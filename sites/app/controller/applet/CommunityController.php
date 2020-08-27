<?php


class App_Controller_Applet_CommunityController extends App_Controller_Applet_InitController {

    public function __construct() {
        parent::__construct(true);
    }

    
    public function _check_lottery_now(){
        $where   = array();
        $where[] = array('name' => 'amll_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'amll_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amll_deleted', 'oper' => '=', 'value' => 0);
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $row        = $list_model->getRow($where);
        return $row && $row['amll_index_status']==1?1:0;
    }

    private function _check_apply($uid){
        $info = array();
        //判断是否已经入驻 0、未入住 1、入驻过待审核 2、入住过并审核通过 3、入住过但未审核通过
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $apply = $es_model->findShopByUser($this->sid,$uid,false);
            if($apply){
                if ($apply['es_handle_status'] == 3) {
                            $info['status'] = 3;
                            $info['msg'] = '您已申请入驻但未通过审核' . ($apply['es_handle_remark'] ? '，未通过原因为'.$apply['es_handle_remark'] : '') . '，请重新编辑';
                }elseif($apply['es_handle_status'] == 1) {
                    $info['status'] = 1;
                    $info['msg'] = '您已申请入驻正在等待审核';
                }else{ //入驻申请通过
                    $info['status'] = 2;
                    $info['msg'] = '您已入驻过并且已经审核通过';
                }
            }else{
                $info['status']=0;
                $info['msg']='您还未入驻';
            }
            return $info;
    }

    private function _check_apply_old($uid){
        $info = array();
        //判断是否已经入驻 0、未入住 1、入驻过待审核 2、入住过并审核通过 3、入住过但未审核通过
        $apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->sid);
        $apply = $apply_model->findRowByMidNoDelete($uid,false);
        if($apply){
            if ($apply['acsa_status'] == 3) {
                $info['status'] = 3;
                $info['msg'] = '您已申请入驻但未通过审核' . ($apply['acsa_deal_note'] ? '，未通过原因为'.$apply['acsa_deal_note'] : '') . '，请重新编辑';
            }elseif($apply['acsa_status'] == 1) {
                $info['status'] = 1;
                $info['msg'] = '您已申请入驻正在等待审核';

            }else{ //入驻申请通过
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                $row = $es_model->findShopByUser($this->sid,$uid,FALSE);
                if($row){
                    $info['status'] = 2;
                    $info['msg'] = '您已入驻过并且已经审核通过';
                }else{
                    $info['status'] = 0;
                    $info['msg'] = '您入驻的店铺已被管理员删除，请重新入驻或联系管理员';
                }
//                    // 判断审核通过的店铺是否被删除
//                    if (!$row['es_deleted']) {
//                        $info['status'] = 2;
//                        $info['msg'] = '您已入驻过并且已经审核通过';
//                    }
//                    else {
//                        $info['status'] = 3;
//                        $info['msg'] = '您入驻的店铺已被管理员删除，请联系管理员';
//                    }
            }
        }else{
            $info['status']=0;
            $info['msg']='您还未入驻';
        }
        return $info;
    }

    
    private function _statistics($type, $num){
        //获取配置信息
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $cfg        = $applet_cfg->findShopCfg();
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
        $tpl = $tpl_model->findUpdateBySid($cfg['ac_index_tpl']);
        if($type == 'browse'){
            $set = array('aci_browse_num' => ($tpl['aci_browse_num'] + $num));
            $tpl_model->findUpdateBySid($cfg['ac_index_tpl'], $set);
        }
        if($type == 'issue'){
            $set = array('aci_issue_num' => ($tpl['aci_issue_num'] + $num));
            $tpl_model->findUpdateBySid($cfg['ac_index_tpl'], $set);
        }
        if($type == 'shop'){
            $set = array('aci_shop_num' => ($tpl['aci_shop_num'] + $num));
            $tpl_model->findUpdateBySid($cfg['ac_index_tpl'], $set);
        }
        if($type == 'share'){
            $set = array('aci_share_num' => ($tpl['aci_share_num'] + $num));
            $tpl_model->findUpdateBySid($cfg['ac_index_tpl'], $set);
        }
    }

    
    private function _get_coupont_list($uid){
        if($uid){
            $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->fetchShowValidList($this->sid,0,0);
            // 获取已经领取的优惠券
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $myCoupon = $receive_model->fetchCouponList($this->sid,$uid);
            $list   = array();
            foreach ($coupon as $key => $value) {
                if(isset($myCoupon[$value['cl_id']])){
                    unset($coupon[$key]);
                }else{
                    //若优惠券还未领完 赠送一张
                    if($value['cl_had_receive'] < $value['cl_count']) {
                        $indata = [
                            'cr_s_id' => $this->sid,
                            'cr_m_id' => $uid,
                            'cr_c_id' => $value['cl_id'],
                            'cr_receive_time' => time(),
                            'cr_expire_time'  => $value['cl_use_time_type'] == 1?$value['cl_use_end_time']:strtotime("+".$value['cl_use_days']." days"),
                        ];
                        $receive_model->insertValue($indata);
                        //设置领取量+1
                        $coupon_model->incrementReceiveCount($value['cl_id'], 1);
                        $list[] = [
                            'id' => $value['cl_id'],
                            'name' => $value['cl_name'],
                            'value' => $value['cl_face_val'],
                            'limit' => $value['cl_use_limit'],
                            'count' => $value['cl_count'],
                            'receive' => $value['cl_had_receive'],
                            'desc' => $value['cl_use_desc'],
                            'start' => date('Y-m-d', $value['cl_start_time']),
                            'end' => date('Y-m-d', $value['cl_end_time']),
                        ];
                    }
                }
            }
            return $list;
        }else{
            $this->outputError('获取用户信息失败');
        }

    }

    private function _get_store_list($type,$index, $count){
        $lng    = $this->request->getStrParam('lng');
        $lat    = $this->request->getStrParam('lat');
        $cate1  = $this->request->getIntParam('cate1');
        $cate2  = $this->request->getIntParam('cate2');
        $district1 = $this->request->getIntParam('district1');
        $district2 = $this->request->getIntParam('district2');
        $name      = $this->request->getStrParam('name');
        $cityId    = $this->request->getIntParam('cityId');
        $town      = $this->request->getIntParam('town');
        $sorucetype = $this->request->getStrParam('sorucetype');

        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'es_expire_time', 'oper' => '>', 'value' => time());
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
        $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0); //状态正常
        $where[] = array('name' => 'es_handle_status', 'oper' => '=', 'value' => 2); //审核通过
        $where[] = array('name' => 'es_list_show', 'oper' => '=', 'value' => 1); //显示店铺
        if($this->applet_cfg['ac_type'] == 33){
            $where[] = array('name' => 'es_name', 'oper' => '!=', 'value' => '');
        }
        if($sorucetype == 'recommend'){
            $where[] = array('name' => 'es_is_recommend', 'oper' => '=', 'value' => 1);
        }

        if($cate1){
            $where[] = array('name' => 'es_cate1', 'oper' => '=', 'value' => $cate1);
        }
        if($cate2){
            $where[] = array('name' => 'es_cate2', 'oper' => '=', 'value' => $cate2);
        }
        if($town){
            //二手车 城市信息
            $where[] = array('name' => 'es_city', 'oper' => '=', 'value' => $town);
        }
        if($district1){
            $where[] = array('name' => 'es_district1', 'oper' => '=', 'value' => $district1);
        }
        if($district2){
            $where[] = array('name' => 'es_district2', 'oper' => '=', 'value' => $district2);
        }
        if($cityId){
            $where[] = array('name' => 'acd_city_id', 'oper' => '=', 'value' => $cityId);
        }
        if($name){
            $where[] = array('name' => 'es_name', 'oper' => 'like', 'value' => "%{$name}%");
            //保存搜索记录
            $this->_save_search_history($name);
        }
        if($this->applet_cfg['ac_type'] == 33){
            $sort = array('es_hand_close'=>'ASC','es_sort' => 'desc','es_follow_num' => 'desc','es_show_num' => 'desc','distance' => 'asc', 'es_createtime' => 'desc');
        }else{
            $sort = array('es_hand_close'=>'ASC','es_sort' => 'desc','distance' => 'asc', 'es_createtime' => 'desc');
        }

        if($type == 'hot'){
            $sort = array('es_hand_close'=>'ASC','es_show_num' => 'desc','es_follow_num' => 'desc', 'es_createtime' => 'desc');
        }
        if($type == 'nearby'){
            $sort = array('es_hand_close'=>'ASC','distance' => 'asc', 'es_createtime' => 'desc');
        }
        if($type == 'score'){
            $sort = array('es_hand_close'=>'ASC','es_score' => 'desc', 'es_createtime' => 'desc');
        }
        if($type == 'new'){
            $sort = array('es_hand_close'=>'ASC', 'es_createtime' => 'desc','es_follow_num' => 'desc','es_show_num' => 'desc','distance' => 'asc');
        }

        $list = $shop_model->getListByDistanceNew($where, $index, $count, $sort,$lng,$lat);
        $data = array();
        $close_data = [];
        $open_data = [];
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        foreach($list as $val){
            $tradeNum = 0;
            if($this->applet_cfg['ac_type'] == 33){
                $where_trade[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
                $where_trade[] = array('name' => 't_es_id', 'oper' => '=', 'value' => $val['es_id']);
                $where_trade[] = array('name' => 't_status', 'oper' => '=', 'value' => 6);

                $tradeNum = $trade_model->getCount($where_trade);
            }
            if($val['es_common_business_time'] || $val['es_week'.date('w').'_business_time']){
                $openInfo = $this->_check_shop_status($val);
            }else{
                $openInfo = $this->_check_shop_open($val);
            }


            $data[] = array(
                'id'       => $val['es_id'],
                'cover'    => $val['es_logo']?$this->dealImagePath($val['es_logo']):$this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                'name'     => $val['es_name'],
                'hot'      => $val['es_follow_num'],
                'showNum'  => $val['es_show_num'],
                'label'    => $val['es_label'],
                'labelType'=> $val['es_label_type'],
                'address'  => $val['es_addr'] ? ($val['es_addr'].($val['es_addr_detail'] ? $val['es_addr_detail'] : '')) : '',
                'cate1'    => $val['es_cate1'],
                'category' => $val['es_cate2_name'],
                'lng'      => $val['es_lng'],
                'lat'      => $val['es_lat'],
                'handClose' => $val['es_hand_close'],
                'distance' => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'m' : round($val['distance'],2).'km' ): 0,
                'openStatus'   => $openInfo['openStatus'],
                'openNote'     => $openInfo['openNote'],
                'tradeNum'     => intval($tradeNum)
            );
        }
        return $data;
    }

    private function _check_shop_status($shop){
        $openStatus  = 2;
        $openNote = '已打烊';
        $timeNow = time();
        $openTimeStr = '';
        if($shop['es_hand_close'] == 0){
            if($shop['es_week'.date('w').'_business_time']){
                $timeArr = json_decode($shop['es_week'.date('w').'_business_time'], true);
                foreach ($timeArr as $time){
                    $openTime = strtotime($time['open']);
                    $closeTime = strtotime($time['close']);
                    if($closeTime <= $openTime){
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        $timeStep_24 = $timeStep_0 + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }
                    $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                }
            }else{
                $timeArr = json_decode($shop['es_common_business_time'], true);
                foreach ($timeArr as $time){
                    $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                    $openTime = strtotime($time['open']);
                    $closeTime = strtotime($time['close']);
                    if($closeTime <= $openTime){
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        $timeStep_24 = $timeStep_0 + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $openStatus  = 1;
                            $openNote = '营业中';
                        }
                    }
                }
            }
        }

        return array('openStatus' => $openStatus, 'openNote' => $openNote, 'openTime' => $openTimeStr);
    }


    
    private function _check_shop_open($shop){
        $data = [];
        if($shop['es_hand_close'] == 0){
            $timeNow = time();
            $isOpen = 0;
            $shopOpen = $shop['es_business_time'] ?  $shop['es_business_time'] : '00:00';
            $shopClose = $shop['es_close_time'] ? $shop['es_close_time'] : '23:59';
            $openTime = strtotime($shopOpen);
            $closeTime = strtotime($shopClose);
            if ($openTime >= $closeTime) {
                //$closeTime = $closeTime + 86400;
                //获得当天0点时间戳
                $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                //获得当天24点时间戳
                $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                    $isOpen = 1;
                }
            }else{
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $isOpen = 1;
                }
            }
            //if (($openTime > time() || $closeTime < time())) {
            if (!$isOpen) {
                $data['openStatus']  = 2;
                $data['openNote'] = '已打烊';
            }else{
                $data['openStatus']  = 1;
                $data['openNote'] = '营业中';
            }
        }else{
            $data['openStatus']  = 2;
            $data['openNote'] = '已打烊';
        }
        return $data;
    }

    private function _get_open_status($shop){
        if($shop['es_hand_close'] == 1){
            return '已打烊';
        }else{
            if($shop['openStatus'] == 1){
                return '营业中';
            }else{
                return '已打烊';
            }
        }
    }

    
    private function _save_search_history($search){
        $history_model = new App_Model_Community_MysqlCommunitySearchHistoryStorage($this->sid);
        $where[] = array('name' => 'acsh_s_id', 'oper' => '=', 'value' =>$this->sid);
        $where[] = array('name' => 'acsh_content', 'oper' => '=', 'value' => $search);
        $row = $history_model->getRow($where);
        if($row){
            $data = array('acsh_times' => $row['acsh_times'] + 1);
            $history_model->updateById($data, $row['acsh_id']);
        }else{
            $data = array(
                'acsh_s_id' => $this->sid,
                'acsh_content' => $search,
                'acsh_times' => 1,
                'acsh_type'  => 1,
                'acsh_update_time' => time()
            );
            $history_model->insertValue($data);
        }
    }

    
    public function hotSearchAction(){
        $type = $this->request->getIntParam('type');
        $history_model = new App_Model_Community_MysqlCommunitySearchHistoryStorage($this->sid);
        $where[] = array('name' => 'acsh_s_id', 'oper' => '=', 'value' =>$this->sid);
        if($type && $this->applet_cfg['ac_type'] != 6){
            $where[] = array('name' => 'acsh_type', 'oper' => '=', 'value' =>$type);
        }
        $sort = array('acsh_times' => 'desc', 'acsh_update_time' => 'desc');
        $list = $history_model->getList($where, 0, 10, $sort);
        if($list){
            $info['data'] = array();
            foreach($list as $val){
                $info['data'][] = $val['acsh_content'];
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂无热门搜索');
        }
    }

    
    private function _shop_index_shortcut($tpl_id){
        $data = array();
        //获取快捷按钮
        $shortcut_storage   = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
        $shortcut   = $shortcut_storage->fetchShortcutShowList($tpl_id);
        if($shortcut){
            foreach ($shortcut as $val){
                $data[] = array(
                    'name' => $val['ss_name'],
                    'icon' => isset($val['ss_icon']) ? $this->dealImagePath($val['ss_icon']) : '',
                    'link' => isset($val['ss_link']) ? $val['ss_link'] : '',
                    'type' => $val['ss_link_type'],
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
        }
        return $data;
    }

    
    private function _shop_index_slide($tpl_id, $type){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($this->sid);
        $slide      = $slide_storage->fetchSlideShowList($tpl_id, $type);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'], # /pages/index/index?id=8
                    'type' => $val['ss_link_type'],
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_article_title']),
                );
            }
        }
        return $data;
    }

    
    private function _shop_index_tpl($tpl_id){
        $data = array();
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
        $tpl = $tpl_model->findUpdateBySid($tpl_id);
        if($tpl){
            $data = array(
                'temp'          => $tpl_id,
                'title'         => $tpl['aci_title'],
                'searchTip'    => $tpl['aci_search_tip'],
                'browseNum'     => $this->number_format($tpl['aci_browse_num']),
                'issueNum'      => $this->number_format($tpl['aci_issue_num']),
                'shopNum'       => $this->number_format($tpl['aci_shop_num']),
                'statIcon'      => $tpl['aci_stat_icon'] ? $this->dealImagePath($tpl['aci_stat_icon']) : $this->dealImagePath('/public/wxapp/customtpl/images/icon_tj.png'),
                'memberNum'     => $this->_get_member_count($tpl['aci_add_member']),
            );
        }else{
            $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
            $where = array();
            $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->sid);
            $template = $template_model->getRow($where);
            $data = array(
                'temp'         => $tpl_id,
                'title'        => $template['act_header_title'],
            );
        }
        return $data;
    }

    
    private function _get_member_count($num){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $count = $member_model->getMemberCount($this->sid);
        $count += $num;
        $count = $this->number_format($count);
        return $count;
    }

    
    private function _index_notice_list(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'title'    => $val['atn_title'],
//                    'link'     => $val['atn_article_id'],
                    //前端说用的是链接 所以也改成链接
                    'link'     => $this->get_link_by_type(1,$val['atn_article_id'],''),
                    'url'      => $this->get_link_by_type(1,$val['atn_article_id'],'')
                );
            }
        }
        return $data;
    }

    //店铺列表
    public function shopListAction(){
        $type   = $this->request->getStrParam('type');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $list = $this->_get_store_list($type, $index, $this->count);
        if($list){
            $info['data'] = $list;

            //判断是否已经入驻
            $uid = plum_app_user_islogin();
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $userShop = $es_model->findShopByUser($this->sid,$uid,false);
            if($userShop){
                $info['shopInfo']['myShop'] = 'yes';
                $info['shopInfo']['shopStatus']=$userShop['es_handle_status'];
            }else{
                $info['shopInfo']['myShop']='no';
                $info['shopInfo']['shopStatus']=0;
            }

            $this->outputSuccess($info);
        }else{
            $this->displayJsonError('数据加载完毕');
        }
    }

    
    public function goodsListAction(){
        $sid  = $this->request->getIntParam('sid');
        $category = $this->request->getIntParam('flid');
        $type = $this->request->getStrParam('type');
        $page = $this->request->getIntParam('page');
        $keyword = $this->request->getStrParam('keyword');
        $sortType = $this->request->getStrParam('sortType', 'normal'); // -排序
        $sourcetype = $this->request->getStrParam('sourcetype');//自定义首页推荐组件 recommendEs 推荐商家商品
        $index = $this->count * $page;
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $where = array();
        if($keyword){
            $keyword = $this->utf8_str_to_unicode($keyword);
            $where[] = array('name' => 'g_name', 'oper' => 'like', 'value' => "%$keyword%");
            $this->dyCheckText($keyword);
        }
        if($sourcetype == 'recommendEs'){
            $type = 'shop';
        }

//        if($this->request->getIntParam('test1')) {
//            plum_msg_dump($this->appletType, 0);
//            $category_list  = $this->_get_cate_list($sid); //商品分类
//
//            if(count($category_list) <3) {
//                $category = 0;
//            }
//            plum_msg_dump($category, 1);
//        }
        // 抖音
        if($this->appletType ==4) {
            $category_list  = $this->_get_cate_list($sid); //商品分类
            if(count($category_list) <3) {
                // 商品分类小于3时，默认为全部
                $category = 0;
            }
        }



        $second_cate = 0;
//        if(!$sid && $this->applet_cfg['ac_type'] == 6){//同城自营商品分类列表
//            $kind_model = new App_Model_Shop_MysqlKindStorage($this->sid);
//            $kind = $kind_model->getRowById($category);
//            if(isset($kind['sk_level']) && $kind['sk_level'] == 2){
//                $second_cate = $category;
//                $category = 0;
//            }
//        }
        if($type == 'special'){
            $where[]    = array('name' => 'g_had_vip_price', 'oper' => '=', 'value' => 1);
            if($this->applet_cfg['ac_type'] != 6){
                $where[]    = array('name' => 'g_es_id', 'oper' => '!=', 'value' => 0);
            }
            $goods    = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, '',  0, array(),array(),$category,0,1,$where,0);
        }elseif($type == 'shop'){
            $where[]    = array('name' => 'g_es_id', 'oper' => '!=', 'value' => 0);
            $sort = array('g_weight'=>'desc','g_update_time'=>'desc');
            $goods    = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, '',  1, $sort,array(),$category,0,1,$where,0);
        }elseif ($type == 'all'){
            $sort = array('g_weight'=>'desc','g_update_time'=>'desc');
            $goods    = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, '',  0, $sort,array(),$category,$second_cate,1,$where,0);
        }else{
            // -抖音小程序 2019-11-07 排序
            switch($sortType) {
                case 'solds' :
                    $sort = array('g_sold'=>'desc','g_weight'=>'desc','g_update_time'=>'desc');
                    break;
                case 'timeNew' :
                    $sort = array('g_create_time'=>'desc','g_weight'=>'desc','g_update_time'=>'desc');
                    break;
                case 'priceUp' :
                    $sort = array('g_price'=>'desc','g_weight'=>'desc','g_update_time'=>'desc');
                    break;
                case 'priceLow' :
                    $sort = array('g_price'=>'asc','g_weight'=>'desc','g_update_time'=>'desc');
                    break;
                case 'normal' :
                default :
                $sort = array('g_weight'=>'desc','g_update_time'=>'desc');
            }

//            $sort = array('g_weight'=>'desc','g_update_time'=>'desc');
            $where[]    = array('name' => 'g_es_id', 'oper' => '=', 'value' => $sid);
            $goods    = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, '',  0, $sort,array(),$category,$second_cate,1,$where,0);
        }
        

        $uid = plum_app_user_islogin();
        if($goods){
            $info['data'] = array();
            $model_gc = new App_Model_Goods_MysqlCommentStorage($this->sid); //商品评价
            foreach($goods as $key => $val){
                $info['data'][$key] = array(
                    'id'         => $val['g_id'],
                    'esId'       => $val['g_es_id'],
                    'esid'       => $val['g_es_id'],
                    'name'       => $val['g_name'],
                    'cover'      => $this->dealImagePath($val['g_cover']),
                    'price'      => floatval($val['g_price']),
                    'vipPrice'   => floatval($val['g_vip_price']),
                    'oriPrice'   => floatval($val['g_ori_price']),
                    'sold'       => $val['g_sold'],
                    'stock'      => $val['g_stock']<0?0:$val['g_stock'],
                    'stockShow'  => $val['g_stock_show'],
                    'listLabel'  => $val['g_list_label'] ? $val['g_list_label'] : '',
                    'soldShow'   => $val['g_sold_show'],
                    'freight'    => $val['g_unified_fee'],
                    'isDiscuss'  => intval($val['g_is_discuss']),
                    'discussInfo'=> isset($val['g_discuss_info']) ? $val['g_discuss_info'] : '',
                    'showVipList'=> $val['g_show_vip'],
                );
                if($this->appletType == 4 && $this->sid == '12228'){
                    //抖音的处理
                    $info['data'][$key]['price'] = $val['g_is_discuss']>0?'面议':floatval($val['g_price']);
                }
                if($this->applet_cfg['ac_type'] == 6){
                    $info['data'][$key]['vipPrice'] = 0;
                    $trade_helper = new App_Helper_Trade($this->sid);
                    $price = $trade_helper::getGoodsVipPirce($val['g_price'],$this->sid,$val['g_id'],0,$uid);
                    $info['data'][$key]['price'] = $price;
                    $info['data'][$key]['vipPrice'] = $this->_get_vip_price($val);


                }
                if($this->applet_cfg['ac_type'] == 8 || $this->applet_cfg['ac_type'] == 33){
                    $info['data'][$key]['vipPrice'] = $this->_get_vip_price($val);
                }

                // -商品评价数 抖音小程序
                $where_gc = array();
                $where_gc[] = ['name'=>'gc_s_id', 'oper'=>'=', 'value'=>$this->sid];
                $where_gc[] = ['name'=>'gc_g_id', 'oper'=>'=', 'value'=>$val['g_id']];
                $where_gc[] = ['name'=>'gc_deleted', 'oper'=>'=', 'value'=>0];
                $info['data'][$key]['commentNum'] = $model_gc->getCount($where_gc);
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }



    //获取vip价的价格区间
    private function _get_vip_price($goods){
        if(!$goods['g_had_vip_price']){
            return 0;
        }else{
            $vipPrice = json_decode($goods['g_vip_price_list'], true);
            $priceArr = array();
            if(!empty($vipPrice)){
                foreach ($vipPrice as $val){
                    $priceArr[] = $val['price'];
                }
            }else{
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
                $format         = $format_model->getListByGid($goods['g_id']);
                foreach ($format as $row){
                    $vipPriceList = json_decode($row['gf_vip_price_list'], true);
                    foreach ($vipPriceList as $val){
                        $priceArr[] = $val['price'];
                    }
                }
            }
            $minPrice = min($priceArr);
            $maxPrice = max($priceArr);
            //return $minPrice;
            if($minPrice && $maxPrice && $minPrice != $maxPrice){
                return $minPrice.'-'.$maxPrice;
            }else{
                return $minPrice ? $minPrice : 0;
            }

        }
    }

    
    private function show_trade_goods_detail_data($tid){
        //获取交易订单商品
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order = $order_model->fetchOrderListByTid($tid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goods = $goods_model->getRowById($order[0]['to_g_id']);
        $data = array();
        if ($order) {
            $data = array(
                'toid'  => $order[0]['to_id'],
                'gid'   => $order[0]['to_g_id'],
                'title' => $order[0]['to_title'],
                'spec'  => isset($order[0]['to_gf_name']) ? $order[0]['to_gf_name'] : '',
                'img'   => isset($order[0]['to_pic']) ? plum_deal_image_url($order[0]['to_pic']) : '',
                'price' => $order[0]['to_price'],
                'num' => $order[0]['to_num'],
                'total' => $order[0]['to_total'],
                'type'  =>$order[0]['to_type'],
                'vipPrice' => $goods?floatval($goods['g_vip_price']):floatval($order[0]['to_price']),
                'sold'  =>  $goods?$goods['g_sold']:123,
                'oriPrice' =>  $goods?floatval($goods['g_ori_price']):floatval($order[0]['to_price']),
            );
        }
        return $data;
    }

    
    private function _get_mall_coupont_list($uid){
        if($uid){
            $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->fetchShowValidList($this->sid,0,0);
            // 获取已经领取的优惠券
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $myCoupon = $receive_model->fetchCouponList($this->sid,$uid);
            $list   = array();
            foreach ($coupon as $key => $value) {
                if(isset($myCoupon[$value['cl_id']])){
                    unset($coupon[$key]);
                }else {
                    if ($value['cl_had_receive'] < $value['cl_count']) {
                        
                        $list[] = array(
                            'id' => $value['cl_id'],
                            'name' => $value['cl_name'],
                            'value' => $value['cl_face_val'],
                            'limit' => $value['cl_use_limit'],
                            'count' => $value['cl_count'],
                            'receive' => $value['cl_had_receive'],
                            'desc' => $value['cl_use_desc'],
                            'start' => date('Y-m-d', $value['cl_start_time']),
                            'end' => date('Y-m-d', $value['cl_end_time']),
                        );
                    }
                }
            }
            return $list;
        }else{
            $this->outputError('获取用户信息失败');
        }
    }

    
    private function _mall_index_tpl(){
        $data = array();
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid(0);
        if($tpl){
            $data = array(
                'title'          => $tpl['amu_title'],
                'couponTitle'    => isset($tpl['amu_coupon_title'])?$tpl['amu_coupon_title']:'',
                'couponSign'     => isset($tpl['amu_coupon_sign'])?$tpl['amu_coupon_sign']:'',
                'proTitle'       => isset($tpl['amu_promotion_title'])?$tpl['amu_promotion_title']:'',
                'proSign'        => isset($tpl['amu_promotion_sign'])?$tpl['amu_promotion_sign']:'',
                'hotImg'         => $this->dealImagePath($tpl['amu_hot_img']),
                'hotLink'        => $tpl['amu_hot_link'],
                'hotUrl'         => $this->get_link_by_type($tpl['amu_hot_type'],$tpl['amu_hot_link'],''),
            );
        }
        return $data;
    }

    
    private function _shop_kind_list(){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowListGroup(0);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'name'  => $val['amk_name'],
                    'sign'  => $val['amk_sign'],
                    'type'  => $val['amk_goods_list'],
                    'link'  => $val['amk_link'],
                    'entershop' => intval($val['gg_is_eshop']),
                    'img'   => isset($val['amk_img']) ? $this->dealImagePath($val['amk_img']) : '',
                    'goods' => $this->_goods_list_by_kind($val['amk_link']),
                );
            }
        }
        return $data;
    }

    
    private function _goods_list_by_kind($kind){
        $match_storage = new App_Model_Goods_MysqlGroupMatchStorage($this->sid);
        $goods_list = $match_storage->fetchGoodsList($kind,0,6);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_goods_details($val);
            }
        }
        return $data;
    }

    
    private function _format_goods_details($goods,$detail=false){
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'sid'        => $goods['g_s_id'],
                'esid'       => $goods['g_es_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'vipPrice'   => floatval($goods['g_vip_price']),
                'points'     => $goods['g_points'],
                'unit'       => $goods['g_unit'],
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'expfeeShow' => intval($goods['g_expfee_show']),
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'isVip'      => $this->member['m_level_long']>time()?1:0,
                'video'      => $goods['g_video_url'] ? $goods['g_video_url']:'',
                'isDiscuss'  => intval($goods['g_is_discuss']),
                'listLabel'  => $goods['g_list_label'] ? $goods['g_list_label'] : '',
                'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
            );
            if($goods['g_type'] == 4){
                $data['type'] = 1;
            }
            if($goods['g_type'] == 5){
                $data['type'] = 2;
            }
            if($goods['g_es_id']){
                $shop =  $this->_get_shop_info($goods['g_es_id']);
                $data['shop'] = $shop;
            }
            // 是否获取商品详情
            if($detail){
                $data['freight'] = $this->_get_postFee_show($goods);
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['detail'] = plum_parse_img_path($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);
                $data['format'] = $this->_goods_format($goods['g_id']);
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }

            }

            $data['isCollect'] = $this->_is_collection($goods['g_id'], 2);
            return $data;
        }
        return false;
    }

    private function _get_postFee_show($goods){
        $postFee = 0;
        //获得配送配置
        $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
        $sendCfg = $send_model->findUpdateBySid(null,$goods['g_es_id']);

        if($sendCfg['acs_express_delivery'] == 0 && $sendCfg['acs_send'] == 1){
            //如果开启了商家配送且未开启快递发货 以商家配送费为准
            //基础配送费
//            $basePrice = floatval($sendCfg['acs_base_price']);
//            //计算最大配送费
//            $sendRange = floatval($sendCfg['acs_send_range']);
//            $baseLong = floatval($sendCfg['acs_base_long']);
//            $plusLong = floatval($sendCfg['acs_plus_long']);
//            $plusPrice = floatval($sendCfg['acs_plus_price']);
//            $plusDistance = $sendRange - $baseLong;
//            $num = ceil($plusDistance/$plusLong);
//            $maxFee = $basePrice + $num * $plusPrice;
//            $postFee = number_format($basePrice,2).'-'.number_format($maxFee,2);
            $postFee = $sendCfg['acs_base_price'];
        }else{
            //以商品本身运费为准
            if($goods['g_expfee_type'] == 1){
                //统一运费
                $postFee = $goods['g_unified_fee'];
            }else{
                //运费模板 取模板中的第一条的首件费用
                $city_model = new App_Model_Shop_MysqlShopDeliveryCityStorage($this->sid);
                $where[] = array('name' => 'sdc_temp_id', 'oper' => '=', 'value' =>$goods['g_unified_tpid']);
                $where[] = array('name' => 'sdc_deleted', 'oper' => '=', 'value' =>0);
                $row = $city_model->getRow($where);
                if($row){
                    $postFee = $row['sdc_first_fee'];
                }
            }
        }
        return $postFee;
    }

    //格式化店铺信息
    private function _get_shop_info($id){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getRowById($id);
        $score_desc = plum_parse_config('community_score_desc', 'system');
        return array(
            'name' => $shop['es_name'],
            'address' => $shop['es_addr'],
            'lng' => $shop['es_lng'],
            'lat' => $shop['es_lat'],
            'mobile' => $shop['es_phone'],
            'score'  => $shop['es_score'],
            'scoreDesc' => $score_desc[intval($shop['es_score'])],
            'isCollection' => $this->_is_collection($shop['es_id'], 1)
        );
    }

    
    public function _is_collection($id, $type){
        $num = 0;
        $collection_model = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid);
        $row = $collection_model->getCollectionByMidPid($this->uid,$id, $type);
        if($row){
            $num = 1;
        }
        return $num;
    }

    
    private function _goods_slide($gid){
        //获取商品幻灯
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $slide       = $slide_model->getListByGidSid($gid, $this->sid);
        $data = array();
        if($slide){
            foreach ($slide as $val){
                $data[] = $this->dealImagePath($val['gs_path']);
            }
        }
        return $data;
    }

    
    private function _goods_format($gid){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = array();
        if($format){
            foreach ($format as $val){
                $data[] = array(
                    'id'    => $val['gf_id'],
                    'name'  => $val['gf_name'],
                    'price' => $val['gf_price'],
                    'sold'  => $val['gf_sold'],
                    'stock' => $val['gf_stock'],
                    'point' => $val['gf_send_point'],
                );
            }
        }
        return $data;
    }


    
    private function _recommend_goods_list(){
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->sid);
        $recommend_list = $recommend_model->fetchRecommendShowListGoods(0);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $goods = $goods_model->getRowById($val['amr_link']);
                $isDiscuss = intval($goods['g_is_discuss']);

                $data[] = array(
                    'sid'   => $val['amr_s_id'],
                    'esid'  => $val['g_es_id'],
                    'name'  => $val['amr_name'],
                    'price' => $val['amr_price'],
                    'img'   => $this->dealImagePath($val['amr_img']),
                    'link'  => $val['amr_link'],
                    'listLabel'  => $val['g_list_label'] ? $val['g_list_label'] : '',
                    'isDiscuss'  => $isDiscuss,
                    'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
                );
            }

        }
        return $data;
    }

    
    private function _deal_recommend_goods_list($sourcetype){
        $page     = $this->request->getIntParam('page');
        $keyWord  = $this->request->getStrParam('keyWord');
        $index    = $page*$this->count;
        $data['data']['category']= [];
        $where = [];
        $goods = [];
        if($sourcetype == 'recommendEs'){
            $where[] = array('name'=>'g_es_id','oper'=>'>','value'=>0);
        }else{
            $where[] = array('name'=>'g_es_id','oper'=>'=','value'=>0);
        }
        $sort = ['g_weight'=>'DESC','g_update_time'=>'DESC'];
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goodsList = $goods_model->fetchShopGoodsList($this->sid,$index,$this->count,$keyWord,1,$sort,[],0,0,1,$where);
        $uid = plum_app_user_islogin();
        if($goodsList){
            foreach ($goodsList as $k => $v){
                $goods[$k] = array(
                    'id'         => $v['g_id'],
                    'esId'       => $v['g_es_id'],
                    'name'       => $v['g_name'],
                    'cover'      => isset($v['g_cover']) ? $this->dealImagePath($v['g_cover']) : '',
                    'price'      => floatval($v['g_price']),
                    'oriPrice'   => floatval($v['g_ori_price']),
                    'brief'      => isset($v['g_brief']) ? $v['g_brief'] : '',
                    'sold'  => $v['g_sold'],
                    'isDiscuss'  => intval($v['g_is_discuss']),
                    'listLabel'  => $v['g_list_label'] ? $v['g_list_label'] : '',
                    'discussInfo'=> isset($v['g_discuss_info']) ? $v['g_discuss_info'] : '',
                );

                if($this->applet_cfg['ac_type'] == 6){
                    $trade_helper = new App_Helper_Trade($this->sid);
                    $price = $trade_helper::getGoodsVipPirce($v['g_price'],$this->sid,$v['g_id'],0,$uid);
                    $goods[$k]['price'] = $price;
                }
            }
            $data['data']['goods']=$goods;
            $this->outputSuccess($data);

        }else{
            $this->outputError('没有更多信息了');
        }

    }

    private function _deal_group_goods_list(){
        $type     =  $this->request->getIntParam('type');
        $page     = $this->request->getIntParam('page');
        $keyWord  = $this->request->getStrParam('keyWord');
        $from     = $this->request->getStrParam('from', 'shop'); //平台商品分组还是商家商品分组，默认是商家
        $index    = $page*$this->count;
        $match_storage = new App_Model_Goods_MysqlGroupMatchStorage($this->sid);
        $group_storage = new App_Model_Goods_MysqlGroupStorage($this->sid);
        $data = array();
        $info = array();
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->sid);
        if($from == 'shop'){
            $where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>1);
        }else{
            $where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>0);
        }

        $sort = array('gg_create_time' => 'DESC');
        $list = $group_storage->getList($where,0,0,$sort);
        $type = $type?$type:$list[0]['gg_id'];
        $uid = plum_app_user_islogin();
        if($list){
            foreach ($list as $val){
                $info[] = array(
                    'id'        => $val['gg_id'],
                    'name'      => $val['gg_name'],
                );
            }
            $data['data']['category']=$info;
            if($keyWord){
                $gwhere[]       = array('name'=>'g_name','oper'=>'like','value'=>"%$keyWord%");
            }

            if($this->appletType == 4 && $this->shop['s_entershop_goods_verify'] == 1){
                $gwhere[] = array('name'=>'g_is_sale','oper'=>'not in','value'=>[4,5]);
            }

            $goodsList         = $match_storage->fetchGoodsList($type,$index,$this->count,$gwhere);
            $goods = array();
            if($goodsList){
                foreach ($goodsList as $k => $v){
                    $goods[$k] = array(
                        'id'         => $v['g_id'],
                        'esId'       => $v['g_es_id'],
                        'name'       => $v['g_name'],
                        'cover'      => isset($v['g_cover']) ? $this->dealImagePath($v['g_cover']) : '',
                        'price'      => floatval($v['g_price']),
                        'oriPrice'   => floatval($v['g_ori_price']),
                        'brief'      => isset($v['g_brief']) ? $v['g_brief'] : '',
                        'listLabel'  => $v['g_list_label'] ? $v['g_list_label'] : '',
                        'sold'  => $v['g_sold'],
                        'isDiscuss'  => intval($v['g_is_discuss']),
                        'discussInfo'=> isset($v['g_discuss_info']) ? $v['g_discuss_info'] : '',
                    );

                    if($this->applet_cfg['ac_type'] == 6){
                        $trade_helper = new App_Helper_Trade($this->sid);
                        $price = $trade_helper::getGoodsVipPirce($v['g_price'],$this->sid,$v['g_id'],0,$uid);
                        $goods[$k]['price'] = $price;
                    }
                }

            }
            $data['data']['goods']=$goods;
            $this->outputSuccess($data);
        }else{
            $this->outputError('暂时没有数据哦');
        }
    }

    
    private function groupByInitials(array $data, $targetKey = 'name')
    {
        $data = array_map(function ($item) use ($targetKey) {
            return array_merge($item, [
                'initials' => $this->getInitials($item[$targetKey]),
            ]);
        }, $data);
        $data = $this->sortInitials($data);
        return $data;
    }

    
    private function sortInitials(array $data)
    {
        $sortData = [];
        foreach ($data as $key => $value) {
            $sortData[$value['initials']][] = $value;
        }
        ksort($sortData);
        return $sortData;
    }

    
    private function getInitials($str)
    {
        if (empty($str)) {return '';}
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str{0});
        }

        $s1  = iconv('UTF-8', 'gb2312', $str);
        $s2  = iconv('gb2312', 'UTF-8', $s1);
        $s   = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) {
            return 'A';
        }

        if ($asc >= -20283 && $asc <= -19776) {
            return 'B';
        }

        if ($asc >= -19775 && $asc <= -19219) {
            return 'C';
        }

        if ($asc >= -19218 && $asc <= -18711) {
            return 'D';
        }

        if ($asc >= -18710 && $asc <= -18527) {
            return 'E';
        }

        if ($asc >= -18526 && $asc <= -18240) {
            return 'F';
        }

        if ($asc >= -18239 && $asc <= -17923) {
            return 'G';
        }

        if ($asc >= -17922 && $asc <= -17418) {
            return 'H';
        }

        if ($asc >= -17417 && $asc <= -16475) {
            return 'J';
        }

        if ($asc >= -16474 && $asc <= -16213) {
            return 'K';
        }

        if ($asc >= -16212 && $asc <= -15641) {
            return 'L';
        }

        if ($asc >= -15640 && $asc <= -15166) {
            return 'M';
        }

        if ($asc >= -15165 && $asc <= -14923) {
            return 'N';
        }

        if ($asc >= -14922 && $asc <= -14915) {
            return 'O';
        }

        if ($asc >= -14914 && $asc <= -14631) {
            return 'P';
        }

        if ($asc >= -14630 && $asc <= -14150) {
            return 'Q';
        }

        if ($asc >= -14149 && $asc <= -14091) {
            return 'R';
        }

        if ($asc >= -14090 && $asc <= -13319) {
            return 'S';
        }

        if ($asc >= -13318 && $asc <= -12839) {
            return 'T';
        }

        if ($asc >= -12838 && $asc <= -12557) {
            return 'W';
        }

        if ($asc >= -12556 && $asc <= -11848) {
            return 'X';
        }

        if ($asc >= -11847 && $asc <= -11056) {
            return 'Y';
        }

        if ($asc >= -11055 && $asc <= -10247) {
            return 'Z';
        }
        if($str == '濮阳'){
            return 'P';
        }
        if($str == '亳州'){
            return 'B';
        }
        if($str == '儋州'){
            return 'D';
        }
        if($str == '漯河'){
            return 'L';
        }
        if($str == '泸州'){
            return 'L';
        }
        if($str == '衢州'){
            return 'Q';
        }
        return '';
    }

    
    private function utf8_str_to_unicode($utf8_str) {
        $unicode_str = '';
        for($i=0;$i<mb_strlen($utf8_str);$i++){
            $val = mb_substr($utf8_str,$i,1,'utf-8');
            if(strlen($val) >= 4){
                $unicode = (ord($val[0]) & 0xF) << 18;
                $unicode |= (ord($val[1]) & 0x3F) << 12;
                $unicode |= (ord($val[2]) & 0x3F) << 6;
                $unicode |= (ord($val[3]) & 0x3F);
                $unicode_str.= '';
            }else{
                $unicode_str.=$val;
            }
        }
        $unicode_str = $this->_filter_character($unicode_str);
        return $unicode_str;
    }
    
    private function _filter_character($nickname) {
        $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);
        $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);
        $nickname = preg_replace('/[=]/u', '', $nickname);
        $nickname = str_replace(array('"','\''), '', $nickname);
        $nickname  = addslashes(trim($nickname));
        return $nickname;
    }



    
    private function _get_enter_shop_goods_info($esId){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $where = [];
        $where[] = ['name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'g_es_id', 'oper' => '=', 'value' => $esId];
        $where[] = ['name' => 'g_is_sale', 'oper' => '=', 'value' => 1];
        $where[] = ['name' => 'g_applay_goods_show', 'oper' => '=', 'value' => 1];

        if($this->appletType == 4 && $this->shop['s_entershop_goods_verify'] == 1){
            $where[] = array('name'=>'g_is_sale','oper'=>'not in','value'=>[4,5]);
        }

        $count = $goods_model->getCount($where);
        $sort = ['g_is_top'=>'DESC','g_weight'=>'DESC','g_create_time'=>'DESC'];
        $list = $goods_model->getList($where,0,3,$sort,['g_id','g_name','g_cover','g_price','g_has_format','g_show_vip','g_is_discuss']);
        $goods_data = [];
        if($list){
            foreach ($list as $goods){
                // 选中「原价 会员价 」中价格最低的一个
                if($goods['g_show_vip']){
                    $vip_price=json_decode($goods['g_vip_price_list'],TRUE);
                    if(empty($vip_price))
                        $vip_price=[];
                    else
                        $vip_price=array_column($vip_price,'price');
                }
                $price_list=$vip_price;
                $price_list[]=floatval($goods['g_price']);

                // 若规格存在 查询商品规格中最小的值
                if($goods['g_has_format']){
                    $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
                    // 规格里面售价的最低价
                    $min_format_price=$format_model->getList([
                        ['name'=>'gf_s_id','oper'=>'=','value'=>$this->sid],
                        ['name'=>'gf_g_id','oper'=>'=','value'=>$goods['g_id']]
                    ],0,1,['gf_price'=>'ASC'],['gf_price']);
                    if($min_format_price[0]['gf_price'])
                        $price_list[]=floatval($min_format_price[0]['gf_price']);


                    // 获取规格里面的会员价
                    if($goods['g_show_vip']){
                        $vip_format_price=$format_model->getList([
                            ['name'=>'gf_s_id','oper'=>'=','value'=>$this->sid],
                            ['name'=>'gf_g_id','oper'=>'=','value'=>$goods['g_id']],
                        ],0,0,[],['gf_vip_price_list']);
                        foreach ($vip_format_price as $vip_format_item) {
                            $vip_format_price_item=json_decode($vip_format_item['gf_vip_price_list'],TRUE);
                            if(empty($vip_format_price_item))
                                $vip_f_price=[];
                            else{
                                $vip_f_price=array_column($vip_format_price_item,'price');
                                $price_list= array_merge($price_list,$vip_f_price);
                            }
                        }
                    }

                }
                $price_list=array_filter($price_list);
                $goods_price=min($price_list);

                $goods_data[] = [
                    'id'    => $goods['g_id'],
                    'name'  => $goods['g_name'],
                    'cover' => $goods['g_cover']?$this->dealImagePath($goods['g_cover']):"",
                    'price' => $goods['g_is_discuss'] >0?'面议':$goods_price
                ];



            }
        }

        return [
            'count' => intval($count),
            'goodsList' => $goods_data
        ];
    }

    
    private function _check_enter_shop_activity($shop){
        $limit = 0;
        $bargain = 0;
        $group = 0;
        if($shop['es_limit_open']){
            $limit_model = new App_Model_Limit_MysqlLimitActStorage();
            $limit_count = $limit_model->getRunningActCount($shop['es_id']);
            if($limit_count > 0){
                $limit = 1;
            }
        }

        if($shop['es_bargain_open']){
            $bargain_model = new App_Model_Bargain_MysqlActivityStorage($this->sid);
            $bargain_count = $bargain_model->getRunningActCount($shop['es_id']);
            if($bargain_count > 0){
                $bargain = 1;
            }
        }

        if($shop['es_group_open']){
            $group_model = new App_Model_Group_MysqlBuyStorage($this->sid);
            $group_count = $group_model->getRunningActCount($shop['es_id']);
            if($group_count > 0){
                $group = 1;
            }
        }

        return [
            'limit' => $limit,
            'bargain' => $bargain,
            'group' => $group
        ];
    }


    
    private function _get_cate_list($id){
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage($id);
        $cateList = $category_model->getListBySid();
        $data = array();
        foreach($cateList as $val){
            $data[] = array(
                'id'   => $val['esgc_id'],
                'name' => $val['esgc_name'],
                'cover' => $this->dealImagePath($val['esgc_logo'])
            );
        }
        return $data;
    }


}

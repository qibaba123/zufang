<?php

class App_Controller_Applet_CouponController extends App_Controller_Applet_InitController {

    public function __construct() {
        parent::__construct();
    }

    private function _format_coupon_data($coupon, $receive,$myCoupon=array()){
        $color = plum_parse_config('coupon_color','system');
        $data = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => $coupon['cl_use_limit'],
            'count'     => $coupon['cl_count'],
            'receive'   => $coupon['cl_had_receive'],
            'startLeft' => ($coupon['cl_start_time'] - time())>0?($coupon['cl_start_time'] - time()):0,
            'needShare' => intval($coupon['cl_need_share']),
            'desc'      => $coupon['cl_use_desc'],
            'type'      => $coupon['cl_use_type'],
            'start'     => date('Y-m-d', $coupon['cl_start_time']),
            'end'       => $coupon['cr_expire_time']?date('Y-m-d H:i', $coupon['cr_expire_time']):date('Y-m-d H:i', $coupon['cl_end_time']),  // 这个时间有问题
            'receiveLimit' => intval($coupon['cl_receive_limit']),
            'newLimit'  => intval($coupon['cl_new_limit']),
            'colorType' => (intval($coupon['cl_id']%4))+1,
            'color'     => $color[(intval($coupon['cl_id']%3))+1],
            'received'  => !empty($myCoupon) && isset($myCoupon[$coupon['cl_id']]) && $coupon['cl_receive_limit']==1 ? 1 : 0,
            'used'      => !empty($myCoupon) && isset($myCoupon[$coupon['cl_id']]) && $myCoupon[$coupon['cl_id']]['cr_is_used']==1 ? 1 : 0,
            'uid'       => $this->uid,
            'shopName'  => '商家券：'.($coupon['es_name']?$coupon['es_name']:'')
        );
        if($this->appletType == 4){
            //判断当前优惠券是否可以继续领取
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $count          = $receive_model->getMemberReceiveCount($this->uid, $coupon['cl_id'], $this->sid);
            $day_count      = $receive_model->getMemberReceiveCount($this->member['m_id'], $coupon['cl_id'], $this->sid,0,TRUE);
            if(($count>=$coupon['cl_receive_limit']) || ($day_count &&  $coupon['cl_receive_day_limit']>0  && $day_count >= $coupon['cl_receive_day_limit'])){
                $data['canReceive']   = 2;
            }else{
                $data['canReceive']   = 1;
            }
        }
        if($this->applet_cfg['ac_type'] == 6 && $coupon['acs_id'] > 0){
            $data['shopName'] = $coupon['acs_name'] ? $coupon['acs_name'] : ($coupon['es_name'] ? $coupon['es_name'] : $this->shop['s_name']);
            $data['shopId'] = $coupon['acs_id'] ? intval($coupon['acs_id']) : 0;
            $data['shopLogo'] = $coupon['acs_img'] ? $this->dealImagePath($coupon['acs_img']) : ($coupon['es_logo'] ? $this->dealImagePath($coupon['es_logo']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png')));

        }elseif ($this->applet_cfg['ac_type'] == 8 && $coupon['es_id'] > 0){
            $data['shopName'] = $coupon['es_name'] ? $coupon['es_name'] : $this->shop['s_name'];
            $data['shopId'] = $coupon['es_id'] ? intval($coupon['es_id']) : 0;
            $data['shopLogo'] = $coupon['es_logo'] ? $this->dealImagePath($coupon['es_logo']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png'));
        }

        if($receive){
            $data['used'] = $coupon['cr_is_used'];
        }
        return $data;
    }

    
    public function receiveAction() {
        $cid    = $this->request->getIntParam('cid');
        $shareMid = $this->request->getIntParam('shareMid');
        $bindId = $this->request->getIntParam('bindId');
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon     = $coupon_model->getCoupon($cid, $this->sid);

        if (!$coupon) {
            $this->outputError("优惠券不存在哟!");
        }

        if ($coupon['cl_end_time'] < time()) {
            $this->outputError("优惠券已失效");
        }

        if($coupon['cl_start_time'] > time()){
            $this->outputError("未到领取时间，".date('n月d日H:i', $coupon['cl_start_time'])."开抢");
        }

        if($coupon['cl_new_limit']){
            $where = array();
            $where[]    = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]    = array('name' => 't_status', 'oper' => '>', 'value' => App_Helper_Trade::TRADE_NO_PAY);
            $where[]    = array('name' => 't_status', 'oper' => '<', 'value' => App_Helper_Trade::TRADE_CLOSED);
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $trade = $trade_model->getRowWithDel($where);
            if($trade){
                $this->outputError('仅限新用户领取');
            }
        }

        $status = 200; //未领取过

        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $count  = $receive_model->getMemberReceiveCount($this->uid, $cid, $this->sid);

        //社区团购 团长帖子优惠券相关
        $bind_model = new App_Model_Coupon_MysqlLeaderCouponPostStorage($this->sid);
        $bind_row = [];
        $postId = 0;
        $leaderId = 0;
        if($bindId){
            $bind_row = $bind_model->getRowById($bindId);
            $postId = $bind_row['lcp_p_id'];
            $leaderId = $bind_row['lcp_leader'];
            //检查用户是否领过该帖子的此优惠券了
            $post_count = $receive_model->getMemberReceiveCount($this->uid,$cid,$this->sid,0,false,$postId);
            if(intval($post_count) > 0){
                $this->outputError("您已经领取过优惠券了");
            }
        }

       
        //已领取过,并且有领取限制,并且领取的数量大于等于限制数量
        if ($count > 0 && $coupon['cl_receive_limit'] > 0 && $count >= $coupon['cl_receive_limit']) {
           // $this->outputError("您已经领取过优惠券了,尽快使用吧!");
           // $status = 400;//已领取过
           // $tip_msg    = "您已经领取过优惠券了,尽快使用吧!";
            $this->outputError("您已经领取过优惠券了,尽快使用吧!");
        }else {
            // 增加每人每日领取数量限制判断
            // zhangzc
            // 2019-07-12
            $day_count  = $receive_model->getMemberReceiveCount($this->member['m_id'], $cid, $this->sid,0,TRUE);
            if($day_count && $coupon['cl_receive_day_limit'] > 0 && $day_count >= $coupon['cl_receive_day_limit']){
                $status = 400;//已领取过
                $tip_msg    = "您今天已经领过了,明天再来看看吧!";
            }else{
                //判断发行量
                if ($coupon['cl_had_receive'] >= $coupon['cl_count'] && !$bind_row) {
                    $this->outputError("优惠券已被领完啦!");
                }elseif ($bind_row && $coupon['lcp_receive'] >= $bind_row['lcp_count']){
                    $this->outputError("优惠券已被领完啦!");
                }else {

                    $slogan = plum_parse_config('coupon_slogan', 'app');
                    $rand   = mt_rand(0, count($slogan)-1);
                    $indata = array(
                        'cr_s_id'         => $this->sid,
                        'cr_es_id'        => $coupon['cl_es_id'],
                        'cr_m_id'         => $this->member['m_id'],
                        'cr_c_id'         => $cid,
                        'cr_receive_time' => time(),
                        'cr_expire_time'  => $coupon['cl_use_time_type'] == 1?$coupon['cl_use_end_time']:strtotime("+".$coupon['cl_use_days']." days"),
                        'cr_slogan'       => $slogan[$rand],
                        'cr_share_mid'    => $shareMid,
                        'cr_p_id'         => $postId,
                        'cr_leader'       => $leaderId
                    );

                    if($shareMid){
                        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                        $member = $member_model->getRowById($shareMid);
                        $indata['cr_share_nickname'] = $member['m_nickname'];
                    }

                    $crid       = $receive_model->insertValue($indata);
                    $tip_msg    = "恭喜您,优惠券领取成功!";
                    //设置领取量+1
                    $coupon_model->incrementReceiveCount($cid, 1);

                    if($bind_row){
                        $bind_model->incrementField('lcp_receive',1,$bindId);
                    }

                    //发送领取成功模板消息,图文消息,过期提醒
                   // $coupon_helper  = new App_Helper_Coupon($this->sid);
                   // $coupon_helper->sendCouponTmplmsg($cid, 'dztz', $this->member['m_id']);
                   // $coupon_helper->sendCouponNewsmsg($cid, 'dztz', $this->member['m_id']);
                   // $coupon_redis   = new App_Model_Coupon_RedisCouponStorage($this->sid);
                   // $coupon_redis->setCouponInvalidNotice($crid, $coupon['cl_end_time']);
                }
            } 
        }

        $where = array();
        $where[] = array('name' => 'cr.cr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'cr.cr_c_id', 'oper' => '=', 'value' => $cid);
        $sort    = array('cr.cr_receive_time' => 'DESC');
        $list    = $receive_model->getReceiveList($where, 0, 50, $sort);

        // $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $myCoupon = $receive_model->fetchCouponList($this->sid, $this->member['m_id']);

        $info['data'] = array(
            'msg'         => $tip_msg,
            'status'      => $status,
            'coupon'      => $this->_format_coupon_data($coupon, false, $myCoupon),
            'receiveList' => $this->_format_receive_list($list),
            'received'    => 1,     //领取成功标志已领取
        );
        if($this->appletType == 4){
            //返回是否可以继续领取
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $count          = $receive_model->getMemberReceiveCount($this->uid, $coupon['cl_id'], $this->sid);
            $day_count      = $receive_model->getMemberReceiveCount($this->member['m_id'], $coupon['cl_id'], $this->sid,0,TRUE);
            if(($count>=$coupon['cl_receive_limit']) || ($day_count &&  $coupon['cl_receive_day_limit']>0  && $day_count >= $coupon['cl_receive_day_limit'])){
                $info['data']['canReceive']   = 2;
            }else{
                $info['data']['canReceive']   = 1;
            }

        }
        $this->outputSuccess($info);
    }

    private function _format_receive_list($list){
        $data = array();
        foreach($list as $key=>$val){
            $avatar = $val['m_avatar']?$val['m_avatar']:'/public/wxapp/images/default-avatar.png';
            $data[] = array(
                'avatar'     => $this->dealImagePath($avatar),
                'nickname'   => $val['m_nickname'],
                'reveiveTime' => date('Y-m-d H:i:s', $val['cr_receive_time']),
                'slogan'     => $val['cr_slogan'],
                'endTime'    => date('Y-m-d H:i:s', $val['cl_end_time']),
            );
        }
        return $data;
    }

    
    public function myCouponAction() {
        $status = $this->request->getStrParam('status');
        $type   = $this->request->getIntParam('type'); //0平台 1店铺
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        
        $where[]    = array('name' => 'cr.cr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]    = array('name' => 'cr.cr_s_id', 'oper' => '=', 'value' => $this->sid);
        if($type){
            $where[]    = array('name' => 'cl.cl_es_id', 'oper' => '!=', 'value' => 0);
        }else{
            $where[]    = array('name' => 'cl.cl_es_id', 'oper' => '=', 'value' => 0);
        }
        $where[]    = array('name' => 'cl.cl_deleted', 'oper' => '=', 'value' => 0);
        switch ($status) {
            case '0'://未使用
                $where[]    = array('name' => 'cr.cr_is_used', 'oper' => '=', 'value' => 0);
                //if($this->applet_cfg['ac_type'] == 21){
                    $where[] = " ((cl.cl_use_time_type=1 and (cl.cl_use_end_time>".time()." or (cl.cl_use_end_time=0 and cl.cl_end_time>".time()."))) or (cl.cl_use_time_type=2 and cr.cr_expire_time>".time()."))";
                
                break;
            case '1'://已使用
                $where[]    = array('name' => 'cr.cr_is_used', 'oper' => '=', 'value' => 1);
                break;
            case '2'://已过期
                //if($this->applet_cfg['ac_type'] == 21){
                    $where[]    = array('name' => 'cr.cr_is_used', 'oper' => '=', 'value' => 0);
                    $where[] = " ((cl.cl_use_time_type=1 and ((cl.cl_use_end_time > 0 and cl.cl_use_end_time<".time().") or (cl.cl_use_end_time=0 and cl.cl_end_time<".time()."))) or (cl.cl_use_time_type=2 and cr.cr_expire_time<".time()."))";
                
                break;
            case '3'://已使用和已过期
                //if($this->applet_cfg['ac_type'] == 21){
                    $where[] = " (cr.cr_is_used=1 or ((cl.cl_use_time_type=1 and ((cl.cl_use_end_time > 0 and cl.cl_use_end_time<".time().") or (cl.cl_use_end_time=0 and cl.cl_end_time<".time()."))) or (cl.cl_use_time_type=2 and cr.cr_expire_time<".time().")))";
                
                break;
        }

        $total  = $receive_model->getReceiveCount($where);
        $pager  = new Libs_Pagination_Paginator($total, 10);
        $sort   = array('cr.cr_receive_time' => 'DESC');
        $list   = $receive_model->getReceiveList($where, $pager->index, $pager->count, $sort);
        if ($list) {
            foreach ($list as &$item) {
                $item = $this->_format_coupon_data($item, true);
                //使用情况判断
                if ($item['used']) {
                    $item['status'] = 1;
                } else {
                    if (strtotime($item['end']) < time()) {
                        $item['status'] = 2;
                    } else {
                        $item['status'] = 0;
                    }
                }
            }
            $list = $this->statusSort($list, 'status');
            $info['data'] = $list;
            $this->outputSuccess($info);
        }else{
            $this->outputError("暂时没有优惠券哦");
        }
    }

    
    private function statusSort($array, $field, $sort = 'SORT_ASC'){
        $arrSort = array();
        foreach ($array as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        array_multisort($arrSort[$field], constant($sort), $array);
        return $array;
    }


    
    public function couponListAction() {
        $esId = $this->request->getIntParam('esId');
        $type = $this->request->getStrParam('type','');
//        $page = $this->request->getIntParam('page');
//        $index = $page * $this->count;
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();

        $all = false;
        if($this->applet_cfg['ac_type'] == 32){
            $all = true;
        }
        
        if(in_array($this->applet_cfg['ac_type'],[21]) && $type == 'notIndex'){
            $all = true;
        }
        
        

        $coupon = $coupon_model->fetchShowValidList($this->sid,0,0, $esId, 0, $all);
        // 获取已经领取的优惠券
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $myCoupon = $receive_model->fetchCouponList( $this->sid,$this->uid);
        $list   = array();
        $cids   = [];
        foreach ($coupon as $key => $value) {
            $list[] = $this->_format_coupon_data($value, false,$myCoupon);
            $cids[] = $value['cl_id'];
        }
        if ($list) {
            if($this->applet_cfg['ac_type'] == 32){
                $list = $this->_check_coupon_receive($list,$cids);
            }

            $info['data'] = $list;
            $this->outputSuccess($info);
        } else {
            $this->outputError('无可用优惠券');
        }
    }

    
    private function _check_coupon_receive($list,$cids){
        if($cids && $list){
            $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
            $myCoupon = $receive_model->fetchCouponListArr( $this->sid,$this->uid,$cids);
            foreach ($list as $key => &$val){
                //存在此优惠券的领取记录
                if($myCoupon[$val['id']]){
                    $myCouponList = $myCoupon[$val['id']];
                    $count = count($myCouponList);
                    $val['used'] = 1;
                    $val['received'] = 0;
                    //如果有未使用的优惠券 状态为未使用
                    foreach ($myCouponList as $k => $v){
                        if($v['cr_is_used'] == 0){
                            $val['used'] = 0;
                            continue;
                        }
                    }
                    //判断是否达到领取限制
                    if($val['receiveLimit'] > 0 && $count >= $val['receiveLimit']){
                        $val['received'] = 1;
                        //全部使用  不显示优惠券
                        if($val['used'] == 1){
                            unset($list[$key]);
                        }
                    }
                }else{
                    $val['received'] = 0;
                    $val['used'] = 1;
                }
            }
        }
        return array_values($list);
    }

    
    private function _get_shortcut(){
        $shortcut_storage   = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
        $shortcut   = $shortcut_storage->fetchShortcutShowList(-4);
        $data = [];
        if($shortcut){
            foreach ($shortcut as $val){
                $data[] = array(
                    'name' => $val['ss_name'],
                    'icon' => isset($val['ss_icon']) ? $this->dealImagePath($val['ss_icon']) : '',
                    'link' => isset($val['ss_link']) ? $val['ss_link'] : '',
                    'type' => intval($val['ss_link_type']),
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
        }
        return $data;
    }

    private function _get_shop_category(){
        $data = [];
        $data[] = [
            'id' => 0,
            'name' => '全部',
        ];
        if($this->applet_cfg['ac_type'] == 8){
            $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
            $list = $category_model->getFirstCategory(0,0);
            if($list){
                foreach ($list as $val){
                    $data[] = [
                        'id' => intval($val['ack_id']),
                        'name' => $val['ack_name']
                    ];
                }
            }
        }elseif ($this->applet_cfg['ac_type'] == 6){
            $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
            $list = $shortcut_model->fetchShortcutShowList(2);
            if($list){
                foreach ($list as $val){
                    $data[] = [
                        'id' => intval($val['acc_id']),
                        'name' => $val['acc_title']
                    ];
                }
            }
        }
        return $data;
    }

    
    private function _shop_index_slide($tpl_id,$type = 1){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($this->sid);
        $slide      = $slide_storage->fetchSlideShowList($tpl_id,$type);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'], # /pages/index/index?id=8
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : '',
                    'type' => $val['ss_link_type'],
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_article_title']),
                );
            }
        }
        return $data;
    }

    
    private function _format_coupon_center($coupon, $myCoupon=array()){
        $left = $coupon['cl_count'] - $coupon['cl_had_receive'];
        $data = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => intval($coupon['cl_use_limit']),
            'count'     => intval($coupon['cl_count']),
            'receive'   => intval($coupon['cl_had_receive']),
            'desc'      => $coupon['cl_use_desc'],
            'left'      => $left > 0 ? intval($left) : 0,
            'startLeft' => ($coupon['cl_start_time'] - time())>0?($coupon['cl_start_time'] - time()):0,
            'needShare' => intval($coupon['cl_need_share']),
            'type'      => $coupon['cl_use_type'],
            'end'       => $coupon['cl_end_time'] ? date('Y-m-d', $coupon['cl_end_time']) : '',
            'received'  => !empty($myCoupon) && isset($myCoupon[$coupon['cl_id']]) ? 1 : 0,
            'uid'       => $this->uid,
            'percent'   => floor(($coupon['cl_had_receive']/$coupon['cl_count'])*100),
            'shopName'  => $this->shop['s_name'],
            'shopId'    => 0,
            'shopLogo'  => $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png')
        );
        $data['expireDesc'] = $data['end'] ? '有效期至'.$data['end'] : '';

        if($this->applet_cfg['ac_type'] == 6 && $coupon['acs_id'] > 0){
            $data['shopName'] = $coupon['acs_name'] ? $coupon['acs_name'] : ($coupon['es_name'] ? $coupon['es_name'] : $this->shop['s_name']);
            $data['shopId'] = $coupon['acs_id'] ? intval($coupon['acs_id']) : 0;
            $data['shopLogo'] = $coupon['acs_img'] ? $this->dealImagePath($coupon['acs_img']) : ($coupon['es_logo'] ? $this->dealImagePath($coupon['es_logo']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png')));

        }elseif ($this->applet_cfg['ac_type'] == 8 && $coupon['es_id'] > 0){
            $data['shopName'] = $coupon['es_name'] ? $coupon['es_name'] : $this->shop['s_name'];
            $data['shopId'] = $coupon['es_id'] ? intval($coupon['es_id']) : 0;
            $data['shopLogo'] = $coupon['es_logo'] ? $this->dealImagePath($coupon['es_logo']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png'));
        }

        return $data;
    }

    
    private function _save_verify_record($mid,$code,$os_id = 0,$type,$manager_id = 0,$manager_role = '',$esId = 0,$osId = 0){

        $role_type = [
            'admin' => 1,
            'entershop' => 2,
            'store' => 3,
        ];

        $role_status = $role_type[$manager_role] ? $role_type[$manager_role] : 0;

        if($type){
            $verify_model = new App_Model_Store_MysqlVerifyStorage($this->sid);

            $data = array(
                'ov_s_id'        => $this->sid,
                'ov_m_id'        => $mid,
                'ov_st_id'       => $os_id,
                'ov_value'       => $code,
                'ov_type'        => $type,
                'ov_record_time' => time(),
                'ov_manager_id' => $manager_id,
                'ov_manager_role' => $role_status,
                'ov_es_id'       => $esId,
                'ov_os_id'       => $osId

            );
            $verify_model->insertValue($data);
        }

    }

}
<?php


class App_Controller_Applet_GroupController extends App_Controller_Applet_InitController
{
    private $group_status_desc  = array(
        App_Helper_Group::GROUP_STATUS_RUNNING  => '待成团',
        App_Helper_Group::GROUP_STATUS_SUCCESS  => '拼团成功',
        App_Helper_Group::GROUP_STATUS_FAILURE  => '拼团失败',
    );

    public function __construct()
    {
        parent::__construct(true);

    }

    

    private function _shop_index_tpl(){
        $data = array();
        $tpl_model = new App_Model_Group_MysqlGroupIndexStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid();
        if($tpl){
            $data = array(
                'title'        => $tpl['agi_title'],
                'listTitle'    => $tpl['agi_list_title'] ? $tpl['agi_list_title'] : '限时特惠拼团',
                'type'         => $tpl['agi_list_type'] ? $tpl['agi_list_type'] : 1,
                'isopen'       => $tpl['agi_isopen']?$tpl['agi_isopen']:0,
                'applytitle'   => !empty($tpl['agi_apply_title'])?$tpl['agi_apply_title']:'欢迎报名参加活动'
            );
        }
        return $data;
    }

    
    private function _shop_index_shortcut(){
        $data = array();
        //获取快捷按钮
        $shortcut_storage   = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
        $shortcut   = $shortcut_storage->fetchShortcutShowList(0);
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

    //获取拼团活动列表
    public function getGroupListAction(){
        $type = $this->request->getIntParam('type');
        $page = $this->request->getIntParam('page');
        $category = $this->request->getIntParam('category');
        //新增参数，判断是否显示全部的活动，包含已结束的活动   1
        $version  = $this->request->getIntParam('version');
        $esId = $this->request->getIntParam('esId');
        
        //$org_model = new App_Model_Group_MysqlOrgStorage();
        $index = $page * $this->count;
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $info['data']   = array();
        if($category){
            if($this->applet_cfg['ac_type'] == 12){//培训版
                $act_arr    = $group_model->getGroupCourse('look',$category,$index,$this->count,'',$version);
            }else{
                $act_arr    = $group_model->getGroupGoods('look',$category,$index,$this->count,'',0);
            }
            $info['data']['category'] = $this->_goods_group($category);
        }else{
            if($this->applet_cfg['ac_type'] == 12){
                $goodsType = 'course';
            }else{
                $goodsType = '';
            }

            $act_arr    = $group_model->getCurrentListByType($type,$index,$this->count,$version,$goodsType, $esId);
        }
        

        if($act_arr || !$page){
            if(!$act_arr){
                $info['data']['goods']=array();
            }else{
                foreach ($act_arr as &$one) {
                    //$had_total   = $org_model->getGroupMemberCount($one['gb_id']);
                    //新增拼团活动的状态，
                    if(time()>$one['gb_end_time'] || ($one['g_stock'] <= 0 && in_array($this->applet_cfg['ac_type'],[1,21,24,8,6]))){
                        $status     = 3;
                        $statusNote = '已结束';
                    }else if(time()>= $one['gb_start_time'] && time()<=$one['gb_end_time']){
                        $status     = 2;
                        $statusNote = '进行中';
                    }else if(time()<$one['gb_start_time']){
                        $status     = 1;
                        $statusNote = '未开始';
                    }

                    if($this->applet_cfg['ac_type'] == 12){
                        $cover = $one['atc_cover'];
                        $name  = $one['atc_title'];
                        $price = $one['atc_price'] && is_numeric($one['atc_price']) ? $one['atc_price'] : 0;
                        $sold  = $one['atc_apply'];
                        $independent = 0;
                    }else{
                        $cover = $one['g_cover'];
                        $name  = $one['g_name'];
                        $price = $one['g_price'];
                        $sold  = $one['g_sold'];
                        $independent = intval($one['g_independent_mall']);
                    }

                    $info['data']['goods'][] = array(
                        'id'    => $one['gb_id'],
                        'cover' => $this->dealImagePath($one['gb_cover']),
                        'gcover'=> $this->dealImagePath($cover),
                        'name'  => $name,
                        'gprice'=> $one['gb_type']==3?$one['gb_tz_price']:$one['gb_price'],
                        'price' => $price,
                        'total' => $one['gb_total'],
                        'showNum'    => $one['gb_view_num'],
                        'showNumShow'=> $one['gb_view_num_show'],
                        'typeDesc' => ($one['gb_type']==2?'抽奖团':($one['gb_type']==4?'阶梯团':$one['gb_total'].'人团')),
//                        'hadTotal' => $one['gb_joined'],
                        'hadTotal' => intval($sold),
                        'status'   => $status,
                        'statusNote'=> $statusNote,
                        'independent' => $independent
                    );
                }
            }

            //抖音 记录入驻店铺浏览
            if($this->appletType == 4 && $esId){
                $this->shopVisitRecord($this->member['m_id'],$esId);
            }

            $this->outputSuccess($info);
        }else{
            $this->outputError('暂无拼团活动记录');
        }
    }

    
    private function _goods_group($id){
        $group_model  = new App_Model_Group_MysqlGroupStorage($this->sid);
        $row = $group_model->getRowById($id);
        $data = array(
            'name'  => $row['agg_name'] ? $row['agg_name'] : '',
            'brief' => isset($row['agg_brief']) ? $row['agg_brief'] : '热销商品包你满意',
            'img'   => isset($row['agg_bg']) && $row['agg_bg'] ? $this->dealImagePath($row['agg_bg']) : $this->dealImagePath('/upload/gallery/thumbnail/C5A1A4E4-B65B-5031-F627091DF542-tbl.jpeg')
        );
        return $data;
    }

    
    private function get_index_coupon() {
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();

        $coupon = $coupon_model->fetchShowValidList($this->sid,0,0);
        $list   = array();
        foreach ($coupon as $key => $value) {
            $list[] = $this->_format_coupon_data($value, false);
        }

        return $list;

    }

    
    private function _format_coupon_data($coupon, $receive){
        $data = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => $coupon['cl_use_limit'],
            'count'     => $coupon['cl_count'],
            'receive'   => $coupon['cl_had_receive'],
            'desc'      => $coupon['cl_use_desc'],
            'type'      => $coupon['cl_use_type'],
            'start'     => date('Y-m-d', $coupon['cl_start_time']),
            'end'       => date('Y-m-d', $coupon['cl_end_time']),
            'colorType' => (intval($coupon['cl_id']%4))+1
        );

        if($receive){
            $data['used'] = $coupon['cr_is_used'];
        }
        return $data;
    }

    
    public function detailAction() {
        //拼团活动ID
        $gbid    = $this->request->getIntParam('gbid');
        if (!$gbid) {
            $this->outputError("拼团活动已消失");
        }
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);

        if($this->applet_cfg['ac_type'] == 12){
            $text = '课程';
            $detail = $group_model->fetchGroupCourse($gbid);
        }else{
            $text = '商品';
            $detail     = $group_model->fetchGroupGoods($gbid);
        }

        if (!$detail) {
            $this->outputError("拼团{$text}消失了");
        }
        $group_model->incrementViewNum($gbid);

        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        //$info['data']['goods_total']= $goods_model->fetchCountBySid($this->sid);
        if($this->applet_cfg['ac_type'] == 12){
            $info['data']['detail']     = $this->_format_course_details($detail, true);
        }else{
            $info['data']['detail']     = $this->_format_goods_details($detail, true);
        }

        if($this->applet_cfg['ac_type'] == 27){
            //获得配置
            $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
            $index = $index_model->findUpdateBySid(59);
            switch ($detail['g_knowledge_pay_type']){
                case 1:
                    $tab_field = $index['aki_picture_tab'] ? $index['aki_picture_tab'] : '目录';
                    break;
                case 2:
                    $tab_field = $index['aki_audio_tab'] ? $index['aki_audio_tab'] : '节目';
                    break;
                case 3:
                    $tab_field = $index['aki_video_tab'] ? $index['aki_video_tab'] : '课程';
                    break;
                default:
                    $tab_field = '课程';
            }
            $info['data']['detail']['tabField'] = $tab_field;
        }


        switch (intval($detail['gb_type'])) {
            case App_Helper_Group::GROUP_TYPE_PTPT :
                $group_key  = 'ptpt';
                $group_name = '普通团';
                break;
            case App_Helper_Group::GROUP_TYPE_CJT :
                $group_key  = 'cjt';
                $group_name = '抽奖团';
                break;
            case App_Helper_Group::GROUP_TYPE_TZYHT :
                $group_key  = 'tzyht';
                $group_name = '团长优惠团';
                break;
            case App_Helper_Group::GROUP_TYPE_JTPT :
                $group_key  = 'jtpt';
                $group_name = '阶梯团';
                break;
        }

        //获取拼团规则
        $gcfg_model = new App_Model_Group_MysqlCfgStorage($this->sid);
        $gcfg   = $gcfg_model->getRowUpdata();
        $info['data']['groupDesc']   = array(
            'rule'  => $detail['gb_act_rule'] ? $detail['gb_act_rule'] : plum_parse_config('group_rule')[$group_key],
            'name'  => $group_name,
        );

        //活动加群设置
        $info['data']['wxGroupData'] = array(
            'show'   => $gcfg?$gcfg['gc_wxgroup_show']:0,
            'title'  => $gcfg?$gcfg['gc_wxgroup_title']:'',
            'desc'   => $gcfg?$gcfg['gc_wxgroup_desc']:'',
            'logo'   => $gcfg?$this->dealImagePath($gcfg['gc_wxgroup_logo']):'',
            'qrcode' => $gcfg?$this->dealImagePath($gcfg['gc_wxgroup_qrcode']):'',
        );

        //入驻商家商品，返回商家信息
        $info['data']['shop'] = array();
        if($detail['gb_es_id']){
            if($this->applet_cfg['ac_type'] == 6){
                $shop =  $this->_get_city_shop_info($detail['gb_es_id']);
            }else{
                $shop =  $this->_get_shop_info($detail['gb_es_id']);
            }
            $info['data']['shop'] = $shop;
        }


        //输出分享信息
        if($this->applet_cfg['ac_type'] == 12){
            $shareCover = $detail['atc_cover'];
            $shareTitle = $detail['atc_title'];
            $brief      = $detail['atc_brief'];
        }else{
            $shareCover = $detail['g_cover'];
            $shareTitle = $detail['g_name'];
            $brief      = $detail['g_brief'];
        }
        $info['data']['share']['title'] = $detail['gb_share_title'] ? $detail['gb_share_title'] : $shareTitle;
        $info['data']['share']['desc'] = $detail['gb_share_desc'] ? $detail['gb_share_desc'] : $brief;
        $info['data']['share']['img'] = $detail['gb_share_image'] ? $this->dealImagePath($detail['gb_share_image']) : $this->dealImagePath($shareCover);


        //获取凑团列表
        $show_list  = null;

        //拼团尚未开始
        if ($detail['gb_start_time'] > time()) {
            $left   = array(
                'status'    => 3,//尚未开始
                'desc'      => '尚未开始',
            );
        } else if ($detail['gb_end_time'] < time()) {//拼团活动已结束
            $left   = array(
                'status'    => 2,//已结束
                'desc'      => '已结束',
            );
        } else {//拼团活动进行中
            //获取凑团显示
            if ($detail['gb_show_num'] > 0) {
                $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
                if($detail['gb_type'] == 4){
                    $group_model  = new App_Model_Group_MysqlBuyStorage($this->sid);
                    $where = array();
                    $where[] = array('name' => 'gb_gbs_id', 'oper' => '=', 'value' => $detail['gb_gbs_id']);
                    $groupList = $group_model->getList($where, 0, 0, array('gb_total' => 'ASC'));
                    foreach ($groupList as $value){
                        $gbidSection[] = $value['gb_id'];
                    }
                    $show_list  = $org_model->fetchJoiningList('', $detail['gb_show_num'], $gbidSection);
                }else{
                    $show_list  = $org_model->fetchJoiningList($gbid, $detail['gb_show_num']);
                }

                $group_redis    = new App_Model_Group_RedisOrgStorage($this->sid);
                foreach ($show_list as &$item) {
                    $item['avatar'] = $item['m_avatar'] ? $item['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                    $item['nickname'] = $item['m_nickname'];
                    $item['tid'] = $item['gm_tid'];
                    $item['less'] = intval($item['go_total']) - intval($item['go_had']);
                    $item['left_time']  = $group_redis->fetchTaskTtl($item['go_id']);
                }
            }

            //计算拼团活动剩余时间
            $left_time  = $detail['gb_end_time'] - time();
            $left_day   = ceil($left_time/(24*60*60));
            $left   = array(
                'status'    => 1,//拼团进行中
                'remain'    => $left_day,
            );
        }

        $info['data']['remain'] = $left;

        $info['data']['show_list']  = $show_list;
        $this->outputSuccess($info);
    }


    //格式化店铺信息
    private function _get_city_shop_info($esId){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getCityShopDetail($esId);
        $data = array();
        if($shop){
            $data = array(
                'id'        => intval($shop['acs_id']),
                'esId'      => intval($shop['es_id']),
                'esid'      => intval($shop['es_id']),
                'name'      => $shop['acs_name'],
                'score'     => $shop['acs_score']>0 && $shop['acs_total_score']>0 ?  round((($shop['acs_score']/$shop['acs_total_score'])*5),1) : 5,   // 星级
                'address'   => $shop['acs_address'],
                'lng'       => $shop['acs_lng'],
                'lat'       => $shop['acs_lat'],
                'mobile'    => $shop['acs_mobile'],
                'vrurl'     => $shop['acs_vr_url'] ? $this->_judge_vrurl($shop['acs_vr_url']) : '',
                'handClose' => intval($shop['es_hand_close'])
            );
        }
        return $data;
    }

    //格式化店铺信息
    private function _get_shop_info($id){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getRowByIdMemberExtra($id);
        if($shop){
            $score_desc = plum_parse_config('community_score_desc', 'system');

            if($shop['es_hand_close'] == 0){
                if($shop['es_common_business_time']){
                    $openInfo = $this->_check_shop_status($shop);
                    $openStatus  = $openInfo['openStatus'];
                    $openNote = $openInfo['openNote'];
                }else{
                    $shopOpen = $shop['es_business_time'] ?  $shop['es_business_time'] : '00:00';
                    $shopClose = $shop['es_close_time'] ? $shop['es_close_time'] : '23:59';
                    $timeNow = time();
                    $isOpen = 0;

                    $openTime = strtotime($shopOpen);
                    $closeTime = strtotime($shopClose);
                    if ($openTime >= $closeTime) {
//                    $closeTime = $closeTime + 86400;
                        //获得当天0点时间戳
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        //获得当天24点时间戳
                        $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                            $isOpen = true;
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $isOpen = true;
                        }
                    }
                    if (!$isOpen) {
                        $openStatus  = 2;
                        $openNote = '已打烊';
                    }else{
                        $openStatus  = 1;
                        $openNote = '营业中';
                    }
                }
            }else{
                $openStatus  = 2;
                $openNote = '已打烊';
            }

            if($shop['es_cate1']){
                $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
                $category = $category_model->getRowById($shop['es_cate1']);
                if($category){
                    $cate1_id = $shop['es_cate1'];
                    $cate1_name = $category['ack_name'];
                }else{
                    $cate1_id = 0;
                    $cate1_name = '';
                }
            }else{
                $cate1_id = 0;
                $cate1_name = '';
            }

            $data = array(
                'id'           => $shop['es_id'],
                'isMy'         => $this->member['m_id'] == $shop['es_m_id'] ? 1 : 0,
                'logo'         => $shop['es_logo'] ? $this->dealImagePath($shop['es_logo']) : '',
                'logoTrue'     => $shop['es_logo'] ? $shop['es_logo'] : '',
                'brief'        => $shop['es_brief'] ? $shop['es_brief'] : '',
                'name'         => $shop['es_name'],
                'address'      => ($shop['es_addr'] ? $shop['es_addr'] : '').($shop['es_addr_detail'] ? $shop['es_addr_detail'] : ''),
                'addressTrue'  => $shop['es_addr'] ? $shop['es_addr'] : '',
                'addressDetail' => $shop['es_addr_detail'] ? $shop['es_addr_detail'] : '',
                'firstCateId'  => $cate1_id,
                'firstCateName'=> $cate1_name,
                'lng'          => $shop['es_lng'],
                'lat'          => $shop['es_lat'],
                'mobile'       => $shop['es_phone'],
                'score'        => $shop['es_score'],
                'scoreDesc'    => $score_desc[intval($shop['es_score'])],
                'isCollection' => $this->_is_collection($shop['es_id'], 1),
                'vrurl'        => $shop['es_vr_url'] ? $this->_judge_vrurl($shop['es_vr_url']) : '',
                'showNum'      => $this->number_format($shop['es_show_num']+1),
                'isbuy'        => intval($shop['es_isbuy']),
                'limitOpen'    => intval($shop['es_limit_open']),
                'groupOpen'    => intval($shop['es_group_open']),
                'bargainOpen'  => intval($shop['es_bargain_open']),
                'handClose'    => intval($shop['es_hand_close']),
                'label'         => isset($shop['es_label']) && trim($shop['es_label']) ? preg_split("/[\s,]+/",$shop['es_label']) : '' ,//trim防止全是空格
                'openTime'     => ($shop['es_business_time'] ?  $shop['es_business_time'] : '00:00' ).'-'.($shop['es_close_time'] ? $shop['es_close_time'] : '23:59'),
                'openTimeStart'=> $shop['es_business_time'] ? $shop['es_business_time'] : '',
                'openTimeEnd'=> $shop['es_close_time'] ? $shop['es_close_time'] : '',
                'openStatus'   => $openStatus,
                'openNote'     => $openNote,
                'carNum'       => intval($shop['ame_car_num']),
                'goodsStyle'   => $shop['es_goods_style'] > 0 ? intval($shop['es_goods_style']) : 1,
                'detail'       => plum_parse_img_path($shop['es_shop_detail'])
            );

            //判断当前当前店铺，当前会员是否可认领
            $uid = plum_app_user_islogin();
            $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $hadShop = $shop_model->getRowByMidSid($uid);
            $data['canClaim'] = 0;
            $data['claimId'] = 0;
            if(!$hadShop && !$shop['es_m_id']){
                $data['canClaim'] = 1;
                $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->sid);
                $claim = $claim_model->findClaimByMidShop($uid, 0, $shop['es_id']);
                $data['claimId'] = $claim?$claim['acsc_id']:0;
            }

            if($shop['es_common_business_time']){
                $data['openTime'] = $openInfo['openTime'];
            }
            return $data;
        }
        return '';
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

    //检查店铺状态
    private function _check_shop_status($shop){
        $openStatus  = 2;
        $openNote = '已打烊';
        $timeNow = time();
        $openTimeStr = '';
        if($shop['es_week'.date('w').'_business_time']){
            $timeArr = json_decode($shop['es_week'.date('w').'_business_time'], true);
            foreach ($timeArr as $time){
                $openTime = strtotime($time['open']);
                $closeTime = strtotime($time['close']);
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $openStatus  = 1;
                    $openNote = '营业中';
                }
                $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
            }
        }else{
            $timeArr = json_decode($shop['es_common_business_time'], true);
            foreach ($timeArr as $time){
                $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                $openTime = strtotime($time['open']);
                $closeTime = strtotime($time['close']);
                if($openTime <= $timeNow && $timeNow <= $closeTime){
                    $openStatus  = 1;
                    $openNote = '营业中';
                }
            }
        }
        return array('openStatus' => $openStatus, 'openNote' => $openNote, 'openTime' => $openTimeStr);
    }

    private function _format_course_details($course,$detail=FALSE){
        if($course){
            $data = array(
                'gbid'       => $course['gb_id'],
                'id'         => $course['atc_id'],
                'name'       => $course['atc_title'],
                'total'      => $course['gb_total'],
                'cover'      => isset($course['atc_cover']) ? $this->dealImagePath($course['atc_cover']) : '',
                'gprice'     => $course['gb_type'] == 3?$course['gb_tz_price']:$course['gb_price'],
                'price'      => floatval($course['atc_price']) && is_numeric($course['atc_price']) ? floatval($course['atc_price']) : 0,
                'oriPrice'   => floatval($course['atc_ori_price']) && is_numeric($course['atc_ori_price']) ? floatval($course['atc_ori_price']) : 0,
                'brief'      => isset($course['atc_hour']) ? $course['atc_hour'].'课时' : '',
                'sold'       => $course['atc_apply'],
                'hasFormat'  => false,
                'gbtype'     => $course['gb_type'],
                'singleBuy' => intval($course['gb_single_buy']),
                'independent' => 0
            );
            if($detail){
                $data['parameter'] = plum_parse_img_path($course['atc_outline']);
                $data['detail'] = plum_parse_img_path($course['atc_content']);
            }

            $groupList = array();
            if($course['gb_type'] == 4){
                $data['gpriceSection'] = array();
                $group_model  = new App_Model_Group_MysqlBuyStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'gb_gbs_id', 'oper' => '=', 'value' => $course['gb_gbs_id']);
                $groupList = $group_model->getList($where, 0, 0, array('gb_total' => 'ASC'));
                foreach ($groupList as $value){
                    $data['gpriceSection'][] = array(
                        'actId'  => intval($value['gb_id']),
                        'total'  => intval($value['gb_total']),
                        'name'   => $value['gb_total']."人团",
                        'gprice' => floatval($value['gb_price']),
                    );
                }
            }

            foreach ($groupList as $value){
                $data['formatSection'][] = array(
                    'actId'  => intval($value['gb_id']),
                    'total'  => intval($value['gb_total']),
                    'name'   => $value['gb_total']."人团",
                    'gprice' => floatval($value['gb_price']),
                );
            }

            //是否已经收藏
            $where = array();
            $where[]    = array('name' => 'atcc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'atcc_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]    = array('name' => 'atcc_atc_id', 'oper' => '=', 'value' => $course['atc_id']);

            $collection_model   = new App_Model_Train_MysqlTrainCourseCollectionStorage($this->sid);
            $had    = $collection_model->getRow($where);
            $data['isCollect'] = $had ? 1 : 0;
            return $data;
        }
        return FALSE;
    }

    
    private function _format_goods_details($goods,$detail=false){
        if($goods){
            $data = array(
                'gbid'       => $goods['gb_id'],
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'total'      => $goods['gb_total'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'gprice'     => $goods['gb_type'] == 3?$goods['gb_tz_price']:$goods['gb_price'],
                'price'      => floatval($goods['g_price']),
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'gbtype'     => $goods['gb_type'],
                'type'       => $goods['g_knowledge_pay_type'],
                'totalNum'   => $goods['g_knowledge_total'],
                'singleBuy' => intval($goods['gb_single_buy']),
                'independent' => intval($goods['g_independent_mall'])
            );

            $uid    = plum_app_user_islogin();
            $vipData = App_Helper_Trade::getGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);
            $data['price'] = floatval($vipData['price']);

            $groupList = array();
            if($goods['gb_type'] == 4){
                $data['gpriceSection'] = array();
                $group_model  = new App_Model_Group_MysqlBuyStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'gb_gbs_id', 'oper' => '=', 'value' => $goods['gb_gbs_id']);
                $groupList = $group_model->getList($where, 0, 0, array('gb_total' => 'ASC'));
                foreach ($groupList as $value){
                    $data['gpriceSection'][] = array(
                        'actId'  => intval($value['gb_id']),
                        'total'  => intval($value['gb_total']),
                        'name'   => $value['gb_total']."人团",
                        'gprice' => floatval($value['gb_price']),
                    );
                }
            }

            $data['newLabel'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['newLabel'][] = $val;
                    }
                }
            }
            if($this->applet_cfg['ac_type']==27){
                $uid = plum_app_user_islogin();
                $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
                $data['updateNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id']);
                $data['readNum'] = $knowpay_model->getReadNumByGid($goods['g_id']);
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $hadBuy = $order_model->getTradeByGid($goods['g_id'],$uid);
                $data['hadBuy'] = $hadBuy?1:0;
                $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'akc_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[] = array('name' => 'akc_c_id', 'oper' => '=', 'value' => 0);
                $where[] = array('name' => 'akc_g_id', 'oper' => '=', 'value' => $goods['g_id']);
                $data['commentCount'] = $comment_model->getCount($where);
            }
            // 是否获取商品详情
            if($detail){
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['video']  = $goods['g_video_url'] ? $goods['g_video_url']:'';
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
                $data['detail'] = plum_parse_img_path($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);
                if($data['slide']) {
                    $imagesize = getimagesize($data['slide'][0]);
                    if ($imagesize[0] == $imagesize[1]) {
                        $data['slideSpecif'] = 1;
                    } else {
                        $data['slideSpecif'] = 0;
                    }
                }
                $data['format'] = $this->_goods_format($goods['g_id']);
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }

                if($data['hasFormat']){
                    $data['formatList']  = $this->_new_goods_format($goods);
                    $formatDataNew = $this->_get_format_value($goods['g_id'], $goods['gb_id'], $goods['gb_type'], false, true);
                    $data['formatValue'] = $formatDataNew['data'];
                    $data['formatValueNew'] = $formatDataNew['newData'];
                    foreach ($groupList as $value){
                        $formatSectionDataNew = $this->_get_format_value($goods['g_id'], $value['gb_id'], $goods['gb_type'], false, true);
                        $data['formatSection'][] = array(
                            'actId'  => intval($value['gb_id']),
                            'total'  => intval($value['gb_total']),
                            'name'   => $value['gb_total']."人团",
                            'gprice' => floatval($value['gb_price']),
                            'formatList'  => $data['formatList'],
                            'formatValue' => $formatSectionDataNew['data'],
                            'formatValueNew' => $formatSectionDataNew['newData'],
                        );
                    }
                }else{
                    foreach ($groupList as $value){
                        $data['formatSection'][] = array(
                            'actId'  => intval($value['gb_id']),
                            'total'  => intval($value['gb_total']),
                            'name'   => $value['gb_total']."人团",
                            'gprice' => floatval($value['gb_price']),
                        );
                    }
                }

                $prices = [$data['gprice']];
                foreach ($data['formatValue'] as $key => $format){
                    // 获取不同规格的价格
                    $prices[] = $data['formatValue'][$key]['price']?$data['formatValue'][$key]['price']:0;
                }
                //array_push($prices,$data['price']);
                $data['maxPrice'] = !empty($prices) && max($prices)>0 ? floatval(max($prices)) : 0;
                $data['minPrice'] = !empty($prices) && min($prices)>0 ? floatval(min($prices)) : 0;

                if($this->applet_cfg['ac_type'] == 7){
                    $hotel_model = new App_Model_Hotel_MysqlHotelStoreStorage($this->sid);
                    $hotelRow = $hotel_model->getRowById($goods['g_kind1']);
                    $data['hotelName'] = $hotelRow['ahs_name'];
                    $data['hotelId']   = $hotelRow['ahs_id'];
                }
            }

            //是否已经收藏
            $where = array();
            $where[]    = array('name' => 'c_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'c_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]    = array('name' => 'c_g_id', 'oper' => '=', 'value' => $goods['g_id']);

            $collection_model   = new App_Model_Goods_MysqlCollectionStorage($this->sid);
            $had    = $collection_model->getRow($where);
            $data['isCollect'] = $had ? 1 : 0;

            return $data;
        }
        return false;
    }

    
    private function _new_goods_format($goods){
        if($goods['g_format_type']){
            $spec = json_decode($goods['g_format_type'], true);
            foreach($spec as $key => $val){
                foreach($val['value'] as $k=>$v){
                    $spec[$key]['value'][$k]['fIndex'] = $key;
                    $spec[$key]['value'][$k]['checked'] = false;
                    $spec[$key]['value'][$k]['img'] = $v['img']?$this->dealImagePath($v['img']):$this->dealImagePath($goods['g_cover']);
                }
            }
            return $spec;
        }else{
            $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
            $format         = $format_model->getListByGid($goods['g_id']);
            $spec = [
                [
                    'name' => '规格',
                    'value' => []
                ]
            ];
            foreach($format as $key => $val){
                $spec[0]['value'][] = [
                    'fIndex' => 0,
                    'checked' => false,
                    'name' => $val['gf_name'],
                    'img'  => $this->dealImagePath($goods['g_cover'])
                ];
            }
            return $spec;
        }
    }


    
    private function _get_format_value($gid, $gbId, $type, $isJoin = false,$isArr=false){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        $newData = array();
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $group = $group_model->getRowById($gbId);
        $group_format_model = new App_Model_Group_MysqlGroupGoodsFormatStorage();
        foreach($format as $val){
            $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid,1);
            $actFormat = $group_format_model->getRowByActIdGfid($gbId, $val['gf_id']);

            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price'  => intval($vipData['price']),
                'gprice' => $actFormat?($type == 3 && !$isJoin?$actFormat['gbf_tz_price']:$actFormat['gbf_price']):($group['gb_type'] == 3 && !$isJoin?$group['gb_tz_price']:$group['gb_price']),
                'stock'  => $this->applet_cfg['ac_type'] == 7 ?  $val['gf_hotel_stock'] : $val['gf_stock']
            ];

            $newData[$val['gf_name'].($val['gf_name2']?'-':'').$val['gf_name2'].($val['gf_name3']?'-':'').$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price'  => intval($vipData['price']),
                'gprice' => $actFormat?($type == 3 && !$isJoin?$actFormat['gbf_tz_price']:$actFormat['gbf_price']):($group['gb_type'] == 3 && !$isJoin?$group['gb_tz_price']:$group['gb_price']),
                'stock'  => $this->applet_cfg['ac_type'] == 7 ?  $val['gf_hotel_stock'] : $val['gf_stock']
            ];
        }
        if($isArr){
            return [
                'data'      =>$data,
                'newData'   =>$newData
            ];
        }else{
            return $data;
        }
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
                    'stock' => $this->applet_cfg['ac_type'] == 7 ?  $val['gf_hotel_stock'] : $val['gf_stock'],
                    'point' => $val['gf_send_point'],
                );
            }
        }
        return $data;
    }

    
    public function joinAction() {
        $tid    = $this->request->getStrParam('tid', null);
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        if ($tid) {
            if($this->applet_cfg['ac_type'] == 12){//培训版
                $group  = $mem_model->findGroupOrgCourse($tid);
            }else{
                $group  = $mem_model->findGroupOrg($tid);
            }

        } else {
            $gbid   = $this->request->getIntParam('gbid');
            $org_model  = new App_Model_Group_MysqlOrgStorage($this->sid);
            if($this->applet_cfg['ac_type'] == 12){//培训版
                $group      = $org_model->findGroupOrgCourse($gbid);
            }else{
                $group      = $org_model->findGroupOrg($gbid);
            }
        }

        if (!$group) {
            $this->outputError("拼团活动消失了");
        }

        if($this->applet_cfg['ac_type'] == 12){//培训版
            $id    = $group['atc_id'];
            $cover = $group['atc_cover'];
            $name  = $group['atc_title'];
            $price = $group['atc_price'] && is_numeric($group['atc_price']) ? $group['atc_price'] : '';
            $oriPrice = $group['atc_ori_price'] && is_numeric($group['atc_ori_price']) ? $group['atc_ori_price'] : '';
            $detail   = $group['atc_content'];
        }else{
            $id    = $group['g_id'];
            $cover = $group['g_cover'];
            $name  = $group['g_name'];
            $price = $group['g_price'];
            $oriPrice = $group['g_ori_price'];
            $detail = $group['g_detail'];
        }

        $info['data']['group']  = array(
            'goId'   => $group['go_id'],
            'gcover' => $this->dealImagePath($cover),
            'gname' => $name,
            'gprice' => floatval($price),
            'price' => floatval($group['gb_price']),
            'oriPrice' => floatval($oriPrice),
            'total' => $group['go_total'],
            'hadNum' => $group['go_had'],
            'gid'    => $id,
            'actid'  => $group['gb_id'],
            'stock'  => intval($group['g_stock']),
            'type'       => $group['g_knowledge_pay_type'],
            'detail' => plum_parse_img_path_new($detail),
            'totalNum'   => $group['g_knowledge_total'],
        );

        if($this->applet_cfg['ac_type'] == 7){//酒店版
            $hotel_model = new App_Model_Hotel_MysqlHotelStoreStorage($this->sid);
            $hotelRow = $hotel_model->getRowById($group['g_kind1']);
            $info['data']['group']['hotelName'] = $hotelRow['ahs_name'];
            $info['data']['group']['hotelId'] = $hotelRow['ahs_id'];
        }

        if($this->applet_cfg['ac_type'] == 27){//知识付费
            $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
            $info['data']['group']['updateNum'] = $knowpay_model->getKnowledgeCountByGid($group['g_id']);

            $info['data']['group']['readNum'] = $knowpay_model->getReadNumByGid($group['g_id']);

            $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'akc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'akc_c_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'akc_g_id', 'oper' => '=', 'value' => $group['g_id']);
            $info['data']['group']['commentCount'] = $comment_model->getCount($where);

            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $hadBuy = $order_model->getTradeByGid($group['g_id'],$this->member['m_id']);
            $info['data']['group']['hadBuy'] = $hadBuy?1:0;
        }

        //获取商品规格

        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($group['g_id']);
        $info['data']['format'] = array();
        foreach($format as $val){
            $info['data']['format'][] = array(
                'gfid'=> $val['gf_id'],
                'gid'=> $val['gf_g_id'],
                'name'=> $val['gf_name'],
                'price' => $val['gf_price'],
                'sold'  => $val['gf_sold'],
                'stock' => $this->applet_cfg['ac_type'] == 7 ?  $val['gf_hotel_stock'] : $val['gf_stock']
            );
        }
        if(!empty($info['data']['format']) && $info['data']['format']){
            $info['data']['hasFormat'] = true;
        }
        $info['data']['formatList'] = array();
        $info['data']['formatValue'] = array();
        if($info['data']['hasFormat']){
            $info['data']['formatList']  = $this->_new_goods_format($group);
            $formatNewData = $this->_get_format_value($group['g_id'], $group['gb_id'], $group['gb_type'], true, true);
            $info['data']['formatValue'] = $formatNewData['data'];
            $info['data']['formatValueNew'] = $formatNewData['newData'];
        }
        //$info['data']['format'] = $this->_goods_format($group['g_id']);
        //获取参与者
        $join_list  = $mem_model->fetchJoinList($group['go_id']);
        foreach($join_list as $value){
            $info['data']['join_list'][]  = array(
                'avatar' => $value['m_avatar']?$value['m_avatar']:$this->dealImagePath("/public/wxapp/images/zhanwei_avatar.png"),
                'isTz'   => $value['gm_is_tz']
            );
        }

        //$info['data']['over_time']  = $group['go_create_time'] + 24*60*60 - time();
        $group_redis    = new App_Model_Group_RedisOrgStorage($this->sid);
        $info['data']['over_time']  = $group_redis->fetchTaskTtl($group['go_id']);
        //拼团进行中
        if ($group['go_status'] == 0) {
            $right  = array('name' => '邀请好友参团', 'href' => 'javascript:openShare(event)');
            $diff_num   = $group['go_total']-$group['go_had'];
            if ($group['go_tz_mid'] == $this->member['m_id']) {
                $title  = '开团成功!';
                $desc   = "只差<span>{$diff_num}</span>位小伙伴参与，快点邀请好友参团吧！";
                $state  = "kaituan";
                $status = 1;
            } else {
                $title  = '终于等到你,快来参团吧!';
                $desc   = "只差<span>{$diff_num}</span>位小伙伴参与，快点来参团吧！";
                $state  = "kaituanzhong";
                $status = 1;
                $had_join   = false;
                //判断是否参与过
                foreach ($join_list as $item) {
                    if ($item['gm_mid'] == $this->member['m_id']) {
                        $had_join   = true;
                        $title  = '参团成功,快邀小伙伴来参团吧!';
                        break;
                    }
                }
                //未参与过
                if (!$had_join) {
                    //未关注公众号
                    if ($group['gb_sub_limit'] && !$this->member['m_is_follow']) {
                        $right  = array('name' => '我要参团', 'href' => 'javascript:showQrcode()');
                    } else {
                        $right  = array('name' => '我要参团', 'href' => 'javascript:showBuy()');
                    }
                }
            }
        } else {
            if ($group['go_status'] == 1) {
                $title  = '组团成功啦！';
                $desc   = '商家会尽快向各位团员发货，请耐心等待！';
                $state  = 'successtuan';
                $status = 2;
            } else {
                $title  = '组团失败';
                $desc   = '';
                $state  = 'failtuan';
                $status = 3;
            }
        }
        $info['data']['group_desc'] = array(
            'title'     => $title,
            'desc'      => $desc,
            'state'     => $state,
            'status'    => $status
        );

        //输出分享信息
        if($this->applet_cfg['ac_type'] == 12){//培训版
            $shareCover = $group['atc_cover'];
            $shareTitle = $group['atc_title'];
            $brief      = $group['atc_brief'];
        }else{
            $shareCover = $group['g_cover'];
            $shareTitle = $group['g_name'];
            $brief      = $group['g_brief'];
        }

        //输出分享信息
        $info['data']['share']['title'] = $group['gb_share_title'] ? $group['gb_share_title'] : $shareTitle;
        $info['data']['share']['desc'] = $group['gb_share_desc'] ? $group['gb_share_desc'] : $brief;
        $info['data']['share']['img'] = $group['gb_share_image'] ? $this->dealImagePath($group['gb_share_image']) : $this->dealImagePath($shareCover);
        $this->outputSuccess($info);
    }



}

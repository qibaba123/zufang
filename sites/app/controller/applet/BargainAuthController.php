<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午10:08
 */
class App_Controller_Applet_BargainAuthController extends App_Controller_Applet_InitController {
    // 订单状态
    private $order_status_desc = array(
        App_Helper_Trade::TRADE_NO_PAY      => '订单待付款',
        App_Helper_Trade::TRADE_WAIT_PAY_RETURN => '待支付确认',
        App_Helper_Trade::TRADE_HAD_PAY     => '订单已支付，等待发货',
        App_Helper_Trade::TRADE_SHIP        => '订单已发货，等待收货',
        App_Helper_Trade::TRADE_FINISH      => '订单已完成',
        App_Helper_Trade::TRADE_CLOSED      => '订单已关闭',
        App_Helper_Trade::TRADE_REFUND      => '订单已退款',
    );

    /*
     * 店铺ID
     */
    public $sid;
    /*
     * 活动ID
     */
    private $aid;

    const MAX_BARGAIN_NUM   = 3;//单活动、单会员最大砍价次数

    public function __construct() {
        parent::__construct();
        $this->sid  = $this->shop['s_id'];
    }

    /*
     * 实际参与砍价页面
     */
    public function detailAction() {
        //获取活动
        $jid    = $this->request->getIntParam('jid');
        $aid    = $this->request->getIntParam('aid');

        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);

        if($this->applet_cfg['ac_type'] == 12){
            $activity  = $bargain_model->getCourseActivityById($aid);
        }else{
            $activity  = $bargain_model->getActivityById($aid);
        }

        $bargain_model->incrementViewNum($aid);

        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $record     = $join_storage->findJoinerByAidMid($aid, $this->member['m_id']);
        if($record && !$jid){
            $jid = $record['bj_id'];
        }

        //是否是活动参与者
        $info['data']['activity']   = $this->_format_activity($activity);


        
        // 砍价添加一个商品库存进入redis里的设置
        // zhangzc
        // 2019-08-12
        if($this->applet_cfg['ac_type'] == 32){
            $trade_redis_model   = new App_Model_Trade_RedisTradeStorage($this->sid); 
            $r_gid               = $activity['g_id'];
            $r_stock             = $activity['g_stock'];
            // 查看有无规格 无规格设置商品本来的库存
            if(empty($info['data']['activity']['format'])){
                $trade_redis_model->sequenceSetGoodsStock($r_gid,0,$r_stock );
            // 有规格设置规格里面的库存   
            }else{
                foreach ($info['data']['activity']['format'] as $item) {
                   $trade_redis_model->sequenceSetGoodsStock($r_gid,$item['id'],$item['stock']);
                }
            }
        }
        


        if($this->applet_cfg['ac_type'] == 27){
            //获得配置
            $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
            $index = $index_model->findUpdateBySid(59);
            switch ($activity['g_knowledge_pay_type']){
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
            $info['data']['activity']['tabField'] = $tab_field;
        }

        $cfg_model = new App_Model_Bargain_MysqlCfgStorage($this->sid);
        $bargain_cfg = $cfg_model->findShopCfg();
        //活动加群设置
        $info['data']['wxGroupData'] = array(
            'show'   => $bargain_cfg?$bargain_cfg['bc_wxgroup_show']:0,
            'title'  => $bargain_cfg?$bargain_cfg['bc_wxgroup_title']:'',
            'desc'   => $bargain_cfg?$bargain_cfg['bc_wxgroup_desc']:'',
            'logo'   => $bargain_cfg?$this->dealImagePath($bargain_cfg['bc_wxgroup_logo']):'',
            'qrcode' => $bargain_cfg?$this->dealImagePath($bargain_cfg['bc_wxgroup_qrcode']):'',
        );

        //入驻商家商品，返回商家信息
        $info['data']['shop'] = array();
        if($activity['ba_es_id']){
            if($this->applet_cfg['ac_type'] == 6){
                $shop =  $this->_get_city_shop_info($activity['ba_es_id']);
            }else{
                $shop =  $this->_get_shop_info($activity['ba_es_id']);
            }

            //抖音 记录入驻店铺浏览
            if($this->appletType == 4 && $activity['ba_es_id']){
                $this->shopVisitRecord($this->member['m_id'],$activity['ba_es_id']);
            }

            $info['data']['shop'] = $shop;
        }

        if($jid){
            $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
            $effort_storage = new App_Model_Bargain_MysqlEffortStorage($this->sid);
            //参与信息
            $record     = $join_storage->getRowByIdSid($jid, $this->sid);
            $info['data']['record'] = array(
                'bjId'     => $record['bj_id'],
                'mid'      => $record['bj_m_id'],
                'nickname' => $record['bj_m_nickname'],
                'avatar'   => $this->dealImagePath($record['bj_m_avatar']),
                'helpCount' => $record['bj_total'],
                'helpAmount' => $record['bj_amount'],
                'hadBuy'     => $record['bj_has_buy'],
                'leftAmount' => floatval($activity['ba_price'] - $record['bj_amount']),
                'percent'    => number_format(($record['bj_amount']/($activity['ba_price']- $activity['ba_kj_price_limit']))*100,2).'%'
            );


            $info['data']['desc'] = '砍价进度:原价'.$activity['ba_price'].'元，已砍至'.floatval($activity['ba_price'] - $record['bj_amount']).'元';
            //获取亲友团砍价列表
            $help_list  = $effort_storage->newFetchHelpListByJid($jid);
            $data = array();
            foreach($help_list as $val){
                $data[] = array(
                    'nickname' => $val['be_m_nickname'],
                    'avatar'   => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'money'    => $val['be_money']
                );
            }
            $info['data']['helper'] = $data;
            $info['data']['self'] = $record['bj_m_id'] == $this->member['m_id']?1:0;
            $info['data']['complete'] = floatval($activity['ba_price'] - $record['bj_amount'] - $activity['ba_kj_price_limit']) <=0 ? 1 : 0;
            if($info['data']['complete']==1){
                $info['data']['desc'] = '砍价进度:已砍至最低价，请立即购买';
            }

            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $where = array();
            $where[] = array('name' => 't_bj_id', 'oper' => '=', 'value' => $record['bj_id']);
            $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 't_status', 'oper' => '>', 'value' => 2);
            $where[] = array('name' => 't_status', 'oper' => '!=', 'value' => 7);
            $trade = $trade_model->getRow($where);
            if($trade){
                $info['data']['tid'] = $trade?$trade['t_tid']:0;
                $info['data']['desc'] = '订单状态:'.$this->order_status_desc[$trade['t_status']];
            }

            //$count = $effort_storage->fetchCountByAidMid($this->aid, $this->member['m_id']);
        }
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

    /**
     * 帖子是否收藏
     */
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

    private function _format_activity($activity){
        if($activity){
            if($this->applet_cfg['ac_type'] == 12){
                $gid = $activity['atc_id'];
                $name = $activity['atc_title'];
                $type = 1;
                $cover = $activity['atc_cover'];
                $stock = 1;
                $detail = $activity['atc_content'];
                $independent = 0;
            }else{
                $gid = $activity['g_id'];
                $name = $activity['g_name'];
                $type = $activity['g_knowledge_pay_type']?$activity['g_knowledge_pay_type']:$activity['g_type'];
                $cover = $activity['g_cover'];
                $stock = $activity['ba_goods_stock'] > 0? ($activity['ba_goods_stock'] - $activity['ba_buy_num']) :$activity['g_stock'];
                $detail = $activity['g_detail'];
                $independent = intval($activity['g_independent_mall']);
            }

            $statusStock = $this->_fetch_status_and_stock($activity);

            $data = array(
                'id'         => $activity['ba_id'],
                'gid'        => $gid,
                'name'       => $name,
                'type'       => $type,
                'cover'      => isset($cover) ? $this->dealImagePath($cover) : '',
                'price'      => $activity['ba_kj_price_limit'],
                'oriPrice'   => $activity['ba_price'],
                'stock'      => $stock > 0 ? $stock : 0,
                'sold'       => $activity['ba_join_num'],
                'hasFormat' => false,
                'endTime'   => $activity['ba_start_time'] < time() ? $activity['ba_end_time'] : $activity['ba_start_time'], //未开始时此字段返回开始时间  方便前端
                'startTime' => $activity['ba_start_time'],
                'rule'      => plum_parse_img_path($activity['ba_rule']),
                'status'    => $this->_fetch_activity_status($activity),
                'totalNum'   => $activity['g_knowledge_total'] ? $activity['g_knowledge_total'] : 0,
                'video'    => $activity['g_video_url'] ? $activity['g_video_url']:'',
                 'vrurl'    => $activity['g_vr_url'] ? $this->_judge_vrurl($activity['g_vr_url']) :'',
                 'desc'     => $activity['ba_desc'] ? $activity['ba_desc'] : '',
                 'shareImg' => $activity['ba_share_cover'] ? $this->dealImagePath($activity['ba_share_cover']) : (isset($activity['ba_image']) && $activity['ba_image'] ? $this->dealImagePath($activity['ba_image']) : $this->dealImagePath($cover)),
                'timeStatus'    => intval($statusStock['status']),
                'independent' => $independent

            );
            $data['newLabel'] = array();
            if(isset($activity['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$activity['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['newLabel'][] = $val;
                    }
                }
            }


            if($this->applet_cfg['ac_type'] == 27){//知识付费
                $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
                $data['updateNum'] = $knowpay_model->getKnowledgeCountByGid($activity['g_id']);

                $data['readNum'] = $knowpay_model->getReadNumByGid($activity['g_id']);

                $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'akc_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[] = array('name' => 'akc_c_id', 'oper' => '=', 'value' => 0);
                $where[] = array('name' => 'akc_g_id', 'oper' => '=', 'value' => $activity['g_id']);
                $data['commentCount'] = $comment_model->getCount($where);

                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $hadBuy = $order_model->getTradeByGid($activity['g_id'],$this->member['m_id']);
                $data['hadBuy'] = $hadBuy?1:0;
            }

            if($this->applet_cfg['ac_type'] == 7){
                $hotel_model = new App_Model_Hotel_MysqlHotelStoreStorage($this->sid);
                $hotelRow = $hotel_model->getRowById($activity['g_kind1']);
                $data['hotelName'] = $hotelRow['ahs_name'];
                $data['hotelId']   = $hotelRow['ahs_id'];
            }

            //未结束活动,判断是否已经到期
//            if($activity['ba_status'] != 2){
//              if($activity['ba_end_time'] < time()){
//                $data['status'] = 2;
//              }
//            }

            //根据时间重新获取状态
            if($activity['ba_start_time'] > time()){
                $data['status'] = 0;
            }elseif ($activity['ba_start_time'] < time() && $activity['ba_end_time'] > time()){
                $data['status'] = 1;
            }else{
                $data['status'] = 2;
            }

            $data['detail'] = plum_parse_img_path($detail);
            if($this->applet_cfg['ac_type'] != 12){
                $formatDataNew = $this->_get_format_value($activity['g_id'], true,$independent);
                $data['slide']  = $this->_goods_slide($activity['g_id']);
                $data['format'] = $this->_goods_format($activity['g_id'],$independent);
                $formatList = $this->_new_goods_format($activity);
                $data['formatList']  = !empty($formatList[0]['value']) ? $formatList : [];
                $data['formatValue'] = $formatDataNew['data'];
                $data['formatValueNew'] = $formatDataNew['newData'];
            }


            if(!empty($data['format']) && $data['format']){
                $data['hasFormat'] = true;
            }
            return $data;
        }
        return false;
    }

    /*
     * 帮助砍价人列表
     */
    public function bargainHelperListAction(){
        $jid    = $this->request->getIntParam('jid');
        $aid    = $this->request->getIntParam('aid');
        $page   = $this->request->getIntParam('page');
        $index = $page*$this->count;

        if(!$jid){
            $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
            $record     = $join_storage->findJoinerByAidMid($aid, $this->member['m_id']);
            $jid = $record['bj_id'];
        }

        $effort_storage = new App_Model_Bargain_MysqlEffortStorage($this->sid);
        $help_list  = $effort_storage->newFetchHelpListByJid($jid,$index,$this->count);
        $data = [];
        if($help_list){
            foreach ($help_list as $val){
                $data[] = [
                    'id'       => $val['be_id'],
                    'nickname' => $val['m_nickname'],
                    'avatar'   => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'money'    => floatval($val['be_money']),
                    'time'     => date('Y-m-d H:i:s',$val['be_help_time'])
                ];
            }

            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }

    }


    /**
     * 新的获取商品规格的方法
     */
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

    /**
     * 获取商品规格数据
     */
    private function _get_format_value($gid,$isArr=false,$independent = 0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        $newData = array();
        foreach($format as $val){
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price' => $val['gf_price'],
                'stock'  => $this->applet_cfg['ac_type'] == 7 && $independent == 0?  $val['gf_hotel_stock'] : $val['gf_stock']
            ];
            $newData[$val['gf_name'].($val['gf_name2']?'-':'').$val['gf_name2'].($val['gf_name3']?'-':'').$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price' => $val['gf_price'],
                'stock'  => $this->applet_cfg['ac_type'] == 7 && $independent == 0?  $val['gf_hotel_stock'] : $val['gf_stock']
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
    /**
     * 获取商品的幻灯
     */
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

    /**
     * 获取商品规格
     */
    private function _goods_format($gid,$independent = 0){
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
                    'stock' => $this->applet_cfg['ac_type'] == 7 && $independent == 0?  $val['gf_hotel_stock'] : $val['gf_stock'],
                    'point' => $val['gf_send_point'],
                );
            }
        }
        return $data;
    }

    /*
     * 参与活动
     */
    public function joinAction() {
        $aid = $this->request->getIntParam('aid');

        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);

        if($this->applet_cfg['ac_type'] == 12){
            $activity = $bargain_model->getCourseActivityById($aid);
        }else{
            $activity = $bargain_model->getActivityById($aid);
        }

        //非进行中的活动
//        if ($activity['ba_status'] != App_Helper_BargainActivity::BARGAIN_ACTIVITY_ONGOING) {
//            $this->outputError("活动已结束,不可参与");
//        }
        if ($activity['ba_start_time'] > time()) {
            $this->outputError("活动尚未开始,不可参与");
        }
        if ($activity['ba_end_time'] < time()) {
            $this->outputError("活动已结束,不可参与");
        }

        //是否重复参与
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $exist      = $join_storage->findJoinerByAidMid($aid, $this->member['m_id']);
        if ($exist) {
            $data['ec'] = self::FAILURE_STATUS;
            $data['em'] = "您已参与过，请勿重复参与";
            $data['jid'] = $exist['bj_id'];
            echo json_encode($data);
            die();
        }

        $indata     = array(
            'bj_s_id'       => $this->sid,
            'bj_a_id'       => $aid,
            'bj_m_id'       => $this->member['m_id'],
            'bj_m_avatar'   => $this->member['m_avatar'],
            'bj_m_nickname' => $this->member['m_nickname'],
            'bj_join_time'  => time(),
        );
        $jid = $join_storage->insertValue($indata);
        //参与成功，增加活动的参与量
        $baUpdate = array(
            'ba_join_num' => $activity['ba_join_num'] + 1
        );
        $bargain_model->updateById($baUpdate, $aid);

        $activity_redis = new App_Model_Bargain_RedisActivityStorage($this->sid);
        //设置价格分段情况
        for ($i=1; $i<4; $i++) {
            $price_key  = "ba_price_section_{$i}";
            $num_key    = "ba_num_section_{$i}";

            if ($activity[$price_key] && $activity[$num_key]) {
                $activity_redis->createPriceSection($activity[$price_key], $activity[$num_key], $i, $jid);
            }
        }
        $info['data'] = array(
            'result' => true,
            'jid'    => $jid,
            'msg'    => '参与成功',
        );
        $this->outputSuccess($info);
    }

    /*
     * 参与砍价
     */
    public function helpAction() {
        $aid = $this->request->getIntParam('aid');
        $mid = $this->request->getIntParam('mid');

        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        if($this->applet_cfg['ac_type'] == 12){
            $activity = $bargain_model->getCourseActivityById($aid);
        }else{
            $activity = $bargain_model->getActivityById($aid);
        }

        //非进行中的活动
//        if ($activity['ba_status'] != App_Helper_BargainActivity::BARGAIN_ACTIVITY_ONGOING) {
//            $this->outputError("活动已结束,不可参与砍价");
//        }
        if ($activity['ba_start_time'] > time()) {
            $this->outputError("活动尚未开始,不可参与砍价");
        }
        if ($activity['ba_end_time'] < time()) {
            $this->outputError("活动已结束,不可参与砍价");
        }
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $record     = $join_storage->findJoinerByAidMid($aid, $mid);
        if(!$record){
            $this->outputError("活动参与记录不存在");
        }
        //会员已购买,不再需要砍价
        if ($record['bj_has_buy']) {
            $this->outputError("会员{$record['bj_m_nickname']}已成功购得商品。");
        }
        //判断是否已砍价
        $effort_storage = new App_Model_Bargain_MysqlEffortStorage($this->sid);
        $helper     = $effort_storage->findHelperByJidMid($record['bj_id'], $this->member['m_id']);
        if ($helper) {
            $this->outputError("您已为亲友砍价，请勿重复砍价");
        }
        //判断砍价是否超限
        $count = $effort_storage->fetchCountByAidMid($aid, $this->member['m_id']);
        if ($count >= self::MAX_BARGAIN_NUM) {
            $this->outputError("您已为3人砍价,已超出砍价上限！");
        }
        $activity_redis = new App_Model_Bargain_RedisActivityStorage($this->sid);
        //砍价限制逻辑
        //$add    = mt_rand(10, 100);//生成1-100s随机叠加时间
        $avg = intval(($activity['ba_price'] - $activity['ba_kj_price_limit'])/($activity['ba_num_section_1'] + $activity['ba_num_section_2'] + $activity['ba_num_section_3']));
        /*if($avg>30){
            $add    = mt_rand($avg - 30, $avg - 30 + 5);//平均值
        }else{
            $add    = mt_rand(30, 35);//31-35s
        }*/
        $add    = mt_rand(5, 30);//5-35s
        $ttl    = $activity_redis->getJoinerLast($record['bj_id']);
        $threshold  = plum_parse_config('bargain_threshold');//解析出阈值
        //可正常砍价 间隔失效的,输入验证码且验证码正确的,有手机号的
        if ($ttl < $threshold[0]) {
            $limit_price    = $activity['ba_kj_price_limit'] + $record['bj_amount'];
            $diff_price     = $activity['ba_price'] - $limit_price;
            //设置下次砍价间隔时间
            $activity_redis->setJoinerLast($record['bj_id'], $add);

            if ($diff_price > 0) {
                $money  = $activity_redis->fetchRecursivePrice($record['bj_id']);
                $money = round($money,2);
                $money  = $money > $diff_price ? $diff_price : $money;//修正价格,防止超出差价
                if($money >= $diff_price){
                    // 砍到最低价，发送模板消息
                    plum_open_backend('templmsg', 'bargainCompleteTempl', array('sid' => $this->sid,'aid' => $aid, 'mid' => $record['bj_m_id'], 'type' => 'kjwc'));
                }
                $indata     = array(
                    'be_s_id'       => $this->sid,
                    'be_j_id'       => $record['bj_id'],
                    'be_a_id'       => $aid,
                    'be_m_id'       => $this->member['m_id'],
                    'be_m_avatar'   => $this->member['m_avatar'],
                    'be_m_nickname' => $this->member['m_nickname'],
                    'be_money'      => $money,
                    'be_help_time'  => time(),
                );

                $help_ret = $effort_storage->insertValue($indata);
                //增加砍价次数及金额
                $join_storage->incrementActivityAmount($record['bj_id'], $money);
                plum_open_backend('templmsg', 'bargainHelperTempl', array('sid' => $this->sid,'aid' => $aid, 'helperid' => $help_ret, 'mid' => $record['bj_m_id']));

                $info['data'] = array(
                    'result' => true,
                    'money'  => $money,
                    'self'   => $record['bj_m_id'] == $this->member['m_id']?1:0,
                    'msg'    => $record['bj_m_id'] == $this->member['m_id']?'你一出手就帮自己砍掉'.$money.'元，去试试小伙伴的功力~':'你一出手就帮朋友砍掉'.$money.'元~',
                );
                $this->outputSuccess($info);
            } else {
                $this->outputError("砍价超出限制,砍价失败");
            }
        } else {
 
            $this->outputError("砍价频率过高,请于{$ttl}秒后再试");
        }
    }

    /**
     * 我的参与
     */
    public function myJoinActivityAction(){
        $status = $this->request->getIntParam('status');  //1进行中  2已结束
        $page = $this->request->getIntParam('page');
        $index  = $this->count * $page;
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $where[] = array('name' => 'bj_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
//        $where[] = array('name' => 'ba_status', 'oper' => '=', 'value' => $status);
        if($status == 1){
            //进行中
            $where[] = array('name' => 'ba_start_time', 'oper' => '<', 'value' => time());
            $where[] = array('name' => 'ba_end_time', 'oper' => '>', 'value' => time());
        }elseif ($status == 2){
            //已结束
            $where[] = array('name' => 'ba_end_time', 'oper' => '<', 'value' => time());
        }

        $sort = array('bj_join_time' => 'desc');

        $list = $join_storage->getJoinerList($where, $index, $this->count, $sort);
        if($this->applet_cfg['ac_type'] == 12){
            $list = $join_storage->getCourseJoinerList($where, $index, $this->count, $sort);
        }else{
            $list = $join_storage->getJoinerList($where, $index, $this->count, $sort);
        }
        $info['data'] = array();
        if($list){
            foreach($list as $val){
                if($this->applet_cfg['ac_type'] == 12){
                    $cover = $val['atc_cover'];
                    $name  = $val['atc_title'];

                }else{
                    $cover = $val['g_cover'];
                    $name  = $val['g_name'];
                }

                $info['data'][] = array(
                    'id'     => $val['ba_id'],
                    'cover' => isset($val['ba_image']) && $val['ba_image'] ? $this->dealImagePath($val['ba_image']) : $this->dealImagePath($cover),
                    'name'  => $name,
                    'oriPrice' => $val['ba_price'],
                    'minPrice' => $val['ba_kj_price_limit'],
                    'sold'  => $val['ba_join_num'],
                    'avatars' => $this->_get_mem_avatar($val['ba_id'])
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    /*
     * 获得砍价活动参与人头像
     */
    private function _get_mem_avatar($aid){
      $data = [];
      $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
      $sort  = array('bj_join_time' => 'DESC');
      $field = array('bj_m_avatar');//只获取头像
      $list  = $join_storage->fetchMemberByAid($aid,0,10,$sort,$field);
      if($list){
        foreach ($list as $val){
          $data[] = $this->dealImagePath($val['bj_m_avatar']);
        }
      }
      return $data;
    }

    /*
     * 下单
     */
    public function payAction() {
        //获取活动
        $tid        = $this->request->getStrParam('tid');//获取订单id
        $order_storage  = new App_Model_Bargain_MysqlOrderStorage($this->sid);
        $order      = $order_storage->findUpdateOrderByTid($tid);
        if (!$order) {
            $this->displayJsonError("订单不存在");
        }
        $body   = $order['bo_title'];
        $amount = floatval($order['bo_amount']);
        //$amount     = 0.01;
        $attach     = array('suid' => $this->shop['s_unique_id']);
        $other      = array(
            'attach'    => json_encode($attach),
        );
        $openid     = $order['bo_buyer_openid'];

        $has_wxpay  = App_Helper_Trade::checkHasWxpay($this->sid);
        if ($has_wxpay) {//自有微信支付
            $notify_url = $this->response->responseHost().'/mobile/wxpay/bargainNotify';//回调地址
            $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id']);
            $ret        = $wx_pay->unifiedJsapiOrder($openid, $body, $tid, $amount, $notify_url, $other);
        } else {//微信支付代收
            $notify_url = $this->response->responseHost().'/mobile/fxbpay/bargainNotify';//回调地址
            $fxb_pay    = new App_Plugin_Weixin_FxbPay($this->sid);
            $ret        = $fxb_pay->unifiedJsapiOrder($openid, $body,$tid, $amount, $notify_url, $other);
        }

        if (is_array($ret)) {
            $params = array(
                'appId'     => $ret['appid'],
                'timeStamp' => strval(time()),
                'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                'package'   => "prepay_id={$ret['prepay_id']}",
                'signType'  => 'MD5',
            );
            $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
            $this->displayJsonSuccess(array('params' => $params));
        } else {
            $this->displayJsonError("微信支付发起失败");
        }
    }

    /*
     * 订单详情
     */
    public function orderAction() {
        //订单ID
        $tid    = $this->request->getStrParam('tid');

        $order_storage  = new App_Model_Bargain_MysqlOrderStorage($this->sid);
        $order  = $order_storage->findUpdateOrderByTid($tid);
        if (!$order) {
            $this->outputError("订单消失了");
        }
        $addr_storage   = new App_Model_Member_MysqlAddressStorage($this->sid);
        $address    = $addr_storage->findAddrByIDMid($order['bo_addr_id'], $this->member['m_id']);

        $info['data']['address']    = $address;
        $info['data']['order']      = $order;
        //$info['data']['activity']   = $activity;
        $this->outputSuccess($info);
    }

    /*
     * 获取活动状态
     */
//    private function _fetch_activity_status($activity){
//        $status = 0;
//        if($activity['ba_start_time']>time()){   // 未开始准备中
//            $status = 0;
//        }elseif($activity['ba_start_time']<time() && $activity['ba_end_time']>time()){   // 正在进行中
//            $status = 1;
//        }elseif($activity['ba_end_time']<time() || ($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) <= 0) || ($activity['ba_goods_stock'] = 0 && $activity['g_stock'] <= 0 && in_array($this->applet_cfg['ac_type'],[21,8,6]))){  //已结束
//            $status = 2;
//        }
//        return $status;
//    }

    private function _fetch_activity_status($activity){
        $status = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){   // 未开始准备中
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow && ((c && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) > 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] > 0 && in_array($this->applet_cfg['ac_type'],[21,8,6])))){   // 正在进行中
            $status = 1;
        }
        elseif($activity['ba_end_time']<$timeNow || ($activity['ba_goods_stock'] > 0 && ($activity['ba_goods_stock'] - $activity['ba_buy_num']) <= 0) || ($activity['ba_goods_stock'] == 0 && $activity['g_stock'] <= 0 && in_array($this->applet_cfg['ac_type'],[21,8,6]))){  //已结束
            $status = 2;
        }
        return $status;
    }

    /*
     * 获得活动时间状态和库存
     */
    private function _fetch_status_and_stock($activity){
        $status = 0;
        $stock = 0;
        $timeNow = time();
        if($activity['ba_start_time']>$timeNow){   // 未开始准备中
            $status = 0;
        }elseif($activity['ba_start_time']<$timeNow && $activity['ba_end_time']>$timeNow){   // 正在进行中
            $status = 1;
        }elseif($activity['ba_end_time']<$timeNow){  //已结束
            $status = 2;
        }
        if($activity['ba_goods_stock'] > 0){
            $stock = $activity['ba_goods_stock'] -$activity['ba_buy_num'];
        }else{
            $stock =  $activity['g_stock'];
        }

        $data = [
            'status' => $status,
            'stock'  => $stock
        ];

        return $data;
    }
}
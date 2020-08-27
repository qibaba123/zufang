<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/17
 * Time: 上午：11：30
 * 微同城需要授权的相关接口
 */

class App_Controller_Applet_CommunityAuthController extends App_Controller_Applet_InitController {

    // 订单状态
    private $order_shop_status_desc = array(
        App_Helper_Trade::TRADE_NO_PAY      => '待付款',
        App_Helper_Trade::TRADE_HAD_PAY     => '待使用',
        App_Helper_Trade::TRADE_FINISH      => '已完成',
        App_Helper_Trade::TRADE_CLOSED      => '已关闭',
        App_Helper_Trade::TRADE_REFUND      => '已退款',
    );

    private $order_status_desc = array(
        App_Helper_Trade::TRADE_NO_PAY      => '待付款',
        App_Helper_Trade::TRADE_WAIT_GROUP  => '待成团',
        App_Helper_Trade::TRADE_HAD_PAY     => '待发货',
        App_Helper_Trade::TRADE_SHIP        => '待收货',
        App_Helper_Trade::TRADE_FINISH      => '已完成',
        App_Helper_Trade::TRADE_CLOSED      => '已关闭',
        App_Helper_Trade::TRADE_REFUND      => '已退款',
    );

    public function __construct() {
        parent::__construct();
    }
    /**
     * 店铺详情
     */
    public function shopDetailAction(){
        $id  = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        if($mid){
            //处理分享动作
            $this->_deal_share($mid, 0);
        }
        $slideInfo = $this->_get_slide_list($id);

        $category  = $this->_get_cate_list($id); //商品分类
        if($this->appletType ==4) {//头条抖音
            $allCategory = [
                'id' => 0,
                'name' => '全部',
                'cover' => $this->dealImagePath('/public/manage/editshop/images/icon/style1/color0/icon_allgoods.png'),
            ];
            array_unshift($category, $allCategory);

            if(count($category) < 4) {
                $category = [];
            }
            
        }
        $cart_model  = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $cartNum     = $cart_model->getCartSum($this->member['m_id'],0,$id);

        $info['data'] = array(
            'shop'     => $this->_get_shop_info($id),
            'slide'    => $slideInfo['images'],
            'slideTrue'=> $slideInfo['imagesTrue'],
            'slideSize'=> $slideInfo['imagesSize'],   // true 则表示新尺寸高度为400，false则表示原来的尺寸高度为300
            'category' => $category,
            'newCategory' => $this->_get_new_cate_list($id),
            'notice'   => $this->_get_notice_list($id),
            'goods'    => $this->_get_goods_list($id),
            'comment'  => $this->_get_comment_list($id, 0, 0, 2),
            'storeList'=> $this->_get_store_list($id),
            'free'     => $this->_get_free_cfg($id), //免费预约配置
            'cartNum'  => $cartNum?$cartNum:0 //购物车数量
        );
//        if($this->sid == 5741){
//            $info['data']['session'] = session_id();
//        }


        if( $info['data']['shop']){
            //判断是否已经入驻
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $userShop = $es_model->findShopByUser($this->sid,$this->member['m_id'],false);
            if($userShop){
                $info['data']['shopInfo']['myShop'] = 'yes';
                $info['data']['shopInfo']['shopStatus']=$userShop['es_handle_status'];
            }else{
                $info['data']['shopInfo']['myShop']='no';
                $info['data']['shopInfo']['shopStatus']=0;
            }

            // 增加店铺浏览量
            $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $shop_model -> addReduceShopNum($id,'show');

            //抖音 记录入驻店铺浏览
            if($this->appletType == 4){
                $this->shopVisitRecord($this->member['m_id'],$id);
            }

            $this->outputSuccess($info);
        }else{
            $this->outputError('店铺不存在');
        }
    }

    /*
     * 二手车 获得服务商发布的二手车数量
     */
//    private function _get_car_num($esId){
//        $where = [];
//        $where[] = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->sid);
//        $where[] = array('name'=>'acr_es_id','oper'=>'=','value'=>$esId);
//        $car_model = new App_Model_Car_MysqlCarResourceStorage($this->sid);
//        $count = $car_model->getCount($where);
//        return $count ? $count : 0;
//    }


    private function _get_free_cfg($id){
        $cfg_model = new App_Model_Community_MysqlCommunityFreeCfgStorage($this->sid);
        $row = $cfg_model->findupdateByEsId($id);
        //有配置且已开通
        if($row && $this->checkToolUsable('mfyy')){
            $data = array(
                'open' => intval($row['acfc_open']),
                'title' => $row['acfc_title'] ? $row['acfc_title'] : '预约',
                'activity' => $row['acfc_activity'] ? $row['acfc_activity'] : '',
                'goods' => $this->_get_free_project($id)
            );
        }else{
            $data = array(
                'open' => 0,
                'title' => '预约',
                'activity' => '',
                'goods' => []
            );
        }
        return $data;
    }

    //店铺门店
    private function _get_store_list($id){
        $store_model = new App_Model_Entershop_MysqlEnterShopStoreStorage($id);
        $storeList = $store_model->getAllListBySid();
        $data = array();
        foreach($storeList as $val){
            $data[] = array(
                'name' => $val['ess_name'],
                'addr' => $val['ess_addr'],
                'lng'  => $val['ess_lng'],
                'lat'  => $val['ess_lat'],
                'mobile' => $val['ess_contact']
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

            $shopOpen = $shop['es_business_time'] ?  $shop['es_business_time'] : '00:00';
            $shopClose = $shop['es_close_time'] ? $shop['es_close_time'] : '23:59';
            $timeArr = [];
            if($shop['es_hand_close'] == 0){
                if($shop['es_common_business_time'] || $shop['es_week'.date('w').'_business_time']){
                    $openInfo = $this->_check_shop_status($shop);
                    $openStatus  = $openInfo['openStatus'];
                    $openNote = $openInfo['openNote'];
                    $shopOpen =$openInfo['openTime'] ? $openInfo['openTime'] : '00:00';
                    $shopClose = $openInfo['openClose'] ? $openInfo['openClose'] : '23:59';
                    $timeArr = $openInfo['timeArr'];
                }else{
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
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
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
                'openTime'     => $timeArr ? implode('，',$timeArr) : $shopOpen.'-'.$shopClose,
                'openTimeStart'=> $shopOpen,
                'openTimeEnd'=> $shopClose,
                'openStatus'   => $openStatus,
                'openNote'     => $openNote,
                'carNum'       => intval($shop['ame_car_num']),
                'goodsStyle'   => $shop['es_goods_style'] > 0 ? intval($shop['es_goods_style']) : 1,
                'detail'       => plum_parse_img_path($shop['es_shop_detail']),
                'showShopDetail' => intval($shop['es_goods_detail_shop'])
            );
            if($this->appletType == 4){
                $data['closedLoop'] = 1;
                $closeStatus        = 0;
                if($shop['es_handle_status'] != 2 || $shop['es_list_show'] != 1 || $shop['es_status'] !=0){
                    $closeStatus = 1;
                }
                if($shop['es_expire_time'] < time()){
                    $closeStatus = $data['isMy'] == 1?2:1;
                }
                $data['closeStatus'] = $closeStatus;
                $data['closeNote']   = $closeStatus == 1?'当前页面已到期':'当前页面不存在';
            }
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

            // -店铺详情 抖音小程序 2019-11-07
            $shopDesc = $this->_get_enterShop_desc($shop);
//            $shopDesc['openTime'] = $data['openTime']; // 开店时间
//            $shopDesc['openTimeStart'] = $data['openTimeStart']; // 开始时间
//            $shopDesc['openTimeEnd']   = $data['openTimeEnd']; // 结束时间
            $data['shopDesc'] = $shopDesc;


            return $data;
        }
        return '';
    }


    //检查店铺状态
    private function _check_shop_status($shop){
        $openStatus  = 2;
        $openNote = '已打烊';
        $timeNow = time();
        $openTimeStr = '';
        $time_open = '';
        $time_close = '';
        $timeArr = [];
        if($shop['es_hand_close'] == 0){
            if($shop['es_week'.date('w').'_business_time']){
                $timeArr1 = json_decode($shop['es_week'.date('w').'_business_time'], true);
                foreach ($timeArr1 as $time){
                    $openTime = strtotime($time['open']);
                    $closeTime = strtotime($time['close']);

                    if($closeTime <= $openTime){
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        $timeStep_24 = $timeStep_0 + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                            $openStatus  = 1;
                            $openNote = '营业中';
                            $time_open = $time['open'];
                            $time_close = $time['close'];
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $openStatus  = 1;
                            $openNote = '营业中';
                            $time_open = $time['open'];
                            $time_close = $time['close'];
                        }
                    }

                    $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                    $timeArr[] = $time['open'].'-'.$time['close'];
                }
            }else{
                $timeArr1 = json_decode($shop['es_common_business_time'], true);
                foreach ($timeArr1 as $time){
                    $openTimeStr .= $time['open'].'-'.$time['close'].'  ';
                    $timeArr[] = $time['open'].'-'.$time['close'];
                    $openTime = strtotime($time['open']);
                    $closeTime = strtotime($time['close']);
                    if($closeTime <= $openTime){
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        $timeStep_24 = $timeStep_0 + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow && $timeNow <= $closeTime)){
                            $openStatus  = 1;
                            $openNote = '营业中';
                            $time_open = $time['open'];
                            $time_close = $time['close'];
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $openStatus  = 1;
                            $openNote = '营业中';
                            $time_open = $time['open'];
                            $time_close = $time['close'];
                        }
                    }
                }
            }
        }

        return array('openStatus' => $openStatus, 'openNote' => $openNote, 'openTime' => $openTimeStr, 'timeOpen' => $time_open, 'timeClose' => $time_close,'timeArr' => $timeArr);
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
                'handClose' => intval($shop['es_hand_close']),
                'showShopDetail' => intval($shop['es_goods_detail_shop'])
            );
        }
        return $data;
    }



    //格式化幻灯数据
    private function _get_slide_list($id){
        $slide_model = new App_Model_Entershop_MysqlEnterShopSlideStorage($id);
        $slide    = $slide_model->getSlideList();
        $data = array();
        $data['imagesSize'] = false;
        if($slide && !empty($slide)){
            foreach($slide as $val){
                $data['images'][] = $this->dealImagePath($val['ess_path']);
                $data['imagesTrue'][] =$val['ess_path'];
                $size = getimagesize($this->dealImagePath($val['ess_path']));
                if($size[1]==400){
                    $data['imagesSize'] = true;
                }
            }
        }else{
            if($this->applet_cfg['ac_type'] == 33){
                $data['images'] = [];
                $data['imagesTrue'] = [];
            }else{
                $data['images'][] = $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_75_30.png');
                $data['imagesTrue'][] = '/public/manage/img/zhanwei/zw_fxb_75_30.png';
            }

        }
        return $data;
    }

    //格式化分类数据
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

    //格式化分类数据
    private function _get_new_cate_list($id){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getRowByIdMemberExtra($id);
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage($id);
        $cateList = $category_model->getListBySid();
        $cfg_model = new App_Model_Community_MysqlCommunityFreeCfgStorage($this->sid);
        $row = $cfg_model->findupdateByEsId($id);

        $data = array();

        if($shop['es_limit_open']){
            $data[] = array(
                'id'   => 'limit',
                'name' => '秒杀活动',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/limit-icon.png')
            );
        }

        if($shop['es_group_open']){
            $data[] = array(
                'id'   => 'group',
                'name' => '拼团活动',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/group-icon.png')
            );
        }

        if($shop['es_bargain_open']){
            $data[] = array(
                'id'   => 'bargain',
                'name' => '砍价活动',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/bargain-icon.png')
            );
        }

        if($shop['es_isbuy']){
            $data[] = array(
                'id'   => 'buy',
                'name' => '优惠买单',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/buy-icon.png')
            );
        }

        if($row['acfc_open']){
            $data[] = array(
                'id'   => 'free',
                'name' => '预约',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/free-icon.png')
            );
        }

        if($shop['es_queue_open']){
            $data[] = array(
                'id'   => 'queue',
                'name' => '排号',
                'cover' => $this->dealImagePath('/public/wxapp/meal/images/queue.png')
            );
        }

        foreach($cateList as $val){
            $data[] = array(
                'id'   => $val['esgc_id'],
                'name' => $val['esgc_name'],
                'cover' => $this->dealImagePath($val['esgc_logo'])
            );
        }
        return $data;
    }

    //格式化公告数据
    private function _get_notice_list($id){
        $notice_model   = new App_Model_Entershop_MysqlEnterShopNoticeStorage($id);
        $notice   = $notice_model->getListBySid();
        $data = array();
        foreach($notice as $val){
            $data[] = $val['esn_title'];
        }
        return $data;
    }

    public function shopGoodsListAction(){
        $esId = $this->request->getIntParam('esId');
        $page = $this->request->getIntParam('page');
        $this->count = 15;
        $index = $page * $this->count;
        $data = $this->_get_goods_list($esId,$this->count,$index);
        if($data){
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有更多信息了');
        }
    }


    //格式化商品数据
    private function _get_goods_list($id,$count = 15,$index = 0){
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $sort = array('g_is_top'=>'DESC','g_weight' => 'DESC','g_update_time'=>'DESC');
        $goods    = $goods_model->fetchEnterShopGoodsList($id, $index, $count, 0, $sort,0,array());
        $data = array();
        foreach($goods as $key => $val){
            $data[] = array(
                'id'   => $val['g_id'],
                'name' => $val['g_name'],
                'cover' => $this->dealImagePath($val['g_cover']),
                'price' => floatval($val['g_price']),
                'vipPrice' => $this->_get_vip_price($val),
                'oriPrice' => floatval($val['g_ori_price']),
                'sold'        => $val['g_sold'],
                'stock'    => $val['g_stock'] > 0 ? $val['g_stock'] : 0,
                'isDiscuss'   => intval($val['g_is_discuss']),
                'listLabel'  => $val['g_list_label'] ? $val['g_list_label'] : '',
                'showVipList'=> $goods['g_show_vip'],
                'discussInfo'=> isset($val['g_discuss_info']) ? $val['g_discuss_info'] : '',
                'description'=> '爆款推荐 TOP'. ($key+1),
            );
        }
        return $data;
    }

    //获取vip价的价格区间
    private function _get_vip_price($goods){
        if(!$goods['g_had_vip_price']){
            $goodsJoinDiscount = $goods['g_join_discount'];
            if($goods['g_es_id']){
                $shop_storage  = new App_Model_Entershop_MysqlEnterShopStorage();
                $enterShop = $shop_storage->getRowById($goods['g_es_id']);
                $goodsJoinDiscount = $enterShop['es_goods_join_discount'];
            }
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getListBySid($this->sid);
            if($level && $goodsJoinDiscount){
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
                $format         = $format_model->getListByGid($goods['g_id']);
                if($format){
                    foreach ($level as  $value){
                        foreach ($format as $row){
                            $priceArr[] = number_format( $row['gf_price']* ($value['ml_discount']/10), 2, ".", "");
                        }
                    }
                }else{
                    foreach ($level as  $value){
                        if($value['ml_discount']){
                            $priceArr[] = number_format( $goods['g_price']* ($value['ml_discount']/10), 2, ".", "");
                        }
                    }
                }
                $minPrice = min($priceArr);
                //return $minPrice;
                $maxPrice = max($priceArr);

                if($minPrice && $maxPrice && $minPrice != $maxPrice){
                    return $minPrice.'-'.$maxPrice;
                }else{
                    return $minPrice ? $minPrice : 0;
                }
            }else{
                return 0;
            }

        }else{
            $priceArr = array();
            $vipPrice = json_decode($goods['g_vip_price_list'], true);
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
                        $priceArr[] = $val['price']?$val['price']:$row['gf_price'];
                    }
                }
            }

            $minPrice = min($priceArr);
            //return $minPrice;
            $maxPrice = max($priceArr);

            if($minPrice && $maxPrice && $minPrice != $maxPrice){
                return $minPrice.'-'.$maxPrice;
            }else{
                return $minPrice ? $minPrice : 0;
            }
        }
    }


    //格式化评论数据
    private function _get_comment_list($id, $gid=0, $index, $count){
        $comment_model  = new App_Model_Goods_MysqlCommentStorage($this->sid);
        $comment  = $comment_model->getEnterShopCommentList($id, $gid, $index, $count);
        $data = array();
        $score_desc = plum_parse_config('community_score_desc', 'system');
        foreach($comment as $val){
            $images = array();
            $commentImg = json_decode($val['gc_comment_img'], true);
            if($commentImg){
                foreach($commentImg as $v){
                    $images[] = $this->dealImagePath($v);
                }
            }
            $data[] = array(
                'id' => $val['gc_id'],
                'nickname' => $val['m_nickname'],
                'avatar' => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'content' => $val['gc_content'],
                'star'    => $val['gc_star'],
                'starDesc' => $score_desc[intval($val['gc_star'])],
                'images' => $images,
                'time' => date('Y-m-d', $val['gc_create_time'])
            );
        }
        return $data;
    }

    /**
     * 商家入驻
     */
    public function submitApplyAction(){
        $name      = $this->request->getStrParam('name');    // 店铺名称
        $contacts  = $this->request->getStrParam('contacts');  // 负责人
        $mobile    = $this->request->getIntParam('mobile');   // 联系电话
        $address   = $this->request->getStrParam('address');      // 地址
        $lng       = $this->request->getStrParam('lng');     // 经度
        $lat       = $this->request->getStrParam('lat');     // 纬度
        $detail    = $this->request->getStrParam('detail');     // 地址详情
        $cate1     = $this->request->getIntParam('cate1');  // 店铺分类id 1级分类
        $cate2     = $this->request->getIntParam('cate2');  // 店铺分类id  2级分类
        $district1 = $this->request->getIntParam('district1');  // 所属商圈id 1级
        $district2 = $this->request->getIntParam('district2');  // 所属商圈id 2级
        $license   = $this->request->getStrParam('license');    // 营业执照
        $costId    = $this->request->getIntParam('costId');    //费用id
        $vrurl     = $this->request->getStrParam('vrurl','');
        $status    = $this->request->getIntParam('status',0);
        $id        = $this->request->getIntParam('id',0);

        $shopType  = $this->request->getIntParam('shopType');
        $prov      = $this->request->getIntParam('prov');
        $city      = $this->request->getIntParam('city');
        $zone      = $this->request->getIntParam('zone');

        $cardFront = $this->request->getStrParam('cardFront');
        $cardBack = $this->request->getStrParam('cardBack');
        $reservePhone = $this->request->getStrParam('reservePhone');
        $inviteCode = $this->request->getStrParam('inviteCode');

        if($mobile){
            if(mb_strlen($mobile)<7){
                $this->outputError('请填写正确的手机号或固话');
            }
        }
        //$apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->sid);
        $apply_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);

        //验证手机号是否存在管理员
            //  enter_shop_manager
        $manage_model = new App_Model_Entershop_MysqlManagerStorage();
        $has_manager = $manage_model->findManagerByMobile($mobile);
        if ($has_manager) {
            $this->outputError('手机号或固话已被使用');
        }
        //  验证手机号是否已经申请
        $has_apply = $apply_model->findRowByMobile($mobile);
        if ($has_apply) {
            $this->outputError('手机号或固话已被使用');
        }
        //新增判断商户名称是否已经被占用
        $has_name  = $apply_model->findRowByName($name);
        if($has_name){
            $this->outputError('店铺名称已被使用，请重新填写');
        }


        $provName = '';
        $cityName = '';
        $zoneName = '';
        if($prov>0 && $city>0 && $zone>0){
            $address_model = new App_Model_Address_MysqlAddressCoreStorage();
            $provName = $address_model->getRowById($prov)['region_name'];
            $cityName = $address_model->getRowById($city)['region_name'];
            $zoneName = $address_model->getRowById($zone)['region_name'];
        }


        //验证会员是否已经入驻
//        $has_shop = $apply_model->findRowByMid($this->member['m_id']);
//        if($has_shop){
//            $this->outputError('您已申请入驻，请勿重复申请');
//        }

        $cost_model = new App_Model_Community_MysqlCommunityEnterCostStorage($this->sid);
        $cost  = $cost_model->getRowById($costId);

        $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
        $category = $category_model->getAllSonCategorySelect(0,0);

        if($name && $contacts && $mobile && $address && $cate1 && $cate2){
            if($id){ //修改
                if($status == 2){

                //通过后修改  enter_shop
                    $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);

                    $data = array(
                        'es_name'       => $name,
                        'es_contact'    => $contacts,
                        'es_mobile'     => $mobile,
                        'es_vr_url'     => $vrurl,
                        'es_addr'       => $address,
                        'es_lng'        => $lng,
                        'es_lat'        => $lat,
                        'es_addr_detail'=> $detail,
                        'es_cate2'      => $cate2,
                        'es_cate2_name' => $category[$cate2],
                        'es_district1'  => $district1,
                        'es_district2'  => $district2,
                        'es_card_front' => $cardFront,
                        'es_card_back'  => $cardBack,
                        'es_prov'       => $prov,
                        'es_city'       => $city,
                        'es_zone'       => $zone,
                        'es_prov_name'  => $provName,
                        'es_city_name'  => $cityName,
                        'es_zone_name'  => $zoneName,
                        'es_reserve_phone' => $reservePhone,
                        'es_invite_code' => $inviteCode
                    );
                    $ret = $es_model->updateById($data,$id);
                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '修改成功'
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('修改失败');
                    }

                }elseif($status == 3){
                //未通过修改  shop_apply
                    $data = array(
                        'es_m_id'        => $this->member['m_id'],
                        'es_s_id'        => $this->sid,
                        'es_cate1'       => $cate1,
                        'es_cate2'       => $cate2,
                        'es_cate2_name'  => $category[$cate2],
                        'es_district1'   => $district1,
                        'es_district2'   => $district2,
                        'es_name'   => $name,
                        'es_contact'    => $contacts,
                        'es_phone'      => $mobile,
                        'es_addr'         => $address,
                        'es_lng'          => $lng,
                        'es_lat'          => $lat,
                        'es_addr_detail' => $detail,
                        'es_license'     => $license,
                        'es_handle_status'       => 1, //重新将状态改为审核中
                        'es_createtime' => time(),
                        'es_vr_url'       => $vrurl,
                        'es_card_front' => $cardFront,
                        'es_card_back'  => $cardBack,
                        'es_prov'       => $prov,
                        'es_city'       => $city,
                        'es_zone'       => $zone,
                        'es_prov_name'  => $provName,
                        'es_city_name'  => $cityName,
                        'es_zone_name'  => $zoneName,
                        'es_reserve_phone' => $reservePhone,
                        'es_invite_code' => $inviteCode
                    );
                    $ret = $apply_model->updateValue($data,$id);
                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '提交成功，请等待管理员审核'
                        );
                    $this->outputSuccess($info);
                    }else{
                        $this->outputError('提交失败');
                    }

                }elseif ($status == 1){
                    //审核中修改 shop_apply
                    $data = array(
                        'es_m_id'        => $this->member['m_id'],
                        'es_s_id'        => $this->sid,
                        'es_cate1'       => $cate1,
                        'es_cate2'       => $cate2,
                        'es_cate2_name'  => $category[$cate2],
                        'es_district1'   => $district1,
                        'es_district2'   => $district2,
                        'es_name'   => $name,
                        'es_contact'    => $contacts,
                        'es_phone'      => $mobile,
                        'es_addr'         => $address,
                        'es_lng'          => $lng,
                        'es_lat'          => $lat,
                        'es_addr_detail' => $detail,
                        'es_license'     => $license,
                        'es_createtime' => time(),
                        'es_vr_url'       => $vrurl,
                        'es_card_front' => $cardFront,
                        'es_card_back'  => $cardBack,
                        'es_prov'       => $prov,
                        'es_city'       => $city,
                        'es_zone'       => $zone,
                        'es_prov_name'  => $provName,
                        'es_city_name'  => $cityName,
                        'es_zone_name'  => $zoneName,
                        'es_reserve_phone' => $reservePhone,
                        'es_invite_code' => $inviteCode
                    );
                   $ret = $apply_model->updateValue($data,$id);
                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '提交成功，请等待管理员审核'
                        );
                    $this->outputSuccess($info);
                    }else{
                        $this->outputError('提交失败');
                    }
                }
            }else{
                $data = array(
                    'es_m_id'        => $this->member['m_id'],
                    'es_unique_id'   => plum_uniqid_base36(),
                    'es_s_id'        => $this->sid,
                    'es_cate1'       => $cate1,
                    'es_cate2'       => $cate2,
                    'es_cate2_name'  => $category[$cate2],
                    'es_district1'   => $district1,
                    'es_district2'   => $district2,
                    'es_name'        => $name,
                    'es_contact'    => $contacts,
                    'es_phone'      => $mobile,
                    'es_addr'         => $address,
                    'es_lng'          => $lng,
                    'es_lat'          => $lat,
                    'es_addr_detail' => $detail,
                    'es_license'     => $license,
                    'es_days'         => $cost['acec_date'],
                    'es_handle_status'       => 0,
                    'es_createtime' => time(),
                    'es_vr_url'       => $vrurl,
                    'es_card_front' => $cardFront,
                    'es_card_back'  => $cardBack,
                    'es_prov'       => $prov,
                    'es_city'       => $city,
                    'es_zone'       => $zone,
                    'es_prov_name'  => $provName,
                    'es_city_name'  => $cityName,
                    'es_zone_name'  => $zoneName,
                    'es_reserve_phone' => $reservePhone,
                    'es_invite_code' => $inviteCode,
                    'es_add_from'   => $this->appletType ? $this->appletType : 1
                );
                if($cost && $cost['acec_cost']==0){
                    $data['es_handle_status'] = 1;
                    $data['es_pay_time'] = time();
                }
                if($this->appletType == 4){
                    $data['es_shop_number'] = plum_random_code(5);
                    $data['es_shop_type'] = $shopType;
                }

                $ret = $apply_model->insertValue($data);
                if($ret){
                    $notice_model = new App_Helper_JiguangPush($this->sid);
                    $notice_model->pushNotice($notice_model::LEAVING_SHOP_ENTER,$ret);
                    //短信通知入驻申请
                    $sms_helper = new App_Helper_Sms($this->sid);
                    $sms_helper->sendNoticeSms(array(), 'xcxsqrz',$this->applet_cfg['ac_name']);
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '提交成功，请等待管理员审核'
                    );

                    if($cost && $cost['acec_cost'] > 0){
                        // 生成订单编号
                        $tid = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                        $record = $apply_model->findUpdateByNumber($tid);
                        // 如果订单号存在则重新生成
                        if($record){
                            $tid = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                        }
                        // 保存帖子的订单编号
                        $apply_model->updateById(array('es_number'=>$tid),$ret);
                        // 支付置顶费用
                        $pay = $this->_post_top_pay($cost['acec_cost'], $tid);
                        $info['data']['payMsg'] = $pay['msg'];
                        $info['data']['params'] = $pay['dataArray'];
                    }
                    $this->outputSuccess($info);
                }
            }
        }else{
            $this->outputError('请将信息填写完整再发布');
        }
    }
    /**
     * 抖音多店-先保存记录再支付
     */
    public function createEnterShopApplyAction(){
        $name      = $this->request->getStrParam('name');    // 店铺名称
        $contacts  = $this->request->getStrParam('contacts');  // 负责人
        $mobile    = $this->request->getIntParam('mobile');   // 联系电话
        $address   = $this->request->getStrParam('address');      // 地址
        $lng       = $this->request->getStrParam('lng');     // 经度
        $lat       = $this->request->getStrParam('lat');     // 纬度
        $detail    = $this->request->getStrParam('detail');     // 地址详情
        $cate1     = $this->request->getIntParam('cate1');  // 店铺分类id 1级分类
        $cate2     = $this->request->getIntParam('cate2');  // 店铺分类id  2级分类
        $district1 = $this->request->getIntParam('district1');  // 所属商圈id 1级
        $district2 = $this->request->getIntParam('district2');  // 所属商圈id 2级
        $license   = $this->request->getStrParam('license');    // 营业执照
        $costId    = $this->request->getIntParam('costId');    //费用id
        $vrurl     = $this->request->getStrParam('vrurl','');
        //$number    = $this->request->getStrParam('number');
        $cardFront = $this->request->getStrParam('cardFront');
        $cardBack  = $this->request->getStrParam('cardBack');
        $shopType  = $this->request->getIntParam('shopType');
        $prov      = $this->request->getIntParam('prov');
        $city      = $this->request->getIntParam('city');
        $zone      = $this->request->getIntParam('zone');
        $reservePhone = $this->request->getStrParam('reservePhone');
        $inviteCode   = $this->request->getStrParam('inviteCode');
        $appid        = $this->request->getStrParam('appid');
        $payType      = $this->request->getIntParam('payType',1); //支付方式  1在线支付  3余额支付
        //$appletType   = $this->request->getIntParam('appletType');

        $provName = '';
        $cityName = '';
        $zoneName = '';
        if($prov>0 && $city>0 && $zone>0){
            $address_model = new App_Model_Address_MysqlAddressCoreStorage();
            $provName = $address_model->getRowById($prov)['region_name'];
            $cityName = $address_model->getRowById($city)['region_name'];
            $zoneName = $address_model->getRowById($zone)['region_name'];
        }
        $promoter = [];
        if($inviteCode) {
            $promoter_model = new App_Model_Promoter_MysqlPromoterStorage($this->sid); // 推广员
            $promoter = $promoter_model->findRowByInvite($inviteCode);
        }
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        if($mobile){
            if(mb_strlen($mobile)<7){
                $this->outputError('请填写正确的手机号或固话');
            }
        }
        $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
        $category = $category_model->getAllSonCategorySelect(0,0);
        if($name && $contacts && $mobile && $address && $cate1 && $cate2){
            $has_shop = $es_model->findShopByUser($this->sid,$this->member['m_id'],false);
            if($has_shop){
                $this->outputError('您已申请入驻，请勿重复申请');
            }
            //支付配置
            $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
            $payCfg      = $pay_type->findRowPay();
            //验证是否存在管理员  enter_shop_manager
            $manage_model = new App_Model_Entershop_MysqlManagerStorage();
            $has_manager  = $manage_model->findManagerByMobile($mobile);
            if ($has_manager) {
                $this->outputError('手机号或固话已被使用');
            }
            //  验证手机号是否已经申请
            $has_apply = $es_model->findRowByMobile($mobile);
            if ($has_apply) {
                $this->outputError('手机号或固话已被使用');
            }
            $cost_model = new App_Model_Community_MysqlCommunityEnterCostStorage($this->sid);
            $cost  = $cost_model->getRowById($costId);

            //$applyDays = $payData['acap_date'] ? $payData['acap_date'] : ($cost['acec_date'] ? $cost['acec_date'] : 0); //如果有订单 优先使用订单信息
            $data = array(
                'es_m_id'          => $this->member['m_id'],
                'es_unique_id'     => plum_uniqid_base36(),
                'es_s_id'          => $this->sid,
                'es_cate1'         => $cate1,
                'es_cate2'         => $cate2,
                'es_cate2_name'    => $category[$cate2],
                'es_district1'     => $district1,
                'es_district2'     => $district2,
                'es_name'          => $name,
                'es_contact'       => $contacts,
                'es_phone'         => $mobile,
                'es_addr'          => $address,
                'es_lng'           => $lng,
                'es_lat'           => $lat,
                'es_addr_detail'   => $detail ? $detail : '',
                'es_license'       => $license,
                //'es_days'          => $applyDays,
                'es_handle_status' => 1,
                'es_createtime'    => time(),
                'es_vr_url'        => $vrurl ? $vrurl : '',
                //'es_pay_time'      => $payData['acap_create_time'] ? $payData['acap_create_time'] : time(),
                //'es_number'        => $number ? $number : '',
                'es_card_front'    => $cardFront,
                'es_card_back'     => $cardBack,
                'es_prov'          => $prov,
                'es_city'          => $city,
                'es_zone'          => $zone,
                'es_prov_name'     => $provName,
                'es_city_name'     => $cityName,
                'es_zone_name'     => $zoneName,
                'es_reserve_phone' => $reservePhone,
                'es_invite_code'   => $inviteCode,
                'es_add_from'      => $this->appletType ? $this->appletType : 1,
                'es_promoter_id'   => $promoter['ap_id'] ? $promoter['ap_id'] : 0, // 推广员id
            );
            if($this->appletType == 4){
                $data['es_shop_number'] = plum_random_code(5);
                $data['es_shop_type'] = $shopType;
            }
            $enterShopData = $data;
            if($payType == 1){
                $apply_model = new App_Model_Entershop_MysqlEnterShopApplyStorage($this->sid);
                //$exit        = $apply_model->getApplyDataByMid($this->member['m_id']);
                $insertData = array(
                    'esa_s_id'  => $this->sid,
                    'esa_m_id'  => $this->member['m_id'],
                    'esa_p_id'  => $costId,
                    'esa_extra' => json_encode($data),
                    'esa_create_time' => time()
                );
                $ret            = $apply_model->insertValue($insertData);
                if($ret){
                    $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCommunityApplyPayDy';//回调地址
                    $acount     = 0;
                    $acount    += $cost['acec_cost'];
                    $openid     = $this->member['m_openid'];
                    $bodyNote   = '支付入驻费用';
                    $body   = $bodyNote;
                    $attach = array(
                        'suid'       => $this->shop['s_unique_id'],
                        'mid'        => $this->member['m_id'],
                        'costId'     => $costId,
                        'costDate'   => $cost['acec_date'],
                        'appid'      => $appid,
                        'applyId'    => $ret
                        //'appletType' => 'toutiao'
                    );
                    $number        = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                    // 获取超时关闭时间
                    $over_time     = plum_parse_config('trade_overtime');
                    $overTime      = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                    $pay_storage   = new App_Plugin_Toutiao_Pay($this->sid);
                    $result        = $pay_storage->appletOrderPayRecharge($acount, $openid, $number, $alipay_notify_url, $body, time(), $overTime, $attach);
                    if (is_array($result) && !$result['code']) {
                        $dealTitle = '店铺入驻';
                        $params = array(
                            'merchant_id'       => $result['biz_content']['merchant_id'],
                            'app_id'            => $result['appid'],
                            'sign_type'         => 'MD5',
                            'timestamp'         => $result['timestamp'],
                            'product_code'      => 'pay',
                            'payment_type'      => 'direct',
                            'out_order_no'      => $result['trade_no'],
                            'uid'               => $result['uid'],
                            'total_amount'      => $result['biz_content']['total_amount'],
                            'currency'          => 'CNY',
                            'subject'           => $dealTitle,
                            'body'              => $dealTitle,
                            'trade_time'        => time(),
                            'valid_time'        => 1800,
                            'notify_url'        => plum_get_base_host(),
                            'alipay_url'        => $result['params_url'],
                            'wx_url'            => '',//$result['wxinfo'] && $result['wxinfo']['mweb_url'] ? $result['wxinfo']['mweb_url'] : '',
                            'version'           => '2.0',
                        );
                        if($params['wx_url'] && $result['wxinfo'] && $result['wxinfo']['trade_type']){
                            $params['wx_type'] = $result['wxinfo']['trade_type'];
                        }
                        $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                        $params['risk_info']   = $result['biz_content']['risk_info'];
                        $params['service']     = 1;
                        $info['data'] = array(
                            'result' => true,
                            'number' => $number,
                            'params' => $params,
                        );

                        $this->outputSuccess($info);
                    } else{
                        $this->outputError('支付错误，请稍后重试');
                    }
                }
            }else{

                $number      = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);

                if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                    $this->outputError('该商户暂未开启余额支付');
                }
                //判断账户余额是否冻结
                if($this->member['m_gold_freeze']){
                    $this->outputError('账户已被冻结，请联系管理员');
                }
                $acount = 0;
                if($cost && $cost['acec_cost'] > 0) {
                    $acount += $cost['acec_cost'];

                    //判断会员余额是否足够支付
                    $coin = floatval($this->member['m_gold_coin']);
                    $fee = floatval($acount);    //支付总费用
                    if ($fee > $coin) {
                        $this->outputError("账户余额不足");
                    }
                    $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->shop['s_id']);
                    $record = $pay_model->findUpdateByNumber($number);
                    // 如果订单号存在则重新生成一个
                    if ($record) {
                        $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                    }
                    //减少会员金币
                    $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                    // 记录使用记录
                    App_Helper_MemberLevel::rechargeRecord($this->sid, $number, $this->member['m_id'], $fee);
                    if ($debit) {
                        $data = [
                            'acap_s_id' => $this->shop['s_id'],
                            'acap_number' => $number,
                            'acap_create_time' => time(),
                            'acap_date' => isset($cost['acec_date']) && $cost['acec_date'] ? $cost['acec_date'] : 0,
                            'acap_money' => $fee,
                            'acap_pay_type' => 3 // 余额支付
                        ];
                        $ret = $pay_model->insertValue($data);
                        if ($ret) {
                            $enterShopData['es_days']     = $data['acap_date'];
                            $enterShopData['es_pay_time'] = $data['acap_create_time'];
                            $enterShopData['es_number']   = $number;
                            $enter_model = new App_Model_Entershop_MysqlEnterShopStorage($this->shop['s_id']);
                            $enter_model->insertValue($enterShopData);
                            $info['data'] = [
                                'result' => TRUE,
                                'number' => $number,
                                'msg' => '支付成功',
                                'params' => '',
                            ];
                            $this->outputSuccess($info);
                        }
                        else {
                            $this->outputError('支付错误，请稍后重试...');
                        }
                    }
                    else {
                        $this->outputError('支付错误，请稍后重试..');
                    }
                }else{
                    $this->outputError('支付错误，请稍后重试.');
                }
            }
        }else{
            $this->outputError('请将信息填写完再提交申请');
        }
    }

    /**
     * 抖音多店续费
     */
    public function createShopRenewAction(){
        $costId    = $this->request->getIntParam('costId');
        $payType   = $this->request->getIntParam('payType');
        $appid     = $this->request->getStrParam('appid');
        $esId      = $this->request->getIntParam('esId');
        $es_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $enterShop    = $es_model->getRowById($esId);
        if(!$enterShop){
            $this->outputError('请选择付费门店');
        }
        // 支付配置
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payCfg      = $pay_type->findRowPay();
        // 生成订单编号
        $number      = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
        //获取费用配置
        $cost_model  = new App_Model_Community_MysqlCommunityEnterCostStorage($this->sid);
        $cost = $cost_model->getRowById($costId);
        if($payType == 1){
            $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCommunityApplyPayDy';//回调地址
            $acount = 0;
            $acount += $cost['acec_cost'];

            $openid = $this->member['m_openid'];
            $body   = '支付续费费用';
            $attach = array(
                'suid'       => $this->shop['s_unique_id'],
                'mid'        => $this->member['m_id'],
                'costId'     => $costId,
                'costDate'   => $cost['acec_date'],
                'appid'      => $appid,
                'esId'       => $esId
                //'appletType' => 'toutiao'
            );
            // 获取超时关闭时间
            $over_time     = plum_parse_config('trade_overtime');
            $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
            $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
            $result = $pay_storage->appletOrderPayRecharge($acount, $openid, $number, $alipay_notify_url, $body, time(), $overTime, $attach);
            if (is_array($result) && !$result['code']) {
                $dealTitle = '店铺续费';
                $params = array(
                    'merchant_id'       => $result['biz_content']['merchant_id'],
                    'app_id'            => $result['appid'],
                    'sign_type'         => 'MD5',
                    'timestamp'         => $result['timestamp'],
                    'product_code'      => 'pay',
                    'payment_type'      => 'direct',
                    'out_order_no'      => $result['trade_no'],
                    'uid'               => $result['uid'],
                    'total_amount'      => $result['biz_content']['total_amount'],
                    'currency'          => 'CNY',
                    'subject'           => $dealTitle,
                    'body'              => $dealTitle,
                    'trade_time'        => time(),
                    'valid_time'        => 1800,
                    'notify_url'        => plum_get_base_host(),
                    'alipay_url'        => $result['params_url'],
                    'wx_url'            => '',//$result['wxinfo'] && $result['wxinfo']['mweb_url'] ? $result['wxinfo']['mweb_url'] : '',
                    'version'           => '2.0',
                );
                if($params['wx_url'] && $result['wxinfo'] && $result['wxinfo']['trade_type']){
                    $params['wx_type'] = $result['wxinfo']['trade_type'];
                }
                $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                $params['risk_info']   = $result['biz_content']['risk_info'];
                $params['service']     = 1;
                $info['data'] = array(
                    'result' => true,
                    'number' => $number,
                    'params' => $params,
                );

                $this->outputSuccess($info);
            } else{
                $this->outputError('支付错误，请稍后重试');
            }
        }else {
            $number      = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
            if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                $this->outputError('该商户暂未开启余额支付');
            }
            //判断账户余额是否冻结
            if($this->member['m_gold_freeze']){
                $this->outputError('账户已被冻结，请联系管理员');
            }
            $acount = 0;
            if($cost && $cost['acec_cost'] > 0) {
                $acount += $cost['acec_cost'];

                //判断会员余额是否足够支付
                $coin = floatval($this->member['m_gold_coin']);
                $fee = floatval($acount);    //支付总费用
                if ($fee > $coin) {
                    $this->outputError("账户余额不足");
                }
                $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->shop['s_id']);
                $record = $pay_model->findUpdateByNumber($number);
                // 如果订单号存在则重新生成一个
                if ($record) {
                    $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                }
                //减少会员金币
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid, $number, $this->member['m_id'], $fee);
                if ($debit) {
                    $data = [
                        'acap_s_id' => $this->shop['s_id'],
                        'acap_number' => $number,
                        'acap_create_time' => time(),
                        'acap_date' => isset($cost['acec_date']) && $cost['acec_date'] ? $cost['acec_date'] : 0,
                        'acap_money' => $fee,
                        'acap_pay_type' => 3 // 余额支付
                    ];
                    $ret = $pay_model->insertValue($data);
                    if ($ret) {
                        $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->sid);
                        $record = $pay_model->findUpdateByNumber($number);
                        if($record){
                            $dateLong = $record['acap_date']; //单位 天
                            $expireTime = $dateLong*86400;
                            if($enterShop['es_expire_time'] > time()){
                                $set = array(
                                    'es_expire_time' => $enterShop['es_expire_time'] + $expireTime
                                );
                            }else{
                                $set = array(
                                    'es_expire_time' => time() + $expireTime
                                );
                            }
                            $ret = $es_model->updateById($set,$esId);
                            if($ret){
                                //将店铺id更新至订单
                                $pay_model->findUpdateByNumber($number,array('acap_es_id'=>$esId));

                                $info['data'] = array(
                                    'result' => true,
                                    'msg'    => '续费成功',
                                );
                                $this->outputSuccess($info);
                            }else{
                                $this->outputError('续费失败');
                            }
                        }else{
                            $this->outputError('支付错误，请重试');
                        }
                    }
                    else {
                        $this->outputError('支付错误，请稍后重试...');
                    }
                }
                else {
                    $this->outputError('支付错误，请稍后重试..');
                }
            }else{
                $this->outputError('支付错误，请稍后重试.');
            }
        }

    }










    /**
     * 新商家入驻
     * 先支付后入驻
     */
    public function newSubmitApplyAction(){
        $name      = $this->request->getStrParam('name');    // 店铺名称
        $contacts  = $this->request->getStrParam('contacts');  // 负责人
        $mobile    = $this->request->getIntParam('mobile');   // 联系电话
        $address   = $this->request->getStrParam('address');      // 地址
        $lng       = $this->request->getStrParam('lng');     // 经度
        $lat       = $this->request->getStrParam('lat');     // 纬度
        $detail    = $this->request->getStrParam('detail');     // 地址详情
        $cate1     = $this->request->getIntParam('cate1');  // 店铺分类id 1级分类
        $cate2     = $this->request->getIntParam('cate2');  // 店铺分类id  2级分类
        $district1 = $this->request->getIntParam('district1');  // 所属商圈id 1级
        $district2 = $this->request->getIntParam('district2');  // 所属商圈id 2级
        $license   = $this->request->getStrParam('license');    // 营业执照
        $costId    = $this->request->getIntParam('costId');    //费用id
        $vrurl     = $this->request->getStrParam('vrurl','');
        $status    = $this->request->getIntParam('status',0);
        $id        = $this->request->getIntParam('id',0);
        $number    = $this->request->getStrParam('number');


        $cardFront = $this->request->getStrParam('cardFront');
        $cardBack  = $this->request->getStrParam('cardBack');
        $shopType  = $this->request->getIntParam('shopType');
        $prov      = $this->request->getIntParam('prov');
        $city      = $this->request->getIntParam('city');
        $zone      = $this->request->getIntParam('zone');
        $reservePhone = $this->request->getStrParam('reservePhone');
        $inviteCode = $this->request->getStrParam('inviteCode');

        $provName = '';
        $cityName = '';
        $zoneName = '';
        if($prov>0 && $city>0 && $zone>0){
            $address_model = new App_Model_Address_MysqlAddressCoreStorage();
            $provName = $address_model->getRowById($prov)['region_name'];
            $cityName = $address_model->getRowById($city)['region_name'];
            $zoneName = $address_model->getRowById($zone)['region_name'];
        }


        $promoter = [];
        if($inviteCode) {
            $promoter_model = new App_Model_Promoter_MysqlPromoterStorage($this->sid); // 推广员
            $promoter = $promoter_model->findRowByInvite($inviteCode);
        }

        //$apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->sid);
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        if($mobile){
            if(mb_strlen($mobile)<7){
                $this->outputError('请填写正确的手机号或固话');
            }
        }

        $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
        $category = $category_model->getAllSonCategorySelect(0,0);

        if($name && $contacts && $mobile && $address && $cate1 && $cate2){
            if($id){ //修改
                if($status == 2){

                    //通过后修改  enter_shop
                    $data = array(
                        'es_name'       => $name,
                        'es_contact'    => $contacts,
                        'es_phone'      => $mobile,
                        'es_vr_url'     => $vrurl ? $vrurl : '',
                        'es_addr'       => $address,
                        'es_lng'        => $lng,
                        'es_lat'        => $lat,
                        'es_addr_detail'=> $detail ? $detail : '',
                        'es_license'    => $license,

                        'es_district1'  => $district1,
                        'es_district2'  => $district2,
                        'es_card_front' => $cardFront,
                        'es_card_back'  => $cardBack,

                        'es_reserve_phone' => $reservePhone,

                    );
                    if($this->appletType != 4){
                        $newData = array(
                            'es_cate1'      => $cate1,
                            'es_cate2'      => $cate2,
                            'es_cate2_name' => $category[$cate2],
                            'es_prov'        => $prov,
                            'es_city'        => $city,
                            'es_zone'        => $zone,
                            'es_prov_name'   => $provName,
                            'es_city_name'   => $cityName,
                            'es_zone_name'   => $zoneName,
                            'es_invite_code' => $inviteCode
                        );
                        $data  = array_merge($data,$newData);
                    }
                    $ret = $es_model->updateById($data,$id);
                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'status' => 2,
                            'msg'    => '修改成功'
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('修改失败');
                    }

                }else{
                    //未通过或审核中修改  shop_apply
                    //验证手机号是否存在管理员
                    //  enter_shop_manager
                    $manage_model = new App_Model_Entershop_MysqlManagerStorage();
                    $has_manager = $manage_model->findManagerByMobile($mobile);
                    if ($has_manager) {
                        $this->outputError('手机号或固话已被使用');
                    }

                    $has_apply = $es_model->findRowByMobile($mobile,$this->member['m_id']);
                    if ($has_apply) {
                        $this->outputError('手机号或固话已被使用');
                    }

                    $data = array(
                        'es_m_id'        => $this->member['m_id'],
                        'es_s_id'        => $this->sid,
                        'es_cate1'       => $cate1,
                        'es_cate2'       => $cate2,
                        'es_cate2_name'    => $category[$cate2],
                        'es_district1'   => $district1,
                        'es_district2'   => $district2,
                        'es_name'   => $name,
                        'es_contact'    => $contacts,
                        'es_phone'      => $mobile,
                        'es_addr'         => $address,
                        'es_lng'          => $lng,
                        'es_lat'          => $lat,
                        'es_addr_detail' => $detail ? $detail : '',
                        'es_license'     => $license,
                        'es_handle_status'       => 1, //重新将状态改为审核中
                        'es_deleted'       => 0, //删除状态改为未删除
                        'es_createtime' => time(),
                        'es_vr_url'       => $vrurl ? $vrurl : '',
                        'es_card_front' => $cardFront,
                        'es_card_back'  => $cardBack,
                        'es_prov'       => $prov,
                        'es_city'       => $city,
                        'es_zone'       => $zone,
                        'es_prov_name'  => $provName,
                        'es_city_name'  => $cityName,
                        'es_zone_name'  => $zoneName,
                        'es_reserve_phone' => $reservePhone,
                        'es_invite_code' => $inviteCode
                    );
                    $ret = $es_model->updateById($data,$id);
                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '提交成功，请等待管理员审核',
                            'status' => 1
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('提交失败');
                    }
                }
            }else{
                //初次提交审核
                //验证是否已经申请
                $has_shop = $es_model->findShopByUser($this->sid,$this->member['m_id'],false);
                if($has_shop){
                    $this->outputError('您已申请入驻，请勿重复申请');
                }

                //验证是否存在管理员  enter_shop_manager
                $manage_model = new App_Model_Entershop_MysqlManagerStorage();
                $has_manager = $manage_model->findManagerByMobile($mobile);
                if ($has_manager) {
                    $this->outputError('手机号或固话已被使用');
                }

                //  验证手机号是否已经申请
                $has_apply = $es_model->findRowByMobile($mobile);
                if ($has_apply) {
                    $this->outputError('手机号或固话已被使用');
                }

                $cost_model = new App_Model_Community_MysqlCommunityEnterCostStorage($this->sid);
                $cost  = $cost_model->getRowById($costId);

                if($number){
                    $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->sid);
                    $payData = $pay_model->findUpdateByNumber($number);
                }

                //如果需要收费
                if($cost['acec_cost'] > 0 && !$payData){
                    $this->outputError('支付信息错误，请重试');
                }

                $applyDays = $payData['acap_date'] ? $payData['acap_date'] : ($cost['acec_date'] ? $cost['acec_date'] : 0); //如果有订单 优先使用订单信息

                $data = array(
                    'es_m_id'        => $this->member['m_id'],
                    'es_unique_id'   => plum_uniqid_base36(),
                    'es_s_id'        => $this->sid,
                    'es_cate1'       => $cate1,
                    'es_cate2'       => $cate2,
                    'es_cate2_name'  => $category[$cate2],
                    'es_district1'   => $district1,
                    'es_district2'   => $district2,
                    'es_name'   => $name,
                    'es_contact'    => $contacts,
                    'es_phone'      => $mobile,
                    'es_addr'         => $address,
                    'es_lng'          => $lng,
                    'es_lat'          => $lat,
                    'es_addr_detail' => $detail ? $detail : '',
                    'es_license'     => $license,
                    'es_days'         => $applyDays,
                    //'es_days_desc'    => '',
                    'es_handle_status'       => 1,
                    'es_createtime' => time(),
                    'es_vr_url'       => $vrurl ? $vrurl : '',
                    'es_pay_time'     => $payData['acap_create_time'] ? $payData['acap_create_time'] : time(),
                    'es_number'       => $number ? $number : '',
                    'es_card_front' => $cardFront,
                    'es_card_back'  => $cardBack,
                    'es_prov'       => $prov,
                    'es_city'       => $city,
                    'es_zone'       => $zone,
                    'es_prov_name'  => $provName,
                    'es_city_name'  => $cityName,
                    'es_zone_name'  => $zoneName,
                    'es_reserve_phone' => $reservePhone,
                    'es_invite_code' => $inviteCode,
                    'es_add_from'   => $this->appletType ? $this->appletType : 1,
                    'es_promoter_id' => $promoter['ap_id'] ? $promoter['ap_id'] : 0, // 推广员id
                );

                if($this->appletType == 4){
                    $data['es_shop_number'] = plum_random_code(5);
                    $data['es_shop_type'] = $shopType;
                }

                $ret = $es_model->insertValue($data);
                if($ret){
                    $notice_model = new App_Helper_JiguangPush($this->sid);
                    $notice_model->pushNotice($notice_model::LEAVING_SHOP_ENTER,$ret);
                    $message_helper = new App_Helper_ShopMessage($this->sid);
                    $message['name'] = $data['es_name'];
                    $message['id'] = $ret;
                    $message_helper->messageRecord($message_helper::LEAVING_SHOP_ENTER,$message);
                    //短信通知入驻申请
                    $sms_helper = new App_Helper_Sms($this->sid);
                    $sms_helper->sendNoticeSms(array(), 'xcxsqrz',$this->applet_cfg['ac_name']);
                    $info['data'] = array(
                        'result' => true,
                        'status' => 1,
                        'msg'    => '提交成功，请等待管理员审核'
                    );
                    //将门店id更新至订单
                    $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->sid);
                    $pay_model->findUpdateByNumber($number,array('acap_es_id'=> $ret));

                    // 推广员 店铺数量加一
                    if($inviteCode) {
                        $promoter_model->incrementField('ap_shop_num', $promoter['ap_id'], 1);
                    }

                    if($this->appletType == 4) {
                        $trade_helper = new App_Helper_Trade($this->sid);
                        $trade_helper->_deal_enter_shop_record($number); // 商家入驻 推广员收益
                    }
                    $this->outputSuccess($info);
                }
            }
        }else{
            $this->outputError('请将信息填写完整再发布');
        }
    }
    /**
     * 选择置顶支付
     */
    private function _post_top_pay($cost, $tid){
        $pay = array(
            'dataArray' => array(),
            'msg'       => '',
        );
        //判断是否填写小程序端的微信支付配置
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if(!$appcfg){
            $pay['msg'] = '该商户暂未填写微信支付配置';
        }

        if($cost>0){
            if($tid){
                $body   = $this->shop['s_name']."商家入驻";
                $openid     = $this->member['m_openid'];
                $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCommunityApply';//回调地址
                $attach = array(
                    'suid'  => $this->shop['s_unique_id'],
                    'mid'   => $this->member['m_id'],
                );
                $other      = array(
                    'attach'    => json_encode($attach),
                );
                // 生成支付参数
                $result = $pay_storage->appletOrderPayRecharge($cost,$openid,$tid,$notify_url,$body,$other);
                if (is_array($result)) {
                    $params = array(
                        'appId'     => $result['appid'],
                        'timeStamp' => strval(time()),
                        'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                        'package'   => "prepay_id={$result['prepay_id']}",
                        'signType'  => 'MD5',
                    );
                    $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $result['app_key']);
                    $pay['dataArray'] = $params;
                } else{
                    $pay['msg'] = '支付错误，请稍后重试';
                }
            }else{
                $pay['msg'] = '支付错误，请重试';
            }
        }
        return $pay;
    }

    /**
     * 商品详情
     */
    public function goodsDetailAction(){
        $gid = $this->request->getIntParam('gid');
        $mid  = $this->request->getIntParam('mid'); //分享人id


        if($mid){
            //处理分享动作
            $this->_deal_share($mid, $gid);
        }
        if($gid){
            //获取店铺商品
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowById($gid);
            if($goods){
                $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->sid);
                $aboutUs = $about_storage->findUpdateBySid();

                $info['data'] = $this->_format_goods_details($goods,true,$aboutUs);
                if(($this->member['m_id'] && $this->member['m_id']>0)){
                    $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
                    $info['data']['cartNum'] = $cart_storage->getCartSum($this->member['m_id'],0,$goods['g_es_id']);
                }else{
                    $info['data']['cartNum'] = 0;
                }
                //获得会员卡跳转类型
                $ct_model  = new App_Model_Member_MysqlCenterToolStorage();
                $centerTool = $ct_model->findUpdateBySid($this->sid);
                $info['data']['membercardJump'] = intval($centerTool['ct_membercard_jump']);


                //抖音 记录入驻店铺浏览
                if($this->appletType == 4 && $goods['g_es_id']){
                    $this->shopVisitRecord($this->member['m_id'],$goods['g_es_id']);
                    $enter_model        = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                    $shop               = $enter_model->getRowById($goods['g_es_id']);
                    $closeStatus        = 0;
                    if($shop['es_handle_status'] != 2 || $shop['es_list_show'] != 1 || $shop['es_status'] !=0){
                        $closeStatus = 1;
                    }
                    if($shop['es_expire_time'] < time()){
                        $closeStatus = $this->member['m_id'] == $shop['es_m_id']?2:1;
                    }
                    $info['data']['closeStatus'] = $closeStatus;
                    $info['data']['closeNote']   = $closeStatus == 1?'当前页面已到期':'当前页面不存在';
                }


                $this->outputSuccess($info);
            }else{
                $this->outputError('商品不存在');
            }
        }else{
            $this->outputError('商品不存在');
        }
    }

    private function _deal_share($mid, $gid){
        $goods_deduct   = new App_Model_Goods_MysqlGoodsRatioDeductStorage($this->sid);
        $gd     = $goods_deduct->findOpenDeduct($gid);
        if($gd){
            //单品分销商品，增加单品分销的分享量
            $set = array('grd_share_num' => ($gd['grd_share_num'] + 1));
            $goods_deduct->updateById($set, $gd['grd_id']);
        }
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow['tc_isopen'] || $tcRow['tc_copartner_isopen']){
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $shareMember = $member_storage->findMemberByIdSid($mid, $this->shop['s_id']);
            if($shareMember['m_is_highest'] || $shareMember['m_1f_id']){
                $is_real_member = App_Helper_MemberLevel::isRealMember($this->shop['s_id'], $mid);
                if($is_real_member){
                    $uid    = plum_app_user_islogin();
                    $member = $member_storage->findMemberByIdSid($uid, $this->shop['s_id']);
                    if($mid != $uid && !$member['m_is_highest'] && !$member['m_1f_id']){
                        App_Helper_MemberLevel::setLevelSendMessage($this->shop['s_id'], $uid, $mid);
                    }
                }
            }
        }
    }



    /**
     * 格式化商品数据
     */
    private function _format_goods_details($goods,$detail=false,$aboutUs = array()){
        if($goods){
            $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
            $level = $offline_member->currLevel($this->member['m_id']);
            $data = array(
                'id'         => $goods['g_id'],
                'esid'       => $goods['g_es_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'vipPrice'   => $this->_get_vip_price($goods),
                'points'     => $goods['g_points'],
                'unit'       => $goods['g_unit'],
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => intval($goods['g_stock'])<0?0:intval($goods['g_stock']),
                'stockShow'  => intval($goods['g_stock_show']),
                'sold'       => intval($goods['g_sold']),
                'soldShow'   => intval($goods['g_sold_show']),
                'expfeeShow' => intval($goods['g_expfee_show']),
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'isSale'     => intval($goods['g_is_sale']),
                'isVip'      => ($this->member['m_level'] || $level)?1:0,
                'video'      => $goods['g_video_url'] ? $goods['g_video_url']:'',
                'isDiscuss'  => intval($goods['g_is_discuss']),
                'listLabel'  => $goods['g_list_label'] ? $goods['g_list_label'] : '',
                'showVipList'=> $goods['g_show_vip'],
                'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
            );

            $data['newLabel'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['newLabel'][] = $val;
                    }
                }
            }

            if($goods['g_type'] == 4){
                $data['type'] = 1;
            }elseif($goods['g_type'] == 5){
                $data['type'] = 2;
            }else{
                $data['type']=0;
            }
            if($goods['g_es_id']){
                if($this->applet_cfg['ac_type'] == 6){
                    $vipInfo = App_Helper_Trade::getGoodsVipPirce($goods['g_price'], $this->sid, $goods['g_id'], '',$this->member['m_id'],1);
                    $data['price'] = $vipInfo['price'];
                    $data['isVip'] = $vipInfo['isVip'];
                    $shop =  $this->_get_city_shop_info($goods['g_es_id']);
                }else{
                    $shop =  $this->_get_shop_info($goods['g_es_id']);
                }

                $data['shop'] = $shop;
            }else{
                $score_desc = plum_parse_config('community_score_desc', 'system');
                $data['shop'] = [
                    'id'           => 0,
                    'name'         => $this->applet_cfg['ac_name'] ? $this->applet_cfg['ac_name'] : ($this->shop['s_name'] ? $this->shop['s_name'] : $aboutUs['sa_name']),
                    'address'      => $aboutUs['sa_address'] ? $aboutUs['sa_address'] : '',
                    'lng'          => $aboutUs['sa_lng'] ? $aboutUs['sa_lng'] : '',
                    'lat'          => $aboutUs['sa_lat'] ? $aboutUs['sa_lat'] : '',
                    'mobile'       => $aboutUs['sa_mobile'] ? $aboutUs['sa_mobile'] : ($this->shop['s_phone'] ? $this->shop['s_phone'] : ''),
                    'score'        => 5,
                    'scoreDesc'    => $score_desc[5],
                    'isCollection' => '',
                    'vrurl'        => '',
                    'showNum'      => '',
                    'isbuy'        => '',
                    'handClose'    => '',
                    'label'        => '',
                    'openTime'     => '',
                    'openStatus'   => '',
                    'openNote'     => '',
                ];
            }

            // -获取商品优惠券 2019-11-06
            $coupon = $this->_get_coupon_list($goods);
            $data['coupon'] = $coupon;
            // -获取店铺销量、产品、收藏 2019-11-06
            $esId = 0;
            if($goods['g_es_id'])
                $esId = $goods['g_es_id'];
            $shopCount = $this->_get_shop_count($esId, $shop);
            $data['shopCount'] = $shopCount;
            // -商品评价 2019-11-06
            $data['comment'] = $this->_get_good_comments($goods);
            // -推荐商品 2019-11-06
            $data['recommend'] = $this->_recommend_new_goods($goods);


            // 是否获取商品详情
            if($detail){
                $data['freight'] = $this->_get_postFee_show($goods);
                $data['parameter'] = plum_parse_img_path_new($goods['g_parameter']);

                $data['detail'] = plum_parse_img_path_new($goods['g_detail']);

                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }
                // 获取商品幻灯
                $slide = $this->_goods_slide($goods['g_id']);
                $data['slide']  = $slide['images'];
                $data['slideSize']  = $slide['imagesSize'];
                $data['format'] = $this->_goods_format($goods['g_id'])['value'];
                // 获取不同规格的价格
                $prices = $this->_goods_format($goods['g_id'])['prices'];
                $prices = $prices?$prices:[];
                array_push($prices,$data['price']);
                $data['maxPrice'] = max($prices)>0 ? floatval(max($prices)) : 0;
                $data['minPrice'] = min($prices)>0 ? floatval(min($prices)) : 0;
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }

                if($goods['g_es_id'] && $this->applet_cfg['ac_type'] == 6){
                    //同城商城  获得商品会员价
//                    $trade_helper = new App_Helper_Trade($this->sid);
//                    $price = $trade_helper::getGoodsVipPirce($goods['g_price'],$this->sid,$goods['g_id'],0,$this->member['m_id']);
//                    $data['price'] = $price;
                }
                if($goods['g_es_id'] && $this->applet_cfg['ac_type'] == 8){
                    //同城商城  获得商品会员价
                    $trade_helper = new App_Helper_Trade($this->sid);
                    $price = $trade_helper::getGoodsVipPirce($goods['g_price'],$this->sid,$goods['g_id'],0,$this->member['m_id']);
                    $data['price'] = $price;
                }
                if($data['hasFormat']){
                    $data['formatList']  = $this->_new_goods_format($goods);
                    if($goods['g_es_id'] && $this->applet_cfg['ac_type'] == 6){
                        $formatInfo = $this->_get_format_value_mall($goods['g_id']);
                        $data['formatValue'] = $formatInfo['data'];
                        $priceArr = $formatInfo['priceArr'];

                        //获得商品的价格区间
                        //$floatPrice = floatval($data['price']);
                        //array_push($priceArr,$data['price']);

                        $data['maxPrice'] = max($priceArr)>0 ? floatval(max($priceArr)) : 0;
                        $data['minPrice'] = min($priceArr)>0 ? floatval(min($priceArr)) : 0;
                    }else{
                        $data['formatValue'] = $this->_get_format_value($goods['g_id']);
                    }
                }
                if($data['slide']){
                    $imagesize = getimagesize($data['slide'][0]);
                    if($imagesize[0]==$imagesize[1]){
                        $data['slideSpecif'] = 1;
                    }else{
                        $data['slideSpecif'] = 0;
                    }
                }

            }
            if($this->applet_cfg['ac_type'] == 6){
                $data['isCollect'] = $this->_is_collection_mall($goods['g_id']);
                if($goods['g_es_id']){
                    $data['shopDetails'] =  $this->_get_city_shop_info($goods['g_es_id']);
                    $data['showShopDetail'] = $data['shopDetails']['showShopDetail'];
                }
            }else{
                $data['isCollect'] = $this->_is_collection($goods['g_id'], 2);
                if($goods['g_es_id']){
                    $data['shopDetails'] =  $this->_get_shop_info($goods['g_es_id']);
                    $data['showShopDetail'] = $data['shopDetails']['showShopDetail'];
                }
            }
            if($data['maxPrice']>0 && $data['minPrice']>0 && $data['maxPrice']==$data['minPrice']){
                $data['minPrice'] = 0;
                $data['maxPrice'] = 0;
            }


            return $data;
        }
        return false;
    }

    /*
     * 获得展示运费
     */
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

    /**
     * 获取商品的幻灯
     */
    private function _goods_slide($gid){
        //获取商品幻灯
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $slide       = $slide_model->getListByGidSid($gid, $this->sid);
        $data['images'] = array();
        $data['imagesSize'] = false;
        if($slide){
            foreach ($slide as $val){
                $data['images'][] = $this->dealImagePath($val['gs_path']);
                $size = getimagesize($this->dealImagePath($val['gs_path']));
                if($size[1]==$size[0]){
                    $data['imagesSize'] = true;
                }
            }
        }
        return $data;
    }

    /**
     * 获取商品规格
     */
//    private function _goods_format($gid){
//        //获取商品规格
//        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
//        $format = $format_model->getListByGid($gid);
//        $data = array();
//        if($format){
//            foreach ($format as $val){
//                $data[] = array(
//                    'id'    => $val['gf_id'],
//                    'name'  => $val['gf_name'],
//                    'price' => $val['gf_price'],
//                    'sold'  => $val['gf_sold'],
//                    'stock' => $val['gf_stock'],
//                    'point' => $val['gf_send_point'],
//                );
//            }
//        }
//        return $data;
//    }
    /**
     * 获取商品规格
     */
    private function _goods_format($gid){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = array();
        if($format){
            foreach ($format as $val){
                $data['value'][] = array(
                    'id'    => $val['gf_id'],
                    'name'  => $val['gf_name'],
                    'price' => floatval($val['gf_price']),
                    'sold'  => intval($val['gf_sold']),
                    'stock' => intval($val['gf_stock']),
                    'point' => intval($val['gf_send_point']),
                );
                $data['prices'][] = $val['gf_price'];
            }
        }
        return $data;
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
    private function _get_format_value($gid){
        $isVip  = $this->member['m_level_long'] > time() ? 1:0;
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        foreach($format as $val){
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price'  => $isVip? floatval($val['gf_vip_price']):floatval($val['gf_price']),
                'vipPrice' => floatval($val['gf_vip_price']),
                'stock'  => intval($val['gf_stock'])
            ];
        }
        return $data;
    }


    /**
     * 获取商品规格数据
     */
    private function _get_format_value_mall($gid){
        $trade_helper = new App_Helper_Trade($this->sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        $priceArr = array();
        foreach($format as $val){
            $price = $trade_helper::getGoodsVipPirce($val['gf_price'],$this->sid,$gid,$val['gf_id'],$this->member['m_id']);
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price'  => $price,
                'vipPrice' => $price,
                'stock'  => intval($val['gf_stock'])
            ];
            $priceArr[] = $price;
        }

        $info['data'] = $data;
        $info['priceArr'] = $priceArr;

        return $info;
    }



    /**
     * 商品评价列表
     */
    public function commentListAction(){
        $page = $this->request->getIntParam('page');
        $gid  = $this->request->getIntParam('gid');
        $index = $page * $this->count;
        $info['data'] = $this->_get_comment_list(0, $gid, $index, $this->count);
        if($info['data']){
            $this->outputSuccess($info);
        }else{
            $this->outputSuccess('数据加载完毕');
        }
    }

    /**
     * 发帖
     */
    public function submitPostAction(){
        $images = $this->request->getStrParam('images');    // 发帖图片
        $content = $this->request->getStrParam('content');  // 发帖内容
        $istop    = $this->request->getIntParam('istop',0);    // 是否置顶 ： 0不置顶，1置顶
        $topTime  = $this->request->getIntParam('topTime');  // 置顶时间id
        $number   = $this->request->getStrParam('number');    // 支付订单号
        $isPlugin = $this->request->getIntParam('isPlugin');//插件
        $category = $this->request->getIntParam('category');
        $address  = $this->request->getStrParam('address');      // 地址
        $aliasAddr = $this->request->getStrParam('aliasAddr');  // 地址别名
        $lng      = $this->request->getStrParam('lng');     // 经度
        $lat      = $this->request->getStrParam('lat');     // 纬度
        $label    = $this->request->getStrParam('label');   // 标签

        //如果是插件，判断是否开通插件
        if($isPlugin){
            $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->sid);
            $row = $plugin_model->findUpdateBySid('post');
            if (!$row || $row['apo_expire_time']<time()) {
                $this->outputError('发帖功能暂不可用');
            }
        }

        if($content=='undefined'){   //过滤掉undefined
            $content='';
        }

        if($number){
            $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->shop['s_id']);
            $payData = $pay_model->findUpdateByNumber($number);
        }

        if($images){
            $images = str_replace('[','',$images);
            $images = str_replace(']','',$images);
            $images = str_replace('"','',$images);
            if($images){
                $images = explode(',',$images);
            }
        }
        $content = plum_sql_quote($content);   // 在对字符串进行转义，防止sql攻击
        if($content){
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);   // 默认使用1号店铺的授权信息验证
            $result = $wxclient_help->checkMsg($content);
            if($result && $result['errcode']==87014){
                $this->outputError($result['errmsg']);
            }
        }
        if($content || !empty($images)){
            //检查发布信息合法性
            if($content){
                $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);   // 默认使用1号店铺的授权信息验证
                $result = $wxclient_help->checkMsg($content);
                if($result && $result['errcode']==87014){
                    $this->outputError($result['errmsg']);
                }
            }

            $data = array(
                'acp_m_id'    => $this->member['m_id'],
                'acp_s_id'    => $this->sid,
                'acp_images'  => !empty($images) ? json_encode($images) : json_encode([]),
                'acp_content' => $content,
                'acp_cate'    => $category,
                'acp_create_time' => time(),
                'acp_address' => $address,
                'acp_alias_address' => $aliasAddr,
                'acp_lng' => $lng,
                'acp_lat' => $lat,
                'acp_label' => $label
            );

            //发帖配置（是否需要审核）
            $index_storage = new App_Model_City_MysqlCityIndexStorage($this->sid);
            $ft_cfg = $index_storage->findUpdateBySid(23);
            if($ft_cfg['aci_post_audit']){
                $data['acp_status'] = 1;
            }

            if($istop && $topTime){
                $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
                $cost = $cost_storage->findRowByActid($topTime);
                if($cost && $cost['act_data']){
                    $topDate = intval($cost['act_data']);
                    $dateTime = $topDate*60*60*24;
                    $expiration = intval(time()+$dateTime);
                    if($cost['act_cost']>0){
                        if($payData && $payData['cpp_top_time']==$topTime){
                            $data['acp_top_date'] = $topDate;
                            $data['acp_istop'] = 1;
                            $data['acp_istop_expiration'] = $expiration;
                            $data['acp_pay_time'] = time();
                        }
                    }else{
                        $data['acp_top_date'] = $topDate;
                        $data['acp_istop'] = 1;
                        $data['acp_istop_expiration'] = $expiration;
                        $data['acp_pay_time'] = time();
                    }
                }
            }

            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $ret = $post_model->insertValue($data);
            if($ret){
                //增加发布量
                $this->_statistics('issue', 1);
                if($istop && $topTime) {
                    $applet_redis = new App_Model_Applet_RedisAppletStorage($this->sid);
                    $applet_redis->recordCommunityTopPostTask($ret, $dateTime);
                }
                $notice_model = new App_Helper_JiguangPush($this->sid);
                $notice_model->pushNotice($notice_model::LEAVING_SUBMIT_POST,$ret);
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '发布成功'
                );
                // 发帖获取积分
                $point_storage = new App_Helper_Point($this->sid);
                $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_POST);

                plum_open_backend('post','checkCommunityImg',array('imgdata'=>rawurlencode(json_encode($images)),'sid'=>$this->sid,'id'=>$ret));

                $this->outputSuccess($info);
            }
        }else{
            $this->outputError('请将信息填写完整再发布');
        }
    }

    /**
     * @param $type 统计类型  type=browse 浏览量  type=issue 发布量 type=shop 商家
     * @param $num  数量
     */
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
    }


    /**
     * 帖子评论
     */
    public function commentPostAction(){
        $pid = $this->request->getIntParam('pid');  // 帖子ID
        $content = $this->request->getStrParam('content');
        $cmid = $this->request->getIntParam('cmid');    // 回复会员ID，（回复别人的评论，评论人的ID）
        $cid =  $this->request->getIntParam('cid');
        $content = plum_sql_quote($content);
        if($pid && $content && $content!=' '){
            $data = array(
                'acc_s_id'      => $this->sid,
                'acc_acp_id'    => $pid,
                'acc_comment'   => $content,
                'acc_m_id'      => $this->member['m_id'],
                'acc_reply_mid' => $cmid,
                'acc_acc_id'    => $cid,
                'acc_time'      => time(),
            );
            $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->sid);
            $ret = $comment_model->insertValue($data);
            if($ret){
                if($cmid>0){
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($cmid);
                }
                // 增加帖子评论数量
                $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
                $post_model->addReducePostNum($pid,'comment','add');
                $info['data'] = array(
                    'result' =>true,
                    'msg'    => '评论成功',
                    'comment' => array(
                        'id'            => $ret,
                        'comment'       => plum_strip_sql_quote($content),
                        'mid'           => $this->uid,
                        'nickname'      => $this->member['m_nickname'],
                        'replyMid'      => isset($member['m_id']) && $member['m_id'] > 0 ? $member['m_id'] : 0,
                        'replyNickname' => isset($member['m_nickname']) && $member['m_nickname'] ? $member['m_nickname'] : ''
                    )
                );
                // 评价帖子获取积分
                $point_storage = new App_Helper_Point($this->sid);
                $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_COMMENT);
                plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid,'applet' => 8, 'tid' => $ret, 'type' => App_Helper_WxappApplet::SEND_SETUP_COMMENT));
                $this->outputSuccess($info);
            }else{
                $this->outputError('评论失败');
            }
        }else{
            $this->outputError('请填写评论内容');
        }
    }


    /**
     * 删除帖子评论（只能删除自己的评论）
     */
    public function deletedPostCommentAction(){
        $cid = $this->request->getIntParam('cid');  // 评论ID
        if($cid){
            $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->sid);
            $row = $comment_model->getRowById($cid);
            if($row && $row['acc_m_id'] == $this->uid){
                $ret = $comment_model->deleteById($cid);
                if($ret){
                    // 减去帖子评论数量
                    $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
                    $post_model->addReducePostNum($row['acc_acp_id'],'comment','reduce');
                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '删除成功'
                    );
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('删除失败');
                }
            }else{
                $this->outputError('只能删除自己的评论哦');
            }
        }else{
            $this->outputError('删除失败');
        }
    }

    /**
     * 删除帖子
     */
    public function deletePostAction(){
        $pid = $this->request->getIntParam('pid');
        if($pid){
            $where = array();
            $where[] = array('name'=>'acp_id','oper'=>'=','value'=>$pid);
            $where[] = array('name'=>'acp_m_id','oper'=>'=','value'=>$this->uid);
            $where[] = array('name'=>'acp_s_id','oper'=>'=','value'=>$this->sid);
            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $set = array('acp_deleted'=>1);
            $ret = $post_model->updateValue($set,$where);
            if($ret){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '删除成功',
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('删除失败');
            }
        }else{
            $this->outputError('删除失败,请重试');
        }
    }

    /**
     * 帖子列表
     */
    public function postListAction(){
        $sortKey  = $this->request->getStrParam('sort');    // 排序：sort=hot 按照热门排序；sort = new 按照最新排序; sort = good 按照精品排序
        $page     = $this->request->getIntParam('page');
        $mine     = $this->request->getStrParam('mine');   // 1我的帖子
        $keyword  = $this->request->getStrParam('keyword'); //关键字
        $category     = $this->request->getIntParam('category',0);//帖子分类
        $index = $page*$this->count;
        $where = array();
        $where[] = array('name'=>'acp_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'acp_status','oper'=>'=','value'=>0);
        $where[] = array('name'=>'acp_deleted','oper'=>'=','value'=>0);    // 未被删除的
        if($keyword){
            $where[] = array('name'=>'acp_content','oper'=>'like','value'=>"%{$keyword}%");
            $this->dyCheckText($keyword);
            $this->_save_search_history($keyword);
        }

        // 我的发帖
        if($mine){
            $where[] = array('name'=>'acp_m_id','oper'=>'=','value'=>$this->uid);
        }
        if($category){
            $where[] = array('name'=>'acp_cate','oper'=>'=','value'=>$category);
        }


        $sort = array('acp_create_time'=>'DESC');
        $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
        if($sortKey=='hot'){
            $sort = array('acp_istop'=>'DESC','acp_comment_num' => 'DESC', 'acp_read_num'=>'DESC');
        }else if($sortKey=='new'){
            $sort = array('acp_istop'=>'DESC','acp_create_time'=>'DESC');
        }else if($sortKey=='good'){
            $sort = array('acp_istop'=>'DESC','acp_collection_num'=>'DESC', 'acp_comment_num' => 'DESC');
        }

        $list = $post_model->getPostListMember($where,$index,$this->count,$sort);
        if($list){
            $info = array();
            //$info['categoryList'] = $cateList;
            foreach ($list as $val){
                $images = array();
                foreach(json_decode($val['acp_images']) as $v){
                    $images[] = $this->dealImagePath($v);
                }
                $coverImgSize = getimagesize($this->dealImagePath(json_decode($val['acp_images'])[0],true));
                $info['data'][] = array(
                    'id'            => $val['acp_id'],
                    'nickname'      => $val['m_nickname'],
                    'avatar'        => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'isCollection'  => $this->_is_collection($val['acp_id'], 3),
                    'cover'         => $this->dealImagePath(json_decode($val['acp_images'])[0]),
                    'imgList'       => $images,
                    'coverWidth'    => $coverImgSize && $coverImgSize[0]>0 ? $coverImgSize[0] : 0,
                    'coverHeight'   => $coverImgSize && $coverImgSize[1]>0 ? $coverImgSize[1] : 0,
                    'content'       => $val['acp_content'],
                    'month'         => $this->_format_month(date('m',$val['acp_create_time'])).'月',
                    'day'           => date('d',$val['acp_create_time']),
                    'commentNum'    => $val['acp_comment_num'],
                    'readNum'       => $val['acp_read_num'],
                    'commentList'   => $this->_post_comment($val['acp_id']),
                    'istop'      => $val['acp_istop']>0 && isset($val['acp_istop_expiration']) && $val['acp_istop_expiration']>time() ? 1 : 0,
                    'collectionNum' => intval($val['acp_collection_num']),
                    'likeNum'       => intval($val['acp_like_num']),
                    'memberId'      => $this->member['m_id'],
                    'isLike'        => $this->_post_like($val['acp_id']),
                    'date'          => date('m-d',$val['acp_create_time']),
                    'label'         => isset($val['acp_label']) && $val['acp_label'] ? $this->_format_label($val['acp_label'],'') : [],
                    'lng'        => $val['acp_lng'],
                    'lat'        => $val['acp_lat'],
                    'address'    => isset($val['acp_address']) && $val['acp_address'] ? $val['acp_address'] : '',
                    'aliasAddr'  => isset($val['acp_alias_address']) && $val['acp_alias_address'] ? $val['acp_alias_address'] : '',
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂无相关内容哦~');
        }
    }

    //格式化标签信息
    private function _format_label($label,$secondCategory){
        $data = array();
        if($secondCategory){
            $data[] = $secondCategory;
        }
        if($label && isset($label)){
            foreach (explode(' ',$label) as $value){
                if($value && $value!='' && (($secondCategory && count($data)<4) || count($data)<3)){
                    $data[] = $value;
                }
            }
        }
        return $data;
    }

    /**
     * 保存搜索记录
     */
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
                'acsh_type'  => 2,
                'acsh_update_time' => time()
            );
            $history_model->insertValue($data);
        }
    }


    /**
     * 帖子详情
     */
    public function postDetailsAction(){
        $pid = $this->request->getIntParam('pid');
        if($pid){
            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $row = $post_model->getPostRowMember($pid);
            if($row){
                $info['data'] = $this->_post_detail_format($row);
                // 增加帖子查看数量;
                $post_model->addReducePostNum($pid,'show','add');
                $this->outputSuccess($info);
            }else{
                $this->outputError('帖子已删除');
            }
        }else{
            $this->outputError('获取帖子失败');
        }
    }

    /**
     * 帖子详情信息格式化
     */
    private function _post_detail_format($val){
        $data = array();
        if(!empty($val)){
            $images = array();
            foreach(json_decode($val['acp_images']) as $v){
                $images[] = $this->dealImagePath($v);
            }
            $data = array(
                'id'         => $val['acp_id'],
                'mid'        => $val['m_id'],
                'nickname'   => $val['m_nickname'],
                'avatar'     => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'content'    => isset($val['acp_content']) ? plum_strip_html_tags($val['acp_content']) : '',
                'time'       => date('Y-m-d',$val['acp_create_time']),
                'readNum'    => $val['acp_read_num'],
                'likeNum'    => intval($val['acp_like_num']),
                'collectionNum' => intval($val['acp_collection_num']),
                'commentNum' => $val['acp_comment_num'],
                'isCollection'  => $this->_is_collection($val['acp_id'], 3),
                'images'     => $images,
                'isLike'     => $this->_post_like($val['acp_id']),
                'comment'    => $this->_post_comment($val['acp_id']),
                'openReward' => intval($this->shop['s_post_reward']),
                'label'      => isset($val['acp_label']) && $val['acp_label'] ? $this->_format_label($val['acp_label'],'') : [],
                'lng'        => $val['acp_lng'],
                'lat'        => $val['acp_lat'],
                'address'    => isset($val['acp_address']) && $val['acp_address'] ? $val['acp_address'] : '',
                'aliasAddr'  => isset($val['acp_alias_address']) && $val['acp_alias_address'] ? $val['acp_alias_address'] : '',
            );
        }
        return $data;
    }

    /**
     * 获取帖子评论
     */
    private function _post_comment($pid){
        $data = array();
        $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->sid);
        $list = $comment_model->getCommentMember($pid);
        if($list){
            foreach ($list as $val){
                $data[] = $this->_post_comment_format($val);
            }
        }
        return $data;
    }

    /**
     * 帖子是否点赞
     */
    public function _post_like($pid){
        $num = 0;
        $like_model = new App_Model_Community_MysqlCommunityPostLikeStorage($this->sid);
        $row = $like_model->getLikeByMidPid($this->member['m_id'],$pid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    /**
     * 帖子评论列表
     */
    public function postCommentListAction(){
        $count = 20;   // 帖子评论一次加载30条
        $pid  = $this->request->getIntParam('pid');
        $page = $this->request->getIntParam('page');
        $mine = $this->request->getIntParam('mine'); //1 我的评论列表
        $index = $page*$count;
        $comment_model = new App_Model_Community_MysqlCommunityPostCommentStorage($this->sid);
        $list = array();
        if($pid){
            $list = $comment_model->getCommentMember($pid,$index,$count);
        }
        if($mine){
            $where[] = array('name' => 'acc_m_id', 'oper' => '=', 'value' => $this->uid);
            $where[] = array('name' => 'acc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);

            $sort  = array('acc_time' => 'desc');
            $list = $comment_model->getCommentPostListMember($where,$index,$count, $sort);
        }

        if($list){
            $info = array();
            foreach ($list as $val){
                $info['data'][] = $this->_post_comment_format($val);
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }

    }

    /**
     * 评论信息格式化
     */
    private function _post_comment_format($val){
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['acc_id'],
                'comment'       => isset($val['acc_comment']) ? plum_strip_sql_quote($val['acc_comment']) : '',
                'mid'           => $val['acc_m_id'],
                'nickname'      => $val['m_nickname'],
                'replyMid'      => $val['acc_reply_mid'] > 0 ? $val['acc_reply_mid'] : 0,
                'replyNickname' => isset($val['acc_reply_mid']) && isset($val['rm_nickname']) ? $val['rm_nickname'] : '',
                'time' => date('m月d日 H:i',$val['acc_time']),
                'postId'      => $val['acp_id'],
                'postContent' => $val['acp_content']?$val['acp_content']:'这是一个图片贴',
                'commentNum'  => $val['acp_comment_num'],
                'month' => $this->_format_month(date('m',$val['acc_time'])).'月',
                'day'   => date('d',$val['acc_time'])
            );
        }
        return $data;
    }

    private function _format_month($month){
        $str_n = '';
        switch($month)
        {
            case '1':$str_n="一";break;
            case '2': $str_n="二";break;
            case '3':$str_n="三";break;
            case '4':$str_n="四";break;
            case '5':$str_n="五";break;
            case '6':$str_n="六"; break;
            case '7':$str_n="七";break;
            case '8':$str_n="八";break;
            case '9':$str_n="九";break;
            case '10':$str_n="十";break;
            case '11':$str_n="十一";break;
            case '12':$str_n="十二";break;
        }
        return $str_n;
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

    public function _is_collection_mall($id){
        $num = 0;
        $collection_model = new App_Model_Goods_MysqlGoodsCollectionStorage($this->sid);
        $row = $collection_model->getRowByIdSidMid($id,$this->sid,$this->uid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    /**
     * 收藏或取消收藏
     */
    public function collectionAction(){
        $id  = $this->request->getIntParam('id');
        $type = $this->request->getIntParam('type'); // 1店铺 2商品 3帖子 5二手车
        if($id){
            $collection_model = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid);
            $row = $collection_model->getCollectionByMidPid($this->member['m_id'],$id, $type);
            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);

            $info['data'] = array(
                'result' => true,
                'msg'    => ''
            );
            // 已收藏
            if($row){
                $collection_model->deleteById($row['acc_id']);
                $info['data']['msg'] = '已取消收藏';
                $info['data']['status'] = 0;
                if($type == 1){
                    $shop_model->addReduceShopNum($id,'collection','reduce');
                }
                if($type == 3){
                    $post_model->addReducePostNum($id,'collection','reduce');
                }
                if($type == 5){
                    $resource_model = new App_Model_Car_MysqlCarResourceStorage($this->sid);
                    $resource_model->addReduceNum($id,'collect','reduce');
                }
                $this->outputSuccess($info);
            }else{
                $data = array(
                    'acc_s_id'   => $this->sid,
                    'acc_m_id'   => $this->member['m_id'],
                    'acc_cid'     => $id,
                    'acc_type'   => $type,
                    'acc_create_time'   => time()
                );
                $collection_model->insertValue($data);
                if($type == 1){
                    $shop_model->addReduceShopNum($id,'collection','add');
                }
                if($type == 3){
                    $post_model->addReducePostNum($id,'collection','add');
                }
                if($type == 5){
                    $resource_model = new App_Model_Car_MysqlCarResourceStorage($this->sid);
                    $resource_model->addReduceNum($id,'collect','add');
                }
                $info['data']['msg'] = '收藏成功';
                $info['data']['status'] = 1;
                // 收藏获取积分
                $point_storage = new App_Helper_Point($this->sid);
                $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_COLLECTION);
                $this->outputSuccess($info);
            }
        }else{
            $this->outputError("收藏失败");
        }

    }

    //我的收藏
    public function myCollectionAction(){
        $type = $this->request->getIntParam('type'); // 1店铺 2商品 3帖子 5.二手车
        $page = $this->request->getIntParam('page');
        $lng  = $this->request->getStrParam('lng');
        $lat  = $this->request->getStrParam('lat');
        $index = $page * $this->count;
        $collection_model = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid);
        $where[] = array('name'=>'acc_m_id','oper'=>'=','value'=>$this->uid);
        $where[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'acc_type','oper'=>'=','value'=>$type);
        $sort = array('acc_create_time' => 'desc');
        $info['data'] = array();
        if($type == 1){
            $list = $collection_model->getCollectionShopListMember($where, $index, $this->count, $sort, $lng, $lat);
            foreach($list as $val){
                $info['data'][] = array(
                    'id' => $val['es_id'],
                    'cover' => $val['es_logo']?$this->dealImagePath($val['es_logo']):$this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                    'name'  => $val['es_name'],
                    'hot' => $val['es_follow_num'],
                    'category' => $val['es_cate2_name'],
                    'label' => $val['es_label'],
                    'distance' => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'m' : round($val['distance'],2).'km' ): 0,
                    'carNum' => intval($val['ame_car_num'])
                );
            }
        }
        if($type == 2 || $type == 4){
            $list = $collection_model->getCollectionGoodsListMember($where, $index, $this->count, $sort);
            foreach($list as $val){
                $info['data'][] = array(
                    'id'       => $val['g_id'],
                    'name'     => $val['g_name'],
                    'cover'    => $this->dealImagePath($val['g_cover']),
                    'price'    => floatval($val['g_price']),
                    'oriPrice' => floatval($val['g_ori_price']),
                    'sold'     => $val['g_sold'],
                    'vipPrice' => $val['g_vip_price'],
                    'listLabel'  => $val['g_list_label'] ? $val['g_list_label'] : '',
                    'isDiscuss' => intval($val['g_is_discuss']),
                    'discussInfo'=> isset($val['g_discuss_info']) ? $val['g_discuss_info'] : '',
                );
            }
        }
        if($type == 3){
            $where[] = array('name'=>'acp_deleted','oper'=>'=','value'=>0);    // 未被删除的帖子
            $list = $collection_model->getCollectionPostListMember($where, $index, $this->count, $sort);
            foreach($list as $val){
                $images = array();

                foreach(json_decode($val['acp_images']) as $v){
                    $images[] = $this->dealImagePath($v);
                }
                $info['data'][] = array(
                    'id'         => $val['acp_id'],
                    'nickname'   => $val['m_nickname'],
                    'avatar'     => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'isCollection' => $this->_is_collection($val['acp_id'], 3),
                    'cover'      => $this->dealImagePath(json_decode($val['acp_images'])[0]),
                    'imgList'    => $images,
                    'content' => $val['acp_content'],
                    'month' => $this->_format_month(date('m',$val['acp_create_time'])).'月',
                    'day'   => date('d',$val['acp_create_time']),
                    'commentNum' => $val['acp_comment_num'],
                    'readNum' => $val['acp_read_num'],
                    'commentList'    => $this->_post_comment($val['acp_id']),
                );
            }
        }
        if($type == 5){
            //二手车
            $list = $collection_model->getCollectionCarResourceListMember($lng,$lat,$where, $index, $this->count, $sort);
            foreach ($list as $val){
                $label = [];
                if($val['acr_label']){
                    $labelArr = preg_split("/[\s,]+/",$val['acr_label']);
                    foreach ($labelArr as $value){
                        if($value && isset($value)){
                            $label[] = $value;
                        }
                    }
                }
                $info['data'][] = array(
                    'id' => $val['acr_id'],
                    'mobile' => $val['acr_phone'] ? $val['acr_phone'] : '',
                    //'distance'   => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'m' : round($val['distance'],2).'km' ): 0,
                    'name' => strstr($val['ct_name'],$val['cb_name']) ? $val['ct_name'] : $val['cb_name'].' '.$val['ct_name'],
                    'carType' => $val['acr_car_type'],
                    'carBrand' => $val['acr_car_brand'],
                    'verify' => $val['acr_es_id'] > 0 ? 1 : 0,
                    'price' => $val['acr_price'].'万',
                    'mile' => $val['acr_mile'].'万公里',
                    'licenseTime' => date('Y-m-d',$val['acr_license_time']),
                    'address' => $val['acr_address'] ? $val['acr_address'] : '',
                    'lng' => $val['acr_lng'],
                    'isCollection' => $this->_is_collection($val['acr_id'], 5),
                    'lat' => $val['acr_lat'],
                    'time' => $this->_format_date($val['acr_create_time'],'list'),
                    'label' => $label,
                    'cover' => $this->dealImagePath($val['acri_path'])
                );
            }

        }
        if($info['data']){
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    /*
     * 列表分段展示时间
     * 小于1分钟  1分钟前
     * 小于1小时  xx分钟前
     * 1-24小时  xx小时前
     * 24-48小时 昨天
     * 48小时以上 xx月xx  xx:xx
     */
    private function _format_date($createTime,$type = 'list'){
        if($type == 'list'){
            $now = time();
            $res = $now - $createTime;

            switch ($res){
                case $res < 60:
                    $date = '1分钟前';
                    break;
                case (60 <= $res && $res < 3600):
                    $date = floor($res/60).'分钟前';
                    break;
                case (3600 <=$res && $res < 86400) :
                    $date = floor($res/3600).'小时前';
                    break;
                case (86400 <= $res && $res < 86400*2) :
                    $date = '昨天';
                    break;
                default:
                    //$date = date('m',$createTime).'月'.date('d',$createTime).'　'.date('H:i',$createTime);
                    $date = date('m',$createTime).'-'.date('d',$createTime);
            }

        }else{
            $date = date('m',$createTime).'-'.date('d',$createTime);
        }
        return $date;
    }

    /**
     * 会员页
     */
    public function vipCenterAction(){
        if($this->member['m_level_long'] < time()){
            $this->outputError('您不是会员哦');
        }
        $card_model = new App_Model_Community_MysqlCommunityCardStorage($this->sid);
        $sort   = array('acc_long_type' => 'ASC','acc_update_time' => 'DESC');
        $where[]    = array('name' => 'acc_s_id','oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'acc_deleted','oper' => '=','value' =>0);
        $list   = $card_model->getList($where,0,0,$sort);
        //是否签到
        $hadAttendance = $this->_had_attendance_new();
        $info['data'] = array(
            'expireTime' => date('Y-m-d', $this->member['m_level_long']),
            'number' => $this->member['m_level_number'],
            'points'  => $this->member['m_points'],
            'hadAttendance' => $hadAttendance?1:0
        );
        foreach($list as $val){
            $info['data']['cardList'][] = array(
                'id'   => $val['acc_id'],
                'name' => $val['acc_name'],
                'days' => $val['acc_long'],
                'price'=> $val['acc_price']
            );
        }
        $this->outputSuccess($info);
    }

    private function _had_attendance(){
        $attendance_model = new App_Model_Community_MysqlCommunityAttendanceStorage($this->sid);
        $where[] = array('name' => 'aca_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'aca_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'aca_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d').' 00:00:00'));
        $row = $attendance_model->getRow($where);
        return $row;
    }

    private function _had_attendance_new(){
        $sign_model = new App_Model_Point_MysqlPointSignStorage($this->sid);
        $record     = $sign_model->findSignByMid($this->member['m_id']);
        if($record){
            $time_str   = date("Y-m-d", $record['ps_last_signtime']);
            $last_zero  = strtotime($time_str." 00:00:00");
            $hour_24    = 24*60*60;
            $curr_time  = time();
            if (($last_zero+$hour_24) > $curr_time) {
                return true;
            }else{
                return false;
            }
        }else{
           return false;
        }


    }

    //会员签到
    public function attendanceAction(){
        // 评价订单获取积分
        $point_storage = new App_Helper_Point($this->sid);
        $ret = $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_SIGN);
        if(is_array($ret) && !$ret['errcode']){
            $info['data'] = array(
                    'result' => true,
                    'point'  => $ret['point'],
                    'msg'    => $ret['errmsg'],
                );
                $this->outputSuccess($info);
        }else{
            $msg = $ret['errmsg'] ?  $ret['errmsg'] : '签到失败';
            $this->outputError($msg);
        }
//        $hadAttendance = $this->_had_attendance();
//        if($hadAttendance){
//            $this->outputError('今天已经签到过了');
//        }else{
//            //获取店铺签到赠送的积分
//            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
//            $tpl  = $tpl_model->findUpdateBySid();
//            $point = $tpl['aci_point'];
//            $data = array(
//                'aca_s_id'   => $this->sid,
//                'aca_m_id'   => $this->uid,
//                'aca_points' => $point,
//                'aca_create_time' => time(),
//            );
//            $attendance_model = new App_Model_Community_MysqlCommunityAttendanceStorage($this->sid);
//            $ret = $attendance_model->insertValue($data);
//            if($ret){
//                //为会员增加积分
//               /* $updata = array(
//                    'm_points'      => $this->member['m_points'] + $point,
//                );
//                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
//                $member_storage->updateById($updata, $this->member['m_id']);*/
//                $point_helper   = new App_Helper_Point($this->sid);
//                $title='签到奖励积分';
//                $point_helper->memberPointRecord($this->member['m_id'], $point, $title, App_Helper_Point::POINT_INOUT_INCOME, App_Helper_Point::POINT_SOURCE_SIGN);
//
//                $info['data'] = array(
//                    'result' => true,
//                    'point'  => $point,
//                    'msg'    => '签到成功',
//                );
//                $this->outputSuccess($info);
//            }else{
//                $this->outputError('签到失败');
//            }
//        }
    }

    /**
     * 积分商城
     */
    public function pointsShopAction(){
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid();
        $hadAttendance = $this->_had_attendance_new();
        //积分商品数量
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goodsCount    = $goods_model->fetchShopGoodsCount($this->sid, '',  0, array(),array(),0,0,array(4,5),array(),0);
        $couponModel   = new App_Model_Coupon_MysqlCouponStorage();   //可以兑换的优惠券数量
        $couponCount   = $couponModel->fetchPointsCouponCount($this->sid);
        //可兑换的优惠券数量
        $info['data'] = array(
            'slide'         => $tpl['aci_point_slide']?$this->_shop_point_slide(json_decode($tpl['aci_point_slide'],1)):'',
            'prizeImg'      => $this->dealImagePath($tpl['aci_point_img']),
            'rule'          => $tpl['aci_point_rule']?plum_parse_img_path($tpl['aci_point_rule']):'',
            'topImg'        => $this->dealImagePath($tpl['aci_point_img']),
            'points'        => $this->member['m_points'],
            'hadAttendance' => $hadAttendance?1:0,
            'isVip'         => $this->member['m_level_long']>time()?1:0,
            'lottery'       => $this->_shop_conduct_lottery(),
            'styleType'     => $tpl['aci_style_type'] ? intval($tpl['aci_style_type']) : 1,
            //新增积分商品和可兑换优惠券的数量
            'goodsNum'      => intval($goodsCount),
            'couponNum'     => intval($couponCount),
            'exchangeRatio' => intval($tpl['aci_exchange_ratio']),
            'exchangeOpen'  => $tpl['aci_exchange_ratio']>0?1:0,
            'memberCardOpen'=> $this->_get_member_card_open()
        );
        $this->outputSuccess($info);
    }

    private function _get_member_card_open(){
        $where      = array();
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' => $this->sid);
        $where[]    = array('name' => 'oc_type','oper' => '=','value' => 2); //会员卡类型是折扣卡
        $where[]    = array('name' => 'oc_deleted','oper' => '=','value' => 0); //未删除
        $where[]    = array('name' => 'oc_is_points','oper' => '=','value' => 1); //可用积分兑换的会员卡
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $count = $card_model->getCount($where);
        return $count>0?1:0;
    }

    private function _shop_point_slide($slide){
        $data = '';
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => '',
                    'link' => '', # /pages/index/index?id=8
                    'img'  => isset($val['imgsrc']) ? $this->dealImagePath($val['imgsrc']) : '',
                    'url'  =>'',
                );
            }
        }
        return $data;
    }

    /**
     * 获取是否有正在进行中的活动
     */
    private function _shop_conduct_lottery(){
        $data = array(
            'start' => false,
            'msg'    => '活动正在筹备中，敬请期待',
        );
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'amll_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'amll_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amll_deleted', 'oper' => '=', 'value' => 0);
        $row = $list_model->getRow($where);
        if($row){
            $data['start'] = true;
        }
        return $data;
    }

    /**
     * 积分兑换会员页面
     */
    public function exchangeCardListAction(){
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 2); //会员卡
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'oc_is_points','oper' => '=','value' => 1); //可用积分兑换的会员卡
        $where[]    = array('name' => 'oc_deleted','oper' => '=','value' =>0);
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $sort   = array('oc_price' => 'ASC', 'oc_long_type' => 'ASC','oc_update_time' => 'DESC');
        $list   = $card_model->getListLevel($where,0,0,$sort);
        $cardList = array();
        if($list){
            $cardType = plum_parse_config('offline_card_new','app');
            foreach ($list as $val){
                $cardList[] = array(
                    'hadBuy'       => false,
                    'id'           => $val['oc_id'],
                    'name'         => $val['oc_name'],
                    'shopName'     => $this->shop['s_name'],
                    'nameSub'      => $val['oc_name_sub'],
                    'bgType'       => $val['oc_bg_type'],
                    'backgroundColor' => $val['oc_background_color'] ? $val['oc_background_color'] : '',
                    'longShow'     => '有效期'.$cardType[$val['oc_long_type']]['long'].'天',
                    'longType'     => $val['oc_long_type'],
                    'longTypeShow' => $cardType[$val['oc_long_type']]['name'],
                    'price'        => $val['oc_price']>0 ? $val['oc_price'] : 0,
                    'points'       => $val['oc_points']>0 ? $val['oc_points'] : 0,
                    'times'        => $val['oc_times'],
                    'identity'     => $val['oc_identity'],
                    'rights'       => str_replace("<br/>", "\n",$val['oc_rights']),
                    'notice'       => str_replace("<br/>", "\n",$val['oc_notice']),
                    'updateTime'   => date('Y-m-d',$val['oc_update_time']),
                    'returnPrice'  => $val['oc_return_price'],
                    'isIdentity'     => $val['oc_identity'] && $val['ml_id']>0 ? 1 : 0,
                    'levelName'      => isset($val['ml_name']) && $val['ml_name'] ? $val['ml_name'] : '',
                    'levelDesc'      => isset($val['ml_desc']) && $val['ml_desc'] ? $val['ml_desc'] : '',
                    'levelDiscount'  => isset($val['ml_discount']) && $val['ml_discount'] ? $val['ml_discount'] : '',
                    'levelDiscountShow'  => isset($val['ml_discount']) && $val['ml_discount'] ? '享'.$val['ml_discount'].'折' : '',
                );
            }
        }
        $info['data'] = array(
            'points'    => $this->member['m_points'],
            'cardList'  => $cardList
        );

        $this->outputSuccess($info);
    }

    /**
     * 积分兑换余额配置
     */
    public function exchangeBalanceCfgAction(){
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid();
        $info['data'] = array(
            'points' => $this->member['m_points'],
            'ratio'  => intval($tpl['aci_exchange_ratio'])>0?intval($tpl['aci_exchange_ratio']):1,
            'desc'   => '每'.intval($tpl['aci_exchange_ratio']).'积分可兑换1元余额'
        );

        $this->outputSuccess($info);
    }

    /**
     * 积分兑换余额
     */
    public function exchangeBalanceAction(){
        $points = $this->request->getIntParam('points');
        if($points){
            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
            $tpl   = $tpl_model->findUpdateBySid();
            if($tpl['aci_exchange_ratio']){
                $ratio = $tpl['aci_exchange_ratio'];
                if($points >= $ratio){
                    //判断会员积分是否足够支付
                    $memberPoints = floatval($this->member['m_points']);
                    if ($points > $memberPoints) {
                        $this->outputError("积分不足");
                    }
                    $coin = floor($points/$ratio);  //可以兑换的余额数量
                    $deductPoints = $points - ($points%$ratio); //兑换整数，多出的不扣除
                    //记录余额变动
                    App_Helper_MemberLevel::coinInoutRecord($this->sid, $this->member['m_id'], $deductPoints, $coin, 12, "积分兑换");
                    //增加用户余额
                    App_Helper_MemberLevel::goldCoinTrans($this->shop['s_id'], $this->member['m_id'], $coin);

                    //扣除积分并记录支积分支出
                    $title  = "兑换余额";
                    $point_helper   = new App_Helper_Point($this->shop['s_id']);
                    $point_helper->memberPointRecord($this->member['m_id'], $deductPoints, $title, App_Helper_Point::POINT_INOUT_OUTPUT, App_Helper_Point::POINT_SOURCE_EXCHANGE_COIN, '');

                    $info['data'] = array(
                        'result' => true,
                        'msg'    => "兑换成功"
                    );
                    $this->outputSuccess($info);
                }else{
                    $this->outputError("积分输入有误");
                }
            }else{
                $this->outputError("商家暂未开启兑换功能");
            }
        }else{
            $this->outputError("请输入兑换积分");
        }
    }

    /**
     * 积分商品分类
     */
    public function pointsCategoryAction(){
        //获取商品分类列表
        $category_model = new App_Model_Community_MysqlPointsKindStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'apk_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'apk_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('apk_weight' => 'desc');
        $cateList = $category_model->getList($where, 0, 0, $sort);
        $info['data'] = array();
        foreach ($cateList as $val){
            $info['data'][] = array(
                'id' => $val['apk_id'],
                'name' => $val['apk_name'],
            );
        }

        $this->outputSuccess($info);
    }

    /**
     * 积分商品
     */
    public function pointsGoodsAction(){
        $kind = $this->request->getIntParam('kind');
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            //积分商城按权重排序商品
            //zhangzc
            //2019-08-01 
            $sort=['g_weight'=>'DESC'];
            $goods    = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, '',  0, $sort,array(),$kind,0,array(4,5),array(),0);
            if($goods){
            $info['data'] = array();
            foreach($goods as $val){
                $info['data'][] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                    'cover' => $this->dealImagePath($val['g_cover']),
                    'price' => floatval($val['g_price']),
                    'points' => $val['g_points'],
                    'oriPrice' => floatval($val['g_ori_price']),
                    'listLabel'  => $val['g_list_label'] ? $val['g_list_label'] : '',
                    'stock' => $val['g_stock']<0?0:$val['g_stock'],
                    'sold' => $val['g_sold'],
                    'stockShow'  => $val['g_stock_show'],
                    'soldShow'   => $val['g_sold_show'],
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }
    /*
     * 积分商城的优惠券列表信息
     */
    public function couponListAction(){
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $page           = $this->request->getIntParam('page');
        $index          = $page*$this->count;

        $coupon = $coupon_model->fetchPointsCouponList($this->sid,$index,$this->count);
        $list   = array();
        foreach ($coupon as $key => $value) {
            $list[] = $this->_format_coupon_data($value, false);
        }
        if ($list) {
            $info['data'] = $list;
            $this->outputSuccess($info);
        } else {
            $this->outputError('无可用现金券');
        }
    }

    /**
     * 格式化优惠券数据
     */
    private function _format_coupon_data($coupon, $receive){
        $color = plum_parse_config('coupon_color','system');
        //查询该用户兑换该优惠券兑换了多少张
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $count  = $receive_model->getMemberReceiveCount($this->member['m_id'],  $coupon['cl_id'], $this->sid,1);
         if($coupon['cl_receive_limit']>0){
             if($count >= $coupon['cl_receive_limit']){
                 $isExchange = 0;   //不可以兑换
             }else{
                 $isExchange =1;
             }
         }else{
             $isExchange =1 ;  //可以兑换
         }
        $data = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => $coupon['cl_use_limit'],
            'count'     => $coupon['cl_count'],
            'type'      => $coupon['cl_use_type'], //1 为所有商品通用  2指定商品
            'start'     => date('Y-m-d', $coupon['cl_start_time']),
            'end'       => date('Y-m-d', $coupon['cl_end_time']),
            'receiveLimit' => intval($coupon['cl_receive_limit']),   //每人限领或者兑换，0为不限制
            'colorType' => (intval($coupon['cl_id']%4))+1,
            'color'     => $color[(intval($coupon['cl_id']%3))+1],
            //新增兑换所需积分
            'points'    => $coupon['cl_need_points'],
            'isExchange' =>$isExchange,  //是否被兑换完  0已兑换完 1没有
            'remainCount' => intval($coupon['cl_count']-$coupon['cl_had_receive']),       //优惠券剩余数量
            //'exchangeCount' => intval($count),                              //该用户已经兑换该优惠券的数量
        );

        if($receive){
            $data['used'] = $coupon['cr_is_used'];
        }
        return $data;
    }


    private function _format_coupon_data1($coupon, $receive){
        $color = plum_parse_config('coupon_color','system');
        //查询该用户兑换该优惠券兑换了多少张
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $count  = $receive_model->getMemberReceiveCount($this->member['m_id'],  $coupon['cl_id'], $this->sid,1);
        $data = array(
            'id'        => $coupon['cl_id'],
            'name'      => $coupon['cl_name'],
            'value'     => $coupon['cl_face_val'],
            'limit'     => $coupon['cl_use_limit'],
            'type'      => $coupon['cl_use_type'], //1 为所有商品通用  2指定商品
            'start'     => date('Y-m-d', $coupon['cl_start_time']),
            'end'       => date('Y-m-d', $coupon['cl_end_time']),
            'colorType' => (intval($coupon['cl_id']%4))+1,
            'color'     => $color[(intval($coupon['cl_id']%3))+1],
        );

        if($receive){
            $data['used'] = $coupon['cr_is_used'];
        }
        return $data;
    }


    /*
     * 查询优惠券适用商品
     */
    public function cgoodsListAction(){
       $id  = $this->request->getIntParam('id');   //优惠券
        $page  = $this->request->getIntParam('page');
        $count = 5;
        $index = $page*$count;
        if($id){
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $row = $coupon_model->getRowByIdSid($id,$this->sid);
            if(!empty($row)){
                //$row['cl_use_desc'] = plum_textarea_html_to_line($row['cl_use_desc']);
               $goods= $this->show_goods_by_actId($row['cl_id'],$row['cl_use_type'],$index,$count);
               $info['data'] = $goods;
               $this->outputSuccess($info);
            }else{
                $this->outputError('该优惠券信息不存在');
            }
        }
    }

    /**
     * @param $actid
     * @param $type
     * 活动商品展示
     */
    private function show_goods_by_actId($actid,$type,$index,$count){
        $goods   = array();
        if($type == 2){ //指定商品
            $goods_model    = new App_Model_Coupon_MysqlCouponGoodsStorage($this->sid);
            $goods_list     = $goods_model->getListByActid($actid,$index,$count);

        }
        foreach($goods_list as $val){
            $goods[] = array(
               // 'id'    => $val['cg_id'],
                'gid'   => $val['g_id'],
                'gname' => $val['g_name'],
                'gcover' => !empty($val['g_cover'])?$this->dealImagePath($val['g_cover']):'',
                'oriPrice' => $val['g_ori_price'],  //商品原价
                'price'   => $val['g_price'],   //商品现价
                'listLabel'  => $val['g_list_label'] ? $val['g_list_label'] : '',
            );
        }
        return $goods;
    }
    /*
     * 积分兑换优惠券
     */
    public function couponChangeAction(){
        //优惠券id
        $cid    = $this->request->getIntParam('cid');
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon     = $coupon_model->getCoupon($cid, $this->sid);
        if (!$coupon) {
            $this->outputError("优惠券不存在哟!");
        }
        if ($coupon['cl_end_time'] < time()) {
            $this->outputError("优惠券已失效");
        }
        if($this->member['m_points']<$coupon['cl_need_points']){
              $this->outputError('抱歉，你的积分不足');
        }

        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $count  = $receive_model->getMemberReceiveCount($this->member['m_id'], $cid, $this->sid,1);
        //已领取过,并且有领取限制,并且领取的数量大于等于限制数量
        if ($count > 0 && $coupon['cl_receive_limit'] > 0 && $count >= $coupon['cl_receive_limit']) {
            //
            $this->outputError('您已经兑换过该优惠券了,尽快使用吧!');
        } else {
            //判断发行量
            if ($coupon['cl_had_receive'] >= $coupon['cl_count']) {
                $this->outputError("优惠券已被兑换完啦!");
            } else {
                $slogan = plum_parse_config('coupon_slogan', 'app');
                $rand   = mt_rand(0, count($slogan)-1);
                $indata = array(
                    'cr_s_id'         => $this->sid,
                    'cr_m_id'         => $this->member['m_id'],
                    'cr_c_id'         => $cid,
                    'cr_receive_time' => time(),
                    'cr_expire_time'  => $coupon['cl_use_time_type'] == 1?$coupon['cl_use_end_time']:strtotime("+".$coupon['cl_use_days']." days"),
                    'cr_slogan'       => $slogan[$rand],
                    'cr_receive_type' => 1,  //类型  1为兑换
                    'cr_points'        => $coupon['cl_need_points']
                );
                $crid       = $receive_model->insertValue($indata);
                $tip_msg    = "恭喜您,优惠券兑换成功!";
                //设置领取量+1
                $coupon_model->incrementReceiveCount($cid, 1);
                if($crid){   //扣除会员积分
                    $pointHelper  = new App_Helper_Point($this->sid);
                    //扣除会员积分，增加积分来源
                    $pointHelper->memberPointRecord($this->member['m_id'],$coupon['cl_need_points'],
                        '优惠券兑换',2,App_Helper_Point::POINT_SOURCE_PRIZE);
                }
            }
        }
        $counts   = $count+1;
        if ($coupon['cl_receive_limit'] > 0 && $counts >= $coupon['cl_receive_limit']){
            $isExchange  = 0;
        }else{
            $isExchange =1;
        }
        //重新查询会员积分
        $memberModel  = new App_Model_Member_MysqlMemberCoreStorage();
        $memberInfo   = $memberModel->getRowByIdSid($this->member['m_id'],$this->sid);
        $info['data'] = array(
            'msg'           => $tip_msg,
            'status'        => 200,
            'received'      => 1,     //领取成功标志已领取
            'isExchange'    => $isExchange,   //说明当前会员还可兑换
            'remainCount'   => $coupon['cl_count']-$coupon['cl_had_receive']-1,   //该优惠券剩余数量
            'points'        => $memberInfo['m_points'],
        );
        $this->outputSuccess($info);
    }
    /*
     * 我的兑换列表
     */
    public function changeListAction(){
        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
        $page          = $this->request->getIntParam('page',0);
        $where[]    = array('name' => 'cr.cr_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]    = array('name' => 'cr.cr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'cl.cl_deleted', 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'cr.cr_receive_type', 'oper' => '=', 'value' => 1);
        $sort   = array('cr.cr_receive_time' => 'DESC');
        $index     = $page*$this->count;
        $list   = $receive_model->getReceiveList($where, $index, $this->count, $sort);
        if ($list) {
            foreach ($list as &$item) {
                $item = $this->_format_coupon_data1($item, true);
                //使用情况判断
                if ($item['used']) {
                    $item['status'] = 1;    //已使用
                } else {
                    if (strtotime($item['end']) < time()) {
                        $item['status'] = 2;   //已过期
                    } else {
                        $item['status'] = 0;      //未过期，未使用
                    }
                }
            }
            $info['data'] = $list;
            $this->outputSuccess($info);
        }else{
            $this->outputError("暂时没有优惠券哦");
        }
    }


    /*
     * VIP会员下单页面
     */
    public function buyVipAction() {
        $this->outputError('请前往卡券页，购买会员卡');
        $id    = $this->request->getIntParam('id');
        $card_model = new App_Model_Community_MysqlCommunityCardStorage($this->sid);
        $card = $card_model->getRowById($id);
        if($card){
            if($card['acc_price'] > 0){
                $tid    = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid);//生成唯一性订单ID
                $indata = array(
                    'acmo_s_id'       => $this->sid,
                    'acmo_m_id'       => $this->member['m_id'],
                    'acmo_cid'        => $id,
                    'acmo_buyer_name' => $this->member['m_nickname'],
                    'acmo_buyer_openid'=> $this->member['m_openid'],
                    'acmo_title'      => $card['acc_name'],
                    'acmo_tid'        => $tid,
                    'acmo_amount'     => $card['acc_price'],
                    'acmo_status'     => 0,
                    'acmo_create_time'=> time(),
                );
                //创建新订单
                $order_storage  = new App_Model_Community_MysqlCommunityMemberOrderStorage($this->sid);
                $ret = $order_storage->insertValue($indata);
                if($ret){
                    $pay = $this->_vip_pay($indata['acmo_amount'],$tid, $indata['acmo_title']);
                    $info['data']['status'] = 'dzf';
                    $info['data']['payMsg'] = $pay['msg'];
                    $info['data']['params'] = $pay['dataArray'];
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('支付错误，请重试');
                }
            }else{
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                //设置到期时间
                $expire_time    = $this->member['m_level_long'] > time() ? $this->member['m_level_long'] : time();

                $add    = $card['acc_long']*24*60*60;
                $expire_time += $add;
                $level  = intval($card['acc_id']);
                //设置用户会员卡号
                $updata = array(
                    'm_level'       => $level,
                    'm_level_long'  => $expire_time,
                    'm_level_number'  => $this->member['m_level_number']?$this->member['m_level_number']:App_Helper_Tool::exportCardNum()
                );
                $ret = $member_storage->updateById($updata, $this->uid);
                if($ret){
                    $info['data']['status'] = 'zfcg';
                    $this->outputSuccess($info);
                }else{
                    $this->outputError('开通会员失败，请重试');
                }
            }
        }else{
            $this->outputError('会员卡不存在');
        }
    }

    private function _vip_pay($cost, $tid, $title){
        $pay = array(
            'dataArray' => array(),
            'msg'       => '',
        );
        //判断是否填写小程序端的微信支付配置
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if(!$appcfg){
            $pay['msg'] = '该商户暂未填写微信支付配置';
        }

        if($cost>0){
            if($tid){
                $body   = $this->shop['s_name'].$title;
                $openid     = $this->member['m_openid'];
                $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                $notify_url = $this->response->responseHost().'/mobile/wxpay/communityVip';//回调地址
                $attach = array(
                    'suid'  => $this->shop['s_unique_id'],
                    'mid'   => $this->member['m_id'],
                );
                $other      = array(
                    'attach'    => json_encode($attach),
                );
                // 生成支付参数
                $result = $pay_storage->appletOrderPayRecharge($cost,$openid,$tid,$notify_url,$body,$other);
                if (is_array($result)) {
                    $params = array(
                        'appId'     => $result['appid'],
                        'timeStamp' => strval(time()),
                        'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                        'package'   => "prepay_id={$result['prepay_id']}",
                        'signType'  => 'MD5',
                    );
                    $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $result['app_key']);
                    $pay['dataArray'] = $params;
                } else{
                    $pay['msg'] = '支付错误，请稍后重试';
                }
            }else{
                $pay['msg'] = '支付错误，请重试';
            }
        }
        return $pay;
    }

    /**
     * 积分商城下单
     */
    public function pointTradeAction(){
        $buys    = $this->request->getStrParam('buys');
        $buys    = json_decode(urldecode($buys), true);
        $addrid  = $this->request->getIntParam('addrid', 0);  // 收货地址ID
        $postFee = $this->request->getFloatParam('postFee',0); //运费



        // 判断商品是否为空如果不为空
        if(!empty($buys) && count($buys) > 0){

            if($this->applet_cfg['ac_type'] == 32){
                $sequenceCfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->sid);
                $sequenceCfg = $sequenceCfg_model->findUpdateBySid();
                $openTime = $sequenceCfg['asc_open_time'] ? $sequenceCfg['asc_open_time'] : '';
                $closeTime = $sequenceCfg['asc_close_time'] ? $sequenceCfg['asc_close_time'] : '';
                $isOpen = App_Helper_Sequence::getOpenStatus($openTime,$closeTime);
                if(!$isOpen){
                    $this->outputError('平台已打样，请在营业时间'.$openTime.'-'.$closeTime.'内购买商品');
                }
            }

            $num_sum    = 0;      //购买商品总数
            $gids       = array();//商品ID
            $nums       = array();//商品数量
            $fids       = array();//商品规格ID
            $goodsNum   = array();    //商品id和数量
            foreach ($buys as $one) {
                $num        = abs(intval($one['num']));
                $num_sum    += $num;
                $gids[]     = intval($one['gid']);
                $nums[]     = $num;
                $fids[]     = intval($one['gfid']);
                $goodsNum[intval($one['gid'])] = $num;


            }
            // 订购商品数量必须大于0
            if ($num_sum > 0) {
                // 获取购买商品
                $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
                $list   = $goods_model->fetchGoodsBySidGids($this->sid, $gids);
                // 如果商品存在
                if ($list) {
                    $goodsList = array();
                    foreach ($list as $val){
                        $goodsList[$val['g_id']] = $val;
                    }
                    $goods_fee  = 0;  // 商品总金额
                    $allPoints  = 0;
                    $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
                    $trade_type = App_Helper_Trade::TRADE_APPLET;//设置订单为小程序类型订单
                    $applet_trade_type = App_Helper_Trade::TRADE_APPLET_POINT;//小程序订单类型默认为积分
                    $trade_extra= json_encode(array('gid' => current($gids)));//设置第一个商品ID
                    $goodsData = array();  //获取商品数据
                    for ($i=0; $i<count($gids); $i++) {
                        $goodsList[$gids[$i]]['order_type'] = App_Helper_Trade::TRADE_ORDER_POINT;//积分
                        $price  = floatval($goodsList[$gids[$i]]['g_price']);  // 商品价格默认为商品价格
                        $points = floatval($goodsList[$gids[$i]]['g_points']);  // 积分默认为商品积分
                        $goodsList[$gids[$i]]['g_has_format']   = $format_model->getFromatCountByGid($goodsList[$gids[$i]]['g_id']);
                        //判断商品库存是否充足
                        if($goodsList[$gids[$i]]['g_stock'] < $goodsNum[$gids[$i]]){
                            $this->outputError('你所选的商品库存不足，暂不能购买');
                        }

                        if ($goodsList[$gids[$i]]['g_has_format'] > 0) {  // 如果商品规格存在时重新计算价格
                            if ($fids[$i] > 0) {
                                $format     = $format_model->findFormatByGfid($fids[$i], $goodsList[$gids[$i]]['g_id']);
                                if ($format) {
                                    $price  = floatval($format['gf_price']);
                                    $points = $format['gf_points'];
                                    $goodsList[$gids[$i]]['g_format'] = $format['gf_name'];
                                }
                            }
                        }


                        if($this->applet_cfg['ac_type'] == 27){
                            //如果是知识付费，检查是否有正在拼团的订单
                            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                            $hadTuan = $order_model->getTuanTradeByGid($goodsList[$gids[$i]]['g_id'], $this->member['m_id']);
                            if($hadTuan){
                                //如果有待拼团的订单， 就暂时不能下单， 防止重复购买
                                $this->outputError('您有正在拼团的订单， 暂时不能购买');
                            }
                        }

                        $goodsList[$gids[$i]]['g_price'] = $price;
                        $goods_fee  += ($price*$nums[$i]);//计算商品总价
                        $allPoints += ($points*$nums[$i]); //商品积分

                        $goodsData[] = array(
                            'id'       => $goodsList[$gids[$i]]['g_id'],
                            'name'     => $goodsList[$gids[$i]]['g_name'],
                            'img'      => plum_deal_image_url($goodsList[$gids[$i]]['g_cover']),
                            'format'   => isset($format['gf_name']) ? $format['gf_name'] : '',
                            'num'      => $nums[$i],
                            'price'    => $price,
                            'points'   => $points,
                            'allPoints'=> ($points*$nums[$i]),
                            'goodsFee' => ($price*$nums[$i]),   //计算商品总价
                            'postFee'  => $postFee, // 计算运费总价,
                            'orderType'=> $goodsList[$gids[$i]]['order_type']
                        );
                    }
                    // 订单合计总价
                    $total_fee      = $goods_fee + $postFee;
                    if($allPoints > $this->member['m_points']){
                        $this->outputError('积分不足');
                    }
                    //创建交易--开始
                    $indata = array(
                        't_s_id'        => $this->sid,
                        't_es_id'       => $list[0]['g_es_id']?$list[0]['g_es_id']:0,  //入驻店铺的id
                        't_m_id'        => $this->member['m_id'],
                        't_buyer_nick'  => $this->member['m_nickname'],
                        't_buyer_openid'=> $this->member['m_openid'],
                        't_tid'         => App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid),//生成唯一性订单ID
                        't_title'       => $list[0]['g_name'],//取第一个商品名称作为订单标题
                        't_pic'         => $list[0]['g_cover'],//取第一个商品封面作为订单图片
                        't_num'         => $num_sum,
                        't_goods_fee'   => $goods_fee,
                        't_points'      => $allPoints,
                        't_payment'     => 0,
                        't_type'        => $trade_type,//订单类型
                        't_applet_type'=> $applet_trade_type, //小程序订单类型
                        't_extra_data'  => $trade_extra,//订单附加数据
                        't_create_time' => time(),
                        't_total_fee'       => $total_fee,
                        't_addr_id'         => $addrid,
                        't_status'          => App_Helper_Trade::TRADE_NO_PAY,//修改订单状态为待支付
                        't_post_fee'        => $postFee,
                        't_pickup_code'     => plum_random_code(8),
                    );
                    $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                    $t_id   = $trade_model->insertValue($indata);

                    // 订单创建成功
                    if ($t_id) {
                        $indata['t_id'] = $t_id;
                        //创建交易订单
                        foreach ($goodsData as $key => $item) {
                            $todata = array(
                                'to_s_id'       => $this->sid,
                                'to_t_id'       => $t_id,
                                'to_g_id'       => $item['id'],
                                'to_gf_id'      => $fids[$key],//规格ID,默认为0
                                'to_gf_name'    => isset($item['format']) ? $item['format'] : '',
                                'to_m_id'       => $this->member['m_id'],
                                'to_num'        => $nums[$key],
                                'to_title'      => $item['name'],
                                'to_pic'        => $item['img'],
                                'to_price'      => $item['price'],
                                'to_points'     => $item['points'],
                                'to_total'      => floatval($item['price'])*$nums[$key],
                                'to_type'       => $item['orderType'],
                                'to_create_time'=> time(),
                            );
                            $order_model->insertValue($todata);
                        }
                        //优惠全免, 直接支付成功
                        if ($total_fee == 0) {
                            $updata = array(
                                't_total_fee'       => $total_fee,
                                't_addr_id'         => $addrid,
                                't_pay_time'        => time(),
                                't_pay_type'        => App_Helper_Trade::TRADE_PAY_JFZF,
                                't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态,
                            );
                            $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
                            $trade_model->findUpdateTradeByTid($indata['t_tid'], $updata);
                            //订单活动后续处理
                            $trade_helper->dealTradeType($indata);
                            $info['data'] = array(
                                'tid'         => $indata['t_tid'],
                                'total'      => $total_fee,
                                'status'     => 'zfcg',
                                'msg'        => '兑换成功',


                            );
                            $this->outputSuccess($info);
                        }else{
                            $info['data'] = array(
                                'tid'         => $indata['t_tid'],
                                'total'      => $total_fee,
                                'status'     => 'dzf',
                                //'tdata'      => $indata
                            );
                            $this->outputSuccess($info);
                        }
                    }else{
                        $this->outputError("订单创建失败,请返回重试");
                    }
                }else{
                    $this->outputError("未订购任何商品");
                }
            }else{
                $this->outputError("请选择订购的商品数量");
            }
        }else{
            $this->outputError("未订购任何商品");
        }
    }

    /*
     * 社区小程序店铺下单
     */
    public function createTradeAction() {
        $buys   = $this->request->getStrParam('buys');
        $buys   = json_decode(urldecode($buys), true);
        $isVip  = $this->member['m_level_long'] > time() ? 1:0;

        if (!$buys || count($buys) == 0) {
            $this->displayJsonError("未订购任何商品");
        }
        $num_sum    = 0;
        $gids       = array();//商品ID
        $nums       = array();//商品数量
        $fids       = array();//商品规格ID
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        foreach ($buys as $one) {
            $num                       = abs(intval($one['num']));
            $num_sum                   += $num;
            $gids[]                    = intval($one['gid']);
            $nums[]                    = $num;
            $fids[intval($one['gid'])] = intval($one['gfid']);
            /*$good                      = $goods_model->findGoodsBySidGid($this->sid, intval($one['gid']));
            if($good['g_stock'] < $num){
                $this->displayJsonError("商品库存不足");
            }*/
        }

        if ($num_sum <= 0) {
            $this->displayJsonError("请选择订购的商品数量");
        }
        $list   = $goods_model->fetchGoodsBySidGids($this->sid, $gids);
        if (!$list) {
            $this->displayJsonError("未订购任何商品");
        }

        $goods_fee  = 0;

        $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);

        $trade_type = App_Helper_Trade::TRADE_APPLET;//设置订单为小程序类型订单
        $trade_extra= json_encode(array('gid' => current($gids)));//设置第一个商品ID
        for ($i=0; $i<count($list); $i++) {
            $list[$i]['order_type'] = App_Helper_Trade::TRADE_ORDER_NORMAL;//普通
            $price  = 0;
            $list[$i]['g_has_format']   = $format_model->getFromatCountByGid($list[$i]['g_id']);
            if ($list[$i]['g_has_format'] == 0) {//无商品规格时
                $price  = $isVip && $list[$i]['g_vip_price'] != 0?floatval($list[$i]['g_vip_price']):floatval($list[$i]['g_price']);
            } else if ($list[$i]['g_has_format'] > 0) {
                if ($fids[$list[$i]['g_id']] > 0) {
                    $format     = $format_model->findFormatByGfid($fids[$list[$i]['g_id']], $list[$i]['g_id']);
                    if ($format) {
                        $price  = $isVip && $format['gf_vip_price']!= 0?floatval($format['gf_vip_price']):floatval($format['gf_price']);
                        $list[$i]['g_format']   = $format['gf_name'];
                    }
                }
            }
            if ($price == 0) {
                $this->displayJsonError("商品 {$list[$i]['g_name']} 未选择订购规格, 请重新选择后再下单!");
            }

            $list[$i]['g_price']    = $price;
            $goods_fee  += ($price*$nums[$i]);//计算商品总价
        }
        $total_fee = $goods_fee;


        //创建交易--开始
        $indata = array(
            't_s_id'        => $this->sid,
            't_es_id'       => $list[0]['g_es_id']?$list[0]['g_es_id']:0,  //入驻店铺的id
            't_m_id'        => $this->member['m_id'],
            't_buyer_nick'  => $this->member['m_nickname'],
            't_buyer_openid'=> $this->member['m_openid'],
            't_tid'         => App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid),//生成唯一性订单ID
            't_title'       => $list[0]['g_name'],//取第一个商品名称作为订单标题
            't_pic'         => $list[0]['g_cover'],//取第一个商品封面作为订单图片
            't_num'         => $num_sum,
            't_goods_fee'   => $goods_fee,
            't_total_fee'   => $total_fee,
            't_payment'     => 0,
            't_status'      => 0,
            't_type'        => $trade_type,//订单类型
            't_extra_data'  => $trade_extra,//订单附加数据
            't_create_time' => time(),
        );
        $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $t_id   = $trade_model->insertValue($indata);
        if (!$t_id) {
            $this->displayJsonError("订单创建失败,请返回重试");
        }
        $full_helper    = new App_Helper_FullAct($this->sid);
        //获取会员的优惠券信息
        $youhuiq    = $full_helper->getCouponListByGids($gids, $this->member['m_id'], $goods_fee);
        $orderGoods = array();
        //创建交易订单
        foreach ($list as $key => $item) {
            $todata = array(
                'to_s_id'       => $this->sid,
                'to_t_id'       => $t_id,
                'to_g_id'       => $item['g_id'],
                'to_gf_id'      => $fids[$item['g_id']],//规格ID,默认为0
                'to_gf_name'    => isset($item['g_format']) ? $item['g_format'] : '',
                'to_m_id'       => $this->member['m_id'],
                'to_g_brief'    => $item['g_brief'],
                'to_num'        => $nums[$key],
                'to_title'      => $item['g_name'],
                'to_pic'        => $item['g_cover'],
                'to_price'      => $item['g_price'],
                'to_total'      => floatval($item['g_price'])*$nums[$key],
                'to_type'       => $item['order_type'],
                'to_create_time'=> time(),
            );
            $order_model->insertValue($todata);
            $orderGoods[] = $todata;
        }

        //店铺配送方式
//        $send_type    = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
//        $sendType = $send_type->findUpdateBySid(null,);

        $info['data'] = array(
            'trade'   => $this->_format_trade($indata),
            'goods'   => $this->_format_goods($orderGoods),
            'coupon'  => $this->_format_coupon($youhuiq),
            'shop'    => $this->_get_shop_info($list[0]['g_es_id']),
        );
        $this->outputSuccess($info);
    }

    /**
     * 格式化优惠券
     */
    private function _format_coupon($coupon){
        $data = array();
        if($coupon && !empty($coupon)){
            foreach ($coupon as $key => $value) {
                $data[] = array(
                    'id'        => $value['cr_id'],
                    'name'      => $value['cl_name'],
                    'value'     => $value['cl_face_val'],
                    'limit'     => $value['cl_use_limit'],
                    'count'     => $value['cl_count'],
                    'receive'   => $value['cl_had_receive'],
                    'desc'      => $value['cl_use_desc'],
                    'start'     => date('Y-m-d', $value['cl_start_time']),
                    'end'       => date('Y-m-d', $value['cl_end_time']),
                    'colorType' => (intval($value['cl_id']%4))+1
                );
            }
        }
        // 不使用优惠券
        $nocoupon[] = array(
            'id'        => 0,
            'name'      =>'不使用优惠券',
            'value'     => 0,
            'limit'     => 0,
            'count'     => 0,
            'receive'   => 0,
            'desc'      => 0,
            'start'     => '',
            'end'       => '',
            'colorType' => 1
        );
        $data = array_merge($nocoupon,$data);
        return $data;
    }


    /**
     * 格式化订单数据
     */
    private function _format_trade($trade){
        return array(
            'mid'       => $trade['t_m_id'],
            'buyerNick' => $trade['t_buyer_nick'],
            'tid'       => $trade['t_tid'],
            'title'     => $trade['t_title'],
            'pic'       => plum_deal_image_url($trade['t_pic']),
            'num'       => $trade['t_num'],
            'goodsFee'  => $trade['t_goods_fee'],
            'totalFee'  => $trade['t_total_fee'],
            'time'      => date('Y-m-d H:i:s', $trade['t_create_time'])
        );
    }

    /**
     * 格式化商品
     */
    private function _format_goods($goods){
        $data = array();
        foreach ($goods as $key => $value) {
            $data[] = array(
                'id'      => $value['to_g_id'],
                'name'    => $value['to_title'],
                'cover'   => plum_deal_image_url($value['to_pic']),
                'price'   => $value['to_price'],
                'format'  => $value['to_gf_name'],
                'num'     => $value['to_num']
            );
        }
        return $data;
    }


    /*
     * 创建待支付订单
     */
    public function submitTradeAction() {
        //订单、支付信息
        $tid     = $this->request->getStrParam('tid');     // 订单编号
        $num     = $this->request->getIntParam('num');   //商品数量
        $yhqid      = $this->request->getIntParam('yhqid', 0);   // 优惠劵ID
        $payWay     = $this->request->getIntParam('payWay',1);//支付方式，1在线支付  2现金支付， 3余额支付
        $addrid     = $this->request->getIntParam('addrid', 0);  // 收货地址ID
        $receiverName  = $this->request->getStrParam('receiverName');  //门店自取，取货人姓名
        $receiverPhone = $this->request->getStrParam('receiverPhone'); //门店自取，取货人电话
        $postType   = $this->request->getFloatParam('postType',0); //配送类型 ：1物流发货，2商家配送，3门店自提

        if($num < 1){
            $this->displayJsonError("请选择商品数量");
        }

        // 支付配置
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payCfg = $pay_type->findRowPay();

        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        if($trade && $trade['t_status'] == 0){
            $discount_fee   = 0;//折扣金额，优惠劵金额
            $full_helper    = new App_Helper_FullAct($this->sid);
            $goods_fee      = floatval($trade['t_goods_fee']);

            $ids    = array();

            //如果使用优惠劵，计算优惠
            if ($yhqid) {
                $coupon_all     = $full_helper->getCouponListByGids($ids, $this->member['m_id'], $goods_fee);
                foreach ($coupon_all as $coupon) {
                    if ($coupon['cr_id'] == $yhqid) {
                        //优惠可用
                        //创建优惠
                        $indata = array(
                            'tc_s_id'       => $this->sid,
                            'tc_tid'        => $trade['t_tid'],
                            'tc_c_id'       => $coupon['cl_id'],
                            'tc_c_name'     => $coupon['cl_name'],
                            'tc_rc_id'      => $coupon['cr_id'],
                            'tc_discount_fee'   => $coupon['cl_face_val'],
                            'tc_used_time'  => time(),
                        );
                        $trade_coupon   = new App_Model_Trade_MysqlTradeCouponStorage($this->sid);
                        $trade_coupon->insertValue($indata);
                        $discount_fee   = floatval($coupon['cl_face_val']);
                        //设置优惠券已使用
                        $rcupdata   = array(
                            'cr_is_used'    => 1,
                            'cr_used_time'  => time(),
                        );
                        $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
                        $receive_model->updateById($rcupdata, $coupon['cr_id']);
                        //使用数量加1
                        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
                        $coupon_model->incrementUsedCount($coupon['cl_id'], 1);
                        break;
                    }
                }
            }

            /*$goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            foreach ($order_list as $item) {
                $ids[]  = $item['to_g_id'];
                $good = $goods_model->findGoodsBySidGid($this->sid, intval($item['to_g_id']));
                if($good['g_stock'] < $num){
                    $this->displayJsonError("商品库存不足");
                }
            }*/

            // 计算使用优惠券后的金额

            $total_fee      = max(0, floatval($trade['t_total_fee']*$num) - $discount_fee);

            $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
            $info['data'] = array(
                'status' => '',
            );

            $order_model    = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $order = $order_model->fetchOrderListByTid($trade['t_id']);

            $udata = array(
                'to_num' => $num,
                'to_total' => $order[0]['to_price']*$num
            );
            $order_model->updateById($udata, $order[0]['to_id']);

            //优惠全免, 直接支付成功
            if ($total_fee == 0) {
                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_goods_fee'       => $goods_fee,
                    't_discount_fee'    => $discount_fee,
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_YHQM,
                    't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态,
                    't_pay_time'        => time(),
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //订单活动后续处理
                $trade_helper->dealTradeType($trade);
                $info['data']['status'] = 'zfcg';
            }elseif ($payWay == 2){
                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_goods_fee'          => $goods_fee,
                    't_discount_fee'    => $discount_fee,
                    't_num'             => $num,
                    't_appointment_time'=> isset($time) && $time ? strtotime($time) : '',
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_HDFK,
                    't_pay_time'        => time(),
                    't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态,
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //订单活动后续处理
                $trade_helper->dealTradeType($trade);
                $info['data']['status'] = 'zfcg';
            }elseif ($payWay == 3){
                if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                    $this->outputError('该店铺暂未开启余额支付');
                }
                //判断账户余额是否冻结
                if($this->member['m_gold_freeze']){
                    $this->outputError('账户已被冻结，请联系管理员');
                }
                $status = intval($trade['t_status']);
                if ($status >= App_Helper_Trade::TRADE_HAD_PAY) {
                    //订单已支付
                    $this->outputError("订单已支付");
                }
                //判断会员余额是否足够支付
                $coin   = floatval($this->member['m_gold_coin']);
                $fee    = floatval($total_fee);//订单总价格
                if ($fee > $coin) {
                    $this->outputError("账户余额不足");
                }

                $updata = array(
                    't_total_fee'       => $total_fee,
                    't_goods_fee'          => $goods_fee,
                    't_discount_fee'    => $discount_fee,
                    't_num'                 => $num,
                    't_appointment_time'   => isset($time) && $time ? strtotime($time) : '',
                    't_pay_type'        => App_Helper_Trade::TRADE_PAY_YEZF,
                    't_pay_time'        => time(),
                    't_payment'         => $fee,
                    't_status'          => App_Helper_Trade::TRADE_WAIT_PAY_RETURN,//等待支付完成确认状态,
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                //减少会员金币
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid,$tid, $this->member['m_id'], $fee);
                if($debit){
                    //订单活动后续处理
                    $trade_helper   = new App_Helper_Trade($this->shop['s_id']);
                    $trade_helper->dealTradeType($trade);
                    //多店的余额支付也要记录待结算交易
                    if($trade['t_es_id']){
                        $trade_helper->recordPendingSettled($tid, $trade['t_total_fee'], $trade['t_title'], $trade['t_es_id']);
                    }
                    $info['data']['status'] = 'zfcg';
                }
            }else{
                $updata = array(
                    't_total_fee'          => $total_fee,
                    't_goods_fee'          => $goods_fee,
                    't_discount_fee'       => $discount_fee,
                    't_num'                => $num,
                    't_pay_type'           => App_Helper_Trade::TRADE_PAY_WXZFDX,
                    't_appointment_time'   => isset($time) && $time ? strtotime($time) : '',
                    't_status'             => App_Helper_Trade::TRADE_NO_PAY,//修改订单状态为待支付
                );
                $ret = $trade_model->findUpdateTradeByTid($tid, $updata);

                //是否触发通知
                $trade_helper->sendTradeStatusMessage($tid, App_Helper_Trade::TRADE_MESSAGE_SEND_MJXD);
                //订单置于超时关闭队列
                $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                $trade_redis->setTradeCloseTtl($trade['t_id'], $overTime);
                $info['data']['status'] = 'dzf';
            }

            if($ret){
                $this->outputSuccess($info);
            }else{
                $this->outputError('确认订单失败，请重试');
            }
        }else{
            $this->outputError('订单不存在');
        }
    }

    /*
     * 订单列表、订单条件查询
     */
    public function orderListAction()
    {
        $status = $this->request->getStrParam('status', 'all');   // 订单状态
        $type   = $this->request->getStrParam('type');    //type=points  积分订单，  type=shop  店铺订单   type=act 活动订单
        $where = array();
        // 检索条件
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 't_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 't_status', 'oper' => '<>', 'value' => 0);
        $where[] = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET);

        if($type == 'shop'){
            $where[] = array('name' => 't_es_id', 'oper' => '!=', 'value' => 0);
        }

        if($type == 'points'){
            $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_POINT);
            $where[] = array('name' => 't_status', 'oper' => '>', 'value' => 2);
            $where[] = array('name' => 't_status', 'oper' => '<', 'value' => 7);
        }

        if($type == 'act'){
            $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 't_applet_type', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_APPLET_POINT);
        }

        // 获取订单状态
        $link = App_Helper_Trade::$trade_link_status;

        if ($status) {
            if($status == 'comment'){
                $where[] = array('name' => 't_had_comment', 'oper' => '=', 'value' => 0);
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link['finish']['id']);
            }elseif($status == 'finish'){
                $where[] = array('name' => 't_had_comment', 'oper' => '=', 'value' => 1);
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$status]['id']);
            }elseif($link[$status]['id']>0){
                $where[] = array('name' => 't_status', 'oper' => '=', 'value' => $link[$status]['id']);
            }
        }
        $data = $this->show_trade_list_data($where, $type);
        if ($data) {
            $info['data'] = $data;
            $this->outputSuccess($info);
        } else {
            $this->outputError('订单数据加载完毕');
        }
    }


    private function show_trade_list_data($where = array(), $type)
    {
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $sort = array('t_create_time' => 'DESC');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $list = $trade_model->getList($where, $index, $this->count, $sort);

        if ($list) {
            if($type == 'shop'){
                $statusNote = $this->order_shop_status_desc;
            }else{
                $statusNote = $this->order_status_desc;
            }

            $data = array();
            foreach ($list as $val) {
                /*if($val['t_status'] == App_Helper_Trade::TRADE_FINISH && !$val['t_had_comment']){
                    $statusDesc = '待评价';
                }else{*/
                    $statusDesc = isset($statusNote[$val['t_status']]) ? $statusNote[$val['t_status']] : '';
                //}
                $data[] = array(
                    'tid'           => $val['t_tid'],
                    'nickname'      => $val['t_buyer_nick'],
                    'paytype'       => $val['t_pay_type'],
                    'cover'         => plum_deal_image_url($val['t_pic']),
                    'title'         => $val['t_title'],
                    'num'           => $val['t_num'],
                    'total'         => $val['t_total_fee'],
                    'discount'      => $val['t_discount_fee'],
                    'freight'       => $val['t_post_fee'],
                    'express_code'  => $val['t_express_code'],
                    'status'        => $val['t_status'],
                    'statusNote'    => $statusDesc,
                    'feedback'      => $val['t_feedback'],
                    'fdstatus'      => $val['t_fd_status'],
                    'result'        => $val['t_fd_result'],
                    'iscomment'     => $this->shop['s_order_comment'] == 0 ? 1 : $val['t_had_comment'],
                    'time'          => date('Y-m-d H:i:s', $val['t_create_time']),
                    'paytime'       => isset($val['t_pay_time']) && $val['t_pay_time'] ? date('Y-m-d H:i:s', $val['t_pay_time']) : '',
                    'goods'         => $this->show_trade_goods_detail_data($val['t_id']),
                );
            }
            return $data;
        } else {
            return false;
        }
    }

    //订单详情
    public function orderDetailsAction()
    {
        $tid = $this->request->getStrParam('tid');  // 订单编号
        if ($tid) {
            $trade = $this->show_trade_details_data($tid);
            if($trade){
                $info['data'] = $trade;
                $this->outputSuccess($info);
            }else{
                $this->outputError('订单不存在或已被删除');
            }
        } else {
            $this->outputError('网络链接错误请重试！');
        }
    }


    /*
     * 订单详情数据展示
     */
    private function show_trade_details_data($tid){
        $data = array();
        if ($tid) {
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $trade = $trade_model->getRowBySid($tid);
            if ($trade) {
                if($trade['t_es_id']>0){
                    $statusNote = $this->order_shop_status_desc;
                }else{
                    $statusNote = $this->order_status_desc;
                }

                /*if($trade['t_status'] == App_Helper_Trade::TRADE_FINISH && !$trade['t_had_comment']){
                    $statusDesc = '待评价';
                }else{*/
                    $statusDesc = isset($statusNote[$trade['t_status']]) ? $statusNote[$trade['t_status']] : '';
                //}
                $payType = App_Helper_Trade::$trade_pay_type_note;
                $verify = $this->_fetch_order_verify($trade);

                $data = array(
                    'id'            => $trade['t_id'],
                    'tid'           => $trade['t_tid'],
                    'title'         => $trade['t_title'],
                    'num'           => $trade['t_num'],
                    'total'         => $trade['t_total_fee'],
                    'points'        => floor($trade['t_points']),
                    'nickname'      => $trade['t_buyer_nick'],
                    'status'        => $trade['t_status'],
                    'statusNote'     => $statusDesc,
                    'needExpress'   => $trade['t_need_express'],
                    'expressCompany'=> isset($trade['t_express_company']) && $trade['t_express_company'] ? $trade['t_express_company'] : '无需物流',
                    'expressCode'   => isset($trade['t_express_code']) && $trade['t_express_code'] ? $trade['t_express_code'] : '无需物流',
                    'freight'       => $trade['t_post_fee'],
                    'goodsFee'      => $trade['t_goods_fee'],
                    'discount'      => $trade['t_discount_fee'],
                    'feedback'      => $trade['t_feedback'],
                    'fdstatus'      => $trade['t_fd_status'],
                    'result'        => $trade['t_fd_result'],
                    'consignee'     => isset($trade['ma_name']) ? $trade['ma_name'] : '',
                    'phone'         => isset($trade['ma_phone']) ? $trade['ma_phone'] : '',
                    'postcode'      => isset($trade['ma_post']) ? $trade['ma_post'] : '',
                    'postDesc'      => "恭喜您兑换成功！商品将在".date('m月d日', $trade['t_pay_time'])."开始陆续发货！",
                    'address'       => $trade['ma_province'] . $trade['ma_city'] . $trade['ma_zone'] . $trade['ma_detail'],
                    'createTime'    => date('Y-m-d H:i:s', $trade['t_create_time']),
                    'payType'       => $trade['t_pay_type'],
                    'payTypeNote'   => $payType[$trade['t_pay_type']],
                    'payTime'       => isset($trade['t_pay_time']) && $trade['t_pay_time'] ? date('Y-m-d H:i:s', $trade['t_pay_time']) : '',
                    'goods'         => $this->show_trade_goods_detail_data($trade['t_id'], $trade['t_extra_data']),
                    'compartment'   => $trade['t_home'],
                    'remarks'       => $trade['t_note'],
                    'isComment'    => $this->shop['s_order_comment'] == 0 ? 1 : $trade['t_had_comment'],
                    'orderType'    => $trade['t_applet_type'],
                    'shop'         => $this->_get_shop_info($trade['t_es_id']),
                    'qrcode'       => $this->dealImagePath($trade['t_qrcode']),
                    'verifyCode'   => $verify['code'],
                    'verifyQrcode' => $verify['qrcode'],
                );
                $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                $goods = $goods_model->getRowById($data['goods'][0]['gid']);
                $data['virtual'] = $goods['g_type']==5?1:0;
            }
        }
        return $data;
    }


    /*
    * 订单商品详情数据
     */
    private function show_trade_goods_detail_data($tid)
    {
        //获取交易订单商品
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $order = $order_model->fetchOrderListByTid($tid);
        $data = array();
        if ($order) {
            foreach ($order as $val) {
                $data[] = array(
                    'toid'  => $val['to_id'],
                    'gid'   => $val['to_g_id'],
                    'title' => $val['to_title'],
                    'spec'  => isset($val['to_gf_name']) ? $val['to_gf_name'] : '',
                    'img'   => isset($val['to_pic']) ? plum_deal_image_url($val['to_pic']) : '',
                    'price' => $val['to_price'],
                    'num'   => $val['to_num'],
                    'total' => $val['to_total'],
                    'brief' => $val['to_g_brief'],
                    'type'  => $val['to_type']
                );
            }
        }
        return $data;
    }

    /*
     * 订单支付成功之后，获取订单详情相关，包括店铺是否开启答题以及赠送抽奖次数相关
     */
    public function orderFinishDetailAction(){
        $tid          = $this->request->getStrParam('tid');  //订单号
        $trade_model  = new App_Model_Trade_MysqlTradeStorage($this->sid);
        if($tid){
            $trade   = $trade_model->findUpdateTradeByTid($tid);
            $payType = App_Helper_Trade::$trade_pay_type_note;
            $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
            $shop       = $shop_model->getRowById($trade['t_s_id']);
            //判断是否开启答题活动
            $subject_model = new App_Model_Answer_MysqlAnswerCfgStorage($this->sid);
            $subject       = $subject_model->fetchUpdateCfg();

            if($trade){
                $data = array(
                    'total'     => floatval($trade['t_total_fee']),  //商品总价
                    'discount'  => floatval($trade['t_discount_fee']) + floatval($trade['t_promotion_fee']),   //优惠金额 = 优惠券 + 满减
                    'points'    => floatval($trade['t_points']),          //订单积分
                    'paytype'   => $payType[$trade['t_pay_type']],  //支付方式
                    'paytypeId' => intval($trade['t_pay_type']),
                    'shopname'  => $shop['s_name'],                   //店铺名称
                    'openPrize' => intval($shop['s_isopen_prize']),    //是否开启订单完成后抽奖 1开启
                    'prizeNum'  => intval($shop['s_send_pnum']),       //赠送的次数
                    'prizeImg'  => !empty($shop['s_prize_cover'])?$this->dealImagePath($shop['s_prize_cover']):'',
                );
                if($subject && $subject['asc_open']){
                    $data['openSubject'] = intval($subject['asc_isopen_subject']);
                    $data['subjectNum']  = intval($subject['asc_send_snum']);
                    $data['subjectImg']  = !empty($subject['asc_subject_cover'])?$this->dealImagePath($subject['asc_subject_cover']):'';
                    $data['subjectType'] = intval($subject['asc_subject_type']);  //1 红包  2奖品  3积分赛
                }else{
                    $data['openSubject'] = 0;
                    $data['subjectNum']  = 0;
                    $data['subjectImg']  = '';
                    $data['subjectType'] = '';
                }
                $returnModel = new App_Model_Shop_MysqlOrderReturnStorage($this->sid);
                $return = $returnModel->findUpdateDeductByTid($tid);
                if($return){
                    $data['return'] = $return['or_return'];
                }
        
                // 营销商城下单获取优惠券
                // zhangzc
                // 2019-10-28
                if($this->applet_cfg['ac_type']==21)
                    $data['couponInfo']=$this->getTradeCoupon($trade);

                $this->deal_prize_subject($shop,$subject,$trade['t_m_id']);
                $info['data'] = $data;
                $this->outputSuccess($info);
            }else{
                $this->outputError('该订单不存在');
            }
        }
    }
    /**
     * 获取订单满减的优惠券
     * 满减优惠券的发放规则，订单金额满足优惠券设置的金额时查找可用的优惠券（未超出领取限制的），然后按照面额进行排序找到最大的面额的优惠券发放给用户
     * zhanzgc
     * 2019-10-28
     * @param  [type] $trade [description]
     * @return [type]        [description]
     */
    private function getTradeCoupon($trade){
        $final_coupon_id='';
        // 获取到店铺所有的可用的满减优惠券
        $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
        $where=[
            ['name'=>'cl_s_id','oper'=>'=','value'=>$this->sid],
            ['name'=>'cl_coupon_type','oper'=>'=','value'=>4],
            ['name'=>'cl_deleted','oper'=>'=','value'=>0],
            ['name'=>'cl_start_time','oper'=>'<','value'=>time()],
            ['name'=>'cl_end_time','oper'=>'>','value'=>time()]
        ];
        $fields=['cl_id','cl_use_end_time','cl_use_days','cl_receive_limit','cl_receive_day_limit','cl_coupon_receive_limit','cl_face_val','cl_use_limit','cl_coupon_type'];
        $coupon_list=$coupon_model->getList($where,0,0,[],$fields);

        // 找出当前订单金额满足条件的优惠券
        $usable_coupons=[];
        foreach ($coupon_list as $key => $val) {
            if(intval($val['cl_coupon_receive_limit']) <= $trade['t_total_fee']){
                $usable_coupons['i_'.$val['cl_id']]=$val;
            }
        }
        if(empty($usable_coupons))
            return null;
        // 按照优惠券的面额进行倒序排序
        array_multisort(array_column($usable_coupons,'cl_face_val'),SORT_DESC,$usable_coupons);

        $coupon_ids=array_column($usable_coupons,'cl_id');

        // 查看用户是否领取了指定的优惠券限制
        $coupon_receive_model=new App_Model_Coupon_MysqlReceiveStorage();
        $receive_records=$coupon_receive_model->getRecieveRecords($coupon_ids,TRUE);
        if($receive_records){
            $records_cids=array_column($receive_records,'cr_c_id');
            foreach($coupon_ids as $v){
                // 有领取记录
                if(in_array($v, $records_cids)){
                    $limit          =$usable_coupons['i_'.$v]['cl_receive_limit'];
                    $receive_count  =$receive_records[$v]['receives'];
                    // 有限制领取
                    if($limit){
                        if($receive_count < $limit){
                            $final_coupon_id=$v;
                            break;
                        }
                    }else{
                        $final_coupon_id=$v;
                        break;
                    }
                //无领取记录 
                }else{
                    $final_coupon_id=$v;
                    break;
                }
            }
            
        //没有记录的直接拿出来一个 
        }else{
            $final_coupon_id=$coupon_ids[0];
        }
    
        if(empty($final_coupon_id))
            return FALSE;

        // 执行用户的领券操作
        $exec_get=$coupon_receive_model->insertValue([
            'cr_s_id'           =>$this->sid,
            'cr_m_id'           =>$this->uid,
            'cr_c_id'           =>$final_coupon_id,
            'cr_receive_time'   =>time(),
            'cr_expire_time'    => $usable_coupons['i_'.$final_coupon_id]['cl_use_end_time'],
            'cr_receive_type'   =>2, //赠送的,
            'cr_t_id'           =>$trade['t_id']
        ]);
        // 执行优惠券的领取数量操作
        $exec_update=$coupon_model->incrementReceiveCount($final_coupon_id);
        if($exec_get && $exec_update){
            $coupon_info=[
                'cl_id'             =>$final_coupon_id,
                'cl_use_limit'      =>$usable_coupons['i_'.$final_coupon_id]['cl_use_limit'],
                'cl_face_val'       =>$usable_coupons['i_'.$final_coupon_id]['cl_face_val'],
                'cl_use_end_time'   =>$usable_coupons['i_'.$final_coupon_id]['cl_use_end_time'],
                'cl_coupon_type'    =>$usable_coupons['i_'.$final_coupon_id]['cl_coupon_type'],
            ];
            return  $coupon_info;
        }
    }

    private function deal_prize_subject($shop,$subject,$uid){
        $lottety_model  = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        if($shop['s_isopen_prize']){
            $lotteryList    = $lottety_model->getLotteryRow();
            $number_model   = new App_Model_Meeting_MysqlMeetingLotteryNumberStorage($this->sid);
            //判断用户的是否参加过抽奖活动
            $numberList     = $number_model->checkMemNum($uid,$lotteryList['amll_id']);
            if($numberList){   //说明参加过，增加抽奖次数
                $set   = array('amln_num'=>$numberList['amln_num']+$shop['s_send_pnum']);
                $number_model->checkMemNum($uid,$lotteryList['amll_id'],$set);
            }else{
                //增加抽奖次数，插入一条新的新的记录
                $number_model->insertMemNum($uid,$lotteryList['amll_id'],$lotteryList['amll_frequency'],$shop['s_send_pnum']);
            }
        }
        //处理答题相关
        if($subject['asc_open'] && $subject['asc_isopen_subject']){
            $member_model  = new App_Model_Member_MysqlMemberCoreStorage();
            $memberRow     = $member_model->findUpdateMemberByUidSid($uid,$this->sid);
            $set           = array('m_revive_card'=>$memberRow['m_revive_card']+$subject['asc_send_snum']);
            $member_model->findUpdateMemberByUidSid($uid,$this->sid,$set);
        }


    }

    /*
     * 核销订单
     */
    public function confirmAcceptAction() {
        $tid    = $this->request->getStrParam('tid');
        $trade_model= new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        if($trade){
            // 判断是否是自己的订单
            if($trade['t_s_id'] == $this->sid){
                // 判断订单状态是否是待收货状态
                if($trade['t_status'] == App_Helper_Trade::TRADE_HAD_PAY){
                    $updata = array(
                        't_finish_time' => time(),
                        't_status'      => App_Helper_Trade::TRADE_FINISH,//置于完成状态
                    );
                    $trade_helper   = new App_Helper_Trade($this->sid);
                    //是否触发通知
                    $trade_helper->sendTradeStatusMessage($tid, App_Helper_Trade::TRADE_MESSAGE_SEND_MJSH);
                    $trade_helper->dealCompleteTrade($trade);//处理订单完成后续
                    //清除自动完成状态定时
                    $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
                    $trade_redis->delTradeFinish($trade['t_id']);
                    //清除待结算状态 确认收货7天后再结算
                    $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
                    $settled        = $settled_model->findSettledByTid($tid);
                    if ($settled && $settled['ts_status'] == App_Helper_Trade::TRADE_SETTLED_PENDING) {
                        $set = array('ts_order_finish_time' => time());
                        $settled_model->updateById($set, $settled['ts_id']);
                        if($this->shop['s_enter_settle'] > 0) {
                            $countdown = plum_parse_config('trade_overtime');
                            $trade_redis = new App_Model_Trade_RedisTradeStorage($this->sid);
                            $trade_redis->setTradeSettledTtl($settled['ts_id'], $this->shop['s_enter_settle'] ? $this->shop['s_enter_settle'] * 24 * 60 * 60 : $countdown['settled']);
                        }else{
                            $trade_redis->delTradeSettledTtl($settled['ts_id']);
                            $trade_helper->recordEnterShopSuccessSettled($settled['ts_id']);
                        }
                    }
                    $ret = $trade_model->findUpdateTradeByTid($tid, $updata);
                    //交易佣金提成通知
                    $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
                    $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);
                    //增加商品销量
                    $trade_helper->modifyGoodsSold($trade['t_id']);
                    // 收货完成向管理员发送推送通知
                    $help_model = new App_Helper_XingePush($this->sid);
                    $help_model->pushNotice($help_model::TRADE_FINISH);  // 推送确认收货通知
                    $notice_model = new App_Helper_JiguangPush($this->sid);
                    $notice_model->pushNotice($notice_model::TRADE_FINISH);
                    // 小程序订单推送模板消息
                    plum_open_backend('index', 'wxappTempl', array('sid' => $this->sid, 'tid' => $tid, 'type' => App_Helper_WxappApplet::SEND_SETUP_QRSH));

                    if($ret){
                        $info['data'] = array(
                            'result' => true,
                            'msg'    => '确认收货成功',
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('确认收货失败');
                    }
                }else{
                    $this->outputError('订单状态不正确');
                }
            }else{
                $this->outputError('非法操作');
            }
        }else{
            $this->outputError('订单不存在');
        }
    }

    /**
     * 积分明细列表
     */
    public function pointDetailsListAction(){
        $type    = $this->request->getIntParam('type');
        $page    = $this->request->getIntParam('page');
        $index   = $page * $this->count;
        $inout_storage = new App_Model_Point_MysqlInoutStorage($this->sid);
        $where=array();
        if($type){
            $where[]    = array('name' => 'pi_type', 'oper' => '=', 'value' => $type);
        }
        $where[]    = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $sort       = array('pi_create_time' => 'DESC');
        $point      = $inout_storage->getList($where,$index, $this->count,$sort);
        $type= App_Helper_Point::$source_status;
        if($point){
            $info=array();
            foreach($point as $k=>$v){
                if($v['pi_extra']){
                    $desc=$type[$v['pi_source']].'('.$v['pi_extra'].')';
                }else{
                    $desc=$type[$v['pi_source']];
                }
                $info['data'][]=array(
                    'type'  => $v['pi_type'],
                    'point' => floor($v['pi_point']),
                    'source'=> $type[$v['pi_source']] ? $type[$v['pi_source']] : '',
                    'time'  => date('Y-m-d H:i:s', $v['pi_create_time']),
                    'desc'  => $desc?$desc:$v['pi_title'],
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有相关明细');
        }
    }

    /**
     * 帖子点赞或取消点赞
     */
    public function postLikeAction(){
        $pid  = $this->request->getIntParam('pid');
        $like_model = new App_Model_Community_MysqlCommunityPostLikeStorage($this->sid);
        // 是否已经点过赞
        $row = $like_model->getLikeByMidPid($this->member['m_id'],$pid);
        $info['data'] = array(
            'result' => true,
            'msg'    => ''
        );
        // 已经点过赞
        if($row){
            $like_model->deleteById($row['cpl_id']);
            $info['data']['msg'] = '取消成功';
            $info['data']['isLike'] = 0;
            // 减少帖子点赞数量
            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $post_model->addReducePostNum($pid,'like','reduce');
            $this->outputSuccess($info);
        }else{
            $data = array(
                'cpl_s_id'   => $this->sid,
                'cpl_m_id'   => $this->member['m_id'],
                'cpl_acp_id' => $pid,
                'cpl_time'   => time()
            );
            $like_model->insertValue($data);
            $info['data']['msg'] = '点赞成功';
            $info['data']['isLike'] = 1;
            // 增加帖子点赞数量
            $post_model = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $post_model->addReducePostNum($pid,'like','add');
            $this->outputSuccess($info);
        }
    }

    /*
     * 获得我的入驻门店信息
     */
    public function getUserShopInfoAction(){
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        //$apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->sid);
        //获得分类
        $category_model = new App_Model_Community_MysqlKindStorage($this->sid);
        $category_list = $category_model->getListBySid();
        $category = array();
        if($category_list){
            foreach ($category_list as $val){
                $category[$val['ack_id']] = $val['ack_name'];
            }
        }
        //获得商圈
        $district_model = new App_Model_Community_MysqlCommunityDistrictStorage($this->sid);
        $districtList = $district_model->getListBySid();

        $shop = $es_model->findShopByUser($this->sid,$this->member['m_id'],FALSE);
        $data = array();
        if($shop){


            //审核通过且未被删除 获得enter_shop表信息
            $data = array(
                'id'        => intval($shop['es_id']),
                'logo'      => $shop['es_logo'] ? $this->dealImagePath($shop['es_logo']) : '',
                'logoTemp'  => $shop['es_logo'] ? $shop['es_logo'] : '',
                'name'      => $shop['es_name'],
                'contact'   => $shop['es_contact'] ? $shop['es_contact'] :'',
                'mobile'    => $shop['es_phone'] ? $shop['es_phone'] : '',
                'vrurl'     => $shop['es_vr_url'] ? $shop['es_vr_url'] : '',
                'address'   => $shop['es_addr'] ? $shop['es_addr'] : '',
                'detail'    => $shop['es_addr_detail'] ? $shop['es_addr_detail'] : '',
                'cate1'     => $shop['es_cate1'],
                'cate2'     => $shop['es_cate2'],
                'lng'       => $shop['es_lng'],
                'lat'       => $shop['es_lat'],
                'cateName' => $shop['es_cate1'] && $shop['es_cate2'] ? $category[$shop['es_cate1']].'-'.$category[$shop['es_cate2']] : '',
                'city'      => $shop['es_city'] && !$shop['es_district2'] ? intval($shop['es_city']) : $districtList[$shop['es_district2']]['acd_city_id'],
                'district1' => $shop['es_district1'],
                'district2' => $shop['es_district2'],
                'districtName' => $shop['es_district2'] ? $districtList[$shop['es_district2']]['acd_area_name'].'-'.$districtList[$shop['es_district2']]['acd_name'] : '',
                'license'   => $shop['es_license'] ? $this->dealImagePath($shop['es_license']) : ($shop['acsa_license'] ? $this->dealImagePath($shop['acsa_license']) : ''),
                'licenseTemp'   => $shop['es_license'] ? $shop['es_license'] : ($shop['acsa_license'] ? $shop['acsa_license'] : ''),

                'cardFront'   => $shop['es_card_front'] ? $this->dealImagePath($shop['es_card_front']) : '',
                'cardFrontTemp'   =>$shop['es_card_front'] ? $shop['es_card_front'] : '',
                'cardBack'   => $shop['es_card_back'] ? $this->dealImagePath($shop['es_card_back']) : '',
                'cardBackTemp'   =>$shop['es_card_back'] ? $shop['es_card_back'] : '',
                'inviteCode' => $shop['es_invite_code'] ? $shop['es_invite_code'] : '',
                'reservePhone' => plum_is_mobile($shop['es_reserve_phone']) ? $shop['es_reserve_phone'] : '',
                'prov' => intval($shop['es_prov']),
                'zone' => intval($shop['es_zone']),
                'provName' => $shop['es_prov_name'] ? $shop['es_prov_name'] : '',
                'cityName' => $shop['es_city_name'] ? $shop['es_city_name'] : '',
                'zoneName' => $shop['es_zone_name'] ? $shop['es_zone_name'] : '',
                'shopType' => intval($shop['es_shop_type']),

//                'editApply' => 0,
                'status'    => $shop['es_handle_status'], //通过
                'expireTime'=> $shop['es_expire_time'] ? date('Y-m-d',$shop['es_expire_time']) : '',


                'loginUrl'  => $this->entershop_login_url,
                'account'   => $shop['esm_mobile'] ? $shop['esm_mobile'] : '',
                'password'  => $shop['esm_mobile'] ? $shop['esm_mobile'] : '',
                'openTime'  => $shop['es_business_time'] && $shop['es_close_time'] ?$shop['es_business_time'].'-'.$shop['es_close_time'] : '',
                'showNum'   => $shop['es_show_num'],//访问量
                'balance' => floatval($shop['es_balance']),//可提现
            );

            //待结算总额
            $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($shop['es_id']);
            $noSettled      = $settled_model->statisticEnterShopNoSettled();
            $data['noSettled'] = floatval($noSettled);
        }else{
            $this->outputError('未找到入驻信息');
        }
//        else{
//            //审核未通过或店铺被删除 获得申请表
//            $shop = $apply_model->findRowByMidNoDelete($this->member['m_id']);
//            if($shop) {
//                $data = [
//                    'id'   => intval($shop['acsa_id']),
//                    'logo' => '',
//                    'logoTemp' => '',
//                    'name' => $shop['acsa_shop_name'],
//                    'contact' => $shop['acsa_contacts'] ? $shop['acsa_contacts'] : '',
//                    'mobile' => $shop['acsa_mobile'],
//                    'vrurl' => $shop['acsa_vr_url'] ? $shop['acsa_vr_url'] :'',
//                    'address' => $shop['acsa_addr'] ? $shop['acsa_addr'] : '',
//                    'detail' => $shop['acsa_addr_detail'] ? $shop['acsa_addr_detail'] :'',
//                    'cate1' => $shop['acsa_cate1'],
//                    'cate2' => $shop['acsa_cate2'],
//                    'lng'   => $shop['acsa_lng'],
//                    'lat'   => $shop['acsa_lat'],
//                    'cateName' => $shop['acsa_cate1'] && $shop['acsa_cate2'] ? $category[$shop['acsa_cate1']] . '-' . $category[$shop['acsa_cate2']] : '',
//                    'district1' => $shop['acsa_district1'],
//                    'district2' => $shop['acsa_district2'],
//                    'districtName' => $shop['acsa_district2'] ? $districtList[$shop['acsa_district2']]['acd_area_name'] . '-' . $districtList[$shop['acsa_district2']]['acd_name'] : '',
//                    'licenseTemp'   => $shop['acsa_license'] ? $shop['acsa_license'] : '',
//                    'license'   => $shop['acsa_license'] ? $this->dealImagePath($shop['acsa_license']) : '',
////                    'editApply' => 1,
//                    //'status'    => $shop['acsa_status'] == 2 ? 3 : $shop['acsa_status'],//通过且被删除 返回未通过
//                    'status'    => $shop['acsa_status'] == 2 ? 3 : $shop['acsa_status'],//通过且被删除 返回未通过
//                    'expireTime'=> '',
//                ];
//            }else{
//                $this->outputError('未找到入驻信息');
//            }
//        }

        $info['data'] = $data;
        $this->outputSuccess($info);

    }

    /*
     * 入驻支付  先支付后入驻
     */
    public function applyPayAction(){
        $payType   = $this->request->getIntParam('payType',1); //支付方式  1在线支付  3余额支付
        $appid     = $this->request->getStrParam('appid');
        $costId    = $this->request->getIntParam('costId');
        $mobile    = $this->request->getIntParam('mobile','');   // 联系电话
        $type      = $this->request->getStrParam('type',''); //类型  apply 申请入驻, renew 续费

        $appletType = $this->request->getIntParam('appletType');

        //$apply_model = new App_Model_Community_MysqlCommunityShopApplyStorage($this->sid);
        $es_model =new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        //入驻 验证是否已经申请
        if($type == "apply"){
          $has_shop = $es_model->findShopByUser($this->sid,$this->member['m_id'],false);
            if($has_shop){
                $this->outputError('您已申请入驻，请勿重复申请');
            }
        }

        if($mobile){
            if(mb_strlen($mobile)<7){
                $this->outputError('请填写正确的手机号或固话');
            }

            $manage_model = new App_Model_Entershop_MysqlManagerStorage();
            $has_manager = $manage_model->findManagerByMobile($mobile);
            if ($has_manager) {
                $this->outputError('手机号或固话已被使用');
            }
            //  验证手机号是否已经申请
            $has_apply = $es_model->findRowByMobile($mobile);
            if ($has_apply) {
                $this->outputError('手机号或固话已被使用');
            }
        }
        // 支付配置
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payCfg = $pay_type->findRowPay();
        // 生成订单编号
        $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);

        //获取费用配置
        $cost_model = new App_Model_Community_MysqlCommunityEnterCostStorage($this->sid);
        $cost = $cost_model->getRowById($costId);

        if($payType == 1){ //微信支付
             // 头条小程序 支付
            // zhangzc
            // 2019-08-14
            if($appletType==4){
                $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCommunityApplyPay';//回调地址
                $acount = 0;
                $acount += $cost['acec_cost'];

                $openid     = $this->member['m_openid'];
                switch ($type){
                    case 'apply':
                        $bodyNote = '支付入驻费用';
                        break;
                    case 'renew':
                        $bodyNote = '支付续费费用';
                        break;
                    default:
                        $bodyNote = '支付入驻费用';
                }
                $body   = $bodyNote;
                $attach = array(
                    'suid'       => $this->shop['s_unique_id'],
                    'mid'        => $this->member['m_id'],
                    'costId'     => $costId,
                    'costDate'   => $cost['acec_date'],
                    'appid'      => $appid,
                    //'appletType' => 'toutiao'
                );
                // 获取超时关闭时间
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
                $result = $pay_storage->appletOrderPayRecharge($acount, $openid, $number, $alipay_notify_url, $body, time(), $overTime, $attach);
                if (is_array($result) && !$result['code']) {
                    if($this->sid == '12228'){
                        $dealTitle = '店铺入驻';
                        $params = array(
                            'merchant_id'       => $result['biz_content']['merchant_id'],
                            'app_id'            => $result['appid'],
                            'sign_type'         => 'MD5',
                            'timestamp'         => $result['timestamp'],
                            'product_code'      => 'pay',
                            'payment_type'      => 'direct',
                            'out_order_no'      => $result['trade_no'],
                            'uid'               => $result['uid'],
                            'total_amount'      => $result['biz_content']['total_amount'],
                            'currency'          => 'CNY',
                            'subject'           => $dealTitle,
                            'body'              => $dealTitle,
                            'trade_time'        => time(),
                            'valid_time'        => 1800,
                            'notify_url'        => plum_get_base_host(),
                            'alipay_url'        => $result['params_url'],
                            'wx_url'            => '',//$result['wxinfo'] && $result['wxinfo']['mweb_url'] ? $result['wxinfo']['mweb_url'] : '',
                            'version'           => '2.0',
                        );
                        if($params['wx_url'] && $result['wxinfo'] && $result['wxinfo']['trade_type']){
                            $params['wx_type'] = $result['wxinfo']['trade_type'];
                        }
                        $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                        $params['risk_info']   = $result['biz_content']['risk_info'];
                        $params['service']     = 1;
                    }else{
                        $params = array(
                            'app_id'      => $result['appid'],
                            'timestamp'   => $result['timestamp'],
                            'trade_no'    => $result['trade_no'],
                            'merchant_id' => $result['biz_content']['merchant_id'],
                            'uid'         => $result['uid'],
                            'total_amount' => $result['biz_content']['total_amount'],
                            'sign_type'   => 'MD5',
                            'params'      => json_encode(array(
                                'url' => $result['params_url']
                            )),
                        );
                        $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                        $params['params']      = $result['params_url'];
                        $params['method']      = 'tp.trade.confirm';
                        $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                        $params['pay_type']    = 'ALIPAY_APP';
                        $params['risk_info']   = $result['biz_content']['risk_info'];
                    }
                    $info['data'] = array(
                        'result' => true,
                        'number' => $number,
                        'params' => $params,
                    );

                    $this->outputSuccess($info);
                } else{
                    $this->outputError('支付错误，请稍后重试');
                }      
            }else{
                // 判断是否开启微信支付
                if(!$payCfg || ($payCfg && $payCfg['pt_wxpay_applet']==0)){
                    $this->outputError('该商户暂未开启微信支付');
                }
               //判断是否填写小程序端的微信支付配置
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();
                if(!$appcfg){
                    $this->outputError('该商户暂未填写微信支付配置');
                }
                $pay_type_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
                $payType = $pay_type_storage->findRowPay();
                if(!$payType || ($payType && $payType['pt_wxpay_applet']==0)){
                    $this->outputError('该店铺暂未开启微信支付');
                }
                $acount = 0;

                switch ($type){
                    case 'apply':
                        $bodyNote = '支付入驻费用';
                        break;
                    case 'renew':
                        $bodyNote = '支付续费费用';
                        break;
                    default:
                        $bodyNote = '支付入驻费用';
                }

                if($cost && $cost['acec_cost'] > 0){
                    $acount += $cost['acec_cost'];
                    $body   = $bodyNote;
                    $openid     = $this->member['m_openid'];
                    $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                    $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCommunityApplyPay';//回调地址

                    $attach = array(
                        'suid'  => $this->shop['s_unique_id'],
                        'mid'   => $this->member['m_id'],
                        'costId' => $costId,
                        'costDate'=> $cost['acec_date'],
                        'appid' => $appid
                    );

                    if($this->sid == 4546 || $this->sid == 5741){
                        $acount = 0.01;
                    }
                    $other      = array(
                        'attach'    => json_encode($attach),
                    );
                    //获取分身小程序信息
                    $child_cfg = new App_Model_Applet_MysqlChildStorage();
                    $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
                    if($child){
                        $result = $pay_storage->appletChildOrderPayRecharge($appid,$acount,$openid,$number,$notify_url,$body,$other);
                    }else{
                        // 生成支付参数
                        $result = $pay_storage->appletOrderPayRecharge($acount,$openid,$number,$notify_url,$body,$other);
                    }

                    if (is_array($result)) {
                        $params = array(
                            'appId'     => $result['appid'],
                            'timeStamp' => strval(time()),
                            'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                            'package'   => "prepay_id={$result['prepay_id']}",
                            'signType'  => 'MD5',
                        );
                        $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $result['app_key']);
                        $info['data'] = array(
                            'result' => true,
                            'number' => $number,
                            'params' => $params,
                        );
                        $this->outputSuccess($info);
                    }else{
                        $this->outputError('支付错误，请稍后重试..');
                    }
                }else{
                    $this->outputError('支付错误，请稍后重试.');
                }
            }
        }elseif($payType==3){ // 余额支付
            // 判断是否开启余额支付
            if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                $this->outputError('该商户暂未开启余额支付');
            }
            //判断账户余额是否冻结
            if($this->member['m_gold_freeze']){
                $this->outputError('账户已被冻结，请联系管理员');
            }
            $acount = 0;
            if($cost && $cost['acec_cost'] > 0) {
                $acount += $cost['acec_cost'];

                //判断会员余额是否足够支付
                $coin = floatval($this->member['m_gold_coin']);
                $fee = floatval($acount);    //支付总费用
                if ($fee > $coin) {
                    $this->outputError("账户余额不足");
                }
                $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->shop['s_id']);
                $record = $pay_model->findUpdateByNumber($number);
                // 如果订单号存在则重新生成一个
                if ($record) {
                    $number = App_Plugin_Weixin_NewPay::makeMchOrderid($this->sid);
                }
                //减少会员金币
                $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                // 记录使用记录
                App_Helper_MemberLevel::rechargeRecord($this->sid, $number, $this->member['m_id'], $fee);
                if ($debit) {
                    $data = [
                        'acap_s_id' => $this->shop['s_id'],
                        'acap_number' => $number,
                        'acap_create_time' => time(),
                        'acap_date' => isset($cost['acec_date']) && $cost['acec_date'] ? $cost['acec_date'] : 0,
                        'acap_money' => $fee,
                        'acap_pay_type' => 3 // 余额支付
                    ];
                    $ret = $pay_model->insertValue($data);
                    if ($ret) {
                        $info['data'] = [
                            'result' => TRUE,
                            'number' => $number,
                            'msg' => '支付成功',
                            'params' => '',
                        ];
                        $this->outputSuccess($info);
                    }
                    else {
                        $this->outputError('支付错误，请稍后重试...');
                    }
                }
                else {
                    $this->outputError('支付错误，请稍后重试..');
                }
            }else{
                $this->outputError('支付错误，请稍后重试.');
            }
        }else{
            $this->outputError('支付方式错误');
        }
        
    }














    /**
     * 续费
     */
    public function shopRenewAction(){
        $esId = $this->request->getIntParam('id',0);
        $number = $this->request->getStrParam('number');
        if($esId && $number){
            $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
//            $where = array();
//            $where[] = array('name'=>'es_id' , 'oper'=> '=' , 'value'=> $esId);
//            $where[] = array('name'=>'es_m_id' , 'oper'=> '=' , 'value'=> $this->member['m_id']);
            $enterShop = $es_model->getRowById($esId);
            if($enterShop){
                $pay_model = new App_Model_Community_MysqlCommunityApplyPayStorage($this->sid);
              $record = $pay_model->findUpdateByNumber($number);
              if($record){
                  $dateLong = $record['acap_date']; //单位 天
                  $expireTime = $dateLong*86400;
                  if($enterShop['es_expire_time'] > time()){
                      $set = array(
                          'es_expire_time' => $enterShop['es_expire_time'] + $expireTime
                      );
                  }else{
                      $set = array(
                          'es_expire_time' => time() + $expireTime
                      );
                  }
                  $ret = $es_model->updateById($set,$esId);
                  if($ret){
                      //将店铺id更新至订单
                      $pay_model->findUpdateByNumber($number,array('acap_es_id'=>$esId));

                      if($this->appletType == 4) {
                          $trade_helper = new App_Helper_Trade($this->sid);
                          $trade_helper->_deal_enter_shop_record($number); // 商家入驻 推广员收益
                      }

                       $info['data'] = array(
                            'result' => true,
                            'msg'    => '续费成功',
                        );
                        $this->outputSuccess($info);
                  }else{
                      $this->outputError('续费失败');
                  }
              }else{
                  $this->outputError('支付错误，请重试');
              }
            }else{
                $this->outputError('店铺不存在或未通过审核');
            }
        }else{
            $this->outputError('参数有误，请重试');
        }
    }
    private function _get_free_project($esId){

        $project_model = new App_Model_Community_MysqlCommunityFreeProjectStorage($this->sid);
        $data = array();
        $list = $project_model->getListByEsId($esId);
        if($list){
            foreach ($list as $val){
                if($val['acfp_name']){
                    $data[] = array(
                        'id' => intval($val['acfp_id']),
                        'name' => $val['acfp_name']
                    );
                }
            }
        }
        return $data;
    }

    /*
     * 获得全部帖子分类
     */
    public function getPostCategoryAction(){
        $data = $this->_get_post_category();
        $info['data'] = $data;

        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid(35);
        $info['showPublicBtn'] = $tpl['aci_show_public_btn'];
        $this->outputSuccess($info);
    }

    /*
     * 获得全部帖子分类
     */
    private function _get_post_category(){
        $cate_model = new App_Model_Community_MysqlCommunityPostCateStorage();
        $where[] = array('name'=>'acpc_s_id','oper'=>'=','value'=>$this->sid);
        $sort = array('acpc_sort'=>'DESC','acpc_update_time'=>'DESC');
        $data = array();
        $list = $cate_model->getList($where,0,0,$sort);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['acpc_id'],
                    'name' => $val['acpc_name']
                );
            }
        }
        return $data;
    }



    /**
     * 可以领取的优惠券
     */
    private function _get_coupon_list($goods) {
        $esId = 0;
        if($goods['g_es_id']) {
            $esId = $goods['g_es_id'];
        }
        $model_cl = new App_Model_Coupon_MysqlCouponStorage($this->sid);
        $where[] = ['name'=>'cl_s_id', 'oper'=>'=', 'value'=>$this->sid]; // 店铺
        $where[] = ['name'=>'cl_es_id', 'oper'=>'=', 'value'=>$esId]; // 入驻店铺
        $where[] = ['name'=>'cl_deleted', 'oper'=>'=', 'value'=>0];
        $where[] = ['name'=>'cl_start_time', 'oper'=>'<', 'value'=>time()]; //领券开始时间
        $where[] = ['name'=>'cl_end_time', 'oper'=>'>=', 'value'=>time()]; //领券结束时间

        $couponList = $model_cl->getList($where, 0, 0);
        $result = array();
        if($couponList) {
            foreach($couponList as $value) {
                // 领取数量超出优惠券数量
                if($value['cl_had_receive'] >= $value['cl_count']) {
                    continue;
                }

                if($esId) {
                    $end = $value['cl_end_time'] ? date('Y.m.d', $value['cl_end_time']) : '';
                } else {
                    $end = $value['cl_use_end_time'] ? date('Y.m.d', $value['cl_use_end_time']) : '';
                }
                $coupon_data = [
                    'id'   => $value['cl_id'], // 优惠券id
                    'name' => $value['cl_name'], //名称
                    'faceVal'  => $value['cl_face_val'], // 面值
                    'limit' => $value['cl_use_limit'] , //限制
                    'start' => $value['cl_start_time'] ? date('Y.m.d', $value['cl_start_time']) : '', //领券开始时间
                    'end'   => $end,
                ];
                //处理当前是否可以再领取
                if($this->appletType == 4){
                    $receive_model  = new App_Model_Coupon_MysqlReceiveStorage();
                    $count          = $receive_model->getMemberReceiveCount($this->uid, $value['cl_id'], $this->sid);
                    $day_count      = $receive_model->getMemberReceiveCount($this->member['m_id'], $value['cl_id'], $this->sid,0,TRUE);
                    if(($count>=$value['cl_receive_limit']) || ($day_count && $value['cl_receive_day_limit'] >0  && $day_count >= $value['cl_receive_day_limit'])){
                        $coupon_data['canReceive']   = 2;
                    }else{
                        $coupon_data['canReceive']   = 1;
                    }
                }
                $result[] = $coupon_data;
            }
        }
        return $result;
    }

    /**
     *  获取店铺 销量、产品、收藏
     */
//    private function _get_shop_count($goods, $shop) {
//        $esId = 0;
//        if($goods['g_es_id']) {
//            $esId = $goods['g_es_id'];
//        }
//
//        $where[] = ['name'=>'g_s_id', 'oper'=>'=', 'value'=>$this->sid];
//        $where[] = ['name'=>'g_es_id', 'oper'=>'=', 'value'=>$esId];
//        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
//        $total       = $goods_model->getGoodsSold($where);
//
//        $result['goodsNum'] = $total['count'] ? $total['count'] : 0; // 商品数量
//        $result['goodsSold']  = $total['sold'] ? $total['sold'] :0; // 总销量
//
//        $collect = 0;
//        if($esId) {
//            $where_acc[] = ['name'=>'acc_s_id', 'oper'=>'=', 'value'=>$this->sid];
//            $where_acc[] = ['name'=>'acc_type', 'oper'=>'=', 'value'=>1]; // 收藏店铺
//            $where_acc[] = ['name'=>'acc_cid', 'oper'=>'=', 'value'=>$esId]; // 店铺id
//            $model_acc = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid); // 收藏
//            $collect   = $model_acc->getCount($where_acc);
//        }
//        $result['collect'] = $collect ? $collect : 0; // 收藏
//
//        // 浏览量
//        $result['showNum'] = 0;
//        if($esId && $shop['showNum']) {
//            $result['showNum'] = $shop['showNum'] ? $shop['showNum'] :0;
//        }
//
//        return $result;
//    }

    /**
     *  商品评价
     */
    private function _get_good_comments($goods) {
        $result['data']  = $this->_get_comment_list($goods['g_es_id'], $goods['g_id'], 0, 4); // 评论列表
        $comment_model   = new App_Model_Goods_MysqlCommentStorage($this->sid);
        $result['total'] = $comment_model->getGoodsCount($goods['g_id']);
        return $result;
    }

    /**
     *  推荐商品
     */
    private function _recommend_new_goods($goods) {
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $where[] = ['name'=>'g_id', 'oper'=>'!=', 'value'=>$goods['g_id']];
        $where[] = ['name'=>'g_kind1', 'oper'=>'=', 'value'=>$goods['g_kind1']];
        $where[] = ['name'=>'g_s_id', 'oper'=>'=', 'value'=>$this->sid];

        if($this->appletType == 4){
            $where[] = array('name'=>'g_es_id','oper'=>'=','value'=>$goods['g_es_id']);
            if($this->shop['s_entershop_goods_verify'] == 1){
                $where[] = array('name'=>'g_is_sale','oper'=>'not in','value'=>[4,5]);
            }
        }

        $sort = array('g_weight'=>'desc','g_update_time'=>'desc');
        $list = $goods_model->getList($where, 0, 6, $sort);

        $res  = array();
        if($list) {
            foreach($list as $key => $val) {
                $res[] = array(
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
            }
        }
        return $res;
    }

    /**
     *  店铺详情
     */
    private function _get_enterShop_desc($shop) {
        $result = [];

        $result['address'] = $shop['es_addr'] ? $shop['es_addr'] : ''; // 详细地址
        $result['addr']    = $shop['es_prov_name'].$shop['es_city_name'].$shop['es_zone_name'];
        $result['lng']     = $shop['es_lng'];
        $result['lat']     = $shop['es_lat'];

        $result['name']    = $shop['es_name']; //名称
        $result['phone']   = $shop['es_phone']; //电话
        $result['showNum'] = $shop['es_show_num']; // 浏览量(进店人数)

        $ret = $this->_get_shop_count($shop['es_id'], $shop);
        $result['goodsNum']  = $ret['goodsNum']; // 商品数量
        $result['goodsSold'] = $ret['goodsSold']; //总销量
        $result['collect']   = $ret['collect']; //收藏

        $model_gc = new App_Model_Goods_MysqlCommentStorage($this->sid); // 评论
        $where[] = ['name'=>'gc_s_id', 'oper'=>'=', 'value'=>$this->sid];
        $where[] = ['name'=>'gc_es_id', 'oper'=>'=', 'value'=>$shop['es_id']];
        $where[] = ['name'=>'gc_deleted', 'oper'=>'=', 'value'=>0];
        $result['commentNum'] = $model_gc->getCount($where); // 评论数量

        $result['createTime'] = date('Y.m.d', $shop['es_createtime']); // 添加时间

        $shopType = [
            1 => '个人',
            2 => '企业',
        ];
        $result['shopType']     = $shop['es_shop_type']; // 店铺类型
        $result['shopTypeDesc'] = $shopType[$shop['es_shop_type']]; //店铺类型详情

        return $result;
    }


    private function _get_shop_count($esId, $shop) {
        $where[] = ['name'=>'g_s_id', 'oper'=>'=', 'value'=>$this->sid];
        $where[] = ['name'=>'g_es_id', 'oper'=>'=', 'value'=>$esId];


        if($this->appletType == 4 && $this->shop['s_entershop_goods_verify'] == 1){
            $where[] = array('name'=>'g_is_sale','oper'=>'not in','value'=>[4,5]);
        }

        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $total       = $goods_model->getGoodsSold($where);

        $result['goodsNum'] = $total['count'] ? $total['count'] : 0; // 商品数量
        $result['goodsSold']  = $total['sold'] ? $total['sold'] :0; // 总销量

        $collect = 0;
        if($esId) {
            $where_acc[] = ['name'=>'acc_s_id', 'oper'=>'=', 'value'=>$this->sid];
            $where_acc[] = ['name'=>'acc_type', 'oper'=>'=', 'value'=>1]; // 收藏店铺
            $where_acc[] = ['name'=>'acc_cid', 'oper'=>'=', 'value'=>$esId]; // 店铺id
            $model_acc = new App_Model_Community_MysqlCommunityCollectionStorage($this->sid); // 收藏
            $collect   = $model_acc->getCount($where_acc);
        }
        $result['collect'] = $collect ? $collect : 0; // 收藏

        // 浏览量
        $result['showNum'] = 0;
        if($esId && $shop['showNum']) {
            $result['showNum'] = $shop['showNum'] ? $shop['showNum'] :0;
        }

        return $result;
    }

}

<?php


class App_Controller_Applet_MallController extends App_Controller_Applet_InitController
{

    public function __construct(){
        parent::__construct(true);

    }
    

    private function _index_notice_list(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'title'    => $val['atn_title'],
                    'link'     => $val['atn_article_id'],
                );
            }
        }
        return $data;
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
    
    private function _find_shop_three_distrib(){
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
        $tcRow         = $three_cfg->findShopCfg();
        if($tcRow){
            return intval($tcRow['tc_isopen']);
        }else{
            return 0;
        }
    }
    //试衣间功能
    private function _get_goods_clothes_room($gid=''){
        $clothes_storage = new App_Model_Goods_MysqlClothesRoomStorage($this->sid);
        $imgList   = $clothes_storage->getListByGidSid($gid);//获取试衣间颜色图片
        $newList   = array();
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        if($imgList){
            if($gid){
                $qrcode = $goods_model->getRowById($gid)['g_qrcode'];
                foreach ($imgList as $key=>$val){
                    $newList[$val['gcri_type']][$key]['img']    = $this->dealImagePath($val['gcri_path']);
                    $newList[$val['gcri_type']][$key]['qrcode'] = $qrcode?$this->dealImagePath($qrcode):'';
                }
            }else{
                foreach ($imgList as $key=>$val){
                    $qrcode    = '';
                    if($val['gcri_g_id']){
                        $qrcode = $goods_model->getRowById($val['gcri_g_id'])['g_qrcode'];
                    }
                    $newList[$val['gcri_type']][$key]['img']    = $this->dealImagePath($val['gcri_path']);
                    $newList[$val['gcri_type']][$key]['qrcode'] = $qrcode?$this->dealImagePath($qrcode):'';
                }
            }
            $modelList = $clothes_storage->getModelListSid();
            if($modelList){
                foreach ($modelList as $item){
                    $newList[$item['gcri_type']][] = $this->dealImagePath($item['gcri_path']);
                }
            }
        }
        return array_values($newList);
    }


    
    private function _shop_index_tpl($tpl_id){
        $data = array();
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid($tpl_id);
        if($tpl){
            $data = array(
                'temp'           => $tpl_id,
                'title'          => $tpl['amu_title'],
                'couponTitle'    => isset($tpl['amu_coupon_title'])?$tpl['amu_coupon_title']:'',
                'couponSign'     => isset($tpl['amu_coupon_sign'])?$tpl['amu_coupon_sign']:'',
                'proTitle'       => isset($tpl['amu_promotion_title'])?$tpl['amu_promotion_title']:'',
                'noticeTitle'   => isset($tpl['amu_notice_title']) ? $tpl['amu_notice_title'] : '最新公告',
                'proSign'        => isset($tpl['amu_promotion_sign'])?$tpl['amu_promotion_sign']:'',
                'hotImg'         => $this->dealImagePath($tpl['amu_hot_img']),
                'hotLink'        => $tpl['amu_hot_link'],
                'hotUrl'         => $this->get_link_by_type($tpl['amu_hot_type'],$tpl['amu_hot_link'],''),
                'address'        => isset($tpl['amu_address']) ? $tpl['amu_address'] : '',
                'lng'            => isset($tpl['amu_lng']) ?  $tpl['amu_lng'] : '',
                'lat'            => isset($tpl['amu_lat']) ? $tpl['amu_lat'] : '',
                'brief'          => $tpl['amu_brief'],
            );
        }else{
            $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
            $where = array();
            $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->sid);
            $template = $template_model->getRow($where);
            $data = array(
                'temp'           => $tpl_id,
                'title'          => $template['act_header_title'],
            );
        }
        return $data;
    }
    
    private function _get_shop_notice_list($tpl_id){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,6,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = $val['ai_title'];
            }
        }
        return $data;
    }



    

    
    private function _shop_index_slide($tpl_id){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($this->sid);
        $slide      = $slide_storage->fetchSlideShowList($tpl_id);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'],
                    'type' => intval($val['ss_link_type']),
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_article_title']),
                );
            }
        }
        return $data;

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
                    'type' => intval($val['ss_link_type']),
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
        }
        return $data;
    }

    
    private function _fetch_group_list(){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
        $org_curr   = array();

        $act_arr    = $group_model->getCurrentList(0,5);
        foreach ($act_arr as &$one) {
            $org_curr[] = array(
                'gbId'  => $one['gb_id'],
                'cover' => $this->dealImagePath($one['gb_cover']),
                'name'  => $one['g_name'],
                'gprice'=> $one['gb_type'] == 3?$one['gb_tz_price']:$one['gb_price'],
                'price' => $one['g_price'],
                'total' => $one['gb_total']
            );
        }
        return $org_curr;
    }

    
    private function _limit_activity_list(){
        $data = array();
        $limit_storage = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        $list = $limit_storage->getAllRunningNotBeginAct();
        if($list){
            $goods_model  = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
            $goods_list = $goods_model->getListByActid($list[0]['la_id']);
            if (!empty($goods_list)) {
                foreach ($goods_list as $val){
                    $data[] = $this->_format_goods_details($val,false,$list[0]['la_id']);
                }
            }
        }
        return $data;
    }

    
    private function _format_full_act($full_act){
        $data = array();
        foreach($full_act as $val){
            $data[] = array(
                'typeDesc' => $val['type_desc'],
                'name'     => $val['fa_name']
            );
        }
        return $data;
    }

    
    private function _goods_list($top=0){
        $page     = $this->request->getIntParam('page');
        $recomm   = $this->request->getIntParam('recomm');      // 获取促销商品
        $sortType = $this->request->getIntParam('sortType');  // 商品排序类型
        $keyword  = $this->request->getStrParam('keyword');
        $kind1    = $this->request->getIntParam('kind1');          // 商品分类ID
        $kind2    = $this->request->getIntParam('kind2');          // 商品分类ID
        $cid      = $this->request->getIntParam('cid');   //优惠券id
        $type     = $this->request->getIntParam('ctype'); //优惠券类型
        if($top || $recomm){
            $top = 1;
        }
        //获取店铺商品
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $index  = $page*$this->count;
        if($sortType && $sortType==1){
            $sort   = array('g_price'=>'ASC','g_weight' => 'DESC', 'g_update_time' => 'DESC');
        }elseif ($sortType && $sortType==2){
            $sort   = array('g_sold'=>'DESC','g_weight' => 'DESC', 'g_update_time' => 'DESC');
        }elseif ($sortType && $sortType==3){
            $sort   = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        }else{
            $sort   = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        }
        $where = array();
        if($type == 2){
            $couponGoods_model = new App_Model_Coupon_MysqlCouponGoodsStorage($this->sid);
            $coupon_goods = $couponGoods_model->getListByActid($cid, 0, 0);
            foreach($coupon_goods as $val){
                $goods[] = $val['cg_g_id'];
            }
            if(!empty($goods)){
                $where[] = array('name' => 'g_id', 'oper' => 'in', 'value' => $goods);
            }
        }
        $list  = $goods_model->fetchShopGoodsList($this->sid, $index, $this->count, $keyword, $top, $sort,array(),$kind1,$kind2,1,$where);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;
    }
    
    private function _goods_list_new($category){
        $page = $this->request->getIntParam('page');
        //获取店铺商品
        $index  = $page*$this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $list        = $goods_model->getGroupGoods('look',$category,$index,$this->count);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info['goods'][] = $this->_format_goods_details($val);
            }
        }else{
            $info['goods'] = array();
        }
        $info['category'] = $this->_goods_group($category);
        return $info;
    }
    
    private function _goods_group($id){
        $group_model  = new App_Model_Goods_MysqlGroupStorage($this->sid);
        $row = $group_model->getRowById($id);
        $data = array(
            'name'      => $row['gg_name'],
            'brief'     => isset($row['gg_brief']) ? $row['gg_brief'] : '热销商品包你满意',
            'img'       => isset($row['gg_bg']) && $row['gg_bg'] ? $this->dealImagePath($row['gg_bg']) : $this->dealImagePath('/upload/gallery/thumbnail/C5A1A4E4-B65B-5031-F627091DF542-tbl.jpeg'),
            'listStyle' => $row['gg_list_type'],
        );
        return $data;

    }

    
    private function _recommend_goods_list($tpl){
        $recommend_model = new App_Model_Mall_MysqlMallRecommendStorage($this->sid);
        $recommend_list = $recommend_model->fetchRecommendShowList($tpl);
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'  => $val['amr_name'],
                    'price' => $val['amr_price'],
                    'img'   => $this->dealImagePath($val['amr_img']),
                    'link'  => $val['amr_link']
                );
            }

        }
        return $data;
    }

    
    private function _shop_kind_list($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'name'  => $val['amk_name'],
                    'sign'  => $val['amk_sign'],
                    'type'  => in_array($val['amk_goods_list'],[2,4]) ? $val['amk_goods_list'] : 2,
                    'link'  => $val['amk_link'],
                    'img'   => isset($val['amk_img']) ? $this->dealImagePath($val['amk_img']) : '',
                    'goods' => $this->_goods_list_by_kind($val['amk_link']),
                );
            }
        }
        return $data;
    }

    
    private function _goods_list_by_kind($kind){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $goods_list = $goods_storage->fetchShopGoodsListByKind(0,6,0,$kind);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_goods_details($val);
            }
        }
        return $data;
    }

    
    private function _get_coupon_list_all(){
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->fetchShowValidList($this->sid,0,0);
        $list = array();
        if($coupon){
            foreach ($coupon as $key => $value) {
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
        return $list;
    }

    
    private function _format_goods_details($goods,$detail=false,$laid=0){
        if(!$laid){
            //获取正在进行中的抢购商品数组
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $act_goods= $act_model->getAllRunningGoodsAct();
            foreach($act_goods as $value){
                if($goods['g_id'] == $value['lg_g_id']){
                    $laid = $value['la_id'];
                }
            }
        }
        if($goods){
            //会员等级
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'isVipPrice' => $goods['g_had_vip_price'] && $levelList,
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'islimit'    => $goods['g_limit'] > 0  ? true : false,
                'purchase'   => isset($goods['g_limit']) && $goods['g_limit'] > 0 ? $goods['g_limit'] : $goods['g_stock'],
                'purchaseNote'   => isset($goods['g_limit']) && $goods['g_limit'] > 0 ? '每人限购'.$goods['g_limit'].'件' : '',
                'isDiscuss'  => intval($goods['g_is_discuss']),
                'phone'      => $this->shop['s_phone'] ? $this->shop['s_phone'] : '',
                'expfeeShow' => intval($goods['g_expfee_show']),
                'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
                'unitName'   => $goods['g_unit_name'] ? $goods['g_unit_name'] :''
            );
            $data['label'] = array();
            $goods['g_is_global'] == 1 ? $data['label'][] = '全球购' : false;
            $goods['g_is_back'] == 1 ? $data['label'][] = '七天退换' : false;
            $goods['g_is_quality'] == 1 ? $data['label'][] = '正品保证' : false;
            $goods['g_is_truth'] == 1 ? $data['label'][] = '如实描述' : false;

            $data['newLabel'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    $data['newLabel'][] = $val;
                }
            }
            // 是否获取商品详情
            if($detail){
                $data['coupon'] = $this->_get_coupon_list_all();
                $data['freight'] = $this->_get_postFee_show($goods);
                $data['video']  = $goods['g_video_url'] ? $goods['g_video_url']:'';
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                //$data['detail'] = $goods['g_detail'];#plum_parse_img_path($goods['g_detail']);
                $data['detail'] = plum_parse_img_path_new($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);
                $data['format'] = $this->_goods_format($goods['g_id']);
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }
                if($data['hasFormat']){
                    $data['formatList']  = $this->_new_goods_format($goods);
                    $data['formatValue'] = $this->_get_format_value($goods['g_id']);
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
            $data['seckill']  = 0;//是否参与秒杀活动
            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);
                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $data['seckill']  = 1;
                    //覆盖原有价格
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $data['price']  = $limit_price;
                    $data['restriction']  = intval($limit_act['lg_limit']);
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                    }
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $goods['g_stock'];

                    if($data['limitStock'] > 0){
                        if($data['purchaseNote']){
                            $data['purchaseNote'] = $data['purchaseNote']."，共{$data['limitStock']}件";
                        }else{
                            $data['purchaseNote'] = "共{$data['limitStock']}件";
                        }
                    }
                    $data['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                    //if(($limit_act['lg_limit'] && $limit_act['lg_limit']>0) || ($limit_act['lg_stock'] && $limit_act['lg_stock']>0)){
                    if($limit_act['lg_stock'] && $limit_act['lg_stock']>0 && $detail){
                        // 获取已经购买过的数量
                        $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                        $had_buy    = $record_model->countBuyNumByActid($limit_act['lg_actid'], $goods['g_id']);
//                        if($limit_act['lg_limit'] && $limit_act['lg_limit']>0){
//                            $data['stock'] = $limit_act['lg_limit']>=$had_buy ? ($limit_act['lg_limit']-$had_buy) : 0;
//                        }else
                        if ($limit_act['lg_stock'] && $limit_act['lg_stock']>0){
                            $data['stock'] = $limit_act['lg_stock']>=$had_buy ? ($limit_act['lg_stock']-$had_buy) : 0;
                        }

                        if($data['hasFormat'] && $data['formatValue']){
                            foreach ($data['formatValue'] as $key => $format){
                                //如果秒杀商品有规格，所有规格统一价格
                                $data['formatValue'][$key]['price'] = $limit_price;
                                if($limit_act['lg_stock']>0 && $detail){
                                    //如果设置了秒杀数量，所有规格统一库存
                                    $data['formatValue'][$key]['stock'] = $data['stock'];
                                }
                            }
                        }
                    }
                }

            }
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

    
    private function _get_format_value($gid){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format         = $format_model->getListByGid($gid);
        $data = array();
        foreach($format as $val){
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price' => $val['gf_price'],
                'stock'  => $val['gf_stock']
            ];
        }
        return $data;
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

    
    private function _get_shop_son_category(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(0,0);
        $kind2_data = array();
        foreach ($kind2 as $val){
            $kind2_data[$val['sk_fid']][] = array(
                'id'        => $val['sk_id'],
                'name'      => $val['sk_name'],
                'logo'      => $this->dealImagePath($val['sk_logo']),
            );
        }
        return $kind2_data;
    }
    
    private function _get_shop_category_good(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);

        //会员等级
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $levelList = $level_model->getListBySid($this->sid);

        // 获取店铺的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(0,0);
        $info = array();
        if($kind2){
            foreach ($kind2 as $val){
                $where             = array();
                $where[]           = array('name'=>'g_s_id','oper'=>'=','value'=>$this->sid);
                $where[]           = array('name' => 'g_is_sale', 'oper' => '=', 'value' =>1);
                $where[]           = array('name'=>'g_kind2','oper'=>'=','value'=>$val['sk_id']);
                $sort              = array('g_weight'=>'DESC','g_update_time' => 'DESC');
                $goodsList       = $goods_storage->getList($where,0,6,$sort);
                $data = array();
                if($goodsList){
                    foreach ($goodsList as $v){
                        $data[] = array(
                            'id'         => $v['g_id'],
                            'name'       => $v['g_name'],
                            'isVipPrice' => $v['g_had_vip_price'] && $levelList,
                            'cover'      => isset($v['g_cover']) ? $this->dealImagePath($v['g_cover']) : '',
                            'price'      => floatval($v['g_price']),
                            'oriPrice'   => floatval($v['g_ori_price']),
                            'brief'      => isset($v['g_brief']) ? $v['g_brief'] : '',
                        );
                    }
                }
                $info[] = array(
                    'id'        => $val['sk_id'],
                    'name'      => $val['sk_name'],
                    'list'      => $data,
                );
            }
        }
        return $info;
    }

    
    private function _get_kind2_goods_data($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);//此时获取的是一级分类
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'id'    => $val['amk_id'],
                    'name'  => $val['amk_name'],
                    'link'  => $val['amk_link'],
                    'img'   => isset($val['amk_img']) ? $this->dealImagePath($val['amk_img']) : '',
                    'kindData' => $this->_get_kind2_goods_data_detail($val['amk_link']),
                );
            }
        }
        return $data;
    }
    
    private function _get_kind2_goods_data_detail($kind1){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kind2      = $kind_model->getSonsByFid($kind1,0,20);//获取最多50个一级分类
        $data       = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'link'  => $val['sk_id'],
                    'name'  => $val['sk_name'],
                    'img'   => $val['sk_logo']?$this->dealImagePath($val['sk_logo']):'',
                    'goods' => $this->_get_goods_by_kind2($val['sk_id'])
                );
            }
        }
        return $data;
    }
    
    private function _get_goods_by_kind2($kind2){
        $data         =  array();
        $sort = array('g_is_top'=>'DESC','g_update_time'=>'DESC');
        $goods_model  =  new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $list         =  $goods_model->fetchTopShopGoodsList(0,20,$sort,$top = 0,0,$kind2);
        //会员等级
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $levelList = $level_model->getListBySid($this->sid);
        if($list){
            foreach($list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'isVipPrice' => $v['g_had_vip_price'] && $levelList,
                    'name' => $val['g_name']?$val['g_name']:'商品名称',
                    'oldPrice'  => floatval($val['g_ori_price']),
                    'newPrice'  => floatval($val['g_price']),
                    'cover'     => $val['g_cover']?$this->dealImagePath($val['g_cover']):''
                );
            }
        }
        return $data;
    }
    
    public function shopCategoryAction(){
        $type     =  $this->request->getIntParam('type');
        $keyWord  =  $this->request->getStrParam('keyWord');
        $page     = $this->request->getIntParam('page');
        // 是否是独立商城的商品列表
        $independence=$this->request->getIntParam('independence',0);

        $index    = $page*$this->count;
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);

        //会员等级
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $levelList = $level_model->getListBySid($this->sid);

        //新增我的浏览和收藏商品
      
        $data = array();
        $info = array();
        $kindRow = $kind_model->getRowById($type);
        if($kindRow['sk_level'] == 1){
            //获取当前一级分类下的所有二级分类
            $kind2 = $kind_model->getSonsByFid($type,0,0);
            $info[] = array(
                 'id'        => $type,
                 'name'      => '全部',
            );
            $data['data']['defaultId'] = $type;
        }else{
            // 获取店铺的所有二级分类
            $kind2 = $kind_model->getAllSonCategory(0,0,0,$independence==500?1:0);
        }

        if($kind2){
            foreach ($kind2 as $val){
                $info[] = array(
                    'id'        => $val['sk_id'],
                    'name'      => $val['sk_name'],
                );
            }
            $data['data']['category']=$info;
            $where             = array();
            $where[]           = array('name'=>'g_s_id','oper'=>'=','value'=>$this->sid);
            $where[]           = array('name' => 'g_is_sale', 'oper' => '=', 'value' =>1);
            //过滤掉预约商品，积分实物商品和积分虚拟商品
            $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
            $sort              = array('g_weight'=>'DESC','g_update_time' => 'DESC');
            if($type){
                if($kindRow['sk_level'] == 1){
                     $where[]       = array('name'=>'g_kind1','oper'=>'=','value'=>$type);
                }else{
                     $where[]       = array('name'=>'g_kind2','oper'=>'=','value'=>$type);
                }
            }else{
                $firstKind2=reset($kind2);
                $data['data']['defaultId']=$firstKind2['sk_id'];
                $where[]       = array('name'=>'g_kind2','oper'=>'=','value'=>$firstKind2['sk_id']);
            }
            if($keyWord){
                $where[]       = array('name'=>'g_name','oper'=>'like','value'=>"%$keyWord%");
            }
           

            $where[] = array('name' => 'g_applay_goods_show', 'oper' => '=', 'value' => 1);  //前台列表不显示的过滤掉

            // 取出来独立商城的列表
            // zhangzc
            // 2019-10-12
            if($independence==500){
                $where[]=['name'=>'g_independent_mall','oper'=>'=','value'=>1];
            }

            $goodsList         = $goods_storage->getList($where,$index, $this->count,$sort);
            $goods = array();
            $uid    = plum_app_user_islogin();

            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);

            if($goodsList){
                foreach ($goodsList as $k => $v){
                    $goods[$k] = array(
                        'id'         => $v['g_id'],
                        'name'       => $v['g_name'],
                        'isVipPrice' => $v['g_had_vip_price'] && $levelList,
                        'cover'      => isset($v['g_cover']) ? $this->dealImagePath($v['g_cover']) : '',
                        'price'      => floatval($v['g_price']),
                        'oriPrice'   => floatval($v['g_ori_price']),
                        'brief'      => isset($v['g_brief']) ? $v['g_brief'] : '',
                        'sold'       => $v['g_sold'],
                        'soldShow'   => $v['g_sold_show'],
                        'isDiscuss'  => intval($v['g_is_discuss']),
                        'discussInfo'=> isset($v['g_discuss_info']) ? $v['g_discuss_info'] : '',
                        'listLabel'  => $goods['g_list_label']
                    );

//                    if($this->applet_cfg['ac_type'] == 6){
//                        $trade_helper = new App_Helper_Trade($this->sid);
//                        $price = $trade_helper::getGoodsVipPirce($v['g_price'],$this->sid,$v['g_id'],0,$uid);
//                        $goods[$k]['price'] = $price;
//                    }

                    if($levelList || $v['g_had_vip_price']){
                        $vipData = App_Helper_Trade::getGoodsVipPirce($goods[$k]['price'], $this->sid, $v['g_id'], 0,$uid, 1);
                        $goods[$k]['isVipPrice'] = $levelList || $v['g_had_vip_price'] || $vipData['isVipPrice'] ? 1 : 0;
                        if($this->applet_cfg['ac_type'] == 6){
                            //同城多店
                            $goods[$k]['vipPrice'] = $this->_get_vip_price($v);
                        }
                        $goods[$k]['noVipPrice'] = $goods[$k]['price'];
                        $goods[$k]['price'] = $vipData['price'];
                        $goods[$k]['isVip'] = $vipData['isVip'];
                    }
                }

            }
            $data['data']['goods']=$goods;
            $this->outputSuccess($data);
        }else{
            $this->outputError('暂时没有数据哦');
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

   

    public function goodsCollectAction(){
        $gid          = $this->request->getIntParam('gid');  //商品id
        $collect_model = new App_Model_Goods_MysqlGoodsCollectionStorage($this->sid);
        $uid = plum_app_user_islogin();
        if($uid  && $gid) {
            $row = $collect_model->getRowByIdSidMid($gid, $this->sid, $uid);
            if ($row) {
                //如果存在 删除记录
                $res = $collect_model->deleteById($row['gc_id']);
                if ($res) {
                    $info['data'] = array(
                        'msg' => '取消成功!',
                        'isCollect' => 0
                    );
                    $this->outputSuccess($info);
                } else {
                    $this->outputError('取消失败!');
                }
            } else {
                //将记录增加在浏览记录表中
                $insertData = array(
                    'gc_s_id' => $this->sid,
                    'gc_m_id' => $uid,
                    'gc_g_id' => $gid,
                    'gc_create_time' => time(),
                );
                $res = $collect_model->insertValue($insertData);
                if ($res) {
                    $info['data'] = array(
                        'msg' => '收藏成功!',
                        'isCollect' => 1
                    );
                    $this->outputSuccess($info);
                    // 评价订单获取积分
                    $point_storage = new App_Helper_Point($this->sid);
                    $point_storage->gainPointBySource($uid,App_Helper_Point::POINT_SOURCE_COLLECTION);
                } else {
                    $this->outputError('收藏失败!');
                }
                //$this->outputError('你已经收藏过该商品了!');
            }
        }else{
            $this->outputError('用户或商品信息获取失败!');
        }
    }

    
    private function _my_collect_goods(){
        $collection_model    = new App_Model_Goods_MysqlGoodsCollectionStorage($this->sid);
        $page = $this->request->getIntParam('page');
        $uid = plum_app_user_islogin();
        //获取店铺商品
        $index    = $page*$this->count;
        $sort     = array('gc_create_time'=>'DESC');
        $where    = array();
        $where[]  = array('name'=>'gc_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  = array('name'=>'gc_m_id','oper'=>'=','value'=>$uid);
        $list   = $collection_model->getGoodsList($where,$index,$this->count,$sort);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;

    }

    
    private function _my_browse_goodslist(){
        $browse_model    = new App_Model_Goods_MysqlGoodsCollectionStorage($this->sid);
        $page = $this->request->getIntParam('page');
        $uid = plum_app_user_islogin();
        //获取店铺商品
        $index    = $page*$this->count;
        $sort     = array('gb_create_time'=>'DESC');
        $where    = array();
        $where[]  = array('name'=>'gb_s_id','oper'=>'=','value'=>$this->sid);
        $where[]  = array('name'=>'gb_m_id','oper'=>'=','value'=>$uid);
        $list   = $browse_model->getGoodsList($where,$index,$this->count,$sort);
        $info = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;

    }




}


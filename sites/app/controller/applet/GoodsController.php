<?php


class App_Controller_Applet_GoodsController extends App_Controller_Applet_InitController
{

    public function __construct(){
        parent::__construct(true);

    }

    
    private function _get_coupon_list_all($esId){
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->fetchShowValidList($this->sid,0,0, $esId);
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
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'flId'       => $goods['g_kind1'],
                'price'      => $goods['g_price'],
                'unit'       => $goods['g_unit'],
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock']<0?0:intval($goods['g_stock']),
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'isDiscuss'  => intval($goods['g_is_discuss']),
                'phone'      => $this->shop['s_phone'] ? $this->shop['s_phone'] : '',
                'expfeeShow' => intval($goods['g_expfee_show']),
                'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
                'unitName'   => $goods['g_unit_name'] ? $goods['g_unit_name'] :''
            );

            $uid    = plum_app_user_islogin();
            $vipData = App_Helper_Trade::getGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);
            $data['noVipPrice'] = $data['price'];
            $data['price'] = $vipData['price'];
            $data['isVip'] = $vipData['isVip'];
            $data['isVipPrice'] = $goods['g_had_vip_price'] || $vipData['isVipPrice'] ? 1 : 0;
            $data['vipLabel'] = '会员折扣';

            $data['label'] = array();
            $goods['g_is_global'] == 1 ? $data['label'][] = '全球购' : false;
            $goods['g_is_back'] == 1 ? $data['label'][] = '七天退换' : false;
            $goods['g_is_quality'] == 1 ? $data['label'][] = '正品保证' : false;
            $goods['g_is_truth'] == 1 ? $data['label'][] = '如实描述' : false;

            $data['newLabel'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['newLabel'][] = $val;
                    }
                }
            }

            $data['format'] = $this->_goods_format($goods['g_id']);
            if(!empty($data['format']) && $data['format']){
                $data['hasFormat'] = true;
            }
            if($data['hasFormat']){
                $data['formatValue'] = $this->_get_format_value($goods['g_id']);
                $formatStock = 0;
                foreach ($data['formatValue'] as $item){
                    $formatStock += $item['stock'];
                }

                if(!($this->applet_cfg['ac_type'] == 18 && $goods['g_kind1'] == 1)){//预约版预约商品不使用规格库存
                    $data['stock'] = $formatStock;
                }

            }

            // 是否获取商品详情
            if($detail){
                $data['coupon'] = $this->_get_coupon_list_all($goods['g_es_id']);
                $data['freight'] = $this->_get_postFee_show($goods);
                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['video']  = $goods['g_video_url'] ? $goods['g_video_url']:'';
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
                $data['detail'] = plum_parse_img_path($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods);

                if($data['hasFormat']){
                    $data['formatList']  = $this->_new_goods_format($goods);
                }

                if($data['slide']){
                    $imagesize = getimagesize($data['slide'][0]);
                    if($imagesize[0]==$imagesize[1]){
                        $data['slideSpecif'] = 1;
                    }else{
                        $data['slideSpecif'] = 0;
                    }
                }
               //获得配送配置
                $send_model = new App_Model_Cake_MysqlCakeSendStorage($this->sid);
                $sendCfg = $send_model->findUpdateBySid();
                $data['postType'] = array(
                    'send' => intval($sendCfg['acs_send']),
                    'receive' => intval($sendCfg['acs_receive']),
                    'express' => intval($sendCfg['acs_express_delivery'])
                );
            }

            //是否已经收藏
            $where[]    = array('name' => 'c_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'c_m_id', 'oper' => '=', 'value' => $uid);
            $where[]    = array('name' => 'c_g_id', 'oper' => '=', 'value' => $goods['g_id']);

            $collection_model   = new App_Model_Goods_MysqlCollectionStorage($this->sid);
            $had    = $collection_model->getRow($where);
            $data['isCollect'] = $had ? 1 : 0;
            $data['has_seckill']  = 0;//是否参与秒杀活动
            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);
                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $data['has_seckill']  = 1;
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
                }
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
        $uid    = plum_app_user_islogin();
        foreach($format as $val){
            $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid,1);
            $data[$val['gf_name'].$val['gf_name2'].$val['gf_name3']] = [
                'id'     => $val['gf_id'],
                'price' => $vipData['price'],
                'oriPrice' => $vipData['isVip']>0 ? $val['gf_price'] : floatval($val['gf_ori_price']),
                'stock'  => $val['gf_stock'] < 0 ? 0 : intval($val['gf_stock'])
            ];
        }
        return $data;
    }

    
    private function _goods_slide($goods){
        //获取商品幻灯
        $slide_model = new App_Model_Goods_MysqlGoodsSlideStorage($this->sid);
        $slide       = $slide_model->getListByGidSid($goods['g_id'], $this->sid);
        $data = array();
        if($slide){
            foreach ($slide as $val){
                $data[] = $this->dealImagePath($val['gs_path']);
            }
        }else if($goods['g_cover'] && isset($goods['g_cover'])){
            $data[] = $this->dealImagePath($goods['g_cover']);
        }
        return $data;
    }

    
    private function _goods_format($gid){
        //获取商品规格
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
        $format = $format_model->getListByGid($gid);
        $data = array();
        $isVip = 0;
        if($format){
            $uid    = plum_app_user_islogin();
            foreach ($format as $val){
                $vipData = App_Helper_Trade::getGoodsVipPirce($val['gf_price'], $this->sid, $gid, $val['gf_id'],$uid, 1);
                $data[] = array(
                    'id'    => $val['gf_id'],
                    'name'  => $val['gf_name'],
                    'price' => $vipData['price'],
                    'sold'  => $val['gf_sold'],
                    'stock' => $val['gf_stock'],
                    'point' => $val['gf_send_point'],
                );
            }
        }
        return $data;
    }

    
    public function goodsCommentAction(){
        $gid = $this->request->getIntParam('gid');
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $goods_comment  = new App_Model_Goods_MysqlCommentStorage($this->sid);
        $total = $goods_comment->getGoodsCount($gid);
        $list = $goods_comment->getGoodsList($gid,$index,$this->count);
        $info['data'] = array(
            'total' => $total,
            'list'  => array()
        );
        $score_desc = plum_parse_config('community_score_desc', 'system');
        if($list){
            $data = array();
            foreach ($list as $val){
                $data[] = array(
                    'gcid'      => $val['gc_id'],
                    'gid'       => $val['gc_g_id'],
                    'tid'       => $val['gc_tid'],
                    'mid'       => $val['gc_mid'],
                    'nickname'  => $val['m_nickname'],
                    'avatar'    => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'content'   => $val['gc_content'],
                    'reply'     => $val['gc_reply'],
                    'format'    => isset($val['gc_format']) && $val['gc_format'] ? $val['gc_format'] :(isset($val['to_gf_name']) ? $val['to_gf_name'] : ''),
                    'time'      => date('Y-m-d',$val['gc_create_time']),
                    'imgList'   => $this->_goods_comment_img($val['gc_comment_img']),
                    'star'    => $val['gc_star'],
                    'starDesc' => $score_desc[intval($val['gc_star'])],
                );
            }
            $info['data']['list'] = $data;
        }
        $this->outputSuccess($info);
    }
    private function _goods_comment_img($img){
        $imgList = array();
        if(isset($img) && $img){
            $imgList = json_decode($img,true);
            foreach ($imgList as &$val){
                $val = $this->dealImagePath($val);
            }
        }
        return $imgList;
    }
}

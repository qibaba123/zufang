<?php
/*
 * 知识付费小程序接口
 */

class App_Controller_Applet_KnowledgepayController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct(true);
    }

    /**
     * 店铺首页
     */

    public function indexAction(){
        $version = $this->request->getStrParam('version');
        $base    = $this->request->getIntParam('base');
        if($this->shop){
            $uid = plum_app_user_islogin();
            $info         = array();
            $tplData      = $this->_shop_index_tpl($this->applet_cfg['ac_index_tpl']);
            $info['data'] = array(
                'suid'           => $this->suid,
                'logo'           => $this->dealImagePath($this->shop['s_logo']),
                'name'           => $this->shop['s_name'],
                'watermark'      => $this->watermark,
                'watermarkImg'  => $this->watermarkImg,
                'openWatermark'   => $this->openWatermark,
                'supportMobile'   => $this->support && isset($this->support['as_mobile']) ? $this->support['as_mobile'] : '',
                'customerService' => $this->applet_cfg['ac_kefu_open'],   //是否开启客服：0未开启，1开启
                'customerMobile'  => $this->applet_cfg['ac_kefu_mobile'],   //是否开启使用客服需授权手机号：0未开启，1开启
                'shareOpen'      => $this->applet_cfg['ac_share_open'],   // 分享海报按钮是否显示
                'shareUrl'       => isset($this->applet_cfg['ac_share_addr']) && $this->applet_cfg['ac_share_addr'] ? $this->dealImagePath($this->applet_cfg['ac_share_addr'],true) : '',   // 分享海报的图片地址
                'shareCover'      => isset($this->applet_cfg['ac_share_custom']) && $this->applet_cfg['ac_share_custom'] ? (isset($this->applet_cfg['ac_share_cover']) && $this->applet_cfg['ac_share_cover'] ? $this->dealImagePath($this->applet_cfg['ac_share_cover'],true) : '') : '',   // 分享封面图片地址
                'shareTitle'      => isset($this->applet_cfg['ac_share_custom']) && $this->applet_cfg['ac_share_custom'] ? (isset($this->applet_cfg['ac_share_title']) && $this->applet_cfg['ac_share_title'] ? $this->applet_cfg['ac_share_title'] : '') : '',   // 分享标题
                'mobile'         => $this->shop['s_phone'],
                'template'       => $tplData,         // 模板信息
                'slide'          => $this->_shop_index_slide($this->applet_cfg['ac_index_tpl']),       // 首页幻灯
                'shortcut'       => $this->_shop_index_shortcut($this->applet_cfg['ac_index_tpl']),    // 首页分类导航
                'kinds'          => $this->_shop_kind_list($this->applet_cfg['ac_index_tpl']),         // 首页商品分类
                'supportOpen'    => $this->support && isset($this->support['as_audit']) ? intval($this->support['as_audit']) : 0,
                'shopInfo'       => $this->shop_company_info(),
                'isVip'          => $this->_check_is_vip($uid),
                'notice'         => $this->_index_notice_list(),
                'recommendList'  => $this->_get_recommend_by_type($this->applet_cfg['ac_index_tpl'],0),
                'recommendAudio'  => $this->_get_recommend_by_type($this->applet_cfg['ac_index_tpl'],2),
                'recommendBig'  => $this->_get_recommend_by_type($this->applet_cfg['ac_index_tpl'],1),
                'quotation'     => $this->_get_quotation()
            );
            if($uid){
                $info['data']['coupon']=$this->_get_coupont_list($uid);
            }else{
                $info['data']['coupon']=array();
            }
            // 解析配置的菜单信息
            $bottom_data = json_decode($this->applet_cfg['ac_bottom_menu'],1);
            if($this->applet_cfg['ac_navigation_bar']){
                $navigat_data = json_decode($this->applet_cfg['ac_navigation_bar'],true);
            }
            // 设置菜单默认值
            $bottom_menu =array(
                "color"             => $bottom_data['color'] ? $bottom_data['color'] : "#999999",
                "selectedColor"     => $bottom_data['selectedColor'] ? $bottom_data['selectedColor'] : "#f20d00",
                "backgroundColor"   => $bottom_data['backgroundColor'] ? $bottom_data['backgroundColor'] : "#ffffff",
                "borderStyle"       => $bottom_data['borderStyle'] ? $bottom_data['borderStyle'] : "white",
                'navigationBarTitleText'         => $this->applet_cfg['ac_name'],
                'navigationBarBackgroundColor'   => $navigat_data['navigationBarBackgroundColor'] ? $navigat_data['navigationBarBackgroundColor'] : '#FFFFFF',
                'navigationBarTextStyle'         => $navigat_data['navigationBarTextStyle'] &&  $navigat_data['navigationBarTextStyle'] == 'white' ? 'light' : 'dark',
                'list'  => array(),
            );
            if($this->appletType == 5 && is_array($bottom_data) && !empty($bottom_data)){
                if(!empty($bottom_data['list'])){
                    foreach ($bottom_data['list'] as $k => $v){
                        $routeInfo = $this->getPageRoute($v['pagePath']);
                        $bottom_menu['list'][$k]['text']     = $v['text'];
                        $bottom_menu['list'][$k]['pagePath'] = $routeInfo['route'];
                        $bottom_menu['list'][$k]['iconPath'] = $this->response->responseHost().'/public/wxapp/icon'.$v['iconPath'];
                        $bottom_menu['list'][$k]['selectedIconPath'] = $this->response->responseHost().'/public/wxapp/icon'.$v['selectedIconPath'];
                    }
                }
            }
            $info['data']['bottom_menu'] = $bottom_menu;

            $attendance_model = new App_Model_Knowpay_MysqlKnowpayAttendanceStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'aka_day', 'oper' => '=', 'value' => strtotime(date('Y-m-d')));
            $where[] = array('name' => 'aka_m_id', 'oper' => '=', 'value' => $uid);
            $where[] = array('name' => 'aka_s_id', 'oper' => '=', 'value' => $this->sid);
            $hadAttendance = $attendance_model->getRow($where);
            $info['data']['hadAttendance'] = $hadAttendance?1:0;

            $this->outputSuccess($info);
        }else{
            $this->outputError('店铺不存在，请核实');
        }
    }

    /*
     * 获得第一条语录
     */
    public function _get_quotation(){
        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
        $where[] = array('name' => 'kcq_s_id', 'oper' => '=', 'value' => $this->sid);
        $sort = array('kcq_create_time'=>'desc');
        $list = $quotation_model->getQuotationMemberList($where,0,1,$sort);
        if($list[0]){
            $row = $list[0];
            $data = array(
                'id' => $row['kcq_id'],
                'content' => $row['kcq_content'] ? $row['kcq_content'] : '',
                'cover' => $row['kcq_cover'] ? $this->dealImagePath($row['kcq_cover']) : '',
                'likeNum' => intval($row['kcq_like_num']),
                'commentNum' => intval($row['kcq_comment_num']),
                'isLike'  => $this->_quotation_like($row['kcq_id'])
            );
        }
        return $data;
    }

    /**
     * 获取首页通知公告
     */
    private function _get_recommend_by_type($tpl_id,$type = 0){
        $recommend_storage = new App_Model_Knowpay_MysqlKnowpayRecommendStorage($this->sid);
        $recommend_list = $recommend_storage->fetchShowList($tpl_id,$type);
        $data = array();
        if($recommend_list){
            if($type == 1){
                //大图推荐内容
                $data = array(
                    'img' => $recommend_list[0]['akr_cover'] ? $this->dealImagePath($recommend_list[0]['akr_cover']) : '',
                    'link' => $recommend_list[0]['akr_link'],
                    'title' => '',
                    'linkType' => intval($recommend_list[0]['akr_link_type']),
                    'url'  => $this->get_link_by_type($recommend_list[0]['akr_link_type'],$recommend_list[0]['akr_link'],$recommend_list[0]['akr_title'],$recommend_list['akr_title']),
                );

            }elseif ($type == 2){
                //推荐音频
                $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);

                foreach ($recommend_list as $val){
                    $goods = $goods_storage->getRowById($val['akr_link']);
                    $data[] = array(
                        'img' => '',
                        'link' => $val['akr_link'],
                        'title' => $goods['g_name'],
                        'linkType' => intval($val['akr_link_type']),
                        'url'  => $this->get_link_by_type($val['akr_link_type'],$val['akr_link'],'',''),
                    );
                }

            }else{
                //普通推荐内容
                foreach ($recommend_list as $val){
                    $data[] = array(
                        'img' => $val['akr_cover'] ? $this->dealImagePath($val['akr_cover']) : '',
                        'link' => $val['akr_link'],
                        'title' => $val['akr_title'] ? $val['akr_title'] : '',
                        'linkType' => intval($val['akr_link_type']),
                        'url'  => $this->get_link_by_type($val['akr_link_type'],$val['akr_link'],$val['akr_title'],$val['akr_title']),
                    );
                }
            }

        }else{
            if($type == 1){
                $data = '';
            }
        }
        return $data;

    }

    /**
     * 通知公告
     */
    private function _index_notice_list(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'title'    => $val['atn_title'],
                    'link'     => $val['atn_article_id'] > 0 ? $val['atn_article_id'] : 0,
                    'url'      => $val['atn_article_id'] > 0 ? $this->get_link_by_type(1,$val['atn_article_id'],'') : ''
                );
            }
        }
        return $data;
    }


    //检查是否是vip
    private function _check_is_vip($uid){
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $uid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        if($member_card){
            return 1;
        }else{
            return 0;
        }
    }


    /**
     * 获取首页幻灯
     */
    private function _shop_index_slide($tpl_id){
        Libs_Log_Logger::outputLog($tpl_id);
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($this->sid);
        $slide      = $slide_storage->fetchSlideShowList($tpl_id);
        Libs_Log_Logger::outputLog($slide);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'],
                    'type' => intval($val['ss_link_type']),
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],'',$val['ss_article_title']),
                );
            }
        }
        return $data;
    }

    /**
     * 获取分类导航
     */
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
                    'type' => intval($val['ss_link_type']),
                    'link' => isset($val['ss_link']) ? $val['ss_link'] : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name'],$val['ss_article_title']),
                );
            }
        }
        return $data;
    }

    /**
     * 获取店铺赠送的优惠券列表
     */
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
                        /*$indata = [
                            'cr_s_id' => $this->sid,
                            'cr_m_id' => $uid,
                            'cr_c_id' => $value['cl_id'],
                            'cr_receive_time' => time(),
                        ];
                        $receive_model->insertValue($indata);
                        //设置领取量+1
                        $coupon_model->incrementReceiveCount($value['cl_id'], 1);*/
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

    /**
     * 获取店铺模板配置
     */
    private function _shop_index_tpl($tpl_id){
        $data = array();
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $tpl   = $tpl_model->findUpdateBySid($tpl_id);
        if($tpl){
            $data = array(
                'temp'         => $tpl_id,
                'title'        => $tpl['aki_title'],
                'recommendTitle' => isset($tpl['aki_recommend_title']) ? $tpl['aki_recommend_title'] : '推荐',
                'searchText'     => isset($tpl['aki_search_tip']) ? $tpl['aki_search_tip'] : '请输入关键词',
                'memberEntrance' => $tpl['aki_member_entrance_img'] ? $this->dealImagePath($tpl['aki_member_entrance_img']) : $this->dealImagePath('/public/wxapp/images/member-enter.png'),
                'entranceOpen'   => intval($tpl['aki_member_entrance_open']),
                'quotationOpen'  => intval($tpl['aki_quotation_open']),
                'quotationTitle' => $tpl['aki_quotation_title'] ? $tpl['aki_quotation_title'] : '精选语录',
                'audioTitle'     => $tpl['aki_audio_title'] ? $tpl['aki_audio_title'] : '推荐音频',
                'noticeTitle'    => $tpl['aki_notice_title'] ? $tpl['aki_notice_title'] : '公告'
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

    /**
     * @param $tpl
     * @return array
     * 获取店铺首页展示的分类数据
     */
    private function _shop_kind_list($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'name'  => $val['amk_name'],
                    'link'  => $val['amk_link'],
                    'id'    => intval($val['amk_sign']),
                    'img'   => isset($val['amk_img']) && $val['amk_img'] ? $this->dealImagePath($val['amk_img']) : ($this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : ''),
                    'goods' => $this->_goods_list_by_kind($val['amk_link'],$val['amk_sign']),
                    'url'   => $this->get_link_by_type(26,$val['amk_link'],$val['amk_name'],$val['amk_sign']),
                );
            }
        }
        return $data;
    }

    /**
     * 根据商品分类获取分类下的商品（默认取10个）
     */
    private function _goods_list_by_kind($kind,$goodsKind){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'g_knowledge_pay_type', 'oper' => '=', 'value' => $kind);
        $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]    = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
        if(intval($goodsKind) > 0){
            $where[]    = array('name' => 'g_kind1', 'oper' => '=', 'value' => $goodsKind);
        }
        $sort       =  array('g_weight'=>'DESC','g_update_time' => 'DESC');

        $goods_list = $goods_storage->getList($where, 0, 10, $sort);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_goods_details($val);
            }
        }
        return $data;
    }

    /**
     * 格式化商品数据
     */
    private function _format_goods_details($goods,$detail=false,$laid=0){
        $uid = plum_app_user_islogin();
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
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $tpl  = $tpl_model->findUpdateBySid($this->applet_cfg['ac_index_tpl']?$this->applet_cfg['ac_index_tpl']:59);
        if($goods){
            $teacher = '';
            if($goods['g_label']){
                $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->sid);
                $teacher = $teacher_storage->getRowById($goods['g_label']);
            }
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'points'     => $goods['g_points'],
                'weight'     => floatval($goods['g_goods_weight']),
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => $goods['g_stock_show'],
                'sold'       => $goods['g_sold'],
                'soldShow'   => $goods['g_sold_show'],
                'freight'    => $goods['g_unified_fee'],
                'totalNum'   => $goods['g_knowledge_total'],
                'author'     => $teacher?$teacher['akt_name']:$goods['g_label'],
                'type'       => $goods['g_knowledge_pay_type'],
                'isNew'      => $goods['g_special'],
                'isPoint'    => ($goods['g_type'] == 4 || $goods['g_type'] == 5)?1:0,
            );

            $data['authorInfo'] = array(
                'id' => $teacher?$teacher['akt_id']:0,
                'name' => $teacher?$teacher['akt_name']:$goods['g_label'],
                'avatar' => $teacher?$this->dealImagePath($teacher['akt_avatar']):'',
                'label' => $teacher['akt_label']
            );

            switch ($goods['g_knowledge_pay_type']){
                case 1:
                    if($tpl['aki_article_cover_type'] == 2){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_article_cover_type'];
                    break;
                case 2:
                    if($tpl['aki_audio_cover_type'] == 2){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_audio_cover_type'];
                    break;
                case 3:
                    if($tpl['aki_video_cover_type'] == 1){
                        $data['cover'] = isset($goods['g_cover1']) ? $this->dealImagePath($goods['g_cover1']) : '';
                    }
                    $data['coverType'] = $tpl['aki_video_cover_type'];
                    break;
            }

            $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
            $hadBuy = $order_model->getTradeByGid($goods['g_id'],$uid);
            $data['hadBuy'] = $hadBuy?1:0;
            $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
            $data['updateNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id']);

            $data['readNum'] = $knowpay_model->getReadNumByGid($goods['g_id']);

            $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'akc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'akc_c_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'akc_g_id', 'oper' => '=', 'value' => $goods['g_id']);
            $data['commentCount'] = $comment_model->getCount($where);

            $uid    = plum_app_user_islogin();
            $vipData = App_Helper_Trade::getKnowpayGoodsVipPirce($data['price'], $this->sid, $goods['g_id'], 0,$uid, 1);
            $data['oriPrice'] = $data['price'];
            $data['price'] = $vipData['price'];
            $data['isVip'] = $vipData['isVip'];

            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);
            $data['isVipPrice'] = ($levelList && ($goods['g_had_vip_price'] || $goods['g_join_discount'])) || $vipData['isVipPrice'] ? 1 : 0;
            $data['vipLabel'] = '会员折扣';
            $data['vipPrice'] = $goods['g_had_vip_price']?json_decode($goods['g_vip_price_list'], true)[0]['price']:$vipData['price'];
            $vipPriceListArr = $this->_get_vip_price_list($data['price'], $goods['g_vip_price_list']);
            $data['vipPriceList'] = $vipPriceListArr['vipPriceList'];
            $data['maxVipPrice']  = $vipPriceListArr['maxVipPrice'];
            $data['minVipPrice']  = $vipPriceListArr['minVipPrice'];

            //显示已学习的课程数量
            $study_model = new App_Model_Knowpay_MysqlKnowpayStudyStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $uid);
            $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
            $studyList = $study_model->getList($where);
            foreach ($studyList as $value){
                foreach (json_decode($value['aks_knowledge_ids'], true) as $val){
                    $hadRead[] = $val;
                }
            }

            $data['hadReadNum'] = $knowpay_model->getKnowledgeCountByGid($goods['g_id'], $hadRead);

            $data['label'] = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $data['label'][] = $val;
                    }
                }
            }
            // 是否获取商品详情
            if($detail){
                $data['detail'] = plum_parse_img_path_new($goods['g_detail']);
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
                    $data['oriPrice'] = floatval($goods['g_price']);
                    $data['price']  = $limit_price;
                    $data['restriction']  = intval($limit_act['lg_limit']);
                    if ($data['format']) {
                        foreach ($data['format'] as &$item) {
                            $item['price']   = $limit_price;
                        }
                    }
                    //单独秒杀销量
                    $data['limitSold']  = $limit_act['lg_sold'];
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $data['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $goods['g_stock'];
                    //覆盖原抢购百分比
                    $data['limitHadSale'] = (round($limit_act['lg_sold']/($limit_act['lg_sold']+$data['limitStock']),2)*100).'%';
                    $data['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                }

            }
            $data['price'] = floatval($data['price']);
            return $data;
        }
        return false;
    }

    /**
     * 讲师详情
     */
    public function teacherDetailAction(){
        $id = $this->request->getIntParam('id');
        $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->sid);
        $teacher = $teacher_storage->getRowById($id);
        if($teacher){
            $info['data'] = array(
                'id'   => $teacher['akt_id'],
                'name' => $teacher['akt_name'],
                'avatar' => $this->dealImagePath($teacher['akt_avatar']),
                'label' => $teacher['akt_label'],
                'desc'  => $teacher['akt_desc'],
                'detail' => plum_parse_img_path($teacher['akt_detail'])
            );

            $this->outputSuccess($info);
        }else{
            $this->outputError("获取失败");
        }
    }

    /**
     * @param $list
     * @param $format
     * @param $hasFormat
     * @return array
     * 获取vip价格列表
     */
    private function _get_vip_price_list($price, $list){

        $data = array();
        $level_model = new App_Model_Member_MysqlLevelStorage();

        $vipPriceList = json_decode($list, true);
        $priceArr = [];
        if($vipPriceList){
            foreach ($vipPriceList as $value){
                $level = $level_model->getRowById($value['identity']);
                if($level){
                    if($value['price'] > 0){
                        $data[$value['identity']] = array(
                            'identity'  => $level['ml_name'],
                            'price' => $value['price']
                        );
                        $priceArr[] = $value['price'];
                    }
                }
            }
        }
        if(empty($data)){
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getListBySid($this->sid);
            if($level){
                foreach ($level as  $value){
                    if($value['ml_discount']){
                        $data[$value['ml_id']] = array(
                            'identity'  => $value['ml_name'],
                            'price' => number_format( $price* ($value['ml_discount']/10), 2, ".", "")
                        );
                        $priceArr[] = number_format( $price* ($value['ml_discount']/10), 2, ".", "");
                    }
                }
            }
        }
        return array(
            'vipPriceList' => array_values($data),
            'maxVipPrice'  => count($priceArr)>1?floatval(max($priceArr)):floatval($priceArr[0]),
            'minVipPrice'  => count($priceArr)>1?floatval(min($priceArr)):floatval($priceArr[0])
        );
    }

    /**
     * 推荐商品
     */
    public function recommendGoodsAction(){
        $count = 10;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);//筛选店长推荐商品
        $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]    = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);

        $total = $goods_model->getCount($where);
        $sort = array('g_update_time' => 'DESC');
        if($total > $count){
            $index = rand(0, $total-$count);
            $list = $goods_model->getList($where, $index, $count, $sort);
        }else{
            $list = $goods_model->getList($where, 0, $count, $sort);
        }
        $info['data'] = array();
        foreach ($list as $val){
            $info['data'][] = $this->_format_goods_details($val);
        }
        $this->outputSuccess($info);
    }

    /**
     * 获取分类信息
     */
    public function categoryListAction(){
        // 获取店铺商品的分类信息
        $categoryId = $this->request->getIntParam('categoryId');
        $category_model = new App_Model_Shop_MysqlKindStorage($this->sid);
        if($categoryId && $categoryId>0){
            $category_list = $category_model->getSonsByFid($categoryId);
        }else{
            $category_list = $category_model->getAllFirstCategory();
        }
        if($category_list){
            $info = array();
            foreach ($category_list as $val){
                $info['data'][] = array(
                    'id'        => $val['sk_id'],
                    'name'      => $val['sk_name']
                );
            }
            // 是否开启一级分类
            $info['noflTab'] = 1;
            $this->outputSuccess($info);
        }else{
            $this->outputError('尚未添加分类');
        }
    }

    /**
     * 搜索
     */
    public function searchGoodsAction(){
        $name = $this->request->getStrParam('name');

        //抖音小程序检查关键字是否违规
        if($this->appletType == 4){
            $client = new App_Plugin_Toutiao_XcxClient($this->sid);
            $res = $client->antidirt($name);
            if(isset($res['data'][0]['predicts'][0]['prob']) && $res['data'][0]['predicts'][0]['prob'] == 1){
                $info['data'] = [
                    'prob' => 1,
                    'msg' => '您输入的内容包含违规信息，请重新输入'
                ];
                $this->outputSuccess($info);
                exit;
            }
        }

        if($name){
            $this->_save_search_history($name);
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
            $name = $this->utf8_str_to_unicode($name);
            $where[]    = array('name' => 'g_name', 'oper' => 'like', 'value' => "%{$name}%");
            $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
            $where[]    = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);

            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where, 0, 0, $sort);
            $total = $goods_model->getCount($where);
            $info['data'] = array();
            $info['data']['article'] = array();
            $info['data']['audio'] = array();
            $info['data']['video'] = array();
            $info['data']['total'] = $total;
            if($list){
                foreach ($list as $val){
                    if($val['g_knowledge_pay_type'] == 1){
                        $info['data']['article'][] = $this->_format_goods_details($val);
                    }
                    if($val['g_knowledge_pay_type'] == 2){
                        $info['data']['audio'][] = $this->_format_goods_details($val);
                    }
                    if($val['g_knowledge_pay_type'] == 3){
                        $info['data']['video'][] = $this->_format_goods_details($val);
                    }
                }
                $this->outputSuccess($info);
            }else{
                $this->outputError('数据加载完毕');
            }
        }else{
            $this->outputError('请输入搜索内容');
        }
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
                'acsh_type'  => 1,
                'acsh_update_time' => time()
            );
            $history_model->insertValue($data);
        }
    }

    /*
     * 商品列表
     */
    public function goodsListAction(){
        $count = 10;
        $knowType = $this->request->getIntParam('knowType'); //1 专栏 2音频 3视频
        $category = $this->request->getIntParam('category'); //分类
        $type     = $this->request->getIntParam('type'); // 0 全部 1免费 2付费 3新品
        $page     = $this->request->getIntParam('page');
        $sourcetype = $this->request->getStrParam('sourcetype');
        $index    = $count * $page;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]    = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);

        if($this->applet_cfg['ac_type'] == 21){
            $where[]    = array('name' => 'g_knowledge_pay_type', 'oper' => '>', 'value' => 0);
        }

        if($knowType){
            $where[]    = array('name' => 'g_knowledge_pay_type', 'oper' => '=', 'value' => $knowType);
        }

        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
        $kindRow = $kind_model->getRowById($category);

        if($category && $kindRow['sk_level'] == 1){
            $where[]    = array('name' => 'g_kind1', 'oper' => '=', 'value' => $category);
        }

        if($category && $kindRow['sk_level'] == 2){
            $where[]    = array('name' => 'g_kind2', 'oper' => '=', 'value' => $category);
        }

        if($sourcetype == 'recommend'){
            $where[]    = array('name' => 'g_is_top', 'oper' => '=', 'value' => 1);
        }
        if($type){
            if($type == 1){
                $where[]    = array('name' => 'g_price', 'oper' => '=', 'value' => 0);
            }
            if($type == 2){
                $where[]    = array('name' => 'g_price', 'oper' => '!=', 'value' => 0);
            }
            if($type == 3){
                $where[]    = array('name' => 'g_special', 'oper' => '=', 'value' => 1);
            }
        }
        $sort = array('g_update_time' => 'DESC');
        $list = $goods_model->getList($where, $index, $count, $sort);
        $info['data'] = array();
        foreach ($list as $val){
            $info['data'][] = $this->_format_goods_details($val);
        }
        $this->outputSuccess($info);
    }

    /**
     * 获取商品详情
     */
    public function goodsDetailAction(){
        $gid = $this->request->getIntParam('gid');
        $laid   = $this->request->getIntParam('laid');  // 限时抢购活动id
        if(!$laid){
            $limit_goods_storage = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
            $limit_act = $limit_goods_storage->getActByGid($gid, $laid, 1);
            $laid = $limit_act['la_id'];
        }

        if($gid){
            //获取店铺商品
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->findGoodsBySidGid($this->sid,$gid);
            if($goods){
                $info['data'] = $this->_format_goods_details($goods,true,$laid);

                //获得配置
                $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
                $index = $index_model->findUpdateBySid(59);
                switch ($goods['g_knowledge_pay_type']){
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
                $info['data']['tabField'] = $tab_field;
                $info['data']['allowComment'] = intval($index['aki_allow_comment']);

                $this->outputSuccess($info);
            }else{
                $this->outputError('商品不存在');
            }
        }else{
            $this->outputError('商品不存在');
        }
    }

    /**
     * 获取商品下面的课程
     */
    public function knowledgeAction(){
        $uid = plum_app_user_islogin();
        $gid = $this->request->getIntParam('gid');
        $sort = $this->request->getStrParam('sort');
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $hadBuy = $order_model->getTradeByGid($gid,$uid)?1:0;
        $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
        $list = $knowpay_model->getKnowledgeByGid($gid, 0, 0, $sort);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->findGoodsBySidGid($this->sid,$gid);
        $isFree = ($goods['g_price'] == 0 && $goods['g_points'] == 0)?true:false;
        $info['data'] = array();
        foreach ($list as $val){
            $info['data'][] = $this->_format_knowledge($val,false,$hadBuy, $isFree);
        }
        if($list){
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    private function _format_knowledge($knowledge, $detail=false, $hadBuy, $isFree){
        if($hadBuy || $knowledge['akk_is_free'] || $isFree){
            $data['id']      = $knowledge['akk_id'];
        }
        $data['title']   = $knowledge['akk_name'];
        $data['readNum'] = $knowledge['akk_read_num'];
        $data['freeTime'] = intval($knowledge['akk_free_time']);
        $data['time']    = date('Y-m-d', $knowledge['akk_create_time']);
        $data['type']    = $knowledge['akk_type'];
        $data['gid']     = $knowledge['akk_g_id'];
        $data['hadBuy']  = $hadBuy;
        if($detail && ($hadBuy || $knowledge['akk_is_free'] || $isFree)){
            $data['content'] = plum_parse_img_path_new($knowledge['akk_content']);
            $data['cover']   = $this->dealImagePath($knowledge['akk_cover']);
            $data['url']     = $this->_preg_replace_url($knowledge['akk_url']);
        }
        return $data;
    }
    /*
     * 将http域名替换成https
     */
    private function _preg_replace_url($url){
        if($this->appletType==4){
            $url = preg_replace('/^http?:\/\//','https://',$url);
        }
        return $url;
    }
    /**
     * 获取课程详情
     */
    public function knowledgeDetailAction(){
        $uid = plum_app_user_islogin();
        $id = $this->request->getIntParam('id');
        $oper = $this->request->getStrParam('oper');
        $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->sid);
        $knowledge = $knowpay_model->getRowById($id);
        $list = $knowpay_model->getKnowledgeByGid($knowledge['akk_g_id'], 0, 0);
        $kids = array();
        foreach ($list as $val){
            $kids[] = $val['akk_id'];
        }
        $offset = array_search($id, $kids);
        if($oper){
            if($oper == 'prev'){
                $id = $kids[$offset-1];
            }else{
                $id = $kids[$offset+1];
            }
            if($id){
                $knowledge = $knowpay_model->getRowById($id);
            }
        }
        $offset = array_search($id, $kids);
        $hadPrev = true;
        $hadNext = true;
        if($offset==0){
            $hadPrev = false;
        }
        if($offset==count($kids)-1){
            $hadNext = false;
        }
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
        $hadBuy = $order_model->getTradeByGid($knowledge['akk_g_id'], $uid)?1:0;
        if($knowledge){
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
            $goods = $goods_model->getRowById($knowledge['akk_g_id']);
            $label = array();
            if(isset($goods['g_custom_label'])){
                $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                foreach ($labelArr as $val){
                    if($val && isset($val)){
                        $label[] = $val;
                    }
                }
            }
            $isFree = $goods['g_price'] == 0?true:false;
            $info['data'] = $this->_format_knowledge($knowledge, true, $hadBuy, $isFree);
            $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
            $where = array();
            $where[] = array('name' => 'akc_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'akc_c_id', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'akc_k_id', 'oper' => '=', 'value' => $id);
            $info['data']['commentCount'] = $comment_model->getCount($where);
            $info['data']['label'] = $label;
            $info['data']['hadPrev'] = $hadPrev;
            $info['data']['hadNext'] = $hadNext;

            //获得课程本身价格
            $vipData = App_Helper_Trade::getKnowpayGoodsVipPirce($goods['g_price'], $this->sid, $goods['g_id'], 0,$uid, 1);
            $info['data']['isVip'] = $vipData['isVip'];
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $levelList = $level_model->getListBySid($this->sid);
            $isVipPrice = $levelList || $goods['g_had_vip_price'] || $vipData['isVipPrice'] ? 1 : 0;
            $vipPrice = $goods['g_had_vip_price']?json_decode($goods['g_vip_price_list'], true)[0]['price']:$vipData['price'];
            $info['data']['price'] = $isVipPrice && $vipData['isVip'] ? $vipPrice : $goods['g_price'];
            $info['data']['seckill']  = 0;//是否参与秒杀活动
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $act_goods= $act_model->getAllRunningGoodsAct();
            foreach($act_goods as $value){
                if($goods['g_id'] == $value['lg_g_id']){
                    $laid = $value['la_id'];
                }
            }
            if($laid>0){
                //获取限时抢购活动
                $limit_buy  = new App_Helper_LimitBuy($this->sid);
                $limit_act  = $limit_buy->checkLimitAct($goods['g_id'],$laid);
                //进行中的限时抢购活动
                if ($limit_act && $limit_act['status'] == App_Helper_LimitBuy::LIMIT_BUY_RUN) {
                    $info['data']['seckill']  = 1;
                    //覆盖原有价格
                    $limit_price    = floatval($limit_act['lg_yh_price']);
                    $info['data']['price']  = $limit_price;
                    $info['data']['restriction']  = intval($limit_act['lg_limit']);
                    //单独秒杀销量
                    $info['data']['limitSold']  = $limit_act['lg_sold'];
                    //若单独设置秒杀数量,取设置值,否则取库存
                    $info['data']['limitStock'] = $limit_act['lg_stock'] ? $limit_act['lg_stock'] : $goods['g_stock'];
                    //覆盖原抢购百分比
                    $info['data']['limitHadSale'] = (round($limit_act['lg_sold']/($limit_act['lg_sold']+$info['data']['limitStock']),2)*100).'%';
                    $info['data']['limit'] = array(
                        'id'         => $limit_act['la_id'],
                        'name'       => $limit_act['la_name'],
                        'label'      => $limit_act['la_label'],
                        'img'        => $this->dealImagePath($limit_act['la_bg_img']),
                        'startTime'  => $limit_act['la_start_time'],
                        'endTime'    => $limit_act['la_end_time'],
                    );
                }
            }



            $info['data']['recommendGoods'] = array();
            if($knowledge['akk_recommend_goods']){
                $info['data']['recommendGoods'] = $this->_recommend_goods_info($knowledge['akk_recommend_goods']);
            }
            //增加浏览量
            $knowpay_model->increaseReadNum($id);
            //保存学习记录
            $this->_record_study_history($id, $knowledge['akk_type']);
            if($uid){
                $point_storage = new App_Helper_Point($this->sid);
                $point_storage->gainPointBySource($uid,App_Helper_Point::POINT_SOURCE_STUDY, array('course' => $knowledge['akk_name']));
            }
            $info['data']['price'] = floatval($info['data']['price']);

            //获得配置
            $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
            $index = $index_model->findUpdateBySid(59);

            $info['data']['allowComment'] = intval($index['aki_allow_comment']);
            $passTime = $this->_save_knowledge_record($knowledge['akk_g_id'],$knowledge['akk_id']);

            $info['data']['passTime'] = $passTime;

            $this->outputSuccess($info);
        }else{
            $this->outputError('课程不存在');
        }
    }

    /**
     * 获取课程评价信息
     */
    public function commentListAction(){
        $gid = $this->request->getIntParam('gid');
        $kid = $this->request->getIntParam('kid');
        $count = 10;   // 帖子评论一次加载30条
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $comment_model = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->sid);
        $list = $comment_model->getCommentMember($gid,$kid,0,$index,$count);
        $like_model = new App_Model_Knowpay_MysqlKnowpayCommentLikeStorage($this->sid);
        $uid = plum_app_user_islogin();
        if($list){
            $info = array();
            foreach ($list as $key => $val){
                $info['data'][$key] = $this->_post_comment_format($val);
                $where = array();
                if($gid){
                    $where[] = array('name'=>'akc_g_id','oper'=>'=','value'=>$gid);
                }
                if($kid){
                    $where[] = array('name'=>'akc_k_id','oper'=>'=','value'=>$kid);
                }
                $where[] = array('name'=>'akc_c_id','oper'=>'=','value'=>$val['akc_id']);
                $info['data'][$key]['replyCount'] = $comment_model->getCommentListMemberCount($where);
                $info['data'][$key]['likeCount'] = $like_model->getLikeCount($val['akc_id']);
                $info['data'][$key]['isLike'] = $like_model->getLikeByMidPid($uid,$val['akc_id'])?1:0;
                $info['data'][$key]['time'] = $this->_format_date($val['akc_time'], 'list');
                $rlist = $comment_model->getCommentMember($gid,$kid,$val['akc_id'],$index,$count);
                $info['data'][$key]['replyList'] = array();
                foreach ($rlist as $v){
                    $info['data'][$key]['replyList'][] = $this->_post_comment_format($v);
                }
            }
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
    private function _format_date($createTime,$type){
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
                    $date = date('m',$createTime).'月'.date('d',$createTime).'　'.date('H:i',$createTime);
            }

        }else{
            $date = date('m',$createTime).'月'.date('d',$createTime).'　'.date('H:i',$createTime);
        }
        return $date;
    }

    /**
     * 评论信息格式化
     */
    private function _post_comment_format($val){
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['akc_id'],
                'comment'       => $val['akc_comment'],
                'mid'           => $val['akc_m_id'],
                'avatar'        => $val['m_avatar']?$this->dealImagePath($val['m_avatar']):($val['m_id']?$this->dealImagePath('/public/wxapp/images/applet-avatar.png'):$this->dealImagePath($this->shop['s_logo'])),
                'nickname'      => $val['m_nickname']?$val['m_nickname']:$this->shop['s_name'],
                'replyMid'      => $val['akc_reply_mid'] ? $val['akc_reply_mid'] : 0,
                'replyNickname' => isset($val['akc_reply_mid']) && isset($val['rm_nickname']) ? $val['rm_nickname'] : $this->shop['s_name']
            );
        }
        return $data;
    }

    /*
     * 获得推荐商品信息
     */
    private function _recommend_goods_info($gids = ''){
        $goodsInfo = array();
        $where     = array();
        $gidArr = json_decode($gids,1);

        if(!empty($gidArr)){
            $where[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $gidArr);
            $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->sid);
            $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
            $where[]    = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);
            $g_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);
            $goodsList = $g_model->getList($where,0,0,array(),array('g_id','g_name','g_cover','g_price','g_sold'));
            if($goodsList){
                foreach ($goodsList as $goods){
                    $goodsInfo[] = array(
                        'gid'   => intval($goods['g_id']),
                        'name'  => $goods['g_name'],
                        'cover'  => $this->dealImagePath($goods['g_cover'])
                    );
                }
            }
        }
        return $goodsInfo;
    }

    private function _record_study_history($id, $type){
        $uid = plum_app_user_islogin();
        $study_model = new App_Model_Knowpay_MysqlKnowpayStudyStorage($this->sid);
        $where = array();
        $where[] = array('name' => 'aks_day', 'oper' => '=', 'value' => strtotime(date('Y-m-d')));
        $where[] = array('name' => 'aks_m_id', 'oper' => '=', 'value' => $uid);
        $where[] = array('name' => 'aks_s_id', 'oper' => '=', 'value' => $this->sid);
        $row = $study_model->getRow($where);
        if($row){
            $ids = json_decode($row['aks_knowledge_ids'], 'true');
            if(!in_array($id, $ids)){
                $ids[] = $id;
                $data = array();
                $data['aks_knowledge_ids'] = json_encode($ids);
                $data['aks_study_count']   = $row['aks_study_count'] + 1;
                if($type == 1){
                    $data['aks_study_article_count'] = $row['aks_study_article_count'] + 1;
                }
                if($type == 2){
                    $data['aks_study_audio_count'] = $row['aks_study_audio_count'] + 1;
                }
                if($type == 3){
                    $data['aks_study_video_count'] = $row['aks_study_video_count'] + 1;
                }
                $study_model->updateById($data, $row['aks_id']);
            }
        }else{
            $ids[] = $id;
            $data = array();
            $data['aks_s_id'] = $this->sid;
            $data['aks_m_id'] = $uid;
            $data['aks_knowledge_ids'] = json_encode($ids);
            $data['aks_study_count']   = 1;
            if($type == 1){
                $data['aks_study_article_count'] = 1;
            }
            if($type == 2){
                $data['aks_study_audio_count'] = 1;
            }
            if($type == 3){
                $data['aks_study_video_count'] = 1;
            }
            $data['aks_day'] = strtotime(date('Y-m-d'));
            $data['aks_create_time'] = time();
            $study_model->insertValue($data);
        }
    }

    /**
     * 活动页配置
     */
    public function activityAction(){
        if($this->shop){
            $info = array();
            $info['data'] = array(
                'suid'           => $this->suid,
                'template'       => $this->_activity_index_tpl(),         // 模板信息
                'slide'          => $this->get_shop_index_slide(0, 7),       // 首页幻灯
            );
            $info['data']['activity'] = $info['data']['template']['activity'];
            unset($info['data']['template']['activity']);
            foreach ($info['data']['activity'] as $key => $val){
                $info['data']['activity'][$key]['goods'] = $this->_get_activity_goods($info['data']['activity'][$key]['link']);
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('店铺不存在，请核实');
        }
    }

    /**
     * 获取店铺模板配置
     */
    private function _activity_index_tpl(){
        $data = array();
        $tpl_model = new App_Model_Knowpay_MysqlActivityCfgStorage($this->sid);
        $tpl   = $tpl_model->fetchUpdateCfg();
        if($tpl){
            $data = array(
                'title'        => $tpl['aka_title'],
                'activity'     => json_decode($tpl['aka_kinds'], true)
            );
        }
        return $data;
    }

    /**
     * 根据类型获取活动商品
     */
    private function _get_activity_goods($type){
        $uid = plum_app_user_islogin();
        if($type == 1){
            //获取拼团商品
            $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);
            $act_arr    = $group_model->getCurrentListByType($type,0,0);
            $data = array();
            foreach ($act_arr as &$one) {
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $hadJoin = $order_model->getTuanTradeByGid($one['g_id'], $uid);
                //$had_total   = $org_model->getGroupMemberCount($one['gb_id']);
                $hadBuy = $order_model->getTradeByGid($one['g_id'],$uid);
                $data[] = array(
                    'id'    => $one['gb_id'],
                    'cover' => $this->dealImagePath($one['gb_cover']),
                    'gcover'=> $this->dealImagePath($one['g_cover']),
                    'brief' => $one['g_brief'],
                    'name'  => $one['g_name'],
                    'gprice'=> $one['gb_type']==3?$one['gb_tz_price']:$one['gb_price'],
                    'price' => $one['g_price'],
                    'total' => $one['gb_total'],
                    'hadTotal' => $one['gb_joined'],
                    'hadJoin' => $hadJoin?1:0,
                    'tid'     => $hadJoin['t_tid'],
                    'hadBuy' => $hadBuy?1:0,
                    'type'       => $one['g_knowledge_pay_type'],
                    'gid'   => $one['g_id']
                );
            }
            return $data;
        }
        if($type == 2){
            //获取秒杀商品-
            $limit_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
            $list = $limit_model->getHadActGoodsList(time(), 0, 0);
            $data = array();
            if (!empty($list)) {
                foreach ($list as $val){
                    $data[] = $this->_format_goods_details($val,false,$val['la_id']);
                }
            }
            return $data;
        }
        if($type == 3){
            //获取砍价商品
            $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
            $where      = array();
            $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->sid);
            $where[]    = array('name'=>'ba_status','oper'=>'=','value'=>1);
            $where[]  = array('name'=>'ba_end_time','oper'=>'>','value'=>time());
            $sort = array('ba_status'=>'DESC','ba_create_time' => 'DESC');
            $list = $bargain_model->getActivityList($where,0,0,$sort);
            $data = array();
            foreach($list as $val){
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $hadBuy = $order_model->getTradeByGid($val['g_id'],$uid);
                $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
                $record     = $join_storage->findJoinerByAidMid($val['ba_id'], $uid);
                //参与信息
                $hadJoin     = $join_storage->getRowByIdSid($record['bj_id'], $this->sid);
                $data[] = array(
                    'id'       => $val['ba_id'],
                    'cover'    => isset($val['ba_image']) && $val['ba_image'] ? $this->dealImagePath($val['ba_image']) : $this->dealImagePath($val['g_cover']),
                    'name'     => $val['g_name'],
                    'oriPrice' => $val['ba_price'],
                    'minPrice' => $val['ba_kj_price_limit'],
                    'sold'     => $val['ba_join_num'],
                    'brief' => $val['g_brief'],
                    'type'       => $val['g_knowledge_pay_type'],
                    'hadBuy' => $hadBuy?1:0,
                    'hadJoin' => $hadJoin?1:0,
                    'gid' => $val['g_id']
                );
            }
            return $data;
        }
    }


    /**
     * 积分商品
     */
    public function pointsGoodsAction(){
        $page = $this->request->getIntParam('page');
        $type = $this->request->getIntParam('type'); // 课程 1  商品 2
        $count = 10;
        $index = $count * $page;
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        if($type == 2){
            $typeArr = array(4);
        }else{
            $typeArr = array(5);
        }
        $goods    = $goods_model->fetchShopGoodsList($this->sid, $index, $count, '',  0, array(),array(),0,0,$typeArr,array(),0);
        if($goods){
            $info['data'] = array();
            foreach($goods as $val){
                $data = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                    'cover' => $this->dealImagePath($val['g_cover']),
                    'price' => floatval($val['g_price']),
                    'points' => $val['g_points'],
                    'sold' => $val['g_sold'],
                    'desc' => $val['g_brief'],
                    'type'       => $val['g_knowledge_pay_type'],
                );
                $data['label'] = array();
                if(isset($goods['g_custom_label'])){
                    $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                    foreach ($labelArr as $v){
                        if($v && isset($v)){
                            $data['label'][] = $v;
                        }
                    }
                }
                $info['data'][] = $data;
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    /**
     * 兑换码配置
     */
    public function rechargeCfgAction(){

        if($this->applet_cfg['ac_type'] == 18){
            $tpl_model = new App_Model_Reservation_MysqlReservationIndexStorage($this->sid);
            $tpl_row = $tpl_model->findUpdateBySid(33);
            $title = $tpl_row['ari_recharge_sub_title']?$tpl_row['ari_recharge_sub_title']:"";
            $rule = $tpl_row['ari_recharge_rule'];
        }else{
            $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
            $tpl_row   = $tpl_model->findUpdateBySid(59);
            $title = $tpl_row['aki_recharge_sub_title']?$tpl_row['aki_recharge_sub_title']:"享知识饕餮盛宴，不一样的学习体验";
            $rule = $tpl_row['aki_recharge_rule'];
        }
        $info['data']['subTitle'] = $title;
        $info['data']['rule'] = $rule;
        $this->outputSuccess($info);
    }

    /**
     * 语录是否点赞
     */
    public function _quotation_like($pid){
        $uid = plum_app_user_islogin();
        $num = 0;
        $like_model = new App_Model_Knowpay_MysqlKnowpayQuotationLikeStorage($this->sid);
        $row = $like_model->getLikeByMidQid($uid,$pid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    /*
     * 语录列表
     */
    public function quotationListAction(){
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
        $where[] = array('name'=>'kcq_s_id','oper'=>'=','value'=>$this->sid);
        $sort = array('kcq_create_time'=> 'DESC');
        $list = $quotation_model->getQuotationMemberList($where,$index,$this->count,$sort);
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[] = $this->_format_quotation($val);
            }
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('没有更多信息了');
        }
    }

    private function _format_quotation($val,$isDetail = false){
        $data = [];
        if($val){
            $imgArr = [];
            $imgs = json_decode($val['kcq_images'],true);
            if(!empty($imgs) && is_array($imgs)){
                foreach ($imgs as $img){
                    $imgArr[] = $this->dealImagePath($img);
                }
            }
            $data = array(
                'id' => $val['kcq_id'],
                'nickname' => $val['m_nickname'] ? $val['m_nickname'] : '',
                'avatar'  => $val['m_avatar'] ? $this->dealImagePath($val['m_avatar']) : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'content' => $val['kcq_content'] ? plum_strip_sql_quote($val['kcq_content']) : '',
                'cover' => $val['kcq_cover'] ? $this->dealImagePath($val['kcq_cover']) : '',
                'images'  => $imgArr,
                'likeNum' => intval($val['kcq_like_num']),
                'commentNum' => intval($val['kcq_comment_num']),
                'likeList' => $this->_fetch_quotation_like($val['kcq_id']),
                'isLike'  => $this->_quotation_like($val['kcq_id']),
                'comment' => $this->_get_quotation_comment($val['kcq_id'],'list')
            );
            if($isDetail){

            }
        }
        return $data;
    }

    /*
     * 获取点赞的前几个人
     */
    private function _fetch_quotation_like($pid){
        $like_model = new App_Model_Knowpay_MysqlKnowpayQuotationLikeStorage($this->sid);
        $likeList = $like_model->getLikeMemberList($pid);
        $data = array();
        if($likeList){
            foreach ($likeList as $val){
                if($val['m_avatar']){
                    $data['avatar'][] = $this->dealImagePath($val['m_avatar']);
                }else{
                    $data['avatar'][] = $this->dealImagePath('/public/wxapp/images/applet-avatar.png');
                }
                if($val['m_nickname']){
                    $data['nickname'][] = $val['m_nickname'];
                }
            }
        }
        return $data;
    }

    /*
     * 语录详情
     */
    public function quotationDetailAction(){
        $id = $this->request->getIntParam('id');
        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->sid);
        $row = $quotation_model->getQuotationMemberRow($id);
        if($row){
            $data = $this->_format_quotation($row,true);
            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('没找到');
        }
    }

    /*
     * 获得语录评论
     */
    private function _get_quotation_comment($id,$type = ''){
        $comment_model = new App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage($this->sid);
        $list = $comment_model->getCommentMember($id,0,20);
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[] = $this->_format_quotation_comment($val,$type);
            }
            return $data;
        }
    }

    /*
     * 语录评论列表
     */
    public function quotationCommentListAction(){
        $count = 20;   // 评论一次加载20条
        $pid = $this->request->getIntParam('id');
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $comment_model = new App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage($this->sid);
        $list = $comment_model->getCommentMember($pid,$index,$count);
        $data = [];
        if($list){
            foreach ($list as $val){
                $data[] = $this->_format_quotation_comment($val,'detail');
            }

            $info['data'] = $data;
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }

    }
    /**
     * 评论信息格式化
     */
    private function _format_quotation_comment($val,$type=''){
        $index_storage = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $index = $index_storage->findUpdateBySid($this->applet_cfg['ac_type']);
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['akqc_id'],
                'comment'       => isset($val['akqc_comment']) ? plum_strip_sql_quote($type=='list' && mb_strlen($val['akqc_comment'])>50 ? mb_substr($val['akqc_comment'],0,50).'...' : $val['akqc_comment']) : '',
                'mid'           => $val['akqc_m_id'],
                'mark'          => (!$val['akqc_m_id'] && $index['aki_manager_mark_open'])? $index['aki_manager_mark']:'',
                'nickname'      => $val['m_nickname']?$val['m_nickname']:$this->shop['s_name'],
                'replyMid'      => $val['akqc_reply_mid'] ? $val['akqc_reply_mid'] : 0,
                'replyMark'     => ($val['akqc_reply_mid']==-1 && $index['aki_manager_mark_open'])? $index['aki_manager_mark']:'',
                'replyNickname' => $val['akqc_reply_mid'] ? (isset($val['rm_nickname']) ? $val['rm_nickname'] : $this->shop['s_name']) : ''
            );
        }
        return $data;
    }

    /**
     * utf8字符转换成Unicode字符
     */
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
    /*
     * 过滤掉昵称中特殊字符
     */
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

    /**
     * 会员权益页面
     */
    public function vipRightsAction(){
        $cfg_model = new App_Model_Knowpay_MysqlKnowpayRightsCfgStorage($this->sid);
        $row = $cfg_model->findUpdateBySid();

        $info['data'] = array(
            'headerTitle'  => $row?$row['akrc_header_title']:'会员权益',
            'navTitle'     => $row?$row['akrc_nav_title']:'会员权益',
            'rightsTitle'  => $row?$row['akrc_rights_title']:'会员权益',
        );

        $navList = json_decode($row['akrc_nav_list'], true);
        foreach ($navList as $val){
            $info['data']['navList'][] = array(
                'title' => $val['title'],
                'img'   => $this->dealImagePath($val['imgsrc']),
                'link'  => $this->get_link_by_type($val['type'],$val['link'],$val['title']),
            );
        }

        $cateList = json_decode($row['akrc_rights_cate'], true);
        foreach ($cateList as $val){
            $info['data']['cateList'][] = array(
                'id'   => $val['link'],
                'name' => $val['title'],
            );
        }
        $info['data']['cardList'] = $this->_get_member_card_list();
        $info['data']['vipInfo'] = array();
        $uid = plum_app_user_islogin();
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($uid);

        $info['data']['memberInfo'] = array(
            'nickname' => $member['m_nickname'],
            'avatar'   => $this->dealImagePath($member['m_avatar'])
        );

        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $member_card    = $offline_member->getUnexpireMemberInfo($member['m_id'], 2);
        if($member_card){
            $info['data']['vipInfo'] = array(
                'expireTime' => date('Y.m.d', $member_card['om_expire_time']),
                'cardId'   => $member_card['om_card_id'],
            );
            $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
            $card   = $card_model->getRowById($member_card['om_card_id']);
            $identity = intval($card['oc_identity']);
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
            $info['data']['vipInfo']['levelName'] = $level?$level['ml_name']:'';
        }
        $this->outputSuccess($info);
    }

    /**
     * 获取会员卡列表
     */
    private function _get_member_card_list(){
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'oc_deleted','oper' => '=','value' =>0);
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $sort   = array('oc_weight' => 'DESC', 'oc_price' => 'ASC', 'oc_long_type' => 'ASC','oc_update_time' => 'DESC');
        $list   = $card_model->getListLevel($where,0,0,$sort);
        $uid = plum_app_user_islogin();

        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $member_card    = $offline_member->getUnexpireMemberInfo($uid, 2);

        $color = plum_parse_config('offline_color','app');
        $cardType = plum_parse_config('offline_card_new','app');
        $data = array();
        foreach ($list as $val){
            if(!empty($val) && $val){
                $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
                 $temp = array(
                    'id'           => $val['oc_id'],
                    'name'         => $val['oc_name'],
                    'shopLogo'     => $this->dealImagePath($logo),
                    'shopName'     => $this->shop['s_name'],
                    'nameSub'      => $val['oc_name_sub'],
                    'bgType'       => $val['oc_bg_type'],
                    'bgColor'      => $color[$val['oc_bg_type']]['color'],
                    'backgroundColor' => $val['oc_background_color'] ? $val['oc_background_color'] : '',
                    'long'         => $cardType[$val['oc_long_type']]['long'],
                    'longShow'     => '有效期'.$cardType[$val['oc_long_type']]['long'].'天',
                    'longType'     => $val['oc_long_type'],
                    'longTypeShow' => $cardType[$val['oc_long_type']]['name'],
                    'price'        => $val['oc_price']>0 ? $val['oc_price'] : 0,
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
                    'backgroundImg'  => $this->dealImagePath('/public/wxapp/images/memberCard1.png')
                );
                if(!$member_card){
                    $temp['type'] = 1;
                }
                if($member_card['om_card_id'] == $val['oc_id']){
                    $temp['hadBuy'] = true;
                    $temp['hadExpire'] = $member_card['om_expire_time']<time()?true:false;
                    $temp['expireTime'] = date('Y.m.d', $member_card['om_expire_time']);
                    $temp['cardNum'] = $member_card['om_card_num'];
                    $temp['type'] = 2;
                }

                if($member_card && $member_card['om_card_id'] != $val['oc_id']){
                    $temp['type'] = 3;
                }
                $data[] = $temp;
            }
        }
        return $data;
    }

    /**
     * 会员价商品列表
     */
    public function vipGoodsListAction(){
        $count = 10;
        $knowType = $this->request->getIntParam('cate'); //1 专栏 2音频 3视频
        $page     = $this->request->getIntParam('page');
        $index    = $count * $page;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]    = array('name' => 'g_had_vip_price','oper' => '=','value' => 1);
        $where[]    = array('name' => 'g_independent_mall', 'oper' => '=', 'value' => 0);

        if($knowType){
            $where[]    = array('name' => 'g_knowledge_pay_type', 'oper' => '=', 'value' => $knowType);
        }

        $sort = array('g_update_time' => 'DESC');
        $list = $goods_model->getList($where, $index, $count, $sort);
        $info['data'] = array();
        foreach ($list as $val){
            $info['data'][] = $this->_format_goods_details($val);
        }
        $this->outputSuccess($info);
    }


    private function _save_knowledge_record($gid,$kid){
        $uid = plum_app_user_islogin();
        $time = 0;
        if($uid){
            $record_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeRecordStorage($this->sid);
            $row = $record_model->findUpdateRowBySidMidKid($this->sid,$uid,$kid);

            $set = [
                'akkr_update_time' => $_SERVER['REQUEST_TIME'],
            ];

            if($row){
                $time = intval($row['akkr_time']);
                $res = $record_model->findUpdateRowBySidMidKid($this->sid,$uid,$kid,$set);
            }else{
                $set['akkr_s_id'] = $this->sid;
                $set['akkr_m_id'] = $uid;
                $set['akkr_k_id'] = $kid;
                $set['akkr_g_id'] = $gid;
                $set['akkr_create_time'] = $_SERVER['REQUEST_TIME'];
                $res = $record_model->insertValue($set);

            }
        }
        return $time;
    }


    /**
     * 修改课程学习时间进度
     * 仅做修改
     */
    public function saveKnowledgeRecordTimeAction(){
        $kid = $this->request->getIntParam('kid');
        $gid = $this->request->getIntParam('gid');

        $time = $this->request->getIntParam('time');
        $end = $this->request->getIntParam('end');
        $record_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeRecordStorage($this->sid);
        $time = $end ? 0 : $time;
        $res  = false;
        $uid = plum_app_user_islogin();

        if($uid){
            $set = [
                'akkr_time' => $time
            ];
//            $row = $record_model->findUpdateRowBySidMidKid($this->sid,$uid,$kid);
//            if($row){
//
//            }else{
//
//            }
            $res = $record_model->findUpdateRowBySidMidKid($this->sid,$uid,$kid,$set);

        }

        if($res){
            $info['data'] = [
                'msg' => 'success'
            ];
            $this->outputSuccess($info);
        }else{
            $this->outputError('fail');
        }
    }

    /*
     * 获得图文音频视频排序
     */
    public function getKnowpayCfgAction(){
        $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->sid);
        $index = $index_model->findUpdateBySid(59);

        $typeArr = [
            [
                'name' => '文章',
                'type' => 1,
                'sort' => intval($index['aki_picture_sort'])
            ],
            [
                'name' => '音频',
                'type' => 2,
                'sort' => intval($index['aki_audio_sort'])
            ],
            [
                'name' => '视频',
                'type' => 3,
                'sort' => intval($index['aki_video_sort'])
            ],
        ];
        $len = count($typeArr);
        for ($i=0;$i<$len-1;$i++){
            for($j=0;$j<$len-1-$i;$j++){
                if($typeArr[$j]['sort'] < $typeArr[$j+1]['sort']){
                    $temp = $typeArr[$j];
                    $typeArr[$j] = $typeArr[$j+1];
                    $typeArr[$j+1] = $temp;
                }
            }
        }
        $info['data']['type'] = $typeArr;
        $this->outputSuccess($info);
    }


}

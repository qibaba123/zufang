<?php


class App_Controller_Applet_CityController extends App_Controller_Applet_InitController {

    public function __construct() {
        parent::__construct(true);
        //$this->_verify_current_applet_type(array(6,8,14,29));
    }

    
    public function indexAction(){
        //验证小程序类型
        $version = $this->request->getStrParam('version');
        $base    = $this->request->getIntParam('base');
        if($this->shop){
            //获取推荐店铺（和附近内推荐店铺一样，首页使用的为id，推荐内使用shopId，需转换）
            //$tj_shops_list = $this->_recommend_shop_list();
            $tj_shops_list = $this->_recommend_shop();
            foreach($tj_shops_list as &$v){
                $v['id'] = $v['shopId'];
            }
            //如果附近推荐店铺未配置，则显示最新的店铺
            if(!$tj_shops_list){
                $tj_shops_list = $this->_recommend_shop_list();
            }

            $info = array();
            $info['data'] = array(
                'suid'            => $this->suid,
                'logo'            => isset($this->shop['s_logo']) && $this->shop['s_logo'] ? $this->dealImagePath($this->shop['s_logo']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_200_200.png'),
                'unitId'          => $this->sid=='6952'?'adunit-2e6d9288c41d1a76':'',
                'name'            => $this->shop['s_name'],
                'watermark'       => $this->watermark,
                'watermarkImg'    => $this->watermarkImg,
                'supportMobile'   => $this->support && isset($this->support['as_mobile']) ? $this->support['as_mobile'] : '',
                'openWatermark'   => $this->openWatermark,
                'mobile'          => $this->shop['s_phone'],
                'customerService' => $this->applet_cfg['ac_kefu_open'],   //是否开启客服：0未开启，1开启
                'customerMobile'  => $this->applet_cfg['ac_kefu_mobile'],   //是否开启使用客服需授权手机号：0未开启，1开启
                'shareOpen'       => $this->applet_cfg['ac_share_open'],   // 分享海报按钮是否显示
                'shareUrl'        => isset($this->applet_cfg['ac_share_addr']) && $this->applet_cfg['ac_share_addr'] ? $this->dealImagePath($this->applet_cfg['ac_share_addr'],true) : '',   // 分享海报的图片地址
                'shareCover'      => isset($this->applet_cfg['ac_share_custom']) && $this->applet_cfg['ac_share_custom'] ? (isset($this->applet_cfg['ac_share_cover']) && $this->applet_cfg['ac_share_cover'] ? $this->dealImagePath($this->applet_cfg['ac_share_cover'],true) : '') : '',   // 分享封面图片地址
                'shareTitle'      => isset($this->applet_cfg['ac_share_custom']) && $this->applet_cfg['ac_share_custom'] ? (isset($this->applet_cfg['ac_share_title']) && $this->applet_cfg['ac_share_title'] ? $this->applet_cfg['ac_share_title'] : '') : '',   // 分享标题
                'template'        => $this->_shop_index_tpl($this->applet_cfg['ac_index_tpl']),
                'slide'           => $this->_shop_index_slide($this->applet_cfg['ac_index_tpl']),
                'notice'          => $this->_index_notice_list(),
                'category'        => $this->_index_post_category(),
                //'location'        => $this->_get_address_by_lat_lng()['building'],
                'lottery'         => $this->_check_lottery_now(),
                'recommend'       => $tj_shops_list, //推荐店铺
                'active'          => $this->_recommend_shop_info(),
                'supportOpen'     => $this->support && isset($this->support['as_audit']) ? intval($this->support['as_audit']) : 0,
                'shopInfo'        => $this->shop_company_info(),
                'openTown'        => false,   // 是否开启社区合伙人功能
                'openRelease'     => $this->_shop_index_tpl($this->applet_cfg['ac_index_tpl'])['postSubmit'],   // 是否开启发布按钮
                'popup'          => $this->_get_popup(),
            );
            $address = $this->_get_address_by_lat_lng();
            $info['data']['location'] = $address['building'];
            $info['data']['district'] = $address['district'];
            //判断是否开启了名片插件
            if($this->checkToolUsable('mpj')){
                $info['data']['mpjOpen'] = 1;
            }else{
                $info['data']['mpjOpen'] = 0;
            }
            //判断是否已经入驻 0、未入住 1、入驻过待审核 2、入住过并审核通过 3、入住过但未审核通过
            $uid = plum_app_user_islogin();
//            $apply_storage = new App_Model_City_MysqlCityShopApplyStorage($this->sid);
//            $row           = $apply_storage->findShopByUser($uid);
//            if($row){
//                if($row['acs_status']==2){
//                    // 判断审核通过的店铺是否被删除
//                    $apply_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
//                    $shop = $apply_storage->findShopByUser($uid);
//                    if($shop){
//                        $info['data']['status']=2;
//                        $info['data']['msg']='您已入驻过并且已经审核通过';
//                    }else{
//                        $info['data']['status']=3;
//                        $info['data']['msg']='您已入驻的店铺已被商家处理，请前往个人中心我的店铺进行编辑或联系商家';
//                    }
//                }else if($row['acs_status']==3){
//                    $info['data']['status']=3;
//                    $info['data']['msg']='您已入驻过但未通过审核，未通过原因为'.$row['acs_handle_remark'].'请前往个人中心我的店铺进行编辑';
//                }else if($row['acs_status']==1){
//                    $info['data']['status']=1;
//                    $info['data']['msg']='您已入驻过正在等待审核';
//                }
//            }else{
//                $info['data']['status']=0;
//                $info['data']['msg']='您还未入驻';
//            }

            //获得未读私信数量
            $msg_model = new App_Model_Car_MysqlCarChatMsgStorage($this->sid);
            $where_msg[] = array('name' => 'accm_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_msg[] = array('name' => 'accm_read', 'oper' => '=', 'value' => 0);
            $where_msg[] = array('name' => 'accm_to_mid', 'oper' => '=', 'value' => $this->member['m_id']);
            $msgCount = $msg_model->getCount($where_msg);
            $info['data']['msgCount'] = $msgCount ? $msgCount : 0;

            $apply_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
            $row           = $apply_storage->findShopByUser($uid);
            if($row){
                if($row['acs_status']==2){
                    // 判断审核通过的店铺是否被删除
                    if(!$row['acs_deleted']){
                        $info['data']['status']=2;
                        $info['data']['msg']='您已入驻过并且已经审核通过';
                    }else{
                        $info['data']['status']=3;
                        $info['data']['msg']='您已入驻的店铺已被商家处理，请前往个人中心我的店铺进行编辑或联系商家';
                    }
                }else if($row['acs_status']==3){
                    $info['data']['status']=3;
                    $info['data']['msg']='您已入驻过但未通过审核，未通过原因为'.$row['acs_handle_remark'].'请前往个人中心我的店铺进行编辑';
                }else if($row['acs_status']==1){
                    $info['data']['status']=1;
                    $info['data']['msg']='您已入驻过正在等待审核';
                }
            }else{
                $info['data']['status']=0;
                $info['data']['msg']='您还未入驻';
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

            if($version && $base){
                // $this->shop_cfg_updata($version,$base);
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('店铺不存在，请核实');
        }
    }
    
    private function _recommend_shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
        $sort  = array('acs_is_recommend'=>'desc','acs_sort'=>'desc','acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_expire_time', 'oper' => '>', 'value' => time()); //入驻未过期
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2); //审核通过
        $where[] = array('name' => 'acs_list_show', 'oper' => '=', 'value' => 1); //显示
        $shop    = $shop_storage->getList($where,0,10,$sort);
        $data = array();
        if($shop){
            foreach ($shop as $val){
                $data[] = array(
                    'id'        => $val['acs_id'],
                    'name'      => $val['acs_name'],
                    'listLabel' => $val['acs_list_label'] ? $val['acs_list_label'] : '',
                    'cover'     => $this->dealImagePath($val['acs_img']),
                );
            }
        }

        return $data;
    }
    
    private function _recommend_shop_info(){
        $shortcut_model = new App_Model_City_MysqlCityPostInfoStorage($this->sid);
        $where    = array();
        $where[]  = array('name'=>'aci_s_id','oper'=>'=','value'=>$this->sid);
        $sort     = array('aci_sort'=>'ASC');
        $shortcut = $shortcut_model->getList($where,0,0,$sort);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'id'           => $val['aci_id'] ,
                'imgsrc'       => $this->dealImagePath($val['aci_img']),
                'link'         => $val['aci_link'],
                'type'         => $val['aci_type'],
                'url'          => $this->get_link_by_type($val['aci_type'],$val['aci_link'],$val['aci_title']),

            );
        }
        return $json;
    }
    
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


    
    private function _shop_index_tpl($tpl_id){
        $data = array();
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
        $tpl = $tpl_model->findUpdateBySid($tpl_id);
        $tpl_default = [];
        if($tpl_id != 23){
            $tpl_default = $tpl_model->findUpdateBySid(23);
        }
        if($tpl_id != 23){
            $agreement = isset($tpl_default['aci_agreement']) && $tpl_default['aci_agreement'] ? plum_parse_img_path($tpl_default['aci_agreement']) : '';
        }else{
            $agreement = isset($tpl['aci_agreement']) && $tpl['aci_agreement'] ? plum_parse_img_path($tpl['aci_agreement']) : '';
        }

        $uid         = plum_app_user_islogin();
        
        //判断会员卡是否到期
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $memberRow      = $offline_member->currLevel($uid);
        if(!$memberRow){   // 如果会员卡不存在则获取会员信息
            $member = $this->member;
            if(!$member){
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_storage->getRowById($uid);
            }
        }
        $type = array(
            array('index'=>0,'name'=>'最新发布','must'=>true,'type'=>'time'),
            array('index'=>1,'name'=>'红包福利','must'=>true,'type'=>'redPacket'),
            array('index'=>2,'name'=>'最新回复','must'=>true,'type'=>'reply'),
            array('index'=>3,'name'=>'距离最近','must'=>true,'type'=>'distance')
        );
        // 商家入驻提醒
        $entry =array(
            'icon' => isset($tpl['aci_apply_icon']) && $tpl['aci_apply_icon'] ? $this->dealImagePath($tpl['aci_apply_icon']) : $this->dealImagePath('/public/wxapp/images/icon_shop.png'),
            'name' => isset($tpl['aci_apply_title']) && $tpl['aci_apply_title'] ? $tpl['aci_apply_title'] : '我是商家，我要入驻',
            'desc' => isset($tpl['aci_apply_desc']) && $tpl['aci_apply_desc'] ? $tpl['aci_apply_desc'] : '超低成本，本地宣传，简单有效，方便快捷',
            'open' => $tpl['aci_apply_open'],
        );

        if($tpl){

            if($tpl){
                $data = array(
                    'temp'          => $tpl_id,
                    'title'         => $tpl['aci_title'],
                    'noticeTitle'   => $tpl['aci_notice_title'] ? $tpl['aci_notice_title'] : '同城头条',
                    'infoTitle'     => $tpl['aci_info_title'] ? $tpl['aci_info_title'] : '优惠活动',
                    'recommendTitle'=> $tpl['aci_recommend_title'] ? $tpl['aci_recommend_title'] : '推荐店铺',
                    'browseNum'     => $this->number_format($tpl['aci_browse_num']),
                    'issueNum'      => $tpl['aci_issue_num_open'] == 1 ? $this->number_format($tpl['aci_issue_num']) : '',
                    'shopNum'       => $this->number_format($tpl['aci_shop_num']),
                    'statIcon'      => $tpl['aci_stat_icon'] ? $this->dealImagePath($tpl['aci_stat_icon']) : $this->dealImagePath('/public/wxapp/customtpl/images/icon_tj.png'),
                    'memberNum'     => $this->_get_member_count($tpl['aci_add_member']),
                    'mustMobile'    => 1, #$tpl['aci_must_mobile'],
                    'mustAddress'   => $tpl['aci_must_address'],
                    'serviceRate'   => $tpl['aci_service_rate'],
                    'regbagMin'     => $tpl['aci_redbag_min'],
                    'postType'      => isset($tpl['aci_post_type']) && $tpl['aci_post_type'] ? $this->_remove_post_quotes($tpl['aci_post_type'])['type'] : $type,
                    'submitPrompt'  => isset($tpl['aci_coop_brief']) ? $tpl['aci_coop_brief'] : '',  //发帖提示
                    'singleMin'     => $tpl['aci_single_min']>0?$tpl['aci_single_min']:0.01,
                    'coopImg'       => isset($tpl['aci_coop_img']) ? $this->dealImagePath($tpl['aci_coop_img']) : $this->dealImagePath('/public/wxapp/card/temp1/images/banner_hornor.png'),
                    'coopBrief'     => isset($tpl['aci_coop_brief']) ? plum_parse_img_path($tpl['aci_coop_brief'] ) : $this->dealImagePath('/public/wxapp/card/temp1/images/banner_hornor.png'),
                    'coopMobile'    => '13159252056',
                    'entry'         => $entry,
                    'recommendOpen' => intval($tpl['aci_recommend_open']),
                    'settledAgreement' => $agreement,
                    'postInstructions' => '',
                    'redPacket'        => isset($tpl['aci_post_type']) && $tpl['aci_post_type'] ? $this->_remove_post_quotes($tpl['aci_post_type'])['redPacket'] : false,
                    'cityMemberOpen'   => intval($tpl['aci_citymember_open']),   //是否开启同城会员，查看帖子相关信息时要用
                    'myLevel'          => $memberRow || $member['m_level'] ?1:0,
                    'town'             => $this->_get_commpany_area(),
                    'postSubmit'       => $tpl['aci_post_submit'] > 0 ? true : false
                );
            }
        }else{
            $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
            $tpl = $tpl_model->findUpdateBySid(23);
            $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
            $where = array();
            $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->sid);
            $template = $template_model->getRow($where);
            $data = array(
                'temp'         => $tpl_id,
                'title'        => $template['act_header_title'],
                'image'        => $this->dealImagePath($tpl['aci_cake_img']),
                'showPost'    => $template['act_show_post_list'],
                'showPostBtn' => $template['act_show_post_btn'],
                'postType'      => isset($tpl['aci_post_type']) && $tpl['aci_post_type'] ? $this->_remove_post_quotes($tpl['aci_post_type'])['type'] : $type,
                'settledAgreement' => $agreement,
                'noticeTitle'   => $tpl['aci_notice_title'] ? $tpl['aci_notice_title'] : '同城头条',
                'infoTitle'     => $tpl['aci_info_title'] ? $tpl['aci_info_title'] : '优惠活动',
                'recommendTitle'=> $tpl['aci_recommend_title'] ? $tpl['aci_recommend_title'] : '推荐店铺',
                'browseNum'     => $this->number_format($tpl['aci_browse_num']),
                'issueNum'      => $tpl['aci_issue_num_open'] == 1 ? $this->number_format($tpl['aci_issue_num']) : '',
                'shopNum'       => $this->number_format($tpl['aci_shop_num']),
                'statIcon'      => $tpl['aci_stat_icon'] ? $this->dealImagePath($tpl['aci_stat_icon']) : $this->dealImagePath('/public/wxapp/customtpl/images/icon_tj.png'),
                'memberNum'     => $this->_get_member_count($tpl['aci_add_member']),
                'mustMobile'    => 1, #$tpl['aci_must_mobile'],
                'mustAddress'   => $tpl['aci_must_address'],
                'serviceRate'   => $tpl['aci_service_rate'],
                'regbagMin'     => $tpl['aci_redbag_min'],
                'submitPrompt'  => isset($tpl['aci_coop_brief']) ? $tpl['aci_coop_brief'] : '',  //发帖提示
                'singleMin'     => $tpl['aci_single_min']>0?$tpl['aci_single_min']:0.01,
                'coopImg'       => isset($tpl['aci_coop_img']) ? $this->dealImagePath($tpl['aci_coop_img']) : $this->dealImagePath('/public/wxapp/card/temp1/images/banner_hornor.png'),
                'coopBrief'     => isset($tpl['aci_coop_brief']) ? plum_parse_img_path($tpl['aci_coop_brief'] ) : $this->dealImagePath('/public/wxapp/card/temp1/images/banner_hornor.png'),
                'coopMobile'    => '13159252056',
                'entry'         => $entry,
                'recommendOpen' => intval($tpl['aci_recommend_open']),
                'postInstructions' => '',
                'redPacket'        => isset($tpl['aci_post_type']) && $tpl['aci_post_type'] ? $this->_remove_post_quotes($tpl['aci_post_type'])['redPacket'] : false,
                'cityMemberOpen'   => intval($tpl['aci_citymember_open']),   //是否开启同城会员，查看帖子相关信息时要用
                'myLevel'          => $memberRow || $member['m_level'] ?1:0,
                'town'             => $this->_get_commpany_area(),
                'postSubmit'       => $tpl['aci_post_submit'] > 0 ? true : false

            );
        }
        $data['postTab'] = $this->_shop_index_post_tab($tpl_id);
        return $data;
    }

    
    private function _get_commpany_area(){
        $company_storage    = new App_Model_Member_MysqlCompanyCoreStorage();
        $company = $company_storage->getRowById($this->shop['s_c_id']);
        $data = array();
        if($company && $company['c_area']){
            $data = array(
                'townId'   => 0,
                'townName' => $company['c_area'],
            );
        }
        return $data;
    }
    private function _remove_post_quotes($type){

        $data['type'] = json_decode($type,true);
        $data['redPacket'] = false;
        foreach ($data['type'] as &$value){
            if($value['must']=='true'){
                $value['must'] = true;
                if($value['type']=='redPacket'){
                    $data['redPacket'] = true;
                }
                if($value['type']=='time'){
                    $value['name'] = $value['name']?$value['name']:'最新发布';
                }
                if($value['type']=='distance'){
                    $value['name'] = $value['name']?$value['name']:'最新发布';
                }
                if($value['type']=='reply'){
                    $value['name'] = $value['name']?$value['name']:'最新回复';
                }
                if($value['type']=='redPacket'){
                    $value['name'] = $value['name']?$value['name']:'红包福利';
                }
            }else{
                $value['must'] = false;
            }
        }
        $empty = true;
        foreach ($data['type'] as &$value){
            if($value['must']){
                $empty = false;
            }
        }
        if($empty){
            $data['type'] = array();
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

    
    private function _shop_index_post_tab($tpl_id){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_City_MysqlCityPostTabStorage($this->sid);
        $slide      = $slide_storage->fetchShortcutShowList($tpl_id);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['acpt_id'],
                    'title' => $val['acpt_name'],
                    'link' => $val['acpt_link'], # /pages/index/index?id=8
                    'img'  => isset($val['acpt_icon']) ? $this->dealImagePath($val['acpt_icon']) : '',
                    'type' => $val['acpt_link_type'],
                    'url'  => $this->get_link_by_type($val['acpt_link_type'],$val['acpt_link'],$val['acpt_name']),
                );
            }
        }
        return $data;
    }

    
    private function _index_post_category(){
        $categoryType = $this->request->getStrParam('type');
        $system = $this->request->getStrParam('system');
        $type = 1;  // 默认获取帖子分类
        if($categoryType=='service'){
            $type = 2;  // 定制版同城获取同城生活分类
        }
        $data = array();
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($type);
        if($shortcut){
            foreach($shortcut as $key => $val){
                if($val['acc_service_type']==2){
                    $link = '/pages/expressCheck/expressCheck?&&title='.$val['acc_title'];

                    if($this->appletType == 5 && $link){
                        $routeInfo = $this->getPageRoute($link);
                        $link = $routeInfo['route'];
                    }

                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $link,
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                }elseif($val['acc_service_type']==3){
                    $link = $val['acc_link_url'].'?title='.$val['acc_title'];

                    if($this->appletType == 5 && $link){
                        $routeInfo = $this->getPageRoute($link);
                        $link = $routeInfo['route'];
                    }

                    if($system && $system == 'ios'){
                        if($val['acc_link_url'] == "/subpages/memberCard/memberCard"){
                            $link = array(
                                'msg' => '十分抱歉，由于相关规范，暂时无法使用此功能'
                            );
                        }
                    }
                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $link,
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                }elseif($val['acc_service_type']==4){
                    $link = '/pages/informationDetail/informationDetail?id='.$val['acc_link_url'];

                    if($this->appletType == 5 && $link){
                        $routeInfo = $this->getPageRoute($link);
                        $link = $routeInfo['route'];
                    }

                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $link,
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                }elseif($val['acc_service_type']==104){
                    $link = '/'.$val['acc_link_url'];

                    if($this->appletType == 5 && $link){
                        $routeInfo = $this->getPageRoute($link);
                        $link = $routeInfo['route'];
                    }

                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $link,
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                } elseif($val['acc_service_type']==106){
                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $val['acc_link_url'],
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                }elseif($val['acc_service_type']==32){
                    //资讯分类列表
                    $link = '/pages/informationPage/informationPage?id='.$val['acc_link_url'].'&title=';

                    if($this->appletType == 5 && $link){
                        $routeInfo = $this->getPageRoute($link);
                        $link = $routeInfo['route'];
                    }

                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $link,
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                }elseif($val['acc_service_type'] == 34){
                    $category_model = new App_Model_City_MysqlCityPostCategoryStorage(0);
                    $category = $category_model->getRowById($val['acc_link_url']);
                    $name = $category['acc_title'];
                    //店铺分类列表
                    $link = '/pages/searchShop/searchShop?id='.$val['acc_link_url'].'&title='.$name;

                    if($this->appletType == 5 && $link){
                        $routeInfo = $this->getPageRoute($link);
                        $link = $routeInfo['route'];
                    }

                    $data[] = array(
                        'id'    => $val['acc_id'],
                        'name'  => $val['acc_title'],
                        'type'  => $val['acc_service_type'],
                        'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                        'link'  => $link,
                        'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                        'mustAddress'   => $val['acc_address_show'] ==1 ? true : false,
                        'allowComment'   => $val['acc_allow_comment'] ==1 ? true : false
                    );
                } else{
                    if($val['acc_isshow']){
                        $link = '/pages/postList/postList?id='.$val['acc_id'].'&title='.$val['acc_title'].'&price='.$val['acc_price'];

                        if($this->appletType == 5 && $link){
                            $routeInfo = $this->getPageRoute($link);
                            $link = $routeInfo['route'];
                        }

                        $data[] = array(
                            'id'    => $val['acc_id'],
                            'name'  => $val['acc_title'],
                            'type'  => $val['acc_service_type'],
                            'icon'  => isset($val['acc_img']) ? $this->dealImagePath($val['acc_img']) : '',
                            'link'  => $link,
                            'mustMobile'   => $val['acc_mobile_show'] ==1 ? true : false,
                            'mustAddress'  => $val['acc_address_show'] ==1 ? true : false,
                            'allowComment'  => $val['acc_allow_comment'] ==1 ? true : false
                        );
                    }
                }
            }
        }
//        if($this->sid==4546){
//            $kuaidi[] = array(
//                'id'    => '',
//                'name'  => '快递助手',
//                'icon'  => $this->dealImagePath('/public/wxapp/city/images/icon_kuaidi.png'),
//                'link'  => '/pages/expressCheck/expressCheck?&title=查快递'
//            );
//            $data = array_merge($kuaidi,$data);
//        }
        return $data;
    }

    
    private function _save_search_history($search, $type=1){
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
                'acsh_type'  => $type,
                'acsh_update_time' => time()
            );
            $history_model->insertValue($data);
        }
    }

    
    private function _fetch_post_img($pid){
        $data = array();
        $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($this->sid);
        $list = $attachment_model->fetchAllAttachment($pid);
        if($list){
            foreach ($list as $val){
                $data[] = $this->dealImagePath($val['aca_path']);
            }
        }
        return $data;
    }

    
    public function _post_like($pid){
        $uid = plum_app_user_islogin();
        $num = 0;
        $like_model = new App_Model_City_MysqlCityPostLikeStorage($this->sid);
        $row = $like_model->getLikeByMidPid($uid,$pid);
        if($row){
            $num = 1;
        }
        return $num;
    }

    
    private function _business_card_collection($cardId){
        $uid = plum_app_user_islogin();
        $num = '';
        if($cardId){
            $collection_model = new App_Model_Business_MysqlBusinessCardCollectionStorage($this->sid);
            $row = $collection_model->getRowByIdMid($cardId,$uid);
            if($row){
                $num = 1;
            }else{
                $num = 0;
            }
        }
        return $num;
    }

    
    public function _post_collection($pid){
        $uid = plum_app_user_islogin();
        $num = 0;
        $collection_model = new App_Model_City_MysqlCityPostCollectionStorage($this->sid);
        $row = $collection_model->getCollectionByMidPid($uid,$pid);
        if($row){
            $num = 1;
        }
        return $num;
    }
    
    public function postTopTimeAction(){

        $data = array();
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->sid);
        $where   = array();
        $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->sid);
        $sort = array('act_data' => 'ASC');
        $list = $cost_storage->getList($where, 0, 0, $sort);
        $info =array();
        if($list){
            foreach ($list as $val){
                $info['data'][] = array(
                    'id'     => $val['act_id'],
                    'name'   => $val['act_data'].'天',
                    'data'   => $val['act_data'],
                    'amount' => $val['act_cost']
                );
            }
        }else{
//            $topCfg = plum_parse_config('top_time','applet');
//            foreach ($topCfg as $key=>$value){
//                $info['data'][] = array(
//                    'id'     => $key,
//                    'name'   => $value['name'],
//                    'data'   => $value['date'],
//                    'amount' => $value['amount']
//                );
//            }
            $info['data'] = array();
        }
        $this->outputSuccess($info);
    }

    
    private function _post_comment($pid,$type,$listType = ''){
        $data = array();
        $comment_model = new App_Model_City_MysqlCityPostCommentStorage($this->sid);

//        if($listType == 'myComment'){
//            $verify = false;
//        }else{
//            $verify = true;
//        }
        $verify = true;
        $list = $comment_model->getCommentMember($pid,0,20,$verify);
        if($list){
            foreach ($list as $val){
                $data[] = $this->_post_comment_format($val,$type);
            }
        }
        return $data;
    }


    
    public function _get_recommend_post_list($cate){
        $where = array();
        $where[] = array('name'=>'acp_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'acp_deleted','oper'=>'=','value'=>0);    // 未被删除的
        $where[] = array('name'=>'acp_status','oper'=>'=','value'=>0);    // 未被封禁的
        $where[] = array('name'=>'acp_acc_id','oper'=>'=','value'=>$cate);

        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
        $count = $post_model->getCount($where);

        $data = array();
        $num = 4;
        $index = ($count - $num>0)?rand(0, $count - $num):0;
        $list = $post_model->getList($where, $index, $num, [], array());

        foreach ($list as $val){
            $data[] = array(
                'id'         => $val['acp_id'],
                'content'    => isset($val['acp_content']) ? ($index['aci_content_mobile_show'] ? plum_textarea_html_to_line($val['acp_content']) :plum_textarea_html_to_line(plum_strip_mobile($val['acp_content']))) : '',
                'time'       => date('m-d H:i',$val['acp_create_time']),
            );
        }

        return $data;
    }

    
    private function create_qrcode($id){
        $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
        $client_plugin   = new App_Plugin_Weixin_WxxcxClient($this->sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CITY_POST_DETAIL_PATH, 210);
        $updata = array('acp_qrcode'=>$url);
        $post_model->updateById($updata,$id);
        return $url;
    }

    
    public function receiveListAction(){
        $pid = $this->request->getIntParam('pid');
        $page = $this->request->getIntParam('page');
        $index = $this->count * $page;
        $receive_model = new App_Model_City_MysqlCityRedbagReceiveStorage($this->sid);
        $receiveList = $receive_model->getReceiveMemberList($pid, $index, $this->count);
        $info['data'] = array();
        if($receiveList){
            foreach($receiveList as $val){
                $info['data'][] = array(
                    'avatar' => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'nickname' => $val['m_nickname'],
                    'money' => $val['acrr_money']
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    
    private function _post_detail_format($val,$categoryList,$category=array(),$type='list',$mpjOpen = 0,$listType = ''){
        //查询当前店铺是否设置了帖子内容后缀提示

        $data = array();
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->sid);
        $index = $index_storage->findUpdateBySid(23);

        $card_model = new App_Model_Business_MysqlBusinessCardStorage($this->sid);
        if(!empty($val)){
            //如果开启名片夹  验证是否有名片和是否收藏了名片
            if($mpjOpen){
                $where_card = array();
                $where_card[] = array('name' => 'abc_s_id', 'oper' => '=', 'value' => $this->sid);
                $where_card[] = array('name' => 'abc_m_id', 'oper' => '=', 'value' => $val['m_id']);
                $where_card[] = array('name' => 'abc_closure', 'oper' => '=', 'value' => 0);//名片未被封禁
                $cardExist = $card_model->getRow($where_card);

                if($cardExist){
                    $cardId = intval($cardExist['abc_id']);
                    $cardCollection = $this->_business_card_collection($cardId);
                }else{
                    $cardId = '';
                    $cardCollection = 0;
                }
            }else{
                $cardCollection = 0;
                $cardId = '';
            }

            $data = array(
                'id'         => $val['acp_id'],
                'mid'        => $val['m_id'] ? $val['m_id'] : 0,
                'nickname'   => $val['m_nickname']?$val['m_nickname']:$this->shop['s_name'],
                'vipMark'    => $this->_get_member_vip_mark($val['m_id']),
                'mark'       => (!$val['m_id'] && $index['aci_manager_mark_open'])? $index['aci_manager_mark']:'',
                'avatar'     => $val['m_avatar']?$this->dealImagePath($val['m_avatar']):($val['m_id']?$this->dealImagePath('/public/wxapp/images/applet-avatar.png'):$this->dealImagePath($this->shop['s_logo'])),
                'content'    => isset($val['acp_content']) ? ($index['aci_content_mobile_show'] ? plum_textarea_html_to_line($val['acp_content']) :plum_textarea_html_to_line(plum_strip_mobile($val['acp_content']))) : '',
                'address'    => isset($val['acp_address']) && $val['acp_address'] ? $val['acp_address'] : '',
                'aliasAddr'  => isset($val['acp_alias_address']) && $val['acp_alias_address'] ? $val['acp_alias_address'] : '',
                'mobile'     => isset($val['acp_mobile']) && $val['acp_mobile'] ? $val['acp_mobile'] : '',
                'isShowPhone'=> intval($val['acp_mobile_show']) || (isset($categoryList[$val['acp_acc_id']]) && $categoryList[$val['acp_acc_id']]['acc_mobile_show']) ? 1 : 0,
                'msg'        => intval($val['acp_mobile_show']) || (isset($categoryList[$val['acp_acc_id']]) && $categoryList[$val['acp_acc_id']]['acc_mobile_show']) ? '' : '请联系客服获取联系方式',
                'lng'        => $val['acp_lng'],
                'lat'        => $val['acp_lat'],
                'istop'      => $val['acp_istop']>0 && isset($val['acp_istop_expiration']) && $val['acp_istop_expiration']>time() ? 1 : 0,
                'category'   => $val['acp_acc_id'],
                'categoryName' => isset($categoryList[$val['acp_acc_id']]) && $categoryList[$val['acp_acc_id']]['acc_title'] ? $categoryList[$val['acp_acc_id']]['acc_title'] : '',
                'secondCategoryId' => intval($val['acp_second_id']),
                'secondCategory' => isset($categoryList[$val['acp_second_id']]) && $categoryList[$val['acp_second_id']]['acc_title'] ? $categoryList[$val['acp_second_id']]['acc_title'] : '',
                'categoryPrice'=> isset($category['acc_price']) && $category['acc_price'] ? floatval($category['acc_price']) : 0,
//                'time'       => date('m',$val['acp_create_time']).'月'.date('d',$val['acp_create_time']).'　'.date('H:i',$val['acp_create_time']),
                'time'       => $this->_format_date($val['acp_create_time'],$type),
                'showNum'    => $val['acp_show_num'],
                'commentNum' => intval($val['acp_comment_num']),
                'likeNum'    => $val['acp_like_num'],
                'likeMember' => $this->_fetch_post_like($val['acp_id']),
                'isLike'     => $this->_post_like($val['acp_id']),
                'isCollection' => $this->_post_collection($val['acp_id']),
                'images'     => $this->_fetch_post_img($val['acp_id']),
                'comment'    => $this->_post_comment($val['acp_id'],$type,$listType),
                'isRedbag'   => $val['acp_isRedbag'] && $val['acp_redbag_balance']>0 ? intval($val['acp_isRedbag']) : 0,
                'qrcode'     => $val['acp_qrcode']?$this->dealImagePath($val['acp_qrcode'], true):'',
                'distance'   => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'m' : round($val['distance'],2).'km' ): 0,
                'postType'   => $val['acp_post_type'],
                'videoCover' => $val['acp_video_cover'],
                'articleTitle' => $val['acp_article_title'],
                'articleCover' => $val['acp_article_cover'],
                'articleContent' => $val['acp_article_content'],
                'allowComment'   => isset($categoryList[$val['acp_acc_id']]) && $categoryList[$val['acp_acc_id']]['acc_allow_comment']==1 ? true : false,
                'cardId'    => $cardId,
                'cardCollection' => $cardCollection,
                'postTip'      => empty($this->shop['s_post_tip'])?'':$this->shop['s_post_tip'],
                //'myLevel'   => $level,
                //'cityMember'   => ($val['m_level']>0 && time()>$val['m_level_long'])?1:0,   //发帖人是否是会员 1是
                'videoUrl' => $val['acp_video_url'] ? $val['acp_video_url'] : ''
            );

            $data['postShop'] = array();
            if($data['mid'] > 0){
                $shop_model = new App_Model_City_MysqlCityShopStorage($this->sid);
                $postShop = $shop_model->findShopByUserEnterShop($data['mid']);
                if($postShop){
                    $data['postShop'] = array(
                        'id'      => $postShop['acs_id'],
                        'esId'    => $postShop['acs_es_id'],
                        'name'    => $postShop['acs_name'],
                        'cover'   => $this->dealImagePath($postShop['acs_cover']),
                        'showNum' => $postShop['acs_show_num']
                    );
                    if($type == 'details'){
                        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                        $goodsNum = $goods_model->getGoodsCountBySidEsIdAction($this->sid, $postShop['acs_es_id']);
                        $data['postShop']['goodsNum'] = $goodsNum;
                    }
                }
            }

          
            $data['label'] = isset($val['acp_label']) && $val['acp_label'] ? $this->_format_label($val['acp_label'],$data['secondCategory']) : array();
            if($type == 'details'){
                $data['videoUrl'] = plum_is_url($val['acp_video_url'])?$val['acp_video_url']:$this->_get_tencent_video($val['acp_video_url']);
            }
        }
        return $data;
    }

    private function _get_member_vip_mark($mid){
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
        $member_card    = $offline_member->getList($where, 0, 0, array('om_update_time' => 'desc'));
        $level = [];

        if($member_card){//先查找是否买了会员卡
            $cardid = $member_card[0]['om_card_id'];
            $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
            $card   = $card_model->getRowById($cardid);
            $identity = intval($card['oc_identity']);
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }

        if(!$level){//取会员的等级
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member     = $member_storage->findMemberByIdSid($mid, $this->sid);
            $identity = $member['m_level'];
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level = $level_model->getRowById($identity);
        }
        return $level['ml_name']?$level['ml_name']:'';
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

    private function _get_tencent_video($vid=''){
        if(!$vid){
            $url = $this->request->getStrParam('videoUrl');
            $urlArr = parse_url($url);
            $arr_query = $this->_convert_url_query($urlArr['query']);
            if($arr_query['vid']){
                $vid  = $arr_query['vid'];
            }else{
                $content = Libs_Http_Client::get($url);
                $content_html_pattern = '/VIDEO_INFO = ({[^}]*.*?)(;.*?var |<\/script>)/s';
                //$content_html_pattern = '/vid: "(.*?)"/s';
                preg_match($content_html_pattern, $content, $video_matchs);
                $video_matchs[1] = preg_replace('/(\/\*.*\*\/)/s', '', $video_matchs[1]);
                $videoInfo = json_decode($video_matchs[1], true);
                if(!$videoInfo){
                    $content_html_pattern = '/vid: "(.*?)"/s';
                    preg_match($content_html_pattern, $video_matchs[1], $video_matchs);
                    $videoInfo['vid'] = $video_matchs[1];
                }
                $vid  = $videoInfo['vid'];
            }
            if(!$vid){
                $pathArr = explode('/', $urlArr['path']);
                $vid = str_replace('.html','',$pathArr[count($pathArr)-1]);
            }
        }
        $params = array(
            'isHLS' => false,
            'charge' => 0,
            'vid' => $vid,
            'defaultfmt' => 'auto',
            'defn' => 'shd',
            'defnpayver' => 1,
            'otype' => 'json',
            'platform' => 11001,
            'sdtfrom' => 'v1103',
            'host' => 'v.qq.com'
        );
        $baseUrl = 'http://h5vv.video.qq.com/getinfo?';
        $paramsArr = [];
        foreach ($params as $key => $val){
            $paramsArr[] = $key.'='.$val;
        }
        $paramsStr = join('&', $paramsArr);

        $content = Libs_Http_Client::get($baseUrl.$paramsStr);
        $content_html_pattern = '/=(.*);/s';
        preg_match($content_html_pattern, $content, $info_matchs);
        $infoInfo = json_decode($info_matchs[1], true);
        $fvkey = $infoInfo['vl']['vi'][0]['fvkey'];
        $fn = $infoInfo['vl']['vi'][0]['fn'];
        $self_host = $infoInfo['vl']['vi'][0]['ul']['ui'][0]['url'];
        if($self_host && $fn && $fvkey){
            $real_url = $self_host.$fn.'?vkey='.$fvkey;

            //去除链接中的ip地址
            $pattern = '/(\d+)\.(\d+)\.(\d+)\.(\d+)/';
            preg_match($pattern,$real_url,$out);
            if($out){
                $str = $out[0].'/';
                $real_url = str_replace($str,'',$real_url);
            }

            return $real_url;
        }
    }

    private function _convert_url_query($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    
    private function _format_date($createTime,$type){
        $now = time();
        if($this->sid==10418){  // 加拿大店铺有时差
            $createTime = $createTime-54000;
            $now = time()-54000;
        }
        if($type == 'list'){
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

    
    private function _fetch_post_like($pid){
        $like_model = new App_Model_City_MysqlCityPostLikeStorage($this->sid);
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

    
    private function _post_comment_format($val,$type=''){
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->sid);
        $index = $index_storage->findUpdateBySid(23);
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['acc_id'],
                'comment'       => isset($val['acc_comment']) ? plum_strip_sql_quote($type=='list' && mb_strlen($val['acc_comment'])>50 ? mb_substr($val['acc_comment'],0,50).'...' : $val['acc_comment']) : '',
                'mid'           => $val['acc_m_id'],
                'mark'          => (!$val['acc_m_id'] && $index['aci_manager_mark_open'])? $index['aci_manager_mark']:'',
                'nickname'      => $val['m_nickname']?$val['m_nickname']:$this->shop['s_name'],
                'replyMid'      => $val['acc_reply_mid'] ? $val['acc_reply_mid'] : 0,
                'replyMark'     => ($val['acc_reply_mid']==-1 && $index['aci_manager_mark_open'])? $index['aci_manager_mark']:'',
                'replyNickname' => isset($val['acc_reply_mid']) && isset($val['rm_nickname']) ? $val['rm_nickname'] : $this->shop['s_name']
            );
        }
        return $data;
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
        if($tcRow['tc_isopen']){
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

    
    

    
    private function _shop_details_format($val, $translate=false,$collection=false,$goods=false){
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['acs_id'],
                'name'          => $val['acs_name'],
                'mid'           => intval($val['acs_m_id']),
                'esId'          => intval($val['acs_es_id']),
                'logo'          => isset($val['acs_img']) && $val['acs_img'] ? $this->dealImagePath($val['acs_img']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_45_45.png'),
                'cover'         => isset($val['acs_cover']) && $val['acs_cover'] ? $this->dealImagePath($val['acs_cover']) : $this->dealImagePath('/public/manage/img/zhanwei/zw_fxb_75_36.png'),
                'code'          => isset($val['acs_code_cover']) && $val['acs_code_cover'] ? array($this->dealImagePath($val['acs_code_cover'])) : '',
                'label'         => isset($val['acs_label']) ? preg_split("/[\s,]+/",$val['acs_label']) : '' ,
                'labelType'     => $val['acs_label_type'],
                'brief'         => isset($val['acs_brief']) ? $val['acs_brief'] : '',
                'openTime'      => $val['acs_open_time'],
                'mobile'        => $val['acs_mobile'],
                'address'       => $val['acs_address'],
                'lng'           => $val['acs_lng'],
                'lat'           => $val['acs_lat'],
                'distance'      => isset($val['distance']) ? ($val['distance']<1 ? floor(1000*$val['distance']).'m' : round($val['distance'],2).'km' ): 0,
                'showNum'       => $this->number_format($val['acs_show_num']+1),
                'content'       => plum_parse_img_path_new($val['acs_brief'].$val['acs_content']),
                'stars'         => $val['acs_score']>0 && $val['acs_total_score']>0 ?  round((($val['acs_score']/$val['acs_total_score'])*5),1) : 5,   // 星级
                'isCollection'  => $collection ? 1 : 0,    //是否收藏过
                'comment'       => $this->_post_number($val['acs_id']),
                'qrcode'        => isset($val['acs_qrcode']) && $val['acs_qrcode'] ? $this->dealImagePath($val['acs_qrcode'],true) : '',
                'payQrcode'     => isset($val['acs_pay_qrcode']) && $val['acs_pay_qrcode'] ? $this->dealImagePath($val['acs_pay_qrcode'],true) : '',
                'vrurl'         => $val['acs_vr_url'] ? $this->_judge_vrurl($val['acs_vr_url']) : '',
                'notice'        => $this->_get_notice_list($val['acs_es_id']),
//                'vrurl'         => '123456',
                'goodsStyle'    => $val['es_goods_style'] > 0 ? intval($val['es_goods_style']) : 1,
                'recommendShops' => array(),
                'listLabel'     => $val['acs_list_label'] ? $val['acs_list_label'] : '',
                'show_num'  => $val['acs_show_num'] ? ($val['acs_show_num'] / 10000 >= 1 ? round($val['acs_show_num'] / 10000 , 1).'万' : $val['acs_show_num']) : 0 ,     //人气（浏览量）
                'showComment'    => intval($this->shop['s_shop_comment']),
                'openStatus'     => $val['openStatus']
            );


            if($val['acs_recommend_shop']){
                $data['recommendShops'] = $this->_recommend_shops_info($val['acs_recommend_shop']);
            }


            $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $shop     = $shop_model->getRowById($val['acs_es_id']);
            $data['isbuy'] = intval($shop['es_isbuy']);
            $data['limitOpen'] = intval($shop['es_limit_open']);
            $data['groupOpen'] = intval($shop['es_group_open']);
            $data['bargainOpen'] = intval($shop['es_bargain_open']);
            if($val['es_hand_close'] == 0){
                if(isset($val['openStatus'])){
                    $data['openNote'] = $data['openStatus'] == 1 ? '营业中' : '已打烊';
                }else{
                    $isOpen = 0;
                    $openTimeArr = explode('-',$val['acs_open_time']);
                    if($this->sid==10418){   //YEGer加拿大店铺  加拿大时间比北京慢15小时
                        $timeNow = time()-54000;
                        $openTime = strtotime(date('Y-m-d',$timeNow).' '.$openTimeArr[0]);
                        $closeTime = strtotime(date('Y-m-d',$timeNow).' '.$openTimeArr[1]);
                    }else{
                        $timeNow = time();
                        $openTime = strtotime($openTimeArr[0]);
                        $closeTime = strtotime($openTimeArr[1]);
                    }
                    if ($openTime >= $closeTime) {
                        //$closeTime = $closeTime + 86400;
                        //获得当天0点时间戳
                        $timeStep_0 = strtotime(date('Y-m-d',$timeNow));
                        //获得当天24点时间戳
                        $timeStep_24 = strtotime(date('Y-m-d',$timeNow)) + 86399;
                        if(($openTime <= $timeNow && $timeNow <= $timeStep_24) || ($timeStep_0 <= $timeNow) && $timeNow <= $closeTime){
                            $isOpen = 1;
                        }
                    }else{
                        if($openTime <= $timeNow && $timeNow <= $closeTime){
                            $isOpen = 1;
                        }
                    }
                    if (!$isOpen) {
                        $data['openStatus']  = 2;
                        $data['openNote'] = '已打烊';
                    }else{
                        $data['openStatus']  = 1;
                        $data['openNote'] = '营业中';
                    }
                }
            }else{
                $data['openStatus']  = 2;
                $data['openNote'] = '已打烊';
            }

            if(!$data['code']){
                $data['code'] = array($data['qrcode']);
            }
            if($translate){
                $addressList = json_decode($val['acs_translate_address']);
                $data['addressList'] = array();
                foreach($addressList as $key=>$value){
                    if(json_decode($val['acs_translate_mobile'])[$key] || json_decode($val['acs_translate_address'])[$key]){
                        $item = array(
                            'name'    => json_decode($val['acs_translate_contacter'])[$key],
                            'mobile'  => json_decode($val['acs_translate_mobile'])[$key],
                            'address' => json_decode($val['acs_translate_address'])[$key],
                            'lng'     => json_decode($val['acs_translate_lng'])[$key],
                            'lat'     => json_decode($val['acs_translate_lat'])[$key]
                        );
                        array_push($data['addressList'], $item);
                    }
                }
                if(!$data['addressList']){
                    $item = array(
                        'name'    => '联系人',
                        'mobile'  => $val['acs_mobile'],
                        'address' => $val['acs_address'],
                        'lng'     => $val['acs_lng'],
                        'lat'     => $val['acs_lat']
                    );
                    $data['addressList'][0] = $item;
                }
            }
            //判断当前当前店铺，当前会员是否可认领
            $uid = plum_app_user_islogin();
            $shop_model = new App_Model_City_MysqlCityShopStorage($this->sid);
            $hadShop = $shop_model->findShopByUserEnterShop($uid);
            $data['canClaim'] = 0;
            $data['claimId'] = 0;
            if(!$hadShop && !$val['acs_m_id']){
                $data['canClaim'] = 1;
                $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->sid);
                $claim = $claim_model->findClaimByMidShop($uid, $val['acs_id']);
                $data['claimId'] = $claim?$claim['acsc_id']:0;
            }

            //获得同城店铺商品信息
            if($goods){
                $data['goods'] = $this->_get_city_shop_goods_list($val['acs_es_id']);
                $data['category'] = $this->_get_city_shop_cate_list($val['acs_es_id']);
            }
            $data['newCategory'] = $this->_get_city_shop_cate_list_new($val['acs_es_id']);
            if(intval($val['acs_s_id']) == 4546){
                $data['code'] = '';
            }

            // 判断店铺当前营销活动
            $data['activityList'] = array();
            //优惠券
            if($val['acs_es_id'] > 0){
                $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
                $coupon = $coupon_model->fetchValidList($this->sid,0,1, array(), $val['acs_es_id']);
                if($coupon){
                    $data['activityList'][] = array(
                        'type'  => 1,
                        'title' => $coupon[0]['cl_name']
                    );
                }
                //秒杀
                $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->sid);
                $limit = $act_model->getAllRunningAct($val['acs_es_id']);
                if($limit){
                    $data['activityList'][] = array(
                        'type'  => 2,
                        'title' => $limit[0]['la_name']
                    );
                }
                //拼团
                $group_model  = new App_Model_Group_MysqlBuyStorage($this->sid);
                $group = $group_model->getCurrentListByType(1,0,1,0,'', $val['acs_es_id']);
                if($group){
                    $data['activityList'][] = array(
                        'type'  => 3,
                        'title' => $group[0]['g_name']
                    );
                }
                //砍价
                $timeNow = time();
                $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
                $where[] = array('name'=>'ba_s_id','oper'=>'=','value'=> $this->sid);
                $where[] = array('name'=>'ba_es_id','oper'=>'=','value'=> $val['acs_es_id']);
                $where[] = array('name'=>'ba_deleted','oper'=>'=','value'=> 0);
                $where[] = array('name'=>'ba_start_time','oper'=>'<','value'=> $timeNow);
                $where[] = array('name'=>'ba_end_time','oper'=>'>','value'=> $timeNow);
                $bargain = $bargain_model->getActivityList($where,0,1,array());
                if($bargain){
                    $data['activityList'][] = array(
                        'type'  => 4,
                        'title' => $bargain[0]['g_name']
                    );
                }
            }
        }
        return $data;
    }

    
    private function _recommend_shops_info($sids = ''){
        $shopsInfo = array();
        $sidArr = json_decode($sids,1);

        if(!empty($sidArr)){
            $where = array();
            $where[] = array('name' => 'acs_id', 'oper' => 'in', 'value' => $sidArr);
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
            $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2); //通过审核
            $where[] = array('name' => 'acs_list_show', 'oper' => '=', 'value' => 1); //显示
            $shop_model = new App_Model_City_MysqlCityShopStorage($this->sid);
            $shopsList = $shop_model->getList($where,0,0,array(),array('acs_id','acs_name','acs_cover','acs_list_label'));
            if($shopsList){
                foreach ($shopsList as $shop){
                    $shopsInfo[] = array(
                        'id'   => intval($shop['acs_id']),
                        'name'  => $shop['acs_name'],
                        'listLabel' => $shop['acs_list_label'] ? $shop['acs_list_label'] : '',
                        'cover'  => $this->dealImagePath($shop['acs_cover']),
                    );
                }
            }
        }
        return $shopsInfo;
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

    
    private function _get_city_shop_cate_list($esId = 0){
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage($esId);
        $cateList = $category_model->getListBySid();
        $data = array();
        if($cateList){
            foreach($cateList as $val){
                $data[] = array(
                    'id'   => $val['esgc_id'],
                    'name' => $val['esgc_name'],
                    'cover' => $val['esgc_logo'] ? $this->dealImagePath($val['esgc_logo']) : ''
                );
            }
        }
        return $data;
    }

    
    private function _get_city_shop_cate_list_new($esId = 0){
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage($esId);
        $cateList = $category_model->getListBySid();
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getRowByIdMemberExtra($esId);
        $cfg_model = new App_Model_Community_MysqlCommunityFreeCfgStorage($this->sid);
        $row = $cfg_model->findupdateByEsId($esId);

        $data = array();

        //获得营销工具启用情况
        $pluginArr = [];
        $limitOpen = 1;
        $groupOpen = 1;
        $bargainOpen = 1;
        $queueOpen = 1;
        $freeOpen = 1;
        $plugin_model = new App_Model_Entershop_MysqlEnterShopPluginOpenStorage($this->sid);
        $plugin_row = $plugin_model->findUpdateBySidEsId($esId);
        if($plugin_row){
            $pluginArr = json_decode($plugin_row['espo_plugin'],1);
        }
        foreach ($pluginArr as $plugin){
            if($plugin['id'] == 'wms' && $plugin['open'] == 0){
                $limitOpen = 0;
            }
            if($plugin['id'] == 'wpt' && $plugin['open'] == 0){
                $groupOpen = 0;
            }
            if($plugin['id'] == 'wkj' && $plugin['open'] == 0){
                $bargainOpen = 0;
            }
            if($plugin['id'] == 'mfyy' && $plugin['open'] == 0){
                $freeOpen = 0;
            }
        }



        if($shop['es_limit_open'] && $limitOpen){
            $data[] = array(
                'id'   => 'limit',
                'name' => '秒杀活动',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/limit-icon.png')
            );
        }

        if($shop['es_group_open'] && $groupOpen){
            $data[] = array(
                'id'   => 'group',
                'name' => '拼团活动',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/group-icon.png')
            );
        }

        if($shop['es_bargain_open'] && $bargainOpen){
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

        if($row['acfc_open'] && $freeOpen){
            $data[] = array(
                'id'   => 'free',
                'name' => '预约',
                'cover' => $this->dealImagePath('/public/wxapp/store/images/free-icon.png')
            );
        }

        if($shop['es_queue_open'] && $queueOpen){
            $data[] = array(
                'id'   => 'queue',
                'name' => '排号',
                'cover' => $this->dealImagePath('/public/wxapp/meal/images/queue.png')
            );
        }

        if($cateList){
            foreach($cateList as $val){
                $data[] = array(
                    'id'   => $val['esgc_id'],
                    'name' => $val['esgc_name'],
                    'cover' => $val['esgc_logo'] ? $this->dealImagePath($val['esgc_logo']) : ''
                );
            }
        }
        return $data;
    }

    
    private function _get_city_shop_goods_list($esId = 0){
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage($this->sid);
        $data = array();
        if($esId){
            $sort = array('g_is_top'=>'DESC','g_weight'=>'DESC','g_update_time'=>'DESC');
            $goods    = $goods_model->fetchEnterShopGoodsList($esId, 0, 10, 0, $sort,0,array());
        }
        if($goods){
            foreach($goods as $val){
                $data[] = $this->_format_goods_details($val,false,'mall');
            }
        }
        return $data;
    }

    
    private function _statistics($type, $num){
        //获取配置信息
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $cfg        = $applet_cfg->findShopCfg();
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->sid);
        $tpl = $tpl_model->findUpdateBySid();
        if($type == 'browse'){
            $set = array('aci_browse_num' => ($tpl['aci_browse_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
        if($type == 'issue'){
            $set = array('aci_issue_num' => ($tpl['aci_issue_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
        if($type == 'shop'){
            $set = array('aci_shop_num' => ($tpl['aci_shop_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
        if($type == 'share'){
            $set = array('aci_share_num' => ($tpl['aci_share_num'] + $num));
            $tpl_model->findUpdateBySid(23, $set);
        }
    }

    
    public function addShareAction(){
        $pid = $this->request->getIntParam('pid');
        $this->_statistics('share', 1);
        if($pid){
            $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
            $ret = $post_model->addReducePostNum($pid,'share','add');
            if($ret){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '统计成功'
                );
                $this->outputSuccess($info);
                return;
            }else{
                $this->outputError('统计失败');
                return;
            }
        }
        $info['data'] = array(
            'result' => true,
            'msg'    => '统计成功'
        );
        $this->outputSuccess($info);
    }

    
    private function _shop_comment_format($val){
        $data = array();
        if(!empty($val)){
            $data = array(
                'id'            => $val['acs_id'],
                'comment'       => isset($val['acs_comment']) ? plum_strip_sql_quote($val['acs_comment']) : '',
                'images'        => json_decode($val['acs_comment_img'],true),
                'stars'         => $val['acs_stars'],
                'mid'           => $val['acs_m_id'],
                'nickname'      => $val['m_nickname'],
                'avatar'        => $val['m_avatar'] ? $val['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'replyMid'      => $val['acs_reply_mid'] > 0 ? $val['acs_reply_mid'] : 0,
                'replyNickname' => isset($val['acs_reply_mid']) && isset($val['rm_nickname']) ? $val['rm_nickname'] : '',
                'date'          => date('Y-m-d',$val['acs_time'])
            );
        }
        return $data;
    }


    
    private function _get_shortcut(){
        $cfg_model = new App_Model_City_MysqlCityShopListCfgStorage($this->sid);
        $cfg = $cfg_model->findUpdateBySid();
        $data = array();
        $showShortcut = $cfg && $cfg['acsc_shortcut'] == 1 ? 1 : 0;
        if($showShortcut){
            $shortcut_storage   = new App_Model_Shop_MysqlShopShortcutStorage($this->sid);
            $shortcut   = $shortcut_storage->fetchShortcutShowList(-3);
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
        }else{
            $categoryType = $this->request->getStrParam('type');  // type=service同城， type=nearby 附近商家

            $type = 1;
            if($categoryType){
                if($categoryType=='service'){
                    $type =0;
                }elseif ($categoryType=='nearby'){
                    $type = 0;
                }
            }
            $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
            $where = array();
            $where[] = array('name'=>'acc_deleted','oper'=>'=','value'=>0);
            $where[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->sid);
            $shortcut = $shortcut_model->fetchShortcutShowList(2);

            if($shortcut) {
                foreach ($shortcut as $key => $val) {
                    if ($val['acc_service_type'] == 1) {      //便民信息不再列出
                        $data[] = array(
                            'name' => $val['acc_title'],
                            'icon' => $val['acc_img'] ? $this->dealImagePath($val['acc_img']) : $this->dealImagePath('/public/manage/img/zhanwei/fenleinav.png'),
                            'link' => $val['acc_id'],
                            'type' => 34,
                            'url'  => $this->get_link_by_type(34,$val['acc_id'],$val['acc_title'])
                        );
                    }
                }
            }
        }
        return $data;
    }

    
    private function _shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->sid);
        $sort  = array('acs_sort'=>'DESC','acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_expire_time', 'oper' => '>', 'value' => time()); //入驻未过期
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2); //审核通过
        $where[] = array('name' => 'acs_list_show', 'oper' => '=', 'value' => 1); //显示
        $shop    = $shop_storage->getList($where,0,10,$sort);
        $data = array();
        if($shop){
            foreach ($shop as $val){
                $data[] = array(
                    'id'        => $val['acs_id'],
                    'name'      => $val['acs_name'].'入驻本平台！',
                );
            }
        }
        return $data;
    }
    
    private function _recommend_shop(){
        $recommend_model      = new App_Model_City_MysqlCityRecommendStorage($this->sid);
        $where     = array();
        $where[]   = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->sid);
        $sort      = array('acr_sort'=>'ASC');
        $recommend = $recommend_model->fetchRecommendShowListShop($where,0,0,$sort);
        $data = array();
        foreach($recommend as $key => $val){
            $data[] = array(
                'id'           => $val['acr_id'] ,
                'shopId'       => $val['acr_link'],
//                'cover'        => $this->dealImagePath($val['acr_cover']),
                'cover'        => $val['acs_img'] ? $this->dealImagePath($val['acs_img']) : $this->dealImagePath($val['acr_cover']),
//                'name'         => $val['acr_name'],
                'name'         => $val['acs_name'],
            );
        }
        return $data;
    }
    
     private function _post_number($acs_acs_id){
         $comment_model=new App_Model_City_MysqlCityShopCommentStorage($this->sid);
         $where = array();
         $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->sid);
         $where[] = array('name' => 'acs_acs_id', 'oper' => '=', 'value' => $acs_acs_id);
         $comment = $comment_model->getCount($where);
         return $comment;
        }
    
    private function _category_List(){
        $categoryType = $this->request->getStrParam('type');  // type=service同城， type=nearby 附近商家

        $type = 1;
        if($categoryType){
            if($categoryType=='service'){
                $type =0;
            }elseif ($categoryType=='nearby'){
                $type = 0;
            }
        }
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
        $where = array();
        $where[] = array('name'=>'acc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->sid);
        $shortcut = $shortcut_model->fetchShortcutShowList(2);
        $info = array();
        if($shortcut) {
            foreach ($shortcut as $key => $val) {
                if ($val['acc_service_type'] == 1) {      //便民信息不再列出
                    $info[] = array(
                        'id' => $val['acc_id'],
                        'name' => $val['acc_title'],
                        'icon' => $val['acc_img'] ? $this->dealImagePath($val['acc_img']) : $this->dealImagePath('/public/manage/img/zhanwei/fenleinav.png'),
                        'price' => $val['acc_price'],
                        'biref' => !empty($val['acc_brief_cover'])?$this->dealImagePath($val['acc_brief_cover']):''
                        //'cateImg' => !empty($val['acc_brief_cover'])?$this->dealImagePath($val['acc_brief_cover']):''
                    );
                }
            }
        }
        return $info;
    }


    
    public function fetchPostCategoryAction(){
        $oneCategory = $this->request->getIntParam('oneCategory');    //帖子一级分类
        if($oneCategory){
            $category_model = new App_Model_City_MysqlCityPostCategoryStorage($this->sid);
            $category = $category_model->getRowByIdSid($oneCategory,$this->sid);
            if($category){
                $info = array();
                $info['data']['one'] = array(
                    'id'    => $category['acc_id'],
                    'name'  => $category['acc_title'],
                    'icon'  => isset($category['acc_img']) ? $this->dealImagePath($category['acc_img']) : '',
                    'link'  => '/pages/expressCheck/expressCheck?&&title='.$category['acc_title'],
                    'mustMobile'    => $category['acc_mobile_show'] ==1 ? true : false,
                    'mustAddress'   => $category['acc_address_show'] ==1 ? true : false,
                    'allowComment'  => $category['acc_allow_comment'] ==1 ? true : false,
                );
                $secondCategory = $category_model->fetchCategorySecondListByOne($oneCategory);
                if($secondCategory){
                    foreach ($secondCategory as $val){
                        $info['data']['second'][] = array(
                            'id'    => $val['acc_id'],
                            'name'  => $val['acc_title'],
                            'icon'  => $val['acc_img'] ? $this->dealImagePath($val['acc_img']) : $this->dealImagePath('/public/manage/img/zhanwei/fenleinav.png'),
                            'price' => $val['acc_price'],
                        );
                    }
                }
                $this->outputSuccess($info);
            }else{
                $this->outputError('暂无分类信息');
            }
        }else{
            $this->outputError('参数有误，请重试');
        }
    }

    
    
    
    private function _shop_kind_list(){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->sid);
        $kind_list = $kind_model->fetchKindShowList(0);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'name'  => $val['amk_name'],
                    //'sign'  => $val['amk_sign'],
                    'type'  => intval($val['amk_goods_list']),
                    'link'  => $val['amk_link'],
                    //'img'   => $val['amk_img'] ? $this->dealImagePath($val['amk_img']) : '',
                    'goods' => $this->_goods_list_by_group($val['amk_link']),
                );
            }
        }
        return $data;
    }

    
    private function _goods_list_by_group($kind){
        $match_storage = new App_Model_Goods_MysqlGroupMatchStorage($this->sid);

        //$goods_list = $match_storage->fetchGoodsList($kind,0,6);
        $goods_list = $match_storage->fetchEntershopGoodsList($kind,0,6);

        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = $this->_format_goods_details($val,false,'mall');
            }
        }
        return $data;
    }

    
    private function _format_goods_details($goods,$detail=false,$listType=''){
        if($goods){
            $data = array(
                'id'         => intval($goods['g_id']),
                'name'       => $goods['g_name'],
                'cover'      => isset($goods['g_cover']) ? $this->dealImagePath($goods['g_cover']) : '',
                'price'      => floatval($goods['g_price']),
                'vipPrice'   => $this->_get_vip_price($goods),
                'points'     => $goods['g_points'],
                'unit'       => $goods['g_unit'],
                'oriPrice'   => floatval($goods['g_ori_price']),
                'brief'      => isset($goods['g_brief']) ? $goods['g_brief'] : '',
                'stock'      => $goods['g_stock'],
                'stockShow'  => intval($goods['g_stock_show']),
                'sold'       => $goods['g_sold'],
                'soldShow'   => intval($goods['g_sold_show']),
                'expfeeShow' => intval($goods['g_expfee_show']),
                'freight'    => $goods['g_unified_fee'],
                'hasFormat'  => false,
                'isVip'      => $this->member['m_level_long']>time()?1:0,
                'video'      => $goods['g_video_url'] ? $goods['g_video_url']:'',
                'isDiscuss'  => intval($goods['g_is_discuss']),
                'discussInfo'=> isset($goods['g_discuss_info']) ? $goods['g_discuss_info'] : '',
                'showVipList'=> $goods['g_show_vip'],
            );
            if($goods['g_type'] == 4){
                $data['type'] = 1;
            }
            if($goods['g_type'] == 5){
                $data['type'] = 2;
            }
            if($goods['g_es_id'] && $listType == 'mall'){
                //同城商城  获得会员价
                if($goods['g_is_discuss'] != 1){
                    $uid = plum_app_user_islogin();
                    $trade_helper = new App_Helper_Trade($this->sid);
                    $data['price'] = $trade_helper::getGoodsVipPirce($data['price'],$this->sid,$data['id'],0,$uid);
                    $vipInfo = App_Helper_Trade::getGoodsVipPirce($goods['g_price'], $this->sid, $goods['g_id'], '',$this->member['m_id'],1);
                    $data['isVip'] = $vipInfo['isVip'];
                }
            }

            // 是否获取商品详情
            if($detail){
                if($goods['g_es_id']){//如果是门店商品 获得门店信息
                    $shop =  $this->_get_shop_info($goods['g_es_id']);
                    $data['shop'] = $shop;
                }else{
                    $data['shop'] = array();
                }

                $data['freight'] = $this->_get_postFee_show($goods);

                $data['parameter'] = plum_parse_img_path($goods['g_parameter']);
                $data['detail'] = plum_parse_img_path($goods['g_detail']);
                $data['slide']  = $this->_goods_slide($goods['g_id']);
                $data['format'] = $this->_goods_format($goods['g_id']);
                $data['vrurl']  = $goods['g_vr_url'] ? $this->_judge_vrurl($goods['g_vr_url']) :'';
                if(!empty($data['format']) && $data['format']){
                    $data['hasFormat'] = true;
                }
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

            //$data['isCollect'] = $this->_is_collection($goods['g_id'], 2);
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

    //格式化店铺信息
    private function _get_shop_info($esId){
        $shop_model  = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
        $shop     = $shop_model->getCityShopDetail($esId);
        return array(
            'id'        => intval($shop['acs_id']),
            'esId'      => intval($shop['es_id']),
            'name'      => $shop['acs_name'],
            'stars'     => $shop['acs_score']>0 && $shop['acs_total_score']>0 ?  round((($shop['acs_score']/$shop['acs_total_score'])*5),1) : 5,   // 星级
            'address'   => $shop['acs_address'],
            'lng'       => $shop['acs_lng'],
            'lat'       => $shop['acs_lat'],
            'mobile'    => $shop['acs_mobile'],

        );
    }

    
    private function _recommend_goods_list($recOpen){
        $data = array();
//        if($recOpen){
            $recommend_model = new App_Model_City_MysqlCityMallRecommendStorage($this->sid);
            $recommend_list = $recommend_model->fetchRecommendShowList();
            if($recommend_list){
                foreach ($recommend_list as $val){
                    $data[] = array(
                        //'name'  => $val['amr_name'],
                        //'price' => $val['amr_price'],
                        'img'   => $this->dealImagePath($val['acmr_img']),
                        'link'  => $val['acmr_link'],
                        'url'   => $this->get_link_by_type($val['acmr_link_type'],$val['acmr_link'],'')
                        //'brief' => $val['amr_brief']
                    );
                }
            }
//        }
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
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
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
                }else{
                    
                    $list[] = array(
                        'id'        => $value['cl_id'],
                        'name'      => $value['cl_name'],
                        'value'     => $value['cl_face_val'],
                        'limit'     => $value['cl_use_limit'],
                        'count'     => $value['cl_count'],
                        'receive'   => $value['cl_had_receive'],
                        'desc'      => $value['cl_use_desc'],
                        'start'     => date('Y-m-d', $value['cl_start_time']),
                        'end'       => date('Y-m-d', $value['cl_end_time']),
                    );
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
                'searchTip'     => $tpl['amu_search_tip'] ? $tpl['amu_search_tip'] : '请输入商品',
                'recOpen'       => intval($tpl['amu_recommend_open'])
            );
        }
        return $data;
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

}

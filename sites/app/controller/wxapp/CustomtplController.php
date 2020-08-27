<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/24
 * Time: 上午11：35
 * 通用模板
 */

class App_Controller_Wxapp_CustomtplController extends App_Controller_Wxapp_InitController
{
    const PROMOTION_TOOL_KEY    = 'mbfz';  // 模板分组功能
    public function __construct()
    {
        parent::__construct();
        $this->setLayout('default.tpl');
    }

    public function settingAction(){
        $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
        $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $template = $template_model->getRow($where);
        $data = json_decode($template['act_data'], true);
        $chooseCommunity = false;
        foreach ($data as $key => $val){
            //对不同的组件做处理
            if(method_exists($this, '_deal_'.$val['type'].'_data')){
                $func = '_deal_'.$val['type'].'_data';
                $data[$key] = $this->$func($val);
            }else{
                switch ($val['type']){
                    case 'chooseCommunity':

                        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36){
                            $chooseCommunity = true;
                        }else{
                            $chooseCommunity = false;
                            unset($data[$key]);
                        }

                       // if(!isset($val['indexShow'])){
                       //     $data[$key]['indexShow'] = true;
                       // }

                        //查找【选择小区】组件属性是否完整 若不完整则添加默认值
                        if($chooseCommunity){
                            $extra_cfg = plum_parse_config('extra', 'customtpl/customtpl-32');
                            $component_cfg = $extra_cfg['chooseCommunity'];
                            $component_cfg_keys = array_keys($component_cfg);
                            foreach ($component_cfg_keys as $keys_k => $keys_v){
                                if(!isset($val[$keys_v])){
                                    $data[$key][$keys_v] = $component_cfg[$keys_v];
                                }
                            }
                        }


                        break;
                }
            }
        }

        if(($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36) && $chooseCommunity == false ){
            $insert = [
                'type'       => 'chooseCommunity',
                'typeText'   => '选择小区',
                'indexShow'  => true,
                'icon'       => '',
            ];
            if(empty($data)){
                $data[] = $insert;
            }else{
                array_unshift($data,$insert);
            }
        }

        $this->_get_list_for_select();         // 获取配置链接
        $this->_shop_information();            // 获取通用资讯文章选择
        $this->_shop_kind_list_for_select();   // 店铺的所有二级分类
        $this->_shop_top_goods_list();         // 店铺选择推荐商品
        $this->_shop_appointment_goods_list(); // 付费预约商品
        $this->_shop_service_category();       // 获取企业服务分类
        $this->_shop_service_article();        // 获取企业产品服务
        $this->_shop_information_category();   // 获取资讯分类
        $this->goodsGroup();                   // 获取商品分组
        $this->_game_category();               // 获取游戏分类
        $this->_get_game_for_select();         // 获取游戏列表
        $this->_get_post_type();               // 获取同城帖子tab标签
        $this->_get_post_category();           // 获取同城帖子分类
        $this->_meal_shop_info();              // 获取餐饮首页配置信息
        $this->_hotel_shop_info();             // 获取酒店首页配置信息
        $this->_get_index_tab();               // 获取二手车首页tab标签
        $this->_get_car_resource();            // 获取二手车全部车源
        $this->_get_car_shop_category();       // 获取二手车服务商分类
        $this->_get_quotation_list();          // 知识付费获取经典语录列表
        $this->_get_knowpay_index();           // 获取知识付费首页配置
        $this->_get_job_index();               // 获取内推首页配置
        $this->_show_category(1, 1);            // 商品分类
        $this->_show_category(2, 1);             // 专家分类
        $this->_show_expert_list();              // 专家列表
        $this->_get_position_list();             // 职位列表
        $this->_get_jump_list();                 // 获得跳转小程序
        $this->_group_list_for_select();         // 获取拼团商品列表
        $this->_limit_list_for_select();         // 获取秒杀商品列表
        $this->_bargain_list_for_select();       // 获取砍价商品列表
        $this->_shop_list_for_select();          // 获取店铺列表
        $this->_store_list_for_select();         // 获取门店列表
        $this->_get_index_statistics_info();     // 获取首页统计组件信息
        $this->_community_shop_kind_list_for_select(); // 获取店铺分类列表
        $this->_get_train_lesson_type();
        $this->_post_tab();
        $this->_get_custom_form_list();         //获取自定义表单列表
        $this->_get_meal_activity();            //餐饮满减活动
        $this->_get_train_course_list();        //获取培训课程列表
        $this->_limit_group();
        $this->_get_menu_list();                //获得美食菜单列表

        // 独立商城的一级分类与二级分类
        if($this->wxapp_cfg['ac_type'] == 27)
            $this->_shop_independence_cate_list();

        if($this->wxapp_cfg['ac_type']==32)
            $this->_goods_activity_list();

        //内推分类
        if($this->wxapp_cfg['ac_type'] == 28){
            $this->_job_kind_list_for_select();
        }

        $page      = $this->_fetch_shop_outside();
        $page_data = $this->_fetch_page_data();


        $this->output['page_list'] = json_encode(array_merge($page,$page_data));
        $this->output['template']  = $template || !empty($data) ?json_encode(array_values($data)):json_encode(array());
        $this->output['headerTitle']  = $template['act_header_title'];
        $this->output['pagebgColor']  = $template['act_page_bgcolor'];
        $this->output['mealType']     = $template['act_meal_type']?$template['act_meal_type']:1;
        $this->output['showpostlist'] = $template['act_show_post_list']?'true':'false';
        $this->output['showpostbtn']  = $template['act_show_post_btn']?'true':'false';
        $this->renderCropTool('/wxapp/index/uploadImg');
        $baseComponent = plum_parse_config('base', 'customtpl/customtpl-' . $this->wxapp_cfg['ac_type']);

        $knowledgepay_status = $this->_check_knowledgepay_show();
        if($knowledgepay_status){
            $baseComponent[] = array(//18
                'type'       => 'courselist',
                'typeText'   => '课程列表',
                'icon'       => 'shangpinliebiao1',
                'goodStyle'  => 1,
                'isShowsold' => true,
                'isShowcart' => true,
                'isShowmore' => false,
                'priceBold'  => false,
                'cartBgcolor' => '#b6d7a8',
                'goodSourceType' => 1,
                'goodSource' => '',
                'goodsNum'   => 4,
                'titleStyle' => array(
                    'color'    => '#333',
                    'fontSize' => 15
                ),
                'priceStyle' => array(
                    'color'    => 'red',
                    'fontSize' => 15),
                'style'      => array(
                    'marginTop' => 0,
                    'marginBottom' => 0
                ),
                'labelStyle' => array(
                    'background' => '#faf2f5',
                    'color' => '#c69693'
                ),
                'goodsData'=>[
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ],
                    [
                        'title' => '课程标题',
                        'cover' => '/public/wxapp/customtpl/images/goodsView1.jpg',
                        'brief' => '商品简介',
                        'price' => 99,
                        'sold'  => 67,
                    ]
                ]
            );
        }


        //推荐组件
        $recommendTypeList = array();
        foreach ($baseComponent as $key => $value){
            if($value['type'] == 'recommendList'){
                $recommendTypeList = $baseComponent[$key]['recommendTypeList'];
            }
            if($this->menuType=='toutiao' && $value['type'] == 'advertisement'){
                unset($baseComponent[$key]);
            }
        }

        $this->output['recommendTypeList'] = json_encode($recommendTypeList);
        $marketComponent = plum_parse_config('marketing', 'customtpl/customtpl-' . $this->wxapp_cfg['ac_type']);
        if($this->menuType=='toutiao' && $marketComponent){
            foreach ($marketComponent as $key=>$value){
                if($value['type'] == 'group' || $value['type']=='bargain'){
                    unset($marketComponent[$key]);
                }
            }
        }
        $this->output['baseComponent'] = json_encode(array_values($baseComponent));
        $this->output['marketComponent'] = json_encode(array_values($marketComponent));

        $this->_get_template_list();  // 获取保存模板列表
        // 获取模板分组是否可用（是否能保存模板）
        $this->output['templateSave'] = true;
        $this->displaySmarty('wxapp/customtpl/setting-new.tpl');
    }

    /**
     * 社区团购商品活动列表
     * zhangzc
     * 2019-10-18
     * @return [type] [description]
     */
    private  function _goods_activity_list(){
        $activity_model = new App_Model_Sequence_MysqlSequenceActivityStorage($this->curr_sid);
        $where=[
            ['name'=>'asa_s_id','oper'=>'=','value'=>$this->curr_sid],
            ['name'=>'asa_is_on','oper'=>'=','value'=>1],
            ['name'=>'asa_deleted','oper'=>'=','value'=>0]
        ] ;
        $new_list=[];
        $list = $activity_model->getList($where,0,0);
        foreach ($list as $key => $val) {
            $new_list[] = array(
                'id'    => $val['asa_id'],
                'name'  => $val['asa_title'],
            );
        }
        $this->output['goodsActivityList'] = json_encode($new_list);
    }

    /**
     * 培训课程列表
     */
    private function _get_train_course_list(){
        $course_storage = new App_Model_Train_MysqlTrainCourseStorage($this->curr_sid);
        $where[]        = array('name' => 'atc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $course_list    = $course_storage->getList($where, 0, 0, array('atc_type_id' => 'DESC'));
        $list  = array();
        if($course_list){
            foreach($course_list as $key => $val){
                $list[] = array(
                    'id'    => $val['atc_id'],
                    'name'  => $val['atc_title'],
                );
            }
        }
        $this->output['courseList'] = json_encode($list);
    }

    /**
     * 获得餐饮活动
     */
    private function _get_meal_activity(){
        $activity_storage = new App_Model_Meal_MysqlMealFullActivityStorage($this->curr_sid);
        $list = $activity_storage->findListBySid();
        $fullName = '';
        foreach ($list as $key => $value) {
            if($value['amf_type'] == 1){
                $fullName .= $value['amf_name'].',';
                unset($list[$key]);
            }
        }
        $fullName = rtrim($fullName, ",");
        array_unshift($list, array('amf_type' => 1, 'amf_name' => $fullName));
        $this->output['mealActivityList'] = json_encode($list);
    }

    /**
     * 获取首页统计组件信息
     */
    private function _get_index_statistics_info(){
        if($this->wxapp_cfg['ac_type'] == 8){
            //获取数据统计信息
            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
            $community  = $tpl_model->findUpdateBySid(35);
            $this->output['community'] = $community;
        }
        if($this->wxapp_cfg['ac_type'] == 6){
            //获取数据统计信息
            $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $community  = $tpl_model->findUpdateBySid(23);
            $this->output['community'] = $community;
        }
    }

    /**
     * 获取保存模板列表
     */
    private function _get_template_list(){
        //模板列表
        $template_model = new App_Model_Applet_MysqlAppletCommonTemplateStorage();
        $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $templateList = $template_model->getList($where, 0, 0, array('act_create_time' => 'ASC'));
        $myTemplate  = array();
        foreach ($templateList as $value){
            $myTemplate[] = array(
                'id'      => $value['act_id'],
                'cover'   => $value['act_cover'],
                'name'    => $value['act_remark_name'],
                'data'    => $value['act_data'],
                'title'   => $value['act_header_title'],
                'bgColor' => $value['act_page_bgcolor']
            );
        }
        $this->output['templateList'] = json_encode($myTemplate);
    }

    /**
     * 获取店铺的全部分类选择使用
     */
    private function _job_kind_list_for_select(){
        $kind_model     = new App_Model_Job_MysqlJobCategoryStorage($this->curr_sid);
        // 获取职位的所有二级分类
        $kind2 = $kind_model->getAllSonCategory(1,0);
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_name']
                );
            }
        }
        // 获取职位的所有一级分类
        $onekind = $kind_model->getAllFirstCategory(1,0);
        $onekinddata = array();
        if($onekind){
            foreach ($onekind as $val){
                $onekinddata[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_name']
                );
            }
        }
        //获取公司的所有一级分类
        $kind1 = $kind_model->getAllFirstCategory(2,0);
        $firstKindSelect = array();
        if($kind1){
            foreach ($kind1 as $val){
                $firstKindSelect[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_name']
                );
            }
        }
        //获取公司列表
        $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->curr_sid);
        $where = [];
        $where[] = array('name' => 'ajc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'ajc_status', 'oper' => '=', 'value' => 2);
        $sort = array('ajc_create_time' => 'DESC');
        $kind3 = $company_model->getList($where,0,0,$sort);
        $companySelect = array();
        if($kind3){
            foreach ($kind3 as $val){
                $companySelect[] = array(
                    'id'   => $val['ajc_id'],
                    'name' => $val['ajc_company_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
        $this->output['firstKindSelect'] = json_encode($firstKindSelect);
        $this->output['oneKindSelect'] = json_encode($onekinddata);
        $this->output['companySelect'] = json_encode($companySelect);
    }

    /**
     * 获取职位列表
     */
    private function _get_position_list(){

        $position_storage = new App_Model_Job_MysqlJobPositionStorage($this->curr_sid);
        $where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'ajp_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);
        //获得全部商品  推荐在前
        $positionList = $position_storage->getList($where, 0, 0);
        $data = array();
        if($positionList){
            foreach ($positionList as $val){
                $data[] = array(
                    'id'   => $val['ajp_id'],
                    'name' => $val['ajp_title'],
                );
            }
        }
        $this->output['positionList'] = json_encode($data);
    }

    private function _get_quotation_list(){
        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->curr_sid);
        $where[] = array('name' => 'kcq_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $sort = array('kcq_create_time'=>'desc');
        $list = $quotation_model->getQuotationMemberList($where,0,0,$sort);
        $quotaData = array();
        foreach($list as $row){
            $quotaData[] = array(
                'id' => $row['kcq_id'],
                'content' => $row['kcq_content'] ? $row['kcq_content'] : '',
                'likeNum' => intval($row['kcq_like_num']),
                'commentNum' => intval($row['kcq_comment_num'])
            );
        }
        $this->output['quotaList']  = json_encode($quotaData);
    }

    private function _get_knowpay_index(){
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(59);
        $this->output['articleCoverType'] = $tpl['aki_article_cover_type'];
        $this->output['audioCoverType']   = $tpl['aki_audio_cover_type'];
        $this->output['videoCoverType']   = $tpl['aki_video_cover_type'];
    }

    private function _meal_shop_info(){
        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(12);
        $tpl['ami_open_time'] = explode('-', $tpl['ami_open_time']);
        $shopInfo = array(
            'openStartTime' => $tpl['ami_open_time'][0],
            'openEndTime'   => $tpl['ami_open_time'][1],
            'spend'         => $tpl['ami_average_spend']?$tpl['ami_average_spend']:0,
            'limit'         => $tpl['ami_post_limit'],
            'nav1HeadImg'   => $tpl['ami_nav1_head_img']?$tpl['ami_nav1_head_img']:'/public/wxapp/driver/images/banner@2x.png',
            'nav2HeadImg'   => $tpl['ami_nav2_head_img']?$tpl['ami_nav2_head_img']:'/public/wxapp/driver/images/banner@2x.png',
            'nav3HeadImg'   => $tpl['ami_nav3_head_img']?$tpl['ami_nav3_head_img']:'/public/wxapp/driver/images/banner@2x.png',
            'postFee'       => $tpl['ami_post_fee']?$tpl['ami_post_fee']:0,
            'postRange'     => $tpl['ami_post_range']?$tpl['ami_post_range']:0,
            'avgSendTime'   => $tpl['ami_avg_send_time']?$tpl['ami_avg_send_time']:0,
            'paymentMoney'  => $tpl['ami_payment_money']?$tpl['ami_payment_money']:0,
            'tablewareFee'  => $tpl['ami_tableware_fee']?$tpl['ami_tableware_fee']:0,
            'longitude'     => $tpl['ami_lng'],
            'latitude'      => $tpl['ami_lat'],
            'address'       => $tpl['ami_address'],
        );


        $this->output['shopInfo']  = json_encode($shopInfo);
    }

    private function _hotel_shop_info(){
        $tpl_model = new App_Model_Hotel_MysqlHotelIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(27);
        $hotelInfo = array(
            'cancelPrompt' => $tpl['ahi_cancel_prompt']?$tpl['ahi_cancel_prompt']:'',
            'tradeRemind' => $tpl['ahi_trade_remind']?$tpl['ahi_trade_remind']:'',
        );

        $this->output['hotelInfo']  = json_encode($hotelInfo);
    }

    private function _get_post_category(){
        $data = array();
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList(1);
        foreach($shortcut as $key => $val){
            $data[$key]['id']   = $val['acc_id'];
            $data[$key]['name'] = $val['acc_title'];
            $data[$key]['icon'] = $val['acc_img'];
            $data[$key]['link']['type'] = $val['acc_service_type'];
            $data[$key]['price']= $val['acc_price'];
            $data[$key]['link']['url']  = $val['acc_link_url'];
            $data[$key]['mobileShow']   = $val['acc_mobile_show'] ==1 ? true : false;
            $data[$key]['addressShow']  = $val['acc_address_show'] ==1 ? true : false;
            $data[$key]['allowComment'] = $val['acc_allow_comment'] ==1 ? true : false;
            $data[$key]['verifyComment']= $val['acc_verify_comment'] ==1 ? true : false;
            $data[$key]['isshow'] = $val['acc_isshow'] ==1 ? true : false;
        }
        $this->output['cityCategory'] = json_encode($data);
    }

    /**
     * 同城首页帖子tab
     */
    private function _post_tab(){
        $tab_storage = new App_Model_City_MysqlCityPostTabStorage($this->curr_sid);
        $tab_list = $tab_storage->fetchShortcutShowList(0);
        $data = array();
        if($tab_list){
            foreach ($tab_list as $val){
                $data[] = array(
                    'index'         => intval($val['acpt_weight']),
                    'link'          => $val['acpt_link'],
                    'linkName'      => '',
                    'type'          => $val['acpt_link_type'],
                    'name'          => $val['acpt_name']
                );
            }
        }
        $this->output['tabList'] = json_encode($data);
    }

    /**
     * 获取自定义表单列表
     */
    private function _get_custom_form_list(){
        $form_model = new App_Model_Applet_MysqlCustomFormStorage();
        $where[] = array('name' => 'acf_s_id' , 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acf_deleted' , 'oper' => '=', 'value' => 0);
        $list = $form_model->getList($where);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['acf_id'],
                    'name' => $val['acf_header_title']
                );
            }
        }
        $this->output['formlist'] = json_encode($data);
    }

    /**
     * @param bool $return
     * @return array
     * 获取同城帖子类型
     */
    private function _get_post_type(){
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(23);
        $type = array(
            array('index'=>0,'name'=>'最新发布','must'=>true,'type'=>'time'),
            array('index'=>1,'name'=>'红包福利','must'=>false,'type'=>'redPacket'),
            array('index'=>2,'name'=>'最新回复','must'=>true,'type'=>'reply'),
            array('index'=>3,'name'=>'距离最近','must'=>true,'type'=>'distance')
        );

        if(!$tpl['aci_post_type']){
            $tpl['aci_post_type'] = json_encode($type);
        }else{
            $tpl['aci_post_type'] = $this->_remove_post_quotes($tpl['aci_post_type']);

        }
        $this->output['tpl'] = $tpl;
    }

    /*
     * 二手车 获得首页固定tab
     */
    private function _get_index_tab(){
        $tpl_model = new App_Model_Car_MysqlCarCfgStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        $type = array(
            array('index'=>0,'name'=>'最新车源','must'=>true,'type'=>'resource'),
            array('index'=>1,'name'=>'推荐服务','must'=>true,'type'=>'goods')
        );

        if(!$tpl['acc_index_tab']){
            $tpl['acc_index_tab'] = json_encode($type);
        }else{
            $tpl['acc_index_tab'] = $this->_remove_post_quotes($tpl['acc_index_tab']);

        }
        $this->output['carCfg'] = $tpl;
    }

    /**
     * @param $type
     * @return string 去除must的引号
     */
    private function _remove_post_quotes($type){
        $type = json_decode($type,true);
        foreach ($type as &$value){
            if($value['must']=='true'){
                $value['must'] = true;
            }else{
                $value['must'] = false;
            }
        }
        return json_encode($type);
    }

    /*
     * 获得全部游戏以供选择
     */
    private function _get_game_for_select($return = false){
        $data = array();
        $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->curr_sid);
        $where[] = array('name'=>'agg_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $game_model->getList($where,0,0);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['agg_id'],
                    'name' => $val['agg_name']
                );
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['gameList'] = json_encode($data);
            $this->output['gameSelect'] = $data;
        }

    }

    /*
     * 获得全部车源以供选择
     */
    private function _get_car_resource($return = false){
        $data = array();
        if($this->wxapp_cfg['ac_type'] == 33){
            $car_model = new App_Model_Car_MysqlCarResourceStorage($this->curr_sid);
            $where[] = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->curr_sid);
            $list = $car_model->getResourceList($where,0,0,[]);
            if($list){
                foreach ($list as $val){
                    $data[] = array(
                        'id' => $val['acr_id'],
                        'name' => $val['cb_name'].' '.$val['ct_name'].'('.$val['m_nickname'].')'
                    );
                }
            }
        }

        if($return){
            return $data;
        }else{
            $this->output['carList'] = json_encode($data);
            $this->output['carSelect'] = $data;
        }

    }

    /*
     * 获得服务商分类
    */
    private function _get_car_shop_category($return = false){
        $data = array();
        if($this->wxapp_cfg['ac_type'] == 33){
            $car_model = new App_Model_Community_MysqlKindStorage($this->curr_sid);
            $where[] = array('name'=>'ack_s_id','oper'=>'=','value'=>$this->curr_sid);
            $list = $car_model->getFirstCategory(0,0);
            if($list){
                foreach ($list as $val){
                    $data[] = array(
                        'id' => $val['ack_id'],
                        'name' => $val['ack_name']
                    );
                }
            }
        }

        if($return){
            return $data;
        }else{
            $this->output['carShopKindList'] = json_encode($data);
            $this->output['carShopKindSelect'] = $data;
        }

    }

    /**
     * 获取游戏分类
     */
    private function _game_category(){
        $category_model = new App_Model_Gamebox_MysqlGameboxCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'agc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $category = $category_model->getList($where,0,0,array('agc_update_time'=>'desc'));
        $data = array();
        if($category){
            foreach ($category as $val){
                $data[] = array(
                    'id'   => $val['agc_id'],
                    'name' => $val['agc_name']
                );
            }
        }
        $this->output['gameCategory'] = json_encode($data);
    }

    /**
     * 获取店铺的全部分类
     */
    private function _community_shop_kind_list_for_select(){
        if($this->wxapp_cfg['ac_type'] == 6){
            $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
            $category = $shortcut_model->fetchShortcutShowList(2);
            $data = array();
            if($category){
                foreach ($category as $val){
                    $data[] = array(
                        'id'   => $val['acc_id'],
                        'name' => $val['acc_title'],
                    );
                }
            }
            $this->output['shopKindSelect'] = json_encode($data);
        }else{
            $kind_model     = new App_Model_Community_MysqlKindStorage($this->curr_sid);
            // 获取店铺的所有二级分类
            $kind1 = $kind_model->getFirstCategory(0,0);
            $data = array();
            if($kind1){
                foreach ($kind1 as $val){
                    $data[] = array(
                        'id'   => $val['ack_id'],
                        'name' => $val['ack_name']
                    );
                }
            }
            $this->output['shopKindSelect'] = json_encode($data);
        }
    }

    /**
     * 获取店铺列表
     */
    private function _shop_list_for_select(){
        if($this->wxapp_cfg['ac_type'] == 6){
            $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $sort  = array('acs_create_time' => 'DESC');
            $where = array();
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
            $shop    = $shop_storage->getList($where,0,0,$sort);
            $data = array();
            $selectShop = array();
            if($shop){
                foreach ($shop as $val){
                    $data[] = array(
                        'id'        => $val['acs_id'],
                        'name'      => $val['acs_name'],
                    );
                    $selectShop[$val['acs_id']] = $val['acs_name'];
                }
            }
            $this->output['shoplist'] = json_encode($data);
            $this->output['selectShop'] = $selectShop;
        }else{
            $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);

            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
            $sort    = array('es_createtime' => 'DESC');
            $list    = $shop_model->getList($where,0,0,$sort);

            $data = array();
            $selectShop = array();
            if($list){
                foreach ($list as $val){
                    $data[] = array(
                        'id'   => $val['es_id'],
                        'name' => $val['es_name']
                    );
                    $selectShop[$val['es_id']] = $val['es_name'];
                }
            }
            $this->output['shoplist'] = json_encode($data);
            $this->output['selectShop'] = $selectShop;
        }
    }

    /**
     * 获取门店列表
     */
    public function _store_list_for_select(){
        $store_model    = new App_Model_Hotel_MysqlHotelStoreStorage($this->curr_sid);
        $where[]   = array('name' => 'ahs_s_id','oper' => '=','value' =>$this->curr_sid);
        $sort = array('ahs_create_time' => 'DESC');
        $list = $store_model->getList($where,0,0,$sort);
        $storeList = array();
        if($list){
            foreach ($list as $store){
                $storeList[] = [
                    'id' => $store['ahs_id'],
                    'name' => $store['ahs_name']
                ];
            }
        }
        $this->output['storelist'] = json_encode($storeList);
    }

    /**
     * 获取内推首页配置
     */
    public function _get_job_index(){
        $tpl_model = new App_Model_Job_MysqlJobIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(61);
        $type = array(
            array('index'=>0,'name'=>'为您推荐','must'=>true,'type'=>'recommend'),
            array('index'=>1,'name'=>'附近职位','must'=>true,'type'=>'nearby'),
            array('index'=>2,'name'=>'高薪职位','must'=>true,'type'=>'fat'),
            array('index'=>3,'name'=>'内推职位','must'=>true,'type'=>'award')
        );

        if(!$tpl['aji_position_type']){
            $tpl['aji_position_type'] = json_encode($type);
        }else{
            $tpl['aji_position_type'] = $this->_remove_post_quotes($tpl['aji_position_type']);
        }

        $jobInfo = array(
            'recommendMin'   => $tpl['aji_recommend_min']?$tpl['aji_recommend_min']:0,
            'entryMin'       => $tpl['aji_entry_min']?$tpl['aji_entry_min']:0,
            'recommendedMin' => $tpl['aji_recommended_min']?$tpl['aji_recommended_min']:0,
            'confirmTime'    => $tpl['aji_confirm_time']?$tpl['aji_confirm_time']:7,
            'inviteNum'      => $tpl['aji_job_invite_num']?$tpl['aji_job_invite_num']:0,
            'awardIntro'     => $tpl['aji_award_intro'],
            'companyNum'     => $tpl['aji_company_num'],
            'positionNum'    => $tpl['aji_position_num'],
            'resumeNum'      => $tpl['aji_resume_num'],
            'browseNum'      => $tpl['aji_browse_num'],
            'statIcon'       => $tpl['aji_stat_icon']
        );
        $this->output['jobTpl'] = $tpl;
        $this->output['jobInfo'] = json_encode($jobInfo);
    }


    /**
     * 资讯分类
     */
    public function _shop_information_category(){
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $list = $category_storage->getListBySid();
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['aic_id'],
                    'index' => $key,
                    'name'  => $val['aic_name']
                );
            }
        }
        $this->output['informationCategory'] = json_encode($categoryList);
    }


    /**
     * 拼团商品列表
     *
     */
    private function _group_list_for_select(){
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->curr_sid);

        $list    = $group_model->getCurrentList(0,0,array());
        $data = array();
        foreach($list as $val){
            $data[] = array(
                'id'    => $val['gb_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['groupList'] = json_encode($data);
    }

    /**
     * 秒杀商品列表
     *
     */
    private function _limit_list_for_select(){
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $list    = $limit_model->getAllRunningNotBeginActGoods(array(),0,0);
        $data = array();
        foreach($list as $val){
            $data[]= array(
                'id'    => $val['g_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['limitList'] = json_encode($data);
    }

    /**
     * 砍价商品列表
     *
     */
    private function _bargain_list_for_select(){
        $where = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);

        $where[]  = array('name'=>'ba_deleted','oper'=>'=','value'=>0);
        $where[]  = array('name'=>'ba_end_time','oper'=>'>','value'=>time());
        $sort = array('ba_status'=>'ASC','ba_create_time' => 'DESC');
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $list = $bargain_model->getActivityList($where,0,0,$sort);
        $data = array();
        foreach($list as $val){
            $data[]= array(
                'id'    => $val['ba_id'],
                'name'  => $val['g_name'],
            );
        }
        $this->output['bargainList'] = json_encode($data);
    }

    /**
     * 获取店铺保存的外链地址
     */
    private function _fetch_shop_outside(){
        $webcfg_storage = new App_Model_Applet_MysqlAppletWebcfgStorage($this->curr_sid);
        $cfg = $webcfg_storage->findUpdateBySid();
        $data = array();
        $page_data = array();
        if($cfg && ($cfg["awc_web1"] || $cfg["awc_web2"] ||$cfg["awc_web3"] || $cfg["awc_web4"] || $cfg["awc_web5"])){
            for($i=1;$i<=5;$i++){
                if(isset($cfg["awc_web$i"]) && $cfg["awc_web$i"]){
                    $data[] = array(
                        'index' => $i,
                        'link'  => $cfg["awc_web$i"],
                        'title' => '链接地址'.$i,
                    );
                    $page_data[] = array(
                        'path' => 'pages/webviewTab'.$i.'/webviewTab'.$i,
                        'name' => '链接地址'.$i,
                    );
                }
            }
        }else{
            $data[] = array(
                'index' => 0,
                'link'  => '',
                'title' => '链接地址1',
            );
        }
        $this->output['outsideLink'] = json_encode($data);
        return $page_data;
    }

    private function _fetch_page_data(){
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();

        switch ($this->menuType){
            case 'toutiao':
                $userType = 'ap_toutiao_user';
                break;
            default:
                $userType = 'ap_wxapp_user';
        }

        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type'],$userType);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 18){
                    if(!in_array($val['ap_path'],['pages/groupIndex/groupIndex','pages/seckillPage/seckillPage','pages/bargainIndex/bargainIndex'])){
                        $path = $val['ap_path'];
                        if($val['ap_path'] == "pages/generalFormTab/generalFormTab"){
                            $path = str_replace('generalFormTab', 'generalForm', $val['ap_path']);
                        }
                        if($val['ap_path'] == "pages/groupIndex/groupIndex"){
                            $path = str_replace('groupIndex', 'groupIndexPage', $val['ap_path']);
                        }
                        if($val['ap_path'] == "pages/goodIndex/goodIndex" && $this->wxapp_cfg['ac_type'] != 8){
                            $path = str_replace('pages', 'subpages0', $val['ap_path']);
                        }
                        if($val['ap_path'] == "pages/seckillPage/seckillPage"){
                            $path = str_replace('seckillPage', 'seckillPageShow', $val['ap_path']);
                        }
                        /*if($val['ap_path'] == "pages/storeMember/storeMember"){
                            $path = str_replace('pages/storeMember/storeMember', 'subpages/memberCard/memberCard', $val['ap_path']);
                        }*/
                        if($val['ap_path'] == "pages/distributionCenterTab/distributionCenterTab"){
                            if(in_array($this->wxapp_cfg['ac_type'],array(21,8,6))){
                                $path = 'subpages0/distributionCenter/distributionCenter';
                            }else{
                                $path = str_replace('distributionCenterTab', 'distributionCenter', $val['ap_path']);
                            }
                        }
                        if($this->menuType=='toutiao'){
                            if(in_array($val['ap_id'],[362,305,291,204,199,191])) continue;
                        }
                        $page_data[] = array(
                            'path' => $path,
                            'name' => $val['ap_desc']." （".$path."）"
                        );
                    }
                }else{
                    $path = $val['ap_path'];
                    if($val['ap_path'] == "pages/generalFormTab/generalFormTab"){
                        $path = str_replace('generalFormTab', 'generalForm', $val['ap_path']);
                    }
                    if($val['ap_path'] == "pages/groupIndex/groupIndex"){
                        $path = str_replace('groupIndex', 'groupIndexPage', $val['ap_path']);
                    }
                    if($val['ap_path'] == "pages/goodIndex/goodIndex" && $this->wxapp_cfg['ac_type'] != 8){
                        $path = str_replace('pages', 'subpages0', $val['ap_path']);
                    }
                    if($val['ap_path'] == "pages/seckillPage/seckillPage"){
                        $path = str_replace('seckillPage', 'seckillPageShow', $val['ap_path']);
                    }
                    /*if($val['ap_path'] == "pages/storeMember/storeMember"){
                        $path = str_replace('pages/storeMember/storeMember', 'subpages/memberCard/memberCard', $val['ap_path']);
                    }*/
                    if($val['ap_path'] == "pages/distributionCenterTab/distributionCenterTab"){
                        if(in_array($this->wxapp_cfg['ac_type'],array(21,8,6))){
                            $path = 'subpages0/distributionCenter/distributionCenter';
                        }else{
                            $path = str_replace('distributionCenterTab', 'distributionCenter', $val['ap_path']);
                        }
                    }
                    if($this->menuType=='toutiao'){
                        if(in_array($val['ap_id'],[362,305,291,204,199,191])) continue;
                    }
                    $page_data[] = array(
                        'path' => $path,
                        'name' => $val['ap_desc']." （".$path."）"
                    );
                }

            }
        }
        if($this->wxapp_cfg['ac_type'] == 6){
            $page_data[] = array(
                'path' => 'pages/goodIndex/goodIndex',
                'name' => '同城商城'." （pages/goodIndex/goodIndex）"
            );
        }
        return $page_data;
    }

    /**
     * 获取企业服务分类以及第一个分类对应的服务
     */
    private function _shop_service_category(){
        $category_storage = new App_Model_Shop_MysqlShopServiceCategoryStorage($this->curr_sid);
        $list = $category_storage->getCategoryListByType(1);
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['ssc_id'],
                    'index' => $key,
                    'name'  => $val['ssc_name']
                );
            }
        }
        $where      = array();
        $where[]    = array('name'=>'ss_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'ss_category','oper'=>'=','value'=>$categoryList[0]['id']);
        $where[]    = array('name'=>'ss_type','oper'=>'=','value'=>1);
        $sort = array('ss_create_time'=>'DESC');
        $article_model  = new App_Model_Shop_MysqlShopServiceInformationStorage();
        $list = $article_model->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'     => $val['ss_id'],
                    'title'  => $val['ss_title'],
                    'brief'  => $val['ss_brief'],
                    'cover'  => $val['ss_cover'],
                    'price'  => $val['ss_price'],
                    'label'  => $val['ss_label'],
                );
            }
        }
        $this->output['categoryList'] = json_encode($categoryList);
        $this->output['articleService'] = json_encode($data);
    }

    /**
     * @param int $is_add
     * 展示商品类目
     */
    private function _show_category($type, $index=0,$all = 0){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $cateList          = $category_model->getSonsByFid($type);
        $category       = array();
        if($index){
            foreach($cateList as $val){
                $category[] = array(
                    'id' => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
            if($type == 2){
                $this->output['expertCategory']    = json_encode($category) ;
                if($all){
                    $this->output['reservationCategory']    =json_encode($category);
                }
            }else{
                $this->output['reservationCategory']   = json_encode($category);
            }
        }else{
            $category       = array();
            foreach($cateList as $val){
                $category[$val['sk_id']] = $val['sk_name'];
            }
            if($type == 2){
                $this->output['expertCategory']    = $category ;
                if($all){
                    $this->output['reservationCategory']    =$category ;
                }
            }else{
                $this->output['reservationCategory']    =$category ;
            }

        }
    }

    /**
     * 专家列表
     */
    private function _show_expert_list(){
        //获取店铺商品
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid,0,0,'', 0, $sort,array(),2,0,1);;
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        $this->output['expertList'] = json_encode($info);
    }


    /**
     * 格式化商品数据
     */
    private function _format_goods_details($goods){
        if($goods){
            $data = array(
                'id'         => $goods['g_id'],
                'name'       => $goods['g_name'],
                'cover'      => $goods['g_cover'],
                'price'      => $goods['g_price'],
                'oriPrice'   => $goods['g_ori_price'],
                'sold'       => $goods['g_sold'],
                'brief'      => $goods['g_brief'],
            );
            return $data;
        }
        return false;
    }

    /**
     * 获取企业服务文章
     */
    private function _shop_service_article(){
        $where      = array();
        $where[]    = array('name'=>'ss_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'ss_type','oper'=>'=','value'=>1);
        $sort = array('ss_create_time'=>'DESC');
        $article_model  = new App_Model_Shop_MysqlShopServiceInformationStorage();
        $list = $article_model->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'     => $val['ss_id'],
                    'title'  => $val['ss_title'],
                    'brief'  => $val['ss_brief'],
                    'cover'  => $val['ss_cover'],
                );
            }
        }
        $this->output['serviceArticle'] = json_encode($data);
    }

    /**
     * 获取商品分组数据
     */
    private function goodsGroup(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        $shopData = array();
        if($list){
            foreach ($list as $val){
                if($val['gg_is_eshop']){
                    $shopData[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }else{
                    $data[] = array(
                        'id'   => $val['gg_id'],
                        'name' => $val['gg_name'],
                    );
                }
            }
        }
        $this->output['goodsGroup'] = json_encode($data);
        $this->output['shopGoodsGroup'] = json_encode($shopData);
    }

    /**
     * 获取店铺促销商品,推荐商品选择推荐商品使用
     */
    private function _shop_top_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);

        $where = [];
//        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
//            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
//        }

        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',1,array(),array(),0,0,0,$where);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['goodsList'] = json_encode($data);
    }

    private function _shop_appointment_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        //只获得推荐商品
//        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',1,array(),array(),0,0,0);
        //获得全部商品  推荐在前
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,0,'',0,array('g_is_top' => 'DESC','g_update_time' => 'DESC'),array(),0,0,3);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
            }
        }
        $this->output['appointmentGoodsList'] = json_encode($data);
    }

    private function _deal_slide_data($data){
        $data['autoplay']     = $data['autoplay']=='true'?true:false;
        $data['isShowvideo']  = $data['isShowvideo']=='true'?true:false;
        $data['borderRadius'] = intval($data['borderRadius']);
        $data['duration']     = intval($data['duration']);
        $data['interval']     = intval($data['interval']);
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        return $data;
    }

    private function _deal_video_data($data){
        $data['autoplay']              = $data['autoplay']=='true'?true:false;
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        return $data;
    }

    private function _deal_fenlei_data($data){
        $data['iconRadius']   = intval($data['iconRadius']);
        $data['navNumber']    = intval($data['navNumber']);
        $data['styleType']    = intval($data['styleType']);
        $data['style']['width']        = intval($data['style']['width']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['borderRadius'] = intval($data['style']['borderRadius']);
        if($this->wxapp_cfg['ac_type'] == 6){
            $flitems = $data['flitems'];
            $data['flitems'] = array();
            $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
            $shortcut = $shortcut_model->fetchShortcutShowList(1);
            $json = array();
            foreach($shortcut as $key => $val){
                $data['flitems'][$key]['id']   = $val['acc_id'];
                $data['flitems'][$key]['name'] = $val['acc_title'];
                $data['flitems'][$key]['icon'] = $val['acc_img'];
                $data['flitems'][$key]['link']['type'] = $val['acc_service_type'];
                $data['flitems'][$key]['price']= $val['acc_price'];
                $data['flitems'][$key]['link']['url']  = $val['acc_link_url'];
                $data['flitems'][$key]['link']['linkName'] = $flitems[$key]['link']['linkName'];
                $data['flitems'][$key]['mobileShow']   = $val['acc_mobile_show'] ==1 ? true : false;
                $data['flitems'][$key]['addressShow']  = $val['acc_address_show'] ==1 ? true : false;
                $data['flitems'][$key]['allowComment'] = $val['acc_allow_comment'] ==1 ? true : false;
                $data['flitems'][$key]['verifyComment']= $val['acc_verify_comment'] ==1 ? true : false;
                $data['flitems'][$key]['isshow'] = $val['acc_isshow'] ==1 ? true : false;
            }
            $this->output['shortcut'] = json_encode($json);
        }
        return $data;
    }

    private function _deal_search_data($data){
        $data['searchArea']['marginBottom']  = intval($data['searchArea']['marginBottom']);
        $data['searchArea']['marginTop']     = intval($data['searchArea']['marginTop']);
        $data['searchArea']['paddingBottom'] = intval($data['searchArea']['paddingBottom']);
        $data['searchArea']['paddingTop']    = intval($data['searchArea']['paddingTop']);
        $data['style']['borderRadius'] = intval($data['style']['borderRadius']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['height']   = intval($data['style']['height']);
        $data['style']['width']    = intval($data['style']['width']);
        $data['showWeather']       = ($data['showWeather']=='true' || !array_key_exists('showWeather', $data))?true:false;
        return $data;
    }

    private function _deal_address_data($data){
        $data['addressStyle'] = intval($data['addressStyle']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        return $data;
    }

    private function _deal_notice_data($data){
        $data['isBold']                = $data['isBold']=='true'?true:false;
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        return $data;
    }

    private function _deal_title_data($data){
        $data['isBold']                = $data['isBold']=='true'?true:false;
        $data['titleStyle']            = intval($data['titleStyle']);
        $data['style']['fontSize']     = intval($data['style']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingBottom']= intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']   = intval($data['style']['paddingTop']);
        return $data;
    }

    private function _deal_image_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        $data['style']['paddingBottom']= intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']   = intval($data['style']['paddingTop']);
        return $data;
    }

    private function _deal_button_data($data){
        $data['buttonStyle']['borderRadius'] = intval($data['buttonStyle']['borderRadius']);
        $data['buttonStyle']['fontSize']     = intval($data['buttonStyle']['fontSize']);
        $data['buttonStyle']['height']       = intval($data['buttonStyle']['height']);
        $data['buttonStyle']['lineHeight']   = intval($data['buttonStyle']['lineHeight']);
        $data['buttonStyle']['width']        = intval($data['buttonStyle']['width']);
        $data['style']['paddingLeft']   = intval($data['style']['paddingLeft']);
        $data['style']['paddingBottom'] = intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']    = intval($data['style']['paddingTop']);
        return $data;
    }

    private function _deal_space_data($data){
        $data['spaceStyle']['borderTopWidth'] = intval($data['spaceStyle']['borderTopWidth']);
        $data['spaceStyle']['width']      = intval($data['spaceStyle']['width']);
        $data['style']['marginTop']       = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        return $data;
    }

    private function _deal_goodlist_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['isShowcart'] = $data['isShowcart']=='true'?true:false;
        $data['isShowsold'] = $data['isShowsold']=='true'?true:false;
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']  = intval($data['titleStyle']['fontSize']);
        return $data;
    }

    private function _deal_pictxt_data($data){
        $data['picStyle']      = intval($data['picStyle']);
        $data['singleImgNum']  = intval($data['singleImgNum']);
        $data['titleStyle']    = intval($data['titleStyle']);
        $data['isShowbrief']   = $data['isShowbrief']=='true'?true:false;
        $data['imageStyle']['borderRadius'] = intval($data['imageStyle']['borderRadius']);
        $data['imageStyle']['height']  = intval($data['imageStyle']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleCss']['fontSize']  = intval($data['titleCss']['fontSize']);
        $data['titleCss']['lineHeight']= intval($data['titleCss']['lineHeight']);
        return $data;
    }

    private function _deal_window_data($data){
        $data['imageStyle']['borderRadius'] = intval($data['imageStyle']['borderRadius']);
        $data['imageStyle']['padding'] = intval($data['imageStyle']['padding']);
        $data['style']['height']       = intval($data['style']['height']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['style']['paddingLeft']  = intval($data['style']['paddingLeft']);
        $data['style']['paddingRight'] = intval($data['style']['paddingRight']);
        $data['style']['paddingBottom']= intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']   = intval($data['style']['paddingTop']);
        return $data;
    }

    private function _deal_coupon_data($data){
        $data['limitStyle']['fontSize'] = intval($data['limitStyle']['fontSize']);
        $data['valueStyle']['fontSize'] = intval($data['valueStyle']['fontSize']);
        $data['style']['marginBottom']  = intval($data['style']['marginBottom']);
        $data['style']['marginTop']     = intval($data['style']['marginTop']);
        $data['style']['paddingBottom'] = intval($data['style']['paddingBottom']);
        $data['style']['paddingTop']    = intval($data['style']['paddingTop']);
        return $data;
    }


    private function _deal_group_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        return $data;
    }

    private function _deal_seckill_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        return $data;
    }

    private function _deal_bargain_data($data){
        $data['goodStyle']  = intval($data['goodStyle']);
        $data['priceBold']  = $data['priceBold']=='true'?true:false;
        $data['isShowmore'] = $data['isShowmore']=='true'?true:false;
        $data['priceStyle']['fontSize']= intval($data['priceStyle']['fontSize']);
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        return $data;
    }

    private function _deal_advertisement_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        return $data;
    }

    private function _deal_shoplist_data($data){
        $data['isShowCate']  = $data['isShowCate']=='true'?true:false;
        $data['isShowmore']  = $data['isShowmore']=='true'?true:false;
        $data['isShowLabel'] = $data['isShowLabel']=='true'?true:false;
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['titleStyle']['fontSize']= intval($data['titleStyle']['fontSize']);
        return $data;
    }

    private function _deal_statistics_data($data){
        $data['style']['marginBottom'] = intval($data['style']['marginBottom']);
        $data['style']['marginTop']    = intval($data['style']['marginTop']);
        $data['browseShow']  = $data['browseShow']=='true'?true:false;
        $data['issueShow']   = $data['issueShow']=='true'?true:false;
        $data['memberShow']  = $data['memberShow']=='true'?true:false;
        $data['shopShow']    = $data['shopShow']=='true'?true:false;

        return $data;
    }

    /**
     * 获取列表以供使用
     */
    private function _get_list_for_select(){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }


        $foldType = plum_parse_config('fold_menu',$config_name);
        $this->output['linkTypeNew'] = array();
        //基础商城和营销商城
        if($this->wxapp_cfg['ac_type'] == 1 || $this->wxapp_cfg['ac_type'] == 21){
            $linkList = plum_parse_config('link',$config_name);
            $linkType = plum_parse_config('link_type',$config_name);
            $weedingType = plum_parse_config('link_type_goods',$config_name);
            $customType  = plum_parse_config('link_type_custom',$config_name);
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($linkType[0]);  // 去除资讯单页
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType, $customType));
            unset($foldType[0]); //去掉客服

            //抖音营销商城 知识付费相关菜单
            $knowledgepay_status = $this->_check_knowledgepay_show();
            if($knowledgepay_status){
                $weedingType[] = array(
                    'id'   => '201',
                    'name' => '课程详情'
                );
                $weedingType[] = array(
                    'id'   => '26',
                    'name' => '课程分类列表'
                );
            }


            if($this->wxapp_cfg['ac_type'] == 21){
                $allMallType = plum_parse_config('link_type_all_mall',$config_name);

                $allMallType[] = array(
                    'id'   => '61',
                    'name' => '美食菜单详情'
                );

                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $allMallType, $customType), $foldType));
            }else{
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $customType), $foldType));
            }

        }

        //门店
        if($this->wxapp_cfg['ac_type'] == 13){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $weedingType = plum_parse_config('link_type_cake','system');
            $customType  = plum_parse_config('link_type_custom','system');
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType, $customType));

            unset($foldType[0]); //去掉客服
            $allMallType = plum_parse_config('link_type_all_mall','system');
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $allMallType, $customType), $foldType));

        }

        //企业
        if($this->wxapp_cfg['ac_type'] == 3){
            $linkList = plum_parse_config('link',$config_name);
            $linkType = plum_parse_config('link_type',$config_name);
            $enterpriseType = plum_parse_config('link_type_enterprise',$config_name);
            $customType  = plum_parse_config('link_type_custom',$config_name);
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $extra_link = array(
                array(
                    'path' => '/pages/decorativeList/decorativeList',
                    'name' => '装修风格',
                ),
                array(
                    'path' => '/pages/caseList/caseList',
                    'name' => '精选案例',
                ),
                array(
                    'path' => '/pages/stylist/stylist',
                    'name' => '设计大咖',
                ),
            );
            $this->output['linkList'] = json_encode(array_merge($link,$extra_link));
            $this->output['linkType'] = json_encode(array_merge($linkType,$enterpriseType, $customType));

           // unset($foldType[0]); //去掉客服
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$enterpriseType, $customType), $foldType));
        }

        //预约服务
        if($this->wxapp_cfg['ac_type'] == 18){
            $linkList = plum_parse_config('link',$config_name);
            $linkType = plum_parse_config('link_type',$config_name);
            $reserType = plum_parse_config('link_type_reserva',$config_name);
            $customType  = plum_parse_config('link_type_custom',$config_name);
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];

            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$reserType, $customType));
            unset($foldType[0]); //去掉客服

            $allMallType = plum_parse_config('link_type_all_mall',$config_name);
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$reserType, $allMallType, $customType), $foldType));
        }

        //游戏盒子
        if($this->wxapp_cfg['ac_type'] == 30){
            $linkType = plum_parse_config('link_type','system');
            unset($linkType[1]);
            unset($linkType[2]);
            unset($linkType[3]);
            $reserType = plum_parse_config('link_type_game','system');
            $this->output['linkType'] = json_encode(array_merge($linkType));
            $this->output['linkType'] = json_encode(array_merge($linkType,$reserType));
            $link = array();
            $this->output['linkList'] = json_encode($link);
        }

        //内推
        if($this->wxapp_cfg['ac_type'] == 28){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $groupType = plum_parse_config('link_type_job','system');

            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $noLink = array(
                array(
                    'id'   => '0',
                    'name' => '无跳转'
                ),
            );

            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($noLink,$linkType,$groupType));
        }

        $goodSourceType = array(
            array(
                'id'   => '1',
                'name' => '商品分类'
            ),
            array(
                'id'   => '2',
                'name' => '商品分组'
            ),
        );
        if($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 7){
            unset($goodSourceType[1]);
        }

        //同城
        if($this->wxapp_cfg['ac_type'] == 6){
            $linkList = plum_parse_config('link','system');
            $linkType = $linkTypeNew = plum_parse_config('link_type','system');
            $groupType = plum_parse_config('link_type_city','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($linkType[0]);  // 去除资讯单页
            unset($customType[0]);  // 去除资讯分类
            unset($customType[2]);

            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$groupType, $customType), $foldType));
            $this->output['linkTypeNew'] = json_encode(array_merge($linkTypeNew,$groupType));

            $goodSourceType = array(
                array(
                    'id'   => '1',
                    'name' => '平台商品分类'
                ),
                array(
                    'id'   => '4',
                    'name' => '商家商品分组'
                ),
            );
        }


        if($this->wxapp_cfg['ac_type'] == 13 || $this->wxapp_cfg['ac_type'] == 18 || $this->wxapp_cfg['ac_type'] == 27 ){
            //去除index为1的元素
            unset($goodSourceType[1]);
            //如果小程序类型为知识付费，分类显示为课程分类
            if($this->wxapp_cfg['ac_type'] == 27){
                $goodSourceType[0]['name'] = '课程分类';
            }
        }

        //多店版
        if($this->wxapp_cfg['ac_type'] == 8){
            $linkList = plum_parse_config('link',$config_name);
            $linkType = plum_parse_config('link_type',$config_name);
            $weedingType = plum_parse_config('link_type_community',$config_name);
            $customType  = plum_parse_config('link_type_custom',$config_name);
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];

            unset($foldType[0]); //去掉客服
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);

            $goodSourceType = array(
                array(
                    'id'   => '2',
                    'name' => '平台商品分组'
                ),
                array(
                    'id'   => '4',
                    'name' => '商家商品分组'
                ),
                array(
                    'id'   => '3',
                    'name' => '入驻店铺推荐商品'
                ),
            );
        }

        //餐饮版
        if($this->wxapp_cfg['ac_type'] == 4){
            $linkList    = plum_parse_config('link','system');
            $linkType    = plum_parse_config('link_type','system');
            $mealType    = plum_parse_config('link_type_meal','system');
            $customType  = plum_parse_config('link_type_custom','system');
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            if($this->menuType=='toutiao'){
                unset($link[12]);
                unset($link[14]);
            }
            $linkTypeArr = $linkTypeArrNew = array_merge($linkType, $customType, $mealType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //酒店版
        if($this->wxapp_cfg['ac_type'] == 7){
            $linkList    = plum_parse_config('link','system');
            $linkType    = plum_parse_config('link_type','system');
            $hotelType   = plum_parse_config('link_type_hotel','system');
            $customType  = plum_parse_config('link_type_custom','system');
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];

            $linkTypeArr = $linkTypeArrNew = array_merge($linkType, $customType, $hotelType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //知识付费
        if($this->wxapp_cfg['ac_type'] == 27){
            $linkList = plum_parse_config('link',$config_name);
            $linkType = plum_parse_config('link_type',$config_name);
            $weedingType = plum_parse_config('link_type_knowpay',$config_name);
            $customType  = plum_parse_config('link_type_custom',$config_name);
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($foldType[0]); //去掉客服
            $foldType[4] = array(
                'id'   => '49',
                'name' => '签到'
            );

            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //二手车
        if($this->wxapp_cfg['ac_type'] == 33){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $weedingType = plum_parse_config('link_type_car','system');
            $customType  = plum_parse_config('link_type_custom','system');

            unset($foldType[1]);unset($foldType[2]);unset($foldType[3]);unset($foldType[4]);
            unset($customType[1]);unset($customType[2]);

            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //社区团购
        if($this->wxapp_cfg['ac_type'] == 32){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $groupType = plum_parse_config('link_type_sequence','system');
            $customType  = plum_parse_config('link_type_custom','system');

            if($this->curr_sid != 9373){
                unset($customType[2]);
            }
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($customType[0]);
            //unset($linkType[3]);  // 去除小程序
            unset($foldType[1]);unset($foldType[2]);unset($foldType[3]);unset($foldType[4]);unset($foldType[0]); //去掉客服
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$groupType, $customType), $foldType);
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }
        //社区团购简单版
        if($this->wxapp_cfg['ac_type'] == 36){
            $linkList = plum_parse_config('link','system');



            $linkType = plum_parse_config('link_type','system');

            unset($linkType[3]);//小程序
            unset($linkType[4]);//vr全景

            $groupType = plum_parse_config('link_type_sequence','system');

            unset($groupType[3]);//秒杀商品详情

            $customType  = plum_parse_config('link_type_custom','system');

            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($customType[0]);
            //unset($linkType[3]);  // 去除小程序
            unset($foldType[1]);unset($foldType[2]);unset($foldType[3]);unset($foldType[4]);unset($foldType[0]); //去掉客服
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$groupType, $customType), $foldType);
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //教育培训
        if($this->wxapp_cfg['ac_type'] == 12){
            $linkList = plum_parse_config('link','system');
            $linkType = plum_parse_config('link_type','system');
            $groupType = plum_parse_config('link_type_train','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($linkType[3]);  // 去除小程序
            unset($foldType[1]);unset($foldType[2]);unset($foldType[3]);unset($foldType[4]);unset($foldType[0]); //去掉客服
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$groupType), $foldType);
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }


        $this->output['goodSourceType'] = json_encode($goodSourceType);
    }

    /**
     * 获取秒杀商品分组数据
     */
    private function _limit_group(){
        $where      = array();
        $where[]    = array('name' => 'alg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Limit_MysqlLimitGroupStorage($this->curr_sid);
        $sort = array('alg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['alg_id'],
                    'name' => $val['alg_name'],
                );
            }
        }
        $this->output['limitGoodsGroup'] = json_encode($data);
    }

    /**
     * 获取通用资讯文章
     */
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }

    /**
     * 获取独立商城的一级分类与2级分类
     * zhangzc
     * 2019-10-11
     * @return [type] [description]
     */
    private function _shop_independence_cate_list(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $kind2 = $kind_model->getAllSonCategory(0,0,0,[1]);
        $kind1 = $kind_model->getAllFirstCategory(0,0,0,[1]);
        $firstKindSelect=[];
        $secondKindSelect=[];
        foreach ($kind1 as $val){
            $firstKindSelect[] = array(
                'id'   => $val['sk_id'],
                'name' => $val['sk_name'],
            );
        }
        foreach ($kind2 as $val){

            $secondKindSelect[] = array(
                'id'   => $val['sk_id'],
                'name' => $val['sk_name'],
            );
        }
        $this->output['independence_kindSelect'] =json_encode($secondKindSelect);
        $this->output['independence_firstKindSelect'] =json_encode($firstKindSelect);
    }

    /**
     * 获取店铺的全部分类选择使用
     */
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        // 获取店铺的所有二级分类
        if($this->wxapp_cfg['ac_type'] == 18){
            $kind2 = $kind_model->getSonsByFid(1);
        }else if($this->wxapp_cfg['ac_type'] == 4){
             $kind2 = $kind_model->getAllSonCategory(0,0,0,[0,1]);
        }else{
            $kind2 = $kind_model->getAllSonCategory(0,0);
        }
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $goodsList = array();
                if($this->wxapp_cfg['ac_type'] == 32){
                    $goodsList = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 20, '', 0, array(), array(), 0, $val['sk_id']);
                    foreach ($goodsList as &$goods){
                        $goods['slides'] = [
                            '/public/wxapp/customtpl/images/goodsView1.jpg',
                            '/public/wxapp/customtpl/images/goodsView1.jpg',
                            '/public/wxapp/customtpl/images/goodsView1.jpg',
                        ];
                        $labels = [];
                        if(isset($goods['g_custom_label']) && $goods['g_custom_label']){
                            $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                            foreach ($labelArr as $label){
                                if($label && isset($label)){
                                    $labels[] = $label;
                                }
                            }
                        }
                        $goods['labels'] = $labels;
                    }
                }
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                    'goodsList' => $goodsList,
                );
            }
        }
        // 获取店铺的所有一级分类
        // 餐饮版本获取独立商城的分类
        if($this->wxapp_cfg['ac_type'] == 4){
            $kind1 = $kind_model->getAllFirstCategory(0,0,0,[0,1]);
        }else{
            $kind1 = $kind_model->getAllFirstCategory(0,0);
        }

        $firstKindSelect = array();
        if($this->wxapp_cfg['ac_type'] == 27){
            $firstKindSelect[] = array(
                'id' => 0,
                'name' => '无'
            );
        }
        if($kind1){
            foreach ($kind1 as $val){
                $goodsList = array();
                if($this->wxapp_cfg['ac_type'] == 32){
                    $goodsList = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 20, '', 0, array(), array(), $val['sk_id'], 0);
                    foreach ($goodsList as &$goods){
                        $goods['slides'] = [
                            '/public/wxapp/customtpl/images/goodsView1.jpg',
                            '/public/wxapp/customtpl/images/goodsView1.jpg',
                            '/public/wxapp/customtpl/images/goodsView1.jpg',
                        ];
                        $labels = [];
                        if(isset($goods['g_custom_label']) && $goods['g_custom_label']){
                            $labelArr = preg_split("/[\s,]+/",$goods['g_custom_label']);
                            foreach ($labelArr as $label){
                                if($label && isset($label)){
                                    $labels[] = $label;
                                }
                            }
                        }
                        $goods['labels'] = $labels;
                    }
                }
                $firstKindSelect[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                    'goodsList' => $goodsList,
                );
            }
        }
        if($this->wxapp_cfg['ac_type'] == 13){
            $this->output['kindSelect'] = json_encode(array_merge($firstKindSelect, $data));
        }else{
            $this->output['kindSelect'] = json_encode($data);
        }
        $this->output['allKindSelect'] = json_encode(array_merge($firstKindSelect, $data));
        if($this->wxapp_cfg['ac_type'] == 18){
            $this->output['allKindSelect'] = json_encode($data);
        }
        if($this->wxapp_cfg['ac_type'] == 6){
            $this->output['allKindSelect'] = json_encode($firstKindSelect);
        }
        $this->output['firstKindSelect'] = json_encode($firstKindSelect);
        $this->output['companySelect'] = json_encode(array());
        $this->output['oneKindSelect'] = json_encode(array());
    }

    /**
     * 保存模板配置
     */
    public function saveSettingAction(){
        $editTemplateId  = $this->request->getIntParam('editTemplateId');
        $headerTitle  = $this->request->getStrParam('headerTitle');
        $pagebgColor  = $this->request->getStrParam('pagebgColor');
        $showpostlist = $this->request->getStrParam('showpostlist');
        $showpostbtn  = $this->request->getStrParam('showpostbtn');
        $mealType     = $this->request->getStrParam('mealType');
        $settingData  = $this->request->getStrParam('data');

        //Libs_Log_Logger::outputLog("店铺".$this->curr_sid."自定义模板数据:".$settingData);
        $settingData = json_decode($settingData, true);
        foreach ($settingData as $key => $value){
            unset($settingData[$key]['typeText']);
            unset($settingData[$key]['icon']);
        }
        $template_model = new App_Model_Applet_MysqlAppletTemplateStorage();
        if($settingData){
            $data = array(
                'act_s_id' => $this->curr_sid,
                'act_header_title' => $headerTitle,
                'act_show_post_list' => $showpostlist=='true'?1:0,
                'act_show_post_btn' => $showpostbtn=='true'?1:0,
                'act_page_bgcolor' => $pagebgColor,
                'act_meal_type'   => $mealType,
                'act_data' => json_encode($settingData?$settingData:[])
            );
            $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $template = $template_model->getRow($where);

            if($template){
                $data['act_update_time'] = time();
                $ret = $template_model->updateById($data, $template['act_id']);
            }else{
                $data['act_create_time'] = time();
                $ret = $template_model->insertValue($data);
            }
            if($ret){
                if($this->wxapp_cfg['ac_type'] == 8 || $this->wxapp_cfg['ac_type'] == 6 || $this->wxapp_cfg['ac_type'] == 33){
                    //获取数据统计信息
                    $this->_save_statistics_data();
                }
                if($this->wxapp_cfg['ac_type'] == 6 ){
                    $this->_save_post_type_data();
                    $this->_save_post_tab();
                }

                if($this->wxapp_cfg['ac_type'] == 4){
                    $this->_save_meal_shop_info();
                }
                if($this->wxapp_cfg['ac_type'] == 7){
                    $this->_save_hotel_shop_info();
                }
                if($this->wxapp_cfg['ac_type'] == 27){
                    $this->_save_knowpay_tpl_info();
                }
                if($this->wxapp_cfg['ac_type'] == 28){
                    $this->_save_job_info();
                }
                if($this->wxapp_cfg['ac_type'] == 33){
                    $this->_save_car_index_tab();
                    $this->_save_post_tab();
                }
                $hadCityFenlei = false;
                if($this->wxapp_cfg['ac_type'] == 6){
                    foreach ($settingData as $key => $value){
                        if($value['type'] == 'fenlei' && !$hadCityFenlei){
                            $hadCityFenlei = true;
                            $this->_save_city_shortcut($value['flitems']);
                        }
                    }
                }

                if($editTemplateId){
                    //如果保存的是一个模板，同步修改模板的信息
                    $this->_update_costom_template($editTemplateId);
                }

                App_Helper_OperateLog::saveOperateLog("自定义模板保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
            $this->displayJson($result);
        }else{
            $this->displayJsonError('请添加模板组件');
        }
    }

    /**
     * 保存内推首页信息
     */
    private function _save_job_info(){
        $jobInfo                    = $this->request->getArrParam('jobInfo');
        $tpl['aji_award_intro']     = $jobInfo['awardIntro'];
        $tpl['aji_confirm_time']    = $jobInfo['confirmTime'];
        $tpl['aji_recommend_min']   = $jobInfo['recommendMin'];
        $tpl['aji_entry_min']       = $jobInfo['entryMin'];
        $tpl['aji_job_invite_num']  = $jobInfo['inviteNum'];
        $tpl['aji_recommended_min'] = $jobInfo['recommendedMin'];
        $tpl['aji_position_type']   = json_encode($this->request->getArrParam('positionType'),JSON_UNESCAPED_UNICODE);
        $tpl['aji_company_num']     = $jobInfo['companyNum'];
        $tpl['aji_position_num']    = $jobInfo['positionNum'];
        $tpl['aji_resume_num']      = $jobInfo['resumeNum'];
        $tpl['aji_browse_num']      = $jobInfo['browseNum'];
        $tpl['aji_stat_icon']       = $jobInfo['statIcon'];

        $tpl_model = new App_Model_Job_MysqlJobIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid(61);
        if(!empty($tpl_row)){
            $tpl_model->findUpdateBySid(61,$tpl);
        }else{
            $tpl['aji_s_id']= $this->curr_sid;
            $tpl['aji_tpl_id'] = 61;
            $tpl['aji_create_time']= time();
            $tpl_model->insertValue($tpl);
        }
    }

    /**
     * 保存知识付费首页信息
     */
    private function _save_knowpay_tpl_info(){
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid(59);
        $tpl['aki_article_cover_type'] = $this->request->getIntParam('articleCoverType', 1);
        $tpl['aki_audio_cover_type']   = $this->request->getIntParam('audioCoverType', 1);
        $tpl['aki_video_cover_type']   = $this->request->getIntParam('videoCoverType', 2);
        if(!empty($tpl_row)){
            $tpl_model->findUpdateBySid(59,$tpl);
        }else{
            $tpl['aki_tpl_id']     = 59;
            $tpl['aki_s_id']       = $this->curr_sid;
            $tpl['aki_create_time']= time();
            $tpl_model->insertValue($tpl);
        }
    }

    /**
     *保存首页帖子tab
     */
    private function _save_post_tab($tpl_id = 0){
        $tabInfo = $this->request->getArrParam('tabList');
        $tab_storage = new App_Model_City_MysqlCityPostTabStorage($this->curr_sid);
        if(!empty($tabInfo)){
            $tab_list = $tab_storage->fetchShortcutShowList($tpl_id);
            if(!empty($tab_list)){
                $del_id = array();
                foreach($tab_list as $val){
                    if(isset($tabInfo[$val['acpt_weight']])){  //存在这个位置的活动，更新
                        $set = array(
                            'acpt_weight'            => $tabInfo[$val['acpt_weight']]['index'],
                            'acpt_name'             => $tabInfo[$val['acpt_weight']]['name'],
                            'acpt_link'        => $tabInfo[$val['acpt_weight']]['link'],
                            'acpt_link_type'     => $tabInfo[$val['acpt_weight']]['type'],
                        );
                        $up_ret = $tab_storage->updateById($set,$val['acpt_id']);
                        unset($tabInfo[$val['acpt_weight']]); //然后清理前端传过来的活动
                    }else{ //多余的删除
                        $del_id[] = $val['acpt_id'];
                    }
                }
                if(!empty($del_id)){
                    $tab_where = array();
                    $tab_where[] = array('name' => 'acpt_id','oper' => 'in' , 'value' => $del_id);
                    $tab_where[] = array('name' => 'acpt_tpl_id','oper' => '=' , 'value' => $tpl_id);
                    $del_ret = $tab_storage->deleteValue($tab_where);
                }

            }

            //新增的课程
            if(!empty($tabInfo)){
                $insert = array();
                foreach($tabInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$tpl_id}','{$val['name']}','','{$val['link']}','{$val['type']}','{$val['index']}','1','0','".time()."') ";
                }
                $ins_ret = $tab_storage->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺通知
            $where   = array();
            $where[] = array('name' => 'acpt_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acpt_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $del     = $tab_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 保存餐饮配置信息
     */
    public function _save_meal_shop_info(){
        $shopInfo     = $this->request->getArrParam('shopInfo');
        $data = array(
            'ami_s_id'          => $this->curr_sid,
            'ami_tpl_id'        => 12,
            'ami_nav1_head_img' => $shopInfo['nav1HeadImg'],
            'ami_nav2_head_img' => $shopInfo['nav2HeadImg'],
            'ami_nav3_head_img' => $shopInfo['nav3HeadImg'],
            'ami_average_spend' => $shopInfo['spend'],
            'ami_post_limit'    => $shopInfo['limit'],
            'ami_post_fee'      => $shopInfo['postFee'],
            'ami_post_range'    => $shopInfo['postRange'],
            'ami_avg_send_time' => $shopInfo['avgSendTime'],
            'ami_open_time'     => $shopInfo['openStartTime'].'-'.$shopInfo['openEndTime'],
            'ami_payment_money' => $shopInfo['paymentMoney'],
            'ami_tableware_fee' => $shopInfo['tablewareFee'],
            'ami_update_time'   => time(),
            'ami_lng'           => $shopInfo['longitude'],
            'ami_lat'           => $shopInfo['latitude'],
            'ami_address'       => $shopInfo['address'],
        );

        $tpl_model = new App_Model_Meal_MysqlMealIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid(12);
        if(!empty($tpl_row)){
            $tpl_model->findUpdateBySid(12,$data);
        }else{
            $tpl['ami_create_time']= time();
            $tpl_model->insertValue($data);
        }
    }


    /**
     * 保存酒店配置信息
     */
    public function _save_hotel_shop_info(){
        $hotelInfo     = $this->request->getArrParam('hotelInfo');
        $data = array(
            'ahi_s_id'          => $this->curr_sid,
            'ahi_tpl_id'         => 27,
            'ahi_cancel_prompt' => $hotelInfo['cancelPrompt'],
            'ahi_trade_remind'  => $hotelInfo['tradeRemind'],
        );

        $tpl_model = new App_Model_Hotel_MysqlHotelIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid(27);
        if(!empty($tpl_row)){
            $tpl_model->findUpdateBySid(27,$data);
        }else{
            $tpl['ahi_create_time']= time();
            $tpl_model->insertValue($data);
        }
    }

    /**
     * 保存快捷导航
     */
    private function _save_city_shortcut($shortcut){
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList(1);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($shortcut as $key => $v){
                        if($v['id'] == $val['acc_id']){
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'acc_sort'  => $index,
                            'acc_title' => $shortcut[$index]['name'],
                            'acc_img'   => $shortcut[$index]['icon'],
                            'acc_service_type'=> $shortcut[$index]["link"]['type'],
                            'acc_price'       => $shortcut[$index]['price'],
                            'acc_link_url'    => $shortcut[$index]["link"]['url'],
                            'acc_mobile_show' => isset($shortcut[$index]['mobileShow']) && $shortcut[$index]['mobileShow'] && $shortcut[$index]['mobileShow'] =='true' ? 1 : 0 ,
                            'acc_address_show' => isset($shortcut[$index]['addressShow']) && $shortcut[$index]['addressShow'] && $shortcut[$index]['addressShow'] =='true' ? 1 : 0,
                            'acc_allow_comment' => isset($shortcut[$index]['allowComment']) && $shortcut[$index]['allowComment'] && $shortcut[$index]['allowComment'] =='true' ? 1 : 0,
                            'acc_verify_comment' => isset($shortcut[$index]['verifyComment']) && $shortcut[$index]['verifyComment'] && $shortcut[$index]['verifyComment'] =='true' ? 1 : 0,
                            'acc_isshow' => isset($shortcut[$index]['isshow']) && $shortcut[$index]['isshow'] && $shortcut[$index]['isshow'] =='true' ? 1 : 0
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['acc_id']);
                        unset($shortcut[$index]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['acc_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'acc_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_where[] = array('name' => 'acc_type','oper' => '=' , 'value' => 1);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }

            //新增的快捷导航
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $key => $val){
                    $mobileShow = isset($val['mobileShow']) && $val['mobileShow'] && $val['mobileShow']=='true' ? 1 : 0;
                    $addressShow = isset($val['addressShow']) && $val['addressShow'] && $val['addressShow']=='true' ? 1 : 0;
                    $allowComment = isset($val['allowComment']) && $val['allowComment'] && $val['allowComment']=='true' ? 1 : 0;
                    $verifyComment = isset($val['verifyComment']) && $val['verifyComment'] && $val['verifyComment']=='true' ? 1 : 0;
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['name']}', '1', '{$val['icon']}', '{$key}', '{$val['link']['type']}','{$val['price']}','{$mobileShow}','{$addressShow}','{$allowComment}','{$verifyComment}','{$val['link']['url']}','0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatchPostCategory($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'acc_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acc_type','oper' => '=' , 'value' => 1);
            $shortcut_model->deleteValue($where);
        }
    }

    /**
     * 保存数据统计信息
     */
    private function _save_statistics_data(){
        $browseNum    = $this->request->getIntParam('browseNum');    // 浏览量
        $issueNum     = $this->request->getIntParam('issueNum');    // 发布量
        $shopNum      = $this->request->getIntParam('shopNum');    // 店铺数量
        $addMemberNum = $this->request->getIntParam('addMemberNum');    // 增加的会员数量
        $statIcon     = $this->request->getStrParam('statIcon'); //数据统计图标

        $data = array(
            'aci_browse_num'    => $browseNum,
            'aci_issue_num'     => $issueNum ,
            'aci_shop_num'      => $shopNum,
            'aci_add_member'    => $addMemberNum,
            'aci_stat_icon'     => $statIcon,
            'aci_update_time'   => time()
        );

        if($this->wxapp_cfg['ac_type'] == 8){
            $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
            $tpl_row   = $tpl_model->findUpdateBySid(35);
            if(!empty($tpl_row)){
                $tpl_model->findUpdateBySid(35,$data);
            }else{
                $data['aci_s_id']= $this->curr_sid;
                $data['aci_tpl_id'] = 35;
                $tpl['aci_create_time']= time();
                $tpl_model->insertValue($data);
            }
        }
        if($this->wxapp_cfg['ac_type'] == 6){
            $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $tpl_row   = $index_storage->findUpdateBySid(23);
            if(!empty($tpl_row)){
                $index_storage->findUpdateBySid(23,$data);
            }else{
                $data['aci_s_id']= $this->curr_sid;
                $data['aci_tpl_id'] = 23;
                $data['aci_create_time']= time();
                $index_storage->insertValue($data);
            }
        }
    }

    /**
     * 保存数据统计信息
     */
    private function _save_post_type_data(){
        $postType     = $this->request->getArrParam('postType');
        $data['aci_post_type'] = json_encode($postType,JSON_UNESCAPED_UNICODE);
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $tpl_row   = $index_storage->findUpdateBySid(23);
        if(!empty($tpl_row)){
            $index_storage->findUpdateBySid(23,$data);
        }else{
            $data['aci_s_id']= $this->curr_sid;
            $data['aci_tpl_id'] = 23;
            $data['aci_create_time']= time();
            $ret = $index_storage->insertValue($data);
        }

    }

    private function _save_car_index_tab(){
        $carCfg     = $this->request->getArrParam('carCfg');
        $data['acc_index_tab'] = json_encode($carCfg,JSON_UNESCAPED_UNICODE);
        $index_storage = new App_Model_Car_MysqlCarCfgStorage($this->curr_sid);
        $tpl_row   = $index_storage->findUpdateBySid();
        if(!empty($tpl_row)){
            $index_storage->findUpdateBySid($data);
        }else{
            $data['acc_s_id']= $this->curr_sid;
            $data['acc_create_time']= time();
            $ret = $index_storage->insertValue($data);
        }

    }

    /**
     * 模版启用
     */
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');

        $set = array(
            'ac_index_tpl'   => $id,
            'ac_update_time' => time()
        );
        //获取配置信息
       // if($this->menuType=='bdapp'){
       //     $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($this->curr_sid);
       // }elseif ($this->menuType=='aliapp'){
       //     $applet_cfg = new App_Model_Alixcx_MysqlAlixcxCfgStorage($this->curr_sid);
       // }else if($this->menuType == 'toutiao'){
       //     $applet_cfg   = new App_Model_Toutiao_MysqlToutiaoCfgStorage($this->curr_sid);
       // }else{
       //     $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
       // }
       // $ret = $applet_cfg->findShopCfg($set);
        $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $ret = $applet_cfg->findShopCfg($set);
        if($ret){
            $result     = array(
                'ec'    => 200,
                'em'    => ' 启用成功'
            );
        }else{
            $result['em'] = '启用失败';
        }

        App_Helper_OperateLog::saveOperateLog("自定义模板启用成功");

        $this->displayJson($result);
    }

    /**
     * 同步修改模板
     */
    public function _update_costom_template($id){
        $headerTitle  = $this->request->getStrParam('headerTitle');
        $showpostlist = $this->request->getStrParam('showpostlist');
        $showpostbtn  = $this->request->getStrParam('showpostbtn');
        $pagebgColor  = $this->request->getStrParam('pagebgColor');
        $settingData  = $this->request->getStrParam('data');
        $image        = $this->request->getStrParam('image');
        if($settingData && $id){
            $filepath = '';
            if($image){
                if (strstr($image,",")){
                    $image = explode(',',$image);
                    $image = $image[1];
                }
                $im     = imagecreatefromstring(base64_decode($image));
                $filename   = plum_uniqid_base36(true).".jpg";
                imagejpeg($im, PLUM_APP_BUILD."/".$filename);
                imagedestroy($im);
                $filepath   = '/public/build/'.$filename;
            }
            $settingData = json_decode($settingData, true);
            $data = array(
                'act_s_id'           => $this->curr_sid,
                'act_header_title'   => $headerTitle,
                'act_show_post_list' => $showpostlist=='true'?1:0,
                'act_show_post_btn'  => $showpostbtn=='true'?1:0,
                'act_page_bgcolor'   => $pagebgColor,
                'act_cover'          => $filepath,
                'act_data'           => json_encode($settingData?$settingData:[])
            );
            $template_model = new App_Model_Applet_MysqlAppletCommonTemplateStorage();

            if($id){
                $template_model->updateById($data, $id);
            }
        }
    }

    /**
     * 存储为模板
     */
    public function save2TemplateAction(){
        $headerTitle  = $this->request->getStrParam('headerTitle');
        $showpostlist = $this->request->getStrParam('showpostlist');
        $showpostbtn  = $this->request->getStrParam('showpostbtn');
        $pagebgColor = $this->request->getStrParam('pagebgColor');
        $settingData = $this->request->getStrParam('data');
        $image       = $this->request->getStrParam('image');
        $name        = $this->request->getStrParam('name');
        if($settingData){
            $filepath = '';
            if($image){
                if (strstr($image,",")){
                    $image = explode(',',$image);
                    $image = $image[1];
                }
                $im     = imagecreatefromstring(base64_decode($image));
                $filename   = plum_uniqid_base36(true).".jpg";
                imagejpeg($im, PLUM_APP_BUILD."/".$filename);
                imagedestroy($im);
                $filepath   = '/public/build/'.$filename;
            }
            $settingData = json_decode($settingData, true);
            $data = array(
                'act_s_id' => $this->curr_sid,
                'act_header_title' => $headerTitle,
                'act_show_post_list' => $showpostlist=='true'?1:0,
                'act_show_post_btn' => $showpostbtn=='true'?1:0,
                'act_page_bgcolor' => $pagebgColor,
                'act_cover'        => $filepath,
                'act_remark_name'  => $name,
                'act_data' => json_encode($settingData?$settingData:[])
            );
            $template_model = new App_Model_Applet_MysqlAppletCommonTemplateStorage();
            $data['act_create_time'] = time();
            $ret = $template_model->insertValue($data);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("自定义模板【".$name."】保存成功");
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
            $this->displayJson($result);
        }else{
            $this->displayJsonError('请添加模板组件');
        }
    }

    /**
     * 删除模板
     */
    public function delTemplateAction(){
        $id  = $this->request->getIntParam('id');
        $set = array('act_deleted' => 1);
        $template_model = new App_Model_Applet_MysqlAppletCommonTemplateStorage();
        $template = $template_model->getRowById($id);
        App_Helper_OperateLog::saveOperateLog("自定义模板【".$template['act_remark_name']."】删除成功");
        $ret = $template_model->updateById($set, $id);
        $this->showAjaxResult($ret, '删除');
    }

    /*
     * 获得培训版课程分类
     */
    private function _get_train_lesson_type(){
        $type_storage = new App_Model_Train_MysqlTrainCourseTypeStorage($this->curr_sid);
        $data = [];
        $list = $type_storage->findListBySid();
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'id' => $val['att_id'],
                    'name' => $val['att_name']
                ];
            }
        }
        $this->output['lessonType'] = json_encode($data);
    }

    /**
     * @param bool $return
     * @return array
     * 获得菜单列表
     */
    private function _get_menu_list($return = false){
        $data = [];
        $menu_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->curr_sid);
        $where[] = array('name' => 'asm_s_id','oper' => '=','value' =>$this->curr_sid);
        $list = $menu_model->getList($where,0,0,[],['asm_id','asm_title']);
        if($list){
            foreach ($list as $val){
                $data[] = [
                    'id' => $val['asm_id'],
                    'title' => $val['asm_title']
                ];
            }
        }
        if($return){
            return $data;
        }else{
            $this->output['menuList'] = json_encode($data);
        }
    }

}

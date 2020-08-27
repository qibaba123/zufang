<?php
/**
 * 弹出层 引导图
 */
class App_Controller_Wxapp_PopupController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();
    }

    /*
     * 弹出层配置列表
     */
    public function popupListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $popup_model = new App_Model_Applet_MysqlAppletPopupStorage($this->curr_sid);
        $where[] = array('name'=>'ap_s_id','oper'=>'=','value'=>$this->curr_sid);

        $list = $popup_model->getList($where,$index,$this->count,array('ap_update_time'=>'desc'));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '弹出层管理', 'link' => '#'),
        ));
        $total = $popup_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['list'] = $list;

        $typeNote = array(
            1 => '每7天弹出1次',
            2 => '每天弹出1次'
        );
        $timeTypeNote = array(
            1 => '天',
            2 => '小时'
        );
        $this->output['typeNote'] = $typeNote;
        $this->output['timeTypeNote'] = $timeTypeNote;
        $this->_get_list_for_select();
        $this->_shop_goods_list();
        $this->_shop_information();
        $this->_get_auction_list();
        //资讯分类
        $this->_shop_information_category();
        $this->_shop_kind_list_for_select();
        $this->_get_jump_list();
        $this->_group_list_for_select(); //获取拼团商品列表
        $this->_limit_list_for_select(); //获取秒杀商品列表
        $this->_bargain_list_for_select(); //获取砍价商品列表
        //付费预约商品
        $this->_shop_appointment_goods_list();
        //获取企业服务分类//获取商品分组
        $this->goodsGroup();
        $this->_shop_service_category();
        $this->_shop_service_article();
        //获取游戏分类
        $this->_game_category();
        //获得小游戏
        $this->_get_game_for_select();
        //同城
        $this->_get_post_type();
        $this->_get_post_category();
        $this->_show_category(1, 1); //商品分类
        $this->_show_category(2, 1); //专家分类
        $this->_show_expert_list();//专家列表
        //餐饮
        $this->_meal_shop_info();
        //获得跳转小程序
        $this->_get_jump_list();
        $this->_get_car_resource();
        $this->_get_car_shop_category();
        $this->_get_quotation_list();
        $this->_get_knowpay_index(); //获取知识付费首页配置
        $this->_shop_list_for_select(); //获取店铺列表
        $this->_show_hotel_link_list();
        $this->_community_shop_kind_list_for_select(); //获取店铺分类列表

        $this->_get_position_list();             // 职位列表
        $this->_get_custom_form_list();
        //内推分类
        if($this->wxapp_cfg['ac_type'] == 28){
            $this->_job_kind_list_for_select();
        }


        $page_list = $this->_fetch_page_data();
        $this->output['page_list'] = json_encode($page_list);
        $this->displaySmarty('wxapp/currency/popup-list.tpl');
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


    private function _fetch_page_data(){
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();
        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type']);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                $path = $val['ap_path'];
                if($val['ap_path'] == "pages/generalFormTab/generalFormTab"){
                    $path = str_replace('generalFormTab', 'generalForm', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/groupIndex/groupIndex"){
                    $path = str_replace('groupIndex', 'groupIndexPage', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/goodIndex/goodIndex"){
                    $path = str_replace('goodIndex', 'goodIndexPage', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/seckillPage/seckillPage"){
                    $path = str_replace('seckillPage', 'seckillPageShow', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/storeMember/storeMember"){
                    $path = str_replace('pages/storeMember/storeMember', 'subpages/memberCard/memberCard', $val['ap_path']);
                }
                if($val['ap_path'] == "pages/distributionCenterTab/distributionCenterTab"){
                    if(in_array($this->wxapp_cfg['ac_type'],array(21,8,6))){
                        $path = 'subpages0/distributionCenter/distributionCenter';
                    }else{
                        $path = str_replace('distributionCenterTab', 'distributionCenter', $val['ap_path']);
                    }
                }
                $page_data[] = array(
                    'path' => $path,
                    'name' => $val['ap_desc']." （".$path."）"
                );
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

    private function _show_hotel_link_list(){
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $list = $category_storage->getListBySid();
        $categoryList = array();
        if($list){
            foreach ($list as $key => $val){
                $categoryList[] = array(
                    'link' => "/pages/informationSpecial/informationSpecial?id=".$val['aic_id']."&title=".$val['aic_name'],
                    'name' => $val['aic_name']
                );
            }
        }
        $menu = array(
            array(
                'name' => '无连接',
                'link' => ''
            ),
            array(
                'name' => '拼团',
                'link' => '/pages/groupIndexPage/groupIndexPage?title=拼团'
            ),
            array(
                'name' => '秒杀',
                'link' => '/pages/seckillPageShow/seckillPageShow?title=秒杀'
            ),
            array(
                'name' => '砍价',
                'link' => '/subpages/bargainIndexPage/bargainIndexPage?title=砍价'
            ),
        );

        $categoryList = array_merge($menu,$categoryList);
        $this->output['hotelLinkLists'] = json_encode($categoryList);
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

    private function _get_knowpay_index(){
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(59);
        $this->output['articleCoverType'] = $tpl['aki_article_cover_type'];
        $this->output['audioCoverType']   = $tpl['aki_audio_cover_type'];
        $this->output['videoCoverType']   = $tpl['aki_video_cover_type'];
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

    /**
     * 获取店铺的全部分类选择使用
     */
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        // 获取店铺的所有二级分类
        if($this->wxapp_cfg['ac_type'] == 18){
            $kind2 = $kind_model->getSonsByFid(1);
        }else{
            $kind2 = $kind_model->getAllSonCategory(0,0);
        }
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $goodsList = array();
                if($this->wxapp_cfg['ac_type'] == 32){
                    $goodsList = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 20, '', 0, array(), array(), 0, $val['sk_id']);
                }
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name'],
                    'goodsList' => $goodsList,
                );
            }
        }
//        //获取店铺的所有一级分类
        $kind1 = $kind_model->getAllFirstCategory(0,0);
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


    /*
     * 获得平台商品一级分类
     */
    private function _curr_first_kind_list_for_select(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllFirstCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['currFirstKindSelect'] = json_encode($data);

    }
    /*
    * 获得平台商品二级分类
    */
    private function _curr_second_kind_list_for_select(){
        $kind_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $list = $kind_model->getAllSonCategory();
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['currSecondKindSelect'] = json_encode($data);
    }


    /*
     * 获得全部文章分类
     */
    private function _get_information_category(){
        $data = array();
        $category_storage = new App_Model_Applet_MysqlAppletInformationCategoryStorage($this->curr_sid);
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'aic_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $category_storage->getList($where,0,0,array('aic_create_time'=>'DESC'));
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['aic_id'],
                    'name' => $val['aic_name']
                );
            }
        }
        $this->output['infocateList'] = json_encode($data);
        $this->output['infocateSelect'] = $data;
    }

    /**
     * 获取店铺促销商品,推荐商品选择推荐商品使用
     */
    private function _shop_goods_list(){
        $test = $this->request->getIntParam('test');
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        //只获得推荐商品
//        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,50,'',1,array(),array(),0,0,0);
        //获得全部商品  推荐在前
        $where = [];
//        if($this->menuType == 'toutiao' && $this->curr_shop['s_entershop_goods_verify'] == 1){
//            $where[]     = array('name' => 'g_is_sale', 'oper' => 'not in', 'value' =>[4,5]);
//        }

        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,100,'',0,array('g_is_top' => 'DESC','g_update_time' => 'DESC'),[],0,0,1,$where);
        $data = array();
        $dataSelect = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
//                $dataSelect[$val['g_id']] = array(
//                    'id'   => $val['g_id'],
//                    'name' => $val['g_name'],
//                );
            }
        }
        $this->output['goodsList'] = json_encode($data);
        //$this->output['goodsSelect'] = $dataSelect;
    }

    /*
     * 获得资讯列表
     */
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,0,$sort);
        $data = array();
        $dataSelect = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
//                $dataSelect[$val['ai_id']] = array(
//                    'id'      => $val['ai_id'],
//                    'title'   => $val['ai_title'],
//                    'brief'   => $val['ai_brief'],
//                    'cover'   => $val['ai_cover']
//                );
            }
        }
        $this->output['information'] = json_encode($data);
        //$this->output['informationSelect'] = $dataSelect;
    }

    /*
     * 获得拍卖详情
     */
    private function _get_auction_list(){
        $data = array();
        $dataSelect = array();
        $auction_model = new App_Model_Auction_MysqlAuctionListStorage($this->curr_sid);
        $where[] = array('name'=>'aal_s_id','oper'=>'=','value'=>$this->curr_sid);
        $list = $auction_model->getList($where,0,0);
        foreach ($list as $val){
            $data[] = array(
                'id' => $val['aal_id'],
                'name' => $val['aal_title']
            );
//            $dataSelect[$val['aal_id']] = array(
//                'id' => $val['aal_id'],
//                'name' => $val['aal_title']
//            );
        }
        $this->output['auctionList'] = json_encode($data);
        //$this->output['auctionSelect'] = $dataSelect;
    }

    /**
     * 获取列表以供使用
     */
    private function _get_list_for_select(){
        $foldType = plum_parse_config('fold_menu','system');
        $this->output['linkTypeNew'] = array();
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        //基础商城和营销商城
        if($this->wxapp_cfg['ac_type'] == 1 || $this->wxapp_cfg['ac_type'] == 21){

            $weedingType = plum_parse_config('link_type_goods','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($linkType[0]);  // 去除资讯单页
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType, $customType));
            unset($foldType[0]); //去掉客服

            if($this->wxapp_cfg['ac_type'] == 21){
                $allMallType = plum_parse_config('link_type_all_mall','system');
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $allMallType, $customType), $foldType));
            }else{
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $customType), $foldType));
            }
        }

        //门店
        if($this->wxapp_cfg['ac_type'] == 13){

            $weedingType = plum_parse_config('link_type_cake','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType, $customType));

            unset($foldType[0]); //去掉客服
            $allMallType = plum_parse_config('link_type_all_mall','system');
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$weedingType, $allMallType, $customType), $foldType));

        }

        //企业
        if($this->wxapp_cfg['ac_type'] == 3){

            $enterpriseType = plum_parse_config('link_type_enterprise','system');
            $customType  = plum_parse_config('link_type_custom','system');
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

            unset($foldType[0]); //去掉客服
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$enterpriseType, $customType), $foldType));
        }

        //预约服务
        if($this->wxapp_cfg['ac_type'] == 18){
            /*if($this->menuType == 4 && $this->wxapp_cfg['ac_type'] == 18){
                $this->output['dyyu'] = true;
            }*/

            $reserType = plum_parse_config('link_type_reserva','system');
            $customType  = plum_parse_config('link_type_custom','system');
            unset($customType[2]);
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge($linkType,$reserType, $customType));
            unset($foldType[0]); //去掉客服
            $allMallType = plum_parse_config('link_type_all_mall','system');
            if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] == 18){
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$reserType, $customType), $foldType));
            }else{
                $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$reserType, $allMallType, $customType), $foldType));
            }

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
        if($this->wxapp_cfg['ac_type'] == 32){
            unset($goodSourceType[1]);
        }

        //同城
        if($this->wxapp_cfg['ac_type'] == 6){

            $linkTypeNew = $linkType;
            $groupType = plum_parse_config('link_type_city','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($linkType[0]);  // 去除资讯单页

            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode(array_merge(array_merge($linkType,$groupType), $foldType));
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

            $weedingType = plum_parse_config('link_type_community','system');
            $customType  = plum_parse_config('link_type_custom','system');
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

            $mealType    = plum_parse_config('link_type_meal','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];

            $linkTypeArr = $linkTypeArrNew = array_merge($linkType, $customType, $mealType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);

        }

        //知识付费
        if($this->wxapp_cfg['ac_type'] == 27){

            $weedingType = plum_parse_config('link_type_knowpay','system');
            $customType  = plum_parse_config('link_type_custom','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            unset($foldType[0]); //去掉客服
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //二手车
        if($this->wxapp_cfg['ac_type'] == 33){

            $weedingType = plum_parse_config('link_type_car','system');
            $customType  = plum_parse_config('link_type_custom','system');

            unset($foldType[1]);unset($foldType[2]);unset($foldType[3]);unset($foldType[4]);

            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$weedingType, $customType), $foldType);
            $this->output['linkList'] = json_encode(array_merge($link));
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //社区团购
        if($this->wxapp_cfg['ac_type'] == 32){

            $groupType = plum_parse_config('link_type_sequence','system');
            $link = $linkList[$this->wxapp_cfg['ac_type']];
            //unset($linkType[3]);  // 去除小程序
            unset($foldType[1]);unset($foldType[2]);unset($foldType[3]);unset($foldType[4]);
            $linkTypeArr = $linkTypeArrNew = array_merge(array_merge($linkType,$groupType), $foldType);
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        //内推招聘
        if($this->wxapp_cfg['ac_type'] == 28){
            $groupType = plum_parse_config('link_type_job','system');

            $link = $linkList[$this->wxapp_cfg['ac_type']];
            $linkTypeArr = $linkTypeArrNew = array_merge($linkType,$groupType);
            $this->output['linkList'] = json_encode($link);
            $this->output['linkType'] = json_encode($linkTypeArr);
            $this->output['linkTypeNew'] = json_encode($linkTypeArrNew);
        }

        if($this->wxapp_cfg['ac_type'] == 7){
            //酒店版为空
            $this->output['linkList'] = json_encode([]);
            $this->output['linkType'] = json_encode([]);
        }

        $this->output['goodSourceType'] = json_encode($goodSourceType);
    }

    /*
     * 保存弹出层配置
     */
    public function popupSaveAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getIntParam('id');
        $cover = $this->request->getStrParam('cover');
        $linkPath = $this->request->getStrParam('link_path');
        $linkType = $this->request->getIntParam('link_type',1);
        $showIndex = $this->request->getIntParam('showIndex',0);
        $showType  = $this->request->getIntParam('showType',2);
        $timeType  = $this->request->getIntParam('timeType',1);
        $timeValue = $this->request->getIntParam('timeValue',1);

        if($this->wxapp_cfg['ac_type'] == 7){
            //酒店版只有链接
            $linkType = 2;
        }

        if($cover){
            $data = array(
                'ap_s_id'       => $this->curr_sid,
                'ap_path'       => $cover,
                'ap_link'       => $linkPath,
                'ap_link_type'  => $linkType,
                'ap_show'       => $showIndex,
                'ap_show_type'  => $showType,
                'ap_time_type'  => $timeType,
                'ap_time_value'  => $timeValue,
                'ap_update_time'=> time(),
            );
            $popup_model = new App_Model_Applet_MysqlAppletPopupStorage($this->curr_sid);
            if($id){
                $res = $popup_model->updateById($data,$id);
            }else{
                $data['ap_create_time'] = time();
                $res = $id = $popup_model->insertValue($data);
            }

            if($res){
                if($showIndex == 1){
                    //将其它弹出层改为不弹出
                    $where[] = array('name'=>'ap_s_id','oper'=>'=','value'=>$this->curr_sid);
                    $where[] = array('name'=>'ap_id','oper'=>'!=','value'=>$id);
                    $popup_model->updateValue(array('ap_show' => 0),$where);
                }
                App_Helper_OperateLog::saveOperateLog("弹窗图片配置信息修改成功");
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '请上传图片'
            );
        }

        $this->displayJson($result);
    }

    public function popupChangShowAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status',0);
        $popup_model = new App_Model_Applet_MysqlAppletPopupStorage($this->curr_sid);
        if($status == 1){
            //将所有弹出层改为不弹出
            $where[] = array('name'=>'ap_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'ap_id','oper'=>'!=','value'=>$id);
            $popup_model->updateValue(array('ap_show' => 0),$where);
        }
        $res = $popup_model->updateById(array('ap_show'=>$status),$id);

        if($res){
            $str = $status == 1 ? '显示' : '隐藏';
            App_Helper_OperateLog::saveOperateLog("{$str}指定弹窗成功");
        }

        $this->showAjaxResult($res,'操作');
    }



    /*
     * 删除弹出层
     */
    public function popupDeleteAction(){
        $id = $this->request->getIntParam('id');
        $popup_model = new App_Model_Applet_MysqlAppletPopupStorage($this->curr_sid);
        $res = $popup_model->deleteBySidId($id,$this->curr_sid);

        if($res){
            App_Helper_OperateLog::saveOperateLog("弹窗删除成功");
        }

        $this->showAjaxResult($res,'删除');
    }

    /*
     * 首页启动图
     */
    public function startImgListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $startimg_model = new App_Model_Applet_MysqlAppletStartImgStorage($this->curr_sid);
        $where[] = array('name'=>'asi_s_id','oper'=>'=','value'=>$this->curr_sid);

        $list = $startimg_model->getList($where,$index,$this->count,array('asi_update_time'=>'desc'));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '引导图管理', 'link' => '#'),
        ));
        $total = $startimg_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['list'] = $list;
        $this->displaySmarty('wxapp/currency/startimg-list.tpl');
    }

    /*
     * 保存弹出层配置
     */
    public function startImgSaveAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getIntParam('id',0);
        $cover = $this->request->getStrParam('cover');
        $showIndex = $this->request->getIntParam('indexShow',0);
        $time = $this->request->getIntParam('time',0);


        if( 1 > $time || $time > 10){
            $this->displayJsonError('时间请填写1-10秒的整数');
        }

        if($cover){
            $data = array(
                'asi_s_id'       => $this->curr_sid,
                'asi_path'       => $cover,
                'asi_show'       => $showIndex,
                'asi_time'       => $time,
                'asi_update_time'=> time(),
            );
            $startimg_model = new App_Model_Applet_MysqlAppletStartImgStorage($this->curr_sid);
            if($id){
                $res = $startimg_model->updateById($data,$id);
            }else{
                $res = $id = $startimg_model->insertValue($data);
            }
            if($res){
                if($showIndex == 1){
                    //将其它弹出层改为不弹出
                    $where[] = array('name'=>'asi_s_id','oper'=>'=','value'=>$this->curr_sid);
                    $where[] = array('name'=>'asi_id','oper'=>'!=','value'=>$id);
                    $startimg_model->updateValue(array('asi_show' => 0),$where);
                }
                App_Helper_OperateLog::saveOperateLog("启动图配置信息修改成功");
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '请上传图片'
            );
        }

        $this->displayJson($result);
    }



    /*
     * 删除弹出层
     */
    public function startImgDeleteAction(){
        $id = $this->request->getIntParam('id');
        $startimg_model = new App_Model_Applet_MysqlAppletStartImgStorage($this->curr_sid);
        $res = $startimg_model->deleteBySidId($id,$this->curr_sid);

        if($res){
            App_Helper_OperateLog::saveOperateLog("启动图删除成功");
        }

        $this->showAjaxResult($res,'删除');
    }

    public function startImgChangShowAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $startimg_model = new App_Model_Applet_MysqlAppletStartImgStorage($this->curr_sid);
        //将所有图片改为不展示
        if($status == 1){
            $where[] = array('name'=>'asi_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'asi_id','oper'=>'!=','value'=>$id);
            $startimg_model->updateValue(array('asi_show' => 0),$where);
        }

        //将当前图片改为展示
        $res = $startimg_model->updateById(array('asi_show'=>$status),$id);

        if($res){
            $str = $status == 1 ? '显示' : '隐藏';
            App_Helper_OperateLog::saveOperateLog("{$str}指定启动图成功");
        }

        $this->showAjaxResult($res,'操作');
    }

}
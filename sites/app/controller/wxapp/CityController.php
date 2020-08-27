<?php


class App_Controller_Wxapp_CityController extends App_Controller_Wxapp_InitController {

    const PROMOTION_TOOL_KEY    = 'sjfx';
    const WEIXIN_PAT_REDPACK    = 1;//微信红包形式
    const WEIXIN_PAY_TRANSFER   = 2;//微信企业转账到零钱
    const WEIXIN_PAY_BANK       = 3;//微信企业转账到银行卡

    public function __construct() {
        parent::__construct();

    }


    
    public function cityTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[6]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $this->wxapp_cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $this->wxapp_cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/city/city-template.tpl');
    }


    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 23);
        $this->_shop_default_tpl();
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_shop_information();
        $this->showShortcut();
        $this->_show_tpl_notice();
        $this->_get_list_for_select('index');
        $this->_shop_top_goods_list();
        $this->_shop_list();
        $this->_recommend_shop_near();
        $this->_show_info();
        $this->_curr_first_kind_list_for_select();
        $this->_curr_second_kind_list_for_select();
        $this->_shop_category(2);
        $this->_get_jump_list();
        $this->_get_information_category();
        $this->_post_tab();
        $this->_limit_list_for_select();
        $this->_bargain_list_for_select();
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();
        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type']);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                $page_data[] = array(
                    'path' => $val['ap_path'],
                    'name' => $val['ap_desc']
                );
            }
        }
        $this->output['page_list'] = json_encode($page_data);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '同城首页配置', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/city/index-tpl_'.$tpl_id.'.tpl');


    }
    
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
    
    
    private function _get_list_for_select($type = ''){
        $linkList = plum_parse_config('link','system');
        $linkType = $linkTypeNew = plum_parse_config('link_type','system');
        $groupType = plum_parse_config('link_type_city','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        unset($linkType[0]);

        if($type == 'mall'){
            unset($groupType[0]);
            $mallType  = plum_parse_config('link_city_mall','system');
            $this->output['mallType'] = json_encode($mallType);
        }

        if($type == 'index'){
            $groupType[] = [
                'id' => '59',
                'name' => '商家秒杀详情'
            ];
            $groupType[] = [
                'id' => '60',
                'name' => '商家砍价详情'
            ];
            $groupType[] = [
                'id'   => '105',
                'name' => '签到'
            ];
        }


        $groupType[] = array(
            'id' => '40',
            'name' => '帖子分类'
        );


        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkType,$groupType));
        $this->output['linkTypeNew'] = json_encode(array_merge($linkTypeNew,$groupType));
    }

    
    private function _limit_list_for_select(){
        $limit_model = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
        $list    = $limit_model->getAllRunningNotBeginActGoods([],0,0);
        $data = [];
        $data_shop = [];
        foreach($list as $val){
            if($val['g_es_id'] > 0){
                $data_shop[]= array(
                    'id'    => $val['g_id'],
                    'name'  => $val['g_name'],
                );
            }else{
                $data[]= array(
                    'id'    => $val['g_id'],
                    'name'  => $val['g_name'],
                );
            }

        }
        $this->output['limitList'] = json_encode($data);
        $this->output['shopLimitList'] = json_encode($data_shop);
    }

    
    private function _bargain_list_for_select(){
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'ba_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name' => 'ba_start_time', 'oper' => '<', 'value' => time());
        $where[] = array('name' => 'ba_end_time', 'oper' => '>', 'value' => time());
        $where[] = array('name' => 'ba_deleted', 'oper' => '=', 'value' => 0);
        $list    = $bargain_model->getActivityList($where,0,0,[]);
        $data = [];
        $data_shop = [];
        foreach($list as $val){
            if($val['ba_es_id'] > 0){
                $data_shop[]= array(
                    'id'    => $val['ba_id'],
                    'name'  => $val['g_name'],
                );
            }else{
                $data[]= array(
                    'id'    => $val['ba_id'],
                    'name'  => $val['g_name'],
                );
            }

        }
        $this->output['bargainList'] = json_encode($data);
        $this->output['shopBargainList'] = json_encode($data_shop);
    }

    
    private function _fetch_member_type($memberData){
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['ml_id'],
                    'name' => $val['ml_name'],
                    'freenum' => isset($memberData[$val['ml_id']]['freenum']) && $memberData[$val['ml_id']]['freenum'] ? intval($memberData[$val['ml_id']]['freenum']) : 0,
                    'paynum'  => isset($memberData[$val['ml_id']]['paynum']) && $memberData[$val['ml_id']]['paynum'] ? intval($memberData[$val['ml_id']]['paynum']) : 0,
                    'postPrice' => isset($memberData[$val['ml_id']]['postPrice']) && $memberData[$val['ml_id']]['postPrice'] ? floatval($memberData[$val['ml_id']]['postPrice']) : 0,
                );
            }
        }
        $this->output['memberCardType'] = json_encode($data);
    }

    
    private function _shop_kind_list_for_select(){
        $kind_model     = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $kind2 = $kind_model->getAllSonCategory(0,0);
        $data = array();
        if($kind2){
            foreach ($kind2 as $val){
                $data[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
    }

    
    private function _city_shop_kind_list_for_select(){
        $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $es_where[] = array('name' => 'es_s_id','oper' => '=','value' =>$this->curr_sid);
        $es_where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $es_where[] = array('name' => 'es_expire_time', 'oper' => '>', 'value' => time());
        $esList = $es_model->getList($es_where,0,0,array(),array('es_id'));
        $esIds = array();
        $data = array();
        if($esList){
            foreach ($esList as $val){
                $esIds[] = $val['es_id'];
            }
        }
        Libs_Log_Logger::outputLog($esIds);
        Libs_Log_Logger::outputLog('上面是多店id');
        $category_model = new App_Model_Entershop_MysqlGoodsCategoryStorage(0);
        if(!empty($esIds)){
            $where[] = array('name' => 'esgc_s_id', 'oper' => 'in', 'value' => $esIds);
            $kind = $category_model->getList($where,0,0,array(),array('esgc_id','esgc_name','esgc_logo','esgc_weight','esgc_create_time','esgc_s_id'));
        }



        if($kind){
            foreach ($kind as $val){
                $data[] = array(
                    'id'   => $val['esgc_id'],
                    'name' => $val['esgc_name'],
                    'esId' => $val['ecgc_s_id']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
    }
    
    private function _ordinary_goods_group(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['gg_id'],
                    'name' => $val['gg_name'],
                );
            }
        }
        $this->output['ordinaryGoodsGroup'] = json_encode($data);
    }
    
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
        $this->output['goodsGroup'] = json_encode($data);
    }
    
    private function _shop_top_goods_list($type = ''){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where = array();
        if($type == 'mall'){
            $where[]    = array('name' => 'g_es_id', 'oper' => '>', 'value' => 0);
        }else{
            $where[]    = array('name' => 'g_es_id', 'oper' => '=', 'value' => 0);
        }
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,0,'',0,array(),array(),0,0,1,$where);
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
    
    private function _shop_default_tpl(){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        
    }

    
    private function showIndexTpl($tpl_id=23){
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        $type = array(
            array('index'=>0,'name'=>'最新发布','must'=>true,'type'=>'time'),
            array('index'=>1,'name'=>'红包福利','must'=>false,'type'=>'redPacket'),
            array('index'=>2,'name'=>'最新回复','must'=>true,'type'=>'reply'),
            array('index'=>3,'name'=>'距离最近','must'=>true,'type'=>'distance')
        );
        if(empty($tpl)){
            $tpl = array(
                'aci_title'         => '首页',
                'aci_tpl_id'        => $tpl_id,
                'aci_post_audit'     => 1,
                'aci_must_address'   => 0,
                'aci_must_mobile'    => 0,
                'aci_service_rate'   => 0,
                'aci_redbag_min'     => 0,
                'aci_single_min'     => 0,
                'aci_browse_num'     => 0,
                'aci_issue_num'      => 0,
                'aci_issue_num_open' => 0,
                'aci_shop_num'       => 0,
                'aci_add_member'     => 0,
                'aci_recommend_open'     => 1,
                'aci_coop_brief'     => '发帖',
                'aci_apply_icon'     => '',
                'aci_apply_title'    => '',
                'aci_apply_desc'     => '',
                'aci_apply_open'     => 1,
                'aci_post_num'       => 0,
                'aci_post_price'     => 0,
                'aci_label_open'     => 0,
                'aci_citymember_open' => 0,
                'aci_content_mobile_show' => 1,
                'aci_post_submit'    => 1,
                'aci_post_top_open'  => 1,
                'aci_post_video_open'=> 1,
                'aci_open_member_remind'=> 0,
                'aci_open_water_mark'=> 0,
            );
        }
        if(!$tpl['aci_post_type']){
            $tpl['aci_post_type'] = json_encode($type);
        }else{
            $tpl['aci_post_type'] = $this->_remove_post_quotes($tpl['aci_post_type']);

        }
        $brief = array(
            'brief' => $tpl['aci_coop_brief']
        );
        $tips = array(
            'tips' => $tpl['aci_warm_tips']
        );
        $this->output['brief'] = json_encode($brief);
        $this->output['tips'] = json_encode($tips);
        $this->output['tpl'] = $tpl;
        if($tpl['aci_member_post_num']){
            $memberData = json_decode($tpl['aci_member_post_num'],true);
        }else{
            $memberData = array();
        }
        $this->_fetch_member_type($memberData);
    }

    
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
    
    private function _shop_category($type = 0){
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category = $shortcut_model->fetchShortcutShowList($type);
        $data = array();
        if($category){
            foreach ($category as $val){
                $data[] = array(
                    'id'   => $val['acc_id'],
                    'name' => $val['acc_title'],
                );
            }
        }
        $this->output['shopCategory'] = json_encode($data);
        return $data;
    }

    
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
    
    private function _shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shop    = $shop_storage->getList($where,0,0,$sort);
        $data = array();
        $data[] = array(
            'id'        => 0,
            'name'      => '请选择',
        );
        if($shop){
            foreach ($shop as $val){
                $data[] = array(
                    'id'        => $val['acs_id'],
                    'name'      => $val['acs_name'],
                );
            }
        }
        $this->output['shopList'] = json_encode($data);

    }
    
    private function _show_shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shop    = $shop_storage->getList($where,0,0,$sort);
        $data = array();
        if($shop){
            foreach ($shop as $val){
                $data[ $val['acs_id']] = array(
                    'imgsrc'    => $val['acs_img'],
                    'name'      => $val['acs_name'],
                );
            }
        }
        $this->output['shopListId'] = json_encode($data);

    }
    
    private function _recommend_shop_list(){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shop    = $shop_storage->getList($where,0,4,$sort);
        $data = array();
        if($shop){
            foreach ($shop as $val){
                $data[] = array(
                    'id'        => $val['acs_id'],
                    'name'      => $val['acs_name'],
                    'cover'     => $val['acs_cover'],
                );
            }
        }
        $this->output['shop'] = json_encode($data);
    }
    private function _recommend_shop_near(){
        $recommend_model      = new App_Model_City_MysqlCityRecommendStorage($this->curr_sid);
        $where     = array();
        $where[]   = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort      = array('acr_sort'=>'ASC');
        $recommend = $recommend_model->getList($where,0,0,$sort);
        $data = array();
        foreach($recommend as $key => $val){
            $data[] = array(
                'id'           => $val['acr_id'] ,
                'shopId'       => $val['acr_link'],
                'cover'        => $val['acr_cover'],
                'name'         => $val['acr_name'],
            );
        }
        foreach($data as &$v){
            $v['id'] = $v['shopId'];
        }
        if(!$data){
            $this->_recommend_shop_list();
        }else{
            $this->output['shop'] = json_encode($data);
        }
    }

    
    private function _show_info(){
        $shortcut_model = new App_Model_City_MysqlCityPostInfoStorage($this->curr_sid);
        $where    = array();
        $where[]  = array('name'=>'aci_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort     = array('aci_sort'=>'ASC');
        $shortcut = $shortcut_model->getList($where,0,0,$sort);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'imgsrc'       => $val['aci_img'],
                'link'         => $val['aci_link'],
                'type'         => $val['aci_type'],
                'title'        => $val['aci_title']
            );
        }
        $this->output['infoList'] = json_encode($json);
    }
    
    private function _save_info(){
        $shortcut_model = new App_Model_City_MysqlCityPostInfoStorage($this->curr_sid);
        $shortcut = $this->request->getArrParam('info');
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList();
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['aci_sort']])){
                        $set = array(
                            'aci_sort'            => $shortcut[$val['aci_sort']]['index'],
                            'aci_img'             => $shortcut[$val['aci_sort']]['imgsrc'],
                            'aci_type'            => $shortcut[$val['aci_sort']]['type'],
                            'aci_link'            => $shortcut[$val['aci_sort']]['link'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['aci_id']);
                        unset($shortcut[$val['aci_sort']]);
                    }else{
                        $del_id[] = $val['aci_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'aci_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['imgsrc']}', '{$val['link']}', '{$val['type']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'aci_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $shortcut_model->deleteValue($where);
        }
    }
    
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

    
    private function _post_tab(){
        $tab_storage = new App_Model_City_MysqlCityPostTabStorage($this->curr_sid);
        $tab_list = $tab_storage->fetchShortcutShowList(23);
        $data = array();
        if($tab_list){
            foreach ($tab_list as $val){
                $data[] = array(
                    'index'         => intval($val['acpt_weight']),
                    'link'          => $val['acpt_link'],
                    'type'          => $val['acpt_link_type'],
                    'name'          => $val['acpt_name']
                );
            }
        }
        $this->output['tabList'] = json_encode($data);
    }

    
    private function _show_tpl_notice(){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList();
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['atn_weight'],
                    'title'         => $val['atn_title'],
                    'articleId'     => $val['atn_article_id'],
                    'articleTitle'  => $val['atn_article_title']
                );
            }
        }
        $this->output['noticeList'] = json_encode($data);
    }
    private function _save_train_notice(){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList();
            if(!empty($notice_list)){
                $del_id = array();
                foreach($notice_list as $val){
                    if(isset($noticeInfo[$val['atn_weight']])){
                        $set = array(
                            'atn_weight'            => $noticeInfo[$val['atn_weight']]['index'],
                            'atn_title'             => $noticeInfo[$val['atn_weight']]['title'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                        );
                        $up_ret = $notice_storage->updateById($set,$val['atn_id']);
                        unset($noticeInfo[$val['atn_weight']]);
                    }else{
                        $del_id[] = $val['atn_id'];
                    }
                }
                if(!empty($del_id)){
                    $notice_where = array();
                    $notice_where[] = array('name' => 'atn_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $notice_storage->deleteValue($notice_where);
                }

            }
            if(!empty($noticeInfo)){
                $insert = array();
                foreach($noticeInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $notice_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'atn_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $notice_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function _save_post_tab($tpl_id){
        $tabInfo = $this->request->getArrParam('tabList');
        $tab_storage = new App_Model_City_MysqlCityPostTabStorage($this->curr_sid);
        if(!empty($tabInfo)){
            $tab_list = $tab_storage->fetchShortcutShowList($tpl_id);
            if(!empty($tab_list)){
                $del_id = array();
                foreach($tab_list as $val){
                    if(isset($tabInfo[$val['acpt_weight']])){
                        $set = array(
                            'acpt_weight'            => $tabInfo[$val['acpt_weight']]['index'],
                            'acpt_name'             => $tabInfo[$val['acpt_weight']]['name'],
                            'acpt_link'        => $tabInfo[$val['acpt_weight']]['link'],
                            'acpt_link_type'     => $tabInfo[$val['acpt_weight']]['type'],
                        );
                        $up_ret = $tab_storage->updateById($set,$val['acpt_id']);
                        unset($tabInfo[$val['acpt_weight']]);
                    }else{
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
            if(!empty($tabInfo)){
                $insert = array();
                foreach($tabInfo as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$tpl_id}','{$val['name']}','','{$val['link']}','{$val['type']}','{$val['index']}','1','0','".time()."') ";
                }
                $ins_ret = $tab_storage->insertBatch($insert);
            }
        }else{
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


    
    private function showShortcut($type=1){
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($type);
        $json = array();
        $postCategory = [];
        foreach($shortcut as $key => $val){
            $json[] = array(
                'id'           => $val['acc_id'],
                'index'        => $key ,
                'title'        => $val['acc_title'],
                'imgsrc'       => $val['acc_img'],
                'type'         => $val['acc_service_type'],
                'price'        => $val['acc_price'],
                'linkUrl'      => $val['acc_link_url'],
                'mobileShow'   => $val['acc_mobile_show'] ==1 ? true : false,
                'addressShow'  => $val['acc_address_show'] ==1 ? true : false,
                'allowComment' => $val['acc_allow_comment'] ==1 ? true : false,
                'verifyComment' => $val['acc_verify_comment'] ==1 ? true : false,
                'isshow'       => $val['acc_isshow'] == 1 ? true : false,
            );
            if($val['acc_service_type'] == 1){
                $postCategory[] = array(
                    'id' => $val['acc_id'],
                    'title' => $val['acc_title']
                );
            }

        }
        if($type == 2){
            $this->output['shortcutCategory'] = json_encode($json);
        }else{
            $this->output['shortcut'] = json_encode($json);
            $this->output['postCategory'] = json_encode($postCategory);
        }

    }

    private function _get_post_category($level=1,$fid=0){
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList(1,$level,$fid,1);
        $postCategory = [];
        foreach($shortcut as $key => $val){
            $postCategory[] = array(
                'id'           => $val['acc_id'],
                'index'        => $key ,
                'title'        => $val['acc_title'],
                'imgsrc'       => $val['acc_img'],
                'type'         => $val['acc_service_type'],
                'price'        => $val['acc_price'],
                'linkUrl'      => $val['acc_link_url'],
                'mobileShow'   => $val['acc_mobile_show'] ==1 ? true : false,
                'addressShow'  => $val['acc_address_show'] ==1 ? true : false,
                'allowComment' => $val['acc_allow_comment'] ==1 ? true : false,
                'verifyComment' => $val['acc_verify_comment'] ==1 ? true : false,
                'isshow'       => $val['acc_isshow'] == 1 ? true : false,
            );
        }
        $this->output['postCategory'] = json_encode($postCategory);
    }




    
    private function _save_shop_shortcut(){
        $shortcut = $this->request->getArrParam('shortcut');
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
                    if($has){
                        $set = array(
                            'acc_sort'  => $index,
                            'acc_title' => $shortcut[$index]['title'],
                            'acc_img'   => $shortcut[$index]['imgsrc'],
                            'acc_service_type'=> $shortcut[$index]['type'],
                            'acc_price'       => $shortcut[$index]['price'],
                            'acc_link_url'    => $shortcut[$index]['linkUrl'],
                            'acc_mobile_show' => isset($shortcut[$index]['mobileShow']) && $shortcut[$index]['mobileShow'] && $shortcut[$index]['mobileShow'] =='true' ? 1 : 0 ,
                            'acc_address_show' => isset($shortcut[$index]['addressShow']) && $shortcut[$index]['addressShow'] && $shortcut[$index]['addressShow'] =='true' ? 1 : 0,
                            'acc_allow_comment' => isset($shortcut[$index]['allowComment']) && $shortcut[$index]['allowComment'] && $shortcut[$index]['allowComment'] =='true' ? 1 : 0,
                            'acc_verify_comment' => isset($shortcut[$index]['verifyComment']) && $shortcut[$index]['verifyComment'] && $shortcut[$index]['verifyComment'] =='true' ? 1 : 0,
                            'acc_isshow' => isset($shortcut[$index]['isshow']) && $shortcut[$index]['isshow'] && $shortcut[$index]['isshow'] =='true' ? 1 : 0
                        );

                        $up_ret = $shortcut_model->updateById($set,$val['acc_id']);
                        unset($shortcut[$index]);
                    }else{
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
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $mobileShow = isset($val['mobileShow']) && $val['mobileShow'] && $val['mobileShow']=='true' ? 1 : 0;
                    $addressShow = isset($val['addressShow']) && $val['addressShow'] && $val['addressShow']=='true' ? 1 : 0;
                    $allowComment = isset($val['allowComment']) && $val['allowComment'] && $val['allowComment']=='true' ? 1 : 0;
                    $verifyComment = isset($val['verifyComment']) && $val['verifyComment'] && $val['verifyComment']=='true' ? 1 : 0;
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['title']}', '1', '{$val['imgsrc']}', '{$val['index']}', '{$val['type']}','{$val['price']}','{$mobileShow}','{$addressShow}','{$allowComment}','{$verifyComment}','{$val['linkUrl']}','0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatchPostCategory($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acc_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acc_type','oper' => '=' , 'value' => 1);
            $shortcut_model->deleteValue($where);
        }
    }

    
    public function shopListAction(){
        $page = $this->request->getIntParam('page');
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $count = 20;
        $index = $page * $count;
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'acs_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'acs_category_id','oper' => '=','value' =>$output['cate']);
        }

        $output['has_member'] = $this->request->getIntParam('has_member',0);
        if($output['has_member'] == 1){
            $where[] = array('name' => 'acs_m_id', 'oper' => '>', 'value' => 0);
        }elseif ($output['has_member'] == 2){
            $where[] = array('name' => 'acs_m_id', 'oper' => '=', 'value' => 0);
        }

        $output['mobile']     = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'acs_mobile','oper' => 'like','value' =>"%{$output['mobile']}%");
        }
        $output['type']     = $this->request->getIntParam('type',0);
        if($output['type']){
            $oper = $output['type'] == 1 ? '>' : '<';
            $where[] = array('name' => 'acs_expire_time', 'oper' => $oper, 'value' => time());
        }


        $tags=$this->request->getIntParam('tags',-1);
        if($tags>-1){
            $where[]=['name'=>'acs_label_type','oper'=>'=','value'=>$tags];
        }


        $this->showOutput($output);

        $shopList = $shop_storage->fetchListMember($where, $index, $count, $sort);

        foreach($shopList as $key => $val){
            if(!$val['acs_qrcode']){
                $list[$key]['acs_qrcode']=$this->create_qrcode($val['acs_id'], $val['acs_img']);
            }
        }
        $total      = $shop_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['list'] = $shopList;
        $this->_get_area_category();
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $hadSc = $plugin_model->findUpdateBySid('sc');
        if($hadSc){
            $this->output['hadSc'] = 1;
        }else{
            $this->output['hadSc'] = 0;
        }
        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $this->output['payCfg']  = $pay_model->findRowPay();
        $this->output['curr_domain'] = plum_get_server('http_host');
        $ext_query = '?';
        if($this->curr_sid == 7448){
            $ext_query .= 'notcheackmobile=1&';
        }
        $ext_query = rtrim($ext_query,'?');
        $ext_query = rtrim($ext_query,'&');
        $this->output['ext_query'] = $ext_query;
        $enter_shop_plugin = plum_parse_config('enter_shop_plugin')[$this->wxapp_cfg['ac_type']];
        $this->output['enter_shop_plugin'] = $enter_shop_plugin;
        $this->output['entershopPluginArr'] = json_encode($enter_shop_plugin,JSON_UNESCAPED_UNICODE);
        $this->_get_shop_num();
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '店铺入驻店铺管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/shop-list.tpl');
    }

    
    private function _get_shop_num($return = false){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $where = $where_expire = array();
        $where[] = $where_expire[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = $where_expire[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = $where_expire[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
        $where_expire[] = array('name' => 'acs_expire_time', 'oper' => '<', 'value' => time());

        $countAll = $shop_storage->getCount($where);
        $countExpire = $shop_storage->getCount($where_expire);

        $info = array(
            'countAll' => $countAll ? $countAll : 0,
            'countExpire' => $countExpire ? $countExpire : 0
        );
        if($return){
            return $info;
        }else{
            $this->output['shopCountInfo'] = $info;
        }
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_istop', 'oper' => '=', 'value' => 1);
        $total_zd = $shop_storage->getCount($where);
        $where[2] = array('name' => 'acs_is_recommend', 'oper' => '=', 'value' => 1);
        $total_tj = $shop_storage->getCount($where);

        $this->output['statInfo'] = [
            'total'      => $countAll ? $countAll : 0,
            'total_ydq'  => $countExpire ? $countExpire : 0,
            'total_zd'   => $total_zd ? $total_zd : 0,
            'total_tj'   => $total_tj ? $total_tj : 0,
        ];

    }

    
    public function shopTopAction(){
        $id     = $this->request->getIntParam('id');
        $isTop  = $this->request->getIntParam('istop');
        if($id){
            $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $row          = $shop_storage->getRowById($id);
            if($row){
                $where    = array();
                $where[]  = array('name'=>'acs_istop','oper'=>'=','value'=>$isTop);
                $where[]  = array('name'=>'acs_id','oper'=>'=','value'=>$id);
                $row1     = $shop_storage->getRow($where);
                if($row1){
                     $set  = array(
                         'acs_istop' => $isTop==1?0:1
                     );
                     $res = $shop_storage->updateById($set,$id);
                     if($res){
                         $result = array(
                             'ec' => 200,
                             'em' => '操作成功'
                         );
                         $str = $set['asc_istop'] == 1 ? '置顶' : '取消置顶';
                         App_Helper_OperateLog::saveOperateLog("{$str}店铺【{$row1['acs_name']}】成功");

                     }else{
                         $result = array(
                             'ec' => 200,
                             'em' => '操作失败'
                         );
                     }
                }else{
                    $result = array(
                        'ec' => 400,
                        'em' => '该店铺信息有误'
                    );
                }

            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '该店铺信息不存在'
                );
            }

        }
        $this->displayJson($result);
    }
    
    private function create_qrcode($id, $cover=''){
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        if(!$cover){
            $shop  = $shop_storage->getRowById($id);
            $cover = $shop['acs_img'];
        }
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::CITY_SHOP_CODE_PATH, 430, $cover);
        if($url){
            $updata = array('acs_qrcode'=>$url);
            $shop_storage->updateById($updata,$id);
        }
        return $url;
    }

    
    public function createQrcodeAction(){
        $id = $this->request->getIntParam('id');
        $url = $this->create_qrcode($id);
        if($url){
            $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        }else{
            $res = array('ec'=> 400,'em'=> '创建失败！');
        }
        $this->displayJson($res);
    }

    
    public function downloadShopQrcodeAction() {
        $id = $this->request->getIntParam('id');
        if($id){
            $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $shop = $shop_storage->getRowById($id);
            $file       = PLUM_DIR_ROOT.$shop['acs_qrcode'];
            $filesize   = filesize($file);
            $filename   = $shop['acs_name'].".jpg";

            plum_send_http_header("Content-type: application/octet-stream");
            plum_send_http_header("Accept-Ranges: bytes");
            plum_send_http_header("Accept-Length:".$filesize);
            plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

            readfile($file);
        }
    }

    
    public function saveShopAction(){
        $latArr = array();
        $lngArr = array();
        $addressArr = array();
        $mobileArr = array();
        $contacterArr = array();
        for($i=1;$i<=3;$i++){
            array_push($latArr,$this->request->getStrParam('lat'.$i));
            array_push($lngArr,$this->request->getStrParam('lng'.$i));
            array_push($addressArr,$this->request->getStrParam('address'.$i));
            array_push($mobileArr,$this->request->getStrParam('mobile'.$i));
            array_push($contacterArr,$this->request->getStrParam('contacter'.$i));
        }

        $id                  = $this->request->getIntParam('id');
        $data['acs_lat']     = $this->request->getStrParam('lat');
        $data['acs_lng']     = $this->request->getStrParam('lng');
        $data['acs_address'] = $this->request->getStrParam('address');
        $data['acs_name']    = $this->request->getStrParam('name');
        $data['acs_mobile']  = $this->request->getStrParam('mobile');
        $data['acs_open_time'] = $this->request->getStrParam('openTime','00:00-23:59');
        $data['acs_cover'] = $this->request->getStrParam('cover');
        $data['acs_brief'] = $this->request->getStrParam('brief');
        $data['acs_istop'] = $this->request->getIntParam('istop');
        $data['acs_sort'] = $this->request->getIntParam('sort');
        $data['acs_type']    = 1;
        $data['acs_status']  = 2;
        $data['acs_category_id']  = $this->request->getIntParam('category');
        $data['acs_content'] = $this->request->getStrParam('content');
        $data['acs_s_id']    = $this->curr_sid;

        $data['acs_translate_lat'] = json_encode($latArr);
        $data['acs_translate_lng'] = json_encode($lngArr);
        $data['acs_translate_address'] = json_encode($addressArr);
        $data['acs_translate_mobile'] = json_encode($mobileArr);
        $data['acs_translate_contacter'] = json_encode($contacterArr);

        if($this->request->getStrParam('lat1')){
            $data['acs_lat']     = $this->request->getStrParam('lat1');
        }

        if($this->request->getStrParam('lng1')){
            $data['acs_lng']     = $this->request->getStrParam('lng1');
        }

        if($this->request->getStrParam('address1')){
            $data['acs_address']     = $this->request->getStrParam('address1');
        }

        if($this->request->getStrParam('mobile1')){
            $data['acs_mobile']     = $this->request->getStrParam('mobile1');
        }

        $shop_storage        = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        if($id){
            $acsRow = $shop_storage->getRowById($id);
            if($acsRow['acs_es_id'] > 0){
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $update = [
                    'es_phone' => $data['acs_mobile'],
                    'es_name' => $data['acs_name'],
                    'es_lng' => $data['acs_lng'],
                    'es_lat' => $data['acs_lat'],
                    'es_addr' => $data['acs_address'],
                    'es_logo' => $data['acs_cover'],
                ];
                $es_model->updateById($update,$acsRow['acs_es_id']);
            }

            $ret = $shop_storage->updateById($data, $id);
        }else{
            $data['acs_create_time'] = time();
            $ret = $shop_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存店铺【{$data['acs_name']}】成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function deleteShopAction(){
        $id  = $this->request->getIntParam('id');
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $row = $shop_storage->getRowByIdSid($id,$this->curr_sid);
        $data['acs_deleted']    = 1;
        $ret = $shop_storage->updateById($data, $id);

            $esId = intval($row['acs_es_id']);
            if($esId > 0){
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $es_model->deleteDFById($esId);
                $esm_model = new App_Model_Entershop_MysqlManagerStorage();
                $where_manager[] = array('name'=>'esm_es_id','oper'=> '=','value'=>$esId);
                $where_manager[] = array('name'=>'esm_s_id','oper'=> '=','value'=>$this->curr_sid);
                $esm_model->deleteValue($where_manager);
                $this->_statistics('shop', -1);
            }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除店铺【{$row['acs_name']}】成功");
        }
        $this->showAjaxResult($ret,'删除');
    }

    
    private function _get_area_category(){
        $category_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category = $category_model->fetchShortcutShowList();
        $categoryList = array();
        $categorySelect = array();
        if($category){
            foreach ($category as $key => $val){
                $categoryList[] = array(
                    'id'    => $val['acc_id'],
                    'index' => $key,
                    'name'  => $val['acc_title']
                );
                $categorySelect[$val['acc_id']] = $val['acc_title'];
            }
        }
        $this->output['categorySelect'] = $categorySelect;
        $this->output['categoryList']   = json_encode($categoryList);
    }

    
    public function addAreaShopAction(){
        $id                  = $this->request->getIntParam('id');
        $shop_storage        = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $shop                = $shop_storage->getRowByIdSid($id, $this->curr_sid);
        $shop['acs_open_time'] = explode('-', $shop['acs_open_time']);
        $shop['acs_address'] =  str_replace(array("\r\n", "\n", "\r"), "", $shop['acs_address']);//去除地址换行符  保证地图初始化
        $this->output['row'] = $shop;
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList(2);
        $this->output['category_select'] = $category;
        $cost_model          = new App_Model_City_MysqlCityApplyCostStorage($this->curr_sid);
        $costList            = $cost_model->findListBySid();
        $this->output['costList'] = $costList;
        if($shop['acs_recommend_shop']){
            $sidArr = json_decode($shop['acs_recommend_shop'],1);
            if(!empty($sidArr)){
                $where_goods = array();
                $where_goods[] = array('name' => 'acs_id', 'oper' => 'in', 'value' => $sidArr);
                $where_goods[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
                $where_goods[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
                $where_goods[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
                $shopList = $shop_storage->getList($where_goods,0,0,array(),array('acs_id','acs_name'));
                $this->output['shopsList'] = $shopList;
            }
        }
        $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $entershop       = $store_model->getRowById($shop['acs_es_id']);
        $this->output['enterShop'] = $entershop;
        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '/wxapp/city/shopList'),
            array('title' => '添加店铺', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/city/add-area-shop.tpl');
    }
    
    public function saveAreaShopAction(){
        $id                  = $this->request->getIntParam('id');
        $data['acs_lat']     = $this->request->getStrParam('lat');
        $data['acs_lng']     = $this->request->getStrParam('lng');
        $data['acs_address'] = $this->request->getStrParam('address');
        $data['acs_name']    = $this->request->getStrParam('name');
        $data['acs_mobile']  = $this->request->getStrParam('mobile');
        $data['acs_label']   = $this->request->getStrParam('label');
        $data['acs_vr_url']   = $this->request->getStrParam('vr');
        $openTime = $this->request->getStrParam('openTime');
        $data['acs_open_time'] = $openTime == '-' ? "00:00-23:59" : $openTime;

        $openTimeArr = explode('-',$data['acs_open_time']);
        $data['acs_open_start'] = $openTimeArr[0];
        $data['acs_open_end'] = $openTimeArr[1];

        $data['acs_cover']   = $this->request->getStrParam('cover');
        $data['acs_img']     = $this->request->getStrParam('img');
        $data['acs_code_cover']   = $this->request->getStrParam('code');
        $data['acs_type']    = 2;
        $data['acs_status']  = 2;
        $data['acs_category_id']  = $this->request->getIntParam('category');
        $data['acs_content'] = $this->request->getStrParam('content');
        $data['acs_s_id']    = $this->curr_sid;
        $data['acs_brief']   = $this->request->getStrParam('brief');
        $data['acs_is_recommend'] = $this->request->getIntParam('isRecommend');
        $data['acs_list_label'] = $this->request->getStrParam('listLabel');
        $data['acs_sort'] = $this->request->getIntParam('sort');
        $data['acs_recommend_shop'] = json_encode($this->request->getArrParam('sids'));
        $showNum = $this->request->getIntParam('showNum');
        $showMaid = $this->request->getFloatParam('showMaid');
        $joinDistrib = $this->request->getIntParam('joinDistrib');
        $cashProportion = $this->request->getFloatParam('cashProportion');
        $shop_storage        = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        if($id){
            $shop = $shop_storage->getRowById($id);
            $data['acs_show_num'] = $shop['acs_show_num'] + $showNum;
            $ret = $shop_storage->updateById($data, $id);
            if($shop['acs_es_id'] > 0){
                $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $es_data = array(
                    'es_name'   => $data['acs_name'],
                    'es_logo'   => $data['acs_img'],
                    'es_label'  => $data['acs_label'],
                    'es_phone'  => $data['acs_mobile'],
                    'es_addr'   => $data['acs_address'],
                    'es_lng'    => $data['acs_lng'],
                    'es_lat'    => $data['acs_lat'],
                    'es_is_recommend' => $data['acs_is_recommend'],
                    'es_join_distrib' => $joinDistrib,
                    'es_maid_proportion' => $showMaid,
                    'es_cash_proportion' => $cashProportion
                );
                $es_model->updateById($es_data,$shop['acs_es_id']);
            }
        }else{
            $dateLong = $this->request->getIntParam('date',0);
            if($dateLong){
              if($dateLong>=12){
                  $expireTime = intval(floor($dateLong/12))*365*86400 + intval(($dateLong%12))*30*86400;
              }else{
                  $expireTime = $dateLong*30*86400;
              }
              $date = time() + $expireTime;
              $data['acs_expire_time'] = $date;
            }else{
                $data['acs_expire_time'] = time() + (365*86400);
            }
            $data['acs_show_num'] = $showNum;
            $data['acs_handle_time'] = time();
            $data['acs_create_time'] = time();
            $ret = $shop_storage->insertValue($data);
                $es_id = $this->_add_enter_shop($data, $joinDistrib);
                if ($es_id) {
                    $update['acs_es_id'] = $es_id;
                    $shop_storage->updateById($update,$ret);
                    $manager_model = new App_Model_Entershop_MysqlManagerStorage();
                    $exist = $manager_model->findManagerByMobile($data['acs_mobile']);
                    if (!$exist) {
                        if(plum_is_mobile($data['acs_mobile'])){
                            $this->_add_enter_shop_manager($es_id, $data['acs_mobile'], $data['acs_mobile']);
                        }
                    }
                }


            if($ret){
                $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
                $left = $date - time();
                $applet_redis->enterOvertimeTask($id, $left);

                App_Helper_OperateLog::saveOperateLog("保存店铺【{$data['acs_name']}】成功");

            }
            $this->_statistics('shop', 1);
        }
        $this->showAjaxResult(1);
    }

    
    public function postTopSetAction(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;

        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->curr_sid);

        $total      = $cost_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();

        $sort = array('act_data' => 'ASC');
        $list = $cost_storage->getList($where, $index, $this->count, $sort);
        if($list){
            $this->output['list'] = $list;
        }

        if($this->wxapp_cfg['ac_type'] == 33){
            $title1 = '车源管理';
            $title2 = '推荐收费配置';
        }else{
            $title1 = '同城管理';
            $title2 = '帖子置顶配置';
        }
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $ft_cfg = $index_storage->findUpdateBySid(23);
        $this->output['ft_cfg'] = $ft_cfg;

        $is_show_ftcfg = 0;
        if($this->wxapp_cfg['ac_type'] == 8){
            $is_show_ftcfg = 1;
        }
        $this->output['is_show_ftcfg'] = $is_show_ftcfg;

        $this->buildBreadcrumbs(array(
            array('title' => $title1, 'link' => '#'),
            array('title' => $title2, 'link' => '#'),
        ));


        $this->displaySmarty('wxapp/city/post-top-setting.tpl');
    }

    
    public function saveTopSetAction(){
        $date       = $this->request->getIntParam('date');
        $cost       = $this->request->getFloatParam('cost');
        $id         = $this->request->getIntParam('id');
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);

        $data = array(
            'act_s_id'        => $this->curr_sid,
            'act_data'        => $date,
            'act_cost'        => $cost,
            'act_update_time' => time(),
        );
        if($id){
            $ret = $cost_storage->updateById($data,$id);
        }else{
            $ret = $cost_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存帖子置顶费用成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    
    public function deleteTopSetAction(){
        $id  = $this->request->getIntParam('id');
           $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
        $ret = $cost_storage->deleteById($id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除帖子置顶费用成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function shopApplyEnterAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where[] = array('name'=>'acs_s_id','oper'=>'=','value'=>$this->curr_sid);
        $apply_name=$this->request->getStrParam('apply_name');
        $apply_mobile=$this->request->getStrParam('apply_mobile');
        $apply_cate=$this->request->getStrParam('apply_cate');
        if($apply_name)
            $where[]=['name'=>'acs_name','oper'=>'like','value'=>"%{$apply_name}%"];
        if($apply_mobile)
            $where[]=['name'=>'acs_mobile','oper'=>'=','value'=>$apply_mobile];
        if($apply_cate)
            $where[]=['name'=>'acs_category_id','oper'=>'=','value'=>$apply_cate];



        $apply_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $total      = $apply_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort          = array('acs_status'=>'ASC','acs_create_time' => 'DESC');
            $list          = $apply_storage->getList($where,$index,$this->count,$sort);
        }

        $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $this->output['cate'] = $cate_model->fetchCategoryListForSelect();
        $this->output['list'] = $list;
        $this->output['status'] = array(1=>'申请中',2=>'通过',3=>'拒绝');
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $index = $index_storage->findUpdateBySid();
        $this->output['indexTpl'] = $index;
        $this->buildBreadcrumbs(array(
            array('title' => '申请入驻管理', 'link' => '#'),
        ));
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 1);
        $total_sqz = $apply_storage->getCount($where);
        $where[1] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
        $total_ytg = $apply_storage->getCount($where);
        $where[1] = array('name' => 'acs_status', 'oper' => '=', 'value' => 3);
        $total_yjj = $apply_storage->getCount($where);

        $this->output['statInfo'] = [
            'total'      => $total ? $total : 0,
            'total_sqz'  => $total_sqz ? $total_sqz : 0,
            'total_ytg'   => $total_ytg ? $total_ytg : 0,
            'total_yjj'   => $total_yjj ? $total_yjj : 0,
        ];

        $this->displaySmarty('wxapp/city/shop-apply-enter-list.tpl');
    }

    
    public function handleApplyAction(){
        $id = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');
        $msg = '';
        $result = array(
            'ec'    => 400,
            'em'    => '处理失败'
        );
        if($id){
            $apply_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $shop = $apply_storage->getRowById($id);
            $updata = array(
                'acs_handle_remark' => $market,
                'acs_status'        => $status?$status:2,
                'acs_handle_time'   => time()
            );

            $ret = $apply_storage->updateById($updata,$id);
            if($status && $status == 2 && $ret){
                $msg = $this->_deal_shop_pass($id);
            }
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('index', 'wxappTempl', array('sid' => $this->curr_sid,'applet' => $this->wxapp_cfg['ac_type'], 'tid' => $id, 'type' => App_Helper_WxappApplet::SEND_SETUP_AUDIT,'appletType'=>$appletType));
            if($ret){
                $result = array(
                    'ec'    => 200,
                    'em'    => '处理成功'.$msg
                );
                $str = $status == 2 ? '通过' : '不通过';
                App_Helper_OperateLog::saveOperateLog("处理商家【{$shop['acs_name']}】入驻申请成功，处理结果：{$str}");
            }
            $this->displayJson($result,1);
        }else{
            $this->displayJsonError('处理失败，请稍后重试');
        }
    }

    
    private function _copy_shop_info_2_city_shop($id){
        $apply_storage = new App_Model_City_MysqlCityShopApplyStorage($this->curr_sid);
        $applyInfo = $apply_storage->getRowById($id);
        if($applyInfo['acs_logo'] && $applyInfo['acs_cate_id']){
            $data = array(
                'acs_s_id'         => $this->curr_sid,
                'acs_category_id' => $applyInfo['acs_cate_id'],
                'acs_name'         => $applyInfo['acs_name'],
                'acs_img'          => $applyInfo['acs_logo'],
                'acs_cover'        => $applyInfo['acs_cover'],
                'acs_brief'        => $applyInfo['acs_brief'],
                'acs_label'        => $applyInfo['acs_service'],
                'acs_open_time'    => $applyInfo['acs_open_time'].'-'.$applyInfo['acs_close_time'],
                'acs_mobile'       => $applyInfo['acs_mobile'],
                'acs_address'      => $applyInfo['acs_address'],
                'acs_lng'          => $applyInfo['acs_lng'],
                'acs_lat'          => $applyInfo['acs_lat'],
                'acs_content'      => $applyInfo['acs_content'],
                'acs_area'         => $applyInfo['acs_area'],
                'acs_aptitude'     => $applyInfo['acs_aptitude'],
                'acs_pay_qrcode'   => $applyInfo['acs_pay_qrcode'],
                'acs_create_time'  => time(),
                'acs_m_id'         => $applyInfo['acs_m_id'],
            );

            $dateLong = $applyInfo['acs_date_long'];
            if($dateLong){
              if($dateLong>=12){
                  $expireTime = intval(floor($dateLong/12))*365*86400 + intval(($dateLong%12))*30*86400;
              }else{
                  $expireTime = $dateLong*30*86400;
              }
              $data['acs_expire_time'] = time() + $expireTime;
            }else{
                $data['acs_expire_time'] = time() + (365*86400);
            }

            $apply_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $ret = $apply_storage->insertValue($data);
            $this->_statistics('shop', 1);
            if($applyInfo['acs_number']){
                $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
                $pay_model->findUpdateByNumber($applyInfo['acs_number'],array('cpp_acs_id'=>$ret));
            }
        }
    }

     
    private function _deal_shop_pass($id){
        $msg = '';
        $apply_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $row = $apply_storage->getRowById($id);
        $dateLong = $row['acs_first_date'];
        if(!$row['acs_expire_time']) {
            if ($dateLong) {
                if ($dateLong >= 12) {
                    $expireTime = intval(floor($dateLong / 12)) * 365 * 86400 + intval(($dateLong % 12)) * 30 * 86400;
                }
                else {
                    $expireTime = $dateLong * 30 * 86400;
                }
                if($expireTime > 0){
                    $date = time() + $expireTime;
                }else{
                    $date = time() + (365 * 86400);
                }
            }
            else {
                $date = time() + (365 * 86400);
            }
        }else{
            $date = $row['acs_expire_time'];
        }
        $update['acs_expire_time'] = $date;
        $acs_res = $apply_storage->updateById($update,$id);
        if($row['acs_es_id'] == 0){
            $row['acs_expire_time'] = $date;
            $es_id = $this->_add_enter_shop($row);
            if ($es_id) {
                $set['acs_es_id'] = $es_id;
                $apply_storage->updateById($set,$id);
                $manager_model = new App_Model_Entershop_MysqlManagerStorage();
                $exist = $manager_model->findManagerByMobile($row['acs_mobile']);
                if (!$exist) {
                    if(plum_is_phone($row['acs_mobile'])){
                        $this->_add_enter_shop_manager($es_id, $row['acs_mobile'], $row['acs_mobile']);
                    }else{
                        $msg = ',店铺手机号格式不正确,请手动创建管理员';
                    }
                }else{
                    $msg = ',店铺手机号已被占用,请手动创建管理员';
                }

            }
        }
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
        $left = $date - time();
        $applet_redis->enterOvertimeTask($id, $left);
        $this->_statistics('shop', 1);
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $hadSc = $plugin_model->findUpdateBySid('sc');
        if(!$hadSc){
            $msg = '';
        }
        return $msg;
    }
    
    public function postListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $mid = $this->request->getIntParam('mid');
        if($mid){
            $where[]    = array('name' => 'acp_m_id', 'oper' => '=', 'value' => $mid);
        }
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => 'acp_content', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $this->output['category'] = $cateId =$this->request->getIntParam('category');
        if($this->output['category']){
            $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
            $cate_row = $cate_model->getRowById($cateId);
            if($cate_row['acc_level'] == 1){
                $where[]        = array('name' => 'acp_acc_id', 'oper' => '=', 'value' => $this->output['category']);
            }else{
                $where[]        = array('name' => 'acp_second_id', 'oper' => '=', 'value' => $this->output['category']);
            }

        }
        $out['start']   = $this->request->getStrParam('start');
        if($out['start']){
            $where[]    = array('name' => 'acp_create_time', 'oper' => '>=', 'value' => strtotime($out['start']));
        }
        $out['end']     = $this->request->getStrParam('end');
        if($out['end']){
            $where[]    = array('name' => 'acp_create_time', 'oper' => '<=', 'value' => (strtotime($out['end']) + 86400));
        }
        $this->output['screen'] = $this->request->getStrParam('screen');
        if($this->output['screen']){
            switch ($this->output['screen']){
                case 'status0':
                    $where[]    = array('name' => 'acp_status', 'oper' => '=', 'value' => 0);
                    break;
                case 'status1':
                    $where[]    = array('name' => 'acp_status', 'oper' => '=', 'value' => 1);
                    break;
                case 'top0':
                    $timeNow = time();
                    $where[]    = " ( acp_istop = 0 or acp_istop_expiration < {$timeNow} )";
                    break;
                case 'top1':
                    $where[]    = array('name' => 'acp_istop', 'oper' => '=', 'value' => 1);
                    $where[]    = array('name' => 'acp_istop_expiration', 'oper' => '>', 'value' => time());
                    break;
                case 'push0':
                    $where[]    = array('name' => 'acp_push', 'oper' => '=', 'value' => 0);
                    break;
                case 'push1':
                    $where[]    = array('name' => 'acp_push', 'oper' => '=', 'value' => 1);
                    break;
            }
        }

        $sortField  = $this->request->getIntParam('sortField',1);
        $this->output['sort'] = $sortField;


        $where[] = array('name'=>'acp_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acp_deleted','oper'=>'=','value'=>0);
        $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
        $total      = $post_storage->getPostListMemberCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            if($sortField ==1){
                $sort          = array('acp_create_time' => 'DESC');
                $list          = $post_storage->getPostListMember($where,$index,$this->count,$sort);
            }elseif($sortField == 2){
                $sort          = array('acc_time' => 'DESC');
                $list          = $post_storage->getPostListMember($where,$index,$this->count,$sort,1);
            }elseif($sortField == 3){
                $sort          = array('acp_like_num' => 'DESC');
                $list          = $post_storage->getPostListMember($where,$index,$this->count,$sort);
            }elseif($sortField == 4){
                $sort          = array('acp_comment_num' => 'DESC');
                $list          = $post_storage->getPostListMember($where,$index,$this->count,$sort);
            }

        }
        foreach($list as $key=>$val){
            $list[$key]['acp_content'] = $this->utf8_str_to_unicode($val['acp_content']);
        }
        $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $whereCate[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $whereCate[] = array('name'=>'acc_deleted','oper'=>'=','value'=>0);;
        $res    = $cate_model->getList($whereCate,0,0,array(),array('acc_id','acc_title'));
        $cateList = [];
        if($res){
            foreach ($res as $val){
                $cateList[$val['acc_id']] = $val['acc_title'];
            }
        }
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $index = $index_storage->findUpdateBySid(23);
        $this->output['index'] = $index;
        $this->output['cateList'] = $cateList;
        $this->output['firstCateList'] = $this->_get_category();
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '帖子管理', 'link' => '#'),
        ));
        $this->output['sortArr'] = array(
            1  => '发布时间',
            2  => '最新评论时间',
            3  => '点赞数量',
            4  => '回复数量'
        );
        $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
        $this->output['costList'] = $cost_storage->findListBySid();
        $where = array();
        $where[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
        $pay_model = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
        $total_ffts = $pay_model->getProfitCountAll($where);
        $where = [];
        $where[] = array('name' => 'acp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);
        $total_fts = $post_storage->getPostListMemberCount($where);
        $where[]    = array('name' => 'acp_status', 'oper' => '=', 'value' => 1);
        $total_yfj  = $post_storage->getPostListMemberCount($where);
        $where = [];
        $where[]    = array('name' => 'acp_istop', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'acp_istop_expiration', 'oper' => '>', 'value' => time());
        $where[]    = array('name' => 'acp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);
        $total_zdz  = $post_storage->getPostListMemberCount($where);
        $statInfo = [
            'total_ffts'=> $total_ffts,
            'total_fts' => $total_fts,
            'total_yfj' => $total_yfj,
            'total_zdz' => $total_zdz,
        ];
        $this->output['statInfo'] = $statInfo;

        $this->displaySmarty('wxapp/city/post-list-new.tpl');

    }
    
    private function _get_category($fid = 0,$level= 1){
        $cate_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        if($fid){
            $whereCate[] = array('name'=>'acc_fid','oper'=>'=','value'=>$fid);
        }
        $whereCate[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $whereCate[] = array('name'=>'acc_level','oper'=>'=','value'=>$level);
        $whereCate[] = array('name'=>'acc_deleted','oper'=>'=','value'=>0);;
        $res    = $cate_model->getList($whereCate,0,0,array(),array('acc_id','acc_title'));
        $cateList = [];
        if($res){
            foreach ($res as $val){
                $cateList[] = [
                    'id'    => $val['acc_id'],
                    'title' => $val['acc_title']
                ];
            }
        }

        return $cateList;

    }

    
    public function ajaxSecondCategoryAction(){
        $fid = $this->request->getIntParam('fid');
        $list = $this->_get_category($fid,2);
        if($list){
            $this->displayJsonSuccess($list);
        }else{
            $this->displayJsonError('');
        }

    }


    
    public function addNowAction(){
        $acpId  =  $this->request->getIntParam('acpId');
        if($acpId){
            $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
            $this->output['row'] = $post_storage->getRowById($acpId);
            $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($this->curr_sid);
            $list = $attachment_model->fetchAllAttachment($acpId);
            $this->output['imgs'] = $list;
        }
        $shortcut_model           = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $this->output['shortcut'] = $shortcut_model->fetchShortcutShowList(1);
        $memberModel              = new App_Model_Member_MysqlMemberCoreStorage();
        $this->output['memberList'] = $memberModel->getMemberListBySource($this->curr_sid,5);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '帖子管理', 'link' => '/wxapp/city/postList'),
            array('title' => '帖子发布', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/add-post.tpl');
    }
    
    public function selectPostClassAction(){
        $fid                 = $this->request->getIntParam('fid');
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $list                = $shortcut_model->fetchShortcutShowList(1,2,$fid);
        if($list){
            $ret  = array(
                'ec'=>200,
                'data'=> $list
            );
        }else{
            $ret  = array(
                'ec'=>400,
                'em'=> '没有相关二级分类'
            );
        }

        $this->displayJson($ret);
    }

    
    public function newSubmitPostAction(){
        $res      = array('ec'=>400,'em'=>'发帖失败');
        $id       = $this->request->getIntParam('id');
        $images   = $this->request->getStrParam('images');
        $content  = $this->request->getStrParam('content');
        $category = $this->request->getIntParam('firstClass');
        $secondId = $this->request->getIntParam('secondClass');
        $address  = $this->request->getStrParam('address');
        $lng      = $this->request->getStrParam('lng');
        $lat      = $this->request->getStrParam('lat');
        $mobile   = $this->request->getStrParam('mobile');
        $video    = $this->request->getStrParam('video');
        $istop    = $this->request->getIntParam('istop',0);
        $topTime  = $this->request->getIntParam('topTime');
        $mid      = $this->request->getIntParam('mid',0);
        $postType = $this->request->getIntParam('postType');

        if($mobile){
            if(mb_strlen($mobile)<7){
                $res['em'] = '请填写正确的手机号或固话';
                $this->displayJson($res,1);
            }
        }
        if($content=='undefined'){
            $content='';
        }
        $content = plum_sql_quote($content);

        $videoCover = '';
        if(strstr($video, 'v.qq.com') !== false){
            $video = $this->_get_tencent_video();
            $videoCover = "https://puui.qpic.cn/qqvideo_ori/0/".$video."_496_280/0";
        }

        if($content && mb_strlen($content)<=2000){
            $data = array(
                'acp_s_id'    => $this->curr_sid,
                'acp_content' => $content,
                'acp_address' => $address=='undefined' ? '' : $address,
                'acp_mobile'  => $mobile == 'undefined' ? '' : $mobile,
                'acp_lng'     => $lng == 'undefined' ? '' : $lng,
                'acp_lat'     => $lat == 'undefined' ? '' : $lat,
                'acp_acc_id'  => $category,
                'acp_second_id' => $secondId,
                'acp_video_url' => $video,
                'acp_post_type' => $postType?$postType:1,
                'acp_video_cover' => $videoCover
            );
            $post_model = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
            $is_add = 0;
            if(!$id){
                $is_add = 1;
                $data['acp_m_id']        = $mid;
                $data['acp_istop']       = 0;
                $data['acp_top_date']    = 0;
                $data['acp_create_time'] = time();
                $ret = $post_model->insertValue($data);
                if($ret){
                    $this->_statistics('issue', 1);
                }
                $id = $ret;
            }else{
                $data['acp_update_time'] = time();
                $ret = $post_model->updateById($data, $id);
            }

            if($ret){
                $res = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                $this->_save_post_img_new($id, $is_add);
                App_Helper_OperateLog::saveOperateLog("帖子发布成功");
            }
        }else{
            $res['em'] = '请填写2000字内的内容哦';
        }
        $this->displayJson($res);
    }
    private function _get_tencent_video($vid=''){
        if(!$vid){
            $url = $this->request->getStrParam('video');
            $urlArr = parse_url($url);
            $arr_query = $this->_convert_url_query($urlArr['query']);
            if($arr_query['vid']){
                $vid  = $arr_query['vid'];
            }else{
                $content = Libs_Http_Client::get($url);
                $content_html_pattern = '/VIDEO_INFO = ({[^}]*.*?)(;.*?var |<\/script>)/s';
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
            $real_url = $vid;
            return $real_url;
        }else{
            return false;
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

    
    private function _save_post_img_new($acpId,$is_add=0){
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($this->curr_sid);

        if($is_add){
            if($acpId && $maxNum>0){
                for($i=0; $i<= $maxNum; $i++){
                    $temp = $this->request->getStrParam('slide_'.$i);
                    $temp = plum_sql_quote($temp);
                    if($temp){
                        $insert[] =  " (NULL, '{$temp}','{$acpId}','{$this->curr_sid}','0', '0', '".time()."') ";
                    }
                }
                $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($this->curr_sid);
                $ret = $attachment_model->insertBatch($insert);
            }
        }else{
            $sl_id = array();
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                $temp_id = $this->request->getIntParam('slide_id_'.$i);
                if($temp && $temp_id == 0){
                    $slide[] = $temp;
                }
                if($temp_id){
                    $sl_id[] = $temp_id;
                }
            }
            $del_id = array();
            $old_slide = $attachment_model->fetchAllAttachment($acpId);
            foreach($old_slide as $val){
                if(!in_array($val['aca_id'],$sl_id)){
                    $del_id[] = $val['aca_id'];
                }
            }
            if(count($slide) <= count($del_id)){
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $attachment_model->updateAttachment($del_id[$d],$slide[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $attachment_model->deleteAttachment($acpId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $attachment_model->updateAttachment($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = " (NULL, '{$sTemp}','{$acpId}','{$this->curr_sid}','0', '0', '".time()."') ";
                    }
                }
                if(!empty($batch_slide)){
                    $attachment_model->insertBatch($batch_slide);
                }
            }
        }
    }
    
    public function updateCostTimeAction(){
        $res  =  array('ec'=>'400','em'=>'置顶失败');
        $pid  =  $this->request->getIntParam('id');//帖子id
        $cost =  $this->request->getIntParam('cost');//置顶费用id
        if($pid && $cost){
            $cost_storage = new App_Model_City_MysqlCityTopCostStorage($this->curr_sid);
            $cost         = $cost_storage->findRowByActid($cost);
            if($cost && $cost['act_data']){
                $topDate    = intval($cost['act_data']);
                $dateTime   = $topDate*60*60*24;
                $expiration = intval(time()+$dateTime);
                $data['acp_top_date']         = $topDate;
                $data['acp_istop']            = 1;
                $data['acp_istop_expiration'] = $expiration;
                $data['acp_pay_time']         = time();
                $post_model                   = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
                $ret                          = $post_model->updateById($data,$pid);
                if($ret){
                    $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
                    $applet_redis->recordTopPostTask($pid,$dateTime);
                    $res  =  array('ec'=>'200','em'=>'置顶成功');
                    App_Helper_OperateLog::saveOperateLog("帖子置顶成功");
                }
            }else{
                $res['em']  =  '检查配置是否失效哦';
            }
        }
        $this->displayJson($res);
    }





    
    public function commentPostAction(){
        $pid = $this->request->getIntParam('pid');
        $content = $this->request->getStrParam('content');
        $cmid = $this->request->getIntParam('cmid');
        $cid =  $this->request->getIntParam('cid');
        $content = plum_sql_quote($content);
        if($pid && $content && $content!=' '){
            $data = array(
                'acc_s_id'      => $this->curr_sid,
                'acc_acp_id'    => $pid,
                'acc_comment'   => $content,
                'acc_m_id'      => -1,
                'acc_reply_mid' => $cmid,
                'acc_acc_id'    => $cid,
                'acc_time'      => time(),
            );
            $comment_model = new App_Model_City_MysqlCityPostCommentStorage($this->curr_sid);
            $ret = $comment_model->insertValue($data);
            if($ret){
                if($cmid>0){
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($cmid);
                }
                $post_model = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
                $post_model->addReducePostNum($pid,'comment','add');
                $post_model->updateById(array('acp_update_time'=>time()),$pid);

                plum_open_backend('index', 'wxappTempl', array('sid' => $this->curr_sid,'applet' => 6, 'tid' => $ret, 'type' => App_Helper_WxappApplet::SEND_SETUP_COMMENT));
                if($ret){
                    App_Helper_OperateLog::saveOperateLog("帖子评论成功");
                }
                $this->showAjaxResult($ret);
            }else{
                $this->displayJsonError('评论失败');
            }
        }else{
            $this->displayJsonError('请填写评论内容');
        }

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
                $unicode_str.= '<span class="emoji-inner emoji'.dechex($unicode).'"></span>';
            }else{
                $unicode_str.=$val;
            }
        }
        return $unicode_str;
    }

    
    public function deletePostAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $article_model = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
            $ret = $article_model->deleteDFById($id,$this->curr_sid);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除帖子成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function postDetailsAction(){
        $id = $this->request->getIntParam('id');
        $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
        $post = $post_storage->getPostRowMemberDistance($id);
        $post['acp_content'] = $this->utf8_str_to_unicode($post['acp_content']);
        $this->output['post'] = $post;
        $this->_fetch_post_img($id);
        $this->_comment_list($id);
        $this->buildBreadcrumbs(array(
            array('title' => '帖子管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/post-details.tpl');
    }

    
    private function _fetch_post_img($pid){
        $attachment_model = new App_Model_City_MysqlCityPostAttachmentStorage($this->curr_sid);
        $list = $attachment_model->fetchAllAttachment($pid);
        $this->output['imgList'] = $list;
    }

    private function _comment_list($pid){
        $count = 30;
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $where[] = array('name'=>'acc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acc_acp_id','oper'=>'=','value'=>$pid);
        $comment_model = new App_Model_City_MysqlCityPostCommentStorage($this->curr_sid);
        $total      = $comment_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination'] = $pageCfg->render();
        $list = $comment_model->getCommentMember($pid,$index,$count);
        foreach($list as $key => $val){
            $list[$key]['acc_comment'] = $this->utf8_str_to_unicode($val['acc_comment']);
        }
        $this->output['commentList'] = $list;

    }

    
    public function saveCityMarkAction(){
        $mark = $this->request->getStrParam('mark');
        $markOpen = $this->request->getIntParam('markOpen');
        $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
        $index = $index_storage->findUpdateBySid(23);
        if($index){
            $data = array();
            $data['aci_manager_mark'] = $mark;
            $data['aci_manager_mark_open'] = $markOpen;
            if(!empty($data)){
                $ret = $index_storage->updateById($data,$index['aci_id']);
            }else{
                $ret = 0;
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("保存管理员标识成功");
            }

            $this->showAjaxResult($ret);

        }else{
            $this->displayJsonError('请先配置首页信息');
        }
    }
    
     public function savePostTipAction(){
        $tip         = $this->request->getStrParam('tip');
         $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
         $set        = array('s_post_tip'=>$tip);
         $ret = $shop_model->updateById($set,$this->curr_sid);

         if($ret){
             App_Helper_OperateLog::saveOperateLog("保存管帖子提示成功");
         }

         $this->showAjaxResult($ret);
     }

    

    
    public function postStatusChangeAction(){
        $pid = $this->request->getIntParam('pid');
        $status = $this->request->getIntParam('status');
        $ret = 0;
        if($pid){
            $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
            $post = $post_storage->getPostRowMemberDistance($pid);
            if($post){
                $set = array('acp_status'=>$status);
                $ret = $post_storage->updateById($set,$pid);
            }
        }

        if($status){
            $str = $status == 1 ? '封禁' : '解封';
            App_Helper_OperateLog::saveOperateLog("{$str}帖子成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function commentShowChangeAction(){
        $id = $this->request->getIntParam('id');
        $show = $this->request->getIntParam('show');
        $ret = 0;
        if($id){
            $comment_storage = new App_Model_City_MysqlCityPostCommentStorage($this->curr_sid);
            $comment = $comment_storage->getRowById($id);
            if($comment){
                $set = array('acc_show'=>$show);
                $ret = $comment_storage->updateById($set,$id);
            }
            if($ret){
                $postId = intval($comment['acc_acp_id']);
                $post_model = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
                $post = $post_model->getRowById($postId);
                if($show == 1){
                    $post_model->addReducePostNum($postId,'comment','add');
                }elseif ($show == 0 && $post['acp_comment_num'] > 0){
                    $post_model->addReducePostNum($postId,'comment','reduce');
                }
                $str = $show == 1 ? '展示' : '隐藏';
                App_Helper_OperateLog::saveOperateLog("{$str}帖子评论成功");
            }
        }
        $this->showAjaxResult($ret);
    }


    
    public function recommendShopListAction(){
        $page = $this->request->getIntParam('page');
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $count = 20;
        $index = $page * $count;
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_istop', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'acs_type', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shopList = $shop_storage->getList($where, $index, $count, $sort);
        $total      = $shop_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination']   = $pageCfg->render();
        $this->output['list'] = $shopList;
        $this->_get_area_category(2);
        $this->buildBreadcrumbs(array(
            array('title' => '推荐店铺管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/recommend-shop-list.tpl');
    }



    
    public function ordinaryShopListAction(){
        $page = $this->request->getIntParam('page');
        $shop_storage = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $count = 20;
        $index = $page * $count;
        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_istop', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_type', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $shopList = $shop_storage->getList($where, $index, $count, $sort);
        $total      = $shop_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination'] = $pageCfg->render();
        $this->output['list'] = $shopList;
        $this->_get_area_category(2);
        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/ordinary-shop-list.tpl');
    }

    
    public function addRecommendShopAction(){
        $id                  = $this->request->getIntParam('id');
        $shop_storage        = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $shop                = $shop_storage->getRowByIdSid($id, $this->curr_sid);
        $shop['acs_open_time'] = explode('-', $shop['acs_open_time']);
        $shop['acs_translate_contacter'] = json_decode($shop['acs_translate_contacter']);
        $shop['acs_translate_mobile'] = json_decode($shop['acs_translate_mobile']);
        $shop['acs_translate_address'] = json_decode($shop['acs_translate_address']);
        $shop['acs_translate_lng'] = json_decode($shop['acs_translate_lng']);
        $shop['acs_translate_lat'] = json_decode($shop['acs_translate_lat']);
        if(!$shop['acs_translate_mobile'][0]){
            $shop['acs_translate_mobile'][0] = $shop['acs_mobile'];
        }
        if(!$shop['acs_translate_address'][0]){
            $shop['acs_translate_address'][0] = $shop['acs_address'];
            $shop['acs_translate_lng'][0] = $shop['acs_lng'];
            $shop['acs_translate_lat'][0] = $shop['acs_lat'];
        }
        $this->output['row'] = $shop;
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList(2);
        $this->output['category_select'] = $category;

        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '/wxapp/city/recommendShopList'),
            array('title' => '添加店铺', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/city/add-recommend-shop.tpl");
    }


    
    public function addOrdinaryShopAction(){
        $id                  = $this->request->getIntParam('id');
        $shop_storage        = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $shop                = $shop_storage->getRowByIdSid($id, $this->curr_sid);
        $shop['acs_open_time'] = explode('-', $shop['acs_open_time']);
        $shop['acs_open_time'] = explode('-', $shop['acs_open_time']);
        $shop['acs_translate_contacter'] = json_decode($shop['acs_translate_contacter']);
        $shop['acs_translate_mobile'] = json_decode($shop['acs_translate_mobile']);
        $shop['acs_translate_address'] = json_decode($shop['acs_translate_address']);
        $shop['acs_translate_lng'] = json_decode($shop['acs_translate_lng']);
        $shop['acs_translate_lat'] = json_decode($shop['acs_translate_lat']);
        if(!$shop['acs_translate_mobile'][0]){
            $shop['acs_translate_mobile'][0] = $shop['acs_mobile'];
        }
        if(!$shop['acs_translate_address'][0]){
            $shop['acs_translate_address'][0] = $shop['acs_address'];
            $shop['acs_translate_lng'][0] = $shop['acs_lng'];
            $shop['acs_translate_lat'][0] = $shop['acs_lat'];
        }
        $this->output['row'] = $shop;
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList(2);
        $this->output['category_select'] = $category;

        $this->buildBreadcrumbs(array(
            array('title' => '店铺管理', 'link' => '/wxapp/city/ordinaryShopList'),
            array('title' => '添加店铺', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty("wxapp/city/add-ordinary-shop.tpl");
    }


    
    public function updatePostAction(){
        $id      = $this->request->getIntParam('id');
        $showNum = $this->request->getIntParam('showNum');
        $likeNum = $this->request->getIntParam('likeNum');
        $firstCate = $this->request->getIntParam('first_cate');
        $secondCate = $this->request->getIntParam('second_cate');
        if($id){
            $post_model = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
            if($likeNum>0){
                $like_ret = $post_model->addReducePostNum($id,'like','add',$likeNum);
            }
            if($showNum>0){
                $show_ret = $post_model->addReducePostNum($id,'show','add',$showNum);
            }
            if($firstCate || $secondCate){
                $post = $post_model->getRowById($id);
                if($post['acp_acc_id'] == $firstCate && $post['acp_second_id'] == $secondCate){
                  $cate_ret = true;
                }else{
                    $set = array(
                        'acp_acc_id' => $firstCate,
                        'acp_second_id' => $secondCate
                    );
                    $cate_ret = $post_model->updateById($set,$id);
                }
            }
        }
        if($like_ret || $show_ret || $cate_ret){
            $ret = 1;
        }else{
            $ret = 0;
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("修改帖子信息成功");
        }

        $this->showAjaxResult($ret,'修改');
    }

    
    public function deletePostCommentAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $comment_model = new App_Model_City_MysqlCityPostCommentStorage($this->curr_sid);
            $ret = $comment_model->deleteBySidId($id,$this->curr_sid);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除帖子评论成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    private function _statistics($type, $num){
        $tpl_model = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
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
    }
    
    public function withdrawAction() {
        if($this->curr_sid==7126){
            $this->_get_withdraw_list_data_currency();
            $this->output['tx_ma_map']      = plum_parse_config('applet_tx_ma_map');
            $this->output['withdrawType']   = plum_parse_config('applet_tx_map');
            $helper_model           = new App_Helper_ShopWeixin($this->curr_sid);
            $this->output['alert']  = $helper_model->checkShopMemberWithdraw();
            $this->showTypeByKey('withdraw_status');
            $this->buildBreadcrumbs(array(
                array('title' => '提现管理', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/city/withdraw-list-currency.tpl');
        }else{
            $this->_get_withdraw_list_data();
            $this->output['tx_ma_map']      = plum_parse_config('applet_tx_ma_map');
            $this->output['withdrawType']   = plum_parse_config('applet_tx_map');
            $helper_model           = new App_Helper_ShopWeixin($this->curr_sid);
            $this->output['alert']  = $helper_model->checkShopMemberWithdraw();
            $this->showTypeByKey('withdraw_status');
            $this->output['bankList'] = plum_parse_config('withdraw_bank_ids');
            $this->buildBreadcrumbs(array(
                array('title' => '提现管理', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/city/withdraw-list.tpl');
        }
    }

    private function _get_withdraw_list_data(){
        $output = array();
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort = array('wd_create_time' => 'DESC');

        $where = array();
        $where[] = array('name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name']   = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'wd_realname', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'wd_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['audit']  = $this->request->getStrParam('audit');
        switch($output['audit']){
            case 'refuse':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 2);
                break;
            case 'pass':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 1);
                break;
            case 'audit':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 0);
                break;
        }
        $where[] = array('name' => 'wd_source', 'oper' => '=', 'value' => 0);

        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $total          = $withdraw_model->getMemberCount($where);
        $page_plugin    = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list  = array();
        if($total > $index){
            $list = $withdraw_model->getMemberList($where,$index,$this->count,$sort);
        }
        $output['showPage'] = $total > $this->count ? 1 : 0;
        $output['list'] = $list;
        $where_total = $where_pass = $where_audit = [['name' => 'wd_source', 'oper' => '=', 'value' => 0]];
        $where_total[] = $where_pass[] = $where_audit[] = ['name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_pass[] = ['name' => 'wd_audit', 'oper' => '=', 'value' => 1];
        $where_audit[] = ['name' => 'wd_audit', 'oper' => '=', 'value' => 0];
        $totalInfo = $withdraw_model->getStatInfo($where_total);
        $passInfo = $withdraw_model->getStatInfo($where_pass);
        $auditInfo = $withdraw_model->getStatInfo($where_audit);
        $statInfo = [
            'totalCount' => intval($totalInfo['total']),
            'totalMoney' => floatval($totalInfo['money']),
            'passCount' => intval($passInfo['total']),
            'passMoney' => floatval($passInfo['money']),
            'auditCount' => intval($auditInfo['total']),
            'auditMoney' => floatval($auditInfo['money']),
        ];
        $output['statInfo'] = $statInfo;

        $this->showOutput($output);
    }
    private function _get_withdraw_list_data_currency(){
        $output = array();
        $page = $this->request->getIntParam('page');
        $index= $page * $this->count;
        $sort = array('wd_create_time' => 'DESC');

        $where = array();
        $where[] = array('name' => 'wd_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $output['name']   = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'wd_realname', 'oper' => 'like', 'value' => "%{$output['name']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'wd_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $output['audit']  = $this->request->getStrParam('audit');
        switch($output['audit']){
            case 'refuse':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 2);
                break;
            case 'pass':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 1);
                break;
            case 'audit':
                $where[] = array('name' => 'wd_audit', 'oper' => '=', 'value' => 0);
                break;
        }

        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $total          = $withdraw_model->getMemberCount($where);
        $page_plugin    = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $output['paginator'] = $page_plugin->render();
        $list  = array();
        if($total > $index){
            $list = $withdraw_model->getMemberCurrencyList($where,$index,$this->count,$sort);
        }
        $output['showPage'] = $total > $this->count ? 1 : 0;
        $output['list'] = $list;
        $this->showOutput($output);
    }
    
    public function dealWithdrawAction(){
        $id     = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');
        $type   = $this->request->getIntParam('type');
        $note   = $this->request->getStrParam('note');
        if($status == 1 && !$type){
            $this->displayJsonError('请选择转账方式');
        }
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        if($id && $status){
            $set = array(
                'wd_audit'      => $status,
                'wd_audit_note' => $note,
                'wd_audit_time' => time()
            );
            $where   = array();
            $where[] = array('name'=>'wd_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'wd_id','oper'=>'=','value'=>$id);
            $where[] = array('name'=>'wd_audit','oper'=>'=','value'=>0);
            $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
            $record = $withdraw_model->getRow($where);
            if($this->curr_shop['s_accountant_withdraw'] == 1 && $status == 1 && $record && ($this->wxapp_cfg['ac_type'] == 32 || $this->wxapp_cfg['ac_type'] == 36)){
                $accountant_model = new App_Model_Accountant_MysqlAccountantConfirmStorage($this->curr_sid);
                $exist = $accountant_model->getRowByTypeId(1,$record['wd_id']);
                if($exist){
                    $result['em'] = '处理已提交，请等待会计审核';
                }else{
                    $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getMemberLeaderRow($record['wd_m_id']);
                    $confirm = [
                        'aac_s_id' => $this->curr_sid,
                        'aac_manager_id' => $this->manager['m_id'],
                        'aac_manager_name' => $this->manager['m_nickname'],
                        'aac_confirm_id' => $record['wd_id'],
                        'aac_confirm_tid' => '',
                        'aac_type' => 1,//用户提现
                        'aac_nickname' => $member['m_nickname'],
                        'aac_realname' => $record['wd_realname'],
                        'aac_avatar'   => $member['m_avatar'],
                        'aac_member_type' => $member['asl_status'] == 2 ? 2 : 1,
                        'aac_money' => $record['wd_money'],
                        'aac_pay_type' => $type,
                        'aac_handle_status' => 1,
                        'aac_handle_remark' => $note,
                        'aac_create_time' => time()
                    ];
                    $res = $accountant_model->insertValue($confirm);
                    if($res){
                        $set['wd_audit'] = 3;
                        $ret = $withdraw_model->updateValue($set,$where);
                        $result = array(
                            'ec' => 200,
                            'em' => '处理已提交，请等待会计审核'
                        );
                    }else{
                        $result['em'] = '处理失败';
                    }
                }

            }elseif(!($this->curr_shop['s_accountant_withdraw'] == 1 && $status == 1) && $record){
                $flag = true;
                $tid  = '';
                if(($record['wd_type'] == 1 || $record['wd_type'] == 3) && $status == 1 && in_array($type,array(1,2,3))){
                    $payRes = $this->_applet_weixin_auto_deal($record,$type);
                    if(!empty($payRes) && $payRes['errno'] == true){
                        $tid = $payRes['send_listid'];
                    }else{
                        $flag = false;
                        $result['em'] = isset($payRes['errmsg']) ? $payRes['errmsg'] :'微信红包支付失败';
                    }
                }
                if($flag){
                    if($status == 1){
                        $set['wd_curr_type']  = $type;
                    }
                    $ret = $withdraw_model->updateValue($set,$where);
                    $this->_deal_withdraw_result($record,$status,$tid);
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '处理成功'
                        );
                        $str = $status == 1 ? '通过' : '不通过';
                        App_Helper_OperateLog::saveOperateLog("处理提现申请成功，处理结果：{$str}");
                    }else{
                        $result['em'] = '处理失败';
                    }
                }
            }
        }
        $this->displayJson($result);
    }

    
    public function _deal_withdraw_result(array $record,$status,$tid=''){

        if($this->curr_sid==7126){
            $account_model = new App_Model_City_MysqlCityAccountStorage($this->curr_sid);
            $money_ret = $account_model->dealWithdrawMoney($record,$record['wd_money'],$status);
        }elseif ($record['wd_source'] == 2){
            $rider_model = new App_Model_Handy_MysqlHandyRiderStorage($this->curr_sid);
            $money_ret = $rider_model->dealWithdrawMoney($record['wd_rider'],$record['wd_money'],$status);
        }else{
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $money_ret = $member_model->dealWithdrawMoney($record['wd_m_id'],$record['wd_money'],$status);
        }
        if($status == 1){//审核通过，则记录流水
            $data = array(
                'dd_s_id'           => $this->curr_sid,
                'dd_m_id'           => $record['wd_m_id'],
                'dd_o_id'           => $record['wd_id'],
                'dd_amount'         => $record['wd_money'],
                'dd_tid'            => $tid,
                'dd_level'          => 0,
                'dd_record_type'    => $record['wd_source'] == 2 ? 8 : 4,
                'dd_record_time'    => time(),
                'dd_record_remark'  => '提现申请通过记录流水'
            );
            $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $book_ret = $book_model->insertValue($data);
        }
        if($money_ret || $book_ret){
            return true;
        }else{
            return false;
        }
    }

    
    public function withdrawCfgAction(){
        $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
        $row = $cgf_model->findCfgBySid($this->curr_sid);
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '提现管理', 'link' => '/wxapp/city/withdraw'),
            array('title' => '提现配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/withdraw-cfg.tpl');
    }

    
    public function saveWithdrawCfgAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求参数错误'
        );
        $data['wc_desc']       = $this->request->getStrParam('wc_desc');
        $data['wc_min']        = $this->request->getFloatParam('wc_min');
        $data['wc_goodsfee_min']        = $this->request->getFloatParam('wc_goodsfee_min');
        $data['wc_change_open']= $this->request->getIntParam('wc_wx_open');
        $data['wc_bank_open']  = $this->request->getIntParam('wc_bank_open');
        $data['wc_auto']  = $this->request->getIntParam('wc_auto');
        $data['wc_mobile_open']  = $this->request->getIntParam('wc_mobile_open');
        $data['wc_account_open']  = $this->request->getIntParam('wc_account_open');
        $data['wc_bank_mobile_open']  = $this->request->getIntParam('wc_bank_mobile_open');
        $data['wc_update_time']= time();
        $data['wc_rate']    =  $this->request->getFloatParam('wc_rate');
        $cgf_model =  new App_Model_Shop_MysqlWithdrawCfgStorage();
        $row = $cgf_model->findCfgBySid($this->curr_sid);
        if($row && isset($row['wc_id']) && $row['wc_id']){
            $ret = $cgf_model->updateById($data,$row['wc_id']);
        }else{
            $data['wc_s_id'] = $this->curr_sid;
            $data['wc_createtime'] = time();
            $ret = $cgf_model->insertValue($data);
        }
        $this->_save_applet_public_key();
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("保存提现配置成功");
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
    }

    
    public function _applet_weixin_auto_deal(array $record, $pay_type = self::WEIXIN_PAT_REDPACK,$accountant = false) {
        if (!in_array($record['wd_type'],array(self::WEIXIN_PAT_REDPACK,self::WEIXIN_PAY_BANK))) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        if($accountant){
            if ($record['wd_audit'] != 3) {
                return array('errno' => false, 'errmsg' => '非待审核状态');
            }
        }else{
            if ($record['wd_audit'] != 0) {
                return array('errno' => false, 'errmsg' => '非待审核状态');
            }
        }

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);
        $pay_storage    = new App_Model_Auth_MysqlPayTypeStorage($this->curr_sid);
        $payCfg = $pay_storage->findRowPay();
        if(!$payCfg || !$payCfg['pt_wxpay_applet']){
            return array('errno' => false, 'errmsg' => '请在支付配置中开启微信支付');
        }
        if ($payCfg && $payCfg['pt_wxpay_applet']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $money          = $record['wd_money']-$record['wd_service_money'];
            if($this->wxapp_cfg['ac_type'] == 30){
                $money = $money['wd_real_money'];
            }
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'], $money);
            } else if($pay_type == self::WEIXIN_PAY_TRANSFER) {
                $ret    = $wxpay_plugin->appletPayTransfer($member['m_openid'], $money, $record['wd_realname']);
            } else if($pay_type == self::WEIXIN_PAY_BANK) {
                $ret    = $wxpay_plugin->appletPayBank($record['wd_account'], $record['wd_realname'], $record['wd_bank'],$money);
            }
        }

        if ($ret && !$ret['code']) {
            return array('errno' => true, 'errmsg' => '微信转账成功');
        } else {
            return array('errno' => false, 'errmsg' => $ret['errmsg']);
        }
    }

    
    private function _save_applet_public_key(){
        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $payCfg = $pay_model->findRowPay();
        if($payCfg && $payCfg['ap_sslcert'] && $payCfg['ap_sslkey'] && !$payCfg['ap_pubpem']){
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($this->curr_sid);
            $retsult = $wxpay_plugin->appletPublicKey();
            if($retsult['code']==0){
                $updata = array(
                    'ap_pubpem' => $retsult['filename']
                );
                $pay_model->findRowPay($updata);
            }
        }
    }

    
    public function shopListPageAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 23);
        $this->_get_shoplist_cfg();
        $this->showShopTplSlide($tpl_id,6);
        $this->showShortcut(2);
        $this->_shop_information();
        $this->_shop_list();
        $this->_show_shop_list();
        $this->_recommend_shop();
        $this->_get_list_for_select();
        $this->_ordinary_goods_group();
        $this->_shop_top_goods_list();
        $this->_limit_group();//秒杀商品分组
        $this->_shop_kind_list_for_select();
        $this->_recommend_shop_list();
        $this->_curr_first_kind_list_for_select();
        $this->_curr_second_kind_list_for_select();
        $this->_shop_category(2);
        $this->_get_jump_list();
        $this->_get_information_category();
        $this->_get_goods_group();
        $this->showShopTplShortcut(-3);
        $this->_get_post_category();

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商家列表', 'link' => '/wxapp/city/shopList'),
            array('title' => '商家列表设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/shop_list_cfg.tpl');
    }

    
    private function _get_goods_group(){
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

    
    private function _get_shoplist_cfg(){
        $tpl_model = new App_Model_City_MysqlCityShopListCfgStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();

        if(empty($tpl)){
            $tpl = array(
                'acsc_shortcut' => 0,
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _recommend_shop(){
        $recommend_model      = new App_Model_City_MysqlCityRecommendStorage($this->curr_sid);
        $where     = array();
        $where[]   = array('name'=>'acr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort      = array('acr_sort'=>'ASC');
        $recommend = $recommend_model->getList($where,0,0,$sort);
        $json = array();
        foreach($recommend as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'link'         => $val['acr_link'],
                'type'         => $val['acr_type'],
                'imgsrc'       => $val['acr_cover'],
                'name'         => $val['acr_name'],
            );
        }
        $this->output['recommendList'] = json_encode($json);
    }
    public function saveShopListPageAction(){
        $tpl_id       = $this->request->getIntParam('tpl_id',23);
        $ret=$this->save_shop_slide_new($tpl_id,6);
        $res=$this->_save_shop_recommend();
        $this->save_shop_shortcut_new(-3);
        $this->_save_shoplist_cfg();

        if($ret||$res){
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
            if($ret){
                App_Helper_OperateLog::saveOperateLog("保存商家列表配置成功");
            }
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
    }

    
    private function _save_shoplist_cfg(){
        $showShortcut = $this->request->getIntParam('showShortcut');
        $set = [
            'acsc_update_time' => time(),
            'acsc_shortcut' => $showShortcut
        ];
        $cfg_model = new App_Model_City_MysqlCityShopListCfgStorage($this->curr_sid);
        $exist = $cfg_model->findUpdateBySid();
        if($exist){
            $res = $cfg_model->findUpdateBySid($set);
        }else{
            $set['acsc_s_id'] = $this->curr_sid;
            $set['acsc_create_time'] = time();
            $res = $cfg_model->insertValue($set);
        }
    }

    
    public function saveSettledAgreementAction(){
        $settledAgreement = $this->request->getParam('settledAgreement');
        if($settledAgreement){
            $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $index = $index_storage->findUpdateBySid();
            if($index){
                $data['aci_agreement'] = $settledAgreement;
                $ret = $index_storage->findUpdateBySid(23,$data);
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("入驻协议成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请填写入驻协议');
        }
    }

    
    private function _save_shop_recommend(){
        $recommend_model      = new App_Model_City_MysqlCityRecommendStorage($this->curr_sid);
        $recommend = $this->request->getArrParam('recommend');
        if(!empty($recommend)){
            $shortcut_list = $recommend_model->fetchRecommendShowList();
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['acr_sort']])){
                        $set = array(
                            'acr_sort'            => $recommend[$val['acr_sort']]['index'],
                            'acr_type'            => $recommend[$val['acr_sort']]['type'],
                            'acr_link'            => $recommend[$val['acr_sort']]['link'],
                            'acr_name'            => $recommend[$val['acr_sort']]['name'],
                            'acr_cover'           => $recommend[$val['acr_sort']]['imgsrc'],
                        );
                        $up_ret = $recommend_model->updateById($set,$val['acr_id']);
                        unset($recommend[$val['acr_sort']]);
                    }else{
                        $del_id[] = $val['acr_id'];
                    }
                }
                if(!empty($del_id)){
                    $recommend_where = array();
                    $recommend_where[] = array('name' => 'acr_id','oper' => 'in' , 'value' => $del_id);
                    $recommend_model->deleteValue($recommend_where);
                }

            }
            if(!empty($recommend)){
                $insert = array();
                foreach($recommend as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['name']}','{$val['imgsrc']}','{$val['link']}', '{$val['type']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $recommend_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $recommend_model->deleteValue($where);
        }
    }
    public function changeExpireAction(){
        $id  = $this->request->getIntParam('id');
        $expire = $this->request->getIntParam('expire',0);
        $expireNow = $this->request->getIntParam('now_expire',0);
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        if($expire){
            if($expire>=12){
                $expireTime = intval(floor($expire/12))*365*86400 + intval(($expire%12))*30*86400;
            }else{
                $expireTime = $expire*30*86400;
            }
            $data = array(
                'acs_expire_time' =>  $expireNow + $expireTime
            );
            $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $res = $shop_model->updateById($data,$id);
            if($res){
                $shop = $shop_model->getRowById($id);
                if($shop['acs_es_id'] > 0){
                    $es_model = new App_Model_Entershop_MysqlEnterShopStorage();
                    $set = array(
                        'es_expire_time' => $expireNow + $expireTime
                    );
                    $es_model->updateById($set,$shop['acs_es_id']);
                }

                $result = array(
                    'ec' => 200,
                    'em' => '修改成功'
                );
                App_Helper_OperateLog::saveOperateLog("修改入驻店铺到期时间成功");
            }
        }else{
            $result = array(
            'ec' => 400,
            'em' => '请填写正确的时间'
            );
        }
        $this->displayJson($result);
    }

     
    public function shopPayRecordAction(){
        $id   = $this->request->getIntParam('id');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $cost_storage = new App_Model_City_MysqlCityPostPayStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'cpp_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'cpp_acs_id', 'oper' => '=', 'value' => $id);
        $sort = array('cpp_create_time' => 'DESC');
        $total      = $cost_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list = $cost_storage->getList($where, $index, $this->count, $sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '同城店铺', 'link' => '/wxapp/city/shopList'),
            array('title' => '付费记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/shop-pay-record.tpl');
    }

    
    public function removeQrcodeAction(){
        $id = $this->request->getIntParam('id');
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_id', 'oper' => '=', 'value' => $id);

        $set = array(
            'acs_code_cover' => ''
        );
        $acs_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $res = $acs_model->updateValue($set,$where);

        if($res){
            App_Helper_OperateLog::saveOperateLog("清除商家小程序码成功");
        }

        $this->showAjaxResult($res,'清除');
    }

    

    

    
    public function commentDetailsAction(){
        $id = $this->request->getIntParam('id');
        $post_storage = new App_Model_City_MysqlCityShopCommentStorage($this->curr_sid);
        $post = $post_storage->getCommentRowWithMemberShop($id);
        $post['acs_comment'] = $this->utf8_str_to_unicode($post['acs_comment']);
        $this->output['post'] = $post;
        $this->output['imgList'] = json_decode($post['acs_comment_img']);
        $this->buildBreadcrumbs(array(
            array('title' => '商家评论管理', 'link' => '/wxapp/city/commentList'),
            array('title' => '评论详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/shop-comment-details.tpl');
    }

    
    public function deleteCommentAction(){
        $cid = $this->request->getIntParam('cid');
        $ret = 0;
        if($cid){
            $post_storage = new App_Model_City_MysqlCityShopCommentStorage($this->curr_sid);
            $set = array('acs_deleted' => 1);
            $ret = $post_storage->updateById($set,$cid);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除评论成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function commentListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $this->output['shopName'] = $this->request->getStrParam('shopName');
        if($this->output['shopName']){
            $where[]        = array('name' => 'shop.acs_name', 'oper' => 'like', 'value' => "%{$this->output['shopName']}%");
        }
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => 'acs.acs_comment', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $out['start']   = $this->request->getStrParam('start');
        if($out['start']){
            $where[]    = array('name' => 'acs.acs_time', 'oper' => '>=', 'value' => strtotime($out['start']));
        }
        $out['end']     = $this->request->getStrParam('end');
        if($out['end']){
            $where[]    = array('name' => 'acs.acs_time', 'oper' => '<=', 'value' => (strtotime($out['end']) + 86400));
        }
        $where[] = array('name'=>'acs.acs_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'acs.acs_deleted','oper'=>'=','value'=> 0);
        $post_storage = new App_Model_City_MysqlCityShopCommentStorage($this->curr_sid);
        $total      = $post_storage->getCommentCountWithMemberShop($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list          = $post_storage->getCommentListWithMemberShop($where, $index,$this->count);
        }
        foreach($list as $key=>$val){
            $list[$key]['acs_comment'] = $this->utf8_str_to_unicode($val['acs_comment']);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '商家评论管理', 'link' => '#'),
        ));
        $where = array();
        $where[] = array('name' => 'acs.acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $total      = $post_storage->getCommentCountWithMemberShop($where);
        $where[1] = array('name' => 'acs.acs_stars', 'oper' => '=', 'value' => 5);
        $total_5 = $post_storage->getCommentCountWithMemberShop($where);
        $where[1] = array('name' => 'acs.acs_stars', 'oper' => '=', 'value' => 4);
        $total_4 = $post_storage->getCommentCountWithMemberShop($where);
        $where[1] = array('name' => 'acs.acs_stars', 'oper' => '=', 'value' => 3);
        $total_3 = $post_storage->getCommentCountWithMemberShop($where);
        $where[1] = array('name' => 'acs.acs_stars', 'oper' => '=', 'value' => 2);
        $total_2 = $post_storage->getCommentCountWithMemberShop($where);
        $where[1] = array('name' => 'acs.acs_stars', 'oper' => '=', 'value' => 1);
        $total_1 = $post_storage->getCommentCountWithMemberShop($where);

        $this->output['statInfo'] = [
            'total'     => $total ? $total : 0,
            'total_5'   => $total_5 ? $total_5 : 0,
            'total_4'   => $total_4 ? $total_4 : 0,
            'total_3'   => $total_3 ? $total_3 : 0,
            'total_2'   => $total_2 ? $total_2 : 0,
            'total_1'   => $total_1 ? $total_1 : 0,
        ];

        $this->displaySmarty('wxapp/city/shop-comment-list.tpl');
    }


    
    public function changeBelongAction(){
        $id = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');

        $res = FALSE;
        if($id && $mid){
            $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $where_row[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where_row[] = array('name' => 'acs_m_id', 'oper' => '=', 'value' => $mid);
            $row = $shop_model->getRow($where_row);
            if($row){
                $this->displayJsonError('该会员已入驻');
            }
            $set = array(
                'acs_m_id' => $mid
            );
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_id', 'oper' => '=', 'value' => $id);
            $res = $shop_model->updateValue($set,$where);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("修改入驻店铺所属用户成功");
        }

        $this->showAjaxResult($res,'修改');
    }
    public function deleteMemberAction(){
        $shop_id=$this->request->getIntParam('shop_id');
        if($shop_id){
            $shop_model=new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $shop_row=$shop_model->getRow([
                ['name'=>'acs_s_id','oper'=>'=','value'=>$this->curr_sid],
                ['name'=>'acs_id','oper'=>'=','value'=>$shop_id]
            ]);
            if(empty($shop_row['acs_m_id'])){
                $this->displayJsonError('未绑定会员信息');
            }
            $where=[
                ['name'=>'acs_id','oper'=>'=','value'=>$shop_id],
                ['name'=>'acs_s_id','oper'=>'=','value'=>$this->curr_sid]
            ];
            $data=[
                'acs_m_id'=>0
            ];
            $res=$shop_model->updateValue($data,$where);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("删除入驻店铺所属用户成功");
        }

        $this->showAjaxResult($res?$res:false,'删除');
    }

    
    public function adAction(){
        $setup_model = new App_Model_Applet_MysqlAppletAdvertisementStorage($this->curr_sid);
        $row = $setup_model->findOneBySid();
        if(in_array($this->wxapp_cfg['ac_type'],array(5,6,4,12,7,13,8,21,27,29))){
            $this->output['wms'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(6,4,12,7,13,21,27,29))){
            $this->output['wkj'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(2,6,4,12,7,13,8,21,27,29))){
            $this->output['wpt'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(6,50,3,21,22,1,29))){
            $this->output['prize'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(6,3,13,18,8,21,1,29))){
            $this->output['dhb'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(6,21,29))){
            $this->output['dt'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(4,13,1,3,9,10,12,11,6,2,5,7,18,21,22,8))){
            $this->output['payShort'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(6,29))){
            $this->output['mpj'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(6,4,13,8,21,27,29))){
            $this->output['pointGoods'] = 1;
        }
        if(in_array($this->wxapp_cfg['ac_type'],array(21,32))){
            $this->output['zdhb'] = 1;
        }


        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '广告位管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/ad-setup.tpl');
    }

    
    public function saveAdAction() {
        $data['aa_pl_id']     = $this->request->getStrParam('pl_id');
        $data['aa_pl_open']   = $this->request->getIntParam('pl_open');
        $data['aa_pd_id']     = $this->request->getStrParam('pd_id');
        $data['aa_pd_open']   = $this->request->getIntParam('pd_open');
        $data['aa_il_id']     = $this->request->getStrParam('il_id');
        $data['aa_il_open']   = $this->request->getIntParam('il_open');
        $data['aa_id_id']     = $this->request->getStrParam('id_id');
        $data['aa_id_open']   = $this->request->getIntParam('id_open');
        $data['aa_tp_id']     = $this->request->getStrParam('tp_id');
        $data['aa_tp_open']   = $this->request->getIntParam('tp_open');
        $data['aa_sl_id']     = $this->request->getStrParam('sl_id');
        $data['aa_sl_open']   = $this->request->getIntParam('sl_open');
        $data['aa_wms_id']     = $this->request->getStrParam('wms_id');
        $data['aa_wms_open']   = $this->request->getIntParam('wms_open');
        $data['aa_wkj_id']     = $this->request->getStrParam('wkj_id');
        $data['aa_wkj_open']   = $this->request->getIntParam('wkj_open');
        $data['aa_wpt_id']     = $this->request->getStrParam('wpt_id');
        $data['aa_wpt_open']   = $this->request->getIntParam('wpt_open');
        $data['aa_prize_id']     = $this->request->getStrParam('prize_id');
        $data['aa_prize_open']   = $this->request->getIntParam('prize_open');
        $data['aa_dhbl_id']     = $this->request->getStrParam('dhbl_id');
        $data['aa_dhbl_open']   = $this->request->getIntParam('dhbl_open');
        $data['aa_dhbd_id']     = $this->request->getStrParam('dhbd_id');
        $data['aa_dhbd_open']   = $this->request->getIntParam('dhbd_open');
        $data['aa_dti_id']     = $this->request->getStrParam('dti_id');
        $data['aa_dti_open']   = $this->request->getIntParam('dti_open');
        $data['aa_dta_id']     = $this->request->getStrParam('dta_id');
        $data['aa_dta_open']   = $this->request->getIntParam('dta_open');
        $data['aa_ps_id']     = $this->request->getStrParam('ps_id');
        $data['aa_ps_open']   = $this->request->getIntParam('ps_open');
        $data['aa_mpj_id']     = $this->request->getStrParam('mpj_id');
        $data['aa_mpj_open']   = $this->request->getIntParam('mpj_open');
        $data['aa_pg_id']     = $this->request->getStrParam('pg_id');
        $data['aa_pg_open']   = $this->request->getIntParam('pg_open');

        $data['aa_game_recommend_id']   = $this->request->getStrParam('game_recommend_id');
        $data['aa_game_recommend_open'] = $this->request->getIntParam('game_recommend_open');
        $data['aa_game_rank_id']        = $this->request->getStrParam('game_rank_id');
        $data['aa_game_rank_open']      = $this->request->getIntParam('game_rank_open');
        $data['aa_game_lottery_id']     = $this->request->getStrParam('game_lottery_id');
        $data['aa_game_lottery_open']   = $this->request->getIntParam('game_lottery_open');
        $data['aa_game_task_id']        = $this->request->getStrParam('game_task_id');
        $data['aa_game_task_open']      = $this->request->getIntParam('game_task_open');

        $data['aa_job_index_id']        = $this->request->getStrParam('job_index_id');
        $data['aa_job_index_open']      = $this->request->getIntParam('job_index_open');
        $data['aa_job_list_id']        = $this->request->getStrParam('job_list_id');
        $data['aa_job_list_open']      = $this->request->getIntParam('job_list_open');
        $data['aa_job_detail_id']        = $this->request->getStrParam('job_detail_id');
        $data['aa_job_detail_open']      = $this->request->getIntParam('job_detail_open');
        $data['aa_job_resume_id']        = $this->request->getStrParam('job_resume_id');
        $data['aa_job_resume_open']      = $this->request->getIntParam('job_resume_open');
        $data['aa_zdhb_id']        = $this->request->getStrParam('zdhb_id');
        $data['aa_zdhb_open']      = $this->request->getIntParam('zdhb_open');
        $data['aa_prize_baidu_id']        = $this->request->getStrParam('prize_baidu_id');
        $data['aa_dhbl_baidu_id']        = $this->request->getStrParam('dhbl_baidu_id');
        $data['aa_id_baidu_id']        = $this->request->getStrParam('id_baidu_id');
        $data['aa_il_baidu_id']        = $this->request->getStrParam('il_baidu_id');
        $data['aa_dhbd_baidu_id']        = $this->request->getStrParam('dhbd_baidu_id');
        $data['aa_ps_baidu_id']        = $this->request->getStrParam('ps_baidu_id');
        $data['aa_update_time']  = time();
        $data['aa_s_id']         = $this->curr_sid;
        $setup_model = new App_Model_Applet_MysqlAppletAdvertisementStorage($this->curr_sid);
        $row = $setup_model->findOneBySid();
        if($row){
            $ret = $setup_model->updateById($data, $row['aa_id']);
        }else{
            $data['aa_create_time'] = time();
            $ret =  $setup_model->insertValue($data);
        }

        App_Helper_OperateLog::saveOperateLog("广告位配置信息保存成功");
        $this->showAjaxResult($ret);
    }


    

    
    private function showMallShopTpl(){
        $tpl_model = new App_Model_Mall_MysqlMallUniversalStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid(0);
        if(empty($tpl)){
            $tpl = array(
                'amu_title'      => '店铺首页',
                'amu_recommend_open'  => 1
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function goodsGroup(){
        $where      = array();
        $where[]    = array('name' => 'gg_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'gg_is_eshop','oper' => '=','value' =>1);
        $group_model    = new App_Model_Goods_MysqlGroupStorage($this->curr_sid);
        $sort = array('gg_create_time' => 'DESC');
        $list = $group_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['gg_id'],
                    'name' => $val['gg_name'],
                );
            }
        }
        $this->output['goodsGroup'] = json_encode($data);
    }

    
    private function _recommend_goods_list($tpl){
        $recommend_model = new App_Model_City_MysqlCityMallRecommendStorage($this->curr_sid);
        $recommend_list = $recommend_model->fetchRecommendShowList();
        $data = array();
        if($recommend_list){
            foreach ($recommend_list as $val){
                $data[] = array(
                    'name'     => $val['acmr_name'],
                    'imgsrc'   => isset($val['acmr_img']) && $val['acmr_img'] ? $val['acmr_img'] :'',
                    'link'     => $val['acmr_link'],
                    'index'    => $val['acmr_weight'],
                    'linkType' => $val['acmr_link_type'],
                    'esId'     => $val['acmr_es_id']
                );
            }

        }else{
            for($i=0;$i<3;$i++){
                if($i == 0){
                    $data[] = array(
                        'name'     => '推荐',
                        'brief'    => '',
                        'imgsrc'   => '/public/manage/img/zhanwei/zw_fxb_350_425.png',
                        'link'     => 0,
                        'index'    => $i,
                        'linkType' => 27,
                        'esId'     => 0,
                    );
                }else{
                    $data[] = array(
                        'name'     => '推荐',
                        'brief'    => '',
                        'imgsrc'   => '/public/manage/img/zhanwei/zw_fxb_35_21.png',
                        'link'     => 0,
                        'index'    => $i,
                        'linkType' => 27,
                        'esId'     => 0,
                    );
                }

            }
        }
        $this->output['recommendGoods'] = json_encode($data);
    }

    
    private function _shop_mall_kind_list(){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        $kind_list = $kind_model->fetchKindShowList(0);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $data[] = array(
                    'title'     => $val['amk_name'],
                    'link'      => $val['amk_link'],
                    'index'     => $val['amk_weight'],
                    'imgsrc'    => $val['amk_img'],
                    'type'      => $val['amk_goods_list'],
                    'sign'      => $val['amk_sign'],
                );
            }
        }else{
            $data[] = array(
                'title'  => '标题',
                'link'   => 0,
                'index'  => 0,
                'type'   => 4,
                'sign'   => '新品上市 先买先得',
                'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_750_180.png'
            );
        }
        $this->output['kindList'] = json_encode($data);
    }
    private function _save_mall_shop_kind(){
        $kind = $this->request->getArrParam('kind');
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        if(!empty($kind)){
            $kind_list = $kind_model->fetchKindShowList(0);
            if(!empty($kind_list)){
                $del_id = array();
                foreach($kind_list as $val){
                    if(isset($kind[$val['amr_weight']])){
                        $set = array(
                            'amk_weight'        => $kind[$val['amk_weight']]['index'],
                            'amk_name'          => $kind[$val['amk_weight']]['title'],
                            'amk_link'          => $kind[$val['amk_weight']]['link'],
                            'amk_img'           => $kind[$val['amk_weight']]['imgsrc'],
                            'amk_goods_list'    => 4,
                            'amk_sign'          => $kind[$val['amk_weight']]['sign'],
                        );
                        $up_ret = $kind_model->updateById($set,$val['amk_id']);
                        unset($kind[$val['amk_weight']]);
                    }else{
                        $del_id[] = $val['amk_id'];
                    }
                }
                if(!empty($del_id)){
                    $kind_where = array();
                    $kind_where[] = array('name' => 'amk_id','oper' => 'in' , 'value' => $del_id);
                    $kind_model->deleteValue($kind_where);
                }

            }
            if(!empty($kind)){
                $insert = array();
                foreach($kind as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', 0, '{$val['title']}', '{$val['imgsrc']}','{$val['link']}','{$val['sign']}','4', '{$val['index']}','".time()."') ";
                }
                $ins_ret = $kind_model->newInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'amk_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => 0);
            $kind_model->deleteValue($where);
        }

    }

    
    private function _save_mall_recommend($tpl_id){
        $recommend = $this->request->getArrParam('recommendGood');
        $recommend_model = new App_Model_City_MysqlCityMallRecommendStorage($this->curr_sid);
        if(!empty($recommend)){
            $recommend_list = $recommend_model->fetchRecommendShowList();
            if(!empty($recommend_list)){
                $del_id = array();
                foreach($recommend_list as $val){
                    if(isset($recommend[$val['amr_weight']])){
                        $set = array(
                            'acmr_weight' => $recommend[$val['acmr_weight']]['index'],
                            'acmr_img'    => $recommend[$val['acmr_weight']]['imgsrc'],
                            'acmr_link'   => $recommend[$val['acmr_weight']]['link'],
                            'acmr_link_type'   => $recommend[$val['acmr_weight']]['linkType'],
                        );
                        $up_ret = $recommend_model->updateById($set,$val['acmr_id']);
                        unset($recommend[$val['acmr_weight']]);
                    }else{
                        $del_id[] = $val['acmr_id'];
                    }
                }
                if(!empty($del_id)){
                    $recommend_where = array();
                    $recommend_where[] = array('name' => 'acmr_id','oper' => 'in' , 'value' => $del_id);
                    $recommend_model->deleteValue($recommend_where);
                }

            }
            if(!empty($recommend)){
                $insert = array();
                foreach($recommend as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', '', '{$val['imgsrc']}', '{$val['link']}', '{$val['index']}','{$val['linkType']}','','".time()."') ";
                }
                $ins_ret = $recommend_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acmr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $recommend_model->deleteValue($where);
        }

    }

    
    private function _entershop_top_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_es_id','oper' => '!=','value' =>0);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $where[]        = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[]        = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('g_update_time' => 'DESC');
        $goods_list = $goods_model->getShopGoodsList($where,0,0,$sort);
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


    
    public function changeInfoAction(){
        $id = $this->request->getIntParam('id',0);
        $acsId = $this->request->getStrParam('acsId');
        $mobile = $this->request->getStrParam('mobile');
        $password = $this->request->getStrParam('password');

        $acs_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
        $acsRow = $acs_model->getRowByIdSid($acsId,$this->curr_sid);
        $where[]    = array('name' => 'esm_mobile', 'oper' => '=', 'value' => $mobile);
        if($id){
            $where[]    = array('name' => 'esm_id', 'oper' => '!=', 'value' => $id);
        }
        $exist = $manager_storage->getRow($where);
        if($exist){
            $this->displayJsonError('手机号已被占用');
        }
        if($this->curr_sid != 7448 && !plum_is_phone($mobile)){
            $this->displayJsonError('请填写正确的手机号');
        }
        if($acsRow && $acsRow['acs_status'] != 1){
            if($acsRow['acs_es_id'] > 0 && $id){//同城店铺有后台有管理员
                $mset = array('esm_mobile' => $mobile, 'esm_password'=>plum_salt_password($password));
                $mret = $manager_storage->updateById($mset, $id);
                if($mret){
                    App_Helper_OperateLog::saveOperateLog("保存店铺登录账户信息成功");
                    $this->showAjaxResult(1);
                }else{
                    $this->showAjaxResult(0);
                }
            }elseif($acsRow['acs_es_id'] > 0 && $id == 0){//同城店铺有后台无管理员
                $res = $this->_add_enter_shop_manager($acsRow['acs_es_id'],$mobile,$password);

                if($res){
                    App_Helper_OperateLog::saveOperateLog("保存店铺登录账户信息成功");
                }

                $this->showAjaxResult($res);
            }else{//同城店铺无后台
                $res = false;
                $esId = $this->_add_enter_shop($acsRow);
                if($esId){
                    $acs_model->updateById(array('acs_es_id' => $esId),$acsId);
                    $res = $this->_add_enter_shop_manager($esId,$mobile,$password);
                }
                if($res){
                    App_Helper_OperateLog::saveOperateLog("保存店铺登录账户信息成功");
                }

                $this->showAjaxResult($res);
            }

        }else{
            $this->displayJsonError('店铺信息不存在');
        }

    }

    
    private function _add_enter_shop($acsRow, $joinDistrib=1){
        $es_model    = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        $es_data = array(
            'es_unique_id'   => plum_uniqid_base36(),
            'es_contact'     => $acsRow['acs_name'],
            'es_m_id'        => $acsRow['acs_m_id'],
            'es_phone'       => $acsRow['acs_mobile'],
            'es_name'        => $acsRow['acs_name'],
            'es_s_id'        => $this->curr_sid,
            'es_logo'        => $acsRow['acs_img'],
            'es_addr'        => $acsRow['acs_address'],
            'es_lng'         => $acsRow['acs_lng'],
            'es_lat'         => $acsRow['acs_lat'],
            'es_label'       => $acsRow['acs_label'],
            'es_join_distrib' => $joinDistrib,
            'es_open_time'   => time(),
            'es_expire_time' => $acsRow['acs_expire_time'] ? $acsRow['acs_expire_time'] : (time()+365*86400),
            'es_createtime'  => time(),
            'es_status'      => 0
        );
        return $es_model->insertValue($es_data);
    }

    
    private function _add_enter_shop_manager($esId,$mobile,$password){
        $manager_storage    = new App_Model_Entershop_MysqlManagerStorage();
        $where[]    = array('name' => 'esm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'esm_es_id', 'oper' => '=', 'value' => $esId);
        $exist = $manager_storage->getRow($where);
        if($exist){
            return false;
        }else{
            $mgdata = array(
                'esm_s_id'       => $this->curr_sid,
                'esm_es_id'      => $esId,
                'esm_mobile'     => $mobile,
                'esm_nickname'   => $password,
                'esm_password'   => plum_salt_password($password),
                'esm_createtime' => time(),
                'esm_status'     => 0,
            );
            return $manager_storage->insertValue($mgdata);
        }

    }

    
    public function applyDetailAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商家管理', 'link' => '#'),
            array('title' => '申请入驻商家', 'link' => '/wxapp/city/shopApplyEnter'),
            array('title' => '商家详情', 'link' => '#'),
        ));
        $id = $this->request->getIntParam('id');
        $apply_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $row = $apply_model->getRowById($id);

        $aptitudeArr = [];
        $aptitude_arr = json_decode($row['acs_aptitude_arr'],1);
        if(is_array($aptitude_arr) && !empty($aptitude_arr)){
            $aptitudeArr = $aptitude_arr;
        }
        if($row['acs_aptitude']){
            $aptitudeArr[] = $row['acs_aptitude'];
        }
        $this->output['aptitudeArr'] = $aptitudeArr;
        $this->_get_area_category();
        $this->output['row'] = $row;
        $this->displaySmarty('wxapp/city/shop-apply-detail.tpl');

    }

    
    public function savePostCfgDDAction(){
        $tpl_id       = $this->request->getIntParam('tpl_id',23);
        $postAudit    = $this->request->getIntParam('postAudit');

        $data = array(
            'aci_s_id'                => $this->curr_sid,
            'aci_tpl_id'              => $tpl_id,
            'aci_post_audit'          => $postAudit ,
        );
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            $index_storage = new App_Model_City_MysqlCityIndexStorage($this->curr_sid);
            $index = $index_storage->findUpdateBySid($tpl_id);
            if($index){
                $data['aci_update_time'] = time();
                $ret = $index_storage->findUpdateBySid($tpl_id,$data);
            }else{
                $data['aci_create_time'] = time();
                $ret = $index_storage->insertValue($data);
            }
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存发帖设置成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result,1);
    }

    
    public function postRedpcakReceiveListAction(){
        $pid = $this->request->getIntParam('pid');//帖子id
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $redpack_model = new App_Model_City_MysqlCityRedbagReceiveStorage($this->curr_sid);
        $total = $redpack_model->getReceiveMemberCount($pid);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['page_html'] = $page_lib->render();
        $list = $redpack_model->getReceiveMemberList($pid,$index,$this->count);
        $this->output['list'] = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '帖子管理', 'link' => '/wxapp/city/postList'),
            array('title' => '红包领取记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/post-redpack-receive.tpl');
    }

    
    public function postFirstCategoryAction(){
        $count = 15;
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $where[]    = array('name' => 'acc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'acc_service_type', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'acc_level', 'oper' => '=', 'value' => 1);
        $sort = array('acc_create_time'=>'DESC');
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $total      = $shortcut_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination'] = $pageCfg->render();
        if($index < $total){
            $list = $shortcut_model->getList($where,$index,$count,$sort);
        }

        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '分类幻灯管理', 'link' => '#'),
        ));
        $this->output['list'] = $list;
        $this->displaySmarty('wxapp/city/post-first-category.tpl');
    }

    
    public function firstCategoryDetailAction(){
        $id = $this->request->getIntParam('id');
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $row = $shortcut_model->getRowById($id);
        $this->output['row'] = $row;
        $this->_get_postcate_slide($id);
        $this->_get_second_postcate($id);
        $this->showShortcut();
        $this->_shop_information();
        $this->_get_list_for_select();
        $this->_shop_top_goods_list();
        $this->_shop_list();
        $this->_recommend_shop_near();
        $this->_show_info();
        $this->_curr_first_kind_list_for_select();
        $this->_curr_second_kind_list_for_select();
        $this->_shop_category(2);
        $this->_get_jump_list();
        $this->_get_information_category();
        $this->_post_tab();
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '帖子分类设置', 'link' => '/wxapp/city/postFirstCategory'),
            array('title' => '幻灯图/二级分类', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/city/post-first-cate-detail.tpl');

    }

    
    private function _get_second_postcate($id){
        $where = array();
        $where[] = array('name' => 'acc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
        $where[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'acc_level', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'acc_fid', 'oper' => '=', 'value' => $id);
        $sort = array('acc_sort'=>'ASC','acc_id'=>'ASC');
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $list = $shortcut_model->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $key => $val){
                $data[] = array(
                    'index' => $key,
                    'id' => $val['acc_id'],
                    'title' => $val['acc_title'],
                    'price' => $val['acc_price'],
                    'sort'  => $val['acc_sort']
                );
            }
        }
        $this->output['secondCate'] = json_encode($data);
    }

    private function _save_second_postcate($id){
        $shortcut = $this->request->getArrParam('secondCate');
        $shortcut_model = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        if(!empty($shortcut)){
            $where[] = array('name' => 'acc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删除
            $where[] = array('name' => 'acc_type', 'oper' => '=', 'value' => 1);
            $where[] = array('name' => 'acc_level', 'oper' => '=', 'value' => 2);
            $where[] = array('name' => 'acc_fid', 'oper' => '=', 'value' => $id);
            $shortcut_list = $shortcut_model->getList($where,0,0);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($shortcut as $key => $v){
                        if($v['id'] == $val['acc_id']){
                            $sort = $v['sort'];
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){
                        $set = array(
                            'acc_sort'  => $sort,
                            'acc_title' => $shortcut[$index]['title'],
                            'acc_price'       => $shortcut[$index]['price'],
                            'acc_update_time' => time()
                        );

                        $up_ret = $shortcut_model->updateById($set,$val['acc_id']);
                        unset($shortcut[$index]);
                    }else{
                        $del_id[] = $val['acc_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'acc_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_where[] = array('name' => 'acc_type','oper' => '=' , 'value' => 1);
                    $shortcut_where[] = array('name' => 'acc_level', 'oper' => '=', 'value' => 2);
                    $shortcut_where[] = array('name' => 'acc_fid', 'oper' => '=', 'value' => $id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['title']}', '1', '{$val['sort']}', '{$val['price']}','2','{$id}','0', '".time()."', '".time()."') ";
                }
                $ins_ret = $shortcut_model->secondInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acc_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acc_type','oper' => '=' , 'value' => 1);
            $where[] = array('name' => 'acc_level', 'oper' => '=', 'value' => 2);
            $where[] = array('name' => 'acc_fid', 'oper' => '=', 'value' => $id);
            $shortcut_model->deleteValue($where);
        }
    }

    
    private function _get_postcate_slide($id){
        $slide_model = new App_Model_City_MysqlCityPostcateSlideStorage($this->curr_sid);
        $list = $slide_model->fetchSlideShowList($id);
        $data = array();
        foreach($list as $key => $val){
            $data[] = array(
                'index'     => $key ,
                'imgsrc'    => $val['acps_path'],
                'type'      => $val['acps_type'],
                'link'      => $val['acps_link'],
            );
        }
        $this->output['slide'] = json_encode($data);
    }

    public function saveFirstCateDetailAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getStrParam('id');
        if($id){
            $res = $this->_save_postcate_slide($id);
            $ret = $this->_save_second_postcate($id);

            if($res || $ret){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );

            }
        }
        $this->displayJson($result);
    }

    private function _save_postcate_slide($cateId){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_City_MysqlCityPostcateSlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($cateId);
            if(!empty($slide_list)){
                $del_id = array();
                foreach($slide_list as $val){
                    if(isset($slide[$val['acps_weight']])){
                        $set = array(
                            'acps_weight' => $slide[$val['acps_weight']]['index'],
                            'acps_path'   => $slide[$val['acps_weight']]['imgsrc'],
                            'acps_type'   => $slide[$val['acps_weight']]['type'],
                            'acps_link'   => $slide[$val['acps_weight']]['link'],
                        );
                        $up_ret = $slide_model->updateById($set,$val['acps_id']);
                        unset($slide[$val['acps_weight']]);
                    }else{
                        $del_id[] = $val['acps_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'acps_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }
            }
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$cateId}, '{$val['imgsrc']}', '{$val['index']}', '{$val['type']}', '{$val['link']}',  '0', '".time()."')";
                }
                $ins_ret = $slide_model->insertNewBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acps_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acps_cate_id','oper' => '=' , 'value' => $cateId);

            $slide_model->deleteValue($where);
        }
        return true;
    }

    
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row        = $tpl_model->getRowBySid($id,$this->curr_sid);
        if($row || $id==0){
            $set = array(
                'ac_index_tpl'   => $id,
                'ac_update_time' => time()
            );

            $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
            $ret = $applet_cfg->findShopCfg($set);

            if($ret){
                $result     = array(
                    'ec'    => 200,
                    'em'    => ' 启用成功'
                );
                App_Helper_OperateLog::saveOperateLog("模板【{$row['it_name']}】启用成功");
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function changeShopLabelAction(){
        $id = $this->request->getIntParam('id');
        $labelType = $this->request->getIntParam('labelType');
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_id', 'oper' => '=', 'value' => $id);

        $set = array(
            'acs_label_type' => $labelType
        );
        $acs_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $shop = $acs_model->getRowById($id);
        $res = $acs_model->updateValue($set,$where);
        if($res){
            App_Helper_OperateLog::saveOperateLog("保存店铺【{$shop['acs_name']}】标签成功");
        }

        $this->showAjaxResult($res,'设置');
    }

    
    public function claimListAction(){
        $acsId = $this->request->getIntParam('acsId');
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->curr_sid);
        $total      = $claim_model->getClaimCountByShop($acsId);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort = array('acsc_create_time' => 'desc');
            $list = $claim_model->getClaimListByShop($acsId, 0, $index, $this->count, $sort);
        }
        $this->output['statusNote'] = array(1 => '待审核', 2 => '已通过', 3 => '已拒绝');
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '店铺入驻店铺管理', 'link' => '/wxapp/city/shopList'),
            array('title' => '店铺认领', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/city/shop-claim.tpl');
    }

    
    public function dealClaimAction(){
        $id     = $this->request->getIntParam('id');
        $market = $this->request->getStrParam('market');
        $status = $this->request->getIntParam('status');
        $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->curr_sid);
        $claim = $claim_model->getRowById($id);


        $acs_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $cityShop = $acs_model->getRowById($claim['acsc_acs_id']);
        $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $hadShop = $shop_model->findShopByUserEnterShop($claim['acsc_m_id']);
        $es_model    = new App_Model_Entershop_MysqlEnterShopStorage($this->curr_sid);
        if($status == 2){
            if(!$cityShop['acs_m_id'] && !$hadShop){
                $set = array('acs_m_id' => $claim['acsc_m_id']);
                $shop_model->updateById($set, $claim['acsc_acs_id']);
                $set = array('es_m_id' => $claim['acsc_m_id']);
                $es_model->updateById($set, $cityShop['acs_es_id']);
            }else{
                if($cityShop['acs_m_id']){
                    $this->displayJsonError("该店铺已被认领");
                }else{
                    $this->displayJsonError("认领人名下已存在店铺");
                }
            }
        }
        $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
        $appletType = $appletType ? $appletType : 0;
        plum_open_backend('templmsg', 'shopClaimTempl', array('sid' => $this->curr_sid, 'id' => $id,'appletType'=>$appletType));
        $set = array(
            'acsc_status' => $status,
            'acsc_deal_note' => $market,
            'acsc_deal_time' => time()
        );
        $ret = $claim_model->updateById($set, $id);

        if($ret){
            $str = '';
            if($status == 2){
                $str = '通过';
            }elseif ($status == 3){
                $str = '拒绝';
            }
            if($str){
                App_Helper_OperateLog::saveOperateLog("处理店铺【{$cityShop['acs_name']}】认领申请成功，处理结果：{$str}");
            }

        }

        $this->showAjaxResult($ret);
    }

    
    public function selectShopAction(){
        $count = 10;
        $id       = $this->request->getIntParam('id');
        $page     = $this->request->getIntParam('page',1);
        $keyword  = $this->request->getStrParam('keyword');
        $page     = $page >=1 ? $page : 1;
        $index    = ($page - 1)* $this->count;

        $sort  = array('acs_create_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_id', 'oper' => '!=', 'value' => $id);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
        if($keyword){
            $where[] = array('name' => 'acs_name','oper' => 'like','value' =>"%{$keyword}%");
        }
        $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $list        = $shop_model->getList($where, $index, $count, $sort);
        $total       = $shop_model->getCount($where);
        $tot_page    = ceil($total/$this->count);
        $menu_helper = new App_Helper_Menu();
        $menu        = $menu_helper->ajaxShopPageLink($tot_page , $page);

        $data = array(
            'ec'        => 200,
            'list'      => $list,
            'pageHtml'  => $menu
        );
        $this->displayJson($data);
    }

    
    public function saveEntershopPluginAction(){
        $esId = $this->request->getIntParam('esId');
        $plugin = $this->request->getArrParam('plugin');
        $res = false;
        if($esId){
            $plugin_model = new App_Model_Entershop_MysqlEnterShopPluginOpenStorage($this->curr_sid);
            $exist = $plugin_model->findUpdateBySidEsId($esId);

            $data = [
                'espo_plugin' => json_encode($plugin,JSON_UNESCAPED_UNICODE),
                'espo_update_time' => time()
            ];

            if($exist){
                $res = $plugin_model->findUpdateBySidEsId($esId,$data);
            }else{
                $data['espo_s_id'] = $this->curr_sid;
                $data['espo_es_id'] = $esId;
                $res = $plugin_model->insertValue($data);
            }
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("保存店铺营销工具开关成功");
        }

        $this->showAjaxResult($res,'保存');
    }

    
    public function changeShopShowAction(){
        $id = $this->request->getIntParam('id');
        $status = $this->request->getIntParam('status');

        $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
        $set = [
            'acs_list_show' => $status
        ];

        $res = $shop_model->updateById($set,$id);

        if($res){
            $shop = $shop_model->getRowById($id);
            $str = $status == 1 ? '显示':'隐藏';
            App_Helper_OperateLog::saveOperateLog("{$str}店铺【{$shop['acs_name']}】成功");
        }
        $this->showAjaxResult($res,'操作');
    }

    
    public function changeShopCommentOpenAction(){
        $value = $this->request->getStrParam('value');
        $status = $value == 'on' ? 1 : 0;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $set = [
            's_shop_comment' => $status
        ];
        $res = $shop_model->updateById($set,$this->curr_sid);

        if($res){
            $str = $status == 1 ? '开启' : '隐藏';
            App_Helper_OperateLog::saveOperateLog("{$str}店铺评论功能");
        }

        $this->showAjaxResult($res);
    }

    
    public function postCatePageAction(){
        $this->showShopTplSlide(0,13);
        $this->_shop_information();
        $this->showShortcut();
        $this->_show_tpl_notice();
        $this->_get_list_for_select();
        $this->_shop_top_goods_list();
        $this->_shop_list();
        $this->_recommend_shop_near();
        $this->_show_info();
        $this->_curr_first_kind_list_for_select();
        $this->_curr_second_kind_list_for_select();
        $this->_shop_category(2);
        $this->_get_jump_list();
        $this->_get_information_category();
        $this->_post_tab();
        $this->_get_goods_group();
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();
        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type']);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                $page_data[] = array(
                    'path' => $val['ap_path'],
                    'name' => $val['ap_desc']
                );
            }
        }
        $this->output['page_list'] = json_encode($page_data);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '同城管理', 'link' => '#'),
            array('title' => '同城首页配置', 'link' => '#'),
        ));

        $this->displaySmarty('wxapp/city/post-cate-page.tpl');
    }

    public function savePostCatePageAction(){
        $res = $this->save_shop_slide_new(0,13);

        if($res){
            App_Helper_OperateLog::saveOperateLog("保存帖子分类幻灯图成功");
        }

        $this->showAjaxResult($res,'保存');
    }

}

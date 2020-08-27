<?php


class App_Controller_Wxapp_ShopController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();
    }

    public function shopTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '企业管理', 'link' => '#'),
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[3]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $appletCfg = $this->wxapp_cfg;
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $appletCfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $appletCfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/shop/shop-template.tpl');
    }
    public function indexTplAction(){
        $tpl_id = $this->request->getIntParam('tpl', 5);
        $this->_shop_default_tpl();
        $this->showShopTpl($tpl_id);
        $this->showShortcut($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->showServiceList($tpl_id);
        $this->showActiveList($tpl_id);
        $this->_shop_service_article();
        $this->_shop_information();
        $this->_shop_mobile_address();
        $this->_shop_master_list();
        $this->_shop_service_category();
        $this->_shop_information_category();
        $this->_show_shortcut_list($tpl_id);
        $this->_show_tpl_notice($tpl_id);
        $this->_get_list_for_select($tpl_id);
        $this->_get_custom_form_list();
        $this->_get_template_list();
        $this->_get_jump_list();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/shop/index-tpl_'.$tpl_id.'.tpl');

    }


    
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
    
    private function _get_list_for_select($tpl_id){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }


        $linkList = plum_parse_config('link',$config_name);
        $linkType = plum_parse_config('link_type',$config_name);
        $customType  = plum_parse_config('link_type_custom',$config_name);

        unset($customType[2]);//去除自定义模板

        $enterpriseType = plum_parse_config('link_type_enterprise',$config_name);
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        if($tpl_id==25){
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
        }else{
            $this->output['linkList'] = json_encode($link);
        }
        $linkTypesNew = array(
            array(
                'id'   => '1',
                'name' => '资讯详情'
            ),
            array(
                'id'   => '106',
                'name' => '小程序'
            ),
        );
        $this->output['linkTypesNew'] = json_encode($linkTypesNew);
        if(in_array($this->menuType,['aliapp','toutiao'])){
            foreach ($linkType as $key => $value) {
                if($value['id']==106){
                    unset($linkType[$key]);
                    break;
                }
            }
        }
        $this->output['linkType'] = json_encode(array_merge($linkType,$enterpriseType, $customType));

    }

    
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

    
    private function _get_template_list(){
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
    private function _shop_master_list(){
        $master_storage = new App_Model_Shop_MysqlShopMasterStorage($this->curr_sid);
        $master_list = $master_storage->fetchMasterList();
        $data = array();
        if($master_list){
            foreach ($master_list as $val){
                $data[] = array(
                    'index' => $val['aem_weight'],
                    'title' => $val['aem_title'],
                    'imgsrc'=> $val['aem_img'],
                    'name'  => $val['aem_name'],
                    'brief' => $val['aem_brief'],
                    'link'  => $val['aem_link']
                );
            }
        }
        $this->output['masterList'] = json_encode($data);
    }

    
    private function _show_tpl_notice($tpl_id){
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchNoticeShowList($tpl_id);
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

    
    private function showShopTpl($tpl_id=5){
        $tpl_model = new App_Model_Applet_MysqlAppletTplStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'at_title'      => '首页',
                'at_search_tip' => '请输入关键字',
                'at_head_img'   => '/public/manage/applet/temp2/images/bg.png',
                'at_tpl_id'     => $tpl_id,
                'at_top_color'  => '#fff',
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _shop_default_tpl(){
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        if(!$cfg['ac_index_tpl']){
            $data = array('ac_index_tpl'=>9);
            $applet_cfg->findShopCfg($data);
        }
    }
    
    public function qrcodeAction() {
        $text   = $this->request->getStrParam('url');
        $type   = $this->request->getStrParam('type');
        $regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';

        if($type == 'down'){
            $unique = $this->shops[$this->curr_sid]['s_unique_id'];
            $name   = 'qrcode_' . $unique .'.png';
            $file   = PLUM_DIR_TEMP . '/'.$name;
            Libs_Qrcode_QRCode::png($text, $file,  'M', 4,4,true);
            header("Content-type: octet/stream");
            header("Content-disposition:attachment;filename=".$name.";");
            header("Content-Length:".filesize($file));
            readfile($file);
            exit;

        }else{
            if (preg_match($regex, $text)) {
                Libs_Qrcode_QRCode::png($text);
            } else {
                plum_redirect(self::FXB_FDL_IMAGE);
            }
        }

    }

    
    private function _shop_mobile_address(){
        $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->curr_sid);
        $row = $about_storage->findUpdateBySid();
        $this->output['contact'] = $row;
    }


    
    private function showShortcut($tpl_id=3){
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($tpl_id);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $val['ss_weight'] ,
                'title'        => $val['ss_name'],
                'imgsrc'       => $val['ss_icon'],
                'link'         => $val['ss_link'],
                'articleId'    => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],
                'type'         => $val['ss_link_type']
            );
        }
        $this->output['shortcut'] = json_encode($json);
    }

    
    private function showServiceList($tpl_id=3){
        $service_model = new App_Model_Shop_MysqlShopServiceStorage($this->curr_sid);
        $service = $service_model->fetchServiceShowList($tpl_id);
        $json = array();
        foreach($service as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'name'         => $val['ss_title'],
                'imgsrc'       => $val['ss_icon'],
                'articleId'    => $val['ss_link'],
                'intro'        => $val['ss_brief'],
                'articleTitle' => $val['ss_article_title'],
            );
        }
        $this->output['serviceList'] = json_encode($json);
    }

    
    private function showActiveList($tpl_id=3){
        $service_model = new App_Model_Shop_MysqlShopServiceStorage($this->curr_sid);
        $active = $service_model->fetchServiceShowList($tpl_id, 2);
        $json = array();
        foreach($active as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'name'         => $val['ss_title'],
                'imgsrc'       => $val['ss_icon'],
                'articleId'    => $val['ss_link'],
                'link'         => $val['ss_link'],
                'intro'        => $val['ss_brief'],
                'label'        => $val['ss_label'],
                'articleTitle' => $val['ss_article_title'],
                'linkType'     => $val['ss_link_type']
            );
        }
        $this->output['activeList'] = json_encode($json);
    }

    
    private function _shop_service_article(){
        $where      = array();
        $where[]    = array('name'=>'ss_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'ss_type','oper'=>'=','value'=>1);
        $where[]    = array('name'=>'ss_deleted','oper'=>'=','value'=>0);
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
    private function save_shop_master(){
        $masterList = $this->request->getArrParam('masterList');
        $master_storage = new App_Model_Shop_MysqlShopMasterStorage($this->curr_sid);
        if(!empty($masterList)){
            $master_list = $master_storage->fetchMasterList(0, 0);
            if(!empty($master_list)){
                $del_id = array();
                foreach($master_list as $key => $val){
                    if(isset($masterList[$val['aem_weight']])){
                        $set = array(
                            'aem_weight'    => $key,
                            'aem_title'     => $masterList[$val['aem_weight']]['title'],
                            'aem_name'      => $masterList[$val['aem_weight']]['name'],
                            'aem_img'       => $masterList[$val['aem_weight']]['imgsrc'],
                            'aem_brief'     => $masterList[$val['aem_weight']]['brief'],
                            'aem_link'      => $masterList[$val['aem_weight']]['link'],
                        );
                        $up_ret = $master_storage->updateById($set,$val['aem_id']);
                        unset($masterList[$val['aem_weight']]);
                    }else{
                        $del_id[] = $val['aem_id'];
                    }
                }
                if(!empty($del_id)){
                    $master_where = array();
                    $master_where[] = array('name' => 'aem_id','oper' => 'in' , 'value' => $del_id);
                    $del_ret = $master_storage->deleteValue($master_where);
                }
            }
            if(!empty($masterList)){
                $insert = array();
                foreach($masterList as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['imgsrc']}','{$val['title']}','{$val['name']}','{$val['brief']}','{$val['link']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $master_storage->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'aem_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $del     = $master_storage->deleteValue($where);
        }
        if($up_ret || $ins_ret || $del_ret || $del){
            return true;
        }else{
            return false;
        }
    }

    
    private function _save_train_notice($tpl_id){
        $noticeInfo = $this->request->getArrParam('notice');
        $notice_storage = new App_Model_Train_MysqlTrainNoticeStorage($this->curr_sid);
        if(!empty($noticeInfo)){
            $notice_list = $notice_storage->fetchNoticeShowList($tpl_id);
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
                foreach ($noticeInfo as $val) {
                    $insert[] = " (NULL, '{$this->curr_sid}',{$tpl_id},'{$val['title']}','','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','" . time() . "') ";
                }
                $ins_ret = $notice_storage->carInsertBatch($insert);
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


    
    private function save_shop_address($address,$lng,$lat,$color,$size){
        $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->curr_sid);
        $row = $about_storage->findUpdateBySid();
        if($address && $lng && $lat){
            $updata = array(
                'sa_address' => $address,
                'sa_lng'     => $lng,
                'sa_lat'     => $lat,
                'sa_color'   => $color,
                'sa_size'    => $size,
                'sa_update_time' => time(),
            );
            if($row){
                $about_storage->findUpdateBySid($updata);
            }else{
                $updata['sa_create_time'] = time();
                $updata['sa_s_id'] = $this->curr_sid;
                $about_storage->insertValue($updata);
            }

        }
        $data['sa_update_time'] = time();
    }

    
    private function _save_shop_slide($tpl_id){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($tpl_id);
            if(!empty($slide_list)){
                $del_id = array();
                foreach($slide_list as $val){
                    if(isset($slide[$val['ss_weight']])){
                        $set = array(
                            'ss_weight' => $slide[$val['ss_weight']]['index'],
                            'ss_link'   => $slide[$val['ss_weight']]['link'],
                            'ss_path'   => $slide[$val['ss_weight']]['imgsrc'],
                        );
                        $up_ret = $slide_model->updateById($set,$val['ss_id']);
                        unset($slide[$val['ss_weight']]);
                    }else{
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }

            }
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$tpl_id}, '{$val['link']}', '{$val['imgsrc']}', '{$val['index']}', '1', '0', '".time()."')";
                }
                $ins_ret = $slide_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $slide_model->deleteValue($where);
        }
        return true;
    }

    
    private function _save_shop_shortcut($tpl_id){
        $shortcut = $this->request->getArrParam('shortcut');
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $key => $val){
                    if(isset($shortcut[$val['ss_weight']])){
                        $set = array(
                            'ss_weight' => $key,
                            'ss_name'   => $shortcut[$val['ss_weight']]['title'],
                            'ss_icon'   => $shortcut[$val['ss_weight']]['imgsrc'],
                            'ss_link'   => $shortcut[$val['ss_weight']]['articleId'],
                            'ss_article_title'   => $shortcut[$val['ss_weight']]['articleTitle'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['ss_id']);
                        unset($shortcut[$val['ss_weight']]);
                    }else{
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}', '{$val['articleId']}', '{$val['index']}','{$val['articleTitle']}', '0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }
    }

    
    private function save_shop_service($tpl_id){
        $serviceList = $this->request->getArrParam('serviceList');
        $service_model = new App_Model_Shop_MysqlShopServiceStorage($this->curr_sid);
        if(!empty($serviceList)){
            $service_list = $service_model->fetchServiceShowList($tpl_id);
            if(!empty($service_list)){
                $del_id = array();
                foreach($service_list as $key => $val){
                    if(isset($serviceList[$val['ss_weight']])){
                        $set = array(
                            'ss_weight'          => $key,
                            'ss_title'           => $serviceList[$val['ss_weight']]['name'],
                            'ss_icon'            => $serviceList[$val['ss_weight']]['imgsrc'],
                            'ss_link'            => $serviceList[$val['ss_weight']]['articleId'],
                            'ss_article_title'   => $serviceList[$val['ss_weight']]['articleTitle'],
                            'ss_brief'           => plum_sql_quote($serviceList[$val['ss_weight']]['intro']),
                            'ss_type'            => 1,
                        );
                        $up_ret = $service_model->updateById($set,$val['ss_id']);
                        unset($serviceList[$val['ss_weight']]);
                    }else{
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $service_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($serviceList)){
                $insert = array();
                foreach($serviceList as $val){
                    $intro = plum_sql_quote($val['intro']);
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['name']}','','{$intro}', '{$val['imgsrc']}', '{$val['articleId']}','{$val['articleTitle']}', '{$val['index']}', '0', '".time()."', '1') ";
                }
                $ins_ret = $service_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $where[] = array('name' => 'ss_type','oper' => '=' , 'value' => 1);
            $service_model->deleteValue($where);
        }
    }

    
    private function save_shop_active($tpl_id){
        $activeList = $this->request->getArrParam('activeList');
        $service_model = new App_Model_Shop_MysqlShopServiceStorage($this->curr_sid);
        if(!empty($activeList)){
            $activity_list = $service_model->fetchServiceShowList($tpl_id, 2);
            if(!empty($activity_list)){
                $del_id = array();
                foreach($activity_list as $key => $val){
                    if(isset($activeList[$val['ss_weight']])){
                        $set = array(
                            'ss_weight'          => $key,
                            'ss_title'           => $activeList[$val['ss_weight']]['name'],
                            'ss_icon'            => $activeList[$val['ss_weight']]['imgsrc'],
                            'ss_link'            => $activeList[$val['ss_weight']]['link'],
                            'ss_article_title'   => $activeList[$val['ss_weight']]['articleTitle'],
                            'ss_brief'           => plum_sql_quote($activeList[$val['ss_weight']]['intro']),
                            'ss_label'           => $activeList[$val['ss_weight']]['label'],
                            'ss_type'            => 2,
                            'ss_link_type'       => $activeList[$val['ss_weight']]['linkType'],
                        );
                        $up_ret = $service_model->updateById($set,$val['ss_id']);
                        unset($activeList[$val['ss_weight']]);
                    }else{
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $service_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($activeList)){
                $insert = array();
                foreach($activeList as $val){
                    $intro = plum_sql_quote($val['intro']);
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['name']}','{$val['label']}','{$intro}', '{$val['imgsrc']}', '{$val['articleId']}','{$val['linkType']}','{$val['articleTitle']}', '{$val['index']}', '0', '".time()."', '2') ";
                }
                $ins_ret = $service_model->insertBatchActivity($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $where[] = array('name' => 'ss_type','oper' => '=' , 'value' => 2);
            $service_model->deleteValue($where);
        }
    }

    
    public function serviceAction() {
        $type = $this->request->getIntParam('type',1);
        $this->_show_service_data($type);
        $this->_get_service_category($type);

        $this->buildBreadcrumbs(array(
            array('title' => '企业管理', 'link' => '#'),
            array('title' => '企业服务', 'link' => '#'),
        ));
        $this->output['type'] = $type;
        $this->displaySmarty('wxapp/shop/service-information.tpl');
    }


    private function _create_qrcode($id,$cover = ''){
        $client_plugin   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = "id=".$id;
        $qrcode = $client_plugin->fetchWxappShareCode($str, $client_plugin::SHOP_SERVICE_INFORMATION_PATH, 210, $cover);
        return $qrcode;
    }

    
    public function informationAction() {
        $type = $this->request->getIntParam('type',2);
        $this->_show_service_data($type);
        $this->_get_service_category($type);

        $this->buildBreadcrumbs(array(
            array('title' => '企业资讯', 'link' => '#'),
        ));
        $this->output['type'] = $type;
        $this->displaySmarty('wxapp/shop/service-information.tpl');
    }

    private function _show_service_data($type){
        $page       = $this->request->getIntParam('page');
        $where      = array();
        $where[]    = array('name'=>'ss_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'ss_type','oper'=>'=','value'=>$type);
        $index      = $page * $this->count;

        $title = $this->request->getStrParam('title');
        if($title){
            $where[]       = array('name'=>'ss_title','oper'=>'like','value'=>"%{$title}%");
        }
        $this->output['title'] = $title;

        $categoryId = $this->request->getIntParam('categoryId');
        if($categoryId){
            $where[]       = array('name'=>'ss_category','oper'=>'=','value'=>$categoryId);
        }
        $this->output['categoryId'] = $categoryId;

        $startTime   = $this->request->getStrParam('start');
        if($startTime){
            $where[]    = array('name' => 'ss_create_time', 'oper' => '>=', 'value' => strtotime($startTime));
        }
        $this->output['start'] = $startTime;

        $endTime     = $this->request->getStrParam('end');
        if($endTime){
            $where[]    = array('name' => 'ss_create_time', 'oper' => '<=', 'value' => (strtotime($endTime) + 86400));
        }
        $this->output['end'] = $endTime;


        $article_model  = new App_Model_Shop_MysqlShopServiceInformationStorage();
        $total      = $article_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();

        $list = array();
        if($index < $total){
            $sort = array('ss_create_time' => 'DESC');
            $list = $article_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
    }

    
    public function startAppletTplAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '该模版不可用'
        );
        $id         = $this->request->getIntParam('id');
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row        = $tpl_model->getRowBySid($id,$this->curr_sid);
        if($row  || $id==0){
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
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】保存成功");
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }

    
    private function _get_service_category($type){
        $where = array();
        $where[] = array('name'=>'ssc_type','oper'=>'=','value'=>$type);
        $where[] = array('name'=>'ssc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'ssc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $category_storage = new App_Model_Shop_MysqlShopServiceCategoryStorage($this->curr_sid);
        $category_list = $category_storage->getList($where,0,0,array('ssc_create_time'=>'DESC'));
        $list = $category_storage->getCategoryListByType($type);
        $category_select = $category_storage->getCategoryListForSelect();
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
        $this->output['category'] = $category_list;
        $this->output['categoryList'] = json_encode($categoryList);
        $this->output['category_list'] = $categoryList;
        $this->output['category_select'] = $category_select;
    }

    
    private function _show_shortcut_list($tpl_id){
        $shortcut_storage = new App_Model_Cake_MysqlCakeShortcutStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_tpl', 'oper' => '=', 'value' => $tpl_id);
        $list    = $shortcut_storage->getList($where, 0, 0, array('acs_index' => 'ASC'));
            $data = array();
            foreach($list as $val){
                $data[] = array(
                    'id'        => $val['acs_id'],
                    'index'     => $val['acs_index'],
                    'imgsrc'    => $val['acs_imgsrc'],
                    'name'      => $val['acs_name'],
                    'linkTitle' => $val['acs_link_title'],
                    'link'      => $val['acs_link'],
                    'type'      => $val['acs_link_type'],
                    'intro'     => $val['acs_brief'],
                );
            }
            $this->output['navList'] = json_encode($data);

    }
    
    private function save_cake_shortcut_new($tpl_id){
        $shortcut = $this->request->getArrParam('brandList');
        $shortcut_model = new App_Model_Cake_MysqlCakeShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    $has = false;
                    $index = 0;
                    foreach($shortcut as $key => $v){
                        if($v['id'] == $val['acs_id']){
                            $index = $key;
                            $has = true;
                        }
                    }
                    if($has){
                        $set = array(
                            'acs_name'      => $shortcut[$index]['name'],
                            'acs_brief'     => $shortcut[$index]['intro'],
                            'acs_tpl'       => $tpl_id,
                            'acs_imgsrc'    => $shortcut[$index]['imgsrc'],
                            'acs_link'      => $shortcut[$index]['link'],
                            'acs_link_title'=> $shortcut[$index]['linkTitle'],
                            'acs_index'     => $index,
                            'acs_link_type' => $shortcut[$index]['type'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['acs_id']);
                        unset($shortcut[$index]);
                    }else{
                        $del_id[] = $val['acs_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'acs_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['name']}', '{$val['intro']}', {$tpl_id}, '{$val['imgsrc']}','{$val['link']}','{$val['articleTitle']}', '{$val['type']}', '{$val['index']}','".time()."') ";
                }
                $ins_ret = $shortcut_model->newInsertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acs_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_tpl','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }
    }

    
    public function wxAlipayChargeQrcodeAction() {
        $amount     = $this->request->getIntParam('amount');
        $amount     = abs($amount);
        if (!$amount) {
            plum_redirect("/public/manage/images/qrcode-placeholder.png");
        }
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = $this->request->getStrParam('channel');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);
        if($channel=='wx_pub_qr'){
            $ret = $this->_wx_pay_cfg($amount);
            if (is_array($ret)){
                $qrcode = $ret['code_url'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }else{
            $ret = $this->_alipay_pay_cfg($amount);
            if (is_array($ret)){
                $qrcode = $ret['qr_code'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }
        Libs_Qrcode_QRCode::png($qrcode);
    }

    
    private function _wx_pay_cfg($amount){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $body   = '新增绑定公众号支付'.($amount/100).'元';
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/push/addBindGzhWxNotify';//回调地址
        $attach = array(
            'sid'    => $this->curr_sid,
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }

    
    private function _alipay_pay_cfg($amount){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $subject   = '新增绑定公众号支付'.($amount/100).'元';
        $notify_url = $this->response->responseHost().'/manage/push/addBindGzhAliNotify';//回调地址
        $amount = $amount/100;
        $attach = array(
            'sid'    => $this->curr_sid,
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;

    }
}
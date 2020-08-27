<?php


class App_Controller_Wxapp_KnowledgepayController extends App_Controller_Wxapp_OrderCommonController{

    public function __construct()
    {
        parent::__construct();
    }

    
    public function knowpayTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[27]['tpl'];
        $tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $list       = $tpl_model->getListByTidSidType($tpl_ids,$this->curr_sid,3);
        $applet_cfg = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $row        = array();
        foreach($list as $val){
            if(empty($row) && $val['it_id'] == $cfg['ac_index_tpl']){
                $row = $val;
                break;
            }
        }
        $this->output['cfg']  = $cfg;
        $this->output['list'] = $list;
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->output['row']  = $row;
        $this->displaySmarty('wxapp/knowledgepay/knowpay-template.tpl');
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
                App_Helper_OperateLog::saveOperateLog("首页模板【{$row['it_name']}】启用成功");
            }else{
                $result['em'] = '启用失败';
            }
        }
        $this->displayJson($result);
    }


   
    public function indexTplAction(){
        $tpl_id = $this->request->getIntParam('tpl', 59);
        $tpl_model = new App_Model_Shop_MysqlIndexTplStorage();
        $row = $tpl_model->getRowBySid($tpl_id, $this->curr_sid);
        $this->output['shop'] = $this->shops[$this->curr_sid];
        $this->showKnowPayTpl($tpl_id);
        $this->showShortcut($tpl_id);
        $this->showSlide($tpl_id);
        $this->_shop_top_goods_list();
        $this->_shop_kind_list_for_select();
        $this->_get_list_for_select();
        $this->_shop_information_category();

        $page = $this->_fetch_shop_outside();
        $page_data = $this->_fetch_page_data();
        $this->output['page_list'] = json_encode(array_merge($page,$page_data));
        $this->_shop_appointment_goods_list();
        $this->_shop_kind_list($tpl_id);
        $this->_get_jump_list();
        $this->_show_tpl_notice();
        $this->_shop_information();
        $this->_show_recommend_by_type($tpl_id,0);
        $this->_show_recommend_by_type($tpl_id,1);
        $this->_show_recommend_by_type($tpl_id,2);
        if($this->wxapp_cfg['ac_type'] == 27)
            $this->_shop_independence_cate_list();
        $this->output['knowpayType'] = json_encode(array(
            array(
                'id' => '1',
                'name' => '图文分类列表'
            ),
            array(
                'id' => '2',
                'name' => '音频分类列表'
            ),
            array(
                'id' => '3',
                'name' => '视频分类列表'
            ),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '/wxapp/knowledgepay/knowpayTemplate'),
            array('title' => '首页模版', 'link' => '#'),
        ));
        $this->output['serviceList'] = json_encode(array());
        $this->displaySmarty('wxapp/knowledgepay/index-tpl_' . $tpl_id . '.tpl');
    }
     
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

    private function _shop_appointment_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
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
    
    private function showServiceList($tpl=5){
        $service_model = new App_Model_Shop_MysqlShopServiceStorage($this->curr_sid);
        $service = $service_model->fetchServiceShowList($tpl);
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

    
    private function _show_recommend_by_type($tpl_id,$type = 0){
        $notice_storage = new App_Model_Knowpay_MysqlKnowpayRecommendStorage($this->curr_sid);
        $notice_list = $notice_storage->fetchShowList($tpl_id,$type);
        $data = array();
        if($notice_list){
            foreach ($notice_list as $val){
                $data[] = array(
                    'index'         => $val['akr_weight'],
                    'imgsrc'        => $val['akr_cover'],
                    'link'          => $val['akr_link'],
                    'type'          => $val['akr_link_type'],
                    'title'         => $val['akr_title'] ? $val['akr_title'] : '',
                    'articleTitle'  => $val['akr_link_detail']
                );
            }
        }
        if($type == 1){
            $this->output['recommendBig'] = json_encode($data);
        }elseif($type == 2){
            $this->output['recommendAudio'] = json_encode($data);
        }else{
            $this->output['recommendList'] = json_encode($data);
        }

    }

    
    private function showKnowPayTpl($tpl_id=59){
        $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'aki_title'                => '店铺首页',
                'aki_search_tip'           => '请输入关键字',
                'aki_tpl_id'               => $tpl_id,
                'aki_member_entrance_img'  => '',
                'aki_member_entrance_open' => 0,
                'aki_quotation_open'       => 1,
                'aki_quotation_title'      => '精选语录',
                'aki_audio_title'          => '推荐音频',
                'aki_notice_title'         => '公告',
            );
        }
        $this->output['tpl'] = $tpl;
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

    
    private function showShortcut($tpl_id=59){
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($tpl_id);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $key ,
                'title'        => $val['ss_name'],
                'imgsrc'       => $val['ss_icon'],
                'link'         => $val['ss_link'],
                'articleId'    => $val['ss_link'],
                'selectedSite' => array(
                    'id'   => $val['ss_link'],
                    'name' => $val['ss_name']
                ),
                'type'         => $val['ss_link_type'],
                'articleTitle' => $val['ss_article_title'] ? $val['ss_article_title'] : 0
            );
        }
        $this->output['shortcut'] = json_encode($json);
    }

    
    private function showSlide($tpl_id=59){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList($tpl_id);
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'          => $key ,
                'imgsrc'         => $val['ss_path'],
                'articleId'      => $val['ss_link'],
                'link'           => $val['ss_link'],
                'type'           => $val['ss_link_type'],
                'articleTitle'   => $val['ss_article_title'] ? $val['ss_article_title'] : 0
            );
        }
        $this->output['slide'] = json_encode($json);
    }

    
    private function _shop_top_goods_list(){
        $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);

        $pictureList = [];
        $videoList = [];
        $audioList = [];
        $where_goods[] = ['name'=>'g_independent_mall','oper'=>'=','value'=>0];
        $goods_list = $goods_storage->fetchShopGoodsList($this->curr_sid,0,0,'',0,array('g_is_top' => 'DESC','g_update_time' => 'DESC'),array(),0,0,1,$where_goods);
        $data = array();
        if($goods_list){
            foreach ($goods_list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name'],
                );
                if($val['g_knowledge_pay_type'] == 1){
                    $pictureList[$val['g_id']] = array(
                        'id'   => $val['g_id'],
                        'name' => $val['g_name'],
                    );
                }
                if($val['g_knowledge_pay_type'] == 2){
                    $audioList[$val['g_id']] = array(
                        'id'   => $val['g_id'],
                        'name' => $val['g_name'],
                    );
                }
                if($val['g_knowledge_pay_type'] == 3){
                    $videoList[$val['g_id']] = array(
                        'id'   => $val['g_id'],
                        'name' => $val['g_name'],
                    );
                }
            }
        }
        $this->output['goodsList'] = json_encode($data);
        $this->output['pictureList'] = json_encode($pictureList);
        $this->output['audioList'] = json_encode($audioList);
        $this->output['videoList'] = json_encode($videoList);
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
        $kind1 = $kind_model->getAllFirstCategory(0,0);
        $firstKindSelect = array();
        if($kind1){
            $firstKindSelect[] = array(
                'id'   => 0,
                'name' => '无'
            );
            foreach ($kind1 as $val){
                $firstKindSelect[] = array(
                    'id'   => $val['sk_id'],
                    'name' => $val['sk_name']
                );
            }
        }
        $this->output['kindSelect'] = json_encode($data);
        $this->output['firstKindSelect'] = json_encode($firstKindSelect);
        $this->output['allKindSelect'] = json_encode(array_merge($firstKindSelect, $data));
    }

    
    private function _get_list_for_select(){
        if($this->menuType == 'toutiao'){
            $config_name = 'toutiaosystem';
        }else{
            $config_name = 'system';
        }


        $foldType = plum_parse_config('fold_menu',$config_name);
        $linkList = plum_parse_config('link',$config_name);
        $linkType = plum_parse_config('link_type',$config_name);
        $weedingType = plum_parse_config('link_type_knowpay',$config_name);
        $customType  = plum_parse_config('link_type_custom',$config_name);
        $foldType[4] = array(
            'id'   => '49',
            'name' => '签到'
        );
        unset($customType[1]);
        unset($customType[2]);
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType,$customType,$foldType));
    }

    
    private function _shop_kind_list($tpl){
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        $kind_list = $kind_model->fetchKindShowList($tpl);
        $data = array();
        if($kind_list){
            foreach ($kind_list as $val){
                $goods      = $this->_get_goods_by_kind1($val['amk_link']);
                $data[] = array(
                    'title'  => $val['amk_name'],
                    'link'   => $val['amk_link'],
                    'index'  => $val['amk_weight'],
                    'imgsrc' => $val['amk_img'],
                    'goods'     => $goods,
                    'sign'   => $val['amk_sign'] ? $val['amk_sign'] : 0
                );
            }
        }else{
            $data[] = array(
                'title'  => '分类名称',
                'link'   => 1,
                'index'  => 0,
                'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_750_180.png',
                'sign'   => 0
            );
        }
        $this->output['kindList'] = json_encode($data);
    }

    
    private function _get_goods_by_kind1($kind1){
        $data         =  array();
        $goods_model  =  new App_Model_Goods_MysqlGoodsStorage();
        $where        =  array();
        $where[]      =  array('name'=>'g_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]      =  array('name'=>'g_kind1','oper'=>'=','value'=>$kind1);
        $where[]      =  array('name'=>'g_is_top','oper'=>'=','value'=>1);
        $list         =  $goods_model->getList($where,0,4,'',array('g_id','g_name','g_vip_price','g_price','g_cover'));
        if($list){
            foreach($list as $val){
                $data[] = array(
                    'id'   => $val['g_id'],
                    'name' => $val['g_name']?$val['g_name']:'课程名称',
                    'oldPrice'  => $val['g_price'],
                    'newPrice'  => $val['g_vip_price']?$val['g_vip_price']:$val['g_price'],
                    'cover'     => $val['g_cover']?$val['g_cover']:'/public/manage/img/zhanwei/zw_fxb_200_200.png'
                );
            }
        }
        return $data;
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

    private function _save_recommend_by_type($tpl_id = 65,$type = 0){
        if($type == 1){
            $recommend = $this->request->getArrParam('recommendBig');
        }elseif($type == 2){
            $recommend = $this->request->getArrParam('recommendAudio');
        }else{
            $recommend = $this->request->getArrParam('recommendList');
        }

        $recommend_model = new App_Model_Knowpay_MysqlKnowpayRecommendStorage($this->curr_sid);
        if(!empty($recommend)){
            $recommend_list = $recommend_model->fetchShowList($tpl_id,$type);
            if(!empty($recommend_list)){
                $del_id = array();
                foreach($recommend_list as $val){
                    if(isset($recommend[$val['akr_weight']])){
                        $set = array(
                            'akr_weight' => $recommend[$val['akr_weight']]['index'],
                            'akr_cover'   => $recommend[$val['akr_weight']]['imgsrc'],
                            'akr_link_type' => $recommend[$val['akr_weight']]['type'],
                            'akr_link'      => $recommend[$val['akr_weight']]['link'],
                            'akr_link_detail'      => $recommend[$val['akr_weight']]['articleTitle'],
                            'akr_title'      => $recommend[$val['akr_weight']]['title'],
                        );

                        $up_ret = $recommend_model->updateById($set,$val['akr_id']);
                        unset($recommend[$val['akr_weight']]);
                    }else{
                        $del_id[] = $val['akr_id'];
                    }
                }
                if(!empty($del_id)){
                    $recommend_where = array();
                    $recommend_where[] = array('name' => 'akr_id','oper' => 'in' , 'value' => $del_id);
                    $recommend_where[] = array('name' => 'akr_type','oper' => '=' , 'value' => $type);
                    $recommend_model->deleteValue($recommend_where);
                }

            }
            if(!empty($recommend)){
                $insert = array();
                foreach($recommend as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$tpl_id}', '{$type}', '{$val['title']}', '', '{$val['imgsrc']}','{$val['link']}','{$val['articleTitle']}','{$val['type']}', '{$val['index']}','0', '".time()."') ";
                }
                $ins_ret = $recommend_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'akr_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'akr_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $where[] = array('name' => 'akr_type','oper' => '=' , 'value' => $type);
            $recommend_model->deleteValue($where);
        }
    }
    public function saveRechargeCfgAction(){

        if($this->wxapp_cfg['ac_type'] == 18){
            $tpl['ari_recharge_sub_title'] = $this->request->getStrParam('subTitle');
            $tpl['ari_recharge_rule'] = $this->request->getStrParam('rule');
            $tpl['ari_update_time']   = time();
            $tpl_id = 33;
        }else{
            $tpl['aki_recharge_sub_title'] = $this->request->getStrParam('subTitle');
            $tpl['aki_recharge_rule'] = $this->request->getStrParam('rule');
            $tpl['aki_update_time']   = time();
            $tpl_id               = $this->request->getIntParam('tpl_id',59);
        }
        $index_tpl_model  = new App_Model_Shop_MysqlIndexTplStorage();
        $row   = $index_tpl_model->getRowBySid($tpl_id,$this->curr_sid);
        if($row){
            if($this->wxapp_cfg['ac_type'] == 18){

                $tpl_model = new App_Model_Reservation_MysqlReservationIndexStorage($this->curr_sid);
                $tpl_row   = $tpl_model->findUpdateBySid(33);
                if(!empty($tpl_row)){
                    $ret = $tpl_model->findUpdateBySid(33,$tpl);
                }else{
                    $tpl['ari_tpl_id']     = $tpl_id;
                    $tpl['ari_s_id']       = $this->curr_sid;
                    $tpl['ari_create_time']= time();
                    $ret = $tpl_model->insertValue($tpl);
                }
            }else{

                $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
                $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
                if(!empty($tpl_row)){
                    $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
                }else{
                    $tpl['aki_tpl_id']     = $tpl_id;
                    $tpl['aki_s_id']       = $this->curr_sid;
                    $tpl['aki_create_time']= time();
                    $ret = $tpl_model->insertValue($tpl);
                }
            }



            if($ret){
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
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    
    private function _save_shop_kind($tpl_id){
        $kind = $this->request->getArrParam('kind');
        $kind_model = new App_Model_Mall_MysqlMallKindStorage($this->curr_sid);
        if(!empty($kind)){
            $kind_list = $kind_model->fetchKindShowList($tpl_id);
            if(!empty($kind_list)){
                $del_id = array();
                foreach($kind_list as $val){
                    if(isset($kind[$val['amr_weight']])){
                        $set = array(
                            'amk_weight' => $kind[$val['amk_weight']]['index'],
                            'amk_name'   => $kind[$val['amk_weight']]['title'],
                            'amk_link'   => $kind[$val['amk_weight']]['link'],
                            'amk_img'    => $kind[$val['amk_weight']]['imgsrc'],
                            'amk_sign'   => $kind[$val['amk_weight']]['sign'],
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
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}','{$val['link']}', '{$val['sign']}','{$val['index']}','".time()."') ";
                }
                $ins_ret = $kind_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'amk_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'amk_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $kind_model->deleteValue($where);
        }

    }
    public function goodsListAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '课程管理', 'link' => '#'),
            array('title' => '课程列表', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->_show_category_type(0);
        $this->output['choseLink']  = $this->showTableLink('goods');
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $this->output['levelList'] = $list;

        $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $index = $index_model->findUpdateBySid(59);
        $this->output['index_cfg'] = $index;

        $this->output['menuType'] = $this->menuType;
        $this->output['acType']   = $this->wxapp_cfg['ac_type'];
        if($this->menuType=='weixin'){
            $link_host      = plum_parse_config('weixin_index','weixin');
            $course_url    = $link_host[$this->wxapp_cfg['ac_type']];
            $course_url   .= sprintf('?appletType=5&suid=%s&share=/SpecialColumnDetail',$this->curr_shop['s_unique_id']);
        }else{
            $course_url   ='';
        }
        $this->output['course_link']=$course_url;


        $this->displaySmarty("wxapp/knowledgepay/goods-list.tpl");
    }

    
    private function showTableLink($type,$param=array()){
        $extra = '';
        if(!empty($param) && is_array($param)){
            foreach($param as $key=>$val){
                $extra .= '&'.$key.'='.$val;
            }
        }
        $link = array();
        switch($type){
            case 'order' :
                $link = array(
                    array(
                        'href'  => '/wxapp/knowledgepay/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/knowledgepay/tradeList?status=tuan'.$extra,
                        'key'   => 'tuan',
                        'label' => '待成团'
                    ),
                    array(
                        'href'  => '/wxapp/knowledgepay/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/knowledgepay/tradeList?status=finish'.$extra,
                        'key'   => 'finish',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/knowledgepay/tradeList?status=closed'.$extra,
                        'key'   => 'closed',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/knowledgepay/goodsList?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/knowledgepay/goodsList?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/meal/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/meal/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/meal/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/meal/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                );
                break;


        }
        return $link;
    }

    private function _show_goods_list_data($isPoint=0){
        $where = array();
        $where[] = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[] = array('name' => 'g_independent_mall','oper' => '=','value' =>0);

        if($this->wxapp_cfg['ac_type'] == 21){
            $where[] = array('name' => 'g_knowledge_pay_type','oper' => '>','value' =>0);
        }

        if($isPoint){
            $output['gtype'] = $this->request->getIntParam('gtype');
            if($output['gtype']){
                $where[]        = array('name' => 'g_type','oper' => '=','value' => $output['gtype']);
            }else{
                if($this->wxapp_cfg['ac_type'] == 27){
                    $where[]        = array('name' => 'g_type','oper' => '=','value' => 5);
                }else{
                    $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(4,5));
                }
            }
        }else{
            $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        }
        $output['name']     = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$output['cate']);
        }
        $output['knowpay'] = $this->request->getIntParam('knowpay');
        if($output['knowpay']){
            $where[] = array('name' => 'g_knowledge_pay_type','oper' => '=','value' =>$output['knowpay']);
        }
        $output['selDeduct']     = $this->request->getIntParam('selDeduct');
        if($output['selDeduct']){
            $where[] = array('name' => 'g_is_deduct','oper' => '=','value' =>($output['selDeduct']-1));
        }
        $output['status'] = $this->request->getStrParam('status','sell');
        switch($output['status']){
            case 'sell':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                $where[] = array('name' => 'g_stock','oper' => '>','value' =>0);
                break;
            case 'sellout':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                $where[] = array('name' => 'g_stock','oper' => '<=','value' =>0);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>2);
                break;
        }

        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $total = $goods_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            foreach($list as $key=>$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
                $path = '';
                if($val['g_knowledge_pay_type'] == 1){
                    $path = $client_plugin::KNOWPAY_ARTICLE_CODE_PATH;
                }
                if($val['g_knowledge_pay_type'] == 2){
                    $path = $client_plugin::KNOWPAY_AUDIO_CODE_PATH;
                }
                if($val['g_knowledge_pay_type'] == 3){
                    $path = $client_plugin::KNOWPAY_VIDEO_CODE_PATH;
                }
                $val['link'] = $path;
                if(!$val['g_qrcode']){
                    $list[$key]['g_qrcode']=$this->create_qrcode($val['g_id'], $val['g_cover']);
                }
            }
            if(!empty($deduct_gids)){
                $deduct_model = new App_Model_Goods_MysqlDeductStorage($this->curr_sid);
                $deduct = $deduct_model->getListByGids($deduct_gids);
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $knowpayType = [
            1 => '图文',
            2 => '音频',
            3 => '视频'
        ];
        $output['knowpayType'] = $knowpayType;
        $output['list'] = $list;
        $output['deduct'] = $deduct;
        $this->showOutput($output);
    }

    
    private function create_qrcode($id, $cover=''){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $good  = $good_model->getRowById($id);
        if(!$cover){
            $cover = $good['g_cover'];
        }
        $str = "id=".$id;
        if($good['g_knowledge_pay_type'] == 1){
            $path = $client_plugin::KNOWPAY_ARTICLE_CODE_PATH;
        }
        if($good['g_knowledge_pay_type'] == 2){
            $path = $client_plugin::KNOWPAY_AUDIO_CODE_PATH;
        }
        if($good['g_knowledge_pay_type'] == 3){
            $path = $client_plugin::KNOWPAY_VIDEO_CODE_PATH;
        }
        $url = $client_plugin->fetchWxappShareCode($str, $path, 210, $cover);
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }


    
    public function createQrcodeAction(){
        $id = $this->request->getIntParam('id');
        $url = $this->create_qrcode($id,'');
        $res = array('ec'=> 200,'em'=> '创建成功！','url'=> $url);
        $this->displayJson($res);
    }

    private function _show_category_type($is_add=1){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $temp          = $category_model->getAllFirstCategory();
        $category = array();
        foreach($temp as $val){
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category']   =$category ;
        $this->output['type']       = plum_parse_config('goodsType');
    }
    public function addGoodsAction(){
        $id  = $this->request->getIntParam('id');
        $isAdd  = 'add';
        $row = array(); $slide = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $isAdd  = 'edit';
            }
        }
        $message_storage = new App_Model_Goods_MysqlMessageTemplateStorage();
        $sort = array('amt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'amt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'amt_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'amt_deleted', 'oper' => '=', 'value' => 0);
        $messageList = $message_storage->getList($where, 0, 0, $sort);

        $this->output['messageListData'] = $messageList;
        $where = array();
        $where[] = array('name'=>'akt_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'akt_deleted','oper'=>'=','value'=>0);
        $sort = array('akt_create_time'=>'DESC');
        $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->curr_sid);
        $this->output['teacherList'] = $teacher_storage->getList($where,0,0);
        $this->output['type']   = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  = $slide;
        $this->output['isAdd']  = $isAdd;


        $this->output['menuType'] = $this->menuType;
        $this->output['acType']   = $this->wxapp_cfg['ac_type'];

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '课程管理', 'link' => '/wxapp/knowledgepay/goodsList'),
            array('title' => '添加课程', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/knowledgepay/add-goods.tpl");
    }

    
    private function _show_category(){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getAllFirstCategory();
        $category       = array();
        foreach($first as $val){
            $category[$val['sk_id']] = $val['sk_name'];
        }
        $this->output['category']   =$category ;
    }
    public function saveGoodsAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写完整课程数据'
        );
        $id       = $this->request->getIntParam('id');
        $data['g_name']         = $this->request->getStrParam('g_name');
        $data['g_price']        = $this->request->getFloatParam('g_price');
        $is_point = $this->request->getIntParam('is_point');
        if($is_point){
            $data['g_type']         = 5;//知识付费积分课程
        }else{
            $data['g_type']         = 2;//知识付费添加课程默认为虚拟课程
        }

        $data['g_points']         = $this->request->getFloatParam('g_points');
        $data['g_message_tpid'] = $this->request->getStrParam('g_message_tpid');

        $data['g_cover']        = $this->request->getStrParam('g_cover');
        $data['g_cover1']       = $this->request->getStrParam('g_cover1');
        $data['g_brief']        = $this->request->getStrParam('g_brief'); ;
        $data['g_label']        = $this->request->getStrParam('g_label'); ;
        $data['g_knowledge_total']  = $this->request->getIntParam('g_knowledge_total'); ;
        $data['g_detail']       = $this->request->getStrParam('g_detail');

        $istop                  = $this->request->getStrParam('g_is_top');
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        $isSpecial              = $this->request->getStrParam('g_special');
        $data['g_special']      = ($isSpecial == 'on' || $isSpecial == 1)? 1 : 0;

        $cusCategory            = $this->_get_custom_category();
        $data['g_kind1']        = $cusCategory['kind1'];
        $data['g_kind2']        = $cusCategory['kind2'];

        $data['g_sold']         = $this->request->getIntParam('g_sold');
        $data['g_weight']       = $this->request->getIntParam('g_weight');
        $data['g_knowledge_pay_type']     = $this->request->getIntParam('g_knowledge_pay_type');
        $data['g_s_id']         = $this->curr_sid;
        $data['g_update_time']  = time();
        $data['g_stock']  = 999;
        $data['g_custom_label'] = $this->request->getStrParam('g_custom_label');

        $data['g_vip_price']    = $this->request->getFloatParam('g_vip_price');
        $data['g_had_vip_price'] = 0;
        if($data['g_vip_price']) {
            $data['g_had_vip_price'] = 1;
        }


        if($data['g_name'] && $data['g_cover']){
            $is_add = 0;
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            if($id){
                $ret = $goods_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
            }else{
                $data['g_create_time'] = time();
                $ret = $goods_model->insertValue($data);
                $id  = $ret;
                $is_add = 1;
            }
            if($ret){
                if($is_add){
                    $this->create_qrcode($ret, $data['g_cover']);
                }
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("课程【{$data['g_name']}】保存成功");

            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    private function _get_custom_category(){
        $result = array(
            'kind1' => 0,
            'kind2' => 0,
        );
        $kind2 = $this->request->getIntParam('custom_cate');
        if($kind2){
            $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
            $row            = $category_model->getRowUpdateByIdSid($kind2,$this->curr_sid);
            $result['kind1']= $row['sk_fid'];
            $result['kind2']= $row['sk_id'];
        }
        return $result;
    }
    public function goodsKnowledgeListAction(){
        $id  = $this->request->getIntParam('id');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowByIdSid($id,$this->curr_sid);
        $this->output['goods']    = $goods;
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->curr_sid);
        $total = $knowpay_model->getKnowledgeCountByGid($id);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list = array();
        if($index <= $total){
            $list = $knowpay_model->getKnowledgeByGid($id,$index,$this->count);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '课程管理', 'link' => '/wxapp/knowledgepay/goodsList'),
            array('title' => '添加课程', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/knowledgepay/goods-knowledge-list.tpl");
    }
    public function addGoodsKnowledgeAction(){
        $id = $this->request->getIntParam('id');
        $gid = $this->request->getIntParam('gid');
        $type = $this->request->getIntParam('type');
        $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->curr_sid);
        $row = $knowpay_model->getRowById($id);
        if($row['akk_url']){
            $urlArr = explode('?',$row['akk_url']);
            $row['akk_url'] = $urlArr[0].'?v='.rand(0, 1000);
        }

        if($this->curr_shop['s_media_provider'] == 1){
            $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
            $qiniu       = $qiniu_model->findRowCfg();
            if($qiniu){
                $url  = plum_parse_config('url', 'qiniu');
                $this->output['qiniu'] = $qiniu;
                $this->output['uploadUrl'] = $url[$qiniu['aq_bucket_zone']];
                $this->output['qnDomain'] = $qiniu['aq_host'] == 'tdkjxcx.tincing.com' ? 'https://'.$qiniu['aq_host'] :  'http://'.$qiniu['aq_host'];


                if($row['akk_url']){
                    $urlArr = parse_url($row['akk_url']);
                    $key = substr($urlArr['path'],1,8).($type==2?'.mp3':'.mp4');
                    if(strlen($key) != 12){
                        $key = plum_random_code(8).($type==2?'.mp3':'.mp4');
                    }
                }else{
                    $key = plum_random_code(8).($type==2?'.mp3':'.mp4');
                }
                $qiniu_client = new App_Plugin_Qiniu_Client($qiniu['aq_access_key'], $qiniu['aq_secret_key'], $qiniu['aq_bucket_name']);
                $token = $qiniu_client->getUploadToken($key);
                $this->output['token'] = $token;
                $this->output['key'] = $key;
            }
        }else{
            $tencentyun_model = new App_Model_Applet_MysqlAppletTencentyunStorage($this->curr_sid);
            $tencentyun       = $tencentyun_model->findRowCfg();
            if($tencentyun){
                if($row['akk_url']){
                    $urlArr = parse_url($row['akk_url']);
                    $key = substr($urlArr['path'],1,8).($type==2?'.mp3':'.mp4');
                    if(strlen($key) != 12){
                        $key = plum_random_code(8).($type==2?'.mp3':'.mp4');
                    }
                }else{
                    $key = plum_random_code(8).($type==2?'.mp3':'.mp4');
                }
                $this->output['tencentyun'] = $tencentyun;
                $this->output['key'] = $key;
            }
        }
        if($row['akk_recommend_goods']){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
            $gidArr = json_decode($row['akk_recommend_goods'],1);
            if(!empty($gidArr)){
                $where_goods[]    = array('name' => 'g_id', 'oper' => 'in', 'value' => $gidArr);
                $where_goods[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' =>$this->curr_sid);
                $where_goods[]    = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
                $goodsList = $goods_model->getList($where_goods,0,10,array(),array('g_id','g_name'));
            }
            $this->output['goodsList'] = $goodsList;
        }
        $this->output['type'] = $type;
        $this->output['gid']  = $gid;
        $this->output['row']  = $row;
        $this->output['mediaProvider'] = $this->curr_shop['s_media_provider'];
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '课程管理', 'link' => '/wxapp/knowledgepay/goodsList'),
            array('title' => '课程管理', 'link' => '/wxapp/knowledgepay/goodsKnowledgeList?id='.$gid),
            array('title' => '添加课程', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/add-goods-knowledge.tpl');
    }
    public function saveGoodsKnowledgeAction(){
        $id                = $this->request->getIntParam('id');
        $data['akk_g_id']  = $this->request->getIntParam('gid');
        $data['akk_type']  = $this->request->getIntParam('type');
        $isfree            = $this->request->getStrParam('akk_is_free');
        $data['akk_read_num'] = $this->request->getIntParam('akk_read_num');
        $data['akk_content']  = $this->request->getStrParam('akk_content');
        $data['akk_url']      = $this->request->getStrParam('akk_url');
        $data['akk_name']     = $this->request->getStrParam('akk_name');
        $data['akk_cover']    = $this->request->getStrParam('akk_cover');
        $data['akk_sort']     = $this->request->getIntParam('akk_sort');
        $data['akk_free_time'] = $this->request->getIntParam('akk_free_time');
        $data['akk_recommend_goods']= $this->request->getStrParam('gids');
        $data['akk_is_free']  = ($isfree == 'on' || $isfree == 1)? 1 : 0;
        $data['akk_update_time']  = time();
        $data['akk_s_id']     = $this->curr_sid;

        if($data['akk_name'] && $data['akk_type'] && $data['akk_g_id']){
            $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->curr_sid);
            if($id){
                $ret = $knowpay_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
                if($data['akk_url']){
                    $params = array(
                        'urls' => array($data['akk_url'])
                    );
                    $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
                    $qiniu       = $qiniu_model->findRowCfg();
                    $qiniu_client = new App_Plugin_Qiniu_Client($qiniu['aq_access_key'], $qiniu['aq_secret_key'], $qiniu['aq_bucket_name']);
                    $ret = $qiniu_client->refreshCdn($params);
                }
            }else{
                $data['akk_create_time'] = time();
                $ret = $knowpay_model->insertValue($data);
            }
        }

        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '保存成功',
            );
            App_Helper_OperateLog::saveOperateLog("课程中课程【{$data['akk_name']}】保存成功");
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
    }
    public function delGoodsKnowledgeAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->curr_sid);
            $data = $knowpay_model->getRowById($id);
            $set = array('akk_deleted' => 1);
            $ret = $knowpay_model->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("课程中课程【{$data['akk_name']}】删除成功");
            }

            $this->showAjaxResult($ret);
        }
    }

    
    public function tradeListAction() {
        $applet_cfg = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $cfg        = $applet_cfg->findShopCfg();
        $this->output['indexTpl'] = $cfg['ac_index_tpl'];

        $this->show_trade_list_data();
        $this->output['link'] = $this->showTableLink('order');
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;

        $where[] = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '订单管理', 'link' => '#'),
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/trade-list.tpl');
    }

    
    public function tradeDetailAction() {
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_applet_type;

        $this->show_trade_detail_data();
        $this->buildBreadcrumbs(array(
            array('title' => '订单管理', 'link' => '/wxapp/knowledgepay/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/trade-detail.tpl');
    }

    
    private function show_trade_detail_data(){
        $tid = $this->request->getStrParam('order_no');
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'t_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'t_tid','oper'=>'=','value'=>$tid);
        $list       = $trade_model->getAddressList($where,0,1,array());
        if(!empty($list) && isset($list[0])){
            $row = $list[0];
            $output['row']  = $row;
            $express = array();
            $needSend= 0;
            if($row['t_status'] == App_Helper_Trade::TRADE_HAD_PAY){
                $express_model  = new App_Model_Trade_MysqlExpressStorage();
                $express        = $express_model->getExpressList(1);
                $needSend       = 1;
            }
            $output['needSend'] = $needSend;
            $output['express']  = $express;
            $coupon = array();
            if($row['t_discount_fee']){
                $trade_coupon_model = new App_Model_Trade_MysqlTradeCouponStorage($this->curr_sid);
                $coupon             = $trade_coupon_model->getListByTid($row['t_tid']);
            }
            $output['coupon']       = $coupon;
            $full   = array();
            if($row['t_promotion_fee']){
                $trade_full_model   = new App_Model_Trade_MysqlTradeFullStorage($this->curr_sid);
                $full               = $trade_full_model->getListByTid($row['t_tid']);
            }
            $output['full']         = $full;
            $trade_order        = new App_Model_Trade_MysqlTradeOrderStorage($this->curr_sid);
            $output['list']     = $trade_order->getGoodsListByTid($row['t_id']);

            $this->_trade_detail_status_desc($row);
            $output['statusNote'] = plum_parse_config('trade_status');
            $this->express_detail($row['t_company_code'],$row['t_express_code']);
            $this->showOutput($output);
        }else{
            plum_url_location('订单号错误');
        }
    }

    private function _trade_detail_status_desc($row){
        $desc = array();
        switch($row['t_status']){
            case App_Helper_Trade::TRADE_NO_PAY:
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => '<div>等待买家付款款</div>'
                );
                break;
            case App_Helper_Trade::TRADE_HAD_PAY:
                if(App_Helper_Trade::TRADE_PAY_WXZFZY == $row['t_pay_type']){
                    $account = '<div>买家已将货款支付至您的 微信对公账户，请到<a href="http://pay.weixin.qq.com" target="_blank">微信商户平台</a>查收。</div>';
                }elseif(App_Helper_Trade::TRADE_PAY_HDFK == $row['t_pay_type']){
                    $account = '该订单为 货到付款订单 ';
                }else{
                }
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => $account
                );
                break;
            case App_Helper_Trade::TRADE_SHIP:
                $desc = array(
                    'icon'      => '!',
                    'class'     => 'primary',
                    'desc'      => '<div>已发货、等待用户确认收货。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_FINISH:
                $desc = array(
                    'icon'      => '√',
                    'class'     => 'success',
                    'desc'      => '<div>用户已确认收货，订单已经完成。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_CLOSED:
                $desc = array(
                    'icon'      => 'X',
                    'class'     => 'danger',
                    'desc'      => '<div>订单已关闭。</div>'
                );
                break;
            case App_Helper_Trade::TRADE_REFUND:
                $desc = array(
                    'icon'      => 'X',
                    'class'     => 'danger',
                    'desc'      => '<div>退款订单。</div>'
                );
                break;
        }
        $this->output['desc'] = $desc;
    }

    private function express_detail($code,$num){
        $data = array();
        $nowStatus = '';
        if($code && $num){
            $track_model = new App_Helper_ExpressTrack();
            $track = $track_model->fetchJsonTrack($code,$num);
            if(!empty($track) && $track['Success']){
                $data = $track['Traces'];
                switch ($track['State']){
                    case 2 :
                        $status = '[在途中]';
                        break;
                    case 3 :
                        $status = '[签收]';
                        break;
                    case 4 :
                        $status = '[问题件]';
                        break;
                    default:
                        $status = '[在途中]';
                        break;
                }
                $nowStatus = $data[count($data)-1]['AcceptTime'].' '.$status.' '. $data[count($data)-1]['AcceptStation'];
            }
        }
        $this->output['nowStatus']  = $nowStatus;
        $this->output['last']       = count($data)-1;
        $this->output['track']      = $data;
    }
    public function activityAction(){
        $this->showIndexTpl();
        $this->showShopTplSlide(0, 7);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $type = array(
            array(
                'id' => '1',
                'name' => '拼团活动'
            ),
            array(
                'id' => '2',
                'name' => '秒杀活动'
            ),
            array(
                'id' => '3',
                'name' => '砍价砍价'
            ),
        );
        if($this->menuType == 'toutiao' && $this->wxapp_cfg['ac_type'] ==27) {
            $type = [
                array(
                    'id' => '2',
                    'name' => '秒杀活动'
                ),
            ];
        }

        $this->output['activityType'] = json_encode($type);
        $this->buildBreadcrumbs(array(
            array('title' => '知识付费管理', 'link' => '#'),
            array('title' => '活动管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/knowledgepay/activity-cfg.tpl");
    }

    
    private function showIndexTpl(){
        $tpl_model = new App_Model_Knowpay_MysqlActivityCfgStorage($this->curr_sid);
        $tpl  = $tpl_model->fetchUpdateCfg();
        if(empty($tpl)){
            $tpl = array(
                'aka_title'         => '活动',
                'aka_kinds'         => json_encode(array())
            );
        }
        $tpl['aka_kinds'] = $tpl['aka_kinds']?$tpl['aka_kinds']:json_encode(array());
        $this->output['tpl'] = $tpl;
    }

    
    public function saveActivityCfgAction(){
        $title            = $this->request->getStrParam('title');
        $goodFlShow       = $this->request->getArrParam('goodFlShow');
        $data = array(
            'aka_s_id'                => $this->curr_sid,
            'aka_title'               => $title,
            'aka_kinds'               => json_encode($goodFlShow),
            'aka_update_time'        => time(),
        );
        $tpl_model = new App_Model_Knowpay_MysqlActivityCfgStorage($this->curr_sid);
        $tpl_row   = $tpl_model->fetchUpdateCfg();
        if(!empty($tpl_row)){
            $ret = $tpl_model->fetchUpdateCfg($data);
        }else{
            $tpl['aka_create_time']= time();
            $ret = $tpl_model->insertValue($data);
        }
        if($ret){
            $this->save_shop_slide(0, 7);//保存幻灯
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
            App_Helper_OperateLog::saveOperateLog("活动页配置信息保存成功");
        }else{
            $result = array(
                'ec' => 400,
                'em' => '模版不可用'
            );
        }
        $this->displayJson($result);
    }

    
    public function commentListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $where = array();
        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => 'akc_comment', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $this->output['start']   = $this->request->getStrParam('start');
        if($this->output['start']){
            $where[]    = array('name' => 'akc_time', 'oper' => '>=', 'value' => strtotime($this->output['start']));
        }
        $this->output['end']     = $this->request->getStrParam('end');
        if( $this->output['end']){
            $where[]    = array('name' => 'akc_time', 'oper' => '<=', 'value' => (strtotime($this->output['end']) + 86400));
        }
        $where[] = array('name'=>'akc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'akc_c_id','oper'=>'=','value'=>0);
        $comment_storage = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->curr_sid);
        $total      = $comment_storage->getCommentListMemberCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        if($index < $total){
            $list          = $comment_storage->getCommentListMember($where, $index,$this->count);
        }
        foreach($list as $key=>$val){
            $list[$key]['akc_comment'] = $this->utf8_str_to_unicode($val['akc_comment']);
        }
        $this->output['list'] = $list;

        $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $indexCfg = $index_model->findUpdateBySid(59);
        if(!$indexCfg){
            $indexCfg = [
                'aki_allow_comment' => 1
            ];
        }
        $this->output['indexCfg'] = $indexCfg;

        $this->buildBreadcrumbs(array(
            array('title' => '课程管理', 'link' => '#'),
            array('title' => '评论列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/comment-list.tpl');
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

    
    public function deleteCommentAction(){
        $cid = $this->request->getIntParam('cid');
        $ret = 0;
        if($cid){
            $comment_storage = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->curr_sid);
            $ret = $comment_storage->deleteById($cid);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("评论删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    
    public function commentDetailsAction(){
        $id = $this->request->getIntParam('id');
        $comment_storage = new App_Model_Knowpay_MysqlKnowpayCommentStorage($this->curr_sid);
        $comment = $comment_storage->getRowById($id);
        $comment['akc_comment'] = $this->utf8_str_to_unicode($comment['akc_comment']);
        $commentList = $comment_storage->getCommentMember($comment['akc_g_id'],$comment['akc_k_id'],$comment['akc_id'],0,0);
        $this->output['commentList'] = $commentList;
        $this->output['comment'] = $comment;
        $this->buildBreadcrumbs(array(
            array('title' => '评论列表', 'link' => '/wxapp/order/commentList'),
            array('title' => '评论详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/comment-details.tpl');
    }
    
    public function secondPointLink($type='index'){
        $link = array(
            array(
                'label' => '积分商城',
                'link'  => '/wxapp/knowledgepay/pointCfg',
                'active'=> 'pointCfg'
            ),
            array(
                'label' => '积分课程',
                'link'  => '/wxapp/knowledgepay/pointGoods',
                'active'=> 'pointCourse'
            ),
            array(
                'label' => '积分商品',
                'link'  => '/wxapp/community/pointGoods',
                'active'=> 'pointGoods'
            ),
            array(
                'label' => '积分订单',
                'link'  => '/wxapp/knowledgepay/pointOrder',
                'active'=> 'pointOrder'
            ),
            array(
                'label' => '积分来源',
                'link'  => '/wxapp/community/pointSourceCfg',
                'active'=> 'pointSourceCfg'
            ),
        );
        $this->output['linkLeft']   = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '积分商城';
    }

    
    public function pointCfgAction(){
        $this->secondPointLink('pointCfg');
        $tpl_model = new App_Model_Community_MysqlCommunityIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid();
        $this->output['pointImg']  = $tpl['aci_point_img']?$tpl['aci_point_img']:'';
        $this->output['point']     = $tpl['aci_point']?$tpl['aci_point']:0;
        $this->output['content']   = $tpl['aci_point_rule']?$tpl['aci_point_rule']:'';
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/knowledgepay/pointGoods'),
            array('title' => '积分商城', 'link' => '#'),
        ));
        $imgArr = $tpl['aci_point_slide']?json_decode($tpl['aci_point_slide'],1):'';
        $json   = array();
        if($imgArr){
            foreach ($imgArr as $key=>$val){
                $json[] = array(
                    'index'     => $val['index'] ,
                    'imgsrc'    => $val['imgsrc'],
                );
            }
        }
        $this->output['slide'] = json_encode($json);
        $this->displaySmarty("wxapp/knowledgepay/point-cfg.tpl");
    }

    
    public function pointGoodsAction(){
        $this->secondPointLink('pointCourse');
        $this->_show_goods_list_data(1);
        $this->output['choseLink']  = $this->showTableLink('pointGoods');
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/knowledgepay/pointGoods'),
            array('title' => '积分课程', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/knowledgepay/point-goods.tpl");
    }

    public function addPointGoodsAction(){
        $id  = $this->request->getIntParam('id');
        $isAdd  = 'add';
        $row = array(); $slide = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $isAdd  = 'edit';
            }
        }
        $this->output['type']   = plum_parse_config('goodsType');
        $this->output['row']    = $row;
        $this->output['slide']  =  $slide;
        $this->output['isAdd']  = $isAdd;

        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '课程管理', 'link' => '/wxapp/knowledgepay/pointGoods'),
            array('title' => '添加课程', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/knowledgepay/add-point-goods.tpl");
    }

    

    public function selectGoodsAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '积分商品', 'link' => '/wxapp/knowledgepay/pointGoods'),
            array('title' => '添加积分商品', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/select-goods.tpl');
    }

    
    public function copyPointGoodsAction(){
        $result  =  array('ec'=>400,'em'=>'保存失败');
        $ret = $this->save_point_goods();
        if($ret){
            $result  =  array('ec'=>200,'em'=>'保存成功');
            App_Helper_OperateLog::saveOperateLog("积分课程保存成功");
        }
        $this->displayJson($result);
    }

    
    private function save_point_goods(){
        $goods          = $this->request->getArrParam('goods');
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $knowpay_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($this->curr_sid);
        foreach($goods as $val){
            $data     = array();
            $goodData = $goods_model->getRowById($val['gid']);
            foreach ($goodData as $key=>$item){
                $data[$key] = $item;
            }
            $data['g_points'] = $val['price'];
            $data['g_type']   = $data['g_type'] == 1?4:5;
            $data['g_create_time'] = time();
            $data['g_update_time'] = time();
            $data['g_price'] = 0;
            unset($data['g_id']);
            unset($data['g_qrcode']);
            $gret  = $goods_model->insertValue($data);//新商品的id
            $where = array();
            $where[] = array('name' => 'akk_g_id', 'oper' => '=', 'value' => $val['gid']);
            $where[] = array('name' => 'akk_deleted', 'oper' => '=', 'value' => 0);
            $knowledge = $knowpay_model->getList($where, 0, 0);
            foreach ($knowledge as $know){
                $knowData = array();
                foreach ($know as $key=>$knowItem){
                    $knowData[$key] = $knowItem;
                }
                $knowData['akk_g_id'] = $gret;
                unset($knowData['akk_id']);
                $ret  = $knowpay_model->insertValue($knowData);
            }
        }
        if($gret){
            return true;
        }
    }

    
    public function pointOrderAction() {
        $this->secondPointLink('pointOrder');
        $where[] = array('name' => 't_es_id', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_POINT);
        $this->show_trade_list_data($where);
        $link = App_Helper_Trade::$trade_link_status;
        unset($link['tuan']);
        $this->output['link'] = $link;
        $this->output['pointOrder'] = 1;
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;
        $this->output['searchUrl'] = '/wxapp/knowledgepay/pointOrder';
        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '积分商城', 'link' => '/wxapp/knowledgepay/pointGoods'),
            array('title' => '积分订单', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/trade-list.tpl');
    }


    
    public function centerManageAction(){
        $center_model   = new App_Model_Member_MysqlCenterToolStorage();
        $row            = $center_model->findUpdateBySid($this->curr_sid);
        if(empty($row)){
            $row = plum_parse_config('center_tool');
        }
        if(!$row['ct_nav_list']){
            $row['ct_nav_list'] = json_encode(array(
                array(
                    'index' => 0,
                    'open' => false,
                    'title' => '我的账户',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
                array(
                    'index' => 1,
                    'open' => false,
                    'title' => '优惠券',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
                array(
                    'index' => 2,
                    'open' => false,
                    'title' => '积分商城',
                    'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
                ),
            ));
        }else{
            $navList = json_decode($row['ct_nav_list'], true);
            foreach($navList as $key=>$val){
                $navList[$key]['open'] = $val['open'] == 'true'?true:false;
            }
            $row['ct_nav_list'] = json_encode($navList);
        }
        $this->output['row'] = $row;
        $this->buildBreadcrumbs(array(
            array('title' => '知识付费管理', 'link' => '#'),
            array('title' => '会员中心', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/member/knowpay-member-center.tpl');
    }

    
    public function rechargeCodeAction(){
        $page = $this->request->getIntParam('page');
        $status = $this->request->getIntParam('status');
        $index = $this->count * $page;
        $code_storage = new App_Model_Knowpay_MysqlKnowpayRechargeCodeStorage($this->curr_sid);
        $where[] = array('name' => 'akrc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'akrc_deleted', 'oper' => '=', 'value' => 0);
        if($status){
            $where[] = array('name' => 'akrc_status', 'oper' => '=', 'value' => 1);
        }else{
            $where[] = array('name' => 'akrc_status', 'oper' => '=', 'value' => 0);
        }
        $total = $code_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination']   = $pageCfg->render();
        $list = array();
        if($index < $total){
            $sort = array('akrc_create_time' => 'desc');
            $list = $code_storage->getList($where, $index, $this->count, $sort);
        }
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->curr_sid);
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $sort   = array('oc_price' => 'ASC', 'oc_long_type' => 'ASC','oc_update_time' => 'DESC');
        $cardlist   = $card_model->getList($where,0,0,$sort);
        $selectCard = array();
        foreach ($cardlist as $val){
            $selectCard[$val['oc_id']] = $val['oc_name'];
        }

        if($this->wxapp_cfg['ac_type'] == 18){
            $tpl_model = new App_Model_Reservation_MysqlReservationIndexStorage($this->curr_sid);
            $tpl  = $tpl_model->findUpdateBySid(33);

            $tpl['aki_recharge_sub_title'] = $tpl['ari_recharge_sub_title'];
            $tpl['aki_recharge_rule'] = $tpl['ari_recharge_rule'];
            $title = '预约管理';
        }else{
            $tpl_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
            $tpl  = $tpl_model->findUpdateBySid(59);
            $title = '知识付费管理';
        }

        $this->output['tpl'] = $tpl;
        $this->output['list'] = $list;
        $this->output['cardList'] = $selectCard;
        $this->output['index'] = $index;
        $this->output['status'] = $status;
        $this->buildBreadcrumbs(array(
            array('title' => $title, 'link' => '#'),
            array('title' => '会员兑换码', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/recharge-code-list.tpl');
    }

    
    public function createRechargeCodeAction(){
        $num = $this->request->getIntParam('number');
        $value = $this->request->getFloatParam('value');
        $expire = $this->request->getStrParam('expire');
        if(!$expire){
            $this->displayJsonError('请填写过期时间');
        }
        $code_storage = new App_Model_Knowpay_MysqlKnowpayRechargeCodeStorage($this->curr_sid);
        for($i = 0; $i < $num; $i++){
            $code = plum_random_code(16,false);
            $insert = array(
                'akrc_s_id'  => $this->curr_sid,
                'akrc_value' => $value,
                'akrc_code'  => $code,
                'akrc_status'=> 0,
                'akrc_expire_time' => strtotime($expire),
                'akrc_create_time' => time()
            );
            $ret = $code_storage->insertValue($insert);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("充值码创建成功");
            }

        }

        $this->showAjaxResult($ret,'创建');
    }

    
    public function exportRechargeCodeAction(){
        include_once(PLUM_APP_PLUGIN.'/phpexcel/PHPExcel.php');
        $start = $this->request->getIntParam('start');
        $end  = $this->request->getIntParam('end');
        $count = $end-$start+1;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
            ->setCreator("WOLF")
            ->setLastModifiedBy("WOLF")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
        $objActSheet = $objPHPExcel->setActiveSheetIndex(0);
        $objActSheet->setCellValue('A1','充值码');
        $objActSheet->setCellValue('B1','绑定会员卡');
        $objActSheet->setCellValue('C1','过期时间');

        $code_storage = new App_Model_Knowpay_MysqlKnowpayRechargeCodeStorage($this->curr_sid);
        $where[] = array('name' => 'akrc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'akrc_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'akrc_status', 'oper' => '=', 'value' => 0);
        $sort = array('akrc_create_time' => 'desc');
        $list = $code_storage->getList($where, $start-1, $count, $sort);
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->curr_sid);
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $sort   = array('oc_price' => 'ASC', 'oc_long_type' => 'ASC','oc_update_time' => 'DESC');
        $cardlist   = $card_model->getList($where,0,0,$sort);
        $selectCard = array();
        foreach ($cardlist as $val){
            $selectCard[$val['oc_id']] = $val['oc_name'];
        }
        foreach ($list as $key=>$row){
            $time = $row['akrc_expire_time']?date("Y-m-d", $row['akrc_expire_time']):'长期有效';
            $objActSheet->setCellValue('A'.($key+2),$row['akrc_code']);
            $objActSheet->setCellValue('B'.($key+2),$selectCard[$row['akrc_value']]);
            $objActSheet->setCellValue('C'.($key+2),$time);
        }
        $objPHPExcel->getActiveSheet()->setTitle('充值码');
        $objPHPExcel->setActiveSheetIndex(0);
        $day      = date("m-d");
        $filename = $day.'充值码.xls';
        ob_end_clean();//清除缓冲区,避免乱码
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    
    public function delRechargeCodeAction(){
        $id  = $this->request->getIntParam('id');
        if($id){
            $code_storage = new App_Model_Knowpay_MysqlKnowpayRechargeCodeStorage($this->curr_sid);
            $update = array(
                'akrc_deleted' => 1
            );
            $ret = $code_storage->updateById($update, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("充值码删除成功");
            }

            $this->showAjaxResult($ret,'删除');
        }
    }

    
    public function addClassicalQuotationAction(){
        $id  =  $this->request->getIntParam('id');
        if($id){
            $quotation_storage = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->curr_sid);
            $row = $quotation_storage->getRowById($id);
            $this->output['row'] = $row;
            $imgs = json_decode($row['kcq_images'],true);
            $this->output['imgs'] = $imgs ? $imgs : [];
        }
        $memberModel              = new App_Model_Member_MysqlMemberCoreStorage();
        $this->output['memberList'] = $memberModel->getMemberListBySource($this->curr_sid,5);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '管理首页', 'link' => '#'),
            array('title' => '经典语录管理', 'link' => '/wxapp/knowledgepay/quotationList'),
            array('title' => '添加经典语录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/add-quotation.tpl');
    }

    
    public function coverUploadAction() {
        $uploader   = new Libs_File_Transfer_Uploader();
        $ret = $uploader->receiveFile('img_cover');

        if (!$ret) {
            $this->displayJsonError("上传失败，请重试");
        }
        $this->displayJsonSuccess(array('path' => $ret['img_cover']));
    }

    public function saveClassicalQuotationAction(){
        $id = $this->request->getIntParam('id');
        $mid = $this->request->getIntParam('mid');
        $content = $this->request->getStrParam('content');
        $images = $this->request->getArrParam('slide');
        if(($mid || $id) && $content && $images){
            $data = array(
                'kcq_s_id'    => $this->curr_sid,
                'kcq_cover'   => $images ? $images[0] : '',
                'kcq_images'  => $images ? json_encode($images) : '',
                'kcq_content' => $content,
                'kcq_create_time' => time()
            );
            $quotation_storage = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->curr_sid);
            $row = $quotation_storage->findRowById($id);
            if($id && $row){
                $ret = $quotation_storage->updateById($data,$id);
            }else{
                $data['kcq_m_id'] = $mid;
                $ret = $quotation_storage->insertValue($data);
            }
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请将信息补充完整');
        }
    }

    
    public function deleteQuotationAction(){
        $id = $this->request->getIntParam('id');
        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->curr_sid);
        $res = $quotation_model->deleteDFById($id,$this->curr_sid);

        if($res){
            App_Helper_OperateLog::saveOperateLog("语录删除成功");
        }

        $this->showAjaxResult($res,'删除');
    }

    
    public function quotationListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;

        $this->output['nickname'] = $this->request->getStrParam('nickname');
        if($this->output['nickname']){
            $where[]        = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$this->output['nickname']}%");
        }
        $this->output['content'] = $this->request->getStrParam('content');
        if($this->output['content']){
            $where[]        = array('name' => 'kcq_content', 'oper' => 'like', 'value' => "%{$this->output['content']}%");
        }
        $out['start']   = $this->request->getStrParam('start');
        if($out['start']){
            $where[]    = array('name' => 'kcq_create_time', 'oper' => '>=', 'value' => strtotime($out['start']));
        }
        $out['end']     = $this->request->getStrParam('end');
        if($out['end']){
            $where[]    = array('name' => 'kcq_create_time', 'oper' => '<=', 'value' => (strtotime($out['end']) + 86400));
        }

        $where[] = array('name'=>'kcq_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'kcq_deleted','oper'=>'=','value'=>0);
        $post_storage = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->curr_sid);
        $total      = $post_storage->getQuotationMemberCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pagination'] = $pageCfg->render();
        $list = array();
        $sort = array('kcq_create_time'=>'DESC');
        if($index < $total){
            $list = $post_storage->getQuotationMemberList($where,$index,$this->count,$sort);
        }
        foreach($list as $key=>$val){
            $list[$key]['kcq_content'] = $this->utf8_str_to_unicode($val['kcq_content']);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '管理首页', 'link' => '#'),
            array('title' => '经典语录管理', 'link' => '/wxapp/knowledgepay/quotationList')
        ));
        $this->displaySmarty('wxapp/knowledgepay/quotation-list.tpl');
    }

    
    public function quotationDetailAction(){
        $id = $this->request->getIntParam('id');
        $quotation_model = new App_Model_Knowpay_MysqlKnowpayClassicalQuotationsStorage($this->curr_sid);
        $row = $quotation_model->getQuotationMemberRow($id);

        $row['kcq_content'] = $this->utf8_str_to_unicode($row['kcq_content']);
        $this->output['row'] = $row;
        $imgArr = $row['kcq_images'] ? json_decode($row['kcq_images'],true) : [];
        $this->output['imgList'] = $imgArr;
        $this->_quotation_comment_list($id);
        $this->buildBreadcrumbs(array(
            array('title' => '经典语录管理', 'link' => '/wxapp/knowledgepay/quotationList'),
            array('title' => '经典语录详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/quotation-detail.tpl');

    }

    private function _quotation_comment_list($qid){
        $count = 30;
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $where[] = array('name'=>'akqc_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'akqc_q_id','oper'=>'=','value'=>$qid);
        $comment_model = new App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage($this->curr_sid);
        $total      = $comment_model->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$count);
        $this->output['pagination'] = $pageCfg->render();
        $list = $comment_model->getCommentMember($qid,$index,$count);
        foreach($list as $key => $val){
            $list[$key]['akqc_comment'] = $this->utf8_str_to_unicode($val['akqc_comment']);
        }
        $this->output['commentList'] = $list;

    }

    
    public function deleteQuotationCommentAction(){
        $id = $this->request->getIntParam('id');
        $comment_model = new App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage($this->curr_sid);
        $res = $comment_model->deleteBySidId($id,$this->curr_sid);

        if($res){
            App_Helper_OperateLog::saveOperateLog("语录评论删除成功");
        }

        $this->showAjaxResult($res,'删除');
    }
    public function teacherListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $where = array();
        $where[] = array('name'=>'akt_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[] = array('name'=>'akt_deleted','oper'=>'=','value'=>0);
        $sort = array('akt_create_time'=>'DESC');
        $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->curr_sid);
        $total = $teacher_storage->getCount($where);
        $list = array();
        if($index<$total){
            $list = $teacher_storage->getList($where,$index,$this->count,$sort);
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);;
        $this->output['pageHtml'] = $page_libs->render();
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '讲师管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/knowledgepay/teacher-list.tpl');
    }
    public function addTeacherAction(){
        $id = $this->request->getIntParam('id');
        $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->curr_sid);
        $row = $teacher_storage->getRowById($id);
        $this->buildBreadcrumbs(array(
            array('title' => '讲师管理', 'link' => '/wxapp/knowledgepay/teacherList'),
            array('title' => '新增讲师', 'link' => '#'),
        ));
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->output['row'] = $row;
        $this->displaySmarty('wxapp/knowledgepay/teacher-edit.tpl');
    }
    public function saveTeacherAction(){
        $id     = $this->request->getIntParam('id');
        $name   = $this->request->getStrParam('name');
        $avatar = $this->request->getStrParam('avatar');
        $label  = $this->request->getStrParam('label');
        $desc   = $this->request->getStrParam('desc');
        $detail = $this->request->getStrParam('detail');

        $data = array(
            'akt_s_id'        => $this->curr_sid,
            'akt_name'        => $name,
            'akt_avatar'      => $avatar,
            'akt_label'       => $label,
            'akt_desc'        => $desc,
            'akt_detail'      => $detail,
        );
        $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->curr_sid);
        if($id > 0){
            $ret = $teacher_storage->updateById($data, $id);
        }else{
            $data['akt_create_time'] = time();
            $ret = $teacher_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("讲师【{$name}】删除成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function delTeacherAction(){
        $id = $this->request->getIntParam('id');
        if($id > 0){
            $teacher_storage = new App_Model_Knowpay_MysqlKnowpayTeacherStorage($this->curr_sid);
            $teacher = $teacher_storage->getRowById($id);
            $set = array('akt_deleted' => 1);
            $ret = $teacher_storage->updateById($set, $id);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("讲师【{$teacher['akt_name']}】删除成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->showAjaxResult(0);
        }
    }

    
    public function vipRightsCfgAction(){
        $cfg_model = new App_Model_Knowpay_MysqlKnowpayRightsCfgStorage($this->curr_sid);
        $row = $cfg_model->findUpdateBySid();
        $this->output['row'] = $row;
        $this->output['navList']    = $row['akrc_nav_list']?$row['akrc_nav_list']:json_encode([]);
        $this->output['rightsCate'] = $row['akrc_rights_cate']?$row['akrc_rights_cate']:json_encode([]);
        $this->_shop_top_goods_list();
        $this->_shop_kind_list_for_select();
        $this->_get_list_for_select();
        $this->_shop_information_category();
        $page = $this->_fetch_shop_outside();
        $page_data = $this->_fetch_page_data();
        $this->output['page_list'] = json_encode(array_merge($page,$page_data));
        $this->_shop_appointment_goods_list();
        $this->_get_jump_list();
        $this->_show_tpl_notice();
        $this->_shop_information();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '门店会员卡', 'link' => '/wxapp/membercard/index'),
            array('title' => '会员卡管理', 'link' => '/wxapp/membercard/card/type/2'),
            array('title' => '会员权益', 'link' => '#')
        ));
        $this->displaySmarty("wxapp/knowledgepay/vip-rights-cfg.tpl");
    }

    
    public function saveVipRightsCfgAction(){
        $headerTitle = $this->request->getStrParam('headerTitle');
        $navTitle    = $this->request->getStrParam('navTitle');
        $navList     = json_encode($this->request->getArrParam('navList'));
        $rightsTitle = $this->request->getStrParam('rightsTitle');
        $rightsCate  = json_encode($this->request->getArrParam('rightsCate'));

        $cfg_model = new App_Model_Knowpay_MysqlKnowpayRightsCfgStorage($this->curr_sid);
        $row = $cfg_model->findUpdateBySid();
        $data = array(
            'akrc_s_id'         => $this->curr_sid,
            'akrc_header_title' => $headerTitle,
            'akrc_nav_title'    => $navTitle,
            'akrc_nav_list'     => $navList,
            'akrc_rights_title' => $rightsTitle,
            'akrc_rights_cate'  => $rightsCate
        );
        if($row){
            $ret = $cfg_model->findUpdateBySid($data);
        }else{
            $data['akrc_create_time'] = time();
            $ret = $cfg_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("会员权益页面信息保存成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function updateFieldAction(){
        $picture_tab = $this->request->getStrParam('picture_tab');
        $audio_tab = $this->request->getStrParam('audio_tab');
        $video_tab = $this->request->getStrParam('video_tab');

        $picture_sort = $this->request->getIntParam('picture_sort');
        $audio_sort = $this->request->getIntParam('audio_sort');
        $video_sort = $this->request->getIntParam('video_sort');
        if(!$picture_tab){
            $picture_tab = '目录';
        }
        if(!$audio_tab){
            $audio_tab = '节目';
        }
        if(!$video_tab){
            $video_tab = '课程';
        }
        $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $index = $index_model->findUpdateBySid(59);
        $set = [
            'aki_picture_tab' => $picture_tab,
            'aki_audio_tab' => $audio_tab,
            'aki_video_tab' => $video_tab,

            'aki_picture_sort' => $picture_sort,
            'aki_audio_sort' => $audio_sort,
            'aki_video_sort' => $video_sort,

            'aki_update_time' => $_SERVER['REQUEST_TIME']
        ];
        if($index){
            $res = $index_model->findUpdateBySid(59,$set);
        }else{
            $set['aki_s_id'] = $this->curr_sid;
            $set['aki_tpl_id'] = 59;
            $set['aki_create_time'] = $_SERVER['REQUEST_TIME'];
            $res = $index_model->insertValue($set);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("课程列表详情配置保存成功");
        }

        $this->showAjaxResult($res);
    }

    
    public function changeAllowCommentAction(){

        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;
        $status_note = $status == 1 ? '启用' : '禁用';

        $index_model = new App_Model_Knowpay_MysqlKnowpayIndexStorage($this->curr_sid);
        $index = $index_model->findUpdateBySid(59);
        $set = [
            'aki_allow_comment' => $status,
            'aki_update_time' => $_SERVER['REQUEST_TIME']
        ];
        if($index){
            $res = $index_model->findUpdateBySid(59,$set);
        }else{
            $set['aki_s_id'] = $this->curr_sid;
            $set['aki_tpl_id'] = 59;
            $set['aki_create_time'] = $_SERVER['REQUEST_TIME'];
            $res = $index_model->insertValue($set);
        }

        if($res){
            App_Helper_OperateLog::saveOperateLog("课程评论{$status_note}成功");
        }

        $this->showAjaxResult($res);
    }
}
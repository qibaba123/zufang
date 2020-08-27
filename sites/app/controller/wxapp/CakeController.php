<?php


class App_Controller_Wxapp_CakeController extends App_Controller_Wxapp_OrderCommonController {

    public function __construct() {
        parent::__construct();
    }

    
    public function cakeTemplateAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '小程序首页模板', 'link' => '#'),
        ));
        $cfg = plum_parse_config('category','applet');
        $tpl_ids = $cfg[13]['tpl'];
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
        $this->displaySmarty('wxapp/cake/cake-template.tpl');
    }

    
    public function indexTplAction(){
        $tpl_id  = $this->request->getIntParam('tpl', 14);
        $this->showIndexTpl($tpl_id);
        $this->showShopTplSlide($tpl_id);
        $this->_show_store_list();
        $this->_show_shortcut_list($tpl_id);
        $this->_show_goods_list();
        $this->_show_special_goods_list();
        $this->_show_category();
        $this->_show_category_goods();
        $this->showShopTplShortcut($tpl_id);
        $this->_show_tpl_notice();
        $this->_shop_information();
        $this->_get_list_for_select();
        $this->_group_list_for_select();
        $this->_limit_list_for_select();
        $this->_bargain_list_for_select();
        $this->_get_jump_list();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->displaySmarty('wxapp/cake/index-tpl_'.$tpl_id.'.tpl');
    }

    
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

    
    private function _get_list_for_select(){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $weedingType = plum_parse_config('link_type_cake','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        $allMallType = plum_parse_config('link_type_all_mall','system');
        $this->output['linkType'] = json_encode(array_merge($linkType,$weedingType,$allMallType));
    }

    
    private function _show_shortcut_list($tpl_id){
        $shortcut_storage = new App_Model_Cake_MysqlCakeShortcutStorage($this->curr_sid);
        $where   = array();
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'acs_tpl', 'oper' => '=', 'value' => $tpl_id);
        $list    = $shortcut_storage->getList($where, 0, 0, array('acs_index' => 'ASC'));
        if($tpl_id == 14){
            $this->output['navList'] = $list;
        }else{
            $data = array();
            foreach($list as $val){
                $data[] = array(
                    'index'     => $val['acs_index'],
                    'imgsrc'    => $val['acs_imgsrc'],
                    'name'      => $val['acs_name'],
                    'linkTitle' => $val['acs_link_title'],
                    'link'      => $val['acs_link'],
                    'type'      => $val['acs_link_type']
                );
            }
            $this->output['navList'] = json_encode($data);
        }

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
                    'imgsrc'        => $val['atn_img'],
                    'articleId'     => $val['atn_article_id'],
                    'articleTitle'  => $val['atn_article_title'],
                    'type'          => $val['atn_type']
                );
            }
        }
        $this->output['activityList'] = json_encode($data);
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

    
    private function _show_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 50, null, 1, $sort);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        $this->output['goods'] = json_encode($info);
        $this->output['goodsSelect'] = $info;
    }

    
    private function _show_special_goods_list(){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $where       = array();
        $where[]     = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]     = array('name' => 'g_special', 'oper' => '=', 'value' => 1);
        $where[]     = array('name' => 'g_is_sale', 'oper' => '=', 'value' => 1);
        $where[]     = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
        $list        = $goods_model->getList($where, 0, 50, $sort);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        $this->output['special'] = json_encode($info);
    }

    
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

    
    private function showIndexTpl($tpl_id=14){
        $tpl_model = new App_Model_Cake_MysqlCakeIndexStorage($this->curr_sid);
        $tpl  = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'aci_title'         => '首页',
                'aci_address'       => '这里填写公司地址',
                'aci_lng'           => '114.72052',
                'aci_lat'           => '34.77485',
                'aci_tpl_id'        => $tpl_id,
            );
        }
        $this->output['tpl'] = $tpl;
    }
    private function save_cake_shortcut($tpl_id){
        $shortcut = $this->request->getArrParam('navList');
        $shortcut_model = new App_Model_Cake_MysqlCakeShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['ss_weight']])){
                        $set = array(
                            'acs_name'      => $shortcut[$val['acs_index']]['name'],
                            'acs_brief'     => $shortcut[$val['acs_index']]['brief'],
                            'acs_tpl'       => $tpl_id,
                            'acs_imgsrc'    => $shortcut[$val['acs_index']]['imgsrc'],
                            'acs_link'      => $shortcut[$val['acs_index']]['link'],
                            'acs_link_title'=> $shortcut[$val['acs_index']]['linkTitle'],
                            'acs_index'     => $shortcut[$val['acs_index']]['index'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['acs_id']);
                        unset($shortcut[$val['acs_index']]);
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
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['name']}', '{$val['brief']}', {$tpl_id}, '{$val['imgsrc']}', '{$val['link']}','{$val['linkTitle']}', '{$val['index']}','".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        }else{
            $where   = array();
            $where[] = array('name' => 'acs_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_tpl','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }
    }

    
    private function save_cake_shortcut_new($tpl_id){
        $shortcut = $this->request->getArrParam('navList');
        $shortcut_model = new App_Model_Cake_MysqlCakeShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['ss_weight']])){
                        $set = array(
                            'acs_name'      => $shortcut[$val['acs_index']]['name'],
                            'acs_brief'     => $shortcut[$val['acs_index']]['brief'],
                            'acs_tpl'       => $tpl_id,
                            'acs_imgsrc'    => $shortcut[$val['acs_index']]['imgsrc'],
                            'acs_link'      => $shortcut[$val['acs_index']]['link'],
                            'acs_link_title'=> $shortcut[$val['acs_index']]['linkTitle'],
                            'acs_index'     => $shortcut[$val['acs_index']]['index'],
                            'acs_link_type' => $shortcut[$val['acs_index']]['type'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['acs_id']);
                        unset($shortcut[$val['acs_index']]);
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
                    $insert[] =  " (NULL, '{$this->curr_sid}', '{$val['name']}', '{$val['brief']}', {$tpl_id}, '{$val['imgsrc']}', '{$val['link']}','{$val['linkTitle']}','{$val['type']}', '{$val['index']}','".time()."') ";
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
                            'atn_img'               => $noticeInfo[$val['atn_weight']]['imgsrc'],
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
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','{$val['imgsrc']}','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','".time()."') ";
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

    
    private function _save_train_notice_new(){
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
                            'atn_img'               => $noticeInfo[$val['atn_weight']]['imgsrc'],
                            'atn_article_id'        => $noticeInfo[$val['atn_weight']]['articleId'],
                            'atn_article_title'     => $noticeInfo[$val['atn_weight']]['articleTitle'],
                            'atn_type'              => $noticeInfo[$val['atn_weight']]['type'],
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
                    $insert[] =  " (NULL, '{$this->curr_sid}','{$val['title']}','{$val['imgsrc']}','{$val['articleId']}','{$val['articleTitle']}','{$val['index']}','{$val['type']}','".time()."') ";
                }
                $ins_ret = $notice_storage->newInsertBatch($insert);
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

    
    private function _update_tpl($data, $tpl_id){
        $tpl_model = new App_Model_Cake_MysqlCakeIndexStorage($this->curr_sid);
        $tpl_row   = $tpl_model->findUpdateBySid($tpl_id);
        if(!empty($tpl_row)){
            $tpl_ret = $tpl_model->findUpdateBySid($tpl_id,$data);
        }else{
            $tpl['aci_create_time']= time();
            $tpl_ret = $tpl_model->insertValue($data);
        }
        return $tpl_ret;
    }

    
    private function _show_store_list($json=true){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[]    = array('name' => 'os_name','oper' => 'like','value' =>"%{$output['name']}%");
        }

        $store_model    = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $total          = $store_model->getCount($where);
        $pageCfg        = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $sort = array('os_create_time' => 'DESC');
            $list = $store_model->getList($where,$index,$this->count,$sort);
        }
        if($json){
            $this->output['storeList'] = json_encode($list);
        }else{
            $this->output['storeList'] = $list;
        }
    }

    
    public function storeListAction(){
        $this->_show_store_list(false);
        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cake/store-list.tpl');
    }

    
    public function addStoreAction(){
        $id     = $this->request->getIntParam('id');
        $row    = array();

        if($id){
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $row         = $store_model->getRowByIdSid($id,$this->curr_sid);
        }
        $shortcut_model      = new App_Model_City_MysqlCityPostCategoryStorage($this->curr_sid);
        $category            = $shortcut_model->fetchShortcutShowList(1);
        $this->output['category_select'] = $category;
        $this->output['row'] = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '店铺门店管理', 'link' => '/wxapp/cake/storeList'),
            array('title' => '添加门店', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/cake/add-store.tpl");
    }

    
    public function saveStoreAction(){
        $field = array('name','province','city','zone','addr','contact','lng','lat','is_head','open_time','close_time','feature','recommend','logo','cover','detail','category','receive_store');
        $data  = array();
        for($i=0 ; $i < count($field); $i++){
            $data['os_'.$field[$i]] = $this->request->getStrParam($field[$i]);
            if($i >= 1 && $i <= 7){
                $data['os_week_'.$i] = $this->request->getIntParam('week_'.$i);
            }
        }
        $id = $this->request->getIntParam('id');
        $mobile = $this->request->getStrParam('manager_mobile');
        $password = $this->request->getStrParam('manager_password');
        $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $data['os_update_time'] = time();
        if($id){
            if($mobile){
                $exist = $store_model->findRowByManagerMobile($mobile,$id);
                if($exist){
                    $result = array(
                        'ec' => 400,
                        'em' => '管理员手机号已经存在'
                    );
                    $this->displayJson($result,true);
                }else{
                    if(!plum_is_mobile_phone($mobile)){
                    $result = array(
                        'ec' => 400,
                        'em' => '请填写正确的管理员手机号'
                    );
                    $this->displayJson($result,true);
                    }else{
                        $data['os_manager_mobile'] = $mobile;
                    }
                }
            }
            if($password){
                $data['os_manager_password'] = plum_salt_password($password);
            }
            $ret = $store_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            if($mobile){
                $exist = $store_model->findRowByManagerMobile($mobile);
                if($exist){
                    $result = array(
                        'ec' => 400,
                        'em' => '管理员手机号已经存在'
                    );
                    $this->displayJson($result,true);
                }else{
                    if($password){
                        if(!plum_is_mobile_phone($mobile)){
                            $result = array(
                                'ec' => 400,
                                'em' => '请填写正确的管理员手机号'
                            );
                            $this->displayJson($result,true);
                        }else{
                            $data['os_manager_mobile'] = $mobile;
                            $data['os_manager_password'] = plum_salt_password($password);
                        }
                    }else{
                        $result = array(
                            'ec' => 400,
                            'em' => '请填写管理员密码'
                        );
                        $this->displayJson($result,true);
                    }
                }
            }

            $data['os_s_id']        = $this->curr_sid;
            $data['os_create_time'] = time();
            $ret = $store_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("门店【".$data['os_name']."】信息保存成功");
        if($data['os_is_head'] == 1){
            $store_model->clearIsHeader();
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存门店【{$data['os_name']}】");
        }

        $this->showAjaxResult($ret,'保存');
    }


    
    public function delStoreAction(){
        $id     = $this->request->getIntParam('id');
        $set    = array(
            'os_is_deleted' => 1
        );
        $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $data = $store_model->getRowById($id);
        $ret = $store_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("删除门店【{$data['os_name']}】");
        }

        $this->showAjaxResult($ret);
    }

    
    private function goods_category_son_data($isJson=1){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $temp           = array();
        foreach($first as $val){
            if($val['sk_level'] == 1){
                $temp[$val['sk_id']] = array(
                    'id'        => $val['sk_id'],
                    'index'     => $val['sk_weight'],
                    'firstName' => $val['sk_name'],
                    'imgSrc'    => $val['sk_logo'],
                    'createTime'=> date('Y-m-d H:i:s', $val['sk_create_time']),
                    'secondItem'=> array(),
                );
            }elseif($val['sk_fid'] > 0 && $val['sk_level'] == 2){
                $temp[$val['sk_fid']]['secondItem'][] = array(
                    'id'         => $val['sk_id'],
                    'index'      => $val['sk_weight'],
                    'secondName' => $val['sk_name'],
                    'imgSrc'     => $val['sk_logo'],
                    'link'       => ""
                );
            }

        }
        if($isJson){
            $category   = array();
            foreach($temp as $tal){
                $category[] = $tal;
            }
            return $category;
        }else{
            return $temp;
        }
    }

    
    public function goodsAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '#'),
        ));
        $this->_show_goods_list_data();
        $this->_show_category();
        $this->output['choseLink']  = $this->showTableLink('goods');
        $this->displaySmarty('wxapp/cake/goods-list.tpl');
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
                        'href'  => '/wxapp/cake/tradeList?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=nopay'.$extra,
                        'key'   => 'nopay',
                        'label' => '待付款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=pay'.$extra,
                        'key'   => 'pay',
                        'label' => '已付款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=complete'.$extra,
                        'key'   => 'complete',
                        'label' => '已完成'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '已退款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/tradeList?status=close'.$extra,
                        'key'   => 'close',
                        'label' => '已关闭'
                    ),
                );
                break;
            case 'goods' :
                $link = array(
                    array(
                        'href'  => '/wxapp/cake/goods?status=sell'.$extra,
                        'key'   => 'sell',
                        'label' => '出售中'
                    ),
                    array(
                        'href'  => '/wxapp/cake/goods?status=depot'.$extra,
                        'key'   => 'depot',
                        'label' => '已下架'
                    ),
                );
                break;
            case 'settled' :
                $link = array(
                    array(
                        'href'  => '/wxapp/cake/settled?status=all'.$extra,
                        'key'   => 'all',
                        'label' => '全部'
                    ),
                    array(
                        'href'  => '/wxapp/cake/settled?status=doing'.$extra,
                        'key'   => 'doing',
                        'label' => '进行中'
                    ),
                    array(
                        'href'  => '/wxapp/cake/settled?status=refund'.$extra,
                        'key'   => 'refund',
                        'label' => '退款'
                    ),
                    array(
                        'href'  => '/wxapp/cake/settled?status=success'.$extra,
                        'key'   => 'success',
                        'label' => '成功'
                    ),
                );
                break;


        }
        return $link;
    }

    
    private function _show_goods_list_data(){
        $where          = array();
        $where[]        = array('name' => 'g_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]        = array('name' => 'g_type','oper' => 'in','value' => array(1,2));
        $output['name'] = $this->request->getStrParam('name');
        if($output['name']){
            $where[] = array('name' => 'g_name','oper' => 'like','value' =>"%{$output['name']}%");
        }
        $output['cate'] = $this->request->getIntParam('cate');
        if($output['cate']){
            $category_storage = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
            $category = $category_storage->getRowById($output['cate']);
            if($category['sk_level']==1){
                $where[] = array('name' => 'g_kind1','oper' => '=','value' =>$output['cate']);
            }else{
                $where[] = array('name' => 'g_kind2','oper' => '=','value' =>$output['cate']);
            }
        }
        $output['status'] = $this->request->getStrParam('status','sell');
        switch($output['status']){
            case 'sell':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>1);
                break;
            case 'depot':
                $where[] = array('name' => 'g_is_sale','oper' => '=','value' =>2);
                break;
        }

        $page                = $this->request->getIntParam('page');
        $index               = $page * $this->count;
        $goods_model         = new App_Model_Goods_MysqlGoodsStorage();
        $total               = $goods_model->getCount($where);
        $pageCfg             = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        $deduct = array();
        if($index <= $total){
            $sort = array('g_update_time' => 'DESC');
            $list = $goods_model->getList($where,$index,$this->count,$sort);
            $deduct_gids = array();
            foreach($list as $key=>$val){
                $deduct_gids[] = $val['g_id'];
                $param = array(
                    'gid' => $val['g_id']
                );
                if(!$val['g_qrcode']){
                    $list[$key]['g_qrcode']=$this->create_qrcode($val['g_id']);
                }
            }
        }
        if($list){
            $output['now'] = 1;
        }
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    private function create_qrcode($id){
        $good_model = new App_Model_Goods_MysqlGoodsStorage($this->curr_sid);
        $client_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $str = "id=".$id;
        $url = $client_plugin->fetchWxappShareCode($str, $client_plugin::GOODS_DETAIL_CODE_PATH, 210);
        $updata = array('g_qrcode'=>$url);
        $good_model->updateById($updata,$id);
        return $url;
    }

    
    private function _show_category(){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        $kindSelect       = array();
        foreach($first as $val){
            $category[$val['sk_id']] = $val['sk_name'];
            $kindSelect[] = array(
                'id'   => $val['sk_id'],
                'fid'  => $val['sk_fid'],
                'name' => $val['sk_name'],
                'level'=> $val['sk_level']
            );
        }
        $this->output['category']   =$category ;
        $this->output['kindSelect']   = json_encode($kindSelect) ;
        $this->output['kindSelectArr'] = $kindSelect ;
    }

    
    private function _show_category_goods(){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $category       = array();
        foreach($first as $val){
            $category[$val['sk_id']] = array(
                'id'   => $val['sk_id'],
                'name' => $val['sk_name'],
                'goods'=> $this->_get_category_goods($val['sk_id'])
            );
        }
        $this->output['categoryGoods']   =$category ;
    }

    
    private function _get_category_goods($id){
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $sort        = array('g_weight' => 'DESC', 'g_update_time' => 'DESC');
        $list        = $goods_model->fetchShopGoodsList($this->curr_sid, 0, 4, null, 0, $sort,array(),$id);
        $info        = array();
        if($list){
            foreach ($list as $val){
                $info[] = $this->_format_goods_details($val);
            }
        }
        return $info;
    }

    
    public function addGoodAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$format = array();
        $formatNum = 0;
        $giftNum   = 0;
        $sort      = array();
        if($id){
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $row = $goods_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
                $slide          = $slide_model->getSlideByGid($row['g_id']);
                $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
                $format         = $format_model->getListByGid($row['g_id']);
                if($format){
                    $formatNum = count($format) - 1;
                    for($i=0 ; $i <= $formatNum ; $i ++){
                        $sort[] = 'format_id_'.$i;
                    }
                }
                foreach ($format as $key => $value) {
                    $format[$key]['gf_cake_gift'] = json_decode($value['gf_cake_gift']);
                }
            }
        }
        $template_storage = new App_Model_Shop_MysqlShopDeliveryTemplateStorage();
        $sort = array('sdt_update_time' => 'DESC');
        $where = array();
        $where[] = array('name' => 'sdt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sdt_deleted', 'oper' => '=', 'value' => 0);
        $tempList = $template_storage->getList($where, 0, 0, $sort);
        $this->output['tempList'] = $tempList;
        $this->_show_category();
        if($row['g_cake_gift']){
            $row['g_cake_gift']  = json_decode($row['g_cake_gift']);
        }
        $this->output['row'] = $row;
        $this->output['slide']      =  $slide;
        $this->output['format']     =  $format;
        $this->output['formatNum']  = $formatNum;
        $this->output['formatSort'] = implode(',',$sort);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '商品管理', 'link' => '/wxapp/cake/goods'),
            array('title' => '添加商品', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/cake/add-goods.tpl");
    }


    
    public function saveGoodAction(){
       $result = array(
            'ec' => 400,
            'em' => '请填写完整商品数据'
        );
        $temp_psf = $this->math_price_stock_format();
        $gift1  = $this->request->getIntParam('g_gift1');
        $gift2  = $this->request->getIntParam('g_gift2');
        $gift3  = $this->request->getIntParam('g_gift3');
        $id       = $this->request->getIntParam('id');
        $intField = array('g_type','g_weight');
        $data     = $this->getIntByField($intField);
        $data['g_name']         = $this->request->getStrParam('g_name');
        $data['g_price']        = $temp_psf['price'];
        $data['g_has_format']   = $temp_psf['format'];
        $data['g_cake_gift']    = json_encode(array($gift1, $gift2, $gift3));

        $data['g_ori_price']    = $this->request->getFloatParam('g_ori_price');
        $data['g_unified_fee']  = $this->request->getFloatParam('g_unified_fee');
        $data['g_goods_weight']  = $this->request->getFloatParam('g_goods_weight');
        $data['g_goods_weight_type']  = $this->request->getIntParam('g_goods_weight_type');

        $data['g_cover']        = $this->request->getStrParam('g_cover');
        $data['g_expfee_type']  = $this->request->getStrParam('g_expfee_type');
        $data['g_unified_tpid']  = $this->request->getStrParam('g_unified_tpid');
        $data['g_brief']        = $this->request->getStrParam('g_brief'); ;
        $data['g_detail']       = $this->request->getStrParam('g_detail');

        $istop                  = $this->request->getStrParam('g_is_top');
        $special                = $this->request->getStrParam('g_special');
        $data['g_is_top']       = ($istop == 'on' || $istop == 1)? 1 : 0;
        $data['g_special']      = ($special == 'on' || $special == 1)? 1 : 0;


        $data['g_kind1']        = $this->request->getIntParam('g_kind1');
        $data['g_kind2']        = $this->request->getIntParam('g_kind2');



        $data['g_s_id']         = $this->curr_sid;
        $data['g_update_time']  = time();
        $format                 = $this->request->getIntParam('format-num');
        $data['g_video_url']    = $this->request->getStrParam('g_video');
        $data['g_stock']        = $this->request->getIntParam('g_stock');
        $data['g_sold']        = $this->request->getIntParam('g_sold');
        $soldShow               = $this->request->getStrParam('g_sold_show');
        $data['g_sold_show']       = ($soldShow == 'on' || $soldShow == 1)? 1 : 0;
        if($data['g_name'] && (($data['g_price'] && $format == 0) || $format > 0)){
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
                $this->batchGoodsFormat($id,$is_add);
                $this->batchSlide($id,$is_add);
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功',
                );
                App_Helper_OperateLog::saveOperateLog("商品【{$data['g_name']}】信息保存成功");
            }else{
                $result['em'] = '保存失败';
            }
        }
        $this->displayJson($result);
    }

    
    public function batchSlide($goId,$is_add=0){
        $slide_model    = new App_Model_Goods_MysqlGoodsSlideStorage($this->curr_sid);
        $maxNum         = $this->request->getStrParam('slide-img-num');
        $slide          = array();
        if($is_add){
            for($i=0; $i<= $maxNum; $i++){
                $temp = $this->request->getStrParam('slide_'.$i);
                $temp = plum_sql_quote($temp);
                if($temp){
                    $slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp}', 0, '".time()."')";
                }
            }
            $slide_model->batchSave($slide);
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
            $old_slide = $slide_model->getListByGidSid($goId,$this->curr_sid);
            foreach($old_slide as $val){
                if(!in_array($val['gs_id'],$sl_id)){
                    $del_id[] = $val['gs_id'];
                }
            }
            if(count($slide) <= count($del_id)){
                for($d=0 ; $d < count($del_id) ; $d++){
                    if(isset($slide[$d]) && $slide[$d]){
                        $slide_model->updateSlide($del_id[$d],$slide[$d]);
                        unset($del_id[$d]);
                    }
                }
                if(!empty($del_id)){
                    $slide_model->deleteSlide($goId,$del_id);
                }
            }else{
                $batch_slide = array();
                for($s=0 ; $s < count($slide) ; $s++){
                    if(isset($del_id[$s]) && $del_id[$s]){
                        $slide_model->updateSlide($del_id[$s],$slide[$s]);
                        unset($slide[$s]);
                    }else{
                        $sTemp = plum_sql_quote($slide[$s]);
                        $batch_slide[] = "(NULL, '{$this->curr_sid}', '{$goId}', '{$sTemp}', 0, '".time()."')";
                    }
                }
                if(!empty($batch_slide)){
                    $slide_model->batchSave($batch_slide);
                }
            }
        }
    }

    
    private function math_price_stock_format(){
        $data   = array(
            'price' => 0,
            'format'=> 0,
        );
        $maxNum = $this->request->getIntParam('format-num');
        for($i=0; $i <= $maxNum; $i++){
            $price  = $this->request->getFloatParam('format_price_'.$i);
            $data['format'] = $data['format'] + 1;
            if($data['price'] == 0) $data['price'] = $price;
        }

        $data['price'] = $this->request->getFloatParam('g_price');

        return $data;
    }

    
    private function batchGoodsFormat($goId,$is_add=0){
        $format_model   = new App_Model_Goods_MysqlFormatStorage($this->curr_sid);
        $maxNum         = $this->request->getIntParam('format-num');
        $go_price       = $this->request->getFloatParam('g_price');
        $formatSort     = $this->request->getStrParam('format-sort');
        $sortArr        = explode(',',$formatSort);
        $format         = array();
        if($is_add){
            for($i=1; $i <= $maxNum; $i++){
                $stock = $this->request->getIntParam('format_stock_'.$i);
                $name       = plum_sql_quote(plum_get_param('format_name_'.$i));
                $tem_price  = $this->request->getFloatParam('format_price_'.$i);
                $gift1      = $this->request->getIntParam('format_gift1_'.$i);
                $gift2      = $this->request->getIntParam('format_gift2_'.$i);
                $gift3      = $this->request->getIntParam('format_gift3_'.$i);
                $weight  = $this->request->getIntParam('format_weight_'.$i);
                $weightType = $this->request->getIntParam('format_weighttype_'.$i);
                $gift       = json_encode(array($gift1, $gift2, $gift3));

                $sort       = array_search('format_id_'.$i,$sortArr);
                $price      = $tem_price ? $tem_price : $go_price ;
                if($name && $price){
                    $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$name}','{$price}','{$weight}','{$weightType}','{$stock}','{$sort}', 0, '".time()."', '{$gift}')";
                }
            }
        }else{
            $gf_id = array();
            for($i=0; $i <= $maxNum; $i++){
                $stock   = $this->request->getIntParam('format_stock_'.$i);
                $name    = plum_sql_quote($this->request->getStrParam('format_name_'.$i));
                $price   = $this->request->getFloatParam('format_price_'.$i);
                $id      = $this->request->getIntParam('format_id_'.$i);
                $weight  = $this->request->getIntParam('format_weight_'.$i);
                $weightType = $this->request->getIntParam('format_weighttype_'.$i);
                $gift1      = $this->request->getIntParam('format_gift1_'.$i);
                $gift2      = $this->request->getIntParam('format_gift2_'.$i);
                $gift3      = $this->request->getIntParam('format_gift3_'.$i);
                $gift       = json_encode(array($gift1, $gift2, $gift3));
                if($name){
                    $sort       = array_search('format_id_'.$i,$sortArr);//gf_sort
                    $temp = array(
                        'gf_name'   => $name,
                        'gf_price'  => $price ? $price : $go_price,
                        'gf_stock'  => $stock,
                        'gf_sort'   => $sort,
                        'gf_format_weight' => $weight,
                        'gf_format_weight_type' => $weightType,
                        'gf_cake_gift' => $gift
                    );
                    if($id == 0){
                        $format[]   = "(NULL, '{$this->curr_sid}', '{$goId}', '{$temp['gf_name']}','{$temp['gf_price']}','{$temp['gf_format_weight']}','{$temp['gf_format_weight_type']}','{$temp['gf_stock']}','{$temp['gf_sort']}', 0, '".time()."', '{$gift}')";
                    }else{
                        $format_model->updateFormat($id,$temp);
                        $gf_id[] = $id;
                    }
                }
            }
            $del_id = array();
            $old_format = $format_model->getListByGid($goId);
            foreach($old_format as $val){
                if(!in_array($val['gf_id'],$gf_id)){
                    $del_id[] = $val['gf_id'];
                }
            }
            if(!empty($del_id)){
                $format_model->deleteFormat($goId,$del_id);
            }
        }
        if(!empty($format)){
            $format_model->batchCakeSaveNew($format);
        }
    }


    
    public function tradeListAction() {
        $this->show_trade_list_data();
        $this->output['print'] = plum_parse_config('type','print');
        $this->output['tradePay'] =  App_Helper_Trade::$trade_pay_type;

        $where[]     = array('name'=>'t_type','oper'=>'=','value'=>App_Helper_Trade::TRADE_APPLET );
        $this->output['todayTradeInfo'] = $this->_show_order_stat($where,true);
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cake/trade-list.tpl');
    }


    
    public function tradeDetailAction() {
        $this->output['tradePay'] = App_Helper_Trade::$trade_pay_type;
        $this->output['tradeType']= App_Helper_Trade::$trade_type;

        $this->show_trade_detail_data();
        $this->buildBreadcrumbs(array(
            array('title' => '订单列表', 'link' => '/wxapp/cake/tradeList'),
            array('title' => '订单详情', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cake/trade-detail.tpl');
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

    
    public function changeSendAction(){
        $result     = array(
            'ec'    => 400,
            'em'    => '修改失败'
        );
        $type = $this->request->getStrParam('type');
        $value = $this->request->getStrParam('value');
        $status = $value == 'on'? 1 : 0;
        $status_note = $status == 1 ? '启用' : '禁用';
        $type_note = '';
        if($type == 'send'){
            $type_note = '商家配送';
            $data['acs_send'] = $status;
        }
        if($type == 'receive'){
            $type_note = '门店自取';
            $data['acs_receive'] = $status;
        }
        if($type == 'express'){
            $type_note = '快递发货';
            $data['acs_express_delivery'] = $status;
        }
        $data['acs_update_time'] = time();
        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $ret = $send_storage->findUpdateBySid($data);
        if($ret){
            $result     = array(
                'ec'    => 200,
                'em'    => ' 修改成功'
            );
            if($status_note && $type_note){
                App_Helper_OperateLog::saveOperateLog($type_note.$status_note."成功");
            }

        }
        $this->displayJson($result);
    }
    
    private function _goods_type_list($isJson=1){
        $category_model = new App_Model_Shop_MysqlKindStorage($this->curr_sid);
        $first          = $category_model->getListBySid();
        $temp           = array();
        foreach($first as $val){
            if($val['sk_level'] == 1){
                $temp[$val['sk_id']] = array(
                    'id'        => $val['sk_id'],
                    'index'     => $val['sk_weight'],
                    'imgSrc'    => $val['sk_logo'] ? $val['sk_logo'] : '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                    'firstName' => $val['sk_name'],
                    'secondItem'=> array(),
                );
            }elseif($val['sk_fid'] > 0 && $val['sk_level'] == 2){
                $temp[$val['sk_fid']]['secondItem'][] = array(
                    'id'         => $val['sk_id'],
                    'index'      => $val['sk_weight'],
                    'secondName' => $val['sk_name'],
                    'imgSrc'     => $val['sk_logo'],
                    'link'       => ""
                );
            }
        }
        if($isJson){
            $category   = array();
            foreach($temp as $tal){
                $category[] = $tal;
            }
            return $category;
        }else{
            return $temp;
        }
    }

    
    public function addStoreDynamicAction(){
        $id  = $this->request->getIntParam('id');
        $row = array(); $slide = array();$goodsList = array();
        if($id){
            $dynamic_storage = new App_Model_Smart_MysqlStoreDynamicStorage($this->curr_sid);
            $row = $dynamic_storage->getRowById($id);
            if(!empty($row)){
                $slide_model    = new App_Model_Smart_MysqlStoreDynamicSlideStorage($this->curr_sid);
                $slide          = $slide_model->getListByDidSid($id);
                $goodsList      = json_decode($row['asd_g_ids'],1);
            }
        }
        $this->output['slide']  = $slide;
        $this->output['row']    = $row;
        $this->output['goodsList'] = is_array($goodsList) ? json_encode($goodsList) :json_encode(array()) ;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->_show_goods_list();
        $this->buildBreadcrumbs(array(
            array('title' => '动态管理', 'link' => '/wxapp/cake/dynamicList'),
            array('title' => '添加/编辑动态', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cake/add-dynamic.tpl');

    }

    
    public function dynamicListAction(){
        $page        = $this->request->getIntParam('page');
        $index       = $page * $this->count;
        $where       = array();
        $where[]     = array('name'=>'asd_s_id','oper'=>'=','value'=>$this->curr_sid);
        $dynamic_storage = new App_Model_Smart_MysqlStoreDynamicStorage($this->curr_sid);
        $total      = $dynamic_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $meeting_list       = array();
        $set=array('asd_create_time'=>'DESC');
        if($index <= $total){
            $meeting_list   = $dynamic_storage->getList($where,$index,$this->count,$set);
        }
        $data = array();
        if($meeting_list){
            foreach ($meeting_list as $key=>$val){
                $data[] = array(
                    'id'        => $val['asd_id'],
                    'startTime' => $val['asd_create_time'],
                    'fabulous'  => $val['asd_fabulous'],
                    'comment'   => $val['asd_comment'],
                    'num'       => $key+1,
                    'push'      => $val['asd_push']
                );
            }
        }
        $smart_model = new App_Model_Cake_MysqlCakeIndexStorage($this->curr_sid);
        $row         = $smart_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']);
        $this->output['row'] = $row;
        $this->output['list']  = $data;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '动态管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/cake/dynamic-list.tpl');
    }

    
    public function storeCfgSaveAction(){
        $smart_model = new App_Model_Cake_MysqlCakeIndexStorage($this->curr_sid);
        $background  = $this->request->getStrParam('background');
        $sign        = $this->request->getStrParam('sign');
        $data=array(
            'aci_dynamic_bg' => $background,
            'aci_dynamic_sign' => $sign,
            'aci_update_time' => time()
        );
        $tpl = $smart_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl']);
        if($tpl){
            $ret = $smart_model->findUpdateBySid($this->wxapp_cfg['ac_index_tpl'],$data);
            if($ret){
                $result = array(
                    'ec' => 200,
                    'em' => '信息保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("保存店铺动态设置成功");
            }else{
                $result = array(
                    'ec' => 400,
                    'em' => '信息保存失败'
                );
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '请先完成首页配置'
            );
        }


        $this->displayJson($result);
    }

    public function saveStoreDynamicAction(){
        $result = array(
            'ec' => 400,
            'em' => '请填写动态信息'
        );
        $id       = $this->request->getIntParam('id');
        $data     = array();
        $data['asd_detail']        = $this->request->getStrParam('content');
        $data['asd_sign1']         = $this->request->getStrParam('sign1');
        $data['asd_sign2']         = $this->request->getStrParam('sign2');
        $data['asd_sign3']         = $this->request->getStrParam('sign3');
        $data['asd_video_url']     = $this->request->getStrParam('videoUrl');
        $data['asd_video_cover']   = $this->request->getStrParam('video_cover');
        $data['asd_g_ids'] = $this->request->getStrParam('goodsList','');

        $dynamic_storage = new App_Model_Smart_MysqlStoreDynamicStorage($this->curr_sid);
        $is_add = 0;
        if($id){
            $data['asd_update_time']    = $_SERVER['REQUEST_TIME'];
            $ret = $dynamic_storage->UpdateById($data,$id);
        }else{
            $data['asd_s_id']           = $this->curr_sid;
            $data['asd_create_time']    = $_SERVER['REQUEST_TIME'];
            $ret = $dynamic_storage->insertValue($data);
            $id  = $ret;
            $is_add = 1;
        }
        if($ret){
            $this->batchSlide($id,$is_add);
            $result = array(
                'ec' => 200,
                'em' => '保存成功',
            );
            App_Helper_OperateLog::saveOperateLog("保存店铺动态信息成功");
        }else{
            $result['em'] = '保存失败';
        }
        $this->displayJson($result);
    }
}
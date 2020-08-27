<?php


class App_Controller_Wxapp_MembercardController extends App_Controller_Wxapp_InitController
{

    public function __construct(){
        parent::__construct();
    }

    private function table_link_show($key){
        $data = array(
            'memberCard' => array(
                'name' => '计次卡会员',
                'link' => '/wxapp/membercard/memberCard',
                'icon' => 'user'
            ),
            'cardOrder' => array(
                'name' => '计次卡购买记录',
                'link' => '/wxapp/membercard/cardOrder',
                'icon' => 'align-justify'
            ),
            'storeCfg' => array(
                'name' => '计次卡设置',
                'link' => '/wxapp/membercard/storeCfg',
                'icon' => 'cog'
            ),
            'verify' => array(
                'name' => '核销门店',
                'link' => '/wxapp/membercard/index',
                'icon' => 'barcode'
            ),
        );
        $this->output['tabKey']  = $key;
        $this->output['tabLink'] = $data;
    }

    private function table_discount_link_show($key){
        $data = array(
            'card' => array(
                'name' => '会员卡种类',
                'link' => '/wxapp/membercard/discountCard',
                'icon' => 'credit-card'
            ),
            'memberCard' => array(
                'name' => '会员卡会员',
                'link' => '/wxapp/membercard/disMemberCard/type/2',
                'icon' => 'user'
            ),
            'cardOrder' => array(
                'name' => '会员卡购买记录',
                'link' => '/wxapp/membercard/disCardOrder/type/2',
                'icon' => 'align-justify'
            ),
        );
        $this->output['tabKey']  = $key;
        $this->output['tabLink'] = $data;
    }

    
    public function indexAction($plugin = 0,$pluginLinkType = ''){
        $cfg_model = new App_Model_Store_MysqlStoreCfgStorage($this->curr_sid);
        $cfg = $cfg_model->fetchUpdateCfg();
        if(!$cfg){
            $this->_open_store_member();
        }
        $this->output['cfg']  = $cfg_model->fetchUpdateCfg();
        $this->output['link'] = $this->composeLink('offline','index',array(),true,'info');

        $bread = [
            array('title' => '门店管理', 'link' => '#'),
            array('title' => '门店列表', 'link' => '#'),
        ];
        $this->output['plugin'] = $plugin;
        if($plugin == 1){
            $plugin_cfg = plum_parse_config('plugin_cfg','cashier');
            $this->output['link']       = $plugin_cfg['link'];
            $this->output['linkType']   = $pluginLinkType;
            $this->output['snTitle']    = $plugin_cfg['snTitle'];
            $bread = $plugin_cfg['breadcrumbs'][$pluginLinkType];
        }
        $this->buildBreadcrumbs($bread);

        $this->_show_list_data();
        $table_menu = new App_Helper_TableMenu();
        $this->output['choseLink']  = $table_menu->showTableLink('store');
        $this->output['appletCfg'] = $this->wxapp_cfg;
        if($this->curr_shop['s_id'] == '5655' || in_array($this->curr_shop['s_broker_type'],[2,3]) || $plugin == 1){
            $this->output['face']   = true;
        }
        $this->displaySmarty("wxapp/memberCard/store-list.tpl");
    }

    
    private function _open_store_member(){
        $cfg_storage    = new App_Model_Store_MysqlStoreCfgStorage($this->curr_sid);
        $indata = array(
            'oc_s_id'           => $this->curr_sid,
            'oc_open_time'      => time(),
            'oc_expire_time'    => $this->wxapp_cfg['ac_expire_time'],
            'oc_create_time'    => time(),
        );
        $cfg_storage->insertValue($indata);
    }


    private function _show_list_data(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'os_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'os_es_id','oper' => '=','value' =>0);
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
        $output['list'] = $list;
        $this->showOutput($output);
    }

    
    public function storeCfgAction(){
        $this->table_link_show('storeCfg');
        $cfg_model = new App_Model_Store_MysqlStoreCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->fetchUpdateCfg();
        $this->_get_card_list();
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->output['cfg'] = $cfg;
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '门店会员卡', 'link' => '/wxapp/membercard/index'),
            array('title' => '门店设置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/memberCard/store-cfg.tpl");
    }

    
    public function openStoreAction(){
        $data = array(
            'oc_use_day'     => $this->request->getIntParam('day'),
            'oc_use_num'     => $this->request->getIntParam('times'),
            'oc_update_time' => $_SERVER['REQUEST_TIME']
        );
        $type = $this->request->getIntParam('verify');
        if(in_array($type,array(1,2))){
            $data['oc_verify_type'] = $type;
        }
        $bg = $this->request->getStrParam('bg');
        if($bg){
            $data['oc_bg'] = $bg;
        }

        $cfg_model = new App_Model_Store_MysqlStoreCfgStorage($this->curr_sid);
        $cfg       = $cfg_model->fetchUpdateCfg();
        if(empty($cfg)){
            $data['oc_s_id']        = $this->curr_sid;
            $data['oc_create_time'] = time();
            $ret = $cfg_model->insertValue($data);
        }else{
            $ret = $cfg_model->fetchUpdateCfg($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("计次卡配置保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    
    private function _get_card_list(){
        $cardtype   = $this->request->getIntParam('type', 1);
        if($cardtype == 1){
        }else{
            $this->table_discount_link_show('card');
        }
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'oc_type','oper' => '=','value' =>$cardtype);
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $total      = $card_model->getCount($where);
        $list       = array();
        if($index <= $total){
            $sort   = array('oc_long_type' => 'ASC','oc_update_time' => 'DESC');
            $list   = $card_model->getList($where,$index,$this->count,$sort);
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $output['cardtype'] = $cardtype;
        $output['type']     = plum_parse_config('offline_card_new','app');
        $output['color']    = plum_parse_config('offline_color','app');
        $this->showOutput($output);
    }

    
    public function cardAction(){
        $cardtype   = $this->request->getIntParam('type', 1);
        if($cardtype == 1){
            $this->table_link_show('card');
        }else{
            $this->table_discount_link_show('card');
        }
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'oc_type','oper' => '=','value' =>$cardtype);
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $total      = $card_model->getCount($where);
        $list       = array();
        if($index <= $total){
            $sort   = array('oc_long_type' => 'ASC','oc_update_time' => 'DESC');
            $list   = $card_model->getList($where,$index,$this->count,$sort);
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $output['cardtype'] = $cardtype;
        $output['type']     = plum_parse_config('offline_card','app');
        $output['color']    = plum_parse_config('offline_color','app');
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '门店会员卡', 'link' => '/wxapp/membercard/index'),
            array('title' => '会员卡管理', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/memberCard/card.tpl");
    }

    
    public function discountCardAction(){
        $cardtype   = $this->request->getIntParam('type', 2);
        if($cardtype == 1){
            $this->table_link_show('card');
        }else{
            $this->table_discount_link_show('card');
        }
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $where      = array();
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->curr_sid);
        $where[]    = array('name' => 'oc_type','oper' => '=','value' =>$cardtype);
        $where[]    = array('name' => 'oc_deleted','oper' => '=','value' =>0);
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $total      = $card_model->getCount($where);
        $list       = array();
        if($index <= $total){
            $sort   = array('oc_long_type' => 'ASC','oc_update_time' => 'DESC');
            $list   = $card_model->getListLevel($where,$index,$this->count,$sort);
        }
        $page_libs  = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $output['cardtype'] = $cardtype;
        $output['type']     = plum_parse_config('discount_card','app');
        $output['color']    = plum_parse_config('discount_card','app');
        $this->showOutput($output);

        if($this->wxapp_cfg['ac_type'] == 16){
            $this->buildBreadcrumbs(array(
                array('title' => '会员营销', 'link' => '#'),
                array('title' => '会员卡管理', 'link' => '#'),
            ));
        }else{
            $this->buildBreadcrumbs(array(
                array('title' => '模块管理', 'link' => '#'),
                array('title' => '门店会员卡', 'link' => '/wxapp/membercard/index'),
                array('title' => '会员卡管理', 'link' => '#'),
            ));
        }


        $this->displaySmarty("wxapp/memberCard/card.tpl");
    }

    public function addCardAction(){
        $id     = $this->request->getIntParam('id');
        $cardtype   = $this->request->getIntParam('type', 1);
        $row    = plum_parse_config('store_card','value');

        if($this->wxapp_cfg['ac_type'] == 16){
            $this->buildBreadcrumbs(array(
                array('title' => '会员营销', 'link' => '#'),
                array('title' => '会员卡', 'link' => '/membercard/discountCard'),
                array('title' => '添加会员卡', 'link' => '#'),
            ));
            $row['oc_name'] = '房源发布月卡';
        }else{
            if($cardtype == 1){
                $url = '/wxapp/membercard/card';
                $title = '门店会员卡';
            }else{
                $url = '/wxapp/membercard/discountCard';
                $title = '会员卡';
            }
            
            $this->buildBreadcrumbs(array(
                array('title' => $title, 'link' => $url),
                array('title' => '添加'.$title, 'link' => '#'),
            ));
        }

        if($id){
            $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
            $row        = $card_model->getRowById($id);

            $row['oc_rights']      = plum_textarea_html_to_line($row['oc_rights']);
            $row['oc_notice']      = plum_textarea_html_to_line($row['oc_notice']);
        }
        $three_cfg  = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $tc         = $three_cfg->findShopCfg();
        $row['tc_level']     = $tc['tc_level'];
        $type    = plum_parse_config('offline_card_new','app');
        $color   = plum_parse_config('offline_color','app');
        $row['type']         = $type[$row['oc_long_type']]['name'];
        $row['color']        = $color[$row['oc_bg_type']]['color'];
        $this->output['row']    = $row;
        $this->output['type']   = $type;
        $this->output['color']  = $color;
        $this->output['name']   = $this->shops[$this->curr_sid]['s_name'];
        $this->output['cardtype']   = $cardtype;
        $level_model = new App_Model_Member_MysqlLevelStorage();
        $list = $level_model->getListBySid($this->curr_sid);
        $list[0] = array(
            'ml_id' => 0,
            'ml_name' => '请选择'
        );
        $this->output['levelList'] = $list?json_encode($list):json_encode(array());
        $this->output['appletCfg'] = $this->wxapp_cfg;

        $showMemberDay = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[21,32])){
            $showMemberDay = 1;
        }
        $this->output['showMemberDay'] = $showMemberDay;

        if($cardtype == 1){
            $this->displaySmarty("wxapp/memberCard/add-card.tpl");
        }else{
            $type = plum_parse_config('discount_card','app');
            $this->output['type']   = $type;
            $this->displaySmarty("wxapp/memberCard/add-card-new.tpl");
        }
    }

    
    public function saveCardAction(){
        $cardtype   = $this->request->getIntParam('type', 1);
        $strField   = array('name','identity','name_sub','rights','notice','background_color','member_day');
        $strData    = $this->getStrByField($strField,'oc_');
        $intField   = array('bg_type','long_type','times', 'add_open_num', 'weight','hidden');
        $intData    = $this->getIntByField($intField,'oc_');
        $floatField = array('price','0f_deduct','1f_deduct','2f_deduct','3f_deduct', 'return_price','member_day_discount');
        $floatData  = $this->getFloatByField($floatField,'oc_');

        if($floatData['oc_member_day_discount'] < 0 || $floatData['oc_member_day_discount'] >= 10){
            $this->displayJsonError('请填写正确的会员日折扣');
        }

        $data       = array_merge($strData,$intData,$floatData);
        if($cardtype == 1){
            $type       = plum_parse_config('offline_card_new','app');
        }else{
            $type       = plum_parse_config('discount_card','app');
        }
        $data['oc_long']= $type[$data['oc_long_type']]['long'];
        $data['oc_update_time'] = $_SERVER['REQUEST_TIME'];
        $data['oc_rights']      = plum_textarea_line_to_html($data['oc_rights']);
        $data['oc_notice']      = plum_textarea_line_to_html($data['oc_notice']);
        $data['oc_type']        = $cardtype;

        $id         = $this->request->getIntParam('id');
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);

        if($id){
            $ret    = $card_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            $data['oc_s_id']        = $this->curr_sid;
            $data['oc_create_time'] = $_SERVER['REQUEST_TIME'];
            $ret    = $card_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("会员卡【".$data['oc_name']."】保存成功");
        $this->showAjaxResult($ret,'保存');
    }

    
    public function delCardAction(){
        $id     = $this->request->getIntParam('id');
        $set    = array(
            'oc_deleted' => 1
        );
        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $card = $card_model->getRowById($id);
        $ret        = $card_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        App_Helper_OperateLog::saveOperateLog("会员卡【".$card['oc_name']."】保存成功");
        $this->showAjaxResult($ret,'删除');
    }

    public function disMemberCardAction(){
        $this->memberCardAction(2);
    }

    public function memberCardAction($card_type = ''){

        $cardtype   = $card_type ? $card_type : $this->request->getIntParam('type', 1);
        if($cardtype == 1){
            $this->table_link_show('memberCard');
        }else{
            $this->table_discount_link_show('memberCard');
        }

        $this->show_member_card_list($cardtype);
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '门店会员卡', 'link' => '/wxapp/membercard/index'),
            array('title' => '门店会员', 'link' => '#'),
        ));
        $this->output['cardtype'] = $cardtype;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->displaySmarty("wxapp/memberCard/store-member.tpl");
    }

    private function show_member_card_list($type){
        $page    = $this->request->getIntParam('page');
        $index   = $page * $this->count;
        $sort    = array('om_create_time' => 'DESC');
        $where   = array();
        $where[] = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'om_type', 'oper' => '=', 'value' => $type);
        $output['card'] = $this->request->getStrParam('card');//门店会员卡
        if($output['card']){
            $where[] = array('name' => 'om_card_num', 'oper' => '=', 'value' => $output['card']);
        }

        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            if($type == 2 || $this->curr_sid == 10380){
                $where[] = " ( m_mobile = {$output['mobile']} or oo_telphone = {$output['mobile']} )";
            }else{
                $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $output['mobile']);
            }

        }
        $member_model= new App_Model_Store_MysqlMemberStorage($this->curr_sid);
        $total       = $member_model->getMemberCardCount($where,$type);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $list        = array();
        if($total > $index){
            $list    = $member_model->getMemberCardList($where,$index,$this->count,$sort,'',$type);
            
        }
        $output['pageHtml']  = $page_plugin->render();
        $output['list']      = $list;
        $where_total = $where_noexpire = $where_used = [];
        $where_total[] = $where_noexpire[] = $where_used[] = ['name' => 'om_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_noexpire[] = $where_used[] = ['name' => 'om_type', 'oper' => '=', 'value' => $type];
        $where_total[] = $where_noexpire[] = $where_used[] = ['name' => 'om_deleted', 'oper' => '=', 'value' => 0];
        $where_noexpire[] = ['name' => 'om_expire_time', 'oper' => '>', 'value' => time()];
        $total_count = $member_model->getMemberCardCount($where_total,$type);
        $noexpire_count = $member_model->getMemberCardCount($where_noexpire,$type);
        $expire_count = intval($total_count) - intval($noexpire_count);

        $statInfo = [
            'total' => intval($total_count),
            'noexpire' => intval($noexpire_count),
            'expire' => $expire_count < 0 ? 0 : $expire_count
        ];
        if($type != 2){
            $where_used[] = ['name' => 'om_left_num', 'oper' => '=', 'value' => 0];
            $used_count = $member_model->getMemberCardCount($where_used,$type);
            $left_count = $statInfo['total'] - intval($used_count);
            $statInfo['used'] = intval($used_count);
            $statInfo['left'] = $left_count < 0 ? 0 : $left_count;
        }


        $output['statInfo'] = $statInfo;
        $this->showOutput($output);
    }
    public function disCardOrderAction(){
        $this->cardOrderAction(2);
    }
    public function cardOrderAction($card_type = ''){
        $cardtype   = $card_type ? $card_type : $this->request->getIntParam('type', 1);
        if($cardtype == 1){
            $this->table_link_show('cardOrder');
        }else{
            $this->table_discount_link_show('cardOrder');
        }

        $this->show_card_order_list($cardtype);
        if($this->wxapp_cfg['ac_type'] == 6){
            $store_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
            $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->curr_sid);
            $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);//未删除
            $this->output['storeList'] = $store_model->getList($where,0,0,array(),array(),true);

            $old_store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['storeListOld'] = $old_store_model->getAllListBySid();

        }else{
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $this->output['storeList'] = $store_model->getAllListBySid();
        }

        $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
        $this->output['cardList'] = $card_model->getShopAllCard();

        $output['type']     = plum_parse_config('offline_card_new','app');
        $output['color']    = plum_parse_config('offline_color','app');
        $output['cardtype'] = $cardtype;
        $this->showOutput($output);
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '门店会员卡', 'link' => '/wxapp/membercard/index'),
            array('title' => '会员卡购买记录', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/memberCard/card-order.tpl");
    }

    public function show_card_order_list($type){
        $page    = $this->request->getIntParam('page');
        $index   = $page * $this->count;
        $sort    = array('oo_create_time' => 'DESC');
        $where   = array();
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'oo_card_type', 'oper' => '=', 'value' => $type);
        $output['tid'] = $this->request->getStrParam('tid');
        if($output['tid']){
            $where[] = array('name' => 'oo_outer_tid', 'oper' => '=', 'value' => $output['tid']);
        }
        $output['store'] = $this->request->getIntParam('store');
        if($output['store']){
            $where[] = array('name' => 'oo_st_id', 'oper' => '=', 'value' => $output['store']);
        }
        $output['card'] = $this->request->getIntParam('card');//门店会员卡
        if($output['card']){
            $where[] = array('name' => 'oo_cardid', 'oper' => '=', 'value' => $output['card']);
        }
        $output['status'] = $this->request->getIntParam('status');
        if($output['status']){
            $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => $output['status']-1);
        }
        $output['nickname'] = $this->request->getStrParam('nickname');
        if($output['nickname']){
            $where[] = array('name' => 'm_nickname', 'oper' => 'like', 'value' => "%{$output['nickname']}%");
        }
        $output['mobile'] = $this->request->getStrParam('mobile');
        if($output['mobile']){
            $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $output['mobile']);
        }
        $order_model = new App_Model_Store_MysqlOrderStorage($this->curr_sid);
        $total       = $order_model->getMemberCardCount($where);
        $page_libs   = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list        = array();
        if($total > $index){
            if($this->curr_sid == 8589 && $this->wxapp_cfg['ac_type'] == 28){
                $list    = $order_model->getMemberCardJobCompanyList($where,$index,$this->count,$sort);
            }else{
                $list    = $order_model->getMemberCardList($where,$index,$this->count,$sort);
            }

        }
        $where_total = $where_wx = $where_coin = [];
        $where_total[] = $where_wx[] = $where_coin[] = ['name' => 'oo_s_id', 'oper' => '=', 'value' => $this->curr_sid];
        $where_total[] = $where_wx[] = $where_coin[] = ['name' => 'oo_card_type', 'oper' => '=', 'value' => $type];
        $where_wx[]= ['name' => 'oo_pay_type', 'oper' => '=', 'value' => 1];
        $where_coin[]= ['name' => 'oo_pay_type', 'oper' => '=', 'value' => 2];
        $totalInfo = $order_model->getTotalAction($where_total);
        $wxInfo = $order_model->getTotalAction($where_wx);
        $coinInfo = $order_model->getTotalAction($where_coin);
        $memberCount = $order_model->getTotalMember($where_total);
        $statInfo = [
            'totalMoney' =>floatval($totalInfo['money']),
            'totalCount' => intval($totalInfo['total']),
            'coinMoney'  => floatval($coinInfo['money']),
            'wxMoney'    => floatval($wxInfo['money']),
            'memberCount'=> intval($memberCount),
        ];
        $output['statInfo'] = $statInfo;



        $output['pageHtml'] = $page_libs->render();
        $output['list']     = $list;
        $output['payType']  = App_Helper_Trade::$trade_pay_type;
        $this->showOutput($output);
    }

    
    public function vcaimaoCardCfgAction(){
        $vcmData = array();
        $cfgData = array();
        $vcmOpen = true;
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->curr_sid);
        $cfg = $vcm_model->findUpdateBySid();
        $result = App_Plugin_Vcaimao_PayClient::getPaySecret($this->wxapp_cfg['ac_appid']);
        Libs_Log_Logger::outputLog($result);
        if($cfg && $cfg['vw_device_id'] && $cfg['vw_pay_secret'] && $result['data']['deviceid']==$cfg['vw_device_id'] && $result['data']['paysecret']==$cfg['vw_pay_secret']){
            $cfgData = $cfg;
        }else{

            if($result && !$result['errcode']){
                $open_client    = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
                $wxxcxResult         = $open_client->getOpenAppid($this->wxapp_cfg['ac_appid']);
                Libs_Log_Logger::outputLog($wxxcxResult);
                $vam_client = new App_Plugin_Vcaimao_PayClient($this->curr_sid);
                $openResult = $vam_client->getOpenAppid($result['data']['deviceid'],$result['data']['paysecret']);
                Libs_Log_Logger::outputLog($openResult);
                if($openResult && !$openResult['errcode'] && $openResult['data']['open_appid']){
                    if($wxxcxResult && !$wxxcxResult['errcode'] && $wxxcxResult['open_appid']){
                        if($openResult['data']['open_appid']!= $wxxcxResult['open_appid']){
                            $unbind_result = $open_client->unbindOpenAppid($this->wxapp_cfg['ac_appid'],$wxxcxResult['open_appid']);
                            Libs_Log_Logger::outputLog($unbind_result);
                            $open_result = $open_client->bindOpenAppid($this->wxapp_cfg['ac_appid'],$openResult['data']['open_appid']);
                            Libs_Log_Logger::outputLog($open_result);
                        }
                    }else{
                        $open_result = $open_client->bindOpenAppid($this->wxapp_cfg['ac_appid'],$openResult['data']['open_appid']);
                        Libs_Log_Logger::outputLog($open_result);
                    }
                }else{
                    $result['data'] = array();
                }
                $vcmData = $result['data'];
            }
        }
        $this->output['vcmData'] = $vcmData;
        $this->output['vcmCfg'] = $cfgData;
        $this->buildBreadcrumbs(array(
            array('title' => '模块管理', 'link' => '#'),
            array('title' => '会员卡', 'link' => '/wxapp/membercard/index'),
            array('title' => '微财猫会员卡', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/memberCard/vcm-card.tpl");

    }

    
    public function saveVcaimaoCfgAction(){
        $deviceId  = $this->request->getStrParam('deviceId');
        $paySecret = $this->request->getStrParam('paySecret');
        $isopen = $this->request->getStrParam('isopen');
        if($deviceId && $paySecret){
            $data = array(
                'vw_sid'        => $this->curr_sid,
                'vw_device_id'  => $deviceId,
                'vw_pay_secret' => $paySecret,
                'vw_isopen'     => $isopen == 'on' ? 1 : 0,
                'vw_update_time'=> time(),
            );
            $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->curr_sid);
            $cfg = $vcm_model->findUpdateBySid();
            if($cfg){
                $ret = $vcm_model->findUpdateBySid($data);
            }else{
                $data['vw_create_time'] = time();
                $ret = $vcm_model->insertValue($data);
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("微财猫会员卡保存成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请将数据填写完整');
        }
    }

    public function changeVcaimaoCfgAction(){
        $isopen = $this->request->getStrParam('isopen');
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->curr_sid);
        $cfg = $vcm_model->findUpdateBySid();
        if($cfg){
            $data = array(
                'vw_isopen'     => $isopen == 'on' ? 1 : 0,
                'vw_update_time'=> time(),
            );
            $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->curr_sid);
            $cfg = $vcm_model->findUpdateBySid();
            if($cfg){
                $ret = $vcm_model->findUpdateBySid($data);
            }else{
                $data['vw_create_time'] = time();
                $ret = $vcm_model->insertValue($data);
            }
            if($ret){
                App_Helper_OperateLog::saveOperateLog("保存成功");
            }
            $this->showAjaxResult($ret);
        }
    }

    public function changeCardInfoAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $id = $this->request->getIntParam('id');
        $field = $this->request->getStrParam('field');
        $value = $this->request->getIntParam('value');
        if($id && $field){
            $card_field = 'oc_'.$field;
            $set = array(
                $card_field => $value
            );
            $card_model = new App_Model_Store_MysqlCardStorage($this->curr_sid);
            $res = $card_model->updateById($set, $id);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("会员卡信息修改成功");
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => '操作异常'
            );
        }
        $this->displayJson($result);
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


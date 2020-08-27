<?php

class App_Controller_Wxapp_CustomerController extends App_Controller_Wxapp_OrderCommonController{

    const PROMOTION_TOOL_KEY = 'kf';
    
    public function __construct(){
        parent::__construct();
    }


    
    public function indexAction(){
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;

        $where = [];
        $where[] = array('name' => 'kur_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $this->output['start']   = $this->request->getStrParam('start');
        if($this->output['start']){
            $where[]    = array('name' => 'kur_create_time', 'oper' => '>=', 'value' => strtotime($this->output['start']));
        }
        $this->output['end']     = $this->request->getStrParam('end');
        if($this->output['end']){
            $where[]    = array('name' => 'kur_create_time', 'oper' => '<=', 'value' => (strtotime($this->output['end']) + 86400));
        }
        $sort = array('kur_update_time' => 'DESC');
        $record_model = new App_Model_Member_MysqlKefuUseStorage($this->curr_sid);
        $total = $record_model->getRecordCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['page_html'] = $page_lib->render();
        $list = $record_model->getRecordList($where,$index,$this->count,$sort);
        $this->output['list'] = $list;

        $this->buildBreadcrumbs(array(
            array('title' => '客服管理', 'link' => '#'),
            array('title' => '客服记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/customer/record-list.tpl');
    }

    
    public function kefuMobileOpenAction(){
        $value   = $this->request->getStrParam('value','');
        $open = $value == 'on' ? 1 : 0;
        $wxapp_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
        $res = $wxapp_model->updateById(array('ac_kefu_mobile' => $open), $this->wxapp_cfg['ac_id']);

        if($res){
            $str = $open == 1 ? '使用客服需授权手机号' : '使用客服无需授权手机号';
            App_Helper_OperateLog::saveOperateLog($str);
        }

        $this->displayJsonSuccess();
    }

    
    public function chatListAction(){
        $count = 20;
        $page = $this->request->getIntParam('page');
        $index = $page*$count;
        $openid = $this->request->getStrParam('openid');

        $where = [];
        $where[] = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'sc_openid', 'oper' => '=', 'value' => $openid);
        $sort = array('sc_create_time' => 'DESC');

        $chat_model = new App_Model_Wechat_MysqlChatMsgStorage($this->curr_sid);
        $total = $chat_model->getCount($where);
        $page_lib    = new Libs_Pagination_Paginator($total,$count,'jquery',true);
        $this->output['page_html'] = $page_lib->render();

        $list = $chat_model->getChatList($where,$index,$count,$sort);
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '客服管理', 'link' => '#'),
            array('title' => '客服记录', 'link' => '/wxapp/customer/index'),
            array('title' => '聊天记录', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/customer/chat-list.tpl');
    }




}


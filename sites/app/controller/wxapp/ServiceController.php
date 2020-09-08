<?php


class App_Controller_Wxapp_ServiceController extends App_Controller_Wxapp_InitController{

    const PROMOTION_TOOL_KEY = 'autoreply';

    public function __construct() {
        parent::__construct();
    }

    //企业服务列表
    public function serviceListAction(){
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
    }






    
    public function msgListAction(){
        $page   = $this->request->getIntParam('page');
        $index  = $page * $this->count;
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        $where = array();
        $where[]    = array('name' => 'asm_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'asm_deleted', 'oper' => '=', 'value' => 0);
        $total      = $msg_model->getCount($where);
        $list       = array();
        if($total > $index){
            $sort = array('asm_create_time' => 'desc');
            $list = $msg_model->getList($where, $index, $this->count, $sort);
        }
        $this->output['typeNote'] = array(
            'text'  => '文本消息',
            'image' => '图片消息',
            'link'  => '图文链接',
            'miniprogrampage' => '小程序卡片',
        );
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();
        $this->output['list']       = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '自动回复列表', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/msg-tpl.tpl');
    }

    
    public function msgSettingAction(){
        $id = $this->request->getIntParam('id');
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        $msg = $msg_model->getRowById($id);
        $this->output['msg'] = $msg;
        $this->output['appletCfg'] = $this->wxapp_cfg;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '自动回复列表', 'link' => '/wxapp/service/msgList'),
            array('title' => '自动回复配置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/msg-setting.tpl');
    }

    
    public function saveMessageAction(){
        $id                  = $this->request->getIntParam('id');
        $data['asm_type']    = $this->request->getStrParam('msgType');
        $data['asm_keyword'] = $this->request->getStrParam('msgKeyword');
        $data['asm_content'] = $this->request->getStrParam('msgContent');
        $data['asm_title']   = $this->request->getStrParam('msgTitle');
        $data['asm_desc']    = $this->request->getStrParam('msgDesc');
        $data['asm_path']    = $this->request->getStrParam('msgPath');
        $data['asm_url']     = $this->request->getStrParam('msgUrl');
        $data['asm_cover']   = $this->request->getStrParam('msgCover');

        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        if($id){
            $data['asm_update_time'] = time();
            $ret = $msg_model->updateById($data, $id);
        }else{
            $data['asm_update_time'] = time();
            $data['asm_create_time'] = time();
            $data['asm_s_id'] = $this->curr_sid;
            $ret = $msg_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自动回复配置保存成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function delMessageAction(){
        $id  = $this->request->getIntParam('id');
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->curr_sid);
        $ret = 0;
        if($id){
            $data['asm_deleted'] = 1;
            $ret = $msg_model->updateById($data, $id);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自动回复配置删除成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function saveAutoReplyTipsAction(){
        $tips  = $this->request->getStrParam('tips');
        $open  = $this->request->getStrParam('open');

        $set = array('s_auto_reply_tips' => $tips, 's_auto_reply_tips_open' => ($open=='on'?1:0));
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $ret = $shop_model->updateById($set, $this->curr_sid);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自动回复提示配置保存成功");
        }

        $this->showAjaxResult($ret);
    }
}
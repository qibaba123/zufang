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
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $list  = $service_model->getList(array(),$index,$this->count,array('es_weight'=>'DESC'));
        $this->output['list'] = $list;
        $this->output['image'] = $this->curr_shop['s_service_image'];
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '企业服务', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/service-list.tpl');
    }

    //保存顶部图片
    public function saveServiceImageAction(){
        $data['s_servicr_image'] = $this->request->getStrParam('image');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->curr_sid);
        $ret = $shop_model->updateById($data,$this->curr_sid);
        if($ret){
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
    }



    //新增或编辑企业服务
    public function addServiceAction(){
        $id = $this->request->getIntParam('id');
        if($id){
            $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
            $row           = $service_model->getRowById($id);
            $this->output['row'] = $row;
        }
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '编辑企业服务', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/service/add-service.tpl');

    }

    //删除企业服务
    public function deleteServiceAction(){
        $id = $this->request->getIntParam('id');
        $update['es_deleted'] = 1;
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $ret = $service_model->updateById($update,$id);
        if($ret){
            $this->displayJsonSuccess(array(),true,'删除成功');
        }else{
            $this->displayJsonError('删除失败');
        }
    }


    //保存服务
    public function saveServiceAction(){
        $id   = $this->request->getIntParam('id');
        $data['es_name']     = $this->request->getStrParam('name');
        $data['es_weight']   = $this->request->getIntParam('weight');
        $data['es_type']     = $this->request->getIntParam('type');
        $data['es_logo']     = $this->request->getStrParam('logo');
        $data['es_cover']    = $this->request->getStrParam('cover');
        $data['es_brief']    = $this->request->getStrParam('brief');
        $data['es_content']  = $this->request->getStrParam('content');
        $data['es_price']    = $this->request->getFloatParam('price');
        $service_model = new App_Model_Service_MysqlEnterpriseServiceStorage();
        $data['es_create_time'] = time();
        if($id){
            $ret = $service_model->updateById($data,$id);
        }else{
            $data['es_s_id'] = $this->curr_sid;
            $ret = $service_model->insertValue($data);
        }
        if($ret){
            $this->displayJsonSuccess(array(),true,'保存成功');
        }else{
            $this->displayJsonError('保存失败');
        }
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
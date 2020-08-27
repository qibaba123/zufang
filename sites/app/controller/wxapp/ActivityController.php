<?php

class App_Controller_Wxapp_ActivityController extends App_Controller_Wxapp_InitController{
    public function __construct(){
        parent::__construct();
    }
    
    public function handleApplyAction(){
        $id               = $this->request->getIntParam('id');
        $note             = $this->request->getStrParam('note');
        $activity_model   = new App_Model_Community_MysqlActivityApplyStorage();
        $set              = array('aap_status'=>1, 'aap_handle_note'=>$note,'aap_handle_time'=>time());
        $ret              = $activity_model->updateById($set,$id);
        if($ret){
            App_Helper_OperateLog::saveOperateLog("处理营销活动申请成功");
            $this->showAjaxResult($ret,'处理');
        }else{
            $this->displayJsonError('处理失败');
        }
    }

}
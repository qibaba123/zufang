<?php

class App_Controller_Wxapp_BasiccfgController extends App_Controller_Wxapp_InitController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function updateDefaultMaidAction(){
        $defaultmaid = $this->request->getFloatParam('defaultmaid');
        $update = array('ap_shop_percentage' => $defaultmaid);
        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->curr_sid);
        $res  = $pay_model->findRowPay();
        if($res){
            $ret  = $pay_model->findRowPay($update);
        }else{
            $this->displayJsonError('请先设置支付配置信息');
        }
        
        if($ret){
            App_Helper_OperateLog::saveOperateLog("保存入驻商家抽成【{$defaultmaid}%】");
        }
        $this->showAjaxResult($ret);
    }


}
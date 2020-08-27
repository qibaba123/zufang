<?php

class App_Controller_Wxapp_OutsideController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }

    
    public function saveOutsideSetupAction(){
        $url = $this->request->getStrParam('outside');
        if($url){
            if(plum_is_https_url($url)){
                $data = array(
                    'awp_url' => $url,
                    'awp_update_time' => time(),
                );
                $outside_model = new App_Model_Applet_MysqlAppletOutsideStorage($this->curr_sid);
                $row = $outside_model->findUpdateBySid();
                if($row){
                    $ret = $outside_model->findUpdateBySid($data);
                }else{
                    $data['awp_s_id'] = $this->curr_sid;
                    $data['awp_create_time'] = time();
                    $ret = $outside_model->insertValue($data);
                }

                if($ret){
                    App_Helper_OperateLog::saveOperateLog("跳转链接保存成功");
                }

                $this->showAjaxResult($ret);
            }else{
                $this->displayJsonError('跳转链接域名仅支持https');
            }
        }else{
            $this->displayJsonError('请填写跳转域名配置');
        }
    }


}
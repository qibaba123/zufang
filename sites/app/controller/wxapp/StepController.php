<?php

class App_Controller_Wxapp_StepController extends App_Controller_Wxapp_InitController{
    public function __construct(){
        parent::__construct();
    }


    /**
     * 积分来源配置管理
     */
    public function cfgAction(){

        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->curr_sid);
        $where       = array();
        $where[]     = array('name' => 'aps_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $pointCfg    = $point_model->getRow($where);
        $this->output['cfg'] = $pointCfg;


        $this->buildBreadcrumbs(array(
            array('title' => '营销工具', 'link' => '#'),
            array('title' => '微信步数', 'link' => '#'),
        ));


        $this->displaySmarty("wxapp/step/step-cfg.tpl");
    }



    /**
     * 保存积分来源配置
     */
    public function saveCfgAction(){
        $id = $this->request->getIntParam('id');
        $step = $this->request->getIntParam('step');
        $stepTotal = $this->request->getIntParam('stepTotal');
        $stepOpen = $this->request->getIntParam('stepOpen');
        $stepRule = $this->request->getStrParam('stepRule');


        $data = array(
            'aps_step' => $step,
            'aps_step_open' => $stepOpen,
            'aps_step_rule' => $stepRule,
            'aps_step_total' => $stepTotal,
        );

        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->curr_sid);
        if($id){
            $data['aps_update_time']=time();
            $ret=$point_model->updateById($data,$id);
        }else{
            $data['aps_s_id']=$this->curr_sid;
            $data['aps_create_time']=time();
            $ret=$point_model->insertValue($data);
        }
        if($ret){
            App_Helper_OperateLog::saveOperateLog("微信步数兑换积分配置保存成功");
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
        $this->displayJson($result);
    }

}
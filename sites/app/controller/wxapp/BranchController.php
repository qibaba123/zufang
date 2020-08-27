<?php


class App_Controller_Wxapp_BranchController extends App_Controller_Wxapp_InitController
{
    public function __construct(){
        parent::__construct();
    }


    
    public function statusAction(){
        $id       = $this->request->getIntParam('id');
        $status   = $this->request->getIntParam('status');
        $set      = array(
            'sb_update_time' => time(),
            'sb_status'      => $status == 1 ? 1 : 2
        );
        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->curr_sid);
       	$ret1         = $branch_model->getRowById($id);
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
      	$extra_model =  new App_Model_Member_MysqlMemberExtraStorage();
        $where       =  array();
        $where[]     = array('name'=>'ame_pro','oper'=>'=','value'=>$ret1['sb_pro']);
        $where[]     = array('name'=>'ame_city','oper'=>'=','value'=>$ret1['sb_city']);
        $where[]     = array('name'=>'ame_area','oper'=>'=','value'=>$ret1['sb_area']);
        $where[]     = array('name'=>'ame_id','oper'=>'!=','value'=>$id);
        $extra       = $extra_model->getRow($where);
        if($extra){
         $fmember = $member_model->getRowById($extra['ame_m_id']);
        }
      
      	 if($fmember['m_is_highest'] > 0){
           $em = '对不起,此区域已有分销商,审核';
          }else{
            $ret = $branch_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
           if($ret && $status==1){
             $branch = $branch_model->getRowUpdateByIdSid($id,$this->curr_sid);
             $update = array('m_is_highest'=>1);
             $member_model = new App_Model_Member_MysqlMemberCoreStorage();
             $member_model->updateById($update,$branch['sb_m_id']);
             $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->curr_sid);
             $eupdate['ame_pro']  = $branch['sb_pro'];
             $eupdate['ame_city'] = $branch['sb_city'];
             $eupdate['ame_area'] = $branch['sb_area'];
             $where               = array();
             $where[]             = array('name'=>"ame_m_id",'oper'=>'=','value'=>$branch['sb_m_id']);
             $extra_model->updateValue($eupdate,$where);
           }
           $em = '审核';
         }
        
        $this->showAjaxResult($ret,$em);
    }
    
    public function deleteAction(){
        $id       = $this->request->getIntParam('id');
        $set      = array(
            'sb_update_time' => time(),
            'sb_deleted'     => 1
        );
        $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->curr_sid);
        $ret = $branch_model->getRowUpdateByIdSid($id,$this->curr_sid,$set);
        $this->showAjaxResult($ret,'删除');
    }

    
    public function saveCenterAction(){
        $field = array('vip','audit','hasname','hasphone','haswx');
        $data  = $this->getIntByField($field,'tc_fx_');
        $data['tc_fx_banner']  = $this->request->getStrParam('banner');
        $data['tc_fx_desc']    = plum_nl_br($this->request->getStrParam('desc'));
        $data['tc_fx_page_title'] = $this->request->getStrParam('pageTitle');
        $data['tc_fx_btn_text']   = $this->request->getStrParam('btnText');
        $data['tc_fx_rights_title']   = $this->request->getStrParam('rightsTitle');
        $data['tc_fx_welcome_text']   = $this->request->getStrParam('welcomeText');
        $data['tc_update_time']= $_SERVER['REQUEST_TIME'];
        $privilege = $this->request->getArrParam('privilege');
        if(!empty($privilege)) $data['tc_fx_privilege']    = json_encode($privilege);
        $three_model = new App_Model_Three_MysqlCfgStorage($this->curr_sid);
        $ret         = $three_model->findShopCfg($data);
        $this->showAjaxResult($ret,'保存');
    }

    
    public function branchHideAction(){
        $id = $this->request->getIntParam('id');
        $res = false;
        if($id){
            $branch_model = new App_Model_Shop_MysqlShopBranchStorage($this->curr_sid);
            $res = $branch_model->updateById(array('sb_web_hide'=>1),$id);
        }
        $this->showAjaxResult($res,'删除');
    }



}
<?php
/*
 * 问答小程序分润配置表
 */
class App_Model_Knowledge_MysqlKnowledgeThreeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $question_table;
    public function __construct($sid){
        $this->_table 	= 'applet_knowledge_three';
        $this->_pk 		= 'akt_id';
        $this->_shopId 	= 'akt_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = 'member';
        $this->question_table = 'applet_knowledge_question';
    }

    /*
     * 获得或修改对应等级的配置
     */
    public function findUpdateThreeCfg($level,$data = null){
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'akt_level','oper'=>'=','value'=>$level);
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }


    /*
     * 获得分钱配置
     */
    public function getThreeCfg(){
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getList($where,0,3);

    }

    /**
     * @param $insert
     * @return bool
     * 批量插入
     */
    public function batchData($insert){
        $ret = false;
        if(is_array($insert) && !empty($insert)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`akt_id`, `akt_s_id`, `akt_level`, `akt_main`, `akt_lv1`, `akt_lv2`, `akt_lv3`, `akt_update_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$insert);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }



}
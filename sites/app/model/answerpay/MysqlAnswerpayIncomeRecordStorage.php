<?php

class App_Model_Answerpay_MysqlAnswerpayIncomeRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_income_record';
        $this->_pk      = 'aair_id';
        $this->_shopId  = 'aair_s_id';
        $this->sid      = $sid;
    }

    /*
     * 批量添加记录
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`aair_id`, `aair_s_id`, `aair_m_id`,`aair_type`,`aair_question_type`,`aair_payment`,`aair_money`, `aair_create_time`,`aair_manager_id`,`aair_inout`,`aair_member_type`,`aair_question_id`,`aair_answer_id`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /**根据条件统计信息
     * @param int $yesterday
     * @return array|bool
     */
    public function deductSum($where){
        $sql  = 'SELECT count(*) as num,sum(aair_money) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 收益列表 关联问题表
     */
    public function getRecordQuestionList($where,$index,$count,$sort){

        $sql = "SELECT aair.*,aaq.aaq_title ";
        $sql .= " FROM ".DB::table($this->_table)." aair ";
        $sql .= " LEFT JOIN pre_applet_answerpay_question aaq on aair.aair_question_id = aaq.aaq_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 收益列表 关联问题表
     */
    public function getRecordQuestionCount($where){

        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." aair ";
        $sql .= " LEFT JOIN pre_applet_answerpay_question aaq on aair.aair_question_id = aaq.aaq_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
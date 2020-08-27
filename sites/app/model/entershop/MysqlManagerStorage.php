<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/9
 * Time: 下午5:13
 */
class App_Model_Entershop_MysqlManagerStorage extends Libs_Mvc_Model_BaseModel {
    public function __construct() {
        parent::__construct();
        $this->_table   = 'enter_shop_manager';
        $this->_pk      = 'esm_id';
    }


    /**
     * 按特定手机号字段检索管理员
     * @param mixed $mobile
     * @return array|bool
     */
    public function findManagerByMobile($mobile, $sid=0,$esId = 0,$id = 0) {
        if($sid){
            $where[]    = array('name' => 'esm_s_id', 'oper' => '=', 'value' => $sid);
        }
        if($esId){
            //排除自身
            $where[]    = array('name' => 'esm_es_id', 'oper' => '!=', 'value' => $esId);
        }
        if($id){
            //排除自身
            $where[]    = array('name' => 'esm_id', 'oper' => '!=', 'value' => $id);
        }

        $where[]    = array('name' => 'esm_mobile', 'oper' => '=', 'value' => $mobile);

        $ret = $this->getRow($where);

        return $ret;
    }

    /*
     * 根据平台店铺id和入驻店铺id获取店铺管理员
     */
    public function findManagerEsid($sid,$esid) {
        $where[]    = array('name' => 'esm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'esm_es_id', 'oper' => '=', 'value' => $esid);
        $where[]    = array('name' => 'esm_status', 'oper' => '=', 'value' => 0);
        $ret = $this->getList($where,0,0);
        return $ret;
    }

    /**
     * 根据店铺id修改管理员信息
     */
    public function updateByEsId($set, $esId){
        $where[]    = array('name' => 'esm_es_id', 'oper' => '=', 'value' => $esId);
        $ret = $this->updateValue($set, $where);
        return $ret;
    }

    public function getListParent($where,$index,$count,$sort){
        $sql = "select esm.*,esmp.esm_nickname as parentName,esmp.esm_id as parentId ";
        $sql .= " from `".DB::table($this->_table)."` esm ";
        $sql .= " left join ".DB::table($this->_table)." esmp on esm.esm_fid = esmp.esm_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getCountParent($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` esm ";
        $sql .= " left join ".DB::table($this->_table)." esmp on esm.esm_fid = esmp.esm_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 设置会员金币自增或自减
     */
    public function incrementManagerField($id, $money ,$field = 'esm_deduct_ktx') {
        $field  = array($field);
        $inc    = array($money);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    public function incrementManagerDeductAmount($mid,$deduct){
        $field  = array('esm_deduct_ktx', 'esm_deduct_amount');
        $inc    = array($deduct, $deduct);

        $where[]    = array('name' => 'esm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
    * 同时增加一个并减少另一个金额
    */
    public function editManagerDeductWithdraw($mid, $money, $inc_field, $cut_field) {
        $field  = array($inc_field, $cut_field);
        $inc    = array($money, -$money);

        $where[]    = array('name' => 'esm_id', 'oper' => '=', 'value' => $mid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


}
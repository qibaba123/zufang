<?php

class Libs_Mvc_Model_BaseModel extends Libs_Mysql_PlumTable {

    public $_shopId;
    public function __construct() {
        parent::__construct();
    }

    public function getRow($where) {
        if($this->_df){
            $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $sql = $this->formatSelectOneSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }


    /**
     * @param $where
     * @return bool
     * 根据条件更新逻辑删除字段
     */
    public function deleteDFByWhere($where){
        if($where && $this->_df){
            $set = array(
                $this->_df => 1,
            );
            return $this->updateValue($set,$where);
        }
        return false;
    }
    /**
     * @param array $where
     * @param int $index
     * @param int $count
     * @param array $sort
     * @param array $field
     * @param bool $primary 是否使用主键作为结果数组的索引
     * @return array|bool
     */
    public function getList($where = array(), $index = 0, $count = 20, $sort = array(), $field = array(), $primary = false,$test=0) {
        if($this->_df){
            $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $sql = $this->formatSelectSql($field, $where, $sort, $index, $count);
        //return $sql;
        if($test){
            return $sql;
        }
        $keyfield = '';
        if ($primary) {
            $keyfield   = $this->_pk;
        }
        $ret = DB::fetch_all($sql, array(), $keyfield);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getCount($where = array(),$test=0) {
        if($this->_df){
            $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        }
        $sql = $this->formatCountSql($where);
        if($test){
            return $sql;
        }
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function insertValue(array $data, $return_insert_id = true, $replace = false, $silent = false) {
        $ret = $this->insert($data, $return_insert_id, $replace, $silent);
        if ($ret === false && !$silent) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function updateValue($set, $where){
        if(empty($where)){
            trigger_error("Update the mysql  where conditions cannot be empty");
            return false;
        }
        $sql = $this->formatUpdateSql($set,$where);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function deleteValue($where) {
        if(empty($where)){
            trigger_error("Delete the mysql  where conditions cannot be empty");
            return false;
        }
        $sql = $this->formatDeleteSql($where);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getRowById($id){
        $where   = array();
        $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
        return $this->getRow($where);
    }

    public function updateById($set,$id){
        if($id){
            $where   = array();
            $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
            return $this->updateValue($set,$where);
        }
    }
    public function getRowByIdSid($id,$sh_id){
        $where   = array();
        $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sh_id);
        return $this->getRow($where);
    }

    /**
     * @param $id
     * @param $sh_id
     * @param array $data
     * @param $region_manager_id  区域管理员id
     * @return array|bool
     * 获取或修改单行数据
     */
    public function getRowUpdateByIdSid($id,$sh_id,$data=array(),$region_manager_id=false){
        $where   = array();
        if($region_manager_id){
            $where[]=['name'=>'asl_region_manager_id','oper'=>'=','value'=>$region_manager_id];
        }
        $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sh_id);
        if(!empty($data)){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }


    public function deleteById($id){
        if($id){
            $where   = array();
            $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
            return $this->deleteValue($where);
        }
        return false;
    }
    public function deleteBySidId($id,$sh_id){
        if($id && $sh_id){
            $where   = array();
            $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
            $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sh_id);
            return $this->deleteValue($where);
        }
        return false;
    }

    /**
     * @param $id
     * @param int $sh_id
     * @return bool
     * 根据ID更新逻辑删除字段
     */
    public function deleteDFById($id,$sh_id=0){
        if($id && $this->_df){
            $where   = array();
            $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
            if($sh_id){
                $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sh_id);
            }
            $set = array(
                $this->_df => 1,
            );
            return $this->updateValue($set,$where);
        }
        return false;
    }


}
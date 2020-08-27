<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Shop_MysqlMenuStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'shop_menu';
        $this->_pk      = 'sm_id';
        $this->_shopId  = 'sm_s_id';
    }

    public function getOneLevelByIndex($sid,$index){
        $where = array();
        $where[] = array('name' => 'sm_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'sm_index', 'oper' => '=', 'value' => $index);
        $where[] = array('name' => 'sm_fid', 'oper' => '=', 'value' => 0);
        return $this->getRow($where);
    }

    public function updateChildNumById($id){
        $sql = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET `sm_has_child` = sm_has_child+1';
        $sql .= ' WHERE `sm_id` = '.intval($id);
        $ret  = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListBySid($sid){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $sort = array('sm_fid' => 'ASC','sm_index' => 'ASC');
        return $this->getList($where,0,0,$sort,array(),$this->_pk);
    }

    /**
     * @param $level 一级、二级
     * @param $sid 店铺ID
     * @param $index 默认位置
     * @param $id 一级时的主键ID
     * @return bool
     * 删除一级菜单，或者二级菜单
     */
    public function deleteMenuByLevel($level,$sid,$index,$id=0){
        $sql = 'delete from '.DB::table($this->_table).' where `sm_s_id` = '.intval($sid);
        if($level == 1){
            $sql .= ' AND (sm_id='.intval($id).' OR (sm_fid='.intval($id).'))';
        }else{
            $sql .= ' AND sm_index='.intval($index).' AND sm_fid='.intval($id).' AND sm_level=2 ';
        }
        $ret  = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /***
     * @param array $where
     * @return bool
     * 删除菜单
     */
    public function updateIndex(array $where){
        $ret = false;
        if(!empty($where)){
            $sql  = 'update '.DB::table($this->_table);
            $sql .= ' set sm_index = sm_index-1 ';
            $sql .= $this->formatWhereSql($where);
            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /*
     * 获取店铺一级菜单
     */
    public function fetchFirstLevelBySid($sid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'sm_level', 'oper' => '=', 'value' => 1);
        $sort   = array('sm_index' => 'ASC');

        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 获取某项一级菜单下的二级菜单
     */
    public function fetchSecondLevelByFid($fid) {
        $where[]    = array('name' => 'sm_fid', 'oper' => '=', 'value' => $fid);

        $sort   = array('sm_index' => 'ASC');

        return $this->getList($where, 0, 0, $sort);
    }

    /**
     * @param $sid
     * @param $index
     * @return bool
     * 查询子菜单数量
     */
    public function hasSon($sid,$index){
        $where   = array();
        $where[] = array('name' => 'sm_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'sm_level', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'sm_index', 'oper' => '=', 'value' => $index);

        $sql = 'SELECT COUNT(*) '.' FROM '.DB::table($this->_table);
        $sql .= ' WHERE sm_fid in(';
        $sql .= ' SELECT sm_id '.' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= ')';
        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $sid
     * @param $index
     * @param $sets
     * @return bool
     * 更新一级菜单的链接方式和内容
     */
    public function updateLevelLink($sid,$index,$sets,$fid=0){
        $where   = array();
        $where[] = array('name' => 'sm_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'sm_index', 'oper' => '=', 'value' => $index);
        $where[] = array('name' => 'sm_fid', 'oper' => '=', 'value' => $fid);
        if($fid){
            $where[] = array('name' => 'sm_level', 'oper' => '=', 'value' => 2);
        }else{
            $where[] = array('name' => 'sm_level', 'oper' => '=', 'value' => 1);
        }
        return $this->updateValue($sets,$where);
    }

    /**
     * @param $sid
     * @param $level
     * @param $findex
     * @return bool
     * 判断一级菜单和二级菜单数量
     */
    public function checkMenuNumber($sid,$level,$findex){
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'sm_level', 'oper' => '=', 'value' => $level);
        $where[] = array('name' => 'sm_fid', 'oper' => '=', 'value' => $findex);
        $count = $this->getCount($where);
        if($level == 2){
            $limit = 5;
        }else{
            $limit = 3;
        }
        if($count < $limit){
            return true;
        }
        return false;
    }

    public function insertCheckExist($data){
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $data[$this->_shopId]);
        $where[] = array('name' => 'sm_level', 'oper' => '=', 'value' => $data['sm_level']);
        $where[] = array('name' => 'sm_fid', 'oper' => '=', 'value' => $data['sm_fid']);
        $where[] = array('name' => 'sm_index', 'oper' => '=', 'value' => $data['sm_index']);
        $exist = $this->getCount($where);
        if($exist == 0){
            return $this->insertValue($data);
        }
        return false;
    }

    /**
     * @param array $insert
     * 批量更新菜单
     */
    public function batchInsert(array $insert){
        if(!empty($insert)){
            $sql  = 'INSERT INTO '. DB::table($this->_table);
            $sql .= ' (`sm_id`, `sm_s_id`, `sm_name`, `sm_link`, `sm_level`, `sm_index`, `sm_fid`, `sm_has_child`, `sm_update_time`, `sm_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$insert);
            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
    }

    /**
     * @param array $ids
     * @param $sid
     * 批量删除不存在的菜单
     */
    public function deleteByIds(array $ids,$sid){
        if(!empty($ids)){
            $where   = array();
            $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
            $where[] = array('name' => $this->_pk, 'oper' => 'in', 'value' => $ids);
            $this->deleteValue($where);
        }
    }
}
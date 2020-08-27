<?php

class App_Model_Address_MysqlAddressCoreStorage extends Libs_Mvc_Model_BaseModel {
    public function __construct() {
        $this->_table = 'china_address';
        $this->_pk    = 'region_id';
        parent::__construct();
    }

    public function get_province(){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=1';
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function getProvinceByField($field=array()){
        $sql = 'SELECT ';
        $sql .= $this->getFieldString($field);
        $sql .= 'FROM `dpl_china_address` WHERE region_type=1';
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function get_province_for_select(){
        $list = $this->get_province();
        $data = array();
        foreach($list as $val){
            $data[$val['region_id']] = $val['region_name'];
        }
        return $data;
    }
    public function get_city(){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=2';
        $ret = DB::fetch_all($sql);
        return $ret;
    }
    public function get_area(){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=3';
        $ret = DB::fetch_all($sql);
        return $ret;
    }
    public function getCityByField($parent_id,$field=array()){
        $sql = 'SELECT ';
        $sql .= $this->getFieldString($field);
        $sql .= 'FROM `dpl_china_address` WHERE region_type=2 AND parent_id='.intval($parent_id);
        $ret = DB::fetch_all($sql);
        return $ret;
    }


    public function get_city_by_parent($parent_id){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=2 AND parent_id='.intval($parent_id);
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function get_area_by_parent($parent_id){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=3 AND parent_id='.intval($parent_id);
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function getChinaAddress(){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE 1 ';
        $ret = DB::fetch_all($sql);
        return $ret;
    }
    /*
    public function getRow($where,$field=array()){
        $sql = 'SELECT ';
        $sql .= $this->getFieldString($field);
        $sql .= ' FROM dpl_china_address ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
   */
    // 根据城市ID获取下级区域信息
    public function get_area_by_parents($parent_ids){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=3 AND parent_id in '.$parent_ids;
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function getRowByZoneName($name){
        $where[] = array('name'=>'region_type','oper'=>'=','value'=>3);
        $where[] = array('name'=>'region_name','oper'=>'=','value'=>$name);
        return $this->getRow($where);
    }

    public function selectDealData($type=0,$id=0){
        $where  = array();
        $field = array('region_id','region_name');
        if(in_array($type,array(1,2,3))){
            $where[] = array('name'=>'region_type','oper'=>'=','value'=>$type);
            if($type == 2){
                $where[] = array('name'=>'parent_id','oper'=>'=','value'=>$id);
            }else if($type == 3){
                $where[] = array('name'=>'parent_id','oper'=>'=','value'=>$id);
            }
        }
        $sql = 'SELECT ';
        $sql .= $this->getFieldString($field);
        $sql .= ' FROM dpl_china_address ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        $data = array();
        foreach($ret as $v){
            $data[$v['region_id']] = $v['region_name'];
        }
        return $data;
    }

    public function getCityAreaList($where, $index = 0, $count = 20, $sort = array()){
        $sql = 'SELECT pa.*,pro.`region_name` p_name,cit.`region_name` c_name,are.`region_name` a_name';
        $sql .=' FROM pre_address pa
                LEFT JOIN dpl_china_address pro ON pro.`region_id`= pa.`add_province`
                LEFT JOIN dpl_china_address cit ON cit.`region_id`= pa.`add_city`
                LEFT JOIN dpl_china_address are ON are.`region_id`= pa.`add_area`';
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

    public function getAddressByMid($mid, $page =0 ){
        $where = array();
        $count = 10;
        $index = $page * $count;
        $where[] = array('name'=>'add_mem_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'add_isdelete','oper'=>'=','value'=>0);
        $sort    = array('add_isdefault'=>'DESC','add_updatetime'=>'DESC');
        return $this->getCityAreaList($where, $index, $count,$sort);
    }

    /**
     * 查询上一级ID
     */
    public function getSuperiorRegionId($id=0){
        $where = array();
        $where[] = array('name'=>'region_id','oper'=>'=','value'=>$id);
        $sql = ' SELECT * FROM dpl_china_address  ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}

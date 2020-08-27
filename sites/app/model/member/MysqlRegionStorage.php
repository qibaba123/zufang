<?php

class App_Model_Member_MysqlRegionStorage extends Libs_Mvc_Model_BaseModel {
    public function __construct() {

        parent::__construct();

    }

    public function get_province(){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type=1';
        $ret = DB::fetch_all($sql);
        return $ret;
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

    public function getListByParent($parent_id){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE  parent_id='.intval($parent_id);
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

    public function get_province_city_in_type($type){
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type in '.$type;
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function getProCityAreaByFname($f_name,$type){
        $f_name = str_replace('省','',$f_name);
        $f_name = str_replace('市','',$f_name);
        $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_type='.$type.' AND parent_id=(';
        $sql .= 'select region_id '.'FROM `dpl_china_address` WHERE region_type='.intval($type-1).' AND region_name = "'.$f_name.'"';
        $sql .=')';
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    public function getCityRowByFname($f_name,$type){
        $f_name = str_replace('省','',$f_name);
        $f_name = str_replace('市','',$f_name);
        $sql = "SELECT * FROM `dpl_china_address` ";
        $sql .= " WHERE region_type={$type} AND region_name = '{$f_name}' ";
        $ret = DB::fetch_first($sql);
        return $ret;
    }

    public function getRow($where,$field=array()){
        $sql = 'SELECT * ';
        $sql .= ' FROM dpl_china_address ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListTable($where,$index = 0,$count = 20,$sort = array(),$field=array()){
        $sql = 'SELECT * ';
        $sql .= ' FROM dpl_china_address ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index, $count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param array $ids
     * @return array
     * 根据省市区ID数组，获取省市区名称数组
     */
    public function getProCityAreaValueByRegionsId(array $ids){
        $data = array();
        if(!empty($ids) && is_array($ids)){
            $r_id = '('.implode(',',$ids).')';
            $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE region_id in '.$r_id;
            $region =  DB::fetch_all($sql);
            foreach($region as $val){
                if($val['region_type'] == 1) {
                    $data['pro'] = $val['region_name'];
                }elseif($val['region_type'] == 2){
                    $data['city'] = $val['region_name'];
                }elseif($val['region_type'] == 3){
                    $data['area'] = $val['region_name'];
                }
            }
        }

        return $data;
    }

    /**
     * @param array $ids
     * @return array
     * 根据省市区名称数组，获取省市区ID数组
     */
    public function getProCityAreaIdByName(array $name){
        $data = array();
        if(!empty($name) && is_array($name)){
            $where = array();
            foreach($name as $val){
                $where[] = ' region_name like "%'.$val.'%" ';
            }
            $region_name  = '('.implode(' or ',$where).')';
            $sql = 'SELECT * '.'FROM `dpl_china_address` WHERE '.$region_name;
            $region =  DB::fetch_all($sql);
            foreach($region as $val){
                if($val['region_type'] == 1) {
                    if(!isset($data['pro'])){
                        $data['pro'] = $val['region_id'];
                    }
                }elseif($val['region_type'] == 2){
                    if(!isset($data['city'])){
                        $data['city'] = $val['region_id'];
                    }
                }elseif($val['region_type'] == 3){
                    if(!isset($data['area'])) {
                        $data['area'] = $val['region_id'];
                    }
                }
            }
        }

        return $data;
    }
    public function get_address_name($id){
        $sql = 'SELECT region_name '.'FROM `dpl_china_address` WHERE region_id='.$id;
        $ret = DB::fetch_first($sql);
        return $ret;
    }
    /**
     * 根据城市名称获取省份id
     * @param  [type] $c_id [description]
     * @return [type]       [description]
     */
    public function getProvinceByCityId($c_id){
        $sql='SELECT `parent_id` FROM `dpl_china_address` WHERE region_id='.$c_id;
        $res=DB::fetch_first($sql);
        return $res;
    }

    public function getCount($where=[]){
        $sql='SELECT COUNT(*) as total FROM `dpl_china_address` ';
        $sql.=$this->formatWhereSql($where);
        $res=DB::result_first($sql);
        if ($res === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }
}

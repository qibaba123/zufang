<?php

class App_Model_App_MysqlAmapStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'amap_address';
        $this->_pk      = 'aa_id';
    }

    public function getCity($fid = 0){
        if($fid){
            $where[] = ['name' => 'aa_fid', 'oper' => '=', 'value' => $fid];
        }
        $where[] = ['name' => 'aa_level', 'oper' => '=', 'value' => 2];
        return $this->getList($where,0,0);
    }

    public function getCityRow($name){
        $where[] = ['name' => 'aa_name', 'oper' => 'like', 'value' => "%{$name}%"];
        $where[] = ['name' => 'aa_level', 'oper' => '=', 'value' => 2];
        return $this->getRow($where);
    }


    public function getListByFid($fid,$level = 0){
        $where = [];
        $where[] = ['name'=>'aa_fid','oper'=>'=','value'=>$fid];
        if($fid == 0){
            $where[] = ['name'=>'aa_level','oper'=>'=','value'=>1];
        }else{
            if($level){
                $where[] = ['name'=>'aa_level','oper'=>'=','value'=>$level];
            }
        }

        return $this->getList($where,0,0);
    }

    public function getRowByAdcode($adcode){
        $where = [];
        $where[] = ['name'=>'aa_ad_code','oper'=>'=','value'=>$adcode];
        return $this->getRow($where);
    }

    public function getCityProvince($name = '',$id = 0){
        $where = [];
        if($name){
            $where[] = ['name' => 'aa.aa_name', 'oper' => '=', 'value' => $name];
        }
        if($id){
            $where[] = ['name' => 'aa.aa_id', 'oper' => '=', 'value' => $id];
        }
        $where[] = ['name' => 'aa.aa_level', 'oper' => '=', 'value' => 2];

        $sql = "SELECT aa.aa_id as cityid,aa.aa_name as city,aa.aa_city_code as citycode,faa.aa_name as prov,faa.aa_id as provid ";
        $sql .= " FROM ".DB::table($this->_table)." aa ";
        $sql .= " LEFT JOIN ".DB::table($this->_table)." faa on faa.aa_id = aa.aa_fid ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function insertBacth($value){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`aa_id`, `aa_fid`, `aa_name`, `aa_city_code`, `aa_ad_code`, `aa_center_lng`, `aa_center_lat`, `aa_level_name`, `aa_level`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$value);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}
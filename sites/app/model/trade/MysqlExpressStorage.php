<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/7/28
 * Time: 下午10:35
 */
class App_Model_Trade_MysqlExpressStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'express';
        $this->_pk 		= 'e_id';
        $this->_df 	    = 'e_deleted';
        parent::__construct();
    }

    /**
     * @param array $value
     * 批量导入快递
     */
    public function insertBatch(array $value){
        $ret = false;
        if(!empty($value)){
            $sql = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`e_id`, `e_name`, `e_code`, `e_weight`, `e_deleted`, `e_create_time`)  ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$value);
            $ret = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    public function getExpressList($is_select=0,$field=array()){
        $sort = array('e_weight' => 'DESC');
        $list = $this->getList(array(),0,0,$sort,$field);
        if($is_select){
            $data = array();
            foreach($list as $val){
                $data[$val['e_code']] = $val['e_name'];
            }
        }else{
            $data =  $list;
        }
        return $data;
    }

    /**
     * 根据快递公司编号查询快递公司信息
     */
    public function getExpressByCode($code){
        $where[] = array('name'=>'e_code','oper'=>'=','value'=>$code);
        return $this->getRow($where);
    }

}
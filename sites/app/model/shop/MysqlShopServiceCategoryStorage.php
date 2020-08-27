<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Shop_MysqlShopServiceCategoryStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'shop_service_category';
        $this->_pk 		= 'ssc_id';
        $this->_shopId 	= 'ssc_s_id';
        $this->_df 	    = 'ssc_deleted';
        parent::__construct();

        $this->sid  = $sid;
    }

    public function getCategoryListForSelect(){
        $where = array();
        $where[] = array('name'=>'ssc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('ssc_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['ssc_type']][$val['ssc_id']] = $val['ssc_name'];
            }
        }
        return $data;
    }

    // 根据类型获取店铺的所有分类
    public function getCategoryListByType($type=1){
        $where = array();
        $where[] = array('name'=>'ssc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>'ssc_type','oper'=>'=','value'=>$type);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('ssc_sort'=>'ASC','ssc_create_time'=>'DESC'));
        return $list;
    }

    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ssc_id`, `ssc_s_id`,`ssc_name`, `ssc_type`,`ssc_sort`,`ssc_deleted`, `ssc_create_time`) ';
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
}
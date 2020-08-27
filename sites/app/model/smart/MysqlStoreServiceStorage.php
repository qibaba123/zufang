<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Smart_MysqlStoreServiceStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_store_service';
        $this->_pk     = 'ass_id';
        $this->_shopId = 'ass_s_id';
        $this->_df     = 'ass_deleted';
        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
    }
    public function getStoreRowBySid($tpl_id,$sid)
    {
        $where   = array();
        $where[] = array('name' => 'ass_tpl_id','oper' => '=' , 'value' => $tpl_id);
        $where[] = array('name' => 'ass_s_id','oper' => '=' , 'value' => $sid);
        $row     = $this->getlist($where);
        return $row;
    }
    /*
 * 批量插入服务
 */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ass_id`, `ass_s_id`,`ass_tpl_id`,`ass_ass_id`,`ass_name`,`ass_cover`,`ass_sort`, `ass_create_time`) ';
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
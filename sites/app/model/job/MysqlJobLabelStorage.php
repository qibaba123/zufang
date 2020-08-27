<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Job_MysqlJobLabelStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_job_label';
        $this->_pk = 'ajl_id';
        $this->_shopId = 'ajl_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    //根据店铺获取标签
    public function getListBySid($pType = 2,$all = false){
        $where[] = array('name' => 'ajl_s_id', 'oper' => '=', 'value' => $this->sid);

        if(!$all){
            $where[] = array('name' => 'ajl_p_type', 'oper' => '=', 'value' => $pType);
        }

        $where[] = array('name' => 'ajl_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('ajl_index' => 'ASC');
        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 批量添加帖子分类
     */
    public function insertBatchLabel(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ajl_id`, `ajl_s_id`, `ajl_name`, `ajl_index`,`ajl_create_time`, `ajl_deleted`, `ajl_p_type`) ';
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
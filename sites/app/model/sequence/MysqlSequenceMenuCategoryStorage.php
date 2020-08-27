<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Sequence_MysqlSequenceMenuCategoryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_menu_category';
        $this->_pk = 'asmc_id';
        $this->_shopId = 'asmc_s_id';
        $this->_df = 'asmc_deleted';
        $this->sid = $sid;
    }

    /*
     * 批量添加店铺分类
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`asmc_id`, `asmc_s_id`, `asmc_title`, `asmc_sort`,`asmc_deleted`, `asmc_create_time` , `asmc_update_time`) ';
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
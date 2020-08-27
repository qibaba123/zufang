<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Job_MysqlJobPositionLabelStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_job_position_label';
        $this->_pk = 'ajpl_id';
        $this->_shopId = 'ajpl_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 根据职位id获取职位标签
     */
    public function getLabelListByPId($pid){
        $where[] = array('name' => 'ajpl_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajpl_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajpl_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('ajpl_create_time' => 'desc');
        return $this->getList($where, 0, 0, $sort);
    }

    /**
     * 根据职位id获取职位标签及名称
     */
    public function getLabelListNameByPId($pid){
        //$where[] = array('name' => 'ajpl_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajpl_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajpl_deleted', 'oper' => '=', 'value' => 0);
        $sort = array('ajl_index' => 'ASC');
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` ajpl ";
        $sql .= " left join pre_applet_job_label ajl on ajl.ajl_id = ajpl.ajpl_l_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,0);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 批量添加帖子分类
     */
    public function insertBatchPostCategory(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ajpl_id`, `ajpl_s_id`, `ajpl_es_id`, `ajpl_ajp_id`,`ajpl_l_id`,`ajpl_deleted`, `ajpl_create_time`) ';
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
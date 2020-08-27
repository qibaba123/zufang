<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Meeting_MysqlMeetingCategoryStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_meeting_category';
        $this->_pk 		= 'amc_id';
        $this->_shopId 	= 'amc_s_id';
        $this->_df 	    = 'amc_deleted';
        parent::__construct();

        $this->sid = $sid;
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListBySid(){
        $where = array();
        $where[] = array('name'=>'amc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getList($where,0,0,array('amc_sort'=>'ASC','amc_create_time'=>'DESC'));
    }
    /**
     * 根据店铺id获取店铺的所有资讯分类(新的)
     */
    public function newGetListBySid($amid){
        $where = array();
        $where[] = array('name'=>'amc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'amc_am_id','oper'=>'=','value'=>$amid);
        return $this->getList($where,0,0,array('amc_sort'=>'ASC','amc_create_time'=>'DESC'));
    }
    /**
     * 获取分类选择使用
     */
    public function getCategoryListForSelect(){
        $where = array();
        $where[] = array('name'=>'amc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('amc_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['amc_id']] = $val['amc_name'];
            }
        }
        return $data;
    }

    /**
     * 批量插入分类使用
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amc_id`, `amc_s_id`,`amc_name`, `amc_sort`,`amc_deleted`, `amc_create_time`) ';
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
    /**
     * 批量插入分类使用
     * @param array $val_arr
     * @return bool
     */
    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amc_id`, `amc_s_id`,`amc_am_id`,`amc_name`, `amc_sort`,`amc_deleted`, `amc_create_time`) ';
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
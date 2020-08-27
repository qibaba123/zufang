<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Applet_MysqlAppletInformationCategoryStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_information_category';
        $this->_pk 		= 'aic_id';
        $this->_shopId 	= 'aic_s_id';
        $this->_df 	    = 'aic_deleted';
        parent::__construct();

        $this->sid = $sid;
    }

    /**
     * 根据店铺id获取店铺的所有资讯分类
     */
    public function getListBySid(){
        $where = array();
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getList($where,0,0,array('aic_sort'=>'ASC','aic_create_time'=>'DESC'));
    }

    /**
     * 获取分类选择使用
     */
    public function getCategoryListForSelect(){
        $where = array();
        $where[] = array('name'=>'aic_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('aic_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['aic_id']] = $val['aic_name'];
            }
        }
        return $data;
    }

    public function getListGzh($where,$index,$count,$sort){
        $sql = "select c.*,g.* ";
        $sql .= " from `".DB::table($this->_table)."` c ";
        $sql .= " left join pre_applet_bind_gzh g on c.aic_id = g.abg_cate_id ";

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

    /**
     * 批量插入分类使用
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`aic_id`, `aic_s_id`,`aic_name`, `aic_sort`,`aic_deleted`, `aic_create_time`) ';
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
<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityFreeProjectStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_free_project';
        $this->_pk = 'acfp_id';
        $this->_shopId = 'acfp_s_id';
        $this->_df = 'acfp_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 根据门店id获取门店的所有预约项目
     */
    public function getListByEsId($esId, $index = 0, $count = 0){
        $where = array();
        $where[] = array('name'=>'acfp_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'acfp_es_id','oper'=>'=','value'=>$esId);
        return $this->getList($where,$index,$count,array('acfp_weight'=>'ASC','acfp_update_time'=>'DESC'));
    }

    /**
     * 批量插入预约项目使用
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acfp_id`, `acfp_s_id`,`acfp_es_id`,`acfp_name`, `acfp_weight`,`acfp_deleted`, `acfp_update_time`) ';
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
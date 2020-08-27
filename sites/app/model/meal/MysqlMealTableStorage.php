<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/10/10
 * Time: 下午：3：32
 */
class App_Model_Meal_MysqlMealTableStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meal_table';
        $this->_pk = 'amt_id';
        $this->_shopId = 'amt_s_id';
        $this->_df = 'amt_deleted';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($amt_id,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'amt_id', 'oper' => '=', 'value' => $amt_id);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function deleteDFByIdEsId($id,$esId=0){
        if($id && $this->_df){
            $where   = array();
            $where[] = array('name' => $this->_pk,'oper' => '=','value' =>$id);
            $where[] = array('name' => 'amt_es_id','oper' => '=','value' =>$esId);

            $set = array(
                $this->_df => 1,
            );
            return $this->updateValue($set,$where);
        }
        return false;
    }

    /*
     * 获得餐桌列表 区分是否为服务员
     */
//    public function getTableList($isWaiter,$esId = 0,$mid){
//        $sort = array('amt_create_time'=>'DESC');
//
//        $sql = 'select * ';
//        $sql .= 'from `'.DB::table($this->_table).'`';
//        $sql .= ' where amt_s_id = '.$this->sid.' ';
//        $sql .= ' and amt_es_id = '.$esId.' ';
//        if(!$isWaiter){
//            //不是服务员 获得未使用餐桌和自己的已使用餐桌
//            $sql .= 'amt_use = 0 or (amt_use = 1 and amt_use_mid = '.$mid.') ';
//        }
//        //是服务员,获得所有餐桌(不做筛选)
//        $sql .= $this->getSqlSort($sort);
//        $sql .= $this->formatLimitSql(0,0);
//        $ret = DB::fetch_all($sql);
//        if ($ret === false) {
//            trigger_error("query mysql failed.", E_USER_ERROR);
//            return false;
//        }
//        return $ret;
//    }
}
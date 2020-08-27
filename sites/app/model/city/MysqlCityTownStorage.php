<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/10/10
 * Time: 下午：3：32
 */
class App_Model_City_MysqlCityTownStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_town';
        $this->_pk = 'act_id';
        $this->_shopId = 'act_s_id';
        $this->_df = 'act_deleted';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
      * 通过店铺id及主键id获取模版配置
      */
    public function findUpdateBySid($act_id,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'act_id', 'oper' => '=', 'value' => $act_id);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
      * 通过店铺id获取全部的数据列表
      */
    public function getListBySid($primary = false) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort = array('act_sort'=>'DESC','act_create_time'=>'DESC');
        return $this->getList($where,0,0,$sort,[],$primary);
    }

    /*
     * 根据管理员手机号获得管理员信息
     */
    public function findRowByMobile($mobile,$id=0) {
        $where[]    = array('name' => 'act_mobile', 'oper' => '=', 'value' => $mobile);
        if($id){
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $id);//排除自身
        }
        $ret = $this->getRow($where);

        return $ret;
    }

    /*
    * 不同字段自增或自减
    */
    public function incrementField($field,$id,$num){
        $field = array($field);
        $inc   = array($num);
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}
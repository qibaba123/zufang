<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/14
 * Time: 下午11:02
 */
class App_Model_Coupon_MysqlCouponStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'coupon_list';
        $this->_pk      = 'cl_id';
        $this->_shopId  = 'cl_s_id';
        $this->_df      = 'cl_deleted';
    }

    /*
     * 获取店铺有效的优惠券列表
     */
    public function fetchValidList($sid, $index = 0, $count = 50, $where=array(), $esId=0) {
        $time       = time();

        $where[]    = array('name' => 'cl_es_id', 'oper' => '=', 'value' => $esId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        //$where[]    = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time);
        $where[]    = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time);
        //新增只查询可以领取的优惠券   coupon_type =0
        $where[]    = array('name' => 'cl_coupon_type', 'oper' => '=', 'value' => 0);
        $sort   = array('cl_top'=>'DESC','cl_sort'=>'DESC','cl_start_time' => 'ASC');
        return  $this->getList($where, $index, $count,$sort);
    }
    /*
     * 获取店铺有效的优惠券列表数量
     */
    public function fetchValidCount($sid,$where=array(), $esId=0) {
        $time       = time();
        $where[]    = array('name' => 'cl_es_id', 'oper' => '=', 'value' => $esId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        //$where[]    = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time);
        $where[]    = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time);
        //新增只查询可以领取的优惠券   coupon_type =0
        $where[]    = array('name' => 'cl_coupon_type', 'oper' => '=', 'value' => 0);
        return  $this->getCount($where);
    }
    /*
     * 获取在店铺首页展示的有效优惠券列表
     */
    public function fetchShowValidList($sid, $index = 0, $count = 10, $esId=0, $isIndex=1, $all = false) {
        $time       = time();
        $where[]    = array('name' => 'cl_es_id', 'oper' => '=', 'value' => $esId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        if(!$all){
            $where[]    = array('name' => 'cl_shop_show', 'oper' => '=', 'value' => 1);
        }

        $where[]    = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time);
        if($isIndex){
            $where[]    = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time);
            //不限制新人领取
            $where[]    = array('name' => 'cl_new_limit', 'oper' => '=', 'value' => 0);
            //不需要分享
            $where[]    = array('name' => 'cl_need_share', 'oper' => '=', 'value' => 0);
        }
        //新增只查询可以领取的优惠券
        $where[]    = array('name' => 'cl_coupon_type', 'oper' => '=', 'value' => 0);
        $sort   = array('cl_top'=>'DESC','cl_sort'=>'DESC','cl_start_time' => 'ASC');

        return  $this->getList($where, $index, $count, $sort);
    }
    /*
     * 获取可以积分兑换的优惠券列表信息
     */
    public function fetchPointsCouponList($sid, $index = 0, $count = 10, $esId=0){
        $time       = time();
        $where[]    = array('name' => 'cl_es_id', 'oper' => '=', 'value' => $esId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time);
        $where[]    = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time);
        //查询可以积分兑换的优惠券
        $where[]    = array('name' => 'cl_coupon_type', 'oper' => '=', 'value' => 1);
        $sort   = array('cl_start_time' => 'ASC');

        return  $this->getList($where, $index, $count, $sort);
    }
    /*
     * 获取可以积分兑换的优惠的数量
     */
    public function fetchPointsCouponCount($sid, $esId=0){
        $time       = time();
        $where[]    = array('name' => 'cl_es_id', 'oper' => '=', 'value' => $esId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cl_start_time', 'oper' => '<', 'value' => $time);
        $where[]    = array('name' => 'cl_end_time', 'oper' => '>', 'value' => $time);
        //查询可以积分兑换的优惠券
        $where[]    = array('name' => 'cl_coupon_type', 'oper' => '=', 'value' => 1);
        return $this->getCount($where);
    }

    /*
     * 获取优惠券
     */
    public function getCoupon($cid, $sid) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $cid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
    }

    /*
     * 设置优惠券领取数量或者兑换数量自增
     */
    public function incrementReceiveCount($cid, $num = 1, $esId=0) {
        $field  = array('cl_had_receive');
        $inc    = array($num);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $cid);
//        $where[]    = array('name' => 'cl_es_id', 'oper' => '=', 'value' => $esId);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 设置优惠券使用数量自增
     */
    public function incrementUsedCount($cid, $num = 1) {
        $field  = array('cl_had_used');
        $inc    = array($num);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $cid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /**
     * 获取我的优惠券
     */
    public function fetch($mid)
    {

    }

    /*
     * 获得收藏列表
     */
    public function getCommunityShopList($where,$index,$count,$sort){
        $sql = "select cl.*,es.es_name,es.es_id,es_logo,es.es_deleted ";
        $sql .= " from `".DB::table($this->_table)."` cl ";
        $sql .= " left join `pre_enter_shop` es on es.es_id = cl.cl_es_id ";
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

    /*
    * 获得收藏列表
    */
    public function getCommunityShopCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` cl ";
        $sql .= " left join `pre_enter_shop` es on es.es_id = cl.cl_es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得收藏列表
     */
    public function getCityShopList($where,$index,$count,$sort){
        $sql = "select cl.*,acs.acs_name,acs.acs_id,acs.acs_img,es.es_name,es.es_id,es_logo ";
        $sql .= " from `".DB::table($this->_table)."` cl ";
        $sql .= " left join `pre_enter_shop` es on es.es_id = cl.cl_es_id ";
        $sql .= " left join `pre_applet_city_shop` acs on acs.acs_es_id = es.es_id ";
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

    /*
     * 获得收藏列表
     */
    public function getCityShopCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` cl ";
        $sql .= " left join `pre_enter_shop` es on es.es_id = cl.cl_es_id ";
        $sql .= " left join `pre_applet_city_shop` acs on acs.acs_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 设置优惠券发放数量自增
     */
    public function incrementCount($cid, $num = 1) {
        $field  = array('cl_count');
        $inc    = array($num);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $cid);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

}
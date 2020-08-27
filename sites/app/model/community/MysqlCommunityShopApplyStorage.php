<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityShopApplyStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $community_kind;
    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table = 'applet_community_shop_apply';
        $this->_pk = 'acsa_id';
        $this->_shopId = 'acsa_s_id';
        $this->_df = 'acsa_deleted';
        $this->sid = $sid;
        $this->community_kind = 'applet_community_kind';
    }

    /*
     * 通过店铺id和订单编号获取申请信息
     */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acsa_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 根据手机获得申请信息
     */
    public function findRowByMobile($mobile,$mid = 0) {
        $where[]    = array('name' => 'acsa_mobile', 'oper' => '=', 'value' => $mobile);
        $where[]    = array('name' => 'acsa_status', 'oper' => '>' , 'value' => 0);//只查找已支付的
        if($mid){
            $where[]    = array('name' => 'acsa_m_id', 'oper' => '<>' , 'value' => $mid); //排除mid
        }
        $ret = $this->getRow($where);

        return $ret;
    }
    //根据店铺名称获得申请信息
    public function findRowByName($name){
        $where[]    = array('name' => 'acsa_shop_name', 'oper' => '=', 'value' => $name);
        $where[]    = array('name' => 'acsa_status', 'oper' => '>' , 'value' => 0);//只查找已支付的
        $ret        = $this->getRow($where);
        return $ret;
    }

    /*
     * 根据会员id获得申请信息
     */
    public function findRowByMid($mid) {
        $where[]    = array('name' => 'acsa_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'acsa_status', 'oper' => '>' , 'value' => 0);//只查找已支付的
        $ret = $this->getRow($where);
        return $ret;
    }

     /*
     * 根据会员id获得申请信息
      * 无论是否删除都可以获得信息
     */
    public function findRowByMidNoDelete($mid,$noDelVerify = true) {
        $where[]    = array('name' => 'acsa_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'acsa_status', 'oper' => '>' , 'value' => 0);
        if(!$noDelVerify){
            $where[]    = array('name' => 'acsa_deleted', 'oper' => '=', 'value' => 0);//未删除
        }
        $sql = "select * ";
        $sql .= ' from `'.DB::table($this->_table).'` es ';
        $sql .= $this->formatWhereSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;

    }

    /*
     * 获得申请表 关联分类
     */
    public function getListKindAction($where,$index,$count,$sort){
        $sql = "select acsa.*,ack1.ack_name as cate1,ack2.ack_name as cate2 ";
        $sql .= " from `".DB::table($this->_table)."` acsa ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack1 ON acsa.acsa_cate1 = ack1.ack_id ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack2 ON acsa.acsa_cate2 = ack2.ack_id ";
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
     * 获得单条申请 关联分类
     */
    public function getRowKindAction($where){
        $sql = "select acsa.*,ack1.ack_name as cate1,ack2.ack_name as cate2 ";
        $sql .= " from `".DB::table($this->_table)."` acsa ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack1 ON acsa.acsa_cate1 = ack1.ack_id ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack2 ON acsa.acsa_cate2 = ack2.ack_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}
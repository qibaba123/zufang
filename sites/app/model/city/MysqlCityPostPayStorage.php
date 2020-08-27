<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityPostPayStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_city_post_pay';
        $this->_pk     = 'cpp_id';
        $this->_shopId = 'cpp_s_id';

        $this->sid     = $sid;
    }

    /*
      * 通过店铺id和订单编号获取帖子信息
      */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'cpp_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 获取收益数量
     */
    public function getProfitCount($where){
        $sql = "select count(*) from (select count(*), FROM_UNIXTIME(cpp_create_time, '%Y-%m-%d') as day ";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= $this->formatWhereSql($where);
        $sql .= "  group by day) as ct";
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取收益记录
     */
    public function getProfitList($where, $index, $count, $sort){
        $sql = "select sum(cpp_money) as total, FROM_UNIXTIME(cpp_create_time, '%Y-%m-%d') as day ";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= $this->formatWhereSql($where);
        $sql .= " group by day";
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
     * 收益总数
     */
    public function getProfitTotal($where){
        $sql = "select sum(cpp_money)";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 获取收益数量
     * 不根据 日 分组
     * 关联用户表 店铺表
     */
    public function getProfitCountAll($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= " left join pre_member m on m.m_id = cpp.cpp_m_id";
        $sql .= " left join pre_applet_city_shop acs on cpp.cpp_acs_id = acs.acs_id";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getProfitMoneyAll($where){
        $sql = "select sum(cpp_money) as total ";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= " left join pre_member m on m.m_id = cpp.cpp_m_id";
        $sql .= " left join pre_applet_city_shop acs on cpp.cpp_acs_id = acs.acs_id";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function fetchPostProfitGroupByDate($where){
        $sql  = 'SELECT sum(cpp_money) as total, FROM_UNIXTIME (`cpp_create_time`,"%m/%d") AS curr_date ';
        $sql .= ' FROM '.DB::table($this->_table).' cpp ';
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function fetchPostProfitGroupByTime($where){
        $sql  = 'SELECT sum(cpp_money) as total, FROM_UNIXTIME (`cpp_create_time`,"%H") AS curr_date ';
        $sql .= ' FROM '.DB::table($this->_table).' cpp ';
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 获取收益记录
     * 不根据 日 分组
     * 关联用户表 店铺表
     */
    public function getProfitListAll($where, $index, $count, $sort){
        $sql = "select cpp.*,acc.*,acs.acs_name,acs.acs_img,m.m_nickname,m.m_avatar  ";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= " left join pre_member m on m.m_id = cpp.cpp_m_id";
        $sql .= " left join pre_applet_city_shop acs on cpp.cpp_acs_id = acs.acs_id";
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
     * 获得指定条件当天收益数量
     */
    public function getTodayProfitSum($where){
        $date = strtotime(date('Y-m-d',time()));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'cpp_create_time', 'oper' => '>', 'value' => $date);
        $sql = "select sum(cpp_money) as total ";
        $sql .= " from `".DB::table($this->_table)."` cpp ";
        $sql .= " left join pre_applet_city_category acc on cpp.cpp_acc_id = acc.acc_id";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}
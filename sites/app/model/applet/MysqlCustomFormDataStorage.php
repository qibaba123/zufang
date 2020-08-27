<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/8
 * Time: 下午6:34
 */
class App_Model_Applet_MysqlCustomFormDataStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $member_table;//店铺id
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_custom_form_data';
        $this->_pk      = 'acfd_id';
        $this->_shopId  = 'acfd_s_id';
        $this->member_table = DB::table('member');

        $this->sid      = $sid;
    }

    /**
     * 获取表单信息及填写人信息
     */
    public function getListMember($where,$index,$count,$sort){
        $sql = "select acfd.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` acfd ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acfd.acfd_m_id ";

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

    public function getListMemberCar($where,$index,$count,$sort){
        $sql = "select acfd.*,m.m_id,m.m_nickname,m.m_avatar,cb.cb_name,ct.ct_name ";
        $sql .= " from `".DB::table($this->_table)."` acfd ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acfd.acfd_m_id ";
        $sql .= " left join pre_car_brand cb on cb.cb_id = acfd.acfd_car_brand ";
        $sql .= " left join pre_car_type ct on ct.ct_id = acfd.acfd_car_type ";

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
     * 获取表单信息及填写人信息
     */
    public function getRowMember($where){
        $sql = "select acfd.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` acfd ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acfd.acfd_m_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 统计信息
     */
    public function getSum($where){
        $where[] = array('name' => 'acfd_deleted', 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(acfd_id) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}
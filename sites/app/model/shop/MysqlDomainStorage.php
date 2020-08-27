<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/5
 * Time: 下午2:39
 */
class App_Model_Shop_MysqlDomainStorage extends Libs_Mvc_Model_BaseModel {

    private $shop_table;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'shop_domain';
        $this->_pk      = 'sd_id';
        $this->_shopId  = 'sd_s_id';
        $this->shop_table = DB::table('shop');
    }

    /*
     * 通过店铺id获取
     */
    public function findUpdateOrderBySid($sid, $data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getShopList($where = array(), $index = 0, $count = 20, $sort = array(), $field = array(), $primary = false) {
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` sd";
        $sql .= " left join pre_shop s on s_id = sd_s_id ";
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

    public function getShopCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` sd";
        $sql .= " left join pre_shop s on s_id = sd_s_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取可用的绑定域名
     */
    public function findDomainBySid($sid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'sd_status', 'oper' => '=', 'value' => 2);//审核通过的可用

        return $this->getRow($where);
    }

    public function checkDomain($domain,$id){
        $where[]    = array('name' => 'sd_domain', 'oper' => '=', 'value' => $domain);
        if($id){
            $where[]    = array('name' => 'sd_id', 'oper' => '!=', 'value' => $id);
        }
        return $this->getCount($where);
    }

    /**
     * 根据公司ID获取代理商的信息
     */
    public function getShopDomainByCid($cid){
        $where[] = array('name'=>'s_c_id','oper'=>'=','value'=>$cid);

        $sql = 'select sd.*';
        $sql .= ' from `'.DB::table($this->_table).'` sd ';
        $sql .= ' left join '.$this->shop_table.' s on s.s_id = sd.sd_s_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
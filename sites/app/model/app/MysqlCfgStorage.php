<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_App_MysqlCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $shop_table = '';
    public function __construct() {
        parent::__construct();
        $this->_table   = 'app_cfg';
        $this->_pk      = 'ac_id';
        $this->_shopId  = 'ac_s_id';
        $this->shop_table = DB::table('shop');
    }

    /*
     * 通过店铺id查找微信配置
     */
    public function findRowBySid($sid) {
        return $this->getRow($this->getWhereBySid($sid));
    }

    public function updateBySId($set,$sid){
        return $this->updateValue($set,$this->getWhereBySid($sid));
    }

    public function getCountBySid($sid){
        return $this->getCount($this->getWhereBySid($sid));
    }

    private function getWhereBySid($sid){
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        return $where;
    }
    /**
     * @param $sid
     * @param null $data
     * @return array|bool
     * 用于后台处理逻辑，不固定某个店铺
     */
    public function fetchUpdateCfgBySid($sid,$data = null){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @return array|bool
     * 连店铺表shop查询
     */
    public function getShopList($where,$index,$count,$sort){
        $sql = 'select  ac.*,s_name ,s_id';
        $sql .= ' from `'.DB::table($this->_table).'` ac';
        $sql .= ' left join '.$this->shop_table.' s on s_id='.$this->_shopId.' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getShopCount($where){
        $sql = 'select  count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` ac';
        $sql .= ' left join '.$this->shop_table.' s on s_id='.$this->_shopId.' ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/23
 * Time: 上午12:40
 */
class App_Model_Store_MysqlStoreCfgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $shop_table = '';
    public function __construct($sid){
        parent::__construct();
        $this->_table 	= 'offline_cfg';
        $this->_pk 		= 'oc_id';
        $this->_shopId 	= 'oc_s_id';
        $this->sid  = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * @param null $data
     * @return array|bool
     * 获取、更新单行配置
     */
    public function fetchUpdateCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * @param null $data
     * @return array|bool
     * 获取、更新单行配置
     */
    public function fetchUpdateCfgBySid($sid,$data = null) {
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
        $sql = 'select  oc.*,s_name,s_id ';
        $sql .= ' from `'.DB::table($this->_table).'` oc';
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
        $sql .= ' from `'.DB::table($this->_table).'` oc';
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
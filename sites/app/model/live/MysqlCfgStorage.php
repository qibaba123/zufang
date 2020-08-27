<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/2/16
 * Time: 下午6:41
 */
class App_Model_Live_MysqlCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'live_cfg';
        $this->_pk      = 'lc_id';
        $this->_shopId  = 'lc_s_id';

        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
     * 获取店铺配置
     */
    public function findShopCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
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
        $sql = 'select  rc.*,s_name,s_id ';
        $sql .= ' from `'.DB::table($this->_table).'` rc';
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
        $sql .= ' from `'.DB::table($this->_table).'` rc';
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
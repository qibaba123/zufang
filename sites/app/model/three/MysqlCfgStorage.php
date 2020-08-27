<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/2
 * Time: 下午3:25
 */
class App_Model_Three_MysqlCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $shop_table = '';

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'three_cfg';
        $this->_pk      = 'tc_id';
        $this->_shopId  = 'tc_s_id';

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
    public function hasStart(){
        $has_start  = 1;
        $config     = $this->findShopCfg();
        //未订购,或已过期
        if (!$config || $config['tc_expire_time'] < time()) {
            $has_start = 0;
        }
        return $has_start;
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
        $sql = 'select  tc.*,s_name,s_id ';
        $sql .= ' from `'.DB::table($this->_table).'` tc';
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
        $sql .= ' from `'.DB::table($this->_table).'` tc';
        $sql .= ' left join '.$this->shop_table.' s on s_id='.$this->_shopId.' ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @return array|bool
     * 合伙人页面设置信息，如果没有，取默认值
     */
    public function getRowValue(){
        $row         = $this->findShopCfg();
        $df_value    = plum_parse_config('branch_cfg','value');
        if(empty($row['tc_fx_banner'])) $row['tc_fx_banner'] = $df_value['tc_fx_banner'];
        if(empty($row['tc_fx_desc'])) $row['tc_fx_desc']     = $df_value['tc_fx_desc'];
        if(empty($row['tc_fx_privilege'])) $row['tc_fx_privilege'] = json_encode($df_value['tc_fx_privilege']);
        return $row;
    }

}
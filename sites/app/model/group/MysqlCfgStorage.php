<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/21
 * Time: 下午4:48
 * 拼团购设置
 */
class App_Model_Group_MysqlCfgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;
    private $shop_table;

    public function __construct($sid = null){
        $this->_table 	= 'group_cfg';
        $this->_pk 		= 'gc_id';
        $this->_shopId 	= 'gc_s_id';
        parent::__construct();

        $this->sid         = $sid;
        $this->curr_table  = DB::table($this->_table);
        $this->shop_table = DB::table('shop');

    }

    public function getRowUpdata($data=array()) {
        $where   = array();
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        if(!empty($data)){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

    public function findShopCfg($data=array()){
        return $this->getRowUpdata($data);
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
        $sql = 'select  gc.*,s_name ,s_id';
        $sql .= ' from `'.DB::table($this->_table).'` gc';
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
        $sql .= ' from `'.DB::table($this->_table).'` gc';
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
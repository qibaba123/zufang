<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/21
 * Time: 下午8:20
 */
class App_Model_Shop_MysqlIndexTplStorage extends Libs_Mvc_Model_BaseModel{

    private $shop_table='';
    public function __construct(){
        $this->_table 	= 'index_tpl';
        $this->_pk 		= 'it_id';
        $this->_shopId 	= 'it_s_id';
        parent::__construct();
        $this->shop_table = DB::table('shop');
    }

    public function getShopList($where, $index, $count, $sort){
        $sql = 'select * ';
        $sql .= 'from `'.DB::table($this->_table).'` it ';
        $sql .= ' left join '.$this->shop_table.' s on s_id='.$this->_shopId;
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
        $sql = 'select count(*) ';
        $sql .= 'from `'.DB::table($this->_table).'` it ';
        $sql .= ' left join '.$this->shop_table.' s on s_id='.$this->_shopId;
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $sid
     * @param int $index
     * @param int $count
     * @param array $sort
     * @return array|bool
     * 获取本店和公有模版
     */
    public function getListBySid($sid,$index=0,$count=20,$sort=array('it_weight'=>'DESC','it_update_time'=>'DESC')){
        $sids       = array(0,$sid);
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => 'in', 'value' => $sids);
        return $this->getList($where,$index,$count,$sort);
    }

    /**
     * @param $sid
     * @param $type
     * @param int $index
     * @param int $count
     * @param array $sort
     * @return array|bool
     * 根据类型获取本店和公有模版
     */
    public function getListBySidType($sid,$type=1,$index=0,$count=20,$sort=array('it_weight'=>'DESC','it_update_time'=>'DESC')){
        $sids       = array(0,$sid);
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => 'in', 'value' => $sids);
        $where[]    = array('name' => 'it_type', 'oper' => '=', 'value' => $type);
        return $this->getList($where,$index,$count,$sort);
    }

    /**
     * @param $id
     * @param $sid
     * @return array|bool
     * 检查某个模版，该店铺是否可以使用
     */
    public function getRowBySid($id,$sid){
        $sids       = array(0,$sid);
        $where      = array();
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => $this->_shopId, 'oper' => 'in', 'value' => $sids);
        return $this->getRow($where);
    }

    /** ******       新版        **************
     * @param $tid  // 模板ID
     * @param $sid
     * @param $type
     * @param int $index
     * @param int $count
     * @param array $sort
     * @return array|bool
     * 根据类型获取本店和公有模版
     */
    public function getListByTidSidType($tid,$sid,$type=1,$index=0,$count=20,$sort=array('it_weight'=>'DESC','it_update_time'=>'DESC')){
        $sids       = array(0,$sid);
        $where      = array();
        $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => 'in', 'value' => $sids);
        $where[]    = array('name' => 'it_type', 'oper' => '=', 'value' => $type);
        return $this->getList($where,$index,$count,$sort);
    }



}
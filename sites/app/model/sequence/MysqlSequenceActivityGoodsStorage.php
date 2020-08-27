<?php
/*
 * 社区团购 活动商品表
 */
class App_Model_Sequence_MysqlSequenceActivityGoodsStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $goods_table;
    private $activity_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_activity_goods';
        $this->_pk = 'asag_id';
        $this->_shopId = 'asag_s_id';
        $this->goods_table = DB::table('goods');
        $this->activity_table = DB::table('applet_sequence_activity');
        $this->sid = $sid;
    }

    public function getListByAid($aid)
    {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asag_a_id', 'oper' => '=', 'value' => $aid);
        return $this->getList($where,0,0);
    }


    /*
     * 获得活动关联的商品列表
     */
    public function fetchGoodsList($where,$index,$count,$sort) {

        $sql = "SELECT asag.*,g.* ";
        $sql .= " FROM ".DB::table($this->_table)." asag ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=asag.asag_g_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function fetchGoodsCount($where) {

        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asag ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=asag.asag_g_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据活动id和商品id，查找关联信息 关联商品列表,活动表
     */
    public function fetchGoodsRow($aid,$gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asag_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'asag_g_id', 'oper' => '=', 'value' => $gid);
        $sql = "SELECT asag.*,g.*,asa.* ";
        $sql .= " FROM ".DB::table($this->_table)." asag ";
        $sql .= " LEFT JOIN ".$this->goods_table." g on g.g_id=asag.asag_g_id ";
        $sql .= " LEFT JOIN ".$this->activity_table." asa on asa.asa_id=asag.asag_a_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 根据活动id和商品id，查找关联信息
     */
    public function fetchRow($aid,$gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'asag_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'asag_g_id', 'oper' => '=', 'value' => $gid);

        return $this->getRow($where);
    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`asag_id`, `asag_s_id`,  `asag_a_id`, `asag_g_id`, `asag_sort`, `asag_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }


}
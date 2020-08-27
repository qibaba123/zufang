<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/17
 * Time: 上午午9:40
 */
class App_Model_Smart_MysqlStoreStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_store_store';
        $this->_pk 		= 'ass_id';
        $this->_shopId 	= 'ass_s_id';
        $this->_df      = 'ass_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }
    /*
     * 获取由近及远门店列表,全部取出,不分页
     */
    public function fetchListOrderLocation($lat, $lng, $where=array(), $index=0, $count=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT os.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-os_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(os_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-os_lat)/360),2)))) distance ';
        $sql .= "FROM ".DB::table($this->_table).' os ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' ORDER BY distance ASC ';
        $sql .= $this->formatLimitSql($index, $count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取门店详情
     */
    public function findStoreById($stid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $stid);

        return $this->getRow($where);
    }

    /**
     * 查询本店所有门店
     */
    public function getAllListBySid(){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort       = array($this->_pk => 'DESC');
        return $this->getList($where,0,0,$sort,array(),true);
    }

    public function clearIsHeader(){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $set = array(
            'os_is_head' => 0
        );
        return $this->updateValue($set,$where);
    }
}
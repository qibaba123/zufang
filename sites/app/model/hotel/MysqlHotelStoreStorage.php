<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Hotel_MysqlHotelStoreStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $manage_table;
    public function __construct($sid){
        $this->_table 	= 'applet_hotel_store';
        $this->_pk 		= 'ahs_id';
        $this->_shopId 	= 'ahs_s_id';
        $this->_df 	    = 'ahs_deleted';
        parent::__construct();
        $this->sid  = $sid;
        $this->manage_table = DB::table('enter_shop_manager');
    }

    /**
     * @return array|bool
     * 获取活动列表
     */
    public function findListBySid() {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ahs_deleted','oper'=>'=','value'=>0);
        return $this->getList($where,0,0,array('ahs_create_time'=>'DESC'));
    }

    /*
     * 获取由近及远门店列表,全部取出,不分页
     */
    public function fetchListOrderLocation($lat, $lng) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT ahs.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ahs_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ahs_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ahs_lat)/360),2)))) distance ';
        $sql .= "FROM ".DB::table($this->_table).' ahs ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' ORDER BY distance ASC ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取由近及远门店列表
     */
    public function fetchListOrderLimitLocation($lat, $lng, $count=0, $ids=array()) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        if($ids && !empty($ids)){
            $count = 0;
            $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $ids);
        }
        $sql = 'SELECT ahs.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ahs_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ahs_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ahs_lat)/360),2)))) distance ';
        $sql .= "FROM ".DB::table($this->_table).' ahs ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' ORDER BY distance ASC ';
        $sql .= $this->formatLimitSql(0,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListEntershop($where,$index,$count,$sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT * ';
        $sql .= "FROM ".DB::table($this->_table).' ahs ';
        $sql .= 'LEFT JOIN `'.$this->manage_table.'` esm on ahs.ahs_es_id = esm.esm_es_id AND ahs_es_id > 0 ';
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

    public function findRowByEsId($esId){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $where[]    = array('name' => 'ahs_es_id', 'oper' => '=', 'value' => $esId);
        return $this->getRow($where);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Meal_MysqlMealStoreStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $enter_shop_table;
    private $enter_shop_manager;
    public function __construct($sid){
        $this->_table 	= 'applet_meal_store';
        $this->_pk 		= 'ams_id';
        $this->_shopId 	= 'ams_s_id';
        $this->_df 	    = 'ams_deleted';
        $this->enter_shop_table = 'enter_shop';
        $this->enter_shop_manager = 'enter_shop_manager';
        parent::__construct();
        $this->sid  = $sid;
    }

    /**
     * @return array|bool
     * 获取门店列表  不关联enter_shop表
     */
    public function findListBySid() {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ams_deleted','oper'=>'=','value'=>0);
        return $this->getList($where,0,0,array('ams_create_time'=>'DESC'));
    }

    /*
     * 门店首页配置
     */
    public function findUpdateByEsId($esId,$data = array()){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ams_es_id', 'oper' => '=', 'value' => $esId);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获取门店列表
     */
    public function fetchStoreList($where,$index,$count ,$sort) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT ams.*,es.es_id,es.es_name,es.es_logo,es.es_qrcode,esm.esm_mobile,esm.esm_password,esm.esm_id,m.m_show_id,m.m_nickname ';
        $sql .= " FROM ".DB::table($this->_table).' ams ';
        $sql .= " LEFT JOIN `pre_member` m on ams.ams_m_id = m.m_id ";
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_table).' es on ams.ams_es_id = es.es_id ';
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_manager).' esm on ams.ams_es_id = esm.esm_es_id AND ams.ams_s_id = esm.esm_s_id ';
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

    /*
     * 获取由近及远门店列表
     */
    public function fetchStoreListLocation($lat, $lng ,$where,$index,$count, $sort='distance') {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT ams.*,es.es_id,es.es_name,es.es_qrcode,es.es_logo,es.es_hand_close,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ams_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ams_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ams_lat)/360),2)))) distance,';
        $sql .= "(case  when ams.ams_open_time = '' or ams.ams_close_time = '' or ams.ams_open_time is null or ams.ams_close_time is null then 1  when unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) < unix_timestamp(concat(curdate(),' ',ams.ams_close_time))  AND unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) < unix_timestamp()  AND unix_timestamp(concat(curdate(),' ',ams.ams_close_time)) > unix_timestamp() then 1  when unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) >= unix_timestamp(concat(curdate(),' ',ams.ams_close_time))  AND ((unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) <= unix_timestamp() AND unix_timestamp() <=unix_timestamp(concat(curdate(),' ','23:59'))) OR  (unix_timestamp(concat(curdate(),' ',ams.ams_close_time)) >= unix_timestamp() AND  unix_timestamp(concat(curdate(),' ','0:00')) <= unix_timestamp())) then 1  else 2 end) as openStatus ,`ams_open_time`,`ams_close_time` ";
        $sql .= " FROM ".DB::table($this->_table).' ams ';
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_table).' es on ams.ams_es_id = es.es_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' ORDER BY es.es_hand_close ASC,openStatus ASC, ';
        if($sort == 'distance'){
            $sql .= 'distance ASC';
        }
        if($sort == 'hot'){
            $sql .= 'es_show_num DESC';
        }
        if($sort == 'sale'){
            $sql .= 'es_show_num DESC';
        }
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

     /*
     * 获得门店详情
      * 关联enter_shop表
     */
    public function fetchStoreDetail($esId) {
        $where[] = array('name'=>'ams_es_id' , 'oper'=>'=', 'value'=>$esId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = 'SELECT ams.*,es.es_id,es.es_name,es.es_logo,es.es_hand_close,es.es_qrcode,es.es_maid_proportion,es.es_cash_proportion,es_auto_receive_order,esm.esm_mobile,esm.esm_password,esm.esm_id,es.es_share_post_ratio ';
        $sql .= " FROM ".DB::table($this->_table).' ams ';
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_table).' es on ams.ams_es_id = es.es_id ';
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_manager).' esm on ams.ams_es_id = esm.esm_es_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
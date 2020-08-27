<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/17
 * Time: 上午午9:40
 */
class App_Model_Store_MysqlStoreStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid = 0){
        $this->_table 	= 'offline_store';
        $this->_pk 		= 'os_id';
        $this->_shopId 	= 'os_s_id';
        $this->_df      = 'os_is_deleted';
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

    /*
     * 获得自提门店数量
     */
    public function getReceiveStoreCount(){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'os_receive_store','oper' => '=','value' =>1);
        return $this->getCount($where);
    }

    /*
     * 根据管理员手机号获得自提门店信息
     */
    public function findRowByManagerMobile($mobile,$id=0) {
        $where[]    = array('name' => 'os_manager_mobile', 'oper' => '=', 'value' => $mobile);
        if($id){
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $id);//排除自身
        }
        $ret = $this->getRow($where);

        return $ret;
    }

    /*
     * 获得自提门店列表 关联地区表
     */
    public function getListRegion($where=array(), $index=0, $count=0, $sort = array()) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        $sql = 'SELECT os.*,ca1.region_name as city_name,ca2.region_name as zone_name ';
        $sql .= "FROM `pre_offline_store` os ";
        $sql .= "LEFT JOIN  `dpl_china_address` ca1 on os.os_city = ca1.region_id ";
        $sql .= "LEFT JOIN  `dpl_china_address` ca2 on os.os_zone = ca2.region_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index, $count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
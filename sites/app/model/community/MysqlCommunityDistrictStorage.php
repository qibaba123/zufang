<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityDistrictStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid = 0)
    {
        parent::__construct();
        $this->_table = 'applet_community_district';
        $this->_pk = 'acd_id';
        $this->_shopId = 'acd_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * @return array|bool
     * 获取店铺所有商圈
     */
    public function getListBySid($cityId = 0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'acd_deleted','oper' => '=','value' =>0);
        if($cityId){
            $where[]    = array('name' => 'acd_city_id','oper' => '=','value' =>$cityId);
        }
        $sort       = array('acd_sort' => 'ASC');
        $field      = array('acd_id','acd_area_id','acd_city_id','acd_area_name','acd_name','acd_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }

    /**
     * @return array|bool
     * 获取店铺所有商圈
     */
    public function getListCityBySid(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'acd_deleted','oper' => '=','value' =>0);
        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."` acd ";
        $sql .= " left join pre_china_address addr on acd.acd_city_id = addr.region_id ";
        $sort       = array('acd_city_id' => 'ASC','acd_sort' => 'ASC');
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,0);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取所有的城市
     */
    public function getCityList(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'acd_deleted','oper' => '=','value' =>0);
        $sql = "select acd_city_id, region_name";
        $sql .= " from `".DB::table($this->_table)."` acd ";
        $sql .= " left join pre_china_address addr on acd.acd_city_id = addr.region_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " group by acd_city_id";
        $sql .= $this->formatLimitSql(0,0);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
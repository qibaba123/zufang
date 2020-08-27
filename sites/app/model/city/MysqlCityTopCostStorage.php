<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityTopCostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_top_cost';
        $this->_pk = 'act_id';
        $this->_shopId = 'act_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    /*
    * 通过店铺id和订单编号获取帖子信息
    */
    public function findRowByActid($actid) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'act_id', 'oper' => '=', 'value' => $actid);
        return $this->getRow($where);

    }
    /**
     * 根据店铺id查询所有的置顶信息
     */
    public function findListBySid() {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where,0,0,array('act_data'=>'ASC'));
    }

    /*
     * 获得所有店铺id
     */
    public function getAllSid(){
        $sql = "select act_s_id,act_cost from `pre_applet_city_top_cost` where act_data = 30 group by act_s_id";
        $ret = DB::fetch_all($sql);
        return $ret;
    }

    /**
	 * @param $value
	 * @return bool
	 * 批量插入
	 */
	public function insertBacth($value){
		$sql  = 'INSERT INTO '.DB::table($this->_table);
		$sql .= ' (`act_id`, `act_s_id`, `act_data`, `act_cost`, `act_update_time`) ';
		$sql .= ' VALUES ';
		$sql .= implode(',',$value);
		$ret = DB::query($sql);

		if ($ret === false) {
			trigger_error("query mysql failed.", E_USER_ERROR);
			return false;
		}
		return $ret;
	}
}
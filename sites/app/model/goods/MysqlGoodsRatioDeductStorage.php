<?php

class App_Model_Goods_MysqlGoodsRatioDeductStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
	public function __construct($sid = null){
		$this->_table 	= 'goods_ratio_deduct';
		$this->_pk 		= 'grd_id';
		$this->_shopId 	= 'grd_s_id';
		parent::__construct();

        $this->sid      = $sid;
	}

    public function getGoodsList($where, $index, $count, $sort){
        $sql = "select grd.*,g.g_name,g.g_id,g.g_cover,g.g_price ";
        $sql .= " from `".DB::table($this->_table)."` grd ";
        $sql .= " left join pre_goods g on grd.grd_g_id = g.g_id ";

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

    public function getListByGids(array $gids){
        $where      = array();
        $where[]    = array('name' => 'grd_g_id', 'oper' => 'in', 'value' => $gids);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $list = $this->getList($where,0,0);
        $data = array();
        foreach($list as $val){
            $data[$val['grd_g_id']] = $val;
        }
        return $data;
    }

    public function fetchUpdateRow($gid,$data=array()){
        $where      = array();
        $where[]    = array('name' => 'grd_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($data)){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

    /*
     * 查找开启中的商品分佣设置
     */
    public function findOpenDeduct($gid) {
        $where[]    = array('name' => 'grd_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'grd_is_used', 'oper' => '=', 'value' => 1);//启用中

        return $this->getRow($where);
    }
}
<?php

class App_Model_Goods_MysqlDeductStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
	public function __construct($sid = null){
		$this->_table 	= 'goods_deduct';
		$this->_pk 		= 'gd_id';
		$this->_shopId 	= 'gd_s_id';
		parent::__construct();

        $this->sid      = $sid;
	}

    public function getGoodsList($where, $index, $count, $sort){
        $sql = "select gd.*,g.g_name,g.g_id,g.g_cover,g.g_price,g.g_kind1,g.g_independent_mall ";
        $sql .= " from `".DB::table($this->_table)."` gd ";
        $sql .= " left join pre_goods g on gd.gd_g_id = g.g_id ";

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

    public function getCourseList($where, $index, $count, $sort){
        $sql = "select gd.*,atc.atc_title as g_name,atc.atc_id as g_id,atc.atc_price as g_price,atc.atc_cover as g_cover ";
        $sql .= " from `".DB::table($this->_table)."` gd ";
        $sql .= " left join pre_applet_train_course atc on gd.gd_g_id = atc.atc_id ";

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
        $where[]    = array('name' => 'gd_g_id', 'oper' => 'in', 'value' => $gids);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $list = $this->getList($where,0,0);
        $data = array();
        foreach($list as $val){
            $data[$val['gd_g_id']] = $val;
        }
        return $data;
    }

    public function fetchUpdateRow($gid,$data=array()){
        $where      = array();
        $where[]    = array('name' => 'gd_g_id', 'oper' => '=', 'value' => $gid);
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
        $where[]    = array('name' => 'gd_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gd_is_used', 'oper' => '=', 'value' => 1);//启用中

        return $this->getRow($where);
    }
}
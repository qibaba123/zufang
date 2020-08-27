<?php

class App_Model_Entershop_MysqlGoodsCategoryStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
	public function __construct($sid){
		$this->_table   = 'enter_shop_goods_category';
		$this->_pk      = 'esgc_id';
        $this->_df      = 'esgc_deleted';
        $this->_shopId  = 'esgc_s_id';
        $this->sid      = $sid;
		parent::__construct();

	}


    /**
     * @return array|bool
     * 获取店铺所有分类
     */
    public function getListBySid(){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('esgc_weight' => 'ASC');
        $field      = array('esgc_id','esgc_name','esgc_logo','esgc_weight','esgc_create_time');
        return $this->getList($where,0,0,$sort,$field,true);
    }

    /*
     * 获得商品分类
     * 关联多店店铺表或同城店铺表
     */
    public function getListShopAction($where,$index,$count,$sort,$type = ''){
        $where[] = array('name' => $this->_df,'oper' => '=','value' =>0);
        $sql = "SELECT esgc.*";
        if($type == 'city'){
            $sql .= ",acs.acs_name as shopName ";
        }else{
            $sql .= ",es.es_name as shopName ";
        }
        $sql .= "FROM `".DB::table($this->_table)."` esgc ";
        if($type == 'city'){
            $sql .= "LEFT JOIN `pre_applet_city_shop` acs on acs.acs_es_id = esgc.esgc_s_id ";
        }else{
            $sql .= "LEFT JOIN `pre_enter_shop` es on es.es_id = esgc.esgc_s_id ";
        }
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

}
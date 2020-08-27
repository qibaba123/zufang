<?php

class App_Model_Legwork_MysqlOtherLegworkCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $applet_table;
    private $enter_shop_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_other_legwork_cfg';
        $this->_pk     = 'aolc_id';
        $this->_shopId = 'aolc_s_id';
        $this->sid     = $sid;
        $this->applet_table = DB::table('applet_cfg');
        $this->enter_shop_table = DB::table('enter_shop');
    }

    /*
      * 通过店铺id
      */
    public function findUpdateBySid($data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aolc_es_id', 'oper' => '=', 'value' => 0);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    public function findUpdateBySidEsId($esId,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aolc_es_id', 'oper' => '=', 'value' => $esId);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获得小程序列表
     */
    public function getShopList($where,$index,$count,$sort){
        $sql  = 'SELECT aolc.*,ac.ac_name,ac.ac_avatar,ac.ac_type,es.es_name,es.es_logo ';
        $sql .= ' FROM '.DB::table($this->_table).' aolc ';
        $sql .= ' LEFT JOIN '.$this->applet_table.' ac on aolc.aolc_s_id = ac.ac_s_id';
        $sql .= ' LEFT JOIN '.$this->enter_shop_table.' es on aolc.aolc_es_id = es.es_id';
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
     * 获得小程序列表
     */
    public function getShopCount($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' aolc ';
        $sql .= ' LEFT JOIN '.$this->applet_table.' ac on aolc.aolc_s_id = ac.ac_s_id';
        $sql .= ' LEFT JOIN '.$this->enter_shop_table.' es on aolc.aolc_es_id = es.es_id';

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}
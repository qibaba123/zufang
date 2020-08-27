<?php

class App_Model_Mobile_MysqlMobileBrowseStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $category_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_mobile_shop_browse';
        $this->_pk     = 'msb_id';
        $this->_shopId = 'msb_s_id';
        $this->shop_table = 'applet_mobile_shop_apply';
        $this->category_table = 'applet_mobile_shop_category';
        $this->sid     = $sid;
    }

  /**
   * 根据会员ID和入驻店铺ID获取浏览记录
   */
  public function getBrowseByMidSid($mid,$sid){
    $where = array();
    $where[] = array('name'=>'msb_m_id','oper'=>'=','value'=>$mid);
    $where[] = array('name'=>'msb_ams_id','oper'=>'=','value'=>$sid);
    $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
    return $this->getRow($where);
  }

  /**
   * 根据会员ID和入驻店铺ID删除浏览记录
   */
  public function deleteBrowseByMidSid($mid,$sid){
    $where = array();
    $where[] = array('name'=>'msb_m_id','oper'=>'=','value'=>$mid);
    $where[] = array('name'=>'msb_ams_id','oper'=>'=','value'=>$sid);
    $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
    return $this->deleteValue($where);
  }

  /*
   * 获得浏览记录店铺
   */
  public function getRecordShopList($mid,$index = 0,$count = 15){
    $where = array();
    $where[]    = array('name' => 'msb_m_id', 'oper' => '=', 'value' => $mid);
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
    $sort       = array('msb_time' => 'DESC');
    $sql = 'SELECT ams.*,msb.msb_id as rid,msb.msb_time as time,amc.amc_id,amc.amc_title ';
    $sql .= "FROM ".DB::table($this->_table).' msb ';
    $sql .= " LEFT JOIN ".DB::table($this->shop_table)." ams on ams.ams_id = msb.msb_ams_id ";
    $sql .= " LEFT JOIN ".DB::table($this->category_table)." amc on amc.amc_id = ams.ams_cate_id ";
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
<?php

class App_Model_Mobile_MysqlMobileCollectionStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $category_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_mobile_shop_collection';
        $this->_pk     = 'msc_id';
        $this->_shopId = 'msc_s_id';
        $this->shop_table = 'applet_mobile_shop_apply';
        $this->category_table = 'applet_mobile_shop_category';
        $this->sid     = $sid;
    }

  /**
   * 根据会员ID和入驻店铺ID获取收藏信息
   */
  public function getCollectionByMidSid($mid,$sid){
    $where = array();
    $where[] = array('name'=>'msc_m_id','oper'=>'=','value'=>$mid);
    $where[] = array('name'=>'msc_ams_id','oper'=>'=','value'=>$sid);
    $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
    return $this->getRow($where);
  }

  /**
   * 根据会员ID和入驻店铺ID删除收藏信息
   */
  public function deleteCollectionByMidSid($mid,$sid){
    $where = array();
    $where[] = array('name'=>'msc_m_id','oper'=>'=','value'=>$mid);
    $where[] = array('name'=>'msc_ams_id','oper'=>'=','value'=>$sid);
    $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
    return $this->deleteValue($where);
  }
    /*
     * 获得收藏店铺
     */
  public function getRecordShopList($mid,$index = 0,$count = 15){
    $where = array();
    $where[]    = array('name' => 'msc_m_id', 'oper' => '=', 'value' => $mid);
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
    $sort       = array('msc_time' => 'DESC');
    $sql = 'SELECT ams.*,msc.msc_id as rid,msc.msc_time as time,amc.amc_id,amc.amc_title ';
    $sql .= "FROM ".DB::table($this->_table).' msc ';
    $sql .= " LEFT JOIN ".DB::table($this->shop_table)." ams on ams.ams_id = msc.msc_ams_id ";
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
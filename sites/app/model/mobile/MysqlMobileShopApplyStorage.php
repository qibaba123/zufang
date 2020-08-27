<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018/3/12
 * Time: 17:31
 */

class App_Model_Mobile_MysqlMobileShopApplyStorage extends Libs_Mvc_Model_BaseModel{

  private $sid;
  private $category_table;
  private $member_table;
  public function __construct($sid = null){
    $this->_table 	= 'applet_mobile_shop_apply';
    $this->_pk 		= 'ams_id';
    $this->_df      = 'ams_deleted';
    $this->_shopId 	= 'ams_s_id';
    parent::__construct();
    $this->sid  = $sid;
    $this->category_table = 'applet_mobile_shop_category';
    $this->member_table = 'member';

  }

  /*
    * 通过店铺id和订单编号获取店铺信息
    */
  public function findUpdateByNumber($number,$data=null) {
    $where      = array();
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
    $where[]    = array('name' => 'ams_number', 'oper' => '=', 'value' => $number);
    if ($data) {
      return $this->updateValue($data, $where);
    } else {
      return $this->getRow($where);
    }
  }


    /*
     * 获得公司列表
     */
  public function fetchListLocation($where,$index,$count,$sort, $lng = 0,$lat =0) {
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
    $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
    $where[]    = array('name' => 'ams_expire_time', 'oper' => '>', 'value' => time());//入驻未到期
    $where[]    = array('name'=>'ams_status','oper'=>'=','value'=>2); //审核通过
    $sql = 'SELECT ams.*,amc.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ams_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ams_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ams_lat)/360),2)))) distance ';
    $sql .= "FROM ".DB::table($this->_table).' ams ';
    $sql .= " LEFT JOIN ".DB::table($this->category_table)." amc on ams.ams_cate_id = amc.amc_id ";
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
     * 获得公司列表 会员
     */
  public function fetchListMember($where,$index,$count,$sort) {
    $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
    $sql = 'SELECT ams.*,m.m_id,m.m_nickname,m.m_show_id ';
    $sql .= "FROM ".DB::table($this->_table).' ams ';
    $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on ams.ams_m_id = m.m_id ";
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
     * 获得公司详情
     */
  public function fetchFirstLocation($id,$where, $lng = 0,$lat = 0 ,$distance = true) {
    if($id){
      $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
    }
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
    $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
    if($distance){
      $sql = 'SELECT ams.*,amc.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ams_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ams_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ams_lat)/360),2)))) distance ';
    }else{
      $sql = 'SELECT ams.*,amc.* ';
    }
    $sql .= "FROM ".DB::table($this->_table).' ams ';
    $sql .= " LEFT JOIN ".DB::table($this->category_table)." amc on ams.ams_cate_id = amc.amc_id ";
    $sql .= $this->formatWhereSql($where);
    $ret = DB::fetch_first($sql);
    if ($ret === false) {
      trigger_error("query mysql failed.", E_USER_ERROR);
      return false;
    }
    return $ret;
  }


  /**
   * 增加或减少收藏数 $operation=add添加 $operation=reduce减少
   */
  public function addShopCollectNum($sId,$operation){
    $sql  = 'UPDATE '.DB::table($this->_table);
    if($operation=='add'){
      $sql .= ' SET  ams_collection = ams_collection + 1 ';
    }
    elseif($operation=='reduce'){
      $sql .= ' SET  ams_collection = ams_collection - 1 ';
    }
    $sql .= '  WHERE '.$this->_pk .' = '.$sId;
    $ret = DB::query($sql);
    if ($ret === false) {
      trigger_error("query mysql failed.", E_USER_ERROR);
      return false;
    }
    return $ret;
  }
  /**
   * 增加或减少浏览数 $operation=add添加 $operation=reduce减少
   */
  public function addShopBrowseNum($sId,$operation){
    $sql  = 'UPDATE '.DB::table($this->_table);
    if($operation=='add'){
      $sql .= ' SET  ams_browse = ams_browse + 1 ';
    }
    elseif($operation=='reduce'){
      $sql .= ' SET  ams_browse = ams_browse - 1 ';
    }
    $sql .= '  WHERE '.$this->_pk .' = '.$sId;
    $ret = DB::query($sql);
    if ($ret === false) {
      trigger_error("query mysql failed.", E_USER_ERROR);
      return false;
    }
    return $ret;
  }

  //判断当前用户名下是否有店铺，或者正在申请中
    public function hasShopByuid($uid){
      $where = array();
      $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
      $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
      $where[]    = array('name' => 'ams_m_id', 'oper' => '=', 'value' => $uid);
      $where[]    = array('name' => 'ams_status', 'oper' => '<>', 'value' => 3);  //3 已拒绝
      $ret=$this->getList($where);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }

    /**
     * @param $where
     */
    public function getSum($where){
        $sql = 'SELECT sum(ams_browse) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}
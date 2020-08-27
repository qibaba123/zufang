<?php

class App_Model_Limit_MysqlLimitGoodsStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;
    private $act_table;
    private $course_table;
    public function __construct($sid = null){
        $this->_table 	= 'limit_goods';
        $this->_pk 		= 'lg_id';
        $this->_shopId 	= 'lg_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->act_table    = DB::table('limit_act');
        $this->course_table = DB::table('applet_train_course');
    }
    /**
     * @param $value
     * @return bool
     * 批量插入
     */
    public function insertBacth($value){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`lg_id`, `lg_s_id`, `lg_actid`, `lg_g_id`, `lg_yh_price`, `lg_limit`, `lg_stock`, `lg_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$value);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $value
     * @return bool
     * 批量插入
     */
    public function insertNewBacth($value){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`lg_id`, `lg_s_id`, `lg_actid`, `lg_g_id`, `lg_yh_price`, `lg_limit`, `lg_stock`, `lg_virtual_sold`,`lg_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$value);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $value
     * @return bool
     * 批量插入
     */
    public function insertNew2Bacth($value){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`lg_id`, `lg_s_id`, `lg_actid`, `lg_g_id`, `lg_yh_price`, `lg_limit`, `lg_stock`, `lg_virtual_sold`, `lg_view_num`, `lg_view_num_show`,`lg_create_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$value);
        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * @param $actid
     * @param $index
     * @param $count
     * @return array|bool
     * 根据活动ID获取活动商品
     */
    public function getListByActid($actid,$index=0,$count=0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'g_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lg_actid', 'oper' => '=', 'value' => $actid);
        $sql = 'SELECT lg_id, lg_g_id,lg_yh_price,lg_limit,lg_stock,lg_virtual_sold,lg_sold,lg_view_num,lg_view_num_show,g.* ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' LEFT JOIN pre_goods g on g_id=lg_g_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 培训用
     * @param $actid
     * @param $index
     * @param $count
     * @return array|bool
     * 根据活动ID获取活动课程
     */
    public function getListByActidCourse($actid,$index=0,$count=0){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'atc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lg_actid', 'oper' => '=', 'value' => $actid);
        $sql = 'SELECT lg_id, lg_g_id,lg_yh_price,lg_limit,lg_stock,atc.* ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' LEFT JOIN '.$this->course_table.' atc on atc.atc_id=lg_g_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 根据商品ID获取进行中的活动
     * 已结束的活动,不再筛选
     * $gid :商品id  $laid:活动id
     * @param int $iscurr 大于0为正在进行的秒杀活动商品
     */
    public function getActByGid($gid,$laid, $iscurr=0) {
        $curr       = time();

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lg_g_id', 'oper' => '=', 'value' => $gid);

        if ($iscurr) {
            $where[]    = array('name' => 'la_start_time', 'oper' => '<', 'value' => $curr);
            $where[]    = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        }

        $where[]    = array('name' => 'la_deleted', 'oper' => '=', 'value' => 0);
        if($laid){
            $where[]    = array('name' => 'la_id', 'oper' => '=', 'value' => $laid);
        }
        $sort   = array('lg_create_time' => 'ASC');
        
        $sql    = "SELECT la.*,lg.* FROM `{$this->curr_table}` AS lg ";
        $sql    .= "LEFT JOIN `{$this->act_table}` AS la ON lg.lg_actid=la.la_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret  = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 根据商品ID获取进行中的活动
     * 已结束的活动和未开始的,不再筛选
     * $gid :商品id  $laid:活动id
     */
    public function getActingByGid($gid,$laid) {
        $curr       = time();

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lg_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'la_start_time', 'oper' => '<', 'value' => $curr);
        $where[]    = array('name' => 'la_end_time', 'oper' => '>', 'value' => $curr);
        $where[]    = array('name' => 'la_deleted', 'oper' => '=', 'value' => 0);
        if($laid){
            $where[]    = array('name' => 'la_id', 'oper' => '=', 'value' => $laid);
        }
        $sort   = array('lg_create_time' => 'ASC');

        $sql    = "SELECT la.*,lg.* FROM `{$this->curr_table}` AS lg ";
        $sql    .= "LEFT JOIN `{$this->act_table}` AS la ON lg.lg_actid=la.la_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret  = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $actid
     * @return array|bool
     * 根据活动ID删除活动商品
     */
    public function deleteListByActid($actid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lg_actid', 'oper' => '=', 'value' => $actid);
        return $this->deleteValue($where);
    }


  /*
   * 设置秒杀库存
   * @param int $gfid 商品规格ID
   */
  public function adjustStock($gid, $num, $gfid = 0) {
    //修改商品表中总库存量
    $field  = array('lg_stock');
    $inc    = array($num);

    $where[]    = array('name' => 'lg_g_id', 'oper' => '=', 'value' => $gid);
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

    $sql = $this->formatIncrementSql($field, $inc, $where);
    DB::query($sql);
    //修改商品规格表中库存量
//    if ($gfid) {
//      $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
//      $format_model->incrementGoodsStock($gfid, $gid, $num);
//    }
  }

  /*
   * 设置秒杀销量
   * @param int $gfid 商品规格ID
   */
  public function adjustSold($gid, $num, $gfid = 0) {
    //修改商品表中总库存量
    $field  = array('lg_sold');
    $inc    = array($num);

    $where[]    = array('name' => 'lg_g_id', 'oper' => '=', 'value' => $gid);
    $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

    $sql = $this->formatIncrementSql($field, $inc, $where);
    DB::query($sql);
    //修改商品规格表中库存量
//    if ($gfid) {
//      $format_model   = new App_Model_Goods_MysqlFormatStorage($this->sid);
//      $format_model->incrementGoodsStock($gfid, $gid, $num);
//    }
  }

    /*
    * 增减活动浏览量
    */
    public function incrementViewNum($aid, $gid, $num=1) {
        $field  = array('lg_view_num');
        $inc    = array($num);

        $where[]    = array('name' => 'lg_actid', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'lg_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'lg_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}
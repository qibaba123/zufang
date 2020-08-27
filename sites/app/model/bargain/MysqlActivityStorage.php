<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/11
 * Time: 下午10:33
 */
class App_Model_Bargain_MysqlActivityStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $goods_table; //商品表
    private $course_table;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'bargain_activity';
        $this->goods_table = 'pre_goods';
        $this->_pk      = 'ba_id';
        $this->_shopId  = 'ba_s_id';
        $this->_df      = 'ba_deleted';

        $this->sid      = $sid;
        $this->course_table = 'applet_train_course';
    }

    public function getActivityList($where, $index, $count, $sort){
        $sql = "select ba.*,g.* ";
        $sql .= " from `".DB::table($this->_table)."` ba ";
        $sql .= " left join ".$this->goods_table." g on g.g_id = ba.ba_g_id ";

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

//    public function getActivityListNew($where, $index, $count, $sort){
//        $sql = "select ba.*,g.*,( ";
//        $sql .= " CASE WHEN ba.ba_start_time > unix_timestamp() THEN 0 ";
//        $sql .= " WHEN ba.ba_start_time > unix_timestamp() THEN 0 ";
//        $sql .= " ) openStatus ";
//        $sql .= " from `".DB::table($this->_table)."` ba ";
//        $sql .= " left join ".$this->goods_table." g on g.g_id = ba.ba_g_id ";
//
//        $sql .= $this->formatWhereSql($where);
//        $sql .= $this->getSqlSort($sort);
//        $sql .= $this->formatLimitSql($index,$count);
//        $ret = DB::fetch_all($sql);
//        if ($ret === false) {
//            trigger_error("query mysql failed.", E_USER_ERROR);
//            return false;
//        }
//        return $ret;
//    }

    public function getActivityCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` ba ";
        $sql .= " left join ".$this->goods_table." g on g.g_id = ba.ba_g_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseActivityCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` ba ";
        $sql .= " left join ".DB::table($this->course_table)." atc on atc.atc_id = ba.ba_g_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCourseActivityList($where, $index, $count, $sort){
        $sql = "select ba.*,atc.* ";
        $sql .= " from `".DB::table($this->_table)."` ba ";
        $sql .= " left join ".DB::table($this->course_table)." atc on atc.atc_id = ba.ba_g_id ";

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

    public function getActivityById($id){
        $where[] = array('name' => 'ba_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ba_id', 'oper' => '=', 'value' => $id);

        $sql = "select ba.*,g.* ";
        $sql .= " from `".DB::table($this->_table)."` ba ";
        $sql .= " left join ".$this->goods_table." g on g.g_id = ba.ba_g_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 培训用
     */

    public function getCourseActivityById($id){
        $where[] = array('name' => 'ba_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ba_id', 'oper' => '=', 'value' => $id);

        $sql = "select ba.*,atc.* ";
        $sql .= " from `".DB::table($this->_table)."` ba ";
        $sql .= " left join ".DB::table($this->course_table)." atc on atc.atc_id = ba.ba_g_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取或修改单行数据（挪到基类里面了）
     */
    public function fetchUpdateByAid($aid, $data = null) {
        $where[]    = array('name' => 'ba_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 递减活动商品数量
     */
    public function incrementGoodsBuyNum($aid) {
        $field  = array('ba_buy_num');
        $inc    = array(1);

        $where[]    = array('name' => 'ba_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 增减活动浏览量
     */
    public function incrementViewNum($aid, $num=1) {
        $field  = array('ba_view_num');
        $inc    = array($num);

        $where[]    = array('name' => 'ba_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'ba_s_id', 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获取所有进行中的活动
     */
    public function getRunningActCount($esId=0) {
        $curr	= time();
        if($esId){
            $where[]	= array('name' => 'ba_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[]	= array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]	= array('name' => 'ba_start_time', 'oper' => '<', 'value' => $curr);
        $where[]	= array('name' => 'ba_end_time', 'oper' => '>', 'value' => $curr);
        return $this->getCount($where);
    }
}
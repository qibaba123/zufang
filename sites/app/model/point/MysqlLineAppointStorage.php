<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/3/1
 * Time: 下午2:10
 */
class App_Model_Point_MysqlLineAppointStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $goods_table;
    private $act_table;
    private $format_table;
    private $curr_table;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'line_appoint';
        $this->_pk      = 'la_id';
        $this->_shopId  = 'la_s_id';

        $this->sid      = $sid;
        $this->curr_table	= DB::table($this->_table);
        $this->goods_table  = DB::table('goods');
        $this->format_table = DB::table('goods_format');
        $this->act_table    = DB::table('point_act');
    }

    // 获取公排商品
    public function getAppointGoodsList($where,$index,$count){
        $sort = array('la_create_time' => 'DESC');
        $sql	= "SELECT pa.pa_name,pa.pa_start_time,pa.pa_end_time,g.g_name,gf.gf_name,la.* FROM `{$this->curr_table}` AS la ";
        $sql	.= "LEFT JOIN `{$this->act_table}` AS pa ON pa.pa_id=la.la_actid ";
        $sql	.= "LEFT JOIN `{$this->goods_table}` AS g ON g.g_id=la.la_g_id ";
        $sql	.= "LEFT JOIN `{$this->format_table}` AS gf ON gf.gf_id=la.la_gf_id ";
        $sql	.= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index,$count);
        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //获取公排商品总数
    public function getAppointGoodsCount($where){
        $sql	= "SELECT count(*) FROM `{$this->curr_table}` AS la ";
        $sql	.= "LEFT JOIN `{$this->act_table}` AS pa ON pa.pa_id=la.la_actid ";
        $sql	.= "LEFT JOIN `{$this->goods_table}` AS g ON g.g_id=la.la_g_id ";
        $sql	.= "LEFT JOIN `{$this->format_table}` AS gf ON gf.gf_id=la.la_gf_id ";
        $sql	.= $this->formatWhereSql($where);
        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取存在的指定商品
     */
    public function fetchExistAppoint($actid, $gid, $gfid = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'la_actid', 'oper' => '=', 'value' => $actid);
        $where[]    = array('name' => 'la_g_id', 'oper' => '=', 'value' => $gid);
        if ($gfid > 0) {
            $where[]    = array('name' => 'la_gf_id', 'oper' => '=', 'value' => $gfid);
        }
        
        return $this->getRow($where);
    }
}
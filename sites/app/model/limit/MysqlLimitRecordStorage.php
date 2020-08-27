<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/12/30
 * Time: 下午10:00
 */
class App_Model_Limit_MysqlLimitRecordStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

    public function __construct($sid = null){
        $this->_table 	= 'limit_record';
        $this->_pk 		= 'lr_id';
        $this->_shopId 	= 'lr_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
    }
    /*
     * 计算秒杀活动商品购买总量
     */
    public function countBuyNum($mid, $actid, $gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'lr_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'lr_actid', 'oper' => '=', 'value' => $actid);

        $sql    = "SELECT SUM(lr_num) FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 计算秒杀活动商品购买总量
     */
    public function countBuyNumByActid($actid, $gid, $gfid=0,$startTime = 0,$endTime = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lr_g_id', 'oper' => '=', 'value' => $gid);
        if($gfid){
            $where[]    = array('name' => 'lr_gf_id', 'oper' => '=', 'value' => $gfid);
        }
        $where[]    = array('name' => 'lr_actid', 'oper' => '=', 'value' => $actid);
        if($startTime > 0 && $endTime > 0){
            $where[]    = array('name' => 'lr_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[]    = array('name' => 'lr_create_time', 'oper' => '<=', 'value' => $endTime);
        }

        $sql    = "SELECT SUM(lr_num) FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);

//        if($this->sid == 11113){
//            Libs_Log_Logger::outputLog($sql,'test.log');
//        }

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
 * 计算秒杀活动商品购买总量
 */
    public function countBuyNumByActidFid($actid, $gid, $fid,$startTime = 0 ,$endTime = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'lr_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'lr_gf_id', 'oper' => '=', 'value' => $fid);
        $where[]    = array('name' => 'lr_actid', 'oper' => '=', 'value' => $actid);

        if($startTime > 0 && $endTime > 0){
            $where[]    =['name' => 'lr_create_time', 'oper' => '>=', 'value' => $startTime];
            $where[]    = ['name' => 'lr_create_time', 'oper' => '<=', 'value' => $endTime];
        }

        $sql    = "SELECT SUM(lr_num) FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
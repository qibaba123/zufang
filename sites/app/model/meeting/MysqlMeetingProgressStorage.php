<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingProgressStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meeting_progress';
        $this->_pk = 'amp_id';
        $this->_shopId = 'amp_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
    * 获取进程列表
    */
    public function fetchProgressShowList($where = array()) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where, 0, 0, array('amp_weight' => 'ASC'));
    }
    /*
        * 获取进程列表(新的)
        */
    public function newFetchProgressShowList($where = array()) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where, 0, 0, array('amp_weight' => 'ASC'));
    }
    //批量插入会议进程
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amp_id`, `amp_s_id`,`amp_c_id`,`amp_title`,`amp_brief`,`amp_start_time`,`amp_end_time`,`amp_weight`,`amp_create_time`,`amp_deleted`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }
    //批量插入会议进程(新的)
    public function newInsertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amp_id`, `amp_s_id`,`amp_am_id`,`amp_c_id`,`amp_title`,`amp_brief`,`amp_start_time`,`amp_end_time`,`amp_weight`,`amp_detail`,`amp_create_time`,`amp_deleted`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }
}
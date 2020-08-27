<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Mobile_MysqlMobileClaimStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_mobile_shop_claim';
        $this->_pk = 'ams_id';
        $this->_shopId = 'ams_s_id';

        $this->sid = $sid;
        //$this->shop_table = DB::table('applet_mobile_shop_apply');
    }
    //查看是否已经有认领过的人，并且已经通过
    public function showIsApply($id){
        $where   = array();
        $where[] = array('name' => 'ams_ams_id','oper'=> '=', 'value' => $id);
        $where[] = array('name' => 'ams_status','oper'=> '=', 'value' => 1);
        $where[] = array('name' => 'ams_s_id','oper'=> '=', 'value' => $this->sid);

        $ret     = $this->getRow($where);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function showApplyStatus($uid,$msid){
        $where   = array();
        $where[] = array('name' => 'ams_s_id','oper'=> '=', 'value' => $this->sid);
        $where[] = array('name' => 'ams_mid','oper'=> '=', 'value' => $uid);
        $where[] = array('name' => 'ams_ams_id','oper'=> '=', 'value' => $msid);
        $sort    = array('ams_create_time'=>'DESC');

       // $where[] = array('name' => 'ams_status','oper'=> '=', 'value' => 1);
        $ret     = $this->getList($where,0,0,$sort);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret[0];    //返回最新的一条申请记录的信息
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: zhaowie
 * Date: 16/5/30
 * Time: 下午4:28
 */
class App_Model_Member_MysqlMemberMobileCfgStorage extends Libs_Mvc_Model_BaseModel {
    private $member_table;
    private $sid;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'member_mobile_cfg';
        $this->_pk      = 'mmc_id';
        $this->_shopId  = 'mmc_s_id';
        $this->sid      = $sid;
        $this->member_table = DB::table('member');
    }

    public function findUpdateBySid($sid, $data = array()) {

        $where[]    = array('name' => 'mmc_s_id', 'oper' => '=', 'value' => $sid);
        if($data){
            $ret = $this->updateValue($data,$where);
        }else{
            $ret = $this->getRow($where);
        }
        return $ret;
    }


}
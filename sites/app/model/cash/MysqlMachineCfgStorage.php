<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/20
 * Time: 下午8:48
 */
class App_Model_Cash_MysqlMachineCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    private $store_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'cash_machine_cfg';
        $this->_pk      = 'cmc_id';
        $this->_shopId  = 'cmc_s_id';

        $this->sid      = $sid;
        $this->member_table  = DB::table('member');
        $this->store_table   = DB::table('offline_store');
    }


    /**
     * 获取对应门店对应机器的数据
     */
    public function getMachineDataByCode($osId,$code,$data=array()){
        $where   = array();
        $where[] = array('name'=>'cmc_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'cmc_os_id','oper'=>'=','value'=>$osId);
        $where[] = array('name'=>'cmc_code','oper'=>'=','value'=>$code);
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);

        }
    }




}
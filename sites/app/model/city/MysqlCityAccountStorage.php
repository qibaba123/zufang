<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityAccountStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_city_account';
        $this->_pk     = 'aca_id';
        $this->_shopId = 'aca_s_id';

        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }

    /**
     * @param $mid
     * @param $accid
     * @return array|bool
     * 获取单个会员的某一币种数据
     */
    public function findUpdateByNumber($mid,$accid) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aca_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aca_acc_id', 'oper' => '=', 'value' => $accid);
        return $this->getRow($where);
    }

    /**
     * @param $mid
     * @return array|bool
     * 获取单个会员的所有账户信息
     */
    public function getListByMid($mid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aca_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getList($where);
    }

    /*
     * 设置会员金币自增或自减
     */
    public function memberFetchGold($mid,$money,$accid){
        $where      = array();
        $where[]    = array('name' => 'aca_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aca_acc_id', 'oper' => '=', 'value' => $accid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET aca_ktx = aca_ktx - '.intval($money);
        $sql .= ' , aca_dsh = aca_dsh + '.intval($money);
        $sql .= ' , aca_update_time = '.time();
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
         * @param $mid 会员ID
         * @param $money 申请提现金额
         * @param $status 提现状态，1审核通过，2审核拒绝
         * @return bool
         */
    public function dealWithdrawMoney(array $record,$money,$status){
        if(in_array($status,array(1,2))){
            switch ($status){
                case 1 : //提现成功 ：待审核金额减，已提现金额增加
                    $set = ' , aca_ytx = aca_ytx + '.intval($money);
                    break;
                case 2 : //提现拒绝 ：待审核金额减；可提现金额增加
                    $set = ' , aca_ktx = aca_ktx + '.intval($money);
                    break;
            }
            $sql = 'UPDATE '.DB::table($this->_table);
            $sql .= ' set aca_dsh =  aca_dsh - ' .intval($money).$set;
            $sql .= ' WHERE `aca_m_id` = '.intval($record['wd_m_id']);
            $sql .= ' && `aca_acc_id` = '.intval($record['wd_acc_id']);
            $sql .= ' && `aca_s_id` = '.intval($record['wd_s_id']);
            $ret = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }



}
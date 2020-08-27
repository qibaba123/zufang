<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/4/10
 * Time: 下午12:00
 */
class App_Model_Shop_MysqlShopGiveRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_give_record';
        $this->_pk      = 'gr_id';
        $this->_shopId  = 'gr_s_id';
        $this->sid      = $sid;
    }

    /*
     * 获取该店铺邀请好友创建店铺获取赠送的次数（或者每天邀请好友的数量）
     */
    public function getGiveCountBySid($type=3,$today=false){
        $where = array();
        $where[] = array('name' => $this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name' => 'gr_type','oper' => '=','value' => $type);
        if($today){
            $time = strtotime(date('Y-m-d'));  // 获取今天得0点的时间
            $where[] = array('name' => 'gr_create_time','oper' => '>=','value' => $time);
        }
        $count = $this->getCount($where);
        return $count;
    }

    /*
     * 获取店铺总获得的奖励
     */
    public function getTotalRewardBySid($show=null){
        $where = array();
        $where[] = array('name' => $this->_shopId,'oper'=>'=','value'=>$this->sid);
        if($show){
            $where[] = array('name' => 'gr_isshow','oper'=>'=','value'=>0);
        }
        $sql = 'select sum(gr_amount) ';
        $sql .= ' from `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}
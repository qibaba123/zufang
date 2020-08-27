<?php
/**
 * Created by PhpStorm.
 * User: zhaowie
 * Date: 16/5/30
 * Time: 下午4:28
 */
class App_Model_Member_MysqlLevelStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'member_level';
        $this->_pk      = 'ml_id';
        $this->_shopId  = 'ml_s_id';
        $this->_df      = 'ml_deleted';
    }

    /*
     * 获取级别列表，主键作为key
     */
    public function getListBySid($sid,$total=50){
        $where   = array();
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sid);
        $sort    = array('ml_weight' => 'DESC','ml_create_time' => 'DESC');
        return $this->getList($where,0,$total,$sort,array(),true);
    }

    public function getListBySidForSelect($sid){
        $list = $this->getListBySid($sid);
        $data = array();
        foreach($list as $val){
            $data[$val['ml_id']] = $val['ml_name'];
        }
        return $data;
    }

    /*
     * 获取店铺VIP特权列表
     */
    public function getVipLevelList($sid) {
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sid);
        $where[] = array('name' => 'ml_is_vip','oper' => '=','value' =>1);//VIP特权
        $sort    = array('ml_weight' => 'DESC','ml_create_time' => 'DESC');
        return $this->getList($where,0,50,$sort,array(),true);
    }
    /*
     * 获取店铺需要购买的VIP列表,仅获取金额大于0
     */
    public function getBuyLevelList($sid) {
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sid);
        $where[] = array('name' => 'ml_is_vip','oper' => '=','value' =>1);//VIP特权
        $where[] = array('name' => 'ml_buy_money','oper' => '>','value' =>0);//仅获取购买金额大于0
        $sort    = array('ml_weight' => 'DESC','ml_create_time' => 'DESC');
        return $this->getList($where,0,50,$sort,array(),true);
    }

    /*
     * 获取VIP特权的级别,通过id,sid筛选
     */
    public function getLevelByIdSid ($id, $sid) {
        $where[] = array('name' => 'ml_id','oper' => '=','value' => $id);//VIP特权
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sid);
        $where[] = array('name' => 'ml_is_vip','oper' => '=','value' =>1);//VIP特权
        $where[] = array('name' => 'ml_deleted','oper' => '=','value' =>0);//未删除

        return $this->getRow($where);
    }


    /*
     * 更加店铺id和会员等级权重获取等级信息
     */
    public function getLevelByTypeSid ($sid,$info,$type = 'weight') {
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sid);

        switch ($type){
            case 'weight':
                $where[] = array('name' => 'ml_weight','oper' => '=','value' =>$info);//等级权重
                break;
            case 'tradeNum':
                $where[] = array('name' => 'ml_traded_num','oper' => '=','value' =>$info);//成功订单数量
                break;
            case 'tradeMoney':
                $where[] = array('name' => 'ml_traded_money','oper' => '=','value' =>$info);//成功交易金额
                break;
            case 'discount':
                $where[] = array('name' => 'ml_discount','oper' => '=','value' =>$info);//成功交易金额
                break;
        }
        $where[] = array('name' => 'ml_deleted','oper' => '=','value' =>0);//未删除
        return $this->getRow($where);
    }

    /*
     * 根据等级信息获得等级
     */
    public function getLevelByInfo($sid,$weight,$tradeNum,$tradeMoney,$discount){
        $where[] = array('name' => $this->_shopId,'oper' => '=','value' =>$sid);
        $where[] = array('name' => 'ml_deleted','oper' => '=','value' =>0);//未删除
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $sql .= " AND ( ml_weight = ".$weight." or ";
        $sql .= " ml_traded_num = ".$tradeNum." or ";
        $sql .= " ml_traded_money = ".$tradeMoney." or ";
        $sql .= " ml_discount = ".$discount." ) ";
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/18
 * Time: 下午4:01
 */
class App_Model_Member_MysqlAddressStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $curr_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'member_address';
        $this->_pk      = 'ma_id';
        $this->_shopId  = 'ma_s_id';
        $this->_df      = 'ma_deleted';

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
    }

    /*
     * 获取会员的默认地址
     */
    public function fetchAddressByMid($mid) {
        $where[]    = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ma_default', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'ma_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getRow($where);
    }
    /*
     * 插入新收货地址,置为默认,并将其他地址设置为非默认
     */
    public function insertDefaultAddress($indata) {
        $indata['ma_default']   = 1;//设为默认

        $mid    = $indata['ma_m_id'];
        $uid    = $indata['ma_uid'];

        $where[]    = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $mid);
        if ($uid) {
            $where[]    = array('name' => 'ma_uid', 'oper' => '=', 'value' => $mid);
        }
        $where_sql  = $this->formatWhereSql($where, false);
        $sql    = "UPDATE `{$this->curr_table}` SET `ma_default`=0 ".$where_sql;

        DB::query($sql);
        $addrid = $this->insertValue($indata);
        return $addrid;
    }

    /*
     * 查找用户绑定的收货地址
     */
    public function findAddrByIDMid($id, $mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ma_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getRow($where);
    }

    /*
     * 获取会员的收货地址列表,默认获取20条记录
     */
    public function fetchAddrListByMid($mid, $uid = 0) {
        $sql    = "SELECT * FROM `{$this->curr_table}` WHERE (`ma_m_id`=".$mid.($uid?" OR `ma_uid`={$uid}":"").") AND `ma_deleted`=0";
        $sort       = array('ma_add_time' => 'DESC');
        $limit_sql  = $this->formatLimitSql(0, 20);
        $sort_sql   = $this->getSqlSort($sort);

        $sql .= $sort_sql;
        $sql .= $limit_sql;
        return DB::fetch_all($sql);
    }

    /*
     * 删除会员的收货地址,逻辑删除
     */
    public function deleteAddress($mid, $addrid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ma_id', 'oper' => '=', 'value' => $addrid);

        $update     = array(
            'ma_deleted'    => 1
        );
        return $this->updateValue($update, $where);
    }
    /*
     * 设置默认收货地址
     */
    public function setDefaultAddress($mid, $addrid) {
        $where[]    = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $mid);
        $where_sql  = $this->formatWhereSql($where, false);
        $sql    = "UPDATE `{$this->curr_table}` SET `ma_default`=0 ".$where_sql;

        DB::query($sql);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $addrid);

        $updata     = array('ma_default' => 1);

        return $this->updateValue($updata, $where);
    }




   /**
    * 获取会员的默认收货地址或一条地址
    */
   public function getMemberDefaultAddress($mid){
       $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
       $where[]    = array('name' => 'ma_m_id', 'oper' => '=', 'value' => $mid);
       $sort = array('ma_default'=>'DESC','ma_add_time' => 'DESC');
       $list = $this->getList($where,0,1,$sort);
       if($list){
           return $list[0];
       }
       return false;
   }


}
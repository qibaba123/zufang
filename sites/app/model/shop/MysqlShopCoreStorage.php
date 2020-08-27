<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Shop_MysqlShopCoreStorage extends Libs_Mvc_Model_BaseModel {

    private $manager_table;
    private $company_table;
    private $weixin_table;
    private $index_table;
    private $applet_table;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop';
        $this->_pk      = 's_id';
        $this->_shopId  = 's_id';
        $this->sid      =$sid;
        $this->manager_table = DB::table('manager');
        $this->company_table = DB::table('company');
        $this->index_table   = DB::table('index_tpl');
        $this->weixin_table  = DB::table('weixin_cfg');
        $this->applet_table  = DB::table('applet_cfg');
    }

    /**
     * @param
     * @return array|bool 获取特定时间内开通的店铺数
     */
    public function getSaleList($beginToday,$endToday){
        $sql  = 'SELECT count(*) total';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' WHERE s_createtime >='.$beginToday;
        $sql .= ' AND s_createtime <'.$endToday;
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




    /**
     * 根据唯一性ID获取店铺信息
     */
    public function findShopByUniqid($uniqid) {
        if (!$uniqid) {
            return false;
        }

        $where[]    = array('name' => 's_unique_id', 'oper' => '=', 'value' => $uniqid);

        return $this->getRow($where);
    }
    /**
     * 根据唯一性id编辑数据
     */
    public function changeShopByUniqid($uniqid,$data=array()){
        if (!$uniqid) {
            return false;
        }
        $where[]    = array('name' => 's_unique_id', 'oper' => '=', 'value' => $uniqid);
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }


    /**
     * @param $where
     * @param $index
     * @param $count
     * @return array|bool
     */
    public function getShopList($where,$index,$count){
        $sql = 'select sh.*,yc_app_secret,yc_app_id ';
        $sql .= ' from `'.DB::table($this->_table).'` sh ';
        $sql .= ' left join pre_youzan_cfg on yc_s_id = sh.s_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 根据公司ID获取已创建店铺的数量
     */
    public function getCompanyShop($cid){
        $where = array();
        $where[]    = array('name' => 's_c_id', 'oper' => '=', 'value' => $cid);
        return $this->getCount($where);
    }

    public function getRowByIdCompany($cid,$id){
        $where = array();
        $where[]    = array('name' => 's_c_id', 'oper' => '=', 'value' => $cid);
        $where[]    = array('name' => 's_id', 'oper' => '=', 'value' => $id);
        return $this->getRow($where);
    }

    public function getShopListForSelect(){
        $where = array();
        $sort = array('s_update_time' => 'DESC');
        $files = array('s_id','s_name');
        $list = $this->getList($where,0,0,$sort,$files);
        $res = array();
        if($list){
            foreach($list as $val){
                $res[$val['s_id']] = $val['s_name'];
            }
        }
        return $res;
    }

    public function getCompanyList($where, $index, $count, $sort){
        $sql = 'select s_id,s_support_id,s_unique_id,s_name,s_balance,s_recharge,s_not_available,s_withdraw_money,s_active_time,s_contact,s_phone,s_type,s_merchant_type,s_expire_time , s_open_time,s_status ';
        $sql .= ',wc_id,wc_auth_status,wc_app_id,wc_app_secret,wc_verify_type,wc_service_type,c_province,c_city,ac_type,m.m_mobile,m.m_password '; //,c_name
        $sql .= ' from `'.DB::table($this->_table).'` s ';
        $sql .= ' left join '.$this->company_table.' c on c_id = s_c_id ';
        $sql .= ' left join '.$this->weixin_table.' wx on wc_s_id = s_id ';
        $sql .= ' left join '.$this->applet_table.' ac on ac_s_id = s_id ';
        $sql .= ' left join '.$this->manager_table.' m on c.c_id = m.m_c_id ';

        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY s_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getCompanyCount($where){
        $sql = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` s ';
        $sql .= ' left join '.$this->company_table.' c on c_id = s_c_id ';
        $sql .= ' left join '.$this->weixin_table.' wx on wc_s_id = s_id ';
        $sql .= ' left join '.$this->applet_table.' ac on ac_s_id = s_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 设置店铺收入余额变化
     */
    public function incrementShopBalance($sid, $balance) {
        $field  = array('s_balance');
        $inc    = array($balance);

        $where[]    = array('name' => 's_id', 'oper' => '=', 'value' => $sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 设置店铺充值余额变化
     */
    public function incrementShopRecharge($sid, $balance) {
        $field  = array('s_recharge');
        $inc    = array($balance);

        $where[]    = array('name' => 's_id', 'oper' => '=', 'value' => $sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /**
     * @param $id
     * @param array $field
     * @return array|bool
     * 根据店铺ID 获取店铺、公司、创建人信息
     */
    public function rowShopCompanyManager($id,$field=array()){
        $sql  = 'SELECT '.$this->getFieldString($field);;
        $sql .= ' FROM '.$this->company_table.'  c ';
        $sql .= ' LEFT JOIN '.DB::table($this->_table).'  s ON s_c_id = c_id';
        $sql .= ' LEFT JOIN '.$this->manager_table.'  ON m_id = c_founder_id';
        $sql .= ' WHERE s_id='.intval($id);

        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /**
     * @param $sid
     * @param $balance
     * @return bool
     * 提现申请保存后，修改店铺账户可用余额和锁定余额
     */
    public function changeBalance($sid, $balance){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET `s_balance` = s_balance - ' . intval($balance);
        $sql .= ' ,s_not_available = s_not_available + ' . intval($balance);
        $sql .= '  WHERE '.$this->_pk .' = '.intval($sid);

        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function changeBalanceWithdraw($sid,$balance,$tx_status){
        if(in_array($tx_status,array(1,2))){
            if($tx_status == 1){ //提现成功，只修改锁定金额，写店铺支出记录
                $set = ' s_not_available = s_not_available - '.floatval($balance);
            }else{ //失败：锁定金额回滚到账户余额
                $set  = ' s_not_available = s_not_available- '.floatval($balance);
                $set .= ' , s_balance = s_balance+ '.floatval($balance);
            }
            $sql  = 'UPDATE '.DB::table($this->_table);
            $sql .= ' SET  ' . $set;
            $sql .= '  WHERE '.$this->_pk .' = '.intval($sid);

            $ret = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }else{
            return false;
        }
    }

    /**
     * @param $where
     * @param $type
     * @return bool
     * 变更店铺类型
     */
    public function changeType($where,$type){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET `s_type_change` = s_type_change + 1 ';
        $sql .= ' ,s_type = ' . intval($type);
        $sql .= ' ,s_change_time = ' . time();
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getWeixinList($where, $index, $count, $sort,$field=array()){
        $sql  = 'select ';
        $sql .= $this->getFieldString($field);
        $sql .= ' from `'.DB::table($this->_table).'` s ';
        $sql .= ' left join '.$this->weixin_table.' wx on wc_s_id = s_id ';
        $sql .= ' left join '.$this->company_table.' c on c_id = s_c_id ';
        $sql .= " left join pre_manager m on m_id = c_founder_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 通过邀请码查找店铺
     */
    public function findShopByInvite($invite) {
        if (!$invite) {
            return false;
        }
        $where[]    = array('name' => 's_invite', 'oper' => '=', 'value' => $invite);

        return $this->getRow($where);
    }

    /*
     * 根据公司id获取店铺信息
     */
    public function findShopByCid($cid) {
        if (!$cid) {
            return false;
        }
        $where[]    = array('name' => 's_c_id', 'oper' => '=', 'value' => $cid);
        $list = $this->getList($where,0,0,array('s_createtime'=>'DESC'));
        if($list){
            return $list[0];
        }
        return false;
    }

    /*
     *
     */
    public function getShopManagerList($where,$index,$count,$sort,$field){
        $sql  = 'SELECT '.$this->getFieldString($field);
        $sql .= ' FROM '.DB::table($this->_table).' s ';
        $sql .= ' LEFT JOIN '.$this->manager_table.' m on m.m_c_id=s.s_c_id And m.m_fid = 0 ';
        $sql .= ' LEFT JOIN '.$this->applet_table.' ac on ac.ac_s_id=s.s_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        Libs_Log_Logger::outputLog($sql,'test.log');
        $list = DB::fetch_all($sql);
        if ($list === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $list;
    }

     /*
      * 通过店铺id
      */
    public function findUpdateBySid($data=null,$fields='') {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where,$fields);
        }
    }


}
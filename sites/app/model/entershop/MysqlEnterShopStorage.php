<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Entershop_MysqlEnterShopStorage extends Libs_Mvc_Model_BaseModel {

    private $manager_table;
    private $sid;
    private $apply_table;
    private $city_shop;
    private $community_kind;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'enter_shop';
        $this->_pk      = 'es_id';
        $this->sid      = $sid;
        $this->_shopId  = 'es_s_id';
        $this->_df      = 'es_deleted';
        $this->manager_table = DB::table('enter_shop_manager');
        $this->apply_table = DB::table('applet_community_shop_apply');
        $this->city_shop = DB::table('applet_city_shop');
        $this->community_kind = 'applet_community_kind';
    }

    /**
     * 根据唯一性ID获取店铺信息
     */
    public function findShopByUniqid($uniqid) {
        if (!$uniqid) {
            return false;
        }

        $where[]    = array('name' => 'es_unique_id', 'oper' => '=', 'value' => $uniqid);

        return $this->getRow($where);
    }

    public function getRowByMidSid($mid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'es_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0);
        return $this->getRow($where);
    }

    /*
     * 获取入驻的所有店铺信息
     */
    public function getShopListBySid($sid)
    {
       $sql ="select * from ".DB::table($this->_table).' where es_deleted =0 and es_s_id = '.$sid.' order by es_createtime desc';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取店铺和管理员信息
     */
    public function getShopMangerList($where,$index,$count,$sort){
        $sql = "select es.*, m.*,mb.m_nickname,mb.m_show_id,mb.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join ".$this->manager_table." m on m.esm_es_id = es.es_id ";
        $sql .= " left join pre_member mb on mb.m_id = es.es_m_id ";
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

    /**
     * 获取店铺和管理员信息
     */
    public function getShopMangerCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join ".$this->manager_table." m on m.esm_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据店铺ID获取店铺信息
     */
    public function findShopBySid($enshopId) {

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $enshopId);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        return $this->getRow($where);
    }


    // 根据距离排序获取店铺信息
    public function getListByDistance($where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT ams.*,es.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join pre_applet_community_district acd on es.es_district2 = acd.acd_id ";
        $sql .= " left join pre_applet_meal_store ams on ams.ams_es_id = es.es_id ";

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

    public function getListByDistanceNew($where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT es.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) as distance ';
        //sql判断是否开店
        //$sql .= "(case  when es.es_business_time = '' or es.es_close_time = '' or es.es_business_time is null or es.es_close_time is null then 1  when unix_timestamp(concat(curdate(),' ',es.es_business_time)) < unix_timestamp(concat(curdate(),' ',es.es_close_time))  AND unix_timestamp(concat(curdate(),' ',es.es_business_time)) < unix_timestamp()  AND unix_timestamp(concat(curdate(),' ',es.es_close_time)) > unix_timestamp() then 1  when unix_timestamp(concat(curdate(),' ',es.es_business_time)) >= unix_timestamp(concat(curdate(),' ',es.es_close_time))  AND ((unix_timestamp(concat(curdate(),' ',es.es_business_time)) <= unix_timestamp() AND unix_timestamp() <=unix_timestamp(concat(curdate(),' ','23:59'))) OR  (unix_timestamp(concat(curdate(),' ',es.es_close_time)) >= unix_timestamp() AND  unix_timestamp(concat(curdate(),' ','0:00')) <= unix_timestamp())) then 1  else 2 end) as openStatus ";
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join pre_applet_community_district acd on es.es_district2 = acd.acd_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
//        if($this->sid == 9800){
//            Libs_Log_Logger::outputLog($sql);
//        }
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMealListByDistance($where,$index,$count,$sort,$lng,$lat){
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT ams.*,es.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) as distance ';
        //sql判断是否开店
        //$sql .= "(case  when ams.ams_open_time = '' or ams.ams_close_time = '' or ams.ams_open_time is null or ams.ams_close_time is null then 1  when unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) < unix_timestamp(concat(curdate(),' ',ams.ams_close_time))  AND unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) < unix_timestamp()  AND unix_timestamp(concat(curdate(),' ',ams.ams_close_time)) > unix_timestamp() then 1  when unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) >= unix_timestamp(concat(curdate(),' ',ams.ams_close_time))  AND ((unix_timestamp(concat(curdate(),' ',ams.ams_open_time)) <= unix_timestamp() AND unix_timestamp() <=unix_timestamp(concat(curdate(),' ','23:59'))) OR  (unix_timestamp(concat(curdate(),' ',ams.ams_close_time)) >= unix_timestamp() AND  unix_timestamp(concat(curdate(),' ','0:00')) <= unix_timestamp())) then 1  else 2 end) as openStatus ";
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join pre_applet_community_district acd on es.es_district2 = acd.acd_id ";
        $sql .= " left join pre_applet_meal_store ams on ams.ams_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
//        if($this->sid == 9800){
//            Libs_Log_Logger::outputLog($sql);
//        }
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序获取店铺信息
    public function getRowDistanceById($id,$lng,$lat){
        $where[] = array('name' => 'es_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'es_status', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT ams.*,es.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join pre_applet_meal_store ams on ams.ams_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序获取店铺信息
    public function getRowByIdMemberExtra($id){
        $where[] = array('name' => 'es_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'es_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT ame.*,es.*,m.m_nickname,m.m_avatar ';
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " left join pre_member m on m.m_id = es.es_m_id ";
        $sql .= " left join pre_applet_member_extra ame on ame.ame_m_id = es.es_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
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
        $field  = array('es_balance');
        $inc    = array($balance);

        $where[]    = array('name' => 'es_id', 'oper' => '=', 'value' => $sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 设置店铺充值余额变化
     */
    public function incrementShopRecharge($sid, $balance) {
        $field  = array('es_recharge');
        $inc    = array($balance);

        $where[]    = array('name' => 'es_id', 'oper' => '=', 'value' => $sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


    /**
     * @param $sid
     * @param $balance
     * @return bool
     * 提现申请保存后，修改店铺账户可用余额和锁定余额
     */
    public function changeBalance($sid, $balance){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET `es_balance` = es_balance - ' . intval($balance);
        $sql .= ' ,es_not_available = es_not_available + ' . intval($balance);
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
                $set = ' es_not_available = es_not_available - '.floatval($balance);
            }else{ //失败：锁定金额回滚到账户余额
                $set  = ' es_not_available = es_not_available- '.floatval($balance);
                $set .= ' , es_balance = es_balance+ '.floatval($balance);
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
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReduceShopNum($id,$type,$operation='add',$num=1){
        if($type=='collection') {
            $field = 'es_follow_num';
        }elseif($type == 'show'){
            $field = 'es_show_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($id);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 通过店铺id和用户ID获取用户入驻信息及申请信息
     * 无论是否被删除都可获得信息
     */
    public function findShopByUser($sid,$userId,$noDelVerify = true) {
        $where      = array();
        $where[]    = array('name' => 'es_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'es_m_id', 'oper' => '=', 'value' => $userId);
        $where[]    = array('name' => 'es_handle_status', 'oper' => '>', 'value' => 0);//已经支付
        if(!$noDelVerify){
            $where[]    = array('name' => 'es_deleted', 'oper' => '=', 'value' => 0);//未删除
        }
        $sql = "select es.*,acsa.acsa_license,acsa.acsa_status,esm.esm_mobile ";
        $sql .= ' from `'.DB::table($this->_table).'` es ';
        $sql .= ' left join `'.$this->apply_table.'` acsa on acsa.acsa_m_id = es.es_m_id ';
        $sql .= ' left join `'.$this->manager_table.'` esm on esm.esm_es_id = es.es_id ';
        $sql .= $this->formatWhereSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /**
     * @param $id
     * @param $sid
     * @return bool
     * 清除门店等级时，把门店表数据清理
     */
    public function clearShopLevel($id,$sid){
        $where      = array();
        $where[]    = array('name' => 'es_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'es_level', 'oper' => '=', 'value' => $id);
        $set = array(
            'es_level' => 0,
        );
        return $this->updateValue($set,$where);
    }

    /*
     * 获得同城版店铺详情
     */
    public function getCityShopDetail($esId){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $esId);

        $sql = "select es.*,acs.* ";
        $sql .= ' from `'.DB::table($this->_table).'` es ';
        $sql .= ' left join `'.$this->city_shop.'` acs on acs.acs_es_id = es.es_id ';
        $sql .= $this->formatWhereSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 根据手机获得申请信息
     */
    public function findRowByMobile($mobile,$mid = 0) {
        $where[]    = array('name' => 'es_phone', 'oper' => '=', 'value' => $mobile);
        $where[]    = array('name' => 'es_handle_status', 'oper' => '>' , 'value' => 0);//只查找已支付的
        if($mid){
            $where[]    = array('name' => 'es_m_id', 'oper' => '<>' , 'value' => $mid); //排除mid
        }
        $ret = $this->getRow($where);

        return $ret;
    }

    //根据店铺名称获得申请信息
    public function findRowByName($name){
        $where[]    = array('name' => 'es_name', 'oper' => '=', 'value' => $name);
        $where[]    = array('name' => 'es_handle_status', 'oper' => '>' , 'value' => 0);//只查找已支付的
        $ret        = $this->getRow($where);
        return $ret;
    }

    /*
      * 通过店铺id和订单编号获取帖子信息
      */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'es_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获得门店表 关联分类
     */
    public function getListKindAction($where,$index,$count,$sort){
        $sql = "select es.*,ack1.ack_name as cate1,ack2.ack_name as cate2 ";
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack1 ON es.es_cate1 = ack1.ack_id ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack2 ON es.es_cate2 = ack2.ack_id ";
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
     * 获得单条门店 关联分类
     */
    public function getRowKindAction($where){
        $sql = "select es.*,ack1.ack_name as cate1,ack2.ack_name as cate2 ";
        $sql .= " from `".DB::table($this->_table)."` es ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack1 ON es.es_cate1 = ack1.ack_id ";
        $sql .= " LEFT JOIN `".DB::table($this->community_kind)."` ack2 ON es.es_cate2 = ack2.ack_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/22
 * Time: 下午10:35
 */
class App_Model_Trade_MysqlTradeOrderStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $trade_table;
    private $trade_order_table;

    public function __construct($sid){
        $this->_table 	= 'trade_order';
        $this->_pk 		= 'to_id';
        $this->_shopId 	= 'to_s_id';
        parent::__construct();
        $this->sid  = $sid;

        $this->trade_table  = DB::table("trade");
        $this->trade_order_table    = DB::table($this->_table);
    }

    /*
     * 获取交易下订单列表
     */
    public function fetchOrderListByTid($tid,$field = array(),$verify=false) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);
        if($verify){
            $where[]    = array('name' => 'to_se_verify', 'oper' => '=', 'value' => 1);
        }

        return $this->getList($where, 0, 0 , [] , $field);
    }

    /*
     * 根据订单号修改订单商品
     */
    public function updateOrderListByTid($set, $tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        return $this->updateValue($set, $where);
    }

    /*
     * 根据订单号退款中的商品的状态
     */
    public function updateRefundingOrderByTid($set, $tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'to_feedback', 'oper' => '=', 'value' => 1);

        return $this->updateValue($set, $where);
    }

    /**
     * 根据订单号获取未退款的商品
     */
    public function getNoRefundOrderByTid($tid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'to_fd_result', 'oper' => '!=', 'value' => 2);

        return $this->getList($where, 0, 0);
    }

    public function getGoodsListSequence($where){
        $sql = "select m.m_openid,m.m_avatar,m.m_id,m.m_nickname,go.g_name,td.*,t.t_create_time,t.t_tid,t.t_status,t.t_se_send_time,t.t_m_id,asct.asc_address,asct.asc_address_detail ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_member m on td.to_m_id = m_id ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' ORDER BY td.to_create_time DESC ';
        Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * [getGoodsListByTid description]
     * @param  [type]  $tid               [description]
     * @param  array   $where             [description]
     * @param  boolean $verify            [description]
     * @param  boolean $supplier          [description]
     * @param  [type]  $region_manager_id [区域合伙人id]
     * @return [type]                     [description]
     */
    public function getGoodsListByTid($tid,$where = array(),$verify=false,$supplier = false,$region_manager_id=true,$field='*',$in=false){
        //$where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($in)
            $where[]    = array('name' => 'to_t_id', 'oper' => 'in', 'value' => $tid);
        else
            $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        // 不清楚谁添加的这个限制，并且用来干什么用的
        // zhangzc
        // 2019-08-05
        if($region_manager_id)
            $where[]    =['name'=>'g_region_add_by','oper'=>'=','value'=>'0'];
        if($verify){
            $where[]    = array('name' => 'to_se_verify', 'oper' => '=', 'value' => 1);
        }
        $sql  = "select  ";
        $sql .= $field;
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        if($supplier){
            $sql .= " left join pre_applet_sequence_supplier_info assi on go.g_supplier_id= assi.assi_id ";
        }
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
  

    public function getGoodsDetailListByTid($tid,$where = array(),$verify=false,$supplier = false,$region_manager_id=true,$field='*',$in=false){
        //$where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($in)
            $where[]    = array('name' => 'to_t_id', 'oper' => 'in', 'value' => $tid);
        else
            $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        // 不清楚谁添加的这个限制，并且用来干什么用的
        // zhangzc
        // 2019-08-05
       // if($region_manager_id)
       //     $where[]    =['name'=>'g_region_add_by','oper'=>'=','value'=>'0'];
       // if($verify){
       //     $where[]    = array('name' => 'to_se_verify', 'oper' => '=', 'value' => 1);
       // }
        $sql  = "select  ";
        $sql .= $field;
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        if($supplier){
            $sql .= " left join pre_applet_sequence_supplier_info assi on go.g_supplier_id= assi.assi_id ";
        }
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsListByTidSequence($tid,$where = array()){
        //$where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        $sql = "select td.*,go.g_name,go.g_add_bed ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsListByTidEntershop($tid,$where = array(),$esId){
        //$where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        $sql .= " LEFT JOIN pre_applet_meal_goods_shelf amgs on go.g_id=amgs.amgs_g_id and amgs_es_id = {$esId} ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getGoodsListByTids($tids,$orderBy = 'ASC'){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => 'in', 'value' => $tids);

        $sql = "select td.*,go.*,gf.*,t.t_tid,t.t_payment ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        $sql .= $this->formatWhereSql($where);
        if($orderBy == 'DESC'){
            $sql .= " order by to_t_id DESC,to_id ASC ";
        }else{
            $sql .= " order by to_t_id ASC,to_id ASC ";
        }
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListByGoIds($ids){
        $sort = array('to_create_time' => 'ASC');
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => 'in', 'value' => $ids);
        return $this->getList($where,0,0, $sort);
    }

    /*
     * 获取会员已成功购买的商品数量
     */
    public function fetchMemberHadBuy($mid, $gid) {
        $sql    = "SELECT SUM(tt.to_num) AS hadbuy FROM {$this->trade_order_table} AS tt JOIN {$this->trade_table} AS t ON tt.to_t_id=t.t_id";
        $sql    .= " WHERE tt.to_g_id={$gid} AND tt.to_m_id={$mid} AND tt.to_s_id={$this->sid} AND t.t_status > ".App_Helper_Trade::TRADE_NO_CREATE_PAY ." AND t.t_status!=".App_Helper_Trade::TRADE_CLOSED;
        return DB::fetch_first($sql);
    }

    /*
     * 获取会员当天已成功购买的商品数量
     */
    public function fetchMemberDayHadBuy($mid, $gid) {
        $sql    = "SELECT SUM(tt.to_num) AS hadbuy FROM {$this->trade_order_table} AS tt JOIN {$this->trade_table} AS t ON tt.to_t_id=t.t_id";
        $sql    .= " WHERE tt.to_g_id={$gid} AND tt.to_m_id={$mid} AND tt.to_s_id={$this->sid} AND t.t_status > ".App_Helper_Trade::TRADE_NO_CREATE_PAY ." AND t.t_status!=".App_Helper_Trade::TRADE_CLOSED ." AND t.t_create_time > ".strtotime(date("Y-m-d"),time());
//        if($this->sid == 10945){
//            Libs_Log_Logger::outputLog($sql,'test.log');
//        }
        return DB::fetch_first($sql);
    }

    /*
     * 培训用 根据订单id获得课程
     */
    public function getCourseByTid($tid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_applet_train_course atc on atc.atc_id = td.to_g_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 婚纱用 根据订单id获得套餐
     */
    public function getPackageByTid($tid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_applet_wedding_package awp on awp.awp_id = td.to_g_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据商品id获取待支付订单的商品数量
     */
    public function getNopayCountByGid($gid, $gfid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'to_gf_id', 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_NORMAL);

        $sql = "select sum(to_num) ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据商品id获取待支付订单的商品数量
     */
    public function getSequenceNopayCountByGid($gid, $gfid=false){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        if($gfid)
            $where[]    = array('name' => 'to_gf_id', 'oper' => '=', 'value' => $gfid);
        $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 't_applet_type', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_APPLET_SEQUENCE);

        $sql = "select sum(to_num) ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据商品id获取已支付订单(知识付费)
     */
    public function getTradeByGid($gid, $uid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));
        $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => $uid);

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获得订单信息 关联商品
     */
    public function getTradeRow($where){

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_member_address ma on t.t_addr_id = ma.ma_id ";
        $sql .= " left join pre_goods g on g.g_id = td.to_g_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获得订单信息 关联商品
     */
    public function getTradeStatusList($where,$index,$count,$sort){

        $sql = "select td.*,t.t_id,t.t_tid,t.t_status,t.t_finish_time ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_t_id ";
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
     * 根据商品id获取已支付订单(知识付费)
     */
    public function getTuanTradeByGid($gid, $uid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => $uid);

        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 统计商品数量和总收入
     * 
     * updator :zhangzc 2019-07-08
     * @param having 是否按照 商品名称查询
     * @param goods_format  是否按照商品规格进行查询
     * 
     */
    public function sumPriceNum($where,$having=false,$goods_format=false){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select sum(td.to_num) as totalNum,sum(td.to_total) as totalMoney,sum(td.to_leader_deduct) as totalDeduct,go.g_name,go.g_cover,td.to_g_id as g_id,to_gf_name ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        $sql .= " left join pre_trade t on td.to_t_id = t.t_id ";
        $sql .= $this->formatWhereSql($where);
        if($goods_format)
            $sql .= " GROUP BY td.to_g_id ,td.to_gf_id ";
        else
            $sql .= " GROUP BY td.to_g_id ";
        if($having)
            $sql.=" HAVING `g_name` like '%{$having}%' ";
        $sql.=" order by null ";
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 统计商品数量和总收入
     * 区分商品规格
     */
    public function sumPriceNumFormat($where){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select sum(td.to_num) as totalNum,sum(td.to_total) as totalMoney,go.g_name,go.g_cover,go.g_id,go.g_supplier_id,gf.gf_id,gf.gf_name,gf.gf_name2,gf.gf_name3,gf.gf_img,t.t_tid ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_goods_format gf on gf.gf_id = td.to_gf_id ";
        $sql .= " left join pre_trade t on td.to_t_id = t.t_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_g_id,td.to_gf_id ";

        $ret = DB::fetch_all($sql);


        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getSequenceGoodsDeductListByTid($tid,$where = array()){
        //$where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_t_id', 'oper' => '=', 'value' => $tid);

        $sql = "select asgd.*,td.to_num,td.to_id,td.to_total,td.to_se_ignore_deduct ,td.to_se_is_region_goods,td.to_fd_status,asrgd.*";
        $sql .= " from `".DB::table($this->_table)."` td ";
       // $sql .= " left join pre_goods go on go.g_id = td.to_g_id ";
        $sql .= " left join pre_applet_sequence_goods_deduct asgd on asgd.asgd_g_id = td.to_g_id ";
        $sql .= " LEFT JOIN pre_applet_sequence_region_goods_deduct asrgd on asrgd.asrgd_g_id=td.to_g_id";
        $sql .= $this->formatWhereSql($where);

       // $sql .= ' GROUP BY td.to_id ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据商品id获取已购买商品的会员
     */
    public function getGoodsMemberByGid($gid,$index,$count,$sort){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
//        $where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

        $sql = "select td.to_num,m.m_avatar,m.m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` td ";
//        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_member m on m.m_id = td.to_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_m_id ";
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
     * 根据商品id获取已购买商品的会员(3月2号)
     */
    //todo 去掉member表
    public function getGoodsMemberByGidNew($gid,$index,$count,$sort){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        //$where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

//        $sql = "select td.to_num,m.m_avatar,m.m_nickname ";
        $sql = "select td.to_num,td.to_m_avatar,td.to_m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        //$sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
//        $sql .= " left join pre_member m on m.m_id = td.to_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_m_id ";
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
     * 根据商品id获取已购买商品的会员
     */
    public function getGoodsMemberCountByGid($gid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

        $sql = "select count(*) as total ";
        $sql .= " from (";
        $sql .= " select td.to_id as total ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_member m on m.m_id = td.to_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_m_id ";
        $sql .= " ) as list_count ";
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据商品id获取已购买商品的会员
     */
    public function getGoodsMemberCountByGidNew($gid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        //$where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

        $sql = "select count(*) as total ";
        $sql .= " from (";
        $sql .= " select td.to_id as total ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        //$sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_member m on m.m_id = td.to_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_m_id ";
        $sql .= " ) as list_count ";
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据商品id获取已购买商品的会员
     */
    public function getGoodsMemberSumByGid($gid,$index,$count,$sort=['to_g_id'=>'DESC']){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);

        $sql = "select sum(td.to_num) as total,td.to_m_avatar,td.to_m_nickname,td.to_create_time ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_m_id ";
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
     * 根据商品id获取已购买商品的会员
     * 每组取时间最大值
     */
    public function getGoodsMemberSumByGidSort($gid,$index,$count,$sort=['to_create_time'=>'DESC']){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);

        $sql = "select sum(td.to_num) as total,td.to_m_avatar,td.to_m_nickname,td.to_create_time ";
        $sql .= " from ( ";
        $sql .= " select to_m_avatar,to_m_nickname,to_create_time,to_num,to_m_id ";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= " limit 100000000 ) td ";
        $sql .= " GROUP BY td.to_m_id ";
        $sql .= " ORDER BY td.to_create_time DESC ";
        $sql .= $this->formatLimitSql($index,$count);
//        if($this->sid == 9373){
//            Libs_Log_Logger::outputLog($sql,'test.log');
//        }

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    
    // 获取付费预约报名中获取指定报名的
    // @params goods_id 活动id
    // @params page 页码
    // @params count 每页显示的数量
    public function getJoinList($goods_id,$page,$count=50){
        $index=$page*$count;
        $where=[
            ['name'  =>'to_g_id','oper'  =>'=','value' =>$goods_id],
            ['name'  =>'t_status','oper'  =>'in','value'=>[App_Helper_Trade::TRADE_HAD_PAY ,App_Helper_Trade::TRADE_FINISH]]
        ];
        $sort=['to_create_time'=>'DESC'];

        $sql='SELECT `m_avatar`,`m_nickname`,`to_create_time`,FROM_UNIXTIME(to_create_time,"%Y.%m.%d") as format_create_time from ';
        $sql.=DB::table('trade_order').' as o ';
        $sql.='LEFT JOIN '.DB::table('member').' as m ';
        $sql.='ON o.`to_m_id`=m.`m_id` ';
        $sql.='LEFT JOIN '.DB::table('trade').' as t on t.t_id=o.to_t_id';
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort($sort);
        $sql.=$this->formatLimitSql($index,$count);
        $res = DB::fetch_all($sql);
        if ($res === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }

    // 付费预约活动参加人数
    public function getJoinCount($goods_id,$where_p=[]){
        $where=[
            ['name'  =>'to_g_id','oper'  =>'=','value' =>$goods_id],
            ['name'  =>'t_status','oper'  =>'in','value'=>[App_Helper_Trade::TRADE_HAD_PAY ,App_Helper_Trade::TRADE_FINISH]]
        ]; 
        if($where_p){
            $where[]=$where_p;
        }
        // 付费预约修改bug - 获取报名次数不应该使用count 应该使用 SUM to_num
        // zhangzc
        // 2019-08-06
        $sql='SELECT SUM(to_num) as total  FROM '.DB::table('trade_order').' AS o ';
        $sql.='LEFT JOIN '.DB::table('trade').' as t on t.t_id=o.to_t_id';
        $sql.=$this->formatWhereSql($where);
        $res=DB::result_first($sql);
        if ($res === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }


    /**
     * 根据商品id获取已购买商品的会员(3月2号)
     */
    public function getGoodsMemberByGidGroup($gid,$index,$count,$sort){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        //$where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

        $sql = "select td.to_num,td.to_m_avatar,td.to_m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY td.to_m_id ";
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
     * 根据gid获得统计信息
     */
    public function getCountGid($gid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'to_g_id', 'oper' => '=', 'value' => $gid);
        //$where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListTrade($where,$index,$count,$sort){
        $sql = "select td.*,t.t_tid,t.t_buyer_nick ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
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

    public function getListGoods($where,$index,$count,$sort){
        $sql = "select td.to_g_id,td.to_gf_id,td.to_num,g.g_sold,g.g_stock ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_goods g on g.g_id = td.to_g_id ";
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

    public function getListTradeGoods($where,$index,$count,$sort){
        $sql = "select td.*,t.t_tid,t.t_buyer_nick,t.t_express_company,t.t_express_code,g.g_name,g.g_cover,g.g_kind2,ma.ma_name,ma.ma_phone ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_member_address ma on t.t_addr_id = ma.ma_id ";
        $sql .= " left join pre_goods g on g.g_id = td.to_g_id ";
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

    public function getListTradeGoodsCommunity($where,$index,$count,$sort){
        $sql = "select td.*,t.t_tid,t.t_buyer_nick,t.t_home_id,g.g_name,g.g_cover,g.g_kind2,asct.asc_name ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_applet_sequence_community asct on t.t_home_id = asct.asc_id ";
        $sql .= " left join pre_goods g on g.g_id = td.to_g_id ";
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

    public function getListTradeGoodsCommunityNew($where,$index,$count,$sort){
        $sql = "select td.*,t.t_tid,t.t_buyer_nick,t.t_home_id,g.g_name,g.g_cover,g.g_kind2,asct.asc_name,asdrt.asdrt_sort,asdrt.asdrt_id,asdr.asdr_sort,asdr.asdr_id,asdr.asdr_name ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_applet_sequence_community asct on t.t_home_id = asct.asc_id ";
        $sql .= " left join pre_applet_sequence_delivery_route_detail asdrt on asdrt.asdrt_community_id = asct.asc_id";
        $sql .= " left join pre_applet_sequence_delivery_route asdr on asdrt.asdrt_dr_id =asdr.asdr_id ";
        $sql .= " left join pre_goods g on g.g_id = td.to_g_id ";
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

    public function getCountTradeGoodsCommunity($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= " left join pre_applet_sequence_community asct on t.t_home_id = asct.asc_id ";
        $sql .= " left join pre_goods g on g.g_id = td.to_g_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    



    public function getCountTrade($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSum($where){
        $sql = "select sum(td.to_num) as numSum ";
        $sql .= " from `".DB::table($this->_table)."` td ";
        $sql .= " left join pre_trade t on t.t_id = td.to_t_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
 * 获取订单列表 关联门店表
 */
    public function getListByApplet($where){
        $sql = "select tr.* ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = tr.to_s_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql(0,1000);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListByAppletCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = tr.to_s_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 根据提供的trade_order表中主键以及商品规格id获取 to_sum的购买总数量
     * zhangzc
     * 2019-08-09
     * @param  [type] $order_ids  [description]
     * @param  [type] $gformat_id [description]
     * @return [type]             [description]
     */
    public  function getOrderSumByOrderIdStatus($order_ids,$gformat_id){
        $sql=sprintf('SELECT SUM(`to_num`) AS sums FROM `%s` 
            LEFT JOIN `pre_trade` ON `to_t_id`=`t_id`',
                DB::table($this->_table));
        $where=[
            ['name'  =>'to_id','oper'=>'in','value'=>$order_ids],
            ['name'  =>'to_gf_id','oper'=>'=','value'=>$gformat_id],
            ['name'  =>'t_status','oper'=>'in','value'=>[1,2,3,4,5,6]],
        ];
        $sql.=$this->formatWhereSql($where);
        $res=DB::result_first($sql);
        if($res===false){
            trigger_error('mysql query faield',E_USER_ERROR);
        }
        return $res;
    }

    public function getOrderTradeExcel($where,$index,$count){
        $sql = "select tr.to_g_id,tr.to_gf_id,tr.to_title,tr.to_gf_name,tr.to_num ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join pre_trade t on t.t_id = tr.to_t_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 计算子订单链接主订单后的条数
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    public function getCountWithTrade($where){
        $sql=sprintf('SELECT COUNT(*) FROM %s 
            LEFT JOIN `pre_trade` ON `t_id`=`to_t_id` ',
            DB::table($this->_table));
        $sql .= $this->formatWhereSql($where);
        $res=DB::result_first($sql);
        if($res===false){
            trigger_error('mysql query faield',E_USER_ERROR);
        }
        return $res;
    }

    
     /**
     * 社区团购导出订单之前计算订单的数量
     * zhangzc
     * 2019-11-13
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    public function getSequenceCountWithTrade($where){
        $sql=sprintf('SELECT COUNT(*) FROM %s 
            LEFT JOIN `pre_trade` ON `t_id`=`to_t_id` 
            LEFT JOIN `pre_applet_sequence_community` ON `asc_id` = `t_home_id`  
            LEFT JOIN `pre_applet_sequence_area` ON `asa_id`= `asc_area` ',
            DB::table($this->_table));
        $sql .= $this->formatWhereSql($where);
        $res=DB::result_first($sql);
        if($res===false){
            trigger_error('mysql query faield',E_USER_ERROR);
        }
        return $res;
    }

    /**
     * 团长中心统计团长佣金
     * zhangzc
     * 2019-11-18
     * @param  [type]  $where [description]
     * @param  [type]  $index [description]
     * @param  integer $count [description]
     * @param  array   $sort  [description]
     * @return [type]         [description]
     */
    public function getOrderDeductByDay($where,$index,$count=10,$sort=[]){
        $sql = "select FROM_UNIXTIME(t_create_time, '%Y-%m-%d') as date,SUM(to_leader_deduct) as deduct ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " LEFT JOIN `pre_trade` ON `t_id`=`to_t_id` ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY FROM_UNIXTIME(t_create_time, '%Y%m%d') ";
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
     * 获取用户指定时间段内购买的某个商品的总量
     * @param  [type] $gid      [商品id]
     * @param  [type] $uid      [用户id]
     * @param  [type] $start    [开始时间]
     * @param  [type] $end      [结束时间]
     * @return [type]           [description]
     */
    public function getUserBuySum($gid,$uid,$start=null,$end=null){
        $where=[
            ['name' =>'to_g_id','oper'=>'=','value'=>$gid],
            ['name' =>'to_m_id','oper'=>'=','value'=>$uid],
        ];
        if(!empty($start))
            $where[]=['name'=>'to_create_time','oper'=>'>=','value'=>$start];
        if(!empty($end))
            $where[]=['name'=>'to_create_time','oper'=>'<=','value'=>$end];

        $sql=sprintf('SELECT SUM(`to_num`) AS total  FROM %s ',DB::table($this->_table));

        $sql.=$this->formatWhereSql($where);

        $res=DB::result_first($sql);
        if($res === false){
            trigger_error('query mysql failed:'.__METHOD__,E_USER_ERROR);
            return false;
        }
        return $res;
    }
  
  
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/22
 * Time: 下午10:13
 */
class App_Model_Trade_MysqlTradeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $trade_table;
    private $trade_order_table;
    private $address_table;
    private $member_table;
    private $group_mem_table;
    private $group_org_table;
    private $enter_shop_table;
    private $train_course_table;
    private $offline_store_table;
    private $wedding_package_table;
    public function __construct($sid = null){
        $this->_table 	= 'trade';
        $this->_pk 		= 't_id';
        $this->_shopId 	= 't_s_id';
        parent::__construct();
        $this->sid  = $sid;

        $this->trade_table      = DB::table($this->_table);
        $this->trade_order_table= DB::table("trade_order");
        $this->address_table    = DB::table('member_address');
        $this->member_table     = DB::table('member');
        $this->group_mem_table  = DB::table('group_mem');
        $this->group_org_table  = DB::table('group_org');
        $this->enter_shop_table  = DB::table('enter_shop');
        $this->train_course_table = DB::table('applet_train_course');
        $this->offline_store_table = DB::table('offline_store');
        $this->wedding_package_table = DB::table('applet_wedding_package');
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        if($this->sid){
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function findUpdateTradeByTidNoMem($tid, $data = null) {
        $where[]    = array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => 0);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    public function findTradeByTidToid($tid,$toid=false){
        if(!empty($tid))
            $where[] = ['name' => 't_tid', 'oper' => '=', 'value' => $tid];
        if($this->sid){
            $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        }
        if($toid){
            $where[] = ['name' => 'to_id', 'oper' => '=', 'value' => $toid];
        }
        // 带子订单退款的关联子订单表
        if($toid){
            $sql  = sprintf('SELECT * FROM %s 
                LEFT JOIN `%s` ON `t_id` =`to_t_id` ',
                $this->trade_table,
                $this->trade_order_table);
            $sql .= $this->formatWhereSql($where);
            $ret  = DB::fetch_first($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }else{
            return $this->getRow($where);
        }
    }

    /*
     * 通过订单交易订单号获取订单
     */
    public function findUpdateTradeByPayNo($no, $data = null) {
        $where[]    = array('name' => 't_pay_trade_no', 'oper' => '=', 'value' => $no);
        if($this->sid){
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**
     * 社区团购 区域管理合伙人查询订单是否属于自己
     * @param  [type] $trade_id [description]
     * @param  [type] $city_id  [description]
     * @return [type]           [description]
     */
    public function findTradeByTidInRegion($trade_id,$city_id,$area_type='C'){
        $sql=sprintf('SELECT `pre_trade`.* FROM `%s` 
                LEFT JOIN `%s` ON `asc_leader`=`t_se_leader` 
                LEFT JOIN `%s` ON `asa_id`=`asc_area` ',
                DB::table($this->_table),
                'pre_applet_sequence_community',
                'pre_applet_sequence_area');
        if($area_type=='C'){
             $sql.=$this->formatWhereSql([
                ['name'=>'t_tid',   'oper'=>'=','value'=>$trade_id],
                ['name'=>'t_s_id',  'oper'=>'=','value'=>$this->sid],
                ['name'=>'asa_city','oper'=>'=','value'=>$city_id]
            ]);
         }else if($area_type=='D'){
             $sql.=$this->formatWhereSql([
                ['name'=>'t_tid',   'oper'=>'=','value'=>$trade_id],
                ['name'=>'t_s_id',  'oper'=>'=','value'=>$this->sid],
                ['name'=>'asa_zone','oper'=>'=','value'=>$city_id]
            ]);
         }
       
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
    public function getListEnterShop($where,$index,$count,$sort){
        $sql = "select tr.*,es.es_id,es.es_name,es.es_logo ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
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
     * 通过备用订单号获取订单
     */
    public function findUpdateTradeBySpareTid($tid, $data = null) {
        $where[]    = array('name' => 't_tid_spare', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    /*
     * 获取会员不同类型订单列表
     * array(all,dfk,dfh,dsh,ywc,ygb)分别为全部,待付款,待发货,待收货,已完成,已关闭
     */
    public function fetchMemberListByType($mid, $type = 'all', $index = 0, $count = 20) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);//未被删除订单
        $where[]    = array('name' => 't_type', 'oper' => 'in', 'value' => array(App_Helper_Trade::TRADE_NORMAL, App_Helper_Trade::TRADE_GROUP, App_Helper_Trade::TRADE_SECKILL));

        switch ($type) {
            case 'all' :
                $where[]    = array('name' => 't_status', 'oper' => '<>', 'value' => App_Helper_Trade::TRADE_NO_CREATE_PAY);
                break;
            case 'dfk' : //待付款
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_NO_PAY);
                break;
            case 'dct' : //待成团
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_WAIT_GROUP);
                break;
            case 'dfh' : //待发货
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_HAD_PAY);
                break;
            case 'dsh' : //待收货
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_SHIP);
                break;
            case 'ywc' : //已完成
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_FINISH);
                break;
            default : //已关闭
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                break;
        }
        $sort   = array('t_create_time' => 'DESC');
        return $this->getList($where, $index, $count, $sort);
    }
    /*
     * 获取会员不同类型下订单的数量
     */
    public function fetchMemberCountByType($mid, $type = 'all' , $appletType = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);//未被删除订单
        $where[]    = array('name' => 't_type', 'oper' => 'in', 'value' => array(App_Helper_Trade::TRADE_NORMAL, App_Helper_Trade::TRADE_GROUP, App_Helper_Trade::TRADE_SECKILL,App_Helper_Trade::TRADE_APPLET));

        switch ($type) {
            case 'all' :
                $where[]    = array('name' => 't_status', 'oper' => '<>', 'value' => App_Helper_Trade::TRADE_NO_CREATE_PAY);
                break;
            case 'dfk' : //待付款
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_NO_PAY);
                break;
            case 'dct' : //待成团
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_WAIT_GROUP);
                break;
            case 'dfh' : //待发货
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_HAD_PAY);
                if($appletType == 32){
                    $where[]    = array('name' => 't_feedback', 'oper' => '=', 'value' => 0);//未申请退款
                }
                break;
            case 'dsh' : //待收货
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_SHIP);
                break;
            case 'ywc' : //已完成
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_FINISH);
                break;
            case 'tkwq' : //退款维权

                if($appletType == 32){
                    $where[]    = array('name' => 't_feedback', 'oper' => '>', 'value' => 0);//有申请退款
                    // $where[]    = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_FINISH);//未完成
                    // 维权订单数量计算方式（去除掉已退款完成的订单）
                    // zhanzgc
                    // 2019-09-09
                    $where[]    = array('name' => 't_status', 'oper' => '!=', 'value' => App_Helper_Trade::TRADE_REFUND);//未完成

                }else{
                    $where[]    = array('name' => 't_feedback', 'oper' => '=', 'value' => App_Helper_Trade::FEEDBACK_YES);
                }
                break;
            default : //已关闭
                $where[]    = array('name' => 't_status', 'oper' => '=', 'value' => App_Helper_Trade::TRADE_CLOSED);
                break;
        }
        return $this->getCount($where);
    }


    public function getTradeListLight($where, $index, $count, $sort) {
        $sql = "select tr.*,ma.*,es.*,ahs.ahs_name ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
        $sql .= " left join pre_applet_hotel_store ahs on ahs.ahs_id = tr.t_store_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
     //  Libs_Log_Logger::outputLog($sql,'fahuoyi.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getAddressList($where, $index, $count, $sort) {
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join ".$this->group_mem_table." gm on gm.gm_tid = tr.t_tid ";
        $sql .= " left join ".$this->group_org_table." go on gm.gm_go_id = go.go_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
        $sql .= " left join ".$this->offline_store_table." os on os.os_id = tr.t_store_id ";
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
     * 重构后的订单导出查询函数
     * zhanzgc
     * 2019-11-07
     * @param  [type] $where [description]
     * @param  [type] $index [description]
     * @param  [type] $count [description]
     * @param  [type] $sort  [description]
     * @return [type]        [description]
     */
    public function getAddressListNew($where, $index, $count, $sort) {
        $sql = "select t_id,t_tid,t_buyer_nick,es_name,ma_name,ma_phone,ma_province,ma_city,ma_zone,ma_detail,ma_post,t_goods_fee,t_post_fee,t_total_fee,t_discount_fee,t_promotion_fee,t_payment,t_express_company,t_express_code,t_status,t_pay_type,t_create_time,t_pay_time,t_note,t_remark_extra,t_express_time,t_finish_time,os_name,t_express_method,to_g_id,to_num,to_gf_id,to_title,to_gf_name,to_price,to_total  ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join ".$this->group_mem_table." gm on gm.gm_tid = tr.t_tid ";
        $sql .= " left join ".$this->group_org_table." go on gm.gm_go_id = go.go_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
        $sql .= " left join ".$this->offline_store_table." os on os.os_id = tr.t_store_id ";
        $sql .= " RIGHT JOIN `pre_trade_order` ON `to_t_id`=`t_id` ";

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

    public function getTradeAddressCount($where) {
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getAddressCount($where) {
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join ".$this->group_mem_table." gm on gm.gm_tid = tr.t_tid ";
        $sql .= " left join ".$this->group_org_table." go on gm.gm_go_id = go.go_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
        $sql .= " left join ".$this->offline_store_table." os on os.os_id = tr.t_store_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSequenceAddressList($where, $index, $count, $sort) {
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join pre_applet_sequence_group_join asgj on asgj.asgj_t_id = tr.t_id ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = asgj.asgj_asg_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = asg.asg_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";
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

    public function getSequenceAddressGoodsList($where, $index, $count, $sort) {
        $sql = "select tr.t_id,tr.t_tid,tr.t_pay_type,tr.t_applet_type,tr.t_se_send_time,tr.t_total_fee,tr.t_goods_fee,tr.t_discount_fee,tr.t_promotion_fee,tr.t_promotion_fee,tr.t_payment,tr.t_num,tr.t_feedback,tr.t_buyer_nick,tr.t_express_method,tr.t_express_company,tr.t_express_code,tr.t_status,tr.t_express_time,tr.t_fd_result,tr.t_fd_status,tr.t_note,tr.t_remark_extra,tr.t_type,tr.t_pic,tr.t_create_time,tr.t_pay_time,tr.t_finish_time,tr.t_express_time,tr.t_se_num,tr.t_address,tr.t_had_comment,tr.t_independent_mall,tr.t_coin_payment,ma.*,asl.*,asct.*,g.g_name ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = tr.t_se_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = tr.t_home_id ";
        $sql .= " left join pre_trade_order tro on tr.t_id = tro.to_t_id ";
        $sql .= " left join pre_goods g on g.g_id = tro.to_g_id ";
        $sql .='LEFT JOIN `pre_applet_sequence_area` pasa on  asa_id= asc_area';

        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY tr.t_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    public function getSequenceAddressActivityGoodsList($where, $index, $count, $sort) {
        $sql = "select tr.t_id,tr.t_tid,tr.t_pay_type,tr.t_applet_type,tr.t_se_send_time,tr.t_total_fee,tr.t_goods_fee,tr.t_discount_fee,tr.t_promotion_fee,tr.t_promotion_fee,tr.t_payment,tr.t_num,tr.t_feedback,tr.t_buyer_nick,tr.t_express_method,tr.t_express_company,tr.t_express_code,tr.t_status,tr.t_express_time,tr.t_fd_result,tr.t_fd_status,tr.t_note,tr.t_remark_extra,tr.t_type,tr.t_pic,tr.t_create_time,tr.t_pay_time,tr.t_finish_time,tr.t_express_time,tr.t_se_num,tr.t_address,tr.t_had_comment,tr.t_independent_mall,tr.t_coin_payment,ma.*,asgj.*,asg.*,asl.*,asct.*,g.g_name,asa.* ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join pre_applet_sequence_group_join asgj on asgj.asgj_t_id = tr.t_id ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = asgj.asgj_asg_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = asg.asg_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= " left join pre_trade_order tro on tr.t_id = tro.to_t_id ";
        $sql .= " left join pre_goods g on g.g_id = tro.to_g_id ";
        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";

        $sql .='LEFT JOIN `pre_applet_sequence_area` pasa on  pasa.asa_id= asc_area';

        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY tr.t_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getSequenceAddressCount($where) {
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join pre_applet_sequence_group_join asgj on asgj.asgj_t_id = tr.t_id ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = asgj.asgj_asg_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = asg.asg_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * [getSequenceAddressListNew description]
     * @param  [type]  $where  [description]
     * @param  [type]  $index  [description]
     * @param  [type]  $count  [description]
     * @param  [type]  $sort   [description]
     * @param  integer $refund [退款订单列表需要传递此参数显示trade_order里面的订单]
     * @return [type]          [description]
     */
    public function getSequenceAddressListNew($where, $index, $count, $sort,$refund=0) {

        // 限制只有在使用商品名字进行查询的时候才会join trade_order表（优化查询效率）
        // zhangzc
        // 2019-09-11
        $is_join_trade_order=FALSE;
        foreach ($where as $key => $value) {
            if($value['name']=='to_title'){
                $is_join_trade_order=TRUE;
                break;
            }
        }


        $sql = "select tr.t_id,tr.t_tid,tr.t_pay_type,tr.t_applet_type,tr.t_se_send_time,tr.t_goods_fee,tr.t_total_fee,tr.t_num,tr.t_feedback,tr.t_buyer_nick,tr.t_express_method,tr.t_status,tr.t_express_time,tr.t_fd_result,tr.t_fd_status,tr.t_note,tr.t_remark_extra,tr.t_type,tr.t_create_time,tr.t_se_num,tr.t_address,tr.t_had_comment,tr.t_fd_status,tr.t_independent_mall,ma.*,asl.asl_id,asl.asl_name,asl.asl_apply_community,asct.asc_name ,asct.asc_address,asct.asc_address_detail,tr.t_express_company,tr.t_express_code,asl.asl_mobile,tr.t_discount_fee,tr.t_payment,tr.t_coin_payment,asa.asa_name,asps.asps_address,asps.asps_address_detail,asps.asps_lng,asps.asps_lat,asps.asps_mobile,asps.asps_manager_nickname,asps.asps_id,tr.t_se_leader,tr.t_refund_time  ";
        // 限制只有在使用商品名字进行查询的时候才会join trade_order表（优化查询效率）
        // zhangzc
        // 2019-09-11
        if($is_join_trade_order){
            $sql.=',to_fd_status,to_id ';
        }
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        //$sql .= " left join pre_applet_sequence_group asg on asg.asg_id = tr.t_se_group ";
        //$sql .= " left join pre_applet_sequence_group_join asgj on asgj.asgj_t_id = tr.t_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = tr.t_se_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = tr.t_home_id ";
        $sql .= " left join pre_applet_sequence_area as asa on asct.asc_area = asa.asa_id ";
        $sql .= " left join pre_applet_sequence_pick_station as asps on tr.t_expert_id = asps.asps_id ";
        if($is_join_trade_order)
            $sql .= " left join `pre_trade_order` on t_id =to_t_id ";
        

        $sql .= $this->formatWhereSql($where);

        // 限制只有在使用商品名字进行查询的时候才会join trade_order表（优化查询效率）
        // zhangzc
        // 2019-09-11
        if(!$refund && $is_join_trade_order)
            $sql.=' GROUP BY t_tid ';
        

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
     * [此表中传递查询参数的时候请注意检查一下与此函数内的查询逻辑是否一致]
     * update by zhangzc
     * 2019-09-04
     * @param  [type]  $where  [description]
     * @param  integer $refund [退款订单列表需要传递此参数显示trade_order里面的订单]
     * @param  integer $area_manager [区域合伙人关联leader表]
     * @return [type]          [description]
     */
    public function getSequenceAddressCountNew($where,$refund=0,$area_manager=0) {
        if(!$refund)
            $sql = "select count(distinct  tr.t_id) AS total ";
        else
            $sql = "select count(*) AS total ";

        $sql .= " from `".DB::table($this->_table)."` tr ";
        
        // 优化连表查询时查询性能
        // 方式：因为是查询count的操作 ，在不使用这些内容的时候不进行连表操作
        // zhangzc
        // 2019-09-04
        $sql_where_key=[];
        $community_join_field=['asc_name','asl_name','asa.asa_zone','asa.asa_city','asl_id'];
        $order_join_field=['to_title'];
        foreach ($where as $key => $value) {
            array_push($sql_where_key, $value['name']);

        }
        // 求交集查询是否包含查询条件
        if(array_intersect($community_join_field,$sql_where_key) || $area_manager){
            $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
            $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = tr.t_se_leader ";
            $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = tr.t_home_id ";
            $sql .= " left join pre_applet_sequence_area as asa on asct.asc_area = asa.asa_id ";
        }
        if(array_intersect($order_join_field,$sql_where_key)){
            $sql .= " left join `pre_trade_order` on t_id =to_t_id ";
        }

      
        $sql .= $this->formatWhereSql($where);
        
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getRefundByTid($tid){

    }

    /**
     * @param string $tid
     * @return array|bool
     * 取一条指定的订单，或者最新的订单
     */
    public function getRowBySid($tid=''){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($tid){
            $where[]= array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        }
        $sort = array('t_create_time' => 'DESC');
        $list = $this->getAddressList($where,0,1,$sort);
        if(!empty($list)){
            return $list[0];
        }else{
            return false;
        }
    }

    /**
     * @param int $yesterday
     * @return array|bool
     */
    public function statOrderStatus($yesterday=0){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sql  = 'SELECT count(*) total,sum(t_payment) money,t_status ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        if($yesterday){
            $ydEnd   = strtotime(date('Y-m-d',time()));
            $ydStart = $ydEnd-86400;
            $sql .= ' and UNIX_TIMESTAMP(`t_create_time`) > '.$ydStart;
            $sql .= ' and UNIX_TIMESTAMP(`t_create_time`) < '.$ydEnd;
        }
        $sql .= ' GROUP BY t_status';
        $ret = DB::fetch_all($sql,array(),'t_status');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取店铺最新订单
     */
    public function fetchNewTrade($count = 20) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 't_status', 'oper' => '>', 'value' => App_Helper_Trade::TRADE_NO_CREATE_PAY);

        $sort       = array('t_create_time' => 'DESC');

        $sql    = "SELECT t.t_id,t.t_buyer_nick,t.t_pic,t.t_type,t.t_extra_data,m.m_avatar FROM `{$this->trade_table}` AS t ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON t.t_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql(0, $count);

        return DB::fetch_all($sql);
    }


    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function  statOrderStatistic($where){
        $sql  = 'SELECT count(*) total,sum(t_payment) money,sum(t_points) points, sum(t_num) goodsNum,sum(t_coin_payment) coinMoney ';
        $sql .= ' FROM '.DB::table($this->_table).' tr ';
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join ".$this->group_mem_table." gm on gm.gm_tid = tr.t_tid ";
        $sql .= " left join ".$this->group_org_table." go on gm.gm_go_id = go.go_id ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = tr.t_es_id ";
        $sql .= " left join ".$this->offline_store_table." os on os.os_id = tr.t_store_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($_GET['test'] == 1){
            plum_msg_dump($sql,0);
            plum_msg_dump($ret,0);
        }
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function statSequenceOrderStatistic($where){
        $sql  = 'SELECT count(*) total,sum(t_payment) money ';
        $sql .= ' FROM '.DB::table($this->_table).' tr ';
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " left join pre_applet_sequence_group_join asgj on asgj.asgj_t_id = tr.t_id ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = asgj.asgj_asg_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = asg.asg_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function statSequenceOrderStatisticNew($where){
        $sql  = 'SELECT count(*) total,sum(t_payment) money ';
        $sql .= ' FROM '.DB::table($this->_table).' tr ';
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
//        $sql .= " left join pre_applet_sequence_group_join asgj on asgj.asgj_t_id = tr.t_id ";
//        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = asgj.asgj_asg_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = tr.t_se_leader ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = tr.t_home_id ";
        $sql .= " left join pre_applet_sequence_area as asa on asct.asc_area = asa.asa_id ";
//        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";
     
        $sql .= $this->formatWhereSql($where);
        
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function statOrderStatisticSingle($where){
        $sql  = 'SELECT count(*) total,sum(t_payment) money ';
        $sql .= ' FROM '.DB::table($this->_table).' tr ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**根据条件统计当前订单是第几单
     * @param int $yesterday
     * @return array|bool
     */
    public function currentOrderNum($where){
        $sql  = 'SELECT count(*)';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 培训用 获得订单课程
     */
    public function getTradeCourseListAction($where,$index,$count,$sort){
        $where[]    = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);//未被删除订单
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->trade_order_table." tot on tot.to_t_id = t.t_id "; //to是mysql关键字 不能用
        $sql .= " left join ".$this->train_course_table." atc on atc.atc_id = tot.to_g_id ";
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
     * 婚纱用 获得订单套餐
     */
    public function getTradePackageListAction($where,$index,$count,$sort){
        $where[]    = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);//未被删除订单
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->trade_order_table." tot on tot.to_t_id = t.t_id "; //to是mysql关键字 不能用
        $sql .= " left join ".$this->wedding_package_table." awp on awp.awp_id = tot.to_g_id ";
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
     * 知识付费 获得订单课程
     */
    public function getKnowpayListAction($where,$index,$count,$sort){
        $where[]    = array('name' => 't_deleted', 'oper' => '=', 'value' => 0);//未被删除订单
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->trade_order_table." tot on tot.to_t_id = t.t_id "; //to是mysql关键字 不能用
        $sql .= " left join pre_goods g on g.g_id = tot.to_g_id ";
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
     * 获得指定天数收益订单信息  根据天分组
     */
    public function getTradeInfoByDay($start,$end,$where = array(),$sort = array()){
        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$start);
        $where[] = array('name'=>'t_create_time','oper'=>'<=','value'=>$end);
        $sql = "select FROM_UNIXTIME(t_create_time, '%m-%d') as date,SUM(t_payment) as money,count(*) as number ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY FROM_UNIXTIME(t_create_time, '%Y%m%d') ";
        $sql .= $this->getSqlSort($sort);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得指定天数收益订单信息  根据天分组
     */
    public function getTradeInfoByDayCount($where,$index = 0,$count = 10,$sort = array()){

        $sql = "select FROM_UNIXTIME(t_create_time, '%Y-%m-%d') as date,SUM(t_payment) as money,SUM(t_post_fee) as postFee,count(*) as num ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY FROM_UNIXTIME(t_create_time, '%Y%m%d') ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得指定天数收益订单信息  根据天分组
     */
    public function getCountByDayCount($where){
        $sql = " select count(*) from ";
        $sql .= " (";
        $sql .= " select FROM_UNIXTIME(t_create_time, '%Y-%m-%d') as date,SUM(t_payment) as money,SUM(t_post_fee) as postFee,count(*) as num ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY FROM_UNIXTIME(t_create_time, '%Y%m%d') ";
        //Libs_Log_Logger::outputLog($sql);
        $sql .= " ) as total_count ";
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得指定天数退款订单信息  根据天分组
     */
    public function getTradeRefundByDayCount($where,$index = 0,$count = 10,$sort = array()){
        $sql = "select FROM_UNIXTIME(t_create_time, '%Y-%m-%d') as date,SUM(tr_money) as refund ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_trade_redund tr on t.t_tid = tr.tr_tid ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY FROM_UNIXTIME(t_create_time, '%Y%m%d') ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        //Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得指定月数收益订单信息  按月分组
     */
    public function getTradeInfoByMonth($start,$end,$where = array(),$sort =array()){
        $where[] = array('name'=>'t_status','oper'=>'in','value'=>array(3,4,5,6));
        $where[] = array('name'=>'t_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'t_create_time','oper'=>'>=','value'=>$start);
        $where[] = array('name'=>'t_create_time','oper'=>'<=','value'=>$end);

        $sql = "select FROM_UNIXTIME(t_create_time, '%Y-%m') as date,SUM(t_payment) as money,count(*) as number ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY FROM_UNIXTIME(t_create_time, '%Y%m') ";
        $sql .= $this->getSqlSort($sort);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
 * 拍卖
 */
    public function getAuctionTradeListAction($where,$index,$count,$sort){
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_applet_auction_join aaj on aaj.aaj_tid = t.t_tid "; //to是mysql关键字 不能用
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
     * 社区团购
     */
    public function getSequenceTradeList($where,$index,$count,$sort){
        $sql = "select t.t_id,t.t_tid,t.t_pay_type,t.t_applet_type,t.t_se_send_time,t.t_total_fee,t.t_goods_fee,t.t_discount_fee,t.t_num,t.t_feedback,t.t_buyer_nick,t.t_express_method,t.t_express_company,t.t_express_code,t.t_status,t.t_express_time,t.t_fd_result,t.t_fd_status,t.t_note,t.t_remark_extra,t.t_type,t.t_pic,t.t_create_time,t.t_pay_time,t.t_finish_time,t.t_pickup_code,t.t_qrcode,t.t_se_num,t.t_address,t.t_had_comment,t.t_independent_mall,t.t_coin_payment,ma.*,asg.*,asct.*,asl.*,asa.*,lm.m_nickname as leaderName";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = t.t_addr_id ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = t.t_se_group ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = t.t_se_leader ";
        $sql .= " left join pre_member lm on lm.m_id = asl.asl_m_id ";
        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";
        // 团长订单增加可以根据商品类型尽心查询的分类

        $sql .= " LEFT JOIN `pre_trade_order` ON `t_id`=`to_t_id` ";
        $sql .= " LEFT JOIN `pre_goods` ON `g_id`=`to_g_id` ";

        $sql .= $this->formatWhereSql($where);
        // 团长订单增加可以根据商品类型尽心查询的分类
        $sql .= " GROUP BY t.t_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSequenceTradeListNew($where,$index,$count,$sort){
        $sql = "select t.t_id,t.t_tid,t.t_pay_type,t.t_applet_type,t.t_se_send_time,t.t_total_fee,t.t_goods_fee,t.t_discount_fee,t.t_num,t.t_feedback,t.t_buyer_nick,t.t_express_method,t.t_express_company,t.t_express_code,t.t_status,t.t_express_time,t.t_fd_result,t.t_fd_status,t.t_note,t.t_remark_extra,t.t_type,t.t_pic,t.t_create_time,t.t_pay_time,t.t_finish_time,t.t_pickup_code,t.t_qrcode,t.t_se_num,t.t_address,t.t_had_comment,t.t_independent_mall,t.t_coin_payment,ma.*,asct.*,asl.asl_name,asl.asl_mobile,lm.m_nickname as leaderName";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = t.t_addr_id ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = t.t_se_leader ";
        $sql .= " left join pre_member lm on lm.m_id = asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        //$sql .= " GROUP BY t.t_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSequenceTradeRecord($where,$index,$count,$sort){
        $sql = "select t.t_id,t.t_tid,t.t_pay_type,t.t_applet_type,t.t_feedback,t.t_buyer_nick,t.t_status,t.t_express_time,t.t_fd_result,t.t_fd_status,t.t_create_time,t.t_pay_time,t.t_finish_time,t.t_coin_payment,t.t_payment,(t.t_payment + t.t_coin_payment) as total_pay ";
        $sql .= " from `".DB::table($this->_table)."` t ";
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

    public function getSequenceTradeRecordCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 社区团购
     */
    public function getSequenceTradeRow($tid){
        $where[]    = array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        //$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select t.*,ma.*,asg.*,asct.*,asl.*,asa.*,lm.m_nickname as leaderName ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = t.t_addr_id ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = t.t_se_group ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = t.t_se_leader ";
        $sql .= " left join pre_member lm on lm.m_id = asl.asl_m_id ";
        $sql .= " left join pre_applet_sequence_activity asa on asa.asa_id = asg.asg_a_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSequenceTradeRowNew($tid){
        $where[]    = array('name' => 't_tid', 'oper' => '=', 'value' => $tid);
        //$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select t.*,ma.*,asct.*,asl.*,lm.m_nickname as leaderName ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = t.t_addr_id ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = t.t_se_leader ";
        $sql .= " left join pre_member lm on lm.m_id = asl.asl_m_id ";
//        $sql .= " left join pre_applet_sequence_pick_station asps on asps.asps_id = t.t_expert_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSequenceTradeRowNewWhere($where){
        //$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select t.*,ma.*,asct.*,asl.*,lm.m_nickname as leaderName ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join ".$this->address_table." ma on ma.ma_id = t.t_addr_id ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = t.t_se_leader ";
        $sql .= " left join pre_member lm on lm.m_id = asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 社区团购 小区销售排行榜
     * 订单->群组小区id->团长
     */
    public function sequenceCommunityRank($where,$index,$count,$sort){
        $sql = "SELECT sum(t_payment) as total,asct.asc_name,asct.asc_id ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_applet_sequence_group asg on asg.asg_id = t.t_se_group ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = asg.asg_c_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY asct.asc_id ";
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
     * 社区团购 小区销售排行榜
     * 订单小区id->团长
     */
    public function sequenceCommunityRankNew($where,$index,$count,$sort){
        $sql = "SELECT sum(t_payment) as total,asct.asc_name,asct.asc_id ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY asct.asc_id ";
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
 * 社区团购 小区销售排行榜
 * 订单小区id->团长
 */
    public function sequenceCommunityRankStatistic($where,$index,$count,$sort){
        $sql = "SELECT sum(t_payment) as total, sum(t_num) as nums, asct.*, asl.*, m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = asc_leader ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY asct.asc_id ";
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
     * 社区团购 小区销售排行榜数量
     * 订单小区id->团长
     */
    public function sequenceCommunityRankStatisticCount($where){
        $sql = "SELECT COUNT(*) FROM ( ";
        $sql .= " SELECT asl_id ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_leader asl on asl.asl_id = t.t_se_leader ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY asct.asc_id ) as count_table ";
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }


    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function statOrderStatisticNew($where){
        $sql  = 'SELECT count(*) as tradeNum,sum(t_payment) as payment,sum(t_num) as goodsNum,sum(t_post_fee) as postFee ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得有订单的会员数量
     */
    public function tradeMemberGroupCount($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM (';
        $sql .= 'SELECT t_id FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY t_m_id ';
        $sql .= ' ) as trades ';
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得有订单的会员信息
     */
    public function tradeMemberGroupList($where,$index = 0,$count = 10,$sort){
        $sql  = 'SELECT m.m_avatar, m.m_nickname ';
        $sql .= ' FROM '.DB::table($this->_table).' t ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on t.t_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY t_m_id ';
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
     * 获得有订单的会员id
     */
    public function tradeMemberGroupListNew($where,$index = 0,$count = 10,$sort){
        $sql  = 'SELECT t.t_m_id ';
        $sql .= ' FROM '.DB::table($this->_table).' t ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY t_m_id ';
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
     * 根据条件获取每天的订单数、订单金额、订单商品数量
     */
    public function fetchTradeTotalNumMoneyGroupByDate($where){
        $sql  = 'SELECT COUNT(*)  as total , SUM(t_num) AS goodsNum ,SUM(t_payment) AS money ,SUM(t_points) AS points, FROM_UNIXTIME (`t_pay_time`,"%m/%d") AS curr_date ';
        $sql .= ' FROM '.DB::table($this->_table).' t ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
 * 根据条件获取每天的订单数、订单金额、订单商品数量
 */
    public function fetchTradeTotalNumMoneyGroupByTime($where){
        $sql  = 'SELECT COUNT(*)  as total , SUM(t_num) AS goodsNum ,SUM(t_payment) AS money ,SUM(t_points) AS points, FROM_UNIXTIME (`t_pay_time`,"%H") AS curr_date ';
        $sql .= ' FROM '.DB::table($this->_table).' t ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY curr_date ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据条件获取每天的订单数、订单金额、订单商品数量
     */
    public function fetchTradeTotalNumMoney($where){
        $sql  = 'SELECT COUNT(*)  as total , SUM(t_num) AS goodsNum ,SUM(t_payment) AS money ,SUM(t_points) AS points ';
        $sql .= ' FROM '.DB::table($this->_table).' t ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取会员下单的数量
     */
    public function fetchMemberTradeCount($mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 't_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 't_status', 'oper' => 'in', 'value' => array(3, 4, 5, 6));

        return $this->getCount($where);
    }

    /**
     * [getRegionManagerIdByTid 根据订单主键获取到区域合伙人的id]
     * @param  [type] $tid [订单主键]
     * @return [type]      [description]
     */
    public function getRegionManagerIdByTid($tid){
        $where[]=['name'=>'t_id','oper'=>'=','value'=>$tid];
        $sql=sprintf('SELECT `asl_region_manager_id` FROM %s LEFT JOIN `pre_applet_sequence_leader` ON `t_se_leader` =`asl_id` ',
            DB::table($this->_table));
        $sql.=$this->formatWhereSql($where);
        $res=DB::result_first($sql);
        if($res==='false'){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $res;
    }

    /*
 * 获取订单列表 关联门店表
 */
    public function getListByApplet($where){
        $sql = "select tr.* ";
        $sql .= " from `".DB::table($this->_table)."` tr ";
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = tr.t_s_id ";
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
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = tr.t_s_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
    * 入驻店铺排行统计
    */
    public function enterShopRankStatistic($where,$index,$count,$sort){
        $sql = "SELECT sum(t_payment) as total, sum(t_num) as nums, es.es_id, es.es_name, es.es_logo, acs.acs_id, acs.acs_img, acs.acs_name ";
        $sql .= " from `".DB::table($this->_table)."` t ";
        $sql .= " left join pre_enter_shop es on es.es_id = t.t_es_id ";
        $sql .= " left join pre_applet_city_shop acs on acs.acs_es_id = t.t_es_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY t.t_es_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }

    public function getTradeStatisticBySid($sid){
        $where = array();
        $where[] = array('name' => 't_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 't_status', 'oper' => 'in', 'value' => array(3,4,5,6,8));
        $sql = "select sum(t_total_fee) as tradeTotal,count(t_id) as tradeCount ";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据编号获取订单数据
     */
    public function getTradeDataByNumber($cardNumber){
        $sql  = '';
        $sql .= ' Select * from '.DB::table($this->_table);
        $sql .= ' Where t_s_id = '.$this->sid.' and ';
        $sql .= "( t_pickup_code = '{$cardNumber}' or t_tid = '{$cardNumber}' )";
        $ret  = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得订单 包含删除的
     */
    public function getRowWithDel($where){
        $sql = "select t_id ";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 社区团购生成订到导出到excel时的数据
     * zhangzc
     * 2019-11-13
     * @param  [type] $where [description]
     * @param  [type] $index [description]
     * @param  [type] $count [description]
     * @param  [type] $sort  [description]
     * @return [type]        [description]
     */
    public function getSequenceTradeForExcelExport($where, $index=0, $count=0, $sort) {
        // 主订单要查询的字段
        $field_trade        =['t_tid','t_buyer_nick','t_address','t_goods_fee','t_post_fee','t_total_fee','t_discount_fee','t_promotion_fee','t_payment','t_express_company','t_express_code','t_status','t_pay_type','t_create_time','t_pay_time','t_note','t_express_time','t_finish_time','t_express_method','t_se_send_time','t_remark_extra'];
        // 子订单要查询的字段
        $field_trade_order  =['to_t_id','to_g_id','to_gf_id','to_num','to_title','to_gf_name','to_price','to_total','to_cost','to_feedback','to_fd_status','to_fd_result'];
        // 地址要查询的字段
        $field_address      =['ma_name','ma_phone','ma_province','ma_province','ma_city','ma_zone','ma_detail','ma_post'];
        // 社区要查询的字段
        $field_community    =['asc_name','asc_address','asc_address_detail'];
        // 团长需要查询的字段
        $field_leader       =['asl_name','asl_mobile'];
        // 供应商要查询的字段
        $field_supplier     =['assi_name','assi_contact','assi_mobile'];
        $fields             =array_merge($field_trade,$field_trade_order,$field_address,$field_community,$field_leader,$field_supplier);

        $sql= sprintf('SELECT %s ',implode(',', $fields));
        $sql .= " FROM `".DB::table($this->_table)."` tr ";
        $sql .= " LEFT JOIN ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " LEFT JOIN `pre_applet_sequence_leader` asl on asl.asl_id = tr.t_se_leader ";
        $sql .= " LEFT JOIN `pre_applet_sequence_community` asct on asct.asc_id = tr.t_home_id ";
        $sql .= " RIGHT JOIN `pre_trade_order` tro on tr.t_id = tro.to_t_id ";
        // $sql .= " LEFT JOIN `pre_goods` g on g.g_id = tro.to_g_id ";
        $sql .= " LEFT JOIN `pre_applet_sequence_area` pasa on  asa_id= asc_area ";
        $sql .= " LEFT JOIN `pre_applet_sequence_supplier_info` assi on to_supplier_id= assi.assi_id ";
        
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


}
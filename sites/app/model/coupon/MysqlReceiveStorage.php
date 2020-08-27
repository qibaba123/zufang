<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/14
 * Time: 下午11:12
 */
class App_Model_Coupon_MysqlReceiveStorage extends Libs_Mvc_Model_BaseModel {

    private $member_table='';

    private $coupon_table;
    private $curr_table;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'coupon_receive';
        $this->_pk      = 'cr_id';
        $this->_shopId  = 'cr_s_id';
        $this->member_table = DB::table('');

        $this->curr_table   = DB::table($this->_table);
        $this->coupon_table = DB::table('coupon_list');
    }
    /**
     * 获取指定用户与指定店铺的优惠券
     * zhangzc
     * 2019-10-23
     * @return [type] [description]
     */
    public function getCouponsByUidSid($where, $index=0, $count=0){
        $sql  = 'SELECT cr.cr_expire_time,cl.cl_name,cl_face_val,cr_c_id,cr_id';
        $sql .= ' FROM `pre_coupon_receive` cr ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = cr_c_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getReceiveList($where, $index, $count, $sort){
        $sql  = 'SELECT cr.*,m.m_nickname,m.m_avatar,cl.*, es.es_name, acs.acs_name, acs.acs_id';
        $sql .= ' FROM `pre_coupon_receive` cr ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = cr_c_id ';
        $sql .= ' LEFT JOIN pre_member m ON m.m_id = cr_m_id ';
        $sql .= ' LEFT JOIN pre_enter_shop es ON cl.cl_es_id = es.es_id ';
        $sql .= ' LEFT JOIN pre_applet_city_shop acs on acs.acs_es_id = es.es_id ';
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

    public function getReceiveCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `pre_coupon_receive` cr ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = cr_c_id ';
        $sql .= ' LEFT JOIN pre_member m ON m.m_id = cr_m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取会员已领取的可用优惠券
     */
    public function fetchMemberValidCoupon($mid, $sid, $esId=0) {
        $sql    = "SELECT cr.*,cl.* FROM {$this->curr_table} AS cr LEFT JOIN {$this->coupon_table} AS cl ON cr.cr_c_id=cl.cl_id ";

        $time   = time();
        $where[]    = array('name' => 'cr.cr_s_id', 'oper' => '=', 'value' => $sid);
        //$where[]    = array('name' => 'cr.cr_es_id', 'oper' => '=', 'value' => $esId);
        $where[]    = array('name' => 'cr.cr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'cr.cr_is_used', 'oper' => '=', 'value' => 0);//未被使用
        $where[] = array('name' => 'cl.cl_start_time', 'oper' => '<', 'value' => $time);//已开始
        //if($sid == 5655){
            $where[] = " ((cl.cl_use_time_type=1 and (cl.cl_use_end_time>".$time." or (cl.cl_use_end_time=0 and cl.cl_end_time>".$time."))) or (cl.cl_use_time_type=2 and cr.cr_expire_time>".$time."))";
        /*}else{
            $where[]    = array('name' => 'cl.cl_end_time', 'oper' => '>', 'value' => $time);//未失效
        }*/
        $where[]    = array('name' => 'cl.cl_deleted', 'oper' => '=', 'value' => 0);//未删除
        //$where[]    = array('name' => 'cr.cr_receive_type', 'oper' => '=', 'value' => 0);
        $sql    .= $this->formatWhereSql($where);
        if($esId){
            $sql .= 'and (cr.cr_es_id = 0 or cr.cr_es_id='.$esId.')';
        }else{
            $sql .= 'and cr.cr_es_id = 0';
        }

        $sort   = array('cl.cl_use_limit' => 'ASC');
        $sql    .= $this->getSqlSort($sort);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 查找会员已领取或者兑换某个优惠券的数量
     * $type 领取或者兑换优惠券   type 0 领取  type 1兑换
     * $today 今日领取的数量 -zhangzc  -2019-07-12
     */
    public function getMemberReceiveCount($mid, $cid, $sid,$type=0,$today=FALSE,$postId = 0) {
        $where[]    = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'cr_c_id', 'oper' => '=', 'value' => $cid);
        $where[]    = array('name' => 'cr_s_id', 'oper' => '=', 'value' => $sid);
        //新增条件
        $where[]    = array('name' => 'cr_receive_type', 'oper' => '=', 'value' => $type);
        // 添加今日领取数量的查询
        // zhangzc
        // 2019-07-12
        if($today){
            $where[]=['name'=>'cr_receive_time','oper'=>'>=','value'=>strtotime(date('Ymd',time()))];
            $where[]=['name'=>'cr_receive_time','oper'=>'<','value'=>strtotime(date('Ymd',time()+60 * 60 * 24))];
        }

        if($postId){
            $where[]    = array('name' => 'cr_p_id', 'oper' => '=', 'value' => $postId);
        }
        return intval($this->getCount($where));
    }
    /*
     * 根据优惠券ID查找可用优惠券
     */
    public function findMemberReceiveCoupon($yhqid, $mid, $sid) {
        $sql    = "SELECT cr.*,cl.* FROM {$this->curr_table} AS cr LEFT JOIN {$this->coupon_table} AS cl ON cr.cr_c_id=cl.cl_id ";

        $time   = time();
        $where[]    = array('name' => 'cr.cr_id', 'oper' => '=', 'value' => $yhqid);
        $where[]    = array('name' => 'cr.cr_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cr.cr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'cr.cr_is_used', 'oper' => '=', 'value' => 0);//未被使用
        $where[]    = array('name' => 'cl.cl_start_time', 'oper' => '<', 'value' => $time);//已开始
        $where[]    = array('name' => 'cl.cl_end_time', 'oper' => '>', 'value' => $time);//未失效
        $where[]    = array('name' => 'cl.cl_deleted', 'oper' => '=', 'value' => 0);//未删除

        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 修改领取的优惠券状态
     */
    public function updateCouponReceive($id, $mid, $sid, array $set) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $mid);

        return $this->updateValue($set, $where);
    }
    /*
     * 获取领取的优惠券
     */
    public function fetchCouponReceive($sid, $crid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $crid);

        $sql    = "SELECT cr.*,cl.* FROM `{$this->curr_table}` AS cr ";
        $sql    .= " LEFT JOIN `{$this->coupon_table}` AS cl ON cr.cr_c_id=cl.cl_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取会员领取的优惠信息
     */
    public function fetchCouponList($sid,$mid,$postId = 0){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $mid);
        if($postId){
            $where[]    = array('name' => 'cr_p_id', 'oper' => '=', 'value' => $postId);
        }
        $list = $this->getList($where,0,0);
        $data = array();
        if($list){
            foreach ($list as $value){
                $data[$value['cr_c_id']] = $value;
            }
    }
        return $data;
    }

    /**
     * 获取会员领取的优惠信息
     */
    public function fetchCouponListArr($sid,$mid,$cids){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'cr_c_id', 'oper' => 'in', 'value' => $cids);
        $list = $this->getList($where,0,0);
        $data = array();
        if($list){
            foreach ($list as $value){
                $data[$value['cr_c_id']][] = $value;
            }
        }
        return $data;
    }

    /**
     * @param $where
     * @param string $type
     * @return array|bool
     * 获取会员领取某个优惠券的信息
     */
    public function findMemberReceiveCouponRow($yhqid, $mid, $sid) {
        $sql    = "SELECT cr.*,cl.* FROM {$this->curr_table} AS cr LEFT JOIN {$this->coupon_table} AS cl ON cr.cr_c_id=cl.cl_id ";

        $time   = time();
        $where[]    = array('name' => 'cr.cr_c_id', 'oper' => '=', 'value' => $yhqid);
        $where[]    = array('name' => 'cr.cr_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cr.cr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'cr.cr_is_used', 'oper' => '=', 'value' => 0);//未被使用
        $where[]    = array('name' => 'cl.cl_start_time', 'oper' => '<', 'value' => $time);//已开始
        $where[]    = array('name' => 'cl.cl_end_time', 'oper' => '>', 'value' => $time);//未失效
        $where[]    = array('name' => 'cl.cl_deleted', 'oper' => '=', 'value' => 0);//未删除

        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getReceiveStat($where,$type = ''){
        $timeNow = time();
        if($type == 'used'){
            //已使用
            $where[] = ['name' => 'cr_is_used', 'oper' => '=', 'value' => 1];
        }
        if($type == 'going'){
            //未使用未到期
            $where[] = ['name' => 'cr_is_used', 'oper' => '=', 'value' => 0];
            $where[] = ['name' => 'cl_start_time','oper' => '<','value' =>$timeNow];
            $where[] = ['name' => 'cl_end_time','oper' => '>','value' =>$timeNow];
        }
        if($type == 'expire'){
            //未使用已到期
            $where[] = ['name' => 'cr_is_used', 'oper' => '=', 'value' => 0];
//            $where[] = ['name' => 'cl_end_time','oper' => '!=','value' =>0];
            $where[] = ['name' => 'cl_end_time','oper' => '<','value' =>$timeNow];
        }

        $sql  = 'SELECT count(*) as total,sum(cl_face_val) as money ';
        $sql .= ' FROM `pre_coupon_receive` cr ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = cr_c_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getReceiveTypeCount($sid, $type, $clid,$startTime, $endTime){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cr_c_id', 'oper' => '=', 'value' => $clid);
        if($type == 'receive'){
            //领取的
            $where[] = ['name' => 'cr_receive_time','oper' => '>=','value' =>$startTime];
            $where[] = ['name' => 'cr_receive_time','oper' => '<=','value' =>$endTime];
        }
        if($type == 'used'){
            //使用的
            $where[] = ['name' => 'cr_used_time','oper' => '>=','value' =>$startTime];
            $where[] = ['name' => 'cr_used_time','oper' => '<=','value' =>$endTime];
        }

        return $this->getCount($where);
    }


    public function getReceiveListNoMember($where, $index, $count, $sort){
        $sql  = 'SELECT cr.*,cl.* ';
        $sql .= ' FROM `pre_coupon_receive` cr ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = cr_c_id ';
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

    public function getReceiveCountNoMember($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `pre_coupon_receive` cr ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = cr_c_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 批量插入
     */
    public function batchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`cr_id`,`cr_s_id`, `cr_es_id`, `cr_m_id`, `cr_c_id`, `cr_receive_time`,`cr_expire_time`) ';
            $sql .= ' VALUES '.implode(',',$value);

            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
        return false;
    }

    /**
     * 获取指定的id的优惠券的领取数量
     * zhangzc
     * 2019-10-28
     * @param  array   $ids  [description]
     * @return [type]        [description]
     */
    public function getRecieveRecords($ids=[],$primary=false){
        if(empty($ids))
            return null;
        $sql=sprintf('SELECT COUNT(*) AS receives,`cr_c_id` FROM `%s`',
            DB::table($this->_table));
        $where=[
            ['name' =>'cr_c_id','oper'  =>'in', 'value'=>$ids],
        ];
        $sql.=$this->formatWhereSql($where);
        $sql.='GROUP BY `cr_c_id`';
        $ret  = DB::fetch_all($sql,[],$primary===TRUE?'cr_c_id':'');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/9
 * Time: 下午12:24
 */
class App_Model_Unitary_MysqlPlanStorage extends Libs_Mvc_Model_BaseModel {

    private $plan_table;
    private $goods_table;
    private $kind_table;
    private $member_table;

    private $sid;//店铺id

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'unitary_plan';
        $this->_pk      = 'up_id';
        $this->_shopId  = 'up_s_id';

        $this->sid      = $sid;

        $this->plan_table   = DB::table($this->_table);
        $this->goods_table  = DB::table('unitary_goods');
        $this->kind_table  = DB::table('unitary_kind');
        $this->member_table  = DB::table('member');
        $this->good_table   = DB::table('goods');
    }

    /*
     * 获取夺宝计划列表
     */
    public function fetchPlanList($index = 0, $count = 20, $kind = 0,$sort = array(),$status=0,$limit=null) {
        //$where      = $where_p;
        $where[]    = array('name' => 'up.'.$this->_shopId, 'oper' => '=', 'value' => $this->sid);//店铺信息
        if($status && $status==2){
            $where[]    = array('name' => 'up.up_status', 'oper' => '=', 'value' => 2);
        }else{
            $where[]    = array('name' => 'up.up_status', 'oper' => '<', 'value' => 2);//进行中
        }
        if ($kind) {
            $where[]    = array('name' => 'up.up_k_id', 'oper' => '=', 'value' => $kind);
        }
        if($limit){
            $where[] = array('name'=>'up_money_limit','oper' => '=','value'=>$limit);
        }
        $where_sql  = $this->formatWhereSql($where);
        $limit_sql  = $this->formatLimitSql($index, $count);

        $newSort    = array();
        if ($sort) {
            foreach ($sort as $field => $value) {
                $newSort['up.'.$field]  = $value;
            }
        }
        $sort_sql   = $this->getSqlSort($newSort);

        $sql    = "SELECT up.*,ug.* FROM `{$this->plan_table}` AS up LEFT JOIN `{$this->goods_table}` AS ug ON up.`up_g_id` = ug.`ug_id` {$where_sql} {$sort_sql} {$limit_sql}";
        $list   = DB::fetch_all($sql);
        return $list;
    }

    /*
     * 获取夺宝商品详情
     */
    public function fetchDetailByPlan($pid) {
        $where[]    = array('name' => 'up.'.$this->_shopId, 'oper' => '=', 'value' => $this->sid);//店铺信息
        $where[]    = array('name' => 'up.up_id', 'oper' => '=', 'value' => $pid);//夺宝id

        $where_sql  = $this->formatWhereSql($where);
        $sql    = "SELECT up.*,ug.*,pg.* FROM `{$this->plan_table}` AS up LEFT JOIN `{$this->goods_table}` AS ug ON up.`up_g_id`=ug.`ug_id` LEFT JOIN `{$this->good_table}` AS pg ON ug.ug_g_id = pg.g_id {$where_sql}";
        return DB::fetch_first($sql);
    }

    /*
     * 设置夺宝计划参与人次自增
     */
    public function incrementHadJoin($pid, $num) {
        $field  = array('up_had', 'up_left');
        $inc    = array($num, -$num);

        $where[]    = array('name' => 'up_id', 'oper' => '=', 'value' => $pid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 全部夺宝商品列表
     */
    public function getPlanDataList($where,$index,$count,$sort){
        $sql = 'select up.*,ug.ug_name,uk.uk_name ';
        $sql .= ' from `'.DB::table($this->_table).'` up ';
        $sql .= ' left join '.$this->goods_table.' ug on up.up_g_id  = ug.ug_id ';
        $sql .= ' left join '.$this->kind_table.' uk on up.up_k_id  = uk.uk_id ';
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
     * 查询该商品夺宝期数的最大值
     * @param int $id 商品id
     * @return mixed
     */
    public function getIssueMax($id){
        $where = array();
        $where[] = array('name'=>'up_g_id','oper'=>'=','value'=>$id);
        $sql = 'select MAX(up_issue) ';
        $sql .= ' from `'.DB::table($this->_table).'` ' ;
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $gid
     * @return bool
     * 检查某商品是否有进行中的
     */
    public function goodsIng($gid){
        $where = array();
        $where[] = array('name'=>'up_g_id' ,'oper'=>'=','value'=>$gid);
        $where[] = array('name'=>'up_status' ,'oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId ,'oper'=>'=','value'=>$this->sid);
        return $this->getCount($where);
    }

    /**
     * @param $id
     * @return array|bool
     * 获取中奖用户信息
     */
    public function getMemberById($id){
        $where   = array();
        $where[] = array('name'=>$this->_pk ,'oper'=>'=','value'=>$id);
        $where[] = array('name'=>$this->_shopId ,'oper'=>'=','value'=>$this->sid);

        $sql     = 'SELECT up.*,m_nickname,m_mobile,m_avatar ';
        $sql    .= ' FROM '.$this->plan_table.' up  ';
        $sql    .= ' LEFT JOIN '.$this->member_table.' m on m_id = up_luck_mid ';
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->formatLimitSql(0,1);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 获取当前商品所在的计划中是否有正在进行的
     * $gid 商品id
     */
}
<?php
/*
 * 爆品分销 团长分佣表
 */
class App_Model_Sequence_MysqlSequenceDeductStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $leader_table;
    private $activity_table;
    private $community_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_deduct';
        $this->_pk = 'asd_id';
        $this->_shopId = 'asd_s_id';
        $this->sid = $sid;
        $this->member_table = DB::table('member');
        $this->leader_table = DB::table('applet_sequence_leader');
        $this->activity_table = DB::table('applet_sequence_activity');
        $this->community_table = DB::table('applet_sequence_community');
    }

    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function deductSum($where){
        $sql  = 'SELECT count(*) as num,sum(asd_money) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 社区团购 区域合伙人团长累计统计佣金计算
     * @return [type] [description]
     */
    public function deductSumByRegion($region_id,$area_type='C'){
        if($area_type=='C')
            $area='asa_city';
        elseif($area_type=='D')
            $area='asa_zone';
        $sql=sprintf('SELECT SUM(temp.asd_money) AS money FROM 
            (
                SELECT `asd_money` FROM `%s` 
                LEFT JOIN `%s`  ON `asd_leader`=`asc_leader` 
                LEFT JOIN `%s` ON  `asc_area` =`asa_id` 
                WHERE `asd_s_id`=%d AND `%s`=%d 
                GROUP BY `asd_tid`
            ) AS temp',
            DB::table($this->_table),
            'pre_applet_sequence_community',
            'pre_applet_sequence_area',
            $this->sid,
            $area,
            $region_id);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getListTrade($where,$index,$count,$sort){
        $sql = "select asd.*,t.t_id,t.t_buyer_nick,t.t_goods_fee,t.t_total_fee,t.t_payment,t.t_post_fee,t.t_create_time ";
        $sql .= " from `".DB::table($this->_table)."` asd ";
        $sql .= " left join pre_trade t on t.t_tid = asd.asd_tid ";
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

    public function getCountTrade($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` asd ";
        $sql .= " left join pre_trade t on t.t_tid = asd.asd_tid ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据订单号获得佣金
     */
    public function getRowByTidAction($tid,$leaderId = 0){
        $where = [];
        $where[] = ['name'=>'asd_s_id','oper'=>'=','value'=>$this->sid];
        $where[] = ['name'=>'asd_tid','oper'=>'=','value'=>$tid];
        if($leaderId){
            $where[] = ['name'=>'asd_leader','oper'=>'=','value'=>$leaderId];
        }
        return $this->getRow($where);
    }



}
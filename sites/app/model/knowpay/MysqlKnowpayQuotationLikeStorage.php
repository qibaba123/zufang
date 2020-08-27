<?php

class App_Model_Knowpay_MysqlKnowpayQuotationLikeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_knowpay_quotation_like';
        $this->_pk = 'akql_id';
        $this->_shopId = 'akql_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }

    /**
     * 根据会员ID和帖子ID获取点赞信息
     */
    public function getLikeByMidQid($mid,$pid){
        $where = array();
        $where[] = array('name'=>'akql_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'akql_q_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getRow($where);
    }

    public function getLikeMemberList($pid,$index=0,$count=10){
        $where = array();
        $where[] = array('name'=>'akql_q_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);

        $sql = "select akql.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` akql ";
        $sql .= " left join ".$this->member_table." m on m.m_id = akql.akql_m_id ";

        $sort = array('akql_create_time' => 'DESC');
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

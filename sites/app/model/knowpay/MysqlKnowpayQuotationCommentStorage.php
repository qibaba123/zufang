<?php

class App_Model_Knowpay_MysqlKnowpayQuotationCommentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $quotation;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_knowpay_quotation_comment';
        $this->_pk = 'akqc_id';
        $this->_shopId = 'akqc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->quotation = DB::table('knowpay_classical_quotations');
    }

    /**
     * 获取帖子评论及评论会员信息
     */
    public function getCommentMember($qid,$index=0,$count=20,$verify =false){
        $where = array();
        $where[] = array('name'=>'akqc_q_id','oper'=>'=','value'=>$qid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
//        if($verify){
//            $where[] = array('name'=>'akqc_show','oper'=>'=','value'=>1); //未被封禁
//        }
        $sort = array('akqc_create_time'=>'DESC');
        $sql = "select akqc.*,m.m_id,m.m_nickname,m.m_avatar,rm.m_id rm_id,rm.m_nickname rm_nickname,rm.m_avatar rm_avatar";
        $sql .= " from `".DB::table($this->_table)."` akqc ";
        $sql .= " left join ".$this->member_table." m on m.m_id = akqc.akqc_m_id ";
        $sql .= " left join ".$this->member_table." rm on rm.m_id = akqc.akqc_reply_mid ";

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
     * 获取帖子评论及评论会员信息
     */
    public function getCommentListByMid($mid,$index=0,$count=20){
        $where = array();
        $where[] = array('name'=>'akqc_acp_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('akqc_create_time'=>'DESC');
        $sql = "select akqc.* ";
        $sql .= " from `".DB::table($this->_table)."` akqc ";

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
     * 获取我所评论过的帖子
     */

    public function getCommentPostListMember($where,$index,$count,$sort){
        $sql = "select kqc.*,m.m_id,m.m_nickname,m.m_avatar,m.m_level,m.m_level_long ";
        $sql .= " from `".DB::table($this->_table)."` akqc ";
        $sql .= " left join ".$this->quotation." kqc on kqc.kqc_id = akqc.akqc_q_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kqc.kqc_m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY akqc_q_id ';
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
<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityPostCommentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $post_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_comment';
        $this->_pk = 'acc_id';
        $this->_shopId = 'acc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->post_table = DB::table('applet_community_post');
    }

    /**
     * 获取帖子评论及评论会员信息
     */
    public function getCommentMember($pid,$index=0,$count=20){
        $where = array();
        $where[] = array('name'=>'acc_acp_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('acc_time'=>'ASC');
        $sql = "select acc.*,m.m_id,m.m_nickname,m.m_avatar,rm.m_id rm_id,rm.m_nickname rm_nickname,rm.m_avatar rm_avatar";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acc.acc_m_id ";
        $sql .= " left join ".$this->member_table." rm on rm.m_id = acc.acc_reply_mid ";

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
        $where[] = array('name'=>'acc_acp_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('acc_time'=>'DESC');
        $sql = "select acc.* ";
        $sql .= " from `".DB::table($this->_table)."` acc ";

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
        $sql = "select acp.*,acc.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->post_table." acp on acp.acp_id = acc.acc_acp_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY acc_acp_id ';
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
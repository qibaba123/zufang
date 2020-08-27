<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Applet_MysqlAppletInformationCommentStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $information_table;
    public function __construct($sid){

        parent::__construct();
        $this->_table 	= 'applet_information_comment';
        $this->_pk 		= 'aic_id';
        $this->_shopId 	= 'aic_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->information_table = DB::table('applet_information');
    }

    /**
     * 获取帖子评论及评论会员信息
     */
    public function getCommentMember($aid,$index=0,$count=20,$where = array(),$sort=array()){
        $where[] = array('name'=>'aic_ai_id','oper'=>'=','value'=>$aid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = $sort && !empty($sort) ? $sort : array('aic_time'=>'DESC');
        $sql = "select aic.*,m.m_id,m.m_nickname,m.m_avatar,rm.m_id rm_id,rm.m_nickname rm_nickname,rm.m_avatar rm_avatar";
        $sql .= " from `".DB::table($this->_table)."` aic ";
        $sql .= " left join ".$this->member_table." m on m.m_id = aic.aic_m_id ";
        $sql .= " left join ".$this->member_table." rm on rm.m_id = aic.aic_reply_mid ";

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
     * 获取帖子评论及评论会员信息总数
     */
    public function getCommentCount($aid){
        $where = array();
        $where[] = array('name'=>'aic_ai_id','oper'=>'=','value'=>$aid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` aic ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得评论记录 关联资讯表
     */
    public function getCommentListInformation($where,$index,$count,$sort){

        $sql = "select aic.*,ai.ai_title,ai.ai_brief,ai.ai_cover";
        $sql .= " from `".DB::table($this->_table)."` aic ";
        $sql .= " left join ".$this->information_table." ai on ai.ai_id = aic.aic_ai_id ";
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
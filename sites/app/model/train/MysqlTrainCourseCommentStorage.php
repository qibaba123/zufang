<?php

class App_Model_Train_MysqlTrainCourseCommentStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $curr_table;
    private $member_table;
    private $trade_order_table;

    public function __construct($sid = null){
        $this->_table 	= 'applet_course_comment';
        $this->_pk 		= 'acc_id';
        $this->_shopId 	= 'acc_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->trade_order_table = DB::table('trade_order');
    }

    public function getGoodsCount($gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($gid){
            $where[]    = array('name' => 'acc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删

        return $this->getCount($where);
    }
    /*
     * 获取商品评论列表
     */
    public function getGoodsList($gid, $index = 0, $count = 20) {
        $where[]    = array('name' => 'acc.acc_s_id', 'oper' => '=', 'value' => $this->sid);
        if($gid){
            $where[]    = array('name' => 'acc.acc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]    = array('name' => 'acc.acc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('acc.acc_create_time' => 'DESC');

        $sql    = "SELECT acc.*,m.m_nickname,m.m_avatar,tod.to_gf_name FROM `{$this->curr_table}` AS acc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON acc.acc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `{$this->trade_order_table}` AS tod ON acc.acc_to_id=tod.to_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取商品最新的一条评价
     */
    public function findGoodsNewOne($gid) {
        $where[]    = array('name' => 'acc.acc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc.acc_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'acc.acc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('acc.acc_create_time' => 'DESC');

        $sql    = "SELECT acc.*,m.m_nickname,m.m_avatar FROM `{$this->curr_table}` AS acc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON acc.acc_mid=m.m_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取评论
     */
    public function getCommentRowMember($id){
        $where[]    = array('name' => 'acc.acc_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'acc.acc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('acc.acc_create_time' => 'DESC');
        $sql    = "SELECT acc.*,m.m_nickname,m.m_avatar,atc.atc_title,atc.atc_cover FROM `{$this->curr_table}` AS acc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON acc.acc_mid=m.m_id ";
        $sql    .= " LEFT JOIN `pre_applet_train_course` AS atc ON acc.acc_g_id=atc.atc_id ";

        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



    public function getCommentCount($score = 0,$where = []){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        if($score){
            $where[] = ['name' => 'acc_star', 'oper' => '=', 'value' => $score];
        }
        $sql = "select count(acc_id) as total ";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " LEFT JOIN `pre_applet_train_course` AS atc ON acc.acc_g_id=atc.atc_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 获取店铺评论数量
     */
    public function getCommentListMemberCount($where) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sql    = "SELECT count(*) as total FROM `{$this->curr_table}` AS acc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON acc.acc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_train_course` AS atc ON acc.acc_g_id=atc.atc_id ";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取店铺评论列表
     */
    public function getCommentListMember($where, $index = 0, $count = 20) {
        $where[]    = array('name' => 'acc.acc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acc.acc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('acc.acc_create_time' => 'DESC');

        $sql    = "SELECT acc.*,m.m_nickname,m.m_avatar,atc.atc_title,atc.atc_cover FROM `{$this->curr_table}` AS acc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON acc.acc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_train_course` AS atc ON acc.acc_g_id=atc.atc_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}
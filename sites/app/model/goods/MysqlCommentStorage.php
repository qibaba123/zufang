<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/26
 * Time: 下午5:17
 */
class App_Model_Goods_MysqlCommentStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $curr_table;
    private $member_table;
    private $trade_order_table;

    public function __construct($sid = null){
        $this->_table 	= 'goods_comment';
        $this->_pk 		= 'gc_id';
        $this->_shopId 	= 'gc_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->trade_order_table = DB::table('trade_order');
    }

    public function getGoodsCount($gid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($gid){
            $where[]    = array('name' => 'gc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        return $this->getCount($where);
    }
    /*
     * 获取商品评论列表
     */
    public function getGoodsList($gid, $index = 0, $count = 20) {
        $where[]    = array('name' => 'gc.gc_s_id', 'oper' => '=', 'value' => $this->sid);
        if($gid){
            $where[]    = array('name' => 'gc.gc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]    = array('name' => 'gc.gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('gc.gc_create_time' => 'DESC');

        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar,tod.to_gf_name FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `{$this->trade_order_table}` AS tod ON gc.gc_to_id=tod.to_id ";

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
        $where[]    = array('name' => 'gc.gc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gc.gc_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => 'gc.gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('gc.gc_create_time' => 'DESC');

        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取门店评论列表
     */
    public function getStoreCommentList($storeid = 0,$gid = 0, $index = 0, $count = 20) {
        $where[]    = array('name' => 'gc_s_id', 'oper' => '=', 'value' => $this->sid);
        if($storeid){
            $where[]    = array('name' => 'gc_store_id', 'oper' => '=', 'value' => $storeid);
        }
        if($gid){
            $where[]    = array('name' => 'gc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('gc_create_time' => 'DESC');

        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar FROM `{$this->curr_table}` as gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
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
     * 获取门店评论最新的一条评价
     */
    public function findStoreCommentNewOne($storeid) {
        $where[]    = array('name' => 'gc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gc_store_id', 'oper' => '=', 'value' => $storeid);
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('gc_create_time' => 'DESC');

        $sql    = "SELECT * FROM `{$this->curr_table}` ";

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
     * 获取门店评论数量
     */
    public function getStoreCommentCount($storeid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gc_store_id', 'oper' => '=', 'value' => $storeid);
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        return $this->getCount($where);
    }

    /**
     * 获取门店评论总分数
     */
    public function getStoreScoreTotal($storeid){
        $where[]    = array('name' => 'gc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gc_store_id', 'oper' => '=', 'value' => $storeid);
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sql    = "SELECT sum(gc_star) as total FROM `{$this->curr_table}` ";

        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
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
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sql    = "SELECT count(*) as total FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_hotel_store` AS ahs ON gc.gc_store_id=ahs.ahs_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON gc.gc_g_id=g.g_id ";

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
    public function getCommentListMember($where, $index = 0, $count = 20,$sort = []) {
        $where[]    = array('name' => 'gc.gc_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gc.gc_deleted', 'oper' => '=', 'value' => 0);//未删
        if(!$sort){
            $sort   = array('gc.gc_create_time' => 'DESC');
        }

        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar,ahs.ahs_name,g.g_name,g.g_cover,g.g_independent_mall FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_hotel_store` AS ahs ON gc.gc_store_id=ahs.ahs_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON gc.gc_g_id=g.g_id ";

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

    /**
     * 获取店铺评论数量
     */
    public function getEnterShopCommentListMemberCount($where) {
        $sql    = "SELECT count(*) as total FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_hotel_store` AS ahs ON gc.gc_store_id=ahs.ahs_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON gc.gc_g_id=g.g_id ";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //获取入驻店铺的平均分
    public function getEnterShopAvgScore($esId){
        $where[] = array('name' => 'gc_es_id', 'oper' => '=', 'value' => $esId);
        $sql    = "SELECT AVG(gc_star) as score FROM `{$this->curr_table}` AS gc ";
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
    public function getEnterShopCommentListMember($where, $index = 0, $count = 20) {
        $sort   = array('gc.gc_create_time' => 'DESC');

        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar,ahs.ahs_name,g.g_name,g.g_cover FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_hotel_store` AS ahs ON gc.gc_store_id=ahs.ahs_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON gc.gc_g_id=g.g_id ";

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

    /**
     * 获取评论
     */
    public function getCommentRowMember($id){
        $where[]    = array('name' => 'gc.gc_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'gc.gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('gc.gc_create_time' => 'DESC');
        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar,ahs.ahs_name,g.g_name,g.g_cover FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";
        $sql    .= "LEFT JOIN `pre_applet_hotel_store` AS ahs ON gc.gc_store_id=ahs.ahs_id ";
        $sql    .= "LEFT JOIN `pre_goods` AS g ON gc.gc_g_id=g.g_id ";

        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取入驻门店评论列表
     */
    public function getEnterShopCommentList($id, $gid, $index = 0, $count = 20) {
        $where[]    = array('name' => 'gc_s_id', 'oper' => '=', 'value' => $this->sid);
        if($id){
            $where[]    = array('name' => 'gc_es_id', 'oper' => '=', 'value' => $id);
        }
        if($gid){
            $where[]    = array('name' => 'gc_g_id', 'oper' => '=', 'value' => $gid);
        }
        $where[]    = array('name' => 'gc_deleted', 'oper' => '=', 'value' => 0);//未删

        $sort   = array('gc_create_time' => 'DESC');

        $sql    = "SELECT gc.*,m.m_nickname,m.m_avatar FROM `{$this->curr_table}` AS gc ";
        $sql    .= "LEFT JOIN `{$this->member_table}` AS m ON gc.gc_mid=m.m_id ";

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

    public function getCommentCount($score = 0,$where = []){
        $where[] = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        if($score){
            $where[] = ['name' => 'gc_star', 'oper' => '=', 'value' => $score];
        }
        $sql = "select count(gc_id) as total ";
        $sql .= " from `".DB::table($this->_table)."` gc ";
        $sql .= " LEFT JOIN `pre_goods` AS g ON gc.gc_g_id=g.g_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}
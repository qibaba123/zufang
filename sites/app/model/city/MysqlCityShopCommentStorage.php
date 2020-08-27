<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityShopCommentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $post_table;
    private $apply_shop_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_shop_comment';
        $this->_pk = 'acs_id';
        $this->_shopId = 'acs_s_id';
        $this->_df = 'acs_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->post_table = DB::table('applet_city_shop');
    }

    /**
     * 获取店铺评论及评论会员信息
     */
    public function getCommentMember($sid,$index=0,$count=20){
        $where = array();
        $where[] = array('name'=>'acs_acs_id','oper'=>'=','value'=>$sid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>$this->_df,'oper'=>'=','value'=>0); //未删除
        $sort = array('acs_time'=>'ASC');
        $sql = "select acs.*,m.m_id,m.m_nickname,m.m_avatar,rm.m_id rm_id,rm.m_nickname rm_nickname,rm.m_avatar rm_avatar";
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acs.acs_m_id ";
        $sql .= " left join ".$this->member_table." rm on rm.m_id = acs.acs_reply_mid ";

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
        $where[] = array('name'=>'acs_acp_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sort = array('acs_time'=>'DESC');
        $sql = "select acs.* ";
        $sql .= " from `".DB::table($this->_table)."` acs ";

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
     * 获取评论列表
     */
    public function getCommentListWithMemberShop($where,$index=0,$count=20){

        $sort = array('acs_time'=>'DESC');
        $sql = "select acs.*,m.m_id,m.m_nickname,m.m_avatar,shop.acs_name shopName ";
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acs.acs_m_id ";
        $sql .= " left join ".$this->post_table." shop on shop.acs_id = acs.acs_acs_id ";
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

    public function getCommentCountWithMemberShop($where){

        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acs.acs_m_id ";
        $sql .= " left join ".$this->post_table." shop on shop.acs_id = acs.acs_acs_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);;
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取单条评论
     */
    public function getCommentRowWithMemberShop($id){
        $where[]    = array('name' => 'acs.acs_id', 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => 'acs.acs_deleted', 'oper' => '=', 'value' => 0);//未删

        $sql = "select acs.*,m.m_id,m.m_nickname,m.m_avatar,shop.acs_name shopName ";
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acs.acs_m_id ";
        $sql .= " left join ".$this->post_table." shop on shop.acs_id = acs.acs_acs_id ";
        $sql .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
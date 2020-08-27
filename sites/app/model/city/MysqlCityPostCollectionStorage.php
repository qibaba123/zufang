<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityPostCollectionStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $post_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_collection';
        $this->_pk = 'acc_id';
        $this->_shopId = 'acc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->post_table = DB::table('applet_city_post');
    }

    /**
     * 根据会员ID和帖子ID获取收藏信息
     */
    public function getCollectionByMidPid($mid,$pid){
        $where = array();
        $where[] = array('name'=>'acc_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'acc_acp_id','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getRow($where);
    }

    /**
     * 获取我收藏的帖子信息
     */

    public function getCollectionPostListMember($where,$index,$count,$sort){
        $sql = "select acp.*,m.m_id,m.m_nickname,m.m_avatar,m.m_level,m.m_level_long ";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->post_table." acp on acp.acp_id = acc.acc_acp_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";

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

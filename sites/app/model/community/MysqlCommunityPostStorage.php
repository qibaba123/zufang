<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityPostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $cate_table;

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_community_post';
        $this->_pk     = 'acp_id';
        $this->_shopId = 'acp_s_id';
        $this->_df     = 'acp_deleted';

        $this->sid     = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
        $this->cate_table = DB::table('applet_community_post_cate');
    }

    /**
     * 获取帖子信息及发帖人信息
     */
    public function getPostListMember($where,$index,$count,$sort){
        $sql = "select acp.*,m.m_id,m.m_nickname,m.m_avatar,acpc.* ";
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
        $sql .= " left join ".$this->cate_table." acpc on acpc.acpc_id = acp.acp_cate ";
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

    public function getPostListMemberCount($where){
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
        $sql .= " left join ".$this->cate_table." acpc on acpc.acpc_id = acp.acp_cate ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取单条帖子信息
     */
    public function getPostRowMember($pid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $pid);
        $where[]    = array('name' => 'acp_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT acp.*,m.m_id,m.m_nickname,m.m_avatar,acpc.* ';
        $sql .= " from `".DB::table($this->_table)."` acp ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acp.acp_m_id ";
        $sql .= " left join ".$this->cate_table." acpc on acpc.acpc_id = acp.acp_cate ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReducePostNum($pid,$type,$operation='add',$num=1){
        if($type=='like'){
            $field = 'acp_like_num';
        }elseif ($type=='comment'){
            $field = 'acp_comment_num';
        }elseif($type=='collection'){
            $field = 'acp_collection_num';
        }else{
            $field = 'acp_read_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($pid);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}
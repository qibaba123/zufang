<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityCollectionStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    private $member_extra;
    private $post_table;
    private $enter_shop_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_collection';
        $this->_pk = 'acc_id';
        $this->_shopId = 'acc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->enter_shop_table = DB::table('enter_shop');
        $this->member_table = DB::table('member');
        $this->post_table = DB::table('applet_community_post');
        $this->goods_table = DB::table('goods');
        $this->member_extra = DB::table('applet_member_extra');
    }

    /**
     * 根据会员ID和帖子ID获取收藏信息
     */
    public function getCollectionByMidPid($mid,$pid, $type){
        $where = array();
        $where[] = array('name'=>'acc_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>'acc_cid','oper'=>'=','value'=>$pid);
        $where[] = array('name'=>'acc_type','oper'=>'=','value'=>$type);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        return $this->getRow($where);
    }

    /**
     * 获取我收藏的店铺信息(建议重新修改)
     */
    public function getCollectionShopListMember($where,$index,$count,$sort, $lng, $lat){
        $sql = 'select es.*,ame.ame_car_num,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-es_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(es_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-es_lat)/360),2)))) distance';
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->enter_shop_table." es on es.es_id = acc.acc_cid and es.es_deleted = 0 ";
        $sql .= " left join ".$this->member_extra." ame on es.es_m_id = ame.ame_m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= "  GROUP BY es.es_id HAVING es.es_id >0 ";
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
     * 获取我收藏的商品信息
     */
    public function getCollectionGoodsListMember($where,$index,$count,$sort){
        $sql = "select g.* ";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->goods_table." g on g.g_id = acc.acc_cid ";

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
     * 获取我收藏的帖子信息
     */
    public function getCollectionPostListMember($where,$index,$count,$sort){
        $sql = "select acp.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->post_table." acp on acp.acp_id = acc.acc_cid ";
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

    /**
     * 获取我收藏的帖子信息
     */
        public function getCollectionCarResourceListMember($lng,$lat,$where,$index,$count,$sort){
            $sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,acri.acri_path ';
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join pre_applet_car_resource acr on acr.acr_id = acc.acc_cid ";
        $sql .= " left join pre_car_brand cb on cb.cb_id = acr.acr_car_brand ";
        $sql .= " left join pre_car_type ct on ct.ct_id = acr.acr_car_type ";
        $sql .= " left join pre_applet_car_resource_img acri on acri.acri_car_id = acc.acc_cid ";
        $sql .= $this->formatWhereSql($where);
        $sql .= "GROUP BY acc_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCollectionListMember($where,$index,$count,$sort){
        $sql = "select acc.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` acc ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acc.acc_m_id ";
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

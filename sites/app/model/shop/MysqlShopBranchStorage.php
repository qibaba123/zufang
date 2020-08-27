<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/30
 * Time: 下午3:17
 */
class App_Model_Shop_MysqlShopBranchStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shopTable;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_branch';
        $this->_pk      = 'sb_id';
        $this->_shopId  = 'sb_s_id';
        $this->sid      = $sid;
        $this->shopTable   = DB::table('shop');
        $this->_df      = 'sb_deleted';
    }
    /*
     * 查找分店
     */
    public function findBranchByFidSid($fxid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'sb_id', 'oper' => '=', 'value' => $fxid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除

        return $this->getRow($where);
    }

    public function findBranchByMid($mid, $fid=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'sb_m_id', 'oper' => '=', 'value' => $mid);
        if($fid){
            $where[]    = array('name' => 'sb_f_id', 'oper' => '=', 'value' => $fid);
        }
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
        return $this->getRow($where);
    }

    /**
     * @param $where
     * @param int $index
     * @param int $count
     * @param array $sort
     * @return array|bool
     * 联立会员表，查询昵称和会员编号
     */
    public function getMemberList($where,$index=0,$count=0,$sort=array('sb_update_time' => 'DESC')){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT sb.*,m_nickname,m_show_id, m.m_avatar, m.m_follow_time, m.m_traded_money,p.region_name as p_name ,c.region_name as c_name,a.region_name as a_name ';
        $sql .= ' FROM `pre_shop_branch` sb ';
        $sql .= ' LEFT JOIN pre_china_address p ON p.region_id = sb_pro ';
        $sql .= ' LEFT JOIN pre_china_address c ON c.region_id = sb_city ';
        $sql .= ' LEFT JOIN pre_china_address a ON a.region_id = sb_area ';
        $sql .= ' LEFT JOIN pre_member m ON m_id = sb_m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberRow($id){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $list       = $this->getMemberList($where,0,1);
        $data       = array();
        if(!empty($list)){
            $data =  $list[0];
        }
        return $data;
    }

    public function getMemberCount($where){
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `pre_shop_branch` sb ';
        $sql .= ' LEFT JOIN pre_member m ON m_id = sb_m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $mobile
     * @return bool
     * 检查手机号是否申请过
     */
    public function checkMobileHasApply($mobile){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'sb_phone', 'oper' => '=', 'value' => $mobile);
        $where[]    = array('name' => 'sb_status', 'oper' => 'in', 'value' => array(0,1));
        return $this->getCount($where);
    }

    /**
     * @param $mid
     * @return bool
     * 校验该用户已经申请过
     */
    public function checkMemberHasApply($mid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'sb_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'sb_status', 'oper' => 'in', 'value' => array(0,1));
        return $this->getCount($where);
    }
}
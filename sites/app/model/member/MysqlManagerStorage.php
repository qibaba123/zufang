<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/16
 * Time: 下午6:33
 */

class App_Model_Member_MysqlManagerStorage extends Libs_Mvc_Model_BaseModel {

    private $member_table;
    public function __construct() {
        parent::__construct();
        $this->_table   = 'manager';
        $this->_pk      = 'm_id';
        $this->member_table = DB::table('member');
    }
    /**
     * 检查工号是不是存在
     */
    public function findManagerByNumber($osId,$number){
        $where   = array();
        $where[] = array('name'=>'m_bind_sid','oper'=>'=','value'=>$osId);
        $where[] = array('name'=>'m_job_number','oper'=>'=','value'=>$number);
        return $this->getRow($where);
    }




    /**
     * 按特定手机号字段检索管理员
     * @param mixed $mobile
     * @return array|bool
     */
    public function findManagerByMobile($mobile) {
        $where[]    = array('name' => 'm_mobile', 'oper' => '=', 'value' => $mobile);

        $ret = $this->getRow($where);

        return $ret;
    }

    public function checkMobile($mobile,$id=0){
        $where   = array();
        $where[] = array('name' => 'm_mobile', 'oper' => '=', 'value' => $mobile);
        if($id){
            $where[] = array('name' => 'm_id', 'oper' => '!=', 'value' => $id);
        }
        return $this->getCount($where);
    }

    public function getRowCompanyShop($id,$cid,$sid){

    }


    /*
     * 根据公司id获取该公司下的所有管理员
     */
    public function getManagerByCompany($id,$sort = array()){
        $where = array();
        $where[] = array('name'=>'m_c_id','oper'=>'=','value'=>$id);
        $where[] = array('name'=>'m_status','oper'=>'=','value'=>0);
        if(empty($sort)){
            $sort = array('m_createtime'=>'DESC');
        }
        $list = $this->getList($where,0,0,$sort);
        return $list;
    }
    /*
     * 通过union ID获取管理员信息
     */
    public function findManagerByUnionid($unionid) {
        $where[]    = array('name' => 'm_wx_unionid', 'oper' => '=', 'value' => $unionid);

        $ret = $this->getRow($where);

        return $ret;
    }

    /**
     * 根据公司获取一条主管理员的信息
     */
    public function findManagerByCid($cid){
        $where   = array();
        $where[] = array('name' => 'm_c_id', 'oper' => '=', 'value' => $cid);
        $where[] = array('name' => 'm_fid', 'oper' => '=', 'value' => 0);
        return $this->getRow($where);
    }

    /**
     * 获取管理员列表（会员信息）
     */
    public function getListWithMember($where, $index, $count, $sort){
        $sql  = ' SELECT ma.*, m.m_id as mid,m.m_nickname as mnickname, m.m_avatar as mavatar, m.m_openid as mopenid, s.s_id, ac.ac_type, ac.ac_name, ma.m_job_number as mjob';
        $sql .= " from `".DB::table($this->_table)."` ma ";
        $sql .= " left join ".$this->member_table." m on m.m_id = ma.m_weixin_mid ";
        $sql .= " left join pre_shop s on s.s_c_id = ma.m_c_id ";
        $sql .= " left join pre_applet_cfg ac on ac.ac_s_id = s.s_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP by ma.m_id ';
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
     * 获取社区团购区域合伙人管理员
     * zhangzc
     * 2019-03-21
     * @return [type] [description]
     */
    public function  getListWithArea($where,$index,$count,$sort){
        $sql=sprintf('SELECT `m_id`,`m_nickname`,`m_mobile`,`m_area_id`,`m_status`,`m_createtime`,dpl_zone.`region_name` as zone,dpl_city.`region_name` as city,`m_area_type`,`m_area_brokerage`,`m_area_region_goods_brokerage` FROM %s 
            LEFT JOIN `dpl_china_address` AS dpl_zone ON dpl_zone.`region_id`=m_area_id 
            LEFT JOIN `dpl_china_address` AS dpl_city ON dpl_city.`region_id`=dpl_zone.`parent_id` ',
            DB::table($this->_table));
        $sql.=$this->formatWhereSql($where);
        $sql.=$this->getSqlSort($sort);
        $sql.=$this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
    * 社区团购获取单个区域合伙人的信息
    * @param  [type] $mid   [管理员id]
    * @param  [type] $cid   [公司id]
    * @return [type]        [description]
    */
    public function getSingleManagerWithArea($mid,$cid){
        $where=[
            ['name'=>'m_id','oper'=>'=','value'=>$mid],
            ['name'=>'m_area_status','oper'=>'=','value'=>1],
            ['name'=>'m_area_region_child','oper'=>'!=','value'=>1],
            ['name'=>'m_c_id','oper'=>'=','value'=>$cid],
        ];
        $sql=sprintf('SELECT `m_id`,`m_nickname`,`m_mobile`,`m_area_id`,`m_status`,`m_createtime`,`region_name`,`m_area_type`,`m_area_brokerage`,`m_area_region_goods_brokerage`,`m_wx_openid`,`m_area_region_child` FROM %s 
            LEFT JOIN `dpl_china_address` ON `region_id`=m_area_id ',
            DB::table($this->_table));
        $sql.=$this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
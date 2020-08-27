<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/12
 * Time: 下午4:20
 */
class App_Model_Agent_MysqlOpenStorage extends Libs_Mvc_Model_BaseModel {

    private $aid;  // 管理员ID

    private $manager_table;
    private $company_table;
    private $shop_table;
    private $applet_cfg;
    private $core_table;
    private $oem_table;
    private $wxapp_table;
    private $center_tool_table;
    private $baidu_cfg_table;

    private $applet_bd_cfg;
    private $applet_alipay_cfg;
    private $applet_toutiao_cfg;
    private $applet_weixin_cfg;
    private $applet_qq_cfg;
    private $face_settled_apply_table; // 刷脸专用
    private $face_alipay_pay;//刷脸支付宝配置
    private $face_applet_pay;//刷脸微信配置

    public function __construct($aid='') {
        parent::__construct();
        $this->_table  = 'agent_open';
        $this->_pk     = 'ao_id';
        $this->aid     = $aid;
        $this->manager_table        = DB::table('manager');
        $this->company_table        = DB::table('company');
        $this->shop_table           = DB::table('shop');
        // 获取小程序中技术服务提供商字段
        $this->applet_cfg           = DB::table('applet_cfg');
        $this->applet_bd_cfg        = DB::table('applet_baidu_cfg');
        $this->applet_alipay_cfg    = DB::table('applet_alipay_cfg');
        $this->applet_toutiao_cfg    = DB::table('applet_toutiao_cfg');
        $this->applet_weixin_cfg    = DB::table('applet_weixin_cfg');
        $this->applet_qq_cfg        = DB::table('applet_qq_cfg');

        $this->core_table           = DB::table('agent_admin');
        $this->oem_table            = DB::table('agent_oem');
        $this->wxapp_table          = DB::table('applet_wxapp');
        $this->center_tool_table    = DB::table('center_tool');
        $this->baidu_cfg_table      = DB::table('applet_baidu_cfg');
        $this->face_settled_apply_table = DB::table('face_settled_apply');
    }


    /**
     *获取代理商管理的店铺信息
     */
    public function getShopList($where,$index,$count,$sort,$appletType = '',$face=''){
        if($this->aid){
            $where[] = array('name'=>'ao_a_id','oper'=>'=','value'=>$this->aid);
        }
        // 添加百度与支付宝小程序技术支持厂家文本信息
        // $sql = 'select s.*, c.*, m.*, ac.*, ao.*, paw.*,alic.ac_watermark as ali_watermark,bdc.ac_watermark as bd_watermark';
        $sql = 'select s.*, c.*, m.*, fsa.*, ac.*, ao.*, paw.*';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->shop_table.' s on ao.ao_s_id = s.s_id ';
        $sql .= ' left join '.$this->company_table.' c on ao.ao_c_id = c.c_id ';
        $sql .= ' left join '.$this->manager_table.' m on ao.ao_c_id = m.m_c_id ';
        $sql .= ' left join '.$this->face_settled_apply_table.' fsa on fsa_s_id = s.s_id ';
        if($appletType == 'baidu'){
            $sql .= ' left join '.$this->applet_bd_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'alixcx'){
            $sql .= ' left join '.$this->applet_alipay_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'toutiao'){
            $sql .= ' left join '.$this->applet_toutiao_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'weixin'){
            $sql .= ' left join '.$this->applet_weixin_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'qq'){
            $sql .= ' left join '.$this->applet_qq_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }else{
            $sql .= ' left join '.$this->applet_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }
        // 添加百度与支付宝小程序技术支持文本
        // $sql .= ' left join '.$this->applet_bd_cfg.' bdc on bdc.ac_s_id = ao.ao_s_id';
        // $sql .= ' left join '.$this->applet_alipay_cfg.' alic on alic.ac_s_id = ao.ao_s_id';

        $sql .= ' left join '.$this->wxapp_table.' paw on ac.ac_s_id = paw.paw_s_id';
        //$sql .= ' left join '.$this->baidu_cfg_table.' abc on abc.ac_s_id = ao.ao_s_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY s.s_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getShopListFace($where,$index,$count,$sort,$appletType = '',$face=''){
        if($this->aid){
            $where[] = array('name'=>'ao_a_id','oper'=>'=','value'=>$this->aid);
        }
        // 添加百度与支付宝小程序技术支持厂家文本信息
        // $sql = 'select s.*, c.*, m.*, ac.*, ao.*, paw.*,alic.ac_watermark as ali_watermark,bdc.ac_watermark as bd_watermark';
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->shop_table.' s on ao.ao_s_id = s.s_id ';
        $sql .= ' left join '.$this->company_table.' c on ao.ao_c_id = c.c_id ';
        $sql .= ' left join '.$this->manager_table.' m on ao.ao_c_id = m.m_c_id ';
        $sql .= ' left join '.$this->face_settled_apply_table.' fsa on fsa_s_id = s.s_id ';
        if($face){
            $sql .= ' left join '.DB::table('face_alipay_pay').' fap on fap.fap_s_id = s.s_id';
            $sql .= ' left join '.DB::table('face_applet_pay').' ap on ap.ap_s_id = s.s_id';
        }
        if($appletType == 'baidu'){
            $sql .= ' left join '.$this->applet_bd_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'alixcx'){
            $sql .= ' left join '.$this->applet_alipay_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'toutiao'){
            $sql .= ' left join '.$this->applet_toutiao_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'weixin'){
            $sql .= ' left join '.$this->applet_weixin_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }elseif ($appletType == 'qq'){
            $sql .= ' left join '.$this->applet_qq_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }else{
            $sql .= ' left join '.$this->applet_cfg.' ac on ac.ac_s_id = ao.ao_s_id';
        }


        // 添加百度与支付宝小程序技术支持文本
        // $sql .= ' left join '.$this->applet_bd_cfg.' bdc on bdc.ac_s_id = ao.ao_s_id';
        // $sql .= ' left join '.$this->applet_alipay_cfg.' alic on alic.ac_s_id = ao.ao_s_id';

        $sql .= ' left join '.$this->wxapp_table.' paw on ac.ac_s_id = paw.paw_s_id';
        //$sql .= ' left join '.$this->baidu_cfg_table.' abc on abc.ac_s_id = ao.ao_s_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY s.s_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取代理商开通店铺数量
     */
    /**
     *获取代理商管理的店铺数量
     */
    public function getOpenCount(){
        $where[] = array('name'=>'ao_a_id','oper'=>'=','value'=>$this->aid);
        return $this->getCount($where);
    }

    /**
     *获取代理商管理的店铺数量
     */
    public function getShopListCount($where){
        $where[] = array('name'=>'ao_a_id','oper'=>'=','value'=>$this->aid);
        $sql = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->shop_table.' s on ao.ao_s_id = s.s_id ';
        $sql .= ' left join '.$this->company_table.' c on ao.ao_c_id = c.c_id ';
        $sql .= ' left join '.$this->applet_cfg.' ac on ao.ao_s_id = ac.ac_s_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return intval($ret);
    }

    /**
     * 获取单位时间内代理商开启的店铺
     */
    public function getCountByTime($start,$end,$name){
        $where   = array();
        $where[] = array('name'=>'aa_name','oper'=>'=','value'=>$name);
        $where[] = array('name'=>'ao_open_time','oper'=>'>=','value'=>$start);
        $where[] = array('name'=>'ao_open_time','oper'=>'<','value'=>$end);
        $sql = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->core_table.' aa on ao.ao_a_id = aa.aa_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return intval($ret);
    }
    /**
     * 获取单位时间内开通的小程序数量
     */
    public function getCountAppletByTime($start,$end,$name){
        $where   = array();
        $where[] = array('name'=>'aa_name','oper'=>'=','value'=>$name);
        $where[] = array('name'=>'ac_open_time','oper'=>'>=','value'=>$start);
        $where[] = array('name'=>'ac_open_time','oper'=>'<','value'=>$end);
        $where[] = array('name'=>"ac_type",'oper'=>'>','value'=>0);
        $where[] = array('name'=>"ac_expire_time",'oper'=>'>','value'=>time());
        $sql = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->core_table.' aa on ao.ao_a_id = aa.aa_id ';
        $sql .= ' left join '.$this->applet_cfg.' ac on ao.ao_s_id = ac.ac_s_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return intval($ret);
    }

    /**
     * 获取总共的开通小程序的数量
     */
    public function getTipsAppletCount($where, $index, $count){
        $sql  = 'select count(*) as num , aa_id, aa_mobile';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->core_table.' aa on ao.ao_a_id = aa.aa_id ';
        $sql .= ' left join '.$this->applet_cfg.' ac on ao.ao_s_id = ac.ac_s_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY aa_id ';
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取总共的开通小程序的数量
     */
    public function getCountAppletAll($index=0,$count=10){
        $where   = array();
        $where[] = array('name'=>"ac_type",'oper'=>'>','value'=>0);
        $where[] = array('name'=>"ac_expire_time",'oper'=>'>','value'=>time());
        $sql  = 'select count(*) as total , aa_name as name ';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->core_table.' aa on ao.ao_a_id = aa.aa_id ';
        $sql .= ' left join '.$this->applet_cfg.' ac on ao.ao_s_id = ac.ac_s_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY aa_id ';
        $sql .= ' ORDER BY total DESC ';
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据公司ID获取代理商的信息
     */
    public function getAgentOemBySid($cid,$openOem = 1){
        $where[] = array('name'=>'ao_c_id','oper'=>'=','value'=>$cid);
        if($openOem){
            $where[] = array('name'=>'aa_open_oem','oper'=>'=','value'=>1);
        }
        $sql = 'select aa.*,aom.ao_domain,aom.ao_name';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->core_table.' aa on ao.ao_a_id = aa.aa_id ';
        $sql .= ' left join '.$this->oem_table.' aom on ao.ao_a_id = aom.ao_aa_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据店铺ID获取代理商信息
     */
    public function getAgentBySid($sid,$uid=0){
        $where[] = array('name'=>'ao_s_id','oper'=>'=','value'=>$sid);
        if($uid){
            $where[] = array('name'=>'ao_a_id','oper'=>'=','value'=>$uid);
        }
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` ao ';
        $sql .= ' left join '.$this->core_table.' aa on ao.ao_a_id = aa.aa_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
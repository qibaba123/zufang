<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Job_MysqlJobCompanyStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $cate_table;
    private $member_table;
    private $enter_shop;
    private $enter_shop_manager;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_job_company';
        $this->_pk = 'ajc_id';
        $this->_shopId = 'ajc_s_id';
        $this->_df = 'ajc_deleted';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->cate_table = 'applet_job_category';
        $this->member_table = 'member';
        $this->enter_shop = 'enter_shop';
        $this->enter_shop_manager = 'enter_shop_manager';
    }

    // 获取店铺单条信息及分类名
    public function getCompanyRowWithCategory($where){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql  = ' SELECT ajc.*,acc.ajc_name,acc.ajc_id ';
        $sql .= " from `".DB::table($this->_table)."` ajc ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on ajc.ajc_cate2 = acc.ajc_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 获取店铺单条信息及分类名
    public function getCompanyCategoryById($id){
        $where[] = array('name' => 'ajc.ajc_id', 'oper' => '=', 'value' => $id);
        $sql  = ' SELECT ajc.*,acc.ajc_name,acc.ajc_id ';
        $sql .= " from `".DB::table($this->_table)."` ajc ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on ajc.ajc_cate2 = acc.ajc_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 获取公司列表信息及分类名
    public function getCompanyListWithCategory($where, $index, $count, $sort){
        $where[] = array('name' => 'ajc.ajc_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'ajc.ajc_s_id', 'oper' => '=', 'value' => $this->sid);
        $sql  = ' SELECT ajc.*,acc.ajc_name,acc.ajc_id,es.es_expire_time,es.es_id,es.es_status,es_balance,esm.esm_id,esm.esm_mobile,esm.esm_password';
        $sql .= " from `".DB::table($this->_table)."` ajc ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on ajc.ajc_cate2 = acc.ajc_id ";
        $sql .= " left join `".DB::table($this->enter_shop)."` es on ajc.ajc_es_id = es.es_id ";
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_manager)." esm on es.es_id = esm.esm_es_id ";
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

    public function getCompanyCountWithCategory($where){
        $where[] = array('name' => 'ajc.ajc_deleted', 'oper' => '=', 'value' => 0);
        $where[] = array('name' => 'ajc.ajc_s_id', 'oper' => '=', 'value' => $this->sid);
        $sql  = ' SELECT count(*)';
        $sql .= " from `".DB::table($this->_table)."` ajc ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on ajc.ajc_cate2 = acc.ajc_id ";
        $sql .= " left join `".DB::table($this->enter_shop)."` es on ajc.ajc_es_id = es.es_id ";
        $sql .= " LEFT JOIN ".DB::table($this->enter_shop_manager)." esm on es.es_id = esm.esm_es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 通过店铺id和用户ID获取用户入住信息
     */
    public function findCompanyByShopId($esId) {
        $where   = array();
        //$where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajc_es_id', 'oper' => '=', 'value' => $esId);
        return $this->getRow($where);
    }

    // 根据距离排序店铺信息
    public function getCompanyListDistanceAsc($where,$index,$count,$sort,$lng,$lat){
        $sql  = ' SELECT ajc.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ajc_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ajc_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ajc_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` ajc ";
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
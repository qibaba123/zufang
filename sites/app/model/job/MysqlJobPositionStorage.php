<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Job_MysqlJobPositionStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_job_position';
        $this->_pk = 'ajp_id';
        $this->_shopId = 'ajp_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
     * 通过店铺id和订单编号获取职位信息
     */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ajp_number', 'oper' => '=', 'value' => $number);
        $where[]    = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    // 根据距离排序获取帖子信息
    public function getListDistanceAsc($where,$index,$count,$sort,$lng,$lat,$name='',$purpose_city = ''){
        $where[] = array('name' => 'ajc_status', 'oper' => '=', 'value' => 2);
        if($purpose_city){
            $sql  = ' SELECT ajp.*,ajc.ajc_company_name,ajc.ajc_logo,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ajp_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ajp_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ajp_lat)/360),2)))) distance,(case when ajp_city_code in ('.$purpose_city.') then 1 else 0 end) as purpose ';
        }else{
            $sql  = ' SELECT ajp.*,ajc.ajc_company_name,ajc.ajc_logo,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-ajp_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(ajp_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-ajp_lat)/360),2)))) distance ';
        }

        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_company ajc on ajp.ajp_es_id = ajc.ajc_es_id";
        $sql .= $this->formatWhereSql($where);
        if($name){
            $sql .= " and (ajp_title like '%{$name}%' or ajc_company_name like '%{$name}%')";
        }
        if($this->sid == 8589){
            Libs_Log_Logger::outputLog($sql,'test.log');
        }

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序获取帖子信息
    public function getListCompany($where,$index,$count,$sort,$name='',$purpose_city = ''){
        $where[] = array('name' => 'ajc_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);
        if($purpose_city){
            $sql  = ' SELECT ajp.*,ajc.ajc_company_name,ajc.ajc_logo,(case when ajp_city_code in ('.$purpose_city.') then 1 else 0 end) as purpose ';
        }else{
            $sql  = ' SELECT ajp.*,ajc.ajc_company_name,ajc.ajc_logo ';
        }

        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_company ajc on ajp.ajp_es_id = ajc.ajc_es_id";
        $sql .= $this->formatWhereSql($where);
        if($name){
            $sql .= " and (ajp_title like '%{$name}%' or ajc_company_name like '%{$name}%')";
        }
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        if($this->sid == 8589){
            Libs_Log_Logger::outputLog($sql,'test.log');
        }

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //根据公司id获取职位列表
    public function getPositionByCid($esId, $count = 0){
        //$where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'ajp_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);

        $sort    = array('ajp_update_time' => 'desc', 'ajp_create_time' => 'desc');
        $sql  = ' SELECT *';
        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_category ajc on ajp.ajp_kind2 = ajc.ajc_id";
        $sql .= " left join pre_applet_job_company ac on ajp.ajp_es_id = ac.ajc_es_id";

        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //根据公司id获取职位列表
    public function getPositionCategoryByCid($esId){
        $where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'ajp_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT *';
        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_category ajc on ajp.ajp_kind2 = ajc.ajc_id";
        $sql .= $this->formatWhereSql($where);
        $sql .= " group by ajp_kind2";

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //获取职位列表
    public function getPositionCategoryCompanyCount($where){
        $where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT count(*)';
        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_company ac on ajp.ajp_es_id = ac.ajc_es_id";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //获取职位列表
    public function getPositionCategoryCompanyList($where, $index, $count){
        $where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);

        $sort    = array('ajp_create_time' => 'desc', 'ajp_update_time' => 'desc');
        $sql  = ' SELECT *';
        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_category ajc on ajp.ajp_kind2 = ajc.ajc_id";
        $sql .= " left join pre_applet_job_company ac on ajp.ajp_es_id = ac.ajc_es_id";

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

    //根据职位id获取职位列表
    public function getPositionCategoryById($id){
        //$where[] = array('name' => 'ajp_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_id', 'oper' => '=', 'value' => $id);

        $sql  = ' SELECT *';
        $sql .= " from `".DB::table($this->_table)."` ajp";
        $sql .= " left join pre_applet_job_category ajc on ajp.ajp_kind2 = ajc.ajc_id";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 增加或减少阅读数、评论数、点赞数 分享数 $operation=add添加 $operation=reduce减少
     */
    public function addReducePositionNum($aid,$type,$operation='add',$num=1){
        if($type=='show'){
            $field = 'ajp_show_num';
        }elseif ($type=='comment'){
            $field = 'ajp_comment_num';
        }elseif($type=='share'){
            $field = 'ajp_share_num';
        }elseif($type=='collection'){
            $field = 'ajp_collection_num';
        }else{
            $field = 'ajp_show_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($aid);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 根据公司获取职位数量
     */
    public function getCompanyPositionCount($esid){
        $where   = array();
        $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esid);
        $where[] = array('name' => 'ajp_deleted', 'oper' => '=', 'value' => 0);
        return $this->getCount($where);
    }
}
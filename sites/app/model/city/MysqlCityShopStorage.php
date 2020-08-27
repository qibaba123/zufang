<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityShopStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $cate_table;
    private $member_table;
    private $enter_shop;
    private $enter_shop_manager;
    private $enter_shop_plugin_open;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_shop';
        $this->_pk = 'acs_id';
        $this->_shopId = 'acs_s_id';
        $this->_df = 'acs_deleted';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->cate_table = 'applet_city_category';
        $this->member_table = 'member';
        $this->enter_shop = 'enter_shop';
        $this->enter_shop_manager = 'enter_shop_manager';
        $this->enter_shop_plugin_open = 'enter_shop_plugin_open';
    }

    // 根据距离排序店铺信息
    public function getShopListDistanceAsc($where,$index,$count,$sort,$lng,$lat){
        $sql  = ' SELECT acs.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acs_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acs_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acs_lat)/360),2)))) distance,es.es_isbuy,es.es_limit_open,es.es_group_open,es.es_bargain_open,es.es_hand_close, ';
        $sql .= "(case  when acs.acs_open_start = '' or acs.acs_open_end = '' or acs.acs_open_start is null or acs.acs_open_end is null then 1  when unix_timestamp(concat(curdate(),' ',acs.acs_open_start)) < unix_timestamp(concat(curdate(),' ',acs.acs_open_end))  AND unix_timestamp(concat(curdate(),' ',acs.acs_open_start)) < unix_timestamp()  AND unix_timestamp(concat(curdate(),' ',acs.acs_open_end)) > unix_timestamp() then 1  when unix_timestamp(concat(curdate(),' ',acs.acs_open_start)) >= unix_timestamp(concat(curdate(),' ',acs.acs_open_end))  AND ((unix_timestamp(concat(curdate(),' ',acs.acs_open_start)) <= unix_timestamp() AND unix_timestamp() <=unix_timestamp(concat(curdate(),' ','23:59'))) OR  (unix_timestamp(concat(curdate(),' ',acs.acs_open_end)) >= unix_timestamp() AND  unix_timestamp(concat(curdate(),' ','0:00')) <= unix_timestamp())) then 1  else 2 end) as openStatus ";
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join pre_enter_shop es on acs.acs_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
//        Libs_Log_Logger::outputLog($sql);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @param $lng
     * @param $lat
     * @param $time [当前时间戳]
     * @param $date [当前日期 2019-10-12]
     * @return array|bool
     */
    public function getShopListDistanceAscCustomTime($where,$index,$count,$sort,$lng,$lat,$time,$date){
        $sql  = ' SELECT acs.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acs_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acs_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acs_lat)/360),2)))) distance,es.es_isbuy,es.es_limit_open,es.es_group_open,es.es_bargain_open,es.es_hand_close, ';
        $sql .= "(case  when acs.acs_open_start = '' or acs.acs_open_end = '' or acs.acs_open_start is null or acs.acs_open_end is null then 1  when unix_timestamp(concat('".$date."',' ',acs.acs_open_start)) < unix_timestamp(concat('".$date."',' ',acs.acs_open_end))  AND unix_timestamp(concat('".$date."',' ',acs.acs_open_start)) < {$time}  AND unix_timestamp(concat('".$date."',' ',acs.acs_open_end)) > {$time} then 1  when unix_timestamp(concat('".$date."',' ',acs.acs_open_start)) >= unix_timestamp(concat('".$date."',' ',acs.acs_open_end))  AND ((unix_timestamp(concat('".$date."',' ',acs.acs_open_start)) <= {$time} AND {$time} <=unix_timestamp(concat('".$date."',' ','23:59'))) OR  (unix_timestamp(concat('".$date."',' ',acs.acs_open_end)) >= {$time} AND  unix_timestamp(concat('".$date."',' ','0:00')) <= {$time})) then 1  else 2 end) as openStatus ";
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join pre_enter_shop es on acs.acs_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
//        Libs_Log_Logger::outputLog($sql,'test.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 根据距离排序获取店铺信息
    public function getRowDistanceById($id,$lng,$lat){
        $where[] = array('name' => 'acs_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'acs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acs_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0); //未删除
        $sql  = ' SELECT acs.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acs_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acs_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acs_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    // 获取店铺列表及分类名
    public function getShopListWithCategory($where,$index,$count,$sort){
        $sql  = ' SELECT acs.*,acc.acc_title,acc.acc_id,es.es_id,es.es_name,es.es_hand_close ';
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on acs.acs_category_id = acc.acc_id ";
        $sql .= " left join `".DB::table($this->enter_shop)."` es on acs.acs_es_id = es.es_id ";
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

    // 获取店铺单条信息及分类名
    public function getShopRowWithCategory($where){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql  = ' SELECT acs.*,acc.acc_title,acc.acc_id,es.es_id,es.es_name,es.es_hand_close,es.es_goods_style ';
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on acs.acs_category_id = acc.acc_id ";
        $sql .= " left join `".DB::table($this->enter_shop)."` es on acs.acs_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取店铺的最大的店铺ID，及店铺总数
     */
    public function maxShopIdShopCount(){
        $sql = "SELECT MAX(`acs_id`) maxId,COUNT(*) num FROM `".DB::table($this->_table)."` WHERE `acs_s_id` = {$this->sid} AND `acs_type` = 1 AND `acs_deleted` = 0";
        $max_id = DB::fetch_first($sql);
        return $max_id;
    }

    /**
     * 获取随机获取店铺
     */
    public function getRandomShopListDistanceAsc($where,$lng,$lat){
        $sql  = ' SELECT acs.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acs_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acs_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acs_lat)/360),2)))) distance ';
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY  RAND()  LIMIT 10 ';
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addShopShowNum($acsId){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  acs_show_num = acs_show_num + 1 ';
        $sql .= '  WHERE '.$this->_pk .' = '.intval($acsId);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function addShopCommentScore($acsId,$score){
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET  acs_score = acs_score +  '.$score .' , acs_total_score = acs_total_score + 5 ';
        $sql .= '  WHERE '.$this->_pk .' = '.intval($acsId);
        Libs_Log_Logger::outputLog($sql);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addShopCollectNum($sId,$operation){
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  acs_collection_num = acs_collection_num + 1 ';
        }
        elseif($operation=='reduce'){
            $sql .= ' SET  acs_collection_num = acs_collection_num - 1 ';
        }
        $sql .= '  WHERE '.$this->_pk .' = '.$sId;
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     * 通过店铺id和用户ID获取用户入住信息
     */
    public function findShopByUser($userId) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_m_id', 'oper' => '=', 'value' => $userId);
        return $this->getRow($where);
    }

    public function findShopByUserEnterShop($userId) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_m_id', 'oper' => '=', 'value' => $userId);
        $where[]    = array('name' => 'acs_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT acs.*,es.*,acc.acc_title,acc.acc_id,esm.esm_mobile ';
        $sql .= " from `".DB::table($this->_table)."` acs ";
        $sql .= " left join `".DB::table($this->cate_table)."` acc on acs.acs_category_id = acc.acc_id ";
        $sql .= " left join `".DB::table($this->enter_shop)."` es on acs.acs_es_id = es.es_id ";
        $sql .= " left join `".DB::table($this->enter_shop_manager)."` esm on esm.esm_es_id = es.es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 通过店铺id和用户ID获取用户入住信息
     * 无论是否被删除都可获得信息
     */
    public function findShopByUserNoDelete($userId) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_m_id', 'oper' => '=', 'value' => $userId);
        $sql = $this->formatSelectOneSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 获得指定条件当天入驻数量
     */
    public function getTodayShopCount($where){
        $date = strtotime(date('Y-m-d',time()));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_create_time', 'oper' => '>', 'value' => $date);
        return $this->getCount($where);
    }

    /*
     * 获得公司列表 会员
     */
  public function fetchListMember($where,$index,$count,$sort) {
    $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);//未删除
    $sql = 'SELECT acs.*,m.m_id,m.m_nickname,m.m_show_id,es.es_id,esm.esm_id,esm.esm_mobile,esm.esm_password,espo.espo_plugin ';
    //$sql = 'SELECT acs.*,m.m_id,m.m_nickname,m.m_show_id ';
    $sql .= "FROM ".DB::table($this->_table).' acs ';
    $sql .= " LEFT JOIN ".DB::table($this->member_table)." m on acs.acs_m_id = m.m_id ";
    $sql .= " LEFT JOIN ".DB::table($this->enter_shop)." es on acs.acs_es_id = es.es_id ";
    $sql .= " LEFT JOIN ".DB::table($this->enter_shop_manager)." esm on acs.acs_es_id = esm.esm_es_id AND acs.acs_s_id = esm.esm_s_id ";
    $sql .= " LEFT JOIN ".DB::table($this->enter_shop_plugin_open)." espo on acs.acs_es_id = espo.espo_es_id ";
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

    /*
     * 门店配置
     */
    public function findUpdateByEsId($esId,$data = array()){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acs_es_id', 'oper' => '=', 'value' => $esId);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}
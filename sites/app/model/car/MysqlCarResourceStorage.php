<?php
/*
 * 二手车 车源
 */
class App_Model_Car_MysqlCarResourceStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $img_table;
    private $brand_table;
    private $type_table;
    private $member_table;
    private $entershop_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_car_resource';
        $this->_pk = 'acr_id';
        $this->_shopId = 'acr_s_id';
        $this->_df = 'acr_deleted';
        $this->sid = $sid;
        $this->img_table = DB::table('applet_car_resource_img');
        $this->brand_table = DB::table('car_brand');
        $this->type_table = DB::table('car_type');
        $this->member_table = DB::table('member');
        $this->entershop_table = DB::table('enter_shop');
    }

    /**
     * 增加或减少阅读数、评论数、点赞数 $operation=add添加 $operation=reduce减少
     */
    public function addReduceNum($id,$type,$operation='add',$num=1){
        if($type=='collect') {
            $field = 'acr_collect_num';
        }elseif($type == 'show'){
            $field = 'acr_show_num';
        }
        $sql  = 'UPDATE '.DB::table($this->_table);
        if($operation=='add'){
            $sql .= ' SET  '.$field.' = '.$field.' + '.$num;
        }else{
            $sql .= ' SET  '.$field.' = '.$field.' - '.$num;
        }
        $sql .= '  WHERE '.$this->_pk .' = '.intval($id);
        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获得会员当天发布数量 包括已删除
     */
    public function getResourceMemberToday($mid){

        $start = strtotime(date('Y-m-d',time()));
        $end = $start+86400;
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acr_create_time', 'oper' => '>=', 'value' => $start);
        $where[] = array('name' => 'acr_create_time', 'oper' => '<=', 'value' => $end);
        $where[] = array('name' => 'acr_m_id', 'oper' => '=', 'value' => $mid);

        $sql = "select count(*) ";
        $sql .= ' from `'.DB::table($this->_table).'` acr ';
        $sql .= $this->formatWhereSql($where);
        $row = DB::result_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 获得车源列表
     * 关联车源图片表以获得封面
     */

    /*
     * 获得车源列表
     * 关联车源图片表以获得封面
     */
    public function getResourceList($where,$index,$count,$sort){
        $sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,m.m_nickname,m.m_avatar,es.es_name ';
        //$sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,acri.acri_path ';
        $sql .= ' from `'.DB::table($this->_table).'` acr ';
        $sql .= " LEFT JOIN `".$this->brand_table."` cb on acr.acr_car_brand = cb.cb_id ";
        $sql .= " LEFT JOIN `".$this->type_table."` ct on acr.acr_car_type = ct.ct_id ";
        $sql .= " LEFT JOIN `".$this->member_table."` m on acr.acr_m_id = m.m_id ";
        $sql .= " LEFT JOIN `".$this->entershop_table."` es on m.m_id = es.es_m_id AND es.es_expire_time > unix_timestamp() AND es.es_deleted = 0 ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function getResourceListNew($where,$index,$count,$sort){
        $sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name ';
        //$sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,acri.acri_path ';
        $sql .= ' from `'.DB::table($this->_table).'` acr ';
        $sql .= " LEFT JOIN `".$this->img_table."` acri on acri.acri_car_id = acr.acr_id ";
        $sql .= " LEFT JOIN `".$this->brand_table."` cb on acr.acr_car_brand = cb.cb_id ";
        $sql .= " LEFT JOIN `".$this->type_table."` ct on acr.acr_car_type = ct.ct_id ";
        //$sql .= " LEFT JOIN `".$this->member_table."` m on acr.acr_m_id = m.m_id ";
        //$sql .= " LEFT JOIN `".$this->entershop_table."` es on m.m_id = es.es_m_id AND es.es_expire_time > unix_timestamp() AND es.es_deleted = 0 ";
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY acr.acr_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 获得车源列表
     * 关联车源图片表以获得封面
     */
    public function getResourceCount($where){
        $sql  = ' SELECT count(*) as total ';
        $sql .= ' from `'.DB::table($this->_table).'` acr ';
//        $sql .= " LEFT JOIN `".$this->img_table."` acri on acri.acri_car_id = acr.acr_id ";
        $sql .= " LEFT JOIN `".$this->brand_table."` cb on acr.acr_car_brand = cb.cb_id ";
        $sql .= " LEFT JOIN `".$this->type_table."` ct on acr.acr_car_type = ct.ct_id ";
        $sql .= " LEFT JOIN `".$this->member_table."` m on acr.acr_m_id = m.m_id ";
        $sql .= " LEFT JOIN `".$this->entershop_table."` es on m.m_id = es.es_m_id AND es.es_expire_time > unix_timestamp() AND es.es_deleted = 0 ";
        $sql .= $this->formatWhereSql($where);
//        $sql .= ' from ( ';
//        $sql  .= ' SELECT acr.acr_id  ';
//        //$sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,acri.acri_path ';
//
//        $sql .= ' ) as total_table ';
        $row = DB::result_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    public function getResourceListDistance($lng,$lat,$where,$index,$count,$sort){
        $sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acr_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acr_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acr_lat)/360),2)))) as distance ';
        //$sql  = ' SELECT acr.*,ct.ct_name,cb.cb_name,acri.acri_path ';
        $sql .= ' from `'.DB::table($this->_table).'` acr ';
//        $sql .= " LEFT JOIN `".$this->img_table."` acri on acri.acri_car_id = acr.acr_id ";
        $sql .= " LEFT JOIN `".$this->brand_table."` cb on acr.acr_car_brand = cb.cb_id ";
        $sql .= " LEFT JOIN `".$this->type_table."` ct on acr.acr_car_type = ct.ct_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $row = DB::fetch_all($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 获得车源列表
     * 关联车源图片表以获得封面
     */
    public function getResourceRow($id){
        $where = [];
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);

        //$sql  = ' SELECT acr.*,cb.*,ct.*,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acr_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acr_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acr_lat)/360),2)))) as distance ';
        $sql = 'SELECT acr.*,cb.*,ct.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` acr ';
        $sql .= " LEFT JOIN `".$this->brand_table."` cb on acr.acr_car_brand = cb.cb_id ";
        $sql .= " LEFT JOIN `".$this->type_table."` ct on acr.acr_car_type = ct.ct_id ";
        $sql .= $this->formatWhereSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /*
     * 获得车源列表
     * 关联车源图片表以获得封面
     */
    public function getResourceRowDistance($id,$lng,$lat){
        $where = [];
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT acr.*,cb.*,ct.*,acri.acri_path,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acr_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acr_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acr_lat)/360),2)))) as distance ';
        //$sql = 'SELECT acr.*,cb.*,ct.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` acr ';
        $sql .= " LEFT JOIN `".$this->img_table."` acri on acri.acri_car_id = acr.acr_id ";
        $sql .= " LEFT JOIN `".$this->brand_table."` cb on acr.acr_car_brand = cb.cb_id ";
        $sql .= " LEFT JOIN `".$this->type_table."` ct on acr.acr_car_type = ct.ct_id ";
        $sql .= $this->formatWhereSql($where);
        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }


}
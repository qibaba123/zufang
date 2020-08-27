<?php
/*
 * 二手车 砍价记录
 */
class App_Model_Car_MysqlCarBargainStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $resource_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_car_bargain';
        $this->_pk = 'acb_id';
        $this->_shopId = 'acb_s_id';
        $this->_df = 'acb_deleted';
        $this->sid = $sid;
        $this->resource_table = DB::table('applet_car_resource');

    }

    /*
     * 获得砍价记录 关联车源表
     */
    public function getBargainListAction($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df,'oper'=> '=', 'value' => 0);
        $sql  = 'SELECT acb.*,acr.*,cb.cb_name,ct.ct_name,acri.acri_path,m.m_mobile ';
        $sql .= ' FROM '.DB::table($this->_table).' acb ';
        $sql .= ' LEFT JOIN '.$this->resource_table.' acr on acb.acb_car_id = acr.acr_id ';
        $sql .= ' LEFT JOIN  pre_car_brand cb on acr.acr_car_brand = cb.cb_id ';
        $sql .= ' LEFT JOIN  pre_car_type ct on acr.acr_car_type = ct.ct_id ';
        $sql .= ' LEFT JOIN  pre_applet_car_resource_img acri on acb.acb_car_id = acri.acri_car_id ';
        $sql .= ' LEFT JOIN  pre_member m on acb.acb_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY acb.acb_id ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getBargainListDistanceAction($lng,$lat,$where,$index,$count,$sort){
        $where[] = array('name' => $this->_df,'oper'=> '=', 'value' => 0);
        $sql  = 'SELECT acb.*,acr.*,cb.cb_name,ct.ct_name,acri.acri_path,m.m_mobile,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*("'.$lng.'"-acr_lng)/360),2)+COS(PI()*"'.$lat.'"/180)* COS(acr_lat * PI()/180)*POW(SIN(PI()*("'.$lat.'"-acr_lat)/360),2)))) as distance ';
        $sql .= ' FROM '.DB::table($this->_table).' acb ';
        $sql .= ' LEFT JOIN '.$this->resource_table.' acr on acb.acb_car_id = acr.acr_id ';
        $sql .= ' LEFT JOIN  pre_car_brand cb on acr.acr_car_brand = cb.cb_id ';
        $sql .= ' LEFT JOIN  pre_car_type ct on acr.acr_car_type = ct.ct_id ';
        $sql .= ' LEFT JOIN  pre_applet_car_resource_img acri on acb.acb_car_id = acri.acri_car_id ';
        $sql .= ' LEFT JOIN  pre_member m on acb.acb_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= " GROUP BY acb.acb_id ";
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
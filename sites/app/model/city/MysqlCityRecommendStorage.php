<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityRecommendStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_recommend';
        $this->_pk = 'acr_id';
        $this->_shopId = 'acr_s_id';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }
    /*
    * 获取店铺推荐商家
    */
    public function fetchRecommendShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acr_deleted', 'oper' => '=', 'value' => 0);//未删除
        return $this->getList($where, 0, 60, array('acr_sort' => 'ASC'));
    }

    /*
       * 获取店铺推荐商家 关联商家表
       */
    public function fetchRecommendShowListShop($where,$index,$count,$sort) {
        $where[]    = array('name' => 'acr_deleted', 'oper' => '=', 'value' => 0);//未删除

        $sql  = ' SELECT acr.*,acs.acs_name,acs.acs_cover,acs.acs_img,acs.acs_brief,acs.acs_id ';
        $sql .= " from `".DB::table($this->_table)."` acr ";
        $sql .= " left join `pre_applet_city_shop` acs on acs.acs_id = acr.acr_link ";
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
   * 批量插入推荐商家
   */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acr_id`, `acr_s_id`,`acr_name`,`acr_cover`,`acr_link`,`acr_type`,`acr_sort`, `acr_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }
}
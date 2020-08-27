<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/20
 * Time: 下午2:39
 */
    class App_Model_City_MysqlCityMallRecommendStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_mall_recommend';
        $this->_pk = 'acmr_id';
        $this->_shopId = 'acmr_s_id';

        $this->sid = $sid;
    }

    /*
       * 获取店铺可展示的快捷菜单列表
       */
    public function fetchRecommendShowList() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getList($where, 0, 50, array('acmr_weight' => 'ASC'));
    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入首页分类
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`acmr_id`, `acmr_s_id`,`acmr_title`,`acmr_img`,`acmr_link`,`acmr_weight`,`acmr_link_type`,`acmr_es_id`,`acmr_create_time`) ';
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
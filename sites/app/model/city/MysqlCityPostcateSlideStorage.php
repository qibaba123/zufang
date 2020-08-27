<?php
/*
 * 同城分类幻灯图
 */
class App_Model_City_MysqlCityPostcateSlideStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_city_postcate_slide';
        $this->_pk 		= 'acps_id';
        $this->_shopId 	= 'acps_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 前端获取店铺可展示的幻灯列表
     */
    public function fetchSlideShowList($cateId) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acps_cate_id', 'oper' => '=', 'value' => $cateId);
        $where[]    = array('name' => 'acps_deleted', 'oper' => '=', 'value' => 0);//未删除

        return $this->getList($where, 0, 5, array('acps_weight' => 'ASC'));
    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`acps_id`, `acps_s_id`,`acps_cate_id`,  `acps_path`, `acps_weight`,  `acps_deleted`, `acps_create_time`) ';
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

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertNewBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`acps_id`, `acps_s_id`,`acps_cate_id`,  `acps_path`, `acps_weight`, `acps_type`, `acps_link`,  `acps_deleted`, `acps_create_time`) ';
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
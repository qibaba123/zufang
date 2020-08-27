<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meal_MysqlMealEnvironmentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meal_environment';
        $this->_pk = 'ame_id';
        $this->_shopId = 'ame_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
    * 获取店铺可展示的快捷菜单列表
    */
    public function fetchEnvironmentShowList($index = 0, $page = 50, $esId = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ame_es_id', 'oper' => '=', 'value' => $esId);

        return $this->getList($where, $index, $page, array('ame_weight' => 'ASC'));
    }

    //批量插入微培训首页学员风采信息
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`ame_id`, `ame_s_id`,`ame_es_id`,`ame_img`,`ame_weight`,`ame_create_time`) ';
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
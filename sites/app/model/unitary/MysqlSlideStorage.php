<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Unitary_MysqlSlideStorage extends Libs_Mvc_Model_BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'unitary_slide';
        $this->_pk = 'us_id';
        $this->_df = 'us_deleted';
        $this->_shopId = 'us_s_id';
    }

    /*
     * 获取店铺的幻灯列表
     */
    public function findListBySid($sid) {
        $where[]    = array('name' => 'us_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'us_deleted', 'oper' => '=', 'value' => 0);//未删除数据

        return $this->getList($where, 0, 0, array('us_create_time' => 'DESC'));
    }
}
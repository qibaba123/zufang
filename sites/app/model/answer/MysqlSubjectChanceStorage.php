<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Answer_MysqlSubjectChanceStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_subject_chance_list';
        $this->_pk = 'ascl_id';
        $this->_shopId = 'ascl_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    /**
     * 获取会员未使用机会数
     */
    public function fetchChanceNum($mid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ascl_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ascl_status', 'oper' => '=', 'value' => 0);
        return $this->getCount($where);
    }

    /*
     * 将一条未使用机会改为已使用
     */
    public function changeStatus($mid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ascl_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ascl_status', 'oper' => '=', 'value' => 0);
        $row = $this->getRow($where);
        return $this->updateById(array('ascl_status' => 1),$row['ascl_id']);
    }


}
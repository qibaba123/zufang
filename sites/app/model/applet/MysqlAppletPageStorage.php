<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletPageStorage extends Libs_Mvc_Model_BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_pages';
        $this->_pk = 'ap_id';
    }

    /**
     * 根据类型获取导航
     */
    public function fetchAction($type,$appletType='ap_wxapp_user'){
        $where    =  array();
        $where[]  =  array('name'=>"ap_type",'oper'=>'=','value'=>$type);
        if($appletType && isset($appletType)){
            $where[]  =  array('name'=>$appletType,'oper'=>'=','value'=>1);
        }
        $sort     =  array('ap_sort'=>'ASC','ap_add_time'=>'DESC');
        return $this->getList($where,0,0,$sort);
    }
    /*
     * 获取页面默认导航
     */
    public function fetchDefaultAction($type,$appletType='ap_wxapp_user') {
        $where[]    = array('name' => 'ap_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'ap_default', 'oper' => '=', 'value' => 1);
        if($appletType && isset($appletType)){
            $where[]  =  array('name'=>$appletType,'oper'=>'=','value'=>1);
        }
        $sort       = array('ap_sort' => 'ASC');

        return $this->getList($where, 0, 0, $sort);
    }
}
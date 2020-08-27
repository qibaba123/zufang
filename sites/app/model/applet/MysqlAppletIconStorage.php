<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletIconStorage extends Libs_Mvc_Model_BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_icon';
        $this->_pk = 'ai_id';
    }
    /**
     * 根据类型获取数据
     */
    public function getIconList($type){
        $where    =  array();
        $where[]  =  array('name'=>"ai_type",'oper'=>'=','value'=>$type);
        $sort     =  array('ai_add_time'=>'DESC');
        return $this->getList($where,0,0,$sort);
    }

    /**
     * 根据类型获取数据
     */
    public function getIconListForSelect($type){
        $where    =  array();
        $where[]  =  array('name'=>"ai_type",'oper'=>'=','value'=>$type);
        $sort     =  array('ai_add_time'=>'DESC');
        $list =  $this->getList($where,0,0,$sort);
        $data = array();
        if($list){
            foreach ($list as $value){
                $data[$value['ai_path']] = $value['ai_desc'];
            }
        }
        return $data;
    }



}
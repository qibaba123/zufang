<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Train_MysqlTrainCourseTypeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_train_type';
        $this->_pk 		= 'att_id';
        $this->_shopId 	= 'att_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /**
     * @return array|bool
     * 获取课程列表
     */
    public function findListBySid() {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'att_deleted','oper'=>'=','value'=>0);
        return $this->getList($where,0,0,array('att_weight'=>'DESC','att_create_time'=>'DESC'));
    }

    /**
     * 获取课程列表选择用
     */
    public function findListForSelect(){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'att_deleted','oper'=>'=','value'=>0);
        $list = $this->getList($where,0,0,array('att_weight'=>'DESC','att_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['att_id']] = $val['att_name'];
            }
        }
        return $data;
    }
}
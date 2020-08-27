<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Community_MysqlPointsKindStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_point_kind';
        $this->_pk      = 'apk_id';
        $this->_shopId  = 'apk_s_id';
        $this->_df      = 'apk_deleted';
        $this->sid      = $sid;
    }

    /**
     * 获取一个店铺的所有分类
     */
    public function getAllCategorySelect($index=0,$count=200){
        $where      = array();
        $where[]    = array('name' => $this->_shopId,'oper' => '=','value' =>$this->sid);
        $sort       = array('apk_weight' => 'DESC');
        $field      = array('apk_id','apk_name','apk_weight');
        $list = $this->getList($where,$index,$count,$sort,$field,true);
        $data = array();
        foreach($list as $val){
            $data[$val['apk_id']] = $val['apk_name'];
        }
        return $data;
    }
}
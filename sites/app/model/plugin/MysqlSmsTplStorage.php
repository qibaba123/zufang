<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlSmsTplStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'sms_tpl';
        $this->_pk      = 'st_id';
        $this->_shopId  = 'st_s_id';

        $this->sid      = $sid;
    }
    /*
     * 获取或修改店铺短信配置
     * $status表示状态，减去1表示状态，0表示全部
     */
    public function getListBySid($status=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($status){
            $where[]    = array('name' => 'st_status', 'oper' => '=', 'value' =>$status-1);
        }
        $sort = array('st_update_time' => 'DESC');
        return $this->getList($where,0,0,$sort);
    }

    public function updateByTplId($set,$tplId){
        $where   = array();
        $where[] = array('name' => 'st_tpl_id', 'oper' => '=', 'value' => $tplId);
        return $this->updateValue($set,$where);
    }

    public function getListForSelect(){
        $list = $this->getListBySid(2);
        $data = array();
        foreach($list as $val){
            $data[$val['st_id']] = $val['st_tpl_sign'];
        }
        return $data;
    }

}
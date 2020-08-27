<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlWeixinTplMsgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'weixin_tplmsg';
        $this->_pk      = 'wt_id';
        $this->_shopId  = 'wt_s_id';
        $this->_df      = 'wt_deleted';

        $this->sid      = $sid;
    }


    public function getListByTplid($tpl,$index,$count){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'wt_tplid', 'oper' => '=', 'value' => $tpl);
        $sort    = array('wt_create_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort);
    }

    public function getCountByTplid($tpl){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'wt_tplid', 'oper' => '=', 'value' => $tpl);
        return $this->getCount($where);
    }

    public function getListBySid($index,$count,$field=array()){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort    = array('wt_create_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort,$field);
    }

    public function getCountBySid(){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getCount($where);
    }

    public function getListByIds(array $ids,$field=array('wt_title','wt_id')){
        $where = array();
        if(!empty($ids) && is_array($ids)){
            $where[] = array('name' => $this->_pk, 'oper' => 'in', 'value' => $ids);
        }
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort    = array('wt_create_time' => 'DESC');
        return $this->getList($where,0,0,$sort,$field,true);

    }
    /*
     * 获取模板消息
     */
    public function findOneById($id) {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);

        return $this->getRow($where);
    }



}
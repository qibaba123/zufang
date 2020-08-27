<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlWeixinNewsStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'weixin_news';
        $this->_pk      = 'wn_id';
        $this->_shopId  = 'wn_s_id';
        $this->_df      = 'wn_deleted';

        $this->sid      = $sid;
    }

    public function getListBySid($sid,$index=0,$count=0,$field=array('wn_id','wn_title')){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $sort       = array('wn_create_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort,$field);
    }

    public function findNewsById($id) {
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if ($this->sid) {
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }

        return $this->getRow($where);
    }

}
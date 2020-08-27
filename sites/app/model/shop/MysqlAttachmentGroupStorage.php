<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/7/29
 * Time: 下午2:59
 */
class App_Model_Shop_MysqlAttachmentGroupStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'shop_attachment_group';
        $this->_pk 		= 'sag_id';
        $this->sid      = $sid;
        $this->_shopId 	= 'sag_s_id';
        parent::__construct();
    }

    function getGroupListAction(){
        $where = array();
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'sag_deleted','oper'=>'=','value'=>0);
        $sort = array('sag_sort' => 'asc');

        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
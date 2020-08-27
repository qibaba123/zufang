<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Applet_MysqlWeixinTplMsgSendStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_weixin_tplsend';
        $this->_pk      = 'awt_id';
        $this->_shopId  = 'awt_s_id';

        $this->sid      = $sid;
    }


    public function getListByMsgid($msgId,$index,$count){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'awt_tpl_msgid', 'oper' => '=', 'value' => $msgId);
        $sort    = array('awt_send_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort);
    }

    public function getCountByMsgid($msgId){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'awt_tpl_msgid', 'oper' => '=', 'value' => $msgId);
        return $this->getCount($where);
    }

    public function insertBatch($val){
        $sql  = 'INSERT INTO '.DB::table($this->_table);
        $sql .= ' (`awt_id`, `awt_s_id`,`awt_tpl_msgid`, `awt_openid`, `awt_title`, `awt_mid`, `awt_m_nickname`, `awt_status`, `awt_send_time`) ';
        $sql .= ' VALUES ';
        $sql .= implode(',',$val);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function insertNewBatch($val){
        if($val){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`awt_id`, `awt_s_id`, `awt_history_id`,`awt_tpl_msgid`, `awt_openid`, `awt_title`, `awt_mid`, `awt_m_avatar`,`awt_m_nickname`, `awt_status`, `awt_send_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val);

            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
    }

}
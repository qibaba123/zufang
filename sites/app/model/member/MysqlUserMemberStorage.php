<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/4
 * Time: 下午4:47
 */

class App_Model_Member_MysqlUserMemberStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'user_member';
        $this->_pk      = 'um_id';
    }

    public function findMemberByUidSid($uid, $sid) {
        $where[]    = array('name' => 'um_uid', 'oper' => '=', 'value' => $uid);
        $where[]    = array('name' => 'um_sid', 'oper' => '=', 'value' => $sid);

        return $this->getRow($where);
    }
}
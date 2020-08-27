<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/4
 * Time: 下午4:47
 */
class App_Model_Member_MysqlUserStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'user';
        $this->_pk      = 'u_id';
    }

    /*
     * 通过openID查找用户
     */
    public function findUpdateByOpenid($openid, $data = null) {
        $where[]    = array('name' => 'u_open_id', 'oper' => '=', 'value' => $openid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 通过手机号查找用户
     */
    public function findUpdateByPhone($phone, $data = null) {
        $where[]    = array('name' => 'u_phone', 'oper' => '=', 'value' => $phone);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}
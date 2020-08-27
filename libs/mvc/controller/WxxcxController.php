<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/28
 * Time: 下午12:25
 */
class Libs_Mvc_Controller_WxxcxController {
    /*
     * 微信消息体,json反序列化后的关联数组形式
     */
    public $weixinMsg;
    /*
     * 是否使用加密形式
     */
    protected $is_encrypt = false;

    public function __construct($weixin_msg) {
        $this->setWeixinMsg($weixin_msg);
    }

    /**
     * 设置微信消息体
     * @param $weixin_msg
     */
    public function setWeixinMsg($weixin_msg) {
        $weixin_msg         = is_object($weixin_msg) ? $this->_object_to_array($weixin_msg) : $weixin_msg;
        $this->weixinMsg    = $weixin_msg;
        $this->is_encrypt   = isset($weixin_msg['is_encrypt']) &&  $weixin_msg['is_encrypt'] ? true : false;
    }

    /**
     * 获取设置的微信消息体
     * @return array
     */
    public function getWeixinMsg() {
        return $this->weixinMsg;
    }
    /*
     * 对象转换为关联数组
     */
    private function _object_to_array($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(array($this, __METHOD__), $d);
        } else {
            // Return array
            return $d;
        }
    }
}
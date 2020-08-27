<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/1
 * Time: 下午6:10
 */

class App_Model_Auth_RedisWeixinPlatformStorage extends Libs_Redis_RedisClient {

    private $comp_access_token_key;

    /**
     * App_Model_Auth_RedisWeixinPlatformStorage constructor.
     * @param string $type 类型,接受weixin公众号类型,wxxcx小程序类型
     */
    public function __construct($type = 'weixin') {
        switch ($type) {
            case 'weixin' :
                $this->comp_access_token_key    = "compoment_access_token";
                break;
            case 'wxxcx'  :
                $this->comp_access_token_key    = "wxxcxcomp_access_token";
                break;
            case 'wxtdt'  :
                $this->comp_access_token_key    = "wxtdtcomp_access_token";
                break;
            case 'baidu'  :
                $this->comp_access_token_key    = "baiducomp_access_token";
                break;
        }
        return parent::__construct();
    }

    /**
     * 设置第三方平台接口调用凭据
     * @param string $token
     * @param int $ttl
     * @return bool
     */
    public function setCompAccessToken($token, $ttl) {
        return $this->redis->setex($this->comp_access_token_key, $ttl, $token);
    }

    /**
     * 获取第三方平台接口调用凭据
     * @return bool|string
     */
    public function getCompAccessToken() {
        return $this->redis->get($this->comp_access_token_key);
    }

    /**
     * 获取第三方平台接口调用凭据剩余生存时间
     * @return int
     */
    public function ttlCompAccessToken() {
        return $this->redis->ttl($this->comp_access_token_key);
    }
    /******************************************************************************************************************/
    public function saveTmpQueryAuthCode($code, $ttl) {
        return $this->redis->setex('tmp_query_auth_code', $ttl, $code);
    }

    public function fetchTmpQueryAuthCode() {
        return $this->redis->get('tmp_query_auth_code');
    }
    /********************************************饿了么蜂鸟配送***************************************************************************/
    public function setAnubisEleAccessToken($token, $ttl) {
        return $this->redis->setex("anubis_ele_access_token", $ttl, $token);
    }

    public function getAnubisEleAccessToken() {
        return $this->redis->get("anubis_ele_access_token");
    }
}
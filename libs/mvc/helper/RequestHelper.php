<?php
/**
 * HTTP请求助手类
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-28
 */
class Libs_Mvc_Helper_RequestHelper {
   
    private static $_instance;

    private $_isMobile = null;
    private $_isWeixin = null;
    private $_isAlipay = null;
    private $_isMobileQQ = null;
    private $_isMobileWeibo = null;
    private $_isMobileQzone = null;

    private function __construct() {
    
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        trigger_error("single instance RequestHelper can not be cloned.", E_USER_ERROR);
    }

    public function getParam($name, $default = '') {
        return isset($_REQUEST[$name]) ? trim($_REQUEST[$name]) : $default;
    }

    public function getStrParam($name, $default = '') {
        return isset($_REQUEST[$name]) ? rawurldecode(trim($_REQUEST[$name])) : $default;
    }

    public function getIntParam($name, $default = 0) {
        return isset($_REQUEST[$name]) ? intval($_REQUEST[$name]) : $default;
    }

    public function getFloatParam($name, $default = 0) {
        return isset($_REQUEST[$name]) ? floatval($_REQUEST[$name]) : $default;
    }

    public function getArrParam($name, $default = array()) {
        return isset($_REQUEST[$name]) && is_array($_REQUEST[$name])? $_REQUEST[$name] : $default;
    }
    /********************获取传递的cookie信息****************************/
    public function getCookie($name, $default = '') {
        return isset($_COOKIE[$name]) ? trim($_COOKIE[$name]) : $default;
    }

    public function getStrCookie($name, $default = '') {
        return isset($_COOKIE[$name]) ? rawurldecode(trim($_COOKIE[$name])) : $default;
    }

    public function getIntCookie($name, $default = 0) {
        return isset($_COOKIE[$name]) ? intval($_COOKIE[$name]) : $default;
    }

    public function getFloatCookie($name, $default = 0) {
        return isset($_COOKIE[$name]) ? floatval($_COOKIE[$name]) : $default;
    }

    public function getArrCookie($name, $default = array()) {
        return isset($_COOKIE[$name]) && is_array($_COOKIE[$name])? $_COOKIE[$name] : $default;
    }
    /**
     * 获取请求的user agent
     */
    public function getUserAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'PHP ' . PHP_VERSION;
    }
    /**
     * 判断是否为手机
     */
    public function isMobile() {
        if (NULL === $this->_isMobile) {
            $user_agent = $this->getUserAgent();
            $this->_isMobile = preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$user_agent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($user_agent,0,4));
        }
        return $this->_isMobile;
    }

    /**
     * 判断是否为微信手机客户端
     */
    public function isWeixin() {
        if (NULL == $this->_isWeixin) {
            $user_agent = $this->getUserAgent();
            $this->_isWeixin = preg_match('/micromessenger/i', $user_agent);
        }
        return $this->_isWeixin;
    }
    /*
     * 判断是否为支付宝手机客户端
     */
    public function isAlipay() {
        if (NULL == $this->_isAlipay) {
            $user_agent = $this->getUserAgent();
            $this->_isAlipay    = preg_match('/Alipay/i', $user_agent);
        }
        return $this->_isAlipay;
    }
    /**
     * 判断是否为手机QQ客户端
     */
    public function isMobileQq() {
        if (NULL == $this->_isMobileQQ) {
            $user_agent = $this->getUserAgent();
            $this->_isMobileQQ = preg_match('/QQ/', $user_agent) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? preg_match('/tencent/i', $_SERVER['HTTP_X_REQUESTED_WITH']) : false);
        }
        return $this->_isMobileQQ;
    }

    /**
     * 判断是否为手机QQ空间客户端
     */
    public function isMobileQzone() {
        if (NULL == $this->_isMobileQzone) {
            if (isset($_SERVER['HTTP_Q_UA']) && preg_match('/qz/i', $_SERVER['HTTP_Q_UA'])) {//ios
                $this->_isMobileQzone = true;
            } else if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && preg_match('/qzone/i', $_SERVER['HTTP_X_REQUESTED_WITH'])) {//android
                $this->_isMobileQzone = true;
            }
        }
        return $this->_isMobileQzone;
    }

    /**
     * 判断是否为手机微博客户端
     */
    public function isMobileWeibo() {
        if (NULL == $this->_isMobileWeibo) {
            $user_agent = $this->getUserAgent();
            $this->_isMobileWeibo = preg_match('/weibo/i', $user_agent);
        }
        return $this->_isMobileWeibo;
    }

    /*
     * 获取真实请求IP
     */
    public function getRealIp(){
        $ip = false;
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = false;
            }
            for ($i = 0; $i < count($ips); $i++){
                if (!eregi ("^(10|172.16|192.168).", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    /*
     * 获取请求IP
     */
    public function getRemoteIp() {
        return $_SERVER['REMOTE_ADDR'];
    }

    /*
     * 获取当前请求链接的完整URL
     */
    public function getRequestUrl() {
        $request_uri    = plum_get_server('REQUEST_URI');

        return plum_get_base_host().$request_uri;
    }
}

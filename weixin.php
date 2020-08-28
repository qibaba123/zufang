<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-04-30
 * @modify 2019-06-18 
 */
require_once "inc.php";
define('PLUM_ENV',          PLUM_DEVELOPMENT_ENV);          //设置当前为开发环境，自动识别测试环境
define('DRUPAL_ROOT',       dirname(__FILE__));
define('WEBAPP_MODULE',     'weixin');
require_once PLUM_DIR_BOOTSTRAP . '/bootload.inc';//初始化libs

//校验请求是否来自微信
if (_check_weixin_signature()) {
    $echostr = plum_get_param('echostr');
    if ($echostr) {//首次认证
        echo $echostr;
    } else {
        weixin_map_invoke();
    }
} else {
    echo 'false';
}

function _check_weixin_signature() {
    $signature  = plum_get_param('signature');
    $timestamp  = plum_get_param('timestamp');
    $nonce      = plum_get_param('nonce');

    $sid        = plum_get_param('sid');//获取店铺id

    if (!$sid) {
        return false;
    }
    //获取token
    $token  = plum_md5_with_salt($sid, $sid);

    $tmpArr = array($token, $timestamp, $nonce);
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode('', $tmpArr);
    $tmpStr = sha1($tmpStr);

    if( $tmpStr == $signature ){
        return true;
    }else{
        return false;
    }
}

/**
 *映射API调用
 */
function weixin_map_invoke() {
    $post_str = $GLOBALS["HTTP_RAW_POST_DATA"];
    $flag = true;
    if (!empty($post_str)){
        $weixin_msg         = simplexml_load_string($post_str, 'SimpleXMLElement', LIBXML_NOCDATA);
        $weixin_msg->suid   = plum_get_param('sid');//设置店铺id
        //获取消息类型
        $msg_type   = strval($weixin_msg->MsgType);
        //获取微信映射
        $table      = plum_parse_config('rewrite','weixin');
        if (isset($table[$msg_type])) {
            try {
                $class = new $table[$msg_type]['controller']($weixin_msg);//传值
                if ($msg_type == 'event') {
                    $method = strtolower((string)$weixin_msg->Event).'Action';
                } else {
                    $method = 'indexAction';
                }
                $class->$method();
            } catch (Exception $e) {
                $flag = false;
                trigger_error("weixin rewrite mapping undifined controller: {$table['$msg_type']['controller']}, action: {$method}", E_USER_ERROR);
            }
        } else {
            $flag = false;
            trigger_error("call undifined weixin rewrite mapping: {$msg_type}", E_USER_WARNING);
        }
    }else{
        $flag = false;
    }
    //分发失败时，返回空串
    if (!$flag) {
        echo '';
        exit;
    }
}

<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-04-30
 * @modify 2019-06-18
 */
require_once "inc.php";
define('PLUM_ENV',          PLUM_DEVELOPMENT_ENV);          //设置当前为开发环境，自动识别测试环境
define('DRUPAL_ROOT',       dirname(__FILE__));
define('WEBAPP_MODULE',     'wxxcx');
require_once PLUM_DIR_BOOTSTRAP . '/bootload.inc';//初始化libs

//校验请求是否来自微信
if (_check_weixin_signature()) {
    $echostr = plum_get_param('echostr');
    if ($echostr) {//首次认证
        echo $echostr;
    } else {
        wxxcx_map_invoke();
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
function wxxcx_map_invoke() {
    $data = $GLOBALS["HTTP_RAW_POST_DATA"];
    $flag = true;
    if (!empty($data)){
        //仅支持json格式的数据
        $content        = json_decode($data, true);
        $content['suid']    = plum_get_param('sid');
        $content['openid']  = plum_get_param('openid');

        //获取消息类型
        $msg_type   = $content['MsgType'];
        //获取微信映射
        $table      = plum_parse_config('rewrite','wxxcx');
        if (isset($table[$msg_type])) {
            try {
                $class = new $table[$msg_type]['controller']($content);//传值
                if ($msg_type == 'event') {
                    $method = strtolower($content['Event']).'Action';
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

<?php
/**
 * 引导加载
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-24
 */

require_once "functions.inc";
require_once "autoload.inc";

/*
 *映射API调用
 */
function plum_api_invoke($type = 'api') {
    $redis_client = new Libs_Redis_RedisClient();
    $redis = $redis_client->getRedis();
    $redis->select(12);
    if($redis->ttl('source_code_auth') == -2){
	//	die();
	}
    $map    = isset($_REQUEST['map']) ? trim($_REQUEST['map']) : '';
    $table  = plum_parse_config($type, 'rewrite');
    $flag   = true;
    if (isset($table[$map])) {
        try {
            $class = new $table[$map]['controller'];
            $method = $table[$map]['action'];
            $class->$method();
            Libs_Log_Logger::outputLog($table[$map]['controller'].$method, 'abc.log');
        } catch (Exception $e) {
            $flag = false;
            trigger_error("api rewrite mapping undifined controller: {$table['$map']['controller']}, action: {$method}", E_USER_ERROR);
        }
    } else {
        $flag = false;
        trigger_error("call undifined api rewrite mapping: {$map}", E_USER_WARNING);
    }
    if (!$flag) {
        $json = array(
            'ec' => 500,
            'em' => 'api rewrite error',
        );
        echo json_encode($json);
    }
}

/*
 * 开启自定义session
 */
/*function plum_api_session_init($type = 'api') {
    $session_config = plum_parse_config($type, 'session');
    $cookie_name = $session_config ? $session_config['cookie_name'] : 'plum_session_' . $type;

    $session_id = plum_get_param($cookie_name);
    if ($session_id) {
        session_id($session_id);
    }
    $sessionHandler = new Libs_Session_SessionHandler();
    $sessionHandler->run();
}*/

function plum_api_session_init($type = PLUM_WEBAPP_MODULE) {
    //获取session配置
    $session_config     = plum_parse_config($type, 'session');
    $cookie_name = $session_config ? $session_config['cookie_name'] : 'plum_session_' . $type;

    ini_set('session.name', $cookie_name);
    ini_set("session.save_handler", "redis");

    $session_id = plum_get_param($cookie_name);
    if ($session_id) {
        session_id($session_id);
    }

    $session_handler = new Libs_Session_SessionHandler();
    $session_handler->run();

    plum_app_user_init();
}

/**
 * 加解密形式开启session
 * @param string $type 配置名
 */
function plum_auth_session($type = 'auth') {
    $session_config = plum_parse_config($type, 'session');
    global $APP_USER;
    $APP_USER   = 0;
    $session    = plum_get_param($session_config['cookie_name']);
    $session    = rawurldecode(urlencode($session));//先转码后解码
    if ($session) {
        //获取到session，开始解密
        $code   = unserialize(plum_authcode($session, 'DECODE', $session_config['auth_token']));

        if (is_array($code) && isset($code[$session_config['uid_key']])) {
            $uid    = intval($code[$session_config['uid_key']]);
            if ($uid) {
                $APP_USER = $uid;
            }
        }
    }
}
//API调用，开启session，保存类型为文件
function plum_open_session($type = PLUM_WEBAPP_MODULE) {
    //获取session配置
    $session_config     = plum_parse_config($type, 'session');
    $is_set_config      = $session_config ? true : false;
    $session_config     = $is_set_config ? $session_config : plum_parse_config(PLUM_WEBAPP_MODULE, 'session');

    $save_path          = PLUM_DIR_SESSION . '/' . $type;
    if (!file_exists($save_path)) {
        $save_path = mkdir($save_path) ? $save_path : $session_config['save_path'];
    }
    $cookie_name = $is_set_config ? $session_config['cookie_name'] : 'plum_session_' . $type;
    $cookie_path = $is_set_config ? $session_config['path'] : '/' . $type;
    //设置是否开启垃圾自动回收机制
    global $gc_open;
    $gc_open    = plum_check_array_key('gc_open', $session_config, true);

    ini_set('session.use_cookies',      plum_check_array_key('use_cookies', $session_config, 1));
    ini_set('session.use_only_cookies', plum_check_array_key('use_only_cookies', $session_config, 1));
    $lottery    = plum_check_array_key('lottery', $session_config, array(1, 1000));
    ini_set('session.gc_probability',   $lottery[0]);
    ini_set('session.gc_divisor',       $lottery[1]);
    ini_set('session.name',             $cookie_name);

    $lifetime   = plum_check_array_key('lifetime', $session_config, 120) * 60;
    ini_set('session.gc_maxlifetime',   $lifetime);
    ini_set('session.save_path',        $save_path);
    $expire     = plum_check_array_key('expire_on_close', $session_config, true);
    $expire     = $expire ? 0 : $lifetime;
    ini_set('session.cookie_lifetime',  $expire);
    ini_set('session.cookie_path',      $cookie_path);
    $domain     = plum_check_array_key('domain', $session_config, null);
    if ($domain) ini_set('session.cookie_domain',   $domain);
    ini_set('session.cookie_secure',    plum_check_array_key('secure', $session_config, 0));
    //@session_start();

    $session_handler = new Libs_Session_FileHandler();
    $session_handler->run();

    plum_app_user_init();
}

function plum_web_session_init() {
    $sessionHandler = new Libs_Session_SessionHandler();
    $sessionHandler->run();
}


/*------------------------------APP USER逻辑处理段---------------------------------------*/
/**
 * app user初始化
 */
function plum_app_user_init() {
    global $APP_USER;
    global $APP_ROLE;
    $APP_USER = isset($_SESSION['uid']) && $_SESSION['uid'] ? intval($_SESSION['uid']) : 0 ;
    $APP_ROLE = isset($_SESSION['role']) && $_SESSION['role'] ? $_SESSION['role'] : '' ;

}
/**
 * app user登录并设置$_SESSION
 * @param int $uid
 * @param string $role
 * @return int
 */
function plum_app_user_login($uid,$role = null) {
    global $APP_USER;
    $uid        = intval($uid);
    //保存角色
    if($role){
        global $APP_ROLE;
        $_SESSION['role'] = $role;
        $APP_ROLE = $role;
    }
    if ($uid > 0) {
        $APP_USER       = $uid;
        $_SESSION['uid']= $uid;
        return $uid;
    }
    return 0;
}

/**
 * app user是否登录并返回登录用户uid
 * @return int
 */
function plum_app_user_islogin() {
    global $APP_USER;
    return $APP_USER > 0 ? $APP_USER : 0;
}

/**
 * app user是否登录并返回登录用户角色
 * @return int
 */
function plum_app_user_role() {
    global $APP_ROLE;
    return $APP_ROLE ? $APP_ROLE : '';
}
function plum_app_get_menu_type() {
    global $APP_MENU_TYPE;
    return $APP_MENU_TYPE ? $APP_MENU_TYPE : '';
}

function plum_app_set_menu_type($menuType) {
    global $APP_MENU_TYPE;
    $_SESSION['menu_type'] = $menuType;
    $APP_MENU_TYPE = $menuType;
}

/**
 * app user退出并清空$_SESSION
 */
function plum_app_user_logout() {
    global $APP_USER;
    global $APP_ROLE;
    $APP_USER           = 0;
    $APP_ROLE           = '';
    $_SESSION['uid']    = 0;
    $_SESSION['role']   = '';
    $_SESSION           = array();

    session_destroy();
}

//注册错误处理函数
new Libs_Log_Error();

class DB extends Libs_Mysql_PlumDatabase {}

$db_config = plum_parse_config('default', 'mysql');

DB::init($db_config);

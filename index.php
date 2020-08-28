<?php
define('DRUPAL_ROOT',       dirname(__FILE__));     //定义DRUPAL根目录
require_once "inc.php";                             //引入配置文件
define('PLUM_ENV', PLUM_DEVELOPMENT_ENV);           //设置当前为开发环境，自动识别测试环境
require_once PLUM_DIR_BOOTSTRAP . '/bootload.inc';  //引入引导文件
//define('PLUM_ENV', PLUM_DEVELOPMENT_ENV);           //设置当前为开发环境，自动识别测试环境

define('PLUM_FXB_SITE', 'manage');

//前后台单一入口 根据request_uri分开
$query          = plum_parse_request_uri();
$prefix         = array_shift($query);
$admin_prefix   = array('admin', 'user', 'js');     //管理端路径前缀
$clear_prefix   = array('managerclear');
// supplier 供应商后台入口
$front_prefix   = array('manage', 'mobile', 'wxapp', 'agent', 'distrib','keeper', 'shop', 'merchant','bdapp','alixcx','supplier');                  //前端路径前缀

if (in_array($prefix, $admin_prefix)) {             //后台模块
    require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
    drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
    menu_execute_active_handler();
    drupal_load('module', 'common');
} elseif(in_array($prefix, $clear_prefix)) {
    require_once PLUM_DIR_BOOTSTRAP . '/distribute.inc';
	execute_manager_clear();
} else {                                            //前台模块
    require_once PLUM_DIR_BOOTSTRAP . '/distribute.inc';
    //使用模块名作为session type，否则使用默认值site
    $session_cfg    = plum_get_config('session');
    $session_type   = isset($session_cfg[$prefix]) ? $prefix : PLUM_FXB_SITE;
    //抽离出默认模块(site)，其他模块则由前缀定义
    $module_type = in_array($prefix, $front_prefix) ? null : PLUM_WEBAPP_MODULE;
    plum_open_session($session_type);
    plum_distribute($module_type);
}

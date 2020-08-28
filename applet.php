<?php
require_once "inc.php";
define('DRUPAL_ROOT',       dirname(__FILE__));
define('PLUM_ENV',          PLUM_DEVELOPMENT_ENV);          //设置当前为开发环境，自动识别测试环境
define('PLUM_CURR_API',     'applet');

require_once PLUM_DIR_BOOTSTRAP . '/bootload.inc';

//plum_auth_session();                                        //使用加解密形式实现session机制
plum_open_session(PLUM_CURR_API);
//plum_api_session_init(PLUM_CURR_API);
plum_api_invoke(PLUM_CURR_API);
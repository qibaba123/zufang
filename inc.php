<?php
/*
 * 梅雨CMS--PLUM CMS
 * 官网：http://www.ikinvin.com
 * 2015-01-06
 */
ini_set('date.timezone',    'Asia/Shanghai');                           //设置为东八区时区

define('PLUM_VERSION',      '0.0.1');
define('PLUM_RELEASE',      '20160314');

define('PLUM_DIR_ROOT',     str_replace("\\","/",dirname(__FILE__)));   //web根目录
define('PLUM_DIR_BOOTSTRAP',PLUM_DIR_ROOT."/bootstrap");                //引导文件目录
define('PLUM_DIR_APP',      PLUM_DIR_ROOT."/sites/app");                //APP所在目录
define('PLUM_DIR_CONFIG',   PLUM_DIR_APP."/config");                    //APP配置所在目录
define('PLUM_APP_PLUGIN',   PLUM_DIR_APP."/plugin");                    //APP插件所在目录
define('PLUM_DIR_LIB',      PLUM_DIR_ROOT."/libs");                     //库文件所在目录
define('PLUM_DIR_UPLOAD',   PLUM_DIR_ROOT."/upload");                   //上传文件目录
define('PLUM_DIR_SESSION',  PLUM_DIR_APP."/storage/session");           //session保存目录
define('PLUM_DIR_CACHE',    PLUM_DIR_APP."/storage/cache");             //cache保存目录
define('PLUM_DIR_TEMP',     PLUM_DIR_APP."/storage/tmp");               //临时文件目录
define('PLUM_APP_LOG',      PLUM_DIR_APP."/storage/log");               //log日志保存目录
define('PLUM_APP_FILE',     PLUM_DIR_APP."/storage/file");              //生成文件保存目录
define('PLUM_APP_BUILD',    PLUM_DIR_ROOT."/public/build");             //生成文件目录
define('PLUM_PATH_UPLOAD',  "/upload");                                 //上传文件根路径
define('PLUM_PATH_PUBLIC',  "/public");                                 //公共文件根路径
define('PLUM_WEBAPP_MODULE',"site");                                    //默认的APP模块
define("PLUM_CHECK_DOMIN", base64_decode("aHR0cDovL3d3dy50aWFuZGlhbnRvbmcuY29tL3d4YXBwL2luc3RhbGwvY2hlY2tEb21pbj9kb21haW49"));

define('PLUM_TESTING_ENV',      'test');                                //当前测试环境
define('PLUM_DEVELOPMENT_ENV',  'dev');                                 //当前开发环境
define('PLUM_PRODUCTION_ENV',   'pro');                                 //当前生产环境
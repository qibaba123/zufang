<?php

class Libs_Log_Error {
    const TESTING_DEBUG_ENV     = 'testing';
    const DEVELOPMENT_DEBUG_ENV = 'development';
    const PRODUCTION_DEBUG_ENV  = 'production';
    /**
     * 映射PHP所有错误类型
     * @var array
     */
    private static $error_type = array(
        E_ERROR             => '错误',            //不可自行处理
        E_WARNING           => '警告',
        E_PARSE             => '语法解析错误',     //不可自行处理
        E_NOTICE            => '通知',
        E_CORE_ERROR        => '核心级错误',       //不可自行处理
        E_CORE_WARNING      => '核心级警告',       //不可自行处理
        E_COMPILE_ERROR     => '编译错误',         //不可自行处理
        E_COMPILE_WARNING   => '编译警告',         //不可自行处理
        E_USER_ERROR        => '用户级错误',
        E_USER_WARNING      => '用户级警告',
        E_USER_NOTICE       => '用户级通知',
        E_STRICT            => '运行时通知',
        E_RECOVERABLE_ERROR => '可捕获的致命错误',
        3                   => '可捕获的异常'
    );

    private static $log_type    = array('error', 'warn', 'notice');

    private static $env         = self::DEVELOPMENT_DEBUG_ENV;
    private static $debug       = false;

    public function __construct() {
        //先检测测试环境
        if (plum_check_test_env()) {
            self::$env      = self::TESTING_DEBUG_ENV;
        } else {
            self::$env      = plum_parse_config('app_debug_env', 'app', self::DEVELOPMENT_DEBUG_ENV);
        }

        self::$debug    = plum_get_isset_param('debug') || plum_parse_config('app_debug_mode', 'app', false);

        //非生产环境，并且debug模式为true时，显示所有错误
        if (self::$env != self::PRODUCTION_DEBUG_ENV && self::$debug) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            //关闭所有PHP错误报告，使用自定义错误报告
            error_reporting(0);
            ini_set('display_errors', 'Off');
            $this->_set_error_handler();
            $this->_set_exception_handler();
            $this->_set_shutdown_handler();
        }
    }

    /**
     * 自定义错误处理函数
     */
    private function _set_error_handler() {
        //设置自定义错误处理函数
        set_error_handler(function($errno, $errmsg, $filename, $linenum, $vars) {
            $err = array(
                'type'      => $errno,
                'message'   => $errmsg,
                'file'      => $filename,
                'line'      => $linenum
            );
            switch($errno) {
                //错误
                case E_USER_ERROR :
                    self::halt($err, 'error');
                    break;
                //警告
                case E_WARNING :
                case E_USER_WARNING :
                    self::halt($err, 'warn');
                    break;
                //注意
                case E_NOTICE :
                case E_USER_NOTICE :
                default :
                    self::halt($err, 'notice');
                    break;
            }
            //返回false时，标准错误处理程序将会继续调用
            //return true;
        });
    }

    private function _set_shutdown_handler() {
        register_shutdown_function(function() {
            if ($err = error_get_last()) {
                //致命级错误
                switch($err['type']) {
                    case E_ERROR :
                    case E_PARSE :
                    case E_CORE_ERROR :
                    case E_COMPILE_ERROR :
                    //case E_USER_ERROR : //已处理，不再继续接收
                        self::halt($err, 'error');
                        break;
                }
            }
        });
    }

    private function _set_exception_handler() {
        set_exception_handler(function(Exception $e) {
            $err = array(
                'type'      => 3,
                'message'   => $e->getMessage(),
                'file'      => $e->getFile(),
                'line'      => $e->getLine()
            );
            self::halt($err, 'exception');
        });
    }

    /**
     * 错误处理统一调用入口
     * @param array $err    错误信息
     * @param string $type  错误类型
     */
    protected static function halt($err, $type = 'error') {
        $log = array(
            'errortime'     => date('Y-m-d H:i:s', time()),
            'errornum'      => $err['type'],
            'errortype'     => self::$error_type[$err['type']],
            'errormsg'      => $err['message'],
            'errorfile'     => $err['file'],
            'errorline'     => $err['line'],
        );

        $log_file_name  = $type.'-'.self::$env.'.log';

        switch ($type) {
            //错误信息，写入日志，并发送邮件告知
            case 'exception' :
            case 'error' :
                Libs_Log_Logger::outputLog($log, $log_file_name);
                //设置模板信息
                $app_name       = plum_parse_config('app_name', 'app', '');
                $smarty         = new Libs_View_Smarty_SmartyTool(PLUM_DIR_ROOT.'/error/');
                $smarty->output['app_name'] = $app_name;
                $smarty->output['err']      = $log;
                $template500    = $smarty->fetchSmarty('500.tpl');
                if (self::$env == self::PRODUCTION_DEBUG_ENV) {//线上生产环境
                    //发送邮件
                    $mailer = new Libs_Mail_Mailer();
                    $mailer->sendMail($app_name, $template500);
                    //对外显示错误信息页面模板
                    $template500 = $smarty->fetchSmarty('500.html');
                }
                die($template500);
                break;
            //警告信息，写入日志
            case 'warn' :
                Libs_Log_Logger::outputLog($log, $log_file_name);
                break;
            //注意信息，暂不处理
            case 'notice' :
            default :

                break;
        }
    }
}
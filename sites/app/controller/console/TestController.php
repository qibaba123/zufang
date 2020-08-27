<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/25
 * Time: 上午9:29
 */
class App_Controller_Console_TestController extends Libs_Mvc_Controller_ConsoleController {

    public function __construct() {
        parent::__construct();
    }

    /*
     * 创建守护进程
     * 执行示例: php /alidata/www/sale/scripts/console.php "member/create"
     */
    public function createAction() {

        $this->createDaemon(3, function ($instance, $pattern, $chan, $msg) {
            $this->eventDistribute($msg);
        });

    }

    /*
     * redis键过期事件分发
     */
    public function eventDistribute($key) {
        $data   = explode('_', $key);
        $kind   = array_shift($data);
        $type   = array_shift($data);

        switch ($kind) {
            case 'daemon' :
                switch ($type) {
                    //订单定时关闭
                    case 'buy' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $goid   = array_shift($data);

                        switch ($method) {
                            //组团活动超时
                            case 'test' :
                                Libs_Log_Logger::outputLog($key, 'ele.log');
                                //trigger_error("test error", E_USER_ERROR);
                                break;
                        }
                        break;
                }
                break;
        }
    }

    /*
     * 重启守护进程
     * 执行示例：php scripts/console.php "member/restart"
     */
    public function restartAction() {
        $this->stopAction();
        $this->createAction();
    }

    /*
     * 停止守护进程
     * 执行示例：php scripts/console.php "member/stop"
     */
    public function stopAction(){
        $this->stopDaemon();
    }
    
    public function __destruct() {
        //切到根目录
        Libs_Log_Logger::outputLog($this->process_id, 'ele.log');

        global $argv;
        $enter   = explode('/', $argv[1])[0];
        $operate = explode('/', $argv[1])[1];
        $times   = $argv[2]?$argv[2]:0; //重启的次数

        if ($this->process_id == 0 && $times < 5 && ($operate == 'create' || $operate == 'restart')) {
            Libs_Log_Logger::outputLog($enter."守护进程异常退出", 'daemon-error.log');
            $this->restartDaemon($enter, $times+1);
        }
    }
}
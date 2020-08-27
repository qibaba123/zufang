<?php

class App_Controller_Console_AnswerpayController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;

    public function __construct() {
        parent::__construct();
    }

    /*
    * 创建守护进程
    * 执行示例: php /alidata/www/sale/scripts/console.php "member/create"
    */
    public function createAction() {

        $this->createDaemon(6, function ($instance, $pattern, $chan, $msg) {
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
            case 'answerpay' :
                switch ($type) {
                    //问题
                    case 'question' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $id   = array_shift($data);
                        $answerpay_helper = new App_Helper_Answerpay($sid);
                        switch ($method) {
                            //问题自动退款关闭
                            case 'refund' :
                                $answerpay_helper->autoCloseQuestion($id);
                                break;
//                            case  'check':
//                                $knowledge_helper->autoQuestionCheck($id);
//                                break;
                        }
                        break;
//                    case 'apply':
//                        $method = array_shift($data);
//                        $sid    = array_shift($data);
//                        $id   = array_shift($data);
//                        $knowledge_helper = new App_Helper_Knowledge($sid);
//                        switch ($method) {
//                            //问题自动退款关闭
//                            case 'handle' :
//                                $knowledge_helper->autoApplyHandle($id);
//                                break;
//                        }
//                        break;
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
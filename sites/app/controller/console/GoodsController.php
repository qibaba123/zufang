<?php

class App_Controller_Console_GoodsController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;

    public function __construct() {
        parent::__construct();
    }

    /*
    * 创建守护进程
    * 执行示例: php /alidata/www/sale/scripts/console.php "member/create"
    */
    public function createAction() {

        $this->createDaemon(10, function ($instance, $pattern, $chan, $msg) {
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
        Libs_Log_Logger::outputLog('执行Goods过期时间分发');
        switch ($kind) {
            //商品定时任务
            case 'goods' :
                switch ($type) {
                    //自动上下架定时任务
                    case 'sale' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $gid = array_shift($data);
                        $sequence_helper     = new App_Helper_Sequence($sid);
                        switch ($method) {
                              //订单分佣
                            case 'return':
                                $sequence_helper->returnTrade($gid);
                                break;
                            //定时上架任务
                            case 'up' :
                                $sequence_helper->_goods_sale_auto($gid,'up');
                                break;
                            //定时下架任务
                            case 'down' :
                                $sequence_helper->_goods_sale_auto($gid,'down');
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
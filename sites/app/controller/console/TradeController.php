<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 下午12:06
 */
class App_Controller_Console_TradeController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;

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
            case 'mall' :
                switch ($type) {
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $tid    = array_shift($data);
                        $trade_helper = new App_Helper_Trade($sid);
                        switch ($method) {
                             //订单分佣
                            case 'return':
                                $trade_helper->returnTrade($tid);
                                break;
                            //订单超时关闭
                            case 'close' :
                                $trade_helper->closeOvertimeTrade($tid);
                                break;
                            //订单自动完成
                            case 'finish' :
                                $trade_helper->completeOvertimeTrade($tid);
                                break;
                            //结算交易到期
                            case 'settled' :
                                $trade_helper->recordSuccessSettled($tid);
                                break;
                            //超时退款处理
                            case 'refund' :
                                $trade_helper->dealAutoRefund($tid);
                                break;
                            //蜂鸟配送推单
                            case 'eledelivery' :
                                $trade_helper->dealEleDelivery($tid);
                                break;
                            //订单打印
                            case 'print' :
                                $trade_helper->dealTradePrint($tid);
                                break;
                        }
                        break;
                }
                break;
            case 'merchant' :
                switch ($type) {
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $tid = array_shift($data);
                        $trade_helper   = new App_Helper_MerchantTrade($sid);
                        switch ($method) {
                            //订单超时关闭
                            case 'close' :
                                $trade_helper->closeOvertimeTrade($tid,$sid);
                                break;
                            //订单自动完成
                            case 'finish' :
                                $trade_helper->completeOvertimeTrade($tid,$sid);
                                break;
                            //结算交易到期
                            case 'settled' :
                                $trade_helper->recordSuccessSettled($tid,$sid);
                                break;
                            //超时退款处理
                            case 'refund' :
                                $trade_helper->dealAutoRefund($tid,$sid);
                                break;
                        }
                        break;
                }
                break;
            case 'legwork' :
                switch ($type) {
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $tid = array_shift($data);
                        $trade_helper   = new App_Helper_Legwork($sid);
                        switch ($method) {
                            //订单超时关闭
                            case 'close' :
                                $trade_helper->closeOvertimeTrade($tid);
                                break;
                            case 'cancel' :
                                $trade_helper->cancelOvertimeTrade($tid);
                                break;
                            case 'alert' :
                                $trade_helper->alertOvertimeTrade($tid);
                                break;
                        }
                        break;
                }
                break;
            case 'handy' :
                switch ($type) {
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $tid = array_shift($data);
                        $trade_helper   = new App_Helper_Handy($sid);
                        switch ($method) {
                            //订单超时关闭
                            case 'close' :
                                $trade_helper->closeOvertimeTrade($tid);
                                break;
                            //订单超时取消
                            case 'cancel' :
                                $trade_helper->cancelOvertimeTrade($tid);
                                break;
                            //订单超时完成
                            case 'finish' :
                                $trade_helper->finishOvertimeTrade($tid);
                                break;
                        }
                        break;
                }
                break;
            case 'helper' :
                switch ($type) {
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $tid = array_shift($data);
                        $trade_helper   = new App_Helper_Helper($sid);
                        switch ($method) {
                            //订单超时关闭
                            case 'close' :
                                $trade_helper->closeOvertimeTrade($tid);
                                break;
                            //订单超时取消
                            case 'cancel' :
                                $trade_helper->cancelOvertimeTrade($tid);
                                break;
                            //订单超时完成
                            case 'finish' :
                                $trade_helper->finishOvertimeTrade($tid);
                                break;
                        }
                        break;
                }
                break;
            case 'giftcard' :
                switch ($type) {
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $tid = array_shift($data);
                        $trade_helper   = new App_Helper_Giftcard($sid);
                        switch ($method) {
                            //订单超时关闭
                            case 'close' :
                                $trade_helper->closeOvertimeTrade($tid);
                                break;
                        }
                        break;
                }
                break;
            case 'meal' :
                switch ($type) {
                    case 'trade' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $tid = array_shift($data);
                        $trade_helper   = new App_Helper_Trade($sid);
                        switch ($method) {
                            //订单未接单
                            case 'unreceive' :
                                $trade_helper->dealUnreceiveOrder($tid);
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
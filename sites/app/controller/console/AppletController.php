<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/25
 * Time: 上午9:29
 */
class App_Controller_Console_AppletController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;

    public function __construct() {
        parent::__construct();
    }

    /*
    * 创建守护进程
    * 执行示例: php /alidata/www/sale/scripts/console.php "member/create"
    */
    public function createAction() {

        $this->createDaemon(9, function ($instance, $pattern, $chan, $msg) {
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
            case 'forum' :
                switch ($type) {
                    //订单定时关闭
                    case 'top' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $pid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateTopOvertimePost(intval($pid));
                                break;
                        }
                        break;
                    case 'bag' : //红包过期
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $pid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateBagOvertimePost(intval($pid));
                                break;
                        }
                        break;
                }
                break;
            case 'car' :
                switch ($type) {
                    //订单定时关闭
                    case 'top' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $pid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateTopOvertimeCar(intval($pid));
                                break;
                        }
                        break;
                }
                break;
            case 'house' :
                switch ($type) {
                    //订单定时关闭
                    case 'top' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $hid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateTopOvertimeHouse(intval($hid));
                                break;
                        }
                }
                break;
            case 'position':
                switch ($type) {
                    //订单定时关闭
                    case 'top' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $pid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateTopOvertimePosition(intval($pid));
                                break;
                        }
                        break;
                }
                break;
            case 'community':
                switch ($type) {

                    //订单定时关闭
                    case 'top' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $pid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateCommunityTopOvertimePost(intval($pid));
                                break;
                        }
                        break;
                }
                break;
            case 'city':
                switch ($type) {
                    //订单定时关闭
                    case 'enter' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $shid   = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'expire1' :
                                $applet_helper->noticeShopExpire(intval($shid), 1);
                                break;
                            case 'expire7' :
                                $applet_helper->noticeShopExpire(intval($shid), 7);
                                break;
                            case 'expire15' :
                                $applet_helper->noticeShopExpire(intval($shid), 15);
                                break;
                        }
                        break;
                }
                break;
            case 'job':
                switch ($type) {
                    //订单定时关闭
                    case 'award' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $id   = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //到期未确认 发放入职奖
                            case 'entry' :
                                $applet_helper->sendAward(intval($id));
                                break;
                        }
                        break;
                    case 'confirm' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $id   = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //到期自动确认面试
                            case 'interview' :
                                $applet_helper->confirmInterview(intval($id));
                                break;
                        }
                        break;
                }
                break;
            case 'auction':
                switch ($type) {
                    //订单定时关闭
                    case 'activity' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $id    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //拍卖活动结束
                            case 'end' :
                                $applet_helper->auctionEnd(intval($id));
                                break;
                        }
                        break;
                    //订单定时关闭
                    case 'trade' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $id    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //拍卖活动结束
                            case 'close' :
                                $applet_helper->auctionTradeClose(intval($id));
                                break;
                        }
                        break;
                }
                break;
            case 'sequence':
                switch ($type) {

                    //订单定时关闭
                    case 'top' :
                        $method = array_shift($data);
                        $sid    = array_shift($data);
                        $pid    = array_shift($data);

                        $applet_helper   = new App_Helper_WxappApplet(intval($sid));
                        switch ($method) {
                            //置顶时间到期
                            case 'over' :
                                $applet_helper->updateSequenceTopOvertimePost(intval($pid));
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
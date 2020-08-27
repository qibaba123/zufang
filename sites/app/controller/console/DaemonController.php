<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/11
 * Time: 下午10:23
 */
class App_Controller_Console_DaemonController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;

    public function __construct() {
        parent::__construct();
    }

    /*
    * 创建守护进程
    * 执行示例: php /alidata/www/sale/scripts/console.php "member/create"
    */
    public function createAction() {

        $this->createDaemon(1, function ($instance, $pattern, $chan, $msg) {
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
            //一元夺宝定时任务
            case 'unitary' :
                switch ($type) {
                    //夺宝计划定时任务
                    case 'plan' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $pid = array_shift($data);
                        $unitary_helper     = new App_Helper_UnitaryOrder($sid);
                        switch ($method) {
                            //定时计算任务
                            case 'compute' :
                                $unitary_helper->computePlan($pid);
                                break;
                            //定时发布结果
                            case 'publish' :
                                $unitary_helper->publishPlan($pid);
                                break;
                            //定时填充任务
                            case 'fill' :
                                $unitary_helper->fillPlan($pid);
                                break;
                        }
                        break;
                    //定时红包任务
                    case 'redpack' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $pid = array_shift($data);
                        $unitary_helper     = new App_Helper_UnitaryOrder($sid);
                        switch ($method) {
                            //定时计算红包
                            case 'compute' :
                                $unitary_helper->computeRedpack($pid);
                                break;
                            case 'award' :
                                $unitary_helper->publishRedpack($pid);
                                break;
                        }
                        break;
                }
                break;
            //微砍价定时任务
            case 'bargain' :
                switch ($type) {
                    case 'activity' :
                        $method = array_shift($data);
                        $sid = array_shift($data);
                        $aid = array_shift($data);
                        $bargain_activity   = new App_Helper_BargainActivity($sid);
                        switch ($method) {
                            //定时计算任务
                            case 'start' :
                                $bargain_activity->updateActivityStatus($aid, 'ongoing');
                                break;
                            //定时发布结果
                            case 'end' :
                                $bargain_activity->updateActivityStatus($aid, 'closed');
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
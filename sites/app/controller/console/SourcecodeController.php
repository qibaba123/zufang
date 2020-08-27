<?php
/**
 * 此守护进程仅限源码使用
 */

class App_Controller_Console_SourcecodeController extends Libs_Mvc_Controller_ConsoleController {

    private $pid;
    private $redis;

    public function __construct() {
        parent::__construct();
        $redis_client = new Libs_Redis_RedisClient();
        $this->redis = $redis_client->getRedis();
    }

    /*
    * 创建守护进程
    * 执行示例: php /alidata/www/sale/scripts/console.php "sourcecode/create"
    */
    public function createAction() {
        $this->redis->select(12);//操作12号数据库
        //计算倒计时
        $key    = "source_code_auth";
        $this->redis->setex($key, 3600*12, $key);

        $this->createDaemon(12, function ($instance, $pattern, $chan, $msg) {
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
        Libs_Log_Logger::outputLog('执行sourcecode过期时间分发');
        switch ($kind) {
            //商品定时任务
            case 'source' :
                switch ($type) {
                    //自动上下架定时任务
                    case 'code' :
                        $method = array_shift($data);
                        switch ($method) {
                            //定时上架任务
                            case 'auth' :
                                $this->redis->select(12);//操作12号数据库
                                //计算倒计时
                                $key    = "source_code_auth";
                                $this->redis->setex($key, 3600*24, $key);
                                
                                $domain = $this->redis->get('domain');
                                if($domain){
                                  $result = file_get_contents(PLUM_CHECK_DOMIN.$domain);
                                }
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
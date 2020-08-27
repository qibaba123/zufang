<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/6
 * Time: 下午9:19
 * @desc 作为后端进程使用时，popen,pclose不可被禁用
 */

class Libs_Mvc_Controller_ConsoleController {

    public $php_bin;

    public $process_id;

    public $piddir;

    public $pidfile;

    public $start_file;

    public function __construct() {
        //非控制台调用直接退出，避免被外部访问
        if (php_sapi_name() != 'cli') {
            die('请在控制台下执行脚本');
        }
        $bin    = plum_parse_config('php_bin', 'console');
        $this->php_bin  = $bin ? $bin : 'php';

        $this->piddir = PLUM_DIR_TEMP. "/pids/";

        plum_setmod_dir($this->piddir);

        global $argv;
        $this->start_file = $argv[1];
        $this->pidfile = $this->piddir . explode('/', $this->start_file)[0] . ".pid";

    }
    /*
     * 创建守护进程并监听redis数据库订阅发布事件
     * @param int $index 监听的redis数据库index
     */
    public function createDaemon($index = 0, $callback) {
        Libs_Log_Logger::outputLog(222,'ele.log');
        if (file_exists($this->pidfile)) {//判断进pid是否存在，防止重复启动
            echo "The file $this->pidfile exists.\n";
            exit();
        }

        ini_set('default_socket_timeout', -1);

        $pid    = pcntl_fork();
        $this->process_id  = $pid;

        if ($pid === -1) {
            //创建子进程失败
            return false;
        } else if ($pid) {
            //父进程中，退出父进程
            //让由用户启动的进程退出
            usleep(500);
            exit;
        }
        //建立一个有别于终端的新session以脱离终端
        $sid    = posix_setsid();
        if ($sid < 0) {
            return false;
        }

        $pid    = pcntl_fork();
        $this->process_id  = $pid;
        if ($pid === -1) {
            return false;
        } else if ($pid) {
            //父进程退出, 剩下子进程成为最终的独立进程
            usleep(50);
            exit;
        }else{
            file_put_contents($this->pidfile, getmypid());
        }

        //关闭标准输入输出的重定向
        if (defined('STDIN')) {
            fclose(STDIN);
        }

        if (defined('STDOUT')) {
            fclose(STDOUT);
        }

        if (defined('STDERR')) {
            fclose(STDERR);
        }

        $cfg    = plum_parse_config('connect', 'redis');
        $redis  = new Redis();
        $redis->connect($cfg['host'], $cfg['port'], $cfg['timeout']);
        $redis->auth($cfg['password']);
        Libs_Log_Logger::outputLog(333,'ele.log');
        Libs_Log_Logger::outputLog($callback,'ele.log');
        Libs_Log_Logger::outputLog($index,'ele.log');
        $redis->pSubscribe(array("__keyevent@{$index}__:expired"), $callback);
    }

    /**
     * 关闭守护进程
     */
    public function stopDaemon(){
        if (file_exists($this->pidfile)) {
            $pid = file_get_contents($this->pidfile);
            posix_kill($pid, 9);
            unlink($this->pidfile);
        }
    }

    /*
     * 重启守护进程
     */
    public function restartDaemon($enter, $times) {
        //切到根目录
        shell_exec('cd '.PLUM_DIR_ROOT);
        shell_exec($this->php_bin.' scripts/console.php "'.$enter.'/restart" '.$times);
    }

}
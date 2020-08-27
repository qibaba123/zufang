<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2019/10/19
 * Time: 8:12 PM
 */
class App_Controller_Console_DatasyncController extends Libs_Mvc_Controller_ConsoleController {

    const RETRY_NUM = 3;//重试次数

    public $sql;

    public $config;
    public $link;
    //重试次数
    public $retry = 0;

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        //nothing to do
    }
    /*
     * 开始同步数据
     */
    public function syncAction() {
        $this->sql  = base64_decode(plum_get_param('sql'));

        $this->connect();
        $rows = $this->query();
        Libs_Log_Logger::outputLog($rows, 'sqlinfo.log');
    }
    /*
     * 建立到rds的持久化连接
     */
    public function connect() {
        $type   = plum_parse_config('sync_type', 'mysql');
        $config = plum_parse_config($type, 'mysql');
        if (!$config) {
            $this->halt('mysql rds config empty');
        }
        $this->config    = $config;

        $link = @new mysqli(
            'p:'.$this->config['host'],
            $this->config['user'],
            $this->config['pass'],
            $this->config['dbname'],
            $this->config['port']
        );
        if ($link->connect_errno) {
            $this->halt("mysqli connect failed. connect error:{$link->connect_errno}:{$link->connect_error}. with config:" . json_encode($this->config));
        }
        $link->set_charset(isset($this->config['dbcharset']) ? $this->config['dbcharset'] : 'utf8mb4');
        $this->link = $link;
        unset($link);
    }
    /*
     * 执行update/delete/insert/replace，返回影响行数
     */
    public function query() {
        $query  = $this->link->query($this->sql);
        if($query === false) {//执行失败
            if ($this->retry < self::RETRY_NUM) {
                $this->retry++;
                return $this->query($this->sql);
            } else {
                $this->halt($this->link->error, $this->link->errno, $this->sql);
            }
        }
        $affect_num = $this->link->affected_rows;

        $this->link->close();
        Libs_Log_Logger::outputLog($this->sql, 'sqlinfo.log');
        return $affect_num;
    }

    public function halt($message = '', $code = 0, $sql = '') {
        trigger_error("errmsg={$message};errcode={$code};sql={$sql}", E_USER_ERROR);
        exit;
    }
}
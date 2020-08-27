
<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2019/10/19
 * Time: 8:12 PM
 */
class App_Controller_Console_SyncController extends Libs_Mvc_Controller_ConsoleController {

    const TABLE_PREFIX = array('pre_', 'dpl_');
    const RETRY_NUM = 5;//重试次数

    public $sync_type;
    public $tbl_pre;
    public $sql;
    public $sync_table;

    public $config;
    public $link;
    //重试次数
    public $retry = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction() {
        //Libs_Log_Logger::outputConsoleLog("this is console sync");
        //Libs_Log_Logger::outputLog('abcd', 'sqlinfo.log');
        $mail = new Libs_Mail_Mailer('thomas@ikinvin.com');
        $mail->sendMail('后端进程', '发送内容');
    }
    /*
     * 开始同步数据
     */
    public function syncAction() {
        Libs_Log_Logger::outputLog('ded', 'sqlinfo.log');
        $this->sql  = base64_decode(plum_get_param('sql'));
        $this->tbl_pre  = self::TABLE_PREFIX;

        $this->syncFilter();
        if ($this->sync_type) {
            $this->syncTable();
            if ($this->sync_table) {
                //过滤表名

                Libs_Log_Logger::outputLog($this->sync_table, 'sqlinfo.log');
            }
        }
    }
    /*
     * 过滤DML操作类型
     */
    public function syncFilter() {
        $sql = ltrim($this->sql);
        $first_char = strtoupper($sql[0]);

        Libs_Log_Logger::outputLog($sql, 'sqlinfo.log');
        if (!$first_char || $first_char == 'S') {
            $this->sync_type = false;//select操作无须同步
        } else {
            $oper   = substr($sql, 0, 7);
            $oper   = strtoupper(rtrim($oper));

            $this->sync_type = $oper;
            Libs_Log_Logger::outputLog($sql, 'sqlinfo.log');
        }
    }
    /*
     * 获取操作表
     */
    public function syncTable() {
        $needle = false;
        $prefix = false;

        foreach ($this->tbl_pre as $index) {
            $tmp_needle = stripos($this->sql, $index);
            if ($tmp_needle !== false) {
                if ($needle === false || $tmp_needle < intval($needle)) {
                    $needle = $tmp_needle;
                    $prefix = $index;
                }
            }
        }

        if (!$prefix) {
            $this->sync_table = false;
        } else {
            $table_name = '';
            do {
                $char = $this->sql[$needle];
                $needle++;

                if ($char == '`' || $char == ' ') {
                    break;
                } else {
                    $table_name .= $char;
                }
            } while (true);

            $this->sync_table = $table_name;
        }

    }
    /*
     * 建立到rds的持久化连接
     */
    public function connect() {
        $config = plum_parse_config('rds2', 'mysql');
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
                $this->query($this->sql);
            } else {
                $this->halt($this->link->error, $this->link->errno, $this->sql);
            }
        }
        $affect_num = $this->link->affected_rows;

        $this->link->close();
        return $affect_num;
    }

    public function halt($message = '', $code = 0, $sql = '') {
        trigger_error("errmsg={$message};errcode={$code};sql={$sql}", E_USER_ERROR);
        exit;
    }
}
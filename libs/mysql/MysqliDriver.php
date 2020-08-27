<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-24
 * Class Libs_Mysql_MysqlDriver
 */

class Libs_Mysql_MysqliDriver {

    public $version;
    public $driver_type = 'mysqli';
    public $table_prefix;//表前缀，如pre_
    public $cur_link;
    public $config;
    public $query_num;

    //设置配置信息
    public function set_config($config) {
        if (!empty($config)) {
            $this->config = $config;
            $this->table_prefix = isset($this->config['tablepre']) ? $this->config['tablepre'] : 'pre_';
        } else {
            $this->halt("call undefined mysql configure");
        }
    }
    //连接数据库
    public function connect() {
        if (empty($this->config)) {
            $this->halt('mysql db config empty');
        }
        $link = @new mysqli(
            $this->config['host'],
            $this->config['user'],
            $this->config['pass'],
            $this->config['dbname'],
            $this->config['port']
        );
        if ($link->connect_errno) {
            $this->halt("mysqli connect failed. connect error:{$link->connect_error}. with config:" . json_encode($this->config));
        }
        $link->set_charset(isset($this->config['dbcharset']) ? $this->config['dbcharset'] : 'utf8mb4');
        $this->cur_link = $link;
        unset($link);
    }
    //获取完整表名
    public function table_name($tablename) {
        return $this->table_prefix . $tablename;
    }
    //以关联数组形式获取第一行数据
    public function fetch_first($sql) {
        return $this->fetch_array($this->query($sql));
    }
    //获取数据首行，首个字段数据
    public function result_first($sql) {
        return $this->result($this->query($sql), 0);
    }
    //执行查询，unbuffered是否缓存数据集
    public function query($sql, $silent = false, $unbuffered = false) {
        if('UNBUFFERED' === $silent) {
            $silent = false;
            $unbuffered = true;
        } elseif('SILENT' === $silent) {
            $silent = true;
            $unbuffered = false;
        }

        $resultmode = $unbuffered ? MYSQLI_USE_RESULT : MYSQLI_STORE_RESULT;

        if(!($query = $this->cur_link->query($sql, $resultmode))) {
            if(in_array($this->errno(), array(2006, 2013)) && substr($silent, 0, 5) != 'RETRY') {
                $this->connect();
                return $this->cur_link->query($sql, 'RETRY'.$silent);
            }
            if(!$silent) {
                $this->halt($this->error(), $this->errno(), $sql);
            }
        }

        $this->query_num++;
        return $query;
    }
    //总行数，buffered数据集时可用
    public function num_rows($query) {
        return $query ? $query->num_rows : 0;
    }
    //结果集query中的字段数目
    public function num_fields($query) {
        return $query ? $query->field_count : null;
    }

    public function free_result($query) {
        return $query ? $query->free() : false;
    }
    //默认以关联数组的形式获取结果集
    public function fetch_array($query, $result_type = MYSQLI_ASSOC) {
        if($result_type == 'MYSQL_ASSOC')
            $result_type = MYSQLI_ASSOC;
        return $query ? $query->fetch_array($result_type) : null;
    }
    //获取结果集中第row行数据中的第一个字段数据
    public function result($query, $row = 0) {
        if(!$query || $query->num_rows == 0) {
            return null;
        }
        $query->data_seek($row);
        $assocs = $query->fetch_row();
        return $assocs[0];
    }

    public function fetch_row($query) {
        return $query ? $query->fetch_row() : null;
    }

    public function fetch_fields($query) {
        return $query ? $query->fetch_field() : null;
    }

    public function escape($escapestr) {
        return $this->cur_link->real_escape_string($escapestr);
    }

    public function affected_rows() {
        return $this->cur_link->affected_rows;
    }

    public function insert_id() {
        return ($id = $this->cur_link->insert_id) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
    }

    public function errno() {
        return intval($this->cur_link->errno);
    }

    public function error() {
        return $this->cur_link->error;
    }

    public function version() {
        if(empty($this->version)) {
            $this->version = $this->cur_link->server_info;
        }
        return $this->version;
    }

    public function close() {
        $this->cur_link->close();
    }

    public function halt($message = '', $code = 0, $sql = '') {
        trigger_error("errmsg={$message};errcode={$code};sql={$sql}", E_USER_ERROR);
        exit;
    }
}

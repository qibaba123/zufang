<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/2/6
 * Time: 下午9:17
 */
class Libs_Mysql_FactoryDB {
    /**
     * @var Libs_Mysql_MysqliDriver
     */
    public $db;

    /**
     * Libs_Mysql_FactoryDB constructor.
     * @param $config 
     */
    public function __construct($config){
        $this->init($config);
    }

    public function init($config) {
        $this->db = new Libs_Mysql_MysqliDriver();
        $this->db->set_config($config);
        $this->db->connect();
    }

    public function table($table) {
        return $this->db->table_name($table);
    }
    //删
    public function delete($table, $condition, $limit = 0, $unbuffered = true) {
        if (empty($condition)) {
            return false;
        } elseif (is_array($condition)) {
            if (count($condition) == 2 && isset($condition['where']) && isset($condition['arg'])) {
                $where = $this->format($condition['where'], $condition['arg']);
            } else {
                $where = $this->implode_field_value($condition, ' AND ');
            }
        } else {
            $where = $condition;
        }
        $limit = intval($limit);
        $sql = "DELETE FROM " . $this->table($table) . " WHERE $where " . ($limit > 0 ? "LIMIT $limit" : '');
        return $this->query($sql, ($unbuffered ? 'UNBUFFERED' : ''));
    }
    //增
    public function insert($table, $data, $return_insert_id = false, $replace = false, $silent = false) {

        $sql = $this->implode($data);
        $cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
        $table = $this->table($table);
        $silent = $silent ? 'SILENT' : '';

        return $this->query("$cmd $table SET $sql", null, $silent, !$return_insert_id);
    }
    //改
    public function update($table, $data, $condition, $unbuffered = false, $low_priority = false) {
        $sql = $this->implode($data);
        if(empty($sql)) {
            return false;
        }
        $cmd = "UPDATE " . ($low_priority ? 'LOW_PRIORITY' : '');
        $table = $this->table($table);
        $where = '';
        if (empty($condition)) {
            $where = '1';
        } elseif (is_array($condition)) {
            $where = $this->implode($condition, ' AND ');
        } else {
            $where = $condition;
        }
        $res = $this->query("$cmd $table SET $sql WHERE $where", $unbuffered ? 'UNBUFFERED' : '');
        return $res;
    }
    //增
    public function insert_id() {
        return $this->db->insert_id();
    }
    //改、删
    public function affected_rows() {
        return $this->db->affected_rows();
    }
    //获取结果集第一行
    public function fetch_first($sql, $arg = array(), $silent = false) {
        $res = $this->query($sql, $arg, $silent, false);
        $ret = $this->db->fetch_array($res);
        $this->db->free_result($res);
        return $ret ? $ret : array();
    }
    //获取结果集所有行
    public function fetch_all($sql, $arg = array(), $keyfield = '', $silent = false) {
        $data = array();
        $query = $this->query($sql, $arg, $silent, false);
        while ($row = $this->db->fetch_array($query)) {
            if ($keyfield && isset($row[$keyfield])) {
                $data[$row[$keyfield]] = $row;
            } else {
                $data[] = $row;
            }
        }
        $this->db->free_result($query);
        return $data;
    }
    //从结果集中获取一行
    public function fetch($result, $type = 'MYSQL_ASSOC') {
        return $this->db->fetch_array($result, $type);
    }
    //从结果集某一行获取第一个字段值
    public function result($result, $row = 0) {
        return $this->db->result($result, $row);
    }
    //获取结果集第一行的第一个字段值
    public function result_first($sql, $arg = array(), $silent = false) {
        $res = $this->query($sql, $arg, $silent, false);
        $ret = $this->db->result($res, 0);
        $this->db->free_result($res);
        return $ret;
    }

    public function query($sql, $arg = array(), $silent = false, $unbuffered = false) {
        if (!empty($arg)) {
            if (is_array($arg)) {
                $sql = $this->format($sql, $arg);
            } elseif ($arg === 'SILENT') {
                $silent = true;

            } elseif ($arg === 'UNBUFFERED') {
                $unbuffered = true;
            }
        }
        $ret = $this->db->query($sql, $silent, $unbuffered);
        if (!$unbuffered && $ret) {
            $cmd = trim(strtoupper(substr($sql, 0, strpos($sql, ' '))));
            if ($cmd === 'SELECT') {

            } elseif ($cmd === 'UPDATE' || $cmd === 'DELETE') {
                $ret = $this->db->affected_rows();
            } elseif ($cmd === 'INSERT') {
                $ret = $this->db->insert_id();
            }
        }
        return $ret;
    }

    public function num_rows($resourceid) {
        return $this->db->num_rows($resourceid);
    }

    public function free_result($query) {
        return $this->db->free_result($query);
    }

    public function error() {
        return $this->db->error();
    }

    public function errno() {
        return $this->db->errno();
    }

    //对值进行转义加引号
    public function quote($str, $noarray = false) {
        if (is_string($str))
            return '\'' . $this->db->escape($str) . '\'';

        if (is_int($str) or is_float($str))
            return '\'' . $str . '\'';

        if (is_array($str)) {
            if($noarray === false) {
                foreach ($str as &$v) {
                    $v = $this->quote($v, true);
                }
                return $str;
            } else {
                return '\'\'';
            }
        }

        if (is_bool($str))
            return $str ? '1' : '0';

        return '\'\'';
    }
    //对字段加引号
    public function quote_field($field) {
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                $field[$k] = $this->quote_field($v);
            }
        } else {
            if (strpos($field, '`') !== false)
                $field = str_replace('`', '', $field);
            $field = '`' . $field . '`';
        }
        return $field;
    }

    public function limit($start, $limit = 0) {
        $limit = intval($limit > 0 ? $limit : 0);
        $start = intval($start > 0 ? $start : 0);
        if ($start > 0 && $limit > 0) {
            return " LIMIT $start, $limit";
        } elseif ($limit) {
            return " LIMIT $limit";
        } elseif ($start) {
            return " LIMIT $start";
        } else {
            return '';
        }
    }

    public function order($field, $order = 'ASC') {
        if(empty($field)) {
            return '';
        }
        $order = strtoupper($order) == 'ASC' || empty($order) ? 'ASC' : 'DESC';
        return $this->quote_field($field) . ' ' . $order;
    }
    //对单个字段进行拼合
    public function field($field, $val, $glue = '=') {

        $field = $this->quote_field($field);

        if (is_array($val)) {
            $glue = $glue == 'notin' ? 'notin' : 'in';
        } elseif ($glue == 'in') {
            $glue = '=';
        }

        switch ($glue) {
            case '=':
                return $field . $glue . $this->quote($val);
                break;
            case '-':
            case '+':
                return $field . '=' . $field . $glue . $this->quote((string) $val);
                break;
            case '|':
            case '&':
            case '^':
                return $field . '=' . $field . $glue . $this->quote($val);
                break;
            case '>':
            case '<':
            case '<>':
            case '<=':
            case '>=':
                return $field . $glue . $this->quote($val);
                break;

            case 'like':
                return $field . ' LIKE(' . $this->quote($val) . ')';
                break;

            case 'in':
            case 'notin':
                $val = $val ? implode(',', $this->quote($val)) : '\'\'';
                return $field . ($glue == 'notin' ? ' NOT' : '') . ' IN(' . $val . ')';
                break;

            default:
                $this->halt("not allow this glue between field and value: {$glue}");
        }
    }

    public function implode($array, $glue = ',') {
        $sql = $comma = '';
        $glue = ' ' . trim($glue) . ' ';
        foreach ($array as $k => $v) {
            $sql .= $comma . $this->quote_field($k) . '=' . $this->quote($v);
            $comma = $glue;
        }
        return $sql;
    }

    public function implode_field_value($array, $glue = ',') {
        return $this->implode($array, $glue);
    }

    public function format($sql, $arg) {
        $count = substr_count($sql, '%');
        if (!$count) {
            return $sql;
        } elseif ($count > count($arg)) {
            $this->halt("sql string format error! this sql need {$count} vars to replace into.", 0, $sql);
        }

        $len = strlen($sql);
        $i = $find = 0;
        $ret = '';
        while ($i <= $len && $find < $count) {
            if ($sql{$i} == '%') {
                $next = $sql{$i + 1};
                if ($next == 't') {
                    $ret .= $this->table($arg[$find]);
                } elseif ($next == 's') {
                    $ret .= $this->quote(is_array($arg[$find]) ? serialize($arg[$find]) : (string) $arg[$find]);
                } elseif ($next == 'f') {
                    $ret .= sprintf('%F', $arg[$find]);
                } elseif ($next == 'd') {
                    $ret .= intval($arg[$find]);
                } elseif ($next == 'i') {
                    $ret .= $arg[$find];
                } elseif ($next == 'n') {
                    if (!empty($arg[$find])) {
                        $ret .= is_array($arg[$find]) ? implode(',', $this->quote($arg[$find])) : $this->quote($arg[$find]);
                    } else {
                        $ret .= '0';
                    }
                } else {
                    $ret .= $this->quote($arg[$find]);
                }
                $i++;
                $find++;
            } else {
                $ret .= $sql{$i};
            }
            $i++;
        }
        if ($i < $len) {
            $ret .= substr($sql, $i);
        }
        return $ret;
    }

    public function halt($message = '', $code = 0, $sql = '') {
        $this->db->halt($message, $code, $sql);
    }
}
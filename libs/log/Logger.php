<?php


class Libs_Log_Logger {

    const TRANSFER_ERROR    = 'LOG转换失败，非LOG信息';
    const LOG_FILENAME      = 'output.log';

    /**
     * 本函数用于取代系统的error_log错误日志记录函数
     * @param string|array|object|bool|int $log 需要记录的错误信息，可以是格式良好的任意类型
     * @param string $filename 保存日志信息的文件名，默认存储路径为sites/app/storage/log/output.log
     * @param bool $append 是否以追加的形式添加日志信息，默认追加
     */
    public static function outputLog($log, $filename = self::LOG_FILENAME, $append = true) {
        if (!plum_setmod_dir(PLUM_APP_LOG)) {
            return;
        }
        $filename = PLUM_APP_LOG . '/' . $filename;
        $mode = $append ? 'a' : 'w';
        if (!($handler = @fopen($filename, $mode))) {
            //文件流打开失败时触发错误，并退出
            trigger_error('LOG日志文件打开失败', E_USER_WARNING);
            return;
        }
        //获取调用跟踪
        $trace  = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $debug  = self::log_format(array('file' => $trace[0]['file'], 'line' => $trace[0]['line']));

        $info = self::log_format($log);
        //开始写入
        if (($write_byte = fwrite($handler, $debug.$info)) === false) {
            $error_msg = 'LOG日志写入失败';
            //检查磁盘空间
            $free_space = disk_free_space(PLUM_APP_LOG);
            //磁盘空间不足
            if ($free_space && $write_byte > $free_space) {
                $error_msg .= '磁盘空间不足';
            }
            //写入失败时，触发错误并退出
            trigger_error($error_msg, E_USER_WARNING);
            fclose($handler);
            return;
        }
        //关闭文件流
        fclose($handler);
    }

    /**
     * 输出信息到控制台
     */
    public static function outputConsoleLog($log) {
        //非控制台调用直接退出
        if (php_sapi_name() != 'cli') {
            //die('请在控制台下执行脚本');
            return;
        }
        $info = self::log_format($log);
        fwrite(STDOUT, $info);
    }

    /**
     * 返回格式化的LOG日志信息
     * @param $log
     * @return string
     */
    private static function log_format($log) {
        $log_type = 'Unknown';
        if (is_array($log)) {
            //数组进行json序列化
            $log_type   = 'Array';
            $loginfo    = self::json_encode_helper($log);
        } else if (is_object($log)) {
            $log_type   = 'Object';
            $loginfo    = self::json_encode_helper($log);
        } else if (is_string($log)) {
            $log_type   = 'String';
            $loginfo    = $log;
        } else if (is_bool($log)) {
            $log_type   = 'Bool';
            $loginfo    = $log ? 'true' : 'false';
        } else if (is_numeric($log)) {
            $log_type   = 'Number';
            $loginfo    = strval($log);
        } else if (is_null($log)) {
            $log_type   = 'Null';
            $loginfo    = 'null';
        } else {
            $loginfo = strval($log);
        }
        //再一次判断，排查转换出错的情况
        if (!is_string($loginfo)) {
            $errno  = json_last_error();
            switch ($errno) {
                default :
                    $loginfo = self::TRANSFER_ERROR.";错误号：{$errno};错误信息：".json_last_error_msg();
                    break;
            }

        }
        //添加换行符
        $loginfo .= "\n";

        $format = "[".date('Y/m/d H:i:s', time())."] $log_type: $loginfo";

        return $format;
    }
    /*
     * utf8格式转换
     */
    private static function utf8ize( $mixed ) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = self::utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            //$mixed = mb_convert_encoding($mixed, "UTF-8", "UTF-8");
            $mixed  = utf8_encode($mixed);
        } elseif (is_object($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed->$key = self::utf8ize($value);
            }
        }
        return $mixed;
    }

    private static function json_encode_helper($var) {
        switch (gettype($var)) {
            case 'boolean':
                return $var ? 'true' : 'false'; // Lowercase necessary!

            case 'integer':
            case 'double':
                return $var;

            case 'resource':
            case 'string':
                // Always use Unicode escape sequences (\u0022) over JSON escape
                // sequences (\") to prevent browsers interpreting these as
                // special characters.
                $replace_pairs = array(
                    // ", \ and U+0000 - U+001F must be escaped according to RFC 4627.
                    '\\' => '\u005C',
                    '"' => '\u0022',
                    "\x00" => '\u0000',
                    "\x01" => '\u0001',
                    "\x02" => '\u0002',
                    "\x03" => '\u0003',
                    "\x04" => '\u0004',
                    "\x05" => '\u0005',
                    "\x06" => '\u0006',
                    "\x07" => '\u0007',
                    "\x08" => '\u0008',
                    "\x09" => '\u0009',
                    "\x0a" => '\u000A',
                    "\x0b" => '\u000B',
                    "\x0c" => '\u000C',
                    "\x0d" => '\u000D',
                    "\x0e" => '\u000E',
                    "\x0f" => '\u000F',
                    "\x10" => '\u0010',
                    "\x11" => '\u0011',
                    "\x12" => '\u0012',
                    "\x13" => '\u0013',
                    "\x14" => '\u0014',
                    "\x15" => '\u0015',
                    "\x16" => '\u0016',
                    "\x17" => '\u0017',
                    "\x18" => '\u0018',
                    "\x19" => '\u0019',
                    "\x1a" => '\u001A',
                    "\x1b" => '\u001B',
                    "\x1c" => '\u001C',
                    "\x1d" => '\u001D',
                    "\x1e" => '\u001E',
                    "\x1f" => '\u001F',
                    // Prevent browsers from interpreting these as as special.
                    "'" => '\u0027',
                    '<' => '\u003C',
                    '>' => '\u003E',
                    '&' => '\u0026',
                    // Prevent browsers from interpreting the solidus as special and
                    // non-compliant JSON parsers from interpreting // as a comment.
                    //'/' => '\u002F',
                    // While these are allowed unescaped according to ECMA-262, section
                    // 15.12.2, they cause problems in some JSON parsers.
                    "\xe2\x80\xa8" => '\u2028', // U+2028, Line Separator.
                    "\xe2\x80\xa9" => '\u2029', // U+2029, Paragraph Separator.
                );

                return '"' . strtr($var, $replace_pairs) . '"';

            case 'array':
                // Arrays in JSON can't be associative. If the array is empty or if it
                // has sequential whole number keys starting with 0, it's not associative
                // so we can go ahead and convert it as an array.
                if (empty($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
                    $output = array();
                    foreach ($var as $v) {
                        $output[] = self::json_encode_helper($v);
                    }
                    return '[ ' . implode(', ', $output) . ' ]';
                }
            // Otherwise, fall through to convert the array as an object.

            case 'object':
                $output = array();
                foreach ($var as $k => $v) {
                    $output[] = self::json_encode_helper(strval($k)) . ':' . self::json_encode_helper($v);
                }
                return '{' . implode(', ', $output) . '}';

            default:
                return 'null';
        }
    }
}
<?php

class Libs_Session_FileHandler {
    private $sess_prefix        = 'sess_';
    private $save_path;
    private $sess_name;

    public function __construct($save_path = null, $sess_name = null) {
        $this->_init_session();
        $this->save_path    = $save_path ? $save_path : ini_get('session.save_path');
        $this->sess_name    = $sess_name ? $sess_name : ini_get('session.name');
    }

    private function _init_session() {
        session_set_save_handler(
            array(&$this, "open"),
            array(&$this, "close"),
            array(&$this, "read"),
            array(&$this, "write"),
            array(&$this, "destroy"),
            array(&$this, "gc")
        );
        register_shutdown_function('session_write_close');
    }

    public function run() {
        $session_data = isset($_SESSION) ? $_SESSION : NULL;
        session_start();
        // Restore session data.
        if (!empty($session_data)) {
            $_SESSION += $session_data;
        }
    }

    public function open($save_path, $session_name) {
        //目录是否存在判断
        if (!is_dir($save_path)) {
            if (!mkdir($save_path, 0775, true)) {
                trigger_error("session save path:{$save_path} make failed!", E_USER_ERROR);
                return false;
            }
        }
        //目录是否可写判断
        if (!is_writable($save_path)) {
            if (!chmod($save_path, 0775)) {
                trigger_error("session save path:{$save_path} cannot writable!", E_USER_ERROR);
                return false;
            }
        }
        return true;
    }

    public function close() {
        return true;
    }

    public function read($session_id) {
        $sess_file_path = $this->_fetch_session_path($session_id);
        if (file_exists($sess_file_path)) {
            if (($val = @file_get_contents($sess_file_path))) {
                return $val;
            }
        }
        return '';//数据不正确或不存在，返回空串
    }

    public function write($session_id, $session_val) {
        $sess_file_path = $this->_fetch_session_path($session_id);
        //session不为空时,为空时不写入
        if ($session_val) {
            @file_put_contents($sess_file_path, $session_val);
        }
        return true;
    }

    public function destroy($session_id) {
        $sess_file_path = $this->_fetch_session_path($session_id);

        @unlink($sess_file_path);
        $this->_session_delete_cookie($this->sess_name);
        return true;
    }

    /*
     * 清空session目录下失效的session文件
     * 只对失效文件(超出时限)做处理
     */
    public function gc($maxlifetime) {
        global $gc_open;
        if ($gc_open) {
            $this->_garbage_collection($this->save_path, $maxlifetime);
        }
        return true;
    }
    /*
     * 垃圾回收,递归处理
     */
    private function _garbage_collection($dir_path, $maxlifetime) {
        //$use_cookie     = ini_get('session.use_cookies');
        $dir_handler    = opendir($dir_path);
        if ($dir_handler) {
            while (($file = readdir($dir_handler)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $file_path  = $dir_path . '/' . $file;
                if (is_dir($file_path)) {
                    $this->_garbage_collection($file_path, $maxlifetime);
                } else {
                    //使用cookie时，删除失效文件(使用文件的修改时间)
                    if (filemtime($file_path) + $maxlifetime < time()) {
                        @unlink($file_path);
                    }
                }
            }
            closedir($dir_handler);
        }
    }

    /*
     * 获取session ID对应的文件路径
     */
    private function _fetch_session_path ($session_id) {
        $dir_prefix = substr($session_id, 0, 2);//获取session_id前两位作为目录前缀
        $dir_path   = $this->save_path . '/' . $dir_prefix;
        //判断目录是否存在
        if (!is_dir($dir_path)) {
            if (!mkdir($dir_path, 0775, true)) {
                trigger_error("session save path:{$dir_path} make failed!", E_USER_ERROR);
                return false;
            }
        }
        $sess_file_name = $this->sess_prefix . $session_id;
        return $dir_path . '/' . $sess_file_name;
    }

    /*
     * 如果有对应的COOKIE，则删除
     */
    private function _session_delete_cookie($name, $secure = NULL) {
        if (isset($_COOKIE[$name])) {
            $params = session_get_cookie_params();
            if ($secure !== NULL) {
                $params['secure'] = $secure;
            }
            $request_time = (int) $_SERVER['REQUEST_TIME'];
            setcookie($name, '', $request_time - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
            unset($_COOKIE[$name]);
        }
    }
}

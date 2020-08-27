<?php
/**
 * User: thomas<thomas@ikinvin.com>
 * Date: 14-4-2
 * Time: 下午10:10
 */

class Libs_Session_SessionHandler {

    private $redis = null;
    private $session_name = "sess";
    private $user_life_time = 864000; //10*24*60*60 十天
    private $visitor_life_time = 3600; //60*60  一小时

    public function __construct() {
        $this->redis = new Redis();
        $redis_cfg    = plum_parse_config('session', 'redis');
        if (!$this->redis->connect($redis_cfg['host'], $redis_cfg['port'], $redis_cfg['timeout'])) {
            trigger_error("redis connect failure", E_USER_ERROR);
            return null;
        }
        if($redis_cfg['password']){
            $this->redis->auth($redis_cfg['password']);
        }
        $this->session_name    = ini_get('session.name');
        $this->_init_session();
    }

    private function _init_session() {
        session_name($this->session_name);
        //session_module_name("redis");
        session_set_save_handler(
            array(&$this, "open"),
            array(&$this, "close"),
            array(&$this, "read"),
            array(&$this, "write"),
            array(&$this, "destroy"),
            array(&$this, "gc")
        );
    }

    public function run() {
        $session_data = isset($_SESSION) ? $_SESSION : NULL;
        session_start();
        // Restore session data.
        if (!empty($session_data)) {
            $_SESSION += $session_data;
        }

        //初始化APP_USER的ID

        $uid        = isset($_SESSION['uid']) && $_SESSION['uid'] ? intval($_SESSION['uid']) : 0 ;
        $life_time  = $uid ? $this->user_life_time : $this->visitor_life_time;
        $params     = session_get_cookie_params();
        $request_time = (int) $_SERVER['REQUEST_TIME'];
        setcookie($this->session_name, session_id(), $request_time + $life_time, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    public function open() {
        if ($this->redis instanceof Redis && $this->_ping(10)) {
            return true;
        } else {
            trigger_error("session redis connect failed", E_USER_ERROR);
        }
    }

    public function close() {
        $this->redis->close();
        return true;
    }

    public function read($session_id) {
        $key = $this->session_name.":".$session_id;
        if (!$this->redis->exists($key)) {
            return false;
        }

        return $this->redis->get($key);
    }

    public function write($session_id, $session_val) {
        global $APP_USER;
        if ($session_val) {
            $life_time = $APP_USER ? $this->user_life_time : $this->visitor_life_time;
            $key = $this->session_name.":".$session_id;
            $this->redis->setex($key, $life_time, $session_val);
        }
        return true;
    }

    public function destroy($session_id) {
        $key = $this->session_name.":".$session_id;

        $this->redis->del($key);
        $this->_session_delete_cookie($this->session_name);
        return true;
    }

    public function gc() {
        return true;
    }

    private function _ping($ttl = 10) {
        set_time_limit($ttl);
        try {
            if ('+PONG' == $this->redis->ping()) {
                return true;
            }
            return false;
        } catch (RedisException $re) {
            trigger_error("session redis connect failed", E_USER_ERROR);
        }
    }

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
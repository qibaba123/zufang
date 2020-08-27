<?php

class Libs_Redis_RedisClient {
    
    public $redis = null;

    public function __construct($type = null) {
        $type   = $type ? $type : 'connect';
        $redis_cfg = plum_parse_config($type, 'redis');

        $this->redis = new Redis();
        if (!$this->redis->connect($redis_cfg['host'], $redis_cfg['port'], $redis_cfg['timeout'])) {
            trigger_error("redis connect failure", E_USER_ERROR);
            return null;
        }
        if (isset($redis_cfg['password']) && $redis_cfg['password']) {
            $this->redis->auth($redis_cfg['password']);
        }
    }

    public function getRedis() {
        return $this->redis;
    }

    //析构函数，释放redis
    public function __destruct() {
        $this->redis->close();
    }
}

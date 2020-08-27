<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-04-21
 */

class Libs_Framework_Model_Xhprof_RedisXhprofStorage {
    private $redis;

    protected $log_struct = array(
        'server',//$_SERVER
        'data',//xhprof收集的数据
        'time',//请求的时间
    );

    public function __construct() {
        $this->redis = (new Libs_Redis_RedisClient('xhprof'))->getRedis();
    }

    /**
     * 添加xhprof收集数据
     */
    public function addXhprofLog($source, $log) {
        return $this->redis->zAdd('xhprof_ikinvin_'.$source, time(), json_encode($log));
    }
}
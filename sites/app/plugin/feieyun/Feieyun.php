<?php

/**
 * Class App_Plugin_Feieyun_Feieyun
 * 飞鹅打印机相关接口
 */
// require_once __DIR__ . '/FeieyunPlugin.php';
class App_Plugin_Feieyun_Feieyun{

    const IP = 'api.feieyun.cn';  // 接口IP或域名
    const PORT = 80;     // 接口IP端口
    const PATH = '/Api/Open/';   // 接口路径
    public $stime;
    public $user;
    public $ukey;
    public $feieCfg;
    public function __construct(){
//        $feie_model = new App_Model_Feie_MysqlFeieCfgStorage($sid);
//        $feieCfg = $feie_model->findRowCfgBySid();
        $feieCfg = plum_parse_config('feie');
        $this->user = $feieCfg['user'];
        $this->ukey = $feieCfg['ukey'];
        $this->feieCfg = $feieCfg;
        $this->stime = time();
    }


    /**
     * @param 添加打印机
     */
    function addprinter($printerContent){
        // 获取公共参数
        $apiname = 'Open_printerAddlist';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['printerContent'] = $printerContent;
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret =  $client_storage->getContent();
            return json_decode($ret,true);
        }

    }

    /*
     * 打印订单
     * $sn 打印机编号
     * $content : 打印内容
     */
    public function printOrder($sn,$content,$times=1){
        // 公共参数
        $apiname = 'Open_printMsg';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['sn'] = $sn;
        $params['content'] = $content;
        $params['times'] = $times;
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret = $client_storage->getContent();
            return json_decode($ret,true);
        }
    }

    /*
     * 删除打印机
     */
    public function deletePrinter($sn){
        // 公共参数
        $apiname = 'Open_printerDelList';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['snlist'] = $sn;
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret = $client_storage->getContent();
            return json_decode($ret,true);
        }
    }

    /*
     * 修改打印机信息
     */
    public function updatePrinter($sn,$name='',$phonenum=''){
        // 公共参数
        $apiname = 'Open_printerEdit';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['sn'] = $sn;
        if($name){
            $params['name'] = $name;
        }
        if($phonenum){
            $params['phonenum'] = $phonenum;
        }
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret =  $client_storage->getContent();
            return json_decode($ret,true);
        }
    }

    /*
     * 清空待打印订单
     * $sn 打印机编号
     */
    public function deletePrinterOrder($sn){
        // 公共参数
        $apiname = 'Open_delPrinterSqs';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['sn'] = $sn;
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret =  $client_storage->getContent();
            return json_decode($ret,true);
        }
    }
    /*
     * 查询打印机状态
     * $sn 打印机编号
     */
    public function queryPrinterStatus($sn){
        // 公共参数
        $apiname = 'Open_queryPrinterStatus';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['sn'] = $sn;
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret = $client_storage->getContent();
            return json_decode($ret,true);
        }
    }

    /*
     * 查询待打印数量
     */
    public function queryOrderInfoByDate($sn,$date){
        // 公共参数
        $apiname = 'Open_queryOrderInfoByDate';
        $params = self::fetchPublicParams($apiname);
        // 私有参数
        $params['sn'] = $sn;
        $params['date'] = $date ? $date : date('Y-m-d',time());
        $client_storage = new App_Plugin_Feieyun_FeieyunPlugin(self::IP,self::PORT);
        if(!$client_storage->post(self::PATH,$params)){
            return false;
        } else{
            $ret = $client_storage->getContent();
            return json_decode($ret,true);
        }
    }

    /*
     * 获取公共参数
     */
    public function fetchPublicParams($apiName){
        $params = array(
            'user'     =>$this->user,
            'stime'    =>$this->stime,
            'sig'      =>self::makeFeieYunSign($this->user,$this->ukey,$this->stime),
            'apiname'  =>$apiName,
        );
        return $params;
    }

    /*
     * 生成签名
     */
    public static function makeFeieYunSign($user,$ukey,$time) {
        $result = sha1($user.$ukey.$time);
        return $result;
    }
}
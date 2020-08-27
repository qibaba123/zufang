<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/10/25
 * Time: 下午8:17
 */
class App_Plugin_Food_AnubisEle {

    //const QUERY_PREFIX  = 'https://exam-anubis.ele.me/anubis-webapi';
    const QUERY_PREFIX  = 'https://open-anubis.ele.me/anubis-webapi';

    const MAP_SOURCE_TENCENT    = 1;
    const MAP_SOURCE_BAIDU      = 2;
    const MAP_SOURCE_GAODE      = 3;

    public $ele_cfg;

    public $result;

    private $access_token;

    private $curr_salt;

    public function __construct() {
        $cfg  = plum_parse_config('ele', 'app');
        $this->ele_cfg  = $cfg;
        $this->result   = array(
            'errcode'   => -1,
            'errmsg'    => 'bad request',
        );
        $this->_fetch_access_token();
    }

    private function _fetch_access_token() {
        $ele_storage    = new App_Model_Auth_RedisWeixinPlatformStorage();
        $token      = $ele_storage->getAnubisEleAccessToken();
        if ($token) {
            $this->access_token = $token;
        } else {
            $salt   = rand(1000, 9999);
            $params = array(
                'app_id'    => $this->ele_cfg['AppID'],
                'salt'      => $salt,
                'secret_key'=> $this->ele_cfg['SecretKey'],
            );
            $params = http_build_query($params);
            $params = rawurlencode($params);

            $signature  = strtolower(md5($params));

            $query_uri  = self::QUERY_PREFIX.'/get_access_token';
            $params = array('app_id' => $this->ele_cfg['AppID'], 'salt' => $salt, 'signature' => $signature);
            $ret    = Libs_Http_Client::get($query_uri, $params);

            $ret    = json_decode($ret, true);

            if ($ret['code'] == 200) {
                $this->access_token = $ret['data']['access_token'];
                //保存access token
                $ttl    = floor($ret['data']['expire_time']/1000)-time();
                $ele_storage->setAnubisEleAccessToken($this->access_token, $ttl);
            } else {
                Libs_Log_Logger::outputLog($this->ele_cfg);
                Libs_Log_Logger::outputLog($ret);
                $this->access_token = null;
            }
        }
    }

    public function getAccessToken(){
        return $this->access_token;
    }

    /**
     * 添加门店信息
     * @param string $storeCode   门店编号
     * @param string $name        门店名称
     * @param string $phone       门店电话
     * @param string $address     门店地址
     * @param float  $lng         经纬度
     * @param float  $lat         经纬度
     * @param int    $map         坐标属性（1:腾讯地图, 2:百度地图, 3:高德地图）
     * @param int    $serviceCode 配送服务(1:蜂鸟配送, 2:蜂鸟优送, 3:蜂鸟快送)
     * @return array
     */
    public function addChainStore($storeCode, $name, $phone, $address, $lng, $lat, $map=3, $serviceCode=1) {
        if (!$this->access_token) {
            return $this->result;
        }
        $name   = mb_strlen($name)>32 ? mb_substr($name,0,32) : $name;
        $address= mb_strlen($address)>64 ? mb_substr($address, 0, 64) : $address;

        $data   = array(
            'chain_store_code'  => $storeCode,
            "chain_store_name"  => $name,
            "contact_phone"     => $phone,
            "address"           => $address,
            "position_source"   => $map,//（1:腾讯地图, 2:百度地图, 3:高德地图）
            "longitude"         => $lng,
            "latitude"          => $lat,
            "service_code"      => $serviceCode,//配送服务(1:蜂鸟配送, 2:蜂鸟优送, 3:蜂鸟快送)
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/chain_store';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        Libs_Log_Logger::outputLog(json_encode($params));
        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 更新门店信息
     * @param string $storeCode   门店编号
     * @param string $name        门店名称
     * @param string $phone       门店电话
     * @param string $address     门店地址
     * @param float  $lng         经纬度
     * @param float  $lat         经纬度
     * @param int    $map         坐标属性（1:腾讯地图, 2:百度地图, 3:高德地图）
     * @param int    $serviceCode 配送服务(1:蜂鸟配送, 2:蜂鸟优送, 3:蜂鸟快送)
     * @return array
     */
    public function updateChainStore($storeCode, $name, $phone, $address, $lng, $lat, $map=3, $serviceCode=1) {
        if (!$this->access_token) {
            return $this->result;
        }
        $name   = mb_strlen($name)>32 ? mb_substr($name,0,32) : $name;
        $address= mb_strlen($address)>64 ? mb_substr($address, 0, 64) : $address;

        $data   = array(
            'chain_store_code'  => $storeCode,
            "chain_store_name"  => $name,
            "contact_phone"     => $phone,
            "address"           => $address,
            "position_source"   => $map,//（1:腾讯地图, 2:百度地图, 3:高德地图）
            "longitude"         => $lng,
            "latitude"          => $lat,
            "service_code"      => $serviceCode,//配送服务(1:蜂鸟配送, 2:蜂鸟优送, 3:蜂鸟快送)
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/chain_store/update';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        Libs_Log_Logger::outputLog(json_encode($params));
        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 查询配送服务
     * @param string $storeCode 门店编号
     * @param string $longitude 经纬度
     * @param string $latitude  经纬度
     * @param int    $map       坐标属性（1:腾讯地图, 2:百度地图, 3:高德地图）
     * @return array
     */
    public function queryDelivery($storeCode, $longitude, $latitude, $map=0){
        if (!$this->access_token) {
            return $this->result;
        }

        $data   = array(
            "chain_store_code"   => $storeCode,
            'position_source'    => $map,  //（0:未知, 1:腾讯地图, 2:百度地图, 3:高德地图）
            'receiver_longitude' => $longitude,
            'receiver_latitude'  => $latitude
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/chain_store/delivery/query';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errcode'] = $ret['code'];
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 查询门店信息
     * @param string | array $code  门店编码
     * @return array
     */
    public function queryChainStore($code) {
        if (!$this->access_token) {
            return $this->result;
        }

        if(is_array($code)){
            $data   = array(
                "chain_store_code"  => $code
            );
        }else{
            $data   = array(
                "chain_store_code"  => array($code)
            );
        }
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/chain_store/query';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 推送配送订单
     * @link https://open.ele.me/documents?to=%2Fdocument%2Fpage%2FtimelyDelivery
     * @param string $tid
     * @param string $storeCode
     * @param string $notify_url
     * @param array $order [total,actual,hadpay,agent,count]
     * @param array $store [name,address,lng,lat,phone,map]
     * @param array $receiver [name,phone,address,lng,lat,map]
     * @param array $item [item_id,item_name,item_quantity,item_price,item_actual_price,item_size,item_remark,is_need_package,is_agent_purchase,agent_purchase_price]
     * [商品编号, 商品名称, 商品数量, 商品原价, 商品实际支付金额, 商品尺寸, 商品备注, 是否需要ele打包 0:否 1:是, 是否代购 0:否, 代购进价, 如果需要代购 此项必填]
     * @return array
     */
    public function sendServiceOrder($tid, $storeCode, $notify_url,array $order,array $store,array $receiver,array $item, $other = null) {
        if (!$this->access_token) {
            return $this->result;
        }

        $data   = array(
            //"partner_remark"    => '',//"商户备注信息", 选填
            "partner_order_code"=> strval($tid),//商户订单号
            'notify_url'        => $notify_url,//回调地址,订单状态变更时会调用此接口传递状态信息
            'order_type'        => 1,//订单类型 1: 蜂鸟配送，支持90分钟内送达
            'chain_store_code'  => $storeCode, //门店编号
            'transport_info'    => array(
                'transport_name'    => $store['name'],
                'transport_address' => $store['address'],
                'transport_longitude'   => $store['lng'],
                'transport_latitude'    => $store['lat'],
                'position_source'       => $store['map'],//取货点经纬度来源, 1:腾讯地图, 2:百度地图, 3:高德地图
                'transport_tel'         => $store['phone'],
                //'transport_remark'      => '',//取货点备注,选填
            ),
            //'order_add_time'    => 0,//下单时间(毫秒),选填
            'order_total_amount'    => $order['total'],//订单总金额（不包含商家的任何活动以及折扣的金额）
            'order_actual_amount'   => $order['actual'],//客户需要支付的金额
            //'order_weight'      =>  $order['weight'],//订单总重量（kg），营业类型选定为果蔬生鲜、商店超市、其他三类时必填，大于0kg并且小于等于6kg,选填
            //'order_remark'      => '',//用户备注,选填
            'is_invoiced'       => 0,//是否需要发票, 0:不需要, 1:需要
            //'invoice'           => '',//发票抬头, 如果需要发票, 此项必填,选填
            'order_payment_status'  => $order['hadpay'],//订单支付状态 0:未支付 1:已支付
            'order_payment_method'  => 1,//订单支付方式 1:在线支付
            'is_agent_payment'      => $order['agent'],//是否需要ele代收 0:否
            //'require_payment_pay'   => 0,//需要代收时客户应付金额, 如果需要ele代收 此项必填,选填
            'goods_count'           => $order['count'],//订单货物件数
            //'require_receive_time'  => 0,//需要送达时间（毫秒),选填
            //'serial_number'         => '',//商家订单流水号, 方便配送骑手到店取货, 支持数字,字母及#等常见字符. 如不填写, 蜂鸟将截取商家订单号后4位作为流水号.选填
            'receiver_info'     => array(
                'receiver_name'         => $receiver['name'],
                'receiver_primary_phone'=> $receiver['phone'],
                //'receiver_second_phone'     => '',//收货人备用联系方式,选填
                'receiver_address'      => $receiver['address'],
                'receiver_longitude'    => $receiver['lng'],
                'receiver_latitude'     => $receiver['lat'],
                'position_source'       => $receiver['map'],//收货人经纬度来源, 1:腾讯地图, 2:百度地图, 3:高德地图
            ),
            'items_json'        => $item,
        );
        if($order['receiveTime']){
            $data['require_receive_time'] = $order['receiveTime'];
        }
        if ($other) {
            $data   = array_merge_recursive($data, $other);
        }

        Libs_Log_Logger::outputLog($data);

        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/order';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 查询配送订单状态
     * @param $tid
     * @return array
     */
    public function queryServiceOrder($tid) {
        if (!$this->access_token) {
            return $this->result;
        }

        $data   = array(
            "partner_order_code"  => strval($tid),
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/order/query';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 查询骑手位置
     * @param $tid
     * @return array
     */
    public function fetchCarrierLocation($tid) {
        if (!$this->access_token) {
            return $this->result;
        }

        $data   = array(
            "partner_order_code"  => strval($tid),
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/order/carrier';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 投诉配送订单 目前，商户只能针对订单状态进入终态（即状态为3，4，5）并且满足96小时之内并且获取到调度或配送员信息（即状态为1）的订单发起投诉操作。
     * @param $tid
     * @param integer $code 订单投诉编码（230:其他, 150:未保持餐品完整, 160:服务态度恶劣, 190:额外索取费用, 170:诱导收货人或商户退单, 140:提前点击送达, 210:虚假标记异常, 220:少餐错餐, 200:虚假配送, 130:未进行配送）
     * @param string $desc
     * @return array
     */
    public function complaintSendOrder($tid, $code, $desc = '') {
        if (!$this->access_token) {
            return $this->result;
        }

        $time   = time()*1000;//转换为毫秒
        $data   = array(
            "partner_order_code"  => strval($tid),
            'order_complaint_code'=> $code,
            'order_complaint_desc'=> $desc,
            'order_complaint_time'=> $time,
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/order/complaint';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /**
     * 取消配送订单
     * @param string $tid
     * @param integer $code 订单取消编码（0:其他, 1:联系不上商户, 2:商品已经售完, 3:用户申请取消, 4:运力告知不配送 让取消订单, 5:订单长时间未分配, 6:接单后骑手未取件）
     * @param string $desc
     * @return array
     */
    public function cancelSendOrder($tid, $code, $desc = '') {
        if (!$this->access_token) {
            return $this->result;
        }

        $time   = time()*1000;//转换为毫秒
        $data   = array(
            "partner_order_code"        => strval($tid),
            'order_cancel_reason_code'  => 2,//订单取消原因代码(2:商家取消)
            'order_cancel_code'         => $code,
            'order_cancel_description'  => $desc,
            'order_cancel_time'         => $time,
        );
        $data   = urlencode(json_encode($data));
        $this->curr_salt    = mt_rand(1000, 9999);
        $signature          = $this->_params_signature($data);
        $query_uri  = self::QUERY_PREFIX.'/v2/order/cancel';
        $params = array('app_id' => $this->ele_cfg['AppID'], 'data' => $data, 'salt' => $this->curr_salt, 'signature' => $signature);

        $ret    = self::doPost($query_uri, json_encode($params));
        $ret    = json_decode($ret, true);

        Libs_Log_Logger::outputLog($ret);
        if ($ret['code'] == 200) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }
    /*
     * 参数加签
     */
    private function _params_signature($data) {
        $params = "app_id={$this->ele_cfg['AppID']}&access_token={$this->access_token}&data={$data}&salt={$this->curr_salt}";

        $signature  = strtolower(md5($params));

        return $signature;
    }


    /**
     * POST请求
     * @param $url
     * @param $param
     * @return boolean|mixed
     */
    public static function doPost($url, $param, $method = "POST")
    {
        // echo 'Request url is ' . $url . PHP_EOL;
        if (empty($url) or empty($param)) {
            throw new InvalidArgumentException('Params is not of the expected type');
        }

        // 验证url合法性
//        if (!filter_var($url, FILTER_VALIDATE_URL)) {
//            throw new InvalidArgumentException('Url is not valid');
//        }

        if (!empty($param) and is_array($param)) {
            $param = urldecode(json_encode($param));
        } else {
            // $param = urldecode(strval($param));
            $param = strval($param);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     //  不进行ssl 认证

        if (strcmp($method, "POST") == 0) {  // POST 操作
            curl_setopt($ch, CURLOPT_POST, true);
        } else if (strcmp($method, "DELETE") == 0) { // DELETE操作
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        } else {
            throw new InvalidArgumentException('Please input correct http method, such as POST or DELETE');
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: Application/json'));
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!empty($result) and $code == '200') {
            return $result;
        }
        return false;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/8/17
 * Time: 下午2:39
 */

class App_Plugin_Aliyun_Apiset {

    public $aliyun_cfg;

    public $result;

    public static $express_status = array(
        0      => '在途中',
        1      => '已揽件',
        2      => '疑难件',
        3      => '已签收',
        4      => '已退签',
        5      => '派件中',
        6      => '退回',
    );

    public function __construct() {
        $cfg  = plum_parse_config('aliyun_api', 'alipay');
        $this->aliyun_cfg    = $cfg;
        $this->result   = array(
            'errcode'   => -1,
            'errmsg'    => 'bad request',
        );
    }
    /*
     * 获取IP解析数据
     */
    public function getIpData($ip) {
        $pattern = '/((?:(?:25[0-5]|2[0-4]\d|(?:1\d{2}|[1-9]?\d))\.){3}(?:25[0-5]|2[0-4]\d|(?:1\d{2}|[1-9]?\d)))/';
        if (preg_match($pattern, $ip) == 0) {
            $this->result['errmsg'] = '请输入正确的IP地址';
            return $this->result;
        }

        $query_uri  = 'http://ali.ip138.com/ip/';
        $params = array('ip' => $ip);
        $header = array("Authorization:APPCODE " . $this->aliyun_cfg['AppCode']);
        $ret    = Libs_Http_Client::get($query_uri, $params, $header);

        $ret    = json_decode($ret, true);

        if ($ret['ret'] == 'ok') {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['data'][0].$ret['data'][1].$ret['data'][2].$ret['data'][3],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }
    /*
     * 抽取新闻内容
     * https://market.aliyun.com/products/57126001/cmapi011144.html?spm=5176.2020520132.101.2.66b372185hcRT0#sku=yuncode514400003
     */
    public function extractNewsData($url) {
        $url    = rawurldecode($url);
        if (!plum_is_url($url)) {
            $this->result['errmsg'] = '请输入正确的URL地址';
            return $this->result;
        }
        $api_cfg = plum_parse_config('aliyun_new','alipay');
        $query_uri  = 'http://ali-extract.showapi.com/extract';
        $params = array('url' => $url);
        $header = array("Authorization:APPCODE " . $api_cfg['AppCode']);
        $ret    = Libs_Http_Client::get($query_uri, $params, $header);

        $ret    = json_decode($ret, true);

        if ($ret['showapi_res_code'] == 0) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['showapi_res_body'],
            );
        } else {
            $this->result['errmsg'] = $ret['showapi_res_error'];
        }
        return $this->result;
    }
    /*
     * 查询天气数据
     * @param string $city 城市中文名
     */
    public function queryWeatherData($city) {
        // $query_uri  = 'http://jisutqybmf.market.alicloudapi.com/weather/query';   免费接口（限制：每分钟30次）
        $query_uri  = 'https://jisutianqi.market.alicloudapi.com/weather/query';      //付费接口（无限制）
        $params = array('city' => $city);
        $header = array("Authorization:APPCODE " . $this->aliyun_cfg['AppCode']);
        $ret    = Libs_Http_Client::get($query_uri, $params, $header);
        //Libs_Log_Logger::outputLog($ret);
        $ret    = json_decode($ret, true);
        if (intval($ret['status']) == 0) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['result'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }
    /*
     * 查询快递信息
     * 文档地址
     * https://market.aliyun.com/products/56928004/cmapi021863.html?spm=5176.730005.0.0.LFWFaH#sku=yuncode1586300000
     */
    public function queryExpressData($num, $type = 'auto') {
        if (!$num) {
            $this->result['errmsg'] = '请输入正确的快递单号';
            return $this->result;
        }
        //$params = array('number' => $num, 'type' => $type);

        //$query_uri  = 'http://jisukdcx.market.alicloudapi.com/express/query';
        $query_uri  = 'https://wuliu.market.alicloudapi.com/kdi';
        $api_cfg = plum_parse_config('aliyun_express','alipay');
        $params = array('no' => $num);
        $header = array("Authorization:APPCODE " . $api_cfg['AppCode']);
        $ret    = Libs_Http_Client::get($query_uri, $params, $header);
        $ret    = json_decode($ret, true);
        if (intval($ret['status']) == 0) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['result'],
            );
        } else {
            $this->result['errmsg'] = $ret['msg'];
        }
        return $this->result;
    }

    /*
     * 查询天气数据
     * @param string $city 城市中文名
     * https://market.aliyun.com/products/56928004/cmapi014123.html?spm=5176.2020520132.101.5.22537218btN86f#sku=yuncode812300000
     */
    public function freeQueryWeatherData($city) {
        // $query_uri  = 'http(s)://saweather.market.alicloudapi.com/area-to-weather';   //免费接口
        $query_uri  = 'https://ali-weather.showapi.com/area-to-weather';      //付费接口
        $params = array(
            'area'        => $city,
            'needIndex'   => 1,
            'needMoreDay' => 1,
        );
        $api_cfg = plum_parse_config('aliyun_new','alipay');
        $header = array("Authorization:APPCODE " . $api_cfg['AppCode']);
        $ret    = Libs_Http_Client::get($query_uri, $params, $header);
        $ret    = json_decode($ret, true);
        if (intval($ret['showapi_res_code']) == 0) {
            $this->result   = array(
                'errcode'   => 0,
                'errmsg'    => 'ok',
                'result'    => $ret['showapi_res_body'],
            );
        } else {
            $this->result['errmsg'] = $ret['showapi_res_error'];
        }
        return $this->result;
    }

    /*
     * 查询汽车品牌
     * https://market.aliyun.com/products/56928004/cmapi028380.html?spm=5176.2020520132.101.5.32117218jTqwp8#sku=yuncode2238000000
     */
    public function fetchCarListData() {
        $query_uri  = 'https://autocars.market.alicloudapi.com/carNewList';      //付费接口
        $header = array("Authorization:APPCODE " . '23403f30714f443e81e65450433ac7d3');
        $ret    = Libs_Http_Client::post($query_uri, array(),array(), $header);
        $ret    = json_decode($ret, true);
        return $ret;
    }

    public function fetchCarDetailData($id) {
        $query_uri  = 'https://autocars.market.alicloudapi.com/carNewDetail';      //付费接口
        $header = array("Authorization:APPCODE " . '23403f30714f443e81e65450433ac7d3');
        $params = [
            'id' => $id
        ];

        $ret    = Libs_Http_Client::post($query_uri, $params,array(), $header);
        $ret    = json_decode($ret, true);
        return $ret;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/28
 * Time: 下午3:04
 */
class App_Helper_ExpressTrack {

    /*
     * 查询快递数据
     * $code 快递公司编码
     * $num 快递编号
     */
    public static function fetchJsonTrack($code, $num) {
        $cfg    = plum_parse_config('kdniao');

        $params = array(
            'OrderCode'     => '',
            'ShipperCode'   => $code,
            'LogisticCode'  => $num,
        );
        $request= json_encode($params);
        $datas  = array(
            'EBusinessID'   => $cfg['app_id'],
            'RequestType'   => '1002',
            'RequestData'   => urlencode($request) ,
            'DataType'      => '2',
        );
        $datas['DataSign']  = urlencode(base64_encode(md5($request.$cfg['app_key'])));
        $header = array("application/x-www-form-urlencoded;charset=utf-8");
        $ret    = Libs_Http_Client::post($cfg['app_url'], $datas, array(), $header);
        $ret    = json_decode($ret, true);
        return $ret;
    }
}
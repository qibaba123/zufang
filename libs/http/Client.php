<?php

class Libs_Http_Client {

    private static $boundary = '';

    public static function get($url, $params = array(), $headers = array(), $misc = array(), $cookie='') {
        if (!empty($params)) {
            $url = $url . '?' . http_build_query($params);
        }
        return self::http($url, 'GET', null, $headers, $misc, $cookie);
    }

    public static function post($url, $params, $files = array(), $headers = array(), $misc = array()) {
        if (!$files) {
            if (is_array($params) || is_object($params)) {
                $body = http_build_query($params);
            } else {
                $body = $params;
            }
        } else {
            $body = self::build_http_query_multi($params, $files);
            $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
        }
        return self::http($url, 'POST', $body, $headers, $misc);
    }

    public static function postFiles($url, $files, $params = array(), $headers = array(), $misc = array()) {
        if (!is_array($files)) {
            return false;
        }

        foreach ($files as $key => &$val) {
            $val = '@'.$val;
        }
        $body = array_merge($files, $params);
        $headers[] = "Content-Type: multipart/form-data";

        return self::http($url, 'POST', $body, $headers, $misc);
    }

    public static function getFiles($url, $files, $params = array(), $headers = array(), $misc = array()) {
        if (!is_array($files)) {
            return false;
        }

        foreach ($files as $key => &$val) {
            $val = '@'.$val;
        }
        $body = array_merge($files, $params);
        $headers[] = "Content-Type: multipart/form-data";

        return self::http($url, 'GET', $body, $headers, $misc);
    }


    /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */
    private static function http($url, $method, $postfields = NULL, $headers = array(), $misc = array(), $cookie='') {
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_USERAGENT, 'Tdot Plum Client v0.1');       //HTTP头部user agent
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);                       //连接超时时间，单位秒
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);                              //最大执行时间，单位秒
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);                     //避免直接输出返回值
        curl_setopt($ci, CURLOPT_ENCODING, "");                             //可接受编码类型，空串支持所有类型
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 2);
        //curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($ci, CURLOPT_HEADER, FALSE);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
        }

        foreach ($misc as $key => $val) {
            $key    = strtoupper($key);
            switch ($key) {
                case 'REFERER' :
                    curl_setopt($ci, CURLOPT_REFERER, $val);
                    break;
            }
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        if($cookie){
            curl_setopt ($ci, CURLOPT_COOKIE , $cookie );
        }
        curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE);

        $response = curl_exec($ci);
        $httpCode = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $httpInfo = curl_getinfo($ci);
        curl_close ($ci);
        return $response;
    }

    /**
     * 发送文件时使用
     * @param array $params
     * @param array $files
     * @return string
     */
    private static function build_http_query_multi($params, $files) {
        //if (!$params) return '';

        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--'.$boundary;
        $endMPboundary = $MPboundary. '--';
        $multipartbody = '';

        foreach ($params as $key => $value) {
            $multipartbody .= $MPboundary . "\r\n";
            $multipartbody .= 'content-disposition: form-data; name="' . $key . "\"\r\n\r\n";
            $multipartbody .= $value."\r\n";
        }
        foreach ($files as $key => $value) {
            if (!$value) {continue;}

            if (is_array($value)) {
                $url = $value['url'];
                if (isset($value['name'])) {
                    $filename = $value['name'];
                } else {
                    $parts = explode( '?', basename($value['url']));
                    $filename = $parts[0];
                }
                $field = isset($value['field']) ? $value['field'] : $key;
            } else {
                $url = $value;
                $parts = explode( '?', basename($url));
                $filename = $parts[0];
                $field = $key;
            }
            $content = file_get_contents($url);

            $multipartbody .= $MPboundary . "\r\n";
            $multipartbody .= 'Content-Disposition: form-data; name="' . $field . '"; filename="' . $filename . '"'. "\r\n";
            $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
            $multipartbody .= $content. "\r\n";
        }

        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }
}
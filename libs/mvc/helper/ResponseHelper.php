<?php

class Libs_Mvc_Helper_ResponseHelper {

    private static $_instance;

    private $_statusCode = 200;
    private $_charset = 'UTF-8';
    private $_contentType = 'text/html';
    private $_headers = array();

    private $_httpCode = array(
        100 => 'Continue',
        101	=> 'Switching Protocols',
        200	=> 'OK',
        201	=> 'Created',
        202	=> 'Accepted',
        203	=> 'Non-Authoritative Information',
        204	=> 'No Content',
        205	=> 'Reset Content',
        206	=> 'Partial Content',
        300	=> 'Multiple Choices',
        301	=> 'Moved Permanently',
        302	=> 'Found',
        303	=> 'See Other',
        304	=> 'Not Modified',
        305	=> 'Use Proxy',
        307	=> 'Temporary Redirect',
        400	=> 'Bad Request',
        401	=> 'Unauthorized',
        402	=> 'Payment Required',
        403	=> 'Forbidden',
        404	=> 'Not Found',
        405	=> 'Method Not Allowed',
        406	=> 'Not Acceptable',
        407	=> 'Proxy Authentication Required',
        408	=> 'Request Timeout',
        409	=> 'Conflict',
        410	=> 'Gone',
        411	=> 'Length Required',
        412	=> 'Precondition Failed',
        413	=> 'Request Entity Too Large',
        414	=> 'Request-URI Too Long',
        415	=> 'Unsupported Media Type',
        416	=> 'Requested Range Not Satisfiable',
        417	=> 'Expectation Failed',
        500	=> 'Internal Server Error',
        501	=> 'Not Implemented',
        502	=> 'Bad Gateway',
        503	=> 'Service Unavailable',
        504	=> 'Gateway Timeout',
        505	=> 'HTTP Version Not Supported'
    );

    private function __construct() {

    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __clone() {
        trigger_error("single instance RequestHelper can not be cloned.", E_USER_ERROR);
    }

    private function _respond() {
        // set status code
        header('HTTP/1.1 ' . $this->_statusCode . ' ' . $this->_httpCode[$this->_statusCode], true, $this->_statusCode);
        // set content type
        header('Content-Type: ' . $this->_contentType . '; charset=' . $this->_charset);
        // set header
        foreach ($this->_headers as $header) {
            header($header, true);
        }
    }

    /**
     * 返回响应的协议及主机
     * @return string
     */
    public function responseHost() {
        $host = plum_get_base_host();
        return $host;
    }

    public function setStatusCode($statusCode) {
        $this->_statusCode = $statusCode;
    }

    public function setHeader($name, $value) {
        $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
        $this->_headers[] = $name . ': ' . $value;
    }

    public function setContentType($contentType) {
        $this->_contentType = $contentType;
    }

    public function setCharset($charset) {
        $this->_charset = $charset;
    }
    /**
     * 302临时重定向
     */
    public function setTemporarilyRedirection($url) {
        $this->setStatusCode(302);
        $this->setHeader('Location', $url);
        $this->_respond();
    }

    public function renderForwardPage() {
        

    }
}

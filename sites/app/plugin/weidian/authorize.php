<?php
require_once 'includes/WebStart.php';
/**
 * 跳转到授权页面
 */
$url = API_HOST . 'oauth2/authorize?appkey=' . $appkey . '&redirect_uri=' . getOAuthRedirectURL () . '&response_type=code&state=STATE';

Header ( "HTTP/1.1 302 " );
Header ( "Location: " . $url );

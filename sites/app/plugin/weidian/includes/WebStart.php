<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
define("CURR_PATH", dirname(dirname(__FILE__)));
require_once CURR_PATH . '/includes/Defines.php';
require_once CURR_PATH . '/includes/AutoLoader.php';

ini_set ( 'date.timezone', 'Asia/Shanghai' );
/**
 * 获取全局AccessToken
 *
 * @return string
 */
function getAccessToken() {
	/**
	 * 这里演示只有一条固定全局AccessToken，在实际使用中，可能会根据不同的授权用户，
	 * 获取各自的AccessToken，此时需要自行扩展实现多用户的全局共享AccessToken
	 */
	return RedisCacheApi::getAccessToken ();
}

/**
 * 更新全局授权数据
 *
 * @param unknown $data        	
 * @return resource boolean
 */
function updateAuthorizationData($data) {
	return RedisCacheApi::updateAuthToken ( $data );
}

/**
 * 获取RefreshToken
 *
 * @return string
 */
function getRefreshToken() {
	/**
	 * 这里演示只有一条固定全局RefreshToken，在实际使用中，可能会根据不同的授权用户，
	 * 获取各自的AccessToken，此时需用户自行实现扩展。
	 */
	return RedisCacheApi::getRefreshToken ();
}

/**
 * 获取当前请求URL
 */
function getCurrentURL() {
	if ($_SERVER ['SERVER_PORT'] == '80') {
		return 'http://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	} else {
		return 'http://' . $_SERVER ['HTTP_HOST'] . ":" . $_SERVER ['SERVER_PORT'] . $_SERVER ['REQUEST_URI'];
	}
}
/**
 * 获取当前host URL
 */
function getCurrentHost() {
	$index = strpos ( $_SERVER ['REQUEST_URI'], "/", 1 );
	$server_path = substr ( $_SERVER ['REQUEST_URI'], 0, $index );
	if ($_SERVER ['SERVER_PORT'] == '80') {
		return 'http://' . $_SERVER ['HTTP_HOST'] . $server_path;
	} else {
		return 'http://' . $_SERVER ['HTTP_HOST'] . ":" . $_SERVER ['SERVER_PORT'] . $server_path;
	}
}
/**
 * 获取授权回调URL
 * #注意：获取到的域名是当前访问的URL地址，需要确保和开放平台设置的域名相同。
 *
 * @return string
 */
function getOAuthRedirectURL() {
	// $host = getCurrentHost ();
	// TODO 授权回调HOST->需要和微店设置的保持一致
	$host = "http://www.abc.com/weidian_sdk_php";
	return $host . "/authorize_callback.php";
}


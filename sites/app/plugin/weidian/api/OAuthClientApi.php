<?php
/**
 * 微店OAuth API
 */
class OAuthClientApi extends ApiBase {
	public function __construct() {
	}
	/**
	 * 获取自用型AccessToken
	 *
	 * @ignore
	 *
	 *
	 *
	 *
	 *
	 *
	 * @return HttpResponse
	 */
	public function getSelfoneAccessToken() {
		global $oneself_appkey;
		global $oneself_secret;
		// 取自用型AccessToken链接
		$url = API_HOST . 'token';
		$parameters = array (
				"grant_type" => "client_credential",
				"appkey" => $oneself_appkey,
				"secret" => $oneself_secret 
		);
		return NetUtils::getInstance ()->request ( $url, 'GET', $parameters );
	}
	
	/**
	 * 上传图片
	 *
	 * @ignore
	 *
	 *
	 *
	 *
	 *
	 *
	 * @param unknown $img_path        	
	 * @return HttpResponse
	 */
	public function uploadImage($access_token, $img_path) {
		$url = API_HOST . 'media/upload';
		return NetUtils::getInstance ()->uploadFile ( $url, array (
				"access_token" => $access_token,
				"media" => $img_path 
		) );
	}
	/**
	 * 使用Code换取AccessToken
	 *
	 * @param unknown $code        	
	 * @return HttpResponse
	 */
	public function getAccessToken($code) {
		$url = API_HOST . "oauth2/access_token";
		global $appkey;
		global $secret;
		return NetUtils::getInstance ()->request ( $url, 'POST', array (
				"grant_type" => "authorization_code",
				"appkey" => $appkey,
				"secret" => $secret,
				"code" => $code 
		) );
	}
	
	/**
	 *
	 * @ignore 刷新access_token
	 * @param unknown $refresh_token        	
	 * @throws Exception
	 * @return HttpResponse
	 */
	function refreshToken($refresh_token) {
		$url = constant ( 'API_HOST' ) . "oauth2/refresh_token";
		global $appkey;
		return NetUtils::getInstance ()->post ( $url, array (
				"grant_type" => "refresh_token",
				"appkey" => $appkey,
				"refresh_token" => $refresh_token 
		) );
	}
}

?>
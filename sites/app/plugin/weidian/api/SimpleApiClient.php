<?php
class SimpleApiClient extends ApiBase {
	public function __construct() {
	}
	/**
	 * HTTP post request
	 * @param unknown $public
	 * @param unknown $param
	 * @return HttpResponse
	 */
	public function post($public, $param) {
		if (is_array ( $public ) || is_object ( $public )) {
			$public = json_encode ( $public );
		}
		if (is_array ( $param ) || is_object ( $param )) {
			$param = json_encode ( $param );
		}
		return NetUtils::getInstance ()->post ( WD_API, array (
				"param" => $param,
				"public" => $public 
		) );
	}
	/**
	 * HTTP get request
	 * @param unknown $public
	 * @param unknown $param
	 * @return HttpResponse
	 */
	public function get($public, $param) {
		if (is_array ( $public ) || is_object ( $public )) {
			$public = json_encode ( $public );
		}
		if (is_array ( $param ) || is_object ( $param )) {
			$param = json_encode ( $param );
		}
		$url = WD_API . "?public=" . urlencode ( $public ) . "&param=" . urlencode ( $param );
		return NetUtils::getInstance ()->get ( $url );
	}
}

?>
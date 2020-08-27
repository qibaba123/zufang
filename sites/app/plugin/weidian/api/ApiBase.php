<?php
class ApiBase {
	protected $access_token;
	public function __construct($access_token) {
		$this->access_token = $access_token;
	}
	public final function buildPublicParameter($method, $version = "1.0", $format = "json") {
		return 'public=' . urlencode ( self::buildPublicValue ( $method, $version, $format ) );
	}
	public function buildPublicValue($method, $version = "1.0", $format = "json") {
		return '{"method":"' . $method . '","access_token":"' . $this->access_token . '","version":"' . $version . '","format":"' . $format . '","lang":"php"}';
	}
}

?>
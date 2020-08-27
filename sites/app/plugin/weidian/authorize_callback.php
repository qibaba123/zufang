<?php
require_once 'includes/WebStart.php';

/**
 * 授权回调地址
 */

Logger::debug ( "参数->code:" . $_REQUEST ["code"] );
Logger::debug ( "参数->state:" . $_REQUEST ["state"] );

$wdClient = new OAuthClientApi ();
$response = $wdClient->getAccessToken ( $_REQUEST ['code'] );
echo $response->data;
if ($response->getDataAsObject ()->status->status_code === 0) {
	if (updateAuthorizationData ( $response->data )) {
		Logger::info ( "更新授权Token成功" );
	} else {
		Logger::info ( "更新授权Token失败" );
	}
}

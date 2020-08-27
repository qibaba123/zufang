<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/15
 * Time: 下午10:46
 */

require_once __DIR__ . '/lib/KdtRedirectApiClient.php';

class App_Plugin_Youzan_ClientPlugin extends KdtRedirectApiClient {

    public function __construct($appId, $appSecret) {
        parent::__construct($appId, $appSecret);
    }
}


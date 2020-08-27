<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/4
 * Time: 下午8:37
 */
require(dirname(__FILE__) . '/init.php');

class App_Plugin_Pingpp_Client extends \Pingpp\Pingpp{

    public function __construct(){
        $cfg    = plum_parse_config('pingpp');
        parent::setApiKey($cfg['live_key']);
        parent::setPrivateKeyPath(dirname(__FILE__).'/cert/rsa_private_key.pem');
    }

    // 生成支付charge对象
    public function create($params = null, $option = null) {
        return \Pingpp\Charge::create($params, $option);
    }

    // 生成退款refund对象
    public function refunds($id = null,$params = null, $option = null) {
        $ch = \Pingpp\Charge::retrieve($id,$option);
        return $ch->refunds->create($params);
    }
}
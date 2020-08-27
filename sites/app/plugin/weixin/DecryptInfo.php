<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/5
 * Time: 下午2:22
 */
include_once "decrypt/wxBizDataCrypt.php";

class App_Plugin_Weixin_DecryptInfo {
    public function __construct() {
    }
    public function getUserInfo($appid, $sessionKey,$encryptedData, $iv){
        $data = '';
        $decrypt = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $decrypt->decryptData($encryptedData, $iv,$data);
        Libs_Log_Logger::outputLog($errCode);
        $info = array(
            'data' => $data,
            'code' => $errCode
        );
        return $info;
    }

    public function getUserInfoTest($appid, $sessionKey,$encryptedData, $iv){
        $data = '';
        $decrypt = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $decrypt->decryptData($encryptedData, $iv,$data);
        $info = array(
            'data' => $data,
            'code' => $errCode
        );
        return $info;
    }


}
<?php

class App_Helper_SharePoster {
    const PHANTOMJS_PATH        = PLUM_DIR_APP."/plugin/phantomjs/bin/phantomjs";
    const PHANTOMJS_SCRIPT_PATH = PLUM_DIR_ROOT."/public/wxapp/phantomjs/phantomjs.js";
    const DOMAIN = "https://jdfs.jixuantiant.com";
    /*
     * 处理生成分享海报
     */
    public static function generateSharePoster($method, $params, $fileType='png'){
        if($params['suid']){
            $suid = $params['suid'];
        }elseif($params['sid']){
            $shop_storage = new App_Model_Shop_MysqlShopCoreStorage();
            $shop = $shop_storage->getRowById($params['sid']);
            $suid = $shop['s_unique_id'];
        }else{
            $suid = 'default';
        }

        $url = self::DOMAIN."/wxapp/shareposter/".$method."?";
        foreach ($params as $key => $val){
            $url .= $key."=".$val."&";
        }

        list($usec, $sec) = explode(" ", microtime());
        $md5  = strtoupper(md5($usec.$sec));
        $name = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);

        $fileroot   = PLUM_DIR_UPLOAD. '/depot/'.$suid.'/'.date('Ymd', time()).'/';
        if (!is_dir($fileroot)) {
            @mkdir($fileroot, 0755, true);
        }

        $filename = PLUM_DIR_UPLOAD. '/depot/'.$suid.'/'.date('Ymd', time()).'/'.$name.($fileType == 'pdf'?'.pdf':'.png');
        $filepath = PLUM_PATH_UPLOAD . '/depot/'.$suid.'/'.date('Ymd', time()).'/'.$name.($fileType == 'pdf'?'.pdf':'.png');

        $ret = shell_exec(self::PHANTOMJS_PATH." ".self::PHANTOMJS_SCRIPT_PATH." '".$url."' ".$filename);
        if(trim($ret) == 'true'){
            //数据同步操作
            try {
                $sync = new Libs_Image_DataSync();
                $sync->pushQueue($filepath);
            } catch (Exception $e) {
                Libs_Log_Logger::outputLog($e->getMessage().':'.$filepath, 'imgsrc.log');
            }
            sleep(1);
            return $filepath;
        }else{
            return false;
        }
    }


}

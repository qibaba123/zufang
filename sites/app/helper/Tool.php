<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/10
 * Time: 下午1:25
 */
class App_Helper_Tool {
    const TRANSFER_ERROR    = 'LOG转换失败，非LOG信息';
    const NOTICE_SUBJECT    = '天店通店铺动态通知';

    // 文件上传
    public function upload_video_limit_type($key, $dir,$isDrupal=0,$type=1){
        $upload_file = isset($_FILES[$key]) ? $_FILES[$key] : false;

        //var_dump($upload_file);exit;
        /*   $filename = $this->getFileName();
           $file_path = $dir.$filename.$check[$info[2]];
           move_uploaded_file($tmp_name, PLUM_DIR_ROOT . $file_path);*/
        if($type == 1){
            $urltype = '.mp4';
        }elseif($type == 2){
            $urltype = '.mp3';
        }
        $data = $this->deal_video_info($upload_file['tmp_name'],$upload_file['error'],$dir,$urltype);
        if($isDrupal){
            drupal_json_output($data);
        }else{
            return $data;
        }
    }


    // 文件上传处理
    private function deal_video_info($tmp_name,$error,$dir,$urltype){
        set_time_limit(0);
        //初始状态
        $data = array(
            'ec'    => 400,
            'em'    => '上传失败，请重试！'
        );
        //初始信息
        $check = array(
            1           => '.mp4',
            2           => '.mp3',
            'type'      => array(1, 2),
        );
        if ($tmp_name && !$error) {
            //var_dump($tmp_name);exit;
            //$info = @getimagesize($tmp_name);
            $fileSize = filesize($tmp_name);  // 获取文件大小，超过 50M 提示视频过大
            //var_dump($fileSize);exit;
            if($fileSize>2*1024*1024*50){
                $data['em']     = '图片大小超过100M，请先压缩后重新上传';
            }else{
                //var_dump($info);exit;
                /* if ($info && in_array($info[2], $check['type']) ) {*/
                $filename = $this->getFileName();
                $file_path = $dir.$filename.$urltype;
                move_uploaded_file($tmp_name, PLUM_DIR_ROOT . $file_path);
                $data['ec']     = 200;
                $data['em']     = '上传成功！';
                $data['url']    = $file_path;
                /*  } else {
                      $data['em']     = '上传格式错误的文件';
                  }*/
            }
            // 清楚缓存
            clearstatcache();
        }
        return $data;
    }
    /*
     * 发送邮件给邮件配置人员
     */
    public static function sendMail($subject, $body, $to = null) {
        if (!$to) {
            $mlto       = plum_parse_config('to', 'mail');
        } else {
            $mlto       = $to;
        }
        $mlcc       = plum_parse_config('cc', 'mail');
        $mailer     = new Libs_Mail_Mailer($mlto, $mlcc);

        $body   = self::logFormat($body);
        $mailer->sendMail($subject, $body ,$to);
    }
    /*
     * 店铺邮件通知
     */
    public static function sendShopNoticeMail($sid, $body) {
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($sid);

        if ($shop && plum_is_email($shop['s_email'])) {
            $mailto     = $shop['s_email'];
            $mailer     = new Libs_Mail_Mailer($mailto);

            $body   = self::logFormat($body);
            $mailer->sendMail(self::NOTICE_SUBJECT, $body);
        }
    }
    /*
     * 记录系统错误到数据库
     */
    public static function recordSystemError($err, $sid) {
        //获取调用跟踪
        $trace  = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1);
        $info = self::logFormat($err);

        $indata = array(
            'w_s_id'        => $sid,
            'w_desc'        => $info,
            'w_file'        => $trace[0]['file'],
            'w_line'        => $trace[0]['line'],
            'w_ip'          => plum_get_client_ip(),
            'w_create_time' => time(),
        );
        $watchdog_model = new App_Model_System_MysqlWatchdogStorage();
        $watchdog_model->insertValue($indata);
    }

    /**
     * 返回格式化的LOG日志信息
     * @param $log
     * @return string
     */
    public static function logFormat($log) {
        $log_type = 'Unknown';
        if (is_array($log)) {
            //数组进行json序列化
            //TODO 转换失败未做处理
            $log_type   = 'Array';
            $log        = json_encode($log, JSON_UNESCAPED_UNICODE);
        } else if (is_object($log)) {
            //TODO 转换失败，未做处理
            $log_type   = 'Object';
            $log        = json_encode($log, JSON_UNESCAPED_UNICODE);
        } else if (is_string($log)) {
            $log_type   = 'String';
        } else if (is_bool($log)) {
            $log_type   = 'Bool';
            $log        = $log ? 'true' : 'false';
        } else if (is_numeric($log)) {
            $log_type   = 'Number';
            $log        = strval($log);
        } else if (is_null($log)) {
            $log_type   = 'Null';
            $log        = 'null';
        } else {
            $log = strval($log);
        }
        //再一次判断，排查转换出错的情况
        if (!is_string($log)) {
            $log = self::TRANSFER_ERROR;
        }
        //添加换行符
        $log .= "\n";

        $format = "[".date('Y/m/d H:i:s', time())."] $log_type: $log";

        return $format;
    }
    /*
     * 输出12位数字卡号
     */
    public static function exportCardNum() {
        $num1   = mt_rand(1000, 9999);
        $num2   = mt_rand(1000, 9999);
        $num3   = mt_rand(1000, 9999);

        return strval($num1).strval($num2).strval($num3);
    }

    public function uploadFileLimitWidthHeight($suid='default', $width,$height){
        set_time_limit(0);
        //初始状态
        $data = array(
            'ec'    => 400,
            'em'    => '上传失败，请重试！'
        );
        //初始信息
        $check = array(
            1           => '.gif',
            2           => '.jpg',
            3           => '.png',
            'width'     => $width,
            'height'    => $height,
            'type'      => array(1, 2, 3),
        );
        list($usec, $sec) = explode(" ", microtime());
        $md5 = strtoupper(md5($usec.$sec));
        $filename = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);

        $upload_file = isset($_FILES['uploadFile']) ? $_FILES['uploadFile'] : false;
        //plum_msg_dump($upload_file);
        if ($upload_file && !$upload_file['error']) {
            $info = @getimagesize($upload_file['tmp_name']);
            if ($info && in_array($info[2], $check['type']) && $info[0] == $check['width'] && $info[1] == $check['height']) {
                $dir = '/upload/depot/'.$suid.'/'.date('Ymd', time()).'/';
                $fileroot   = PLUM_DIR_ROOT . $dir;
                if (!is_dir($fileroot)) {
                    @mkdir($fileroot, 0755, true);
                }
                $file_path = $dir.$filename.$check[$info[2]];
                move_uploaded_file($upload_file['tmp_name'], DRUPAL_ROOT . $file_path);
                //数据同步操作
                try {
                    $sync = new Libs_Image_DataSync();
                    $sync->pushQueue($file_path);
                } catch (Exception $e) {
                    Libs_Log_Logger::outputLog($e->getMessage().':'.$file_path, 'imgsrc.log');
                }
                $data['ec']     = 200;
                $data['em']     = '上传成功！';
                $data['url']    = $file_path;
            } else {
                $data['em']     = '需上传宽'.$width.'px、高'.$height.'px的图片';
            }
        }
        drupal_json_output($data);
    }

    /**
     * 输出手机端访问链接
     * @param $controller
     * @param $action
     * @param array $params
     * @param bool $need_suid
     * @param string $snsapi_type
     * @return string
     */
    public static function outputMobileLink($sid, $controller, $action, $params = array(), $need_suid = true, $snsapi_type = 'base') {
        $domain_model   = new App_Model_Shop_MysqlDomainStorage();
        $domain     = $domain_model->findDomainBySid($sid);

        $shop_model     = new App_Model_Shop_MysqlShopCoreStorage();
        $shop       = $shop_model->getRowById($sid);

        if (!$domain) {
            $domain     = 'http://'.plum_parse_config('shield_domain', 'weixin');
        } else {
            $domain     = 'http://'.$domain['sd_domain'];
        }

        $allow_type = array_keys(plum_parse_config('scope_type', 'weixin'));
        $type   = in_array($snsapi_type, $allow_type) ? $snsapi_type : 'base';
        $link   = $domain."/mobile/{$controller}/{$action}";
        foreach ($params as $key => $val) {
            $link .= "/{$key}/{$val}";
        }
        if ($need_suid) {
            $link .= "/suid/".$shop['s_unique_id'];
        }
        if ($snsapi_type != 'info') {
            $link .= "/snsapi/{$type}";
        }
        return $link;
    }

    /*
     * 消息模板的搜索,替换
     */
    public static function messageContentReplace($reg, $msg, $tpl) {
        if (empty($reg) || empty($msg)) {
            return $tpl;
        }

        foreach ($reg as &$item) {
            $item   = "/{$item}/";
        }

        return preg_replace($reg, $msg, $tpl);
    }

    /*
     * *********************图片上传*******************************************
     */
    // 单张图片上传
    public function upload_file_limit_type($key, $dir,$isDrupal=0){
        $upload_file = isset($_FILES[$key]) ? $_FILES[$key] : false;
     //   Libs_Log_Logger::outputLog($upload_file,'image.log');
     //   Libs_Log_Logger::outputLog($dir,'image.log');
        $data = $this->deal_file_info($upload_file['tmp_name'],$upload_file['error'],$dir);
       if($isDrupal){
           drupal_json_output($data);
       }else{
           return $data;
       }
    }
    // 多图上传
    public function upload_files_limit_type($key, $dir){
        $upload_files = isset($_FILES[$key]) ? $_FILES[$key] : false;
        if(is_array($upload_files['tmp_name'])){
            $img = array();
            $em  = array();
            for($i=0;$i<count($upload_files['tmp_name']);$i++){
                $tmp_name = $upload_files['tmp_name'][$i];
                $error    = $upload_files['error'][$i];
                $res = $this->deal_file_info($tmp_name,$error,$dir);
                if($res['ec'] == 200){
                    $img[] = $res['url'];
                }else{
                    $em[]  = '第'.$i.'张图上传结果：'.$res['em'];
                }
            }
            if(!empty($img)){
                $data = array(
                    'ec'    => 200,
                    'url'   => $img,
                    'em'    => $em
                );
            }else{
                $data = array(
                    'ec'    => 400,
                    'em'    => $em
                );
            }
        }else{
            $data = array(
                'ec'    => 400,
                'em'    => array('上传失败，请重试！')
            );
        }
        return $data;
    }

    // 图片上传处理
    private function deal_file_info($tmp_name,$error,$dir){
        set_time_limit(0);
        //初始状态
        $data = array(
            'ec'    => 400,
            'em'    => '上传失败，请重试！'
        );
        //初始信息
        $check = array(
            1           => '.gif',
            2           => '.jpg',
            3           => '.png',
            'type'      => array(1, 2, 3),
        );
        if ($tmp_name && !$error) {
            $info = @getimagesize($tmp_name);
            $fileSize = filesize($tmp_name);  // 获取图片大小，超过 2M 提示图片过大
            if($fileSize>10*1024*1024){
                $data['em']     = '图片大小超过10M，请先压缩后重新上传';
            }else{
                if ($info && in_array($info[2], $check['type']) ) {
                    $fileroot   = PLUM_DIR_ROOT . $dir;
                    if (!is_dir($fileroot)) {
                        @mkdir($fileroot, 0755, true);
                    }
                    $filename = $this->getFileName();
                    $file_path = $dir.$filename.$check[$info[2]];
                    move_uploaded_file($tmp_name, PLUM_DIR_ROOT . $file_path);
                    //数据同步操作
                    try {
                        $sync = new Libs_Image_DataSync();
                        $sync->pushQueue($file_path);
                    } catch (Exception $e) {
                        Libs_Log_Logger::outputLog($e->getMessage().':'.$file_path, 'imgsrc.log');
                    }
                    $data['ec']     = 200;
                    $data['em']     = '上传成功！';
                    $data['url']    = $file_path;
                } else {
                    $data['em']     = '上传格式错误的图片';
                }
            }
            // 清楚缓存
            clearstatcache();
        }
        return $data;
    }

    private function getFileName(){
        list($usec, $sec) = explode(" ", microtime());
        $md5 = strtoupper(md5($usec.$sec));
        $filename = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);
        return $filename;
    }


    /*
     * 通过手机号获取归属地
     */
    public static function getAddressByMobile($mobile){
        $url    = "http://apis.juhe.cn/mobile/get";
        $key    = 'b020b1b37c993089fcb5fed500b71e99';
        $params = array('phone' =>$mobile, 'key'=>$key);
        $ret = Libs_Http_Client::get($url, $params);
        $result = json_decode($ret,true);
        $data = array();
        if($result['resultcode']==200){
            $data = array(
                'province' => $result['result']['province'],
                'city'     => $result['result']['city'],
            );
        }
        return $data;
    }


    public  function get_push_result($id,$ios,$android){
        $push_and = '<span id="push_android_'.$id.'"><a class="btn btn-warning" href="javascript:push('.$id.','."'android'".')" role="button">安卓</a></span>';
        $push_ios = '<span id="push_ios_'.$id.'"><a class="btn btn-warning" href="javascript:push('.$id.','."'ios'".')" role="button">苹果</a></span>';

        if($ios==0 && $android==0){
            $data = $push_and.$push_ios;
        }elseif($ios==0 && $android==1){
            $data = '成功'.$push_ios;
        }elseif($ios==1 && $android==0){
            $data = $push_and.'成功';
        }else{
            $data = '推送 成功';
        }


        return $data;
    }


    /**
     * 游戏盒子触发任务完成
     */
    public static function checkGameTask($sid, $mid, $type, $gid=0, $shareId=''){
        $task_model = new App_Model_Gamebox_MysqlGameboxTaskStorage($sid);
        $where = array();
        $where[] = array('name' => 'agt_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'agt_type', 'oper' => '=', 'value' => $type);
        $tasks = $task_model->getList($where, 0, 0, array());
        $progress_model = new App_Model_Gamebox_MysqlGameboxTaskProgressStorage($sid);
        if($tasks){
            switch ($type){
                case 2: //玩指定数量游戏
                    $history_model = new App_Model_Gamebox_MysqlGameboxHistoryStorage($sid);
                    $where = array();
                    $where[] = array('name' => 'agh_s_id', 'oper' => '=', 'value' => $sid);
                    $where[] = array('name' => 'agh_m_id', 'oper' => '=', 'value' => $mid);
                    $where[] = array('name' => 'agh_update_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
                    $playNum = $history_model->getCount($where);
                    foreach ($tasks as $val){
                        $progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                        if($playNum >= $val['agt_game_num'] && !$progress){
                            $indata[] = array(
                                'agtp_s_id'   => $sid,
                                'agtp_m_id'   => $mid,
                                'agtp_agt_id' => $val['agt_id'],
                                'agtp_status' => 1,
                                'agtp_create_time' => time()
                            );
                        }
                    }
                    break;
                case 3: //玩指定游戏
                    foreach ($tasks as $val){
                        $progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                        if($gid == $val['agt_game_id'] && !$progress){
                            $indata[] = array(
                                'agtp_s_id'   => $sid,
                                'agtp_m_id'   => $mid,
                                'agtp_agt_id' => $val['agt_id'],
                                'agtp_status' => 1,
                                'agtp_create_time' => time()
                            );
                        }
                    }
                    break;
                case 4: //分享好友
                    $history_model = new App_Model_Gamebox_MysqlGameboxTaskHistoryStorage($sid);
                    $where = array();
                    $where[] = array('name' => 'agth_m_id', 'oper' => '=', 'value' => $mid);
                    $where[] = array('name' => 'agth_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
                    $history = $history_model->getRow($where);
                    if($history){
                        $shareMember = $history['agth_share_member']?json_decode($history['agth_share_member'], true):[];
                        if(!in_array($shareId, $shareMember)){
                            array_push($shareMember, $shareId);
                            $set = array('agth_share_num' => $history['agth_share_num'] + 1, 'agth_share_member' => json_encode($shareMember));
                            $history_model->updateById($set, $history['agth_id']);
                            foreach ($tasks as $val){
                                //$progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                                if($val['agt_day_times'] > $history['agth_share_num']){
                                    $indata[] = array(
                                        'agtp_s_id'   => $sid,
                                        'agtp_m_id'   => $mid,
                                        'agtp_agt_id' => $val['agt_id'],
                                        'agtp_status' => 1,
                                        'agtp_create_time' => time()
                                    );
                                }
                            }
                        }
                    }else{
                        $data = array(
                            'agth_s_id' => $sid,
                            'agth_m_id' => $mid,
                            'agth_share_num' => 1,
                            'agth_share_member' => json_encode([$shareId]),
                            'agth_create_time' => time()
                        );
                        $history_model->insertValue($data);
                        foreach ($tasks as $val){
                            //$progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                            if($val['agt_day_times'] > $history['agth_share_num']){
                                $indata[] = array(
                                    'agtp_s_id'   => $sid,
                                    'agtp_m_id'   => $mid,
                                    'agtp_agt_id' => $val['agt_id'],
                                    'agtp_status' => 1,
                                    'agtp_create_time' => time()
                                );
                            }
                        }
                    }
                    break;
                case 5: //分享群
                    $history_model = new App_Model_Gamebox_MysqlGameboxTaskHistoryStorage($sid);
                    $where = array();
                    $where[] = array('name' => 'agth_m_id', 'oper' => '=', 'value' => $mid);
                    $where[] = array('name' => 'agth_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
                    $history = $history_model->getRow($where);
                    if($history){
                        $shareGroup = $history['agth_share_group']?json_decode($history['agth_share_group'], true):[];
                        if(!in_array($shareId, $shareGroup)){
                            array_push($shareGroup, $shareId);
                            $set = array('agth_group_num' => $history['agth_group_num'] + 1, 'agth_share_group' => json_encode($shareGroup));
                            $history_model->updateById($set, $history['agth_id']);
                            foreach ($tasks as $val){
                                //$progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                                if($val['agt_day_times'] > $history['agth_group_num']){
                                    $indata[] = array(
                                        'agtp_s_id'   => $sid,
                                        'agtp_m_id'   => $mid,
                                        'agtp_agt_id' => $val['agt_id'],
                                        'agtp_status' => 1,
                                        'agtp_create_time' => time()
                                    );
                                }
                            }
                        }
                    }else{
                        $data = array(
                            'agth_s_id' => $sid,
                            'agth_m_id' => $mid,
                            'agth_group_num' => 1,
                            'agth_share_group' => json_encode([$shareId]),
                            'agth_create_time' => time()
                        );
                        $history_model->insertValue($data);
                        foreach ($tasks as $val){
                            //$progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                            if($val['agt_day_times'] > $history['agth_group_num']){
                                $indata[] = array(
                                    'agtp_s_id'   => $sid,
                                    'agtp_m_id'   => $mid,
                                    'agtp_agt_id' => $val['agt_id'],
                                    'agtp_status' => 1,
                                    'agtp_create_time' => time()
                                );
                            }
                        }
                    }
                    break;
                case 6: //邀请新用户
                    $history_model = new App_Model_Gamebox_MysqlGameboxTaskHistoryStorage($sid);
                    $where = array();
                    $where[] = array('name' => 'agth_m_id', 'oper' => '=', 'value' => $mid);
                    $where[] = array('name' => 'agth_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d', time())));
                    $history = $history_model->getRow($where);
                    if($history){
                        $set = array('agth_new_num' => $history['agth_new_num'] + 1);
                        $history_model->updateById($set, $history['agth_id']);
                        foreach ($tasks as $val){
                            //$progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                            if($val['agt_day_times'] > $history['agth_new_num']){
                                $indata[] = array(
                                    'agtp_s_id'   => $sid,
                                    'agtp_m_id'   => $mid,
                                    'agtp_agt_id' => $val['agt_id'],
                                    'agtp_status' => 1,
                                    'agtp_create_time' => time()
                                );
                            }
                        }
                    }else{
                        $data = array(
                            'agth_s_id' => $sid,
                            'agth_m_id' => $mid,
                            'agth_new_num' => 1,
                            'agth_create_time' => time()
                        );
                        $history_model->insertValue($data);
                        foreach ($tasks as $val){
                            //$progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                            if($val['agt_day_times'] > $history['agth_new_num']){
                                $indata[] = array(
                                    'agtp_s_id'   => $sid,
                                    'agtp_m_id'   => $mid,
                                    'agtp_agt_id' => $val['agt_id'],
                                    'agtp_status' => 1,
                                    'agtp_create_time' => time()
                                );
                            }
                        }
                    }
                    break;
                case 1: //签到
                case 7: //抽奖
                    foreach ($tasks as $val){
                        $progress = $progress_model->getRowByTidMid($val['agt_id'], $mid);
                        if(!$progress){
                            $indata[] = array(
                                'agtp_s_id'   => $sid,
                                'agtp_m_id'   => $mid,
                                'agtp_agt_id' => $val['agt_id'],
                                'agtp_status' => 1,
                                'agtp_create_time' => time()
                            );
                        }
                    }
                    break;
            }
        }
        if(!empty($indata)){
            foreach ($indata as $val){
                $progress_model->insertValue($val);
            }
        }
        return true;
    }

    // 单张图片上传
    public function upload_file_no_type($dir,$isDrupal=0){
        $upload_file = $_FILES;
        $data = $this->deal_file_info($upload_file['name'],$upload_file['error'],$dir);
        if($isDrupal){
            drupal_json_output($data);
        }else{
            return $data;
        }
    }



    /**
     * 读取文件最后$n行
     * @param string $filename 文件路径
     * @param int $n 最后几行
     * @return mixed false表示有错误，成功则返回字符串
     */
    public static function FileLastLines($filename,$n){
        if(!$fp=fopen($filename,'r')){
            echo "打开文件失败，请检查文件路径是否正确，路径和文件名不要包含中文";
            return false;
        }
        $pos=-2;
        $eof="";
        $str="";
        while($n>0){
            while($eof!="\n"){
                if(!fseek($fp,$pos,SEEK_END)){
                    $eof=fgetc($fp);
                    $pos--;
                }else{
                    break;
                }
            }
            $str.=fgets($fp);
            $eof="";
            $n--;
        }
        return $str;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/4/26
 * Time: 下午6:30
 */
class App_Plugin_Jpush_JpushPlugin {

    const JPUSH_GATWAY    = 'https://api.jpush.cn/v3/push';

    private $applet_type;     // 小程序类型 type=29是51同镇平台

    public function __construct($type) {
        $this->applet_type = $type;       //小程序类型
    }

    /**
     * @param $receiver   推送目标用户
     * @param string $title  推送标题
     * @param string $content  推送内容
     * @param array $extras 附加值
     * @param string $type  推送类型
     * @param int $m_time   保存离线时间的秒数默认为一天
     * @return bool
     */
    public function push($receiver, $title='', $content='', $extras=array(),$type='all', $m_time=86400,$production=true,$leagwork = false){
        $data = array();
        $data['platform'] = 'all';          //目标用户终端手机的平台类型android,ios,winphone,all代表所有类型
        $data['audience']['alias'] = $receiver;          //目标用户,推送给多个别名，$receive ='all'全部；//$receive = array('tag'=>array('2401','2588','9527'));//标签
        if($type=='notification'){
            //发送通知
            $data['notification'] = $this->_fetch_notification($title,$content,$extras);
        }elseif ($type=='message'){
            //自定义信息
            $data['message'] = $this->_fetch_message($title,$content,$extras);
        }else{
            //发送通知
            $data['notification'] = $this->_fetch_notification($title,$content,$extras);
            //自定义信息
            $data['message'] = $this->_fetch_message($title,$content,$extras);
        }
        //附加选项
        $data['options'] = array(
            "sendno"           => time(),
            "time_to_live"     => intval($m_time),      //保存离线时间的秒数默认为一天
            "apns_production"  => $production,          //指定 APNS 通知发送环境：0开发环境，1生产环境。
        );
        $param = json_encode($data);
        $header = $this->_request_header($leagwork);
        $res = $this->push_curl($param,$header);
        if($leagwork){
            Libs_Log_Logger::outputLog($res);
        }
        // 判断处理结果
        if($res){
            if(isset($res['error'])){  //如果返回了error则证明失败，返回错误信息
                return $res['error'];
            }else{
                //处理成功的推送......
                return true;
            }
        }else{          //未得到返回值--推送失败
            return false;
        }
    }
    //获取推送通知
    private function _fetch_notification($title,$content,$extras){
        $notification = array(
            //统一的模式--标准模式

            "android"=>array(
                "alert"      =>$content,
                "title"      =>$title,
                "builder_id" =>1,
                "extras"     =>$extras
            ),
            //ios的自定义
            "ios"=>array(
                "alert"   =>$content,
                "badge"   =>"1",
                "sound"   =>"default",
                "extras"  =>$extras
            ),
        );
        return $notification;
    }
    //获取推送消息内容
    private function _fetch_message($title,$content,$extras){
        //自定义信息
        $message = array(
            "title"       =>$title,
            "msg_content" =>$content,
            "extras"      =>$extras
        );
        return $message;
    }

    // 获取header
    public function _request_header($legwork = false){
        // 获取推送配置
        if($legwork){
            // 跑腿骑手app推送
            $pushCfg = plum_parse_config('legworkappjpush');
            Libs_Log_Logger::outputLog('-----执行这一步了-------');
        }elseif($this->applet_type==29){
            // type=29则表示同镇同城信息
            $pushCfg = plum_parse_config('tongzhenjpush');
        }else{
            $pushCfg = plum_parse_config('jpush');
        }
        $appkey = $pushCfg['AppKey'];
        $MasterSecret = $pushCfg['MasterSecret'];
        $base64=base64_encode("$appkey:$MasterSecret");
        $header = array("Authorization:Basic $base64","Content-Type:application/json");
        return $header;
    }

    // 执行curl
    public function push_curl($param="",$header="") {
        if (empty($param)) { return false; }
        $postUrl = self::JPUSH_GATWAY;
        $curlPost = $param;
        $ch = curl_init();                                      //初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);           // 增加 HTTP Header（头）里的字段
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $data = curl_exec($ch);                                 //运行curl
        curl_close($ch);
        return $data;
    }

}
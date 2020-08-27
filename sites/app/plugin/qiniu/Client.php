<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/26
 * Time: 下午2:38
 */

function classLoader($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/' . $path . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');

require_once  __DIR__ . '/Qiniu/functions.php';
use Qiniu\Auth;

class App_Plugin_Qiniu_Client {
    /**
     * @var Auth
     */
    public $auth;

    public $qiniu_cfg;

    public function __construct($ak='', $sk='', $name='') {
        if($ak && $sk && $name){
            $this->qiniu_cfg = array(
                'Access_Key' => $ak,
                'Secret_Key' => $sk,
                'Bucket_Name' => $name
            );
        }else{
            $qiniu_cfg  = plum_parse_config('access', 'qiniu');
            $this->qiniu_cfg    = $qiniu_cfg;
        }
        $this->initAuth();
    }

    private function initAuth() {
        // 用于签名的公钥和私钥
        $accessKey = $this->qiniu_cfg['Access_Key'];
        $secretKey = $this->qiniu_cfg['Secret_Key'];
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);

        $this->auth = $auth;
    }

    public function getUploadToken($key=null) {
        $bucket = $this->qiniu_cfg['Bucket_Name'];
        $token  = $this->auth->uploadToken($bucket,$key);

        return $token;
    }

    /**
     *  刷新cdn缓存
     */
    public function refreshCdn($params){
      $url = 'http://fusion.qiniuapi.com/v2/tune/refresh';
//      $params = array(
//          'urls' =>array(
//              'http://os578arev.bkt.clouddn.com/fhg1lhcf5p.mp4',
//              'http://os578arev.bkt.clouddn.com/fhfqdvs6ov.mp4',
//              'http://os578arev.bkt.clouddn.com/fg7svf2e9c.mp4',
//          ),
//          'dirs' => array()
//      );
      $header = array();
      $header[] = 'Host: fusion.qiniuapi.com';
      $header[] = 'Content-Type: application/json';
      $header[] = 'Authorization: QBox '.$this->auth->signRequest($url,null);
      $ret = Libs_Http_Client::post($url,json_encode($params),array(),$header);

      return $ret;
    }

    /**
     *  资源删除
     */
    public function delete($key){
        $entry = $this->qiniu_cfg['Bucket_Name'].':'.$key;
        $encodedEntryURI = $this->urlsafe_base64_encode($entry);
        $url = 'http://rs.qiniu.com/delete/'.$encodedEntryURI;
        $header = array();
        $header[] = 'Host: rs.qiniu.com';
        $header[] = 'Content-Type: application/x-www-form-urlencoded';
        $header[] = 'Authorization: QBox '.$this->auth->signRequest($url,null);
        $ret = Libs_Http_Client::post($url,array(),array(),$header);

        return $ret;
    }

    private function urlsafe_base64_encode($string) {
        return strtr(base64_encode($string), '+/', '-_');
    }

    /*
    * 获取视频帧缩略图
    */
    public function fetchVFrame($filename, $offset = 1, $w = 480, $h = 360) {
        $notify_url = plum_get_base_host()."/report/vframe";
        // 用于签名的公钥和私钥
        $accessKey = $this->qiniu_cfg['Access_Key'];
        $secretKey = $this->qiniu_cfg['Secret_Key'];
        // 初始化签权对象
        $auth = new Auth($accessKey, $secretKey);
        $pipeline   = "plum_zhy";//使用的队列名称
        $pfop       = new PersistentFop($auth, $this->bucket, $pipeline, $notify_url);

        //视频截取缩略图操作
        $fops       = "vframe/jpg/offset/{$offset}/w/{$w}/h/{$h}";

        list($id, $err) = $pfop->execute($filename, $fops);

        if ($err != null) {
            return false;
        }
        return $id;
    }


}
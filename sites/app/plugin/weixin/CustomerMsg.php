<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2019/1/8
 * Time: 12:17 PM
 */
class App_Plugin_Weixin_CustomerMsg extends App_Plugin_Weixin_WxxcxClient {

    public function __construct($sid){
        parent::__construct($sid);
    }
    /*
     * 检查访问token
     */
    private function _check_token() {

    }
    /*
     * 下发客服消息输入状态
     * @link https://developers.weixin.qq.com/miniprogram/dev/api/customerTyping.html
     */
    public function customerTyping($openid, $input = 'yes') {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token={$this->access_token}";
        $params     = array(
            'touser'    => $openid,
            'command'   => $input == 'yes' ? 'Typing' : 'CancelTyping',
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 上传图片素材，获取media_id，3天内有效
     * @link https://developers.weixin.qq.com/miniprogram/dev/api/uploadTempMedia.html
     */
    public function uploadImageMedia($img_path) {
        $imgPath    = PLUM_DIR_ROOT.$img_path;//绝对路径
        if (!file_exists($imgPath)) {
            return false;
        }
        //新增临时素材
        $url    = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$this->access_token}&type=image";

        $fields	= array("media" => $imgPath);
        $result = Libs_Http_Client::post($url, array(), $fields);;
        $result = json_decode($result, true);

        if (!isset($result['media_id'])) {
            return false;
        }
        return $result['media_id'];
    }
    /*
     * 发送文本消息
     */
    public function sendTextMsg($openid, $content) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $params     = array(
            'touser'    => $openid,
            'msgtype'   => 'text',
            'text'      => array('content'   => $content),
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 发送图片消息
     */
    public function sendImageMsg($openid, $img_path) {
        $this->_check_token();
        $media_id   = $this->uploadImageMedia($img_path);
        if (!$media_id) {
            return $this->_format_response_output(array('errcode' => -1, 'errmsg' => '图片素材上传失败'));
        }
        $req_url    = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $params     = array(
            'touser'    => $openid,
            'msgtype'   => 'image',
            'image'     => array('media_id' => $media_id),
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 发送链接消息
     */
    public function sendLinkMsg($openid, $title, $desc, $url, $cover) {
        $this->_check_token();

        $req_url    = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $params     = array(
            'touser'    => $openid,
            'msgtype'   => 'link',
            'link'      => array(
                'title'     => $title,
                'description'   => $desc,
                'url'       => $url,
                'thumb_url' => $cover,
            ),
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 发送小程序卡片消息
     */
    public function sendCardMsg($openid, $title, $path, $img_path) {
        $this->_check_token();
        $media_id   = $this->uploadImageMedia($img_path);
        if (!$media_id) {
            return $this->_format_response_output(array('errcode' => -1, 'errmsg' => '图片素材上传失败'));
        }

        $req_url    = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $params     = array(
            'touser'    => $openid,
            'msgtype'   => 'miniprogrampage',
            'miniprogrampage'   => array(
                'title'     => $title,
                'pagepath'  => $path,
                'thumb_media_id' => $media_id,
            ),
        );
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 对输出结果进行格式化处理
     * @link https://smartprogram.baidu.com/docs/develop/third/error/
     */
    private function _format_response_output($res) {
        $code   = array();

        if ($res['errcode'] != 0) {//errno != 0
            $code['errcode']    = $res['errcode'];
            $code['errmsg']     = $res['errmsg'];
        } else {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
        }

        unset($res['errcode']);
        unset($res['errmsg']);

        $code['data']   = empty($res) ? null : $res;

        return $code;
    }
}
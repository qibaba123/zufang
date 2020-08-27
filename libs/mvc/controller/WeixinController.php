<?php

class Libs_Mvc_Controller_WeixinController {

    public $weixinMsg;
    /*
     * 是否使用加密形式
     */
    protected $is_encrypt = false;

    public function __construct($weixin_msg) {
        $this->setWeixinMsg($weixin_msg);
    }

    public function setWeixinMsg($weixin_msg) {
        $this->weixinMsg = $weixin_msg;
        $this->is_encrypt   = property_exists($weixin_msg, 'is_encrypt') && $weixin_msg->is_encrypt ? true : false;
    }

    public function getWeixinMsg() {
        return $this->weixinMsg;
    }

    /**
     * 发送图文信息模板
     * @param array $item e.g. $item = array(array('title','description','picurl','url'))
     */
    public function sendNewsResponse(array $item) {
        $newsTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>%s</ArticleCount>
                        <Articles>%s</Articles>
                        </xml>";
        $articles = '';
        foreach ($item as $each) {
            $articles .= "<item>
                        <Title><![CDATA[{$each['title']}]]></Title>
                        <Description><![CDATA[{$each['description']}]]></Description>
                        <PicUrl><![CDATA[{$each['picurl']}]]></PicUrl>
                        <Url><![CDATA[{$each['url']}]]></Url>
                        </item>";
        }
        $time = time();
        $msgType = "news";
        $resultStr = sprintf(
            $newsTpl,
            $this->weixinMsg->FromUserName,
            $this->weixinMsg->ToUserName,
            $time,
            $msgType,
            count($item),
            $articles);
        $this->_output_response($resultStr);
    }

    public function sendEmptyResponse() {
        echo '';
        exit;
    }

    /*
     * 发送文本回应
     */
    public function sendTextResponse($content) {
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>";
        $time = time();
        $msgType = "text";
        $resultStr = sprintf(
            $textTpl,
            $this->weixinMsg->FromUserName,
            $this->weixinMsg->ToUserName,
            $time,
            $msgType,
            $content);
        $this->_output_response($resultStr);
    }
    /*
     * 发送图片回应
     */
    public function sendImageResponse($media_id) {
        $imgTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                        </Image>
                        </xml>";
        $time = time();
        $msgType = "image";
        $resultStr = sprintf(
            $imgTpl,
            $this->weixinMsg->FromUserName,
            $this->weixinMsg->ToUserName,
            $time,
            $msgType,
            $media_id);
        $this->_output_response($resultStr);
    }

    /*
     * 输出回应
     */
    private function _output_response($result) {
        if ($this->is_encrypt) {
            $result = App_Plugin_Weixin_MsgCrypt::encrypt($result);
        }
        echo $result;
        exit;
    }
}

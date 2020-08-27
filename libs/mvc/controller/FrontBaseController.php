<?php
/**
 * @author thomas<thomas@ikinvin.com>
 * @since 2014-03-28
 */

class Libs_Mvc_Controller_FrontBaseController extends Libs_Mvc_Controller_BaseController {

    public function __construct() {
        parent::__construct();
        global $base_url;
        $this->output['baseurl'] = $base_url;
    }

    /**
     * 获取相对基URL，如/story/
     */
    public function getBaseUrl() {
        global $base_url;
        return $base_url;
    }

    /**
     * 获取绝对URL基路径，如http://www.ikinvin.com/story/
     */
    public function getStandardUrl() {
        $base_url = $this->getBaseUrl();
        $standard_url   = plum_get_base_host().$base_url;
        return $standard_url;
    }

    public function getCurrentUrl() {
        $request_uri    = plum_get_server('REQUEST_URI');
        $current_url    = plum_get_base_host().$request_uri;
        return $current_url;
    }

    /*
     * 拼接绝对路径的URL
     */
    public function splitAbsoluteUrl($url){
        $pattern    = '/^http[s]?:\/\//';
        if (preg_match($pattern, $url)) {
            $current_url    = $url;
        } else {
            $current_url = plum_get_base_host().$url;
        }

        return $current_url;
    }

    /**
     * 展示空白提示页，并终止程序(手机端)
     * @param string $msg
     */
    public function displayBlankPage($msg) {
        $this->output['msg']    = $msg;
        $this->displaySmarty('mobile/blank.tpl', null, null, false);
        exit;
    }

    /**
     * 展示空白提示页, 并终止程序(管理端)
     * @param $title
     * @param $msg
     * @param string $type (default,tips,normal,warning,success,error)
     */
    public function displayTipsPage($title, $msg, $type = 'default') {
        $this->output['tips']   = array(
            'title'     => $title,
            'content'   => $msg,
            'type'      => $type,
        );
        $this->displaySmarty('layout/placeholder.tpl');
        exit;
    }

    /**
     * 输出分享结构体
     * @param string $title
     * @param string $link
     * @param string $image
     * @param string $desc
     */
    public function outputShareStruct($title, $link, $image, $desc = '') {
        $title   = str_replace(array("\r\n", "\n", "\r"), "", $title);
        $title   = strip_tags($title);//去除所有的HTML和PHP标签
        //去除换行符，HTML标签
        if ($desc) {
            $desc   = preg_replace("/\s+/", "", $desc);//去除所有的换行，以及回车换行
            //$desc   = str_replace(array("\r\n", "\n", "\r"), "", $desc);
            $desc   = strip_tags($desc);//去除所有的HTML和PHP标签
        }
        $this->output['struct'] = array(
            'title'     => $title,
            'link'      => $link,
            'image'     => $image,
            'desc'      => $desc
        );
    }

    /**
     * 渲染裁图工具
     * @param string $action
     * @param int $width
     * @param int $height
     * @param string $field_name
     * @param string $render
     * @param string $title
     */
    public function renderCropTool($action, $width = null, $height =null, $field_name = 'image', $render = 'cropper', $title = '图片上传') {
        $img_cfg    = new Libs_Image_Crop_Cropper($width, $height, $action, $field_name, $title);
        $img_cfg->isLoadJquery(false);
        $img        = $img_cfg->fetchHtml();
        $this->output[$render] = $img;//['field', 'model', 'mobile']
    }

    /**
     * 响应裁图操作
     * @return array
     */
    public function respondCrop() {
        $width  = $this->request->getIntParam('w', 200);
        $height = $this->request->getIntParam('h', 200);
        $crop       = new Libs_Image_Crop_Cropper();
        $crop->crop($width, $height);

        return array(
            'state'  => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult()
        );
    }

    /**
     * @param array $field
     * @param $pre
     * @return array
     * 根据字段循环获取前端数据
     */
    public function getIntByField(array $field,$pre=''){
        $data = array();
        foreach($field as $val){
            $temp = $this->request->getIntParam($val,false);
            if(!($temp === false)){
                $data[$pre.$val] = $temp;
            }
        }
        return $data;
    }
    public function getFloatByField(array $field,$pre=''){
        $data = array();
        foreach($field as $val){
            $temp =  $this->request->getFloatParam($val,false);
            if(!($temp === false)){
                $data[$pre.$val] = $temp;
            }
        }
        return $data;
    }

    /**
     * @param array $field
     * @param string $pre
     * @return array
     * 根据字段批量获取前端传过来的字段
     */
    public function getStrByField(array $field,$pre=''){
        $data = array();
        foreach($field as $val){
            $temp = $this->request->getStrParam($val,false);
            if(!($temp === false)){
                $data[$pre.$val] = $temp;
            }
        }
        return $data;
    }
}

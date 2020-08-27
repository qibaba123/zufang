<?php

class Libs_Mvc_Controller_BaseController {

    const JSON_SUCCESS_STATUS = 200;
    const JSON_FAILURE_STATUS = 400;

    public $request     = null;
    public $response    = null;
    public $smarty;
    public $output = array();

    public function __construct() {
        //初始化request,response助手
        $this->request = Libs_Mvc_Helper_RequestHelper::getInstance();
        $this->response = Libs_Mvc_Helper_ResponseHelper::getInstance();
        //构造smarty模板类
        $this->smarty = new Libs_View_Smarty_SmartyClass();
    }

    /**
     * 输出json格式数据
     * @param array $data
     */
    public function displayJson(array $data, $exit = false) {
        $data['timesec'] = time();
        echo json_encode($data);
        if ($exit) {
            exit;
        }
    }

    /*
     * 输出错误格式的json格式数据
     * @param  string $em
     */
    public function displayJsonError($em) {
        $data['ec'] = self::JSON_FAILURE_STATUS;
        $data['em'] = $em;

        echo json_encode($data);
        die();
    }

    public function displayJsonSuccess($data = null, $exit = false, $em = '') {
        $output = $data ? array('data' => $data) : array();
        $output['timesec']  = time();
        $output['ec']       = self::JSON_SUCCESS_STATUS;
        $output['em']       = $em;

        echo json_encode($output);
        if ($exit) {
            die();
        }
    }
    /*
     * 输出模板文件
     * @param string $template
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param mixed $use_layout
     */
    public function displaySmarty($template, $cache_id = null, $compile_id = null, $use_layout = null) {
        foreach ($this->output as $name => $value) {
            $this->smarty->assign($name, $value);
        }
        $this->smarty->display($template, $cache_id, $compile_id, $use_layout);
    }
    /*
     * 获取模板输出
     * @param string $template
     * @return string
     */
    public function fetchSmarty($template) {
        foreach ($this->output as $name => $value) {
            $this->smarty->assign($name, $value);
        }
        return $this->smarty->fetch($template);
    }

    public function setLayout($layout) {
        $this->smarty->setLayout($layout);
    }

    /*
     * @param $ret
     * @param string $label
     * 显示异步请求结果，返回两种情况
     */
    public function showAjaxResult($ret,$label='保存',$is_json=0){
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => $label.'成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => $label.'失败'
            );
        }
        if($is_json){
            return $result;
        }else{
            $this->displayJson($result,true);
        }
    }
}
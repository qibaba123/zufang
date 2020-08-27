<?php

class Libs_Mvc_Controller_ApiBaseController extends Libs_Mvc_Controller_BaseController {

    const SUCCESS_STATUS = 200;
    const FAILURE_STATUS = 400;

    public function __construct() {
        parent::__construct();
    }

    public function dealImagePath($path,$down=false) {
        $absolute   = false;
        $pattern    = '/^http[s]?:\/\//';
        if (preg_match($pattern, $path)) {
            $absolute = true;
        }
        if (!$absolute) {//非绝对路径
            // 小程序下载的图片必须和授权域名一致
            $path = plum_get_base_host() . '/' . ltrim($path, '/');
        }
        return $path;
    }

    /**
     * 输出封装json数组
     * @param int $ec
     * @param string $em
     */
    public function outputJson($ec = self::SUCCESS_STATUS, $em = '') {
        $this->output['timesec'] = time();
        $this->output['ec'] = $ec;
        $this->output['em'] = $em;
        echo json_encode($this->output);
    }

    /**
     * 输出成功信息
     * @param array $data
     */
    public function outputSuccess($data = array()) {
        $data['timesec'] = time();
        $data['ec'] = self::SUCCESS_STATUS;
        $data['em'] = '';
        echo json_encode($data);
    }

    public function outputSuccessWithExit($data) {
        $output['data'] = $data;

        $output['timesec'] = time();
        $output['ec'] = self::SUCCESS_STATUS;
        $output['em'] = '';
        echo json_encode($output);
        exit;
    }

    /**
     * 输出错误信息并中断程序执行
     * @param string $em 错误信息
     */
    public function outputError($em) {
        $data['ec'] = self::FAILURE_STATUS;
        $data['em'] = $em;
        echo json_encode($data);
        die();
    }
}
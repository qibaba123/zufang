<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/19
 * Time: 下午6:15
 */

class App_Controller_Site_IndexController extends App_Controller_Site_HeadController {


    private $yz_redirect_uri;

    public function __construct() {
        parent::__construct(true);
    }


    /**
     * 测试新的首页-zmh
     */
    public function indexAction(){
        //手机端访问，跳转到技术支持页面
        plum_redirect('/wxapp/index');
    }


}
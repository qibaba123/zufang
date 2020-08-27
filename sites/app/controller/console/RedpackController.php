<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/6
 * Time: 下午9:13
 */

class App_Controller_Console_RedpackController extends Libs_Mvc_Controller_ConsoleController{


    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        $name   = plum_get_param("name");
        Libs_Log_Logger::outputConsoleLog("this is console ".$name);
    }

    /*******************************************后台进程****************************************************************/
    /*
     * 后台保存红包记录
     */
    public function addQrcodeRedpackAction(){
        $sid    = plum_get_int_param('sid');
        $rqid   = plum_get_int_param('rqid');
        $redpack = new App_Helper_Redpack($sid);
        $redpack->systemQrcodeRedpack($rqid);
    }

    /*
     * 后台删除红包记录
     */
    public function deleteQrcodeRedpackAction(){
        $sid    = plum_get_int_param('sid');
        $rqid   = plum_get_int_param('rqid');
        $count  = plum_get_int_param('count');
        $redpack = new App_Helper_Redpack($sid);
        $redpack->deleteQrcodeRecordFile($rqid,$count);
    }
}
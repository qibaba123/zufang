<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/25
 * Time: 上午9:29
 */
class App_Controller_Console_PostController extends Libs_Mvc_Controller_ConsoleController {


    public function __construct() {
        parent::__construct();
    }
    /*
* 帖子置顶到期未更新执行定时任务更新帖子置顶状态
*/
    public function changePostTopAction(){
        $where[] = array('name'=>'acp_istop','oper'=>'=','value'=>1);
        $where[] = array('name'=>'acp_istop_expiration','oper'=>'<','value'=>time());
        $post_storage = new App_Model_City_MysqlCityPostStorage(0);
        $set = array('acp_istop'=>0,'acp_top_date'=>0);
        $ret = $post_storage->updateValue($set,$where);
    }


    /*
     * 检查帖子图片是否有违规
     */
    public function checkImgAction(){
        $imgData = rawurldecode(trim($_REQUEST['imgdata']));
        $sid      = plum_get_int_param('sid');
        $id      = plum_get_int_param('id');
        $imgData = json_decode($imgData,true);
        if(!empty($imgData)){
            $num = 0;
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);
            foreach ($imgData as $val){
                $result = $wxclient_help->checkImg($val);
                if($result && $result['errcode']){
                    $num+=1;
                }
            }
            if($num>0){
                $data['acp_status'] = 1;
                $post_model = new App_Model_City_MysqlCityPostStorage($sid);
                $post_model->updateById($data,$id);
            }
        }
    }


    /*
     * 检查社区多店版帖子图片是否有违规
     */
    public function checkCommunityImgAction(){
        $imgData = rawurldecode(trim($_REQUEST['imgdata']));
        $sid      = plum_get_int_param('sid');
        $id      = plum_get_int_param('id');
        $imgData = json_decode($imgData,true);
        if(!empty($imgData)){
            $num = 0;
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);
            foreach ($imgData as $val){
                $result = $wxclient_help->checkImg($val);
                if($result && $result['errcode']){
                    $num+=1;
                }
            }
            if($num>0){
                $data['acp_status'] = 1;
                $post_model = new App_Model_Community_MysqlCommunityPostStorage($sid);
                $post_model->updateById($data,$id);
            }
        }

    }

    /*
     * 检查社区团购帖子图片是否有违规
     */
    public function checkSequenceImgAction(){
        $imgData = rawurldecode(trim($_REQUEST['imgdata']));
        $sid      = plum_get_int_param('sid');
        $id      = plum_get_int_param('id');
        $imgData = json_decode($imgData,true);
        if(!empty($imgData)){
            $num = 0;
            $wxclient_help = new App_Plugin_Weixin_WxxcxClient(1);
            foreach ($imgData as $val){
                $result = $wxclient_help->checkImg($val);
                if($result && $result['errcode']){
                    $num+=1;
                }
            }
            if($num>0){
                $data['asp_status'] = 1;
                $post_model = new App_Model_Sequence_MysqlSequencePostStorage($sid);
                $post_model->updateById($data,$id);
            }
        }

    }

    /**
     * 图片添加水印
     */
    public function addWatermarkAction(){
        $imgData = rawurldecode(trim($_REQUEST['imgdata']));
        $sid      = plum_get_int_param('sid');
        $imgData = json_decode($imgData,true);
        if(!empty($imgData)){
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
            $cfg        = $applet_cfg->findShopCfg();
            foreach ($imgData as $val){
                App_Helper_Image::addTextWatermark($val, $cfg['ac_name']);
            }
        }
    }
}
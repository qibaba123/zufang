<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/6/27
 * Time: 上午：11：30
 * 通用相关接口
 */

class App_Controller_Applet_PointController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    /*
     * 分享获取积分
     */
    public function shareGetPointAction(){
        $type = $this->request->getStrParam('type');
        $id = $this->request->getIntParam('id');
        $ret_extra = $this->_deal_share_extra($id,$type);
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
        $pointCfg = $point_model->findUpdateBySid();
        if(!$pointCfg || !$pointCfg['aps_share']){
            $this->outputError('');
        }
        $point_storage = new App_Helper_Point($this->sid);
        $ret = $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_SHARE);
        if($ret && is_array($ret)){
            if(!$ret['errcode']){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => '分享成功，获得'.$ret['point'].'积分',
                    'point'  => $ret['point'],
                );
                $this->outputSuccess($info);
            }else{
                if($ret_extra){

                    $info['data'] = array(
                        'result' => true,
                        'msg'    => '分享成功',
                        'point'  => 0,
                    );
                    $this->outputSuccess($info);
                }else{
                    $this->outputError($ret['errmsg']);
                }
            }
        }elseif($ret){
            $info['data'] = array(
                'result' => true,
                'msg'    => '获取积分成功',
                'point'  => 0,
            );
            $this->outputSuccess($info);
        }elseif ($ret_extra){
            $info['data'] = array(
                'result' => true,
                'msg'    => '分享成功',
                'point'  => 0,
            );
            $this->outputSuccess($info);
        }else{
            $this->outputError('获取积分失败');
        }
    }

    /*
     * 处理分享其它操作
     */
    private function _deal_share_extra($id,$type){
        $res = false;
        if($type == 'menu' && $id){
            $menu_model = new App_Model_Sequence_MysqlSequenceMenuStorage($this->sid);
            $res = $menu_model->addReducePostNum($id,'share');
        }
        return $res;
    }


    /**
     * 签到领取积分
     */
    public function attendanceSignAction(){
        $point_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
        $pointCfg = $point_model->findUpdateBySid();
        if(!$pointCfg){
            $this->outputError('签到活动未配置');
        }
        $point_storage = new App_Helper_Point($this->sid);
        $ret = $point_storage->gainPointBySource($this->uid,App_Helper_Point::POINT_SOURCE_SIGN);
        if($ret && is_array($ret)){
            if(!$ret['errcode']){
                $info['data'] = array(
                    'result' => true,
                    'msg'    => $ret['errmsg'],
                    'point'  => $ret['point'],
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError($ret['errmsg']);
            }
        }else{
            $this->outputError('签到失败');
        }
    }


}
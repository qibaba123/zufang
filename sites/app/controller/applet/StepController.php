<?php
/**
 * 处理收货地址
 */

include_once "sites/app/plugin/weixin/decrypt/wxBizDataCrypt.php";

class App_Controller_Applet_StepController extends App_Controller_Applet_InitController  {

    public function __construct() {
        parent ::__construct();
    }

    /*
     * 步数首页
     */
    public function stepIndexAction(){
        $code = $this->request->getStrParam('code');
        $iv = $this->request->getStrParam('iv');
        $encryptedData = $this->request->getStrParam('encryptedData');
        $stepResult = $this->_get_step($code,$iv,$encryptedData);

        $step = 0;
        if($stepResult['code'] == 0){
            $stepData = json_decode($stepResult['data'],1);
            $step = end($stepData['stepInfoList'])['step'];
            //记录步数
            $this->_deal_step_record($step);

        }

        //检查是否兑换
        $hadRecharge = $this->_check_recharge();
        //获得配置和规则和理论兑换分数
        $cfg_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
        $where[]     = array('name' => 'aps_s_id', 'oper' => '=', 'value' => $this->sid);
        $cfg = $cfg_model->getRow($where);
        $canPoint = 0;
        if($cfg['aps_step'] > 0){
            $canPoint = floor($step/$cfg['aps_step']);
        }
        $canPoint = $cfg['aps_step_total'] > 0 && $cfg['aps_step_total'] <= $canPoint ? $cfg['aps_step_total'] : $canPoint;
        $data = [
            'step' => $step,
            'point' => $this->member['m_points'],
            'hadRecharge' => $hadRecharge > 0 ? 1 : 0,
            'rechargePoint' => intval($hadRecharge),
//            'rechargeOpen' => intval($cfg['aps_step_open']),
            'canPoint' => intval($canPoint),
            'can' => $canPoint > 0 ? 1 : 0,
            'rule' => $cfg['aps_step_rule'] ? plum_parse_img_path_new($cfg['aps_step_rule']) : ''
        ];

        $info['data'] = $data;
        $this->outputSuccess($info);
    }

    /**
     * @param $step
     * @return array|bool
     * 记录或更新步数
     */
    private function _deal_step_record($step){
        //查找是否有当天的记录
        $record_model = new App_Model_Step_MysqlStepRecordStorage($this->sid);
        $record = $record_model->findUpdateByMid($this->member['m_id']);

        $data = [
            'asr_nickname' => $this->member['m_nickname'] ? $this->member['m_nickname'] : $this->member['m_nickname'],
            'asr_avatar' => $this->member['m_avatar'],
            'asr_step' => $step,
            'asr_update_time' => time()
        ];


        if($record){
            $res = $record_model->findUpdateByMid($this->member['m_id'],$data);
        }else{
            $data['asr_s_id'] = $this->sid;
            $data['asr_m_id'] = $this->member['m_id'];
            $res = $record_model->insertValue($data);
        }

        return $res;
    }

    /**
     * @return int
     * 查看今天是否已经兑换
     */
    private function _check_recharge(){
        $inout_model = new App_Model_Point_MysqlInoutStorage($this->sid);
        $where[]    = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[]    = array('name' => 'pi_source', 'oper' => '=', 'value' => App_Helper_Point::POINT_SOURCE_STEP);
        $where[]    = array('name' => 'pi_create_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d')) );
        $row = $inout_model->getRow($where);
        if($row){
            return $row['pi_point'];
        }else{
            return 0;
        }
    }

    /*
     * 步数排行榜
     */
    public function stepRankAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $record_model = new App_Model_Step_MysqlStepRecordStorage($this->sid);
        $where[] = array('name' => 'asr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asr_update_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d')));
        $sort = ['asr_step' => 'DESC','asr_update_time' => 'DESC'];
        $list = $record_model->getList($where,$index,$this->count,$sort);
        if($list){
            $data = [];
            foreach ($list as $val){
                $data[] = [
                    'nickname' => $val['asr_nickname'],
                    'avatar' => $val['asr_avatar'] ? $val['asr_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'step' => $val['asr_step'],
                    'point' => $val['asr_point_today']
                ];
            }
            $info['data']['list'] = $data;

            $rank = $record_model->getRank($this->member['m_id']);
            $record_my = $record_model->findUpdateByMid($this->member['m_id']);

            $my = [
                'nickname' => $record_my['asr_nickname'],
                'avatar' => $record_my['asr_avatar'] ? $record_my['asr_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                'step' => $record_my['asr_step'],
                'point' => $record_my['asr_point_today'],
                'rank' => intval($rank['rowNo']) > 0 ? $rank['rowNo'] : '暂无'
            ];
            $info['data']['my'] = $my;


            $this->outputSuccess($info);

        }else{
            $this->outputError('没有更多信息了');
        }
    }

    /*
     * 兑换积分
     */
    public function rechargePointAction(){
        $step = $this->request->getIntParam('step');
        $hadRecharge = $this->_check_recharge();
        if(!$hadRecharge){
            $cfg_model = new App_Model_Point_MysqlPointSourceStorage($this->sid);
            $where[]     = array('name' => 'aps_s_id', 'oper' => '=', 'value' => $this->sid);
            $cfg = $cfg_model->getRow($where);
            $canPoint = 0;
            if($cfg['aps_step'] > 0){
                $canPoint = floor($step/$cfg['aps_step']);
            }
            $canPoint = $cfg['aps_step_total'] > 0 && $cfg['aps_step_total'] <= $canPoint ? $cfg['aps_step_total'] : $canPoint;
            if($canPoint > 0){
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $res = $member_model->incrementMemberPoint($this->member['m_id'],$canPoint);
                if($res){
                    $point_model = new App_Model_Point_MysqlInoutStorage();
                    $data = array(
                        'pi_s_id'=> $this->sid,
                        'pi_m_id'=> $this->member['m_id'],
                        'pi_type'=> 1,
                        'pi_point'=> $canPoint,
                        'pi_title'=> $step.'步兑换积分'.$canPoint,
                        'pi_source'=>App_Helper_Point::POINT_SOURCE_STEP,
                        'pi_extra' =>'',
                        'pi_create_time'=> time(),
                    );
                    $point_model->insertValue($data);

                    //将积分更新至今日记录
                    $record_model = new App_Model_Step_MysqlStepRecordStorage($this->sid);
                    $record_model->findUpdateByMid($this->member['m_id'],['asr_point_today' => $canPoint]);
                    $info['data'] = [
                        'msg' => '兑换成功'
                    ];
                    $this->outputSuccess($info);

                }else{
                    $this->outputError('兑换失败');
                }
            }else{
                $this->outputError('无法兑换');
            }


        }else{
            $this->outputError('你今天已经兑换过了');
        }
    }

    /*
     * 获得步数
     */
    public function getStepAction(){
        $code = $this->request->getStrParam('code');
        $iv = $this->request->getStrParam('iv');
        $encryptedData = $this->request->getStrParam('encryptedData');

        $auth   = App_Plugin_Weixin_WxxcxClient::weixinAuthType($this->sid);
        if($auth == App_Plugin_Weixin_WxxcxClient::WEIXIN_AUTH_OPEN){
            $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $result    = $wxxcx_client->fetchOpenidByCode($this->applet_cfg['ac_appid'],$code);
        }else{
            $result = App_Helper_WeixinEvent::getWxopenid($this->applet_cfg['ac_appid'],$this->applet_cfg['ac_appsecret'],$code);
        }

        $decrypt = new WXBizDataCrypt($this->applet_cfg['ac_appid'], $result['session_key']);
        $data = '';
        $errCode = $decrypt->decryptData($encryptedData, $iv,$data);
//        $userInfo = [];
//        if($errCode)
        $userInfo = json_decode($data,true);
        $info['data'] = $userInfo;
        $this->outputSuccess($info);
    }

    private function _get_step($code,$iv,$encryptedData){
        $auth   = App_Plugin_Weixin_WxxcxClient::weixinAuthType($this->sid);
        if($auth == App_Plugin_Weixin_WxxcxClient::WEIXIN_AUTH_OPEN){
            $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $result    = $wxxcx_client->fetchOpenidByCode($this->applet_cfg['ac_appid'],$code);
        }else{
            $result = App_Helper_WeixinEvent::getWxopenid($this->applet_cfg['ac_appid'],$this->applet_cfg['ac_appsecret'],$code);
        }

        $decrypt = new WXBizDataCrypt($this->applet_cfg['ac_appid'], $result['session_key']);
        $data = '';
        $errCode = $decrypt->decryptData($encryptedData, $iv,$data);
        $info = array(
            'data' => $data,
            'code' => $errCode
        );
        return $info;
    }


}
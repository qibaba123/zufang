<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/1
 * Time: 下午5:05
 */

class App_Controller_Applet_AgentController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct(true);

    }

    /*
     * 小程序开发咨询
     */
    public function appletConsultationAction(){
        $name = $this->request->getStrParam('name');
        $mobile = $this->request->getStrParam('mobile');
        $profession = $this->request->getStrParam('profession');
        if($name && $mobile){
            if(plum_is_mobile_phone($mobile)){
                //查找小程序所属代理商
                $open_model = new App_Model_Agent_MysqlOpenStorage(0);
                $open = $open_model->getAgentBySid($this->sid);
                $aId = $open['ao_a_id'];
                $data = array(
                    'acl_aa_id'     => $aId,
                    'acl_s_id'      => $this->sid,
                    'acl_name'      => $name,
                    'acl_mobile'    => $mobile,
                    'acl_profession'=> $profession,
                    'acl_create_time' => time()
                );

                $consultation_model = new App_Model_Agent_MysqlAgentConsultationListStorage();
                $res = $consultation_model->insertValue($data);
                if($res){
                    //todo 发送邮件
                    //获得邮箱
                    $oem_model = new App_Model_Agent_MysqlAgentOemStorage();
                    $oem = $oem_model->findOemByAaid($aId);
                    $msgbody= "客户姓名：{$name}；电话：{$mobile}；行业：{$profession}；";
                    if($oem['ao_email'] && plum_is_email($oem['ao_email'])){
                        App_Helper_Tool::sendMail("小程序开发咨询，请及时处理",$msgbody,$oem['ao_email']);
                    }
                    // 发送短信通知
                    $sms_helper = new App_Helper_AgentSms($aId);
                    $sms_helper->sendNoticeSms('zxxcxtz',array('小程序通知，'.$msgbody.'该'));
                    $info['data'] = array(
                        'msg' => '提交成功'
                    );
                    $this->outputSuccess($info);

                }else{
                    $this->outputError('提交失败');
                }
            }else{
                $this->outputError('请填写正确的手机或固话');
            }
        }else{
            $this->outputError('请将信息补充完整');
        }

    }


}

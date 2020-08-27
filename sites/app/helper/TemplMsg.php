<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/23
 * Time: 下午4:52
 */

class App_Helper_TemplMsg{

    private $sid;
    private $shop;

    public function __construct($sid)
    {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }

    private function _filter_illegality_chars($str){
        $escapers = array("\\", "/", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $str);
        return $result;
    }

    /**
     * @param $tplmsg
     * @param $member
     * @param $tpl
     * @param string $page
     * 向单个用户推送消息
     */
    private function _send_msg_to_member($tplmsg, $member, $tpl, $page='',$curr_sid = 0,$appletType = 0){
        if(!empty($member)){
            $this->sid = $curr_sid > 0 ? $curr_sid : $this->sid;
            if($appletType == 5){
                //公众号模板消息
                $tpl = json_decode($tpl, true);
                $weixin_cfg_model = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
                $weixin_cfg = $weixin_cfg_model->findShopCfg();
                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
//                            $jump   = plum_is_url($jump) ? $jump : '';
                $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
                $shop = $shop_model->getRowById($this->sid);
                //暂时先用首页做跳转
                $jump = plum_parse_config('weixin_index','weixin')[$weixin_cfg['ac_type']]."?suid={$shop['s_unique_id']}&appletType=5";

//                if($this->sid == 4546){
//                    $member['m_openid'] = 'ophzYvsk766ScNhPVTyAT3kZYymY';
//                }
//
//                $sendData = $tpl;

                $sendData = [];
                foreach ($tpl as $k => $v){
                    $sendData[$k]  = array(
                        'value' => trim($v['value'], "{}"),
                        'color' => $v['color'],
                    );
                }

                $ret = $weixin_client->sendTemplateMessage($member['m_openid'], $tplmsg['wt_tplid'], $jump, $sendData);
            }else{
                $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);
                $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);

                $where = array();
                $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $member['m_id']);
                $formids = $formids_model->getRow($where);
                $ids = json_decode($formids['af_ids'],true);
                $formid = '';
                foreach($ids as $k => $v){
                    if($v['expire']>time()){
                        $formid = $v['formId'];
                        unset($ids[$k]);
                        $udata = array('af_ids' => json_encode(array_values($ids)));
                        $formids_model->updateById($udata, $formids['af_id']);
                        break 1;
                    }
                }
                if($formid){
                    $tplData = json_decode($tpl, true);
                    //处理数据data
                    $sendData   = array();
                    foreach ($tplData as $value) {
                        $sendData[$value['key']]  = array(
                            'value' => trim($value['contxt'], "{}"),
                            'color' => $value['color'],
                        );
                    }
                    $emphasis   = intval($tplmsg['awt_emphasis']);
                    $weixin_client->sendTemplateMessage($member['m_openid'], $tplmsg['awt_tplid'], $formid, $sendData, $page, $emphasis);
                }
            }
        }
    }

    /**
     * 向所有用户发送消息，并做发送记录
     * @param $tplmsg
     * @param $tpl
     * @param string $page
     * @param $recordField
     * @param $id
     * @param $msgId
     * @param $appletType
     */
    private function _send_msg_to_all_member_old($tplmsg, $tpl, $page='', $recordField, $id, $msgId, $appletType = 0){
        Libs_Log_Logger::outputLog(111,'msg.log');
        $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);

        if($appletType == 5){
            $source = plum_parse_config('menu_type_member_source')[$appletType];
            //推送用户 暂时只区分公众号和其它
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $where_member = [];
            $where_member[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_member[] = ['name' => 'm_source', 'oper' => '=', 'value' => $source];
            $memberList = $member_model->getList($where_member,0,0,[],['m_id','m_openid','m_avatar','m_nickname']);

//            $source = $appletType == 5 ? 1 : 0;
        }else{
            $memberList    = $formids_model->getMemberKeyMid($this->sid,array(),0,0);
        }
      Libs_Log_Logger::outputLog($memberList,'msg.log');
        Libs_Log_Logger::outputLog(222,'msg.log');

        $history_model = new App_Model_Tplmsg_MysqlPushHistoryStorage();
        $historyValue = array(
            'aph_s_id'   => $this->sid,
            $recordField => $id,
            'aph_create_time' => time()
        );
        $hid = $history_model->insertValue($historyValue);
        Libs_Log_Logger::outputLog(333,'msg.log');
        $count = 0;
        $errormsg = '';
        if(!empty($memberList)){
            Libs_Log_Logger::outputLog(444,'msg.log');
//            if($recordField = 'aph_information_id' && $this->sid == 10418){
//                Libs_Log_Logger::outputLog('秒杀推送，有用户','test.log');
//            }
            if($appletType == 5){
                Libs_Log_Logger::outputLog(555,'msg.log');
                $tplData = json_decode($tpl, true);

                $weixin_cfg_model = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
                $weixin_cfg = $weixin_cfg_model->findShopCfg();
                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
//                            $jump   = plum_is_url($jump) ? $jump : '';
                $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
                $shop = $shop_model->getRowById($this->sid);
                //暂时先用首页做跳转
                $jump = plum_parse_config('weixin_index','weixin')[$weixin_cfg['ac_type']]."?suid={$shop['s_unique_id']}&appletType=5";

//                if($this->sid == 4546){
//                    $member['m_openid'] = 'ophzYvsk766ScNhPVTyAT3kZYymY';
//                }
//
//                $sendData = $tpl;

                $sendData = [];
                foreach ($tplData as $k => $v){
                    $sendData[$k]  = array(
                        'value' => trim($v['value'], "{}"),
                        'color' => $v['color'],
                    );
                }
                foreach ($memberList as $val){
                    $ret = $weixin_client->sendTemplateMessage($val['m_openid'], $tplmsg['wt_tplid'], $jump, $sendData);
                    //消息发送成功的才记录
                    if($ret && $ret['errcode'] == 0) {
                        $count++;
                        $nickanme = addslashes($val['m_nickname']);
                        $receiveData[] = "(NULL, {$this->sid}, {$hid},{$msgId}, '{$val['m_openid']}', '{$tplmsg['awt_title']}', '{$val['m_id']}', '{$val['m_avatar']}','{$nickanme}', '1', '{$_SERVER['REQUEST_TIME']}')";
                    }else{
                        $errormsg = $ret['errmsg'];
                    }

                }
                Libs_Log_Logger::outputLog(666,'msg.log');
            }else{
                Libs_Log_Logger::outputLog(777,'msg.log');
                $receiveData = array();
                $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                foreach($memberList as $val){
                    $where = array();
                    $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $val['m_id']);
                    $formids = $formids_model->getRow($where);
                    $ids = json_decode($formids['af_ids'],true);
                    $formid = '';
                    foreach($ids as $k => $v){
                        if($v['expire']>time()){
                            $formid = $v['formId'];
                            unset($ids[$k]);
                            $udata = array('af_ids' => json_encode(array_values($ids)));
                            $formids_model->updateById($udata, $formids['af_id']);
                            break 1;
                        }
                    }
                    if($formid){
                        $tplData = json_decode($tpl, true);
                        //处理数据data
                        $sendData   = array();
                        foreach ($tplData as $value) {
                            $sendData[$value['key']]  = array(
                                'value' => trim($value['contxt'], "{}"),
                                'color' => $value['color'],
                            );
                        }
                        $emphasis   = intval($tplmsg['awt_emphasis']);
                        $ret = $weixin_client->sendTemplateMessage($val['m_openid'],$tplmsg['awt_tplid'],$formid,$sendData,$page, $emphasis);
//                    if($recordField = 'aph_information_id' && $this->sid == 10418){
//                        Libs_Log_Logger::outputLog($ret,'test.log');
//                    }
                        //消息发送成功的才记录
                        if($ret && $ret['errcode'] == 0) {
                            $count++;
                            $nickanme = addslashes($val['m_nickname']);
                            $receiveData[] = "(NULL, {$this->sid}, {$hid},{$msgId}, '{$val['m_openid']}', '{$tplmsg['awt_title']}', '{$val['m_id']}', '{$val['m_avatar']}','{$nickanme}', '1', '{$_SERVER['REQUEST_TIME']}')";
                        }else{
                            $errormsg = $ret['errmsg'];
                        }
                    }
                }
                Libs_Log_Logger::outputLog(888,'msg.log');
            }

            $send_model  = new App_Model_Applet_MysqlWeixinTplMsgSendStorage($this->sid);
            $send_model->insertNewBatch($receiveData);
            Libs_Log_Logger::outputLog(999,'msg.log');
        }else{
            Libs_Log_Logger::outputLog(1000,'msg.log');
            if($recordField = 'aph_information_id' && $this->sid == 4546){
                Libs_Log_Logger::outputLog('咨询推送，无用户','test.log');
            }
        }
        $set['aph_total'] = $count;
        if($count == 0){
            $set['aph_error_msg'] = $errormsg;
        }
        Libs_Log_Logger::outputLog(1001,'msg.log');
        $history_model->updateById($set, $hid);
    }

  
      /**
     * 向所有用户发送消息，并做发送记录
     * @param $tplmsg
     * @param $tpl
     * @param string $page
     * @param $recordField
     * @param $id
     * @param $msgId
     * @param $appletType
     */
    private function _send_msg_to_all_member($tplmsg, $tpl, $page='', $recordField, $id, $msgId, $appletType = 0,$share=''){
        $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);

        if($appletType == 5){
            $source = plum_parse_config('menu_type_member_source')[$appletType];
            //推送用户 暂时只区分公众号和其它
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $where_member = [];
            $where_member[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_member[] = ['name' => 'm_source', 'oper' => '=', 'value' => $source];
            $memberList = $member_model->getList($where_member,0,0,[],['m_id','m_openid','m_avatar','m_nickname']);

//            $source = $appletType == 5 ? 1 : 0;
        }else{
            if(isset($tplmsg['awt_type']) && $tplmsg['awt_type'] == 2){
                $auth_model = new App_Model_Subscribe_MysqlSubscribeAuthStorage($this->sid);
                $memberList    = $auth_model->authMemberList($tplmsg['awt_tplid'],0,0);
                if($this->sid == 9373){
                    Libs_Log_Logger::outputLog($memberList,'ding.log');
                }

            }else{
                $memberList    = $formids_model->getMemberKeyMid($this->sid,array(),0,0);
            }

        }


        $history_model = new App_Model_Tplmsg_MysqlPushHistoryStorage();
        $historyValue = array(
            'aph_s_id'   => $this->sid,
            $recordField => $id,
            'aph_create_time' => time()
        );
        $hid = $history_model->insertValue($historyValue);
        $count = 0;
        $errormsg = '';
        if(!empty($memberList)){

            if($appletType == 5){
                $tplData = json_decode($tpl, true);

                $weixin_cfg_model = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
                $weixin_cfg = $weixin_cfg_model->findShopCfg();
                $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
                $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
                $shop = $shop_model->getRowById($this->sid);
                //暂时先用首页做跳转
                $jump = plum_parse_config('weixin_index','weixin')[$weixin_cfg['ac_type']]."?suid={$shop['s_unique_id']}&appletType=5";


                $sendData = [];
                foreach ($tplData as $k => $v){
                    $sendData[$k]  = array(
                        'value' => trim($v['value'], "{}"),
                        'color' => $v['color'],
                    );
                }

                if($share){
                    $jump .= '&share=/'.$share.'?id='.$id;
                }

                foreach ($memberList as $val){
                    $ret = $weixin_client->sendTemplateMessage($val['m_openid'], $tplmsg['wt_tplid'], $jump, $sendData);
                    //消息发送成功的才记录
                    if($ret && $ret['errcode'] == 0) {
                        $count++;
                        $nickanme = addslashes($val['m_nickname']);
                        $receiveData[] = "(NULL, {$this->sid}, {$hid},{$msgId}, '{$val['m_openid']}', '{$tplmsg['awt_title']}', '{$val['m_id']}', '{$val['m_avatar']}','{$nickanme}', '1', '{$_SERVER['REQUEST_TIME']}')";
                    }else{
                        $errormsg = $ret['errmsg'];
                    }

                }
            }elseif (isset($tplmsg['awt_type']) && $tplmsg['awt_type'] == 2){
              // Libs_Log_Logger::outputLog(111,'msg.log');
                //发送订阅消息
                $tplData = json_decode($tpl, true);
                $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                $sendData = [];
                foreach ($tplData as $v){
//                    $curr_value = trim($v['contxt'], "{}");
                    $sendData[$v['key']]  = [
//                        'value' => trim($v['contxt'], "{}"),
                        'value' => $this->handleSubscribeValue($v['key'],$v['contxt']),
                    ];
                }
                foreach ($memberList as $val){
                    $ret = $weixin_client->sendSubscribeMessage($val['m_openid'],$tplmsg['awt_tplid'],$sendData,$page);
                    if($this->sid == 9373){
                        Libs_Log_Logger::outputLog($ret,'ding.log');
                    }
 					//Libs_Log_Logger::outputLog($ret,'msg.log');
                    if($ret && $ret['errcode'] == 0){
                        $count++;
                        $nickanme = addslashes($val['m_nickname']);
                        $receiveData[] = "(NULL, {$this->sid}, {$hid},{$msgId}, '{$val['m_openid']}', '{$tplmsg['awt_title']}', '{$val['m_id']}', '{$val['m_avatar']}','{$nickanme}', '1', '{$_SERVER['REQUEST_TIME']}')";
                        App_Helper_TemplMsg::reduceSubscribeNum($this->sid,$tplmsg['awt_tplid'],$val['m_openid']);
                    }
                }

            }else{
                $receiveData = array();
                $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                foreach($memberList as $val){
                    $where = array();
                    $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $val['m_id']);
                    $formids = $formids_model->getRow($where);
                    $ids = json_decode($formids['af_ids'],true);
                    $formid = '';
                    foreach($ids as $k => $v){
                        if($v['expire']>time()){
                            $formid = $v['formId'];
                            unset($ids[$k]);
                            $udata = array('af_ids' => json_encode(array_values($ids)));
                            $formids_model->updateById($udata, $formids['af_id']);
                            break 1;
                        }
                    }
                    if($formid){
                        $tplData = json_decode($tpl, true);
                        //处理数据data
                        $sendData   = array();
                        foreach ($tplData as $value) {
                            $sendData[$value['key']]  = array(
                                'value' => trim($value['contxt'], "{}"),
                                'color' => $value['color'],
                            );
                        }
                        $emphasis   = intval($tplmsg['awt_emphasis']);
                        $ret = $weixin_client->sendTemplateMessage($val['m_openid'],$tplmsg['awt_tplid'],$formid,$sendData,$page, $emphasis);

                        //消息发送成功的才记录
                        if($ret && $ret['errcode'] == 0) {
                            $count++;
                            $nickanme = addslashes($val['m_nickname']);
                            $receiveData[] = "(NULL, {$this->sid}, {$hid},{$msgId}, '{$val['m_openid']}', '{$tplmsg['awt_title']}', '{$val['m_id']}', '{$val['m_avatar']}','{$nickanme}', '1', '{$_SERVER['REQUEST_TIME']}')";
                        }else{
                            $errormsg = $ret['errmsg'];
                        }
                    }
                }
            }

            $send_model  = new App_Model_Applet_MysqlWeixinTplMsgSendStorage($this->sid);
            $send_model->insertNewBatch($receiveData);
        }
      // Libs_Log_Logger::outputLog(333,'msg.log');
        $set['aph_total'] = $count;
        if($count == 0){
            $set['aph_error_msg'] = $errormsg;
        }
        $history_model->updateById($set, $hid);
    }
  
  
  
  
    /**
     * 减少模板消息授权次数
     *
     * @param $tplid
     * @param $openid
     * @param $sid
     */
    public static function reduceSubscribeNum($sid,$tplid,$openid){
        $auth_model = new App_Model_Subscribe_MysqlSubscribeAuthStorage($sid);
        $row = $auth_model->fetchRow($openid,$tplid);
        if($row){
            if($row['asa_num'] > 1){
                $set = [
                    'asa_num' => $row['asa_num'] - 1
                ];
                $auth_model->updateById($set,$row['asa_id']);
            }else{
                $auth_model->deleteById($row['asa_id']);
            }
        }
    }



    /**
     * @param $key [参数类型]
     * @param $value [参数值]
     * @return false|string
     * 将有长度限制的非特殊类型值截取
     * 参数规则详见https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.send.html
     */
    public function handleSubscribeValue($key,$value){

        $value = trim($value,"{}");
        $curr_key = preg_replace("/\\d+/",'', $key);
        switch($curr_key){
            case 'thing':
                $value = mb_substr($value,0,20);
                break;
            case 'number':
                if(is_numeric($value)){
                    $value = substr($value,0,3);
                }
                break;
            case 'letter':
                if(preg_match("/^[a-zA-Z\s]+$/",$value)){
                    $value = substr($value,0,32);
                }
                break;
            case 'character_string':
                $m = mb_strlen($value,'utf-8');
                $n = strlen($value);
                if($n == $m){
                    $value = substr($value,0,32);
                }
                break;
            case 'name':
                $m = mb_strlen($value,'utf-8');
                $n = strlen($value);
                if($n == $m){
                    $value = substr($value,0,20);
                }else{
                    $value = mb_substr($value,0,10);
                }
                break;
            case 'phrase':
                $m = mb_strlen($value,'utf-8');
                $n = strlen($value);
                if($n % $m == 0 && $n % 3 == 0){
                    $value = mb_substr($value,0,5);
                }
                break;
        }

        return $value;
    }

  
  
  
    /**
     * 向所有用户发送消息，不做发送记录
     * @param $tplmsg
     * @param $tpl
     * @param string $page
     * @param int $appletType
     */
    private function _send_msg_to_all_member_norecord($tplmsg, $tpl, $page='',$appletType = 0){
        if($appletType == 5){
            $source = plum_parse_config('menu_type_member_source')[$appletType];
            //推送用户 暂时只区分公众号和其它
            $member_model = new App_Model_Member_MysqlMemberCoreStorage();
            $where_member = [];
            $where_member[] = ['name' => 'm_s_id', 'oper' => '=', 'value' => $this->sid];
            $where_member[] = ['name' => 'm_source', 'oper' => '=', 'value' => $source];
            $memberList = $member_model->getList($where_member,0,0,[],['m_id','m_openid','m_avatar','m_nickname']);

            $tplData = json_decode($tpl, true);

            $weixin_cfg_model = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
            $weixin_cfg = $weixin_cfg_model->findShopCfg();
            $weixin_client  = new App_Plugin_Weixin_ClientPlugin($this->sid,5);
//                            $jump   = plum_is_url($jump) ? $jump : '';
            $shop_model = new App_Model_Shop_MysqlShopCoreStorage($this->sid);
            $shop = $shop_model->getRowById($this->sid);
            //暂时先用首页做跳转
            $jump = plum_parse_config('weixin_index','weixin')[$weixin_cfg['ac_type']]."?suid={$shop['s_unique_id']}&appletType=5";

            $sendData = [];
            foreach ($tplData as $k => $v){
                $sendData[$k]  = array(
                    'value' => trim($v['value'], "{}"),
                    'color' => $v['color'],
                );
            }
            foreach ($memberList as $val){
                $ret = $weixin_client->sendTemplateMessage($val['m_openid'], $tplmsg['wt_tplid'], $jump, $sendData);
            }
        }else{
            $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);
            $memberList    = $formids_model->getMemberKeyMid($this->sid,array(),0,0);
            if(!empty($memberList)){
                $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
                foreach($memberList as $val){
                    $where = array();
                    $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $val['m_id']);
                    $formids = $formids_model->getRow($where);
                    $ids = json_decode($formids['af_ids'],true);
                    $formid = '';
                    foreach($ids as $k => $v){
                        if($v['expire']>time()){
                            $formid = $v['formId'];
                            unset($ids[$k]);
                            $udata = array('af_ids' => json_encode(array_values($ids)));
                            $formids_model->updateById($udata, $formids['af_id']);
                            break 1;
                        }
                    }
                    if($formid){
                        $tplData = json_decode($tpl, true);
                        //处理数据data
                        $sendData   = array();
                        foreach ($tplData as $value) {
                            $sendData[$value['key']]  = array(
                                'value' => trim($value['contxt'], "{}"),
                                'color' => $value['color'],
                            );
                        }
                        $emphasis   = intval($tplmsg['awt_emphasis']);
                        $weixin_client->sendTemplateMessage($val['m_openid'],$tplmsg['awt_tplid'],$formid,$sendData,$page, $emphasis);
                    }
                }
            }
        }



    }

    /**
     * @param $id
     * 餐饮排队叫号取号成功通知
     */
    public function sendMealStartQueueTmplmsg($id) {
        $order_queue_model = new App_Model_Meal_MysqlMealOrderQueueStorage($this->sid);
        $queue           = $order_queue_model->getQueueRowWithTable($id);
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($queue['amoq_m_id']);

        $appletType = plum_parse_config('member_source_menu_type')[$member['m_source']];
        $appletType = $appletType ? $appletType : 0;

        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();
        if(isset($setup["aws_meal_start_queue_open"]) && $setup["aws_meal_start_queue_open"] && $setup["aws_meal_start_queue_mid"]) {
            //发送消息模板
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_meal_start_queue_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg         = $tplmsg_model->findOneById($setup["aws_meal_start_queue_mid"]);
            }

            //替换订单数据
            $tpl            = $tplmsg['awt_data'];


            if($queue['amoq_es_id']){
                $shop_storage = new App_Model_Entershop_MysqlEnterShopStorage();
                $enterShop = $shop_storage->getRowById($queue['amoq_es_id']);
                $shopName = $enterShop['es_name'];
            }else{
                $shopName = $this->shop['s_name'];
            }

            $total = $order_queue_model->getQueueCount($queue['amot_id']);
            $before = $order_queue_model->getWaitTotal($queue['amot_id'], time());

            $infor['shopName'] = $shopName;
            $infor['name']   = $queue['amot_table'];
            $infor['number'] = $queue['amoq_number'];
            $infor['status'] = $queue['amoq_status']==1?'排队中':'请就餐';
            $infor['total']  = $total;
            $infor['before'] = $before;
            $infor['time']   = date('Y-m-d H:i:s', $queue['amoq_create_time']);

            $replace_helper   = new App_Helper_ReplaceMsg();
            list($tpl,)       = $replace_helper->replaceMealQueueTpl($infor, $tpl);//替换推送模板变量
            $tpl = $this->_filter_illegality_chars($tpl);
            $page = '';

            //开始推送信息
            $this->_send_msg_to_member($tplmsg, $member, $tpl, $page,0,$appletType);
        }
    }

    /**
     * @param $id
     * 餐饮排队叫号商家叫号通知
     */
    public function sendMealCallQueueTmplmsg($id) {
        $order_queue_model = new App_Model_Meal_MysqlMealOrderQueueStorage($this->sid);
        $queue           = $order_queue_model->getQueueRowWithTable($id);
        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $member = $member_model->getRowById($queue['amoq_m_id']);
        $appletType = plum_parse_config('member_source_menu_type')[$member['m_source']];
        $appletType = $appletType ? $appletType : 0;

        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();
        if(isset($setup["aws_meal_call_queue_open"]) && $setup["aws_meal_call_queue_open"] && $setup["aws_meal_call_queue_mid"]) {
            //发送消息模板
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_meal_call_queue_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg         = $tplmsg_model->findOneById($setup["aws_meal_call_queue_mid"]);
            }

            //替换订单数据
            $tpl            = $tplmsg['awt_data'];
            if($queue['amoq_es_id']){
                $shop_storage = new App_Model_Entershop_MysqlEnterShopStorage();
                $enterShop = $shop_storage->getRowById($queue['amoq_es_id']);
                $shopName = $enterShop['es_name'];
            }else{
                $shopName = $this->shop['s_name'];
            }

            $total = $order_queue_model->getQueueCount($queue['amot_id']);
            $before = $order_queue_model->getWaitTotal($queue['amot_id'], time());

            $infor['shopName'] = $shopName;
            $infor['name']   = $queue['amot_table'];
            $infor['number'] = $queue['amoq_number'];
            $infor['status'] = $queue['amoq_status']==1?'排队中':'已过号';
            $infor['total']  = $total;
            $infor['before'] = $before;
            $infor['time']   = date('Y-m-d H:i:s', $queue['amoq_create_time']);

            $replace_helper   = new App_Helper_ReplaceMsg();
            list($tpl,)       = $replace_helper->replaceMealQueueTpl($infor, $tpl);//替换推送模板变量
            $tpl = $this->_filter_illegality_chars($tpl);
            $page = '';
            //开始推送信息
            $this->_send_msg_to_member($tplmsg, $member, $tpl, $page, 0, $appletType);
        }
    }

    /**
     * @param $id
     * 购买会员卡通知
     */
    public function sendMemberCardTmplmsg($id,$appletType = 0) {
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();
        if(isset($setup["aws_buy_member_card_open"]) && $setup["aws_buy_member_card_open"] && $setup["aws_buy_member_card_mid"]) {
            //发送消息模板
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_buy_member_card_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg         = $tplmsg_model->findOneById($setup["aws_buy_member_card_mid"]);
            }

            //替换订单数据
            $tpl            = $tplmsg['awt_data'];
            $order_storage  = new App_Model_Store_MysqlOrderStorage($this->shop['s_id']);
            $order      = $order_storage->findUpdateOrderByTid($id);

            $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
            $card   = $card_model->getShopOneCard($order['oo_cardid']);

            $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
            $member_card    = $offline_member->findUpdateMemberByMid($order['oo_m_id'], array(), $card['oc_type']);

            $infor['cardName']   = $card['oc_name'];
            $infor['cardNumber'] = $member_card['om_card_num'];
            $infor['expireTime'] = date('Y-m-d', $member_card['om_expire_time']);
            $infor['cardRights'] = str_replace("<br/>", "\n",$card['oc_rights']);
            $infor['cardNotice'] = str_replace("<br/>", "\n",$card['oc_notice']);

            $replace_helper   = new App_Helper_ReplaceMsg();
            list($tpl,)       = $replace_helper->replaceMemberCardTpl($infor, $tpl);//替换推送模板变量
            $tpl = $this->_filter_illegality_chars($tpl);
            $page = '';
            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
            $member = $member_model->getRowById($order['oo_m_id']);
            //开始推送信息
            $this->_send_msg_to_member($tplmsg, $member, $tpl, $page,0,$appletType);
        }
    }

    //职位推送
    public function positionPushTemplmsg($id, $msgId) {
        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($msgId);
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $position_model = new App_Model_Job_MysqlJobPositionStorage(0);
        $job = $position_model->getPositionCategoryById($id);

        $company_model = new App_Model_Job_MysqlJobCompanyStorage(0);
        $company = $company_model->findCompanyByShopId($job['ajp_es_id']);

        $infor['title']     = $job['ajp_title'];
        $infor['cate']      = $job['ajc_name'];
        $infor['company']   = $company['ajc_company_name'];
        $infor['salary']    = $job['ajp_min_salary'].'K-'.$job['ajp_max_salary'].'K';
        $infor['desc']      = $job['ajp_desc'];
        $infor['recommendAward']   = $job['ajp_recommend_pre_award'];
        $infor['entryAward']       = $job['ajp_entry_pre_award'];
        $infor['recommendedAward'] = $job['ajp_recommended_pre_award'];

        $replace_helper   = new App_Helper_ReplaceMsg();
        list($tpl,)       = $replace_helper->replacePositionTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = 'pages/jobDetail/jobDetail?id='.$id;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_position_id', $id, $msgId);
    }

    //充值推送
    public function sendRechargeTmplmsg($tid) {
        //查找当前类型是否开启模板消息
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_recharge_open"]) && $setup["aws_recharge_open"]) {
            $mid    = $setup["aws_recharge_mid"];
            if ($mid) {
                //发送消息模板
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($mid);
                //替换订单数据
                $tpl    = $tplmsg['awt_data'];
                $trade_helper   = new App_Helper_Trade($this->sid);
                $record_storage = new App_Model_Member_MysqlRechargeStorage($this->shop['s_id']);

                $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
                $applet     = $applet_model->findShopCfg();

                $record         = $record_storage->findRecordByTid($tid);
                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($record['rr_m_id']);
                $infor['tid']        = $record['rr_tid'];
                $infor['price']      = $record['rr_amount'];
                $infor['coin']       = $record['rr_gold_coin'];
                $infor['balance']    = $member['m_gold_coin'];
                if($applet['ac_type'] == 28){
                    //内推招聘，余额取店铺余额
                    $enter_shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                    $enter_shop = $enter_shop_model->getRowById($record['rr_es_id']);
                    $infor['balance'] = $enter_shop['es_balance'];
                }

                $infor['time']       = date('Y-m-d H:i:s', $record['rr_create_time']);
                list($tpl,)          = $trade_helper->replaceRechargeTpl($infor, $tpl);//替换推送模板变量
                $tpl = $this->_filter_illegality_chars($tpl);
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, '');
            }
        }
    }

    //退款推送
    public function sendRefundTmplmsg($tid,$toid=0,$appletType = 0) {

        //查找当前类型是否开启模板消息
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
        }

        if (isset($setup["aws_refund_open"]) && $setup["aws_refund_open"]) {
            $mid    = $setup["aws_refund_mid"];
            if ($mid) {
                //发送消息模板
                if($appletType == 5){
                    $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                    $tplmsg['awt_data'] = $tplmsg['wt_data'];
                    $jump   = $tplmsg['wt_url'];
                }else{
                    $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                }

                //替换订单数据
                $tpl    = $tplmsg['awt_data'];
                $trade_helper   = new App_Helper_Trade($this->sid);
                $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                $trade      = $trade_model->findUpdateTradeByTid($tid);
                $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);

                // 单品退款的订单发送单品的商品名称
                // zhangzc
                // 2019-08-16
                if($toid){
                    $order_model=new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                    $order_info=$order_model->getRowById($toid);
                }

                $refund = $refund_model->getFinishTid($tid,$toid);
                $infor['tid']        = $trade['t_tid'];
                $infor['title']      = $toid?$order_info['to_title']:$trade['t_title'];
                $infor['num']        = $trade['t_num'];
                $infor['reason']     = $refund['tr_reason'];
                $infor['totalFee']   = $trade['t_total_fee'];
                $infor['refundFee']  = $refund['tr_money'];
                $infor['payTime']    = date('Y-m-d H:i:s', $trade['t_pay_time']);
                $infor['refundTime'] = date('Y-m-d H:i:s', $refund['tr_finish_time']);
                list($tpl,)          = $trade_helper->replaceRefundTpl($infor, $tpl);//替换推送模板变量
                $tpl = $this->_filter_illegality_chars($tpl);
                //todo 公众号跳转

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($trade['t_m_id']);
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, '',0,$appletType);
            }
        }
    }

    //资讯推送
    public function sendInformationTmplmsg($aid, $mid, $appletType = 0) {
//        if($this->sid == 4546){
//            Libs_Log_Logger::outputLog('执行资讯推送111','test.log');
//            Libs_Log_Logger::outputLog('applettype111'.$appletType,'test.log');
//        }
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
        }

        //替换订单数据
        $tpl    = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $information = $information_storage->getRowById($aid);
        $infor['title']      = $information['ai_title'];
        $infor['time']       = date('Y-m-d H:i', $information['ai_create_time']);
        $infor['desc']       = $information['ai_brief'];
        list($tpl,)          = $trade_helper->replaceInforTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = isset($jump) ? $jump : "pages/informationDetail/informationDetail?id=".$aid;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_information_id', $aid, $mid, $appletType);
    }

    //产品服务推送
    public function sendServiceTmplmsg($ssid, $mid) {
        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($mid);
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $service_model  = new App_Model_Shop_MysqlShopServiceInformationStorage();
        $service        = $service_model->getRowById($ssid);
        $infor['title']      = $service['ss_title'];
        $infor['price']      = $service['ss_price'];
        $infor['desc']       = $service['ss_brief'];
        $infor['label']      = $service['ss_label'];
        $infor['time']       = date('Y-m-d H:i', $service['ss_create_time']);
        list($tpl,)          = $trade_helper->replaceServiceTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/articleDetail/articleDetail?id=".$ssid;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_service_id', $ssid, $mid);
    }

    //抽奖活动推送
    public function sendLotteryTmplmsg($id, $mid, $appletType = 0) {
        //发送消息模板

        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $list_model     = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $lottery        = $list_model->getRowById($id);
        $infor['title'] = $lottery['amll_name'];
        $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->sid);
        $goodsList     = $lottery_model->getListBySid($id, 1);
        $infor['goods'] = '';
        foreach ($goodsList as $val){
            $infor['goods'] .= $val['aml_name'].'、';
        }

        list($tpl,)          = $trade_helper->replaceLotteryTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $applet     = $applet_model->findShopCfg();

        if($applet['ac_type'] == 3){
            $page = "pages/getReward/getReward";
        }else{
            $page = "subpages/getReward/getReward";
        }
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_lottery_id', $id, $mid, $appletType);
    }

    //预约活动推送
    public function sendAppointmentTmplmsg($id, $mid, $appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }


        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods          = $goods_model->getRowById($id);
        $infor['title'] = $goods['g_name'];
        $infor['price'] = $goods['g_price'];
        $infor['long']  = $goods['g_appointment_length'];
        $infor['date']  = $goods['g_appointment_date'];
        $infor['time']  = $goods['g_appointment_time'];
        $infor['brief'] = $goods['g_brief'];
        list($tpl,)     = $trade_helper->replaceAppointmentTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/Generalreservationdetail/Generalreservationdetail?id=".$id;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_appointment_id', $id, $mid, $appletType);

    }

    //版本升级推送
    public function sendUpgradeTmplmsg($mid) {
        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($mid);
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $applet         = $applet_model->findShopCfg();
        $infor['code']  = $applet['ac_version'];
        list($tpl,)     = $trade_helper->replaceUpgradeTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "";
        $this->_send_msg_to_all_member_norecord($tplmsg, $tpl, $page);
    }

    //商品推送
    public function sendGoodsTmplmsg($id, $mid, $appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
        $goods          = $goods_model->getRowById($id);
        $infor['title'] = $goods['g_name'];
        $infor['price'] = $goods['g_price'];
        $infor['oriPrice']  = $goods['g_ori_price'];
        $infor['limit'] = $goods['g_limit'];
        $infor['sold']  = $goods['g_sold'];
        $infor['stock'] = $goods['g_stock'];
        $goods['g_brief'] = '';
        $infor['brief'] = $goods['g_brief'];
        list($tpl,)     = $trade_helper->replaceGoodsTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);
        $page = '';

        if($goods['g_knowledge_pay_type'] == 0){
            //不是知识付费的商品
            $page = "pages/goodDetail/goodDetail?id=".$id;
        }
        if($goods['g_knowledge_pay_type'] == 1){
            // 知识付费图文商品
            $page = "pages/zlDetail/zlDetail?id=".$id;
        }
        if($goods['g_knowledge_pay_type'] == 2){
            //知识付费音频商品
            $page = "pages/audioDetail/audioDetail?id=".$id;
        }
        if($goods['g_knowledge_pay_type'] == 3){
            //知识付费视频商品
            $page = "pages/videoDetail/videoDetail?id=".$id;
        }
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_g_id', $id, $mid,$appletType);
    }

    //社区团购商品到货推送
    public function sendGoodsGetTmplmsg($id, $mid,$leader = 0,$startTime = 0, $endTime = 0) {

        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($mid);
        //替换订单数据

        $sequence_helper   = new App_Helper_Sequence($this->sid);


        $formids_model  = new App_Model_Member_MysqlMemberFormidsStorage($this->sid);

        $history_model = new App_Model_Tplmsg_MysqlPushHistoryStorage();
        $historyValue = array(
            'aph_s_id' => $this->sid,
            'aph_g_id' => $id,
            'aph_create_time' => time()
        );
        $hid = $history_model->insertValue($historyValue);
        $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);

        $where_get = [];
        $where_get[] = ['name' => 'to_s_id', 'oper' => '=', 'value' => $this->sid];
        $where_get[] = ['name' => 'to_g_id', 'oper' => '=', 'value' => $id];
        $where_get[] = ['name' => 'to_se_verify', 'oper' => '=', 'value' => 0];
        $where_get[] = ['name' => 'to_se_refund', 'oper' => '=', 'value' => 0];
        $where_get[] = ['name' => 't_status', 'oper' => 'in', 'value' => [3,4,5]];
        if($leader && $startTime && $endTime){
            $where_get[] = ['name' => 't_se_leader', 'oper' => '=', 'value' => $leader];
            $where_get[] = ['name' => 'to_create_time', 'oper' => '>=', 'value' => $startTime];
            $where_get[] = ['name' => 'to_create_time', 'oper' => '<=', 'value' => $endTime];
        }
        $order_list = $order_model->getGoodsListSequence($where_get);
        if(!empty($order_list)){

            $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->sid);
            $count = 0;
            $receiveData = array();
            $mids = [];
            foreach ($order_list as $val){
                if(!in_array($val['m_id'],$mids)){
                    $mids[] = $val['m_id'];
                    $infor = [];
                    $tpl   = $tplmsg['awt_data'];
                    $infor['title'] = $val['g_name'];
                    $infor['price'] = $val['to_total'];
                    $infor['tid'] = $val['t_tid'];
                    $infor['createTime'] = date('Y-m-d',$val['t_create_time']);
                    $infor['sendTime'] = $val['to_se_send_time'] > 0 ? date('Y-m-d',$val['to_se_send_time']) : ($val['t_se_send_time'] ? date('Y-m-d',$val['t_se_send_time']) : '');
                    $infor['address'] = $val['asc_address'] ? $val['asc_address'].($val['asc_address_detail'] ? $val['asc_address_detail'] : '') : '';


                    list($tpl,)     = $sequence_helper->replaceGoodsGetTpl($infor, $tpl);//替换推送模板变量
                    $tpl = str_replace("\n", "\\n",$tpl);
                    $tpl = str_replace("\t", "",$tpl);
                    $tpl = str_replace("•", "",$tpl);

                    $where = array();
                    $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'af_m_id', 'oper' => '=', 'value' => $val['m_id']);
                    $formids = $formids_model->getRow($where);
                    $ids = json_decode($formids['af_ids'],true);
                    $formid = '';
                    foreach($ids as $k => $v){
                        if($v['expire']>time()){
                            $formid = $v['formId'];
                            unset($ids[$k]);
                            $udata = array('af_ids' => json_encode(array_values($ids)));
                            $formids_model->updateById($udata, $formids['af_id']);
                            break 1;
                        }
                    }
                    if($formid){
                        $tplData = json_decode($tpl, true);
                        //处理数据data
                        $sendData   = array();
                        foreach ($tplData as $value) {
                            $sendData[$value['key']]  = array(
                                'value' => trim($value['contxt'], "{}"),
                                'color' => $value['color'],
                            );
                        }
                        $emphasis   = intval($tplmsg['awt_emphasis']);

                        $page = "subpages/orderDetail/orderDetail?tid=".$val['t_tid'];
                        $ret = $weixin_client->sendTemplateMessage($val['m_openid'],$tplmsg['awt_tplid'],$formid,$sendData,$page, $emphasis);
                        if($ret && $ret['errcode'] == 0) {
                            $count++;
                            $nickanme = addslashes($val['m_nickname']);
                            $receiveData[] = "(NULL, {$this->sid}, {$hid},{$mid}, '{$val['m_openid']}', '{$tplmsg['awt_title']}', '{$val['m_id']}', '{$val['m_avatar']}','{$nickanme}', '1', '{$_SERVER['REQUEST_TIME']}')";
                        }
                    }
                }
            }

            $set['aph_total'] = $count;
            $history_model->updateById($set, $hid);
            $send_model  = new App_Model_Applet_MysqlWeixinTplMsgSendStorage($this->sid);
            $send_model->insertNewBatch($receiveData);
        }

    }

    //拼团活动推送
    public function sendGroupTmplmsg($id, $mid,$appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $group_model    = new App_Model_Group_MysqlBuyStorage($this->sid);

        if($appletType == 5){
            $cfg_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
        }else{
            $cfg_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        }
        $cfg = $cfg_model->findShopCfg();

        if($cfg['ac_type'] == 12){
            $group        = $group_model->fetchCourseGroupGoods($id);
            $group['g_name'] = $group['atc_title'];
        }else{
            $group        = $group_model->fetchGroupGoods($id);
        }
        $infor['title'] = $group['g_name'];
        $infor['rule']  = $group['gb_act_rule'];
        $infor['tzPrice'] = $group['gb_tz_price'];
        $infor['price'] = $group['gb_price'];
        $infor['total'] = $group['gb_total'];
        $infor['startTime'] = date('Y-m-d H:i:s', $group['gb_start_time']);
        $infor['endTime']   = date('Y-m-d H:i:s', $group['gb_end_time']);
        list($tpl,)     = $trade_helper->replaceGroupActTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/groupGoodDetail/groupGoodDetail?goodid=".$id;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_group_id', $id, $mid,$appletType);
    }

    //秒杀活动推送
    public function sendLimitTmplmsg($id, $mid,$appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $act_model      = new App_Model_Limit_MysqlLimitActStorage($this->sid);
        $limit          = $act_model->getRowById($id);
        $infor['title'] = $limit['la_name'];
        $infor['startTime'] = date('Y-m-d H:i:s', $limit['la_start_time']);
        $infor['endTime'] = date('Y-m-d H:i:s', $limit['la_end_time']);
        $infor['label'] = $limit['la_label'];
        list($tpl,)     = $trade_helper->replaceLimitActTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/seckillPage/seckillPage";
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_limit_id', $id, $mid,$appletType);
    }

    //砍价活动推送
    public function sendBargainTmplmsg($id, $mid,$appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }

        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);

        if($appletType == 5){
            $cfg_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
        }else{
            $cfg_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        }
        $cfg = $cfg_model->findShopCfg();

        if($cfg['ac_type'] == 12){
            $bargain        = $bargain_model->getCourseActivityById($id);
            $bargain['g_name'] = $bargain['atc_title'];
        }else{
            $bargain        = $bargain_model->getActivityById($id);
        }

        $infor['title'] = $bargain['g_name'];
        $infor['buyPrice']  = $bargain['ba_buy_price_limit'];
        $infor['kjPrice']   = $bargain['ba_kj_price_limit'];
        $infor['startTime'] = date('Y-m-d H:i:s', $bargain['ba_start_time']);
        $infor['endTime']   = date('Y-m-d H:i:s', $bargain['ba_end_time']);
        list($tpl,)     = $trade_helper->replaceBargainActTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "subpages/bargainGoodDetail/bargainGoodDetail?id=".$id;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_bargain_id', $id, $mid,$appletType);
    }

    //帖子推送
    public function sendPostTmplmsg($id, $mid, $appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }

        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);

        if($appletType == 5){
            $applet_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
        }else{
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        }
        $applet     = $applet_model->findShopCfg();
        if($applet['ac_type'] == 6){
            $post_storage = new App_Model_City_MysqlCityPostStorage($this->sid);
            $post        = $post_storage->getPostRowMemberDistance($id);
            $recordField = 'aph_post_id';
        }else{
            $post_storage = new App_Model_Community_MysqlCommunityPostStorage($this->sid);
            $post        = $post_storage->getPostRowMember($id);
            $recordField = 'aph_cpost_id';
        }
        $infor['nickname']  = $post['m_nickname'];
        $infor['content']   = mb_substr($post['acp_content'],0,150, 'utf-8');
        $infor['time']      = date('Y-m-d H:i:s', $post['acp_create_time']);

        list($tpl,)     = $trade_helper->replacePostTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/postDetail/postDetail?id=".$id;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, $recordField, $id, $mid,$appletType);
    }

    //店铺推送
    public function sendShopTmplmsg($id, $mid, $appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }

        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        if($appletType == 5){
            $applet_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
        }else{
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        }
        $applet     = $applet_model->findShopCfg();
        if($applet['ac_type'] == 8){
            $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
            $shop = $shop_model->getRowById($id);
            $infor['name']      = $shop['es_name'];
            $infor['address']   = $shop['es_addr'];
            $infor['phone']     = $shop['es_phone'];
            $recordField = 'aph_cshop_id';
            $page = "pages/shopDetail/shopDetail?id=".$id;
        }else{
            $shop_model = new App_Model_City_MysqlCityShopStorage($this->sid);
            $shop = $shop_model->getRowById($id);
            $infor['name']      = $shop['acs_name'];
            $infor['address']   = $shop['acs_address'];
            $infor['phone']     = $shop['acs_mobile'];
            $recordField = 'aph_shop_id';
            $page = "pages/shopDetailnew/shopDetailnew?id=".$id;
        }
        list($tpl,)     = $trade_helper->replaceShopTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, $recordField, $id, $mid, $appletType);
    }

    //优惠券推送
    public function sendCouponTmplmsg($id, $mid, $appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }

        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
        $coupon = $coupon_model->getRowById($id);

        if($appletType == 5){
            $applet_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
        }else{
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
        }

        $applet     = $applet_model->findShopCfg();
        $infor['title']     = $coupon['cl_name'];
        $infor['value']     = $coupon['cl_face_val'];
        $infor['limit']     = $coupon['cl_use_limit'];
        $infor['count']     = $coupon['cl_count'];
        $infor['receive']   = $coupon['cl_had_receive'];
        $infor['rlimit']    = $coupon['cl_receive_limit'];
        $infor['startTime'] = date('Y-m-d H:i:s', $coupon['cl_start_time']);
        $infor['endTime']   = date('Y-m-d H:i:s', $coupon['cl_end_time']);
        list($tpl,)     = $trade_helper->replaceCouponTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        if($applet['ac_type'] == 8){
            $page = "pages/couponCenter/couponCenter?title=领券中心";
        }elseif($applet['ac_type'] == 13){
            $page = "pages/discount/discount";
        }elseif($applet['ac_type'] == 1 || $applet['ac_type'] == 24){
            $page = "pages/couponList/couponList";
        }elseif($applet['ac_type'] == 21 ){
            $page = "subpages/couponList/couponList";
        }elseif($applet['ac_type'] == 6){
            $page = "pages/nearby/nearby";
        }else{
            $page = "";
        }

        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_coupon_id', $id, $mid,$appletType);
    }

    //答题推送
    public function sendAnswerTmplmsg($mid,$appletType = 0) {
        //发送消息模板
        if($appletType == 5){
            $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($mid);
            $tplmsg['awt_data'] = $tplmsg['wt_data'];
            $jump   = $tplmsg['wt_url'];
        }else{
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg         = $tplmsg_model->findOneById($mid);
        }

        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $cfg_model      = new App_Model_Answer_MysqlAnswerCfgStorage($this->sid);
        $answer         = $cfg_model->fetchUpdateCfg();
        $infor['time']      = $answer['asc_open_time'].'-'.$answer['asc_end_time'];
        $infor['shareNum']  = $answer['asc_share_num'];
        $infor['allowNum']  = $answer['asc_allow_card'];
        $infor['phone']     = $answer['asc_award_phone'];

        list($tpl,)     = $trade_helper->replaceAnswerTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "subpages/questionIndex/questionIndex";
        $this->_send_msg_to_all_member_norecord($tplmsg, $tpl, $page);
    }

    //动态推送
    public function sendDynamicTmplmsg($id, $mid) {
        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($mid);
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $dynamic_storage = new App_Model_Smart_MysqlStoreDynamicStorage($this->sid);
        $dynamic = $dynamic_storage->getRowById($id);
        $infor['label'] = $dynamic['asd_sign1'].'、'.$dynamic['asd_sign2'].'、'.$dynamic['asd_sign3'];
        $infor['desc']  = $dynamic['asd_detail'];

        list($tpl,)     = $trade_helper->replaceDynamicTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/shopDynamic/shopDynamic";
        $this->_send_msg_to_all_member_norecord($tplmsg, $tpl, $page);
    }

    //帖子赞赏
    public function sendPostRewardTmplmsg($id,$appletType = 0) {

        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_reward_open"]) && $setup["aws_reward_open"] && $setup["aws_reward_mid"]) {

            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_reward_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_reward_mid"]);
            }


            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $reward_storage = new App_Model_Applet_MysqlAppletRewardRecordStorage($this->shop['s_id']);
                $reward = $reward_storage->fetchRewardMemberRow($id);
                $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
                $post = $post_model->getRowById($reward['arr_corr_id']);
                $rewardData = array(
                    'content'   => $post['acp_content'],
                    'member'    => $reward['m_nickname'],
                    'money'     => $reward['arr_money'],
                    'time'      => date("Y-m-d H:i", $reward['arr_create_time'])
                );
                list($tpl,)    = $trade_helper->replacePostRewardTpl($rewardData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($post['acp_m_id']);

                $page = "pages/postDetail/postDetail?id=".$post['acp_id'];
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page,0,$appletType);
            }
        }
    }

    //砍价完成推送
    public function bargainCompleteTempl($aid, $mid, $type) {
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        $bargain      = $bargain_model->getActivityById($aid);
        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $record     = $join_storage->findJoinerByAidMid($aid, $mid);

        if ($bargain && $bargain["ba_{$type}_msgid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($bargain["ba_{$type}_msgid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $bargain = array(
                    'goods'     => $bargain['g_name'],
                    'minPrice'  => $bargain['ba_kj_price_limit'],
                    'helperNum' => $record['bj_total'],
                    'helperMoney' => $record['bj_amount'],
                    'startTime' => date("Y-m-d H:i", $bargain['ba_start_time']),
                    'endTime'   => date("Y-m-d H:i", $bargain['ba_end_time'])
                );
                list($tpl,)    = $trade_helper->replaceBargainCompleteTpl($bargain, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($mid);

                $page = "subpages/bargainGoodDetail/bargainGoodDetail?id=".$aid;
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    //砍价帮砍成功推送
    public function bargainHelperTempl($helperid, $aid, $mid) {
        $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        $bargain      = $bargain_model->getActivityById($aid);

        if ($bargain && $bargain["ba_bkcg_msgid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($bargain["ba_bkcg_msgid"]);

            $effort_storage = new App_Model_Bargain_MysqlEffortStorage($this->sid);
            $helper = $effort_storage->getRowById($helperid);

            $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
            $record     = $join_storage->getRowById($helper['be_j_id']);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $bargain = array(
                    'goods'     => $bargain['g_name'],
                    'helperMember' => $helper['be_m_nickname'],
                    'helperMoney'  => $helper['be_money'],
                    'leftMoney' => $bargain['ba_price'] - $bargain['ba_kj_price_limit'] - $record['bj_amount'],
                    'minPrice'  => $bargain['ba_kj_price_limit'],
                    'helperNum' => $record['bj_total'],
                    'helperTotalMoney' => $record['bj_amount']
                );
                list($tpl,)    = $trade_helper->replaceBargainHelperTpl($bargain, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($mid);

                $page = "subpages/bargainGoodDetail/bargainGoodDetail?id=".$aid;
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    //工单创建推送
    public function workorderCreateTempl($id, $type) {
        //查找当前类型是否开启模板消息
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_work_order_".$type."_open"]) && $setup["aws_work_order_".$type."_open"] && $setup["aws_work_order_".$type."_mid"]) {

            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_work_order_".$type."_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换工单数据
                $tpl    = $tplmsg['awt_data'];
                $order_model = new App_Model_Workorder_MysqlWorkOrderStorage($this->sid);
                $order       = $order_model->getRowById($id);
                $statusNote  = array(1 => '待受理', 2 => '已受理', 3 => '已完成');
                $orderData = array(
                    'type'       => $order['awo_type'],
                    'title'      => $order['awo_title'],
                    'content'    => $order['awo_content'],
                    'status'     => $statusNote[$order['awo_status']],
                    'createTime' => date("Y-m-d H:i", $order['awo_create_time']),
                    'dealTime'   => $order['awo_deal_time']?date("Y-m-d H:i", $order['awo_deal_time']):'',
                );
                list($tpl,)    = $trade_helper->replaceOrderCreateTpl($orderData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($order['awo_m_id']);

                $page = "pages/workorderDetail/workorderDetail?id=".$id;
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }

        }
    }

    //工单评论推送
    public function workorderCommentTempl($id) {
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_work_order_comment_open"]) && $setup["aws_work_order_comment_open"] && $setup["aws_work_order_comment_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_work_order_comment_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $comment_model = new App_Model_Workorder_MysqlWorkorderCommentStorage();
                $comment = $comment_model->getCommentOrderMemberRow($id);
                $statusNote  = array(1 => '待受理', 2 => '已受理', 3 => '已完成');
                $commentData = array(
                    'title'     => $comment['awo_title'],
                    'status'    => $statusNote[$comment['awo_status']],
                    'commenter' => $comment['m_nickname'],
                    'content'   => $comment['awoc_content'],
                    'time'      => date("Y-m-d H:i", $comment['awoc_create_time'])
                );
                list($tpl,)    = $trade_helper->replaceOrderCommentTpl($commentData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($comment['awo_m_id']);

                $page = "pages/workorderDetail/workorderDetail?id=".$comment['awoc_order_id'];
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    //招聘投递状态变化
    public function sendStatusChangeTempl($id, $from) {
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_job_send_change_open"]) && $setup["aws_job_send_change_open"] && $setup["aws_job_send_change_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_job_send_change_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $send_model = new App_Model_Job_MysqlJobSendStorage($this->sid);
                $send = $send_model->fetchSendPositionCompanyDetail($id);
                $sendStatusSelect = plum_parse_config('sendStatusSelect', 'jobcfg');
                $commentData = array(
                    'title'     => $send['ajp_title'],
                    'company'   => $send['ajc_company_name'],
                    'status'    => $sendStatusSelect[$send['ajs_status']],
                    'time'      => date("Y-m-d H:i", $send['ajs_update_time'])
                );
                list($tpl,)    = $trade_helper->replaceSendStatusChangeTpl($commentData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $memberList = array();
                if($from == 'seeker'){
                    $bind_model = new App_Model_Job_MysqlJobBindStorage($this->sid);
                    $where = array();
                    $where[] = array('name' => 'ajb_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'ajb_es_id', 'oper' => '=', 'value' => $send['ajc_es_id']);
                    $bindList = $bind_model->getList($where, 0, 0);
                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    foreach ($bindList as $value){
                        $memberList[] = $member_model->getRowById($value['ajb_m_id']);
                    }
                    $page = "subpages0/resumeDetail/resumeDetail?id=".$id;
                }else{
                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    $member         = $member_model->getRowById($send['ajs_m_id']);
                    $memberList[] = $member;
                    $page = "pages/wode/wode";
                }

                if ($memberList) {;
                    foreach($memberList as $val){
                        $this->_send_msg_to_member($tplmsg, $val, $tpl, $page);
                    }
                }
            }
        }
    }


    //招聘推荐成功
    public function recommendSuccessTempl($id) {
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_job_recommend_success_open"]) && $setup["aws_job_recommend_success_open"] && $setup["aws_job_recommend_success_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_job_recommend_success_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $send_model = new App_Model_Job_MysqlJobSendStorage($this->sid);
                $send = $send_model->fetchSendPositionCompanyDetail($id);
                $relation_model = new App_Model_Job_MysqlJobRelationStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'ajr_ajs_id', 'oper' => '=', 'value' => $id);
                $where[] = array('name' => 'ajr_ajp_id', 'oper' => '=', 'value' => $send['ajs_ajp_id']);
                $where[] = array('name' => 'ajr_f1_mid', 'oper' => '=', 'value' => $send['ajs_f1_mid']);
                $relation = $relation_model->getRow($where);
                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($relation['ajr_mid']);
                $commentData = array(
                    'ninckname' => $member['m_nickname'],
                    'position'  => $send['ajp_title'],
                    'time'      => date("Y-m-d H:i", $relation['ajr_create_time'])
                );
                list($tpl,)    = $trade_helper->replaceRecommendSuccessTpl($commentData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $member         = $member_model->getRowById($send['ajs_f1_mid']);
                $page = "pages/workorderDetail/workorderDetail?id=".$send['ajs_id'].'&mid='.$send['ajs_m_id'];
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }


    // 简历被查看推送
    public function resumeShowTemplmsg($rid, $esId){
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_job_resume_show_open"]) && $setup["aws_job_resume_show_open"] && $setup["aws_job_resume_show_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_job_resume_show_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换简历被浏览数据
                $tpl    = $tplmsg['awt_data'];
                $resume_model = new App_Model_Job_MysqlJobResumeStorage($this->sid);
                $resume = $resume_model->getRowById($rid);
                $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->sid);
                $company  = $company_model->findCompanyByShopId($esId);

                $commentData = array(
                    'company'   => $company['ajc_company_name'],
                    'date'      => date('Y-m-d H:i', time()),
                    'showTimes' => $resume['ajr_show_num']
                );
                list($tpl,)    = $trade_helper->replaceResumeShowTpl($commentData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($resume['ajr_m_id']);

                $page = "";
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    //房源推送
    public function sendrResourceTmplmsg($id, $mid) {
        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($mid);
        //替换订单数据
        $tpl            = $tplmsg['awt_data'];
        $trade_helper   = new App_Helper_Trade($this->sid);
        $resource_model = new App_Model_Resources_MysqlResourcesStorage();
        $resource       = $resource_model->getRowById($id);
        $infor['title'] = $resource['ahr_title'];   //标题
        $infor['area']  = $resource['ahr_area'].'平方米';    //面积
        $infor['price'] = $resource['ahr_price'].($resource['ahr_sale_type'] == 1 ? '万元' : '元/月');   //售价
        $infor['housetype']   = $resource['ahr_home_num'].'室'.$resource['ahr_hall_num'].'厅'.$resource['ahr_toilet_num'].'卫';    //户型
        $infor['orientation'] = $resource['ahr_orientation'];   //朝向
        $infor['community']   = $resource['ahr_community'];     //小区
        $infor['saletype']    = $resource['ahr_sale_type'] == 1 ? '出售' : '出租';     //出租出售类型
        list($tpl,)     = $trade_helper->resourcesInforTpl($infor, $tpl);//替换推送模板变量
        $tpl = $this->_filter_illegality_chars($tpl);

        $page = "pages/houseDetail/houseDetail?id=".$id;
        $this->_send_msg_to_all_member($tplmsg, $tpl, $page, 'aph_house_id', $id, $mid);
    }

    //分销佣金通知
    public function deductTempl($odId,$appletType = 0) {
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
            $cfg_model = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
            $cfg = $cfg_model->findShopCfg();
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
            $cfg_model = new App_Model_Applet_MysqlCfgStorage($this->sid);
            $cfg = $cfg_model->findShopCfg();
        }

        if (isset($setup["aws_deduct_open"]) && $setup["aws_deduct_open"] && $setup["aws_deduct_mid"]) {

            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_deduct_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_deduct_mid"]);
            }

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $deduct_model = new App_Model_Shop_MysqlOrderDeductStorage($this->sid);
                $where = array();
                $where[] = array('name' => 'od_id', 'oper' => '=', 'value' => $odId);

                if($cfg['ac_type'] == 12){
                    $deduct = $deduct_model->getCourseOrderDeductRow($where);
                    $deduct['g_name'] = $deduct['g_name'] && $deduct['g_s_id'] == $this->sid ? $deduct['g_name'] : $deduct['atc_title'];
                }else{
                    $deduct = $deduct_model->getOrderDeductRow($where);
                }

                $deductStatus = array('待返现', '已返现', '退款收回返现');
                $deductData = array();
                for($i = 0; $i <= 3; $i++){
                    $deductData[$i] = array(
                        'mid'       => $deduct['od_'.$i.'f_id'],
                        'tid'       => $deduct['od_tid'],
                        'goods'     => $deduct['g_name'],
                        'member'    => $deduct['m0_nickname'],
                        'amount'    => $deduct['od_amount'],
                        'deduct'    => $deduct['od_'.$i.'f_deduct'],
                        'status'    => $deductStatus[$deduct['od_status']],
                    );
                }

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                foreach ($deductData as $value){
                    if($value['mid'] && $value['deduct'] > 0){
                        $tpl    = $tplmsg['awt_data'];
                        list($tpl,)    = $trade_helper->replaceDeductTpl($value, $tpl);
                        $tpl = $this->_filter_illegality_chars($tpl);
                        $member         = $member_model->getRowById($value['mid']);
                        $this->_send_msg_to_member($tplmsg, $member, $tpl, '', 0, $appletType);
                    }
                }
            }
        }
    }

    //私信通知
    public function chatNoticeTmplmsg($id,$appletType = 0) {
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_chat_open"]) && $setup["aws_chat_open"] && $setup["aws_chat_mid"]) {

            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_chat_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_chat_mid"]);
            }


            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $msg_model = new App_Model_Car_MysqlCarChatMsgStorage($this->sid);
                $msg = $msg_model->getRowById($id);
                if($appletType == 5){
                    $applet_model   = new App_Model_Weixin_MysqlWeixinCfgStorage($this->sid);
                }else{
                    $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->sid);
                }
                $applet     = $applet_model->findShopCfg();
                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $company_model = new App_Model_Job_MysqlJobCompanyStorage($this->sid);

                if($msg['accm_from'] == 1){  //会员发出的信息
                    $member         = $member_model->getRowById($msg['accm_m_id']);
                    $msgData = array(
                        'member'    => $member['m_nickname'],
                        'content'   => $msg['accm_content'],
                        'time'      => date("Y-m-d H:i", $msg['accm_create_time'])
                    );
                }else{
                    $company = $company_model->getRowById($msg['accm_m_id']);
                    //公司发出的信息
                    $msgData = array(
                        'member'    => $company['ajc_company_name'],
                        'content'   => $msg['accm_content'],
                        'time'      => date("Y-m-d H:i", $msg['accm_create_time'])
                    );
                }

                list($tpl,)    = $trade_helper->replaceChatNoticeTpl($msgData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $memberList = array();
                if($applet['ac_type'] == 28 && $msg['accm_from'] == 1){ //内推招聘  会员发出的信息，通知公司
                    $company = $company_model->getRowById($msg['accm_to_mid']);
                    $bind_model = new App_Model_Job_MysqlJobBindStorage($this->sid);
                    $where = array();
                    $where[] = array('name' => 'ajb_s_id', 'oper' => '=', 'value' => $this->sid);
                    $where[] = array('name' => 'ajb_es_id', 'oper' => '=', 'value' => $company['ajc_es_id']);
                    $bindList = $bind_model->getList($where, 0, 0);
                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    foreach ($bindList as $value){
                        $memberList[] = $member_model->getRowById($value['ajb_m_id']);
                    }
                }else{
                    $member  = $member_model->getRowById($msg['accm_to_mid']);
                    $memberList[] = $member;
                }

                $page = '';
                if($applet['ac_type'] == 6){
                    $page = "subpages0/messageList/messageList";
                }
                if($applet['ac_type'] == 33){
                    $page = "pages/postDetail/postDetail";
                }
                if($applet['ac_type'] == 28){
                    $page = "subpages/messageList/messageList?from=".($msg['accm_from'] == 1?'company':'member');
                }
                foreach ($memberList as $val){
                    $this->_send_msg_to_member($tplmsg, $val, $tpl, $page,0,$appletType);
                }
            }
        }
    }

    //社区团购
    public function sequenceTempl($tid,$type) {
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_{$type}_open"]) && $setup["aws_{$type}_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_{$type}_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $trade_model = new App_Model_Trade_MysqlTradeStorage();
                //9373
                $trade = $trade_model->getSequenceTradeRowNew($tid);

                $uid   = $trade['t_m_id'];
                $replace['leaderName'] = $trade['asl_name'];
                $replace['leaderMobile'] = $trade['asl_mobile'];
                $replace['community'] = $trade['asc_name'];
                $replace['tid'] = $tid;
                $replace['createTime'] = date('Y-m-d H:i:s',$trade['t_create_time']);
                $replace['finishTime'] = date('Y-m-d H:i:s',$trade['t_finish_time']);
                $replace['title'] = $trade['t_title'];
                $replace['totalFee'] = $trade['t_total_fee'];
                $replace['postFee'] = $trade['t_post_fee'];

                list($tpl, )    = $trade_helper->replaceSequenceTpl($replace, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($uid);

                $page = "subpages/orderDetail/orderDetail?tid=".$tid;
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    //私信通知
    public function legworkShareTmplmsg($id) {
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_share_success_open"]) && $setup["aws_share_success_open"] && $setup["aws_share_success_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_share_success_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $open_model = new App_Model_Legwork_MysqlLegworkShareOpenStorage($this->sid);
                $openRow = $open_model->getRowById($id);

                $where_open[] =  array('name' => 'also_s_id', 'oper' => '=', 'value' => $this->sid);
                $where_open[] =  array('name' => 'also_share_mid', 'oper' => '=', 'value' => $openRow['also_share_mid']);
                $open_total = $open_model->getCount($where_open);
                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($openRow['also_m_id']);
                $msgData = array(
                    'member'    => $member['m_nickname'],
                    'money'     => $openRow['also_money'],
                    'total'     => $open_total ? intval($open_total): 1,
                    'time'      => date("Y-m-d H:i", $openRow['also_create_time'])
                );
                list($tpl,)    = $trade_helper->replaceChatNoticeTpl($msgData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member         = $member_model->getRowById($openRow['also_share_mid']);

                $this->_send_msg_to_member($tplmsg, $member, $tpl, '');
            }
        }
    }

    //跑腿 订单相关推送
    public function legworkTradeTempl($tid,$type) {
        $trade_model = new App_Model_Legwork_MysqlLegworkTradeStorage($this->sid);
        $trade = $trade_model->getTradeRow($tid);
        $curr_sid = $this->sid;
        if($trade['alt_other_sid'] > 0){
            $curr_sid = $trade['alt_other_sid'];
        }

        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($curr_sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_{$type}_open"]) && $setup["aws_{$type}_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($curr_sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_{$type}_mid"]);

            if ($tplmsg) {
                $legwork_helper   = new App_Helper_Legwork($curr_sid);
                $tpl    = $tplmsg['awt_data'];


                $status_note = App_Helper_Legwork::$trade_status_note;
                if($trade['alt_type'] == App_Helper_Legwork::TRADE_TYPE_BUY){
                    $status_note[App_Helper_Legwork::TRADE_HAD_TAKE] = '待买货';
                    $status_note[App_Helper_Legwork::TRADE_HAD_GET] = '已买货';
                    //$timeNote = '立即购买';
                }else{
                    $status_note[App_Helper_Legwork::TRADE_HAD_TAKE] = '待取货';
                    $status_note[App_Helper_Legwork::TRADE_HAD_GET] = '已取货';
                    //$timeNote = '立即送达';
                }
                $cancelNote = '';
                if($trade['alt_cancel_type'] == 1){
                    $status_note[App_Helper_Legwork::TRADE_CLOSED] = $cancelNote = '用户取消';

                }elseif ($trade['alt_cancel_type'] == 2){
                    $status_note[App_Helper_Legwork::TRADE_CLOSED] = $cancelNote = '平台取消';
                }

                $uid   = $trade['alt_m_id'];
                $replace['tid'] = $trade['alt_other_tid'] ? $trade['alt_other_tid'] : $trade['alt_tid'];
                $replace['totalFee'] = $trade['alt_total_fee'];
                $replace['createTime'] = date('Y-m-d H:i:s',$trade['alt_create_time']);
                $replace['type'] = App_Helper_Legwork::$trade_type_note_single[$trade['alt_type']];
                $replace['status'] = $status_note[$trade['alt_status']];
                $replace['toAddress'] = $trade['alt_termini_type'] == 2 ? '就近购买' : ($trade['alt_termini'] ? $trade['alt_termini'].$trade['alt_termini_detail'] :$trade['terminiProvince'].$trade['terminiCity'].$trade['terminiZone'].$trade['terminiDetail']);
                $replace['fromAddress'] = $trade['alt_addr_id'] ? $trade['addrProvince'].$trade['addrCity'].$trade['addrZone'].$trade['addrDetail'] : ($trade['alt_addr'] ? $trade['alt_addr'] : '');
                $replace['riderName'] = $trade['alr_name'] ? $trade['alr_name'] : '';
                $replace['riderMobile'] = $trade['alr_mobile'] ? $trade['alr_mobile'] : '';
                $replace['takeTime'] = $trade['alt_take_time'] ?  date('Y-m-d H:i:s',$trade['alt_take_time']) : '';
                $replace['getTime'] = $trade['alt_get_time'] ?  date('Y-m-d H:i:s',$trade['alt_get_time']) : '';
                $replace['finishTime'] = $trade['alt_finish_time'] ?  date('Y-m-d H:i:s',$trade['alt_finish_time']) : '';
                $replace['cancelTime'] = $trade['alt_cancel_done_time'] ?  date('Y-m-d H:i:s',$trade['alt_cancel_done_time']) : '';
                $replace['cancelType'] = $cancelNote;
                $replace['refundMoney'] = $trade['alt_refund_finish'] ? $trade['alt_payment']: '';
                $replace['note'] = $trade['alt_note'] ? $trade['alt_note'] : '';


                list($tpl, )    = $legwork_helper->replaceLegworkTradeTpl($replace, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($uid);
                if($trade['alt_other_sid'] > 0){
                    $applet_model = new App_Model_Applet_MysqlCfgStorage($trade['alt_other_sid']);
                    $applet_cfg = $applet_model->findShopCfg();
                    switch ($applet_cfg['ac_type']){
                        case 4:
                            $page = "pages/orderDetail/orderDetail?orderid=".$trade['alt_other_tid'];
                            break;
                        case 6:
                            $page = "pages/orderDetail/orderDetail?orderid=".$trade['alt_other_tid'];
                            break;
                        case 21:
                            $page = "pages/orderDetail/orderDetail?orderid=".$trade['alt_other_tid'];
                            break;
                        default:
                            $page = '';
                    }
                }else{
                    $page = "pages/orderDetail/orderDetail?tid=".$tid;
                }

                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page,$curr_sid);
            }
        }
    }

    //培训 订单支付推送
    public function trainTradeTempl($tid,$type) {
        $trade_model = new App_Model_Trade_MysqlTradeStorage($this->sid);
        $trade = $trade_model->findUpdateTradeByTid($tid);
        $curr_sid = $this->sid;

        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($curr_sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_{$type}_open"]) && $setup["aws_{$type}_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($curr_sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_{$type}_mid"]);

            if ($tplmsg) {
                $tpl    = $tplmsg['awt_data'];

                //获得课程信息
                $order_model = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $course = $order_model->getCourseByTid($trade['t_id']);
                $uid   = $trade['t_m_id'];
                $replace['tid'] = $trade['t_tid'];
                $replace['name'] = $course['atc_title'];
                $replace['payment'] = $trade['t_payment'];
                $replace['payTime'] = date('Y-m-d H:i:s',$trade['t_pay_time']);
                $replace['courseTime'] =  $course['atc_start_time'] && $course['atc_end_time'] ? date('Y-m-d',$course['atc_start_time']).' ~ '. date('Y-m-d',$course['atc_end_time']) : '';


                $tpl    = json_encode(json_decode($tpl, true), JSON_UNESCAPED_UNICODE);
                $cfg    = plum_parse_config('message', 'tmplmsg');
                foreach($replace as $key=>$val){
                    $replace[$key] = str_replace("\n", "\\n",$val);
                }
                $tplval  = array(
                    $replace['tid'],$replace['name'],$replace['payment'],$replace['payTime'],$replace['courseTime']
                );
                $tplreg   = $cfg[41];

                list($tpl, ) = array(preg_replace($tplreg, $tplval, $tpl));
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($uid);

                $page = "pages/tradeDetail/tradeDetail?tid=".$tid;
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    //抽奖团中奖结果通知
    public function lotteryGroupTmpl($gbid, $sendIds) {
        $sendIds = json_decode($sendIds, true);

        $luck_msg_model = new App_Model_Group_MysqlGoodLuckStorage($this->sid);
        $row            = $luck_msg_model->fetchRowUpdateByGbId($gbid);

        $where      = array();
        $where[]    = array('name' => 'gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_gb_id', 'oper' => '=', 'value' => $row['gc_gb_id']);
        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
        $field      = array('gm_tid','gm_mid');
        $list       = $mem_model->getList($where,0,0,array(),$field);

        //中奖者名单
        $winnerList = $mem_model->getWinnerListByGbid($gbid);
        $winnerListStr = '';
        foreach ($winnerList as $key => $val){
            $winnerListStr .= $val['m_nickname'];
            if($key+1 < count($winnerList)){
                $winnerListStr .= '、';
            }
        }

        if(!empty($list)){
            //消息发送
            foreach($list as $val){
                //发送中奖消息
                if($row['gc_zjjg_msgid'] && (empty($sendIds) || in_array($val['gm_mid'],$sendIds))) {
                    $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                    $trade      = $trade_model->findUpdateTradeByTid($val['gm_tid']);

                    $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($row["gc_zjjg_msgid"]);

                    if ($tplmsg) {
                        $trade_helper   = new App_Helper_Trade($this->sid);
                        $mem_model  = new App_Model_Group_MysqlMemStorage($this->sid);
                        $goods_model = new App_Model_Goods_MysqlGoodsStorage($this->sid);

                        $group = $mem_model->findGroupOrg($val['gm_tid'], $trade['t_m_id']);
                        $goods = $goods_model->getRowById($group['gb_g_id']);
                        //替换订单数据
                        $tpl    = $tplmsg['awt_data'];
                        //替换拼团数据
                        list($tpl,)    = $trade_helper->replaceGroupTpl($group, $tpl, '', $goods, $winnerListStr);
                        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                        $member         = $member_model->getRowById($trade['t_m_id']);

                        $this->_send_msg_to_member($tplmsg, $member, $tpl, '');
                    }
                }
            }
        }
    }

    //抽奖团退款通知
    public function lotteryRefundTmpl($gbid, $refundTids) {
        $refundTids = json_decode($refundTids, true);

        $luck_msg_model = new App_Model_Group_MysqlGoodLuckStorage($this->sid);
        $row            = $luck_msg_model->fetchRowUpdateByGbId($gbid);

        //查找当前类型是否开启模板消息
        if ($row["gc_tktz_msgid"]) {
            $mid    = $row["gc_tktz_msgid"];
            if ($mid) {
                foreach ($refundTids as $tid){
                    //发送消息模板
                    $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                    $tplmsg     = $tplmsg_model->findOneById($mid);
                    //替换订单数据
                    $tpl    = $tplmsg['awt_data'];
                    $trade_helper   = new App_Helper_Trade($this->sid);
                    $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                    $trade      = $trade_model->findUpdateTradeByTid($tid);
                    $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($this->sid);
                    $refund = $refund_model->getRowTid($tid);
                    $infor['tid']        = $trade['t_tid'];
                    $infor['title']      = $trade['t_title'];
                    $infor['num']        = $trade['t_num'];
                    $infor['reason']     = $refund['tr_reason'];
                    $infor['totalFee']   = $trade['t_total_fee'];
                    $infor['refundFee']  = $refund['tr_money'];
                    $infor['payTime']    = date('Y-m-d H:i:s', $trade['t_pay_time']);
                    $infor['refundTime'] = date('Y-m-d H:i:s', $refund['tr_finish_time']);
                    list($tpl,)          = $trade_helper->replaceRefundTpl($infor, $tpl);//替换推送模板变量
                    $tpl = $this->_filter_illegality_chars($tpl);

                    $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                    $member = $member_model->getRowById($trade['t_m_id']);
                    //开始推送信息
                    $this->_send_msg_to_member($tplmsg, $member, $tpl, '');
                }
            }
        }
    }

    //社区团购团长申请审核通知
    public function leaderHandleTmpl($id,$sid,$comId,$mid) {
        Libs_Log_Logger::outputLog('执行推送方法','test.log');
        $leader_model = new App_Model_Sequence_MysqlSequenceLeaderStorage($sid);
        $leader = $leader_model->getRowById($id);

        $community = [];
        $community_model = new App_Model_Sequence_MysqlSequenceCommunityStorage($sid);
        if($comId){
            $community = $community_model->getRowById($comId);
        }

        //发送消息模板
        $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
        $tplmsg         = $tplmsg_model->findOneById($mid);

        //查找当前类型是否开启模板消息
        if ($tplmsg) {
            $mid    = $leader["asl_m_id"];
            if ($mid) {
                $com_name = '';
                if($leader['asl_status'] == 2){
                    $status = '审核通过';
                    $com_name = $community['asc_name'] ? $community['asc_name'] : '';
                }else{
                    $status = '审核拒绝';
                    if($leader['asl_apply_community'] && $leader['asl_apply_community_type'] == 1){
                        $com_name = $leader['asl_apply_community'];
                    }elseif($leader['asl_apply_community_id'] && $leader['asl_apply_community_type'] == 2){
                        $community = $community_model->getRowById($leader['asl_apply_community_id']);
                        $com_name = $community['asc_name'] ? $community['asc_name'] : '';
                    }
                }
                $sequence_helper = new App_Helper_Sequence($sid);
                //替换订单数据
                $tpl    = $tplmsg['awt_data'];
                $infor['name']       = $leader['asl_name'];
                $infor['mobile']     = $leader['asl_mobile'];
                $infor['applyTime']  = $leader['asl_create_time'] ? date('Y-m-d H:i',$leader['asl_create_time']) : '';
                $infor['handleTime'] = $leader['asl_handle_time'] ? date('Y-m-d H:i',$leader['asl_handle_time']) : '';
                $infor['community']   = $com_name;
                $infor['status']  = $status;
                $infor['remark'] = $leader['asl_handle_remark'] ? $leader['asl_handle_remark'] : '';

                list($tpl,)          = $sequence_helper->replaceLeaderHandleTpl($infor, $tpl);//替换推送模板变量
                $tpl = $this->_filter_illegality_chars($tpl);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getRowById($mid);
                //开始推送信息
                $this->_send_msg_to_member($tplmsg, $member, $tpl, '');
            }
        }
    }

    /**
     * 积分变更通知
     */
    public function pointsChangeTempl($id, $before){
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_points_change_open"]) && $setup["aws_points_change_open"] && $setup["aws_points_change_mid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_points_change_mid"]);

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $inout_model    = new App_Model_Point_MysqlInoutStorage($this->sid);
                $inout = $inout_model->getRowById($id);
                $where = array();
                $where[] = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[] = array('name' => 'pi_type', 'oper' => '=', 'value' => 1);
                $where[] = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $inout['pi_m_id']);
                $getTotal   = $inout_model->pointStatistic($where);
                $where = array();
                $where[] = array('name' => 'pi_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[] = array('name' => 'pi_type', 'oper' => '=', 'value' => 2);
                $where[] = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $inout['pi_m_id']);
                $spendTotal = $inout_model->pointStatistic($where);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($inout['pi_m_id']);

                $pointsData = array(
                    'before'     => $before,
                    'after'      => $member['m_points'],
                    'change'     => $inout['pi_point'],
                    'desc'       => $inout['pi_title'],
                    'getTotal'   => $getTotal,
                    'spendTotal' => $spendTotal
                );
                list($tpl,)    = $trade_helper->replacePointsChangeTpl($pointsData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);


                $this->_send_msg_to_member($tplmsg, $member, $tpl, '');
            }
        }
    }

    /**
     * @param $id
     * @param int $appletType
     * 积分变更通知
     */
    public function coinChangeTempl($id,$appletType = 0){
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
            $setup  = $setup_model->findOneBySid();
        }


        if (isset($setup["aws_coin_change_open"]) && $setup["aws_coin_change_open"] && $setup["aws_coin_change_mid"]) {
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_coin_change_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_coin_change_mid"]);
            }

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];
                $record_storage = new App_Model_Member_MysqlRechargeStorage($this->sid);
                $record = $record_storage->getRowById($id);

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($record['rr_m_id']);

                $pointsData = array(
                    'before'     => $record['rr_status'] == 1?$member['m_gold_coin'] - $record['rr_amount']:$member['m_gold_coin'] + $record['rr_amount'],
                    'after'      => $member['m_gold_coin'],
                    'change'     => $record['rr_amount'],
                    'desc'       => $record['rr_remark']?$record['rr_remark']:'余额支付',
                );
                list($tpl,)    = $trade_helper->replaceCoinChangeTpl($pointsData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);


                $this->_send_msg_to_member($tplmsg, $member, $tpl, '',0,$appletType);
            }
        }
    }

    /**
     * 组队红包组队成功
     */
    public function redbagSuccessTempl($id){
        $join_model = new App_Model_Redbag_MysqlRedbagJoinStorage($this->sid);
        $join = $join_model->getRowById($id);

        $activity_model = new App_Model_Redbag_MysqlRedbagActivityStorage($this->sid);
        $activity = $activity_model->getRowById($join['arj_a_id']);

        if ($activity["ara_zdcg_msgid"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($activity["ara_zdcg_msgid"]);
            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];

                $where = [];
                $where[] = ['name' => 'arj_s_id','oper' => '=','value' =>$this->sid];
                $where[] = ['name' => 'arj_group','oper' => '=','value' => $join['arj_group']];
//                $list = $join_model->getListMember($where,0,0, array());
                $list = $join_model->getList($where,0,0, array());

                $memberStr = '';
                foreach ($list as $key => $val){
                    $memberStr .= $val['arj_nickname'];
                    if($key < count($list) -1 ){
                        $memberStr .= '、';
                    }
                }
                $pointsData = array(
                    'name'     => $activity['ara_name'],
                    'money'    => $activity['ara_money'],
                    'num'      => $activity['ara_num'],
                    'joiner'   => $memberStr,
                );
                list($tpl,)    = $trade_helper->replaceRedbagSuccessTpl($pointsData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $page = 'subpages0/teamRedpacket/teamIndex/teamIndex';
                foreach ($list as $key => $val){
                    $this->_send_msg_to_member($tplmsg, $val, $tpl, $page);
                }
            }
        }

    }

    /**
     * 会务报名成功通知
     */
    public function meetingTradeTempl($tid){
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_meeting_bmcg_open"]) && $setup["aws_meeting_bmcg_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
            $tplmsg     = $tplmsg_model->findOneById($setup["aws_meeting_bmcg_mid"]);
            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];

                $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                $trade      = $trade_model->findUpdateTradeByTid($tid);

                $order_model      = new App_Model_Trade_MysqlTradeOrderStorage($this->sid);
                $order = $order_model->fetchOrderListByTid($trade['t_id']);

                $meeting_storage  = new App_Model_Meeting_MysqlMeetingStorage($this->sid);
                $meeting          = $meeting_storage->getRowById($order[0]['to_g_id']);

                $ticket_storage   = new App_Model_Meeting_MysqlMeetingTicketStorage($this->sid);
                $ticket           = $ticket_storage->getRowById($order[0]['to_gf_id']);


                $meetingData = array(
                    'tid'         => $trade['t_tid'],
                    'nickname'    => $trade['t_buyer_nick'],
                    'meetingName' => $meeting['am_title'],
                    'meetingType' => $ticket['amt_name'],
                    'typeDesc'    => $ticket['amt_content'],
                    'orderMoney'  => $trade['t_total_fee'],
                    'orderTime'   => date('Y-m-d H:i:s', $trade['t_create_time']),
                    'meetingTime' => date('Y-m-d H:i:s',$meeting['am_start_time']).'-'.date('Y-m-d H:i:s', $meeting['am_end_time']),
                    'meetingAddr' => $meeting['am_address']
                );
                list($tpl,)    = $trade_helper->replaceMeetingTradeTpl($meetingData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $page = 'pages/signPage/signPage?tid='.$trade['t_tid'];

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($trade['t_m_id']);
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page);
            }
        }
    }

    /**
     * 留言处理通知
     */
    public function formDealTempl($id,$appletType = 0){
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_form_deal_open"]) && $setup["aws_form_deal_open"]) {
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_form_deal_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_form_deal_mid"]);
            }

            if ($tplmsg) {
                $trade_helper   = new App_Helper_Trade($this->sid);
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];

                $data_model = new App_Model_Applet_MysqlCustomFormDataStorage();
                $formData = $data_model->getRowById($id);

                $form_model = new App_Model_Applet_MysqlCustomFormStorage();
                $form = $form_model->getRowById($formData['acfd_tpl_id']);

                $replaceData = array(
                    'title'       => $form['acf_header_title'],
                    'createTime'  => date('Y-m-d H:i:s', $formData['acfd_create_time']),
                    'dealContent' => $formData['acfd_remark'],
                    'dealTime'    => date('Y-m-d H:i:s', time()),
                );
                list($tpl,)    = $trade_helper->replaceFormDealTpl($replaceData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $page = '';

                $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($formData['acfd_m_id']);
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page,0,$appletType);
            }
        }
    }

    /**
     * 店铺被评论通知
     */
    public function shopCommentTempl($id,$appletType = 0){
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_shop_comment_open"]) && $setup["aws_shop_comment_open"]) {

            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_shop_comment_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_shop_comment_mid"]);
            }


            if ($tplmsg) {
                $trade_helper   = new App_Helper_ReplaceMsg();
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];

                $comment_model = new App_Model_City_MysqlCityShopCommentStorage($this->sid);
                $commentData = $comment_model->getRowById($id);

                $shop_model = new App_Model_City_MysqlCityShopStorage($this->sid);
                $shop = $shop_model->getRowById($commentData['acs_acs_id']);

                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $commentMember = $member_model->getRowById($commentData['acs_m_id']);

                $replaceData = array(
                    'shopName'   => $shop['acs_name'],
                    'commentator'  => $commentMember['m_nickname'],
                    'commentScore' => $commentData['acs_stars'],
                    'commentContent' => $commentData['acs_comment'],
                    'commentTime'    => date('Y-m-d H:i:s', time()),
                );
                list($tpl,)    = $trade_helper->replaceShopCommentTpl($replaceData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $page = 'pages/shopDetailnew/shopDetailnew?id='.$shop['acs_id'];

                $member         = $member_model->getRowById($shop['acs_m_id']);
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page, 0, $appletType);
            }
        }
    }

    /**
     * 电话本入驻审核通知
     */
    public function mobileAuditTempl($id,$appletType = 0){
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_mobile_audit_open"]) && $setup["aws_mobile_audit_open"]) {
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_mobile_audit_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_mobile_audit_mid"]);
            }

            if ($tplmsg) {
                $trade_helper   = new App_Helper_ReplaceMsg();
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];

                $apply_storage = new App_Model_Mobile_MysqlMobileShopApplyStorage($this->sid);
                $applyData = $apply_storage->getRowById($id);

                $replaceData = array(
                    'shopName'       => $applyData['ams_name'],
                    'auditResult'    => $applyData['ams_status']==2?'审核通过':'审核不通过',
                    'applyTime'      => date('Y-m-d H:i:s', $applyData['ams_create_time']),
                    'auditTime'      => date('Y-m-d H:i:s', $applyData['ams_handle_time']),
                    'auditRemark'    => $applyData['ams_handle_remark'],
                );
                list($tpl,)    = $trade_helper->replaceMobileAuditTpl($replaceData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $page = '';
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($applyData['ams_m_id']);
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page,0,$appletType);
            }
        }
    }

    /**
     * 店铺认领审核通知
     */
    public function shopClaimTempl($id,$appletType = 0){
        if($appletType == 5){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->sid);
        }
        $setup  = $setup_model->findOneBySid();

        if (isset($setup["aws_shop_claim_open"]) && $setup["aws_shop_claim_open"]) {
            if($appletType == 5){
                $tplmsg_model   = new App_Model_Auth_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_shop_claim_mid"]);
                $tplmsg['awt_data'] = $tplmsg['wt_data'];
                $jump   = $tplmsg['wt_url'];
            }else{
                $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->sid);
                $tplmsg     = $tplmsg_model->findOneById($setup["aws_shop_claim_mid"]);
            }

            if ($tplmsg) {
                $trade_helper   = new App_Helper_ReplaceMsg();
                //替换砍价数据
                $tpl    = $tplmsg['awt_data'];

                $claim_model = new App_Model_City_MysqlCityShopClaimStorage($this->sid);
                $applyData = $claim_model->getRowById($id);

                $shop_model = new App_Model_City_MysqlCityShopStorage($this->sid);
                $shop = $shop_model->getRowById($applyData['acsc_acs_id']);

                $replaceData = array(
                    'shopName'       => $shop['acs_name'],
                    'auditResult'    => $applyData['acsc_status']==2?'审核通过':'审核不通过',
                    'applyTime'      => date('Y-m-d H:i:s', $applyData['acsc_create_time']),
                    'auditTime'      => date('Y-m-d H:i:s', $applyData['acsc_deal_time']),
                    'auditRemark'    => $applyData['acsc_deal_note'],
                );
                list($tpl,)    = $trade_helper->replaceShopClaimTpl($replaceData, $tpl);
                $tpl = $this->_filter_illegality_chars($tpl);
                $page = '';
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member         = $member_model->getRowById($applyData['acsc_m_id']);
                $this->_send_msg_to_member($tplmsg, $member, $tpl, $page, 0, $appletType);
            }
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/6
 * Time: 下午9:13
 */

class App_Controller_Console_IndexController extends Libs_Mvc_Controller_ConsoleController{
    const WEIXIN_PAT_REDPACK    = 1;//微信红包形式
    const WEIXIN_PAY_TRANSFER   = 2;//微信企业转账到零钱
    const WEIXIN_PAY_BANK       = 3;//微信企业转账到银行卡

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        $name   = plum_get_param("name");

        Libs_Log_Logger::outputConsoleLog("this is console ".$name);
    }
    /******************************************session机制垃圾回收*******************************************************/
    public function gcAction() {
        $type   = plum_get_param('type');
        //获取session配置
        $session_config     = plum_parse_config($type, 'session');

        $dir_path       = plum_check_array_key('save_path', $session_config, null);
        $max_lifetime   = plum_check_array_key('lifetime', $session_config, 30*24*60);

        $this->_garbage_collection($dir_path, $max_lifetime);
    }

    private function _garbage_collection($dir_path, $maxlifetime) {
        $dir_handler    = opendir($dir_path);
        if ($dir_handler) {
            while (($file = readdir($dir_handler)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $file_path  = $dir_path . '/' . $file;

                if (is_dir($file_path)) {
                    $this->_garbage_collection($file_path, $maxlifetime);
                } else {
                    //使用cookie时，删除失效文件(使用文件的修改时间)
                    if (filemtime($file_path) + $maxlifetime < time()) {
                        @unlink($file_path);
                      	Libs_Log_Logger::outputConsoleLog($file_path."清除成功");
                    }
                }
            }
            closedir($dir_handler);
        }
    }

    /*******************************************后台进程****************************************************************/
    /*
     * 后台订单处理
     */
    public function tradeBackAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');
        $from   = plum_get_param('from');

        $trade_model= new App_Model_Trade_MysqlTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $trade_helper   = new App_Helper_Trade($sid);
        $trade_helper->dealTradeType($trade,0,$from);
    }

    /**
     * 商品加入购物单
     */
    public function addShoppingAction(){
        $sid    = plum_get_int_param('sid');
        $gid    = plum_get_int_param('gid');
        $gfid   = plum_get_int_param('gfid');
        $esid   = plum_get_int_param('esid');
        $mid   = plum_get_int_param('mid');

        $trade_helper = new App_Helper_Trade($sid);
        $trade_helper->dealAddShopping($mid,$gid, $gfid, $esid);
    }

    /**
     * 将商品从购物单中删除
     */
    public function delShoppingAction(){
        $sid   = plum_get_int_param('sid');
        $mid   = plum_get_int_param('mid');
        $delShopping = rawurldecode(trim($_REQUEST['delShopping']));
        $trade_helper = new App_Helper_Trade($sid);
        $trade_helper->dealDelShopping($mid, json_decode($delShopping, true));

    }

    /**
     * 同步更新购物单订单
     */
    public function updateOrderAction(){
        $sid   = plum_get_int_param('sid');
        $tid   = plum_get_param('tid');
        $trade_helper = new App_Helper_Trade($sid);
        $trade_helper->updateOrder($tid);
    }

    /**
     * 同步更新购物单商品信息
     */
    public function updateGoodsAction(){
        $sid   = plum_get_int_param('sid');
        $gid   = plum_get_param('gid');
        $trade_helper = new App_Helper_Trade($sid);
        $trade_helper->updateGoods($gid);
    }

    /*
     * 后台跑腿订单处理
     */
    public function legworkTradeBackAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $trade_model= new App_Model_Legwork_MysqlLegworkTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $trade_helper   = new App_Helper_Legwork($sid);
        $trade_helper->dealTradeType($trade);
    }

    /*
     * 后台校园跑腿订单处理
     */
    public function handyTradeBackAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $trade_model= new App_Model_Handy_MysqlHandyTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $trade_helper   = new App_Helper_Handy($sid);
        $trade_helper->dealTradeType($trade);
    }

    /*
     * 后台礼品卡订单处理
     */
    public function giftcardTradeBackAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $trade_model= new App_Model_Giftcard_MysqlGiftCardTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $gift_helper   = new App_Helper_Giftcard($sid);
        $gift_helper->dealTradePay($trade);
    }



    /*
     * 后台商家岛订单处理
     */
    public function merchantTradeBackAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $trade_model= new App_Model_Merchant_MysqlMerchantTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);

        $trade_helper   = new App_Helper_MerchantTrade($sid);
        $trade_helper->dealTradeType($trade);
    }
    /*
     * 微信小程序模板消息发送
     */
    public function wxappTemplAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');
        $type   = plum_get_param('type');
        $applet = plum_get_param('applet');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_WxappApplet($sid);
        $wxapp->sendWxappTmplmsg($tid, $type,$applet,$appletType);
    }


    /**
     * 帖子增加浏览量
     */
    public function postAddShowNumAction(){
        $pids     = plum_get_param('pids');
        $sid    = plum_get_int_param('sid');
        $pids = json_decode($pids,true);
        $post_model = new App_Model_City_MysqlCityPostStorage($sid);
        $post_model->addReducePostNum($pids,'show','add',1);
    }

    /**
     * 修改七牛域名
     */
    public function qiniuChangeHostAction(){
        $sid     = plum_get_int_param('sid');
        $oldhost = plum_get_param('oldhost');
        $newhost = plum_get_param('newhost');

        $index      = 0;
        $count      = 50;

        //修改知识付费课程表
        $where = array();
        $where[] = array('name' => 'akk_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'akk_url', 'oper' => 'like', 'value' => "%{$oldhost}%");
        $knowledge_model = new App_Model_Knowpay_MysqlKnowpayKnowledgeStorage($sid);
        $field      = array('akk_id', 'akk_s_id', 'akk_url');
        do {
            $list   = $knowledge_model->getList($where, $index, $count, array(), $field);
            foreach ($list as $item) {
                $video = str_replace($oldhost, $newhost, $item['akk_url']);
                $knowledge_model->updateById(array('akk_url' => $video), $item['akk_id']);
            }
        }while(count($list) == $count);

        //修改资讯的
        $where = array();
        $where[] = array('name' => 'ai_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'ai_video', 'oper' => 'like', 'value' => "%{$oldhost}%");
        $infomation_model = new App_Model_Applet_MysqlAppletInformationStorage();
        $field      = array('ai_id', 'ai_s_id', 'ai_video');
        do {
            $list   = $infomation_model->getList($where, $index, $count, array(), $field);
            foreach ($list as $item) {
                $video = str_replace($oldhost, $newhost, $item['ai_video']);
                $infomation_model->updateById(array('ai_video' => $video), $item['ai_id']);
            }
        }while(count($list) == $count);

        //修改七牛视频管理表
        $where = array();
        $where[] = array('name' => 'aqv_s_id', 'oper' => '=', 'value' => $sid);
        $where[] = array('name' => 'aqv_video_url', 'oper' => 'like', 'value' => "%{$oldhost}%");
        $video_model = new App_Model_Applet_MysqlAppletQiniuVideoStorage($sid);
        $field      = array('aqv_id', 'aqv_s_id', 'aqv_video_url');
        do {
            $list   = $video_model->getList($where, $index, $count, array(), $field);
            foreach ($list as $item) {
                $video = str_replace($oldhost, $newhost, $item['aqv_video_url']);
                $video_model->updateById(array('aqv_video_url' => $video), $item['aqv_id']);
            }
        }while(count($list) == $count);
    }

    /**
     * 自动提现
     */
    public function withdrawAction(){
        $sid    = plum_get_int_param('sid');
        $rid    = plum_get_int_param('rid');
        $where   = array();
        $where[] = array('name'=>'wd_s_id','oper'=>'=','value'=>$sid);
        $where[] = array('name'=>'wd_id','oper'=>'=','value'=>$rid);
        $where[] = array('name'=>'wd_audit','oper'=>'=','value'=>0);
        $withdraw_model = new App_Model_Member_MysqlWithDrawalStorage();
        $record = $withdraw_model->getRow($where);
        $pay_type = $record['wd_type']==1?2:3;
        //非微信转账类型
        if (!in_array($record['wd_type'],array(self::WEIXIN_PAT_REDPACK,self::WEIXIN_PAY_BANK))) {
            return array('errno' => false, 'errmsg' => '非微信转账类型');
        }
        //待审核才能提现
        if ($record['wd_audit'] != 0) {
            return array('errno' => false, 'errmsg' => '非待审核状态');
        }
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($record['wd_m_id']);
        $pay_storage    = new App_Model_Auth_MysqlPayTypeStorage($sid);
        $payCfg = $pay_storage->findRowPay();
        if(!$payCfg || !$payCfg['pt_wxpay_applet']){
            return array('errno' => false, 'errmsg' => '请在支付配置中开启微信支付');
        }
        if ($payCfg && $payCfg['pt_wxpay_applet']) {
            $wxpay_plugin   = new App_Plugin_Weixin_NewPay($sid);
            if ($pay_type == self::WEIXIN_PAT_REDPACK) {
                $ret    = $wxpay_plugin->appletSendRedpack($member['m_openid'], $record['wd_real_money']);  // 微信红包
            } else if($pay_type == self::WEIXIN_PAY_TRANSFER) {
                $ret    = $wxpay_plugin->appletPayTransfer($member['m_openid'], $record['wd_real_money'], $record['wd_realname']);  //微信转账到零钱
            } else if($pay_type == self::WEIXIN_PAY_BANK) {
                $ret    = $wxpay_plugin->appletPayBank($record['wd_account'], $record['wd_realname'], $record['wd_bank'],$record['wd_real_money']);  // 微信转账到银行卡
            }
        }
        if ($ret && !$ret['code']) {
            $set = array(
                'wd_audit'      => 1,
                'wd_audit_note' => '',
                'wd_audit_time' => time()
            );
            $withdraw_model->updateValue($set,$where);
            //修改用户金额，并通过时记录交易流水
            $this->_deal_withdraw_result($record,1,$ret['send_listid'], $sid);
        }else{
            Libs_Log_Logger::outputLog('提现失败：'.$sid.'_'.$rid,'withdraw.log');
            Libs_Log_Logger::outputLog($ret,'withdraw.log');
        }
    }

    /**
     * @param array $record
     * @param $status
     * @param string $tid
     * @return bool
     * 转账成功后，1、处理用户金额；2、记录流水
     */
    private function _deal_withdraw_result(array $record,$status,$tid='',$sid){
        $member_model = new App_Model_Member_MysqlMemberCoreStorage();
        $money_ret = $member_model->dealWithdrawMoney($record['wd_m_id'],$record['wd_money'],$status);
        if($status == 1){//审核通过，则记录流水
            $data = array(
                'dd_s_id'           => $sid,
                'dd_m_id'           => $record['wd_m_id'],
                'dd_o_id'           => $record['wd_id'],
                'dd_amount'         => $record['wd_money'],
                'dd_tid'            => $tid,
                'dd_level'          => 0,
                'dd_record_type'    => 4,
                'dd_record_time'    => time(),
                'dd_record_remark'  => '提现申请通过记录流水'
            );
            $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
            $book_ret = $book_model->insertValue($data);
        }
        if($money_ret || $book_ret){
            return true;
        }else{
            return false;
        }
    }

    /*******************************************后台进程****************************************************************/
    /*
     * 定时检查微信小程序的审核状态
     */
    public function checkAuditAction() {
        set_time_limit(0);
        $applet_model   = new App_Model_Applet_MysqlCfgStorage(null);
        $diff       = time()-24*60*60;

        $where[]    = array('name' => 'ac_audit_status', 'oper' => '=', 'value' => 1);//审核中
        $where[]    = array('name' => 'ac_audit_time', 'oper' => '<', 'value' => $diff);//提交审核一天后的

        $index      = -50;
        $count      = 50;
        $sort       = array('ac_audit_time' => 'ASC');

        $set    = array();
        do {
            $index  += $count;
            $list   = $applet_model->getList($where, $index, $count, $sort, array('ac_id', 'ac_s_id', 'ac_audit_base', 'ac_audit_version'));

            $set    = array_merge($set, $list);
        }while(count($list) == $count);

        foreach ($set as $item) {
            $client = new App_Plugin_Weixin_WxxcxClient($item['ac_s_id']);

            $ret    = $client->fetchLatestAudit();
            if ($ret['errcode'] == 0) {
                if ($ret['status'] == 2) {
                    Libs_Log_Logger::outputLog('代码仍处于审核中, 请耐心等待!');
                } else {
                    Libs_Log_Logger::outputLog($ret);
                    $updata = array(
                        'ac_audit_status' => $ret['status'] == 0 ? 2 : 3,
                        'ac_audit_reason' => $ret['status'] == 1 ? $ret['reason'] : '',
                    );
                    //审核成功的
                    if ($ret['status'] == 0) {
                        $client->releaseTemplateCode();//发布上线
                        //设置无审核状态
                        $updata = array(
                            'ac_audit_status' => 0,
                            'ac_base'   => $item['ac_audit_base'],
                            'ac_version'=> $item['ac_audit_version'],
                        );
                    }
                    //设置审核状态
                    $applet_model   = new App_Model_Applet_MysqlCfgStorage($item['ac_s_id']);
                    $applet_model->findShopCfg($updata);
                    //  关闭审核伪装版本
                    $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($item['ac_s_id']);
                    $tpl_model->findUpdateBySid(26,array('asp_audit'=>0));
                }
            } else {
                Libs_Log_Logger::outputLog($ret);
            }
        }
    }
    /*
     * 定时检查同城置顶帖到期问题
     * 判断置顶帖是否到期未取消置顶
     */
    public function checkTopPostAction() {
        set_time_limit(0);
        $where = array();
        $where[] = array('name'=>'acp_istop','oper'=>'=','value'=>1);
        $where[] = array('name'=>'acp_istop_expiration','oper'=>'<=','value'=>time());
        $post_storage = new App_Model_City_MysqlCityPostStorage(0);
        $set = array(
            'acp_istop'            => 0,
            'acp_istop_expiration' => 0
        );
        $ret = $post_storage->updateValue($set,$where);

        //检查多店帖子置顶
        $where = array();
        $where[] = array('name'=>'acp_istop','oper'=>'=','value'=>1);
        $where[] = array('name'=>'acp_istop_expiration','oper'=>'<=','value'=>time());
        $post_model = new App_Model_Community_MysqlCommunityPostStorage(0);
        $set = array(
            'acp_istop'            => 0,
            'acp_istop_expiration' => 0
        );
        $ret = $post_model->updateValue($set,$where);
        //检查招聘职位置顶
        $where = array();
        $where[] = array('name'=>'ajp_is_top','oper'=>'=','value'=>1);
        $where[] = array('name'=>'ajp_top_expiration','oper'=>'<=','value'=>time());
        $position_model = new App_Model_Job_MysqlJobPositionStorage(0);
        $set = array(
            'ajp_is_top'         => 0,
            'ajp_top_expiration' => 0
        );
        $ret = $position_model->updateValue($set,$where);
    }

    /**
     * 定时检查代理商招商指标
     */
    public function checkAgentTargetAction(){
        //获取连续两月未招商的代理商列表
        $manager_storage = new App_Model_Agent_MysqlAdminStorage();
        $list = $manager_storage->getUnfinishedTargetList();
        foreach($list as $val){
            $fmanager = $manager_storage->getRowById($val['aa_fid']);
            //关闭招商权限
            $update = array('aa_open_lower' => 0);
            //上级代理商扣除3个名额
            $newArray = json_decode($fmanager['aa_vist_record'], true);
            array_splice($newArray,-1);
            $fupdate = array('aa_vist_record' => json_encode($newArray));
            $manager_storage->updateById($update, $val['aa_id']);
            $manager_storage->updateById($fupdate, $val['aa_fid']);
            $desc  = "连续两月未完成招商指标, 关闭招商权限";
            $fdesc = $val['aa_name'].'连续两月未完成招商指标，扣除1个招商指标';
            $this->_record_award($val['aa_id'], 2,$desc);
            $this->_record_award($val['aa_fid'], 2,$fdesc);
        }
    }

    //记录惩罚记录
    private function _record_award($uid, $status, $desc){
        $data = array(
            'aa_a_id'         => $uid,
            'aa_status'       => $status,
            'aa_desc'         => $desc,
            'aa_create_time' => time()
        );
        $award_storage = new App_Model_Agent_MysqlAgentAwardStorage();
        $award_storage->insertValue($data);
    }

    /**
     * 给代理商发送即将到期的小程序数据发送短信通知
     */
    public function sendSmsToAgentAction(){
        $ucpaas_plugin  = new App_Plugin_Sms_UcpaasPlugin();
        //快到期的商户（30天）
        $where = array();
        $where[] = array('name'=>'ac_expire_time','oper'=>'>=','value'=>strtotime("+29 days"));
        $where[] = array('name'=>'ac_expire_time','oper'=>'<','value'=>strtotime("+30 days"));
        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $thirtyShopList = $open_storage->getTipsAppletCount($where,0,0);

        foreach ($thirtyShopList as $value){
            $params = array(
                '30天内',
                $value['num'].'个小程序'
            );
            if($value['aa_id'] == 2){
                // 发送短信通知
                $ucpaas_plugin->sendNoticeSms($value['aa_mobile'], 'xcxxftz', $params);
            }
        }

        //快到期的商户（15天）
        $where = array();
        $where[] = array('name'=>'ac_expire_time','oper'=>'>=','value'=>strtotime("+14 days"));
        $where[] = array('name'=>'ac_expire_time','oper'=>'<','value'=>strtotime("+15 days"));
        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $fifteenShopList = $open_storage->getTipsAppletCount($where,0,0);

        foreach ($fifteenShopList as $value){
            $params = array(
                '15天内',
                $value['num'].'个小程序'
            );
            if($value['aa_id'] == 2){
                // 发送短信通知
                $ucpaas_plugin->sendNoticeSms($value['aa_mobile'], 'xcxxftz', $params);
            }
        }

        //快到期的商户（7天）
        $where = array();
        $where[] = array('name'=>'ac_expire_time','oper'=>'>=','value'=>strtotime("+6 days"));
        $where[] = array('name'=>'ac_expire_time','oper'=>'<','value'=>strtotime("+7 days"));
        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $sevenShopList = $open_storage->getTipsAppletCount($where,0,0);

        foreach ($sevenShopList as $value){
            $params = array(
                '7天内',
                $value['num'].'个小程序'
            );
            if($value['aa_id'] == 2) {
                // 发送短信通知
                $ucpaas_plugin->sendNoticeSms($value['aa_mobile'], 'xcxxftz', $params);
            }
        }
    }

    //定时抓取微信公众号文章
    public function getArticleAction(){
        set_time_limit(0);
        //趁着这个定时方法，检查招聘小程序的状态
        $this->_check_job_send_status();
        $cfg = plum_parse_config('cfgAuto', 'gzhcfg');
        $token = $cfg['token'];
        $cookie = $cfg['cookies'];
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage(0);
        $where = array();
        $where[] = array('name' => 'abg_get_article_time', 'oper' => '<', 'value' => strtotime(date('Y-m-d')));
        if(time() > strtotime(date('Y-m-d', time()).' 09:00:00')){
            $count = 5;
        }else{
            $count = 1;
        }
        $gzhList = $gzh_model->getList($where, 0, $count, array("abg_is_pay" => 'desc', "abg_get_article_time" => 'ASC'));
        if($gzhList){
            foreach ($gzhList as $gzh){
                $count = 10;
                $header = array(
                    "Host"=> 'mp.weixin.qq.com',
                    "Upgrade-Insecure-Requests"=> '1',
                    "Referer"=>  'https://mp.weixin.qq.com/cgi-bin/appmsg?t=media/appmsg_edit_v2&action=edit&isNew=1&type=10&token='.$token.'&lang=zh_CN',
                );
                $url = "https://mp.weixin.qq.com/cgi-bin/appmsg?action=list_ex&token=".$token."&lang=zh_CN&random=0.6254349379640605&type=9&f=json&ajax=1&fakeid=".urlencode($gzh['abg_wxno'])."&query=&begin=0&count=".$count;
                $res = Libs_Http_Client::get($url, array(), $header, array(), $cookie);
                $data = json_decode($res, true);
                $article = array();
                if($data['app_msg_list']){
                    foreach ($data['app_msg_list'] as $value){
                        $articleTemp = array();
                        $articleTemp['title'] = $value['title'];
                        $articleTemp['cover'] = $value['cover'];
                        $articleTemp['digest'] = $value['digest'];
                        $articleTemp['content_url'] = $value['link'];
                        $articleTemp['contentId'] = $value['update_time'];
                        $article[] = $articleTemp;
                    }
                }

                if($article){
                    $this->_save_article($article, $gzh['abg_wxno'], 0, $gzh['abg_s_id'], $gzh['abg_cate_id']);
                }
                if($data['base_resp']['ret'] == 0 || $data['base_resp']['ret'] == 200002){
                    Libs_Log_Logger::outputLog($gzh['abg_id']);
                    $set = array('abg_get_article_time' => time());
                    $gzh_model->updateById($set, $gzh['abg_id']);
                }
            }
        }
    }

    private function _check_job_send_status(){
        $send_model = new App_Model_Job_MysqlJobSendStorage(0);
        $where = array();
        $where[] = array('name' => 'ajs_interview_time', 'oper' => '<', 'value' => time());
        $where[] = array('name' => 'ajs_status', 'oper' => '=', 'value' => 4);
        $set = array(
            'ajs_status'         => 5,
            'ajs_update_time'    => time(),
        );
        $send_model->updateValue($set, $where);

        $where = array();
        $where[] = array('name' => 'ajs_interview_time', 'oper' => '<', 'value' => time());
        $where[] = array('name' => 'ajs_status', 'oper' => '=', 'value' => 3);
        $set = array(
            'ajs_status'         => 9,
            'ajs_end_time'       => time(),
            'ajs_update_time'    => time(),
        );
        $send_model->updateValue($set, $where);
    }

    private function _save_article($article, $wxno, $needHost=0, $sid, $cid){
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $insertData = array();
        $gzh_model = new App_Model_Information_MysqlInformationGzhStorage($sid);
        $gzh = $gzh_model->getRowByWxId($wxno);
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop = $shop_model->getRowById($sid);
        foreach ($article as $key => $value){
            $data = array(
                'ai_title'       => $value['title'],
                'ai_cover'       => $this->_download_article_image($value['cover'], $shop['s_unique_id']),
                'ai_brief'       => $value['digest'],
                'ai_wx_real_url' => $value['content_url'],
                'ai_wx_no'       => $wxno,
                'ai_from'        => $gzh['abg_name'],
                'ai_wx_id'       => $value['contentId'],
                'ai_category'    => $cid,
                'ai_create_time' => time(),
                'ai_s_id'        => $sid,
                'ai_update_time' => time()
            );
            $where = array();
            $where[] = array('name' => 'ai_s_id', 'oper' => '=', 'value' => $sid);
            $where[] = array('name' => 'ai_wx_no', 'oper' => '=', 'value' => $wxno);
            $where[] = array('name' => 'ai_wx_id', 'oper' => '=', 'value' => $value['contentId']);
            $where[] = array('name' => 'ai_deleted', 'oper' => '=', 'value' => 0);
            $row = $information_storage->getRow($where);
            if(!$row){
                $content = $this->_get_article_info($value['content_url'], 1);
                $client_storage = new App_Plugin_Querylist_Query($shop['s_unique_id']);
                $article = $client_storage->queryWxArticle($value['content_url']);
                $data['ai_content'] = $content['article'];
                $data['ai_video'] = $article['video'];
                $insertData[] = $data;
            }
        }
        foreach ($insertData as $val){
            $information_storage->insertValue($val);
        }
    }

    private function _download_article_image($img, $suid){
        if(!$suid){
            $suid = 'default';
        }
        list($usec, $sec) = explode(" ", microtime());
        $md5        = strtoupper(md5($usec.$sec));
        $name   = substr($md5, 0, 8).'-'.substr($md5, 10, 4).'-'.mt_rand(1000, 9999).'-'.substr($md5, 20, 12);

        $fileroot   = PLUM_DIR_UPLOAD. '/depot/'.$suid.'/'.date('Ymd', time()).'/';
        if (!is_dir($fileroot)) {
            @mkdir($fileroot, 0755, true);
        }
        $filename = PLUM_DIR_UPLOAD. '/depot/'.$suid.'/'.date('Ymd', time()).'/'.$name.'.png';
        $filepath = PLUM_PATH_UPLOAD . '/depot/'.$suid.'/'.date('Ymd', time()).'/'.$name.'.png';
        if(!file_exists($filename)){
            $hander = curl_init();
            $fp = fopen($filename,'wb');
            curl_setopt($hander,CURLOPT_URL,$img);
            curl_setopt($hander,CURLOPT_FILE,$fp);
            curl_setopt($hander,CURLOPT_HEADER,0);
            curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($hander,CURLOPT_TIMEOUT,60);
            curl_exec($hander);
            curl_close($hander);
            fclose($fp);
            //数据同步操作
            try {
                $sync = new Libs_Image_DataSync();
                $sync->pushQueue($filepath);
            } catch (Exception $e) {
                Libs_Log_Logger::outputLog($e->getMessage().':'.$filepath, 'imgsrc.log');
            }
        }
        return $filepath;
    }


    private function _get_article_info($url, $needReplace = 0){
        if($needReplace){
            $url = str_replace('http', 'https', $url);
        }
        $content = Libs_Http_Client::get($url);
        $content_html_pattern = '/<div class="rich_media_content ".*?id="js_content".*?>(.*?)<\/div>/s';
        preg_match($content_html_pattern, $content, $content_matchs);
        if($content_matchs[1]){
            $article_content = str_replace('data-src', 'src', $content_matchs[1]);
        }

        $content_html_pattern = '/<iframe.*?data-src=[\'|"].*?vid=(.*?)&amp;.*?><\/iframe>/s';
        preg_match($content_html_pattern, $content, $vid_matchs);
        if(!$vid_matchs[1]){
            $content_html_pattern = '/<iframe.*?src=[\'|"].*?vid=(.*?)[\'|"]><\/iframe>/s';
            preg_match($content_html_pattern, $content, $vid_matchs);
        }
        if($vid_matchs[1]){
            $vid = $vid_matchs[1];
            $videoInfo = $this->_get_tencent_video($vid);
            $videoUrl = $videoInfo['real_url'];
        }

        return array(
            'article' => $article_content,
            'video' => $videoUrl
        );
    }

    //抓取腾讯视频地址
    private function _get_tencent_video($vid=''){
        $params = array(
            'isHLS' => false,
            'charge' => 0,
            'vid' => $vid,
            'defaultfmt' => 'auto',
            'defn' => 'shd',
            'defnpayver' => 1,
            'otype' => 'json',
            'platform' => 11001,
            'sdtfrom' => 'v1103',
            'host' => 'v.qq.com'
        );
        $baseUrl = 'http://h5vv.video.qq.com/getinfo?';
        $paramsArr = [];
        foreach ($params as $key => $val){
            $paramsArr[] = $key.'='.$val;
        }
        $paramsStr = join('&', $paramsArr);
        $content = Libs_Http_Client::get($baseUrl.$paramsStr);
        $content_html_pattern = '/=(.*);/s';
        preg_match($content_html_pattern, $content, $info_matchs);
        $infoInfo = json_decode($info_matchs[1], true);
        $fvkey = $infoInfo['vl']['vi'][0]['fvkey'];
        $fn = $infoInfo['vl']['vi'][0]['fn'];
        $self_host = $infoInfo['vl']['vi'][0]['ul']['ui'][0]['url'];
        if($self_host && $fn && $fvkey){
            $real_url = $self_host.$fn.'?vkey='.$fvkey;
            return array(
                'real_url' => $vid,
                'cover' => "https://puui.qpic.cn/qqvideo_ori/0/".$vid."_496_280/0"
            );
        }else{
            return false;
        }
    }

    public function testAction() {
        /*$applet_model   = new App_Model_Applet_MysqlCfgStorage();
        $where[] = array('name' => 'ac_type', 'oper' => 'in', 'value' => [5, 6, 21]);
        $list = $applet_model->getList($where, 0, 0 , array());
        //var_dump($list);
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage(0);
        //开通应用
        foreach($list as $val){
            $indata = array(
                'apo_s_id'           => $val['ac_s_id'],
                'apo_a_id'           => 0,
                'apo_plugin_id'     => 'wms',  //订购类型
                'apo_open_time'     => time(),
                'apo_expire_time'   => $val['ac_expire_time'],
                'apo_update_time'   => time(),
            );
            $ret = $plugin_model->insertValue($indata);
        }

        Libs_Log_Logger::outputLog('enter');*/
    }

    public function levelAction() {
        $uid    = plum_get_int_param('uid');
        $level  = plum_get_int_param('level', 1);
        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

        $refer = array();
        switch($level) {
            case 2 :
                $list = $member_storage->fetchSecondLevelList($uid);
                if ($list) {
                    $ids = array();
                    foreach ($list as $item) {
                        array_push($ids, $item['m_f_id']);
                    }
                    $ids = array_unique($ids, SORT_NUMERIC);
                    $refer = $member_storage->fetchMembersByids($ids);
                }
                break;
            case 3 :
                $list = $member_storage->fetchThirdLevelList($uid);
                if ($list) {
                    $ids = array();
                    foreach ($list as $item) {
                        array_push($ids, $item['m_f_id']);
                    }
                    $ids = array_unique($ids, SORT_NUMERIC);
                    $refer = $member_storage->fetchMembersByids($ids);
                }
                break;
            case 1 :

            default :
                $refer  = array($uid => array('m_nickname' => "wwww"));
                $list = $member_storage->fetchFirstLevelList($uid);
                break;
        }
        Libs_Log_Logger::outputConsoleLog($list);
    }

    public function transAction() {
        $sid    = plum_get_int_param('sid');
        $mid    = plum_get_int_param('mid');
        $amount = plum_get_int_param('money');
        $name   = plum_get_param('name');

        $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($mid);

        $wxpay_plugin   = new App_Plugin_Weixin_PayPlugin($sid);

        $ret = $wxpay_plugin->payTransfer($member['m_openid'], $amount, $name);
        Libs_Log_Logger::outputConsoleLog($ret);
        var_dump($ret);
    }

    public function clearQuotaAction() {
        $sid    = plum_get_int_param('sid');

        $wxcfg_sog  = new App_Model_Auth_MysqlWeixinStorage();
        $cfg    = $wxcfg_sog->findWeixinBySid($sid);

        $url    = "https://api.weixin.qq.com/cgi-bin/clear_quota?access_token={$cfg['wc_auth_access_token']}";
        $param  = array('appid' => $cfg['wc_app_id']);
        $result     = Libs_Http_Client::post($url, json_encode($param));
        $result     = json_decode($result, true);

        Libs_Log_Logger::outputConsoleLog($result);
    }

    public function clearCompoQuotaAction() {
        $plat_cfg   = plum_parse_config('platform', 'weixin');
        //获取token剩余时间
        $p_s    = new App_Model_Auth_RedisWeixinPlatformStorage();

        $token  = $p_s->getCompAccessToken();
        $url    = "https://api.weixin.qq.com/cgi-bin/component/clear_quota?component_access_token={$token}";
        $param  = array('component_appid' => $plat_cfg['app_id']);
        $result     = Libs_Http_Client::post($url, json_encode($param));
        $result     = json_decode($result, true);

        Libs_Log_Logger::outputConsoleLog($result);
    }

    /*
     * 柏拉图文件获取
     */
    public function getbltAction() {
        $month  = plum_get_int_param('m');
        $day    = plum_get_int_param('d');
        $url    = "http://unhe.cn/joymall/4tomake.php";
        for ($i = 1; $i <= $day; $i++) {
            $birthday   = ($month < 10 ? "0{$month}" : $month).($i < 10 ? "0{$i}" : $i);
            $param  = array('name' => '二中', 'birthday' => '2000'.$birthday);
            $ori    = Libs_Http_Client::get($url, $param);

            if ($ori) {
                $oim    = imagecreatefromstring($ori);

                $midim  = imagecreatetruecolor(600, 80);
                $black  = imagecolorallocate($midim, 0, 0, 1);
                imagefill($midim, 0, 0, $black);

                imagecopyresampled($oim, $midim, 0, 265, 0, 0, 600, 80, 600, 80);

                $btmim  = imagecreatetruecolor(600, 130);
                imagefill($btmim, 0, 0, $black);

                imagecopyresampled($oim, $btmim, 0, 580, 0, 0, 600, 130, 600, 130);

                $hold_path  = PLUM_DIR_APP."/storage/file/bolatu";
                $ret = imagejpeg($oim, $hold_path."/{$birthday}.jpeg");
                imagedestroy($oim);
                imagedestroy($midim);
                imagedestroy($btmim);
                Libs_Log_Logger::outputConsoleLog("{$birthday}底图生成".($ret ? "成功" : "失败"));
            } else {
                Libs_Log_Logger::outputConsoleLog("{$birthday}图片资源获取失败");
            }
            usleep(50);
        }
    }

    public function xiubltAction() {
        $url    = "http://unhe.cn/joymall/4tomake.php";

        $birthday   = plum_get_param('b');
        $param  = array('name' => '二中', 'birthday' => '2000'.$birthday);
        $ori    = Libs_Http_Client::get($url, $param);

        if ($ori) {
            $oim    = imagecreatefromstring($ori);

            $midim  = imagecreatetruecolor(600, 80);
            $black  = imagecolorallocate($midim, 0, 0, 1);
            imagefill($midim, 0, 0, $black);

            imagecopyresampled($oim, $midim, 0, 265, 0, 0, 600, 80, 600, 80);

            $btmim  = imagecreatetruecolor(600, 130);
            imagefill($btmim, 0, 0, $black);

            imagecopyresampled($oim, $btmim, 0, 580, 0, 0, 600, 130, 600, 130);

            $hold_path  = PLUM_DIR_APP."/storage/file/bolatu";
            $ret = imagejpeg($oim, $hold_path."/{$birthday}.jpeg");
            imagedestroy($oim);
            imagedestroy($midim);
            imagedestroy($btmim);
            Libs_Log_Logger::outputConsoleLog("{$birthday}底图生成".($ret ? "成功" : "失败"));
        } else {
            Libs_Log_Logger::outputConsoleLog("{$birthday}图片资源获取失败");
        }
    }
    /*
     * 定时任务,处理分期返还
     */
    public function pointAction() {
        set_time_limit(0);
        $queue_model    = new App_Model_Point_MysqlPointQueueStorage();
        $where[]    = array('name' => 'pq_status', 'oper' => '=', 'value' => 0);//返还中
        $sort       = array('pq_create_time' => 'DESC');
        $index      = -1000;
        $count      = 1000;
        Libs_Log_Logger::outputLog("定时任务在执行");
        $curr   = time();
        do {
            $index  += $count;
            $list       = $queue_model->getList($where, $index, $count, $sort);
            foreach ($list as $item) {
                $last_zero  = strtotime(date("Y-m-d", $item['pq_last_time']));
                $unit_day   = 24*60*60;
                switch ($item['pq_unit']) {
                    case 1 :
                        $interval   = 1*$unit_day;
                        break;
                    case 2 :
                        $interval   = 7*$unit_day;
                        break;
                    case 3 :
                        $interval   = 30*$unit_day;
                        break;
                    default :
                        $interval   = 1*$unit_day;
                        break;
                }
                $diff   = $curr-$last_zero;
                if ($item['pq_back_num'] == 0 || $diff > $interval) {
                    $back_num   = intval($item['pq_total_num']);
                    $division   = round(($item['pq_total_point']*100)/$back_num)/100;
                    $had_num    = $item['pq_back_num']+1;
                    $title      = "购买商品{$item['pq_g_name']},分期返还,共获得积分{$item['pq_total_point']},分{$back_num}期返还,本期(第{$had_num}期)获取积分{$division}";
                    $updata     = array(
                        'pq_back_point'     => $had_num == $back_num ? $item['pq_total_point'] : $item['pq_back_point']+$division,
                        'pq_back_num'       => $had_num,
                        'pq_last_time'      => time(),
                        'pq_status'         => $had_num == $back_num ? 1 : 0,
                    );
                    $queue_model->updateById($updata, $item['pq_id']);

                    Libs_Log_Logger::outputLog($title);
                    $point_helper   = new App_Helper_Point($item['pq_s_id']);
                    $point_helper->memberPointRecord($item['pq_m_id'], $division, $title, App_Helper_Point::POINT_INOUT_INCOME, App_Helper_Point::POINT_SOURCE_TRADE, $item['pq_tid']);
                }
            }
        } while (count($list) == $count);
    }

    public function xiuvipAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');
        $mid    = plum_get_int_param('mid');

        //设置各级佣金提成
        $order_deduct   = new App_Helper_OrderDeduct($sid);
        $order_deduct->completeOrderDeduct($tid, $mid);
    }

    public function xiuyouzanAction() {
        set_time_limit(0);
        $order_model    = new App_Model_Shop_MysqlOrderCoreStorage();

        $where[]    = array('name' => 'o_status', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'o_yz_status', 'oper' => '>', 'value' => 0);

        $order  = $order_model->getList($where, 0, 0);

        foreach ($order as $item) {
            Libs_Log_Logger::outputConsoleLog($item);
            $tid    = $item['o_tid'];
            $oauth_client   = new App_Plugin_Youzan_OauthClient($item['o_s_id']);
            $oauth_client->getTradeOnly($tid);
        }
    }

    public function xiuqrcodeAction() {
        $sid    = plum_get_int_param('sid');
        $mid    = plum_get_int_param('mid');
        $shop_weixin    = new App_Helper_ShopWeixin($sid);

        $shop_weixin->sendQrcode($mid);
    }

    public function moveSessAction() {
        set_time_limit(0);
        $type       = plum_get_param('type', 'api');
        $dir_path   = PLUM_DIR_SESSION . '/' . $type;

        $dir_handler    = opendir($dir_path);
        if ($dir_handler) {
            while (($file = readdir($dir_handler)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $file_path  = $dir_path . '/' . $file;
                if (is_dir($file_path)) {
                    continue;
                } else {
                    //判断子目录存在,创建
                    $dir_prefix = substr($file, 5, 2);//获取session_id前两位作为目录前缀
                    $child_path = $dir_path . '/' . $dir_prefix;
                    //判断目录是否存在
                    if (!is_dir($child_path)) {
                        if (!mkdir($child_path, 0775, true)) {
                            Libs_Log_Logger::outputConsoleLog("session save path:{$dir_path} make failed!");
                            continue;
                        }
                    }
                    //移动文件
                    if (rename($file_path, $child_path.'/'.$file)) {
                        Libs_Log_Logger::outputConsoleLog("session file :{$file_path} move success!");
                    } else {
                        Libs_Log_Logger::outputConsoleLog("session file :{$file_path} move failed!");
                    }
                }
            }
            closedir($dir_handler);
        }
    }
    /*
     * 修复店铺每个会员的下三级数量
     */
    public function xiulevelAction() {
        set_time_limit(0);
        $sid    = plum_get_int_param('sid');

        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();

        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);

        $total  = $member_model->getCount($where);
        Libs_Log_Logger::outputConsoleLog($total);

        for ($i = 0; $i <= $total; $i+=20) {
            $list   = $member_model->getList($where, $i, 20);

            foreach ($list as $item) {
                $where1     = array();
                $where1[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
                $where1[]   = array('name' => 'm_1f_id', 'oper' => '=', 'value' => $item['m_id']);
                $count1     = $member_model->getCount($where1);

                $where2     = array();
                $where2[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
                $where2[]   = array('name' => 'm_2f_id', 'oper' => '=', 'value' => $item['m_id']);
                $count2     = $member_model->getCount($where2);

                $where3     = array();
                $where3[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
                $where3[]   = array('name' => 'm_3f_id', 'oper' => '=', 'value' => $item['m_id']);
                $count3     = $member_model->getCount($where3);

                $updata = array(
                    'm_1c_count'    => intval($count1),
                    'm_2c_count'    => intval($count2),
                    'm_3c_count'    => intval($count3),
                );

                $ret = $member_model->updateById($updata, $item['m_id']);

                if ($ret) {
                    Libs_Log_Logger::outputConsoleLog("会员ID{$item['m_id']}修改下三级数量成功");
                } else {
                    Libs_Log_Logger::outputConsoleLog("会员ID{$item['m_id']}修改下三级数量失败");
                }
            }
        }

        Libs_Log_Logger::outputConsoleLog("处理完成");
    }
    /*
     * 修复微砍价订单无法实时到账问题
     */
    public function xiubargainAction() {
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');

        $order_model    = new App_Model_Bargain_MysqlOrderStorage($sid);
        $order  = $order_model->findUpdateOrderByTid($tid);

        $trade_helper   = new App_Helper_Trade($sid);
        $trade_helper->recordRealtimeTransfer($order['bo_amount'], "微砍价支付金额实时到账");

        Libs_Log_Logger::outputConsoleLog($order);
    }
    /*
     * 修复门店会员卡
     */
    public function xiucardAction() {
        $sid    = plum_get_int_param('sid');

        $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
        $where[]    = array('name' => 'm_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'm_card_long', 'oper' => '>', 'value' => time());

        $list   = $member_model->getList($where, 0, 0);
        $offline_model  = new App_Model_Store_MysqlMemberStorage($sid);
        foreach ($list as $item) {
            $indata = array(
                'om_s_id'       => $sid,
                'om_m_id'       => $item['m_id'],
                'om_expire_time'=> $item['m_card_long'],
                'om_card_num'   => $item['m_level_card'],
                'om_create_time'=> time(),
            );
            $offline_model->insertValue($indata);
            Libs_Log_Logger::outputConsoleLog($item);
        }
    }

    public function sqltestAction() {
        $sid    = plum_get_int_param('sid');
        $goid   = plum_get_int_param('goid');

        $group_helper   = new App_Helper_Group($sid);
        $ret = $group_helper->groupOrgOvertime($goid);
        Libs_Log_Logger::outputConsoleLog($ret);
    }

    public function sendtestAction() {
        $tid    = plum_get_param('tid');
        $sid    = plum_get_int_param('sid');

        $group_helper   = new App_Helper_Group($sid);
        $group_helper->sendGroupTmplmsg($tid, 'zfcg');
    }
    
    public function smstestAction() {
        $quxun  = new App_Plugin_Sms_QuXunPlugin();
        $ret    = $quxun->sendSms('18530990310', '这是一条订单,订单名称为哇哈哈');
        
        Libs_Log_Logger::outputConsoleLog($ret);
    }

    public function mailtestAction() {
        App_Helper_Tool::sendShopNoticeMail(11, '这是一条订单,订单名称为哇哈哈');
    }

    public function xiuwdAction() {
        $order_model    = new App_Model_Shop_MysqlOrderCoreStorage();

        $where[]    = array('name' => 'o_status', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'o_wd_status', 'oper' => '>', 'value' => 0);

        $list       = $order_model->getList($where, 0, 0);

        foreach ($list as $item) {
            $sid    = $item['o_s_id'];
            $wd_client      = new App_Plugin_Weidian_Client($sid);

            $detail     = $wd_client->getOrderDetail($item['o_tid']);
            if ($detail) {
                $status = $detail['status'];
                switch ($status) {
                    case 'unpay' :
                        $curr_status    = App_Helper_OrderLevel::ORDER_NO_PAY;
                        break;
                    case 'pay' :
                    case 'ship' :
                        $curr_status    = App_Helper_OrderLevel::ORDER_HAD_PAY;
                        break;
                    case 'accept' :
                    case 'finish' :
                        $curr_status    = App_Helper_OrderLevel::ORDER_HAD_COMPLETE;
                        break;
                    case 'close' :
                        $curr_status    = App_Helper_OrderLevel::ORDER_HAD_CLOSED;
                        break;
                    case 'seller_refund' :
                        $curr_status    = App_Helper_OrderLevel::ORDER_REFUND;
                        break;
                    default :
                        $curr_status    = 0;
                        break;
                }
                if ($curr_status) {
                    $order_level    = new App_Helper_OrderLevel($sid);
                    $order_level->weidianOrderUpdateDeal($detail, $curr_status);
                    Libs_Log_Logger::outputConsoleLog("订单{$detail['trade_no']}已处理完成");
                }
            }
        }
    }

    public function testadrAction() {
        $sid        = plum_get_int_param('sid', 12);
        $index      = plum_get_int_param('index', 0);
        $adr_model  = new App_Model_Member_MysqlAddressStorage($sid);
        $list       = $adr_model->getList(array(), $index, 100);
        $adr_helper = new App_Helper_Address();
        foreach ($list as $item) {
            $ret    = $adr_helper->getLevelRegion($item['ma_province'], $item['ma_city'], $item['ma_zone']);
            if ($ret) {
                Libs_Log_Logger::outputConsoleLog($ret);
            } else {
                Libs_Log_Logger::outputConsoleLog("获取失败");
                Libs_Log_Logger::outputConsoleLog($item);
            }
        }
    }

    public function refundTradeAction() {
        $tid    = plum_get_param('tid');
        $sid    = plum_get_int_param('sid');

        $trade_model    = new App_Model_Trade_MysqlTradeStorage($sid);
        $trade      = $trade_model->findUpdateTradeByTid($tid);
        $refund_model   = new App_Model_Trade_MysqlTradeRefundStorage($sid);

        $indata     = array(
            'tr_s_id'       => $sid,
            'tr_wid'        => App_Plugin_Weixin_PayPlugin::makeMchOrderid('W'),
            'tr_tid'        => $tid,
            'tr_reason'     => '系统自动退款',//退款原因
            'tr_money'      => $trade['t_total_fee'],
            'tr_create_time'=> time(),//退款编号创建时间
            'tr_status'     => 0,//退款处理中
        );
        $rfid = $refund_model->insertValue($indata);
        $trade_helper   = new App_Helper_Trade($sid);
        $ret = $trade_helper->dealRefund($trade['t_id']);
    }

    public function testbgAction() {
        set_time_limit(0);
        $a  = plum_get_int_param('a');
        $b  = plum_get_param('b');
        $c  = plum_get_float_param('c');

        $msg    = "参数分别是:a={$a};b={$b};c={$c}";
        Libs_Log_Logger::outputLog("控制台被执行;".$msg);
    }
    /*
     * 修复待结算造成的bug
     */
    public function xiudjsAction() {
        set_time_limit(0);
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage(0);

        //$where[]    = array('name' => 'ts_id', 'oper' => '>', 'value' => 800);
        $where[]    = array('name' => 'ts_status', 'oper' => '=', 'value' => 2);//未结算成功

        $index      = -50;
        $count      = 50;
        $point      = plum_parse_config('wxpay_point', 'weixin');

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        do {
            $index  += $count;
            $list   = $settled_model->getList($where, $index, $count);
            foreach ($list as $item) {
                $trade_model    = new App_Model_Trade_MysqlTradeStorage($item['ts_s_id']);
                $trade  = $trade_model->findUpdateTradeByTid($item['ts_tid']);

                $type   = intval($trade['t_pay_type']);
                if (!in_array($type, array(2,3))) {
                    Libs_Log_Logger::outputLog("退款结算订单{$item['ts_title']}在处理中");
                    /*
                    $amount     = intval(100*$item['ts_amount']);//单位分
                    $less       = ceil($amount*$point);
                    $none       = $amount-$less;
                    Libs_Log_Logger::outputLog("已结算订单{$item['ts_tid']}结算{$none}分将被扣除");

                    $shop       = $shop_model->getRowById($item['ts_s_id']);
                    $balance    = intval(100*$shop['s_balance']);//单位分
                    Libs_Log_Logger::outputLog("店铺{$item['ts_s_id']}收益为{$balance}分,被扣除前");
                    //记录支出
                    $outdata    = array(
                        'si_s_id'   => $item['ts_s_id'],
                        'si_name'   => "订单: {$item['ts_title']} 使用自有支付,已结算金额被扣除",
                        'si_amount' => $none/100,
                        'si_balance'=> ($balance-$none)/100,
                        'si_type'   => 2,
                        'si_create_time'    => time(),
                    );
                    $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($item['ts_s_id']);
                    $inout_model->insertValue($outdata);
                    //修改余额
                    $shop_model->incrementShopBalance($item['ts_s_id'], -($none/100));
                    $trade_redis    = new App_Model_Trade_RedisTradeStorage($item['ts_s_id']);
                    $trade_redis->delTradeSettledTtl($item['ts_id']);
                    $settled_model->deleteById($item['ts_id']);
                    */
                }
            }

        }while(count($list) == $count);
    }

    public function addDomainAction() {
        $sid    = plum_get_int_param('sid');
        $domain = plum_get_param('domain');
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($sid);
        //首先添加现有服务器域名
        $wxxcx_client->coverCodeDomain($domain, $domain, $domain, $domain, 'add');
    }

    public function getDomainAction() {
        $sid    = plum_get_int_param('sid');
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($sid);
        //首先添加现有服务器域名
        $domain = $wxxcx_client->fetchCodeDomain();
        Libs_Log_Logger::outputConsoleLog($domain);
    }


    /*
     * 二手车 批量保存车型
     */
    public function saveCarTypeAction(){
        $brand_model = new App_Model_Car_MysqlCarBrandStorage();
        $type_model = new App_Model_Car_MysqlCarTypeStorage();
        $aliyun_storage = new App_Plugin_Aliyun_Apiset();
        $where[] = ['name' => 'cb_cate_id', 'oper' => 'in', 'value' => [4233,4231,4232]];
        $list = $brand_model->getList($where,0,0);
        foreach ($list as $value){
//            if(!in_array($value['cb_cate_id'],[4631,4431,5231,4233,4231,4232])){
//
//            }
           if(in_array($value['cb_cate_id'],[4233,4231,4232])){
               $insert = [];
               $cateId = $value['cb_cate_id'];
               $ret = $aliyun_storage->fetchCarDetailData($cateId);
               $brands = $ret['cars'];
               foreach ($brands as $k => $brand_row){
                   if($k > 0){
                       foreach($brand_row['typeList'] as $val){
                           $img = '';
                           if($val['imgUrl']){
                               $img = $this->_download_article_image($val['imgUrl']);
                           }
                           $insert[] = " (NULL, '{$value['cb_id']}','{$val['typeName']}', '{$val['guidePrice']}', '{$value['cb_cate_id']}','{$val['imgUrl']}', '{$img}', '0') ";
                       }
                   }
               }
               $type_model->batchSave($insert);
            }
        }
    }

    /**
     * 跑腿 修改骑手最新推送状态
     */
    public function changeLegworkRiderNoticeAction(){
        $sid    = plum_get_int_param('sid');
        $rider_model = new App_Model_Legwork_MysqlLegworkRiderStorage($sid);
        $set = [
            'alr_new_notice' => 1
        ];
        $where = [];
        $where[] = ['name' => 'alr_s_id', 'oper' => '=', 'value' => $sid];
        $rider_model->updateValue($set,$where);

    }

    /**
     * 社区团购
     * 修正 完成订单
     */
    public function finishSequenceOrderAction(){
        $sid    = plum_get_int_param('sid');
        $trade_model= new App_Model_Trade_MysqlTradeStorage($sid);
        $where = [];
        $where[] = ['name' => 't_s_id', 'oper' => '=', 'value' => $sid];
        $where[] = ['name' => 't_create_time', 'oper' => '>=', 'value' => 1546272000];
        $where[] = ['name' => 't_create_time', 'oper' => '<=', 'value' => 1546963199];
        $where[] = ['name' => 't_status', 'oper' => 'in', 'value' => [3,4,5]];
        $where[] = ['name' => 't_feedback', 'oper' => '=', 'value' => 0];
        $where[] = ['name' => 't_applet_type', 'oper' => '=', 'value' => 11];
        $tradeList = $trade_model->getList($where,0,0,['t_id'=>'ASC'],['t_id','t_tid','t_se_leader','t_se_group','t_se_send_time','t_goods_fee','t_payment']);
        if($tradeList){
            foreach ($tradeList as $trade_row){
                $updata = array(
                    't_finish_time' => time(),
                    't_status'      => App_Helper_Trade::TRADE_FINISH,//置于完成状态
                );
                $ret = $trade_model->updateById($updata,$trade_row['t_id']);
                if($ret){
                    //获得该订单所有未核销商品
                    $order_model = new App_Model_Trade_MysqlTradeOrderStorage($sid);
                    $orderIds = [];
                    $where_order = [];
                    $where_order[] = ['name'=>'to_t_id','oper'=>'=','value'=>$trade_row['t_id']];
                    $where_order[] = ['name'=>'to_se_verify','oper'=>'=','value'=>0];
                    $order_list = $order_model->getList($where_order,0,0);
                    foreach ($order_list as $order){
                        $orderIds[] = $order['to_id'];
                    }
                    if(!empty($orderIds)){
                        $where_order = [];
                        $set = [
                            'to_se_verify' => 1,
                            'to_se_verify_time' => time()
                        ];
                        $where_order[] = ['name'=>'to_id','oper'=>'in','value'=>$orderIds];
                        $order_model->updateValue($set,$where_order);
                    }
                    $sequence_helper = new App_Helper_Sequence($sid);
                    $sequence_helper->dealSequenceVerify($trade_row,0,false);
                }
            }

        }
    }

    public function townDeductAction(){
        $town = plum_get_int_param('town');
        $sid  = plum_get_int_param('sid');
        $number = plum_get_param('number');
        $totalCost = plum_get_param('totalCost');
        $type = plum_get_param('type');
        $helper = new App_Helper_Trade($sid);
        $helper->dealTownDeduct($town,$number,$type,$totalCost);
    }

    public function goodsStockAlertAction(){
        $sid  = plum_get_int_param('sid');
        $gid  = plum_get_int_param('gid');
        $gfid = plum_get_int_param('gfid');
        $goods_model = new App_Model_Goods_MysqlGoodsStorage();
        $goods = $goods_model->getRowById($gid);
        $data = [
            'g_id' => $goods['g_id'],
            'g_es_id' => $goods['g_es_id'],
            'g_name' => $goods['g_name']
        ];
        if($gfid){
            $format_model = new App_Model_Goods_MysqlFormatStorage($sid);
            $format = $format_model->findFormatByGfid($gfid,$gid);
            $data['g_name'] = $data['g_name'].'（'.$format['gf_name'].$format['gf_name2'].$format['gf_name3'].'）';
        }
        $jiguang = new App_Helper_JiguangPush($sid);
        $jiguang->pushNotice($jiguang::GOODS_STOCK_ALERT,$data);
    }

    public function dealAnswerBuyAction(){
        $sid  = plum_get_int_param('sid');
        $aid  = plum_get_int_param('aid');
        $qType = plum_get_int_param('qType');
        $mid  = plum_get_int_param('mid');
        $money  = plum_get_param('money');

        $answerpay_helper = new App_Helper_Answerpay($sid);
        $answerpay_helper->dealAnswerBuy($mid,$aid,$qType,$money);

    }

    /**
     * 邀新用户订单处理
     * zhangzc
     * 2019-08-27
     * @return [type] [description]
     */
    public function inviteUserTradeAction(){
        $pay_type   =plum_get_int_param('pay_type');
        $gids       =plum_get_param('gids');
        $t_tid      =plum_get_param('t_tid');
        $payment    =plum_get_param('payment');
        $mid        =plum_get_param('mid');
        $sid        =plum_get_param('sid');
        $gids       =json_decode($gids,TRUE);

        $trade_helper   = new App_Helper_Trade($sid);
        $trade_helper->tradeInviteDeal($pay_type,$gids,$t_tid,$payment,$mid);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/18
 * Time: 上午8:58
 */

class App_Controller_Wxapp_TplmsgController extends App_Controller_Wxapp_InitController{

    public function __construct() {
        parent::__construct();
    }


    public function tplMsgListAction(){
        $tplid   = $this->request->getStrParam('tplid');
        $page    = $this->request->getIntParam('page');
        $index   = $page * $this->count;
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $total          = $tpl_msg_model->getCountByTplid($tplid);
        $page_libs      = new Libs_Pagination_Paginator($total,$this->count);
        $list           = array();

        if($total > $index){
            $list = $tpl_msg_model->getListByTplid($tplid,$index,$this->count);
            foreach($list as &$val){
                $temp = json_decode($val['awt_remind'],true);
                $val['remind'] = $temp['contxt'];
                $val['color']  = $temp['color'];
            }
        }

        $tpl_model = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $tpl = $tpl_model->getRowTplId($tplid);
        $subscribe = $tpl['awt_type'] == 2 ? 1 : 0;
        $this->output['list']       = $list;
        $this->output['tplid']      = $tplid;
        $this->output['pageHtml']   = $page_libs->render();
        $this->output['subscribe']  = $subscribe;
        if($subscribe){
            $url = '/wxapp/tplmsg/subscribeTpl';
        }else{
            $url = '/wxapp/tplmsg/tpl';
        }

        $this->buildBreadcrumbs(array(
            array('title' => '微信消息模版', 'link' => $url),
            array('title' => '自定义消息', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tplmsg/tplmsg-list.tpl');
    }
    /*
     * 消息模板管理
     */
    public function tplmsgManageAction() {
        $data = $this->get_row_data();
        if(empty($data)){
            $data = $this->get_add_dfdata();
        }

        $this->output['data'] = $data;
        $kind = plum_parse_config('kind','tmplmsg');
        $msg  = plum_parse_config('message','tmplmsg');
        $appletMsgCfg = plum_parse_config('appletMsg','tmplmsg');
        $appletMsg = $appletMsgCfg[$this->wxapp_cfg['ac_type']];

        foreach ($msg as $key => $val){
            if(!in_array($key, $appletMsg)){
                unset($kind[$key]);
                unset($msg[$key]);
            }
        }


        if($this->wxapp_cfg['ac_type'] == 27){
            $kind[12] = "课程/商品推送变量替换";

//            $kind_row = $kind[53];
//            unset($kind[53]);
//            array_unshift($kind,[53=>$kind_row]);
        }

        $this->output['kind'] = $kind;
        $this->output['msg']  = $msg;

        $this->output['day']  = date('m月d日',$_SERVER['REQUEST_TIME']);
        $this->buildBreadcrumbs(array(
            array('title' => '微信消息模版', 'link' => '/wxapp/tplmsg/tpl'),
            array('title' => '自定义消息', 'link' => '/wxapp/tplmsg/tplmsgList?tplid='.$data['tplid']),
            array('title' => '添加自定义消息', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tplmsg/tplmsg-manage.tpl');
    }


    /*
     * 消息模板管理
     */
    public function subscribeMsgManageAction() {
        $data = $this->get_row_data();
        if(empty($data)){
            $data = $this->get_add_subscribe_dfdata();
        }
    
        $this->output['data'] = $data;
        $kind = plum_parse_config('kind','tmplmsg');
        $msg  = plum_parse_config('message','tmplmsg');
        $appletMsgCfg = plum_parse_config('appletMsg','tmplmsg');
        $appletMsg = $appletMsgCfg[$this->wxapp_cfg['ac_type']];

        foreach ($msg as $key => $val){
            if(!in_array($key, $appletMsg)){
                unset($kind[$key]);
                unset($msg[$key]);
            }
        }


        if($this->wxapp_cfg['ac_type'] == 27){
            $kind[12] = "课程/商品推送变量替换";
        }

        $this->output['kind'] = $kind;
        $this->output['msg']  = $msg;
        $this->output['subscribe'] = 1;
        $this->output['day']  = date('m月d日',$_SERVER['REQUEST_TIME']);
        $this->buildBreadcrumbs(array(
            array('title' => '微信消息模版', 'link' => '/wxapp/tplmsg/subscribeTpl'),
            array('title' => '自定义消息', 'link' => '/wxapp/tplmsg/tsubscribeMsgList?tplid='.$data['tplid']),
            array('title' => '添加自定义消息', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tplmsg/tplmsg-manage.tpl');
    }

    /*
     * 消息模板发送设置
     */
    public function tplmsgSetupAction() {
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $tplList = $tpl_msg_model->getList($where,0,0);
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $row = $setup_model->findOneBySid();

        $this->output['tplList'] = $tplList;
        $this->output['applet'] = $this->wxapp_cfg;
        $this->output['row'] = $row;

        if(in_array($this->wxapp_cfg['ac_type'],plum_parse_config('show_answer_push','allow'))){
            $showAnswerPush = 1;
        }else{
            $showAnswerPush = 0;
        }
        $this->output['showAnswerPush'] = $showAnswerPush;

        $this->buildBreadcrumbs(array(
            array('title' => '消息模板发送设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tplmsg/tplmsg-setup.tpl');
    }

    /*
     * 消息模板发送设置
     */
    public function subscribeMsgSetupAction() {
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $where[] = array('name' => 'awt_type','oper' => '=', 'value' => 2);
        $tplList = $tpl_msg_model->getList($where,0,0);
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $row = $setup_model->findOneBySid();

        $this->output['tplList'] = $tplList;
        $this->output['applet'] = $this->wxapp_cfg;
        $this->output['row'] = $row;
        $this->output['subscribe'] = 1;
        $this->buildBreadcrumbs(array(
            array('title' => '消息模板发送设置', 'link' => '#'),
        ));

        $defaultMsg = plum_parse_config('defaultMsg','subscribeMsg');
        $showDefault = [];
        foreach ($defaultMsg[$this->wxapp_cfg['ac_type']] as $key =>$val){
            $showDefault[$key] = true;
        }
        $this->output['showDefault'] = $showDefault;


        $this->displaySmarty('wxapp/tplmsg/tplmsg-setup.tpl');
    }

    /*
     * 保存发送设置
     */
    public function saveSetupAction() {
        $data['aws_mjfh_mid']     = $this->request->getIntParam('mjfh_mid');
        $data['aws_mjfh_open']    = $this->request->getIntParam('mjfh_open');
        $data['aws_qrsh_mid']     = $this->request->getIntParam('qrsh_mid');
        $data['aws_qrsh_open']    = $this->request->getIntParam('qrsh_open');
        $data['aws_zfcg_mid']     = $this->request->getIntParam('zfcg_mid');
        $data['aws_zfcg_open']    = $this->request->getIntParam('zfcg_open');
        $data['aws_audit_mid']    = $this->request->getIntParam('audit_mid');
        $data['aws_audit_open']   = $this->request->getIntParam('audit_open');
        $data['aws_comment_mid']  = $this->request->getIntParam('comment_mid');
        $data['aws_comment_open'] = $this->request->getIntParam('comment_open');
        $data['aws_like_mid']     = $this->request->getIntParam('like_mid');
        $data['aws_like_open']    = $this->request->getIntParam('like_open');
        $data['aws_reward_mid']   = $this->request->getIntParam('reward_mid');
        $data['aws_reward_open']  = $this->request->getIntParam('reward_open');
        $data['aws_share_mid']    = $this->request->getIntParam('share_mid');
        $data['aws_share_open']   = $this->request->getIntParam('share_open');
        $data['aws_push_mid']     = $this->request->getIntParam('push_mid');
        $data['aws_push_open']    = $this->request->getIntParam('push_open');
        $data['aws_sexpire_mid']  = $this->request->getIntParam('sexpire_mid');
        $data['aws_sexpire_open'] = $this->request->getIntParam('sexpire_open');
        $data['aws_service_mid']  = $this->request->getIntParam('service_mid');
        $data['aws_service_open'] = $this->request->getIntParam('service_open');
        $data['aws_lottery_mid']  = $this->request->getIntParam('lottery_mid');
        $data['aws_lottery_open'] = $this->request->getIntParam('lottery_open');
        $data['aws_appointment_mid']  = $this->request->getIntParam('appointment_mid');
        $data['aws_appointment_open'] = $this->request->getIntParam('appointment_open');
        $data['aws_appointment_remind_mid']  = $this->request->getIntParam('appointment_remind_mid');
        $data['aws_appointment_remind_open'] = $this->request->getIntParam('appointment_remind_open');
        $data['aws_upgrade_mid']  = $this->request->getIntParam('upgrade_mid');
        $data['aws_upgrade_open'] = $this->request->getIntParam('upgrade_open');
        $data['aws_goods_mid']    = $this->request->getIntParam('goods_mid');
        $data['aws_goods_open']   = $this->request->getIntParam('goods_open');
        $data['aws_group_mid']    = $this->request->getIntParam('group_mid');
        $data['aws_group_open']   = $this->request->getIntParam('group_open');
        $data['aws_limit_mid']    = $this->request->getIntParam('limit_mid');
        $data['aws_limit_open']   = $this->request->getIntParam('limit_open');
        $data['aws_bargain_mid']  = $this->request->getIntParam('bargain_mid');
        $data['aws_bargain_open'] = $this->request->getIntParam('bargain_open');
        $data['aws_post_mid']     = $this->request->getIntParam('post_mid');
        $data['aws_post_open']    = $this->request->getIntParam('post_open');
        $data['aws_shop_mid']     = $this->request->getIntParam('shop_mid');
        $data['aws_shop_open']    = $this->request->getIntParam('shop_open');
        $data['aws_coupon_mid']   = $this->request->getIntParam('coupon_mid');
        $data['aws_coupon_open']  = $this->request->getIntParam('coupon_open');
        $data['aws_answer_mid']   = $this->request->getIntParam('answer_mid');
        $data['aws_answer_open']  = $this->request->getIntParam('answer_open');
        $data['aws_dynamic_mid']  = $this->request->getIntParam('dynamic_mid');
        $data['aws_dynamic_open'] = $this->request->getIntParam('dynamic_open');
        $data['aws_recharge_mid']  = $this->request->getIntParam('recharge_mid');
        $data['aws_recharge_open'] = $this->request->getIntParam('recharge_open');
        $data['aws_refund_mid']   = $this->request->getIntParam('refund_mid');
        $data['aws_refund_open']  = $this->request->getIntParam('refund_open');

        $data['aws_deduct_mid']   = $this->request->getIntParam('deduct_mid');
        $data['aws_deduct_open']  = $this->request->getIntParam('deduct_open');

        $data['aws_work_order_create_mid']    = $this->request->getIntParam('work_order_create_mid');
        $data['aws_work_order_create_open']   = $this->request->getIntParam('work_order_create_open');
        $data['aws_work_order_dealing_mid']   = $this->request->getIntParam('work_order_dealing_mid');
        $data['aws_work_order_dealing_open']  = $this->request->getIntParam('work_order_dealing_open');
        $data['aws_work_order_finish_mid']    = $this->request->getIntParam('work_order_finish_mid');
        $data['aws_work_order_finish_open']   = $this->request->getIntParam('work_order_finish_open');
        $data['aws_work_order_comment_mid']   = $this->request->getIntParam('work_order_comment_mid');
        $data['aws_work_order_comment_open']  = $this->request->getIntParam('work_order_comment_open');

        $data['aws_job_send_change_mid']        = $this->request->getIntParam('job_send_change_mid');
        $data['aws_job_send_change_open']       = $this->request->getIntParam('job_send_change_open');
        $data['aws_job_recommend_success_mid']  = $this->request->getIntParam('job_recommend_success_mid');
        $data['aws_job_recommend_success_open'] = $this->request->getIntParam('job_recommend_success_open');
        $data['aws_job_position_push_mid']  = $this->request->getIntParam('job_position_push_mid');
        $data['aws_job_position_push_open'] = $this->request->getIntParam('job_position_push_open');
        $data['aws_job_resume_show_mid']    = $this->request->getIntParam('job_resume_show_mid');
        $data['aws_job_resume_show_open']   = $this->request->getIntParam('job_resume_show_open');

        $data['aws_express_trade_mid']  = $this->request->getIntParam('express_trade_mid');
        $data['aws_express_trade_open'] = $this->request->getIntParam('express_trade_open');

        $data['aws_se_create_activity_mid']  = $this->request->getIntParam('se_create_activity_mid');
        $data['aws_se_create_activity_open'] = $this->request->getIntParam('se_create_activity_open');
        $data['aws_se_join_activity_mid']  = $this->request->getIntParam('se_join_activity_mid');
        $data['aws_se_join_activity_open'] = $this->request->getIntParam('se_join_activity_open');
        $data['aws_se_trade_verify_mid']  = $this->request->getIntParam('se_trade_verify_mid');
        $data['aws_se_trade_verify_open'] = $this->request->getIntParam('se_trade_verify_open');
        $data['aws_se_notice_leader_mid']  = $this->request->getIntParam('se_notice_leader_mid');
        $data['aws_se_notice_leader_open'] = $this->request->getIntParam('se_notice_leader_open');
        $data['aws_se_goods_get_mid']  = $this->request->getIntParam('se_goods_get_mid');
        $data['aws_se_goods_get_open'] = $this->request->getIntParam('se_goods_get_open');

        $data['aws_fpush_open']  = $this->request->getIntParam('fpush_open');
        $data['aws_fpush_mid'] = $this->request->getIntParam('fpush_mid');

        $data['aws_chat_open']  = $this->request->getIntParam('chat_open');
        $data['aws_chat_mid'] = $this->request->getIntParam('chat_mid');

        $data['aws_meal_start_queue_open'] = $this->request->getIntParam('meal_start_queue_open');
        $data['aws_meal_start_queue_mid']  = $this->request->getIntParam('meal_start_queue_mid');
        $data['aws_meal_call_queue_open']  = $this->request->getIntParam('meal_call_queue_open');
        $data['aws_meal_call_queue_mid']   = $this->request->getIntParam('meal_call_queue_mid');
        //跑腿相关
        if($this->wxapp_cfg['ac_type'] == 34){
            $data['aws_legwork_pay_mid']  = $this->request->getIntParam('legwork_pay_mid');
            $data['aws_legwork_pay_open'] = $this->request->getIntParam('legwork_pay_open');
            $data['aws_legwork_get_mid']  = $this->request->getIntParam('legwork_get_mid');
            $data['aws_legwork_get_open'] = $this->request->getIntParam('legwork_get_open');
            $data['aws_legwork_cancel_mid']  = $this->request->getIntParam('legwork_cancel_mid');
            $data['aws_legwork_cancel_open'] = $this->request->getIntParam('legwork_cancel_open');
            $data['aws_legwork_finish_mid']  = $this->request->getIntParam('legwork_finish_mid');
            $data['aws_legwork_finish_open'] = $this->request->getIntParam('legwork_finish_open');
            $data['aws_legwork_take_mid']  = $this->request->getIntParam('legwork_take_mid');
            $data['aws_legwork_take_open'] = $this->request->getIntParam('legwork_take_open');
        }

        $data['aws_buy_member_card_mid']  = $this->request->getIntParam('buy_member_card_mid');
        $data['aws_buy_member_card_open'] = $this->request->getIntParam('buy_member_card_open');

        $data['aws_leader_handle_mid']  = $this->request->getIntParam('leader_handle_mid');
        $data['aws_leader_handle_open'] = $this->request->getIntParam('leader_handle_open');

        $data['aws_points_change_mid']  = $this->request->getIntParam('points_change_mid');
        $data['aws_points_change_open'] = $this->request->getIntParam('points_change_open');

        $data['aws_coin_change_mid']  = $this->request->getIntParam('coin_change_mid');
        $data['aws_coin_change_open'] = $this->request->getIntParam('coin_change_open');

        $data['aws_meeting_bmcg_mid']  = $this->request->getIntParam('meeting_bmcg_mid');
        $data['aws_meeting_bmcg_open'] = $this->request->getIntParam('meeting_bmcg_open');

        $data['aws_form_deal_mid']  = $this->request->getIntParam('form_deal_mid');
        $data['aws_form_deal_open'] = $this->request->getIntParam('form_deal_open');

        // 店铺被评论通知
        $data['aws_shop_comment_mid']  = $this->request->getIntParam('shop_comment_mid');
        $data['aws_shop_comment_open'] = $this->request->getIntParam('shop_comment_open');

        // 电话本入驻审核通知
        $data['aws_mobile_audit_mid']  = $this->request->getIntParam('mobile_audit_mid');
        $data['aws_mobile_audit_open'] = $this->request->getIntParam('mobile_audit_open');

        // 店铺认领审核通知
        $data['aws_shop_claim_mid']  = $this->request->getIntParam('shop_claim_mid');
        $data['aws_shop_claim_open'] = $this->request->getIntParam('shop_claim_open');
        // 用户验证申请处理结果
        $data['aws_mobile_apply_mid']  = $this->request->getIntParam('mobile_apply_mid');
        $data['aws_mobile_apply_open'] = $this->request->getIntParam('mobile_apply_open');

        $data['aws_update_time']  = time();
        $data['aws_s_id']         = $this->curr_sid;

        if($this->menuType == 'weixin'){
            $setup_model = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }

        $row = $setup_model->findOneBySid();
        if($row){
            $ret = $setup_model->updateById($data, $row['aws_id']);
        }else{
            $data['aws_create_time'] = time();
            $ret =  $setup_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("编辑模板消息发送设置");
        $this->showAjaxResult($ret);
    }

    /*
    * 保存发送设置
    */
    public function saveOtherLegworkSetupAction() {

        $data['aws_legwork_get_mid']  = $this->request->getIntParam('legwork_get_mid');
        $data['aws_legwork_get_open'] = $this->request->getIntParam('legwork_get_open');
        $data['aws_legwork_take_mid']  = $this->request->getIntParam('legwork_take_mid');
        $data['aws_legwork_take_open'] = $this->request->getIntParam('legwork_take_open');
        $data['aws_legwork_finish_mid']  = $this->request->getIntParam('legwork_finish_mid');
        $data['aws_legwork_finish_open'] = $this->request->getIntParam('legwork_finish_open');

        $data['aws_update_time']  = time();
        $data['aws_s_id']         = $this->curr_sid;
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $row = $setup_model->findOneBySid();
        if($row){
            $ret = $setup_model->updateById($data, $row['aws_id']);
        }else{
            $data['aws_create_time'] = time();
            $ret =  $setup_model->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("跑腿配置模板消息保存成功");
        }

        $this->showAjaxResult($ret);
    }

    /**
     * @return array
     * 编辑时候获取单条记录
     */
    private function
     get_row_data(){
        $id     = $this->request->getIntParam('id');
        $data   = array();
        if($id > 0){
            $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $row            = $tpl_msg_model->getRowByIdSid($id,$this->curr_sid);
            if(!empty($row)){
                $data = array(
                    'id'        => $row['awt_id'],
                    'page'       => $row['awt_page'],
                    'title'     => $row['awt_title'],
                    'item'      => $row['awt_data'],
                    'tplid'     => $row['awt_tplid'],
                    'emphasis'  => $row['awt_emphasis']
                );
            }
        }
        return $data;
    }

    /**
     * @return array
     * 新增时获取默认值
     */
    private function get_add_dfdata(){
        $tplId      = $this->request->getStrParam('tplId');
        $data       = array();
        $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $tpl        = $tpl_model->getRowTplId($tplId);
        if($tpl){
            $data['id']     = 0;
            $data['page']    = '';
            $data['tplid']  = $tplId;
            $data['title']  = $tpl['awt_title'];
            $reg = '/{{(.+?)}}/';
            preg_match_all($reg,$tpl['awt_content'],$matches);

  
            if(!empty($matches)){
                //@todo 键值
                $items   = $matches[count($matches)-1];
                $content       = explode("\n", $tpl['awt_example']);
                $title         = array(); //结构体头部
                $keyword       = array(); //结构体中间
                $remark        = array(); //结构体备注
                $i             = 0;
                foreach($content as $fal){
                    if($fal){
                        if($tplId == 'ISdGDaiGoKADvrEgWdML3cFHzkVFN0lWpzhVWtnSmrw'){ //订单发货提醒的微信模版中文冒号（“：”），微信整成功英文冒号，所有需要替换
                            $fal  = str_replace(':','：',$fal);
                        }
                        $temp = explode('：',$fal);
                        if(count($temp) > 1){ //中间
                            $keyword[] = array(
                                'titletxt'  => $temp[0],
                                'contxt'    => $temp[1],
                                'color'     => '#5976be',
                                'key'       => str_replace('.DATA','',$items[$i]),
                            );
                        }else{ //头部和尾部
                            if(empty($title)){
                                $title = array(
                                    'contxt'    => mb_substr($temp[0],0,10),
                                    'color'     => '#FF1F1F',
                                    'key'       => str_replace('.DATA','',$items[$i]),
                                );
                            }else{
                                $remark = array(
                                    'contxt'    => mb_substr($temp[0],0,10),
                                    'color'     => '#FF1F1F',
                                    'key'       => str_replace('.DATA','',$items[$i]),
                                );
                            }
                        }
                        $i ++ ;
                    }
                }
                //备注未绑定上
                if(empty($remark)){
                    $last = $items[count($items) -1];
                    $last = str_replace('.DATA','',$last);
                    if(in_array($last,array('remark','Remark'))){
                        $remark = array(
                            'contxt'    => '',
                            'color'     => '#FF1F1F',
                            'key'       => $last,
                        );
                    }
                }
                //标题前缀、后缀

                $fields  = explode("\n", $tpl['awt_content']);
                $first   = explode('{{'.$items[0].'}}',$fields[0]);
                $data['item']   = json_encode($keyword);
            }
        }
        return $data;
    }


    /**
     * @return array
     * 新增时获取默认值
     */
    private function get_add_subscribe_dfdata(){
        $tplId      = $this->request->getStrParam('tplId');
        $data       = array();
        $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $tpl        = $tpl_model->getRowTplId($tplId);
        if($tpl){
            $data['id']     = 0;
            $data['page']    = '';
            $data['tplid']  = $tplId;
            $data['title']  = $tpl['awt_title'];
            $reg = '/{{(.+?)}}/';
            preg_match_all($reg,$tpl['awt_content'],$matches);

            if(!empty($matches)){
                //@todo 键值
                $items   = $matches[count($matches)-1];
                $content       = explode("\n", $tpl['awt_example']);
                $title         = array(); //结构体头部
                $keyword       = array(); //结构体中间
                $remark        = array(); //结构体备注
                $i             = 0;
                foreach($content as $fal){
                    if($fal){
                        if($tplId == 'ISdGDaiGoKADvrEgWdML3cFHzkVFN0lWpzhVWtnSmrw'){ //订单发货提醒的微信模版中文冒号（“：”），微信整成功英文冒号，所有需要替换
                            $fal  = str_replace(':','：',$fal);
                        }
                        $temp = explode(':',$fal);
                        if(count($temp) > 1){ //中间
                            $keyword[] = array(
                                'titletxt'  => $temp[0],
                                'contxt'    => $temp[1],
                                'color'     => '#5976be',
                                'key'       => str_replace('.DATA','',$items[$i]),
                            );
                        }else{ //头部和尾部
                            if(empty($title)){
                                $title = array(
                                    'contxt'    => mb_substr($temp[0],0,10),
                                    'color'     => '#FF1F1F',
                                    'key'       => str_replace('.DATA','',$items[$i]),
                                );
                            }else{
                                $remark = array(
                                    'contxt'    => mb_substr($temp[0],0,10),
                                    'color'     => '#FF1F1F',
                                    'key'       => str_replace('.DATA','',$items[$i]),
                                );
                            }
                        }
                        $i ++ ;
                    }
                }
                //备注未绑定上
                if(empty($remark)){
                    $last = $items[count($items) -1];
                    $last = str_replace('.DATA','',$last);
                    if(in_array($last,array('remark','Remark'))){
                        $remark = array(
                            'contxt'    => '',
                            'color'     => '#FF1F1F',
                            'key'       => $last,
                        );
                    }
                }
                //标题前缀、后缀

                $fields  = explode("\n", $tpl['awt_content']);
                $first   = explode('{{'.$items[0].'}}',$fields[0]);
                $data['item']   = json_encode($keyword);
            }
        }
        return $data;
    }

    /**
     * 保存模版消息
     */
    public function saveTplMsgAction(){
        $field  = array('title','page','emphasis');
        $data   = $this->getStrByField($field,'awt_');
        $item   = $this->request->getArrParam('item');

        //$data['awt_item']   = json_encode($item);
        $data['awt_update_time'] = $_SERVER['REQUEST_TIME'];
        $data['awt_data'] = json_encode($item);
        $tplid  = $this->request->getStrParam('tplid');
        $id     = $this->request->getIntParam('id');

        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        if($id){
            $ret = $tpl_msg_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
        }else{
            $tpl_model      = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $exist   = $tpl_model->getRowTplId($tplid);

            $data['awt_type']     =  $exist['awt_type'] ? $exist['awt_type'] : 1;
            $data['awt_subscribe_type'] =  intval($exist['awt_subscribe_type']);
            $data['awt_tplid']    =  $tplid;
            $data['awt_s_id']     =  $this->curr_sid;
            $data['awt_create_time'] = $_SERVER['REQUEST_TIME'];
            $ret = $tpl_msg_model->insertValue($data);
        }
        App_Helper_OperateLog::saveOperateLog("模版消息【".$data['awt_title']."】信息保存成功");
        $this->showAjaxResult($ret,'保存');
    }

    /**
     * @param $first
     * @param $keyword
     * @param $remark
     * @return string
     * 整合模版消息数据
     */
    /*private function reset_data_content($first,$keyword,$remark){
        $content = array();
        if(isset($first['key'])){
            $content[$first['key']] = array(
                "value" => $first['contxt'],
                "color" => $first['color']
            );
        }
        foreach($keyword as $key=>$val){
            $content[$val['key']] = array(
                "value" => $val['contxt'],
                "color" => $val['color']
            );
        }
        if(isset($remark['key'])){
            $content[$remark['key']] = array(
                "value" => $remark['contxt'],
                "color" => $remark['color']
            );
        }
        return json_encode($content);
    }*/

    /**
     * 微信消息模版
     */
    public function tplAction(){
        $page   = $this->request->getIntParam('page');
        $index  = $page * $this->count;
        $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $total      = $tpl_model->getCountBySid(1);
        $list       = array();
        if($total > $index){
            $list = $tpl_model->getListBySid($index,$this->count,1);
            // $example = explode("\r\n", $tpl['awt_example']);
        }
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();
        foreach($list as $key=>$val){
            $list[$key]['awt_example'] = str_replace("\n", "<br/>",$val['awt_example']);
        }
        $this->output['list']       = $list;
        $this->output['subscribe']  = 0;
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '微信消息模版', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tplmsg/wx-tpl.tpl');
    }


    /**
     * 微信消息模版
     */
    public function subscribeTplAction(){
        $page   = $this->request->getIntParam('page');
        $index  = $page * $this->count;
        $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $total      = $tpl_model->getCountBySid(2);
        $list       = array();
        if($total > $index){
            $list = $tpl_model->getListBySid($index,$this->count,2);
            // $example = explode("\r\n", $tpl['awt_example']);
        }
        $page_libs = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['pageHtml']   = $page_libs->render();
        foreach($list as $key=>$val){
            $list[$key]['awt_example'] = str_replace("\n", "<br/>",$val['awt_example']);
        }
        $this->output['list']       = $list;
        $this->output['subscribe']  = 1;
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '订阅消息模版', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/tplmsg/wx-tpl.tpl');
    }


    /**
     *  从微信同步消息模版
     */
    public function refreshSubscribeTplAction(){
        $result = array(
            'ec' => 400,
            'em' => '微信尚未添加订阅消息模版'
        );
        $Wxxcx_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $data          = $Wxxcx_plugin->fetchAllPrivateSubscribeTemplate();
        if($data['errcode'] == 0){
            $list = $data['data'];
            $insert         = array();
            $tpl_model      = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            foreach($list as $val){
                $exist   = $tpl_model->checkTplId($val['priTmplId'],2);
                if($exist == 0){
                    $insert[] = "(NULL, {$this->curr_sid}, '{$val['priTmplId']}', '{$val['title']}', '{$val['content']}', '{$val['example']}', '0', '".time()."', '2', '{$val['type']}')";
                }
            }
            if(!empty($insert)){
                $ret = $tpl_model->insertBatchSubscribe($insert);
                $result = $this->showAjaxResult($ret,'同步',1);
            }else{
                $result['em'] =  '已更新，没有变动';
            }
        }else{
            $result = array(
                'ec' => 400,
                'em' => $data['errmsg']
            );
        }
        $this->displayJson($result);
    }


    /**
     *  从微信同步消息模版
     */
    public function refreshTplAction(){
        $result = array(
            'ec' => 400,
            'em' => '微信尚未添加消息模版'
        );
        $Wxxcx_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $list           = $Wxxcx_plugin->fetchAllPrivateTemplate();
        if(!empty($list) && count($list) > 0){
            $insert         = array();
            $tpl_model      = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            foreach($list as $val){
                $exist   = $tpl_model->checkTplId($val['template_id']);
                if($exist == 0){
                    $insert[] = "(NULL, {$this->curr_sid}, '{$val['template_id']}', '{$val['title']}', '{$val['content']}', '{$val['example']}', '0', '".time()."')";
                }
            }
            if(!empty($insert)){
                $ret = $tpl_model->insertBatch($insert);
                $result = $this->showAjaxResult($ret,'同步',1);
            }else{
                $result['em'] =  '已更新，没有变动';
            }
        }
        $this->displayJson($result);
    }

    /**
     * 异步获取模版消息＋分页
     */
    public function msgTplAction(){
        $page       = $this->request->getIntParam('page',1);
        $page       = $page >=1 ? $page : 1;
        $index      = ($page - 1)* $this->count;
        $msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $total      = $msg_model->getCountBySid();
        $list       = $msg_model->getListBySid($index,$this->count);
        $tot_page   = ceil($total/$this->count);

        $menu_helper= new App_Helper_Menu();
        $menu       = $menu_helper->ajaxPageLink($tot_page , $page);
        if($total > 1){
            $data = array(
                'ec'        => 200,
                'list'      => $list,
                'pageHtml'  => $menu
            );
        }else{
            $data = array(
                'ec'        => 400,
                'msg'       => '您还未添加消息模版'
            );
        }
        $this->displayJson($data);
    }

    /**
     * 删除模版
     */
    public function deleteTplAction(){
        $tplid      = $this->request->getStrParam('tplId');
        $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $tpl = $tpl_model->getRowTplId($tplid);
        $ret        = $tpl_model->deleteByTplId($tplid);
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $set = array(
            'awt_deleted' => 1
        );
        $where[] = array('name' => 'awt_tplid', 'oper' => '=', 'value' => $tplid);
        $tpl_msg_model->updateValue($set, $where);
        if($ret){
            $Wxxcx_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $Wxxcx_plugin->deletePrivateTemplate($tplid);

            App_Helper_OperateLog::saveOperateLog("消息模板【".$tpl['awt_title']."】删除成功");
        }
        $this->showAjaxResult($ret,'删除');
    }


    /**
     * 删除模版
     */
    public function deleteSubscribeTplAction(){
        $tplid      = $this->request->getStrParam('tplId');
        $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
        $tpl = $tpl_model->getRowTplId($tplid);
        $ret        = $tpl_model->deleteByTplId($tplid);
        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $set = array(
            'awt_deleted' => 1
        );
        $where[] = array('name' => 'awt_tplid', 'oper' => '=', 'value' => $tplid);
        $tpl_msg_model->updateValue($set, $where);
        if($ret){
            $Wxxcx_plugin  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $Wxxcx_plugin->deleteSubscribePrivateTemplate($tplid);

            App_Helper_OperateLog::saveOperateLog("消息模板【".$tpl['awt_title']."】删除成功");
        }

        $this->showAjaxResult($ret,'删除');
    }

    /******************按模版发送消息**************************/

    /**
     * 根据会员昵称获取会员列表
     */
    public function memberAction(){
        $data       = array(
            'ec'    => 400,
            'em'    => '未查到相关会员'
        );
        $nickname   = $this->request->getStrParam('nickname');

        $text       = json_encode($nickname);
        $text       = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
            return addslashes($str[0]);
        },$text);
        $nickname   = json_decode($text);
        if($nickname){
            $formids_model   = new App_Model_Member_MysqlMemberFormidsStorage($this->curr_sid);
            $where      = array();
            $where[]    = array('name'=>'m_nickname','oper'=>'like','value'=>"%{$nickname}%");
            $list       = $formids_model->getAbleMemberList($where,0,0);

            if(!empty($list)){
                $mem = array();
                foreach($list as $val){
                    $mem[] = array(
                        'id'       => $val['m_id'],
                        'nickname' => $val['m_nickname'],
                        'show'     => $val['m_show_id']
                    );
                }
                $data       = array(
                    'ec'    => 200,
                    'data'  => $mem,
                );
            }
        }
        $this->displayJson($data);
    }

    public function sendMsgAction(){
        $msg_id = $this->request->getIntParam('msgid');
        $msg_model = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $tpl = $msg_model->getRowUpdateByIdSid($msg_id,$this->curr_sid);

        if(!empty($tpl)){
            $page   = $this->request->getIntParam('page');
            $index  = $page * $this->count;
            $send_model  = new App_Model_Applet_MysqlWeixinTplMsgSendStorage($this->curr_sid);
            $total      = $send_model->getCountByMsgid($msg_id);
            //列表数据
            $list       = array();
            if($total > $index){
                $list = $send_model->getListByMsgid($msg_id,$index,$this->count);
            }
            $page_libs      = new Libs_Pagination_Paginator($total,$this->count);
            $formids_model   = new App_Model_Member_MysqlMemberFormidsStorage($this->curr_sid);
            $this->output['pageHtml']   = $page_libs->render();
            $this->output['member']     = $formids_model->getAbleMemberList([],0,0);
            $this->output['row']        = $tpl;
            $this->output['list']       = $list;
            $this->output['status']     = plum_parse_config('send','status');
            $this->output['color']      = plum_parse_config('color','status');
            $this->buildBreadcrumbs(array(
                array('title' => '微信消息模版', 'link' => '/wxapp/tplmsg/tpl'),
                array('title' => '自定义消息', 'link' => '/wxapp/tplmsg/tplmsgList?tplid='.$tpl['awt_tplid']),
                array('title' => '发送模版消息', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/tplmsg/tplmsg-send.tpl');
        }else{
            plum_url_location('未知消息模版','/wxapp/tplmsg/tpl');
        }
    }
    public function sendToPeopleAction(){
        $result = array(
            'ec' => 400,
            'em' => '模版错误'
        );
        //@todo 校验模版信息
        $msg_id     = $this->request->getIntParam('msgId');
        $msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $tpl        = $msg_model->getRowUpdateByIdSid($msg_id,$this->curr_sid);
        if(!empty($tpl)){
            //@todo 获取会员信息
            $type   = $this->request->getIntParam('type');
            $midArr = array();
            if($type == 0){
                $temp   = $this->request->getStrParam('member');
                $midArr = explode(',',$temp);
            }
            $formids_model = new App_Model_Member_MysqlMemberFormidsStorage($this->curr_sid);
            $member       = $formids_model->getMemberKeyMid($this->curr_sid,$midArr,0,0,array('m_id','m_openid','m_nickname'));
            //@todo 发送消息
            if(!empty($member)){
                $data = array();
                $weixin_client  = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
                foreach($member as $val){
                    $where[] = array('name' => 'af_s_id', 'oper' => '=', 'value' => $this->curr_sid);
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
                            break;
                        }
                    }
                    $tplData = json_decode($tpl['awt_data'], true);
                    //处理数据data
                    $sendData   = array();
                    foreach ($tplData as $value) {
                        $sendData[$value['key']]  = array(
                            'value' => trim($value['contxt'], "{}"),
                            'color' => $value['color'],
                        );
                    }
                    $emphasis   = intval($tpl['awt_emphasis']);
                    $send_ret       = $weixin_client->sendTemplateMessage($val['m_openid'],$tpl['awt_tplid'],$formid,$sendData,'', $emphasis);
                    if($send_ret && $send_ret['errcode'] == 0){
                        $nickname = str_replace("'",'',$val['m_nickname']);
                        $nickname = str_replace('"','',$nickname);
                        $data[]     = "(NULL, {$this->curr_sid}, {$msg_id}, '{$val['m_openid']}', '{$tpl['awt_title']}', '{$val['m_id']}', '{$nickname}', '1', '{$_SERVER['REQUEST_TIME']}')";
                    }
                }

                if(!empty($data)){
                    $send_model  = new App_Model_Applet_MysqlWeixinTplMsgSendStorage($this->curr_sid);
                    $ret         = $send_model->insertBatch($data);
                    $result      = $this->showAjaxResult($ret,'发送',1);
                }else{
                    $result['em'] = '消息模版信息错误，消息发送失败';
                }
            }else{
                $result['em'] = '会员信息不存在';
            }
        }
        $this->displayJson($result);
    }

    public function testAction(){
        $applet_helper   = new App_Helper_WxappApplet(4546);
        $applet_helper->noticeShopExpire(6923, 1);
    }


    //创建默认模板
    public function createDefaultTplmsgAction(){
        $type  = $this->request->getStrParam('type');
        $field = $this->request->getStrParam('field');
        $defaultcfg = plum_parse_config('defaultmsg','tmplmsg');

        $Wxxcx_plugin = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $result       = $Wxxcx_plugin->addPrivateTemplate($defaultcfg[$type]['tplid'], $defaultcfg[$type]['keywords']);

        $list           = $Wxxcx_plugin->fetchAllPrivateTemplate();

        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);

        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);

        $ret = false;
        if(!empty($list) && count($list) > 0){
            $insert         = array();
            $tpl_model      = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            foreach($list as $val){
                $exist   = $tpl_model->checkTplId($val['template_id']);
                if($exist == 0){
                    $insert[] = "(NULL, {$this->curr_sid}, '{$val['template_id']}', '{$val['title']}', '{$val['content']}', '{$val['example']}', '0', '".time()."')";
                    if($val['template_id'] == $result['template_id']){
                        $tmlmsgdata = $this->_display_default_content($val['content'], $defaultcfg[$type]['values']);
                        $data = array();
                        $data['awt_s_id']  = $this->curr_sid;
                        $data['awt_tplid'] = $val['template_id'];
                        $data['awt_title'] = $val['title'];
                        $data['awt_data']  = $tmlmsgdata;
                        $data['awt_create_time']  = time();
                        $data['awt_update_time']  = time();
                        $msgid = $tpl_msg_model->insertValue($data);

                        $setupdata = array();
                        $setupdata[$field] = $msgid;
                        $row = $setup_model->findOneBySid();
                        if($row){
                            $ret = $setup_model->updateById($setupdata, $row['aws_id']);
                        }else{
                            $setupdata['aws_s_id'] = $this->curr_sid;
                            $setupdata['aws_create_time'] = time();
                            $ret = $setup_model->insertValue($setupdata);
                        }
                    }
                }
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("默认模板创建成功");
            }

            if(!empty($insert)){
                $tpl_model->insertBatch($insert);
                $this->showAjaxResult($ret);
            }
        }
        $this->showAjaxResult($ret);
    }

    private function _display_default_content($content, $defaultValues){
        $content = explode("\n", $content);
        $keyword = array();

        $reg = '/(.+?){{(.+?)}}/';
        foreach($content as $key => $fal){
            if($fal){
                preg_match($reg, $fal, $matchContent);
                $keyword[] = array(
                    'titletxt'  => $matchContent[1],
                    'contxt'    => $defaultValues[$key],
                    'color'     => '#5976be',
                    'key'       => str_replace('.DATA','', $matchContent[2]),
                );
            }
        }
        return json_encode($keyword);
    }

    /**
     *  保存消息模版
     */
    public function saveToutiaoTplAction(){
        $title = $this->request->getStrParam('message_title');
        $template_id = $this->request->getStrParam('message_id');
        if($title && $template_id){
            $tpl_model      = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $insert = array(
                'awt_s_id'  => $this->curr_sid,
                'awt_tplid' => $template_id,
                'awt_title' => $title,
                'awt_create_time' => time()

            );
            $ret = $tpl_model->insertValue($insert);
            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请填写模板名称和模板内容');
        }

    }

    //创建默认订阅消息模板
    public function createDefaultSubscribeAction(){
        $type  = $this->request->getStrParam('type');
        $field = $this->request->getStrParam('field');
        $defaultcfg = plum_parse_config('defaultMsg','subscribeMsg')[$this->wxapp_cfg['ac_type']];

        $Wxxcx_plugin = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $result       = $Wxxcx_plugin->subscribeAddTemplate($defaultcfg[$type]['tid'], $defaultcfg[$type]['keywords'],$defaultcfg[$type]['brief']);

        $errormsg = [
            '200014' => '当前小程序服务类目不支持设置默认模板',
            '200011' => '此账号已被封禁，无法操作',
            '200013' => '此模版已被封禁，无法选用',
            '200012' => '个人模版数已达上限，上限25个'
        ];

        if($result['errcode'] > 0 && isset($errormsg[$result['errcode']])){
            $this->displayJsonError($errormsg[$result['errcode']]);
        }

        Libs_Log_Logger::outputLog($result,'ding.log');
        $list = $Wxxcx_plugin->fetchAllPrivateSubscribeTemplate();
        $list = $list['data'];
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);

        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);

        $ret = false;
        if(!empty($list) && count($list) > 0){
            $insert         = array();
            $tpl_model      = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            foreach($list as $val){
                $exist   = $tpl_model->checkTplId($val['priTmplId'],2);
                if($exist == 0){
                    $insert[] = "(NULL, {$this->curr_sid}, '{$val['priTmplId']}', '{$val['title']}', '{$val['content']}', '{$val['example']}', '0', '".time()."','2','{$val['type']}')";
                    if($val['priTmplId'] == $result['priTmplId']){
                        $tmlmsgdata = $this->_display_default_content($val['content'], $defaultcfg[$type]['values']);
                        $data = array();
                        $data['awt_s_id']  = $this->curr_sid;
                        $data['awt_tplid'] = $val['priTmplId'];
                        $data['awt_title'] = $val['title'];
                        $data['awt_type'] = 2;
                        $data['awt_subscribe_type'] = $val['type'];
                        $data['awt_data']  = $tmlmsgdata;
                        $data['awt_create_time']  = time();
                        $data['awt_update_time']  = time();
                        $msgid = $tpl_msg_model->insertValue($data);

                        $setupdata = array();
                        $setupdata[$field] = $msgid;
                        $row = $setup_model->findOneBySid();
                        if($row){
                            $ret = $setup_model->updateById($setupdata, $row['aws_id']);
                        }else{
                            $setupdata['aws_s_id'] = $this->curr_sid;
                            $setupdata['aws_create_time'] = time();
                            $ret = $setup_model->insertValue($setupdata);
                        }
                    }
                }
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("默认模板创建成功");
            }

            if(!empty($insert)){
                $tpl_model->insertBatchSubscribe($insert);
                $this->showAjaxResult($ret);
            }
        }
        $this->showAjaxResult($ret);
    }

}
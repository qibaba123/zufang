<?php

class App_Controller_Wxapp_TplpreviewController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();
    }



    
    public function informationPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);

        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_push_open"]) && $setup["aws_push_open"]) {

            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_push_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl    = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            $information = $information_storage->getRowById($id);
            $infor['title']      = $information['ai_title'];
            $infor['time']       = date('Y-m-d H:i', $information['ai_create_time']);
            $infor['desc']       = $information['ai_brief'];
            list($tpl,)          = $trade_helper->replaceInforTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tpl = str_replace("\t", "\\t",$tpl);
            $tplData = json_decode($tpl, true);

            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }

            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function lotteryPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_lottery_open"]) && $setup["aws_lottery_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_lottery_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $list_model     = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
            $lottery        = $list_model->getRowById($id);
            $infor['title'] = $lottery['amll_name'];
            $lottery_model = new App_Model_Meeting_MysqlMeetingLotteryStorage($this->curr_sid);
            $goodsList     = $lottery_model->getListBySid($id, 1);
            $infor['goods'] = '';
            foreach ($goodsList as $val){
                $infor['goods'] .= $val['aml_name'].'、';
            }

            list($tpl,)          = $trade_helper->replaceLotteryTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function appointmentPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_appointment_open"]) && $setup["aws_appointment_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_appointment_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $goods_model    = new App_Model_Goods_MysqlGoodsStorage();
            $goods          = $goods_model->getRowById($id);
            $infor['title'] = $goods['g_name'];
            $infor['price'] = $goods['g_price'];
            $infor['long']  = $goods['g_appointment_length'];
            $infor['date']  = $goods['g_appointment_date'];
            $infor['time']  = $goods['g_appointment_time'];
            $infor['brief'] = $goods['g_brief'];
            list($tpl,)     = $trade_helper->replaceAppointmentTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function goodsPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_goods_open"]) && $setup["aws_goods_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_goods_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $goods          = $goods_model->getRowById($id);
            $infor['title'] = $goods['g_name'];
            $infor['price'] = $goods['g_price'];
            $infor['oriPrice']  = $goods['g_ori_price'];
            $infor['limit'] = $goods['g_limit'];
            $infor['sold']  = $goods['g_sold'];
            $infor['stock'] = $goods['g_stock'];
            $goods['g_brief'] = '';
            $infor['brief'] = $goods['g_brief'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            list($tpl,)     = $trade_helper->replaceGoodsTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tpl = str_replace("\t", "",$tpl);
            $tpl = str_replace("•", "",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function groupPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_group_open"]) && $setup["aws_group_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_group_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $group_model    = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
            $group          = $group_model->fetchGroupGoods($id);
            $infor['title'] = $group['g_name'];
            $infor['rule']  = $group['gb_act_rule'];
            $infor['tzPrice'] = $group['gb_tz_price'];
            $infor['price'] = $group['gb_price'];
            $infor['total'] = $group['gb_total'];
            $infor['startTime'] = date('Y-m-d H:i:s', $group['gb_start_time']);
            $infor['endTime']   = date('Y-m-d H:i:s', $group['gb_end_time']);
            list($tpl,)     = $trade_helper->replaceGroupActTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function limitPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_limit_open"]) && $setup["aws_limit_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_limit_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $act_model      = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
            $limit          = $act_model->getRowById($id);
            $infor['title'] = $limit['la_name'];
            $infor['startTime'] = date('Y-m-d H:i:s', $limit['la_start_time']);
            $infor['endTime'] = date('Y-m-d H:i:s', $limit['la_end_time']);
            $infor['label'] = $limit['la_label'];
            list($tpl,)     = $trade_helper->replaceLimitActTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function bargainPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_bargain_open"]) && $setup["aws_bargain_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_bargain_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
            $bargain        = $bargain_model->getActivityById($id);
            $infor['title'] = $bargain['g_name'];
            $infor['buyPrice']  = $bargain['ba_buy_price_limit'];
            $infor['kjPrice']   = $bargain['ba_kj_price_limit'];
            $infor['startTime'] = date('Y-m-d H:i:s', $bargain['ba_start_time']);
            $infor['endTime']   = date('Y-m-d H:i:s', $bargain['ba_end_time']);
            list($tpl,)     = $trade_helper->replaceBargainActTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function postPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_post_open"]) && $setup["aws_post_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_post_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $applet     = $applet_model->findShopCfg();
            if($applet['ac_type'] == 6){
                $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
                $post        = $post_storage->getPostRowMemberDistance($id);
            }else{
                $post_storage = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
                $post        = $post_storage->getPostRowMember($id);
            }

            $infor['nickname']  = $post['m_nickname'];
            $infor['content']   = mb_substr($post['acp_content'],0,150, 'utf-8');
            $infor['time']      = date('Y-m-d H:i:s', $post['acp_create_time']);

            list($tpl,)     = $trade_helper->replacePostTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                
                $tplData[$key]['contxt'] = trim($val['contxt'], "{}");
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function shopPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_shop_open"]) && $setup["aws_shop_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_shop_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $applet     = $applet_model->findShopCfg();
            if($applet['ac_type'] == 8){
                $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $shop = $shop_model->getRowById($id);
                $infor['name']      = $shop['es_name'];
                $infor['address']   = $shop['es_addr'];
                $infor['phone']     = $shop['es_phone'];
            }else{
                $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
                $shop = $shop_model->getRowById($id);
                $infor['name']      = $shop['acs_name'];
                $infor['address']   = $shop['acs_address'];
                $infor['phone']     = $shop['acs_mobile'];
            }
            list($tpl,)     = $trade_helper->replaceShopTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function couponPreviewAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_coupon_open"]) && $setup["aws_coupon_open"]) {
            $tplmsg_model   = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
            $tplmsg         = $tplmsg_model->findOneById($setup["aws_coupon_mid"]);
            $tpl_model  = new App_Model_Applet_MysqlWeixinTplStorage($this->curr_sid);
            $weixintpl        = $tpl_model->getRowTplId($tplmsg['awt_tplid']);
            $tpl            = $tplmsg['awt_data'];
            $trade_helper   = new App_Helper_Trade($this->curr_sid);
            $coupon_model   = new App_Model_Coupon_MysqlCouponStorage();
            $coupon = $coupon_model->getRowById($id);
            $infor['title']     = $coupon['cl_name'];
            $infor['value']     = $coupon['cl_face_val'];
            $infor['limit']     = $coupon['cl_use_limit'];
            $infor['count']     = $coupon['cl_count'];
            $infor['receive']   = $coupon['cl_had_receive'];
            $infor['rlimit']    = $coupon['cl_receive_limit'];
            $infor['startTime'] = date('Y-m-d H:i:s', $coupon['cl_start_time']);
            $infor['endTime']   = date('Y-m-d H:i:s', $coupon['cl_end_time']);
            list($tpl,)     = $trade_helper->replaceCouponTpl($infor, $tpl);//替换推送模板变量
            $tpl = str_replace("\n", "\\n",$tpl);
            $tplData = json_decode($tpl, true);
            foreach ($tplData as $key => $val){
                $tplData[$key]['contxt'] = str_replace('{', '',$tplData[$key]['contxt']);
                $tplData[$key]['contxt'] = str_replace('}', '',$tplData[$key]['contxt']);
                if($key + 1 == $tplmsg['awt_emphasis']){
                    $tplData[$key]['emphasis'] = 1;
                }
            }
            $data = array(
                'tplData' => $tplData,
                'title'   => $weixintpl['awt_title'],
                'date'    => date('m月d日 H:i', time())
            );
            $this->displayJsonSuccess($data);
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function pushHistoryAction(){
        $id   = $this->request->getIntParam('id');
        $type = $this->request->getStrParam('type');
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $history_model = new App_Model_Tplmsg_MysqlPushHistoryStorage();
        $where = array();
        $where[] = array('name' => 'aph_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        switch ($type) {
            case 'goods':
                $where[] = array('name' => 'aph_g_id', 'oper' => '=', 'value' => $id);
                break;
            case 'information':
                $where[] = array('name' => 'aph_information_id', 'oper' => '=', 'value' => $id);
                break;
            case 'post':
                $where[] = array('name' => 'aph_post_id', 'oper' => '=', 'value' => $id);
                break;
            case 'cpost':
                $where[] = array('name' => 'aph_cpost_id', 'oper' => '=', 'value' => $id);
                break;
            case 'group':
                $where[] = array('name' => 'aph_group_id', 'oper' => '=', 'value' => $id);
                break;
            case 'limit':
                $where[] = array('name' => 'aph_limit_id', 'oper' => '=', 'value' => $id);
                break;
            case 'bargain':
                $where[] = array('name' => 'aph_bargain_id', 'oper' => '=', 'value' => $id);
                break;
            case 'appointment':
                $where[] = array('name' => 'aph_appointment_id', 'oper' => '=', 'value' => $id);
                break;
            case 'shop':
                $where[] = array('name' => 'aph_shop_id', 'oper' => '=', 'value' => $id);
                break;
            case 'cshop':
                $where[] = array('name' => 'aph_cshop_id', 'oper' => '=', 'value' => $id);
                break;
            case 'coupon':
                $where[] = array('name' => 'aph_coupon_id', 'oper' => '=', 'value' => $id);
                break;
            case 'lottery':
                $where[] = array('name' => 'aph_lottery_id', 'oper' => '=', 'value' => $id);
                break;
            case 'service':
                $where[] = array('name' => 'aph_service_id', 'oper' => '=', 'value' => $id);
                break;
            case 'position':
                $where[] = array('name' => 'aph_position_id', 'oper' => '=', 'value' => $id);
                break;
            case 'house':
                $where[] = array('name' => 'aph_house_id', 'oper' => '=', 'value' => $id);
                break;
        }
        $total = $history_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $list = $history_model->getList($where, $index, $this->count, array('aph_create_time' => 'desc'));
        }
        $this->output['list'] = $list;
        $this->displaySmarty("wxapp/tplmsg/push-history.tpl");
    }

    
    public function receiveListAction(){
        $id    = $this->request->getIntParam('id');
        $page  = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $send_model  = new App_Model_Applet_MysqlWeixinTplMsgSendStorage($this->curr_sid);
        $where = array();
        $where[] = array('name' => 'awt_history_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'awt_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $total = $send_model->getCount($where);
        $pageCfg = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $this->output['paginator'] = $pageCfg->render();
        $list   = array();
        if($index <= $total){
            $list = $send_model->getList($where, $index, $this->count, array('awt_send_time' => 'desc'));
        }
        $this->output['list'] = $list;
        $this->displaySmarty("wxapp/tplmsg/push-member.tpl");
    }

    private function _filter_illegality_chars($str){
        $escapers = array("\\", "/", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\n", "\\r", "\\t", "\\f", "\\b");
        $result = str_replace($escapers, $replacements, $str);
        return $result;
    }

}
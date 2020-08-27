<?php

class App_Controller_Wxapp_TplpushController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct();
        if($this->curr_sid != 5655 && $this->curr_sid != 4546 && $this->curr_sid != 8298){
            $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
            $ttl    = $applet_redis->getPushLast($this->curr_sid);
            if ($ttl > 0){
                if($ttl>60*60){
                    $hour = floor($ttl/3600);
                    $min = floor(($ttl-3600 * $hour)/60);
                    $second = floor((($ttl-3600 * $hour) - 60 * $min) % 60);
                    $this->displayJsonError("推送频率过高,请于{$hour}时{$min}分{$second}秒后再试");
                }elseif($ttl>60){
                    $min = floor($ttl/60);
                    $second = fmod($ttl,60);
                    $this->displayJsonError("推送频率过高,请于{$min}分{$second}秒后再试");
                }else{
                    $this->displayJsonError("推送频率过高,请于{$ttl}秒后再试");
                }
            }
        }
    }

    private function _record_push(){
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->curr_sid);
        $time = 60*60*2;
        $applet_redis->setPushLast($this->curr_sid, $time);
    }

    
    public function informationPushAction(){
        $aid = $this->request->getIntParam('aid');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }

        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_push_open"]) && $setup["aws_push_open"]) {
            $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
            $data['ai_push'] = 1;
            $ret = $information_storage->updateById($data,$aid);
            $this->_record_push();

            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;
            plum_open_backend('templmsg', 'informationTempl', array('sid' => $this->curr_sid,'aid' => $aid, 'mid' => $setup["aws_push_mid"],'appletType'=>$appletType));
            $row = $information_storage->getRowById($aid);
            App_Helper_OperateLog::saveOperateLog("资讯【{$row['ai_title']}】推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function lotteryPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_lottery_open"]) && $setup["aws_lottery_open"]) {
            $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->curr_sid);
            $data['amll_push'] = 1;
            $ret = $list_model->updateById($data,$id);
            $this->_record_push();

            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'lotteryTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_lottery_mid"],'appletType' => $appletType));
            $row = $list_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("抽奖活动【{$row['amll_name']}】推送成功");

            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function appointmentPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }

        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_appointment_open"]) && $setup["aws_appointment_open"]) {
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $data['g_push'] = 1;
            $ret = $goods_model->updateById($data, $id);
            $this->_record_push();

            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'appointmentTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_appointment_mid"],'appletType' => $appletType));

            $row = $goods_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("预约项目【{$row['g_name']}】推送成功");

            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function upgradePushAction(){
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_upgrade_open"]) && $setup["aws_upgrade_open"]) {
            $this->_record_push();
            plum_open_backend('templmsg', 'upgradeTempl', array('sid' => $this->curr_sid, 'mid' => $setup["aws_upgrade_mid"]));
            App_Helper_OperateLog::saveOperateLog("版本更新推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }


    
    public function goodsPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_goods_open"]) && $setup["aws_goods_open"]) {
            $goods_model = new App_Model_Goods_MysqlGoodsStorage();
            $data['g_push'] = 1;
            $ret = $goods_model->updateById($data, $id);
            $this->_record_push();

            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'goodsTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_goods_mid"],'appletType' => $appletType));
            $row = $goods_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("商品【{$row['g_name']}】推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function groupPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_group_open"]) && $setup["aws_group_open"]) {
            $group_model  = new App_Model_Group_MysqlBuyStorage($this->curr_sid);
            $data['gb_push'] = 1;
            $ret = $group_model->updateById($data, $id);
            $this->_record_push();
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;
            plum_open_backend('templmsg', 'groupTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_group_mid"],'appletType' => $appletType));

            App_Helper_OperateLog::saveOperateLog("拼团活动推送成功");

            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function limitPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_limit_open"]) && $setup["aws_limit_open"]) {
            $act_model  = new App_Model_Limit_MysqlLimitActStorage($this->curr_sid);
            $data['la_push'] = 1;
            $ret = $act_model->updateById($data, $id);
            $this->_record_push();
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;
            plum_open_backend('templmsg', 'limitTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_limit_mid"],'appletType' => $appletType));
            $row = $act_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("秒杀活动【{$row['la_name']}】推送成功");

            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function bargainPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_bargain_open"]) && $setup["aws_bargain_open"]) {
            $bargain_model  = new App_Model_Bargain_MysqlActivityStorage($this->curr_sid);
            $data['ba_push'] = 1;
            $ret = $bargain_model->updateById($data, $id);
            $this->_record_push();
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;
            plum_open_backend('templmsg', 'bargainTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_bargain_mid"],'appletType' => $appletType));
            App_Helper_OperateLog::saveOperateLog("砍价活动推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function postPushAction(){
        $id = $this->request->getIntParam('id');
        $type = $this->request->getStrParam('type');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }

        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_post_open"]) && $setup["aws_post_open"]) {
            if($type == 'community'){
                $post_storage = new App_Model_Community_MysqlCommunityPostStorage($this->curr_sid);
            }else{
                $post_storage = new App_Model_City_MysqlCityPostStorage($this->curr_sid);
            }
            $data['acp_push'] = 1;
            $ret = $post_storage->updateById($data, $id);
            $this->_record_push();
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;
            plum_open_backend('templmsg', 'postTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_post_mid"],'appletType'=>$appletType));
            App_Helper_OperateLog::saveOperateLog("帖子推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function shopPushAction(){
        $id = $this->request->getIntParam('id');
        $type = $this->request->getStrParam('type');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_shop_open"]) && $setup["aws_shop_open"]) {
            if($type == 'community'){
                $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
                $data['es_push'] = 1;
            }else{
                $shop_model = new App_Model_City_MysqlCityShopStorage($this->curr_sid);
                $data['acs_push'] = 1;
            }
            $ret = $shop_model->updateById($data, $id);
            $this->_record_push();

            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'shopTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_shop_mid"],'appletType'=>$appletType));

            if($type == 'community'){
                $row = $shop_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("店铺【{$row['es_name']}】推送成功");
            }else{
                $row = $shop_model->getRowById($id);
                App_Helper_OperateLog::saveOperateLog("店铺【{$row['acs_name']}】推送成功");
            }

            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function couponPushAction(){
        $id = $this->request->getIntParam('id');
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_coupon_open"]) && $setup["aws_coupon_open"]) {
            $coupon_model = new App_Model_Coupon_MysqlCouponStorage();
            $data['cl_push'] = 1;
            $ret = $coupon_model->updateById($data, $id);
            $this->_record_push();
            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;
            plum_open_backend('templmsg', 'couponTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_coupon_mid"],'appletType' => $appletType));

            $row = $coupon_model->getRowById($id);
            App_Helper_OperateLog::saveOperateLog("优惠券【{$row['cl_name']}】推送成功");

            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function answerPushAction(){
        if($this->menuType == 'weixin'){
            $setup_model    = new App_Model_Applet_MysqlWechatTplMsgSetupStorage($this->curr_sid);
        }else{
            $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        }

        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_answer_open"]) && $setup["aws_answer_open"]) {
            $this->_record_push();

            $appletType = plum_parse_config('menu_type_str_num')[$this->menuType];
            $appletType = $appletType ? $appletType : 0;

            plum_open_backend('templmsg', 'answerTempl', array('sid' => $this->curr_sid, 'mid' => $setup["aws_answer_mid"],'appletType' => $appletType));
            App_Helper_OperateLog::saveOperateLog("答题活动推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function dynamicPushAction(){
        $id = $this->request->getIntParam('id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_dynamic_open"]) && $setup["aws_dynamic_open"]) {
            $dynamic_storage = new App_Model_Smart_MysqlStoreDynamicStorage($this->curr_sid);
            $data['asd_push'] = 1;
            $ret = $dynamic_storage->updateById($data, $id);
            $this->_record_push();
            plum_open_backend('templmsg', 'dynamicTempl', array('sid' => $this->curr_sid,'id' => $id, 'mid' => $setup["aws_dynamic_mid"]));
            App_Helper_OperateLog::saveOperateLog("动态推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }

    
    public function resourcePushAction(){
        $id = $this->request->getIntParam('ahr_id');
        $setup_model    = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $setup  = $setup_model->findOneBySid();
        if (isset($setup["aws_fpush_open"]) && $setup["aws_fpush_open"]) {
            plum_open_backend('templmsg', 'resourceTempl', array('sid' => $this->curr_sid,'ahrid' => $id, 'mid' => $setup["aws_fpush_mid"]));
            App_Helper_OperateLog::saveOperateLog("房源推送成功");
            $this->showAjaxResult(1, '推送');
        }else{
            $this->displayJsonError('请先配置模板消息');
        }
    }
}
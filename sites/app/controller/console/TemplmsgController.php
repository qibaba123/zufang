<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/6
 * Time: 下午9:13
 */

class App_Controller_Console_TemplmsgController extends Libs_Mvc_Controller_ConsoleController{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 餐饮排队叫号推送(取号成功)
     */
    public function mealStartQueueTemplAction(){
        $id     = plum_get_int_param('id'); //排号的id
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendMealStartQueueTmplmsg($id);
    }

    /**
     * 餐饮排队叫号推送(商家叫号)
     */
    public function mealCallQueueTemplAction(){
        $id     = plum_get_int_param('id');  //排号的id
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendMealCallQueueTmplmsg($id);
    }

    /**
     * 购买会员卡通知推送
     */
    public function memberCardTemplAction(){
        $id     = plum_get_param('id');  //订单tid
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendMemberCardTmplmsg($id,$appletType);
    }

    /**
     * 职位推送
     */
    public function positionTemplAction(){
        $mid    = plum_get_int_param('mid');
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->positionPushTemplmsg($id, $mid);
    }

    /**
     * 充值推送
     */
    public function rechargeTemplAction(){
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendRechargeTmplmsg($tid);
    }

    /**
     * 退款推送
     */
    public function refundTemplAction(){
        $sid    = plum_get_int_param('sid');
        $tid    = plum_get_param('tid');
        $toid   = plum_get_param('toid',0);
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendRefundTmplmsg($tid,$toid,$appletType);
    }

    /**
     * 资讯推送
     */
    public function informationTemplAction(){
        $aid = plum_get_int_param('aid');
        $mid = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendInformationTmplmsg($aid, $mid, $appletType);
    }

    /**
     * 资讯推送
     */
    public function serviceTemplAction(){
        $ssid = plum_get_int_param('ssid');
        $mid = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendServiceTmplmsg($ssid, $mid);
    }

    /**
     * 抽奖活动推送
     */
    public function lotteryTemplAction(){
        $id = plum_get_int_param('id');
        $mid = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendLotteryTmplmsg($id, $mid , $appletType);
    }

    /**
     * 预约项目推送
     */
    public function appointmentTemplAction(){
        $id = plum_get_int_param('id');
        $mid = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendAppointmentTmplmsg($id, $mid, $appletType);
    }

    /**
     * 预约项目推送
     */
    public function upgradeTemplAction(){
        $mid = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendUpgradeTmplmsg($mid);
    }

    /**
     * 商品推送
     */
    public function goodsTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendGoodsTmplmsg($id, $mid, $appletType);
    }
    /**
     * 商品到货通知推送
     */
    public function goodsGetTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $leader = plum_get_int_param('leader');
        $startTime = plum_get_int_param('startTime');
        $endTime = plum_get_int_param('endTime');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendGoodsGetTmplmsg($id, $mid, $leader, $startTime, $endTime);
       
    }


    /**
     * 拼团活动推送
     */
    public function groupTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendGroupTmplmsg($id, $mid,$appletType);
    }

    /**
     * 拼团活动推送
     */
    public function limitTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendLimitTmplmsg($id, $mid,$appletType);
    }

    /**
     * 砍价活动推送
     */
    public function bargainTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendBargainTmplmsg($id, $mid,$appletType);
    }

    /**
     * 帖子推送
     */
    public function postTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendPostTmplmsg($id, $mid, $appletType);
    }

    /**
     * 商家推送
     */
    public function shopTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendShopTmplmsg($id, $mid, $appletType);
    }

    /**
     * 优惠券推送
     */
    public function couponTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendCouponTmplmsg($id, $mid,$appletType);
    }

    /**
     * 答题推送
     */
    public function answerTemplAction(){
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendAnswerTmplmsg($mid,$appletType);
    }

    /**
     * 动态推送
     */
    public function dynamicTemplAction(){
        $id     = plum_get_int_param('id');
        $mid    = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendDynamicTmplmsg($id, $mid);
    }

    /**
     * 帖子赞赏推送
     */
    public function postRewardTemplAction(){
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendPostRewardTmplmsg($id,$appletType);
    }

    /**
     * 砍价完成推送
     */
    public function bargainCompleteTemplAction(){
        $mid    = plum_get_int_param('mid');
        $aid    = plum_get_int_param('aid');
        $sid    = plum_get_int_param('sid');
        $type   = plum_get_param('type');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->bargainCompleteTempl($aid, $mid, $type);
    }

    /**
     * 砍价帮砍推送
     */
    public function bargainHelperTemplAction(){
        $mid    = plum_get_int_param('mid');
        $aid    = plum_get_int_param('aid');
        $helperid = plum_get_int_param('helperid');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->bargainHelperTempl($helperid, $aid, $mid);
    }


    /**
     * 创建工单推送
     */
    public function workorderCreateTemplAction(){
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $type   = plum_get_param('type');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->workorderCreateTempl($id, $type);
    }

    /**
     * 工单评论推送
     */
    public function workorderCommentTemplAction(){
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->workorderCommentTempl($id);
    }

    /**
     * 投递状态变化推送
     */
    public function sendStatusChangeTemplAction(){
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $from   = plum_get_param('from');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendStatusChangeTempl($id, $from);
    }

    /**
     * 推荐成功推送
     */
    public function recommendSuccessTemplAction(){
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->recommendSuccessTempl($id);
    }

    /**
     * 简历被浏览通知
     */
    public function resumeShowTemplAction(){
        $sid    = plum_get_int_param('sid');
        $rid    = plum_get_int_param('rid');
        $esId   = plum_get_int_param('esId');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->resumeShowTemplmsg($rid, $esId);
    }

    /**
     * 房源推送
     */
    public function resourceTemplAction(){
        $id = plum_get_int_param('ahrid');
        $mid = plum_get_int_param('mid');
        $sid    = plum_get_int_param('sid');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sendrResourceTmplmsg($id, $mid);
    }

    /**
     * 分销佣金消息推送
     */
    public function deductTemplAction(){
        $odId   = plum_get_int_param('odId');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->deductTempl($odId,$appletType);
    }

    /**
     * 私信消息通知
     */
    public function chatNoticeAction(){
        $id     = plum_get_int_param('id');
        $sid    = plum_get_int_param('sid');
        $appletType = plum_get_int_param('appletType');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->chatNoticeTmplmsg($id,$appletType);
    }

    /**
     * 社区团购相关推送
     */
    public function sendSequenceTemplAction(){
        $tid     = plum_get_param('tid');
        $sid    = plum_get_int_param('sid');
        $type   = plum_get_param('type');

        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->sequenceTempl($tid,$type);
    }

    /**
     * 社区团购相关推送
     */
    public function sendLegworkTemplAction(){
        $tid     = plum_get_param('tid');
        $sid    = plum_get_int_param('sid');
        $type   = plum_get_param('type');
        $id     = plum_get_int_param('id');

        $wxapp  = new App_Helper_TemplMsg($sid);
        if($type == 'share_success'){
            $wxapp->legworkShareTmplmsg($id);
        }else{
            $wxapp->legworkTradeTempl($tid,$type);
        }

    }

    /*
     * 培训订单支付推送
     */
    public function trainTradeTemplAction(){
        $tid     = plum_get_param('tid');
        $sid    = plum_get_int_param('sid');
        $type   = plum_get_param('type');
        $wxapp  = new App_Helper_TemplMsg($sid);
        $wxapp->trainTradeTempl($tid,$type);
    }

    /**
     * 抽奖团中奖结果通知
     */
    public function lotteryGroupTmplmsgAction(){
        $sid     = plum_get_int_param('sid');
        $sendIds = rawurldecode(trim($_REQUEST['sendIds']));
        $gbid    = plum_get_int_param('gbid');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->lotteryGroupTmpl($gbid, $sendIds);
    }

    /**
     * 抽奖团中奖结果通知
     */
    public function lotteryRefundTemplAction(){
        $sid     = plum_get_int_param('sid');
        $gbid    = plum_get_int_param('gbid');
        $refundTids = rawurldecode(trim($_REQUEST['refundTids']));
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->lotteryRefundTmpl($gbid, $refundTids);
    }

    /**
     * 社区团购团长审核通知
     */
    public function leaderHandleTemplAction(){
        $sid   = plum_get_int_param('sid');
        $id    = plum_get_int_param('id');
        $comId = plum_get_int_param('comid');
        $mid   = plum_get_int_param('mid');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->leaderHandleTmpl($id, $sid, $comId, $mid);
    }

    /**
     * 积分变更提醒
     */
    public function pointsChangeTemplAction(){
        $sid   = plum_get_int_param('sid');
        $id    = plum_get_int_param('id');
        $before = plum_get_int_param('before');

        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->pointsChangeTempl($id, $before);
    }

    /**
     * 余额变更提醒
     */
    public function coinChangeTemplAction(){
        $sid   = plum_get_int_param('sid');
        $id    = plum_get_int_param('id');
        $appletType = plum_get_int_param('appletType');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->coinChangeTempl($id,$appletType);
    }

    /**
     * 组队红包组队成功
     */
    public function redbagSuccessTemplAction(){
        $sid   = plum_get_int_param('sid');
        $id    = plum_get_int_param('id');

        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->redbagSuccessTempl($id);
    }

    /**
     * 会务报名成功通知
     */
    public function meetingTemplAction(){
        $sid   = plum_get_int_param('sid');
        $tid   = plum_get_param('tid');

        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->meetingTradeTempl($tid);
    }

    /**
     * 留言处理结果通知
     */
    public function formDealTemplAction(){
        $sid   = plum_get_int_param('sid');
        $id    = plum_get_int_param('id');
        $appletType = plum_get_int_param('appletType');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->formDealTempl($id,$appletType);
    }

    /**
     * 店铺被评论通知
     */
    public function shopCommentTemplAction(){
        $sid = plum_get_int_param('sid');
        $id = plum_get_int_param('id');
        $appletType = plum_get_int_param('appletType');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->shopCommentTempl($id,$appletType);
    }

    /**
     * 电话本入驻审核通知
     */
    public function mobileAuditTemplAction(){
        $sid = plum_get_int_param('sid');
        $id = plum_get_int_param('id');
        $appletType = plum_get_int_param('appletType');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->mobileAuditTempl($id,$appletType);
    }

    /**
     * 店铺认领审核通知
     */
    public function shopClaimTemplAction(){
        $sid = plum_get_int_param('sid');
        $id = plum_get_int_param('id');
        $appletType = plum_get_int_param('appletType');
        $wxapp   = new App_Helper_TemplMsg($sid);
        $wxapp->shopClaimTempl($id,$appletType);
    }
}
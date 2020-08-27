<?php

/*
 * 页面内二级菜单数组，一般为付费插件
 * key 为wxmenu中侧边栏的链接
 * value 为除wxmenu侧边栏链接外其它页面的链接
 */


return array(
    //多商家商城
    '/citymall/index'    => array(
        '/citymall/goodsList',
        '/citymall/goodsGroup',
        '/citymall/editGoods'
    ),
    //电话本
    '/mobile/index'    => array(
        '/mobile/categoryList',
        '/mobile/applySet',
        '/mobile/shopList',
        '/mobile/shopEdit',
        '/mobile/errorList'
    ),
    //抽奖管理
    '/meeting/lotteryList'    => array(
        '/meeting/lottery',
        '/meeting/record',
        '/meeting/prizeList',
    ),
    //付费预约
    '/appointment/template'    => array(
        '/appointment/goods',
        '/appointment/addGood',
        '/appointment/appointmentKindList',
        '/appointment/tradeList',
        '/appointment/tradeDetail',
        '/appointment/tradeRefund',
    ),
    //答题
    '/answer/index'    => array(
        '/answer/answerCfg',
        '/answer/subjectList',
        '/answer/subject',
        '/answer/awardList',
        '/answer/awardRecordList',
        '/answer/rank',
    ),
    //积分商城
    '/community/pointCfg'    => array(
        '/community/pointSourceCfg',
        '/community/pointOrder',
        '/community/pointGoods',
        '/community/addPointGoods',
        '/community/selectGoods',
        '/community/couponList',
        '/community/couponAdd',
        '/community/pointTradeDetail',
        '/community/pointTradeRefund',
    ),
    //拼团
    '/group/cfg'    => array(
        '/group/index',
        '/group/addGroup',
        '/group/editGroup',
        '/group/partake',
        '/group/group',
        '/group/order',
        '/group/tradeDetail',
        '/group/activity',
    ),
    //秒杀
    '/limit/cfg'    => array(
        '/limit/group',
        '/limit/index',
        '/limit/add',
        '/limit/limitBanner',
        '/limit/activity',
    ),
    //砍价
    '/bargain/index'    => array(
        '/bargain/list',
        '/bargain/add',
        '/bargain/join',
        '/bargain/order',
        '/bargain/activity',
        '/bargain/tradeDetail',
        '/bargain/tradeRefund'
    ),
    //分销
    '/three/index'    => array(
        '/three/code',
        '/three/center',
        '/three/deduct',
        '/three/goodsRatio',
        '/three/member',
        '/three/daybook',
        '/three/order',
        '/three/withdraw',
        '/three/withdrawCfg',
        '/three/branchcfg',
        '/three/branch',
    ),
    //配送
    '/delivery/index'    => array(
        '/delivery/receiveCfg',
        //'/delivery/sendCfg',
    ),
    //名片夹
    '/businesscard/index' => array(
        '/businesscard/cardTpl',
        '/businesscard/editCard',
        '/businesscard/editTpl',
    ),
    //资讯管理
    '/currency/informationList' => array(
        '/currency/informationCate',
        '/currency/gzhBind',
        '/currency/informationCardType',
        '/currency/addInformation',
        '/currency/informationSlide'
    ),
    //音视频设置
    '/currency/conductVideo' => array(
        '/currency/backgroundMusic',
        '/currency/vrUrl'
    ),
    //云打印机
    '/print/feieList' => array(
        '/print/ticketPrintSet'
    ),
    //储值卡（原充值配置）
    '/member/record' => array(
        '/member/cfg'
    ),
    //计次卡
    '/membercard/storeCfg' => array(
        '/membercard/cardOrder',
        '/membercard/memberCard',
        //'/membercard/index'
    ),
    //折扣卡
    '/membercard/discountCard' => array(
        '/membercard/disCardOrder',
        '/membercard/disMemberCard',
    ),
    //客服管理
    '/customer/index' => array(
        '/customer/chatList'
    ),

);
<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/1/31
 * Time: 上午10:31
 */
return array(
    //多店平台
    'menu'   => array(
        array(
            'title'     => '管理中心',
            'link'      => '/index/index',
            'icon'      => 'icon-dashboard',
            'access'    => 'index-index',
        ),
//        array(
//            'title'     => '商户概览',
//            'link'      => '/statisticanalysis/index',
//            'icon'      => 'fa-line-chart',
//            'access'    => 'analysis-index',
//        ),
//        array(
//            'title'     => '小程序管理',
//            'link'      => '#',
//            'icon'      => 'icon-desktop',
//            'access'    => 'setup-cfg',
//            'submenu'   => array(
//                array(
//                    'title'     => '开发设置',
//                    'link'      => '/setup/index',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'setup-index',
//                    'ignore'    => true
//                ),
//                array(
//                    'title'     => '审核管理',
//                    'link'      => '/setup/code',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'setup-code',
//                    'ignore'    => true
//                ),
//                array(
//                    'title'     => '菜单导航',
//                    'link'      => '/setup/bottomMenu',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'setup-bottomMenu',
//                    'ignore'    => true
//                ),
//                array(
//                    'title'     => '模板消息',
//                    'link'      => '/tplmsg/tpl',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'tplmsg-tpl',
//                ),
//                array(
//                    'title'     => '分身小程序',
//                    'link'      => '/child/index',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'child-index',
//                    'ignore'    => true
//                ),
//                array(
//                    'title'     => '跳转小程序',
//                    'link'      => '/setup/jumpList',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'setup-jumpList',
//                    'ignore'    => true
//                ),
//                array(
//                    'title'     => '开发者模式',
//                    'link'      => '/setup/person',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => 'setup-person',
//                    'ignore'    => true
//                ),
////                array(
////                    'title'     => '支付宝小程序',
////                    'link'      => '/setup/aliapp',
////                    'icon'      => 'icon-bar-chart',
////                    'access'    => 'setup-aliapp',
////                ),
//                array(
//                    'title'     => '数据统计',
//                    'link'      => '/plugin/aldApplet',
//                    'icon'      => 'fa-expeditedssl',
//                    'access'    => 'plugin-aldApplet',
//                    'ignore'    => true
//                ),
//                /*
//                array(
//                    'title'     => '客服消息',
//                    'link'      => '/setup/customer',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => array(),
//                ),
//                */
//            ),
//        ),
        array(
            'title'     => '配置管理',
            'link'      => '#',
            'icon'      => 'fa-cogs',
            'access'    => 'currency-cfg',
            'submenu'   => array(
                array(
                    'title'     => '支付配置',
                    'link'      => '/currency/payStyle',
                    'icon'      => 'icon-cog',
                    'access'    => 'currency-payStyle',
                ),
//array(
//                    'title'     => '收银台',
//                    'link'      => '/currency/cashier',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'currency-cashier',
//                ),
//                array(
//                    'title'     => 'VR/音视频设置',
//                    'link'      => '/currency/conductVideo',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'currency-conductVideo',
//                ),
//                array(
//                    'title'     => '分享海报设置',
//                    'link'      => '/currency/sharecfg',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'currency-sharecfg',
//                ),
//                array(
//                    'title'     => '客服设置',
//                    'link'      => '/currency/kefucfg',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'currency-kefucfg',
//                ),
//                array(
//                    'title'     => '微信卡券',
//                    'link'      => '/currency/wxcard',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'currency-wxcard',
//                ),
//                array(
//                    'title'     => '短信设置',
//                    'link'      => '/plugin/settingSms',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'plugin-settingSms',
//                ),
//                array(
//                    'title'     => '音视频存储',
//                    'link'      => '/currency/video',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'currency-video',
//                ),
//                array(
//                    'title'     => '云打印机',
//                    'link'      => '/print/feieList',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'mall-sendMethod',
//                ),
            ),
        ),
        array(
            'title'     => '模块管理',
            'link'      => '#',
            'icon'      => 'icon-tasks',
            'access'    => 'module-cfg',
            'special'   => true,
            'submenu'   => array(
                array(
                    'title'     => '公告管理',
                    'link'      => '/currency/noticeList',
                    'icon'      => 'icon-cog',
                    'access'    => 'currency-informationList',
                ),
                array(
                    'title'     => '资讯管理',
                    'link'      => '/currency/informationList',
                    'icon'      => 'icon-cog',
                    'access'    => 'currency-informationList',
                ),
            ),
        ),
//        array(
//            'title'     => '平台管理',
//            'link'      => '#',
//            'icon'      => 'icon-home',
//            'access'    => 'community-cfg',
//            'commonTools' => true,   //常用工具模块
//            'submenu'   => array(
//                array(
//                    'title'     => '平台主页',
//                    'link'      => '/community/communityTemplate',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-communityTemplate',
//                    'index-icon'=> '/community/index.png',
//                ),
//                array(
//                    'title'     => '平台商城',
//                    'link'      => '/community/mallCfg',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-mallCfg',
//                    'index-icon'=> '/community/mall.png',
//                ),
//                array(
//                    'title'     => '帖子分类管理',
//                    'link'      => '/community/postCateList',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-postCateList',
//                    'index-icon'=> '/community/post-cate.png',
//                ),
//                array(
//                    'title'     => '帖子管理',
//                    'link'      => '/community/postList',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-postList',
//                    'index-icon'=> '/community/post.png',
//                ),
//                array(
//                    'title'     => '发帖设置',
//                    'link'      => '/city/postTopSet',
//                    'icon'      => 'fa-hand-o-up',
//                    'access'    => 'city-postTopSet',
//                    'index-icon'=> '/community/order-cfg.png',
//                ),
//                array(
//                    'title'     => '个人中心管理',
//                    'link'      => '/community/centerManage',
//                    'icon'      => 'fa-user',
//                    'access'    => 'community-centerManage',
//                    'index-icon'=> '/community/member-center.png',
//                ),
//                array(
//                    'title'     => '关于我们',
//                    'link'      => '/community/aboutUs',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-aboutUs',
//                    'index-icon'=> '/community/about-us.png',
//                ),array(
//                    'title'     => '广告位配置',
//                    'link'      => '/city/ad',
//                    'icon'      => 'fa-yelp',
//                    'access'    => 'city-ad',
//                    'index-icon'=> '/community/ad.png',
//                ),
////                array(
////                    'title'     => '付费会员',
////                    'link'      => '/membercard/discountCard',
////                    'icon'      => 'icon-cog',
////                    'access'    => 'community-vipCard',
////                ),
//            ),
//        ),
//        array(
//            'title'     => '用户管理',
//            'link'      => '#',
//            'icon'      => 'icon-user',
//            'access'    => 'member-list',
//            'commonTools' => true,   //常用工具模块
//            'submenu'   => array(
//                array(
//                    'title'     => '用户列表',
//                    'link'      => '/member/list',
//                    'icon'      => 'icon-user',
//                    'access'    => 'member-list',
//                    'index-icon'=> '/community/member-list.png',
//                ),
//                array(
//                    'title'     => '用户分类',
//                    'link'      => '/member/memberCategoryList',
//                    'icon'      => 'fa-list-ul',
//                    'access'    => 'member-category',
//                    'index-icon'=> '/community/member-cate.png',
//                ),
//                array(
//                    'title'     => '用户等级',
//                    'link'      => '/member/level',
//                    'icon'      => 'icon-user',
//                    'access'    => 'member-level',
//                    'index-icon'=> '/community/member-level.png',
//                ),
//                array(
//                    'title'     => '签到记录',
//                    'link'      => '/member/attendenceRecord',
//                    'icon'      => 'fa-check-square-o',
//                    'access'    => 'member-attendenceRecord',
//                    'index-icon'=> '/community/attendence.png',
//                ),
////                array(
////                    'title'     => '用户充值',
////                    'link'      => '/member/record',
////                    'icon'      => 'fa-ioxhost',
////                    'access'    => 'member/rechargeChange',
////                ),
//            ),
//        ),
//        array(
//            'title'     => '会员卡管理',
//            'link'      => '#',
//            'icon'      => 'fa-id-card',
//            'access'    => 'member-cfg',
//            'submenu'   => array(
//                array(
//                    'title'     => '会员卡',
//                    'link'      => '/membercard/discountCard',
//                    'icon'      => 'fa-pencil-square-o',
//                    'access'    => 'membercard-discountCard',
//                ),
////                array(
////                    'title'     => '计次卡',
////                    'link'      => '/membercard/storeCfg',
////                    'icon'      => 'fa-send-o',
////                    'access'    => 'membercard-card',
////                ),
//                array(
//                    'title'     => '储值卡',
//                    'link'      => '/member/record',
//                    'icon'      => 'fa-ioxhost',
//                    'access'    => 'member-rechargeChange',
//                ),
//            ),
//        ),
//        array(
//            'title'     => '秒杀',
//            'link'      => '#',
//            'icon'      => 'icon-bell',
//            'access'    => array(),
//            'commonTools' => true,   //常用工具模块
//            'submenu'   => array(
//                array(
//                    'title'     => '秒杀首页',
//                    'link'      => '/limit/cfg',
//                    'icon'      => 'icon-bell',
//                    'access'    => array(),
//                ),
//                array(
//                    'title'     => '秒杀商品分组',
//                    'link'      => '/limit/group',
//                    'icon'      => 'icon-bell',
//                    'access'    => array(),
//                ),
//                array(
//                    'title'     => '秒杀活动',
//                    'link'      => '/limit/index',
//                    'icon'      => 'icon-bell',
//                    'access'    => array(),
//                ),
//            ),
//        ),
//        array(
//            'title'     => '拼团管理',
//            'link'      => '/group/index',
//            'icon'      => 'icon-group',
//            'access'    => array(),
//            'commonTools' => true,   //常用工具模块
//        ),

//        array(
//            'title'     => '商家管理',
//            'link'      => '#',
//            'icon'      => 'icon-shopping-cart',
//            'access'    => 'community-shop',
//            'commonTools' => true,   //常用工具模块
//            'submenu'   => array(
//                array(
//                    'title'     => '申请商家',
//                    'link'      => '/community/shopApplyEnter',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-shopApplyEnter',
//                    'index-icon'=> '/community/shop-apply.png',
//                ),
//                array(
//                    'title'     => '已入驻商家',
//                    'link'      => '/community/shopList',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-shopList',
//                    'index-icon'=> '/community/shop-list.png',
//                ),
//                array(
//                    'title'     => '商家分类',
//                    'link'      => '/community/shopCategory',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-shopCategory',
//                    'index-icon'=> '/community/shop-cate.png',
//                ),
//                array(
//                    'title'     => '商圈管理',
//                    'link'      => '/community/district',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-district',
//                    'index-icon'=> '/community/area.png',
//                ),
//                array(
//                    'title'     => '商家提现',
//                    'link'      => '/community/withdraw',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-withdraw',
//                    'index-icon'=> '/community/shop-withdraw.png',
//                ),
//                array(
//                    'title'     => '商家等级',
//                    'link'      => '/community/level',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-level',
//                    'index-icon'=> '/community/shop-level.png',
//                ),
//            ),
//        ),
//        array(
//            'title'     => '商品管理',
//            'link'      => '#',
//            'icon'      => 'icon-shopping-cart',
//            'access'    => 'goods-cfg',
//            'commonTools' => true,   //常用工具模块
//            'submenu'   => array(
//                /*array(
//                    'title'     => '商品分类',
//                    'link'      => '/goods/goodsCategory',
//                    'icon'      => 'icon-tags',
//                    'access'    => 'goods-goodsCategory',
//                ),*/
//                array(
//                    'title'     => '平台商品分组',
//                    'link'      => '/goods/group',
//                    'icon'      => 'icon-tags',
//                    'access'    => 'goods-group',
//                    'index-icon'=> '/community/goods-group.png',
//                ),
//                array(
//                    'title'     => '商家商品分组',
//                    'link'      => '/community/shopGoodsGroup',
//                    'icon'      => 'icon-tags',
//                    'access'    => 'community-shopGoodsGroup',
//                    'index-icon'=> '/community/shop-goods-group.png',
//                ),
//                array(
//                    'title'     => '平台商品分类',
//                    'link'      => '/goods/goodsCategory',
//                    'icon'      => 'fa-align-center',
//                    'access'    => 'goods-goodsCategory',
//                    'index-icon'=> '/city/goods-cate.png',
//                ),
//                array(
//                    'title'     => '全部商品',
//                    'link'      => '/goods/index',
//                    'icon'      => 'icon-th-large',
//                    'access'    => 'goods-index',
//                    'index-icon'=> '/community/goods-list.png',
//                ),
//                array(
//                    'title'     => '商品评价管理',
//                    'link'      => '/order/commentList',
//                    'icon'      => 'icon-th-large',
//                    'access'    => 'order-commentList',
//                    'index-icon'=> '/community/goods-comment.png',
//                ),
//                array(
//                    'title'     => '运费模板',
//                    'link'      => '/delivery/index',
//                    'icon'      => 'icon-th-large',
//                    'access'    => 'delivery-index',
//                    'index-icon'=> '/community/express-tpl.png',
//                ),
//                array(
//                    'title'     => '留言模板',
//                    'link'      => '/goods/messageList',
//                    'icon'      => 'fa-calculator',
//                    'access'    => 'goods-messageList',
//                    'index-icon'=> '/community/message-tpl.png',
//                ),
//            ),
//        ),
        array(
            'title'     => '订单管理',
            'link'      => '#',
            'icon'      => 'icon-list',
            'access'    => 'community-tradeList',
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '全部订单',
                    'link'      => '/community/tradeList',
                    'icon'      => 'icon-th-large',
                    'access'    => 'community-tradeList',
                    'index-icon'=> '/community/order.png',
                ),
                array(
                    'title'     => '维权订单',
                    'link'      => '/order/refundList',
                    'icon'      => 'fa-frown-o',
                    'access'    => 'order-refundList',
                    'index-icon'=> '/city/order-refund.png',
                ),
                array(
                    'title'     => '订单设置',
                    'link'      => '/delivery/tradeSetting',
                    'icon'      => 'icon-cog',
                    'access'    => 'order-tradeCfg',
                    'index-icon'=> '/community/order-cfg.png',
                ),
            ),
        ),
//        array(
//            'title'     => '营销工具',
//            'link'      => '#',
//            'icon'      => 'icon-gift',
//            'access'    => 'group-cfg',
//            'commonTools' => true,   //常用工具模块
//            'submenu'   => array(
//                array(
//                    'title'     => '优惠券',
//                    'link'      => '/coupon/index',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'coupon-index',
//                    'index-icon'=> '/community/coupon.png',
//                ),
//                array(
//                    'title'     => '满减满包邮',
//                    'link'      => '/full/index',
//                    'icon'      => 'fa-archive',
//                    'access'    => 'full-index',
//                    'commonTools' => true,   //常用工具模块
//                ),
//                array(
//                    'title'     => '积分商城',
//                    'link'      => '/community/pointCfg',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'community-pointGoods',
//                    'index-icon'=> '/community/point-shop.png',
//                ),
//                array(
//                    'title'     => '抽奖管理',
//                    'link'      => '/meeting/lotteryList',
//                    'icon'      => 'fa-gift',
//                    'access'    => 'meeting-prizeList',
//                    'index-icon'=> '/community/lottery.png',
//                    'commonTools' => true,   //常用工具模块
//                ),
//                array(
//                    'title'     => '拼团管理',
//                    'link'      => '/group/cfg',
//                    'icon'      => 'fa-users',
//                    'access'    => 'group-index',
//                    'index-icon'=> '/community/group.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'wpt'
//                ),
//                array(
//                    'title'     => '秒杀管理',
//                    'link'      => '/limit/cfg',
//                    'icon'      => 'fa-hourglass-2',
//                    'access'    => 'limit-cfg',
//                    'index-icon'=> '/community/limit.png',
//                    'commonTools' => true,
//                    'plugin_name'=>'wms'
//                ),
//                array(
//                    'title'     => '砍价管理',
//                    'link'      => '/bargain/index',
//                    'icon'      => 'fa-gavel',
//                    'access'    => 'bargain-index',
//                    'index-icon'=> '/community/bargain.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'wkj'
//                ),
//                array(
//                    'title'     => '电话本管理',
//                    'link'      => '/mobile/index',
//                    'icon'      => 'fa-mobile',
//                    'access'    => 'mobile-index',
//                    'index-icon'=> '/community/mobile-book.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'dhb'
//                ),
//                array(
//                    'title'     => '商家预约',
//                    'link'      => '/free/freeTradeList',
//                    'icon'      => 'icon-check',
//                    'access'    => 'free-tradelist',
//                    'index-icon'=> '/community/reservation.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'mfyy'
//                ),
//                array(
//                    'title'     => '客服通知',
//                    'link'      => '/customer/index',
//                    'icon'      => 'fa-comment-o',
//                    'access'    => 'customer-index',
//                    'index-icon'=> '/community/kefu.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'kf'
//                ),
//                array(
//                    'title'     => '拍卖管理',
//                    'link'      => '/auction/indexCfg',
//                    'icon'      => 'fa-sitemap',
//                    'access'    => 'auction-index',
//                    'index-icon'=> '/community/auction.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'pm'
//                ),
////                array(
////                    'title'     => '活动申请列表',
////                    'link'      => '/activity/list',
////                    'icon'      => 'fa-id-card',
////                    'access'    => 'activity-list',
////                    'commonTools' => true,   //常用工具模块
////                ),
//                array(
//                    'title'     => '答题管理',
//                    'link'      => '/answer/index',
//                    'icon'      => 'icon-cog',
//                    'access'    => 'answer-index',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'dt',
//                ),
//                array(
//                    'title'     => '分销合伙人',
//                    'link'      => '/copartner/index',
//                    'icon'      => 'fa-sitemap',
//                    'access'    => 'copartner-index',
//                    'index-icon'=> '/community/member-cate.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=> 'hhr'
//                ),
//                /*array(
//                    'title'     => '蜂鸟配送',
//                    'link'      => '/plugin/settingEle#',
//                    'icon'      => 'fa-user-o',
//                    'access'    => 'setting-ele',
//                    'index-icon'=> '/community/ele-send.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'anubis'
//                ),*/
//                array(
//                    'title'     => '跑腿配送',
//                    'link'      => '/plugin/otherLegworkCfg',
//                    'icon'      => 'fa-user-o',
//                    'access'    => 'setting-otherlegwork',
//                ),
//                array(
//                    'title'     => '自动回复',
//                    'link'      => '/service/msgList#',
//                    'icon'      => 'fa-user-o',
//                    'access'    => 'setting-ele',
//                    'index-icon'=> '/community/message-tpl.png',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'autoreply'
//                ),
//                array(
//                    'title'     => '收藏有礼',
//                    'link'      => '/collectionprize/index',
//                    'icon'      => 'icon-tags',
//                    'access'    => 'collection-prize',
//                    'commonTools' => true,   //常用工具模块
//                    'plugin_name'=>'scyl'
//                ),
//                array(
//                    'title'     => '新年祝福',
//                    'link'      => '/plugin/blessingSet',
//                    'icon'      => 'fa-gift',
//                    'index-icon'=> '/community/new-year.png',
//                    'access'    => 'plugin-blessingSet',
//                ),
//                array(
//                    'title'     => '刷脸支付',
//                    'link'      => '/cashier/record',
//                    'icon'      => 'icon-money',
//                    'access'    => 'plugin-cashier',
//                    'plugin_name'=>'cashier'
//                ),
//            ),
//        ),
        array(
            'title'     => '操作日志',
            'link'      => '/manager/operateLogList',
            'icon'      => 'icon-columns',
            'access'    => 'operate-log',
        ),
    ),
    'menu_power' => array(
        'operate-log',
        'index-index',       //首页
        'analysis-index',    //商户概览
        'setup-cfg',
        'setup-index',      // 开发设置
        'setup-code',       // 审核管理
        'setup-bottomMenu',           //菜单导航
        'tplmsg-tpl',                 //模板消息
        'child-index',                //分身小程序
        'setup-jumpList',             //跳转小程序
        'setup-person',                 //开发者模式
        // 'setup-aliapp',                 //支付宝小程序
        'plugin-aldApplet',
        'module-cfg',
        'currency-payStyle',             //支付配置
        'currency-conductVideo',         //VR音视频管理
        'currency-sharecfg',            // 分享设置
        'currency-kefucfg',             // 客服设置
        'currency-wxcard',             // 微信卡券
        'currency-cashier',            // 收银台
        'currency-informationList',    //资讯管理
        'currency-appointmentList',    //留言管理
        'appointment-template',
        /*'membercard-index',            // 门店列表
        'member-cfg',                     //会员卡管理
        'membercard-card',              // 会员计次卡
        */
        'member-rechargeChange',          // 会员储值卡
        'membercard-discountCard',        // 会员折扣卡
        'plugin-cfg',                     // 插件管理
        'plugin-settingSms',             // 短信设置
        'currency-video',                // VR音视频管理
        'mall-sendMethod',
        'member-list',       //
        'member-list',
        'member-level',
        //'member/rechargeChange',
        'community-cfg',
        'community-indexTpl',       //
        'community-shopCategory',       //

        'community-district',       //
        'city-postTopSet',       //
        'community-postList',       //
        //'community-vipCard',       //
        'community-pointGoods',       //
        'community-mallCfg',       //
        // 'community-mallCfg',       //
        'community-aboutUs',       //
        'community-shop',
        'community-shopApplyEnter',       //
        'community-shopList',       //
        'community-withdraw',       //
        'community-level',       //
        'goods-cfg',
        'city-ad',
        // 'goods-goodsCategory',       //
        'goods-group',       //
        'community-shopGoodsGroup',       //
        'goods-index',       //
        'delivery-index',       //
        'order-commentList',       //
        'order-tradeCfg',       //
        'community-tradeList',       //
        'group-cfg',
        'group-index',       //
        'limit-cfg',       //
        'coupon-index',       //
        'mobile-index',       //
        // 'appointment-template'  ,    //付费预约管理
        'activity-list',
        'community-centerManage',
        'currency-cfg',
        'member-attendenceRecord',
        'free-tradelist',
        'customer-index',
        'community-postCateList',
        'popup-list',
        'startimg-list',
        'full-index',
        'bargain-index',  //砍价
        'collection-prize',
        'order-refundList',
        'copartner-index',   //分销合伙人
//        'free-tradelist'
        'setting-otherlegwork',
        'plugin-cashier',
    ),
    'plugin' => array(
        'dt' => array(
            'name' => '答题',
            'price' => 600,
            'noPack' => true
        ),
        'gdb' => array(
            'name' => '过渡版',
            'price' => 100,
            'noPack' => true,
        ),
        'wpt' => array(
            'name' => '微拼团',
            'price' => 600,
        ),
        'wms' => array(
            'name' => '微秒杀',
            'price' => 400,
        ),
        'wkj' => array(
            'name' => '微砍价',
            'price' => 400,
        ),
        'dhb' => array(
            'name' => '电话本',
            'price' => 300,
        ),
//        'kf' => array(
//            'name' => '客服通知',
//            'price' => 600,
//        ),
        'mfyy' => array(
            'name' => '商家预约',
            'price' => 600,
        ),
        'pm' => array(
            'name' => '拍卖',
            'price' => 400,
            'noPack' => true,
        ),
        'mbfz' => array(
            'name' => '自定义模板分组',
            'price' => 300,
            'noPack' => true,
        ),
        'hhr' => array(
            'name' => '微分销',
            'price' => 900,
            'noPack' => true,
        ),
        /*'anubis' => array(
            'name' => '蜂鸟配送',
            'price' => 400,
            'noPack' => true,
        ),*/
//        'autoreply' => array(
//            'name' => '自动回复',
//            'price' => 600,
//            'noPack' => true,
//        ),
        'queue' => array(
            'name' => '排号',
            'price' => 600,
            'noPack' => true,
        ),
        'cashier' => array(
            'name' => '收银台',
            'price' => 0,
            'noPack' => true,
        ),
//        'scyl' => array(
//            'name' => '收藏有礼',
//            'price' => 600,
//            'noPack' => true,
//        ),
    )
);
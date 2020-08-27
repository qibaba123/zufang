<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/1/31
 * Time: 上午10:31
 */
return array(
    //知识付费小程序
    'menu'   => array(
        array(
            'title'     => '管理中心',
            'link'      => '/index/index',
            'icon'      => 'icon-dashboard',
            'access'    => 'index-index',
        ),
        array(
            'title'     => '商户概览',
            'link'      => '/statisticanalysis/index',
            'icon'      => 'fa-line-chart',
            'access'    => 'analysis-index',
        ),
        array(
            'title'     => '小程序管理',
            'link'      => '#',
            'icon'      => 'fa-scribd',
            'access'    => 'setup-setup',
            'submenu'   => array(
                array(
                    'title'     => '开发设置',
                    'link'      => '/setup/index',
                    'icon'      => 'fa-wrench',
                    'access'    => 'setup-index',
                    'ignore'    => true
                ),
                array(
                    'title'     => '审核管理',
                    'link'      => '/setup/code',
                    'icon'      => 'fa-superpowers',
                    'access'    => 'setup-code',
                    'ignore'    => true
                ),
                array(
                    'title'     => '菜单导航',
                    'link'      => '/setup/bottomMenu',
                    'icon'      => 'fa-th-large',
                    'access'    => 'setup-bottomMenu',
                    'ignore'    => true
                ),
                array(
                    'title'     => '模板消息',
                    'link'      => '/tplmsg/tpl',
                    'icon'      => 'fa-envelope-square',
                    'access'    => 'tplmsg-tpl',
                ),
                array(
                    'title'     => '分身小程序',
                    'link'      => '/child/index',
                    'icon'      => 'fa-window-restore',
                    'access'    => 'child-index',
                    'ignore'    => true
                ),
                array(
                    'title'     => '跳转小程序',
                    'link'      => '/setup/jumpList',
                    'icon'      => 'fa-mail-forward',
                    'access'    => 'setup-jumpList',
                    'ignore'    => true
                ),
                array(
                    'title'     => '开发者模式',
                    'link'      => '/setup/person',
                    'icon'      => 'fa-life-bouy',
                    'access'    => 'setup-person',
                    'ignore'    => true
                ),
//                array(
//                    'title'     => '支付宝小程序',
//                    'link'      => '/setup/aliapp',
//                    'icon'      => 'fa-expeditedssl',
//                    'access'    => 'setup-aliapp',
//                ),
                array(
                    'title'     => '数据统计',
                    'link'      => '/plugin/aldApplet',
                    'icon'      => 'fa-expeditedssl',
                    'access'    => 'setup-aliapp',
                    'ignore'    => true
                ),
            ),
        ),
        array(
            'title'     => '配置管理',
            'link'      => '#',
            'icon'      => 'fa-cogs',
            'access'    => 'currency-cfg',
            'submenu'   => array(
                array(
                    'title'     => '支付配置',
                    'link'      => '/currency/payStyle',
                    'icon'      => 'fa-yen',
                    'access'    => 'currency-payStyle',
                ),
                array(
                    'title'     => 'VR/音视频设置',
                    'link'      => '/currency/conductVideo',
                    'icon'      => 'fa-youtube-play',
                    'access'    => 'currency-conductVideo',
                ),
                array(
                    'title'     => '分享海报设置',
                    'link'      => '/currency/sharecfg',
                    'icon'      => 'fa-share-alt',
                    'access'    => 'currency-sharecfg',
                ),
                array(
                    'title'     => '客服设置',
                    'link'      => '/currency/kefucfg',
                    'icon'      => 'fa-comments',
                    'access'    => 'currency-kefucfg',
                ),
                array(
                    'title'     => '微信卡券',
                    'link'      => '/currency/wxcard',
                    'icon'      => 'fa-credit-card-alt',
                    'access'    => 'currency-wxcard',
                ),
            ),
        ),
        array(
            'title'     => '模块管理',
            'link'      => '#',
            'icon'      => 'fa-cubes',
            'access'    => 'module-cfg',
            'submenu'   => array(
//                array(
//                    'title'     => '收银台',
//                    'link'      => '/currency/cashier',
//                    'icon'      => 'fa-laptop',
//                    'access'    => 'currency-cashier',
//                ),
                array(
                    'title'     => '资讯管理',
                    'link'      => '/currency/informationList',
                    'icon'      => 'fa-send-o',
                    'access'    => 'currency-informationList',
                ),
              /*  array(
                    'title'     => '留言管理',
                    'link'      => '/currency/appointmentList',
                    'icon'      => 'fa-pencil-square-o',
                    'access'    => 'currency-appointmentList',
                ),*/
                array(
                    'title'     => '留言管理',
                    'link'      => '/form/formData',
                    'icon'      => 'fa-pencil-square-o',
                    'access'    => 'currency-appointmentList',
                ),
//                array(
//                    'title'     => '门店会员卡',
//                    'link'      => '/membercard/index',
//                    'icon'      => 'fa-credit-card-alt',
//                    'access'    => array(),
//                ),
//                array(
//                    'title'     => '门店列表',
//                    'link'      => '/membercard/index',
//                    'icon'      => 'fa-credit-card-alt',
//                    'access'    => 'membercard-index',
//                ),
                array(
                    'title'     => '启动图管理',
                    'link'      => '/popup/startimglist',
                    'icon'      => 'fa-file-image-o',
                    'access'    => 'startimg-list',
                ),
            ),
        ),
        array(
            'title'     => '用户管理',
            'link'      => '#',
            'icon'      => 'fa-user-o',
            'access'    => 'member-cfg',
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '用户列表',
                    'link'      => '/member/list',
                    'icon'      => 'fa-list-ul',
                    'access'    => 'member-list',
                    'index-icon'=> '/knowpay/member-list.png',
                ),
                array(
                    'title'     => '用户分类',
                    'link'      => '/member/memberCategoryList',
                    'icon'      => 'fa-list-ul',
                    'access'    => 'member-category',
                    'index-icon'=> '/knowpay/member-cate.png',
                ),
                array(
                     'title'     => '用户等级',
                     'link'      => '/member/level',
                     'icon'      => 'icon-user',
                     'access'    => 'member-level',
                    'index-icon'=> '/knowpay/member-level.png',
                 ),
                array(
                    'title'     => '签到记录',
                    'link'      => '/member/attendenceRecord',
                    'icon'      => 'fa-check-square-o',
                    'access'    => 'member-attendenceRecord',
                    'index-icon'=> '/knowpay/attendence.png',
                ),
//                array(
//                    'title'     => '用户充值',
//                    'link'      => '/member/record',
//                    'icon'      => 'fa-ioxhost',
//                    'access'    => array(),
//                ),
            ),
        ),
        array(
            'title'     => '会员卡管理',
            'link'      => '#',
            'icon'      => 'fa-id-card',
            'access'    => 'member-cfg1',
            'submenu'   => array(
                array(
                    'title'     => '会员卡',
                    'link'      => '/membercard/discountCard',
                    'icon'      => 'fa-pencil-square-o',
                    'access'    => 'membercard-discountCard',
                ),
                array(
                    'title'     => '储值卡',
                    'link'      => '/member/record',
                    'icon'      => 'fa-ioxhost',
                    'access'    => 'member-rechargeChange',
                ),
//                array(
//                    'title'     => '计次卡',
//                    'link'      => '/membercard/storeCfg',
//                    'icon'      => 'fa-send-o',
//                    'access'    => 'membercard-card',
//                ),

            ),
        ),
        array(
            'title'     => '插件管理',
            'link'      => '#',
            'icon'      => 'fa-plug',
            'access'    => 'plugin-cfg',
            'submenu'   => array(
                array(
                    'title'     => '短信设置',
                    'link'      => '/plugin/settingSms',
                    'icon'      => 'fa-envelope-o',
                    'access'    => 'plugin-settingSms',
                ),
                array(
                    'title'     => '音视频存储',
                    'link'      => '/currency/video',
                    'icon'      => 'fa-cloud-upload',
                    'access'    => 'currency-video',
                ),
                array(
                    'title'     => '云打印机',
                    'link'      => '/print/feieList',
                    'icon'      => 'icon-cog',
                    'access'    => 'mall-sendMethod',
                ),
            ),
        ),
        array(
            'title'     => '知识付费管理',
            'link'      => '#',
            'icon'      => 'icon-home',
            'access'    => 'enterprise-cfg',
            'special'   => true,
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '主页管理',
                    //'link'      => '/knowledgepay/indexTpl',
                    'link'      => '/knowledgepay/knowpayTemplate',
                    'icon'      => 'icon-cog',
                    'access'    => 'question-indexTpl',
                    'index-icon'=> '/knowpay/index.png',
                ),
                array(
                    'title'     => '活动页配置',
                    'link'      => '/knowledgepay/activity',
                    'icon'      => 'icon-cog',
                    'access'    => 'question-category',
                    'index-icon'=> '/knowpay/activity.png',
                ),
                array(
                    'title'     => '个人中心管理',
                    'link'      => '/knowledgepay/centerManage',
                    'icon'      => 'fa-user',
                    'access'    => 'city-centerManage',
                    'index-icon'=> '/knowpay/member-center.png',
                ),
                array(
                    'title'     => '会员兑换码',
                    'link'      => '/knowledgepay/rechargeCode',
                    'icon'      => 'fa-user',
                    'access'    => 'knowledgepay-rechargeCode',
                    'index-icon'=> '/knowpay/member-code.png',
                ),
                array(
                    'title'     => '广告位配置',
                    'link'      => '/city/ad',
                    'icon'      => 'fa-yelp',
                    'access'    => 'city-ad',
                    'index-icon'=> '/knowpay/ad.png',
                ),
                array(
                    'title'     => '经典语录管理',
                    'link'      => '/knowledgepay/quotationList',
                    'icon'      => 'icon-quote-left',
                    'access'    => 'quotation-list',
                    'index-icon'=> '/knowpay/quotation.png',
                ),
                array(
                    'title'     => '帖子分类管理',
                    'link'      => '/community/postCateList',
                    'icon'      => 'icon-cog',
                    'access'    => 'community-postCateList',
                    'index-icon'=> '/knowpay/post-cate.png',
                ),
                array(
                    'title'     => '帖子管理',
                    'link'      => '/community/postList',
                    'icon'      => 'icon-cog',
                    'access'    => 'community-postList',
                    'index-icon'=> '/knowpay/post.png',
                ),
                array(
                    'title'     => '发帖设置',
                    'link'      => '/city/postTopSet',
                    'icon'      => 'fa-hand-o-up',
                    'access'    => 'city-postTopSet',
                    'index-icon'=> '/knowpay/post-cfg.png',
                ),
            ),
        ),
        array(
            'title'     => '课程管理',
            'link'      => '#',
            'icon'      => 'fa-shopping-cart',
            'access'    => 'goods-cfg',
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '课程分类',
                    'link'      => '/goods/goodsCategory',
                    'icon'      => 'icon-cog',
                    'access'    => 'question-list',
                    'index-icon'=> '/knowpay/class-cate.png',
                ),
                array(
                    'title'     => '课程列表',
                    'link'      => '/knowledgepay/goodsList',
                    'icon'      => 'icon-cog',
                    'access'    => 'goods-category',
                    'index-icon'=> '/knowpay/class-list.png',
                ),
                array(
                    'title'     => '作者列表',
                    'link'      => '/knowledgepay/teacherList',
                    'icon'      => 'icon-cog',
                    'access'    => 'goods-category',
                    'index-icon'=> '/knowpay/class-list.png',
                ),
                array(
                    'title'     => '评论管理',
                    'link'      => '/knowledgepay/commentList',
                    'icon'      => 'icon-cog',
                    'access'    => 'knowledgepay-commentList',
                    'index-icon'=> '/knowpay/comment.png',
                ),
                array(
                    'title'     => '留言模板',
                    'link'      => '/goods/messageList',
                    'icon'      => 'fa-calculator',
                    'access'    => 'goods-messageList',
                    'index-icon'=> '/knowpay/message-tpl.png',
                ),
            ),
        ),
        array(
            'title'     => '订单管理',
            'link'      => '#',
            'icon'      => 'fa-tasks',
            'access'    => 'order-list',
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '课程订单',
                    'link'      => '/knowledgepay/tradeList',
                    'icon'      => 'fa-shopping-bag',
                    'access'    => 'order-tradeList',
                    'index-icon'=> '/knowpay/class-order.png',
                )
            ),
        ),
        array(
            'title'     => '商城管理',
            'link'      => '#',
            'icon'      => 'icon-home',
            'access'    => 'mall-cfg',
            'submenu'   => array(
                array(
                    'title'     => '商品分类',
                    'link'      => '/goods/goodsCategoryIndependent',
                    'icon'      => 'fa-align-center',
                    'access'    => 'goods-goodsCategory',
                    'index-icon'=> '/meal/goods-cate.png'
                ),
                array(
                    'title'     => '商品列表',
                    'link'      => '/goods/index',
                    'icon'      => 'fa-list-ol',
                    'access'    => 'goods-index',
                    'index-icon'=> '/meal/goods-list.png'
                ),
                array(
                    'title'     => '运费模板',
                    'link'      => '/delivery/index',
                    'icon'      => 'fa-calculator',
                    'access'    => 'delivery-index',
                ),
                array(
                    'title'     => '商品评价',
                    'link'      => '/order/commentList',
                    'icon'      => 'fa-pencil',
                    'access'    => 'order-commentList',
                ),
                array(
                    'title'     => '商城订单',
                    'link'      => '/order/tradeList',
                    'icon'      => 'fa-shopping-bag',
                    'access'    => 'order-tradeList',
                ),
                array(
                    'title'     => '维权订单',
                    'link'      => '/order/refundList',
                    'icon'      => 'fa-frown-o',
                    'access'    => 'order-refundList',
                ),
                array(
                    'title'     => '订单设置',
                    'link'      => '/delivery/tradeSetting',
                    'icon'      => 'icon-cog',
                    'access'    => 'order-tradeCfg',
                ),
            ),
        ),
        array(
            'title'     => '营销工具',
            'link'      => '#',
            'icon'      => 'fa-suitcase',
            'access'    => 'three-cfg',
            'submenu'   => array(
                array(
                    'title'     => '优惠券',
                    'link'      => '/coupon/index',
                    'icon'      => 'icon-cog',
                    'access'    => 'coupon-index',
                ),
                array(
                    'title'     => '付费预约',
                    'link'      => '/appointment/template',
                    'icon'      => 'fa-handshake-o',
                    'access'    => 'appointment-template',
                    'submenu'   => array(),
                ),
                array(
                    'title'     => '分销中心',
                    'link'      => '/three/index',
                    'icon'      => 'fa-sitemap',
                    'access'    => 'three-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wfx'
                ),
                array(
                    'title'     => '拼团管理',
                    'link'      => '/group/index',
                    'icon'      => 'fa-users',
                    'access'    => 'group-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wpt'
                ),
                array(
                    'title'     => '砍价管理',
                    'link'      => '/bargain/list',
                    'icon'      => 'fa-gavel',
                    'access'    => 'bargain-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wkj'
                ),
                array(
                    'title'     => '积分商城',
                    'link'      => '/knowledgepay/pointGoods',
                    'icon'      => 'fa-database',
                    'access'    => 'community-pointGoods',
                    'commonTools' => true,   //常用工具模块
                ),
                array(
                    'title'     => '秒杀管理',
                    'link'      => '/limit/index',
                    'icon'      => 'fa-hourglass-2',
                    'access'    => 'limit-cfg',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wms'
                ),
                array(
                    'title'     => '抽奖管理',
                    'link'      => '/meeting/lotteryList',
                    'icon'      => 'fa-gift',
                    'access'    => 'meeting-prizeList',
                    'commonTools' => true,   //常用工具模块
                ),
                array(
                    'title'     => '答题管理',
                    'link'      => '/answer/index',
                    'icon'      => 'icon-cog',
                    'access'    => 'answer-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'dt'
                ),
                array(
                    'title'     => '客服通知',
                    'link'      => '/customer/index',
                    'icon'      => 'fa-comment-o',
                    'access'    => 'customer-index',
                    'commonTools' => true,   //常用工具模块
                     'plugin_name'=>'kf'
                ),
                array(
                    'title'     => '自动回复',
                    'link'      => '/service/msgList#',
                    'icon'      => 'fa-user-o',
                    'access'    => 'setting-ele',
                    'commonTools' => true,   //常用工具模块
                     'plugin_name'=>'autoreply'
                ),
                array(
                    'title'     => '收藏有礼',
                    'link'      => '/collectionprize/index',
                    'icon'      => 'icon-tags',
                    'access'    => 'collection-prize',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'scyl'
                ),
                array(
                    'title'     => '新年祝福',
                    'link'      => '/plugin/blessingSet',
                    'icon'      => 'fa-gift',
                    'access'    => 'plugin-blessingSet',
                ),
            ),
        ),
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
        'setup-setup',
        'setup-index',      // 开发设置
        'setup-code',       // 审核管理
        'setup-bottomMenu',           //菜单导航
        'tplmsg-tpl',                 //模板消息
        'child-index',                //分身小程序
        'setup-jumpList',             //跳转小程序
        'setup-person',                 //开发者模式
        'setup-aliapp',                 //支付宝小程序
         'currency-cfg',
        'currency-payStyle',             //支付配置
        'currency-conductVideo',         //VR音视频管理
        'currency-sharecfg',            // 分享设置
        'currency-kefucfg',
        'currency-wxcard',
        'module-cfg',// 微信卡券
        'currency-cashier',            // 收银台
        'currency-informationList',    //资讯管理
        'currency-appointmentList',    //留言管理
      'membercard-index',            // 门店列表
        /* 'appointment-template',
       'appointment-goods',
       'appointment-tradeList',*/
        'city-ad',
        'member-cfg1',                     //会员卡管理
        'member-rechargeChange',          // 会员储值卡
        'membercard-card',               // 会员计次卡
        'membercard-discountCard',
        'member-cfg',
        'member-list',
        'member-level',


        'plugin-cfg',
        'plugin-settingSms',// 插件管理
        'currency-video',
        'mall-sendMethod',

        'enterprise-cfg',
        'question-indexTpl',
        'question-category',
        'city-centerManage',
        'knowledgepay-rechargeCode',
        'goods-cfg',
        'question-list',
        'goods-category',
        'knowledgepay-commentList',
        'order-list',
        'order-tradeList',
        'three-cfg',
        'coupon-index',
        'three-index',
        'group-index',
        'bargain-index',
        'community-pointGoods',
        'limit-cfg',
        'customer-index',
        'collection-prize',
        'quotation-list',
        'startimg-list',
    ),


    'extra' => array(
        'bottom'    => false,//无底部菜单说明
    ),
    'plugin' => array(
        'gdb' => array(
            'name' => '过渡版',
            'price' => 100,
            'noPack' => true,
        ),
        'wkj' => array(
            'name' => '微砍价',
            'price' => 400,
        ),
        'wfx' => array(
            'name' => '微分销',
            'price' => 900,
        ),
        'wpt' => array(
            'name' => '微拼团',
            'price' => 600,
        ),
        'wms' => array(
            'name' => '微秒杀',
            'price' => 400,
        ),
//        'kf' => array(
//            'name' => '客服通知',
//            'price' => 600,
//        ),
//        'dt' => array(
//            'name' => '答题',
//            'price' => 600,
//        ),
//        'autoreply' => array(
//            'name' => '自动回复',
//            'price' => 600,
//            'noPack' => true,
//        ),
//        'scyl' => array(
//            'name' => '收藏有礼',
//            'price' => 600,
//            'noPack' => true,
//        ),
    )
);
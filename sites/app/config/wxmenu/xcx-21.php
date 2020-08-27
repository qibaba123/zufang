<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/1/31
 * Time: 上午10:31
 */
return array(
    //营销商城
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
            'access'    => 'setup-cfg',
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
//                array(
//                    'title'     => '模板消息',
//                    'link'      => '/tplmsg/tpl',
//                    'icon'      => 'fa-envelope-square',
//                    'access'    => 'tplmsg-tpl',
//                ),
                array(
                    'title'     => '订阅消息消息',
                    'link'      => '/tplmsg/subscribetpl',
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
               // array(
               //     'title'     => '支付宝小程序',
               //     'link'      => '/setup/aliapp',
               //     'icon'      => 'fa-expeditedssl',
               //     'access'    => 'setup-aliapp',
               // ),
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
                ),array(
                    'title'     => '收银台',
                    'link'      => '/currency/cashier',
                    'icon'      => 'fa-laptop',
                    'access'    => 'currency-cashier',
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
                // array(
                //     'title'     => '微信卡券',
                //     'link'      => '/currency/wxcard',
                //     'icon'      => 'fa-credit-card-alt',
                //     'access'    => 'currency-wxcard',
                // ),
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
            'title'     => '模块管理',
            'link'      => '#',
            'icon'      => 'fa-cubes',
            'access'    => 'module-cfg',
            'submenu'   => array(

                array(
                    'title'     => '资讯管理',
                    'link'      => '/currency/informationList',
                    'icon'      => 'fa-send-o',
                    'access'    => 'currency-informationList',
                ),
                array(
                    'title'     => '帮助中心管理',
                    'link'      => '/currency/helpCenterInfoList',
                    'icon'      => 'icon-question-sign',
                    'access'    => 'helpcenter-list',

                ),
            ),
        ),
        array(
            'title'     => '店铺管理',
            'link'      => '#',
            'icon'      => 'fa-university',
            'access'    => 'mall-cfg',
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '店铺主页',
                    'link'      => '/mall/mallTemplate',
                    'icon'      => 'fa-home',
                    'access'    => 'mall-mallTemplate',
                    'index-icon'=> '/shop/index.png',
                ),


                array(
                    'title'     => '个人中心设置',
                    'link'      => '/member/mallCenterManage',
                    'icon'      => 'fa-user',
                    'access'    => 'member-mallCenterManage',
                    'index-icon'=> '/shop/member-center.png',
                ),
                array(
                    'title'     => '配送方式',
                    'link'      => '/delivery/sendCfg',
                    'icon'      => 'fa-truck',
                    'access'    => 'mall-sendMethod',
                    'index-icon'=> '/shop/express.png',
                ),
                array(
                    'title'     => '门店列表',
                    'link'      => '/membercard/index',
                    'icon'      => 'fa-credit-card-alt',
                    'access'    => 'membercard-index',
                    'index-icon'=> '/shop/shop-list.png',
                ),
                array(
                    'title'     => '广告位配置',
                    'link'      => '/city/ad',
                    'icon'      => 'fa-yelp',
                    'access'    => 'city-ad',
                    'index-icon'=> '/shop/ad.png',
                ),
            ),
        ),
        array(
            'title'     => '商品管理',
            'link'      => '#',
            'icon'      => 'fa-shopping-cart',
            'access'    => 'goods-cfg',
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
                array(
                    'title'     => '商品分类',
                    'link'      => '/goods/goodsCategory',
                    'icon'      => 'fa-align-center',
                    'access'    => 'goods-goodsCategory',
                    'index-icon'=> '/shop/goods-cate.png',
                ),
                array(
                    'title'     => '商品列表',
                    'link'      => '/goods/index',
                    'icon'      => 'fa-list-ol',
                    'access'    => 'goods-index',
                    'index-icon'=> '/shop/goods-list.png',
                ),
                array(
                    'title'     => '商品分组',
                    'link'      => '/goods/group',
                    'icon'      => 'icon-tags',
                    'access'    => 'goods-group',
                    'index-icon'=> '/shop/goods-group.png',
                ),
               // array(
               //     'title'     => '运费模板',
               //     'link'      => '/delivery/index',
               //     'icon'      => 'fa-calculator',
               //     'access'    => 'delivery-index',
               // ),
                array(
                    'title'     => '留言模板',
                    'link'      => '/goods/messageList',
                    'icon'      => 'fa-calculator',
                    'access'    => 'goods-messageList',
                    'index-icon'=> '/shop/message-tpl.png',
                ),
                array(
                    'title'     => '商品评价',
                    'link'      => '/order/commentList',
                    'icon'      => 'fa-pencil',
                    'access'    => 'order-commentList',
                    'index-icon'=> '/shop/goods-comment.png',
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
                    'title'     => '全部订单',
                    'link'      => '/order/tradeList',
                    'icon'      => 'fa-shopping-bag',
                    'access'    => 'order-tradeList',
                    'index-icon'=> '/shop/order.png',
                ),
                array(
                    'title'     => '维权订单',
                    'link'      => '/order/refundList',
                    'icon'      => 'fa-frown-o',
                    'access'    => 'order-refundList',
                    'index-icon'=> '/shop/order-refund.png',
                ),
                array(
                    'title'     => '订单设置',
                    'link'      => '/delivery/tradeSetting',
                    'icon'      => 'icon-cog',
                    'access'    => 'order-tradeCfg',
                    'index-icon'=> '/shop/order-cfg.png',
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
                    'index-icon'=> '/shop/member-list.png',
                ),
                array(
                    'title'     => '用户分类',
                    'link'      => '/member/memberCategoryList',
                    'icon'      => 'fa-list-ul',
                    'access'    => 'member-category',
                    'index-icon'=> '/shop/member-cate.png',
                ),
                array(
                    'title'     => '用户等级',
                    'link'      => '/member/level',
                    'icon'      => 'icon-user',
                    'access'    => 'member-level',
                    'index-icon'=> '/shop/member-level-shop.png',
                ),
                array(
                    'title'     => '签到记录',
                    'link'      => '/member/attendenceRecord',
                    'icon'      => 'fa-check-square-o',
                    'access'    => 'member-attendenceRecord',
                    'index-icon'=> '/shop/attendence.png',
                ),
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
                    'title'     => '计次卡',
                    'link'      => '/membercard/storeCfg',
                    'icon'      => 'fa-send-o',
                    'access'    => 'membercard-card',
                ),
                array(
                    'title'     => '储值卡',
                    'link'      => '/member/record',
                    'icon'      => 'fa-ioxhost',
                    'access'    => 'member-rechargeChange',
                ),
                array(
                    'title'     => '微财猫会员卡',
                    'link'      => '/membercard/vcaimaoCardCfg',
                    'icon'      => 'fa-ioxhost',
                    'access'    => 'member-rechargeChange',
                ),
            ),
        ),
        //数据中心
        array(
            'title'         =>'数据中心',
            'link'          =>'#',
            'icon'          =>'icon-bar-chart',
            'access'        =>'statistics-data',
            'commonTools'   => true,
            'submenu'       =>array(
                array(
                    'title'     => '商品转化率',
                    'link'      => '/seqstatistics/goodsTrans',
                    'icon'      => 'icon-star',
                    'access'    => 'statistics-goods-trans',
                ),
                array(
                    'title'     => '商品销售排行',
                    'link'      => '/seqstatistics/goodsRank',
                    'icon'      => 'icon-star',
                    'access'    => 'statistics-goods-rank',
                ),
                array(
                    'title'     => '会员增长趋势',
                    'link'      => '/seqstatistics/memberIncrease',
                    'icon'      => 'icon-star',
                    'access'    => 'statistics-memberIncrease',
                ),
                array(
                    'title'     => '会员消费排行',
                    'link'      => '/seqstatistics/memberCost',
                    'icon'      => 'icon-star',
                    'access'    => 'statistics-memberCost',
                ),
                array(
                    'title'     => '销售额统计',
                    'link'      => '/seqstatistics/sale',
                    'icon'      => 'icon-star',
                    'access'    => 'statistics-sale',
                ),
                array(
                    'title'     => '销售指标',
                    'link'      => '/seqstatistics/saleAnalysis',
                    'icon'      => 'icon-star',
                    'access'    => 'statistics-saleAnalysis',
                ),
            )
        ),


       // array(
       //     'title'     => '插件管理',
       //     'link'      => '#',
       //     'icon'      => 'fa-plug',
       //     'access'    => 'plugin-cfg',
       //     'submenu'   => array(
       //         array(
       //             'title'     => '短信设置',
       //             'link'      => '/plugin/settingSms',
       //             'icon'      => 'fa-envelope-o',
       //             'access'    => 'plugin-settingSms',
       //         ),
       //         array(
       //             'title'     => '音视频存储',
       //             'link'      => '/currency/video',
       //             'icon'      => 'fa-cloud-upload',
       //             'access'    => 'currency-video',
       //         ),
       //         array(
       //             'title'     => '云打印机',
       //             'link'      => '/print/feieList',
       //             'icon'      => 'icon-cog',
       //             'access'    => 'mall-sendMethod',
       //         ),
       //     ),
       // ),
        array(
            'title'     => '美食区管理',
            'link'      => '#',
            'icon'      => 'icon-lemon',
            'access'    => 'sequence-menu',
            'submenu'   => array(

                array(
                    'title'     => '美食区首页',
                    'link'      => '/sequence/menuIndex',
                    'icon'      => 'icon-cogs',
                    'access'    => 'menu-index',
                ),
                array(
                    'title'     => '菜单列表',
                    'link'      => '/sequence/menuList',
                    'icon'      => 'icon-indent-right',
                    'access'    => 'menu-list',
                ),
            ),
        ),


        array(
            'title'     => '营销工具',
            'link'      => '#',
            'name'      => 'market',
            'linknew'   => '/Marketingplugins/pluginsList',
            'icon'      => 'fa-suitcase',
            'access'    => 'three-cfg',
            'hidden'    => true,   //存在此属性并为true在侧边栏中隐藏submenu
            'submenu'   => array(
                array(
                    'title'     => '活动优惠券',
                    'link'      => '/coupon/index',
                    'icon'      => 'fa-archive',
                    'access'    => 'coupon-index',
                    'img'       => 'sequence/icon_yhj@2x.png',
                    'intro'     => '满减、满赠、新用户、指定商品优惠券',
                    'name'      => '',  
                    'type'      => 'market',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name' => 'agent_yhq',
                ),
                array(
                    'title'     => '满减包邮',
                    'link'      => '/full/index',
                    'icon'      => 'fa-archive',
                    'img'       => 'shop/icon_mj@2x.png',
                    'intro'     => '满减包邮',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'coupon-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name' => 'agent_mjby',
                ),
                array(
                    'title'     => '抽奖管理',
                    'link'      => '/meeting/lotteryList',
                    'icon'      => 'fa-gift',
                    'img'       => 'sequence/icon_cj@2x.png',
                    'intro'     => '刺激粉丝参与，提高活跃度和粘性',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'meeting-prizeList',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name' => 'agent_cj',
                ),
                array(
                    'title'     => '付费预约',
                    'link'      => '/appointment/template',
                    'icon'      => 'fa-handshake-o',
                    'img'       => 'shop/icon_ffyy@2x.png',
                    'intro'     => '全面展示服务项目，在线预约支付定金',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'appointment-template',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name' => 'agent_ffyy',
                ),
                array(
                    'title'     => '积分商城',
                    'link'      => '/community/pointCfg',
                    'icon'      => 'fa-database',
                    'img'       => 'sequence/icon_jfsc@2x.png',
                    'intro'     => '多种获得积分方式，，保证用户留存',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'community-pointGoods',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name' => 'agent_jfsc',
                ),
                array(
                    'title'     => '分销管理',
                    'link'      => '/three/index',
                    'icon'      => 'fa-sitemap',
                    'img'       => 'shop/icon_fx@2x.png',
                    'intro'     => '支持三级分销，安全便捷，获客成本低',
                    'name'      => 'wfx',  
                    'type'      => 'market',
                    'access'    => 'three-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wfx'
                ),
                array(
                    'title'     => '拼团管理',
                    'link'      => '/group/cfg',
                    'icon'      => 'fa-users',
                    'img'       => 'shop/icon_pin@2x.png',
                    'intro'     => '邀请好友一起购买，薄利多销',
                    'name'      => 'wpt',  
                    'type'      => 'market',
                    'access'    => 'group-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wpt'
                ),
                array(
                    'title'     => '砍价管理',
                    'link'      => '/bargain/index',
                    'icon'      => 'fa-gavel',
                    'img'       => 'sequence/icon_kj@2x.png',
                    'intro'     => '邀请好友帮忙砍到最低价，吸粉神器',
                    'name'      => 'wkj',  
                    'type'      => 'market',
                    'access'    => 'bargain-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'   =>'wkj'
                ),
                array(
                    'title'     => '秒杀管理',
                    'link'      => '/limit/cfg',
                    'icon'      => 'fa-hourglass-2',
                    'img'       => 'sequence/icon_miaosha@2x.png',
                    'intro'     => '限时限量秒杀，打造爆款商品',
                    'name'      => 'wms',  
                    'type'      => 'market',
                    'access'    => 'limit-cfg',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'wms'
                ),
                array(
                    'title'     => '电话本管理',
                    'link'      => '/mobile/index',
                    'icon'      => 'fa-mobile',
                    'img'       => 'sequence/icon_dhb@2x.png',
                    'intro'     => '支持入住、收录，可拨打、收藏',
                    'name'      => 'dhb',  
                    'type'      => 'market',
                    'access'    => 'mobile-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'dhb'
                ),
                array(
                    'title'     => '答题管理',
                    'link'      => '/answer/index',
                    'icon'      => 'icon-cog',
                    'img'       => 'sequence/icon_dt@2x.png',
                    'intro'     => '全民答题。疯狂互动，用户拉新',
                    'name'      => 'dt',  
                    'type'      => 'market',
                    'access'    => 'answer-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'dt'
                ),
                array(
                    'title'     => '拍卖管理',
                    'link'      => '/auction/indexCfg',
                    'icon'      => 'fa-sitemap',
                    'img'       => 'shop/icon_pm@2x.png',
                    'intro'     => '特色功能有效营销',
                    'name'      => 'pm',  
                    'type'      => 'market',
                    'access'    => 'auction-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'pm'
                ),
                array(
                    'title'     => '客服通知',
                    'link'      => '/customer/index',
                    'icon'      => 'fa-comment-o',
                    'img'       => 'shop/icon_kftz@2x.png',
                    'intro'     => '客服通知',
                    'name'      => '',  
                    'type'      => 'info',
                    'access'    => 'customer-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'kf'
                ),
                array(
                    'title'     => '用户验证',
                    'link'      => '/mobileapply/index',
                    'icon'      => 'fa-user-o',
                    'img'       => 'sequence/icon_yhyz@2x.png',
                    'intro'     => '获取用户信息，设置查看权限',
                    'name'      => 'yhyz',  
                    'type'      => 'info',
                    'access'    => 'mobileapply-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'yhyz'
                ),
                array(
                    'title'     => '商品分佣',
                    'link'      => '/goodsratio/goodsratio#',
                    'icon'      => 'fa-user-o',
                    'img'       => 'shop/icon_spfy@2x.png',
                    'intro'     => '一次性分享赚钱，订单完成佣金结算',
                    'name'      => 'dpfx',  
                    'type'      => 'market',
                    'access'    => 'goodsratio-index',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'dpfx'
                ),
                array(
                    'title'     => '自动回复',
                    'link'      => '/service/msgList#',
                    'icon'      => 'fa-user-o',
                    'img'       => 'sequence/icon_zdhf@2x.png',
                    'intro'     => '客服咨询，关键字自动回复',
                    'name'      => 'autoreply',  
                    'type'      => 'market',
                    'access'    => 'setting-ele',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'autoreply'
                ),
                array(
                    'title'     => '组队红包',
                    'link'      => '/redbag/activityList',
                    'icon'      => 'icon-tags',
                    'img'       => 'sequence/icon_sc@2x.png',
                    'intro'     => '用户收藏、提升用户粘性月使用率',
                    'name'      => 'zdhb',  
                    'type'      => 'market',
                    'access'    => 'team-redbag',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'zdhb'
                ),
                array(
                    'title'     => '收藏有礼',
                    'link'      => '/collectionprize/index',
                    'icon'      => 'icon-tags',
                    'img'       => 'sequence/icon_sc@2x.png',
                    'intro'     => '满减、满赠、新用户、指定商品优惠券',
                    'name'      => 'scyl',  
                    'type'      => 'market',
                    'access'    => 'collection-prize',
                    'commonTools' => true,   //常用工具模块
                    'plugin_name'=>'scyl'
                ),
                array(
                    'title'     => '新年祝福',
                    'link'      => '/plugin/blessingSet',
                    'icon'      => 'fa-gift',
                    'img'       => 'sequence/icon_snzf@2x.png',
                    'intro'     => '节日好友祝福转发',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'plugin-blessingSet',
                    'plugin_name' => 'agent_xnzf',
                ),
                array(
                    'title'     => '跑腿配送',
                    'link'      => '/plugin/otherLegworkCfg',
                    'icon'      => 'fa-user-o',
                    'img'       => 'shop/icon_ptps@2x.png',
                    'intro'     => '商城加跑腿配置，骑手接单',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'setting-otherlegwork',
                    'plugin_name' => 'agent_ptps',
                ),
                array(
                    'title'     => '礼品卡',
                    'link'      => '/giftcard/index',
                    'icon'      => 'icon-tags',
                    'img'       => 'shop/icon_lpk@2x.png',
                    'intro'     => '可自己使用或转赠他人',
                    'name'      => '',  
                    'type'      => 'market',
                    'access'    => 'gift-card',
                    'plugin_name' => 'agent_lpk',
                ),
                array(
                    'title'     => '卡密充值',
                    'link'      => '/Cardpwd/index',
                    'icon'      => 'icon-tags',
                    'img'       => 'sequence/icon_km@2x.png',
                    'intro'     => '一键生成充值账号，多渠道分发',
                    'name'      => 'kmcz',  
                    'type'      => 'market',
                    'access'    => 'plugin-cardpwd',
                    'plugin_name' => 'agent_kmcz',
                ),
                // array(
                //     'title'     => '刷脸支付',
                //     'link'      => '/cashier/record',
                //     'icon'      => 'icon-money',
                //     'img'       => 'sequence/icon_slzf@2x.png',
                //     'intro'     => '小程序+刷脸支付',
                //     'name'      => 'cashier',  
                //     'type'      => 'market',
                //     'access'    => 'plugin-cashier',
                //     'plugin_name'=>'cashier'
                // ),
                array(
                    'title'     => '弹窗',
                    'link'      => '/popup/popupList',
                    'img'       => 'shop/icon_tc@2x.png',
                    'intro'     => '小程序弹窗管理',
                    'name'      => '',  
                    'type'      => 'common',
                ),
                array(
                    'title'     => '启动图',
                    'link'      => '/popup/startimglist',
                    'img'       => 'shop/icon_qdt@2x.png',
                    'intro'     => '小程序首页启动图管理',
                    'name'      => '',  
                    'type'      => 'common',
                ),
                array(
                    'title'     => '自定义表单',
                    'link'      => '/form/formData',
                    'img'       => 'shop/icon_zdylb@2x.png',
                    'intro'     => '自定义表单设置',
                    'name'      => '',  
                    'type'      => 'info',
                ),
                array(
                    'title'     => '微信步数',
                    'link'      => '/step/cfg',
                    'icon'      => 'fa-wechat',
                    'img'       => 'sequence/icon_step@2x.png',
                    'intro'     => '微信步数兑换积分',
                    'name'      => 'step',
                    'type'      => 'market',
                    'access'    => 'step-cfg',
                    'plugin_name'=>'step'
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
        'dhb' => array(
            'name' => '电话本',
            'price' => 300,
        ),
       // 'dt' => array(
       //     'name' => '答题',
       //     'price' => 600,
       // ),
        'pm' => array(
            'name' => '拍卖',
            'price' => 400,
            'noPack' => true,
        ),
       // 'kf' => array(
       //     'name' => '客服通知',
       //     'price' => 600,
       // ),
       // 'yhyz' => array(
       //     'name' => '实名验证',
       //     'price' => 600,
       //     'noPack' => true,
       // ),
        'dpfx' => array(
            'name' => '商品分佣',
            'price' => 600,
            'noPack' => true,
        ),
        'mbfz' => array(
            'name' => '自定义模板分组',
            'price' => 300,
            'noPack' => true,
        ),
        /*'anubis' => array(
            'name' => '蜂鸟配送',
            'price' => 400,
            'noPack' => true,
        ),*/
       // 'autoreply' => array(
       //     'name' => '自动回复',
       //     'price' => 600,
       //     'noPack' => true,
       // ),
        'zdhb' => array(
            'name' => '组队红包',
            'price' => 400,
        ),
       // 'scyl' => array(
       //     'name' => '收藏有礼',
       //     'price' => 600,
       //     'noPack' => true,
       // ),
       
       // 卡密充值插件
       'kmcz'=>[
            'name' => '卡密充值',
            'price' => 0,
       ],
        'cashier' => array(
            'name' => '收银台',
            'price' => 0,
            'noPack' => true,
        ),
        // 卡密充值插件
        'step'=>[
            'name' => '微信步数',
            'price' => 0,
        ],
    ),

    'menu_power' => array(
        'step-cfg',
        'plugin-cashier',
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
        'setup-aliapp',                 //支付宝小程序
         'currency-cfg',
        'currency-payStyle',             //支付配置
        'currency-conductVideo',         //VR音视频管理
        'currency-sharecfg',            // 分享设置
        'currency-kefucfg',
        'currency-wxcard',             // 微信卡券
        'module-cfg',
       'currency-cashier',            // 收银台
        'currency-informationList',    //资讯管理
        'currency-appointmentList',    //留言管理
        'membercard-index',            // 门店列表
        /*'appointment-template',
        'appointment-goods',
        'appointment-tradeList',*/
        'city-ad',
        'member-cfg',                     //会员卡管理
        'member-rechargeChange',          // 会员储值卡
        'membercard-card',               // 会员计次卡
        'membercard-discountCard',
        'mall-cfg1',
        'mall-mallTemplate',
        //'mall-shopSetup',
        'mall-shopNotice',
        'member-mallCenterManage',
        'mall-sendMethod',
        'goods-cfg',
        'goods-goodsCategory',
        'goods-index',
        'goods-group',
//        'delivery-index',
//        'delivery-sendCfg',
        'goods-messageList',
        'order-commentList',
        'member-cfg',
        'member-list',
        'member-level',
        'order-list',
        'order-tradeCfg',
        'order-tradeList',
        'order-refundList',

        'plugin-cfg',                     // 插件管理
        'plugin-settingSms',             // 短信设置
        'currency-video',                // VR音视频管理
        'mall-sendMethod',
        'three-cfg',
        'three-index',
        'group-index',
        'bargain-index',
        'community-pointGoods',
        'meeting-prizeList',
        'appointment-template',
        'limit-cfg',
        'coupon-index',
        'mobile-index',
        'answer-index',
        'auction-index',
        'customer-index',
        'mobileapply-index',
        'goodsratio-index',
        'popup-list',
        'startimg-list',
        'setting-ele',
        'team-redbag',
        'helpcenter-list',
        'plugin-blessingSet',
        'collection-prize',
        'setting-otherlegwork',
        'gift-card',
        'menu-index',
        'menu-list',
        'statistics-data',
        'statistics-goods-trans',
        'statistics-goods-rank',
        'statistics-memberIncrease',
        'statistics-memberCost',
        'statistics-sale',
        'statistics-saleAnalysis'
    ),
);
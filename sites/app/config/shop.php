<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/3
 * Time: 上午10:32
 */
return array(
    //行业模块
    'category'  => array(
        8   => array(
            'menu'  => array(
                array(
                    'title'     => '店铺管理',
                    'link'      => '#',
                    'icon'      => 'icon-home',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺信息',
                            'link'      => '/shop/basic',
                            'icon'      => 'icon-bar-chart',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '店铺设置',
                            'link'      => '/shop/setting',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '店铺公告',
                            'link'      => '/shop/notice',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '门店管理',
                            'link'      => '/shop/offlineStoreList',
                            'icon'      => 'icon-cog',
                            'toutiaoHide' => 1,
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '配送配置',
                            'link'      => '/delivery/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '云打印机',
                            'link'      => '/print/feieList',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '收银台',
                            'link'      => '/shop/cashier',
                            'icon'      => 'icon-cashier',
                            'toutiaoHide' => 1,
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '银行卡管理',
                            'link'      => '/bank/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现记录',
                            'link'      => '/withdraw/withdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '商品管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '商品分类',
                            'link'      => '/goods/goodsCategory',
                            'icon'      => 'icon-tags',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商品列表',
                            'link'      => '/goods/index',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商品评价',
                            'link'      => '/order/commentList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '留言模板',
                            'link'      => '/goods/messageList',
                            'icon'      => 'fa-calculator',
                            'access'    => 'goods-messageList',
                        ),
                    ),
                ),
                array(
                    'title'     => '订单管理',
                    'link'      => '#',
                    'icon'      => 'icon-calendar',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺订单',
                            'link'      => '/order/tradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '会员管理',
                    'link'      => '#',
                    'icon'      => 'icon-calendar',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '会员列表',
                            'link'      => '/member/list',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '营销工具',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => 'tool-cfg',
                    'submenu'   => array(
                        array(
                            'title'     => '优惠券',
                            'link'      => '/coupon/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'coupon-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '秒杀管理',
                            'link'      => '/limit/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'limit-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '满减满包邮',
                            'link'      => '/full/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'full-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '拼团管理',
                            'link'      => '/group/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'group-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '砍价管理',
                            'link'      => '/bargain/list',
                            'icon'      => 'fa-archive',
                            'access'    => 'bargain-list',
                            'commonTools' => true,   //常用工具模块
                        ),
                        /*array(
                            'title'     => '蜂鸟配送',
                            'link'      => '/plugin/settingEle',
                            'icon'      => 'fa-archive',
                            'access'    => 'coupon-index',
                            'commonTools' => true,   //常用工具模块
                        ),*/
                        array(
                            'title'     => '跑腿配送',
                            'link'      => '/legwork/otherLegworkCfg',
                            'icon'      => 'fa-archive',
                            'access'    => 'other-legwork',
                            'toutiaoHide' => 1,
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '排号',
                            'link'      => '/queue/queueTableList',
                            'icon'      => 'fa-user-o',
                            'access'    => 'queue-table-list',
                            'toutiaoHide' => 1,
                            'commonTools' => true,   //常用工具模块
                        ),
                    ),
                ),
                array(
                    'title'     => '客服会话',
                    'link'      => '/dialog/memberList',
                    'icon'      => 'icon-comments',
                    'access'    => 'dialog-memberList',
                    'toutiaoOnly' => 1,
                ),
            ),
            //付费插件 若总平台未购买 入驻商家后台将不做展示
            'plugin' => array(
                'mfyy' => array(
                    'title'     => '预约管理',
                    'link'      => '#',
                    'icon'      => 'icon-check',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '预约配置',
                            'link'      => '/free/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '预约订单',
                            'link'      => '/free/freeTradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
            ),
        ),
        // 连云港房产使用，其他使用上面16
        51   => array(
            'menu'  => array(
                array(
                    'title'     => '房产管理',
                    'link'      => '#',
                    'icon'      => 'icon-home',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '房源管理',
                            'link'      => '/house/resource',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '房源举报管理',
                            'link'      => '/house/report',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '楼盘管理',
                            'link'      => '/house/property',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '求租求购',
                            'link'      => '/house/applyList',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '房产专家',
                            'link'      => '/house/experts',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商家入驻',
                            'link'      => '/house/enter',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '合作商管理',
                            'link'      => '/house/partner',
                            'icon'      => 'icon-home',
                            'access'    => array(),
                        ),
                    ),
                ),
            ),
        ),
        //餐饮门店使用
        4    => array(
            'menu'  => array(
                array(
            'title'     => '店铺管理',
            'link'      => '#',
            'icon'      => 'icon-home',
            'access'    => array(),
            'commonTools' => true,   //常用工具模块
            'submenu'   => array(
//                array(
//                    'title'     => '店铺信息',
//                    'link'      => '/shop/basic',
//                    'icon'      => 'icon-bar-chart',
//                    'access'    => array(),
//                ),
                array(
                    'title'     => '店铺主页',
                    'link'      => '/meal/indexTpl',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '店铺设置',
                    'link'      => '/shop/setting',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '收益信息',
                    'link'      => '/shop/basic',
                    'icon'      => 'icon-bar-chart',
                    'access'    => array(),
                ),
                array(
                    'title'     => '提现管理',
                    'link'      => '/withdraw/withdraw',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '店铺活动',
                    'link'      => '/meal/activity',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
//                array(
//                    'title'     => '店铺设置',
//                    'link'      => '/mall/shopSetup',
//                    'icon'      => 'icon-cog',
//                    'access'    => array(),
//                ),
                array(
                    'title'     => '餐桌/包间设置',
                    'link'      => '/meal/mealTableList',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '门店管理',
                    'link'      => '/shop/offlineStoreList',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '预订管理',
                    'link'      => '/meal/appointmentList',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '云打印机',
                    'link'      => '/print/feieList',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '收银台',
                    'link'      => '/shop/cashier',
                    'icon'      => 'icon-cashier',
                    'access'    => array(),
                ),
            ),
        ),
                array(
                    'title'     => '商品管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'commonTools' => true,   //常用工具模块
                    'submenu'   => array(
                        array(
                            'title'     => '商品管理',
                            'link'      => '/goods/mealGoods',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                ),
        ),
                array(
                    'title'     => '订单管理',
                    'link'      => '#',
                    'icon'      => 'icon-list',
                    'access'    => array(),
                    'commonTools' => true,   //常用工具模块
                    'submenu'   => array(
                        array(
                            'title'     => '订单管理',
                            'link'      => '/meal/tradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
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
                    'icon'      => 'icon-gift',
                    'access'    => 'tool-cfg',
                    'toutiaoHide' => 1,
                    'submenu'   => array(
                        /*array(
                            'title'     => '蜂鸟配送',
                            'link'      => '/plugin/settingEle',
                            'icon'      => 'fa-archive',
                            'access'    => 'coupon-index',
                            'commonTools' => true,   //常用工具模块
                        ),*/
                        array(
                            'title'     => '跑腿配送',
                            'link'      => '/legwork/otherLegworkCfg',
                            'icon'      => 'fa-archive',
                            'access'    => 'other-legwork',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '排号',
                            'link'      => '/queue/queueTableList',
                            'icon'      => 'fa-user-o',
                            'access'    => 'queue-table-list',
                            'commonTools' => true,   //常用工具模块
                        ),
                    ),
                ),
            ),
        ),
        //同城门店用
        6    => array(
            'menu'  => array(
                array(
                    'title'     => '店铺管理',
                    'link'      => '#',
                    'icon'      => 'icon-home',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺信息',
                            'link'      => '/shop/basic',
                            'icon'      => 'icon-bar-chart',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '店铺设置',
                            'link'      => '/shop/setting',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '店铺公告',
                            'link'      => '/shop/notice',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '门店管理',
                            'link'      => '/shop/offlineStoreList',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '配送配置',
                            'link'      => '/delivery/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '云打印机',
                            'link'      => '/print/feieList',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '收银台',
                            'link'      => '/shop/cashier',
                            'icon'      => 'icon-cashier',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '银行卡管理',
                            'link'      => '/bank/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现记录',
                            'link'      => '/withdraw/withdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '商品管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '商品分类',
                            'link'      => '/goods/goodsCategory',
                            'icon'      => 'icon-tags',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商品列表',
                            'link'      => '/goods/index',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商品评价',
                            'link'      => '/order/commentList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '留言模板',
                            'link'      => '/goods/messageList',
                            'icon'      => 'fa-calculator',
                            'access'    => 'goods-messageList',
                        ),
                    ),
                ),
                array(
                    'title'     => '订单管理',
                    'link'      => '#',
                    'icon'      => 'icon-calendar',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺订单',
                            'link'      => '/order/tradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '营销工具',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => 'tool-cfg',
                    'submenu'   => array(
                        array(
                            'title'     => '优惠券',
                            'link'      => '/coupon/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'coupon-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '秒杀管理',
                            'link'      => '/limit/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'limit-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '拼团管理',
                            'link'      => '/group/index',
                            'icon'      => 'fa-archive',
                            'access'    => 'group-index',
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '砍价管理',
                            'link'      => '/bargain/list',
                            'icon'      => 'fa-archive',
                            'access'    => 'bargain-list',
                            'commonTools' => true,   //常用工具模块
                        ),
                        /*array(
                            'title'     => '蜂鸟配送',
                            'link'      => '/plugin/settingEle',
                            'icon'      => 'fa-archive',
                            'access'    => 'coupon-index',
                            'commonTools' => true,   //常用工具模块
                        ),*/
                        array(
                            'title'     => '跑腿配送',
                            'link'      => '/legwork/otherLegworkCfg',
                            'icon'      => 'fa-archive',
                            'access'    => 'other-legwork',
                            'toutiaoHide' => 1,
                            'commonTools' => true,   //常用工具模块
                        ),
                        array(
                            'title'     => '排号',
                            'link'      => '/queue/queueTableList',
                            'icon'      => 'fa-user-o',
                            'access'    => 'queue-table-list',
                            'toutiaoHide' => 1,
                            'commonTools' => true,   //常用工具模块
                        ),
                    ),
                ),
            ),
            //付费插件 若总平台未购买 入驻商家后台将不做展示
            'plugin' => array(
                'mfyy' => array(
                    'title'     => '预约管理',
                    'link'      => '#',
                    'icon'      => 'icon-check',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '预约配置',
                            'link'      => '/free/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),

                        array(
                            'title'     => '预约订单',
                            'link'      => '/free/freeTradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
            ),
        ),
        //酒店门店用
        7    => array(
            'menu'  => array(
                array(
                    'title'     => '店铺管理',
                    'link'      => '#',
                    'icon'      => 'icon-home',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺信息',
                            'link'      => '/shop/basicHotel',
                            'icon'      => 'icon-bar-chart',
                            'access'    => array(),
                        ),
//                        array(
//                            'title'     => '店铺设置',
//                            'link'      => '/shop/setting',
//                            'icon'      => 'icon-cog',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '店铺公告',
//                            'link'      => '/shop/notice',
//                            'icon'      => 'icon-cog',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '门店管理',
//                            'link'      => '/shop/storeList',
//                            'icon'      => 'icon-cog',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '配送配置',
//                            'link'      => '/delivery/index',
//                            'icon'      => 'icon-cog',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '云打印机',
//                            'link'      => '/print/feieList',
//                            'icon'      => 'icon-cog',
//                            'access'    => array(),
//                        ),
                    ),
                ),
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
//                        array(
//                            'title'     => '收银台',
//                            'link'      => '/shop/cashier',
//                            'icon'      => 'icon-cashier',
//                            'access'    => array(),
//                        ),
                        array(
                            'title'     => '银行卡管理',
                            'link'      => '/bank/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现记录',
                            'link'      => '/withdraw/withdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
//                array(
//                    'title'     => '商品管理',
//                    'link'      => '#',
//                    'icon'      => 'icon-gift',
//                    'access'    => array(),
//                    'submenu'   => array(
//                        array(
//                            'title'     => '商品分类',
//                            'link'      => '/goods/goodsCategory',
//                            'icon'      => 'icon-tags',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '商品列表',
//                            'link'      => '/goods/index',
//                            'icon'      => 'icon-th-large',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '商品评价',
//                            'link'      => '/order/commentList',
//                            'icon'      => 'icon-th-large',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '留言模板',
//                            'link'      => '/goods/messageList',
//                            'icon'      => 'fa-calculator',
//                            'access'    => 'goods-messageList',
//                        ),
//                    ),
//                ),
                array(
                    'title'     => '订单管理',
                    'link'      => '#',
                    'icon'      => 'icon-calendar',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺订单',
                            'link'      => '/hotel/tradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '房间管理',
                            'link'      => '/hotel/goods',
                            'icon'      => 'icon-cog',
                            'access'    => 'hotel-goods',
                        ),
                    ),
                ),
            ),
        ),
        //门店用
        33    => array(
            'menu'  => array(
                array(
                    'title'     => '店铺管理',
                    'link'      => '#',
                    'icon'      => 'icon-home',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺信息',
                            'link'      => '/shop/basic',
                            'icon'      => 'icon-bar-chart',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '店铺设置',
                            'link'      => '/shop/carSetting',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '配送配置',
                            'link'      => '/delivery/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '云打印机',
                            'link'      => '/print/feieList',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
//                        array(
//                            'title'     => '收银台',
//                            'link'      => '/shop/cashier',
//                            'icon'      => 'icon-cashier',
//                            'access'    => array(),
//                        ),
                        array(
                            'title'     => '银行卡管理',
                            'link'      => '/bank/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现记录',
                            'link'      => '/withdraw/withdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '商品管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '商品分类',
                            'link'      => '/goods/goodsCategory',
                            'icon'      => 'icon-tags',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商品列表',
                            'link'      => '/goods/index',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '商品评价',
                            'link'      => '/order/commentList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '留言模板',
                            'link'      => '/goods/messageList',
                            'icon'      => 'fa-calculator',
                            'access'    => 'goods-messageList',
                        ),
                    ),
                ),
                array(
                    'title'     => '订单管理',
                    'link'      => '#',
                    'icon'      => 'icon-calendar',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '店铺订单',
                            'link'      => '/order/tradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
//                array(
//                    'title'     => '营销工具',
//                    'link'      => '#',
//                    'icon'      => 'icon-gift',
//                    'access'    => 'tool-cfg',
//                    'submenu'   => array(
//                        array(
//                            'title'     => '优惠券',
//                            'link'      => '/coupon/index',
//                            'icon'      => 'fa-archive',
//                            'access'    => 'coupon-index',
//                            'commonTools' => true,   //常用工具模块
//                        ),
//                    ),
//                ),
            ),
        ),
        //社区团购合伙人用
        32    => array(
            'menu'  => array(
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '收益统计',
                            'link'      => '/sequence/managerDeductRecord',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现管理',
                            'link'      => '/sequence/managerWithdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '团长管理',
                    'link'      => '#',
                    'icon'      => 'icon-group',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '团长管理',
                            'link'      => '/sequence/leaderList',
                            'icon'      => 'icon-user-md',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '合伙人管理',
                    'link'      => '#',
                    'icon'      => 'icon-sitemap',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '合伙人管理',
                            'link'      => '/sequence/managerList',
                            'icon'      => 'icon-sitemap',
                            'access'    => array(),
                        ),
                    ),
                ),
//                array(
//                    'title'     => '商品管理',
//                    'link'      => '#',
//                    'icon'      => 'icon-gift',
//                    'access'    => array(),
//                    'submenu'   => array(
//                        array(
//                            'title'     => '商品分类',
//                            'link'      => '/goods/goodsCategory',
//                            'icon'      => 'icon-tags',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '商品列表',
//                            'link'      => '/goods/index',
//                            'icon'      => 'icon-th-large',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '商品评价',
//                            'link'      => '/order/commentList',
//                            'icon'      => 'icon-th-large',
//                            'access'    => array(),
//                        ),
//                        array(
//                            'title'     => '留言模板',
//                            'link'      => '/goods/messageList',
//                            'icon'      => 'fa-calculator',
//                            'access'    => 'goods-messageList',
//                        ),
//                    ),
//                ),
                array(
                    'title'     => '订单管理',
                    'link'      => '#',
                    'icon'      => 'icon-calendar',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '订单管理',
                            'link'      => '/sequence/tradeList',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
            ),
        ),

        35    => array(
            'menu'  => array(
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '收益统计',
                            'link'      => '/answerpay/managerDeductRecord',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现管理',
                            'link'      => '/answerpay/managerWithdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '提问管理',
                    'link'      => '#',
                    'icon'      => 'icon-comments',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '提问列表',
                            'link'      => '/answerpay/questionList',
                            'icon'      => 'icon-comments',
                            'access'    => array(),
                        ),
                    ),
                ),

            ),
        ),
        -1    => array(
            'menu'  => array(
                array(
                    'title'     => '财务管理',
                    'link'      => '#',
                    'icon'      => 'icon-gift',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '收益统计',
                            'link'      => '/town/index',
                            'icon'      => 'icon-cog',
                            'access'    => array(),
                        ),
                        array(
                            'title'     => '提现管理',
                            'link'      => '/town/withdraw',
                            'icon'      => 'icon-th-large',
                            'access'    => array(),
                        ),
                    ),
                ),
                array(
                    'title'     => '合伙人管理',
                    'link'      => '#',
                    'icon'      => 'icon-sitemap',
                    'access'    => array(),
                    'submenu'   => array(
                        array(
                            'title'     => '合伙人管理',
                            'link'      => '/town/townList',
                            'icon'      => 'icon-sitemap',
                            'access'    => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'menu'  => array(
        /*array(
            'title'     => '店铺管理',
            'link'      => '#',
            'icon'      => 'icon-home',
            'access'    => array(),
            'submenu'   => array(
                array(
                    'title'     => '店铺信息',
                    'link'      => '/shop/basic',
                    'icon'      => 'icon-bar-chart',
                    'access'    => array(),
                ),
                array(
                    'title'     => '店铺设置',
                    'link'      => '/shop/setting',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '店铺公告',
                    'link'      => '/shop/notice',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '门店管理',
                    'link'      => '/shop/storeList',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
            ),
        ),
        array(
            'title'     => '财务管理',
            'link'      => '#',
            'icon'      => 'icon-gift',
            'access'    => array(),
            'submenu'   => array(
                array(
                    'title'     => '银行卡管理',
                    'link'      => '/bank/index',
                    'icon'      => 'icon-cog',
                    'access'    => array(),
                ),
                array(
                    'title'     => '提现记录',
                    'link'      => '/withdraw/withdraw',
                    'icon'      => 'icon-th-large',
                    'access'    => array(),
                ),
            ),
        ),
        array(
            'title'     => '商品管理',
            'link'      => '#',
            'icon'      => 'icon-gift',
            'access'    => array(),
            'submenu'   => array(
                array(
                    'title'     => '商品分类',
                    'link'      => '/goods/goodsCategory',
                    'icon'      => 'icon-tags',
                    'access'    => array(),
                ),
                array(
                    'title'     => '商品列表',
                    'link'      => '/goods/index',
                    'icon'      => 'icon-th-large',
                    'access'    => array(),
                ),
                array(
                    'title'     => '商品评价',
                    'link'      => '/order/commentList',
                    'icon'      => 'icon-th-large',
                    'access'    => array(),
                ),
            ),
        ),
        array(
            'title'     => '订单管理',
            'link'      => '#',
            'icon'      => 'icon-calendar',
            'access'    => array(),
            'submenu'   => array(
                array(
                    'title'     => '店铺订单',
                    'link'      => '/order/tradeList',
                    'icon'      => 'icon-th-large',
                    'access'    => array(),
                ),
            ),
        ),*/
    ),



);
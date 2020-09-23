<?php
return array(
    // ************************用户相关****************************************
    'api'   => array(
        
        // 首页幻灯列表
        
        // 首页店铺快捷导航列表
        
        
        
        //广酒月饼核销优惠券
        
    ),
    // ************************商家相关***************************************
    'client'    => array(
        //***********************图片上传（uploadImg）***********************
        
        
        
        
        
        
        
        
        //***********************登陆、注册、找回密码（user）*****************************
        
        
        
        
        
        
        
        
        //***************************管理员（manager）***********************************
        
        
        //***************************创建或者选择店铺（Guide）*****************************
        
        
        
        
        
        
        
        //***************************店铺（shop）*****************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************银行卡（bank）***************************
        
        
        
        
        
        //*************************订单（order）****************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************会员（member）*****************************
        
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //*************************提现（withdraw）**************************
        
        
        
        
        
        
        
        
        
        
        //*************************幻灯（slide）******************************
        
        //*************************营销插件（plugin）***************************
        
        //************************通知公告（article）****************************
        
        
        
        //************************小程序（wxchat）************************************
        
        
        
        
        
        //************************小程序-审核管理（wxchat）************************************
        
        
        //**********************同城版功能(city)****************************//
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //**********************多店版功能(community)**********************//
        
        
        
        
        
        
        
        
        
        
        
        //**********************商品审核管理(goods)****************************//
        
        
        
        
        
        //**********************商品管理(goods)****************************//
        
        
        
        
        
        
        //======================收银台(cashier)==========================//
        
        
        
        
        //============================商品评价(comment)=========================//
        
        
        
        //==========================预约管理(appointment)=========================//
        
        
        

        
        
        
        //**************************社区团购相关****************************//
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        /************************会员卡相关*************************************/
        
        
        /************************餐饮相关*************************************/
        
        
        
        
        
        
        //***********************砍价*****************************
        
        
        
        
        //***********************秒杀*****************************
        
        
        
        
        
        //***********************拼团*****************************
        
        
    ),

    /*******************************微信小程序接口相关********************************/
    'applet'    => array(
        'applet_update_member_info'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'updateMemberInfoAction',
            'desc'              => '修改会员信息'
        ),
        'applet_img_upload'     => array(
            'controller'        => 'App_Controller_Applet_IndexController',
            'action'            => 'uploadImgAction',
            'desc'              => '单张图片上传'
        ),

        'applet_member_info'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'userInfoAction',
            'desc'              => '验证获取用户信息'
        ),
        'applet_zf_index'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'indexAction',
            'desc'              => '首页接口'
        ),
        'applet_zf_aboutus'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'aboutusAction',
            'desc'              => '关于我们接口'
        ),
        'applet_zf_service_list'     => array(
            'controller'        => 'App_Controller_Applet_ServiceController',
            'action'            => 'serviceListAction',
            'desc'              => '企业服务列表接口'
        ),
        'applet_zf_service_detail'     => array(
            'controller'        => 'App_Controller_Applet_ServiceController',
            'action'            => 'serviceDetailAction',
            'desc'              => '企业服务详情接口'
        ),
        'applet_zf_collet'     => array(
            'controller'        => 'App_Controller_Applet_ServiceController',
            'action'            => 'colletAction',
            'desc'              => '收藏接口'
        ),
        'applet_zf_my_collet'     => array(
            'controller'        => 'App_Controller_Applet_ServiceController',
            'action'            => 'myColletAction',
            'desc'              => '我的收藏接口'
        ),
        'applet_information_category'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'informationCategoryAction',
            'desc'              => '资讯分类接口'
        ),
        'applet_information_list'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'informationListAction',
            'desc'              => '通用资讯列表接口'
        ),
        'applet_information_details'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'informationDetailsAction',
            'desc'              => '通用资讯详情接口'
        ),
        'applet_get_area'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'getareaAction',
            'desc'              => '获取省市区'
        ),
        'applet_get_park'      => array(
            'controller'        => 'App_Controller_Applet_ParkController',
            'action'            => 'getparkAction',
            'desc'              => '获取园区'
        ),
        'applet_house_list'      => array(
            'controller'        => 'App_Controller_Applet_ParkController',
            'action'            => 'houseListAction',
            'desc'              => '办公室/工位列表'
        ),
        'applet_house_details'      => array(
            'controller'        => 'App_Controller_Applet_ParkController',
            'action'            => 'houseDetailsAction',
            'desc'              => '办公室/工位详情'
        ),

        'applet_my_center'      => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'meAction',
            'desc'              => '个人中心接口'
        ),
        'applet_my_data'      => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'meDataAction',
            'desc'              => '我的资料接口'
        ),
        'applet_save_my_data'      => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'saveDataAction',
            'desc'              => '保存我的资料接口'
        ),
        'applet_create_service_trade'      => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'createServiceTradeAction',
            'desc'              => '创建预约订单'
        ),
        'applet_confirm_service_trade'      => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'confirmServiceTradeAction',
            'desc'              => '确认预约订单'
        ),
        'applet_pay_service_trade'      => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'TradePayAction',
            'desc'              => '订单支付'
        ),
        'applet_create_form_trade'      => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'createFormTradeAction',
            'desc'              => '创建表单订单'
        ),

        'applet_service_trade_list'      => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'ServiceTradeListAction',
            'desc'              => '预约订单列表'
        ),
        'applet_service_trade_detail'      => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'ServiceTradeDetailAction',
            'desc'              => '预约订单列表'
        ),

        'applet_zf_vip_detail'     => array(
            'controller'        => 'App_Controller_Applet_ServiceController',
            'action'            => 'vipDetailAction',
            'desc'              => 'VIP详情接口'
        ),







        //**********************单品分享分销*************************//
        'applet_deduct_goods_list'     => array(
            'controller'        => 'App_Controller_Applet_GoodsratioController',
            'action'            => 'goodsListAction',
            'desc'              => '单品分享分销商品'
        ),
        'applet_deduct_goods_profit'     => array(
            'controller'        => 'App_Controller_Applet_GoodsratioController',
            'action'            => 'shareProfitListAction',
            'desc'              => '单品分享分销收益'
        ),
        'applet_member_card_details' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'memberCardDetailsAction',
            'desc'              => '门店会员卡详情'
        ),
           'applet_merchant_bargain'     => array(
            'controller'        => 'App_Controller_Applet_MerchantUserController',
            'action'            => 'bargainDetailAction',
            'desc'              => '砍价活动详情'
        ),
        'applet_custom_bargain_data'   => array(
            'controller'        => 'App_Controller_Applet_CustomtplBaseController',
            'action'            => 'getBargainDataAction',
            'desc'              => '自定义首页砍价列表'
        ),
         'applet_custom_group_data'   => array(
            'controller'        => 'App_Controller_Applet_CustomtplBaseController',
            'action'            => 'getGroupDataAction',
            'desc'              => '自定义首页拼团列表'
        ),
       'applet_redbag_receive_record'      => array(
            'controller'        => 'App_Controller_Applet_RedbagController',
            'action'            => 'receiveRecordAction',
            'desc'              => '红包领取记录'
        ),
       'applet_redbag_group_list'      => array(
            'controller'        => 'App_Controller_Applet_RedbagController',
            'action'            => 'groupListAction',
            'desc'              => '参与组队列表'
        ),
         'applet_redbag_receive'      => array(
            'controller'        => 'App_Controller_Applet_RedbagController',
            'action'            => 'receiveAction',
            'desc'              => '领取红包'
        ),
         'applet_redbag_join_group'      => array(
            'controller'        => 'App_Controller_Applet_RedbagController',
            'action'            => 'joinGroupAction',
            'desc'              => '参加组队'
        ),
            'applet_three_subordinate_back_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'subordinateBackNewAction',
            'desc'              => '获取用户下级的所有返佣记录'
        ),
       'applet_error_log'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'appletErrorLogAction',
            'desc'              => '小程序错误日志收集'
        ),
         'applet_help_center_list'      => array(
            'controller'        => 'App_Controller_Applet_HelpController',
            'action'            => 'helpCenterListAction',
            'desc'              => '帮助中心列表'
        ),
        'applet_help_center_detail'      => array(
            'controller'        => 'App_Controller_Applet_HelpController',
            'action'            => 'helpCenterDetailAction',
            'desc'              => '帮助中心详情'
        ),
              //*************************订阅消息相关**************************************
        'applet_subscribe_get_ids'     => array(
            'controller'        => 'App_Controller_Applet_SubscribeController',
            'action'            => 'getTplIdsAction',
            'desc'              => '获得操作授权的订阅消息模板'
        ),
        'applet_subscribe_get_ids_all'     => array(
            'controller'        => 'App_Controller_Applet_SubscribeController',
            'action'            => 'getTplIdsAllAction',
            'desc'              => '获得所有操作订阅消息模板'
        ),
        'applet_subscribe_save_auth'     => array(
            'controller'        => 'App_Controller_Applet_SubscribeAuthController',
            'action'            => 'saveAuthNewAction',
            'desc'              => '保存订阅消息授权'
        ),
        'applet_subscribe_tpl_list'     => array(
            'controller'        => 'App_Controller_Applet_SubscribeController',
            'action'            => 'getTplPushListAction',
            'desc'              => '获得订阅消息列表'
        ),
      'applet_mall_limit_index'=> array(
            'controller'        => 'App_Controller_Applet_LimitController',
            'action'            => 'indexAction',
            'desc'              => '秒杀活动首页'
        ),
        'applet_custom_seckill_data'   => array(
            'controller'        => 'App_Controller_Applet_CustomtplBaseController',
            'action'            => 'getSeckillDataAction',
            'desc'              => '自定义首页秒杀列表'
        ),
          //********************微信计步兑换积分相关****************
        'applet_step_index'=>[
            'controller'        => 'App_Controller_Applet_StepController',
            'action'            => 'stepIndexAction',
            'desc'              => '计步页面'
        ],
        'applet_step_rank'=>[
            'controller'        => 'App_Controller_Applet_StepController',
            'action'            => 'stepRankAction',
            'desc'              => '计步排行榜'
        ],
        'applet_step_recharge'=>[
            'controller'        => 'App_Controller_Applet_StepController',
            'action'            => 'rechargePointAction',
            'desc'              => '计步兑换积分'
        ],
        'applet_step_get'=>[
            'controller'        => 'App_Controller_Applet_StepController',
            'action'            => 'getStepAction',
            'desc'              => '获得步数'
        ],
        //*************************首页通用接口（index）******************************
      'applet_community_exchange_card' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'exchangeCardListAction',
            'desc'              => '积分兑换会员卡页面'
        ),
        'applet_member_recharge_list'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'memberRechargeListAction',
            'desc'              => '会员积分收支明细'
        ),
       'applet_custom_goods_data'   => array(
            'controller'        => 'App_Controller_Applet_CustomtplBaseController',
            'action'            => 'getGoodsListAction',
            'desc'              => '自定义首页商品列表'
        ),
       'applet_custom_points_data'   => array(
            'controller'        => 'App_Controller_Applet_CustomtplBaseController',
            'action'            => 'getPointsDataAction',
            'desc'              => '自定义首页积分列表'
        ),
       'applet_member_card_list' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'cardListAction',
            'desc'              => '门店会员卡列表'
        ),
       'applet_mall_my_cj' => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'mycjAction',
            'desc'              => '我的抽奖列表'
        ),
      'applet_member_card_count' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'cardCountAction',
            'desc'              => '门店会员卡数量'
        ),
      'applet_find_area' => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'findareaAction',
            'desc'              => '根据父ID获取下面区域信息'
        ),
       'applet_find_street' => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'getstreetAction',
            'desc'              => '根据父ID获取下面街道信息'
        ),
      'applet_index_savearea' => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'saveareaAction',
            'desc'              => '保存地址'
        ),
        'applet_img_upload'     => array(
            'controller'        => 'App_Controller_Applet_IndexController',
            'action'            => 'uploadImgAction',
            'desc'              => '单张图片上传'
        ),
        
        
        'applet_start_page'  => array(
            'controller'        => 'App_Controller_Applet_IndexController',
            'action'            => 'startPageAction',
            'desc'              => '小程序开机启动页'
        ),
        
        'applet_index_page'  => array(
            'controller'        => 'App_Controller_Applet_IndexController',
            'action'            => 'getIndexPageAction',
            'desc'              => '小程序首页路径'
        ),
        
        
        //*************************小程序配置信息（appletCfg）***************
        
        //*************************用户信息（member）************************
//        'applet_member_info'     => array(
//            'controller'        => 'App_Controller_Applet_MemberController',
//            'action'            => 'userInfoAction',
//            'desc'              => '验证获取用户信息'
//        ),
        'applet_member_center_cfg'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'memberCenterAction',
            'desc'              => '会员中心配置'
        ),

        'applet_bind_member_mobile'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'savePhoneAction',
            'desc'              => '绑定会员手机号'
        ),
        'applet_member_recharge_cfg'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'rechargeCfgAction',
            'desc'              => '会员充值配置'
        ),
        'applet_member_recharge_pay'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'rechargePayAction',
            'desc'              => '会员充值微信下单'
        ),
        
         'applet_community_points_shop' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'pointsShopAction',
            'desc'              => '社区小程序积分商城'
        ),
        'applet_community_points_goods' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'pointsGoodsAction',
            'desc'              => '社区小程序积分商品'
        ),
        
        'applet_member_point_list'     => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'pointDetailsListAction',
            'desc'              => '会员积分收支明细'
        ),
        
        'applet_community_orderFinish_detail' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'orderFinishDetailAction',
            'desc'              => '订单支付成功之后显示是否开启抽奖答题等'
        ),
        
        
        
        
        
        //*************************商铺首页（shop）**********************************
        
        'applet_index_info'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'indexAction',
            'desc'              => '商铺首页'
        ),
        'applet_goods_list'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'goodsListAction',
            'desc'              => '商品列表'
        ),
        'applet_goods_detail'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'goodsDetailAction',
            'desc'              => '商品详情'
        ),
        'applet_shop_notice'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'shopNoticeAction',
            'desc'              => '店铺通知公告'
        ),
        'applet_shop_new_notice'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'newShopNoticeAction',
            'desc'              => '店铺通知公告'
        ),
        'applet_goods_category_list'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'categoryListAction',
            'desc'              => '商品分类列表'
        ),
        'applet_goods_clothes_room'     => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'clothesNowAction',
            'desc'              => '是否开启试衣间功能'
        ),
        'applet_goods_details_poster' => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'goodsDetailsPosterAction',
            'desc'              => '商品详情分享海报'
        ),
        'applet_goods_share_poster' => array(
            'controller'        => 'App_Controller_Applet_ShopController',
            'action'            => 'goodsSharePosterAction',
            'desc'              => '商品分享海报'
        ),
        'applet_get_member_unionid'     => array(
            'controller'        => 'App_Controller_Applet_MemberController',
            'action'            => 'getUserUninonidAction',
            'desc'              => '获取用户unionID'
        ),
        
        //************************购物车（cart）*********************************
        'applet_add_cart'     => array(
            'controller'        => 'App_Controller_Applet_CartController',
            'action'            => 'addCartAction',
            'desc'              => '加入购物车'
        ),
        'applet_cart_list'     => array(
            'controller'        => 'App_Controller_Applet_CartController',
            'action'            => 'cartGoodsListAction',
            'desc'              => '购物车列表'
        ),

        'applet_cart_delete'     => array(
            'controller'        => 'App_Controller_Applet_CartController',
            'action'            => 'deleteCartAction',
            'desc'              => '删除购物车商品'
        ),
        'applet_cart_num'     => array(
            'controller'        => 'App_Controller_Applet_CartController',
            'action'            => 'getCartSumAction',
            'desc'              => '获得购物车数量'
        ),

        //*************************订单（order）*******************************
        'applet_order_list'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'orderListAction',
            'desc'              => '订单列表'
        ),
        'applet_order_detail'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'orderDetailsAction',
            'desc'              => '订单商品详情'
        ),
        'applet_order_create'     => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'createTradeAction',
            'desc'              => '创建订单'
        ),
        'applet_order_confirm'     => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'createAction',
            'desc'              => '确认订单'
        ),
        'applet_cancel_order'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'cancelOrderAction',
            'desc'              => '取消订单'
        ),
        'applet_order_fetch_track'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'fetchTrackAction',
            'desc'              => '查看订单物流'
        ),
        'applet_order_remind'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'remindOrderAction',
            'desc'              => '提醒发货'
        ),
        'applet_order_refund'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'applyRefundAction',
            'desc'              => '申请退款'
        ),
        'applet_order_refund_cancel'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'cancelRefundAction',
            'desc'              => '取消退款申请'
        ),
        'applet_order_confirm_accept'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'confirmAcceptAction',
            'desc'              => '确认收货'
        ),
        'applet_order_comment'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'commentAction',
            'desc'              => '订单评价'
        ),
        'applet_order_comment_save'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'saveCommentAction',
            'desc'              => '提交订单评价'
        ),
        'applet_order_pay'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'shopRechargeAppletAction',
            'desc'              => '订单支付（微信支付）'
        ),
        'applet_order_index_list' => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'getIndexTradeListAction',
            'desc'              => '首页提示订单列表'
        ),
        
        
        
        'applet_order_extended_delivery'   => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'orderExtendedDeliveryAction',
            'desc'              => '订单延长收货'
        ),
        'applet_order_refund_record'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'feedbackRecordAction',
            'desc'              => '订单维权记录'
        ),
        'applet_order_delete'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'deleteTradeAction',
            'desc'              => '删除订单'
        ),
        'applet_get_post_fee'     => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'getPoseFeeAction',
            'desc'              => '获取运费'
        ),
        'applet_goods_comment_list'     => array(
            'controller'        => 'App_Controller_Applet_GoodsController',
            'action'            => 'goodsCommentAction',
            'desc'              => '商品评价列表'
        ),
        
        'applet_get_receive_store_new'     => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'getReceiveStoreNewAction',
            'desc'              => '获得自提门店 三级联动'
        ),
        
        'applet_shop_send_price'     => array(
            'controller'        => 'App_Controller_Applet_TradeController',
            'action'            => 'getShopSendPriceAction',
            'desc'              => '根据收货地址获得店铺配送费'
        ),
        
        'applet_order_passwd_verify'     => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'verifyOrderByPasswdAction',
            'desc'              => '输入密码核销订单'
        ),
        

        
        
        
        

        //*************************收货地址管理(Address)**************************
        'applet_address_add'    => array(
            'controller'        => 'App_Controller_Applet_AddressController',
            'action'            => 'addAddressAction',
            'desc'              => '新增/编辑收货地址'
        ),
        'applet_address_delete' => array(
            'controller'        => 'App_Controller_Applet_AddressController',
            'action'            => 'deleteAddressAction',
            'desc'              => '删除收货地址'
        ),

        'applet_address_list'   => array(
            'controller'        => 'App_Controller_Applet_AddressController',
            'action'            => 'addressListAction',
            'desc'              => '收货地址列表'
        ),
        'applet_address_default'     => array(
            'controller'        => 'App_Controller_Applet_AddressController',
            'action'            => 'defaultAction',
            'desc'              => '设置默认收货地址'
        ),

        
        
        
        
        // **************************微企业相关（enterprise）***********************
        
        
//        
        
        
        
        
        
        
        
        // *********************微婚纱相关（wedding）**************************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        // *********************微驾校相关（driver）**************************************
        
        
        
        
        
        
        
        
        
        //************************currency(公共接口)****************************
        
        'applet_promotional_video'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'videoAction',
            'desc'              => '视频链接'
        ),
        'applet_submit_appointment'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'saveAppointmentAction',
            'desc'              => '提交预约信息（通用）'
        ),
        
        
        

        'applet_applet_jump_list'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'appletJumpListAction',
            'desc'              => '通用跳转小程序接口'
        ),
        
        
        
        
        'applet_information_comment'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'commentInformationAction',
            'desc'              => '通用资讯评论'
        ),
        'applet_information_collection'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyAuthController',
            'action'            => 'informationCollectionAction',
            'desc'              => '通用资讯收藏'
        ),
        'applet_comment_list'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'informationCommentListAction',
            'desc'              => '通用资讯评论列表'
        ),
        'applet_information_like'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'informationLikeAction',
            'desc'              => '通用资讯点赞'
        ),
        
        'applet_information_share_statistics'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'addShareAction',
            'desc'              => '通用资讯分享量统计'
        ),
        'applet_custom_form'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'customFormAction',
            'desc'              => '自定义表单'
        ),
        'applet_submit_form_data'      => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'submitFormAction',
            'desc'              => '提交自定义表单数据'
        ),
        /*
            *添加自定义表单获取手机验证码接口
            *zhangzc
            *2019-02-15
        */
        
        'applet_applet_support'    => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'fetchAgentSupportAction',
            'desc'              => '获取小程序技术支持相关信息'
        ),
        'applet_applet_suspension_menu'    => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'suspensionMenuAction',
            'desc'              => '获取小程序折叠菜单相关信息'
        ),
        'applet_save_form_id' => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'saveFormIdsAction',
            'desc'              => '保存用户formid'
        ),
        'applet_get_address' => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'addressByLngLatAction',
            'desc'              => '逆地址解析'
        ),
        
        'applet_kefu_cfg' => array(
            'controller'        => 'App_Controller_Applet_CustomerController',
            'action'            => 'kefuCfgAction',
            'desc'              => '通用获得微信客服配置'
        ),
        'applet_kefu_click' => array(
            'controller'        => 'App_Controller_Applet_CustomerController',
            'action'            => 'kefuClickAction',
            'desc'              => '点击客服回调'
        ),

        
        'applet_water_mark' => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'waterMarkAction',
            'desc'              => '技术支持水印'
        ),
        //--------新年祝福-----------
        'applet_blessing_cfg' => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'blessingCfgAction',
            'desc'              => '店铺祝福语配置'
        ),
        'applet_blessing_save' => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'saveBlessingAction',
            'desc'              => '发送祝福语保存'
        ),
        'applet_blessing_share' => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'blessingShareAction',
            'desc'              => '生成祝福海报'
        ),
        //---------------------用户wifi----------------------------
        
        
        
        

        // *********************information(资讯付费相关)******************************
        'applet_information_card_list' => array(
            'controller'        => 'App_Controller_Applet_InformationController',
            'action'            => 'informationCardAction',
            'desc'              => '资讯会员类型列表'
        ),
        'applet_information_pay' => array(
            'controller'        => 'App_Controller_Applet_InformationController',
            'action'            => 'payForInformationAction',
            'desc'              => '资讯付费（微信支付）'
        ),
        
        'applet_information_post_reward' => array(
            'controller'        => 'App_Controller_Applet_InformationController',
            'action'            => 'informationRewardAction',
            'desc'              => '资讯或帖子打赏'
        ),
        'applet_reward_list' => array(
            'controller'        => 'App_Controller_Applet_InformationController',
            'action'            => 'rewardRecordListAction',
            'desc'              => '资讯或帖子打赏列表'
        ),
        
        // *********************point(积分相关)******************************
        'applet_share_get_point' => array(
            'controller'        => 'App_Controller_Applet_PointController',
            'action'            => 'shareGetPointAction',
            'desc'              => '分享领取积分'
        ),
        'applet_sign_get_point' => array(
            'controller'        => 'App_Controller_Applet_PointController',
            'action'            => 'attendanceSignAction',
            'desc'              => '签到领取积分'
        ),
        //***********************card(微名片相关接口)***************************
        
        
        
        
        
        //***********************train(微培训相关接口)***************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //***********************meal(微点餐相关接口)***************************
        
        
        
        
        
        'applet_coupon_list'   => array(
            'controller'        => 'App_Controller_Applet_CouponController',
            'action'            => 'couponListAction',
            'desc'              => '代金券列表'
        ),
        
        
        'applet_coupon_receive'   => array(
            'controller'        => 'App_Controller_Applet_CouponController',
            'action'            => 'receiveAction',
            'desc'              => '代金券领取'
        ),
        'applet_my_coupon'   => array(
            'controller'        => 'App_Controller_Applet_CouponController',
            'action'            => 'myCouponAction',
            'desc'              => '我的代金券'
        ),
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //***********************meal(微蛋糕相关接口)***************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************cash(收银台所有店铺通用)********************************
        
        
        
        
        //************************appointment(预约下单所有店铺通用)********************************
        'applet_appointment_index'   =>  array(
            'controller'        => 'App_Controller_Applet_AppointmentController',
            'action'            => 'indexAction',
            'desc'              => '预约首页配置'
        ),
        'applet_appointment_good_detail'   =>  array(
            'controller'        => 'App_Controller_Applet_AppointmentController',
            'action'            => 'goodsDetailAction',
            'desc'              => '产品详情'
        ),
        'applet_appointment_good_share'   =>  array(
            'controller'        => 'App_Controller_Applet_AppointmentController',
            'action'            => 'goodsShareAction',
            'desc'              => '产品分享海报'
        ),
        'applet_appointment_good_list'   =>  array(
            'controller'        => 'App_Controller_Applet_AppointmentController',
            'action'            => 'goodsListAction',
            'desc'              => '预约产品列表'
        ),
        'applet_appointment_good_kind'   =>  array(
            'controller'        => 'App_Controller_Applet_AppointmentController',
            'action'            => 'appointmentKindAction',
            'desc'              => '预约产品分类'
        ),
        'applet_appointment_create_trade' => array(
            'controller'        => 'App_Controller_Applet_AppointmentOrderController',
            'action'            => 'createTradeAction',
            'desc'              => '预约下单'
        ),
        'applet_appointment_create_order' => array(
            'controller'        => 'App_Controller_Applet_AppointmentOrderController',
            'action'            => 'createAction',
            'desc'              => '预约提交订单'
        ),
        'applet_appointment_order_list' => array(
            'controller'        => 'App_Controller_Applet_AppointmentOrderController',
            'action'            => 'orderListAction',
            'desc'              => '预约订单列表'
        ),
        'applet_appointment_order_detail' => array(
            'controller'        => 'App_Controller_Applet_AppointmentOrderController',
            'action'            => 'orderDetailsAction',
            'desc'              => '预约订单详情'
        ),
        //新增付费预约控制
        'applet_appointment_join_count' => array(
            'controller'        => 'App_Controller_Applet_AppointmentOrderController',
            'action'            => 'getJoinCount',
            'desc'              => '获取预约报名已报名人数'
        ),
        'applet_appointment_forward' => array(
            'controller'        => 'App_Controller_Applet_AppointmentController',
            'action'            => 'setForwadAction',
            'desc'              => '付费预约转发计数'
        ),
        'applet_appointment_join_list' => array(
            'controller'        => 'App_Controller_Applet_AppointmentOrderController',
            'action'            => 'getJoinList',
            'desc'              => '获取预约报名已报名头像列表'
        ),
        //*****************************city(同城信息)***************************************
        'applet_city_index' => array(
            'controller'        => 'App_Controller_Applet_CityController',
            'action'            => 'indexAction',
            'desc'              => '微同城首页'
        ),
        
        
        'applet_city_one_second_category' => array(
            'controller'        => 'App_Controller_Applet_CityController',
            'action'            => 'fetchPostCategoryAction',
            'desc'              => '帖子一级和二级分类'
        ),
        'applet_city_post_top' => array(
            'controller'        => 'App_Controller_Applet_CityController',
            'action'            => 'postTopTimeAction',
            'desc'              => '发帖置顶时间'
        ),
        
        
        
        
        'applet_city_post_like' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'postLikeAction',
            'desc'              => '帖子点赞或取消点赞'
        ),
        'applet_city_post_collection' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'postCollectionAction',
            'desc'              => '帖子收藏或取消收藏'
        ),
        'applet_city_comment_delete' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'deletedPostCommentAction',
            'desc'              => '删除帖子评论'
        ),
        
        'applet_city_post_delete' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'deletePostAction',
            'desc'              => '删除帖子'
        ),
        
        
        

        
        
        
        
        
        
        'applet_city_post_pay' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'submitPostPayAction',
            'desc'              => '支付发帖费用及入驻费用'
        ),
        'applet_city_receive_redbag' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'receiveRedbagAction',
            'desc'              => '同城领取红包'
        ),
        'applet_city_receive_list' => array(
            'controller'        => 'App_Controller_Applet_CityController',
            'action'            => 'receiveListAction',
            'desc'              => '同城红包领取明细'
        ),
        'applet_city_share_post' => array(
            'controller'        => 'App_Controller_Applet_CityController',
            'action'            => 'addShareAction',
            'desc'              => '增加帖子分享量'
        ),
        
        
        
        
        
        
        
        
        
        
        'applet_city_tx_2_balance' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'tx2BalanceAction',
            'desc'              => '提现到余额'
        ),
        'applet_city_inout_history' => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'inoutAction',
            'desc'              => '交易明细'
        ),
        
        
        'applet_city_post_set_top'   => array(
            'controller'        => 'App_Controller_Applet_CityAuthController',
            'action'            => 'setPostTopAction',
            'desc'              => '帖子置顶'
        ),
        
        
        'applet_city_advertisement_cfg'  => array(
            'controller'        => 'App_Controller_Applet_CurrencyController',
            'action'            => 'advertisementCfgAction',
            'desc'              => '获取广告位配置'
        ),
        
        
        
        
        
        
        
        //*********************three(三级分销（老版分销使用）)****************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        //*********************three(三级分销（新版全功能商城使用）)****************************
        'applet_three_member_info_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'memberInfoAction',
            'desc'              => '获取用户信息'
        ),
        'applet_three_center_cfg_new'     => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'distribCenterAction',
            'desc'              => '分销中心配置'
        ),
        'applet_three_level_list_new'     => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'levelAction',
            'desc'              => '分级会员信息'
        ),
        'applet_three_order_list_new'     => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'orderAction',
            'desc'              => '我的分享收入'
        ),
        'applet_three_cash_back_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'cashbackAction',
            'desc'              => '我的返现收入'
        ),
        'applet_three_my_order_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'myOrderAction',
            'desc'              => '分销订单'
        ),
        'applet_three_my_refer_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'myReferAction',
            'desc'              => '我的推荐人'
        ),
        'applet_three_rank_list_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'rankAction',
            'desc'              => '销售排行榜'
        ),
        'applet_three_withdraw_cfg_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'applyWithdrawCfgAction',
            'desc'              => '申请提现配置'
        ),
        'applet_three_apply_tx_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'applyTxAction',
            'desc'              => '申请提现'
        ),
        'applet_three_tx_record_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'recordTxAction',
            'desc'              => '提现记录'
        ),
        'applet_three_save_profile_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'saveProfileAction',
            'desc'              => '修改个人资料'
        ),
        'applet_three_save_phone_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'savePhoneAction',
            'desc'              => '保存手机号'
        ),
        'applet_three_share_code_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'qrcodeAction',
            'desc'              => '生成二維碼'
        ),
        'applet_three_set_level_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'setLevelAction',
            'desc'              => '设置层级关系'
        ),
        'applet_three_reset_spread_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'resetSpreadAction',
            'desc'              => '海报销毁并重建'
        ),
        'applet_three_configure_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'threeCfgAction',
            'desc'              => '申请分销页面配置'
        ),
        'applet_three_apply_distribution_new' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'applyDistributionAction',
            'desc'              => '申请成为分销员'
        ),
        
        
        'applet_three_subordinate_back' => array(
            'controller'        => 'App_Controller_Applet_ThreeDistribController',
            'action'            => 'subordinateBackAction',
            'desc'              => '根据下级id, 获取此下级的返佣记录'
        ),
        
        
        
        //************************single(微单页)****************************
        
        
        
        
        //************************hotel(微酒店)****************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************商城限时抢购（秒杀）*********************************
        
        
        
        
        //************************商城拼团（拼团）*********************************
        
        'applet_mall_group_list' => array(
            'controller'        => 'App_Controller_Applet_GroupController',
            'action'            => 'getGroupListAction',
            'desc'              => '拼团活动列表'
        ),
        'applet_mall_group_detail' => array(
            'controller'        => 'App_Controller_Applet_GroupController',
            'action'            => 'detailAction',
            'desc'              => '拼团活动详情'
        ),
        'applet_mall_group_join' => array(
            'controller'        => 'App_Controller_Applet_GroupController',
            'action'            => 'joinAction',
            'desc'              => '拼团参与情况'
        ),
        'applet_mall_my_group' => array(
            'controller'        => 'App_Controller_Applet_OrderController',
            'action'            => 'mytuanAction',
            'desc'              => '我的拼团列表'
        ),
        
        //************************微信卡券*************************************
        
        //************************门店会员卡*************************************
        
        'applet_store_member_info' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'memberInfoAction',
            'desc'              => '门店会员详情'
        ),
        
        
        'applet_buy_member_card' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'buyRenewCardAction',
            'desc'              => '购买或续费门店会员卡'
        ),
        
        
        'applet_pay_member_card' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'payCardOrderAction',
            'desc'              => '支付购买会员卡'
        ),
        
        
        
        
        
        'applet_card_order_list' => array(
            'controller'        => 'App_Controller_Applet_MemberCardController',
            'action'            => 'orderListAction',
            'desc'              => '会员卡购买订单列表'
        ),
        //************************房产小程序接口*************************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************预约小程序接口*************************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************工单小程序接口*************************************
        
        
        
        
        
        
        
        
        
        
        //************************社区小程序接口*************************************
        
        
        
        
        'applet_community_shop_list' => array(
            'controller'        => 'App_Controller_Applet_CommunityController',
            'action'            => 'shopListAction',
            'desc'              => '社区小程序商家列表'
        ),
        'applet_community_hot_search' => array(
            'controller'        => 'App_Controller_Applet_CommunityController',
            'action'            => 'hotSearchAction',
            'desc'              => '社区小程序热门搜索'
        ),
        
        'applet_community_goods_list' => array(
            'controller'        => 'App_Controller_Applet_CommunityController',
            'action'            => 'goodsListAction',
            'desc'              => '社区小程序商品列表'
        ),
        
        
        'applet_community_goods_detail' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'goodsDetailAction',
            'desc'              => '社区小程序商品详情'
        ),
        
        'applet_community_submit_post' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'submitPostAction',
            'desc'              => '社区小程序发帖'
        ),
        'applet_community_post_comment' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'commentPostAction',
            'desc'              => '社区小程序帖子评论'
        ),
        'applet_community_post_list' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'postListAction',
            'desc'              => '社区小程序帖子列表'
        ),
        'applet_community_post_delete' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'deletePostAction',
            'desc'              => '社区小程序删除帖子'
        ),
        'applet_community_comment_delete' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'deletedPostCommentAction',
            'desc'              => '社区小程序删除帖子评论'
        ),
        'applet_community_post_detail' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'postDetailsAction',
            'desc'              => '社区小程序帖子详情'
        ),
        'applet_community_post_comment_list' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'postCommentListAction',
            'desc'              => '社区小程序帖子评论列表'
        ),
        'applet_community_collection' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'collectionAction',
            'desc'              => '社区小程序收藏'
        ),
        'applet_community_my_collection' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'myCollectionAction',
            'desc'              => '社区小程序我的收藏'
        ),
        
        
        
        
        

        
        
        
        
        
        
        'applet_community_change_list' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'changeListAction',
            'desc'              => '兑换列表'
        ),

        
        
        
        
        'applet_community_points_trade' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'pointTradeAction',
            'desc'              => '社区小程序积分商品购买'
        ),
        'applet_community_order_list' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'orderListAction',
            'desc'              => '社区小程序订单列表'
        ),
        'applet_community_order_detail' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'orderDetailsAction',
            'desc'              => '社区小程序订单详情'
        ),
        
        
        
        'applet_community_post_like' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'postLikeAction',
            'desc'              => '帖子点赞或取消点赞'
        ),
        
        
        
        
        
        
        
        
        //申请活动接口
        
        
        //新增判断拼团秒杀是否开区的接口
        
        
        'applet_community_post_category' => array(
            'controller'        => 'App_Controller_Applet_CommunityAuthController',
            'action'            => 'getPostCategoryAction',
            'desc'              => '获得全部帖子分类'
        ),
        
        
  //***********************多店免费预约***********************************
        
        
        
        
        
        
        //************************会议小程序接口*************************************
        
        
        'applet_meeting_lottery' => array(
            'controller'        => 'App_Controller_Applet_MeetingAuthController',
            'action'            => 'lotteryAction',
            'desc'              => '会议小程序抽奖页面'
        ),
        'applet_meeting_start_lottery' => array(
            'controller'        => 'App_Controller_Applet_MeetingAuthController',
            'action'            => 'startLotteryAction',
            'desc'              => '会议小程序开始抽奖'
        ),
        'applet_meeting_share_lottery' => array(
            'controller'        => 'App_Controller_Applet_MeetingAuthController',
            'action'            => 'addShareLotteryNumAction',
            'desc'              => '分享后增加抽奖次数'
        ),
        'applet_meeting_exchange_pnum' => array(
            'controller'        => 'App_Controller_Applet_MeetingAuthController',
            'action'            => 'exchangeLotteryNumAction',
            'desc'              => '积分兑换抽奖次数'
        ),
        'applet_meeting_mine_lottery' => array(
            'controller'        => 'App_Controller_Applet_MeetingAuthController',
            'action'            => 'getMyLotteryRecordAction',
            'desc'              => '获取我的中奖纪录'
        ),
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************砍价相关接口*************************************
        
        
        'applet_bargain_activity_detail' => array(
            'controller'        => 'App_Controller_Applet_BargainAuthController',
            'action'            => 'detailAction',
            'desc'              => '砍价活动详情'
        ),
        'applet_bargain_activity_join' => array(
            'controller'        => 'App_Controller_Applet_BargainAuthController',
            'action'            => 'joinAction',
            'desc'              => '参与砍价活动'
        ),
        'applet_bargain_activity_help' => array(
            'controller'        => 'App_Controller_Applet_BargainAuthController',
            'action'            => 'helpAction',
            'desc'              => '帮助砍价'
        ),
        
        'applet_bargain_share_info' => array(
            'controller'        => 'App_Controller_Applet_BargainController',
            'action'            => 'getShareInfoAction',
            'desc'              => '获取分享信息'
        ),
        
        //************************万能门店相关接口*************************************
        
        
        
        
        
        
        //************************万能企业相关接口*************************************
        
        
        
        
        //************************万能商城相关接口*************************************
        
        'applet_mall_goodList' => array(
            'controller'        => 'App_Controller_Applet_MallController',
            'action'            => 'shopCategoryAction',
            'desc'              => '万能商城商品列表'
        ),
        'applet_mall_goodsCollect' => array(
            'controller'        => 'App_Controller_Applet_MallController',
            'action'            => 'goodsCollectAction',
            'desc'              => '商品收藏'
        ),
        
        
        //***********************答题小程序*****************************************
        'applet_subject_list'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'getSubjectNewAction',
            'desc'              => '出题题目列表'
        ),
        'applet_subject_fetch_use_card'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'getOrUseSubjectCardAction',
            'desc'              => '领取或使用复活卡'
        ),
        'applet_subject_upload_answer'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'answerEndByTypeAction',
            'desc'              => '上传答题结果'
        ),
        
        'applet_subject_redpacket_list'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'redPacketListAction',
            'desc'              => '获取红包列表'
        ),
        'applet_subject_award_list'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'myAwardListAction',
            'desc'              => '我的奖品列表'
        ),
        'applet_subject_win_rank'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'winRankListAction',
            'desc'              => '获得胜场排行榜'
        ),
        'applet_subject_get_chance'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'getAnswerChanceAction',
            'desc'              => '兑换答题机会'
        ),
        'applet_subject_redpacket_cfg'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'subjectCfgAction',
            'desc'              => '答题领红包配置'
        ),
        
        
        'applet_subject_share_fetch_card'   => array(
            'controller'        => 'App_Controller_Applet_SubjectController',
            'action'            => 'ShareConfirmFetchCardAction',
            'desc'              => '分享后别人点击确认领取复活卡'
        ),
        // ******************店铺支付配置**********************************************
        'applet_pay_cfg'   => array(
            'controller'        => 'App_Controller_Applet_PayCfgController',
            'action'            => 'payCfgAction',
            'desc'              => '店铺支付配置'
        ),
        // ******************电话本相关接口**********************************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //*******************微名片插件相关***********************************************
        
        
        
        
        
        
        
        
        //*************************问答小程序相关接口***************************//
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        // ******************自定义首页配置**********************************************
        
        'applet_custom_tpl_base'   => array(
            'controller'        => 'App_Controller_Applet_CustomtplBaseController',
            'action'            => 'tplCfgAction',
            'desc'              => '自定义首页基本信息配置'
        ),
        
        
        
        
        
        
        
        
        
        
        // ******************知识付费**********************************************
        'applet_knowpay_index'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'indexAction',
            'desc'              => '首页配置'
        ),
        'applet_knowpay_recommend_goods'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'recommendGoodsAction',
            'desc'              => '推荐商品'
        ),
        'applet_knowpay_search'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'searchGoodsAction',
            'desc'              => '搜索商品'
        ),
        'applet_knowpay_category'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'categoryListAction',
            'desc'              => '分类列表'
        ),
        'applet_knowpay_goods_list'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'goodsListAction',
            'desc'              => '商品列表'
        ),
        'applet_knowpay_goods_detail'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'goodsDetailAction',
            'desc'              => '商品详情'
        ),
        'applet_knowpay_goods_knowledge'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'knowledgeAction',
            'desc'              => '商品下面的课程'
        ),
        'applet_knowpay_knowledge_detail'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'knowledgeDetailAction',
            'desc'              => '课程详情'
        ),
        'applet_knowpay_attendance'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'attendanceAction',
            'desc'              => '签到'
        ),
        'applet_knowpay_study_history'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'studyHistoryAction',
            'desc'              => '学习情况'
        ),
        'applet_knowpay_comment'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'commentKnowledgeAction',
            'desc'              => '课程评价'
        ),
        'applet_knowpay_comment_list'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'commentListAction',
            'desc'              => '课程评价列表'
        ),
        'applet_knowpay_comment_like'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'commentLikeAction',
            'desc'              => '课程评价点赞'
        ),
        'applet_knowpay_my_comment'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'myCommentAction',
            'desc'              => '我的评价'
        ),
        'applet_knowpay_activity'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'activityAction',
            'desc'              => '活动页面'
        ),
        'applet_knowpay_points_mall'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'pointsMallAction',
            'desc'              => '积分商城'
        ),
        'applet_knowpay_points_goods'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'pointsGoodsAction',
            'desc'              => '积分商品'
        ),
        'applet_knowpay_had_buy'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'hadBuyListAction',
            'desc'              => '已购列表'
        ),
        'applet_knowpay_recharge_code'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'useRechargeCodeAction',
            'desc'              => '使用兑换码'
        ),
        'applet_knowpay_recharge_cfg'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'rechargeCfgAction',
            'desc'              => '兑换码规则'
        ),
        'applet_knowpay_quotation_list'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'quotationListAction',
            'desc'              => '语录列表'
        ),
        'applet_knowpay_quotation_detail'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'quotationDetailAction',
            'desc'              => '语录详情'
        ),
        'applet_knowpay_quotation_like'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'quotationLikeAction',
            'desc'              => '语录点赞'
        ),
        'applet_knowpay_quotation_comment'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'quotationCommentAction',
            'desc'              => '评论语录'
        ),
        'applet_knowpay_quotation_comment_delete'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'deleteQuotationCommentAction',
            'desc'              => '删除评论语录'
        ),
        'applet_knowpay_quotation_comment_list'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'quotationCommentListAction',
            'desc'              => '语录评论列表'
        ),
        'applet_knowpay_teacher_detail'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'teacherDetailAction',
            'desc'              => '讲师详情'
        ),
        'applet_knowpay_vip_rights'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'vipRightsAction',
            'desc'              => '会员权益页面'
        ),
        'applet_knowpay_vip_goods'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'vipGoodsListAction',
            'desc'              => '会员折扣商品'
        ),
        
        'applet_knowpay_record_time'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'saveKnowledgeRecordTimeAction',
            'desc'              => '知识付费记录课程学习时间'
        ),
        'applet_knowpay_record_list'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayAuthController',
            'action'            => 'knowledgeRecordListAction',
            'desc'              => '知识付费课程学记录列表'
        ),
        'applet_knowpay_cfg'   => array(
            'controller'        => 'App_Controller_Applet_KnowledgepayController',
            'action'            => 'getKnowpayCfgAction',
            'desc'              => '知识付费配置'
        ),

        // ******************求职内推**********************************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //************************拍卖*********************************
        
        
        
        
        
        
        
        
        
        
        
        
        //**********************代理商*************************//
        'applet_agent_consultation_submit'     => array(
            'controller'        => 'App_Controller_Applet_AgentController',
            'action'            => 'appletConsultationAction',
            'desc'              => '提交小程序开发咨询'
        ),
        //**********************单品分享分销*************************//
        
        
        //****************************游戏盒子****************************//
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //***************************商家岛用户端小程序*************************//
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //******************************社区团购**********************************//
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        

        
        

        
        
        
        
        
        

        //****************************二手车********************************//
        
        
        
        
        
        
        
        
        
        
        
        
        // -- 客服会话
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
//        
        
        
        
        //****************************跑腿*******************************//
        
        
        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //用户投诉新增的三个接口 方法
        //zhangzc
        //2019-06-29
        
        
        
        
        
        

        //****************************组队红包*******************************//
        
        
        
        
        
        
        
        
        //****************************收藏有礼*******************************//
        'applet_collection_prize_setting'      => array(
            'controller'        => 'App_Controller_Applet_CollectionPrizeController',
            'action'            => 'settingAction',
            'desc'              => '收藏有礼配置'
        ),
        'applet_collection_prize_submit'      => array(
            'controller'        => 'App_Controller_Applet_CollectionPrizeController',
            'action'            => 'submitApplyAction',
            'desc'              => '收藏有礼提交审核'
        ),
        //************************礼品卡首页***************************
        
        
        
        
        
        
        
        
        
        
        
        

        //*************************问答小程序*************************
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        /*********************卡密充值 插件************************/
        
        
        /**
         * 新会员推荐插件
         * zhangzc
         * 2019-08-24
         */
        
    //处理收银台功能
    'cashier'  => array(
        //用户登录相关接口
        'cashier_user_login'     => array(
            'controller'        => 'App_Controller_Cashier_UserController',
            'action'            => 'loginAction',
            'desc'              => '用户登陆'
        ),
        //收款相关
        'cashier_cash_cfg'       => array(
            'controller'        => 'App_Controller_Cashier_CashController',
            'action'            => 'cfgAction',
            'desc'              => '收款模块相关配置'
        ),
        'cashier_cash_record'       => array(
            'controller'        => 'App_Controller_Cashier_CashController',
            'action'            => 'cashRecordAction',
            'desc'              => '收款记录'
        ),
        'cashier_cash_record_detail'       => array(
            'controller'        => 'App_Controller_Cashier_CashController',
            'action'            => 'recordDetailAction',
            'desc'              => '收款详情'
        ),
        'cashier_cash_face_auth'     => array(
            'controller'        => 'App_Controller_Cashier_CurrencyController',
            'action'            => 'facePayAuthAction',
            'desc'              => '获取扫码凭证'
        ),
        'cashier_cash_scan_code'     => array(
            'controller'        => 'App_Controller_Cashier_CurrencyController',
            'action'            => 'microPayAction',
            'desc'              => '扫码支付'
        ),
        'cashier_cash_search_result' => array(
            'controller'        => 'App_Controller_Cashier_CurrencyController',
            'action'            => 'checkPayResultAction',
            'desc'              => '查询扫码结果'
        ),
        'cashier_cash_record_sum'       => array(
            'controller'        => 'App_Controller_Cashier_CashController',
            'action'            => 'getSumDataAction',
            'desc'              => '统计数据'
        ),
        'cashier_cash_trade_data'       => array(
            'controller'        => 'App_Controller_Cashier_CurrencyController',
            'action'            => 'getTradeDataByTidAction',
            'desc'              => '根据订单标识获取订单数据'
        ),
        /*'cashier_cash_refund'       => array(
            'controller'        => 'App_Controller_Cashier_CurrencyController',
            'action'            => 'refundCashierOrderAction',
            'desc'              => '退款操作'
        ),*/
        'cashier_cash_refund'  => array(
            'controller'        => 'App_Controller_Cashier_CurrencyController',
            'action'            => 'refundCashierNewAction',
            'desc'              => '退款操作'
        ),
        //核销相关-会员卡
        'cashier_hexiao_crad_data'     => array(
            'controller'        => 'App_Controller_Cashier_CardController',
            'action'            => 'getMemberInfoByCardAction',
            'desc'              => '获取核销数据'
        ),
        'cashier_hexiao_verify'     => array(
            'controller'        => 'App_Controller_Cashier_CardController',
            'action'            => 'delHeXiaoAction',
            'desc'              => '核销操作'
        ),
        'cashier_hexiao_record_cfg'     => array(
            'controller'        => 'App_Controller_Cashier_CardController',
            'action'            => 'getVerifyCfgAction',
            'desc'              => '查询配置'
        ),
        'cashier_hexiao_record'     => array(
            'controller'        => 'App_Controller_Cashier_CardController',
            'action'            => 'storeVerifyListAction',
            'desc'              => '核销记录'
        ),
        'cashier_hexiao_card_record'     => array(
            'controller'        => 'App_Controller_Cashier_CardController',
            'action'            => 'getRecordByCardAction',
            'desc'              => '会员卡核销记录'
        ),
        //设置-转交功能
        'cashier_manager_handover_data'     => array(
            'controller'        => 'App_Controller_Cashier_ManagerController',
            'action'            => 'handoverNumAction',
            'desc'              => '转交统计数据'
        ),
        'cashier_manager_handover_out'     => array(
            'controller'        => 'App_Controller_Cashier_ManagerController',
            'action'            => 'handoverOutAction',
            'desc'              => '交接退出'
        ),
        /*'cashier_manager_handover_out'     => array(
            'controller'        => 'App_Controller_Cashier_UserController',
            'action'            => 'loginOutNowAction',
            'desc'              => '交接退出'
        ),*/
        'cashier_machine_check_password'     => array(
            'controller'        => 'App_Controller_Cashier_ManagerController',
            'action'            => 'checkPassAction',
            'desc'              => '验证操作密码'
        ),
        'cashier_machine_cfg'     => array(
            'controller'        => 'App_Controller_Cashier_ManagerController',
            'action'            => 'getMachineCfgAction',
            'desc'              => '获取机器配置'
        ),
        'cashier_machine_cfg_change'     => array(
            'controller'        => 'App_Controller_Cashier_ManagerController',
            'action'            => 'changeMachineCfgAction',
            'desc'              => '修改机器配置'
        ),
        'cashier_manager_print_owner'     => array(
            'controller'        => 'App_Controller_Cashier_ManagerController',
            'action'            => 'printDataAction',
            'desc'              => '手动打印功能'
        ),
        //会员模块相关
        'cashier_member_detail'     => array(
            'controller'        => 'App_Controller_Cashier_MemberAuthController',
            'action'            => 'memberInfoAction',
            'desc'              => '会员详情'
        ),
        'cashier_member_card_list'     => array(
            'controller'        => 'App_Controller_Cashier_MemberAuthController',
            'action'            => 'getMemCardAction',
            'desc'              => '获取会员计次卡'
        ),
        
        'cashier_member_list'     => array(
            'controller'        => 'App_Controller_Cashier_MemberController',
            'action'            => 'memberListAction',
            'desc'              => '会员列表'
        ),
        'cashier_member_export'     => array(
            'controller'        => 'App_Controller_Cashier_MemberController',
            'action'            => 'exportMemberAction',
            'desc'              => '会员信息导出'
        ),
        'cashier_member_integral_change'     => array(
            'controller'        => 'App_Controller_Cashier_MemberController',
            'action'            => 'memberIntegralChangeAction',
            'desc'              => '会员积分更改'
        ),
        'cashier_member_coin_change'     => array(
            'controller'        => 'App_Controller_Cashier_MemberController',
            'action'            => 'memberCoinChangeAction',
            'desc'              => '会员余额更改'
        ),
        'cashier_member_integral_list'     => array(
            'controller'        => 'App_Controller_Cashier_MemberController',
            'action'            => 'meberIntegralRecordAction',
            'desc'              => '会员积分记录列表'
        ),
         'cashier_member_coin_list'     => array(
            'controller'        => 'App_Controller_Cashier_MemberController',
            'action'            => 'memberCoinRecordAction',
            'desc'              => '会员余额记录列表'
        ),
        'cashier_member_recharge_cfg'     => array(
            'controller'        => 'App_Controller_Cashier_MemberAuthController',
            'action'            => 'rechargeCfgAction',
            'desc'              => '会员充值配置'
        ),
        'cashier_member_recharge_pay'     => array(
            'controller'        => 'App_Controller_Cashier_MemberAuthController',
            'action'            => 'rechargePayAction',
            'desc'              => '会员充值支付'
        ),
        'cashier_member_bind_mobile'     => array(
            'controller'        => 'App_Controller_Cashier_MemberAuthController',
            'action'            => 'bindMobileAction',
            'desc'              => '会员手机号绑定功能'
        ),
        //商品模块相关
        'cashier_goods_list'     => array(
            'controller'        => 'App_Controller_Cashier_GoodController',
            'action'            => 'goodListAction',
            'desc'              => '商品列表'
        ),
        'cashier_goods_detail'     => array(
            'controller'        => 'App_Controller_Cashier_GoodController',
            'action'            => 'goodDetailAction',
            'desc'              => '商品详情'
        ),
        'cashier_goods_add'     => array(
            'controller'        => 'App_Controller_Cashier_GoodController',
            'action'            => 'goodAddAction',
            'desc'              => '商品添加/编辑'
        ),
        'cashier_goods_delete'     => array(
            'controller'        => 'App_Controller_Cashier_GoodController',
            'action'            => 'deleteGoodsAction',
            'desc'              => '商品删除'
        ),
        'cashier_goods_showVip'     => array(
            'controller'        => 'App_Controller_Cashier_GoodController',
            'action'            => 'changeShowVipAction',
            'desc'              => '商品 修改商品是否显示会员价'
        ),
        'cashier_goods_category'     => array(
            'controller'        => 'App_Controller_Cashier_GoodController',
            'action'            => 'categoryListAction',
            'desc'              => '商品分类'
        ),
        //订单
        'cashier_member_by_code'  => array(
            'controller'        => 'App_Controller_Cashier_TradeController',
            'action'            => 'checkMemberByCodeAction',
            'desc'              => '根据手机号获取会员信息'
        ),
        'cashier_create_trade'     => array(
            'controller'        => 'App_Controller_Cashier_TradeController',
            'action'            => 'createTradeAction',
            'desc'              => '创建订单'
        ),
       /* 'cashier_pay_trade'     => array(
            'controller'        => 'App_Controller_Cashier_TradeController',
            'action'            => 'dealTradeNewAction',
            'desc'              => '支付订单'
        ),*/
        'cashier_pay_trade'     => array(
            'controller'        => 'App_Controller_Cashier_FaceController',
            'action'            => 'payTradeAction',
            'desc'              => '支付订单'
        ),
        'cashier_search_pay_trade'     => array(
            'controller'        => 'App_Controller_Cashier_TradeController',
            'action'            => 'searchTradeAction',
            'desc'              => '查询订单'
        ),
        'cashier_search_trade'     => array(
            'controller'        => 'App_Controller_Cashier_TradeController',
            'action'            => 'getPayAction',
            'desc'              => 'tid 查询订单'
        ),
        // 幻灯图
//        'cashier_index_slide'     => array(
//            'controller'        => 'App_Controller_Cashier_ImgController',
//            'action'            => 'startImgAction',
//            'desc'              => '幻灯图列表'
//        ),
        'cashier_index_slide'     => array(
            'controller'        => 'App_Controller_Cashier_ImgController',
            'action'            => 'slideListAction',
            'desc'              => '幻灯图列表'
        ),


        // 测试 语音播报
        'cashier_voice_test'     => array(
            'controller'        => 'App_Controller_Cashier_ImgController',
            'action'            => 'testAction',
            'desc'              => '测试语音播报'
        ),
        //授权相关接口
        'cashier_auth_start'     => array(
            'controller'        => 'App_Controller_Cashier_AuthController',
            'action'            => 'startAuthAction',
            'desc'              => '授权接口'
        ),
        'cashier_auth_unfreeze'     => array(
            'controller'        => 'App_Controller_Cashier_AuthController',
            'action'            => 'unfreezeMoneyAction',
            'desc'              => '授权解冻'
        ),



        // ******** 商家小程序 *******
        'shop_user_login'     => array(
            'controller'        => 'App_Controller_Cashier_ShopUserController',
            'action'            => 'checkLoginAction',
            'desc'              => '商家小程序 登录接口'
        ),
        'shop_user_logout'     => array(
            'controller'        => 'App_Controller_Cashier_ShopUserController',
            'action'            => 'backLoginAction',
            'desc'              => '商家小程序 退出接口'
        ),

        'shop_manager_member_info'     => array(
            'controller'        => 'App_Controller_Cashier_ShopManagerController',
            'action'            => 'memberInfoAction',
            'desc'              => '管理者及店铺信息'
        ),
        'shop_manager_machine_list'     => array(
            'controller'        => 'App_Controller_Cashier_ShopManagerController',
            'action'            => 'machineListAction',
            'desc'              => '机器列表'
        ),
        'shop_manager_cash_record_list'     => array(
            'controller'        => 'App_Controller_Cashier_ShopManagerController',
            'action'            => 'cashRecordListAction',
            'desc'              => '账单列表'
        ),
        'shop_manager_cash_record_index'     => array(
            'controller'        => 'App_Controller_Cashier_ShopManagerController',
            'action'            => 'getCashRecordCountAction',
            'desc'              => '首页统计账单'
        ),
        'shop_manager_cash_record_echart'     => array(
            'controller'        => 'App_Controller_Cashier_ShopManagerController',
            'action'            => 'getEchartDataAction',
            'desc'              => '首页统计图'
        ),



        'shop_manager_test'     => array(
            'controller'        => 'App_Controller_Cashier_ShopManagerController',
            'action'            => 'testAction',
            'desc'              => '测试接口'
        ),

    ),

    //刷脸付代理商APP相关接口
    'faceagent' => array(
        'faceagent_trade_list'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'tradeListAction',
            'desc'              => '代理商流水列表'
        ),
        'faceagent_trade_settle'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'settleInoutAction',
            'desc'              => '结算申请'
        ),
        'faceagent_trade_settle_list'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'settleRecordListAction',
            'desc'              => '结算中心'
        ),
        // 首页
        'faceagent_index'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'indexAction',
            'desc'              => '首页'
        ),

        //商户列表
        'faceagent_merchant_list'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'merchantListAction',
            'desc'              => '商户列表'
        ),

        //设备列表
        'faceagent_merchant_equip_list'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'merchantEquipAction',
            'desc'              => '商户的设备列表'
        ),
        //个人信息
        'faceagent_member_info'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'memberInfoAction',
            'desc'              => '个人信息'
        ),
        //个人信息
        'faceagent_member_login'  => array(
            'controller'        => 'App_Controller_Faceagent_UserController',
            'action'            => 'loginAction',
            'desc'              => '账号登录'
        ),
        //个人信息
        'faceagent_member_logout'  => array(
            'controller'        => 'App_Controller_Faceagent_UserController',
            'action'            => 'logoutAction',
            'desc'              => '账号退出'
        ),

        // 商店列表
        'faceagent_shop_list'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'getShopListAction',
            'desc'              => '商店列表'
        ),
        // 机器列表
        'faceagent_machine_list'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'getMachineListAction',
            'desc'              => '机器列表'
        ),
        //银行卡列表
        'faceagent_bank_list'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'myBankListAction',
            'desc'              => '银行卡列表'
        ),
        //添加银行卡
        'faceagent_bank_add'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'addBankAction',
            'desc'              => '添加银行卡'
        ),
        //保存银行卡
        'faceagent_bank_save'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'saveBankInfoAction',
            'desc'              => '保存银行卡'
        ),
        //删除银行卡
        'faceagent_bank_delete'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'deleteBankInfoAction',
            'desc'              => '删除银行卡'
        ),
        //申请提现
        'faceagent_apply_page'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'applyPageAction',
            'desc'              => '申请提现'
        ),
        //申请提现
        'faceagent_apply_save'  => array(
            'controller'        => 'App_Controller_Faceagent_IndexController',
            'action'            => 'saveApplyAction',
            'desc'              => '保存申请提现记录'
        ),
        //有效单量列表
        'faceagent_valid_list'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'getValidNumListAction',
            'desc'              => '有效单量列表'
        ),
        //代理中心
        'faceagent_agent_center'  => array(
            'controller'        => 'App_Controller_Faceagent_TradeController',
            'action'            => 'agentCenterAction',
            'desc'              => '代理中心'
        ),
    ),
 ),
);
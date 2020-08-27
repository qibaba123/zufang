<?php
/*
 * 订阅消息获得授权配置
 */

return [
    'auth' => [
        //酒店预订
        3 => [
            //点击下单提交  支付成功
            'applet_community_points_trade' => ['zfcg'],
            //点击充值  充值成功、商品推送、秒杀活动推送
            'applet_member_recharge_pay' => ['recharge'],
            //付费预约点击预约时  预约成功提醒、商品推送
            'applet_appointment_create_order' => ['appointment'],
            //点击抽奖按钮时  抽奖活动、秒杀活动推送
            'applet_meeting_start_lottery' => ['lottery'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'service'=>'产品服务推送',
                'zfcg'=>'支付成功通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
                'lottery'=>'抽奖活动',
            ]
        ],


        //预约服务
        4 => [
            //点击下单提交  支付成功、商品推送、优惠券推送
            'applet_meal_create_order' => ['zfcg','goods','coupon'],
            'applet_order_confirm' => ['zfcg','goods','coupon'],
            //点击提醒卖家发货  卖家发货、确认收货
//            'applet_order_remind' => ['mjfh','qrsh'],
//            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知、余额变更通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知 商品推送
            'applet_buy_member_card' => ['buy_member_card','goods'],
            //点击充值  充值成功、商品推送、秒杀活动推送
            'applet_member_recharge_pay' => ['recharge','goods','limit'],
            //付费预约点击预约时  预约成功提醒、商品推送
            'applet_appointment_create_order' => ['appointment','goods'],
            //点击抽奖按钮时  抽奖活动
            'applet_meeting_start_lottery' => ['lottery'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //领取优惠券  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //点击立即排号  取号成功、叫号通知
            'applet_meal_start_queue' => ['meal_start_queue','meal_call_queue'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'group'=>'拼团活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
//                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
//                'coin_change'=>'余额变更通知',
                'meal_start_queue'=>'取号成功通知',
                'meal_call_queue'=>'叫号通知',
            ]
        ],


        //同城
        6 => [
            //点击下单提交  支付成功、余额变更通知、积分变更通知
            'applet_order_confirm' => ['zfcg','coin_change','points_change'],
            //点击提醒卖家发货  卖家发货、确认收货、商品推送
            'applet_order_remind' => ['mjfh','qrsh','goods'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知、优惠券推送、商品推送
            'applet_buy_member_card' => ['buy_member_card','coupon','goods'],
            //点击充值  充值成功、商品推送
            'applet_member_recharge_pay' => ['recharge','goods'],
            //付费预约点击预约时  预约成功提醒
            'applet_appointment_create_order' => ['appointment'],
            //点击抽奖按钮时  抽奖活动
            'applet_meeting_start_lottery' => ['lottery'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //点击申请分销按钮时  分销佣金通知、商品推送
            'applet_three_buy_copartner_level' => ['deduct','goods'],
            //点击申请分销按钮时  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //点击发布帖子  帖子评论、帖子点赞、帖子赞赏
            'applet_city_new_post_submit' => ['comment','post','reward'],
            //提交商家入驻申请  入驻店铺审核、入主店铺到期、店铺评论
            'applet_city_new_shop_apply' => ['audit','sexpire','shop_comment'],
            //店铺认领  店铺认领审核、入主店铺到期、店铺评论
            'applet_city_claim_shop' => ['shop_claim','sexpire','shop_comment'],
            //电话本入驻  电话本入驻审核通知
            'applet_mobile_shop_apply' => ['mobile_audit'],
            //点击立即排号  取号成功、叫号通知
            'applet_meal_start_queue' => ['meal_start_queue','meal_call_queue'],
            //私信详情页点击发送  私信通知推送
            'applet_car_submit_chat' => ['live_start'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'group'=>'拼团活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'answer'=>'答题推送',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
                'coin_change'=>'余额变更通知',
                'deduct'=>'分销佣金通知',
                'comment'=>'帖子评论通知',
                'post'=>'帖子推送',
                'reward'=>'帖子赞赏通知',
                'audit'=>'入驻店铺审核通知',
                'sexpire'=>'入驻店铺到期提醒',
                'shop_comment'=>'店铺评论通知',
                'mobile_audit'=>'电话本入驻审核通知',
                'meal_start_queue'=>'取号成功通知',
                'meal_call_queue'=>'叫号通知',
                'chat'=>'私信通知'
            ]
        ],


        //酒店预订
        7 => [
            //点击下单提交  支付成功、商品推送、优惠券推送
            'applet_hotel_create_order' => ['zfcg','goods','coupon'],
            'applet_order_confirm' => ['zfcg','goods','coupon'],
            //点击提醒卖家发货  卖家发货、确认收货
            'applet_order_remind' => ['mjfh','qrsh'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知、余额变更通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知 商品推送
            'applet_buy_member_card' => ['buy_member_card','goods'],
            //点击充值  充值成功、商品推送、秒杀活动推送
            'applet_member_recharge_pay' => ['recharge','goods','limit'],
            //付费预约点击预约时  预约成功提醒、商品推送
            'applet_appointment_create_order' => ['appointment','goods'],
            //点击抽奖按钮时  抽奖活动、秒杀活动推送
            'applet_meeting_start_lottery' => ['lottery','limit'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //领取优惠券  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'group'=>'拼团活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
//                'coin_change'=>'余额变更通知',
            ]
        ],

        //多店
        8 => [
            //点击下单提交  支付成功、商品推送、优惠券推送
            'applet_order_confirm' => ['zfcg','goods','coupon'],
            //点击提醒卖家发货  卖家发货、确认收货、商品推送
            'applet_order_remind' => ['mjfh','qrsh','goods'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知、优惠券推送、商品推送
            'applet_buy_member_card' => ['buy_member_card','coupon','goods'],
            //点击充值  充值成功、商品推送
            'applet_member_recharge_pay' => ['recharge','goods'],
            //付费预约点击预约时  预约成功提醒
            'applet_appointment_create_order' => ['appointment'],
            //点击抽奖按钮时  抽奖活动
            'applet_meeting_start_lottery' => ['lottery'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //点击申请分销按钮时  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //点击发布帖子  帖子评论、帖子点赞
            'applet_community_submit_post' => ['comment','post'],
            //提交商家入驻申请  入驻店铺审核、资讯推送、版本更新
            'applet_community_apply_enter_new' => ['audit','push','upgrade'],
            //点击立即排号  取号成功、叫号通知
            'applet_meal_start_queue' => ['meal_start_queue','meal_call_queue'],
            //订阅直播开始  直播开始通知
            'applet_live_room_want' => [''],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'group'=>'拼团活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
                'comment'=>'帖子评论通知',
                'post'=>'帖子推送',
                'audit'=>'入驻店铺审核通知',
                'sexpire'=>'入驻店铺到期提醒',
                'shop_comment'=>'店铺评论通知',
                'meal_start_queue'=>'取号成功通知',
                'meal_call_queue'=>'叫号通知',
            ]
        ],

        //教育培训
        12 => [
            //点击下单提交  支付成功、商品推送、优惠券推送
            'applet_train_submit_trade' => ['zfcg','goods','coupon'],
            //点击提醒卖家发货  卖家发货、确认收货
            'applet_order_remind' => ['mjfh','qrsh'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知、余额变更通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知 商品推送
            'applet_buy_member_card' => ['buy_member_card','goods'],
            //点击充值  充值成功、商品推送、秒杀活动推送
            'applet_member_recharge_pay' => ['recharge','goods','limit'],
            //付费预约点击预约时  预约成功提醒、商品推送
            'applet_appointment_create_order' => ['appointment','goods'],
            //点击抽奖按钮时  抽奖活动、秒杀活动推送
            'applet_meeting_start_lottery' => ['lottery','limit'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //领取优惠券  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //点击申请分销按钮时  分销佣金通知、余额变更通知
            'applet_three_apply_distribution_new' => ['deduct','goods'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'group'=>'拼团活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
//                'coin_change'=>'余额变更通知',
                'deduct'=>'分销佣金通知'
            ]
        ],


        //房产楼盘
        16 => [
            //点击充值  充值成功
            'applet_member_recharge_pay' => ['recharge'],
            //付费预约点击预约时  预约成功提醒
            'applet_appointment_create_order' => ['appointment'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'fpush' => '房源推送'
            ]
        ],

        //预约服务
        18 => [
            //点击下单提交  支付成功、商品推送、优惠券推送
            'applet_reservation_submit_trade' => ['zfcg','goods','coupon'],
            //点击提醒卖家发货  卖家发货、确认收货
            'applet_order_remind' => ['mjfh','qrsh'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知、余额变更通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知 商品推送
            'applet_buy_member_card' => ['buy_member_card','goods'],
            //点击充值  充值成功、商品推送、秒杀活动推送
            'applet_member_recharge_pay' => ['recharge','goods','limit'],
            //付费预约点击预约时  预约成功提醒、商品推送
            'applet_appointment_create_order' => ['appointment','goods'],
            //点击抽奖按钮时  抽奖活动
            'applet_meeting_start_lottery' => ['lottery'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //领取优惠券  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
//                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
//                'coin_change'=>'余额变更通知',
            ]
        ],

        //工单
        20 => [
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //提交工单 工单处理中、工单已完成、工单评论
            'applet_work_order_submit' => ['work_order_dealing','work_order_dealing','work_order_comment'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'form_deal'=>'留言表单处理结果通知',
            ]
        ],

        //营销商城
        21 => [
            //点击下单提交  支付成功、余额变更通知、积分变更通知
            'applet_order_confirm' => ['zfcg','coin_change','points_change'],
            //点击提醒卖家发货  卖家发货、确认收货
            'applet_order_remind' => ['mjfh','qrsh'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知、余额变更通知
            'applet_order_refund' => ['refund','coin_change'],
            //点击购买会员卡  购买会员卡通知 余额变更通知 积分变更通知
            'applet_buy_member_card' => ['buy_member_card','coin_change','goods'],
            //点击充值  充值成功、余额变更通知
            'applet_member_recharge_pay' => ['recharge','coin_change','goods'],
            //付费预约点击预约时  预约成功提醒、余额变更通知
            'applet_appointment_create_order' => ['appointment','coin_change'],
            //点击抽奖按钮时  抽奖活动、积分变更通知
            'applet_meeting_start_lottery' => ['lottery','points_change'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //点击申请分销按钮时  分销佣金通知、余额变更通知
            'applet_three_apply_distribution_new' => ['deduct','coin_change','goods'],
            //点击申请分销按钮时  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods'],
            //点击用户验证申请  用户验证申请处理结果
            'applet_member_mobile_apply' => ['mobile_apply'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'group'=>'拼团活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'answer'=>'答题推送',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
                'coin_change'=>'余额变更通知',
                'deduct'=>'分销佣金通知',
                'mobile_apply' =>'用户验证申请处理结果',
            ]
        ],

        //知识付费
        27 => [
            //点击下单提交  支付成功、课程推送、优惠券推送
            'applet_order_confirm' => ['zfcg','goods','coupon'],
            //点击提醒卖家发货  卖家发货、确认收货、课程推送
            'applet_order_remind' => ['mjfh','qrsh','goods'],
            //点击申请退款  退款通知
            'applet_order_refund' => ['refund'],
            //点击购买会员卡  购买会员卡通知、优惠券推送、课程推送
            'applet_buy_member_card' => ['buy_member_card','coupon','goods'],
            //付费预约点击预约时  预约成功提醒
            'applet_appointment_create_order' => ['appointment'],
            //点击抽奖按钮时  抽奖活动
            'applet_meeting_start_lottery' => ['lottery'],
            //自定义表单点击提交 留言表单处理结果
            'applet_submit_form_data' => ['form_deal'],
            //点击领取优惠券  分销佣金通知、课程推送
            'applet_coupon_receive' => ['coupon','goods'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'课程推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
            ]
        ],

        //求职内推
        28 => [
            //公司注册  入驻店铺审核
            'applet_job_company_apply' => ['audit'],
            //点击充值  充值成功
            'applet_job_company_recharge' => ['recharge'],
            //投递简历 投递状态变化 简历被浏览 职位推送
            'applet_job_send_resume' => ['job_send_change','job_resume_show','position_push'],
            //职位详情，点击发送给朋友或分享海报 投递状态变化 简历被浏览 职位推送
            'applet_job_position_share' => ['job_recommend_success'],
            //私信详情页点击发送  私信通知推送
            'applet_job_submit_chat' => ['chat'],
            //自定义表单点击提交 留言表单处理结果
            'applet_submit_form_data' => ['form_deal'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'form_deal'=>'留言表单处理结果通知',
                'audit'=>'入驻店铺审核',
                'recharge'=>'充值成功',
                'job_send_change'=>'投递状态变化',
                'job_resume_show'=>'简历被浏览',
                'position_push'=>'职位推送',
                'job_recommend_success'=>'推荐成功',
                'chat'=>'私信通知推送'
            ]
        ],

        //社区团购
        32 => [
            //点击下单提交  支付成功、余额变更通知、积分变更通知
            'applet_sequence_submit_trade_new' => ['zfcg','se_goods_get','se_notice_leader'],
            //点击提醒卖家发货  卖家发货、确认收货
            'applet_order_remind' => ['mjfh','qrsh'],
            'applet_order_confirm_accept' => ['mjfh','qrsh'],
            //点击申请退款  退款通知、余额变更通知
            'applet_order_refund' => ['refund','coin_change'],
            //点击购买会员卡  购买会员卡通知 余额变更通知 积分变更通知
            'applet_buy_member_card' => ['buy_member_card','coin_change'],
            //自定义表单点击提交
            'applet_submit_form_data' => ['form_deal'],
            //提交团长申请 团长申请审核 订单通知团长 订单核销通知
            'applet_sequence_leader_apply' => ['leader_handle','se_notice_leader','se_trade_verify'],
            //优惠券领取  分销佣金通知、商品推送
            'applet_coupon_receive' => ['coupon','goods','push'],


            //点击充值  充值成功、余额变更通知
//            'applet_member_recharge_pay' => ['recharge','coin_change'],
            //点击抽奖按钮时  抽奖活动、积分变更通知
//            'applet_meeting_start_lottery' => ['lottery','points_change'],

            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'goods'=>'商品推送',
                'limit'=>'秒杀活动推送',
                'bargain'=>'砍价活动推送',
                'coupon'=>'优惠券推送',
                'buy_member_card'=>'购买会员卡通知',
//                'lottery'=>'抽奖活动推送',
                'zfcg'=>'支付成功通知',
                'refund'=>'退款通知',
                'mjfh'=>'卖家发货通知',
                'form_deal'=>'留言表单处理结果通知',
                'answer'=>'答题推送',
//                'appointment'=>'付费预约推送',
//                'recharge'=>'充值成功通知',
                'coin_change'=>'余额变更通知',
                'deduct'=>'分销佣金通知',
                'se_notice_leader'=>'订单通知团长',
                'se_trade_verify'=>'订单核销通知',
                'se_goods_get'=>'商品到货通知'

            ]
        ],

        //跑腿
        34 => [
            //点击下单提交  骑手接单通知、骑手已取货通知、订单确认通知
            'applet_legwork_submit_trade' => ['legwork_take','legwork_get','legwork_finish'],
            //点击充值  充值成功
            'applet_member_recharge_pay' => ['recharge'],
            //邀新点击立即分享
            'applet_legwork_share_page' => ['share_success'],
            //自定义表单点击提交 留言表单处理结果
            'applet_submit_form_data' => ['form_deal'],
            //点击领取优惠券  分销佣金通知、课程推送
            'applet_coupon_receive' => ['coupon'],
            //通用推送相关
            'push' => [
                'push'=> '资讯推送',
                'upgrade'=>'版本更新推送',
                'coupon'=>'优惠券推送',
                'form_deal'=>'留言表单处理结果通知',
                'appointment'=>'付费预约推送',
                'recharge'=>'充值成功通知',
                'legwork_take'=>'骑手接单通知',
                'legwork_get'=>'骑手已取货通知',
                'legwork_finish'=>'订单确认通知'
            ]
        ],

    ],


    //文章信息类型
    'defaultMsg'  => [
        21 => [
            //类目  生活服务->线下超市/便利店，商家自营->服装/鞋/箱包
            'coin_change'   => [  //余额变更通知
                'tid' => '1972',
                'keywords' => [1,4,2],
                'values' => [
                    '{变更余额}','{余额变更描述}','{变更后余额}'
                ],
                'brief' => '余额变更通知'
            ],
            'points_change'   => [  //积分变更通知
                'tid' => '310',
                'keywords' => [1,3,2],
                'values' => [
                    '{变更前积分}','{积分变更描述}','{变更后积分}'
                ],
                'brief' => '积分变更通知'
            ],
            'buy_member_card'   => [  //购买会员卡通知
                'tid' => '2380',
                'keywords' => [7,8,2,6],
                'values' => [
                    '{会员卡名称}','{会员卡号}','{到期时间}','{使用须知}'
                ],
                'brief' => '购买会员卡通知'
            ],
            'coupon'   => [  //优惠券推送
                'tid' => '3209',
                'keywords' => [1,2,3,4],
                'values' => [
                    '{优惠券标题}','{使用条件}','{生效时间}', '{失效时间}'
                ],
                'brief' => '优惠券通知'
            ],
            'bargain'   => [  //砍价推送
                'tid' => '2727',
                'keywords' => [1,4],
                'values' => [
                    '{砍价商品}','{帮砍总金额}'
                ],
                'brief' => '砍价成功通知'
            ],
            'group'   => [  //拼团活动推送
                'tid' => '4533',
                'keywords' => [1,5,3,4,7],
                'values' => [
                    '{插入参团时间}','{商品名称}','{商品价格}','{插入拼团价格}','{插入参团剩余人数}'
                ],
                'brief' => '拼团活动通知'
            ],
            'goods'   => [  //商品推送
                'tid' => '2954',
                'keywords' => [1,4,5],
                'values' => [
                    '{商品名称}','{商品原价}','{商品售价}'
                ],
                'brief' => '商品降价通知'
            ],
            'lottery'   => [  //抽奖活动推送
                'tid' => '1116',
                'keywords' => [1,5],
                'values' => [
                    '{活动名称}','{抽奖奖品}'
                ],
                'brief' => '抽奖活动通知'
            ],
            'appointment'   => [  //付费预约
                'tid' => '3096',
                'keywords' => [8,1,7],
                'values' => [
                    '{项目名称}','{项目时间}','{项目价格}'
                ],
                'brief' => '付费预约通知'
            ],
            'recharge'   => [  //充值成功
                'tid' => '755',
                'keywords' => [1,3,4,5],
                'values' => [
                    '{插入订单号}','{支付金额}','{余额}','{充值时间}'
                ],
                'brief' => '充值成功通知'
            ],
            'deduct'   => [  //分销佣金通知
                'tid' => '1493',
                'keywords' => [1,2,3],
                'values' => [
                    '{订单编号}','{订单金额}','{返佣金额}'
                ],
                'brief' => '分销佣金通知'
            ],
            'mjfh'   => [  //卖家发货
                'tid' => '1493',
                'keywords' => [4,5,1,2,3],
                'values' => [
                    '{插入店铺名}','{插入商品名}','{插入快递公司}','{插入快递单号}','{插入支付时间}'
                ],
                'brief' => '卖家发货通知'
            ],
            'refund'   => [  //订单退款
                'tid' => '1451',
                'keywords' => [7,2,3,4,11],
                'values' => [
                    '{插入订单号}','{插入商品名}','{插入退款金额}','{插入退款时间}','{插入退款原因}'
                ],
                'brief' => '订单退款通知'
            ],
            'zfcg'   => [  //支付成功
                'tid' => '1927',
                'keywords' => [7,2,3,4,11],
                'values' => [
                    '{插入订单号}','{插入商品名}','{插入订单金额}','{插入支付时间}'
                ],
                'brief' => '支付成功通知'
            ],

        ],

        32 => [
            //类目  生活服务->线下超市/便利店
            'zfcg'   => [  //订单支付成功
                'tid' => '3578',   //微信模板id
                'keywords' => [1,2,3,4],
                'values' => [//默认变量
                     '{插入商品名}', '{插入订单金额}','{插入订单号}', '{插入支付时间}',
                ],
                'brief' => '订单支付成功通知'
            ],
            'refund'   => [  //退款通知
                'tid' => '1451',
                'keywords' => [7,2,9,3,11],
                'values' => [
                    '{插入订单号}','{插入商品名}','{插入订单金额}', '{插入退款金额}','{插入退款原因}'
                ],
                'brief' => '订单退款成功通知'
            ],
            'coupon'   => [  //优惠券推送
                'tid' => '3209',
                'keywords' => [1,2,3,4],
                'values' => [
                    '{优惠券标题}','{使用条件}','{生效时间}', '{失效时间}'
                ],
                'brief' => '优惠券通知'
            ],
            'buy_member_card'   => [  //会员卡推送
                'tid' => '2380',
                'keywords' => [7,8,2,6],
                'values' => [
                    '{会员卡名称}','{会员卡号}','{到期时间}', '{使用须知}'
                ],
                'brief' => '会员开通成功通知'
            ],
            'se_trade_verify'   => [  //订单核销
                'tid' => '3116',
                'keywords' => [2,3,4],
                'values' => [
                    '{商品名称}','{订单号}','{核销时间}'
                ],
                'brief' => '订单核销通知用户'
            ],
            'se_notice_leader'   => [  //订单通知团长
                'tid' => '1476',
                'keywords' => [2,3,4,6],
                'values' => [
                    '{商品名称}','{订单金额}','{订单号}','{下单时间}'
                ],
                'brief' => '新订单通知团长'
            ],
            'se_goods_get'   => [  //商品到货通知
                'tid' => '4049',
                'keywords' => [1,3,5],
                'values' => [
                    '{商品名称}','{取货时间}','{取货地址}'
                ],
                'brief' => '商品到货通知'
            ],
            'leader_handle'   => [  //团长申请审核结果
                'tid' => '4082',
                'keywords' => [2,1,3],
                'values' => [
                    '{审核内容}','{审核结果}','{审核时间}'
                ],
                'brief' => '团长申请审核结果通知'
            ],
            'form_deal'   => [  //留言表单处理结果
                'tid' => '3840',
                'keywords' => [1,2,3],
                'values' => [
                    '{表单标题}','{留言时间}','{处理内容}'
                ],
                'brief' => '留言表单处理结果通知'
            ],

        ],

    ],

    'paramDesc' => [
        'thing' => [
            'key' => 'thing',
            'name' => '事务',
            'desc' => '20个以内字符，可汉字、数字、字母或符号组合。',
            'warning' => '超出部分将被截取'
        ],
        'number' => [
            'key' => 'number',
            'name' => '数字',
            'desc' => '32位以内，只能数字，可带小数，',
            'warning' => '超出部分将被截取，不满足规则将无法发送'
        ],
        'letter' => [
            'key' => 'letter',
            'name' => '字母',
            'desc' => '32位以内，只能字母。',
            'warning' => '超出部分将被截取，不满足规则将无法发送'
        ],
        'symbol' => [
            'key' => 'symbol',
            'name' => '符号',
            'desc' => '5位以内，只能符号。',
            'warning' => '不满足规则将无法发送'
        ],
        'character_string' => [
            'key' => 'character_string',
            'name' => '字符串',
            'desc' => '32位以内数字、字母或符号。',
            'warning' => '超出部分将被截取'
        ],
        'time' => [
            'key' => 'time',
            'name' => '时间',
            'desc' => '24小时制时间格式（支持+年月日)，例如：15:01，或：2019年10月1日 15:01。',
            'warning' => '不满足规则将无法发送'
        ],
        'date' => [
            'key' => 'date',
            'name' => '日期',
            'desc' => '年月日格式（支持+24小时制时间），例如：2019年10月1日，或：2019年10月1日 15:01。',
            'warning' => '不满足规则将无法发送'
        ],
        'amount' => [
            'key' => 'amount',
            'name' => '金额',
            'desc' => '1个币种符号+10位以内纯数字，可带小数，结尾可带“元”。',
            'warning' => '不满足规则将无法发送'
        ],
        'phone_number' => [
            'key' => 'phone_number',
            'name' => '电话',
            'desc' => '17位以内，数字、符号电话号码，例：+86-0766-66888866。',
            'warning' => '不满足规则将无法发送'
        ],
        'car_number' => [
            'key' => 'car_number',
            'name' => '车牌',
            'desc' => '8位以内，第一位与最后一位可为汉字，其余为字母或数字，例：粤A8Z888挂。',
            'warning' => '不满足规则将无法发送'
        ],
        'name' => [
            'key' => 'name',
            'name' => '姓名',
            'desc' => '中文10个汉字内；纯英文20个字母内；中文和字母混合按中文名算，10个字内。',
            'warning' => '超出部分将被截取'
        ],
        'phrase' => [
            'key' => 'phrase',
            'name' => '汉字',
            'desc' => '5个以内汉字。',
            'warning' => '超出部分将被截取，不满足规则将无法发送'
        ],
    ],



];
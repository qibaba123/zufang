<?php
/**
 * 配置文件通用说明
 * 应用环境分为三种类型：test测试环境，dev开发环境，pro生产环境
 * 1、test测试环境将根据app.php配置文件中的test_host字段的配置内容自动识别
 * 2、dev开发环境和pro生产环境有index.php中的常量决定
 *
 * 配置字段分为四种类型：common通用类型，test测试类型，dev开发类型，pro生产类型
 * 1、test,dev,pro均继承自common类型
 * 2、配置字段时，common类型无需特别声明，默认即为common类型
 * 3、其他三种类型配置时加上标识+':'+字段名，如'test:default_tpl'
 * 4、注意标识后边的':'的两侧不能有空格
 * 5、使用时，优先获取各应用环境下的配置字段，如无，则获取通用类型
 */
return array(
	//应用名称及应用调试状态
	'app_name'		=> '天店通',
	'app_domain'	=> '',
	'app_manage_domain'		=> array(),
	'app_debug_env'	=> 'production',//取值development(开发环境)，production(生产环境)，testing(测试环境，自动识别，无需配置)
	'app_debug_mode'=> false,//production(生产环境)时，该配置不起作用
	'test_host'	=> array(
		'127.0.0.1', 'localhost'
	),
	//云片网短信配置
	'yunpian'	=> array(
		'api_key'		=> '',
		'sign_token'	=> '',
        'sign_company'  => '天店通',
		'valid_time'	=> 10*60,//十分钟有效期
		'unit_price'	=> 0.06,//单位元
		//短信发送模板
		'tpl'		=> array(
			1	=> array(
				'tpl_id'		=> 1,
				'tpl_content'	=> '【#company#】您的验证码是#code#',
				'tpl_key'		=> array('company', 'code')
			),
			2	=> array(
				'tpl_id'		=> 2,
				'tpl_content'	=> '【#company#】您的验证码是#code#。如非本人操作，请忽略本短信',
				'tpl_key'		=> array('company', 'code')
			),
			1572798	=> array(
				'tpl_id'		=> 1572798,
				'tpl_content'	=> '【天店通】新订单通知，会员#name#购买的#goods#商品已下单成功，订单编号#code#，请尽快安排发货。',
				'tpl_key'		=> array('name', 'goods', 'code'),
			),
			1572808	=> array(
				'tpl_id'		=> 1572808,
				'tpl_content'	=> '【天店通】订单完成通知，会员#name#购买的订单#code#已确认收货，订单已完成。',
				'tpl_key'		=> array('name', 'code'),
			),
		),
	),
	'quxun'		=> array(
		'uid'	=> '',
		'pwd'	=> ''
	),
    'ip138'     => array(
        'AppKey'    => 24588099,
        'AppSecret' => '',
        'AppCode'   => '',
    ),
    'ele'       => array(
        'AppID'     => '',
        'SecretKey' => '',
    ),
	'alidayu'	=> array(
		'app_key'		=> '',
		'app_secret'	=> '',
		'sign_token'	=> '',
		'app_sign'		=> '天店通',
		'app_product'	=> '天店通',
		'valid_time'	=> 60*60,//六十分钟有效期
		'tpl'			=> array(
			'sfyz'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product'),
				'tpl_demo'	=> '验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！',
			),
			'dlqr'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product'),
				'tpl_demo'	=> '验证码${code}，您正在登录${product}，若非本人操作，请勿泄露。',
			),
			'dlyc'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product'),
				'tpl_demo'	=> '验证码${code}，您正尝试异地登录${product}，若非本人操作，请勿泄露。',
			),
			'yhzc'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product'),
				'tpl_demo'	=> '验证码${code}，您正在注册成为${product}用户，感谢您的支持！',
			),
			'hdqr'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product', 'item'),
				'tpl_demo'	=> '验证码${code}，您正在参加${product}的${item}活动，请确认系本人申请。',
			),
			'xgmm'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product'),
				'tpl_demo'	=> '验证码${code}，您正在尝试修改${product}登录密码，请妥善保管账户信息。',
			),
			'xxbg'	=> array(
				'tpl_id'	=> '',
				'tpl_key'	=> array('code', 'product'),
				'tpl_demo'	=> '验证码${code}，您正在尝试变更${product}重要信息，请妥善保管账户信息。',
			),
		),
	),
	//ping++支付配置
	'pingpp'	=> array(
		'app_name'	=> '天店通',
		'app_id'	=> '',
		'test_key'	=> '',
		'live_key'	=> '',
	),
	'geetest'	=> array(
		'captcha_id'		=> '',
		'private_key'		=> '',
	),
	'youzan'	=> array(
		//旧的
		//'client_id'     => '',
		//'client_secret' => '',
		//新的
		'client_id'     => '',
		'client_secret' => '',
	),
	'weidian'	=> array(
		'appkey'	=> '',
		'secret'	=> '',
	),
    // 高德地图
    'mapKay' =>'834759862e8170bdd5b806c16a83fac3',
	//信鸽推送配置
	'xg_cfg'    => array(    //原来老版本
		//安卓配置
		'xg_android'=>array(
			"accessId"  => "",
			"accessKey" => "",
			"secretKey" => "",
		),
		//ios配置
		'xg_ios'=>array(
			"accessId"  => "",
			"accessKey" => "",
			"secretKey" => "",
		),
	),
//	'xg_cfg'    => array(  //新版本
//		//安卓配置
//		'xg_android'=>array(
//			"accessId"  => "",
//			"accessKey" => "",
//			"secretKey" => "",
//		),
//		//ios配置
//		'xg_ios'=>array(
//			"accessId"  => "",
//			"accessKey" => "",
//			"secretKey" => "",
//		),
//	),
    //极光推送配置
    'jpush'  => array(
        'AppKey' => '',
        'MasterSecret' => ''
    ),

    // 51同镇极光推送(51同镇APP使用)
    'tongzhenjpush' => array(
        'AppKey' => '',
        'MasterSecret' => ''
    ),

    // 跑腿骑手app极光推送 (51同镇)
    'legworkappjpush' => array(
        'AppKey' => '',
        'MasterSecret' => ''
    ),

    // 跑腿骑手app极光推送（跑得快跑腿）
    'legworkappjpushnew' => array(
        'AppKey' => '',
        'MasterSecret' => ''
    ),

    //阿拉丁统计配置  账号： 密码：。
    'aldcfg' => array(
        "third_id"     => "",
        "third_secret" => ""
    ),

    // 飞鹅打印机配置
    'feie'  => array(
        'user' => 'thomas@ikinvin.com',
        'ukey' => 'XpMFaUk4vV7RB8Ak'
    ),
	'sex' => array(
		'M' => '男',
		'Y' => '女'
	),
	'apply_tx_type'	=> array(
		'wx'		=> 1,//微信红包
		'alipay'	=> 2,//支付宝账号
		'bank'		=> 3,//银行账号
	),
	'wechat_type' =>array(
		0 => '订阅号',
		1 => '升级的订阅号',
		2 => '服务号',
	),
	'tx_map'	=> array(
		1	=> '微信红包',
		2	=> '支付宝账号',
		3	=> '银行账号',
	),
	'tx_ma_map'	=> array(
		1	=> '微信红包',
		2	=> '企业转账',
		3	=> '人工转账',
	),
    // 微信小程序提现
    'applet_tx_map'	=> array(
        1	=> '微信零钱',
        2	=> '支付宝账号',
        3	=> '银行账号',
    ),
    'applet_tx_ma_map'	=> array(
      //  1	=> '微信红包',
        2	=> '微信转账到零钱',
        3   => '微信转账到银行卡',
        4	=> '人工转账',
    ),
	'tx_status' => array(
		0 => '待审核',
		1 => '审核通过',
		2 => '审核拒绝',
	),
	'btn' => array(
		0 => 'danger',
		1 => 'success',
		2 => 'warning'
	),
	'shop_type'		=> array(
		'fenxiaobao'=> 0,
		'youzan'	=> 1,
		'weidian'	=> 2,
	),
	'shop_kefu'     => array(
		3 => '百度商桥',
		1 => '美洽',
		2 => 'QQ',
		0 => ' 无',
	),
	'order_status'	=> array(
		1      		=> '订单未付款',
		2	     	=> '订单已付款',
		3			=> '订单已完成',
		4			=> '订单已关闭',
		5			=> '订单退款'
	),
	'trade_status'	=> array(
		// 0			=> '待成团',
		1      		=> '订单未付款',
		2	     	=> '待成团',             #'付款中',
		3			=> '已付款',
		4			=> '已发货',
		5			=> '确认收货',
		6			=> '已完成',
		7			=> '已关闭',
		8			=> '退款订单',
		10          => '待抽奖',
	),
	'group_trade_status'	=> array(
		// 0			=> '待成团',
		1      		=> '订单未付款',
		2	     	=> '待成团',
		3			=> '待发货',
		4			=> '待收货',
		5			=> '确认收货',
		6			=> '已完成',
		7			=> '已关闭',
		8			=> '已退款',
		10          => '待抽奖',
	),
	// 维权处理结果
	'refund_status' => array(
		1           => '拒绝退款',
		2           => '同意退款',
		3           => '买家撤销',
	),
	'order_status_search'	=> array(
		'all'      	=> 0,
		'nopay'	    => 1,
		'pay'		=> 2,
		'complete'	=> 3,
		'close'		=> 4,
		'refund'	=> 5,
	),

	'trade_status_search'	=> array(
		'all'      	=> 0,
		'nopay'	    => 1,
		'pay'		=> 3,
		'complete'	=> 6,
		'close'		=> 7,
		'refund'	=> 8,
	),

	'withdraw_status'	=> array(
		0			=> '待审核',
		1      		=> '审核通过',
		2	     	=> '审核拒绝',
	),
    'legwork_withdraw_status'	=> array(
        1			=> '待审核',
        2      		=> '审核通过',
        3	     	=> '审核拒绝',
    ),
	'show'	=> array(
		0			=> '隐藏',
		1      		=> '显示',
	),
	'vote_game_status' => array(
		1      		=> '正常',
		2	     	=> '关闭',
	),
	'shopType'  => array(
		0 => '天店通店铺',
		1 => '有赞店铺',
		2 => '微店店铺',
	),
	// 店铺状态
	'shop_status' => array(
		0 => '正常',
		1 => '申请中',
		2 => '禁用',
		3 => '单功能',

	),
	'redStatus' => array(
		0 => '未启动',
		1 => '进行中',
		2 => '已暂停',
		3 => '已结',
	),
	'bargainStatus' => array(
		0 => '准备中',
		1 => '进行中',
		2 => '已结束',
	),

	'bargainBuy' => array(
		0 => '未购买',
		1 => '已购买',
	),
	'goodsType' => array(
		1 => '实物商品',
		2 => '虚拟商品'
	),
	'audit'	=> array(
		0	=> '审核中',
		1   => '审核通过',
		2	=> '审核拒绝',
	),
	//分销中心默认配置
	'center_cfg'	=> array(
		'cc_center_title'	=> '会员中心',
		'cc_center_bg'		=> '/public/mobile/images/shk_02.png',
		'cc_center_color'	=> '#FFFFFF',
		'cc_qrcode_bg'		=> '/public/mobile/images/qr_bg.jpg',
		'cc_qrcode_tip'		=> '您的推广二维码已生成,请稍后,马上发送给您',
		'cc_noqr_tip'		=> '您还没有消费体验产品,不能获得推广二维码',
		'cc_avatar_loc'		=> '(15,15)',
		'cc_qrcode_loc'		=> '(210,380)',
		'cc_min_num'		=> 0,
		'cc_min_amount'		=> 0,
		'cc_must_set'		=> 0,
		'cc_show_refer'		=> 1,
		'cc_myuser_show'	=> 1,
		'cc_myshare_show'	=> 1,
		'cc_mycash_show'	=> 1,
		'cc_myrefer_show'	=> 1,
		'cc_mywith_show'	=> 1,
		'cc_myrank_show'	=> 1,
		'cc_myinfo_show'	=> 1,
		'cc_myorder_show'	=> 1,
		'cc_mycode_show'	=> 1,
		'cc_myuser_name0'	=> '我的会员',
		'cc_myuser_name1'	=> '一级会员',
		'cc_myuser_name2'	=> '二级会员',
		'cc_myuser_name3'	=> '三级会员',
		'cc_myshare_name'	=> '我的分享收入',
		'cc_mycash_name'	=> '我的返现收入',
		'cc_myrefer_name'	=> '我的推荐人',
		'cc_mywith_name'	=> '申请提现',
		'cc_myrank_name'	=> '销售排行榜',
		'cc_myinfo_name'	=> '我的资料',
		'cc_myorder_name'	=> '分销订单',
		'cc_mycode_name'	=> '我的二维码',
	),
	//会员中心默认配置
	'center_tool'	=> array(
	    'ct_topstyle'       => 1,
		'ct_center_title'	=> '会员中心',
		'ct_center_bg'		=> '/public/mobile/images/shk_02.png',
		'ct_center_color'	=> '#FFFFFF',
		'ct_mypt_show'		=> 0,//我的拼团
		'ct_mycj_show'		=> 0,//我的抽奖
		'ct_myfx_show'		=> 0,//分销中心
		'ct_myact_show'		=> 1,//账户充值
		'ct_myjf_show'		=> 0,//我的积分
		'ct_jfshop_show'    => 0,//积分商城
		'ct_myyhq_show'		=> 1,//优惠券
		'ct_mywith_show'	=> 1,//余额提现
		'ct_myinfo_show'	=> 1,//修改资料
		'ct_myphone_show'	=> 0,//我的手机号
		'ct_myaddr_show'	=> 1,//地址管理
		'ct_mycart_show'	=> 1,//购物车
		'ct_myvip_show'		=> 0,//特级会员
        'ct_mycard_show'	=> 1,//我的会员
		'ct_partner_show'	=> 0,//合伙人
		'ct_myft_show'	    => 1,//发帖
		'ct_mypl_show'	    => 1,//评论
		'ct_mydd_show'	    => 1,//订单
		'ct_mymalldd_show'	    => 0,//商城订单
		'ct_region_show'	=> 0,//区域代理商
		'ct_mysc_show'	    => 1,//我的收藏
		'ct_mylpq_show'	    => 0,//我的礼品券
		'ct_mybespeak_show'	=> 0,//我的预约
		'ct_service_show'	=> 0,//客服电话
		'ct_aboutus_show'	=> 0,//关于我们
		'ct_myread_show'	=> 0,//付费阅读
        'ct_mymp_show'	    => 0,//我的名片
        'ct_mympj_show'	    => 0,//我的名片夹
        'ct_kefu_show'	    => 0,//客服
        'ct_myyqm_show'	    => 1,//邀请码
        'ct_mystudy_show'	=> 1,//我的学习情况
        'ct_mydy_show'	    => 1,//我的订阅
        'ct_myms_show'	    => 1,//我的秒杀
        'ct_mykj_show'	    => 1,//我的砍价
        'ct_mybr_show'      => 1,//我的足迹
        'ct_myhx_show'      => 0,//我的核销
        'ct_appletad_show'  => 0,//我也要做小程序 已移至代理商后台
        'ct_myfree_show'    => 0,//免费预约订单
        'ct_mygd_show'      => 0,//单品分销显示
        'ct_mygdp_show'     => 0,//单品分销收益显示
        'ct_myreturn_show'  => 0,//订单返现
        'ct_myinvite_show'  => 1,//邀请赚金币(游戏盒子)
        'ct_mycooperation_show'  => 1,//商务合作(游戏盒子)
        'ct_myappo_show'    => 0,//我的付费预约
        'ct_mychat_show'    => 1, //私信
        'ct_mobilebook_show' => 1, //电话本
		'ct_mypt_name'		=> '我的拼团',//分销中心
		'ct_mycj_name'		=> '我的抽奖团',//分销中心
		'ct_myfx_name'		=> '分销中心',//分销中心
		'ct_myact_name'		=> '我的钱包',//账户充值
		'ct_myjf_name'		=> '我的积分',
		'ct_myyhq_name'		=> '我的优惠券',//优惠券
		'ct_mywith_name'	=> '收益提现',//余额提现
		'ct_myinfo_name'	=> '修改资料',//修改资料
		'ct_myphone_name'	=> '我的手机号',//我的手机号
		'ct_myaddr_name'	=> '地址管理',//地址管理
		'ct_mycart_name'	=> '购物车',//购物车
		'ct_myvip_name'		=> '特级会员',//特级会员
        'ct_mycard_name'    => '我的会员',//我的会员
		'ct_partner_name'	=> '招募合伙人',//特级会员
		'ct_myft_name'		=> '我的发帖',//发帖
		'ct_mypl_name'		=> '我的评论',//评论
		'ct_mydd_name'		=> '我的订单',//订单
        'ct_mymalldd_name'		=> '我的商城订单',//订单
		'ct_region_name'	=> '区域代理商',
		'ct_jfshop_name'	=> '积分商城',
		'ct_mylpq_name'	    => '我的礼品券',
		'ct_mysc_name'	    => '我的收藏',
		'ct_mybespeak_name' => '我的预约',
		'ct_service_name'   => '客服电话',
		'ct_aboutus_name'   => '关于我们',
		'ct_myread_name'    => '付费阅读',
        'ct_mymp_name'      => '我的名片',
        'ct_mympj_name'      => '我的名片夹',
        'ct_kefu_name'      => '客服',
        'ct_myyqm_name'	    => '兑换码',//兑换码
        'ct_mystudy_name'	=> '我的学习情况',//我的学习情况
        'ct_mydy_name'	    => '我的订阅',//我的订阅
        'ct_myms_name'	    => '我的秒杀',//我的秒杀
        'ct_mykj_name'	    => '我的砍价',//我的砍价
        'ct_mybr_name'      => '我的足迹', //我的足迹
        'ct_myhx_name'      => '我的核销', //我的核销
        'ct_mygd_name'      => '单品分销', //单品分销
        'ct_mygdp_name'     => '分享收益', //单品分销分享收益
        'ct_myreturn_name'  => '订单返现', //订单返现
        'ct_myinvite_name'  => '邀请赚金币', //邀请赚金币(游戏盒子)
        'ct_mycooperation_name'  => '商务合作',//商务合作(游戏盒子)
 		'ct_advert_show'	=> 0,//广告显示
		'ct_advert_img'		=> '',
		'ct_advert_link'	=> '',
        'ct_appletad_name'  => '我也要做小程序',//我也要做小程序 已移至代理商后台
        'ct_myfree_name'    => '预约订单',//我也要做小程序 已移至代理商后台
        'ct_style_type'     => 1, //会员中心样式 默认旧版
        'ct_service_title'  => '我的服务', //新版会员中心内容标题
        'ct_myappo_name'    => '付费预约',
        'ct_mychat_name'    => '私信',
        'ct_mobilebook_name' => '电话本', //电话本
        /*----社区团购相关----*/
        'ct_coupon_name'    => '领券大厅',
        'ct_coupon_show'    => 0,
        'ct_tzapply_name'   => '申请当团长',
        'ct_tzapply_show'   => 1,
        'ct_tzcenter_name'  => '团长管理中心',
        'ct_tzcenter_show'  => 1,
        'ct_gysapply_name'  => '我是供应商',
        'ct_gysapply_show'  => 0,
        'ct_tzinfo_name'  => '团长信息',
        'ct_tzinfo_show'  => 1,
        'ct_pickstation_name'  => '自提点管理',
        'ct_pickstation_show'  => 1,
        'ct_invitenew_show'  => 0, //新人邀请
        'ct_invitenew_name'  => '新人邀请', //新人邀请
        /*-------------------*/

        /*----二手车相关----*/
        'ct_carshare_name'    => '分享有礼', //跑腿也用这个
        'ct_carshare_show'    => 1,
        'ct_carshopcollect_name'   => '关注服务商',
        'ct_carshopcollect_show'   => 1,
        'ct_carbargain_name'  => '我的砍价',
        'ct_carbargain_show'  => 1,
        /*-------------------*/

        /*----跑腿----*/
        'ct_applyrule_name'    => '加入跑男',
        'ct_applyrule_show'    => 0,

        'ct_helpcenter_name'    => '帮助中心',
        'ct_helpcenter_show'    => 0,
        'ct_invoice_name'    => '我的发票',
        'ct_invoice_show'    => 0,
        'ct_exchange_name'    => '我的报名',
        'ct_exchange_show'    => 0,
        'ct_mywifi_name'    => '我的wifi',
        'ct_mywifi_show'    => 0,
        'ct_redbag_name'    => '组队红包',
        'ct_redbag_show'    => 0,

        'ct_lottery_name'    => '组队红包',
        'ct_lottery_show'    => 0,

        'ct_myvault_name'    => '小金库',
        'ct_myvault_show'    => 0,

        'ct_verify_mobile'  => 0,

        'ct_mycfg_name'    => '我的设置',
        'ct_mycfg_show'    => 0,

        'ct_actcenter_name'    => '活动中心',
        'ct_actcenter_show'    => 0,
        // 跑腿中心默认不显示
        'ct_complaint_show'	=>0,

        'ct_shopapply_name'    => '申请入驻',
        'ct_shopapply_show'    => 0,
	),
	'forever'	=> array(
		0 => '暂不生成',
		1 => '生成'
	),
	'yesNo' => array(
		0 => '否',
		1 => '是'
	),
    'order_price'   => array(
        12   => array(
            'name'      => '天店通商家版 一年期',
            'price'     => 1600,
            'origin'    => 1800,
            'right'     => array(
                '专属客户经理一对一服务',
                '行业解决方案贴身指导落地',
            )
        ),
        24   => array(
            'name'      => '天店通商家版 两年期',
            'price'     => 3000,
            'origin'    => 3600,
            'right'     => array(
                '专属客户经理一对一服务',
                '行业解决方案贴身指导落地',
            )
        ),
		36   => array(
			'name'      => '天店通商家版 三年期',
			'price'     => 4200,
			'origin'    => 5400,
			'right'     => array(
				'专属客户经理一对一服务',
				'行业解决方案贴身指导落地',
			)
		),
        15   => array(
            'name'      => '天店通VIP定制 15月期',
            'price'     => 50000,
            'origin'    => 60000,
            'right'     => array(
                '专属客户经理一对一服务',
                '行业解决方案贴身指导落地',
            )
        ),
    ),
    'shop_version'  => array(
        0   => array('name' => '免费版', 'color' => '#bbb'),
        1   => array('name' => '商家版', 'color' => '#FF5A5A'),
        2   => array('name' => 'VIP版', 'color' => ''),
    ),
    //砍价活动阈值,防止刷票
    'bargain_threshold' => array(
        0   => 30,//初始阈值
        1   => 100,//第一阶段,超过30s
        2   => 500,//第二阶段,超过100s
        3   => 3000,//第三阶段,超过5000s
    ),
	'trade_overtime'	=> array(
		'close'		=> 60*60,//60分钟
        'finish'    => 7*24*60*60,//7天完成订单
		'extend'	=> 3*24*60*60,//3天延长收货时间
		'settled'	=> 7*24*60*60,//7天待结算订单完成
		'refund'	=> 7*24*60*60,//7天退款申请
		'none'		=> 15*24*60*60,//15天订单完成后不可退款
	),
    'fdl_image'     => "/public/site/img/fxb_fdl.jpg",
    //mobile下允许访问的域名
	'allow_domain'	=> array('www.tdotapp.com', 'www.91yikuaiqian.com', 'www.ykuaiqian.com'),
    'kdniao'    => array(
        'app_id'        => 1262053,
        'app_key'       => '',
        'app_url'       => 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx'
    ),
	'settledStatus' => array(
		0 => '进行中',
		1 => '结算成功',
		2 => '退款',
	),
	'settled_status_select' => array(
		0 => array(
			'css'   => 'info',
			'label' => '进行中',
		),
		1 => array(
			'css'   => 'success',
			'label' => '结算成功',
		),
		2 => array(
			'css'   => 'default',
			'label' => '退款',
		),
	),
	'settled_status' => array(
		'all'     => -1,
		'doing'   => 0,
		'success' => 1,
		'refund'  => 2,
		'failed'  => 3,
	),
	'tradePayType' => array(
		1 => '微信安全支付－自有',
		2 => '微信安全支付－代销',
		3 => '支付宝',
		4 => '货到付款'
	),
	'banks' => array(
		"10001" => "中国工商银行 ",
		"10002" => "中国农业银行 ",
		"10003" => "中国银行 ",
		"10004" => "中国建设银行 ",
		"10005" => "交通银行 ",
		"10006" => "中国邮政储蓄银行 ",
		"10007" => "招商银行 ",
		"10008" => "中信银行 ",
		"10009" => "中国光大银行 ",
		"10010" => "中国民生银行 ",
		"10011" => "兴业银行 ",
		"10012" => "浦东发展银行 ",
		"10013" => "广发银行 ",
		"10014" => "平安银行 ",
	),
	'sort_type'		=> array(
		1	=>	array('name' => '排序数字越大越靠前'),
		2	=>	array('name' => '商品序号越大越靠前'),
		3	=>	array('name' => '创建时间越早越靠前'),
		4	=>	array('name' => '最热的排在前面'),
	),
	'group_type'		=> array(
		1	=>	array(
			'type'  => 1,
			'title' => '普通拼团',
			'brief' => '设置普通拼团信息',
			'desc'  => '顾客帮你卖，信任背书，老客带新客参团购买，开团分享',
			'color' => 'red',
			'field' => 'gc_ptpt_rule',
			'img'   => 'gc_ptpt_img',
		),
		2	=>	array(
			'type'  => 2,
			'title' => '抽奖团',
			'brief' => '设置抽奖团购信息',
			'desc'  => '全新拼团模式，小价格买高性价商品，吸粉的绝佳利器',
			'color' => 'blue',
			'field' => 'gc_cjt_rule',
			'img'   => 'gc_cjt_img'
		),
		3	=>	array(
			'type'  => 3,
			'title' => '团长优惠团',
			'brief' => '设置团长优惠团购信息',
			'desc'  => '意见领袖当团长，号召群众来拼团，建立直销平台',
			'color' => 'green',
			'field' => 'gc_tzyht_rule',
			'img'   => 'gc_tzyht_img'
		),
        4	=>	array(
            'type'  => 4,
            'title' => '阶梯拼团',
            'brief' => '设置团长优惠团购信息',
            'desc'  => '意见领袖当团长，号召群众来拼团，建立直销平台',
            'color' => 'green',
            'field' => 'gc_tzyht_rule',
            'img'   => 'gc_tzyht_img'
        ),
	),
	'coupon_slogan'	=> array(
		'城里人好会玩,用优惠券扫货',
		'抢优惠券,选对货,做对事',
		'不去购物,抢啥优惠券',
		'感谢优惠券,扫货就靠你了',
		'一旦被宠爱,必然会沦陷',
		'怀揣这么大的优惠券,心慌慌',
		'用优惠券,遇见更有趣的自己',
		'全力以赴的我,今天要多买一点',
		'我是购买狂,我为自己代言',
		'世界一直在变,不变的是扫货的心',
        '购物不领优惠券，不如回家卖手链',
        '朋友一生一起走，优惠券是咱好朋友'
	),
	'send_goods' => array(
		1 => '全送',
		2 => '随机赠送一个',
	),
	'full_type' => array(
		1 => array(
			'type'  => 1,
			'title' => '满减活动',
			'brief' => '设置订单满多少钱享受减多少钱的优惠',
			'desc'  => '通过满减活动，惠及用户，促销商品',
			'color' => 'red'
		),

		2 => array(
			'type'  => 2,
			'title' => '满赠活动',
			'brief' => '设置订单满多少钱可有赠品的优惠活动',
			'desc'  => '通过满赠活动，惠及用户，促销商品',
			'color' => 'blue'
		),
		3 => array(
			'type'  => 3,
			'title' => '满折活动',
			'brief' => '设置订单满多少钱享受几折的优惠活动',
			'desc'  => '通过满折活动，惠及用户，促销商品',
			'color' => 'green'
		),
		4 => array(
			'type'  => 4,
			'title' => '满包邮活动',
			'brief' => '设置订单满多少钱商品包邮的活动',
			'desc'  => '通过满包邮活动，惠及用户，促销商品',
			'color' => 'yellow'
		),
	),
	'full_use_type' => array(
		1 => '全店通用',
		2 => '指定商品参与',
	),

	'system_slide_type' => array(
		'ffymhd'    => '付费页面幻灯',
		'cjffym'    => '插件付费页面',
		'sellerApp' => '商家版App首页',
		'website'   => '网站首页幻灯',
		'helpcenter'=> '帮助中心幻灯',
		'agentManage'=> '代理商管理后台'
	),
	'seo_cfg' => array(
		'index' => array(
			'title' 	  => '天店通_小程序开发平台_小程序招商_小程序加盟_百度小程序_抖音小程序',
			'keywords' 	  => '小程序加盟_小程序招商_小程序代理_微信小程序_小程序制作平台_小程序生成平台_小程序平台_微商铺_分销商城_微商城_百度小程序_智能小程序_头条小程序_抖音小程序',
			'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交，面向全国开启小程序招商加盟，同时已开发出百度智能小程序_抖音小程序，欢迎各方人士加盟合作，共享千亿市场。',
		),
		'list' => array(
			'title' 	  => '微商铺,分销商城,微信小程序开发平台-天店通【官网】',
			'keywords' 	  => '微信营销,微商城,微信商城,微分销,微分销系统,分销商城,微商铺,分销宝,天店通,小程序开发,微信小程序制作,小程序开发平台，郑州小程序开发',
			'description' => '天店通，行业内领先的微商城系统，商家可以使用微分销系统进行微分销，是一家专业的微信小程序制作与小程序开发平台，并且郑州小程序开发可以进行单独的功能定制开发，无缝对接有赞、微店，拥有强大的功能和分销商城营销插件，使你能够利用微信商城和小程序开发，成就一个微信营销神话！',
		),
        'template' => array(
            'title' 	  => '行业模板_天店通',
            'keywords' 	  => '小程序模板开发,餐饮小程序模板，商城小程序模板，小程序招商,小程序代理加盟,微信小程序',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交，这里有各行各业的模板，热门的餐饮小程序模板和商城小程序模板静等您的参观!',
        ),
        'userCase' => array(
            'title' 	  => '商家案例_天店通',
            'keywords' 	  => '小程序案例，餐饮小程序案例，企业小程序案例,小程序招商,小程序代理加盟',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交,这里有与我们合作过的案例展示,不管您是做企业的还是做餐饮的,我们有海量优质案例供您选择!',
        ),
        'cooperate' => array(
            'title' 	  => '小程序加盟_天店通',
            'keywords' 	  => '小程序代理,小程序加盟平台,招商代理小程序,小程序代理加盟,小程序代理怎么样,微信小程序',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交,面向全国开启小程序招商加盟，同时已开发出百度智能小程序
，欢迎各方人士加盟合作，共享千亿市场。',
        ),
        'customizing' => array(
            'title' 	  => '官方定制_天店通',
            'keywords' 	  => '小程序开发,微信小程序开发工具,小程序怎样定制,小程序招商,小程序代理加盟,微信小程序',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交,来自国内专业小程序开发团队，专业为您定制出您想要小程序。',
        ),
        'news' => array(
            'title' 	  => '新闻资讯_天店通',
            'keywords' 	  => '关于小程序的新闻,小程序资讯,小程序怎么注册,小程序最新排行榜,小程序招商,小程序代理加盟,微信小程序',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交,这里有最新的小程序资讯,以及行业的最新动态,在这里,你都可以了解!',
        ),
        'about' => array(
            'title' 	  => '关于我们_天店通',
            'keywords' 	  => '小程序企业,小程序开发商,小程序的优势,天店通怎么样,小程序招商,小程序代理加盟,微信小程序',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交，小程序行业先驱者,品牌有实力，面向全国开启小程序招商加盟，欢迎各方人士加盟合作，共享千亿市场。',
        ),
        'help' => array(
            'title' 	  => '使用指南_天店通',
            'keywords' 	  => '小程序怎么注册,小程序怎么做,小程序教程,微信小程序教程视频,小程序招商,小程序代理加盟',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交,在这里有小程序的注册教程和使用教程视频,帮助您更快更好的了解并使用小程序!',
        ),
        'community' => array(
            'title' 	  => '社区团购-天店通',
            'keywords' 	  => '社区团购,社区团购小程序,社区团购小程序开发,微信小程序,小程序招商,小程序加盟,小程序代理',
            'description' => '天店通—国内领先的小程序开发制作平台，社区团购小程序开发无需代码，一键提交审核，社区团购小程序多种营销玩法，解决传统购物痛点',
        ),
        'toutiao' => array(
            'title' 	  => '抖音小程序-天店通',
            'keywords' 	  => '抖音小程序，头条小程序，抖音小程序开发，抖音小程序加盟',
            'description' => '天店通—国内领先的小程序开发制作平台，无需代码编辑工具，一键提交，面向全国开启小程序招商加盟，同时已开发出头条小程序_抖音小程序，欢迎各方人士加盟合作，共享千亿市场',
        ),
	),
    'offline_card'  => array(
        1   => array('name' => '周卡', 'long' => 7),
        2   => array('name' => '月卡', 'long' => 30),
        3   => array('name' => '季卡', 'long' => 90),
        4   => array('name' => '半年卡', 'long' => 180),
        5   => array('name' => '年卡', 'long' => 365),
    ),
	'offline_card_new'  => array(
		1   => array('name' => '月卡', 'long' => 30),
		2   => array('name' => '季卡', 'long' => 90),
		3   => array('name' => '半年卡', 'long' => 180),
		4   => array('name' => '年卡', 'long' => 365),
		5   => array('name' => '无期限卡', 'long' => 365*10),
	),
    'discount_card'  => array(
        1   => array('name' => '月卡', 'long' => 30),
        2   => array('name' => '季卡', 'long' => 90),
        3   => array('name' => '半年卡', 'long' => 180),
        4   => array('name' => '年卡', 'long' => 365),
        5   => array('name' => '无限期卡（默认10年）', 'long' => 365*10)
    ),
    'offline_color' => array(
        1   => array('name' => '蓝色', 'color' => 'blue'),
        2   => array('name' => '紫色', 'color' => 'purple'),
        3   => array('name' => '绿色', 'color' => 'green'),
        4   => array('name' => '橙色', 'color' => 'orange'),
    ),
	'graphic_type' => array(
		1 => '单图文',
		2 => '多图文',
	),
	'pay_channel'  => array(
		'wx_pub_qr' => '微信扫码',
		'alipay_qr' => '支付宝扫码',
        'jhpay'     => '建行收银'
	),
	//拼团规则
	'group_rule'	=> array(
		'ptpt'	=> "1、选择心仪的商品\n2、支付开团或参团\n3、等待好友参团支付\n4、达到人数组团成功",
		'cjt'	=> "1、支付开团并邀请好友参团,人数不足自动退款\n2、活动结束后从组团成功订单中随机抽取中奖者多名\n3、未中奖用户全额退款\n4、中奖商品预计24小时内发放",
		'tzyht'	=> "1、选择心仪的商品\n2、支付开团或参团\n3、等待好友参团支付\n4、达到人数组团成功\n5、团长以优惠价格开团"
	),
	'article_map' => array(
		1 => '产品中心',
		2 => '资讯中心',
		3 => '帮助中心',
		4 => '解决方案',
	),
    'news_type'=>array(
        1 => '电商资讯',
        2 => '新闻资讯',
    ),
	// 红包类型
	'redpack_type' => array(
		0  => '普通红包',
		1  => '关键词红包',
		2  => '口令红包',
		3  => '关注红包',
		4  => '裂变红包',
        5  => '二维码红包'
	),
	// 管理员状态
	'manager_status' => array(
		0 => '正常',
		1 => '申请中',
		2 => '禁用',
	),
	// 证书状态
	'ssl_status' => array(
		0 => '未支付',
		1 => '受理中',
		2 => '已颁发',
	),
    // vr订单状态
    'vr_order_status' => array(
        0 => '受理中',
        1 => '已处理',
    ),
	//商品列表展示形式
	'goodsListStyle' => array(
		1  => '大图',
		2  => '小图',
		3  => '一大两小',
		4  => '详细列表',
	),
	//积分返还类型
	'integralReturn' =>  array(
		1  => '天',
		2  => '周',
		3  => '月',
	),
    // 保证金缴纳
    'bond_status' => array(
        0   => '未交纳',
        1   => '已交纳',
        2   => '已退保',
    ),
    // 商户类型
    'merchant_type' => array(
        1  => '电商公司',
        2  => '商贸公司',
        3  => '实体门店',
        4  => '批发商',
        5  => '厂商',
        6  => '个人',
    ),
    // 店铺认证类型
    'shop_verify_type' => array(
        0  => '未认证',
        1  => '个人',
        2  => '企业',
    ),
    // 店铺保证金退保申请
    'bond_apply' => array(
        0 => '未申请',
        1 => '待审核',
        2 => '已处理',
    ),
    // 首页模板类型
    'indexTpl' => array(
        1 => '微商城专属',
        2 => '店铺私有',
        3 => '小程序专属',
        4 => 'App专属',
    ),
    // 订单提示单位
    'tipUnit'  => array(
        0 => '秒',
        1 => '分钟',
        2 => '小时',
    ),

    // 插件类型
    'promotion_tool_type' => array(
        1 => '微商城',
        2 => '小程序',
    ),
	// 帮助中心类别
	'help_center_type' => array(
		1 => '操作教程',
		2 => '常见问题',
	),

    //分销底部固定样式背景图
    'distrib_bg' => '/public/wxapp/three/qrcode.jpg',

    'member_center' => array(
        array(
            'index' => 0,
            'open' => false,
            'title' => '小金库',
            'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
        ),
        array(
            'index' => 1,
            'open' => false,
            'title' => '卡包',
            'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
        ),
        array(
            'index' => 2,
            'open' => false,
            'title' => '积分商城',
            'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
        ),
        array(
            'index' => 3,
            'open' => false,
            'title' => '会员特权',
            'imgsrc' => '/public/manage/img/zhanwei/zw_fxb_200_200.png'
        ),
    ),
    'information_card_type' => array(
        1 => '日卡',
        2 => '月卡',
        3 => '年卡'
    ),

    'shop_apply' => array(
        1 => '待审核',
        2 => '已通过',
        3 => '已拒绝'
    ),

    'plugin_pack' => array(
        21 => 1500
    ),

    'verify_record_type' => array(
        1 => array('status'=>'','desc'=>'会员/门店次卡消费核销'),
        2 => array('status'=>'order','desc'=>'门店自提/预约订单核销'),
        3 => array('status'=>'meet','desc'=>'会议报名签到核销'),
        4 => array('status'=>'reward','desc'=>'活动奖品码核销'),
        5 => array('status'=>'answer','desc'=>'答题奖品码核销'),
        6 => array('status'=>'answer','desc'=>'订单核销'),
        7 => array('status'=>'answer','desc'=>'优惠券核销'),
        8 => array('status'=>'answer','desc'=>'礼品卡核销'),
    ),

    /*
     * 奖品兑换码类型配置
     * length 随机码长度
     * flag 首字母
     */
    'reward_code_cfg' => array(
        'answer'  => array('length'=>5,'flag'=>'A'), //答题获奖
        'lottery' => array('length'=>7,'flag'=>'L'), //转盘抽奖
    ),

    /*
     * 提现审核状态
     */
    'client_withdraw_status' => array(
        0   => '审核中',
        1   => '已通过',
        2   => '已拒绝'
    ),

    /*
     * 微名片默认名片模板类型及背景图
     */
    'default_business_card' => array(
        1 => array('name'=>'类型一','img'=>'/public/wxapp/businesscard/img/card_default_new_1.png','style'=>'/public/wxapp/businesscard/img/style_img_1.png'),
        2 => array('name'=>'类型二','img'=>'/public/wxapp/businesscard/img/card_default_2.png','style'=>'/public/wxapp/businesscard/img/style_img_2.png'),
        3 => array('name'=>'类型三','img'=>'/public/wxapp/businesscard/img/card_default_new_3.png','style'=>'/public/wxapp/businesscard/img/style_img_3.png'),
        4 => array('name'=>'类型四','img'=>'/public/wxapp/businesscard/img/card_default_new_4.png','style'=>'/public/wxapp/businesscard/img/style_img_4.png'),
        5 => array('name'=>'类型五','img'=>'/public/wxapp/businesscard/img/card_default_new_5.png','style'=>'/public/wxapp/businesscard/img/style_img_5.png'),
    ),

    'default_business_card_new' => array(
        array('name'=>'类型一','type'=>3,'img'=>'/public/wxapp/businesscard/img/default_bg_1.png','style'=>'/public/wxapp/businesscard/img/style_3.png'),
        array('name'=>'类型二','type'=>2,'img'=>'/public/wxapp/businesscard/img/default_bg_2.png','style'=>'/public/wxapp/businesscard/img/style_2.png'),
       array('name'=>'类型三','type'=>3,'img'=>'/public/wxapp/businesscard/img/default_bg_3.png','style'=>'/public/wxapp/businesscard/img/style_3.png'),
        array('name'=>'类型四','type'=>3,'img'=>'/public/wxapp/businesscard/img/default_bg_4.png','style'=>'/public/wxapp/businesscard/img/style_3.png'),
        array('name'=>'类型五','type'=>1,'img'=>'/public/wxapp/businesscard/img/default_bg_5.png','style'=>'/public/wxapp/businesscard/img/style_1.png'),
    ),

    /*
     * 问答小程序问题状态
     */
    'question_status' => array(
        1 => '待回答',
        2 => '解答中',
        3 => '已解答',
        4 => '已关闭'
    ),
    /*
     * 问答小程序回答状态
     */
    'answer_status' => array(
        1 => '待获奖',
        2 => '未获奖',
        3 => '已获奖',
    ),
    /*
     * 问答小程序分享状态
     */
    'share_status' => array(
        1 => '分享中',
        2 => '分享失败',
        3 => '分享成功',
    ),

    /*
     * 新会员中心订单导航
     */
    'trade_nav' => array(
       array(
           'imgsrc' => '/public/wxapp/images/center/icon_pay.png',
           'title'  => '待付款'
       ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_fahuo.png',
            'title'  => '待发货'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_shouhuo.png',
            'title'  => '待收货'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_collect.png',
            'title'  => '退换货'
        ),
    ),

    'trade_nav_car' => array(
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_pay.png',
            'title'  => '待付款'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_fahuo.png',
            'title'  => '待核销'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_shouhuo.png',
            'title'  => '已完成'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_collect.png',
            'title'  => '售后/退款'
        ),
    ),

    /*
     * 校园跑腿会员中心订单导航
     */
    'trade_nav_handy' => array(
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_pay.png',
            'title'  => '等待中'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_fahuo.png',
            'title'  => '进行中'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_shouhuo.png',
            'title'  => '已完成'
        ),
        array(
            'imgsrc' => '/public/wxapp/images/center/icon_collect.png',
            'title'  => '未支付'
        ),
    ),

    /*
     * 后台订单筛选项
     */
    'trade_screen' => array(
        'valid' => '有效订单',
        'close' => '已关闭订单',
        'all'   => '全部订单',
        'finished'=>'已完成',
    ),

    /*
     * 资讯点赞假头像
     */
    'fake_avatar' => array(
        'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJFHwAaKDcnXgUK9rOZ4LaiaRnZD8lSszAl2q36DhvcqJIu71MMkqlXYSRM1MytTU732nmfKNw0zRQ/132',
        'https://wx.qlogo.cn/mmopen/vi_32/e1icWnXz7wFgepfaN7trOHQZLmalXwz3k9fbn9Kxl5Ztr1CY1BMMaaY8YJ2NPhmo0JU5nwRzaDswHzR9sicQibJeA/132',
        '/public/wxapp/images/applet-avatar.png',
        'https://wx.qlogo.cn/mmopen/vi_32/BqvzicuyUIWbPSZAAHhNPviagz7rxfhVat0ACvwbLYKFibadgurgmR2fL3icJh2HnbKMYVLul2mrp4cTjKO1RNfIEA/132',
        'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJgfKzsRvQwibml1bPAtqey2PwiaPeOia3HRuH2qiadetKAOHdDURAC7fm58kRzVbMHjYK49xVU61Umbg/132',
        'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIjTlXUOibjFdH0zianFjzHxJy1JagO4VJzt4gdTkjic39OwmUJe4DkcBfXrHYAHiavkXWzcBLsOYQVyA/132',
        'https://wx.qlogo.cn/mmopen/vi_32/UIuJOPKzcEIMCHQ96SibhNufIQHGqDUhtmpn8VXictqTLcRQPekCkJdkgf9PaiaeUxKkTPdqLrjq81PuzjAsW2YqQ/132',
        'https://wx.qlogo.cn/mmopen/vi_32/6N9CicT21YdwiachyIRlLA97nyaIFmU4Tq95at4dvZCFru6TdP03bEsb4QGnk5ufLiaZVdxmFZFRxkyREh9jiavjMA/132'


    ),
    /*
     * 常用链接
     */
    'url_arr' => array(
        'entershop_login' => 'http://tdot.tiandianyun.com/shop/index/enterLogin?from=shop'
    ),

    'day_time' => array(
        '01:00',
        '02:00',
        '03:00',
        '04:00',
        '05:00',
        '06:00',
        '07:00',
        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
        '18:00',
        '19:00',
        '20:00',
        '21:00',
        '22:00',
        '23:00',
    ),

	//提现方式
	'withdraw_type' => array(
		1	=> ['withdrawType'=>'bank-group','name'=>'线下银行卡提现'],
		2	=> ['withdrawType'=>'wxblance-group','name'=>'微信零钱提现'],
		3	=> ['withdrawType'=>'wxbank-group','name'=>'微信银行卡提现'],
		4	=> ['withdrawType'=>'zfbblance-group','name'=>'支付宝提现'],
	),
	//提现微信商户平台所属银行
	'withdraw_bank_ids' => array(
		'1002'	=> '中国工商银行',
		'1005'	=> '中国农业银行',
		'1026'	=> '中国银行',
		'1003'	=> '中国建设银行',
		'1001'	=> '招商银行',
		'1066'	=> '中国邮政储蓄银行',
		'1020'	=> '中国交通银行',
		'1004'	=> '浦发银行',
		'1006'	=> '民生银行',
		'1009'	=> '兴业银行',
		'1010'	=> '平安银行',
		'1021'	=> '中信银行',
		'1025'	=> '华夏银行',
		'1027'	=> '广发银行',
		'1022'	=> '光大银行',
		'1032'	=> '北京银行',
		'1056'	=> '宁波银行',
	),

    'enter_shop_plugin' => array(
        6 => [
                ['id'=>'wms','name'=>'秒杀'],
                ['id'=>'wpt','name'=>'拼团'],
                ['id'=>'wkj','name'=>'砍价'],
                ['id'=>'mfyy','name'=>'商家预约'],
               // ['id'=>'anubis','name'=>'蜂鸟配送'],
                ['id'=>'queue','name'=>'排号']
            ]
    ),

    'city_town_deduct' => [
        1 => '帖子发布',
        2 => '帖子置顶',
        3 => '店铺入驻',
        4 => '店铺续费'
    ],

    'sequence_leader_refuse' =>[
        1 => '街道不存在',
        2 => '社区不存在',
        3 => '店铺名称不符合规则',
        4 => '自提地址不符合规则',
        5 => '其它原因',
        -1 => '手动填写原因'
    ],

    'member_sort_type' => [
        'showid' => [
            'name' => '编号排序',
            'checked' => 1,
            'sort' => 'desc',
            'field' => 'm_id'
        ],
        'point' => [
            'name' => '积分排序',
            'checked' => 0,
            'sort' => 'desc',
            'field' => 'm_points'
        ],
        'coin' => [
            'name' => '余额排序',
            'checked' => 0,
            'sort' => 'desc',
            'field' => 'm_gold_coin'
        ],
        'deduct' => [
            'name' => '收益排序',
            'checked' => 0,
            'sort' => 'desc',
            'field' => 'm_deduct_amount'
        ],
        'tradenum' => [
            'name' => '订单成交总数排序',
            'checked' => 0,
            'sort' => 'desc',
            'field' => 'm_traded_num'
        ],
        'trademoney' => [
            'name' => '订单成交总额排序',
            'checked' => 0,
            'sort' => 'desc',
            'field' => 'm_traded_money'
        ],
    ],

    /*
     * 竞价页面联系方式相关配置
     */
    'page_contact_cfg' => [
        'net' => [
            'qq' => '',
            'tel' => '',
            'kefu' =>'<script>(function() {var _53code = document.createElement("script");_53code.src = "https://tb.53kf.com/code/code/6809a889dd33578aa1673d67aa49da8e/3";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(_53code, s);})();</script>'
        ],
        'cn' => [
            'qq' => '',
            'tel' => '',
            'kefu' =>'<script>(function() {var _53code = document.createElement("script");_53code.src = "https://tb.53kf.com/code/code/6809a889dd33578aa1673d67aa49da8e/1";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(_53code, s);})();</script>'
        ],
    ],

    'answerpay_cfg' => [
        'aac_expert_answer_pay' => 1,
        'aac_manager_answer_pay' => 1,
        'aac_expert_answer_price' => 0,
        'aac_manager_answer_price' => 0,
        'aac_expert_question_price' => 0,
        'aac_manager_question_price' => 0,
        'aac_expert_question_expire' => 7,
        'aac_manager_question_expire' => 7,
        'aac_expert_answer_percent' => 50,
        'aac_expert_question_percent' => 50,
        'aac_manager_answer_percent' => 50,
        'aac_manager_question_percent' => 50,
        'aac_normal_question_title' => '免费提问',
        'aac_normal_question_brief' => '免费提问 解答等待时间较长',
        'aac_normal_question_img' => '/public/wxapp/answerpay/icon_free.png',
        'aac_normal_question_open' => 1,

        'aac_expert_question_title' => '专家提问',
        'aac_expert_question_brief' => '专家提问 清晰关键 响应迅速',
        'aac_expert_question_img' => '/public/wxapp/answerpay/icon_expert.png',
        'aac_expert_question_open' => 1,

        'aac_manager_question_title' => '大V提问',
        'aac_manager_question_brief' => '免费提问 解答等待时间较长',
        'aac_manager_question_img' => '/public/wxapp/answerpay/icon_star.png',
        'aac_manager_question_open' => 1,
        'aac_question_rule' => ''
    ],

    'answerpay_manager_withdraw_cfg' => [
        'emwc_desc' => '',
        'emwc_min' => 0,
        'emwc_wx_open' => 0,
        'emwc_zfb_open' => 0,
        'emwc_bank_open' => 1,
        'emwc_rate' => 0
    ],

    'answerpay_member_withdraw_cfg' => [
        'aawc_desc' => '',
        'aawc_min' => 0,
        'aawc_wx_open' => 0,
        'aawc_zfb_open' => 0,
        'aawc_bank_open' => 1,
        'aawc_rate' => 0
    ],

    'answerpay_record_type_note' => [
        1 => '回答收入',
        2 => '围观收入',
        3 => '手续费',
    ],

    'answerpay_withdraw_type' => [
        1 => '微信提现',
        2 => '支付宝提现',
        3 => '银行卡提现'
    ],

    'agent_close_cfg' => [
        [
            'key' => 'child',
            'name' => '分身小程序',
            'link' => '/child/index',
            'val' => 0,
        ],
        [
            'key' => 'jump',
            'name' => '跳转小程序',
            'link' => '/setup/jumpList',
            'val' => 0,
        ],
        [
            'key' => 'person',
            'name' => '开发者模式',
            'link' => '/setup/person',
            'val' => 0,
        ],
        [
            'key' => 'wifi',
            'name' => 'wifi管理',
            'link' => '/city/wifiList',
            'val' => 0,
        ],
        [
            'key' => 'answer',
            'name' => '答题',
            'link' => '/answer/index',
            'val' => 0,
        ],
        [
            'key' => 'prepare',
            'name' => '预售',
            'val' => 0,
        ],
    ],

    /*
     * 退款理由
     */
    'refund_reason' => [
        '多拍/排错/不想要',
        '快递一直未送到',
        '未按约定时间发货',
        '快递无跟踪记录',
        '空包裹/少货',
        '其他'
    ],

    'active_refund_reason' => [
        0 => '无',
        1 => '尺码不对/拍错/颜色拍错',
        2 => '无货/断码',
        -1 => '其它'
    ],

    'shareposter_bg' => [
        '/public/wxapp/sequence/images/bg1.png',
        '/public/wxapp/sequence/images/bg2.png'
    ],


    //菜单类型对应数字
    'menu_type_str_num' => [
        'wxapp' => 1,
        'bdapp' => 2,
        'aliapp' => 3,
        'toutiao' => 4,
        'weixin' => 5,
        'qq' => 6,
        'qihoo' => 7
    ],

    //菜单数字对应类型
    'menu_type_num_str' => [
        1 => 'wxapp',
        2 => 'bdapp',
        3 => 'aliapp',
        4 => 'toutiao',
        5 => 'weixin',
        6 => 'qq',
        7 => 'qihoo'
    ],

    //用户来源对应类型
    'member_source_menu_type' => [
        2 => 1,//微信
        4 => 2,//百度
        3 => 3,//支付宝
        1 => 5,//公众号
        6 => 4,//抖音
        7 => 6,//qq
        8 => 7,//360
    ],

    //类型对应用户来源
    'menu_type_member_source' => [
        1 => 2,//微信
        2 => 4,//百度
        3 => 3,//支付宝
        5 => 1,//公众号
        4 => 6,//抖音
        6 => 7,//qq
        7 => 8,//360
    ],

    //抖音多店商品需审核字段
    'shop_goods_verify_field' => [
        [
            'field' => 'g_name',
            'name' => '商品名称'
        ],
        /*[
            'field' => 'g_custom_label',
            'name' => '商品标签'
        ],
        [
            'field' => 'g_list_label',
            'name' => '商品列表标签'
        ],*/
        [
            'field' => 'g_cover',
            'name' => '商品封面图'
        ],
        [
            'field' => '',
            'name' => '商品幻灯图'
        ],
        [
            'field' => 'g_parameter',
            'name' => '商品参数'
        ],
        /*[
            'field' => 'g_brief',
            'name' => '商品简介'
        ],*/
        [
            'field' => 'g_detail',
            'name' => '商品详情'
        ],
    ],

    //抖音多店 logo修改次数
    'enter_shop_logo_num' => 2,

    //校园跑腿 重量
    'handy_weight' => [
        '5斤以下',
        '5-10斤',
        '10-15斤',
        '15-20斤',
        '20斤以上'
    ],
);
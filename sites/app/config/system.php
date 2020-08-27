<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/12/19
 * Time: 下午6:08
 */
return array(
    'access_domain'     => '',//管理后台访问域名控制
    'access_control'    => array(
        'domain'    => '',
        'enter'     => '',
        'host'      => '',
        'agent'     => '',
        'keeper'    => '',
        'shop'      => '',
        'supplier'  => '', //社区团购供应商后台
        'cashier'   => 'https://www.tiandiantong.com/cashier', //收银台后台
        'broker'    => 'https://www.tiandiantong.com/broker', //刷脸付代理后台
    ),
    'price_version'     => array(
        'mfb'   => array(
            'name'      => '体验版',
            'price'     => 0,
            'origin'    => '*',
            'timeline'  => 15,//单位天
            'version'   => 'mfb',
            'right'     => array(
                '注册即赠送',
                '专属客服经理一对一服务',
                '免费体验强大营销功能',
                '丰富营销功能及小插件',
                '全面的行业一体化解决方案',
            ),
            'buy'       => 0,//无需购买
            'show'      => false,
            'plugin'    => array(),
        ),
        'sjb'   => array(
            'name'      => '免费版保证金',
            'price'     => 600,
            'origin'    => 600,
            'timeline'  => 365,//单位天
            'version'   => 'sjb',
            'right'     => array(
                '享受尊贵体验',
                '凸显品牌个性',
                '专属客服经理一对一服务',
                '丰富营销功能及小插件',
                '全面的行业一体化解决方案',
            ),
            'buy'       => 2,//直接购买
            'show'      => false,
            'plugin'    => array(),
        ),
        'hzb'   => array(
            'name'      => '合作版',
            'price'     => '加盟代理',
            'origin'    => '*',
            'timeline'  => 365,//单位天
            'version'   => 'hzb',
            'right'     => array(
                '招商加盟代理合作',
                '全面的扶持体系',
                '广阔的行业发展前景',
                '极具竞争力的代理优惠政策',
            ),
            'buy'       => 1,//协商购买
            'show'      => true,
            'plugin'    => array('sjfx'),
        ),
        'tyb'   => array(
            'name'      => '试用版',
            'price'     => 100,
            'origin'    => 600,
            'timeline'  => 30,//单位天
            'version'   => 'tyb',
            'right'     => array(
                '享受尊贵体验',
                '凸显品牌个性',
                '专属客服经理一对一服务',
                '丰富营销功能及小插件',
                '全面的行业一体化解决方案',
            ),
            'buy'       => 2,//直接购买
            'show'      => false,
            'plugin'    => array(),
        ),
        'yyb'   => array(
            'name'      => '免费版',
            'price'     => 0,
            'origin'    => 7000,
            'timeline'  => 365,//单位天
            'version'   => 'yyb',
            'right'     => array(
                '经济型选择',
                '专属客服经理一对一服务',
                '丰富营销功能及小插件',
                '全面的行业一体化解决方案',
            ),
            'buy'       => 2,//直接购买
            'show'      => true,
            'plugin'    => array(),
        ),
        'hhb'   => array(
            'name'      => '旗舰版',
            'price'     => 8800,
            'origin'    => 15000,
            'timeline'  => 365,//单位天
            'version'   => 'hhb',
            'right'     => array(
                '豪华套餐更实惠',
                '享受尊贵体验',
                '凸显品牌个性',
                '专属客服经理一对一服务',
                '丰富营销功能及小插件',
                '全面的行业一体化解决方案',
            ),
            'buy'       => 2,//直接购买
            'show'      => true,
            'plugin'    => array('sjfx', 'ptg', 'wxhb', 'ggfb', 'wkj', 'yydb', 'xsqg', 'xxmd'),
        ),
    ),
    'shop_version'  => array(
        'mfb'   => array('name' => '体验版', 'color' => '#bbb'),//创建后的版本
        'sjb'   => array('name' => '免费版', 'color' => '#f57354'),//免费使用的版本
        'hzb'   => array('name' => '合作版', 'color' => '#FF5A5A'),
        'tyb'   => array('name' => '试用版', 'color' => '#FF5A5A'),//百元体验的版本
        'yyb'   => array('name' => '免费版', 'color' => '#FF5A5A'),
        'hhb'   => array('name' => '旗舰版', 'color' => '#FF5A5A'),
    ),
    //新用户注册控制
    'reg_control'   => array(

    ),
    // 店铺赠送金币
    'give_gold' => array(
        1 => 10,     // 创建店铺成功
        2 => 100,    // 店铺缴纳保证金
        3 => 10,     // 邀请好友创建店铺
        4 => 100,    // 邀请好友缴纳保证金
        5 => 30,     // 个人认证
        6 => 50,     // 企业认证
        7 => 50,     // 购买插件
        8 => 50,     // 邀请好友购买插件
        9 => 500,    // 邀请好友购买7800套餐
    ),

    //酒店会员卡颜色
    'coupon_color' => array(
        1 => 'yellow',
        2 => 'purple',
        3 => 'pink',
    ),

    //预约小程序商品分类类型
    'reservation_category_type' => array(
        1 => '商品',
        2 => '专家'
    ),
    //预约小程序商品分类类型
    'reservation_comment_label' => array(
        '妙手回春',
        '认真负责',
        '非常专业',
        '耐心细致'
    ),
    //预约小程序订单提示
    'reservation_order_tips' => '请您按规定时间到店进行您的项目，如有特殊情况请致电客服人员',

    //工单小程序问题分类
    'work_order_type' => array(
        '咨询',
        '问题反馈'
    ),

    //工单回访时间
    'work_return_time' => array(
        '不限',
        '工作日',
        '周末'
    ),

    //社区入驻时间
    'community_enter_time' => array(
        array(
            'desc' => '3个月',
            'date' => 3 * 30
        ),
        array(
            'desc' => '半年',
            'date' => 6 * 30
        ),
        array(
            'desc' => '1年',
            'date' => 365
        ),
        array(
            'desc' => '2年',
            'date' => 365 * 2
        ),
    ),

    'vip_card'  => array(
        1   => array('name' => '周卡', 'long' => 7),
        2   => array('name' => '月卡', 'long' => 30),
        3   => array('name' => '季卡', 'long' => 90),
        4   => array('name' => '半年卡', 'long' => 180),
        5   => array('name' => '年卡', 'long' => 365),
    ),

    //社区小程序商品分类类型
    'community_comment_label' => array(
        '环境优美',
        '服务周到',
        '价格公道'
    ),
    //社区小程序店铺评分描述
    'community_score_desc' => array(
        1 => '极差',
        2 => '较差',
        3 => '一般',
        4 => '不错',
        5 => '很棒'
    ),

    // 链接类型 通用
    'link_type' => array(
        array(
          'id'   => '0',
          'name' => '无链接'
        ),
        array(
            'id'   => '1',
            'name' => '资讯详情'
        ),
        array(
            'id'   => '2',
            'name' => '列表/菜单'
        ),
        array(
            'id'   => '106',
            'name' => '小程序'
        ),
        array(
            'id'   => '3',
            'name' => 'VR全景链接'
        ),
    ),
    'link_type_sequence' => array(
        array(
            'id' => '32',
            'name' => '资讯分类'
        ),
        array(
            'id' => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '23',
            'name' => '商品分类列表(一级分类)'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表(二级分类)'
        ),
        array(
            'id'   => '29',
            'name' => '秒杀商品详情'
        ),
        array(
            'id'   => '4',
            'name' => '商品分组列表'
        ),
        array(
            'id'   => '11',
            'name' => '秒杀分组列表'
        ),
        array(
            'id'   => '61',
            'name' => '美食菜单详情'
        ),
        array(
            'id'   => '503',
            'name' => '商品活动列表'
        ),
        array(
            'id'   => '505',
            'name' => '商品分类导航页'
        ),

    ),
    'link_type_custom' => array(  //自定义模板
        array(
            'id'   => '32',
            'name' => '资讯分类'
        ),
        array(
            'id'   => '55',
            'name' => '自定义表单'
        ),
        array(
            'id'   => '56',
            'name' => '自定义模板'
        ),
    ),
    'link_type_goods' => array(   //微商城专用
        array(
            'id'   => '4',
            'name' => '商品分组列表'
        ),
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表(二级分类)'
        ),
        array(
            'id'   => '23',
            'name' => '商品分类列表(一级分类)'
        ),
        array(
            'id'   => '46',
            'name' => '付费预约详情'
        ),
        array(
            'id'   => '32',
            'name' => '资讯分类'
        )
    ),
    'link_type_limit' => array(   //微秒杀商城专用
        array(
            'id'   => '4',
            'name' => '普通分组列表'
        ),
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表'
        ),
        array(
            'id'   => '11',
            'name' => '秒杀分组列表'
        ),
        array(
            'id'   => '20',
            'name' => '店铺详情'
        ),
        array(
            'id'   => '42',
            'name' => '商家商品分组'
        ),
        array(
            'id'   => '34',
            'name' => '店铺分类'
        ),
    ),
    'link_type_meal' => array(  //微餐饮专用
        array(
            'id'   => '16',
            'name' => '店铺分类列表'
        ),
        array(
            'id'   => '43',
            'name' => '店铺详情'
        ),
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '58',
            'name' => '排号'
        ),
        array(
            'id'   => '23',
            'name' => '商品分类列表(一级分类)'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表(二级分类)'
        ),
    ),
    'link_type_group' => array(   //微拼团商城专用
        array(
            'id'   => '4',
            'name' => '普通分组列表'
        ),
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表'
        ),
        array(
            'id'   => '12',
            'name' => '拼团分组列表'
        ),
        array(
            'id'   => '20',
            'name' => '店铺详情'
        ),
        array(
            'id'   => '42',
            'name' => '商家商品分组'
        ),
        array(
            'id'   => '34',
            'name' => '店铺分类'
        ),
    ),
    'link_type_bargain' => array(   //砍价专用
        array(
            'id'   => '4',
            'name' => '普通分组列表'
        ),
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表'
        ),
        array(
            'id'   => '20',
            'name' => '店铺详情'
        ),
        array(
            'id'   => '42',
            'name' => '商家商品分组'
        ),
        array(
            'id'   => '34',
            'name' => '店铺分类'
        ),
    ),
    'link_type_reserva' => array(   //预约专用
        array(
            'id'   => '5',
            'name' => '产品服务详情'
        ),
        array(
            'id'   => '6',
            'name' => '分类列表'
        ),
        array(
            'id'   => '37',
            'name' => '专家详情'
        ),
        array(
            'id'   => '38',
            'name' => '专家分类列表'
        ),
    ),
    'link_type_weeding' => array(   //微婚纱专用
        array(
            'id'   => '7',
            'name' => '风格详情'
        ),
        array(
            'id'   => '51',
            'name' => '系列分类列表'
        ),
        array(
            'id'   => '52',
            'name' => '模特样片分类列表'
        ),
        array(
            'id'   => '53',
            'name' => '见证客片分类列表'
        ),
        array(
            'id'   => '504',
            'name' => '收银台'
        ),
        array(
            'id'   => '46',
            'name' => '付费预约'
        ),
    ),
    'link_type_driver' => array(   //微驾校专用
        array(
            'id'   => '8',
            'name' => '场地详情'
        ),
    ),
    'link_type_cake' => array(   //微门店专用
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '10',
            'name' => '商品列表'
        ),
    ),
    'link_type_house' => array(   //房产专用
        array(
            'id'   => '13',
            'name' => '房源详情'
        ),
        array(
            'id'   => '14',
            'name' => '楼盘详情'
        ),
        array(
            'id'   => '55',
            'name' => '自定义表单'
        ),
    ),

    'link_type_hotel' => array(   //酒店专用
        array(
            'id' => '32',
            'name' => '资讯分类'
        ),
        array(
            'id' => '54',
            'name' => '门店详情'
        ),
    ),
    'link_type_community' => array(   //社区专用
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '16',
            'name' => '店铺分类列表'
        ),
        array(
            'id'   => '17',
            'name' => '店铺详情'
        ),
        array(
            'id'   => '29',
            'name' => '秒杀商品详情'
        ),
        array(
            'id'   => '31',
            'name' => '砍价商品详情'
        ),
        array(
            'id'   => '30',
            'name' => '拼团商品详情'
        ),
        array(
            'id'   => '41',
            'name' => '平台商品分组'
        ),
        array(
            'id'   => '42',
            'name' => '商家商品分组'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表(二级分类)'
        ),
        array(
            'id'   => '23',
            'name' => '商品分类列表(一级分类)'
        ),
    ),
    'link_type_all_mall' => array(   //全功能商城专用
        array(
            'id'   => '29',
            'name' => '秒杀商品详情'
        ),
        array(
            'id'   => '30',
            'name' => '拼团商品详情'
        ),
        array(
            'id'   => '31',
            'name' => '砍价商品详情'
        ),
    ),
    'link_type_enterprise' => array(   //企业专用
        array(
            'id'   => '18',
            'name' => '产品服务分类'
        ),
        array(
            'id'   => '19',
            'name' => '产品服务详情'
        ),
    ),
    'link_type_city' => array(   //同城专用
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '20',
            'name' => '店铺详情'
        ),
        array(
            'id'   => '9',
            'name' => '商品分类列表(二级分类)'
        ),
        array(
            'id'   => '23',
            'name' => '商品分类列表(一级分类)'
        ),
        array(
            'id'   => '41',
            'name' => '平台商品分组'
        ),
        array(
            'id'   => '42',
            'name' => '商家商品分组'
        ),
        array(
            'id'   => '34',
            'name' => '店铺分类'
        ),
        array(
            'id' => '32',
            'name' => '资讯分类'
        ),
//        array(
//            'id' => '59',
//            'name' => '商家秒杀详情'
//        ),
//        array(
//            'id' => '60',
//            'name' => '商家砍价详情'
//        ),

    ),
    'link_type_store' => array(   //多门店专用
        array(
            'id'   => '21',
            'name' => '资讯分类'
        ),
    ),
    'link_type_legwork' => array(   //跑腿小程序
        array(
            'id'   => '32',
            'name' => '资讯分类'
        ),
    ),
    'link_type_mall' => array(   //万能商城商城专用
        array(
            'id'   => '5',
            'name' => '商品详情'
        ),
        array(
            'id'   => '22',
            'name' => '商品分类'
        ),
    ),
    'link_type_train' => array(
        array(
            'id'   => '24',
            'name' => '分类课程列表'
        ),
        array(
            'id'   => '57',
            'name' => '课程详情'
        ),
        array(
            'id'   => '55',
            'name' => '自定义表单'
        ),
    ),
    'link_type_knowledge' => array(
        array(
            'id'   => '25',
            'name' => '分类提问列表'
        ),
    ),
    'link_type_knowpay' => array(   //知识付费专用
        array(
            'id'   => '5',
            'name' => '课程详情'
        ),
        array(
            'id'   => '26',
            'name' => '分类列表'
        ),
        array(
            'id'   => '46',
            'name' => '付费预约详情'
        ),
        array(
            'id'   => '500',
            'name' => '商城商品分类列表(一级分类)'
        ),
        array(
            'id'   => '501',
            'name' => '商城商品分类列表(二级分类)'
        ),
        array(
            'id'   => '502',
            'name' => '商城商品详情'
        ),
    ),

    'link_type_job' => array(   //招聘小程序专用
        array(
            'id'   => '62',
            'name' => '职位列表（一级分类）'
        ),
        array(
            'id'   => '35',
            'name' => '职位列表（二级分类）'
        ),
        array(
            'id'   => '36',
            'name' => '职位详情'
        ),
        array(
            'id'   => '48',
            'name' => '公司详情'
        ),
        array(
            'id'   => '50',
            'name' => '公司列表'
        ),
    ),
    'link_city_mall' => array(   //同城商城
//        array(
//            'id'   => '9',
//            'name' => '商品分类列表(二级分类)'
//        ),
//        array(
//            'id'   => '23',
//            'name' => '商品分类列表(一级分类)'
//        ),
        array(
            'id'   => '27',
            'name' => '入住店铺商品详情'
        ),
        array(
            'id'   => '28',
            'name' => '入住店铺商品分类'
        ),
        array(
            'id'   => '33',
            'name' => '入住店铺商品分组'
        ),
        array(
            'id'   => '34',
            'name' => '店铺分类'
        ),
    ),
    'link_type_game' => array(  //游戏盒子
        array(
            'id'   => '39',
            'name' => '游戏列表'
        ),
        array(
            'id'   => '107',
            'name' => '小游戏'
        )
    ),
    'link_type_car' => array(   //二手车
        array(
            'id'   => '20',
            'name' => '服务商详情'
        ),
        array(
            'id'   => '45',
            'name' => '服务商分类列表'
        ),
        array(
            'id'   => '44',
            'name' => '车源详情'
        ),

    ),
    'fold_menu' => array(
        array(
            'id'   => '101',
            'name' => '客服'
        ),
        array(
            'id'   => '102',
            'name' => '电话'
        ),
        array(
            'id'   => '103',
            'name' => '分享'
        ),
        array(
            'id'   => '104',
            'name' => '菜单'
        ),
        array(
            'id'   => '105',
            'name' => '签到'
        ),
    ),

    /*
     *各版本链接地址
     */
    'link' => array(
        1 => array(     // 微商城
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/allFlGoodsPage/allFlGoodsPage',
                'name' => '全部商品分类',
            ),
            array(
                'path' => '/pages/allgoodsPage/allgoodsPage',
                'name' => '全部商品列表',
            ),
            array(
                'path' => '/pages/searchList/searchList',
                'name' => '商品搜索',
            ),
            array(
                'path' => '/subpages/couponList/couponList',
                'name' => '优惠券大厅',
            ),
            array(
                'path' => 'subpages/walletRecharge/walletRecharge?from=slide',
                'name' => '账户余额充值',
            ),
            /*拼团版商城除商城页面路劲外，增加页面路径*/
//            array(
//                'path' => '/pages/groupIndexPage/groupIndexPage',
//                'name' => '拼团页面',
//            ),
            /*秒杀版商城除商城页面路劲外，增加页面路径*/
//            array(
//                'path' => '/pages/seckillPageShow/seckillPageShow',
//                'name' => '秒杀页面',
//            ),
        ),
        2 => array(     // 拼团
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/allFlGoodsPage/allFlGoodsPage',
                'name' => '全部商品分类',
            ),
            array(
                'path' => '/pages/allgoodsPage/allgoodsPage',
                'name' => '全部商品列表',
            ),
            array(
                'path' => '/pages/searchList/searchList',
                'name' => '商品搜索',
            ),
            /*拼团版商城除商城页面路劲外，增加页面路径*/
//            array(
//                'path' => '/pages/groupIndexPage/groupIndexPage',
//                'name' => '拼团页面',
//            ),
            /*秒杀版商城除商城页面路劲外，增加页面路径*/
//            array(
//                'path' => '/pages/seckillPageShow/seckillPageShow',
//                'name' => '秒杀页面',
//            ),
        ),
        3 => array(     // 微企业
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/subpages/integralShop/integralShop',
                'name' => '积分商城',
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单',
            ),
            array(
                'path' => '/pages/commonView/commonView',
                'name' => 'VR全景',
            ),
            array(
                'path' => '/subpages/aboutus/aboutus',
                'name' => '关于我们',
            ),
            array(
                'path' => '/subpages/getReward/getReward',
                'name' => '抽奖',
            ),
            array(
                'path' => '/subpages/appletList/appletList',
                'name' => '跳转小程序',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages/telBook/telBook',
                'name' => '电话本'
            ),

        ),
        4 => array(     // 微餐饮
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/subpages/memberCard/memberCard',
                'name' => '会员卡',
            ),
            array(
                'path' => '/pages/reservation/reservation',
                'name' => '预约(单店)',
            ),
            array(
                'path' => '/pages/orderMeal/orderMeal?type=1',
                'name' => '外卖(单店)',
            ),
            array(
                'path' => '/pages/orderMeal/orderMeal?type=2',
                'name' => '堂食(单店)',
            ),
            array(
                'path' => '/pages/mulShopList/mulShopList',
                'name' => '店铺列表(多店)',
            ),
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/couponList/couponList',
                'name' => '优惠券列表',
            ),
            array(
                'path' => '/pages/voucher/voucher',
                'name' => '我的优惠券',
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单',
            ),
            array(
                'path' => '/pages/walletRecharge/walletRecharge',
                'name' => '账户余额充值',
            ),
            array(
                'path' => '/subpages/integralShop/integralShop',
                'name' => '积分商城',
            ),
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团',
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价',
            ),
            array(
                'path' => '/subpages/Generalreservation/Generalreservation',
                'name' => '付费预约',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/allgoodsPage/allgoodsPage',
                'name' => '商城商品列表'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages0/giftCard/cardhome/cardhome',
                'name' => '礼品卡首页'
            )
        ),
        5 => array(     // 秒杀
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/allFlGoodsPage/allFlGoodsPage',
                'name' => '全部商品分类',
            ),
            array(
                'path' => '/pages/allgoodsPage/allgoodsPage',
                'name' => '全部商品列表',
            ),
            array(
                'path' => '/pages/searchList/searchList',
                'name' => '商品搜索',
            ),
        ),
        6 => array(     // 微同城
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/expressCheck/expressCheck',
                'name' => '查快递',
            ),
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团',
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀',
            ),
            array(
                'path' => '/pages/release/release',
                'name' => '发帖',
            ),
            array(
                'path' => '/subpages/questionIndex/questionIndex',
                'name' => '红包来了',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价',
            ),
            array(
                'path' => '/subpages0/searchList/searchList',
                'name' => '商品列表',
            ),
            array(
                'path' => '/pages/goodslist/goodslist',
                'name' => '会员特惠商品',
            ),
            array(
                'path' => '/subpages0/auctionpage/auctionIndex/auctionIndex',
                'name' => '拍卖',
            ),
            array(
                'path' => '/subpages/memberCard/memberCard',
                'name' => '会员卡',
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单',
            ),
            array(
                'path' => '/subpages/namecard/myNamecard/myNamecard',
                'name' => '我的名片'
            ),
            array(
                'path' => '/pages/settled/settled',
                'name' => '商家入驻'
            ),
            array(
                'path' => '/subpages0/cardRank/cardRank',
                'name' => '名片榜',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages/receiveCouponCenter/receiveCouponCenter',
                'name' => '领券中心'
            ),
            array(
                'path' => '/subpages/myCoupon/myCoupon',
                'name' => '我的优惠券'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages0/activityCenter/activityCenter',
                'name' => '活动中心'
            ),

        ),
        7 => array(     // 酒店

            array(
                'name' => '付费预约',
                'path' => '/subpages/Generalreservation/Generalreservation'
            ),
            array(
                'name' => '积分商城',
                'path' => '/subpages/integralShop/integralShop'
            ),
            array(
                'name' => '会员折扣卡',
                'path' => '/subpages/buyMenberCard/buyMenberCard'
            ),
            array(
                'name' => '会员计次卡',
                'path' => '/pages/storeMemberPage/storeMemberPage'
            ),
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团',
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/allgoodsPage/allgoodsPage',
                'name' => '商城商品列表'
            ),
            array(
                'path' => '/pages/distributionCenterTab/distributionCenterTab',
                'name' => '分销中心'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages/getReward/getReward',
                'name' => '转盘抽奖'
            ),
        ),
        8 => array(     // 微社区
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/integralShop/integralShop',
                'name' => '积分商城',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价',
            ),
            array(
                'path' => '/pages/couponCenter/couponCenter',
                'name' => '平台领券大厅',
            ),
            array(
                'path' => '/pages/shopSettled/shopSettled',
                'name' => '商家入驻',
            ),
            array(
                'path' => '/pages/goodslist/goodslist',
                'name' => '会员特惠',
            ),
            array(
                'path' => '/subpages/shopgoodslist/shopgoodslist',
                'name' => '入驻店铺商品列表',
            ),
            array(
                'path' => '/subpages0/auctionpage/auctionIndex/auctionIndex',
                'name' => '拍卖',
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages/receiveCouponCenter/receiveCouponCenter',
                'name' => '领券中心'
            ),
            array(
                'path' => '/subpages0/allFlGoodsPage/allFlGoodsPage',
                'name' => '平台商品分类',
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团'
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀'
            ),
        ),
        9 => array(     // 微婚纱
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/fengge/fengge',
                'name' => '风格列表',
            ),
            array(
                'path' => '/pages/jianzheng/jianzheng',
                'name' => '见证列表',
            ),
        ),
        10 => array(     // 微驾校
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
        ),
        11 => array(     // 微名片
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/experience/experience',
                'name' => '企业介绍',
            ),
            array(
                'path' => '/pages/visitingCard/visitingCard',
                'name' => '企业名片',
            ),
            array(
                'path' => '/pages/hornor/hornor',
                'name' => '产品展示',
            ),

        ),
        12 => array(  // 微培训
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/teacherlist/teacherlist',
                'name' => '师资列表',
            ),
            array(
                'path' => '/pages/elegant/elegant',
                'name' => '学员风采',
            ),
            array(
                'path' => '/pages/school/school',
                'name' => '学校详情',
            ),
            array(
                'path' => '/pages/course/course',
                'name' => '课程列表',
            ),
            array(
                'path' => '/pages/signup/signup',
                'name' => '报名',
            ),
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团页面',
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀页面',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价页面',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages/questionIndex/questionIndex',
                'name' => '答题',
            ),
            array(
                'path' => '/subpages/distributionCenter/distributionCenter',
                'name' => '分销中心',
            ),
            array(
                'path' => '/subpages/integralShop/integralShop',
                'name' => '积分商城',
            ),
            array(
                'path' => '/pages/couponList/couponList',
                'name' => '优惠券大厅',
            ),
            array(
                'path' => '/subpages0/appletList/appletList',
                'name' => '小程序列表',
            ),
            array(
                'path' => '/subpages/memberCard/memberCard',
                'name' => '会员卡',
            ),

        ),
        13 => array(  // 微门店
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/classifyPage/classifyPage',
                'name' => '分类列表',
            ),
            array(
                'path' => '/subpages/shopDynamicPage/shopDynamicPage',
                'name' => '动态',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
        ),
        18 => array(  // 微预约
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/teams/teams',
                'name' => '团队列表',
            ),
            array(
                'path' => '/pages/casepage/casepage',
                'name' => '案例列表',
            ),
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团页面',
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀页面',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价页面',
            ),
            array(
                'path' => '/subpages/Generalreservation/Generalreservation',
                'name' => '付费预约',
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单',
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
        ),

        16 => array(  // 房产
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/houseList/houseList?source=1',
                'name' => '个人房源',
            ),
            array(
                'path' => '/pages/houseList/houseList?source=2',
                'name' => '中介房源',
            ),
            array(
                'path' => '/pages/skillHouses/skillHouses',
                'name' => '新房推荐',
            ),
            array(
                'path' => '/pages/expertHouse/expertHouse',
                'name' => '房产专家',
            ),
            array(
                'path' => '/pages/applyList/applyList?type=1',
                'name' => '求购',
            ),
            array(
                'path' => '/pages/applyList/applyList?type=2',
                'name' => '求租',
            ),
            array(
                'path' => '/pages/nearbyHouse/nearbyHouse',
                'name' => '查附近',
            ),
            array(
                'path' => '/pages/myapply/myapply',
                'name' => '商家入驻',
            ),

        ),
        21 => array(     // 微商城
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/allFlGoodsPage/allFlGoodsPage',
                'name' => '全部商品分类',
            ),
            array(
                'path' => '/pages/allgoodsPage/allgoodsPage',
                'name' => '全部商品列表',
            ),
            array(
                'path' => '/pages/searchList/searchList',
                'name' => '商品搜索',
            ),
            /*拼团版商城除商城页面路劲外，增加页面路径*/
            array(
                'path' => '/pages/groupIndexPage/groupIndexPage',
                'name' => '拼团页面',
            ),
            /*秒杀版商城除商城页面路劲外，增加页面路径*/
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀页面',
                ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价',
            ),
            array(
                'path' => '/subpages0/auctionpage/auctionIndex/auctionIndex',
                'name' => '拍卖',
            ),
            array(
                'path' => '/subpages/couponList/couponList',
                'name' => '优惠券大厅',
            ),
            array(
                'path' => '/subpages/walletRecharge/walletRecharge?from=slide',
                'name' => '账户余额充值',
            ),
            array(
                'path' => '/subpages0/fenleiGoods/fenleiGoods',
                'name' => '分类商品'
            ),
            array(
                'path' => '/subpages0/teamRedpacket/teamIndex/teamIndex',
                'name' => '组队红包'
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages/getReward/getReward',
                'name' => '转盘抽奖'
            ),
            array(
                'path' => '/subpages0/giftCard/cardhome/cardhome',
                'name' => '礼品卡首页'
            ),
            array(
                'path' => '/subpages0/goodDistribution/goodDistribution',
                'name' => '单品分销'
            ),
            array(
                'path' => '/subpages0/finefood/finefood',
                'name' => '美食区列表'
            ),

        ),

        22 => array(  // 微会议
            array(
                'path' => '/pages/getReward/getReward',
                'name' => '抽奖页面',
            ),
        ),
        24 => array(     // 万能商城
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/wnGoodsList/wnGoodsList',
                'name' => '全部商品列表',
            ),
        ),
        26 => array(     // 问答小程序
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/solvePage/solvePage',
                'name' => '发布提问',
            ),
        ),
        27 => array(     // 知识付费小程序
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/subpages/couponList/couponList',
                'name' => '领券大厅',
            ),
            array(
                'path' => '/subpages/questionIndex/questionIndex',
                'name' => '答题',
            ),
            array(
                'path' => '/subpages/activityProduct/activityProduct',
                'name' => '活动页面',
            ),
            array(
                'path' => '/subpages/searchPage/searchPage',
                'name' => '搜索页面',
            ),
            array(
                'path' => '/subpages/Generalreservation/Generalreservation',
                'name' => '付费预约',
            ),
            array(
                'path' => '/subpages/getReward/getReward',
                'name' => '抽奖',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages/signin/signin',
                'name' => '积分商城',
            ),
        ),
        28 => array(     // 内推招聘
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/jzjobList/jzjobList',
                'name' => '兼职列表'
            ),
        ),
        32 => array(     // 社区团购

            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/subpages/integralShop/integralShop',
                'name' => '积分商城',
            ),
            array(
                'path' => '/subpages/getReward/getReward',
                'name' => '抽奖',
            ),
            array(
                'path' => '/subpages/questionIndex/questionIndex',
                'name' => '答题',
            ),
            array(
                'path' => '/pages/seckillPageShow/seckillPageShow',
                'name' => '秒杀',
            ),
            array(
                'path' => '/subpages/bargainIndexPage/bargainIndexPage',
                'name' => '砍价',
            ),
            array(
                'path' => '/subpages/buyMenberCard/buyMenberCard',
                'name' => '会员卡',
            ),
            array(
                'path' => '/subpages/walletRecharge/walletRecharge',
                'name' => '余额充值',
            ),
            array(
                'path' => '/pages/applyTuan/applyTuan',
                'name' => '申请团长',
            ),
            array(
                'path' => '/subpages/supplierApply/supplierApply',
                'name' => '申请供应商',
            ),
            array(
                'path' => '/subpages0/teamRedpacket/teamIndex/teamIndex',
                'name' => '组队红包'
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单'
            ),
            array(
                'path' => '/subpages/telBook/telBook',
                'name' => '电话本'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
            array(
                'path' => '/subpages0/forumPage/forumPage',
                'name' => '帖子列表'
            ),
            array(
                'path' => '/subpages0/finefood/finefood',
                'name' => '美食区列表'
            ),
            array(
                'path' => '/subpages0/inviteFriends/inviteIndex/inviteIndex',
                'name' => '新人邀请'
            ),

        ),
        33 => array(     // 微同城
            array(
                'path' => '/pages/moreRecommend/moreRecommend',
                'name' => '推荐车源',
            ),
            array(
                'path' => '/pages/searchPage/searchPage',
                'name' => '车源搜索页',
            ),
            array(
                'path' => '/subpages/buyCar/buyCar',
                'name' => '车源列表',
            ),
            array(
                'path' => '/subpages/saleCar/saleCar',
                'name' => '发布车源',
            ),
            array(
                'path' => '/subpages/generalForm/generalForm',
                'name' => '估价',
            ),
            array(
                'path' => '/subpages/messageList/messageList',
                'name' => '私信列表',
            ),
            array(
                'path' => '/subpages/myorder/myorder',
                'name' => '我的订单',
            ),
            array(
                'path' => '/subpages/serviceCenter/serviceCenter',
                'name' => '服务商中心',
            ),
            array(
                'path' => '/subpages/inviteGift/inviteGift',
                'name' => '邀请有礼',
            ),
            array(
                'path' => '/subpages/walletRecharge/walletRecharge?from=slide',
                'name' => '充值',
            ),

        ),
        34 => array(     // 跑腿小程序
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/subpages/couponList/couponList',
                'name' => '优惠券大厅',
            ),
            array(
                'path' => '/subpages0/yearGreeting/shopGreeting/shopGreeting',
                'name' => '新年祝福'
            ),
            array(
                'path' => '/subpages0/collectGift/collectGift',
                'name' => '收藏有礼'
            ),
        ),

        36 => array(     // 社区团购

            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/applyTuan/applyTuan',
                'name' => '申请团长',
            ),
            array(
                'path' => '/pages/generalForm/generalForm',
                'name' => '自定义表单'
            ),

        ),

        50 => array(     // 微商城
            /*以下路径需拼接title字段，例：path+'?title='+title */
            array(
                'path' => '/pages/informationPage/informationPage',
                'name' => '资讯列表',
            ),
            array(
                'path' => '/pages/allFlGoodsPage/allFlGoodsPage',
                'name' => '全部商品分类',
            ),
            array(
                'path' => '/pages/allgoodsPage/allgoodsPage',
                'name' => '全部商品列表',
            ),
            array(
                'path' => '/pages/searchList/searchList',
                'name' => '商品搜索',
            ),
        ),
    ),



    'house_shortcut' => array(
        0 => array(
            'index'        => 0 ,
            'title'        => '个人房源',
            'imgsrc'       => '/public/wxapp/house/images/m1@2x.png',
            'isshow'       => true
        ),
        1 => array(
            'index'        => 1 ,
            'title'        => '中介房源',
            'imgsrc'       => '/public/wxapp/house/images/m2@2x.png',
            'isshow'       => true
        ),
        2 => array(
            'index'        => 2 ,
            'title'        => '新盘推荐',
            'imgsrc'       => '/public/wxapp/house/images/m3@2x.png',
            'isshow'       => true
        ),
        3 => array(
            'index'        => 3 ,
            'title'        => '房产专家',
            'imgsrc'       => '/public/wxapp/house/images/m4@2x.png',
            'isshow'       => true
        ),
        4 => array(
            'index'        => 4 ,
            'title'        => '求购客户',
            'imgsrc'       => '/public/wxapp/house/images/m5@2x.png',
            'isshow'       => true
        ),
        5 => array(
            'index'        => 5 ,
            'title'        => '求租客户',
            'imgsrc'       => '/public/wxapp/house/images/m6@2x.png',
            'isshow'       => true
        ),
        6 => array(
            'index'        => 6 ,
            'title'        => '商家入驻',
            'imgsrc'       => '/public/wxapp/house/images/m7@2x.png',
            'isshow'       => true
        ),
        7 => array(
            'index'        => 7 ,
            'title'        => '查附近',
            'imgsrc'       => '/public/wxapp/house/images/m8@2x.png',
            'isshow'       => true
        ),
    ),
    'house_shortcut_new' => array(
        0 => array(
            'index'        => 0 ,
            'title'        => '个人房源',
            'imgsrc'       => '/public/wxapp/house/images/m1@2x.png',
            'type'         => 6,
            'link'         => '/pages/houseList/houseList?source=1'
        ),
        1 => array(
            'index'        => 1 ,
            'title'        => '中介房源',
            'imgsrc'       => '/public/wxapp/house/images/m2@2x.png',
            'type'         => 6,
            'link'         => '/pages/houseList/houseList?source=2'
        ),
        2 => array(
            'index'        => 2 ,
            'title'        => '新盘推荐',
            'imgsrc'       => '/public/wxapp/house/images/m3@2x.png',
            'type'         => 6,
            'link'         => '/pages/skillHouses/skillHouses'
        ),
        3 => array(
            'index'        => 3 ,
            'title'        => '房产专家',
            'imgsrc'       => '/public/wxapp/house/images/m4@2x.png',
            'type'         => 6,
            'link'         => '/pages/expertHouse/expertHouse'
        ),
        4 => array(
            'index'        => 4 ,
            'title'        => '求购客户',
            'imgsrc'       => '/public/wxapp/house/images/m5@2x.png',
            'type'         => 6,
            'link'         => '/pages/applyList/applyList?type=1'
        ),
        5 => array(
            'index'        => 5 ,
            'title'        => '求租客户',
            'imgsrc'       => '/public/wxapp/house/images/m6@2x.png',
            'type'         => 6,
            'link'         => '/pages/applyList/applyList?type=2'
        ),
        6 => array(
            'index'        => 6 ,
            'title'        => '商家入驻',
            'imgsrc'       => '/public/wxapp/house/images/m7@2x.png',
            'type'         => 6,
            'link'         => '/pages/myapply/myapply'
        ),
        7 => array(
            'index'        => 7 ,
            'title'        => '查附近',
            'imgsrc'       => '/public/wxapp/house/images/m8@2x.png',
            'type'         => 6,
            'link'         => '/pages/nearbyHouse/nearbyHouse'
        ),
    ),
    /*
     * 微信提现到银行卡支持的银行
     */
    'support_bank'   => array(
        array(
            'code' => 1002,
            'bank' => '工商银行',
        ),
        array(
            'code' => 1005,
            'bank' => '农业银行',
        ),
        array(
            'code' => 1026,
            'bank' => '中国银行',
        ),
        array(
            'code' => 1003,
            'bank' => '建设银行',
        ),
        array(
            'code' => 1001,
            'bank' => '招商银行',
        ),
        array(
            'code' => 1066,
            'bank' => '邮储银行',
        ),
        array(
            'code' => 1020,
            'bank' => '交通银行',
        ),
        array(
            'code' => 1004,
            'bank' => '浦发银行',
        ),
        array(
            'code' => 1006,
            'bank' => '民生银行',
        ),
        array(
            'code' => 1009,
            'bank' => '兴业银行',
        ),
        array(
            'code' => 1010,
            'bank' => '平安银行',
        ),
        array(
            'code' => 1021,
            'bank' => '中信银行',
        ),
        array(
            'code' => 1025,
            'bank' => '华夏银行',
        ),
        array(
            'code' => 1027,
            'bank' => '广发银行',
        ),
        array(
            'code' => 1022,
            'bank' => '光大银行',
        ),
        array(
            'code' => 1032,
            'bank' => '北京银行',
        ),
        array(
            'code' => 1056,
            'bank' => '宁波银行',
        ),
    ),

    'defaultName' => '给您拜年啦！',
    'defaultContent' => '猪年正朝气蓬勃的向您走来，愿您猪年吉祥，好运如潮，意气风发，万事顺心，财源滚滚，福寿百年，吉祥平安，人旺运旺，阖家欢乐，万事如意！',
    'blessingMusic' => array(
        1 => 'http://pxsp.tiandiantong.net/music1.mp3',
        2 => 'http://pxsp.tiandiantong.net/music2.mp3',
        3 => 'http://pxsp.tiandiantong.net/music3.mp3',
        4 => 'http://pxsp.tiandiantong.net/music4.mp3',
        5 => 'http://pxsp.tiandiantong.net/music5.mp3',
    ),
);
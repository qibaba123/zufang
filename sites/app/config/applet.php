<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/3
 * Time: 上午10:32
 */
return array(
    //公众号第三方平台信息配置
    'platform'  => array(
        'app_id'        => '',
        'app_secret'    => '',
        'verify_token'  => '',
        'crypt_key'     => '',
    ),
    'func_scope'    => array(
        17       => array(
            'name'  => '帐号管理权限',
            'desc'  => ''
        ),
        18       => array(
            'name'  => '开发管理权限',
            'desc'  => ''
        ),
        19       => array(
            'name'  => '客服消息管理权限',
            'desc'  => ''
        ),
        25       => array(
            'name'  => '开放平台帐号管理权限',
            'desc'  => ''
        ),
        30       => array(
            'name'  => '小程序基本信息设置权限',
            'desc'  => ''
        ),
        31       => array(
            'name'  => '小程序认证权限',
            'desc'  => ''
        ),
        36       => array(
            'name'  => '微信卡路里权限',
            'desc'  => ''
        ),
        37       => array(
            'name'  => '附近地点权限',
            'desc'  => ''
        ),
        40       => array(
            'name'  => '插件管理权限',
            'desc'  => ''
        ),
        41       => array(
            'name'  => '搜索widget权限',
            'desc'  => ''
        ),
    ),
    //行业模块
    'category'  => array(
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        8   => array(
            'logo'  => 'icon-weishequ',
            'name'  => '多店平台',
            'brief' => '小程序社区在微信生态系统的框架下，让交流、互动更加便捷、快速。',
            'link'  => '',
            'tag'   => '超级平台',
            'test'  => array(
                'account'   => '17555555555',
                'password'  => '17555555555',
            ),
            'price' => 5000,
            'priced'=> '￥5000/年',
            'guidePrice' => '￥5000/年',
            'suggestPrice' => '￥9980/年',        // 建议售价
            'saleprice'     => 9980,
            'enable'=> true, 
            'plugin' => false,
            'version'   => '3.7.0',
            'base'      => 270,
            'desc'      => '店铺详情购物车入口添加数量显示',
            'codeid'    => 1260,//代码模板ID
            'tpl'       => array(35),//首页模板ID
            'download'  => 'http://tiandiantong.oss-cn-beijing.aliyuncs.com/tdtwsq.zip',
            'platform'  => 'wxtdt',
            'tplimg'    => 'weishequ.png'   //模板导图图片v
        ),
        
        21   => array(
            'logo'  => 'icon-duogongneng',
            'name'  => '营销商城',
            'brief' => '营销商城底板价，可接入收费插件',
            'link'      => '',
            'tag'   => '全功能版',
            'test'  => array( 
                'account'   => '18999999999',
                'password'  => '18999999999',
            ),
            'price'     =>  1500,
            'priced'    => '￥1500/年',
            'guidePrice'=> '￥1500/年',        //最低指导价
            'suggestPrice' => '￥8999/年',        // 建议售价
            'saleprice'     => 8999,
            'enable'    => true,
            'plugin' => false,
            'version'   => '4.6.5',
            'base'      => 465,				   //base之前写错，未保证版本正常升级，写为和版本一样
            'desc'      => '编辑地址调整及部分细节问题调整优化', 
            'codeid'    => 1289,//代码模板ID
            'tpl'       => array(3,4,15,16,17,18,19),   //全功能商城首页模板ID
            'download'  => 'http://tiandiantong.oss-cn-beijing.aliyuncs.com/tdtqgnwsc.zip',
            'platform'  => 'wxtdt',
            'tplimg'    => 'duogongneng.png'   //模板导图图片v
        ),
        27   => array(
            'logo'  => 'icon-lore',
            'name'  => '知识付费',
            'brief' => '借助小程序强力搭建知识付费新生态，支持图文、音频和视频，并可快速传播',
            'link'  => '',
            
            
            
                    // 建议售价
            
            
            
            'plugin' => true, 
            
            
            'desc'      => '菜单导航链接新增分类商品页面 支付参数优化',
            //代码模板ID
            'menu'  => array(),
            'indexTpl'  => 59, // 首页默认模板
            'tpl'  => array(59,65), // 首页默认模板
            
            
            'tplimg'    => 'zhishifufei.png'   //模板导图图片v
        ),
        
        
        
        
        
        
        

        
        //社区团购删减版
        

        


        
        // 连云港房产使用，其他使用上面16
        
    ),

    'manager_menu' => array(
        array(
            'title'     => '权限设置',
            'link'      => '/manager/managerList',
            'icon'      => 'fa-cog',
            'access'    => 'manager-managerList',
        ),
    ),
    // 知识付费价格
    'knowledge_price' => array(
        1 => 3980,     // 1年3980，
        2 => 7160,     // 2年 价格  7160
        3 => 9560,     // 3年 价格  9550
    ),
    /**
     * 微企业服务资讯分类
     */
    'service_type' => array(
        1 => '服务',
        2 => '资讯'
    ),
    /**
     * 微婚纱样片分类
     */
    'sample_type' => array(
        1 => '模特样片',
        2 => '客户样片'
    ),
    'icon_type'     => array(
        1   => '暖色系',
        2   => '冷色系',
    ),
    /**
     * 微点餐活动类型
     */
    'activity_type' => array(
        1 => '满减',
        2 => '新用户',
        3 => '公告',
    ),
    /**
     * 微酒店订单评价标签
     */
    'hotel_comment_label' => array(
        0 => '干净整洁',
        1 => '交通便利',
        2 => '环境优美',
        3 => '宾至如归',
    ),

    'hotel_home_desc' => array(
        'prepay' => '预定酒店后立即向酒店在线支付房费',
        'cancel' => '您在23:59前取消或变更订单，酒店将扣取您首晚房费作为违约费用；如果您在23:59之后取消或变更，酒店将收取全额房费作为违约费用',
        'inland' => '须持二代身份证入住',
        'remind' => '酒店于住店当天13:00办理入住，离店当天13:00办理退房，如您在13:00前到达，可能需要等待方能入住，具体以酒店安排为准。'
    ),

    'hotel_order_status_desc' => array(
        1 => '请您及时支付，超时后订单将自动取消',
        2 => '订单待支付确认',
        3 => '酒店于13:00办理入住，如需提早办理请联系商家',
        6 => '您的订单已完成',
        7 => '订单已关闭'
    ),
    /**
     * 微同城帖子置顶时间
     */
    'top_time' => array(
        1 => array(
            'name' => '1天',
            'date' => 1,
            'time' => 60*60*24,
            'amount' => 0.02
        ),
        2 => array(
            'name' => '7天',
            'date' => 7,
            'time' => 60*60*24*7,
            'amount' => 0.03
        ),
        3 => array(
            'name' => '30天',
            'date' => 30,
            'time' => 60*60*24*30,
            'amount' => 0.04
        ),
    ),
    /**
     * 房产装修类型
     */
    'house_fitment_type' => array(
        '毛坯',
        '普通',
        '中档',
        '精装',
        '豪装'
    ),
    /**
     * 房产房间朝向
     */
    'house_orientation' => array(
        '南北(通透)',
        '东西',
        '东户(边户)',
        '西户(边户)',
        '朝南',
        '朝北',
        '其它'
    ),
    /**
     * 房产房间类型
     */
    'house_type' => array(
        '住宅',
        '公寓',
        '别墅',
        '写字楼',
        '商铺',
        '厂房',
        '商住一体'
    ),
    /**
     * 房产举报原因
     */
    'house_report_reason' => array(
        '房源无法带看',
        '图片与实际不符',
        '价格与实际差异较大',
        '房源不在该小区',
        '其它'
    ),
    /**
     * 房产几室
     */
    'house_room_num' => array(
        array(
            'num' => 1,
            'desc'     => '一室'
        ),
        array(
            'num' => 2,
            'desc'     => '二室'
        ),
        array(
            'num' => 3,
            'desc'     => '三室'
        ),
        array(
            'num' => 4,
            'desc'     => '四室'
        ),
    ),
    /*
     * 楼盘状态
     */
    'building_status' => array(
        0 => '预售',
        1 => '在售',
        2 => '售罄',
    ),
    /**
     * 房产房源状态
     */
    'house_status' => array('审核','实勘','推荐'),
    /**
     * 房产价格区间
     */
    'house_sale_price' => array(
        array(
            'minPrice' => 0,
            'maxPrice' => 40,
            'desc'     => '40万以下'
        ),
        array(
            'minPrice' => 40,
            'maxPrice' => 60,
            'desc'     => '40-60万'
        ),
        array(
            'minPrice' => 60,
            'maxPrice' => 80,
            'desc'     => '60-80万'
        ),
        array(
            'minPrice' => 100,
            'maxPrice' => 150,
            'desc'     => '100-150万'
        ),
        array(
            'minPrice' => 150,
            'maxPrice' => 0,
            'desc'     => '150万以上'
        )
    ),
    /**
     * 房产出租价格区间
     */
    'house_rent_price' => array(
        array(
            'minPrice' => 0,
            'maxPrice' => 500,
            'desc'     => '500以下'
        ),
        array(
            'minPrice' => 501,
            'maxPrice' => 1000,
            'desc'     => '500-1000元'
        ),
        array(
            'minPrice' => 1001,
            'maxPrice' => 2000,
            'desc'     => '1000-2000元'
        ),
        array(
            'minPrice' => 2001,
            'maxPrice' => 3000,
            'desc'     => '2000-3000元'
        ),
        array(
            'minPrice' => 3001,
            'maxPrice' => 5000,
            'desc'     => '3000-5000元'
        ),
        array(
            'minPrice' => 5001,
            'maxPrice' => 10000,
            'desc'     => '5000-10000元'
        ),
        array(
            'minPrice' => 10001,
            'maxPrice' => 0,
            'desc'     => '10000元以上'
        )
    ),

    /**
     * 房产楼盘价格区间
     */
    'house_property_price' => array(
        array(
            'minPrice' => 0,
            'maxPrice' => 10000,
            'desc'     => '1万以下'
        ),
        array(
            'minPrice' => 10000,
            'maxPrice' => 20000,
            'desc'     => '1-2万'
        ),
        array(
            'minPrice' => 20000,
            'maxPrice' => 30000,
            'desc'     => '2-3万'
        )
    ),

    /**
     * 房产面积区间
     */
    'house_area' => array(
        array(
            'minArea' => 0,
            'maxArea' => 90,
            'desc'     => '0-90㎡'
        ),
        array(
            'minArea' => 91,
            'maxArea' => 120,
            'desc'     => '90-120㎡'
        ),
        array(
            'minArea' => 121,
            'maxArea' => 160,
            'desc'     => '120-160㎡'
        ),
        array(
            'minArea' => 161,
            'maxArea' => 0,
            'desc'     => '160㎡以上'
        )
    ),

    /**
     * 经营分类
     */
    'house_enter_business' => array('房产中介', '装修', '家政', '建材销售', '品牌家居', '灯饰卫浴', '家具家电', '开发商'),

    /**
     * 房产合作商类型
     */
    'partner_type' => array(
        1 => '品牌入驻',
        2 => '品牌合作伙伴',
        3 => '品牌中介联盟'
    ),
    /**
     * 行业案例和教程链接配置
     */
    'case_help' => array(
        1   => array(
            'name'  => '商城版',
            'helpUrl' => 'http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=222&extra=',
            'case'    => array(//小程序案例码
                array(
                    'name'    => '天店通',
                    'logo'    => 'wsc/logo_tdt.png',
                    'case'    => 'wsc/case_tdt.jpg'
                ),
                array(
                    'name'    => '依萌云商',
                    'logo'    => 'wsc/logo_ymys.jpg',
                    'case'    => 'wsc/case_ymys.jpg'
                ),
            )  
        ),
        2   => array(
            'name'  => '微拼团',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )  
        ),
        3   => array(
            'name'  => '企业版',
            'helpUrl' => 'http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=221&extra=page%3D1',
            'case'    => array(//小程序案例码
                array(
                    'name'    => '天点科技',
                    'logo'    => 'wqy/logo_tdkj.jpg',
                    'case'    => 'wqy/case_tdkj.jpg'
                ),
                array(
                    'name'    => '安徽商会',
                    'logo'    => 'wqy/logo_ahsh.jpg',
                    'case'    => 'wqy/case_ahsh.jpg'
                ),
            )   
        ),
        4   => array(
            'name'  => '微点餐',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )  
        ),
        5   => array(
            'name'  => '微预约',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )  
        ),
        6   => array(
            'name'  => '微同城',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )  
        ),
        7   => array(
            'name'  => '微酒店',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )  
        ),
        8   => array(
            'name'  => '微社区',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )   
        ),
        9   => array(
            'name'  => '婚纱摄影版',
            'helpUrl' => 'http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=224&extra=page%3D1',
            'case'    => array(//小程序案例码
                array(
                    'name'    => '罗马假日',
                    'logo'    => 'whs/logo_lmjr.jpg',
                    'case'    => 'whs/case_lmjr.jpg'
                ),
                array(
                    'name'    => '自然一派',
                    'logo'    => 'whs/logo_zryp.jpg',
                    'case'    => 'whs/case_zryp.jpg'
                ),
            )   
        ),
        10   => array(
            'name'  => '驾校版',
            'helpUrl' => 'http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=227&extra=page%3D1',
            'case'    => array(//小程序案例码
                array(
                    'name'    => '微驾校',
                    'logo'    => 'wjx/logo_tdt.png',
                    'case'    => 'wjx/case_tdt.jpg'
                ),
                array(
                    'name'    => '快捷驾校',
                    'logo'    => 'wjx/logo_kjjx.jpg',
                    'case'    => 'wjx/case_kjjx.jpg'
                ),
            )   
        ),
        11   => array(
            'name'  => '名片版',
            'helpUrl' => 'http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=225&extra=page%3D1',
            'case'    => array(//小程序案例码
                array(
                    'name'    => '微名片',
                    'logo'    => 'wmp/logo_tdt.png',
                    'case'    => 'wmp/case_tdt.jpg'
                ),
            )  
        ),
        12   => array(
            'name'    => '培训版',
            'helpUrl' => 'http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=226&extra=page%3D1',
            'case'    => array(//小程序案例码
                array(
                    'name'    => '微培训',
                    'logo'    => 'wpx/logo_tdt.png',
                    'case'    => 'wpx/case_tdt.jpg'
                ),
            )  
        ),
        13   => array(
            'name'    => '门店版',
            'helpUrl' => '',
            'case'    => array(//小程序案例码

            )  
        ),
    ),
);
<?php
return array(
    //文章信息类型
    'rewrite'  => array(
        //事件类型MsgType
        'event' => array( 'controller' => 'App_Controller_Weixin_EventController', 'action' => 'indexAction' ),
        //文本类型MsgType
        'text'  => array( 'controller' => 'App_Controller_Weixin_TextController', 'action' => 'indexAction' ),
    ),
    'shield_domain' => 'www.ykuaiqian.com',//防止被微信屏蔽的域名
    /*
     * array_keys();获取所有键名
     */
    'menu'  => array(
        'click'     => array(
            'id'    => 1,
            'type'  => 'click',
            'extra' => 'key',
        ),
        'view'     => array(
            'id'    => 2,
            'type'  => 'view',
            'extra' => 'url',
        ),
        'scancode_push'     => array(
            'id'    => 3,
            'type'  => 'scancode_push',
            'extra' => 'key',
        ),
        'scancode_waitmsg'     => array(
            'id'    => 4,
            'type'  => 'scancode_waitmsg',
            'extra' => 'key',
        ),
        'pic_sysphoto'     => array(
            'id'    => 5,
            'type'  => 'pic_sysphoto',
            'extra' => 'key',
        ),
        'pic_photo_or_album'     => array(
            'id'    => 6,
            'type'  => 'pic_photo_or_album',
            'extra' => 'key',
        ),
        'pic_weixin'     => array(
            'id'    => 7,
            'type'  => 'pic_weixin',
            'extra' => 'key',
        ),
        'location_select'     => array(
            'id'    => 8,
            'type'  => 'location_select',
            'extra' => 'key',
        ),
        'media_id'     => array(
            'id'    => 9,
            'type'  => 'media_id',
            'extra' => 'media_id',
        ),
        'view_limited'     => array(
            'id'    => 10,
            'type'  => 'view_limited',
            'extra' => 'media_id',
        ),
    ),
    //公众号第三方平台信息配置
    'platform'  => array(
        'app_id'        => '',
        'app_secret'    => '',
        'verify_token'  => '',
        'crypt_key'     => '',
    ),
    'auth_login'    => array(
        'app_id'        => '',
        'app_secret'    => '',
    ),
    'web_login'    => array(
        'app_id'        => '',
        'app_secret'    => '',
    ),
    'xcx_login'     => array(
        'app_id'        => '',
        'app_secret'    => '',
    ),

    // 天店通微信支付配置
    'fxb_pay'   => array(
    ),
    //服务商模式下的微信支付配置
    'sub_pay'   => array(
    ),
    'scope_type'    => array(
        'info' => 'snsapi_userinfo',
        'base' => 'snsapi_base',
        'none' => false,
    ),
    //通用输出JSAPI的店铺id
    'common_jsapi_sid'  => 11,
    //点击事件枚举
    'click_enum'    => array(
        'plum_hqtgewm'       => array(
            'text'      => '获取推广二维码',
            'method'    => '_fetch_spread_qrcode'
        ),
        'plum_hyzy'       => array(
            'text'      => '会员主页',
            'method'    => '_center_index'
        ),
        'plum_dpzy'       => array(
            'text'      => '店铺主页',
            'method'    => '_shop_index'
        ),
        'plum_gwc'       => array(
            'text'      => '购物车',
            'method'    => '_shop_cart'
        ),
        'plum_fxzx'       => array(
            'text'      => '分销中心',
            'method'    => '_member_index'
        ),
        'plum_ddzx'       => array(
            'text'      => '订单中心',
            'method'    => '_center_myorder'
        ),
        'plum_qdlqjf'     => array(
            'text'      => '签到领取积分',
            'method'    => '_sign_gain_point'
        ),
    ),
    'wxpay_point'   => 0.006,
    'func_scope'    => array(
        1       => array(
            'name'  => '消息管理权限',
            'desc'  => ''
        ),
        2       => array(
            'name'  => '用户管理权限',
            'desc'  => ''
        ),
        3       => array(
            'name'  => '帐号服务权限',
            'desc'  => ''
        ),
        4       => array(
            'name'  => '网页服务权限',
            'desc'  => ''
        ),
        5       => array(
            'name'  => '微信小店权限',
            'desc'  => ''
        ),
        6       => array(
            'name'  => '微信多客服权限',
            'desc'  => ''
        ),
        7       => array(
            'name'  => '群发与通知权限',
            'desc'  => ''
        ),
        8       => array(
            'name'  => '微信卡券权限',
            'desc'  => ''
        ),
        9       => array(
            'name'  => '微信扫一扫权限',
            'desc'  => ''
        ),
        10       => array(
            'name'  => '微信连WIFI权限',
            'desc'  => ''
        ),
        11       => array(
            'name'  => '素材管理权限',
            'desc'  => ''
        ),
        12       => array(
            'name'  => '微信摇周边权限',
            'desc'  => ''
        ),
        13       => array(
            'name'  => '微信门店权限',
            'desc'  => ''
        ),
//        14       => array(
//            'name'  => '微信支付权限',
//            'desc'  => ''
//        ),
        15       => array(
            'name'  => '自定义菜单权限',
            'desc'  => ''
        ),
    ),
    //自动回复消息设置
    'auto_reply'   => array(
        'name'      => '自动回复消息设置',
        'default'   => "欢迎加入。",
        'usable'    => array('{插入ID号}', '{插入会员昵称}', '{插入店铺名}'),
    ),
    'redpack_txt'   => array(
        //关注红包
        'follow'    => array(
            'blw'   => '您来晚了,红包已经被领完了',
            'ffcg'  => '红包已发放成功,请注意查收',
        ),
        //关键词红包
        'keyword'   => array(
            'wks'   => '来早了,红包活动尚未开始',
            'yjs'   => '来晚了,红包活动已经结束了',
            'blw'   => '您来晚了,红包已经被领完了',
            'cflq'  => '您已领取过红包,不要贪心噢!',
            'ffcg'  => '红包已发放成功,请注意查收',
        ),
        //口令红包
        'command'   => array(
            'wks'   => '来早了,红包活动尚未开始',
            'yjs'   => '来晚了,红包活动已经结束了',
            'ysy'   => '领取失败,口令已被使用',
            'lqcx'  => '领取失败,您领取的数量已经超限了',
            'ffcg'  => '红包已发放成功,请注意查收',
        ),
        //裂变红包
        'fission'   => array(
            'wks'   => '来早了,红包活动尚未开始',
            'yjs'   => '来晚了,红包活动已经结束了',
            'blw'   => '您来晚了,红包已经被领完了',
            'cflq'  => '您已领取过红包,不要贪心噢!',
            'ffcg'  => '红包已发放成功,请注意查收',
        ),
        'qrcode'   => array(
            'wks'   => '来早了,红包活动尚未开始',
            'yjs'   => '来晚了,红包活动已经结束了',
            'ysy'   => '领取失败,红包口令已被使用',
            'lqcx'  => '领取失败,您领取的数量已经超限了',
            'ffcg'  => '红包已发放成功,请注意查收',
        ),
    ),
);
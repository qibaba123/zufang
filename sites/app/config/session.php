<?php

return array(
    'site'  => array(
        //session文件保存路径
        'save_path'     => PLUM_DIR_SESSION . '/site',
        //是否使用cookie来存储session会话ID
        'use_cookies'   => 1,
        //是否仅使用cookie来存储session会话ID
        'use_only_cookies'  => 1,
        //cookie名称
        'cookie_name'   => 'plum_session_site',
        //是否开启垃圾自动回收机制，默认为true
        'gc_open'       => true,
        //session文件被当做垃圾回收的概率 2/1000
        'lottery'       => array(2, 1000),
        //session文件及cookie的最大存活时间，单位分钟
        'lifetime'      => 30*24*60,//设计为30天存储时间
        //浏览器关闭时，cookie是否失效
        'expire_on_close' => true,
        //设定会话cookie的路径
        'path'          => '/',
        //设定会话cookie的域名
        'domain'        => null,
        //设定是否仅通过安全链接发送会话cookie
        'secure'        => 0,
    ),
    //会员模块session配置
    'mobile'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/mobile',
        'use_cookies'   => 1,//使用cookie存储sessionID
        'use_only_cookies'  => 0,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_mobile',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 30 * 24 * 60,//30天
        'expire_on_close' => true,
        'path'          => '/mobile',
        'domain'        => null,
        'secure'        => 0,
    ),
    //会员模块session配置
    'merchant'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/merchant',
        'use_cookies'   => 1,//使用cookie存储sessionID
        'use_only_cookies'  => 0,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_merchant',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 30 * 24 * 60,//30天
        'expire_on_close' => true,
        'path'          => '/merchant',
        'domain'        => null,
        'secure'        => 0,
    ),
    //管理模块session配置
    'manage'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/manage',
        'use_cookies'   => 1,//使用cookie存储sessionID
        'use_only_cookies'  => 1,//不允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_manage',
        'gc_open'       => true,
        'lottery'       => array(1, 2000),
        'lifetime'      => 30 * 24 * 60,//30天
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    //代理商模块session配置
    'agent'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/agent',
        'use_cookies'   => 1,//使用cookie存储sessionID
        'use_only_cookies'  => 1,//不允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_agent',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 3 * 24 * 60,//3天
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    'api'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/api',
        'use_cookies'   => 0,//禁用cookie存储sessionID
        'use_only_cookies'  => 0,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_api',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 365 * 24 * 60,//一年
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    'client'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/client',
        'use_cookies'   => 0,//禁用cookie存储sessionID
        'use_only_cookies'  => 0,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_client',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 365 * 24 * 60,//一年
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    //跑腿APP session
    'legwork'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/legwork',
        'use_cookies'   => 0,//禁用cookie存储sessionID
        'use_only_cookies'  => 0,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_legwork',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 365 * 24 * 60,//一年
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    'applet'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/applet',
        'use_cookies'   => 0,//禁用cookie存储sessionID
        'use_only_cookies'  => 0,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_applet',
        'gc_open'       => false,
        'lottery'       => array(1, 1000),
        'lifetime'      => 30 * 24 * 60,//一月
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    // 小程序入驻商家后台
    'shop'  => array(
        'save_path'     => PLUM_DIR_SESSION . '/shop',
        'use_cookies'   => 1,//禁用cookie存储sessionID
        'use_only_cookies'  => 1,//允许通过URL传递sessionID
        'cookie_name'   => 'plum_session_shop',
        'gc_open'       => true,
        'lottery'       => array(1, 1000),
        'lifetime'      => 30 * 24 * 60,//一月
        'expire_on_close' => true,
        'path'          => '/',
        'domain'        => null,
        'secure'        => 0,
    ),
    //加解密形式实现session机制的配置
    'auth'  => array(
        'cookie_name'   => 'plum_session_auth',
        'auth_token'    => PLUM_AUTH_TOKEN,//也可自定义
        'uid_key'       => 'uid',//用户id的key
    ),
    // 供应商后台登录session 设置
    'supplier'=>array(
        //session文件保存路径
        'save_path'     => PLUM_DIR_SESSION . '/supplier',
        //是否使用cookie来存储session会话ID
        'use_cookies'   => 1,
        //是否仅使用cookie来存储session会话ID
        'use_only_cookies'  => 1,
        //cookie名称
        'cookie_name'   => 'plum_session_site',
        //是否开启垃圾自动回收机制，默认为true
        'gc_open'       => true,
        //session文件被当做垃圾回收的概率 2/1000
        'lottery'       => array(2, 1000),
        //session文件及cookie的最大存活时间，单位分钟
        'lifetime'      => 30*24*60,//设计为30天存储时间
        //浏览器关闭时，cookie是否失效
        'expire_on_close' => true,
        //设定会话cookie的路径
        'path'          => '/',
        //设定会话cookie的域名
        'domain'        => null,
        //设定是否仅通过安全链接发送会话cookie
        'secure'        => 0,
    ),
);
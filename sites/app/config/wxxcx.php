<?php
return array(
    //文章信息类型
    'rewrite'  => array(
        //事件类型MsgType
        'event' => array( 'controller' => 'App_Controller_Wxxcx_EventController', 'action' => 'indexAction' ),
        //文本类型MsgType
        'text'  => array( 'controller' => 'App_Controller_Wxxcx_TextController', 'action' => 'indexAction' ),
        //图片类型MsgType
        'image' => array( 'controller' => 'App_Controller_Wxxcx_ImageController', 'action' => 'indexAction' ),
    ),
    'encode_token'  => '',
    'qcloud_token'  => '',
    'domain'    => array(
    ),
    //微信小程序管理后台进入允许域名,百度小程序管理后台允许进入域名
    'wxapp_in'  => array(),
    //微信小程序业务域名(VR视频使用)
    'business_domain' => array(),
    //微信卡券授权域名
    'wxcode_auth'   => 'www.com',
    'platform'  => array(
    ),
    'server'    => array(),
    'group' => array(
    ),
    'notify_url' => 'http://shopping.zhjl.link'
);
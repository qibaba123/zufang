<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/4/26
 * Time: 下午6:37
 */

return array(
    //云之讯短信相关配置
    'ucpaas'    => array(
        'account_sid'   => '',
        'auth_token'    => '',
        'app_id'        => '',
        'valid_time'	=> 60*60,//六十分钟有效期
        //'template_id'   => 43322,  //签名《天店通》
        'template_id'   => '',   //签名《小程序平台》
        'template_txt'  => '您的验证码：{1}，如非本人操作，请忽略本短信。',
        'unit_price'    => 0.06,   // 单位元
        //通知类短信模板
        'notice_tpl'    => array(
            'ddzfcg'    => array(
                'tit'   => '订单支付成功通知',
                'tid'   => '43473',
                'txt'   => '新订单通知，会员{1}购买的{2}商品已支付成功，订单编号{3}，请尽快安排发货。',
            ),
            'ddwctz'    => array(
                'tit'   => '订单完成通知',
                'tid'   => '43474',
                'txt'   => '订单完成通知，会员{1}购买的{2}商品，订单号{3}已确认收货，订单已完成。',
            ),
            'sqtktz'    => array(
                'tit'   => '申请退款通知',
                'tid'   => '43579',
                'txt'   => '买家{1}对{2}订单进行退款申请，请您对订单{3}退款及时处理！',
            ),
            'mjfhtz'    => array(
                'tit'   => '订单发货通知',
                'tid'   => '43581',
                'txt'   => '您在{1}购买的商品{2}，卖家已经发货，请及时关注物流动态。',
            ),
            'tytktz'    => array(
                'tit'   => '同意退款通知',
                'tid'   => '43583',
                'txt'   => '您在{1}对订单{2}提交的退款申请，卖家已同意退款，请及时查看资金流向。',
            ),
            'jjtktz'    => array(
                'tit'   => '拒绝退款通知',
                'tid'   => '43585',
                'txt'   => '您在{1}提交的订单号{2}的退款申请，卖家拒绝退款，拒绝原因是{3}，请及时与卖家进行沟通。',
            ),
            'xcxyytz'    => array(
                'tit'   => '小程序预约通知',
                'tid'   => '149350',
                'txt'   => '您的小程序《{1}》收到新的预约留言，请及时登录管理后台查看处理，退订回TD',
            ),
            'xcxsqrz'    => array(
                'tit'   => '小程序店铺入驻提醒',
                'tid'   => '282927',
                'txt'   => '您管理的小程序《{1}》有新的店铺申请入驻，请及时登录管理后台查看处理。',
            ),
            'wmddpstz'    => array(
                'tit'   => '外卖配送通知',
                'tid'   => '359061',
                'txt'   => '您在{1}预订的外卖{2}，商家正在配送中，请保持手机畅通',
            ),
            'kfxxtz'    => array(
                'tit'   => '客服消息提醒',   //用户同意绑定手机号
                'tid'   => '367751',
                'txt'   => '您管理的《{1}》有新的用户咨询，请及时登录管理后台查看处理',
            ),
            'zxxcxtz'    => array(
                'tit'   => '咨询小程序制作',   //用户提交信息咨询
                'tid'   => '380904',
                'txt'   => '您收到新的制作{1}咨询消息请及时联系',
            ),
            'xcxxftz'   => array(
                'tit'   => '续费通知',
                'tid'   => '396408',
                'txt'   => '您开通的应用在{1}有{2}即将到期，请及时登录代理商后台续费以免影响使用。'
            ),
        ),
    ),
);
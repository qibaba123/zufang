<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 10:11:59
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/shareposter/seckill-share.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12585888665e4f3c6f1bd116-98260968%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0668a4a180951a4d50d74ba607f459665d3472eb' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/shareposter/seckill-share.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12585888665e4f3c6f1bd116-98260968',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'goods' => 0,
    'limitAct' => 0,
    'qrcode' => 0,
    'cfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f3c6f1f8ab9_35809796',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f3c6f1f8ab9_35809796')) {function content_5e4f3c6f1f8ab9_35809796($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="apple-mobile-web-app-title" content/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="email=no" name="format-detection" />
    <link rel="stylesheet" href="/public/wxapp/seckillshare/css/base.css" />
    <link rel="stylesheet" href="/public/wxapp/seckillshare/css/index.css?19" />
</head>
<body>
    <div  id="job-wrap">
        <div class="new-share-content">
            <img src="/public/wxapp/seckillshare/images/poster-bg.png" class="share-bg" alt="分享海报">
            <div class="poster-info">
                <img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_cover'];?>
" class="poster-cover" alt="封面">
                <div class="title"><?php echo $_smarty_tpl->tpl_vars['goods']->value['g_name'];?>
</div>
                <!-- 普通商品显示 -->
                <?php if ($_smarty_tpl->tpl_vars['goods']->value['seckill']==0) {?>
                <div class="good-price">购买价：￥<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_price'];?>
</div>
                <?php if ($_smarty_tpl->tpl_vars['goods']->value['g_ori_price']>0) {?>
                <div class="ori-price">原价:￥<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_ori_price'];?>
</div>
                <?php }?>
                <?php } elseif ($_smarty_tpl->tpl_vars['goods']->value['seckill']==1) {?>
                <div class="good-price">抢购价：￥<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_price'];?>
 <?php if ($_smarty_tpl->tpl_vars['goods']->value['g_ori_price']>0) {?><span class="ori-price">原价:￥<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_ori_price'];?>
</span><?php }?></div>
                <div class="end-time">活动截止日期：<?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['limitAct']->value['la_end_time']);?>
</div>
                <?php } elseif ($_smarty_tpl->tpl_vars['goods']->value['seckill']==2) {?>
                <!-- 秒杀商品显示 -->
                <div class="good-price">抢购价：￥<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_price'];?>
 <?php if ($_smarty_tpl->tpl_vars['goods']->value['g_ori_price']>0) {?><span class="ori-price">原价:￥<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_ori_price'];?>
</span><?php }?></div>
                <div class="end-time">活动开始时间：<?php echo date('n月d日H:i',$_smarty_tpl->tpl_vars['limitAct']->value['la_start_time']);?>
</div>
                <?php }?>
            </div>
        </div>
        <div class="applet-code">
            <div class="left-code" style="display: inline-block;">
                <img src="/public/wxapp/seckillshare/images/img_frame.png" class="code-bg" alt="小程序码背景">
                <img src="<?php echo $_smarty_tpl->tpl_vars['qrcode']->value;?>
" class="code-img" alt="小程序码">
            </div>
            <div class="code-intro" style="display: inline-block;">
                <div class="code-title">长按识别小程序码查看详情</div>
                <div class="code-sub">分享来自<?php echo $_smarty_tpl->tpl_vars['cfg']->value['ac_name'];?>
</div>
            </div>
        </div>
    </div>
</body>
</html><?php }} ?>

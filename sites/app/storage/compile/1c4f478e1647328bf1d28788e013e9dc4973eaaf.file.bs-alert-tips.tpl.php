<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:44:31
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/bs-alert-tips.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10647408085dea14efac2655-56502760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c4f478e1647328bf1d28788e013e9dc4973eaaf' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/bs-alert-tips.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10647408085dea14efac2655-56502760',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea14efac5702_62420411',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea14efac5702_62420411')) {function content_5dea14efac5702_62420411($_smarty_tpl) {?><style type="text/css">
    /******复制样式控制*******/
    .tips-txt{
        height: 40px;
        line-height: 40px;
        text-align: center;
        width: 360px;
        position: fixed;
        top:15%;
        left:50%;
        margin-left: -180px;
        border-radius: 5px;
        z-index: 100;
        color: #666;
        display: none;
    }
    .tips-txt.bg-success{
        border:1px solid #D7E9C7;
        background-color: rgba(223,241,217,0.9);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#E5DFF1D9,endColorstr=#E5DFF1D9);
    }
    .tips-txt.bg-fail{
        border:1px solid #EED3D7;
        background-color: rgba(242,222,222,0.9);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#E5F2DEDE,endColorstr=#E5F2DEDE);
    }
</style>
<div id="tips-txt" class="tips-txt bg-success"></div>
<script type="text/javascript">
    function showTips(msg){
        var timer;
        $("#tips-txt").text(msg).stop().fadeIn();
        clearTimeout(timer);
        timer=setTimeout(function(){
            $("#tips-txt").stop().fadeOut();
        },2000);
    }
</script><?php }} ?>

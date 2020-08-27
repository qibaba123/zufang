<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:12:47
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/bs-alert-tips.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21445064795e859e7f9f4672-97455894%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ea9c24a780a483136fada36450a67dd10df42f6' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/bs-alert-tips.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21445064795e859e7f9f4672-97455894',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e859e7f9f5768_00368938',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e859e7f9f5768_00368938')) {function content_5e859e7f9f5768_00368938($_smarty_tpl) {?><style type="text/css">
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

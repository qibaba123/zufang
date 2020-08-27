<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 09:55:01
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tpl-img.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18372674605e8697750a81a9-89999821%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe97b827814fefacbc93a63f88466fd4f043b54e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tpl-img.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18372674605e8697750a81a9-89999821',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'category' => 0,
    'key' => 0,
    'value' => 0,
    'tplimg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8697750e46a3_55643263',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8697750e46a3_55643263')) {function content_5e8697750e46a3_55643263($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv=X-UA-Compatible content="IE=EmulateIE10">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>模板导图</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/site/css/userCase.css">
    <style>
        a{
            text-decoration: none;
            color: #333;
        }
        ul{
            list-style-type: none;
        }

        .case-list li {
            width: auto;
            height: auto;
            border: 0;
        }

        .case-list .case-code img {
            margin: 100px 10px;
        }

        .case-list li .case-code {
            height: 88%;
        }

        .clearfix:after {
            content: ".";
            display: block;
            height: 0;
            clear: both;
            visibility: hidden;
        }
    </style>

</head>

<div class="userCase-wrap">
    <!--<div class="case-title">
        <img src="/public/agent/index/images/yonghuanli.png" alt="banner-title">
    </div>
    <div class="case_nav">
        <nav class="inv-type">
            <div id="navul" style="display: inline-block;">
                <span class="tab <?php if (!$_smarty_tpl->tpl_vars['type']->value) {?>tab-active<?php }?>"><a href="/agent/index/case">全部</a></span>
                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                <span class="tab <?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['key']->value) {?>tab-active<?php }?>"><a href="/agent/index/case/type/<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</a></span>
                <?php } ?>
            </div>
        </nav>
    </div>-->
    <div class="case-list">
        <ul class="clearfix">
            <li>
                <img class="lazy" src="/public/wxapp/tplimage/images/<?php echo $_smarty_tpl->tpl_vars['tplimg']->value;?>
" alt="案例图片">
                <!--<div class="case-code">
                    <img class="lazy" data-original="<?php echo $_smarty_tpl->tpl_vars['value']->value['cc_qrcode'];?>
" alt="二维码">
                </div>
                <div class="cc_name"><?php echo $_smarty_tpl->tpl_vars['value']->value['cc_name'];?>
</div>-->
            </li>
        </ul>
    </div>
</div>
<script src="/public/common/js/jquery-1.11.1.min.js"></script>
<script src="/public/plugin/lazyload/jquery.lazyload.min.js"></script>
<script>
    /*图片预加载*/
    $("img.lazy").lazyload({effect: "fadeIn"});
</script>
</body>
</html><?php }} ?>

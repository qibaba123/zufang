<?php /* Smarty version Smarty-3.1.17, created on 2020-04-01 18:39:05
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/manage/layer/breadcrumbs-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20812996605e846f49c61f04-89381549%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9b3e46e3c99b4602aca7f29889afa78e163a892' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/manage/layer/breadcrumbs-new.tpl',
      1 => 1548822179,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20812996605e846f49c61f04-89381549',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bread_crumbs' => 0,
    'index' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e846f49c6aba9_98874365',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e846f49c6aba9_98874365')) {function content_5e846f49c6aba9_98874365($_smarty_tpl) {?><style>
	.breadcrumbs {
	    position: relative;
	    border-bottom: 1px solid #e5e5e5;
	    background-color: #f9f9f9;
	    min-height: 41px;
	    line-height: 40px;
	    padding: 10px 12px 10px 12px;
	    display: block;
   	}
   	.breadcrumb > li + li:before {
	    font-family: FontAwesome;
	    font-size: 14px;
	    content: "/";
	    color: #b2b6bf;
	    margin-right: 2px;
	    padding: 0 5px 0 2px;
	    position: relative;
	    top: 1px;
	}
	.breadcrumbs li img{
		display: inline-block;
		width:14px;
		height:14px;
		margin-top:-4px;
	}
	.breadcrumbs li a{
		color:#999;
	}
	.breadcrumbs li:hover a{
		color:#0077DD;
	}
</style>
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>
	<div class="breadcrumbs-wrap" style="background-color:#fff;">
	    <ul class="breadcrumb">
	        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bread_crumbs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	        <li>
	            <?php if ($_smarty_tpl->tpl_vars['index']->value==0) {?>
	            <!--<i class="icon-home home-icon"></i>-->
	            <img src="/public/wxapp/images/icon_home.png" alt="" />
	            <?php }?>
	            <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</a>
	        </li>
	        <?php } ?>
	    </ul><!-- .breadcrumb -->
	</div>
</div><?php }} ?>

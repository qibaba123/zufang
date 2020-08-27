<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:16:47
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/memberCard/tabal-link.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12133253485e859f6f08a3e3-18221043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '106498349943ab5646cb8940c89bd67a34045a26' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/memberCard/tabal-link.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12133253485e859f6f08a3e3-18221043',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tabLink' => 0,
    'tabKey' => 0,
    'key' => 0,
    'tal' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e859f6f099aa9_25437431',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e859f6f099aa9_25437431')) {function content_5e859f6f099aa9_25437431($_smarty_tpl) {?><ul class="nav nav-tabs" id="myTab">
    <?php  $_smarty_tpl->tpl_vars['tal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tal']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tabLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tal']->key => $_smarty_tpl->tpl_vars['tal']->value) {
$_smarty_tpl->tpl_vars['tal']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tal']->key;
?>
    <?php if ($_smarty_tpl->tpl_vars['tabKey']->value==$_smarty_tpl->tpl_vars['key']->value) {?>
    <li class="active">
        <a href="#tab1">
            <!-- <i class="green icon-<?php echo $_smarty_tpl->tpl_vars['tal']->value['icon'];?>
 bigger-110"></i> -->
            <?php echo $_smarty_tpl->tpl_vars['tal']->value['name'];?>

        </a>
    </li>
    <?php } else { ?>
    <li>
        <a href="<?php echo $_smarty_tpl->tpl_vars['tal']->value['link'];?>
">
            <!-- <i class="green icon-<?php echo $_smarty_tpl->tpl_vars['tal']->value['icon'];?>
 bigger-110"></i> -->
            <?php echo $_smarty_tpl->tpl_vars['tal']->value['name'];?>

        </a>
    </li>
    <?php }?>
    <?php } ?>
</ul><?php }} ?>

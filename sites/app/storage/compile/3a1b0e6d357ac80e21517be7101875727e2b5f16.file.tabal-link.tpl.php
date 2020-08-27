<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:53:38
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/memberCard/tabal-link.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10593384335e4df4b2203f65-81208118%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a1b0e6d357ac80e21517be7101875727e2b5f16' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/memberCard/tabal-link.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10593384335e4df4b2203f65-81208118',
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
  'unifunc' => 'content_5e4df4b22107a5_31698126',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df4b22107a5_31698126')) {function content_5e4df4b22107a5_31698126($_smarty_tpl) {?><ul class="nav nav-tabs" id="myTab">
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

<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:44:38
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/memberCard/tabal-link.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19199871875dea14f66c2743-60249685%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c2dbc747f66b29b3ca048eead3d860e7fbec8d2' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/memberCard/tabal-link.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19199871875dea14f66c2743-60249685',
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
  'unifunc' => 'content_5dea14f66d3d35_87690470',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea14f66d3d35_87690470')) {function content_5dea14f66d3d35_87690470($_smarty_tpl) {?><ul class="nav nav-tabs" id="myTab">
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

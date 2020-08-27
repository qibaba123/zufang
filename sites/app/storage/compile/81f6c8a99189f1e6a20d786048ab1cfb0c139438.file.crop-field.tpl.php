<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 09:11:54
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/libs/image/crop/tpl/crop-field.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1198706815e853bdad02a90-27544135%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81f6c8a99189f1e6a20d786048ab1cfb0c139438' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/libs/image/crop/tpl/crop-field.tpl',
      1 => 1560823964,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1198706815e853bdad02a90-27544135',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'multi_image' => 0,
    'image_array' => 0,
    'crop_width' => 0,
    'crop_height' => 0,
    'default_title' => 0,
    'val' => 0,
    'field_name' => 0,
    'default_image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e853bdad359d9_13385526',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e853bdad359d9_13385526')) {function content_5e853bdad359d9_13385526($_smarty_tpl) {?><div class="container">
    <?php if ($_smarty_tpl->tpl_vars['multi_image']->value) {?>
    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['image_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
    <div class="avatar-view cropper-box" style="width: <?php echo $_smarty_tpl->tpl_vars['crop_width']->value;?>
px; height: <?php echo $_smarty_tpl->tpl_vars['crop_height']->value;?>
px;" title="<?php echo $_smarty_tpl->tpl_vars['default_title']->value;?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['default_title']->value;?>
">
        <input type="hidden" id="avatar-field" class="avatar-field" name="<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"/>
        <i class="icon-delete crop-delete"></i>
    </div>
    <?php } ?>
    <?php }?>
    <!-- Current avatar -->
    <div class="avatar-view cropper-box" style="width: <?php echo $_smarty_tpl->tpl_vars['crop_width']->value;?>
px; height: <?php echo $_smarty_tpl->tpl_vars['crop_height']->value;?>
px;" title="<?php echo $_smarty_tpl->tpl_vars['default_title']->value;?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['default_image']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['default_title']->value;?>
">
        <input type="hidden" class="avatar-field" name="<?php echo $_smarty_tpl->tpl_vars['field_name']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['default_image']->value;?>
"/>
    </div>
</div><?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 08:58:52
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/print/template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11837221785e8bd04ce66093-60627057%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c573d57ecc0a81303687c8b77be7d7e5beef796' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/print/template.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11837221785e8bd04ce66093-60627057',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'print' => 0,
    'key' => 0,
    'val' => 0,
    'tag' => 0,
    'tableTag' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8bd04ceaaef6_02368813',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8bd04ceaaef6_02368813')) {function content_5e8bd04ceaaef6_02368813($_smarty_tpl) {?><style>
	.page-content{
		padding:20px;
	}
	.btn-box{
		margin-top: 15px;
		text-align: center;
	}
	.btn-box .btn{
		margin:0 5px;
	}
	.tabbable textarea.form-control{
		resize: vertical;
	}
	.label-box{
		margin-top: 30px;
	}
	.label-box h4{
		font-size: 16px;
		font-weight: bold;
		line-height: 2;
		text-align: center;
	}
	
	.table tbody tr td,.table thead tr th{
		padding: 6px;
		color: #999;
		text-align: center;
	}
	.table thead tr th{
		color: #333;
	}
	.table tbody tr td.title{
		font-weight: bold;
		color: #666;
	}
</style>
<div class="row" style="max-width:1000px;margin:0 auto">
	<div class="col-xs-12">
		<div class="tabbable">
			<ul class="nav nav-tabs" id="myTab">
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['print']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
				<li <?php if ($_smarty_tpl->tpl_vars['key']->value==1) {?>class="active"<?php }?>>
					<a data-toggle="tab" href="#shopping-list_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>

					</a>
				</li>
				<?php } ?>
			</ul>

			<div class="tab-content">
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['print']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
				<div id="shopping-list_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="tab-pane in <?php if ($_smarty_tpl->tpl_vars['key']->value==1) {?>active<?php }?>">
					<div>
						<textarea name="content_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" id="content_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" rows="15" class="form-control"><?php echo $_smarty_tpl->tpl_vars['val']->value['content'];?>
</textarea>
						<div class="btn-box">
							<button class="btn btn-sm btn-green previewCon" data-type="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">预览</button>
							<button class="btn btn-sm btn-blue savePrintTpl" data-type="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">保存</button>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>

		<div class="label-box">
			<h4>订单标签提示</h4>
			<div class="label-tip">
				<table cellpadding="0" cellspacing="0" border="1" width="100%" class="table">
					<thead>
					<tr>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tag']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
						<td  class="title"><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['val']->value['field'];?>
</td>
						<?php if ($_smarty_tpl->tpl_vars['key']->value%4==3) {?></tr><tr><?php }?>
						<?php } ?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="label-box">
			<h4>表格标签提示</h4>
			<div class="label-tip">
				<table cellpadding="0" cellspacing="0" border="1" width="100%" class="table">
					<thead>
					<tr>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tableTag']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
						<td  class="title"><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['val']->value['field'];?>
</td>
						<?php if ($_smarty_tpl->tpl_vars['key']->value%4==3) {?></tr><tr><?php }?>
						<?php } ?>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/wxapp-order.js?1"></script>

<?php }} ?>

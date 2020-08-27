<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:02:57
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/cost-rank.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17454038415e8699516a39d2-69823701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ad43a4fa4cb65f293904f20c4ecbdb5998f8b80' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/cost-rank.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17454038415e8699516a39d2-69823701',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cost_list' => 0,
    'key' => 0,
    'item' => 0,
    'showPage' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8699516f3ae1_97192432',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8699516f3ae1_97192432')) {function content_5e8699516f3ae1_97192432($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/cost-rank.css">
<style type="text/css">
	.font-bold{
        font-size: 14px;
    }
</style>
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<form class='form-inline' action='/wxapp/seqstatistics/memberCost' method='get'>
			<div class='form-group'>
			    <a href="/wxapp/seqstatistics/memberCost" class='btn btn-sm btn-warning'>
			        <?php if ($_GET['finish_only']!=1) {?>
			        <i class="icon-ok-sign"></i>
			        <?php }?>全部
			    </a>
			    <a href="/wxapp/seqstatistics/memberCost?finish_only=1" class='btn btn-sm btn-warning'>
			        <?php if ($_GET['finish_only']==1) {?>
			        <i class="icon-ok-sign"></i>
			        <?php }?>仅显示已完成订单
			    </a>
			</div>
			<div class='form-group'>
				<select class='form-control' name='orderby'>
					<!-- <option value='0'>排序</option> -->
					<option value='ordercount' <?php if ($_GET['orderby']!='ordermoney') {?>selected<?php }?> >订单数</option>
					<option value='ordermoney' <?php if ($_GET['orderby']=='ordermoney') {?>selected<?php }?>>订单金额</option>
				</select>
			</div>
			<div class='form-group'>
				<input class='form-control' type="text" name="user" placeholder="会员名/手机号" value='<?php echo $_GET['user'];?>
'>
			</div>
			<button class='btn btn-sm btn-info' type='submit'>搜索</button>
		</form>
	</div>
</div>
<table class='table table-hover'>
	<thead>
		<tr>
			<td>排行</td>
			<td>会员</td>
			<td>姓名</td>
			<td>手机号</td>
			<td>消费金额</td>
			<td>订单数</td>
		</tr>
	</thead>
	<tbody>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cost_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<tr>
			<td>
				<?php if ($_GET['page']*50+$_smarty_tpl->tpl_vars['key']->value+1<=5) {?>
				<span class='label label-danger label-padding'><?php echo $_GET['page']*50+$_smarty_tpl->tpl_vars['key']->value+1;?>
</span>
				<?php } else { ?>
				<span class='label label-default label-padding'><?php echo $_GET['page']*50+$_smarty_tpl->tpl_vars['key']->value+1;?>
</span>
				<?php }?>
			</td>
			<td>
				<div class='flex'>
					<p>
						<img class='avatar-img' src="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_avatar'];?>
">
					</p>
					<p><?php if ($_smarty_tpl->tpl_vars['item']->value['m_nickname']!='undefined') {?><?php echo $_smarty_tpl->tpl_vars['item']->value['m_nickname'];?>
<?php }?></p>
				</div>
			</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['m_realname'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['m_mobile'];?>
</td>
			<td>
				<span class='font-bold'>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['total']) {?>
				￥<?php echo $_smarty_tpl->tpl_vars['item']->value['total'];?>

				<?php } else { ?>
				￥0
				<?php }?>
				</span>
			</td>
			<td>
				<span class='font-bold'>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['num']) {?>
				<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>

				<?php } else { ?>
				0
				<?php }?>
				</span>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<!--<div class='text-right'>
	
</div>-->
<?php if ($_smarty_tpl->tpl_vars['showPage']->value!=0) {?>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</div>
            </div>
        </div>
    </div>
</div>
<?php }?><?php }} ?>

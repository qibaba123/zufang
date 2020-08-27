<?php /* Smarty version Smarty-3.1.17, created on 2020-02-22 11:14:15
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/sales.tpl" */ ?>
<?php /*%%SmartyHeaderCode:858185515e509c877af712-48820496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f96a5ff1fa5cad9604f9541eeb91f37063880ab7' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/sales.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '858185515e509c877af712-48820496',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sum' => 0,
    'max' => 0,
    'sales' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e509c8780cad7_30470539',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e509c8780cad7_30470539')) {function content_5e509c8780cad7_30470539($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/sales.css">
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<form class='form-inline' action='/wxapp/seqstatistics/sale' method='get'>
			<div class='form-group'>
			    <a href="javascript:;" data-type='line' class='btn btn-sm btn-success chart_type'>
			        <?php if ($_GET['chart_type']==''||$_GET['chart_type']=='line') {?>
			        <i class="icon-ok-sign"></i>
			        <?php }?>折线图
			    </a>
			    <a href="javascript:;" data-type='pie' class='btn btn-sm btn-success chart_type'>
			        <?php if ($_GET['chart_type']=='pie') {?>
			        <i class="icon-ok-sign"></i>
			        <?php }?>饼状图
			    </a>
			</div>
			<div class='form-group'>
			    <a href="javascript:;" data-type=0 class='btn btn-sm btn-warning finish'>
			        <?php if ($_GET['finish_only']!=1) {?>
			        <i class="icon-ok-sign"></i>
			        <?php }?>全部订单
			    </a>
			    <a href="javascript:;" data-type=1 class='btn btn-sm btn-warning finish'>
			        <?php if ($_GET['finish_only']==1) {?>
			        <i class="icon-ok-sign"></i>
			        <?php }?>仅显示已完成订单
			    </a>
			</div>
			<div class='form-group'>
				<select id='year' name='year' class='form-control'></select>
			</div>
			<div class='form-group'>
				<select id='month' name='month' class='form-control'>
					<option value='0'>月份</option>
				</select>
			</div>
			<div class='form-group'>
				<select id='day' name='day' class='form-control'>
					<option value='0'>日期</option>
				</select>
			</div>
			<div class='form-group'>
				<select id='type' name='type' class='form-control'>
					<option value='total'>交易额</option>
					<option value='count' <?php if ($_GET['type']=='count') {?>selected<?php }?>>交易量</option>
				</select>
			</div>
			<button type='submit' class='btn btn-sm btn-info'>搜索</button>
		</form>
	</div>
</div>
<div class='panel panel-default'>
	<div class='panel-heading'>
		<?php if ($_GET['type']=='total'||$_GET['type']=='') {?>
		总交易额：
		<?php } elseif ($_GET['type']=='count') {?>
		总交易量：
		<?php }?>
		<span class='text-danger'><?php echo $_smarty_tpl->tpl_vars['sum']->value;?>
</span>&nbsp;，
		<?php if ($_GET['type']=='total'||$_GET['type']=='') {?>
		区间最高交易额：
		<?php } elseif ($_GET['type']=='count') {?>
		区间最高交易量：
		<?php }?>
		<span class='text-danger'><?php echo $_smarty_tpl->tpl_vars['max']->value;?>
</span>
	</div>
	<div class='panel-body'>
		<!-- 统计图表区域 -->
		<div id='echart' style="height: 520px;"></div>
		<!-- 数据显示区域 -->
		<table class='table table-hover'>
			<thead>
				<tr>
					<td>日期</td>
					<td>
						<?php if ($_GET['type']=='total'||$_GET['type']=='') {?>
						交易额
						<?php } elseif ($_GET['type']=='count') {?>
						交易量
						<?php }?>
					</td>
					<td>所占比例</td>
				</tr>
			</thead>
			<tbody>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sales']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
					<tr>
						<td class='grey'>
							<?php if ($_GET['day']) {?>
							<?php echo mb_substr($_smarty_tpl->tpl_vars['item']->value['dates'],-2,2);?>
&nbsp;点-&nbsp;<?php echo sprintf("%02d",(mb_substr($_smarty_tpl->tpl_vars['item']->value['dates'],-2,2)+1));?>
点
							<?php } else { ?>
							<?php echo $_smarty_tpl->tpl_vars['item']->value['dates'];?>

							<?php }?>
						</td>
						<td>
							<span <?php if ($_smarty_tpl->tpl_vars['item']->value['total']) {?>class='text-success'<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['total'];?>
</span>
						</td>
						<td>
							<span <?php if ($_smarty_tpl->tpl_vars['item']->value['total']) {?>class='text-success'<?php }?>><?php echo sprintf("%.2f",($_smarty_tpl->tpl_vars['item']->value['total']/$_smarty_tpl->tpl_vars['sum']->value*100));?>
%</span>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<input id='pie_data' type="hidden" value='<?php echo json_encode($_smarty_tpl->tpl_vars['sales']->value);?>
'>
<input id='year_hidden' type="hidden" value="<?php echo $_GET['year'];?>
">
<input id='month_hidden' type="hidden" value="<?php echo $_GET['month'];?>
">
<input id='day_hidden' type="hidden" value="<?php echo $_GET['day'];?>
">
<input id='chart_type' type="hidden" value="<?php echo $_GET['chart_type'];?>
">
<input id='type' type="hidden" value="<?php echo $_GET['type'];?>
">

<script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script type="text/javascript" src='/public/wxapp/seqstatistics/js/sale.js?ver=0.2.4'></script><?php }} ?>

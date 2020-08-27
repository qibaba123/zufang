<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:03:05
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/sales-analysis.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14255652655e86995948f517-36202837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11aac3037cd630a6f22947b2dc64613f7bbf22f1' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/sales-analysis.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14255652655e86995948f517-36202837',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'analysis_data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8699594e2ba8_52897921',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8699594e2ba8_52897921')) {function content_5e8699594e2ba8_52897921($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/sales-analysis.css">
<style type="text/css">
	.font-bold{
        font-size: 14px;
    }
</style>
<div class='help-block text-right'>
    <!-- <small class='text-warning'>*仅统计已完成订单数据*</small> -->
    <a href="/wxapp/seqstatistics/saleAnalysis" class='btn btn-sm btn-warning'>
        <?php if ($_GET['finish_only']!=1) {?>
        <i class="icon-ok-sign"></i>
        <?php }?>全部
    </a>
    <a href="/wxapp/seqstatistics/saleAnalysis?finish_only=1" class='btn btn-sm btn-warning'>
        <?php if ($_GET['finish_only']==1) {?>
        <i class="icon-ok-sign"></i>
        <?php }?>仅显示已完成订单
    </a>
</div>
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class='form-group'>
			<table class='table'>
				<thead>
					<tr>
						<td style='width: 150px;'>订单总金额</td>
						<td style='width: 150px;'>总会员数</td>
						<td style='width: 150px;'>会员人均消费</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['money'];?>
</span></td>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['member_total'];?>
</span></td>
						<td><span class='font-bold'><?php echo round($_smarty_tpl->tpl_vars['analysis_data']->value['money']/$_smarty_tpl->tpl_vars['analysis_data']->value['member_total'],2);?>
</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: 100%">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class='form-group'>
			<table class='table'>
				<thead>
					<tr>
						<td style='width: 150px;'>订单总金额</td>
						<td style='width: 150px;'>总访问次数</td>
						<td style='width: 150px;'>访问转化率</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['money'];?>
</span></td>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['vist'];?>
</span></td>
						<td><span class='font-bold'><?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['money']/$_smarty_tpl->tpl_vars['analysis_data']->value['vist']*100);?>
%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-info" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['money']/$_smarty_tpl->tpl_vars['analysis_data']->value['vist']*100);?>
%">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class='form-group'>
			<table class='table'>
				<thead>
					<tr>
						<td style='width: 150px;'>总订单数</td>
						<td style='width: 150px;'>总访问次数</td>
						<td style='width: 150px;'>订单转化率</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['trade_total'];?>
</span></td>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['vist'];?>
</span></td>
						<td><span class='font-bold'><?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['trade_total']/$_smarty_tpl->tpl_vars['analysis_data']->value['vist']*100);?>
%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-warning" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['trade_total']/$_smarty_tpl->tpl_vars['analysis_data']->value['vist']*100);?>
%">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class='form-group'>
			<table class='table'>
				<thead>
					<tr>
						<td style='width: 150px;'>消费会员数</td>
						<td style='width: 150px;'>会员总数</td>
						<td style='width: 150px;'>会员消费率</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['consume_member'];?>
</span></td>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['member_total'];?>
</span></td>
						<td><span class='font-bold'><?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['consume_member']/$_smarty_tpl->tpl_vars['analysis_data']->value['member_total']*100);?>
%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-danger" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['consume_member']/$_smarty_tpl->tpl_vars['analysis_data']->value['member_total']*100);?>
%">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class='form-group'>
			<table class='table'>
				<thead>
					<tr>
						<td style='width: 150px;'>总订单数</td>
						<td style='width: 150px;'>总会员数</td>
						<td style='width: 150px;'>订单购买率</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['trade_total'];?>
</span></td>
						<td><span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['analysis_data']->value['member_total'];?>
</span></td>
						<td><span class='font-bold'><?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['trade_total']/$_smarty_tpl->tpl_vars['analysis_data']->value['member_total']*100);?>
%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-primary" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ceil($_smarty_tpl->tpl_vars['analysis_data']->value['trade_total']/$_smarty_tpl->tpl_vars['analysis_data']->value['member_total']*100);?>
%">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div><?php }} ?>

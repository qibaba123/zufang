<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 11:50:30
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/order/trade-refund-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3644836105e86b286aba634-96749231%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7830301d5aa052e0cccac7fb15e8229fe179a25' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/order/trade-refund-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3644836105e86b286aba634-96749231',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'tid' => 0,
    'title' => 0,
    'buyer' => 0,
    'name' => 0,
    'phone' => 0,
    'status' => 0,
    'link' => 0,
    'key' => 0,
    'val' => 0,
    'list' => 0,
    'tradePay' => 0,
    'showShopName' => 0,
    'statusNote' => 0,
    'page_html' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86b286b33684_52340483',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86b286b33684_52340483')) {function content_5e86b286b33684_52340483($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
	.balance .balance-info{
		width: 33.33% !important;
	}
</style>
<!-- 汇总信息 -->
<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
	<div class="balance-info">
		<div class="balance-title">总退款订单<span></span></div>
		<div class="balance-content">
			<span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">退款中的订单<span></span></div>
		<div class="balance-content">
			<span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['going'];?>
</span>
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">已退款订单<span></span></div>
		<div class="balance-content">
			<span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['done'];?>
</span>
		</div>
	</div>
</div>
<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="/wxapp/order/refundList" method="get">
			<div class="col-xs-11 form-group-box">
				<div class="form-container">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">订单编号</div>
							<input type="text" class="form-control" name="tid" value="<?php echo $_smarty_tpl->tpl_vars['tid']->value;?>
"  placeholder="订单编号">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group ">
							<div class="input-group-addon">商品名称</div>
							<input type="text" class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"  placeholder="商品名称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">买家</div>
							<input type="text" class="form-control" name="buyer" value="<?php echo $_smarty_tpl->tpl_vars['buyer']->value;?>
"  placeholder="购买人微信昵称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人</div>
							<input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"  placeholder="收货人姓名">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人电话</div>
							<input type="text" class="form-control" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
"  placeholder="收货人电话">
						</div>
					</div>
					<input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
				</div>
			</div>
			<div class="col-xs-1 pull-right search-btn">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>
<div class="choose-state">
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['link']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<a href="/wxapp/order/refundList?status=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['status']->value&&$_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['key']->value) {?>class="active"<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
	<?php } ?>
	<!---
            <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;"><i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span></button>
    -->
</div>
<div class="trade-list">
	<table class="ui-table-order" style="padding: 0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
		    <tr class="widget-list-header">
		        <th class="" colspan="2" style="min-width: 212px; max-width: 212px;">商品</th>
		        <th class="price-cell" style="min-width: 87px; max-width: 87px;">总价/数量</th>
		        <th class="aftermarket-cell" style="min-width: 85px; max-width: 85px;">维权</th>
		        <th class="customer-cell" style="min-width: 110px; max-width: 110px;">买家</th>
		        <th class="time-cell" style="min-width: 80px; max-width: 80px;">
		            <a href="javascript:;" data-orderby="book_time">下单时间<span class="orderby-arrow desc">↓</span></a>
		        </th>
		        <th class="state-cell" style="min-width: 100px; max-width: 100px;">维权状态</th>
		        <th class="state-cell" style="min-width: 100px; max-width: 100px;">维权结果</th>
		        <th class="pay-price-cell" style="min-width: 120px; max-width: 120px;">实付金额</th>
		    </tr>
		</thead>
		<tbody class="widget-list-item">
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<tr class="separation-row">
			<td colspan="8"></td>
		</tr>
		<tr class="header-row">
			<td colspan="7">
				<div>
					订单号: <?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>

					<div class="help" style="display: inline-block;">
						<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><?php echo $_smarty_tpl->tpl_vars['tradePay']->value[$_smarty_tpl->tpl_vars['val']->value['t_pay_type']];?>
</span>
						<div class="js-notes-cont hide">
							该订单通过您公众号自有的微信支付权限完成交易，货款已进入您微信支付对应的财付通账号
						</div>
						<?php if ($_smarty_tpl->tpl_vars['showShopName']->value==1) {?>
						<span style="padding-left: 20px;">
								<?php if ($_smarty_tpl->tpl_vars['val']->value['t_es_id']) {?>
								<?php echo $_smarty_tpl->tpl_vars['val']->value['es_name'];?>

								<?php } else { ?>
								平台自营
								<?php }?>
						</span>
						<?php }?>
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/order/tradeDetail?order_no=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="new-window" >查看详情</a>
						<a href="#" class="js-remark hide"> - 备注</a>
					</div>
				</div>
			</td>
		</tr>
		<tr class="content-row">
			<td class="image-cell">
				<img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_pic'];?>
">
			</td>
			<td class="title-cell">
				<p class="goods-title">
					<a href="/wxapp/order/refundList?title=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
"class="new-window" title="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>

					</a>
				</p>
				<p>
				</p>
			</td>
			<td class="price-cell">
				<p>
					<?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>

				</p>
				<p>(<?php echo $_smarty_tpl->tpl_vars['val']->value['t_num'];?>
件)</p>
			</td>
			<td class="aftermarket-cell" rowspan="1">
				<?php if (in_array($_smarty_tpl->tpl_vars['val']->value['t_feedback'],array(1,2))) {?>
				<a href="/wxapp/order/tradeRefund?order_no=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="new-window" >处理维权</a>
				<?php }?>
			</td>
			<td class="customer-cell" rowspan="1">
				<p>
					<a href="/wxapp/order/refundList?buyer=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>
" class="new-window" target="_blank">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>

					</a>
				</p>
				<p class="user-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['ma_name'];?>
</p>
				<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_phone'];?>

			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['t_create_time']);?>

				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<!--<p class="js-order-state" id="status_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
"><?php echo $_smarty_tpl->tpl_vars['statusNote']->value[$_smarty_tpl->tpl_vars['val']->value['t_status']];?>
</p>-->
					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_fd_status']==1) {?>
					<span style="color: red;">等待商家处理</span>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_fd_status']==4) {?>
					<span style="">等待会计处理</span>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_fd_status']==2) {?>
					<span style="color: green;">等待买家处理</span>
					<?php } else { ?>
					<span>维权结束</span>
					<?php }?>
				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_fd_result']==1) {?>
					<span style="color: red;">拒绝退款</span>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_fd_result']==2) {?>
					<span style="color: green;">同意退款</span>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_fd_result']==3) {?>
					<span>买家撤销</span>
					<?php }?>
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>

						<br>
					</div>

				</div>
			</td>
		</tr>
		<?php if ($_smarty_tpl->tpl_vars['val']->value['t_note']) {?>
		<tr class="remark-row buyer-msg">
			<td colspan="9">买家备注： <?php echo $_smarty_tpl->tpl_vars['val']->value['t_note'];?>
</td>
		</tr>
		<?php }?>
		<?php } ?>
		<tr class="separation-row">
			<td colspan="8"><?php echo $_smarty_tpl->tpl_vars['page_html']->value;?>
 </td>
		</tr>
		</tbody>
	</table>
</div>
<script>
	$(function(){
		// 搜索框滚动
		var formGroupNum = $(".form-group-box").find('.form-group').length;
		$(".form-container").width(270*formGroupNum);
	})
</script>
<?php }} ?>

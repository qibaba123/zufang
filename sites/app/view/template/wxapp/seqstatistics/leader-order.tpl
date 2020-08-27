<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/leader-order.css">
<div class='panel panel-primary'>
	<div class='panel-body'>
		<form action="">
			<div style='display: flex;'>
				<input type="hidden" name="id" value='<{$smarty.get.id}>'>
				<input class='form-control' style="width: 300px;margin-right: 10px;" type="search" placeholder="订单号码" name='order_id' value='<{$smarty.get.order_id}>'>
				<button class='btn btn-sm btn-primary'>查询订单</button>
			</div>
		</form>
	</div>
</div>
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class="choose-state">
			<{foreach $link as $key=>$val}>
			<{/foreach}>
			<a href="/wxapp/seqstatistics/leaderOrder?id=<{$smarty.get.id}>&status=all" 
			<{if $smarty.get.status=='all'||$smarty.get.status==''}>
			class="active"
			<{/if}>> 全部</a>
			<a href="/wxapp/seqstatistics/leaderOrder?id=<{$smarty.get.id}>&status=pay" 
			<{if $smarty.get.status=='pay'}>
			class="active"
			<{/if}>>已付款</a>
			<a href="/wxapp/seqstatistics/leaderOrder?id=<{$smarty.get.id}>&status=nopay"
			<{if $smarty.get.status=='nopay'}>
			class="active"
			<{/if}>> 未付款</a>
			<a href="/wxapp/seqstatistics/leaderOrder?id=<{$smarty.get.id}>&status=finish" 
			<{if $smarty.get.status=='finish'}>
			class="active"
			<{/if}>>已完成</a>
		</div>
		<table class='table'>
			<thead>
				<tr>
					<td>商品</td>
					<td>数量</td>
					<td>支付方式</td>
					<td>订单总价格</td>
					<td>订单实付价格</td>
					<td>订单状态</td>
					<td>订单详情</td>
				</tr>
			</thead>
			<tbody>
				<{foreach $order_list as $item}>
				<tr>
					<td colspan="7" class='padding-line' style='border-left:none;border-right: none;'></td>
				</tr>
				<tr>
					<td colspan="7" class='head-title'>
						订单编号：<{$item.t_tid}>
					</td>
				</tr>
				<tr>
					<td class='goods-info'>
						<p>
							<img src="<{$item.t_pic}>">
						</p>
						<p>
							<{$item.t_title}>
						</p>
					</td>
					<td><{$item.t_num}></td>
					<td>
						<{if $item.t_pay_type==1}>
						微信
						<{elseif $item.t_pay_type==2}>
						微信代销
						<{elseif $item.t_pay_type==3}>
						支付宝代销
						<{/if}>
					</td>
					<td>
						￥<{$item.t_payment}>
					</td>
					<td>
						<span class='text-danger'>￥<{$item.t_payment}></span>
					</td>
					<td>
						<{if $item.t_status ==6}>
						<span class='text-success'>已完成</span>
						<{else if $item.t_status ==7}>
						<span class='text-danger'>交易关闭</span>
						<{else if $item.t_status ==8}>
						<span class='text-warning'>退款交易</span>
						<{else if $item.t_status ==1}>
						<span class='text-info'>待付款</span>
						<{else if $item.t_status ==3}>
						<span class='text-success'>待发货</span>
						<{else if $item.t_status ==4}>
						<span class='text-success'>已发货</span>
						<{/if}>
					</td>
					<td>
						<a href="/wxapp/order/tradeDetail?order_no=<{$item.t_tid}>">详情</a>
					</td>
				</tr>
				<{/foreach}>
			</tbody>
		</table>
		<div class='text-right'>
			<{$paginator}>
		</div>
	</div>
</div>
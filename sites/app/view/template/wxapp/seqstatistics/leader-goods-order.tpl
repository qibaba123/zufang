<style type="text/css">
	.flex{
		display: flex;
		align-items: center;
	}
	.flex img{
		width: 50px;
		height: 50px;
	}
	.flex p{
		margin-right: 10px;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class='flex'>
			<p>
				<img src="<{$goods_info.g_cover}>">
			</p>
			<p>
				商品名称：<a target="_blank" href="/wxapp/sequence/goodsEdit?id=<{$goods_info.g_id}>"><span class='text-info'><{$goods_info.g_name}></span></a>
			</p>
			<p>商品单价：<span class='text-info'>￥<{$goods_info.g_price}></span></p>
			<p>商品库存：<span class='text-info'><{$goods_info.g_stock}></span></p>
			<p style='margin-left: 50px;'>
				未付款订单：<b class='text-danger'><{if $sum['c_1']['total']}><{$sum['c_1']['total']}><{else}>0<{/if}></b>
			</p>
			<p>
				已付款订单：<b class='text-danger'><{if $sum['c_3']['total']}><{$sum['c_3']['total']}><{else}>0<{/if}></b>
			</p>
			<p>
				已完成订单：<b class='text-danger'><{if $sum['c_6']['total']}><{$sum['c_6']['total']}><{else}>0<{/if}></b>
			</p>
		</div>
	</div>
</div>
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class="choose-state">
			<{foreach $link as $key=>$val}>
			<{/foreach}>
			<a href="/wxapp/seqstatistics/leaderGoodsOrder?l_id=<{$smarty.get.l_id}>&g_id=<{$smarty.get.g_id}>&status=all" 
			<{if $smarty.get.status=='all'||$smarty.get.status==''}>
			class="active"
			<{/if}>> 全部</a>
			<a href="/wxapp/seqstatistics/leaderGoodsOrder?l_id=<{$smarty.get.l_id}>&g_id=<{$smarty.get.g_id}>&status=pay" 
			<{if $smarty.get.status=='pay'}>
			class="active"
			<{/if}>>已付款</a>
			<a href="/wxapp/seqstatistics/leaderGoodsOrder?l_id=<{$smarty.get.l_id}>&g_id=<{$smarty.get.g_id}>&status=nopay"
			<{if $smarty.get.status=='nopay'}>
			class="active"
			<{/if}>> 未付款</a>
			<a href="/wxapp/seqstatistics/leaderGoodsOrder?l_id=<{$smarty.get.l_id}>&g_id=<{$smarty.get.g_id}>&status=finish" 
			<{if $smarty.get.status=='finish'}>
			class="active"
			<{/if}>>已完成</a>
		</div>
		<table class='table table-hover'>
			<thead>
				<tr>
					<td>订单编号</td>
					<td>总金额</td>
					<td>实付金额</td>
					<td>订单状态</td>
					<td>订单时间</td>
					<td>订单详情</td>
				</tr>
			</thead>
			<tbody>
				<{foreach $order_list as $item}>
				<tr>
					<td><{$item.t_tid}></td>
					<td>￥<{$item.t_total_fee}></td>
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
						<span class='text-info'>代付款</span>
						<{else if $item.t_status ==3}>
						<span class='text-success'>代发货</span>
						<{else if $item.t_status ==4}>
						<span class='text-success'>已发货</span>
						<{/if}>
					</td>
					<td ><{date('Y/m/d H:i:s',$item.t_create_time)}></td>
					<td>
						<a target="_blank" href="/wxapp/order/tradeDetail?order_no=<{$item.t_tid}>">查看详情</a>
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
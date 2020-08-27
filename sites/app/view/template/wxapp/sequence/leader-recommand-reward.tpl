<div class='panel panel-default'>
	<div class='panel-heading'>
		团长推荐佣金奖励记录
	</div>
	<div class='panel-body'>
		<table class='table table-hover'>
			<thead>
				<tr>
 					<th>团长</th>
					<th>订单</th>
					<th>金额</th>
					<th>时间</th>
				</tr>
			</thead>
			<tbody>
				<{foreach $reward_list as $item}>
				<tr>
					<td>
						<p>团长：<span style='color: #9a999e;'><{$item.asl_name}></span></p>
						<p>手机：<span style='color: #9a999e;'><{$item.asl_mobile}></span></p>
					</td>
					<td>
						<a target="_blank" href="/wxapp/order/tradeDetail?order_no=<{$item.asrr_tid}>"><{$item.asrr_tid}></a>
					</td>
					<td>
						<span class='text-danger'>￥<{sprintf('%.2f',$item.asrr_money/100)}></span>
					</td>
					<td>
						<{date('Y/m/d H:i:s',$item.asrr_create_at)}>
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
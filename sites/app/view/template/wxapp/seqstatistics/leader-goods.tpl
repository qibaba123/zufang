<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/leader-goods.css">
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class='flex'>
			<p>
				<img src="<{$leader_info.m_avatar}>">
			</p>
			<p>
				昵称：<{$leader_info.m_nickname}>
			</p>
			<p>姓名：<{$leader_info.asl_name}></p>
			<p>手机号码：<{$leader_info.asl_mobile}></p>
		</div>
	</div>
</div>
<div class='panel panel-default'>
	<div class='panel-body'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<td>商品信息</td>
					<td>商品状态</td>
					<td>商品库存</td>
					<td>商品销售总量</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
				<{foreach $goods_limited as $item}>
				<tr>
					<td class='info'>
						<p>
							<img src="<{$item.g_cover}>">
						</p>
						<p>
							<{$item.g_name}><br><label class='label label-danger'>团长限购商品</label>
						</p>
					</td>
					<td>
						<{if $item.g_deleted != 1}>
							<{if $item.g_is_sale==1}>
							<span class='text-success'>在售</span>
							<{else if $item.g_is_sale==2}>
							<span class='text-warning'>已下架</span>
							<{/if}>
						<{else}>
							<span class='text-danger'>已删除</span>
						<{/if}>
					</td>
					<td><{$item.g_stock}></td>
					<td>
						<{if $item.total}>
						<{$item.total}>
						<{else}>
						0
						<{/if}>
					</td>
					<td>
						<a href='/wxapp/seqstatistics/leaderGoodsOrder?l_id=<{$smarty.get.id}>&g_id=<{$item.g_id}>'>商品订单</a>
					</td>
				</tr>
				<{/foreach}>
				<tr>
					<td colspan="5"></td>
				</tr>
				<{foreach $goods_list as $item}>
				<tr>
					<td class='info'>
						<p>
							<img src="<{$item.g_cover}>">
						</p>
						<p>
							<{$item.g_name}>
						</p>
					</td>
					<td>
						<{if $item.g_deleted != 1}>
							<{if $item.g_is_sale==1}>
							<span class='text-success'>在售</span>
							<{else if $item.g_is_sale==2}>
							<span class='text-warning'>已下架</span>
							<{/if}>
						<{else}>
							<span class='text-danger'>已删除</span>
						<{/if}>
					</td>
					<td><{$item.g_stock}></td>
					<td>
						<{if $item.total}>
						<{$item.total}>
						<{else}>
						0
						<{/if}>
					</td>
					<td>
						<a href='/wxapp/seqstatistics/leaderGoodsOrder?l_id=<{$smarty.get.id}>&g_id=<{$item.g_id}>'>商品订单</a>
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
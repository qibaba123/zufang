<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
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
			<span class="money"><{$statInfo['total']}></span>
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">退款中的订单<span></span></div>
		<div class="balance-content">
			<span class="money"><{$statInfo['going']}></span>
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">已退款订单<span></span></div>
		<div class="balance-content">
			<span class="money"><{$statInfo['done']}></span>
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
							<input type="text" class="form-control" name="tid" value="<{$tid}>"  placeholder="订单编号">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group ">
							<div class="input-group-addon">商品名称</div>
							<input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="商品名称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">买家</div>
							<input type="text" class="form-control" name="buyer" value="<{$buyer}>"  placeholder="购买人微信昵称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人</div>
							<input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="收货人姓名">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人电话</div>
							<input type="text" class="form-control" name="phone" value="<{$phone}>"  placeholder="收货人电话">
						</div>
					</div>
					<input type="hidden" name="status" value="<{$status}>">
				</div>
			</div>
			<div class="col-xs-1 pull-right search-btn">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>
<div class="choose-state">
	<{foreach $link as $key=>$val}>
	<a href="/wxapp/order/refundList?status=<{$key}>" <{if $status && $status eq $key}>class="active"<{/if}>><{$val['label']}></a>
	<{/foreach}>
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
		<{foreach $list as $val}>
		<tr class="separation-row">
			<td colspan="8"></td>
		</tr>
		<tr class="header-row">
			<td colspan="7">
				<div>
					订单号: <{$val['t_tid']}>
					<div class="help" style="display: inline-block;">
						<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><{$tradePay[$val['t_pay_type']]}></span>
						<div class="js-notes-cont hide">
							该订单通过您公众号自有的微信支付权限完成交易，货款已进入您微信支付对应的财付通账号
						</div>
						<{if $showShopName == 1}>
						<span style="padding-left: 20px;">
								<{if $val['t_es_id']}>
								<{$val['es_name']}>
								<{else}>
								平台自营
								<{/if}>
						</span>
						<{/if}>
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/order/tradeDetail?order_no=<{$val['t_tid']}>" class="new-window" >查看详情</a>
						<a href="#" class="js-remark hide"> - 备注</a>
					</div>
				</div>
			</td>
		</tr>
		<tr class="content-row">
			<td class="image-cell">
				<img src="<{$val['t_pic']}>">
			</td>
			<td class="title-cell">
				<p class="goods-title">
					<a href="/wxapp/order/refundList?title=<{$val['t_title']}>"class="new-window" title="<{$val['t_title']}>">
						<{$val['t_title']}>
					</a>
				</p>
				<p>
				</p>
			</td>
			<td class="price-cell">
				<p>
					<{$val['t_total_fee']}>
				</p>
				<p>(<{$val['t_num']}>件)</p>
			</td>
			<td class="aftermarket-cell" rowspan="1">
				<{if in_array($val['t_feedback'],array(1,2))}>
				<a href="/wxapp/order/tradeRefund?order_no=<{$val['t_tid']}>" class="new-window" >处理维权</a>
				<{/if}>
			</td>
			<td class="customer-cell" rowspan="1">
				<p>
					<a href="/wxapp/order/refundList?buyer=<{$val['t_buyer_nick']}>" class="new-window" target="_blank">
						<{$val['t_buyer_nick']}>
					</a>
				</p>
				<p class="user-name"><{$val['ma_name']}></p>
				<{$val['ma_phone']}>
			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<{date('Y-m-d H:i:s',$val['t_create_time'])}>
				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<!--<p class="js-order-state" id="status_<{$val['t_tid']}>"><{$statusNote[$val['t_status']]}></p>-->
					<{if $val['t_fd_status'] eq 1}>
					<span style="color: red;">等待商家处理</span>
					<{elseif $val['t_fd_status'] eq 4}>
					<span style="">等待会计处理</span>
					<{elseif $val['t_fd_status'] eq 2}>
					<span style="color: green;">等待买家处理</span>
					<{else}>
					<span>维权结束</span>
					<{/if}>
				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<{if $val['t_fd_result'] eq 1}>
					<span style="color: red;">拒绝退款</span>
					<{elseif $val['t_fd_result'] eq 2}>
					<span style="color: green;">同意退款</span>
					<{elseif $val['t_fd_result'] eq 3}>
					<span>买家撤销</span>
					<{/if}>
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
						<{$val['t_total_fee']}>
						<br>
					</div>

				</div>
			</td>
		</tr>
		<{if $val['t_note']}>
		<tr class="remark-row buyer-msg">
			<td colspan="9">买家备注： <{$val['t_note']}></td>
		</tr>
		<{/if}>
		<{/foreach}>
		<tr class="separation-row">
			<td colspan="8"><{$page_html}> </td>
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

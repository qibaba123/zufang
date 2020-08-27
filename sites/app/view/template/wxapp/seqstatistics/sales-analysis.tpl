<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/sales-analysis.css">
<style type="text/css">
	.font-bold{
        font-size: 14px;
    }
</style>
<div class='help-block text-right'>
    <!-- <small class='text-warning'>*仅统计已完成订单数据*</small> -->
    <a href="/wxapp/seqstatistics/saleAnalysis" class='btn btn-sm btn-warning'>
        <{if $smarty.get.finish_only != 1}>
        <i class="icon-ok-sign"></i>
        <{/if}>全部
    </a>
    <a href="/wxapp/seqstatistics/saleAnalysis?finish_only=1" class='btn btn-sm btn-warning'>
        <{if $smarty.get.finish_only == 1}>
        <i class="icon-ok-sign"></i>
        <{/if}>仅显示已完成订单
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
						<td><span class='font-bold'><{$analysis_data.money}></span></td>
						<td><span class='font-bold'><{$analysis_data.member_total}></span></td>
						<td><span class='font-bold'><{round($analysis_data.money/$analysis_data.member_total,2)}></span></td>
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
						<td><span class='font-bold'><{$analysis_data.money}></span></td>
						<td><span class='font-bold'><{$analysis_data.vist}></span></td>
						<td><span class='font-bold'><{ceil($analysis_data.money/$analysis_data.vist*100)}>%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-info" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <{ceil($analysis_data.money/$analysis_data.vist*100)}>%">
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
						<td><span class='font-bold'><{$analysis_data.trade_total}></span></td>
						<td><span class='font-bold'><{$analysis_data.vist}></span></td>
						<td><span class='font-bold'><{ceil($analysis_data.trade_total/$analysis_data.vist*100)}>%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-warning" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <{ceil($analysis_data.trade_total/$analysis_data.vist*100)}>%">
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
						<td><span class='font-bold'><{$analysis_data.consume_member}></span></td>
						<td><span class='font-bold'><{$analysis_data.member_total}></span></td>
						<td><span class='font-bold'><{ceil($analysis_data.consume_member/$analysis_data.member_total*100)}>%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-danger" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <{ceil($analysis_data.consume_member/$analysis_data.member_total*100)}>%">
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
						<td><span class='font-bold'><{$analysis_data.trade_total}></span></td>
						<td><span class='font-bold'><{$analysis_data.member_total}></span></td>
						<td><span class='font-bold'><{ceil($analysis_data.trade_total/$analysis_data.member_total*100)}>%</span></td>
						<td>
							<div class="progress">
								<div class="progress-bar progress-bar-primary" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <{ceil($analysis_data.trade_total/$analysis_data.member_total*100)}>%">
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/sales.css">
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<form class='form-inline' action='/wxapp/seqstatistics/sale' method='get'>
			<div class='form-group'>
			    <a href="javascript:;" data-type='line' class='btn btn-sm btn-success chart_type'>
			        <{if $smarty.get.chart_type =='' || $smarty.get.chart_type =='line'}>
			        <i class="icon-ok-sign"></i>
			        <{/if}>折线图
			    </a>
			    <a href="javascript:;" data-type='pie' class='btn btn-sm btn-success chart_type'>
			        <{if $smarty.get.chart_type == 'pie'}>
			        <i class="icon-ok-sign"></i>
			        <{/if}>饼状图
			    </a>
			</div>
			<div class='form-group'>
			    <a href="javascript:;" data-type=0 class='btn btn-sm btn-warning finish'>
			        <{if $smarty.get.finish_only != 1}>
			        <i class="icon-ok-sign"></i>
			        <{/if}>全部订单
			    </a>
			    <a href="javascript:;" data-type=1 class='btn btn-sm btn-warning finish'>
			        <{if $smarty.get.finish_only == 1}>
			        <i class="icon-ok-sign"></i>
			        <{/if}>仅显示已完成订单
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
					<option value='count' <{if $smarty.get.type=='count'}>selected<{/if}>>交易量</option>
				</select>
			</div>
			<button type='submit' class='btn btn-sm btn-info'>搜索</button>
		</form>
	</div>
</div>
<div class='panel panel-default'>
	<div class='panel-heading'>
		<{if $smarty.get.type=='total'||$smarty.get.type==''}>
		总交易额：
		<{else if $smarty.get.type=='count'}>
		总交易量：
		<{/if}>
		<span class='text-danger'><{$sum}></span>&nbsp;，
		<{if $smarty.get.type=='total'||$smarty.get.type==''}>
		区间最高交易额：
		<{else if $smarty.get.type=='count'}>
		区间最高交易量：
		<{/if}>
		<span class='text-danger'><{$max}></span>
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
						<{if $smarty.get.type=='total'||$smarty.get.type==''}>
						交易额
						<{else if $smarty.get.type=='count'}>
						交易量
						<{/if}>
					</td>
					<td>所占比例</td>
				</tr>
			</thead>
			<tbody>
				<{foreach $sales as $item}>
					<tr>
						<td class='grey'>
							<{if $smarty.get.day}>
							<{mb_substr($item.dates,-2,2)}>&nbsp;点-&nbsp;<{sprintf("%02d",(mb_substr($item.dates,-2,2)+1))}>点
							<{else}>
							<{$item.dates}>
							<{/if}>
						</td>
						<td>
							<span <{if $item.total}>class='text-success'<{/if}>><{$item.total}></span>
						</td>
						<td>
							<span <{if $item.total}>class='text-success'<{/if}>><{($item.total/$sum*100)|string_format:"%.2f"}>%</span>
						</td>
					</tr>
				<{/foreach}>
			</tbody>
		</table>
	</div>
</div>
<input id='pie_data' type="hidden" value='<{json_encode($sales)}>'>
<input id='year_hidden' type="hidden" value="<{$smarty.get.year}>">
<input id='month_hidden' type="hidden" value="<{$smarty.get.month}>">
<input id='day_hidden' type="hidden" value="<{$smarty.get.day}>">
<input id='chart_type' type="hidden" value="<{$smarty.get.chart_type}>">
<input id='type' type="hidden" value="<{$smarty.get.type}>">

<script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script type="text/javascript" src='/public/wxapp/seqstatistics/js/sale.js?ver=0.2.4'></script>
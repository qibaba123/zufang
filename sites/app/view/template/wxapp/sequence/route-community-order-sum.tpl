<style type="text/css">
	.form-inline .form-control{
		width: auto!important;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body'>
		<form class='form-inline' method="get">
			<input type="hidden" name="route_id" value='<{$smarty.get.route_id}>'>
			<input type="hidden" name="community_id" value='<{$smarty.get.community_id}>'>
			<div class='form-group'>
				<label>商品名称：</label>
				<input id='goods_name' class='form-control' type="text" name="goods_name" value='<{$smarty.get.goods_name}>'>
			</div>
			<div class='form-group'>
				<label>开始时间：</label>
				<input id='start' class='form-control' type="text" name="start" value='<{$smarty.get.start}>' autocomplete="off">
			</div>
			<div class='form-group'>
				<label>结束时间：</label>
				<input id='end' class='form-control' type="text" name="end" value='<{$smarty.get.end}>' autocomplete="off">
			</div>
			<button type='submit' class='btn btn-primary btn-sm'><i class='fa icon-search'></i>搜索</button>
		</form>
	</div>
</div>
<table class='table table-hover'>
	<thead>
		<tr>
			<th>商品图片</th>
			<th>商品名称</th>
			<th>数量</th>
		</tr>
	</thead>
	<tbody>
		<{foreach $total as $item}>
		<tr>
			<td>
				<img style='width: 80px;height: 80px;border-radius: 5px;' src="<{$item.cover}>">
			</td>
			<td><{$item.name}></td>
			<td><{$item.num}></td>
		</tr>
		<{/foreach}>
	</tbody>
</table>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
	$(function(){
		laydate.render({
			elem: '#start' ,
			type:'datetime'
		});
		laydate.render({
			elem: '#end' ,
			type:'datetime'
		});
	});
</script>
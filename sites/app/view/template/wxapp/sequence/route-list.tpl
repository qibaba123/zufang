<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<style type="text/css">
	.form-inline .form-control{
		width: auto!important;
	}
	.dropdown-menu{
		z-index: 1200 !important;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body'>
		<form class='form-inline' method="get">
			<div class='form-group'>
				<label>路线名称：</label>
				<input  class='form-control' type="text" name="route_name" value="<{$smarty.get.route_name}>">
			</div>
			<div class='form-group'>
				<label>配送员：</label>
				<input  class='form-control' type="text" name="delivery_name" value="<{$smarty.get.delivery_name}>">
			</div>
			<div class='form-group'>
				<label>配送员联系电话：</label>
				<input  class='form-control' type="number" name="delivery_mobile" value="<{$smarty.get.delivery_mobile}>">
			</div>
			<div class='form-group'>
				<label>小区名称：</label>
				<input  class='form-control' type="text" name="delivery_community" value="<{$smarty.get.delivery_community}>">
			</div>
			<button type='submit' class='btn btn-primary btn-sm'><i class='fa icon-search'></i>搜索</button>
		</form>
	</div>
</div>
<div class='row' style='padding-bottom: 10px;'>
	<div class='col-xs-12'>
		<a href='/wxapp/sequence/viewEditRoute' class='btn btn-success btn-sm'><i class='fa fa-plus'></i>新增路线</a>
		<a class='btn btn-primary btn-sm print-modal-btn' data-toggle="modal" data-target="#printModal" data-type="3" data-id="0">分拣配货单</a>
		<a class='btn btn-warning btn-sm export' data-all='all'>导出当前页面配送数据</a>
		<a class='btn btn-warning btn-sm print-modal-btn' data-type='2' data-all='all' data-toggle="modal" data-target="#printModal">导出当前页面交货单</a>
		<a class='btn btn-warning btn-sm print-modal-btn' data-type='1' data-all='all' data-toggle="modal" data-target="#printModal">导出当前页面提货单</a>
		<span style='color: #9a999e;padding-left: 20px;font-size: 12px;'>Tips:批量导出数据请允许浏览器在当前页面打开新窗口</span>
	</div>
</div>
<table class='table table-hover'>
	<thead>
		<tr>
			<th>路线名称</th>
			<th>配送员</th>
			<th>手机号码</th>
			<th>配送小区数量</th>
			<th>排序</th>
			<th>添加时间</th>
			<th class='text-right'>操作</th>
		</tr>
	</thead>
	<tbody>
		<{foreach $route_list as $item}>
		<tr>
			<td><{$item.asdr_name}></td>
			<td><{$item.asdr_delivery_name}></td>
			<td><{$item.asdr_delivery_mobile}></td>
			<td><{$item.asdr_delivery_num}></td>

			<td><{$item.asdr_sort}></td>

			<td><{date('Y/m/d H:i',$item.asdr_create_time)}></td>
			<td class='text-right'>
				<button class='btn btn-default btn-sm change-sort' data-id='<{$item.asdr_id}>' data-sort='<{$item.asdr_sort}>' data-toggle="modal" data-target="#sortModal" >排序</button>
				<a href="#" data-id="<{$item.asdr_id}>" class="btn btn-default btn-sm print-modal-btn" data-type="1" data-toggle="modal" data-target="#printModal">提货单</a>
				<a href="#" data-id="<{$item.asdr_id}>" class="btn btn-default btn-sm print-modal-btn" data-type="2" data-toggle="modal" data-target="#printModal">交货单</a>
				<button data-rid='<{$item.asdr_id}>' class='btn btn-primary btn-sm export'>导出配送</button>
				<a href='/wxapp/sequence/viewEditRoute?route_id=<{$item.asdr_id}>' class='btn btn-success btn-sm view'>查看</a>
				<button data-rid='<{$item.asdr_id}>' class='btn btn-danger btn-sm delete'>删除</button>
			</td>
		</tr>
		<{/foreach}>
	</tbody>
</table>
<div class='text-right'>
	<{$paginator}>
</div>


<div id='sortModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="width: 500px;margin-right: auto !important;margin-left: auto">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">线路排序</h4>
			</div>
			<input type="hidden" id="route_com_id" value="">
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-3 control-label no-padding-right" for="route_com_sort" style="text-align: center">排序：</label>
					<div class="col-sm-8">
						<input id="route_com_sort" type="text" class="form-control" placeholder="越大越靠前" style="height:auto!important"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='submitSort' type="button" class="btn btn-primary">保存</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- 配送数据导出 -->
<div id='exportModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">配送数据导出</h4>
			</div>
			<div class="modal-body">
				<div class='form'>
					<input type="hidden" id="export-all" value=''>
					<input id='hidden_route_id' type="hidden" name="">
					<div class='form-group' >
						<label>汇总方式：</label>
						<select id="excel_type" name="excel_type" class="form-control">
							<option value="1">按小区汇总</option>
							<option value="2">按商品汇总</option>
						</select>
					</div>
					<div class='form-group'>
						<label>订单状态</label>
						<select id="trade_finished" name="trade_finished" class="form-control">
							<option value="1">已付款</option>
							<option value="2">已完成</option>
							<option value="3">已付款和已完成</option>
						</select>
					</div>
					<div class='form-group'>
						<label>N日后配送商品</label>
						 <div class="checkbox">
							<label>
								<input id='sequence_day_1' name='sequence_day_1' type="checkbox" checked value="1"> 包含N日后配送商品(以导出时的结束日期为准)
							</label>
						</div>
					</div>
				
					<div class='form-group'>
						<label>开始时间：</label>
						<input id='start' class='form-control' type="text" autocomplete="off" readonly>
					</div>
					<div class='form-group'>
						<label>结束时间：</label>
						<input id='end' class='form-control' type="text" autocomplete="off" readonly>
					</div>
					<div class='text-danger text-center'>
						<small>
						*状态为「已完成」的订单，将不会导出到配送数据中*
						<br>
						*没有订单数据的小区将不会进行数据导出*
						</small>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='exportSave' type="button" class="btn btn-primary">导出</button>
			</div>
		</div>
	</div>
</div>

<!-- 打印 -->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="printModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 700px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="printModalLabel">
					打印
				</h4>
			</div>
			<div class="modal-body" style="text-align: center;margin-bottom: 45px;">
				<div class="modal-plan p_num clearfix shouhuo">
					<form class='form-horizontal'>
						<input type="hidden" id="print_all" value=''>
						<input type="hidden" value="" id="print_type">
						<input type="hidden" value="" id="print_id">
						<div class="space"></div>
						<div class="form-group" style="height: 10px">
							<label class="col-sm-2 control-label">订单状态</label>
							<div class="col-sm-4">
								<select name="order_status" id="order_status" class="form-control">
									<option value="1">已付款</option>
									<option value="2">已完成</option>
									<option value="3">已付款和已完成</option>
								</select>
							</div>
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-4 ">

							</div>
						</div>
						<div class="space"></div>

						<div class="search-reason search-reason-3 search-route-id">
							<div class="form-group" style="height: 10px">
								<label class="col-sm-2 control-label">线路</label>
								<div class="col-sm-4">
									<select name="print_route_id" id="print_route_id" class="form-control">
										<option value="0">全部</option>
										<{foreach $route_list_all as $item}>
										<option value="<{$item.asdr_id}>"><{$item.asdr_name}></option>
										<{/foreach}>
									</select>
								</div>
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-4 ">

								</div>
							</div>
							<div class="space"></div>
						</div>

						<div class="search-reason search-reason-2 search-goods-name">
							<div class="form-group" style="height: 10px">
								<label class="col-sm-2 control-label">商品名称</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="print_goods_name" name="print_goods_name">
								</div>
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-4 ">

								</div>
							</div>
							<div class="space"></div>
						</div>
						<div class='form-group sort-community'>
							<label class="col-sm-2 control-label">按小区合并</label>
							<div class="col-sm-8">
								 <div class="checkbox text-left">
									<label>
										<input id='community_sort' name='community_sort' type="checkbox" checked value="1">按照小区进行合并(勾选后按照线路中的小区进行分类合并)
									</label>
								</div>
							</div>
						</div>
						<div class='form-group'>
							<label class="col-sm-2 control-label">N日后配送</label>
							<div class="col-sm-6">
								 <div class="checkbox text-left">
									<label>
										<input id='sequence_day' name='sequence_day' type="checkbox" checked value="1"> 包含N日后配送商品(以导出时的结束日期为准)
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">开始日期</label>
							<div class="col-sm-4">
								<input class="form-control date-picker" type="text" id="print_start_date" data-date-format="yyyy-mm-dd" name="print_start_date" placeholder="请输入开始日期" autocomplete="off" />
							</div>
							<label class="col-sm-2 control-label">开始时间</label>
							<div class="col-sm-4 bootstrap-timepicker">
								<input class="form-control" type="text" name="timepicker_print_start" id="timepicker_print_start" placeholder="请输入开始时间" autocomplete="off" value="00:00:00" />
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">结束日期</label>
							<div class="col-sm-4">
								<input class="form-control date-picker" type="text" id="print_end_date" data-date-format="yyyy-mm-dd" name="print_end_date" placeholder="请输入结束日期" autocomplete="off"  />
							</div>
							<label class="col-sm-2 control-label">结束时间</label>
							<div class="col-sm-4 bootstrap-timepicker">
								<input class="form-control" type="text" id="timepicker_print_end" name="timepicker_print_end" placeholder="请输入结束时间" autocomplete="off" value="23:59:59" />
							</div>
						</div>
						<button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
						<button type="button" class="btn btn-primary printConGoods" >打印</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
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
		$('.delete').click(function(){
			let _this=$(this);
			let uid=$(this).data('rid');
			if(!uid){
				layer.msg('请选择要删除的路线');
			}
			layer.confirm('您确定要删除当前路线及路线中的小区关联吗？', {
               	title:'删除提示',
               	btn: ['确定','取消']
            }, function(){
            	if(!confirm('请确认您的删除操作！'))
            		return;
               	$.ajax({
               		type:'post',
               		url:'/wxapp/sequence/deleteDeliveryRoute',
               		dataType:'json',
               		data:{
               			'route_id':uid
               		},
               		success:function(res){
               			layer.msg(res.em);
               			if(res.ec==200){
               				_this.parent().parent().remove();
               			}
               		}
               	});
            })
		});

		$('.export').click(function(){
			let all=$(this).data('all');
			if(all){
				$('#export-all').val(true);
			}else{
				$('#export-all').val(false);
			}
			let route_id=$(this).data('rid');
			$('#hidden_route_id').val(route_id);
			$('#exportModal').modal('show');
		});
		$('#exportSave').click(function(){
			let route_id		=$('#hidden_route_id').val();
			let start			=$('#start').val();
			let end				=$('#end').val();
			let type			= $('#excel_type').val();
			let sequence_day	=$('#sequence_day_1:checked').val();
			let trade_finished	=$('#trade_finished').val();
			sequence_day=typeof(sequence_day)!='undefined'?sequence_day:0;

			let all=$('#export-all').val();
			if(all=='true'){
				let ids=getRouterIds();
				if(ids==null){return;}
				for(let i=0;i<ids.length;i++){
					let url='/wxapp/sequence/exportRouteDeliveryData?route_id='+ids[i]+'&start='+start+'&end='+end+'&do_export=1&type='+type+'&sequence_day='+sequence_day+'&multi=1'+'&status='+trade_finished;
					window.open(url);
				}
			}else{
				$.ajax({
					type:'post',
					url:'/wxapp/sequence/exportRouteDeliveryData',
					dataType:'json',
					data:{
						'route_id':route_id,
						'start':start,
						'end':end,
						'type':type,
						'sequence_day':sequence_day,
						'status':trade_finished,
					},
					success:function(res){					
						if(res.ec==400){
							layer.msg(res.em);
						}else{
							window.location.href='/wxapp/sequence/exportRouteDeliveryData?route_id='+route_id+'&start='+start+'&end='+end+'&do_export=1&type='+type+'&sequence_day='+sequence_day+'&status='+trade_finished;
						}
					}
				});
			}
			// window.location.href='/wxapp/sequence/exportRouteDeliveryData?route_id='+route_id+'&start='+start+'&end='+end;		
			
		});

		/*初始化日期选择器*/
		$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

		$("input[id^='timepicker']").timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
	});


	$('.printCon').on('click',function(){
		var type = $(this).data('type');
		var id  = $(this).data('id');
		window.location.href='/wxapp/print/sequencePrintWord?id='+id+'&type='+type
	});

	$('.printConGoods').on('click',function(){
		let type			= $('#print_type').val();
		let id				= $('#print_id').val();
		let start_date		= $('#print_start_date').val();
		let start_time		= $('#timepicker_print_start').val();
		
		let end_date		= $('#print_end_date').val();
		let end_time		= $('#timepicker_print_end').val();
		
		let order_status	= $('#order_status').val();
		
		let goods_name		= $('#print_goods_name').val();
		let route_id		= $('#print_route_id').val();
		let sequence_day	= $('#sequence_day:checked').val();
		let community_sort	= $('#community_sort:checked').val();
		sequence_day		= (typeof(sequence_day)!='undefined')?sequence_day:0;
		let url;
		if(type == 3){
			url = '/wxapp/print/sequencePrintWordGoods'
		}else{
			url = '/wxapp/print/sequencePrintWord'
		}
		// 查询是否是批量导出
		let all=$('#print_all').val();
		if(all=='true'){
			let ids=getRouterIds();
			if (ids==null){return;}
			for(let i=0;i<ids.length;i++){
				var print_url = url+'?print_start_date='+start_date+'&type='+type+'&print_start_time='+start_time+'&print_end_date='+end_date+'&print_end_time='+end_time+'&id='+ids[i]+'&order_status='+order_status+'&goods_name='+goods_name+'&route_id='+route_id+'&sequence_day='+sequence_day+'&with_comm='+community_sort;
				window.open(print_url);
			}
		}else{
			var print_url = url+'?print_start_date='+start_date+'&type='+type+'&print_start_time='+start_time+'&print_end_date='+end_date+'&print_end_time='+end_time+'&id='+id+'&order_status='+order_status+'&goods_name='+goods_name+'&route_id='+route_id+'&sequence_day='+sequence_day+'&with_comm='+community_sort;
			window.location.href= print_url;
		}
		

	

	});

	function openDownloadDialog(url, saveName)
	{
		if(typeof url == 'object' && url instanceof Blob)
		{
			url = URL.createObjectURL(url); // 创建blob地址
		}
		var aLink = document.createElement('a');
		aLink.href = url;
		aLink.download = saveName || ''; // HTML5新增的属性，指定保存文件名，可以不要后缀，注意，file:///模式下不会生效
		var event;
		if(window.MouseEvent) event = new MouseEvent('click');
		else
		{
			event = document.createEvent('MouseEvents');
			event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
		}
		let res = aLink.dispatchEvent(event);
	}

	$('.printConNew').on('click',function(){
		var type = $(this).data('type');
		var id  = $(this).data('id');
		var href ='/wxapp/print/sequencePrintWord?id='+id+'&type='+type;
		openDownloadDialog(href);
	});

	$('.print-modal-btn').click(function () {
		let type = $(this).data('type');
		let all  = $(this).data('all');
		if(all){
			$('#print_all').val(true);
		}else{
			$('#print_all').val(false);
		}
		$('#print_type').val(type);
		let id = $(this).data('id');
		$('#print_id').val(id);
		$('.search-goods-name').hide();
		$('.sort-community').show();
		if(id > 0){
			$('.search-route-id').hide();
			if(type == 2){
				$('.search-goods-name').show();
				$('.sort-community').hide();
			}else if(type == 1){
				$('.sort-community').hide();
			}
		}else{
			$('.search-route-id').show();
		}
	});
	// 获取当前页面所有的路线名称
	function getRouterIds(){
		let ids=new Array();
		$('.delete').each(function(){
			ids.push($(this).data('rid'));
		});
		return ids;
	}


	$('.change-sort').click(function () {
		let id=$(this).data('id');
		let sort=$(this).data('sort');
		$('#route_com_id').val(id);
		$('#route_com_sort').val(sort);
	});

	// 提交排序数据
	$('#submitSort').click(function(){
		let id=$('#route_com_id').val();
		let sort=$('#route_com_sort').val();

		$.ajax({
			type:'POST',
			url:'/wxapp/sequence/changeRouteSort',
			dataType:'json',
			data:{
				'id'		:id,
				'sort'		:sort,
			},
			success:function(res){
				layer.msg(res.em);
				if(res.ec==200){
					window.location.reload();
				}
			}
		});
	});

</script>

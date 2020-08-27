<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/leader-rank.css">
<style type="text/css">
	#form .label{
		height: 25px;
		line-height: 1.4;
		padding: 4px 12px;
		cursor: pointer;
		background-color: #abbac3 !important;
	}
	#form .active{
		background-color: #3a87ad !important;
	}
	.font-bold{
		font-size: 14px;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<form id='form' class='form-inline'>
			<div class='form-group'>
				<a class='btn btn-sm btn-success' data-toggle="modal" data-target="#export-modal"><i class='icon-cloud-download'></i>导出排行</a>
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
				<span name='all' class="search label label-info <{if $smarty.get.start=='all' || $smarty.get.start==''}>active<{/if}>">全部</span>
				<span name='today' class="search label label-info  <{if $smarty.get.start=='today'}>active<{/if}>">今日</span>
				<span name='yesterday' class="search label label-info <{if $smarty.get.start=='yesterday'}>active<{/if}>">昨日</span>	
				<span name='week' class="search label label-info  <{if $smarty.get.start=='week'}>active<{/if}>">近7日</span>
				<span name='month' class="search label label-info  <{if $smarty.get.start=='month'}>active<{/if}>">近30日</span>&nbsp;&nbsp;
			</div>
			<div class='form-group'>
				<input name='start' type="text" id="start" class='form-control' placeholder="开始时间" value='<{if !in_array($smarty.get.start,["today","yesterday","week","month","all"])}><{$smarty.get.start}><{/if}>' autocomplete='off'>
			</div>
			<div class='form-group'>
				<input name='end' type="text" id="end" class='form-control' placeholder="结束时间" value='<{$smarty.get.end}>' autocomplete='off'>
			</div>
			<div class='form-group'>
				<select class='form-control' name='orderby' id='orderby'>
					<option value='money' <{if $smarty.get.orderby=='money'}>selected<{/if}>>按销售额</option>
					<option value='total' <{if $smarty.get.orderby=='total'}>selected<{/if}>>按订单量</option>
				</select>
			</div>
			<button type='button' class='btn btn-sm btn-info' id='getData'>查询</button>
		</form>
	</div>
</div>
<div class='panel panel-default'>
	<div class='panel-body'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<td>团长ID</td>
					<td>团长信息</td>
					<td>团长分成比例</td>
					<td>团长销售总额</td>
					<td>团长总订单数</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
				<{foreach $leader_rank as $item}>
				<tr>
					<td>
						<span class='text-info'><{$item.asl_id}></span>
					</td>
					<td>
						<div class='info'>
							<div>
								<img src="<{$item.m_avatar}>">
							</div>
							<div>
								<p>团长昵称：<{$item.m_nickname}></p>
								<p>团长姓名：<{$item.asl_name}></p>
								<p>手机号码：<{$item.asl_mobile}></p>
							</div>
						</div>
					</td>
					<td>
						<span class='font-bold'><{$item.asl_percent}>%</span>
					</td>
					<td>
						<span class='text-danger font-bold'>￥
						<{if $item.money}>
						<{$item.money}>
						<{else}>
						0
						<{/if}>
						</span>
					</td>
					<td>
						<span class='font-bold'>
						<{if $item.total}>
						<{$item.total}>
						<{else}>
						0
						<{/if}>
						</span>
					</td>
					<td>
						<p>
							<a href="/wxapp/sequence/leaderInfo?id=<{$item.asl_id}>">团长营业额统计</a>
						</p>
						<p>
							<a href="/wxapp/seqstatistics/leaderOrder?id=<{$item.asl_id}>">订单统计</a>
						</p>
						<p>
							<a href="/wxapp/seqstatistics/leaderGoods?id=<{$item.asl_id}>">团长商品</a>
						</p>
						<p>
							<a href="/wxapp/sequence/leaderDeductRecordNew?id=<{$item.asl_id}>">团长佣金统计</a>
						</p>
					</td>
				</tr>
				<{/foreach}>
			</tbody>
		</table>
		<!--<div class='text-right'>
			
		</div>-->
	</div>
</div>
<{if $showPage != 0 }>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><{$paginator}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>

<div id='export-modal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">团长排行导出</h4>
			</div>
			<div class="modal-body">
				<form id='export-form' class='form-horizontal' onsubmit="return false">
					<div class='form-group'>
						<label for="order-status" class="col-sm-2 control-label">订单状态</label>
					    <div class="col-sm-10">
					    	<label>
					          	<input type="radio" name='order-status' value=0 checked> 全部
					        </label>
					        &nbsp;&nbsp;&nbsp;
					        <label>
					          	<input type="radio" name='order-status' value=1> 已完成
					        </label>
					    </div>
					</div>
					<div class='form-group'>
						<label for="order-status" class="col-sm-2 control-label">时间</label>
					    <div class="col-sm-5">
					        <input class='form-control' type="text" name='start' id='export-start' autocomplete="off" readonly>
					 	</div>
					    <div class="col-sm-5">
					        <input class='form-control' type="text" name='end' id='export-end' autocomplete='off' readonly>
					    </div>
					</div>
					<div class='help-block text-center'>*时间为空默认导出全部数据*</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button type="button" class="btn btn-primary" id='export-rank'>导出</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
	$(function(){
		laydate.render({
		  elem: '#start' 
		});
		laydate.render({
		  elem: '#end' 
		});
		laydate.render({
			elem: '#export-start',
			type:'datetime'
		});
		laydate.render({
			elem: '#export-end' ,
			type:'datetime'
		});
		$('.search').click(function(){
			// location.href='/wxapp/seqstatistics/leaderRank?start='+$(this).attr('name');
			let type=$(this).attr('name');
			let params=getQueryVariable();
			params['start']=type;
			location.href='/wxapp/seqstatistics/leaderRank?'+$.param(params);
		});
		$('#getData').click(function(){
			// 获取预设标签中选中的内容 
			// 获取自定义查询日期中的数值
			// 获取排序规则
			let type=$('#form span.active').attr('name');
			let start=$('#start').val();
			let end=$('#end').val();
			let orderby=$('#orderby').val();

			let params='?';
			if(start && end){
				params+='start='+start+'&end='+end;
			}else if(type){
				params+='start='+type;
			}
			if(orderby){
				params+='&orderby='+orderby;
			}
			window.location.href='/wxapp/seqstatistics/leaderRank'+params;
		});

		// 筛选订单类型
		$('.finish').click(function(){
			let type=$(this).data('type');
			let params=getQueryVariable();
			params['finish_only']=type;
			location.href='/wxapp/seqstatistics/leaderRank?'+$.param(params);
		});
		// 获取url参数
		function getQueryVariable(){
	       let query = window.location.search.substring(1);
	       let vars = query.split("&");
	       let params={};
	       for (let i=0;i<vars.length;i++) {
               let pair = vars[i].split("=");
               params[pair[0]]=pair[1];
	       }
	       return params;
		}
		//团长排行数据导出
		$('#export-rank').click(function(){
			var index = layer.load(10, {
                shade: [0.6,'#666']
            });
			$.ajax({
				type:'POST',
				url:'/wxapp/seqstatistics/leaderRankExport',
				dataType:'json',
				data:$('#export-form').serialize(),
				success:function(res){
	    			if(res.ec==200){
	    				window.location.href=res.data.url;
	    			}else{
	    				layer.msg(res.em);
	    			}
	    			layer.close(index);
	    		},
	    		error:function(){
					layer.msg('数据导出失败，请稍后再试');
	    		},
	    		complete:function(){
	    			layer.close(index);
	    		}
			});
		});

	})
</script>
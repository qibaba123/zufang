<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/leader-rank.css">
<style>
	.label{
		line-height: 20px;
	}
	.calender input[type="text"]{
		display: none;
	}
	.font-bold{
		font-size: 14px;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<form class='form-inline' action='/wxapp/seqstatistics/sequenceCommunityRank' action='get'>
			<input id='finish_only' type="hidden" name="finish_only" value='<{$smarty.get.finish_only}>'>
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
			<div class='form-group calender'>
				<input  id='start_date' class='form-control' name='start' type="text" name="" placeholder="开始时间" autocomplete="off" value='<{$smarty.get.start}>' disabled>	
			</div>
			<div class='form-group calender'>
				<input  id='end_date' class='form-control' name='end' type="text" name="" placeholder="结束时间" autocomplete="off" value='<{$smarty.get.end}>' disabled>
			</div>
			<div class='form-group'>
				<select id='searchType' class='form-control' name='searchType'>
					<option value='all' <{if $smarty.get.searchType=='all'}>selected<{/if}>>总排行</option>
					<option value='month' <{if $smarty.get.searchType=='month'}>selected<{/if}>>本月排行</option>
					<option value='customer' <{if $smarty.get.searchType=='customer'}>selected<{/if}>>自定义查询</option>
				</select>
			</div>
		
			<div class='form-group'>
				<select class='form-control' name='sortType'>
					<option value='nums' <{if $smarty.get.sortType=='nums'}>selected<{/if}>>按销售数</option>
					<option value='total' <{if $smarty.get.sortType=='total'}>selected<{/if}>>按销售额</option>

				</select>
			</div>
			<button class='btn btn-sm btn-info'>查询</button>
		</form>
	</div>
</div>
<div class='help-block text-right'>
	<small class='text-warning'>*已自动略无信息数据*</small>
</div>
<div class='panel panel-default'>
	<div class='panel-body'>
		<table class='table table-hover'>
			<thead>
				<tr>
					<td>排行</td>
					<td>小区信息</td>
					<td>团长信息</td>
					<td>销售数</td>
					<td>销售额</td>
				</tr>
			</thead>
			<tbody>
				<{foreach $list as $key => $item}>
				<tr>
					<td>
						<{if $smarty.get.page*50+$key+1 <= 5}>
						<span class='label label-danger label-padding'><{$smarty.get.page*50+$key+1}></span>
						<{else}>
						<span class='label label-default label-padding'><{$smarty.get.page*50+$key+1}></span>
						<{/if}>
					</td>
					<td>
						<div>
							<p style="font-weight: bold"><{$item.asc_name}></p>
							<p>粉丝数：<{$item.asc_member}></p>
							<p>取货地址：<{$item.asc_address_detail}></p>
						</div>
					</td>
					<td class='info'>
						<div>
							<img src="<{$item.m_avatar}>">
						</div>
						<div>
							<p>团长昵称：<{$item.m_nickname}></p>
							<p>团长姓名：<{$item.asl_name}></p>
							<p>手机号码：<{$item.asl_mobile}></p>
						</div>
					</td>
					<td>
						<span class='font-bold'><{$item.nums}></span>
					</td>
					<td>
						<span class='font-bold'>￥<{$item.total}></span>
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
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
	$(function(){
		laydate.render({
		  elem: '#start_date' 
		});
		laydate.render({
		  elem: '#end_date' 
		});
		if($('#searchType').val()=='customer'){
			$('.calender input[type="text"]').css({'display':'block'});
			$('.calender input[type="text"]').attr('disabled',false);
		}
		$('#searchType').change(function(){
			let type=$(this).val();
			if(type=='customer'){
				$('.calender input[type="text"]').css({'display':'block'});
				$('.calender input[type="text"]').attr('disabled',false);
			}else{
				$('.calender input[type="text"]').css({'display':'none'});
				$('.calender input[type="text"]').attr('disabled',true);
			}
		});
		// 筛选订单类型
		$('.finish').click(function(){
			let type=$(this).data('type');
			let params=getQueryVariable();
			params['finish_only']=type;
			location.href='/wxapp/seqstatistics/sequenceCommunityRank?'+$.param(params);
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
	});
</script>
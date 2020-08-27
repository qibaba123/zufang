<style type="text/css">
	.balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
        display: flex;
    }
    .balance-info {
    	flex: 1;
        text-align: center;
        padding: 0 15px 30px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance-info:nth-of-type(1){
    	border-left: none;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
</style>
<div class='panel panel-default'>
	<div class='panel-body'>
		<!-- 汇总信息 -->
	    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
	        <div class="balance-info">
	            <div class="balance-title">总收益<span></span></div>
	            <div class="balance-content">
	                <span class="money"><{$brokerage_sum}></span>
	                <span class="unit">元</span>
	            </div>
	        </div>
	        <div class="balance-info">
	            <div class="balance-title">已提现<span></span></div>
	            <div class="balance-content">
	                <span class="money"><{$already_money}></span>
	                <span class="unit">元</span>
	            </div>
	        </div>
	        <div class="balance-info">
	            <div class="balance-title">待审核<span></span></div>
	            <div class="balance-content">
	                <span class="money"><{$review_money}></span>
	                <span class="unit">元</span>
	            </div>
	        </div>
	        <{if $area_info==1}>
	        <div class="balance-info">
	            <div class="balance-title">提现管理<span></span></div>
	            <div class="balance-content">
	                <button id='get_money' class='btn btn-sm btn-green'>提现</button>
	            </div>
	        </div>
	        <{/if}>
	    </div>
		<div>
			<!-- Nav tabs -->
			<ul id='tabs' class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#brokerage" aria-controls="brokerage" role="tab" data-toggle="tab">佣金记录</a></li>
				<li role="presentation"><a href="#withdraw" aria-controls="withdraw" role="tab" data-toggle="tab">提现记录</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="brokerage">
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>订单编号</th>
								<th>订单金额</th>
								<th>佣金状态</th>
								<th>获取时间</th>
							</tr>
						</thead>
						<tbody>
							<{foreach $brokerage_list as $item}>
							<tr>
								<td>
									<a target="_blank" title='查看订单详情' href="/wxapp/order/tradeDetail?order_no=<{$item.armb_tid}>"><{$item.armb_tid}></a>
								</td>
								<td><span class='text-danger'>￥<{sprintf('%.2f',$item.armb_money/100)}></span></td>
								<td>
									<{if $item.armb_status==1}>
									<span class='text-success'>佣金已获取</span>
									<{else}>
									<span class='text-danger'>订单未完成</span>
									<{/if}>
								</td>
								<td><{date('Y/m/d H:i:s',$item.armb_create_at)}></td>
							</tr>
							<{/foreach}>
						</tbody>
					</table>
					<div class='text-right'>
						<{$paginator}>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="withdraw">
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>提现金额</th>
								<th>提现方式</th>
								<th>提现状态</th>
								<th>申请时间</th>
								<th>审核说明</th>
							</tr>
						</thead>
						<tbody>
							<{foreach $withdraw_list as $item}>
							<tr>
								<td><span class='text-danger'>￥<{sprintf('%.2f',$item.arwr_money/100)}></span></td>
								<td><{if $item.arwr_type==0}>微信<{else if $item.arwr_type==1}>人工转账<{else}>其他<{/if}></td>
								<td>
									<{if $item.arwr_status==0}>
									<span class='text-warning'>审核中</span>
									<{else if $item.arwr_status==1}>
									<span class='text-success'>已通过</span>
									<{else if $item.arwr_status==2}>
									<span class='text-danger'>已拒绝</span>
									<{/if}>
								</td>
								<td><{date('Y/m/d H:i:s',$item.arwr_create_at)}></td>
								<td>
									<{if $item.arwr_remark}>
									<{$item.arwr_remark}>
									<{else}>
									无
									<{/if}>
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

		</div>
	</div>
</div>
<!-- 提现处理 -->
<div class="modal fade" id="get_modey_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="text-align: left;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="excelOrderLabel">
					佣金提现
				</h4>
			</div>
			<div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
				<div class="modal-plan">
					<div class='form form-horizontal'>
						<div class='form-group'>
							<label class='col-xs-2'>提现方式:</label>
							<div class='col-xs-6'  style='text-align:left;'>
								<label class="radio-inline">
									<input type="radio" name="money_type" value="0" checked="checked" disabled> 微信
								</label>
							</div>
						</div>
						<div class='form-group'>
							<label class='col-xs-2'>提现金额:</label>
							<div class='col-xs-6'>
								<input class='form-control' type="number" id="money" value=''>
							</div>
						</div>
						<div class='form-group'>
							<div class='col-xs-offset-2 col-xs-6'>
								<button id='get_money_submit' class='btn btn-sm btn-primary'>申请提现</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>

<script type="text/javascript">
	$(function(){
		// 设置默认tab标签页
		let type='<{$smarty.get.type}>';
		if(type=='brokerage'||type==''){
			$('#tabs a[href="#brokerage"]').tab('show');
		}else if(type=='withdraw'){
			$('#tabs a[href="#withdraw"]').tab('show');
		}
		// 切换标签页
		$('#tabs a[data-toggle="tab"]').click(function(){
			let type=$(this).attr('aria-controls');
			let params=getQueryVariable();
			if(typeof(params)=='undefiend')
				params=null;
			params['type']=type;
			window.location.href='/wxapp/Seqregion/regionBrokerage?'+$.param(params);;
		});

		$('#get_money').click(function(){
			$('#get_modey_modal').modal('show');
		});
		// 提现处理
		$('#get_money_submit').click(function(){
			let money=$('#money').val();
			$.ajax({
				'type'  : 'post',
                'url'   : '/wxapp/sequence/regionGetMoney',
                'data'  : {
                	'money':money
                },
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        setTimeout(function(){
                        	window.location.reload();
                        },500);
                    }
                }
			})
		});
		// 获取页面的url 参数
		function getQueryVariable(){
			let query = window.location.search.substring(1);
			let vars = query.split("&");
			let params={};
			for (let i=0;i<vars.length;i++) {
				if(vars[i]=='')
					break;
			   let pair = vars[i].split("=");
			   params[pair[0]]=pair[1];
			}
			return params;
	   }
	});
</script>
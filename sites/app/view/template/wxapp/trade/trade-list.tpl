<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
	.datepicker{
		z-index: 1060 !important;
	}
	.ui-table-order .time-cell{
		width: 120px !important;
	}
	.form-group{
		margin-bottom: 10px !important;
	}
	.search-box{
		margin: 20px auto 20px;
	}
	.input-group .select2-choice{
		height: 34px;
		line-height: 34px;
		border-radius: 0 4px 4px 0 !important;
	}
	.input-group .select2-container{
		border: none !important;
		padding: 0 !important;
	}
	.balance .balance-info {
		width: 25% !important;
	}

	.entershop-select .select2-choice{
		height: 34px;
		line-height: 34px;
		border-radius: 0 4px 4px 0 !important;
	}
	.entershop-select .select2-container{
		border: none !important;
		padding: 0 !important;
	}

</style>


	<div>
		<a href="javascript:;" class="btn btn-green btn-xs btn-excel" ><i class="icon-download"></i>订单导出</a>
	</div>
	<div class="page-header search-box">
		<div class="col-sm-12">
			<form class="form-inline" action="/wxapp/zftrade/tradeList" method="get">
				<div class="col-xs-11 form-group-box" style="overflow: visible;">
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
								<div class="input-group-addon">预约人</div>
								<input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="预约人姓名">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">预约人电话</div>
								<input type="text" class="form-control" name="phone" value="<{$phone}>"  placeholder="预约人电话">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon" style="height:34px;">订单类型</div>
								<select id="type" name="type" style="height:34px;width:100%" class="form-control my-select2">
									<option value="0">全部</option>
									<option value="1" <{if $type == 1}>selected<{/if}>>园区服务</option>
									<option value="2" <{if $type == 2}>selected<{/if}>>企业服务</option>
									<option value="3" <{if $type == 3}>selected<{/if}>>VIP服务</option>
								</select>
							</div>
						</div>
						<div class="form-group" style="width: 400px">
							<div class="input-group">
								<div class="input-group-addon" >下单时间</div>
								<input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete='off'>
								<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
								<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
								<input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete='off'>
								<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
							</div>
						</div>
						<input type="hidden" name="status" value="<{$status}>">
					</div>
				</div>
				<div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 35%;right: 2%;">
					<button type="submit" class="btn btn-green btn-sm">查询</button>
				</div>
			</form>
		</div>
	</div>
	<!-- 订单汇总信息 -->
<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">今日收益<span></span></div>
            <div class="balance-content">
                <span class="money"><{if $today['money']}><{$today['money']}><{else}>0<{/if}></span>
                <span class="unit">元</span>
                <!--<a href="/manage/shop/inout" class="pull-right">收支明细</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">今日订单数<span></span></div>
            <div class="balance-content">
                <span class="money"><{if $today}><{$today['total']}><{else}>0<{/if}></span>
                <!--<span class="unit">元</span>
                <a href="/manage/shop/settled" class="pull-right">待结算记录</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">总收益

            </div>
            <div class="balance-content">
                <span class="money money-font"><{if $total['money']}><{$total['money']}><{else}>0<{/if}></span>
                <span class="unit">元</span>
                <!--<a href="/manage/shop/inout" class="pull-right" style="margin-left: 6px;"> 明细 </a>
                <!--<a href="/manage/withdraw/apply" class="ui-btn ui-btn-primary pull-right btn-margin-right js-goto-btn">提现</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">总订单数</div>
            <div class="balance-content">
                <span class="money money-font"><{if $total}><{$total['total']}><{else}>0<{/if}></span>
            </div>
        </div>
    </div>
	<div class="choose-state">
		<a href="/wxapp/zftrade/tradeList?status=0" <{if $status eq 0}>class="active"<{/if}>>全部</a>
		<a href="/wxapp/zftrade/tradeList?status=1" <{if $status && $status eq 1}>class="active"<{/if}>>待支付</a>
		<a href="/wxapp/zftrade/tradeList?status=2" <{if $status && $status eq 2}>class="active"<{/if}>>已支付</a>
		<a href="/wxapp/zftrade/tradeList?status=3" <{if $status && $status eq 3}>class="active"<{/if}>>已过期</a>
		<!---
				<button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;"><i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span></button>
		-->
	</div>
	<div class="trade-list">
		<table class="ui-table-order" style="padding: 0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
			<tr class="widget-list-header">
				<th class="" colspan="2" style="min-width: 212px; max-width: 212px;">商品</th>
				<th class="price-cell" style="min-width: 87px; max-width: 87px;">单价/期限</th>
				<th class="customer-cell" style="min-width: 110px; max-width: 110px;">买家</th>
				<th class="time-cell" style="min-width: 80px; max-width: 80px;">
					<a href="javascript:;" data-orderby="book_time">服务时间<span class="orderby-arrow desc">↓</span></a>
				</th>
				<th class="state-cell" style="min-width: 100px; max-width: 100px;">订单状态</th>
				<th class="pay-price-cell" style="min-width: 120px; max-width: 120px;">实付金额</th>
			</tr>
			</thead>

			<{foreach $list as $val}>
			<tbody class="widget-list-item">
			<tr class="separation-row">
				<td colspan="8"></td>
			</tr>
			<tr class="header-row">
				<td colspan="6">
					<div>
						订单号: <{$val['rt_tid']}> (<{$goods_type[$val['rt_type']]}>)

					</div>
					<div class="clearfix">
					</div>
				</td>
				<td colspan="2" class="text-right">
				<!--	<div class="order-opts-container">
						<div class="js-opts" style="display: block;">
							<{if $pointOrder == 1}>
							<a href="/wxapp/community/pointTradeDetail?order_no=<{$val['t_tid']}>" class="new-window" >查看详情</a>
							<{else}>
							<a href="/wxapp/community/tradeDetail?order_no=<{$val['t_tid']}>" class="new-window" >查看详情</a>
							<{/if}>
							<{if $hideDeduct != 1}>
							- <a href="javascript:;" data-tid="<{$val['t_tid']}>" class="js-deduct">查看分佣</a>
							<{/if}>
							<a href="#" class="js-remark hide">备注</a>
						</div>
					</div>-->
				</td>
			</tr>
			<tr class="content-row">
				<td class="image-cell">
					<img src="<{$val['rt_cover']}>">
				</td>
				<td class="title-cell">
					<p class="goods-title">
						<a href="/wxapp/zftrade/tradeList?title=<{$val['rt_g_name']}>"class="new-window" title="<{$val['rt_g_name']}>">
							<{if $val['rt_nume']}>[<{$val['rt_number']}>]<{/if}><{$val['rt_g_name']}><{if $val['re_format'] != 0}><{$val['sf_name']}><{/if}>
						</a>
					</p>
					<p>
					</p>
				</td>
				<td class="price-cell">
					<p>
						<{$val['rt_g_price']}>
					</p>
					<p>(<{$val['rt_time_num']}><{$time_type[$val['rt_time_type']]}>)</p>
				</td>
				<td class="customer-cell" rowspan="1">
					<p>
						<a href="/wxapp/zftrade/tradeList?buyer=<{$val['rt_m_nickname']}>" class="new-window" target="_blank">
							<{$val['rt_m_nickname']}>
						</a>
					</p>
					<p class="user-name"><{$val['rt_m_name']}></p>
					<{$val['rt_m_mobile']}>
				</td>
				<td class="time-cell" rowspan="1">
					<div class="td-cont">
						<{date('Y-m-d',$val['rt_start_time'])}>
						<p>至</p>
						<{date('Y-m-d',$val['rt_end_time'])}>
					</div>
				</td>
				<td class="state-cell" rowspan="1">
					<div class="td-cont">
						<p class="js-order-state" id="status_<{$val['t_tid']}>"><{$statusNote[$val['rt_status']]}></p>
					</div>
				</td>
				<td class="pay-price-cell" rowspan="1">
					<div class="td-cont text-center">
						<div>
							<{$val['rt_fee']}>
							<br>

						</div>

					</div>
				</td>
			</tr>
			<{if $val['rt_note']}>
				<tr class="remark-row buyer-msg">
					<td colspan="8">买家备注： <{$val['rt_note']}></td>
				</tr>
				<{/if}>
			</tbody>
			<{/foreach}>

			<tbody class="widget-list-item">
			<tr class="separation-row">
				<td colspan="8"><{$page_html}> </td>
			</tr>
			</tbody>

		</table>
		<div id="refund-form"  class="modal fade">
			<div class="modal-dialog" style="width:760px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="modelTitle">退款处理</h4>
					</div>
					<div class="modal-body">
						<div class="row hid-row" id="show-deduct">
							<table class="ui-table" style="margin-bottom:20px;">
								<thead>
								<tr>
									<th></th>
									<th>总价</th>
									<th>购买人</th>
									<th>购买人返现</th>
									<th>上级</th>
									<th>上级返现</th>
									<th>上二级</th>
									<th>上二级返现</th>
									<th>上三级</th>
									<th>上三级返现</th>
									<th>返现状态</th>
								</tr>
								</thead>
								<tbody id="deduct-tr">

								</tbody>
							</table>
						</div>
						<form class="form-inline form-horizontal">
							<input type="hidden" id="hid_id" value="0">
							<input type="hidden" id="modal-type" value="refund">
							<input type="hidden" id="cate" value="list">
							<div class="row hid-row" id="show-refund">
								<div class="checkbox col-sm-12 mod-div">
									<label>审核状态 ： &nbsp;&nbsp;</label>
									<label>
										<input type="radio" name="status" checked value="2"> &nbsp; 通 &nbsp; 过 &nbsp;
									</label>
									<label>
										<input type="radio" name="status" value="1">  &nbsp; 拒 &nbsp; 绝 &nbsp;
									</label>
								</div>
							</div>
							<div class="row hid-row" id="show-express" style="margin:0">
								<!--发货HTML-->
								<table class="ui-table" style="margin-bottom:20px;">
									<thead>
									<tr>
										<th class="cell-35">商品</th>
										<th class="cell-5">数量</th>
										<th class="cell-5">单价</th>
										<th class="cell-5">总价</th>
									</tr>
									</thead>
									<tbody id="buy-goods-modal">

									</tbody>
								</table>
								<div class="control-group">
									<label class="control-label">收货信息：</label>
									<div class="controls">
										<div class="control-action" id="modal-address">

										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">发货方式：</label>
									<div class="controls">
										<label class="radio inline">
											<input type="radio" data-validate="no" checked="" value="1" data-id="1" name="no_express"><span style="padding: 1px 5px;">需要物流</span>
										</label>
										<label class="radio inline">
											<input type="radio" data-validate="no" value="0" data-id="0" name="no_express"><span style="padding: 1px 5px;">无需物流</span>
										</label>
										<{if $appletCfg['ac_type'] == 21}>
										<label class="radio inline">
											<input type="radio" data-validate="no" value="2" data-id="2" name="no_express"><span style="padding: 1px 5px;">商家配送</span>
										</label>
										<{/if}>
									</div>
								</div>
								<div class="control-group row" id="wuliu-info">
									<div class="col-xs-6">
										<label class="control-label">物流公司：</label>
										<div class="controls">
											<select id="express_id" name="express_id" class="form-control chosen-select" data-placeholder="请选择一个物流公司">
												<option value="0"></option>
												<{foreach $express as $key=>$val}>
												<option value="<{$key}>"><{$val}></option>
												<{/foreach}>
											</select>
											<p class="tip hide">*发货后，10分钟内可修改一次物流信息</p>
										</div>
									</div>
									<div class="col-xs-6">
										<label class="control-label">快递单号：</label>
										<div class="controls">
											<input type="text" id="express_code" name="express_code" class="form-control" />
										</div>
									</div>
								</div>
								<div class="control-group row" id="shop-sned-info" style="display: none;">
									<div class="col-xs-6">
										<label class="control-label">配送员名称：</label>
										<div class="controls">
											<input type="text" id="delivery_name" name="delivery_name" class="form-control" />
										</div>
									</div>
									<div class="col-xs-6">
										<label class="control-label">配送员电话：</label>
										<div class="controls">
											<input type="text" id="delivery_mobile" name="delivery_mobile" class="form-control" />
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<span id="saveResult" ng-model="saveResult" class="text-center"></span>
						<button type="button" class="btn btn-primary modal-save" onclick="saveModal()" >保存</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!--维权结果处理-->
		<div class="modal fade" id="agreeTK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close"
								data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="agreeTKLabel">
							维权处理
						</h4>
					</div>
					<div class="modal-body">
						<div class="alert">
							订单中的部分商品，买家已提交了退款申请。你需要先跟买家协商，买家撤销退款申请后，才能进行发货操作。
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="ui-btn ui-btn-primary btn-refund" data-dismiss="modal">
							我知道了
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<style>
	.layui-layer-btn{
		border-top: 1px solid #eee;
	}
	.upload-tips{
		/* overflow: hidden; */
	}
	.upload-tips label{
		display: inline-block;
		width: 70px;
	}
	.upload-tips p{
		display: inline-block;
		font-size: 13px;
		margin:0;
		color: #666;
		margin-left: 10px;
	}
	.upload-tips .upload-input{
		display: inline-block;
		text-align: center;
		height: 35px;
		line-height: 35px;
		background-color: #1276D8;
		color: #fff;
		width: 90px;
		position: relative;
		cursor: pointer;
	}
	.upload-tips .upload-input>input{
		display: block;
		height: 35px;
		width: 90px;
		opacity: 0;
		margin: 0;
		position: absolute;
		top: 0;
		left: 0;
		z-index: 2;
		cursor: pointer;
	}
</style>
<!-- 订单导出操作 -->
<style>
	/*大图弹框*/
	.modal{
		position: fixed;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background-color: rgba(0,0,0,.5);
		display: none;
	}
	.modal-img{
		position:absolute;
		max-width:90%;
		max-height:90%;
		left:5%;
		top:50%;
		z-index:3;
		transform:translateY(-50%);
		-webkit-transform:translateY(-50%);
	}
	.modal-img .image{
		width:100%;
		height:100%;
	}
	.modal-img img{
		width:100%;
		max-height:100%;
	}
	.space{
		margin: 12px 0;
		width: 100%;
	}
</style>



		<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="width: 700px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
						</button>
						<h4 class="modal-title" id="excelOrderLabel">
							导出订单
						</h4>
					</div>
					<div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
						<div class="modal-plan p_num clearfix shouhuo">
							<form id='trade-export-form' enctype="multipart/form-data" action="/wxapp/order/excelOrderNew" method="post" onsubmit="return false">
								<div class="form-group">
									<label class="col-sm-2 control-label">订单状态</label>
									<div class="col-sm-4">
										<select id="orderStatus" name="orderStatus" class="form-control">
											<option value="0">全部</option>
											<{foreach $statusNote as $key=>$val}>
											<option value="<{$key}>"><{$val}></option>
											<{/foreach}>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">订单类型</label>
									<div class="col-sm-4">
										<select id="orderType" name="orderType" class="form-control">
											<option value="0">全部</option>
											<{foreach $goods_type as $key=>$val}>
											<option value="<{$key}>"><{$val}></option>
											<{/foreach}>
										</select>
									</div>
								</div>
								<div class="space"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label">商品名称</label>
									<div class="col-sm-10">
										<input class="form-control" type="text" id="goodstitle" name="goodstitle" placeholder="请输入商品名称,不填默认全部商品"/>
									</div>
								</div>
								<div class="space"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label">开始日期</label>
									<div class="col-sm-4">
										<input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期" autocomplete='off'/>
									</div>
									<label class="col-sm-2 control-label">开始时间</label>
									<div class="col-sm-4 bootstrap-timepicker">
										<input class="form-control" type="text" id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
									</div>
								</div>
								<div class="space"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label">结束日期</label>
									<div class="col-sm-4">
										<input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"  autocomplete='off' />
									</div>
									<label class="col-sm-2 control-label">结束时间</label>
									<div class="col-sm-4 bootstrap-timepicker">
										<input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
									</div>
								</div>
								<div class="space" style="margin-bottom: 70px;"></div>
								<button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
								<button id='trade-export' type="submit" class="btn btn-primary" role="button">导出</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>


<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/order.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
	$(function(){

		// 订单导出
		// zhangzc
		// 2019-11-11
	    $('#trade-export').click(function(){
	    	var index = layer.load(10, {
                shade: [0.6,'#666']
            });
	    	$.ajax({
	    		type:'POST',
	    		url:'/wxapp/order/excelOrderNew',
	    		dataType:'json',
	    		data:$('#trade-export-form').serialize(),
	    		success:function(res){
	    			if(res.ec==200){
	    				// window.open('http://'+location.hostname+res.data.url);
	    				window.location.href=res.data.url;
	    			}else{
	    				layer.msg(res.em);
	    			}
	    			layer.close(index);
	    		},
	    		error:function(){
					layer.msg('数据导出失败，请稍后再试或减少单次的导出量！');
	    		},
	    		complete:function(){
	    			layer.close(index);
	    		}
	    	})
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
		// 下拉搜索框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            placeholder_text_single : '请选择'
        });
		$(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
		});
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$(".select2-entershop").select2({
			language: "zh-CN", //设置 提示语言
			width: "100%", //设置下拉框的宽度
			placeholder: "请选择", // 空值提示内容，选项值为 null
		});



		/*添加备注信息*/
		$(".ui-table-order").on('click', '.js-opts .js-remark', function(event) {
			event.preventDefault();
			layer.prompt({
				title: '添加备注信息',
				formType: 2 //prompt风格，支持0-2
			}, function(text){
				layer.msg('备注信息：'+ text);
			});
		});
		$('.js-deduct').on('click',function(){
			var tid = $(this).data('tid');
			if(tid){

				var data = {
					'tid' : tid
				};
				showDeduct(data);
			}
		});

		$('.edit-price-btn').on('click',function(){
			var tid = $(this).data('tid');
			layer.prompt({title: '输入订单价格，并确认', formType: 0}, function(price, index){
				var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
				if (!reg.test(price)){
					layer.msg('请输入正确订单金额');
					return false;
				}
				var index = layer.load(10, {
					shade: [0.6,'#666']
				});
				var data = {
					'tid'	: tid,
					'price': price
				};
				$.ajax({
					'type'  : 'post',
					'url'   : '/wxapp/order/editPrice',
					'data'  : data,
					'dataType'  : 'json',
					'success'   : function(ret){
						layer.close(index);
						if(ret.ec == 200){
							window.location.reload();
						}else{
							layer.msg(ret.em);
						}
					}
				});
			});
		});

		$('.express-btn').on('click',function(){
			var feedback = $(this).data('feedback');
			if(feedback == 1){ //有维权不可发货，除非会员取消维权状态为3
				$('#agreeTK').modal('show');
			}else{
				var tid = $(this).data('tid');
				var province = $(this).data('province');
				var city 	= $(this).data('city');
				var area 	= $(this).data('area');
				var address = $(this).data('address');
				var phone 	= $(this).data('phone');
				var name 	= $(this).data('name');
				var num     = $(this).data('tra-num');
				if(num > 0){
					var _html = '';
					for(var i=0; i< num ; i++){
						_html += '<tr>';
						_html += '<td><div>'+$(this).data('title_'+i)+'</div></td>';
						_html += '<td>'+$(this).data('num_'+i)+'</td>';
						_html += '<td>'+$(this).data('price_'+i)+'</td>';
						_html += '<td>'+$(this).data('total_'+i)+'</td>';
						_html += '</tr>';
					}
					$('#buy-goods-modal').html(_html);
				}
				$('#modal-address').html(province + ' '+city+ ' '+area+ ' '+address+ '，'+name+ ' '+phone);
				$('#hid_id').val(tid);
				$('#modal-type').val('express');
				$('#modelTitle').text('发货处理');
				hideFormShowById('express');
				$('#refund-form').modal('show');
			}

		});
		// 搜索框滚动
		//var formGroupNum = $(".form-group-box").find('.form-group').length;
		//$(".form-container").width(270*formGroupNum);
	});

	function selectedFile(obj){
		var path = $(obj).val();
		$(obj).parents('form').find('p').text(path);
	}

	$('[data-click-upload]').on('click', function(){
		var htmlTxt=$("#bulk_shipment");
		var that    = this;
		//页面层
		var layIndex = layer.open({
			type: 1,
			title: '文件路径',
			shadeClose: true, //点击遮罩关闭
			shade: 0.6, //遮罩透明度
			skin: 'layui-anim',
			area: ['500px', '200px'], //宽高
			btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
			content: htmlTxt,
			yes : function() {
				var loading = layer.load(2);
				var $form = htmlTxt.find('form');
				var url = $form.attr("action"),
						data = new FormData($form[0]);
				$.ajax(url, {
					type: "post",
					data: data,
					processData: false,
					contentType: false,
					dataType: 'json',
					success: function (data) {
						if (data.ec == 200) {
							layer.msg('批量发货成功');
						}else {
							layer.msg(data.em);
						}
						window.location.reload();
					},
					complete: function () {
						layer.close(loading);
						layer.close(layIndex);
					}
				});
			}
		});
	});

	/**
	 * 拼团失败手动同步信息
	 */
	$('.group-synchron').on('click',function(){
		var goid = $(this).data('goid');
		var index = layer.load(10, {
			shade: [0.6,'#666']
		});
		var data = {
			'goid'	: goid
		};
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/order/groupSynchron',
			'data'  : data,
			'dataType'  : 'json',
			'success'   : function(ret){
				layer.close(index);
				if(ret.ec == 200){
					window.location.reload();
				}else{
					layer.msg(ret.em);
				}
			}
		});
	});


	/**
	 * 自动确认收货失败手动同步信息
	 */
	$('.express-synchron').on('click',function(){
		var tid = $(this).data('tid');
		var index = layer.load(10, {
			shade: [0.6,'#666']
		});
		var data = {
			'tid'	: tid
		};
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/order/expressSynchron',
			'data'  : data,
			'dataType'  : 'json',
			'success'   : function(ret){
				layer.close(index);
				layer.msg(ret.em);
				if(ret.ec == 200){
					window.location.reload();
				}
			}
		});
	});


    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

	//订单导出按钮
	$('.select2-test').on('click',function(){
		$('#test-select2').modal('show');
	});


    $('.order_finish').on('click',function(){
        var tid = $(this).data('tid');
        if(confirm('确认已完成订单？')){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/finishOrder',
                'data'  : {tid: tid},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });


    $('.push_ele_order').on('click',function(){
        var tid = $(this).data('tid');
        if(confirm('确认推单到蜂鸟配送？')){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/pushEleOrder',
                'data'  : {tid: tid},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });


</script>
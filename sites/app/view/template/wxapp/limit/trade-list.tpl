<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style>
	.page-content{
		margin-left: 130px;
	}
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
</style>
<div class="alert alert-block alert-yellow ">
    <button type="button" class="close" data-dismiss="alert">
    <i class="icon-remove"></i>
    </button>
    结算时间：确认收货后，立即结算。未确认收货，7天自动确认收货结算。
</div>
<div>
	<a href="/wxapp/print" class="btn btn-green btn-sm"><i class="icon-print"></i>打印模版设置</a>
	<a href="#" class="btn btn-green btn-sm" data-click-upload ><i class="icon-cloud-upload"></i>批量发货</a>
	<a href="javascript:;" class="btn btn-green btn-xs btn-excel" ><i class="icon-download"></i>订单导出</a>
</div>
<{include file="../common-second-menu.tpl"}>
<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="/wxapp/limit/order" method="get">
			<input type="hidden" value="<{$independent}>" name="independent">
			<div class="col-xs-11 form-group-box">
				<div class="form-container" style="width: auto !important;">
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
							<input type="text" class="form-control" name="harvest" value="<{$name}>"  placeholder="收货人姓名">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人电话</div>
							<input type="text" class="form-control" name="phone" value="<{$phone}>"  placeholder="收货人电话">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">配送方式</div>
							<select name="postType" id="" class="form-control">
								<option value="0">全部</option>
								<{foreach $expressMethod as $key => $val}>
								<option value="<{$key}>" <{if $key eq $postType}>selected<{/if}>><{$val}></option>
								<{/foreach}>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">筛选</div>
							<select name="tradeScreen" id="" class="form-control">
								<{foreach $trade_screen as $key => $val}>
							<option value="<{$key}>" <{if $key eq $tradeScreen}>selected<{/if}>><{$val}></option>
								<{/foreach}>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">自提门店</div>
							<select  class="form-control" name="osId">
								<option value="0">全部</option>
								<{foreach $storeSelect as $key => $val}>
							<option value="<{$key}>" <{if $key == $osId}>selected<{/if}>><{$val['os_name']}></option>
								<{/foreach}>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon" style="height:34px;">所属商家</div>
							<select id="esId" name="esId" style="height:34px;width:100%" class="form-control my-select2">
								<option value="0">全部</option>
								<option value="-1" <{if $esId == -1}>selected<{/if}>>平台自营</option>
								<{foreach $selectShop as $key => $val}>
							<option <{if $esId eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
								<{/foreach}>
							</select>
						</div>
					</div>
					<div class="form-group" style="width: 400px">
						<div class="input-group">
							<div class="input-group-addon" >下单时间</div>
							<input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
						<!--
					<div class="form-group">
						<div class="input-group" style="width: 210px;">
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
						-->
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
                <span class="money"><{if $todayTradeInfo['money']}><{$todayTradeInfo['money']}><{else}>0<{/if}></span>
                <span class="unit">元</span>
                <!--<a href="/manage/shop/inout" class="pull-right">收支明细</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">今日订单数<span></span></div>
            <div class="balance-content">
                <span class="money"><{if $todayTradeInfo}><{$todayTradeInfo['total']}><{else}>0<{/if}></span>
                <!--<span class="unit">元</span>
                <a href="/manage/shop/settled" class="pull-right">待结算记录</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">店铺收益

            </div>
            <div class="balance-content">
                <span class="money money-font"><{if $searchTradeInfo['money']}><{$searchTradeInfo['money']}><{else}>0<{/if}></span>
                <span class="unit">元</span>
                <!--<a href="/manage/shop/inout" class="pull-right" style="margin-left: 6px;"> 明细 </a>
                <!--<a href="/manage/withdraw/apply" class="ui-btn ui-btn-primary pull-right btn-margin-right js-goto-btn">提现</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">店铺订单数</div>
            <div class="balance-content">
                <span class="money money-font"><{if $searchTradeInfo}><{$searchTradeInfo['total']}><{else}>0<{/if}></span>
                <!--<span class="unit">币</span>
                <!-- 充值按钮 -->
                <!--<a href="/manage/account/balance" class="pull-right" style="margin-left: 6px;"> 明细 </a>
                <a href="#" class="ui-btn ui-btn-primary pull-right js-recharge-money">充值</a>
                <div class="ui-popover ui-popover-input top-center charge-input">
                    <div class="ui-popover-inner">
                        <input type="text" class="form-control money-input" id="money-input" autofocus="autofocus" placeholder="请输入充值金额" style="width:160px;display:inline-block;height:30px;vertical-align:top">
                        <a class="ui-btn ui-btn-primary js-save" href="javascript:;" onclick="confirmCharge(this)">确定</a>
                        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide()">取消</a>
                    </div>
                    <div class="arrow"></div>
                </div>-->
            </div>
        </div>
    </div>

<div class="choose-state">
	<{foreach $orderlink as $key=>$val}>
	<a href="/wxapp/limit/order?status=<{$key}>&independent=<{$independent}>" <{if $status && $status eq $key}>class="active"<{/if}>><{$val['label']}></a>
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
					订单号: <{$val['t_tid']}>
					<div class="help" style="display: inline-block;">
						<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><{$tradePay[$val['t_pay_type']]}></span>
						<{if $val['t_applet_type'] eq 1}>
						<span class="tuan-tag">秒</span>
						<{elseif $val['t_applet_type'] eq 2}>
						<span class="tuan-tag">团</span>
						<{elseif $val['t_applet_type'] eq 3}>
						<span class="tuan-tag">奖</span>
						<{elseif $val['t_applet_type'] eq 5}>
						<span class="tuan-tag">砍</span>
						<{/if}>
						<div class="js-notes-cont hide">
							该订单通过您公众号自有的微信支付权限完成交易，货款已进入您微信支付对应的财付通账号
						</div>
						<span style="padding-left: 20px;">
								<{if $val['t_es_id']}>
								<{$val['es_name']}>
								<{else}>
								平台自营
								<{/if}>
							</span>
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/order/tradeDetail?order_no=<{$val['t_tid']}>" class="new-window" >查看详情</a> -
						<a href="javascript:;" data-tid="<{$val['t_tid']}>" class="js-deduct">查看分佣</a>
						<a href="#" class="js-remark hide">备注</a>
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
					<a href="/wxapp/limit/order?title=<{$val['t_title']}>&independent=<{$independent}>"class="new-window" title="<{$val['t_title']}>">
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
					<a href="/wxapp/limit/order?buyer=<{$val['t_buyer_nick']}>&independent=<{$independent}>" class="new-window" target="_blank">
						<{$val['t_buyer_nick']}>
					</a>
				</p>
				<{if $val['t_express_method'] == 2}>
				<p class="user-name"><{$val['t_express_company']}></p>
				<{$val['t_express_code']}>
				<{else}>
				<p class="user-name"><{$val['ma_name']}></p>
				<{$val['ma_phone']}>
				<{/if}>

			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<{date('Y-m-d H:i:s',$val['t_create_time'])}>
				</div>
				<div class="td-cont">
					<p class="user-name" style="color:green;margin-top: 10px">[<{$tradePay[$val['t_pay_type']]}>]</p>
				</div>
				<div class="td-cont">
					<p class="user-name" style="margin-top: 10px">
						<a href="/wxapp/limit/order?postType=<{$val['t_express_method']}>&independent=<{$independent}>" class="new-window" target="_blank">
						<{$expressMethod[$val['t_express_method']]}>
						</a>
					</p>
				</div>
				<{if $val['t_store_id']}>
				<div class="td-cont">
					<p class="user-name" style=";margin-top: 10px">
						<{$val['os_name']}>
					</p>
				</div>
				<{/if}>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<p class="js-order-state" id="status_<{$val['t_tid']}>"><{$statusNote[$val['t_status']]}></p>
					<{if $val['t_status'] eq 8 && $val['t_fd_result'] eq 1}>
					<span style="color: red;">［拒绝］</span>
					<{elseif $val['t_status'] eq 8 && $val['t_fd_result'] eq 2}>
					<span style="color: green;">［同意］</span>
					<{/if}>
					<{if $val['t_status'] eq 4 && $val['t_express_time'] && $val['t_express_time'] lt (time()-608400)}>
					<span class="btn btn-success btn-xs express-synchron" data-tid="<{$val['t_id']}>">信息同步</span>
					<{/if}>
					<{if $val['go_status'] eq 0 && $val['go_create_time'] lt (time()-86400)  && $val['go_id'] gt 0 && $val['t_type'] gt 0}>
					<span class="btn btn-info btn-xs group-synchron" data-goid="<{$val['go_id']}>">拼团信息同步</span>
					<{/if}>
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
						<{$val['t_total_fee']}>
						<br>

						<p class="user-name">
							<{if $val['t_status'] == 3}>
							<span id="express_<{$val['t_tid']}>" class="btn btn-primary btn-xs express-btn"
								  data-receivename="<{$val['t_express_company']}>"
								  data-receivephone="<{$val['t_express_code']}>"
								  data-expressmethod="<{$val['t_express_method']}>"
								  data-tid="<{$val['t_tid']}>"
								  data-feedback="<{$val['t_feedback']}>"
								  data-province="<{$val['ma_province']}>"
								  data-city="<{$val['ma_city']}>"
								  data-area="<{$val['ma_zone']}>"
								  data-address="<{$val['ma_detail']}>"
								  data-phone="<{$val['ma_phone']}>"
								  data-name="<{$val['ma_name']}>"
								  data-tra-num="<{if isset($trader[$val['t_id']])}><{$trader[$val['t_id']]['count']}><{else}>0<{/if}>"
							<{if isset($trader[$val['t_id']])}>
							<{foreach $trader[$val['t_id']]['data'] as $key=>$mal}>
							data-title_<{$key}>="<{$mal['to_title']}>"
							data-price_<{$key}>="<{$mal['to_price']}>"
							data-num_<{$key}>="<{$mal['to_num']}>"
							data-total_<{$key}>="<{$mal['to_total']}>"
							<{/foreach}>
							<{/if}>>发货</span>
							<{/if}>

							<{if $val['t_status'] == 2 || $val['t_status'] == 3 || $val['t_status'] == 4}>
							<span id="refund_<{$val['t_tid']}>" class="btn btn-primary btn-xs refund-btn"
							  data-tid="<{$val['t_tid']}>"
							  data-type="<{$val['t_type']}>"
							  data-applet-type="<{$val['t_applet_type']}>"
							  data-feedback="<{$val['t_feedback']}>"
							  data-province="<{$val['ma_province']}>"
							  data-city="<{$val['ma_city']}>"
							  data-area="<{$val['ma_zone']}>"
							  data-address="<{$val['ma_detail']}>"
							  data-phone="<{$val['ma_phone']}>"
							  data-name="<{$val['ma_name']}>"
							  data-status="<{$val['t_status']}>"
							  data-tra-num="<{if isset($trader[$val['t_id']])}><{$trader[$val['t_id']]['count']}><{else}>0<{/if}>"
							<{if isset($trader[$val['t_id']])}>
							<{foreach $trader[$val['t_id']]['data'] as $key=>$mal}>
							data-title_<{$key}>="<{$mal['to_title']}>"
							data-price_<{$key}>="<{$mal['to_price']}>"
							data-num_<{$key}>="<{$mal['to_num']}>"
							data-total_<{$key}>="<{$mal['to_total']}>"
							<{/foreach}>
							<{/if}>>退款</span>
							<{/if}>

							<{if $val['t_status'] == 1}>
							<span class="btn btn-primary btn-xs edit-price-btn"
								  data-tid="<{$val['t_tid']}>">修改订单价格</span>
							<{/if}>

						</p>
						<{if $val['t_status'] == 3 || $val['t_status'] == 4}>
						<p class="user-name">
						<span id="order_finish_<{$val['t_tid']}>" class="btn btn-primary btn-xs order_finish"
							  data-tid="<{$val['t_tid']}>"
						>订单完成</span>
						</p>
						<{/if}>

					</div>
					<{foreach $print as $pkey=>$pal}>
					<p class="user-name">
					<a href="javascript:;" class="btn btn-info btn-xs previewCon" data-type="<{$pkey}>" data-tid="<{$val['t_tid']}>"><i class="icon-print"></i><{$pal['label']}></a>
					</p>
					<{/foreach}>
				</div>
			</td>
		</tr>
		<{if $val['t_note']}>
		<tr class="remark-row buyer-msg">
			<td colspan="8">买家备注： <{$val['t_note']}></td>
		</tr>
		<{/if}>

		<{if $val['t_remark_extra']}>
		<tr class="remark-row buyer-msg"
		<{if count($val['t_remark_extra']) == 1 && $val['t_remark_extra'][0]['name']=='备注' && !$val['t_remark_extra'][0]['value']}>
		style="display:none"
		<{/if}>
		>
			<td colspan="8">
			<{foreach $val['t_remark_extra'] as $v}>
			<{if $v['value']}>
			<{if $v['type'] != 'image'}>
			<{$v['name']}>：<{$v['value']}>&nbsp;&nbsp;&nbsp;&nbsp;
			<{else}>
			<{$v['name']}>：<img src="<{$v['value']}>" alt="" width="50px">&nbsp;&nbsp;&nbsp;&nbsp;
			<{/if}>
			<{/if}>
			<{/foreach}>
			</td>
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
									<label class="radio inline">
										<input type="radio" data-validate="no" value="2" data-id="2" name="no_express"><span style="padding: 1px 5px;">商家配送</span>
									</label>
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
							<{if $expressNote == 1}>
							<div class="control-group row" id="shop-express-note" style="display: none;">
								<div class="col-xs-10">
									<label class="control-label">备注：</label>
									<div class="controls">
										<textarea id="express_note" name="express_note" cols="30" rows="5" class="form-control" ></textarea>
									</div>
								</div>
							</div>
							<{/if}>
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
<!-- 批量发货导入文件弹框 -->
<div id="bulk_shipment" style="display: none;padding:5px 20px;">
	<div class="upload-tips">
		<form action="/wxapp/order/deliver" enctype="multipart/form-data" method="post">
			<label style="height:35px;line-height: 35px;">本地上传</label>
			<span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="order_deliver" type="file"></span>
			<p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传csv类型的文件</p>
			<div style="font-size: 14px;margin-top: 10px;" >注意　<span id="show-notice">最大支持 1 MB CSV的文件。</span></div>
			<div style="font-size: 14px;margin-top: 10px;" ><a href="/public/common/批量发货样本.csv" id="show-notice">下载批量发货模板</a></div>
		</form>
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
					<form enctype="multipart/form-data" action="/wxapp/order/excelOrder" method="post">
						<input type="hidden" value="1" name="orderType">
						<input type="hidden" value="<{$independent}>" name="excel_independent">
						<div class="form-group">
							<label class="col-sm-2 control-label">订单类型</label>
							<div class="col-sm-4">
								<select id="orderStatus" name="orderStatus" class="form-control">
									<{foreach $orderlink as $key=>$val}>
									<option value="<{$key}>"><{$val['label']}></option>
									<{/foreach}>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" name="addressOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="address-order" style="position: relative;top: 2px">根据地址排序</label>
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
								<input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期"/>
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
								<input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
							</div>
							<label class="col-sm-2 control-label">结束时间</label>
							<div class="col-sm-4 bootstrap-timepicker">
								<input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
							</div>
						</div>
						<div class="space" style="margin-bottom: 70px;"></div>
						<button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
						<button type="submit" class="btn btn-primary" role="button">导出</button>
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
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
	$(function(){
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
			search_contains: true
		});
        $(".my-select2").select2({
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

        //单个订单退款
        $('.refund-btn').on('click',function(){
            var status  = $(this).data('status');
            var msg = '你确定要给该订单退款吗？';
            if(status==4){
				msg = '该订单已发货确定要退款吗？'
			}
            var tid  = $(this).data('tid');
            var type = $(this).data('type');
            var appletType = $(this).data('applet-type');
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'tid'	: tid,
                    'status': 2,
                    'group' : type == 1 || (type== 5 && appletType == 2) ? 1 : 0
                };
                console.log(data);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/activeRefund',
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
            }, function() {

            });
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
				var receiveName = $(this).data('receivename');
				var receivePhone = $(this).data('receivephone');
				var expressMethod = $(this).data('expressmethod');

				if(expressMethod == 2){
				    phone = receivePhone;
				    name = receiveName;
                }

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
				if(expressMethod == 2){
                    $('#modal-address').html(name+ ' '+phone);
                }else{
                    $('#modal-address').html(province + ' '+city+ ' '+area+ ' '+address+ '，'+name+ ' '+phone);
                }

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

	//完成订单
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

</script>
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
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
	select.form-control{
		-webkit-appearance: none;
	}
	.tuan-tag{
		padding: 2px 8px;
    	background-color: #ff4e4e;
	}
	.goods-cell{
		width: 400px;
	}
	.td-goods{
		display: flex;
		align-items:center;
	}
	.cell{
		border-left: 1px solid #f2f2f2;
	}
	span.btn{
		width: 70px;
	}
	.previewCon{
		width: 80px;
	}
	.new-window {
	    color: #44abf7 !important;
	}
	.balance{

	}
	.balance .balance-info{
		float: none!important;
		width: auto!important;
		flex: 1;
	}
	.trade-list{
		font-family: Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,Arial,sans-serif!important;
	}
	.user-name .btn{
		width: 80px;
	}
	.cover{
		position: fixed;
	    top: 0;
	    left: 0;
	    bottom: 0;
	    right: 0;
	    background-color: rgba(0,0,0,.6);
	    display: none;
	    z-index: 9999;
	}
	#progress_bar {
		margin: 20px;
		width: 400px;
		height: 16px;
		position: relative;
		margin: 300px auto;
	}
</style>
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
<{if $limit_trade == 1 || $bargain_trade == 1}>
<{include file="../common-second-menu.tpl"}>
<div style="margin-left: 130px" >
<{else}>
<div>
	<a href="/wxapp/print" class="btn btn-green btn-sm"><i class="icon-print"></i>打印模版设置</a>
	<a href="javascript:;" class="btn btn-green btn-sm btn-excel" ><i class="icon-download"></i>订单导出</a>
	<{if $appletCfg['ac_base'] < 21 || $curr_shop['s_id'] == 9373}>
	<a href="javascript:;" class="btn btn-blue btn-sm btn-excel-activity" ><i class="icon-download"></i>活动订单导出</a>
	<{/if}>
	<a href="javascript:;" class="btn btn-green btn-sm btn-print-list" ><i class="icon-print"></i>订单打印</a>
</div>
<{/if}>
<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="<{if $limit_trade == 1}>/wxapp/limit/sequenceOrder<{elseif $bargain_trade == 1}>/wxapp/bargain/sequenceOrder<{else}>/wxapp/sequence/tradeListNew<{/if}>" method="get">
			<div class="col-xs-11 form-group-box">
				<div class="form-container" style="width: auto !important;">
					<!-- 订单相关查询 -->
					<div class='row'>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">订单类型</div>
								<select name="tradeScreen"  class="form-control">
									<{foreach $trade_screen as $key => $val}>
								<option value="<{$key}>" <{if $key eq $tradeScreen}>selected<{/if}>><{$val}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">订单编号</div>
								<input type="text" class="form-control" name="tid" value="<{$tid}>"  placeholder="订单编号">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">商品名称</div>
								<input type="text" class="form-control" name="gname" value="<{$gname}>"  placeholder="商品名称" title='若商品更改过名称，可能会搜索不到结果'>
							</div>
						</div>
						<div class="form-group" style="width: 520px">
							<div class="input-group">
								<div class="input-group-addon" >下单时间</div>
								<input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" autocomplete='off'>
                                <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                </span>
								<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
								<input id='end-time' type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" autocomplete='off'>
								<span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                </span>
							</div>
						</div>
					</div>
					
					<!-- 买家相关查询 -->
					<div class='row'>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">买家昵称</div>
								<input type="text" class="form-control" name="buyer" value="<{$buyer}>"  placeholder="购买人微信昵称">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">收货人</div>
								<input type="text" class="form-control" name="harvest" value="<{$harvest}>"  placeholder="收货人姓名">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">收货人电话</div>
								<input type="text" class="form-control" name="phone" value="<{$phone}>"  placeholder="收货人电话">
							</div>
						</div>
					</div>
					
					<!-- 团长相关查询方式 -->
					<div class='row'>
						<div class="form-group">
							<div class="input-group ">
								<div class="input-group-addon">社区名称</div>
								<input type="text" class="form-control" name="community" value="<{$community}>"  placeholder="小区名称">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group ">
								<div class="input-group-addon">团长名称</div>
								<input type="text" class="form-control" name="leaderName" value="<{$leader}>"  placeholder="团长名称">
							</div>
						</div>
					</div>

					<!-- 配送方式查询 -->
					<div class='row'>
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">配送方式</div>
								<select name="postType"  class="form-control">
									<option value="0">全部</option>
									<{foreach $expressMethod as $key => $val}>
									<option value="<{$key}>" <{if $key eq $postType}>selected<{/if}>><{$val}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
					</div>
					<input type="hidden" name="status" value="<{$status}>">
					<input type="hidden" name="area_id" value="<{$smarty.get.area_id}>">
				</div>
			</div>
			<input type="hidden" name="area_id" value='<{$smarty.get.area_id}>'>
			<div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 35%;right: 2%;">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>
<{if $region_child}>
<!-- 订单汇总信息 -->
<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;display: flex;align-items: center;">
    <div class="balance-info">
        <div class="balance-title">今日收益<span></span></div>
        <div class="balance-content">
            <span class="money"><{if $todayTradeInfo['money']}><{$todayTradeInfo['money']}><{else}>0<{/if}></span>
            <span class="unit">元</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">今日订单数<span></span></div>
        <div class="balance-content">
            <span class="money"><{if $todayTradeInfo}><{$todayTradeInfo['total']}><{else}>0<{/if}></span>
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
        </div>
    </div>
    <{if $area_info}>
    <!-- 区域合伙人 -->
    <div class="balance-info">
        <!-- <div class="balance-title">区域合伙人佣金</div>
        <div class="balance-content">
          	<p>总佣金： <span class="money money-font"><{$brokerage_sum}></span><span class="unit">元</span></p>
           	<p>已提现： <span class="money money-font" style='color: #06BF04;'><{$already_money}></span><span class="unit">元</span></p>
           	<p>待审核： <span class="money money-font" style='color: #c09853;'><{$review_money}></span><span class="unit">元</span></p>
        </div>
        <div>
        	<button id='get_money' class="btn btn-green btn-sm">提现</button>
        </div> -->
        <a href="/wxapp/Seqregion/regionBrokerage" class='btn btn-sm btn-green'>佣金收入</a>   
       	<button id='edit_region' class='btn btn-sm btn-green'>添加操作员</button>      
    </div>
     <{/if}>
</div>
<{/if}>
<div class="choose-state">
	<{if $limit_trade == 1 || $bargain_trade == 1}>
	<{foreach $orderlink as $key=>$val}>
		<a href="<{if $limit_trade == 1}>/wxapp/limit/sequenceOrder<{elseif $bargain_trade == 1}>/wxapp/bargain/sequenceOrder<{else}>/wxapp/sequence/tradeListNew<{/if}>?status=<{$key}>" <{if $status && $status eq $key}>class="active"<{/if}>><{$val['label']}></a>
	<{/foreach}>
	<{else}>
	<{foreach $link as $key=>$val}>
	<a href="/wxapp/sequence/tradeListNew?status=<{$key}>&tradeScreen=<{$smarty.get.tradeScreen}>&tid=<{$smarty.get.tid}>&gname=<{$smarty.get.gname}>&start=<{$smarty.get.start}>&end=<{$smarty.get.end}>&buyer=<{$smarty.get.buyer}>&harvest=<{$smarty.get.harvest}>&phone=<{$smarty.get.phone}>&community=<{$smarty.get.community}>&leaderName=<{$smarty.get.leaderName}>&postType=<{$smarty.get.postType}>&area_id=<{$smarty.get.area_id}>" <{if $status && $status eq $key}>class="active"<{/if}>><{$val['label']}></a>
	<{/foreach}>
	<{/if}>
</div>
<div class="trade-list">
	<table class="ui-table-order" style="padding: 0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
		    <tr class="widget-list-header">
		        <th style="width: 400px;">商品信息</th>
		        <th style="min-width: 110px; max-width: 200px;">买家信息</th>
		        <th style="min-width: 110px; max-width: 200px;">团长信息</th>
		        <th style="min-width: 110px;">费用</th>
		        <th style="min-width: 110px;">订单状态</th>
		        <th style="min-width: 110px;">操作</th>
		    </tr>
		</thead>

		<{foreach $list as $val}>
		<tbody class="widget-list-item">
		<tr class="separation-row">
			<td colspan="6"></td>
		</tr>
		<!-- 第一行的订单基本信息 -->
		<tr class="header-row">
			<td colspan="4">
				<div class="help" style="display: inline-block;">					
					<{if $val['t_applet_type'] eq 1}>
					<span class="tuan-tag">秒杀</span>
					<{elseif $val['t_applet_type'] eq 2}>
					<span class="tuan-tag">团购</span>
					<{elseif $val['t_applet_type'] eq 3}>
					<span class="tuan-tag">奖励</span>
					<{elseif $val['t_applet_type'] eq 5}>
					<span class="tuan-tag">砍价</span>
					<{/if}>
					<span style='padding:0 15px 0 0;font-weight: bold;'><{date('Y-m-d H:i:s',$val['t_create_time'])}></span>
					<span style='color: #999;'>订单编号: <{$val['t_tid']}></span>
					<div class="js-notes-cont hide">
						该订单通过您公众号自有的微信支付权限完成交易，货款已进入您微信支付对应的财付通账号
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/order/tradeDetail?order_no=<{$val['t_tid']}>" class="new-window" >查看详情</a>
						<!--
						<a href="javascript:;" data-tid="<{$val['t_tid']}>" class="js-deduct">查看分佣</a>
						-->
						<a href="#" class="js-remark hide">备注</a>
					</div>
				</div>
			</td>
		</tr>
		<!-- 订单详细内容系那是区域 -->
		<tr class="content-row">
			<!-- 商品显示区域 -->
			<td class='cell goods-cell'>
				<{foreach $trader[$val['t_id']]['data'] as $key=>$mal}>
				<div class='td-goods'>
					<p style='width: 60px;height: 60px;'>
						<img style='width: 60px;height: 60px;' src="<{$mal.to_pic}>">
					</p>
					<p style='flex: 1;padding:0 8px;'>
						<span><{$mal['to_title']}></span>
					</p>					
					<p style="text-align: right;">
						￥<{$mal['to_price']}><br>x<{$mal['to_num']}> (件)
					</p>
				</div>
				<{/foreach}>
				<{if $val['t_se_num'] > 0}>
				<p>
					接龙编号：<{$val['t_se_num']}>
				</p>
				<{/if}>
			</td>
			<!-- 买家信息 -->
			<td class='cell'>
				<p>下单人：<a href="<{if $limit_trade == 1}>/wxapp/limit/sequenceOrder<{elseif $bargain_trade == 1}>/wxapp/bargain/sequenceOrder<{else}>/wxapp/sequence/tradeListNew<{/if}>?buyer=<{$val['t_buyer_nick']}>" class="new-window" target="_blank"><{$val['t_buyer_nick']}></a></p>
				<p>收货人：<span style='color: #999;'>
					<{if $val['t_express_method']==1 || $val['t_express_method']==3}>
					<!-- 商家配送 -->
					<{$val['ma_name']}>
					<{else}>
					<{$val['t_express_company']}>
					<{/if}>
				</span></p>
				<p>联系电话：<span style='color: #999;'>
					<{if $val['t_express_method']==1 || $val['t_express_method']==3}>
					<!-- 商家配送 -->
					<{$val['ma_phone']}>
					<{else}>
					<{$val['t_express_code']}>
					<{/if}>
					</span></p>
				<{if $expressMethod[$val['t_express_method']]=='门店自取'}>
				<{if $val['asps_id'] > 0 }>
				<p style='max-width: 245px;'>自提地址：<span style='color: #999;'><{$val['asps_address']}>
						--<{$val['asps_address_detail']}></span></p>
				<{else}>
				<p style='max-width: 245px;'>自提地址：<span style='color: #999;'><{$val['asc_address']}>
						--<{$val['asc_address_detail']}></span></p>
				<{/if}>

				<{else}>
				<p style='max-width: 245px;'>收货地址：<span style='color: #999;'>
					<{if $expressMethod[$val['t_express_method']]=='团长配送'}>
						<{$val['t_address']}>
					<{else}>
						<{$val['ma_province']}><{$val['ma_city']}><{$val['ma_zone']}><{$val['ma_detail']}>	
					<{/if}>
					</span></p>
				<{/if}>	
				<p>类型：<a href="<{if $limit_trade == 1}>/wxapp/limit/sequenceOrder<{elseif $bargain_trade == 1}>/wxapp/bargain/sequenceOrder<{else}>/wxapp/sequence/tradeListNew<{/if}>?postType=<{$val['t_express_method']}>" class="new-window" target="_blank"><{$expressMethod[$val['t_express_method']]}></a></p>
			</td>
			<!-- 团长信息 -->
			<td class="cell">
				<p>
					团长名称：
					<{if $val.t_se_leader}>
					<a href="<{if $limit_trade == 1}>/wxapp/limit/sequenceOrder<{elseif $bargain_trade == 1}>/wxapp/bargain/sequenceOrder<{else}>/wxapp/sequence/tradeListNew<{/if}>?leader=<{$val['asl_id']}>&leaderName=<{$val['asl_name']}>"class="new-window" title="<{$val['asl_name']}>">
						<{$val['asl_name']}>
					</a>
					<{else if $val.t_status < 7 && $val.t_status >=2}>
					<!-- 团长信息未回写成功-执行手动操作的逻辑 -->
					<button class='btn btn-sm sync_leader' data-tid='<{$val.t_id}>' style='font-size: 12px;padding: 4px;'>同步团长信息</button>
					<{/if}>
				</p>
				<p>所在街道：<span style='color: #999;'><{$val['asa_name']}></span></p>
				<p>社区名称：
					<a href="<{if $limit_trade == 1}>/wxapp/limit/sequenceOrder<{elseif $bargain_trade == 1}>/wxapp/bargain/sequenceOrder<{else}>/wxapp/sequence/tradeListNew<{/if}>?community=<{$val['asc_name']}>"class="new-window" title="<{$val['asc_name']}>">
						<span style='color: #999;'><{$val['asc_name']}></span>
					</a>
				</p>
				<p style='max-width: 245px;display: inline-block;'>
					社区地址：<span style='color: #999;'><{$val['asc_address']}>--<{$val['asc_address_detail']}></span>
				</p>
				<p>团长电话：<span style='color: #999;'><{$val['asl_mobile']}></span></p>
			</td>
			<!-- 费用 -->
			<td class='cell'>
				<p>支付方式：<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><{$tradePay[$val['t_pay_type']]}></span></p>
				<p>总金额：￥<{$val['t_goods_fee']}></p>
				<p>实付金额：￥<{$val['t_payment']}></p>
				<p>优惠金额：￥<{$val['t_discount_fee']}></p>
				<!-- <p>抵扣方式：</p> -->
			</td>
			<!-- 订单状态 -->
			<td class='cell'>	
				<div class="td-cont">
					<p class="js-order-state" id="status_<{$val['t_tid']}>"><{$statusNote[$val['t_status']]}></p>
					<{if $val['t_status'] eq 8 && $val['t_fd_result'] eq 1}>
					<span style="color: red;">［拒绝］</span>
					<{elseif $val['t_status'] eq 8 && $val['t_fd_result'] eq 2}>
					<span style="color: green;">［同意］</span>
					<{/if}>

					<{if $val['t_refund_time'] && $val['t_status'] == 8}>
					<p><{date('Y-m-d H:i',$val['t_refund_time'])}></p>
					<{/if}>

					<{if $val['t_status'] eq 4 && $val['t_express_time'] && $val['t_express_time'] lt (time()-608400)}>
					<span class="btn btn-success btn-xs express-synchron" data-tid="<{$val['t_id']}>">信息同步</span>
					<{/if}>
					<p class="js-order-state" style="width: 80%;margin: 0 auto !important;">
						<{if $val['t_finish_time']}>
						<{date('Y-m-d H:i',$val['t_finish_time'])}>
						<{/if}>
					</p>
				</div>
				<div>
					<{if in_array($val['t_feedback'],array(1,2))}>
					<a href="/wxapp/order/tradeRefund?order_no=<{$val['t_tid']}>" class="new-window" >处理维权</a>
					<{/if}>	
				</div>
			</td>
			<!-- 操作 -->
			<td class='cell'>
				<div class="td-cont text-center">
					<{if $val['t_status'] == 2}>
					<p class="user-name"><span class="btn btn-info btn-xs order-synchron" data-tid="<{$val['t_tid']}>">订单同步</span></p>
					<{/if}>
					<{if $val['t_status'] == 3 || $val['t_status'] == 4}>
					<p class="user-name">
					<span id="order_finish_<{$val['t_tid']}>" class="btn btn-success btn-xs order_finish"
						  data-tid="<{$val['t_tid']}>"
					><i class='icon-check-sign'></i>完成订单</span>
					</p>
					<{/if}>
					<{foreach $print as $pkey=>$pal}>
					<p class="user-name">
					<a href="javascript:;" class="btn btn-warning btn-xs previewCon" data-type="<{$pkey}>" data-tid="<{$val['t_tid']}>"><i class="icon-print"></i><{$pal['label']}></a>
					</p>
					<{/foreach}>
					<{if $val.t_status ==3 &&  $val.t_express_method == 3}>
					<p class="user-name">
					<a href='javascript:;'  class="btn btn-primary btn-xs express-btn"
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
						<{/if}>
					>
						<i class='icon-truck'></i>
						快递发货
					</a>
					</p>
					<{/if}>
					<p class="user-name">
						<{if ($val['t_status'] == 2 || $val['t_status'] == 3 || $val['t_status'] == 4) && $val['t_fd_status'] != 3 && $val['t_fd_status'] != 4}>

						<span id="refund_<{$val['t_tid']}>" class="btn btn-danger btn-xs refund-btn-modal" data-toggle="modal" data-target="#refundNewModal"
						  data-tid="<{$val['t_tid']}>"
							data-payment="<{$val['t_payment']}>"
							  data-coin-payment="<{$val['t_coin_payment']}>"
							  data-applet-type="<{$val['t_applet_type']}>"
						  data-type="<{$val['t_type']}>"
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
						<{/if}>><i class='icon-warning-sign'></i>退款</span>
						<{/if}>
					</p>
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
					<{if $v['type'] == 'image'}>
						<{$v['name']}>：<img src="<{$v['value']}>" alt="" width="50px">&nbsp;&nbsp;&nbsp;&nbsp;
					<{else if $v['type']=='checkbox'}>
						<{$v['name']}>:
						<{foreach $v['value'] as $item}>
							<{$item}>
						<{/foreach}>
					<{else}>
						<{$v['name']}>：<{$v['value']}>&nbsp;&nbsp;&nbsp;&nbsp;
					<{/if}>
				<{/if}>
			<{/foreach}>
			</td>
		</tr>
		<{/if}>
		</tbody>
		<{/foreach}>

		<!--<tbody class="widget-list-item">
		    <tr class="separation-row">
		        <td colspan="8" class='text-right'> </td>
		    </tr>
		</tbody>-->

	</table>
	<{if $showPage != 0 }>
	<div style="height: 53px;margin-top: 15px;">
	    <div class="bottom-opera-fixd">
	        <div class="bottom-opera">	            
	            <div class="bottom-opera-item" style="text-align:center;">
	                <div class="page-part-wrap"><{$page_html}></div>
	            </div>
	        </div>
	    </div>
	</div>
	<{/if}>

	<div class="modal fade" id="refundNewModal" tabindex="-1" role="dialog" aria-labelledby="refundNewModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="overflow: auto; width: 500px">
			<div class="modal-content">
				<input type="hidden" id="hid_refund_tid">
				<input type="hidden" id="hid_refund_status">
				<input type="hidden" id="hid_refund_type">
				<input type="hidden" id="hid_refund_applettype">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="myModalLabel">
						退款
					</h4>
				</div>
				<!--
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">退款金额：</label>
						<div class="col-sm-8">
							<input id="curr_refund" class="form-control" placeholder="请填写退款金额" style="height:auto!important"/>
						</div>
					</div>
				</div>
				-->

				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">退款原因：</label>
						<div class="col-sm-8">
							<select name="refund_reason" id="refund_reason" class="form-control">
								<{foreach $activeRefundReason as $key => $val}>
								<option value="<{$key}>"><{$val}></option>
								<{/foreach}>
							</select>
						</div>
					</div>

					<div class="form-group row refund_note_row" style="display: none">
						<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">其它原因：</label>
						<div class="col-sm-8">
							<textarea name="refund_note" id="refund_note" cols="30" rows="3" class="form-control"></textarea>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消
					</button>
					<button type="button" class="btn btn-primary" id="refund-btn-new">
						确认
					</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>

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
							       <!--  <label class="radio inline">
							            <input type="radio" data-validate="no" value="0" data-id="0" name="no_express"><span style="padding: 1px 5px;">无需物流</span>
							        </label>
									<label class="radio inline">
										<input type="radio" data-validate="no" value="2" data-id="2" name="no_express"><span style="padding: 1px 5px;">商家配送</span>
									</label> -->
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
					<form id='trade-export-form' enctype="multipart/form-data" action="/wxapp/sequence/excelOrderNew"  method="post" onsubmit="return false">
						<div class="form-group">
							<label class="col-sm-2 control-label">订单类型</label>
							<div class="col-sm-4">
								<select id="orderStatus1" name="orderStatus" class="form-control">
									<{foreach $link as $key=>$val}>
									<option value="<{$key}>"><{$val['label']}></option>
									<{/foreach}>
								</select>
							</div>
							<div class="col-sm-4" style="display: none;">
								<input type="checkbox" name="addressOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="address-order" style="position: relative;top: 2px">根据地址排序</label>
							</div>

						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">配送方式</label>
							<div class="col-sm-4">
								<select id="postType1" name="postType" class="form-control">
									<option value="0">全部</option>
									<{foreach $expressMethod as $key=>$val}>
									<option value="<{$key}>"><{$val}></option>
									<{/foreach}>
								</select>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="mergeOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="goods-order" style="position: relative;top: 2px">同订单合并</label>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="goodsOrder" id="goodsOrder" style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="goods-order" style="position: relative;top: 2px">根据商品排序</label>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">小区</label>
							<div class="col-sm-4">
								<select id="communityId" name="communityId" class="form-control" style="">
									<option value="0">全部</option>
									<{foreach $communitySelect as $val}>
									<option value="<{$val['id']}>"><{$val['name']}></option>
									<{/foreach}>
								</select>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="communityOrder" id="communityOrder" style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="goods-order" style="position: relative;top: 2px">根据小区排序</label>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="clearChildOrder" id="clearChildOrder" style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="goods-order" style="position: relative;top: 2px">去除已退款单品</label>
							</div>
						</div>
						<div class="space"></div>
						<!--
						<div class="form-group">
							<label class="col-sm-2 control-label">活动名称</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="activitytitle" name="activitytitle" placeholder="请输入活动名称,不填默认全部活动"/>
							</div>
						</div>
						<div class="space"></div>
						-->
						<div class="form-group">
							<label class="col-sm-2 control-label">商品名称</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="goodsname" name="goodsname" placeholder="请输入商品名称,不填默认全部商品"/>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">开始日期</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="startDate"  name="startDate" placeholder="请输入开始日期" autocomplete="off" />
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">结束日期</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="endDate"  name="endDate" placeholder="请输入结束日期" autocomplete="off"  />
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

<div class="modal fade" id="printOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 700px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="excelOrderLabel">
					打印订单
				</h4>
			</div>
			<div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
				<div class="modal-plan p_num clearfix shouhuo">
					<form>
						<div class="form-group">
							<label class="col-sm-2 control-label">打印机</label>
							<div class="col-sm-4">
								<select id="print_sn" name="sn" class="form-control">
									<{foreach $printlist as $val}>
									<option value="<{$val['afl_sn']}>"><{$val['afl_name']}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">订单类型</label>
							<div class="col-sm-4">
								<select id="print_orderStatus" name="orderStatus" class="form-control">
									<{foreach $link as $key=>$val}>
									<option value="<{$key}>"><{$val['label']}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">配送方式</label>
							<div class="col-sm-10">
								<select id="print_postType" name="postType" class="form-control" style="width: 37%;">
									<option value="0">全部</option>
									<{foreach $expressMethod as $key=>$val}>
									<option value="<{$key}>"><{$val}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">小区</label>
							<div class="col-sm-10">
								<select id="print_communityId" name="communityId" class="form-control" style="width: 37%;">
									<option value="0">全部</option>
									<{foreach $communitySelect as $val}>
									<option value="<{$val['id']}>"><{$val['name']}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<div class="space"></div>
						<!--
						<div class="form-group">
							<label class="col-sm-2 control-label">活动名称</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="print_activitytitle" name="activitytitle" placeholder="请输入活动名称,不填默认全部活动"/>
							</div>
						</div>
						<div class="space"></div>
						-->
						<div class="form-group">
							<label class="col-sm-2 control-label">商品名称</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="print_goodsname" name="goodsname" placeholder="请输入商品名称,不填默认全部商品"/>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">开始日期</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="print_startDate"  name="print_startDate" placeholder="请输入开始日期" autocomplete="off" />
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">结束日期</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="print_endDate"  name="print_endDate" placeholder="请输入结束日期" autocomplete="off" />
							</div>
						</div>
						<div class="space" style="margin-bottom: 70px;"></div>
						<button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
						<a href="javascript:;" class="btn btn-primary print-order-list">打印</a>
					</form>
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


<!-- 设置区域合伙人子操作员 -->
<div id='region_model' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">添加/编辑操作员</h4>
			</div>
			<div class="modal-body">
				<div class='form-horizontal'>
					<input type="hidden" id="region_id">
					<div class='form-group'>
						<label class='label-control col-xs-2'>登录账号</label>
						<div class='col-xs-8'>
							<input id='region_mobile' class='form-control' type="text" placeholder="操作员手机号码">
						</div>
					</div>
					<div class='form-group'>
						<label class='label-control col-xs-2'>登录密码</label>
						<div class='col-xs-8'>
							<input id='region_pwd' class='form-control' type="password" autocomplete="off" placeholder="操作员登录密码">
							<div class='help-block'>
								<small>*密码不填写时默认与登录账号相同*</small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				<button id='region_save' type="button" class="btn btn-primary">保存</button>
			</div>
		</div>
	</div>
</div>
	<{if $limit_trade == 1 || $bargain_trade == 1}>
</div>
	<{/if}>
<div class='cover'>
	<div id='progress_bar'></div>
</div>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/order.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.bootcss.com/progressbar.js/1.0.1/progressbar.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
	$(function(){
		laydate.render({
			elem: '#start-time',
			type: 'datetime' 
		});
		laydate.render({
			elem: '#end-time' ,
			type: 'datetime' 
		});
		laydate.render({
			elem: '#startDate' ,
			type: 'datetime' 
		});
		laydate.render({
			elem: '#endDate' ,
			type: 'datetime' 
		});
		laydate.render({
			elem: '#print_startDate' ,
			type: 'datetime' 
		});
		laydate.render({
			elem: '#print_endDate' ,
			type: 'datetime' 
		});

		// 订单导出
		// zhangzc
		// 2019-11-14
	    $('#trade-export').click(function(){
            $('.cover').show();
	    	var bar =progressBar();
            // 在导出之前
	    	$.ajax({
	    		type:'POST',
	    		url:'/wxapp/sequence/excelOrderNew',
	    		dataType:'json',
	    		data:$('#trade-export-form').serialize(),
	    		success:function(res){
	    			if(res.ec==200){
	    				bar.animate(1, {
						    duration: 800
						}, function() {
						});
	    				setTimeout(function(){
	    					window.location.href=res.data.url;
	    					$('.cover').hide();
	    				},1000);
	    				
	    			}else{
	    				layer.msg(res.em);
	    				$('.cover').hide();
	    			}
	    			

	    		},
	    		error:function(){
					layer.msg('数据导出失败，请稍后再试或减少单次的导出量！');
					$('.cover').hide();
	    		},
	    		complete:function(){
	    			// if(res.ec!=200)
	    			// 	$('.cover').hide();
	    		}
	    	})
	    });
	    /**
	     * progressbar
	     * @return {[type]} [description]
	     */
	    function progressBar(){
	    	$('#progress_bar').html('');
	    	let container = document.querySelector('#progress_bar')
	    	let progress=randomNum(80,99);
			let bar = new ProgressBar.Line(container, {
				strokeWidth: 4,
				easing: 'easeInOut',
				duration: 10000,
				color: '#428bca',
				trailColor: '#eee',
				trailWidth: 4,
				svgStyle: {width: '100%', height: '100%'},
				text: {
				    style: {
						// Text color.
						// Default: same as stroke color (options.color)
						color: '#fff',
						position: 'absolute',
						right: '0',
						top: '30px',
						padding: 0,
						margin: 0,
						transform: null
				    },
				    autoStyleContainer: false
				},
				from: {color: '#FFEA82'},
				to: {color: '#ED6A5A'},
				step: (state, bar) => {
				    bar.setText('订单导出中：'+Math.round(bar.value() * 100) + ' %');
				}
			});

			bar.animate(progress/100);  // Number from 0.0 to 1.0
			return bar;
	    }
	    // 生成随机数
	    function randomNum(minNum,maxNum){ 
		    switch(arguments.length){ 
		        case 1: 
		            return parseInt(Math.random()*minNum+1,10); 
		        break; 
		        case 2: 
		            return parseInt(Math.random()*(maxNum-minNum+1)+minNum,10); 
		        break; 
		            default: 
		                return 0; 
		            break; 
		    } 
		} 
		 
		
		// 区域合伙人添加操作员
		$('#edit_region').click(function(){
			$.ajax({
				type:'POST',
				url:'/wxapp/seqregion/getRegionChildManager',
				dataType:'json',
				success:function(res){
					if(res.ec==200){
						$('#region_mobile').val(res.data.m_mobile);
						$('#region_id').val(res.data.m_id);
					}
					// else{
					// 	 layer.msg(res.em);
					// }
				}
			});
			$('#region_model').modal('show');
		});
		$('#region_save').click(function(){
			let mobile=$('#region_mobile').val();
			let pwd=$('#region_pwd').val();
			$.ajax({
				type:'POST',
				url:'/wxapp/seqregion/editRegionChildManager',
				dataType:'json',
				data:{
					'mobile':mobile,
					'pwd':pwd
				},
				success:function(res){
					layer.msg(res.em);
					if(res.ec==200)
						$('#region_model').modal('hide');
				}
			});

		});

		// 快递发货
		$('.express-btn').on('click',function(){
			var feedback = $(this).data('feedback');
			if(feedback == 1){ //有维权不可发货，除非会员取消维权状态为3
				layer.msg('该订单有维权信息暂时不能进行发货处理！');
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
                    'group' : type == 1?1:0
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/activeRefund',
                    'data'  : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.msg(ret.em,{time: 1600},function () {
							layer.close(index);
							if(ret.ec == 200){
								window.location.reload();
							}
						});
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
    $('.btn-excel-activity').on('click',function(){
        $('#excelOrderActivity').modal('show');
    });

    $('.btn-print-list').on('click',function(){
        $('#printOrder').modal('show');
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
                'url'   : '/wxapp/order/finishSequenceOrder',
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
    $('.print-order-list').on('click',function () {
		var startDate = $('#print_startDate').val();
		var startTime = $('#timepicker_print_startTime').val();
		var endDate = $('#print_endDate').val();
		var endTime = $('#timepicker_print_endTime').val();
		var sn = $('#print_sn').val();
		var orderStatus = $('#print_orderStatus').val();
		var postType = $('#print_postType').val();
		var communityId = $('#print_communityId').val();
		var goodsname = $('#print_goodsname').val();


		var data = {
			startDate:startDate,
			startTime:startTime,
			endDate:endDate,
			endTime:endTime,
			sn:sn,
			orderStatus:orderStatus,
			postType:postType,
			communityId:communityId,
			goodsname:goodsname
		};


        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/printOrderList',
            'data'  : data,
            'dataType' : 'json',
             success  : function(ret){
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
     * 手动同步dingd
     */
    $('.order-synchron').on('click',function(){
        var tid = $(this).data('tid');
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'	: tid
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/order/orderSynchron',
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

    // 手动同步团长信息
    $('.sync_leader').click(function(){
    	 var tid = $(this).data('tid');
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'	: tid
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/syncLeaderInfo',
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

	$('#refund_reason').change(function () {
		let val = $(this).val();
		if(val < 0){
			$('.refund_note_row').show();
		}else{
			$('.refund_note_row').hide();
		}
	});

	$('.refund-btn-modal').on('click',function () {
		//先清空
		$('#hid_refund_status').val('');
		$('#hid_refund_tid').val('');
		$('#hid_refund_type').val('');
		$('#hid_refund_applettype').val('');
		$('#curr_refund').val('');
		$('#refund_reason').val(0);
		$('#refund_note').val('');

		$('#hid_refund_status').val($(this).data('status'));
		$('#hid_refund_tid').val($(this).data('tid'));
		$('#hid_refund_type').val($(this).data('type'));
		$('#hid_refund_applettype').val($(this).data('applet-type'));
		var coin_payment = $(this).data('coin-payment');
		var payment = $(this).data('payment');
		var total = parseFloat(payment) + parseFloat(coin_payment);
		$('#curr_refund').val(total);
	});

	//单个订单退款
	$('#refund-btn-new').on('click',function(){

		var status  = $('#hid_refund_status').val();
		var curr_refund = $('#curr_refund').val();
		var msg = '你确定要给该订单退款吗？';
		if(status==4){
			msg = '该订单已发货确定要退款吗？'
		}
		var tid  = $('#hid_refund_tid').val();
		var type = $('#hid_refund_type').val();
		var appletType = $('#hid_refund_applettype').val();
		var refund_reason = $('#refund_reason').val();
		var refund_note = $('#refund_note').val();
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
				'refund_reason' : refund_reason,
				'refund_note' : refund_note,
				// 'custom': 1,
				// 'curr_refund' : curr_refund,
				'group' : type == 1 || (type== 5 && appletType == 2) ? 1 : 0
			};
			$.ajax({
				'type'  : 'post',
				'url'   : '/wxapp/order/activeRefund',
				'data'  : data,
				'dataType'  : 'json',
				'success'   : function(ret){
					layer.close(index);
					layer.msg(ret.em,{ time : 2000 });
					if(ret.ec == 200){
						window.location.reload();
					}
				}
			});
		}, function() {

		});
	});


	$('#communityOrder').click(function () {
		$('#goodsOrder').attr('checked',false);
	});

	$('#goodsOrder').click(function () {
		$('#communityOrder').attr('checked',false);
	});
	$('#clearChildOrder').click(function(){
		let checked=$('#clearChildOrder').attr('checked');
		if(checked)
			$('#clearChildOrder').attr('checked',false);
		else
			$('#clearChildOrder').attr('checked',true);
	});

</script>
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .modal-body{
        overflow: hidden;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
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
</style>
<{include file="../common-second-menu.tpl"}>
<div  id="mainContent">
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/goodsratio/order" method="get">
                <div class="col-xs-11 form-group-box">
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
                                <div class="input-group-addon">购买人</div>
                                <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="购买人微信昵称">
                            </div>
                        </div>
                        <div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">下单时间</div>
							<input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							 <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
                        <input type="hidden" name="status" value="<{$status}>">
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
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
            </div>
        </div>
    </div>
    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $status eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
        <!---
                <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;"><i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span></button>
        -->
    </div>
    <div class="row">
        <!-- <div class="space-4"></div> -->
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fixed-table-box" style="margin-bottom: 30px;">
                        <div class="fixed-table-header">
                            <table class="table table-hover table-avatar">
                                <thead>
                                    <tr>
                                        <th class="hidden-480">订单编号</th>
                                        <th class="hidden-480">购买商品</th>
                                        <th>购买数量</th>
                                        <th>总价</th>
                                        <th>购买人</th>
                                        <th>购买人返现</th>
                                        <th>分享人</th>
                                        <th >分享人佣金</th>
                                        <th>订单状态</th>
                                        <th>
                                            <i class="icon-time bigger-110 hidden-480"></i>
                                            购买时间
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="fixed-table-body">
                            <table id="sample-table-1" class="table table-hover table-button">
                                <tbody>
                                <{foreach $list as $val}>
                                    <tr>
                                        <td><{$val['t_tid']}></td>
                                        <td>
                                            <a href="/wxapp/goodsratio/order?title=<{$val['t_title']}>"><{$val['t_title']}></a></td>
                                        <td><{$val['t_num']}></td>
                                        <td><{$val['t_total_fee']}></td>
                                        <td><a href="/wxapp/goodsratio/order?mid=<{$val['t_m_id']}>">
                                            <{$val['t_buyer_nick']}></a></td>
                                        <td>
                                            <{$val['od_0f_deduct']}>
                                        </td>
                                        <td><{if isset($level[$val['od_1f_id']])}>
                                            <a href="/wxapp/goodsratio/order?1f_id=<{$val['od_1f_id']}>"><{$level[$val['od_1f_id']]}></a>
                                            <{/if}></td>
                                        <td><{$val['od_1f_deduct']}></td>
                                        <td class="hidden-480" id="status_<{$val['o_id']}>">
                                            <span class="label label-sm label-<{$trade_status[$val['t_status']]['css']}>"><{$trade_status[$val['t_status']]['label']}></span>
                                        </td>
                                        <td><{date("Y-m-d H:i:s",$val['od_create_time'])}></td>
                                    </tr>
                                    <{/foreach}>
                                </tbody>
                            </table>
                            <{$paginator}>
                        </div>
                    </div>
                    
                </div><!-- /span -->
            </div><!-- /row -->
            <div id="divide-form"  class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-12 fanxian">
                                <div class="row" >
                                    <span class="col-sm-3" style="text-align: right;">总&emsp;&ensp;金&emsp;&ensp;额：</span>
                                    <div class="col-sm-9" id="total-money">￥0</div>
                                </div>
                                <div class="row" >
                                    <span class="col-sm-3" style="text-align: right;">下次返现时间：</span>
                                    <div class="col-sm-3" id="next-time"></div>
                                    <span class="col-sm-3" style="text-align: right;">上次返现时间：</span>
                                    <div class="col-sm-3" id="pre-time"></div>
                                </div>
                                <div class="row">
                                    <span class="col-sm-3" style="text-align: right;"  id="current-progress">分&emsp;&ensp;0&emsp;&ensp;期：</span>
                                    <div class="col-sm-9">
                                        <div class="progress" data-percent="0%">
                                            <div class="progress-bar" style="width:0%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
    </div>
</div>
<{include file="../bs-alert-tips.tpl"}>
<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var searchTradeInfo = <{$searchTradeInfo}>;
    var todayTradeInfo = <{$todayTradeInfo}>;
    var choseLink = <{$choseLink}>;
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");


        //退款处理
        $('.orderRefund').on('click',function(){
            var id = $(this).data('id');
            if(id){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/refund',
                    'data'  : {'oid':id},
                    'dataType' : 'json',
                    'success'   : function(ret){
                        if(ret.ec == 200){
                            $('#status_'+id).html('<span class="label label-sm label-default">订单退款</span>');
                            $('#refund_'+id).hide();
                        }
                        showTips(ret.em);
                    }
                });
            }
        });
        //分期情况展示
        $('.back_num').on('click',function(){
            var num = $(this).data('num');
            var title = $(this).data('title');
            var buyer = $(this).data('buyer');

            if(num){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/three/divide',
                    'data'  : {'num':num},
                    'dataType' : 'json',
                    'success'   : function(ret){
                        if(ret.ec == 200){
                            $('.modal-title').html('【 '+buyer+'】'+'的返现情况');
                            $('#total-money').html('￥'+ret.data.cd_divide_total);
                            $('#next-time').html(ret.data.cd_divide_next);
                            $('#pre-time').html(ret.data.cd_divide_pre);
                            $('#current-progress').html('分&emsp;&ensp;'+ret.data.cd_divide_num+'&emsp;&ensp;期：');

                            $('.progress').attr('data-percent',ret.data.ratio+'('+ret.data.cd_divide_had+'期)');
                            $('.progress-bar').css('width',ret.data.ratio);
                            $('#divide-form').modal('show');
                        }
                    }
                });
            }
        });
        //有赞订单同步
        $('.btn-syn').on('click',function(){
            var tid = $(this).data('tid');
            if(tid){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'tid':tid
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/synOrder',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });

        // 微店订单同步
        //有赞订单同步
        $('.btn-micro-syn').on('click',function(){
            var tid = $(this).data('tid');
            if(tid){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'tid':tid
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/microOrderSynchron',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
    });
    
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }
</script>



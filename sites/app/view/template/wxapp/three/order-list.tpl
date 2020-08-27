<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
    .datepicker{
        z-index: 1060 !important;
    }
    .ui-table-order .time-cell{
        width: 120px !important;
    }
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
<{include file="../common-second-menu.tpl"}>
<div  id="mainContent">
    <a href="javascript:;" class="btn btn-green btn-xs btn-excel" data-toggle="modal" data-target="#excelOrder"><i class="icon-download"></i>分销订单导出</a>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/three/order" method="get">
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
                                <div class="input-group-addon"><{$goodsName}>名称</div>
                                <input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="<{$goodsName}>名称">
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
                                <div class="input-group-addon" style="height:34px;">所属分销员</div>
                                <select id="fid" name="fid" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <{foreach $threeMember as $key => $val}>
                                <option <{if $fid eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
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
                                        <th class="hidden-480">购买<{$goodsName}></th>
                                        <th>购买数量</th>
                                        <th>总价</th>
                                        <th>购买人</th>
                                        <th>购买人返现</th>
                                        <th class="<{if $threeLevel < 1}>hide<{/if}>">上级</th>
                                        <th class="<{if $threeLevel < 1}>hide<{/if}>">上级佣金</th>
                                        <th class="<{if $threeLevel < 2}>hide<{/if}>">上二级</th>
                                        <th class="<{if $threeLevel < 2}>hide<{/if}>">上二级佣金</th>
                                        <th class="<{if $threeLevel < 3}>hide<{/if}>">上三级</th>
                                        <th class="<{if $threeLevel < 3}>hide<{/if}>">上三级佣金</th>
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
                                            <{if $val['g_name'] && $appletCfg['ac_type'] != 12}>
                                            <a><{$val['g_name']}></a></td>
                                            <{elseif $val['atc_title'] && $appletCfg['ac_type'] == 12}>
                                            <a><{$val['atc_title']}></a></td>
                                            <{else}>
                                            <a href="/wxapp/three/order?title=<{$val['t_title']}>"><{$val['t_title']}></a></td>
                                            <{/if}>
                                        <{if $val['to_num']}>
                                        <td><{$val['to_num']}></td>
                                        <{else}>
                                        <td><{$val['t_num']}></td>
                                        <{/if}>
                                        <{if $val['to_total']}>
                                        <td><{$val['to_total']}></td>
                                        <{else}>
                                        <td><{$val['t_total_fee']}></td>
                                        <{/if}>
                                        <td><a href="/wxapp/three/order?mid=<{$val['t_m_id']}>">
                                            <{$val['t_buyer_nick']}></a></td>
                                        <td>
                                            <{$val['od_0f_deduct']}>
                                        </td>
                                        <td class="<{if $threeLevel < 1}>hide<{/if}>"><{if isset($level[$val['od_1f_id']])}>
                                            <a href="/wxapp/three/order?1f_id=<{$val['od_1f_id']}>"><{$level[$val['od_1f_id']]}></a>
                                            <{/if}></td>
                                        <td class="<{if $threeLevel < 1}>hide<{/if}>"><{$val['od_1f_deduct']}></td>
                                        <td class="<{if $threeLevel < 2}>hide<{/if}>"><{if isset($level[$val['od_2f_id']])}>
                                            <a href="/wxapp/three/order?1f_id=<{$val['od_2f_id']}>"><{$level[$val['od_2f_id']]}></a>
                                            <{/if}></td>
                                        <td class="<{if $threeLevel < 2}>hide<{/if}>"><{$val['od_2f_deduct']}></td>
                                        <td class="<{if $threeLevel < 3}>hide<{/if}>"><{if isset($level[$val['od_3f_id']])}>
                                            <a href="/wxapp/three/order?1f_id=<{$val['od_3f_id']}>"><{$level[$val['od_3f_id']]}></a>
                                            <{/if}></td>
                                        <td class="<{if $threeLevel < 3}>hide<{/if}>"><{$val['od_3f_deduct']}></td>
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
<div class="modal fade" id="excelOrder" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
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
                    <form enctype="multipart/form-data" action="/wxapp/three/excelOrder" method="post">
                        <input type="hidden" value="<{$esId}>" name="esId">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">订单类型</label>
                            <div class="col-sm-4">
                                <select id="orderStatus" name="orderStatus" class="form-control">
                                    <{foreach $choseLink as $key=>$val}>
                                    <option value="<{$key}>"><{$val['label']}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属分销员</label>
                            <div class="col-sm-4">
                                <div class="input-group" style="width: 100%">
                                    <select id="efid" name="fid" style="height:34px;width:100%" class="form-control my-select2">
                                        <option value="0">全部</option>
                                        <{foreach $threeMember as $key => $val}>
                                        <option value="<{$key}>"><{$val}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
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
<{include file="../bs-alert-tips.tpl"}>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    var searchTradeInfo = <{$searchTradeInfo}>;
    var todayTradeInfo = <{$todayTradeInfo}>;
    var choseLink = <{$choseLink}>;
    console.log(searchTradeInfo);
    console.log(todayTradeInfo);
    console.log(choseLink);
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
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

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



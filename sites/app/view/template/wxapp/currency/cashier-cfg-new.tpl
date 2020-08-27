<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">

<!--<link rel="stylesheet" href="/public/wxapp/cashier/css/base.css">-->

<link rel="stylesheet" href="/public/wxapp/cashier/css/billlist.css?1">
<style>
    .balance .balance-info2 {
        width: 100%;
        text-align: left;
    }
    .code{
        float: left;
    }
    .line-display{
        display: inline-block;
        padding: 4px;
    }
    .switch-title{
        font-size: 18px;
    }
    .switch-span{
        display: inline-block;
        height: 30px;
        line-height: 30px;
        margin-bottom: 30px;
    }
    .total-amount{
        margin-right: 25px;
    }
    .datepicker{
        z-index: 1060 !important;
    }
    .stat-balance .balance-info{
        width: 16.66% !important;
    }
    .table thead tr th{
		color:#000;
		font-size:13px;
	}
	.item-wrap {
		position: relative;
	}
	.item-wrap .cover-btn{
		position: absolute;
		right: 0;
		top: 3px;
		width: 130px;
		height: 35px;
		background: #06BF04;
		color: #fff;
		text-align: center;
		line-height:35px;
		font-size: 16px;
		/*pointer-events: none;*/
		border-radius: 5px;
		cursor: pointer;
	}
	#pay_user{
		margin-left: 30px;
		width: 120px;
	}
	.pay-tip-box{
		padding: 10px 0;
		width: 300px;
		height: 170px;
		background: #fff;
		text-align: center;

	}
	.pay-tip-box p{
		margin: 30px 0;
		font-size: 28px;
	    color: #666;

	}
	.cancle-pay-btn{
		margin: 30px auto 0;
		width: 140px;
		height: 40px;
		border-radius: 5px;
		text-align: center;
		line-height: 40px;
		color: #fff;
		background: #ff2200;
		cursor: pointer;
	}
    select{
        -webkit-appearance:none;
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
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }

.form-group-box .form-group {margin: 5px 10px 5px 0px; float: none; }
</style>
<{if $plugin == 1}>
<{include file="../common-second-menu.tpl"}>
    <div id="content-con" style="margin-left: 130px">
<{else}>
    <div>
<{/if}>
<div class="tabbable">
    <ul class="nav nav-tabs" id="myTab">
        <li id="cashier-code" class="active">
            <a data-toggle="tab" href="javascript:;"  >
                <i class="green icon-home bigger-110"></i>
                收银台
            </a>
        </li>
        <!--
        <li>
            <a href="/wxapp/currency/cashRecode">
                <i class="green icon-flag bigger-110"></i>
                收银记录
            </a>
        </li>

        <li id="cashier-discount">
            <a data-toggle="tab" href="#discount">
                <i class="green icon-home bigger-110"></i>
                收银台设置
            </a>
        </li>
        -->
    </ul>

    <div class="tab-content">
        <{if $wxapp_cfg['ac_s_id'] eq 5655 && $plugin != 1}>
        <div id="qrcode-pay" class="tab-pane in active">
            <div class="ui-box settlement-info" style="height: 150px">
                <div class="balance clearfix" style="width: 85%;float: left;">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 16px">付款码付款</p>
                            <div class="item-wrap">
                                <b>支付金额</b>
                                <span class="line-display"><input type="number" id="pay_amount" class="form-control"></span>
                                <!--<b>支付用户</b>-->
                                <span class="line-display"><input  id="pay_user" class="form-control" autocomplete="off"></span>
                                <div class="cover-btn">确认支付</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <{/if}>
        <!--店铺基本信息-->
        <{if $curr_shop['s_broker_type'] != 2 && $plugin != 1}>
        <div id="home" class="tab-pane in active">
            <div class="ui-box settlement-info" style="height: 300px">
                <div class="balance clearfix" style="width: 15%;float: left;">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p>小程序收款码</p>
                            <div id="erweima">
                                <img src="<{$wxapp_cfg['ac_receivable_code']}>" alt="二维码" style="width:200px;">
                            </div>
                            <p><a href="/wxapp/currency/downCode">下载二维码</a>
                                <a href="javascript:;" onclick="updateAppletCashier('<{$val['ai_id']}>')" style="margin-left: 30px">更新二维码</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="balance clearfix" style="width: 85%;float: left;">
                    <div class="balance-info balance-info2" style="height: 275px">
                        <div class="code">
                            <span class="switch-span">
                                <span class="switch-title" style="font-size: 16px">余额支付&nbsp;</span>
                                <label id="choose-onoff" class="choose-onoff">
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="coinOpen" data-type="open" onchange="changeSwitch()" type="checkbox" <{if $payCfg && $payCfg['ap_coin']}> checked<{/if}>>
                                <span class="lbl"></span>
                                </label>
                            </span>
                            <p style="font-size: 16px">优惠条件和优惠金额设置</p>
                            <div class="item-wrap">
                                <b>每满</b>
                                <span class="line-display"><input type="number" id="full_amount" value="<{$payCfg['ap_full_amount']}>" class="form-control"></span>
                                <b>元，立减</b>
                                <span class="line-display"><input type="number" id="reduced_amount" value="<{$payCfg['ap_reduced_amount']}>" class="form-control"></span>
                                <b>元，每笔订单累计最高优惠</b>
                                <span class="line-display"><input type="number" id="high_amount" value="<{$payCfg['ap_high_amount']}>" class="form-control"></span>
                                <b>元，（未设置最高则表示优惠无上限）</b>
                            </div>
                            <button class="btn btn-sm btn-green btn-save" style="margin-top: 20px"> 保 存</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <{/if}>
        <div id="recode" class="tab-pane" style="display: block">
            <span style="font-weight: bold;margin-right: 5px;font-size: 14px">收银记录 <a href="javascript:;" class="btn btn-green btn-xs btn-excel"><i class="icon-download"></i>收银记录导出</a></span>
            <div class="page-header search-box" style="margin-bottom: 15px !important;">
                <div class="col-sm-12">
                    <form class="form-inline" action="<{if $plugin == 1}>/wxapp/cashier/record<{else}>/wxapp/currency/cashier<{/if}>" method="get">
                        <div class="col-xs-11 form-group-box">
                            <div class="form-container">
                                <div class="form-group" style="width: 280px;">
                                    <div class="input-group">
                                        <div class="input-group-addon">订单号</div>
                                        <input type="text" class="form-control" name="trade_id" value="<{$trade_id}>" placeholder="订单编号">
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <div class="input-group">
                                        <div class="input-group-addon">会员昵称</div>
                                        <input type="text" class="form-control" name="search_nickname" value="<{$search_nickname}>" placeholder="会员昵称">
                                    </div>
                                </div>

                                <{if $showShopSearch == 1}>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="height:34px;">所属商家</div>
                                        <select id="enterId" name="enterId" style="height:34px;width:100%" class="form-control my-select2">
                                            <option value="0">全部</option>
                                            <option value="-1" <{if $enterId == -1}>selected<{/if}>>平台</option>
                                            <{foreach $selectShop as $key => $val}>
                                        <option <{if $enterId eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>
                                <{/if}>

                                 <div class='form-group'>
                                    <div class="input-group" >
                                        <span class="input-group-addon">
                                            订单类型
                                        </span>
                                        <select class='form-control' name='order_status'>
                                            <option value='all' <{if $smarty.get.order_status=='all'}>selected <{/if}> >全部</option>
                                            <option value='payed' <{if $smarty.get.order_status=='payed'}>selected <{/if}>>已付款</option>
                                            <option value='refund' <{if $smarty.get.order_status=='refund'}>selected <{/if}>>已退款</option>
                                        </select>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <div class="input-group" >
                                        <span class="input-group-addon">
                                            支付方式
                                        </span>
                                        <select class='form-control' name='pay_type'>
                                            <option value='0' >全部</option>
                                            <{foreach $selPayType as $key => $val}>
                                        <option value="<{$key}>" <{if $pay_type eq $key}>selected<{/if}>><{$val}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <div class="input-group" >
                                        <span class="input-group-addon">
                                            收银员
                                        </span>
                                        <select class='form-control' name='os_manage'>
                                            <option value='0' >全部</option>
                                            <{foreach $osManage as $key => $val}>
                                        <option value="<{$key}>" <{if $os_manage eq $key}>selected<{/if}>><{$val['m_nickname']}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <div class="input-group" >
                                        <span class="input-group-addon">
                                            机器名称
                                        </span>
                                        <select class='form-control' name='search_machine'>
                                            <option value='0' >全部</option>
                                            <{foreach $machine as $key => $val}>
                                        <option value="<{$key}>" <{if $search_machine eq $key}>selected<{/if}>><{$val}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 500px;">
                                    <div class="input-group">
                                        <div class="input-group-addon" >支付时间</div>
                                        <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time"  autocomplete="off" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>

                                    <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" id="end-time"  autocomplete="off" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
    
                                    
                                    <span class="input-group-addon" style="background-color: #fff;" > <input type="checkbox" name="timeAll" id="timeAll" onclick="time_check()" value="1" <{if $timeAll ==1}>checked<{/if}>>全部</span>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="input-group" style="width: 210px;">
                                        <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                        <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                        <div class="col-xs-1 pull-right search-btn">
                            <button type="submit" class="btn btn-green btn-sm">查询</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--
            <div style="margin-bottom: 15px">
                <span class="total-amount">今日收益：<{$amountToday}></span>
                <span class="total-amount">总收益：<{$amountAll}></span>
                <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>收银记录导出</a>
            </div>
            -->
            <!-- 汇总信息 -->
            <div class="balance stat-balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                <div class="balance-info">
                    <div class="balance-title">收入金额<span></span></div>
                    <div class="balance-content">
                        <span class="money"><{$statInfo['todayMoney']}></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">收入笔数<span></span></div>
                    <div class="balance-content">
                        <span class="money"><{$statInfo['todayTotal']}></span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总收入金额<span></span></div>
                    <div class="balance-content">
                        <span class="money"><{$statInfo['totalMoney']}></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总收入笔数<span></span></div>
                    <div class="balance-content">
                        <span class="money"><{$statInfo['totalTotal']}></span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总退款金额<span></span></div>
                    <div class="balance-content">
                        <span class="money"><{$statInfo['refundMoney']}></span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总退款笔数<span></span></div>
                    <div class="balance-content">
                        <span class="money"><{$statInfo['refundTotal']}></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                    	<!--table-striped -->
                        <table id="sample-table-1" class="table table-hover table-button">
                            <thead>
                            <tr>
                                <th class="hidden-480">会员头像</th>
                                <th>会员昵称</th>
                                <{if $showShopSearch == 1}>
                                <th>所属商家</th>
                                <{/if}>
                                <th>订单编号</th>
                                <th>微信/支付宝交易号</th>
                                <th>机器名称</th>
                                <th>实付金额</th>
                                <th>支付方式</th>
                                <th>收银员</th>
                                <!-- <th>微信支付金额</th> -->
                                <!-- <th>余额支付金额</th> -->
                                <th>是否退款</th>
                                <th>退款金额</th>
                                <th><i class="icon-time bigger-110 hidden-480"></i>支付时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <{foreach $list as $item}>
                                <tr id="<{$item['cr_tid']}>">
                                    <td><img class="img-thumbnail" width="50" src="<{if $item['m_avatar'] && isset($item['m_avatar'])}><{$item['m_avatar']}> <{else}> /public/wxapp/cashier/img/avatar.png <{/if}>" /></td>
                                    <td><{if $item['m_nickname']}><{$item['m_nickname']}><{/if}></td>
                                    <{if $showShopSearch == 1}>
                                    <td><{if $item['es_name']}>
                                        <{$item['es_name']}>
                                        <{else}>
                                        平台
                                        <{/if}></td>
                                    <{/if}>
                                    <td><{$item['cr_tid']}></td>
                                    <td><{$item['t_pay_trade_no']}></td>
                                    <td><{$machine[$item['cr_code']]}></td>

                                    <td style="color:#333;"><{$item['cr_money']}></td>
                                    <td>
                                        <{$paytype[$item['cr_pay_type']]}>
                                        <input type="hidden" vlaue="<{$item['cr_pay_type']}>">
                                    </td>
                                    <td>
                                        <{$item['ma_nickname']}>
                                    </td>
                                    <!-- <td>
                                        <{$item['cr_online_money']}>
                                    </td> -->
                                    <!-- <td>
                                        <{$item['cr_balance']}>
                                    </td> -->
                                    <td><{if $item['cr_isrefund'] eq 1}><span style="color: red">已退款</span><{else}>未退款<{/if}></td>
                                    <td><{$item['cr_refund_money']}></td>
                                    <td><{date("Y-m-d H:i:s",$item['cr_pay_time'])}></td>
                                    <td>
                                        <{if $item['m_id'] gt 0 &&  $item['cr_isrefund'] eq 0 && $curr_shop['s_broker_type'] != 2 && !$plugin}>
                                        <a href="javascript:;" onclick="refundMoney('<{$item['cr_tid']}>')" class="btn btn-xs btn-danger del-btn" style="color:#f00;">退款</a>
                                        <{/if}>
                                        <{if $curr_shop['s_broker_type'] == 2 || $plugin == 1}>
                                          <a href="javascript:;" onclick="hxModal(this)" data-tid="<{$item['cr_tid']}>"  class="btn btn-xs btn-info" style="color:#f00;">详情</a>
                                          <{if $item['cr_refund_money'] < $item['cr_money']}>
                                          <a href="javascript:;" onclick="spzftkmodal(this)" data-tid="<{$item['cr_tid']}>" data-type="<{$item['cr_trade']}>" class="btn btn-xs btn-danger del-btn" style="color:#f00;">刷脸退款</a>
                                          <{/if}>
                                        <{/if}>
                                    </td>
                                </tr>
                                <{/foreach}>
                            <tr><td colspan="13" style="text-align:center"><{$paginator}></td></tr>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div>
            </div>
        </div>
        <div id="discount" class="tab-pane in">
            <div class="ui-box settlement-info">
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <!--
                            <span class="switch-span">
                                <span class="switch-title">余额支付1&nbsp;</span>
                                <label id="choose-onoff" class="choose-onoff">
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="coinOpen" data-type="open" onchange="changeSwitch()" type="checkbox" <{if $payCfg && $payCfg['ap_coin']}> checked<{/if}>>
                                <span class="lbl"></span>
                                </label>
                            </span>
                            -->
                            <p style="font-size: 18px">优惠条件和优惠金额设置</p>
                            <div class="item-wrap">
                                <b>每满</b>
                                <span class="line-display"><input type="number" id="full_amount" value="<{$payCfg['ap_full_amount']}>" class="form-control"></span>
                                <b>元，立减</b>
                                <span class="line-display"><input type="number" id="reduced_amount" value="<{$payCfg['ap_reduced_amount']}>" class="form-control"></span>
                                <b>元，每笔订单累计最高优惠</b>
                                <span class="line-display"><input type="number" id="high_amount" value="<{$payCfg['ap_high_amount']}>" class="form-control"></span>
                                <b>元，（未设置最高则表示优惠无上限）</b>
                            </div>
                            <button class="btn btn-sm btn-green btn-save" style="margin-left: 20px;margin-top: 20px"> 保 存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    收银记录导出
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/currency/importCashier" method="post">
                        <div class="form-group" style="height: 25px">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期"/>
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group" style="height: 45px">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off"  type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>

                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- 详情弹窗内容 -->
	<div class="modal-part hx-modal" id="hxmodal">

	</div>

  <!--退款相关弹窗-->
        <div class="modal-part hx-modal" id="tkmodal">

        </div>
        <!-- 商品支付退款弹窗内容 -->
        <div class="modal-part hx-modal" id="spzftkmodal">

        </div>
        <script type="text/html" id="template1">
            <ul class="info-list">
                <li>订单编号：${tid}</li>
                <li>商品名称：
                    <div class="good-list">
                        {{each(i,val) goodsList}}
                        <p>
                            ${val.title}   x ${val.num}
                        </p>
                        {{/each}}
                    </div>
                </li>
                <li>商品总数：${tradeNum}</li>
                <li>应收金额：${yfMoney}</li>
                <li>实收金额：${relMoney}</li>
                <li>支付方式：${payType}</li>
                <li>交易时间：${time}</li>
                <li>订单备注：无</li>
            </ul>
            <ul class="info-list" style="border-top: 1px solid #eee;">
                <li>收银员：${keeper}</li>
                <li>会员：${memName}</li>
                <li>会员等级：${memLevel}</li>
                <li>联系电话：${memMobile}</li>
            </ul>
            <div class="modal-btnarea clearfix">
                <!--<div class="modal-btn print-btn">打印</div>-->
                <div class="modal-btn close-btn" onclick="closeModal()">关闭</div>
            </div>
        </script>
        <script type="text/html" id="template2">
            <div class="tk-info">
                <table class="money-show">
                    <tr>
                        <td>金　　额</td>
                        <td>${payMoney}</td>
                    </tr>
                    <tr>
                        <td>已退金额</td>
                        <td>${refundMoney}</td>
                    </tr>
                </table>
                <div class="money-input-box">
                    <div class="input-item flex-wrap">
                        <label for="">输入金额</label>
                        <div class="flex-con">
                            <input type="text" id="amount" class="cus-input" placeholder="输入退款金额">
                        </div>
                        <span id="tag" class="tag" data-money="${ktMoney}" onclick="payall(this)">全部</span>
                    </div>
                    <input type="hidden" id="tid" value="${tid}">
                    <div class="input-item flex-wrap">
                        <label for="">退款原因</label>
                        <div class="flex-con">
                            <select class="cus-input" id="reason" name="">
                                {{each(i,val) refundReason}}
                                <option value="${i}">${val}</option>
                                {{/each}}
                            </select>
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">店主账号</label>
                        <div class="flex-con">
                            <input type="text" id="mobile" class="cus-input" placeholder="输入店主账号">
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">账号密码</label>
                        <div class="flex-con">
                            <input type="password" id="pass" class="cus-input" placeholder="输入账号密码">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-btnarea clearfix">
                <div class="modal-btn print-btn" onclick="closeModal()">取消</div>
                <div class="modal-btn close-btn" onclick="makesure()">确定</div>
            </div>
        </script>
        <script type="text/html" id="template3">
            <div class="tk-info">
                <div class="money-input-box">
                    <div class="input-item flex-wrap">
                        <label for="">退款商品</label>
                        <div class="flex-con">
                            <div class="cus-input tkgood-select">
                                <p class="choose-name" onclick="showGoods()">选择退款商品</p>
                                <div class="tkgood-list">
                                    <div class="good-num flex-wrap">
                                        <div class="flex-con" onclick="refundSelectAll()">
                                            <span class="good-name">全部商品</span>
                                        </div>
                                    </div>
                                    {{each(i,val) goodsList}}
                                    <div class="good-num flex-wrap active">
                                        <div class="flex-con">
                                            <span class="good-name">${val.title}</span>
                                            <span>×${val.relnum}</span>
                                        </div>
                                        <div class="num-change">
                                            <span class="minus" data-index="${i}" onclick="changeSelectGoodsNum(this,1)"></span>
                                            <span class="num num-${i}">${val.relnum}</span>
                                            <span class="add"   data-index="${i}" onclick="changeSelectGoodsNum(this,2)"></span>
                                        </div>
                                    </div>
                                    {{/each}}
                                    <div class="choose-opera flex-wrap">
                                        <span class="cancel-btn flex-con border-r" onclick="showGoods()">取消</span>
                                        <span class="confirm-btn flex-con" onclick="confirmRefundSelect()">确定</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" id="tid" value="${tid}">
                    <div class="input-item flex-wrap">
                        <label for="">退款金额</label>
                        <div class="flex-con">
                            <input type="text" readonly="readonly" value="${ktMoney}" class="cus-input" placeholder="输入退款金额">
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">退款原因</label>
                        <div class="flex-con">
                            <select id="reason" class="cus-input" name="">
                                {{each(i,val) refundReason}}
                                <option value="${i}">${val}</option>
                                {{/each}}
                            </select>
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">店长账号</label>
                        <div class="flex-con">
                            <input type="text" id="mobile" class="cus-input" placeholder="输入店主账号">
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">账号密码</label>
                        <div class="flex-con">
                            <input type="password" id="pass" class="cus-input" placeholder="输入账号密码">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-btnarea clearfix">
                <div class="modal-btn print-btn" onclick="closeModal()">取消</div>
                <div class="modal-btn close-btn" onclick="makesure()">确定</div>
            </div>
        </script>
<script type="text/javascript" src="/public/wxapp/cashier/js/laydate/laydate.js"></script>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script src="/public/wxapp/cashier/js/jquery-template.js"></script>
<script>
    var goodsList;
    var buys = [];
    var cashType = '';
    $(function () {
        var type = '<{$type}>'
        if(type && type=='discount'){
            $('#home').removeClass('active');
            $('#recode').css('display','none');
            $('#discount').addClass('active');
            $('#cashier-code').removeClass('active');
            $('#cashier-discount').addClass('active');
        }
        $('#cashier-code').on('click',function () {
            $('#recode').css('display','block');
        });
        $('#cashier-discount').on('click',function () {
            $('#recode').css('display','none');
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

        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });

        time_check();

    });
    $('.btn-save').on('click',function(){
        var full_amount = $('#full_amount').val();
        var reduced_amount = $('#reduced_amount').val();
        var high_amount = $('#high_amount').val();
        var data = {
            'full_amount'    : full_amount,
            'reduced_amount' : reduced_amount,
            'high_amount'    : high_amount
        };
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'	: 'post',
            'url'	: '/wxapp/currency/discountSet',
            'data'	: data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    // window.location.reload();
                }
            }
        });

//        if(full_amount && reduced_amount && high_amount){
//
//        }else{
//            layer.msg('请填写完整数据');
//        }
    });

    function updateAppletCashier() {
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'	: 'post',
            'url'	: '/wxapp/currency/updateAppletCashier',
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                     window.location.reload();
                }
            }
        });
    }

    function changeSwitch() {
        var open   = $('#coinOpen:checked').val();
        console.log(open);
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/changeSwitch',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em)
            }
        });
    }

    function refundMoney(tid) {
        layer.confirm('你确定要退款吗', {
            title: '确认退款',
            btn: ['确定','取消']    //按钮
        }, function(){
            if(tid){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'	: 'post',
                    'url'	: '/wxapp/currency/refundCashierOrder',
                    'data'	: { tid:tid},
                    'dataType' : 'json',
                    'success'  : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }else{
                layer.msg('请刷新页面重试');
            }
        },function (){

        });
    }

    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

	//点击付款
	$('.cover-btn').click(function(){
        var amount = $('#pay_amount').val();
        if(amount>0){
            $("#pay_user").focus();
            let openDiv='<div class="pay-tip-box"><p>请扫描付款码</p><div class="cancle-pay-btn" onclick="cancelPay()">取消付款</div></div>'
            layer.open({
                type: 1,
                title:'等待付款',
                closeBtn: 0,
                shadeClose:false,
                content: openDiv //这里content是一个普通的String
            });
        }else{
            layer.msg('请输入支付金额');
        }

	});
	//关闭付款
	function cancelPay(){
		console.log('关闭付款');
		$("#pay_user").blur();
		layer.closeAll();
	}


    $("#qrcode-pay").bind("keydown",function(e){

        // 兼容FF和IE和Opera

        var theEvent = e || window.event;

        var code = theEvent.keyCode || theEvent.which || theEvent.charCode;

        if (code == 13) {
            //回车执行查询
            var amount = $('#pay_amount').val();
            var user = $('#pay_user').val();
            console.log(user);
            if(user){
                $("#pay_user").blur();
                $('#pay_user').val('');
                if(amount>0){
                    layer.closeAll();
                    var index = layer.load(1, {
                        shade: [0.1,'#fff'] //0.1透明度的白色背景
                    });
                    $.ajax({
                        'type'	: 'post',
                        'url'	: '/wxapp/currency/microPay',
                        'data'	: { amount:amount,code:user},
                        'dataType' : 'json',
                        'success'  : function(ret){
                            layer.close(index);
                            console.log(ret);
                            if(ret.ec == 200){
                                layer.msg('支付成功', {
                                    icon: 1,
                                    time: 3000 //3秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    window.location.reload();
                                });

                            }
                        }
                    });
                }else{
                    layer.closeAll();
                    layer.msg('请输入支付金额');
                }
            }else{
                layer.msg('请重新扫描支付码', {
                    icon: 1,
                    time: 2000 //3秒关闭（如果不配置，默认是3秒）
                }, function(){
                    layer.closeAll();
                });
            }
        }

    });
    //记录详情
    function hxModal(ele){
        let tid = $(ele).data('tid');
        if(tid){
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/cash/recordDetail',
                'data'	: {tid:tid},
                'dataType' : 'json',
                'success'  : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        //赋值并打开弹窗
                        $('#hxmodal').html('');
                        $('#template1').tmpl(ret.data).appendTo('#hxmodal');
                        layer.open({
                            type: 1,
                            area: ['360px'],
                            title: ['订单详情','font-size:16px;font-weight:bold;text-align:center;padding:0 20px;background-color:#fff;height:50px;line-height:50px;'],
                            closeBtn:0,
                            content: $('#hxmodal') //这里content是一个普通的String
                        });

                    }
                }
            });
        }else{
           layer.msg('请重试');
        }

    }
    //退款金额
    function tkModal(){
        layer.open({
            type: 1,
            area: ['380px'],
            title: ['退款','font-size:16px;font-weight:bold;text-align:center;padding:0 20px;background-color:#fff;height:50px;line-height:50px;'],
            closeBtn:0,
            content: $('#tkmodal') //这里content是一个普通的String
        });
    }
    //处理退款弹窗
    function spzftkmodal(ele){
        let tid  = $(ele).data('tid');
        var type = $(ele).data('type');
        if(tid){
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/cash/getTradeDataByTid',
                'data'	: {tid:tid},
                'dataType' : 'json',
                'success'  : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        //赋值并打开弹窗
                        $('#spzftkmodal').html('');
                        if(type == 1){
                          $('#template2').tmpl(ret.data).appendTo('#spzftkmodal');
                        }else{
                          $('#template3').tmpl(ret.data).appendTo('#spzftkmodal');
                        }
                        goodsList  = ret.data.goodsList;
                        cashType   = ret.data.cashType;
                        layer.open({
                            type: 1,
                            area: ['380px'],
                            title: ['退款','font-size:16px;font-weight:bold;text-align:center;padding:0 20px;background-color:#fff;height:50px;line-height:50px;'],
                            closeBtn:0,
                            content: $('#spzftkmodal') //这里content是一个普通的String
                        });
                    }
                }
            });
        }else{
            layer.msg('请重试');
        }


    }
    function closeModal(){
			layer.close(layer.index)
	}
    function payall(ele){
      let money = $(ele).data('money');
      $('#amount').val(money);
    }
    function showGoods(){
      $('.tkgood-list').toggleClass('show');
    }
    //处理数量修改调整
    function changeSelectGoodsNum(ele,type){
      var index  = $(ele).attr('data-index');
      let relnum = 0;
      if(goodsList){
        let relnumexit = goodsList[index].relnum;//最大可退款量
        relnum = $('.num-'+index).html();
        if(type == 1){
           relnum =  relnum-1 >0?parseInt(relnum)-1:0;
        }else if (type == 2) {
           relnum =  relnum+1 <= relnumexit?parseInt(relnum)+1:relnumexit;

        }
      }
      goodsList[index]['refundNum'] = relnum;
      $('.num-'+index).html(relnum);
    }
    //处理退款数据
    function refundSelectAll(){
      buys = [];
      for(var i in goodsList){
        goodsList[i]['refundNum'] = goodsList[i]['relnum']
        buys.push({
          'num': goodsList[i]['relnum'],
          'id': goodsList[i]['id']
        })
      }
      $('.choose-name').html("全部商品");
      console.log(buys);
      showGoods();
   }
   //处理选择后的结果
   function confirmRefundSelect(){
      buys     = [];
      let html = '';
      for(var i in goodsList){
        if(goodsList[i]['refundNum'] > 0){
          buys.push({
            'num': goodsList[i]['refundNum'],
            'id' : goodsList[i]['id']
          })
          html += goodsList[i]['title'] + '×' + goodsList[i]['refundNum'] + " ";
        }
      }
      $('.choose-name').html(html);
      console.log(buys);
      showGoods();
  }
  //点击保存的操作
  function makesure(){
    var params = ['tid','amount','reason','mobile','pass'];
    var tid    = $('#tid').val();
    var amount = $('#amount').val();
    var reason = $('#reason').val();
    var mobile = $('#mobile').val();
    var pass   = $('#pass').val();
    if(mobile && pass){
      if(cashType == 1 && !amount){
         layer.msg('无可退款金额');
         return
      }
      if(cashType == 2 && !buys){
        layer.msg('请选择退款商品');
          return
      }
      buys = buys?JSON.stringify(buys):buys;
      var indexs = layer.load(1, {
          shade: [0.1,'#fff'] //0.1透明度的白色背景
      });
      var data = {tid:tid,amount:amount,reason:reason,mobile:mobile,pass:pass,buys:buys};
      $.ajax({
          'type'	: 'post',
          'url'	: '/wxapp/cash/refundCashierNew',
          'data'	: data,
          'dataType' : 'json',
          'success'  : function(ret){
              layer.msg(ret.em,{
                time:2000
              },function(){
                if(ret.ec == 200){
                  window.location.reload();
                }else{
                  layer.closeAll();
                }
              });
          }
      });
    }else{
      layer.msg('请填写操作账号');
    }
  }


  function time_check() {
    let checkAll = $('#timeAll').get(0).checked ? 1 : 0;
    console.log(checkAll);
    if(checkAll ==1) {
        // $('#start-time').val('');
        // $('#end-time').val('');

        $('#start-time').prop('disabled', true);
        $('#end-time').prop('disabled', true);
    } else {
        $('#start-time').removeAttr('disabled');
        $('#end-time').removeAttr('disabled');
    }
  }

</script>

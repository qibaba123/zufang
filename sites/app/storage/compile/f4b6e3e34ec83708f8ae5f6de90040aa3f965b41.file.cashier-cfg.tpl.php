<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 08:49:57
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/cashier-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13544262635e8bce359f9136-15238420%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4b6e3e34ec83708f8ae5f6de90040aa3f965b41' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/cashier-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13544262635e8bce359f9136-15238420',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'plugin' => 0,
    'wxapp_cfg' => 0,
    'curr_shop' => 0,
    'val' => 0,
    'payCfg' => 0,
    'trade_id' => 0,
    'showShopSearch' => 0,
    'enterId' => 0,
    'selectShop' => 0,
    'key' => 0,
    'start' => 0,
    'end' => 0,
    'amountToday' => 0,
    'amountAll' => 0,
    'statInfo' => 0,
    'list' => 0,
    'item' => 0,
    'paytype' => 0,
    'paginator' => 0,
    'type' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8bce35aaac79_88253775',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8bce35aaac79_88253775')) {function content_5e8bce35aaac79_88253775($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<link rel="stylesheet" href="/public/wxapp/cashier/css/billlist.css">
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
</style>
<?php if ($_smarty_tpl->tpl_vars['plugin']->value==1) {?>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <div id="content-con" style="margin-left: 130px">
<?php } else { ?>
    <div>
<?php }?>
<div class="tabbable">
    <ul class="nav nav-tabs" id="myTab">
        <li id="cashier-code" class="active">
            <a data-toggle="tab" href="javascript:;" onclick="spzftkmodal()" >
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
        <?php if ($_smarty_tpl->tpl_vars['wxapp_cfg']->value['ac_s_id']==5655&&$_smarty_tpl->tpl_vars['plugin']->value!=1) {?>
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
        <?php }?>
        <!--店铺基本信息-->
        <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_broker_type']!=2&&$_smarty_tpl->tpl_vars['plugin']->value!=1) {?>
        <div id="home" class="tab-pane in active">
            <div class="ui-box settlement-info" style="height: 300px">
                <div class="balance clearfix" style="width: 15%;float: left;">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p>小程序收款码</p>
                            <div id="erweima">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['wxapp_cfg']->value['ac_receivable_code'];?>
" alt="二维码" style="width:200px;">
                            </div>
                            <p><a href="/wxapp/currency/downCode">下载二维码</a>
                                <a href="javascript:;" onclick="updateAppletCashier('<?php echo $_smarty_tpl->tpl_vars['val']->value['ai_id'];?>
')" style="margin-left: 30px">更新二维码</a>
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
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="coinOpen" data-type="open" onchange="changeSwitch(this)" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payCfg']->value&&$_smarty_tpl->tpl_vars['payCfg']->value['ap_coin']) {?> checked<?php }?>>
                                <span class="lbl"></span>
                                </label>
                            </span>
                            <?php if ($_smarty_tpl->tpl_vars['wxapp_cfg']->value['ac_type']==4) {?>
                            <!-- 仅在餐饮类小程序后台显示 -->
                         
                            <span class="switch-span">
                                <span class="switch-title" style="font-size: 16px">开启会员价格&nbsp;</span>
                                <label id="choose-onoff" class="choose-onoff">
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="vipOpen" data-type="open" data-field='ap_meal_vip' onchange="changeSwitch(this)" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payCfg']->value&&$_smarty_tpl->tpl_vars['payCfg']->value['ap_meal_vip']) {?> checked<?php }?>>
                                <span class="lbl"></span>
                                </label>
                            </span>
                            <span class="switch-span">
                                <span class="switch-title" style="font-size: 16px">开启优惠券&nbsp;(<small>仅平台无门槛优惠券可用</small>)</span>
                                <label id="choose-onoff" class="choose-onoff">
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="couponOpen" data-type="open" data-field='ap_meal_coupon' onchange="changeSwitch(this)" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payCfg']->value&&$_smarty_tpl->tpl_vars['payCfg']->value['ap_meal_coupon']) {?> checked<?php }?>>
                                <span class="lbl"></span>
                                </label>
                            </span>
                            <?php }?>
                            <p style="font-size: 16px">优惠条件和优惠金额设置</p>
                            <div class="item-wrap">
                                <b>每满</b>
                                <span class="line-display"><input type="number" id="full_amount" value="<?php echo $_smarty_tpl->tpl_vars['payCfg']->value['ap_full_amount'];?>
" class="form-control"></span>
                                <b>元，立减</b>
                                <span class="line-display"><input type="number" id="reduced_amount" value="<?php echo $_smarty_tpl->tpl_vars['payCfg']->value['ap_reduced_amount'];?>
" class="form-control"></span>
                                <b>元，每笔订单累计最高优惠</b>
                                <span class="line-display"><input type="number" id="high_amount" value="<?php echo $_smarty_tpl->tpl_vars['payCfg']->value['ap_high_amount'];?>
" class="form-control"></span>
                                <b>元，（未设置最高则表示优惠无上限）</b>
                            </div>
                            <button class="btn btn-sm btn-green btn-save" style="margin-top: 20px"> 保 存</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php }?>
        <div id="recode" class="tab-pane" style="display: block">
            <span style="font-weight: bold;margin-right: 5px;font-size: 14px">收银记录 <a href="javascript:;" class="btn btn-green btn-xs btn-excel"><i class="icon-download"></i>收银记录导出</a></span>
            <div class="page-header search-box" style="margin-bottom: 15px !important;">
                <div class="col-sm-12">
                    <form class="form-inline" action="<?php if ($_smarty_tpl->tpl_vars['plugin']->value==1) {?>/wxapp/cashier/record<?php } else { ?>/wxapp/currency/cashier<?php }?>" method="get">
                        <div class="col-xs-11 form-group-box">
                            <div class="form-container">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">订单号</div>
                                        <input type="text" class="form-control" name="trade_id" value="<?php echo $_smarty_tpl->tpl_vars['trade_id']->value;?>
">
                                    </div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['showShopSearch']->value==1) {?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="height:34px;">所属商家</div>
                                        <select id="enterId" name="enterId" style="height:34px;width:100%" class="form-control my-select2">
                                            <option value="0">全部</option>
                                            <option value="-1" <?php if ($_smarty_tpl->tpl_vars['enterId']->value==-1) {?>selected<?php }?>>平台</option>
                                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['selectShop']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                        <option <?php if ($_smarty_tpl->tpl_vars['enterId']->value==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon" >支付时间</div>
                                        <input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group" style="width: 210px;">
                                        <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                        <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                    </div>
                                </div>

                                 <div class='form-group'>
                                    <div class="input-group" style="width: 210px;">
                                        <span class="input-group-addon">
                                            订单类型
                                        </span>
                                        <select class='form-control' name='order_status'>
                                            <option value='all' <?php if ($_GET['order_status']=='all') {?>selected <?php }?> >全部</option>
                                            <option value='payed' <?php if ($_GET['order_status']=='payed') {?>selected <?php }?>>已付款</option>
                                            <option value='refund' <?php if ($_GET['order_status']=='refund') {?>selected <?php }?>>已退款</option>
                                        </select>
                                    </div>
                                </div>
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
                <span class="total-amount">今日收益：<?php echo $_smarty_tpl->tpl_vars['amountToday']->value;?>
</span>
                <span class="total-amount">总收益：<?php echo $_smarty_tpl->tpl_vars['amountAll']->value;?>
</span>
                <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>收银记录导出</a>
            </div>
            -->
            <!-- 汇总信息 -->
            <div class="balance stat-balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                <div class="balance-info">
                    <div class="balance-title">今日收入金额<span></span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['todayMoney'];?>
</span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">今日收入笔数<span></span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['todayTotal'];?>
</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总收入金额<span></span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['totalMoney'];?>
</span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总收入笔数<span></span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['totalTotal'];?>
</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总退款金额<span></span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['refundMoney'];?>
</span>
                        <span class="unit">元</span>
                    </div>
                </div>
                <div class="balance-info">
                    <div class="balance-title">总退款笔数<span></span></div>
                    <div class="balance-content">
                        <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['refundTotal'];?>
</span>
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
                                <?php if ($_smarty_tpl->tpl_vars['showShopSearch']->value==1) {?>
                                <th>所属商家</th>
                                <?php }?>
                                <th>订单编号</th>
                                <th>实付金额</th>
                                <th>支付方式</th>
                                <!-- <th>微信支付金额</th> -->
                                <!-- <th>余额支付金额</th> -->
                                <th>是否退款</th>
                                <th>退款金额</th>
                                <th><i class="icon-time bigger-110 hidden-480"></i>支付时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                <tr id="<?php echo $_smarty_tpl->tpl_vars['item']->value['cr_tid'];?>
">
                                    <td><img class="img-thumbnail" width="50" src="<?php if ($_smarty_tpl->tpl_vars['item']->value['m_avatar']&&isset($_smarty_tpl->tpl_vars['item']->value['m_avatar'])) {?><?php echo $_smarty_tpl->tpl_vars['item']->value['m_avatar'];?>
 <?php } else { ?> /public/app/images/logo.jpg <?php }?>" /></td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['m_nickname']) {?><?php echo $_smarty_tpl->tpl_vars['item']->value['m_nickname'];?>
<?php }?></td>
                                    <?php if ($_smarty_tpl->tpl_vars['showShopSearch']->value==1) {?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['es_name']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['es_name'];?>

                                        <?php } else { ?>
                                        平台
                                        <?php }?></td>
                                    <?php }?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['cr_tid'];?>
</td>
                                    <td style="color:#333;"><?php echo $_smarty_tpl->tpl_vars['item']->value['cr_money'];?>
</td>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['paytype']->value[$_smarty_tpl->tpl_vars['item']->value['cr_pay_type']];?>

                                    </td>
                                    <!-- <td>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['cr_online_money'];?>

                                    </td> -->
                                    <!-- <td>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['cr_balance'];?>

                                    </td> -->
                                    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['cr_isrefund']==1) {?><span style="color: red">已退款</span><?php } else { ?>未退款<?php }?></td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['cr_isrefund']==1) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['cr_money'];?>

                                        <?php } else { ?>
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['cr_refund_money'];?>

                                        <?php }?>
                                        </td>
                                    <td><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['item']->value['cr_pay_time']);?>
</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['m_id']>0&&$_smarty_tpl->tpl_vars['item']->value['cr_isrefund']==0) {?>
                                        <a href="javascript:;" onclick="refundMoney('<?php echo $_smarty_tpl->tpl_vars['item']->value['cr_tid'];?>
')" class="btn btn-xs btn-danger del-btn" style="color:#f00;">退款</a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                            <tr><td colspan="10"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
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
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="coinOpen" data-type="open" onchange="changeSwitch()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['payCfg']->value&&$_smarty_tpl->tpl_vars['payCfg']->value['ap_coin']) {?> checked<?php }?>>
                                <span class="lbl"></span>
                                </label>
                            </span>
                            -->
                            <p style="font-size: 18px">优惠条件和优惠金额设置</p>
                            <div class="item-wrap">
                                <b>每满</b>
                                <span class="line-display"><input type="number" id="full_amount" value="<?php echo $_smarty_tpl->tpl_vars['payCfg']->value['ap_full_amount'];?>
" class="form-control"></span>
                                <b>元，立减</b>
                                <span class="line-display"><input type="number" id="reduced_amount" value="<?php echo $_smarty_tpl->tpl_vars['payCfg']->value['ap_reduced_amount'];?>
" class="form-control"></span>
                                <b>元，每笔订单累计最高优惠</b>
                                <span class="line-display"><input type="number" id="high_amount" value="<?php echo $_smarty_tpl->tpl_vars['payCfg']->value['ap_high_amount'];?>
" class="form-control"></span>
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
<!--退款相关弹窗-->
        <div class="modal-part hx-modal" id="tkmodal">
            <div class="tk-info">
                <table class="money-show">
                    <tr>
                        <td>金　　额</td>
                        <td>152.6</td>
                    </tr>
                    <tr>
                        <td>已退金额</td>
                        <td>15</td>
                    </tr>
                </table>
                <div class="money-input-box">
                    <div class="input-item flex-wrap">
                        <label for="">输入金额</label>
                        <div class="flex-con">
                            <input type="text" class="cus-input" placeholder="输入退款金额">
                        </div>
                        <span class="tag">全部</span>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">退款原因</label>
                        <div class="flex-con">
                            <select class="cus-input" name="">
                                <option value="其它原因">其它原因</option>
                                <option value="原因1">原因1</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">店主账号</label>
                        <div class="flex-con">
                            <input type="text" class="cus-input" placeholder="输入店主账号">
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">账号密码</label>
                        <div class="flex-con">
                            <input type="password" class="cus-input" placeholder="输入账号密码">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-btnarea clearfix">
                <div class="modal-btn print-btn" onclick="closeModal()">取消</div>
                <div class="modal-btn close-btn">确定</div>
            </div>
        </div>
        <!-- 商品支付退款弹窗内容 -->
        <div class="modal-part hx-modal" id="spzftkmodal">
            <div class="tk-info">
                <div class="money-input-box">
                    <div class="input-item flex-wrap">
                        <label for="">退款商品</label>
                        <div class="flex-con">
                            <div class="cus-input tkgood-select">
                                <p class="choose-name">选择退款商品</p>
                                <div class="tkgood-list show">
                                    <div class="good-num flex-wrap">
                                        <div class="flex-con">
                                            <span class="good-name">全部商品</span>
                                        </div>
                                    </div>
                                    <div class="good-num flex-wrap active">
                                        <div class="flex-con">
                                            <span class="good-name">海口市东方航空罗斯福建安路附近可啊</span>
                                            <span>×2</span>
                                        </div>
                                        <div class="num-change">
                                            <span class="minus"></span>
                                            <span class="num">1</span>
                                            <span class="add"></span>
                                        </div>
                                    </div>
                                    <div class="good-num flex-wrap">
                                        <div class="flex-con">
                                            <span class="good-name">海口市东方航空罗</span>
                                            <span>×2</span>
                                        </div>
                                        <div class="num-change">
                                            <span class="minus"></span>
                                            <span class="num">2</span>
                                            <span class="add dis"></span>
                                        </div>
                                    </div>
                                    <div class="choose-opera flex-wrap">
                                        <span class="cancel-btn flex-con border-r">取消</span>
                                        <span class="confirm-btn flex-con">确定</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">可退金额</label>
                        <div class="flex-con">
                            <input type="text" class="cus-input" placeholder="输入退款金额">
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">退款原因</label>
                        <div class="flex-con">
                            <select class="cus-input" name="">
                                <option value="其它原因">其它原因</option>
                                <option value="原因1">原因1</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">店长账号</label>
                        <div class="flex-con">
                            <input type="text" class="cus-input" placeholder="输入店主账号">
                        </div>
                    </div>
                    <div class="input-item flex-wrap">
                        <label for="">账号密码</label>
                        <div class="flex-con">
                            <input type="password" class="cus-input" placeholder="输入账号密码">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-btnarea clearfix">
                <div class="modal-btn print-btn" onclick="closeModal()">取消</div>
                <div class="modal-btn close-btn">确定</div>
            </div>
        </div>
<script type="text/javascript" src="/public/wxapp/cashier/js/laydate/laydate.js"></script>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script>
    $(function () {
        var type = '<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
'
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

    function changeSwitch(element) {
        
        let id=$(element).attr('id');
        console.log(id);
        var open   = $('#'+id+':checked').val();
        let fields  = $(element).data('field');
        var data = {
            value:open,
            field:fields
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

    //处理退款弹窗
    function spzftkmodal(){
        layer.open({
            type: 1,
            area: ['380px'],
            title: ['退款','font-size:16px;font-weight:bold;text-align:center;padding:0 20px;background-color:#fff;height:50px;line-height:50px;'],
            closeBtn:0,
            content: $('#spzftkmodal') //这里content是一个普通的String
        });
    }

    function closeModal() {
        layer.closeAll();
    }

</script>
<?php }} ?>

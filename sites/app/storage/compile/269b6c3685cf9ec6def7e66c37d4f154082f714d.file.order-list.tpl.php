<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:12:47
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/three/order-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:571097965e859e7f927504-95269082%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '269b6c3685cf9ec6def7e66c37d4f154082f714d' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/three/order-list.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '571097965e859e7f927504-95269082',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tid' => 0,
    'goodsName' => 0,
    'title' => 0,
    'nickname' => 0,
    'threeMember' => 0,
    'fid' => 0,
    'key' => 0,
    'val' => 0,
    'start' => 0,
    'end' => 0,
    'status' => 0,
    'todayTradeInfo' => 0,
    'searchTradeInfo' => 0,
    'choseLink' => 0,
    'threeLevel' => 0,
    'list' => 0,
    'appletCfg' => 0,
    'level' => 0,
    'trade_status' => 0,
    'paginator' => 0,
    'esId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e859e7f9ebe53_73680870',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e859e7f9ebe53_73680870')) {function content_5e859e7f9ebe53_73680870($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
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
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
                                <input type="text" class="form-control" name="tid" value="<?php echo $_smarty_tpl->tpl_vars['tid']->value;?>
"  placeholder="订单编号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
名称</div>
                                <input type="text" class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"  placeholder="<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">购买人</div>
                                <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
"  placeholder="购买人微信昵称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">所属分销员</div>
                                <select id="fid" name="fid" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['threeMember']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <option <?php if ($_smarty_tpl->tpl_vars['fid']->value==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">下单时间</div>
							<input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							 <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
                        <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
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
                <span class="money"><?php if ($_smarty_tpl->tpl_vars['todayTradeInfo']->value['money']) {?><?php echo $_smarty_tpl->tpl_vars['todayTradeInfo']->value['money'];?>
<?php } else { ?>0<?php }?></span>
                <span class="unit">元</span>
                <!--<a href="/manage/shop/inout" class="pull-right">收支明细</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">今日订单数<span></span></div>
            <div class="balance-content">
                <span class="money"><?php if ($_smarty_tpl->tpl_vars['todayTradeInfo']->value) {?><?php echo $_smarty_tpl->tpl_vars['todayTradeInfo']->value['total'];?>
<?php } else { ?>0<?php }?></span>
                <!--<span class="unit">元</span>
                <a href="/manage/shop/settled" class="pull-right">待结算记录</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">店铺收益

            </div>
            <div class="balance-content">
                <span class="money money-font"><?php if ($_smarty_tpl->tpl_vars['searchTradeInfo']->value['money']) {?><?php echo $_smarty_tpl->tpl_vars['searchTradeInfo']->value['money'];?>
<?php } else { ?>0<?php }?></span>
                <span class="unit">元</span>
                <!--<a href="/manage/shop/inout" class="pull-right" style="margin-left: 6px;"> 明细 </a>
                <!--<a href="/manage/withdraw/apply" class="ui-btn ui-btn-primary pull-right btn-margin-right js-goto-btn">提现</a>-->
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">店铺订单数</div>
            <div class="balance-content">
                <span class="money money-font"><?php if ($_smarty_tpl->tpl_vars['searchTradeInfo']->value) {?><?php echo $_smarty_tpl->tpl_vars['searchTradeInfo']->value['total'];?>
<?php } else { ?>0<?php }?></span>
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
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['choseLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['href'];?>
" <?php if ($_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['val']->value['key']) {?> class="active" <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
        <?php } ?>
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
                                        <th class="hidden-480">购买<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
</th>
                                        <th>购买数量</th>
                                        <th>总价</th>
                                        <th>购买人</th>
                                        <th>购买人返现</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<1) {?>hide<?php }?>">上级</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<1) {?>hide<?php }?>">上级佣金</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>">上二级</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>">上二级佣金</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>">上三级</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>">上三级佣金</th>
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
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <tr>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
</td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['g_name']&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=12) {?>
                                            <a><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
</a></td>
                                            <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['atc_title']&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==12) {?>
                                            <a><?php echo $_smarty_tpl->tpl_vars['val']->value['atc_title'];?>
</a></td>
                                            <?php } else { ?>
                                            <a href="/wxapp/three/order?title=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
</a></td>
                                            <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['to_num']) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['to_num'];?>
</td>
                                        <?php } else { ?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['t_num'];?>
</td>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['to_total']) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['to_total'];?>
</td>
                                        <?php } else { ?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>
</td>
                                        <?php }?>
                                        <td><a href="/wxapp/three/order?mid=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_m_id'];?>
">
                                            <?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>
</a></td>
                                        <td>
                                            <?php echo $_smarty_tpl->tpl_vars['val']->value['od_0f_deduct'];?>

                                        </td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<1) {?>hide<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_1f_id']])) {?>
                                            <a href="/wxapp/three/order?1f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['od_1f_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_1f_id']];?>
</a>
                                            <?php }?></td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<1) {?>hide<?php }?>"><?php echo $_smarty_tpl->tpl_vars['val']->value['od_1f_deduct'];?>
</td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_2f_id']])) {?>
                                            <a href="/wxapp/three/order?1f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['od_2f_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_2f_id']];?>
</a>
                                            <?php }?></td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>"><?php echo $_smarty_tpl->tpl_vars['val']->value['od_2f_deduct'];?>
</td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_3f_id']])) {?>
                                            <a href="/wxapp/three/order?1f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['od_3f_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_3f_id']];?>
</a>
                                            <?php }?></td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>"><?php echo $_smarty_tpl->tpl_vars['val']->value['od_3f_deduct'];?>
</td>
                                        <td class="hidden-480" id="status_<?php echo $_smarty_tpl->tpl_vars['val']->value['o_id'];?>
">
                                            <span class="label label-sm label-<?php echo $_smarty_tpl->tpl_vars['trade_status']->value[$_smarty_tpl->tpl_vars['val']->value['t_status']]['css'];?>
"><?php echo $_smarty_tpl->tpl_vars['trade_status']->value[$_smarty_tpl->tpl_vars['val']->value['t_status']]['label'];?>
</span>
                                        </td>
                                        <td><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['val']->value['od_create_time']);?>
</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

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
                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['esId']->value;?>
" name="esId">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">订单类型</label>
                            <div class="col-sm-4">
                                <select id="orderStatus" name="orderStatus" class="form-control">
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['choseLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</option>
                                    <?php } ?>
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
                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['threeMember']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                        <?php } ?>
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
<?php echo $_smarty_tpl->getSubTemplate ("../bs-alert-tips.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    var searchTradeInfo = <?php echo $_smarty_tpl->tpl_vars['searchTradeInfo']->value;?>
;
    var todayTradeInfo = <?php echo $_smarty_tpl->tpl_vars['todayTradeInfo']->value;?>
;
    var choseLink = <?php echo $_smarty_tpl->tpl_vars['choseLink']->value;?>
;
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


<?php }} ?>

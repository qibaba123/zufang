<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 14:20:58
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goodsratio/order-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20622585025e8c1bca8dc3f0-82061319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73eea9146982c438f76e6edef4fd21dfbae8cc24' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goodsratio/order-list.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20622585025e8c1bca8dc3f0-82061319',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tid' => 0,
    'title' => 0,
    'nickname' => 0,
    'start' => 0,
    'end' => 0,
    'status' => 0,
    'todayTradeInfo' => 0,
    'searchTradeInfo' => 0,
    'choseLink' => 0,
    'val' => 0,
    'list' => 0,
    'level' => 0,
    'trade_status' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8c1bca949418_17536714',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8c1bca949418_17536714')) {function content_5e8c1bca949418_17536714($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/shop-basic.css">
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
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent">
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/goodsratio/order" method="get">
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
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"  placeholder="商品名称">
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
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <tr>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
</td>
                                        <td>
                                            <a href="/wxapp/goodsratio/order?title=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
</a></td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['t_num'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>
</td>
                                        <td><a href="/wxapp/goodsratio/order?mid=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_m_id'];?>
">
                                            <?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>
</a></td>
                                        <td>
                                            <?php echo $_smarty_tpl->tpl_vars['val']->value['od_0f_deduct'];?>

                                        </td>
                                        <td><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_1f_id']])) {?>
                                            <a href="/wxapp/goodsratio/order?1f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['od_1f_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['od_1f_id']];?>
</a>
                                            <?php }?></td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['od_1f_deduct'];?>
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
<?php echo $_smarty_tpl->getSubTemplate ("../bs-alert-tips.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var searchTradeInfo = <?php echo $_smarty_tpl->tpl_vars['searchTradeInfo']->value;?>
;
    var todayTradeInfo = <?php echo $_smarty_tpl->tpl_vars['todayTradeInfo']->value;?>
;
    var choseLink = <?php echo $_smarty_tpl->tpl_vars['choseLink']->value;?>
;
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


<?php }} ?>

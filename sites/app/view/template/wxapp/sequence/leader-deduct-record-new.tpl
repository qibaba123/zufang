<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .info-title {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .info-title span {
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .money-span{
        margin-right: 10px;
        vertical-align: top;
        font-size: 16px;
    }
    .goods-title{
        min-width: 304px;
        display: inline-block;
        max-width: 604px;
        vertical-align: top;
    }
    .goods-price{
        min-width: 46px;
        display: inline-block;
        vertical-align: top;
    }
    td{
        background-color: #fff !important;
    }
    .table{
        color: #9a999e;
    }
</style>
<div class="page-header">
    <a href="#" data-target="#myModal" data-toggle="modal" class="btn btn-xs btn-success">导出订单数据</a>
</div>
<div class="redpack-receive-detail" style="margin:20px 20px 20px 0;">
    <div class="row">
        <div class="col-xs-12">
            <span class="money-span">总返佣：<{$info['total']}>（元）</span>
            <span class="money-span">可提现：<{$info['ktx']}>（元）</span>
            <span class="money-span">已提现：<{$info['ytx']}>（元）</span>
            <span class="money-span">审核中：<{$info['dsh']}>（元）</span>
        </div>
    </div>
</div>
<div class='panel panel-primary'>
    <div class='panel-body'>
        <form action="">
            <div style='display: flex;'>
                <input type="hidden" name="id" value='<{$smarty.get.id}>'>
                <input type="hidden" name="mid" value='<{$smarty.get.mid}>'>
                <input class='form-control' style="width: 300px;margin-right: 10px;" type="search" placeholder="订单号码" name='order_id' value='<{$smarty.get.order_id}>'>
                <button class='btn btn-sm btn-primary'>查询订单</button>
            </div>
        </form>
    </div>
</div>
<div id="mainContent">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>所购商品</th>
                            <th>订单金额</th>
                            <th>购买人</th>
                            <th>佣金</th>
                            <th>下单时间</th>
                            <th>核销日期</th>
                        </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><{$val['asd_tid']}></td>
                            <td>
                                <{foreach $val['goods'] as $key => $row}>
                                <div class="goods-box">
                                    <div style="float: left;margin: 2px 0;">
                                        <{if $key > 0}>
                                        <hr style="margin: 5px auto;width: 90%;color: #eee">
                                        <{/if}>
                                        <div class="goods-title" style="">
                                            <{$row['to_title']}><br>
                                            <{$row['to_gf_name']}>
                                        </div>
                                        <div class="goods-price" style="">
                                            <{$row['to_price']}>
                                            <{if $row['to_fd_status'] == 3}>
                                            <span style="color: red">（已退款）</span>
                                            <{/if}>
                                            <br>
                                            x<{$row['to_num']}>（件）
                                        </div>
                                    </div>

                                </div>
                                <{/foreach}>
                            </td>
                            <td>
                                <div>商品金额：￥<{$val['t_goods_fee']}></div>
                                <div>订单金额：￥<{$val['t_total_fee']}></div>
                                <{if $val['refund_money'] > 0}>
                                <div>退款金额：￥<{$val['refund_money']}></div>
                                <{/if}>
                                <div>配 送 费：￥<{$val['t_post_fee']}></div>
                            </td>
                            <td><{$val['t_buyer_nick']}></td>
                            <td>￥<{$val['asd_money']}></td>
                            <td><{date('Y/m/d H:i',$val['t_create_time'])}></td>
                            <td><{date('Y/m/d H:i',$val['asd_create_time'])}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
                <{$pageHtml}>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    导出记录
                </h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="/wxapp/sequence/excelLeaderDeduct" method="post">
                    <input type="hidden" id="leaderId" name="leaderId" value="<{$leaderId}>">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">下单起始时间：</label>
                    <div class="col-sm-8">
                        <input id="start" name="start" class="form-control" placeholder="请填写起始时间" style="height:auto!important" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" autocomplete="off" />
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">下单截止时间：</label>
                    <div class="col-sm-8">
                        <input id="end" name="end" class="form-control" placeholder="请填写截止时间" style="height:auto!important" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                    <div class="col-sm-3" style="text-align: left">
                        <input type="checkbox" name="mergeOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
                        <label for="goods-order" style="position: relative;top: 2px">同订单合并</label>
                    </div>
                </div>
                    <div style="margin: 0 auto;text-align: center">
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
    $(function () {
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
    });

    $('.confirm-deduct').on('click',function () {
        var id = $(this).data('id');
        var money = $(this).data('money');
        layer.confirm('确定结算吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/confirmDeduct',
                    'data'  : { id:id,money:money},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
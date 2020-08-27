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
</style>
<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

    });
</script>
<div  id="mainContent">
    <div class="redpack-receive-detail" style="margin:20px 0;">
        <h4 class="info-title">
            <span>团长营业详情</span>
            <a style='margin-left: 100px;' href="/wxapp/seqstatistics/leaderGoods?id=<{$smarty.get.id}>" class='btn btn-sm btn-info'>团长商品统计 >></a>
            <a href="/wxapp/seqstatistics/leaderOrder?id=<{$smarty.get.id}>" class='btn btn-sm btn-warning'>团长订单统计 >></a>
        </h4>
        <div class="row">
            <div class="col-xs-4">
                <p>订单总量：<{$info['tradeNum']}>（单）</p>
            </div>
            <div class="col-xs-4">
                <p>商品总量：<{$info['goodsNum']}>（件）</p>
            </div>
            <div class="col-xs-4">
                <p>营业额（包含配送费）：<{$info['goodsFee']}>（元）</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p>退款订单：<{$info['refundNum']}>（单）</p>
            </div>
            <div class="col-xs-4">
                <p>退款金额：<{$info['refund']}>（元）</p>
            </div>
            <div class="col-xs-4">
                <p>配送费：<{$info['postFee']}>（元）</p>
            </div>

        </div>
    </div>
    <div class="page-header search-box" style="display: none">
        <div class="col-sm-12">
            <form class="form-inline" action="/manage/redpack/qrcodeList">
                <input type="hidden" name="id" value="<{$id}>" />
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-addon">红包码</div>
                                <input type="text" class="form-control" name="command" value="<{$command}>" placeholder="请输入红包码">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-addon">状态</div>
                                <select name="status" id="" class="form-control">
                                    <option value="1" <{if $status == 1}>selected<{/if}>>已领取</option>
                                    <option value="0" <{if $status == 0}>selected<{/if}>>未领取</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="width: 400px">
                            <div class="input-group">
                                <div class="input-group-addon" >领取时间</div>
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
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>订单数</th>
                        <th>订单金额</th>
                        <th>配送费</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><{$val['date']}></td>
                            <td><{$val['num']}></td>
                            <td><{$val['money']}></td>
                            <td><{$val['postFee']}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
                <{$pageHtml}>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
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
</script>
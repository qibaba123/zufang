<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
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

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 33.33%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
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
<{if $showSecondLink == 1}>
<{include file="../common-second-menu.tpl"}>

<{else}>

<{/if}>
<div  id="mainContent">
    <div class="redpack-receive-detail" style="margin:20px 0;">
        <!-- 汇总信息 -->
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">总配送费<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                    <span class="unit">元</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已结算<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['verify']}></span>
                    <span class="unit">元</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">未结算<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['noverify']}></span>
                    <span class="unit">元</span>
                </div>
            </div>
        </div>

    </div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/plugin/shopPostFee">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-addon">状态</div>
                                <select name="status" id="" class="form-control">
                                    <option value="0">全部</option>
                                    <option value="2" <{if $status == 2}>selected<{/if}>>已结算</option>
                                    <option value="1" <{if $status == 1}>selected<{/if}>>未结算</option>
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
                        <th>订单号</th>
                        <th>跑腿订单号</th>
                        <th>所属店铺</th>
                        <th>总费用</th>
                        <th>状态</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><{date('Y-m-d H:i',$val['alsp_create_time'])}></td>
                            <td><{$val['alsp_other_tid']}></td>
                            <td><{$val['alsp_tid']}></td>
                            <td>
                                <{if $val['alsp_other_esid'] > 0}>
                                    <{$selectShop[$val['alsp_other_esid']]}>
                                <{else}>
                                    平台自营
                                <{/if}>
                            </td>
                            <td><{$val['alsp_rider_money']}></td>
                            <td>
                                <{if $val['alsp_status'] == 2}>
                                <span style="color: green">已结算</span>
                                <{else}>
                                未结算
                                <{/if}>
                            </td>
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
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script>
    $(function () {
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });

        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
    });

    $('.confirm-post').on('click',function () {
        var sid = $(this).data('sid');
        var esid = $(this).data('esid');
        layer.confirm('确定结算吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            if(sid){
                console.log(esid);
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/legwork/confirmPost',
                    'data'  : { sid:sid,esid:esid},
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
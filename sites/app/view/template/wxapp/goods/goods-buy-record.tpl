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
    }
    .goods-title{
        min-width: 404px;
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
        //console.log('商铺ID为：<{$sidddd}>');
    });
</script>
<div  id="mainContent">
    <div class="redpack-receive-detail" style="margin:20px 0;">
        <div class="row">
            <div class="col-xs-5">
                <span class="money-span">总销售量：<{$sumInfo['numSum']}>（件）</span>
            </div>
        </div>
    </div>
    <!--
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/sequence/leaderDeductRecord">
                <input type="hidden" name="id" value="<{$leaderId}>" />
                <input type="hidden" name="mid" value="<{$mid}>" />
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-addon">状态</div>
                                <select name="status" id="" class="form-control">
                                    <option value="1" <{if $status == 1}>selected<{/if}>>已结算</option>
                                    <option value="0" <{if $status == 0}>selected<{/if}>>未结算</option>
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
    -->
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>购买人</th>
                        <th>购买数量</th>
                        <th>订单号</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><{date('Y-m-d H:i',$val['to_create_time'])}></td>
                            <td><{$val['t_buyer_nick']}></td>
                            <td><{$val['to_num']}></td>
                            <td><{$val['t_tid']}></td>
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
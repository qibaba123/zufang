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
        <div class="row">
            <div class="col-xs-2">
                <input type="hidden" id="hid_money" value="<{$info['money']}>">
                <p>总佣金：<{$info['money']}>（元）</p>
            </div>
            <div>
                <button class="btn btn-sm btn-success confirm-deduct" data-id="<{$leaderId}>" data-money="<{$info['money']}>">结算佣金</button>
                <span style="color: red">结算佣金会将该团长所有未结算佣金标记为"已结算"，请确认所有佣金都已结清再进行此操作</span>
            </div>
        </div>
    </div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/sequence/leaderDeductRecord">
                <input type="hidden" name="id" value="<{$leaderId}>" />
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
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>订单号</th>
                        <th>佣金</th>
                        <th>状态</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><{date('Y-m-d H:i',$val['asd_create_time'])}></td>
                            <td><{$val['asd_tid']}></td>
                            <td><{$val['asd_money']}></td>
                            <td>
                                <{if $val['asd_status'] == 1}>
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
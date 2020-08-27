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
    <div class="alert alert-block alert-yellow " >
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        此处为绑定当前跑腿小程序的其他小程序商家列表
    </div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/legwork/shopList">
                <input type="hidden" name="shop_id" value="<{$shop_id}>">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group ">
                                <div class="input-group-addon">名称</div>
                                <input type="text" name="name" class="form-control">
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
                        <th>图标</th>
                        <th>名称</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <{if $val['aolc_es_id'] > 0}>
                            <td><img src="<{if $val['es_logo']}><{$val['es_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_200_200.png<{/if}>" alt="" style="width: 60px"></td>
                            <td><{$val['es_name']}></td>
                            <{else}>
                            <td><img src="<{if $val['ac_avatar']}><{$val['ac_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_200_200.png<{/if}>" alt="" style="width: 60px"></td>
                            <td><{$val['ac_name']}></td>
                            <{/if}>
                            <td>
                                <{if $val['aolc_open'] == 1}>
                                <span style="color: green">开启</span>
                                <{else}>
                                <span>关闭</span>
                                <{/if}>
                            </td>
                            <td>
                                <a href="/wxapp/legwork/shopPostFee?sid=<{$val['aolc_s_id']}>&esid=<{$val['aolc_es_id']}>">
                                    <{if $val['aolc_es_id'] > 0}>
                                    店铺配送费
                                    <{else}>
                                    商家配送费
                                    <{/if}>
                                </a>
                                <{if in_array($val['ac_type'],[4,6,8]) && $val['aolc_es_id'] == 0}>
                                <a href="/wxapp/legwork/shopList?shop_id=<{$val['aolc_s_id']}>">
                                     - 查看店铺
                                </a>
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

    $('.confirm-post').on('click',function () {
        var sid = $(this).data('sid');
        layer.confirm('确定结算吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/legwork/confirmPost',
                    'data'  : { sid:sid},
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
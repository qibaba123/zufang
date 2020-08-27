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
    .table tr th,.table tr td{
        text-align: center;
    }
</style>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<{include file="../common-second-menu.tpl"}>
<div id="content-con" style="padding-left: 130px;">
    <div class="page-header search-box">
        <div class="col-sm-12">
            <!-- 两字按钮 -->
            <form action="/wxapp/community/vipOrder" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group col-sm-3">
                            <div class="input-group">
                                <div class="input-group-addon">订单编号</div>
                                <input type="text" class="form-control" name="tid" value="<{$tid}>"  placeholder="订单编号">
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="input-group ">
                                <div class="input-group-addon">订单状态</div>
                                <select class="form-control" id="status" name="status">
                                    <option value="0" >全部</option>
                                    <option value="1" <{if 1 eq $status}> selected<{/if}>>待支付</option>
                                    <option value="2" <{if 2 eq $status}> selected<{/if}>>已支付</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-3">
                            <div class="input-group">
                                <div class="input-group-addon">购买人</div>
                                <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="购买人微信昵称">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm verify-btn">搜索</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover table-button">
                    <thead>
                    <tr>
                        <th class="hidden-480">订单编号</th>
                        <th class="hidden-480">会员卡</th>
                        <th>购买者</th>
                        <th>金额</th>
                        <th>订单状态</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            支付时间
                        </th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            购买时间
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><{$val['acmo_tid']}></td>
                            <td><{$val['acmo_title']}></td>
                            <td><{$val['m_nickname']}></td>
                            <td><{$val['acmo_amount']}></td>
                            <td>
                                <{if $val['acmo_status'] eq 1}>
                                <span class="label label-sm label-success">已付款</span>
                                <{else}>
                                <span class="label label-sm label-danger">未付款</span>
                                <{/if}>
                            </td>

                            <td><{if $val['acmo_pay_time']}><{date("Y-m-d H:i",$val['acmo_pay_time'])}><{/if}></td>
                            <td><{date("Y-m-d H:i",$val['acmo_create_time'])}></td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
                <{$paginator}>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
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



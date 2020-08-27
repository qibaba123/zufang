<link rel="stylesheet" href="/public/manage/groupControl/css/style.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .modal-dialog{
        width: 400px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    #sample-table-1{
        border: none;
    }

    .search-btn button{
        display: inline-block;
        margin-left: 5px;
    }


</style>
<{include file="../common-second-menu-new.tpl"}>
<div style="margin-left: 130px">
    <div class="page-header search-box" style="margin-bottom: 20px;margin-top: 0;">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/giftcard/cardBuyList" method="get">
                <div class="col-xs-10 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">礼品卡名称</div>
                                <input type="text" name="name" id="name" class="form-control" value="<{$name}>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">卡号</div>
                                <input type="text" name="number" id="number" class="form-control" value="<{$number}>">
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="input-group">
                                <div class="input-group-addon">购买时间起</div>
                                <input class='form-control' id='start' type="text" name="start" autocomplete="off" readonly="true" value='<{$start}>'>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="input-group">
                                <div class="input-group-addon">购买时间止</div>
                                <input class='form-control' id='end' type="text" name="end"  autocomplete="off" readonly="true" value='<{$end}>'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                    <button type="button" class="btn btn-primary btn-sm btx-excel">导出</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" id="content-con">
                <table id="sample-table-1" class="table table-hover table-button">
                    <thead>
                    <tr>
                        <th>卡号</th>
                        <th>礼品卡名称</th>
                        <th>购买人</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            购买时间
                        </th>
                        <th>
                            状态
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $key => $val}>
                        <tr id="tr_<{$val['agcb_id']}>" <{if ($key % 2 == 1)}>class="info"<{else}><{/if}>>
                            <td><{$val['agcb_number']}></td>
                            <td><{$val['agcb_name']}></td>
                            <td><{$val['agct_m_nickname']}></td>
                            <td><{date('Y-m-d H:i',$val['agcb_create_time'])}></td>
                            <td>
                                <{if $val['agcb_status'] == 1}>
                                <span class="font-color-audit">未激活</span>
                                <{elseif $val['agcb_status'] == 2}>
                                <span class="font-color-pass">已激活</span>
                                <{elseif $val['agcb_status'] == 3}>
                                <span class="font-color-refuse">已用完</span>
                                <{/if}>
                            </td>
                        </tr>
                        <{/foreach}>
                        <tr><td colspan="5"><{$paginator}></td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
    laydate.render({
        elem: '#start'
    });
    laydate.render({
        elem: '#end'
    });

    $('.btx-excel').click(function () {
        let name = $('#name').val();
        let number = $('#number').val();
        let start = $('#start').val();
        let end = $('#end').val();

        if(!start || !end){
            layer.msg('请选择完整的购买时间');
            return false;
        }
        window.location.href='/wxapp/giftcard/cardBuyExcel?name='+name+'&number='+number+'&start='+start+'&end='+end;
    });



</script>



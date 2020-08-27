<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<style>
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
        white-space: nowrap;
        min-width: 90px;
    }
    .table tbody tr td { text-align: center; }
    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
    .balance-line-1 .balance-info{
        width: 16.66% !important;
    }
    .balance-line-2 .balance-info{
        width: 33.33% !important;
    }

    .coupon-admend{
        display:inline-block!important;
        width:13px;
        height:13px;
        cursor:pointer;
        visibility:hidden;
    }
    .tr-content:hover .coupon-admend{
        visibility:visible;
    }
    .datepicker{
        z-index: 1060 !important;
    }
    .ui-table-order .time-cell{
        width: 120px !important;
    }

    .modal-dialog{
        width: 700px;
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

    .ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
    .ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }

</style>


<{include file="../common-second-menu-new.tpl"}>

<div id="content-con">
    <div  id="mainContent" >
<div><{$info}></div>

<a href="javascript:;" class="btn btn-green btn-xs add-cou" data-id="0"><i class="icon-plus bigger-80"></i> 新增</a>
<!-- <a href="javascript:;" class="btn btn-info btn-xs">启用</a>
<a href="javascript:;" class="btn btn-danger btn-xs">禁用</a> -->
<!-- 搜索框 -->
<div class="page-header search-box">
    <div class="col-sm-12">
        <form action="/wxapp/coupon/couponType/" method="get" class="form-inline">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">分类名称</div>
                            <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="分类名称">
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

<!-- 列表 -->
<div class="row">
    <div class="col-xs-12">
        <div class="fixed-table-box" style="margin-bottom: 30px;">
            <!--fixed-table-header-->
            <div class="fixed-table-header">
                <table class="table table-hover table-avatar">
                    <thead>
                    <tr>
                        <!-- <th class="center">
                            <label>
                                <input type="checkbox" class="ace"  id="checkBoxt" onclick="select_all_by_name('crcid','checkBoxt')" />
                                <span class="lbl"></span>
                            </label>
                        </th> -->
                        <th>分类名称</th>
                        <th>类型</th>
                        <th>权重排序</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <!-- </table>
                 </div>
                 <div class="fixed-table-body" style="overflow: hidden;max-height: none">
                     <table id="sample-table-1" class="table table-hover table-avatar"> -->
                    <tbody>
                    <{foreach $list as $val}>
                        <tr class="tr-content">
                            <!-- <td class="center">
                                <label>
                                    <input type="checkbox" class="ace" name="crcid" value="<{$val['crc_id']}>"/>
                                    <span class="lbl"></span>
                                </label>
                            </td> -->
                            <td><{$val['cct_name']}></td>
                            <td><{$type[$val['cct_type']]}></td>
                            <td><{$val['cct_sort']}></td>
                            <td style="color:#ccc;">
                                <p>
                                    <a href="javascript:void(0);" class="add-cou"
                                       data-id="<{$val['cct_id']}>" data-type="<{$val['cct_type']}>" data-sort="<{$val['cct_sort']}>" data-name="<{$val['cct_name']}>" >编辑</a> -
                                    <a href="javascript:void(0);" onclick="delType('<{$val['cct_id']}>')" style="color:#f00;">删除</a>

                                     - <a href="/wxapp/coupon/rechargeCouponList/Stype/<{$val['cct_type']}>">赠送优惠券</a>
                                </p>
                            </td>
                        </tr>
                        <{/foreach}>
                    <tr><td colspan="4" style="text-align:right"><{$paginator}></td></tr>
                    </tbody>
                </table>
            </div>

        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<!--添加-->
<div id="coupon-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加分类</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hidden_id" value="">

                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >分类名称</label>
                    <div class="col-sm-10">
                        <input type="text" id="name" class="form-control" value="" placeholder="请输入分类名称">
                    </div>
                </div>

                <div class="space"></div>
                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >类型</label>
                    <div class="col-sm-10">
                        <select id="type" class="form-control" >
                            <{foreach $type as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="space"></div>
                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >权重排序</label>
                    <div class="col-sm-10">
                        <input type="number" id="sort" class="form-control" value="" placeholder="数值越大，排序越前">
                    </div>
                </div>

            </div>
            <div style="text-align: center;padding: 10px 0">
                <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                <button type="button" class="btn btn-primary save-cou" >确定</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>


    $('.add-cou').on('click',function(){
        var id = $(this).data('id');
        $('#hidden_id').val(id);
        if(id ==0) {
            // 添加
            $('#type').val(1);
            $('#sort').val('');
            $('#name').val('');
        } else {
            // 编辑
            $('#type').val($(this).data('type'));
            $('#sort').val($(this).data('sort'));
            $('#name').val($(this).data('name'));
        }

        $('#coupon-modal').modal('show');
    });

    // 保存
    $('.save-cou').on('click', function() {
        var id   = $('#hidden_id').val();
        var type = $('#type').val();
        var sort = $('#sort').val();
        var name = $('#name').val();

        if(!name) {
            layer.msg('请输入分类名称');
            return ;
        }


        var data = {
            'id'   : id,
            'type' : type,
            'sort' : sort,
            'name' : name,
        };
        var url = '/wxapp/coupon/saveCouponType';
        sendAjax(url, data, true);
    });



    function delType(id) {
        layer.confirm('您确定要删除该分类吗？',
            {btn: ['删除', '取消'], title: '删除'},
            function() {
                var data = { 'id': id };
                var url = '/wxapp/coupon/delCouponType';
                sendAjax(url, data, true);
            }
        );
    }


    function sendAjax(url,data,reload){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : url,
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em,
                        {time: 1500},
                    function() {
                        if(ret.ec == 200 && reload){
                            window.location.reload();
                        }
                    }
                );
            }
        });
    }

</script>


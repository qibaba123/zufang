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

    .modal-body .form-group .col-sm-10{
        padding-bottom: 10px;
    }

    .ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
    .ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }

</style>

<{include file="../common-second-menu-new.tpl"}>

<div id="content-con">
    <div  id="mainContent" >
        <div><{$info}></div>
<a href="javascript:;" class="btn btn-green btn-xs add-cou"><i class="icon-plus bigger-80"></i> 新增</a>
<!-- <a href="javascript:;" class="btn btn-info btn-xs">启用</a>
<a href="javascript:;" class="btn btn-danger btn-xs">禁用</a> -->
<!-- 搜索框 -->
<div class="page-header search-box">
    <div class="col-sm-12">
        <form action="/wxapp/coupon/rechargeCouponList/Stype/<{$Stype}>" method="get" class="form-inline">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">优惠券名称</div>
                            <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="优惠券名称">
                        </div>
                    </div>

                   <!-- <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">类型</div>
                            <select name="Stype" id="" class="form-control">
                                <option value="0">全部</option>
                                <{foreach $type as $key => $value}>
                                <option value="<{$key}>" <{if $key == $Stype}>selected<{/if}> ><{$value}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div> -->
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
                        <th>类型</th>
                        <th>限制条件</th>
                        <th>赠送优惠券</th>
                        <th>赠送数量</th>
                        <th>是否启用</th>
                        <th>创建时间</th>
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
                            <td><{$type[$val['crc_type']]}></td>
                            <td>
                                <{if $val['crc_type'] ==1}>
                                 -
                                <{elseif $val['crc_type'] ==2}>
                                会员卡 <{$rv[$val['rv_id']]}>
                                <{elseif $val['crc_type'] ==3}>
                                消费金额满<{$val['crc_limit_money']}> 元
                                <{/if}>
                            </td>
                            <td><{$val['cl_name']}></td>
                            <td><{$val['crc_num']}></td>
                            <td>
                                <{if $val['cl_end_time'] > time() }>
                                    <{if $val['crc_status'] eq 1}>
                                     <span style="color: green;">启用</span>
                                    <{else}>
                                     <span style="color: red;">禁用</span>
                                    <{/if}>
                                <{else}>
                                <span style="color:grey;">过期</span>
                                <{/if}>
                            </td>
                            <td>
                                <{if $val['crc_create_time']}><{date('Y-m-d', $val['crc_create_time'])}><{else}> - <{/if}>
                            </td>

                            <td style="color:#ccc;">
                                <p>
                                    <{if $val['cl_end_time'] > time() }>
                                    <{if $val['crc_status'] eq 1}>
                                    <a href="javascript:void(0);" onclick="changeStatus(<{$val['crc_id']}>, 2)"> 禁用</a> -
                                    <{else}>
                                    <a href="javascript:void(0);" onclick="changeStatus(<{$val['crc_id']}>, 1)"> 启用</a> -
                                    <{/if}>

                                    <a href="javascript:void(0);" class="edit-num" data-id="<{$val['crc_id']}>" data-num="<{$val['crc_num']}>">修改数量</a> -
                                    <{/if}>
                                    <a href="javascript:void(0);" onclick="delRC('<{$val['crc_id']}>')" style="color:#f00;">删除</a>
                                </p>
                            </td>
                        </tr>
                        <{/foreach}>
                    <tr><td colspan="7" style="text-align:right"><{$paginator}></td></tr>
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
                <h4 class="modal-title">添加优惠券</h4>
            </div>
            <div class="modal-body">

                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >类型</label>
                    <div class="col-sm-10">
                        <select id="type"  class="form-control" onchange="showDiv()">
                            <{foreach $type as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div id="rid_div" class="form-group" style="height: 12px; display:none;">
                    <label class="col-sm-2 control-label" >充值卡</label>
                    <div class="col-sm-10">
                        <select id="rid"  class="form-control">
                            <{foreach $rv as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div id="money_div" class="form-group" style="height: 12px; display:none;">
                    <label class="col-sm-2 control-label" >消费金额</label>
                    <div class="col-sm-10">
                        <input type="number" id="money" class="form-control" value="">
                    </div>
                </div>

                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >优惠券</label>
                    <div class="col-sm-10">
                        <select id="coupon"  class="form-control">

                        </select>
                    </div>
                </div>

                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >数量</label>
                    <div class="col-sm-10">
                        <input type="number" id="num" class="form-control" value="">
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

<!--修改数量-->
<div id="coupon-edit-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改数量</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hidden_crcid" value="">

                <div class="space"></div>
                <div class="form-group" style="height: 12px">
                    <label class="col-sm-2 control-label" >数量</label>
                    <div class="col-sm-10">
                        <input type="number" id="cnum" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div style="text-align: center;padding: 10px 0">
                <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                <button type="button" class="btn btn-primary save-num" >确定</button>
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

    var COUPON = [];
    $(function() {
        // 初始化
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/coupon/getCouponSelect',
            'data'  : { },
            'dataType' : 'json',
            'success'   : function(ret){
                // console.log(ret);
                if(ret.ec == 200){
                    var data = ret.list;
                    COUPON = data;
                    var html = '';
                    for(var i=0 ; i < data.length ; i++){
                        html += '<option value="'+data[i].cl_id+'">'+data[i].cl_name+'</option>';
                    }
                    $('#coupon').html(html);
                }
            }
        });

        showDiv();
    });

    // 添加
    $('.add-cou').on('click',function(){
        if(Array.prototype.isPrototypeOf(COUPON) && COUPON.length === 0) {
            layer.confirm('未获取到优惠券或优惠券均已过期，请先添加可用优惠券。', 
                {title: '提示', btn: ['前往','取消']},
                function () {
                    window.location.href="/wxapp/coupon/cash";
                },function () {
                    
                }
            );
        } else {
            $('#type').val(<{$Stype}>);
            showDiv();
            $('#coupon-modal').modal('show');    
        }
    });
    $('.save-cou').on('click', function() {
        var rid = $('#rid').val();
        var cid = $('#coupon').val();
        var num = $('#num').val();
        var type = $('#type').val();
        var money = $('#money').val();
        console.log();
        if(type ==1) {
            var data = {
                'type' : type,
                'cid'  : cid,
                'num'  : num,
            }
        }
        if(type ==2) {
            if(!rid) {
                layer.msg('请选择充值卡');
                return;
            }

            var data = {
                'type' : type,
                'rid' : rid,
                'cid' : cid,
                'num' : num,
            };
        } else if(type ==3) {
            if(!money || money <=0) {
                layer.msg('请填写金额');
                return;
            }

            var data = {
                'type' : type,
                'money' : money,
                'cid' : cid,
                'num' : num,
            };
        }


        if(!cid) {
            layer.msg('未选择优惠券');
            return ;
        }
        if(num <=0) {
            layer.msg('请填写数量');
            return ;
        }


        var url = '/wxapp/coupon/saveRC';
        console.log(data);
        sendAjax(url,data,true);
    });

    // 修改数量
    $('.edit-num').on('click', function() {
        $('#hidden_crcid').val($(this).data('id'));
        $('#cnum').val($(this).data('num'));
        $('#coupon-edit-modal').modal('show');
    });
    $('.save-num').on('click', function() {
        var id = $('#hidden_crcid').val();
        var num = $('#cnum').val();

        if(num <=0) {
            layer.msg('请填写数量');
            return ;
        }

        var data = {
            'id'  : id,
            'num' : num,
        };
        console.log(data);
        var url = '/wxapp/coupon/saveRCnum';
        sendAjax(url, data, true);
    });

    // 启用/禁用
    function changeStatus(id, status) {
        var data = {
            'id' : id,
            'status' : status,
        }
        var url = '/wxapp/coupon/changeStatusRC';
        sendAjax(url, data, true);
    }

    // 删除
    function delRC(id) {
        layer.confirm('您确定要删除该优惠券？',
            {btn: ['删除', '取消'], title: '删除'},
            function() {
                var data = { id : id };
                var url = '/wxapp/coupon/delRc';
                sendAjax(url, data, true);
            }
        );
    }


    function sendAjax(url,data,reload){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        console.log(url);
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

    function showDiv() {
        var type = $('#type').val();
        if(type ==1) {
            $('#money_div').hide();
            $('#rid_div').hide();
        } else if(type ==2) {
            $('#rid_div').show();
            $('#money_div').hide();
        } else if(type ==3){
            $('#money_div').show();
            $('#rid_div').hide();
        }
    }

</script>

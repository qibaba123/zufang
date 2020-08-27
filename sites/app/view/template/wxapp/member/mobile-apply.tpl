<meta http-equiv="Content-Type" content="text/html; charset=utf8mb4" />
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    /*
    switch开关
     */
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    #tip-div{
        width: 60%;
        margin-top: 10px;
    }
    #tip-textarea{
        display: inline-block;
        width: 50%;
    }
    #tip-span{
        width: 10%;
        display: inline-block;
        text-align: center;
    }
</style>
<div style="margin-bottom: 20px">
<span >
        <span class="switch-title">启用用户验证：</span>
        <label id="choose-onoff" class="choose-onoff">
            <input class="ace ace-switch ace-switch-5" id="applyOpen"  data-type="open" onchange="changeOpen()" type="checkbox" <{if $mobileCfg && $mobileCfg['mmc_open'] eq 1}>checked<{/if}>>
            <span class="lbl"></span>
        </label>
        <span style="color: red">此功能启用时，用户必须填写手机号提交申请并通过审核后才能使用小程序</span>
    </span>
</div>
<div>
    <span style="">
        <span class="switch-title">启用自动审核：</span>
        <label id="choose-auto-onoff" class="choose-auto-onoff">
            <input class="ace ace-switch ace-switch-5" id="applyAutoVerify"  data-type="open" onchange="changeAutoVerify()" type="checkbox" <{if $mobileCfg && $mobileCfg['mmc_auto_verify'] eq 1}>checked<{/if}>>
            <span class="lbl"></span>
        </label>
        <span style="color: red">此功能启用时，用户填写的申请将自动通过</span>
    </span>
</div>
<div id="tip-div">
    <span id="tip-span">提示信息：</span>
    <textarea name="" id="tip-textarea" cols="20" rows="3" class="form-control"><{if $mobileCfg && $mobileCfg['mmc_tip']}><{$mobileCfg['mmc_tip']}><{/if}></textarea>
    <a href="#" id="save-tip" class="btn btn-sm btn-success" onclick="saveTip()">保存</a>
</div>
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/mobileapply/index" method="get">
            <div class="col-xs-11 form-group-box" style="width: auto !important;">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="微信昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">会员编号</div>
                            <input type="text" class="form-control" name="content" value="<{$content}>"  placeholder="会员编号">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">手机号</div>
                            <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="手机号码">
                        </div>
                    </div>
                    <div class="form-group" style="width:580px;">
                        <div class="input-group" style="width:100%;">
                            <div class="start-endtime">
                                <em style="width:70px;text-align:center">申请时间：</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                                <em style="padding:0 3px;">到</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="<{$status}>">
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 10%;right: 2%;">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>会员编号</th>
                            <th>姓名</th>
                            <th>电话</th>
                            <th>申请时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['mma_id']}>">
                                <td><img src="<{$val['m_avatar']}>" width="50"></td>
                                <td style="max-width: 120px"><{$val['m_nickname']}></td>
                                <td><{$val['m_show_id']}></td>
                                <td><{$val['mma_name']}></td>
                                <td><{$val['mma_mobile']}></td>
                                <td><{if $val['mma_update_time'] > 0}><{date('Y-m-d H:i',$val['mma_update_time'])}><{/if}></td>
                                <td>
                                    <{if $val['mma_status'] == 2}>
                                    <span style="color: green">通过</span>
                                    <{elseif $val['mma_status'] == 3}>
                                    <span style="color: red">未通过</span>
                                    <{else}>
                                    <span>申请中</span>
                                    <{/if}>
                                </td>
                                <td>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['mma_id']}>" data-reamrk="<{$val['mma_handle_remark']}>">审核</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="8"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝/封禁</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="remark" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>

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

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#remark').val($(this).data('remark'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var remark = $('#remark').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            remark : remark,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobileapply/handleMemberMobile',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    function changeOpen() {
        var open   = $('#applyOpen:checked').val();
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mobileapply/mobileApplyOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
            }
        });
    }

    function changeAutoVerify() {
        var open   = $('#applyAutoVerify:checked').val();
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mobileapply/mobileApplyAutoVerify',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
            }
        });
    }
    function saveTip() {
        var tip   = $('#tip-textarea').val();
        var data = {
            tip:tip
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mobileapply/saveTip',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em)
            }
        });
    }
</script>

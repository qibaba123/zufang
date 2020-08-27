<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
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
    a.new-window { color: blue; }
    .payment-block-wrap { font-family: '黑体'; }
    .payment-block { border: 1px solid #e5e5e5; margin-bottom: 20px; }
    .payment-block .payment-block-header { position: relative; padding: 10px; border-bottom: 1px solid #e5e5e5; margin-bottom: -1px; background: #F8F8F8; cursor: pointer; }
    .payment-block .payment-block-header h3 { font-size: 16px; font-weight: bold; line-height: 30px; margin: 0; }
    .payment-block .payment-block-header h3:after { content: ' '; border: 5px solid #999; width: 0; height: 0; display: inline-block; position: absolute; margin-left: 6px; margin-top: 12px; border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent; border-top-width: 7px; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; transition: all 0.2s; }
    .payment-block-wrap.open .payment-block-header h3:after { -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); -webkit-transform-origin: 50% 25%; -moz-transform-origin: 50% 25%; -ms-transform-origin: 50% 25%; transform-origin: 50% 25%; }
    .payment-block .payment-block-header .choose-onoff { position: absolute; top: 10px; right: 10px; }
    .payment-block .payment-block-body { display: none; padding: 25px; }
    .payment-block-body .form-group { overflow: hidden; }
    .payment-block-body .form-group label { font-weight: bold; }
    .payment-block-body .form-group p { color: #999; margin: 0; margin-top: 5px; }
    .payment-block .payment-block-body h4 { color: #333; margin-bottom: 20px; font-size: 14px; }
    .form-horizontal { margin-bottom: 30px; width: auto; }
    .form-horizontal .control-group { margin-bottom: 10px; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .controls-row:after, .dropdown-menu>li>a, .form-actions:after, .form-horizontal .control-group:after, .modal-footer:after, .nav-pills:after, .nav-tabs:after, .navbar-form:after, .navbar-inner:after, .pager:after, .thumbnails:after { clear: both; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .form-horizontal .control-label { float: left; width: 160px; padding-top: 5px; text-align: right; }
    .form-horizontal .control-label { width: 120px; font-size: 14px; line-height: 18px; }
    .page-payment .form-label-text-left .control-label { text-align: left; width: 100px; }
    .controls { font-size: 14px; }
    .form-horizontal .controls { margin-left: 180px; }
    .form-horizontal .controls { margin-left: 130px; word-break: break-all; }
    .page-payment .form-label-text-left .controls { margin-left: 100px; }
    .form-horizontal .control-action { padding-top: 5px; display: inline-block; font-size: 14px; line-height: 18px; }
    .ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
    .ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }
    .pay-test-status { font-size: 12px; margin-top: 10px; width: 400px; }
    .payment-block .payment-block-body p { line-height: 24px; }
    .payment-block .payment-block-body dl { line-height: 24px; }
    .payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
    .payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
    .payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
    .payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
    .showhide-secreskey { position: absolute; top: 4px; right: 18px; height: 26px; line-height: 26px; border-radius: 3px; background-color: #0095e5; color: #fff; z-index: 1; padding: 0 7px; font-size: 12px; cursor: pointer; }
    .showhide-secreskey:hover { opacity: 0.9; }

    .timeDian{
        margin-left: 10% !important;
    }
    .title-col-2{
        width: 135px !important;
        padding-left: 20px !important;
    }
    .save-button-box{
        margin-left: 20.6666% !important;
    }
    .time{
        display: inline-block;
    }
    /* 保存按钮样式 */
    .alert.save-btn-box{
        border: 1px solid #F5F5AA;
        background-color: #FFFFCC;
        text-align: center;
        position: fixed;
        bottom: 0;
        left: 50%;
        margin-left: -453px;
        width: 870px;
        margin-bottom: 0;
        z-index: 200;
    }
    #container object{
        position:relative!important;
        height: 300px!important;
    }
    .input-tip{
        color: #999;
        padding-left: 5px;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
</style>
<{include file="../article-kind-editor.tpl"}>
<div class="payment-style" ng-app="chApp" ng-controller="chCtrl">
    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
        <input type="hidden" value="<{if $row['esm_id']}><{$row['esm_id']}><{else}>0<{/if}>" id="hid_id">
       <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
            <label for="range" style="font-size: 14px">姓名<font color="red">*</font></label>
        </div>
        <div class="form-group col-sm-10">
            <input type="text" class="form-control" id="esm_nickname" name="esm_nickname" placeholder="请填写管理员姓名" value="<{if $row}><{$row['esm_nickname']}><{/if}>" style="width:15%;display: inline-block">
            <span></span>
            <span class="input-tip"></span>
        </div>
       </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">手机号<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="esm_mobile" name="esm_mobile" placeholder="管理员手机号" value="<{if $row}><{$row['esm_mobile']}><{/if}>" <{if $row['esm_id']}>disabled="disabled"<{/if}> style="width:15%;display: inline-block">
                <span></span>
                <span class="input-tip">将作为管理员登录账号和初始密码</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">分佣比例</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="esm_percent" name="esm_percent" placeholder="请填写分佣比例" value="<{if $row}><{$row['esm_percent']}><{/if}>" style="width:15%;display: inline-block">
                <span>%</span>
                <span class="input-tip">请填写0-100之间的整数</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">上级</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="hidden" id="select-manager-id" value="">
                <{if $parent['esm_id']}>
                <span id="select-manager-name" style="display: inline-block;font-weight: bold;min-width: 195px;color: blue"><{$parent['esm_nickname']}></span>
                <{else}>
                <span id="select-manager-name" style="display: inline-block;min-width: 195px;">当前没有上级</span>
                <span class="input-tip"><button class="btn btn-xs btn-success get-managers" data-mk="show" data-manager="<{if $row['esm_id']}><{$row['esm_id']}><{else}>0<{/if}>">选择上级</button></span>
                <{/if}>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">备注</label>
            </div>
            <div class="form-group col-sm-10">
                <textarea name="esm_note" id="esm_note" cols="30" rows="10" class="form-control" style="width: 50%"><{$row['esm_note']}></textarea>
            </div>
        </div>

        <div style="height: 100px">

        </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save" onclick="saveCfg()"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
    <!--
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
-->
    <{include file="../fetch-manager-modal.tpl"}>
<script>

    function saveCfg(){
        var id   = $('#hid_id').val();
        var name = $('#esm_nickname').val();
        var mobile = $('#esm_mobile').val();
        var percent = $('#esm_percent').val();
        var note = $('#esm_note').val();
        var fid  = $('#select-manager-id').val();
        var loading = layer.load(2);
        var data={
            name:name,
            mobile:mobile,
            percent:percent,
            note:note,
            id:id,
            fid:fid
        };
        
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/managerSave',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
                if(response.ec == 200){
                    window.location.reload();
                }

            }
        });
    }

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
    function selectTime(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    }

</script>

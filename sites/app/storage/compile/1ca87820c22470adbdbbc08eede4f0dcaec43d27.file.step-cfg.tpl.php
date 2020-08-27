<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:25:14
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/step/step-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6019409225e4e6c9a2b5479-81142671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ca87820c22470adbdbbc08eede4f0dcaec43d27' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/step/step-cfg.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6019409225e4e6c9a2b5479-81142671',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6c9a2e2e67_47768943',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6c9a2e2e67_47768943')) {function content_5e4e6c9a2e2e67_47768943($_smarty_tpl) {?>
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
<?php echo $_smarty_tpl->getSubTemplate ("../article-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="payment-style" ng-app="chApp" ng-controller="chCtrl">
    <!--
    <div class='row'>
        <div class='form-group col-sm-2' style="width: 135px;text-align: left;padding-left: 20px">
            <label for="range" style="font-size: 14px">接单人完成订单<font color="red">*</font></label>
        </div>
        <div class='form-group col-sm-10'>
            <label id="choose-onoff" class="choose-onoff" style="left: 110px">
                <input name="rider_finish" class="ace ace-switch ace-switch-5" id="rider_finish" type="checkbox"
                <?php if ($_smarty_tpl->tpl_vars['cfg']->value['aps_rider_finish']==1) {?>
                checked
                <?php }?>
                >
                <span class="lbl"></span>
            </label>
            <span></span>
            <span class="input-tip">启用时，接单人不需要核销码即可完成订单</span>
        </div>
    </div>
    -->
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['cfg']->value['aps_id'];?>
" id="hid_id">
        <!--
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">启用步数兑换积分</label>
            </div>
            <div class="form-group col-sm-10">
                    <span style="">
                        <label id="choose-onoff" class="choose-onoff">
                            <input name="sms_start" class="ace ace-switch ace-switch-5" id="step_open"  type="checkbox" <?php if ($_smarty_tpl->tpl_vars['cfg']->value&&$_smarty_tpl->tpl_vars['cfg']->value['aps_step_open']) {?> checked<?php }?>>
                        <span class="lbl"></span>
                        </label>
                        <span class="input-tip"></span>
                    </span>
            </div>
        </div>
           -->
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">兑换比例</label>
            </div>
            <div class="form-group col-sm-10">
                每<input type="number" class="form-control" id="step" name="step" placeholder="" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['aps_step'];?>
<?php }?>" style="width:10%;display: inline-block">步兑换1积分
                <span></span>
                <span class="input-tip">不满1分时不计算，如兑换10.5分记为10分</span>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">每次最多兑换积分</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="step_total" name="step_total" placeholder="自动取消时间" value="<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['aps_step_total'];?>
<?php }?>" style="width:10%;display: inline-block">
                <span>分</span>
                <span class="input-tip"></span>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;padding-right: 25px;">
                <label for="" style="font-size: 14px">兑换规则</label>
            </div>
            <div class="form-group col-sm-10">
            <textarea class="form-control" style="width:100%;height:250px;visibility:hidden;" id = "step_rule" name="step_rule" placeholder="请填写跑腿服务规则"  rows="15" style=" text-align: left; resize:vertical;" >
            <?php echo $_smarty_tpl->tpl_vars['cfg']->value['aps_step_rule'];?>

            </textarea>
                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                <input type="hidden" name="ke_textarea_name" value="step_rule" />
            </div>
        </div>

        <div style="height: 100px">

        </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save" onclick="saveCfg()"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/laydate/laydate.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
    <!--
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
-->
<script>

    //执行一个laydate实例
    laydate.render({
        elem: '#open_time', //指定元素
        type:'time'
    });
     //执行一个laydate实例
    laydate.render({
        elem: '#close_time', //指定元素
        type:'time'
    });

    function saveCfg(){
        var stepRule = $('#step_rule').val();
        var step = $('#step').val();
        var stepTotal = $('#step_total').val();
        //let stepOpen = typeof($('#step_open:checked').val())=='undefined'?0:1;
        let id = $('#hid_id').val();
        // let riderFinish=typeof($('#rider_finish:checked').val())=='undefined'?0:1;
        // let open_time = $('#open_time').val();
        // let close_time = $('#close_time').val();
        var loading = layer.load(2);

        var data={
            'stepRule' : stepRule,
            'step' : step,
            'stepTotal' : stepTotal,
            'stepOpen' : 1,
            'id' : id
        };
//        
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/step/saveCfg',
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
    $(function(){

    })

</script>
<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 16:48:16
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/redbag/activity-edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16043484665e8c3e501bf526-49456269%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f735df3a772a2d42c7d887402855922f673e821' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/redbag/activity-edit.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16043484665e8c3e501bf526-49456269',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8c3e502195e1_57974391',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8c3e502195e1_57974391')) {function content_5e8c3e502195e1_57974391($_smarty_tpl) {?>
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
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="alert alert-block alert-yellow "  style="margin-left: 150px">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    1、该活动奖励为所有参与活动用户共同瓜分的金额。2、每人获得的金额数随机。3、用户获得的红包金额目前只能用于平台消费
</div>
<div class="payment-style" ng-app="chApp" ng-controller="chCtrl" style="margin-left: 150px">
    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
        <input type="hidden" id="hid_id" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['ara_id']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_id'];?>
<?php } else { ?>0<?php }?>">
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">启用活动<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="status" id="recommend1" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ara_status']==1) {?>checked<?php }?>>
                        <label for="recommend1">是</label>
                    </span>
                    <span>
                        <input type="radio" name="status" id="recommend2" value="2"  <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ara_status']==1)) {?>checked<?php }?>>
                        <label for="recommend2">否</label>
                    </span>
                </div>
            </div>
        </div>
       <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
            <label for="range" style="font-size: 14px">活动名称<font color="red">*</font></label>
        </div>
        <div class="form-group col-sm-10">
            <input type="text" class="form-control" id="activityName" name="activityName" placeholder="请填写活动名称" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_name'];?>
<?php }?>" style="width:15%;display: inline-block">
        </div>
       </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">活动奖励<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="money" name="money" placeholder="请填写活动奖励" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_money'];?>
<?php }?>" style="width:15%;display: inline-block" <?php if ($_smarty_tpl->tpl_vars['row']->value['ara_id']) {?> disabled="disabled" <?php }?>>
                <span>元</span>
                <span class="input-tip"></span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">组队所需人数<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="num" name="num" placeholder="请填写组队人数" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_num'];?>
<?php }?>" style="width:15%;display: inline-block" <?php if ($_smarty_tpl->tpl_vars['row']->value['ara_id']) {?> disabled="disabled" <?php }?>>
                <span>人</span>
                <span class="input-tip">请填写2-100的数字，不宜太多</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">每人每日组队次数</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="limit" name="limit" placeholder="请填写每人每日组队次数" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_limit'];?>
<?php }?>" style="width:15%;display: inline-block" >
                <span></span>
                <span class="input-tip">不填或填0为无限制</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">每人总组队次数</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="limit_total" name="limit_total" placeholder="请填写每人总组队次数" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_limit_total'];?>
<?php }?>" style="width:15%;display: inline-block" >
                <span></span>
                <span class="input-tip">不填或填0为无限制</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">总组队次数</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="limit_group" name="limit_group" placeholder="请填写总组队次数" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_limit_group'];?>
<?php }?>" style="width:15%;display: inline-block" >
                <span></span>
                <span class="input-tip">不填或填0为无限制</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">组队时间<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="hour" name="hour" placeholder="请填写组队时间" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_hour'];?>
<?php }?>" style="width:15%;display: inline-block" <?php if ($_smarty_tpl->tpl_vars['row']->value['ara_id']) {?> disabled="disabled" <?php }?>>
                <span>小时</span>
                <span class="input-tip">从发起活动开始，超过此时间将组队失败</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">转发标题<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="text" class="form-control" id="share_title" name="share_title" placeholder="分享标题" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_share_title'];?>
<?php }?>" style="width:60%;display: inline-block">
                <span></span>
                <span class="input-tip"></span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">转发封面<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <div class="form-group col-sm-10" style="padding-left: 0">
                    <img onclick="toUpload(this)"   data-limit="1" data-width="500" data-height="400" data-dom-id="upload-shareImg" id="upload-shareImg"  src="<?php if ($_smarty_tpl->tpl_vars['row']->value['ara_share_img']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_share_img'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_555_480.png<?php }?>"  height="100%" style="display:inline-block;height: 200px;margin: 0">
                    <input type="hidden" id="shareImg"  class="avatar-field bg-img" name="shareImg" ng-value="shareImg" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['ara_share_img']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_share_img'];?>
<?php }?>"/>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;padding-right: 25px;">
            <label for="" style="font-size: 14px">活动规则</label>
        </div>
        <div class="form-group col-sm-10">
            <textarea class="form-control" style="height:250px;text-align: left; resize:vertical;width: 60%" id="rule" name="rule" placeholder="请填写活动规则"  rows="15"><?php echo $_smarty_tpl->tpl_vars['row']->value['ara_rule'];?>
</textarea>
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
<script>

    function saveCfg(){
        var id = $('#hid_id').val();
        var name = $('#activityName').val();
        var num = $('#num').val();
        var limit_total = $('#limit_total').val();
        var limit_group = $('#limit_group').val();
        var limit = $('#limit').val();
        var money = $('#money').val();
        var rule = $('#rule').val();
        var hour = $('#hour').val();
        var share_title = $('#share_title').val();
        var shareImg = $('#shareImg').val();
        var status = $('input[name=status]:checked').val();
        $('.btn-save').attr('disabled','disabled');
        var loading = layer.load(2);
        var data={
            id:id,
            name:name,
            num:num,
            limit:limit,
            limit_total:limit_total,
            limit_group:limit_group,
            money:money,
            rule:rule,
            hour:hour,
            share_title:share_title,
            shareImg:shareImg,
            status:status
        };
        
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/redbag/activitySave',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
                if(response.ec == 200){
                    window.location.href="/wxapp/redbag/activityList";
                }else{
                    $('.btn-save').removeAttr('disabled');
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

    /**
     * 图片结果处理
     * @param allSrc
     */
    /*
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-shareImg'){
                    $('#category-cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }
    */
</script>
    <?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

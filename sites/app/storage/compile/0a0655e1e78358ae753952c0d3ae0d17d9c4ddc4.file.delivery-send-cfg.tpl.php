<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:35:45
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/delivery/delivery-send-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6626692525e1be5914df9a3-10317469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a0655e1e78358ae753952c0d3ae0d17d9c4ddc4' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/delivery/delivery-send-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6626692525e1be5914df9a3-10317469',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sendCfg' => 0,
    'appletCfg' => 0,
    'dataValue' => 0,
    'k' => 0,
    'v' => 0,
    'showSendFee' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be591584e75_49719614',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be591584e75_49719614')) {function content_5e1be591584e75_49719614($_smarty_tpl) {?>
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

<?php echo $_smarty_tpl->getSubTemplate ("../article-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="payment-style" ng-app="chApp" ng-controller="chCtrl" style="margin-left: 130px">
    <div class="page-header" style="min-height: 50px">

            <span style="">
                    商家配送：
                    <label id="choose-onoff" class="choose-onoff">
                        <input name="sms_start" class="ace ace-switch ace-switch-5" id="sendOpen" data-type="open" onchange="changeOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value&&$_smarty_tpl->tpl_vars['sendCfg']->value['acs_send']) {?> checked<?php }?>>
                    <span class="lbl"></span>
                    </label>
            </span>
        <div class="watermrk-show">
            <span class="label-name">排序：</span>
            <div class="watermark-box">
                <div class="input-group">
                    <input type="number" style="width: 60px" maxlength="2" class="form-control" id="delivery-sort" value="<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_send_sort'];?>
" data-type="send" oninput="if(value.length>2)value=value.slice(0,2)">
                    <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-delivery-sort">确认</span>
                            <span>数值越大越靠前</span>
                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
        <div class="row">
                    <form action="">
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==13) {?>
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label title-col-2">是否当日配送<font color="red">*</font></label>
                            <div class="col-sm-10">
                                <div class="radio-box">
                                    <span>
                                        <input type="radio" name="g_is_global" id="global1" value="1" <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value&&$_smarty_tpl->tpl_vars['sendCfg']->value['acs_today_send']==1) {?>checked<?php }?>>
                                        <label for="global1">是</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="g_is_global" id="global2" value="0"  <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value&&$_smarty_tpl->tpl_vars['sendCfg']->value['acs_today_send']==0) {?>checked<?php }?>>
                                        <label for="global2">否（将在次日配送）</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=1&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=21&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=24) {?>
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label title-col-2" >每天配送时段<font color="red">*</font></label>
                            <label style="margin-left: 35px">开始时间</label><label style="margin-left: 13.7%">结束时间</label>
                            <label style="color: #428BCA;cursor: pointer;margin-left: 50px;" onclick="addTimeHtml(this)">增加</label>
                            <?php if ($_smarty_tpl->tpl_vars['dataValue']->value) {?>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataValue']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                            <div class="timeDian" style="margin-left: 17%;margin-top: 10px">
                                <input type="text" class="time form-control" id="start<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value[0];?>
" onchange="" style="width: 10%;margin-right:4%">--<input class="time form-control" type="text" id="end<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value[1];?>
" style="width: 10%;margin-left:4%" onchange="">
                                <label style="color: #428BCA;cursor: pointer;margin-left: 8px;" onclick="delTimeHtml(this)">删除</label>
                            </div>
                            <?php } ?>
                            <?php } else { ?>
                            <div class="timeDian" style="margin-left: 17%;margin-top: 10px">
                                <input type="text" class="time form-control" id="start0" data-id="0" onchange="" style="width: 10%;margin-right:4%">--<input class="time form-control" data-id="0" type="text" id="end0" style="width: 10%;margin-left:4%" onchange="">
                                <label style="color: #428BCA;cursor: pointer;margin-left: 8px;" onclick="delTimeHtml(this)">删除</label>
                            </div>
                            <?php }?>
                        </div>
                        <?php }?>
                        <!--<div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10 col-sm-offset-2 save-button-box">
                                <button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveTimeCfg()"> 保 存 </button>
                            </div>
                        </div>-->
                    </form>
                </div>
        <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
            <label for="price" style="font-size: 14px">店铺地址</label>
        </div>

        <div class="form-group col-sm-8">
            <input type="text" class="form-control" id="addr" name="addr" placeholder="请填写详细地址" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_address'];?>
<?php }?>">
        </div>

        <div class="form-group col-sm-2 text-left">
            <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_lng'];?>
<?php }?>">
            <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_lat'];?>
<?php }?>">
            <label class="btn btn-default btn-sm btn-map-search"> 搜索地图 </label>
        </div>
    </div>
        <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
            <label for="price" style="font-size: 14px">地图定位</label>
        </div>
        <div class="form-group col-sm-9" style="height: 300px">
            <div id="container"></div>
        </div>
        </div>
       <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
            <label for="range" style="font-size: 14px">最大配送范围<font color="red">*</font></label>
        </div>
        <div class="form-group col-sm-10">
            <input type="number" class="form-control" id="range" name="range" placeholder="请填写配送范围" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_send_range'];?>
<?php }?>" style="width:15%;display: inline-block">
            <span>千米</span>
            <span class="input-tip">超出最大配送范围的订单将无法使用商家配送</span>
        </div>
       </div>
        <?php if ($_smarty_tpl->tpl_vars['showSendFee']->value==1) {?>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">订单满多少起送</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="satisfySend" name="satisfySend" placeholder="请填写订单满多少元起送" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_satisfy_send'];?>
<?php }?>" style="width:15%;display: inline-block">
                <span>元起送</span>
                <span class="input-tip">订单金额必须达到多少钱才配送，否则将无法下单</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">基本配送费用<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="baseLong" name="baseLong" placeholder="请填写基本配送范围" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_base_long'];?>
<?php }?>" style="width:15%;display: inline-block">
                <span>千米内</span>
                <input type="number" class="form-control" id="basePrice" name="basePrice" placeholder="请填写基本配送费用" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_base_price'];?>
<?php }?>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">基本配送范围内按基本配送费用收费</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">超出部分费用<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <span>每超出</span>
                <input type="number" class="form-control" id="plusLong" name="plusLong" placeholder="请填写超出范围" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_plus_long'];?>
<?php }?>" style="width:15%;display: inline-block">
                <span>千米,需另支付</span>
                <input type="number" class="form-control" id="plusPrice" name="plusPrice" placeholder="请填写额外支付" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_plus_price'];?>
<?php }?>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">若用户超出基本配送范围,超出部分需按距离额外支付费用</span>
            </div>
        </div>
        <?php }?>
        <div class="row">
        <div class="form-group col-sm-2 text-right" style="width: 135px;padding-right: 25px;">
            <label for="" style="font-size: 14px">配送范围详情<font color="red">*</font></label>
        </div>
        <div class="form-group col-sm-10">
            <textarea class="form-control" style="width:100%;height:500px;visibility:hidden;" id = "sendDetail" name="aptitude" placeholder="请填写配送范围信息"  rows="15" style=" text-align: left; resize:vertical;" >
            <?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_send_scope'];?>

            </textarea>
            <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
            <input type="hidden" name="ke_textarea_name" value="aptitude" />
        </div>
    </div>
    </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save" onclick="saveTimeCfg()"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script>
    $(function(){
        console.log('work');
        //首次进入默认选择位置
        var address = '<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_address'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_address'];?>
' : '公司地址';
        var lng = '<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_lng'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_lng'];?>
' : '113.72052';
        var lat = '<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_lat'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_shop_lat'];?>
' : '34.77485';
        //高德地图引入
        var marker, geocoder,map = new AMap.Map('container',{
            zoom            : 10,
            keyboardEnable  : true,
            resizeEnable    : true,
            topWhenClick    : true,
            center          : [lng,lat]
        });
        //添加地图控件
        AMap.plugin(['AMap.ToolBar'],function(){
            var toolBar = new AMap.ToolBar();
            map.addControl(toolBar);
            $('#container object[data="about:blank"]').style.position='inherit';
        });

        //地图添加点击事件
        map.on('click', function(e) {
            $('#lng').val(e.lnglat.getLng());
            $('#lat').val(e.lnglat.getLat());
            //添加地图服务
            AMap.service('AMap.Geocoder',function(){
                //实例化Geocoder
                geocoder = new AMap.Geocoder({
                    city: "010"//城市，默认：“全国”
                });
                //TODO: 使用geocoder 对象完成相关功能
                //逆地理编码
                var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
                geocoder.getAddress(lnglatXY, function(status, result) {
                    console.log(result);
                    if (status === 'complete' && result.info === 'OK') {
                        addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);
                        $('#addr').val(result.regeocode.formattedAddress);
                    }else{
                        //获取地址失败
                    }
                });
            });
        });
        //搜索地图位置
        $('.btn-map-search').on('click',function(){
            var address     = $('#addr').val();
            if(address){
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : '全国', //城市，默认：“全国”
                        'radius' : 1000   //范围，默认：500
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //地理编码,返回地理编码结果
                    geocoder.getLocation(address, function(status, result) {
                        console.log(result);
                        if (status === 'complete' && result.info === 'OK') {
                            var loc_lng_lat = result.geocodes[0].location;
                            $('#lng').val(loc_lng_lat.getLng());
                            $('#lat').val(loc_lng_lat.getLat());
                            addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),result.geocodes[0].formattedAddress);
                        }else{
                            layer.msg('您输入的地址无法找到，请确认后再次输入');
                        }
                    });
                });

            }else{
                layer.msg('请填写门店地址');
            }
        });


        if(address && lng && lat){
            addMarker(lng,lat,address);
        }
        /**
         * 添加一个标签和一个结构体
         * @param lng
         * @param lat
         * @param address
         */
        function addMarker(lng,lat,address) {
            if (marker) {
                marker.setMap();
            }
            marker = new AMap.Marker({
                icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                position: [lng,lat]
            });
            marker.setMap(map);

            infoWindow = new AMap.InfoWindow({
                offset  : new AMap.Pixel(0,-30),
                content : '您选中的位置：'+address
            });
            infoWindow.open(map, [lng,lat]);
        }
    });

    function changePayType(data){
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/cake/changeSend',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.alert(response.em, {icon: 6})
                window.location.reload();
            }
        });
    }
    /*隐藏显示配置区域*/
    $(".js-wxpay-header-region").on('click', function(event) {
        var that = $(this).next('.js-wxpay-body-region');
        var thatWrap = $(this).parents('.payment-block-wrap');
        var isDisplay = that.css("display");
        console.log(isDisplay=='block');
        if(isDisplay=='block'){
            that.stop().slideUp();
            thatWrap.removeClass('open');
        }else{
            that.stop().slideDown();
            thatWrap.addClass('open');
        }
    });
    function addTimeHtml(obj){
        var endId=$('.timeDian').last().children().eq(0).data('id');
        console.log(endId);
        var nextId=++endId;
        var timeDiv='<div class="timeDian" style="margin-left: 17%;margin-top: 10px">'+'<input class="time form-control" data-id="'+nextId+'" onclick="selectTime()" type="text" id="'+'start'+nextId+'"style="width: 10%;margin-right:4%">--<input type="text" class="time form-control" data-id="'+nextId+'"  onclick="selectTime()" id="'+'end'+nextId+'" style="width: 10%;margin-left:4%">'+'<label style="color: #428BCA;cursor: pointer;margin-left:1%" onclick="delTimeHtml(this)">删除</label></div>';
        $(obj).parent().append(timeDiv);
    }
    function delTimeHtml(obj){
        $(obj).parent().remove();
    }
    function saveTimeCfg(){
        var radioValue=$(":radio:checked").val();
        var sendScope = $('#sendDetail').val();
        var address   = $('#addr').val();
        var sendRange = $('#range').val();
        var baseLong  = $('#baseLong').val();
        var basePrice  = $('#basePrice').val();
        var plusLong  = $('#plusLong').val();
        var plusPrice  = $('#plusPrice').val();
        var satisfySend  = $('#satisfySend').val();
        var lng = $('#lng').val();
        var lat = $('#lat').val();
        var sort = $('#delivery-sort').val();
        var loading = layer.load(2);
        console.log(radioValue);
        var dataTime=new Array();
        var n=0;
        $('.timeDian').each(function(){
            dataTime[n]=$(this).children().eq(0).data('id');
            n++;
        });
        var dataValue=new Array();
        var m=0;
        $.each(dataTime,function(index,value){
            dataValue[m]=$('#start'+value).val()+'-'+$('#end'+value).val();
            m++
        });
        console.log(dataValue);
        var data={
            'dataValue'   :dataValue,
            'radioValue'  :radioValue,
            'sendDetails' :sendScope,
            'address'     : address,
            'lng'         : lng,
            'lat'         : lat,
            'sendRange'   : sendRange,
            'baseLong'    : baseLong,
            'basePrice'   : basePrice,
            'plusLong'    : plusLong,
            'plusPrice'   : plusPrice,
            'satisfySend' : satisfySend,
            'sort'        : sort
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSendTwo',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
                window.location.reload();
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

    function changeOpen() {
        var open   = $('#sendOpen:checked').val();
        console.log(open);
        var data = {
            value:open,
            type : 'send'
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSend',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }
    $('#save-delivery-sort').on('click',function () {
        var value = $('#delivery-sort').val();
        var type = $('#delivery-sort').data('type');
        var data = {
            value:value,
            type : type
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSort',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });
</script>
<?php }} ?>

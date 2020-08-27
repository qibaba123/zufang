<?php /* Smarty version Smarty-3.1.17, created on 2020-04-05 18:02:32
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/legwork/other-legwork-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6877057455e89acb8729562-28765381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87f31deb988a104a40724596793c33316c1cdb03' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/legwork/other-legwork-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6877057455e89acb8729562-28765381',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'showSecondLink' => 0,
    'sendCfg' => 0,
    'bindName' => 0,
    'section' => 0,
    'item' => 0,
    'tplList' => 0,
    'val' => 0,
    'row' => 0,
    'curr_shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e89acb879cf66_79727239',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e89acb879cf66_79727239')) {function content_5e89acb879cf66_79727239($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/colorPicker/spectrum.css">
<link rel="stylesheet" href="/public/manage/css/sms.css" />
<link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">
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

    .table.table-avatar tbody>tr>td { line-height: 48px; }
    .radio-box { margin-left: 0; }
    .form-horizontal .control-label { font-weight: bold; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "开启\a0\a0\a0\a0\a0\a0\a0\a0\a0禁止"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #D15B47; border: 1px solid #CC4E38; }
    .right-kg { width: 100%; border: 1px solid #ccc; border-radius: 0 4px 4px 0; padding: 3px 10px; }
    .tab-pane .input-group { width: 100%; }
    .tab-pane .input-group .input-group-addon:first-child { width: 180px; text-align: right; }

    /*短信通知设置*/
    .message-temp { margin: 0 auto; }
    .messtype-title { font-size: 15px; line-height: 40px; font-weight: bold; }
    .seller-mess { margin-bottom: 10px; }
    .seller-mess li, .buyer-mess li { width: 30%; display: inline-block; max-width: 250px; margin-bottom: 5px; margin-right: 15px; }
    .mess-temp { border: 1px solid #e8e8e8; box-shadow: 2px 2px 5px #ddd; border-radius: 3px; width: 100%; background-color: #fbfbfb; padding-bottom: 6px;}
    .mess-temp h4 { margin:0;border-bottom: 1px solid #e8e8e8; line-height: 35px; padding: 0 10px; font-size: 15px; background-color: #f6f6f6; font-family: "Microsoft Yahei"; }
    .mess-temp p { margin: 0; padding: 0 10px; line-height: 22px; font-size: 14px; color: #888; height: 66px; box-sizing: border-box; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 3; margin-top: 5px;}
    .state-box { margin-top: 5px; }
    .state-box label { font-size: 14px; line-height: 35px; font-weight: normal; float: left; }
    .state-box .switch-box { height: 35px; margin-left: 50px; box-sizing: border-box; padding: 4px 0 3px; }
    .tips{
        color:#666
    }

    .section-item{
        margin: 6px 0;
    }
    .section-item input{
        display: inline-block;
        width: 100px;
        margin: 0 5px;
    }


</style>
<?php if ($_smarty_tpl->tpl_vars['showSecondLink']->value==1) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <div class="row" style="margin-left: 130px">
    <?php } else { ?>
        <div class="row" >
<?php }?>

    <div class="col-sm-12" >
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#cfg">
                        <i class="green icon-cog bigger-110"></i>
                        配送设置
                    </a>
                </li>
                <li>

                    <a data-toggle="tab" href="#tplmsg">
                        模板消息
                    </a>
                </li>
            </ul>
            <div class="tab-content form-horizontal">
                <!--客服配置-->
                <div id="cfg" class="tab-pane active">
                    <div class="message-temp">
                        <div class="buyer-mess">
                            <ul>
                                <li style="width: 100%;max-width: inherit">
                                    <div class="state-box" style="height: 60px;">
                                        <span style="float: left;position: relative;top: 10px;">跑腿配送：</span>
                                        <label id="choose-onoff" class="choose-onoff">
                                            <input name="sms_start" class="ace ace-switch ace-switch-5" id="sendOpen" data-type="open" onchange="changeLegworkOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value&&$_smarty_tpl->tpl_vars['sendCfg']->value['aolc_open']) {?> checked<?php }?>>
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                    <div class="state-box">
                                        <span>绑定appid：</span>
                                        <input type="text" id="appid" style="display: inline-block;width: 300px;" class="form-control" name="appid" value="<?php if ($_smarty_tpl->tpl_vars['sendCfg']->value['aolc_appid']) {?><?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['aolc_appid'];?>
<?php }?>">
                                        <span class="tips">请填写绑定跑腿小程序的appid</span>
                                    </div>
                                    <div class="state-box">
                                        <span>当前绑定：</span>
                                        <span style="color:blue;"><?php echo $_smarty_tpl->tpl_vars['bindName']->value;?>
</span>
                                    </div>
                                    <div class="state-box" style="margin-top: 10px">
                                        <span style="font-size: 16px;font-weight: bold">补贴运费：</span>
                                        <button class="btn btn-xs btn-success add-section" onclick="addSection()" style="margin-left: 10px">新增</button>
                                        <div style="color: red">
                                            补贴运费为商家补贴给用户的费用，不影响骑手配送费获得。例如，配送费10元，补贴2元，用户支付就是8元，骑手仍然是10元
                                        </div>
                                        <div class="section-box">
                                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['section']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                            <div class="section-item">运费<input type="number" class="form-control section-min" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['min'];?>
">元至<input type="number" class="form-control section-max" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['max'];?>
">元，补贴<input type="number" class="form-control section-value" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['value'];?>
">元<button class="btn btn-xs btn-danger remove-section" onclick="removeSection(this)" style="margin-left: 20px">删除</button>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--提交操作-->
                    <div style="padding: 10px 0;margin-top: 10px;">
                        <button class="btn btn-md btn-blue save-legwork-cfg">&nbsp;保 存&nbsp;</button>
                    </div>
                </div>
                <div id="tplmsg" class="tab-pane">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="/wxapp/tplmsg/tpl" class="btn btn-md btn-green" target="_blank" style="margin-bottom: 10px">管理模板消息</a>
                            <div class="table-responsive">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <tr style="">
                                        <td>骑手接单通知</td>
                                        <td>
                                            <select name="aws_legwork_take_mid"  class="form-control">
                                                <option value="0">请选择消息模板</option>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tplList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_take_mid']==$_smarty_tpl->tpl_vars['val']->value['awt_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input  class="ace ace-switch ace-switch-5" name="aws_legwork_take_open"  type="checkbox" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_take_open']==1) {?>checked<?php }?>>
                                            <span class="lbl"></span>
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <td>骑手已取货通知</td>
                                        <td>
                                            <select name="aws_legwork_get_mid"  class="form-control">
                                                <option value="0">请选择消息模板</option>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tplList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_get_mid']==$_smarty_tpl->tpl_vars['val']->value['awt_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input  class="ace ace-switch ace-switch-5" name="aws_legwork_get_open"  type="checkbox" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_get_open']==1) {?>checked<?php }?>>
                                            <span class="lbl"></span>
                                        </td>
                                    </tr>
                                    <tr style="">
                                        <td>订单确认通知</td>
                                        <td>
                                            <select name="aws_legwork_finish_mid"  class="form-control">
                                                <option value="0">请选择消息模板</option>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tplList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_finish_mid']==$_smarty_tpl->tpl_vars['val']->value['awt_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input  class="ace ace-switch ace-switch-5" name="aws_legwork_finish_open"  type="checkbox" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_finish_open']==1) {?>checked<?php }?>>
                                            <span class="lbl"></span>
                                        </td>
                                    </tr>
                                    <!--
                                    <tr style="">
                                        <td>订单取消通知</td>
                                        <td>
                                            <select name="aws_legwork_cancel_mid"  class="form-control">
                                                <option value="0">请选择消息模板</option>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tplList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_cancel_mid']==$_smarty_tpl->tpl_vars['val']->value['awt_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input  class="ace ace-switch ace-switch-5" name="aws_legwork_cancel_open"  type="checkbox" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['aws_legwork_cancel_open']==1) {?>checked<?php }?>>
                                            <span class="lbl"></span>
                                        </td>
                                    </tr>
                                    -->
                                </table>
                                <div style="padding: 10px 0;margin-top: 10px;">
                                    <button class="btn btn-md btn-blue save-tplmsg">&nbsp;保 存&nbsp;</button>
                                </div>
                            </div><!-- /.table-responsive -->
                        </div><!-- /span -->
                    </div><!-- /row -->


                    <div id="layer-dinggou" style="display:none;">
                        <div class="zent-dialog-body clearfix">
                            <div class="pay-info">
                                <dl>
                                    <dt>应用服务名称：</dt>
                                    <dd>短信充值</dd>
                                </dl>
                                <dl>
                                    <dt>生效时间：</dt>
                                    <dd>支付成功后，短信立即到账</dd>
                                </dl>
                                <dl>
                                    <dt>订购店铺：</dt>
                                    <dd><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_name'];?>
</dd>
                                </dl>
                                <dl>
                                    <dt>应用服务价格：</dt>
                                    <dd><span class="money"></span></dd>
                                </dl>
                                <div class="pay-info-line"></div>
                                <dl>
                                    <dt>支付方式：</dt>
                                    <dd>店铺余额(￥<?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_recharge'];?>
)支付</dd>
                                    <dd>
                                        <div class="not-sufficient-funds">
                                            <span class="red">提醒：</span>若当前店铺余额不足，请先充值，成功后再进行订购
                                        </div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>合计：</dt>
                                    <dd><span class="total-money"></span></dd>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dd>
                                        <a href="javascript:;" target="_blank" onclick="payCharge(this, event)" class="zent-btn zent-btn-danger zent-btn-large">充值</a>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <?php echo $_smarty_tpl->getSubTemplate ("../bs-alert-tips.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                </div>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
    } );
    $('.btn-start').on('click',function(){
        var data = {
            'id'	: $(this).data('id')
        };
        indexTplStart(data);
    });

    // 保存短信通知设置
    $('.save-sms-cfg').on('click',function(){
        console.log(data);
        var url = '/wxapp/plugin/saveSmsSetting';
        plumAjax(url,data,0)
    });
</script>
<script type="text/javascript">

    $(function(){

        /*支付方式tab栏切换*/
        $(".pay-way-nav").click(function(event) {
            currSwitch++;
            var that    = this;
            changePay(that);
        });
    });
    function changePay(obj) {
        obj = obj ? obj : $('.pay-way-nav').first();
        $(obj).addClass('active').siblings().removeClass('active');
        var index = $(obj).index();
        $(".online-pay-content").eq(index).stop().show();
        $(".online-pay-content").eq(index).siblings('.online-pay-content').stop().hide();
        if (currSwitch < 2) {
            qrcode(index);
        }
    }
    function hadPay(obj, event) {
        event.preventDefault();
        location.reload();
    }
    //获取扫码
    function qrcode(index) {
        layer.load(2, {time: 1000});
        money       = $('#update_watermark').val();
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/plugin/wxAlipayChargeQrcodeEle?channel='+type[index]+'&money='+money;
        console.log(url);
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

        img.attr('src', url);
    }
    //隐藏
    function stopShow(ele){
        $('.nowbuy-con').stop().hide();
        $('#update-watermark').stop().show();
    }




    function cancelEleOrder(e) {
        var tid = $(e).data('tid');
        $('#cancel-id').val(tid);
        $('#cancelModal').modal('show');
    }

    $('#cancel-order').click(function () {
        var tid = $('#cancel-id').val();
        var code = $('#cancel-code').val();
        var data = {
            'tid'   : tid,
            'code'  : code
        };
        $.ajax({
            type  : 'post',
            url   : '/wxapp/plugin/cancelEleOrder',
            data  : data,
            dataType  : 'json',
            success   : function(ret){
                if(ret.ec == 200){
                    window.location.reload();
                }
                layer.msg(ret.em);
            }
        });
    })

    function complainEleOrder(e) {
        var tid = $(e).data('tid');
        $('#complain-id').val(tid);
        $('#complainModal').modal('show');


    }

    $('#complain-order').click(function () {
        var tid = $('#complain-id').val();
        var code = $('#complain-code').val();
        var data = {
            'tid'   : tid,
            'code'  : code
        };
        $.ajax({
            type  : 'post',
            url   : '/wxapp/plugin/complainEleOrder',
            data  : data,
            dataType  : 'json',
            success   : function(ret){
                if(ret.ec == 200){
                    window.location.reload();
                }
                layer.msg(ret.em);
            }
        });
    })

    function changeLegworkOpen() {
        var open   = $('#sendOpen:checked').val();
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/plugin/changeLegworkOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                console.log(ret.em);
            }
        });
    }

    function delEleOrder(e) {
        var id = $(e).data('id');
        if(id){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/plugin/delEleOrder',
                'data'  : {'id': id},
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                    layer.msg(ret.em);
                }
            });
        }
    }
    $('.save-legwork-cfg').on('click',function () {
        var appid = $('#appid').val();
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'appid':appid
        };
        var sectionArr = [];
        var sectionRow = '';
        $('.section-item').each(function(){
            sectionRow = {
                'min': $(this).find('.section-min').val(),
                'max': $(this).find('.section-max').val(),
                'value': $(this).find('.section-value').val()
            };
            sectionArr.push(sectionRow);
        });
        data.sectionArr = sectionArr;
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/plugin/saveLegworkCfg',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }

            }
        });
    });

    function removeSection(e) {
        $(e).parent().remove();
    }

    function addSection() {
        var section_html = getSectionHtml();
        $('.section-box').append(section_html);
    }


    function getSectionHtml() {
        var section_html = "<div class='section-item' style=' margin: 6px 0;'>运费<input type='number' class='form-control section-min' value='' style='margin: 0 5px;'>元至<input type='number' class='form-control section-max' value='' style='margin: 0 5px;'>元，补贴<input type='number' class='form-control section-value' value='' style='margin: 0 5px;'>元<button class='btn btn-xs btn-danger remove-section' onclick='removeSection(this)' style='margin-left: 20px'>删除</button></div>";
        return section_html;
    }

    $('.save-tplmsg').on('click',function(){
        var index = layer.load(1, {
            shade: [0.1,'#fff']
        },{time:10*1000});
        var data = {
            'legwork_take_open': $('input[name=aws_legwork_take_open]').is(':checked')?1:0,
            'legwork_take_mid': $('select[name=aws_legwork_take_mid]').val(),
            'legwork_get_open': $('input[name=aws_legwork_get_open]').is(':checked')?1:0,
            'legwork_get_mid': $('select[name=aws_legwork_get_mid]').val(),
//            'legwork_cancel_open': $('input[name=aws_legwork_cancel_open]').is(':checked')?1:0,
//            'legwork_cancel_mid': $('select[name=aws_legwork_cancel_mid]').val(),
            'legwork_finish_open': $('input[name=aws_legwork_finish_open]').is(':checked')?1:0,
            'legwork_finish_mid': $('select[name=aws_legwork_finish_mid]').val(),
        }
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplmsg/saveOtherLegworkSetup',
            'data'  : data,
            'dataType'  : 'json',
            success : function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
            }
        })
    });


</script><?php }} ?>

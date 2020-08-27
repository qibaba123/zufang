<?php /* Smarty version Smarty-3.1.17, created on 2020-04-22 10:23:37
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/delivery/trade-setting.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8077119315e86b22874f989-23960635%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf80b0738fa14243d5aeaafc247d3bb17c2d4e51' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/delivery/trade-setting.tpl',
      1 => 1587437152,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8077119315e86b22874f989-23960635',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86b2287b9640_31881912',
  'variables' => 
  array (
    'curr_shop' => 0,
    'appletCfg' => 0,
    'orderComment' => 0,
    'ac_type' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86b2287b9640_31881912')) {function content_5e86b2287b9640_31881912($_smarty_tpl) {?><style>
    /*
    .page-content{
        margin-left: 140px;
    }*/
    .password-redpack .info-title{
        padding:10px 0;
        width: 100%;
    }
    .password-redpack .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .code{
        float: left;
    }
    .line-display{
        display: inline-block;
        padding: 4px;
    }
    .item-wrap{
        margin-left: 10px;
    }
    .form-control{
        width: 90px;
    }
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
</style>
<!--
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

-->
<div class="password-redpack">

    <h4 class="info-title"><span>待付款订单取消时间设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>拍下未付款订单</span>
            <span class="line-display"><input type="number" id="close_trade" value="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_close_trade']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_close_trade'];?>
<?php } else { ?>60<?php }?>" class="form-control"></span>
            <span>分钟内未付款，自动取消订单</span>
        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
    <h4 class="info-title"><span style="width: 100%">是否开启自动确认收货</span></h4>
    <div class="code">
        <div class="item-wrap">
           <span class='tg-list-item'>
               <input class='tgl tgl-light' id='auto_finish' type='checkbox' <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_auto_finish']) {?>checked<?php }?>>
               <label class='tgl-btn' for='auto_finish'></label>
           </span>
        </div>
    </div>
    <?php }?>
    <h4 class="info-title"><span style="width: 100%">自动确认收货时间设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
            <span>付款后</span>
            <?php } else { ?>
            <span>发货后</span>
            <?php }?>
            <span class="line-display"><input type="number" id="finish_trade" value="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_finish_trade']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_finish_trade'];?>
<?php } else { ?>7<?php }?>" class="form-control"></span>
            <span>天，自动确认收货</span>
            <div style="color:red">
                注：该处修改时需注意，原来的订单还是按照修改前设置的时间自动确认，修改后新下的订单会按照新设置的时间自动确认收货。
            </div>
        </div>
    </div>
    <h4 class="info-title"><span style="width: 100%">确认收货展示退货设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>确认收货后</span>
            <span class="line-display"><input type="number" id="return_time" value="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_return_time']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_return_time'];?>
<?php } else { ?>0<?php }?>" class="form-control"></span>
            <span>天，无法退货</span>
        </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
    <h4 class="info-title"><span style="width: 100%">订单返现设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>订单返现比例</span>
            <span class="line-display"><input type="number" id="return_ratio" value="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_order_return_ratio']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_order_return_ratio'];?>
<?php }?>" class="form-control"></span>
            <span>%</span>
        </div>
        <div style="color: red">提示：订单完成后将按实际付款金额比例返现至用户余额，0表示不返现，与分销返现互不影响。</div>
    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
    <h4 class="info-title"><span style="width: 100%">订单提示设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>首页订单提示</span>
            <label id="choose-onoff" class="choose-onoff">
                <input class="ace ace-switch ace-switch-5" id="s_order_tip" data-type="open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_order_tip']) {?>checked<?php }?> >
                <span class="lbl"></span>
            </label>
        </div>
        <div style="color: red"></div>
    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['orderComment']->value) {?>
    <h4 class="info-title"><span style="width: 100%;margin-top: 20px">评价订单设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>允许评价订单</span>
            <label id="choose-onoff" class="choose-onoff">
                <input class="ace ace-switch ace-switch-5" id="s_order_comment" data-type="open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_order_comment']) {?>checked<?php }?> >
                <span class="lbl"></span>
            </label>
        </div>
        <div style="color: red"></div>
    </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
    <h4 class="info-title"><span style="width: 100%">自动退款时间设置</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>付款后</span>
            <span class="line-display"><input type="number" id="auto_refund" value="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_auto_refund']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_auto_refund'];?>
<?php } else { ?>0<?php }?>" class="form-control"></span>
            <span>分钟内, 若用户发起退款, 将自动退款(订单将在此后开始打印)</span>
        </div>
    </div>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==4) {?>
    <h4 class="info-title"><span style="width: 100%">自动接单</span></h4>
    <div class="code">
        <div class="item-wrap">
           <span class='tg-list-item'>
               <input class='tgl tgl-light' id='auto_receive_order' type='checkbox' <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_auto_receive_order']) {?>checked<?php }?>>
               <label class='tgl-btn' for='auto_receive_order'></label>
           </span>
        </div>
        <p style="color: red;margin-top: 10px;">注：若关闭自动接单，商家在10分钟内未接单，系统将自动退款</p>
    </div>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
    <h4 class="info-title"><span style="width: 100%;margin-top: 20px">允许入驻商家完成订单</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span></span>
            <label id="choose-onoff" class="choose-onoff" style="margin-bottom: 10px">
                <input class="ace ace-switch ace-switch-5" id="s_entershop_finish_open" data-type="open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_entershop_finish_open']) {?>checked<?php }?> >
                <span class="lbl"></span>
            </label>
        </div>
        <div style="color: red"></div>
    </div>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==4||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
    <h4 class="info-title"><span style="width: 100%">商家订单结算</span></h4>
    <div class="code">
        <div class="item-wrap">
            <span>商家订单完成</span>
            <span class="line-display"><input type="number" id="enter_settle" value="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_enter_settle']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_enter_settle'];?>
<?php } else { ?>0<?php }?>" class="form-control"></span>
            <span>天后, 结算至商家余额</span>
        </div>
        <div class=''>
            <button id='manual_sync_settled' class='btn btn-sm btn-danger'>手动同步商家未结算订单</button>
        </div>
    </div>
    <?php }?>
    <button class="btn btn-sm btn-green btn-save" style="margin-left: 20px;margin-top: 100px;display: block"> 保 存</button>
</div>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>

<script>

    <?php if ($_smarty_tpl->tpl_vars['ac_type']->value==32) {?>
        //示范一个公告层
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            closeBtn: false,
            area: '300px;',
            shade: 0.8,
            id: 'LAY_layuipro', //设定一个id，防止重复弹出
            btn: ['现在跳转'],
            btnAlign: 'c',
            moveType: 1, //拖拽模式，0或者1
            content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">为了更好的用户体验，我们已经将当前配置页面已更新至<br><br>【配置管理】-->【系统配置】中，<br><br>此配置页面将不在进行支持！！！</div>',
            success: function(layero){
                var btn = layero.find('.layui-layer-btn');
                btn.find('.layui-layer-btn0').attr({
                    href: '/wxapp/configs/config#tradesetting',
                });
            }
        });
    <?php }?>





    var appletType = '<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_type'];?>
';
    $('.btn-save').on('click',function(){
    	layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var finish_trade = $('#finish_trade').val();
            var return_time = $('#return_time').val();
	        var close_trade  = $('#close_trade').val();
            var return_ratio = $('#return_ratio').val();
            var s_order_tip  = $('#s_order_tip:checked').val();
            var s_order_comment  = $('#s_order_comment:checked').val();
            var auto_refund  = $('#auto_refund').val();
            var auto_receive_order  = $('#auto_receive_order:checked').val();
            var enter_settle  = $('#enter_settle').val();
            var s_entershop_finish_open = $('#s_entershop_finish_open:checked').val();
            if(close_trade < 3){
                layer.msg('订单取消时间设置不能少于3分钟');
                return;
            }

            var auto_finish;
            if($('#auto_finish').is(':checked') || appletType != '32'){
                auto_finish = 1;
            }else{
                auto_finish = 0;
            }
	        if(finish_trade && close_trade){
	            var data={
	                'finishTrade': finish_trade,
                    'return_time' : return_time,
	                'closeTrade': close_trade,
                    'returnRatio': return_ratio,
                    'autoFinish':auto_finish,
                    's_order_tip':s_order_tip,
                    'autoRefund':auto_refund,
                    'autoReceiveOrder': auto_receive_order,
                    's_order_comment':s_order_comment,
                    'enter_settle': enter_settle,
                    's_entershop_finish_open' : s_entershop_finish_open
	            };
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/delivery/saveTradeSetting',
	                'data'  : data,
	                'dataType'  : 'json',
	                success : function(response){
	                    layer.msg(response.em);
	                    if(response.ec == 200){
                            window.location.reload();
                        }
	                }
	            });
	        }
        });
        
    });
    /**
     * 手动同步未结算的店铺订单
     * @param  {[type]} ){                 } [description]
     * @return {[type]}     [description]
     */
    $('#manual_sync_settled').click(function(){
        layer.confirm('确定要同步未结算的订单？此操作仅在商户订单出现异常未结算时使用！', {
            btn: ['确定','取消'] //按钮
        },function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/delivery/manualSyncSettled',
                'dataType'  : 'json',
                 success : function(response){
                    layer.msg(response.em);
                    layer.close(index);
                }
            });
        });
    });
</script><?php }} ?>

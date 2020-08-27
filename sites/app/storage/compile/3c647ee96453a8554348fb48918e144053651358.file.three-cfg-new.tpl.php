<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:09:01
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/three-cfg-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5433355565e4df84d87ebe8-13616519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c647ee96453a8554348fb48918e144053651358' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/three-cfg-new.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5433355565e4df84d87ebe8-13616519',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tcRow' => 0,
    'appletCfg' => 0,
    'row' => 0,
    'showRoundType' => 0,
    'withdraw' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df84d8eb3d4_87556108',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df84d8eb3d4_87556108')) {function content_5e4df84d8eb3d4_87556108($_smarty_tpl) {?><style>
    .table.table-avatar tbody>tr>td{
        line-height: 48px;
    }
    .radio-box{
        margin-left: 0;
    }
    input[type=checkbox].ace.ace-switch {
        height: 32px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        line-height: 31px;
        height: 32px;
        overflow: hidden;
        border-radius: 18px;
        font-size: 12px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before {
        background-color: #44BB00;
        border-color: #44BB00;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        top: 1px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
        top: 1px
    }
    #must_set input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "\a0\a0必须设置\a0\a0\a0\a0暂不设置";
    }
    #must_set input[type=checkbox].ace.ace-switch,#must_set input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        width: 105px;
    }
    #must_set input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
        left: 74px;
    }
    #show_refer input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "\a0\a0显示\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0隐藏";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开\a0\a0\a0\a0\a0\a0\a0\a0关";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    #show_refer input[type=checkbox].ace.ace-switch,#show_refer input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        width: 85px;
    }
    #show_refer input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
        left: 54px;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--<div style="margin-left:135px;"><a target="_blank" style="color:red; " href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=384&extra=">该插件使用教程请点此查看</a></div>-->
<div  id="mainContent">
    <div class="row">
        <div class="page-header">
            <div class="alert alert-block alert-yellow ">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                分销等级，涉及到用户佣金，请不要随便修改!
            </div>
        </div>
    </div>

    <div class="row"  style="margin-left: 30px;margin-right: 30px;margin-bottom: 20px">
        <div class="page-header">
            <h1>基础设置</h1>
        </div>
        <div class="setting" style="width: 80%;margin: auto;">
            <div class="form-inline row ">
                <label for="inputEmail3" class="col-sm-3 control-label">是否开启三级分销</label>
                <label class="form-group" id="choose-yesno">
                    <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus()" <?php if ($_smarty_tpl->tpl_vars['tcRow']->value&&$_smarty_tpl->tpl_vars['tcRow']->value['tc_isopen']==1) {?>checked<?php }?> >
                    <label class='tgl-btn' for='audit_status'></label>
                </label>
            </div>
            <div id="lebelTab" class="tab-pane in ">
                <div class="form-inline row " style="margin-top: 20px;">
                    <label class="col-sm-3 control-label">分销等级</label>
                    <div class="">
                        <div class="level-box">
                            <div class="radio-box levelChoose">
                                <span data-val="1">
                                    <input type="radio" name="level" value="1" id="level1" >
                                    <label for="level1">1级分销</label>
                                </span>
                                <span data-val="2">
                                    <input type="radio" name="level" value="2" id="level2">
                                    <label for="level2">2级分销</label>
                                </span>
                                <span data-val="3">
                                    <input type="radio" name="level" value="3" id="level3">
                                    <label for="level3">3级分销</label>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-inline row " style="margin-top: 20px;">
                <label class="col-sm-3 control-label">收银台是否参与分销</label>
                <div class="level-box">
                    <div class="radio-box">
                                <span data-val="1">
                                    <input type="radio" name="cashierOpen" value="1" id="cashierOpen1" >
                                    <label for="cashierOpen1">是</label>
                                </span>
                        <span data-val="0">
                                    <input type="radio" name="cashierOpen" value="0" id="cashierOpen0">
                                    <label for="cashierOpen0">否</label>
                                </span>
                    </div>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==18) {?>
             <div class="form-inline row " style="margin-top: 20px;">
                <label class="col-sm-3 control-label">会员卡是否参与分销</label>
                <div class="level-box">
                    <div class="radio-box">
                        <span data-val="1">
                            <input type="radio" name="cardDeduct" value="1" id="cardDeduct1" >
                            <label for="cardDeduct1">是</label>
                        </span>
                        <span data-val="0">
                            <input type="radio" name="cardDeduct" value="0" id="cardDeduct0">
                            <label for="cardDeduct0">否</label>
                        </span>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
            <div class="form-inline row " style="margin-top: 20px;">
                <label class="col-sm-3 control-label">商品详情是否展示佣金</label>
                <div class="level-box">
                    <div class="radio-box">
                                <span data-val="1">
                                    <input type="radio" name="showDeductOpen" value="1" id="showDeductOpen1" >
                                    <label for="showDeductOpen1">是</label>
                                </span>
                        <span data-val="0">
                                    <input type="radio" name="showDeductOpen" value="0" id="showDeductOpen0">
                                    <label for="showDeductOpen0">否</label>
                                </span>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
    <div class="row"  style="margin-left: 30px;margin-right: 30px;margin-bottom: 20px">
        <div class="page-header">
            <h1>分销资格设置</h1>
        </div>
        <div class="setting" style="width: 80%;margin: auto;">
            <div id="wxCfg" class="tab-pane">
                <input type="hidden" name="cfg_id" id="cfg_id" value="0"/>
                <div class="form-inline row">
                    <label class="col-sm-3 control-label">成为分销员/合伙人条件</label>
                    <div class="form-inline col-sm-9" role="form">
                        <div class="form-group">
                            <div class="input-group" style="width: 210px;">
                                <div class="input-group-addon">消费</div>
                                <input type="text" size="8" class="form-control member_limit" id="limitNumber"
                                       value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_min_num']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_min_num'];?>
<?php }?>"
                                       data-id="limitNumber" placeholder="最低购买数量" style="width:120px;">
                                <div class="input-group-addon">次</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span style="margin:0 35px;">或者</span>
                        </div>
                        <div class="form-group">
                            <div class="input-group" style="width: 210px;">
                                <div class="input-group-addon">消费</div>
                                <input type="text" size="8" class="form-control member_limit" id="limitMoney"
                                       value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cc_min_amount']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_min_amount'];?>
<?php }?>"
                                       data-id="limitMoney"  placeholder="或者最低消费额度" style="width:120px;">
                                <div class="input-group-addon">元</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 control-label">存在条件限制时提示语</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" rows="3" id="noqr_tip" placeholder="存在条件限制时候，会员无法获取二维码时提示语"><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cc_noqr_tip'];?>
<?php }?></textarea>
                    </div>
                    <div class="col-sm-4">
                        &nbsp;
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                <div class="space-4"></div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">成为分销商是否需要上级审核</label>
                    <div class="level-box col-sm-9">
                        <div class="radio-box">
                                <span data-val="1">
                                    <input type="radio" name="audit" value="1" id="audit1" >
                                    <label for="audit1">是</label>
                                </span>
                            <span data-val="0">
                                    <input type="radio" name="audit" value="0" id="audit0">
                                    <label for="audit0">否</label>
                                </span>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="space-4"></div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">充值金额是否计算成消费额度</label>
                    <div class="level-box col-sm-9">
                        <div class="radio-box">
                                <span data-val="1">
                                    <input type="radio" name="recharge" value="1" id="recharge1" >
                                    <label for="recharge1">是</label>
                                </span>
                            <span data-val="0">
                                    <input type="radio" name="recharge" value="0" id="recharge0">
                                    <label for="recharge0">否</label>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="space-4"></div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">首页是否开启三级分销提醒</label>
                    <div class="level-box col-sm-9">
                        <div class="radio-box">
                                <span data-val="1">
                                    <input type="radio" name="tip" value="1" id="tip1" >
                                    <label for="tip1">是</label>
                                </span>
                            <span data-val="0">
                                    <input type="radio" name="tip" value="0" id="tip0">
                                    <label for="tip0">否</label>
                                </span>
                        </div>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['showRoundType']->value==1) {?>
                <div class="space-4"></div>
                <div class="form-group row" >
                    <label class="col-sm-3 control-label">佣金取整</label>
                    <div class="level-box col-sm-9">
                        <div class="radio-box">
                            <span>
                                <input type="radio" name="roundType" id="round_no" value="0" <?php if (!($_smarty_tpl->tpl_vars['tcRow']->value['tc_round_type']>0)) {?>checked<?php }?>>
                                <label for="round_no">不取整</label>
                            </span>
                            <span>
                                <input type="radio" name="roundType" id="round_ceil" value="1" <?php if ($_smarty_tpl->tpl_vars['tcRow']->value['tc_round_type']==1) {?>checked<?php }?>>
                                <label for="round_ceil">向上取整</label>
                            </span>
                            <span>
                                <input type="radio" name="roundType" id="round_floor" value="2" <?php if ($_smarty_tpl->tpl_vars['tcRow']->value['tc_round_type']==2) {?>checked<?php }?>>
                                <label for="round_floor">向下取整</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label" style="color: red">注意：</label>
                    <div class="level-box col-sm-9" >
                        1.选择向上取整时，佣金会强制转换为更大的整数，如佣金为<span style="color: red">1.01元</span>则会增加为<span style="color: red">2元</span><br>
                        2.选择向下取整时，佣金会强制转换为更小的整数，如佣金为<span style="color: red">1.99元</span>则会减少为<span style="color: red">1元</span><br>
                    </div>
                </div>
                <?php } else { ?>
                <!-- 防止js报错 -->
                 <input type="hidden" name="roundType" value="0" >
                <?php }?>
                <div class="space-4"></div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">推广海报图</label>
                    <div class="level-box col-sm-9">
                        <a href="/wxapp/three/code" class="btn btn-primary">设置</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-left: 30px;margin-right: 30px;margin-bottom: 20px">
        <div class="page-header">
            <h1>佣金提现设置</h1>
        </div>
        <div class="setting" style="width: 80%;margin: auto;">
            <!--提现信息配置-->
            <div id="wxCfg" class="tab-pane">
                <input type="hidden" name="cfg_id" id="cfg_id" value="0"/>
                <div class="form-group  row">
                    <label class="col-sm-3 control-label">提现方式</label>
                    <div class="col-sm-9">
                        <div class="form-group  row">
                            <label for="inputEmail3" class="col-sm-3 control-label">微信零钱提现</label>
                            <label class="" id="choose-yesno">
                                <input name="wc_wx_open" onchange="checkChange('wc_wx_open')" class="ace ace-switch ace-switch-5" id="wc_wx_open" <?php if ($_smarty_tpl->tpl_vars['withdraw']->value&&$_smarty_tpl->tpl_vars['withdraw']->value['wc_change_open']) {?>checked<?php }?> type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>
                        <div class="form-group  row">
                            <label for="inputEmail3" class="col-sm-3 control-label">银行卡提现</label>
                            <label class="" id="choose-yesno" >
                                <input name="wc_bank_open"  onchange="checkChange('wc_bank_open')" class="ace ace-switch ace-switch-5" id="wc_wx_open" <?php if ($_smarty_tpl->tpl_vars['withdraw']->value&&$_smarty_tpl->tpl_vars['withdraw']->value['wc_bank_open']) {?>checked<?php }?> type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                </div>

                 <div class="form-group  row" id="wx_open" <?php if (!$_smarty_tpl->tpl_vars['withdraw']->value['wc_change_open']) {?>style="display:none"<?php }?>>
                     <label for="inputEmail3" class="col-sm-3 control-label">零钱提现配置</label>
                     <div class="col-sm-9">
                        <label for="inputEmail3" class="control-label" style="margin-right: 10px;">是否填写手机号</label>
                        <label class="" id="choose-yesno" style="margin-right: 20px;">
                            <input name="wc_wxmobile_open" class="ace ace-switch ace-switch-5" id="wc_wxmobile_open" <?php if ($_smarty_tpl->tpl_vars['withdraw']->value&&$_smarty_tpl->tpl_vars['withdraw']->value['wc_mobile_open']) {?>checked<?php }?> type="checkbox">
                            <span class="lbl"></span>
                        </label>

                        <label for="inputEmail3" class="control-label" style="margin-right: 10px;" >是否填写账号</label>
                        <label class="" id="choose-yesno">
                            <input name="wc_wxaccount_open" class="ace ace-switch ace-switch-5" id="wc_wxaccount_open" <?php if ($_smarty_tpl->tpl_vars['withdraw']->value&&$_smarty_tpl->tpl_vars['withdraw']->value['wc_account_open']) {?>checked<?php }?> type="checkbox">
                            <span class="lbl"></span>
                        </label>
                     </div>
                <div class="space"></div>
                  </div>

                  <div class="form-group  row" id="bank_open" <?php if (!$_smarty_tpl->tpl_vars['withdraw']->value['wc_bank_open']) {?>style="display:none"<?php }?>>
                    <label for="inputEmail3" class="col-sm-3 control-label">银行卡提现配置</label>
                     <div class="col-sm-9">
                         <label for="inputEmail3" class="control-label" style="margin-right: 10px;">是否填写手机号</label>

                         <label class="" id="choose-yesno">
                            <input name="wc_bank_mobile_open" class="ace ace-switch ace-switch-5" id="wc_bank_mobile_open" <?php if ($_smarty_tpl->tpl_vars['withdraw']->value&&$_smarty_tpl->tpl_vars['withdraw']->value['wc_bank_mobile_open']) {?>checked<?php }?> type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </div>
                   <div class="space"></div>
                </div>
                <div class="form-group  row">
                    <label class="col-sm-3 control-label">提现最低额度限制</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="wc_min" id="wc_min" value="<?php if ($_smarty_tpl->tpl_vars['withdraw']->value) {?><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['wc_min'];?>
<?php }?>" placeholder="提现最低额度">
                    </div>
                </div>
                <div class="space-4"></div>
                <!--新增提现手续百分比-->
                <div class="form-group  row">
                    <label class="col-sm-3 control-label">提现手续费百分比（单位%）</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="wc_rate" id="wc_rate" value="<?php if ($_smarty_tpl->tpl_vars['withdraw']->value) {?><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['wc_rate'];?>
<?php }?>" placeholder="提现手续费百分比">
                    </div>
                    <div style="font-size: 12px;color: #999;margin-top: 2px;margin-left:27%;">
                        提示:如果不填或者为0，则说明提现不收取手续费。如要设置手续费百分比为5%,填写为5即可
                    </div>
                </div>
                <div class="space-4"></div>
                <div class="form-group  row">
                    <label class="col-sm-3 control-label">提现说明</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" id="wc_desc" name="wc_desc"><?php if ($_smarty_tpl->tpl_vars['withdraw']->value) {?><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['wc_desc'];?>
<?php }?></textarea>
                    </div>
                </div>
                <div class="space"></div>

                <div class="form-group  row">
                    <label for="inputEmail3" class="col-sm-3 control-label">自动提现</label>
                    <label class="" id="choose-yesno">
                        <input name="wc_auto" class="ace ace-switch ace-switch-5" id="wc_auto" <?php if ($_smarty_tpl->tpl_vars['withdraw']->value&&$_smarty_tpl->tpl_vars['withdraw']->value['wc_auto']) {?>checked<?php }?> type="checkbox">
                        <span class="lbl"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-----提交操作---->
    <div class="form-group">
        <div class="center">
            <button class="btn btn-sm btn-primary save-cfg" > &nbsp; 保 &nbsp; 存 &nbsp; </button>
        </div>
    </div>
</div>
<script src="/public/plugin/layer/layer.js" type="text/javascript"></script>
<script src="/public/wxapp/three/js/sale.js" type="text/javascript"></script>
<script>
    $(function(){
        $('input[name="level"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_level'];?>
"]').attr('checked',true);
        $('input[name="audit"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_f_audit'];?>
"]').attr('checked',true);
        $('input[name="refer"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['cc_show_refer'];?>
"]').attr('checked',true);
        $('input[name="must"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['cc_must_set'];?>
"]').attr('checked',true);
        $('input[name="recharge"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['cc_recharge_amount'];?>
"]').attr('checked',true);
        $('input[name="tip"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_istip'];?>
"]').attr('checked',true);
        $('input[name="cashierOpen"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_cashier_open'];?>
"]').attr('checked',true);
         $('input[name="cardDeduct"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_card_deduct'];?>
"]').attr('checked',true);
        $('input[name="showDeductOpen"][value="<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_show_deduct_open'];?>
"]').attr('checked',true);
        console.log(<?php echo $_smarty_tpl->tpl_vars['row']->value['tc_istip'];?>
);
    });
    $('.member_limit').on('click',function(){
        var id   = $(this).data('id');
        var msg  = '成为分销员的限制条件';
        if(id == 'limitNumber'){
            msg = '最低购买数量：只有购买一定数量的商品，才能成为分销员';
        }else{
            msg = '最低购买金额：只有购买一定金额的商品，才能成为分销员';
        }
        layer.tips(msg, '#'+id, {
            tips: [1, '#3595CC'],
            time: 4000
        });
    });
    function checkChange(name){
        if($('input[name="'+name+'"]:checked').val()=='on'){
            $('#'+name.substring(3)).show();
        }else{
            $('#'+name.substring(3)).hide();
        }
    }
    $('.save-cfg').on('click',function(){
    	layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            saveWithDraw()

            var level = $('input[name="level"]:checked').val();
	        var refer = $('input[name="refer"]:checked').val();
	        var must  = $('input[name="must"]:checked').val();
	        var recharge  = $('input[name="recharge"]:checked').val();
            var cashierOpen  = $('input[name="cashierOpen"]:checked').val();
            var showDeductOpen  = $('input[name="showDeductOpen"]:checked').val();
	        var istip     = $('input[name="tip"]:checked').val();
            var roundType = $("input[name='roundType']:checked").val();
            var audit = $("input[name='audit']:checked").val();
            // 预约服务添加会员卡分销
            // zhangzc
            // 2019-08-19
            var cardDeduct  = $('input[name="cardDeduct"]:checked').val();
            
	        var  data = {
	            'level'     : level,
	            'refer'     : refer ,
	            'must'      : must ,
	            'recharge'  : recharge ,
                'audit'     : audit,
                'cashierOpen'  : cashierOpen ,
                'showDeductOpen'  : showDeductOpen ,
	            'number'    : $('#limitNumber').val(),
	            'money'     : $('#limitMoney').val(),
	            'noqrTip'   : $('#noqr_tip').val(),
	            'pageType'  : 'cfg',
	            'istip'      :istip,
                'roundType' : roundType,
                'cardDeduct':cardDeduct,
	        };
	        sendCfg(data);
        });
    });
    function saveWithDraw() {
        var open            = $('input[name="wc_wx_open"]:checked').val();
        var openBank        = $('input[name="wc_bank_open"]:checked').val();
        var auto            = $('input[name="wc_auto"]:checked').val();
        var wxmobile_open   = $('input[name="wc_wxmobile_open"]:checked').val();
        var wxaccount_open  = $('input[name="wc_wxaccount_open"]:checked').val();
        var bankmobile_open = $('input[name="wc_bank_mobile_open"]:checked').val();
        var wc_min          = parseInt($('#wc_min').val());
        var wc_desc         = $('#wc_desc').val();
        //var wc_wx_actname   = $('#wc_wx_actname').val();
        var wc_bank_open = openBank == 'on' ? 1: 0;
        var wc_wx_open = open == 'on' ? 1: 0;
        var wc_auto = auto == 'on' ? 1: 0;
        var wc_mobile_open = wxmobile_open == 'on' ? 1: 0;
        var wc_account_open = wxaccount_open == 'on' ? 1: 0;
        var wc_bank_mobile_open = bankmobile_open == 'on' ? 1: 0;
        //新增提现手续费百分比
        var wc_rate       = $('#wc_rate').val();
        if(wc_min < 1){
            layer.msg('提现最低额度限制不得低于1元');
        }else{
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            var data = {
                'wc_desc'           : wc_desc,
                'wc_wx_open'        : wc_wx_open,
                'wc_bank_open'      : wc_bank_open,
                'wc_min'            : wc_min,
                'wc_auto'           : wc_auto,
                'wc_mobile_open'   : wc_mobile_open,
                'wc_account_open'  : wc_account_open,
                'wc_bank_mobile_open': wc_bank_mobile_open,
                'wc_rate'            : wc_rate
            };

            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/three/saveWithdrawCfg',
                'data'  : data,
                'dataType'  : 'json',
                success : function(response){
                }
            });
        }
    }
    function changeAuditStatus() {
        var status = $('#audit_status').is(':checked');
        var data = {
            status : status ? 1 : 0
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/three/openThreeDistrib',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(data.status==1){
                        layer.msg('启用成功');
                    }else{
                        layer.msg('关闭成功');
                    }
                }
            }
        });
    }

</script>
<?php }} ?>

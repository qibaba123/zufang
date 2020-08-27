<?php /* Smarty version Smarty-3.1.17, created on 2020-04-23 11:55:36
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/member-coin-record.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13482359045ea111b84a9729-43954015%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b691bc7aba89a2e6425e68d063dd654820a6031d' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/member-coin-record.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13482359045ea111b84a9729-43954015',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'member' => 0,
    'mid' => 0,
    'status' => 0,
    'start' => 0,
    'end' => 0,
    'list' => 0,
    'item' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5ea111b8521252_74034040',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea111b8521252_74034040')) {function content_5ea111b8521252_74034040($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/wxapp/css/member-record-derails.css?2">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<div  id="content-con" class="cus-part-item" style="padding: 15px 22px;">
    <div class="wechat-setting">
        <div class="tabbable">
            <!--导航链接-->
            <?php echo $_smarty_tpl->getSubTemplate ("../memberCard/tabal-link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <div class="tab-content"  style="z-index:1;padding: 10px 0;padding-bottom: 0;">
                <div id="mainContent">
                    <!-- <div class="row" style="padding-left: 20px">
                        当前余额：<?php echo $_smarty_tpl->tpl_vars['member']->value['m_gold_coin'];?>

                        <a class="btn btn-xs btn-primary recharge-btn" data-toggle="modal" data-target="#rechargeModal"  data-mid="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
" data-coin="<?php echo $_smarty_tpl->tpl_vars['member']->value['m_gold_coin'];?>
" data-type="single" style="margin-left: 20px">操作</a>
                    </div> -->
                    <div class="cur-remain">
                        <div class="cur-remain-label">当前余额（元）</div>
                        <div class="cur-remain-val">
                            <span><?php echo $_smarty_tpl->tpl_vars['member']->value['m_gold_coin'];?>
</span>
                            <a href="javascript:;" class="recharge-btn" data-toggle="modal" data-target="#rechargeModal"  data-mid="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
" data-coin="<?php echo $_smarty_tpl->tpl_vars['member']->value['m_gold_coin'];?>
" data-type="single">操作</a>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="page-header search-box" style="width: 98%">
                            <div class="col-sm-12">
                                <form class="form-inline" action="/wxapp/member/memberCoinRecord" method="get">
                                    <div class="col-xs-11 form-group-box">
                                        <div class="form-container" style="width: auto !important;">
                                            <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">
                                            <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
                                            <div class="form-group" style="width: 480px">
                                                <div class="input-group">
                                                    <div class="input-group-addon" >时间</div>
                                                    <input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                                    <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                                    <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <div class="tabbable record-tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <!--
                                    <li >
                                        <a href="/wxapp/member/rechargeChange">
                                            <i class="green icon-cog bigger-110"></i>
                                            充值配置
                                        </a>
                                    </li>
                                    -->
                                    <li <?php if ($_smarty_tpl->tpl_vars['status']->value==1) {?>class="active"<?php }?>>
                                        <a <?php if ($_smarty_tpl->tpl_vars['status']->value==1) {?>href="#"<?php } else { ?>href="/wxapp/member/memberCoinRecord?mid=<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
&status=1"<?php }?>>
                                        收入
                                        </a>
                                    </li>
                                    <li <?php if ($_smarty_tpl->tpl_vars['status']->value==2) {?>class="active"<?php }?>>
                                        <a <?php if ($_smarty_tpl->tpl_vars['status']->value==2) {?>href="#"<?php } else { ?>href="/wxapp/member/memberCoinRecord?mid=<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
&status=2"<?php }?>>
                                        支出
                                        </a>
                                    </li>
                                </ul>
                                <div class="search-part-wrap">
                                    <form class="form-inline" action="/wxapp/member/memberCoinRecord" method="get">
                                        <input type="hidden" name="mid" value="<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
">
                                        <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
                                        <div class="search-input-item">
                                            <div class="input-item-group">
                                                <div class="input-item-addon">关注时间</div>
                                                <div class="input-form">
                                                    <input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </div>
                                                <div class="input-form">到</div>
                                                <div class="input-form">
                                                    <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="search-input-item">
                                            <div class="search-btn">
                                                <button type="submit" class="btn btn-blue btn-sm">查询</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-content" style="padding: 10px 0;padding-bottom: 0;">
                                    <!--
                                    <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>充值记录导出</a>
                                    -->
                                    <!--充值记录-->
                                    <div id="home" class="tab-pane in active">
                                        <div class="cus-part-item" style="padding: 0;box-shadow: none;margin-bottom: 0;">
                                            <div class="table-responsive">
                                                <table id="sample-table-1" class="table" style="margin-bottom: 0;">
                                                    <thead>
                                                    <tr>
                                                        <th>订单编号</th>
                                                        <th>支付金额</th>
                                                        <th>获得金额</th>
                                                        <th>支付方式</th>
                                                        <th>备注</th>
                                                        <th>
                                                            <i class="icon-time bigger-110 hidden-480"></i>
                                                            创建时间
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                                        <tr id="tr_id_<?php echo $_smarty_tpl->tpl_vars['item']->value['rr_id'];?>
">
                                                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['rr_tid'];?>
</td>
                                                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['rr_amount'];?>
</td>
                                                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['rr_gold_coin'];?>
</td>
                                                            <td>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==1) {?>
                                                                微信支付
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==2) {?>
                                                                余额支付
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==3) {?>
                                                                充值码充值
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==4) {?>
                                                                管理员充值
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==10) {?>
                                                                订单退款
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==11) {?>
                                                                红包收入
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==12) {?>
                                                                积分兑换
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==13) {?>
                                                                购买会员卡
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==14) {?>
                                                                订单关闭退款
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==15) {?>
                                                                订单退款
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==18) {?>
                                                                收银台退款
                                                                <?php }?>
                                                            </td>
                                                            <td class="remark">
                                                                <p>
                                                                    <?php echo $_smarty_tpl->tpl_vars['item']->value['rr_remark'];?>

                                                                </p>
                                                                <?php if ($_smarty_tpl->tpl_vars['item']->value['rr_pay_type']==4&&$_smarty_tpl->tpl_vars['item']->value['manager_id']>0) {?>
                                                                <p>
                                                                    <span style="color: blue;">管理员：</span><?php echo $_smarty_tpl->tpl_vars['item']->value['manager_name'];?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['item']->value['manager_mobile'];?>

                                                                </p>
                                                                <?php }?>
                                                            </td>
                                                            <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['item']->value['rr_create_time']);?>
</td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="page-part-wrap"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</div>
                                            </div><!-- /.table-responsive -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 余额充值 -->
<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="hid_mid" >
            <input type="hidden" id="recharge_type" value="">
            <input type="hidden" id="gold_coin_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rechargeModalLabel">
                    余额
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row coin-operate" style="display: none">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                        <div class="col-sm-8">
                            <div class="radio-box">
                            <span>
                                <input type="radio" name="operateCoin" id="addCoin" value="1" checked="checked">
                                <label for="addCoin">充值</label>
                            </span>
                                <span>
                                <input type="radio" name="operateCoin" id="reduceCoin" value="0">
                                <label for="reduceCoin">扣费</label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>金额：</label>
                        <div class="col-sm-8">
                            <input id="gold_coin" class="form-control" placeholder="请填写充值金额" style="height:auto!important" type="number"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                        <div class="col-sm-8">
                            <textarea name="recharge-remark" id="recharge_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-blue saveRecharge">保存</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    收支导出
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/member/importRecharge" method="post">
                        <div class="form-group" style="height: 25px">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期"/>
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group" style="height: 45px">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off"  type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>

                        <button type="button" class="btn btn-blueoutline" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-blue" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--该店铺交易明细-->
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
    $(function(){
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
    });


    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

    //充值模态框点击
    $('.recharge-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var coinNow = $(this).data('coin');
        //批量充值
        if(type == 'multi'){
            //隐藏操作选择
            $(".coin-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".coin-operate").css('display','');
        }
        $('#hid_mid').val(mid);
        $('#recharge_type').val(type);
        $('#gold_coin_now').val(coinNow);
        $('#gold_coin').val('');
        $('#recharge_remark').val('');
        $('#pwd').val('');
    });

    //管理员操作余额
    $('.saveRecharge').on('click',function(){
        var mid    = $('#hid_mid').val();
        var coin   = $('#gold_coin').val();
        var coinNow= $('#gold_coin_now').val();
        var remark = $('#recharge_remark').val();
        var pwd    = $('#pwd').val();
        var type   = $('#recharge_type').val();
        var operate= $("input[name='operateCoin']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && parseFloat(coinNow) < parseFloat(coin)){
            layer.msg('扣费金额需小于当前余额');
            return false;
        }
        var data = {
            'mid'     : mid,
            'coin'    : coin,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl= '/wxapp/member/newSaveRecharge';
        //批量充值
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择用户');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiRecharge'
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });
</script>
<?php }} ?>

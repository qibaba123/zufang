<?php /* Smarty version Smarty-3.1.17, created on 2020-05-10 15:31:37
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/member-countCard-verify.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17718807225eb7add987c690-88798470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e4bb241251b9ef21145a9e643f7d23380581389' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/member-countCard-verify.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17718807225eb7add987c690-88798470',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'offlineCard' => 0,
    'mid' => 0,
    'status' => 0,
    'start' => 0,
    'end' => 0,
    'urlType' => 0,
    'list' => 0,
    'item' => 0,
    'appletCfg' => 0,
    'storeList' => 0,
    'storeListOld' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5eb7add98e2318_97789002',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eb7add98e2318_97789002')) {function content_5eb7add98e2318_97789002($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
    .datepicker{
        z-index: 1060 !important;
    }
    .ui-table-order .time-cell{
        width: 120px !important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    table tr th,table tr td{
        text-align: center;
    }
    .remark{
        min-width: 250px;
        max-width: 400px;
        overflow: hidden;
        white-space: normal !important;
        vertical-align:middle;
        text-align: left;
    }
</style>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <?php echo $_smarty_tpl->getSubTemplate ("../memberCard/tabal-link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <div class="tab-content"  style="z-index:1;">
                <div id="mainContent">
                    <?php if ($_smarty_tpl->tpl_vars['offlineCard']->value['cardTitle']) {?>
                    <div class="row" style="padding-left: 20px;margin-bottom: 10px">
                        <span style="font-weight: bold;padding-right: 10px;font-size: 18px"><?php echo $_smarty_tpl->tpl_vars['offlineCard']->value['cardTitle'];?>
</span>
                        <?php if ($_smarty_tpl->tpl_vars['offlineCard']->value['expireStatus']==1) {?>
                        <span style="color: green">未到期</span>
                        <?php } else { ?>
                        <span style="color: red">已到期</span>
                        <?php }?>
                        <br/>
                        <span>卡号<?php echo $_smarty_tpl->tpl_vars['offlineCard']->value['cardNum'];?>
</span><br/>
                        <span>剩余<?php echo $_smarty_tpl->tpl_vars['offlineCard']->value['leftNum'];?>
次</span><br/>
                        <span>到期时间：<?php echo $_smarty_tpl->tpl_vars['offlineCard']->value['expireTime'];?>
</span>

                    </div>
                    <?php }?>
                    <div class="row">
                        <!--
                        <div class="page-header search-box" style="width: 98%">
                            <div class="col-sm-12">
                                <form class="form-inline" action="/wxapp/member/memberCountCardOrder" method="get">
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
                        </div>
                        -->
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div class="tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <!--
                                    <li >
                                        <a href="/wxapp/member/rechargeChange">
                                            <i class="green icon-cog bigger-110"></i>
                                            充值配置
                                        </a>
                                    </li>
                                    -->
                                    <li <?php if ($_smarty_tpl->tpl_vars['urlType']->value=='order') {?>class="active"<?php }?>>
                                    <a <?php if ($_smarty_tpl->tpl_vars['urlType']->value=='order') {?>href="#"<?php } else { ?>href="/wxapp/member/memberCountCardOrder?mid=<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
"<?php }?>>

                                    购买记录
                                    </a>
                                    </li>
                                    <li <?php if ($_smarty_tpl->tpl_vars['urlType']->value=='verify') {?>class="active"<?php }?>>
                                    <a <?php if ($_smarty_tpl->tpl_vars['urlType']->value=='verify') {?>href="#"<?php } else { ?>href="/wxapp/member/memberCountCardVerify?mid=<?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
"<?php }?>>

                                    使用记录
                                    </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <!--
                                    <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>充值记录导出</a>
                                    -->
                                    <!--充值记录-->
                                    <div id="home" class="tab-pane in active">
                                        <div class="table-responsive">
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>使用门店</th>
                                                    <th>使用时间</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                                    <tr id="tr_id_<?php echo $_smarty_tpl->tpl_vars['item']->value['ov_id'];?>
">
                                                        <td>
                                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                                            <?php if ($_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['item']->value['ov_st_id']]['acs_name']) {?>
                                                            <?php echo $_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['item']->value['ov_st_id']]['acs_name'];?>

                                                            <?php }?>
                                                            <?php if ($_smarty_tpl->tpl_vars['storeListOld']->value[$_smarty_tpl->tpl_vars['item']->value['ov_st_id']]['os_name']) {?>
                                                            <?php echo $_smarty_tpl->tpl_vars['storeListOld']->value[$_smarty_tpl->tpl_vars['item']->value['ov_st_id']]['os_name'];?>

                                                            <?php }?>
                                                            <?php } else { ?>
                                                            <?php echo $_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['item']->value['ov_st_id']]['os_name'];?>

                                                            <?php }?>
                                                        </td>
                                                        <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['item']->value['ov_record_time']);?>
</td>
                                                    </tr>
                                                    <?php } ?>
                                                <tr><td colspan="7"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                                                </tbody>
                                            </table>
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
<!-- 增加积分 -->
<div class="modal fade" id="pointModal" tabindex="-1" role="dialog" aria-labelledby="pointModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="point_mid" >
            <input type="hidden" id="point_type" value="">
            <input type="hidden" id="point_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pointModalLabel">
                    积分
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row point-operate" style="display: none">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                        <div class="col-sm-8">
                            <div class="radio-box">
                            <span>
                                <input type="radio" name="operatePoint" id="addPoint" value="1" checked="checked">
                                <label for="addPoint">增加</label>
                            </span>
                                <span>
                                <input type="radio" name="operatePoint" id="reducePoint" value="0">
                                <label for="reducePoint">扣除</label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>积分：</label>
                        <div class="col-sm-8">
                            <input id="point" class="form-control" placeholder="请填写积分数值" style="height:auto!important" type="number"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                        <div class="col-sm-8">
                            <textarea name="point-remark" id="point_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="point_pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary savePoint">保存</button>
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

                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
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

    //增加积分模态框点击
    $('.point-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var pointNow = $(this).data('point_now');
        //批量增加
        if(type == 'multi'){
            $(".point-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".point-operate").css('display','');
        }
        $('#point_mid').val(mid);
        $('#point_type').val(type);
        $('#point_now').val(pointNow);
        $('#point').val('');
        $('#point_remark').val('');
        $('#point_pwd').val('');
    });

    //管理员增加积分
    $('.savePoint').on('click',function(){
        var mid    = $('#point_mid').val();
        var type   = $('#point_type').val();
        var point  = $('#point').val();
        var pointNow = $('#point_now').val();
        var remark = $('#point_remark').val();
        var pwd    = $('#point_pwd').val();
        var operate= $("input[name='operatePoint']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && pointNow < point){
            layer.msg('扣除积分需小于当前积分');
            return false;
        }

        var data = {
            'mid'     : mid,
            'point'   : point,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl = '/wxapp/member/savePoint';
        //批量增加
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择会员');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiPoint';
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

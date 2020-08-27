<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 14:32:23
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/memberCard/store-member.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12755811815e4f7977703248-90393230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d7a9c61bec3f401940fa7468012b7520075f334' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/memberCard/store-member.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12755811815e4f7977703248-90393230',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cardtype' => 0,
    'statInfo' => 0,
    'card' => 0,
    'appletCfg' => 0,
    'nickname' => 0,
    'mobile' => 0,
    'curr_shop' => 0,
    'list' => 0,
    'val' => 0,
    'pageHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f7977782371_37473929',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f7977782371_37473929')) {function content_5e4f7977782371_37473929($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .datepicker { z-index: 1060 !important; }
    .balance .balance-info{
        <?php if ($_smarty_tpl->tpl_vars['cardtype']->value!=2) {?>
        width: 20% !important;
        <?php } else { ?>
        width: 33.33% !important;
        <?php }?>

    }
    .nav-tabs{z-index: 1;}
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <?php echo $_smarty_tpl->getSubTemplate ("./tabal-link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <div class="tab-content"  style="z-index:1;">
                <!-- 汇总信息 -->
                <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                    <div class="balance-info">
                        <div class="balance-title">总会员数<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">未到期<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['noexpire'];?>
</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">已到期<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['expire'];?>
</span>
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value!=2) {?>
                    <div class="balance-info">
                        <div class="balance-title">未用完<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['used'];?>
</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">已用完<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['left'];?>
</span>
                        </div>
                    </div>
                    <?php }?>
                </div>
                <div class="page-header search-box">
                    <div class="col-sm-12">
                        <form action="/wxapp/membercard/memberCard/type/<?php echo $_smarty_tpl->tpl_vars['cardtype']->value;?>
" method="get" class="form-inline">
                            <div class="col-xs-11 form-group-box">
                                <div class="form-container">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员卡号：</div>
                                            <input type="text" class="form-control" name="card" value="<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" placeholder="会员卡号">
                                        </div>
                                    </div>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员昵称：</div>
                                            <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
" placeholder="会员昵称">
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">手机号：</div>
                                            <input type="text" class="form-control" name="mobile" value="<?php echo $_smarty_tpl->tpl_vars['mobile']->value;?>
" placeholder="会员手机号">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-1 pull-right search-btn">
                                <button type="submit" class="btn btn-green btn-sm search-btn">查询</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?>
                <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>会员导出</a>
                <?php }?>
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <!--------------会员卡购买记录列表---------------->
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                                    <th>公司名称</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                                    <th>会员昵称</th>
                                    <th>手机号</th>
                                    <?php }?>
                                    <th>会员卡号</th>
                                    <th>到期时间</th>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?>
                                    <th>状态</th>
                                    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==10380) {?>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>生日</th>
                                    <th>公司</th>
                                    <th>职位</th>
                                    <?php }?>
                                    <th>可消费次数</th>
                                    <th>操作</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>生日</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==10380) {?>
                                    <th>公司</th>
                                    <th>职位</th>
                                    <?php }?>
                                    <?php }?>
                                    <!--
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                    <th>备注</th>
                                    <?php }?>
                                    -->
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr class="oo_id_<?php echo $_smarty_tpl->tpl_vars['val']->value['oo_id'];?>
">
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                                    <th><?php echo $_smarty_tpl->tpl_vars['val']->value['ajc_company_name'];?>
</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1||$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==10380) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['m_mobile'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_telphone'];?>
<?php }?></td>
                                    <?php }?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['om_card_num'];?>
</td>
                                    <td><?php echo date("Y.m.d",$_smarty_tpl->tpl_vars['val']->value['om_expire_time']);?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['om_expire_time']<=time()) {?>
                                         <span class="label label-sm label-default">已到期</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['om_left_num']==0) {?>
                                        <span class="label label-sm label-default">已消费完</span>
                                        <?php } else { ?>
                                        <span class="label label-sm label-success">正常使用中</span>
                                        <?php }?></td>
                                    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==10380) {?>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['oo_name'];?>

                                    </td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['oo_gender']==0) {?>女<?php } else { ?>男<?php }?>
                                    </td>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['oo_birthday'];?>

                                    </td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_company'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_position'];?>
</td>
                                    <?php }?>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['om_left_num'];?>
次
                                    </td>
                                    <td><a href="/wxapp/membercard/verify?mid=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" >消费记录</a></td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['oo_name'];?>

                                    </td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['oo_gender']==0) {?>女<?php } else { ?>男<?php }?>
                                    </td>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['oo_birthday'];?>

                                    </td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==10380) {?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_company'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_position'];?>
</td>
                                    <?php }?>
                                    <?php }?>
                                    <!--
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                    <td style="max-width: 300px;overflow: hidden;white-space: normal">
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['oo_remark'];?>

                                    </td>
                                    <?php }?>
                                    -->
                                    <td>
                                        <a href="javascript:void(0);" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['om_id'];?>
" class="btn-delete-mem-card" style="color:#f00;">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr><td colspan="10"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</td></tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出会员
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/membercard/importMemberCard" method="post">
                        <div class="form-group" style="height: 30px;">
                            <label class="col-sm-3 control-label">到期时间开始</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入会员到期日期"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group" style="height: 30px;margin-bottom: 30px">
                            <label class="col-sm-3 control-label">到期时间截止</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off"  type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入会员到期日期"/>
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
<script src="/public/plugin/layer/layer.js"></script>
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
       //删除会员卡
        $('.btn-delete-mem-card').on('click',function(){
            var id = $(this).data('id');
            if(id > 0){
                var data = { id:id };
                layer.confirm('确认要删除该会员卡会员？', {
                    btn: ['删除', '取消']
                }, function(){
                    $.ajax({
                        url : '/wxapp/membercard/deleteMemberCard',
                        type: 'post',
                        data : data,
                        dataType : 'json',
                        success : function(ret){
                            layer.msg(ret.em,{ time: 2000 },function(){
                                if(ret.ec == 200){
                                    window.location.reload();
                                }
                            });
                        }
                    });
                });
            }
        });
    });

    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });
</script><?php }} ?>

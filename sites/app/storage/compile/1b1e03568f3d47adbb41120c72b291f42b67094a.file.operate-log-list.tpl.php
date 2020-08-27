<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 09:19:53
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/manager/operate-log-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17262951185e4f30398a9db9-52142868%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b1e03568f3d47adbb41120c72b291f42b67094a' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/manager/operate-log-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17262951185e4f30398a9db9-52142868',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'managerList' => 0,
    'manager' => 0,
    'val' => 0,
    'start' => 0,
    'end' => 0,
    'list' => 0,
    'item' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f30398de3d9_92347995',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f30398de3d9_92347995')) {function content_5e4f30398de3d9_92347995($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/www/wwwroot/default/yingxiaosc/libs/view/smarty/libs/plugins/modifier.date_format.php';
?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/manager/operateLogList" method="get" class="form-inline" id="search-form-box">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">操作人</div>
                                <select id="cate" name="manager" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['managerList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option <?php if ($_smarty_tpl->tpl_vars['manager']->value==$_smarty_tpl->tpl_vars['val']->value['m_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="width: 600px">
                            <div class="input-group">
                                <div class="input-group-addon" >操作时间</div>
                                <input type="text" class="form-control" autocomplete="off" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                <input type="text" class="form-control" autocomplete="off" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>操作人</th>
                                <th>操作信息</th>
                                <th>操作时间</th>
                                <th>操作ip</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                            <tr id="tr_id_<?php echo $_smarty_tpl->tpl_vars['item']->value['mol_id'];?>
">
                                <td>
                                    <a href="#"><?php echo $_smarty_tpl->tpl_vars['item']->value['m_nickname'];?>
</a>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['mol_message'];?>
</td>
                                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['mol_create_time'],"%Y-%m-%d %H:%M:%S");?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['item']->value['mol_ip'];?>

                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class='text-center'>
                            <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

                        </div>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
    });
</script><?php }} ?>

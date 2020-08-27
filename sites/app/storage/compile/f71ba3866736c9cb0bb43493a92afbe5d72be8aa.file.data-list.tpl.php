<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:24:08
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/form/data-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6577431405e85a12877d568-54262874%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f71ba3866736c9cb0bb43493a92afbe5d72be8aa' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/form/data-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6577431405e85a12877d568-54262874',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'appletCfg' => 0,
    'dyyu' => 0,
    'sequenceShowAll' => 0,
    'formList' => 0,
    'val' => 0,
    'formid' => 0,
    'statInfo' => 0,
    'list' => 0,
    'v' => 0,
    'count' => 0,
    'showPage' => 0,
    'pagination' => 0,
    'vv' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e85a128839f22_35775227',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e85a128839f22_35775227')) {function content_5e85a128839f22_35775227($_smarty_tpl) {?><link rel="stylesheet" href="/public/plugin/viewer/viewer.min.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .balance .balance-info{
        width: 33.33% !important;
    }
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }

    .form-group .col-sm-8{
        min-height: 27px;
        line-height: 27px;
        margin-bottom: 5px;
    }
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }
    .datepicker {
        z-index: 1060 !important;
    }
</style>
<div id="content-con">
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=15&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=34&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32) {?>
    <?php if (!$_smarty_tpl->tpl_vars['dyyu']->value) {?>
    <div class="authorize-tip flex-wrap">
        <div class="shop-logo">
            <img src="/public/wxapp/setup/images/yuyue_icon.png" alt="logo">
        </div>
        <div class="flex-con">
            <h4>预约咨询功能</h4>
            <p class="state" style="color: #999;">
                <span>简化版的预约咨询功能,无需开通支付 </span>
                <?php if ($_smarty_tpl->tpl_vars['sequenceShowAll']->value==1) {?>
                <span>如果需要用户付费预约,请使用<a href="/wxapp/appointment/template" target="_blank">付费预约功能</a></span>
                <?php }?>
            </p>
        </div>
        <div>
            <a href="/wxapp/currency/appointmentList" class="btn btn-sm btn-default"> 切换旧版 </a>
        </div>
    </div>
    <?php }?>
    <?php } else { ?>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=34&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32) {?>
    <div>
        <a href="/wxapp/currency/appointmentList" class="btn btn-sm btn-blue" style="float: right"> 切换旧版 </a>
    </div>
    <?php }?>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==34) {?>
    <div class="alert alert-block alert-yellow ">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        审核通过后需前往骑手列表处添加骑手信息。骑手方可登录骑手APP。骑手APP可通过应用宝搜索“51同镇”
    </div>
    <?php }?>
    <a href="/wxapp/form/list" class="btn btn-sm btn-green" target="_blank" style="margin-bottom: 20px"> 自定义表单 </a>
    <a href="javascript:;" class="btn btn-blue btn-xs btn-excel" data-toggle="modal" data-target="#excelOrder" style="margin-bottom: 20px;height: 30px;line-height: 25px;"><i class="icon-download"></i>留言导出</a>

    <div class="introduce-tips" style="display:inline-block;min-width:400px;margin-left:20px;top:-8px;">
    	<div class="tips-btn">
    		<span>介绍</span><img src="/public/site/img/tips.png" alt="图标" />
    	</div>
    	<div class="tips-con-wrap">
    		<div class="tips-con">
        		<div class="triangle_border_up"><span></span></div>
        		<div class="con">功能使用说明：平台方收集一些用户信息、活动报名、客户登记、意见反馈、调查问卷等；
可以在①后台页面管理->主页管理->自定义首页->拖拽组件进行链接；②小程序管理->底部菜单处链接
</div>
        	</div>
    	</div>
    </div>

    <div class="page-header search-box" style="margin-bottom: 20px;margin-top: 0;">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/form/formData" method="get">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">所属表单</div>
                                <select class="form-control" name="formid">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['formList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['acf_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['acf_id']==$_smarty_tpl->tpl_vars['formid']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['acf_header_title'];?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <!-- 汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">总留言数<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">待处理<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['notDone'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已处理<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['done'];?>
</span>
            </div>
        </div>
    </div>
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>表单信息</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                提交时间
                            </th>
                            <th>处理情况</th>
                            <th>处理备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['acfd_id'];?>
">
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
" alt="" style="width: 50px;height: 50px;border-radius: 4px;"/></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                <td class="viewer">
                                    <div style="height: 60px;overflow: hidden;width: 100%;padding-left: 15px;white-space: normal;">
                                        <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(0, null, 0);?>
                                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = json_decode($_smarty_tpl->tpl_vars['val']->value['acfd_data'],true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                                        <?php if ($_smarty_tpl->tpl_vars['v']->value['type']!='submit'&&$_smarty_tpl->tpl_vars['v']->value['type']!='intro') {?>
                                        <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?>
                                        <?php if ($_smarty_tpl->tpl_vars['v']->value['type']=='upload') {?>
                                        <div class="form-group row" style="margin-bottom: 0">
                                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align:left;font-size: 12px;padding: 0;margin: 0"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                                            <div class="col-sm-8" style="min-height: 20px;line-height: 17px;">
                                                <div><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
" data-original="<?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
" alt="" style="width: 100px;"/></div>
                                            </div>
                                        </div>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']=='map') {?>
                                        <div class="form-group row" style="margin-bottom: 0">
                                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align:left;font-size: 12px;padding: 0;margin: 0"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                                            <div class="col-sm-8" style="min-height: 20px;line-height: 17px;">
                                                <div style="font-size: 12px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['value'][0];?>
</div>
                                            </div>
                                        </div>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']=='checkbox') {?>
                                        <div class="form-group row" style="margin-bottom: 0">
                                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align:left;font-size: 12px;padding: 0;margin: 0"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                                            <div class="col-sm-8" style="min-height: 20px;line-height: 17px;">
                                                <div style="font-size: 12px;">
                                                    <?php echo implode(',',$_smarty_tpl->tpl_vars['v']->value['value']);?>

                                                </div>
                                            </div>
                                        </div>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']=='verifyCode') {?>
                                        <div class="form-group row" style="margin-bottom: 0">
                                            <label class="control-label no-padding-right" for="qq-num" style="text-align:left;font-size: 12px;padding: 0;margin: 0"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                                            <div class="col-sm-8" style="min-height: 20px;line-height: 17px;">
                                                <div style="font-size: 12px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['value']['mobile'];?>
</div>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div class="form-group row" style="margin-bottom: 0">
                                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align:left;font-size: 12px;padding: 0;margin: 0"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                                            <div class="col-sm-8" style="min-height: 20px;line-height: 17px;">
                                                <div style="font-size: 12px;"><?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
</div>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <?php }?>
                                        <?php } ?>
                                    </div>
                                    <?php if ($_smarty_tpl->tpl_vars['count']->value>3) {?>
                                    <p style="padding-left:4px;margin-bottom: -5px;margin-top: 3px;" onclick="showchange(this)"><a href="JavaScript:;">查看更多</a></p>
                                    <?php }?>
                                </td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['acfd_create_time']);?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['acfd_processed']==1) {?>
                                <td style="color: green">已处理</td>
                                <?php } else { ?>
                                <td style="color: red">未处理</td>
                                <?php }?>
                                <td style="white-space: normal;max-width:300px;"><?php echo $_smarty_tpl->tpl_vars['val']->value['acfd_remark'];?>
</td>
                                <td style="color:#ccc;">
                                    <a href="#" data-toggle="modal" data-target="#myModal<?php echo $_smarty_tpl->tpl_vars['val']->value['acfd_id'];?>
">详情</a> -
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['acfd_processed']==0) {?>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#dealModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acfd_id'];?>
">处理</a> -
                                    <?php }?>
                                    <a class="delete-btn" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acfd_id'];?>
" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->

            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<?php if ($_smarty_tpl->tpl_vars['showPage']->value!=0) {?>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</div>
            </div>
        </div>
    </div>
</div>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
<div class="modal fade" id="myModal<?php echo $_smarty_tpl->tpl_vars['val']->value['acfd_id'];?>
" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    提交信息
                </h4>
            </div>
            <div class="modal-body">
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = json_decode($_smarty_tpl->tpl_vars['val']->value['acfd_data'],true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['type']!='submit'&&$_smarty_tpl->tpl_vars['v']->value['type']!='intro') {?>
                        <?php if ($_smarty_tpl->tpl_vars['v']->value['type']=='upload') {?>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                            <div class="col-sm-8">
                                <div><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
" alt="" style="width: 100px"/></div>
                            </div>
                        </div>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']=='map') {?>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                            <div class="col-sm-8">
                                <div><?php echo $_smarty_tpl->tpl_vars['v']->value['value'][0];?>
</div>
                            </div>
                        </div>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']=='checkbox') {?>
                        <div class="form-group row" style="margin-bottom: 0">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                            <div class="col-sm-8">
                                <div>
                                    <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['v']->value['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                                    <?php echo $_smarty_tpl->tpl_vars['vv']->value;?>
<br/>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']=='verifyCode') {?>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                            <div class="col-sm-8">
                                <div><?php echo $_smarty_tpl->tpl_vars['v']->value['value']['mobile'];?>
</div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><?php echo $_smarty_tpl->tpl_vars['v']->value['data']['title'];?>
：</label>
                            <div class="col-sm-8">
                                <div><?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
</div>
                            </div>
                        </div>
                        <?php }?>
                    <?php }?>
                <?php } ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php } ?>
<div class="modal fade" id="dealModal" tabindex="-1" role="dialog" aria-labelledby="dealModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="dealModalLabel">
                    处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="8" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出留言
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form class="form-horizontal" enctype="multipart/form-data" action="/wxapp/form/importMessage" method="post">
                        <div class='form-group'>
                            <label class='col-sm-2 control-label'>所属表单</label>
                            <div class='col-sm-10'>
                                <select class="form-control" name="formid">
                                    <option value="0">请选择所属表单</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['formList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['acf_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['acf_id']==$_smarty_tpl->tpl_vars['formid']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['acf_header_title'];?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" autocomplete="off" name="startDate" placeholder="请输入开始日期"/>
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd" autocomplete="off" name="endDate" placeholder="请输入结束日期"/>
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 20px;"></div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/viewer/viewer.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
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

        $('.viewer').viewer({url:"data-original"}); //预览图片

    })

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var data = {
            id : hid,
            market : market
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/form/handleAppointment',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });

    function showchange(e){
        $(e).prev().css('overflow', 'inherit');
        $(e).hide();
    }


    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
		layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
           	var loading = layer.load(2);
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/form/delFormData',
	            'data'  : {id: id},
	            'dataType' : 'json',
	            success : function(ret){
	                layer.close(loading);
	                layer.msg(ret.em);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }
	            }
	        });
        });
    })
</script>
<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:39:51
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/customer/chat-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9429286535e86a1f75dda08-43300459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c57fbef1a35d515084fc48d354a88c25d45b6b93' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/customer/chat-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9429286535e86a1f75dda08-43300459',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'start' => 0,
    'end' => 0,
    'postCategory' => 0,
    'val' => 0,
    'categoryId' => 0,
    'shopCategory' => 0,
    'list' => 0,
    'curr_shop' => 0,
    'page_html' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86a1f7635c66_61175545',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86a1f7635c66_61175545')) {function content_5e86a1f7635c66_61175545($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .nickname{
        padding-left: 3px;
    }


</style>
<div id="content-con">
    <div  id="mainContent" >

        <!--
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/customer/index" method="get" class="form-inline">
                    <input type="hidden" name="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group" style="width:580px;">
                                <div class="input-group" style="width:100%;">
                                    <div class="start-endtime">
                                        <em style="width:70px;text-align:center">收益时间：</em>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                        </div>
                                        <em style="padding:0 3px;">到</em>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">类型</div>
                                    <select  class="form-control" name="categoryId">
                                        <option value="0">全部</option>
                                        <?php if ($_smarty_tpl->tpl_vars['type']->value==1) {?>
                                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['postCategory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['categoryId']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                                            <?php } ?>
                                        <?php } else { ?>
                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['shopCategory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"  <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['categoryId']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                                        <?php } ?>
                                        <?php }?>
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
        -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>用户</th>
                            <th style="min-width: 300px">内容</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['sc_from']) {?>
                                <td>
                                    <img style="width: 50px;" src="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_logo']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_logo'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_200_200.png<?php }?>" alt="">
                                    <span class="nickname">客服</span>
                                </td>
                                <?php } else { ?>
                                <td>
                                    <img style="width: 50px;" src="<?php if ($_smarty_tpl->tpl_vars['val']->value['m_avatar']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
<?php } else { ?>/public/wxapp/images/applet-avatar.png<?php }?>" alt="">
                                    <span class="nickname"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</span>
                                </td>
                                <?php }?>
                                <td style="min-width: 300px">
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['sc_type']==1) {?>
                                <img style="width: 150px;" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['sc_content'];?>
" alt="">
                                <?php } else { ?>
                                <?php echo $_smarty_tpl->tpl_vars['val']->value['sc_content'];?>

                                <?php }?>
                                </td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['sc_create_time']);?>
</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
            <?php echo $_smarty_tpl->tpl_vars['page_html']->value;?>

        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<?php }} ?>

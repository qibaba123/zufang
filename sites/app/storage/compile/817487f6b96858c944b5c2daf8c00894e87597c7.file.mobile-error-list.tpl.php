<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:11:24
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mobile/mobile-error-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15691274465e869b4cd06383-02490348%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '817487f6b96858c944b5c2daf8c00894e87597c7' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mobile/mobile-error-list.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15691274465e869b4cd06383-02490348',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e869b4cd43ce5_77188000',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e869b4cd43ce5_77188000')) {function content_5e869b4cd43ce5_77188000($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>报错人</th>
                            <th>报错人头像</th>
                            <th>店铺名称</th>
                            <th>报错原因</th>
                            <th>报错时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['mse_id'];?>
">
                                <td style="max-width: 120px"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
" width="50"></td>
                                <td style="max-width: 300px"><?php echo $_smarty_tpl->tpl_vars['val']->value['ams_name'];?>
</td>
                                <td style="max-width: 500px"><?php echo $_smarty_tpl->tpl_vars['val']->value['mse_remark'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['mse_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['mse_time']);?>
<?php }?></td>
                                <td class="jg-line-color">
                                    <a href="/wxapp/mobile/shopEdit/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['mse_ams_id'];?>
" >查看店铺</a> - 
                                    <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['mse_id'];?>
" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="6"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function confirmDelete(ele) {
        var id = $(ele).data('id');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/mobile/deleteError',
	                'data'  : { id:id},
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
    }
</script>
<?php }} ?>

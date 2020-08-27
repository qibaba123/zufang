<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:46:08
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/help-center-info-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18049643675e4df2f06553a3-06075695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a50ca31bbea61e53d490382e77bb7c93083c547' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/help-center-info-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18049643675e4df2f06553a3-06075695',
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
  'unifunc' => 'content_5e4df2f067c9b6_60682313',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df2f067c9b6_60682313')) {function content_5e4df2f067c9b6_60682313($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
</style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="alert alert-block alert-yellow " >
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            可在小程序端个人中心处查看
        </div>
        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="/wxapp/currency/helpCenterInfoEdit" ><i class="icon-plus bigger-80"></i> 添加</a>

        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>排序权重</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['ahci_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ahci_title'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ahci_sort'];?>
</td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['ahci_update_time']);?>
</td>
                                <td>
                                    <a href="/wxapp/currency/helpCenterInfoEdit?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['ahci_id'];?>
">编辑 - </a>
                                    <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ahci_id'];?>
" onclick="confirmDelete(this)" style="color: red">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="4" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>


    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/currency/helpCenterInfoDelete',
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



</script><?php }} ?>

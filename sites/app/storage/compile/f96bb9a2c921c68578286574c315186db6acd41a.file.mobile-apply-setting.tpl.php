<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:02:27
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/mobile/mobile-apply-setting.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7418040745e4e6743e63579-01247246%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f96bb9a2c921c68578286574c315186db6acd41a' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/mobile/mobile-apply-setting.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7418040745e4e6743e63579-01247246',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6743e922b2_00201141',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6743e922b2_00201141')) {function content_5e4e6743e922b2_00201141($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="" data-weight="" ><i class="icon-plus bigger-80"></i> 添加收费配置</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>入驻月数</th>
                            <th>入驻费用</th>
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
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['mac_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['mac_data'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['mac_cost'];?>
</td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['mac_update_time']);?>
</td>
                                <td class="jg-line-color">
                                    <a class="add-cost" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['mac_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['mac_data'];?>
" data-weight="<?php echo $_smarty_tpl->tpl_vars['val']->value['mac_cost'];?>
">编辑</a> - 
                                    <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['mac_id'];?>
" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="4" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻时间：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写入驻时间" style="height:auto!important" type="number"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                    <div class="col-sm-8">
                    <span style="font-size: 12px;color: #666">入驻时间以“月”为单位，一年即12个月。</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻费用：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="请填写费用" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.add-cost').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        $('#category-weight').val($(this).data('weight'));
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var date   = $('#category-name').val();
        var cost = $('#category-weight').val();

        if(cost < 0){
            layer.msg('入驻费用填写有误');
            return false;
        }

        var data = {
            id     : id,
            date   : date,
            cost   : cost
        };
        if(date){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/saveApplySet',
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

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/mobile/deleteApplySet',
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

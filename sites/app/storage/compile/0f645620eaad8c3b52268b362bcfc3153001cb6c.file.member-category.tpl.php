<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:56:59
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/member/member-category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1285012805e4df57bde1524-96719483%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0f645620eaad8c3b52268b362bcfc3153001cb6c' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/member/member-category.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1285012805e4df57bde1524-96719483',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'currType' => 0,
    'key' => 0,
    'val' => 0,
    'list' => 0,
    'appletCfg' => 0,
    'pagination' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df57be22093_18385844',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df57be22093_18385844')) {function content_5e4df57be22093_18385844($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs add-category" href="#" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加分类</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <!--
                <div class="choose-state">
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                <a href="/wxapp/reservation/goodsCategory" <?php if ($_smarty_tpl->tpl_vars['currType']->value&&$_smarty_tpl->tpl_vars['currType']->value==$_smarty_tpl->tpl_vars['key']->value) {?>class="active"<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</a>
                <?php } ?>
                </div>
                -->
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>分类名称</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['mc_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['mc_name'];?>
</td>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['mc_update_time']);?>
</td>
                                <td style="color:#ccc;">
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['mc_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['mc_name'];?>
" data-weight="0" >编辑</a>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==34) {?>
                                     - <a class="" href="/wxapp/legwork/memberLegworkPriceCfg?memberCate=<?php echo $_smarty_tpl->tpl_vars['val']->value['mc_id'];?>
"  >配送费用</a>
                                    <?php }?>
                                     - <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['mc_id'];?>
" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr><td colspan="3" class='text-right'><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
                    添加分类
                </h4>
            </div>
            <div class="modal-body">
                <!--
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类类型：</label>
                    <div class="col-sm-8">
                        <div>
                            <select name="category-type" id="category-type" class="form-control">
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['currType']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                -->
                <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['currType']->value;?>
" name="category-type" id="category-type" >
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
                    </div>
                </div>
                <!--
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类排序：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="数字越大，排序越靠后" style="height:auto!important"/>
                    </div>
                </div>
                -->
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
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
//        $('#category-weight').val($(this).data('weight'));
    });
    $('.add-category').on('click',function () {
        $('#hid_id').val('');
        $('#category-name').val('');
//        $('#category-weight').val('');
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#category-name').val();
//        var weight = $('#category-weight').val();
        var data = {
            id     : id,
            name   : name,
//            weight : weight,
        };
        
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/memberCategorySave',
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
        layer.confirm('确定删除吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/member/memberCategoryDelete',
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

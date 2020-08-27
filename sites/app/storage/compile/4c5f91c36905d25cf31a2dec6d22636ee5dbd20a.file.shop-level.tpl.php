<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:09:51
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/shop-level.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2601994455dea1adf521e28-89989432%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c5f91c36905d25cf31a2dec6d22636ee5dbd20a' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/shop-level.tpl',
      1 => 1575623389,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2601994455dea1adf521e28-89989432',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'item' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1adf562d73_00561898',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1adf562d73_00561898')) {function content_5dea1adf562d73_00561898($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/mnt/www/default/duodian/tdtinstall/libs/view/smarty/libs/plugins/modifier.date_format.php';
?><link rel="stylesheet" href="/public/manage/css/member-list.css">
<style>
	.table-bordered>thead>tr>th,.table-bordered>tbody>tr>td{border:none;border-bottom:1px solid #ddd;}
</style>
<div>
    <div class="page-header">
        <button  class="btn btn-green btn-modal" data-type="edit" role="button"><i class="icon-plus bigger-80"></i> 添加</button>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>等级名称</th>
                        <th>最大商品发布数量</th>
                        <th>权重</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            创建时间
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <tr id="tr_id_<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_id'];?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['esl_name'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['item']->value['esl_max_goods']>0) {?><?php echo $_smarty_tpl->tpl_vars['item']->value['esl_max_goods'];?>
<?php } else { ?>无限制<?php }?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['esl_weight'];?>
</td>
                            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['esl_create_time'],"%Y-%m-%d %H:%M:%S");?>
</td>
                            <td class="jg-line-color">
                                <a href="javascript:;" class="btn-modal"
                                        data-type="edit"
                                        data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_id'];?>
"
                                        data-name="<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_name'];?>
"
                                        data-desc="<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_desc'];?>
"
                                        data-maxgoods="<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_max_goods'];?>
"
                                        data-weight="<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_weight'];?>
"
                                >

                                    编辑
                                </a>
                                -
                                <a href="javascript:;" class="btn-del" data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['esl_id'];?>
" style="color:#f00;">
                                    删除
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加/编辑商家等级</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hid_id" value="0">
                    <table class="table table-bordered form-inline">
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 商家等级名称 </td>
                            <td><input type="text" class="form-control" required="required" id="name" placeholder="商家级别名称" ></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 等级描述说明 </td>
                            <td><textarea type="text" class="form-control" id="desc" placeholder="对该等级的简单介绍" ></textarea></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> 最大商品发布数量 </td>
                            <td><input type="number" min="0" class="form-control" id="maxgoods" >件<span style="font-size: 13px;color: #999;">&nbsp;&nbsp;0或不填表示无限制</span></td>
                        </tr>
                        <!--<tr>
                            <td class="success td-title col-xs-4"> 或 </td>
                            <td><span>累计消费</span><input type="number" min="0" class="form-control" id="money" >元</td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 商家折扣 </td>
                            <td><input type="number" class="form-control" required="required" id="discount" oninput="limitDiscount(this)" placeholder="商家折扣">折<span style="font-size: 13px;color: #999;">（商家购买商品时的折扣）</span></td>
                        </tr>-->
                        <tr>
                            <td class="success td-title col-xs-4"> 等级权重(数字) </td>
                            <td><input type="number" min="0" size="6" class="form-control" id="weight" oninput="this.value=this.value.replace(/\D/g,'')"><span style="font-size: 13px;color: #999;">数字越大排序越靠前</span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary save-btn">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<style type="text/css">
    .td-title{
        text-align: right;
    }
    .form-inline input[type="number"]{
        width: 100px;
        height: 24px;
        line-height: 24px;
        margin: 0 5px;
        font-size: 12px;
        padding: 0 10px;
    }
</style>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    function limitDiscount(e){
        if($(e).val()>10){
            $(e).val(10);
        }
    }
    $('.btn-modal').on('click',function(){
        var type = $(this).data('type');
        var id= 0,name='',desc='',price='',maxGoods='',weight='';
        if(type == 'edit'){
            id      = $(this).data('id');
            name    = $(this).data('name');
            desc    = $(this).data('desc');
            maxGoods  = $(this).data('maxgoods');
            weight  = $(this).data('weight');
        }else{

        }
        $('#hid_id').val(id);
        $('#name').val(name);
        $('#desc').val(desc);
        $('#maxgoods').val(maxGoods);
        $('#weight').val(weight);
        $('#modal-info-form').modal('show');
    });
    $('.save-btn').on('click',function(){
        var id      = $('#hid_id').val();
        var name    = $('#name').val();
        var desc    = $('#desc').val();
        var maxGoods = $('#maxgoods').val();
        var weight  = $('#weight').val();
//        if(maxGoods <= 0){
//            layer.msg('最大商品数量需大于零');
//            return false;
//        }

        if(name && desc){ //(sale || down || traded || price || money)
            var data = {
                'id'    : id,
                'name'  : name,
                'desc'  : desc,
                'maxGoods' : maxGoods,
                'weight': weight
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/saveLevel',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }else{
            layer.msg('请完善表单');
        }
    });
    $('.btn-del').on('click',function(){
        var id = $(this).data('id');
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                'id'    : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/delLevel',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        $('#tr_id_'+id).remove();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script><?php }} ?>

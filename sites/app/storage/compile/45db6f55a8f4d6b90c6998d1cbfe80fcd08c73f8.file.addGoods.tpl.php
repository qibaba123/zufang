<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:11:00
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/goodsratio/addGoods.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3567156375e4e69447b3065-96749727%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45db6f55a8f4d6b90c6998d1cbfe80fcd08c73f8' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/goodsratio/addGoods.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3567156375e4e69447b3065-96749727',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'curr_shop' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
    'goodsList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e69447f8200_19305805',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e69447f8200_19305805')) {function content_5e4e69447f8200_19305805($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    .chosen-container {
        width: 100%!important;
    }
    .chosen-container-multi .chosen-choices{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .chosen-container-single .chosen-single{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
        height: 34px;
        background: url();
        background-color: #fff;
    }
    .chosen-container-single .chosen-single span{
        margin-top: 2px;
    }
    .chosen-single div b:before{
        top:3px;
    }
    select.form-control {
        padding: 5px 6px;
        height: 34px;
    }
</style>

<div id="content-con">
    <div  id="mainContent" >
        <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <div class="alert alert-block alert-yellow ">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            无上下级关系绑定，一次性分享赚钱，A可以分享给B，B也可以分享给A，订单完成，佣金结算，关系结束
        </div>
        <div class="alert alert-block alert-green" style="line-height: 30px;color: #888">
         <span class='tg-list-item'>
             是否开启单品分销
             <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus()" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value&&$_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_deduct']) {?>checked<?php }?> >
             <label class='tgl-btn' for='audit_status'></label>
         </span>
        </div>
        <div class="page-header">
            <a class="btn btn-green btn-xs fxGoods" href="#"><i class="icon-plus bigger-80"></i>添加单品分销</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>商品名称</th>
                            <th>购买人返现比例</th>
                            <th>上级提成比例</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['grd_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
</td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['grd_0f_ratio'];?>

                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['grd_1f_ratio'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['grd_is_used']) {?>
                                    <span style="color: green">开启</span>
                                    <?php } else { ?>
                                    <span style="color: red">关闭</span>
                                    <?php }?></td>
                                <td class="jg-line-color">
                                    <a class="confirm-handle fxGoods" href="#" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
"
                                       data-ratio_0="<?php echo $_smarty_tpl->tpl_vars['val']->value['grd_0f_ratio'];?>
"
                                       data-ratio_1="<?php echo $_smarty_tpl->tpl_vars['val']->value['grd_1f_ratio'];?>
"
                                       data-used="<?php echo $_smarty_tpl->tpl_vars['val']->value['grd_is_used'];?>
" >编辑</a> - 
                                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['grd_id'];?>
" onclick="confirmDelete(this)" style="cursor: pointer;color:#f00;">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

    <div id="modal-info-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:500px;;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger" id="modal-title">佣金配置设置</h4>
                </div>

                <div class="modal-body" style="overflow: hidden;height: 400px">
                    <input type="hidden" class="form-control" id="hid-id">
                    <input type="hidden" class="form-control" id="hid-type" value="deduct">
                    <!--分佣比例设置-->
                    <div id="threeSale" class="tab-div">
                        <div class="alert alert-block alert-yellow">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            若未开启，或者未设置，则按 店铺 佣金配置进行分销!
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div id="home"  class="tab-pane in active">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">分销商品</div>
                                        <div style="width: 375px">
                                            <select class="form-control selectpicker chosen-select" id="g_id" name="g_id"  data-live-search="true"  data-need="required" data-placeholder="请选择分销商品" >
                                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goodsList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                            <!--<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>
</option>-->
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
</option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">购买人返现比例</div>
                                        <input type="text" class="form-control" id="ratio_0" placeholder="返现比例百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">上级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_1" placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <div class="input-group col-sm-3" style="padding: 0">
                                    <div class="input-group-addon"> 是否开启 : &nbsp;</div>
                                    <label class="input-group-addon" id="choose-yesno" style="padding: 4px 10px;margin: 0;border: 1px solid #D5D5D5;">
                                        <input name="used" class="ace ace-switch ace-switch-5" id="used"  type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save" onclick="saveRatio()">保存</button>
                </div>
            </div>
        </div>
    </div>    <!-- MODAL ENDS -->

<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>

    $(function(){
        // 搜索选择下拉框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
        });

    });

    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            var name = $(this).data('name');
            $('.chosen-single span').text(name);
            $('#hid-id').val(gid);
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }
        }else{
            $('#hid-id').val();
        }
        show_modal_content('threeSale',gid);
        $('#modal-info-form').modal('show');

    });

    function show_modal_content(id,gid){
        $('.tab-div').hide();
        $('#'+id).show();
        $('#hid-goods').val(gid);
        var title = '佣金配置设置',type='deduct';
        switch (id){
            case 'threeSale':
                title = '佣金配置设置';
                type  = 'deduct';
                break;
            case 'setPoint':
                title = '商品积分设置';
                type  = 'point';
                break;
        }
        $('#modal-title').text(title);
        $('#hid-type').val(type);
    }

    function saveRatio(){
        var gid = $('#hid-id').val();
        if(!gid){
            gid = $('#g_id').val();
        }
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goodsratio/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/goodsratio/delRatio',
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
	        });
        }
    }

    function changeAuditStatus() {
        var status = $('#audit_status').is(':checked');
        var data = {
            status : status ? 1 : 0
        };
        
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goodsratio/openGoodsDeduct',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(data.status==1){
                        layer.msg('启用成功');
                    }else{
                        layer.msg('关闭成功');
                    }
                }
            }
        });
    }
</script><?php }} ?>

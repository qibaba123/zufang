<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:46:07
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/information-card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18244610755e4df2ef2c9918-32004528%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85f97cf670cf5dfe9533e634e076accd2a777705' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/information-card.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18244610755e4df2ef2c9918-32004528',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'type' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df2ef304572_62796600',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df2ef304572_62796600')) {function content_5e4df2ef304572_62796600($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
	.table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd;}
</style>
    <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


    <div class="row" style="margin-left: 150px;margin-top: 20px;">
        <div class="col-sm-9" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-money bigger-110"></i>
                            付费会员类型
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/currency/getInformationMemberList">
                            <i class="green icon-th-large bigger-110"></i>
                            付费会员
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/currency/getInformationPayRecord">
                            <i class="green icon-cog bigger-110"></i>
                            资讯付费记录
                        </a>
                    </li>
                    <li>
                        <a href="/wxapp/currency/getInformationCardPayRecord">
                            <i class="green icon-cog bigger-110"></i>
                            会员购买记录
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="page-header">
                            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加会员类型</a>
                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>标题</th>
                                    <th>价格</th>
                                    <th>类型</th>
                                    <th>时长（天/月/年）</th>
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
                                    <tr id="tr_id_<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_id'];?>
">
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aic_title'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aic_money'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['val']->value['aic_type']];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aic_time'];?>
</td>
                                        <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['aic_create_time']);?>
</td>
                                        <td>
                                            <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_id'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_title'];?>
"  data-price="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_money'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_type'];?>
"data-time="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_time'];?>
">编辑</a>
                                            <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_id'];?>
" onclick="confirmDelete(this)" style="color:#f00;cursor: pointer;">删除</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
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
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">标题：</label>
                    <div class="col-sm-8">
                        <input id="card-name" class="form-control" placeholder="请填写标题，例如：日卡、月卡、年卡" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">价格：</label>
                    <div class="col-sm-8">
                        <input id="card-price" class="form-control" placeholder="请填写价格" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">类型：</label>
                    <div class="col-sm-8">
                        <select id="card-type" name="card-type" class="form-control">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">时间：</label>
                    <div class="col-sm-8">
                        <input id="card-time" class="form-control" placeholder="请填写会员卡时长，表示N天、N个月、N年" style="height:auto!important"/>
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
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#card-name').val($(this).data('title'));
        $('#card-price').val($(this).data('price'));
        $('#card-type').val($(this).data('type'));
        $('#card-time').val($(this).data('time'));
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#card-name').val();
        $('#card-price').val();
        $('#card-type').val();
        $('#card-time').val();
    });

    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var title   = $('#card-name').val();
        var price = $('#card-price').val();
        var type  = $('#card-type').val();
        var time  = $('#card-time').val();
        var data = {
            id    : id,
            title : title,
            price : price,
            type  : type,
            time  : time
        };
        console.log(data);
        if(title && price && type && time){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/saveInformationCardType',
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
        if(id){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/currency/deletedInformationCard',
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

</script><?php }} ?>

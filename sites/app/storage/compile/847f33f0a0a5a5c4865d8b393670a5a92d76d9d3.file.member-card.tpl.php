<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:08:48
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/community/member-card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:523106405e4df8406f4bb2-54045478%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '847f33f0a0a5a5c4865d8b393670a5a92d76d9d3' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/community/member-card.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '523106405e4df8406f4bb2-54045478',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'type' => 0,
    'pageHtml' => 0,
    'pagination' => 0,
    'cardSelectList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df840730503_34889673',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df840730503_34889673')) {function content_5e4df840730503_34889673($_smarty_tpl) {?><style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-community-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="content-con" style="padding-left: 130px;">
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <div class="tab-content"  style="z-index:1;">
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <div class="page-header">
                            <a href="javascript:;" class="btn btn-green btn-sm add-btn" data-toggle="modal" data-target="#editModal" >
                                添加会员卡
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <th>会员卡名称</th>
                                    <th>类型/时长</th>
                                    <th>所需积分</th>
                                    <th>折扣率</th>
                                    <th>权益</th>
                                    <th>须知</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
">
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['val']->value['oc_long_type']]['name'];?>
/<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_long'];?>
天</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_points'];?>
</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['ml_discount']>0) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['ml_discount'];?>
折<?php }?></td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_rights'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_notice'];?>
</td>
                                    <td style="color:#ccc;">
                                        <a href="javascript:;" data-toggle="modal" data-target="#editModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
" data-points="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_points'];?>
" class="edit-btn">编辑</a>-
                                        <a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
" class="del-btn" style="color:#f00;">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if ($_smarty_tpl->tpl_vars['pageHtml']->value) {?>
                                    <tr><td colspan="9"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    编辑会员卡
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">会员卡：</label>
                    <div class="col-sm-8">
                        <select name="member-card" id="member-card" class="form-control">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cardSelectList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name'];?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">所需积分：</label>
                    <div class="col-sm-8">
                        <input id="card-points" type="number" class="form-control" placeholder="请填写所需积分" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-info">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">

    $('.add-btn').on('click',function(){
        $("#member-card").val(0);
        $("#card-points").val(0);
        $("#member-card").attr("disabled",false);
    });

    $('.edit-btn').on('click',function(){
        $("#member-card").val($(this).data('id'));
        $("#card-points").val($(this).data('points'));
        $("#member-card").attr("disabled",true);
    });

    $('#confirm-info').on('click',function(){
        var data   = {
            'cardId'     : $("#member-card").val(),
            'points'     : $("#card-points").val(),
        };
        if(data.cardId > 0){
            var loading = layer.load(10, {
                shade: [0.6,'#666']
            });
            console.log(data);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/addPointMemberCard',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    })

    $('.del-btn').on('click',function(){
        var data   = {
            'cardId'     : $(this).data('id')
        };
        if(data.cardId > 0){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           	var loading = layer.load(10, {
	                shade: [0.6,'#666']
	            });
	           	console.log(data);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/community/delPointMemberCard',
	                'data'  : data,
	                'dataType' : 'json',
	                'success'   : function(ret){
	                    console.log(ret);
	                    layer.close(loading);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
                            window.location.reload();
	                    }
	                }
	            }); 
	        });
        }
    });

</script>



<?php }} ?>

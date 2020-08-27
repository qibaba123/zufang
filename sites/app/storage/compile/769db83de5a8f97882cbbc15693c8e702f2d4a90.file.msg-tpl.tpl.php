<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:19:07
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/service/msg-tpl.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6368171015e4dfaabf20da0-38251542%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '769db83de5a8f97882cbbc15693c8e702f2d4a90' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/service/msg-tpl.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6368171015e4dfaabf20da0-38251542',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'typeNote' => 0,
    'pageHtml' => 0,
    'curr_shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4dfaac013748_19718188',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4dfaac013748_19718188')) {function content_5e4dfaac013748_19718188($_smarty_tpl) {?><style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }

    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
</style>
<div>
    <div class="page-header" style="overflow:hidden">
        <div class="col-sm-12">
            <a class="btn btn-green btn-sm refresh-btn" href="/wxapp/service/msgSetting">
                <i class="icon-plus bigger-40"></i>  添加
            </a>
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>提示文本</button>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">关键字</th>
                        <th>回复类型</th>
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
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['asm_keyword'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['typeNote']->value[$_smarty_tpl->tpl_vars['val']->value['asm_type']];?>
</td>
                            <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['asm_update_time']);?>
</td>
                            <td class="jg-line-color">
                                <a href="/wxapp/service/msgSetting/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
">
                                    配置
                                </a> - 
                                <a href="javascript:;"
                                   data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" style="color:#f00;" class="del-btn">
                                    删除
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($_smarty_tpl->tpl_vars['pageHtml']->value) {?>
                        <tr><td colspan="5"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</td></tr>
                    <?php }?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    自动回复提示
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea class="form-control" id = "auto-reply-tips" name="auto-reply-tips" placeholder="提示文本"  rows="5"  ><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_auto_reply_tips'];?>
</textarea>
                    </div>
                </div>
                <div style="display: inline-block;vertical-align:  middle;">
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="tipsOpen" data-type="open" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value&&$_smarty_tpl->tpl_vars['curr_shop']->value['s_auto_reply_tips_open']) {?>checked<?php }?>>
                        <span class="lbl"></span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="conform-add">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/withdraw-list.js" ></script>

<script type="text/javascript" language="javascript">
    $('.del-btn').on('click',function(){
        var id = $(this).data('id');
    	layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
	            'id' : id
	        };
	        var index = layer.load(1, {
	            shade: [0.1,'#fff'] //0.1透明度的白色背景
	        },{time:10*1000});
	
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/service/delMessage',
	            'data'  : data,
	            'dataType'  : 'json',
	            success : function(json_ret){
	                layer.close(index);
	                layer.msg(json_ret.em);
	                if(json_ret.ec == 200){
	                    window.location.reload();
                    }
	            }
	
	        })
        });

    });

    // 提交信息
    $("#conform-add").click(function(){
        var tips = $('#auto-reply-tips').val();
        var open   = $('#tipsOpen:checked').val();
        if(open == 'on' && !tips){
            layer.msg('请填写提示信息');
            return false;
        }
        var data = {
            'tips'     : tips,
            'open'     : open
        };
        var index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            type: 'post',
            url: "/wxapp/service/saveAutoReplyTips" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    $('#myModal').modal('hide');
                }
            }
        });
    });


</script>
<?php }} ?>

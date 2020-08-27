<?php /* Smarty version Smarty-3.1.17, created on 2020-04-23 09:46:06
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/comment-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18391137215ea0f35e584c79-84880646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a328230815780320a44100429be6ba7fa00c3c58' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/comment-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18391137215ea0f35e584c79-84880646',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'appletCfg' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5ea0f35e5cda26_63477956',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ea0f35e5cda26_63477956')) {function content_5ea0f35e5cda26_63477956($_smarty_tpl) {?><link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/css/code.css?11">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/lrtk.css?1">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<div class="version-manage">
    <div class="version-item-box">
        <div class="code-version-title">
            <h3>评论列表</h3>
        </div>
        <div class="code-version-con">
            <?php if ($_smarty_tpl->tpl_vars['list']->value) {?>
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <tr>
                            <td>
                                <?php if (($_smarty_tpl->tpl_vars['val']->value['aic_reply_mid']>0&&$_smarty_tpl->tpl_vars['val']->value['rm_nickname'])||$_smarty_tpl->tpl_vars['val']->value['aic_reply_mid']==-1) {?>

                                <a href="#">
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['aic_m_id']==-1) {?>
                                    <?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_name'];?>

                                    <?php } else { ?>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>

                                    <?php }?>

                                </a> 回复 <a href="#">
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['aic_reply_mid']==-1) {?>
                                <?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_name'];?>

                                    <?php } else { ?>
                                <?php echo $_smarty_tpl->tpl_vars['val']->value['rm_nickname'];?>

                                    <?php }?>
                            </a> <?php echo $_smarty_tpl->tpl_vars['val']->value['aic_comment'];?>

                                <?php } else { ?>
                                <a href="#"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</a> 评论  <?php echo $_smarty_tpl->tpl_vars['val']->value['aic_comment'];?>

                                <?php }?>
                            </td>
                            <td><a href="#" style="color: red" id="delete-confirm" onclick="deletePostComment('<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_id'];?>
')" >删除</a>
                                <a href="#"  data-toggle="modal" data-target="#myModal" class="reply-comment" data-id="<?php if ($_smarty_tpl->tpl_vars['val']->value['aic_aic_id']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['aic_aic_id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['aic_id'];?>
<?php }?>" data-mid="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_m_id'];?>
" data-aid="<?php echo $_smarty_tpl->tpl_vars['val']->value['aic_ai_id'];?>
" >回复</a>
                            </td>
                        </tr>
                        <?php } ?>
                    <tr><td colspan="2"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
            <?php } else { ?>
            <div><p style="font-size: 18px">暂无评论信息</p></div>
            <?php }?>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="hid_mid" >
            <input type="hidden" id="hid_aid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    回复
                </h4>
            </div>
            <div class="modal-body" style="">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea name="reply-comment" id="reply-comment" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-reply">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.reply-comment').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#hid_mid').val($(this).data('mid'));
        $('#hid_aid').val($(this).data('aid'));
        $('#reply-comment').text('');
    });

    function deletePostComment(id) {
        //var id = $(this).data('id');
        console.log(id);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/currency/deleteInformationComment',
            'data'  : { aid:id},
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    $('#confirm-reply').on('click',function () {
        var cid = $('#hid_id').val();
        var mid = $('#hid_mid').val();
        var aid = $('#hid_aid').val();
        var content = $('#reply-comment').val();

        var data = {
          cid : cid,
          mid : mid,
          aid : aid,
          content : content
        };
        console.log(data);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/currency/replyInformationComment',
            'data'  : data,
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });

    })


</script><?php }} ?>

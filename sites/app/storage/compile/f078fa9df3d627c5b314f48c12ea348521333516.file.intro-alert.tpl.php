<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:34:23
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/layer/intro-alert.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10906736895e1be53fb7ec97-14406558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f078fa9df3d627c5b314f48c12ea348521333516' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/layer/intro-alert.tpl',
      1 => 1536116108,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10906736895e1be53fb7ec97-14406558',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'notice_alert' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be53fb88022_64716114',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be53fb88022_64716114')) {function content_5e1be53fb88022_64716114($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['notice_alert']->value) {?>
<style>
    .close{
        outline: none;
    }
    .contxt-wrap{
        font-size: 15px;
        line-height: 1.8;
        color: #666;
        min-height: 380px;
        max-height: 450px;
        overflow: auto;
        padding: 15px 20px;
    }
    .contxt-wrap p{
        margin: 0;
        text-indent: 2em;
    }
    .modal-dialog{
        padding-top: 5%;
    }
</style>
<div class="modal fade" id="myModalIntro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 650px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none;padding: 15px 20px;background-color: #f6f7f8">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalIntroLabel" style="font-size: 20px;padding-right:40px;" id="notice-alert-title">
                    <?php echo $_smarty_tpl->tpl_vars['notice_alert']->value['title'];?>

                </h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div class="contxt-wrap" id="notice-alert-content">
                    <?php echo $_smarty_tpl->tpl_vars['notice_alert']->value['content'];?>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
    $(function(){
        $(".contxt-wrap").niceScroll({
            cursorwidth:"7px",
            cursorborder:"0",
            cursorcolor:"#666",
            cursoropacitymax:"0.5",
            // autohidemode:false
        });
        //有未读信息
        if('<?php echo $_smarty_tpl->tpl_vars['notice_alert']->value['status'];?>
' == '200' ){
            $('#myModalIntro').modal('show');
        }
    })
</script>
<?php }?><?php }} ?>

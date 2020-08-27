<?php /* Smarty version Smarty-3.1.17, created on 2020-04-05 18:02:41
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/giftcard/coin-card-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8828873205e89acc10a45b5-27621564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7247a3986bdfb2a581f630f98a1135d0dade017' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/giftcard/coin-card-list.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8828873205e89acc10a45b5-27621564',
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
  'unifunc' => 'content_5e89acc10d8069_19788561',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e89acc10d8069_19788561')) {function content_5e89acc10d8069_19788561($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    .message-muban .form-horizontal .control-label{
        font-weight: bold;
        margin-bottom:0;
        line-height: 34px;
        padding-top: 0;
    }
    .message-muban select.form-control{
        height: 34px;
    }
    .message-fenlei{
        background-color: #f6f6f6;
        border:1px solid #e8e8e8;
        border-radius: 4px;
        margin-bottom: 10px;
        padding: 0 10px;
        padding-top: 15px;
    }
    .message-fenlei:last-child{
        margin-bottom: 0;
    }
    .message-fenlei .fenlei-name{
        font-size: 14px;
        line-height: 35px;
        font-weight: bold;
        border-right: 1px dashed #ddd;
        height: 35px;
        color: #02a802;
    }
    .modal-body{
        max-height: 650px;
        overflow: auto;
    }

    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }


</style>
<div id="content-con">

    <div  id="mainContent" style="margin-left: 130px;">

        <div class="page-header">
            <a href="/wxapp/giftcard/editCoinCard" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <thead>
                        <tr>
                            <!--
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            -->
                            <th>排序</th>
                            <th>封面图</th>
                            <th>名称</th>
                            <th>面值</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                添加时间
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr>
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['ba_id'];?>
"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agc_sort'];?>
</td>
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['agc_cover'];?>
" height="50"></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agc_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agc_coin'];?>
</td>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['agc_create_time']);?>
</td>
                                <td style="color:#ccc;">
                                    <p>
                                        <a href="/wxapp/giftcard/editCoinCard/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['agc_id'];?>
" >编辑</a>
                                        - <a href="javascript:;" onclick="deleteCard('<?php echo $_smarty_tpl->tpl_vars['val']->value['agc_id'];?>
')"  style="color:#f00;">删除</a>
                                    </p>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr><td colspan="11"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>

<script>

    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        // 
        layer.msg('复制成功');
        optshide();
    } );

    //删除
    function deleteCard(id) {
        layer.confirm('你确定要删除吗？', {
            btn: ['确定','取消'], //按钮
            title : '删除'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/giftcard/deleteCard',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

</script>
<?php }} ?>

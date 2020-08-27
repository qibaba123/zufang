<?php /* Smarty version Smarty-3.1.17, created on 2020-04-08 00:52:35
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/collection/audit-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14690959085e8cafd3c70420-74778599%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '753bac234075133fdcfb07b19ed51cbacf18d2bf' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/collection/audit-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14690959085e8cafd3c70420-74778599',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nickname' => 0,
    'status' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8cafd3cbcd06_88597676',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8cafd3cbcd06_88597676')) {function content_5e8cafd3cbcd06_88597676($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/collectionprize/check" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">用户昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
"  placeholder="用户昵称">
                                    <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="choose-state">
            <a href="/wxapp/collectionprize/check?status=1" <?php if ($_smarty_tpl->tpl_vars['status']->value==1) {?> class="active" <?php }?>>待审核</a>
            <a href="/wxapp/collectionprize/check?status=2" <?php if ($_smarty_tpl->tpl_vars['status']->value==2) {?> class="active" <?php }?>>已通过</a>
            <a href="/wxapp/collectionprize/check?status=3" <?php if ($_smarty_tpl->tpl_vars['status']->value==3) {?> class="active" <?php }?>>已拒绝</a>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>昵称</th>
                            <th>图片</th>
                            <th>提交时间</th>
                            <th>状态</th>
                            <th>处理备注</th>
                            <th>处理时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['acpa_id'];?>
">
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
" width="50"></td>
                                <td style="max-width: 120px"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                <td><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpa_collection_img'];?>
" rel="prettyPhoto[]"><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpa_collection_img'];?>
" width="50"></a></td>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['acpa_create_time']);?>
</td>
                                <td style="max-width: 120px">
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['acpa_status']==1) {?>
                                    <span style="color: red">待审核</span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['acpa_status']==2) {?>
                                    <span style="color: blue">已通过</span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['acpa_status']==3) {?>
                                    <span>已拒绝</span>
                                    <?php }?>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['acpa_deal_note'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['acpa_audit_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['acpa_audit_time']);?>
<?php }?></td>
                                <td>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpa_id'];?>
" data-reamrk="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpa_deal_note'];?>
">审核</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="9"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="remark" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>

<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        $("a[rel^='prettyPhoto']").prettyPhoto();
    });

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#remark').val($(this).data('remark'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var remark = $('#remark').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            remark : remark,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/collectionprize/handleApply',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });
</script>
<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:56:47
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/order/comment-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13639833495e4df56fdfe4f9-89033590%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f85c7345a16481c20ff8f08e7deb7c958fbfaf0f' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/order/comment-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13639833495e4df56fdfe4f9-89033590',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'nickname' => 0,
    'content' => 0,
    'sortType' => 0,
    'searchStatus' => 0,
    'start' => 0,
    'end' => 0,
    'status' => 0,
    'appletCfg' => 0,
    'list' => 0,
    'val' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df56fe521f0_46775030',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df56fe521f0_46775030')) {function content_5e4df56fe521f0_46775030($_smarty_tpl) {?><meta http-equiv="Content-Type" content="text/html; charset=utf8mb4" />
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css?2">
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
    .balance .balance-info{
        width: 16.66% !important;
    }
</style>
<!-- 汇总信息 -->
<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
    <div class="balance-info">
        <div class="balance-title">总评价数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">5分评价数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_5'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">4分评价数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_4'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">3分评价数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_3'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">2分评价数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_2'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">1分评价数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_1'];?>
</span>
        </div>
    </div>
</div>
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/order/commentList" method="get">
            <div class="col-xs-11 form-group-box" style='min-height: 60px;'>
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">评论人昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
"  placeholder="评论人微信昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">评论内容</div>
                            <input type="text" class="form-control" name="content" value="<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
"  placeholder="评论内容">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">排序</div>
                            <select name="sort_type" id="sort_type" class="form-control">
                                <option value="">最新评价</option>
                                <option value="star_desc" <?php if ($_smarty_tpl->tpl_vars['sortType']->value=='star_desc') {?> selected <?php }?>>评分最高</option>
                                <option value="star_asc" <?php if ($_smarty_tpl->tpl_vars['sortType']->value=='star_asc') {?> selected <?php }?>>评分最低</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">筛选</div>
                            <select name="search_status" id="search_status" class="form-control">
                                <option value="">全部</option>
                                <option value="had_reply" <?php if ($_smarty_tpl->tpl_vars['searchStatus']->value=='had_reply') {?> selected <?php }?>>已回复</option>
                                <option value="no_reply" <?php if ($_smarty_tpl->tpl_vars['searchStatus']->value=='no_reply') {?> selected <?php }?>>未回复</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="width:580px;">
                        <div class="input-group" style="width:100%;">
                            <div class="start-endtime">
                                <em style="width:70px;text-align:center">评论时间：</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                                <em style="padding:0 3px;">到</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>

<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>评论人</th>
                            <th>评论人头像</th>
                            <th>商品名称</th>
                            <th>订单号</th>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=18) {?>
                            <th>评分</th>
                            <?php }?>
                            <th>评论内容</th>
                            <th>评论时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
">
                                <td style="max-width: 120px"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
" width="50"></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gc_tid'];?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=18) {?>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gc_star'];?>
</td>
                                <?php }?>
                                <td style="max-width: 500px;overflow: hidden"><?php echo $_smarty_tpl->tpl_vars['val']->value['gc_content'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['gc_create_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['gc_create_time']);?>
<?php }?></td>
                                <td style="color:#ccc;">
                                    <a href="/wxapp/order/commentDetails/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['gc_id'];?>
">详情</a> -
                                    <?php if (!$_smarty_tpl->tpl_vars['val']->value['gc_reply']&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=18) {?>
                                    <a href="#" data-toggle="modal" data-target="#myModal" onclick="replyComment('<?php echo $_smarty_tpl->tpl_vars['val']->value['gc_id'];?>
')">回复</a> - 
                                    <?php }?>
                                    <a href="#" id="delete-confirm" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
" onclick="deleteComment('<?php echo $_smarty_tpl->tpl_vars['val']->value['gc_id'];?>
')" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="7"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    回复评论
                </h4>
                <input type="hidden" id="c_id" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">回复：</label>
                        <div class="col-sm-12">
                            <textarea name="comment_reply" id="comment_reply" class="form-control" rows="5" placeholder="请输入回复内容"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        确认回复
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>

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

    });
    function deleteComment(id) {
        //var id = $(this).data('id');
        console.log(id);
        layer.confirm('确定要删除此条评论吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var load_index = layer.load(2,
		            {
		                shade: [0.1,'#333'],
		                time: 10*1000
		            }
		        );
		        $.ajax({
		            'type'   : 'post',
		            'url'   : '/wxapp/order/deleteComment',
		            'data'  : { cid:id},
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
            });
    }

    function replyComment(id) {
        $('#c_id').val(id);
    }

    $('#conform-update').on('click',function () {
        var c_id = $('#c_id').val();
        var reply = $('#comment_reply').val();
        if(c_id){
            var data = {
                cid       : c_id,
                reply  : reply
            };
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/order/replyComment',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    })
</script>
<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:48:07
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/post-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15509489945dea15c764c8d1-33481403%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da33b530b48ef42fa90906d0744c3bd039ca7a77' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/post-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15509489945dea15c764c8d1-33481403',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl' => 0,
    'nickname' => 0,
    'cateSelect' => 0,
    'val' => 0,
    'cate' => 0,
    'content' => 0,
    'start' => 0,
    'end' => 0,
    'status' => 0,
    'list' => 0,
    'pagination' => 0,
    'costList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea15c76f6e15_95044237',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea15c76f6e15_95044237')) {function content_5dea15c76f6e15_95044237($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
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
    .zhiding{
        /*margin-left: 15px;
        border: 2px solid #FFEB3B;
        padding: 2px;
        background: #e99d93;*/
    }
    .set-top{
        min-width: 90px;
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
    .tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked + .lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked + .lbl::before{
        background-color: #06BF04;
        border-color:#06BF04;
    }
</style>
<div style="display: inline-block;vertical-align:  middle;margin-top: 15px;">
    是否显示发帖按钮:
    <label id="choose-onoff" class="choose-onoff">
        <input class="ace ace-switch ace-switch-5" id="showPublicBtn" data-type="open" onchange="showPublicBtn()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['tpl']->value['aci_show_public_btn']) {?>checked<?php }?>>
        <span class="lbl"></span>
    </label>
</div>
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/community/postList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">发帖人昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
"  placeholder="发帖人微信昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">帖子分类</div>
                            <select class="form-control" name="cate">
                                <option value="0">全部</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cateSelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['id']==$_smarty_tpl->tpl_vars['cate']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">发帖内容</div>
                            <input type="text" class="form-control" name="content" value="<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
"  placeholder="发帖内容">
                        </div>
                    </div>
                    <div class="form-group" style="width:580px;">
                        <div class="input-group" style="width:100%;">
                            <div class="start-endtime">
                                <em style="width:70px;text-align:center">发帖时间：</em>
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
							<th>发帖人头像</th>
                            <th>发帖人</th>                            
                            <th>帖子分类</th>
                            <th>帖子内容</th>
                            <th>发帖时间</th>
                            <th>帖子状态</th>
                            <th>是否置顶</th>
                            <th>置顶到期时间</th>
                            <th>是否已推送</th>
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
" class="tr-content">                                
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
" width="50" style="border-radius:4px;"></td>
                                <td style="max-width: 120px"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_name'];?>
</td>
                                <td style="max-width: 500px;overflow: hidden"><?php echo $_smarty_tpl->tpl_vars['val']->value['acp_content'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['acp_create_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['acp_create_time']);?>
<?php }?></td>
                                <td class="status-td"><?php if ($_smarty_tpl->tpl_vars['val']->value['acp_status']) {?>
                                    <span style="color: red">封禁</span>
                                    <!--<br><button class="btn btn-sm btn-success change-post-status" onclick="changePostStatus(<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
,0)">解封</button>-->
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus(<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
,0)" />
                                    <?php } else { ?>
                                    <span style="color: green">正常</span>
                                    <!--<br><button class="btn btn-sm btn-danger change-post-status" onclick="changePostStatus(<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
,1)">封禁</button>-->
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus(<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
,1)" />
                                    <?php }?>
                                </td>
                                <td  class="set-top" <?php if ($_smarty_tpl->tpl_vars['val']->value['acp_istop']==1&&$_smarty_tpl->tpl_vars['val']->value['acp_istop_expiration']>time()) {?>style="color: red"<?php }?>>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['acp_istop']==1&&$_smarty_tpl->tpl_vars['val']->value['acp_istop_expiration']>time()) {?>是<?php } else { ?>
                                	否 
                                <!--<a data-toggle="modal" data-target="#myTopModal" href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
" class="zhiding">置顶</a>-->
                                	<img src="/public/wxapp/images/icon_edit.png" class="good-admend zhiding" data-toggle="modal" data-target="#myTopModal" href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
" />
                                <?php }?>
                                </td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['acp_istop_expiration']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['acp_istop_expiration']);?>
<?php }?>
                                </td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['acp_push']) {?>已推送<?php } else { ?><span style="color:#333;">未推送</span><?php }?></td>
                                <td class="jg-line-color">                                   
                                    <p>
                                        <a href="javascript:;" onclick="pushPost('<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
')" >推送</a> -
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
')">预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=cpost&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
" >记录</a>
                                    </p>
                                    <p>
                                        <a href="/wxapp/community/postDetails/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
">详情</a> -                                      
                                        <a href="#" data-toggle="modal" data-target="#myModal" onclick="updatePost('<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_cate'];?>
')">修改</a> - 
                                    	<a href="#" id="delete-confirm" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
" onclick="deletePost('<?php echo $_smarty_tpl->tpl_vars['val']->value['acp_id'];?>
')" >删除</a>
                                    </p>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="10"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
                    修改帖子信息
                </h4>
                <input type="hidden" id="post_id" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">阅读量：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="post_show" id="post_show" placeholder="请输入增加的数量">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">点赞量：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="post_like" id="post_like" placeholder="请输入增加的数量">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">分类：</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="post_cate">
                                <option value="0">无分类</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cateSelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        确认修改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<!-- 模态框（置顶选项） -->
<div class="modal fade" id="myTopModal" tabindex="-1" role="dialog" aria-labelledby="myTopModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myTopModal">
                    置顶帖子
                </h4>
                <input type="hidden" id="pid" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">置顶时间：</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="cost_data">
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['costList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['act_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['act_data'];?>
天</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-top">
                        确认置顶
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>


<div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    推送预览
                </h4>
            </div>
            <div class="modal-body preview-page" style="overflow: auto">
                <div class="mobile-page ">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar">
                            消息模板预览
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="height: 380px;">
                                <div class="message">
                                    <h3 id="tpl-title"></h3>
                                    <p class="date" id="tpl-date"></p>
                                    <div class="item-txt"  id="tpl-content">

                                    </div>
                                    <div class="see-detail">进入小程序查看</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-footer"><span></span></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
    function deletePost(id) {
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
            'url'   : '/wxapp/community/deletePost',
            'data'  : { id:id},
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

    function pushPost(id) {

        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/postPush',
                'data'  : { id:id, type: 'community'},
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

    function updatePost(id,cate) {
        $('#post_id').val(id);
        $('#post_cate').val(cate)
    }

    $('#conform-update').on('click',function () {
        var post_id = $('#post_id').val();
        var post_show = $('#post_show').val();
        var post_like = $('#post_like').val();
        var post_cate = $('#post_cate').val();
        if(post_id){
            var data = {
                id       : post_id,
                showNum  : post_show,
                likeNum  : post_like,
                postCate : post_cate,
            };
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            console.log(data);
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/community/updatePost',
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

    //置顶功能
    $('.zhiding').on('click',function(){
        var id = $(this).data('id');
        if(id){
            $('#pid').val(id);
        }
    });
    $('#conform-top').on('click',function(){
        var id   = $('#pid').val();
        var cost = $('#cost_data').val();
        if(id && cost){
            var data = {
                'id'   : id,
                'cost' : cost
            };
            var load_index = layer.load(2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/community/updateCostTime',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em,{
                        time:1000
                    },function(){
                        window.location.reload();
                    });
                }
            });
        }
    });

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/postPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }

    function changePostStatus(id,status) {
        console.log(id);
        console.log(status);
        var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        var data = {
            pid : id,
            status : status
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/postStatusChange',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
                if(ret.ec == 200){
                    var str = '';
                    if(status == 1){
//                      str =  '<span style="color: red">封禁</span><br><button class="btn btn-sm btn-success change-post-status" onclick="changePostStatus('+id+',0)">解封</button>'
						str =  '<span style="color: red">封禁</span> <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus('+id+',0)" />'
                    }else{
//                      str =  '<span style="color: green">正常</span><br><button class="btn btn-sm btn-danger change-post-status" onclick="changePostStatus('+id+',1)">封禁</button>'
                    	str =  '<span style="color: green">正常</span> <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus('+id+',1)" />'
                    }
                    $('#tr_'+id).find('.status-td').html(str);
                }
                layer.close(load_index);
            }
        });
    }

    //是否显示发布按钮
    function showPublicBtn(obj){
        var v = $('#showPublicBtn:checked').val();
        console.log(v);
        var v = v == 'on' ? 1 : 0;
        var data = {
            'showPublicBtn' : v
        }
        $.ajax({
            type: 'POST',
            url : '/wxapp/community/showPublicBtn',
            data: data,
            dataType : 'json',
            success : function(res){
                if(res.ec == 400){
                    layer.msg(res.em,{ time : 2000 });
                }
            }
        });
    }

</script>
<?php }} ?>

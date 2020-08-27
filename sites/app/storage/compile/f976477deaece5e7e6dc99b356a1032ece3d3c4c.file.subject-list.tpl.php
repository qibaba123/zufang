<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:17:29
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/answer/subject-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3187460445e4dfa49592798-54823702%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f976477deaece5e7e6dc99b356a1032ece3d3c4c' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/answer/subject-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3187460445e4dfa49592798-54823702',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'type' => 0,
    'degree' => 0,
    'key' => 0,
    'degreeNum' => 0,
    'val' => 0,
    'list' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4dfa495d7926_34635591',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4dfa495d7926_34635591')) {function content_5e4dfa495d7926_34635591($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
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
    td{
        white-space: normal;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="content-con"  style="margin-left: 150px">

    <a href="/wxapp/answer/subject" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <a href="#" class="btn btn-green btn-sm" data-click-upload ><i class="icon-cloud-upload"></i>批量导入题目信息</a>
    <!--<div style="margin: 10px 0;border: 1px solid #ccc;width: 45%">
        <div class="input-group-addon" style="text-align: left;">导入题目信息</div>
        <div style="padding: 10px 20px">
            <form enctype="multipart/form-data" method="post" action="/wxapp/answer/excelSubject" >
                <label>选择导入的excel<font color="red">*</font></label>
                <div>
                    <input type="file" id="files" name="files" style="float: left"/>
                    <button type="submit" class="btn btn-green btn-sm">导入excel题目信息</button>
                </div>
            </form>
        </div>
    </div>-->
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/answer/subjectList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">题目</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="题目">
                                <input type="hidden" class="form-control" name="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" placeholder="题目">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">难易程度</div>
                                <select class="form-control" id="degree" name="degreeNum">
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['degree']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option value ="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['degreeNum']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                    <?php } ?>
                                </select>
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
        <?php if ($_smarty_tpl->tpl_vars['type']->value=='public') {?>
            <a href="/wxapp/answer/subjectList/type/pri" >私有题目</a>
            <a href="/wxapp/answer/subjectList/type/public" class="active">公共题目</a>
        <?php } else { ?>
            <a href="/wxapp/answer/subjectList/type/pri" class="active" >私有题目</a>
            <a href="/wxapp/answer/subjectList/type/public" >公共题目</a>
        <?php }?>

    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-hover table-avatar">
                            <tr>
                                <th>题目</th>
                                <th>答案</th>
                                <th>选项一</th>
                                <th>选项二</th>
                                <th>选项三</th>
                                <th>选项四</th>
                                <th>难度系数(越大越难)</th>
                                <th>添加时间</th>
                                <?php if ($_smarty_tpl->tpl_vars['type']->value=='pri') {?>
                                <th>操作</th>
                                <?php }?>
                            </tr>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_question'];?>
</td>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_answer'];?>
</td>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_item1'];?>
</td>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_item2'];?>
</td>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_item3'];?>
</td>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_item4'];?>
</td>
                                <td style="white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['as_degree'];?>
</td>
                                <td style="white-space: normal;"><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['as_create_time']);?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['type']->value=='pri') {?>
                                    <td style="white-space: normal;" class="jg-line-color">
                                    <a href="/wxapp/answer/subject/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['as_id'];?>
">编辑</a> -
                                    <a href="javascript:;" onclick="deleteSubject(this)" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['as_id'];?>
" class="btn-del" style="color:#f00;">删除</a>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php } ?>
                        <tr><td colspan="9" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<!-- 批量导入题目文件弹框 -->
<div id="bulk_shipment" style="display: none;padding:5px 20px;">
    <div class="upload-tips">
        <form action="/wxapp/answer/excelSubject" enctype="multipart/form-data" method="post">
            <label style="height:35px;line-height: 35px;">本地上传</label>
            <span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="files" type="file"></span>
            <p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传Excel类型的文件</p>
            <div style="font-size: 14px;margin-top: 10px;" >注意　<span id="show-notice">最大支持 1 MB Excel的文件。</span></div>
            <div style="font-size: 14px;margin-top: 10px;" ><a href="/public/common/答题题目样本.xlsx" id="show-notice">下载批量导入题目模板</a></div>
        </form>
    </div>
</div>
<style>
    .layui-layer-btn{
        border-top: 1px solid #eee;
    }
    .upload-tips{
        /* overflow: hidden; */
    }
    .upload-tips label{
        display: inline-block;
        width: 70px;
    }
    .upload-tips p{
        display: inline-block;
        font-size: 13px;
        margin:0;
        color: #666;
        margin-left: 10px;
    }
    .upload-tips .upload-input{
        display: inline-block;
        text-align: center;
        height: 35px;
        line-height: 35px;
        background-color: #1276D8;
        color: #fff;
        width: 90px;
        position: relative;
        cursor: pointer;
    }
    .upload-tips .upload-input>input{
        display: block;
        height: 35px;
        width: 90px;
        opacity: 0;
        margin: 0;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 2;
        cursor: pointer;
    }
</style>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    function deleteSubject(ele) {
        var id = $(ele).data('id');
        var data={
            'id':id
        };
        if(id){
            layer.confirm('确定要删除吗？', {
                title: '删除提示',
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    'type': 'post',
                    'url' : '/wxapp/answer/deleteSubject',
                    'data':data,
                    'dataType': 'json',
                    success: function (ret) {
                        layer.msg(ret.em);
                        if (ret.ec == 200) {
                            window.location.reload();
                        }
                    }
                });
            });
        }
    }
    function tabCss(obj){
        $(obj).addClass('active');
        $(obj).siblings.removeClass('active');
    }
    function selectedFile(obj){
        var path = $(obj).val();
        $(obj).parents('form').find('p').text(path);
    }
    $('[data-click-upload]').on('click', function(){
        var htmlTxt=$("#bulk_shipment");
        var that    = this;
        //页面层
        var layIndex = layer.open({
            type: 1,
            title: '文件路径',
            shadeClose: true, //点击遮罩关闭
            shade: 0.6, //遮罩透明度
            skin: 'layui-anim',
            area: ['500px', '200px'], //宽高
            btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
            content: htmlTxt,
            yes : function() {
                var loading = layer.load(2);
                var $form = htmlTxt.find('form');
                var url = $form.attr("action"),
                        data = new FormData($form[0]);
                $.ajax(url, {
                    type: "post",
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.ec == 200) {
                            layer.msg('批量导入题目成功');
                        }else {
                            layer.msg(data.em);
                        }
                        window.location.reload();
                    },
                    complete: function () {
                        layer.close(loading);
                        layer.close(layIndex);
                    }
                });
            }
        });
    });
</script><?php }} ?>

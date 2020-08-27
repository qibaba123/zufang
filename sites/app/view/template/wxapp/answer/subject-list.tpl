<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
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
<{include file="../common-second-menu.tpl"}>
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
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="题目">
                                <input type="hidden" class="form-control" name="type" value="<{$type}>" placeholder="题目">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">难易程度</div>
                                <select class="form-control" id="degree" name="degreeNum">
                                    <{foreach $degree as $key=>$val}>
                                    <option value ="<{$key}>" <{if $key==$degreeNum}>selected="selected"<{/if}>><{$val}></option>
                                    <{/foreach}>
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
        <{if $type=='public'}>
            <a href="/wxapp/answer/subjectList/type/pri" >私有题目</a>
            <a href="/wxapp/answer/subjectList/type/public" class="active">公共题目</a>
        <{else}>
            <a href="/wxapp/answer/subjectList/type/pri" class="active" >私有题目</a>
            <a href="/wxapp/answer/subjectList/type/public" >公共题目</a>
        <{/if}>

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
                                <{if $type=='pri'}>
                                <th>操作</th>
                                <{/if}>
                            </tr>
                        <{foreach $list as $val}>
                            <tr>
                                <td style="white-space: normal;"><{$val['as_question']}></td>
                                <td style="white-space: normal;"><{$val['as_answer']}></td>
                                <td style="white-space: normal;"><{$val['as_item1']}></td>
                                <td style="white-space: normal;"><{$val['as_item2']}></td>
                                <td style="white-space: normal;"><{$val['as_item3']}></td>
                                <td style="white-space: normal;"><{$val['as_item4']}></td>
                                <td style="white-space: normal;"><{$val['as_degree']}></td>
                                <td style="white-space: normal;"><{date('Y-m-d H:i',$val['as_create_time'])}></td>
                                <{if $type=='pri'}>
                                    <td style="white-space: normal;" class="jg-line-color">
                                    <a href="/wxapp/answer/subject/?id=<{$val['as_id']}>">编辑</a> -
                                    <a href="javascript:;" onclick="deleteSubject(this)" data-id="<{$val['as_id']}>" class="btn-del" style="color:#f00;">删除</a>
                                    </td>
                                <{/if}>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="9" style="text-align:right"><{$paginator}></td></tr>
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
</script>
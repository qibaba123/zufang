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
<{include file="../common-second-menu-new.tpl"}>
<div  id="mainContent"  style="">
    <a class="add-slide btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="0" data-sort="" data-path="/public/manage/img/zhanwei/zw_fxb_75_36.png" data-category="0" data-information="0"><i class="icon-plus bigger-80"></i> 新增</a>
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
            <form action="/wxapp/currency/informationSlide" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">分类</div>
                                <select name="category_search" id="category_search" class="form-control">
                                    <option value="0">全部</option>
                            <{foreach $category_select as $key => $val}>
                            <option value="<{$key}>" <{if $key == $category_search}>selected<{/if}> ><{$val}></option>
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
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                            <tr>
                                <th>图片</th>
                                <th>所属分类</th>
                                <th>排序权重</th>
                                <th>编辑时间</th>
                                <th>操作</th>
                            </tr>
                        <{foreach $list as $val}>
                            <tr>
                                <td style="white-space: normal;"><img src="<{$val['ais_path']}>" alt="" style="height:100px;"></td>
                                <td style="white-space: normal;"><{$category_select[$val['ais_category']]}></td>
                                <td style="white-space: normal;"><{$val['ais_sort']}></td>
                                <td style="white-space: normal;"><{date('Y-m-d H:i',$val['ais_update_time'])}></td>
                                <td style="white-space: normal;">
                                    <a class="add-slide" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['ais_id']}>" data-category="<{$val['ais_category']}>" data-path="<{$val['ais_path']}>" data-sort="<{$val['ais_sort']}>" data-information="<{$val['ais_link_id']}>">编辑</a> -
                                    <a href="javascript:;" onclick="deleteSubject(this)" data-id="<{$val['ais_id']}>" class="btn-del">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="5" style="text-align:right"><{$paginator}></td></tr>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<!-- 添加奖品弹出层 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="categoryOld">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    幻灯图
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">幻灯图：(建议尺寸720*360)</label>
                    <div class="col-sm-8">
                        <div>
                            <div class="cropper-box" data-width="720" data-height="360" style="height:100%;">
                                <img id="default-cover" src="/public/manage/img/zhanwei/zw_fxb_75_36.png" width="100%" height="100%" style="display:block;width: 335px;" alt="封面" >
                                <input type="hidden" class="avatar-field bg-img" name="slide-path" id="slide-path"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">所属分类：</label>
                    <div class="col-sm-8">
                        <select name="category" id="category" class="form-control">
                            <{foreach $category_select as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">排序权重：</label>
                    <div class="col-sm-8">
                        <input id="sort" class="form-control" placeholder="请输入整数，越大越靠前" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">链接文章：</label>
                    <div class="col-sm-8">
                        <select name="information" id="information" class="form-control">
                            <option value="0">无</option>
                            <{foreach $information_select as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <!--<div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">奖品价值：</label>
                    <div class="col-sm-8">
                        <input type="number" id="award-price" class="form-control" placeholder="请填写奖品价值" maxlength="2" style="height:auto!important" />
                    </div>
                </div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-slide">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
<{$cropper['modal']}>
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
                    'url' : '/wxapp/currency/deleteSlide',
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
    //点击编辑或添加幻灯图
    $('.add-slide').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category').val($(this).data('category'));
        $('#information').val($(this).data('information'));
        $('#categoryOld').val($(this).data('category'));
        $('#sort').val($(this).data('sort'));
        $('#slide-path').val($(this).data('path'));
        $('#default-cover').attr('src',$(this).data('path'));
    });

    $('#save-slide').on('click',function(){
        var category = $('#category').val();
        var categoryOld = $('#categoryOld').val();
        var sort = $('#sort').val();
        var cover = $('#slide-path').val();
        var information = $('#information').val();
        if(!cover){
            layer.msg('请上传幻灯图');
            return;
        }
        if(!category){
            layer.msg('请选择分类');
            return;
        }

        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#hid_id').val();


        var data = {
            id   : id,
            category : category,
            categoryOld : categoryOld,
            path : cover,
            sort : sort,
            information : information
        };
//        console.log(data);return;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveSlide',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/currency/informationSlide'
                }
            }
        });

    });



</script>
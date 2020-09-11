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
<div id="content-con">
<div  id="mainContent"  style="">

    <div id="content-con" class="content-con">
        <div class="opera-btn-box" style="display: inline;">
            <a href="/wxapp/service/addService" class="btn btn-blue btn-sm"><i class="icon-plus bigger-80"></i> 新增</a>
        </div>
        <button class="btn btn-blue btn-sm" style="margin-left: 20px;padding-bottom: 5px;" data-toggle="modal" data-target="#topModal"><i class="icon-plus bigger-80"></i>企业服务顶部图片</button>
        <div class="search-part-wrap">

        </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                            <tr>
                                <th>服务名称</th>
                                <th>服务logo</th>
                                <th>服务类型</th>
                                <th>排序权重</th>
                                <th>编辑时间</th>
                                <th>操作</th>
                            </tr>
                        <{foreach $list as $val}>
                            <tr>
                                <td><{$val['es_name']}></td>
                                <td style="white-space: normal;"><img src="<{$val['es_logo']}>" alt="" style="width:150px;"></td>
                                <td style="white-space: normal;"><{if $val['es_type'] == 1}>企业服务商品<{else}>企业服务文章<{/if}></td>
                                <td style="white-space: normal;"><{$val['es_weight']}></td>
                                <td style="white-space: normal;"><{date('Y-m-d H:i',$val['es_create_time'])}></td>
                                <td style="white-space: normal;">
                                    <a class="btn btn-xs btn-primary" href="/wxapp/service/addService?id=<{$val['es_id']}>" >编辑</a> -
                                    <a class="btn btn-xs btn-danger" href="javascript:;" onclick="deleteSubject(this)" data-id="<{$val['es_id']}>" class="btn-del">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="6" style="text-align:right"><{$paginator}></td></tr>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
</div>

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="topModal" tabindex="-1" role="dialog" aria-labelledby="topModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 600px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        企业服务顶部图片
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <!--<div style="text-align: center;padding: 20px 0">
                            <img onclick="toUpload(this)" data-limit="1" style="width: 80%" data-width="750" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<{if $image}><{$image}><{else}>/public/wxapp/community/images/image_750_200.png<{/if}>"  width="750px" height="200px" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="top-image"  class="avatar-field bg-img" name="top-image" value="<{if $image}><{$image}><{/if}>"/>
                        </div>-->
                            <div class="cropper-box" data-width="750" data-height="400" style="padding: 20px 0">
                                <img id="default-cover" src="<{if $image}><{$image}><{else}>/public/manage/images/zhanwei/add0.png<{/if}>" width="150px" height="66px" style="display:block;margin:auto" alt="轮播图">
                                <input type="hidden" class="avatar-field bg-img" name="top-image" id="top-image" value="<{if $image}><{$image}><{else}>/public/wxapp/community/images/image_750_200.png<{/if}>"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="confirm-save">
                        保存
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
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
    <{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    $('#confirm-save').on('click',function(){
        var image = $('#top-image').val();
        var data = {
            image: image
        };

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/service/saveServiceImage',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });


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
                    'url' : '/wxapp/service/deleteService',
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


    $('#save-slide').on('click',function(){
//        var category = $('#category').val();
//        var categoryOld = $('#categoryOld').val();
        var sort  = $('#sort').val();
        var cover = $('#slide-path').val();
        var aiid   = $('#aiid').val();
        var ainame = $('#aiid option:selected').html();
        var type  = $('#type').val();
//        alert(gname);return;
//        var information = $('#information').val();
        if(!cover){
            layer.msg('请上传幻灯图');
            return;
        }
//        if(!category){
//            layer.msg('请选择分类');
//            return;
//        }
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#hid_id').val();


        var data = {
            id   : id,
//            category : category,
//            categoryOld : categoryOld,
            path : cover,
            sort : sort,
           /* gid  :  gid,*/
            aiid : aiid,
            ainame : ainame,
            type  : type
//            information : information
        };
//        console.log(data);return;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/slide/saveSlide',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/slide/informationSlide'
                }
            }
        });

    });



</script>
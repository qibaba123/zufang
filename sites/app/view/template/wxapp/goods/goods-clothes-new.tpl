<link rel="stylesheet" href="/public/manage/groupControl/css/style.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .layui-layer-content #layui-layer-iframe1>img{
        width: 100%;!important;
        height: 100%;!important;
    }
    #bulk_shipment .upload-tips span{
        height:35px;
        line-height: 35px;
        display: inline-block;
        width: 80%;
    }
    .modal-body span{
        height:35px;
        line-height: 35px;
        display: inline-block;
        padding: 0 18px ;
        width: 48%;
    }
    .modal-body span input{
        width: 80%;
    }
</style>
<div>
    <div class="page-header">
        <{if $type == 'model'}>
        <a href="javascript:;" onclick="toUpload()"   class="btn btn-green btn-bigger "><i class="icon-plus bigger-80"></i><{$desc}> 上传</a>
        <{else}>
        <a href="javascript:;"   class="btn btn-green btn-bigger saveFile"><i class="icon-plus bigger-80"></i><{$desc}> 上传</a>
        <a href="javascript:;"   class="btn btn-green btn-bigger show-product"><i class="icon-plus bigger-80"></i>参数</a>
        <{/if}>
    </div>
    <!--<div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $type eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
    </div>-->
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" id="content-con">
                <table id="sample-table-1" class="table table-striped table-hover table-button">
                    <thead>
                    <tr>
                        <th>图片</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            最近更新
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $key => $val}>
                        <tr id="tr_<{$val['gcri_id']}>" >
                            <td onclick="hrefto('<{$val['gcri_path']}>')">
                                <img src="<{$val['gcri_path']}>" width="110px" height="110px" alt="图片">
                            </td>
                            <td><{date('Y-m-d H:i:s',$val['gcri_update_time'])}></td>
                            <td>
                                <a href="javascript:;" id="del_<{$val['gcri_id']}>" class="btn-del" data-gid="<{$val['gcri_id']}>">删除</a>
                            </td>
                        </tr>
                        <{/foreach}>
                        <tr><td colspan="4"><{$paginator}></td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="goods-modal"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">样品参数</h4>
                </div>
                <div class="modal-body">
                    <span>编号: <input type="text" class="code" value="<{if $p_data}><{$p_data['gcp_code']}><{/if}>"/></span>
                    <span>品名: <input type="text" class="name" value="<{if $p_data}><{$p_data['gcp_name']}><{/if}>"/></span>
                    <span>规格: <input type="text" class="spec" value="<{if $p_data}><{$p_data['gcp_spec']}><{/if}>"/></span>
                    <span>门幅: <input type="text" class="width" value="<{if $p_data}><{$p_data['gcp_width']}><{/if}>"/></span>
                    <span>克重: <input type="text" class="weight" value="<{if $p_data}><{$p_data['gcp_weight']}><{/if}>"/></span>
                </div>
                <input type="hidden" class="g_id" value="<{$gid}>">
                <input type="hidden" class="gcp_id" value="<{$p_data['gcp_id']}>">
                <div class="modal-footer ajax-pages" id="footer-page">
                    <button type="button" class="btn btn-blue btn-md" onclick="saveProduct()">
                        保存
                        <i class="icon-search icon-on-right bigger-110"></i>
                    </button>
                    <!--存放分页数据-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<div id="bulk_shipment" style="display: none;padding:5px 20px;height: 180px">
    <div class="upload-tips">
        <form action="/wxapp/clothes/addRoomImg?type=<{$type}>&gid=<{$gid}>" enctype="multipart/form-data" method="post">
            <span  class="upload-input">
                图片: <input style="display: inline-block;margin-left: 5px" class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="room_img" type="file">
            </span>
            <p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传文件</p>
            <div style="font-size: 14px;" >注意　<span id="show-notice">最大支持 2 MB 文件。</span></div>
        </form>
    </div>
</div>
<{include file="./img-upload-modal-test.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>

<script type="text/javascript">
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        // console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
        optshide();
    } );

    /**
     * 修改商品排序权重
     */
    function changeWeight(obj){
        var old = $(obj).data('old');
        var data = {
            'id'    : $(obj).data('id'),
            'val'   : $(obj).val()
        };

        if(data.id && data.val != old){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/changeWeight',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        fetchPageData(currPage);
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }

    }

    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            // console.log(link);
            $('.copy-div input').val(link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-204;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-490,'top':top-conTop-152}).stop().show();
        // initCopy();
    });
    /*$(".ui-popover.ui-popover-link").on('click', function(event) {
     event.preventDefault();
     event.stopPropagation();
     });*/
    $("body").on('click', function(event) {
        optshide();
    });
    /*隐藏复制链接弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    function selectedFile(obj){
        var path = $(obj).val();
        $(obj).parents('form').find('p').text(path);
    }
    /**
     * 文档上传
     */
    $('.saveFile').on('click', function(){
        var htmlTxt=$("#bulk_shipment");
        var that    = this;
        //页面层
        var layIndex = layer.open({
            type: 1,
            title: '<{$desc}>',
            shadeClose: true, //点击遮罩关闭
            shade: 0.6, //遮罩透明度
            skin: 'layui-anim',
            area: ['500px', '220px'], //宽高
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
                        layer.msg(data.em,{
                            time:2000
                        },function(){
                            window.location.reload();
                        });
                        //window.location.reload();
                    },
                    complete: function () {
                        layer.close(loading);
                        layer.close(layIndex);
                    }
                });
            }
        });
    });
    $('.btn-del').on('click',function(){
        var id = $(this).data('gid');
        layer.confirm('您确定要删除图片吗?',function(){
            var data = {
                'id' : id
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            console.log(data);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/clothes/delClothesImg',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        $('#tr_'+data.id).hide();
                    }
                }
            });
        },function(){

        });
    });
    function hrefto(obj){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: '516px',
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: '<img src="'+obj+'" style="width:100%;">'
        });
    }
    /**
     * 模特图片复用
     */
    $('.copyFile').on('click',function(){
        layer.confirm('您确认要复用已上传的模特图片吗?',function(){
            var gid = '<{$gid}>';
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/clothes/copyModelImg',
                'data'  : {gid:gid},
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                }
            });
        },function(){

        });
    });

    $('.show-product').on('click',function(){
        $('#goods-modal').modal('show');
    });
    /**
     * 保存商品参数
     */
    function saveProduct(){
        var data  = {};
        var filed = new Array('code','name','spec','width','weight','g_id','gcp_id');
        for(var i=0;i<filed.length;i++){
            data[filed[i]] = $('.'+filed[i]).val();
            if(!data[filed[i]] && filed[i] != 'gcp_id'){
                layer.msg('请完善您的数据');
                return;
            }
        }
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/clothes/addRoomProduction',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em,{
                    time:2000
                },function(){
                    if(ret.ec==200){
                        location.reload();
                    }
                });
            }
        });
    }

</script>



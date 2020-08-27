<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 09:11:54
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/img-upload-modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19324539575e853bdad8b3f1-55811088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91ab94835baa251b6d9d530b84f33d70fe2f9a0e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/img-upload-modal.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19324539575e853bdad8b3f1-55811088',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'universaltype' => 0,
    'univeralid' => 0,
    'curr_shop' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e853bdad9eac6_10244965',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e853bdad9eac6_10244965')) {function content_5e853bdad9eac6_10244965($_smarty_tpl) {?><style>
    #myimg{
        font-family: "微软雅黑";
    }
    #myimg .modal-body{
        padding:0!important;
    }
    .group-img{

    }
    .group-name{
        background-color: #F2F2F2;
        width: 160px;
        float: left;
        padding: 15px 0;
        overflow-y: scroll;
        height: 541px;
    }
    /*.group-name.commonH{
    	height: 588px;
    }*/
    .group-name>div{
        /*background-color: #fff;*/
        line-height: 3;
        padding:0 15px;
        /* margin-bottom: 5px;*/
        cursor: pointer;
        /*   color:#fff;*/
    }
    .group-name>div.active{
        background-color: #fff;
    }
    .group-name span{
        float: right;
        color: #999;
    }
    .showimg-con{
        margin-left: 160px;
    }
    #showimg-con .group-img-con {
        display: none;
    }
    #showimg-con .group-img-con.active {
        display: block;
    }
    .showimg-con ul{
        margin:0;
        padding:0;
        padding-right: 0;
        overflow: hidden;
        padding-top: 15px;
        /*height: 486px;*/
        height: 490px;
    }
    .showimg-con ul li{
        margin-left: 16px;
        width: 120px;
        text-align: center;
        float: left;
    }
    .showimg-con ul li p{
        margin:0;
        line-height: 2.5;
        margin-bottom: 5px;
    }
    .showimg-con li div{
        height: 120px;
        background-color: #f2f2f2;
        vertical-align: middle;
        position: relative;
        overflow: hidden;
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .showimg-con li>div.selected::after{
        position: absolute;
        left: 0;
        top:0;
        content: '';
        height: 100%;
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:2px solid #0077DD;
        z-index: 1;
    }
    .showimg-con li>div.selected::before{
        content:'';
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 2;
        height: 30px;
        width: 30px;
        background: url(/public/manage/img/sanjiao.png) no-repeat;
        background-size: 30px;
        background-position: bottom right;
    }
    .showimg-con li div img{
        width: 100%;
        display: block;
        margin:auto;
        height: 100%;
    }
    .showimg-con li div span{
        position: absolute;
        height: 30px;
        line-height: 30px;
        color: #fff;
        width: 100%;
        left: 0;
        bottom: 0;
        z-index: 1;
        background-color: rgba(0,0,0,0.4);
    }

    .img-pages{
        text-align: right;
        padding:10px 0;
        margin:0 15px 5px;
        border-radius: 5px;
        background-color: #f5f5f5;
        position: relative;
    }
    .img-pages #upload-btn{
        position: absolute;
        left: 5px;
    }
    .img-pages #update-group-btn {
        position: absolute;
        left: 76px;
    }
    .img-pages #del-group-btn {
        position: absolute;
        left: 148px;
    }
    .img-pages a{
        padding: 5px 8px;
        margin: 0 1px;
        min-width: 28px;
        border: 1px solid #ddd;
        background-color: #fff;
        text-align: center;
        border-radius: 2px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        color: #333;
    }
    .img-pages a:hover{
        background-color: #f8f8f8;
        color: #0077DD;
    }
    .img-pages a.active{
        background-color: #0077DD;
        color: #fff;
        border-color: #0077DD;
    }
    .img-pages p{
        display: inline-block;
        vertical-align: top;
        margin-left: 5px;
        margin-bottom: 0;
    }
    .add-img{
        display: none;
        padding:40px 30px;
    }
    .add-tip{
        overflow: hidden;
    }
    .add-tip p{
        margin:10px 0;
        color: #999;
    }
    .add-tip img.selected::after{
        position: absolute;
        left: 0;
        top:0;
        content: '';
        height: 100%;
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:2px solid #0077DD;
        z-index: 1;
    }
    .add-tip img.selected::before{
        content:'';
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 2;
        height: 30px;
        width: 30px;
        background: url(/public/manage/img/sanjiao.png) no-repeat;
        background-size: 30px;
        background-position: bottom right;
    }
    .modal-header h4 {
        margin: 0;
        font-size: 16px;
        font-family: "黑体";
    }
    .modal-header h4 span{
        color: #38f;
        cursor: pointer;
    }
    /* .layui-layer-shade{
        display: none;
    } */
    #slide-img {
        margin: 0;
        margin-bottom: 5px;
    }
    #slide-img p {
        margin: 0;
        position: relative;
        padding: 0;
        display: inline-block;
        height: 90px;
        width: 90px;
        margin-right: 15px;
        cursor: pointer;
    }
    #slide-img p .delimg-btn {
        position: absolute;
        top: -9px;
        right: -9px;
        height: 20px;
        line-height: 17px;
        text-align: center;
        width: 20px;
        border: 1px solid #ddd;
        background-color: rgba(0, 0, 0, 0.3);
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
        font-size: 16px;
        color: #fff;
        cursor: pointer;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        -ms-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
    }
    #slide-img p:hover .delimg-btn, #slide-img p .delimg-btn:hover {
        background-color: #444;
    }
    .img-thumbnail {
        display: inline-block;
        margin-right: 15px;
        margin-left: 0;
        height: 90px;
        width: 90px;
    }
    /* 查看大图 */
    .view-shade {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: #444;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 9999;
    }
    .bigImg-show {
        position: absolute;
        height: 90%;
        width: 90%;
        left: 5%;
        top: 5%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .bigImg-show img {
        max-width: 100%;
        max-height: 100%;
        margin: auto;
        display: block;
        border: 5px solid #f9f9f9;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
    }
    .img-pages #delete-btn{
        position: absolute;
        left: 80px;
        top: 4px;
        background-color: red!important;
        border-color: red!important;
    }
    #showimg-con .img-con{
        display:none;
    }
    #showimg-con .img-con.active{
        display:block;
    }
    .select-tab{
        width:100%;
        height:57px;
        line-height:57px;
        color:#333;
        background-color:#f2f2f2;
        font-size:0;
        box-sizing:border-box;
        border-left:1px solid #e5e5e5;
    }
    .select-tab .swiper-container{
        width:100%;
        height:100%;
    }
    .select-tab .swiper-slide .tab-item{
        width:100%;
        text-align: center;
        display:inline-block;
        font-size:16px;
    }
    .select-tab .swiper-slide.active .tab-item{
        background-color:#fff;
    }
    .loading {
        display: none;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: #fff url("/public/site/img/loading.gif") no-repeat center center;
        opacity: .75;
        filter: alpha(opacity=75);
        z-index: 20140628;
    // min-height: 1000px;
    }
    img {
        margin: auto;
        display: block;
    }
    .btn-add-group:before{
        content: '+';
        color: #98999a;
        font-size: 20px;
        position: relative;
        left: -10px;
        top: 1px;
    }
    .show-group-name{
        display: inline-block;
    }
    .img-real-name{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .modal-body{
        max-height: inherit;
        height: inherit;
    }
</style>
<!--图片弹窗-->
<div class="modal fade" id="myimg" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:890px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myimgTitle">
                    我的图片
                </h4>
            </div>
            <div class="modal-body">
                <div class="group-img">
                    <div class="group-name" id="group-name">
                        <div class="neme-item active">全部图片<span id="uploadTotalImg"></span></div>
                        <div class="neme-item">公共图片<span id="uploadCommonTotalImg"></span></div>
                        <div style="text-align: center;line-height: 2;"><a href="javascript:;" data-toggle="modal" data-target="#groupModal" class="btn-add-group">添加分组</a></div>
                    </div>
                    <div class="showimg-con" id="showimg-con">
                        <div class="img-con active">
                            <ul id="attach-ajax-img">
                                <!--图片显示位置-->
                            </ul>
                            <div class="img-pages">
                                <div class="btn btn-green btn-xs" id="upload-btn">上传图片</div>
                                <div class="btn btn-green btn-xs" id="update-group-btn" style="display: none" data-toggle="modal" data-target="#groupModal">编辑分组</div>
                                <div class="btn btn-red btn-xs" id="del-group-btn" style="display: none;background-color: red!important;">删除分组</div>
                                <div id="ajax-page-html" style="display:inline-block">
                                    <!--分页显示位置-->
                                </div>
                                <p id="page-total"></p>
                            </div>
                        </div>
                        <div class="img-con">
                            <div class="tab-con">
                                <ul id="attach-common-ajax-img">

                                </ul>
                            </div>
                            <div class="img-pages">
                                <!--	                            <div class="btn btn-green btn-xs">上传图片</div>-->
                                <div style="display:inline-block" id="ajax-common-page-html" >
                                    <!--分页显示位置-->
                                </div>
                                <p id="page-common-total"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-img">
                    <div class="add-tip">
                        <label class="col-xs-3 text-right">本地图片：</label>
                        <div class="col-xs-9" id="upload-width-height">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align:right">
                <button type="button" class="btn btn-blue" id="chooseimg1" style="width:100px;display: none" >返回图库
                </button>
                <button type="button" class="btn btn-blue" id="update-btn" style="width:120px;" data-toggle="modal" data-target="#nameModal" >修改图片名称
                </button>
                <button type="button" class="btn btn-blue" id="edit-group-btn" style="width:120px;" data-toggle="modal" data-target="#setGroupModal" >设置图片分组
                </button>
                <button type="button" class="btn btn-red" id="delete-btn" style="width:100px;background-color: red!important;" >删除
                </button>
                <button type="button" class="btn btn-blue"
                        data-dismiss="modal" id="confirm-btn" style="width:100px;">确定
                </button>
            </div>
            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 330px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    编辑图片分组
                </h4>
            </div>
            <div class="modal-body">
                <div style="padding:20px;">
                    <form role="form">
                        <input type="hidden" id="hid">
                        <div class="input-group" style="width: 100%;margin-bottom: 15px;">
                            <span class="input-group-addon" >分组名称</span>
                            <input type="text" class="form-control" placeholder="请输入分组名称" id="groupName">
                        </div>
                        <div class="input-group" style="width: 100%;">
                            <span class="input-group-addon">排序权重</span>
                            <input type="text" class="form-control" placeholder="请输入排序权重" id="groupWeight">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary btn-save-group">
                    确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 330px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    设置图片名称
                </h4>
            </div>
            <div class="modal-body">
                <div style="padding:20px;">
                    <form role="form">
                        <div class="input-group" style="width: 100%;margin-bottom: 15px;">
                            <span class="input-group-addon" >图片名称</span>
                            <input type="text" class="form-control" placeholder="请输入图片名称" id="imgRealName">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary btn-save-name">
                    确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="setGroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 330px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    设置图片分组
                </h4>
            </div>
            <div class="modal-body">
                <div style="padding:20px;">
                    <form role="form">
                        <div class="input-group" style="width: 100%;margin-bottom: 15px;">
                            <span class="input-group-addon" >图片分组</span>
                            <select name="img-group-select" id="img-group-select" class="form-control">

                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                </button>
                <button type="button" class="btn btn-primary btn-save-set-group">
                    确定
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="view-shade" id="view-shade" style="display:none">
    <div class="bigImg-show">
        <img src="" alt="图片">
    </div>
</div>
<input id='universal_type' type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['universaltype']->value;?>
">
<input id='universal_id' type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['univeralid']->value;?>
">
<!--  <script src="/public/plugin/layer/layer.js"></script>-->
<!-- <script src="/public/site/js/swiper-4.4.2.min.js"></script>-->
<script>
    $('#group-name').on('click', '.neme-item',function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        if(index==1){
            $('#showimg-con .img-con').eq(index).addClass('active').siblings().removeClass('active');
            $(this).parent().addClass('commonH');
            $('#delete-btn').stop().hide();
            $("#update-btn").stop().hide();
            $("#edit-group-btn").stop().hide();
        }else{
            if(index == 0){
                $('#del-group-btn').stop().hide();
                $('#update-group-btn').stop().hide();
            }else{
                $('#del-group-btn').stop().show();
                $('#update-group-btn').stop().show();
            }
            $('#showimg-con .img-con').eq(0).addClass('active').siblings().removeClass('active');
            $(this).parent().removeClass('commonH');
            $('#delete-btn').stop().show();
            $("#update-btn").stop().show();
            $("#edit-group-btn").stop().show();
            fetchUploadImgData(1, $(this).data('id'));
        }
    });

    //  	$('#select-tab .swiper-slide').click(function(){
    //  		$(this).addClass('active').siblings().removeClass('active')
    //  	})


    /**
     * 调用方法说明：
     * 调用toUpload()方法，并传递限制图片的数量 如果不传则默认选择一个
     * 打开modal弹窗，选择图片
     * 点击保存时，返回图片地址
     * 自定义deal_select_img()方法，来处理返回的图片地址
     * */
    var nowIndex = 0, maxNum = 1,nowId='upload-cover',page= 1, width=200,height=200; //图片选择配置  大于1多选，数量为最多选择图片个数 小于1单选
    function toUpload(elem){
        var limit   = parseInt($(elem).data('limit'));
        width   = parseInt($(elem).data('width'));
        height  = parseInt($(elem).data('height'));
        var domId   = $(elem).data('dom-id');
        if(limit > 0)  maxNum = limit;
        initUploadBox();
        if(domId) nowId = domId;
        fetchUploadImgData(1);
        fetchImgGroupData();
        $('#myimg').modal('show');
        var index = $(elem).data('index');
        // console.log('toUpload--index---'+index);
        if(index) nowIndex=index;
        $("#chooseimg1").stop().hide();
        $("#delete-btn").stop().show();
        $("#update-btn").stop().show();
        $('#del-group-btn').stop().hide();
        $('#update-group-btn').stop().hide();
        $("#edit-group-btn").stop().show();
        $(".group-img").stop().show();
        $(".add-img").stop().hide();
        // console.log(width);
        // console.log(height);
    }

    function initUploadBox(){
        var html = '<div class="cropper-box" data-groupid="" data-width="'+width+'" style="width: 250px;display: inline-block; margin-right: 50px" data-height="'+height+'">';
        html += '<img src="/public/manage/img/zhanwei/default.png" height="100px" alt="图片">';
        html += '<p style="text-align:center">静态图片</p>';
        html += '<p>仅支持jpg、gif、png三种格式, <span id="up_wh_tip">建议尺寸：'+width+' x '+height+' 像素</span></p>';
        html += '<p>请将图片大小控制在2M以内，否则将无法上传</p>';
        html += '<input type="hidden"  class="avatar-field bg-img crop-img-value" value=""/>';
        html += '</div>';
        html += '<div class="origin-box" style="width: 250px;display: inline-block;height:265px;position:relative;float:right">';
        html += '<input type="file"  id="gif-file" value="" onchange="uploadGif(this)" style="position: absolute; height: 280px;width: 250px;opacity: 0;margin: 0;top: 0;left: 0;z-index: 2;cursor: pointer;"/> <img src="/public/manage/img/zhanwei/default.png" height="100px" alt="图片">';
        html += '<p style="text-align:center">动态图片</p>';
        html += '<p>仅支持gif格式, <span id="up_wh_tip">建议尺寸：'+width+' x '+height+' 像素</span></p>';
        html += '<input type="hidden"  class="avatar-field ori-img ori-img-value" value=""/>';
        html += '</div>';
        $('#upload-width-height').html(html);
        $(".cropper-box").unbind();

        new $.CropAvatar($("#crop-avatar"));
    }

    /*弹出层出现时清空已选择图片*/
    $('#myimg').on('show.bs.modal', function () {
        $(".showimg-con li div").removeClass('selected');
    });

    /*选中图片添加选中样式*/
    $(".showimg-con").on('click', 'li>div', function(event) {
        var num=0;
        if(maxNum>1){
            var liItems = $(this).parents('ul').find('li');
            liItems.each(function(index, el) {
                if($(this).find('div').hasClass('selected')){
                    num++;
                }else{

                }
            });
            if(num<maxNum){
                $(this).toggleClass('selected');
            }else{
                if($(this).hasClass('selected')){
                    $(this).toggleClass('selected');
                }else{
                    layer.msg("最多添加"+maxNum+"张图片哦！")
                }
            }

        }else if(maxNum<=1){
            $(this).parents(".showimg-con").find('li div').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    function uploadGif(e){
        var file = $(e).val();
        if (file.type) {
            var isImageFile =  /^image\/\w+$/.test(file.type);
        } else {
            var isImageFile =  /\.(jpg|jpeg|png|gif)$/.test(file);
        }

        if(isImageFile){
            var url = "/admin/image/upload/common/default?dir=image&suid=<?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_unique_id'];?>
",
                data = new FormData();
            data.append('files[]', $(e)[0].files[0]);

            $.ajax(url, {
                type: "post",
                data: data,
                processData: false,
                contentType: false,

                beforeSend: function () {
                    $('.modal-content').find(".loading").fadeIn();
                },

                success: function (data) {
                    $(".origin-box").find('img').attr("src", data.url);
                    $(".origin-box").find('input:hidden').val(data.url);
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg(textStatus || errorThrown)
                },

                complete: function () {
                    $('.modal-content').find(".loading").fadeOut();
                }
            });
        }
    }

    /*点击确定按钮打印获取图片路径*/
    $("#confirm-btn").on('click', function(event) {
        var groupImg = $(this).parents('.modal-content').find('.group-img').css("display");
        var addImg = $(this).parents('.modal-content').find('.add-img');
        var allSrc = new Array();
        if(groupImg==='block'){
            var liItems = $(this).parents('.modal-content').find('.showimg-con li');
            liItems.each(function(index, el) {
                if($(this).find('div').hasClass('selected')){
                    var imgSrc = $(this).find('div img').attr("src");
                    allSrc.push(imgSrc);
                }else{

                }
            });
        }else if(groupImg==='none'){
            var corpImg = $('.crop-img-value').val();
            var oriImg  = $('.ori-img-value').val();
            // console.log(corpImg);
            // console.log(oriImg);
            if(corpImg){
                allSrc.push(corpImg);
            }else if(oriImg){
                allSrc.push(oriImg);
            }else{
                allSrc.push(addImg.find('img').attr("src"));
            }
        }
        $(".group-img").stop().show();
        $(".add-img").stop().hide();
        /*打印图片路径*/
        // console.log(allSrc);
        deal_select_img(allSrc);
        /*layer.photos({
            photos: '#slide-img',
            zIndex: '199890410'
        });*/
    });

    /*上传图片按钮点击跳转上传图片区域*/
    $("#upload-btn").click(function(event) {
        $(".group-img").stop().hide();
        $(".group-img").find('.showimg-con li div').removeClass('selected');
        $(".add-img").stop().show();
        $("#chooseimg1").stop().show();
        $("#myimgTitle").html("<span id='chooseimg'>选择图片></span>上传图片");
        $("#delete-btn").stop().hide();
        $("#update-btn").stop().hide();
        $("#edit-group-btn").stop().hide();
        var groupid = $('.neme-item.group-item.active').data('id');
        $('.cropper-box').data('groupid', groupid);
    });

    /*标题选择图片点击返回选择图片区域*/
    $(".modal-content").on('click','#chooseimg', function(event) {
        $(".group-img").stop().show();
        $(".add-img").stop().hide();
        $("#myimgTitle").html("我的图片");
        $("#chooseimg1").stop().hide();
        $("#delete-btn").stop().show();
        $("#update-btn").stop().show();
        $("#edit-group-btn").stop().show();
    });

    $(".modal-content").on('click','#chooseimg1', function(event) {
        $(".group-img").stop().show();
        $(".add-img").stop().hide();
        $("#myimgTitle").html("我的图片");
        $("#chooseimg1").stop().hide();
        $("#delete-btn").stop().show();
        $("#update-btn").stop().show();
        $("#edit-group-btn").stop().show();
    });

    $('.btn-save-group').on('click', function(event){
        const data = {
            'id' : $('#hid').val(),
            'name' : $('#groupName').val(),
            'weight' : $('#groupWeight').val()?$('#groupWeight').val():0
        };
        let index = 0;
        $.each($(".group-item"), function(){
            if(data.weight < $(this).data('weight')){
                index++;
            }
        });
        $.ajax({
            'type'   : 'post',
            'url'    : '/wxapp/index/saveAttachmentGroup',
            'data'   : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                // console.log(ret);
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    if(!data.id){
                        if($('.group-item').length > 0){
                            if(index==0){
                                $('.group-item').eq(0).before(`<div class="neme-item group-item" data-weight="${data.weight}" data-name="${data.name}" data-id="${ret.id}"><div class="show-group-name">${data.name}</div><span class="uploadGroupTotalImg">0张</span></div>`);
                            }else{
                                $('.group-item').eq(index-1).after(`<div class="neme-item group-item" data-weight="${data.weight}" data-name="${data.name}" data-id="${ret.id}"><div class="show-group-name">${data.name}</div><span class="uploadGroupTotalImg">0张</span></div>`);
                            }
                        }else{
                            $('.neme-item').eq(1).after(`<div class="neme-item group-item" data-weight="${data.weight}" data-name="${data.name}" data-id="${ret.id}"><div class="show-group-name">${data.name}</div><span class="uploadGroupTotalImg">0张</span></div>`);
                        }
                    }else{
                        $('.neme-item.group-item.active .show-group-name').text(data.name);
                        $('.neme-item.group-item.active').data('name', data.name)
                        $('.neme-item.group-item.active').data('weight', data.weight)
                    }
                    $('#groupModal').modal('hide');
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    });

    function fetchUploadImgData(page, gid){
        let u_type=$('#universal_type').val();
        let u_id=$('#universal_id').val();
        var data = {
            'page'   : page,
            'height' : height,
            'width'  : width,
            'gid'    : gid,
            'u_id'   : u_id,
            'u_type' : u_type,
        };
        $.ajax({
            'type'   : 'post',
            'url'    : '/wxapp/index/fetchAttachment',
            'data'   : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                // console.log(ret);
                if(ret.ec == 200){
                    $('#ajax-page-html').html(ret.pageHtml);
                    $('#page-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                    if(!gid){
                        $('#uploadTotalImg').text(ret.total+'张');
                    }
                    showImg(ret.data, '');
                }else{
                    layer.msg(ret.em);
                }
            }
        });
        var data = {
            'page'   : page,
            'height' : height,
            'width'  : width,
            'type'   : 'common'
        };
        $.ajax({
            'type'   : 'post',
            'url'    : '/wxapp/index/fetchAttachment/type/common',
            'data'   : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                // console.log(ret);
                if(ret.ec == 200){
                    $('#ajax-common-page-html').html(ret.pageHtml);
                    $('#page-common-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                    $('#uploadCommonTotalImg').text(ret.total+'张');
                    showImg(ret.data, 'common');
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function fetchImgGroupData(){
        $.ajax({
            'type'   : 'post',
            'url'    : '/wxapp/index/fetchAttachmentGroup',
            'data'   : {'height':height, 'width':width},
            'dataType'  : 'json',
            'success'   : function(ret){
                // console.log(ret);
                if(ret.ec == 200){
                    $('.group-item').remove();
                    for(let i in ret.data){
                        let data = ret.data[i];
                        $('.neme-item').eq(1).after(`<div class="neme-item group-item" data-weight="${data.weight}" data-name="${data.name}" data-id=${data.id}><div class="show-group-name">${data.name}</div><span class="uploadGroupTotalImg">${data.count}张</span></div>`);
                    }
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function fetchPageData(page, type, gid){
        if(type == 'common'){
            var data = {
                'page'   : page,
                'height' : height,
                'width'  : width,
                'type'   : 'common'
            };
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/fetchAttachment/type/common',
                'data'   : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    // console.log(ret.pageHtml);
                    if(ret.ec == 200){
                        // console.log(ret.pageHtml);
                        $('#ajax-common-page-html').html(ret.pageHtml);
                        $('#page-common-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                        $('#uploadCommonTotalImg').text(ret.total+'张');
                        showImg(ret.data, 'common');
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }else{
            var data = {
                'page'   : page,
                'height' : height,
                'width'  : width,
                'gid'    : gid
            };
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/fetchAttachment',
                'data'   : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    // console.log(ret);
                    if(ret.ec == 200){
                        $('#ajax-page-html').html(ret.pageHtml);
                        $('#page-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                        if(!gid){
                            $('#uploadTotalImg').text(ret.total+'张');
                        }

                        showImg(ret.data);
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    }

    function showImg(data, type){
        var img_html = '';
        if(data.length > 0){
            for(var i=0;i<data.length;i++){
                img_html += '<li><div>';
                img_html += '<img src="'+data[i].path+'" alt="图片">';
                img_html += '<span class="resolution-ratio">'+data[i].width+'*'+data[i].height+'</span>';
                img_html += '</div><p class="img-real-name">'+(data[i].realName?data[i].realName:data[i].name)+'</p>';
                img_html += '</li>'
            }
            if(type=='common'){
                $('#attach-common-ajax-img').html(img_html);
            }else{
                $('#attach-ajax-img').html(img_html);
            }
        }else{
            if(type=='common'){
                $('#attach-common-ajax-img').html('');
            }else{
                $('#attach-ajax-img').html(img_html);
            }
        }
    }


    /*幻灯添加放大事件*/
    $("#slide-img").on('click', 'img', function(event) {
        var that = $(this);
        var curSrc = that.attr("src");

        $("#view-shade .bigImg-show img").attr("src",curSrc);
        $("#view-shade").stop().fadeIn();
    });

    $("#view-shade").on('click', function(event) {
        $(this).stop().fadeOut();
    });

    $('#update-group-btn').on('click', function () {
        $('#hid').val($('.neme-item.group-item.active').data('id'));
        $('#groupName').val($('.neme-item.group-item.active').data('name'));
        $('#groupWeight').val($('.neme-item.group-item.active').data('weight'));
    });

    /*点击确定按钮打印获取图片路径*/
    $("#delete-btn").on('click', function(event) {
        var groupImg = $(this).parents('.modal-content').find('.group-img').css("display");
        var addImg = $(this).parents('.modal-content').find('.add-img');
        var allSrc = new Array();
        if(groupImg==='block'){
            var liItems = $(this).parents('.modal-content').find('.showimg-con li');
            liItems.each(function(index, el) {
                if($(this).find('div').hasClass('selected')){
                    var imgSrc = $(this).find('div img').attr("src");
                    allSrc.push(imgSrc);
                }
            });
        }else if(groupImg==='none'){
            allSrc.push(addImg.find('img').attr("src"));
        }
        if(allSrc.length>0){
            layer.confirm('确定要删除吗？一旦删除将无法找回', {
                title:false,
                closeBtn:0,
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    'type'   : 'post',
                    'url'    : '/wxapp/index/deleteAttachment',
                    'data'   : { imgSrc:allSrc},
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.msg(ret.em);
                        if(ret.ec == 200) {
                            if(groupImg==='block'){
                                var liItems = $('#delete-btn').parents('.modal-content').find('.showimg-con li');
                                liItems.each(function(index, el) {
                                    if($(this).find('div').hasClass('selected')){
                                        $(this).remove();
                                    }
                                });
                            }else if(groupImg==='none'){
                                addImg.remove();
                            }
                        }
                    }
                });
            });
        }else{
            layer.msg('请选择要删除的图片');
        }
    });

    /*批量修改图片名称*/
    $(".btn-save-name").on('click', function(event) {
        var name = $("#imgRealName").val();
        var allSrc = new Array();

        var liItems = $("#myimg").find('.showimg-con li');
        liItems.each(function(index, el) {
            if($(this).find('div').hasClass('selected')){
                var imgSrc = $(this).find('div img').attr("src");
                allSrc.push(imgSrc);
            }
        });

        if(allSrc.length>0){
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/updateAttachmentName',
                'data'   : { imgSrc:allSrc, name: name},
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200) {
                        var liItems = $("#myimg").find('.showimg-con li');
                        liItems.each(function(index, el) {
                            if($(this).find('div').hasClass('selected')){
                                $(this).find('.img-real-name').text(name);
                            }
                        });
                        $('#nameModal').modal('hide');
                    }
                }
            });
        }else{
            layer.msg('请选择图片');
        }
    });

    /*批量修改图片分组*/
    $(".btn-save-set-group").on('click', function(event) {
        var group = $("#img-group-select").val();
        var allSrc = new Array();

        var liItems = $("#myimg").find('.showimg-con li');
        liItems.each(function(index, el) {
            if($(this).find('div').hasClass('selected')){
                var imgSrc = $(this).find('div img').attr("src");
                allSrc.push(imgSrc);
            }
        });

        if(allSrc.length>0){
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/updateAttachmentGroup',
                'data'   : { imgSrc:allSrc, group: group},
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200) {
                        var liItems = $("#myimg").find('.showimg-con li');
                        if($('.group-name .neme-item.active').hasClass('group-item')){
                            liItems.each(function(index, el) {
                                if($(this).find('div').hasClass('selected')){
                                    $(this).remove();
                                }
                            });
                            let selectNum = allSrc.length;
                            let imgNum = $('.group-name .neme-item.active .uploadGroupTotalImg').text();
                            $('.group-name .neme-item.active .uploadGroupTotalImg').text((parseInt(imgNum)-selectNum)+'张');
                        }
                        $.each($(".group-item"), function(){
                            if($(this).data('id') == group){
                                let imgNum = $(this).find('.uploadGroupTotalImg').text();
                                let selectNum = allSrc.length;
                                $(this).find('.uploadGroupTotalImg').text((parseInt(imgNum)+selectNum)+'张');
                            }
                        });
                        $('#setGroupModal').modal('hide');
                    }
                }
            });
        }else{
            layer.msg('请选择图片');
        }
    });

    $('#edit-group-btn').on('click', function () {
        $('#img-group-select').html('');
        $.each($(".group-item"), function(){
            $('#img-group-select').append(`<option value="${$(this).data('id')}">${$(this).data('name')}</option>`);
        });
    });

    $('#del-group-btn').on('click', function(){
        var id = $('.neme-item.group-item.active').data('id');
        layer.confirm('确定要删除吗？', {
            title:false,
            closeBtn:0,
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/delAttachmentGroup',
                'data'   : { id :id },
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200) {
                        $('.neme-item.group-item.active').remove();
                        $('#attach-ajax-img').html('');
                    }
                }
            });
        })
    });

    /**
     * 图片删除功能
     * 以图片容器为准，容器中的图片img标签结果<div><p><img>
     */
    $(".pic-box").on('click', '.delimg-btn', function(event) {
        var id = $(this).parent().parent().attr('id');
        event.preventDefault();
        event.stopPropagation();
        var delElem = $(this).parent();
        layer.confirm('确定要删除吗？', {
            title:false,
            closeBtn:0,
            btn: ['确定','取消'] //按钮
        }, function(){
            delElem.remove();
            var num = parseInt($('#'+id+'-num').val());
            // console.log(num);
            // console.log(id);
            if(num > 0){
                $('#'+id+'-num').val(parseInt(num) - 1);
            }
            layer.msg('删除成功');
        });
    });
    /**
     * 模板angular图片上传使用
     *
     */
    function deal_select_img(allSrc){
        if(allSrc){
            var imgId = nowId.split('-');
            // console.log(imgId);
            // console.log(nowId);
            $('#'+nowId).attr('src',allSrc[0]);
            $('#'+nowId).val(allSrc[0]);
            $('#'+imgId[1]).val(allSrc[0]);
        }
    }
</script>
<?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>
<?php }} ?>

<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
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
    .goods-selected{
        padding: 5px 2px;
        margin: 0 2px;
        position: relative;
    }
    .goods-selected-name{
        font-weight: bold;
        color: #38f;
        width: 90%;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }
    .goods-selected-button{
        width: 9%;
        display: inline-block;
        padding-left: 2px;
    }

    .upload-tips{
        padding-top: 15px;
    }

    .upload-input>input {
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

<{include file="../../manage/common-kind-editor.tpl"}>

<div ng-app="ShopIndex" id="div-add" ng-controller="ShopInfoController" >
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="type" name="type" value="<{$type}>" data-need="required" placeholder="请选择类型">
                                        <input type="hidden" id="hid_gid" name="gid" value="<{$gid}>">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['akk_id']}><{else}>0<{/if}>">
                                        <!-- 表单分类显示 -->
                                        <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>标题：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="akk_name" name="akk_name" placeholder="请填写课程名称" required="required" value="<{if $row}><{$row['akk_name']}><{/if}>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name" class="control-label">试读章节：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="akk_is_free" id="free1" value="1" <{if $row && $row['akk_is_free'] eq 1}>checked<{/if}>>
                                                                        <label for="free1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="akk_is_free" id="free2" value="0"  <{if !($row && $row['akk_is_free'] eq 1)}>checked<{/if}>>
                                                                        <label for="free2">否</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <{if $type == 3}>
                                                        <div class="form-group">
                                                            <label class="control-label">试看时间：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['akk_free_time']}><{else}>0<{/if}>" name="akk_free_time" id="akk_free_time"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">单位秒，若不填则为试看全部内容</p>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <div class="form-group">
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['akk_sort']}><{else}>1<{/if}>" name="akk_sort" id="akk_sort"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越小排序越靠前</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name" class="control-label">阅读量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="akk_read_num" name="akk_read_num" placeholder="请填写阅读量" required="required" style="width:160px;" value="<{if $row}><{$row['akk_read_num']}><{/if}>">
                                                            </div>
                                                        </div>

                                                        <{if $type == 2 || $type == 1}>
                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>封面图：</label>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-akk_cover" id="upload-akk_cover"  src="<{if $row && $row['akk_cover']}><{$row['akk_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="akk_cover"  class="avatar-field bg-img" name="akk_cover" value="<{if $row && $row['akk_cover']}><{$row['akk_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-akk_cover">修改(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>音频上传：</label>
                                                            <div class="control-group">
                                                                <{if ($qiniu && $mediaProvider==1) || ($tencentyun && $mediaProvider==2)}>
                                                                <div id="upload-dom">
                                                                    <audio style="width: 500px;<{if !$row['akk_url']}>display: none;<{else}>display: block;<{/if}>margin-bottom: 15px" id="playaudio" src="<{$row['akk_url']}>" preload="preload" controls="controls" ></audio>
                                                                    <span class="btn btn-md btn-green upload-btn" onclick="toUploadMedia()"><{if $row && $row['akk_url']}>修改音频<{else}>添加音频<{/if}></span>
                                                                    <p class="tip">仅支持MP3格式</p>
                                                                    <a href="javascript:;" onclick="changeEnter(2)">手动填写链接</a>
                                                                </div>
                                                                <div id="enter-dom" style="display: none">
                                                                    <input type="text" class="form-control"  id="akk_url" name="akk_url" placeholder="请填写链接" required="required" value="<{if $row}><{$row['akk_url']}><{/if}>">
                                                                    <p class="tip">仅支持MP3格式</p>
                                                                    <a href="javascript:;" onclick="changeEnter(1)">上传音频</a>
                                                                </div>
                                                                <{else}>
                                                                <div style="margin-top: 8px;color: red;">
                                                                    您未配置存储信息 <a href="/wxapp/currency/video" target="_blank">前往配置</a>
                                                                </div>
                                                                <{/if}>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <{if $type == 3}>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>视频上传：</label>
                                                            <div class="control-group">
                                                                <{if ($qiniu && $mediaProvider==1) || ($tencentyun && $mediaProvider==2)}>
                                                                <div id="upload-dom">
                                                                    <video src="<{$row['akk_url']}>" style="width: 500px;<{if !$row['akk_url']}>display: none;<{else}>display: block;<{/if}>margin-bottom: 15px" id="playvideo" controls="controls"></video>
                                                                    <span class="btn btn-md btn-green upload-btn" onclick="toUploadMedia()"><{if $row && $row['akk_url']}>修改视频<{else}>添加视频<{/if}></span>
                                                                    <p class="tip">仅支持MP4格式</p>
                                                                    <a href="javascript:;" onclick="changeEnter(2)">手动填写链接</a>
                                                                </div>
                                                                <div id="enter-dom" style="display: none" >
                                                                    <input type="text" class="form-control" id="akk_url" name="akk_url" placeholder="请填写链接" required="required" value="<{if $row}><{$row['akk_url']}><{/if}>">
                                                                    <p class="tip">仅支持MP4格式</p>
                                                                    <a href="javascript:;" onclick="changeEnter(1)">上传视频</a>
                                                                </div>
                                                                <{else}>
                                                                <div style="margin-top: 8px;color: red;">
                                                                    您未配置存储信息 <a href="/wxapp/currency/video" target="_blank">前往配置</a>
                                                                </div>
                                                                <{/if}>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <{if $type == 1 || $type == 2 || $type == 3}>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                <{if $type == 2 || $type == 3}>
                                                                课程
                                                                <{else}>
                                                                图文
                                                                <{/if}>
                                                                详情：</label>
                                                            <div class="control-group">
                                                                <textarea class="form-control" style="width:80%;height:500px;visibility:hidden;" id = "akk_content" name="akk_content" placeholder="课程详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <{if $row && $row['akk_content']}><{$row['akk_content']}><{/if}>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="akk_content" />
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>推荐课程</span>
                                                    </div>
                                                    <div class="group-info" style="padding-left: 170px;">
                                                        <div class="form-group">
                                                            <div class="part" style="overflow: hidden;padding-bottom: 10px">
                                                                <div style="width: 78%;float: left;">
                                                                    <label for="">推荐课程</label>
                                                                </div>
                                                                <div style="width: 18%;float: right;">
                                                                    <label for=""><span>
                                                                        <span class="btn btn-sm btn-primary goods-button btn-goods">添加</span>
                                                                        <span class="btn btn-sm btn-danger goods-button btn-remove-all">清空</span>
                                                                    </span></label>
                                                                </div>
                                                            </div>
                                                            <div class="topic goods-selected-list">
                                                                <{if $goodsList}>
                                                                <{foreach $goodsList as $goods}>
                                                                <div class='goods-name goods-selected' gid='<{$goods['g_id']}>' ><div class='goods-selected-name'><{$goods['g_name']}></div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>
                                                                <{/foreach}>
                                                                <{else}>
                                                                <span class="goods-name goods-none" style="font-weight: bold;color: #38f">
                                                                    无推荐课程
                                                                </span>
                                                                <{/if}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </form>
                                </div>

                                <div class="row-fluid wizard-actions" style="text-align: center">
                                    <button class="btn btn-primary" onclick="saveGoods('save');">
                                        保存
                                    </button>
                                </div>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<div id="bulk_shipment" style="display: none;padding:5px 20px;">
    <div class="upload-tips">
        <form enctype="multipart/form-data" id="testform" method="post">
            <input name="key" id="key" type="hidden" value="<{$key}>">
            <input name="token" id="uploadToken" type="hidden" value="<{$token}>">
            <input name="accept" type="hidden" />
            <label style="height:35px;line-height: 35px;">本地上传</label>
            <span class="upload-input">选择文件<input class="avatar-input" id="userfile" onchange="selectedFile(this)" name="file" type="file"></span>
            <{if $type == 2}>
            <p style="height:35px;line-height: 35px;" id="filePath"><i class="icon-warning-sign red bigger-100"></i>请上传MP3格式类型的音频文件</p>
            <{/if}>
            <{if $type == 3}>
            <p style="height:35px;line-height: 35px;" id="filePath"><i class="icon-warning-sign red bigger-100"></i>请上传MP4格式类型的视频文件</p>
            <{/if}>
        </form>
        <div class="upload-progress" style="padding-top:10px;">
            <div class="layui-progress" lay-showpercent="true" lay-filter="demo">
                <div class="layui-progress-bar" lay-percent="0"></div>
            </div>
        </div>
        <div class="uploaded-result" style="width: 350px;padding: 5px 0;">

        </div>
    </div>
</div>
<div id="goods-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">推荐课程</h4>
            </div>
            <div class="modal-body">
                <div class="good-search" style="margin-top: 20px">
                    <div class="input-group">
                        <input type="text" id="keyword" class="form-control" placeholder="搜索课程">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchGoodsPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr>
                <table  class="table-responsive">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <thead>
                    <tr>
                        <th>课程图片</th>
                        <th style="text-align:left">课程名称</th>
                        <th>操作</th>
                    </thead>

                    <tbody id="goods-tr">
                    <!--课程列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/layui/layui.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script type="text/javascript" src="/public/plugin/tencentyun/cos-js-sdk-v5.min.js"></script>

<script>
    //    var filePath=document.getElementById("上传控件id").value;
    //    var fileType=filePath.substr(filePath.lastIndexOf("\.")).toLowerCase();
    var index = '';
    var domain  = "<{$qnDomain}>";
    var type  = "";
    var qiniu = "<{$qiniu}>";

    var tencentyun = "<{$tencentyun}>";
    var qdomain     = "<{$tencentyun['at_host']}>";

    var mediaProvider = "<{$mediaProvider}>";

    var config = {
        Bucket: "<{$tencentyun['at_bucket_name']}>",
        Region: "<{$tencentyun['at_bucket_zone']}>"
    };

    // 上传逻辑
    function uplode() {
        // 获取上传视频的格式
        var filepath = $('#filePath').text();
        console.log(filepath);
        var fileType=filepath.substr(filepath.lastIndexOf("\.")).toLowerCase();
        console.log(fileType);
        if(<{$type}> == 2 && fileType!='.mp3' ){
            layer.msg('请上传MP3格式的音频文件');
            return
        }

        if(<{$type}> == 3 && fileType!='.mp4' ){
            layer.msg('请上传MP4格式的视频文件');
            return
        }

        var info = new FormData(document.getElementById("testform"));
        var $uploadedResult = $('.uploaded-result');
        index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            url: "<{$uploadUrl}>",  // 不同的地区有不同的上传URL；华东：https://up.qbox.me；华北：https://up-z1.qbox.me，华南：https://up-z2.qbox.me，北美：https://up-na0.qbox.me
            type: 'POST',
            data: info,
            processData: false,
            contentType: false,
            xhr: function(){
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',function(e) {
                        if (e.lengthComputable) {
                            var percent = e.loaded/e.total*100;
                            $('.upload-progress').stop().show();
                            // console.log(e.loaded + "/" + e.total);
                            // console.log(parseInt(percent)+'%');

                            layui.use('element', function(){
                                var $ = layui.jquery,
                                    element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块
                                //触发事件
                                var active = {
                                    loading: function(){
                                        n = parseInt(percent);
                                        layui.element().progress('demo', n+'%');
                                    }
                                };
                                active.loading();
                            });
                        }
                    }, false);
                }
                return myXhr;
            },
            success: function(res) {
                layer.closeAll();
                $('.upload-progress').stop().hide();
                // var str = '<p style="margin-bottom:8px;margin-left: 0;">已上传：' + res.key + '</p>';
                if (res.key ) {
                    filePath = domain +'/'+res.key;
                    <{if $type == 2}>
                    $('#playaudio').attr('src',filePath+'?v='+Math.ceil(Math.random()*1000));
                    $('#playaudio').css('display','block');
                    <{/if}>
                    <{if $type == 3}>
                        $('#playvideo').attr('src',filePath+'?v='+Math.ceil(Math.random()*1000));
                        $('#playvideo').css('display','block');
                    <{/if}>
                    $('#akk_url').val(filePath);
                }
            },
            error: function(res) {
                console.log("失败:" +  JSON.stringify(res));
                $uploadedResult.html('上传失败请稍后重试，失败原因：' + res.responseText);
                layer.close(index);
            }
        });
    }

    var getAuthorization = function (options, callback) {
        $.get('/wxapp/currency/tencentUploadCfg', {
            // 可从 options 取需要的参数
        }, function (data) {
            data = JSON.parse(data);
            var credentials = data.data.credentials;
            callback({
                TmpSecretId: credentials.tmpSecretId,
                TmpSecretKey: credentials.tmpSecretKey,
                XCosSecurityToken: credentials.sessionToken,
                ExpiredTime: data.data.expiredTime
            });
        });
    };

    var cos = new COS({
        getAuthorization: getAuthorization,
    });

    function putObject() {
        var key = $('#key').val();
        // 获取上传视频的格式
        var filepath = $('#filePath').text();
        console.log(filepath);
        var fileType=filepath.substr(filepath.lastIndexOf("\.")).toLowerCase();
        console.log(fileType);
        if(<{$type}> == 2 && fileType!='.mp3' ){
            layer.msg('请上传MP3格式的音频文件');
            return
        }

        if(<{$type}> == 3 && fileType!='.mp4' ){
            layer.msg('请上传MP4格式的视频文件');
            return
        }

        var $uploadedResult = $('.uploaded-result');
        index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        // 调用方法
        cos.putObject({
            Bucket: config.Bucket, // Bucket 格式：test-1250000000
            Region: config.Region,
            Key: key,
            Body: document.getElementById('userfile').files[0],
            onTaskReady: function (tid) {
                TaskId = tid;
                console.log('onTaskReady', tid);
            },
            onTaskStart: function (info) {
                console.log('onTaskStart', info);
            },
            onProgress: function (progressData) {
                var percent = progressData.loaded/progressData.total*100;
                $('.upload-progress').stop().show();

                layui.use('element', function(){
                    var $ = layui.jquery,
                        element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块
                    //触发事件
                    var active = {
                        loading: function(){
                            n = parseInt(percent);
                            layui.element().progress('demo', n+'%');
                        }
                    };
                    active.loading();
                });
            },
        }, function (err, data) {
            layer.closeAll();
            if(data.statusCode == 200){
                $('.upload-progress').stop().hide();
                filePath = qdomain +'/'+key;
                <{if $type == 2}>
                $('#playaudio').attr('src',filePath+'?v='+Math.ceil(Math.random()*1000));
                $('#playaudio').css('display','block');
                <{/if}>
                <{if $type == 3}>
                $('#playvideo').attr('src',filePath+'?v='+Math.ceil(Math.random()*1000));
                $('#playvideo').css('display','block');
                <{/if}>
                $('#akk_url').val(filePath);
            }else{
                $uploadedResult.html('上传失败请稍后重试');
                layer.close(index);
            }
        });
    }

    // 选择视频文件
    function selectedFile(obj){
        var path = $(obj).val();
        $(obj).parents('form').find('p').text(path);
    }

    function changeEnter(type) {
        if(type == 1){
            $('#upload-dom').show();
            $('#enter-dom').hide();
        }
        if(type == 2){
            $('#upload-dom').hide();
            $('#enter-dom').show();
        }
    }


    /**
     * 上传触发
     * @param that
     */
    function toUploadMedia(){
        $('.uploaded-result').html('');
        $('.upload-progress').stop().hide();
        var layIndex = layer.open({
            type: 1,
            title: '添加音频',
            shadeClose: true, //点击遮罩关闭
            shade: 0.6, //遮罩透明度
            skin: 'layui-anim',
            area: ['500px', '230px'], //宽高
            btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
            content: $("#bulk_shipment"),
            yes : function() {
                if(mediaProvider == 1){
                    uplode();
                }else{
                    putObject();
                }
            }
        });
    }

    /**
     * 保存课程信息
     */
    function saveGoods(){
        var load_index = layer.load(
            2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        var gids     = [];
        //保存推荐课程
        $('.goods-selected').each(function () {
            var gid = $(this).attr('gid');
            gids.push(gid)
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/saveGoodsKnowledge',
            'data'  : $('#goods-form').serialize()+'&gids='+JSON.stringify(gids),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.href="/wxapp/knowledgepay/goodsKnowledgeList/?id=<{$gid}>";
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    //管理课程
    $('.btn-goods').on('click',function(){
        //初始化
        var num = $('.goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个课程');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');

        $('.th-weight').hide();

        $('#goods-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage);
    });

    function fetchGoodsPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            'id'    :  $('#currId').val()  ,
            'page'  : page,
            'keyword': $('#keyword').val(),
            'knowpayType': <{$type}>
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/giftGoods',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].g_id+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p></td>';
            html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealGoods( this )"> 选取 </td>';
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }

    //选择关联课程
    function dealGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此课程，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //移除关联课程
    function removeGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐课程 </span>';
            $('.goods-selected-list').html(default_html);
        }
    }

    //清空关联课程
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐课程 </span>';
        $('.goods-selected-list').html(default_html);
    });



</script>
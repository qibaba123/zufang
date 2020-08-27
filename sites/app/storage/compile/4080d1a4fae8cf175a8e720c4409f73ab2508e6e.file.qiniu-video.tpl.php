<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 10:00:55
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/qiniu-video.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13240080955e4f39d7835d31-63808359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4080d1a4fae8cf175a8e720c4409f73ab2508e6e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/qiniu-video.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13240080955e4f39d7835d31-63808359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'qiniu' => 0,
    'list' => 0,
    'val' => 0,
    'pagination' => 0,
    'qnDomain' => 0,
    'uploadUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f39d7871ea2_90361718',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f39d7871ea2_90361718')) {function content_5e4f39d7871ea2_90361718($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<style>
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }
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

    .btn-cyan, .btn-cyan:focus {
        background-color: #00c4ba !important;
        border-color: #00bfb4;
    }
</style>

<div id="content-con">
    <audio id='audio' style="display: none"></audio>
    <video id='video' style="display: none" ></video>
    <div class="authorize-tip flex-wrap">
        <div class="shop-logo">
            <img src="/public/wxapp/images/qiniu-icon.jpeg" alt="logo">
        </div>
        <div class="flex-con">
            <h4>七牛云对象存储</h4>
        </div>
        <div class="opera-btn-box"><a href="javascript:void(0)" onclick="changeServer(this,event)" class="btn btn-sm btn-cyan">切换腾讯云</a></div>
    </div>
    <div class="authorize-tip flex-wrap">
        <div class="shop-logo">
        <img src="/public/wxapp/setup/images/wechat_avatar.png" alt="logo">
        </div>
        <div class="flex-con">
            <h4>音视频管理</h4>
            <?php if ($_smarty_tpl->tpl_vars['qiniu']->value) {?>
            <p class="state" style="color: #999;">
                <span>您已配置七牛信息，修改时会有5分钟左右的延迟，请稍后刷新重试</span>
            </p>
            <?php } else { ?>
            <p class="state" style="color: orangered;">
                <span>您尚未配置七牛信息</span>
                <span style="margin-left: 25px;"><a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=347&page=1&extra=#pid9981" style="color:red;">查看配置教程</a></span>
            </p>
            <?php }?>
        </div>
        <div>
            <a href="/wxapp/currency/qiniu" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 七牛配置</a>
            <a href="javascript:;" class="btn btn-sm btn-green" onclick="syncDomain(this, event)">重置服务器域名</a>
        </div>
    </div>
    <div  id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">
        <div class="page-header">
            <a href="#" class="btn btn-green btn-xs" onclick="addVideo()" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 文件上传</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>类型</th>
                            <th>地址</th>
                            <th>时长</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                最近更新</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_title'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_type'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_video_url'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_time'];?>
s</td>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['aqv_update_time']);?>
</td>
                                <td>
                                    <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_id'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_title'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_video_url'];?>
" onclick="editVideo(this)" class="btn btn-xs btn-green">重传</a>
                                    <a href="#" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_video_url'];?>
" class="copy_input btn btn-xs btn-green">复制链接</a>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_video_url'];?>
?v=<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_time'];?>
" target="_blank" class="btn btn-xs btn-green">预览</a>
                                    <a href="#" id="delete-confirm"  onclick="deleteVideo('<?php echo $_smarty_tpl->tpl_vars['val']->value['aqv_id'];?>
')" class="btn btn-xs btn-danger del-btn">删除</a>
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

<div id="bulk_shipment" style="display: none;padding:5px 20px;">
    <div class="upload-tips">
        <form enctype="multipart/form-data" id="testform" method="post">
            <input name="key" id="key" type="hidden" value="">
            <input name="token" id="uploadToken" type="hidden" value="">
            <input name="id" type="hidden" id="id" />
            <input name="accept" type="hidden" />
            <div style="margin: 30px 0;height: 40px;">
                <label style="height:35px;line-height: 35px;float: left;">文件名称</label>
                <input name="name" type="text" id="name" class="form-control" style="width: 80%;float: left;"/>
            </div>
            <label style="height:35px;line-height: 35px;">本地上传</label>
            <span class="upload-input">选择文件<input class="avatar-input" id="userfile" onchange="selectedFile(this)" name="file" type="file"></span>
            <p style="height:35px;line-height: 35px;" id="filePath"><i class="icon-warning-sign red bigger-100"></i>请上传MP4/MP3格式类型的文件</p>
            <div style="font-size: 14px;margin-top: 10px;margin-bottom: 20px" >注意　<span id="show-notice">最大支持100M(MP4格式)和20M(MP3格式)的文件。</span></div>
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
<?php echo $_smarty_tpl->getSubTemplate ("../bs-alert-tips.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/layui/layui.js"></script>

<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        showTips('复制成功');
    } );

    //    var filePath=document.getElementById("上传控件id").value;
    //    var fileType=filePath.substr(filePath.lastIndexOf("\.")).toLowerCase();
    var index = '';
    var domain  = "<?php echo $_smarty_tpl->tpl_vars['qnDomain']->value;?>
";
    var type  = "";
    var qiniu = "<?php echo $_smarty_tpl->tpl_vars['qiniu']->value;?>
"
    // 上传逻辑
    function uplode(key, token) {
        var name = $('#name').val();
        if(!name){
            layer.msg('请填写文件名称');
            return
        }
        // 获取上传视频的格式
        var filepath = $('#filePath').text();
        console.log(filepath);
        var fileType=filepath.substr(filepath.lastIndexOf("\.")).toLowerCase();
        console.log(fileType);
        type = fileType=='.mp4'?'mp4':'mp3';
        if(fileType!='.mp4' && fileType!='.mp3'){
            layer.msg('请上传MP4格式的视频文件或MP3格式的音频文件');
            return
        }
        var fileSize = document.getElementById('userfile').files[0].size;  // 获取上传视频的大小单为B
        fileSize = parseFloat((fileSize/(1024*1024)).toFixed(1));
        if(fileSize>100 && fileType=='.mp4'){
            layer.msg('请上传100M以内的视频文件');
            return
        }
        if(fileSize>20 && fileType=='.mp3'){
            layer.msg('请上传20M以内的音频文件');
            return
        }
        /*var info = new FormData(document.getElementById("testform"));*/
        var info = new FormData();
        info.append('key', key);
        info.append('token', token);
        info.append('accept', "");
        info.append('file', document.getElementById('userfile').files[0]);
        var $uploadedResult = $('.uploaded-result');
        index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        console.log(info);
        $.ajax({
            url: "<?php echo $_smarty_tpl->tpl_vars['uploadUrl']->value;?>
",  // 不同的地区有不同的上传URL；华东：https://up.qbox.me；华北：https://up-z1.qbox.me，华南：https://up-z2.qbox.me，北美：https://up-na0.qbox.me
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
                $('.upload-progress').stop().hide();
                // var str = '<p style="margin-bottom:8px;margin-left: 0;">已上传：' + res.key + '</p>';
                if (res.key ) {
                    filePath = domain +'/'+res.key;
                    var duration = 0;
                    if(type=='mp3'){
                        $('#audio').attr("src", getObjectURL(document.getElementById('userfile').files[0]));
                        getTime('audio', filePath);
                    }else{
                        $('#video').attr("src", getObjectURL(document.getElementById('userfile').files[0]));
                        $('#video').load();
                        getTime('video', filePath);
                    }

                }
                //  $uploadedResult.html(str);
            },
            error: function(res) {
                console.log("失败:" +  JSON.stringify(res));
                $uploadedResult.html('上传失败请稍后重试，失败原因：' + res.responseText);
                layer.close(index);
            }
        });
    }

    <!--把文件转换成可读URL-->
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) { // basic
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }

    function deleteVideo(id){
    	layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/currency/deleteVideo',
	            'data'  : {id: id},
	            'dataType'  : 'json',
	            'success'   : function(ret){
	                layer.close(index);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }else{
	                    layer.msg(ret.em);
	                }
	            }
	        });
        });
    }

    function getTime(type, filePath){
        setTimeout(function () {
            var duration = $("#"+type)[0].duration;
            console.log(duration);
            if(isNaN(duration)){
                getTime(type,filePath);
            }else{
                /*var video = document.getElementById("video");
                video.currentTime=5;
                var canvas = document.createElement("canvas");
                canvas.width = video.videoWidth * 0.8;
                canvas.height = video.videoHeight * 0.8;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var img = document.createElement("img");
                img.src = canvas.toDataURL("image/png");*/
                saveVideo(filePath, duration);
            }
        }, 10);
    }

    function syncDomain(obj, event) {
        event.preventDefault();
        layer.msg('确定再次同步服务器域名？', {
            time: 0 //不自动关闭
            ,btn: ['确定', '取消']
            ,yes: function(index){
                layer.close(index);
                var loading = layer.load(2, {time: 10*1000});
                $.ajax({
                    type    : 'post',
                    url     : '/wxapp/setup/syncDomain',
                    data    : '',
                    dataType: 'json',
                    success : function(ret){
                        layer.close(loading);
                        if(ret.ec == 200){
                            layer.msg('服务器域名同步成功', {
                                time: 0 //不自动关闭
                                ,btn: ['确定']
                                ,yes: function(index){
                                    layer.close(index);
                                    location.reload();
                                }
                            });
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }
        });
    }


    // 选择视频文件
    function selectedFile(obj){
        var path = $(obj).val();
        $(obj).parents('form').find('p').text(path);
    }

    function getUplode(){
        var filepath = $('#filePath').text();
        var fileType=filepath.substr(filepath.lastIndexOf("\.")).toLowerCase();
        var key = $('#key').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/uploadCfg',
            'data'  : {type: fileType, key: key},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    uplode(ret.data.key, ret.data.token);
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    //编辑视频
    function editVideo(e){
        $('#name').val($(e).data('title'));
        $('#id').val($(e).data('id'));
        $('#key').val($(e).data('url').split('/')[$(e).data('url').split('/').length - 1]);
        toUpload();
    }

    //添加视频
    function addVideo(){bulk_shipment
        $('#name').val('');
        $('#id').val('');
        $('#key').val('');
        toUpload();
    }

    /**
     * 上传触发
     * @param that
     */
    function toUpload(){
        if(!qiniu){
            layer.msg('请先配置七牛信息');
            return
        }
        $('.uploaded-result').html('');
        $('.upload-progress').stop().hide();
        var layIndex = layer.open({
            type: 1,
            title: '文件上传',
            shadeClose: true, //点击遮罩关闭
            shade: 0.6, //遮罩透明度
            skin: 'layui-anim',
            area: ['500px', '350px'], //宽高
            btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
            content: $("#bulk_shipment"),
            yes : function() {
                getUplode();
            }
        });
    }

    // 保存视频信息
    function saveVideo(url, duration) {
        var name = $('#name').val();
        var id = $('#id').val();
        if(url){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/saveQiniuVideo',
                'data'  : { videoUrl:url,name: name, type: type, id: id, duration: duration},
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    }

    function changeServer(obj, event) {
        layer.msg('你确定要切换为腾讯云？', {
            time: 0 //不自动关闭
            ,btn: ['切换', '不切换']
            ,yes: function(index){
                layer.close(index);
                var loading = layer.load(2, {time: 10*1000});
                $.ajax({
                    type    : 'post',
                    url     : '/wxapp/currency/changeMediaProvider',
                    data    : {type: 2},
                    dataType: 'json',
                    success : function(ret){
                        layer.close(loading);
                        location.reload();
                    }
                });
            }
        });
    }

</script>
<?php }} ?>

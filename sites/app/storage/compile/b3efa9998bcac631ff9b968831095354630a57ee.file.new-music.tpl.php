<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:44:24
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/new-music.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7125033905e4df288817b52-76152416%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3efa9998bcac631ff9b968831095354630a57ee' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/new-music.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7125033905e4df288817b52-76152416',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'key' => 0,
    'token' => 0,
    'qnDomain' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df288854df8_83665995',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df288854df8_83665995')) {function content_5e4df288854df8_83665995($_smarty_tpl) {?><link rel="stylesheet" href="/public/plugin/layui/css/layui.css"  media="all">
<style>
    .page-content{
        margin-left: 140px;
    }
    .video-box{
        padding-top: 20px;
    }
    .video-con{
        width: 500px;
        height: 60px;
        margin:0 auto;
    }
    .video-con img{
        width: 100%;
        height: 100%;
    }
    .video-con video{
        width: 100%;
        height: 100%;
    }
    .btn-area{
        padding: 30px 0;
        text-align: center;
    }
    .btn-area .btn{
        margin:0 3px;
    }
    .prompt{
        text-align: center;
        color:#999;
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
    .tgl {
        display: none
    }
    .tgl, .tgl *, .tgl:after, .tgl:before, .tgl+.tgl-btn, .tgl:after, .tgl:before {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box
    }
    .tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection, .tgl+.tgl-btn::-moz-selection, .tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection {
        background: 0 0
    }
    .tgl::selection, .tgl:after::selection, .tgl:before::selection, .tgl+.tgl-btn::selection, .tgl::selection, .tgl:after::selection, .tgl:before::selection {
        background: 0 0
    }
    .tgl+.tgl-btn {
        outline: 0;
        display: block;
        width: 4em;
        height: 2em;
        position: relative;
        cursor: pointer
    }
    .tgl+.tgl-btn:after, .tgl+.tgl-btn:before {
        position: relative;
        display: block;
        content: "";
        width: 50%;
        height: 100%
    }
    .tgl+.tgl-btn:after {
        left: 0
    }
    .tgl+.tgl-btn:before {
        display: none
    }
    .tgl:checked+.tgl-btn:after {
        left: 50%
    }
    .tgl-light+.tgl-btn {
        background: #ddd;
        border-radius: 2em;
        padding: 2px;
        -webkit-transition: all .4s ease;
        transition: all .4s ease
    }
    .tgl-light+.tgl-btn:after {
        border-radius: 50%;
        background: #fff;
        -webkit-transition: all .2s ease;
        transition: all .2s ease
    }
    .tgl-light:checked+.tgl-btn {
        background: #00CA4D
    }
    .isOn{
        display: inline-block;
        margin-left: 30px;
    }
    .isOn>span{
        display: inline-block;
        vertical-align: middle;
        font-weight: bold;
        margin-right: 10px;
    }

    .btn-area {
        padding: 10px 0 30px 0;
        text-align: center;
        width: 640px;
        margin: auto;
    }
    .part1{
    	padding: 30px 0;
	    border: 1px solid #ccc;
	    width: 600px;
	    margin: 20px auto;
    }
    .part2{
    	width: 600px;
	    padding: 30px 0;
	    margin: 0 auto;
	    border: 1px solid #ccc;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="alert alert-block alert-yellow ">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    重要提示：上传音频仅支持mp3格式,音频大小控制在20M以内,以保证播放流畅不卡顿!
</div>
<div class="video-box">
    <div style="text-align: center;margin-bottom: 30px;">
        <div class="isOn">
            <span>开启背景音乐:</span>
            <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='music_is_open' type='checkbox' onclick="changeOpen()" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['av_music_isopen']) {?>checked<?php }?> >
                            <label class='tgl-btn' for='music_is_open'></label>
                </span>
        </div>
    </div>

    <div class="prompt">
        <span style="display: block">可选择上传音频或填写音频链接, 二选一</span>
        <span>此处添加的音频将用于小程序背景音乐使用，修改音频时会有延迟，请稍后刷新重试</span>
    </div>
    <div class="cfg-box" <?php if (!$_smarty_tpl->tpl_vars['row']->value||$_smarty_tpl->tpl_vars['row']->value['av_music_isopen']==0) {?>style="display:none"<?php }?>>
    <div class="part1">
    	<div class="video-con " >
	        <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['av_music_url']) {?>
	        <audio style="width: 500px" class="playvideo" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['av_music_url'];?>
?v=<?php echo time();?>
" preload="preload" controls="controls" loop="loop"></audio>
	        <?php }?>
	    </div>
	    <div class="btn-area " style="padding: 22px 0 10px 0;">
	        <span class="btn btn-md btn-green" onclick="toUpload()"><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['av_music_url']) {?>重新上传<?php } else { ?>添加音频<?php }?></span>
	    </div>
    </div>
    <div style="text-align: center;font-size: 20px;margin-bottom:30px;" class="">或</div>
    <div class="part2">
    	<div style="width: 545px;margin:0 auto;" class="">
	        <span class="form-title" style="margin-right: 5px">填写音乐名称</span>
	        <input style="display: inline-block;width: 82%" type="text" id="music_title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['av_music_title'];?>
" class="form-control" placeholder="请填写音乐名称">
	    </div>
	    <div class="btn-area " style="width:600px;">
	        <span class="form-title">填写音频链接</span>
	        <input style="display: inline-block;width: 75%" type="text" id="video-url" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['av_music_url'];?>
" class="form-control" placeholder="请填写音乐链接">
	        <!--<span class="btn btn-md btn-green" onclick="saveMusicUrl()">保存</span>-->
	    </div>
    </div>
    <span style="display: block;margin: 30px auto;width: 100px;" class="btn btn-md btn-green" onclick="saveMusicUrl()">保存</span>
    <!--<div style="width: 640px;margin: auto;" class="">
        <span class="form-title" style="margin-right: 5px">填写音乐名称</span>
        <input style="display: inline-block;width: 75%" type="text" id="music_title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['av_music_title'];?>
" class="form-control" placeholder="请填写音乐名称">
    </div>
    <div class="btn-area ">
        <span class="form-title">填写音频链接</span>
        <input style="display: inline-block;width: 75%" type="text" id="video-url" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['av_music_url'];?>
" class="form-control" placeholder="请填写音乐链接">
        <span class="btn btn-md btn-green" onclick="saveMusicUrl()">保存</span>
    </div>-->
    </div>
</div>
<div id="bulk_shipment" style="display: none;padding:5px 20px;">
    <div class="upload-tips ">
        <form enctype="multipart/form-data" id="testform" method="post">
            <input name="key" id="key" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
            <input name="token" id="uploadToken" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
">
            <input name="accept" type="hidden" />
            <label style="height:35px;line-height: 35px;">本地上传</label>
            <span class="upload-input">选择文件<input class="avatar-input" id="userfile" onchange="selectedFile(this)" name="file" type="file"></span>
            <p style="height:35px;line-height: 35px;" id="filePath"><i class="icon-warning-sign red bigger-100"></i>请上传MP3格式类型的音频文件</p>
            <div style="font-size: 14px;margin-top: 10px;margin-bottom: 20px" >注意　<span id="show-notice">最大支持20M(MP3格式)的音频文件。</span></div>
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
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/layui/layui.js"></script>

<script>
    //    var filePath=document.getElementById("上传控件id").value;
    //    var fileType=filePath.substr(filePath.lastIndexOf("\.")).toLowerCase();
    var index = '';
    var domain  = "<?php echo $_smarty_tpl->tpl_vars['qnDomain']->value;?>
";
    // 上传逻辑
    function uplode() {
        // 获取上传视频的格式
        var filepath = $('#filePath').text();
        console.log(filepath);
        var fileType=filepath.substr(filepath.lastIndexOf("\.")).toLowerCase();
        console.log(fileType);
        if(fileType!='.mp3'){
            layer.msg('请上传MP3格式的音频文件');
            return
        }
        var fileSize = document.getElementById('userfile').files[0].size;  // 获取上传视频的大小单为B
        fileSize = parseFloat((fileSize/(1024*1024)).toFixed(1));
        console.log(fileSize);
        if(fileSize>20){
            layer.msg('请上传20M以内的音频文件');
            return
        }
        var info = new FormData(document.getElementById("testform"));
        var $uploadedResult = $('.uploaded-result');
        index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            url: 'https://up-z2.qbox.me',  // 不同的地区有不同的上传URL；华东：https://up.qbox.me；华北：https://up-z1.qbox.me，华南：https://up-z2.qbox.me，北美：https://up-na0.qbox.me
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
                    saveMusic(filePath);
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

    // 选择视频文件
    function selectedFile(obj){
        var path = $(obj).val();
        $(obj).parents('form').find('p').text(path);
    }


    /**
     * 上传触发
     * @param that
     */
    function toUpload(){
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
                uplode();
            }
        });
    }

    function saveMusicUrl(){
        var url = $('#video-url').val();
        var title = $('#music_title').val();
        var open   = $('#music_is_open:checked').val();
        saveMusic(url,title,open);
    }

    // 保存视频信息
    function saveMusic(url,title,open='on') {
        console.log(url);
        if(url){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/saveMusic',
                'data'  : { musicUrl:url, title: title, open:open == 'on' ? 1 : 0},
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

    function changeOpen() {
        var open   = $('#music_is_open:checked').val();
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        console.log('开关'+open);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveMusicOpen',
            'data'  : { open:open == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
                    console.log(ret.em);
//                if(ret.ec == 200){
					console.log('开关2'+ret.open);
                    if(ret.open == 1){
                        $('.cfg-box').css('display','block');
                    }else{
                        $('.cfg-box').css('display','none');
                    }
                    layer.close(index);
                }
        });
    }
</script><?php }} ?>

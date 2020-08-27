<!DOCTYPE HTML>
<html>
<head>
    <title>管理系统</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/manage/css/bangding.css?2">
    <script src="/public/common/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div class="wrap">
    <div class="wechat-setting" style="max-width: 1200px;">
        <div class="bind-wechat">
            <div class="left">
                <h4>一键授权 轻松创建小程序</h4>
                <p>授权之后 即可通过小程序业务助手自助完成小程序生成步骤</p>
                <div class="opera-btn">
                    <a href="<{$auth_uri}>" data-authuri="<{$auth_uri}>" class="have-btn">一键授权接入</a>
                    <!--<a href="<{$domain}>/wxapp/guide/editAuth" class="no-btn">手动接入(不推荐使用)</a>-->
                </div>
            </div>
            <div class="right">
                <ul>
                    <li><span>扫描二维码选择名下需授权的小程序</span></li>
                    <li><span>授权即代表同意通过小程序业务助手创建并管理小程序</span></li>
                    <li><span>授权之后即可根据提示步骤自助生成小程序</span></li>
                    <li><span>操作中如遇问题请及时联系客服协助解决</span></li>
                </ul>
            </div>
        </div>
        <div class="alert alert-block alert-yellow ">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            重要提示：请确认您要授权的小程序,授权成功后不支持更换、解绑等逆向操作。
        </div>
        <div class="function-intro">
            <ul>
                <li>
                    <p>
                        <img src="/public/manage/img/function_1.png" alt="图标">
                        <span>免提交<br>代码</span>
                    </p>
                </li>
                <li>
                    <p>
                        <img src="/public/manage/img/function_2.png" alt="图标">
                        <span>自动<br>更新</span>
                    </p>
                </li>
                <li>
                    <p>
                        <img src="/public/manage/img/function_3.png" alt="图标">
                        <span>自动提交<br>审核</span>
                    </p>
                </li>
                <li>
                    <p>
                        <img src="/public/manage/img/function_4.png" alt="图标">
                        <span>多行业<br>方案</span>
                    </p>
                </li>
                <li>
                    <p>
                        <img src="/public/manage/img/function_5.png" alt="图标">
                        <span>一键换<br>模板</span>
                    </p>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/controllers/custom.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>
    $(function() {
        //设置指定时间后页面刷新，以重新获取预授权码
        var expires = 600*1000;
        window.setTimeout(function() {
            window.location.reload();
        }, expires);
    });

    function openAuthTip(obj) {
        layer.confirm('请在新窗口中完成微信公众号授权', {
            skin : 'layui-layer-molv',
            closeBtn: 0,
            btn : ['已完成设置', '授权失败，重试']
        }, function(){
            location.replace('/wxapp/index');
        }, function(index){
            layer.close(index);
            //window.open($(obj).attr('href'));
        });
    }

    function openAuthuri(obj, event) {
        event.preventDefault();
        var authuri	= $(obj).data('authuri');
        window.open(authuri);
    }
</script>
</body>
</html>

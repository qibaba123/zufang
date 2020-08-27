<link rel="stylesheet" href="/public/manage/css/bangding.css?2">
<style>
    .main-content{
        margin-left: 140px;
    }
</style>
<div class="wrap">
    <div class="wechat-setting" style="max-width: 1200px;">
        <div class="bind-wechat">
            <div class="left">
                <h4>一键授权 轻松接入分身小程序</h4>
                <p>授权之后 即可通过天店通自助接入分身小程序</p>
                <div class="opera-btn">
                    <a onclick="openAuthuri(this, event)" href="javascript:void(0)" data-authuri="<{$auth_uri}>" class="have-btn">一键授权接入(强烈推荐)</a>
                    <!--
                    <a href="/manage/wechat/edit" class="no-btn">普通接入(不推荐使用)</a>
                    -->
                </div>
            </div>
            <div class="right">
                <ul>
                    <li><span>扫描二维码选择名下需授权的小程序</span></li>
                    <li><span>授权即代表同意通过天店通创建并管理小程序</span></li>
                    <li><span>授权之后即可根据提示步骤自助生成小程序</span></li>
                    <li><span>操作中如遇问题请及时联系客服协助解决</span></li>
                </ul>
            </div>
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
//        var host	= location.hostname;
//        if (host.toLowerCase() == 'www.tiandiantong.com') {
//            var authuri	= $(obj).data('authuri');
//            window.open(authuri);
//        } else {
//            layer.open({
//                type: 1
//                ,title: false //不显示标题栏
//                ,closeBtn: false
//                ,area: '300px;'
//                ,shade: 0.8
//                ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
//                ,resize: false
//                ,btn: ['重新登录', '暂不授权']
//                ,btnAlign: 'c'
//                ,moveType: 1 //拖拽模式，0或者1
//                ,content: '<div style="padding: 30px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
//                '由于在微信开放平台中绑定的域名为: www.tiandiantong.com,与当前访问域名(' + location.hostname +
//                ')不符,如欲继续授权,需要在www.tiandiantong.com域名下的管理后台重新登录。' +
//                '<span style="color: orangered;">如遇提示为非安全性网站,请忽略,并继续访问,或者<a href="http://se.360.cn/" style="color: #45d983;" target="_blank">下载360安全浏览器</a>访问。</span></div>'
//                ,success: function(layero){
//                    var btn = layero.find('.layui-layer-btn');
//                    btn.find('.layui-layer-btn0').attr({
//                        href: 'http://www.tiandiantong.com/manage/user/index'
//                        ,target: '_blank'
//                    });
//                }
//            });
//        }
    }
</script>
<link rel="stylesheet" href="/public/manage/colorPicker/spectrum.css">
<style>
.main-content { margin-left: 0; }
.tabbable .tab-content { margin-top: 10px; border: 1px solid #eee; border-radius: 3px; box-shadow: 0 0 10px #e8e8e8;padding:0; }
.tabbable .tab-content .label-title{padding: 0 15px;height: 48px;line-height: 48px;font-size: 16px;font-weight: bold;box-sizing: border-box;background-color: #f9f9f9;}
.tabbable .tab-content .tab-pane{padding:15px;}
.cus-input-group { display: table; padding: 6px 0; width: 100%; }
.cus-input-group .cus-label { width: 180px; text-align: right; font-weight: bold; font-size: 14px; vertical-align: top; height: 38px; line-height: 38px; box-sizing: border-box;padding-right: 10px;}
.cus-input-group .cus-input-box { display: table-cell; width: 100%; vertical-align: top; }
.cus-input-group .cus-input-box .form-control { box-shadow: none; border-radius: 0; border-color: #e8e8e8; height: 38px; }
.cus-input-group .cus-input-box .form-control:focus{border-color: #81c9f9;}
.cus-input-group .cus-input-box textarea.form-control { height: 80px; }
.cus-input-group .cropper-box{width: 100px;height: 100px;overflow:hidden;}
.cus-input-group .cropper-box img { width: 100px; margin-left: 0; }
</style>
<div class="tabbable">
    <div class="tab-content form-horizontal">
        <div class="label-title">授权管理</div>
        <!--客服配置-->
        <div id="home" class="tab-pane active">
            <div id="wxCfg" >
                <input type="hidden" name="cfg_id" id="cfg_id" value="0"/>
                <div class="cus-input-group">
                    <div class="cus-label">小程序名称（必填）：</div>
                    <div class="cus-input-box">
                        <input id="applet_name" name="applet_name" type="text" value="<{if $appletCfg && $appletCfg['ac_name']}><{$appletCfg['ac_name']}><{/if}>" class="form-control" placeholder="请输入您的小程序名称，4-32个字符">
                    </div>
                </div>
                <div class="cus-input-group">
                    <div class="cus-label">小程序头像（必填）：</div>
                    <div class="cus-input-box">
                        <div class="cropper-box" data-width="200" data-height="200" >
                            <img <{if $appletCfg['ac_avatar']}>src=<{$appletCfg['ac_avatar']}><{else}>src="/public/manage/img/zhanwei/zw_fxb_45_45.png"<{/if}> >
                            <input type="hidden" id="applet_avatar"  class="avatar-field bg-img" name="applet_avatar" value="<{if $appletCfg['ac_avatar']}><{$appletCfg['ac_avatar']}><{/if}>"/>
                        </div>
                    </div>
                </div>
                <div class="cus-input-group">
                    <div class="cus-label">小程序简介（必填）：</div>
                    <div class="cus-input-box">
                        <textarea id="applet_signature" name="applet_signature" class="form-control" placeholder="请输入您的小程序简介"><{if $appletCfg && $appletCfg['ac_signature']}><{$appletCfg['ac_signature']}><{/if}></textarea>
                    </div>
                </div>
                <div class="cus-input-group">
                    <div class="cus-label">原始ID（必填）：</div>
                    <div class="cus-input-box">
                        <input name="applet_id" type="text" class="form-control" id="applet_id" value="<{if $appletCfg && $appletCfg['ac_gh_id']}><{$appletCfg['ac_gh_id']}><{/if}>" <{if $appletCfg && $appletCfg['ac_gh_id']}>readonly<{/if}>  placeholder="以gh_开头,请正确填写,填写后将不能修改">
                    </div>
                </div>
                <div class="cus-input-group">
                    <div class="cus-label">AppID（必填）：</div>
                    <div class="cus-input-box">
                        <input name="applet_appid" type="text" class="form-control" id="applet_appid" value="<{if $appletCfg && $appletCfg['ac_appid']}><{$appletCfg['ac_appid']}><{/if}>" placeholder="应用ID,以wx开头，填写后不能修改" <{if $appletCfg && $appletCfg['ac_gh_id']}>readonly<{/if}> >
                    </div>
                </div>
                <div class="cus-input-group">
                    <div class="cus-label">AppSecret（必填）：</div>
                    <div class="cus-input-box">
                        <input name="applet_appsecret" type="text" class="form-control" id="applet_appsecret" value="<{if $appletCfg && $appletCfg['ac_appsecret']}><{$appletCfg['ac_appsecret']}><{/if}>" placeholder="应用秘钥,32位长">
                    </div>
                </div>
            </div>
            <!--提交操作-->
            <div style="padding: 10px 0;margin-top: 10px;padding-left: 180px;">
                <input type="hidden" id="cfgid" value="<{$appletCfg['ac_id']}>">
                <button class="btn btn-md btn-blue save-cfg">&nbsp;保 存&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<{$cropper['modal']}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.save-cfg').on('click',function(){
        var name  = $('#applet_name').val();
        var ghid  = $('#applet_id').val();
        var appid  = $('#applet_appid').val();
        var appsecret  = $('#applet_appsecret').val();
        var cfgid  = $('#cfgid').val();
        var avatar  = $('#applet_avatar').val();
        var signature  = $('#applet_signature').val();
        var nameLength = getStringLength(name);
        if(name=='' || nameLength<4 || nameLength>32){
            layer.msg('小程序名称信息有误，请检查');
            return;
        }
        if(ghid==''){
            layer.msg('请填写小程序的原始ID');
            return;
        }
        if(appid==''){
            layer.msg('请填写小程序的APPID');
            return;
        }
        if(avatar==''){
            layer.msg('请上传小程序的头像');
            return;
        }
        if(signature==''){
            layer.msg('请填写小程序的简介');
            return;
        }
        if(appsecret=='' || appsecret.length!=32){
            layer.msg('小程序的秘钥不正确，请检查');
            return;
        }
        if(name && ghid && appid && appsecret){
            var data = {
                appid     : appid,
                appsecret : appsecret,
                name      : name,
                ghid      : ghid,
                cfgid     : cfgid,
                avatar    : avatar,
                signature : signature
            };
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            console.log(data);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/guide/saveEditAuth',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    window.location.href='/wxapp/index';
                }
            });
        }else{
            layer.msg('填写信息有误请检查后重试');
        }
    });
    // 获取微信菜单的名称长度（一个汉字算两个字符，字母和数字算一个字符）
    function getStringLength(val) {
        var len = 0;
        for (var i = 0; i < val.length; i++) {
            var str = val.charAt(i);
            if (str.match(/[^\x00-\xff]/ig) != null) {
                len += 2;
            } else {
                len += 1;
            }
        }
        return len;
    }
</script>
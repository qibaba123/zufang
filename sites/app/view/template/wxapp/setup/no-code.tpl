<style>
/*页面样式*/
.breadcrumbs {z-index:1!important;}
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
.step-show { max-width: 1200px; margin: 0 auto; width: 95%; padding: 5px; overflow: hidden; position: relative;font-size: 0;}
.step-show .step-img { width: 24%; display: inline-block;vertical-align: middle; }
.step-show .step-img img { width: 100%; display: block; border: 1px solid #eee; box-shadow: 2px 2px 6px #ddd; }
.jiantou-tip { width: 14%;  display: inline-block;vertical-align: middle;}
</style>
<div class="authorize-wrap">
	<div class="authorize-tip flex-wrap">
		<div class="shop-logo">
			<img src="<{$ac_avatar}>" alt="logo">
		</div>
		<div class="flex-con">
			<h4><{$ac_name}> <span style="color: red; padding-left: 16px;">未授权</span></h4>
			<p class="state" style="color: #999;">
				<span>您未将小程序"开发管理与数据分析权限"授权给平台,将无法使用开发管理功能,你可以点击右侧按钮并按照如下教程重新授权。</span>
			</p>
		</div>
		<div>
			<!--<a href="<{$auth_uri}>" class="btn btn-sm btn-green">重新授权</a>-->
			<a href="javascript:void(0)" onclick="openAuthuri(this,event)" data-authdomain="<{$authdomain}>" data-authtype="<{$authtype}>" data-authuri="<{$authcode}>" class="btn btn-sm btn-green">重新授权</a>
		</div>
	</div>
	<div class="step-show">
		<div class="step-img">
			<img src="/public/wxapp/images/step-1.png" alt="步骤提示">
		</div>
		<img src="/public/wxapp/images/step-tip.png" class="jiantou-tip" alt="箭头">
		<div class="step-img">
			<img src="/public/wxapp/images/step-2.png" alt="步骤提示">
		</div>
		<img src="/public/wxapp/images/step-tip.png" class="jiantou-tip" alt="箭头">
		<div class="step-img">
			<img src="/public/wxapp/images/step-3.png" alt="步骤提示">
		</div>
	</div>
</div>
<script>
    function openAuthuri(obj, event) {
        event.preventDefault();
        var type 	= $(obj).data('authtype');
        var authcode= $(obj).data('authuri');
        var domain	= $(obj).data('authdomain');
        if (type == 'domain') {
            window.open(authcode);
        } else {
            window.open(domain+"/manage/user/center?loginid="+authcode);
        }
    }
</script>
<style>
	input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
		background-color: #666666;
		border: 1px solid #666666;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before {
		background-color: #333333;
		border: 1px solid #333333;
	}
	input[type=checkbox].ace.ace-switch {
		width: 90px;
		height: 30px;
		margin: 0;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
		line-height: 30px;
		height: 31px;
		overflow: hidden;
		border-radius: 18px;
		width: 89px;
		font-size: 13px;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before {
		background-color: #44BB00;
		border-color: #44BB00;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before {
		background-color: #DD0000;
		border-color: #DD0000;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
		width: 28px;
		height: 28px;
		line-height: 28px;
		border-radius: 50%;
		top: 1px;
	}
	input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
		left: 59px;
		top: 1px
	}
	a.new-window{
		color: blue;
	}
	.page-content {
		padding: 20px;
	}
	.payment-block-wrap {
		font-family: '黑体';
	}
	.payment-block {
		border: 1px solid #e5e5e5;
		margin-bottom: 20px;
	}
	.payment-block .payment-block-header {
		position: relative;
		padding: 10px;
		border-bottom: 1px solid #e5e5e5;
		margin-bottom: -1px;
		background: #F8F8F8;
		cursor: pointer;
	}
	.payment-block .payment-block-header h3 {
		font-size: 16px;
		font-weight: bold;
		line-height: 30px;
		margin: 0;
	}
	.payment-block .payment-block-header h3:after {
		content: ' ';
		border: 5px solid #999;
		width: 0;
		height: 0;
		display: inline-block;
		position: absolute;
		margin-left: 6px;
		margin-top: 12px;
		border-left-color: transparent;
		border-right-color: transparent;
		border-bottom-color: transparent;
		border-top-width: 7px;
		-webkit-transition: all 0.2s;
		-moz-transition: all 0.2s;
		transition: all 0.2s;
	}
	.payment-block-wrap.open .payment-block-header h3:after {
		-webkit-transform: rotate(180deg);
		-moz-transform: rotate(180deg);
		-ms-transform: rotate(180deg);
		transform: rotate(180deg);
		-webkit-transform-origin: 50% 25%;
		-moz-transform-origin: 50% 25%;
		-ms-transform-origin: 50% 25%;
		transform-origin: 50% 25%;
	}
	.payment-block .payment-block-header .choose-onoff {
		position: absolute;
		top: 10px;
		right: 10px;
	}
	.payment-block .payment-block-body {
		display: none;
		padding: 25px;
	}
	.payment-block-body .form-group{
		overflow: hidden;
	}
	.payment-block-body .form-group label {
		font-weight: bold;
	}

	.payment-block-body .form-group p {
		color: #999;
		margin: 0;
		margin-top: 5px;
	}
	.payment-block .payment-block-body h4 {
	    color: #333;
	    margin-bottom: 20px;
	    font-size: 14px;
	}
	.form-horizontal {
	    margin-bottom: 30px;
	    width: auto;
	}
	.form-horizontal .control-group {
	    margin-bottom: 10px;
	}
	.form-horizontal .control-group:after, .form-horizontal .control-group:before {
	    display: table;
	    line-height: 0;
	    content: "";
	}
	.controls-row:after, .dropdown-menu>li>a, .form-actions:after, .form-horizontal .control-group:after, .modal-footer:after, .nav-pills:after, .nav-tabs:after, .navbar-form:after, .navbar-inner:after, .pager:after, .thumbnails:after {
	    clear: both;
	}
	.form-horizontal .control-group:after, .form-horizontal .control-group:before {
	    display: table;
	    line-height: 0;
	    content: "";
	}
	.form-horizontal .control-label {
	    float: left;
	    width: 160px;
	    padding-top: 5px;
	    text-align: right;
	}
	.form-horizontal .control-label {
	    width: 120px;
	    font-size: 14px;
	    line-height: 18px;
	}
	.page-payment .form-label-text-left .control-label {
	    text-align: left;
	    width: 100px;
	}
	.controls {
	    font-size: 14px;
	}
	.form-horizontal .controls {
	    margin-left: 180px;
	}
	.form-horizontal .controls {
	    margin-left: 130px;
	    word-break: break-all;
	}
	.page-payment .form-label-text-left .controls {
	    margin-left: 100px;
	}
	.form-horizontal .control-action {
	    padding-top: 5px;
	    display: inline-block;
	    font-size: 14px;
	    line-height: 18px;
	}
	.ui-message, .ui-message-warning {
	    padding: 7px 15px;
	    margin-bottom: 15px;
	    color: #333;
	    border: 1px solid #e5e5e5;
	    line-height: 24px;
	}
	.ui-message-warning {
	    color: #333;
	    background: #ffc;
	    border-color: #fc6;
	}
	.pay-test-status {
	    font-size: 12px;
	    margin-top: 10px;
	    width: 400px;
	}
	.payment-block .payment-block-body p {
	    line-height: 24px;
	}
	.payment-block .payment-block-body dl {
	    line-height: 24px;
	}
	.payment-block .payment-block-body dl dt {
	    font-weight: bold;
	    color: #333;
	    line-height: 24px;
	}
	.payment-block .payment-block-body dl dd {
	    margin-bottom: 20px;
	    color: #666;
	    line-height: 24px;
	}

	.payment-block .payment-block-body h4 {
	    color: #333;
	    font-size: 14px;
	    margin-bottom: 20px;
	}
	.payment-block .payment-block-header .tips-txt{
		position: absolute;
		top:10px;
		left: 115px;
		font-size: 13px;
		text-align: right;
		color: #999;
		height: 30px;
		line-height: 30px;
	}
</style>

<div class="payment-style">
	<div class="payment-block-wrap">
		<div class="payment-block">
		    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
		    	<div>
		    		<form action="">
						<input type="hidden" id="acid" value="<{$appletPay['ac_id']}>"/>
		    			<div class="form-group">
		    			    <label for="firstname" class="col-sm-2 control-label text-right">AppID<font color="red">*</font></label>
		    			    <div class="col-sm-10">
		    			        <input type="text" class="form-control" id="appid" value="<{if $appletPay && $appletPay['ac_appid']}><{$appletPay['ac_appid']}><{/if}>" data-msg="填写您的AppID，并保存" readonly placeholder="填写您的AppID">
		    			            <p>分身小程序AppID</p>
		    			    </div>
		    			</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">支付商户号<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="mchid" value="<{if $appletPay}><{$appletPay['ac_mchid']}><{/if}>" data-msg="填写您的支付商户号，并保存" placeholder="填写您的支付商户号">
								<p>请填写微信商户平台商户号</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">API秘钥<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="mchkey" value="<{if $appletPay}><{$appletPay['ac_mchkey']}><{/if}>" data-msg="填写您的API秘钥，并保存" placeholder="请填写您的API秘钥">
								<p>请填写微信商户平台的API秘钥</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">证书路径</label>
							<div class="col-sm-10">
								<div  class="form-control" style="position: relative;">
									<span><{if $appletPay && $appletPay['ac_sslcert']}> 已上传 <{else}> 未上传 <{/if}></span>
									<a href="#" class="btn btn-success btn-xs" id="choose-zhengshu" data-click-upload data-type="cert" data-msg="请上传apiclient_cert.pem的支付证书文件" style="position: absolute;right: 5px;top:3px;">上传</a>
									<input type="hidden" name="sslcert" id="sslcert" data-msg="填上传证书路径" value="<{if $appletPay}><{$appletPay['ac_sslcert']}><{/if}>">
								</div>
								<p>请上传apiclient_cert.pem的支付证书文件</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">秘钥路径</label>
							<div class="col-sm-10">
								<div class="form-control" style="position: relative;">
									<span><{if $appletPay && $appletPay['ac_sslkey']}> 已上传 <{else}> 未上传 <{/if}></span>
									<a href="#" class="btn btn-success btn-xs" id="choose-miyao" data-click-upload data-type="key" data-msg="请上传apiclient_key.pem的支付密钥证书文件" style="position: absolute;right: 5px;top:3px;">上传</a>
									<input type="hidden" name="sslkey" id="sslkey" data-msg="填上传秘钥路径" value="<{if $appletPay}><{$appletPay['ac_sslkey']}><{/if}>">
								</div>
								<p>请上传apiclient_key.pem的支付密钥证书文件</p>
							</div>
						</div>
		    			<div class="form-group">
		    				<div class="col-sm-2"></div>
		    			    <div class="col-sm-10 col-sm-offset-2">
		    			        <button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveWxPay()"> 保 存 </button>
		    			    </div>
		    			</div>
		    		</form>
		    	</div>
		    </div>
		</div>
	</div>
	
</div>
<div id="zhengshu" style="display: none;padding:5px 20px;">
	<div class="upload-tips">
		<form action="/wxapp/currency/pemcert" enctype="multipart/form-data" method="post">
			<label style="height:35px;line-height: 35px;">本地上传</label>
			<span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="pem_cert" type="file"></span>
			<p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传pem类型的文件</p>
			<div style="font-size: 14px;padding-left: 29px;margin-top: 10px;" >注意　<span id="show-notice">apiclient_cert.pem为支付证书文件，apiclient_key.pem为支付密钥证书文件</span></div>
		</form>
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
<script src="/public/plugin/layer/layer.js"></script>
<script>
	$(function(){

		$('[data-click-upload]').on('click', function(){
			var type    = $(this).data('type');
			var msg     = $(this).data('msg');
			$('#show-notice').html(msg);
			var htmlTxt=$("#zhengshu");
			var that    = this;
			//页面层
			var layIndex = layer.open({
				type: 1,
				title: '证书路径',
				shadeClose: true, //点击遮罩关闭
				shade: 0.6, //遮罩透明度
				skin: 'layui-anim',
				area: ['500px', '200px'], //宽高
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
							if (data.ec == 200) {
								$(that).prev('span').text('上传成功');
								$(that).next('input').val(data.data.path);
							} else {
								layer.alert('上传失败，请重试');
							}
						},
						complete: function () {
							layer.close(loading);
							layer.close(layIndex);
						}
					});
				}
			});
		});

	});
	//选择文件
	function selectedFile(obj){
		var path = $(obj).val();
		$(obj).parents('form').find('p').text(path);
	}

	function saveWxPay(){
		var appid = $('#appid').val();
		var data  = {
			'appid' : appid,
		};
		if(appid){
			var check = new Array('mchid','mchkey');
			for(var i=0; i < check.length;i++){
				var temp = $('#'+check[i]).val();
				if(temp){
					data[check[i]] = temp;
				}else{
					var msg = $('#'+check[i]).attr('placeholder');
					layer.msg(msg);
					return false;
				}
			}
		}else{
			layer.msg('请绑定微信');
			window.location.href = '/wxapp/guide/grantAuth';
			return false;
		}
		data['acid'] = $('#acid').val();
		data['sslcert'] = $('#sslcert').val();
		data['sslkey']  = $('#sslkey').val();
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/child/savePay',
			'data'  : data,
			'dataType'  : 'json',
			success : function(response){
				layer.msg(response.em);
			}
		});
	}




</script>

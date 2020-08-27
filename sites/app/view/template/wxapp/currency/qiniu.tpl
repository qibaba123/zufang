<style>
a.new-window { color: blue; }
.page-content { padding: 20px; }
.payment-block-wrap { font-family: '黑体'; }
.payment-block { border: 1px solid #e5e5e5; margin-bottom: 20px; }
.payment-block .payment-block-header { position: relative; padding: 10px; border-bottom: 1px solid #e5e5e5; margin-bottom: -1px; background: #F8F8F8; cursor: pointer; }
.payment-block .payment-block-header h3 { font-size: 16px; font-weight: bold; line-height: 30px; margin: 0; }
.payment-block .payment-block-header h3:after { content: ' '; border: 5px solid #999; width: 0; height: 0; display: inline-block; position: absolute; margin-left: 6px; margin-top: 12px; border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent; border-top-width: 7px; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; transition: all 0.2s; }
.payment-block-wrap.open .payment-block-header h3:after { -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); -webkit-transform-origin: 50% 25%; -moz-transform-origin: 50% 25%; -ms-transform-origin: 50% 25%; transform-origin: 50% 25%; }
.payment-block .payment-block-header .choose-onoff { position: absolute; top: 10px; right: 10px; }
.payment-block .payment-block-body { display: none; padding: 25px; }
.payment-block-body .form-group { overflow: hidden; }
.payment-block-body .form-group label { font-weight: bold; }
.payment-block-body .form-group p { color: #999; margin: 0; margin-top: 5px; }
.payment-block .payment-block-body h4 { color: #333; margin-bottom: 20px; font-size: 14px; }
.form-horizontal { margin-bottom: 30px; width: auto; }
.form-horizontal .control-group { margin-bottom: 10px; }
.form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
.controls-row:after, .dropdown-menu>li>a, .form-actions:after, .form-horizontal .control-group:after, .modal-footer:after, .nav-pills:after, .nav-tabs:after, .navbar-form:after, .navbar-inner:after, .pager:after, .thumbnails:after { clear: both; }
.form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
.form-horizontal .control-label { float: left; width: 160px; padding-top: 5px; text-align: right; }
.form-horizontal .control-label { width: 120px; font-size: 14px; line-height: 18px; }
.page-payment .form-label-text-left .control-label { text-align: left; width: 100px; }
.controls { font-size: 14px; }
.form-horizontal .controls { margin-left: 180px; }
.form-horizontal .controls { margin-left: 130px; word-break: break-all; }
.page-payment .form-label-text-left .controls { margin-left: 100px; }
.form-horizontal .control-action { padding-top: 5px; display: inline-block; font-size: 14px; line-height: 18px; }
.ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
.ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }
.pay-test-status { font-size: 12px; margin-top: 10px; width: 400px; }
.payment-block .payment-block-body p { line-height: 24px; }
.payment-block .payment-block-body dl { line-height: 24px; }
.payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
.payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
.payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
.payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
.showhide-secreskey { position: absolute; top: 4px; right: 18px; height: 26px; line-height: 26px; border-radius: 3px; background-color: #0095e5; color: #fff; z-index: 1; padding: 0 7px; font-size: 12px; cursor: pointer; }
.showhide-secreskey:hover { opacity: 0.9; }
</style>

<div class="payment-style">

	<div class="payment-block-wrap">
		<div class="payment-block">
		    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
		    	<div>
		    		<form action="">
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">存储区域<font color="red">*</font></label>
							<div class="col-sm-10">
								<select name="zone" id="zone" class="form-control">
									<option value="1" <{if $qiniu['aq_bucket_zone']==1}>selected<{/if}>>华东</option>
									<option value="2" <{if $qiniu['aq_bucket_zone']==2}>selected<{/if}>>华北</option>
									<option value="3" <{if $qiniu['aq_bucket_zone']==3}>selected<{/if}>>华南</option>
									<option value="4" <{if $qiniu['aq_bucket_zone']==4}>selected<{/if}>>北美</option>
								</select>
								<p>请填写存储区域</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">存储空间名称<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="name" value="<{if $qiniu}><{$qiniu['aq_bucket_name']}><{/if}>" data-msg="填写您的存储空间名称，并保存" placeholder="填写您的存储空间名称">
								<p>请填写存储空间名称</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">AccessKey<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="ak" value="<{if $qiniu}><{$qiniu['aq_access_key']}><{/if}>" data-msg="填写您的AccessKey，并保存" placeholder="填写您的AccessKey">
								<p>请填写AccessKey</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">SecretKey<font color="red">*</font></label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="sk" value="<{if $qiniu}><{$qiniu['aq_secret_key']}><{/if}>" data-msg="填写您的SecretKey，并保存" placeholder="填写您的SecretKey">
								<p>请填写SecretKey</p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">外链域名<font color="red">*</font></label>
							<div class="col-sm-10" style="position: relative;">
								<span style="position: absolute;left: 20px;font-size: 16px;font-weight: 700;line-height: 34px;">http://</span>
								<input type="text" class="form-control" id="host" style="padding-left: 77px;" value="<{if $qiniu}><{$qiniu['aq_host']}><{/if}>" data-msg="填写您的外链域名，并保存" placeholder="填写您的外链域名">
								<p>请填写外链域名</p>
							</div>
						</div>
						<div class="form-group" <{if !$qiniu}>style="display: none"<{/if}>>
							<label for="firstname" class="col-sm-2 control-label text-right">域名更新</label>
							<div class="col-sm-10" style="position: relative;">
								<div class="radio-box">
									<span data-val="1">
										<input type="radio" name="hostchange" value="1" id="hostchange1" >
										<label for="hostchange1">是</label>
									</span>
									<span data-val="0">
										<input type="radio" name="hostchange" value="0" checked="checked" id="hostchange0">
										<label for="hostchange0">否</label>
									</span>
									<p>若选是，将把已保存的旧域名下的音视频更换为新保存的域名</p>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-10 col-sm-offset-2">
								<button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveQiniu()"> 保 存 </button>
							</div>
						</div>
		    		</form>
		    	</div>
		    </div>
		</div>
	</div>

</div>
<script src="/public/plugin/layer/layer.js"></script>
<script>
	function saveQiniu(){
		var check = new Array('zone','name','ak','sk','host');
		var data  = {};
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
		data.hostchange = $('input[name="hostchange"]:checked').val();
		console.log(data);
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/currency/saveQiniu',
			'data'  : data,
			'dataType'  : 'json',
			success : function(response){
				layer.msg(response.em);
				//window.location.href="/wxapp/currency/video"
			}
		});
	}

</script>

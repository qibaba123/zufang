<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/lrtk.css?1">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">
<style type="text/css">
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
a.new-window { color: blue; }
.page-content { padding: 20px; }
.payment-block-wrap { font-family: '黑体'; }
.payment-block { border: 1px solid #e5e5e5; margin-bottom: 20px; }
.payment-block .payment-block-header { position: relative; padding: 10px; border-bottom: 1px solid #e5e5e5; margin-bottom: -1px; background: #F8F8F8; cursor: pointer; }
.payment-block .payment-block-header h3 { font-size: 16px; font-weight: bold; line-height: 30px; margin: 0; }
.payment-block .payment-block-header h3:after { content: ' '; border: 5px solid #999; width: 0; height: 0; display: inline-block; position: absolute; margin-left: 6px; margin-top: 12px; border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent; border-top-width: 7px; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; transition: all 0.2s; }
.payment-block-wrap.open .payment-block-header h3:after { -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); -webkit-transform-origin: 50% 25%; -moz-transform-origin: 50% 25%; -ms-transform-origin: 50% 25%; transform-origin: 50% 25%; }
.payment-block .payment-block-header .choose-onoff { position: absolute; top: 10px; right: 10px; }
.payment-block .payment-block-body { display: none; }
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
.info-group-inner .group-title{
	width: 13% !important;
}
.group-info{
	/*background-color: #fff !important;*/
}
.info-group-box{
	margin-bottom: 5px !important;
}
.info-group-inner .group-info .control-label{
	width: 180px !important;
}
#slide-img p{
	height: 114px !important;
	width: 284px !important;
}
.img-thumbnail{
	height: 114px !important;
	width: 284px !important;
}
	.form-group div{
		line-height: 34px;
	}
.form-group img{
	max-height: 250px;
}
</style>
<div class="payment-style">
	<div class="payment-block-wrap">
		<div class="payment-block">
			<div class="info-group-box">
				<div class="info-group-inner">
					<div class="group-info" style="background-color: #fff">
						<div class="payment-block-body js-wxpay-body-region" style="display: block;">
							<div>
								<form action="">
									<input type="hidden" class="form-control" id="acsId" value="<{if $row}><{$row['acs_id']}><{/if}>" >
							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">店铺名称：</label>
								<div class="col-sm-3">
									<{if $row && $row['acs_name']}><{$row['acs_name']}><{/if}>
								</div>
							</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">申请电话：</label>
										<div class="col-sm-3">
											<{if $row && $row['acs_mobile']}><{$row['acs_mobile']}><{/if}>
										</div>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">类别：</label>
										<div class="col-sm-3">
											<{$categorySelect[$row['acs_category_id']]}>
										</div>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">营业时间：</label>
										<div class="col-sm-3">
											<{if $row && $row['acs_open_time']}><{$row['acs_open_time']}><{/if}>
										</div>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">店铺地址：</label>
										<div class="col-sm-3">
											<{if $row && $row['acs_address']}><{$row['acs_address']}><{/if}>
										</div>
									</div>

							<div class="form-group">
								<label for="firstname" class="col-sm-2 control-label text-right">店铺封面：</label>
								<div class="col-sm-3" style="width: 80%">
									<{if $row['acs_cover']}>
									<img src="<{$row['acs_cover']}>" alt="店铺封面">
									<{/if}>
								</div>
							</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">资质证书：</label>
										<div class="col-sm-3" style="width: 80%">
											<!--
											<{if $row['acs_aptitude']}>
											<img src="<{$row['acs_aptitude']}>" alt="资质证书">
											<{/if}>
											-->
											<{if $aptitudeArr}>
											<div class="infopic">
												<div class="picbox">
													<ul class="gallery piclist">
														<{foreach $aptitudeArr as $aptitude}>
														<li><a href="<{$aptitude}>" rel="prettyPhoto[]"><img src="<{$aptitude}>" /></a></li>
														<{/foreach}>
													</ul>
												</div>
												<div class="pic_prev"></div>
												<div class="pic_next"></div>
											</div>
											<{/if}>
										</div>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">店铺简介：</label>
										<div class="col-sm-3">
											<{if $row && $row['acs_brief']}><{$row['acs_brief']}><{/if}>
										</div>
									</div>
									<div class="form-group">
										<label for="firstname" class="col-sm-2 control-label text-right">审核状态：</label>
										<div class="col-sm-3">
											<{if $row['acs_status'] == 2}>
											<span style="color: green">已通过</span>
											<{elseif $row['acs_status'] == 3}>
											<span style="color: green">已拒绝</span>
											<{else}>
											<span>申请中</span>
											<{/if}>
										</div>
									</div>

									<{if $row['acs_status'] == 1}>
							<div class="form-group">
								<div class="col-sm-3 col-sm-offset-2">
									<button type="button" class="btn btn-danger  btn-handle btn-sm" style="margin-right: 30px" data-toggle="modal" data-target="#myModal"  data-status="3"> 拒 绝 </button>
									<button type="button" class="btn btn-primary btn-handle btn-sm" data-toggle="modal" data-target="#myModal"  data-status="2"> 通 过 </button>
								</div>
							</div>
									<{/if}>
						</form>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 535px;">
		<div class="modal-content">
			<input type="hidden" id="hid_id" value="<{$row['acs_id']}>">
			<input type="hidden" id="status" value="">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					申请处理
				</h4>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-2 control-label no-padding-right" for="qq-num">状态：</label>
					<div class="col-sm-10">
						<span class="status-span span-green" style="display: none;color: green">通过</span>
						<span class="status-span span-red" style="display: none;color: red">拒绝</span>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
					<div class="col-sm-10">
						<textarea id="market" class="form-control" rows="8" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消
				</button>
				<button type="button" class="btn btn-primary" id="confirm-handle">
					确认
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<style>
.layui-layer-btn { border-top: 1px solid #eee; }
.upload-tips {		/* overflow: hidden; */ }
.upload-tips label { display: inline-block; width: 70px; }
.upload-tips p { display: inline-block; font-size: 13px; margin: 0; color: #666; margin-left: 10px; }
.upload-tips .upload-input { display: inline-block; text-align: center; height: 35px; line-height: 35px; background-color: #1276D8; color: #fff; width: 90px; position: relative; cursor: pointer; }
.upload-tips .upload-input>input { display: block; height: 35px; width: 90px; opacity: 0; margin: 0; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer; }
</style>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script>
    $(document).ready(function(){
        $("area[rel^='prettyPhoto']").prettyPhoto();
        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
    })

    $('.btn-handle').on('click',function () {
		var status = $(this).data('status');
		$('.status-span').css('display','none');
        $('#status').val(status);
		if(status == 2){
            $('.span-green').css('display','');
        }
        if(status == 3){
            $('.span-red').css('display','');
        }
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/handleApply',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

</script>

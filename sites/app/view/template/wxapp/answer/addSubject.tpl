<style>
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
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
<{include file="../common-second-menu.tpl"}>
<div class="payment-style" style="margin-left: 150px">
	<div class="payment-block-wrap">
		<div class="payment-block">
		    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
		    	<div>
		    		<form action="">
		    			<div class="form-group">
		    			    <label for="firstname" class="col-sm-2 control-label text-right">题目</label>
		    			    <div class="col-sm-3">
		    			        <input type="text"   class="form-control" id="question" value="<{if $row}><{$row['as_question']}><{/if}>">
								<input type="hidden" class="form-control" id="asId" value="<{if $row}><{$row['as_id']}><{/if}>" >
							</div>
		    			</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label text-right">题目配图(580*280)</label>
							<div>
								<img onclick="toUpload(this)" data-limit="1" data-width="580" data-height="280" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['as_question_cover']}><{$row['as_question_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
								<input type="hidden" id="upload-cover"  class="avatar-field bg-img" name="upload-cover" value="<{if $row && $row['as_question_cover']}><{$row['as_question_cover']}><{/if}>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">正确答案<font color="red">*</font></label>
							<div class="col-sm-3">
								<select class="form-control" id="answer" >
									<{foreach $answer as $key=>$val}>
									<option value ="<{$key}>" <{if $key==$row['as_answer']}>selected="selected"<{/if}>><{$val}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">选项一<font color="red">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="item1" value="<{if $row}><{$row['as_item1']}><{/if}>">
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">选项二<font color="red">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="item2" value="<{if $row}><{$row['as_item2']}><{/if}>">
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">选项三<font color="red">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="item3" value="<{if $row}><{$row['as_item3']}><{/if}>">
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">选项四<font color="red">*</font></label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="item4" value="<{if $row}><{$row['as_item4']}><{/if}>">
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-2 control-label text-right">难易程度<font color="red">*</font></label>
							<div class="col-sm-3">
								<select class="form-control" id="degree" >
									<{foreach $degree as $key=>$val}>
									<option value ="<{$key}>" <{if $key==$row['as_degree']}>selected="selected"<{/if}>><{$val}></option>
									<{/foreach}>
								</select>
							</div>
						</div>
						<{if $type==''}>
						<div class="form-group">
							<div class="col-sm-2"></div>
							<div class="col-sm-3 col-sm-offset-2">
								<button type="button" class="btn btn-primary btn-pay btn-sm" onclick="saveSubject()"> 保 存 </button>
							</div>
						</div>
						<{/if}>
		    		</form>
		    	</div>
		    </div>
		</div>
	</div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script src="/public/plugin/layer/layer.js"></script>
<script>
	function saveSubject() {
		var id = $('#asId').val();
		var data = {
			'id': id,
		};
		data['question']   = $('#question').val();
		data['questionCover']   = $('#upload-cover').val();
		data['answer']     = $('#answer').val();
		data['item1']      = $('#item1').val();
		data['item2']      = $('#item2').val();
		data['item3']      = $('#item3').val();
		data['item4']      = $('#item4').val();
		data['degree']     = $('#degree').val();
		layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
           	$.ajax({
				'type': 'post',
				'url': '/wxapp/answer/saveSubject',
				'data': data,
				'dataType': 'json',
				success: function (response) {
					layer.msg(response.em);
					window.location.href="/wxapp/answer/subjectList";
				}
			});
        });
	}

</script>

<link rel="stylesheet" type="text/css" href="/public/plugin/layui2/css/layui.css">
<script type="text/javascript" src='/public/plugin/layui2/layui.js'></script>

<link rel="stylesheet" type="text/css" href="/public/wxapp/sequence/css/card.css">
<style type="text/css">
	.width800{
		width: 800px!important;
	}
</style>
<div class='help-block text-right'>使用「CTRL+F」快捷键，快速搜素配置项</div>
<form class="layui-form" lay-filter="form" action="">
	<div id='config_container'></div>
	<div class='text-center submit'>
		<button class="layui-btn" lay-submit lay-filter="forSubmit">保存</button>
	</div>
</form>
<input id='configs' type="hidden" value='<{$configs}>'>
<input id='config_values' type="hidden" value='<{$config_values}>'>
<!-- 富文本插件 -->
<{include file="../article-kind-editor.tpl"}>
<!-- 图片上传插件 -->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/wxapp/sequence/js/configs.js?ver=1.0.4"></script>

<script type="text/javascript">
	var config_values=$('#config_values').val();

	//Demo
	layui.use('form', function(){
		var form = layui.form;
		//监听提交
		form.on('submit(forSubmit)', function(data){
			$.ajax({
				type:'POST',
				url:'/wxapp/configs/saveConfig',
				dataType:'json',
				data:data.field,
				success:function(res){
					layer.msg(res.em);
				}
			});  
			return false;
		});
		// 设置值
		let obj=JSON.parse(config_values);
		Object.keys(obj).forEach(function(key){
		    let tmp=obj[key];
		    if(typeof(tmp)=='string'){
		    	obj[key]=tmp.replace("*&^%$","'");
		    }
		});
		form.val("form", obj);

	});
	
	
	let configs=$('#configs').val();

	let html=configComponents.init(configs,JSON.parse(config_values));
	$('#config_container').html(html);

</script>
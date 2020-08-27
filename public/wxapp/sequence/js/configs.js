/**
 * 组件生成器
 * zhangzc
 * 2019-10-07
 */

var configComponents=function(){};
configComponents.prototype={
	// 普通文本
	initText:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		html+='<input type="text" name="'+item['table']+'|'+item['field']+'" placeholder="'+item['placeholder']+'"autocomplete="off" class="layui-input" value="'+item['default']+'">';
		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// switch
	initSwitch:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline">';
		html+='<input type="checkbox" name="'+item['table']+'|'+item['field']+'" lay-skin="switch" lay-text="ON|OFF" value="1">';
		
		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 长文本
	initAreaText:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		
		html+='<textarea name="'+item['table']+'|'+item['field']+'" placeholder="'+item['placeholder']+'" class="layui-textarea"></textarea>';
		
		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 下拉框
	initSelect:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		
		html+='<select name="'+item['table']+'|'+item['field']+'" lay-search lay-verify="" >';
		for (let i=0;i<item['sourceData'].length;i++) {
			html+='<option value="'+item["sourceData"][i]["value"]+'">'+item["sourceData"][i]["key"].replace("*&^%$","'")+'</option>';
		}
		html+='</select></div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 下拉框二级联动
	initSelectUnion:function(item,config_values){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width800 flex">';
		
		html+='<select class="select_union" lay-filter="select_union" name="'+item['table']+'|'+item['field']+'" lay-search>';
		
		let va='',va2='';
		let name=item['table']+'|'+item['field'];
		let name2=item['table']+'|'+item['field2'];
		for (var key in config_values) { 
            if(key == name){
           	 	va=config_values[key];
            }
            if(name2==key){
            	va2=config_values[key];
            }
        }
        // 判断va2的值是不是一个字符串类型的
        let disabled='',disabled_select='';
        if (parseFloat(va2).toString() != 'NaN') {
        	disabled='disabled';
        	name_input='';
        	name_select='name="'+item['table']+'|'+item['field2']+'"';
        	va2='';
        }else{
        	disabled_select='disabled';
        	name_select='';
        	name_input='name="'+item['table']+'|'+item['field2']+'"';
        }
        let selected='';
		for (let j=0;j<item['sourceData'].length;j++) {
			if(va==item["sourceData"][j]["value"]){
				selected='selected';
			}
			html+="<option data-value='"+encodeURI(JSON.stringify(item["sourceData"][j]["data_value"]))+"' value='"+item["sourceData"][j]["value"]+"'"+selected+" >"+item["sourceData"][j]["key"].replace("*&^%$","'")+"</option>";
			selected='';
		}
		html+='</select>';
		html+='<select class="select" '+name_select+' data-name="'+item['table']+'|'+item['field2']+'" lay-search '+disabled_select+'>';
		html+='</select>';

		html+='<input type="text" '+name_input+' data-name="'+item['table']+'|'+item['field2']+'" autocomplete="off" class="layui-input union_text"  '+disabled+' style="width:300px;" value="'+va2+'">';

		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 日期选择
	initDate:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		
		html+='<input type="text" name="'+item['table']+'|'+item['field']+'" placeholder="'+item['placeholder']+'"autocomplete="off" class="layui-input date" readonly>';
		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 时间选择
	initTime:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		
		html+='<input type="text" name="'+item['table']+'|'+item['field']+'" placeholder="'+item['placeholder']+'"autocomplete="off" class="layui-input time" readonly>';
		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 日期时间选择
	initDateTime:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		
		html+='<input type="text" name="'+item['table']+'|'+item['field']+'" placeholder="'+item['placeholder']+'"autocomplete="off" class="layui-input datetime" readonly>';
		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 图片上传
	initImg:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width500">';
		let rand=Math.random().toString(36).slice(-8);
		html+='<img onclick="toUpload(this)"   data-limit="1" data-width="'+item['width']+'" data-height="'+item['height']+'"  id="upload-'+rand+'" data-dom-id="upload-'+rand+'" src="'+item['sourceData']+'"  style="display:inline-block;height: '+item['height']+'px; width:'+item['width']+'px;margin: 0">';
        html+='<input type="hidden" id="'+rand+'"  class="avatar-field bg-img" name="'+item['table']+'|'+item['field']+'" />';

		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 富文本框
	initRichText:function(item){
		if(!item) return '';
		let html='';
		if(item['before'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['before']+'</div>';
		html+='<div '+this.setAnchor(item['anchor'])+' class="layui-input-inline width750">';
		
		html+='<textarea class="form-control" style="width:100%;height:250px;visibility:hidden;text-align: left; resize:vertical;" name="'+item['table']+'|'+item['field']+'" placeholder="'+item['placeholder']+'"  rows="15" >';
        html+=item['sourceData'];
        html+='</textarea>';
        html+='<input type="hidden" name="sub_dir" id="sub-dir" value="default" />';
        html+='<input type="hidden" name="ke_textarea_name" value="'+item['table']+'|'+item['field']+'" data-items="simple" />';


		html+='</div>';
		if(item['after'])
			html+='<div class="layui-form-mid layui-word-aux">'+item['after']+'</div>';
		if(item['tips'])
			html+='<i class="fa icon-question-sign" style="color:#9a999e;" data-toggle="tooltip" data-placement="top" title="'+item['tips']+'"></i>';
		return html;
	},
	// 构建
	init:function(config,config_values){
		configs=JSON.parse(config);
		let html='';
		// 配型类型
		for (let i = 0; i < configs.length; i++) {
			let name=configs[i]['name'];
			html+='<div class="row">';
			html+='		<div class="col-xs-12">';
	        html+='			<div class="card">';
	        html+='				<div class="card-body">';
	        html+='					<h4 class="card-title">'+name+'</h4>';
	        html+='					<div class="card-content">';

			let list=configs[i]['list'];
			for (let j=0; j<list.length; j++) {
				let item=list[j];
				html+='<div class="layui-form-item"><label class="layui-form-label">'+item['name']+'</label>';
				for(let k=0;k<item.values.length;k++){
					let config_item=item.values[k];
					switch(config_item['type']){
						case 'switch':
							html+=this.initSwitch(config_item);
							break;
						case 'text':
							html+=this.initText(config_item);
							break;
						case 'textarea':
							html+=this.initAreaText(config_item);
							break;
						case 'date':
							html+=this.initDate(config_item);
							break;
						case 'time':
							html+=this.initTime(config_item);
							break;
						case 'datetime':
							html+=this.initDateTime(config_item);
							break;
						case 'select':
							html+=this.initSelect(config_item);
							break;
						case 'selectUnion':
							html+=this.initSelectUnion(config_item,config_values);
							break;
						case 'richtext':
							html+=this.initRichText(config_item);
							break;
						case 'imgupload':
							html+=this.initImg(config_item);
							break;
					}
				}
				html+='</div>';
			}
			
			html+='</div>';
			html+='</div>';
			html+='</div>';
			html+='</div>';
			html+='</div>';
		}
		return html;
	},
	//设置锚点名称
	setAnchor:function(anchor){
		if(anchor)
			return 'id="'+anchor+'"';
		else
			return '';
	},
}

window['configComponents']=new configComponents();

layui.use('form', function(){
	var form = layui.form;
	form.on('select(select_union)', function(data){
		let options=JSON.parse(decodeURI($(data.elem).find('option:checked').data('value'))); //得到被选中的值
		let dom=$(data.elem).parent().find('.select');
		let utext=$(data.elem).parent().find('.union_text');
		dom.html('');
		let inner_option='';
		dom.append('<option value="">请选择</option>');
		for(let k=0;k<options.length;k++){
			let val=options[k]["key"];
			if(val){
				val=val.replace("*&^%$","'")
			}
			dom.append('<option value="'+options[k]["value"]+'">'+val+'</option>');
		}

		// 下拉联动需要手动设置的属性框的取值操作
		if(options=='plum_text'){
			dom.attr('disabled','true');
			dom.removeAttr('name');
			utext.attr('disabled',false);
			utext.attr('name',utext.data('name'));
			utext.attr('placeholder','请在此处输入···');
		}else{
			dom.attr('disabled',false);
			dom.attr('name',dom.data('name'));
			utext.attr('disabled',true);
			utext.removeAttr('name');
			utext.removeAttr('placeholder');
		}

		form.render('select');   
	}); 
});
layui.use('laydate', function(){
	var laydate = layui.laydate;
	$('.date').each(function(index){
        var _this=this;
        laydate.render({
            elem: _this,
            type:'date',
    	});
    });
    $('.time').each(function(index){
        var _this=this;
        laydate.render({
            elem: _this,
            type:'time',
			format:'HH:mm',
    	});
    });
    $('.datetime').each(function(index){
        var _this=this;
        laydate.render({
            elem: _this,
            type:'datetime',
    	});
    });
});

$(function(){
	$('[data-toggle="tooltip"]').tooltip();	
	// 设置二级联动菜单的option值
	$('.select_union').each(function(){			
		let value=$(this).find("option:selected").data('value');
		value=JSON.parse(decodeURI(value));
		let dom=$(this).next('.select');
		let utext=$(this).next('.union_text');
		dom.append('<option value="">请选择</option>');
		for (let i =0; i<value.length; i++) {
			let val =value[i]['key'];
			if(val){
				val =val.replace("*&^%$","'");
			}
			dom.append('<option value="'+value[i]['value']+'">'+val+'</option>');
		}
	});
	layui.use('form', function(){
		var form = layui.form;
		form.render('select');   
	});

	// 设置锚点的时候导航到锚点位置并将锚点处的标题着重突出
	if(!location.hash)
		return;
	$(location.hash).parent().parent().parent().find('.card-title').css({'color':'#b92c28'});
});





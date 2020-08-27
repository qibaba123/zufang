$(function(){
	menushowToggle();// 左侧手机导航预览切换
	showDropmenu();//右侧其他选项列表显示隐藏
	editOpts();//编辑提示框
	delOpts();//删除提示框
	deleteFirstmenu();//删除一级菜单提示框
	limenuActive();//点击当前条目当前添加active类
	//先选出 textarea 和 统计字数 dom 节点
	var wordCount = $("#txt-info"),
	    textArea = wordCount.find("textarea"),
	    word = wordCount.find(".word");
	//调用
	statInputNum(textArea,word);

	/*var valTxt;
	$(".js-modal-txt").on('click', function(event) {
		event.preventDefault();
		var oneIndex = $(this).parents('.opera-box').index();
		var twoIndex=0;
		$(".menu-titles li").each(function(index, el) {
			if($(this).hasClass('active')){
				liParent=$(this).parent();
				if(liParent.hasClass('sec-nav-field')){
					alert("二级级菜单"+liParent.hasClass('sec-nav-field').index());
				}
			}
		});
		
		$("#myModal").attr("data-id",oneIndex);
	});
	$(".js-modal-links").on('click', function(event) {
		event.preventDefault();
		var oneIndex = $(this).parents('.opera-box').index();
		$("#myModalLink").attr("data-id",oneIndex);
	});

	$("#myModal .confirm").on('click',  function(event) {
		event.preventDefault();
	});*/
});

var operaIndex=0;//定义删除菜单对应的一级菜单索引
var oneIndex=0,dataIndex=0;//定义一级菜单索引对应回复信息索引
/*点击文本信息  初始化编辑框数据并获取当前对应索引*/
$(".custom-operation").on('click', '.js-modal-txt', function(event) {
	event.preventDefault();
	var that=$(this);
	oneIndex=that.parents(".opera-box").index();
	that.parents(".opera-box").find('li').each(function(index, el) {
		if($(this).hasClass('active')){
			dataIndex=$(this).attr("data-id");
		}
	});
	var curVal=$(".custom-operation").find('.opera-box').eq(oneIndex).find(".menu-content .link-to[data-id="+dataIndex+"]").show().html();
	$("#myModal").find('textarea').val(curVal);
});
/*点击自定义外链  初始化编辑框数据并获取当前对应索引*/
$(".custom-operation").on('click', '.js-modal-links', function(event) {
	event.preventDefault();
	var that=$(this);
	oneIndex=that.parents(".opera-box").index();
	that.parents(".opera-box").find('li').each(function(index, el) {
		if($(this).hasClass('active')){
			dataIndex=$(this).attr("data-id");
		}
	});
	// var curVal=$(".custom-operation").find('.opera-box').eq(oneIndex).find(".menu-content .link-to[data-id="+dataIndex+"]").show().text();
	$("#myModalLink").find('input').val('');
});
/*新增二级菜单时最后一个二级菜单添加active类*/
$(".custom-operation").on('click', '.add-second-nav', function(event) {
	event.preventDefault();
	var that=$(this);
	var secondLi=that.parents('.menu-titles').find('.sec-nav-field li');
	that.parents('.menu-titles').find('li').removeClass('active');
	var activeIndex=secondLi.length-1;
	secondLi.eq(activeIndex).addClass('active');
	var curId=secondLi.eq(activeIndex).attr("data-id");
	$(this).parents('.opera-wrap').find(".link-to[data-id="+curId+"]").stop().show().siblings().hide();
	that.parents('.menu-titles').next().find(".select-link").stop().show();
});
/*点击删除确定按钮*/
$(".ui-popover.ui-popover--confirm .js-save").click(function(event) {
	event.preventDefault();
	var liLen=$(".opera-box").eq(operaIndex).find('.sec-nav-field li').length;
	$(".opera-box").eq(index).find('.menu-titles li').removeClass('active');
	$(".opera-box").eq(operaIndex).find('.sec-nav-field li').eq(liLen-1).addClass('active');
	var dataId=$(".opera-box").eq(operaIndex).find('.sec-nav-field li').eq(liLen-1).attr("data-id");
	$(".opera-box").eq(operaIndex).find(".menu-content .link-to[data-id="+dataId+"]").stop().show();
});

/*获取弹出框文本域的值*/
function getValue(elem,type){
	var valTxt;
	if(type=='click'){
		var valTxt=$(elem).parents('.modal-footer').prev().find('textarea').val();
		valTxt = valTxt;
	}else if(type='view'){
		var valLink=$(elem).parents('.modal-footer').prev().find('input').val();
		//valTxt = "<a href='#'>"+valLink+"</a>";
		valTxt = valLink;
	}
	$(".custom-operation").find('.opera-box').eq(oneIndex).find(".menu-content .link-to[data-id="+dataIndex+"]").show().html(valTxt);
	 console.log(valTxt+"--"+operaIndex+'>>'+oneIndex+">>"+dataIndex);
	if(valTxt){
		var data = {
			'one' 	: oneIndex,
			'two' 	: dataIndex,
			'value'	: valTxt,
			'type'	: type
		};
		$.ajax({
			'type' 	: 'post',
			'url'	: '/manage/wechat/menuLink',
			'data'	: data,
			'dataType' : 'json',
			'success'	: function(ret){
				layer.msg(ret.em);
			}
		});
	}
}
/**
 * 保存外链额外值
 * @param data
 */

 /*点击获取推广二维码  初始化编辑框数据并获取当前对应索引*/
$(".custom-operation").on('click', '.js-modal-save', function(event) {
	event.preventDefault();
	var that=$(this);
	oneIndex=that.parents(".opera-box").index();
	that.parents(".opera-box").find('li').each(function(index, el) {
		if($(this).hasClass('active')){
			dataIndex=$(this).attr("data-id");
		}
	});
	var akey = that.data('key');
	var avalue = that.data('value');
	$("#akey").val(akey);
	$("#avalue").val(avalue);
});
function setValue(extra,type,akey){
	var data = {
		'one' 	: oneIndex,
		'two' 	: dataIndex,
		'akey'	: akey,
		'value'	: extra,
		'type'	: type
	};
	$(".custom-operation").find('.opera-box').eq(oneIndex).find(".menu-content .link-to[data-id="+dataIndex+"]").show().html(data.value);
	console.log(data.value+"--"+oneIndex+">>"+dataIndex);
	layer.msg('保存成功');
	return;
	$.ajax({
		'type' 	: 'post',
		'url'	: '/manage/wechat/menuLink',
		'data'	: data,
		'dataType' : 'json',
		'success'	: function(ret){
			layer.msg(ret.em);
		}
	});
}
/**
 * 保存单个菜单
 * @param name
 * @param parentIndex
 * @param sonIndex
 */
function saveMenu(name,parentIndex,sonIndex){
	var data = {
		'name'  : name,
		'index' : sonIndex,
		'findex': parentIndex
	};
	$.ajax({
		type  : 'POST',
		url     : '/manage/wechat/saveMenu',
		data    :  data,
		dataType : 'json',
		success  : function(ret){

		}

	});
}
/**
 * 删除单个菜单
 * @param parentIndex
 * @param sonIndex
 */
function delMenu(parentIndex,sonIndex){
	var data = {
		'index' : sonIndex,
		'findex': parentIndex
	};
	$.ajax({
		type  : 'POST',
		url     : '/manage/wechat/delMenu',
		data    :  data,
		dataType : 'json',
		success  : function(ret){
			console.log(ret);
		}

	});
}

/*右侧点击标题当前条目添加active类*/
function limenuActive(){
	$("#firstmenu").on('click', '.opera-box .menu-titles li', function(event) {
		event.preventDefault();
		var thatLi=$(this);
		thatLi.parents('.opera-box').find('.menu-titles li').removeClass('active');
		thatLi.addClass('active');
		var dataId=thatLi.attr("data-id");
		thatLi.parents('.opera-box').find(".link-to").removeClass('show');
		thatLi.parents('.opera-box').find(".link-to[data-id="+dataId+"]").stop().show().siblings().stop().hide();
		if(thatLi.parents('.opera-box').find('.first-nav-field li').hasClass('active') && thatLi.parents('.opera-box').find('.sec-nav-field li').length>0){
			thatLi.parents('.opera-box').find(".link-to[data-id=-1]").html('<span>使用二级菜单后主回复已失效。</span>');
			thatLi.parents('.menu-titles').next().find(".select-link").stop().hide();
		}else{
			// thatLi.parents('.opera-box').find(".link-to[data-id=-1]").html('一级菜单内容回复');
			thatLi.parents('.menu-titles').next().find(".select-link").stop().show();
		}
	});
}


/*获取弹出框文本域的值*/
/*function getValue(elem,type){
	if(type=='text'){
		var valTxt=$(elem).parents('.modal-footer').prev().find('textarea').val();
		valTxt = valTxt;
		var oneIndex = $(elem).parents('#myModal').attr("data-id");
		var html = "<div data-id="+oneIndex+">"+valTxt+"</div>";
		
	}else if(type='link'){
		var valLink=$(elem).parents('.modal-footer').prev().find('input').val();
		valTxt = valLink;
		var oneIndex = $(elem).parents('#myModalLink').attr("data-id");
		console.log(oneIndex);
		var html = "<div data-id="+oneIndex+">"+"<a href='#'>"+valTxt+"</a></div>";
	}
	$('.opera-box').eq(oneIndex).find('.menu-content').append(html);
}*/
/*右侧点击标题当前条目添加active类*/
/*function limenuActive(){
	$("#firstmenu").on('click', '.opera-box li.menu-item', function(event) {
		event.preventDefault();
		var thatLi=$(this);
		thatLi.parents('.opera-box').find('.menu-titles li').removeClass('active');
		thatLi.addClass('active');
		if(thatLi.parents('.opera-box').find('.first-nav-field li').hasClass('active') && thatLi.parents('.opera-box').find('.sec-nav-field li').length>0){
			thatLi.parents('.menu-titles').next().find(".firsttxt-disabled").stop().show();
			thatLi.parents('.menu-titles').next().find(".select-link").stop().hide();
		}else{
			thatLi.parents('.menu-titles').next().find(".firsttxt-disabled").stop().hide();
			thatLi.parents('.menu-titles').next().find(".select-link").stop().show();
		}
	});
}*/





/*左右模拟器菜单隐藏显示切换*/
function menushowToggle(){
	$("#navmenu-ul").on('click', 'li>span', function(event) {
		event.preventDefault();
		event.stopPropagation();
		var that=$(this);
		var otherLi=that.parents('li').siblings();
		that.parents('li').find('dl').stop().toggle();
		var dlShow=that.next('dl').css("display");
		if(dlShow=='block'){
			otherLi.find('dl').stop().hide();
		}else{
			return;
		}
		$("#navmenu-masklayer").on('click', function(event) {
			event.preventDefault();
			event.stopPropagation();
			$('#navmenu-ul').find('dl').stop().hide();
		});
	});
}

/*右侧其他选项列表显示隐藏*/
function showDropmenu(){
	$(".custom-operation").on('mouseover', '.dropdown-con', function(event) {
		event.preventDefault();
		$(this).find('.dropdown-menu-xiala').stop().fadeIn();
	}).on('mouseout', '.dropdown-con', function(event) {
		event.preventDefault();
		$(this).find('.dropdown-menu-xiala').stop().fadeOut();
	});;
}
/*删除提示框*/
function delOpts(){
	
	//弹出删除选择框
	$(".custom-operation").on('click', '.menu-titles li .opts a[class^="js-del"]', function(event) {
		var boxLeft = Math.round($("#custommenu-box").offset().left);
		var boxTop = Math.round($("#custommenu-box").offset().top);
		event.preventDefault();
		event.stopPropagation();
		operaIndex=$(this).parents('.opera-box').index();
		var left = Math.round($(this).offset().left);
		var top = Math.round($(this).offset().top);
		optshide();
		$(".ui-popover.ui-popover--confirm").css({'left':left-boxLeft-313,'top':top-boxTop-9}).stop().show();
	});
	// $(".ui-popover.ui-popover--confirm").on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// });
	editdeletedide();
}
function editOpts(){
	//弹出编辑选择框
	$(".custom-operation").on('click', '.menu-titles li .opts a[class^="js-edit"]', function(event) {
		var boxLeft = Math.round($("#custommenu-box").offset().left);
		var boxTop = Math.round($("#custommenu-box").offset().top);
		event.preventDefault();
		event.stopPropagation();
		var edithat = $(this) ;
		// if(edithat.parents('ul').hasClass('first-nav-field')){
		// 	edithat.parents('.custommenu-box').find('.js-name-input').prop({
		// 		maxlength: 4,
		// 	})
		// }else{
		// 	edithat.parents('.custommenu-box').find('.js-name-input').prop({
		// 		maxlength: 7,
		// 	})
		// }
		var left = Math.round(edithat.offset().left);
		var top = Math.round(edithat.offset().top); 
		var curTxt=edithat.parent().prev().text();
		// $(".ui-popover.ui-popover-edit input").val(curTxt);
		optshide();
		$(".ui-popover.ui-popover-edit").css({'left':left-boxLeft-139,'top':top-boxTop+30}).stop().show();
	});
	$(".ui-popover.ui-popover-edit").on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
	});
	editdeletedide();
}
function deleteFirstmenu(){
	$(".custom-operation").on('click', '.opera-box .delete', function(event) {
		var boxLeft = Math.round($("#custommenu-box").offset().left);
		var boxTop = Math.round($(".page-con").offset().top);
		event.preventDefault();
		event.stopPropagation();
		var left = Math.round($(this).offset().left);
		var top = Math.round($(this).offset().top);
		optshide();
		$(".ui-popover.ui-popover--confirm").css({'left':left-boxLeft-320,'top':top-boxTop}).stop().show();
	});
	editdeletedide();
}
/*隐藏编辑删除弹出框*/
function optshide(){
	$('.ui-popover').stop().hide();
}
/*点击确定取消隐藏编辑删除弹出框*/
function editdeletedide(){
	/*隐藏删除框*/
	$(".ui-popover-inner").on('click', 'a', function(event) {
		event.preventDefault();
		event.stopPropagation();
		optshide();
	});
	// 点击空白区域删除框消失
	$('body').on('click', function(event) {
		$('.ui-popover').each(function(index, el) {
			if($(this).css('display')=='block'){
				optshide();
			}else{
				return;
			}
		});
	});
}
/*文本信息剩余字数统计*/
function statInputNum(textArea,numItem) {
    var max = numItem.text(),
        curLength;
    textArea[0].setAttribute("maxlength", max);
    curLength = textArea.val().length;
    numItem.text(max - curLength);
    textArea.on('input propertychange', function () {
        numItem.text(max - $(this).val().length);
    });
}

/*发布微信菜单*/
function publishMenu() {
    var loading = layer.load(1);
    var url     = '/manage/wechat/publish';
    $.ajax({
        url : url,
        data : {},
        dataType : 'json',
        method : "POST",
        cache : false,
        timeout : 20000//毫秒单位
    }).done(function(ret) {
        if (ret.ec == 200) {
            layer.msg('发布成功');
        } else {
            layer.msg(ret.em, {
                time: 0 //不自动关闭
                ,btn: ['确定']
                ,yes: function(index){
                    layer.close(index);
                }
            });
        }
    }).always(function() {
        layer.close(loading);
    });
}

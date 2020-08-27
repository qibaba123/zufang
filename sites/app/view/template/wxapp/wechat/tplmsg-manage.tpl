<link rel="stylesheet" href="/public/manage/mesManage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/mesManage/css/index.css">
<link rel="stylesheet" href="/public/manage/mesManage/css/style.css">
<div class="preview-page" ng-app="messApp" ng-controller="messCtrl" style="padding-bottom:60px;">
	<div class="preview-page-wrap" style="overflow:hidden;">
		<div class="mobile-page">
			<div class="mobile-header"></div>
			<div class="mobile-con">
				<div class="title-bar">
					消息模板管理
				</div>
				<!-- 主体内容部分 -->
				<div class="index-con">
					<!-- 首页主题内容 -->
					<div class="index-main" style="height: 380px;">
					    <div class="message">
					    	<h3><{$data['title']}></h3>
					    	<p class="date"><{$day}></p>
							<p class="">
								<span><{$data['titlePre']}></span>
								<span class="remind-txt" ng-bind="messageTxt.remindTxt.contxt" ng-style="{'color':'{{messageTxt.remindTxt.color}}'}"></span>
								<span><{$data['titleSuf']}></span>
							</p>
							<div class="item-txt" ng-repeat="item in messageTxt.itemTxt">
					    		<span class="title">{{item.titletxt}}：</span>
					    		<span class="text" ng-style="{'color':'{{item.color}}'}">{{item.contxt}}</span>
							</div>
					    	<div class="item-txt" id="invitetxt">
					    		<span class="text" ng-bind="messageTxt.inviteTxt.contxt" ng-style="{'color':'{{messageTxt.inviteTxt.color}}'}">点击此处邀请小伙伴参团~</span>
					    	</div>
					    	<div class="see-detail">详情</div>
					    </div>
					</div>
				</div>
			</div>
			<div class="mobile-footer"><span></span></div>
		</div>
		<div class="edit-right">
			<div class="form-group" style="background-color: #f8f8f8;margin-top:70px;padding: 10px;border: 1px solid #e8e8e8;border-radius: 4px;">
				<label for="">模版消息名称</label>
				<input type="text" class="form-control" ng-model="messageTxt.title" >
			</div>
			<div class="edit-con" style="margin-top: 20px;">
				<div class="message-manage">
					<div class="item-txt-manage">
						<label for="">提醒内容</label>
						<div class="txt-color flex-wrap">
							<textarea rows="2" class="cus-input flex-con" ng-model="messageTxt.remindTxt.contxt" data-obj="remindTxt" onmouseup="getPosition(this)" oninput="getPosition(this)"></textarea>
							<p><input type="text" class="color"></p>
						</div>
					</div>
					<div class="item-txt-manage" ng-repeat="item in messageTxt.itemTxt">
						<label for="">{{item.titletxt}}</label>
						<div class="txt-color flex-wrap">
							<input type="text" class="cus-input flex-con" ng-model="item.contxt" data-obj="{{$index}}"  onmouseup="getPosition(this)" oninput="getPosition(this)">
							<p><input type="text" class="color"></p>
						</div>
					</div>
					<div class="item-txt-manage">
						<label for="">查看提醒</label>
						<div class="txt-color flex-wrap">
							<input type="text" class="cus-input flex-con" ng-model="messageTxt.inviteTxt.contxt" data-obj="inviteTxt" onmouseup="getPosition(this)" oninput="getPosition(this)">
							<p><input type="text" class="color"></p>
						</div>
					</div>
					<div class="item-txt-manage" style="display: none">
						<label for="">详情URL</label>
						<div class="txt-color flex-wrap">
							<input type="text" class="cus-input flex-con" ng-model="messageTxt.detailUrl" data-obj="detailUrl"  onmouseup="getPosition(this)" oninput="getPosition(this)">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<{foreach $kind as $key=>$val}>
	<{if isset($msg[$key])}>
	<div class="short-insert-box" style="margin: 10px 0;">
		<label for=""><{$val}></label>
		<div>
			 <p>
				 <{foreach $msg[$key] as $mal}>
				 <span class="short"><{$mal}></span>
				 <{/foreach}>
			 </p>
			<{if $msg['url-'|cat:$key]}>
			<div class="line"></div>
			 <p>
				 <{foreach $msg['url-'|cat:$key] as $ual}>
				 <span class="short"><{$ual}></span>
				 <{/foreach}>
			 </p>
			<{/if}>
		</div>
	</div>
	<{/if}>
	<{/foreach}>
	<div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm btn-save" ng-click="saveMsg()" > 保 存 </button></div>
</div>
<script type="text/javascript" src="/public/manage/mesManage/color-spectrum/spectrum.js"></script>
<script type="text/javascript" src="/public/manage/mesManage/js/angular-1.4.6.min.js"></script>
<script type="text/javascript" src="/public/manage/mesManage/js/angular-root.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
var app = angular.module('messApp',['RootModule']);
app.controller('messCtrl', ['$scope','$http', function($scope,$http){
	$scope.messageTxt = {
		title:'<{$data['title']}>',
		remindTxt:<{$data['remind']}>,
		itemTxt:<{$data['item']}>,
		inviteTxt:<{$data['remark']}>,
		detailUrl:'<{$data['url']}>'
	};
	$scope.saveMsg=function(){
		var index = layer.load(1, {
			shade: [0.1,'#fff'] //0.1透明度的白色背景
		},{
			time : 10*1000
		});

		//传递添加橱窗索引位置
		var data = {
			'id'	 	 : '<{$data['id']}>',
			'title'	 	 : $scope.messageTxt.title,
			'title_pre'	 : '<{$data['titlePre']}>',
			'title_suf'	 : '<{$data['titleSuf']}>',
			'tplid'	 	 : '<{$data['tplid']}>',
			'remind' 	 : $scope.messageTxt.remindTxt,
			'item'		 : $scope.messageTxt.itemTxt,
			'remark'	 : $scope.messageTxt.inviteTxt,
			'url'		 : $scope.messageTxt.detailUrl
		};
		$http({
			method: 'POST',
			url:    '/wxapp/wechat/saveTplMsg',
			data:   data
		}).then(function(response) {
			layer.close(index);
			layer.msg(response.data.em);
			if(response.data.ec == 200){
				window.location.href = '/wxapp/wechat/tplmsgList?tplid=<{$data['tplid']}>';
			}
		});

	};


		$(function(){
			// 输入框背景色
			$('.message-manage').find("input.color").each(function(index, el) {
				var indexLength = $(this).parents('.message-manage').find('input.color').length-1;
				var curColor = '';
		        if(index==0){
		        	curColor = $(".message").find('.remind-txt').css("color");
		        }else if(index == indexLength){
					curColor = $(".message").find('#invitetxt .text').css("color");
		        }else{
		        	var itemIndex = index-1;
		        	curColor = $(".message").find('.item-txt').eq(itemIndex).find('.text').css("color");
		        }
				$(this).spectrum({
				    color: curColor,
				    showButtons: false,
				    showInitial: true,
				    showPalette: true,
				    showSelectionPalette: true,
				    maxPaletteSize: 10,
				    preferredFormat: "hex",
				    move: function (color) {
				        var realColor = color.toHexString();
				        if(index==0){
				        	$scope.messageTxt.remindTxt.color = realColor;
				        	$(".message").find('.remind-txt').css("color",realColor);
				        }else if(index == indexLength){
							$scope.messageTxt.inviteTxt.color = realColor;
							$(".message").find('#invitetxt .text').css("color",realColor);
				        }else{
				        	var itemIndex = index-1;
				        	$scope.messageTxt.itemTxt[itemIndex].color = realColor;
				        	$(".message").find('.item-txt').eq(itemIndex).find('.text').css("color",realColor);
				        }
				    },
				    palette: [
				            ['black', 'white', 'blanchedalmond',
				            'rgb(255, 128, 0);', '#6bc86b'],
				            ['red', 'yellow', '#16cfc0', 'blue', 'violet']
				        ]
				    
				});
			});
		});

		/*快捷插入*/
		$(".short-insert-box .short").click(function(event) {
			var dataType = curObjIndex.dataObj;
			if(isFocus){
				var textObj = $(curObjIndex.curObj);
				var curIndex = curObjIndex.curIndex;
				var val = textObj.val();
				var thisVal = $(this).text();

				var newVal = val.substr(0, curIndex) + thisVal + val.substr(curIndex, val.length);
				$scope.$apply(function(){
					if(dataType=='remindTxt' || dataType=='inviteTxt'){
						$scope.messageTxt[dataType].contxt=newVal;
					}else if(dataType=='detailUrl'){
						$scope.messageTxt[dataType]=newVal;
					}else{
						$scope.messageTxt.itemTxt[dataType].contxt=newVal
					}
				})
			}else{
				layer.msg("请选择要插入的输入框");
			}
			
		});
		
	}]);
	var curObjIndex={},isFocus=false;
	/*获取光标索引*/
	function getPosition(obj) {
		isFocus = true;
        var cursurPosition=0;
        var dataobj = $(obj).data("obj");
        if(obj.selectionStart){ //非IE
            cursurPosition= obj.selectionStart;
        }else{ //IE
            try{
				var range = document.selection.createRange();
				range.moveStart("character",-obj.value.length);
				cursurPosition=range.text.length;
            }catch(e){
                cursurPosition = 0;
            }
        }
        cursorIndex = cursurPosition;
        return curObjIndex={
        	curObj:obj,
        	dataObj:dataobj,
        	curIndex:cursorIndex
        };
    }
</script>
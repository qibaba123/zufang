<link rel="stylesheet" href="/public/manage/mesManage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/mesManage/css/index.css">
<link rel="stylesheet" href="/public/manage/mesManage/css/style.css">

<style>
	input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
		content: "放大\a0\a0正常";
		text-indent: -7px;
	}

	input[type=checkbox].ace.ace-switch.ace-switch-4:checked + .lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked + .lbl::after {
		left: 34px;
	}

	input[type=checkbox].ace.ace-switch.ace-switch-5:checked + .lbl::before {
		text-indent: 6px;
	}
</style>
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
							<!--<p class="">
								<span><{$data['titlePre']}></span>
								<span class="remind-txt" ng-bind="messageTxt.remindTxt.contxt" ng-style="{'color':'{{messageTxt.remindTxt.color}}'}"></span>
								<span><{$data['titleSuf']}></span>
							</p>-->
							<div class="item-txt" ng-repeat="item in messageTxt.itemTxt">
								<div ng-if="$index+1!=messageTxt.emphasis">
									<span class="title" >{{item.titletxt}}：</span>
									<span class="text"  ng-style="{'color':'{{item.color}}'}">{{item.contxt}}</span>
								</div>
								<div ng-if="$index+1==messageTxt.emphasis" style="margin: 10px 0">
									<span class="title" style="display: block;text-align: center">{{item.titletxt}}</span>
									<span class="text" style="display: block;text-align: center;font-size: 20px"  ng-style="{'color':'{{item.color}}'}">{{item.contxt}}</span>
								</div>
							</div>
					    	<!--<div class="item-txt" id="invitetxt">
					    		<span class="text" ng-bind="messageTxt.inviteTxt.contxt" ng-style="{'color':'{{messageTxt.inviteTxt.color}}'}">点击此处邀请小伙伴参团~</span>
					    	</div>-->
					    	<div class="see-detail">进入小程序查看</div>
					    </div>
					</div>
				</div>
			</div>
			<div class="mobile-footer"><span></span></div>
		</div>
		<div class="edit-right">
			<div class="form-group" style="background-color: #f8f8f8;margin-top:70px;padding: 10px;border: 1px solid #e8e8e8;border-radius: 4px;">
				<label for="">名称（名称仅供区分使用，实际标题以模板消息标题为准）</label>
				<input type="text" class="form-control" ng-model="messageTxt.title">
			</div>
			<div class="edit-con" style="margin-top: 20px;">
				<div class="message-manage">
					<div class="item-txt-manage" ng-repeat="item in messageTxt.itemTxt">
						<label for="">{{item.titletxt}}</label>
						<div class="txt-color flex-wrap">
							<input type="text" class="cus-input flex-con" ng-model="item.contxt" data-obj="{{$index}}"  onmouseup="getPosition(this)" oninput="getPosition(this)">
							<p><input type="text" class="color"></p>

							<div class="control-group">
								<label style="padding: 4px 0;margin: 0;">
									<input  class="ace ace-switch ace-switch-5"  type="checkbox" ng-click="selectEmphasis(this,$index)" ng-checked="{{messageTxt.emphasis==$index+1}}">
									<span class="lbl"></span>
								</label>
							</div>
						</div>
					</div>
					<!--<div class="item-txt-manage">
						<label for="">小程序页面路径</label>
						<div class="txt-color flex-wrap">
							<input type="text" class="cus-input flex-con" ng-model="messageTxt.detailPage" data-obj="detailPage"  onmouseup="getPosition(this)" oninput="getPosition(this)">
						</div>
					</div>-->
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
			<!--<{if $msg['url-'|cat:$key]}>
			<div class="line"></div>
			 <p>
				 <{foreach $msg['url-'|cat:$key] as $ual}>
				 <span class="short"><{$ual}></span>
				 <{/foreach}>
			 </p>
			<{/if}>-->
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
		emphasis: '<{$data['emphasis']}>',
		title:'<{$data['title']}>',
		itemTxt:<{$data['item']}>,
		detailPage:'<{$data['page']}>',
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
			'tplid'	 	 : '<{$data['tplid']}>',
			'item'		 : $scope.messageTxt.itemTxt,
			'page'		 : $scope.messageTxt.detailPage,
			'emphasis'  : $scope.messageTxt.emphasis
		};
		$http({
			method: 'POST',
			url:    '/wxapp/tplmsg/saveTplMsg',
			data:   data
		}).then(function(response) {
			layer.close(index);
			layer.msg(response.data.em);
			if(response.data.ec == 200){
				window.location.href = '/wxapp/tplmsg/tplmsgList?tplid=<{$data['tplid']}>';
			}
		});

	};
	$scope.selectEmphasis = function(e, index){
		if(index+1 == $scope.messageTxt.emphasis){
			$scope.messageTxt.emphasis = 0;
		}else{
			$scope.messageTxt.emphasis = index+1;
		}

		for(var i=0; i<$('.ace-switch').length; i++){
			if(i!=index){
				$('.ace-switch').eq(i).removeAttr('checked');
			}
		}

	}

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
		        	var itemIndex = index;
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
						$scope.messageTxt.itemTxt[index].color = realColor;
						$(".message").find('.item-txt').eq(index).find('.text').css("color",realColor);
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
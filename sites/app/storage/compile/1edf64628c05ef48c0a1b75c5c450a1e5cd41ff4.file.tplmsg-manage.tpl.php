<?php /* Smarty version Smarty-3.1.17, created on 2020-04-09 09:22:38
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/tplmsg-manage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10825047895e8e78de95b773-75933459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1edf64628c05ef48c0a1b75c5c450a1e5cd41ff4' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/tplmsg-manage.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10825047895e8e78de95b773-75933459',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'day' => 0,
    'kind' => 0,
    'key' => 0,
    'msg' => 0,
    'val' => 0,
    'mal' => 0,
    'ual' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8e78de9a6a89_34483416',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8e78de9a6a89_34483416')) {function content_5e8e78de9a6a89_34483416($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/mesManage/color-spectrum/spectrum.css">
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
					    	<h3><?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
</h3>
					    	<p class="date"><?php echo $_smarty_tpl->tpl_vars['day']->value;?>
</p>
							<!--<p class="">
								<span><?php echo $_smarty_tpl->tpl_vars['data']->value['titlePre'];?>
</span>
								<span class="remind-txt" ng-bind="messageTxt.remindTxt.contxt" ng-style="{'color':'{{messageTxt.remindTxt.color}}'}"></span>
								<span><?php echo $_smarty_tpl->tpl_vars['data']->value['titleSuf'];?>
</span>
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
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['kind']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<?php if (isset($_smarty_tpl->tpl_vars['msg']->value[$_smarty_tpl->tpl_vars['key']->value])) {?>
	<div class="short-insert-box" style="margin: 10px 0;">
		<label for=""><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</label>
		<div>
			 <p>
				 <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value[$_smarty_tpl->tpl_vars['key']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
				 <span class="short"><?php echo $_smarty_tpl->tpl_vars['mal']->value;?>
</span>
				 <?php } ?>
			 </p>
			<!--<?php if ($_smarty_tpl->tpl_vars['msg']->value[('url-').($_smarty_tpl->tpl_vars['key']->value)]) {?>
			<div class="line"></div>
			 <p>
				 <?php  $_smarty_tpl->tpl_vars['ual'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ual']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value[('url-').($_smarty_tpl->tpl_vars['key']->value)]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ual']->key => $_smarty_tpl->tpl_vars['ual']->value) {
$_smarty_tpl->tpl_vars['ual']->_loop = true;
?>
				 <span class="short"><?php echo $_smarty_tpl->tpl_vars['ual']->value;?>
</span>
				 <?php } ?>
			 </p>
			<?php }?>-->
		</div>
	</div>
	<?php }?>
	<?php } ?>
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
		emphasis: '<?php echo $_smarty_tpl->tpl_vars['data']->value['emphasis'];?>
',
		title:'<?php echo $_smarty_tpl->tpl_vars['data']->value['title'];?>
',
		itemTxt:<?php echo $_smarty_tpl->tpl_vars['data']->value['item'];?>
,
		detailPage:'<?php echo $_smarty_tpl->tpl_vars['data']->value['page'];?>
',
	};
	$scope.saveMsg=function(){
		var index = layer.load(1, {
			shade: [0.1,'#fff'] //0.1透明度的白色背景
		},{
			time : 10*1000
		});

		//传递添加橱窗索引位置
		var data = {
			'id'	 	 : '<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
',
			'title'	 	 : $scope.messageTxt.title,
			'tplid'	 	 : '<?php echo $_smarty_tpl->tpl_vars['data']->value['tplid'];?>
',
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
				window.location.href = '/wxapp/tplmsg/tplmsgList?tplid=<?php echo $_smarty_tpl->tpl_vars['data']->value['tplid'];?>
';
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
</script><?php }} ?>

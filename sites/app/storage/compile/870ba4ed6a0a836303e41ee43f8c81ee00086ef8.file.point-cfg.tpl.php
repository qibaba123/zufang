<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:10:42
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/point-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13657245455dea1b12b4d738-57031164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '870ba4ed6a0a836303e41ee43f8c81ee00086ef8' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/point-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13657245455dea1b12b4d738-57031164',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'exchangeOpen' => 0,
    'content' => 0,
    'pointImg' => 0,
    'slide' => 0,
    'point' => 0,
    'styleType' => 0,
    'ratio' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1b12b82c93_19102133',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1b12b82c93_19102133')) {function content_5dea1b12b82c93_19102133($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/card/certificate/css/index.css?3">
<link rel="stylesheet" href="/public/wxapp/card/certificate/css/style.css?1">
<style>
	.order-info{
		padding: 10px;
    	background: #fff;
	}

	.order-info div{
		width: 33.33%;
    	text-align: center;
	}
	
	.order-info img{
		width: 30px;
	}

	.user-operation{
		margin-top: 10px;
    	background: #fff;
	}

	.user-operation .border-b{
		padding: 6px 10px;
	}

	.user-operation img{
		width: 14px;
    	float: right;
    	margin-top: 6px;
	}

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-community-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!-- <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 -->
<?php echo $_smarty_tpl->getSubTemplate ("../article-kind-editor-other.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" style="padding-left: 130px;">
	<div class="mobile-page">
		<div class="mobile-header"></div>
		<div class="mobile-con">
			<div class="title-bar cur-edit">
				积分商城
			</div>
			<!-- 主体内容部分 -->
			<div class="index-con">
				<!-- 首页主题内容 -->
				<div class="index-main">
					<div class="hornor-wrap">
						<div class="banner-wrap" data-left-preview data-id="1">
							<img src="/public/wxapp/images/banner.jpg" alt="轮播图" ng-if="banners.length<=0" style="width: 100%">
							<img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0" style="width: 100%">
							<div class="paginations">
								<span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
							</div>
						</div>
						<div class="top-img" data-left-preview data-id="2" style="background: #fff;height: 60px;line-height: 60px;padding: 0 10px;">
							<div style="float: left">我的积分：<img src="/public/wxapp/community/images/point.png" style="height: 16px;width:16px;margin: 0 3px;display: inline-block" alt=""/>666666</div>
							<div style="float: right">
								<span style="display: inline-block; padding: 3px 15px;border: 1px solid #999;color: #666;line-height: 20px;border-radius: 3px">规则</span>
							</div>
						</div>
						<div class="top-img" data-left-preview data-id="3" style="background: #fff;height: 60px;line-height: 60px;padding: 0 10px;text-align: center">
							点击管理商品样式
						</div>
						<!--<div class="top-img cur-edit" data-left-preview data-id="4">
							<img ng-src="{{pointImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':pointImg}}" alt="报名封面图"/>
						</div>-->
					</div>
				</div>
			</div>
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">

			<div class="banner" data-right-edit data-id="1" style="display: block;">
				<label>积分商城幻灯（建议尺寸750*300）</label>
				<div class="banner-manage" ng-repeat="banner in banners">
					<div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
					<div class="edit-img">
						<div>
							<img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;width: 100%">
							<input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
						</div>
					</div>
				</div>
				<div class="add-box" title="添加" ng-click="addNewBanner()"></div>
			</div>
			<div class="active" data-right-edit data-id="2">
				<!--<div class="hornor-covers-manage" style="margin-bottom: 10px">
					<div class="edit-img">
						<div class="input-group-box">
							<label for="">签到赠送积分：</label>
							<input type="number" class="cus-input"  ng-model="point">
						</div>
					</div>
				</div>-->
				<?php if ($_smarty_tpl->tpl_vars['exchangeOpen']->value) {?>
				<div class="hornor-covers-manage" style="margin-bottom: 10px">
					<div class="edit-img">
						<div class="input-group-box">
							<label for="">积分兑换余额：每</label>
							<input type="text" class="cus-input"  ng-model="ratio" style="width: 50px;height: 20px;">
							<label for="">积分，兑换1元余额</label>
						</div>
					</div>
				</div>
				<?php }?>
				<div>
					<label for="">积分规则：</label>
					<div class="form-textarea">
						<textarea  class="form-control" style="width:100%;height:350px;visibility:hidden;text-align: left; resize:vertical;"  id="content-detail" name="content-detail" placeholder="积分规则"  rows="20">
							<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

						</textarea>
						<input type="hidden" name="sub_dir" id="sub-dir" value="default" />
						<input type="hidden" name="ke_textarea_name" value="content-detail" />
					</div>
				</div>
			</div>
			<div class="active" data-right-edit data-id="3">
				<!--<div class="hornor-covers-manage" style="margin-bottom: 10px">
					<div class="edit-img">
						<div class="input-group-box">
							<label for="">签到赠送积分：</label>
							<input type="number" class="cus-input"  ng-model="point">
						</div>
					</div>
				</div>-->
				<div>
					<label for="">列表样式：</label>
					<div class="form-textarea">
						<div class="radio-box showstyle-radio">
							<form>
								<span>
                                        <input type="radio" name="goods-show" id="showstyle1" value="1" ng-model="styleType">
                                        <label for="showstyle1">小图</label>
                                </span>
								<span>
                                        <input type="radio" name="goods-show" id="showstyle2" value="2" ng-model="styleType">
                                        <label for="showstyle2">大图</label>
                                </span>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="hornor-covers" data-right-edit data-id="4" >
				<label>积分抽奖图片<span>（封面建议尺寸750px*280px）</span></label>
				<div class="hornor-covers-manage">
					<div class="edit-img">

						<div>
							<img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="280" imageonload="changeBg()" data-dom-id="upload-pointImg" id="upload-pointImg"  ng-src="{{pointImg?pointImg:'/public/manage/img/zhanwei/zw_fxb_75_30.png'}}"  width="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="pointImg"  class="avatar-field bg-img" name="pointImg" ng-value="pointImg"/>
						</div>
					</div>
				</div>
			</div>-->
			<!--<div class="hornor-covers" data-right-edit data-id="2">
				<div class="hornor-covers-manage">
					<div class="edit-img">
						<div class="input-group-box">
							<label for="">签到赠送积分：</label>
							<input type="number" class="cus-input"  ng-model="point">
						</div>
					</div>
				</div>
			</div>-->
		</div>
	</div>
	<div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
	var app = angular.module('chApp', ['RootModule']);
	app.controller('chCtrl', ['$scope','$http','$timeout', function($scope,$http,$timeout){
		/*$scope.pointImg    = '<?php echo $_smarty_tpl->tpl_vars['pointImg']->value;?>
';*/
		$scope.banners     = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
		$scope.point       = <?php echo $_smarty_tpl->tpl_vars['point']->value;?>
;
		$scope.styleType   = '<?php echo $_smarty_tpl->tpl_vars['styleType']->value;?>
';
		$scope.ratio       = '<?php echo $_smarty_tpl->tpl_vars['ratio']->value;?>
';
		console.log('style：'+$scope.styleType);
	    $(function(){
	    	$('.mobile-page').on('click', '[data-left-preview]', function(event) {
	    		var id = $(this).data('id');
	    		$(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
	    		$(this).addClass('cur-edit');
	    		$("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
	    	});
	    });
		$scope.doThis=function(type,index){
			var realIndex=-1;
			/*获取要删除的真正索引*/
			realIndex = $scope.getRealIndex($scope[type],index);
			$scope[type][realIndex].imgsrc = imgNowsrc;
		};
	    $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.pointImg = imgNowsrc;
            }
        };
		$scope.addNewBanner = function(){
			var banner_length = $scope.banners.length;
			var defaultIndex = 0;
			if(banner_length>0){
				for (var i=0;i<banner_length;i++){
					if(parseInt(defaultIndex) < parseInt($scope.banners[i].index)){
						defaultIndex = $scope.banners[i].index;
					}
				}
				defaultIndex++;
			}
			if(banner_length>=8){
				layer.open({
					type: 1,
					title: false,
					shade:0,
					skin: 'layui-layer-error',
					closeBtn: 0,
					shift: 5,
					content: '最多只能添加8张广告图哦',
					time: 2000
				});
			}else{
				var banner_Default = {
					index: defaultIndex,
					imgsrc: '/public/wxapp/images/banner.jpg',
					articleId: ''
				};
				$scope.banners.push(banner_Default);
				$timeout(function(){
					//卸载掉原来的事件
					$(".cropper-box").unbind();
					new $.CropAvatar($("#crop-avatar"));
				},500);
			}
			console.log($scope.banners);
		}

		$scope.getRealIndex = function(type,index){
			var resultIndex = -1;
			for(var i=0;i<type.length;i++){
				if(type[i].index==index){
					resultIndex = i;
					break;
				}
			}
			return resultIndex;
		};


		$scope.delIndex=function(type,index){
			var realIndex=-1;
			/*获取要删除的真正索引*/
			realIndex = $scope.getRealIndex($scope[type],index);
			console.log(type+"-->"+realIndex);
			layer.confirm('您确定要删除吗？', {
				title:'删除提示',
				btn: ['确定','取消']
			}, function(){
				if($scope[type].length>1){
					$scope.$apply(function(){
						$scope[type].splice(realIndex,1);
					});
					layer.msg('删除成功');
				}else{
					layer.msg('最少要留一个哦');
				}
			});
		}
	  	// 保存数据
        $scope.saveData = function(){
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            },{
	                time : 10*1000
	            });
				console.log($scope.banners);
	            var data = {
	               /* 'pointImg'	: $scope.pointImg,*/
					'imgArr'    : $scope.banners,
					'point'	    : $scope.point,
					'ratio'     : $scope.ratio,
					'content'   : $('#content-detail').val(),
					'styleType' : $scope.styleType
	            };
	            $http({
	                method: 'POST',
	                url:    '/wxapp/community/savePointImg',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
	            });
	        });
        };




	}]);
	//图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

	// 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>

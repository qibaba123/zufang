<link rel="stylesheet" href="/public/wxapp/card/certificate/css/index.css?3">
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
<{include file="../common-community-menu.tpl"}>
<{include file="../article-kind-editor-other.tpl"}>
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
						<div class="top-img" data-left-preview data-id="2" style="background: #fff;height: 60px;line-height: 60px;padding: 0 10px;">
							<div style="text-align: center">
								<span style="display: inline-block; padding: 3px 15px;color: #666;line-height: 20px;border-radius: 3px">签到规则</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">

			<div class="active" data-right-edit data-id="2" style="display: block;">
				<div>
					<label for="">签到规则：</label>
					<div class="form-textarea">
						<textarea  class="form-control" style="width:100%;height:350px;visibility:hidden;text-align: left; resize:vertical;"  id="content-detail" name="content-detail" placeholder="签到规则"  rows="20">
							<{$content}>
						</textarea>
						<input type="hidden" name="sub_dir" id="sub-dir" value="default" />
						<input type="hidden" name="ke_textarea_name" value="content-detail" />
					</div>
				</div>
			</div>
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
		/*$scope.pointImg    = '<{$pointImg}>';*/
		$scope.banners     = <{$slide}>;
		$scope.point       = <{$point}>;
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
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
			console.log($scope.banners);
            var data = {
				'content'   : $('#content-detail').val(),
            };
            $http({
                method: 'POST',
                url:    '/wxapp/community/savePointImg',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
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
<{include file="../img-upload-modal.tpl"}>

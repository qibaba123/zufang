<link rel="stylesheet" href="/public/wxapp/card/certificate/css/index.css?3">
<link rel="stylesheet" href="/public/wxapp/card/certificate/css/style.css?1">
<style>
	.coupon-list{
		margin: 6px;
	}

	.coupon-list .coupon-top{
		background-color: #fff;
		padding: 5px;
		margin-bottom: 5px;
	}

	.coupon-list .coupon-top .coupon-top-left{
		width: 25%;
	    display: inline-block;
	    height: 75px;
	    line-height: 75px;
	    color: red;
	    text-align: center;
	}

	.coupon-list .coupon-top .coupon-top-left span{
		font-size: 30px;
	}

	.coupon-list .coupon-top .coupon-top-right{
		width: 73%;
    	display: inline-block;
    	padding: 10px;
	}

	.coupon-list .coupon-bottom{
		padding: 5px 10px;
    	margin-bottom: 10px;
    	background-color: #A6D8CC;
    	color: #fff;
	}

	.coupon-title{
		font-weight: bold;
	}
	
	.coupon-desc{
		overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
	}
	.card-logo{
		width: 100%;
		height: 100%;
		border-radius: 50%;
	}

</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
	<div class="mobile-page">
		<div class="mobile-header"></div>
		<div class="mobile-con">
			<div class="title-bar cur-edit">
				领取卡券
			</div>
			<!-- 主体内容部分 -->
			<div class="index-con">
				<!-- 首页主题内容 -->
				<div class="index-main">
					<div class="hornor-wrap">
					    <div class="top-img cur-edit" data-left-preview data-id="1">
					        <img ng-src="{{couponPic==''?'/public/manage/img/zhanwei/zw_fxb_750_320.png':couponPic}}" alt="卡券封面图"/>
					    </div>
					    
					</div>
					<div class="coupon-list">
						<{foreach $cardList as $value}>
							<div class="coupon-top">
								<div class="coupon-top-left">
									<img class="card-logo" src="<{$logo}>?">
								</div>
								<div class="coupon-top-right">
									<div class="coupon-title"><{$value['wc_brand_name']}></div>
									<div class="coupon-desc"><{$value['wc_title']}></div>
								</div>
							</div>
						<{/foreach}>
					</div>
				</div>
			</div>
			
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">
			<div class="hornor-covers" data-right-edit data-id="1" style="display: block;">
				<label>优惠券界面封面<span>（封面建议尺寸750px*300px）</span></label>
				<div class="hornor-covers-manage">
					<div class="edit-img">
						<div class="cropper-box" data-width="750" data-height="300" style="height:100%;">
	                        <img ng-src="{{couponPic?couponPic:'/public/manage/img/zhanwei/zw_fxb_750_320.png'}}"  onload="changeSrc(this)"  imageonload="changeBg()" alt="报名封面">
		                </div>
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
		$scope.couponPic  = '<{$background}>';

	    $(function(){
	    	$('.mobile-page').on('click', '[data-left-preview]', function(event) {
	    		var id = $(this).data('id');
	    		$(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
	    		$(this).addClass('cur-edit');
	    		$("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
	    	});
	    });

	    $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.couponPic = imgNowsrc;
            }
        };

	  	// 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'background'	: $scope.couponPic
            };
            $http({
                method: 'POST',
                url:    '/wxapp/currency/saveCardBackground',
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
<{$cropper['modal']}>

<link rel="stylesheet" href="/public/manage/limitCfg/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/limitCfg/css/index.css">
<link rel="stylesheet" href="/public/manage/limitCfg/css/style.css">
<div class="preview-page" ng-app="messApp" ng-controller="messCtrl" style="padding-bottom:70px;">
	<div class="mobile-page">
		<div class="mobile-header"></div>
		<div class="mobile-con">
			<div class="title-bar">
				限时抢购
			</div>
			<!-- 主体内容部分 -->
			<div class="index-con">
				<!-- 首页主题内容 -->
				<!--<div class="index-main" style="background-color: {{killManage.bgColor}}">-->
				<div class="index-main" style="background-color: #fff">
				    <div id="main-box">
				    	<div class="second-ad">
				    		<div class="dead-time" id="dead-time">距结束<span>00</span>:<span>00</span>:<span>00</span></div>
				    		<img ng-src="{{killManage.bannerImg}}" imageonload="changeBg()" alt="广告图">
				    	</div>
				    	<div class="second-goods">
				    		<ul>
				    			<li>
				    				<a href="#" class="border-b">
				    					<div class="goods-img">
				    						<img src="/public/manage/limitCfg/images/goodsView1.jpg" alt="商品图片">
				    					</div>
				    					<div class="goods-info">
				    						<h4>此处显示商品名称</h4>
				    						<div class="goods-price">
				    							<i class="doller">￥</i>199
				    						</div>
				    						<div class="goods-price-old">
				    							<del>￥359</del>
				    						</div>
				    						<span class="skill-btn">去秒杀</span>
				    						<div class="skill-lod">
				    						    <span class="sale-count" id="sale-count-b">已秒<em>23%</em></span>
				    						    <div id="progress-b" class="kill-progress">
				    						        <div class="skill-pro-bg">
				    						            <p class="skill-iteam-progress">
				    						                <span class="skill-pro-insetbg">
				    						                    <span class="skill-iteam-pro" style="width: 23%;"></span>
				    						                </span>
				    						            </p>
				    						        </div>
				    						    </div>
				    						</div>
				    					</div>
				    				</a>
				    			</li>
				    			<li>
				    				<a href="#" class="border-b">
				    					<div class="goods-img">
				    						<img src="/public/manage/limitCfg/images/goodsView2.jpg" alt="商品图片">
				    					</div>
				    					<div class="goods-info">
				    						<h4>此处显示商品名称</h4>
				    						<div class="goods-price">
				    							<i class="doller">￥</i>199
				    						</div>
				    						<div class="goods-price-old">
				    							<del>￥359</del>
				    						</div>
				    						<span class="skill-btn">去秒杀</span>
				    						<div class="skill-lod">
				    						    <span class="sale-count" id="sale-count-b">已秒<em>56%</em></span>
				    						    <div id="progress-b" class="kill-progress">
				    						        <div class="skill-pro-bg">
				    						            <p class="skill-iteam-progress">
				    						                <span class="skill-pro-insetbg">
				    						                    <span class="skill-iteam-pro" style="width: 56%;"></span>
				    						                </span>
				    						            </p>
				    						        </div>
				    						    </div>
				    						</div>
				    					</div>
				    				</a>
				    			</li>
				    			<li>
				    				<a href="#" class="border-b">
				    					<div class="goods-img">
				    						<img src="/public/manage/limitCfg/images/goodsView3.jpg" alt="商品图片">
				    					</div>
				    					<div class="goods-info">
				    						<h4>此处显示商品名称</h4>
				    						<div class="goods-price">
				    							<i class="doller">￥</i>199
				    						</div>
				    						<div class="goods-price-old">
				    							<del>￥359</del>
				    						</div>
				    						<span class="skill-btn">去秒杀</span>
				    						<div class="skill-lod">
				    						    <span class="sale-count" id="sale-count-b">已秒<em>23%</em></span>
				    						    <div id="progress-b" class="kill-progress">
				    						        <div class="skill-pro-bg">
				    						            <p class="skill-iteam-progress">
				    						                <span class="skill-pro-insetbg">
				    						                    <span class="skill-iteam-pro" style="width: 23%;"></span>
				    						                </span>
				    						            </p>
				    						        </div>
				    						    </div>
				    						</div>
				    					</div>
				    				</a>
				    			</li>
				    			<li>
				    				<a href="#" class="border-b">
				    					<div class="goods-img">
				    						<img src="/public/manage/limitCfg/images/goodsView4.jpg" alt="商品图片">
				    					</div>
				    					<div class="goods-info">
				    						<h4>此处显示商品名称</h4>
				    						<div class="goods-price">
				    							<i class="doller">￥</i>199
				    						</div>
				    						<div class="goods-price-old">
				    							<del>￥359</del>
				    						</div>
				    						<span class="skill-btn">去秒杀</span>
				    						<div class="skill-lod">
				    						    <span class="sale-count" id="sale-count-b">已秒<em>80%</em></span>
				    						    <div id="progress-b" class="kill-progress">
				    						        <div class="skill-pro-bg">
				    						            <p class="skill-iteam-progress">
				    						                <span class="skill-pro-insetbg">
				    						                    <span class="skill-iteam-pro" style="width: 80%;"></span>
				    						                </span>
				    						            </p>
				    						        </div>
				    						    </div>
				    						</div>
				    					</div>
				    				</a>
				    			</li>
				    		</ul>
				    	</div>
				    </div>
				</div>
			</div>
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">
			<div class="kill-manage">
				<!--
				<div class="kill-manage-item">
					<label for="">页面背景色</label>
					<p><input type="text" class="color" id="page-bgColor"></p>
				</div>
				-->
				<div class="kill-manage-item">
					<label for="">广告图管理</label>
					<div class="banner-img" >
						<img onclick="toUpload(this)"
							 imageonload="changeBannerImg()"
							 data-limit="1"
							 data-width="750"
							 data-height="210"
							 data-dom-id="banner-img"
							 id="banner-img"
							 data-dfvalue="/public/manage/limitCfg/images/second_banner.jpg"
							 placeholder="请上传广告图"
							 data-need="required"
							 src="<{if $row && $row['la_bg_img']}><{$row['la_bg_img']}><{else}>/public/manage/limitCfg/images/second_banner.jpg<{/if}>"   class="avatar-field bg-img img-thumbnail" >
						<a href="javascript:;" onclick="toUpload(this)" imageonload="changeBannerImg()" data-limit="1" data-width="750" data-height="210"  data-dom-id="banner-img" data-need="required">修改广告图</a>
					</div>
					<p class="size-tip">图片建议尺寸750*210</p>
				</div>
			</div>
		</div>
	</div>
	<div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveCfg()" > 保 存 </button></div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script src="/public/manage/limitCfg/js/jquery-ui-1.9.2.min.js"></script>
<script src="/public/manage/limitCfg/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/limitCfg/js/sortable.js"></script>
<script src="/public/manage/limitCfg/color-spectrum/spectrum.js"></script>
<script src="/public/manage/vendor/angular-root.js"></script>
<script>
	var la_id = <{$row['la_id']}>;
	var color_val = '<{$row['la_bg_color']}>';
	if(!color_val){
		color_val = '#fff'
	}
	var app = angular.module('messApp',['RootModule']);
	var bannerImgSrc = "<{$row['la_bg_img']}>";
	if(!bannerImgSrc){
		bannerImgSrc = '/public/manage/limitCfg/images/second_banner.jpg'
	}
	app.controller('messCtrl', ['$scope','$http', function($scope,$http){
		$scope.killManage = {
			bgColor:color_val,
			bannerImg:bannerImgSrc
		}
		$scope.changeBannerImg=function(){
	        if(bannerImgSrc){
	            $scope.killManage.bannerImg =bannerImgSrc;
	        }
	    };
		$(function(){
			// 页面背景色
			$("#page-bgColor").spectrum({
			    color: $scope.killManage.bgColor,
			    showButtons: false,
			    showInitial: true,
			    showPalette: true,
			    showSelectionPalette: true,
			    maxPaletteSize: 10,
			    preferredFormat: "hex",
			    move: function (color) {
			        var realColor = color.toHexString();
			        $scope.killManage.bgColor = realColor;
			        $(".index-main").css("background-color",realColor);
			        console.log($scope.killManage.bgColor);
			    },
			    palette: [
			            ['#5542CD','black', 'white', 'blanchedalmond',
			            'rgb(255, 128, 0);', '#6bc86b'],
			            ['red', 'yellow', '#16cfc0', 'blue', 'violet','#00c1f7']
			        ]
			    
			});
		});

		$scope.saveCfg   = function() {
			var index = layer.load(1, {
				shade: [0.1,'#fff'] //0.1透明度的白色背景
			},{
				time : 10*1000
			});
			var data = {
				'bg'   	 : $('#banner-img').attr('src'),
				'color'  : $scope.killManage.bgColor,
				'id'     : la_id
			};
			// console.log(data);
			$http({
				method: 'POST',
				url:    '/wxapp/limit/saveLimitBanner',
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
                    //call the function that was passed
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });
	function deal_select_img(allSrc){
		if(allSrc){
			$('#'+nowId).attr('src',allSrc[0]);
			bannerImgSrc = allSrc[0];
		}
	}
</script>
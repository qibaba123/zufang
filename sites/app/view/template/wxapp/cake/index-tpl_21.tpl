<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp2/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp2/css/style.css?3">
<style>
	.fenleinav-manage{
		padding: 10px;
    	background-color: #fff;
    	border: 1px solid #e8e8e8;
    	margin-top: 10px;
	}
	.goods-part .good .text{
		line-height: 1.5;
		overflow: hidden;
    	white-space: nowrap;
    	text-overflow: ellipsis
	}
	.banner-manage{
		padding-bottom: 15px;
	}
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
	<div class="mobile-page">
		<div class="mobile-header"></div>
		<div class="mobile-con">
			<div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">
				
			</div>
			<!-- 主体内容部分 -->
			<div class="index-con">
				<!-- 首页主题内容 -->
				<div class="index-main">
					<div class="banner-wrap" data-left-preview data-id="1">
				    	<img src="/public/wxapp/images/banner.jpg" alt="轮播图" ng-if="banners.length<=0">
				    	<img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
				    	<div class="paginations">
				    		<span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
				    	</div>
				    </div>
				    <div class="address-show flex-wrap" data-left-preview data-id="2" >
						<span ng-if="storeList.length<1">此处显示地址信息</span>
						<div ng-repeat="store in storeList" class="sotre-list">
					    	<span class="flex-con" ng-if="storeList.length<3" style="font-size: {{fontSize}}px;color:{{color}}">[{{store.os_name}}]{{store.os_addr}}</span>
					    	<span class="flex-con mulity" ng-if="storeList.length>2" style="font-size: {{fontSize}}px;color:{{color}}">[{{store.os_name}}]{{store.os_addr}}</span>
						</div>
						<img src="/public/wxapp/cake/images/jiantoubttom.png" class="enter" ng-if="storeList.length>2"  />
				  	</div>

					<div class="top-img" data-left-preview data-id="7" style="margin:10px 0">
						<img ng-src="{{couponImg==''?'/public/wxapp/card/certificate/images/zhanwei_750_230.jpg':couponImg}}" alt="报名封面图" style="width: 100%" />
					</div>

				  	<div class="goods-part recommend" data-left-preview data-id="3">
				  		<div class="title">{{shortcutTitle}}</div>
				  		<ul class="good-list">
							<li class="good" ng-repeat="good in goods">
								<div class="good-box">
									<img src="{{good.cover}}" alt="" class="good-cover">
									<div class="good-name text">{{good.name}}</div>
									<div class="good-price text">￥{{good.price}}<del>￥{{good.oriPrice}}</del></div> 
								</div>
							</li>
						</ul>
				  	</div>

				  	<div class="goods-part goods" data-left-preview data-id="4">
				  		<div class="title">{{cateOneTitle?cateOneTitle:'版块一'}}</div>
						<div class="good" ng-repeat="good in categoryGoods[indexCateOne].goods">
							<div class="good-box">
								<img src="{{good.cover}}" alt="" class="good-cover">
								<div class="good-name text">{{good.name}}</div>
								<div class="good-price text" style="color: #9BC7DF;font-size: 14px;">￥{{good.price}}<del>￥{{good.oriPrice}}</del></div>
							</div>
						</div>
						<div class="more"><span>查看更多</span></div>
				  	</div>
					<div class="top-img" data-left-preview data-id="5">
					    <img ng-src="{{img==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':img}}" alt="报名封面图" style="width: 100%" />
					</div>
					<div class="goods-part goods" data-left-preview data-id="6" style="margin-top: 0">
				  		<div class="title">{{cateTwoTitle?cateTwoTitle:'版块二'}}</div>
						<div class="good" ng-repeat="good in categoryGoods[indexCateTwo].goods">
							<div class="good-box">
								<img src="{{good.cover}}" alt="" class="good-cover">
								<div class="good-name text">{{good.name}}</div>
								<div class="good-price text" style="color: #9BC7DF;font-size: 14px;">￥{{good.price}}<del>￥{{good.oriPrice}}</del></div>
							</div>
						</div>
						<div class="more"><span>查看更多</span></div>
				  	</div>
				</div>
			</div>
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">
			<div class="header-top" data-right-edit data-id="0" style="display:block;">
				<label>顶部管理</label>
				<div class="top-manage">
					<div class="input-group-box">
						<label class="label-name">页面标题：</label>
						<input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
					</div>
				</div>
			</div>
			<div class="banner" data-right-edit data-id="1">
				<label>幻灯管理</label>
				<div class="banner-manage" ng-repeat="banner in banners">
					<div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
					<div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
						<div>
							<img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
						</div>
                    </div>
				</div>
				<div class="add-box" title="添加" ng-click="addNewBanner()"></div>
			</div>
			<div class="field" data-right-edit data-id="2">
				<label style="width: 100%">门店管理</label>
                <div class="fenleinav-manage">
                	<div class="input-group">
                        <div style="width: 100%;display: flex;margin-bottom: 30px;">
	                        <label class="label-name">地址文字颜色：</label>
	                        <div class="right-color">
	                            <input type="text" class="color-input" data-colortype="selectedColor" ng-model="color">
	                        </div>
	                    </div>   
                    </div>
                    <div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;display: flex">
                            <label class="label-name" style="width: 140px">地址文字大小：</label>
                            <select class="cus-input" ng-model="fontSize" ng-options="x.id as x.name for x in sizes"></select>
                        </div>
                    </div>
                    <div class="input-groups" style="margin-bottom: 10px;">
                    	<div class="no-data-tip">此处门店为固定链接，请到对应管理页面管理相关内容~</div>
					</div>
                </div>
			</div>
			<div class="coursepart" data-right-edit data-id="7">
				<label>优惠券页面链接图片<span>（图片建议尺寸750px*220px）</span></label>
				<div class="hornor-covers-manage">
					<div class="edit-img">
						<!--<div class="cropper-box" data-width="750" data-height="220" style="height:100%;">
							<img ng-src="{{couponImg?couponImg:'/public/wxapp/card/certificate/images/zhanwei_750_230.jpg'}}"  onload="changeSrc(this)"  imageonload="changeBg()" alt="图片" style="width: 100%">
						</div>-->
						<div>
							<img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="220" imageonload="changeBg()" data-dom-id="upload-couponImg" id="upload-couponImg{{$index}}"  ng-src="{{couponImg?couponImg:'/public/wxapp/card/certificate/images/zhanwei_750_225.jpg'}}"  width="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="couponImg"  class="avatar-field bg-img" name="couponImg" ng-value="couponImg"/>
						</div>
					</div>
				</div>
			</div>
			<div class="coursepart" data-right-edit data-id="3">
                <div class="fenleinav-manage">
					<div class="input-groups">
						<label class="label-name">标题名称：</label>
						<input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="shortcutTitle">
					</div>
                    <div class="no-data-tip">此处商品为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
			</div>
			<div class="coursepart" data-right-edit data-id="4">
				<div class="input-groups">
					<label class="label-name">标题名称：</label>
					<input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="cateOneTitle">
				</div>
                <div class="input-groups">
					<label for="">展示分类：</label>
					<select class="cus-input" ng-model="indexCateOne">
						<option ng-repeat="x in categoryGoods" value="{{x.id}}">{{x.name}}</option>
					</select>
				</div>
			</div>
			<div class="coursepart" data-right-edit data-id="5">
				<label>图片<span>（图片建议尺寸750px*300px）</span></label>
				<div class="hornor-covers-manage">
					<div class="edit-img">
						<!--<div class="cropper-box" data-width="750" data-height="300" style="height:100%;">
	                        <img ng-src="{{img?img:'/public/manage/img/zhanwei/zw_fxb_75_30.png'}}"  onload="changeSrc(this)"  imageonload="changeBg('img')" alt="图片" style="width: 100%">
		                </div>-->

						<div>
							<img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="changeBg('img')" data-dom-id="upload-img" id="upload-img{{$index}}"  ng-src="{{img?img:'/public/wxapp/card/certificate/images/zhanwei_750_225.jpg'}}"  width="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="img"  class="avatar-field bg-img" name="img" ng-value="img"/>
						</div>
					</div>
				</div>
			</div>
			<div class="coursepart" data-right-edit data-id="6">
				<div class="input-groups">
					<label class="label-name">标题名称：</label>
					<input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="cateTwoTitle">
				</div>
                <div class="input-groups">
					<label for="">展示分类：</label>
					<select class="cus-input" ng-model="indexCateTwo">
						<option ng-repeat="x in categoryGoods" value="{{x.id}}">{{x.name}}</option>
					</select>
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
	app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
		$scope.sizes = [{ id: '10', name:'10px'}, { id:'12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
		$scope.color          = '<{$tpl['aci_font_color']}>' ? '<{$tpl['aci_font_color']}>' : '#000000';
        $scope.fontSize       = '<{$tpl['aci_font_size']}>' ? '<{$tpl['aci_font_size']}>' : '14';
		$scope.headerTitle    = '<{$tpl['aci_title']}>' ? '<{$tpl['aci_title']}>' : '首页';
		$scope.img            = '<{$tpl['aci_cake_img']}>';
		$scope.couponImg      = '<{$tpl['aci_index_coupon_img']}>'
		$scope.banners        = <{$slide}>;
		$scope.tpl_id         = '<{$tpl['aci_tpl_id']}>';
		$scope.storeList      = <{$storeList}>;
		$scope.goods          = <{$goods}>;
		$scope.category       = <{json_encode($category)}>;
        $scope.groupList = <{$groupList}>;
        $scope.limitList = <{$limitList}>;
        $scope.bargainList = <{$bargainList}>;
		$scope.categoryGoods  = <{json_encode($categoryGoods)}>;
		$scope.indexCateOne   = '<{$tpl['aci_index_cate_one']}>';
		$scope.indexCateTwo   = '<{$tpl['aci_index_cate_two']}>';
		$scope.cateOneTitle   = '<{$tpl['aci_index_cate_one_name']}>';
		$scope.cateTwoTitle   = '<{$tpl['aci_index_cate_two_name']}>';
		$scope.shortcutTitle   = '<{$tpl['aci_shortcut_title']}>' ? '<{$tpl['aci_shortcut_title']}>' : '精品推荐';

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

	    /*获取真正索引*/
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

	    /*删除元素*/
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

            var data = {
                'title' 	      : $scope.headerTitle,
                'slide'		      : $scope.banners,
                'img'             : $scope.img,
				'couponImg'      : $scope.couponImg,
                'indexCateOne'    : $scope.indexCateOne,
                'indexCateOneName': $scope.cateOneTitle,
                'indexCateTwo'    : $scope.indexCateTwo,
                'indexCateTwoName': $scope.cateTwoTitle,
				'shortcutTitle'   : $scope.shortcutTitle,
                'color'           : $scope.color,
                'fontSize'        : $scope.fontSize,
                'tpl_id'	      : $scope.tpl_id,
            };
            $http({
                method: 'POST',
                url:    '/wxapp/cake/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        // 选择分类
        $scope.getSelectId = function(type,index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            var category = $scope.category;
            var curId = '';
            for(var i in category){
            	if(category[i] == title){
            		curId = i;
            	}
            }
            $scope[type][index].link = curId;
        };


	    $scope.inputChange = function(){
	    	console.log("aaa");
	    }

        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };

        $scope.initColor = function(obj,colorVal){
            obj.spectrum({
                color: colorVal,
                showButtons: false,
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxPaletteSize: 10,
                preferredFormat: "hex",
                move: function (color) {
                    var realColor = color.toHexString();
                    console.log(realColor);
                    $scope.$apply(function(){
                        $scope.color=realColor;
                        console.log($scope.color);
                    });
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        };

        $scope.changeBg=function(type){
            if(imgNowsrc){
				if(type == 'img'){
					$scope.img = imgNowsrc;
				}else{
					$scope.couponImg = imgNowsrc;
				}

            }
        };

	    $(function(){
	    	$('.mobile-page').on('click', '[data-left-preview]', function(event) {
	    		var id = $(this).data('id');
	    		$(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
	    		$(this).addClass('cur-edit');
	    		$("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
	    	});

	    	$("input.color-input").each(function(index, el) {
                var obj = $(this);
                var val = obj.val();
                console.log(val);
                $scope.initColor(obj,val);
            });

	    	$('img.enter').on('click', function(event) {
	        	if($('.address-show').hasClass('active')){
	        		$('.address-show').removeClass('active');
	        	}else{
	        		$('.address-show').addClass('active');
	        	}
	        	event.stopPropagation();
	    	});
	    });
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
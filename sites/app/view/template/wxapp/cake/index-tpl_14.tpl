<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp1/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp1/css/style.css?3">
<style>
	.fenleinav-manage{
		padding: 10px;
    	background-color: #fff;
    	border: 1px solid #e8e8e8;
	}
	.goods-part .good .text{
		line-height: 1.5;
		overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
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
				  	<div class="nav" data-left-preview data-id="3">
						<div class="nav-big">
							<img src="{{navList[0].imgsrc}}" alt="">
							<div class="nav-name" style="color: #B17A5E;font-size: 15px">{{navList[0].name}}</div>
							<div class="nav-brief" style="color: #B17A5E;">{{navList[0].brief}}</div>
						</div>
						<div class="nav-small">
							<img src="{{navList[1].imgsrc}}" alt="">
							<div class="nav-name" style="color:#DA6362;font-size: 15px">{{navList[1].name}}</div>
							<div class="nav-brief" style="color:#DA6362;">{{navList[1].brief}}</div>
						</div>
						<div class="nav-small">
							<img src="{{navList[2].imgsrc}}" alt="">
							<div class="nav-name" style="color:#48C5E7;font-size: 15px">{{navList[2].name}}</div>
							<div class="nav-brief" style="color:#48C5E7;">{{navList[2].brief}}</div>
						</div>
				  	</div>
				  	<div class="goods-part" data-left-preview data-id="4">
						<div class="good" ng-repeat="good in goods">
							<div class="good-box">
								<img src="{{good.cover}}" alt="" class="good-cover">
								<div class="good-name text">{{good.name}}</div>
								<div class="good-brief text" style="font-size: 13px;">{{good.brief}}</div>
								<div class="good-price text" style="color: #ff0033;font-size: 15px;">￥{{good.price}}</div>
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
			<div class="nav" data-right-edit data-id="3">
				<div class="nav-box">
					<div class="edit-img">
						<!--<div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
	                        <img ng-src="{{navList[0].imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('navList',0)" alt="导航图标">
	                        <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="coach.imgsrc"/>
	                        <span style="color: #999;font-size: 5px;">尺寸：200*200</span>
	                    </div>-->
						<div>
							<img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('navList',0)" data-dom-id="upload-navList0" id="upload-navList0"  ng-src="{{navList[0].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="navList0"  class="avatar-field bg-img" name="navList0" ng-value="navList[0].imgsr"/>
							<span style="color: #999;font-size: 5px;">尺寸：200*200</span>
						</div>
	                </div>
	                
					<div class="edit-txt">
						<div class="input-group-box">
							<label for="">活动名称：</label>
							<input type="text" class="cus-input" ng-model="navList[0].name">
						</div>
						<div class="input-group-box">
							<label for="">活动介绍：</label>
							<input type="text" class="cus-input" ng-model="navList[0].brief">
						</div>
						<!--
						<div class="input-groups">
							<label for="">链接到：</label>
							<select class="cus-input" ng-model="navList[0].linkTitle" ng-options="x as x for x in category" ng-change="getSelectId('navList',0,navList[0].linkTitle)"></select>
						</div>
						-->
						<div class="input-group-box clearfix">
							<label for="">链接类型：</label>
							<select class="cus-input form-control" ng-model="navList[0].type"  ng-options="x.id as x.name for x in linkTypes" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==1">
							<label for="">单　　页：</label>
							<select class="cus-input" ng-model="navList[0].link"  ng-options="x.id as x.title for x in articles" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==2">
							<label for="">列　　表：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.path as x.name for x in linkList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==3">
							<label for="">外　　链：</label>
							<input type="text" class="cus-input form-control" ng-value="navList[0].link" ng-model="navList[0].link" />
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==10">
							<label for="">分类详情：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.id as x.name for x in kindSelect" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==5">
							<label for="">商品详情：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.id as x.name for x in goods" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==29" style="margin-top: 10px;">
							<label for="">秒杀商品：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.id as x.name for x in limitList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==30" style="margin-top: 10px;">
							<label for="">拼团商品：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.id as x.name for x in groupList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==31" style="margin-top: 10px;">
							<label>砍价商品：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.id as x.name for x in bargainList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[0].type==106" style="margin-top: 10px;">
							<label>小 程 序：</label>
							<select class="cus-input form-control" ng-model="navList[0].link"  ng-options="x.appid as x.name for x in jumpList" ></select>
						</div>
					</div>
				</div>
				<div class="nav-box">
					<div class="edit-img">
						<!--<div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
	                        <img ng-src="{{navList[1].imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('navList',1)" alt="导航图标">
	                        <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="coach.imgsrc"/>
	                        <span style="color: #999;font-size: 5px;">尺寸：200*200</span>
	                    </div>-->
						<div>
							<img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('navList',1)" data-dom-id="upload-navList1" id="upload-navList1"  ng-src="{{navList[1].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="navList1"  class="avatar-field bg-img" name="navList1" ng-value="navList[1].imgsr"/>
							<span style="color: #999;font-size: 5px;">尺寸：200*200</span>
						</div>
	                </div>
					<div class="edit-txt">
						<div class="input-group-box">
							<label for="">活动名称：</label>
							<input type="text" class="cus-input" ng-model="navList[1].name">
						</div>
						<div class="input-group-box">
							<label for="">活动介绍：</label>
							<input type="text" class="cus-input" ng-model="navList[1].brief">
						</div>
						<!--
						<div class="input-groups">
							<label for="">链接到：</label>
							<select class="cus-input" ng-model="navList[1].linkTitle" ng-options="x as x for x in category" ng-change="getSelectId('navList',1,navList[1].linkTitle)"></select>
						</div>
						-->
						<div class="input-group-box clearfix">
							<label for="">链接类型：</label>
							<select class="cus-input form-control" ng-model="navList[1].type"  ng-options="x.id as x.name for x in linkTypes" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==1">
							<label for="">单　　页：</label>
							<select class="cus-input" ng-model="navList[1].link"  ng-options="x.id as x.title for x in articles" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==2">
							<label for="">列　　表：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.path as x.name for x in linkList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==3">
							<label for="">外　　链：</label>
							<input type="text" class="cus-input form-control" ng-value="navList[1].link" ng-model="navList[1].link" />
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==10">
							<label for="">分类详情：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.id as x.name for x in kindSelect" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==5">
							<label for="">商品详情：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.id as x.name for x in goods" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==29" style="margin-top: 10px;">
							<label for="">秒杀商品：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.id as x.name for x in limitList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==30" style="margin-top: 10px;">
							<label for="">拼团商品：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.id as x.name for x in groupList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==31" style="margin-top: 10px;">
							<label>砍价商品：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.id as x.name for x in bargainList" ></select>
						</div>
						<div class="input-group-box clearfix" ng-show="navList[1].type==106" style="margin-top: 10px;">
							<label>小 程 序：</label>
							<select class="cus-input form-control" ng-model="navList[1].link"  ng-options="x.appid as x.name for x in jumpList" ></select>
						</div>
					</div>
				</div>
				<div class="nav-box">
					<div class="edit-img">
						<!--<div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
	                        <img ng-src="{{navList[2].imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('navList',2)" alt="导航图标">
	                        <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="coach.imgsrc"/>
	                        <span style="color: #999;font-size: 5px;">尺寸：200*200</span>
	                    </div>-->
						<div>
							<img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('navList',2)" data-dom-id="upload-navList2" id="upload-navList2"  ng-src="{{navList[2].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
							<input type="hidden" id="navList2"  class="avatar-field bg-img" name="navList2" ng-value="navList[2].imgsr"/>
							<span style="color: #999;font-size: 5px;">尺寸：200*200</span>
						</div>
	                </div>
					<div class="edit-txt">
						<div class="input-group-box">
							<label for="">活动名称：</label>
							<input type="text" class="cus-input" ng-model="navList[2].name">
						</div>
						<div class="input-group-box">
							<label for="">活动介绍：</label>
							<input type="text" class="cus-input" ng-model="navList[2].brief">
						</div>
						<div class="input-groups">
							<label for="">链接到：</label>
							<!-- <select class="cus-input" ng-model="优惠券列表" disable="true" ng-options="x as x for x in category" ng-change="getSelectId('navList',2,navList[2].linkTitle)"></select> -->
							<input type="text" style="width: 100%;height: 35px" class="cus-input" disabled="disabled" value="优惠券列表">
						</div>
					</div>

				</div>
			</div>
			
			<div class="coursepart" data-right-edit data-id="4">
				<label style="width: 100%">首页商品管理</label>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处商品为固定链接，请到对应管理页面管理相关内容~</div>
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
		$scope.sizes = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
		$scope.color          = '<{$tpl['aci_font_color']}>' ? '<{$tpl['aci_font_color']}>' : '#000000';
        $scope.fontSize       = '<{$tpl['aci_font_size']}>' ? '<{$tpl['aci_font_size']}>' : '14';
		$scope.headerTitle = '<{$tpl['aci_title']}>' ? '<{$tpl['aci_title']}>' : '首页';
		$scope.banners     = <{$slide}>;
        $scope.jumpList = <{$jumpList}>;
		$scope.tpl_id      = '<{$tpl['aci_tpl_id']}>';
		$scope.storeList   = <{$storeList}>;
		$scope.goods       = <{$goods}>;
		$scope.kindSelect       = <{$kindSelect}>;
        $scope.articles        =  <{$information}>;
        $scope.groupList = <{$groupList}>;
        $scope.limitList = <{$limitList}>;
        $scope.bargainList = <{$bargainList}>;
		$scope.category    = <{json_encode($category)}>;
	    $scope.navList     = [
	    	{
	    		index: "<{$navList[0]['acs_index']}>" ? "<{$navList[0]['acs_index']}>" : 0,
	    		imgsrc: "<{$navList[0]['acs_imgsrc']}>" ? "<{$navList[0]['acs_imgsrc']}>" : "/public/manage/img/zhanwei/zw_fxb_200_200.png",
	    		name: '<{$navList[0]['acs_name']}>'?'<{$navList[0]['acs_name']}>':'新品发布',
	    		brief: '<{$navList[0]['acs_brief']}>'?'<{$navList[0]['acs_brief']}>':'期待，不一样的生活',
	    		link: '<{$navList[0]['acs_link']}>'?'<{$navList[0]['acs_link']}>':0,
	    		linkTitle: '<{$navList[0]['acs_link_title']}>'?'<{$navList[0]['acs_link_title']}>':'',
				type : '<{$navList[0]['acs_link_type']}>'?'<{$navList[0]['acs_link_type']}>':''
			},
			{
	    		index: '<{$navList[1]['acs_index']}>'?'<{$navList[1]['acs_index']}>':1,
	    		imgsrc: '<{$navList[1]['acs_imgsrc']}>'?'<{$navList[1]['acs_imgsrc']}>':'/public/manage/img/zhanwei/zw_fxb_200_200.png',
	    		name: '<{$navList[1]['acs_name']}>'?'<{$navList[1]['acs_name']}>':'精选蛋糕',
	    		brief: '<{$navList[1]['acs_brief']}>'?'<{$navList[1]['acs_brief']}>':'精致于心，自然不同',
	    		link: '<{$navList[1]['acs_link']}>'?'<{$navList[1]['acs_link']}>':0,
	    		linkTitle: '<{$navList[1]['acs_link_title']}>'?'<{$navList[1]['acs_link_title']}>':'',
                type : '<{$navList[1]['acs_link_type']}>'?'<{$navList[1]['acs_link_type']}>':''
			},
			{
	    		index: '<{$navList[2]['acs_index']}>'?'<{$navList[2]['acs_index']}>':2,
	    		imgsrc: '<{$navList[2]['acs_imgsrc']}>'?'<{$navList[2]['acs_imgsrc']}>':'/public/manage/img/zhanwei/zw_fxb_200_200.png',
	    		name: '<{$navList[2]['acs_name']}>'?'<{$navList[2]['acs_name']}>':'活动优惠',
	    		brief: '<{$navList[2]['acs_brief']}>'?'<{$navList[2]['acs_brief']}>':'优惠不放假，甜蜜陪伴',
	    		link: '<{$navList[2]['acs_link']}>'?'<{$navList[2]['acs_link']}>':0,
	    		linkTitle: '<{$navList[2]['acs_link_title']}>'?'<{$navList[2]['acs_link_title']}>':'',
                type : '<{$navList[2]['acs_link_type']}>'?'<{$navList[2]['acs_link_type']}>':''
			},
		];
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;

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
                'title' 	 : $scope.headerTitle,
                'slide'		 : $scope.banners,
                'navList'	 : $scope.navList,
                'tpl_id'	 : $scope.tpl_id,
                'color'      : $scope.color,
                'fontSize'   : $scope.fontSize,
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

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.coopera.imgsrc = imgNowsrc;
            }
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
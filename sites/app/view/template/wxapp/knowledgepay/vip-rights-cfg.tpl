<script>
    //console.log('<{json_encode($link)}>');
</script>
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css">
<style>

    .fenlei-nav ul { background-color: #fff; }
    .fenlei-nav li img { -webkit-border-radius: 25px; -moz-border-radius: 25px; -ms-border-radius: 25px; border-radius: 25px; }
    .good-list-wrap .good-list{padding: 0 4px;}
    .good-list-wrap .good-view2 .good-item{padding: 4px;box-sizing: border-box;}
    .good-list-wrap .good-view2 .item-wrap{padding: 0;}
    .good-list-wrap .good-view2 .good-image {width: 100%;height: 150px;}
    .good-list-wrap .good-view2 .good-title { text-align: left; }
    .good-list-wrap .good-view2 .price-buy{text-align: left;}
    .good-list-wrap .good-view2 .price-buy .sold{text-align: right;color: #999;font-size: 12px;}
    .recommend-img { padding: 0 4px 10px; overflow: hidden;margin-bottom: 8px; }
    .recommend-img .img-item { padding: 4px; box-sizing: border-box; float: left;margin: 0; width: 50%; height: 100px; }
    .fenleinav-manage .edit-img { -webkit-border-radius: 50%; -moz-border-radius: 50%; -ms-border-radius: 50%; border-radius: 50%; }
    .recommend-manage { padding: 15px; }
    .recommend-manage .edit-img { float: none; width: 90%; -webkit-border-radius: 0; -moz-border-radius: 0; -ms-border-radius: 0; border-radius: 0; height: auto; margin: 0 auto 8px; }
    .recommend-manage .edit-txt { float: none; width: 100% }
    .fenlei-nav ul { white-space: normal; }
    .recommend-img .img-item { width: 100%;height: auto;}
    .good-item{height: 90px;padding: 10px 15px;}
    .good-item .good-img { width: 70px; height: 70px; float: left; }
    .good-item .good-img img { width: 100%; height: 100%; display: block; border-radius: 4px}
    .good-item .good-intro { padding-left: 10px;float: left;width: 216px;position: relative;box-sizing: border-box; height: 73px; font-size: 12px; }
    .good-item .good-price { position: absolute; width: 100%; left: 0; bottom: 0; padding-left: 10px; box-sizing: border-box; }
</style>

<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">
                店铺主页
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div>
                        <div style="font-size: 22px;color: #aaa;padding: 50px 0;text-align: center;">此处用于展示会员卡信息</div>
                    </div>
                    <div class="fenlei-nav" data-left-preview data-id="1">
                        <div style="background: #fff;padding: 5px 11px;font-weight: bolder;">
                            <span>{{navTitle}}</span>
                        </div>
                        <div>
                            <div class="no-data-tip" ng-if="fenleiNavs.length<=0">点此添加导航~</div>
                            <ul ng-if="fenleiNavs.length>0" style="padding-top: 0">
                                <li ng-repeat="fenleiNav in fenleiNavs">
                                    <a href="javascript:;">
                                        <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                        <p ng-bind="fenleiNav.title"></p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div style="background: #fff;padding: 5px 11px;font-weight: bolder;">
                            <span>{{rightsTitle}}</span>
                        </div>
                        <div>
                            <div class="no-data-tip" ng-if="rightsCate.length<=0">点此添加分类~</div>
                            <ul ng-if="rightsCate.length>0" style="width: 1000px;padding-top: 0">
                                <li ng-repeat="cate in rightsCate" style="width: 105px;">
                                    <a href="javascript:;">
                                        <p ng-bind="cate.title"></p>
                                    </a>
                                </li>
                            </ul>
                            <div ng-if="rightsCate.length>0" style="background: #fff">
                                <div class="good-item border-b" ng-repeat="index in [0,1,2,3,4] track by $index">
                                    <div class="good-item-con">
                                        <div class="good-img">
                                            <img src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片">
                                        </div>
                                        <div class="good-intro">
                                            <div class="good-title"  style="font-weight: bolder">课程标题</div>
                                            <div class="good-brief" >课程简介</div>
                                            <div class="good-price" style="color: red">￥199</div>
                                        </div>
                                    </div>
                                </div>
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
                    <div class="input-group">
                        <label for="">页面标题</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>

            <div class="fenleinav" data-right-edit data-id="1">
                <div class="input-group">
                    <label for="">导航标题</label>
                    <input type="text" class="cus-input" placeholder="请输入导航标题" maxlength="10" ng-model="navTitle">
                </div>
                <label style="width: 100%">分类导航<span>(分类最多添加8个)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="150" data-height="150" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" maxlength="5" ng-value="fenleiNav.title" ng-model="fenleiNav.title">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                            <label for="">资讯详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==9">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label for="">课程详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <!-- 一级分类选择 -->
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==23">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==26">
                            <label for="">分类列表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                        </div>
                        <!-- 一级分类选择 -->
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==26">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==46">
                            <label for="" class="label-name">付费预约：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==32">
                            <label for="" class="label-name">资讯分类：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
                            <label for="" class="label-name">菜　　单：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link" ng-options="x.path as x.name for x in pages"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="2">
                <div class="input-group">
                    <label for="">权益标题</label>
                    <input type="text" class="cus-input" placeholder="请输入权益标题" maxlength="10" ng-model="rightsTitle">
                </div>
                <label style="width: 100%">分类</label>
                <div class="fenleinav-manage" ng-repeat="cate in rightsCate">
                    <div class="delete" ng-click="delIndex('rightsCate',cate.index)">×</div>
                    <div class="edit-txt" style="float: inherit;width: 90%">
                        <div class="input-group-box clearfix">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" maxlength="5" ng-value="cate.title" ng-model="cate.title">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">分类数据：</label>
                            <select class="cus-input form-control" ng-model="cate.link"  ng-options="x.id as x.name for x in cateknowpayType" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addRightsCateNew()"></div>
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
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle = "<{$row['akrc_header_title']}>" ? "<{$row['akrc_header_title']}>" : "会员权益" ;
        $scope.navTitle    = "<{$row['akrc_nav_title']}>" ? "<{$row['akrc_nav_title']}>" : "会员权益" ;
        $scope.rightsTitle = "<{$row['akrc_rights_title']}>" ? "<{$row['akrc_rights_title']}>" : "会员权益" ;
        $scope.fenleiNavs  = <{$navList}>;
        $scope.rightsCate  = <{$rightsCate}>;
        $scope.cateknowpayType = [{id:'1', name:'图文课程'},{id:'2', name:'音频课程'},{id:'3', name:'视频课程'}];


        $scope.knowpayType          = [{id:'1', name:'图文分类列表'},{id:'2', name:'音频分类列表'},{id:'3', name:'视频分类列表'}];
        $scope.goodsList            = <{$goodsList}>;
        $scope.firstKindSelect      = <{$firstKindSelect}>;
        $scope.kindSelect           = <{$kindSelect}>;
        $scope.jumpList             = <{$jumpList}>;
        $scope.linkTypes            = <{$linkType}>;
        $scope.linkList             = <{$linkList}>;
        $scope.articles             = <{$information}>;
        $scope.audioList            = <{$audioList}>;
        $scope.pages                =  <{$page_list}>;
        $scope.informationCategory  = <{$informationCategory}>;
        $scope.articleCoverType     = "<{$tpl['aki_article_cover_type']}>";
        $scope.audioCoverType       = "<{$tpl['aki_audio_cover_type']}>";
        $scope.videoCoverType       = "<{$tpl['aki_video_cover_type']}>";
        $scope.appointmentGoodsList = <{$appointmentGoodsList}>;
        $scope.allKindSelect        = <{$allKindSelect}>;

        /*添加分类导航方法*/
        $scope.addNewfenleiNav = function(){
            var fenleiNav_length = $scope.fenleiNavs.length;
            var defaultIndex = 0;
            if(fenleiNav_length>0){
                for (var i=0;i<fenleiNav_length;i++){
                    if(defaultIndex < $scope.fenleiNavs[i].index){
                        defaultIndex = $scope.fenleiNavs[i].index;
                    }
                }
                defaultIndex++;
            }
            if(fenleiNav_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个分类导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    articleId: '',
                    link : '',
                    type : '4'
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.fenleiNavs);
        }

        /*添加分类方法*/
        $scope.addRightsCateNew = function(){
            var rightsCate_length = $scope.rightsCate.length;
            var defaultIndex = 0;
            if(rightsCate_length>0){
                for (var i=0;i<rightsCate_length;i++){
                    if(defaultIndex < $scope.rightsCate[i].index){
                        defaultIndex = $scope.rightsCate[i].index;
                    }
                }
                defaultIndex++;
            }
            if(rightsCate_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个分类导航哦',
                    time: 2000
                });
            }else{
                var rightsCate_Default = {
                    index: defaultIndex,
                    title: '默认标题',
                    link : '',
                };
                $scope.rightsCate.push(rightsCate_Default);
            }
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
        }

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
                if(type == 'fenleiNavs'){
                    //导航可以全部删除
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                }else{
                    if($scope[type].length>1){
                        $scope.$apply(function(){
                            $scope[type].splice(realIndex,1);
                        });
                        layer.msg('删除成功');
                    }else{
                        layer.msg('最少要留一个哦');
                    }
                }

            });
        };
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取图片的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };
        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.shopintrobg = imgNowsrc;
            }
        };

        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).data('id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
            });
        });

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
	
	            var data = {
	                'headerTitle' 	: $scope.headerTitle,
	                'navTitle'		: $scope.navTitle,
	                'rightsTitle'	: $scope.rightsTitle,
                    'navList'       : $scope.fenleiNavs,
                    'rightsCate'    : $scope.rightsCate,
	             };
	            console.log(data);
	            $http({
	                method: 'POST',
	                url:    '/wxapp/knowledgepay/saveVipRightsCfg',
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
                    //call the function that was passed
                    console.log(attrs.imageonload);
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
        console.log(imgNowsrc);

    }
</script>
<{include file="../img-upload-modal.tpl"}>
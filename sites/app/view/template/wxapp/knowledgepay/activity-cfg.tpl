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
    .good-list-wrap .title-name p {
        text-align: center;
    }
    .good-list-wrap .title-name p:before {
        position: inherit;
    }
    .good-list-wrap .good-view2 .good-item {
        width: 100%;
    }
    .good-list-wrap .good-view2 .good-image {
        width: 35%;
        height: 105px;
        display: inline-block;
    }

    .good-list-wrap .good-view2 .good-intro {
        width: 63%;
        display: inline-block;
        height: 105px;
        padding-top: 10px;
    }

    .good-list-wrap{
        background: #fff;
        margin-bottom: 10px;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" >
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
                    <div data-left-preview data-id="1">
                        <div class="banner-wrap">
                            <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
                            <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                            <div class="paginations">
                                <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                            </div>
                        </div>
                    </div>
                    <div class="good-show-wrap" data-left-preview data-id="4">
                        <div class="no-data-tip" ng-if="goodFlShow.length<=0">点此添加活动~</div>
                        <div class="good-list-wrap" ng-repeat="goodfl in goodFlShow" ng-if="goodFlShow.length>0">
                            <div class="title-name flex-wrap">
                                <p class="flex-con">{{goodfl.title}}</p>
                                <!-- <div class="more-enter">
                                    更多
                                    <img src="/public/wxapp/mall/temp3/images/icon_more_enter.png" />
                                </div> -->
                            </div>
                            <div class="good-list good-view2">
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView1.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView2.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView3.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView4.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
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
            <div class="banner" data-right-edit data-id="1">
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*400px)</span></label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="4">
                <label style="width: 100%">分类课程展示管理</label>
                <div class="fenleinav-manage" ng-repeat="goodfl in goodFlShow">
                    <div class="delete" ng-click="delIndex('goodFlShow',goodfl.index)">×</div>
                    <div class="input-group-box" style="margin-bottom: 10px;">
                        <label style="width: 70px">标题名称：</label>
                        <input type="text" class="cus-input" ng-model="goodfl.title" maxlength="15">
                    </div>
                    <div class="input-group-box" style="margin-bottom: 10px;">
                        <label style="width: 70px">链接到：</label>
                        <select class="cus-input" ng-model="goodfl.link" ng-options="x.id as x.name for x in activityType"></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewGoodfl()"></div>
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
        $scope.headerTitle= "<{$tpl['aka_title']}>" ? "<{$tpl['aka_title']}>" : "微秒杀" ;
        $scope.isopen     = '<{$tpl['aka_isopen']}>';
        $scope.applyTitle     = '<{$tpl['aka_apply_title']}>';
        $scope.goodFlShow     = <{$tpl['aka_kinds']}>;
        $scope.activityType     = <{$activityType}>;
        $scope.banners = <{$slide}>;

        /*添加新的轮播图*/
        $scope.addNewBanner = function(){
            var banner_length = $scope.banners.length;
            var defaultIndex = 0;
            if(banner_length>0){
                for (var i=0;i<banner_length;i++){
                    if(defaultIndex < $scope.banners[i].index){
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
                    imgsrc: '/public/wxapp/mall/temp3/images/banner_zhanwei.jpg',

                };
                $scope.banners.push(banner_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.banners);
        };

        /*添加新的课程分类*/
        $scope.addNewGoodfl = function(){
            var goodfl_length = $scope.goodFlShow.length;
            var defaultIndex = 0;
            if(goodfl_length>0){
                for (var i=0;i<goodfl_length;i++){
                    if(defaultIndex < $scope.goodFlShow[i].index){
                        defaultIndex = $scope.goodFlShow[i].index;
                    }
                }
                defaultIndex++;
            }
            if(goodfl_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个课程分类哦',
                    time: 2000
                });
            }else{
                var goodfl_Default = {
                    index: defaultIndex,
                    title:'默认名称',
                    link: ''
                };
                $scope.goodFlShow.push(goodfl_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.goodFlShow);
        };

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
                if($scope[type].length>1){
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                }else{
                    layer.msg('最少要留一个哦');
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
            /*控制店铺图片宽高比*/
            // $(".shop-bg").height($(".shop-bg").width()*0.3175);
            initListShow()
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).data('id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
            });
        });

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title' 	    : $scope.headerTitle,
                'slide'		    : $scope.banners,
                'goodFlShow'	: $scope.goodFlShow,
                'isopen'        : $scope.isopen,
                'applyTitle'     : $scope.applyTitle,
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/knowledgepay/saveActivityCfg',
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
                    console.log(attrs.imageonload);
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    /*遍历添加对应列表展示样式*/
    function initListShow(){
        $('.edit-con').find(".showstyle-radio input[type=hidden]").each(function(index, el) {
            var styleVal = $(this).val();
            $(this).parents('.showstyle-radio').find('span').eq(styleVal-1).find('input[type=radio]').prop('checked','checked');
        });
        $(".index-main").find("input[type=hidden]").each(function(index, el) {
            var that = $(this);
            var styleVal = that.val();
            var styleDiv = $(this).parents(".hot-product").find(".goods-show>div");
            var curClass = styleDiv.attr("class");
            styleDiv.removeClass(curClass).addClass('goods-view'+styleVal);
        });
    }

    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
        console.log(imgNowsrc);

    }
</script>
<{include file="../img-upload-modal.tpl"}>
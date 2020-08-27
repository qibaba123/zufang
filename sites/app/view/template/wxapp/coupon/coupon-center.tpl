<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp22/css/index.css?5">
<link rel="stylesheet" href="/public/wxapp/index/temp22/css/style.css?3">
<style>
    .recommend-img { padding: 0 4px 10px; overflow: hidden;margin-bottom: 8px; }
    .recommend-img .img-item { padding: 4px; box-sizing: border-box; float: left;margin: 0; width: 50%; height: 100px; }
    .recommend-manage { padding: 15px; }
    .recommend-manage .edit-img { float: none; width: 90%; -webkit-border-radius: 0; -moz-border-radius: 0; -ms-border-radius: 0; border-radius: 0; height: auto; margin: 0 auto 8px; }
    .recommend-manage .edit-txt { float: none; width: 100% }
    .notice-box .notice-txt {
        height: 40px;
    }

    .notice-box .noticeicon {
        width: 50px;
        margin-right: 15px;
    }

    .fenlei-nav ul {
        white-space: inherit;
        height: 150px;
    }

    .fenlei-nav li img {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        border-radius: 10px;
    }

    .fenleinav-manage .edit-img {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        border-radius: 10px;
    }
    .edit-con input[type=number], .edit-con select, .edit-con textarea {
        padding: 7px 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        width: 100%;
        -webkit-transition: box-shadow 0.5s;
        -moz-transition: box-shadow 0.5s;
        -ms-transition: box-shadow 0.5s;
        -o-transition: box-shadow 0.5s;
        transition: box-shadow 0.5s;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        min-height: 34px;
        resize: none;
        background-color: #fff;
    }
    .post-type .tg-list-item{
        display: inline;
        float: right;
        margin-right: 35%;
    }
    .post-type .edit-txt{
        margin-bottom: 10px;
    }
    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
    .fenlei-nav li {
        width: 20%;
    }
    .fenleinav-manage .input-num input{border-radius:0;text-align: center;}
    .fenleinav-manage .input-num label{width:88px;line-height:3!important;}
    .fenleinav-manage .input-num .input-group-addon{line-height:2!important;}
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
                    <!-- 幻灯 -->
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/manage/img/zhanwei/zw_fxb_75_40.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>

                    <!-- 分类导航 -->
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div class="no-nav" ng-if="fenleiNavs.length<=0">
                            暂无分类哦~
                        </div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
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
                    <div class="input-groups">
                        <label for="">页面标题</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label style="width: 100%;">幻灯管理<span>(幻灯图片建议尺寸:750px*400px)</span></label>
                <div ui-sortable="sortableOptions" ng-model="banners">
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                        <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>

                    <div class="input-group clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypesNew" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==1">
                        <label for="">单　　页：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==5">
                        <label for="" style="width: 20%;float: left;">商品详情：</label>
                        <select class="cus-input form-control" style="padding:2px 15px;width: 80%;float: left;" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==20">
                        <label for="" style="width: 20%;float: left;">店铺详情：</label>
                        <select class="cus-input form-control" style="padding:2px 15px;width: 80%;float: left;" ng-model="banner.link"  ng-options="x.id as x.name for x in shopList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==34">
                        <label for="">店铺分类：</label>
                        <select class="cus-input" style="padding:2px 15px" ng-model="banner.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                    </div>
                    <!-- 自营商品一级分类 -->
                    <div class="input-group clearfix" ng-show="banner.type==23">
                        <label for="">商品分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                    </div>
                    <!-- 自营商品二级分类 -->
                    <div class="input-group clearfix" ng-show="banner.type==9">
                        <label for="">商品分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==41">
                        <label for="">商品分组：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsGroup" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==42">
                        <label for="">商品分组：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in shopGoodsGroup" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==16">
                        <label for="">店铺分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==17">
                        <label for="">店铺详情：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in shopList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==32">
                        <label for="">资讯分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==40">
                        <label for="">帖子分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.title for x in postCategory" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==104">
                        <label for="">菜　　单：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.path as x.name for x in pages" ></select>
                    </div>
                </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="2" >
                <label style="width: 100%">导航<span></span></label>
                <div ui-sortable="sortableOptions" ng-model="fenleiNavs">
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
                                <select class="cus-input" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypesNew" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                                <label for="">单　　页：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                                <label for="">列　　表：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                                <label for="">外　　链：</label>
                                <input type="text" class="cus-input" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                                <label for="" >商品详情：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==20">
                                <label for="" >店铺详情：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==34">
                                <label for="">店铺分类：</label>
                                <select class="cus-input" style="padding:2px 15px" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                            </div>
                            <!-- 自营商品一级分类 -->
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==23">
                                <label for="">商品分类：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                            </div>
                            <!-- 自营商品二级分类 -->
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==9">
                                <label for="">商品分类：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==41">
                                <label for="">商品分组：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsGroup" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==42">
                                <label for="">商品分组：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopGoodsGroup" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==16">
                                <label for="">店铺分类：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==17">
                                <label for="">店铺详情：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopList" ></select>
                            </div>

                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                                <label for="">小 程 序：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==32">
                                <label for="">资讯分类：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==40">
                                <label for="">帖子分类：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in postCategory" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
                                <label for="">菜　　单：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in pages" ></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>

            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>


<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.headerTitle     = '<{$tpl['acc_title']}>';
        $scope.banners         = <{$slide}>;
        $scope.shopList        = <{$shopList}>;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkTypesNew = <{$linkTypeNew}>;
        $scope.linkList  = <{$linkList}>;
        $scope.articles        = <{$information}>;
        $scope.postCategory = <{$postCategory}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.goodsList          = <{$goodsList}>;
        $scope.currSecondKindSelect = <{$currSecondKindSelect}>;
        $scope.currFirstKindSelect = <{$currFirstKindSelect}>;
        $scope.shopCategory = <{$shopCategory}>
        $scope.goodsGroup = <{$goodsGroup}>;
        $scope.shopGoodsGroup = <{$shopGoodsGroup}>;
        $scope.infocateList       = <{$infocateList}>;
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.shopKindSelect       = <{$shopKindSelect}>;
        $scope.pages =  <{$page_list}>;

        $scope.sortableOptions = {
            update: function(e, ui) {
                setTimeout(function () {
                    for(let i in $scope.banners){
                        $scope.banners[i].index = i;
                    }
                    for (let i in $scope.fenleiNavs) {
                        $scope.fenleiNavs[i].index = i;
                    }
                }, 500);

                console.log("拖动完成");
            },
            axis: 'y'
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
                layer.msg("最多只能添加8张广告图哦~");
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                    link:$scope.articles.length>0?$scope.articles[0].id:'',
                    articleTitle:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:'',
                    type : '1'
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
            if(fenleiNav_length>=30){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加30个分类导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    articleId: $scope.articles.length>0?$scope.articles[0].id:'',
                    link : $scope.articles.length>0?$scope.articles[0].id:'',
                    type : '1'
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
        $scope.delIndex=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }


            console.log(type+"-->"+realIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if(parentType){
                    $scope.$apply(function(){
                        $scope[parentType][type].splice(realIndex,1);
                    });
                }else{
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                }
                layer.msg('删除成功');
            });
            console.log($scope.appointInfo);
        }




        $scope.doThis=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
                $scope[parentType][type][realIndex].imgsrc = imgNowsrc;
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
                $scope[type][realIndex].imgsrc = imgNowsrc;
            }


        };

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            console.log($scope.memberCardType);
            var data = {
                'headerTitle' 	 : $scope.headerTitle,
                'slide'		     : $scope.banners,
                'shortcut'       : $scope.fenleiNavs,
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/coupon/saveCouponCenter',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).attr('data-id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
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
<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:18:23
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/giftcard/gift-card-index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9695740615e4e6aff2f9862-21861704%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0336b67803aaeca099690f784eec63e3ca93c9c' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/giftcard/gift-card-index.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9695740615e4e6aff2f9862-21861704',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl' => 0,
    'slide' => 0,
    'shopList' => 0,
    'linkType' => 0,
    'linkTypeNew' => 0,
    'linkList' => 0,
    'information' => 0,
    'postCategory' => 0,
    'jumpList' => 0,
    'goodsList' => 0,
    'currSecondKindSelect' => 0,
    'currFirstKindSelect' => 0,
    'shopCategory' => 0,
    'goodsGroup' => 0,
    'shopGoodsGroup' => 0,
    'infocateList' => 0,
    'shortcut' => 0,
    'shopKindSelect' => 0,
    'coverList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6aff33a067_92083613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6aff33a067_92083613')) {function content_5e4e6aff33a067_92083613($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
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
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
                    <div class="hot-recommend" data-left-preview data-id="2">
                        <div ng-if="listTitle" style="text-align: center">{{listTitle}}</div>
                        <div class="recommend-img">
                            <div class="no-data-tip" ng-if="coverList.length<=0" style="height: 60px;line-height: 60px;font-size: 18px">点此添礼品卡封面~</div>
                            <div class="img-item" ng-repeat="good in coverList" style="height:120px">
                                <img ng-src="{{good.imgsrc}}" style="height: auto !important;"/>
                                <div style="text-align: center;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{good.name}}</div>
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
                    <div class="input-groups">
                        <label for="">页面标题</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label style="width: 100%;">幻灯管理<span>(幻灯图片建议尺寸:750px*400px)</span></label>
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
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>

            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">封面管理<span>(图片建议尺寸为750px*470px)</span></label>
                <div class="top-manage">
                    <div class="input-groups">
                        <label for="">列表标题</label>
                        <input type="text" class="cus-input" placeholder="请输入列表标题" maxlength="24" ng-model="listTitle">
                    </div>
                </div>
                <div class="fenleinav-manage recommend-manage" ng-repeat="good in coverList" style="height: 230px">
                    <div class="delete" ng-click="delIndex('coverList',good.index)">×</div>
                    <div class="edit-img" style="width: 50%;">
                        <!--<div class="cropper-box" data-width="400" data-height="250" style="height:100%;">
                            <img ng-src="{{good.imgsrc}}"  onload="changeSrc(this)" imageonload="doThis('coverList',good.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="good.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="470" imageonload="doThis('coverList',good.index)" data-dom-id="upload-good{{$index}}" id="upload-good{{$index}}"  ng-src="{{good.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="good{{$index}}"  class="avatar-field bg-img" name="good{{$index}}" ng-value="good.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix" style="height: 40px">
                            <label for="">名称：</label>
                            <input class="cus-input form-control" style="padding:2px 15px" ng-model="good.name" >
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addCover()"></div>
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
        $scope.headerTitle     = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agcs_title'];?>
';
        $scope.banners         = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.shopList        = <?php echo $_smarty_tpl->tpl_vars['shopList']->value;?>
;
        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkTypesNew = <?php echo $_smarty_tpl->tpl_vars['linkTypeNew']->value;?>
;
        $scope.linkList  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.articles        = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.postCategory = <?php echo $_smarty_tpl->tpl_vars['postCategory']->value;?>
;
        $scope.jumpList = <?php echo $_smarty_tpl->tpl_vars['jumpList']->value;?>
;
        $scope.goodsList          = <?php echo $_smarty_tpl->tpl_vars['goodsList']->value;?>
;
        $scope.currSecondKindSelect = <?php echo $_smarty_tpl->tpl_vars['currSecondKindSelect']->value;?>
;
        $scope.currFirstKindSelect = <?php echo $_smarty_tpl->tpl_vars['currFirstKindSelect']->value;?>
;
        $scope.shopCategory = <?php echo $_smarty_tpl->tpl_vars['shopCategory']->value;?>

        $scope.goodsGroup = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.shopGoodsGroup = <?php echo $_smarty_tpl->tpl_vars['shopGoodsGroup']->value;?>
;
        $scope.infocateList       = <?php echo $_smarty_tpl->tpl_vars['infocateList']->value;?>
;
        $scope.fenleiNavs = <?php echo $_smarty_tpl->tpl_vars['shortcut']->value;?>
;
        $scope.shopKindSelect       = <?php echo $_smarty_tpl->tpl_vars['shopKindSelect']->value;?>
;
        $scope.coverList = <?php echo $_smarty_tpl->tpl_vars['coverList']->value;?>
;
        $scope.listTitle = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agcs_list_title'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agcs_list_title'];?>
' : '';


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
                    link: $scope.articles.length>0?$scope.articles[0].id:'',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
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
        }

        /*添加分类导航方法*/
        $scope.addNewfenleiNav = function(){
            var fenleiNav_length = $scope.fenleiNavs.length;
            var defaultIndex = 0;
            if(fenleiNav_length>0){
                for (var i=0;i<fenleiNav_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.fenleiNavs[i].index)){
                        defaultIndex = $scope.fenleiNavs[i].index;
                    }
                }
                defaultIndex++;
            }
            if(fenleiNav_length>=60){
                layer.msg("最多只能添加60个分类");
            }else{
                var fenleiNav_Default = {
                    id: 0,
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    type: '1',    // 默认是帖子类型
                    price : 0,
                    linkUrl : '',
                    mobileShow : false,
                    addressShow : false,
                    allowComment : true,
                    verifyComment : false
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }


        };


        $scope.addCover = function(){
            var good_length = $scope.coverList.length;
            var defaultIndex = 0;
            if(good_length>0){
                for (var i=0;i<good_length;i++){
                    if(defaultIndex < $scope.coverList[i].index){
                        defaultIndex = $scope.coverList[i].index;
                    }
                }
                defaultIndex++;
            }
            var good_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/zw_fxb_750_422.png',
                name: '默认名称',
                id:'0'
            };
            $scope.coverList.push(good_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
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
        }

        $scope.changeApplyIcon=function(){
            if(imgNowsrc){
                $scope.applyIcon = imgNowsrc;
            }
        };

        $scope.changeStatIcon=function(){
            if(imgNowsrc){
                $scope.statIcon = imgNowsrc;
            }
        };

        // 选择文章
        $scope.getSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var articles = $scope.articles;
            var curId = '';
            var curTitle = '';
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                    curTitle = articles[i].title;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
                $scope[type][realIndex].title = curTitle;
            }
        };

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
            var data = {
                'headerTitle'       : $scope.headerTitle,
                'slide'		        : $scope.banners,
                'coverList'         : $scope.coverList,
                'listTitle'         : $scope.listTitle
            };
            $http({
                method: 'POST',
                url:    '/wxapp/giftcard/saveGiftCardIndex',
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
<?php if ($_smarty_tpl->tpl_vars['tpl']->value['aci_s_id']==4546) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal-test.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
    <?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?><?php }} ?>

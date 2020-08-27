<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 15:45:04
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/sequence/menu-index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1011590645e86e98013dbd7-90581873%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28f7168486f7d7cd07119f1b2f30a6c86e56c08d' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/sequence/menu-index.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1011590645e86e98013dbd7-90581873',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'slide' => 0,
    'menuCate' => 0,
    'currSecondKindSelect' => 0,
    'currFirstKindSelect' => 0,
    'information' => 0,
    'tpl' => 0,
    'goodsList' => 0,
    'goodsGroup' => 0,
    'infocateList' => 0,
    'linkType' => 0,
    'linkList' => 0,
    'limitGoodsGroup' => 0,
    'limitList' => 0,
    'menuList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86e980174e49_93567718',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86e980174e49_93567718')) {function content_5e86e980174e49_93567718($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/appointment/css/index.css?1">
<link rel="stylesheet" href="/public/wxapp/appointment/css/style.css?1">
<style>
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }
    /*.goods-bottom{*/
        /*position: relative;*/
        /*bottom: 1px;*/
        /*text-align: center;*/
        /*width: 100%;*/
    /*}*/
    .classify-preiview-page .classify-name span {
        display: table-cell;
        width: 1000px;
        text-align: center;
        height: 35px;
        line-height: 35px;
    }
</style>

<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar" data-left-preview data-id="0" ng-bind="headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <!-- 背景图 -->
                    <div class="banner-wrap cur-edit" data-left-preview data-id="1">
                        <img src="/public/manage/img/zhanwei/zw_fxb_75_40.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>
                    <div class="notice-box classify-preiview-page" data-left-preview data-id="2">
                        <div class="classify-name" ng-show="secondCate.length > 0">
                            <span ng-repeat="cate in secondCate | limitTo:4" >{{cate.title}}</span>
                        </div>
                        <div class="classify-name" ng-show="secondCate.length == 0">
                            <span style="color: red;text-align: center;font-size: 16px">点此添加分类</span>
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


            <div class="banner" data-right-edit data-id="1"  style="display:block;">
                <label>幻灯管理</label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="360" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="20" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-group clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==1">
                        <label for="">资讯详情：</label>
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
                        <label for="" style="">商品详情：</label>
                        <select class="cus-input" style="" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==4">
                        <label for="" style="">商品详情：</label>
                        <select class="cus-input" style="" ng-model="banner.link"  ng-options="x.id as x.name for x in category" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==20">
                        <label for="" style="">店铺详情：</label>
                        <select class="cus-input" style="" ng-model="banner.link"  ng-options="x.id as x.name for x in shopList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==34">
                        <label for="">店铺分类：</label>
                        <select class="cus-input" style="" ng-model="banner.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==23">
                        <label for="">商品分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==9">
                        <label for="">商品分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==32">
                        <label for="">资讯分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==29">
                        <label for="">秒杀商品：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in limitList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==42">
                        <label for="">商品分组：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==61">
                        <label for="">菜单详情：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.title for x in menuList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==11">
                        <label for="">商品分组：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="notice" data-right-edit data-id="2">
                <label>分类</label>
                <div class="service-manage" ng-repeat="cate in secondCate">
                    <div class="delete" ng-click="delIndex('secondCate',cate.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">名　称：</label>
                            <input maxlength="6" type="text" class="cus-input" ng-model="cate.title">
                        </div>
                        <!--
                        <div class="input-groups">
                            <label for="">排　序：</label>
                            <input type="text" class="cus-input" ng-model="cate.sort">
                        </div>
                        <div class="input-groups">
                            <label for="">费　用：</label>
                            <input type="text" class="cus-input" ng-model="cate.price">
                        </div>
                        -->
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewCate()"></div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){

        $scope.banners = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.secondCate = <?php echo $_smarty_tpl->tpl_vars['menuCate']->value;?>
;
        $scope.currSecondKindSelect = <?php echo $_smarty_tpl->tpl_vars['currSecondKindSelect']->value;?>
;
        $scope.currFirstKindSelect = <?php echo $_smarty_tpl->tpl_vars['currFirstKindSelect']->value;?>
;
        $scope.articles        = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.headerTitle     = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['asc_menu_title'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['asc_menu_title'];?>
' : '美食区';
        $scope.goodsList = <?php echo $_smarty_tpl->tpl_vars['goodsList']->value;?>
;
        $scope.category  = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.infocateList = <?php echo $_smarty_tpl->tpl_vars['infocateList']->value;?>
;
        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkList  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.limitGoodsGroup = <?php echo $_smarty_tpl->tpl_vars['limitGoodsGroup']->value;?>
;
        $scope.limitList = <?php echo $_smarty_tpl->tpl_vars['limitList']->value;?>
;
        $scope.menuList = <?php echo $_smarty_tpl->tpl_vars['menuList']->value;?>
;

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




        /*删除元素*/
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');

                // if($scope[type].length>1){
                //
                // }else{
                //     layer.msg('最少要留一个哦');
                // }
            });
        };

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
            if(banner_length>=20){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error', 
                    closeBtn: 0, 
                    shift: 5,
                    content: '最多只能添加20张广告图哦',
                    time: 2000
                });
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                    type : '1',
                    link: $scope.articles.length>0?$scope.articles[0].id:'',
                };
                $scope.banners.push(banner_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
        }

        $scope.addNewCate = function(){
            var cate_length = $scope.secondCate.length;
            var defaultIndex = 0;
            if(cate_length>0){
                for (var i=0;i<cate_length;i++){
                    if(defaultIndex < $scope.secondCate[i].index){
                        defaultIndex = $scope.secondCate[i].index;
                    }
                }
                defaultIndex++;
            }
            // if(cate_length>=5){
            //     layer.open({
            //         type: 1,
            //         title: false,
            //         shade:0,
            //         skin: 'layui-layer-error',
            //         closeBtn: 0,
            //         shift: 5,
            //         content: '最多只能添加5张广告图哦',
            //         time: 2000
            //     });
            // }else{
            //
            // }
            var cate_Default = {
                id : -1,
                index: defaultIndex,
                title: '分类名称',
                price: '0',
                sort: '0'
            };
            $scope.secondCate.push(cate_Default);
        }

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.headImg = imgNowsrc;
            }
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

        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };

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
                    'title'   : $scope.headerTitle,
	                'slide'   : $scope.banners,
                    'id'      : $scope.id,
                    'secondCate' : $scope.secondCate
	             };
	            $http({
	                method: 'POST',
	                url:    '/wxapp/sequence/saveMenuIndex',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
	                if(response.data.ec == 200){
	                    //window.location.reload();
                    }
	            }); 
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
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:05:46
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/auction/auction-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1450159115e4e680a06cd18-80633772%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '10e97df0c67224adbc8511e2f97072e004698305' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/auction/auction-cfg.tpl',
      1 => 1579405882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1450159115e4e680a06cd18-80633772',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl' => 0,
    'slide' => 0,
    'linkType' => 0,
    'linkList' => 0,
    'information' => 0,
    'infocateList' => 0,
    'jumpList' => 0,
    'page_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e680a0a1b23_30919102',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e680a0a1b23_30919102')) {function content_5e4e680a0a1b23_30919102($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/appointment/css/index.css?1">
<link rel="stylesheet" href="/public/wxapp/appointment/css/style.css?1">
<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/style.css?3">
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

    .recommend-img .img-item-small {
        width: 46%;
        height: auto;
        float: left;
        margin: 10px 5px;
    }
    .img-item-small img{
        width: 100%;
    }
    .list-title{
        text-align: center;
        font-size: 17px;
        padding: 5px 0;
    }
    .label-name{
        display: inline-block;
        width: 17%;
    }
    .select-name{
        display: inline-block;
        width: 82%;!important;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <!--#4c8fbd;-->
<!--<div style="margin-left:135px;"><a target="_blank" style="color:red; " href="
https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=405&page=1&extra=#pid10039">该插件使用教程请点此查看</a></div>-->
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
                        <div data-left-preview data-id="1">
                            <div class="banner-wrap">
                                <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
                                <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                                <div class="paginations">
                                    <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                                </div>
                            </div>
                        </div>
                        <div class="goods-part" data-left-preview data-id="2">
                            <div class="goods-head">
                                <span class="left">{{listTitle}}</span>
                                <div class="right">
                                    {{orderTitle}} >
                                </div>
                            </div>
                        </div>
                        <div class="appointment-wrap" data-left-preview data-id="3">
                            <div class="no-data-tip" style="font-size: 20px;color: red">基础信息配置</div>
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
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*360px)</span></label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="360" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <!--
                    <div class="input-group-box">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleId" ng-options="x.id as x.name for x in goodsList"></select>
                    </div>
                    -->
                    <div class="input-group-box clearfix">
                        <label class="label-name" for="">链接类型：</label>
                        <select class="cus-input form-control" style="width: 82%;float: right;" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==1" style="margin-top: 10px;">
                        <label for="" class="label-name">资讯详情：</label>
                        <select class="cus-input form-control" style="width: 82%;float: right;" ng-model="banner.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==2" style="margin-top: 10px;">
                        <label for="" class="label-name">列　　表：</label>
                        <select class="cus-input form-control" style="width: 82%;float: right;" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==3" style="margin-top: 10px;">
                        <label for="" class="label-name">VR链接：</label>
                        <input type="text" class="cus-input form-control" style="width: 82%;float: right;" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==32" style="margin-top: 10px;">
                        <label for="" class="label-name">资讯分类：</label>
                        <select class="cus-input form-control" style="width: 82%;float: right;" ng-model="banner.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==106" style="margin-top: 10px;">
                        <label for="" class="label-name">小 程 序：</label>
                        <select class="cus-input form-control" style="width: 82%;float: right;" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==104" style="margin-top: 10px;">
                        <label for="" class="label-name">菜　　单：</label>
                        <select class="cus-input form-control" style="width: 82%;float: right;" ng-model="banner.link" ng-options="x.path as x.name for x in pages"></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="notice" data-right-edit data-id="2">
                <div class="fenleinav-manage">
                    <div class="input-groups">
                        <label for="">拍卖列表：</label>
                        <input type="text" class="cus-input" ng-model="listTitle">
                    </div>
                    <div class="input-groups">
                        <label for="">我的拍卖：</label>
                        <input type="text" class="cus-input" ng-model="orderTitle">
                    </div>
                    <div class="no-data-tip">此处为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="3">
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 150px;">获拍后支付确认时间：</label>
                    <input type="text" class="cus-input" ng-model="confirmTime" style="width: 55%">
                    <span style="font-weight: 700;margin-left: 10px">天</span>
                </div>
                <div class="input-group-box">
                    <label class="label-name">服务时间：</label>
                    <input type="text" class="cus-input time" ng-model="serviceStartTime" style="width: 40%" onchange="" >
                    <input type="text" class="cus-input time" ng-model="serviceEndTime" style="width: 40%" onchange="" >
                </div>
                <div class="input-group-box">
                    <label class="label-name">客服电话：</label>
                    <input type="text" class="cus-input" ng-model="phone" placeholder="请输入联系电话">
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle= "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_title'];?>
" : "拍卖" ;
        $scope.listTitle= "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_list_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_list_title'];?>
" : "拍卖列表" ;
        $scope.orderTitle= "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_order_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_order_title'];?>
" : "我的竞拍" ;
        $scope.banners = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.phone   = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_phone'];?>
";
        $scope.confirmTime = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_confirm_time'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_confirm_time'];?>
' : '7';
        $scope.serviceStartTime = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_service_start_time'];?>
";
        $scope.serviceEndTime = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_service_end_time'];?>
";

        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkList  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.noticeTxt      = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.informationCategory = <?php echo $_smarty_tpl->tpl_vars['infocateList']->value;?>
;
        $scope.jumpList = <?php echo $_smarty_tpl->tpl_vars['jumpList']->value;?>
;
        $scope.pages    =  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
;



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
                    articleId: $scope.noticeTxt[0]?$scope.noticeTxt[0].id:'',
                    link : $scope.noticeTxt[0]?$scope.noticeTxt[0].id:'',
                    type : '1'

                };
                $scope.banners.push(banner_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
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
        }

        /*删除元素*/
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if($scope[type].length>1 || type=='fenleiNavs'){
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
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            },{
	                time : 10*1000
	            });
	            var data = {
	                'title' 	    : $scope.headerTitle,
	                'slide'		    : $scope.banners,
                    'phone'         : $scope.phone,
	                'listTitle'     : $scope.listTitle,
	                'orderTitle'    : $scope.orderTitle,
                    'confirmTime'   : $scope.confirmTime,
                    'serviceStartTime' : $scope.serviceStartTime,
                    'serviceEndTime'   : $scope.serviceEndTime
	            };
	            $http({
	                method: 'POST',
	                url:    '/wxapp/auction/saveCfg',
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

    }

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

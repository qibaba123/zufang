<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:11:48
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mall/index-tpl_3.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21129524925e859e44e44d01-29833240%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '335f6c36a083a39612d4ae9c605e00c104d61289' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mall/index-tpl_3.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21129524925e859e44e44d01-29833240',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl' => 0,
    'jumpList' => 0,
    'information' => 0,
    'kindSelect' => 0,
    'firstKindSelect' => 0,
    'goodsList' => 0,
    'appointmentGoodsList' => 0,
    'slide' => 0,
    'groupList' => 0,
    'limitList' => 0,
    'bargainList' => 0,
    'kindList' => 0,
    'goodsGroup' => 0,
    'linkType' => 0,
    'linkList' => 0,
    'infocateList' => 0,
    'page_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e859e44e918c8_24728346',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e859e44e918c8_24728346')) {function content_5e859e44e918c8_24728346($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/shopfixture/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/manage/applet/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css">

<style>
    .notice-box {
        height: 40px;
        margin-top: 5px;
    }
    .notice-box {
        padding: 0;
        background: #fff;
    }
    .notice-box {
        padding: 10px;
    }
    .notice-txt {
        font-size: 15px;
        line-height: 20px;
        overflow: hidden;
        height: 100%;
        padding-left:15px;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle" style="background-color: #f8f8f8">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="shop-intro" data-left-preview data-id="1">
                        <!--
                        <img ng-src="{{shopintrobg}}" alt="商铺图">
                        <div class="shop-name">
                            <a href="#" class="logo"><img src="/public/manage/applet/temp1/images/sy_20.png" alt="logo"></a>
                        </div>
                        -->
                        <div class="banner-wrap">
                            <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
                            <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                            <div class="paginations">
                                <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                            </div>
                        </div>
                    </div>


                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="5">
                        <div style="display: inline-block;font-size: {{fontSize}}px;color:{{color}};height: 100%;float:left;line-height: 20px;margin:0 2px;">{{noticeTitle}}</div>
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0" >最新公告内容</p>
                            <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                        </div>
                    </div>

                    <div class="hot-product" data-left-preview data-id="2">
                        <input type="hidden" ng-value="proShowstyle">
                        <div class="title">
                            <span>店铺推荐</span>
                        </div>
                        <div class="goods-show">
                            <div class="goods-view1">
                                <ul>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/applet/temp1/images/goodsView1.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥9999</p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/applet/temp1/images/goodsView2.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥9999</p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/applet/temp1/images/goodsView3.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥9999</p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
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
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <!--
            <div class="shopintrobg" data-right-edit data-id="1">
                <label>背景图</label>
                <div class="shopintrobg-manage">
                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="276" imageonload="changeBg()" data-dom-id="upload-shopintrobg" id="upload-shopintrobg{{$index}}"  ng-src="{{shopintrobg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="shopintrobg"  class="avatar-field bg-img" name="shopintrobg" ng-value="shopintrobg"/>
                    <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="276" data-dom-id="upload-shopintrobg">修改背景图<span>(建议尺寸750*276)</span></a>
                </div>
            </div>
            -->
            <div class="banner" data-right-edit data-id="1">
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*400px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px;">搜索文本：</label>
                    <input type="text" class="cus-input" placeholder="请输入搜索提示内容" maxlength="10" ng-model="searchPlaceholder">
                </div>
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
                    <!--
                    <div class="input-group-box">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleId" ng-options="x.id as x.name for x in goodsList"></select>
                    </div>
                    -->
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==1">
                        <label for="">资讯详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==4">
                        <label for="">分组详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in category" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==9">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==5">
                        <label for="">商品详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==46">
                        <label for="">付费预约：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in appointmentGoodsList" ></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==23">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==29" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 17%">秒杀商品：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in limitList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==30" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 17%">拼团商品：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in groupList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==31" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 17%">砍价商品：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==32">
                        <label for="">资讯分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==106" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 16%">小 程 序：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==104">
                        <label for="" class="label-name">菜　　单：</label>
                        <select class="cus-input form-control" ng-model="banner.link" ng-options="x.path as x.name for x in pages"></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="goodsShow" data-right-edit data-id="2">
                <label>列表样式</label>
                <div class="goods-show-manage">
                    <div class="radio-box showstyle-radio">
                        <input type="hidden" ng-value="proShowstyle" ng-model="proShowstyle">
                        <span ng-click="changeShowStyle($event)" data-id="1">
								<input type="radio" name="goods-show" id="showstyle1">
								<label for="showstyle1">大图</label>
							</span>
                        <span ng-click="changeShowStyle($event)" data-id="2">
								<input type="radio" name="goods-show" id="showstyle2">
								<label for="showstyle2">小图</label>
							</span>
                        <span ng-click="changeShowStyle($event)" data-id="3">
								<input type="radio" name="goods-show" id="showstyle3">
								<label for="showstyle3">一大两小</label>
							</span>
                        <span ng-click="changeShowStyle($event)" data-id="4">
								<input type="radio" name="goods-show" id="showstyle4">
								<label for="showstyle4">详细列表</label>
							</span>
                    </div>
                </div>
            </div>

            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="5">
                <label>最新公告</label>
                <div class="edit-con" style="margin-bottom: 4px;margin-top: 2px">
                    <div class="activity link-setting" style="display:block;">
                <span class='tg-list-item'>
						是否启用头条公告功能
                     <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus('<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_id'];?>
')" <?php if ($_smarty_tpl->tpl_vars['tpl']->value&&$_smarty_tpl->tpl_vars['tpl']->value['ami_notice_status']==1) {?>checked<?php }?> >
                     <label class='tgl-btn' for='audit_status'></label>
                </span>
                    </div>
                </div>
                <div class="fenleinav-manage">
                    <div class="input-group-box" style="margin-bottom: 20px;">
                        <label class="label-name">公告标题：</label>
                        <input type="text" class="cus-input" placeholder="请输入公告标题" maxlength="4" ng-model="noticeTitle">
                    </div>
                    <div class="input-group">
                        <div style="width: 100%;display: flex;margin-bottom: 30px;">
                            <label class="label-name">地址文字颜色：</label>
                            <div class="right-color">
                                <input type="text" class="color-input" data-colortype="selectedColor" ng-model="color">
                            </div>
                        </div>
                    </div>
                    <!--<div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;display: flex">
                            <label class="label-name" style="width: 140px">地址文字大小：</label>
                            <select class="cus-input" ng-model="fontSize" ng-options="x.id as x.name for x in sizes"></select>
                        </div>
                    </div>-->
                    <div class="service-manage">
                        <label  class="label-name" for="">头条内容取资讯内容,请在资讯功能位置添加</label>
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
    var imgNowsrc=0 ;

    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle    = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_title'];?>
";
        $scope.shopintrobg    = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_head_img'];?>
";
        $scope.proShowstyle   = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_goods_list'];?>
";
        $scope.tpl_id		  = "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_tpl_id'];?>
";
        $scope.jumpList = <?php echo $_smarty_tpl->tpl_vars['jumpList']->value;?>
;
        $scope.noticeTitle    = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_title'];?>
':'今日头条';
        $scope.noticeTxt      = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.sizes          = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
        $scope.color          = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_color'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_color'];?>
' : '#000000';
        $scope.fontSize       = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_size'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_size'];?>
' : '16';

        $scope.kindSelect = <?php echo $_smarty_tpl->tpl_vars['kindSelect']->value;?>
;
        $scope.firstKindSelect = <?php echo $_smarty_tpl->tpl_vars['firstKindSelect']->value;?>
;
        $scope.goodsList = <?php echo $_smarty_tpl->tpl_vars['goodsList']->value;?>
;
        $scope.appointmentGoodsList = <?php echo $_smarty_tpl->tpl_vars['appointmentGoodsList']->value;?>
;
        $scope.banners = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.groupList = <?php echo $_smarty_tpl->tpl_vars['groupList']->value;?>
;
        $scope.limitList = <?php echo $_smarty_tpl->tpl_vars['limitList']->value;?>
;
        $scope.bargainList = <?php echo $_smarty_tpl->tpl_vars['bargainList']->value;?>
;
        $scope.goodFlShow = <?php echo $_smarty_tpl->tpl_vars['kindList']->value;?>
;
        $scope.category  = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkList  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.informationCategory = <?php echo $_smarty_tpl->tpl_vars['infocateList']->value;?>
;
        $scope.pages                =  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
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
                    articleId: $scope.goodsList[0]?$scope.goodsList[0].id:'',
                    link : $scope.goodsList[0]?$scope.goodsList[0].id:'',
                    type : '5'
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

        $scope.changeShowStyle=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var index = $($event.target).parent('span').data('id');
            console.log(index);
            that.get(0).checked=true;

            var styleDiv = $(".index-main").find(".hot-product").find(".goods-show>div");
            var curClass = styleDiv.attr("class");
            styleDiv.removeClass(curClass).addClass('goods-view'+index);
            $scope.proShowstyle = index;

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
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取图片的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                console.log(imgNowsrc);
                $scope.shopintrobg = imgNowsrc;
            }
        };
        $scope.initListShow = function(){
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
        };
        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'title' 	 : $scope.headerTitle,
                'head_img'   : $scope.shopintrobg,
                'list_type'  : $scope.proShowstyle,
                'tpl_id'	 : $scope.tpl_id,
                'notice_title'     : $scope.noticeTitle,
                'notice_color'     : $scope.color,
                'slide'		       : $scope.banners,
                //'notice_size'      : $scope.fontSize
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/mall/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
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
            $scope.initListShow();//初始化列表样式
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
        });
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
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
        console.log(imgNowsrc);
        // return imgNowsrc;

    }
    function changeAuditStatus(id) {
        var status = $('#audit_status').is(':checked');
        var data = {
            status : status ? 1 : 0,
            id     : id
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mall/changeNoticeStatus',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(data.status==1){
                        layer.msg('启用成功');
                    }else{
                        layer.msg('关闭成功');
                    }
                }
            }
        });
    }
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>

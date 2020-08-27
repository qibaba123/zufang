<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:10:45
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/group/group-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16231299215dea1b153c6d29-50600263%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f866b965eb9417f63d00070738d6641d5e99583' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/group/group-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16231299215dea1b153c6d29-50600263',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl' => 0,
    'setMemberCenter' => 0,
    'shopType' => 0,
    'goods' => 0,
    'slide' => 0,
    'shortcut' => 0,
    'goodsGroup' => 0,
    'activityGroup' => 0,
    'linkTypes' => 0,
    'linkList' => 0,
    'kindSelect' => 0,
    'page_list' => 0,
    'ordinaryGoodsGroup' => 0,
    'shoplist' => 0,
    'shopGoodsGroup' => 0,
    'shopKindSelect' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1b15425605_07507361',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1b15425605_07507361')) {function content_5dea1b15425605_07507361($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css">
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
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <!--#4c8fbd;-->
<!--<div style="margin-left:135px;"><a target="_blank" style="color:red; " href="
http://p5oby9nm7.bkt.clouddn.com/%E6%8B%BC%E5%9B%A2.mp4">该插件使用教程请点此查看</a></div>-->
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
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div class="no-data-tip" ng-if="fenleiNavs.length<=0">点此添加导航~</div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="hot-recommend" data-left-preview data-id="3" style="margin-top: 5px">
                        <div class="list-title">
                            {{listTitle}}
                        </div>
                        <div class="recommend-img list-type_1" <?php if ($_smarty_tpl->tpl_vars['tpl']->value['agi_list_type']==1) {?> style="display:block" <?php } else { ?> style="display:none" <?php }?>>
                            <div class="img-item" ng-repeat="good in goodsList">
                                <img ng-src="{{good.cover}}" />
                                <div>{{good.name}}</div>
                                <div>
                                    <div style="float: left;color: red;font-weight: 700;">￥{{good.price}}<del style="color: #808080;margin-left: 10px;font-weight: normal;font-size: 12px;">￥{{good.oriprice}}</del></div>
                                    <div style=" float: right;padding: 0 10px;background: #444;color: white;border-radius: 4px;">{{good.total}}人团</div>
                                </div>
                            </div>
                        </div>
                        <div class="recommend-img list-type_2" <?php if ($_smarty_tpl->tpl_vars['tpl']->value['agi_list_type']==2) {?> style="display:block" <?php } else { ?> style="display:none" <?php }?>>
                            <div class="img-item-small" ng-repeat="good in goodsList">
                                <img ng-src="{{good.cover}}" />
                                <div style="line-height: 1.5;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{good.name}}</div>
                                <div>
                                    <div style="float: left;color: red;font-weight: 700;margin-top: 5px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;max-width: 85px">
                                        <div>
                                            ￥{{good.price}}
                                        </div>
                                        <div style="color: #808080;font-weight: normal;font-size: 12px;">
                                            <s>￥{{good.oriprice}}</s>
                                        </div>
                                    </div>
                                    <div style=" float: right;padding: 0 5px;background: #FF534C;color: white;font-size: 10px;margin-top: 20px;">去开团</div>
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
                    <!--
                    <?php if ($_smarty_tpl->tpl_vars['setMemberCenter']->value==1) {?>
                        <div class="input-group" style="margin-top: 5px">
                            <label style="">个人中心我的拼团</label>
                            <div class="goods-show-manage">
                                <div class="radio-box showstyle-radio">
                        <span data-id="1">
								<input type="radio" name="member-center" value="1" id="memberCenter1"  ng-model="memberCenter" ng-checked="memberCenter == 1">
								<label for="memberCenter1">显示</label>
                        </span>
                                    <span data-id="2">
								<input type="radio" name="member-center" value="0" id="memberCenter2" ng-model="memberCenter" ng-checked="memberCenter == 0">
								<label for="memberCenter2">不显示</label>
                        </span>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    -->
                    <?php if ($_smarty_tpl->tpl_vars['shopType']->value==6||$_smarty_tpl->tpl_vars['shopType']->value==8) {?>
                    <div class="input-group">
                       <label for="">是否开启活动申请</label>
                        <!--<input type="checkbox" class="cus-input" id="showlist1" data-id="myfx">
                        <label for="showlist1">开启</label>-->
                        <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='isopen' type='checkbox' ng-checked='isopen==1' ng-model="isopen">
                                <label class='tgl-btn' for='isopen'></label>
                        </span>
                    </div>
                    <div class="input-group">
                        <label for="">申请活动说明语</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="applyTitle">
                    </div>
                    <?php }?>
                    <!--<div class="check-row">
                        <span>分销中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist1" data-id="myfx" ng-checked="centerInfo.showlist.myfx.isShow==1" ng-click="checked($event)">
                                <label for="showlist1">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myfx.name"></p>
                        </div>
                    </div>-->
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
            <div class="fenleinav" data-right-edit data-id="2">
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
                        <!--
                        <div class="input-group-box clearfix">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="fenleiNav.articleId" ng-options="x.id as x.name for x in category"></select>
                        </div>
                        -->
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==4">
                            <label for="">分组详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in ordinaryGoodsGroup" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==9">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==12">
                            <label for="">分组详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in category" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
                            <label for="">菜　　单：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in pages" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==20">
                            <label for="">店铺详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==42">
                            <label for="">商品分组：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==34">
                            <label for="">店铺分类：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="3">
                <div class="fenleinav-manage">
                    <div class="input-group" style="margin-bottom: 10px">
                        <label style="font-weight: bold">列表标题</label>
                         <input type="text" class="cus-input" placeholder="请输入列表标题" maxlength="8" ng-model="listTitle">
                    </div>
                    <div class="input-group">
                        <label style="font-weight: bold">列表样式</label>
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
                    </div>
                </div>
                    </div>
                </div>
                <div class="no-data-tip">此处活动为固定链接，请到对应管理页面管理相关内容~</div>
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
        $scope.goodsList = <?php echo $_smarty_tpl->tpl_vars['goods']->value;?>
;
        $scope.headerTitle= "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_title'];?>
" : "微拼团" ;
        $scope.listTitle= "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_list_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_list_title'];?>
" : "限时特惠拼团" ;
        $scope.proShowstyle = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_list_type'];?>
';
        $scope.isopen     = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_isopen'];?>
';
        $scope.applyTitle     = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_apply_title'];?>
';
        //$scope.memberCenter = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['agi_member_center'];?>
';
        $scope.banners = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.fenleiNavs = <?php echo $_smarty_tpl->tpl_vars['shortcut']->value;?>
;
        // $scope.category  = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.category  = <?php echo $_smarty_tpl->tpl_vars['activityGroup']->value;?>
;
        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkTypes']->value;?>
;
        $scope.linkList  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.kindSelect = <?php echo $_smarty_tpl->tpl_vars['kindSelect']->value;?>
;
        $scope.pages =  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
;
        $scope.ordinaryGoodsGroup = <?php echo $_smarty_tpl->tpl_vars['ordinaryGoodsGroup']->value;?>
;
        $scope.shoplist  = <?php echo $_smarty_tpl->tpl_vars['shoplist']->value;?>
;
        $scope.shopCategory = <?php echo $_smarty_tpl->tpl_vars['shopGoodsGroup']->value;?>
;
        $scope.shopKindSelect  = <?php echo $_smarty_tpl->tpl_vars['shopKindSelect']->value;?>
;
        console.log($scope.isopen);
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
                    articleId: $scope.category[0]?$scope.category[0].id:'',
                    link : $scope.category[0]?$scope.category[0].id:'',
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

            if(index == 1){
                $('.list-type_1').css('display','block');
                $('.list-type_2').css('display','none');
            }else if(index == 2){
                $('.list-type_1').css('display','none');
                $('.list-type_2').css('display','block');
            }

        }
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
                if($scope[type].length>0 || type=='fenleiNavs'){
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
	            var open        = $('#isopen:checked').val();
	            var data = {
	                'title' 	    : $scope.headerTitle,
	                'slide'		    : $scope.banners,
	                'shortcut'	    : $scope.fenleiNavs,
	                'listTitle'     : $scope.listTitle,
	                'listType'      : $scope.proShowstyle,
	                'isopen'        : open == 'on' ? 1 : 0,
	                'applyTitle'    : $scope.applyTitle,
	                //'memberCenter'  : $scope.memberCenter
	            };
	            console.log(data);
	            $http({
	                method: 'POST',
	                url:    '/wxapp/group/saveCfg',
	                data:   data
	            }).then(function(response) {
	                console.log(response);
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
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

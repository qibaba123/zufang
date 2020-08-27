<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:04:48
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/appointment/appointment-template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16737708795e4df7504372d1-88892018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc7e00b32adc75b66ba07f659d3f0e6023a969ed' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/appointment/appointment-template.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16737708795e4df7504372d1-88892018',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'dyyu' => 0,
    'appletCfg' => 0,
    'tpl' => 0,
    'noticeList' => 0,
    'articles' => 0,
    'slide' => 0,
    'appoint' => 0,
    'goods' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df750484f48_64288596',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df750484f48_64288596')) {function content_5e4df750484f48_64288596($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
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
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="authorize-tip flex-wrap" style="margin-left: 140px">
    <div class="shop-logo">
        <img src="/public/wxapp/setup/images/weixin_pay.png" alt="logo">
    </div>
    <div class="flex-con">
        <h4>付费预约功能</h4>
        <p class="state" style="color: #999;">
          <?php if (!$_smarty_tpl->tpl_vars['dyyu']->value) {?>
            <span>付费预约需要使用微信支付功能 <a href="https://pay.weixin.qq.com" target="_blank">开通微信支付</a></span>
            <span>如果无法开启微信支付,请使用无需付费的 <a href="/wxapp/currency/appointmentList" target="_blank">咨询管理功能</a></span>
          <?php } else { ?>
            <span>付费预约需要使用支付功能 </span>
            <span>如果无法开启支付功能,请使用无需付费的 <a href="/wxapp/currency/appointmentList" target="_blank">咨询管理功能</a></span>
          <?php }?>
        </p>
    </div>
    <div>
      <?php if (!$_smarty_tpl->tpl_vars['dyyu']->value) {?>
        <a href="/wxapp/currency/payStyle" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 配置微信支付</a>
      <?php }?>
    </div>
</div>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar" data-left-preview data-id="0">
                {{headerTitle}}
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <!-- 背景图 -->
                    <div class="banner-wrap cur-edit" data-left-preview data-id="1">
                        <img src="/public/wxapp/images/banner.jpg" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>

                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="2">
                        <div class="act-box">
                            <img src="/public/wxapp/appointment/images/general_reservation_notable.png" class="noticeicon" alt="图标">
                            <div class="notice-txt">
                                <p ng-if="noticeTxt.length<=0">最新公告内容</p>
                                <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                            </div>
                        </div>
                    </div>
                    <!--新增预约简介-->
                    <div class="goods-part" data-left-preview data-id="5">
                        <div class="goods-head">
                            <span class="left" ng-model="appointTitle">{{appointTitle}}</span>
                            <div class="right">
                                查看更多
                            </div>
                        </div>
                        <div class="good" style="width:100%;height:auto;">
                            <div class="good-box">
                                {{appoint[0].title}}
                            </div>
                        </div>
                        <!--<div class="goods-bottom">
                            <span>查看全部</span>
                        </div>-->
                    </div>
                    <!--预约简介结束-->
                    <div class="goods-part" data-left-preview data-id="3">
                        <div class="goods-head">
                            <span class="left">{{goodTitle}}</span>
                            <div class="right">
                                <img src="/public/wxapp/appointment/images/general_reservation_order.png" alt="图标">
                                {{orderTitle}}
                            </div>
                        </div>
                        <div class="good" ng-repeat="good in goods">
                            <div class="good-box">
                                <img src="{{good.cover}}" alt="" class="good-cover">
                                <div class="good-name text">{{good.name}}</div>
                            </div>
                        </div>
                        <!--<div class="goods-bottom">
                            <span>查看全部</span>
                        </div>-->
                    </div>
                    <!-- 地址选择 -->
                    <div class="address-show flex-wrap" data-left-preview data-id="4">
                        <div class="contact-box">
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/appointment/images/yuyue_location.png" alt="图标">
                                <span class="label-name">地址：</span>
                                <span class="label-con flex-con" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{address}}</span>
                            </div>
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/appointment/images/yuyue_phone.png" alt="图标">
                                <span class="label-name">电话：</span>
                                <span class="label-con flex-con">{{mobile}}</span>
                            </div>
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/appointment/images/yuyue_time.png" alt="图标">
                                <span class="label-name">营业时间：</span>
                                <span class="label-con flex-con">{{openTime}}</span>
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
            <div class="header-top" data-right-edit data-id="0">
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
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="360" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-groups clearfix">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleTitle" ng-options="x.name as x.name for x in goods" ng-change="getSelectGoodId('banners',banner.index,banner.articleTitle)"></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="notice" data-right-edit data-id="5" id="noticeShow" >
            <label style="width: 100px">预约简介管理</label>

            <div class="service-manage">
                <div class="edit-txt">
                    <div class="input-groups">
                        <label for="">标　题：</label>
                        <input type="text" class="cus-input" ng-model="appointTitle">
                    </div>
                    <div class="input-groups" ng-repeat="appoint1 in appoint">
                        <label for="">简　介：</label>
                        <textarea rows="2" class="cus-input" placeholder="请输入简介"  ng-model="appoint1.title"></textarea>
                        <span style="color:red;padding-left: 70px;">"简介"为空时，小程序端将不显示此板块</span>
                    </div>
                    <div class="input-groups" ng-repeat="appoint1 in appoint">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="appoint1.articleTitle" ng-options="x.name as x.name for x in articles" ng-change="getSelectId('appoint',appoint1.index,appoint1.articleTitle)"></select>
                    </div>
                </div>
            </div>
        </div>
            <!-- 公告 -->
            <div class="notice" data-right-edit data-id="2">
                <label>最新公告</label>
                <div class="service-manage" ng-repeat="notice in noticeTxt">
                    <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="notice.title">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="notice.articleTitle" ng-options="x.name as x.name for x in articles" ng-change="getSelectId('noticeTxt',notice.index,notice.articleTitle)"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNotice()"></div>
            </div>
             <!-- 预约项目管理 -->
            <div class="notice" data-right-edit data-id="3">
                <div class="fenleinav-manage">
                    <div class="input-groups">
                        <label for="">项目标题：</label>
                        <input type="text" class="cus-input" ng-model="goodTitle">
                    </div>
                    <div class="input-groups">
                        <label for="">订单标题：</label>
                        <input type="text" class="cus-input" ng-model="orderTitle">
                    </div>
                    <div class="input-groups">
                        <label for="">预约按钮文本：</label>
                        <input type="text" class="cus-input" ng-model="buttonText" maxlength="8">
                    </div>
                    <!--
                    <div class="isOn">
                        <span>下单预约时间是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='must_time' type='checkbox' ng-model="mustTime">
                            <label class='tgl-btn' for='must_time'></label>
                        </span>
                    </div>
                    <div class="isOn">
                        <span>下单预约地址是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='must_address' type='checkbox' ng-model="mustAddress">
                            <label class='tgl-btn' for='must_address'></label>
                        </span>
                    </div>
                    <div class="no-data-tip">此处预约项目为固定链接，请到对应管理页面管理相关内容~</div>
                    -->
                </div>
            </div>
            <!-- 地址 -->
            <div class="address" data-right-edit data-id="4">
                <div class="input-group-box" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6) {?>style="display: none" <?php }?>>
                    <label class="label-name">开启信息显示：</label>
                    <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='show_address' type='checkbox' ng-model="showAddress">
                                <label class='tgl-btn' for='show_address' style="margin-right: 57%;width: 60px;"></label>
                </span>
                </div>

                <div class="input-group-box" style="margin: 10px 0;">
                    <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                        <label style="width: 75%;display: inline-block;">详细地址</label>
                        <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                            <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="lng">
                            <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="lat">
                            <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                        </div>
                    </div>
                    <input  class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="address" />
                </div>

                <div id="container" style="width: 100%;height: 300px"></div>
                <div class="input-group-box">
                    <label class="label-name">电话：</label>
                    <input type="text" class="cus-input" ng-model="mobile" placeholder="请输入联系电话">
                </div>
                <div class="input-group-box">
                    <label class="label-name">营业时间：</label>
                    <input type="text" class="cus-input" ng-model="openTime" placeholder="请输入营业时间" maxlength="12">
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
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){

        $scope.headerTitle = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_title'];?>
':"预约";
        $scope.openTime    = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_open_time'];?>
';
        $scope.mobile      = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_mobile'];?>
';
        $scope.address     = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_address'];?>
';
        $scope.showAddress = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_show_address'];?>
' > 0 ?true:false;
        $scope.goodTitle   = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_good_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_good_title'];?>
':"预约项目";
        $scope.orderTitle  = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_order_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_order_title'];?>
':"预约订单";
        $scope.lng         = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_lng'];?>
'? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_lng'];?>
' : '113.72052';
        $scope.lat         = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_lat'];?>
'? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_lat'];?>
' : '34.77485';
        $scope.noticeTxt   = <?php echo $_smarty_tpl->tpl_vars['noticeList']->value;?>
;
        $scope.articles    = <?php echo $_smarty_tpl->tpl_vars['articles']->value;?>
;
        $scope.banners     = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.mustTime    = <?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_musttime'];?>
 ? true : false ;
        $scope.mustAddress = <?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_mustaddress'];?>
 ? true : false ;
        /*新增*/
        $scope.appointTitle = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_appoint_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_appoint_title'];?>
':"预约简介";
        $scope.buttonText = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_button_text'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['aai_button_text'];?>
':"预约";
        $scope.appoint   = <?php echo $_smarty_tpl->tpl_vars['appoint']->value;?>
;
        $scope.goods = <?php echo $_smarty_tpl->tpl_vars['goods']->value;?>
;
        console.log( $scope.goods);
        console.log($scope.appoint);

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

        $scope.addNotice = function(){
            var notice_length = $scope.noticeTxt.length;
            var defaultIndex = 0;
            if(notice_length>0){
                for (var i=0;i<notice_length;i++){
                    if(defaultIndex < $scope.noticeTxt[i].index){
                        defaultIndex = $scope.noticeTxt[i].index;
                    }
                }
                defaultIndex++;
            }
            if(notice_length>=5){
                layer.msg("最多只能添加5条公告哦~");
            }else{
                var notice_Default = {
                    index: defaultIndex,
                    title: '默认公告标题',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                };
                $scope.noticeTxt.push(notice_Default);
            }
            console.log($scope.noticeTxt);
        }

        // 选择商品
        $scope.getSelectGoodId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var goods = $scope.goods;
            var curId = '';
            for(var i = 0;i < goods.length;i++){
                if(goods[i].name == title){
                    curId = goods[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
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
            for(var i = 0;i < articles.length;i++){
                if(articles[i].name == title){
                    curId = articles[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
            }
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

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.headImg = imgNowsrc;
            }
        };

        $scope.changeNav1=function(){
            if(imgNowsrc){
                $scope.nav1HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav2=function(){
            if(imgNowsrc){
                $scope.nav2HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav3=function(){
            if(imgNowsrc){
                $scope.nav3HeadImg = imgNowsrc;
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
	                'img'     : $scope.headImg,
	                'slide'   : $scope.banners,
	                'address' : $scope.address,
	                'mobile'  : $scope.mobile,
	                'openTime': $scope.openTime,
	                'notice'  : $scope.noticeTxt,
	                'lng'     : $scope.lng,
	                'lat'     : $scope.lat,
	                'goodTitle': $scope.goodTitle,
	                'orderTitle': $scope.orderTitle,
	                'buttonText': $scope.buttonText,
	                'mustTime'    : $scope.mustTime == true ? 1 : 0,
	                'mustAdress'  : $scope.mustAddress == true ? 1 : 0,
	                'showAdress'  : $scope.showAddress == true ? 1 : 0,
	                /*'appointLink' : $scope.appointLink,
	                'appointBrief': $scope.appointBrief,
	                'linkTitle'   : $scope.LinkTitle*/
	                'appoint'   : $scope.appoint,
	                'appointTitle': $scope.appointTitle
	             };
	            console.log(data);
	            $http({
	                method: 'POST',
	                url:    '/wxapp/appointment/saveAppletTpl',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
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
            //高德地图引入
            var marker, geocoder,map = new AMap.Map('container',{
                zoom            : 11,
                keyboardEnable  : true,
                resizeEnable    : true,
                topWhenClick    : true
            });
            //添加地图控件
            AMap.plugin(['AMap.ToolBar'],function(){
                var toolBar = new AMap.ToolBar();
                map.addControl(toolBar);
            });
            //首次进入默认选择位置
            addMarker($scope.lng,$scope.lat,$scope.address);

            //地图添加点击事件
            map.on('click', function(e) {
                $('#lng').val(e.lnglat.getLng());
                $('#lat').val(e.lnglat.getLat());
                //添加地图服务
                AMap.service('AMap.Geocoder',function(){
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        city: "010"//城市，默认：“全国”
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //逆地理编码
                    var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
                    geocoder.getAddress(lnglatXY, function(status, result) {
                        console.log(result);
                        if (status === 'complete' && result.info === 'OK') {
//                            //详细地址处理
//                            var township    =  result.regeocode.addressComponent.township;
//                            var street      =  result.regeocode.addressComponent.street;
//                            var streetNumber=  result.regeocode.addressComponent.streetNumber;
//                            var neighborhood=  result.regeocode.addressComponent.neighborhood;
//                            var adds = township + street + streetNumber + neighborhood;
//                            var pcz  = {
//                                'province'  : result.regeocode.addressComponent.province,
//                                'city'      : result.regeocode.addressComponent.city,
//                                'zone'      : result.regeocode.addressComponent.district,
//                                'town'      : adds
//                            };
                            addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);
                        }else{
                            //获取地址失败
                        }
                    });
                });
            });
            //搜索地图位置
            $('.btn-map-search').on('click',function(){
                var addr     = $('#addr').val();
                if($scope.address){
                    console.log($scope.address);
                    AMap.service('AMap.Geocoder',function(){ //回调函数
                        //实例化Geocoder
                        geocoder = new AMap.Geocoder({
                            'city'   : '全国', //城市，默认：“全国”
                            'radius' : 1000   //范围，默认：500
                        });
                        //TODO: 使用geocoder 对象完成相关功能
                        //地理编码,返回地理编码结果
                        geocoder.getLocation($scope.address, function(status, result) {
                            console.log(result);
                            if (status === 'complete' && result.info === 'OK') {
                                var loc_lng_lat = result.geocodes[0].location;
                                addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),$scope.address);
                            }else{
                                layer.msg('您输入的地址无法找到，请确认后再次输入');
                            }
                        });
                    });

                }else{
                    layer.msg('请填写详细地址');
                }
            });


            /**
             * 添加一个标签和一个结构体
             * @param lng
             * @param lat
             * @param address
             */
            function addMarker(lng,lat,address) {
                if (marker) {
                    marker.setMap();
                }
                marker = new AMap.Marker({
                    icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                    position: [lng,lat]
                });
                marker.setMap(map);

                infoWindow = new AMap.InfoWindow({
                    offset  : new AMap.Pixel(0,-30),
                    content : '您选中的位置：'+address
                });
                infoWindow.open(map, [lng,lat]);
                $scope.address   = address;
                $scope.lng = lng;
                $scope.lat  = lat;
                $('#details-address').val(address);
                $('#lng').val(lng);
                $('#lat').val(lat);
                console.log(address);

            }
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

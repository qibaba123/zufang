<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/style.css?3">
<style>

    .isOn {
        margin: 10px 0;
        position: relative;
        padding: 30px 0;
        border-bottom: 1px solid #eee;
        height: 120px;
    }

    .isOn .open{
        position: relative;
        top: -35px;
    }
    .isOn .tg-list-item{
        display: inline-block;
        position: relative;
        top: 10px;
    }
    .isOn .title{
        position: relative;
        top: -15px;
    }

    .isOn .title input{
        width: 200px;
        display: inline-block;
    }

    .fenleinav-manage .edit-img {
        margin-top: 20px;
    }

    .shop-wrap {
        background-color: #fff;
        padding: 10px 0;
    }

    .search-container { background-color: rgba(0, 0, 0, .6); }
    .search-container {
        border-radius: 40px;
        width: 60%;
        margin: 0 auto;
        padding: 4px 10px;
        box-sizing: border-box;
        text-align: left;
        border: 1px solid #dfdfdf;
        position: absolute;
        margin: 5px 10px;
    }
    .search-container img {
        height: 18px;
        width: 18px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }
    .search-container p {
        display: inline-block;
        vertical-align: middle;
        color: #fff;
        font-size: 14px;
    }
</style>
<{include file="../../manage/article-kind-editor.tpl"}>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="shopInfo.headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="banner-wrap" data-left-preview data-id="1">
                        <div style="box-sizing: border-box;">
                            <div class="search-container">
                                <img src="/public/wxapp/mall/temp3/images/sousuo@2x.png" />
                                <p>{{shopInfo.searchPlaceholder}}</p>
                            </div>
                        </div>
                        <img ng-src="{{shopInfo.nav1HeadImg?shopInfo.nav1HeadImg:'/public/wxapp/images/banner.jpg'}}" style="width: 100%" alt="轮播图">
                    </div>
                    <div class="shop-wrap" data-left-preview data-id="2">
                        <div class="no-data-tip" style="font-size: 20px;color: red">点此管理店铺设置</div>
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
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="shopInfo.headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1">
                <label>搜索管理</label>
                <div class="top-manage">
                    <div class="input-group-box">
                        <label class="label-name">搜索文本：</label>
                        <input type="text" class="cus-input" placeholder="请输入搜索文本" maxlength="50" ng-model="shopInfo.searchPlaceholder">
                    </div>
                </div>
                <label>图片管理</label>
                <div class="banner-manage">
                    <div>
                        <label for="">顶部图片：</label>
                        <div class="headImg-manage"  style="height:100%;width: 100%">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav1()" data-dom-id="upload-nav1HeadImg" id="upload-nav1HeadImg"  ng-src="{{shopInfo.nav1HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav1HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav1HeadImg"  class="avatar-field bg-img" name="nav1HeadImg" ng-value="shopInfo.nav1HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="address" data-right-edit data-id="2">
                <div class="shops-name">店铺设置</div>
                <div class="input-group-box">
                    <label class="label-name">营业时间：</label>
                    <input type="text" class="cus-input time" ng-model="shopInfo.openStartTime" style="width: 40%" onchange="" >
                    <input type="text" class="cus-input time" ng-model="shopInfo.openEndTime" style="width: 40%" onchange="" >
                </div>
                <div class="input-group-box">
                    <label class="label-name">联系商家：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.phone" placeholder="请输入联系电话">
                </div>
                <div class="input-group-box">
                    <label class="label-name">人均消费：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.spend" placeholder="人均消费">
                </div>
                <div class="input-group-box">
                    <label class="label-name">最低起送金额：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.limit" placeholder="满多少元起送">
                </div>
                <div class="input-group-box">
                    <label class="label-name">配送费：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.postFee" placeholder="配送费">
                </div>
                <div class="input-group-box">
                    <label class="label-name">配送范围(公里)：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.postRange" placeholder="多少公里内配送">
                </div>
                <div class="input-group-box">
                    <label class="label-name">平均送达时间(分钟)：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.avgSendTime" placeholder="平均送达时间">
                </div>
                <div class="input-group-box">
                    <label class="label-name">餐具费（单位：每人，0表示免费）：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.tablewareFee" placeholder="请输入餐具费用">
                </div>
                <div class="input-group-box">
                    <label class="label-name">现金支付预支付金额（为防止恶意下单现金支付的订单需预支一部分费用）：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.paymentMoney" placeholder="请输入预付金额">
                </div>
                <!--
                <div class="input-group-box">
                    <div class="open">
                        <span>允许用户选择餐桌：</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='choose_table' type='checkbox'  <{if $tpl && $tpl['ami_choose_on'] == 1}>checked<{/if}>>
                        <label class='tgl-btn' for='choose_table'></label>
                        </span>
                        </div>
                </div>-->
                <label>商家地址</label>
                <div class="fenleinav-manage" style="padding-top: 10px;">
                    <div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                            <label style="width: 75%;display: inline-block;">详细地址</label>
                            <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="shopInfo.longitude">
                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="shopInfo.latitude">
                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                            </div>
                        </div>
                        <textarea rows="3" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="shopInfo.address"></textarea>
                    </div>

                    <div id="container" style="width: 100%;height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.shopInfo = {
            headerTitle: '<{$tpl['ami_title']}>'?'<{$tpl['ami_title']}>':"微点餐",
            searchPlaceholder: '<{$tpl['ami_search_holder']}>'?'<{$tpl['ami_search_holder']}>':"请输入关键字",
            recommendMore:"<{$tpl['ami_recommend_more']}>",
            headImg:"<{$tpl['ami_head_img']}>",
            openStartTime:'<{$tpl['ami_open_time'][0]}>',
            openEndTime:'<{$tpl['ami_open_time'][1]}>',
            spend: '<{$tpl['ami_average_spend']}>'?'<{$tpl['ami_average_spend']}>':0,
            shopLabel1: '<{$tpl['ami_label'][0]}>'?'<{$tpl['ami_label'][0]}>':'标签一',
            shopLabel2: '<{$tpl['ami_label'][1]}>'?'<{$tpl['ami_label'][1]}>':'标签二',
            shopLabel3: '<{$tpl['ami_label'][2]}>'?'<{$tpl['ami_label'][2]}>':'标签三',
            phone:'<{$tpl['ami_phone']}>',
            limit:'<{$tpl['ami_post_limit']}>',
            address:'<{$tpl['ami_address']}>',
            longitude:'<{$tpl['ami_lng']}>',
            latitude:'<{$tpl['ami_lat']}>',
            nav1HeadImg:'<{$tpl['ami_nav1_head_img']}>',
            nav2HeadImg:'<{$tpl['ami_nav2_head_img']}>',
            nav3HeadImg:'<{$tpl['ami_nav3_head_img']}>',
            postFee: '<{$tpl['ami_post_fee']}>'?'<{$tpl['ami_post_fee']}>':0,
            postRange: '<{$tpl['ami_post_range']}>'?'<{$tpl['ami_post_range']}>':0,
            avgSendTime: '<{$tpl['ami_avg_send_time']}>'?'<{$tpl['ami_avg_send_time']}>':0,
            paymentMoney: '<{$tpl['ami_payment_money']}>'?'<{$tpl['ami_payment_money']}>':0,
            tablewareFee: '<{$tpl['ami_tableware_fee']}>'?'<{$tpl['ami_tableware_fee']}>':0,
            logoShow : '<{$tpl['ami_logo_show']}>',
            // 是否开启外卖和堂食及预约
            outOn: '<{$tpl['ami_out_on']}>' > 0 ? true : false ,
            eatOn: '<{$tpl['ami_eat_on']}>' > 0 ? true : false ,
            appOn: '<{$tpl['ami_appo_on']}>' > 0 ? true : false ,
            // 是否开启外卖和堂食及预约
            outImg:'<{$tpl['ami_out_img']}>' ? '<{$tpl['ami_out_img']}>' : '/public/wxapp/meal/images/out_img.png' ,
            eatImg:'<{$tpl['ami_eat_img']}>' ? '<{$tpl['ami_eat_img']}>' : '/public/wxapp/meal/images/eat_img.png' ,
            appImg:'<{$tpl['ami_appo_img']}>' ? '<{$tpl['ami_appo_img']}>' : '/public/wxapp/meal/images/app_img.png'
        };

        $scope.activityList = <{$activityList}>;
        $scope.banners     = <{$slide}>;
        $scope.environmentList = <{$environmentList}>;
        $scope.recommendList = <{$recommendList}>;
        $scope.labelList = <{$labelList}>;
        $scope.navList = <{$navList}>;

        console.log($scope.navList);

        $scope.tpl_id      = 67;

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

        /*添加店铺环境方法*/
        $scope.addEnvironment = function(){
            var environmentList_length = $scope.environmentList.length;
            var defaultIndex = 0;
            if(environmentList_length>0){
                for (var i=0;i<environmentList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.environmentList[i].index)){
                        defaultIndex = parseInt($scope.environmentList[i].index);
                    }
                }
                defaultIndex++;
            }
            var environmentList_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/zw_fxb_200_200.png'
            };
            $scope.environmentList.push(environmentList_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
        };

        $scope.addLabel= function(){
            var labelList_length = $scope.labelList.length;
            var defaultIndex = 0;
            if(labelList_length>0){
                for (var i=0;i<labelList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.labelList[i].index)){
                        defaultIndex = parseInt($scope.labelList[i].index);
                    }
                }
                defaultIndex++;
            }
            if(labelList_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个标签',
                    time: 2000
                });
            }else{
                var labelList_Default = {
                    index: defaultIndex,
                    title: '标签'
                };;
                $scope.labelList.push(labelList_Default);
            }
        }

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
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_30.png',
                    link: 'http://www.fenxiaobao.xin/manage/index/index',
                    articleTitle:'',
                    articleId:0
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

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.shopInfo.headImg = imgNowsrc;
            }
        };

        $scope.changeNav1=function(){
            if(imgNowsrc){
                $scope.shopInfo.nav1HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav2=function(){
            if(imgNowsrc){
                $scope.shopInfo.nav2HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav3=function(){
            if(imgNowsrc){
                $scope.shopInfo.nav3HeadImg = imgNowsrc;
            }
        };
        // 外卖图标
        $scope.changeOutImg=function(){
            if(imgNowsrc){
                $scope.shopInfo.outImg = imgNowsrc;
            }
        };
        // 堂食图标
        $scope.changeEatImg=function(){
            if(imgNowsrc){
                $scope.shopInfo.eatImg = imgNowsrc;
            }
        };
        // 预约图标
        $scope.changeAppImg=function(){
            if(imgNowsrc){
                $scope.shopInfo.appImg = imgNowsrc;
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

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var chooseTable = $('#choose_table').is(':checked');
            var data = {
                'tpl_id'	 : $scope.tpl_id,
                'shopInfo'    : $scope.shopInfo,
            };
            console.log($scope.shopInfo);
            $http({
                method: 'POST',
                url:    '/wxapp/meal/saveAppletTpl',
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
            addMarker($scope.shopInfo.longitude,$scope.shopInfo.latitude,$scope.shopInfo.address);

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
                if($scope.shopInfo.address){
                    console.log($scope.shopInfo.address);
                    AMap.service('AMap.Geocoder',function(){ //回调函数
                        //实例化Geocoder
                        geocoder = new AMap.Geocoder({
                            'city'   : '全国', //城市，默认：“全国”
                            'radius' : 1000   //范围，默认：500
                        });
                        //TODO: 使用geocoder 对象完成相关功能
                        //地理编码,返回地理编码结果
                        geocoder.getLocation($scope.shopInfo.address, function(status, result) {
                            console.log(result);
                            if (status === 'complete' && result.info === 'OK') {
                                var loc_lng_lat = result.geocodes[0].location;
                                addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),$scope.shopInfo.address);
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
                $('#details-address').val(address);
                $('#lng').val(lng);
                $('#lat').val(lat);
                $scope.shopInfo.address   = address;
                $scope.shopInfo.longitude = lng;
                $scope.shopInfo.latitude  = lat;
                console.log($scope.shopInfo.address);

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

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>
<{include file="../img-upload-modal.tpl"}>
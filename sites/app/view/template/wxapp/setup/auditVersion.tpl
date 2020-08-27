<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp1/css/index.css?5">
<link rel="stylesheet" href="/public/wxapp/index/temp1/css/style.css?1">
<style>
    .article-con img{
        width: 100%;
    }
    .contact-box{
        padding: 10px;
    }
    .article-con{
        min-height: 300px;
        background-color: white;
        padding: 10px;
    }
    .edit-right .edit-con{margin-top: 0;}
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <{include file="../article-kind-editor.tpl"}>
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/wxapp/mall/temp3/images/banner_750_400.jpg" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="pagination">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>

                    <div class="shops-contact" data-left-preview data-id="3">
                        <div class="contact-box">
                            <div class="contact-item flex-wrap">
                                <span class="label-name">名称：</span>
                                <span class="label-con flex-con">{{shopName}}</span>
                            </div>
                            <div class="contact-item flex-wrap">
                                <span class="label-name">地址：</span>
                                <span class="label-con flex-con">{{address}}</span>
                            </div>
                            <div class="contact-item flex-wrap">
                                <span class="label-name">电话：</span>
                                <span class="label-con flex-con">{{mobile}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="article-con" id="article-con" data-left-preview data-id="4" >
                        <{if $tpl && $tpl['asp_content']}>

                        <{else}>
                        <p>这里将会显示图文内容</p>
                        <{/if}>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con" style="margin-bottom: 20px;margin-top: 50px">
            <div class="activity link-setting" style="display:block;">
                <span class='tg-list-item' style="font-size: 16px;font-weight: bold;">
						是否启用审核过渡版
                     <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus()" <{if $tpl && $tpl['asp_audit'] == 1}>checked<{/if}> >
                     <label class='tgl-btn' for='audit_status'></label>
                </span>
                <span class='tg-list-item' style="font-size: 16px;">
						审核过渡版外链
                     <input id='audit_web_url' type='text' ng-model="auditWebUrl">
                </span>
            </div>
            <!--
            <div class="color-set-box" style="margin-bottom: 30px;display:block;">
                <label class="label-name" style="font-size: 16px;font-weight: bold;">启用版本：</label>
                <div class="right-color">
                    <div class="radio-box" style="width: 80%;float: left;">
					    	<span ng-click="changeEnabledVersion($event)">
					    		<input type="radio" name="enabledVersion" id="formal" data-show="1" ng-checked="enabledVersion=='1'">
					    		<label for="formal">线上正式版本</label>
					    	</span>
                            <span ng-click="changeEnabledVersion($event)">
					    		<input type="radio" name="enabledVersion" id="examine" data-show="2" ng-checked="enabledVersion=='2'">
					    		<label for="examine">正在审核版本</label>
					    	</span>
                    </div>
                </div>
            </div>
            -->
        </div>
        <div class="edit-con jianzheng-manage">
            <div class="header-top" data-right-edit data-id="0" style="display:block;">
                <label>顶部管理</label>
                <div class="top-manage">
                    <div class="input-group">
                        <label for="">页面标题</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="12" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label>幻灯管理<span>（建议尺寸750*400）</span></label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="enterpriseIntro" data-right-edit data-id="3">
                <label>联系地址</label>
                <div class="top-manage">
                    <div class="input-group-box">
                        <label class="label-name">名称：</label>
                        <input type="text" class="cus-input" ng-model="shopName" placeholder="请输入页面标题" maxlength="15">
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">电话：</label>
                        <input type="text" class="cus-input" ng-model="mobile" placeholder="请输入咨询电话">
                    </div>
                    <div class="input-groups" style="margin: 10px 0;">
                        <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                            <label style="width: 75%;display: inline-block;">详细地址</label>
                            <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="longitude">
                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="latitude">
                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                            </div>
                        </div>
                        <input type="text" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="address" />
                    </div>

                    <div id="container" style="width: 100%;height: 300px"></div>
                </div>
            </div>
            <div class="contxt" data-right-edit data-id="4">
                <div>
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:450px;visibility:hidden;" id="article-detail" name="article-detail1" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['asp_content']}><{$tpl['asp_content']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-detail1" />
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
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
    var enabledVersion = <{$tpl['asp_audio_version']}>;
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle= '<{$tpl['asp_head_title']}>';
        $scope.auditWebUrl= '<{$tpl['asp_audit_web_url']}>';
        $scope.shopName = '<{$tpl['asp_name']}>';
        $scope.mobile= '<{$tpl['asp_mobile']}>';
        $scope.banners =  <{$slide}>;
        $scope.address = '<{$tpl['asp_address']}>' ? '<{$tpl['asp_address']}>' : '郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室';
        $scope.longitude = '<{$tpl['asp_lng']}>' ? '<{$tpl['asp_lng']}>' : '113.72052';
        $scope.latitude = '<{$tpl['asp_lat']}>' ? '<{$tpl['asp_lat']}>' : '34.77485';
        $scope.tpl_id	= '<{$tpl['asp_tpl_id']}>';
        $scope.enabledVersion = <{$tpl['asp_audio_version']}>;

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
                        $scope.addressStyle.color=realColor;
                        console.log($scope.addressStyle.color);
                    });
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        };



        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            $scope[type][realIndex].imgsrc = imgNowsrc;
            //console.log($scope[type][realIndex]);
        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.coopera.imgsrc = imgNowsrc;
            }
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
            if(banner_length>8){
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
                    imgsrc: '/public/wxapp/mall/temp3/images/banner_750_400.jpg',
                    link: '',
                    articleId: "",
                    articleTitle: ""
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
                $scope.$apply(function(){
                    $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');
//                if($scope[type].length>1){
//                    $scope.$apply(function(){
//                        $scope[type].splice(realIndex,1);
//                    });
//                    layer.msg('删除成功');
//                }else{
//                    layer.msg('最少要留一个哦');
//                }
            });
        };

        $scope.changeEnabledVersion=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var value = that.data('show');
            that.get(0).checked = true;
            $scope.enabledVersion = value;
            enabledVersion = value;
            console.log($scope.enabledVersion);
            console.log(enabledVersion);
        };

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            console.log(weddingTaocanDetailArray);
            $scope.content = weddingTaocanDetailArray[1];

            var data = {
                'title' 	 : $scope.headerTitle,
                'name'       : $scope.shopName,
                'slide'		 : $scope.banners,
                'tpl_id'	 : $scope.tpl_id,
                'mobile'     : $scope.mobile,
                'address'    : $scope.address,
                'longitude'  : $scope.longitude,
                'latitude'   : $scope.latitude,
                'content'    : $scope.content,
                'enabledVersion' : $scope.enabledVersion,
                'webUrl'     : $scope.auditWebUrl
            };
            console.log(data);

            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveAuditVersion',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };


        $(function(){
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
            addMarker($scope.longitude,$scope.latitude,$scope.address);

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
                $scope.longitude = lng;
                $scope.latitude  = lat;
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
    /**
     启用审核版本
     */
    function changeAuditStatus() {
        var status = $('#audit_status').is(':checked');
        var data = {
            status : status ? 1 : 0,
            enabledVersion : enabledVersion
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/setup/changeAuditStatus',
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
<{include file="../img-upload-modal.tpl"}>
<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css">
<style>
    .fenlei-nav{
        background: #fff;
        margin-bottom: 10px;
    }
    .fenlei-nav li{
        width: 25%;
        padding: 8px 10px;
        text-align: center;
        display: inline-block;
        font-size: 12px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .fenlei-nav img{
        width: 35px;
    }

    .fenlei-nav-manage li{
        width: 25%;
        padding: 8px 10px;
        text-align: center;
        display: inline-block;
        font-size: 12px;
    }

    .fenlei-nav-manage img{
        width: 60%;
        margin-bottom: 5px;
    }
    .fenlei-nav-manage .tgl-btn{
        margin: 5px auto;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" style="padding-bottom: 60px;">
    <!--
    <div class="page-header">
        <div class="input-group">
            <div class="input-group-addon"> 会 &nbsp; 员 &nbsp; 中 &nbsp; 心 : </div>
            <input type="text" class="form-control" id="user_center" value="<{if $row}><{$row['center']}><{/if}>" placeholder="" readonly style="height:35px;">
            <a class="input-group-addon copy_input" data-clipboard-target="user_center">复制</a>
        </div>
    </div>
    -->
    <!-- /.page-header -->
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" ng-bind="centerInfo.headerTitle">
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="mobile-content">
                        <div class="member-info" ng-style="{'background-image':'url('+centerInfo.bgSrc+')'}">
                            <div class="base-info">
                                <div class="left-touxiang"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" ng-style="{'color':centerInfo.txtColor}">
                                    <p>会员昵称</p>
                                    <p>会员ID：18</p>
                                    <!--<p>会员等级：无</p>-->
                                </div>
                            </div>
                        </div>
                        <!-- 分类导航 -->
                        <div class="fenlei-nav" >
                            <ul class="border-t border-b" style="white-space: normal;">
                                <li ng-if="nav.open" ng-repeat="nav in navList">
                                    <img ng-src="{{nav.imgsrc}}" width="100%" height="100%"  alt="图标">
                                    <span>{{nav.title}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="order-info flex-wrap border-b">
                            <a href="#" class="orderstate1 flex-con">全部订单<span>0</span></a>
                            <a href="#" class="orderstate2 flex-con">待付款<span>0</span></a>
                            <a href="#" class="orderstate3 flex-con">已发货<span>0</span></a>
                            <a href="#" class="orderstate4 flex-con">退换货<span>0</span></a>
                        </div>
                        <!--
                        <a href="#" class="ad-img" ng-hide="centerInfo.adImg.adshow==0"><img ng-src="{{centerInfo.adImg.imgSrc}}" alt="banner广告"></a>
                        -->

                        <ul class="user-operation">
                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.mycj.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.mycj.name}}<span></span></a></li>
                            -->
                            <{if $appletCfg['ac_type'] eq 21}>
                            <li class="border-b" ng-hide="centerInfo.showlist.mypt.isShow==0"><a href="#" class="icon15">{{centerInfo.showlist.mypt.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myfx.isShow==0"><a href="#" class="icon1">{{centerInfo.showlist.myfx.name}}<span></span></a></li>
                            <{/if}>
                            <li class="border-b" ng-hide="centerInfo.showlist.myact.isShow==0"><a href="#" class="icon3">{{centerInfo.showlist.myact.name}}<span></span></a></li>

                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.myjf.isShow==0"><a href="#" class="icon3">{{centerInfo.showlist.myjf.name}}<span></span></a></li>
                            -->
                            <li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon2">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>
                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.mywith.isShow==0"><a href="#" class="icon4">{{centerInfo.showlist.mywith.name}}<span></span></a></li>
                            -->
                        </ul>
                        <ul class="user-operation">
                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.myinfo.isShow==0"><a href="#" class="icon8">{{centerInfo.showlist.myinfo.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myphone.isShow==0"><a href="#" class="icon12">{{centerInfo.showlist.myphone.name}}<span></span></a></li>
                            -->
                            <li class="border-b" ng-hide="centerInfo.showlist.myaddr.isShow==0"><a href="#" class="icon9">{{centerInfo.showlist.myaddr.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mycart.isShow==0"><a href="#" class="icon14">{{centerInfo.showlist.mycart.name}}<span></span></a></li>
                        </ul>
                        <!--
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.appletad.isShow==0"><a href="#" class="icon_applet_black">{{centerInfo.showlist.appletad.name}}<span></span></a></li>
                        </ul>
                        -->
                        <!--
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.region.isShow==0"><a href="#" class="icon17">{{centerInfo.showlist.region.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.partner.isShow==0"><a href="#" class="icon13">{{centerInfo.showlist.partner.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myvip.isShow==0"><a href="#" class="icon10">{{centerInfo.showlist.myvip.name}}<span></span></a></li>
                        </ul>
                        -->
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con">
            <div class="header-top" data-right-edit data-id="0" style="display:block;">
                <div class="top-manage">
                    <div class="input-groups">
                        <label for="">页面名称</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="centerInfo.headerTitle">
                    </div>
                    <div class="input-groups">
                        <label for="">信息文字颜色</label>
                        <input type="text" placeholder="请输入页面标题" id="txtColor">
                    </div>
                    <div class="input-groups">
                        <label for="">信息背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="272" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}"  imageonload="changeTopBg()" id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*272</p>
                            <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" />
                        </div>
                    </div>
                </div>
                <div class="top-manage">
                    <div class="fenlei-nav-manage" >
                        <ul style="white-space: normal;">
                            <li ng-repeat="nav in navList">
                                <div class="edit-img">
                                    <div style="height:100%;">
                                        <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',nav.index)" data-dom-id="upload-navList{{$index}}" id="upload-navList{{$index}}"  ng-src="{{nav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="navList{{$index}}"  class="avatar-field bg-img" name="navList{{$index}}" ng-value="nav.imgsrc"/>
                                    </div>
                                </div>
                                <input type="text" ng-model="nav.title" class="form-control"/>
                                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='navList{{$index}}_start' type='checkbox' ng-model="nav.open">
                                <label class='tgl-btn' for='navList{{$index}}_start'></label>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--
                <div class="ad-manage">
                    <div class="input-groups">
                        <label for="">广告图片</label>
                        <div class="topinfo" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="272" data-dom-id="ad-img">
                            <img ng-src="{{centerInfo.adImg.imgSrc}}"  imageonload="changeAdImg()" id="ad-img" alt="背景图片">
                            <span>修改广告图</span>
                            <p>建议尺寸：750*272</p>
                        </div>
                    </div>
                    <div class="input-groups">
                        <label for="">广告图片链接</label>
                        <input type="text" ng-model="centerInfo.adImg.link">
                    </div>
                    <div class="check-row">
                        <span style="text-align:left">是否显示</span>
                        <div class="check-box">
                            <input type="checkbox" id="adimg" data-id="adshow" ng-checked="centerInfo.adImg.adshow==1" ng-click="adshowChecked($event)">
                            <label for="adimg">显示</label>
                        </div>
                    </div>
                </div>
                -->
                <div class="showlist-manage">
                    <!--
                    <div class="check-row">
                        <span>我的抽奖团</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmycj" data-id="mycj" ng-checked="centerInfo.showlist.mycj.isShow==1" ng-click="checked($event)">
                                <label for="showmycj">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycj.name"></p>
                        </div>
                    </div>
                    -->
                    <{if $appletCfg['ac_type'] eq 21}>
                    <div class="check-row">
                        <span>我的拼团</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmypt" data-id="mypt" ng-checked="centerInfo.showlist.mypt.isShow==1" ng-click="checked($event)">
                                <label for="showmypt">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mypt.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>分销中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist1" data-id="myfx" ng-checked="centerInfo.showlist.myfx.isShow==1" ng-click="checked($event)">
                                <label for="showlist1">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myfx.name"></p>
                        </div>
                    </div>
                    <{/if}>
                    <div class="check-row">
                        <span>我的钱包</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist2" data-id="myact" ng-checked="centerInfo.showlist.myact.isShow==1" ng-click="checked($event)">
                                <label for="showlist2">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myact.name"></p>
                        </div>
                    </div>
                    <!--
                    <div class="check-row">
                        <span>我的积分</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyjf" data-id="myjf" ng-checked="centerInfo.showlist.myjf.isShow==1" ng-click="checked($event)">
                                <label for="showmyjf">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myjf.name"></p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>我的优惠券</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlistcoupon" data-id="myyhq" ng-checked="centerInfo.showlist.myyhq.isShow==1" ng-click="checked($event)">
                                <label for="showlistcoupon">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myyhq.name"></p>
                        </div>
                    </div>
                    <!--
                    <div class="check-row">
                        <span>收益提现</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist3" data-id="mywith" ng-checked="centerInfo.showlist.mywith.isShow==1" ng-click="checked($event)">
                                <label for="showlist3">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mywith.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>修改资料</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist4" data-id="myinfo" ng-checked="centerInfo.showlist.myinfo.isShow==1" ng-click="checked($event)">
                                <label for="showlist4">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myinfo.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的手机号</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist5" data-id="myphone" ng-checked="centerInfo.showlist.myphone.isShow==1" ng-click="checked($event)">
                                <label for="showlist5">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myphone.name"></p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>地址管理</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist6" data-id="myaddr" ng-checked="centerInfo.showlist.myaddr.isShow==1" ng-click="checked($event)">
                                <label for="showlist6">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myaddr.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的购物车</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="mycart" data-id="mycart" ng-checked="centerInfo.showlist.mycart.isShow==1" ng-click="checked($event)">
                                <label for="mycart">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycart.name"></p>
                        </div>
                    </div>
                    <!--
                    <div class="check-row">
                        <span>小程序咨询</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="appletad" data-id="appletad" ng-checked="centerInfo.showlist.appletad.isShow==1" ng-click="checked($event)">
                                <label for="appletad">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.appletad.name"></p>
                        </div>
                    </div>
                    -->
                    <!--
                    <div class="check-row">
                        <span>区域代理商</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="region" data-id="region" ng-checked="centerInfo.showlist.region.isShow==1" ng-click="checked($event)">
                                <label for="region">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.region.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>招募合伙人</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlistpartner" data-id="partner" ng-checked="centerInfo.showlist.partner.isShow==1" ng-click="checked($event)">
                                <label for="showlistpartner">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.partner.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>特级会员</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist7" data-id="myvip" ng-checked="centerInfo.showlist.myvip.isShow==1" ng-click="checked($event)">
                                <label for="showlist7">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myvip.name"></p>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning setting-save" role="alert" ><button class="btn btn-primary btn-sm" ng-click="saveCenter();">保存</button></div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/manage/centermanage/color-spectrum/spectrum.js"></script>
<script type="text/javascript" src="/public/manage/centermanage/js/angular-1.4.6.min.js"></script>
<script type="text/javascript" src="/public/manage/centermanage/js/angular-root.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
    } );

    var imgNowsrc='';
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                imgNowsrc = allSrc[0];
            }
        }
    }
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',  ['$scope', '$http', function($scope, $http){
        $scope.navList = <{$row['ct_nav_list']}>;
        $scope.centerInfo = {
            headerTitle:"<{$row['ct_center_title']}>",
            txtColor:"<{$row['ct_center_color']}>",
            bgSrc:"<{$row['ct_center_bg']}>",
            adImg:{
                imgSrc:"<{$row['ct_advert_img']}>",
                link:"<{$row['ct_advert_link']}>",
                adshow:<{$row['ct_advert_show']}>
        },
            showlist:{
            mypt :{
                isShow : <{$row['ct_mypt_show']}>,
                name: "<{if $row['ct_mypt_name']}><{$row['ct_mypt_name']}><{else}>我的拼团<{/if}>"
            },
            mycj :{
                isShow : <{$row['ct_mycj_show']}>,
                name: "<{if $row['ct_mycj_name']}><{$row['ct_mycj_name']}><{else}>我的抽奖团<{/if}>"
            },
            myfx :{
                isShow : <{$row['ct_myfx_show']}>,
                name: "<{if $row['ct_myfx_name']}><{$row['ct_myfx_name']}><{else}>分销中心<{/if}>"
            },
            myact : {
                isShow : <{$row['ct_myact_show']}>,
                name : "<{if $row['ct_myact_name']}><{$row['ct_myact_name']}><{else}>账户充值<{/if}>"
            },
            myjf : {
                isShow : <{$row['ct_myjf_show']}>,
                name : "<{if $row['ct_myjf_name']}><{$row['ct_myjf_name']}><{else}>我的积分<{/if}>"
            },
            myyhq : {
                isShow : <{$row['ct_myyhq_show']}>,
                name : "<{if $row['ct_myyhq_name']}><{$row['ct_myyhq_name']}><{else}>我的优惠券<{/if}>"
            },
            mywith : {
                isShow : <{$row['ct_mywith_show']}>,
                name : "<{if $row['ct_mywith_name']}><{$row['ct_mywith_name']}><{else}>余额提现<{/if}>"
            },
            myinfo : {
                isShow : <{$row['ct_myinfo_show']}>,
                name : "<{if $row['ct_myinfo_name']}><{$row['ct_myinfo_name']}><{else}>修改资料<{/if}>"
            },
            myphone : {
                isShow : <{$row['ct_myphone_show']}>,
                name : "<{if $row['ct_myphone_name']}><{$row['ct_myphone_name']}><{else}>我的手机号<{/if}>"
            },
            myaddr : {
                isShow : <{$row['ct_myaddr_show']}>,
                name : "<{if $row['ct_myaddr_name']}><{$row['ct_myaddr_name']}><{else}>收货地址<{/if}>"
            },
            mycart : {
                isShow : <{$row['ct_mycart_show']}>,
                name : "<{if $row['ct_mycart_name']}><{$row['ct_mycart_name']}><{else}>购物车<{/if}>"
            },
            region:{
                isShow : <{$row['ct_region_show']}>,
                name : "<{if $row['ct_region_name']}><{$row['ct_region_name']}><{else}>区域代理商<{/if}>"
            },
            partner:{
                isShow : <{$row['ct_partner_show']}>,
                name : "<{if $row['ct_partner_name']}><{$row['ct_partner_name']}><{else}>招募合伙人<{/if}>"
            },
            myvip : {
                isShow : <{$row['ct_myvip_show']}>,
                name : "<{if $row['ct_myvip_name']}><{$row['ct_myvip_name']}><{else}>特级会员<{/if}>"
            },
            appletad : {
                isShow : <{$row['ct_appletad_show']}>,
                name : "<{if $row['ct_appletad_name']}><{$row['ct_appletad_name']}><{else}>我也要做小程序<{/if}>"
            },

        }
    };
        $scope.adshowChecked = function($event){
            var curElem = $($event.target);
            var isChecked = curElem.is(":checked");
            var dataId = curElem.data('id');
            if(isChecked){
                $scope.centerInfo.adImg[dataId] = 1;
            }else{
                $scope.centerInfo.adImg[dataId] = 0;
            }
        };
        $scope.checked = function($event){
            var curElem = $($event.target);
            var isChecked = curElem.is(":checked");
            var dataId = curElem.data('id');
            if(isChecked){
                $scope.centerInfo.showlist[dataId].isShow = 1;
            }else{
                $scope.centerInfo.showlist[dataId].isShow = 0;
            }

        };
        $scope.changeTopBg=function(){
            if(imgNowsrc){
                $scope.centerInfo.bgSrc = imgNowsrc;
            }
        };
        $scope.changeAdImg=function(){
            if(imgNowsrc){
                $scope.centerInfo.adImg.imgSrc = imgNowsrc;
            }
        };

        $scope.saveCenter = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title'         : $scope.centerInfo.headerTitle,
                'color'         : $scope.centerInfo.txtColor,
                'bg'            : $scope.centerInfo.bgSrc,
                'ad_link'       : $scope.centerInfo.adImg.link,
                'ad_img'        : $scope.centerInfo.adImg.imgSrc,
                'advert'        : $scope.centerInfo.adImg.adshow,
                'list'          : $scope.centerInfo.showlist,
                'navList'       :$scope.navList
            };



            $http({
                method: 'POST',
                url:    '/wxapp/member/saveCenter',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $("#txtColor").spectrum({
                color: "<{$row['ct_center_color']}>",
                showButtons: false,
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxPaletteSize: 10,
                preferredFormat: "hex",
                move: function (color) {
                    var realColor = color.toHexString();
                    $scope.centerInfo.txtColor = realColor;
                    changeTxtcolor(realColor);
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        });
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
    /*改变文字颜色*/
    function changeTxtcolor(color){
        $(".base-info .user-name").css("color",color);
    }

</script>
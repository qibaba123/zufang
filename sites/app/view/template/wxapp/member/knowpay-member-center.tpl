<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css?1">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css">
<style>
.fenlei-nav { background: #fff; margin-bottom: 5px; }
.fenlei-nav li { width: 33.3%; padding: 8px 10px; text-align: center; display: inline-block; font-size: 12px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.fenlei-nav img { width: 35px; }
.fenlei-nav-manage li { width: 33.3%; padding: 8px 10px; text-align: center; display: inline-block; font-size: 12px; }
.fenlei-nav-manage img { width: 60%; margin-bottom: 5px; }
.fenlei-nav-manage .tgl-btn { margin: 5px auto; }
.user-operation{margin-bottom: 5px;}
.base-info .user-name p:first-child{font-size: 15px;font-weight: normal;}
.base-info .user-name p.grade{font-size: 12px;color: rgba(255, 255, 255, 0.7);padding-left: 15px;background: url(/public/mobile/center/images/mine/two/icon_huiyuan.png) no-repeat left center;background-size: 12px; }
.user-operation>li a{font-size: 14px;}
.numshow-box{background-color: #fff;border-radius: 6px 6px 0 0;margin-top: -5px;align-items: center;position: relative;margin-bottom: 5px;}
.numshow-box .num-item{text-align: center;padding: 10px 0;}
.numshow-box .num-item.border-r::after{top: 18px;bottom: 18px;}
.numshow-box .num-item.border-r:last-child::after{height: 0;}
.numshow-box .num-item .num{font-size: 17px;}
.numshow-box .num-item .text{font-size: 13px;}
.new-fenlei-nav ul{font-size: 0;}
.new-fenlei-nav ul li{width: 25%;box-sizing: border-box;}
.new-fenlei-nav li img{width: 24px;}
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
            <!--<div class="title-bar cur-edit" ng-bind="centerInfo.headerTitle">
            </div>-->
            <div class="title-bar cur-edit">
                个人中心
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="mobile-content">
                        <div class="member-info" style="background: #333;">
                            <div class="base-info flex-wrap" style="align-items: center;">
                                <div class="left-touxiang"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name flex-con"><!--ng-style="{'color':centerInfo.txtColor}"-->
                                    <p>会员昵称</p>
                                    <!--<p>会员ID：18</p>-->
                                    <p>会员等级</p>
                                </div>
                            </div>
                        </div>
                        <div class="numshow-box flex-wrap" style="display: none;">
                            <div class="num-item flex-con border-r">
                              <div class="num">20</div>
                              <div class="text">我的账户</div>
                            </div>
                            <div class="num-item flex-con border-r">
                              <div class="num">20</div>
                              <div class="text">我的订阅</div>
                            </div>
                            <div class="num-item flex-con border-r">
                              <div class="num">20</div>
                              <div class="text">优惠券</div>
                            </div>
                            <div class="num-item flex-con border-r">
                              <div class="num">20</div>
                              <div class="text">积分商城</div>
                            </div>
                        </div>
                        <!-- 分类导航 -->
                        <div class="fenlei-nav new-fenlei-nav" style="display: none;">
                            <ul class="border-t border-b" style="white-space: normal;">
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_huyuanzx.png" width="100%" height="100%"  alt="图标">
                                    <span>我的会员</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_dhm.png" width="100%" height="100%"  alt="图标">
                                    <span>兑换码</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_ruzhu.png" width="100%" height="100%"  alt="图标">
                                    <span>讲师管理中心</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_jf.png" width="100%" height="100%"  alt="图标">
                                    <span>积分商城</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_fx.png" width="100%" height="100%"  alt="图标">
                                    <span>分销中心</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_dy.png" width="100%" height="100%"  alt="图标">
                                    <span>我的订阅</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_tz.png" width="100%" height="100%"  alt="图标">
                                    <span>我的发帖</span>
                                </li>
                                <li>
                                    <img src="/public/mobile/center/images/mine/two/icon_pl.png" width="100%" height="100%"  alt="图标">
                                    <span>我的评论</span>
                                </li>
                            </ul>
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

                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.mycard.isShow==0"><a href="#" class="icon18" style="background-image: url(/public/mobile/center/images/mine/two/icon_huyuanzx.png);">{{centerInfo.showlist.mycard.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myyqm.isShow==0"><a href="#" class="icon39" style="background-image: url(/public/mobile/center/images/mine/two/icon_dhm.png);">{{centerInfo.showlist.myyqm.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myfx.isShow==0"><a href="#" class="icon19" style="background-image: url(/public/mobile/center/images/mine/two/icon_fx.png);">{{centerInfo.showlist.myfx.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mymalldd.isShow==0"><a href="#" class="icon29" style="background-image: url(/public/mobile/center/images/mine/two/icon_scdd.png);">{{centerInfo.showlist.mymalldd.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mysc.isShow==0"><a href="#" class="icon_sc" style="background-image: url(/public/mobile/center/images/mine/two/icon_sc.png);">{{centerInfo.showlist.mysc.name}}<span></span></a></li>
                        </ul>
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.mystudy.isShow==0"><a href="#" class="icon40" style="background-image: url(/public/mobile/center/images/mine/two/icon_wdxx.png);">{{centerInfo.showlist.mystudy.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mydy.isShow==0"><a href="#" class="icon41" style="background-image: url(/public/mobile/center/images/mine/two/icon_scdd.png);">{{centerInfo.showlist.mydy.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mypl.isShow==0"><a href="#" class="icon19" style="background-image: url(/public/mobile/center/images/mine/two/icon_scdd.png);">{{centerInfo.showlist.mypl.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myft.isShow==0"><a href="#" class="icon30" style="background-image: url(/public/mobile/center/images/mine/two/icon_scdd.png);">{{centerInfo.showlist.myft.name}}<span></span></a></li>
                        </ul>

                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.mypt.isShow==0"><a href="#" class="icon21" style="background-image: url(/public/mobile/center/images/mine/two/icon_pt.png);">{{centerInfo.showlist.mypt.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myms.isShow==0"><a href="#" class="icon42" style="background-image: url(/public/mobile/center/images/mine/two/icon_ms.png);">{{centerInfo.showlist.myms.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mykj.isShow==0"><a href="#" class="icon43" style="background-image: url(/public/mobile/center/images/mine/two/icon_kj.png);">{{centerInfo.showlist.mykj.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.kefu.isShow==0"><a href="#" class="icon_mine_kefu" style="background-image: url(/public/mobile/center/images/mine/two/icon_kf.png);">{{centerInfo.showlist.kefu.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16" style="background-image: url(/public/mobile/center/images/mine/two/icon_cj.png);">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.shopapply.isShow==0"><a href="#" class="icon29" style="background-image: url(/public/mobile/center/images/mine/two/icon_xcx.png);">{{centerInfo.showlist.shopapply.name}}<span></span></a></li>
                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.expertcenter.isShow==0"><a href="#" class="icon_sc">{{centerInfo.showlist.expertcenter.name}}<span></span></a></li>
                            -->
                        </ul>
                        <!--
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.appletad.isShow==0"><a href="#" class="icon_applet_black">{{centerInfo.showlist.appletad.name}}<span></span></a></li>
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
                <!--<div class="top-manage">
                    <div class="input-groups">
                        <label for="">页面名称</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="centerInfo.headerTitle">
                    </div>
                </div>-->
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
                <div class="showlist-manage">
                    <div class="check-row">
                        <span>会员中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmycard" data-id="mycard" ng-checked="centerInfo.showlist.mycard.isShow==1" ng-click="checked($event)">
                                <label for="showmycard">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycard.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>会员兑换码</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyyqm" data-id="myyqm" ng-checked="centerInfo.showlist.myyqm.isShow==1" ng-click="checked($event)">
                                <label for="showmyyqm">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myyqm.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>分销中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyfx" data-id="myfx" ng-checked="centerInfo.showlist.myfx.isShow==1" ng-click="checked($event)">
                                <label for="showmyfx">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myfx.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的商城订单</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmymalldd" data-id="mymalldd" ng-checked="centerInfo.showlist.mymalldd.isShow==1" ng-click="checked($event)">
                                <label for="showmymalldd">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mymalldd.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的收藏</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmysc" data-id="mysc" ng-checked="centerInfo.showlist.mysc.isShow==1" ng-click="checked($event)">
                                <label for="showmysc">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mysc.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的学习情况</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmystudy" data-id="mystudy" ng-checked="centerInfo.showlist.mystudy.isShow==1" ng-click="checked($event)">
                                <label for="showmystudy">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mystudy.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的订阅</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmydy" data-id="mydy" ng-checked="centerInfo.showlist.mydy.isShow==1" ng-click="checked($event)">
                                <label for="showmydy">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mydy.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>评论</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmypl" data-id="mypl" ng-checked="centerInfo.showlist.mypl.isShow==1" ng-click="checked($event)">
                                <label for="showmypl">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mypl.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的帖子</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyft" data-id="myft" ng-checked="centerInfo.showlist.myft.isShow==1" ng-click="checked($event)">
                                <label for="showmyft">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myft.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>拼团</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmypt" data-id="mypt" ng-checked="centerInfo.showlist.mypt.isShow==1" ng-click="checked($event)">
                                <label for="showmypt">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mypt.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>秒杀</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyms" data-id="myms" ng-checked="centerInfo.showlist.myms.isShow==1" ng-click="checked($event)">
                                <label for="showmyms">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myms.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>砍价</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmykj" data-id="mykj" ng-checked="centerInfo.showlist.mykj.isShow==1" ng-click="checked($event)">
                                <label for="showmykj">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mykj.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>客服</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="kefu" data-id="kefu" ng-checked="centerInfo.showlist.kefu.isShow==1" ng-click="checked($event)">
                                <label for="kefu">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.kefu.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>抽奖</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="lottery" data-id="lottery" ng-checked="centerInfo.showlist.lottery.isShow==1" ng-click="checked($event)">
                                <label for="lottery">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.lottery.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>讲师申请</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="shopapply" data-id="shopapply" ng-checked="centerInfo.showlist.shopapply.isShow==1" ng-click="checked($event)">
                                <label for="shopapply">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.shopapply.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>讲师管理中心</span>
                        <div class="check-box">
                            <p>
                                <!--
                                <input type="checkbox" id="expertcenter" data-id="expertcenter" ng-checked="centerInfo.showlist.expertcenter.isShow==1" ng-click="checked($event)">
                                <label for="expertcenter">显示</label>
                                -->
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.expertcenter.name"></p>
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
                isShow : 0,
                    name : "<{if $row['ct_myact_name']}><{$row['ct_myact_name']}><{else}>账户充值<{/if}>"
            },
            jfshop : {
                isShow : <{$row['ct_jfshop_show']}>,
                name : "<{if $row['ct_jfshop_name']}><{$row['ct_jfshop_name']}><{else}>积分商城<{/if}>"
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
                isShow : 0,
                    name : "<{if $row['ct_myinfo_name']}><{$row['ct_myinfo_name']}><{else}>修改资料<{/if}>"
            },
            myphone : {
                isShow : <{$row['ct_myphone_show']}>,
                name : "<{if $row['ct_myphone_name']}><{$row['ct_myphone_name']}><{else}>我的手机号<{/if}>"
            },
            myaddr : {
                isShow : 0,
                    name : "<{if $row['ct_myaddr_name']}><{$row['ct_myaddr_name']}><{else}>收货地址<{/if}>"
            },
            mycart : {
                isShow : <{$row['ct_mycart_show']}>,
                name : "<{if $row['ct_mycart_name']}><{$row['ct_mycart_name']}><{else}>购物车<{/if}>"
            },
            mycard : {
                isShow : <{$row['ct_mycard_show']}>,
                name : "<{if $row['ct_mycard_name']}><{$row['ct_mycard_name']}><{else}>我的会员<{/if}>"
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
            mymalldd : {
                isShow : <{$row['ct_mymalldd_show']}>,
                name : "<{if $row['ct_mymalldd_name']}><{$row['ct_mymalldd_name']}><{else}>我的商城订单<{/if}>"
            },
            mysc : {
                isShow : <{$row['ct_mysc_show']}>,
                name : "<{if $row['ct_mysc_name']}><{$row['ct_mysc_name']}><{else}>我的收藏<{/if}>"
            },
            myft : {
                isShow :  <{$row['ct_myft_show']}>,
                name : "<{if $row['ct_myft_name']}><{$row['ct_myft_name']}><{else}>我的发帖<{/if}>"
            },
            mypl : {
                isShow : <{$row['ct_mypl_show']}>,
                name : "<{if $row['ct_mypl_name']}><{$row['ct_mypl_name']}><{else}>我的评论<{/if}>"
            },
            mydd : {
                isShow : <{$row['ct_mydd_show']}>,
                name : "<{if $row['ct_mydd_name']}><{$row['ct_mydd_name']}><{else}>我的订单<{/if}>"
            },
            myread : {
                isShow : <{$row['ct_myread_show']}>,
                name : "<{if $row['ct_myread_name']}><{$row['ct_myread_name']}><{else}>付费阅读<{/if}>"
            },
            kefu : {
                isShow : <{$row['ct_kefu_show']}>,
                name : "<{if $row['ct_kefu_name']}><{$row['ct_kefu_name']}><{else}>客服<{/if}>"
            },
            mymp : {
                isShow : <{$row['ct_mymp_show']}>,
                name : "<{if $row['ct_mymp_name']}><{$row['ct_mymp_name']}><{else}>我的名片<{/if}>"
            },
            mympj : {
                isShow : <{$row['ct_mympj_show']}>,
                name : "<{if $row['ct_mympj_name']}><{$row['ct_mympj_name']}><{else}>我的名片夹<{/if}>"
            },
            myyqm : {
                isShow : <{$row['ct_myyqm_show']}>,
                name : "<{if $row['ct_myyqm_name']}><{$row['ct_myyqm_name']}><{else}>填写邀请码<{/if}>"
            },
            mystudy : {
                isShow : <{$row['ct_mystudy_show']}>,
                name : "<{if $row['ct_mystudy_name']}><{$row['ct_mystudy_name']}><{else}>我的学习情况<{/if}>"
            },
            mydy : {
                isShow : <{$row['ct_mydy_show']}>,
                name : "<{if $row['ct_mydy_name']}><{$row['ct_mydy_name']}><{else}>我的订阅<{/if}>"
            },
            myms : {
                isShow : <{$row['ct_myms_show']}>,
                name : "<{if $row['ct_myms_name']}><{$row['ct_myms_name']}><{else}>我的秒杀<{/if}>"
            },
            mykj : {
                isShow : <{$row['ct_mykj_show']}>,
                name : "<{if $row['ct_mykj_name']}><{$row['ct_mykj_name']}><{else}>我的砍价<{/if}>"
            },
            appletad : {
                isShow : <{$row['ct_appletad_show']}>,
                name : "<{if $row['ct_appletad_name']}><{$row['ct_appletad_name']}><{else}>我也要做小程序<{/if}>"
            },
            lottery : {
                isShow : <{$row['ct_lottery_show']}>,
                name : "<{if $row['ct_lottery_name']}><{$row['ct_lottery_name']}><{else}>抽奖<{/if}>"
            },
            shopapply : {
                isShow : <{$row['ct_shopapply_show']}>,
                name : "<{if $row['ct_shopapply_name']}><{$row['ct_shopapply_name']}><{else}>讲师申请<{/if}>"
            },
            expertcenter : {
                isShow : <{$row['ct_expertcenter_show']}>,
                name : "<{if $row['ct_expertcenter_name']}><{$row['ct_expertcenter_name']}><{else}>讲师管理中心<{/if}>"
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
        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.centerInfo.bgSrc = imgNowsrc;
            }
        };
        $scope.changeAdImg=function(){
            if(imgNowsrc){
                $scope.centerInfo.adImg.imgSrc = imgNowsrc;
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

    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }



</script>
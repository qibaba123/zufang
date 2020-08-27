<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css?2">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css?2">
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
                                <div class="left-touxiang" style="margin: 0 auto;float: none"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="text-align: center;width: 100%;padding-left: 0" ><!--ng-style="{'color':centerInfo.txtColor}"-->
                                    <p>会员昵称</p>
                                    <!--<p>会员ID：18</p>-->
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
                        <div class="style-type-old" ng-show="centerInfo.styleType == 1">
                            <ul class="user-operation">
                                <!--
                                <li class="border-b" ng-hide="centerInfo.showlist.myinfo.isShow==0"><a href="#" class="icon8">{{centerInfo.showlist.myinfo.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.myphone.isShow==0"><a href="#" class="icon12">{{centerInfo.showlist.myphone.name}}<span></span></a></li>
                                -->
                                <li class="border-b" ng-hide="centerInfo.showlist.mydd.isShow==0"><a href="#" class="icon20">{{centerInfo.showlist.mydd.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.myhx.isShow==0"><a href="#" class="icon44">{{centerInfo.showlist.myhx.name}}<span></span></a></li>
                                <!--<li class="border-b" ng-hide="centerInfo.showlist.myaddr.isShow==0"><a href="#" class="icon9">{{centerInfo.showlist.myaddr.name}}<span></span></a></li>-->
                                <li class="border-b" ng-hide="centerInfo.showlist.mycart.isShow==0"><a href="#" class="icon14">{{centerInfo.showlist.mycart.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mypt.isShow==0"><a href="#" class="icon_pt">{{centerInfo.showlist.mypt.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon_yhq">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>
                                <{if $haveHhr == 1}>
                                <li class="border-b" ng-hide="centerInfo.showlist.myfx.isShow==0"><a href="#" class="icon51">{{centerInfo.showlist.myfx.name}}<span></span></a></li>
                                <{/if}>

                            </ul>

                            <ul class="user-operation">
                                <!--
                                <li class="border-b" ng-hide="centerInfo.showlist.mycj.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.mycj.name}}<span></span></a></li>
                                -->
                                <!--<li class="border-b" ng-hide="centerInfo.showlist.mysc.isShow==0"><a href="#" class="icon23">{{centerInfo.showlist.mysc.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mybr.isShow==0"><a href="#" class="icon23">{{centerInfo.showlist.mybr.name}}<span></span></a></li>-->


                                <li class="border-b" ng-hide="centerInfo.showlist.myft.isShow==0"><a href="#" class="icon18">{{centerInfo.showlist.myft.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mypl.isShow==0"><a href="#" class="icon19">{{centerInfo.showlist.mypl.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mychat.isShow==0"><a href="#" class="icon19">{{centerInfo.showlist.mychat.name}}<span></span></a></li>
                                <!--
                                <li class="border-b" ng-hide="centerInfo.showlist.myact.isShow==0"><a href="#" class="icon3">{{centerInfo.showlist.myact.name}}<span></span></a></li>
                                -->

                                <!--
                                <li class="border-b" ng-hide="centerInfo.showlist.myjf.isShow==0"><a href="#" class="icon3">{{centerInfo.showlist.myjf.name}}<span></span></a></li>
                                -->
                                <!--<li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon2">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>-->


                            </ul>

                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.mymp.isShow==0"><a href="#" class="icon37">{{centerInfo.showlist.mymp.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mympj.isShow==0"><a href="#" class="icon38">{{centerInfo.showlist.mympj.name}}<span></span></a></li>

                            </ul>

                            <!--<ul class="user-operation">

                            </ul>-->

                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.myphone.isShow==0"><a href="#" class="icon_phone">{{centerInfo.showlist.myphone.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mywith.isShow==0"><a href="#" class="icon_tx">{{centerInfo.showlist.mywith.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.jfshop.isShow==0"><a href="#" class="icon_jfshop">{{centerInfo.showlist.jfshop.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.myread.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.myread.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.kefu.isShow==0"><a href="#" class="icon36">{{centerInfo.showlist.kefu.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mywifi.isShow==0"><a href="#" class="icon_city_wifi">{{centerInfo.showlist.mywifi.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.actcenter.isShow==0"><a href="#" class="icon_activity">{{centerInfo.showlist.actcenter.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.step.isShow==0"><a href="#" class="icon27">{{centerInfo.showlist.step.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.helpcenter.isShow==0"><a href="#" class="icon_yy">{{centerInfo.showlist.helpcenter.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.subscribe.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.subscribe.name}}<span></span></a></li>
                            </ul>
                            <!--
                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.appletad.isShow==0"><a href="#" class="icon_applet_black">{{centerInfo.showlist.appletad.name}}<span></span></a></li>
                            </ul>
                            -->
                        </div>
                        <div class="style-type-new" ng-show="centerInfo.styleType == 2">
                             <div class="fenlei-nav" ng-hide="centerInfo.showlist.mydd.isShow==0">
                                <div class="style-new-title">
                                    <span>{{centerInfo.showlist.mydd.name}}</span>
                                    <span style="font-size:12px;color:#777;float:right">查看全部订单 ></span>
                                </div>
                                <ul class="border-t border-b" style="white-space: normal;">
                            
                                    <li ng-repeat="item in tradeNav">
                                        <img ng-src="{{item.imgsrc}}" width="100%" height="100%"  alt="图标">
                                        <span>{{item.title}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="fenlei-nav">
                                <div class="style-new-title">
                                    <span>{{centerInfo.serviceTitle}}</span>
                                </div>
                                <ul class="border-t border-b service-nav" style="white-space: normal;">          
                                    <li ng-hide="centerInfo.showlist.myft.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/1.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myft.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mypl.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_pl.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mypl.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mysc.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/7.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mysc.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mychat.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/7.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mychat.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mycart.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_car.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mycart.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mypt.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_pt.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mypt.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myhx.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/5.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myhx.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myyhq.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_coupon.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myyhq.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mymp.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_mp.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mymp.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mympj.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_mpj.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mympj.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myphone.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/14.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myphone.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mywith.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_tx.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mywith.name}}</span>
                                    </li>
                                    <{if $haveHhr == 1}>
                                    <li ng-hide="centerInfo.showlist.myfx.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_fx.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myfx.name}}</span>
                                    </li>
                                    <{/if}>
                                    <li ng-hide="centerInfo.showlist.jfshop.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_jf.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.jfshop.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myread.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_yd.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myread.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.kefu.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_kf.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.kefu.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mywifi.isShow==0">
                                        <img ng-src="/public/mobile/center/images/icon_city_wifi.jpg" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mywifi.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.lottery.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_cj.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.lottery.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.actcenter.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/icon_activity.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.actcenter.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.step.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_wxbs.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.step.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.helpcenter.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/9.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.helpcenter.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.subscribe.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/9.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.subscribe.name}}</span>
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
                <div class="top-manage">
                    <div class="input-groups">
                        <label for="">页面名称</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="centerInfo.headerTitle">
                    </div>
                    <div class="input-groups">
                        <label for="">页面样式</label>
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="indexShow" id="index_yes" value="1" ng-model="centerInfo.styleType" <{if $row['ct_style_type'] eq 1}>checked<{/if}>>
                                        <label for="index_yes">旧版小图标</label>
                                    </span>
                            <span>
                                        <input type="radio" name="indexShow" id="index_no" value="2" ng-model="centerInfo.styleType" <{if $row['ct_style_type'] eq 2}>checked<{/if}>>
                                        <label for="index_no">新版大图标</label>
                                    </span>
                        </div>
                    </div>
                    <div class="input-groups" ng-show="centerInfo.styleType == 2">
                        <label for="">服务标题</label>
                        <input type="text" placeholder="请输入服务标题" maxlength="10" ng-model="centerInfo.serviceTitle">
                    </div>
                    <div class="input-groups">
                        <label for="">提示授权手机</label>
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="verifyMobile" id="mobile_yes" value="1" ng-model="centerInfo.verifyMobile" <{if $row['ct_verify_mobile'] eq 1}>checked<{/if}>>
                                        <label for="mobile_yes">开启</label>
                                    </span>
                            <span>
                                        <input type="radio" name="verifyMobile" id="mobile_no" value="0" ng-model="centerInfo.verifyMobile" <{if $row['ct_verify_mobile'] neq 1}>checked<{/if}>>
                                        <label for="mobile_no">关闭</label>
                                    </span>
                        </div>
                        <div style="color: red">开启时，用户进入个人中心时会有授权手机号的提示</div>
                    </div>
                    <!--
                    <div class="input-groups" ng-show="centerInfo.styleType == 2">
                        <label for="">开通会员跳转</label>
                        <select class="form-control" name="" id="" ng-model="centerInfo.membercardJump" style="width: 78%">
                            <option value="0">会员卡列表</option>
                            <option value="1">会员卡</option>
                            <option value="2">计次卡</option>
                            <option value="3">储值卡</option>
                        </select>
                    </div>
                    -->
                    <!--<div class="input-groups">
                        <label for="">信息文字颜色</label>
                        <input type="text" placeholder="请输入页面标题" id="txtColor">
                    </div>-->
                    <div class="input-groups">
                        <label for="">信息背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="300" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}" onload="changeBgSrc(this)" imageonload="changeTopBg()" id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*300</p>
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
                <div class="showlist-manage">
                    <div class="check-row">
                        <span>我的发帖</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyft" data-id="myft" ng-checked="centerInfo.showlist.myft.isShow==1" ng-click="checked($event)">
                                <label for="showmyft">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myft.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的评论</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmypl" data-id="mypl" ng-checked="centerInfo.showlist.mypl.isShow==1" ng-click="checked($event)">
                                <label for="showmypl">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mypl.name"></p>
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
                        <span>私信</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmychat" data-id="mychat" ng-checked="centerInfo.showlist.mychat.isShow==1" ng-click="checked($event)">
                                <label for="showmychat">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mychat.name"></p>
                        </div>
                    </div>
                    <!--<div class="check-row">
                        <span>我的足迹</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmybr" data-id="mybr" ng-checked="centerInfo.showlist.mybr.isShow==1" ng-click="checked($event)">
                                <label for="showmybr">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mybr.name"></p>
                        </div>
                    </div>-->
                    <div class="check-row">
                        <span>我的订单</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmydd" data-id="mydd" ng-checked="centerInfo.showlist.mydd.isShow==1" ng-click="checked($event)">
                                <label for="showmydd">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mydd.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的核销</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyhx" data-id="myhx" ng-checked="centerInfo.showlist.myhx.isShow==1" ng-click="checked($event)">
                                <label for="showmyhx">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myhx.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>购物车</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmycart" data-id="mycart" ng-checked="centerInfo.showlist.mycart.isShow==1" ng-click="checked($event)">
                                <label for="showmycart">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycart.name"></p>
                        </div>
                    </div>
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

                    <div class="check-row" <{if $haveMpj == 0 }>style="display: none !important;" <{/if}>>
                        <span>我的名片</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmymp" data-id="mymp" ng-checked="centerInfo.showlist.mymp.isShow==1" ng-click="checked($event)">
                                <label for="showmymp">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mymp.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的名片夹</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmympj" data-id="mympj" ng-checked="centerInfo.showlist.mympj.isShow==1" ng-click="checked($event)">
                                <label for="showmympj">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mympj.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>手机管理</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlistphone" data-id="myphone" ng-checked="centerInfo.showlist.myphone.isShow==1" ng-click="checked($event)">
                                <label for="showlistphone">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myphone.name"></p>
                        </div>
                    </div>

                    <div class="check-row">
                       <span>我的优惠券</span>
                       <div class="check-box">
                           <p>
                               <input type="checkbox" id="showmyyhq" data-id="myyhq" ng-checked="centerInfo.showlist.myyhq.isShow==1" ng-click="checked($event)">
                               <label for="showmyyhq">显示</label>
                           </p>
                           <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myyhq.name"></p>
                       </div>
                   </div>
                    <div class="check-row">
                        <span>申请提现</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist3" data-id="mywith" ng-checked="centerInfo.showlist.mywith.isShow==1" ng-click="checked($event)">
                                <label for="showlist3">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mywith.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>积分商城</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showjfshop" data-id="jfshop" ng-checked="centerInfo.showlist.jfshop.isShow==1" ng-click="checked($event)">
                                <label for="showjfshop">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.jfshop.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>付费阅读</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showread" data-id="myread" ng-checked="centerInfo.showlist.myread.isShow==1" ng-click="checked($event)">
                                <label for="showread">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myread.name"></p>
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
                    <{if $haveHhr == 1}>
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
                    <{/if}>
                    <div class="check-row">
                        <span>我的wifi</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="mywifi" data-id="mywifi" ng-checked="centerInfo.showlist.mywifi.isShow==1" ng-click="checked($event)">
                                <label for="mywifi">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mywifi.name"></p>
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
                        <span>活动中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="actcenter" data-id="actcenter" ng-checked="centerInfo.showlist.actcenter.isShow==1" ng-click="checked($event)">
                                <label for="actcenter">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.actcenter.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>微信步数</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="step" data-id="step" ng-checked="centerInfo.showlist.step.isShow==1" ng-click="checked($event)">
                                <label for="step">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.step.name"></p>
                        </div>
                    </div>
                <div class="check-row">
                    <span>帮助中心</span>
                    <div class="check-box">
                        <p>
                            <input type="checkbox" id="showhelpcenter" data-id="helpcenter" ng-checked="centerInfo.showlist.helpcenter.isShow==1" ng-click="checked($event)">
                            <label for="showhelpcenter">显示</label>
                        </p>
                        <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.helpcenter.name"></p>
                    </div>
                </div>
                <div class="check-row" >
                    <span>订阅消息</span>
                    <div class="check-box">
                        <p>
                            <input type="checkbox" id="showsubscribe" data-id="subscribe" ng-checked="centerInfo.showlist.subscribe.isShow==1" ng-click="checked($event)">
                            <label for="showsubscribe">显示</label>
                        </p>
                        <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.subscribe.name"></p>
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
        $scope.tradeNav = <{$tradeNav}>;
        $scope.centerInfo = {
            headerTitle:"<{$row['ct_center_title']}>",
            membercardJump:"<{$row['ct_membercard_jump']}>",
            txtColor:"<{$row['ct_center_color']}>",
            bgSrc:"<{$row['ct_center_bg']}>",
            styleType : "<{$row['ct_style_type']}>",
            verifyMobile : "<{$row['ct_verify_mobile']}>",
            serviceTitle : "<{$row['ct_service_title']}>" ? "<{$row['ct_service_title']}>" : "我的服务",
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
            mysc : {
                isShow : <{$row['ct_mysc_show']}>,
                name : "<{if $row['ct_mysc_name']}><{$row['ct_mysc_name']}><{else}>我的收藏<{/if}>"
            },
            mybr:{
                isShow : <{$row['ct_mybr_show']}>,
                name : "<{if $row['ct_mybr_name']}><{$row['ct_mybr_name']}><{else}>我的足迹<{/if}>"
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
            myhx : {
                isShow : <{$row['ct_myhx_show']}>,
                name : "<{if $row['ct_myhx_name']}><{$row['ct_myhx_name']}><{else}>我的核销<{/if}>"
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
            mychat : {
                isShow : <{$row['ct_mychat_show']}>,
                name : "<{if $row['ct_mychat_name']}><{$row['ct_mychat_name']}><{else}>私信<{/if}>"
            },
            appletad : {
                isShow : <{$row['ct_appletad_show']}>,
                name : "<{if $row['ct_appletad_name']}><{$row['ct_appletad_name']}><{else}>我也要做小程序<{/if}>"
            },
            mywifi : {
                isShow : <{$row['ct_mywifi_show']}>,
                name : "<{if $row['ct_mywifi_name']}><{$row['ct_mywifi_name']}><{else}>我的wifi<{/if}>"
            },
            lottery : {
                isShow : <{$row['ct_lottery_show']}>,
                name : "<{if $row['ct_lottery_name']}><{$row['ct_lottery_name']}><{else}>抽奖<{/if}>"
            },
            actcenter : {
                isShow : <{$row['ct_actcenter_show']}>,
                name : "<{if $row['ct_actcenter_name']}><{$row['ct_actcenter_name']}><{else}>活动中心<{/if}>"
            },
            step : {
                isShow :  <{$row['ct_step_show']}>,
                name : "<{if $row['ct_step_name']}><{$row['ct_step_name']}><{else}>微信步数<{/if}>"
            },
            helpcenter : {
                isShow : <{$row['ct_helpcenter_show']}>,
                name : "<{if $row['ct_helpcenter_name']}><{$row['ct_helpcenter_name']}><{else}>帮助中心<{/if}>"
            },
            subscribe : {
                isShow : <{$row['ct_subscribe_show']}>,
                name : "<{if $row['ct_subscribe_name']}><{$row['ct_subscribe_name']}><{else}>订阅消息<{/if}>"
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
                'serviceTitle'  : $scope.centerInfo.serviceTitle,
                'membercardJump': $scope.centerInfo.membercardJump,
                'styleType'     : $scope.centerInfo.styleType,
                'verifyMobile'  : $scope.centerInfo.verifyMobile,
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

    function changeBgSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }

</script>
<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css?1">
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

                        <!-- 分类导航 -->
                        <!--
                        <div class="fenlei-nav" >
                            <ul class="border-t border-b" style="white-space: normal;">
                                <li ng-if="nav.open" ng-repeat="nav in navList">
                                    <img ng-src="{{nav.imgsrc}}" width="100%" height="100%"  alt="图标">
                                    <span>{{nav.title}}</span>
                                </li>
                            </ul>
                        </div>
                        -->
                        <div class="member-info" style="position: relative;height: 88.5px;background:#2FCD98;padding: 0 " >
                            <img src="{{centerInfo.bgSrc}}" alt="图片" style="width: 100%;height: 88.5px" ng-show="centerInfo.bgSrc != '/public/mobile/images/shk_02.png'">
                            <div class="base-info" style="position: absolute;top: 0">
                                <div class="left-touxiang" style="margin: 0;float: none;display: inline-block;width: 50px;height: 50px"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="width: auto;padding-left: 0;display: inline-block;float: none" ><!--ng-style="{'color':centerInfo.txtColor}"-->
                                    <p>会员昵称</p>
                                    <!--<p>会员ID：18</p>-->
                                    <!--<p>会员等级：无</p>-->
                                </div>
                            </div>
                        </div>
                        <div class="style-type-old" ng-show="centerInfo.styleType == 1">
                            <ul class="user-operation">

                                <li class="border-b" ng-hide="centerInfo.showlist.mydd.isShow==0"><a href="#" class="icon_tx">{{centerInfo.showlist.mydd.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon_yhq">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.coupon.isShow==0"><a href="#" class="icon_yhq">{{centerInfo.showlist.coupon.name}}<span></span></a></li>
                                <!--
                                <li class="border-b" ng-hide="centerInfo.showlist.mywith.isShow==0"><a href="#" class="icon_tx">{{centerInfo.showlist.mywith.name}}<span></span></a></li>
                                -->
                                <li class="border-b" ng-hide="centerInfo.showlist.kefu.isShow==0"><a href="#" class="icon_phone">{{centerInfo.showlist.kefu.name}}<span></span></a></li>
                            </ul>

                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.tzapply.isShow==0"><a href="#" class="icon_pt">{{centerInfo.showlist.tzapply.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.tzcenter.isShow==0"><a href="#" class="icon_sc">{{centerInfo.showlist.tzcenter.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.tzinfo.isShow==0"><a href="#" class="icon_sc">{{centerInfo.showlist.tzinfo.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.gysapply.isShow==0"><a href="#" class="icon_gdp">{{centerInfo.showlist.gysapply.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.subscribe.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.subscribe.name}}<span></span></a></li>
                            </ul>

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
                                    <li ng-hide="centerInfo.showlist.myyhq.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_coupon.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myyhq.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myact.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_qb.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myact.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.coupon.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_coupon.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.coupon.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.jfshop.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_jf.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.jfshop.name}}</span>
                                    </li>
                                    <!--
                                    <li ng-hide="centerInfo.showlist.mywith.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_tx.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mywith.name}}</span>
                                    </li>
                                    -->
                                    <li ng-hide="centerInfo.showlist.kefu.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_kf.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.kefu.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.tzapply.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_pt.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.tzapply.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.tzcenter.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/14.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.tzcenter.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.tzinfo.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/14.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.tzinfo.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mycard.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/icon10.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mycard.name}}</span>
                                    </li>

                                    <li ng-hide="centerInfo.showlist.redbag.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_jf.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.redbag.name}}</span>
                                    </li>

                                    <li ng-hide="centerInfo.showlist.gysapply.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/10.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.gysapply.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.helpcenter.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/9.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.helpcenter.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.lottery.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_cj.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.lottery.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.pickstation.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/icon_gl.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.pickstation.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.invitenew.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/invitenew.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.invitenew.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myft.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/1.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myft.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.step.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_wxbs.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.step.name}}</span>
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
                        <label for="">背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="210" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}"  imageonload="changeBg()" id="bg-img" style="display:inline-block;width: 150px">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*210</p>
                            <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" />
                        </div>
                    </div>
                    <div class="input-groups">
                        <label for="">页面名称</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="centerInfo.headerTitle">
                    </div>
                    <div class="input-groups" style="display: none">
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

                </div>
                <div class="showlist-manage">
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
                        <span>我的钱包</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyact" data-id="myact" ng-checked="centerInfo.showlist.myact.isShow==1" ng-click="checked($event)">
                                <label for="showmyact">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myact.name"></p>
                        </div>
                    </div>

                    <div class="check-row" <{if $sequenceShowAll == 0}> style="display: none" <{/if}>>
                        <span>积分商城</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showjfshop" data-id="jfshop" ng-checked="centerInfo.showlist.jfshop.isShow==1" ng-click="checked($event)">
                                <label for="showjfshop">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.jfshop.name"></p>
                        </div>
                    </div>
                    <!--
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
                    -->
                    <div class="check-row">
                        <span>优惠券大厅</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="coupon" data-id="coupon" ng-checked="centerInfo.showlist.coupon.isShow==1" ng-click="checked($event)">
                                <label for="coupon">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.coupon.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>申请当团长</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="tzapply" data-id="tzapply" ng-checked="centerInfo.showlist.tzapply.isShow==1" ng-click="checked($event)">
                                <label for="tzapply">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.tzapply.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>团长管理中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="tzcenter" data-id="tzcenter" ng-checked="centerInfo.showlist.tzcenter.isShow==1" ng-click="checked($event)">
                                <label for="tzcenter">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.tzcenter.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>团长信息</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="tzinfo" data-id="tzinfo" ng-checked="centerInfo.showlist.tzinfo.isShow==1" ng-click="checked($event)">
                                <label for="tzinfo">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.tzinfo.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的会员</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="mycard" data-id="mycard" ng-checked="centerInfo.showlist.mycard.isShow==1" ng-click="checked($event)">
                                <label for="mycard">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycard.name"></p>
                        </div>
                    </div>
                    <div class="check-row" <{if $sequenceShowAll == 0}> style="display: none" <{/if}>>
                        <span>我是供应商</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="gysapply" data-id="gysapply" ng-checked="centerInfo.showlist.gysapply.isShow==1" ng-click="checked($event)">
                                <label for="gysapply">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.gysapply.name"></p>
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
                    <div class="check-row" <{if $sequenceShowAll == 0}> style="display: none" <{/if}>>
                        <span>组队红包</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="redbag" data-id="redbag" ng-checked="centerInfo.showlist.redbag.isShow==1" ng-click="checked($event)">
                                <label for="redbag">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.redbag.name"></p>
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
                    <div class="check-row" <{if $sequenceShowAll == 0}> style="display: none" <{/if}>>
                        <span>抽奖</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="lottery" data-id="lottery" ng-checked="centerInfo.showlist.lottery.isShow==1" ng-click="checked($event)">
                                <label for="lottery">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.lottery.name"></p>
                        </div>
                    </div>
                    <div class="check-row" >
                        <span>自提点管理</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="pickstation" data-id="pickstation" ng-checked="centerInfo.showlist.pickstation.isShow==1" ng-click="checked($event)">
                                <label for="pickstation">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.pickstation.name"></p>
                        </div>
                    </div>
                    <div class="check-row" >
                        <span>新人邀请</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="invitenew" data-id="invitenew" ng-checked="centerInfo.showlist.invitenew.isShow==1" ng-click="checked($event)">
                                <label for="invitenew">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.invitenew.name"></p>
                        </div>
                    </div>
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
                        <span>微信步数</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="step" data-id="step" ng-checked="centerInfo.showlist.step.isShow==1" ng-click="checked($event)">
                                <label for="step">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.step.name"></p>
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
        //$scope.navList = <{$row['ct_nav_list']}>;
        $scope.tradeNav = <{$tradeNav}>;
        $scope.centerInfo = {
            headerTitle:"<{$row['ct_center_title']}>",
            txtColor:"<{$row['ct_center_color']}>",
            bgSrc:"<{$row['ct_center_bg']}>",
            styleType : "<{$row['ct_style_type']}>",
            serviceTitle : "<{$row['ct_service_title']}>" ? "<{$row['ct_service_title']}>" : "我的服务",
            adImg:{
                imgSrc:"<{$row['ct_advert_img']}>",
                link:"<{$row['ct_advert_link']}>",
                adshow:<{$row['ct_advert_show']}>
        },


        showlist:{
            myyhq : {
                isShow : <{$row['ct_myyhq_show']}>,
                name : "<{if $row['ct_myyhq_name']}><{$row['ct_myyhq_name']}><{else}>我的优惠券<{/if}>"
            },
            jfshop : {
                isShow : <{$row['ct_jfshop_show']}>,
                name : "<{if $row['ct_jfshop_name']}><{$row['ct_jfshop_name']}><{else}>积分商城<{/if}>"
            },
            coupon : {
                isShow : <{$row['ct_coupon_show']}>,
                name : "<{if $row['ct_coupon_name']}><{$row['ct_coupon_name']}><{else}>优惠券大厅<{/if}>"
            },
            myact : {
                isShow : <{$row['ct_myact_show']}>,
                name : "<{if $row['ct_myact_name']}><{$row['ct_myact_name']}><{else}>我的钱包<{/if}>"
            },
            tzapply : {
                isShow : <{$row['ct_tzapply_show']}>,
                name : "<{if $row['ct_tzapply_name']}><{$row['ct_tzapply_name']}><{else}>申请当团长<{/if}>"
            },
            tzcenter : {
                isShow : <{$row['ct_tzcenter_show']}>,
                name : "<{if $row['ct_tzcenter_name']}><{$row['ct_tzcenter_name']}><{else}>团长管理中心<{/if}>"
            },
            tzinfo : {
                isShow : <{$row['ct_tzinfo_show']}>,
                name : "<{if $row['ct_tzinfo_name']}><{$row['ct_tzinfo_name']}><{else}>团长信息<{/if}>"
            },
            mycard : {
                isShow : <{$row['ct_mycard_show']}>,
                name : "<{if $row['ct_mycard_name']}><{$row['ct_mycard_name']}><{else}>我的会员<{/if}>"
            },
            gysapply : {
                isShow : <{$row['ct_gysapply_show']}>,
                name : "<{if $row['ct_gysapply_name']}><{$row['ct_gysapply_name']}><{else}>我是供应商<{/if}>"
            },
            mywith : {
                isShow : <{$row['ct_mywith_show']}>,
                name : "<{if $row['ct_mywith_name']}><{$row['ct_mywith_name']}><{else}>余额提现<{/if}>"
            },
            mydd : {
                isShow : <{$row['ct_mydd_show']}>,
                name : "<{if $row['ct_mydd_name']}><{$row['ct_mydd_name']}><{else}>我的订单<{/if}>"
            },
            kefu : {
                isShow : <{$row['ct_kefu_show']}>,
                name : "<{if $row['ct_kefu_name']}><{$row['ct_kefu_name']}><{else}>客服<{/if}>"
            },
            appletad : {
                isShow : <{$row['ct_appletad_show']}>,
                name : "<{if $row['ct_appletad_name']}><{$row['ct_appletad_name']}><{else}>我也要做小程序<{/if}>"
            },
            redbag : {
                isShow : <{$row['ct_redbag_show']}>,
                name : "<{if $row['ct_redbag_name']}><{$row['ct_redbag_name']}><{else}>组队红包<{/if}>"
            },
            helpcenter : {
                isShow : <{$row['ct_helpcenter_show']}>,
                name : "<{if $row['ct_helpcenter_name']}><{$row['ct_helpcenter_name']}><{else}>帮助中心<{/if}>"
            },
            lottery : {
                isShow : <{$row['ct_lottery_show']}>,
                name : "<{if $row['ct_lottery_name']}><{$row['ct_lottery_name']}><{else}>抽奖<{/if}>"
            },
            pickstation : {
                isShow : <{$row['ct_pickstation_show']}>,
                name : "<{if $row['ct_pickstation_name']}><{$row['ct_pickstation_name']}><{else}>自提点管理<{/if}>"
            },
            invitenew : {
                isShow : <{$row['ct_invitenew_show']}>,
                name : "<{if $row['ct_invitenew_name']}><{$row['ct_invitenew_name']}><{else}>新人邀请<{/if}>"
            },
            myft : {
                isShow :  <{$row['ct_myft_show']}>,
                name : "<{if $row['ct_myft_name']}><{$row['ct_myft_name']}><{else}>我的发帖<{/if}>"
            },
            step : {
                isShow :  <{$row['ct_step_show']}>,
                name : "<{if $row['ct_step_name']}><{$row['ct_step_name']}><{else}>微信步数<{/if}>"
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
                'serviceTitle'  : $scope.centerInfo.serviceTitle,
                //'styleType'     : $scope.centerInfo.styleType,
                'styleType'     : 2,
                'color'         : $scope.centerInfo.txtColor,
                'bg'            : $scope.centerInfo.bgSrc,
                'ad_link'       : $scope.centerInfo.adImg.link,
                'ad_img'        : $scope.centerInfo.adImg.imgSrc,
                'advert'        : $scope.centerInfo.adImg.adshow,
                'list'          : $scope.centerInfo.showlist,
                //'navList'       :$scope.navList
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
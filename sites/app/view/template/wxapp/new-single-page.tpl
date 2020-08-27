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
    .bottom-menu{
        height: 50px;
        width: 100%;
    }
    .bottom-menu .no-menu-tips{
        line-height: 50px;
        text-align: center;
        font-size: 14px;
        color: #999;
    }
    .bottom-menu .menu-list{
        display: table;
    }
    .bottom-menu .menu-item{
        display: table-cell;
        height: 50px;
        overflow: hidden;
        width: 1000px;
    }
    .bottom-menu .menu-item img{
        width: 25px;
        height: 25px;
        margin:0 auto;
        display: block;
        margin-top: 5px;
        border-radius: 5px;
    }
    .bottom-menu .menu-item p{
        line-height: 20px;
        text-align: center;
        margin:0;
        font-size: 13px;
        color: #666;
    }
    .bottom-menu-manage{
        width: 420px;
        height: 60px;
        border-radius: 4px;
        overflow: hidden;
    }
    .bottom-menu-manage .menu-item{
        height: 60px;
    }
    .bottom-menu-manage .menu-item img{
        height: 30px;
        width: 30px;
    }
    .other-setting {
        padding: 10px 0;
    }
    .other-setting .color-set-box {
        overflow: hidden;
        padding: 3px 0;
    }
    .other-setting .color-set-box .label-name {
        float: left;
        line-height: 32px;
        text-align: right;
        width: 100px;
    }
    .sp-replacer{
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .activity-manage .edit-img{
        width: 70%;
        margin: 0 auto;
    }
    .activity-manage .edit-img img{
        width: 100%;
        margin:0 auto;
        cursor: pointer;
    }
    .activity-manage .edit-txt{
        padding-top: 10px;
    }
    .activity-manage .edit-txt .input-group-box{
        padding: 3px 0;
        overflow: hidden;
    }
    .activity-manage .edit-txt .input-group-box .label-name{
        width: 18%;
        float: left;
        line-height: 34px;
    }
    .activity-manage .edit-txt .input-group-box .cus-input{
        width: 82%;
        float: left;
    }
    .data-manage-tips{
        padding: 10px 0;
        font-size: 16px;
        font-weight: bold;
        color: #aaa;
        text-align: left;
    }
    .right-icon .curicon-box{
        display: inline-block;
        vertical-align: middle;
        overflow: hidden;
        padding: 1px;
        margin-right: 10px;
    }
    .right-icon .curicon-box img{
        float: left;
        height: 32px;
        width: 32px;
        margin:0 3px;
    }
    .right-icon .chooseicon{
        font-size: 12px;
        color: #007cf9;
        border:1px solid #007cf9;
        border-radius: 2px;
        padding: 5px;
        cursor: pointer;
    }
    div[data-menu].cur-edit {
        position: relative;
    }
    div[data-menu].cur-edit::after, div[data-menu].cur-edit:hover::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 2px dashed #FC7C7C;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        z-index: 10;
        cursor: pointer;
    }
    .index-img-show{
        width: 33%;
        padding: 3px;
        display: inline-block;

    }
    .index-img-title{
        text-align: left;
        color: #000;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main" style="height: 430px;">
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
                    <div class="appointment-wrap" data-left-preview data-id="6">
                        <div class="no-data-tip" ng-if="!jumpInfo.isOn">点此管理小程序跳转</div>
                        <div ng-if="jumpInfo.isOn">
                            <img ng-src="{{jumpInfo.background}}" class="logo-bg" style="width: 100%"/>
                        </div>
                    </div>
                    <div class="shops-contact" data-left-preview data-id="8" style="background-color: #fff">
                        <div class="no-data-tip" ng-if="!videoShow">点此管理视频</div>
                        <div ng-if="videoShow">
                            <img ng-src="{{videoImg}}" class="logo-bg" style="width: 100%"/>
                        </div>
                    </div>
                    <div class="shops-contact" data-left-preview data-id="9" style="background-color: #fff">
                        <div class="no-data-tip" ng-if="indexImg.length <= 0 || !imgShow">点此管理商户图片</div>
                        <div class="no-data-tip" ng-if="indexImg.length > 0 && imgShow">
                            <div class="index-img-title">
                                <span>{{imgTitle}}</span>
                            </div>
                            <div class="index-img-show" ng-repeat="img in indexImg | limitTo:3">
                                <img ng-src="{{img.imgsrc}}" class="logo-bg" style="width: 100%"/>
                            </div>

                        </div>
                    </div>

                    <div class="article-con" id="article-con" data-left-preview data-id="4" >
                        <{if $tpl && $tpl['asp_content']}>
                        <{$tpl['asp_content']}>
                        <{else}>
                        <p>这里将会显示图文内容</p>
                        <{/if}>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="5">
                        <div class="no-data-tip" ng-if="!appointInfo.isOn">点此管理预约模块儿~</div>
                        <div ng-if="appointInfo.isOn">
                            <div class="cooperative-wrap">
                                <img ng-src="{{bottomImg}}" style="width: 90%;" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="bottom-menu" data-left-preview data-id="7">
                    <div class="no-menu-tips" ng-show="{{menuList.length<=1}}">点击此处配置底部菜单~</div>
                    <div class="menu-list" ng-show="{{menuList.length>1}}" style="background-color:{{bottomMenu.bgColor}};">
                        <div class="menu-item" ng-repeat="menu in menuList" ng-show="menu.isShow">
                            <img ng-src="{{menu.icon}}" alt="图标">
                            <p style="color:{{bottomMenu.textColor}}">{{menu.name}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con jianzheng-manage">
            <div class="header-top" data-right-edit data-id="0" style="display:block;">
                <label>顶部管理</label>
                <div class="top-manage">
                    <div class="input-group">
                        <label for="">页面标题</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                    <!--
                    <div class="input-group">
                        <label for="">背景音乐</label>
                        <textarea type="text" placeholder="请输入背景音乐链接" ng-model="backgroundMusic"></textarea>
                    </div>
                    -->
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label>幻灯管理<span>（建议尺寸750*400）</span></label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="shopintrobg-manage cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <input ng-model="banner.type = 106"  value="106" type="hidden">
                    <div class="input-group clearfix">
                        <label for="">小 程 序：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="enterpriseIntro" data-right-edit data-id="3">
                <label>联系地址</label>
                <div class="top-manage">
                    <div class="input-group-box">
                        <label class="label-name">Logo：</label>

                        <img onclick="toUpload(this)"  style="margin-top: 20px;width: 25%"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="changelogoImg()" data-dom-id="upload-logoImg" id="upload-logoImg"  ng-src="{{logoImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="logoImg"  class="avatar-field bg-img" name="logoImg" ng-value="logoImg"/>
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">名称：</label>
                        <input type="text" class="cus-input" ng-model="shopName" placeholder="请输入页面标题" maxlength="12">
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">简介：</label>
                        <input type="text" class="cus-input" ng-model="brief" placeholder="请输入公司简介" maxlength="18">
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">电话：</label>
                        <input type="text" class="cus-input" ng-model="mobile" placeholder="请输入咨询电话">
                    </div>

                    <div class="isOn" style="margin-bottom: 5px;margin-top: 20px">
                        <span>首页显示地图:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='mapShow' type='checkbox' ng-model="mapShow">
                        <label class='tgl-btn' for='mapShow' style="display: inline-block;margin-left: 5px"></label>
                    </span>
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
                    <!--<div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:450px;visibility:hidden;" id="content-detail" name="content-detail" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['asp_content']}><{$tpl['asp_content']}><{/if}></textarea>
                        <input type="hidden" name="ke_textarea_name" value="content-detail" />
                    </div>-->
                    <div class="form-textarea">
                        <textarea style="width:100%;height:350px;" id="content-detail" name="content-detail" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['asp_content']}><{$tpl['asp_content']}><{/if}></textarea>
                        <input type="hidden" name="ke_textarea_name" value="content-detail" />
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="5">
                <div class="isOn">
                    <span>开启预约:(用于收集表单信息，点击跳转到<a href="/wxapp/form/index" target="_blank" style="color: #428bca">自定义表单</a>页面。)</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='sms_start' type='checkbox' ng-model="appointInfo.isOn">
                        <label class='tgl-btn' for='sms_start'></label>
                    </span>
                </div>
                <div class="shopintrobg-manage" ng-if="appointInfo.isOn">
                    <div style="margin-top: 20px;">
                        <a href="/wxapp/form/index" target="_blank" class="btn btn-sm btn-green"> 配置自定义表单 </a>
                    </div>
                    <img onclick="toUpload(this)"  style="margin-top: 20px;width: 100%"  data-limit="1" onload="changeSrc(this)" data-width="710" data-height="240" imageonload="changeBottomImg()" data-dom-id="upload-bottomImg" id="upload-bottomImg"  ng-src="{{bottomImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="bottomImg"  class="avatar-field bg-img" name="bottomImg{{$index}}" ng-value="bottomImg"/>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="6">
                <div class="isOn">
                    <span>开启跳转小程序:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='jump_start' type='checkbox' ng-model="jumpInfo.isOn">
                        <label class='tgl-btn' for='jump_start'></label>
                    </span>
                </div>
                <div class="appoint-manage" ng-if="jumpInfo.isOn">
                    <div class="input-group">
                        <label for="">跳转小程序:</label>
                        <!--<input type="text" class="cus-input" placeholder="请输入跳转小程序的APPID" maxlength="64" ng-model="jumpInfo.appid">-->
                        <select class="cus-input" ng-model="jumpInfo.appid"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group">
                        <label for="">跳转小程序背景图:</label>
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)" data-limit="1" onload="changeSrc(this)" data-width="750" data-height="200" imageonload="changeBg()" data-dom-id="upload-logoBg" id="upload-logoBg{{$index}}"  ng-src="{{jumpInfo.background}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="logoBg"  class="avatar-field bg-img" name="logoBg" ng-value="logoBg"/>
                            <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="200" data-dom-id="upload-logoBg">修改背景图<span>(建议尺寸750*318)</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div data-right-edit data-id="7">
                <label>底部菜单管理</label>
                <div class="other-setting">
                    <div class="color-set-box">
                        <label class="label-name">导航文字颜色：</label>
                        <div class="right-color">
                            <input type="text" class="color-input" data-colortype="color" ng-model="bottomMenu.textColor">
                        </div>
                    </div>
                    <div class="color-set-box">
                        <label class="label-name">导航背景色：</label>
                        <div class="right-color">
                            <input type="text" class="color-input" data-colortype="backgroundColor" ng-model="bottomMenu.bgColor">
                        </div>
                    </div>
                </div>
                <div class="bottom-menu bottom-menu-manage">
                    <div class="menu-list" ng-show="{{menuList.length>1}}" style="background-color:{{bottomMenu.bgColor}};">
                        <div class="menu-item" ng-repeat="menu in menuList" data-menu data-type="{{menu.type}}" data-index="{{menu.index}}">
                            <img ng-src="{{menu.icon}}" alt="图标">
                            <p style="color:{{bottomMenu.textColor}}">{{menu.name}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="enterpriseIntro" data-right-edit data-id="8">
                <label>视频管理</label>
                <div class="top-manage">
                    <div class="isOn" style="margin-bottom: 5px">
                        <span>开启视频:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='videoShow' type='checkbox' ng-model="videoShow">
                        <label class='tgl-btn' for='videoShow' style="display: inline-block;margin-left: 5px"></label>
                    </span>
                    </div>
                    <div class="input-group-box" style="margin-bottom: 5px">
                        <label class="label-name">视频封面（建议尺寸710*380）</label>

                        <img onclick="toUpload(this)"  style="margin-top: 5px;width: 100%"  data-limit="1" onload="changeSrc(this)" data-width="710" data-height="380" imageonload="changevideoImg()" data-dom-id="upload-videoImg" id="upload-videoImg"  ng-src="{{videoImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="videoImg"  class="avatar-field bg-img" name="videoImg" ng-value="videoImg"/>
                    </div>
                    <div class="input-group-box" style="margin-bottom: 5px">
                        <label class="label-name">视频地址：</label>
                        <input type="text" class="cus-input" ng-model="videoUrl" placeholder="请输入视频地址" style="margin-top: 5px">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="9" ng-model="indexImg">
                <label>商户图片管理<span>（建议尺寸500*500）</span></label>
                <div class="input-group-box" style="margin-bottom: 5px">
                    <div class="isOn" style="margin-bottom: 5px">
                        <span>开启商户图片:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='imgShow' type='checkbox' ng-model="imgShow">
                        <label class='tgl-btn' for='imgShow' style="display: inline-block;margin-left: 5px"></label>
                    </span>
                    </div>
                </div>

                <div class="input-group-box" style="margin-bottom: 5px">
                    <label class="label-name">标题：</label>
                    <input type="text" class="cus-input" ng-model="imgTitle" maxlength="6" placeholder="请输入标题" style="margin-top: 5px;display: inline-block;width: 90%">
                </div>
                <div class="banner-manage" ng-repeat="img in indexImg">
                    <div class="delete" ng-click="delIndex('indexImg',img.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="shopintrobg-manage cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
                        <div class="shopintrobg-manage" style="background-color: #fff;text-align: center">
                            <img onclick="toUpload(this)"  data-limit="30" onload="changeSrc(this)" data-width="500" data-height="500" imageonload="doThis('indexImg',img.index)" data-dom-id="upload-indeximg{{$index}}" id="upload-indeximg{{$index}}"  ng-src="{{img.imgsrc}}"  height="100%" style="display:inline-block;width: 40%;">
                            <input type="hidden" id="indeximg{{$index}}"  class="avatar-field bg-img" name="indeximg{{$index}}" ng-value="img.imgsrc"/>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewImg()"></div>
            </div>
        </div>
        <div class="edit-con" id="menuBox" style="margin-top:25px;display: none;">
            <div class="activity-manage jianzheng-manage" ng-repeat="menu in menuList" data-menu-show data-type="{{menu.type}}" data-index="{{menu.index}}">
                <label style="width: 100%"><b>菜单图标及页面内容配置</b></label>
                <div class="edit-txt">
                    <div class="input-group-box clearfix" ng-hide="{{menu.type=='index'}}">
                        <label class="label-name">是否显示：</label>
                        <div class="right-icon" style="margin-left: 18%;padding: 3px 0;">
                           <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='sms_start_{{$index}}' type='checkbox' ng-model="menu.isShow">
                                <label class='tgl-btn' for='sms_start_{{$index}}'></label>
                            </span>
                        </div>
                    </div>
                    <div class="input-group-box clearfix">
                        <label class="label-name">导航图标：</label>
                        <div class="right-icon edit-img">
                            <div class="shopintrobg-manage curicon-box">
                                <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="50" data-height="50" imageonload="doIconThis('menuList',menu.index)" data-dom-id="upload-icon{{$index}}" id="upload-icon{{$index}}"  ng-src="{{menu.icon}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="icon{{$index}}"  class="avatar-field bg-img" name="icon{{$index}}" ng-value="menu.icon"/>
                                <span class="chooseicon" onclick="toUpload(this)" data-width="50" data-height="50" data-limit="8" data-dom-id="upload-icon{{$index}}">+选择图标</span>
                            </div>
                        </div>
                        <!--<div class="right-icon">
                            <div class="curicon-box">
                                <img ng-src="{{menu.icon}}" alt="图标">
                            </div>
                            <span class="chooseicon" data-toggle="modal" ng-click="chooseIcon(nav.index)">+选择图标</span>
                        </div>-->
                    </div>
                    <div class="input-group-box clearfix">
                        <label class="label-name">导航名称：</label>
                        <input type="text" class="cus-input" minlength="1" maxlength="5" ng-model="menu.name">
                    </div>
                    <div class="input-group-box clearfix" ng-show="{{menu.index>0}}">
                        <label for="">导航类型类型：</label>
                        <select ng-model="menu.category"  ng-options="x.id as x.name for x in menuCategory" style="width: 76%" ></select>
                    </div>
                </div>
                <div ng-show="menu.category==1">
                    <!--<div class="form-textarea" style="margin-top:8px;" ng-show="{{menu.index>0}}">
                        <textarea class="form-control1" style="width:100%;height:450px;visibility:hidden;" ng-model="menu.content" id="article-detail{{menu.index}}" name="article-detail{{menu.index}}" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" id="ke_textarea_name" data-type="single" data-show="false" value="article-detail{{menu.index}}" />
                    </div>-->
                    <div class="form-textarea" style="margin-top:8px;" ng-show="{{menu.index>0}}">
                        <textarea style="width:100%;height:350px;" class="form-control1" ng-model="menu.content" id="article-detail{{menu.index}}" name="article-detail{{menu.index}}" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" data-type="single" data-show="false" value="article-detail{{menu.index}}" />
                    </div>
                </div>
                <div ng-show="menu.category==4">
                    <div class="shopintrobg-manage">
                        <div style="margin-top: 20px;">
                            <a href="/wxapp/form/index" target="_blank" class="btn btn-sm btn-green"> 配置自定义表单 </a>
                        </div>
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
    console.log('new index');
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle= '<{$tpl['asp_head_title']}>';
        $scope.backgroundMusic= '<{$tpl['asp_background_music']}>';
        $scope.shopName = '<{$tpl['asp_name']}>';
        $scope.mobile= '<{$tpl['asp_mobile']}>';
        $scope.brief= '<{$tpl['asp_brief']}>';
        $scope.logoImg= '<{$tpl['asp_logo']}>';
        $scope.banners =  <{$slide}>;
        $scope.address = '<{$tpl['asp_address']}>' ? '<{$tpl['asp_address']}>' : '郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室';
        $scope.longitude = '<{$tpl['asp_lng']}>' ? '<{$tpl['asp_lng']}>' : '113.72052';
        $scope.latitude = '<{$tpl['asp_lat']}>' ? '<{$tpl['asp_lat']}>' : '34.77485';
        $scope.tpl_id	= 63;
        $scope.menuCategory = <{$menuCategory}>;
        $scope.appointInfo = {
                isOn:<{if $tpl['asp_appoint_ison']}> true <{else}> false <{/if}>,
            title:"<{$tpl['asp_appoint_title']}>" ? "<{$tpl['asp_appoint_title']}>" : '领取专享优惠',
            btnTxt:"<{$tpl['asp_appoint_btn_text']}>" ? "<{$tpl['asp_appoint_btn_text']}>" : '预约',
    };
        $scope.jumpInfo = {
                isOn:<{if $tpl['asp_jump_open']}> true <{else}> false <{/if}>,
            background:"<{$tpl['asp_jump_background']}>" ? "<{$tpl['asp_jump_background']}>" : '/public/manage/img/zhanwei/zw_fxb_750_320.png',
            appid:"<{$tpl['asp_jump_appid']}>" ? "<{$tpl['asp_jump_appid']}>" : '',
    };
        $scope.bottomImg = '<{$tpl['asp_appoint_btn_img']}>'?'<{$tpl['asp_appoint_btn_img']}>':'/public/manage/img/zhanwei/zw_fxb_75_30.png';
        $scope.logoImg = '<{$tpl['asp_logo']}>'?'<{$tpl['asp_logo']}>':'/public/manage/img/zhanwei/zw_fxb_200_200.png';
        $scope.videoImg = '<{$tpl['asp_video_img']}>'?'<{$tpl['asp_video_img']}>':'/public/manage/img/zhanwei/zw_fxb_75_40.png';
        $scope.videoShow = '<{$tpl['asp_video_show']}>' == '1' ? true : false;
        $scope.imgShow = '<{$tpl['asp_img_show']}>' == '1' ? true : false;
        $scope.mapShow = '<{$tpl['asp_map_show']}>' == '1' ? true : false;
        $scope.videoUrl = '<{$tpl['asp_video_url']}>'?'<{$tpl['asp_video_url']}>':'';
        $scope.indexImg = <{$indexImg}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.imgTitle = '<{$tpl['asp_img_title']}>'?'<{$tpl['asp_img_title']}>':'商户图片';
        $scope.bottomMenu = {
            bgColor:"<{$tpl['asp_bottom_bg_color']}>" ? "<{$tpl['asp_bottom_bg_color']}>" : '#f0f0f0',
            textColor:"<{$tpl['asp_bottom_text_color']}>" ? "<{$tpl['asp_bottom_text_color']}>" : '#666'
        }
        $scope.editmenuType = 'article1';
        $scope.menuList = <{$meunList}>?<{$meunList}>: [
            {
                index : 0,
                isShow:true,
                name:'首页',
                type:'index',
                category : '1',
                icon:'/public/wxapp/images/icon_sy.png',
            },
            {
                index : 1,
                isShow:true,
                name:'菜单1',
                type:'article1',
                category :'1',
                icon:'/public/wxapp/images/icon_sy.png',
                content:'富文本1'
            },
            {
                index : 2,
                isShow:true,
                name:'菜单2',
                type:'article2',
                category : '1',
                icon:'/public/wxapp/images/icon_sy.png',
                content:'富文本2'
            },
            {
                index : 3,
                isShow:true,
                name:'菜单3',
                type:'article3',
                category : '1',
                icon:'/public/wxapp/images/icon_sy.png',
                content:'富文本3'
            },
            {
                index : 4,
                isShow:true,
                name:'菜单4',
                type:'article4',
                category : '1',
                icon:'/public/wxapp/images/icon_sy.png',
                content:'富文本4'
            }
        ];

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
                        // $scope.addressStyle.color=realColor;
                        // console.log($scope.addressStyle.color);
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

        $scope.doIconThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            $scope[type][realIndex].icon = imgNowsrc;
            //console.log($scope[type][realIndex]);
        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.jumpInfo.background = imgNowsrc;
            }
        };
        $scope.changeBottomImg=function(){
            if(imgNowsrc){
                $scope.bottomImg = imgNowsrc;
            }
        };
        $scope.changelogoImg=function(){
            if(imgNowsrc){
                $scope.logoImg = imgNowsrc;
            }
        };

        $scope.changevideoImg=function(){
            if(imgNowsrc){
                $scope.videoImg = imgNowsrc;
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
                    type : '106',
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

        $scope.addNewImg = function(){
            var img_length = $scope.indexImg.length;
            var defaultIndex = 0;
            if(img_length>0){
                for (var i=0;i<img_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.indexImg[i].index)){
                        defaultIndex = $scope.indexImg[i].index;
                    }
                }
                defaultIndex++;
            }
            if(img_length>30){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加30张图片',
                    time: 2000
                });
            }else{
                var img_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_45_45.png',
                };
                $scope.indexImg.push(img_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.indexImg);
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

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            console.log(weddingTaocanDetailArray);
            $scope.content = weddingTaocanDetailArray[0];

            for(var i = 0;i<$scope.menuList.length;i++){
                $scope.menuList[i].content = weddingTaocanDetailArray[i+1];
            }


            var data = {
                'title' 	 : $scope.headerTitle,
                'music' 	 : $scope.backgroundMusic,
                'name'       : $scope.shopName,
                'slide'		 : $scope.banners,
                'tpl_id'	 : $scope.tpl_id,
                'mobile'     : $scope.mobile,
                'address'    : $scope.address,
                'longitude'  : $scope.longitude,
                'latitude'   : $scope.latitude,
                'content'    : $scope.content,
                'appointInfo': $scope.appointInfo,
                'jumpInfo'   : $scope.jumpInfo,
                'bottomImg'  : $scope.bottomImg,
                'menuList': $scope.menuList,
                'bottomMenu':$scope.bottomMenu,
                'brief'     : $scope.brief,
                'logo'      : $scope.logoImg,
                'videoImg'      : $scope.videoImg,
                'videoUrl'      : $scope.videoUrl,
                'videoShow'      : $scope.videoShow,
                'imgShow'      : $scope.imgShow,
                'indexImg'      : $scope.indexImg,
                'imgTitle'  : $scope.imgTitle,
                'mapShow'   : $scope.mapShow
            };
            console.log(data);

            $http({
                method: 'POST',
                url:    '/wxapp/single/saveAppletTpl',
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
                if(id==7){
                    $("#menuBox").stop().show();
                    $("#menuBox [data-menu-show]").eq(0).stop().show();
                    $(".bottom-menu-manage [data-menu]").eq(0).addClass('cur-edit');
                }else{
                    $("#menuBox").stop().hide();
                }
            });

            // $('.bottom-menu-manage').on('click', '[data-menu]', function(event) {
            //     var id = $(this).data('type');
            //     $(this).parents('.bottom-menu-manage').find('[data-menu]').removeClass('cur-edit');
            //     $(this).addClass('cur-edit');
            //     console.log($scope.menuList);
            //     console.log(id);
            //     $("[data-menu-show][data-type="+id+"]").stop().show().siblings().stop().hide();
            // });

            $('.bottom-menu-manage').on('click', '[data-menu]', function(event) {
                var id = $(this).data('index');
                $(this).parents('.bottom-menu-manage').find('[data-menu]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                console.log($scope.menuList);
                $("[data-menu-show][data-index="+id+"]").stop().show().siblings().stop().hide();
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
</script>
<{include file="./img-upload-modal.tpl"}>
<{include file="./article-ue-editor.tpl"}>
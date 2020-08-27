<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/setup/css/index.css">
<link rel="stylesheet" href="/public/wxapp/setup/css/style.css?1">
<style>
    /*跳转链接设置样式*/
    .link-setting .activity-manage { padding-right: 40px; }
    .link-setting .activity-manage .edit-txt { padding-top: 0; }
    .link-setting .activity-manage .delete { border-radius: 50%; background-color: #ddd; color: #fff; width: 26px; height: 26px; line-height: 26px; top: 16px; right: 8px; font-weight: normal; }
    .link-setting .activity-manage .add-btn { border-radius: 50%; background-color: #447ef1; color: #fff; width: 26px; height: 26px; line-height: 27px; top: 16px; right: 8px; text-align: center; position: absolute; font-size: 22px; cursor: pointer; }
    .link-setting .activity-manage .edit-txt .input-group-box .cus-input { height: 34px; }
    .edit-right .edit-con{margin-top: 0;}
    .activity .activity-manage .edit-txt .input-group-box .cus-input { width: 77%; height: 34px}
    .activity .activity-manage .edit-txt .input-group-box label { width: 23%; }
    .activity .activity-manage .edit-img img { margin-top: 25px;padding: 6px;border-radius: 50%}
    /*颜色配置相关*/
    .index-con .index-main{height: 465px;}
    .radio-box{padding-top: 3px;}
    .sp-container {background-color: #eee;border: 1px solid #dedede;border-radius: 3px;}
    .sp-palette-container{border-right: 1px solid #dedede;}
    .sp-picker-container{border-left: none;}
    .jt-tips{display: block;margin:8px auto;width: 40px;}
    .other-setting{width: 92%;margin:10px auto;padding: 15px;border:1px solid #eee; box-shadow: 1px 1px 8px #eee;border-radius: 5px;background-color: #fff;}
    .mobile-con .title-bar{background-image: url(/public/wxapp/setup/images/title-bar2.png);}
    .mobile-con .title-bar.white{background-image: url(/public/wxapp/setup/images/title-bar1.png);}
    .other-setting .color-set-box .label-name{width:160px;}
    .fold-menu-set-wrap{position: absolute!important;left: 5px;bottom: 60px}
    .fold-menu-set{ font-size: 12px; background-color: #2e99c9; color: #fff; border-radius: 50px; width: 50px; height: 50px; line-height: 16px; padding: 9px 5px; text-align: center; }
    .sp-container input{background-color: #fff;}
    .page-path-text{
        line-height: 34px;
    }
    .copy-button{
        line-height: 34px;
        font-size: 12px;
        color: #007cf9;
        border: 1px solid #007cf9;
        border-radius: 2px;
        padding: 5px;
        cursor: pointer;
        margin-left: 3px;
    }
    .input-tip{
        font-size: 12px;
        color: #666;
        padding-left: 80px;
        margin-bottom: 10px;
    }
    .fold-menu-set-wrap-right{
        position: absolute!important;
        left: 260px !important;
        bottom: 60px
    }
    .phone-icon-btn{
        padding: 3px 5px !important;
    }
    .phone-icon-input{
        width: 40%;
        display: inline-block;
    }
    .phone-icon-label{
        width: 70px;
        text-align: right;
    }
    /*.alert-success{
        margin-left: 140px;
    }*/
	.preview-page{
	 	margin:0;
	    padding:20px 0;
	}
</style>
<{include file="../common-second-menu.tpl"}>
<div id="mainContent">
	<div class="alert alert-block alert-success">
	    <ol>
	        <li><p>图标库推荐, 点击访问<a href="http://www.iconfont.cn/" target="_blank"> http://www.iconfont.cn </a></p></li>
	    </ol>
	</div>
	<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
	    <div class="mobile-page">
	        <div class="mobile-header"></div>
	        <div class="mobile-con">
	            <div class="title-bar {{topNavinfo.color=='white'?'white':''}}" ng-style="navColorObj">
	                小程序标题
	            </div>
	            <!-- 主体内容部分 -->
	            <div class="index-con">
	                <!-- 首页主题内容 -->
	                <div class="index-main">
						<{if $menuType neq 'weixin'}>
	                    <img src="/public/wxapp/setup/images/top-jt.png" class="jt-tips" alt="箭头提示">
	                    <div class="other-setting">
	                        <div class="color-set-box">
	                            <label class="label-name">导航栏背景颜色：</label>
	                            <div class="right-color">
	                                <input type="text" class="color-input" data-colortype="navcolor" ng-model="topNavinfo.bgColor">
	                            </div>
	                        </div>
	                        <div class="color-set-box">
	                            <label class="label-name">导航栏文字颜色：</label>
	                            <div class="right-color">
	                                <div class="radio-box">
	                                        <span ng-click="changeNavColor($event)">
	                                            <input type="radio" name="navColor" id="navblack" data-navcolor="black" ng-checked="topNavinfo.color=='black'">
	                                            <label for="navblack">黑色</label>
	                                        </span>
	                                    <span ng-click="changeNavColor($event)">
	                                            <input type="radio" name="navColor" id="navwhite" data-navcolor="white" ng-checked="topNavinfo.color=='white'">
	                                            <label for="navwhite">白色</label>
	                                        </span>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
						<{/if}>
	                    <{if in_array($appletCfg['ac_type'],$companyInfo)}>
	                    <{if $appletCfg['ac_type'] neq 18}>
	                    <div data-left-preview data-id="5">
	                        <div class="no-footer-nav" style="height: 60px;  text-align: center;  font-size: 20px;  line-height: 60px;">
	                            点此添加首页公司介绍
	                        </div>
	                    </div>
	                    <{/if}>
	                    <{if $appletCfg['ac_type'] neq 16}>
	                    <div data-left-preview data-id="4">
	                        <div class="no-footer-nav" style="height: 60px;  text-align: center;  font-size: 20px;  line-height: 60px;" ng-if="indexNavs.length<=0">
	                            点此添加首页快捷菜单
	                        </div>
	                        <div style="background: #fff;padding: 0 10px" ng-if="indexNavs.length>0" >
	                            <div class="nav_item" ng-repeat="nav in indexNavs track by $index" style="width: 50%;display: inline-block;padding: 5px;">
	                                <img ng-src="{{nav.imgsrc}}" alt="图标" style="width: 100%">
	                            </div>
	                        </div>
	                    </div>
	                    <{/if}>
	                    <{/if}>
	                    <div class="other-setting">
	                        <div class="color-set-box">
	                            <label class="label-name">底部菜单文字颜色：</label>
	                            <div class="right-color">
	                                <input type="text" class="color-input" data-colortype="color" ng-model="footNavs.color">
	                            </div>
	                        </div>
	                        <div class="color-set-box">
	                            <label class="label-name">底部菜单文字选中颜色：</label>
	                            <div class="right-color">
	                                <input type="text" class="color-input" data-colortype="selectedColor" ng-model="footNavs.selectedColor">
	                            </div>
	                        </div>
	                        <div class="color-set-box">
	                            <label class="label-name">底部菜单背景色：</label>
	                            <div class="right-color">
	                                <input type="text" class="color-input" data-colortype="backgroundColor" ng-model="footNavs.backgroundColor">
	                            </div>
	                        </div>

							<{if $menuType == 'weixin'}>
							<div class="color-set-box" style="display: none">
								<label class="label-name">底部菜单上边框颜色：</label>
								<div class="right-color">
									<div class="radio-box">
										<input type="text" class="color-input" data-colortype="borderStyle" ng-model="footNavs.borderStyle">
									</div>
								</div>
							</div>
							<{else}>
								<div class="color-set-box">
									<label class="label-name">底部菜单上边框颜色：</label>
									<div class="right-color">
										<div class="radio-box">
												<span ng-click="changeBorderColor($event)">
													<input type="radio" name="borderColor" id="black" data-borcolor="black" ng-checked="footNavs.borderStyle=='black'">
													<label for="black">黑色</label>
												</span>
											<span ng-click="changeBorderColor($event)">
													<input type="radio" name="borderColor" id="white" data-borcolor="white" ng-checked="footNavs.borderStyle=='white'">
													<label for="white">白色</label>
												</span>
										</div>
									</div>
								</div>
							<{/if}>


	                    </div>
	                    <img src="/public/wxapp/setup/images/bottom-jt.png" class="jt-tips" alt="箭头提示">
	                </div>
	                <!--
	                <div class="fold-menu-set-wrap" data-left-preview data-id="2">
	                    <div class="no-footer-nav fold-menu-set">
	                        配置折叠菜单
	                    </div>
	                </div>
	                -->
	                <div data-left-preview data-id="3">
	                    <div class="no-footer-nav" style="height: 60px;  text-align: center;  font-size: 20px;  line-height: 60px;" ng-if="footNavs.list.length<=0">
	                        点此添加底部菜单
	                    </div>
	                    <div class="footer_nav_box {{footNavs.borderStyle=='white'?'bortWhite':'bortBlack'}}" ng-if="footNavs.list.length>0" ng-style="colorObj">
	                        <div class="nav_item" ng-repeat="nav in footNavs.list" ng-click="navToggle(nav.pagePath)">
	                            <img ng-src="{{nav.select?nav.selectedIconPath:nav.iconPath}}" alt="图标">
	                            <p style="color:{{nav.select?footNavs.selectedColor:''}}">{{nav.text}}</p>
	                        </div>
	                    </div>
	                </div>
	                <{if in_array($appletCfg['ac_type'],$phoneIcon)}>
	                <div class="fold-menu-set-wrap fold-menu-set-wrap-right" data-left-preview data-id="6">
	                    <div class="no-footer-nav fold-menu-set">
	                        <img src="/public/wxapp/images/icon_bddh.png" alt="" style="width: 80%">
	                    </div>
	                </div>
	                <{/if}>
	            </div>
	        </div>
	        <div class="mobile-footer"><span></span></div>
	    </div>
	    <div class="edit-right" style="margin-left: 360px!important;">
	        <{if $appletCfg['ac_type'] == 6}>
	        <div><span style="color:red;font-size:14px;">注：当底部菜单链接“同城商城”时，需先开通多商家商城插件，开通后入驻商家有独立后台，管理商品、订单。若不开通此插件入驻的商家起展示作用，商家没有独立后台、不能上传管理自己的商品、订单。</span></div>
	        <{/if}>
	        <!--
	        <div class="edit-con" data-right-edit data-id="1">
	            <div class="activity link-setting" >
	                <label style="width: 100%">跳转外链设置<span style="color: red">(小程序跳转外链只支持HTTPS域名)</span></label>
	                <div ui-sortable ng-model="outsideLink">
	                    <div class="activity-manage" style="padding-top: 5px;"  ng-repeat="link in outsideLink">
	                        <div class="delete" ng-click="delIndex('outsideLink',link.index)" ng-hide="$index==0">-</div>
	                        <div class="add-btn" title="添加" ng-show="$index==0" ng-click="addNewLink()">+</div>
	                        <div class="edit-txt">
	                            <div class="input-group-box clearfix">
	                                <label for="" ng-model="link.title">{{link.title}}</label>
	                                <input type="text" class="cus-input" ng-model="link.link">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="text-center" style="margin-top: 10px;">
	                    <span class="btn btn-sm btn-green" ng-click="saveOutsideLink()">保存链接</span>
	                </div>
	            </div>
	        </div>
	        -->
	        <{if $templateSave}>
	        <div class="edit-con">
	            <div class="activity link-setting" style="display: block">
	                <label style="width: 100%">跳转自定义页面设置<span style="color: red"></span></label>
	                <div ui-sortable ng-model="outsideLink">
	                    <div class="activity-manage" style="padding-top: 5px;"  ng-repeat="link in customPageLink">
	                        <div class="delete" ng-click="delIndex('customPageLink',link.index)" ng-hide="$index==0">-</div>
	                        <div class="add-btn" title="添加" ng-show="$index==0" ng-click="addNewPage()">+</div>
	                        <div class="edit-txt">
	                            <div class="input-group-box clearfix">
	                                <label for="" ng-model="link.title">{{link.title}}</label>
	                                <select class="cus-input form-control" ng-model="link.link"  ng-options="x.id as x.name for x in templateList" ></select>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="text-center" style="margin-top: 10px;">
	                    <span class="btn btn-sm btn-green" ng-click="saveCustomPage()">保存页面</span>
	                </div>
	            </div>
	        </div>
	        <{/if}>
	        <div class="introduce-tips">
	        	<div class="tips-btn">
	        		<span>介绍</span><img src="/public/site/img/tips.png" alt="图标" />
	        	</div>
	        	<div class="tips-con-wrap">
	        		<div class="tips-con">
		        		<div class="triangle_border_up"><span></span></div>
		        		<div class="con">该处修改底部菜单需要保存后重新提交审核（在小程序管理-》审核管理点击）</div>
		        	</div>
	        	</div>
	        </div>	
	        <div class="edit-con" style="margin-top: 10px;">
	            <div class="activity" style="display:block;" data-right-edit data-id="3">
	                <label style="width: 100%">底部图标<span style="color: red">(底部导航链接不能重复，且必须有一个链接到首页)</span></label>
					<span style="color:red">该处修改底部菜单需要保存后重新提交审核（在小程序管理->审核管理点击）</span>
	                <div ui-sortable ng-model="footNavs.list">
	                    <div class="activity-manage" ng-repeat="nav in footNavs.list">
	                        <div class="delete" ng-click="delIndex('list',nav.index,'footNavs')">×</div>
	                        <div class="edit-txt">
	                            <div class="input-group-box clearfix">
	                                <label for="">导航图标：</label>
	                                <div class="right-icon">
	                                    <div class="curicon-box">
	                                        <img ng-src="{{nav.iconPath}}" alt="图标">
	                                        <img ng-src="{{nav.selectedIconPath}}" alt="图标">
	                                    </div>
	                                    <span class="chooseicon" data-toggle="modal" ng-click="chooseIcon(nav.index)">+选择图标</span>
	                                    <div class="radio-box" style="float: right;">
						    				<span style="margin:0;" ng-click="changeSetIndex(nav.index)">
						    					<input type="radio" name="setindex" id="setindex{{$index}}" ng-model="nav.setIndex" ng-checked="nav.setIndex=='1'">
						    					<label for="setindex{{$index}}" style="width: 91px;line-height: 27px;">设置为首页</label>
						    				</span>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="input-group-box clearfix">
	                                <label for="">导航名称：</label>
	                                <input type="text" class="cus-input" minlength="1" maxlength="5" ng-model="nav.text">
	                            </div>
	                            <div class="input-group-box clearfix">
	                                <label for="">链接到：</label>
	                                <select class="cus-input" ng-model="nav.pagePath" ng-options="x.path as x.name for x in pages" style="width: 62%;"></select>
	                                <input type="hidden" id="page-path_{{nav.index}}" value="{{nav.pagePath}}">
	                                <span class="copy-button" data-clipboard-action="copy" data-clipboard-text="{{nav.pagePath}}">复制路径</span>
	                                <!--<select class="cus-input" ng-model="nav.pagePath" ng-options="x.path as x.name for x in pages" ng-change="getId('list',nav.index,nav.pagePath)"></select>-->
	                            </div>
	                            <!--
	                            <div class="input-group-box clearfix">
	                                <label for="">页面路径：</label>
	                                <span class="page-path-text">{{nav.pagePath}}</span>
	                            </div>
	                            -->
	                        </div>
	                    </div>
	                </div>
	                <div class="add-box" title="添加" ng-click="addNewNav()"></div>
	                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=228&extra=" target="_blank" style="color: red;margin-left:15%">首次添加底部导航请仔细查看教程，<span style="color: blue">点击查看</span></a>
	            </div>
	            <div class="activity" data-right-edit data-id="2">
	                <label style="width: 100%">折叠菜单<span style="color: red">(折叠菜单配置需要点击下方保存，可不必发布新版本即可生效)</span></label>
	                <div class="color-set-box" style="margin-bottom: 30px;">
	                    <label class="label-name" style="font-size: 16px;font-weight: bold;float: left;">展示页面：</label>
	                    <div class="right-color">
	                        <div class="radio-box" style="width: 80%;float: left;">
						    	<span ng-click="changeInformationShow($event)">
						    		<input type="radio" name="suspensionShow" id="indexShow" data-show="0" ng-checked="suspensionShow=='0'">
						    		<label for="indexShow">仅首页</label>
						    	</span>
	                            <span ng-click="changeInformationShow($event)">
						    		<input type="radio" name="suspensionShow" id="allShow" data-show="1" ng-checked="suspensionShow=='1'">
						    		<label for="allShow">所有页面</label>
						    	</span>
	                        </div>
	                    </div>
	                </div>
	
	                <div class="color-set-box" style="float:left;margin: 25px 0;width: 100%;">
	                    <label class="label-name" style="font-size: 16px;font-weight: bold;float: left;">折叠图标：</label>
	                    <div class="right-color">
	                        <div class="cropper-box" data-width="300" data-height="300" >
	                            <img style="margin: inherit!important;" src="<{if $zdIcon}><{$zdIcon}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" width=15%>
	                            <input type="hidden" id="applet-logo"  class="avatar-field bg-img" name="applet-logo" value="<{if $zdIcon}><{$zdIcon}><{/if}>"/>
	                        </div>
	                    </div>
	                </div>
	
	                <div ui-sortable ng-model="footNavs.list">
	                    <div class="activity-manage" ng-repeat="fenleiNav in fenleiNavs">
	                        <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
	                        <div class="edit-img" style="width: 20%;float: left">
	                            <div>
	                                <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
	                                <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
	                            </div>
	                        </div>
	
	                        <div class="edit-txt" style="float: right;width: 80%">
	                            <div class="input-group-box clearfix">
	                                <label for="">菜单名称：</label>
	                                <input type="text" class="cus-input" minlength="1" maxlength="5" ng-model="fenleiNav.title">
	                            </div>
	                            <div class="input-group-box clearfix">
	                                <label for="">链接类型：</label>
	                                <select class="cus-input" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
	                                <label for="">菜　　单：</label>
	                                <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.path as x.name for x in pages"></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
	                                <label for="">单　　页：</label>
	                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in information" ></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
	                                <label for="">列　　表：</label>
	                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
	                                <label for="">外　　链：</label>
	                                <input type="text" class="cus-input" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
	                                <label for="">小 程 序：</label>
	                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
	                <div class="save-btn-box" role="alert" style="text-align: center;margin-top: 20px;"><button class="btn btn-blue btn-sm" style="text-align: center;margin-top: 20px;" ng-click="savefenleiNavs()">  保 存 </button></div>
	            </div>
	            <div class="activity" data-right-edit data-id="4">
	                <label style="width: 100%">首页快捷导航菜单(图片大小 370*160 )<span style="color: red">(快捷导航菜单配置需要点击下方保存，可不必发布新版本即可生效)</span></label>
	                <div class="isOn" style="overflow: hidden">
	                    <span>是否开启：</span>
	                    <span class='tg-list-item' style="width: 82%;float: right;margin-bottom: 10px;">
	                        <input class='tgl tgl-light' id='menu_start' type='checkbox' ng-model="indexMenuIsOn">
	                        <label class='tgl-btn' for='menu_start'></label>
	                                   <span style="color: red;font-size: 14px;float: left;margin-top:-25px;margin-left:70px;">注:该模块开启后在首页显示</span>
	                    </span>
	                </div>
	                <div class="input-group" style="margin-bottom: 10px;width: 100%">
	                    <label for="" style="width: 17%">标　　题：</label>
	                    <input type="text" class="cus-input" style="width:83%"  placeholder="请输入首页快捷导航菜单标题" maxlength="6" ng-model="indexMenuTitle">
	                </div>
	                <div ui-sortable ng-model="indexNavs">
	                    <div class="activity-manage" ng-repeat="indexNav in indexNavs track by $index">
	                        <div class="delete" ng-click="delIndex('indexNavs',indexNav.index)">×</div>
	                        <div class="edit-img">
	                            <div>
	                                <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="370" data-height="160" imageonload="doThis('indexNavs',indexNav.index)" data-dom-id="upload-index{{$index}}" id="upload-index{{$index}}"  ng-src="{{indexNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;border-radius: 0">
	                                <input type="hidden" id="index{{$index}}"  class="avatar-field bg-img" name="index{{$index}}" ng-value="indexNav.imgsrc"/>
	                            </div>
	                        </div>
	                        <div class="edit-txt">
	                            <div class="input-group-box clearfix">
	                                <label for="">菜单名称：</label>
	                                <input type="text" class="cus-input" minlength="1" maxlength="10" ng-model="indexNav.title">
	                            </div>
	                            <div class="input-group-box clearfix">
	                                <label for="">链接类型：</label>
	                                <select class="cus-input" ng-model="indexNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="indexNav.type==104">
	                                <label for="">菜　　单：</label>
	                                <select class="cus-input" ng-model="indexNav.link" ng-options="x.path as x.name for x in pages"></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="indexNav.type==1">
	                                <label for="">单　　页：</label>
	                                <select class="cus-input" ng-model="indexNav.link"  ng-options="x.id as x.title for x in information" ></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="indexNav.type==2">
	                                <label for="">列　　表：</label>
	                                <select class="cus-input" ng-model="indexNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="indexNav.type==3">
	                                <label for="">外　　链：</label>
	                                <input type="text" class="cus-input" ng-value="indexNav.link" ng-model="indexNav.link" />
	                            </div>
	                            <div class="input-group-box clearfix" ng-show="indexNav.type==106">
	                                <label for="">小 程 序：</label>
	                                <select class="cus-input" ng-model="indexNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="add-box" title="添加" ng-click="addNewIndexNav()"></div>
	                <div class="save-btn-box" role="alert" style="text-align: center;margin-top: 20px;"><button class="btn btn-blue btn-sm"  ng-click="saveIndexNavs()">  保 存 </button></div>
	            </div>
	            <div class="address" data-right-edit data-id="5">
	                <label>联系地址<span style="color: red">(联系地址配置需要点击下方保存，可不必发布新版本即可生效)</span></label>
	                <div class="fenleinav-manage top-manage">
	                    <div class="isOn" style="overflow: hidden">
	                        <span>是否开启：</span>
	                        <span class='tg-list-item' style="width: 82%;float: right;margin-bottom: 10px;">
	                        <input class='tgl tgl-light' id='sms_start' type='checkbox' ng-model="contact.isOn">
	                        <label class='tgl-btn' for='sms_start'></label>
	                                                        <span style="color: red;font-size: 14px;float: left;margin-top:-25px;margin-left:70px;">注:该模块开启后在首页显示</span>
	                    </span>
	                    </div>
	                    <div class="shopintrobg-manage">
	                        <label for="">公司logo：</label>
	                        <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="160" data-height="160" imageonload="changeLogo()" data-dom-id="upload-logoImg" id="upload-logoImg{{$index}}"  ng-src="{{contact.logo}}"  height="100%" style="display:inline-block;width: 80px;border-radius: 50%;margin-bottom: 10px;">
	                        <input type="hidden" id="logoImg"  class="avatar-field bg-img" name="logoImg" ng-value="contact.logo"/>
	                        <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="160" data-height="160" data-dom-id="upload-logoImg">修改logo<span>(建议尺寸160*160)</span></a>
	                    </div>
	                    <div class="input-group-box">
	                        <label for="">公司名称：</label>
	                        <input type="text" class="cus-input" style="width: 80%"  ng-model="contact.name">
	                    </div>
	                    <div class="input-group-box">
	                        <label for="">公司简介：</label>
	                        <textarea rows="4" placeholder="请输入公司简介" style="border: 1px solid #ddd;border-radius: 4px;width: 80%;margin-top: 10px;margin-bottom: 10px;padding: 5px" ng-change="changeBrief()" ng-model="contact.brief"></textarea>
	                    </div>
	                    <div class="input-group-box">
	                        <label for="">公司详情：</label>
	                        <select class="cus-input" ng-model="contact.link" style="height:38px;width: 80%;margin-bottom: 2px"  ng-options="x.id as x.title for x in information" ></select>
	                        <div class="input-tip">请在 模块管理->资讯管理 中添加详情文章</div>
	                    </div>
	                    <div class="input-group-box">
	                        <label for="">联系电话：</label>
	                        <input type="text" class="cus-input"  style="width: 80%"  placeholder="请输入联系电话" ng-model="contact.mobile">
	                    </div>
	                    <div class="input-group-box" style="margin-bottom: 10px;margin-top: 10px">
	                        <div style="width: 100%;overflow: hidden;margin-bottom: 10px;">
	                            <label style="width: 75%;display: inline-block;">公司详细地址：</label>
	                            <div class="text-right" style="width: 20%;display: inline-block;vertical-align: middle;">
	                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="contact.lng">
	                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="contact.lat">
	                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
	                            </div>
	                        </div>
	                        <textarea rows="2" placeholder="请输入详细地址" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 96%" ng-change="changeBrief()" ng-model="contact.address"></textarea>
	                    </div>
	                    <div id="container" style="width: 100%;height: 300px"></div>
	                </div>
	                <div class="save-btn-box" role="alert" style="text-align: center;margin-top: 20px;"><button class="btn btn-blue btn-sm"  ng-click="saveCompanyInfo()">  保 存 </button></div>
	            </div>
	            <div class="activity" data-right-edit data-id="6">
	                <label style="width: 100%">电话悬浮图标</label>
	                <div class="input-group-box">
	                    <label for="" class="phone-icon-label">当前状态：</label>
	                    <span style="color: green;" ng-if="phoneIconIsOn==1">显示</span>
	                    <span style="color: red" ng-if="phoneIconIsOn==0">隐藏</span>
	
	                    <span style="text-align: center;display: inline-block;margin-left: 20px">
	                            <button class="btn btn-green btn-sm phone-icon-btn"  ng-click="savePhoneIcon()" ng-if="phoneIconIsOn==0">  显示图标 </button>
	                            <button class="btn btn-danger btn-sm phone-icon-btn"  ng-click="savePhoneIcon()" ng-if="phoneIconIsOn==1">  隐藏图标 </button>
	                        </span>
	
	                </div>
	                <div class="input-group-box" style="margin: 10px 0">
	                    <label for="" class="phone-icon-label">联系电话：</label>
	                    <input type="text" value="<{$curr_shop['s_phone']}>" class="form-control phone-icon-input" id="shopPhone">
	                </div>
	                <div class="isOn" style="overflow: hidden">
	                    <span style="width: 100%;text-align: center;display: inline-block">
	                        <button class="btn btn-blue btn-sm"  ng-click="saveShopPhone()" >  保存 </button>
	                    </span>
	                </div>
	            </div>
	        </div>
	    </div>
	    <!-- 保存 -->
	    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveFootNavs()">  保 存 </button></div>
	    <!-- 模态框（Modal） -->
	    <div class="modal fade" id="iconChooseModal" tabindex="-1" role="dialog" aria-labelledby="iconChooseLabel" aria-hidden="true">
	        <div class="modal-dialog">
	            <div class="modal-content">
	                <div class="modal-header" style="padding: 10px 15px;">
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:1px">&times;</button>
	                    <h4 class="modal-title" id="iconChooseLabel">选择导航图标</h4>
	                </div>
	                <div class="modal-body" style="padding: 10px;max-height: 380px;overflow: auto;">
	                    <div class="tabbable" >
	                        <ul class="nav nav-tabs" id="myTab">
	                            <li class="active">
	                                <a data-toggle="tab" href="#style1">
	                                    <{$applet_type}>
	                                </a>
	                            </li>
	                            <!--<li>
	                                <a data-toggle="tab" href="#style2">
	                                    冷色系
	                                </a>
	                            </li>
	                            -->
	                        </ul>
	                        <div class="tab-content" id="iconchoose-content">
	                            <div id="style1" class="tab-pane in active">
	                                <div class="iconchoose-box">
	                                    <div class="iconchoose-item">
	                                        <!--<p class="title-name">微商城</p>-->
	                                        <ul class="iconlist">
	                                            <{foreach $icon_list as $key=>$val}>
	                                            <li>  <!-- class="active"-->
	                                                <div class="iconwrap">
	                                                    <img src="/public/wxapp/icon/<{$val['ai_path']}>.png" class="iconpath" alt="图标">
	                                                    <img src="/public/wxapp/icon/<{$val['ai_path']}>_d.png" class="selectediconpath" alt="图标">
	                                                </div>
	                                            </li>
	                                            <{/foreach}>
	                                        </ul>
	                                    </div>
	                                </div>
	                            </div>
	                            <!--
	                            <div id="style2" class="tab-pane">
	                                <div class="iconchoose-box">
	                                    <div class="iconchoose-item">
	                                        <p class="title-name">冷色系一</p>
	                                        <ul class="iconlist">
	                                            <li>
	                                                <div class="iconwrap">
	                                                    <img src="/public/wxapp/setup/images/shouye1@2x.png" class="iconpath" alt="图标">
	                                                    <img src="/public/wxapp/setup/images/shouye@2x.png" class="selectediconpath" alt="图标">
	                                                </div>
	                                            </li>
	                                            <li>
	                                                <div class="iconwrap">
	                                                    <img src="/public/wxapp/setup/images/huodong1@2x.png" class="iconpath" alt="图标">
	                                                    <img src="/public/wxapp/setup/images/huodong@2x.png" class="selectediconpath" alt="图标">
	                                                </div>
	                                            </li>
	                                            <li>
	                                                <div class="iconwrap">
	                                                    <img src="/public/wxapp/setup/images/liuyan1@2x.png" class="iconpath" alt="图标">
	                                                    <img src="/public/wxapp/setup/images/liuyan@2x.png" class="selectediconpath" alt="图标">
	                                                </div>
	                                            </li>
	                                        </ul>
	                                    </div>
	                                </div>
	                            </div>
	                            -->
	                        </div>
	                    </div>
	
	                </div>
	                <div class="modal-footer" style="padding: 10px 15px;margin-top: 0;">
	                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
	                    <button type="button" class="btn btn-sm btn-primary" ng-click="saveChooseicon()">确定</button>
	                </div>
	            </div><!-- /.modal-content -->
	        </div><!-- /.modal -->
	    </div>
	
	</div>
</div>
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script>
    $(function () {
        // 定义一个新的复制对象
        // var clip = new ZeroClipboard( $('.copy-button'), {
        //     moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
        // } );
        // // 复制内容到剪贴板成功后的操作
        // clip.on( 'complete', function(client, args) {
        //     console.log("复制成功的内容是："+args.text);
        //     layer.msg('复制成功');
        // } );
        // 定义一个新的复制对象
        var clipboard = new ClipboardJS('.copy-button');
        // 复制内容到剪贴板成功后的操作
        clipboard.on('success', function(e) {
            console.log(e);
            layer.msg('复制成功');
        });
        clipboard.on('error', function(e) {
            console.log(e);
            console.log('复制失败');
        });
    });

    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.pages = <{$page_list}>;
        $scope.outsideLink = <{$outsideLink}>;
        $scope.customPageLink = <{$customPageLink}>;
        $scope.templateList = <{$templateList}>;
        $scope.footNavs = {
                'color':'<{$bottom_menu['color']}>',
                'selectedColor':'<{$bottom_menu['selectedColor']}>',
                'borderStyle':'<{$bottom_menu['borderStyle']}>',   //black或者white
                'backgroundColor':'<{$bottom_menu['backgroundColor']}>',
                list:<{$list}>
    };
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;
        $scope.fenleiNavs = <{$suspensionMenu}>;
        $scope.indexNavs = <{$indexMenu}>;
        $scope.indexMenuTitle = '<{$indexMenuTitle}>';
        $scope.indexMenuIsOn = <{if $indexMenuIsOn}> true <{else}> false <{/if}>;
        $scope.information = <{$information}>;
        $scope.suspensionShow = <{$suspensionMenuShow}>;
        $scope.topNavinfo = <{$topNavinfo}>;
        $scope.contact = <{$contact}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.navColorObj = {
            "background-color":$scope.topNavinfo.bgColor
        };
        $scope.templateList = <{$templateList}>;
        $scope.logoImg = '/public/manage/img/zhanwei/fenleinav.png';
        $scope.phoneIconIsOn = <{$phoneIconIsOn}> ;
        $scope.navToggle = function(pagePath){
            var navs = $scope.footNavs;
            for(var i=0;i<navs.list.length;i++){
                navs.list[i].select = false;
                if(navs.list[i].pagePath==pagePath){
                    navs.list[i].select = true;
                }
            }
        };
        $scope.addNewNav = function(){
            var nav_length = $scope.footNavs.list.length;
            var defaultIndex = 0;
            if(nav_length>0){
                for (var i=0;i<nav_length;i++){
                    if(defaultIndex < $scope.footNavs.list[i].index){
                        defaultIndex = $scope.footNavs.list[i].index;
                    }
                }
                defaultIndex++;
            }
            if(nav_length>=5){
                layer.msg('最多只能添加5个导航');
            }else{
                var nav_Default = {
                    index: defaultIndex,
                    pagePath: $scope.pages.length>0?$scope.pages[0].path:'',
                    iconPath: "/public/wxapp/icon/<{$icon_list[0]['ai_path']}>.png",
                    selectedIconPath: "/public/wxapp/icon/<{$icon_list[0]['ai_path']}>_d.png",
                    text: "默认标题",
                    // pagePathName:$scope.pages.length>0?$scope.pages[0].name:''
                };
                $scope.footNavs.list.push(nav_Default);
            }
            console.log($scope.footNavs.list);
        };
        $scope.changeBorderColor=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var value = that.data('borcolor');
            that.get(0).checked = true;
            $scope.footNavs.borderStyle = value;
            console.log($scope.footNavs.borderStyle);
        };
        $scope.changeNavColor=function($event){
            $event.preventDefault();
            var that = $($event.target).prev('input:eq(0)');
            var value = that.data('navcolor');
            that.get(0).checked = true;
            $scope.topNavinfo.color = value;
            console.log($scope.topNavinfo.color);
        };
        /*获取设置首页数据*/
        $scope.changeSetIndex=function(index){
            var nav_length = $scope.footNavs.list.length;
            if(nav_length>0){
                for (var i=0;i<nav_length;i++){
                    if(index == $scope.footNavs.list[i].index){
                        $scope.footNavs.list[i].setIndex = 1;
                    }else{
                        $scope.footNavs.list[i].setIndex = 0;
                    }
                }
            }
        };
        $scope.changeInformationShow=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var value = that.data('show');
            that.get(0).checked = true;
            $scope.suspensionShow = value;
            console.log($scope.suspensionShow);
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
        /*添加新的跳转外链的地址*/
        $scope.addNewLink = function(){
            var link_length = $scope.outsideLink.length;
            var defaultIndex = 0;
            if(link_length>0){
                for (var i=0;i<link_length;i++){
                    if(defaultIndex < parseInt($scope.outsideLink[i].index)){
                        defaultIndex = parseInt($scope.outsideLink[i].index);
                    }
                }
                defaultIndex++;
            }
            var title_var = link_length+1;
            if(link_length>=5){
                layer.msg('最多只能添加5个外链地址');
            }else{
                var link_Default = {
                    index: defaultIndex,
                    link: "",
                    title:'外链地址'+title_var
                };
                $scope.outsideLink.push(link_Default);
            }
            console.log($scope.outsideLink);
        };

        /*添加新的自定义页面*/
        $scope.addNewPage = function(){
            var link_length = $scope.customPageLink.length;
            var defaultIndex = 0;
            if(link_length>0){
                for (var i=0;i<link_length;i++){
                    if(defaultIndex < parseInt($scope.customPageLink[i].index)){
                        defaultIndex = parseInt($scope.customPageLink[i].index);
                    }
                }
                defaultIndex++;
            }
            var title_var = link_length+1;
            if(link_length>=5){
                layer.msg('最多只能添加5个自定义页面');
            }else{
                var link_Default = {
                    index: defaultIndex,
                    link: "",
                    title:'自定义页面'+title_var
                };
                $scope.customPageLink.push(link_Default);
            }
            console.log($scope.customPageLink);
        };

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
        };

        $scope.initColor = function(obj,colorVal,type){
            obj.spectrum({
                color: colorVal,
                showButtons: false,
                showInput: true,
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxPaletteSize: 10,
                preferredFormat: "hex",
                move: function (color) {
                    var realColor = color.toHexString();
                    var colortype = $(obj)[0].dataset.colortype;
                    console.log(colortype);
                    if(colortype=='navcolor'){
                        $scope.topNavinfo.bgColor = realColor;
                        $scope.navColorObj = {
                            "background-color":$scope.topNavinfo.bgColor
                        }
                        console.log($scope.navColorObj);
                    }else{
                        $scope.footNavs[colortype] = realColor;
                        $scope.$apply(function(){
                            $scope.colorObj = {
                                "color":$scope.footNavs.color,
                                "background-color":$scope.footNavs.backgroundColor
                            }
                            $scope.colorSelectObj = {
                                "color":$scope.footNavs.selectedColor
                            }
                        });
                        console.log($scope.footNavs);
                    }
                },
                palette: [
                    ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", "rgb(153, 153, 153)","rgb(183, 183, 183)",
                        "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(239, 239, 239)", "rgb(243, 243, 243)", "rgb(248, 248, 248)", "rgb(255, 255, 255)"],
                    ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)", "rgb(0, 153, 255)"],
                    ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                        "rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
                        "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",
                        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
                ]
            });
        };
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
            if(fenleiNav_length>=10){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加10个折叠菜单',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    type : '1',
                    link : ''
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.fenleiNavs);
        };
        /*添加首页导航方法*/
        $scope.addNewIndexNav = function(){
            var indexNav_length = $scope.indexNavs.length;
            var defaultIndex = 0;
            if(indexNav_length>0){
                for (var i=0;i<indexNav_length;i++){
                    if(defaultIndex < $scope.indexNavs[i].index){
                        defaultIndex = $scope.indexNavs[i].index;
                    }
                }
                defaultIndex++;
            }
            if(indexNav_length>=4){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加4个首页菜单',
                    time: 2000
                });
            }else{
                var indexNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_36.png',
                    title: '默认标题',
                    type : '1',
                    link : ''
                };
                $scope.indexNavs.push(indexNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
        };
        $scope.chooseIcon = function(index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            console.log(index);
            realIndex = $scope.getRealIndex($scope.footNavs.list,index);
            $scope.curEditIndex = realIndex;
            console.log(realIndex);
            $("#iconChooseModal").modal('show');
        };
        $scope.saveChooseicon = function(){
            var elem = $('#iconchoose-content').find('li.active');
            var iconPath = elem.find('img.iconpath').attr("src");
            var selectedIconPath = elem.find('img.selectediconpath').attr("src");
            var index = $scope.curEditIndex;
            console.log($scope.curEditIndex);
            $scope.footNavs.list[index].iconPath = iconPath;
            $scope.footNavs.list[index].selectedIconPath = selectedIconPath;
            console.log($scope.footNavs);
            $("#iconChooseModal").modal('hide');
        };
        //保存首页导航
        $scope.saveIndexNavs = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'indexMenu'  :$scope.indexNavs,
                'indexMenuTitle'  :$scope.indexMenuTitle,
                'indexMenuIsOn'   :$scope.indexMenuIsOn
            };
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveIndexMenu',
                data:   data
            }).then(function(response) {
                layer.close(index);
                if(response.data.ec==200){
                    layer.msg(response.data.em);
                }else {
                    layer.msg(response.data.em);
                }
            });
        };
        //保存公司信息
        $scope.saveCompanyInfo = function(){
            if($scope.contact.name==''){
                layer.msg('请填写公司名称');
                return false;
            }
            if($scope.contact.logo==''){
                layer.msg('请上传公司logo');
                return false;
            }
            if($scope.contact.mobile==''){
                layer.msg('请填写公司联系电话');
                return false;
            }
            if($scope.contact.address==''){
                layer.msg('请填写公司地址');
                return false;
            }
            if($scope.contact.link=='' || $scope.contact.link==0){
                layer.msg('请选择公司详情');
                return false;
            }
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'companyInfo'  :$scope.contact
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveCompanyInfo',
                data:   data
            }).then(function(response) {
                layer.close(index);
                if(response.data.ec==200){
                    layer.msg(response.data.em);
                }else {
                    layer.msg(response.data.em);
                }
            });
        }
        //保存悬浮导航
        $scope.savefenleiNavs = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'suspensionMenu'  :$scope.fenleiNavs,
                'suspensionShow'  :$scope.suspensionShow,
                'zdIcon'          :document.getElementById('applet-logo').value
            };
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveSuspensionMenu',
                data:   data
            }).then(function(response) {
                layer.close(index);
                if(response.data.ec==200){
                    layer.msg(response.data.em);
                }else {
                    layer.msg(response.data.em);
                }
            });
        }
        // 保存按钮
        $scope.saveFootNavs = function(){
            var isIndex = false;
            if($scope.footNavs.list.length<2){
                layer.msg('至少需要添加两个导航');
                return;
            }
            for (var i=0;i<$scope.footNavs.list.length;i++){
                if($scope.footNavs.list[i].pagePath=='pages/index/index'){
                    isIndex = true;
                }
            }
            if(!isIndex){
                layer.msg('必须有一个链接到首页');
                return;
            }
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'color'           :$scope.footNavs.color,
                'selectedColor'   :$scope.footNavs.selectedColor,
                'borderStyle'     :$scope.footNavs.borderStyle,//black或者white
                'backgroundColor' :$scope.footNavs.backgroundColor,
                'list'            :$scope.footNavs.list,
                'suspensionMenu'  :$scope.fenleiNavs,
                'suspensionShow'  :$scope.suspensionShow,
                'navColor'        :$scope.topNavinfo.color,
                'navBackground'   :$scope.topNavinfo.bgColor,
                'indexMenu'       :$scope.indexNavs,
                'indexMenuTitle'  :$scope.indexMenuTitle,
                'indexMenuIsOn'   :$scope.indexMenuIsOn,
                'companyInfo'     :$scope.contact              //公司信息
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveBottomMenu',
                data:   data
            }).then(function(response) {
                layer.close(index);
                if(response.data.ec==200){
                    layer.confirm(response.data.em, {
                        btn: ['前往发布新版本','暂不发布'] //按钮
                    }, function(){
                        location.replace('/wxapp/setup/code#cdgx');
                    }, function(){

                    });
                }else {
                    layer.msg(response.data.em);
                }
            });
        };

        // 保存按钮
        $scope.saveOutsideLink = function(){
            console.log($scope.outsideLink);
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var link_data = {
                'outside'  :$scope.outsideLink
            };
            console.log(link_data);
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveOutsideLink',
                data:   link_data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                location.replace('/wxapp/setup/bottomMenu');
            });
        };

        // 保存按钮
        $scope.saveCustomPage = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var link_data = {
                'customPage'  :$scope.customPageLink
            };
            console.log(link_data);
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveCustomPageLink',
                data:   link_data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                location.replace('/wxapp/setup/bottomMenu');
            });
        };
        //保存首页电话图标开关
        $scope.savePhoneIcon = function () {
            console.log($scope.phoneIconIsOn);
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var phone_data = {
                'phoneIcon' :   $scope.phoneIconIsOn
            };
            $http({
                method: 'POST',
                url:    '/wxapp/setup/savePhoneIconOpen',
                data:   phone_data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                if(response.data.ec == 200){
                    if($scope.phoneIconIsOn == 1){
                        $scope.phoneIconIsOn = 0;
                    }else{
                        $scope.phoneIconIsOn = 1;
                    }
                }
            });
        };


        //保存首页电话图标电话
        $scope.saveShopPhone = function () {

            var shopPhone = $("#shopPhone").val();
            if(!shopPhone){
                layer.msg('请填写联系电话');
                return false;
            }
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var phone_data = {
                'shopPhone' :   shopPhone
            };
            $http({
                method: 'POST',
                url:    '/wxapp/setup/saveShopPhone',
                data:   phone_data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $("input.color-input").each(function(index, el) {
                var obj = $(this);
                var type = obj.data('type');
                var val = obj.val();
                console.log(val);
                $scope.initColor(obj,val,type);
            });
            $("#iconchoose-content").on('click', 'li', function(event) {
                event.preventDefault();
                $(this).parents('#iconchoose-content').find('li').removeClass('active');
                $(this).addClass('active');
            });
        });
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
            if($scope.contact.lng && $scope.contact.lat && $scope.contact.address){
                addMarker($scope.contact.lng,$scope.contact.lat,$scope.contact.address);
            }
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
                        }
                    });
                });
            });
            //搜索地图位置
            $('.btn-map-search').on('click',function(){
                var addr     = $('#addr').val();
                if($scope.contact.address){
                    console.log($scope.contact.address);
                    AMap.service('AMap.Geocoder',function(){ //回调函数
                        //实例化Geocoder
                        geocoder = new AMap.Geocoder({
                            'city'   : '全国', //城市，默认：“全国”
                            'radius' : 1000   //范围，默认：500
                        });
                        //TODO: 使用geocoder 对象完成相关功能
                        //地理编码,返回地理编码结果
                        geocoder.getLocation($scope.contact.address, function(status, result) {
                            console.log(result);
                            if (status === 'complete' && result.info === 'OK') {
                                var loc_lng_lat = result.geocodes[0].location;
                                addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),$scope.contact.address);
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
                $scope.contact.address   = address;
                $scope.contact.lng = lng;
                $scope.contact.lat  = lat;
                $('#details-address').val(address);
                $('#lng').val(lng);
                $('#lat').val(lat);
                console.log(address);
                console.log(lng);
                console.log(lat);

            }


        });
        $scope.changeLogo=function(){
            if(imgNowsrc){
                $scope.contact.logo = imgNowsrc;
            }
        }
        $scope.doThis=function(type,index){
            var typeArr = type.split('.');
            var realIndex=-1;
            if(typeArr.length>1){
                realIndex = $scope.getRealIndex($scope[typeArr[0]][typeArr[1]],index);
                $scope[typeArr[0]][typeArr[1]][realIndex].imgsrc = imgNowsrc;
            }else{
                realIndex = $scope.getRealIndex($scope[typeArr[0]],index);
                $scope[typeArr[0]][realIndex].imgsrc = imgNowsrc;
            }
        };
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
<{include file="../img-upload-modal.tpl"}>

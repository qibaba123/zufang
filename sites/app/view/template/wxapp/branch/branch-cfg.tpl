<link rel="stylesheet" href="/public/manage/css/memberHome.css">
<link rel="stylesheet" href="/public/manage/branch/css/index.css">
<link rel="stylesheet" href="/public/manage/branch/css/style.css">
<style type="text/css">
    .tab-content img{
        margin: 0 auto;
    }
    .apply-info{
        margin-top: 10px;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div  id="mainContent" >
    <div ng-app="branchApp" ng-controller="branchCtrl">
        <div class="space-6" style="color: red;" ng-show="tip" ng-bind="tip"></div>
        <div class="preview-page" style="padding-bottom:60px;">
            <div class="mobile-page">
                <div class="mobile-header"></div>
                <div class="mobile-con">
                    <div class="title-bar" ng-bind="pageManage.pageTitle">

                    </div>
                    <!-- 主体内容部分 -->
                    <div class="index-con">
                        <!-- 首页主题内容 -->
                        <div class="index-main">
                            <div class="page-maincon">
                                <div class="image">
                                    <img ng-src="{{pageManage.adImgSrc}}" alt="图片">
                                </div>
                                <div class="apply-info">
                                    <p>{{pageManage.welcomeText}}</p>
                                    <p>邀请人：<span>阿兰</span>（请核对）</p>
                                    <form action="" id="apply-form">
                                        <div class="input-box" ng-show="pageManage.infoShow.realName==1">
                                            <input type="text" required="required" placeholder="请填写真实姓名" name="fxname">
                                        </div>
                                        <div class="input-box" ng-show="pageManage.infoShow.telPhone==1">
                                            <input type="tel" required="required" maxlength="11" placeholder="请填写手机号码，方便联系" name="fxphone">
                                        </div>
                                        <div class="input-box" ng-show="pageManage.infoShow.weixin==1">
                                            <input type="text" required="required" placeholder="请填写微信号" name="fxwxno">
                                        </div>
                                    </form>
                                </div>
                                <div class="tequan">
                                    <p ng-bind="pageManage.rightsTitle"></p>
                                    <ul class="tequan-content">
                                        <li class="clearfix" ng-repeat="tequan in pageManage.tequanItem">
                                            <div class="dianpu">
                                                <img ng-src="{{tequan.iconSrc}}" alt="图标">
                                            </div>
                                            <ul>
                                                <li ng-bind="tequan.firstTitle">独立微店</li>
                                                <li ng-bind="tequan.secondTitle">拥有自己的微店及推广二维码</li>
                                            </ul>
                                        </li>
                                        <li ng-bind="pageManage.tipsTxt">
                                            合伙人的商品销售统一由厂家直接收款,直接发货,并提供产品的售后服务,分销佣金由厂家统一设置。
                                        </li>
                                    </ul>
                                </div>
                                <div class="sure" ng-bind="pageManage.btnText">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-footer"><span></span></div>
            </div>
            <div class="edit-right">
                <div class="limit-box">
                    <h3 class="edit-title">权限设定</h3>
                    <div class="limit-item">
                        <label for="">是否仅VIP可申请成为分销商：</label>
                        <div class="radio-box">
                            <span ng-click="changeStyle($event,'vipApply')">
                                <input type="radio" name="vipapply" data-show="1" id="vipapply1" ng-checked="pageManage.vipApply==1">
                                <label for="vipapply1">是</label>
                            </span>
                            <span ng-click="changeStyle($event,'vipApply')">
                                <input type="radio" name="vipapply" data-show="0" id="vipapply0" ng-checked="pageManage.vipApply==0">
                                <label for="vipapply0">否</label>
                            </span>
                        </div>
                    </div>
                    <div class="limit-item">
                        <label for="">是否对分销商进行审核：</label>
                        <div class="radio-box">
                            <span ng-click="changeStyle($event,'audit')">
                                <input type="radio" name="audit" data-show="1" id="audit1" ng-checked="pageManage.audit==1">
                                <label for="audit1">是</label>
                            </span>
                            <span ng-click="changeStyle($event,'audit')">
                                <input type="radio" name="audit" data-show="0" id="audit0" ng-checked="pageManage.audit==0">
                                <label for="audit0">否</label>
                            </span>
                        </div>
                    </div>
                    <div id="audit-tip" ng-if="pageManage.audit==0">
                        <span style="margin-left: 10px;color: red">如果选择不对分销商进行审核，则申请的分销商将会直接成为最高级分销商</span>
                    </div>
                </div>
                <div class="edit-con animated flipInX">
                    <div class="page-maincon-manage">
                        <h3 class="edit-title">编辑页面内容</h3>
                        <div class="ad-img-manage">
                            <div class="cropper-box" data-width="750" data-height="375" style="height:100%;">
                                <img ng-src="{{pageManage.adImgSrc}}"  onload="changeSrc(this)"  imageonload="doThis('adImgSrc',0)"   alt="广告图片">
                            </div>
                            <p class="pic-tip">(图片格式仅限jpg、png、gif,建议尺寸750x375)</p>
                        </div>
                        <div class="tequan-item" ng-repeat="tequan in pageManage.tequanItem">
                            <div class="delete" ng-click="delItem(tequan.index)">×</div>
                            <div class="icon-img">
                                <div class="cropper-box" data-width="150" data-height="150" style="height:100%;">
                                    <img ng-src="{{tequan.iconSrc}}" onload="changeSrc(this)"  imageonload="doThis('tequanItem',tequan.index)"  width="100%" height="100%" style="display:block;" alt="">
                                    <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="tequan.iconSrc"/>
                                </div>
                            </div>
                            <div class="txt-edit">
                                <div class="input-rows">
                                    <label for="">标　题：</label>
                                    <input type="text" class="cus-input" maxlength="10" placeholder="请输入标题" ng-model="tequan.firstTitle">
                                </div>
                                <div class="input-rows">
                                    <label for="">副标题：</label>
                                    <input type="text" class="cus-input" maxlength="100" placeholder="请输入副标题" ng-model="tequan.secondTitle">
                                </div>
                            </div>
                        </div>
                        <div class="add-box" ng-click="addTequanItem()">+</div>
                        <div class="tip-contxt">
                            <label for="">提示内容：</label>
                            <textarea class="cus-input" rows="3" placeholder="请输入提示内容" ng-model="pageManage.tipsTxt"></textarea>
                        </div>
                        <div class="tip-contxt">
                            <label for="">页面标题：</label>
                            <input class="cus-input" style="width: 100%;" placeholder="页面标题" ng-model="pageManage.pageTitle">
                        </div>
                        <div class="tip-contxt">
                            <label for="">按钮文字：</label>
                            <input class="cus-input" style="width: 100%;" placeholder="按钮文字" ng-model="pageManage.btnText">
                        </div>
                        <div class="tip-contxt">
                            <label for="">欢迎文字：</label>
                            <input class="cus-input" style="width: 100%;" placeholder="欢迎文字" ng-model="pageManage.welcomeText">
                        </div>
                        <div class="tip-contxt">
                            <label for="">合伙人权益标题：</label>
                            <input class="cus-input" style="width: 100%;" placeholder="合伙人权益标题" ng-model="pageManage.rightsTitle">
                        </div>
                        <div class="info-show-hide">
                            <div class="check-row">
                                <span>真实姓名：</span>
                                <div class="check-box">
                                    <input type="checkbox" id="realName" data-id="realName" ng-checked="pageManage.infoShow.realName==1" ng-click="checked($event)">
                                    <label for="realName">显示</label>
                                </div>
                            </div>
                            <div class="check-row">
                                <span>手机号码：</span>
                                <div class="check-box">
                                    <input type="checkbox" id="telPhone" data-id="telPhone" ng-checked="pageManage.infoShow.telPhone==1" ng-click="checked($event)">
                                    <label for="telPhone">显示</label>
                                </div>
                            </div>
                            <div class="check-row">
                                <span>微&ensp;信&ensp;号：</span>
                                <div class="check-box">
                                    <input type="checkbox" id="weixin" data-id="weixin" ng-checked="pageManage.infoShow.weixin==1" ng-click="checked($event)">
                                    <label for="weixin">显示</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning save-btn-box" role="alert" ><button class="btn btn-primary btn-sm" ng-click="saveSetting();">保存</button></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/branch/js/angular-1.4.6.min.js"></script>
<script type="text/javascript" src="/public/manage/branch/js/angular-root.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>

    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
    } );
    //自定义修改图片
    var imgNowsrc=0;
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }
    var banner = '<{$row['tc_fx_banner']}>';
    var  tipsTxt  = '<{$row['tc_fx_desc']}>';
    // var defautImg = "<{if $row['tc_fx_banner']}><{$row['tc_fx_banner']}><{else}>'/public/manage/branch/images/shouye.png'<{/if}>";
    var defautImg = banner ? banner : '/public/manage/branch/images/shouye.png';
    var app = angular.module('branchApp', ['RootModule']);
    app.controller('branchCtrl', ['$scope', '$http','$timeout', function($scope, $http,$timeout) {
        $scope.pageManage = {
            vipApply:'<{$row['tc_fx_vip']}>',
            audit   :'<{$row['tc_fx_audit']}>',
            adImgSrc: '<{if $row['tc_fx_banner']}><{$row['tc_fx_banner']}><{else}>/public/manage/branch/images/shouye.png<{/if}>',
            tequanItem:<{$row['tc_fx_privilege']}>,
            pageTitle:'<{if $row['tc_fx_page_title']}><{$row['tc_fx_page_title']}><{else}>招募合伙人<{/if}>',
            btnText:'<{if $row['tc_fx_btn_text']}><{$row['tc_fx_btn_text']}><{else}>我要成为合伙人<{/if}>',
            welcomeText : '<{if $row['tc_fx_welcome_text']}><{$row['tc_fx_welcome_text']}><{else}>欢迎申请成为分销商，请填写申请信息<{/if}>',
            rightsTitle : '<{if $row['tc_fx_rights_title']}><{$row['tc_fx_rights_title']}><{else}>合伙人特权<{/if}>',
            tipsTxt   : tipsTxt.replace(/<br\s*\/?>/gi,"\r\n") ,
            infoShow:{
                realName:'<{$row['tc_fx_hasname']}>',
                telPhone:'<{$row['tc_fx_hasphone']}>',
                weixin:'<{$row['tc_fx_haswx']}>'
            }
        };
        // 显示隐藏表单
        $scope.checked = function($event){
            var curElem = $($event.target);
            var isChecked = curElem.is(":checked");
            var dataId = curElem.data('id');
            if(isChecked){
                $scope.pageManage.infoShow[dataId] = 1;
            }else{
                $scope.pageManage.infoShow[dataId] = 0;
            }
        }
        /*更改商品列表样式*/
        $scope.changeStyle = function($event,type){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var value = that.data('show');
            that.get(0).checked=true;
            $scope.pageManage[type] = value;
        };
        $scope.addTequanItem = function(){
            var tequanItem_length = $scope.pageManage.tequanItem.length;
            for( var i=0;i< tequanItem_length;i++){
                if( tequanItem_length===$scope.pageManage.tequanItem[i].index){
                     tequanItem_length = "a"+ tequanItem_length;
                }else{
                     tequanItem_length = tequanItem_length;
                }
            }
            var tequanItemsDefault = {
                index:tequanItem_length,
                iconSrc:'/public/manage/img/zhanwei/fenleinav.png',
                firstTitle:'特权标题',
                secondTitle:'特权副标题',
                imgsrc:'/public/manage/img/zhanwei/fenleinav.png'
            };
            $scope.pageManage.tequanItem.push(tequanItemsDefault);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
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
            var temp = $scope.pageManage;
            if(type == 'tequanItem'){
                var realIndex=-1;
                /*获取真正索引*/
                realIndex = $scope.getRealIndex(temp[type],index);
                temp[type][realIndex].iconSrc = imgNowsrc;
               // console.log(temp[type][realIndex].iconSrc);
            }else{
                temp[type] = imgNowsrc;
            }

        };
    //保存配置
        $scope.saveSetting   = function() {
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'vip'           : $scope.pageManage.vipApply,
                'audit'         : $scope.pageManage.audit,
                'banner'        : $scope.pageManage.adImgSrc,
                'desc'          : $scope.pageManage.tipsTxt,
                'hasname'       : $scope.pageManage.infoShow.realName,
                'hasphone'      : $scope.pageManage.infoShow.telPhone,
                'haswx'         : $scope.pageManage.infoShow.weixin,
                'privilege'     : $scope.pageManage.tequanItem,
                'pageTitle'     : $scope.pageManage.pageTitle,
                'btnText'       : $scope.pageManage.btnText,
                'rightsTitle'       : $scope.pageManage.rightsTitle,
                'welcomeText'       : $scope.pageManage.welcomeText,
            };
            $http({
                method  : 'POST',
                url     :  '/wxapp/branch/saveCenter',
                data    :   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };
        /*删除元素*/
        $scope.delItem = function(index){
            var realIndex = -1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope.pageManage.tequanItem,index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消'] 
            }, function(){
                if($scope.pageManage.tequanItem.length<2){
                    layer.msg('至少有一个特权哦！');
                }else{
                    $scope.$apply(function(){
                        $scope.pageManage.tequanItem.splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                }
            });
        };
    }])
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    //call the function that was passed
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    })


</script>
<{$cropper['modal']}>

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
    .member-info-new{
        background-color: #159CFA;
        position: relative;
        padding: 2px 0;
    }
    .base-info-new{
        width: 88%;
        overflow: hidden;
        padding: 16px 4% 16px;
        margin-top: 36px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 10px;
        background-color: #fff;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" style="padding-bottom: 60px;">
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

                        <div class="member-info-new" style="">
                            <img src="/public/manage/centermanage/images/sjd_bg.png" alt="" style="width: 100%;position: absolute"></img>
                            <div class="base-info-new base-info" style="">
                                <div class="left-touxiang" style="margin: 0 auto;float: left"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="text-align: center;width: 50%;padding-left: 0;padding-top: 20px" >
                                    <p>会员昵称</p>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="member-info" ng-style="{'background-image':'url('+centerInfo.bgSrc+')'}">
                            <div class="base-info">
                                <div class="left-touxiang" style="margin: 0 auto;float: none"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="text-align: center;width: 100%;padding-left: 0" >
                                    <p>会员昵称</p>
                                </div>
                            </div>
                        </div>
                        -->


                        <div class="style-type-old">

                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.myft.isShow==0"><a href="#" class="icon30">{{centerInfo.showlist.myft.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mysc.isShow==0"><a href="#" class="icon31">{{centerInfo.showlist.mysc.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.myread.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.myread.name}}<span></span></a></li>
                                <{if $appletCfg['ac_type']==3}>
                                <li class="border-b" ng-hide="centerInfo.showlist.mobilebook.isShow==0"><a href="#" class="icon_mobilebook">{{centerInfo.showlist.mobilebook.name}}<span></span></a></li>
                                <{/if}>
                            </ul>

                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.service.isShow==0"><a href="#" class="icon32">{{centerInfo.showlist.service.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.kefu.isShow==0"><a href="#" class="icon_mine_kefu">{{centerInfo.showlist.kefu.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.aboutus.isShow==0"><a href="#" class="icon33">{{centerInfo.showlist.aboutus.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.jfshop.isShow==0"><a href="#" class="icon27">{{centerInfo.showlist.jfshop.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mypl.isShow==0"><a href="#" class="icon8">{{centerInfo.showlist.mypl.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.subscribe.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.subscribe.name}}<span></span></a></li>
                            </ul>

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
                </div>
                <div class="showlist-manage">

                    <div class="check-row">
                        <span>显示签到</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showqdan" data-id="qdan" ng-checked="centerInfo.showlist.qdan.isShow==1" ng-click="checked($event)">
                                <label for="showqdan">显示</label>
                            </p>
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
                        <span>付费阅读</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showread" data-id="myread" ng-checked="centerInfo.showlist.myread.isShow==1" ng-click="checked($event)">
                                <label for="showread">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myread.name"></p>
                        </div>
                    </div>
                    <{if $appletCfg['ac_type']==3}>
                    <div class="check-row">
                        <span>电话本</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmobilebook" data-id="mobilebook" ng-checked="centerInfo.showlist.mobilebook.isShow==1" ng-click="checked($event)">
                                <label for="showmobilebook">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mobilebook.name"></p>
                        </div>
                    </div>
                    <{/if}>
                    <div class="check-row">
                        <span>客服电话</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showservice" data-id="service" ng-checked="centerInfo.showlist.service.isShow==1" ng-click="checked($event)">
                                <label for="showservice">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.service.name"></p>
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
                        <span>关于我们</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showaboutus" data-id="aboutus" ng-checked="centerInfo.showlist.aboutus.isShow==1" ng-click="checked($event)">
                                <label for="showaboutus">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.aboutus.name"></p>
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
                        <span>订阅消息</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showsubscribe" data-id="subscribe" ng-checked="centerInfo.showlist.subscribe.isShow==1" ng-click="checked($event)">
                                <label for="showsubscribe">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.subscribe.name"></p>
                        </div>
                    </div>
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
            qdan : {
                isShow : <{if $row['ct_qdan_show']}><{$row['ct_qdan_show']}><{else}>0<{/if}>,
                name: ""
            },
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
            appletad : {
                isShow : <{$row['ct_appletad_show']}>,
                name : "<{if $row['ct_appletad_name']}><{$row['ct_appletad_name']}><{else}>我也要做小程序<{/if}>"
            },
            aboutus : {
                isShow : <{$row['ct_aboutus_show']}>,
                name : "<{if $row['ct_aboutus_name']}><{$row['ct_aboutus_name']}><{else}>关于我们<{/if}>"
            },
            service : {
                isShow : <{$row['ct_service_show']}>,
                name : "<{if $row['ct_service_name']}><{$row['ct_service_name']}><{else}>客服电话<{/if}>"
            },
            mobilebook : {
                isShow : <{$row['ct_mobilebook_show']}>,
                name : "<{if $row['ct_mobilebook_name']}><{$row['ct_mobilebook_name']}><{else}>电话本<{/if}>"
            },
            lottery : {
                isShow : <{$row['ct_lottery_show']}>,
                name : "<{if $row['ct_lottery_name']}><{$row['ct_lottery_name']}><{else}>抽奖<{/if}>"
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
                'styleType'     : $scope.centerInfo.styleType,
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
<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css?2">
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
                        <div class="member-info" ng-style="{'background-image':'url('+centerInfo.bgSrc+')'}" style="display: none;">
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
                        <div class="fenlei-nav" style="display: none;">
                            <ul class="border-t border-b" style="white-space: normal;">
                                <li ng-if="nav.open" ng-repeat="nav in navList">
                                    <img ng-src="{{nav.imgsrc}}" width="100%" height="100%"  alt="图标">
                                    <span>{{nav.title}}</span>
                                </li>
                            </ul>
                        </div>

                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.mycard.isShow==0"><a href="#" class="icon52">{{centerInfo.showlist.mycard.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.jfshop.isShow==0"><a href="#" class="train_jf">{{centerInfo.showlist.jfshop.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon48">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>
                            <{if $curr_shop['s_id'] == 4230 || $curr_shop['s_id'] == 10380}>
                            <li class="border-b" ng-hide="centerInfo.showlist.invoice.isShow==0"><a href="#" class="train_fp">{{centerInfo.showlist.invoice.name}}<span></span></a></li>
                            <{/if}>
                            <li class="border-b" ng-hide="centerInfo.showlist.myfx.isShow==0"><a href="#" class="icon49">{{centerInfo.showlist.myfx.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mypt.isShow==0"><a href="#" class="icon47">{{centerInfo.showlist.mypt.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mydd.isShow==0"><a href="#" class="icon45">{{centerInfo.showlist.mydd.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mysc.isShow==0"><a href="#" class="icon46">{{centerInfo.showlist.mysc.name}}<span></span></a></li>
                            <{if $curr_shop['s_id'] == 4230 || $curr_shop['s_id'] == 10380}>
                            <li class="border-b" ng-hide="centerInfo.showlist.exchange.isShow==0"><a href="#" class="train_exchange">{{centerInfo.showlist.exchange.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.kefu.isShow==0"><a href="#" class="train_kf">{{centerInfo.showlist.kefu.name}}<span></span></a></li>
                            <{/if}>
                            <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.subscribe.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.subscribe.name}}<span></span></a></li>
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
                <div class="top-manage" style="display: none;">
                    <div class="input-groups">
                        <label for="">页面名称</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="centerInfo.headerTitle">
                    </div>
                    <!--<div class="input-groups">
                        <label for="">信息文字颜色</label>
                        <input type="text" placeholder="请输入页面标题" id="txtColor">
                    </div>-->
                    <div class="input-groups">
                        <label for="">信息背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="300" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}"  imageonload="changeBg()" id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*300</p>
                            <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" />
                        </div>
                    </div>
                </div>
                <div class="showlist-manage">

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
                        <span>我的课程</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmydd" data-id="mydd" ng-checked="centerInfo.showlist.mydd.isShow==1" ng-click="checked($event)">
                                <label for="showmydd">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mydd.name"></p>
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
                        <span>我的会员</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmycard" data-id="mycard" ng-checked="centerInfo.showlist.mycard.isShow==1" ng-click="checked($event)">
                                <label for="showmycard">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycard.name"></p>
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
                    <{if $curr_shop['s_id'] == 4230 || $curr_shop['s_id'] == 10380}>
                    <div class="check-row">
                        <span>我的发票</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showinvoice" data-id="invoice" ng-checked="centerInfo.showlist.invoice.isShow==1" ng-click="checked($event)">
                                <label for="showinvoice">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.invoice.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的报名</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showexchange" data-id="exchange" ng-checked="centerInfo.showlist.exchange.isShow==1" ng-click="checked($event)">
                                <label for="showexchange">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.exchange.name"></p>
                        </div>
                    </div>

                    <div class="check-row">
                        <span>客服</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showkefu" data-id="kefu" ng-checked="centerInfo.showlist.kefu.isShow==1" ng-click="checked($event)">
                                <label for="showkefu">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.kefu.name"></p>
                        </div>
                    </div>
                    <{/if}>
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
            mycard :{
                isShow : <{$row['ct_mycard_show']}>,
                name: "<{if $row['ct_mycard_name']}><{$row['ct_mycard_name']}><{else}>我的会员<{/if}>"
            },
            myfx :{
                isShow : <{$row['ct_myfx_show']}>,
                name: "<{if $row['ct_myfx_name']}><{$row['ct_myfx_name']}><{else}>分销中心<{/if}>"
            },
            myyhq : {
                isShow : <{$row['ct_myyhq_show']}>,
                name : "<{if $row['ct_myyhq_name']}><{$row['ct_myyhq_name']}><{else}>我的优惠券<{/if}>"
            },
            mysc : {
                isShow : <{$row['ct_mysc_show']}>,
                name : "<{if $row['ct_mysc_name']}><{$row['ct_mysc_name']}><{else}>我的收藏<{/if}>"
            },
            mydd : {
                isShow : <{$row['ct_mydd_show']}>,
                name : "<{if $row['ct_mydd_name']}><{$row['ct_mydd_name']}><{else}>我的订单<{/if}>"
            },
            invoice : {
                isShow : <{$row['ct_invoice_show']}>,
                name : "<{if $row['ct_invoice_name']}><{$row['ct_invoice_name']}><{else}>我的发票<{/if}>"
            },
            exchange : {
                isShow : <{$row['ct_exchange_show']}>,
                name : "<{if $row['ct_exchange_name']}><{$row['ct_exchange_name']}><{else}>我的报名<{/if}>"
            },
            kefu : {
                isShow : <{$row['ct_kefu_show']}>,
                name : "<{if $row['ct_kefu_name']}><{$row['ct_kefu_name']}><{else}>客服<{/if}>"
            },
            jfshop : {
                isShow : <{$row['ct_jfshop_show']}>,
                name : "<{if $row['ct_jfshop_name']}><{$row['ct_jfshop_name']}><{else}>积分商城<{/if}>"
            },
            appletad : {
                isShow : <{$row['ct_appletad_show']}>,
                name : "<{if $row['ct_appletad_name']}><{$row['ct_appletad_name']}><{else}>我也要做小程序<{/if}>"
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
                'color'         : $scope.centerInfo.txtColor,
                'bg'            : $scope.centerInfo.bgSrc,
                'ad_link'       : $scope.centerInfo.adImg.link,
                'ad_img'        : $scope.centerInfo.adImg.imgSrc,
                'advert'        : $scope.centerInfo.adImg.adshow,
                'list'          : $scope.centerInfo.showlist,
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
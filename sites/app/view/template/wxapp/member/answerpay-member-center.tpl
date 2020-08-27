<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css">
<style>
    .fenlei-nav{
        background: #fff;
        margin-bottom: 10px;
    }
    .fenlei-nav li{
        width: 24%;
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

                        <div class="member-info" style="background: #fff;color: #000;">
                            <!--
                            <div class="member-info" style="background: #179EEF;">
                            -->
                            <div class="base-info">
                                <div class="left-touxiang" style="margin: 0;float: none;display: inline-block"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="width: auto;padding-left: 0;display: inline-block;float: none" ><!--ng-style="{'color':centerInfo.txtColor}"-->
                                    <p>会员昵称</p>
                                    <!--<p>会员ID：18</p>-->
                                    <!--<p>会员等级：无</p>-->
                                </div>
                            </div>
                        </div>

                        <div class="style-type-new">
                            <div class="fenlei-nav">
                                <ul class="border-t border-b" style="white-space: normal;">

                                    <li>
                                        <span>66</span><br>
                                        <span>我的回答</span>
                                    </li>
                                    <li>
                                        <span>66</span><br>
                                        <span>我的提问</span>
                                    </li>
                                    <li>
                                        <span>66</span><br>
                                        <span>我的围观</span>
                                    </li>
                                    <li>
                                        <span>66</span><br>
                                        <span>最近浏览</span>
                                    </li>
                                </ul>
                            </div>
                            <div ng-show="centerInfo.adImg.adshow == 1">
                                <img src="{{centerInfo.adImg.imgSrc}}" alt="" style="width: 100%">
                            </div>
                            <ul class="user-operation">
                                <li class="border-b" ng-hide="centerInfo.showlist.myact.isShow==0"><a href="#" class="icon30">{{centerInfo.showlist.myact.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.mycfg.isShow==0"><a href="#" class="icon29">{{centerInfo.showlist.mycfg.name}}<span></span></a></li>
                                <li class="border-b" ng-hide="centerInfo.showlist.helpcenter.isShow==0"><a href="#" class="icon5">{{centerInfo.showlist.helpcenter.name}}<span></span></a></li>
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
                    <div class="input-groups">
                        <label for="">申请专家显示</label>
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="applyShow" id="index_yes" value="1" ng-model="centerInfo.adImg.adshow">
                                        <label for="index_yes">显示</label>
                                    </span>
                            <span>
                                        <input type="radio" name="applyShow" id="index_no" value="0" ng-model="centerInfo.adImg.adshow">
                                        <label for="index_no">不显示</label>
                                    </span>
                        </div>
                    </div>
                    <div class="input-groups">
                        <label for="">申请专家图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="700" data-height="150" data-dom-id="ad-img">
                            <img ng-src="{{centerInfo.adImg.imgSrc}}"  imageonload="changeAdImg()" id="ad-img" width="150px" style="display:inline-block;">
                            <span>修改图片</span>
                            <p>建议尺寸：700*150</p>
                            <input type="hidden" id="center_bg" class="avatar-field ad-img" name="center_bg" />
                        </div>
                    </div>


                </div>
                <div class="showlist-manage">
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
                    <div class="check-row">
                        <span>我的设置</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmycfg" data-id="mycfg" ng-checked="centerInfo.showlist.mycfg.isShow==1" ng-click="checked($event)">
                                <label for="showmycfg">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycfg.name"></p>
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
            membercardJump:"<{$row['ct_membercard_jump']}>",
            txtColor:"<{$row['ct_center_color']}>",
            bgSrc:"<{$row['ct_center_bg']}>" ?"<{$row['ct_center_bg']}>" : '/public/manage/centermanage/images/shk_02.png',
            styleType : "<{$row['ct_style_type']}>",
            serviceTitle : "<{$row['ct_service_title']}>" ? "<{$row['ct_service_title']}>" : "我的服务",
            adImg:{
                imgSrc:"<{$row['ct_advert_img']}>" ? "<{$row['ct_advert_img']}>" : '/public/manage/img/zhanwei/zw_fxb_75_20.png',
                link:"<{$row['ct_advert_link']}>",
                adshow:<{$row['ct_advert_show']}>
        },

        showlist:{
            helpcenter :{
                isShow : <{$row['ct_helpcenter_show']}>,
                name: "<{if $row['ct_helpcenter_name']}><{$row['ct_helpcenter_name']}><{else}>'帮助中心'<{/if}>"
            },
            myact :{
                isShow : <{$row['ct_myact_show']}>,
                name: "<{if $row['ct_myact_name']}><{$row['ct_myact_name']}><{else}>'我的钱包'<{/if}>"
            },
            mycfg :{
                isShow : <{$row['ct_mycfg_show']}>,
                name: "<{if $row['ct_mycfg_name']}><{$row['ct_mycfg_name']}><{else}>'我的设置'<{/if}>"
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
                'membercardJump': $scope.centerInfo.membercardJump,
                'styleType'     : $scope.centerInfo.styleType,
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
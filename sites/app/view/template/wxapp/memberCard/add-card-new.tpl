<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/manage/store/memberCard/css/index.css">
<link rel="stylesheet" href="/public/manage/store/memberCard/css/style.css">
<style>
    .input-rows>label{
        width: 125px !important;
    }
</style>
<div class="preview-page" ng-app="cardApp" ng-controller="cardCtrl" style="padding-bottom:70px;">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                会员卡详情
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="card-detail">
                        <div class="card-box">
                            <div class="card-item" ng-class="cardInfo.cardColor">
                                <div class="card-type">{{cardInfo.cardType}}</div>
                                <div class="card-name">
                                    <div class="avatar">
                                        <img src="/public/manage/store/memberCard/images/avatar.png" alt="头像">
                                    </div>
                                    <h3><{$name}>{{cardInfo.cardType}}</h3>
                                </div>
                                <div class="card-info">
                                    <p ng-bind="cardInfo.title"></p>
                                </div>
                                <div class="limit-date">
                                    <span>售价:￥{{cardInfo.price}}元</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-intro">
                            <h4 class="border-b">会员卡权益</h4>
                            <div class="intro-txt" id="rightsShow">
                            </div>
                        </div>
                        <div class="card-intro">
                            <h4 class="border-b">使用须知</h4>
                            <div class="intro-txt" id="useNoticeShow">
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
            <div class="card-manage ">
                <div class="input-rows">
                    <label for="">会员卡标题：</label>
                    <input type="text" class="cus-input" ng-model="cardInfo.title">
                </div>
                <div class="input-rows">
                    <label for="">会员卡颜色：</label>
                    <div style="width: 100%">
                        <input type="text" class="cus-input color-input" data-colortype="selectedColor" ng-model="cardInfo.backgroundColor">
                        <span>字体颜色为白色，建议选择深色</span>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="">会员卡时长：</label>
                    <div style="padding: 5px 0;width: 100%;">
                        <div class="radio-box">
                            <{foreach $type as $key=>$tal}>
                            <span data-val="<{$key}>" ng-click="changeCardType($event)">
                                <input type="radio" name="type" value="<{$key}>" <{if $row['oc_long_type'] eq $key}>checked<{/if}> id="type<{$key}>" >
                                <label for="type<{$key}>" data-long="<{$tal['long']}>" data-key="<{$key}>" data-name="<{$tal['name']}>"><{$tal['name']}></label>
                            </span>
                            <{/foreach}>
                        </div>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="">价格：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.price">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                </div>
                <{if $appletCfg['ac_type'] != 16}>
                <div class="input-rows">
                    <label for="">到账金额：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.returnPrice">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                </div>
                <{/if}>
                <div class="input-rows">
                    <label for="">开卡人数：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.addOpenNum">
                            <span class="input-group-addon">人</span>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 100px;">用于显示在实际开卡人数的基础上增加的虚拟开卡人数</div>
                <div class="input-rows">
                    <label for="">排序权重：</label>
                    <div style="width: 100%">
                        <div class="input-group" style="width: 100%">
                            <input type="text" class="form-control" ng-model="cardInfo.weight" style="border-radius: 4px;">
                        </div>
                    </div>
                </div>
                <div style="margin-left: 100px;">数字越大排序越靠前</div>
                <div class="line"></div>
                <div class="input-rows">
                    <label for="">绑定会员身份：</label>
                    <select class="cus-input form-control" ng-model="cardInfo.identity"  ng-options="x.ml_id as x.ml_name for x in levelList" ></select>
                </div>
                <{if $appletCfg['ac_type'] != 28}>
                <div class="input-rows">
                    <label for="">会员折扣率：</label>
                    <div style="width: 100%">
                        <div class="input-group" style="width: 100%">
                            <span style="font-size: 14px;font-weight: normal;line-height: 2;padding-left: 3px" ng-if="levelList[cardInfo.identity].ml_discount">{{levelList[cardInfo.identity].ml_discount}}折</span>
                            <a style="float: right;border-radius: 4px !important;" class="btn btn-sm btn-primary" href="/wxapp/member/level" target="_blank">设置会员等级</a>
                        </div>
                    </div>
                </div>
                <{/if}>


                <div <{if $showMemberDay != 1}>style="display: none" <{/if}>>
                    <div class="input-rows">
                        <label for="">会员日：</label>
                        <div style="width: 100%">
                            <div class="input-group" style="width: 100%">
                                <input type="text" class="form-control" id="member_day" onclick="WdatePicker({dateFmt:'dd'})" style="border-radius: 4px;display: inline-block;width: 30%" value="<{$row['oc_member_day']}>">
                            </div>
                        </div>
                    </div>
                    <div style="margin-left: 100px;">设置会员日后，每月会员日当天下单将按照会员日折扣支付</div>

                    <div class="input-rows">
                        <label for="">会员日折扣：</label>
                        <div style="width: 100%">
                            <div class="input-group" style="width: 100%">
                                <input type="text" class="form-control"  style="border-radius: 4px;display: inline-block;width: 30%" ng-model="cardInfo.memberDayDiscount" >折
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-rows">
                    <label for="">会员卡权益：</label>
                    <textarea class="cus-input" rows="4" id="rights" ng-model="cardInfo.rights"></textarea>
                </div>
                <div class="input-rows">
                    <label for="">使用须知：</label>
                    <textarea class="cus-input" rows="4" id="useNotice" ng-model="cardInfo.useNotice"></textarea>
                </div>
                <div class="input-rows">
                    <label for="">是否显示：</label>
                    <div style="padding: 5px 0;width: 100%;">
                        <div class="radio-box">
                            <span data-val="0" ng-click="changeCardHidden($event)">
                                <input id='hidden_1' type="radio" name="hidden_type" value="0" <{if $row['oc_hidden'] neq 1 }>checked<{/if}> >
                                <label for="hidden_1" data-name="0">显示</label>
                            </span>
                             <span data-val="1" ng-click="changeCardHidden($event)">
                                <input id='hidden_2' type="radio" name="hidden_type" value="1" <{if $row['oc_hidden'] eq 1}>checked<{/if}> >
                                <label for="hidden_2" data-name="1">隐藏</label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveCard()"> 保 存 </button></div>
</div>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/store/memberCard/layer/layer.js"></script>
<script src="/public/manage/store/memberCard/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/store/memberCard/js/angular-root.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    var app = angular.module('cardApp',['RootModule']);
    app.controller('cardCtrl', ['$scope','$http', function($scope,$http){

        $scope.cardInfo = {
            title       : "<{$row['oc_name']}>",
            identity    : "<{$row['oc_identity']}>" ? "<{$row['oc_identity']}>" : 0,
            fuTitle     : "<{$row['oc_name_sub']}>",
            cardColor   : "<{$row['color']}>",
            backgroundColor : "<{$row['oc_background_color']}>",
            bgType      : "<{$row['oc_bg_type']}>",
            cardType    : "<{$row['type']}>",
            longType    : "<{$row['oc_long_type']}>",
            addOpenNum  : "<{$row['oc_add_open_num']}>",
            limitMonth  : "<{$row['oc_long']}>",
            times       : "<{$row['oc_times']}>",
            price       : "<{$row['oc_price']}>",
            weight      : "<{$row['oc_weight']}>",
            rights      : "<{$row['oc_rights']}>",
            useNotice   : "<{$row['oc_notice']}>",
            deduct0     : "<{$row['oc_0f_deduct']}>",
            deduct1     : "<{$row['oc_1f_deduct']}>",
            deduct2     : "<{$row['oc_2f_deduct']}>",
            deduct3     : "<{$row['oc_3f_deduct']}>",
            returnPrice : "<{$row['oc_return_price']}>",
            memberDayDiscount : "<{$row['oc_member_day_discount']}>",
            hidden:"<{$row['oc_hidden']}>",
        };
        $scope.levelList = <{$levelList}>;


        /*更改会员卡颜色*/
        $scope.changeCardcolor = function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var value = that.next().data('color');
            var type  = that.next().data('key');
            that.get(0).checked=true;
            $scope.cardInfo.cardColor   = value;
            $scope.cardInfo.bgType      = type;
        };
        /*更改会员卡类型*/
        $scope.changeCardType = function($event){
            $event.preventDefault();
            var that  = $($event.target).prev('input:eq(0)');
            var name  = that.next().data('name');
            var long  = that.next().data('long');
            var type  = that.next().data('key');
            that.get(0).checked=true;
            $scope.cardInfo.cardType   = name;
            $scope.cardInfo.limitMonth = long;
            $scope.cardInfo.longType   = type;
        };

         /*选择会员卡是否显示*/
        $scope.changeCardHidden = function($event){
            $event.preventDefault();
            var that  = $($event.target).prev('input:eq(0)');
            var val  = that.next().data('name');
            that.get(0).checked=true;
            $scope.cardInfo.hidden   = val;

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

        $scope.saveCard = function(){
            var memberDay = $('#member_day').val();
            var data = {
                'id'        : '<{$row['oc_id']}>',
                'type'      : '<{$cardtype}>',
                'name' 	    : $scope.cardInfo.title,
                'identity' 	: $scope.cardInfo.identity,
                'return_price': $scope.cardInfo.returnPrice,
                'name_sub' 	: $scope.cardInfo.fuTitle,
                'bg_type' 	: $scope.cardInfo.bgType,
                'long_type' : $scope.cardInfo.longType,
                'times'     : $scope.cardInfo.times,
                'price'     : $scope.cardInfo.price,
                'weight'    : $scope.cardInfo.weight,
                'rights'    : $scope.cardInfo.rights,
                'add_open_num': $scope.cardInfo.addOpenNum,
                'notice'    : $scope.cardInfo.useNotice,
                '0f_deduct' : $scope.cardInfo.deduct0,
                '1f_deduct' : $scope.cardInfo.deduct1,
                '2f_deduct' : $scope.cardInfo.deduct2,
                '3f_deduct' : $scope.cardInfo.deduct3,
                'background_color' : $scope.cardInfo.backgroundColor,
                'fictitious_open_num' : $scope.cardInfo.fictitiousNum,
                'member_day_discount' : $scope.cardInfo.memberDayDiscount,
                'member_day' : memberDay,
                'hidden' : $scope.cardInfo.hidden
            };
            console.log(data);

            var loading = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            $http({
                method: 'POST',
                url:    '/wxapp/membercard/saveCard',
                data:   data
            }).then(function(response) {
                console.log(response);
                layer.close(loading);
                layer.msg(response.data.em);
                if(response.data.ec == 200){
                    window.location.href = '/wxapp/membercard/discountCard';
                }
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

            $("#rightsShow").html($scope.cardInfo.rights.split("\n").join("<br />"));
            $("#useNoticeShow").html($scope.cardInfo.useNotice.split("\n").join("<br />"));
            $("#rights").on('input', function(event) {
                var curVal = $(this).val();
                $scope.cardInfo.rights = curVal ;
                var showVal = curVal.split("\n").join("<br />");
                $("#rightsShow").html(showVal);
            });
            $("#useNotice").on('input', function(event) {
                var curVal = $(this).val();
                $scope.cardInfo.useNotice = curVal ;
                var showVal = curVal.split("\n").join("<br />");
                $("#useNoticeShow").html(showVal);
            });
        });
    }]);
</script>
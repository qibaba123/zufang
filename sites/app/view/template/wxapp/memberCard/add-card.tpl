<link rel="stylesheet" href="/public/manage/store/memberCard/css/index.css">
<link rel="stylesheet" href="/public/manage/store/memberCard/css/style.css">
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
                                    <span ng-bind="cardInfo.fuTitle"></span>
                                </div>
                                <div class="limit-date">
                                    <p>【有效期{{cardInfo.limitMonth}}天，不可退换】</p>
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
                    <label for="">副标题：</label>
                    <input type="text" class="cus-input" ng-model="cardInfo.fuTitle">
                </div>
                <div class="input-rows">
                    <label for="">卡颜色：</label>
                    <div style="padding: 5px 0;width: 100%;">
                        <div class="radio-box">
                            <{foreach $color as $key=>$cal}>
                            <span data-val="<{$key}>" ng-click="changeCardcolor($event)">
                                <input type="radio" name="color" value="<{$key}>" <{if $row['oc_bg_type'] eq $key}>checked<{/if}> id="type<{$key}>" >
                                <label for="type<{$key}>" data-color="<{$cal['color']}>" data-key="<{$key}>"><{$cal['name']}></label>
                            </span>
                            <{/foreach}>
                        </div>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="">卡类型：</label>
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
                    <label for="">可消费次数：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="0表示不限次数（默认）" ng-model="cardInfo.times">
                            <span class="input-group-addon">次</span>
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
                <div class="input-rows">
                    <label for="" style="width: 125px;!important;">虚拟开卡人数：</label>
                    <input type="text" class="cus-input" ng-model="cardInfo.fictitiousNum">
                </div>
                <!--
                <div class="line"></div>
                <div class="input-rows form-group">
                    <label for="">会员返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct0">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <{if $row['tc_level'] && $row['tc_level'] > 0}>
                <div class="input-rows">
                    <label for="">上级返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct1">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $row['tc_level'] && $row['tc_level']>1}>
                <div class="input-rows form-inline">
                    <label for="">上二级返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct2">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $row['tc_level'] && $row['tc_level']>2}>
                <div class="input-rows">
                    <label for="">上三级返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct3">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <{/if}>
                -->
                <div class="line"></div>
                <div class="input-rows">
                    <label for="">会员身份：</label>
                    <select class="cus-input form-control" ng-model="cardInfo.identity"  ng-options="x.ml_id as x.ml_name for x in levelList" ></select>
                </div>
                <div class="input-rows">
                    <label for="">会员卡权益：</label>
                    <textarea class="cus-input" rows="4" id="rights" ng-model="cardInfo.rights"></textarea>
                </div>
                <div class="input-rows">
                    <label for="">使用须知：</label>
                    <textarea class="cus-input" rows="4" id="useNotice" ng-model="cardInfo.useNotice"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveCard()"> 保 存 </button></div>
</div>
<script src="/public/manage/store/memberCard/layer/layer.js"></script>
<script src="/public/manage/store/memberCard/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/store/memberCard/js/angular-root.js"></script>
<script>
    var app = angular.module('cardApp',['RootModule']);
    app.controller('cardCtrl', ['$scope','$http', function($scope,$http){

        $scope.cardInfo = {
            title       : "<{$row['oc_name']}>",
            identity    : "<{$row['oc_identity']}>",
            fuTitle     : "<{$row['oc_name_sub']}>",
            cardColor   : "<{$row['color']}>",
            bgType      : "<{$row['oc_bg_type']}>",
            cardType    : "<{$row['type']}>",
            longType    : "<{$row['oc_long_type']}>",
            //limitMonth  : "<{$row['oc_long']}>",
            'limitMonth': '<{$type[$row['oc_long_type']]['long']}>',
            times       : "<{$row['oc_times']}>",
            price       : "<{$row['oc_price']}>",
            rights      : "<{$row['oc_rights']}>",
            useNotice   : "<{$row['oc_notice']}>",
            deduct0     : "<{$row['oc_0f_deduct']}>",
            deduct1     : "<{$row['oc_1f_deduct']}>",
            deduct2     : "<{$row['oc_2f_deduct']}>",
            deduct3     : "<{$row['oc_3f_deduct']}>",
            addOpenNum  : "<{$row['oc_add_open_num']}>"
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
        $scope.saveCard = function(){
            var data = {
                'id'        : '<{$row['oc_id']}>',
                'name' 	    : $scope.cardInfo.title,
                'identity' 	: $scope.cardInfo.identity,
                'name_sub' 	: $scope.cardInfo.fuTitle,
                'bg_type' 	: $scope.cardInfo.bgType,
                'long_type' : $scope.cardInfo.longType,
                'times'     : $scope.cardInfo.times,
                'price'     : $scope.cardInfo.price,
                'rights'    : $scope.cardInfo.rights,
                'notice'    : $scope.cardInfo.useNotice,
                '0f_deduct' : $scope.cardInfo.deduct0,
                '1f_deduct' : $scope.cardInfo.deduct1,
                '2f_deduct' : $scope.cardInfo.deduct2,
                '3f_deduct' : $scope.cardInfo.deduct3,
                'add_open_num' : $scope.cardInfo.addOpenNum
            };

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
                    //window.location.href = '/wxapp/membercard/card';
                    window.location.href = '/wxapp/membercard/storeCfg';
                }
            });
        };
        $(function(){
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
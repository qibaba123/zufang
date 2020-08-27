<link rel="stylesheet" href="/public/manage/coupon/css/index.css">
<link rel="stylesheet" href="/public/manage/coupon/css/style.css">
<style>
	/*选择全部或指定商品*/
	.choose-goodrange{
		padding-top: 5px;
	}
	.choosegoods{
		padding: 5px 0;
	}
	.choosegoods .tip{
		font-size: 12px;
		color: #999;
		margin:0;
	}
	.choosegoods>div{
		display: none;
	}
	.add-good-box .btn{
		margin-top: 10px;
	}
	.add-good-box .table{
		max-width: 750px;
		margin: 10px 0 0;
	}
	.add-good-box .table thead tr th{
		border-right: 0;
		padding: 8px 6px;
		vertical-align: middle;
	}
	.left{
		text-align: left;
	}
	.center{
		text-align: center;
	}
	.right{
		text-align: right;
	}
	.add-good-box .table tbody tr td{
		padding: 7px 6px;
		vertical-align: middle;
		white-space: normal;
	}
	td.goods-info p{
		display: -webkit-box !important;
		overflow: hidden;
		text-overflow:ellipsis;
		word-break:break-all;
		-webkit-box-orient:vertical;
		-webkit-line-clamp:2;
		max-height: 38px;
	}
	.add-good-box .table span.del-good{
		color: #38f;
		font-weight: bold;
		cursor: pointer;
	}
	.input-rows>label {
		width: 115px;
	}
</style>

<{include file="../common-second-menu.tpl"}>
<div class="preview-page" ng-app="proApp" ng-controller="proCtrl" style="padding-bottom:65px;">
	<div class="mobile-page">
		<div class="mobile-header"></div>
		<div class="mobile-con">
			<div class="title-bar">
				优惠券管理
			</div>
			<!-- 主体内容部分 -->
			<div class="index-con">
				<!-- 首页主题内容 -->
				<div class="index-main">
					<div class="coupon">
						<div class="coupon-detail-wrap">
							<div class="promote-card">
								<div class="clearfix" style="height:60px;">
									<h2 class="fl promote-card-name" ng-bind="couponInfo.name"></h2>
									<p class="fr promote-share">分享</p>
								</div>
								<p class="center promote-value"><b>￥</b> <span ng-bind="couponInfo.faceVal"></span></p>
								<p class="center promote-limit" ng-show="couponInfo.useLimitType==0">无限制</p>
								<p class="center promote-limit" ng-show="couponInfo.useLimitType==1">订单满<span ng-bind="couponInfo.useLimitVal">xx</span>元(含运费)</p>
								<p class="center promote-limit-date">有效日期：<span ng-bind="couponInfo.effectTime"></span> - <span ng-bind="couponInfo.pastDueTime"></span></p>
								<div class="dot"></div>
							</div>
							<div class="promote-desc">
								<h2 class="promote-desc-title">使用说明</h2>
								<div class="block-item" ng-bind="couponInfo.instructions">
									暂无使用说明...
								</div>
							</div>
						</div>
					</div>
					<div class="coupon-show">
						<ul class="showTicket">
							<li>
								<div class="ticket-box">
									<div>
										<p class="center money">￥<span ng-bind="couponInfo.faceVal">3</span></p>
										<p class="center limitmoney">满<span ng-bind="couponInfo.useLimitVal"></span>元使用</p>
										<p class="left limit-time">有效期：<span ng-bind="couponInfo.effectTime"></span> - <span ng-bind="couponInfo.pastDueTime"></span></p>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="mobile-footer"><span></span></div>
	</div>
	<div class="edit-right">
		<div class="edit-con">
			<div class="coupon-manage">
				<div class="coupon-base-info">
					<h4>优惠券基础信息</h4>
					<div class="input-rows">
						<label for=""><span class="red">*</span>优惠券名称：</label>
						<input type="text" class="cus-input" ng-model="couponInfo.name" placeholder="最多支持10个字">
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>面值：</label>
						<div class="input-groups">
							<input type="text" class="cus-input add-input" ng-keyup="checkFaceVal()"  ng-model="couponInfo.faceVal" oninput="this.value=this.value.replace(/\D/g,'')">
							<span>元</span>
						</div>
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>使用门槛：</label>
						<div class="input-groups">
							<div class="radio-box">
								<input type="radio" name="useing-limit" id="nolimit" ng-checked="couponInfo.useLimitType==0" ng-click="useLimit($event)" class="add-input">
								<label for="nolimit">不限制</label>
							</div>
							<div class="radio-box">
								<input type="radio" name="useing-limit" id="limit-money" ng-checked="couponInfo.useLimitType==1" ng-click="useLimit($event)" add-input>
								<label for="limit-money">满<input type="text" class="cus-input add-input" ng-keyup="checkFaceVal()" ng-model="couponInfo.useLimitVal">元可使用</label>
							</div>
						</div>
					</div>
				</div>
				<div class="coupon-base-rules">
					<h4>基本规则</h4>
					<div class="input-rows">
						<label class="col-sm-3 control-label" style="padding-left: 0px;"><span class="red">*</span>用券时间类型</label>
						<div class="level-box">
							<div class="radio-box">
								<span data-val="0">
									<input type="radio" class="add-input" name="use-time-type" id="useTimeType1" data-val="1" ng-checked="couponInfo.useTimeType==1" ng-click="changeTimeType($event)">
									<label for="useTimeType1">指定时间</label>
								</span>
								<span data-val="1">
									<input type="radio" class="add-input" name="use-time-type" id="useTimeType2" data-val="2" ng-checked="couponInfo.useTimeType==2" ng-click="changeTimeType($event)">
									<label for="useTimeType2">指定天数</label>
								</span>
							</div>
						</div>
					</div>
					<div ng-show="couponInfo.useTimeType==1">
						<div class="input-rows">
							<label for=""><span class="red">*</span>用券结束时间：</label>
							<input type="text" class="cus-input add-input" onclick="chooseDate()" ng-model="couponInfo.useEndTime" onchange="">
						</div>
					</div>
					<div ng-show="couponInfo.useTimeType==2">
						<div class="input-rows">
							<label for=""><span class="red">*</span>领券当日起</label>
							<input type="text" class="cus-input add-input" ng-model="couponInfo.useDays" style="width: 70px;margin-left: 10px;">
							<label for="" style="width: 64px;">天内可用</label>
						</div>
					</div>

					<div class="input-rows">
						<label for="">使用说明：</label>
						<textarea name="" id="" rows="3" class="cus-input"  ng-model="couponInfo.instructions"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveCoupon();"> 保 存 </button></div>
</div>

<script src="/public/manage/coupon/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script src="/public/manage/coupon/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/coupon/js/angular-root.js"></script>
<{include file="../modal-gift-select.tpl"}>
<script>
    $(function(){
        if('<{$row && $row['cl_id']}>' != ''){
            $('.add-input').attr('disabled','true');
        }
        // 选择全店或部分商品相关js
        $(".choose-goodrange").on('click', '.radio-box>span', function(event) {
            var type = $(this).data('type');
            $(this).parents('.choose-goodrange').find(".choosegoods>div").stop().hide();
            $(this).parents('.choose-goodrange').find(".choosegoods>div[data-type="+type+"]").stop().show();
        });
        // 删除选择的商品
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
            // if(length<=1){
            // 	goodListElem.stop().hide();
            // }
        });
    });
    var app = angular.module('proApp',['RootModule']);
    app.controller('proCtrl', ['$scope','$http', function($scope,$http){
        $scope.limitNumber = ['不限','1张', '2张', '3张','4张','5张','10张'];
        $scope.couponInfo = {
            name:'<{if $row['cl_name']}><{$row['cl_name']}><{/if}>',
            number: '<{if $row['cl_count']}><{$row['cl_count']}><{/if}>',
            faceVal: '<{if $row['cl_face_val']}><{$row['cl_face_val']}><{/if}>',
            useLimitType:<{if $row['cl_use_limit']}>1<{else}>0<{/if}>,
            useDays:<{if $row['cl_use_days']}><{$row['cl_use_days']}><{else}>0<{/if}>,
            useLimitVal:<{if $row['cl_use_limit']}><{$row['cl_use_limit']}><{else}>0<{/if}>,
            useTimeType:<{if $row['cl_use_time_type']}><{$row['cl_use_time_type']}><{else}>1<{/if}>,
            getLimit:"<{if $row['cl_receive_limit']}><{$row['cl_receive_limit']}>张<{else}>不限<{/if}>",
            pastDueTime: '<{if $row['cl_end_time']}><{date("Y-m-d H:i:s",$row['cl_end_time'])}><{/if}>',
            useEndTime: '<{if $row['cl_use_end_time']}><{date("Y-m-d H:i:s",$row['cl_use_end_time'])}><{else}><{if $row['cl_end_time']}><{date("Y-m-d H:i:s",$row['cl_end_time'])}><{/if}><{/if}>',
            instructions: '<{if $row['cl_use_desc']}><{$row['cl_use_desc']}><{/if}>'
    };
        $scope.useLimit = function($event){
            var elem = $($event.target);
            var typeVal = elem.parents(".radio-box").index();
            $scope.couponInfo.useLimitType = typeVal;
        };
        $scope.indexShow = function($event){
            var target = $event.target;
            var typeVal = target.getAttribute('data-val');
            $scope.couponInfo.indexShow = typeVal;
        };
        $scope.changeTimeType = function($event){
            var target = $event.target;
            var typeVal = target.getAttribute('data-val');
            $scope.couponInfo.useTimeType = typeVal;
        };

        $scope.checkFaceVal=function(){
            var faceVal = $scope.couponInfo.faceVal;
            var limit   = $scope.couponInfo.useLimitVal;
            if($scope.couponInfo.useLimitType == 1 && faceVal > limit){
                layer.msg('订单限制金额必须大于等于优惠券的面值');
            }
        };
        $scope.saveCoupon   = function() {
            var limit = 0;
            if($scope.couponInfo.useLimitType == 1){
                limit = $scope.couponInfo.useLimitVal;
            }
            var receiveStr = $scope.couponInfo.getLimit;
            if(receiveStr == '不限'){
                var receive = 0;
            }else{
                var receive = receiveStr.replace('张','');
            }
            var data = {
                'id'		: '<{if $row['cl_id']}><{$row['cl_id']}><{else}>0<{/if}>',
                'name'      : $scope.couponInfo.name,
                'face_val'  : $scope.couponInfo.faceVal,
                'use_limit' : limit,
                'use_desc'  : $scope.couponInfo.instructions,
                'count'   	: $scope.couponInfo.number,
                'end'   	: $scope.couponInfo.pastDueTime,
                'useEnd'   	: $scope.couponInfo.useEndTime,
                'useTimeType' : $scope.couponInfo.useTimeType,
                'useDays' : $scope.couponInfo.useDays,
                'use_type'  : $('input[name="use_type"]:checked').val(),
                'couponType':2,
            };

            if(parseInt(data.use_limit) > 0 && parseInt(data.face_val) > parseInt(data.use_limit)){
                layer.msg('订单限制金额必须大于等于优惠券的面值');
                return false;
            }
            layer.confirm('确定要保存吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                },{
                    time : 10*1000
                });
                $http({
                    method: 'POST',
                    url:    '/wxapp/collectionprize/saveCoupon',
                    data:   data
                }).then(function(response) {
                    layer.close(index);
                    layer.msg(response.data.em);
                    if(response.data.ec== 200){
                        window.location.href='/wxapp/collectionprize/coupon';
                    }
                });
            });
        };
    }]);
    var nowdate = new Date();
    var year = nowdate.getFullYear(),
        month = nowdate.getMonth()+1,
        date = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd HH:mm:ss',
            minDate:today
        });
    }


</script>
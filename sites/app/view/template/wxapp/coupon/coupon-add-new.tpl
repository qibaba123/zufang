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
<!--
<{include file="../common-second-menu-new.tpl"}>
-->
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
						<p class="about-card-desc">(分销商城优惠群)</p>
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
					<{if $ac_type == 21}>
						<!-- 营销商城选择优惠券类型 -->
						<div class='input-rows'>
							<label for=""><span class="red">*</span>优惠券类型：</label>
							<div class="level-box">
								<div class="radio-box">
									<span data-val="0">
										<input type="radio" name="coupon-type" id="coupon_0" data-val="0" ng-checked="couponInfo.couponType==0" ng-click="couponType($event)">
										<label for="coupon_0">普通券</label>
									</span>
									<span data-val="1">
										<input type="radio" name="coupon-type" id="coupon_1" data-val="4" ng-checked="couponInfo.couponType==4" ng-click="couponType($event)">
										<label for="coupon_1">满赠券</label>
									</span>
								</div>
							</div>
						</div>

						<div class="input-rows hidden_type_show">
							<label for=""><span class="red">*</span>订单金额：</label>
							<input type="text" class="cus-input" ng-model="couponInfo.tradeLimit" placeholder="订单满足此金额时进行赠送">
						</div>
					<{/if}>
					<div class="input-rows">
						<label for=""><span class="red">*</span>优惠券名称：</label>
						<input type="text" class="cus-input" ng-model="couponInfo.name" placeholder="最多支持10个字">
					</div>
					<div class="input-rows hidden_type">
						<label for=""><span class="red">*</span>发放总量：</label>
						<div class="input-groups">
							<input type="text" class="cus-input" ng-model="couponInfo.number" oninput="this.value=this.value.replace(/\D/g,'')">
							<span>张</span>
						</div>
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>排序权重：</label>
						<div class="input-groups">
							<input type="text" class="cus-input" ng-model="couponInfo.sort" oninput="this.value=this.value.replace(/\D/g,'')">
							<span>越大越靠前</span>
						</div>
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
					<{if $shopType eq 21 || $shopType eq 1 || $shopType eq 6 || $shopType eq 8}>
					<div class="input-rows hidden_type">
						<label class="col-sm-4 control-label" style="padding-left: 0px;">仅限新用户领取:</label>
						<div class="level-box">
							<div class="radio-box">
								<span data-val="0">
									<input type="radio" name="new-limit" id="unnewlimit" data-val="0" ng-checked="couponInfo.newLimit==0" ng-click="newLimit($event)">
									<label for="unnewlimit">不限制</label>
								</span>
								<span data-val="1">
									<input type="radio" name="new-limit" id="newlimit" data-val="1" ng-checked="couponInfo.newLimit==1" ng-click="newLimit($event)">
									<label for="newlimit">限制</label>
								</span>
							</div>
						</div>
					</div>
					<{/if}>
					<div class="input-rows hidden_type">
						<label class="col-sm-4 control-label" style="padding-left: 0px;">是否分享后领取:</label>
						<div class="level-box">
							<div class="radio-box">
								<span data-val="0">
									<input type="radio" name="need-share" id="unneedShare" data-val="0" ng-checked="couponInfo.needShare==0" ng-click="needShare($event)">
									<label for="unneedShare">不需要</label>
								</span>
								<span data-val="1">
									<input type="radio" name="need-share" id="needShare" data-val="1" ng-checked="couponInfo.needShare==1" ng-click="needShare($event)">
									<label for="needShare">需要</label>
								</span>
							</div>
						</div>
					</div>
					<{if $shopType neq 23 }>
					<div class="input-rows hidden_type">
						<label class="col-sm-3 control-label" style="padding-left: 0px;">店铺首页展示</label>
						<div class="level-box">
							<div class="radio-box">
								<span data-val="0">
									<input type="radio" name="index-show" id="show" data-val="0" ng-checked="couponInfo.indexShow==0" ng-click="indexShow($event)">
									<label for="show">不展示</label>
								</span>
								<span data-val="1">
									<input type="radio" name="index-show" id="unshow" data-val="1" ng-checked="couponInfo.indexShow==1" ng-click="indexShow($event)">
									<label for="unshow">展示</label>
								</span>
							</div>
						</div>
					</div>
					<{/if}>
				</div>
				<div class="coupon-base-rules">
					<h4>基本规则</h4>
					<div class="input-rows">
						<label for=""><span class="red">*</span>每人限领：</label>
						<select name="" id="" class="cus-input add-input" ng-model="couponInfo.getLimit" ng-options="item for item in limitNumber">
						</select>
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>领券开始时间：</label>
						<input type="text" class="cus-input add-input" onclick="chooseDate()" ng-model="couponInfo.effectTime" onchange="">
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>领券结束时间：</label>
						<input type="text" class="cus-input add-input" onclick="chooseDate()" ng-model="couponInfo.pastDueTime" onchange="">
					</div>
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
					<!--新增会议版没有使用商品限制  shopType 22为会议版-->
					<div class="input-rows" <{if $shopType eq 12 || $shopType eq 9 || $shopType eq 22 || $shopType eq 6 || $shopType eq 8 || $shopType eq 34 }> style="display:none;" <{/if}>>
						<label for="">使用商品：</label>
						<div class="cus-input" style="background-color: #fff;">
							<div class="choose-goodrange">
								<div class="radio-box">
									<span data-type="all">
										<input type="radio" name="use_type" id="allGood" value="1" <{if !($row && $row['cl_use_type'] eq 2)}>checked<{/if}>>
										<label for="allGood">全店通用</label>
									</span>
									<span data-type="assign">
										<input type="radio" name="use_type" id="assignGood" value="2" <{if $row && $row['cl_use_type'] eq 2}>checked<{/if}>>
										<label for="assignGood">指定商品</label>
									</span>
								</div>
								<div class="choosegoods">
									<div class="allgood-tip" data-type="all" <{if !($row && $row['cl_use_type'] eq 2)}>style="display: block;"<{/if}>>
									<p class="tip">保存后，不能更改成指定商品</p>
								</div>
								<div class="assigngood-tip" data-type="assign" <{if $row && $row['cl_use_type'] eq 2}>style="display: block;"<{/if}>>
								<p class="tip">指定商品可用时，订单金额不包含运费</p>
								<div class="add-good-box">
									<div class="goodshow-list">
										<table class="table">
											<thead>
											<tr>
												<th class="left">商品名称</th>
												<th class="right">操作</th>
											</tr>
											</thead>
											<tbody id="can-used_goods">
											<{foreach $goods as $val}>
												<tr class="good-item">
													<td class="goods-info" data-id="<{$val['id']}>" data-gid="<{$val['gid']}>" data-name="<{$val['gname']}>"><p><{$val['gname']}></p></td>
													<td class="right"><span class="del-good">删除</span></td>
												</tr>
												<{/foreach}>
											</tbody>
										</table>
									</div>
									<div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="confirmAddgood()">+添加商品</div>
								</div>
							</div>
						</div>
					</div>
				</div>
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
			sort: '<{if $row['cl_sort']}><{$row['cl_sort']}><{else}>0<{/if}>',
			faceVal: '<{if $row['cl_face_val']}><{$row['cl_face_val']}><{/if}>',
			useLimitType:<{if $row['cl_use_limit']}>1<{else}>0<{/if}>,
			indexShow:<{if $row['cl_shop_show']}><{$row['cl_shop_show']}><{else}>0<{/if}>,
            newLimit:<{if $row['cl_new_limit']}><{$row['cl_new_limit']}><{else}>0<{/if}>,
            needShare:<{if $row['cl_need_share']}><{$row['cl_need_share']}><{else}>0<{/if}>,
        	useDays:<{if $row['cl_use_days']}><{$row['cl_use_days']}><{else}>0<{/if}>,
			useLimitVal:<{if $row['cl_use_limit']}><{$row['cl_use_limit']}><{else}>0<{/if}>,
			useTimeType:<{if $row['cl_use_time_type']}><{$row['cl_use_time_type']}><{else}>1<{/if}>,
			getLimit:"<{if $row['cl_receive_limit']}><{$row['cl_receive_limit']}>张<{else}>不限<{/if}>",
			effectTime: '<{if $row['cl_start_time']}><{date("Y-m-d H:i:s",$row['cl_start_time'])}><{/if}>',
			pastDueTime: '<{if $row['cl_end_time']}><{date("Y-m-d H:i:s",$row['cl_end_time'])}><{/if}>',
			useEndTime: '<{if $row['cl_use_end_time']}><{date("Y-m-d H:i:s",$row['cl_use_end_time'])}><{else}><{if $row['cl_end_time']}><{date("Y-m-d H:i:s",$row['cl_end_time'])}><{/if}><{/if}>',
			instructions: '<{if $row['cl_use_desc']}><{$row['cl_use_desc']}><{/if}>',
			couponType:'<{if $row['cl_coupon_type']}><{$row['cl_coupon_type']}><{/if}>',
			tradeLimit:'<{if $row['cl_coupon_receive_limit']}><{$row['cl_coupon_receive_limit']}><{/if}>',
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
	$scope.newLimit = function($event){
		var target = $event.target;
		var typeVal = target.getAttribute('data-val');
		$scope.couponInfo.newLimit = typeVal;
	};
	$scope.needShare = function($event){
		var target = $event.target;
		var typeVal = target.getAttribute('data-val');
		$scope.couponInfo.needShare = typeVal;
	};

	$scope.checkFaceVal=function(){
		var faceVal = $scope.couponInfo.faceVal;
		var limit   = $scope.couponInfo.useLimitVal;
		if($scope.couponInfo.useLimitType == 1 && faceVal > limit){
			layer.msg('订单限制金额必须大于等于优惠券的面值');
		}
	};


	//优惠券类型选择
	//zhangzc
	//2019-10-26
	$scope.couponType=function($event){
		var target = $event.target;
		var typeVal = target.getAttribute('data-val');
		$scope.couponInfo.couponType = typeVal;
		// 满赠券隐藏掉一些不需要进行设置的字段
		if(typeVal==4){
			$('.hidden_type').hide();
			$('.hidden_type_show').show();
		}else{
			$('.hidden_type').show();
			$('.hidden_type_show').hide();
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
			'index_show': $scope.couponInfo.indexShow,
            'new_limit': $scope.couponInfo.newLimit,
			'needShare': $scope.couponInfo.needShare,
			'use_limit' : limit,
			'use_desc'  : $scope.couponInfo.instructions,
			'count'   	: $scope.couponInfo.number,
			'sort'   	: $scope.couponInfo.sort,
			'start'    	: $scope.couponInfo.effectTime,
			'end'   	: $scope.couponInfo.pastDueTime,
            'useEnd'   	: $scope.couponInfo.useEndTime,
            'useTimeType' : $scope.couponInfo.useTimeType,
            'useDays' : $scope.couponInfo.useDays,
			'use_type'  : $('input[name="use_type"]:checked').val(),
			'receive_limit' : receive,
			'couponType':$scope.couponInfo.couponType,
			'tradeLimit':$scope.couponInfo.tradeLimit,
		};
		var goods = {},g=0;
		$('#can-used_goods').find('.good-item').each(function(){
			var gid = $(this).find('.goods-info').data('gid');
			if(gid){
				goods['go_'+g] = {
					'id' 	: $(this).find('.goods-info').data('id'),
					'gid'	: gid,
					'name'	: $(this).find('.goods-info').data('gname')
				};
				g++;
			}
		});
		data.goods = goods;

		if(parseInt(data.use_type) == 2 && JSON.stringify(data.goods) == "{}"){
            layer.msg('请选择商品');
            return false;
        }

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
				url:    '/wxapp/coupon/save',
				data:   data
			}).then(function(response) {
				layer.close(index);
				layer.msg(response.data.em);
				if(response.data.ec== 200){
					window.location.href='/wxapp/coupon/index';
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
			dateFmt:'yyyy-MM-dd',
			minDate:today
		});
	}
	$(function(){
		let coupon_type=$('input[name="coupon-type"]:checked').data('val');
		if(coupon_type == 4){
			$('.hidden_type').hide();
			$('.hidden_type_show').show();
		}
	});

</script>
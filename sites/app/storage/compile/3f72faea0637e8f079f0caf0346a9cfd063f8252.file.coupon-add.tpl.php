<?php /* Smarty version Smarty-3.1.17, created on 2020-05-28 16:32:03
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/community/coupon-add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18848524615ecf7703060488-68014071%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f72faea0637e8f079f0caf0346a9cfd063f8252' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/community/coupon-add.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18848524615ecf7703060488-68014071',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shopType' => 0,
    'row' => 0,
    'goods' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5ecf77030e8d22_75761101',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ecf77030e8d22_75761101')) {function content_5ecf77030e8d22_75761101($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/coupon/css/index.css">
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
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-community-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
					<div class="input-rows">
						<label for=""><span class="red">*</span>优惠券名称：</label>
						<input type="text" class="cus-input" ng-model="couponInfo.name" placeholder="最多支持10个字">
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>发放总量：</label>
						<div class="input-groups">
							<input type="text" class="cus-input" ng-model="couponInfo.number" oninput="this.value=this.value.replace(/\D/g,'')">
							<span>张</span>
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
						<label for=""><span class="red">*</span>兑换所需积分：</label>
						<div class="input-groups">
							<input type="text" class="cus-input add-input"   ng-model="couponInfo.needPoints" oninput="this.value=this.value.replace(/\D/g,'')">
							<span>积分</span>
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
					<?php if ($_smarty_tpl->tpl_vars['shopType']->value!=23) {?>
					<!--<div class="input-rows">
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
					</div>-->
					<?php }?>
				</div>
				<div class="coupon-base-rules">
					<h4>基本规则</h4>
					<div class="input-rows">
						<label for=""><span class="red">*</span>每人限领：</label>
						<select name="" id="" class="cus-input add-input" ng-model="couponInfo.getLimit" ng-options="item for item in limitNumber">
						</select>
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>生效时间：</label>
						<input type="text" class="cus-input add-input" onclick="chooseDate()" ng-model="couponInfo.effectTime" onchange="">
					</div>
					<div class="input-rows">
						<label for=""><span class="red">*</span>过期时间：</label>
						<input type="text" class="cus-input add-input" onclick="chooseDate()" ng-model="couponInfo.pastDueTime" onchange="">
					</div>
					<div class="input-rows">
						<label for="">使用说明：</label>
						<textarea name="" id="" rows="3" class="cus-input"  ng-model="couponInfo.instructions"></textarea>
					</div>
					<!--新增会议版没有使用商品限制  shopType 22为会议版-->
				<div class="input-rows" style="display:none;">
					<label for="">使用商品：</label>
					<div class="cus-input" style="background-color: #fff;">
						<div class="choose-goodrange">
							<div class="radio-box">
									<span data-type="all">
										<input type="radio" name="use_type" id="allGood" value="1" <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cl_use_type']==2)) {?>checked<?php }?>>
										<label for="allGood">全店通用</label>
									</span>
								<span data-type="assign">
										<input type="radio" name="use_type" id="assignGood" value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cl_use_type']==2) {?>checked<?php }?>>
										<label for="assignGood">指定商品</label>
									</span>
							</div>
							<div class="choosegoods">
								<div class="allgood-tip" data-type="all" <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cl_use_type']==2)) {?>style="display: block;"<?php }?>>
								<p class="tip">保存后，不能更改成指定商品</p>
							</div>
							<div class="assigngood-tip" data-type="assign" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cl_use_type']==2) {?>style="display: block;"<?php }?>>
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
										<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
											<tr class="good-item">
												<td class="goods-info" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['gid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
"><p><?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
</p></td>
												<td class="right"><span class="del-good">删除</span></td>
											</tr>
											<?php } ?>
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
<?php echo $_smarty_tpl->getSubTemplate ("../modal-gift-select.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script>
    $(function(){
        if('<?php echo $_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['cl_id'];?>
' != ''){
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
            name:'<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_name'];?>
<?php }?>',
            number: '<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_count']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_count'];?>
<?php }?>',
            faceVal: '<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_face_val']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_face_val'];?>
<?php }?>',
            useLimitType:<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_use_limit']) {?>1<?php } else { ?>0<?php }?>,
            indexShow:<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_shop_show']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_shop_show'];?>
<?php } else { ?>0<?php }?>,
            useLimitVal:<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_use_limit']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_use_limit'];?>
<?php } else { ?>0<?php }?>,
            getLimit:"<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_receive_limit']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_receive_limit'];?>
张<?php } else { ?>不限<?php }?>",
            effectTime: '<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_start_time']) {?><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['row']->value['cl_start_time']);?>
<?php }?>',
            pastDueTime: '<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_end_time']) {?><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['row']->value['cl_end_time']);?>
<?php }?>',
            instructions: '<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_use_desc']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_use_desc'];?>
<?php }?>',
            needPoints  : <?php if ($_smarty_tpl->tpl_vars['row']->value['cl_need_points']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_need_points'];?>
<?php } else { ?>0<?php }?>,
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


        $scope.checkFaceVal=function(){
            var faceVal = $scope.couponInfo.faceVal;
            var limit   = $scope.couponInfo.useLimitVal;
            if($scope.couponInfo.useLimitType == 1 && faceVal > limit){
                layer.msg('订单限制金额必须大于等于优惠券的面值');
            }
        };
        $scope.saveCoupon   = function() {
            $needpoints=$scope.couponInfo.needPoints;
            if($needpoints <=0){
                layer.msg('兑换所需积分必须大于0');
                return false;
			}
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
                'id'		: '<?php if ($_smarty_tpl->tpl_vars['row']->value['cl_id']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['cl_id'];?>
<?php } else { ?>0<?php }?>',
                'name'      : $scope.couponInfo.name,
                'face_val'  : $scope.couponInfo.faceVal,
                'index_show': 0,
                'use_limit' : limit,
                'use_desc'  : $scope.couponInfo.instructions,
                'count'   	: $scope.couponInfo.number,
                'start'    	: $scope.couponInfo.effectTime,
                'end'   	: $scope.couponInfo.pastDueTime,
                'use_type'  : 0,
                'receive_limit' : receive,
				'couponType':1,
                'needPoints': $scope.couponInfo.needPoints,
            };
            /*var goods = {},g=0;
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
            data.goods = goods;*/

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
	                    window.location.href='/wxapp/community/couponList';
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


</script><?php }} ?>

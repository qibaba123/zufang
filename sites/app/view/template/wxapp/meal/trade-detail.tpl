<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/order/trade-detail.css">
<style>
    .tooltip-inner{
        max-width: 245px;
    }
    .right-price{
        width: 80px;
        display: inline-block;
        vertical-align: middle;
        text-align: left;
    }
    .yh-price{
        font-size: 14px;
    }
    .icon_full{
        display: inline-block;
        vertical-align: middle;
        font-size: 12px;
        color: #fff;
        background-color: #e2010c;
        font-style: normal;
        width: 16px;
        height: 16px;
        line-height: 16px;
        text-align: center;
        border-radius: 4px;
        margin-right: 3px;
        position: relative;
        top: -1px;
    }
    .real-price{
        font-size: 14px;
    }
</style>
<{if $isActivity == 1}>
<{include file="../common-second-menu.tpl"}>
<div class="page-trade-order-detail" style="margin-left: 130px">
    <{else}>
    <div class="page-trade-order-detail">
        <{/if}>
    <div class="app-init-container">
        <div class="step-region">
            <ul class="ui-step ui-step-4">
                <li class="<{if $row && $row['t_create_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        买家下单
                    </div>
                    <div class="ui-step-number">
                        1
                    </div>
                    <div class="ui-step-meta">
						<{if $row && $row['t_create_time']}><{date('Y-m-d H:i:s',$row['t_create_time'])}><{/if}>
                    </div>
                </li>
                <li class="<{if $row && $row['t_pay_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        付款至微信
                    </div>
                    <div class="ui-step-number">
                        2
                    </div>
                    <div class="ui-step-meta">
						<{if $row && $row['t_pay_time']}><{date('Y-m-d H:i:s',$row['t_pay_time'])}><{/if}>
                    </div>
                </li>
                <li class="<{if $row && $row['t_express_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        商家发货
                    </div>
                    <div class="ui-step-number">
                        3
                    </div>
                    <div class="ui-step-meta">
						<{if $row && $row['t_express_time']}><{date('Y-m-d H:i:s',$row['t_express_time'])}><{/if}>
					</div>
                </li>
                <li class="<{if $row && $row['t_finish_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        结算货款
                    </div>
                    <div class="ui-step-number">
                        4
                    </div>
                    <div class="ui-step-meta">
						<{if $row && $row['t_finish_time']}><{date('Y-m-d H:i:s',$row['t_finish_time'])}><{/if}>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content-region clearfix">
        	<div class="info-region">
        	    <h3 style="margin-top:0"><{if $row['t_type'] eq 1}><span class="tuan-tag">团</span><{elseif $row['t_type'] eq 2}><span class="tuan-tag">奖</span><{/if}>订单信息<span class="secured-title">担保交易</span></h3>
        	    <table class="info-table">
        	        <tbody>
        	            <tr>
        	                <th>订单编号：</th>
        	                <td><{if $row}><{$row['t_tid']}><{/if}><a href="javascript:;" data-toggle="tooltip" data-html="true" data-placement="top" title="外部订单号：22015236446325236655<br>支付流水号：142515658556665566"> 更多</a></td>
        	            </tr>
                        <{if $row['legworkNum']}>
                            <tr>
                                <th>顺序号：</th>
                                <td>
                                    <{$row['legworkNum']}>
                                </td>
                            </tr>
                            <{/if}>
        	            <tr style="display: table-row;">
        	                <th>订单类型：</th>
        	                <td><{if $row['t_meal_type']==1}>外卖<{else}>堂食<{/if}></td>
        	            </tr>
        	            <tr style="display: none;">
        	                <th>团编号：</th>
        	                <td>-</td>
        	            </tr>
        	            <tr style="display: none;">
        	                <th>归属网店：</th>
        	                <td>-</td>
        	            </tr>
        	            <tr>
        	                <th class="<{$row['t_pay_type']}>">付款方式：</th>
        	                <td><{$tradePay[$row['t_pay_type']]}></td>
        	            </tr>
        	            <tr>
        	                <th>买家：</th>
        	                <td><a href="/wxapp/meal/tradeList?buyer=<{$row['t_buyer_nick']}>" class="new-window" ><{if $row}><{$row['t_buyer_nick']}><{/if}></a></td>
        	            </tr>
                        <{if $row['t_room_num'] > 0}>
                            <tr>
                                <th>用餐人数：</th>
                                <td><{$row['t_room_num']}></td>
                            </tr>
                        <{/if}>
        	        </tbody>
        	    </table>
        	    <div class="dashed-line"></div>
        	    <table class="info-table">
        	        <tbody>
                    <{if $row['t_meal_type']==1}>
                        <tr>
                            <th>送达时间：</th>
                            <td><{$row['t_meal_send_time']}></td>
                        </tr>
        	            <tr>
        	                <th>收货信息：</th>
        	                <td>
        	                    <p><{$row['ma_province']}> <{$row['ma_city']}> <{$row['ma_zone']}> <{$row['ma_detail']}>, <{$row['ma_name']}>, <{$row['ma_phone']}></p>
        	                    <div><a href="javascript:;" data-clipboard-text="<{$row['ma_province']}> <{$row['ma_city']}> <{$row['ma_zone']}> <{$row['ma_detail']}>, <{$row['ma_name']}>, <{$row['ma_phone']}>" class="copy_input">[复制]</a>
        	                    </div>
        	                </td>
        	            </tr>
                    <{/if}>
        	            <tr>
        	                <th>买家留言：</th>
        	                <td><{$row['t_note']}></td>
        	            </tr>
        	        </tbody>
        	    </table>

                <div class="dashed-line"></div>
                <table style="margin-left: 100px;margin-top: 10px">
                    <tbody>
                    <tr>
                        <td><a class="confirm-handle btn btn-blue btn-xs" data-toggle="modal" data-target="#myPrintModal" style="text-align: center;line-height: 30px;width: 60px;border-radius: 5px;padding: 0;">小票打印</a></td>
                    </tr>
                    </tbody>
                </table>

        	</div>

        	<div class="state-region">
        	    <div style="padding: 0px 0px 30px 40px;">
        	        <h3 class="state-title"><span class="icon <{$desc['class']}>"><{$desc['icon']}></span>订单状态：<{if $row['t_express_method'] == 7}><{$legworkStatusNote[$row['t_status']]}><{else}><{$statusNote[$row['t_status']]}><{/if}></h3>
        	        <div class="state-desc">
                        <{$desc['desc']}>
        	        </div>
                    <{if $needSend && $row['t_meal_type'] == 1}>
                    <div class="state-btn">
                        <div class="btn btn-xs btn-blue" data-toggle="modal" data-target="#refund-form">发货</div>
                        <div class="btn btn-xs btn-link js-remark hide">备注</div>
                    </div>
                    <{/if}>
        	    </div>
        	    <div class="state-remind-region">
        	        <div class="dashed-line"></div>
        	        <div class="state-remind">
        	            <h4>温馨提示：</h4>
        	            <ul>
        	                <li>交易已成功，如果买家提出售后要求，请积极与买家协商，做好售后服务。</li>
        	            </ul>
        	        </div>
        	    </div>
        	</div>
        </div>
        <table class="ui-table ui-table-simple goods-table">
            <thead>
                <tr>
                    <th></th>
					<th class="cell-30">商品名称</th>
					<th>购买规格</th>
                    <th>单价(元)</th>
                    <th>数量</th>
                    <th class="cell-13">小计(元)</th>
                    <th>状态</th>
                </tr>
            </thead>
            <tbody>
                <tr class="tr-express">
                    <td><strong><{if $row['t_meal_type']==1}>外卖<{else}>堂食<{/if}></strong></td>
                    <{if $row['t_meal_type']==1}>
                    <td><span class="express-meta">配送员：<{if $row && $row['t_express_company']}><{$row['t_express_company']}><{/if}></span><span class="express-meta"><{if $row && $row['t_express_code']}>手机号：<{$row['t_express_code']}><{/if}></span></td>
                    <{/if}>
                </tr>
				<{foreach $list as $val}>
					<tr class="test-item">
						<td class="td-goods-image" rowspan="1">
							<div class="ui-centered-image" src="<{$val['to_pic']}>" width="48" height="48" style="width: 48px; height: 48px;">
								<img src="<{$val['g_cover']}>" style="max-width: 48px; max-height: 48px;"></div>
						</td>
						<td><a href="#" target="_blank"><{$val['to_title']}></a>
							<p class="c-gray"></p>
						</td>
						<td><{$val['gf_name']}></td>
						<td><{$val['to_price']}></td>
						<td><{$val['to_num']}></td>
						<td>
							<p><{$val['to_total']}></p>
							<div></div>
						</td>
						<td class="td-postage" ><{$statusNote[$row['t_status']]}></td>
					</tr>
				<{/foreach}>

            </tbody>
            <tfoot>
            <tr>
                <td colspan="9" class="text-right">
                    <{if $coupon}>
                    <{foreach $coupon as $cal}>
                    <p class="text-right">
                        <i class="icon_full">减</i><a href="javascript:;" ><{$cal['tc_c_name']}>：</a><span class="yh-price right-price"> &nbsp; - <{$cal['tc_discount_fee']}></span>
                </p>
                <{/foreach}>
                <{/if}>

                <{if $full}>
                <{foreach $full as $fal}>
                <p class="text-right">
                    <i class="icon_full">减</i><a href="javascript:;"><{$fal['tf_name']}>：</a><span class="yh-price right-price"> &nbsp; - <{$fal['tf_discount_fee']}></span>
                </p>
                <{/foreach}>
                <{/if}>
                    <{if $row['t_meal_type']==1}>
                    <{if $row['t_pack_fee']}>
                    <p class="text-right">
                        <span>餐盒费：</span><span class="yh-price right-price"> &nbsp; + <{$row['t_pack_fee']}></span>
                    </p>
                    <{/if}>
                    <{if $row['t_post_fee']}>
                    <p class="text-right">
                        <span>运费：</span><span class="yh-price right-price"> &nbsp; + <{$row['t_post_fee']}></span>
                    </p>
                    <{/if}>
                    <{/if}>
                    <p class="real-price"><span class="c-gray">实收总价：</span><span class="real-pay ui-money-income right-price">￥ <{$row['t_total_fee']}></span></p>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
	<!-- 物流详情弹出层 -->
    <div class="modal fade" id="logistics" tabindex="-1" role="dialog" 
       aria-labelledby="myModalLabel" aria-hidden="true">
       	<div class="modal-dialog" style="width:650px;">
          	<div class="modal-content">
             	<div class="modal-header">
                	<button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                	</button>
                	<h4 class="modal-title" id="logisticsLabel">
                   		物流详情
                	</h4>
             	</div>
             	<div class="modal-body">
    				<table class="ui-table ui-table-simple">
    				    <thead>
    				        <tr>
    				            <th class="cell-25">时间</th>
    				            <th class="cell-60">内容</th>
    				        </tr>
    				    </thead>
    				    <tbody>
							<{foreach $track as $key => $mal}>
    				        <tr <{if $key eq $last}>style="color: #390" <{/if}>>
    				            <td><{$mal['AcceptTime']}></td>
    				            <td><{$mal['AcceptStation']}></td>
    				        </tr>
							<{/foreach}>
    				    </tbody>
    				</table>
             	</div>
          	</div><!-- /.modal-content -->
    	</div><!-- /.modal -->
    </div>
</div>

<div id="refund-form"  class="modal fade">
    <div class="modal-dialog" style="width:760px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modelTitle">发货处理</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline form-horizontal">
                    <input type="hidden" id="hid_id" value="<{$row['t_tid']}>">
                    <input type="hidden" id="modal-type" value="express">
                    <input type="hidden" id="cate" value="detail">
                    <div class="row hid-row" id="show-express" style="margin:0">
                        <!--发货HTML-->
                        <table class="ui-table" style="margin-bottom:20px;">
                            <thead>
                                <tr>
                                    <th class="cell-35">商品</th>
                                    <th class="cell-5">数量</th>
                                    <th class="cell-5">单价</th>
                                    <th class="cell-5">总价</th>
                                </tr>
                            </thead>
                            <tbody id="buy-goods-modal">
                            <{foreach $list as $val}>
                                <tr>
                                    <td class="cell-35"><{$val['to_title']}></td>
                                    <td class="cell-5"><{$val['to_num']}></td>
                                    <td class="cell-5"><{$val['to_price']}></td>
                                    <td class="cell-5"><{$val['to_total']}></td>
                                </tr>
                            <{/foreach}>
                            </tbody>
                        </table>

                        <div class="control-group row" id="wuliu-info">
                            <div class="col-xs-6">
                                <label class="control-label">送餐员名称：</label>
                                <div class="controls">
                                    <input type="text" id="courier_name" name="courier_name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">联系电话：</label>
                                <div class="controls">
                                    <input type="text" id="courier_phone" name="courier_phone" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                <button type="button" class="btn btn-primary modal-save" onclick="expressMeal()" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- 打印小票-选择打印机-模态框 -->
<div class="modal fade" id="myPrintModal" tabindex="-1" role="dialog" aria-labelledby="myPrintLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myPrintLabel">
                    选择打印机
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">选择打印机</label>
                    <div class="col-sm-7">
                        <select id="printSn" name="printSn" class="form-control" data-placeholder="请选择一个打印机">
                            <{foreach $printlist as $val}>
                            <option value="<{$val['afl_sn']}>"><{$val['afl_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-print">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<{include file="../bs-alert-tips.tpl"}>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/wxapp-order.js"></script>
<script>

    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        //console.log("复制成功的内容是："+args.text);
        showTips('复制成功');
    } );

    $(function () { 
        /*提示消息*/
        $("[data-toggle='tooltip']").tooltip(); 

        // 下拉搜索框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true
        });

        /*添加备注信息*/
        $(".state-region").on('click', '.js-remark', function(event) {
            event.preventDefault();
            layer.prompt({
              title: '添加备注信息',
              formType: 2 //prompt风格，支持0-2
            }, function(text){
               layer.msg('备注信息：'+ text);
            });
        });

        // 更新物流信息
        $('#location_reload').on('click',function () {
            window.location.reload();
        });

        //选择打印机后，打印小票确认
        $('#confirm-print').on('click',function(){
            var tid   = '<{$row['t_tid']}>';
            var sn   = $('#printSn').val();
            var data = {
                tid  : tid,
                sn   : sn
            };
            if(data){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/meal/printOrder',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        if(ret.ec == 200){
                            layer.msg('订单发送成功，如果打印不成功请查看打印机是否在线');
                            $('#myPrintModal').modal('hide')
                        }
                    }
                });
            }
        });

    });
</script>
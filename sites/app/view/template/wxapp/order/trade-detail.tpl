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

    .page-trade-order-detail .info-table th {
        text-align: center;
    }

    .page-trade-order-detail .info-table td {
        color: #999;
        padding: 0 0 10px 0;
        vertical-align: top;
        font-size: 12px;
    }
</style>
<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> </object> 
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<{if $isActivity == 1}>
<{include file="../common-second-menu.tpl"}>
<div class="page-trade-order-detail" style="margin-left: 130px">
<{else}>
<div class="page-trade-order-detail">
<{/if}>
    <div class="app-init-container">
        <div class="step-region">
            <ul class="ui-step ui-step-4">
                <li class="<{if $row && $row['t_create_time']}>ui-step-done<{/if}>" <{if $noExpress == 1}> style="margin-left: 10%" <{/if}>>
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
                <li class="<{if $row && $row['t_pay_time']}>ui-step-done<{/if}>" >
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
                <{if $noExpress == 0}>
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
                <{/if}>
                <li class="<{if $row && $row['t_finish_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        结算货款
                    </div>
                    <div class="ui-step-number">
                        <{if $noExpress == 0}>4<{else}>3<{/if}>
                    </div>
                    <div class="ui-step-meta">
						<{if $row && $row['t_finish_time']}><{date('Y-m-d H:i:s',$row['t_finish_time'])}><{/if}>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content-region clearfix">
        	<div class="info-region">
        	    <h3 style="margin-top:0"><{if $row['t_type'] eq 1}><span class="tuan-tag">团</span><{elseif $row['t_type'] eq 2}><span class="tuan-tag">奖</span><{/if}>订单信息<!--<span class="secured-title">担保交易</span>--></h3>
        	    <table class="info-table">
        	        <tbody>
        	            <tr>
        	                <th>订单编号：</th>
        	                <td><{if $row}><{$row['t_tid']}><{/if}>
                                <!--<a href="javascript:;" data-toggle="tooltip" data-html="true" data-placement="top" title="外部订单号：22015236446325236655<br>支付流水号：142515658556665566"> 更多</a>-->
                            </td>
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
        	                <td>
                                <!--
                                <{if $row['t_applet_type'] == 11}>
                                    <{if $row['asaj_isleader'] == 1}>
                                        发起接龙活动订单
                                    <{else}>
                                        参与接龙活动订单
                                    <{/if}>
                                <{else}>
                                <{/if}>
                                -->
                                <{$tradeType[$row['t_applet_type']]}>
                            </td>
        	            </tr>
        	            <{if $row['t_applet_type'] == 11 && ($row['asa_title'] || $row['asg_id'])}>
                            <tr>
                                <th>活动名称：</th>
                                <td><{$row['asa_title']}></td>
                            </tr>
                            <tr>
                                <th>群组编号：</th>
                                <td><{$row['asg_id']}></td>
                            </tr>
                        <{/if}>
        	            <tr>
        	                <th class="<{$row['t_pay_type']}>">付款方式：</th>
        	                <td><{$tradePay[$row['t_pay_type']]}></td>
        	            </tr>
        	            <tr>
        	                <th>买家：</th>
                            <{if $appletCfg['ac_type'] == 32  || $appletCfg['ac_type'] == 36}>
                            <td><a href="/wxapp/sequence/tradeList?buyer=<{$row['t_buyer_nick']}>" class="new-window" ><{if $row}><{$row['t_buyer_nick']}><{/if}></a></td>
                            <{else}>
                            <td><a href="/wxapp/order/tradeList?buyer=<{$row['t_buyer_nick']}>" class="new-window" ><{if $row}><{$row['t_buyer_nick']}><{/if}></a></td>
                            <{/if}>

        	            </tr>
        	        </tbody>
        	    </table>
        	    <div class="dashed-line"></div>
        	    <table class="info-table">
        	        <tbody>

        	            <tr>
        	                <th>配送方式：</th>
                            <{if $row['t_express_method'] eq 2}>
                            <td>门店自取</td>
                            <{elseif $row['t_express_method'] eq 1}>
                            <td>商家配送</td>
                            <{elseif $row['t_express_method'] eq 6}>
                            <td>团长配送</td>
                            <{else}>
                            <td>快递配送</td>
                            <{/if}>
        	            </tr>
                        <{if $row['t_express_method'] != 2 && $row['t_addr_id'] > 0}>
        	            <tr>
        	                <th>收货信息：</th>
        	                <td>
        	                    <p><{$row['ma_province']}> <{$row['ma_city']}> <{$row['ma_zone']}> <{$row['ma_detail']}>, <{$row['ma_name']}>, <{$row['ma_phone']}></p>
        	                    <div><a href="javascript:;" data-clipboard-text="<{$row['ma_province']}> <{$row['ma_city']}> <{$row['ma_zone']}> <{$row['ma_detail']}>, <{$row['ma_name']}>, <{$row['ma_phone']}>" class="copy_input">[复制]</a>
        	                    </div>
        	                </td>
        	            </tr>
                        <{if $member && $member['m_id_num'] && isset($member['m_id_num'])}>
                        <tr>
                            <th>身份证号：</th>
                            <td>
                                <p><{$member['m_id_num']}></p>
                            </td>
                        </tr>
                        <{/if}>
                        <{elseif ($row['t_express_method'] eq 2 || $row['t_express_method'] eq 6 || $row['t_express_company'] || $row['t_express_code'])}>
                        <{if $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36}>
                        <tr>
                            <th>自取门店：</th>
                            <td>
                                <{if $row['t_es_id'] > 0}>
                                <{$row['es_name']}>
                                <{else}>
                                <{$row['os_name']}>
                                <{/if}>

                            </td>
                        </tr>
                        <{/if}>
                        <{if $row['t_express_method'] == 6}>
                            <tr>
                                <th>收货人：</th>
                                <td>
                                    <{$row['t_express_company']}>   <{$row['t_express_code']}>
                                </td>
                            </tr>
                            <tr>
                                <th>地址：</th>
                                <td>
                                    <{$row['t_address']}>
                                </td>
                            </tr>
                        <{else}>
                        <tr>
                            <th>自取人：</th>
                            <td>
                                <{$row['t_express_company']}>   <{$row['t_express_code']}>
                            </td>
                        </tr>
                        <{/if}>
                        <{/if}>

                        <{if $deduct_row && $deduct_row['asd_money'] > 0}>
                            <tr>
                                <th>团长佣金：</th>
                                <td>
                                    <{$deduct_row['asd_money']}>
                                </td>
                            </tr>
                        <{/if}>
                        <{if $row['t_express_note']}>
                            <tr>
                                <th>物流备注：</th>
                                <td>
                                    <{$row['t_express_note']}>
                                </td>
                            </tr>
                            <{/if}>
        	            <tr>
        	                <th>买家留言：</th>
        	                <td><{$row['t_note']}></td>
        	            </tr>
                        <{foreach $row['t_remark_extra'] as $val}>
                            <tr>
                                <th><{$val['name']}>：</th>
                                <{if $val['type'] == 'image'}>
                                <td><img src="<{$val['value']}>" alt="" style="height: 100px; width: 100px"></td>
                                <{elseif $val['type'] == 'checkbox'}>
                                <td>
                                <{foreach $val['value'] as $vv}>
                                <{$vv}>，
                                <{/foreach}>
                                </td>
                                <{else}>
                                <td><{$val['value']}></td>
                                <{/if}>
                            </tr>
                        <{/foreach}>
        	        </tbody>
        	    </table>

                <div class="dashed-line"></div>
                <table style="margin-left: 10px;margin-top: 10px">
                    <tbody>
                    <tr>
                        <td><a class="confirm-handle btn btn-blue btn-xs" data-toggle="modal" data-target="#myPrintModal" style="text-align: center;line-height: 30px;width: 60px;border-radius: 5px;padding: 0;">小票打印</a></td>
                        <{if $appletCfg['ac_s_id'] == 5655}>
                        <td><a class="confirm-handle btn btn-blue btn-xs" onclick="printLodop()" style="text-align: center;line-height: 30px;width: 60px;border-radius: 5px;padding: 0;">面单打印</a></td>
                        <{/if}>
                    </tr>
                    </tbody>
                </table>
        	</div>

        	<div class="state-region">
        	    <div style="padding: 0px 0px 30px 40px;">
        	        <h3 class="state-title"><span class="icon <{$desc['class']}>"><{$desc['icon']}></span>订单状态：<{if $row['t_express_method'] == 7}><{$legworkStatusNote[$row['t_status']]}><{else}><{$statusNote[$row['t_status']]}><{/if}></h3>
        	        <div class="state-desc">
                        <{$desc['desc']}>
                        <{if $row['t_refund_time'] && $row['t_status'] == 8}>
                        &nbsp;<{date('Y-m-d H:i',$row['t_refund_time'])}>
                        <{/if}>
        	        </div>
                    <{if $needSend && $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36}>
                    <div class="state-btn">
                        <div class="btn btn-xs btn-blue" data-toggle="modal" data-target="#refund-form">发货</div>
                        <div class="btn btn-xs btn-link js-remark hide">备注</div>
                    </div>
                    <{/if}>
        	    </div>
        	    <div class="state-remind-region">
        	        <div class="dashed-line"></div>
        	        <div class="state-remind">
        	            <h4>交易提醒：</h4>
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
					<th class="cell-30"><{if $goodsName}><{$goodsName}><{else}>商品<{/if}>名称</th>
					<th>购买规格</th>
                    <th>单价(元)</th>
                    <th>数量</th>
                    <th class="cell-13">小计(元)</th>
                    <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                    <th>自提/配送时间</th>
                    <{/if}>
                    <th>状态</th>
                    <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                    <th>操作</th>
                    <{/if}>
                </tr>
            </thead>
            <tbody>
                <tr class="tr-express">
                    <{if $row['t_express_method'] != 2 && $row['t_express_method'] != 6}>
                    <td><strong>包裹 - 1</strong></td>
                    <td><span class="express-meta"><{if $row && $row['t_express_company']}><{$row['t_express_company']}><{/if}></span><span class="express-meta"><{if $row && $row['t_express_code']}>运单号：<{$row['t_express_code']}><{/if}></span></td>
                    <td colspan="7"><span class="express-meta express-latest-news"><{$nowStatus}></span>
                        <{if $row && $row['t_express_code']}>
                        <a href="javascript:;" data-toggle="modal" data-target="#logistics">更多</a>
                    &nbsp;&nbsp;&nbsp;<a href="javascript:;" id="location_reload">更新</a>
                        <{/if}>
                    </td>
                    <{/if}>
                </tr>
				<{foreach $list as $val}>
					<tr class="test-item">
						<td class="td-goods-image" rowspan="1">
							<div class="ui-centered-image" src="<{$val['to_pic']}>" width="48" height="48" style="width: 48px; height: 48px;">
								<img src="<{$val['g_cover']}>" style="max-width: 48px; max-height: 48px;"></div>
						</td>
						<td>
                            <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                            <a href="/wxapp/sequence/goodsEdit/?id=<{$val['to_g_id']}>" target="_blank"><{$val['to_title']}></a>
                            <{else}>
                            <a href="/wxapp/goods/newAdd/?id=<{$val['to_g_id']}>" target="_blank"><{$val['to_title']}></a>
                            <{/if}>
							<p class="c-gray"></p>
						</td>
						<td><{$val['to_gf_name']}></td>
						<td><{$val['to_price']}></td>
						<td><{$val['to_num']}></td>
						<td>
							<p><{$val['to_total']}></p>
							<div></div>
						</td>
                        <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                        <td><{$val['sendDate']}></td>
                        <{/if}>
						<td class="td-postage" >
                            <{if $val['to_se_verify'] == 1}>
                            已完成
                            <{else}>
                                 <{if $val['to_fd_result'] != 2}>
                                    <{$statusNote[$row['t_status']]}>
                                 <{else}>
                                    <span style="color: red">已退款</span>
                                 <{/if}>
                                <{if $appletCfg['ac_type'] == 21 || ( $appletCfg['ac_type'] ==32)}>
                                    <{if $val.to_fd_status==4}>
                                        <p style='color: #9a999e;padding-top: 5px;'>等待「会计审核」处理中</p>
                                    <{else}>
                                        <{if $val['to_feedback'] == 0}>
                                            <{if $appletCfg['ac_type'] ==32}>
                                                <p style="margin-top: 5px"><a href="javasript:;" data-toid="<{$val['to_id']}>" data-status="<{$row['t_status']}>" class="refund-btn-seq">主动退款</a></p>
                                            <{else}>
                                                <p style="margin-top: 5px"><a href="javasript:;" data-toid="<{$val['to_id']}>" data-status="<{$row['t_status']}>" class="refund-btn">主动退款</a></p>
                                            <{/if}>
                                        <{else}>
                                            <p style="margin-top: 5px">
                                                <{if $val['to_fd_result'] == 1}>
                                                拒绝退款
                                                <{elseif $val['to_fd_result'] == 3}>
                                                撤销退款
                                                <{elseif $val['to_fd_result'] == 0}>
                                                申请退款
                                                <{else}>
                                                同意退款
                                                <{/if}>
                                            </p>
                                        <{/if}>
                                    <{/if}>
                                <{/if}>
                            <{/if}>
                        </td>
                        <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                        <td class="td-postage">
                            <{if $val['to_se_verify'] == 0 && in_array($val['t_status'],[3,4,5])}>
                            <span id="order_finish_<{$val['to_id']}>" class="btn btn-primary btn-xs " data-id="<{$val['to_id']}>" onclick="verifyTradeOrder(this)">核销商品</span>
                            <{/if}>
                        </td>
                        <{/if}>
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
                    <{if $row['t_total_weight'] > 0}>
                    <p class="text-right">
                        <span>总重量：</span><span class="yh-price right-price"> &nbsp; <{$row['t_total_weight']}></span>
                    </p>
                    <{/if}>
                    <p class="text-right">
                        <span>运费：</span><span class="yh-price right-price"> &nbsp; <{$row['t_post_fee']}></span>
                    </p>
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
                                    <th class="cell-35"><{if $goodsName}><{$goodsName}><{else}>商品<{/if}></th>
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
                        <div class="control-group clearfix">
                            <label class="control-label">收货信息：</label>
                            <div class="controls">
                                <div class="control-action" id="modal-address">
                                    <{if $row['t_express_method'] != 2 && $row['t_addr_id'] > 0}>
                                    <span><{$row['ma_province']}> <{$row['ma_city']}> <{$row['ma_zone']}> <{$row['ma_detail']}>, <{$row['ma_name']}>, <{$row['ma_phone']}></span>
                                    <{elseif ($row['t_express_method'] eq 2 || $row['t_express_company'] || $row['t_express_code'])}>
                                    <span>
                                        <{if $row['t_es_id'] > 0}>
                                            <{$row['es_name']}>
                                            <{else}>
                                            <{$row['os_name']}>
                                        <{/if}>
                                    </span>
                                    <span style="padding-left: 5px">
                                        <{$row['t_express_company']}>   <{$row['t_express_code']}>
                                    </span>
                                    <{/if}>
                                </div>
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label">发货方式：</label>
                            <div class="controls">
                                <label class="radio inline">
                                    <input type="radio" data-validate="no" checked="" value="1" data-id="1" name="no_express"><span style="padding: 1px 5px;">需要物流</span>
                                </label>
                                <label class="radio inline">
                                    <input type="radio" data-validate="no" value="0" data-id="0" name="no_express"><span style="padding: 1px 5px;">无需物流</span>
                                </label>
                                <label class="radio inline">
                                    <input type="radio" data-validate="no" value="2" data-id="2" name="no_express"><span style="padding: 1px 5px;">商家配送</span>
                                </label>
                            </div>
                        </div>
                        <div class="control-group row" id="wuliu-info">
                            <div class="col-xs-6">
                                <label class="control-label">物流公司：</label>
                                <div class="controls">
                                    <select id="express_id" name="express_id" class="form-control chosen-select" data-placeholder="请选择一个物流公司">
                                        <option value="0"></option>
                                        <{foreach $express as $key=>$val}>
                                        <option value="<{$key}>"><{$val}></option>
                                        <{/foreach}>
                                    </select>
                                    <p class="tip hide">*发货后，10分钟内可修改一次物流信息</p>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">快递单号：</label>
                                <div class="controls">
                                    <input type="text" id="express_code" name="express_code" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <{if $expressNote == 1}>
                        <div class="control-group row" id="shop-express-note" style="display: none;">
                            <div class="col-xs-10">
                                <label class="control-label">备注：</label>
                                <div class="controls">
                                    <textarea id="express_note" name="express_note" cols="30" rows="5" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                        <{/if}>
                        <div class="control-group row" id="shop-sned-info" style="display: none;">
                            <div class="col-xs-6">
                                <label class="control-label">配送员名称：</label>
                                <div class="controls">
                                    <input type="text" id="delivery_name" name="delivery_name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">配送员电话：</label>
                                <div class="controls">
                                    <input type="text" id="delivery_mobile" name="delivery_mobile" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                <button type="button" class="btn btn-primary modal-save" onclick="expressTrade()" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
<script type="text/javascript" src="/public/wxapp/mall/js/order.js"></script>
<script type="text/javascript" src="/public/plugin/lodop/LodopFuncs.js"></script>
<script>
    <{if $appletCfg['ac_s_id'] == 5655}>
        function printLodop(){
            var LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));
            LODOP.PRINT_INIT("打印任务名");               //首先一个初始化语句
            LODOP.ADD_PRINT_TEXT(0,0,100,20,"文本内容一");//然后多个ADD语句及SET语句
            LODOP.PREVIEW();                         //最后一个打印(或预览、维护、设计)语句
        }
    <{/if}>

    var rowJson = '<{$rowJson}>';
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
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
        })

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
                    'url'   : '/wxapp/order/printOrder',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        if(ret.ec == 200){
                            layer.msg('订单发送成功，如果打印不成功请查看打印机是否在线');
                            $('#myPrintModal').modal('hide')
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }
        });

        //单个订单退款
        $('.refund-btn').on('click',function(){
            var toid  = $(this).data('toid');
            var status = $(this).data('status');
            var msg = '你确定要给该订单退款吗？';
            if(status==4){
                msg = '该订单已发货确定要退款吗？'
            }
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'toid'  : toid,
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/orderRefund',
                    'data'  : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }, function() {

            });
        });

        // 社区团购的单品退款
        $('.refund-btn-seq').on('click',function(){
            var toid  = $(this).data('toid');
            var status = $(this).data('status');
            var msg = '你确定要给该订单退款吗？';
            if(status==4){
                msg = '该订单已发货确定要退款吗？'
            }
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'toid'  : toid,
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/tradeOrderRefund',
                    'data'  : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }, function() {

            });
        });
    });
    function verifyTradeOrder(ele) {
        layer.confirm('确定核销此商品？', {
            btn: ['确定','取消'], //按钮
            title : '核销'
        }, function(){

            var id = $(ele).data('id');
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/finishSequenceTradeOrder',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }
</script>
<link rel="stylesheet" href="/public/manage/order/trade-detail.css">
<style>
    .tooltip-inner{
        max-width: 245px;
    }
    .ui-step li{
        width: 33.325%;
    }
    .page-trade-order-detail{
        padding: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
    }
    .page-trade-order-detail h3{
        margin:0;
    }
    .page-trade-order-detail .state-region .state-title .icon.info{
        color: #07d;
        border-color: #07d;
    }
    .page-trade-order-detail .info-region .info-goods {
        zoom: 1;
        margin: 10px 0;
        overflow: hidden;
    }
    .page-trade-order-detail .info-region .info-goods .info-goods-content {
        margin-left: 70px;
    }
    .page-trade-order-detail .info-region .info-goods .info-goods-content div{
        font-family: '黑体';
        line-height: 1.2;
    }
    .page-trade-order-detail .info-region .info-goods .ui-centered-image {
        float: left;
    }
    .ui-centered-image {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        width: 60px;
        height: 60px;
    }
    .ui-centered-image img {
        max-width: 60px;
        max-height: 60px;
        border: 0;
        vertical-align: middle;
    }
    .page-trade-order-detail .state-region .state-desc {
        margin-bottom: 30px;
        color: #666;
    }
    .page-trade-order-detail .state-region .state-desc div,.page-trade-order-detail .state-region .state-desc p ,.page-trade-order-detail .state-region .state-desc em{
        font-family: '黑体';
        line-height: 1.2;
    }
    .page-trade-order-detail .state-region .state-desc em {
        color: #f60;
        font-style: normal;
    }
    .page-trade-order-detail .safeguard-log h3 {
        font-size: 14px;
        font-weight: bold;
    }
    .page-trade-order-detail .safeguard-log .send-comments {
        color: #07d;
        position: absolute;
        right: 16px;
        top: 16px;
        cursor: pointer;
    }
    .page-trade-order-detail .state-remind li {
        color: #999;
        font-size: 12px;
        font-family: '黑体';
    }
    .form-horizontal {
        margin-bottom: 30px;
        width: auto;
    }
    .reply-comments {
        display: none;
    }
    .form-horizontal.reply-comments {
        margin: 20px 0 0 0;
        font-family: '黑体';
    }
    .page-trade-order-detail .safeguard-log {
        /*border: 1px solid #e5e5e5;
        padding: 15px;*/
        padding: 10px 0;
        position: relative;
    }
    .page-trade-order-detail .safeguard-log h3 {
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .page-trade-order-detail .safeguard-log .send-comments {
        color: #07d;
        position: absolute;
        right: 16px;
        top: 16px;
        cursor: pointer;
        font-family: '黑体';
    }
    .page-trade-order-detail .safeguard-log table {
        width: 97%;
        margin:0 auto;
    }
    .page-trade-order-detail .safeguard-log td {
        padding: 2px 0;
        font-size: 13px;
        font-family: '黑体';
    }
    .page-trade-order-detail .safeguard-log .tr-title td {
        padding: 10px 0 0 0;
        /*border-bottom: 1px dashed #e5e5e5;*/
    }
    .page-trade-order-detail .safeguard-log .tr-title td:first-child {
        font-weight: bold;
    }
    .page-trade-order-detail .safeguard-log .td-time {
        color: #999;
    }
    .page-trade-order-detail .safeguard-log td {
        padding: 2px 0;
    }
    .page-trade-order-detail .safeguard-log .tr-title+tr td {
        padding-top: 10px;
    }
    .page-trade-order-detail .safeguard-log .td-meta {
        color: #999;
        width: 70px;
    }
    .form-horizontal.reply-comments .controls {
        margin-left: 0;
    }
    .form-horizontal.reply-comments .reply-dialog textarea {
        margin-top: 0px;
        margin-bottom: 0px;
        height: 124px;
        border-radius: 0;
        width: 100%;
        margin-bottom: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        resize: vertical;
    }
    .form-horizontal.reply-comments .reply-dialog .inputer-actions {
        padding: 9px 14px;
        border-left: 1px solid #cccccc;
        border-bottom: 1px solid #cccccc;
        border-right: 1px solid #cccccc;
        height: 16px;
        line-height: 16px;
        text-align: right;
    }
    .form-horizontal.reply-comments .reply-dialog .actions {
        height: 40px;
    }
    .form-horizontal.reply-comments .reply-dialog .actions .postComment {
        float: right;
        margin: 9px 14px 0 0;
    }
    .form-horizontal.reply-comments .reply-dialog .images {
        margin: -24px 100px 0 0;
    }
    .form-horizontal.reply-comments .reply-dialog .images .image {
        position: relative;
        display: inline-block;
        margin-right: 20px;
        cursor: pointer;
    }
    .form-horizontal.reply-comments .reply-dialog .images .image .add-image {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        width: 60px;
        height: 60px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border: 2px dashed #e5e5e5;
        font-size: 30px;
        color: #e5e5e5;
    }
    .form-horizontal .control-label {
        float: left;
        width: 160px;
        padding-top: 5px;
        text-align: right;
    }
    .alert {
        padding: 12px 35px 12px 15px;
        color: #333;
        background-color: #FFF5CB;
        border-color: #FDEEB2;
        border-radius: 0;
        font-size: 12px;
        font-family: "黑体";
    }
    .form-horizontal .control-group {
        margin-bottom: 10px;
    }
    .form-horizontal .control-label {
        width: 120px;
        font-size: 14px;
        line-height: 18px;
        font-family: "黑体";
    }
    .form-horizontal .control-action {
        padding-top: 5px;
        display: inline-block;
        font-size: 14px;
        line-height: 18px;
        font-family: "黑体";
    }
    .form-horizontal .controls {
        margin-left: 130px;
        word-break: break-all;
    }
    .line{
        margin: 10px 0;
        height: 1px;
        background-color: #e8e8e8;
    }
    .alert-applet-code{padding-top:5px;padding-bottom: 5px; }
    .alert-applet-code .applet-pay{display: inline-block;vertical-align: middle;height: 32px;position: relative;box-sizing: border-box;}
    .alert-applet-code .applet-pay .icon_applet{height: 32px;width: 32px;vertical-align: middle;display: block;}
    .alert-applet-code .applet-pay .pay-code-box{border:1px solid #ddd; background-color:#fff;position: absolute;top:50px;left:50%;margin-left: -110px;width: 220px;padding: 15px;box-sizing: border-box; z-index: 2;display: none;}
    .alert-applet-code .applet-pay .pay-code-box:before,.alert-applet-code .applet-pay .pay-code-box:after{content:'';position: absolute;left:50%;top:-15px;margin-left:-8px;border-width: 8px;border-style: dashed dashed solid dashed;border-color: transparent transparent #fff transparent;z-index: 2;}
    .alert-applet-code .applet-pay .pay-code-box:after{z-index: 1;border-color: transparent transparent #ddd transparent;top:-16px;}
    .alert-applet-code .applet-pay:hover .pay-code-box{display: block;}
    .alert-applet-code .applet-pay .pay-code-box img{width: 180px;height: 180px;margin:0 auto;}
    .alert-applet-code .applet-pay .pay-code-box p{font-size: 13px;display: block;margin:0;margin-top: 8px;line-height: 2;text-align: center;}
</style>
    <div class="page-trade-order-detail">
    <!--
    <div class="page-trade-order-detail">
-->

    <div class="app-init-container">
        <div class="step-region">
            <ul class="ui-step ui-step-4">
                <li class="<{if $refund && $refund['tr_create_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        买家发起维权
                    </div>
                    <div class="ui-step-number">
                        1
                    </div>
                    <div class="ui-step-meta">
						<{if $refund && $refund['tr_create_time']}><{date('Y-m-d H:i:s',$refund['tr_create_time'])}><{/if}>
                    </div>
                </li>
                <li class="<{if ($refund && $refund['tr_note_time']) || ($refund && $refund['tr_finish_time'])}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
						处理中
                    </div>
                    <div class="ui-step-number">
                        2
                    </div>
                    <div class="ui-step-meta">
						<{if $refund && $refund['tr_note_time']}><{date('Y-m-d H:i:s',$refund['tr_note_time'])}><{/if}>
                    </div>
                </li>
                <li class="<{if $refund && $refund['tr_finish_time']}>ui-step-done<{/if}>">
                    <div class="ui-step-title">
                        处理完成
                    </div>
                    <div class="ui-step-number">
                        3
                    </div>
                    <div class="ui-step-meta">
						<{if $refund && $refund['tr_finish_time']}><{date('Y-m-d H:i:s',$refund['tr_finish_time'])}><{/if}>
					</div>
                </li>
            </ul>
        </div>
        <div class="content-region clearfix">
            <div class="info-region" style="padding: 15px;">
                <h3>售后维权</h3>
                <div>
                    <div class="info-goods">
                        <div class="ui-centered-image" src="<{$row['t_pic']}>"><img src="<{$row['t_pic']}>"></div>
                        <div class="info-goods-content">
                            <div><{$row['t_title']}></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="dashed-line"></div>
                </div>
                <table class="info-table">
                    <tbody>
                        <tr class="hide">
                            <th>期望结果：</th>
                            <td><span class="color-orange">仅退款</span></td>
                        </tr>
                        <tr>
                            <th>退款金额：</th>
                            <td><span class="color-orange"><{$refund['tr_money']}></span>
                                元
                                <{if $row['t_type'] != 6}>
                                <span>(含运费<{$row['t_post_fee']}>元)</span></td>
                                <{/if}>
                        </tr>
                        <tr>
                            <th>维权原因：</th>
                            <td><{$refund['tr_reason']}></td>
                        </tr>
                        <tr>
                            <th>维权编号：</th>
                            <td><{$refund['tr_wid']}></td>
                        </tr>
                    </tbody>
                </table>
                <div class="dashed-line"></div>
                <table class="info-table">
                    <tbody>
                        <tr>
                            <th>订单编号：</th>
                            <td><a href="#"><{$refund['tr_tid']}></a></td>
                        </tr>
                        <tr>
                            <th>付款时间：</th>
                            <td><{if $row['t_pay_time']}><{date('Y-m-d H:i:s',$row['t_pay_time'])}><{/if}></td>
                        </tr>
                    </tbody>
                </table>
                <div class="dashed-line"></div>
                <table class="info-table">
                    <tbody>
                    <tr>
                        <th>预计到店时间：</th>
                        <td>
                            <{$row['t_meal_send_time']}>
                        </td>
                    </tr>
                    <tr>
                        <th>入住时间：</th>
                        <td>
                            <{date('Y-m-d',$row['t_receive_start_time'])}> ~ <{date('Y-m-d',$row['t_receive_end_time'])}>
                        </td>
                    </tr>
                    <tr>
                        <{if $row['t_express_method'] == 1}>
                        <th>入住人信息：</th>
                        <td>
                            <p>
                                <{foreach json_decode($row['t_express_company']) as $value}>
                                <{$value}>，
                                <{/foreach}>
                                <{$row['t_express_code']}></p>
                            <div><a href="javascript:;" data-clipboard-text="
        	                         <{foreach json_decode($row['t_express_company']) as $value}>
                                        <{$value}>，
                                    <{/foreach}>
                                    <{$row['t_express_code']}>
        	                    " class="copy_input">[复制]</a>
                            </div>
                        </td>
                        <{else}>
                        <th>取货人信息：</th>
                        <td>
                            <p><{$row['t_express_company']}> <{$row['t_express_code']}></p>
                        </td>
                        <{/if}>
                    </tr>
                    <tr>
                        <th>买家留言：</th>
                        <td><{$row['t_note']}></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        	<div class="state-region">
        	    <div style="padding: 0px 0px 30px 40px;">
        	        <h3 class="state-title">
                        <{if $row['t_feedback'] eq 1 && $row['t_fd_status'] eq 1}>
                        <span class="icon info">!</span>等待商家处理退款申请
                        <{elseif $row['t_feedback'] eq 1 && $row['t_fd_status'] eq 2}>
                        <!--<span class="icon success">√</span>商家 <{if isset($refundNote[$row['t_fd_result']])}><{$refundNote[$row['t_fd_result']]}><{/if}>退款申请  -->
                        <span class="icon info">!</span>等待买家处理
                        <{else}>
                        <span class="icon success">√</span>维权已解决
                        <{/if}>
                    </h3>
                    <{if $row['t_fd_status'] eq 1}>
        	        <div class="state-desc">
        	            <div>
        	                收到买家仅退款申请，请尽快处理。
                            <p>请在<span class="color-orange"><em id="remain-time"></em></span>处理本次退款，如逾期未处理，将自动同意退款。</p>
        	            </div>
        	        </div>
                    <{elseif $row['t_fd_status'] eq 2}>
                    <div class="state-desc">
                        <div>
                            你已拒绝买家的退款申请。
                            <p>如果买家在<span class="color-orange"><em id="remain-time"></em></span>未继续申请退款，维权将自动结束。</p>
                        </div>
                    </div>
                    <{else}>
                    <div class="state-desc">
                        <div>
                            维权已处理完毕。
                        </div>
                    </div>
                    <{/if}>

                    <div class="state-action">
                        <{if $canAgree && $row['t_fd_status'] eq 1}>
                        <div class="ui-btn ui-btn-<{if $alert['errno'] < 0}>default<{else}>primary<{/if}>" data-toggle="modal" data-target="#agreeTK">同意买家退款</div>
                        <{/if}>
                        <{if $canRefuse && $row['t_fd_status'] eq 1}>
                        <div class="ui-btn" data-toggle="modal" data-target="#refuseTK">拒绝退款申请</div>
                        <{/if}>
                    </div>
                    <div class="space" style="margin:5px 0;"></div>
                    <{if $row['t_status'] eq 6}>
                        <{if $canAgree && $alert['errmsg']}><!---商家可以同意退款 并且存在提示信息---->
                        <div class="alert alert-block  alert-applet-code alert-<{if $alert['errno'] < 0}>yellow<{else}>success<{/if}> ">
                            <i class="icon-bullhorn"></i>
                            <{$alert['errmsg']}>
                            <div class="applet-pay">
                                <img src="/public/wxapp/images/icon_applet.png" class="icon_applet" alt="小程序图标">
                                <div class="pay-code-box">
                                    <img src="/public/wxapp/images/qrc_miniapp.jpg" alt="小程序二维码">
                                    <p>微信扫码，手机端经营管理</p>
                                </div>
                            </div>
                        </div>
                        <{/if}>
                    <{else}>
                    <{if $canAgree}><!---商家可以同意退款 并且存在提示信息---->
                    <div class="alert alert-block alert-applet-code alert-<{if $alert['errno'] < 0}>yellow<{else}>success<{/if}> ">
                        <i class="icon-bullhorn"></i>
                        若同意退款，订单退款金额将从微信支付商户的余额中直接扣除。点击右侧可查看商户余额是否充足?
                        <div class="applet-pay">
                            <img src="/public/wxapp/images/icon_applet.png" class="icon_applet" alt="小程序图标">
                            <div class="pay-code-box">
                                <img src="/public/wxapp/images/qrc_miniapp.jpg" alt="小程序二维码">
                                <p>微信扫码，手机端经营管理</p>
                            </div>
                        </div>
                    </div>
                    <{/if}>
                    <{/if}>


        	    </div>
        	    <div class="state-remind-region">
        	        <div class="dashed-line"></div>
        	        <div class="state-remind">
        	            <h4>维权处理提醒：</h4>
        	            <ul>
                            <li>如果未发货，请点击同意退款给买家。</li>
                            <li>如果实际已发货，请主动与买家联系。</li>
                            <li>如果您逾期未处理，视作同意买家申请，系统将自动退款给买家。</li>
                        </ul>
        	        </div>
        	    </div>
        	</div>
        </div>
        <div class="safeguard-log">
            <h3>协商记录</h3>
            <table>
                <tbody>
                <{if $refundList}>
                <{foreach $refundList as $key=>$val}>
                    <tr class="tr-title">
                        <td>买家</td>
                        <td class="td-time"><{if $val['tr_create_time']}><{date('Y-m-d H:i:s',$val['tr_create_time'])}><{/if}></td>
                    </tr>
                    <tr>
                        <td class="td-meta">
                            退款原因：
                        </td>
                        <td><{$val['tr_reason']}></td>
                    </tr>
                    <tr>
                        <td class="td-meta">
                            退款金额：
                        </td>
                        <td><{$val['tr_money']}></td>
                    </tr>
                    <tr>
                        <td class="td-meta">
                            联系电话：
                        </td>
                        <td><{$val['tr_contact']}></td>
                    </tr>
                <{if $val['tr_status'] eq 1 }>
                    <{if $val['tr_finish_time']}>
                    <tr class="tr-title">
                        <td>商家</td>
                        <td class="td-time"><{if $val['tr_finish_time']}><{date('Y-m-d H:i:s',$val['tr_finish_time'])}><{/if}></td>
                    </tr>
                    <tr>
                        <td class="td-meta">
                            处理结果：
                        </td>
                        <td><{$refundNote[$row['t_fd_result']]}></td>
                    </tr>
                    <{elseif $val['tr_seller_note']}>
                    <tr class="tr-title">
                        <td>商家</td>
                        <td class="td-time"><{if $val['tr_note_time']}><{date('Y-m-d H:i:s',$val['tr_note_time'])}><{/if}></td>
                    </tr>
                    <tr>
                        <td class="td-meta">
                            处理结果：
                        </td>
                        <td>拒绝退款</td>
                    </tr>
                    <tr>
                        <td class="td-meta">
                            商家留言：
                        </td>
                        <td><{$val['tr_seller_note']}></td>
                    </tr>
                    <{/if}>
                    <tr><td colspan="2"><div class="line"></div></td></tr>
                <{/if}>
                <{/foreach}>
                <{/if}>
                </tbody>
            </table>
        </div>
    </div>
    <{if $canAgree}>
    <div class="modal fade" id="agreeTK" tabindex="-1" role="dialog"
       aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="agreeTKLabel">
                   维权处理
                </h4>
             </div>
             <div class="modal-body">
                <div class="alert">
                    该笔订单通过 “<span style="color: #f60;"><{$statusNote[$row['t_status']]}></span>” 付款， 需您同意退款申请，买家才能退货给您； 买家退货后您需再次确认收货后，退款将自动原路退回至买家付款账户；
                </div>
                <div class="form-horizontal" style="margin: 0;">
                    <div class="control-group">
                        <div class="control-label">处理方式：</div>
                        <div class="controls">
                            <div class="control-action">仅退款</div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">退款金额：</div>
                        <div class="controls">
                            <div class="control-action" style="color: #f60;">¥ <{$refund['tr_money']}></div>
                        </div>
                    </div>
                </div>
             </div>
             <div class="modal-footer">
                <button type="button" class="ui-btn ui-btn-primary btn-refund" data-type="<{$option['agree']}>">
                   同意
                </button>
             </div>
          </div>
    </div>
</div>


<div class="modal fade" id="refuseTK" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="refuseTKLabel">
               维权处理
            </h4>
         </div>
         <div class="modal-body">
            <div class="alert">
                建议您与买家协商后，再确定是否拒绝退款。如您拒绝退款后，买家可修改退款申请协议重新发起退款。
                也可直接发起维权申请，将会由有赞客满介入处理。
            </div>
            <div class="form-horizontal" style="margin: 0;">
                <div class="control-group">
                    <div class="control-label">处理方式：</div>
                    <div class="controls">
                        <div class="control-action">仅退款</div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label">退款金额：</div>
                    <div class="controls">
                        <div class="control-action" style="color: #f60;">¥ <{$refund['tr_money']}></div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="control-label">拒绝理由：</div>
                    <div class="controls">
                        <textarea name="reject_reason" id="note"  class="form-control" rows="3" placeholder="请填写您的拒绝理由" style="width:70%"></textarea>
                    </div>
                </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="ui-btn ui-btn-primary btn-refund" data-type="<{$option['refuse']}>">
               拒绝
            </button>
         </div>
      </div>
</div>

    <{/if}>
    <script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
    <script>
    $(function () {
        $("[data-toggle='tooltip']").tooltip(); 
    });


    /**
     *倒计时
     * 传值剩余秒输
     */
    var leftsecond = '<{$endTime}>';
    function _fresh(){
        if(leftsecond < 0){
            leftsecond = 0;
        }
        __d=parseInt(leftsecond/3600/24);
        __h=parseInt((leftsecond/3600)%24);
        __m=numGSH(parseInt((leftsecond/60)%60));
        __s=numGSH(parseInt(leftsecond%60));
        document.getElementById("remain-time").innerHTML=__d+"天"+__h+"小时"+__m+"分钟"+__s+"秒";
        leftsecond --;
        function numGSH(t){
            if(t<10){
                t="0"+t;
            }else{
                t=t;
            }
            return t;
        }
        setTimeout(_fresh,1000);
    }
    _fresh();

    /**
     * 退款逻辑实现
     */
    $('.btn-refund').on('click',function(){
        var status  = $(this).data('type');
        var note    = '';
        if(status == 1){ //拒绝记录拒绝原因
            note    = $('#note').val();
            if(!note) {
                layer.msg('请填写拒绝原因');
                return false;
            }
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'	: '<{$row['t_tid']}>',
            'status': status,
            'note'	: note
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/order/refundTrade',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });

    });

</script>
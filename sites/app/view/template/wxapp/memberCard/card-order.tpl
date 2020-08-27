<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .total-amount{
        margin-right: 25px;
    }
    .balance .balance-info{
        width: 20% !important;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <{include file="./tabal-link.tpl"}>
            <div class="tab-content"  style="z-index:1;">
                <!-- 汇总信息 -->
                <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                    <div class="balance-info">
                        <div class="balance-title">销售总次数<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['totalCount']}></span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">销售总人数<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['memberCount']}></span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">销售总金额<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['totalMoney']}></span>
                            <span class="unit">元</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">微信支付销售总金额<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['wxMoney']}></span>
                            <span class="unit">元</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">余额支付销售总金额<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['coinMoney']}></span>
                            <span class="unit">元</span>
                        </div>
                    </div>
                </div>
                <div class="page-header search-box">
                    <div class="col-sm-12">
                        <form action="/wxapp/membercard/cardOrder/type/<{$cardtype}>" method="get" class="form-inline">
                            <div class="col-xs-11 form-group-box">
                                <div class="form-container">
                                    <{if $cardtype != 2}>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">门店：</div>
                                            <select name="store" id="store" class="form-control">
                                                <option value="0">全部</option>
                                                <{if $appletCfg['ac_type'] == 6}>
                                                <{foreach $storeList as $key => $val}>
                                            <option value="<{$val['acs_id']}>" <{if $val['acs_id'] eq $store}> selected <{/if}>><{$val['acs_name']}></option>
                                                <{/foreach}>
                                                <{else}>
                                                <{foreach $storeList as $key => $val}>
                                                <option value="<{$val['os_id']}>" <{if $val['os_id'] eq $store}> selected <{/if}>><{$val['os_name']}></option>
                                                <{/foreach}>
                                                <{/if}>
                                            </select>
                                        </div>
                                    </div>
                                    <{/if}>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员卡：</div>
                                            <select name="card" id="card" class="form-control">
                                                <option value="0">全部</option>
                                                <{foreach $cardList as $key => $val}>
                                                <option value="<{$val['oc_id']}>" <{if $val['oc_id'] eq $card}> selected <{/if}>><{$val['oc_name']}></option>
                                                <{/foreach}>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员昵称：</div>
                                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>" placeholder="会员昵称">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">订单编号：</div>
                                            <input type="text" class="form-control" name="tid" value="<{$tid}>" placeholder="会员昵称">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-1 pull-right search-btn">
                                <button type="submit" class="btn btn-green btn-sm search-btn">查询</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <!--------------会员卡购买记录列表---------------->
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <th>购买人</th>
                                    <th>会员卡</th>
                                    <{if $cardtype != 2}>
                                    <th>门店</th>
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] == 28}>
                                    <th>公司</th>
                                    <{/if}>
                                    <th>金额</th>
                                    <th>状态</th>
                                    <th>付款方式</th>
                                    <{if $appletCfg['ac_type'] == 8}>
                                    <th>备注</th>
                                    <{/if}>
                                    <th>支付时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                <tr>
                                    <td><{$val['oo_buyer_nick']}></td>
                                    <td><{$val['oo_title']}></td>
                                    <{if $cardtype != 2}>
                                        <td>
                                        <{if $appletCfg['ac_type'] == 6}>
                                            <{if $storeList[$val['oo_st_id']]['acs_name']}>
                                            <{$storeList[$val['oo_st_id']]['acs_name']}>
                                            <{/if}>
                                            <{if $storeListOld[$val['oo_st_id']]['os_name']}>
                                            <{$storeListOld[$val['oo_st_id']]['os_name']}>
                                            <{/if}>
                                        <{else}>
                                            <{$storeList[$val['oo_st_id']]['os_name']}>
                                        <{/if}>
                                        </td>
                                        <!--
                                        <td><{$storeList[$val['oo_st_id']]['os_name']}></td>
                                        -->
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] == 28}>
                                    <td><{$val['ajc_company_name']}></td>
                                    <{/if}>
                                    <td><{$val['oo_amount']}></td>
                                    <td>
                                        <{if $val['oo_status'] eq 2}>已付款<{else}><span style="color: red">未支付</span><{/if}>
                                    </td>
                                    <td>
                                        <{if $val['oo_status'] eq 2}>
                                            <{if $val['oo_pay_type'] == 1}>微信支付<{elseif $val['oo_pay_type'] == 2}>余额支付<{/if}>
                                        <{/if}>
                                    </td>
                                    <{if $appletCfg['ac_type'] == 8}>
                                    <td style="max-width: 250px;overflow: hidden;white-space: normal">
                                        <{$val['oo_remark']}>
                                    </td>
                                    <{/if}>
                                    <td><{if $val['oo_pay_time']}><{date('Y-m-d H:i:s',$val['oo_pay_time'])}><{/if}></td>
                                </tr>
                                <{/foreach}>
                                <tr><td colspan="11"><{$pageHtml}></td></tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->

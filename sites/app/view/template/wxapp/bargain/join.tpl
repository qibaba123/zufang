<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/bindsetting.css">
<style>
    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: calc(100% / 4);
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div id="mainContent">
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">参与人数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$total}></span>
                <span class="unit"></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">商品总数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['buyNum']}></span>
                <span class="unit"></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">砍价总额<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['money']}></span>
                <span class="unit">元</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">总次数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['joinNum']}></span>
                <span class="unit">次</span>
            </div>
        </div>
    </div>
<!--
<div class="wrap">
    <div class="function" style="border: none;padding: 1px;">
        <div class="left">
            <table>
                <tr>
                    <td class="title">活动名称：</td>
                    <td colspan="3"><{$bargain['ba_name']}></td>
                </tr>
                <tr>
                    <td class="title">活动时间：</td>
                    <td colspan="3"><{date('Y-m-d H:i',$bargain['ba_start_time'])}> 至 <{date('Y-m-d H:i',$bargain['ba_end_time'])}></td>
                </tr>
                <tr>
                    <td class="title">商品单价：</td>
                    <td><{$bargain['ba_price']}></td>
                    <td class="title">商品总数：</td>
                    <td><{$bargain['ba_total']}></td>
                </tr>
                <tr>
                    <td class="title">活动状态：</td>
                    <td>
                        <span class="label label-sm label-<{$bargainStatus[$bargain['ba_status']]['css']}>"><{$bargainStatus[$bargain['ba_status']]['label']}></span>
                    </td>
                    <td class="title">参与情况：</td>
                    <td><{$total}>  次</td>
                </tr>

            </table>
        </div>

    </div>
</div>
-->
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                <thead>
                <tr>
                    <th>参与会员</th>
                    <th>头像</th>
                    <th>砍价次数</th>
                    <th>砍价总额</th>
                    <th>参与时间</th>
                    <th>是否购买</th>
                </tr>
                </thead>
                <tbody>
                <{foreach $list as $val}>
                    <tr>
                        <td><{$val['bj_m_nickname']}></td>
                        <td><img src="<{$val['bj_m_avatar']}>" width="50"></td>
                        <td><{if $val['bj_total']}><a href="/wxapp/bargain/effort?jid=<{$val['bj_id']}>" style="width: 10px; height: 5px;" class="btn-link"><{$val['bj_total']}></a><{/if}></td>
                        <td><{$val['bj_amount']}></td>
                        <td><{date('Y-m-d H:i',$val['bj_join_time'])}></td>
                        <td><span class="label label-sm label-<{$bargainBuy[$val['bj_has_buy']]['css']}>"><{$bargainBuy[$val['bj_has_buy']]['label']}></span></td>
                    </tr>
                    <{/foreach}>
                <tr><td colspan="6"> <{$paginator}></td></tr>
                </tbody>
            </table>
        </div><!-- /.table-responsive -->
    </div><!-- /span -->
</div><!-- /row -->
</div>


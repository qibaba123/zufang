<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .inline-div{
        line-height: 34px;
        padding-right: 0;
        padding-left: 0;
    }
</style>
<{include file="../common-second-menu-new.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <!--<div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>
        </div>-->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                           <th>支付金额</th>
                            <th>付费时长</th>
                            <th>支付方式</th>
                            <th>支付时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ams_id']}>">
                                <td><{$val['msp_money']}></td>
                                <td><{$val['msp_date']}>个月</td>
                                <td>
                                    <{if $val['msp_pay_type'] eq 1}>
                                    微信支付
                                    <{else}>
                                    余额支付
                                    <{/if}>
                                </td>
                                <td>
                                    <{date('Y-m-d H:i:s',$val['msp_create_time'])}>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="4"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>



<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>

</script>
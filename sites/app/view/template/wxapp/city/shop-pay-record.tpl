<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>


</style>
<div id="content-con">
    <!-- 推广商品弹出框 -->
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>支付金额</th>
                            <th>付费时长</th>
                            <!--<th>付费类型</th>-->
                            <th>支付方式</th>
                            <th>支付时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['cpp_id']}>">
                                <td>
                                    <{$val['cpp_money']}>
                                </td>
                                <td>
                                    <{if $val['cpp_top_time']}>
                                    <{$val['cpp_top_time']}>个月
                                    <{else}>
                                    12个月
                                    <{/if}>
                                </td>
                                <!--<td>
                                    <{if $val['cpp_acc_id'] eq 0}>
                                    续期付费
                                    <{else}>
                                    入驻付费
                                    <{/if}>
                                </td>-->
                                <td>
                                    <{if $val['cpp_pay_type'] eq 1}>
                                    微信支付
                                    <{else}>
                                    余额支付
                                    <{/if}>
                                </td>
                                <td>
                                    <{date('Y-m-d H:i:s',$val['cpp_create_time'])}>
                                </td>

                            </tr>
                            <{/foreach}>
                        <tr><td colspan="7"><{$pagination}></td></tr>
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
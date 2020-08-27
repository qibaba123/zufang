<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">推送时间</th>
                        <th>送达人数</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr id="tr_<{$val['aph_id']}>">
                            <td><{date('Y-m-d H:i:s',$val['aph_create_time'])}></td>
                            <td style="text-align: center;max-width: 80px;">
                                <{$val['aph_total']}>
                                <{if $val['aph_total'] == 0 && strstr($val['aph_error_msg'], 'invalid template_id')}>
                                <p style="color: red">请至微信公众平台查看模板消息是否存在或可用</p>
                                <{/if}>
                            </td>
                            <td>
                                <a href="/wxapp/tplpreview/receiveList/?id=<{$val['aph_id']}>" class="btn btn-xs btn-info deal-audit">
                                    查看
                                </a>
                            </td>
                        </tr>
                    <{/foreach}>
                    <{if $paginator}>
                        <tr><td colspan="5"><{$paginator}></td></tr>
                    <{/if}>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/withdraw-list.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js" ></script>

<script type="text/javascript" language="javascript">


</script>

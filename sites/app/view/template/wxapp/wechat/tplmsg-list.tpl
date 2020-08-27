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
    <div class="page-header" style="overflow:hidden">
        <div class="col-sm-12">
            <a class="btn btn-green btn-sm refresh-btn" href="/wxapp/wechat/tplmsgManage/?tplId=<{$tplid}>">
                <i class="icon-plus bigger-40"></i>  添加模版信息
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">模版ID</th>
                        <th>标题</th>
                        <th>提醒内容</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr id="tr_<{$val['wt_id']}>">
                            <td><{$val['wt_tplid']}></td>
                            <td><{$val['wt_title']}></td>
                            <td style="color: <{$val['color']}>"><{$val['remind']}></td>
                            <td><{date('Y-m-d H:i:s',$val['wt_update_time'])}></td>
                            <td>
                                <a href="/wxapp/wechat/tplmsgManage/?id=<{$val['wt_id']}>" class="btn btn-xs btn-info deal-audit">
                                    查看编辑
                                </a>
                                <!--
                                <a href="/manage/wechat/sendMsg?msgid=<{$val['wt_id']}>" class="btn btn-xs btn-info deal-audit">
                                    发送消息
                                </a>
                                -->
                                <a href="javascript:;" class="btn btn-xs btn-danger del-btn"
                                   data-id="<{$val['wt_id']}>">
                                    删除
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
    $('.del-btn').on('click',function(){
        var data = {
            'type'  : 'wxtplmsg',
            'id'    : $(this).data('id')
        };
        commonDeleteById(data);
    });


</script>

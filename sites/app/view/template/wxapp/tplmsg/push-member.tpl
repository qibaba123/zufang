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
<div >
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>用户头像</th>
                        <th>用户昵称</th>
                        <th>发送时间</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $val}>
                        <tr>
                            <td><img src="<{if $val['awt_m_avatar']}><{$val['awt_m_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="width: 50px" alt=""></td>
                            <td><{$val['awt_m_nickname']}></td>
                            <td><{date('Y-m-d H:i:s',$val['awt_send_time'])}></td>
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

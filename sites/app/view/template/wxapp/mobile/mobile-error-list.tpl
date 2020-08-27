<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
</style>
<{include file="../common-second-menu-new.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>报错人</th>
                            <th>报错人头像</th>
                            <th>店铺名称</th>
                            <th>报错原因</th>
                            <th>报错时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['mse_id']}>">
                                <td style="max-width: 120px"><{$val['m_nickname']}></td>
                                <td><img src="<{$val['m_avatar']}>" width="50"></td>
                                <td style="max-width: 300px"><{$val['ams_name']}></td>
                                <td style="max-width: 500px"><{$val['mse_remark']}></td>
                                <td><{if $val['mse_time'] > 0}><{date('Y-m-d H:i',$val['mse_time'])}><{/if}></td>
                                <td class="jg-line-color">
                                    <a href="/wxapp/mobile/shopEdit/id/<{$val['mse_ams_id']}>" >查看店铺</a> - 
                                    <a href="#" data-id="<{$val['mse_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="6"><{$pagination}></td></tr>
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
    function confirmDelete(ele) {
        var id = $(ele).data('id');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/mobile/deleteError',
	                'data'  : { id:id},
	                'dataType' : 'json',
	                success : function(ret){
	                    layer.close(loading);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
	                        window.location.reload();
	                    }
	                }
	            });
	        }
        });
    }
</script>

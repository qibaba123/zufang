<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
</style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="alert alert-block alert-yellow " >
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            可在小程序端个人中心处查看
        </div>
        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="/wxapp/currency/helpCenterInfoEdit" ><i class="icon-plus bigger-80"></i> 添加</a>

        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>排序权重</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ahci_id']}>">
                                <td><{$val['ahci_title']}></td>
                                <td><{$val['ahci_sort']}></td>
                                <td><{date('Y-m-d H:i:s', $val['ahci_update_time'])}></td>
                                <td>
                                    <a href="/wxapp/currency/helpCenterInfoEdit?id=<{$val['ahci_id']}>">编辑 - </a>
                                    <a href="#" data-id="<{$val['ahci_id']}>" onclick="confirmDelete(this)" style="color: red">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="4" style="text-align:right"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>


    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/currency/helpCenterInfoDelete',
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
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }
</style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="/wxapp/city/addRecommendShop"><i class="icon-plus bigger-80"></i>添加店铺</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>店铺名称</th>
                            <th>店铺分类</th>
                            <th>店铺地址</th>
                            <th>营业时间</th>
                            <th>店铺电话</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acs_id']}>">
                                <td>
                                    <{$val['acs_name']}>
                                </td>
                                <td>
                                    <{$categorySelect[$val['acs_category_id']]}>
                                </td>
                                <td>
                                    <{$val['acs_address']}>
                                </td>
                                <td>
                                    <{$val['acs_open_time']}>
                                </td>
                                <td>
                                    <{$val['acs_mobile']}>
                                </td>
                                <td><{date('Y-m-d H:i:s',$val['acs_create_time'])}></td>
                                <td>
                                    <a class="confirm-handle" href="/wxapp/city/addRecommendShop/id/<{$val['acs_id']}>">编辑</a>
                                    <a class="delete-btn" data-id="<{$val['acs_id']}>">删除</a>
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
    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/deleteShop',
                'data'  : {id:id},
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
    })
</script>
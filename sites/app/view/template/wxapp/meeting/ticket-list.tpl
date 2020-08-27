<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<div class="page-header">
    <a class="btn btn-green btn-xs" href="/wxapp/meeting/addTicket/amid/<{$amid}>" ><i class="icon-plus bigger-80"></i>添加票类</a>
</div>
<!--<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/meeting/meetingList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">票类名称</div>
                            <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="票类名称">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>-->
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>票类名称</th>
                            <th>票类总数</th>
                            <th>已购买数</th>
                            <th>票类价格</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['id']}>">
                                <td><{$val['name']}></td>
                                <td><{$val['total']}></td>
                                <td><{$val['buy_num']}></td>
                                <td><{$val['price']}></td>
                                <td><{date('Y-m-d', $val['createTime'])}></td>
                                <td>
                                    <a href="/wxapp/meeting/addTicket/amid/<{$amid}>/id/<{$val['id']}>" >编辑</a>-
                                    <a href="#" data-id="<{$val['id']}>" onclick="confirmDelete(this)">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <{$paginator}>
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        console.log($(this).data('cover'));
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#category-name').val();
        var data = {
            id     : id,
            name   : name
        };
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/saveAct',
                'data'  : data,
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

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
            layer.confirm('确定删除吗？', {
                title:'删除提示',
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/meeting/delTicket',
                    'data'  : { tid:tid},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            });
            /*var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/delTicket',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });*/
        }
    }
</script>
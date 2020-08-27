<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<{include file="../common-second-menu-new.tpl"}>

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs edit-category" href="#" data-id="0" data-name="" data-weight="" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加分类</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>分类名称</th>
                            <th>添加时间</th>
                            <th>排序权重</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['agk_id']}>">
                                <td><{$val['agk_name']}></td>
                                <td><{date('Y-m-d H:i:s', $val['agk_create_time'])}></td>
                                <td><{$val['agk_weight']}></td>
                                <td>
                                   <a href="javascript:;" class="edit-category" data-id="<{$val['agk_id']}>" data-name="<{$val['agk_name']}>" data-weight="<{$val['agk_weight']}>" data-toggle="modal" data-target="#myModal" >编辑</a>

                                    - <a href="javascript:;" onclick="confirmDelete(this)" data-id="<{$val['agk_id']}>" >删除</a>

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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">排序权重：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="请填写整数,越大越靠前" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{$cropper['modal']}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.edit-category').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        $('#category-weight').val($(this).data('weight'));
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#category-name').val();
        var weight   = $('#category-weight').val();
        var data = {
            id     : id,
            name   : name,
            weight   : weight
        };
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/appointment/saveKind',
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
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/appointment/deleteKind',
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
    }

//    $('.change_now').on('click',function(){
//        var id     =  $(this).data('id');
//        var type   =  $(this).data('type');
//        var str    = '';
//        var status = '';
//        if(type==1){
//            str    = '关闭';
//            status = 2;
//        }else{
//            str  = '开启';
//            status = 1;
//        }
//        var data = {
//            'id'     : id,
//            'status' : status
//        };
//        layer.confirm('您确认要'+str+'首页展示吗',function(){
//            $.ajax({
//                'type'  : 'post',
//                'url'   : '/wxapp/meeting/changeIndexStatus',
//                'data'  : data,
//                'dataType' : 'json',
//                success : function(ret){
//                    layer.msg(ret.em);
//                    if(ret.ec == 200){
//                        window.location.reload();
//                    }
//                }
//            });
//        },function(){
//
//        });
//    });



</script>
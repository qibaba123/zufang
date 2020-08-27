<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<{include file="../common-community-menu.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加分类</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>分类名称</th>
                            <th>权重</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['apk_id']}>">
                                <td><{$val['apk_name']}></td>
                                <td><{$val['apk_weight']}></td>
                                <td><{date('Y-m-d H:i',$val['apk_create_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['apk_id']}>" data-name="<{$val['apk_name']}>" data-weight="<{$val['apk_weight']}>">编辑</a>
                                     - <a href="#" data-id="<{$val['apk_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
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
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">分类名称：</label>
                    <div class="col-sm-10">
                        <input id="cate-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">排序权重：</label>
                    <div class="col-sm-10">
                        <input id="cate-weight" class="form-control" placeholder="请填写排序权重" style="height:auto!important"/>
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
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#cate-name').val($(this).data('name'));
        $('#cate-weight').val($(this).data('weight'));
    });
    $('#confirm-category').on('click',function(){
        var id = $('#hid_id').val();
        var name = $('#cate-name').val();
        var weight = $('#cate-weight').val();
        var data = {
            id   : id,
            name : name,
            weight: weight
        };
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/savePointsCategory',
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
                'url'   : '/wxapp/community/deletePointsCategory',
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
</script>
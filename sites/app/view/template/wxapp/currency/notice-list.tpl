<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs add-category" href="#" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加分类</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <!--
                <div class="choose-state">
                    <{foreach $type as $key=>$val}>
                <a href="/wxapp/reservation/goodsCategory" <{if $currType && $currType eq $key}>class="active"<{/if}>><{$val}></a>
                <{/foreach}>
                </div>
                -->
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>公告简介</th>
                            <th>权重</th>
                            <th>修改时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ca_id']}>">
                                <td><{$val['sn_brief']}></td>
                                <td><{$val['sn_weight']}></td>
                                <td><{date('Y-m-d H:i',$val['sn_create_time'])}></td>
                                <td style="color:#ccc;">
                                    <a class="confirm-handle btn btn-xs btn-primary" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['sn_id']}>" data-name="<{$val['sn_brief']}>" data-weight="<{$val['sn_weight']}>" >编辑</a>
                                    - <a  class=" btn btn-xs btn-danger"  href="#" data-id="<{$val['sn_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="5" class='text-right'><{$paginator}></td></tr>
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
                    添加科系
                </h4>
            </div>
            <div class="modal-body">
                <!--
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类类型：</label>
                    <div class="col-sm-8">
                        <div>
                            <select name="category-type" id="category-type" class="form-control">
                                <{foreach $type as $key=>$val}>
                                <option value="<{$key}>" <{if $key == $currType}>selected<{/if}>><{$val}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
                -->
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">公告简介：</label>
                    <div class="col-sm-8">
                        <input id="subject-name" class="form-control" placeholder="请填写公告简介" style="height:auto!important;height: 80px;"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">权重：</label>
                    <div class="col-sm-8">
                        <input id="subject-weight" class="form-control" placeholder="请填写权重" style="height:auto!important"/>
                    </div>
                </div>
                <!--
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类排序：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="数字越大，排序越靠后" style="height:auto!important"/>
                    </div>
                </div>
                -->
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
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#subject-name').val($(this).data('name'));
        $('#subject-weight').val($(this).data('weight'));
    });
    $('.add-category').on('click',function () {
        $('#hid_id').val('');
        $('#subject-name').val('');
        $('#subject-weight').val('');
//        $('#category-weight').val('');
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#subject-name').val();
        var weight = $('#subject-weight').val();
        var data = {
            id     : id,
            name   : name,
            weight : weight,
        };

        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/noticeSave',
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
        layer.confirm('确定删除吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/currency/noticeDeleted',
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
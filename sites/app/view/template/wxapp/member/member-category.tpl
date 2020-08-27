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
                            <th>分类名称</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['mc_id']}>">
                                <td><{$val['mc_name']}></td>
                                <td><{date('Y-m-d H:i',$val['mc_update_time'])}></td>
                                <td style="color:#ccc;">
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['mc_id']}>" data-name="<{$val['mc_name']}>" data-weight="0" >编辑</a>
                                    <{if $appletCfg['ac_type'] == 34}>
                                     - <a class="" href="/wxapp/legwork/memberLegworkPriceCfg?memberCate=<{$val['mc_id']}>"  >配送费用</a>
                                    <{/if}>
                                     - <a href="#" data-id="<{$val['mc_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <tr><td colspan="3" class='text-right'><{$pagination}></td></tr>
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
                <input type="hidden" value="<{$currType}>" name="category-type" id="category-type" >
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
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
        $('#category-name').val($(this).data('name'));
//        $('#category-weight').val($(this).data('weight'));
    });
    $('.add-category').on('click',function () {
        $('#hid_id').val('');
        $('#category-name').val('');
//        $('#category-weight').val('');
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#category-name').val();
//        var weight = $('#category-weight').val();
        var data = {
            id     : id,
            name   : name,
//            weight : weight,
        };
        
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/memberCategorySave',
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
                    'url'   : '/wxapp/member/memberCategoryDelete',
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
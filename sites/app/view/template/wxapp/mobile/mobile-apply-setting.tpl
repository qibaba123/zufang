<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<{include file="../common-second-menu-new.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="" data-weight="" ><i class="icon-plus bigger-80"></i> 添加收费配置</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>入驻月数</th>
                            <th>入驻费用</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['mac_id']}>">
                                <td><{$val['mac_data']}></td>
                                <td><{$val['mac_cost']}></td>
                                <td><{date('Y-m-d H:i:s', $val['mac_update_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="add-cost" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['mac_id']}>" data-name="<{$val['mac_data']}>" data-weight="<{$val['mac_cost']}>">编辑</a> - 
                                    <a href="#" data-id="<{$val['mac_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="4" style="text-align:right"><{$paginator}></td></tr>
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
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻时间：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写入驻时间" style="height:auto!important" type="number"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                    <div class="col-sm-8">
                    <span style="font-size: 12px;color: #666">入驻时间以“月”为单位，一年即12个月。</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻费用：</label>
                    <div class="col-sm-8">
                        <input id="category-weight" class="form-control" placeholder="请填写费用" style="height:auto!important"/>
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
    $('.add-cost').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        $('#category-weight').val($(this).data('weight'));
    });
    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var date   = $('#category-name').val();
        var cost = $('#category-weight').val();

        if(cost < 0){
            layer.msg('入驻费用填写有误');
            return false;
        }

        var data = {
            id     : id,
            date   : date,
            cost   : cost
        };
        if(date){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/mobile/saveApplySet',
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
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/mobile/deleteApplySet',
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
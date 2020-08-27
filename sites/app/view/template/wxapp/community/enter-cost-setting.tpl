<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>新增</button>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>入驻时间</th>
                            <th>入驻费用</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acec_id']}>">
                                <td><{$val['acec_desc']}></td>
                                <td><{$val['acec_cost']}></td>
                                <td><{date('Y-m-d H:i:s', $val['acec_update_time'])}></td>
                                <td>
                                    <a class="update-handle" href="#" data-toggle="modal" data-target="#updateModal"  data-id="<{$val['acec_id']}>" data-desc="<{$val['acec_desc']}>" data-cost="<{$val['acec_cost']}>">编辑</a>
                                    <a href="#" data-id="<{$val['acec_id']}>" onclick="confirmDelete(this)">删除</a>
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
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻时间：</label>
                    <div class="col-sm-8">
                        <select name="date" id="date" class="form-control" onchange="dateChange(this)">
                        <{foreach $costData as $val}>
                            <option value="<{$val['date']}>"><{$val['desc']}></option>
                        <{/foreach}>
                            <option value="-1">自定义</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="display: none" id="custom-cost">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                    <div class="col-sm-8">
                        <input type="number" value="" class="form-control col-sm-9" style="width: 60%" id="custom-date" name="custom-date"/>
                        <select name="custom-type" id="custom-type" class="form-control col-sm-3" style="width: 35%;margin-left: 5%">
                            <option value="1">天</option>
                            <option value="2">月</option>
                            <option value="3">年</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻费用：</label>
                    <div class="col-sm-8">
                        <input id="cost" type="number" class="form-control" placeholder="请填写入驻费用" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-add">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id = 'hid_id'/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻时间：</label>
                    <div class="col-sm-8">
                        <label id = "date-label" style="margin-top: 5px"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">入驻费用：</label>
                    <div class="col-sm-8">
                        <input id="update-cost" type="number" class="form-control" placeholder="请填写入驻费用" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-update">
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
    $('.update-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#date-label').text($(this).data('desc'));
        $('#update-cost').val($(this).data('cost'));
    });

    function dateChange(e){
        if($(e).val() == -1){
            $('#custom-cost').show();
        }else{
            $('#custom-cost').hide();
        }
    }

    $('#confirm-add').on('click',function(){
        var days   = $('#date').val();
        var cost   = $('#cost').val();
        if(days>-1){
            var desc   = $('#date').find("option:selected").text();
        }else{
            days = $('#custom-date').val();
            var type = $('#custom-type').val();
            if(type == 1){
                days = days;
                desc = days + '天';
            }
            if(type == 2){
                desc = days + '个月';
                days = days * 30;
            }
            if(type == 3){
                desc = days + '年';
                days = days * 365;
            }
        }

        var data = {
            date   : days,
            cost   : cost,
            desc   : desc
        };

        if(days){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/addInCharge',
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

    $('#confirm-update').on('click',function(){
        var id     = $('#hid_id').val();
        var cost   = $('#update-cost').val();
        var data = {
            id   : id,
            cost   : cost
        };

        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/addInCharge',
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
                'url'   : '/wxapp/community/deleteInCharge',
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
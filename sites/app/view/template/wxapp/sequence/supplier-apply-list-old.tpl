<link rel="stylesheet" href="/public/manage/css/bargain-list.css">


<div id="content-con">
    <div  id="mainContent" >
        <!--
        <div class="page-header">

        </div><!-- /.page-header -->

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/supplierApplyList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">用户名</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">会员编号</div>
                                    <input type="number" class="form-control" name="showid" value="<{$showid}>"  placeholder="会员编号">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="truename" value="<{$truename}>"  placeholder="姓名">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>用户名</th>
                            <th>会员编号</th>
                            <th>信息</th>
                            <th>备注</th>
                            <th>审核状态</th>
                            <th>处理时间</th>
                            <th>处理备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ass_id']}>">
                                <td>
                                    <img src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>'/public/wxapp/images/applet-avatar.png'<{/if}>" alt="" style="width: 50px">
                                </td>
                                <td><{$val['m_nickname']}></td>
                                <td><{$val['m_show_id']}></td>
                                <td>
                                    姓名：<{$val['ass_name']}><br>
                                    电话：<{$val['ass_mobile']}><br>
                                </td>
                                <td style="max-width:150px"><{$val['ass_remark']}></td>
                                <td>
                                    <{if $val['ass_status'] == 2}>
                                    <span style="color: green;"><{$statusNote[$val['ass_status']]}></span>
                                    <{elseif $val['ass_status'] == 3}>
                                    <span style="color:red"><{$statusNote[$val['ass_status']]}></span>
                                    <{else}>
                                    <{$statusNote[$val['ass_status']]}>
                                    <{/if}>
                                </td>
                                <td><{if $val['ass_handle_time']}><{date('Y-m-d H:i',$val['ass_handle_time'])}><{/if}></td>
                                <td style="max-width: 150px">
                                    <{$val['ass_handle_remark']}>
                                </td>
                                <td>
                                    <{if $val['ass_status'] eq 1}>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['ass_id']}>">处理</a>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>

                        <tr><td colspan="9"><{$pagination}></td></tr>

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
                    申请处理
                </h4>
            </div>
            <div class="modal-body" style="padding: 10px 15px !important;">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });
    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/supplierApplyHandle',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

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
                    'url'   : '/wxapp/gamebox/areaDelete',
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
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/meeting/participants" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">姓名</div>
                            <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="姓名" style="">
                            <input type="hidden" class="form-control" name="id" value="<{$id}>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">手机号</div>
                            <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="手机号" style="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">公司</div>
                            <input type="text" class="form-control" name="company" value="<{$company}>"  placeholder="公司" style="">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <div class="input-group">
                            <div class="input-group-addon">状态</div>
                            <select type="" class="form-control" name="status" style="">
                                <option value="0" selected="selected">全部</option>
                                <option value="1">已签到</option>
                                <option value="2">未签到</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>公司</th>
                            <th>票类</th>
                            <th>参会状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['tid']}>">
                                <td><{$val['name']}></td>
                                <td><{$val['mobile']}></td>
                                <td><{$val['company']}></td>
                                <td><{$val['ticket']}></td>
                                <{if $val['status']=='未签到'}>
                                <td style="color: red"><{$val['status']}></td>
                                <td  >
                                    <span onclick="confirm(this)" data-id="<{$val['tid']}>" style="cursor: pointer;color: #428bca;">签到</span>
                                    <span onclick="userDeleted(this)" data-id="<{$val['tid']}>" style="cursor: pointer;color: #FF0000;">删除</span>
                                    <span href="#" data-toggle="modal" data-target="#myModal<{$val['tid']}>" style="color: #428bca;">查看提交信息</span>
                                </td>
                                <{else}>
                                <td style="color: blue"><{$val['status']}></td>
                                <td>
                                    <span>签到</span>
                                    <span onclick="userDeleted(this)" data-id="<{$val['tid']}>" style="cursor: pointer;color: #FF0000;">删除</span>

                                    <span href="#" data-toggle="modal" data-target="#myModal<{$val['tid']}>" style="color: #428bca;">查看提交信息</span>
                                </td>
                                <{/if}>
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
<{foreach $list as $key => $val}>
    <div class="modal fade" id="myModal<{$val['tid']}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 535px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        提交信息
                    </h4>
                </div>
                <div class="modal-body">
                    <{foreach $val['remarkExtra'] as $k => $v}>
                    <{if $v['type'] != 'submit'}>
                    <{if $v['type'] == 'image'}>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><{$v['name']}>：</label>
                        <div class="col-sm-8">
                            <div><img src="<{$v['value']}>" alt="" style="width: 100px"/></div>
                        </div>
                    </div>
                    <{elseif $v['type'] == 'map'}>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><{$v['name']}>：</label>
                        <div class="col-sm-8">
                            <div><{$v['value'][0]}></div>
                        </div>
                    </div>
                    <{else}>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><{$v['name']}>：</label>
                        <div class="col-sm-8">
                            <div><{$v['value']}></div>
                        </div>
                    </div>
                    <{/if}>
                    <{/if}>
                    <{/foreach}>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <{/foreach}>
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
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/delMeeting',
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
    function confirm(ele){
        var tid=$(ele).data('id');
        if(tid){
            layer.confirm('确定改为已签到吗？', {
                title:'签到提示',
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/meeting/confirm',
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
        }
    }
    function userDeleted(ele){
        var tid=$(ele).data('id');
        if(tid){
            layer.confirm('确定删除吗？', {
                title:'删除提示',
                btn: ['确定','取消'] //按钮
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/meeting/userDeleted',
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
        }
    }
</script>
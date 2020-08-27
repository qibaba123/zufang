<link rel="stylesheet" href="/public/manage/css/sms.css" />
<div class="page-header">
    <span class="btn btn-green btn-xs btn-sms" data-type="add" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增模版 </span><BR/>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>模版签名</th>
                    <th>短信内容</th>
                    <th class="hidden-480">审核状态</th>
                    <th class="hidden-480">审核结果</th>
                    <th>
                        <i class="icon-time bigger-110 hidden-480"></i>
                        更新时间
                    </th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                <{foreach $list as $val}>
                    <tr>
                        <td><{$val['st_tpl_sign']}></td>
                        <td><{$val['st_tpl_content']}></td>
                        <td><span class="label label-sm label-<{$audit[$val['st_status']]['css']}>"><{$audit[$val['st_status']]['label']}></span></td>
                        <td><{$val['st_reason']}></td>
                        <td><{if $val['st_update_time']}><{date('Y-m-d H:i',$val['st_update_time'])}><{/if}></td>
                        <td>
                            <{if $val['st_status'] == 0}><span class="btn btn-primary btn-xs btn-syn" data-id="<{$val['st_id']}>">同步</span><{/if}>
                            <{if $val['st_status'] == 2}><span class="btn btn-green btn-xs btn-sms" data-type="edit" data-id="<{$val['st_id']}>" data-sign="<{$val['st_tpl_sign']}>">修改</span><{/if}>

                        </td>
                    </tr>
                <{/foreach}>
                </tbody>
            </table>
        </div><!-- /.table-responsive -->
    </div><!-- /span -->
</div><!-- /row -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加/编辑签名</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 ">
                    <div  class="col-md-2"><label>短信签名:</label></div>
                    <div  class="col-md-1 right"><label>【</label></div>
                    <div  class="col-md-4">
                        <input type="text" class="form-control" style="width:150px;" id="sign" placeholder="签名为店铺名称，公司简称，品牌名">
                    </div>
                    <div  class="col-md-1 left"><label>】</label></div>
                    <div  class="col-md-4 right"><label><a id="access-tip"  href="javascript:;">@哪些签名不被允许</a></label></div>
                </div>
                <div class="space-4"></div>
                <div class="col-sm-12" style="margin-top: 10px;">
                    <div  class="col-md-2">&nbsp;</div>
                    <div  class="col-md-10 left"><span class="form-control-static">签名3-8字，建议使用汉字，不能包括网址或者特殊字符。</span></div>
                </div>
            </div>
            <input type="hidden" id="hid_id" value="0">
            <input type="hidden" id="old_sign" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-green btn-xs btn-save"> 保 存 </button>
            </div>
        </div>
    </div>
</div>

<{include file="../bs-alert-tips.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    /*隐藏充值弹出框*/
    $('#access-tip').on('click',function(){
        layer.tips('1.含有特殊字符（如$@^等）的签名。<br/>2.与公司、商标和网站名无关的签名', '#access-tip', {
            tips: [3, '#3595CC'],
            time: 4000
        });
    });
    $('.btn-sms').on('click', function () {
        var type = $(this).data('type');
        var id = 0,sign = '';
        if(type == 'edit'){
            id   =  $(this).data('id');
            sign =  $(this).data('sign');
        }
        $('#hid_id').val(id);
        $('#sign').val(sign);
        $('#old_sign').val(sign);
        $('#myModal').modal('show');
    });
    $('.btn-save').on('click', function () {
        var id   =  $('#hid_id').val();
        var sign =  $('#sign').val();
        var old_sign = $('#old_sign').val();
        if(!old_sign || sign != old_sign){
            var data = {
                'id'   : id,
                'sign' : sign,
                'old'  : old_sign
            };
            $.ajax({
                type  : 'post',
                url   : '/manage/plugin/saveSms',
                data  : data,
                dataType  : 'json',
                success   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }else{
            $('#myModal').modal('hide');
        }
    });
    $('.btn-syn').on('click', function () {
        var id   =  $(this).data('id');
        if(id){
            var data = {
                'id'   : id
            };
            $.ajax({
                type  : 'post',
                url   : '/manage/plugin/synSms',
                data  : data,
                dataType  : 'json',
                success   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });

</script>
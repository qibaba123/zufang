$('.btn-audit').on('click',function(){
    var id = $(this).data('id');
    $('#hid_id').val(id);
    $('#modal-form').modal('show');
});
$('.modal-save').on('click',function(){
    var data = {
        'id'     : $('#hid_id').val(),
        'status' : $('input[name="status"]:checked').val()
    };
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    },{time:10*1000});

    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/branch/status',
        'data'  : data,
        'dataType'  : 'json',
        success : function(json_ret){
            layer.close(index);
            layer.msg(json_ret.em);

            if(json_ret.ec == 200){
                var statusNote = '';
                switch (data.status){
                    case "1" :
                        statusNote = '<span class="label label-sm label-success">审核通过</span>';
                        break;
                    case "2" :
                        statusNote = '<span class="label label-sm label-danger">审核拒绝</span>';
                        break;
                }
                if(statusNote){
                    $('#status_'+data.id).html(statusNote);
                    $('#audit_'+data.id).hide();
                }
                $('#modal-form').modal('hide');
            }
        }

    })
});
$('.btn-del').on('click',function(){
    var data = {
        'id' : $(this).data('id')
    };
    layer.confirm('您确定要删除分店吗？', {
        btn: ['删除','取消'] //按钮
    }, function(){
        $.ajax({
            'type'  : 'post',
            'url'   : '/manage/branch/delete',
            'data'  : data,
            'dataType'  : 'json',
            success : function(json_ret){
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    $('#tr_'+data.id).hide();
                }
            }

        })
    });
});
// 删除关键词红包、口令红包、关注红包、裂变红包
$('.del-btn').on('click',function(){
    var data = {
        'id'   : $(this).data('id'),
        'type' : $(this).data('type'),
        'keyword' : $(this).data('keyword')   // 关键词只针对关键词红包核裂变红包
    };
    if(data.id){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'	: 'post',
            'url'	: '/manage/redpack/delRed',
            'data'	: data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+data.id).remove();
                }
            }
        });
    }else{
        layer.msg('未获取到红包信息');
    }
});
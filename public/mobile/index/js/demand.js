/**
 * Created by zhaoweizhen on 16/2/29.
 */
$('.demand-btn').on('click',function(){
    var name    = $('#demand-name').val();
    var mobile  = $('#demand-mobile').val();
    var content = $('#demand-content').val();
    if(mobile.length != 11){
        alert('请填写有效的手机号');
        return false;
    }
    var data = {
        'name'    : name,
        'mobile'  : mobile,
        'content' : content
    };
    $.ajax({
        'type' : 'post',
        'url'  : '/service/demand',
        'data' : data,
        'dataType' : 'json',
        success : function(json_ret){
            if(json_ret.em){
                alert(json_ret.em);
            }
            if(json_ret.ec == 200){
                $('#demand-name').val('');
                $('#demand-mobile').val('');
                $('#demand-content').val('');
            }
        }
    });
});

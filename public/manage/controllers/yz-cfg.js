function saveYouZan(){
    var app_id      = $('#app_id').val();
    var app_secret  = $('#app_secret').val();
    var data = {
        'app_id'        : app_id,
        'app_secret'    : app_secret
    };
    console.log(data);
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/auth/saveYouZan',
        'data'  : data,
        'dataType' : 'json',
        success : function(response){
            fade_in_out_msg('saveResult',response.em,response.ec);
        }
    });
}

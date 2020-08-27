<!--

搜索并选择会员 可在一个页面中同时存在多个
在html代码的id后跟参数即可

<div class="form-group" style="margin-right: 0;margin-left: 0">
                <div class="form-control multi-choose-box multi-choose-box" >
                    <ul class="multi-choose" id="multi-choose_this">
<li class="input-search"><input type="text" id="m_nickname_this" autocomplete="off" oninput="getMember('this')" placeholder="" ></li>
</ul>
<div class="mem-list" id="mem-list_this">

</div>
</div>
<input type="hidden" class="form-control" id="hid_nickname_this" >
<input type="hidden" class="form-control" id="m_id_this" >

</div>


-->

<link rel="stylesheet" href="/public/manage/css/select-input.css">
<style>
    .mem-list{
        top:100%;
        border-color: #ccc;
    }
    .multi-choose-box{
        padding: 0;
        position: relative;
        min-height: 34px;
        height: auto;
    }
    .multi-choose-box .multi-choose{
        overflow: hidden;
    }
    .multi-choose-box .multi-choose li{
        float: left;
        margin:3px 4px;
        height: 26px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .multi-choose-box .multi-choose .choose-txt{
        border:1px solid #ddd;
        height: 26px;
        padding: 2px 5px;
        border-radius: 3px;
        font-size: 13px;
        line-height: 21px;
        background-image: linear-gradient(#f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eeeeee 100%);
        background-clip: padding-box;
        box-shadow: 0 0 2px white inset, 0 1px 0 rgba(0, 0, 0, 0.05);
    }
    .multi-choose-box .multi-choose .choose-txt span{
        margin-right: 4px;
    }
    .multi-choose-box .multi-choose .choose-txt .delete{
        color: #bbb;
    }
    .multi-choose-box .multi-choose .choose-txt .delete:hover{
        color: #999;
    }
    .multi-choose-box .multi-choose li input{
        width: auto;
        display: inline-block;
        height: 26px;
        padding: 3px 0;
        margin:0 3px;
        border:none;
        min-width: 25px;
        width: 25px;
    }
</style>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $(function(){
        //根据输入框内容改变输入框宽度
        $('.multi-choose li input[type="text"]').on('input', function(){
            $(this).width(textWidth($(this).val())+10);
        });
        //点击搜索区域输入框获得焦点
        $(".multi-choose").click(function(event) {
            //$('.multi-choose li input[type="text"]').focus();
            $(this).find('li').find('input[type="text"]').focus();
        });
        $('body').on('click',function(){
            $(".mem-list").stop().fadeOut();
        });
        $(".mem-list").on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
    })
    /**
     * 绑定会员，后台检索
     */
    function getMember(target){
        console.log(target);
        var nickname = $("#m_nickname_"+target).val();
        console.log(nickname);
        var hid      = $('#hid_nickname_'+target).val();
        if(nickname==""){
            $("#mem-list_"+target).html("").stop().hide();
        }
        if(hid != nickname && nickname){
            var data = {
                'nickname' : nickname
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/member',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    if(ret.ec == 200){
                        var mem = ret.data;
                        selectMemberHtml(ret.data,target);
                        $("#mem-list_"+target).stop().show();
                    }else{
                        // layer.msg(ret.em);
                    }

                }
            });
        }

    }

    /**
     * 绑定会员列表展示
     */
    function selectMemberHtml(data,target){
        var _html = '<ul class="lay-ul">';
        for(var i = 0 ; i < data.length ; i++){
            _html += '<li><a href="javascript:;" onclick="selectedMember('+data[i].id+','+"'"+data[i].nickname+"'"+','+"'"+ target +"'"+')">'+data[i].nickname+'（会员编号：'+data[i].show+'）'+'</a></li>';
        }
        _html += '<ul>';
        $("#mem-list_"+target).html(_html);
    }

    /**
     * 选中会员绑定处理
     * @param id
     * @param nickname
     */

    function selectedMember(id,nickname,target){
        console.log(target);
        $('#m_nickname_'+target).val('');
        var html = '';
        var isHas = true;
        $("#multi-choose_"+target).find(".choose-txt").each(function(index, el) {
            var itemId = $(this).find('.delete').data('id');
            if(itemId == id){
                layer.msg("该会员已选择");
                isHas = false;
            }
        });
        if(isHas){
            html += '<li class="choose-txt">';
            html += '<span>'+nickname+'</span> ';
            html += '<a href="javascript:;" class="delete" onclick="removeChooseItem(this,'+"'"+ target +"'"+')" data-id="'+id+'"><i class="icon-remove"></i></a>';
            html += '</li>';
            $("#multi-choose_"+target).find('li.input-search').before(html);
            $('#hid_nickname_'+target).val(nickname);
            $('#m_id_'+target).val(id);
            $("#mem-list_"+target).stop().fadeOut();
            $("#m_nickname_"+target).css('display','none');
        }
    }
    /**
     * 移除所选
     */
    function removeChooseItem(obj,target){
        $(obj).parents('.choose-txt').remove();
        $("#m_nickname_"+target).css('display','inline-block');
    }
    /**
     * 根据输入框内容改变输入框宽度
     */
    function textWidth(text){
        var sensor = $('<pre>'+ text +'</pre>').css({display: 'none'});
        $('body').append(sensor);
        var width = sensor.width();
        sensor.remove();
        return width;
    };

</script>
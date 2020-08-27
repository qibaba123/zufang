<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:10:56
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/layer/ajax-select-input-single.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1786197635e4df8c0b0b8a5-25039891%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a033406d2ba7e76645b32d6c97059803113f452c' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/layer/ajax-select-input-single.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1786197635e4df8c0b0b8a5-25039891',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df8c0b0dde2_60956752',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df8c0b0dde2_60956752')) {function content_5e4df8c0b0dde2_60956752($_smarty_tpl) {?>
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
<div class="form-group" style="margin-right: 0;margin-left: 0">
    <div class="form-control multi-choose-box" class="multi-choose-box">
        <ul class="multi-choose" id="multi-choose">
            <!-- <li class="choose-txt">
                <span>选择的内容</span>
                <a href="javascript:;" class="delete"><i class="icon-remove"></i></a>
            </li> -->
            <li class="input-search"><input type="text" id="m_nickname" autocomplete="off" oninput="getMember()" placeholder="" ></li>
        </ul>
        <div class="mem-list" id="mem-list">

        </div>
    </div>
    <input type="hidden" class="form-control" id="hid_nickname" >
    <input type="hidden" class="form-control" id="m_id" >
    
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $(function(){
        //根据输入框内容改变输入框宽度
        $('.multi-choose li input[type="text"]').on('input', function(){
            $(this).width(textWidth($(this).val())+10);
        });
        // 点击搜索区域输入框获得焦点
        $(".multi-choose").click(function(event) {
            $('.multi-choose li input[type="text"]').focus();
        });
        $('body').on('click',function(){
            $("#mem-list").stop().fadeOut();
        });
        $("#mem-list").on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
        });
    })
    /**
     * 绑定会员，后台检索
     */
    function getMember(){
        var nickname = $('#m_nickname').val();
        var hid      = $('#hid_nickname').val();
        if(nickname==""){
            $("#mem-list").html("").stop().hide();
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
                        selectMemberHtml(ret.data);
                        $("#mem-list").stop().show();
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
    function selectMemberHtml(data){
        var _html = '<ul class="lay-ul">';
        for(var i = 0 ; i < data.length ; i++){
            _html += '<li><a href="javascript:;" onclick="selectedMember('+data[i].id+','+"'"+data[i].nickname+"'"+')">'+data[i].nickname+'（会员编号：'+data[i].show+'）'+'</a></li>';
        }
        _html += '<ul>';
        $("#mem-list").html(_html);
    }

    /**
     * 选中会员绑定处理
     * @param id
     * @param nickname
     */

    function selectedMember(id,nickname){
        $('#m_nickname').val('');
        var html = '';
        var isHas = true;
        $("#multi-choose").find(".choose-txt").each(function(index, el) {
            var itemId = $(this).find('.delete').data('id');
            if(itemId == id){
                layer.msg("该会员已选择");
                isHas = false;
            }
        });
        if(isHas){
            html += '<li class="choose-txt">';
            html += '<span>'+nickname+'</span> ';
            html += '<a href="javascript:;" class="delete" onclick="removeChooseItem(this)" data-id="'+id+'"><i class="icon-remove"></i></a>';
            html += '</li>';
            $("#multi-choose").find('li.input-search').before(html);
            $('#hid_nickname').val(nickname);
            $('#m_id').val(id);
            $("#mem-list").stop().fadeOut();
            $("#m_nickname").css('display','none');
        }
    }
    /**
     * 移除所选
     */
    function removeChooseItem(obj){
        $(obj).parents('.choose-txt').remove();
        $("#m_nickname").css('display','inline-block');
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

    // 获取选中的所有会员的ID
    function getSelectAll() {
        var ids = new Array();
        $("#multi-choose").find(".choose-txt").each(function(index, el) {
            var itemId = $(this).find('.delete').data('id');
            ids[index] = itemId;
        });
        return ids;
    }

</script><?php }} ?>

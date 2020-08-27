<?php /* Smarty version Smarty-3.1.17, created on 2020-05-09 14:42:40
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/comment-goods.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19442785595eb650e035d207-26136982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7096adec392498df7c63ac05afed2f5b78c1ca83' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/comment-goods.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19442785595eb650e035d207-26136982',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'memberList' => 0,
    'val' => 0,
    'spec' => 0,
    'key' => 0,
    'value' => 0,
    'jumpUrl' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5eb650e03a7a14_98270375',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5eb650e03a7a14_98270375')) {function content_5eb650e03a7a14_98270375($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style>
    .container{
        width: 60%;
    }
    .group-info .control-group .form-control {
        max-width: 100%;
    }
    .layui-layer .container{
        width: 100%;
    }

    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .search-input{
        width: 90% !important;
        margin-bottom: 5px !important;
        display: block !important;
    }
    .small-input{
        display: inline-block !important;
        width: 50% !important;
       margin-right: 10px;
    }
    label{
       font-weight: bold;
    }
    .control-group{
        margin-top: 5px;
    }

</style>
<?php if ($_smarty_tpl->tpl_vars['row']->value['g_id']) {?>
<div class="container">

    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_id']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_id'];?>
<?php }?>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="">商品名称</label>
            <div class="control-group">
                <span style="color: #428bca"><?php echo $_smarty_tpl->tpl_vars['row']->value['g_name'];?>
</span>
            </div>
        </div>
        <div class="form-group">
            <label for="">选择会员<font color="red">*</font><span style="color: red;padding-left: 10px">需要先到会员管理的会员列表点击新增添加会员</span></label>
            <div class="control-group">
                <select name="member" id="member" style="" class="form-control small-input" placeholder="请选择会员">
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['memberList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['spec']->value) {?>
        <div class="form-group">
            <label for="">商品规格<font color="red">*</font></label>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['spec']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
            <div class="control-group">
                <?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
：
                <input type="hidden" id="format_key_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="format-key" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
">
                <select name="format_value_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" id="format_value_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" style="" class="form-control small-input format-value">
                    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</option>
                    <?php } ?>
                </select>
            </div>
            <?php } ?>
        </div>
        <?php }?>
        <div class="form-group">
            <label for="">分数<font color="red">*</font><span style="color: red;padding-left: 10px">请填写1-5的整数</span></label>
            <div class="control-group">
                <input type="number" id="score" placeholder="请填写分数" class="form-control small-input" />
            </div>
        </div>
        <div class="form-group">
            <label for="">评价时间 <span style="color: red;padding-left: 10px">若不填则为保存时的时间</span></label>
            <div class="control-group" >
               <input id="time" name="time" autocomplete="off" type="text" placeholder="请选择本次评价的时间" class="form-control small-input" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
            </div>
        </div>
        <div class="form-group" style="margin-top: 10px">
            <label for="">评价内容<font color="red">*</font></label>
            <div class="control-group">
                <textarea name="content" id="content" cols="30" rows="3" class="form-control" placeholder="请填写评价内容"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="">图片<span style="color: red;padding-left: 10px">最多3张，尺寸 640 x 640 像素</span></label>
            <div class="control-group" style="margin-top: 15px">
                <div id="slide-img" class="pic-box" style="display:inline-block">

                </div>
                <span onclick="toUpload(this)" data-limit="3" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
                <input type="hidden" id="slide-img-num" name="slide-img-num" value="0" placeholder="控制图片张数">
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning setting-save" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm btn-save">保存</button>
</div>
<?php } else { ?>
    <div class="container">
        <div class="group-info">
            <div class="form-group">
                <label for="">商品名称</label>
                <div class="control-group">
                    <span style="color: #428bca">未找到商品</span>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript">


    $('.btn-save').click(function(){
        var id = $('#hid_id').val();
        var score = $('#score').val();
        var content = $('#content').val();
        var time = $('#time').val();
        var member = $('#member').val();


        var check   = new Array('member','score','content');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp){
                var msg = $('#'+check[i]).attr('placeholder');
                console.log(check[i]);
                layer.msg(msg);
                return false;
            }
        }

        var imgArr = [];
        var index = 0;
        var path = '';
        $('.img-p').each(function () {
            // var info = {
            //   id : $(this).find('.img-id').val(),
            //   path :   $(this).find('.img-path').val(),
            //   index : index
            // };
            path = $(this).find('.img-path').val();
            imgArr.push(path);
            index++;
        });

        var formatArr = [];
        var key = 0;
        var keyName = '';
        var valueName = '';
        var str = '';
        $('.format-key').each(function () {
            keyName = $(this).val();
            valueName = $('#format_value_'+key).val();
            str = keyName+":"+valueName;
            formatArr.push(str);
            key++;
        });


        var data = {
                id : id,
                score : score,
                content : content,
                time : time,
                member : member,
                imgArr : imgArr,
                formatArr : formatArr
            };
        console.log(data);

        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/saveComment',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='<?php echo $_smarty_tpl->tpl_vars['jumpUrl']->value;?>
';
                }
            }
        });

    });



    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                var imgId = nowId.split('-');
                $('#'+nowId).attr('src',allSrc[0]);
                $('#'+nowId).val(allSrc[0]);
                $('#'+imgId[1]).val(allSrc[0]);
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p class="img-p">';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'" class="img-path">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0" class="img-id">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).append(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    /*初始化日期选择器*/
    // $('.time').click(function(){
    //     WdatePicker({
    //         dateFmt:'HH:mm',
    //         minDate:'00:00:00'
    //     })
    // })
</script>

<?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>

<?php }} ?>

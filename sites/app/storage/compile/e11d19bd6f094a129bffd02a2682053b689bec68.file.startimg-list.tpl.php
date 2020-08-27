<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:21:47
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/startimg-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6919888895e4dfb4b1a1c36-54539848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e11d19bd6f094a129bffd02a2682053b689bec68' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/startimg-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6919888895e4dfb4b1a1c36-54539848',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4dfb4b1dc1e1_36155861',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4dfb4b1dc1e1_36155861')) {function content_5e4dfb4b1dc1e1_36155861($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加图片</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <thead>
                        <tr>
                            <th>图片</th>
                            <th>显示时间</th>
                            <th>展示启用</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_id'];?>
">
                                <td>
                                    <img src="<?php if ($_smarty_tpl->tpl_vars['val']->value['asi_path']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['asi_path'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_750_1334.png<?php }?>" style="width:80px" alt="">
                                </td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['asi_time'];?>
秒
                                </td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['asi_show']) {?>
                                    <span style="color: green">已启用</span>
                                    <a href="#" class="btn btn-sm btn-red" onclick="changeShow(<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_id'];?>
,0)" style="padding: 3px 5px">关闭</a>
                                    <?php } else { ?>
                                    <span style="color: red">未启用</span>
                                    <a href="#" class="btn btn-sm btn-green" onclick="changeShow(<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_id'];?>
,1)" style="padding: 3px 5px">启用</a>
                                    <?php }?>
                                </td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['asi_update_time']);?>
</td>
                                <td>
                                    <a class="confirm-handle btn btn-xs btn-green" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_id'];?>
" data-cover="<?php if ($_smarty_tpl->tpl_vars['val']->value['asi_path']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['asi_path'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_750_1334.png<?php }?>" data-indexshow="<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_show'];?>
" data-time="<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_time'];?>
" >编辑</a>
                                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['asi_id'];?>
" onclick="confirmDelete(this)" class="btn btn-xs btn-danger del-btn">删除</a>
                                </td>
                            </tr>
                            <?php } ?>

                        <tr><td colspan="9"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>

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
                    添加/编辑
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">图片：(建议尺寸750*1344)</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="1334" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_750_1334.png"  width="250" height="445" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="category-cover"  class="avatar-field bg-img" name="category-cover"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">是否展示：</label>
                    <div class="col-sm-6">
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="indexShow" id="index_yes" value="1" >
                                        <label for="index_yes">是</label>
                                    </span>
                            <span>
                                        <input type="radio" name="indexShow" id="index_no" value="0" >
                                        <label for="index_no">否</label>
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">显示时间：</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="show-time" maxlength="2">
                        <span style="color: red">请填写1-10之间的整数</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-cover').val($(this).data('cover'));
        $('#upload-cover').attr('src',$(this).data('cover'));
        $('#show-time').val($(this).data('time'));
        $("input[name='indexShow']").removeProp('checked');
        var indexShow = $(this).data('indexshow');

        if(indexShow == 1){
            $('#index_yes').prop('checked',true);
        }else{
            $('#index_no').prop('checked',true);
        }
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#category-cover').val('');
        $('#show-time').val('');
        $('#upload-cover').attr('src','/public/manage/img/zhanwei/zw_fxb_750_1334.png');
        $("input[name='indexShow']").removeProp('checked');
        $('#index_yes').prop('checked',true);
    });

    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var cover  = $('#category-cover').val();
        var time  = $('#show-time').val();
        var indexShow = $("input[name='indexShow']:checked").val();
        var data = {
            id     : id,
            cover  : cover,
            time   : time,
            indexShow : indexShow
        };
        console.log(data);
        if(cover){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/popup/startImgSave',
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
        }else{
            layer.msg('请上传图片');
            return false;
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
                    'url'   : '/wxapp/popup/startImgDelete',
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

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#category-cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    function changeShow(id,status) {
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/popup/startImgChangShow',
                'data'  : { id:id,status:status},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);

                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    }
</script><?php }} ?>

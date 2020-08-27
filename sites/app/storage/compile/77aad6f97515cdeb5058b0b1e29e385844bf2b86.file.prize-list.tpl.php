<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:03:24
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/meeting/prize-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19496934475e4df6fca93605-36896302%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '77aad6f97515cdeb5058b0b1e29e385844bf2b86' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/meeting/prize-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19496934475e4df6fca93605-36896302',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'list' => 0,
    'val' => 0,
    'typeArr' => 0,
    'paginator' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df6fcad27e5_58003598',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df6fcad27e5_58003598')) {function content_5e4df6fcad27e5_58003598($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header" style=""><!--href="/wxapp/meeting/addPrize"-->
        <a class="btn btn-green btn-xs"   href="javascript:;" onclick="addPrize(this)" ><i class="icon-plus bigger-80"></i>添加奖品</a>
    </div>
        <!--
    <div class="page-header search-box" style="">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/meeting/prizeList" method="get">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">用户昵称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"  placeholder="用户昵称">
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
    -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>奖品名称</th>
                            <th>奖品封面</th>
                            <th>添加时间</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_name'];?>
</td>
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_cover'];?>
" style="width: 60px;height: 60px;margin:0;"></td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['ampl_create_time']);?>
</td>
                                <td>
                                   <?php echo $_smarty_tpl->tpl_vars['typeArr']->value[$_smarty_tpl->tpl_vars['val']->value['ampl_type']];?>

                                </td>
                                <td style="color:#ccc;">
                                    <!--<a href="/wxapp/meeting/addPrize?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_id'];?>
" >编辑</a>--->
                                    <a href="javascript:;" onclick="addPrize(this)" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_id'];?>
"
                                     data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_name'];?>
" data-cover="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_cover'];?>
"
                                       data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_type'];?>
"  data-pnum="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_pnum'];?>
"  style="">编辑</a> -
                                    <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['ampl_id'];?>
" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<!--新增编辑或者弹出增加奖品弹框-->
<div id="add-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="font-size: 18px">添加/编辑奖品</h3>
            </div>
            <div class="modal-body" style="margin: 5px 15px">
                <form id="add-form">
                    <input type="hidden" class="form-control" id="hid_id" value="0">
                    <div class="form-group">
                        <label for="name">奖品名称</label>
                        <input type="text" class="form-control" id="name" placeholder="奖品名称">
                    </div>
                    <div class="form-group">
                        <label for="type">奖品类型</label>
                        <div class="control-group">
                            <select id="type" name="type" onchange="showNum(this)" class="form-control">
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['typeArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="points" style="display:none;">
                        <label for="pnum">奖励数量</label>
                        <input type="text" class="form-control" id="pnum" name="pnum" placeholder="请填写奖励数量"  value="">
                   </div>
                    <div class="form-group">
                        <label>奖品图片</label>
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_75_36.png"  width="200px" style="display:inline-block;margin:0;">
                            <input type="hidden" id="cover"  class="avatar-field bg-img" name="upload-cover" value=""/>
                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover">修改图片<small style="font-size: 12px;color:#999">（建议尺寸：200*200）</small></a>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-save-add" >保存修改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">活动名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写活动名称" style="height:auto!important"/>
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

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<!--编辑或者新增奖品弹框结束-->
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script>

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#cover').val(allSrc[0]);
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
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/meeting/delPrize',
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
    function showNum(obj){
        var type = $(obj).val();
        if(type ==2 || type ==3 || type ==4 || type ==5){
            $('#points').show();
        }else{
            $('#points').hide();
        }

    }
    //添加或者编辑奖品弹框
    function addPrize(obj){

        var id = $(obj).data('id');
        if(id){
            var name = $(obj).data('name');
            var type = $(obj).data('type');
            var cover = $(obj).data('cover');
            var pnum  = $(obj).data('pnum');
            if(type == 1 || type ==0){
                $('#points').stop().hide();
            }else{
                $('#points').stop().show();
            }
            $('#hid_id').val(id);
            $('#name').val(name);
            $('#type').val(type);
            $('#pnum').val(pnum);
            $('#cover').val(cover);
            $('#upload-cover').attr('src',cover);
        }

        $('#add-modal').modal('show');
    }


    //奖品增或编辑
    $('.btn-save-add').on('click',function(){
        var filed = new Array('type','name','cover');
        for(var i= 0;i<filed.length;i++){
            if(!$("#"+filed[i]).val()){
                layer.msg('请完善您的数据');
                return;
            }
        }
        var data = {
            'id'   : $('#hid_id').val(),
            'name' : $('#name').val(),
            'cover': $('#cover').val(),
            'pnum' : $('#pnum').val(),
            'type': $('#type').val(),

        };

        if(data.name){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/meeting/savePrize',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#add-modal').modal('hide');
                        window.location.reload();
                       /* if(data.id > 0){
                            $('#name_'+data.id).html(data.name);
                        }else{
                            window.location.reload();
                        }*/
                    }
                }
            });
        }else{
            layer.msg('奖品名称不能为空');
        }
    });
</script><?php }} ?>

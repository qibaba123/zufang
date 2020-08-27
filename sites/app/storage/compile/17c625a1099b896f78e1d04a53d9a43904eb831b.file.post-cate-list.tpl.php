<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:48:05
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/post-cate-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2327948035dea15c57a4d01-34579893%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17c625a1099b896f78e1d04a53d9a43904eb831b' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/post-cate-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2327948035dea15c57a4d01-34579893',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'list' => 0,
    'val' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea15c57fd841_61180063',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea15c57fd841_61180063')) {function content_5dea15c57fd841_61180063($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <!--
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加团长</a>
            -->
            <a class="btn btn-green btn-xs add-category" href="#" data-toggle="modal" data-target="#myModal" ><i class="icon-plus bigger-80"></i>添加分类</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box" >
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/community/postCateList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">名称</div>
                                    <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"  placeholder="名称">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <!--
                            <th class="center" style="display: none">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            -->
                            <th>名称</th>
                            <th>排序</th>
                            <th>最近更新</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['asa_id'];?>
">
                                <!--
                                <td class="center" style="display: none">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['asa_id'];?>
"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_name'];?>

                                </td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_sort'];?>

                                </td>
                                <td>
                                    <?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['acpc_update_time']);?>

                                </td>
                                <td class="jg-line-color">
                                    <a href="#" class="edit-category" data-toggle="modal" data-target="#myModal" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_name'];?>
" data-sort="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_sort'];?>
">编辑</a>
                                     - <a href="#" onclick="confirmDelete(this)" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['acpc_id'];?>
" style="color:#f00;">删除</a>
                                </td>
                            </tr>

                            <?php } ?>

                        <tr>
                            <!--
                            <td colspan="2">
                                <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下线</span>
                                <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上线</span>
                            </td>
                            -->
                            <td colspan="8"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
                    添加分类
                </h4>
            </div>
            <div class="modal-body">
                <!--
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类图片：(建议尺寸228*201)</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="228" data-height="201" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_200_200.png"  width="228px" height="201px" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="category-cover"  class="avatar-field bg-img" name="category-cover"/>
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类排序：</label>
                    <div class="col-sm-8">
                        <input id="category-sort" class="form-control" placeholder="数字越大，排序越靠前" style="height:auto!important"/>
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
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script>
    $('.add-category').on('click',function () {
        $('#category-name').val('');
        $('#category-sort').val('');
        $('#hid_id').val('');
    });

    $('.edit-category').on('click',function () {
        var name = $(this).data('name');
        var id = $(this).data('id');
        var sort = $(this).data('sort');

        $('#category-name').val(name);
        $('#category-sort').val(sort);
        $('#hid_id').val(id);
    });

    $('#confirm-category').on('click',function () {
        var id = $('#hid_id').val();
        var name = $('#category-name').val();
        var sort = $('#category-sort').val();

        if(!name){
            layer.msg('请填写分类名称');
            return;
        }

        var loading = layer.load(2);

        var data = {
            id : id,
            name : name,
            sort : sort
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/postCateSave',
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
    });

    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/community/postCateDelete',
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
</script><?php }} ?>

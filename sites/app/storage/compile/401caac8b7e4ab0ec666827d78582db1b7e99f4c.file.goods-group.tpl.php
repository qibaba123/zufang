<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:09:55
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/goods/goods-group.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13477329795dea1ae34d6942-84773462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '401caac8b7e4ab0ec666827d78582db1b7e99f4c' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/goods/goods-group.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13477329795dea1ae34d6942-84773462',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'key' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1ae3527742_60241389',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1ae3527742_60241389')) {function content_5dea1ae3527742_60241389($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/groupControl/css/style.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
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


</style>
<div>
    <div class="page-header">
        <a href="javascript:;" data-mk="add" data-id="0" data-name="" class="btn btn-green btn-xs btn-group"><i class="icon-plus bigger-80"></i> 新增</a>
        <!--
        <div class="col-sm-1 pull-right search-btn">
            <a href="/wxapp/goods/groupControl" class="btn btn-green btn-xs" style="margin-top:6px;">商品分类</a>
        </div>
        -->
    </div>
    <div class="ui-popover ui-popover-link left-center" style="top:100px;">
        <div class="ui-popover-inner">
            <div class="input-group copy-div">
                <input type="text" class="form-control" id="copy" value="" readonly style="height:34px;">
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" id="content-con">
                <table id="sample-table-1" class="table table-hover table-button">
                    <thead>
                    <tr>
                        <th class="hidden-480">分组名称</th>
                        <th class="hidden-480">商关联品</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            创建时间
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
" <?php if (($_smarty_tpl->tpl_vars['key']->value%2==1)) {?>class="info"<?php } else { ?><?php }?>>
                            <td id="name_<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['gg_name'];?>
</td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['val']->value['gg_total'];?>

                                <div class="pull-right" style="font-size:0">
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['gg_total']>0) {?>
                                    <a class="btn btn-xs btn-success btn-goods" href="javascript:;" data-mk="look" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
">查看</a>
                                    <?php }?>
                                    <a class="btn btn-xs btn-info btn-goods" href="javascript:;" data-mk="add"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
">增加关联</a>
                                </div>
                            </td>
                            <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['gg_create_time']);?>
</td>
                            <td style="color:#ccc;">
                                <a class="btn-group" href="javascript:;" data-mk="edit" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_name'];?>
" data-style="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_list_type'];?>
" data-img="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_bg'];?>
" data-brief="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_brief'];?>
">编辑</a>
                                 - <a class="btn-group" href="javascript:;" data-mk="del" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
" style="color:#f00;">删除</a>
                                <!--<a href="javascript:;" id="link_<?php echo $_smarty_tpl->tpl_vars['val']->value['gg_id'];?>
" class="btn-link" data-link="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
">链接</a>-->

                            </td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="4"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="add-modal"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" style="font-size: 18px">商品分组</h3>
                </div>
                <div class="modal-body" style="margin: 5px 15px">
                    <form id="add-form">
                        <input type="hidden" class="form-control" id="hid_id" value="0">
                        <div class="form-group">
                            <label for="group_name">分组名称</label>
                            <input type="text" class="form-control" id="group_name" placeholder="分组名称">
                        </div>
                        <div class="form-group">
                            <label>分组背景图</label>
                            <!--
                            <div class="cropper-box" data-width="725" data-height="340">
                                <img src="/public/manage/img/zhanwei/zw_fxb_75_36.png" id="background_img" width="180" style="display:inline-block;margin:0"><a href="javascript:void(0)" style="display: inline;color:blue;font-size:14px;vertical-align: bottom;position: relative;left:5px;">修改图片<small style="font-size: 12px;color:#999">（建议尺寸：725*340）</small></a>
                                <input type="hidden" id="background_image" class="avatar-field source-img" ng-model="cover" name="background_image" value=""/>
                            </div>
                            -->
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="725" data-height="340" data-dom-id="background_img" id="background_img"  src="/public/manage/img/zhanwei/zw_fxb_75_36.png"  width="180" style="display:inline-block;margin:0;">
                                <input type="hidden" id="background_img"  class="avatar-field bg-img" name="background_image" value=""/>
                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="725" data-height="340" data-dom-id="background_img">修改图片<small style="font-size: 12px;color:#999">（建议尺寸：725*340）</small></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="group_name">分组简介</label>
                            <input type="text" class="form-control" id="group_brief" placeholder="分组简介">
                        </div>
                        <div class="form-group">
                            <label>商品样式</label>
                            <div class="radio-box showstyle-radio" style="padding: 5px 0">
                                <span class="change-style">
                                    <input type="radio" name="goods-show" value="1" id="showstyle1" checked>
                                    <label for="showstyle1">
                                        <img src="/public/manage/img/good_style1.png" width="40" alt="大图">
                                        <!-- <span>大图</span> -->
                                    </label>
                                </span>
                                <span class="change-style">
                                    <input type="radio" name="goods-show" value="2" id="showstyle2" >
                                    <label for="showstyle2">
                                        <img src="/public/manage/img/good_style2.png" width="40" alt="小图">
                                        <!-- <span>小图</span> -->
                                    </label>
                                </span>
                                <span class="change-style">
                                    <input type="radio" name="goods-show" value="3" id="showstyle3" >
                                    <label for="showstyle3">
                                        <img src="/public/manage/img/good_style3.png" width="40" alt="一大两小">
                                        <!-- <span>一大两小</span> -->
                                    </label>
                                </span>
                                <span class="change-style">
                                    <input type="radio" name="goods-show" value="4" id="showstyle4" >
                                    <label for="showstyle4">
                                        <img src="/public/manage/img/good_style4.png" width="40" alt="详细列表">
                                        <!-- <span>详细列表</span> -->
                                    </label>
                                </span>
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
    <!--关联商品modal-->
    <div id="goods-modal"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">关联商品</h4>
                </div>
                <div class="modal-body">
                    <div class="good-search">
                        <div class="input-group">
                            <input type="text" id="keyword" class="form-control" placeholder="搜索商品">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                        </div>
                    </div>
                    <hr>
                    <table  class="table-responsive">
                        <input type="hidden" id="mkType" value="">
                        <input type="hidden" id="currId" value="">
                        <thead>
                        <tr>
                            <th>商品图片</th>
                            <th style="text-align:left">商品名称</th>
                            <th class="th-weight">排序权重</th>
                            <th>操作</th>
                        </thead>

                        <tbody id="goods-tr">
                            <!--商品列表展示-->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer ajax-pages" id="footer-page">
                    <!--存放分页数据-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>

<script type="text/javascript">
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        // console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
        optshide();
    } );

    var currPage=1;
    //编辑或者删除处理
    $('.btn-group').on('click',function(){
        var mk      = $(this).data('mk');
        var id      = $(this).data('id');
        var name    = $(this).data('name');
        var style   = $(this).data('style');
        var img     = $(this).data('img');
        var brief   = $(this).data('brief');
        switch (mk){
            case 'add' :
            case 'edit':
                $('#hid_id').val(id);
                $('#group_name').val(name);
                $('#group_brief').val(brief);
                $('#background_img').val(img);
                if(img && img!=''){
                    $('#background_img').attr('src',img);
                }
                $('#add-modal').modal('show');
                $("input[name='goods-show'][value="+style+"]").attr("checked",true);
                break;
            case 'del' :
                var data = {
                    'type' : 'goodsGroup' ,
                    'id'   : id
                };
                //commonDeleteById(data);
                commonDeleteByIdWxapp(data);
                break;
        }

    });

    //分组新增或编辑
    $('.btn-save-add').on('click',function(){
        var data = {
            'id'   : $('#hid_id').val(),
            'name' : $('#group_name').val(),
            'style': $('input[name="goods-show"]:checked').val(),
            'brief'  : $('#group_brief').val(),
            'img'    : $('#background_img').val()
        };

        if(data.name){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveGroup',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#add-modal').modal('hide');
                        if(data.id > 0){
                            $('#name_'+data.id).html(data.name);
                        }else{
                            window.location.reload();
                        }
                    }
                }
            });
        }else{
            layer.msg('分组名称不能为空');
        }
    });
    //管理商品
    $('.btn-goods').on('click',function(){
        //初始化
        $('#goods-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');
        if(type == 'look'){
            $('.th-weight').show();
        }else{
            $('.th-weight').hide();
        }
        $('#goods-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchPageData(currPage);
    });

    function fetchPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            'id'    :  $('#currId').val()  ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/groupGoods',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data){
        var mk = $('#mkType').val();
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].g_id+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p></td>';
            if(mk == 'look'){
                html += '<td><input type="number" data-id="'+data[i].gm_id+'" data-old="'+data[i].gm_weight+'" value="'+data[i].gm_weight+'" onblur="changeWeight(this)" size="2" style="width:50px;" class="form-control" ></td>';
                html += '<td><a href="javascript:;" class="btn btn-xs btn-danger" data-type="del" data-id="'+data[i].g_id+'" onclick="dealGoods( this )"> 移除 </a></td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].g_id+'" onclick="dealGoods( this )"> 选取 </td>';
            }
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }
    /**
     * 移除商品
     */
    function dealGoods(ele){
        var id      = $(ele).data('id');
        var type    = $(ele).data('type');
        var gg      = $('#currId').val() ;
        if(id && type){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var data = {
                'id'    : id,
                'type'  : type,
                'gg'    : gg
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveGoodsGroup',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#goods_tr_'+id).remove();
                    }
                }
            });
        }
    }
    /**
     * 修改商品排序权重
     */
    function changeWeight(obj){
        var old = $(obj).data('old');
        var data = {
            'id'    : $(obj).data('id'),
            'val'   : $(obj).val()
        };

        if(data.id && data.val != old){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/changeWeight',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        fetchPageData(currPage);
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }

    }

    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            // console.log(link);
            $('.copy-div input').val(link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-204;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-490,'top':top-conTop-152}).stop().show();
        // initCopy();
    });
    /*$(".ui-popover.ui-popover-link").on('click', function(event) {
     event.preventDefault();
     event.stopPropagation();
     });*/
    $("body").on('click', function(event) {
        optshide();
    });
    /*隐藏复制链接弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

</script>


<?php }} ?>

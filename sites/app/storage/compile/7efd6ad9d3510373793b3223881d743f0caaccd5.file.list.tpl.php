<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:48:15
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/full/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3169208085dea15cf2040a5-39158769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7efd6ad9d3510373793b3223881d743f0caaccd5' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/full/list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3169208085dea15cf2040a5-39158769',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'list' => 0,
    'val' => 0,
    'type' => 0,
    'use_type' => 0,
    'pageHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea15cf261560_76041669',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea15cf261560_76041669')) {function content_5dea15cf261560_76041669($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td p{
        margin:0;
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
    .center{
        text-align: center;
    }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 33.33%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
</style>
<!--
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

-->
<div id="content-con">
    <div  id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">
        <!-- 汇总信息 -->
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">已满减订单<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已减免金额<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['money'];?>
</span>
                    <span class="unit">元</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已包邮订单<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['postTotal'];?>
</span>
                </div>
            </div>
        </div>
        <div class="page-header">
            <a href="/wxapp/full/add" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="fixed-table-box" style="margin-bottom: 30px;">
                    <div class="fixed-table-header">
                        <table class="table table-hover table-avatar">
                            <thead>
                                <tr>
                                    <!--
                                    <th class="center">
                                        <label>
                                            <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    -->
                                    <th>活动名称</th>
                                    <th>活动方式</th>
                                    <th>参与形式</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        状态
                                    </th>
                                    <th>开始时间</th>
                                    <th>结束时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="fixed-table-body" style="overflow: hidden;max-height: none">
                        <table id="sample-table-1" class="table table-hover table-avatar">
                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['fa_id'];?>
">
                                    <!--
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['fa_id'];?>
"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    -->
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['fa_name'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['val']->value['fa_type']]['title'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['use_type']->value[$_smarty_tpl->tpl_vars['val']->value['fa_use_type']];?>
</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['fa_start_time']>time()) {?>
                                        <span class="label label-sm label-danger">尚未开始</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['fa_start_time']<=time()&&$_smarty_tpl->tpl_vars['val']->value['fa_end_time']>time()) {?>
                                        <span class="label label-sm label-success">进行中</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['fa_end_time']<=time()) {?>
                                        <span class="label label-sm label-green">活动结束</span>
                                        <?php }?></td>

                                    <td>
                                        <p>
                                            开始时间：<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['fa_start_time']);?>

                                        </p>
                                        <p>
                                            结束时间：<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['fa_end_time']);?>

                                        </p>

                                    </td>
                                    <!--
                                    <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['fa_end_time']);?>
</td>
                                    -->
                                    <td style="color:#ccc;">
                                        <a href="/wxapp/full/add/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['fa_id'];?>
" >编辑</a> -

                                        <a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['fa_id'];?>
" class="btn-del" style="color:#f00;" >删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php if ($_smarty_tpl->tpl_vars['pageHtml']->value) {?>
                                <tr><td colspan="13"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</td></tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div><!-- /span -->
        </div><!-- /row -->
        <div id="goods-modal"  class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">赠送商品</h4>
                    </div>
                    <div class="modal-body">
                        <table  class="table-responsive" style="width:100%;">
                            <thead>
                            <tr>
                                <th>商品名称</th>
                                <th class="center">数量</th>
                            </thead>

                            <tbody id="goods-tr">
                            <!--商品列表展示-->
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>
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
    
    $(function(){
        $('.btn-goods').on('click',function(){
            var goods = $(this).data('goods');
            var html = '';
            for(i in goods){
                if(goods[i].gname){
                    html += '<tr>';
                    html += '<td style="text-align:left"><p class="g-name">'+goods[i].gname+'</p></td>';
                    html += '<td style="text-align:center"><p class="g-num">'+goods[i].num+'</p></td>';
                    html += '</tr>';
                }
            }
            if(html){
                $('#goods-tr').html(html);
                $('#goods-modal').modal('show');
            }else{
                layer.msg('尚未添加赠送商品');
            }
        });
        $('.btn-del').on('click',function(){
	            var data = {
	                'id' : $(this).data('id')
	            };
	            layer.confirm('确定要删除吗？', {
		            btn: ['确定','取消'] //按钮
		        }, function(){
		            if(data.id > 0){
		                $.ajax({
		                    'type'  : 'post',
		                    'url'   : '/wxapp/full/delFull',
		                    'data'  : data,
		                    'dataType' : 'json',
		                    success : function(ret){
		                        layer.msg(ret.em);
		                        if(ret.ec == 200){
		                            $('#tr_'+data.id).hide();
		                        }
		                    }
		                });
		            }
	        	});
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
    });
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }
    
</script>
<?php }} ?>

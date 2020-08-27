<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 11:22:09
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/all-common-goods-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2392396445e86abe194d5a4-72584925%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46d8b89de6a821f568a63c7710584b4ca5250a39' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/all-common-goods-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2392396445e86abe194d5a4-72584925',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
    'noGoods' => 0,
    'now' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86abe198ff41_05932836',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86abe198ff41_05932836')) {function content_5e86abe198ff41_05932836($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }

</style>
<div  id="content-con" >
    <!--<a href="javascript:" class="btn btn-green btn-xs btn-import"><i class="icon-plus bigger-80"></i>批量导入</a>-->
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/goods/allCommonGoods" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="商品名称">
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
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th>商品 价格</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">
                                <td class="proimg-name" style="min-width: 270px;">
                                    <?php if (isset($_smarty_tpl->tpl_vars['val']->value['g_cover'])) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_cover'];?>
" width="75px" height="75px" alt="封面图">
                                    <?php }?>
                                    <div>
                                        <p class="pro-name">
                                            <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['g_name'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>

                                            <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
<?php }?>
                                        </p>
                                        <p class="pro-price"><?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
</p>
                                    </div>

                                </td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['g_update_time']);?>
</td>
                                <td>
                                    <a href="/wxapp/goods/allCommonGoodsDetail/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">导入商品</a>
                                    <!--<a href="javascript:" class="btn-import" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">导入商品</a>-->
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                </td><td colspan="3" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }

            show_modal_content('threeSale',gid);
            $('#modal-info-form').modal('show');
        }else{
            layer.msg('未获取到商品信息');
        }
    });
    $(function(){
        let name = '<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
';
        let noGoods = '<?php echo $_smarty_tpl->tpl_vars['noGoods']->value;?>
';
        if(name && noGoods==1){
            layer.msg("无关键词商品");
        }
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<?php echo $_smarty_tpl->tpl_vars['now']->value;?>
';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
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

    $('.btn-import').on('click',function(){
        var id = $(this).data('id');
        var ids = '';
        if(id){
            ids = id;
        }else{
            ids  = get_select_all_ids_by_name('ids');
        }
        if(ids){
            var data = {
                'ids' : ids
            };
            var url = '/wxapp/goods/allCommon2Shop';
            plumAjax(url,data,false);
        }else{
            layer.msg("请选择要导入的商品");
        }
    });
</script><?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:05:51
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/auction/auction-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9040014195e4e680ff02392-01185841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a9da795acd99b4db98a340ab4f9fd3bdffb7abe4' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/auction/auction-list.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9040014195e4e680ff02392-01185841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'name' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6810023a19_14064575',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6810023a19_14064575')) {function content_5e4e6810023a19_14064575($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
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
        width: calc(100% / 5);
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
    .auction-admend {
        display: inline-block!important;
        width: 13px;
        height: 13px;
        cursor: pointer;
        margin-left: 3px;
    }

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <!--#4c8fbd;-->
<div  id="content-con" style="margin-left: 120px">
    <a href="/wxapp/auction/editAuction" class="btn btn-green btn-xs" style="margin-bottom: 10px;"><i class="icon-plus bigger-80"></i> 新增</a>

    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">全部活动<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">进行中<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_jxz'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已结束<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_yjs'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计参与人数<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_ljcyrs'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计参与次数<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_ljcycs'];?>
</span>
            </div>
        </div>

    </div>

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/auction/auctionList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">活动名称</div>
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
            <div class="row">
                <div class="col-xs-12">
                    <div class="fixed-table-box" style="margin-bottom: 30px;">
                        <div class="fixed-table-header">
                            <table class="table table-hover table-avatar">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            <label>
                                                <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>商品图片</th>
                                        <th>商品名称</th>
                                        <th>起拍价</th>
                                        <th>当前价</th>
                                        <th>加价幅度</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>是否展示</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="fixed-table-body">
                            <table id="sample-table-1" class="table table-hover table-avatar">
                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
">
                                        <td class="center">
                                            <label>
                                                <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
"/>
                                                <span class="lbl"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <?php if (isset($_smarty_tpl->tpl_vars['val']->value['aal_cover'])) {?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_cover'];?>
" width="75px" height="75px" alt="封面图">
                                            <?php }?>
                                        </td>
                                        <td>
                                            <a href="/wxapp/auction/editAuction/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
" >
                                            <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['aal_title'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['aal_title'],0,20);?>

                                            <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['aal_title'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['aal_title'];?>
<?php }?>
                                            </a>
                                        </td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aal_start_price'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aal_curr_price'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aal_add_limit'];?>
</td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_start_time']) {?>
                                            <?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['aal_start_time']);?>

                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_end_time']) {?>
                                            <?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['aal_end_time']);?>

                                            <?php }?>
                                        </td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_is_show']) {?><span>展示</span><?php } else { ?><span>不展示</span><?php }?>
                                            <img src="/public/wxapp/images/icon_edit.png" class="auction-admend set-auction" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
" data-show="<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_is_show'];?>
" />
                                        </td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_end_time']) {?>
                                                <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_start_time']>time()) {?>
                                                    <span style="color: red">未开始</span>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_start_time']<time()&&$_smarty_tpl->tpl_vars['val']->value['aal_end_time']>time()) {?>
                                                    <span style="color: red">进行中</span>
                                                <?php }?>
                                                <?php if ($_smarty_tpl->tpl_vars['val']->value['aal_end_time']<time()) {?>
                                                <span style="color: grey">已结束</span>
                                                <?php }?>
                                            <?php }?>
                                        </td>
                                        <td>
                                            <p>
                                                <?php if (!$_smarty_tpl->tpl_vars['val']->value['aal_end_time']||$_smarty_tpl->tpl_vars['val']->value['aal_end_time']>time()) {?>
                                                <a href="/wxapp/auction/editAuction/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
" >编辑</a> -
                                                <?php }?>
                                                <a href="javascript:;" id="del_<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
" class="btn-del" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_id'];?>
"><span style="color: red">删除</span></a>
                                            </p>

                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

                        </div>
                    </div>
                </div><!-- /span -->
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">

    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('gid'),
            'type': 'auction'
        };
        //commonDeleteById(data);
        commonDeleteByIdWxapp(data);
    });
    function saveRatio(){
        var gid = $('#hid-goods').val();
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }


    function pushGoods(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/goodsPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }


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

    $(".set-auction").on('click',function () {
        var that = this;
        layer.confirm('确定要修改展示状态吗？', {
            btn: ['确定','取消'], //按钮
            title : '修改'
        }, function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });

            var id = $(that).data('id');
            var show = $(that).data('show');

            var data = {
                'id'  :id,
                'show' :show?0:1,
            };

            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/auction/changeAuction',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        })
    });
</script><?php }} ?>

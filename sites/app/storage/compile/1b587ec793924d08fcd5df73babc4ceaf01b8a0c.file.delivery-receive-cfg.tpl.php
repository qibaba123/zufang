<?php /* Smarty version Smarty-3.1.17, created on 2020-02-18 21:23:29
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/delivery/delivery-receive-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15558342305e4be5514570e0-53691576%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b587ec793924d08fcd5df73babc4ceaf01b8a0c' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/delivery/delivery-receive-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15558342305e4be5514570e0-53691576',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'showReceivePriceLimit' => 0,
    'isPoint' => 0,
    'selectList' => 0,
    'showStoreGoodsLimit' => 0,
    'curr_shop' => 0,
    'sendCfg' => 0,
    'name' => 0,
    'storeList' => 0,
    'val' => 0,
    'showManager' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4be5514cca79_07615651',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4be5514cca79_07615651')) {function content_5e4be5514cca79_07615651($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<style>
    .inline-div{
        line-height: 34px;
        padding-right: 0;
        padding-left: 0;
    }
    .searchable-select-dropdown{
        z-index: 999;
    }
    #myModal .searchable-select{
        width: 100%;
    }
    .searchable-select-input[type="text"]{
        display: inline-block;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }

</style>
<style>
        input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    <?php if ($_smarty_tpl->tpl_vars['showReceivePriceLimit']->value==1) {?>
    .watermrk-show{
        display: block !important;
        margin-left: 0;
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .watermrk-show .label-name{
        min-width: 100px;
        text-align: right;
    }
    <?php }?>

    </style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <div  id="mainContent" >

        <?php if ($_smarty_tpl->tpl_vars['isPoint']->value!=1) {?>
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
            <span style="color: red;">商品可到店消费、门店自提</span>
        </div>
        <?php }?>
        <div class="page-header">
            <!--<a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>-->
            <?php if ($_smarty_tpl->tpl_vars['isPoint']->value==1) {?>
            <a href="/wxapp/community/addReceiveStore" class="btn btn-green btn-xs add-activity" ><i class="icon-plus bigger-80"></i> 新增自提门店</a>
            <?php } else { ?>
            <a href="/wxapp/delivery/addReceiveStore" class="btn btn-green btn-xs add-activity" ><i class="icon-plus bigger-80"></i> 新增自提门店</a>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['selectList']->value) {?>
            <a href="#" class="btn btn-green btn-xs add-activity" data-toggle="modal" data-target="#myModal" >选择自提门店</a>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['showStoreGoodsLimit']->value==1) {?>
            <span style="margin-left: 20px">
                    自提商品限制：
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="store-goods-limit"  data-type="open" onchange="changeStoreGoodsLimit()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value&&$_smarty_tpl->tpl_vars['curr_shop']->value['s_store_goods_limit']) {?>checked<?php }?>>
                        <span class="lbl"></span>
                    </label>
            </span>
            <?php }?>

            <span style="margin-left: 20px">
                    门店自提：
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="receiveOpen"  data-type="open" onchange="changeOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value&&$_smarty_tpl->tpl_vars['sendCfg']->value['acs_receive']) {?>checked<?php }?>>
                        <span class="lbl"></span>
                    </label>
            </span>


            <?php if ($_smarty_tpl->tpl_vars['isPoint']->value!=1) {?>
            <div class="watermrk-show">
                <span class="label-name">排序：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="number" style="width: 70px;color:#000" maxlength="2" class="form-control" id="delivery-sort" value="<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_receive_sort'];?>
" data-type="receive" oninput="if(value.length>2)value=value.slice(0,2)">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-delivery-sort">确认</span>
                            <span>数值越大越靠前</span>
                        </span>
                    </div>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['showReceivePriceLimit']->value==1) {?>
            <div class="watermrk-show">
                <span class="label-name">最低自提金额：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="number" style="width: 70px;color:#000" class="form-control" id="receive_price" value="<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_receive_price'];?>
" data-type="receive">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-receive-price">确认</span>
                            <span>0表示不限制</span>
                        </span>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php }?>


        </div>
        <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/delivery/receiveCfg" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">门店名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="门店名称">
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
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <thead>
                        <tr>
                            <th>门店名称</th>
                            <th>是否总店</th>
                            <th>联系方式</th>
                            <th>详细地址</th>
                            <th>营业时间</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['storeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
">
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['os_name'];?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['os_is_head']==1) {?>
                                    总店
                                    <?php }?>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['os_contact'];?>
</td>
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><?php echo $_smarty_tpl->tpl_vars['val']->value['os_addr'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['os_open_time'];?>
-<?php echo $_smarty_tpl->tpl_vars['val']->value['os_close_time'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['os_create_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['os_create_time']);?>
<?php }?></td>
                                <td style="color:#ccc;">
                                    <?php if ($_smarty_tpl->tpl_vars['isPoint']->value==1) {?>
                                    <a href="/wxapp/community/addReceiveStore/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
">详情</a> -

                                    <?php } else { ?>
                                    <a href="/wxapp/delivery/addReceiveStore/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
">详情</a> -
                                    <a href="/wxapp/order/tradeList?osId=<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
" >门店订单</a> -
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['showManager']->value==1) {?>
                                    <a href="#" class="btn-manager" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
" data-mobile="<?php echo $_smarty_tpl->tpl_vars['val']->value['os_manager_mobile'];?>
" data-password="<?php if ($_smarty_tpl->tpl_vars['val']->value['os_manager_password']) {?>1<?php } else { ?>0<?php }?>">管理员</a> -
                                    <?php }?>
                                    <a href="#" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
" onclick="removeReceiveStore(this)" style="color:#f00;">移除</a>
                                    <?php if ($_smarty_tpl->tpl_vars['showStoreGoodsLimit']->value==1) {?>
                                    <p>
                                        <a href="/wxapp/delivery/editStoreGoods?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
" >自提商品</a>
                                    </p>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="14"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
    <div class="modal-dialog" style="width: 400px;">
        <div class="modal-content" style="overflow: inherit;">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    选择自提门店
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div style="margin: auto">
                        <div class="col-sm-2 inline-div" style="text-align: right">请选择</div>
                        <div class="col-sm-10">
                            <select name="select_store" id="select_store">
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['selectList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['os_name'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-receive">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="managerModal" tabindex="-1" role="dialog" aria-labelledby="managerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 500px !important;">
        <div class="modal-content">
             <input type="hidden" id="hid_osId" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="managerModalLabel">
                    管理员
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>手机号</label>
                    <div class="col-sm-8">
                        <input id="manager_mobile" class="form-control" placeholder="请填写管理员手机" style="height:auto!important" type="number"/>
                    </div>
                </div>
                    <div class="space-4"></div>
                <div class="form-group row" style="margin-bottom: 3px !important;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码
                        <span class="password-green" style="color: green;display: none">(已设置)</span>
                        <span class="password-red" style="color: red;display: none">(未设置)</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="password" autocomplete="off" id="manager_password" class="form-control" placeholder="请填写管理员密码" style="height:auto!important" />
                    </div>
                </div>
                    <div class="modal-tip" style="color: #777;display: none;font-size: 12px;padding-left: 120px">不填写则不修改</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveManager">保存</button>
            </div>
        </div>
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../../manage/common-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('#select_store').searchableSelect();
    function removeReceiveStore(ele) {
        var id = $(ele).data('id');
        var status = 0;
        if(id){
        	layer.confirm('确定要移除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           	var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/delivery/changeReceiveStore',
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
	        });
        }
    }


    $('#change-receive').on('click',function(){
        var id = $('#select_store').val();
        var status = 1;

        var data = {
            id : id,
            status : status
        };
        console.log(data);

        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/delivery/changeReceiveStore',
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

    function changeOpen() {
        var open   = $('#receiveOpen:checked').val();
        console.log(open);
        var data = {
            value:open,
            type : 'receive'
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSend',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
                if(ret.ec == 400 && open == 'on'){
                    $('#receiveOpen').removeAttr('checked');
                    layer.msg(ret.em);
                }
            }
        });
    }

    function changeStoreGoodsLimit() {
        var open   = $('#store-goods-limit:checked').val();
        console.log(open);
        var data = {
            value:open,
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeStoreGoodsLimit',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
                if(ret.ec == 400 && open == 'on'){
                    $('#store-goods-limit').removeAttr('checked');
                    layer.msg(ret.em);
                }
            }
        });
    }


    $('.btn-manager').on('click',function () {
       var id = $(this).data('id');
       var mobile = $(this).data('mobile');
       var password = $(this).data('password');
       console.log(password);
       $('.password-green').css('display','none');
       $('.password-red').css('display','none');
       $('.modal-tip').css('display','none');
       $('#hid_osId').val('');
       $('#manager_mobile').val('');
       $('#manager_password').val('');
       $('#hid_osId').val(id);
       $('#manager_mobile').val(mobile);

       if(mobile){
           $('.modal-tip').css('display','');
       }

       if(password == 1){
           $('.password-green').css('display','');
       }else if(password == 0){
           $('.password-red').css('display','');
       }

       $('#managerModal').modal('show');

    });

    $('.saveManager').on('click',function () {
       var id =  $('#hid_osId').val();
       var mobile = $('#manager_mobile').val();
       var password = $('#manager_password').val();

       var data = {
           id:id,
           mobile:mobile,
           password:password
       };
       $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/saveStoreManager',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    $('#save-delivery-sort').on('click',function () {
        var value = $('#delivery-sort').val();
        var type = $('#delivery-sort').data('type');
        var data = {
            value:value,
            type : type
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSort',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });

    $('#save-receive-price').on('click',function () {
        var value = $('#receive_price').val();
        var data = {
            value:value,
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeReceivePrice',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });


</script>
<?php }} ?>

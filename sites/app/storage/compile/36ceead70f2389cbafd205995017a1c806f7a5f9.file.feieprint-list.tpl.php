<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 09:17:11
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/print/feieprint-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8416341745e4f2f97b73fe7-16512639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36ceead70f2389cbafd205995017a1c806f7a5f9' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/print/feieprint-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8416341745e4f2f97b73fe7-16512639',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'siddd' => 0,
    'showCategory' => 0,
    'esTrade' => 0,
    'region' => 0,
    'show_printer_owner' => 0,
    'list' => 0,
    'val' => 0,
    'firstCategory' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f2f97be0ab6_08144720',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f2f97be0ab6_08144720')) {function content_5e4f2f97be0ab6_08144720($_smarty_tpl) {?><script>
    //console.log(<?php echo $_smarty_tpl->tpl_vars['siddd']->value;?>
);
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="add-cost btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="" data-weight="" data-name=""><i class="icon-plus bigger-80"></i> 添加打印机</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                	<!--table-striped--> 
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>打印机编号</th>
                            <th>打印机名称</th>
                            <th>打印机状态</th>
                            <th>待打印数量</th>
                            <th>流量卡号</th>
                            <th>是否自动打印</th>
                            <?php if ($_smarty_tpl->tpl_vars['showCategory']->value==1) {?>
                            <th>商品分类</th>
                            <?php }?>
                            <!--
                            <?php if ($_smarty_tpl->tpl_vars['esTrade']->value==1) {?>
                            <th>是否打印商家订单</th>
                            <?php }?>
                            -->
                            <th>添加时间</th>
                            <?php if ($_smarty_tpl->tpl_vars['region']->value!=1&&$_smarty_tpl->tpl_vars['show_printer_owner']->value==1) {?>
                            <th>添加人</th>
                            <?php }?>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['afl_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['status'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['orderNum'];?>
<?php if ($_smarty_tpl->tpl_vars['val']->value['orderNum']>0) {?><a style="margin-left: 8px" href="javascript:;" class="btn btn-danger btn-xs" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="waiting" data-msg="确定清除待打印订单吗？" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
" onclick="printOperate(this)">清空</a><?php }?></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['afl_phonenum'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['afl_automatic']>0) {?><span style="color:#333">是</span><a class="btn btn-danger btn-xs" style="margin-left: 5px" href="#" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="automatic" data-msg="确定要关闭当前打印机的自动打印吗？" onclick="printOperate(this)">关闭</a><?php } else { ?><span style="color: red">否</span><a class="btn btn-blue btn-xs" style="margin-left: 5px" href="#" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="automatic" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
" data-msg="确定要开启当前打印机的自动打印吗？" onclick="printOperate(this)">开启</a><?php }?></td>
                                <?php if ($_smarty_tpl->tpl_vars['showCategory']->value) {?>
                                <td><?php if (isset($_smarty_tpl->tpl_vars['firstCategory']->value[$_smarty_tpl->tpl_vars['val']->value['afl_kind1']])) {?><?php echo $_smarty_tpl->tpl_vars['firstCategory']->value[$_smarty_tpl->tpl_vars['val']->value['afl_kind1']]['name'];?>
<?php } else { ?>全部<?php }?></td>
                                <?php }?>
                                <!--
                                <?php if ($_smarty_tpl->tpl_vars['esTrade']->value==1) {?>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['afl_es_trade']>0) {?><span style="color:#333">是</span><a class="btn btn-danger btn-xs" style="margin-left: 5px" href="#" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="estrade" data-msg="确定要关闭当前打印机打印商家订单吗？关闭后入驻商家的订单将不会被打印" onclick="printOperate(this)">关闭</a><?php } else { ?><span style="color: red">否</span><a class="btn btn-blue btn-xs" style="margin-left: 5px" href="#" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="estrade" data-msg="确定要开启当前打印机打印商家订单吗？开启后将自动打印入驻商家的订单" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
" onclick="printOperate(this)">开启</a><?php }?></td>
                                <?php }?>
                                -->
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['afl_create_time']);?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['region']->value!=1&&$_smarty_tpl->tpl_vars['show_printer_owner']->value==1) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['afl_create_by']==0) {?>
                                    <td title='区域合伙人添加'>平台</td>
                                    <?php } else { ?>
                                    <td title='区域合伙人添加'><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                    <?php }?>
                                <?php }?>
                                <td>
                                    <a class="confirm-handle btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_name'];?>
" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-phonenum="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_phonenum'];?>
" data-key="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_key'];?>
" data-estrade="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_es_trade'];?>
" data-kind1="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_kind1'];?>
">编辑</a>
                                    <a class="confirm-handle btn btn-green btn-xs" href="#" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="test" data-msg="确定发送测试订单到该打印机吗？" onclick="printOperate(this)" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
" >测试</a>
                                    <a class="btn btn-danger btn-xs" href="#" data-sn="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
" data-type="delete" data-msg="确定删除当前打印机吗？" onclick="printOperate(this)" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_id'];?>
" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
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
                    添加打印机
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">打印机编号（必填）</label>
                    <div class="col-sm-7">
                        <input id="print-sn" class="form-control" placeholder="请填写打印机编号" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">打印机识别码（必填）</label>
                    <div class="col-sm-7">
                        <input id="print-key" class="form-control" placeholder="请填写打印机识别码" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">打印机备注名称</label>
                    <div class="col-sm-7">
                        <input id="print-name" class="form-control" placeholder="请填写打印机备注名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">流量卡号</label>
                    <div class="col-sm-7">
                        <input id="print-phonenum" class="form-control" placeholder="请填写流量卡号" style="height:auto!important"/>
                    </div>
                </div>

                <div class="form-group row" <?php if ($_smarty_tpl->tpl_vars['showCategory']->value==0) {?>style="display:none"<?php }?>>
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">商品分类</label>
                    <div class="col-sm-7">
                        <select name="print-kind1" id="print-kind1" class="form-control">
                            <option value="0">全部</option>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['firstCategory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!--
                <?php if ($_smarty_tpl->tpl_vars['esTrade']->value==1) {?>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">同步打印商家订单</label>
                    <div class="col-sm-7">
                        <div class="radio-box">
                            <span data-val="1">
                                <input type="radio" name="esTrade" value="1" id="esTrade1" >
                                <label for="esTrade1">是</label>
                            </span>
                            <span data-val="0">
                                <input type="radio" name="esTrade" value="0" id="esTrade0" checked>
                                <label for="esTrade0">否</label>
                            </span>
                        </div>
                        <span style="font-size: 12px;color: #777">启用时，当入驻商家有订单付款时，此打印机会同步打印</span>
                    </div>
                </div>
                <?php }?>
                -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-save">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#print-sn').val($(this).data('sn'));
        $('#print-name').val($(this).data('name'));
        $('#print-key').val($(this).data('key'));
        $('#print-phonenum').val($(this).data('phonenum'));
        $('#print-kind1').val($(this).data('kind1'));

    });
    $('#confirm-save').on('click',function(){
        var id   = $('#hid_id').val();
        var sn   = $('#print-sn').val();
        var name = $('#print-name').val();
        var key  = $('#print-key').val();
        var phonenum = $('#print-phonenum').val();
        var kind1 = $('#print-kind1').val();
        var data = {
            id     : id,
            sn     : sn,
            name   : name,
            key    : key,
            phonenum   : phonenum,
            kind1  : kind1
        };
        if(data){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/print/savePrintNew',
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
    // 操作打印机
    function printOperate(ele) {
        var sn = $(ele).data('sn');
        var id = $(ele).data('id');
        var type = $(ele).data('type');
        var msg = $(ele).data('msg');
        if(sn){
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/print/printOperate',
                    'data'  : { sn:sn,type:type,id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            //window.location.reload();
                        }
                    }
                });
            }, function() {

            });
        }
    }

</script><?php }} ?>

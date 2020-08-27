<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:07:28
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/shop-apply-enter-list-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3422089655dea1a50033629-41340737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '50d666c4aad4b9ebd69a29ab5b346f5c988dbeed' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/shop-apply-enter-list-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3422089655dea1a50033629-41340737',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'curr_domain' => 0,
    'menuType' => 0,
    'personApply' => 0,
    'maid' => 0,
    'list' => 0,
    'val' => 0,
    'category' => 0,
    'district' => 0,
    'status' => 0,
    'pagination' => 0,
    'protocol' => 0,
    'applyRule' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1a500bf2a6_71774164',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1a500bf2a6_71774164')) {function content_5dea1a500bf2a6_71774164($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
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


    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../../manage/common-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <div  id="mainContent" >
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
        商家登录管理地址：<a href="http://<?php echo $_smarty_tpl->tpl_vars['curr_domain']->value;?>
/shop/user/index"> http://<?php echo $_smarty_tpl->tpl_vars['curr_domain']->value;?>
/shop/user/index</a><a href="javascript:;" class="copy-button btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://<?php echo $_smarty_tpl->tpl_vars['curr_domain']->value;?>
/shop/user/index" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>

    </div>
        <div class="page-header">
            <a href="/wxapp/community/inCharge" class="btn btn-green btn-sm"><i class="icon-plus bigger-80"></i> 入驻费用配置</a>
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#topModal"><i class="icon-plus bigger-80"></i>入驻页顶部图片</button>
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#enterModal"><i class="icon-plus bigger-80"></i>入驻协议</button>
            <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
            <button class="btn btn-green btn-xs" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#ruleModal">入驻说明</button>
            <span style="">
                    允许个人申请：
                    <label id="choose-onoff" class="choose-onoff">
                        <input name="sms_start" class="ace ace-switch ace-switch-5" id="personApply" data-type="person" onchange="changeOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['personApply']->value) {?> checked<?php }?>>
                    <span class="lbl"></span>
                    </label>
            </span>
            <?php }?>
            <div class="watermrk-show">
                <span class="label-name">店铺订单抽成比例(%)：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="text" style="width: 60px" class="form-control" id="default-maid" value="<?php echo $_smarty_tpl->tpl_vars['maid']->value;?>
">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-default-maid">确认修改</span>
                            <span>（微信在线支付提现会收取0.6%手续费）</span>
                        </span>
                    </div>
                </div>
            </div>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>

                            <th>申请店铺名称</th>
                            <th>负责人</th>
                            <th>联系电话</th>
                            <th>分类</th>
                            <!--
                            <th>商圈</th>
                            <th>店铺地址</th>
                            <th>营业执照</th>
                            -->

                            <th>申请状态</th>
                            <th>申请时间</th>
                            <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                            <th>店铺区域</th>
                            <th>入驻时长</th>
                            <?php }?>
                            <th>处理备注</th>
                            <th>处理时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_contact'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_phone'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['category']->value[$_smarty_tpl->tpl_vars['val']->value['es_cate1']];?>
-<?php echo $_smarty_tpl->tpl_vars['category']->value[$_smarty_tpl->tpl_vars['val']->value['es_cate2']];?>
</td>
                                <!--
                                <td><?php echo $_smarty_tpl->tpl_vars['district']->value[$_smarty_tpl->tpl_vars['val']->value['es_district2']]['area_name'];?>
-<?php echo $_smarty_tpl->tpl_vars['district']->value[$_smarty_tpl->tpl_vars['val']->value['es_district2']]['name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_addr'];?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['es_addr_detail'];?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['es_license']) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_license'];?>
" alt="" style="width: 100px"/>
                                    <?php }?>
                                </td>
                                -->
                                <td style="color: <?php if ($_smarty_tpl->tpl_vars['val']->value['acsa_status']==3) {?>red<?php } else { ?>green<?php }?>"><?php echo $_smarty_tpl->tpl_vars['status']->value[$_smarty_tpl->tpl_vars['val']->value['es_handle_status']];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['es_createtime']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['es_createtime']);?>
<?php }?></td>
                                <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                                  <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['es_prov_name'];?>
-<?php echo $_smarty_tpl->tpl_vars['val']->value['es_city_name'];?>
-<?php echo $_smarty_tpl->tpl_vars['val']->value['es_zone_name'];?>

                                  </td>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['daysValue'];?>

                                </td>
                                <?php }?>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_handle_remark'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['es_handle_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['es_handle_time']);?>
<?php }?></td>
                                <td class="jg-line-color">
                                    <a href="/wxapp/community/applyDetail?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">详情</a>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['es_handle_status']==1) {?>
                                     - <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">处理</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="12"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
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
                    申请处理
                </h4>
            </div>
            <div class="modal-body" style="padding: 15px!important;">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="enterModal" tabindex="-1" role="dialog" aria-labelledby="enterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="enterModalLabel">
                    入驻协议
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12" style="padding: 30px">
                        <textarea class="form-control" style="width:100%;height:400px;visibility:hidden;" id = "protocol" name="protocol" placeholder="入驻协议"  rows="20" style=" text-align: left; resize:vertical;" >
                              <?php if ($_smarty_tpl->tpl_vars['protocol']->value) {?><?php echo $_smarty_tpl->tpl_vars['protocol']->value;?>
<?php }?>
                        </textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="protocol" />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="conform-protocol">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<div class="modal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="ruleModalLabel">
                    入驻说明
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12" style="padding: 30px">
                        <textarea class="form-control" style="width:100%;height:400px;visibility:hidden;" id = "apply_rule" name="apply_rule" placeholder="入驻协议"  rows="20" style=" text-align: left; resize:vertical;" >
                              <?php if ($_smarty_tpl->tpl_vars['applyRule']->value) {?><?php echo $_smarty_tpl->tpl_vars['applyRule']->value;?>
<?php }?>
                        </textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="apply_rule" />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="conform-rule">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="topModal" tabindex="-1" role="dialog" aria-labelledby="topModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    入驻页顶部图片
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <!--<div style="text-align: center;padding: 20px 0">
                            <img onclick="toUpload(this)" data-limit="1" style="width: 80%" data-width="750" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<?php if ($_smarty_tpl->tpl_vars['image']->value) {?><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
<?php } else { ?>/public/wxapp/community/images/image_750_200.png<?php }?>"  width="750px" height="200px" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="top-image"  class="avatar-field bg-img" name="top-image" value="<?php if ($_smarty_tpl->tpl_vars['image']->value) {?><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
<?php }?>"/>
                        </div>-->
                        <div class="cropper-box" data-width="750" data-height="200" style="padding: 20px 0">
                            <img id="default-cover" src="<?php if ($_smarty_tpl->tpl_vars['image']->value) {?><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
<?php } else { ?>/public/wxapp/community/images/image_750_200.png<?php }?>" width="80%"style="display:block;margin:auto" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="top-image" id="top-image" value="<?php if ($_smarty_tpl->tpl_vars['image']->value) {?><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
<?php } else { ?>/public/wxapp/community/images/image_750_200.png<?php }?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-save">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript">
    // 定义一个新的复制对象
    var clipboard = new ClipboardJS('.copy-button');
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        console.log(e);
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
        console.log(e);
        console.log('复制失败');
    });


    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-save').on('click',function(){
        var image = $('#top-image').val();
        var data = {
            image: image
        };

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/saveTopImage',
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

    // 提交入驻协议
    $("#conform-protocol").click(function(){
        var protocol = $('#protocol').val();
        var data = {
            'protocol'     : protocol
        };
        var index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            type: 'post',
            url: "/wxapp/community/saveProtocol" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    $('#myModal').modal('hide');
                }
            }
        });
    });

    // 提交入驻说明
    $("#conform-rule").click(function(){
        var rule = $('#apply_rule').val();
        var data = {
            'rule' : rule
        };
        var index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            type: 'post',
            url: "/wxapp/community/saveRule" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    $('#myModal').modal('hide');
                }
            }
        });
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/handleApply',
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

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#top-image').val(allSrc[0]);
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

    /**
     * 修改默认抽成比例
     */
    $('#save-default-maid').on('click',function(){
        var defaultmaid = $('#default-maid').val();    // 默认抽成比例
        if(defaultmaid){
            if(defaultmaid=='<?php echo $_smarty_tpl->tpl_vars['maid']->value;?>
'){
                return;
            }
            var index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            var data = {
                'defaultmaid' : defaultmaid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/Basiccfg/updateDefaultMaid',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        }
    });

    function changeOpen() {
        var open   = $('#personApply:checked').val();
        console.log(open);
        var data = {
            value: open,
            type : 'person'
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/changeOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }

</script>
<?php }} ?>

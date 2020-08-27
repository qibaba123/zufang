<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:07:25
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/memberCard/card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14076505425dea1a4d7bad24-41937359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e169a26c0fdd53f4d8d482fa6d8c1f185531a7a8' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/memberCard/card.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14076505425dea1a4d7bad24-41937359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cardtype' => 0,
    'appletCfg' => 0,
    'list' => 0,
    'val' => 0,
    'type' => 0,
    'pageHtml' => 0,
    'pagination' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1a4d829607_69559687',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1a4d829607_69559687')) {function content_5dea1a4d829607_69559687($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .nav-tabs{z-index:1;}
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
    .table thead tr th{font-size:12px;}
    .choose-state>a.active{border-bottom-color: #4C8FBD;border-top:0;}
    .tr-content .card-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;margin-left:3px}
    .tr-content:hover .card-admend{visibility:visible;}
    .btn-xs{padding:0 2px!important;}
</style>
<!-- 修改会员卡信息弹出框 -->
<div class="ui-popover ui-popover-cardinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-cardinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <?php echo $_smarty_tpl->getSubTemplate ("./tabal-link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <div class="tab-content"  style="z-index:1;">
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <div class="page-header">
                            <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?>
                            <a href="/wxapp/membercard/addCard" class="btn btn-green btn-sm" >添加会员计次卡</a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                            <a href="/wxapp/membercard/addCard/type/2" class="btn btn-green btn-sm" >
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==16) {?>
                                添加会员卡
                                <?php } else { ?>
                                添加会员卡
                                <?php }?>

                            </a>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==27) {?>
                            <a href="/wxapp/knowledgepay/vipRightsCfg" class="btn btn-green btn-sm" >会员权益页面</a>
                            <?php }?>
                            <?php }?>
                        </div>
                        <!--------------会员卡记录列表---------------->
                        <div class="choose-state">
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                            <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?>
                            <a href="/wxapp/membercard/card/type/1"  class="active" >优惠次卡</a>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                            <a href="/wxapp/membercard/card/type/2"  class="active" >会员卡</a>
                            <?php }?>
                            <?php }?>

                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                                    <th>会员卡名称</th>
                                    <?php } else { ?>
                                    <th>会员卡名称</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                    <th>副标题</th>
                                    <?php }?>
                                    <th>类型/时长</th>
                                    <th>价格</th>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                    <th>消费次数</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                                    <th>折扣率</th>
                                    <?php }?>
                                    <th>排序权重</th>
                                    <th>权益</th>
                                    <th>须知</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
" class="tr-content">
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name_sub'];?>
</td>
                                    <?php }?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['val']->value['oc_long_type']]['name'];?>
/<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_long'];?>
天</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_price'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['oc_times']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_times'];?>
次<?php } else { ?>不限<?php }?></td>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['ml_discount']>0) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['ml_discount'];?>
折<?php }?></td>
                                    <?php }?>
                                    <td>
                                        <span><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_weight'];?>
</span>
                                        <img src="/public/wxapp/images/icon_edit.png" class="card-admend set-card-weight" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_weight'];?>
" data-field="weight" />
                                    </td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_rights'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_notice'];?>
</td>
                                    <td style="color:#ccc;">
                                        <a href="/wxapp/membercard/addCard/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
&type=<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_type'];?>
" >编辑</a>-
                                        <a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
" class="del-btn" style="color:#f00;">删除</a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if ($_smarty_tpl->tpl_vars['pageHtml']->value) {?>
                                    <tr><td colspan="10" class='text-right'><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
    $("body").on('click', function(event) {
        optshide();
    });

    $('.del-btn').on('click',function(){
        var data   = {
            'id'     : $(this).data('id')
        };
        if(data.id > 0){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           	var loading = layer.load(10, {
	                shade: [0.6,'#666']
	            });
	           	console.log(data);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/membercard/delCard',
	                'data'  : data,
	                'dataType' : 'json',
	                'success'   : function(ret){
	                    console.log(ret);
	                    layer.close(loading);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
	                        $('#tr_'+data.id).hide();
	                    }
	                }
	            }); 
	        });
        }
    });

    /*修改商品信息*/
    $("#content-con").on('click', 'table td .card-admend.set-card-weight', function(event) {
        var id = $(this).data('id');
        var field = $(this).data('field');
        //var value = $(this).data('value');
        var value = $(this).parent().find("span").text();//直接取span标签内数值,防止更新后value不变
        //console.log(value);
        $('#hid_gid').val(id);
        $('#hid_field').val(field);
        $('#currValue').val(value);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-cardinfo").css({'left':left-conLeft-376,'top':top-conTop-76}).stop().show();
    });

    $(".ui-popover-cardinfo").on('click', function(event) {
        event.stopPropagation();
    });

    /*隐藏弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    $(".save-cardinfo").on('click',function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });

        var id = $('#hid_gid').val();
        var field = $('#hid_field').val();
        var value = $('#currValue').val();

        var data = {
            'id'  :id,
            'field' :field,
            'value':value
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/membercard/changeCardInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find("span").text(value);
                    layer.close(index);
                    if(field == "weight"){
                        window.location.reload();
                    }
                }else{
                    layer.msg(ret.em);
                }
            }
        });


    });
</script>



<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:35:49
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/memberCard/store-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8146813005e1be595542a83-81296175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e86581bbd5a24617e54f64f73865817b49c84bcb' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/memberCard/store-cfg.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8146813005e1be595542a83-81296175',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cfg' => 0,
    'cardtype' => 0,
    'appletCfg' => 0,
    'list' => 0,
    'val' => 0,
    'type' => 0,
    'pageHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be595596152_64422044',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be595596152_64422044')) {function content_5e1be595596152_64422044($_smarty_tpl) {?><style>
    /* 会员信息提示框样式 */
    .page-header{
        padding:10px 0;
    }
    .page-header .alert-gray{
        background-color: #F4F4F4;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
        color: #666;
        padding: 5px 15px;
        margin-bottom: 10px;
    }
    body{
        min-width: 1200px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .daytimes{
        display: inline-block;
        vertical-align: top;
        margin-right: 20px;
    }
    .daytimes>span{
        line-height: 29px;
        padding:0 3px;
        display: inline-block;
        vertical-align: top;
    }
    .nav-tabs{z-index:1;}
    .table tr th ,.table tr td {
        text-align: center;
    }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<div class="row">
    <div class="col-sm-12" style="margin-bottom: 20px;">
        <div class="tabbable">
            <!----导航链接----->
            <?php echo $_smarty_tpl->getSubTemplate ("./tabal-link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <div class="tab-content">
                <!--店铺基本信息-->
                <div id="home" class="tab-pane in active">
                    <div class="row form-group">
                        <label for="" class="col-xs-2 text-right" style="line-height:29px;">会员计次卡背景图:</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="360" data-dom-id="bg-img">
                            <img src="<?php if ($_smarty_tpl->tpl_vars['cfg']->value['oc_bg']) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['oc_bg'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_75_36.png<?php }?>" class="img-thumbnail"  id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图<small>建议尺寸：750*360</small></span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="" class="col-xs-2 text-right" style="line-height:29px;">核销方式:</label>
                        <div class="radio-box">
                            <span data-val="1" class="select-verify">
                                <input type="radio" name="verify" value="1" <?php if ($_smarty_tpl->tpl_vars['cfg']->value['oc_verify_type']==1) {?>checked<?php }?> id="type1" >
                                <label for="type1" data-key="1">按卡设置核销</label>
                            </span>
                            <span data-val="2" class="select-verify">
                                <input type="radio" name="verify" value="2" <?php if ($_smarty_tpl->tpl_vars['cfg']->value['oc_verify_type']==2) {?>checked<?php }?> id="type2" >
                                <label for="type2" data-key="1">自定义核销</label>
                            </span>
                        </div>
                    </div>
                    <div class="row custom-set form-group" <?php if ($_smarty_tpl->tpl_vars['cfg']->value['oc_verify_type']==1) {?>style="display: none;"<?php }?>>
                        <label for="" class="col-xs-2 text-right" style="line-height:29px;">免费消费设置:</label>
                        <div class="col-xs-10">
                            <div class="daytimes"><input type="text" class="input-mini" id="days" /><span>天</span></div>
                            <div class="daytimes"><input type="text" class="input-mini" id="times" /><span>次</span></div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group text-center">
                        <button class="btn btn-blue cfg-btn" style="margin:0 10px" >保存</button>
                    </div>
                </div>
            </div>
        <div class="tab-content"  style="z-index:1;">
            <!--验证卡券-->
            <div id="tab1" class="tab-pane in active">
                <div class="verify-intro-box" data-on-setting>
                    <div class="page-header">
                        <span style="font-weight: bold;margin-right: 5px;font-size: 18px">计次卡种类</span>
                        <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?>
                        <a href="/wxapp/membercard/addCard" class="btn btn-green btn-sm" ><i class="icon-plus bigger-80"></i> 新增</a>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?>
                        <a href="/wxapp/membercard/addCard/type/2" class="btn btn-green btn-sm" >
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==16) {?>
                            添加会员卡
                            <?php } else { ?>
                            添加会员卡
                            <?php }?>

                        </a>
                        <?php }?>
                    </div>
                    <!--------------会员卡记录列表---------------->
                    <div class="choose-state">
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                    <a href="/wxapp/membercard/card/type/1" <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==1) {?> class="active" <?php }?>>优惠次卡</a>
                        <?php }?>
                        <!--<a href="/wxapp/membercard/card/type/2" <?php if ($_smarty_tpl->tpl_vars['cardtype']->value==2) {?> class="active" <?php }?>>会员卡</a>-->
                    </div>
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-bordered table-hover">
                            <thead>
                            <tr class="success">
                                <th>会员卡名称</th>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                <th>副标题</th>
                                <?php }?>
                                <th>类型/时长</th>
                                <th>价格</th>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                <th>消费次数</th>
                                <?php }?>
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
">
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name_sub'];?>
</td>
                                    <?php }?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['val']->value['oc_long_type']]['name'];?>
/<?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['val']->value['oc_long_type']]['long'];?>
<!--<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_long'];?>
-->天</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_price'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=16) {?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['oc_times']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_times'];?>
次<?php } else { ?>不限<?php }?></td>
                                    <?php }?>
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
                                <tr><td colspan="8"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
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
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" >
    $(function(){
        $('#days').ace_spinner({
            value:<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['oc_use_day'];?>
<?php } else { ?>1<?php }?>,
            min:1,
            max:100,
            step:1,
            on_sides: true, 
            icon_up:'icon-plus smaller-75', 
            icon_down:'icon-minus smaller-75',
             btn_up_class:'btn-success' , 
             btn_down_class:'btn-danger'
        });
        $('#times').ace_spinner({
            value:<?php if ($_smarty_tpl->tpl_vars['cfg']->value) {?><?php echo $_smarty_tpl->tpl_vars['cfg']->value['oc_use_num'];?>
<?php } else { ?>1<?php }?>,
            min:1,
            max:100,
            step:1,
            on_sides: true, 
            icon_up:'icon-plus smaller-75', 
            icon_down:'icon-minus smaller-75',
             btn_up_class:'btn-success' , 
             btn_down_class:'btn-danger'
        });

        
        $('.cfg-btn').on('click',function(){
            var data = {
                'day'   : $('#days').val(),
                'times' : $('#times').val(),
                'verify': $('input[name="verify"]:checked').val(),
                'bg'    : $('#bg-img').attr('src'),
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/membercard/openStore',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                }
            });
        });
        
    })
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
            }
        }
    }
    $('.select-verify').on('click',function(){
        var val = $(this).data('val');
        if(val == 2){
            $('.custom-set').show();
        }else{
            $('.custom-set').hide();
        }
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
</script><?php }} ?>

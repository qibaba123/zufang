<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:12:57
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/bargain/activity.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16477519765e4df939d7d3a9-27051955%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7656d160ac370552b4e1aff909c6515464d698e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/bargain/activity.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16477519765e4df939d7d3a9-27051955',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cropper' => 0,
    'row' => 0,
    'goodsName' => 0,
    'restart' => 0,
    'goodsList' => 0,
    'val' => 0,
    'goods' => 0,
    'appletCfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df939e05eb0_79368897',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df939e05eb0_79368897')) {function content_5e4df939e05eb0_79368897($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    #banner-lists .banner-item{
        margin-bottom: 15px;
        display: none;
    }
    #banner-lists .banner-item .show{
        display: block;
    }
    .form-inline .form-group{
        margin-bottom: 15px;
    }

    .chosen-container {
        width: 100%!important;
    }
    .chosen-container-multi .chosen-choices{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .chosen-container-single .chosen-single{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
        height: 34px;
        background: url();
        background-color: #fff;
    }
    .chosen-container-single .chosen-single span{
        margin-top: 2px;
    }
    .chosen-single div b:before{
        top:3px;
    }
    select.form-control {
        padding: 5px 6px;
        height: 34px;
    }
    .chosen-container {
        width: 70%!important;
        margin-right: 10px;
    }
</style>

<!---
<link rel="stylesheet" href="/modules/common/css/common.css" />
<link rel="stylesheet" href="/modules/common/kindeditor/themes/default/default.css" />

<script type="text/javascript" src="/modules/common/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="/modules/common/js/textarea_kindeditor.js"></script>
---->
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../common-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div><?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>
</div>
    <div class="alert alert-yellow">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <p class="text-center">温馨提示</p>
        <ol>
            <li><small>1、活动开始后，商品价格和时间不可再编辑</small></li>
            <li><small>2、添加活动时间，必须大于当前时间</small></li>
            <li><small>3、砍价的三个阶段设置：可设置需要多少人砍掉多少钱，控制每个阶段砍价的参与人数。如：一个活动想设置砍掉100元，让10个人参与。分阶段设置砍价的好处之一是，前两个阶段可轻松砍到，最后一个阶段可设置多几个人参与才能砍掉。如：可设置第一阶段需要找2人砍掉50元，第二阶段需要2人砍掉30元，第三阶段需要6人砍掉20元。</small></li>
            <li><small>4、购买时最低价：用户砍到这个价格就可以进行购买，不用砍到最后。</small></li>
            <li><small>5、砍价时最低价：砍到的最低价，用户砍到最低价进行购买。</small></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter">新增/编辑砍价活动</h4>
                            <div class="col-xs-1 pull-right search-btn">
                                <a href="/wxapp/bargain/list" class="btn btn-primary btn-xs" style="margin-top:6px;">返回</a>
                            </div>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline" id="activity-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_id'];?>
<?php } else { ?>0<?php }?>">
                                    <div style="overflow:hidden">
                                        <div class="form-group  col-xs-5">
                                            <label for="price">砍价<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
</label>
                                            <div>
                                                <select class="form-control selectpicker chosen-select" id="g_id" name="g_id" onchange="changePrice()" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_g_id']&&$_smarty_tpl->tpl_vars['restart']->value==0) {?>disabled="disabled"<?php }?>  data-live-search="true"  data-need="required" data-placeholder="请选择砍价<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
">
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goodsList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-price="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_g_id']==$_smarty_tpl->tpl_vars['val']->value['g_id']) {?>selected="selected"<?php }?>><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>
</option>
                                                <?php } ?>
                                                </select>
                                                <span>原价：<span id="ori-price"><?php if ($_smarty_tpl->tpl_vars['goods']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_price'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['goodsList']->value[0]['g_price'];?>
<?php }?></span></span>
                                            </div>
                                        </div>

                                        <div class="form-group col-xs-3">
                                            <label for="price">砍价商品库存(0表示取商品库存)</label>
                                            <input type="text" class="form-control" id="goods_stock" name="goods_stock" placeholder="0表示取商品库存" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_goods_stock'];?>
<?php }?>">
                                        </div>

                                        <div class="form-group col-xs-2">
                                            <label for="price">购买时最低价</label>
                                            <input type="text" class="form-control" id="buy_price" name="buy_price" placeholder="购买时最低价" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_buy_price_limit'];?>
<?php }?>">
                                        </div>

                                        <div class="form-group col-xs-2">
                                            <label for="price">砍价时最低价</label>
                                            <input type="text" class="form-control" id="kj_price" name="kj_price" placeholder="砍价时最低价" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_kj_price_limit'];?>
<?php }?>">
                                        </div>


                                        <div class="form-group col-xs-3">
                                            <label for="price">砍价第一段</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="se_price_1" name="se_price_1" placeholder="砍掉价格" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_price_section_1'];?>
<?php }?>">
                                                </div>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="se_num_1" name="se_num_1" placeholder="所需人数" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_num_section_1'];?>
<?php }?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label for="price">砍价第二段</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="se_price_2" name="se_price_2" placeholder="砍掉价格" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_price_section_2'];?>
<?php }?>">
                                                </div>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="se_num_2" name="se_num_2" placeholder="所需人数" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_num_section_2'];?>
<?php }?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-3">
                                            <label for="price">砍价第三段</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="se_price_3" name="se_price_3" placeholder="砍掉价格" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_price_section_3'];?>
<?php }?>">
                                                </div>
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="se_num_3" name="se_num_3" placeholder="所需人数" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_num_section_3'];?>
<?php }?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                        <div class="form-group col-xs-3">
                                        &nbsp;&nbsp;<label for="price">浏览量/是否显示</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="viewNum" name="viewNum" placeholder="浏览量" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_view_num'];?>
<?php }?>">
                                                </div>
                                                <div class="col-xs-6">
                                                    <label style="padding: 4px 0;margin: 0;">
                                                        <input name="viewNumShow" class="ace ace-switch ace-switch-5" id="viewNumShow" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_view_num_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                        <span class="lbl"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>

                                        <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_status']!=0)) {?>
                                        <div class="form-group col-xs-6">
                                            <label for="start">开始时间</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="start" name="start" placeholder="开始时间" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['row']->value['ba_start_time']);?>
<?php }?>">
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input id="startTime" name="startTime" type="text" class="form-control" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('H:i:s',$_smarty_tpl->tpl_vars['row']->value['ba_start_time']);?>
<?php }?>"/>
                                                        <span class="input-group-addon">
                                                            <i class="icon-time bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-xs-6">
                                            <label for="end">结束时间</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="end" name="end" placeholder="结束时间" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['row']->value['ba_end_time']);?>
<?php }?>">
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input id="endTime" name="endTime" type="text" class="form-control" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('H:i:s',$_smarty_tpl->tpl_vars['row']->value['ba_end_time']);?>
<?php }?>"/>
                                                        <span class="input-group-addon">
                                                            <i class="icon-time bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_status']==2&&$_smarty_tpl->tpl_vars['restart']->value==1) {?>
                                            <!-- 已结束活动 重新编辑时间 -->
                                    <input type="hidden" name="restart" id="restart" value="<?php echo $_smarty_tpl->tpl_vars['restart']->value;?>
">
                                            <div class="form-group col-xs-6">
                                            <label for="start">开始时间</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="start" name="start" placeholder="开始时间" required="required" value="">
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input id="startTime" name="startTime" type="text" class="form-control" required="required" value=""/>
                                                        <span class="input-group-addon">
                                                            <i class="icon-time bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-xs-6">
                                            <label for="end">结束时间</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <input type="text" class="form-control" id="end" name="end" placeholder="结束时间" required="required" value="">
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input id="endTime" name="endTime" type="text" class="form-control" required="required" value=""/>
                                                        <span class="input-group-addon">
                                                            <i class="icon-time bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label no-padding-right">活动封面图片（建议尺寸：710*350）</label>
                                            <div class="cropper-box" data-width="710" data-height="350" >
                                                <img <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_image']) {?>src=<?php echo $_smarty_tpl->tpl_vars['row']->value['ba_image'];?>
<?php } else { ?>src="/public/manage/img/zhanwei/zw_fxb_350_250.png"<?php }?>  width="95%" style="display:inline-block;">
                                                <input type="hidden" id="ba_img"  class="avatar-field bg-img" name="img" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_image']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_image'];?>
<?php }?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-4">
                                            <label class="control-label no-padding-right">分享描述</label>
                                            <div class="form-textarea">
                                                <textarea id = "desc" name="desc" cols="30" class="form-control" rows="12"><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_desc']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_desc'];?>
<?php }?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label class="control-label no-padding-right">活动规则</label>
                                            <div class="form-textarea">
                                                <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id = "rule" name="rule" placeholder="活动规则"  rows="20" style=" text-align: left; resize:vertical;" >
                                                <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ba_rule']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ba_rule'];?>
<?php }?>
                                                </textarea>
                                                <input type="hidden" name="ke_textarea_name" value="rule" />
                                            </div>
                                        </div>

                                        <div class="form-group col-xs-12" style="text-align:center">
                                            <button type="button" class="btn btn-primary btn-save btn-xs"> 保 存 </button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        // 搜索选择下拉框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true
        });
    });
    /*初始化日期选择器*/
    $('#start').datepicker({autoclose:true}).next().on(ace.click_event, function(){
      // $(this).prev().focus();
    });
    $('#end').datepicker({autoclose:true}).next().on(ace.click_event, function(){
      // $(this).prev().focus();
    });
    $('#startTime').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
    $('#endTime').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });

    function changePrice(){
        $('#ori-price').text($(".chosen-select option:selected").attr("data-price"));
    }

    $('.btn-save').on('click',function(){
        var start   = $('#start').val();
        var endTime = $('#endTime').val();
        var end     = $('#end').val();

        var buy_price = parseFloat($('#buy_price').val());
        var kj_price = parseFloat($('#kj_price').val());
        var price_1  = parseFloat($('#se_price_1').val());
        var price_2  = parseFloat($('#se_price_2').val());
        var price_3  = parseFloat($('#se_price_3').val());

        var num_1    = parseInt($('#se_num_1').val());
        var num_2    = parseInt($('#se_num_2').val());
        var num_3    = parseInt($('#se_num_3').val());

        if((price_1 > 0 && num_1 <= 0 ) || (price_2 > 0 && num_2 <= 0) || (price_3 > 0 && num_3 <= 0)){
            layer.msg('砍价区间数据错误');
            return false;
        }
		
		layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
			var index = layer.load(1, {
	            shade: [0.1,'#fff'] //0.1透明度的白色背景
	        });
	        $.ajax({
	            'type'   : 'post',
	            'url'   : '/wxapp/bargain/save',
	            'data'  : $('#activity-form').serialize(),
	            'dataType'  : 'json',
	            'success'   : function(ret){
	                layer.close(index);
	                if(ret.ec == 200){
	                    window.location.href='/wxapp/bargain/list';
	                }else{
	                    layer.msg(ret.em);
	                }
	            }
	        });
        });
        
    });
</script>

<?php }} ?>

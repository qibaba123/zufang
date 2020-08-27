<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 18:57:40
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/group/add-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20217616385e4e6624a34b69-97019540%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14fedb78a0c34a60a305b9c46239949f9d61999f' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/group/add-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20217616385e4e6624a34b69-97019540',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'groupType' => 0,
    'val' => 0,
    'row' => 0,
    'goodsList' => 0,
    'goods' => 0,
    'appletCfg' => 0,
    'value' => 0,
    'now' => 0,
    'yesNo' => 0,
    'key' => 0,
    'isAdd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6624afd3a6_83668912',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6624afd3a6_83668912')) {function content_5e4e6624afd3a6_83668912($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<!-- <link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" /> -->
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
	input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
		content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
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
	.ptinfo-fenlei{
	    background-color: #f6f6f6;
	    border:1px solid #e8e8e8;
	    border-radius: 4px;
	    margin-bottom: 10px;
	    padding: 15px 10px;
	}
	.ptinfo-fenlei .fenlei-name{
	    font-size: 16px;
	    line-height: 34px;
	    font-weight: bold;
	    color: #02a802;
	    display: block;
	    text-align: center;
	    padding-right: 10px;
	}
	.ptinfo-fenlei .control-label{
		font-weight: bold;
		text-align: right;
		padding-right: 0;
		line-height: 26px;
	}
	.ptinfo-fenlei .col-xs-10 .form-group:last-child{
		margin-bottom: 0;
	}
	.Wdate.form-control[type=text]{
		background: #fff url(/public/plugin/datePicker/skin/datePicker.gif) no-repeat;
		height: 34px;
		border-color: #ccc;
		background-position: 98% center;
	}
	.radio-box{
		line-height: 34px;
	}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="mainContent">
<div class="choose-pintuan" id="div-type">
	<h3>选择创建一种拼团方式</h3>
	<p>通过发放优惠券提高用户参与度</p>
	<div class="pintuan-type" >
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groupType']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<div class="type-item" data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
">
			<?php if ($_smarty_tpl->tpl_vars['val']->value['type']==4) {?>
			<a href="/wxapp/group/addSectionGroup">
			<?php } else { ?>
			<a href="#">
			<?php }?>
				<div class="ticket ticket-<?php echo $_smarty_tpl->tpl_vars['val']->value['color'];?>
">
					<span><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</span>
				</div>
				<div class="right-txt">
					<h4><?php echo $_smarty_tpl->tpl_vars['val']->value['brief'];?>
</h4>
					<p><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>
</p>
				</div>
			</a>
		</div>
		<?php } ?>
	</div>
</div>
<div class="choose-pintuan"  id="div-add" style="display: none;">
	<form class="form-horizontal" id="activity-form"  enctype="multipart/form-data">
		<input type="hidden" id="hid_id" name="id" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_id'];?>
<?php } else { ?>0<?php }?>">
		<input type="hidden" id="type" name="type" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_type'];?>
<?php } else { ?>0<?php }?>" data-need="required" placeholder="请选择团购分类">
		<div style="overflow:hidden">
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">参团商品</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">拼团购封面</label>
						<div class="col-xs-9">
							<div>
								<img onclick="toUpload(this)"
									 data-limit="1"
									 data-width="750"
									 data-height="360"
									 data-dom-id="cover"
									 id="cover"
									 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_75_36.png"
									 placeholder="请上传拼图购封面图"
									 data-need="required"
									 src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_75_36.png<?php }?>"  style="display:inline-block;width:200px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
								<a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="360" data-dom-id="cover">修改（尺寸：750*360）</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">参团商品</label>
						<div class="col-xs-6">
							<select class="form-control selectpicker chosen-select" id="g_id" name="g_id" onchange="changePrice()"  <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_g_id']) {?>disabled="disabled"<?php }?>  data-live-search="true"  data-need="required" data-placeholder="请选择参团商品">
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goodsList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
								<option data-price="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
" data-format='<?php echo $_smarty_tpl->tpl_vars['val']->value['g_format'];?>
' value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_g_id']==$_smarty_tpl->tpl_vars['val']->value['g_id']) {?>selected="selected"<?php }?>><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>
</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-xs-3" style="margin-top: 7px">原价：<span id="ori-price"><?php if ($_smarty_tpl->tpl_vars['goods']->value) {?><?php echo $_smarty_tpl->tpl_vars['goods']->value['g_price'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['goodsList']->value[0]['g_price'];?>
<?php }?></span></div>
					</div>
					<div class="form-group">
							<label for="price" class="col-xs-3 control-label">是否允许单独购买</label>
							<div class="col-xs-9">
								<div class="radio-box">
									<span data-val="1">
										<input type="radio" name="single" value="1" id="single1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_single_buy']==1) {?>checked<?php } elseif (empty($_smarty_tpl->tpl_vars['row']->value)) {?>checked<?php }?>>
										<label for="single1">允许</label>
									</span>
									<span data-val="0">
										<input type="radio" name="single" value="0" id="single0" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_single_buy']==0) {?>checked<?php }?>>
										<label for="single0">不允许</label>
									</span>
								</div>
							</div>
					</div>
					<div class="form-group tuanzhang">
						<label for="price" class="col-xs-3 control-label">单人限购</label>
						<div class="col-xs-9">
							<input type="number" class="form-control " id="limit" name="limit"  data-need="" placeholder="请填写单人限购数量, 0表示不限购" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_limit'];?>
<?php }?>">
						</div>
					</div>
					<div class="form-group tuanzhang">
						<label for="price" class="col-xs-3 control-label">排序权重</label>
						<div class="col-xs-9">
							<input type="number" class="form-control " id="sort" name="sort"  data-need="" placeholder="请填写排序权重" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_sort'];?>
<?php } else { ?>0<?php }?>">
						</div>
					</div>
					<?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">浏览量</label>
						<div class="col-xs-9">
							<input type="number" class="form-control" id="viewNum" name="viewNum" placeholder="请填写浏览量" data-need="" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_view_num'];?>
<?php } else { ?>0<?php }?>" style="width: 160px;">
						</div>
					</div>

					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">浏览量显示</label>
						<div class="col-xs-9">
							<label style="padding: 4px 0;margin: 0;">
								<input name="viewNumShow" class="ace ace-switch ace-switch-5" id="viewNumShow" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_view_num_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
								<span class="lbl"></span>
							</label>
						</div>
					</div>
					<?php }?>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">活动规则</label>
						<div class="col-xs-9">
							<textarea id="activity_rule" class="form-control " rows="3" name="activity_rule" data-need="" placeholder="请填写活动规则"><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_act_rule'];?>
<?php }?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">价格设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group tuanzhang" style="display: none">
						<label for="price" class="col-xs-3 control-label">团长优惠价</label>
						<div class="col-xs-9">
							<input type="number" class="form-control " id="tz_price" name="tz_price"  data-need="" placeholder="请填写团长优惠价格" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_tz_price']) {?>disabled="disabled"<?php }?> value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_tz_price'];?>
<?php }?>">
						</div>
					</div>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">团购价格</label>
						<div class="col-xs-9">
							<input type="number" class="form-control " id="price" name="price" placeholder="请填写团购价格" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_price']) {?>disabled="disabled"<?php }?> data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_price'];?>
<?php }?>">
						</div>
					</div>
				</div>
			</div>

			<div class="ptinfo-fenlei clearfix" id="format-edit-box" <?php if ($_smarty_tpl->tpl_vars['row']->value['g_format']) {?>style="display:block"<?php } else { ?>style="display:none"<?php }?>>
				<div class="col-xs-2">
					<span class="fenlei-name">规格价格设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<table class="table" border="0" cellpadding="0" cellspacing="0" style="margin-left: 55px;border: 0;width: 92%">
						<thead>
							<tr>
								<th class="center">规格</th>
								<th class="center" id="tz-title">团长优惠价</th>
								<th class="center">团购价格</th>
							</tr>
						</thead>
						<tbody id="fomat-group-box">
						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['row']->value['g_format']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
						<tr data-id="<?php echo $_smarty_tpl->tpl_vars['value']->value['gfid'];?>
">
							<td class="center"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</td>
							<td class="center" <?php if ($_smarty_tpl->tpl_vars['row']->value['gb_type']!=3) {?>style="display:none"<?php }?>>
								<div class="form-group tuanzhang">
									<div class="col-xs-12">
										<input type="number" class="form-control " id="tz_price" name="tz_price"  data-need="" placeholder="请填写团长优惠价格" <?php if ($_smarty_tpl->tpl_vars['row']->value) {?>disabled="disabled"<?php }?> value="<?php if ($_smarty_tpl->tpl_vars['value']->value) {?><?php echo $_smarty_tpl->tpl_vars['value']->value['tzprice'];?>
<?php }?>">
									</div>
								</div>
							</td>
							<td class="center">
								<div class="form-group">

									<div class="col-xs-12">
										<input type="number" class="form-control " id="price" name="price" placeholder="请填写团购价格" <?php if ($_smarty_tpl->tpl_vars['row']->value) {?>disabled="disabled"<?php }?> data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['value']->value) {?><?php echo $_smarty_tpl->tpl_vars['value']->value['price'];?>
<?php }?>">
									</div>
								</div>
							</td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">人数设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">单个团要求参团人数</label>
						<div class="col-xs-9">
							<input type="number" class="form-control need-desc" id="total" name="total" placeholder="请填写参团人数，至少2人" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_total']) {?>disabled="disabled"<?php }?> data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_total'];?>
<?php }?>"  oninput="this.value=this.value.replace(/\D/g,'')">
						</div>
					</div>
					<div class="form-group" style="display: none;">
						<label for="price" class="col-xs-3 control-label">所有拼团共计参与人数</label>
						<div class="col-xs-9">
							<input type="number" class="form-control need-desc" id="joined" name="joined" placeholder="本活动总计参与人数"  data-need="" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_joined'];?>
<?php }?>"  oninput="this.value=this.value.replace(/\D/g,'')">
						</div>
					</div>

					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">凑团显示个数</label>
						<div class="col-xs-9">
							<input type="text" class="form-control need-desc" id="show_num" name="show_num" placeholder="请填写凑团显示个数" data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_show_num'];?>
<?php }?>"  oninput="this.value=this.value.replace(/\D/g,'')">
							<span style="color: red">注：凑团个数指小程序端待成团数量显示，方便其他用户之间加入组团</span>
						</div>
					</div>

				</div>
			</div>
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">时间设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="start" class="col-xs-3 control-label">开始时间</label>
						<div class="col-xs-9">
							<input id="startTime" name="startTime" autocomplete="off" type="text" placeholder="请选择开始时间" class="Wdate form-control" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_start_time']) {?>disabled="disabled"<?php }?> value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['gb_start_time']);?>
<?php }?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\');}'})">
							<!-- <div class="col-xs-6">
								<input type="text" class="form-control" id="start" name="start" placeholder="请选择开始日期" data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['row']->value['gb_start_time']);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['now']->value;?>
<?php }?>">
							</div>
							<div class="col-xs-6">
								<div class="input-group bootstrap-timepicker">
									<input id="startTime" name="startTime" type="text" class="form-control" data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('H:i:s',$_smarty_tpl->tpl_vars['row']->value['gb_start_time']);?>
<?php }?>" placeholder="请选择开始时间" />
									<span class="input-group-addon">
										<i class="icon-time bigger-110"></i>
									</span>
								</div>
							</div> -->
						</div>
					</div>
					<div class="form-group">
						<label for="end" class="col-xs-3 control-label">结束时间</label>
						<div class="col-xs-9">
							<input id="endTime" name="endTime" autocomplete="off"  type="text" placeholder="请选择结束时间" class="Wdate form-control" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_end_time']) {?>disabled="disabled"<?php }?> value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['gb_end_time']);?>
<?php }?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\');}'})">
							<!-- <div class="col-xs-6">
								<input type="text" class="form-control" id="end" name="end" placeholder="请选择结束时间" data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['row']->value['gb_end_time']);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['now']->value;?>
<?php }?>">
							</div>
							<div class="col-xs-6">
								<div class="input-group bootstrap-timepicker">
									<input id="endTime" name="endTime" type="text" class="form-control" data-need="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('H:i:s',$_smarty_tpl->tpl_vars['row']->value['gb_end_time']);?>
<?php }?>" placeholder="请选择结束时间"/>
									<span class="input-group-addon">
										<i class="icon-time bigger-110"></i>
									</span>
								</div>
							</div> -->
						</div>
					</div>    
				</div>
			</div>
			<div class="ptinfo-fenlei clearfix putong" style="display: none;">
				<div class="col-xs-2">
					<span class="fenlei-name">其它设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group putong" style="display: none;" id="div-auto">
						<label for="price" class="col-xs-3 control-label">是否自动成团</label>
						<div class="col-xs-9">
							<div class="radio-box">
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['yesNo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
								<span data-val="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
									<input type="radio" name="auto" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" id="auto<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_start_time']<time()) {?>disabled="disabled"<?php }?>  <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_use_auto']==$_smarty_tpl->tpl_vars['key']->value) {?>checked<?php } elseif (empty($_smarty_tpl->tpl_vars['row']->value)&&$_smarty_tpl->tpl_vars['key']->value==1) {?>checked<?php }?>>
									<label for="auto<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</label>
								</span>
								<?php } ?>
							</div>
							<span style="color: red">注：设置为允许自动成团时，在拼团时间结束时未成团的订单系统会自动成团</span>
						</div>
					</div>
				</div>
			</div>
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">分享设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">分享图片</label>
						<div class="col-xs-9">
							<img onclick="toUpload(this)"
								 data-limit="1"
								 data-width="645"
								 data-height="500"
								 data-dom-id="share_image"
								 id="share_image"
								 placeholder="请上传分享图片"
								 data-need="required"
								 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_45_45.png"
								 src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['gb_share_image']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_share_image'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>"  style="display:inline-block;width:100px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
							<a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="645" data-height="500" data-dom-id="share_image">修改<small>(尺寸：645*500)</small></a>
						</div>
					</div>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">分享标题</label>
						<div class="col-xs-9">
							<input type="text" class="form-control need-desc" id="share_title" name="share_title" data-need="" placeholder="若不填写，则取商品标题" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['gb_share_title'];?>
<?php }?>" >
						</div>
					</div>
				</div>
			</div>
			<div class="form-group col-xs-12" style="text-align:center">
				<button type="button" class="btn btn-primary btn-save"> 保 存 </button>
			</div>
		</div>
	</form>
</div><!-- /row -->
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<!-- <script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script> -->

<script type="text/javascript">
	var selectType = '<?php echo $_smarty_tpl->tpl_vars['row']->value['gb_type'];?>
';
	$(function(){
		// 搜索选择下拉框
		$(".chosen-select").chosen({
			no_results_text: "没有找到",
			search_contains: true
		});

		if('<?php echo $_smarty_tpl->tpl_vars['isAdd']->value;?>
' == 'edit'){
			deal_show_hide_by_type('<?php echo $_smarty_tpl->tpl_vars['row']->value['gb_type'];?>
')
		}
	});
	$('.type-item').on('click',function(){
		var type = $(this).data('type');
		if(type){
			deal_show_hide_by_type(type);
		}
	});
	$('.need-desc').on('focus',function(){
		var desc = $(this).data('desc');
		if(desc){
			var id   = $(this).attr('id');
			layer.tips(desc, '#'+id, {
				tips: [2, '#78BA32'],
				time: 4000
			});
		}
	});

	function deal_show_hide_by_type(type){
        selectType = type;
		$('#type').val(type);
		$('#div-type').hide();
		$('#div-add').show();
		var type_val = parseInt(type);
		switch (type_val){
			case 1 :
                $('#tz-title').hide();
                $('.putong').show();
				break;
			case 2 :
                $('#tz-title').hide();
				$('.choujiang').show();
				break;
			case 3 :
                $('#tz-title').show();
                $('.tuanzhang').show();
				break;
		}
		<?php if (!$_smarty_tpl->tpl_vars['row']->value) {?>
			changePrice();
		<?php }?>
	}
	/*初始化日期选择器*/
	/*$('#start').datepicker({autoclose:true}).next().on(ace.click_event, function(){
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
	});*/
	$('.btn-save').on('click',function(){
		var field = new Array('type','g_id','price','total','joined','show_num','start','startTime','end','endTime','share_title','share_desc','activity_rule', 'limit');
		var data  = { };
		for(var i=0; i<field.length; i++){
			var temp = $('#'+field[i]).val();
			if(temp){
				data[field[i]] = temp
			}else{
				var req = $('#'+field[i]).attr('data-need');
				if(req == 'required'){
				    console.log(field[i]);
					var msg = $('#'+field[i]).attr('placeholder');
					layer.msg(msg);
					return false;
				}
			}
		}
		data.sort      =  $('input[name="sort"]').val();
		data.use_auto  =  $('input[name="auto"]:checked').val();
		data.sub_limit =  $('input[name="limit"]:checked').val();
		data.single_buy =  $('input[name="single"]:checked').val();
		data.id 	   =  $('#hid_id').val();
		data.tz_price  =  $('#tz_price').val();
        data.viewNum   =  $('#viewNum').val();
        data.viewNumShow =  $('#viewNumShow:checked').val()=='on'?1:0;
		var imgField   =  new Array('cover','share_image');
		for(var j=0; j<imgField.length; j++){
			var imgTemp = $('#'+imgField[j]).attr('src');
			var df      = $('#'+imgField[j]).data('dfvalue');
			if(imgTemp && df != imgTemp){
				data[imgField[j]] = imgTemp
			}else{
                console.log(imgField[j]);
                errorTips(imgField[j]);
				return false;
			}
		}
		data.format = [];
        $('.format-item').each(function () {
            data.format.push({
                'id' : $(this).data('id'),
                'tzprice' : $(this).find('.format_tz_price').val(),
                'price' : $(this).find('.format_price').val()
            });
        });
		console.log(data);
		if(data.total <= 1){
			layer.msg('参团人数必需大于1个人');
			return false;
		}
		layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
           	var index = layer.load(1, {
				shade: [0.1,'#fff'] //0.1透明度的白色背景
			});
			$.ajax({
				'type'  : 'post',
				'url'   : '/wxapp/group/saveGroup',
				'data'  : data,
				'dataType' : 'json',
				'success'  : function(ret){
					layer.close(index);
					layer.msg(ret.em);
					if(ret.ec == 200){
						window.location.href='/wxapp/group/index';
					}
				}
			});
 
        });
		
	});

    function changePrice(){
        $('#ori-price').text($(".chosen-select option:selected").attr("data-price"));
        var format = JSON.parse($(".chosen-select option:selected").attr("data-format"));
        var html = '';
        for(var i in format){
            html += `<tr data-id="${format[i]['gfid']}" class="format-item">
						<td class="center">${format[i]['name']}</td>
						<td class="center" style="display:${selectType == 3?'block':'none'}">
							<div class="form-group tuanzhang">
								<div class="col-xs-12">
									<input type="number" class="form-control format_tz_price" name="format_tz_price"  data-need="" placeholder="请填写团长优惠价格" value="">
								</div>
							</div>
						</td>
						<td class="center">
							<div class="form-group">

								<div class="col-xs-12">
									<input type="number" class="form-control format_price" name="format_price" placeholder="请填写团购价格" data-need="required" value="">
								</div>
							</div>
						</td>
					</tr>`;
        }
        if(html){
            $('#format-edit-box').show();
        }else{
            $('#format-edit-box').hide();
        }
        $('#fomat-group-box').html(html);
    }


    function errorTips(id){
		var req = $('#'+id).data('need');
		if(req == 'required'){
			var msg = $('#'+id).attr('placeholder');
			layer.msg(msg);
		}
	}
	function deal_select_img(allSrc){
		if(allSrc){
			$('#'+nowId).attr('src',allSrc[0]);
		}
	}
</script>

<?php }} ?>

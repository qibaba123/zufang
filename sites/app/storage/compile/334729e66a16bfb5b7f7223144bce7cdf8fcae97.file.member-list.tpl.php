<?php /* Smarty version Smarty-3.1.17, created on 2020-03-30 22:40:18
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/member-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6526168995e4df8c0a37b77-56710915%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '334729e66a16bfb5b7f7223144bce7cdf8fcae97' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/member-list.tpl',
      1 => 1585579216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6526168995e4df8c0a37b77-56710915',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df8c0b04949_94143277',
  'variables' => 
  array (
    'mLevel' => 0,
    'key' => 0,
    'val' => 0,
    'curr_shop' => 0,
    'statInfo' => 0,
    'type' => 0,
    'nickname' => 0,
    'mid' => 0,
    'mobile' => 0,
    'remark' => 0,
    'choseLink' => 0,
    'threeLevel' => 0,
    'list' => 0,
    'level' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df8c0b04949_94143277')) {function content_5e4df8c0b04949_94143277($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<style>
    .form-group-box { overflow: auto; }
    .form-group-box .form-group { width: 260px; margin-right: 10px; float: left; }
    .table.table-avatar tbody>tr>td { line-height: 30px; }
    .fixed-table-box .table thead>tr>th, .fixed-table-body .table tbody>tr>td { text-align: center; }
    .member-set .form-group { margin-right: 0; margin-left: 0; width: 200px; display: table-cell; vertical-align: middle; }

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
        width: 25%;
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
<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span></span>
        <select id="member-grade" name="jiaohuo">
            <?php if ($_smarty_tpl->tpl_vars['mLevel']->value) {?>
                <option value="0">请选择等级</option>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['mLevel']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
            <?php } ?>
            <?php } else { ?>
                <option value="0">尚未添加等级</option>
            <?php }?>
        </select>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn ui-btn-primary js-save" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<!--转移会员下级-->
<div class="ui-popover ui-member-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center;margin-bottom: 6px;">将所有下级会员转移至新选择会员下</span>
        <div class="member-set" style="display: table;">
        <?php echo $_smarty_tpl->getSubTemplate ("../layer/ajax-select-input-single.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <input type="hidden" id="hid_mid" value="0">
         <input type="hidden" id="nickname" >
            <div style="text-align: center;padding: 3px 0 3px 5px;display: table-cell;vertical-align: middle;">
            <a class="ui-btn ui-btn-primary my-ui-btn save-transfer-member" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<!--转移会员下级结束-->
<div class="ui-popover ui-popover-time left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span></span>
        <input type="text" id="endDate" style="margin:0">
        <input type="hidden" id="hid_dateid" value="0">
        <a class="ui-btn ui-btn-primary js-save-date" href="javascript:;" onclick="saveDate(this)">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent">
    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_empty_membership']==0) {?>
    <div class="alert alert-block alert-warning" style="line-height: 20px;">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        清空会员关系将会把所有会员上下级关系、上下级数量、分销佣金全部清空，该操作仅能操作一次且会员总人数少于50人时才能使用，请谨慎使用
        <br/>
   </div>
    <div class="page-header" style="overflow:hidden">
        <div class="col-sm-1">
            <a class="btn btn-green btn-sm btn-deleted" href="javascript:;">
                <i class="bigger-40"></i> 清空会员关系
            </a>
        </div>
    </div>
    <?php }?>
    <!-- 汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">分销会员<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">最高级会员<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['highestTotal'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计销售<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['sale'];?>
</span>
                <span class="unit">元</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计返佣<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['deduct'];?>
</span>
                <span class="unit">元</span>
            </div>
        </div>
    </div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/three/member" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <input type="hidden" name="type" value="<?php if ($_smarty_tpl->tpl_vars['type']->value) {?><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
<?php } else { ?>all<?php }?>">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
" placeholder="微信昵称">
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">会员编号</div>
                                <input type="text" class="form-control" name="mid"  value="<?php if ($_smarty_tpl->tpl_vars['mid']->value) {?><?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
<?php }?>" placeholder="编号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">手机号</div>
                                <input type="text" class="form-control" name="mobile"  value="<?php if ($_smarty_tpl->tpl_vars['mobile']->value) {?><?php echo $_smarty_tpl->tpl_vars['mobile']->value;?>
<?php }?>" placeholder="手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">备注</div>
                                <input type="text" class="form-control" name="remark"  value="<?php if ($_smarty_tpl->tpl_vars['remark']->value) {?><?php echo $_smarty_tpl->tpl_vars['remark']->value;?>
<?php }?>" placeholder="备注">
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
    <div class="choose-state">
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['choseLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['href'];?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['val']->value['key']) {?> class="active" <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
        <?php } ?>
        <!---
        <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;">
            <i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span>
        </button>
        -->
        <?php if ($_smarty_tpl->tpl_vars['type']->value=='highest') {?>
        <button class="pull-right btn btn-info btn-xs add-btn" style="margin-top: 5px;margin-right: 10px;"
                data-type="highest" data-title="添加最高级">
            添加最高级
        </button>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['type']->value=='refer') {?>
        <button class="pull-right btn btn-info btn-xs add-btn" style="margin-top: 5px;margin-right: 10px;"
                data-type="refer" data-title="添加官方推荐人">
            添加官方推荐人
        </button>
        <?php }?>
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
                                        <th>会员编号</th>
                                        <th>会员昵称</th>
                                        <th>分佣区域</th>
                                        <th>会员备注</th>
                                        <th>手机号</th>
                                        <th>分享码</th>
                                        <th>分享海报</th>
                                        <th>上级</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>">上二级</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>">上三级</th>
                                        <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==7163||$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']!=7224) {?>
                                        <th>会员等级</th>
                                        <?php }?>
                                        <th>销售总额</th>
                                        <th>返佣总额</th>
                                        <th>下级数量</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>">下二级数量</th>
                                        <th class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>">下三级数量</th>
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
                                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
">
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_show_id'];?>
</td>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['m_nickname']) {?>
	                                            <a href="#"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>

	                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['m_is_highest']==1) {?>
	                                            	(最高级) 
	                                            <?php }?>
	                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['m_is_refer']==1) {?>
	                                            	(官方推荐人)
	                                            <?php }?>
	                                            </a>
                                            <?php } else { ?>
                                            -
                                            <?php }?>
                                            <!--<?php if ($_smarty_tpl->tpl_vars['val']->value['m_is_highest']==1) {?>
                                            <span class="label label-sm label-success">
                                                最高级</span>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['m_is_refer']==1) {?>
                                            <span class="label label-sm label-info">
                                                官方推荐人</span>
                                            <?php }?>-->
                                        </td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['area'];?>
</td>
                                        <td><div style="white-space: normal;line-height:1.5;width:160px;"><?php echo $_smarty_tpl->tpl_vars['val']->value['m_remark'];?>
</div></td>
                                        <td><?php if ($_smarty_tpl->tpl_vars['val']->value['m_mobile']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['m_mobile'];?>
<?php } else { ?>无<?php }?></td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_invite_code'];?>
</td>
                                        <td id="td_share_img_<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
">
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['m_spread_image']) {?>
                                            <a href="javascript:;" class="btn btn-primary btn-xs btn-share-look" data-uid="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" data-img="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_spread_image'];?>
">查看海报</a>
                                            <?php } else { ?>
                                            <p>未生成海报</p>
                                            <a href="javascript:;" class="btn btn-primary btn-xs btn-share-create" data-uid="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
">创建海报</a>
                                            <?php }?>
                                        </td>
                                        <td><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_1f_id']])) {?>
                                            <a href="/wxapp/three/member?1f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_1f_id'];?>
">
                                                <?php if ($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_1f_id']]) {?><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_1f_id']];?>
<?php } else { ?>未知昵称:ID(<?php echo $_smarty_tpl->tpl_vars['val']->value['m_1f_id'];?>
)<?php }?>
                                            </a>
                                            <?php }?></td>
                                        <td  class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_2f_id']])) {?>
                                            <a href="/wxapp/three/member?2f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_2f_id'];?>
">
                                                <?php if ($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_2f_id']]) {?><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_2f_id']];?>
<?php } else { ?>未知昵称:ID(<?php echo $_smarty_tpl->tpl_vars['val']->value['m_2f_id'];?>
)<?php }?>
                                            </a>
                                            <?php }?></td>
                                        <td class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>"><?php if (isset($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_3f_id']])) {?>
                                            <a href="/wxapp/three/member?3f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_3f_id'];?>
">
                                                <?php if ($_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_3f_id']]) {?><?php echo $_smarty_tpl->tpl_vars['level']->value[$_smarty_tpl->tpl_vars['val']->value['m_3f_id']];?>
<?php } else { ?>未知昵称:ID(<?php echo $_smarty_tpl->tpl_vars['val']->value['m_3f_id'];?>
)<?php }?>
                                            </a>
                                            <?php }?></td>
                                        <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==7163||$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']!=7224) {?>
                                            <td><?php echo $_smarty_tpl->tpl_vars['mLevel']->value[$_smarty_tpl->tpl_vars['val']->value['m_level']];?>
</td>
                                        <?php }?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_sale_amount'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_deduct_amount'];?>
</td>
                                        <td>
                                        	<!--<?php echo $_smarty_tpl->tpl_vars['val']->value['total1'];?>
-->
	                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['total1']) {?>
	                                            <a href="/wxapp/three/member?1f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" title="查看下级会员"><?php echo $_smarty_tpl->tpl_vars['val']->value['total1'];?>
</a>
	                                        <?php } else { ?>
	                                        	<span><?php echo $_smarty_tpl->tpl_vars['val']->value['total1'];?>
</span>
	                                        <?php }?>                        
                                        </td>
                                        <td  class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<2) {?>hide<?php }?>">
                                        	<!--<?php echo $_smarty_tpl->tpl_vars['val']->value['total2'];?>
-->
	                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['total2']) {?>
	                                            <a href="/wxapp/three/member?2f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" title="查看下二级会员"><?php echo $_smarty_tpl->tpl_vars['val']->value['total2'];?>
</a>
	                                        <?php } else { ?>
	                                        	<span><?php echo $_smarty_tpl->tpl_vars['val']->value['total2'];?>
</span>
	                                        <?php }?> 	
                                        </td>
                                        <td  class="<?php if ($_smarty_tpl->tpl_vars['threeLevel']->value<3) {?>hide<?php }?>">
                                        	<!--<?php echo $_smarty_tpl->tpl_vars['val']->value['total3'];?>
-->
	                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['total3']) {?>
	                                           <!-- <a href="/wxapp/three/member?3f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" title="查看下三级会员" class="label label-sm label-success" >查看</a>-->
	                                        	<a href="/wxapp/three/member?3f_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" title="查看下三级会员"><?php echo $_smarty_tpl->tpl_vars['val']->value['total3'];?>
</a>
	                                        <?php } else { ?>
	                                        	<span><?php echo $_smarty_tpl->tpl_vars['val']->value['total3'];?>
</span>
	                                        <?php }?>                             
                                        </td>
                                        <td class="jg-line-color">
                                            <a href="/wxapp/three/daybook?mid=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
">佣金流水</a>
                                            <?php if ($_smarty_tpl->tpl_vars['type']->value=='refer') {?>
                                             - <a href="javascript:;" class="cel-refer" data-id=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
>取消官方推荐</a>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==7163||$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']!=7224) {?>
                                             - <a href="#" class="set-membergrade" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" data-level="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_level'];?>
">设会员</a>
                                            <?php }?>
                                            <!--<a href="#" class="transfer-member" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
" data-nickname="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
">转移下级</a>-->
                                            <?php if (!$_smarty_tpl->tpl_vars['type']->value||$_smarty_tpl->tpl_vars['type']->value=='all'||$_smarty_tpl->tpl_vars['type']->value=='highest') {?>
                                             - <a href="/wxapp/three/relation?mid=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
">设置分销关系</a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

                        </div>
                    </div>
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form><input type="hidden" id="hid_type" value="">
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">会员编号</span>
                            <input type="text" class="form-control" id="showID" aria-describedby="inputGroupSuccess1Status">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">推荐码(选填)</span>
                            <input oninput="this.value=this.value.replace(/[^\A-\Z0-9]/g,'')" class="form-control" id="code" placeholder="6位数字或大写字母组合,会员推荐码" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveReferBest">保存</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/member.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $('.add-btn').on('click',function(){
        var type = $(this).data('type');
        var title = $(this).data('title');
        $('#myModalLabel').html(title);
        $('#hid_type').val(type);
        $('#showID').val('');
        $('#code').val('');
        $('#myModal').modal('show')
    });

    $('.saveReferBest').on('click',function(){
        var type   = $('#hid_type').val();
        var showId = $('#showID').val();
        var code   = $('#code').val();
        /*if(code.length !=6 ){
            layer.msg('推荐码必须是6位数字和大写字母组合');
            return false;
        }*/

        if(showId && type){
            var data = {
                'type'      :  type,
                'showId'    : showId,
                'code'      : code
            };
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setReferBest',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });

   $('#myTab li').on('click', function() {
       var id = $(this).data('id');
       window.location.href='/wxapp/three/member?type='+id;
   });

   /*设置会员等级*/
    $('select').searchableSelect();
    $("#mainContent").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
            console.log(level);
           $('#member-grade').val(level);
        }
        $('#hid_mid').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#mainContent").offset().left)-160;
        var conTop = Math.round($("#mainContent").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-360,'top':top-conTop-96}).stop().show();
    });
    /**
     * 保存等级到期时间
     */
    $("#content-con").on('click', 'table td a.long_date', function(event) {
        var _this = $(this);
        var id  = _this.data('id');
        var end = _this.data('end');
        var curDate = _this.text();
        $("#endDate").val(curDate);
        $("#hid_dateid").val(id);

        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#mainContent").offset().left)-60;
        var conTop = Math.round($("#mainContent").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-time").css({'left':left-conLeft-445,'top':top-conTop-96}).stop().show();
    });

    $(".ui-popover").on('click', function(event) {
        event.stopPropagation();
    });
    $(".main-container").on('click', function(event) {
        optshide();
    });

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level>0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择用户等级');
        }

    });


    //取消官方推荐
    $('.cel-refer').on('click',function(){
        var id = $(this).data('id');
        var data  = {
            'id'    : id
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/cancelRefer',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+id).remove();
                    //optshide();
                }
            }
        });
    });
    $('.btn-share-look').on('click',function(){
        var id  = $(this).data('uid');
        var img = $(this).data('img');
        if(id && img){
            var html='<p class="text-center" style="height: 500px;width: 360px;"><img src="'+img+'" alt="宣传海报" style="width:100%; height:100%;" class="img-thumbnail"></p>';
            html  +='<p class="text-center"><button type="button" class="btn btn-danger btn-destroy" onclick="destroySpread('+id+')">销毁此海报</button></p>';
            layer.open({
                type: 1,
                title:'分享海报',
                top:-10,
                skin: 'layui-layer-demo', //样式类名
                closeBtn: 1, //不显示关闭按钮
                shift: 2,
                shadeClose: true, //开启遮罩关闭
                content: html
            });

        }
    });

    function destroySpread(id){
        if(id){
            var data  = {
                'id'    : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/destroySpread',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.closeAll();
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#td_share_img_'+id).text('未生成海报');
                    }
                }
            });
        }
    }


    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

        /*日期选择器*/
        $('#endDate').datepicker({autoclose:true}).next().on(ace.click_event, function(){
          // $(this).prev().focus();
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

    //转移会员下级
    $("#mainContent").on('click', 'table td a.transfer-member', function(event) {
        var id = $(this).data('id');
        var nickname = $(this).data('nickname');
        $('#hid_mid').val(id);
        $('#nickname').val(nickname);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#mainContent").offset().left)-160;
        var conTop = Math.round($("#mainContent").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-member-select").css({'left':left-conLeft-360,'top':top-conTop-96}).stop().show();
    });

    $(".ui-popover .save-transfer-member").on('click', function(event) {
        var targetMid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
        var pendMid = $('#hid_mid').val();
        var nickname = $('#nickname').val();
        var newNickname = $('#hid_nickname').val();
        console.log(newNickname);
        console.log(nickname);
        console.log(targetMid);
        console.log(pendMid);
        if(pendMid>0 && targetMid>0){
            event.preventDefault();
            var data  = {
                'pendMid'    : pendMid,
                'targetMid' : targetMid
            };
            layer.confirm('确定要将《'+nickname+'》的所有下级会员转移到《'+newNickname+'》名下吗？一旦转移将无法恢复', {
                btn: ['确定','取消'], //按钮
                title : '确认转移'
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/member/transferMember',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'  : function(ret){
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                            optshide();
                        }
                    }
                });
            }, function(){

            });
        }else{
            layer.msg('请选择转移到的用户');
        }

    });

    //创建海报
    $('.btn-share-create').on('click',function(){
        var mid  = $(this).data('uid');
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/three/threePostCreate',
            'data'  : {mid: mid},
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    });

    //取消官方推荐
    $('.btn-deleted').on('click',function(){
        console.log(123455);
        layer.confirm('你确定要清空会员关系吗？一旦清空将无法恢复', {
            btn: ['确定','取消'], //按钮
            title : '确认清空'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/three/emptyMemberShip',
                'data'  : { },
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        optshide();
                    }
                }
            });
        }, function(){

        });
    });
</script><?php }} ?>

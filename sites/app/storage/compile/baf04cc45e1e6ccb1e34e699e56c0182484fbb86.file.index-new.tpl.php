<?php /* Smarty version Smarty-3.1.17, created on 2020-04-01 18:39:05
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/index-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10802671305e846f49c6e008-82516237%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'baf04cc45e1e6ccb1e34e699e56c0182484fbb86' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/index-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10802671305e846f49c6e008-82516237',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'new_styles' => 0,
    'sys_notice' => 0,
    'menuType' => 0,
    'expireTip' => 0,
    'outinfo' => 0,
    'region_area' => 0,
    'appletCfg' => 0,
    'kind' => 0,
    'noticeList' => 0,
    'notice' => 0,
    'shortcut' => 0,
    'item' => 0,
    'curr_shop' => 0,
    'catelist' => 0,
    'manager' => 0,
    'from' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e846f49ceceb7_91585691',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e846f49ceceb7_91585691')) {function content_5e846f49ceceb7_91585691($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/css/index.css?8">
<!--
<link rel="stylesheet" href="/public/wxapp/wxappOverloadNew.css?1" />
-->
<style>
/*	div.navbar{z-index: 1!important;}*/
    .alert-yellow { color: #666; font-weight: normal; background-color: #FFF7CC; border-color: #FFEEBB; letter-spacing: 0.5px; margin:0 0 15px;border-radius:4px; font-size: 14px; /*font-weight: 600; font-family: "黑体"; */line-height: 1.8; border: none; padding:10px 15px; }
    .alert-yellow a { color: #38f; }
    .alert-yellow i { color: red; }
    .update-content { font-size: 13px; margin-left: 20px; }
    .base-wrap {overflow: unset;}
    .base-info .shop-name .icon-edit-box{color:#999;font-size:15px;top:-1px;}
	
	.base-info{margin-right:0px;border:none;box-shadow: 0 0 10px #EBEBEB;background-color:#fff;}
	.applet-helper-new{height:194px;box-shadow: 0 0 10px #EBEBEB;background-color:#fff;padding: 15px 20px;}
	.applet-helper-new .helper-code .little-code {height: 60px;width: 60px;border-radius: 10px;display: block;margin: 0 auto;}
	.applet-helper-new .helper-code .big-code {height: 300px;width: 300px;position: absolute;left: 50%;top: 60px;margin-left: -150px;display: none;border: 1px solid #ddd;box-shadow: 2px 2px 10px #ccc;}
	.applet-helper-new .helper-title {font-size: 15px;font-weight: bold;padding: 10px 0;text-align: center;}
	.applet-helper-new .helper-intro {font-size: 13px;color: #999;line-height: 1.7;display: -webkit-box !important;overflow: hidden;text-overflow:ellipsis;word-break:break-all;-webkit-box-orient:vertical;-webkit-line-clamp:3;}
	.version-update{height: 194px;background-color: #fff;padding: 15px 20px;box-shadow: 0 0 10px #EBEBEB;}
	.version-update .helper-title{color:#5E5E5E;}
	.version-update .desc-list{color:#a8a8a8;font-size:12px;}
	.version-update .desc-list .update-item{line-height:26px;}
	.version-update .desc-list .update-item .desc{padding-right:10px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
	.version-update .desc-list .time{color:#DFDFDF;}
	.flex-wrap {display: flex;}
	.flex-con {flex: 1; }
    .weixin-notice {height:50px; margin-top: 4px;background-color: #fff;padding: 8px 20px;box-shadow: 0 0 10px #EBEBEB;}
    .weixin-notice img{height: 100%;display: inline-block;position: relative;top: -16px;border-radius: 4px;margin-right: 8px;}
    .weixin-notice .notice-desc{display:inline-block;width: 78%;}
    .weixin-notice .notice-desc .title{font-size: 14px;color: #666;}
    .weixin-notice .notice-desc .desc{font-size: 12px;color: #a8a8a8;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}

    .base-info .btn-wrap{text-align: right;}
	.base-info .btn-wrap .infor-btn{font-size:12px;color:#118BFB;padding:4px 10px;border-radius:4px;border:1px solid #118BFB;margin-left:10px;}
	.base-info .btn-wrap .infor-btn.active{background-color:#118BFB;color:#fff;}
	.base-info .btn-wrap .infor-btn:hover{background-color:#118BFB;color:#fff;}
	
	.tool-wrap{background-color:#fff;padding:0 20px;}
	.tool-wrap .tool-list-new li{height:82px;line-height:82px;margin-bottom:16px;}
	.tool-wrap .tool-list-new .img-box{width:82px;height:82px;background-color:#EFF2FC;}
	.tool-wrap .tool-list-new .img-box img{display: block;width:100%;height:100%;}
	.tool-list-new .tool-item {padding:0;background-color:#F7F8FC;line-height:82px;box-shadow: inherit;}
	.tool-list-new .tool-item .desc{height:82px;color:#666;font-size:14px;text-align:center;background-color:#F7F8FC;}
	.service-list .service-item-new{border:none;margin-bottom:15px;height:40px;}
	.service-list .service-item-new img{width:40px;height:40px;vertical-align: middle;margin-right:12px;}
	.service-list .service-item-new p{color:#666;font-size:14px;line-height:40px;}
	@media (min-width: 1200px){
		.applet-version,.applet-helper-wrap{
		    padding-left:0;
		}
	}
	@media (min-width: 768px) and (max-width: 1200px){
		.base-info-wrap{
		    margin-bottom:10px;
		}
		.applet-helper-wrap{
			padding-left:0;
			padding-right:12px;
		}
	}
	@media only screen and (max-width: 991px){
		div.navbar{margin-left:0;}
	}
	@media (max-width: 768px){
		.base-info-wrap,.applet-helper-wrap{
		    margin-bottom:10px;
		}
		.applet-helper-wrap{
			padding:0;
		}
	}
    #breadcrumbs{
        display: none;
    }
</style>
<?php echo $_smarty_tpl->tpl_vars['new_styles']->value;?>

<?php if ($_smarty_tpl->tpl_vars['sys_notice']->value&&isset($_smarty_tpl->tpl_vars['sys_notice']->value[0])) {?>
<input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['menuType']->value;?>
'>
	<?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','qq'))) {?>
	<div class="alert alert-block alert-yellow" style="margin-bottom: 0;">
	    <button type="button" class="close" data-dismiss="alert">
	        <i class="icon-remove"></i>
	    </button>
	    <i class="icon-exclamation-sign"></i>
        <?php if ($_smarty_tpl->tpl_vars['expireTip']->value&&isset($_smarty_tpl->tpl_vars['expireTip']->value)) {?>
        <span style="font-size: 22px;color: red;">
        <?php echo $_smarty_tpl->tpl_vars['expireTip']->value;?>

        </span>
        <?php } else { ?>
	    [公告] (版本号 <?php echo $_smarty_tpl->tpl_vars['sys_notice']->value[0]['sn_version'];?>
) <?php echo $_smarty_tpl->tpl_vars['sys_notice']->value[0]['sn_title'];?>

	    <a target="_blank" href="/wxapp/index/noticeList">历史更新</a>
	    <?php echo $_smarty_tpl->tpl_vars['sys_notice']->value[0]['sn_content'];?>

	    <!--<div class="update-content">
	        <?php echo $_smarty_tpl->tpl_vars['sys_notice']->value[0]['sn_content'];?>

	    </div>-->
        <?php }?>
	</div>
	<?php }?>
<?php }?>

<div class="index-wrap">
    <div class="base-wrap row">
    
		<!--小程序数据助手一块存在时 applet-version col-lg-6 col-md-12 col-sm-12 col-xs-12-->
	    <!--小程序数据助手一块不存在时 applet-version col-lg-9 col-md-8 col-sm-8 col-xs-12-->
		<div class="base-info-wrap <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='wxapp') {?>col-lg-6 col-md-12 col-sm-12 col-xs-12<?php } elseif (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp'))) {?>col-xs-12<?php } else { ?>col-lg-9 col-md-8 col-sm-8 col-xs-12<?php }?>">
			<div class="base-info">
	            <div class="" style="position: relative;">
	                <div class="">
	                    <h3>基本信息</h3>
	                    <div class="shop-name">
	                        <h4 class="name">店铺名称：<span><?php echo $_smarty_tpl->tpl_vars['outinfo']->value['sname'];?>
</span></h4>
	                        <?php if ($_smarty_tpl->tpl_vars['region_area']->value!=1) {?>
	                        <span class="icon-edit-box" onclick="modifyShopName(this, event)">修改<i class="icon-edit"></i></span>&nbsp;&nbsp;&nbsp;
	                        &nbsp;&nbsp;&nbsp;
							<?php }?>
	                    </div>
	                    <div class="kt-time">
	                    	<span>开通时间：<?php echo $_smarty_tpl->tpl_vars['outinfo']->value['open_time'];?>
</span>
	                    	<span style="margin-left:10px;">到期时间：<?php echo $_smarty_tpl->tpl_vars['outinfo']->value['expire_time'];?>
</span>
	                    </div>
	                    <div class="kt-time">
	                    	<span>当前版本:<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_version'];?>
</span>
	                    	<span style="color:#118BFB;font-size:12px;">(最新版本<?php echo $_smarty_tpl->tpl_vars['sys_notice']->value[0]['sn_version'];?>
)</span>
	                    </div>
	                    <div class="btn-wrap">
	                    	<a href="javascript:void(0)" data-xid="<?php echo $_smarty_tpl->tpl_vars['outinfo']->value['curr_type'];?>
" class="infor-btn xufei-link js-buy-btn active">续费</a>
                            <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='aliapp') {?>
	                    	<a href="/wxapp/setup/code"class="infor-btn">升级版本</a>
                            <?php }?>
	                    	<?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','qq'))) {?>
	                    	<a href="/wxapp/index/tplImg/?id=<?php echo $_smarty_tpl->tpl_vars['kind']->value;?>
" class="infor-btn" target="_blank">功能导图</a>
	                    	<?php }?>
	                    </div>

	                </div>
	                <?php if ($_smarty_tpl->tpl_vars['menuType']->value&&$_smarty_tpl->tpl_vars['menuType']->value=='wxapp') {?>
	                <?php if ($_smarty_tpl->tpl_vars['region_area']->value!=1) {?>
	                <div class="activity link-setting" style="position: absolute;top:5px;right: 0;">
	                    <span class='tg-list-item' style="font-size: 16px;font-weight: bold;">
	                            关注公众号
	                         <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus()" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_follow_open']) {?>checked<?php }?> >
	                         <label class='tgl-btn' for='audit_status' style="display: inline-block;"></label>
	                    </span>
	                </div>
	                <?php }?>
	                <?php }?>
	            </div>
	        </div>
		</div>
		<!--小程序数据助手一块存在时 applet-version col-lg-6 col-md-12 col-sm-12 col-xs-12-->
	    <!--小程序数据助手一块不存在时 applet-version col-lg-3 col-md-4 col-sm-4 col-xs-12-->
	   	<?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','qq'))) {?>
        <div class="applet-version <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='wxapp') {?>col-lg-6 col-md-12 col-sm-12 col-xs-12<?php } else { ?>col-lg-3 col-md-4 col-sm-4 col-xs-12<?php }?>">
        	<?php if ($_smarty_tpl->tpl_vars['menuType']->value&&$_smarty_tpl->tpl_vars['menuType']->value=='wxapp') {?>
	        <div class="applet-helper-wrap col-lg-6 col-md-6 col-sm-6 col-xs-12">
	        	<div class="applet-helper-new">
		            <div class="helper-code">
		                <img src="/public/wxapp/images/applet-data-code.jpg" class="little-code" alt="数据统计小程序二维码">
		                <img src="/public/wxapp/images/applet-data-code.jpg" class="big-code" alt="数据统计小程序二维码">
		            </div>
		            <div class="helper-title">小程序数据助手</div>
		            <div class="helper-intro">微信公众平台发布的官方小程序，帮助相关开发和运营人员查看自身小程序的运营数据，扫描下面小程序码即可体验。</div>
		        </div>
	        </div>
	        <?php }?>
	        <!--小程序数据助手一块存在时 version-update col-lg-6 col-md-6 col-sm-6 col-xs-12-->
	        <!--小程序数据助手一块不存在时 version-update-->
	        <div class="version-update <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='wxapp') {?>col-lg-6 col-md-6 col-sm-6 col-xs-12<?php }?>">
			    <div class="helper-title">版本更新</div>
			    <div class="desc-list">
                    <?php  $_smarty_tpl->tpl_vars['notice'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['notice']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['noticeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['notice']->key => $_smarty_tpl->tpl_vars['notice']->value) {
$_smarty_tpl->tpl_vars['notice']->_loop = true;
?>
			    	<div class="update-item flex-wrap">
			    		<div class="desc flex-con">[更新](版本号 <?php echo $_smarty_tpl->tpl_vars['notice']->value['sn_version'];?>
)<?php echo $_smarty_tpl->tpl_vars['notice']->value['sn_title'];?>
</div>
			    		<div class="time"><?php echo date('m/d',$_smarty_tpl->tpl_vars['notice']->value['sn_create_time']);?>
</div>
			    	</div>
                    <?php } ?>
			    </div>
			</div>
            <!--<div id="weixin-notice-tip" class="weixin-notice <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='wxapp') {?>col-lg-6 col-md-6 col-sm-6 col-xs-12<?php }?>">
                <img src="/public/wxapp/setup/images/qspt.png" alt="">
                <div class="notice-desc">
                    <div class="title">企商平台公众号</div>
                    <div class="desc">微信扫码关注公众号获取最新消息通知</div>
                </div>
            </div>-->
        </div>
        <?php }?>
    </div>
    <!--
     <div class="data-statistics">
        <div class="data-title">小程序数据助手<span>微信公众平台发布的官方小程序，帮助相关开发和运营人员查看自身小程序的运营数据，扫描下面小程序码即可体验。</span></div>
        <div class="data-applet-code">
            <img src="/public/wxapp/images/applet-data-code.jpg" alt="数据统计小程序二维码">
            <p>小程序数据助手二维码</p>
        </div>
    </div>
    -->
    <div class="tool-wrap">
        <h3 class="title-name">常用工具</h3>
        <ul class="tool-list-new row">
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['shortcut']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp'))&&$_smarty_tpl->tpl_vars['item']->value['name']=='广告位配置') {?><?php continue 1?><?php }?>
            <li class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                <a href="/wxapp<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
" class="tool-item">
                    <div class="flex-wrap">
                    	<div class="img-box">
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['index-icon']) {?>
                        <img src="/public/wxapp/index-icon<?php echo $_smarty_tpl->tpl_vars['item']->value['index-icon'];?>
" alt="图标" />
                            <?php } else { ?>
                        <img src="/public/wxapp/images/icon_index_home.png" alt="图标" />
                            <?php }?>
                    	</div>
                    	<div class="desc flex-con">
                    		<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
-<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

                    	</div>
                    </div>
                    <!--<p><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</p>
                    <h4><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</h4>-->
                </a>
            </li>
            <?php } ?>

        </ul>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==5655) {?>
    <div class="tool-wrap" style="margin-top:20px;padding-top:15px;">
        <h3 class="title-name">更多服务</h3>
        <ul class="service-list row">
            <li class="service-item-new col-lg-2 col-md-4 col-sm-4 col-xs-6">
                <a href="/wxapp/currency/sslList" class="hyfa-item">
                <a href="#" class="hyfa-item increment-service">
                	<div class="flex-wrap">
                		<img src="/public/wxapp/images/service/icon_ssl.png" alt="ssl证书">
                    	<p>ssl证书</p>
                	</div>
                </a>
            </li>
            <li class="service-item-new col-lg-2 col-md-4 col-sm-4 col-xs-6">
                <a href="/wxapp/plugin/vrOrderList" class="hyfa-item">
                <a href="#" class="hyfa-item increment-service">
                	<div class="flex-wrap">
                		<img src="/public/wxapp/images/service/icon_vr_new.png" alt="VR全景拍摄">
                    	<p>VR全景拍摄</p>
                	</div>
                </a>
            </li>
        </ul>
    </div>
    <?php }?>
    <!--
    <div class="hyfa-wrap">
        <h3 class="title-name">行业方案 <a href="/wxapp/guide/index" class="pull-right">切换类型</a></h3>
        <ul class="hyfa-list">
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['catelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <li class="<?php if ($_smarty_tpl->tpl_vars['item']->value['used']) {?>used<?php }?>">
                <p class="no-used-txt">未启用</p>
                <a href="#" class="hyfa-item">
                    <img src="/public/wxapp/guide/images/<?php echo $_smarty_tpl->tpl_vars['item']->value['logo'];?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
">
                    <p><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</p>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
    -->
</div>
<div class="modal fade" id="taocanBuyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="cooperateTitle"><?php echo $_smarty_tpl->tpl_vars['outinfo']->value['curr_wxapp']['name'];?>
小程序行业模板续费</h4>
            </div>
            <div class="modal-body">
                <div class="nowbuy-con">
                    <div class="zent-dialog-body clearfix">
                        <div class="pay-info" style="margin-bottom: 5px;">
                            <dl>
                                <dt>应用名称：</dt>
                                <dd id="product-name"><?php echo $_smarty_tpl->tpl_vars['outinfo']->value['curr_wxapp']['name'];?>
</dd>
                            </dl>
                            <dl>
                                <dt>应用简介：</dt>
                                <dd id="product-brief"><?php echo $_smarty_tpl->tpl_vars['outinfo']->value['curr_wxapp']['brief'];?>
</dd>
                            </dl>
                            <dl>
                                <dt>生效时间：</dt>
                                <dd>支付成功后，服务时间将叠加</dd>
                            </dl>
                            <dl>
                                <dt>应用价格：</dt>
                                <dd><span class="money" id="produce-price"><?php echo $_smarty_tpl->tpl_vars['outinfo']->value['curr_wxapp']['priced'];?>
</span></dd>
                            </dl>
                        </div>
                        <div class="ui-nav clearfix">
                            <ul class="pull-left">
                                <li class="pay-way-nav js-online-pay active">
                                    <a href="javascript:;">微信扫码支付</a>
                                </li>
                                <li class="pay-way-nav js-offline-pay">
                                    <a href="javascript:;">支付宝扫码支付</a>
                                </li>
                            </ul>
                        </div>
                        <div class="online-pay-content" style="display: block;">
                            <div class="zent-alert">
                                <span class="red">提醒：</span>支付成功后，服务立即开通
                            </div>
                            <div class="pay-qrcode image-code">
                                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
                            </div>
                            <div class="weixin-btn">
                                <p>微信扫码支付，成功后服务立即开通</p>
                                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
                            </div>
                        </div>
                        <div class="online-pay-content" style="display: none;">
                            <div class="zent-alert">
                                <span class="red">提醒：</span>支付成功后，服务立即开通
                            </div>
                            <div class="pay-qrcode image-code">
                                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
                            </div>
                            <div class="weixin-btn">
                                <p>支付宝扫码支付，成功后服务立即开通</p>
                                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="popover fade left in" role="tooltip" id="notice-popover" style="width: 120px; display: none;">
    <div class="arrow" style="top: 50%;"></div>
    <div class="popover-content" style="padding: 8px 10px;text-align: center">
        <img src="<?php echo $_smarty_tpl->tpl_vars['manager']->value['m_report_qrcode'];?>
" alt="" style="height: 95px">
        <div style="font-size: 12px;color: #a8a8a8;margin-top: 3px;">微信扫码关注公众号获取消息通知</div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" >
    var currSuid = "<?php echo $_smarty_tpl->tpl_vars['outinfo']->value['suid'];?>
", currVersion = 0, currSwitch = 0;
    var renewal = '<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_self_renewal'];?>
';
    var from = '<?php echo $_smarty_tpl->tpl_vars['from']->value;?>
';
    var bindMid = '<?php echo $_smarty_tpl->tpl_vars['manager']->value['m_weixin_mid'];?>
';
    var qrcode = '<?php echo $_smarty_tpl->tpl_vars['manager']->value['m_report_qrcode'];?>
';
    $(function(){
        // 动态修改导航z-index
        $(".modal").on('show.bs.modal', function () {
            $("#navbar").css("z-index",0);
        });
        $(".modal").on('hide.bs.modal', function () {
            $("#navbar").css("z-index",1);
        });

        /*支付方式tab栏切换*/
        $(".pay-way-nav").click(function(event) {
            currSwitch++;
            var that    = this;
            changePay(that);
        });

        /*选购*/
        $(".js-buy-btn").on('click', function(event) {
            console.log(renewal);
            if(renewal==1){
                event.preventDefault();
                currSwitch  = 0;//重置
                currVersion = $(this).data('xid');
                $("#taocanBuyModal").modal('show');//选购弹出层显示
                changePay(null);
            }else{
                layer.msg('暂不支持自助续费请和代理商联系');
            }
        });

        /*if(from === 'login' && bindMid==0){
            layer.open({
                type: 1 //Page层类型
                ,area: ['500px', '350px']
                ,title: '商户经营报告通知'
                ,shade: 0.6 //遮罩透明度
                ,maxmin: false //允许全屏最小化
                ,anim: 1 //0-6的动画形式，-1不开启
                ,content: '<div style="padding:15px;text-align: center"><img src="'+qrcode+'" alt=""><div style="font-size: 16px;width: 60%;margin: 15px auto;color: red;">扫码关注公众号，小程序每日经营数据会在第2天早上8：00发送给您</div></div>'
            });
        }*/

        $('#weixin-notice-tip').hover(function(){
            var edithat = $(this) ;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            $("#notice-popover").css({'left':left-126,'top':top-110}).stop().show();
        },function(){
            $("#notice-popover").stop().hide();
        })


        /*if(window.Notification && Notification.permission !== "denied") {
            Notification.requestPermission(function(status) {
                var notice_ = new Notification('新的消息', { body: '您有新的消息'});
                notice_.onclick = function(){
                    window.focus();
                }
            });
        }*/
    });

    //获取扫码
    function qrcode(index) {
        layer.load(2, {time: 1000});
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/guide/chargeQrcode/version/'+currVersion+'/unique/'+currSuid+'/channel/'+type[index];
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

        img.attr('src', url);
    }

    function msgTip(){
        layer.msg('请到官网帮助中心查看相关文档教程!');
    }

    function hadPay(obj, event) {
        event.preventDefault();
        var new_url = "/wxapp/index/index?select_suid="+currSuid;
        window.location.replace(new_url);
    }

    function changePay(obj) {
        obj = obj ? obj : $('.pay-way-nav').first();
        $(obj).addClass('active').siblings().removeClass('active');
        var index = $(obj).index();
        $(".online-pay-content").eq(index).stop().show();
        $(".online-pay-content").eq(index).siblings('.online-pay-content').stop().hide();
        if (currSwitch < 2) {
            qrcode(index);
        }
    }

    function modifyShopName(obj, event) {
        layer.prompt({title: '请输入新的店铺名称'}, function(val, index){
            layer.close(index);
            if (val) {
                var loading = layer.load(2, {time: 10*1000});
                $.ajax({
                    type    : 'post',
                    url     : '/wxapp/setup/modifyName',
                    data    : {
                        'name' : val
                    },
                    dataType: 'json',
                    success : function(ret){
                        layer.close(loading);
                        if(ret.ec == 200){
                            layer.msg('店铺名称修改成功', {
                                time: 0 //不自动关闭
                                ,btn: ['确定']
                                ,yes: function(index){
                                    layer.close(index);
                                    location.reload();
                                }
                            });
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }
        });
    }
    /**
     * 开启关注公众号
     */
    function changeAuditStatus() {
        var followOpen = $('#audit_status').is(':checked');
        var data = {
            followOpen : followOpen ? 1 : 0
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/setup/saveFollowOpen',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(followOpen==1){
                        layer.msg('启用成功');
                    }else{
                        layer.msg('关闭成功');
                    }
                }
            }
        });
    }

    $(".increment-service").click(function() {
        layer.msg('请联系你的上级服务商开通');
    });
</script><?php }} ?>

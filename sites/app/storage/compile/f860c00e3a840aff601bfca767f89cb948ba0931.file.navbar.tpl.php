<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:34:23
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/layer/navbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1884301635e1be53f9e6813-28842465%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f860c00e3a840aff601bfca767f89cb948ba0931' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/layer/navbar.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1884301635e1be53f9e6813-28842465',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sys_event_count' => 0,
    'sys_event' => 0,
    'item' => 0,
    'sys_notice' => 0,
    'curr_shop' => 0,
    'message_count' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be53fa54547_25489915',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be53fa54547_25489915')) {function content_5e1be53fa54547_25489915($_smarty_tpl) {?><style>
    div.navbar {z-index: 50;}
	.navbar-header.pull-right li{height:60px;line-height:60px;}
	.ace-nav > li > a{background-color:#fff!important;}
	.ace-nav>li{border-left:1px solid #fff!important;}
	.navbar-header.pull-right li a{color:#666;font-size:14px;}
	.navbar-header.pull-right li:hover a{color:#0077DD!important;}
    .icon_dot_notices {height: 18px;background-color: #ff5027;line-height: 18px;color: #fff;font-size: 12px;position: absolute;top: 11px;right: 5px;z-index: 999;}
    .icon_dot_notices_inner {display: block;position: relative;z-index: 1;margin: 0 -2px;}
    .icon_dot_notices_left {position: absolute;left: -8px;top: 0;background: #ff5027;width: 18px;height: 18px;vertical-align: middle;display: inline-block;border-radius: 100%;}
    .icon_dot_notices_right {position: absolute;right: -8px;top: 0;background: #ff5027;width: 18px;height: 18px;vertical-align: middle;display: inline-block;border-radius: 100%;}
    .account_message_box {position: absolute;top: 55px;right: 180px;z-index: 9;}
    .account_message_box:before{content: '';position: absolute;top: -9px;width: 15px;right: 110px;height: 15px;background-color: #fff;transform: rotate(45deg);-ms-transform: rotate(45deg);-moz-transform: rotate(45deg);-webkit-transform: rotate(45deg);-o-transform: rotate(45deg);}
    .skin_pop .skin_pop_inner {border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;box-shadow: 0 0 20px #e4e8eb;-moz-box-shadow: 0 0 20px #e4e8eb;-webkit-box-shadow: 0 0 20px #e4e8eb;background-color: #fff;}
    .account_message_box_hd {line-height: 49px;padding: 0 15px;border-bottom: 1px solid #e7e7eb;}
    .account_message_box_hd .global_info {font-size: 16px;float: left;}
    .global_mod .global_extra {text-align: right;}
    .account_message_box_bd {padding: 0 15px;max-height: 300px;overflow-y: auto;line-height:normal}
    .account_message_list {width: 360px;}
    .account_message_item:first-child {border-top-width: 0;}
    .account_message_item {padding: .8em 0;border-top: 1px solid #e7e7eb;}
    .account_message_title {width: 300px;display: inline-block;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;word-wrap: normal;font-size: 15px;color: #333;}
    .account_message_desc, .account_message_info {color: #9a9a9a;word-wrap: break-word;word-break: break-all;}
    .account_message_desc {padding-top: .2em;cursor: pointer;font-size: 13px}
    .account_message_info {padding-top: .4em;font-size: 13px;height: 20px;}
    .message-get-more{margin-bottom: 10px;text-align: center;}
    .message_staus{float: right; color: #07d}
    .message_staus.read{color: #9a9a9a}
    .message-link{cursor: pointer;}
</style>
<div class="navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav">
        <!--
        <li class="purple">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="icon-bell"></i> 通知
                <span class="badge badge-important"><?php echo $_smarty_tpl->tpl_vars['sys_event_count']->value;?>
</span>
            </a>
            <ul class="pull-right dropdown-navbar navbar-green dropdown-menu dropdown-caret dropdown-close" style="top:96%;">
                <li class="dropdown-header">
                    <i class="icon-warning-sign"></i>
                    <?php echo $_smarty_tpl->tpl_vars['sys_event_count']->value;?>
条通知
                </li>
                <?php if ($_smarty_tpl->tpl_vars['sys_event']->value) {?>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sys_event']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['sn_link'];?>
" target="_blank">
                        <div class="clearfix">
                            <span class="pull-left gonggao-list"><?php echo $_smarty_tpl->tpl_vars['item']->value['se_title'];?>
</span>
                        </div>
                    </a>
                </li>
                <?php } ?>
                <?php } else { ?>
                <li  style="text-align:center;font-size:12px;color:#999;border-bottom: 1px solid #eee;height:40px;line-height:40px;">
                    <span>暂无更多通知~</span>
                </li>
                <?php }?>

                <li>
                    <a href="/manage/system/event">
                        查看所有通知
                        <i class="icon-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </li>
        -->
        <!--
        <li class="purple">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                 <i class="icon-bullhorn"></i> 公告
            </a>
            <ul class="pull-right dropdown-navbar navbar-blue dropdown-menu dropdown-caret dropdown-close" style="top:96%;">
                <li class="dropdown-header">
                    <i class="icon-warning-sign"></i>
                    系统公告&产品动态
                </li>
                <?php if ($_smarty_tpl->tpl_vars['sys_notice']->value) {?>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sys_notice']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <li>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['sn_link'];?>
" target="_blank">
                        <div class="clearfix">
                            <span class="pull-left gonggao-list"><?php echo $_smarty_tpl->tpl_vars['item']->value['sn_title'];?>
</span>
                        </div>
                    </a>
                </li>
                <?php } ?>
                <?php } else { ?>
                <li style="text-align:center;font-size:12px;color:#999;border-bottom: 1px solid #eee;height:40px;line-height:40px;">
                    <span>暂无更多公告~</span>
                </li>
                <?php }?>
                <li>
                    <a href="/manage/system/notice">
                        查看所有公告
                        <i class="icon-arrow-right"></i>
                    </a>
                </li>
            </ul>
        </li>
        -->
        <!--<li class="light-blue">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" onerror="showDefaultImg('shopLogo')" src="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_logo']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_logo'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>" style="display: inline-block;height: 40px;width: 40px;margin-top: -2px"/>
                <span class="user-info" style="text-align: center;">
                    <small><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_name'];?>
</small>
                    <span style="line-height: 1.8;font-size: 14px;">设置</span>
                </span>
                <i class="icon-caret-down"></i>
            </a>

            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <li>
                    <a href="/wxapp/user/userInfo">
                        <i class="icon-cog"></i>
                        店铺设置
                    </a>
                </li>
                <li>
                    <a href="/manage/user/home">
                        <i class="icon-home"></i>
                        管理中心
                    </a>
                </li>

                <li>
                    <a href="/manage/user/logout">
                        <i class="icon-off"></i>
                        退出
                    </a>
                </li>
            </ul>
        </li>-->
        <!--<li><a href="javascript:;" style="color:#0077DD!important;"><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_name'];?>
</a></li>-->
        <li style="position: relative">
            <a href="JavaScript:;" class="toggle-message-box">消息通知</a>
            <?php if ($_smarty_tpl->tpl_vars['message_count']->value>0) {?>
            <span class="icon_dot_notices">
                <span class="icon_dot_notices_inner"><?php echo $_smarty_tpl->tpl_vars['message_count']->value;?>
</span>
                <span class="icon_dot_notices_left"></span>
                <span class="icon_dot_notices_right"></span>
            </span>
            <?php }?>
        </li>
        <li><a href="/wxapp/user/userInfo">店铺设置</a></li>
        
        <li><a href="/manage/user/logout">退出</a></li>
    </ul><!-- /.ace-nav -->
</div><!-- /.navbar-header -->

<div class="account_message_box skin_pop" style="display: none">
    <div class="skin_pop_inner account_message_box_inner">
        <div class="account_message_box_hd global_mod float_layout">
            <div class="global_info">通知</div>
            <div class="global_extra">
                <a href="javascript:void(0);" onclick="setRead()">全部已读</a>
            </div>
        </div>
        <div class="account_message_box_bd">
            <ul class="account_message_list">

            </ul>
            <div class="message-get-more"><a href="javascript:;">查看更多</a></div>
        </div>
    </div>
</div>

<script>
    var current_message_page = 0;
    $(function () {
        /*隐藏弹出框*/
        $("#main-container").on('click', function(event) {
            optshideTwo();
        });
        $("#navbar").on('click', function(event) {
            optshideTwo();
        });
        $(".toggle-message-box").on('click', function(event) {
            $('.account_message_box.skin_pop').stop().show();
            event.stopPropagation();
        });
        getMessageList();
        $(".message-get-more").on('click', function(event) {
            getMessageList();
            event.stopPropagation();
        });
    })

    /*隐藏弹出框*/
    function optshideTwo(){
        $('.account_message_box.skin_pop').stop().hide();
    }

    /*获取消息列表*/
    function getMessageList() {
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/getShopMessage',
            'data'  : {page: current_message_page},
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    for(let i in ret.data){
                        $('.account_message_list').append(formatMessageItem(ret.data[i]))
                    }
                    current_message_page++
                }else{
                    if(current_message_page==0){
                        $('.account_message_list').html("<span style='color: #c8c8c8;padding: 30px;text-align: center;display: inline-block;width: 100%;'>暂无消息通知</span>")
                        $('.message-get-more').hide();
                    }else{
                        $('.message-get-more').html("<span style='color: #c8c8c8'>没有更多了</span>")
                    }
                }
            }
        });
    }

    /*格式化消息列表数据*/
    function formatMessageItem(data) {
        let html = '';
        html += '<li class="account_message_item"><span href="javascript:;" class="message-link" data-id="'+data.id+'" data-link="'+data.link+'" onclick="messageClick(this)"><div class="account_message_global"><div class="account_message_title">';
        html += data.title;
        html += '</div><span class="message_staus '+(data.read==1?'read':'')+'">'+(data.read==1?'[已读]':'[未读]')+'</span></div><div class="account_message_desc">';
        html += data.content + data.extraContent;
        html += '</div><div class="account_message_info"><span style="float: left">';
        html += data.time;
        html += '</span><span style="float: right;color:#428bca">查看详情</span></div></a></li>'

        return html;
    }

    function messageClick(e){
        let id = $(e).data('id');
        let link = $(e).data('link');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/setRead',
            'data'  : {id: id},
            'dataType' : 'json',
            success : function(ret){
                window.location.href = link;
            }
        });
    }

    function setRead() {
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/setRead',
            'data'  : {},
            'dataType' : 'json',
            success : function(ret){
                window.location.reload();
            }
        });
    }

    /**
     * 通知消息额外跳转链接
     */
    $('.extra-content-link').click(function () {
        let link = $(this).data('link');
        window.open(link);
    });
</script><?php }} ?>

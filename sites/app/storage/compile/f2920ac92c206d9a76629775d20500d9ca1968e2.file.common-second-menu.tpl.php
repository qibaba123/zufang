<?php /* Smarty version Smarty-3.1.17, created on 2020-02-18 20:35:32
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/common-second-menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19925673815e4bda14985df0-58161642%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2920ac92c206d9a76629775d20500d9ca1968e2' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/common-second-menu.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19925673815e4bda14985df0-58161642',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'snTitle' => 0,
    'link' => 0,
    'val' => 0,
    'linkType' => 0,
    'appletCfg' => 0,
    'ver_style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4bda1499a784_07563954',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4bda1499a784_07563954')) {function content_5e4bda1499a784_07563954($_smarty_tpl) {?><link href="/public/manage/css/navmenu.css" rel="stylesheet" />
<div class="second-navmenu" >
    <ul>
        <li class="title"><?php if ($_smarty_tpl->tpl_vars['snTitle']->value) {?><?php echo $_smarty_tpl->tpl_vars['snTitle']->value;?>
<?php }?></li>
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['link']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['val']->value['active']==$_smarty_tpl->tpl_vars['linkType']->value) {?>
        <li><a href="#" class="active"><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a></li>
        <?php } else { ?>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a></li>
        <?php }?>
        <?php } ?>
    </ul>
    <div class="showhide-shortcut">
        <input id='dddd' type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32;?>
">
        <div class="hide-menu">
            <span class="left-top"></span><span class="left-bottom"></span>
            <i class="icon-double-angle-left"></i>
        </div>
        <div class="show-menu" style="display: none;">
            <span class="right-top"></span><span class="right-bottom"></span>
            <i class="icon-double-angle-right"></i>
        </div>
    </div>
</div>


<script>
    window.ver= '<?php echo $_smarty_tpl->tpl_vars['ver_style']->value;?>
';
    $(function(){
        sidebarState(0)
        $(".icon-double-angle-left").on('click', function(event) {
            event.preventDefault();
            sidebarState(1);
        });
        $(".icon-double-angle-right").on('click', function(event) {
            event.preventDefault();
            sidebarState(1);
        });
        /*点击隐藏二级菜单*/
        $(".showhide-shortcut .hide-menu").on('click', function(event) {
            $("#mainContent").css({
                'margin-left': 0
            });
            $(".showhide-shortcut .show-menu").stop().show();
            $(this).stop().hide();
//          $(".second-navmenu").css("left","10px");
//          $(".second-navmenu .showhide-shortcut").css("right","-20px");
			var isMenuMin = $("#sidebar").hasClass("menu-min");
            if(isMenuMin){
	            $('div.navbar').css({'margin-left': '42px'});
	            $('.index-logo').css({'width':'30px','height':'30px'});
	            
            	$(".second-navmenu").css("left","-87px");
            	$(".second-navmenu .showhide-shortcut").css("right","-20px");
            }else{
	            $('div.navbar').css({'margin-left': ver=='1'?"190px":"140px"});
	            $('.index-logo').css({'width':'60px','height':'60px'});
            	$(".second-navmenu").css("left",ver=='1'?"60px":"10px");
            	$(".second-navmenu .showhide-shortcut").css("right","-20px");
            }
        });
        /*点击显示二级菜单*/
        $(".showhide-shortcut .show-menu").on('click', function(event) {
            $("#mainContent").css({
                'margin-left': "130px"
            });
            $(".showhide-shortcut .hide-menu").stop().show();
            $(this).stop().hide();
//          $(".second-navmenu").css("left","140px");
//          $(".second-navmenu .showhide-shortcut").css("right",0);
			var isMenuMin = $("#sidebar").hasClass("menu-min");
            if(isMenuMin){
	            $('div.navbar').css({'margin-left': '42px'});
	            $('.index-logo').css({'width':'30px','height':'30px'});
	            
            	$(".second-navmenu").css("left","42px");
            	$(".second-navmenu .showhide-shortcut").css("right","0");
            }else{

                $('div.navbar').css({'margin-left': ver=='1'?"190px":"140px"});
	            $('.index-logo').css({'width':'60px','height':'60px'});
            	// $(".second-navmenu").css("left","140px");
                $(".second-navmenu").css("left",ver=='1'?"190px":"140px");
            	$(".second-navmenu .showhide-shortcut").css("right","0");
            }
        });

    })
    function sidebarState(tag){
        var isMenuMin = $("#sidebar").hasClass("menu-min");
       // console.log(tag);
       console.log(isMenuMin);
        var left = 0;
        if(isMenuMin){
            if(tag == '1'){
                left = ver=='1'?'190px':'140px';
            }else{
                left = '42px';
            }
        }else{
            if(tag == '1'){
                left = '42px';
            }else{
                 left = ver=='1'?'190px':'140px';
            }
        }
        $(".second-navmenu").css({
            left : left
        })
        // 修复页面二级菜单展开遮挡bug
        // zhangzc
        // 2019-03-09
        if(left.slice(0,-2)>10){  //二级菜单的left值
            $('#mainContent').css({'margin-left':'130px'});
            $('.second-navmenu .hide-menu').show();
            $('.second-navmenu .show-menu').hide();
            $('.second-navmenu .showhide-shortcut').css('right',0);
        }else{
            $('#mainContent').css({'margin-left':'0'});
        }
    }
</script><?php }} ?>

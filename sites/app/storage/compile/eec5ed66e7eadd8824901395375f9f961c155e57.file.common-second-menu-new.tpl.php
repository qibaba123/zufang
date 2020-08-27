<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:45:03
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/common-second-menu-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10814602355e4df2afa30fd9-32125654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eec5ed66e7eadd8824901395375f9f961c155e57' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/common-second-menu-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10814602355e4df2afa30fd9-32125654',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'snTitle' => 0,
    'linkLeft' => 0,
    'val' => 0,
    'linkType' => 0,
    'secondLink' => 0,
    'ver_style' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df2afa4a6f4_70108645',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df2afa4a6f4_70108645')) {function content_5e4df2afa4a6f4_70108645($_smarty_tpl) {?><link href="/public/manage/css/navmenu.css" rel="stylesheet" />
<div class="second-navmenu" >
    <ul>
        <li class="title"><?php if ($_smarty_tpl->tpl_vars['snTitle']->value) {?><?php echo $_smarty_tpl->tpl_vars['snTitle']->value;?>
<?php }?></li>

        <?php if ($_smarty_tpl->tpl_vars['linkLeft']->value) {?>

        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['linkLeft']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['val']->value['active']==$_smarty_tpl->tpl_vars['linkType']->value) {?>
        <li><a href="#" class="active" ><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a></li>
        <?php } else { ?>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
" ><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a></li>
        <?php }?>
        <?php } ?>

        <?php } else { ?>

        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['secondLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <?php if ($_smarty_tpl->tpl_vars['val']->value['active']==$_smarty_tpl->tpl_vars['linkType']->value) {?>
        <li><a href="#" class="active" ><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a></li>
        <?php } else { ?>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
" ><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a></li>
        <?php }?>
        <?php } ?>

        <?php }?>

    </ul>
    <div class="showhide-shortcut">
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
//            $(".main-slide-box").css({
//                'margin-left': 0
//            });
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
//            $(".main-slide-box").css({
//                'margin-left': "140px"
//            });
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
                $(".second-navmenu").css("left",ver=='1'?"190px":"140px");
     
                $('div.navbar').css({'margin-left': ver=='1'?"190px":"140px"});

            	$(".second-navmenu .showhide-shortcut").css("right","0");
            }
        });
    });
    function sidebarState(tag){
        var isMenuMin = $("#sidebar").hasClass("menu-min");
        console.log('侧边栏是否有此类'+isMenuMin);
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

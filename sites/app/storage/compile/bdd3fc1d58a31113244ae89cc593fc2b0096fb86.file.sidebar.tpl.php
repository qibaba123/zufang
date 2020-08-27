<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:34:23
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/layer/sidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19426379495e1be53fa58e51-64934916%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdd3fc1d58a31113244ae89cc593fc2b0096fb86' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/layer/sidebar.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19426379495e1be53fa58e51-64934916',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'curr_shop' => 0,
    'sibebar_menu' => 0,
    'oem' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be53fa67098_64786202',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be53fa67098_64786202')) {function content_5e1be53fa67098_64786202($_smarty_tpl) {?><style>
    .nav-list > li .submenu > li > a .menu-text{
        display: inline-block;
    }
    .nav-list > li .submenu > li > a .menu-text.icon_pay{
        background: url(/public/manage/images/icon_fufei.png) no-repeat right center;
        padding-right: 18px;
        background-size: 14px;
        width: 90%;
    }
</style>
<div class="sidebar" id="sidebar" >
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>
    <!-- <div class="inner-container" style="position: absolute;left:0;right:-16px;height:100%;z-index:12;overflow-x: hidden;overflow-y: scroll;"> -->
        <div class="sidebar-content">
            <div class="index-logo" style="width:60px;height:60px;margin: 16px auto;">
                <img src="<?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_logo']) {?><?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_logo'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>" style="width:100%;height:100%;border-radius:50%!important;">
            </div>
            <ul class="nav nav-list">
                <?php echo $_smarty_tpl->tpl_vars['sibebar_menu']->value;?>

            </ul><!-- /.nav-list -->
            <div class="sidebar-collapse" id="sidebar-collapse" style="border-bottom: 0;">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['oem']->value) {?>
            <div class="logo-show" style="height: auto;color: #fff">
                <span style="background: url('<?php echo $_smarty_tpl->tpl_vars['oem']->value['ao_logo'];?>
') no-repeat 2px center;background-size: 38px;"></span>
                <div class='comp-name' style="text-align: center"><?php echo $_smarty_tpl->tpl_vars['oem']->value['ao_name'];?>
</div>
            </div>

            <?php } else { ?>
            <div class="logo-show"><span></span></div>
            <!-- <div class="anli-show">
                <div class="anli-item case" style="height: 200px">
                    <img src="/public/wxapp/images/jiaoliuxuexi.png" alt="图标"  onmouseover="showCode(this)" style="width: 50%;height: 35%">
                    <div class="erweima" onmouseout="hideCode(this)"><img src="/public/wxapp/images/jiaoliu.png" alt="二维码" style="height: 200px"></div>
                </div>
            </div> -->
            <?php }?>

        </div>
    <!-- </div> -->
    <script type="text/javascript">

        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){

        }
        /*显示二维码*/
        function showCode(elem){
            $(elem).parents('.anli-item').find('.erweima').stop().fadeIn();
        }
        /*隐藏二维码*/
        function hideCode(elem){
            $(elem).stop().fadeOut();
        }
    </script>
</div>
<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:43:30
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/manage/layer/kefu-notice.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3923549785dea14b278d247-72910736%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '388f09c3528f0ea72a1c6663ea0b41eb4d565f5a' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/manage/layer/kefu-notice.tpl',
      1 => 1536116108,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3923549785dea14b278d247-72910736',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'oem' => 0,
    'sys_notice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea14b2796dc1_87523056',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea14b2796dc1_87523056')) {function content_5dea14b2796dc1_87523056($_smarty_tpl) {?><style>
    .kefu-notice{
        position: fixed;
        right: 2px;
        bottom: 2px;
        z-index: 201;
    }
    .kefu-notice>div{
        padding:8px 0;
        background-color: #FF6600;
        color: #fff;
        text-align: center;
        line-height: 1;
        cursor: pointer;
        width: 65px;
        font-size: 12px;
    }
    .kefu-notice>.contact-kefu{
        border-bottom: 1px solid #EB5E00;
        -webkit-border-radius: 3px 3px 0 0;
        -moz-border-radius: 3px 3px 0 0;
        -ms-border-radius: 3px 3px 0 0;
        -o-border-radius: 3px 3px 0 0;
        border-radius: 3px 3px 0 0;
    }
    .kefu-notice>.contact-kefu a{
        display: block;
        color: #fff;
        text-decoration: none;
    }
    .kefu-notice>.sys-notice{
        -webkit-border-radius: 0 0 3px 3px;
        -moz-border-radius: 0 0 3px 3px;
        -ms-border-radius: 0 0 3px 3px;
        -o-border-radius: 0 0 3px 3px;
        border-radius: 0 0 3px 3px;
        position: relative;
    }
    .kefu-notice>div img{
        display: block;
        margin:0 auto;
        margin-bottom: 3px;
        height: 22px;
    }
    .sys-notice .notice-detail{
        position: absolute;
        right: -700px;
        width: 500px;
        bottom:0;
        height: 54px;
        line-height: 54px;
        background-color: #f5f5f5;
        color: #333;
        border:1px solid #ddd;
        border-radius: 3px 0 0 3px;
        font-family: '黑体';
        font-size: 15px;
        -webkit-transition:right 0.5s;
        -moz-transition:right 0.5s;
        -ms-transition:right 0.5s;
        -o-transition:right 0.5s;
        transition:right 0.5s;
        z-index: -1;
    }
    .sys-notice .notice-detail.show{
        right: 100%;
    }
    .sys-notice .notice-detail a{
        text-decoration: none;
        color: blue;
    }
</style>
<div class="kefu-notice">
    <div class="contact-kefu">
        <?php if ($_smarty_tpl->tpl_vars['oem']->value) {?>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $_smarty_tpl->tpl_vars['oem']->value['ao_kefu'];?>
&site=qq&menu=yes" target="_blank">
            <img src="/public/manage/img/icon-kefu.png" alt="客服">
            联系客服
        </a>
        <?php } else { ?>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=2271654662&site=qq&menu=yes" target="_blank">
            <img src="/public/manage/img/icon-kefu.png" alt="客服">
            联系客服
        </a>
        <?php }?>
    </div>
    <div class="sys-notice">
        <img src="/public/manage/img/icon-notice.png" alt="公告">
        系统公告
        <div class="notice-detail" id="notice-detail">
            [公告]平台分销功能已调整完毕，可进行付费使用 <a href="<?php echo $_smarty_tpl->tpl_vars['sys_notice']->value[0]['sn_link'];?>
" target="_blank">点此查看</a>
        </div>
    </div>
</div>
<script>
    $(".sys-notice").click(function(event) {
        $(this).find('.notice-detail').toggleClass('show');
    });
    $(".main-container").click(function(event) {
        var isShow = $("#notice-detail").hasClass('show');
        if(isShow){
            $("#notice-detail").removeClass('show');
        }
    });
</script><?php }} ?>

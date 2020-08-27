<!DOCTYPE html>
<html lang='zh'>
<head>
    <{config_load file="default.conf"}>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv=X-UA-Compatible content="IE=EmulateIE10">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><{#app_name#}></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/public/manage/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/5.8.1/css/all.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/public/manage/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="/public/manage/assets/css/colorbox.css" />
    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="/public/manage/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/public/manage/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/public/manage/assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="/public/manage/overload.css?15" />
    <link rel="stylesheet" href="/public/wxapp/wxappOverloadNew.css?19" />
    <style>
        body{
            font-family:  PingFang SC,Microsoft YaHei,Arial,sans-serif,Helvetica Neue,Helvetica,Hiragino Sans GB;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
        .main-content{
            margin-left: 190px;
            padding-right: 0;
        }
        .second-navmenu{
            top:89px!important;
        }
        .sidebar{
            width: 190px!important;
        }
        .fas{
            width: 30px;
            height: 36px;
            line-height: 36px;
            text-align: center;
            font-weight: 900!important;
        }
        .nav-list > li .submenu > li a > [class*="fa-"]{
            display: inline-block!important;
            font-size: 14px !important;
        }
        .nav-list > li .submenu{
            margin-left: 8px;
        }
    </style>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/public/manage/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="/public/manage/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/public/manage/assets/js/html5shiv.js"></script>
    <script src="/public/manage/assets/js/respond.min.js"></script>
    <![endif]-->
 
    <{$new_styles}>
    <!-- basic scripts -->

    <!--[if !IE]> -->

    <!-- <![endif]-->

    <!--[if IE]>
    <script src="/public/common/js/jquery-1.11.1.min.js"></script>
    <![endif]-->

    <!--[if !IE]> -->

    <script type="text/javascript">
        window.jQuery || document.write("<script src='/public/manage/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/public/manage/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
        if("ontouchend" in document) document.write("<script src='/public/manage/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/public/common/js/bootstrap-3.3.1.min.js"></script>
    <script src="/public/manage/assets/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->

    <!-- ace scripts -->

    <script src="/public/manage/assets/js/ace-elements.min.js"></script>
    <script src="/public/manage/assets/js/ace.min.js"></script>
    <script type="text/javascript" src='https://cdn.staticfile.org/vue/2.6.10/vue.min.js'></script>
    <script type="text/javascript" src='https://cdn.staticfile.org/axios/0.19.0-beta.1/axios.min.js'></script>
<!--     <link rel="stylesheet" type="text/css" href="https://cdn.staticfile.org/iview/3.3.3/styles/iview.css">
 -->    <script type="text/javascript" src='https://cdn.staticfile.org/iview/3.3.3/iview.min.js'></script>
</head>
<body>

<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>
    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                   <{$shop_info.shop_name}> | 供应商后台 
                </small>
            </a>
        </div>
        <{include file="../supplier/navbar.tpl"}>
    </div>
</div>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{
            ace.settings.check('main-container' , 'fixed')
        }catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>
        <{include file="../supplier/sidebar.tpl"}>
        <div class="main-content">
            <{include file="../manage/layer/breadcrumbs-new.tpl"}>
            <div class="page-content">
                <{include file="$NACHO_CONTENT_FOR_LAYOUT"}>
            </div><!-- /.page-content -->
        </div>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse" style="position: fixed;right: 20px;bottom: 100px;display: none;">
           <i class="fas fa-arrow-up"></i>
        </a>
    </div><!-- /.main-container-inner -->
</div><!-- /.main-container -->
<{foreach $pageSpecScript as $script}>
    <{$script}>
<{/foreach}>
<script src="/public/plugin/nicescroll/jquery.nicescroll.min.js"></script>
<script>
    $(function(){
        if($('.sidebar').hasClass('menu-min')){
            $('div.navbar').css('margin-left','42px');
        }else{
            $('div.navbar').css('margin-left','190px');
        }
        $(".sidebar-content").niceScroll({
            cursorborder:"0",
            cursorcolor:"#444",
            cursorwidth:"4",
            cursoropacitymax:"0",
            autohidemode:true
        });
        setTimeout(function(){
            sidebarOverflow(0);
        },10)
        $(".icon-double-angle-left").on('click', function(event) {
            event.preventDefault();
            sidebarOverflow(1);
        });
        $(".icon-double-angle-right").on('click', function(event) {
            event.preventDefault();
            sidebarOverflow(1);
        });
        // 返回顶部按钮显示隐藏
        $("#main-container").scroll(function(event) {
            var scrollTop = $(this).scrollTop();
            if(scrollTop>300){
                $("#btn-scroll-up").stop().show();
            }else{
                $("#btn-scroll-up").stop().fadeOut();
            }
        });
        // 点击返回顶部按钮
        $("#btn-scroll-up").on('click', function(event) {
            event.preventDefault();
            $("#main-container").animate({
                scrollTop:0
            }, 500);
        });
    });
    function sidebarOverflow(tag){
        var isMenuMin = $("#sidebar").hasClass("menu-min");
        var overflow = 0;
        if(isMenuMin){
            if(tag == '1'){
                overflow = 'hidden';
            }else{
                overflow = '';
            }
        }else{
            if(tag == '1'){
                overflow = '';
            }else{
                overflow = 'hidden';
            }
        }
        $(".sidebar-content").css({
            overflow : overflow
        })
        if(overflow=='hidden'){
            $('div.navbar').css('margin-left','190px');
            $('.index-logo').css({'width':'60px','height':'60px'});
        }else{
            $('div.navbar').css('margin-left','42px');
            $('.index-logo').css({'width':'30px','height':'30px'});
        }
    }
</script>
</body>
</html>
<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" href="/public/manage/assets/css/font-awesome.min.css" />

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
    <link rel="stylesheet" href="/public/manage/overload.css" />
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
                    <!--
                    <i class="icon-fxb"></i>
                    -->
                    <{$shop['es_name']}><{#app_name#}>
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->
        <{include file="../shop/layer/navbar.tpl"}>
    </div><!-- /.container -->
</div>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){

        }
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>
        <{include file="../shop/layer/sidebar.tpl"}>
        <div class="main-content">
            <{include file="../shop/layer/breadcrumbs.tpl"}>
            <div class="page-content">
                <{include file="$NACHO_CONTENT_FOR_LAYOUT"}>
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->
        <{include file="../shop/layer/helpcenter.tpl"}>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse" style="position:absolute">
            <i class="icon-double-angle-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container-inner -->
</div><!-- /.main-container -->
<{foreach $pageSpecScript as $script}>
    <{$script}>
    <{/foreach}>

<script src="/public/plugin/nicescroll/jquery.nicescroll.min.js"></script>
<script>
    $(function(){
        /*$(".page-content").niceScroll({
         cursorborder:"0",
         cursorcolor:"#444",
         cursorwidth:"6",
         cursoropacitymax:"0.8",
         autohidemode:false
         });*/
        $(".help-container-body").niceScroll({
            cursorborder:"0",
            cursorcolor:"#444",
            cursoropacitymax:"0.7",
            // autohidemode:false
        });
        $("#btn-scroll-up").on('click', function(event) {
            event.preventDefault();
            $("#main-container").animate({
                scrollTop:0
            }, 500);
        });
    })
</script>
</body>
</html>
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
    <link rel="stylesheet" href="/public/manage/assets/css/new/font-awesome.css" />

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
    <link rel="stylesheet" href="/public/manage/overload.css?15" />
    <!--
    <link rel="stylesheet" href="/public/wxapp/wxappOverload.css?17" />
    -->
    <link rel="stylesheet" href="/public/wxapp/wxappOverloadNew.css?19" />
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
</head>

<body>
<style>
    .browser-tip { background-color: #2C099B; position: relative;display: none;z-index: 2;}
    .browser-tip .down-tip { display: block; height: 60px; width: 100%; background: url(/public/manage/img/360down.jpg) no-repeat center; position: relative; }
    .browser-tip .close-tip { width: 30px; height: 60px; line-height: 60px; text-align: center; position: absolute; right: 10px; top: 0; font-size: 22px; color: rgba(255, 255, 255, 0.9); cursor: pointer; }
    .browser-tip .close-tip:hover { color: #fff; text-decoration: none; }
    .help-body-content .contact-kefu, .kefu-notice .contact-kefu { display: none; }
    .kefu-notice>.sys-notice { -webkit-border-radius: 3px!important; -moz-border-radius: 3px!important; -ms-border-radius: 3px!important; -o-border-radius: 3px!important; border-radius: 3px!important; }
    /*.breadcrumbs{
        z-index: 3!important;
    }*/
    .second-navmenu{top:89px!important;}
</style>
<!-- 推荐浏览器 -->
<!-- <div class="browser-tip" id="browsertip">
    <a href="http://chrome.360.cn/" target="_blank" class="down-tip"></a>
    <span class="close-tip" onclick="closeTip(this)">×</span>
</div> -->
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <{$curr_shop['s_name']}><{#app_name#}> | <{if $oem}><{$oem['ao_name']}><{else}>小程序<{/if}>
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->
        <!-- <div style="float:left;margin-left:51%;margin-top:10px;font-size:14px;">
            <span><a style="color:#409FE6;" href="<{$articleHref}>" target="_blank">模板制作教程请点此查看</a></span>
        </div>-->
        <{include file="../wxapp/layer/navbar.tpl"}>
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
        <{include file="../wxapp/layer/sidebar.tpl"}>
        <div class="main-content">
            <{include file="../manage/layer/breadcrumbs-new.tpl"}>
            <div class="page-content">
                <{include file="$NACHO_CONTENT_FOR_LAYOUT"}>
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->
        <{if $oem}>
        <{include file="../wxapp/layer/oemhelpcenter.tpl"}>
        <{else}>
        <{include file="../manage/layer/helpcenter.tpl"}>
        <{/if}>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse" style="position: fixed;right: 70px;display: none;">
            <i class="icon-double-angle-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container-inner -->
</div><!-- /.main-container -->
<{foreach $pageSpecScript as $script}>
    <{$script}>
    <{/foreach}>

<{include file="../manage/layer/kefu-notice.tpl"}>
<{include file="../manage/layer/intro-alert.tpl"}>
<script src="/public/plugin/nicescroll/jquery.nicescroll.min.js"></script>
<script>
    $(function(){
        window.ver= '<{$ver_style}>';
        if($('.sidebar').hasClass('menu-min')){
            $('div.navbar').css('margin-left','42px');
        }else{
            $('div.navbar').css('margin-left',ver=='1'?'190px':'140px');
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
        // 判断浏览器下载提示cookie
        // var isBrowserTip = getCookie('browserDowntip');
        // if(isBrowserTip==1){
        //     //显示浏览器提示
        //     $('.browser-tip').css("display","block");
        //     $("#main-container,#sidebar").css("top","105px");
        // }else{
        //     //隐藏浏览器提示
        //     $('.browser-tip').css("display","none");
        //     $("#main-container,#sidebar").css("top","45px");
        // }
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
            $('div.navbar').css('margin-left',ver=='1'?'190px':'140px');
            $('.index-logo').css({'width':'60px','height':'60px'});
//          if($('.showhide-shortcut').find('.show-menu').length>0){
//          	console.log('你好');
//      		$(".second-navmenu").css("left","42px");
//          	$(".second-navmenu .showhide-shortcut").css("right","0");
//          	$("#mainContent").css({
//              'margin-left': "0"
//          	});
//          }
        }else{
            $('div.navbar').css('margin-left','42px');
            $('.index-logo').css({'width':'30px','height':'30px'});
//          if($('.showhide-shortcut').find('.show-menu').length>0){
//          	console.log('你好2');
//      		$(".second-navmenu").css("left","-88px");
//          	$(".second-navmenu .showhide-shortcut").css("right","0");
//          	$("#mainContent").css({
//              'margin-left': "0"
//          	});
//          }
        }
    }
    function closeTip(elem){
        $(elem).parents('.browser-tip').stop().hide();
        $("#main-container,#sidebar").css("top","45px");
        //获取当前时间
        var date = new Date();
        var expiresDays = 365;
        //将date设置为10天以后的时间
        date.setTime(date.getTime()+expiresDays*24*3600*1000);
        //将userId和userName两个cookie设置为365天后过期
        document.cookie = "browserDowntip=0;path=/;expires="+date.toGMTString();
    }
    function getCookie(name){
        var strCookie=document.cookie;
        var arrCookie=strCookie.split("; ");
        for(var i=0;i<arrCookie.length;i++){
            var arr=arrCookie[i].split("=");
            if(arr[0]==name)return arr[1];
        }
        return 1;
    }
</script>
</body>
</html>
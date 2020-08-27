<link href="/public/manage/css/navmenu.css" rel="stylesheet" />
<div class="second-navmenu" >
    <ul>
        <li class="title"><{if $snTitle}><{$snTitle}><{/if}></li>
        <{foreach $linkLeft as $val}>
        <{if $val['active'] eq $linkType}>
        <li><a href="#" class="active"><{$val['label']}></a></li>
        <{else}>
        <li><a href="<{$val['link']}>"><{$val['label']}></a></li>
        <{/if}>
        <{/foreach}>
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
    window.ver= '<{$ver_style}>';
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
</script>
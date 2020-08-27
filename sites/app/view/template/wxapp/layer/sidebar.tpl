<style>
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
                <img src="<{if $curr_shop['s_logo']}><{$curr_shop['s_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="width:100%;height:100%;border-radius:50%!important;">
            </div>
            <ul class="nav nav-list">
                <{$sibebar_menu}>
            </ul><!-- /.nav-list -->
            <div class="sidebar-collapse" id="sidebar-collapse" style="border-bottom: 0;">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <{if $oem}>
            <div class="logo-show" style="height: auto;color: #fff">
                <span style="background: url('<{$oem['ao_logo']}>') no-repeat 2px center;background-size: 38px;"></span>
                <div class='comp-name' style="text-align: center"><{$oem['ao_name']}></div>
            </div>

            <{else}>
            <div class="logo-show"><span></span></div>
            <!-- <div class="anli-show">
                <div class="anli-item case" style="height: 200px">
                    <img src="/public/wxapp/images/jiaoliuxuexi.png" alt="图标"  onmouseover="showCode(this)" style="width: 50%;height: 35%">
                    <div class="erweima" onmouseout="hideCode(this)"><img src="/public/wxapp/images/jiaoliu.png" alt="二维码" style="height: 200px"></div>
                </div>
            </div> -->
            <{/if}>

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

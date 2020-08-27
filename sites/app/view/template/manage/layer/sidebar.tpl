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
            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <a class="btn btn-success" href="<{$common_oper[0]['href']}>" title="<{$common_oper[0]['title']}>">
                        <i class="<{$common_oper[0]['icon']}>"></i>
                    </a>
                    <a class="btn btn-info" href="<{$common_oper[1]['href']}>" title="<{$common_oper[1]['title']}>">
                        <i class="<{$common_oper[1]['icon']}>"></i>
                    </a>
                    <a class="btn btn-warning" href="<{$common_oper[2]['href']}>" title="<{$common_oper[2]['title']}>">
                        <i class="<{$common_oper[2]['icon']}>"></i>
                    </a>
                    <a class="btn btn-danger" href="<{$common_oper[3]['href']}>" title="<{$common_oper[3]['title']}>">
                        <i class="<{$common_oper[3]['icon']}>"></i>
                    </a>
                </div>

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <a class="btn btn-success"></a>
                    <a class="btn btn-info"></a>
                    <a class="btn btn-warning"></a>
                    <a class="btn btn-danger"></a>
                </div>
            </div><!-- #sidebar-shortcuts -->

            <ul class="nav nav-list">
                <{$sibebar_menu}>
            </ul><!-- /.nav-list -->

            <div class="sidebar-collapse" id="sidebar-collapse" style="border-bottom: 0;">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
            <div class="logo-show"><span>天店通</span></div>
        </div>
    <!-- </div> -->
    
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){

        }
    </script>
</div>

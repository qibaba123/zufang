<style>
    /*引导提示*/
    .mod-guide {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        pointer-events: none;
        z-index: 100000;
    }
    .mod-guide .mod-guide-backdrop {
        height: 100%;
        width: 100%;
    }
    .mod-guide-backdrop .backdrop-tb {
        width: 100%;
        height: 100%;            /*table-layout: fixed;*/
        border-collapse: collapse;
    }
    .backdrop-tb td {
        background-color: rgba(0, 0, 0, .5);
        font-size: 0;
        padding: 0;
        pointer-events: auto;
    }
    .backdrop-tb .transparent-row-l {
        width: 139px;
    }
    .mod-guide-main {
        position: absolute;
        left: 220px;
        top: 108px;
        z-index: 1;
        pointer-events: auto;
    }
    .mod-guide-main .mode-dialog-inner {
        width: 320px;
        background-color: #eee;
        border-radius: 2px;
    }
    .mode-dialog-inner .btn-dismiss {
        position: absolute;
        top: 0;
        right: 0;
        width: 25px;
        height: 25px;
        line-height: 25px;
        text-align: center;
        color: #888;
        font-size: 20px;
        text-decoration: none;
        opacity: 0.85;
    }
    .mode-dialog-inner .icon-direct-left {
        position: absolute;
        left: -70px;
        top: 40px;
        width: 69px;
        height: 50px;
        background: url(/public/manage/images/icon_zhiyin.png) no-repeat;
        background-position: 0 0;
    }
    .mode-dialog-inner .icon-direct-right {
        position: absolute;
        left: 100%;
        top: 30px;
        width: 69px;
        height: 50px;
        background: url(/public/manage/images/icon_zhiyin.png) no-repeat;
        background-position: -69px 0;
        display: none;
    }
    .mode-dialog-inner .btn-dismiss:hover {
        opacity: 1;
    }
    .mod-guide-main .mod-dialog-bd {
        padding: 20px;
        border-radius: 2px 2px 0 0;
        border-bottom: 1px solid #e8e8e8;
        min-height: 123px;
    }
    .mod-guide-main .tips-content {
        display: none;
    }
    .mod-guide-main .tips-content .hd-text {
        color: #1FB7B6;
        font-size: 20px;
        margin-bottom: 6px;
    }
    .mod-guide-main .tips-content .p-text {
        color: #333;
        font-size: 14px;
        line-height: 1.7;
        opacity: .85;
    }
    .mod-guide-main .mod-dialog-ft {
        height: 47px;
        border-radius: 0 0 2px 2px;
    }
    .mod-dialog-ft-left {
        float: left;
        width: 60%;
    }
    .mod-dialog-ft-left .mod-dots {
        overflow: hidden;
        padding: 18px 0 18px 10px;
    }
    .mod-dialog-ft-left .mod-dots li {
        float: left;
        margin-left: 9px;
    }
    .mod-dialog-ft-left .mod-dots .btn-dot {
        display: block;
        height: 9px;
        width: 9px;
        border: 1px solid #1FB7B6;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
    }
    .mod-dialog-ft-left .mod-dots .btn-dot.active {
        background-color: #1FB7B6;
    }
    .mod-dialog-ft-right {
        float: right;
        width: 40%;
        padding: 7px;
        text-align: right;
    }
    .mod-dialog-ft-right .next-tips, .mod-dialog-ft-right .close-tips {
        height: 33px;
        line-height: 33px;
        display: inline-block;
        padding: 0 10px;
        margin-right: 2px;
        color: #fff;
        font-size: 12px;
        border-radius: 3px;
        background-color: #1FB7B6;
        text-decoration: none;
        min-width: 70px;
        text-align: center;
    }
    .mod-dialog-ft-right .close-tips {
        display: none;
    }
</style>
<div class="mod-guide" id="mod-guide">
    <div class="mod-guide-backdrop">
        <table class="backdrop-tb">
            <tr class="js-bg-1" style="height: 128px;">
                <td colspan="2"></td>
            </tr>
            <tr class="js-bg-2" style="height: 40px;">
                <td class="transparent-row-l" style="background: transparent;"></td>
                <td class="transparent-row-r"></td>
            </tr>
            <tr class="js-bg-3">
                <td colspan="2"></td>
            </tr>
        </table>
    </div>
    <div class="mod-guide-main mode-dialog">
        <div class="mode-dialog-inner">
            <a href="javascript:;" class="btn-dismiss" title="关闭" onclick="closeTips()">×</a>
            <i class="icon-direct-left"></i>
            <i class="icon-direct-right"></i>
            <div class="mod-dialog-bd">
                <div class="tips-content tips-1" style="display: block;">
                    <div class="hd-text">店铺装修</div>
                    <div class="p-text">在这里可以设置店铺页面，查看店铺概况，设置店铺客服。</div>
                </div>
                <div class="tips-content tips-2">
                    <div class="hd-text">商品管理</div>
                    <div class="p-text">在这里可以上传店铺商品信息，并对商品进行分组管理。</div>
                </div>
                <div class="tips-content tips-3">
                    <div class="hd-text">营销工具</div>
                    <div class="p-text">在这里可以调用营销工具，分销、团购、积分、夺宝、红包等。</div>
                </div>
                <div class="tips-content tips-4">
                    <div class="hd-text">帮助中心</div>
                    <div class="p-text">每一个工具的右侧位置，都有对应的使用教程，可自助完成开店。</div>
                </div>
            </div>
            <div class="mod-dialog-ft">
                <div class="mod-dialog-ft-left">
                    <ol class="mod-dots">
                        <li><a href="javascript:;" class="btn-dot active" onclick="dotTips(this)"></a></li>
                        <li><a href="javascript:;" class="btn-dot" onclick="dotTips(this)"></a></li>
                        <li><a href="javascript:;" class="btn-dot" onclick="dotTips(this)"></a></li>
                        <li><a href="javascript:;" class="btn-dot" onclick="dotTips(this)"></a></li>
                    </ol>
                </div>
                <div class="mod-dialog-ft-right">
                    <a href="javascript:;" class="next-tips" onclick="nextTips()">继续引导</a>
                    <a href="javascript:;" class="close-tips" onclick="closeTips()">关闭</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /*引导提示*/
    function nextTips(){
        var nextIndex = '';
        var btnDot = $(".mod-dialog-ft").find('.btn-dot');
        btnDot.each(function(index, el) {
            if($(this).hasClass('active')){
                nextIndex = $(this).parents('li').index()+1;
            }
        });
        jumpTips(nextIndex);
        console.log(nextIndex);
    }
    function dotTips(obj){
        var nextIndex = $(obj).parents('li').index();
        jumpTips(nextIndex);
        console.log(nextIndex);
    }
    function jumpTips(nextIndex){
        var btnDot = $(".mod-dialog-ft").find('.btn-dot');
        var jsBg1H = '',jsBg2H = '',jsBg3H = '',top = '',left=220,right='auto';
        $(".tips-content").eq(nextIndex).stop().show().siblings().stop().hide();
        btnDot.removeClass('active');
        btnDot.eq(nextIndex).addClass('active');
        if(nextIndex>=3){
            $(".next-tips").stop().hide();
            $(".close-tips").css("display","inline-block");
            $(".icon-direct-left").stop().hide();
            $(".icon-direct-right").stop().show();
            $(".transparent-row-l").css({
                "background":"rgba(0,0,0,0.5)",
                "width":"auto"
            });
            $(".transparent-row-r").css({
                "background":"transparent",
                "width":"160px"
            });
            jsBg1H = "50px";
            jsBg2H = "auto";
            jsBg3H = 0;
            top = "50px";
            left = "auto";
            right = "240px";
        }else{
            $(".close-tips").stop().hide();
            $(".next-tips").css("display","inline-block");
            $(".icon-direct-right").stop().hide();
            $(".icon-direct-left").stop().show();
            $(".transparent-row-l").css({
                "background":"transparent",
                "width":"140px"
            });
            $(".transparent-row-r").css({
                "background":"rgba(0,0,0,0.5)",
                "width":"auto"
            });
            if(nextIndex==1){
                jsBg1H = "168px";
                jsBg2H = "40px";
                jsBg3H = "auto";
                top = "148px";
                left = "220px";
                right = 'auto';
            }else if(nextIndex==2){
                jsBg1H = "328px";
                jsBg2H = "40px";
                jsBg3H = "auto";
                top = "308px";
                left = "220px";
                right = 'auto';
            }else if(nextIndex==0){
                jsBg1H = "128px";
                jsBg2H = "40px";
                jsBg3H = "auto";
                top = "108px";
                left = "220px";
                right = 'auto';
            }
        }
        $(".js-bg-1").css("height",jsBg1H);
        $(".js-bg-2").css("height",jsBg2H);
        $(".js-bg-3").css("height",jsBg3H);
        $(".mod-guide-main").css({
            top : top,
            left : left,
            right : right
        })
    }
    /*关闭引导提示*/
    function closeTips(){
        $("#mod-guide").stop().fadeOut();
    }
</script>
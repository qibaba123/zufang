<style>
.anli-show { overflow: hidden; position: relative; padding: 0 5px; padding-top: 10px; }
.anli-show .anli-item { width: 100%; float: left; margin-bottom: 5px; position: relative; }
.anli-show .anli-item img { display: block; margin: 0 auto; border-radius: 4px; width: 122px; height: 122px; }
.anli-show .anli-item p { line-height: 26px; text-align: center; font-size: 12px; color: #666; padding: 0; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; margin-bottom: 8px; }
.anli-show .erweima { position: absolute; left: 0; width: 100%; background-color: #f9f9f9; display: none; bottom: 20px; top: -5px; height: 131px; }
.anli-show .erweima img { width: 100%; height: 131px; }
.service-one { font-family: "黑体"; border-bottom: 1px solid #EAEAEA; padding-bottom: 10px; margin-bottom: 5px; }
.service-one .title { padding: 10px 0; }
.service-one .title h4 { border-left: 3px solid #3283FA; line-height: 1.1; font-family: "黑体"; font-size: 13px; margin: 0; padding-left: 3px; }
.service-one .code-info img { width: 80%; height: auto; display: block; margin: 0 auto; }
.service-one .code-info div { padding: 7px 0; }
.service-one .code-info p { line-height: 1.1; font-size: 12px; margin: 8px 0; }
.service-one .code-info p.tel { margin: 5px 0; text-align: center; }
.service-one .code-info p.num { margin: 5px 0; text-align: left; }
.app-manage-shop { margin-top: 10px; }
.app-manage-shop img, .anli-show img { width: 100%; display: block; margin: 0 auto; }
.app-manage-shop p { margin: 0; line-height: 1.4; font-size: 12px; color: #666; text-align: center; margin-top: 5px; }
.help-container-body{overflow: auto!important; }
.help-container-body::-webkit-scrollbar { display: none; }
.anli-item a { display: block; }
.browser-recommend .down-tip{display: block;text-align: center;font-size: 13px;color: blue;}
.browser-recommend .down-tip img{display: block;width: 100%;border-radius: 4px;}
.help-center-box{transition: all 0.3s;transform: translateX(0);}
.help-center-box.yincang{transform: translateX(160px);}
.unfold-btn{position:fixed;right:160px;top:50%;height: 116px;width: 40px;margin-top:-58px;z-index: 5;cursor: pointer;background: url(/public/wxapp/images/hide-btn.png) no-repeat left center;background-size:
37px 116px;transition: all 0.3s;}
.unfold-btn span{position: absolute;top:0;right: 0;width: 6px;background-color: #f9f9f9;height: 100%;}
.unfold-btn.yincang{right:-10px!important;}
.unfold-btn img{display: block;height: 18px;width: 18px;margin-top: 49px;margin-left:12px;transition: all
0.3s;transform: rotate(180deg);}
.unfold-btn.yincang img{transform: rotate(0deg);}
.main-content{padding-right: 0;}
</style>
<div class="unfold-btn js_unfold yincang"><span></span><img src="/public/wxapp/images/icon_open.png" alt="隐藏图标"></div>
<div class="help-center-box yincang">
    <div class="help-con">
        <div class="help-container-head">帮助和服务</div>
        <div class="help-container-body">
            <div class="help-body-content" style="padding-bottom: 120px;">
                <div class="contact-kefu" style="padding:15px 0;border-top:1px solid #EAEAEA;border-bottom:1px solid #EAEAEA;margin-bottom:10px;">
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<{$oem['ao_kefu']}>&site=qq&menu=yes" style="display:inline-block;background:url(/public/manage/img/icon_kefu.png) no-repeat;background-position:5px center; background-size:25px;padding-left: 35px;color: #FF8D39;font-size: 16px;">
                        联系客服
                    </a>
                </div>
                <div class="browser-recommend">
                    <a href="http://chrome.360.cn/" target="_blank" class="down-tip">
                        <img src="/public/wxapp/images/360_download.png" alt="360下载">
                    </a>
                </div>
                <div class="anli-show">
                    <p style="display:inline-block;background:url(/public/manage/img/icon_kefu.png) no-repeat;background-position:4px 3px; background-size:18px;padding-left: 30px;color: #FF8D39;font-size: 16px;">客服二维码</p>
                    <div class="anli-item" style="width: 100%">
                        <img src="<{$oem['ao_kefu_qrcode']}>" alt=""/>
                    </div>
                </div>

                <div class="anli-show">
                    <p>客户案例</p>
                    <{foreach $agentCase as $item}>
                        <div class="anli-item case">
                            <img src="<{$item['ac_logo']}>" alt="图标"  onmouseover="showCode(this)">
                            <p><{$item['ac_name']}></p>
                            <div class="erweima" onmouseout="hideCode(this)"><img src="<{$item['ac_qrcode']}>" alt="二维码"></div>
                        </div>
                    <{/foreach}>
                </div>
                <!-- <div class="app-manage-shop">
                    <img src="/public/manage/img/tiandiantong1.jpg" alt="天店通APP二维码">
                </div> -->
                <{if $appletCfg['ac_type'] eq 8}>
                <div style="padding:15px 0;margin-bottom:10px;">
                    <a target="_blank" href="/shop"  style="display:inline-block;background-position:5px center; background-size:25px;color: #399fff;font-size: 16px;">
                        入驻商家登录
                    </a>
                </div>
                <{/if}>
            </div>
        </div>
    </div>
</div>
<script src="/public/plugin/nicescroll/jquery.nicescroll.min.js"></script>
<script>
    $(function(){
        $(".help-container-body").niceScroll({
            cursorborder:"0",
            cursorcolor:"#444",
            cursorwidth:"4",
            cursoropacitymax:"0",
            autohidemode:true
        });
        // 隐藏显示右侧帮助中心
        var scrollbarWidth = $("#main-container")[0].offsetWidth-$("#main-container")[0].scrollWidth;
        if(scrollbarWidth>0){
            var rightX = scrollbarWidth+154;
            $(".js_unfold").css("right",rightX+"px");
        }else{
            $(".js_unfold").css("right","154px");
        }
        $(".js_unfold").click(function() {
            var $this = $(this);
            var paddR = $(".main-content").css("padding-right");
            if(paddR=="0px"){
                $(".main-content").css("padding-right","160px");
                $(".help-center-box").removeClass('yincang');
                $this.removeClass('yincang');
            }else{
                $(".main-content").css("padding-right","0");
                $(".help-center-box").addClass('yincang');
                $this.addClass('yincang');
            }
        })
    })
    /*显示二维码*/
    function showCode(elem){
        $(elem).parents('.anli-item').find('.erweima').stop().fadeIn();
    }
    /*隐藏二维码*/
    function hideCode(elem){
        $(elem).stop().fadeOut();
    }

</script>
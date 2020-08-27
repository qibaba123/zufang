<style type="text/css">
    /******复制样式控制*******/
    .tips-txt{
        height: 40px;
        line-height: 40px;
        text-align: center;
        width: 360px;
        position: fixed;
        top:15%;
        left:50%;
        margin-left: -180px;
        border-radius: 5px;
        z-index: 100;
        color: #666;
        display: none;
    }
    .tips-txt.bg-success{
        border:1px solid #D7E9C7;
        background-color: rgba(223,241,217,0.9);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#E5DFF1D9,endColorstr=#E5DFF1D9);
    }
    .tips-txt.bg-fail{
        border:1px solid #EED3D7;
        background-color: rgba(242,222,222,0.9);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#E5F2DEDE,endColorstr=#E5F2DEDE);
    }
</style>
<div id="tips-txt" class="tips-txt bg-success"></div>
<script type="text/javascript">
    function showTips(msg){
        var timer;
        $("#tips-txt").text(msg).stop().fadeIn();
        clearTimeout(timer);
        timer=setTimeout(function(){
            $("#tips-txt").stop().fadeOut();
        },2000);
    }
</script>
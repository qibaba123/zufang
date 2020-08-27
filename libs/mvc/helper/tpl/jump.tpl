<style type="text/css">
    body,div{
        margin:0;
        padding:0;
    }
    .page-jump-shade{
        width: 100%;
        height: 100%;
        position: fixed;
        top:0;
        left:0;
        background-color: rgba(0,0,0,0.7);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#B2000000,endColorstr=#B2000000);    /*IE8支持*/
        display: none;
        opacity: 0;
        -webkit-opacity: 0;
        -moz-opacity: 0;
        -o-opacity: 0;
        -ms-opacity: 0;
        transition:opacity 0.6s ease-in-out 0s;
        -webkit-transition:opacity 0.6s ease-in-out 0s;
        -moz-transition:opacity 0.6s ease-in-out 0s;
        -o-transition:opacity 0.6s ease-in-out 0s;
        -ms-transition:opacity 0.6s ease-in-out 0s;
    }
    .pageJump-content{
        height: 250px;
        width: 500px;
        background: url(/public/common/img/common_jump.gif) no-repeat;
        background-position:center;
        background-size: cover;
        background-color: #fff;
        position: absolute;
        top:50%;
        left:50%;
        margin-left: -250px;
        margin-top: -125px;
        z-index: 9999999;
        zoom:1;
        color:#000;
    }
    .pageJump-content p{
        width: 100%;
        text-align: center;
        margin-top: 30px;
        font-size: 20px;
        color:#fff;
    }
    .pageJump-content p span{
        font-weight: bold;
    }
    .fadeIn{
        opacity: 1;
        -webkit-opacity: 1;
        -moz-opacity: 1;
        -o-opacity: 1;
        -ms-opacity: 1;
    }
    .fadeOut{
        opacity: 0;
        -webkit-opacity: 0;
        -moz-opacity: 0;
        -o-opacity: 0;
        -ms-opacity: 0;
    }
</style>
<div class="page-jump-shade" id="page-jump-shade">
    <div class="pageJump-content">
        <p>操作成功，<span id="end-time">5</span> 秒后自动跳转...</p>
    </div>
</div>
<script>
    var i = 5;
    var timeDaoJiShi=null;
    var PageJumpShade=document.getElementById('page-jump-shade');
    //出现加载中页面
    function jumpPageShow(){
        PageJumpShade.className='page-jump-shade';
        PageJumpShade.style.display="block";
        setTimeout(function(){
            PageJumpShade.className='page-jump-shade fadeIn';
            remainTime();
        },500);
        //设置
        timeDaoJiShi=setInterval("remainTime()",1000);
    }
    // 5秒后页面淡出
    function remainTime(){
        if(i==0||i<0){
            PageJumpShade.className='page-jump-shade';
            PageJumpShade.className='page-jump-shade fadeOut';
            setTimeout(function(){
                PageJumpShade.style.display='none';
                i=5;
                clearInterval(timeDaoJiShi);
            },500);
            // 倒计时结束页面跳转
            window.location.href='test-successful.html';
        }
        document.getElementById('end-time').innerHTML=i;
        i--;
    }
    var jumpButton=document.getElementById('jump-button');
    jumpButton.onclick=function(){
        jumpPageShow();
    };
</script>
<!doctype html>
<html>
<head>
    <meta charset="gb2312">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>万能收款码</title>
</head>
<body>
<div id="aaa"></div>
<script>
    if(navigator.userAgent.match(/Alipay/i)) {
        // 支付宝
        document.getElementById('aaa').innerText = navigator.userAgent
        //window.location.href = "https://qr.alipay.com/s7x09789hcdklvu4n7dss1a";
    } else if(navigator.userAgent.match(/MicroMessenger\//i)) {
        // 微信
        document.getElementById('aaa').innerText = navigator.userAgent
        //window.location.replace("https://mp.weixin.qq.com/a/~BZkSQ-CHfy1kZzwvfCDfqg~~");
    } else if(navigator.userAgent.match(/baiduboxapp\//i)) {
        // 百度
        document.getElementById('aaa').innerText = navigator.userAgent
        //window.location.replace("https://mbd.baidu.com/ma/landingpage?t=smartapp_share&appid=NhSz0YS5GfwS4s69z335etcCHZlMMTPo");
    } else {
        alert("aa");
    }
</script>

</body>
</html>
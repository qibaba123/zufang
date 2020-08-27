<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes"/>
		<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
		<meta name="apple-mobile-web-app-title" content/>
		<meta name="format-detection" content="telephone=no"/>
		<meta content="email=no" name="format-detection" />
		
		<link rel="stylesheet" href="/public/wxapp/hotel/css/base.css" />
		<link rel="stylesheet" href="/public/wxapp/hotel/css/index-share.css" />
	</head>
	<body>
		<div class="main-content" id="job-wrap">
			<img class="bg" src="/public/wxapp/hotel/images/bg1.png" alt="" />
			<div class="content">
				<div class="goods-wrap">
					<div class="good-style1">
						<{foreach $goods_list as $key => $val}>
						<div class="good-item common-wrap">
							<img class="el-img<{$val['img_flag']}>" src="/public/wxapp/hotel/images/el-img<{$val['img_flag']}>.png">
							<div class="cover">
								<img src="<{$val['g_cover']}>" alt="" />
							</div>
							<div class="info-wrap">
								<div class="name-wrap">
									<div class="name"><{$val['g_name']}></div>
									<div class="brief"></div>
								</div>
								<div class="money-wrap">
									<span class="money"><span class="label">￥</span><{$val['g_price']}></span>
									<span class="ori-money">￥<{$val['g_ori_price']}></span>
								</div>
							</div>
						</div>
						<{/foreach}>
					</div>
				</div>
				<div class="colonel-wrap common-wrap">
					<img class="el-img3" src="/public/wxapp/hotel/images/el-img3.png">
					<img class="el-img4" src="/public/wxapp/hotel/images/el-img4.png">
					<div class="code">
						<img src="<{$qrcode}>" alt="" />
					</div>
					<div class="hotel-name"><{$title}></div>
					<div class="hotel-tel"><{$phone}></div>
					<div class="hotel-address"><{$cfg['ahc_shareposter_addr']}></div>
				</div>
			</div>
		</div>
	</body>
</html>

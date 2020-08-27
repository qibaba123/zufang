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
	<link rel="stylesheet" href="/public/wxapp/job/css/base.css?2" />
	<link rel="stylesheet" href="/public/wxapp/job/css/sharePagetwo.css?6" />
</head>
<body>
<div class="main-content" id="job-wrap">
	<div class="header-wrap">
		<img src="/public/wxapp/job/images/icon_top.jpg" alt="图片" />
	</div>
	<div class="content-center">
		<div class="recruit-wrap">
			<div class="logo">
				<img src="<{$company['ajc_logo']}>" alt="" />
			</div>
			<div class="position-wrap">
				<div class="name"><{$company['ajc_company_name']}></div>
				<div class="label-wrap">
					<label>
						<img src="/public/wxapp/job/images/icon_dingwei.png" alt="图标" />
						<span><{$company['ajc_addr']}></span>
					</label>
				</div>
			</div>
			<div class="desc-wrap">
				<span><{$company['ajc_size']}></span>
				<span><{$company['ajc_name']}></span>
				<span><{$company['ajc_finance']}></span>
			</div>
		</div>
		<!--招聘职位-->
		<div class="recruit-position">
			<div class="title">
				<img src="/public/wxapp/job/images/icon_title.jpg"/>
			</div>
			<div class="position-list clearfix">
				<{foreach $positionList as $val}>
				<div class="position-item">
					<label><span><{$val['ajc_name']}>：<{$val['ajp_min_salary']}>k-<{$val['ajp_max_salary']}>k</span></label>
				</div>
				<{/foreach}>
			</div>
		</div>
	</div>
	<!--内推招聘网-->
	<div class="code-wrap">
		<img class="hu" src="/public/wxapp/job/images/icon_hu.jpg" alt="图片" />
		<div class="code-img">
			<img src="<{$code}>" alt="" />
		</div>
		<div class="desc">长按识别了解更多职位</div>
		<div class="footer-desc">--- <{$cfg['ac_name']}> ---</div>
	</div>
</div>
</body>
</html>

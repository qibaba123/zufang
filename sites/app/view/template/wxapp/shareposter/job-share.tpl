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
	<link rel="stylesheet" href="/public/wxapp/job/css/sharePage.css?23" />
</head>
<body>
<div class="new-share-content" id="job-wrap">
	<img src="/public/wxapp/job/images/job-com-sharebg.png" class="share-bg" alt="分享海报">
	<div class="share-info">
		<div class="company-info">
			<img src="<{$company['ajc_logo']}>" class="company-logo" alt="公司logo">
			<p class="name"><{$company['ajc_company_name']}></p>
			<p class="label">
				<span><{$company['ajc_size']}></span>|<span><{$company['ajc_cate2']}></span>|<span><{$company['ajc_finance']}></span>
			</p>
			<{if $job['ajp_type'] == 1}>
			<div class="award-tip">在线等，悬赏<{$job['ajp_entry_pre_award']}>元</div>
			<{/if}>
		</div>	
		<div class="job-info">
			<div class="job-name"><{$job['ajp_title']}></div>
			<div class="job-salary"><{$job['ajp_min_salary']}><{$job['salaryUnit']}>-<{$job['ajp_max_salary']}><{$job['salaryUnit']}>/<{$job['salaryType']}></div>
			<div class="label">
				<{foreach $labels as $val}>
				<span><{$val}></span>
				<{/foreach}>
			</div>
		</div>
	</div>
	<div class="applet-code">
		<img src="<{$code}>" class="code" alt="小程序码">
		<p class="code-tip">长按识别小程序码，查看详情</p>
		<div class="rights">
			<img src="<{$cfg['ac_avatar']}>" class="shop-logo" alt="店铺logo">
			<span><{$cfg['ac_name']}></span>
		</div>
	</div>
</div>
<!-- <div class="main-content" id="job-wrap">
	<div class="header-wrap">
		<div class="header-con flex-wrap">
			<div class="logo">
				<img src="<{$company['ajc_logo']}>" alt="" />
			</div>
			<div class="infor flex-con">
				<div class="title"><{$company['ajc_company_name']}></div>
				<div class="label-wrap">
					<span><{$company['ajc_size']}></span>
					<span><{$company['ajc_cate2']}></span>
					<span><{$company['ajc_finance']}></span>
				</div>
			</div>
		</div>
		<div class="label-icon">
			<span>聘</span>
		</div>
	</div>
	<div class="recruit-wrap">
		<div class="money-wrap">
			<{$job['ajp_min_salary']}>k-<{$job['ajp_max_salary']}>k
		</div>
		<div class="position-wrap">
			<div class="name"><{$job['ajp_title']}></div>
			<div class="label-wrap">
				<label>
					<img src="/public/wxapp/job/images/icon_dingwei.png" alt="图标" />
					<span><{$job['ajp_city']}></span>
				</label>
				<label>
					<span><{$job['workYears']}></span>
				</label>

			</div>
		</div>
		<div class="desc-wrap">
			<{foreach $labels as $val}>
			<span><{$val}></span>
			<{/foreach}>
		</div>
	</div>
	<{if $job['ajp_type'] == 1}>
		<div class="recommend-content">
			<div class="recommend-wrap flex-wrap">
				<div class="desc"><span>求推荐</span></div>
				<div class="con flex-con">
					悬赏<span><{$job['ajp_entry_pre_award']}></span>元
				</div>
			</div>
		</div>
	<{/if}>
	<div class="code-wrap">
		<div class="code-img">
			<img src="<{$code}>" alt="" />
		</div>
		<div class="desc">
			长按识别，赚取推荐奖
		</div>
		<div class="footer-desc">--- <{$cfg['ac_name']}> ---</div>
	</div>
</div> -->
</body>
</html>
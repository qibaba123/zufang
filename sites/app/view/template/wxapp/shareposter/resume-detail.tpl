<style>
	.flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; }
	.flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
	.flex-vertical { -webkit-box-orient: vertical; -webkit-flex-direction: column; -ms-flex-direction: column; -webkit-flex-flow: column; -flex-direction: column; flex-flow: column; }
	/* 用户信息 */
	.userinfo-box { padding: 13px; background-color: #fff; position: relative; }
	.userinfo-box button { position: absolute; left: 0; top: 0; height: 100%; width: 100%; margin: 0; opacity: 0; z-index: 1; }
	.userinfo-box .avatar-box { height: 55px; width: 55px; border-radius: 50%; margin-right: 10px; position: relative;}
	.userinfo-box .avatar-box .avatar { display: block; height: 100%; width: 100%; border-radius: 50%; }
	.userinfo-box .avatar-box .icon-sex{position: absolute;bottom: 0;right: 0;z-index: 1;width: 18px;height: 18px;}
	.userinfo-box .user-name { font-size: 18px;margin-bottom: 2px;font-weight: bold; }
	.userinfo-box .user-name span{color: #666;font-size: 13px;padding-left: 10px;font-weight: normal;}
	.userinfo-box .user-name .icon-tongbu { padding: 5px; display: inline-block; vertical-align: middle; position: relative;top:-1px;margin-left: 2px; }
	.userinfo-box .user-name .icon-tongbu image { display: block; width: 18px; height: 18px; position: relative; top: -1px; }
	.userinfo-box .edit-tip { font-size: 13px; color: #666; }
	.userinfo-box .edit-tip view{display: inline-block;vertical-align: middle;position: relative;top:-1px;color: #0099f5;margin-left: 4px;}
	.userinfo-box .edit-tip view image{display: inline-block;vertical-align: middle;height: 10px;width: 10px;position: relative;top:-1px;margin-left: 1px;}
		/* 快捷导航 */
	.shortcut-wrap{background-color: #fff;padding: 10px 0 0;}
	.shortcut-wrap .label-title{font-size: 16px;color: #333;padding: 0 11px;}
	.mine-shortcut-menu { display: flex;background-color: #fff;}
	.mine-shortcut-menu .shortcut-item { flex:1; width: 24%; padding: 10px 0; box-sizing: border-box; text-align: center;display: inline-block;}
	.mine-shortcut-menu .shortcut-item image { width: 25px; height: 25px; display: block; margin: 0 auto; }
	.mine-shortcut-menu .shortcut-item span { display: block; line-height: 1.6; white-space: nowrap; overflow: hidden; text-align: center;text-overflow: ellipsis; font-size: 13px; color: #333; margin-top: 2px;}
	.shortcut-wrap .mine-shortcut-menu .shortcut-item span{margin-top: 8px;}
	.mine-shortcut-menu .shortcut-item span.number{font-size: 24px;display: div;span-align: center;color: #333;line-height: 1.2;}



	.qzyx-item{width: 94%;margin:0 auto;padding: 13px 0;}
	.qzyx-item image{display: div;width: 13px;height: 13px;}
	.qzyx-item .flex-con{font-size: 15px;color: #666;}
	.part{padding-left: 13px;background-color: #fff;margin-top: 10px;}
	.part-title{line-height: 47px;font-weight: bold;font-size: 15px;}
	.part-title .right-opera{padding: 0 13px;color: #777;}
	.part-title .right-opera image{display: inline-block;height: 12px;width: 12px;vertical-align: middle;margin-right: 3px;}
	.part-title .right-opera span{display: inline-block;vertical-align: middle;height: 47px;line-height: 47px;font-size: 13px;}

	.interview-progress{background-color: #fff;}
	.interview-progress .label-name{font-size: 15px;margin-bottom: 8px;}
	.progress-list{width: 96%;margin:0 auto;}
	.progress-item{padding:10px 0;position: relative;}
	.progress-item:before,.progress-item:after{content:'';position: absolute;left:0;width: 1px;background-color: #e1e1e1;top:0;height: 18px;}
	.progress-item:after{top:18px;bottom: 0;height: auto;}
	.progress-item:first-child:before{width: 0;}
	.progress-item:last-child:after{bottom: 35%;}
	.progress-item .circle{height: 8px;width: 8px;background-color: #0099f6;box-sizing: border-box;position: absolute;left:-3px;top:18px;z-index: 2;border-radius: 50%;}
	.progress-item .progress-detail{padding-left: 13px;}
	.progress-item .progress-detail span{display: div;line-height: 1.5;}
	.progress-item .progress-detail span.state{color: #333;}
	.progress-item .progress-detail span.time{color:#a9a9a9;font-size: 12px;}
	.progress-item .progress-detail span.desc{color:#999;font-size: 14px;line-height: 1.5;}
	.progress-item.active span.state{color: #0099f6; }
	.progress-item.active span.time{color: #0099f6; }
	.fold-hide{span-align: center;padding: 11px 0;width:97%;color: #0099f5;font-size: 14px;}
	.fold-hide image{display: inline-block;width: 10px;height: 10px;vertical-align: middle;position: relative;top:-1px;margin-left: 3px;}

	.personal-intro{color:#999;font-size: 14px;line-height: 1.5;display: div;padding: 8px 13px 13px 0;}
	.contact-box{padding:13px 13px 10px 0;font-size: 14px;color: #666;}
	.contact-box .contact-item{display: inline-block;vertical-align: middle;}
	.contact-box .contact-item image{display: inline-block;height: 20px;width: 20px;vertical-align: middle;margin-right: 3px;}
	.contact-box .contact-item span{display: inline-block;height: 20px;line-height: 20px;vertical-align: middle;}
		/* 底部操作 */
	.bottom-zhanwei{height: 50px;}
	.bottom-opera{position: fixed;left:0;bottom: 0;z-index: 10;background-color: #fff; width: 100%;}
	.bottom-opera .opera-item{padding: 4px 10px;min-width: 55px;box-sizing: border-box;position: relative;}
	.bottom-opera .opera-item button{position: absolute;left:0;top: 0;z-index: 1;width: 100%;height: 100%;margin:0;opacity: 0;}
	.bottom-opera .opera-item image{display: block;height: 20px;width: 20px;margin:3px auto 1px;}
	.bottom-opera .opera-item span{font-size: 12px;display: div;span-align: center;color: #666;}
	.opera-btn{background-color: #0099f5;color: #fff;font-size: 16px;span-align: center;height: 50px;line-height: 50px;position: relative;}
	.btn-hover{opacity: 0.9;}
	.opera-btn button{position: absolute;left:0;top: 0;z-index: 1;width: 100%;height: 100%;margin:0;opacity: 0;}

	.state-box{height: 100%;padding: 25% 0;color: #979797;box-sizing: border-box;}
	.state-box .icon-state{width: 90px;height: 90px;margin:15px auto;display: block;}
	.state-box .label{font-size: 15px;span-align: center;line-height: 1.5;}
	.state-box .sub-label{font-size: 14px;span-align: center;line-height: 1.5;}
	.state-box .result-label{width: 84%;border:1px solid #efefef; border-radius: 4px;margin:15px auto;box-sizing: border-box;padding: 13px 15px;font-size: 13px;}
	.state-box .appeal-btn{height: 39px;line-height: 40px;width: 105px;border-radius: 4px;color: #fff;span-align: center;margin:40px auto 10px;background-color: #19a8f1;font-size: 16px;}
</style>

<div class="resume-wrap" id="job-wrap" style="width: 750px; margin: auto;">
	<div class="userinfo-box flex-wrap">
		<div class="flex-con">
			<div class="user-name"><{$resume['ajr_name']}> <span><{$resume['age']}>岁</span></div>
			<div class="edit-tip">
				<{$categorySelect[$resume['ajr_cate2']]}> |
				<{$resume['ajr_work_years']}> |
				<{$resume['ajr_education']}>
			</div>
			<{if $resume['purposeCity']}>
			<div style="margin-top: 2px">
				意向城市：<{$resume['purposeCity']}>
			</div>
			<{/if}>
		</div>
		<div class="avatar-box">
			<img src="<{$resume['ajr_avatar']}>" class="avatar" >
			<{if $resume['ajr_gender'] == 0}>
			<img src="/public/wxapp/job/images/icon_male.png" class="icon-sex" >
			<{else}>
			<img src="/public/wxapp/job/images/icon_woman.png" class="icon-sex" >
			<{/if}>
		</div>
	</div>
	<{if $resume['ajr_work_type'] || $resume['ajr_salary'] || $resume['ajr_work_status'] || $resume['ajr_arrival_time']}>
	<div class="mine-shortcut-menu border-t" >
		<div class="shortcut-item">
			<img src="/public/wxapp/job/images/icon_quanzhi.png">
			<span><{$resume['ajr_work_type']}></span>
		</div>
		<div class="shortcut-item">
			<img src="/public/wxapp/job/images/icon_salary.png">
			<span><{$resume['ajr_salary']}></span>
		</div>
		<div class="shortcut-item">
			<img src="/public/wxapp/job/images/icon_quit.png">
			<span><{$resume['ajr_work_status']}></span>
		</div>
		<div class="shortcut-item">
			<img src="/public/wxapp/job/images/icon_time.png">
			<span><{$resume['ajr_arrival_time']}></span>
		</div>
	</div>
	<{/if}>
	<div class="part">
		<div class="part-title flex-wrap border-b">
			<div class="flex-con">个人描述</div>
		</div>
		<div class="contact-box">
			<div class="contact-item" style="margin-right:30px;">
				<img src="/public/wxapp/job/images/icon_tel.png" >
				<span style="position: relative;top: -15px;"><{$resume['ajr_mobile']}></span>
			</div>
			<{if $resume['ajr_email']}>
			<div class="contact-item">
				<img src="/public/wxapp/job/images/icon_email.png" >
				<span style="position: relative;top: -15px;"><{$resume['ajr_email']}></span>
			</div>
			<{/if}>
		</div>
		<{if $resume['ajr_desc']}>
		<span class="personal-intro"><{$resume['ajr_desc']}></span>
		<{/if}>
	</div>
	<{if $workExperience }>
	<div class="part" >
		<div class="part-title flex-wrap border-b">
			<div class="flex-con">工作经历</div>
		</div>
		<div class="interdiv-progress">
			<div class="progress-list">
				<{foreach $workExperience as $val}>
				<div>
					<div class="progress-item">
						<div class="circle"><span class="one"><span class="two"></span></span></div>
						<div class="progress-detail">
							<div class="flex-wrap">
								<div class="flex-con"><span class="state"><{$val['ajwe_position']}>/<{$val['ajwe_company']}></span></div>
							</div>
							<span class="time"><{date('Y-m-d', $val['ajwe_entry_time'])}> - <{if $val['ajwe_leave_time']}><{date('Y-m-d', $val['ajwe_leave_time'])}><{else}>至今<{/if}></span>
							<span class="desc" ><{$val['ajwe_duties']}></span>
						</div>
					</div>
				</div>
				<{/foreach}>
			</div>
		</div>
	</div>
	<{/if}>
	<{if $educationExperience }>
	<div class="part" >
		<div class="part-title flex-wrap border-b">
			<div class="flex-con">教育经历</div>
		</div>
		<div class="interdiv-progress">
			<div class="progress-list">
				<{foreach $educationExperience as $val}>
				<div>
					<div class="progress-item">
						<div class="circle"><span class="one"><span class="two"></span></span></div>
						<div class="progress-detail">
							<div class="flex-wrap">
								<div class="flex-con"><span class="state"><{$val['ajee_education']}>/<{$val['ajee_profession']}>/<{$val['ajee_school']}></span></div>
							</div>
							<span class="time"><{date('Y-m-d', $val['ajee_start_time'])}> - <{date('Y-m-d', $val['ajee_end_time'])}></span>
						</div>
					</div>
				</div>
				<{/foreach}>
			</div>
		</div>
	</div>
	<{/if}>
	<{if $objectExperience }>
	<div class="part" >
		<div class="part-title flex-wrap border-b">
			<div class="flex-con">项目经历</div>
		</div>
		<div class="interdiv-progress">
			<div class="progress-list">
				<{foreach $objectExperience as $val}>
				<div >
					<div class="progress-item">
						<div class="circle"><span class="one"><span class="two"></span></span></div>
						<div class="progress-detail">
							<div class="flex-wrap">
								<div class="flex-con"><span class="state"><{$val['ajoe_name']}></span></div>
							</div>
							<span class="time"><{date('Y-m-d', $val['ajoe_start_time'])}> - <{date('Y-m-d', $val['ajoe_end_time'])}></span>
							<span class="desc" ><{$val['ajoe_desc']}></span>
						</div>
					</div>
				</div>
				<{/foreach}>
			</div>
		</div>
	</div>
	<{/if}>
</div>




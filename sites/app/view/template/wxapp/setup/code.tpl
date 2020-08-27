<link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/css/code.css?11">
<style>
.tgl-light+.tgl-btn { background: #9a9a9a;  !important; }
.tgl-light:checked+.tgl-btn { background: #00CA4D;  !important; }
.audit-btn .tips { position: absolute; left: -15%; top: 102%; font-size: 14px; line-height: 1.5; background-color: #ffefc5; z-index: 2; padding: 12px; -webkit-box-shadow: 3px 3px 5px #ddd; -moz-box-shadow: 3px 3px 5px #ddd; -ms-box-shadow: 3px 3px 5px #ddd; box-shadow: 3px 3px 5px #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; -ms-border-radius: 4px; border-radius: 4px; display: none; width: 130%; margin-top: 10px; text-align: center;}
.audit-btn .tips:before { content: ''; position: absolute; left: 50%; top: -12px; height: 0; border-style: dashed dashed solid dashed; border-color: transparent transparent #ffefc5 transparent; z-index: 1; border-width: 6px; }
</style>
<{if $overdue == 'yes'}>
	<div class="alert alert-block alert-yellow " style="clear: both;">
		<div class="pull-right">
			<!--<a href="<{$auth_uri}>" class="btn btn-sm btn-green">重新授权</a>-->
			<a href="javascript:void(0)" onclick="openAuthuri(this,event)" data-authdomain="<{$authdomain}>" data-authtype="<{$authtype}>" data-authuri="<{$authcode}>" class="btn btn-sm btn-green">重新授权</a>

		</div>
		<div>
			重要提示：您授权的小程序已过期,更新代码、同步信息等功能将无法使用,请点击右侧按钮重新授权。
		</div>
	</div>
	<{/if}>
<{if $sys_notice && isset($sys_notice[0])}>
	<div class="alert alert-block alert-yellow" style="margin-bottom: 0;">
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
		<i class="icon-exclamation-sign"></i>
		[公告] (版本号 <{$sys_notice[0]['sn_version']}>) <{$sys_notice[0]['sn_title']}>
		<a target="_blank" href="/wxapp/index/noticeList">历史更新</a>
		<div class="update-content">
			<{$sys_notice[0]['sn_content']}>
		</div>
	</div>
	<{/if}>



<div class="version-manage">
	<div class="title-name">
		<h2>开发管理</h2>
		<!--
		<div class="btn-box audit-btn js_audit_tip" style="position:relative;float:right;">
			<a href="/wxapp/setup/auditVersion" class="btn btn-blue js_submit_check" style="float: right;">配置审核过渡版</a>
			<div class="tips">审核过渡版--顾名思义: 由于微信团队在对小程序版本迭代及内容审核时,加入严格的管制。开启此版本,可临时使用伪装版页面覆盖现有版本内容,以达到审核快速通过的目的。通过后,可关闭过渡版,将原有版本内容展现出来。</div>
		</div>
		-->
	</div>

	<div class="alert alert-block alert-success">
		<ol>
			<li>
				线上版本：表示小程序已上线，可在微信通过小程序名称进行搜索；
			</li>
			<li>
				审核版本：表示小程序已提交微信进行审核，审核周期为3-4天；
			</li>
			<li>
				体验版本：也称“预览”，小程序内容配置后可扫码预览；
			</li>
			<li>
				代码更新：小程序功能根据市场需求在不断迭代更新，一些新功能需要更新版本上线后可使用；
			</li>
		</ol>
	</div>

	<div class="version-item-box">
		<div class="code-version-title">
			<h3>线上版本</h3>
			<a href="javascript:;" onclick="pushUpgrade()" style="float: right">版本推送</a>
		</div>
		<{if $wxxcx_cfg['ac_base'] > 0}>
		<div class="code-version-con">
			<div class="code-version-left">
				<label class="simple_preview_label">版本号</label>
				<p class="simple_preview_value"><{$wxxcx_cfg['ac_version']}></p>
				<p><span class="status_tag success icon_after" data-toggle="modal" data-target="#xscodeModal">线上版本</span></p>
			</div>
			<div class="code-version-right">
				<div class="btn-box">
                    <!--
					<a href="#" class="btn btn-green">详情</a>
					<a href="#" class="btn btn-green js_drop_switch"><i class="icon-angle-down"></i></a>
					<div class="code-version-dropmenu">
						<a href="javascript:;">设置访问状态</a>
					</div>
					-->
					<div class="code-version-dropmenu">
						<a href="javascript:;" onclick="revertCodeRelease(this, event)">版本回退</a>
					</div>
				</div>
			</div>
			<div class="code-version-bd">
				<div class="simple_preview_item">
					<label class="simple_preview_label">应用名称</label>
					<p class="simple_preview_value"><{$wxxcx_cfg['ac_name']}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">到期时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_expire_time'])}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">应用简介</label>
					<p class="simple_preview_value"><{$wxxcx_cfg['ac_signature']}></p>
				</div>
			</div>
		</div>
		<{else}>
		<div>
			<p>尚未提交线上版本</p>
		</div>
		<{/if}>
	</div>
	<div class="version-item-box">
		<div class="code-version-title">
			<h3>审核版本</h3>
		</div>
        <{if $wxxcx_cfg['ac_audit_status'] > 0}>
		<div class="code-version-con">
			<div class="code-version-left">
				<label class="simple_preview_label">版本号</label>
				<p class="simple_preview_value"><{$wxxcx_cfg['ac_audit_version']}></p>
                <p><span class="status_tag info icon_after" data-toggle="modal" data-target="#scancodeModal">体验版<i class="icon_code_qrcode"></i></span></p>
			</div>
			<div class="code-version-right">
                <{if $wxxcx_cfg['ac_audit_status'] == 1}>
                <div class="btn-box">
                    <a href="javascript:void" class="btn btn-green js_submit_check" onclick="updateStatus(this)">更新审核状态</a>
					<a href="#" class="btn btn-green js_drop_switch"><i class="icon-angle-down"></i></a>
					<div class="code-version-dropmenu">
						<a href="javascript:;" onclick="confirmUndo(this, event)">撤回审核</a>
					</div>
                </div>
                <{elseif $wxxcx_cfg['ac_audit_status'] == 2}>
                <div class="btn-box">
                    <a href="javascript:void" class="btn btn-green js_submit_check" onclick="releaseCode(this)">发布上线</a>
					<!--
                    <a href="#" class="btn btn-green js_drop_switch"><i class="icon-angle-down"></i></a>
                    <div class="code-version-dropmenu">
                        <a href="javascript:;">取消发布</a>
                    </div>
                    -->
                </div>
                <{else}>
                <div>
                    <span>审核失败</span>
                </div>
                <{/if}>
			</div>
			<div class="code-version-bd">
				<{if $wxxcx_cfg['ac_audit_status'] == 1}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">审核状态</label>
					<p class="simple_preview_value">正在审核中</p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">提交时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_audit_time'])}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">审核ID</label>
					<p class="simple_preview_value"><{$wxxcx_cfg['ac_audit_id']}></p>
				</div>
				<{elseif $wxxcx_cfg['ac_audit_status'] == 2}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">审核状态</label>
					<p class="simple_preview_value">审核通过</p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">审核时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_audit_time'])}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">说明</label>
					<p class="simple_preview_value">请点击右侧发布上线</p>
				</div>
				<{else}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">审核状态</label>
					<p class="simple_preview_value">审核未通过</p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">审核时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_audit_time'])}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">原因描述</label>
					<p class="simple_preview_value"><{$wxxcx_cfg['ac_audit_reason']}></p>
				</div>
				<{/if}>
			</div>
		</div>
        <{else}>
        <div>
            <span>你暂无提交审核的版本或者版本已发布上线</span>
        </div>
        <{/if}>
	</div>

	<div class="version-item-box">
		<div class="code-version-title">
			<h3>体验版本</h3>
		</div>
		<div class="code-version-con">
			<div class="code-version-left">
				<{if $wxxcx_cfg['ac_experience_base'] > 0}>
				<label class="simple_preview_label">版本号</label>
				<p class="simple_preview_value"><{$wxxcx_cfg['ac_experience_version']}></p>
				<p><span class="status_tag info icon_after" data-toggle="modal" data-target="#scancodeModal">体验版<i class="icon_code_qrcode"></i></span></p>
				<{elseif $wxxcx_cfg['ac_audit_base'] > 0}>
				<label class="simple_preview_label">版本号</label>
				<p class="simple_preview_value"><{$wxxcx_cfg['ac_audit_version']}></p>
				<p><span class="status_tag info icon_after" data-toggle="modal" data-target="#scancodeModal">体验版<i class="icon_code_qrcode"></i></span></p>
				<{else}>
				<label class="simple_preview_label">无体验版</label>
				<{/if}>
			</div>
			<div class="code-version-right">  <!--如果审核版本和体验版都低于最新基本版本-->
				<{if $wxxcx_cfg['ac_audit_base'] < $wxxcx_app['base'] && $wxxcx_cfg['ac_experience_base'] < $wxxcx_app['base']}>
				<div class="btn-box">
					<a href="javascript:void" class="btn btn-green js_submit_check" onclick="updateEdition(this)">获取最新体验版</a>
				</div>
				<{else}>
				<div class="btn-box">
					<span>最新体验版本, 无需更新</span>
				</div>
				<{/if}>
			</div>
			<div class="code-version-bd">
				<div class="simple_preview_item">
					<label class="simple_preview_label">最新版本</label>
					<p class="simple_preview_value">当前代码库最新版本: <{$wxxcx_app['version']}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">体验说明</label>
					<p class="simple_preview_value">
						<{if $wxxcx_cfg['ac_audit_base'] < $wxxcx_app['base']}>
						您的小程序代码包非最新版本,请点击右侧获取最新体验版,以更新到最新代码包。
						<{else}>
						您的小程序代码包已是最新版本,请点击左侧体验版,以查看最新体验二维码。
						<{/if}>
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="version-item-box">
		<div class="code-version-title">
			<h3>代码更新</h3>
		</div>
        <div class="code-version-con" style="position: relative;min-height: 34px;">
            <div class="code-version-left">
                <label class="simple_preview_label">版本号</label>
                <p class="simple_preview_value"><{$wxxcx_app['version']}></p>
            </div>
            <{if $wxxcx_app['base'] > $wxxcx_cfg['ac_base']}>
			<div class="code-version-right">
				<div class="btn-box">
                    <{if $wxxcx_cfg['ac_audit_status'] == 0}>
                    <a href="#" class="btn btn-green js_submit_check" data-toggle="modal" data-target="#checkModal">更新代码并提交审核</a>
                    <{elseif $wxxcx_cfg['ac_audit_status'] == 1}>
                    <span>代码已提交, 正在审核中</span>
                    <{elseif $wxxcx_cfg['ac_audit_status'] == 2}>
                    <span>代码审核成功, 请发布上线</span>
                    <{else}>
                    <a href="#" class="btn btn-green js_submit_check" data-toggle="modal" data-target="#checkModal">重新提交审核</a>
                    <{/if}>
				</div>
			</div>
            <{else}>
            <div class="code-version-right">
                <div class="btn-box">
                    <span>最新版本, 无需更新</span>
                </div>
            </div>
            <{/if}>
			<div class="code-version-bd">
				<{if !$wxxcx_cfg['ac_name']}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">重要提示</label>
					<p class="simple_preview_value">
						<span style="color: #d81b1b;">小程序还未设置昵称、头像、简介。请先<a href="https://mp.weixin.qq.com" target="_blank">设置</a>完后再重新授权。</span><br>
						<span style="color: #d81b1b">未初始化的小程序将无法提交代码审核!</span>
					</p>
				</div>
				<{/if}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">行业名称</label>
					<p class="simple_preview_value"><{$wxxcx_app['name']}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">行业简介</label>
					<p class="simple_preview_value"><{$wxxcx_app['brief']}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">更新描述</label>
					<p class="simple_preview_value"><{$wxxcx_app['desc']}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">特别说明</label>
					<p class="simple_preview_value" style="color: red;">如果你设置过底部菜单,代码更新时将你设置的底部菜单一并提交审核,底部菜单样式可查看下方展示。</p>
				</div>
			</div>
		</div>
	</div>
	<{if $had_menu}>
	<div class="version-item-box" id="cdgx">
		<div class="code-version-title">
			<h3>菜单更新</h3>
		</div>
		<div class="code-version-con">
			<div class="code-version-left">
				<label class="simple_preview_label">自定义</label>
				<p class="simple_preview_value"><{if $wxxcx_cfg['ac_bottom_menu']}><span style="color: #0B8E00;">是</span><{else}><span style="color: red;">否</span><{/if}></p>
			</div>
			<div class="code-version-right">
				<div class="btn-box">
					<{if $wxxcx_cfg['ac_audit_status'] == 0}>
					<a href="#" class="btn btn-green js_submit_check" data-toggle="modal" data-target="#checkModal">更新代码并提交审核</a>
					<{elseif $wxxcx_cfg['ac_audit_status'] == 1}>
					<span>代码已提交, 正在审核中</span>
					<{elseif $wxxcx_cfg['ac_audit_status'] == 2}>
					<span>代码审核成功, 请发布上线</span>
					<{else}>
					<a href="#" class="btn btn-green js_submit_check" data-toggle="modal" data-target="#checkModal">重新提交审核</a>
					<{/if}>
				</div>
			</div>
			<div class="code-version-bd">
				<{if $wxxcx_cfg['ac_bottom_time']}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">最新修改时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_bottom_time'])}></p>
				</div>
				<{/if}>
				<{if $wxxcx_cfg['ac_audit_time']}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">上次审核时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_audit_time'])}></p>
				</div>
				<{/if}>
				<div class="simple_preview_item">
					<label class="simple_preview_label" style="line-height: 58px;">底部菜单</label>
					<div class="simple_preview_value">
						<div class="bottom-menu-box">
							<div class="bottom-menu-opera">
								<{if $bottom}>
								<div class="bottom-menu">
									<{foreach $bottom as $item}>
									<div class="bottom-menu-item">
										<img src="/public/wxapp/icon/<{$item['iconPath']}>" alt="图标">
										<p><{$item['text']}></p>
									</div>
									<{/foreach}>
								</div>
								<{/if}>
								<div class="modify-box">
									<a href="/wxapp/setup/bottomMenu" class="btn btn-sm btn-green">前往配置</a>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">特别说明</label>
					<{if $wxxcx_cfg['ac_bottom_menu']}>
					<p style="color: red;margin:0">当前底部tab栏, 提交上线将使用此菜单形式, 点击上方按钮可修改。</p>
					<{else}>
					<p style="color: red;margin:0">您尚未添加底部tab栏, 提交上线将使用如上显示的默认菜单, 点击上方按钮可修改。</p>
					<{/if}>
				</div>
			</div>
		</div>
	</div>
	<{else}>
	<div class="version-item-box" id="cdgx">
		<div class="code-version-title">
			<h3>自定义更新</h3>
		</div>
		<div class="code-version-con">
			<div class="code-version-left">
			</div>
			<div class="code-version-right">
				<div class="btn-box">
					<{if $wxxcx_cfg['ac_audit_status'] == 0}>
					<a href="#" class="btn btn-green js_submit_check" data-toggle="modal" data-target="#checkModal">更新代码并提交审核</a>
					<{elseif $wxxcx_cfg['ac_audit_status'] == 1}>
					<span>代码已提交, 正在审核中</span>
					<{elseif $wxxcx_cfg['ac_audit_status'] == 2}>
					<span>代码审核成功, 请发布上线</span>
					<{else}>
					<a href="#" class="btn btn-green js_submit_check" data-toggle="modal" data-target="#checkModal">重新提交审核</a>
					<{/if}>
				</div>
			</div>
			<div class="code-version-bd">
				<{if $wxxcx_cfg['ac_audit_time']}>
				<div class="simple_preview_item">
					<label class="simple_preview_label">上次审核时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_audit_time'])}></p>
				</div>
				<{/if}>
			</div>
		</div>
	</div>
	<{/if}>
</div>

<!-- 审核模态框（Modal） -->
<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="checkModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 620px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="checkModalLabel">
					小程序提交审核配置
				</h4>
			</div>
			<div class="modal-body">
				<div class="check-setting-wrap">
					<div class="check-info" style="margin-bottom: 15px;">
						<div class="simple_preview_item">
							<label class="simple_preview_label">首页名称:</label>
							<div class="input-right">
								<input type="text" id="wxapp_title" value="<{$wxxcx_cfg['ac_name']}>" class="form-control" placeholder="请输入小程序名称">
							</div>
						</div>
						<div class="simple_preview_item">
							<label class="simple_preview_label">搜索标签:</label>
							<div class="input-right">
								<input type="text" id="wxapp_tag" value="<{$wxxcx_cfg['ac_name']}>" class="form-control" placeholder="请输入小程序搜索标签">
							</div>
							<p style="color: #9a9a9a;">标签用空格分开，填写与小程序功能相关的标签，更容易被搜索</p>
						</div>
						<div class="simple_preview_item">
							<div class="check-box">
								<span>
									<input type="checkbox" id="checkpass" checked>
									<label for="checkpass">审核通过时，自动发布上线</label>
								</span>
							</div>
						</div>
					</div>
					<!--
					<h4 class="title-name">导航栏相关配置</h4>
					<div class="nav-setting-box">
						<div class="simple_preview_item">
							<label class="simple_preview_label">文字内容:</label>
							<div class="input-right">
								<input type="text" id="wxapp_navtit" value="<{$wxxcx_cfg['ac_name']}>" class="form-control" placeholder="请输入导航标题">
							</div>
						</div>
						<div class="simple_preview_item">
							<label class="simple_preview_label">背景颜色:</label>
							<div class="input-right">
								<input type="text" class="form-control" value="#ffffff" id="navbg-color">
							</div>
						</div>
						<div class="simple_preview_item">
							<label class="simple_preview_label">文字颜色:</label>
							<div class="input-right">
								<div class="radio-box" style="padding: 5px 0 4px;">
								    <span>
										<input type="radio" name="textcolor" id="blackTxt" value="0" checked>
										<label for="blackTxt">黑</label>
									</span>
									<span>
										<input type="radio" name="textcolor" value="1" id="whiteTxt">
										<label for="whiteTxt">白</label>
									</span>
								</div>
							</div>
						</div>
					</div>
					-->
				</div>
				<div class="bottom-opera-box text-center" style="margin-top: 25px">
					<{if in_array($wxxcx_cfg['ac_type'],array(6,26,27,28,34,35))}>
					<span class="btn btn-green" onclick="newSubmitCode(this)">
					<{else}>
					<span class="btn btn-green" onclick="submitCode(this)">
					<{/if}>

						更新代码并提交审核
					</span>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!-- 线上版本 -->
<div class="modal fade" id="xscodeModal" tabindex="-1" role="dialog" aria-labelledby="xscodeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="xscodeModalLabel">
					扫码访问线上版本
				</h4>
			</div>
			<div class="modal-body">
				<div class="sacan-code-box text-center" style="margin-bottom: 15px;">
					<p>扫描下方小程序码即可访问线上版本</p>
					<div class="code_qrcode">
		                <div class="pic_code_qrcode_wrp">
		                    <img class="pic_code_qrcode" src="<{$wxxcx_cfg['ac_wxacode']}>" id="pic_code_qrcode" alt="二维码">
		                </div>
		                <strong class="code_qrcode_title"><{$wxxcx_cfg['ac_name']}>线上版本</strong>
		            </div>
					<div class="btn-box" style="margin-top: 15px;">
						<a href="/wxapp/setup/downloadQrcode" class="btn btn-green js_submit_check">下载小程序码</a>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!-- 审核模态框（Modal） -->
<div class="modal fade" id="scancodeModal" tabindex="-1" role="dialog" aria-labelledby="scancodeModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 620px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="scancodeModalLabel">
					扫码访问体验版
				</h4>
			</div>
			<div class="modal-body">
				<div class="sacan-code-box text-center">
					<p>管理员及体验者可扫描下方二维码即可体验体验版</p>
					<div class="code_qrcode">
		                <div class="pic_code_qrcode_wrp">
		                    <img class="pic_code_qrcode" src="/wxapp/setup/fetchQrcode" id="pic_code_qrcode" alt="二维码">
		                </div>
		                <strong class="code_qrcode_title"><{$wxxcx_cfg['ac_name']}>体验版</strong>
		            </div>
					<div class="btn-box">
						<a href="javascript:void" class="btn btn-green js_submit_check" onclick="openBind(this, event)">绑定新体验者</a>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<!-- 绑定体验者 -->
<div class="modal fade" id="bindUserModal" tabindex="-1" role="dialog" aria-labelledby="bindUserModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 300px;padding-top: 18%;">
		<div class="modal-content">
			<div class="modal-header" style="padding:10px 15px;">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top: -8px;margin-right: -5px;">
					&times;
				</button>
				<h4 class="modal-title" id="bindUserModalLabel" style="font-size: 16px;">
					请输入需要绑定的微信号
				</h4>
			</div>
			<div class="modal-body">
				<div class="user-wechat">
					<input type="text" id="wechatid" value="" class="form-control">
					<div class="text-right" style="margin-top: 15px;">
						<span class="btn btn-sm btn-blue" onclick="confirmBind(this, event)">确定</span>
						<span class="btn btn-sm" data-dismiss="modal" aria-hidden="true">取消</span>
					</div>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/color-spectrum/spectrum.js"></script>
<script>
	$(function(){
		// 更多操作菜单
		$(".btn-box").on('click', '.js_drop_switch', function(event) {
			var isShow = $(this).next().css("display");
			if(isShow=='none'){
				$(this).next().stop().show();
			}
		});
		$('body').on('click', function(event) {
			$(".btn-box").find('.code-version-dropmenu').stop().hide();
		});
		$('body').on('click', '.js_drop_switch,.code-version-dropmenu', function(event) {
			event.stopPropagation();
		});

		$("#navbg-color").spectrum({
	    	color: "#f8f8f8",
	    	showButtons: false,
	    	showInitial: true,
	    	showPalette: true,
	    	showSelectionPalette: true,
	    	maxPaletteSize: 10,
	    	preferredFormat: "hex",
	    	move: function (color) {
	    	    var realColor = color.toHexString();
	    	    console.log(realColor);
	    	},
	    	palette: [
	    	    ['black', 'white', 'blanchedalmond',
	    	            'rgb(255, 128, 0);', '#6bc86b'],
	    	    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
	    	]
	    	    
	    });
	    // 审核提示显示隐藏
	    $(".js_audit_tip").hover(function() {
	    	$(this).find('.tips').stop().fadeIn();
	    }, function() {
	    	$(this).find('.tips').stop().fadeOut();
	    });
	});

    function submitCode(obj) {
        var data = getSubmitData();
        if(data){
            $('#checkModal').hide();
            var index = layer.load(2, {time: 10*1000});
            $.ajax({
                type    : 'post',
                url     : '/wxapp/setup/submitCode',
                data    : data,
                dataType: 'json',
                success : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        layer.msg('代码已更新并提交审核成功', {
                            time: 0 //不自动关闭
                            ,btn: ['确定']
                            ,yes: function(index){
                                layer.close(index);
                                location.reload();
                            }
                        });
                    }else{
                    	if (ret.err == 61023) {
							layer.msg('小程序授权已过期,需要重新授权？', {
								time: 0 //不自动关闭
								,btn: ['重新授权', '暂不授权']
								,yes: function(index){
									layer.close(index);
									location.replace('/wxapp/setup/index');
								}
							});
						} else {
							layer.msg('错误代码：'+ret.err+' 错误信息：'+ret.em);
						}
                    }
                }
            });
        }
    }

    function getSubmitData(){
        var wxapp_title     = $('#wxapp_title').val();
        var wxapp_tag       = $('#wxapp_tag').val();
		var wxapp_auto		= $('#checkpass').prop("checked");

        if(!wxapp_title){
            layer.msg('请输入小程序名称');
            return false;
        }

        if(!wxapp_tag){
            layer.msg('请输入小程序标签');
            return false;
        }

        return {
            'wxapp_title'   : wxapp_title,
            'wxapp_tag'     : wxapp_tag,
			'wxapp_auto'	: wxapp_auto ? 1 : 0
        };
    }

    function releaseCode(obj) {
        event.preventDefault();
        var index = layer.load(2, {time: 10*1000});
        $.ajax({
            type    : 'post',
            url     : '/wxapp/setup/releaseCode',
            data    : '',
            dataType: 'json',
            success : function(ret){
                layer.close(index);
                if(ret.ec == 200){
					layer.msg('发布上线成功', {
						time: 0 //不自动关闭
						,btn: ['确定']
						,yes: function(index){
							layer.close(index);
							location.reload();
						}
					});
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function updateStatus(obj) {
        event.preventDefault();
        var index = layer.load(2, {time: 10*1000});
        $.ajax({
            type    : 'post',
            url     : '/wxapp/setup/updateStatus',
            data    : '',
            dataType: 'json',
            success : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    layer.msg(ret.data, {
                        time: 0 //不自动关闭
                        ,btn: ['确定']
                        ,yes: function(index){
                            layer.close(index);
                            location.reload();
                        }
                    });
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function updateEdition(obj) {
		event.preventDefault();
		var index = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/setup/editionCode',
			data    : '',
			dataType: 'json',
			success : function(ret){
				layer.close(index);
				if(ret.ec == 200){
					layer.msg('已更新到最新体验版本', {
						time: 0 //不自动关闭
						,btn: ['确定']
						,yes: function(index){
							layer.close(index);
							location.reload();
						}
					});
				}else{
					layer.msg(ret.em);
				}
			}
		});
	}

    function openBind(obj, event) {
		event.preventDefault();
		$("#bindUserModal").modal('show');
	}

	function closeBindModel() {
		$("#bindUserModal").modal('hide');
	}

	function confirmBind(obj, event) {
		var wechatid	= $('#wechatid').val();
		if (wechatid.length > 0) {
			console.log(wechatid);
			closeBindModel();
			var index = layer.load(2, {time: 10*1000});
			$.ajax({
				type    : 'post',
				url     : '/wxapp/setup/bindTester',
				data    : {
					'wechatid' : wechatid
				},
				dataType: 'json',
				success : function(ret){
					layer.close(index);
					if(ret.ec == 200){
						layer.msg('体验者绑定成功');
					}else{
						layer.msg(ret.em);
					}
				}
			});
		}
	}

	function confirmUndo(obj, event) {
		event.preventDefault();
		layer.confirm('每天撤回次数最多1次，每月最多10次，确定撤回?', {
			btn: ['确定','取消'] //按钮
		}, function(){
			var index = layer.load(2, {time: 10*1000});
			$.ajax({
				type    : 'post',
				url     : '/wxapp/setup/undoCode',
				data    : '',
				dataType: 'json',
				success : function(ret){
					layer.close(index);
					if(ret.ec == 200){
						layer.msg('撤回审核成功');
						location.reload();
					}else{
						layer.msg(ret.em);
					}
				}
			});
		});
	}
    function revertCodeRelease(obj, event) {
        event.preventDefault();
        layer.confirm('版本回退将会退到上一个版本?', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var index = layer.load(2, {time: 10*1000});
            $.ajax({
                type    : 'post',
                url     : '/wxapp/setup/revertCodeRelease',
                data    : '',
                dataType: 'json',
                success : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        layer.msg('回退成功');
                        location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });
    }
	// 重新授权
    function openAuthuri(obj, event) {
        event.preventDefault();
        var type 	= $(obj).data('authtype');
        var authcode= $(obj).data('authuri');
        var domain	= $(obj).data('authdomain');
        if (type == 'domain') {
            window.open(authcode);
        } else {
            window.open(domain+"/manage/user/center?loginid="+authcode);
        }
    }

    function pushUpgrade() {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
				'type'  : 'post',
				'url'   : '/wxapp/tplpush/upgradePush',
				'dataType' : 'json',
				success : function(ret){
					layer.msg(ret.em,{
						time: 2000, //2s后自动关闭
					},function(){
						if(ret.ec == 200){
							window.location.reload();
						}
					});
				}
			});
        }, function(){

        });
    }

    function newSubmitCode(obj) {
        var data = getSubmitData();
        if(data){
            $('#checkModal').hide();
            var index = layer.load(2, {time: 10*1000});
            $.ajax({
                type    : 'post',
                url     : '/wxapp/setup/submitAudit',
                data    : data,
                dataType: 'json',
                success : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        // '代码已更新并提交审核成功'
                        layer.msg(ret.em, {
                            time: 0 //不自动关闭
                            ,btn: ['确定']
                            ,yes: function(index){
                                layer.close(index);
                                location.reload();
                            }
                        });
                    }else{
                        if (ret.err == 61023) {
                            layer.msg('小程序授权已过期,需要重新授权？', {
                                time: 0 //不自动关闭
                                ,btn: ['重新授权', '暂不授权']
                                ,yes: function(index){
                                    layer.close(index);
                                    location.replace('/wxapp/setup/index');
                                }
                            });
                        } else {
                            layer.msg('错误代码：'+ret.err+' 错误信息：'+ret.em);
                        }
                    }
                }
            });
        }
    }
</script>
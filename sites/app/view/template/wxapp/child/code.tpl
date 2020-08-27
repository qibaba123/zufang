<link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/css/code.css?1">
<div class="version-manage">
	<div class="title-name">
		<h2>开发管理</h2>
	</div>
	<div class="version-item-box">
		<div class="code-version-title">
			<h3>线上版本</h3>
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
				</div>
			</div>
			<div class="code-version-bd">
				<div class="simple_preview_item">
					<label class="simple_preview_label">应用名称</label>
					<p class="simple_preview_value"><{$wxxcx_cfg['ac_name']}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">到期时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_first['ac_expire_time'])}></p>
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
					<{if $wxxcx_cfg['ac_audit_id'] eq -1}>
					<a href="#" class="btn btn-green js_drop_switch"><i class="icon-angle-down"></i></a>
					<div class="code-version-dropmenu">
						<a href="javascript:;" onclick="quitVerify(this, event)">取消审核</a>
					</div>
					<{/if}>
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
			<h3>代码更新</h3>
		</div>
        <div class="code-version-con">
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

	<div class="version-item-box" id="cdgx">
		<div class="code-version-title">
			<h3>菜单更新</h3>
		</div>
		<div class="code-version-con">
			<div class="code-version-left">
				<label class="simple_preview_label">自定义菜单</label>
				<p class="simple_preview_value" style="text-align: center;"><{if $wxxcx_first['ac_bottom_menu']}><span style="color: #0B8E00;">是</span><{else}><span style="color: red;">否</span><{/if}></p>
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
				<div class="simple_preview_item">
					<label class="simple_preview_label">最新修改时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_first['ac_bottom_time'])}></p>
				</div>
				<div class="simple_preview_item">
					<label class="simple_preview_label">上次审核时间</label>
					<p class="simple_preview_value"><{date('Y-m-d H:i:s', $wxxcx_cfg['ac_audit_time'])}></p>
				</div>
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
					<{if $wxxcx_first['ac_bottom_menu']}>
					<p style="color: red;margin:0">当前底部tab栏, 提交上线将使用此菜单形式, 点击上方按钮可修改。</p>
					<{else}>
					<p style="color: red;margin:0">您尚未添加底部tab栏, 提交上线将使用如上显示的默认菜单, 点击上方按钮可修改。</p>
					<{/if}>
				</div>
			</div>
		</div>
	</div>
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
					审核配置
				</h4>
			</div>
			<div class="modal-body">
				<div class="check-setting-wrap">
					<div class="check-info" style="margin-bottom: 15px;">
						<div class="simple_preview_item">
							<label class="simple_preview_label">名称:</label>
							<div class="input-right">
								<input type="text" id="wxapp_title" value="<{$wxxcx_cfg['ac_name']}>" class="form-control" placeholder="请输入小程序名称">
							</div>
						</div>
						<div class="simple_preview_item">
							<label class="simple_preview_label">标签:(每个标签最多6个字)</label>
							<div class="input-right">
								<input type="text" id="wxapp_tag" value="<{$wxxcx_cfg['ac_name']}>" class="form-control" placeholder="请输入小程序标签，以便别人更好的查找到您的小程序，|隔开以输入更多便签">
							</div>
						</div>
						<div class="simple_preview_item">
							<div class="check-box" style="padding-left: 70px">
								<span>
									<input type="checkbox" id="checkpass" checked>
									<label for="checkpass">审核通过时，自动发布上线</label>
								</span>
							</div>
						</div>
					</div>
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
				</div>
				<div class="bottom-opera-box text-center" style="margin-top: 25px">
					<span class="btn btn-green" onclick="submitCode(this)">
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
						<a href="/wxapp/child/downloadQrcode/appid/<{$wxxcx_cfg['ac_appid']}>" class="btn btn-green js_submit_check">下载小程序码</a>
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
		                    <img class="pic_code_qrcode" src="/wxapp/child/fetchQrcode/appid/<{$wxxcx_cfg['ac_appid']}>" id="pic_code_qrcode" alt="二维码">
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
	var appid	= "<{$wxxcx_cfg['ac_appid']}>";
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
	});

    function submitCode(obj) {
        var data = getSubmitData();
        if(data){
            $('#checkModal').hide();
            var index = layer.load(2, {time: 10*1000});
            $.ajax({
                type    : 'post',
                url     : '/wxapp/child/submitCode',
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
                        layer.msg(ret.em);
                    }
                }
            });
        }
    }

    function getSubmitData(){
        var wxapp_title     = $('#wxapp_title').val();
        var wxapp_tag       = $('#wxapp_tag').val();
        var wxapp_navtit    = $('#wxapp_navtit').val();
        var wxapp_navclr    = $('#navbg-color').val();
        var wxapp_navbg     = $("input[name='textcolor']:checked").val();
		var wxapp_auto		= $('#checkpass').prop("checked");

        if(!wxapp_title){
            layer.msg('请输入小程序名称');
            return false;
        }

        if(!wxapp_tag){
            layer.msg('请输入小程序标签');
            return false;
        }

        if(!wxapp_navtit){
            layer.msg('请输入小程序首页导航栏标题');
            return false;
        }

        return {
        	'appid'			: appid,
            'wxapp_title'   : wxapp_title,
            'wxapp_tag'     : wxapp_tag,
            'wxapp_navtit'  : wxapp_navtit,
            'wxapp_navclr'  : wxapp_navclr,
            'wxapp_navbg'   : wxapp_navbg,
			'wxapp_auto'	: wxapp_auto ? 1 : 0
        };
    }

    function releaseCode(obj) {
        event.preventDefault();
        var index = layer.load(2, {time: 10*1000});
        $.ajax({
            type    : 'post',
            url     : '/wxapp/child/releaseCode',
            data    : 'appid='+appid,
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
    
    function quitVerify(obj, event) {
		event.preventDefault();
		var index = layer.load(2, {time: 10*1000});
		$.ajax({
			type    : 'post',
			url     : '/wxapp/child/quitVerify',
			data    : 'appid='+appid,
			dataType: 'json',
			success : function(ret){
				layer.close(index);
				if(ret.ec == 200){
					layer.msg('审核已取消', {
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
            url     : '/wxapp/child/updateStatus',
            data    : 'appid='+appid,
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
				url     : '/wxapp/child/bindTester',
				data    : {
					'appid' 	: appid,
					'wechatid' 	: wechatid
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
</script>
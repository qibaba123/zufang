<style>
.list-box-wrap { padding: 10px 0; }
.list-box { background-color: #fff; box-shadow: 1px 1px 5px #ddd; border-radius: 3px; }
.list-box table { border: 1px solid #E6E7EC; }
.list-box table thead td { padding: 12px 8px; background-color: #EBEEF0; color: #555}
.list-box table tbody td { border: none; border-top: 1px solid #E6E7EC; color: #555; font-size: 14px; line-height: 1.5; white-space: normal; padding: 10px; }
.list-box .img-text { overflow: hidden; }
.list-box .imgavatar { height: 90px; width: 90px; float: left; }
.list-box table tbody .right-info { margin-left: 100px; max-width: 500px; }
.list-box table tbody .right-info h4 { margin: 0; font-size: 16px; color: #333; margin: 10px 0; }
.list-box table tbody .right-info p{color: #c3c3c3;}
.list-box table tbody td .time { color: #333; }
.list-box table li { list-style: disc; }
.list-box a { color: #3292ff; }
.list-box a:hover { color: blue; }
.bubble_tips { display: inline-block; vertical-align: middle; position: relative; color: #c1c2c3; }
.bubble_left { margin-left: 6px; }
.mass_send_tips { color: #9e9f9f; margin: 0; }
.bubble_tips_inner { padding: 5.5px 12px; border: 1px solid #e6e7ec; line-height: 21px; background-color: #fff; word-wrap: break-word; word-break: break-all; }
.bubble_tips_arrow { position: absolute; top: 50%; margin-top: -6px; display: inline-block; width: 0; height: 0; border-width: 6px; border-style: dashed; border-color: transparent; border-left-width: 0; border-right-color: #fff; border-right-style: solid; }
.bubble_left .bubble_tips_arrow.out { border-right-color: #e6e7ec; left: -6px; }
.bubble_left .bubble_tips_arrow.in { left: -5px; }
</style>
<div class="alert alert-block alert-success" style="line-height: 20px;">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <p>说明：分身小程序就是内容跟原主体的小程序一模一样，不用再填充内容，可以支付、交易。是为了帮助有的商家只想制作填充一个小程序做引流。分身小程序需要在原主体的小程序上订购开通。</p>
    <p>开通方式：服务商后台->商户管理->分身数量点击增加。开通后把注册的小程序授权进来，配置下支付后即可提交审核。</p>
</div>
<div class="list-box-wrap">
	<div class="opera-btn" style="margin-bottom: 15px">
		<a href="javascript:void(0)" onclick="startAuth(this, event)" data-surplus="<{$surplus}>" class="btn btn-md btn-green">授权接入分身小程序</a>
		<div class="bubble_tips bubble_left">
		    <div class="bubble_tips_inner">
		        <p class="mass_send_tips" id="tips">还可授权接入<{$surplus}>个分身小程序</p>
		    </div>
		    <i class="bubble_tips_arrow out"></i>
		    <i class="bubble_tips_arrow in"></i>
		</div>
	</div>
	<div class="list-box">
		<table class="table">
			<thead>
				<tr>
					<td>分身小程序</td>
					<td>权限集</td>
					<td>授权属性</td>
					<td>操作</td>
				</tr>
			</thead>
			<tbody>
                <{if $list}>
                <{foreach $list as $item}>
                    <tr>
                        <td>
                            <div class="img-text">
                                <img src="<{$item['ac_logo']}>" class="imgavatar" alt="logo">
                                <div class="right-info">
                                    <h4><{$item['ac_name']}></h4>
                                    <p><{$item['ac_signature']}></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <{$item['scope_desc']}>
                        </td>
                        <td>
                            <ul>
                                <li>APPID: <{$item['ac_appid']}></li>
                                <li>授权状态:<{if $item['ac_auth_status']}>已授权<{else}>未授权<{/if}></li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <{if $item['ac_auth_status']}>
                                <li><a href="/wxapp/child/code/appid/<{$item['ac_appid']}>">代码管理</a></li>
                                <li><a href="/wxapp/child/setup/appid/<{$item['ac_appid']}>">开发设置</a></li>
                                <{/if}>
                                <li><a href="/wxapp/child/grantAuth/appid/<{$item['ac_appid']}>">重新授权</a></li>
                                <li><a href="javascript:void(0)" onclick="stopAuth(this, event)" data-appid="<{$item['ac_appid']}>">解除应用</a></li>
                                <li><a href="/wxapp/child/payCfg/id/<{$item['ac_id']}>">支付配置</a></li>
                            </ul>
                        </td>
                    </tr>
                <{/foreach}>
                <{else}>
                    <tr>
                        <td colspan="4">暂无接入任何分身小程序</td>
                    </tr>
                <{/if}>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function stopAuth(obj, event) {
        event.preventDefault();
        layer.msg('停止授权将该账号从分身小程序列表中删除,但不会清除已占用名额,请谨慎操作？', {
            time: 0 //不自动关闭
            ,btn: ['停止授权', '再想想']
            ,yes: function(index){
                layer.close(index);
                var loading = layer.load(2, {time: 10*1000});
                var appid   = $(obj).data('appid');
                $.ajax({
                    type    : 'post',
                    url     : '/wxapp/child/stopAuth',
                    data    : {
                        'appid' 	: appid
                    },
                    dataType: 'json',
                    success : function(ret){
                        layer.close(loading);
                        if(ret.ec == 200){
                            layer.msg('停止授权成功');
                            location.reload();
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }
        });
    }

    function startAuth(obj, event) {
        event.preventDefault();
        var surplus = parseInt($(obj).data('surplus'));
        if (surplus > 0) {
            location.assign('/wxapp/child/grantAuth');
        } else {
            layer.msg('您目前可授权接入的分身小程序数量为0,请联系您的服务商已增加更多可授权分身小程序数量。', {
                time: 20000, //20s后自动关闭
                btn: ['明白了']
            });
        }
    }
</script>
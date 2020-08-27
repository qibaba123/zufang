<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }
</style>
<div id="content-con">
    <div  id="mainContent">
        <div class="authorize-tip flex-wrap">
            <div class="shop-logo">
                <img src="/public/wxapp/setup/images/xcx_nav.png" alt="logo">
            </div>
            <div class="flex-con">
                <h4>打开同一公众号下关联的另一个小程序</h4>
                <p class="state" style="color: #999;">
                    <span>注意: 只有同一公众号下的关联的小程序之间才可相互跳转 <a href="https://mp.weixin.qq.com/debug/wxadoc/introduction/#%E5%85%AC%E4%BC%97%E5%8F%B7%E5%85%B3%E8%81%94%E5%B0%8F%E7%A8%8B%E5%BA%8F" target="_blank">详情</a></span>
                </p>
                <p class="state" style="color: #999;">
                    <span>注意: 公众号可关联同主体的10个小程序及不同主体的3个小程序。当前小程序和要跳转的小程序必须同时关联到同一公众号下。</span>
                </p>
            </div>
            <div>
                <a href="/wxapp/setup/addJump" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 添加关联小程序</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                        	<th>小程序logo</th>
                            <th>小程序名称</th>
                            <th>小程序APPID</th>                            
                            <th>小程序简介</th>
                            <!--
                            <th>小程序背景图</th>
                            -->
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['aj_id']}>">
                            	<td><{if $val['aj_logo']}><img src="<{$val['aj_logo']}>" width="60" height="60" alt="封面图" style="border-radius:4px;"><{/if}></td>
                                <td><{$val['aj_name']}></td>
                                <td><{$val['aj_appid']}></td>                                
                                <td><{$val['aj_brief']}></td>
                                <!--
                                <td><{if $val['aj_background']}><img src="<{$val['aj_background']}>" width="150px" height="72px" alt="封面图"><{/if}></td>
                                -->
                                <td><{if $val['aj_create_time']}><{date('Y-m-d H:i',$val['aj_create_time'])}><{/if}></td>
                                <td class="jg-line-color">
                                    <a href="/wxapp/setup/addJump/id/<{$val['aj_id']}>" >编辑</a> - 
                                    <a href="#" id="delete-confirm" data-id="<{$val['aj_id']}>" onclick="deleteJump('<{$val['aj_id']}>')" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                            <{if $pageHtml}>
                            <tr><td colspan="7"><{$pageHtml}></td></tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function deleteJump(id) {
        console.log(id);
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(2,
	            {
	                shade: [0.1,'#333'],
	                time: 10*1000
	            }
	        );
	        $.ajax({
	            'type'   : 'post',
	            'url'   : '/wxapp/setup/deleteJump',
	            'data'  : { id:id},
	            'dataType'  : 'json',
	            'success'  : function(ret){
	                layer.close(load_index);
	                layer.msg(ret.em);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }
	            }
	        });
        });
    }
</script>

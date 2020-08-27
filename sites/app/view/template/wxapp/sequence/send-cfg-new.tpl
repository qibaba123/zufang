<link href="/public/plugin/layui2/css/layui.css" rel="stylesheet" type="text/css"></link>
<link href="/public/wxapp/sequence/css/card.css" rel="stylesheet" type="text/css"></link>
<style type="text/css">
	.width800 {
	    width: 800px!important;
	}
	.layui-form-label{
		width: 135px;
	}
</style>
<script src="/public/plugin/layui2/layui.js" type="text/javascript">
</script>
<form class="layui-form" lay-filter="form" action="">
	<div class="container_docker">
		<!-- 配送时间设置 -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">配送时间设置</h4>
                <div ckass="card-content">
                    <div class="layui-form-item">
                        <label class="layui-form-label">开始配送/发货时间：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="sequenceDay" name='sequenceDay'  placeholder="不填或填0则默认为当天自取/配送" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_sequence_day']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>天 &nbsp;&nbsp;<small>*不填或填0则默认为当天自取/配送</small></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">配送/发货延后时间：</label>
                        <div class="layui-input-inline width500">
                            <select id="sequenceDaytime" name='sequenceDaytime' lay-filter="send-time" value="<{if $sendCfg}><{$sendCfg['acs_sequence_daytime']}><{/if}>">
			                    <option value="">不设置</option>
			                    <{foreach $dayTime as $val}>
			                        <option value="<{$val}>" <{if $val eq $sendCfg['acs_sequence_daytime']}>selected<{/if}> ><{$val}></option>
			                    <{/foreach}>
			                </select>
                        </div>
                        <div class='layui-form-mid layui-word-aux'><small>当天在设置的时间后下单，配送/发货时间将延后一天</small> </div>
                    </div>
                </div>
            </div>
        </div>
	    <!-- 商家配送设置 -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">商家配送设置</h4>
                <div ckass="card-content">
                	<div class='layui-form-item'>
                		<label class="layui-form-label">商家配送状态：</label>
                		<div class="layui-input-inline width500">
	                		<input type="checkbox" name="send" lay-skin="switch" lay-filter='switch' lay-text="ON|OFF" value="1"  <{if $sendCfg && $sendCfg['acs_send']}> checked<{/if}> >
	                	</div>
                	</div>
                	<div class='layui-form-item'>
                		<label class="layui-form-label">商家配送排序：</label>
                		<div class="layui-input-inline width500">
	                		<input type="text" name="sendSort" placeholder="" autocomplete="off" class="layui-input" value="<{$sendCfg['acs_send_sort']}>" oninput="if(value.length>2)value=value.slice(0,2)"> 
	                	</div>
                	</div>
                	<div class="layui-form-item">
                        <label class="layui-form-label"><font style='color: red;'>*</font>最大配送范围：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="sendRange" name='sendRange' placeholder="" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_send_range']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>千米 &nbsp;&nbsp;<small>*超出最大配送范围的订单将无法使用配送到家</small></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">起送价格：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="satisfySend" name='satisfySend' placeholder="订单金额必须达到多少钱才配送，否则将无法下单。0表示无限制" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_satisfy_send']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元&nbsp;&nbsp;<small>*订单金额必须达到多少钱才配送，否则将无法下单。0表示无限制</small></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">免配送费价格：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="post_free" name='post_free'  placeholder="订单满足设定的金额时免配送费用，设置为0不进行减免" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_post_free']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元&nbsp;&nbsp;<small>*订单满足设定的金额时免配送费用，设置为0不进行减免</small></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><font style='color: red;'>*</font>基本配送费用：</label>
                        <div class="layui-input-inline width500 flex">
                            <input type="number" id="baseLong" name='baseLong' placeholder="请填写基本配送范围" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_base_long']}><{/if}>">
                            <div class='layui-form-mid layui-word-aux' style='flex:0 0 60px;margin: 0 5px;'>千米内</div>
                            <input type="number" id="basePrice" name='basePrice'  placeholder="请填写基本配送费用" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_base_price']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元&nbsp;&nbsp;<small>*基本配送范围内按基本配送费用收费</small></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"><font style='color: red;'>*</font>超出部分费用：</label>
                        <div class="layui-input-inline width500 flex">
                            <input type="number" id="plusLong" name='plusLong'  placeholder="" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_plus_long']}><{/if}>">
                            <div class='layui-form-mid layui-word-aux' style='flex:0 0 90px;margin: 0 5px;'>千米需另支付</div>
                            <input type="number" id="plusPrice" name='plusPrice'  placeholder="" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_plus_price']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元&nbsp;&nbsp;<small>*若用户超出基本配送范围,超出部分需按距离额外支付费用</small></div>
                    </div>
                </div>
            </div>
        </div>
	
	    <!-- 团长配送设置 -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">团长配送设置</h4>
                <div ckass="card-content">
                	<div class='layui-form-item'>
                		<label class="layui-form-label">团长配送状态：</label>
                		<div class="layui-input-inline width500">
	                		<input type="checkbox" name="leader" lay-skin="switch" lay-filter='switch' lay-text="ON|OFF" value="1" <{if $sendCfg && $sendCfg['acs_leader_send']}> checked<{/if}>>
	                	</div>
                	</div>
                	<div class='layui-form-item'>
                		<label class="layui-form-label">团长配送排序：</label>
                		<div class="layui-input-inline width500">
	                		<input type="text" id="leaderSort" name='leaderSort' placeholder="" autocomplete="off" class="layui-input" value="<{$sendCfg['acs_leader_sort']}>">
	                	</div>
                	</div>
                	
                	<div class="layui-form-item">
                        <label class="layui-form-label">团长配送费用：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="leaderPrice" name='leaderPrice' placeholder="" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_leader_price']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">起送价格：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="leaderLimit" name='leaderLimit' placeholder="订单金额必须达到多少钱才配送，否则将无法下单。0表示无限制" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_leader_limit']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元&nbsp;&nbsp;<small>*订单金额必须达到多少钱才配送，否则将无法下单。0表示无限制</small></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">免配送费价格：</label>
                        <div class="layui-input-inline width500">
                            <input type="text" id="leaderReduce" name='leaderReduce' placeholder="使用团长配送时，订单金额达到此金额将免费配送。0表示不设置" autocomplete="off" class="layui-input" value="<{if $sendCfg}><{$sendCfg['acs_leader_limit']}><{/if}>">
                        </div>
                        <div class='layui-form-mid layui-word-aux'>元&nbsp;&nbsp;<small>*使用团长配送时，订单金额达到此金额将免费配送。0表示不设置</small></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 门店自提 -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">买家自提</h4>
                <div ckass="card-content">
                	<div class='layui-form-item'>
                		<label class="layui-form-label">自提方式状态：</label>
                		<div class="layui-input-inline width500">
	                		<input type="checkbox" name="receive" lay-skin="switch" lay-filter='switch' lay-text="ON|OFF" value="1" <{if $sendCfg && $sendCfg['acs_receive']}>checked<{/if}>>
	                	</div>
                	</div>
                	<div class='layui-form-item'>
                		<label class="layui-form-label">自提方式排序：</label>
                		<div class="layui-input-inline width500">
	                		<input type="text" id="receiveSort" name='receiveSort' placeholder="" autocomplete="off" class="layui-input" value="<{$sendCfg['acs_receive_sort']}>">
	                	</div>
                	</div>
                </div>
            </div>
        </div>
        <!-- 快递配送 -->
        <div class='card'>
        	<div class="card-body">
        		<h4 class="card-title">快递配送</h4>
 	            <div ckass="card-content">
	            	<div class='layui-form-item'>
	            		<label class="layui-form-label">快递配送状态：</label>
	            		<div class="layui-input-inline width500">
	                		<input type="checkbox" name="express" lay-skin="switch" lay-filter='switch' lay-text="ON|OFF" value="1"  <{if $sendCfg && $sendCfg['acs_express_delivery']}>checked<{/if}>>
	                	</div>
	            	</div>
	            	<div class='layui-form-item'>
	            		<label class="layui-form-label">快递方式排序：</label>
	            		<div class="layui-input-inline width500">
	                		<input type="text" name="expressSort" placeholder="" autocomplete="off" class="layui-input" value="<{$sendCfg['acs_express_sort']}>">
	                	</div>
	            	</div>
	            	<div class='layui-form-item'>
	            		<label class="layui-form-label">配置快递发货模板：</label>
	            		<div class="layui-input-inline width500">
	                		  <a href='/wxapp/delivery/index' target="_blank" class="layui-btn layui-btn-normal">配置快递发货模板</a> 
	                	</div>
	            	</div>
	            </div>
	        </div>
        </div>
	</div>
	<div class='text-center submit'>
		<button class="layui-btn" lay-submit lay-filter="forSubmit">保存</button>
	</div>
</form>
<script type="text/javascript">
	$(function(){
		// 获取到所有的switch并设置对应的容器内的元素可编辑状态
		setContainerEleStatus();

		layui.use('form', function(){
			var form = layui.form;
			form.on('submit(forSubmit)', function(data){
				$.ajax({
					type:'POST',
					url:'/wxapp/delivery/saveDeliveryCfg',
					dataType:'json',
					data:data.field,
					success:function(res){
						layer.msg(res.em);
					}
				});  
				return false;
			});
			form.on('switch(switch)', function(data){
				setSwitcherFieldStatus($(data.elem),data.elem.checked);
			}); 
		});
		//改变switch的状态的时候设置该容器内的元素不可编辑
		function setSwitcherFieldStatus(ele,status){
			let parent=ele.parent().parent().parent();
			if(status){
				parent.find("input[type='text']").attr('disabled',false);
				parent.find("input[type='number']").attr('disabled',false);
				parent.find("select").attr('disabled',false);
			}else{
				parent.find("input[type='text']").attr('disabled',true);
				parent.find("input[type='number']").attr('disabled',true);
				parent.find("select").attr('disabled',true);
			}
		}
		// 初始化的时候设置容器内元素的可编辑状态
		function setContainerEleStatus(){
			$("input[type='checkbox']").each(function(){
				let that=$(this);
				let checked=that.attr('checked');
				checked=typeof(checked)=='undefined'?false:true;
				setSwitcherFieldStatus(that,checked);
			});
		}
	});
</script>
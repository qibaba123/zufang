<style type="text/css">
	.form select{
		-webkit-appearance:none;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class='form form-horizontal'>
			<input id='manager_id' type="hidden" value="<{$manager_info.m_id}>">
			<input type="hidden" id="hid_openid" value="<{$manager_info.m_wx_openid}>">

			<div class='form-group' <{if $manager_info.m_wx_openid || $manager_info.m_id}> style="display:none" <{/if}>>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>选择用户：</label>
				<div class='col-sm-6'>
					<{include file="../layer/ajax-select-input-single.tpl"}>
				</div>
			</div>

			<{if $member['m_id']}>
			<div class='form-group'>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>关联用户：</label>
				<div class='col-sm-6' style="line-height: 23px">
					<{$member['m_nickname']}>
				</div>
			</div>
			<{/if}>

			<div class='form-group'>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>姓名：</label>
				<div class='col-sm-6'>
					<input id='name' class='form-control' type="text" value="<{$manager_info.m_nickname}>" placeholder='请输入区域合伙人姓名'>
				</div>
			</div>
			<div class='form-group'>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>手机号码：</label>
				<div class='col-sm-6'>
					<input id='mobile' class='form-control' type="text" value="<{$manager_info.m_mobile}>" 
					<{if $manager_info.m_id}>disabled<{/if}> placeholder='手机号码将作为登录账号使用'>
					<div class='help-block'>
						<small>*手机号码将作为登录账号使用*</small>
					</div>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2'>密码：</label>
				<div class='col-sm-6'>
					<input id='pass' class='form-control' autocomplete="off" type="password"
					<{if $smarty.get.mid!=''}>
					placeholder="不填写则视为不进行修改"
					<{else}>
					placeholder="默认为空则与手机号码相同"
					<{/if}>
					">
				</div>
			</div>
			<div class='form-group'>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>所属区域：</label>
				<div class='col-sm-2'>
					<div class="input-group">
						<select id='prov' class='form-control' data-type='province'>
							<option value='0'>请选择开通城市</option>
							<{foreach $province as $item}>
								<option <{if $province_id==$item.region_id}>selected<{/if}> value='<{$item.region_id}>'><{$item.region_name}></option>>
							<{/foreach}>
						</select>
						<span class="input-group-addon">省</span>
					</div>
				</div>
				<div class='col-sm-2'>
					<div class="input-group">
						<select id='city' class='form-control' data-type='city'>
							<option value='0'>请选择开通城市</option>
							<{foreach $citys as $item}>
								<option <{if $city_id==$item.region_id}>selected<{/if}> value='<{$item.region_id}>'><{$item.region_name}></option>>
							<{/foreach}>
						</select>
						<span class="input-group-addon">市</span>
					</div>
				</div>
				<div class='col-sm-2'>
					<div class="input-group">
						<select id='zone' class='form-control'>
							<option value='0'>请选择开通区域</option>
							<{foreach $zones as $item}>
								<option <{if $manager_info.m_area_id==$item.region_id}>selected<{/if}> value='<{$item.region_id}>'><{$item.region_name}></option>>
							<{/foreach}>
						</select>
						<span class="input-group-addon">区/县</span>
					</div>
				</div>
			</div>
			<div class='form-group'>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>平台商品佣金比例：</label>
				<div class='col-sm-6'>
					<div class="input-group">
						<input id='brokerage' type="number" class="form-control" placeholder="平台商品佣金比例" value="<{$manager_info.m_area_brokerage}>">
						<span class="input-group-addon">%</span>
					</div>
					<div class='help-block'>
						<small>*平台商品设置区域合伙人可提现的比例*</small>
					</div>
				</div>
			</div>
			<div class='form-group'>
				<font style='color:red;line-height:35px;'>*</font><label class='col-sm-2'>自定义商品抽成比例：</label>
				<div class='col-sm-6'>
					<div class="input-group">
						<input id='c_brokerage' type="number" class="form-control" placeholder="自定义商品抽成比例" value="<{$manager_info.m_area_region_goods_brokerage}>">
						<span class="input-group-addon">%</span>
					</div>
					<div class='help-block'>
						<small>*区域合伙人自定义添加的商品，平台抽取提成*</small>
					</div>
				</div>
			</div>
			<{if $smarty.get.mid!=''}>
			<div class='form-group'>
				<label class='col-sm-2'>创建时间：</label>
				<div class='col-sm-6'>
					<input class='form-control' type="text" value="<{date('Y/m/d H:i:s',$manager_info.m_createtime)}>" disabled>
				</div>
			</div>
			<{/if}>
			<div class='form-group'>
				<div class='col-sm-offset-2 col-sm-6'>
					<button id='submit' class='btn btn-primary'>保存</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
	$(function(){
		$('#submit').click(function(){
			let m_id=$('#manager_id').val();
			let name=$('#name').val();
			let mobile=$('#mobile').val();
			let pass=$('#pass').val();
			let city=$('#city').val();
			let zone=$('#zone').val();
			let memberId = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
			let pattern = /^1[23456789]\d{9}$/;
			let brokerage=$('#brokerage').val();
			let c_brokerage=$('#c_brokerage').val();

			if(name==''){
				layer.msg('请填写合伙人姓名');
				return;
			}
	        if (!pattern.test(mobile)) {
	            layer.msg('请输入有效的手机号');
	            return false;
	        }
	        if(city==0||city==''){
	        	layer.msg('请选择开通城市');
	        	return;
	        }
//	        if(zone==0||zone==''){
//	        	layer.msg('请选择开通区/县');
//	        	return;
//	        }
	        $.ajax({
	        	type:'POST',
	        	url:'/wxapp/seqregion/editSeqAreaManager',
	        	dataType:'json',
	        	data:{
	        		'name'			:name,
	        		'mobile'		:mobile,
	        		'pass'			:pass,
	        		'city'			:city,
	        		'zone'			:zone,
	        		'mid'			:m_id,
	        		'brokerage'		:brokerage,
	        		'c_brokerage'	:c_brokerage,
					'memberId'  	:memberId,
	        	},
	        	success:function(res){
	        		layer.msg(res.em);
	                if(res.ec == 200 ){
	                    location.reload();
	                }
	        	}
	        });
		});

		$('#prov,#city').change(function(){
			let p_id=$(this).val();
			let type=$(this).data('type');
			if(type=='city')
				type='2';
			$.ajax({
				type:'post',
				url:'/wxapp/seqregion/getRegionByPId',
				dataType:'json',
				data:{
					'region_id':p_id,
					'type':type,
				},
				success:function(res){
					if(res.ec == 200 ){
						let option="<option value='0'>请选择开通城市</option>";
						for(let i=0;i<res.data.length;i++){
							option+="<option value='"+res.data[i].region_id+"'>"+res.data[i].region_name+"</option>";
						}
						if(type==2)
							$('#zone').html(option);
						else
	                    	$('#city').html(option);
	                }else{
	                	layer.msg(res.em);
	                }
				}
			});
		});
	});
</script>
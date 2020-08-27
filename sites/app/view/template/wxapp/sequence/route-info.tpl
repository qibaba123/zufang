<link rel="stylesheet" type="text/css" href="/public/manage/ajax-page.css">
<style type="text/css">
	.form-inline{
		padding: 10px 0;
	}
	.modal-lg{
		width: 900px;
	}
	.input-group{
		display: inline-table;
		width: 180px;
	}
	.form-group{
		margin-bottom: 10px!important;
	}
</style>
<input id='route_id' type="hidden" value="<{$smarty.get.route_id}>">
<div class='panel panel-default'>
	<div class='panel-body'>
		<div class='form-horizontal'>
			<div class='form-group'>
				<label class='col-xs-1'>路线名称：</label>
				<div class='col-xs-6'>
					<input id='route_name' class='form-control' type="text" name="" value='<{$route_info.asdr_name}>'>
				</div>
			</div>
			<div class='form-group'>
				<label  class='col-xs-1'>配送员：</label>
				<div class='col-xs-6'>
					<input id='delivery_name' class='form-control' type="text" name="" value='<{$route_info.asdr_delivery_name}>'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-xs-1'>配送员手机：</label>
				<div class='col-xs-6'>
					<input id='delivery_mobile' class='form-control' type="number" name="" value='<{$route_info.asdr_delivery_mobile}>'>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-xs-1'>关联社区：</label>
				<div class='col-xs-11'>
					<div style='padding-bottom: 10px;'>
						<button id='add_community' class='btn btn-primary btn-sm'>增加小区</button>
					</div>
					<table class='table table-hover'>
						<thead>
							<tr>
								<th>小区名称</th>
								<th>团长姓名</th>

								<th>小区排序</th>

								<th>联系电话</th>
								<th class='text-right'>操作</th>
							</tr>
						</thead>
						<tbody>
							<{foreach $community_list as $item}>
							<tr>
								<td><{$item.asc_name}></td>
								<td><{$item.asl_name}></td>

								<td><{$item.asdrt_sort}></td>

								<td><{$item.asl_mobile}></td>
								<td class='text-right'>

									<button class='btn btn-default btn-sm change-sort' data-id='<{$item.asdrt_id}>' data-sort='<{$item.asdrt_sort}>' data-toggle="modal" data-target="#sortModal" >排序</button>

									<a class='btn btn-success btn-sm' href='/wxapp/sequence/viewRouteCommunityGoods?route_id=<{$smarty.get.route_id}>&community_id=<{$item.asdrt_community_id}>'>查看</a>
									<button class='btn btn-danger btn-sm delete' data-id='<{$item.asdrt_id}>'>删除</button>
								</td>
							</tr>
							<{/foreach}>
						</tbody>
					</table>
					<div class='text-right'>
						<{$paginator}>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id='sortModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" style="width: 500px;margin-right: auto !important;margin-left: auto">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">小区排序</h4>
			</div>
			<input type="hidden" id="route_com_id" value="">
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-3 control-label no-padding-right" for="route_com_sort" style="text-align: center">排序：</label>
					<div class="col-sm-8">
						<input id="route_com_sort" type="text" class="form-control" placeholder="越大越靠前" style="height:auto!important"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='submitSort' type="button" class="btn btn-primary">保存</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div id='communityModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">增加小区</h4>
			</div>
			<div class="modal-body">
				<div class='form-inline searchbox'>
					<div class='form-group'>
                        <div class="input-group">
                            <select id='search_prov' class='form-control' name='search_province' data-type='province'>
                                <option value='0'>请选择省份</option>
                                <{foreach $province as $item}>
                            <option value='<{$item.region_id}>'><{$item.region_name}></option>>
                                <{/foreach}>
                            </select>
                            <span class="input-group-addon">省</span>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class="input-group">
                            <select id='search_city' name='search_city' class='form-control' data-type='city'>
                                <option value='0'>请选择城市</option>
                            </select>
                            <span class="input-group-addon">市</span>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class="input-group">
                            <select id='search_zone' name='search_zone' class='form-control' data-type='zone'>
                                <option value='0'>请选择区/县</option>
                            </select>
                            <span class="input-group-addon">区</span>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class="input-group">
                            <select id='street' name='street' class='form-control'>
                                <option value='0'>请选择街道</option>
                            </select>
                            <span class="input-group-addon">街道</span>
                        </div>
                    </div>
                    <div class='form-group'>
                    	<input id='community' class='form-control' type="text" placeholder ="搜索小区名称">
                    </div>
                    <div class='form-group'>
                    	<button id='search' class='btn btn-primary btn-sm'>搜索</button>
                    </div>
				</div>
				<table class='table'>
					<thead>
						<tr>
							<th><input id='select_all' type="checkbox" name="">&nbsp;选择</th>
							<th>小区名称</th>
							<th>团长名称</th>
							<th>联系电话</th>
						</tr>
					</thead>
					<tbody id='recommend-tr'>
						
					</tbody>
				</table>
				<div id='recommend-footer-page' class='text-center ajax-pages'></div>
			</div>
			<div class="modal-footer">
				<button id='submitRoute' type="button" class="btn btn-primary">保存</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
	function getCommunityList(page,type){
		var index = layer.load(10, {
            shade: [0.6,'#666']
        });
       
        let district_community=type.split('_');
		// 获取小区信息
		$.ajax({
			type:'post',
			url:'/wxapp/sequence/getCommnunityNotInRoute',
			dataType:'json',
			data:{
				'page'		:page,
				'district'	:district_community[0],
				'community'	:district_community[1],
			},
			success:function(ret){
				layer.close(index);
				if(ret.list=='')
                    layer.msg('未搜索到数据');
                setRecommendListHtml(ret.list);
                $('#recommend-footer-page').html(ret.pageHtml)
			}
		});
	}
	function setRecommendListHtml(data){
        var mk = $('#mkType').val();
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="community_tr_'+data[i].asc_leader+'">';
            html += '<td><input type="checkbox" name="community" value="'+data[i].asc_id+'"></td>';
            html += '<td>'+data[i].asc_name+'</td>';
            html += '<td>'+data[i].asl_name+'</td>';
            html += '<td><p class="g-name">'+data[i].asl_mobile+'</p></td>';
            html += '</tr>';
        }
        $('#recommend-tr').html(html);
    }
	$(function(){
		$('.delete').click(function(){
			let _this=$(this);
			let uid=$(this).data('id');
			if(!uid){
				layer.msg('请选择要删除的小区');
			}
			layer.confirm('您确定要删除当前线路中的小区吗？', {
               	title:'删除提示',
               	btn: ['确定','取消']
            }, function(){
               	$.ajax({
               		type:'post',
               		url:'/wxapp/sequence/deleteDeliveryRouteDetail',
               		dataType:'json',
               		data:{
               			'community_id':uid,
               		},
               		success:function(res){
               			layer.msg(res.em);
               			if(res.ec==200){
               				_this.parent().parent().remove();
               			}
               		}
               	});
            })
		});

		$('#add_community').click(function(){
			getCommunityList(1,'0_0');
			$('#search_prov').val('');
			$('#search_city').val('');
			$('#search_zone').val('');
			$('#street').val('');

			$('#communityModal').modal('show');
		});

		$('#search_prov,#search_city').change(function(){
	        let p_id=$(this).val();
	        let type=$(this).data('type');
	        if(p_id==0){
	            if(type=='province'){
	                $('#search_city').find('option[value="0"]').attr('selected',true);
	            }
	            $('#search_zone').find('option[value="0"]').attr('selected',true);
	            return;
	        }
	        if(type=='city')
	            type='2';
	        $.ajax({
	            type:'post',
	            url:'/wxapp/sequence/getRegionByPId',
	            dataType:'json',
	            data:{
	                'region_id':p_id,
	                'type':type,
	            },
	            success:function(res){
	            	let option="<option value='0'>请选择城市</option>";
                    if(type==2)
                    	option="<option value='0'>请选择区/县</option>";
	                if(res.ec == 200 ){
	                    for(let i=0;i<res.data.length;i++){
	                        option+="<option value='"+res.data[i].region_id+"'>"+res.data[i].region_name+"</option>";
	                    }
	                    if(type==2)
	                        $('#search_zone').html(option);
	                    else
	                        $('#search_city').html(option);
	                }else{
	                    layer.msg(res.em);
	                }
	            }
	        });
	    });
		$('#search').click(function(){
			let district=$('#street').val();
			let community=$('#community').val();
			let param=(district?district:0)+'_'+(community?community:0);
			getCommunityList(1,param);
		});

		$('#search_zone').change(function(){
			let district=$(this).val();
			$.ajax({
	            type:'post',
	            url:'/wxapp/sequence/getCommunityCountByArea',
	            dataType:'json',
	            data:{
	                'district':district,
	            },
	            success:function(res){
	                if(res.ec == 200 ){
	                    let option="<option value='0'>请选择街道</option>";
	                    for(let i=0;i<res.data.length;i++){
	                        option+="<option value='"+res.data[i].asa_id+"'>"+res.data[i].asa_name+"</option>";
	                    }
	                    $('#street').html(option);
	                }else{
	                    layer.msg(res.em);
	                }
	            }
	        });
		});
		// 提交路线数据
		$('#submitRoute').click(function(){
			let route_id=$('#route_id').val();
			let route_name=$('#route_name').val();
			let delivery_name=$('#delivery_name').val();
			let delivery_mobile=$('#delivery_mobile').val();
			let communitys=new Array();
			$('input[name="community"]:checked').each(function(i){ 
				communitys.push($(this).val());
			});
			$.ajax({
				type:'POST',
				url:'/wxapp/sequence/createDeliveryRoute',
				dataType:'json',
				data:{
					'route_id'			:route_id,
					'route_name'		:route_name,
					'delivery_staff'	:delivery_name,
					'delivery_mobile'	:delivery_mobile,
					'communitys'		:communitys,
				},
				success:function(res){
					layer.msg(res.em);
					if(res.ec==200){
						setTimeout(function(){
							window.location.href='/wxapp/sequence/viewEditRoute?route_id='+res.data.route_id;
						},1000);
					}
				}
			});
		});

		$('#select_all').click(function(){
			let is_check=$(this).prop('checked');
			$('input[name="community"]').each(function(i){ 
				if(is_check){
					$(this).prop('checked',true);
				}else{
					$(this).prop('checked',false);
				}
			});
		});
	});

	$('.change-sort').click(function () {
		let id=$(this).data('id');
		let sort=$(this).data('sort');
		$('#route_com_id').val(id);
		$('#route_com_sort').val(sort);
	});

	// 提交排序数据
	$('#submitSort').click(function(){
		let id=$('#route_com_id').val();
		let sort=$('#route_com_sort').val();

		$.ajax({
			type:'POST',
			url:'/wxapp/sequence/changeRouteCommunitySort',
			dataType:'json',
			data:{
				'id'		:id,
				'sort'		:sort,
			},
			success:function(res){
				layer.msg(res.em);
				if(res.ec==200){
					window.location.reload();
				}
			}
		});
	});

</script>

<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<!-- <link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" /> -->
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
	input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
		content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
	}
	.chosen-container {
	    width: 100%!important;
	}
	.chosen-container-multi .chosen-choices{
	    padding: 3px 5px 2px!important;
	    border-radius: 4px;
	    border: 1px solid #ccc;
	}
	.chosen-container-single .chosen-single{
		padding: 3px 5px 2px!important;
	    border-radius: 4px;
	    border: 1px solid #ccc;
	    height: 34px;
	    background: url();
	    background-color: #fff;
	}
	.chosen-container-single .chosen-single span{
		margin-top: 2px;
	}
	.chosen-single div b:before{
		top:3px;
	}
	select.form-control {
	    padding: 5px 6px;
	    height: 34px;
	}
	.ptinfo-fenlei{
	    background-color: #f6f6f6;
	    border:1px solid #e8e8e8;
	    border-radius: 4px;
	    margin-bottom: 10px;
	    padding: 15px 10px;
	}
	.ptinfo-fenlei .fenlei-name{
	    font-size: 16px;
	    line-height: 34px;
	    font-weight: bold;
	    color: #02a802;
	    display: block;
	    text-align: center;
	    padding-right: 10px;
	}
	.ptinfo-fenlei .control-label{
		font-weight: bold;
		text-align: right;
		padding-right: 0;
		line-height: 26px;
	}
	.ptinfo-fenlei .col-xs-10 .form-group:last-child{
		margin-bottom: 0;
	}
	.Wdate.form-control[type=text]{
		background: #fff url(/public/plugin/datePicker/skin/datePicker.gif) no-repeat;
		height: 34px;
		border-color: #ccc;
		background-position: 98% center;
	}
	.radio-box{
		line-height: 34px;
	}
</style>
<{include file="../common-second-menu.tpl"}>
<div id="mainContent" ng-app="chApp" ng-controller="chCtrl">
<div class="choose-pintuan"  id="div-add">
	<form class="form-horizontal" id="activity-form"  enctype="multipart/form-data">
		<input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['gb_id']}><{else}>0<{/if}>">
		<input type="hidden" id="type" name="type" value="<{if $row}><{$row['gb_type']}><{else}>0<{/if}>" data-need="required" placeholder="请选择团购分类">
		<div style="overflow:hidden">
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">参团商品</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">拼团购封面</label>
						<div class="col-xs-9">
							<div>
								<img onclick="toUpload(this)"
									 data-limit="1"
									 data-width="750"
									 data-height="360"
									 data-dom-id="cover"
									 id="cover"
									 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_75_36.png"
									 placeholder="请上传拼图购封面图"
									 data-need="required"
									 src="<{if $row && $row['gb_cover']}><{$row['gb_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  style="display:inline-block;width:200px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
								<a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="360" data-dom-id="cover">修改（尺寸：750*360）</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">参团商品</label>
						<div class="col-xs-6">
							<select class="form-control selectpicker chosen-select" id="g_id" name="g_id" ng-change="changePrice()" ng-model="gId" <{if $row && $row['gb_g_id']}>disabled="disabled"<{/if}>  data-live-search="true"  data-need="required" data-placeholder="请选择参团商品">
								<{foreach $goodsList as $val}>
								<option data-price="<{$val['g_price']}>" data-format='<{$val['g_format']}>' value="<{$val['g_id']}>" <{if $row && $row['gb_g_id'] eq $val['g_id']}>selected="selected"<{/if}>><{mb_substr($val['g_name'],0,20)}></option>
								<{/foreach}>
							</select>
						</div>
						<div class="col-xs-3" style="margin-top: 7px">原价：<span id="ori-price"><{if $goods}><{$goods['g_price']}><{else}><{$goodsList[0]['g_price']}><{/if}></span></div>
					</div>
					<div class="form-group">
							<label for="price" class="col-xs-3 control-label">是否允许单独购买</label>
							<div class="col-xs-9">
								<div class="radio-box">
									<span data-val="1">
										<input type="radio" name="single" value="1" id="single1" <{if $row && $row['gb_single_buy'] eq 1}>checked<{elseif empty($row)}>checked<{/if}>>
										<label for="single1">允许</label>
									</span>
									<span data-val="0">
										<input type="radio" name="single" value="0" id="single0" <{if $row && $row['gb_single_buy'] eq 0}>checked<{/if}>>
										<label for="single0">不允许</label>
									</span>
								</div>
							</div>
					</div>
					<div class="form-group tuanzhang">
						<label for="price" class="col-xs-3 control-label">单人限购</label>
						<div class="col-xs-9">
							<input type="number" class="form-control " id="limit" name="limit"  data-need="" placeholder="请填写单人限购数量, 0表示不限购" value="<{if $row}><{$row['gb_limit']}><{/if}>">
						</div>
					</div>
					<div class="form-group tuanzhang">
						<label for="price" class="col-xs-3 control-label">排序权重</label>
						<div class="col-xs-9">
							<input type="number" class="form-control " id="sort" name="sort"  data-need="" placeholder="请填写排序权重" value="<{if $row}><{$row['gb_sort']}><{else}>0<{/if}>">
						</div>
					</div>
					<{if $appletCfg['ac_type'] == 6 || $appletCfg['ac_type'] == 8}>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">浏览量</label>
						<div class="col-xs-9">
							<input type="number" class="form-control" id="viewNum" name="viewNum" placeholder="请填写浏览量" data-need="" value="<{if $row}><{$row['gb_view_num']}><{else}>0<{/if}>" style="width: 160px;">
						</div>
					</div>

					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">浏览量显示</label>
						<div class="col-xs-9">
							<label style="padding: 4px 0;margin: 0;">
								<input name="viewNumShow" class="ace ace-switch ace-switch-5" id="viewNumShow" <{if ($row && $row['gb_view_num_show']) || !$row}>checked<{/if}> type="checkbox">
								<span class="lbl"></span>
							</label>
						</div>
					</div>
					<{/if}>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">活动规则</label>
						<div class="col-xs-9">
							<textarea id="activity_rule" class="form-control " rows="3" name="activity_rule" data-need="" placeholder="请填写活动规则"><{if $row}><{$row['gb_act_rule']}><{/if}></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="ptinfo-fenlei clearfix" ng-show="selectedGoodsFormat.length<=0">
				<div class="col-xs-2">
					<span class="fenlei-name">阶梯价格设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<table class="table" border="0" cellpadding="0" cellspacing="0" style="margin-left: 55px;border: 0;width: 92%;margin-bottom: 0">
						<thead>
						<tr>
							<th class="center" style="width: 17%;">阶段</th>
							<th class="center">阶段人数</th>
							<th class="center">团购价格</th>
							<th class="center">操作</th>
						</tr>
						</thead>
						<tbody id="fomat-group-box">
							<tr ng-repeat="price in sectionPrice">
								<td class="center">
									<div class="form-group">
										<div class="col-xs-12">
											<span style="font-weight: bolder">阶段{{$index+1}}</span>
										</div>
									</div>
								</td>
								<td class="center">
									<div class="form-group">
										<div class="col-xs-12">
											<input type="number" class="form-control" min="2" id="tz_price" name="tz_price"  data-need="" ng-model="price.total" placeholder="请填写阶段人数" <{if $row}>disabled="disabled"<{/if}> >
										</div>
									</div>
								</td>
								<td class="center">
									<div class="form-group">
										<div class="col-xs-12">
											<input type="number" class="form-control " id="price" name="price" placeholder="请填写团购价格" ng-model="price.price" <{if $row}>disabled="disabled"<{/if}> data-need="required" >
										</div>
									</div>
								</td>
								<td class="center">
									<div class="form-group" ng-if="isAdd==1">
										<div class="col-xs-12">
											<div class="delete" ng-click="delIndex('sectionPrice',$index)" style="color: red">删除</div>
										</div>
									</div>
								</td>
							</tr>
							<tr ng-if="isAdd==1">
								<td colspan="4">
									<div ng-click="addSection()" style="background: #fff;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;text-align: center;width: 80%;margin: 15px auto 0;">添加阶梯</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="ptinfo-fenlei clearfix" ng-show="selectedGoodsFormat.length>0" id="format-edit-box">
				<div class="col-xs-2">
					<span class="fenlei-name">规格价格设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<table class="table" border="0" cellpadding="0" cellspacing="0" style="margin-left: 55px;border: 0;width: 92%">
						<thead>
							<tr>
								<th class="center" style="width: 17%;">阶段</th>
								<th class="center">阶段人数</th>
								<th class="center">规格</th>
								<th class="center">团购价格</th>
								<th class="center">操作</th>
							</tr>
						</thead>
						<tbody id="fomat-group-box" ng-repeat="price in sectionPrice track by $index" ng-init="trIndex = $index">
							<tr ng-repeat="format in price.format track by $index">
								<td class="center" rowspan="{{price.format.length}}" ng-if="$index==0">
									<div class="form-group">
										<div class="col-xs-12">
											<span style="font-weight: bolder">阶段{{trIndex+1}}</span>
										</div>
									</div>
								</td>
								<td class="center" rowspan="{{price.format.length}}" ng-if="$index==0">
									<div class="form-group">
										<div class="col-xs-12">
											<input type="number" class="form-control" min="2" id="tz_price" name="tz_price"  data-need="" ng-model="price.total" placeholder="请填写阶段人数" <{if $row}>disabled="disabled"<{/if}> >
										</div>
									</div>
								</td>
								<td class="center" >
									<div class="form-group">
										<div class="col-xs-12">
											<span style="font-weight: bolder">{{format.name}}</span>
										</div>
									</div>
								</td>
								<td class="center">
									<div class="form-group">
										<div class="col-xs-12">
											<input type="number" class="form-control " name="price" placeholder="请填写团购价格" ng-model="format.price" <{if $row}>disabled="disabled"<{/if}> data-need="required" >
										</div>
									</div>
								</td>

								<td class="center" rowspan="{{price.format.length}}" ng-if="$index==0">
									<div class="form-group" ng-if="isAdd==1">
										<div class="col-xs-12">
											<div class="delete" ng-click="delIndex('sectionPrice',$index)" style="color: red">删除</div>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
						<tr ng-if="isAdd==1">
							<td colspan="5">
								<div ng-click="addSection()" style="background: #fff;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;text-align: center;width: 80%;margin: 15px auto 0;">添加阶梯</div>
							</td>
						</tr>
					</table>
				</div>
			</div>



			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">展示设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">所有拼团共计参与人数</label>
						<div class="col-xs-9">
							<input type="number" class="form-control need-desc" id="joined" name="joined" placeholder="本活动总计参与人数"  data-need="required" value="<{if $row}><{$row['gb_joined']}><{/if}>"  oninput="this.value=this.value.replace(/\D/g,'')">
						</div>
					</div>

					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">凑团显示个数</label>
						<div class="col-xs-9">
							<input type="text" class="form-control need-desc" id="show_num" name="show_num" placeholder="请填写凑团显示个数" data-need="required" value="<{if $row}><{$row['gb_show_num']}><{/if}>"  oninput="this.value=this.value.replace(/\D/g,'')">
							<span style="color: red">注：凑团个数指小程序端待成团数量显示，方便其他用户之间加入组团</span>
						</div>
					</div>

				</div>
			</div>
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">时间设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="start" class="col-xs-3 control-label">开始时间</label>
						<div class="col-xs-9">
							<input id="startTime" name="startTime" type="text" autocomplete="off" placeholder="请选择开始时间" class="Wdate form-control" <{if $row && $row['gb_start_time']}>disabled="disabled"<{/if}> value="<{if $row}><{date('Y-m-d H:i:s',$row['gb_start_time'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\');}'})">
						</div>
					</div>
					<div class="form-group">
						<label for="end" class="col-xs-3 control-label">结束时间</label>
						<div class="col-xs-9">
							<input id="endTime" name="endTime"  type="text" autocomplete="off" placeholder="请选择结束时间" class="Wdate form-control" <{if $row && $row['gb_end_time']}>disabled="disabled"<{/if}> value="<{if $row}><{date('Y-m-d H:i:s',$row['gb_end_time'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\');}'})">
						</div>
					</div>    
				</div>
			</div>
			<div class="ptinfo-fenlei clearfix putong" style="display: none;">
				<div class="col-xs-2">
					<span class="fenlei-name">其它设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group putong" style="display: none;" id="div-auto">
						<label for="price" class="col-xs-3 control-label">是否自动成团</label>
						<div class="col-xs-9">
							<div class="radio-box">
								<{foreach $yesNo as $key=>$val}>
								<span data-val="<{$key}>">
									<input type="radio" name="auto" value="<{$key}>" id="auto<{$key}>" <{if $row && $row['gb_start_time']<time()}>disabled="disabled"<{/if}>  <{if $row && $row['gb_use_auto'] eq $key}>checked<{elseif empty($row) && $key eq 1}>checked<{/if}>>
									<label for="auto<{$key}>"><{$val}></label>
								</span>
								<{/foreach}>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ptinfo-fenlei clearfix">
				<div class="col-xs-2">
					<span class="fenlei-name">分享设置</span>
				</div>
				<div class="col-xs-10" style="border-left:1px dashed #ddd;">
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">分享图片</label>
						<div class="col-xs-9">
							<img onclick="toUpload(this)"
								 data-limit="1"
								 data-width="645"
								 data-height="500"
								 data-dom-id="share_image"
								 id="share_image"
								 placeholder="请上传分享图片"
								 data-need="required"
								 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_45_45.png"
								 src="<{if $row && $row['gb_share_image']}><{$row['gb_share_image']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  style="display:inline-block;width:100px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
							<a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="645" data-height="500" data-dom-id="share_image">修改<small>(尺寸：645*500)</small></a>
						</div>
					</div>
					<div class="form-group">
						<label for="price" class="col-xs-3 control-label">分享标题</label>
						<div class="col-xs-9">
							<input type="text" class="form-control need-desc" id="share_title" name="share_title" data-need="" placeholder="若不填写，则取商品标题" value="<{if $row}><{$row['gb_share_title']}><{/if}>" >
						</div>
					</div>
				</div>
			</div>
			<div class="form-group col-xs-12" style="text-align:center">
				<button type="button" class="btn btn-primary btn-save" ng-click="save()"> 保 存 </button>
			</div>
		</div>
	</form>
</div><!-- /row -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>

<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.selectedGoodsFormat = <{$selectedGoodsFormat}>;
		$scope.sectionPrice = <{$sectionPrice}>;
		$scope.gId =  '<{$goods['g_id']}>'?'<{$goods['g_id']}>':'<{$goodsList[0]['g_id']}>';
		$scope.isAdd = '<{$isAdd}>'

        $scope.changePrice = function(){
            $('#ori-price').text($(".chosen-select option:selected").attr("data-price"));
			$scope.selectedGoodsFormat = JSON.parse($(".chosen-select option:selected").attr("data-format"));
            $scope.sectionPrice = [];
			console.log($scope.selectedGoodsFormat);
        };

        $scope.addSection = function(){
			let format = angular.copy($scope.selectedGoodsFormat);
            let data = {
                'total' : 2,
                'price': 0,
				'format': format
            };
            $scope.sectionPrice.push(data);
        };

        /*删除元素*/
        $scope.delIndex=function(type,index){
            console.log(type);
            console.log(index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(index,1);
                });
                layer.msg('删除成功');
            })
        };

        /*删除元素*/
        $scope.save=function(type,index){
            var field = new Array('g_id','joined','show_num','start','startTime','end','endTime','share_title','share_desc','activity_rule', 'limit');
            var data  = { };
            for(var i=0; i<field.length; i++){
                var temp = $('#'+field[i]).val();
                if(temp){
                    data[field[i]] = temp
                }else{
                    var req = $('#'+field[i]).attr('data-need');
                    if(req == 'required'){
                        console.log(field[i]);
                        var msg = $('#'+field[i]).attr('placeholder');
                        layer.msg(msg);
                        return false;
                    }
                }
            }

            if($scope.sectionPrice.length<=0){
                layer.msg("请添加阶段价格");
                return false;
            }
            data.sort      =  $('input[name="sort"]').val();
            data.use_auto  =  $('input[name="auto"]:checked').val();
            data.sub_limit =  $('input[name="limit"]:checked').val();
            data.single_buy =  $('input[name="single"]:checked').val();
            data.id 	   =  $('#hid_id').val();
            data.tz_price  =  $('#tz_price').val();
            data.viewNum   =  $('#viewNum').val();
            data.viewNumShow =  $('#viewNumShow:checked').val()=='on'?1:0;
            data.sectionPrice = JSON.stringify($scope.sectionPrice);
            var imgField   =  new Array('cover','share_image');
            for(var j=0; j<imgField.length; j++){
                var imgTemp = $('#'+imgField[j]).attr('src');
                var df      = $('#'+imgField[j]).data('dfvalue');
                if(imgTemp && df != imgTemp){
                    data[imgField[j]] = imgTemp
                }else{
                    console.log(imgField[j]);
                    errorTips(imgField[j]);
                    return false;
                }
            }
            console.log(data);
            layer.confirm('确定要保存吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/group/saveSectionGroup',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'  : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.href='/wxapp/group/index';
                        }
                    }
                });
            });
        };

        $(function(){
            // 搜索选择下拉框
            $(".chosen-select").chosen({
                no_results_text: "没有找到",
                search_contains: true
            });
        });
	}])


	$('.type-item').on('click',function(){
		var type = $(this).data('type');
		if(type){
			deal_show_hide_by_type(type);
		}
	});
	$('.need-desc').on('focus',function(){
		var desc = $(this).data('desc');
		if(desc){
			var id   = $(this).attr('id');
			layer.tips(desc, '#'+id, {
				tips: [2, '#78BA32'],
				time: 4000
			});
		}
	});


    function errorTips(id){
		var req = $('#'+id).data('need');
		if(req == 'required'){
			var msg = $('#'+id).attr('placeholder');
			layer.msg(msg);
		}
	}

	function deal_select_img(allSrc){
		if(allSrc){
			$('#'+nowId).attr('src',allSrc[0]);
		}
	}
</script>


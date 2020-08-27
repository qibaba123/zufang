<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
	.page-content{
		margin-left: 140px;
	}
	.ui-table-order .time-cell{
		width: 120px !important;
	}
	.form-group{
		margin-bottom: 10px !important;
	}
	.search-box{
		margin: 20px auto 20px;
	}
</style>
<{include file="../common-second-menu.tpl"}> <!--#4c8fbd;-->
<div>
	<a href="/wxapp/print" class="btn btn-green btn-sm"><i class="icon-print"></i>打印模版设置</a>
	<a href="#" class="btn btn-green btn-sm" data-click-upload ><i class="icon-cloud-upload"></i>批量发货</a>
</div>
<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="/wxapp/auction/orderList" method="get">
			<div class="col-xs-11 form-group-box">
				<div class="form-container">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">订单编号</div>
							<input type="text" class="form-control" name="tid" value="<{$tid}>"  placeholder="订单编号">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group ">
							<div class="input-group-addon">商品名称</div>
							<input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="商品名称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">买家</div>
							<input type="text" class="form-control" name="buyer" value="<{$buyer}>"  placeholder="购买人微信昵称">
						</div>
					</div>
					<div class="form-group" style="width: 400px">
						<div class="input-group">
							<div class="input-group-addon" >参与时间</div>
							<input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
					<input type="hidden" name="status" value="<{$status}>">
				</div>
			</div>
			<div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 20%;right: 2%;">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>

<div class="choose-state">
	<{foreach $orderLink as $key=>$val}>
	<a href="<{$val['href']}>" <{if $status && $status eq $val['key']}>class="active"<{/if}>><{$val['label']}></a>
	<{/foreach}>
</div>
<div class="trade-list">
	<table class="ui-table-order" style="padding: 0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
		    <tr class="widget-list-header">
		        <th class="" colspan="2" style="min-width: 212px; max-width: 212px;">商品</th>
		        <th class="price-cell" style="min-width: 87px; max-width: 87px;">起拍价</th>
				<th class="price-cell" style="min-width: 87px; max-width: 87px;">当前价格</th>
		        <th class="customer-cell" style="min-width: 110px; max-width: 110px;">买家</th>
		        <th class="time-cell" style="min-width: 80px; max-width: 80px;">
		            <a href="javascript:;" data-orderby="book_time">参与时间<span class="orderby-arrow desc">↓</span></a>
		        </th>
		        <th class="state-cell" style="min-width: 100px; max-width: 100px;">订单状态</th>
		        <th class="pay-price-cell" style="min-width: 150px; max-width: 150px;">实付金额</th>
		    </tr>
		</thead>

		<{foreach $list as $val}>
		<tbody class="widget-list-item">
		<tr class="separation-row">
			<td colspan="7"></td>
		</tr>
		<tr class="header-row">
			<td colspan="7">
				<div>
					订单号: <{$val['t_tid']}>
					<div class="help" style="display: inline-block;">
						<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><{$tradePay[$val['t_pay_type']]}></span>
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/auction/tradeDetail?order_no=<{$val['t_tid']}>" class="new-window" >查看详情</a>
						<a href="#" class="js-remark hide">备注</a>
					</div>
				</div>
			</td>
		</tr>
		<tr class="content-row">
			<td class="image-cell">
				<img src="<{$val['t_pic']}>">
			</td>
			<td class="title-cell">
				<p class="goods-title">
					<a href="/wxapp/auction/orderList?title=<{$val['t_title']}>"class="new-window" title="<{$val['t_title']}>">
						<{$val['t_title']}>
					</a>
				</p>
			</td>
			<td class="price-cell">
				<p>
					<{$val['aal_start_price']}>
				</p>
			</td>
			<td class="price-cell">
				<p>
					<{$val['aal_curr_price']}>
				</p>
			</td>
			<td class="customer-cell" rowspan="1">
				<p>
					<a href="/wxapp/auction/orderList?buyer=<{$val['t_buyer_nick']}>" class="new-window" target="_blank">
						<{$val['t_buyer_nick']}>
					</a>
				</p>
			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<{date('Y-m-d H:i:s',$val['t_create_time'])}>
				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<p class="js-order-state" id="status_<{$val['t_tid']}>"><{$statusNote[$val['t_status']]}></p>
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
						<{$val['t_total_fee']}>
						<br>
					</div>
					<p class="user-name">
					<{if $val['t_status'] == 3}>
				<span id="express_<{$val['t_tid']}>" class="btn btn-primary btn-xs express-btn"
					  data-tid="<{$val['t_tid']}>"
					  data-feedback="<{$val['t_feedback']}>"
					  data-province="<{$val['ma_province']}>"
					  data-city="<{$val['ma_city']}>"
					  data-area="<{$val['ma_zone']}>"
					  data-address="<{$val['ma_detail']}>"
					  data-phone="<{$val['ma_phone']}>"
					  data-name="<{$val['ma_name']}>"
					  data-tra-num="<{if isset($trader[$val['t_id']])}><{$trader[$val['t_id']]['count']}><{else}>0<{/if}>"
					<{if isset($trader[$val['t_id']])}>
					<{foreach $trader[$val['t_id']]['data'] as $key=>$mal}>
					data-title_<{$key}>="<{$mal['to_title']}>"
					data-price_<{$key}>="<{$mal['to_price']}>"
					data-num_<{$key}>="<{$mal['to_num']}>"
					data-total_<{$key}>="<{$mal['to_total']}>"
					<{/foreach}>
					<{/if}>>发货</span>
					<{/if}>
					</p>
					<{foreach $print as $pkey=>$pal}>
					<p class="user-name">
					<a href="javascript:;" class="btn btn-info btn-xs previewCon" data-type="<{$pkey}>" data-tid="<{$val['t_tid']}>"><i class="icon-print"></i><{$pal['label']}></a>
					</p>
					<{/foreach}>
				</div>
			</td>
		</tr>
		<{if $val['t_note']}>
		<tr class="remark-row buyer-msg">
			<td colspan="7">买家备注： <{$val['t_note']}></td>
		</tr>
		<{/if}>
		<{if $val['t_remark_extra']}>
		<tr class="remark-row buyer-msg"
			<{if count($val['t_remark_extra']) == 1 && $val['t_remark_extra'][0]['name']=='备注' && !$val['t_remark_extra'][0]['value']}>
			style="display:none"
			<{/if}>
			>
			<td colspan="8">
				<{foreach $val['t_remark_extra'] as $v}>
				<{if $v['value']}>
				<{if $v['type'] != 'image'}>
				<{$v['name']}>：<{$v['value']}>&nbsp;&nbsp;&nbsp;&nbsp;
				<{else}>
				<{$v['name']}>：<img src="<{$v['value']}>" alt="" width="50px">&nbsp;&nbsp;&nbsp;&nbsp;
				<{/if}>
				<{/if}>
				<{/foreach}>
			</td>
			</tr>
			<{/if}>
		</tbody>
		<{/foreach}>

		<tbody class="widget-list-item">
		    <tr class="separation-row">
		        <td colspan="7"><{$page_html}> </td>
		    </tr>
		</tbody>

	</table>
	<div id="refund-form"  class="modal fade">
		<div class="modal-dialog" style="width:760px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modelTitle">退款处理</h4>
				</div>
				<div class="modal-body">
					<div class="row hid-row" id="show-deduct">
						<table class="ui-table" style="margin-bottom:20px;">
							<thead>
							<tr>
								<th></th>
								<th>总价</th>
								<th>购买人</th>
								<th>购买人返现</th>
								<th>上级</th>
								<th>上级返现</th>
								<th>上二级</th>
								<th>上二级返现</th>
								<th>上三级</th>
								<th>上三级返现</th>
								<th>返现状态</th>
							</tr>
							</thead>
							<tbody id="deduct-tr">

							</tbody>
						</table>
					</div>
					<form class="form-inline form-horizontal">
						<input type="hidden" id="hid_id" value="0">
						<input type="hidden" id="modal-type" value="refund">
						<input type="hidden" id="cate" value="list">
						<div class="row hid-row" id="show-refund">
							<div class="checkbox col-sm-12 mod-div">
								<label>审核状态 ： &nbsp;&nbsp;</label>
								<label>
									<input type="radio" name="status" checked value="2"> &nbsp; 通 &nbsp; 过 &nbsp;
								</label>
								<label>
									<input type="radio" name="status" value="1">  &nbsp; 拒 &nbsp; 绝 &nbsp;
								</label>
							</div>
						</div>
						<div class="row hid-row" id="show-express" style="margin:0">
							<!--发货HTML-->
							<table class="ui-table" style="margin-bottom:20px;">
								<thead>
								<tr>
									<th class="cell-35">商品</th>
									<th class="cell-5">数量</th>
									<th class="cell-5">单价</th>
									<th class="cell-5">总价</th>
								</tr>
								</thead>
								<tbody id="buy-goods-modal">

								</tbody>
							</table>
							<div class="control-group">
								<label class="control-label">收货信息：</label>
								<div class="controls">
									<div class="control-action" id="modal-address">

									</div>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">发货方式：</label>
								<div class="controls">
									<label class="radio inline">
										<input type="radio" data-validate="no" checked="" value="1" data-id="1" name="no_express"><span style="padding: 1px 5px;">需要物流</span>
									</label>
									<label class="radio inline">
										<input type="radio" data-validate="no" value="0" data-id="0" name="no_express"><span style="padding: 1px 5px;">无需物流</span>
									</label>
								</div>
							</div>
							<div class="control-group row" id="wuliu-info">
								<div class="col-xs-6">
									<label class="control-label">物流公司：</label>
									<div class="controls">
										<select id="express_id" name="express_id" class="form-control chosen-select" data-placeholder="请选择一个物流公司">
											<option value="0"></option>
											<{foreach $express as $key=>$val}>
											<option value="<{$key}>"><{$val}></option>
											<{/foreach}>
										</select>
										<p class="tip hide">*发货后，10分钟内可修改一次物流信息</p>
									</div>
								</div>
								<div class="col-xs-6">
									<label class="control-label">快递单号：</label>
									<div class="controls">
										<input type="text" id="express_code" name="express_code" class="form-control" />
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<span id="saveResult" ng-model="saveResult" class="text-center"></span>
					<button type="button" class="btn btn-primary modal-save" onclick="saveModal()" >保存</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!--维权结果处理-->
	<div class="modal fade" id="agreeTK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close"
							data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="agreeTKLabel">
						维权处理
					</h4>
				</div>
				<div class="modal-body">
					<div class="alert">
						订单中的部分商品，买家已提交了退款申请。你需要先跟买家协商，买家撤销退款申请后，才能进行发货操作。
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="ui-btn ui-btn-primary btn-refund" data-dismiss="modal">
						我知道了
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 批量发货导入文件弹框 -->
<div id="bulk_shipment" style="display: none;padding:5px 20px;">
	<div class="upload-tips">
		<form action="/wxapp/order/deliver" enctype="multipart/form-data" method="post">
			<label style="height:35px;line-height: 35px;">本地上传</label>
			<span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="order_deliver" type="file"></span>
			<p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传csv类型的文件</p>
			<div style="font-size: 14px;margin-top: 10px;" >注意　<span id="show-notice">最大支持 1 MB CSV的文件。</span></div>
			<div style="font-size: 14px;margin-top: 10px;" ><a href="/public/common/批量发货样本.csv" id="show-notice">下载批量发货模板</a></div>
		</form>
	</div>
</div>
<style>
	.layui-layer-btn{
		border-top: 1px solid #eee;
	}
	.upload-tips{
		/* overflow: hidden; */
	}
	.upload-tips label{
		display: inline-block;
		width: 70px;
	}
	.upload-tips p{
		display: inline-block;
		font-size: 13px;
		margin:0;
		color: #666;
		margin-left: 10px;
	}
	.upload-tips .upload-input{
		display: inline-block;
		text-align: center;
		height: 35px;
		line-height: 35px;
		background-color: #1276D8;
		color: #fff;
		width: 90px;
		position: relative;
		cursor: pointer;
	}
	.upload-tips .upload-input>input{
		display: block;
		height: 35px;
		width: 90px;
		opacity: 0;
		margin: 0;
		position: absolute;
		top: 0;
		left: 0;
		z-index: 2;
		cursor: pointer;
	}
</style>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/wxapp-order.js"></script>
<script type="text/javascript">
	$(function(){
		// 下拉搜索框
		$(".chosen-select").chosen({
			no_results_text: "没有找到",
			search_contains: true
		});

		/*添加备注信息*/
		$(".ui-table-order").on('click', '.js-opts .js-remark', function(event) {
			event.preventDefault();
			layer.prompt({
			  title: '添加备注信息',
			  formType: 2 //prompt风格，支持0-2
			}, function(text){
			   layer.msg('备注信息：'+ text);
			});
		});
		$('.js-deduct').on('click',function(){
			var tid = $(this).data('tid');
			if(tid){

				var data = {
					'tid' : tid
				};
				showDeduct(data);
			}
		});

		$('.order_finish').on('click',function(){
			var tid = $(this).data('tid');
			if(confirm('确认已完成订单？')){
				var index = layer.load(10, {
		            shade: [0.6,'#666']
		        });
				$.ajax({
		            'type'  : 'post',
		            'url'   : '/wxapp/order/finishOrder',
		            'data'  : {tid: tid},
		            'dataType' : 'json',
		            'success'   : function(ret){
		                layer.close(index);
		                if(ret.ec == 200){
		                    window.location.reload();
		                }else{
		                    layer.msg(ret.em);
		                }
		            }
		        });
			}
		});

		$('.refund-btn').on('click',function(){
			if(confirm("确定退款吗？")){
				var index = layer.load(10, {
					shade: [0.6,'#666']
				});
				var tid  = $(this).data('tid');
				var data = {
					'tid'	: tid,
					'status': 2,
				};
				$.ajax({
					'type'  : 'post',
					'url'   : '/wxapp/order/refundTrade',
					'data'  : data,
					'dataType'  : 'json',
					'success'   : function(ret){
						layer.close(index);
		                layer.msg(ret.em);
						if(ret.ec == 200){
							window.location.reload();
						}
					}
				});
			}
		});

        $('.express-btn').on('click',function(){
            var feedback = $(this).data('feedback');
            if(feedback == 1){ //有维权不可发货，除非会员取消维权状态为3
                $('#agreeTK').modal('show');
            }else{
                var tid = $(this).data('tid');
                var province = $(this).data('province');
                var city 	= $(this).data('city');
                var area 	= $(this).data('area');
                var address = $(this).data('address');
                var phone 	= $(this).data('phone');
                var name 	= $(this).data('name');
                var num     = $(this).data('tra-num');
                if(num > 0){
                    var _html = '';
                    for(var i=0; i< num ; i++){
                        _html += '<tr>';
                        _html += '<td><div>'+$(this).data('title_'+i)+'</div></td>';
                        _html += '<td>'+$(this).data('num_'+i)+'</td>';
                        _html += '<td>'+$(this).data('price_'+i)+'</td>';
                        _html += '<td>'+$(this).data('total_'+i)+'</td>';
                        _html += '</tr>';
                    }
                    $('#buy-goods-modal').html(_html);
                }
                $('#modal-address').html(province + ' '+city+ ' '+area+ ' '+address+ '，'+name+ ' '+phone);
                $('#hid_id').val(tid);
                $('#modal-type').val('express');
                $('#modelTitle').text('发货处理');
                hideFormShowById('express');
                $('#refund-form').modal('show');
            }

        });
		// 搜索框滚动
		//var formGroupNum = $(".form-group-box").find('.form-group').length;
		//$(".form-container").width(270*formGroupNum);
	});

	function selectedFile(obj){
		var path = $(obj).val();
		$(obj).parents('form').find('p').text(path);
	}

	$('[data-click-upload]').on('click', function(){
		var htmlTxt=$("#bulk_shipment");
		var that    = this;
		//页面层
		var layIndex = layer.open({
			type: 1,
			title: '文件路径',
			shadeClose: true, //点击遮罩关闭
			shade: 0.6, //遮罩透明度
			skin: 'layui-anim',
			area: ['500px', '200px'], //宽高
			btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
			content: htmlTxt,
			yes : function() {
				var loading = layer.load(2);
				var $form = htmlTxt.find('form');
				var url = $form.attr("action"),
						data = new FormData($form[0]);
				$.ajax(url, {
					type: "post",
					data: data,
					processData: false,
					contentType: false,
					dataType: 'json',
					success: function (data) {
						if (data.ec == 200) {
							layer.msg('批量发货成功');
						}else {
							layer.msg(data.em);
						}
						window.location.reload();
					},
					complete: function () {
						layer.close(loading);
						layer.close(layIndex);
					}
				});
			}
		});
	});


    /**
     * 自动确认收货失败手动同步信息
     */
    $('.express-synchron').on('click',function(){
        var tid = $(this).data('tid');
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'	: tid
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/order/expressSynchron',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    });

</script>
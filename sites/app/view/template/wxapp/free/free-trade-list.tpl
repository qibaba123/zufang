<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
	.datepicker{
		z-index: 1060 !important;
	}
	.ui-table-order .time-cell{
		width: 120px !important;
	}
	.ui-table-order .state-cell{
		width: 120px !important;
	}
	.form-group{
		margin-bottom: 10px !important;
	}
	.search-box{
		margin: 20px auto 20px;
	}

</style>

<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="/wxapp/free/freeTradeList" method="get">
			<div class="col-xs-11 form-group-box">
				<div class="form-container" style="width: auto !important;">
					<div class="form-group">
						<div class="input-group ">
							<div class="input-group-addon">项目名称</div>
							<input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="项目名称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">预约人</div>
							<input type="text" class="form-control" name="buyer" value="<{$buyer}>"  placeholder="预约人微信昵称">
						</div>
					</div>
					<!--

					-->
					<div class="form-group" style="width: 440px;">
						<div class="input-group">
							<div class="input-group-addon" >预约时间</div>
							<input type="text" class="form-control" name="appostart" value="<{$appostart}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="appoend" value="<{$appoend}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
					<div class="form-group" style="width: 440px;">
						<div class="input-group">
							<div class="input-group-addon" >下单时间</div>
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
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">订单状态</div>
							<select name="timeStatus" id="timeStatus" class="form-control">
								<option value="">全部</option>
								<option value="on">预约中</option>
								<option value="expire">已失效</option>
							</select>
						</div>
					</div>
						<!--
					<div class="form-group">
						<div class="input-group" style="width: 210px;">
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
						-->
					<input type="hidden" name="status" value="<{$status}>">
				</div>
			</div>
			<div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 35%;right: 2%;">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>

<div class="choose-state">
	<{foreach $link as $key=>$val}>
	<a href="/wxapp/free/freeTradeList?status=<{$key}>" <{if $status && $status eq $key}>class="active"<{/if}>><{$val['label']}></a>
	<{/foreach}>
	<!---
            <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;"><i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span></button>
    -->
</div>
<div class="trade-list">
	<table class="ui-table-order" style="padding: 0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
		    <tr class="widget-list-header">
		        <th class="" colspan="2" style="min-width: 212px; max-width: 212px;">预约项目</th>
		        <th class="customer-cell" style="min-width: 110px; max-width: 120px;">预约人</th>
		        <th class="time-cell" style="min-width: 80px; max-width: 80px;color: black">
		            <a href="javascript:;" data-orderby="book_time">下单时间</a>
		        </th>
		        <th class="state-cell" style="min-width: 100px; max-width: 100px;">订单状态</th>
		        <th class="pay-price-cell" colspan="2" style="min-width: 120px; max-width: 120px;">操作</th>
		    </tr>
		</thead>

		<{foreach $list as $val}>
		<tbody class="widget-list-item">
		<tr class="separation-row">
			<td colspan="6"></td>
		</tr>
		<tr class="header-row">
			<td colspan="5">
				<div>
					<{$val['es_name']}>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="1" class="text-right">
				<div class="order-opts-container">

				</div>
			</td>
		</tr>
		<tr class="content-row">
			<td class="image-cell">
				<{if $val['es_logo']}>
				<img src="<{$val['es_logo']}>">
				<{else}>
				<img src="/public/manage/img/zhanwei/zw_fxb_200_200.png">
				<{/if}>
			</td>
			<td class="title-cell">
				<p class="goods-title">
					预约项目：<{$val['acfp_name']}>
				</p>
				<p>
					预约时间：<{date('Y-m-d H:i',$val['acft_time'])}>
				</p>
				<p>
					<{if $val['acft_activity']}>
					预约礼：<{$val['acft_activity']}>
					<{/if}>
				</p>
			</td>
			<td class="customer-cell" rowspan="1" style="width: 250px">
				<p>
					<a href="/wxapp/free/freeTradeList?buyer=<{$val['m_nickname']}>" class="new-window" target="_blank">
						<{$val['m_nickname']}>
					</a>
				</p>
				<{foreach json_decode($val['acft_custom_data'], true) as $v}>
					<{if $v['type'] == 'upload'}>
					<p style="text-align: left"><{$v['data']['title']}>：<img src="<{$v['value']}>" alt=""></p>
					<{elseif $v['type'] == 'map'}>
					<p style="text-align: left"><{$v['data']['title']}>：<{$v['value'][0]}></p>
					<{else}>
					<p style="text-align: left"><{$v['data']['title']}>：<{$v['value']}></p>
					<{/if}>
				<{/foreach}>
			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<{date('Y-m-d H:i:s',$val['acft_create_time'])}>
				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<p>
						<{if $val['acft_time'] >= time()}>
						<span style="color: blue">预约中</span>
						<{else}>
						<span style="color: #777">已失效</span>
						<{/if}>
					</p>
					<p>
						<{if $val['acft_status'] == 1}>
						<span style="color: red">待处理</span>
						<{elseif $val['acft_status'] == 2}>
						<span style="color: green">已处理</span>
						<{else}>
						<span style="color: #777">已取消</span>
						<{/if}>
					</p>
					<{if $val['acft_handle_time'] > 0}>
					<p>
						<{date('Y-m-d H:i',$val['acft_handle_time'])}>
					</p>
					<{/if}>
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
                        <{if $val['acft_status'] == 1}>
						<a href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['acft_id']}>" class="btn btn-sm btn-primary confirm-handle">处理</a>
                        <{/if}>
					</div>
				</div>
			</td>
		</tr>
		<{if $val['acft_remark']}>
		<tr class="remark-row buyer-msg">
			<td colspan="6">备注： <{$val['acft_remark']}></td>
		</tr>
		<{/if}>
		<{if $val['acft_handle_remark']}>
			<tr class="remark-row handle-remark">
				<td colspan="6">处理备注： <{$val['acft_handle_remark']}></td>
			</tr>
			<{/if}>
		</tbody>
		<{/foreach}>

		<tbody class="widget-list-item">
		    <tr class="separation-row">
		        <td colspan="6"><{$page_html}> </td>
		    </tr>
		</tbody>
	</table>

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
<!-- 订单导出操作 -->
<style>
	/*大图弹框*/
	.modal{
		position: fixed;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background-color: rgba(0,0,0,.5);
		display: none;
	}
	.modal-img{
		position:absolute;
		max-width:90%;
		max-height:90%;
		left:5%;
		top:50%;
		z-index:3;
		transform:translateY(-50%);
		-webkit-transform:translateY(-50%);
	}
	.modal-img .image{
		width:100%;
		height:100%;
	}
	.modal-img img{
		width:100%;
		max-height:100%;
	}
	.space{
		margin: 12px 0;
		width: 100%;
	}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    订单处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="remark" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/order.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
	$(function(){
		/*初始化日期选择器*/
		$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

		$("input[id^='timepicker']").timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

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

        /* 选中select */
        var timeStatus = '<{$timeStatus}>';
        $('#timeStatus').val(timeStatus);


	});

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var remark = $('#remark').val();
        var data = {
            id : hid,
            remark : remark,
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/shop/free/handleFreeTrade',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });


	function selectedFile(obj){
		var path = $(obj).val();
		$(obj).parents('form').find('p').text(path);
	}


</script>
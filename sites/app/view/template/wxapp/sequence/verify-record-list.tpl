<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<style>
    .form-group {
        margin-bottom: 10px !important;
    }
</style>
<div id="content-con">
    <div  id="mainContent" >

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/verifyRecordList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="truename" value="<{$truename}>"  placeholder="姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">订单号</div>
                                    <input type="text" class="form-control" name="tid" value="<{$tid}>"  placeholder="订单号">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">核销码</div>
                                    <input type="text" class="form-control" name="code" value="<{$code}>"  placeholder="核销码">
                                </div>
                            </div>
                            <div class="form-group" style="width: 400px">
                                <div class="input-group">
                                    <div class="input-group-addon" >核销时间</div>
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


                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>订单号</th>
                            <th>核销码</th>
                            <th>核销人</th>
                            <th>核销时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ov_id']}>">
                                <td>
                                    <a href="/wxapp/order/tradeDetail?order_no=<{$val['ov_se_tid']}>" target="_blank"><{$val['ov_se_tid']}></a>
                                </td>
                                <td>
                                    <{$val['ov_value']}>
                                </td>
                                <td>
                                    <{if $val['ov_se_mid']}>
                                    <p>
                                        昵称：<{$val['m_nickname']}>（会员编号：<{$val['m_show_id']}>）
                                    </p>
                                    <p>
                                        姓名：<{$val['asl_name']}>
                                    </p>
                                    <{else}>
                                    <p>
                                        后台核销
                                    </p>
                                    <{/if}>
                                </td>
                                <td><{date('Y-m-d H:i',$val['ov_record_time'])}></td>
                            </tr>
                            <{/foreach}>

                        	<!--<tr><td colspan="4" class='text-right'></td></tr>-->

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
    <{if $showPage != 0 }>
    <div style="height: 53px;margin-top: 15px;">
	    <div class="bottom-opera-fixd">
	        <div class="bottom-opera">	            
	            <div class="bottom-opera-item" style="text-align:center;">
	                <div class="page-part-wrap"><{$pagination}></div>
	            </div>
	        </div>
	    </div>
	</div>
	<{/if}>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    $(function () {
        /*初始化日期选择器*/
        //$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        //    $(this).prev().focus();
        //});
    });
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<!--<link rel="stylesheet" type="text/css" href="/public/wxapp/city/fancyBox/css/jquery.fancybox.min.css" >-->
<link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/lrtk.css?1">
<link rel="stylesheet" href="/public/plugin/prettyPhoto/css/prettyPhoto.css">

<style>
    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: calc(100% / 4);
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
    .form-inline .form-control{
        width: auto!important;
    }
</style>



<div id="content-con">
    <div  id="mainContent" >

        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">全部商家<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">申请中<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_sqz']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已通过<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_ytg']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已拒绝<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_yjj']}></span>
                </div>
            </div>

        </div>

        <div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>
        </div>
        <div class='panel panel-default'>
            <div class='panel-body'>
                <form class='form-inline'>
                    <div class='form-group'>
                        <label>店铺名称：</label>
                        <input class='form-control' type="text" name="apply_name" value='<{$smarty.get.apply_name}>'>
                    </div>
                    <div class='form-group'>
                        <label>申请电话：</label>
                        <input  class='form-control'  type="text" name="apply_mobile" value='<{$smarty.get.apply_mobile}>'>
                    </div>
                    <div class='form-group'>
                        <label>分类：</label>
                        <select class='form-control' name='apply_cate'>
                            <option value=''>请选择分类</option>
                            <{foreach $cate as $key => $item}>
                            <option value='<{$key}>' <{if $smarty.get.apply_name == $key}>selected<{/if}> ><{$item}></option>
                            <{/foreach}>
                        </select>
                    </div>
                    <button class='btn btn-sm btn-primary'><i class='fa icon-search'></i>搜索</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>

                            <th>申请店铺名称</th>
                            <th>申请电话</th>
                            <th>分类</th>
                            <!--
                            <th>营业时间</th>
                            <th>申请店铺地址</th>
                            <th>店铺实景</th>
                            <th>资质证书</th>
                            <th>店铺简介</th>
                            -->
                            <th>店铺标签</th>
                            <th>申请状态</th>
                            <th>申请时间</th>
                            <th>处理备注</th>
                            <th>处理时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acs_id']}>">

                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><{$val['acs_name']}></td>
                                <td><{$val['acs_mobile']}></td>
                                <td><{$cate[$val['acs_category_id']]}></td>
                                <!--
                                <td><{$val['acs_open_time']}></td>
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><{$val['acs_address']}></td>
                                <td><img src="<{$val['acs_cover']}>" alt="" style="width: 100px"/></td>
                                <!-- <a class="fancybox" data-fancybox="images" href="<{$val['acs_aptitude']}>">-->
                                <!--
                                <td style="min-width: 100px">
                                    <!-- 防止无图时插件报错
                                    <{if $val['acs_aptitude']}>
                                    <a href="<{$val['acs_aptitude']}>" rel="prettyPhoto[]"><img src="<{$val['acs_aptitude']}>" alt="" style="width: 100px"/></a>
                                    <{/if}>
                                </td>
                                <td style="min-width: 200px;word-break: break-all;white-space: normal;"><{$val['acs_brief']}></td>
                                -->
                                <td><{$val['acs_label']}></td>
                                <td style="color: <{if $val['acs_status'] eq 2}>green<{else}>red<{/if}>"><{$status[$val['acs_status']]}></td>
                                <td><{if $val['acs_create_time'] > 0}><{date('Y-m-d H:i',$val['acs_create_time'])}><{/if}></td>
                                <td><{$val['acs_handle_remark']}></td>
                                <td><{if $val['acs_handle_time'] > 0}><{date('Y-m-d H:i',$val['acs_handle_time'])}><{/if}></td>
                                <td class="jg-line-color">
                                    <{if $val['acs_status'] eq 1}>
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['acs_id']}>">处理</a> -
                                    <{/if}>
                                    <a href="/wxapp/city/applyDetail?id=<{$val['acs_id']}>">详情</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="14"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
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
<div class="modal fade" id="settledAgreement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="form-group">
                <label class="control-label" style="height: 50px;line-height: 50px;margin-left: 5%;font-size: 16px;font-weight: bold;">商家入驻协议：</label>
                <div class="control-group" style="margin-left:5%;">
                    <textarea class="form-control" style="width:90%;height:350px;" id="settledAgreement" name="settledAgreement" placeholder="入驻协议"  rows="20" style=" text-align: left; resize:vertical;" ><{if $indexTpl && $indexTpl['aci_agreement']}><{$indexTpl['aci_agreement']}><{/if}></textarea>
                    <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                    <input type="hidden" name="ke_textarea_name" value="settledAgreement" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="saveSettledAgreement">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{include file="../../manage/common-kind-editor.tpl"}>
<!--<script src="/public/wxapp/city/fancyBox/js/jquery.fancybox.min.js"></script>-->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script>
//	图片放大预览效果
	$(document).ready(function() {
//		$("[data-fancybox]").fancybox({
//			// Options will go here
//		});
//		$("area[rel^='prettyPhoto']").prettyPhoto();
//		        $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		 $("a[rel^='prettyPhoto']").prettyPhoto();
	});
	
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var status = $('#status').val();
        var data = {
            id : hid,
            market : market,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/handleApply',
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

    $('#saveSettledAgreement').on('click',function(){
        var settledAgreement = $('textarea[name=settledAgreement]').val();
        console.log(settledAgreement);
        if(settledAgreement){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/saveSettledAgreement',
                'data'  : { settledAgreement:settledAgreement},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('请填写入驻协议');
        }
    });

</script>
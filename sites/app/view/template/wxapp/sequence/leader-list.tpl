<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }

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
        width: 50%;
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
    #leaderRule{
        z-index: 100 !important;
    }

    form select{
        -webkit-appearance:none;
    }
    form .row{
        margin-bottom:10px;
    }
    form .small-group{
        width: 170px!important;
    }
    
    /*分页颜色*/
	.page-part-wrap{ text-align: center;}
	.page-part-wrap .pagination a{color: #666;background-color: #f0f0f0;}
	.page-part-wrap .pagination .current,.page-part-wrap .pagination a:hover{background-color: #008df2;}
	.page-part-wrap .pagination a,.page-part-wrap .pagination span{margin-bottom: 0;}
	
	/*底部操作悬浮*/
	.bottom-opera-fixd { position: fixed; left: 50%; width: 860px; bottom: 0; z-index: 15; background-color: #fff; border-radius: 4px; box-shadow: 0 0 10px #ddd; padding: 0 15px; margin-left: -430px; }
	.bottom-opera-fixd .pagination{margin: 10px 0;}
	.bottom-opera-fixd .bottom-opera{display: table;width: 100%;}
	.bottom-opera-fixd .bottom-opera-item{display: table-cell;vertical-align: middle;}
</style>
<{include file="../article-ue-editor.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <!-- 汇总信息 -->
        <{if $parentid == 0}>
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">团长总数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">累计团长佣金<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['money']}></span>
                </div>
            </div>
        </div>

        <div class="page-header">
            <!--
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加团长</a>
            -->
            <a class="btn btn-green btn-xs" href="/wxapp/sequence/leaderEdit" ><i class="icon-plus bigger-80"></i>添加团长</a>
            <a class="btn btn-green btn-xs" href="/wxapp/sequence/leaderExcel" >团长导出</a>
            <{if $region == '' || $region== null}>
            <a class="btn btn-primary btn-xs add-activity" href="#" data-toggle="modal" data-target="#leaderRule">团长申请说明</a>
            <a class="btn btn-warning btn-xs " href="/wxapp/configs/config#leaderconfig" target="_blank">团长退款/团长推荐奖励设置</a>
           <!--  <span style="margin-left: 20px">
                <span class="switch-title">启用团长退款：</span>
                <label id="choose-onoff" class="choose-onoff">
                    <input class="ace ace-switch ace-switch-5" id="leaderRefundOpen"  data-type="open" onchange="changeOpen('leaderRefund')" type="checkbox" <{if ($cfg && $cfg['asc_leader_refund']) || !$cfg}>checked<{/if}>>
                    <span class="lbl"></span>
                </label>
            </span>
            <{if $sequenceShowAll == 1}>
            <span style='margin-left:20px;'>
                <span class='switch-title'>启用团长推荐奖励：</span>
                <label id='leader-recmd-reward-onoff' class='choose-onoff'>
                    <input id='leader-recmd-reward' class='ace ace-switch ace-switch-5' data-type="open" type='checkbox'
                    <{if $cfg && $cfg['asc_leader_recmd_reward']==1}>checked<{/if}>
                    >
                    <span class="lbl"></span>
                </label>
            </span>
            <div id='leader-reward-per' class='form-inline' style="display:<{if $cfg && $cfg['asc_leader_recmd_reward']==1}>inline-block;<{else}>none;<{/if}>">
                <div class='form-group'>
                    <div class="input-group" style='width: 120px;'>
                        <input id='leader_recmd_reward_value' class='form-control' style='display: inline-block;width: 100px;' type="number" value="<{$cfg['asc_leader_recmd_reward_percent']}>"" placeholder="奖励百分比">
                        <div class="input-group-addon">%</div>
                    </div>
                </div>
                <button id='save_leader_recmd_reward' class='btn btn-sm btn-primary'>保存</button>
            </div>
            <i class='fa icon-question-sign' data-toggle="tooltip" data-placement="bottom" title="开启团长推荐奖励功能，申请团长时填写推荐人的推荐码或扫描推荐人的小程序码。申请成功后推荐人即可获取被推荐人的订单佣金。推荐人获取的佣金将从被推荐人获取的佣金中按照百分比进行扣除。"></i>
            <{/if}> -->
            <{/if}>
            <div style="color:red;">
                成为团长后，各团长在小程序"个人中心"->"团长管理中心"进行团长订单核销、提现等操作
            </div>
        </div>
        <!--/.page-header-->
        <{/if}>
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/leaderList" method="get">
                    <input type="hidden" value="<{$parentid}>" name="parentid">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class='row'>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">用户名</div>
                                        <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="用户名">
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
                                        <div class="input-group-addon">电话</div>
                                        <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="电话">
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='form-group small-group'>
                                    <div class="input-group">
                                        <select id='prov' class='form-control' name='province' data-type='province'>
                                            <option value='0'>请选择城市</option>
                                            <{foreach $province as $item}>
                                            <option <{if $smarty.get.province==$item.region_id}>selected<{/if}> value='<{$item.region_id}>'><{$item.region_name}></option>>
                                            <{/foreach}>
                                        </select>
                                        <span class="input-group-addon">省</span>
                                    </div>
                                </div>
                                <div class='form-group small-group'>
                                    <div class="input-group">
                                        <select id='city' name=city class='form-control' data-type='city'>
                                            <option value='0'>请选择城市</option>
                                            <{foreach $citys as $item}>
                                            <option <{if $smarty.get.city==$item.region_id}>selected<{/if}> value='<{$item.region_id}>'><{$item.region_name}></option>>
                                            <{/foreach}>
                                        </select>
                                        <span class="input-group-addon">市</span>
                                    </div>
                                </div>
                                <div class='form-group small-group'>
                                    <div class="input-group">
                                        <select id='zone' name='zone' class='form-control'>
                                            <option value='0'>请选择区域</option>
                                            <{foreach $zones as $item}>
                                            <option <{if $smarty.get.zone==$item.region_id}>selected<{/if}> value='<{$item.region_id}>'><{$item.region_name}></option>>
                                            <{/foreach}>
                                        </select>
                                        <span class="input-group-addon">区/县</span>
                                    </div>    
                                </div>
                                <{if $region=='' && $show_area_leader==1}>
                                <div class='form-group'>
                                     <div class="input-group">
                                        <div class="input-group-addon">合伙人手机号</div>
                                        <input type="tel" class="form-control" name="region_mobile" value="<{$region_mobile}>"  placeholder="区域合伙人手机号码">
                                    </div>
                                </div>
                                <{/if}>
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
                            <th>会员编号</th>
                            <th>头像</th>
                            <th>团长信息</th>
                            <{if $curr_shop['s_id'] == 9373}>
                            <th>合伙人</th>
                            <{/if}>
                            <th id="percent_sort" style="cursor: pointer">分佣比例 <i class="<{if $smarty.get.percent=='up'}>icon-caret-up<{else if $smarty.get.percent=='down' || $smarty.get.percent==''}>icon-caret-down<{/if}>" style='padding-left: 3px;'></i></th>
                            <th id='sort' style='cursor: pointer;'>佣金 <i class="<{if $smarty.get.deduct=='up'}>icon-caret-up<{else if $smarty.get.deduct=='down' || $smarty.get.deduct==''}>icon-caret-down<{/if}>" style='padding-left: 3px;'></i></th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asl_id']}>">
                                <td><{$val['m_show_id']}></td>
                                <td>
                                    <img src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>'/public/wxapp/images/applet-avatar.png'<{/if}>" alt="" style="width: 50px;margin:0;border-radius:4px;">
                                </td>
                                <td>
                                    <p>昵称：<span style='color:#9a999e;'><{$val['m_nickname']}></span></p>
                                    <p>姓名：<span style='color:#9a999e;'><{$val['asl_name']}></span></p>
                                    <p>手机：<span style='color:#9a999e;'><{$val['asl_mobile']}></span></p>
                                    <{if $val.recmd_man_id}>
                                    <p>推荐人：<a target="_blank" href="/wxapp/sequence/leaderEdit?id=<{$val.recmd_man_id}>" style='color:#9a999e;text-decoration: underline;'><{$val.recmd_man}></a></p>
                                    <{/if}>
                                </td> 

                                <{if $curr_shop['s_id'] == 9373}>
                                <td>
                                    <{$val['esm_nickname']}><br>
                                    <{$val['esm_mobile']}><br>
                                </td>
                                <{/if}>
                                <td>
                                    <{$val['asl_percent']}>%
                                </td>
                                <td>
                                    <p>可提现：<span class='text-success'>￥<{floatval($val['m_deduct_ktx'])}></span></p>
                                    <p>已提现：<span class='text-warning'>￥<{floatval($val['m_deduct_ytx'])}></span></p>
                                    <p>审核中：<span class='text-danger'>￥<{floatval($val['m_deduct_dsh'])}></span></p>
                                    <p>总 计： <span style="font-weight: bold">￥<{$val['m_deduct_ktx'] + $val['m_deduct_ytx'] + $val['m_deduct_dsh']}></span></p>
                                </td>
                                <td class="jg-line-color">
                                    <p>

                                        <a href="/wxapp/sequence/leaderInfo?id=<{$val['asl_id']}>">营业详情</a>
                                         - <a href="/wxapp/sequence/leaderDeductRecordNew?id=<{$val['asl_id']}>&mid=<{$val['asl_m_id']}>">佣金详情</a>

                                        <{if $sequenceShowAll == 1}>
                                         - <a href="/wxapp/sequence/leaderRecmdRecord?leader_id=<{$val['asl_id']}>" title='推荐团长获取到的佣金奖励'>推荐奖励</a>
                                        <{/if}>
                                    </p>
                                    <p>                                       
                                        <{if $curr_shop['s_id'] == 9373}>
	                                        <{if $val['esm_id'] > 0}>
	                                        <a data-id="<{$val['asl_id']}>" onclick="confirmClearManager(this)" style="color:#f00;">清除合伙人</a> - 
	                                        <{else}>
	                                        <a data-id="<{$val['asl_id']}>" data-mk="choose" class="get-managers">关联合伙人</a> - 
	                                        <{/if}>
                                        <{/if}>
                                        <{if $sequenceShowAll == 1}>
                                        <a href="/wxapp/sequence/leaderList?parentid=<{$val['asl_id']}>" target="_blank">查看「我」推荐的团长</a>
                                        <{/if}>
                                    </p>
                                    <p>
                                        <a href="/wxapp/sequence/leaderEdit?id=<{$val['asl_id']}>">编辑</a>
                                        <a data-id="<{$val['asl_id']}>" onclick="confirmDelete(this)" style="color:red;">取消团长</a>
                                    </p>
                                    <{if $sequenceShowAll == 1}>
                                    <{if $region=='' && $show_area_leader==1}>
                                    <p>
                                         <a href="javascript:;" class='text-success region-modal' data-id="<{$val['asl_id']}>" data-province="<{$val['asl_apply_province']}>" data-manager="<{$val['asl_region_manager_id']}>">分配团长</a>
                                    </p>
                                    <{/if}>
                                        <p>
                                            <a href="javascript:;" class='text-info recommend-modal' data-id="<{$val['asl_id']}>" ><{if $val['asl_parent_id']}>修改推荐人<{else}>添加推荐人<{/if}></a>
                                        </p>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>

                        <!--<tr><td colspan=" <{if $curr_shop['s_id'] == 9373}>7<{else}>6<{/if}>" class='text-right'></td></tr>-->

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<{if $showPage != 0 }>
<!--固定分页底部-->
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">
            <div class="bottom-opera-item" style="text-align:center">
                <div class="page-part-wrap"><{$pagination}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content" style="overflow: visible">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加团长
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">

                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">微信昵称：</label>
                    <div class="col-sm-8">
                        <{include file="../layer/ajax-select-input-single.tpl"}>
                        <input type="hidden" id="hid_acsId" value="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="comfirm-area">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="leaderRule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 740px;">
        <div class="modal-content">
            <div class="form-group">
                <label class="control-label" style="height: 50px;line-height: 50px;margin-left: 5%;font-size: 16px;font-weight: bold;">团长申请说明：</label>
                <div>
                    <div class="form-textarea" style="margin-left:1%;margin-right: 1%">
                        <textarea  style="height:450px;" id="leader-rule" name="leader-rule" placeholder="申请说明"  rows="20" style=" text-align: left; resize:vertical;" ><{if $cfg && $cfg['asc_leader_rule']}><{$cfg['asc_leader_rule']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="leader-rule" />
                    </div>
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
<div id="region-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">分配团长至区域合伙人</h4>
            </div>
            <div class="modal-body" style="padding: 10px 20px!important;">
                <div class="good-search">
                    <div class="input-group" style='margin: 0;width: 100%;'>
                        <input type="number" id="mobile" class="form-control search-input" placeholder="手机号码">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" id='search'>
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr style="margin-top: 10px">
                <table class="table table-responsive">
                    <input type="hidden" id="leader" value="">
                    <input type="hidden" id="province" value="">
                    <input type="hidden" id="leader-manager" value="">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th style="text-align:left">昵称</th>
                            <th class="th-truename">手机号码</th>
                            <th>区域名称</th>
                            <th>操作</th>
                        </tr>
                    </thead>

                    <tbody id="region-tr">
                    <!--区域管理员列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!--修改团长推荐人-->
<div id="recommend-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">选择上级推荐人</h4>
            </div>
            <div class="modal-body" style="padding: 10px 20px!important;">
                <div class="good-search">
                    <div class="input-group" style='margin: 0;width: 100%;'>
                        <input type="number" id="recommend-mobile" class="form-control search-input" placeholder="手机号码">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary" id='recommend-search'>
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr style="margin-top: 10px">
                <table class="table table-responsive">
                    <input type="hidden" id="leader_id" value="">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>昵称</th>
                        <th>手机号码</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody id="recommend-tr">
                    <!--区域管理员列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="recommend-footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<{include file="../img-upload-modal.tpl"}>

<{include file="../fetch-manager-modal.tpl"}>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<!-- <script type="text/javascript" src="/public/manage/controllers/goods.js"></script> -->
<script>
    $(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('#sort').click(function(){
            if($(this).find('i').hasClass('icon-caret-up'))
                location.href='/wxapp/sequence/leaderList?deduct=down';
            else
                location.href='/wxapp/sequence/leaderList?deduct=up';
        });

        $('#percent_sort').click(function(){
            if($(this).find('i').hasClass('icon-caret-up'))
                location.href='/wxapp/sequence/leaderList?percent=down';
            else
                location.href='/wxapp/sequence/leaderList?percent=up';
        });
        $('#prov,#city').change(function(){
            let p_id=$(this).val();
            let type=$(this).data('type');
            if(p_id==0){
                if(type=='province'){
                    $('#city').find('option[value="0"]').attr('selected',true);
                }
                $('#zone').find('option[value="0"]').attr('selected',true);
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

        $('#leader-recmd-reward').change(function(){
            let type=$(this).prop('checked');
            if(type){
                $('#leader-reward-per').css({'display':'inline-block'});
            }else{
                 layer.confirm('是否要修改团长推荐比例状态与分成比例？', {
                title:'提示',
                btn: ['确定','取消'] //按钮
            }, function(){});
                $('#leader-reward-per').hide();
                //关闭的时候需要同时关闭当前的推荐团长设置
                $.ajax({
                    type:'post',
                    url:'/wxapp/sequence/leaderRewardPer',
                    dataType:'json',
                    data:{
                        'close_type':'close'
                    },
                    success:function(res){
                        layer.msg(res.em);
                    }
                });
            }
        });
        // 保存团长推荐信息
        $('#save_leader_recmd_reward').click(function(){

            layer.confirm('是否要修改团长推荐比例状态与分成比例？', {
                title:'提示',
                btn: ['确定','取消'] //按钮
            }, function(){
                let status= $('#leader-recmd-reward').prop('checked');
                let reward_per=$('#leader_recmd_reward_value').val();
                $.ajax({
                    type:'post',
                    url:'/wxapp/sequence/leaderRewardPer',
                    dataType:'json',
                    data:{
                        'status':status?1:0,
                        'reward_per':reward_per,
                    },
                    success:function(res){
                        layer.msg(res.em);
                    }
                });

            });
        });
    })
    //团长分配至区域管理的逻辑
    function getMangerList(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {            
            'page'  : page,
            'mobile':$('#mobile').val(),
            'province':$('#province').val(),
            'leaderManager' : $('#leader-manager').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/Seqregion/getRegionManagerLess',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    if(ret.list=='')
                        layer.msg('未搜索到数据');
                    setMangerListHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }
    function setMangerListHtml(data){
        var mk = $('#mkType').val();
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].m_id+'">';
            html += '<td>'+data[i].m_id+'</td>';
            html += '<td>'+data[i].m_nickname+'</td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].m_mobile+'</p></td>';
            if(data[i].city!=data[i].zone){
                html += '<td style="text-align:center"><p class="g-name">'+data[i].city+'-'+data[i].zone+'</p></td>';
            }else{
                html += '<td style="text-align:center"><p class="g-name">'+data[i].zone+'</p></td>';
            }
            if(data[i].selected == 1){
                html += '<td>已分配</td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info dealData" data-mid="'+data[i].m_id+'"> 分配至此管理员 </td>';
            }

            html += '</tr>';
        }
        $('#region-tr').html(html);
    }
    $(function(){
        $('.region-modal').click(function(){
            var leader_id=$(this).data('id');
            var province=$(this).data('province');
            $('#leader').val(leader_id);
            $('#province').val(province);
            $('#leader-manager').val($(this).data('manager'));
            getMangerList(1);
            $('#region-modal').modal('show');
        });
        $('#search').click(function(){
            getMangerList(1);
        });
        $('#region-tr').on('click','.dealData',function(){
            let region=$(this).data('mid');
            let leader=$('#leader').val();
            $.ajax({
                type:'post',
                url:'/wxapp/sequence/changeLeaderRegionArea',
                dataType:'json',
                data:{
                    'leader':leader,
                    'region':region
                },
                success:function(res){
                    layer.msg(res.em);
                    if(res.ec==200)
                        $('#region-modal').modal('hide');
                }
            });
        })
    });

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#asa_name').val($(this).data('name'));
        $('#asa_poster_name').val($(this).data('postername'));
        $('#asa_poster_mobile').val($(this).data('postermobile'));

    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#asa_name').val('');
        $('#asa_poster_name').val('');
        $('#asa_poster_mobile').val('');
    });

    $('#comfirm-area').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#asa_name').val();
        var posterName = $('#asa_poster_name').val();
        var posterMobile  = $('#asa_poster_mobile').val();
        var data = {
            id     : id,
            name   : name,
            posterMobile : posterMobile,
            posterName  : posterName,
        };
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/areaSave',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });

    function confirmDelete(ele) {
        layer.confirm('确定取消吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/leaderRemove',
                    'data'  : { id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });

    }

    function confirmClearManager(ele) {
        layer.confirm('确定清除合伙人吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/clearManager',
                    'data'  : { id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });

    }

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#category-cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    function changeOpen(type) {
        var open   = $('#'+type+'Open:checked').val();
        var data = {
            value:open,
            type : type
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/changeCfgOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
            }
        });
    }

    $('#saveSettledAgreement').on('click',function(){
        //var leaderRule = $('textarea[name=leader-rule]').val();
        var leaderRule = weddingTaocanDetailArray[0];
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/saveLeaderRule',
            'data'  : { leaderRule:leaderRule},
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    });

    $('.recommend-modal').click(function(){
        var leader_id = $(this).data('id');
        $('#leader_id').val(leader_id);
        getRecommendList(0);
        $('#recommend-modal').modal('show');
    });

    //团长设置推荐人的逻辑
    function getRecommendList(page){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'page'  : page,
            'mobile':$('#recommend-mobile').val(),
            'leader_id':$('#leader_id').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/leaderListForSelect',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    if(ret.list=='')
                        layer.msg('未搜索到数据');
                    setRecommendListHtml(ret.list);
                    $('#recommend-footer-page').html(ret.pageHtml)
                }
            }
        });
    }
    function setRecommendListHtml(data){
        var mk = $('#mkType').val();
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].asl_id+'">';
            html += '<td style="text-align:center">'+data[i].asl_id+'</td>';
            html += '<td style="text-align:center">'+data[i].asl_name+'</td>';
            html += '<td style="text-align:center"><p class="g-name">'+data[i].asl_mobile+'</p></td>';
            html += '<td style="text-align:center"><a href="javascript:;" class="btn btn-xs btn-info select-recommend" data-aslid="'+data[i].asl_id+'"> 选择推荐人 </td>';


            html += '</tr>';
        }
        $('#recommend-tr').html(html);
    }

    $('#recommend-search').click(function(){
        getRecommendList(0);
    });

    $('#recommend-tr').on('click','.select-recommend',function(){
        var recommendId=$(this).data('aslid');
        var leader_id=$('#leader_id').val();
        $.ajax({
            type:'post',
            url:'/wxapp/sequence/setLeaderRecommend',
            dataType:'json',
            data:{
                'recommendId':recommendId,
                'leader_id':leader_id
            },
            success:function(res){
                layer.msg(res.em);
                if(res.ec==200)
                    window.location.reload();
                    $('#recommend-modal').modal('hide');
            }
        });
    })
</script>
<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
    .form-group select{
        -webkit-appearance:none;
    }
    .table.table-avatar tbody>tr>td { line-height: 1.5; }
    .datepicker { z-index: 1060 !important; }
    .ui-table-order .time-cell { width: 120px !important; }
    .form-group-box { overflow: auto; }
    .form-group-box .form-group { width: 260px; margin-right: 10px; float: left; }
    .fixed-table-box .table thead>tr>th, .fixed-table-body .table tbody>tr>td { text-align: center; }
    .fixed-table-body { max-height: inherit; }
    .recharge-btn, .point-btn { margin-left: 10px; }
    .waiter-dialog { width: 500px !important; }
    .waiter-content { overflow: visible !important; }
    .radio-box span { margin-right: 45px !important; }
    #waiter_shop { max-width: 250px; }

    /* 扣费弹出框 */
    .ui-popover, .openid-box { background: #000 none repeat scroll 0 0; border-radius: 6px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); padding: 2px; z-index: 1010; display: none; position: absolute; right: 0; top: 75%; width: 340px; left: auto; }
    .ui-popover .ui-popover-inner { background: #fff none repeat scroll 0 0; border-radius: 4px; min-width: 280px; padding: 10px; }
    .ui-popover .ui-popover-inner .money-input, .ui-popover .ui-popover-inner .point-input { border-radius: 4px !important; line-height: 19px; -webkit-transition: border linear .2s, box-shadow linear .2s; -moz-transition: border linear .2s, box-shadow linear .2s; -o-transition: border linear .2s, box-shadow linear .2s; transition: border linear .2s, box-shadow linear .2s; }
    .ui-popover .ui-popover-inner .money-input:focus, .ui-popover .ui-popover-inner .point-input:focus { border: 1px solid #73b8ee; -webkit-box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075); -moz-box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075); box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075); }
    .ui-popover .arrow { border: 5px solid transparent; height: 0; position: absolute; width: 0; }
    .ui-popover.top-center .arrow { left: 90%; margin-left: -5px; top: -10px; }
    .ui-popover.top-left .arrow, .ui-popover.top-center .arrow, .ui-popover.top-right .arrow { border-bottom-color: #000; }
    .ui-popover .arrow::after { border: 5px solid transparent; content: " "; display: block; font-size: 0; height: 0; position: relative; width: 0; }
    .ui-popover.top-center .arrow::after { left: -5px; top: -3px; }
    .ui-popover.top-left .arrow::after, .ui-popover.top-center .arrow::after, .ui-popover.top-right .arrow::after { border-bottom-color: #fff; }
    .bottom-tr td { line-height: 25px !important; }
    .btn-openid { text-align: center; margin: 0 auto; }
    #sample-table-1 { border-right: none; border-left: none; }

    .balance .balance-info{
        <{if ($canBan == 1 && $category == 0) || (!$canBan && $category > 0)}>
        width: 25% !important;
        <{elseif $canBan == 1 && $category > 0}>
        width: 20% !important;
        <{else}>
        width: 33.33% !important;
        <{/if}>
    }
    
    .img-thumbnail{width:60px!important;height:60px!important;}
	.tr-content .user-admend{display:inline-block!important;width:0;height:0;overflow:hidden;cursor:pointer;}
	.tr-content:hover .user-admend{width:13px;height:13px;cursor:pointer;}

    .search-box .form-group{
        float: none;
        margin-bottom:10px;
    }
    .fixed-table-body .td-min-width{
        min-width: 50px!important;
        width: 50px!important;
    }
    .fixed-table-body td,.fixed-table-body th{
        min-width: 50px!important;
    }
    .fixed-table-box th{
        border-top: 1px solid #ddd!important;
        border-bottom: 1px solid #ddd!important;
    }
    .form-container{
        width:auto!important;
    }
</style>
<!-- openid弹出框 -->
<div class="ui-popover ui-popover-openid left-center" style="top:100px;" popover-type="openid">
    <!--
    <div class="arrow"></div>
    -->
    <div class="ui-popover-inner">
        <div class="input-group copy-div">
            <input type="text" class="form-control" id="copy" value="" readonly>
            <span class="input-group-btn">
                    <button class="copy-openid btn btn-white" data-clipboard-action="copy" data-clipboard-text="" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center;z-index: 3000">复制</button>
            </span>
        </div>
    </div>
</div>
<div class="ui-popover ui-popover-select left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <select id="member-grade" name="jiaohuo">
            <{if $mLevel}>
                <option value="0">请选择等级</option>
                <option value="-1">清除会员等级</option>
            <{foreach $mLevel as $key=>$val}>
                <option value="<{$key}>"><{$val}></option>
            <{/foreach}>
            <{else}>
                <option value="0">尚未添加等级</option>
            <{/if}>
        </select>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn ui-btn-primary js-save" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div class="ui-popover ui-popover-time left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span></span>
        <input type="text" id="endDate" style="margin:0">
        <input type="hidden" id="hid_dateid" value="0">
        <a class="ui-btn ui-btn-primary js-save-date" href="javascript:;" onclick="saveDate(this)">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>

<{if $addMember == 1}>
<a href="javascript:;" onclick="addMember()" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
<{/if}>
<a href="javascript:;" class="btn btn-green btn-xs btn-excel" ><i class="icon-download"></i>用户导出</a>
<div id="content-con">
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/member/list" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <input type="hidden" name="type" value="<{if $type}><{$type}><{else}>all<{/if}>">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>" placeholder="用户昵称">
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">用户编号</div>
                                <input type="text" class="form-control" name="mid"  value="<{if $mid}><{$mid}><{/if}>" placeholder="编号">
                            </div>
                        </div>
                        <{if $addMember == 1}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">用户来源</div>
                                <select name="source" id="source" class="form-control">
                                    <option value="0">全部</option>
                                    <option value="2" <{if $source eq 2}>selected<{/if}> >小程序</option>
                                    <option value="5" <{if $source eq 5}>selected<{/if}> >后台添加</option>
                                </select>
                            </div>
                        </div>
                        <{/if}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">分类</div>
                                <select name="category" id="category" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $memberCategory as $key =>$val}>
                                    <option value="<{$key}>" <{if $key == $category}>selected<{/if}>><{$val['mc_name']}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="choose-state">
        <!--<{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $type eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>-->
        <!---
        <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;">
            <i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span>
        </button>
        -->
    </div>
    <!-- 订单汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;border-top:none;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">今日新增用户<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['totalToday']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">近7天新增<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total7days']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">用户总数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
        <{if $canBan == 1}>
        <div class="balance-info">
            <div class="balance-title">被封禁用户<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['totalBan']}></span>
            </div>
        </div>
        <{/if}>
        <{if $category > 0}>
        <div class="balance-info">
            <div class="balance-title">当前分类用户<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['totalCate']}></span>
            </div>
        </div>
        <{/if}>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fixed-table-box" style="margin-bottom: 30px;"> 
                        <div class="fixed-table-body">
                            <table id="sample-table-1" class="table table-hover table-avatar">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            <label>
                                                <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>用户编号</th>
                                        <th class="hidden-480">头像</th>
                                        <th>用户昵称</th>
                                        <th>用户状态</th>
                                        <th>手机号</th>
                                        <!--新增来源  同城的可以-->
                                        <{if $addMember == 1}>
                                        <th>来源</th>
                                        <{/if}>
                                        <th>余额</th>
                                        <th>收益</th>
                                        <{if $appletCfg['ac_type'] != 34}>
                                        <th>积分</th>
                                        <{/if}>
                                        <th>账户状态</th>                             
                                        <th>关注时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <{foreach $list as $val}>
                                    <tr id="tr_<{$val['m_id']}>" class="tr-content">
                                        <td class="center td-min-width">
                                            <label>
                                                <input type="checkbox" class="ace" name="ids" value="<{$val['m_id']}>"/>
                                                <span class="lbl"></span>
                                            </label>
                                        </td>
                                        <td><{$val['m_show_id']}>
                                            <{if $val['ame_cate'] > 0 && $memberCategory[$val['ame_cate']]}>
                                            <br/><{$memberCategory[$val['ame_cate']]['mc_name']}>
                                            <{/if}>
                                        </td>
                                        <td style="position:relative">
                                            <img class="img-thumbnail" width="60" src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" />
                                        </td>
                                        <td>
                                            <p>
                                                <{if $val['m_nickname']}>
                                                <a href="#" style="color:#333;"><{$val['m_nickname']}></a>
                                                <{else}>
                                                -
                                                <{/if}>
                                                <{if $val['m_is_highest'] eq 1}>
                                                <span class="label label-sm label-success">
                                                    最高级</span>
                                                <{/if}>
                                                <{if $val['m_is_refer'] eq 1}>
                                                <span class="label label-sm label-info">
                                                    官方推荐人</span>
                                                <{/if}>
                                                <{if $val['m_is_waiter'] eq 1}>
                                                 <span class="label label-sm label-success">
                                                    服务员</span>
                                                <{/if}>
                                                <{if $val['asl_status'] eq 2}>
                                                <span class="label label-sm label-success">
                                                    团长</span>
                                                <{/if}>
                                            </p>
                                            <!--<a href="#" class="btn btn-green btn-xs btn-openid" data-openid="<{$val['m_openid']}>">查看openid</a>-->
                                        </td>
                                        <{if $val['m_status'] == 0}>
                                        <td><span style="color: #333;">正常</span></td>
                                        <{/if}>
                                        <{if $val['m_status'] == 1}>
                                        <td><span style="color: red">封禁中</span></td>
                                        <{/if}>
                                        <td><{if $val['m_mobile']}><{$val['m_mobile']}><{else}>无<{/if}></td>
                                        <!--用户来源-->
                                        <{if $addMember == 1}>
                                        <td><{$memberSource[$val['m_source']]}></td>
                                        <{/if}>
                                        <td style="min-width: 100px; position: relative;width: 85px;" class="recharge-td">
                                            <{$val['m_gold_coin']}>
                                            <{if $appletCfg['ac_type'] != 28}>
                                            <!--<a class="btn btn-xs btn-blue recharge-btn" data-toggle="modal" data-target="#rechargeModal"  data-mid="<{$val['m_id']}>" data-coin="<{$val['m_gold_coin']}>" data-type="single">操作</a>-->
                                            <img src="/public/wxapp/images/icon_edit.png" class="user-admend recharge-btn" data-toggle="modal" data-target="#rechargeModal"  data-mid="<{$val['m_id']}>" data-coin="<{$val['m_gold_coin']}>" data-type="single" />
                                            <{/if}>
                                            <!--
                                            <a href="#" class="btn btn-primary opration-btn details-btn js-recharge-money" style="padding: 0 3px">扣除</a>
                                            <div class="ui-popover ui-popover-input top-center charge-input">
                                                <div class="ui-popover-inner">
                                                    <input type="text" class="form-control money-input" id="money-input" autofocus="autofocus" placeholder="请输入扣除金额" style="margin-top: 8px;width:160px;display:inline-block;height:30px;vertical-align:top">
                                                    <a class="ui-btn ui-btn-primary" href="javascript:;" onclick="confirmSplit(this, <{$val['m_gold_coin']}>, <{$val['m_id']}>)">确定</a>
                                                    <a class="ui-btn js-cancel" href="javascript:;" onclick="hideChargeInput()">取消</a>
                                                </div>
                                                <div class="arrow"></div>
                                            </div>
                                            -->
                                        </td>
                                        <td style="min-width: 100px;position: relative">
                                            <{$val['m_deduct_ktx']}>
                                        </td>
                                        <{if $appletCfg['ac_type'] != 34}>
                                        <td style="min-width: 100px;position: relative;width: 85px;">
                                            <{$val['m_points']}>
                                            <!--<a class="btn btn-xs btn-blue point-btn" data-toggle="modal" data-target="#pointModal"  data-mid="<{$val['m_id']}>" data-type="single" data-point_now="<{$val['m_points']}>">操作</a>-->
                                            
                                            <img src="/public/wxapp/images/icon_edit.png" class="user-admend point-btn" data-toggle="modal" data-target="#pointModal"  data-mid="<{$val['m_id']}>" data-type="single" data-point_now="<{$val['m_points']}>" />
                                            <!--
                                            <a href="#" class="btn btn-default opration-btn details-btn js-recharge-point" style="padding: 0 3px">扣除</a>
                                            <div class="ui-popover ui-popover-input top-center point-charge-input">
                                                <div class="ui-popover-inner">
                                                    <input type="text" class="form-control point-input" id="point-input" autofocus="autofocus" placeholder="请输入扣除积分" style="margin-top: 8px;width:160px;display:inline-block;height:30px;vertical-align:top">
                                                    <a class="ui-btn ui-btn-primary" href="javascript:;" onclick="confirmPointSplit(this, <{$val['m_points']}>, <{$val['m_id']}>)">确定</a>
                                                    <a class="ui-btn js-cancel" href="javascript:;" onclick="hidePointInput()">取消</a>
                                                </div>
                                                <div class="arrow"></div>
                                            </div>
                                            -->
                                        </td>
                                        <{/if}>

                                        <td>
                                            <{if $val['m_gold_freeze'] == 0}>
                                            <span style="color: #333;">正常</span>
                                                <!--<a class="btn btn-warning freeze-btn" mid="<{$val['m_id']}>" status="1">冻结账户</a>-->
                                            <{/if}>
                                            <{if $val['m_gold_freeze'] == 1}>
                                            <span style="color: red">已冻结</span>
                                                <!--<a class="btn btn-success freeze-btn" mid="<{$val['m_id']}>" status="0">解冻账户</a>-->
                                            <{/if}>
                                            <{if $appletCfg['ac_type'] != 8 && $appletCfg['ac_type'] != 3 && $appletCfg['ac_type'] != 26 }>
                                                <p style="margin: 0"><{if isset($mLevel[$val['m_level']])}><{$mLevel[$val['m_level']]}><{/if}></p>
                                            <{/if}>
                                        </td>
                                        <td>
                                            <{$val['m_follow_time']}>
                                        </td>
                                        <td style="min-width: 100px;color:#ccc;">
                                            <p>
                                                <a href="/wxapp/member/memberDetailNew?id=<{$val['m_id']}>" >
                                                    详情
                                                </a> -
                                                <!-- 是否有封禁会员 -->

                                                <{if $val['m_status'] == 0}>
                                                <a href="javascript:;" onclick="changeStatus(<{$val['m_id']}>,<{$val['m_status']}>)">封禁</a> -
                                                <{/if}>
                                                <{if $val['m_status'] == 1}>
                                                <a href="javascript:;" onclick="changeStatus(<{$val['m_id']}>,<{$val['m_status']}>)">解封</a> -
                                                <{/if}>
                                                <{if in_array($appletCfg['ac_type'],[6,21,27])}>
                                                <a href="/wxapp/member/getMemberPointDetail?mid=<{$val['m_id']}>" >
                                                    积分明细
                                                </a>
                                                <{/if}>
                                            </p>

                                            <p>
                                                <{if $appletCfg['ac_type'] != 8 && $appletCfg['ac_type'] != 3 && $appletCfg['ac_type'] != 26 &&  $appletCfg['ac_type'] != 33 && $appletCfg['ac_type'] != 34}>
                                                <!-- 是否可设置会员等级 -->
                                                <a href="#" class="set-membergrade" data-id="<{$val['m_id']}>" data-level="<{$val['m_level']}>">设会员</a> -
                                                <{/if}>

                                                <{if $val['m_gold_freeze'] == 0}>
                                                <a class="freeze-gold" href="#" mid="<{$val['m_id']}>" status="1">冻结余额</a>
                                                <{else}>
                                                <a class="freeze-gold"  href="#" mid="<{$val['m_id']}>" status="0">解冻余额</a>
                                                <{/if}>
                                            </p>

                                            <p>
                                                <{if $appletCfg['ac_type'] == 4}>
                                                -
                                                <a class="waiter-set" data-toggle="modal" data-target="#waiterModal"  data-mid="<{$val['m_id']}>" data-waiter="<{$val['m_is_waiter']}>" data-shop="<{$val['m_waiter_shop']}>">设置服务员</a>
                                                <{/if}>
                                                <!-- 社区团购设置团长 -->
                                                <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>

                                                <{if $val['asl_status'] == 2}>
                                                <a class="leader-set" data-mid="<{$val['m_id']}>" data-type="2">取消团长</a>
                                                <{else}>
                                                <a class="leader-set" data-mid="<{$val['m_id']}>" data-type="1">设置团长</a>
                                                <{/if}>
                                                <{/if}>
                                            </p>
                                            <!-- 餐饮版设置服务员 -->
                                        </td>
                                    </tr>
                                    <{if $val['m_remark']}>
                                    <tr class="member-remark"><td style="background-color: #f5f5f5;border-top: none;"></td><td colspan="14" style="border-top: none;line-height: 15px;text-align: left;padding-left: 8px;background-color: #f5f5f5">备注：<{$val['m_remark']}></td></tr>
                                    <{/if}>
                                    <{/foreach}>
                                    <tr class="bottom-tr">
                                        <td colspan="3" style="text-align: left">
                                            <a href="#" class="btn btn-blue btn-xs recharge-btn" data-toggle="modal"  data-type="multi" data-mid="0" data-target="#rechargeModal">余额批量充值</a>
                                            <{if $appletCfg['ac_type'] != 34}>
                                            <a href="#" class="btn btn-blue btn-xs point-btn" data-toggle="modal"  data-type="multi" data-mid="0" data-target="#pointModal">积分批量增加</a>
                                            <{/if}>
                                            <a href="#" class="btn btn-success btn-xs" style="color: #fff;margin-left: 10px" data-toggle="modal" data-target="#categoryModal" >修改用户分类</a>
                                        </td>

                                        <td colspan="15" style="text-align: right">
                                            <{$paginator}>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>

<!-- Modal -->    
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group" style="padding: 20px">
                    <div class="input-group" style="width: 100%">
                        <label for="kind2" class="control-label">用户分类：</label>
                        <select name="custom_cate" id="custom_cate" class="form-control">
                            <option value="0">请选择分类</option>
                            <option value="-1">清除分类</option>
                            <{foreach $memberCategory as $key =>$val}>
                            <option value="<{$key}>"><{$val['mc_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-cate">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form><input type="hidden" id="hid_type" value="">
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">用户编号</span>
                            <input type="text" class="form-control" id="showID" aria-describedby="inputGroupSuccess1Status">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">推荐码(选填)</span>
                            <input oninput="this.value=this.value.replace(/\D/g,'')" class="form-control" id="code" placeholder="6位数字,会员推荐码" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveReferBest">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- 增加积分 -->
<div class="modal fade" id="pointModal" tabindex="-1" role="dialog" aria-labelledby="pointModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
             <input type="hidden" id="point_mid" >
             <input type="hidden" id="point_type" value="">
             <input type="hidden" id="point_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pointModalLabel">
                    积分
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row point-operate" style="display: none">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                    <div class="col-sm-8">
                        <div class="radio-box">
                            <span>
                                <input type="radio" name="operatePoint" id="addPoint" value="1" checked="checked">
                                <label for="addPoint">增加</label>
                            </span>
                            <span>
                                <input type="radio" name="operatePoint" id="reducePoint" value="0">
                                <label for="reducePoint">扣除</label>
                            </span>
                        </div>
                    </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>积分：</label>
                    <div class="col-sm-8">
                        <input id="point" class="form-control" placeholder="请填写积分数值" style="height:auto!important" type="number"/>
                    </div>
                </div>
                    <div class="space-4"></div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                    <div class="col-sm-8">
                        <textarea name="remark" id="point_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                    <div class="col-sm-8">
                        <input type="password" autocomplete="off" id="point_pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary savePoint">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- 余额充值 -->
<div class="modal fade" id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
             <input type="hidden" id="hid_mid" >
             <input type="hidden" id="recharge_type" value="">
             <input type="hidden" id="gold_coin_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rechargeModalLabel">
                    余额
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row coin-operate" style="display: none">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                    <div class="col-sm-8">
                        <div class="radio-box">
                            <span>
                                <input type="radio" name="operateCoin" id="addCoin" value="1" checked="checked">
                                <label for="addCoin">充值</label>
                            </span>
                            <span>
                                <input type="radio" name="operateCoin" id="reduceCoin" value="0">
                                <label for="reduceCoin">扣费</label>
                            </span>
                        </div>
                    </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>金额：</label>
                    <div class="col-sm-8">
                        <input id="gold_coin" class="form-control" placeholder="请填写充值金额" style="height:auto!important" type="number"/>
                    </div>
                </div>
                    <div class="space-4"></div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                    <div class="col-sm-8">
                        <textarea name="remark" id="remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                    <div class="col-sm-8">
                        <input type="password" id="pwd" autocomplete="off" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveRecharge">保存</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade waiter-model" id="waiterModal" tabindex="-1" role="dialog" aria-labelledby="waiterModalLabel" aria-hidden="true">
    <div class="modal-dialog waiter-dialog" role="document">
        <div class="modal-content waiter-content">
             <input type="hidden" id="hid_waiter_mid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rechargeModalLabel">
                    设置服务员
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right"><font color="red">*</font>设置为服务员：</label>
                    <div class="col-sm-6">
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="is_waiter" id="waiter_yes" value="1" >
                                        <label for="waiter_yes">是</label>
                                    </span>
                                    <span>
                                        <input type="radio" name="is_waiter" id="waiter_no" value="0" checked="checked">
                                        <label for="waiter_no">否</label>
                                    </span>
                                </div>
                    </div>
                </div>
                    <div class="space-4"></div>
                    <{if $appletCfg['ac_index_tpl'] == 55}>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right"><font color="red">*</font>门店：</label>
                    <div class="col-sm-6">
                        <select name="waiter_shop" id="waiter_shop" class="form-control">
                            <{foreach $shopList as $val}>
                            <option value="<{$val['es_id']}>"><{$val['es_name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                    <{/if}>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveWaiter">保存</button>
            </div>
        </div>
    </div>
</div>

<!--新增添加会员-->
<div id="add-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="font-size: 18px">添加用户</h3>
            </div>
            <div class="modal-body" style="margin: 5px 15px">
                <form id="add-form">
                    <div class="form-group">
                        <label for="name">用户昵称</label>
                        <input type="text" class="form-control" id="username" placeholder="请输入用户昵称">
                    </div>
                    <div class="form-group">
                        <label>用户头像</label>
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="/public/manage/img/zhanwei/zw_fxb_45_45.png"  width="200px" style="display:inline-block;margin:0;">
                            <input type="hidden" id="cover"  class="avatar-field bg-img" name="upload-cover" value=""/>
                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover">修改头像<small style="font-size: 12px;color:#999">（建议尺寸：200*200）</small></a>
                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="saveMember()" class="btn btn-primary btn-save-add" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出用户
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/member/importMember" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">关注日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入关注日期"/>
                            </div>
                            <label class="col-sm-2 control-label">关注时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker1" name="startTime" placeholder="请输入关注时间"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off"  type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 70px;"></div>
                        <{if $appletCfg['ac_type'] == 6}>
                        <div class="form-group">
                            <div class="col-sm-4" style="display: block;width: 100%;margin-bottom: 20px;text-align: left;padding-left: 28px;">
                                <input type="checkbox" name="adminMember" style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
                                <label for="admin-member" style="position: relative;top: 2px">后台添加用户</label>
                            </div>
                        </div>
                        <{/if}>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/controllers/member.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
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
    })
    var clipboard = new ClipboardJS('.copy-openid');
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
    });

    //新增添加会员弹出框
    function addMember(){
        $('#add-modal').modal('show');
    }
    //保存新的会员信息
    function saveMember(){
       var name    = $('#username').val();
       var avatar  = $('#cover').val();
       var data    = {
           'name':name,
           'avatar':avatar
       };
       if(name && avatar){
           $.ajax({
               'type'  : 'post',
               'url'   : '/wxapp/member/addMember',
               'data'  : data,
               'dataType' : 'json',
               'success'  : function(ret){
                   layer.msg(ret.em);
                   if(ret.ec == 200){
                       //$('#tr_'+id).remove();
                       //optshide();
                       window.location.reload();
                   }
               }
           });
       }else{
           layer.msg('请完善信息');
       }

    }
    /*扣费弹出框*/
    $(".js-recharge-money").click(function(event) {
        event.stopPropagation();
        $(".money-input").val('');
        $(this).next().stop().fadeToggle();
        $("#money-input")[0].focus();
    });
    /*减少积分弹出框*/
    $(".js-recharge-point").click(function(event) {
        event.stopPropagation();
        $(".point-input").val('');
        $(this).next().stop().fadeToggle();
        $("#point-input")[0].focus();
    });

    function hideChargeInput(){
        $(".charge-input").stop().fadeOut();
    }
    function hidePointInput(){
        $(".point-charge-input").stop().fadeOut();
    }

    /*确认扣费*/
    function confirmSplit(elem, coin, mid){
        var txt;
        var that = $(elem);
        txt = that.prev().val();
        if(mid){
            if(!isNaN(txt)){
                if (txt == 0) {
                    layer.msg('金额必须为数字');
                } else {
                    amount  = Math.abs(txt);
                    if(amount<=coin){
                        layer.confirm('确定扣除用户'+amount+'余额？', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var data = {
                                'mid'   : mid,
                                'amount': amount
                            };
                            $.ajax({
                                type  : 'post',
                                url   : '/wxapp/member/splitMoney',
                                data  : data,
                                dataType  : 'json',
                                success : function (json_ret) {
                                    layer.msg(json_ret.em);
                                    if(json_ret.ec == 200){
                                        window.location.reload();
                                    }
                                }
                            })
                        }, function(){

                        });
                    }else{
                        layer.msg('扣除金额大于用户余额');
                    }
                }
            }else{
                layer.msg('金额必须为数字');

            }
        }


    }

    /*确认扣除积分*/
    function confirmPointSplit(elem, coin, mid){
        var txt;
        var that = $(elem);
        txt = that.prev().val();
        if(mid){
            if(!isNaN(txt)){
                if (txt == 0) {
                    layer.msg('积分必须为数字');
                } else {
                    amount  = Math.abs(txt);
                    if(amount<=coin){
                        layer.confirm('确定扣除用户'+amount+'积分？', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var data = {
                                'mid'   : mid,
                                'point': amount
                            };
                            $.ajax({
                                type  : 'post',
                                url   : '/wxapp/member/splitPoint',
                                data  : data,
                                dataType  : 'json',
                                success : function (json_ret) {
                                    layer.msg(json_ret.em);
                                    if(json_ret.ec == 200){
                                        window.location.reload();
                                    }
                                }
                            })
                        }, function(){

                        });
                    }else{
                        layer.msg('扣除积分大于用户积分');
                    }
                }
            }else{
                layer.msg('积分必须为数字');

            }
        }


    }


    $('.add-btn').on('click',function(){
        var type = $(this).data('type');
        var title = $(this).data('title');
        $('#myModalLabel').html(title);
        $('#hid_type').val(type);
        $('#showID').val('');
        $('#code').val('');
        $('#myModal').modal('show')
    });
    //充值模态框点击
    $('.recharge-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var coinNow = $(this).data('coin');
        //批量充值
        if(type == 'multi'){
            //隐藏操作选择
            $(".coin-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".coin-operate").css('display','');
        }
        $('#hid_mid').val(mid);
        $('#recharge_type').val(type);
        $('#gold_coin_now').val(coinNow);
        $('#gold_coin').val('');
        $('#remark').val('');
        $('#pwd').val('');
    });


    //增加积分模态框点击
    $('.point-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var pointNow = $(this).data('point_now');
        //批量增加
        if(type == 'multi'){
            $(".point-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".point-operate").css('display','');
        }
        $('#point_mid').val(mid);
        $('#point_type').val(type);
        $('#point_now').val(pointNow);
        $('#point').val('');
        $('#point_remark').val('');
        $('#point_pwd').val('');
    });

    $('.waiter-set').on('click',function () {
        var mid = $(this).data('mid');
        var isWaiter = $(this).data('waiter');
        var shop = $(this).data('shop');
        $('#hid_waiter_mid').val(mid);
        if(isWaiter){
            $('#waiter_yes').attr('checked','checked');
            $('#waiter_no').attr('checked','');
        }
        $('#waiter_shop').val(shop);
    });

    $('.saveWaiter').on('click',function(){
        var mid    = $('#hid_waiter_mid').val();
        var isWaiter = $('input:radio[name="is_waiter"]:checked').val();
        var shop   = $('#waiter_shop').val();
        if(mid){
            var data = {
                'mid'     : mid,
                'isWaiter': isWaiter,
                'shop'    : shop
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setWaiterNew',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.close(index);
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });

    $('.saveReferBest').on('click',function(){
        var type   = $('#hid_type').val();
        var showId = $('#showID').val();
        var code   = $('#code').val();
        if(code.length !=6 ){
            layer.msg('推荐码必须是6位数字');
            return false;
        }

        if(showId && type){
            var data = {
                'type'      :  type,
                'showId'    : showId,
                'code'      : code
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setReferBest',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.close(index);
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });
    //管理员操作余额
    $('.saveRecharge').on('click',function(){
        var mid    = $('#hid_mid').val();
        var coin   = $('#gold_coin').val();
        var coinNow= $('#gold_coin_now').val();
        var remark = $('#remark').val();
        var pwd    = $('#pwd').val();
        var type   = $('#recharge_type').val();
        var operate= $("input[name='operateCoin']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && parseFloat(coinNow) < parseFloat(coin)){
            layer.msg('扣费金额需小于当前余额');
            return false;
        }
        var data = {
            'mid'     : mid,
            'coin'    : coin,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl= '/wxapp/member/newSaveRecharge';
        //批量充值
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择用户');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiRecharge'
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    //管理员增加积分
    $('.savePoint').on('click',function(){
        var mid    = $('#point_mid').val();
        var type   = $('#point_type').val();
        var point  = $('#point').val();
        var pointNow = $('#point_now').val();
        var remark = $('#point_remark').val();
        var pwd    = $('#point_pwd').val();
        var operate= $("input[name='operatePoint']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && pointNow < point){
            layer.msg('扣除积分需小于当前积分');
            return false;
        }

        var data = {
            'mid'     : mid,
            'point'   : point,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl = '/wxapp/member/savePoint';
        //批量增加
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择会员');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiPoint';
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

   $('#myTab li').on('click', function() {
       var id = $(this).data('id');
       window.location.href='/wxapp/member/list?type='+id;
   });

   /*设置会员等级*/
    $('#member-grade').searchableSelect();
    $("#content-con").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
           $('#member-grade').val(level);
        }
        $('#hid_mid').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-486,'top':top-conTop-76}).stop().show();
    });
    /**
     * 保存等级到期时间
     */
    $("#content-con").on('click', 'table td a.long_date', function(event) {
        var _this = $(this);
        var id  = _this.data('id');
        var end = _this.data('end');
        var curDate = _this.text();
        $("#endDate").val(curDate);
        $("#hid_dateid").val(id);

        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        $(".ui-popover.ui-popover-time").css({'left':left-conLeft-445,'top':top-conTop-96}).stop().show();
    });

    // $(".ui-popover").on('click', function(event) {
    //     event.stopPropagation();
    // });
    // $(".ui-popover").on('click', function(event) {
    //     setTimeout(function () {
    //         event.preventDefault();
    //         event.stopPropagation();
    //     },100);
    // });

    //$(".main-container").on('click', function(event) {

    $("#content-con").on('click', function(event) {
        optshide();
    });

    /*复制openid弹出框*/
    $("#content-con").on('click', 'table td a.btn-openid', function(event) {
        var openid = $(this).data('openid');
        if(openid){
            $('.copy-div input').val(openid);
            $('.copy-div .copy-openid').attr('data-clipboard-text',openid);
        }
        event.preventDefault();
        event.stopPropagation();

        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-openid").css({'left':left-conLeft-64,'top':top-conTop-66}).stop().show();
    });

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level != 0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择用户等级');
        }

    });



    //取消官方推荐
    $('.cel-refer').on('click',function(){
        var id = $(this).data('id');
        var data  = {
            'id'    : id
        };
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/cancelRefer',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+id).remove();
                    //optshide();
                }
            }
        });
    });
    /*$('.long_date').on('click',function(){
        var id  = $(this).data('id');
        var end = $(this).data('end');
    });*/

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

        /*日期选择器*/
        $('#endDate').datepicker({autoclose:true}).next().on(ace.click_event, function(){
          // $(this).prev().focus();
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
        
    });
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }

    function changeStatus(id, status){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/changeStatus',
            'data'  : {id: id,status: status},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    $('.freeze-gold').on('click',function () {
        var mid = $(this).attr('mid');
        var status = $(this).attr('status')
        var text;
        if(status==1){
        	text="确定要冻结余额吗？";
        }else{
        	text="确定要解冻余额吗？";
        }
        layer.confirm(text, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(
	                2,
	                {
	                    shade: [0.1,'#333'],
	                    time: 10*1000
	                }
	        );
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/member/freezeGold',
	            'data'  : {mid: mid,status: status},
	            'dataType'  : 'json',
	            'success'   : function(ret){
	                layer.close(load_index);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }else{
	                    layer.msg(ret.em);
	                }
	            }
	        });
        });
    });

    $('.set-waiter').on('click',function () {
        var mid = $(this).attr('mid');
        var status = $(this).attr('status')
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/setWaiter',
            'data'  : {mid: mid,status: status},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    });

    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

    $('.leader-set').on('click',function () {
       var mid = $(this).data('mid');
       var type = $(this).data('type');
       var text = '';
       if(type == 1){
           text = '确定将该用户设置为团长吗？';
       }else{
           text = '确定取消该用户的团长吗？';
       }
        layer.confirm(text, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/changeLeader',
                'data'  : {mid: mid,type: type},
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });

    });

    $('#change-cate').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            $(this).attr('disabled','disabled');
            var data = {
                'mids' : ids,
                'cate': $('#custom_cate').val()
            };
            var url = '/wxapp/member/changeMemberCategory';
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : url,
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        $(this).removeAttr('disabled');
                    }
                }
            });
        }else{
            layer.msg('请选择用户');
        }
    });

</script>
<{include file="../img-upload-modal.tpl"}>
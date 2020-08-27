<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" type="text/css" href="/public/wxapp/css/member-list-new.css?31">
<style>
    #excelOrder .form-group{
        height: 30px;
    }
</style>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<!-- openid弹出框 -->
<div class="ui-popover ui-popover-openid left-center" style="top:100px;" popover-type="openid">
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
<!-- 订单汇总信息 -->
<div class="balance">
    <div class="balance-info">
        <div class="balance-content">
            <span class="money"><{$statInfo['totalToday']}></span>
        </div>
        <div class="balance-title">今日新增用户<span></span></div>
    </div>
    <div class="balance-info">

        <div class="balance-content">
            <span class="money"><{$statInfo['total7days']}></span>
        </div>
        <div class="balance-title">近7天新增<span></span></div>
    </div>
    <div class="balance-info">
        <div class="balance-content">
            <span class="money"><{$statInfo['total']}></span>
        </div>
        <div class="balance-title">用户总数<span></span></div>
    </div>
    <{if $canBan == 1}>
    <div class="balance-info">
        <div class="balance-content">
            <span class="money"><{$statInfo['totalBan']}></span>
        </div>
        <div class="balance-title">被封禁用户<span></span></div>
    </div>
    <{/if}>
    <{if $category > 0}>
    <div class="balance-info">
        <div class="balance-content">
            <span class="money"><{$statInfo['totalCate']}></span>
        </div>
        <div class="balance-title">当前分类用户<span></span></div>
    </div>
    <{/if}>
</div>
<div id="content-con" class="content-con">
    <div class="opera-btn-box">
        <{if $addMember == 1}>
        <a href="javascript:;" onclick="addMember()" class="btn btn-blue btn-sm"><i class="icon-plus bigger-80"></i> 新增</a>
        <{/if}>
        <!-- <a href="javascript:;" class="btn btn-blue btn-sm btn-excel" ><i class="icon-download"></i>用户导出</a> -->
    </div>
    <div class="search-part-wrap">
        <form action="/wxapp/member/list" method="get" class="form-inline">
            <input type="hidden" name="type" value="<{if $type}><{$type}><{else}>all<{/if}>">
            <input type="hidden" name="sortType" value="<{$sortType}>">
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">昵称</div>
                    <div class="input-form">
                        <input type="text" class="form-control" name="nickname" id="nickname" value="<{$nickname}>" placeholder="用户昵称">
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">用户编号</div>
                    <div class="input-form">
                        <input type="text" class="form-control" name="mid" id="mid" value="<{if $mid}><{$mid}><{/if}>" placeholder="编号">
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">手机号</div>
                    <div class="input-form">
                        <input type="text" class="form-control" name="mobile" id="mobile" value="<{if $mobile}><{$mobile}><{/if}>" placeholder="手机号">
                    </div>
                </div>
            </div>
            <div class="search-input-item" style="display: none">
                <div class="input-item-group">
                    <div class="input-item-addon">备注</div>
                    <div class="input-form">
                        <input type="text" class="form-control" name="remark" id="remark" value="<{if $remark}><{$remark}><{/if}>" placeholder="备注">
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">用户等级</div>
                    <div class="input-form">
                        <select name="searchlv" id="searchlv" class="form-control">
                            <option value="0">全部</option>
                            <{foreach $mLevel as $key=>$val}>
                        <option value="<{$key}>" <{if $key == $searchlv}>selected<{/if}>><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <{if $addMember == 1}>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">用户来源</div>
                    <div class="input-form">
                        <select name="source" id="source" class="form-control">
                            <option value="0">全部</option>
                            <option value="1" <{if $source eq 1}>selected<{/if}> >公众号</option>
                            <option value="2" <{if $source eq 2}>selected<{/if}> >小程序</option>
                            <option value="5" <{if $source eq 5}>selected<{/if}> >后台添加</option>
                        </select>
                    </div>
                </div>
            </div>
            <{/if}>
            <{if $sequenceShowAll == 1}>
            <div class="search-input-item" <{if $cash}> style="display:none;" <{/if}>>
            <div class="input-item-group">
                <div class="input-item-addon">分类</div>
                <div class="input-form">
                    <select name="category" id="category" class="form-control">
                        <option value="0">全部</option>
                        <{foreach $memberCategory as $key =>$val}>
                    <option value="<{$key}>" <{if $key == $category}>selected<{/if}>><{$val['mc_name']}></option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
    </div>
    <{/if}>

    <div class="search-input-item">
        <div class="input-item-group">
            <div class="input-item-addon" style="font-weight: bold">授权状态</div>
            <div class="input-form">
                <select name="authorization" id="authorization" class="form-control">
                    <option value="-1">全部</option>
                    <option value="0" <{if $authorization == 0}> selected <{/if}>>已授权</option>
                    <option value="1" <{if $authorization == 1}> selected <{/if}>>未授权</option>
                </select>
            </div>
        </div>
    </div>

    <div class="search-input-item">
        <div class="input-item-group">
            <div class="input-item-addon">关注时间</div>
            <div class="input-form">
                <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                <i class="icon-calendar bigger-110"></i>
            </div>
            <div class="input-form">到</div>
            <div class="input-form">
                <input type="text" class="form-control" name="end" id="end-time" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                <i class="icon-calendar bigger-110"></i>
            </div>
        </div>
    </div>
    <div class="search-input-item">
        <div class="search-btn">
            <button type="submit" class="btn btn-blue btn-sm">查询</button>
            <a href="javascript:;" class="btn btn-blue btn-sm btn-excel" ><i class="icon-download"></i>用户导出</a>
        </div>
    </div>
    </form>
</div>
<!-- 排序按钮 -->
<div class="sort-type-box">
    <{foreach $member_sort_type as $key => $item}>
    <div class="sort-type-item" data-sorttype="<{$key}>_<{$item['sort']}>">
        <span class="sort-type" <{if $sort_type == $key}>style="color:#008cf6"<{/if}>><{$item['name']}>
        <i class="icon-caret-up" <{if $item['sort'] == 'desc'}>style="display:inline-block"<{/if}>></i>
        <i class="icon-caret-down" <{if $item['sort'] == 'asc'}>style="display:inline-block"<{/if}>></i>
        </span>
    </div>
    <{/foreach}>
</div>
<div class="cus-part-item" style="padding:0 12px;box-shadow: none;">
    <div class="fixed-table-box">
        <div class="fixed-table-body">
            <table id="sample-table-1" class="table table-avatar">
                <thead>
                <tr>
                    <th>
                        <label>
                            <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>头像</th>
                    <th>用户信息</th>
                    <th>个人数据</th>
                    <th>状态</th>
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
                        <!-- 头像 标签 -->
                        <td>
                            <{if $cash}>
                        <img class="img-thumbnail" width="60" src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/wxapp/images/member-2.png<{/if}>" />
                            <{else}>
                        <img class="img-thumbnail" width="60" src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" />
                            <{/if}>


                            <!-- 标签 -->
                            <{if $val['m_is_highest'] > 0}>
                            <span class="label label-sm label-success">
                                        <{$deduct[$val['m_is_highest']]}></span>
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
                        </td>
                        <!-- 用户信息 -->
                        <td>
                            <div class="td-top-info" style="text-align: left;">
                                <p class="tab-txt left"><span class="lab-name left">昵称：</span><span class="lab-txt"><{$val['m_nickname']}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">编号：</span><span class="lab-txt"><{$val['m_show_id']}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">手机号：</span><span class="lab-txt"><{if $val['m_mobile']}><{$val['m_mobile']}><{else}>无<{/if}></span>
                                <p class="tab-txt left"><span class="lab-name left">姓名：</span><span class="lab-txt"><{if $val['m_realname']}><{$val['m_realname']}><{else}>无<{/if}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">性别：</span><span class="lab-txt"><{$val['m_sex']}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">类别：</span><span class="lab-txt"><{if $val['ame_cate'] > 0 && $memberCategory[$val['ame_cate']]}><{$memberCategory[$val['ame_cate']]['mc_name']}><{else}>无<{/if}></span>
                                <p class="tab-txt left"><span class="lab-name left">地区：</span><span class="lab-txt"><{$val['m_pro_name']}>-<{$val['m_city_name']}>-<{$val['m_area_name']}>-<{$val['m_street_name']}></span></p>

                                <p class="tab-txt left"><span class="lab-name left">关注时间：</span><span class="lab-txt"><{$val['m_follow_time']}></span></p>
                            </div>
                        </td>
                        <!-- 个人数据 -->
                        <td>
                            <div class="td-top-info" style="text-align: left;">
                                <p class="tab-txt left"><span class="lab-name left">积分：</span><span class="lab-txt"><{$val['m_points']}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">余额：</span><span class="lab-txt"><{$val['m_gold_coin']}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">收益：</span><span class="lab-txt"><{$val['m_deduct_ktx'] + $val['m_deduct_dsh'] + $val['m_deduct_ytx']}></span>
                                <p class="tab-txt left"><span class="lab-name left">订单成交总数：</span><span class="lab-txt"><{$val['m_traded_num']}></span></p>
                                <p class="tab-txt left"><span class="lab-name left">订单成交总额：</span><span class="lab-txt"><{$val['m_traded_money']}></span></p>
                                <{if $val['m_is_highest'] > 0}>

                                <p class="tab-txt left"><span class="lab-name left">分销地区： </span>
                                <{foreach $val['area'] as $vv}>
                                   <p class="lab-txt" style="max-width: 250px;"><{$vv['area']}><a href="#" class="del-area" data-id="<{$vv['id']}>">   删除</a></p>
                                    <{/foreach}>
                                </p>

                                <{/if}>
                            </div>
                        </td>
                        <!-- 状态 -->
                        <td>
                            <div class="td-top-info" style="text-align: left;">
                                <{if $canBan == 1}>
                                <p class="tab-txt left"><span class="lab-name left">用户状态：</span><span class="lab-txt"><{if $val['m_status'] == 0}><span style="color: #333;">正常</span><{/if}><{if $val['m_status'] == 1}><span style="color: red">封禁中</span><{/if}></span></p>
                                <{/if}>
                                <{if !$hideLevel}>
                                <p class="tab-txt left"><span class="lab-name left">用户等级：</span><span class="lab-txt member-level-text"><{if isset($mLevel[$val['m_level']])}><{$mLevel[$val['m_level']]}><{else}>无<{/if}></span></p>
                                <{/if}>
                                <{if $addMember == 1}>
                                <p class="tab-txt left"><span class="lab-name left">用户来源：</span><span class="lab-txt"><{$memberSource[$val['m_source']]}></span>

                                    <{/if}>
                                <p class="tab-txt left"><span class="lab-name left">进入渠道：</span><span class="lab-txt"><{if $val['m_join_status'] == 1}>扫码进入<{else}>自然进入<{/if}></span>
                                <p class="tab-txt left"><span class="lab-name left">openid：</span><span class="lab-txt"><{$val['m_openid']}></span></p>
                            </div>
                        </td>
                        <td>
                            <p>
                                <a class="btn btn-blueoutline btn-xs" href="/wxapp/member/memberDetailNew?id=<{$val['m_id']}>" >
                                    明细
                                </a>
                            </p>
                            <p>
                                <{if $val['m_is_highest'] == 0}>
                                <a class="add-slide btn btn-blueoutline btn-xs" href="#" data-toggle="modal" data-target="#threeModal"  data-id="<{$val['m_id']}>">设置分销商</a>
                                <{else}>
                                <a class="del-highest btn btn-blueoutline btn-xs" href="#" data-id="<{$val['m_id']}>">取消分销商</a>
                                <{/if}>

                            </p>
                            <{if $val['m_is_highest'] != 0}>
                            <p>
                                <a class="add-area btn btn-blueoutline btn-xs" href="#" data-toggle="modal" data-target="#threeareaModal"  data-id="<{$val['m_id']}>">增加区域</a>
                            </p>
                            <p>


                                <a class="add-level btn btn-blueoutline btn-xs" href="#" data-toggle="modal" data-target="#threelevelModal"  data-id="<{$val['m_id']}>">更改等级</a>

                            </p>
                            <{/if}>
                            <{if $canBan}>
                            <p>
                                <{if $val['m_status'] == 0}>
                                <a href="javascript:;" class="btn btn-blueoutline btn-xs" onclick="changeStatus(<{$val['m_id']}>,<{$val['m_status']}>)">封禁</a>
                                <{/if}>
                                <{if $val['m_status'] == 1}>
                                <a href="javascript:;" class="btn btn-blueoutline btn-xs" onclick="changeStatus(<{$val['m_id']}>,<{$val['m_status']}>)">解封</a>
                                <{/if}>
                            </p>
                            <{/if}>
                            <p>
                                <{if $val['m_gold_freeze'] == 0}>
                                <a class="freeze-gold btn btn-blueoutline btn-xs" href="#" mid="<{$val['m_id']}>" status="1">冻结余额</a>
                                <{else}>
                                <a class="freeze-gold btn btn-blueoutline btn-xs"  href="#" mid="<{$val['m_id']}>" status="0">解冻余额</a>
                                <{/if}>
                            </p>
                            <{if $appletCfg['ac_type'] == 4 || $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                            <div class="drop-btn-box">
                                <span class="btn btn-blue btn-xs">设置<b class="arrow icon-angle-down"></b></span>
                                <div class="drop-btn-list">
                                    <{if !$hideLevel}>
                                    <p>
                                        <a href="#" class="change-level-btn btn btn-lightblue btn-xs" data-toggle="modal" data-target="#levelSingleModal"  data-mid="<{$val['m_id']}>" data-type="single" data-level="<{$val['m_level']}>">设置会员</a>
                                    </p>
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] == 4}>
                                    <p>
                                        <a class="waiter-set btn btn-lightblue btn-xs" data-toggle="modal" data-target="#waiterModal"  data-mid="<{$val['m_id']}>" data-waiter="<{$val['m_is_waiter']}>" data-shop="<{$val['m_waiter_shop']}>">设置服务员</a>
                                    </p>
                                    <{/if}>
                                    <!-- 社区团购设置团长 -->
                                    <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                                    <{if $val['asl_status'] == 2}>
                                    <p>
                                        <a class="leader-set btn btn-lightblue btn-xs" data-mid="<{$val['m_id']}>" data-type="2">取消团长</a>
                                    </p>
                                    <{else}>
                                    <p>
                                        <a class="leader-set btn btn-lightblue btn-xs" data-mid="<{$val['m_id']}>" data-type="1">设置团长</a>
                                    </p>
                                    <{/if}>
                                    <{/if}>
                                </div>
                            </div>
                            <{else}>
                            <{if !$hideLevel}>
                            <p>
                                <a href="#" class="change-level-btn btn btn-blueoutline btn-xs" data-toggle="modal" data-target="#levelSingleModal"  data-mid="<{$val['m_id']}>" data-type="single" data-level="<{$val['m_level']}>">设置会员</a>
                            </p>
                            <{/if}>
                            <{/if}>
                            <div class="drop-btn-box">
                                <span class="btn btn-blue btn-xs">更改<b class="arrow icon-angle-down"></b></span>
                                <div class="drop-btn-list">
                                    <{if $sequenceShowAll == 1}>
                                    <p>
                                        <a href="#" class="js-point-btn btn btn-lightblue btn-xs" data-toggle="modal" data-target="#pointModal"  data-mid="<{$val['m_id']}>" data-type="single" data-point_now="<{$val['m_points']}>" >更改积分</a>
                                    </p>
                                    <p>
                                        <a href="#" class="js-recharge-btn btn btn-lightblue btn-xs" data-toggle="modal" data-target="#rechargeModal"  data-mid="<{$val['m_id']}>" data-coin="<{$val['m_gold_coin']}>" data-type="single" >更改余额</a>
                                    </p>
                                    <p>
                                        <a href="#" class="js-change-cate-btn btn btn-lightblue btn-xs" data-toggle="modal" data-target="#categorySingleModal"  data-mid="<{$val['m_id']}>" data-type="single" data-cate="<{$val['ame_cate']}>" <{if $cash}> style="display:none;" <{/if}> >更改分类</a>
                                    </p>
                                    <{else}>
                                    <p>
                                        <a href="#" class="js-recharge-btn btn btn-lightblue btn-xs" data-toggle="modal" data-target="#rechargeModal"  data-mid="<{$val['m_id']}>" data-coin="<{$val['m_gold_coin']}>" data-type="single" >更改余额</a>
                                    </p>
                                    <{/if}>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <{/foreach}>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">
            <div class="bottom-opera-item" style="padding: 13px 0;<{if $showPage == 0 }>text-align: center;<{/if}>">
                <a href="#" class="btn btn-blue btn-xs js-recharge-btn" data-toggle="modal"  data-type="multi" data-mid="0" data-target="#rechargeModal">余额批量充值</a>
                <{if !in_array($appletCfg['ac_type'],[34,37])}>
                <a href="#" class="btn btn-blue btn-xs js-point-btn" data-toggle="modal"  data-type="multi" data-mid="0" data-target="#pointModal">积分批量增加</a>
                <{/if}>

                <a href="#" class="btn btn-blueoutline btn-xs" data-toggle="modal" data-target="#categoryModal" <{if $cash}> style="display:none;" <{/if}> >修改用户分类</a>
            </div>
            <div class="bottom-opera-item" style="text-align: right">
                <div class="page-part-wrap"><{$paginator}></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="threeareaModal" tabindex="-1" role="dialog" aria-labelledby="threeareaModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            <input type="hidden" id="area_mid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    增加区域
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">选择城市：</label>
                    <div class="control-group">
                        <div class="col-sm-8" style="width:17%;">
                            <select class="form-control" name="pro_id" id="pro_id" >
                                <option value="0">省份</option>
                                <{foreach $pro as $val}>
                                <option value="<{$val['id']}>"><{$val['name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                        <div class="col-sm-8" style="width:17%;">
                            <select class="form-control" name="city_id" id="city_id" >
                                <option value="0">城市</option>

                            </select>
                        </div>
                        <div class="col-sm-8" style="width:20%;">
                            <select class="form-control" name="area_id" id="area_id" >
                                <option value="0">区域</option>

                            </select>
                        </div>
                        <div class="col-sm-8" style="width:20%;">
                            <select class="form-control" name="street_id" id="street_id" >
                                <option value="0">街道</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="add-area">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="threelevelModal" tabindex="-1" role="dialog" aria-labelledby="threelevelModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            <input type="hidden" id="hid_level_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改分销等级
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">选择等级：</label>
                    <div class="control-group">
                        <div class="col-sm-8" style="width:30%;">
                            <select class="form-control" name="dc_level_id" id="dc_level_id" >
                                <option value="0">请选择等级</option>
                                <{foreach $decuct as $val}>
                                <option value="<{$val['dc_id']}>"><{$val['dc_buy_num']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-level">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div> <!-- Modal -->
<div class="modal fade" id="threeModal" tabindex="-1" role="dialog" aria-labelledby="threeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置城市
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">选择城市：</label>
                    <div class="control-group">
                        <div class="col-sm-8" style="width:17%;">
                            <select class="form-control" name="pro" id="pro" >
                                <option value="0">省份</option>
                                <{foreach $pro as $val}>
                                <option value="<{$val['id']}>"><{$val['name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                        <div class="col-sm-8" style="width:17%;">
                            <select class="form-control" name="city" id="city" >
                                <option value="0">城市</option>

                            </select>
                        </div>
                        <div class="col-sm-8" style="width:20%;">
                            <select class="form-control" name="area" id="area" >
                                <option value="0">区域</option>

                            </select>
                        </div>
                        <div class="col-sm-8" style="width:20%;">
                            <select class="form-control" name="street" id="street" >
                                <option value="0">街道</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">选择等级：</label>
                    <div class="control-group">
                        <div class="col-sm-8" style="width:30%;">
                            <select class="form-control" name="dc_level" id="dc_level" >
                                <option value="0">等级</option>
                                <{foreach $decuct as $val}>
                                <option value="<{$val['dc_id']}>"><{$val['dc_buy_num']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-slide">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div> <!-- Modal -->
<div class="modal fade" id="categorySingleModal" tabindex="-1" role="dialog" aria-labelledby="categorySingleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="cate_mid_single" >
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
                        <label for="kind2" class="control-label input-group-addon">用户分类：</label>
                        <select name="custom_cate" id="custom_cate_single" class="form-control">
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
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-blue" id="change-cate-single">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- Modal -->
<div class="modal fade" id="levelSingleModal" tabindex="-1" role="dialog" aria-labelledby="levelSingleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="level_mid_single" >
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
                        <label for="kind2" class="control-label input-group-addon">等级：</label>
                        <select name="custom_cate" id="custom_level_single" class="form-control">
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-blue" id="change-level-single">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
                        <label for="kind2" class="control-label input-group-addon">用户分类：</label>
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
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-blue" id="change-cate">
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
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-blue saveReferBest">保存</button>
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
                            <textarea name="point_remark" id="point_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
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
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-blue savePoint">保存</button>
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
                            <textarea name="recharge_remark" id="recharge_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-blue saveRecharge">保存</button>
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
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-blue saveWaiter">保存</button>
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
                <button type="button" onclick="saveMember()" class="btn btn-blue btn-save-add" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content" style="overflow:inherit">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出用户
                </h4>
            </div>
            <div class="modal-body" style="overflow: inherit;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/member/importMember" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10">
                                <input class="form-control" autocomplete="off" type="text" id="excel_nickname" name="excel_nickname" placeholder="用户昵称"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户编号</label>
                            <div class="col-sm-10">
                                <input class="form-control" autocomplete="off" type="text" id="excel_showid" name="excel_showid" placeholder="用户编号"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机号</label>
                            <div class="col-sm-10">
                                <input class="form-control" autocomplete="off" type="text" id="excel_mobile" name="excel_mobile" placeholder="用户编号"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <!--
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <input class="form-control" autocomplete="off" type="text" id="excel_remark" name="excel_remark" placeholder="备注"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">用户等级</label>
                            <div class="col-sm-10">
                                <select name="excel_level" id="excel_level" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $mLevel as $key=>$val}>
                                <option value="<{$key}>" <{if $key == $searchlv}>selected<{/if}>><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group" <{if $addMember != 1}>style="display:none;"<{/if}>>
                        <label class="col-sm-2 control-label">用户来源</label>
                        <div class="col-sm-10">
                            <select name="excel_source" id="excel_source" class="form-control">
                                <option value="0">全部</option>
                                <option value="2" <{if $source eq 2}>selected<{/if}> >小程序</option>
                                <option value="5" <{if $source eq 5}>selected<{/if}> >后台添加</option>
                            </select>
                        </div>
                </div>
                <div class="space" <{if $addMember != 1}>style="display:none;"<{/if}>></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">分类</label>
                <div class="col-sm-10">
                    <select name="excel_category" id="excel_category" class="form-control">
                        <option value="0">全部</option>
                        <{foreach $memberCategory as $key =>$val}>
                    <option value="<{$key}>" <{if $key == $category}>selected<{/if}>><{$val['mc_name']}></option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
            <div class="space"></div>

            <div class="form-group">
                <label class="col-sm-2 control-label">授权状态</label>
                <div class="col-sm-10">
                    <select name="excel_authorization" id="excel_authorization" class="form-control">
                        <option value="-1">全部</option>
                        <option value="0">已授权</option>
                        <option value="1">未授权</option>
                    </select>
                </div>
            </div>
            <div class="space"></div>

            <div class="form-group">
                <label class="col-sm-2 control-label">关注日期</label>
                <div class="col-sm-10">
                    <input class="form-control date-picker" autocomplete="off" type="text" id="excel_startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入关注日期"/>
                </div>
                <!--
                <label class="col-sm-2 control-label">关注时间</label>
                <div class="col-sm-6 bootstrap-timepicker">
                    <input class="form-control" type="text" autocomplete="off"  id="timepicker1" name="startTime" placeholder="请输入关注时间"/>
                </div>
                -->
            </div>
            <div class="space"></div>
            <div class="form-group">
                <label class="col-sm-2 control-label">结束日期</label>
                <div class="col-sm-10">
                    <input class="form-control date-picker" autocomplete="off"  type="text" id="excel_endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
                </div>
                <!--
                <label class="col-sm-2 control-label">结束时间</label>
                <div class="col-sm-6 bootstrap-timepicker">
                    <input class="form-control" type="text" autocomplete="off"  id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                </div>
                -->
            </div>
            <button type="button" class="btn btn-blueoutline" data-dismiss="modal" style="margin-right: 30px;margin-top: 25px;margin-bottom: 10px">取消</button>
            <button type="submit" class="btn btn-blue" role="button" style="margin-top: 25px;margin-bottom: 10px">导出</button>
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

    $('.del-area').on('click',function(){
        var id = $(this).data('id');
        var data = {
            id   : id,
        };
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/delarea',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    })
    $('.del-highest').on('click',function(){
        var id = $(this).data('id');
        var data = {
            id   : id,
        };
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/delHighest',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/member/list'
                }
            }
        });

    })
    $('#save-level').on('click',function(){
        var dc_level     = $('#dc_level_id').val();
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#hid_level_id').val();


        var data = {
            id   : id,
            dc_level      : dc_level
//            information : information
        };
//        console.log(data);return;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/savelevelnew',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });


    $('#save-slide').on('click',function(){
        var city         = $('#city').val();
        var city_name    = $("select[name='city']").find("option:selected").text();
        var pro          = $('#pro').val();
        var pro_name     = $("select[name='pro']").find("option:selected").text();
        var area         = $('#area').val();
        var area_name    = $("select[name='area']").find("option:selected").text();
        var street       = $('#street').val();
        var dc_level     = $('#dc_level').val();
        var street_name  = $("select[name='street']").find("option:selected").text();
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#hid_id').val();


        var data = {
            id   : id,
            city  : city,
            pro   : pro,
            area   : area,
            street   : street,
            city_name  : city_name,
            pro_name   : pro_name,
            area_name   : area_name,
            street_name   : street_name,
            dc_level      : dc_level
//            information : information
        };
//        console.log(data);return;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/savearea',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    $('#add-area').on('click',function(){
        var city         = $('#city_id').val();
        var city_name    = $("select[name='city_id']").find("option:selected").text();
        var pro          = $('#pro_id').val();
        var pro_name     = $("select[name='pro_id']").find("option:selected").text();
        var area         = $('#area_id').val();
        var area_name    = $("select[name='area_id']").find("option:selected").text();
        var street       = $('#street_id').val();
        var street_name  = $("select[name='street_id']").find("option:selected").text();
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#area_mid').val();


        var data = {
            id   : id,
            city  : city,
            pro   : pro,
            area   : area,
            street   : street,
            city_name  : city_name,
            pro_name   : pro_name,
            area_name   : area_name,
            street_name   : street_name,
//            information : information
        };
//        console.log(data);return;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/addarea',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    //点击编辑或添加幻灯图
    $('.add-slide').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('.add-level').on('click',function () {
        $('#hid_level_id').val($(this).data('id'));
    });
    $('.add-area').on('click',function () {
        $('#area_mid').val($(this).data('id'));
    });

    $('#pro_id').change(function(){
        $("#city").html('');
        $("#area").html('');
        var p_ro = $(this).val();
        //console.log(p_ro);return;
        var data = {
            'fid'   : p_ro,
            'level' : 2,
        }
        $.ajax({
            url:'/wxapp/member/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value=''>地市</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['id'] + '>' + v['name'] + '</option>'
                });
                $("#city_id").html(option);
            }
        })

    });
    $('#city_id').change(function(){
        $("#area_id").html('');
        var city = $(this).val();
        var data = {
            'fid'   : city,
            'level' : 3,
        }
        $.ajax({
            url:'/wxapp/member/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='不限'>不限</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['id'] + '>' + v['name'] + '</option>'
                });
                $("#area_id").html(option);
            }
        })

    });
    $('#area_id').change(function(){
        $("#street_id").html('');
        var area = $(this).val();
        var data = {
            'fid'   : area,
            'level' : 4,
        }
        $.ajax({
            url:'/wxapp/member/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='不限'>不限</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['id'] + '>' + v['name'] + '</option>'
                });
                $("#street_id").html(option);
            }
        })

    });



    $('#pro').change(function(){
        $("#city").html('');
        $("#area").html('');
        var p_ro = $(this).val();
        //console.log(p_ro);return;
        var data = {
            'fid'   : p_ro,
            'level' : 2,
        }
        $.ajax({
            url:'/wxapp/member/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value=''>地市</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['id'] + '>' + v['name'] + '</option>'
                });
                $("#city").html(option);
            }
        })

    });
    $('#city').change(function(){
        $("#area").html('');
        var city = $(this).val();
        var data = {
            'fid'   : city,
            'level' : 3,
        }
        $.ajax({
            url:'/wxapp/member/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='不限'>不限</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['id'] + '>' + v['name'] + '</option>'
                });
                $("#area").html(option);
            }
        })

    });
    $('#area').change(function(){
        $("#street").html('');
        var area = $(this).val();
        var data = {
            'fid'   : area,
            'level' : 4,
        }
        $.ajax({
            url:'/wxapp/member/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='不限'>不限</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['id'] + '>' + v['name'] + '</option>'
                });
                $("#street").html(option);
            }
        })

    });


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
    $('.js-recharge-btn').on('click',function(){
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
        $('#recharge_remark').val('');
        $('#pwd').val('');
    });


    //增加积分模态框点击
    $('.js-point-btn').on('click',function(){
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
        var remark = $('#recharge_remark').val();
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
        var status = $(this).attr('status');
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
        // var sortType = $(this).data('sorttype');
        var nickname = $('#nickname').val();
        var mid = $('#mid').val();
        var source = $('#source').val();
        var category = $('#category').val();
        var searchlv = $('#searchlv').val();
        // var remark = $('#remark').val();
        var mobile = $('#mobile').val();
        var start = $('#start-time').val();
        var end = $('#end-time').val();
        var authorization = $('#authorization').val();

        $('#excel_nickname').val(nickname);
        $('#excel_showid').val(mid);
        $('#excel_mobile').val(mobile);
        $('#excel_source').val(source);
        $('#excel_category').val(category);
        $('#excel_level').val(searchlv);
        $('#excel_startDate').val(start);
        $('#excel_endDate').val(end);
        $('#excel_authorization').val(authorization);
        // $('#excel_remark')


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

    $('.sort-type-item').on('click',function () {
        var sortType = $(this).data('sorttype');
        var nickname = $('#nickname').val();
        var mid = $('#mid').val();
        var source = $('#source').val();
        var category = $('#category').val();
        var searchlv = $('#searchlv').val();
        var remark = $('#remark').val();
        var mobile = $('#mobile').val();
        var start = $('#start-time').val();
        var end = $('#end-time').val();

        var url = '/wxapp/member/list?nickname='+nickname+'&mid='+mid+'&source='+source+'&category='+category+'&sortType='+sortType+'&searchlv='+searchlv+'&remark='+remark+'&mobile='+mobile+'&start='+start+'&end'+end;
        window.location.href = url;
    });


    $('.js-change-cate-btn').on('click',function () {
        var mid = $(this).data('mid');
        var cate = $(this).data('cate');
        $('#cate_mid_single').val(mid);
        $('#custom_cate_single').val(cate);
    });

    $('.change-level-btn').on('click',function () {
        var mid = $(this).data('mid');
        var level = $(this).data('level');
        $('#level_mid_single').val(mid);
        $('#custom_level_single').val(level);
    });

    $('#change-cate-single').on('click',function(){
        // var ids  = get_select_all_ids_by_name('ids');
        var id = $('#cate_mid_single').val();
        var ids = id+',';
        if(ids){
            $(this).attr('disabled','disabled');
            var data = {
                'mids' : ids,
                'cate': $('#custom_cate_single').val()
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

    $("#change-level-single").on('click', function() {
        var id    = $('#level_mid_single').val();
        var level = $('#custom_level_single').val();
        var text = $("#custom_level_single option:selected").text();
        if(id>0 && level != 0){
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
                        //window.location.reload();
                        if(level < 0){
                            $('#tr_'+id).find('.member-level-text').html('无');
                        }else if(level > 0){
                            $('#tr_'+id).find('.member-level-text').html(text);
                        }
                        $('#levelSingleModal').modal('hide')
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择用户等级');
        }

    });

</script>
<{include file="../img-upload-modal.tpl"}>

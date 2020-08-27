<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">

<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }

    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }

    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    .lookup-condition{
        width: 100%;
        height: 35px;
        margin-bottom: 10px;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }


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
    .tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
    .ui-popover{
        z-index: 999;
    }
</style>
<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <{include file="../layer/ajax-select-input-single.tpl"}>
        <input type="hidden" id="hid_acsId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary js-save my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<div id="content-con">
    <!-- 推广商品弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">店铺二维码</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后进入店铺</p>
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                    <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>

    <div  id="mainContent" >
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
            入驻商家登录管理地址：<a href="http://<{$curr_domain}>/shop/user/index<{$ext_query}>" target="_blank"> http://<{$curr_domain}>/shop/user/index<{$ext_query}></a><a href="javascript:;" class="copy-button btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://<{$curr_domain}>/shop/user/index<{$ext_query}>" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>
            <br>
            <span style="color: red;">提示：已入驻商家的账号密码均默认为填写的手机号</span>
        </div>

        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">全部商家<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已到期商家<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_ydq']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">置顶商家<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_zd']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">推荐商家<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total_tj']}></span>
                </div>
            </div>

        </div>

        <div class="page-header">
            <a class="btn btn-green btn-xs add-activity" href="/wxapp/city/addAreaShop"><i class="icon-plus bigger-80"></i>添加店铺</a>
            <a class="btn btn-green btn-xs add-activity" href="/wxapp/city/shopListPage"><i class="fa-asterisk bigger-80"></i>附近商家页面设置</a>
            <a href="javascript:;" class="btn btn-green btn-xs btn-excel" data-toggle="modal" data-target="#excelShop" ><i class="icon-download"></i>导出店铺</a>
            <div class="watermrk-show">
                <span class="label-name">店铺订单抽成比例(%)：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="text" style="width: 60px" class="form-control" id="default-maid" value="<{$payCfg['ap_shop_percentage']}>">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-default-maid">确认修改</span>
                            <span>（微信在线支付提现会收取0.6%手续费）</span>
                        </span>
                    </div>
                </div>
            </div>
        </div><!-- /.page-header -->
        <!-- 复制链接弹出框 -->
        <div class="ui-popover ui-popover-link left-center" style="top:100px;">
            <div class="ui-popover-inner">
                <div class="input-group copy-div">
                    <input type="text" class="form-control" id="copy" value="" readonly>
                    <span class="input-group-btn">
                    <a href="javascirpt:;" class="btn btn-white copy-button" id="copycardid" type="button" data-clipboard-action="copy" data-clipboard-text="" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
                </div>
            </div>
            <div class="arrow"></div>
        </div>

        <div class="page-header search-box" style="margin-bottom: 20px">
            <div class="col-sm-12">
                <form action="/wxapp/city/shopList" method="get" class="form-inline">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">店铺名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="店铺名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">店铺分类</div>
                                    <select id="cate" name="cate" style="height:34px;width:100%" class="form-control">
                                        <option value="0">全部</option>
                                        <{foreach $categorySelect as $key => $val}>
                                        <option <{if $categorySelect eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">店铺电话</div>
                                    <input type="text" class="form-control" name="mobile" value="<{$mobile}>" placeholder="店铺电话">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">到期类型</div>
                                    <select id="type" name="type" style="height:34px;width:100%" class="form-control">
                                        <option value="0" <{if $type == 0}>selected<{/if}>>全部</option>
                                        <option value="1" <{if $type == 1}>selected<{/if}>>未到期</option>
                                        <option value="2" <{if $type == 2}>selected<{/if}>>已到期</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">认领状态</div>
                                    <select id="has_member" name="has_member" style="height:34px;width:100%" class="form-control">
                                        <option value="0" <{if $has_member == 0}>selected<{/if}>>全部</option>
                                        <option value="1" <{if $has_member == 1}>selected<{/if}>>已认领</option>
                                        <option value="2" <{if $has_member == 2}>selected<{/if}>>未认领</option>
                                    </select>
                                </div>
                            </div>

                             <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">店铺标签</div>
                                    <select id="tags" name="tags" style="height:34px;width:100%" class="form-control">
                                        <option value="-1" <{if $smarty.get.tags === -1 || $smarty.get.tags==''}>selected<{/if}>>全部</option>
                                        <option value="0" <{if $smarty.get.tags === 0}>selected<{/if}>>无</option>
                                        <option value="1" <{if $smarty.get.tags == 1}>selected<{/if}>>活动</option>
                                        <option value="2" <{if $smarty.get.tags == 2}>selected<{/if}>>新店</option>
                                        <option value="3" <{if $smarty.get.tags == 3}>selected<{/if}>>优惠</option>
                                        <option value="4" <{if $smarty.get.tags == 4}>selected<{/if}>>置顶</option>
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
        <div style="font-size: 16px;margin-bottom: 20px">
            已入驻共 <span style="color: blue"><{$shopCountInfo['countAll']}></span> 家，已到期 <span style="color: blue"><{$shopCountInfo['countExpire']}></span> 家
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                        	<th>店铺名称</th>
                            <th>店铺标签</th>                           
                            <th>会员编号</th>
                            <{if $hadSc == 1}>
                            <th>登录账号</th>
                            <{/if}>
                            <th>店铺分类</th>
                            <!--
                            <th>店铺地址</th>
                            <th>营业时间</th>
                            <th>店铺电话</th>
                            -->
                            <th>创建时间</th>
                            <th>到期时间</th>
                            <!--
                            <th>是否已推送</th>
                             -->
                            <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                            <th>是否置顶</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acs_id']}>" class="tr-content">
                            	<td>
                                    <{$val['acs_name']}>
                                    <p>
                                        <{if $val['acs_is_recommend'] eq 1}>
                                        <span class="label label-sm label-success">推荐</span>
                                        <{/if}>
                                    </p>
                                </td>
                                <td style="text-align: center">
                                    <{if $val['acs_label_type'] == 0}>
                                    <span>无</span>
                                    <{elseif $val['acs_label_type'] == 1}>
                                    <img src="/public/wxapp/city/images/icon_hd.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{elseif $val['acs_label_type'] == 2}>
                                    <img src="/public/wxapp/city/images/icon_xd.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{elseif $val['acs_label_type'] == 3}>
                                    <img src="/public/wxapp/city/images/icon_yh.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{elseif $val['acs_label_type'] == 4}>
                                    <img src="/public/wxapp/city/images/icon_zd.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{/if}>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend edit-info" data-id="<{$val['acs_id']}>" data-labelType="<{$val['acs_label_type']}>" onclick="changeLabel(this)" data-toggle="modal" data-target="#labelModal">
                                    <!--<p style="margin:0;text-align: left;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-id="<{$val['acs_id']}>" data-labelType="<{$val['acs_label_type']}>" onclick="changeLabel(this)" data-toggle="modal" data-target="#labelModal">设置标签</a>
                                    </p>-->
                                </td>                                
                                <td>
                                     <{$val['m_show_id']}><br>
                                    <{$val['m_nickname']}>
                                </td>
                                <{if $hadSc == 1}>
                                <td>
                                    <{if $val['esm_mobile']}><{$val['esm_mobile']}><{else}>无账号<{/if}>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend edit-info" data-esmid="<{$val['esm_id']}>"  data-mobile="<{$val['esm_mobile']}>" data-acsid="<{$val['acs_id']}>" onclick="" data-toggle="modal" data-target="#infoModal">
                                    <!--<p style="margin:0;text-align: left;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-esmid="<{$val['esm_id']}>"  data-mobile="<{$val['esm_mobile']}>" data-acsid="<{$val['acs_id']}>" onclick="" data-toggle="modal" data-target="#infoModal">修改账户信息</a>
                                    </p>-->
                                </td>
                                <{/if}>
                                <td>
                                    <{$categorySelect[$val['acs_category_id']]}>
                                </td>
                                <!--
                                <td>
                                    <{$val['acs_address']}>
                                </td>
                                <td>
                                    <{$val['acs_open_time']}>
                                </td>
                                <td>
                                    <{$val['acs_mobile']}>
                                </td>
                                -->
                                <td><{date('Y-m-d H:i:s',$val['acs_create_time'])}></td>
                                <td><{date('Y-m-d',$val['acs_expire_time'])}></td>
                                <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                <td><{if $val['acs_istop']}><span style="color: red;">已置顶</span><{else}><span >未置顶</span><{/if}></td>
                                <{/if}>
                                <!--
                                <td><{if $val['acs_push']}>已推送<{else}><span style="color: red">未推送</span><{/if}></td>
                                -->
                                <td class="jg-line-color">
                                    <p>
                                    <a class="change-expire" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['acs_id']}>" data-expire="<{$val['acs_expire_time']}>">延长时间</a> -
                                    <a href="/wxapp/city/shopPayRecord/id/<{$val['acs_id']}>">付费记录</a>
                                    <{if $hadSc == 1  && $val['acs_es_id'] > 0}>
                                        - <a href="/wxapp/citymall/shopOrder/esId/<{$val['acs_es_id']}>">商家订单</a>
                                    <{/if}>
                                    </p>
                                    <p>
                                        <a href="javascript:;" id="link_<{$val['es_id']}>" class="btn-link" data-link="pages/shopDetailnew/shopDetailnew?id=<{$val['acs_id']}>">店铺路径</a>
                                        <{if !in_array($menuType,['toutiao','qq'])}>
                                        - <a href="javascript:;" class="btn-tuiguang" data-id="<{$val['acs_id']}>" data-share="<{$val['acs_qrcode']}>">小程序码</a>
                                        - <a href="javascript:;" class="remove-qrcode" data-id="<{$val['acs_id']}>" >清除码</a>
                                        <{/if}>
                                        <{if $val['acs_list_show'] == 1}>
                                        - <a href="javascript:;" class="change-shop-show" data-id="<{$val['acs_id']}>" data-status="0" style="color:red;">隐藏店铺</a>
                                        <{else}>
                                        - <a href="javascript:;" class="change-shop-show" data-id="<{$val['acs_id']}>" data-status="1" style="color:green;">显示店铺</a>
                                        <{/if}>
                                    </p>
                                    <p>
                                    	<a href="#" class="set-member" data-id="<{$val['acs_id']}>" >绑定会员</a>
                                    	 - <a class="confirm-handle" href="/wxapp/city/claimList/acsId/<{$val['acs_id']}>">店铺认领</a>
                                         - <a href="#" class="set-member1" onclick="topShop(this)" data-id="<{$val['acs_id']}>" data-top="<{$val['acs_istop']}>">
                                            <{if $val['acs_istop']==0}>置顶<{else}>取消置顶<{/if}>
                                        </a>
                                        <{if !in_array($menuType,['toutiao','qq'])}>
                                        <{if $val['acs_es_id'] > 0}>
                                        - <a class="edit-entershop-plugin" data-esid="<{$val['acs_es_id']}>" data-plugin='<{$val['espo_plugin']}>' data-toggle="modal" data-target="#entershopPluginModal">营销工具</a>
                                        <{/if}>
                                        <{/if}>
                                        <!-- 添加删除会员 -->
                                        <a class='delete-member' href="javascript:;" data-id="<{$val['acs_id']}>" style='color: red;'>删除会员</a>
                                    </p>
                                    <p>
                                        <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                        <a href="javascript:;" onclick="pushShop('<{$val['acs_id']}>')" >推送</a> -
                                        <{if !in_array($menuType,['weixin'])}>
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<{$val['acs_id']}>')">预览</a> -
                                        <{/if}>
                                        <a href="/wxapp/tplpreview/pushHistory?type=shop&id=<{$val['acs_id']}>" >记录</a>
                                        <{/if}>
                                        - <a class="confirm-handle" href="/wxapp/city/addAreaShop/id/<{$val['acs_id']}>">编辑</a>
                                        - <a class="delete-btn" data-id="<{$val['acs_id']}>" style="color:red;">删除</a>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="12"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    延长到期时间
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div style="margin: auto">
                        <div class="col-sm-3 inline-div" style="text-align: right">延长</div>
                        <div class="col-sm-6">
                            <input type="number" name="expire" id="expire" placeholder="请填写整数" class="form-control" >
                        </div>
                        <div class="col-sm-3 inline-div" style="text-align: left">个月</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-expire">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
            <input type="hidden" id="acsid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    信息修改
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">账号：</label>
                    <div class="col-sm-8">
                        <input id="mobile" class="form-control" placeholder="请填写联系电话" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码：</label>
                    <div class="col-sm-8">
                        <input id="password" type="password" class="form-control" placeholder="请填写登录密码" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-info">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="labelModal" tabindex="-1" role="dialog" aria-labelledby="labelModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="lsid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    设置标签
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="control-group" style="padding-left: 66px;">
                        <div class="radio-box">
                            <span>
                                <input type="radio" name="label_type" id="labelType0" value="0" >
                                <label for="labelType0">无</label>
                            </span>
                            <span>
                                <input type="radio" name="label_type" id="labelType1" value="1"  >
                                <label for="labelType1"><img src="/public/wxapp/city/images/icon_hd.png" alt="" style="height: 20px;margin-bottom: 3px;"></label>
                            </span>
                            <span>
                                <input type="radio" name="label_type" id="labelType2" value="2"  >
                                <label for="labelType2"><img src="/public/wxapp/city/images/icon_xd.png" alt="" style="height: 20px;margin-bottom: 3px;"></label>
                            </span>
                            <span>
                                <input type="radio" name="label_type" id="labelType3" value="3"  >
                                <label for="labelType3"><img src="/public/wxapp/city/images/icon_yh.png" alt="" style="height: 20px;margin-bottom: 3px;"></label>
                            </span>
                            <span>
                                <input type="radio" name="label_type" id="labelType4" value="4"  >
                                <label for="labelType4"><img src="/public/wxapp/city/images/icon_zd.png" alt="" style="height: 20px;margin-bottom: 3px;"></label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-label">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="excelShop" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出店铺
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/excel/cityShopExportExcel" method="post">
                        <div class="form-group lookup-condition">
                            <label class="col-sm-2 control-label" style="text-align: right;width: 150px">店铺类型</label>
                            <div class="col-sm-6">
                                <select id="category" name="category" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $categorySelect as $key => $val}>
                                <option <{if $categorySelect eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="form-group lookup-condition">
                            <label class="col-sm-2 control-label" style="text-align: right;width: 150px">入驻到期时间</label>
                            <div class="col-sm-6">
                                <input  class="form-control" name="startDate" type="text" class="Wdate" onClick="WdatePicker()" />
                            </div>
                        </div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    推送预览
                </h4>
            </div>
            <div class="modal-body preview-page" style="overflow: auto">
                <div class="mobile-page ">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar">
                            消息模板预览
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="height: 380px;">
                                <div class="message">
                                    <h3 id="tpl-title"></h3>
                                    <p class="date" id="tpl-date"></p>
                                    <div class="item-txt"  id="tpl-content">

                                    </div>
                                    <div class="see-detail">进入小程序查看</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-footer"><span></span></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="entershopPluginModal" tabindex="-1" role="dialog" aria-labelledby="entershopPluginModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <input type="hidden" id="plugin_es_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    营销工具
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto" >
                <{foreach $enter_shop_plugin as $key => $value}>
                <div class="form-group" style="margin-top: 10px;">
                    <label class="control-label">是否开启<{$value['name']}>：</label>
                    <div class="control-group" style="display: inline-block;">
                        <label style="padding: 4px 0;margin: 0;">
                            <input name="show_<{$value['id']}>" class="ace ace-switch ace-switch-5" id="show_<{$value['id']}>" type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </div>
                </div>
                <{/foreach}>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-plugin-open">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>

<script>
    var entershopPluginArr = <{$entershopPluginArr}>;
    console.log(entershopPluginArr);
    // 定义一个新的复制对象
    var clipboard = new ClipboardJS('.copy-button');
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        console.log(e);
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
        console.log(e);
        console.log('复制失败');
    });

    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');

        optshide();
        console.log(6666)
    } );


    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            $('.copy-div input').val(link);
            $('#copycardid').attr('data-clipboard-text',link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        console.log('444');
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-505,'top':top-conTop - 125}).stop().show();
    });

    //重新生成店铺二维码图片
    function reCreateQrcode(id=0){
        if(id==0){
            id = $('#qrcode-goods-id').val();
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/createQrcode',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }
    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        console.log(shareImg);
        var id  = that.data('id');
//        if(shareImg){
//
//        }else{
//            reCreateQrcode(id);
//        }
        $('#act-code-img').attr('src',shareImg); //分享二维码图片
        $('#qrcode-goods-id').val(id);
        $('#download-goods-qrcode').attr('href', '/wxapp/city/downloadShopQrcode?id='+id);
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        console.log('555');
        $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158-95}).stop().show();
    });
    /*隐藏弹出框*/
    function optshide(event){
        $('.ui-popover').stop().hide();
        console.log('11111111');
        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
            $(this).remove();
        });
    }
    $("#content-con").on('click', function(event) {
        console.log('22222');


            $('.ui-popover').stop().hide();
            //清空已选择
            $("#multi-choose").find(".choose-txt").each(function () {
                $(this).remove();
            });

    });
    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');
        if(id){
            layer.confirm('确定删除吗？', {
                title:'删除提示',
                btn: ['确定','取消'] //按钮
            }, function(){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/city/deleteShop',
                    'data'  : {id:id},
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

        }
    });

    function changeLabel(e) {
        $('#lsid').val($(e).data('id'));
        $(":radio[name='label_type'][value='" + $(e).data('labeltype') + "']").prop("checked", "checked");
    }

    function pushShop(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/shopPush',
                'data'  : { id:id, type: 'city'},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                            if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }
    /*将店铺置顶或者取消置顶
     */
    function topShop(obj){
        var istop = $(obj).data('top');
        var id    = $(obj).data('id');
        var msg   = '';
        if(!istop){
            msg='你确定要将该店铺置顶吗?';
        }else{
            msg='你确定要将该店铺置顶取消吗?';
        }
        console.log(istop);
        layer.confirm(msg, {
            btn: ['确定','取消'], //按钮
            title : '置顶'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/shopTop',
                'data'  : { id:id, istop: istop},
                'dataType' : 'json',
                success : function(ret){
                    console.log(ret);
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    $('.change-expire').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#now_expire').val($(this).data('expire'));
        $('#expire').val('');
    });

    $('.remove-qrcode').on('click',function () {
       var id = $(this).data('id');

       var data = {
           id :id
       };

       if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/removeQrcode',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){

                    }
                }
            });
        }

    });


    $('#change-expire').on('click',function(){
        var hid = $('#hid_id').val();
        var expire = $('#expire').val();
        var now_expire = $('#now_expire').val();
        console.log(hid);

        if(!expire){
            layer.msg('请填写延长时间');
            return false;
        }

        var data = {
            id : hid,
            expire : expire,
            now_expire : now_expire
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/changeExpire',
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

    $("#content-con").on('click', 'table td a.set-member', function(event) {

        var id = $(this).data('id');
        $('#hid_acsId').val(id);
        optshide();
        console.log('333');
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-349,'top':top-conTop-106}).stop().show();
    });

    $(function(){

        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1
        });

        $('.js-save').on('click',function(){
            var acsId = $('#hid_acsId').val();
            var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
            if(!mid){
                layer.msg('请选择会员');
                return;
            }

            console.log(acsId);
            console.log(mid);
            var data = {
                'id' : acsId,
                'mid': mid
            };
            console.log(data);
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/changeBelong',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        optshide();
                        window.location.reload();
                    }
                }
            });

        });
    });

    $('.edit-info').on('click',function () {
        $('#esmid').val($(this).data('esmid'));
        $('#acsid').val($(this).data('acsid'));
        $('#mobile').val($(this).data('mobile'));
    });

    $('#confirm-info').on('click',function(){
        var id      = $('#esmid').val();
        var acsId    = $('#acsid').val();
        var mobile   = $('#mobile').val();
        var password = $('#password').val();
        var data = {
            id     : id,
            acsId  : acsId,
            mobile   : mobile,
            password : password
        };
        if(mobile && password){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/city/changeInfo',
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
        }else{
            layer.msg('请完善账户信息');
        }
    });

    $('#confirm-label').on('click',function(){
        var id        = $('#lsid').val();
        var labelType = $("input[name='label_type']:checked").val();
        var data = {
            id     : id,
            labelType: labelType
        };

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/changeShopLabel',
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

    });

    /**
     * 修改默认抽成比例
     */
    $('#save-default-maid').on('click',function(){
        var defaultmaid = $('#default-maid').val();    // 默认抽成比例
        if(defaultmaid){
            if(defaultmaid=='<{$payCfg['ap_shop_percentage']}>'){
                return;
            }
            var index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            var data = {
                'defaultmaid' : defaultmaid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/Basiccfg/updateDefaultMaid',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        }
    });

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/shopPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }
    $('.edit-entershop-plugin').click(function () {
        var esid = $(this).data('esid');
        var plugin = $(this).data('plugin');
//        console.log(plugin);
        $('#plugin_es_id').val(esid);
//        console.log(plugin.length);
        if(plugin.length > 0){
            //先将所有的开启
            for(var i=0;i<entershopPluginArr.length;i++){
                $('#show_'+entershopPluginArr[i].id).prop("checked", true);
            }
            //将已关闭的关闭
            for(var j = 0;j<plugin.length;j++){
                if(plugin[j].open == '0'){
                    $('#show_'+plugin[j].id).prop("checked", false);
                }
            }
        }else{
            for(var a=0;a<entershopPluginArr.length;a++){
                $('#show_'+entershopPluginArr[a].id).prop("checked", true);
            }
        }
    })

    $('#save-plugin-open').click(function () {
        $(this).attr('disabled','disabled');
       var id =  $('#plugin_es_id').val();
       var result_arr = [];
       var row = '';
       var res = '';
       for(var i=0;i<entershopPluginArr.length;i++){
           res = $('#show_'+entershopPluginArr[i].id).is(':checked');
           console.log(res);
           res = res ? 1 : 0;
           row = {
               'id' : entershopPluginArr[i].id,
               'open' : res
           }
           result_arr.push(row);
       }
//       console.log(entershopPluginArr.length);
//       console.log(id);
//       console.log(result_arr);
       var data = {
           'esId' : id,
           'plugin' : result_arr
       };
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/saveEntershopPlugin',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                    $(this).removeAttr('disabled');
                }

            }
        });

    });

    // 店铺删除会员信息
    $('.delete-member').click(function(){
        let shop_id=$(this).data('id');
        layer.confirm('是否要删除当前会员信息？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        },function(){
            var loading = layer.load(2);
            // 会员编号
            $.ajax({
                type:'POST',
                url:'/wxapp/city/deleteMember',
                dataType:'json',
                data:{
                    'shop_id':shop_id,
                },
                success:function(res){
                    layer.close(loading);
                    layer.msg(res.em);
                    if(res.ec == 200){
                        window.location.reload();
                    }
                }
            });
        });

    });

    $('.change-shop-show').click(function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        var msg = '';
        if(status == 1){
            msg = '显示';
        }else{
            msg = '隐藏';
        }

        var data = {
            id:id,
            status:status
        };

        layer.confirm('是否要'+msg+'当前店铺？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        },function(){
            var loading = layer.load(2);
            // 会员编号
            $.ajax({
                type:'POST',
                url:'/wxapp/city/changeShopShow',
                dataType:'json',
                data:data,
                success:function(res){
                    layer.close(loading);
                    layer.msg(res.em);
                    if(res.ec == 200){
                        window.location.reload();
                    }
                }
            });
        });

    });

</script>
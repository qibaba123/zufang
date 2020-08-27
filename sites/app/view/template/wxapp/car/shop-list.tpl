<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">

<style>
    /*
     * 设置等级弹出框
     */
    .page-content{
        position: relative;
    }
    .cate-span{
        display: block;
        text-align: center;
        margin-bottom: 1px;
    }
    .my-ui-btn{
        margin: 0 7px;
    }
    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }
    .alert-orange {
        text-align: center;
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
</style>
<!-- 修改门店等级 -->
<div class="ui-popover ui-popover-select left-center grade-select" style="top:100px;width: 410px">
    <div class="ui-popover-inner">
        <span></span>
        <select id="shop-grade" name="jiaohuo">
            <{if $shopLevel}>
                <option value="0">请选择等级</option>
            <{foreach $shopLevel as $key=>$val}>
                <option value="<{$key}>"><{$val}></option>
            <{/foreach}>
            <{else}>
                <option value="0">尚未添加等级</option>
            <{/if}>
        </select>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn ui-btn-primary save-grade" href="javascript:;">确定</a>
        <a class="ui-btn ui-btn-warning remove-grade" href="javascript:;">移除等级</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<!-- 修改所属会员 -->
<div class="ui-popover ui-popover-select left-center member-select" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <{include file="../layer/ajax-select-input-single.tpl"}>
        <input type="hidden" id="hid_esId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary save-member my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<!-- 服务商二维码 -->
<div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">服务商二维码</span>
                <span>服务商链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看</div>
                    <div class="code-fenlei">
                        <div style="text-align: center;margin: 0 auto">
                            <div class="text-center show" >
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后进入服务商</p>
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                    <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="link-box">
                    <div class="link-wrap">
                        <p>服务商链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="pages/goodDetail/goodDetail" readonly>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-white copy-button" id="copygoods" type="button" data-clipboard-action="copy" data-clipboard-target="#copyLink" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
<div  id="mainContent" >
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
        服务商登录管理地址：<a href="http://<{$curr_domain}>/shop/user/index"> http://<{$curr_domain}>/shop/user/index</a><a href="javascript:;" class="copy-button btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://<{$curr_domain}>/shop/user/index" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>
            <br>
            <span style="color: red;">提示：已入驻服务商的账号密码均默认为填写的手机号</span>
    </div>
<div class="page-header">
            <a href="/wxapp/car/addShop" class="btn btn-green btn-sm"><i class="icon-plus bigger-80"></i> 新增</a>
            <a href="javascript:;" class="btn btn-green btn-xs btn-excel" data-toggle="modal" data-target="#excelShop" ><i class="icon-download"></i>导出服务商</a>
    <div class="watermrk-show">
        <span class="label-name">店铺订单抽成比例(%)：</span>
        <div class="watermark-box">
            <div class="input-group">
                <input type="text" style="width: 60px" class="form-control" id="default-maid" value="<{$maid}>">
                <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-default-maid">确认修改</span>
                            <span>（微信在线支付提现会收取0.6%手续费）</span>
                        </span>
            </div>
        </div>
    </div>
</div><!-- /.page-header -->

<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/car/shopList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">服务商名称</div>
                            <input type="text" class="form-control" name="shopName" value="<{$shopName}>"  placeholder="服务商名称">
                        </div>
                    </div>
                    <!--
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">负责人</div>
                            <input type="text" class="form-control" name="contact" value="<{$contact}>"  placeholder="服务商负责人">
                        </div>
                    </div>
                    -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">电话</div>
                            <input type="text" class="form-control" name="phone" value="<{$phone}>"  placeholder="服务商电话">
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
<div id="content-con">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>标签</th>
                            <th>服务商名称</th>
                            <th>会员编号</th>
                            <th>登录账号</th>
                            <th>分类</th>
                            <th>到期时间</th>
                            <!--
                            <th>是否已推送</th>
                            <th>是否开启买单</th>
                            -->
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['es_id']}>">
                                <td style="text-align: center">
                                    <{if $val['es_label_type'] == 0}>
                                    <span>无</span>
                                    <{elseif $val['es_label_type'] == 1}>
                                <img src="/public/wxapp/city/images/icon_hd.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{elseif $val['es_label_type'] == 2}>
                                <img src="/public/wxapp/city/images/icon_xd.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{elseif $val['es_label_type'] == 3}>
                                <img src="/public/wxapp/city/images/icon_yh.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{elseif $val['es_label_type'] == 4}>
                                <img src="/public/wxapp/city/images/icon_zd.png" alt="" style="height: 20px;margin-bottom: 10px;">
                                    <{/if}>
                                    <p style="margin:0;text-align: left;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-id="<{$val['es_id']}>" data-labelType="<{$val['es_label_type']}>" onclick="changeLabel(this)" data-toggle="modal" data-target="#labelModal">设置标签</a>
                                    </p>
                                </td>
                                <td>
                                    <p><{$val['es_name']}></p>
                                    <!--
                                    <p>营业状态：<{if $val['es_hand_close'] == 1}><span style="color:red;">已打烊</span><{else}><span style="color: blue">正常</span><{/if}>
                                    </p>
                                    -->
                                    <p>
                                        <{if $val['es_is_recommend'] eq 1}>
                                        <span class="label label-sm label-success">推荐</span>
                                        <{/if}>
                                    </p>
                                </td>
                                <td>
                                    <{$val['m_show_id']}>
                                </td>
                                <td>
                                    <{if $val['esm_mobile']}><{$val['esm_mobile']}><{else}>无账号<{/if}>
                                    <p style="margin:0;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-esmid="<{$val['esm_id']}>" data-esid="<{$val['es_id']}>" data-mobile="<{$val['esm_mobile']}>" onclick="" data-toggle="modal" data-target="#infoModal">修改账户信息</a>
                                    </p>
                                </td>
                                <td><span class="cate-span"><{$category[$val['es_cate1']]['ack_name']}></span></td>
                                <td><{if $val['es_expire_time'] > 0}><{date('Y-m-d H:i',$val['es_expire_time'])}><{/if}></td>
                                <!--
                                <td><{if $val['es_level']}><{$shopLevel[$val['es_level']]}><{else}><{/if}></td>
                                <td><{if $val['es_push']}>已推送<{else}><span style="color: red">未推送</span><{/if}></td>
                                <td><{if $val['es_isbuy']}><span style="color: green;">已开启</span><{else}><span style="color: red;">已关闭</span><{/if}>
                                    <p style="margin:0;">
                                        <{if $val['es_isbuy']}>
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" onclick="openShop(this)" data-buy="<{$val['es_isbuy']}>" data-id="<{$val['es_id']}>">
                                            <{if $val['es_isbuy']}>关闭<{else}>开启<{/if}>
                                        </a>
                                        <{else}>
                                        <a href="javascript:;" class="btn btn-success btn-xs edit-info" onclick="openShop(this)" data-buy="<{$val['es_isbuy']}>" data-id="<{$val['es_id']}>">
                                           开启
                                        </a>
                                        <{/if}>
                                    </p>
                                </td>
                                -->
                                <td>
                                    <p>
                                        <!--
                                        <a href="/wxapp/community/shopOrder/esId/<{$val['es_id']}>">服务商订单</a>
                                        -->
                                         <a class="change-expire" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['es_id']}>" data-expire="<{$val['es_expire_time']}>">延长时间</a>
                                        <!--
                                         - <a href="#" class="set-shopgrade" data-id="<{$val['es_id']}>" data-level="<{$val['es_level']}>">等级设置</a>
                                         -->
                                    </p>
                                    <p>
                                        <!--
                                        <{if $showFree}>
                                        <a href="/wxapp/free/freeTradeList?esId=<{$val['es_id']}>" class="" data-id="<{$val['es_id']}>" >预约订单</a> -
                                        <{/if}>
                                        -->
                                         <a href="#" class="set-shop-member" data-id="<{$val['es_id']}>" >绑定会员</a>
                                         - <a href="javascript:;" class="btn-tuiguang" data-id="<{$val['es_id']}>" data-share="<{$val['es_qrcode']}>" data-link="pages/serviceproDetail/serviceproDetail?id=<{$val['es_id']}>">二维码</a>
                                         - <a href="/wxapp/car/resourceList?shopName=<{$val['es_name']}>" target="_blank">查看车源</a>
                                    </p>
                                    <p>
                                        <a href="/wxapp/car/addShop/id/<{$val['es_id']}>" >编辑</a>
                                        <!--
                                        <{if $val['es_status'] eq 0}>
                                         - <a class="confirm-handle" href="#" style="color: red" onclick="changeStatus('<{$val['es_id']}>','<{$val['es_status']}>')">封禁</a>
                                        <{else}>
                                         - <a class="confirm-handle" href="#"  onclick="changeStatus('<{$val['es_id']}>','<{$val['es_status']}>')">解封</a>
                                        <{/if}>
                                        -->
                                         - <a href="#" class="delete-shop" data-id="<{$val['es_id']}>" style="color: red">删除</a>
                                        <!--
                                        <{if $val['es_hand_close']}>
                                        - <a href="#" class="hand-close-shop" data-id="<{$val['es_id']}>" data-type="0" style="color: blue">开启服务商</a>
                                        <{else}>
                                        - <a href="#" class="hand-close-shop" data-id="<{$val['es_id']}>" data-type="1" style="color: red">打烊服务商</a>
                                        <{/if}>
                                        -->
                                    </p>
                                    <!--
                                    <p>
                                        <a href="javascript:;" onclick="pushShop('<{$val['es_id']}>')" >推送</a> -
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<{$val['es_id']}>')">推送预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=cshop&id=<{$val['es_id']}>" >推送记录</a>
                                    </p>
                                    -->
                                    <!---<a href="#" class="set-shop" onclick="openShop(this)" data-buy="<{$val['es_isbuy']}>" data-id="<{$val['es_id']}>" ><{if $val['es_isbuy']}>关闭买单<{else}>开启买单<{/if}></a>-->
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="11"><{$pagination}></td></tr>
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
                        <div class="col-sm-3 inline-div" style="text-align: right;padding-top: 6px">延长</div>
                        <div class="col-sm-6">
                            <input type="number" name="expire" id="expire" placeholder="请填写整数" class="form-control" >
                        </div>
                        <div class="col-sm-3 inline-div" style="text-align: left;padding-top: 6px">个月</div>
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
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
            <input type="hidden" id="esid">
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
                        <input id="password" type="password" autocomplete="off" class="form-control" placeholder="请填写登录密码" style="height:auto!important"/>
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
<div class="modal fade" id="excelShop" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出服务商
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/excel/carShopExportExcel" method="post">
                        <div class="form-group lookup-condition">
                            <label class="col-sm-2 control-label" style="text-align: right;width: 150px">服务商类型</label>
                            <div class="col-sm-6">
                                <select id="category" name="category" style="height:34px;width:100%" class="form-control">
                                    <option value="0" selected>全部</option>
                                    <{foreach $category as $key => $val}>

                                        <option value="<{$val['ack_id']}>"><{$val['ack_name']}></option>
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
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    // 定义一个新的复制对象
    var clipboard = new ClipboardJS('.copy-button');
    console.log(clipboard);
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        console.log(e);
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
        console.log(e);
        console.log('复制失败');
    });

    $('.edit-info').on('click',function () {
        $('#esmid').val($(this).data('esmid'));
        $('#esid').val($(this).data('esid'));
        $('#mobile').val($(this).data('mobile'));
    });

    $('#confirm-info').on('click',function(){
        var id      = $('#esmid').val();
        var esid     = $('#esid').val();
        var mobile   = $('#mobile').val();
        var password = $('#password').val();
        var data = {
            id     : id,
            esid   : esid,
            mobile   : mobile,
            password : password
        };
        console.log(data);
        if(mobile && password){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeInfo',
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

    $(function () {
        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1
        });

        $('.save-member').on('click',function(){
            var esId = $('#hid_esId').val();
            var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
            if(!mid){
                layer.msg('请选择会员');
                return;
            }

            console.log(esId);
            console.log(mid);
            var data = {
                'id' : esId,
                'mid': mid
            };
            console.log(data);
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeBelong',
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
    function changeStatus(id, status){
        var data = {
            id: id,
            status: status
        };

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/changeStatus',
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
    $('.delete-shop').on('click',function () {
        var id = $(this).data('id');
       layer.confirm('您确定要删除吗？删除后服务商管理员将无法登陆。', {
          btn: ['确定','取消'] //按钮
        }, function(){
           deleteEnterShop(id);
        }, function(){

        });
    });

    $('.hand-close-shop').on('click',function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var msg = '';
        if(type == 1){
            msg = '确定要打烊服务商吗？'
        }else{
            msg = '确定要开启服务商吗？'
        }

        layer.confirm(msg, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                id: id,
                type:type
            };
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/handCloseShop',
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
        }, function(){

        });
    });


    function deleteEnterShop(id) {
        var data = {
            id: id
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/deleteEnterShop',
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

    $('.change-expire').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#now_expire').val($(this).data('expire'));
        $('#expire').val('');
    });

    function pushShop(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/shopPush',
                'data'  : { id:id, type: 'community'},
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
     /*开启或者关闭服务商买单
     */
    function openShop(obj) {
        var id = $(obj).data('id');
        var isbuy = $(obj).data('buy');
        var msg = '';
        if(isbuy){
            msg = '你确定关闭该服务商的买单功能吗？';
        }else{
            msg = '你确定要为该服务商开启买单功能吗?';
        }
        layer.confirm(msg, {
            btn: ['确定','取消'], //按钮
            title : '买单设置'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/openBuy',
                'data'  : { id:id, isbuy:isbuy},
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
                'url'   : '/wxapp/community/changeExpire',
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

    /*设置会员等级*/
    $('#shop-grade').searchableSelect();
    $("#content-con").on('click', 'table td a.set-shopgrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
            console.log(level);
           $('#shop-grade').val(level);
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
        console.log(conTop+"/"+top);
        $(".ui-popover.grade-select").css({'left':left-conLeft-557,'top':top-conTop+48}).stop().show();
    });
    // $(".ui-popover").on('click', function(event) {
    //     event.stopPropagation();
    // });
    /*隐藏设置等级弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
           $(this).remove();
        });
    }
    $("#mainContent").on('click', function(event) {
        optshide();
    });

    $("#content-con").on('click', 'table td a.set-shop-member', function(event) {
        var id = $(this).data('id');
        $('#hid_esId').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.member-select").css({'left':left-conLeft-485,'top':top-conTop+16}).stop().show();
    });

    $(".ui-popover .save-grade").on('click', function(event) {
        var level = $(".ui-popover #shop-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level>0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择服务商等级');
        }

    });

    $(".ui-popover .remove-grade").on('click', function(event) {
        var id    = $('#hid_mid').val();
        if(id>0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : 0
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择服务商等级');
        }

    });

    //重新生成服务商二维码图片
    function reCreateQrcode(){
        var esId = $('#qrcode-goods-id').val();
        console.log(esId);
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/createShopQrcode',
            'data'  : {esId:esId},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                    console.log(ret.url);
                    $(".btn-tuiguang[data-id|='"+esId+"']").attr('data-share',ret.url);
               }
            }
        });
    }
    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var link   = $(this).data('link');
        $('#copyLink').val(link); //详情链接
        console.log(shareImg);
        var esId  = that.data('id');
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(esId);
            $('#download-goods-qrcode').attr('href', '/wxapp/community/downloadShopQrcode?esId='+esId);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-507,'top':top-conTop+90}).stop().show();

    });

    $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
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

    function changeLabel(e) {
        $('#lsid').val($(e).data('id'));
        $(":radio[name='label_type'][value='" + $(e).data('labeltype') + "']").prop("checked", "checked");
    }

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
            'url'   : '/wxapp/car/changeShopLabel',
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

    $('#save-default-maid').on('click',function(){
        var defaultmaid = $('#default-maid').val();    // 默认抽成比例
        if(defaultmaid){
            if(defaultmaid=='<{$maid}>'){
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

</script>
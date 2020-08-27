<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
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
</style>


<{include file="../../manage/common-kind-editor.tpl"}>
<div  id="mainContent" >

<div class="alert alert-block alert-yellow ">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    骑手APP可通过应用宝搜索“51同镇”进行下载。各骑手使用下面账号进行登录
</div>

<div class="page-header">
    <a href="/wxapp/legwork/riderEdit" class="btn btn-green btn-sm"><i class="icon-plus bigger-80"></i> 新增</a>
    <button class="btn btn-green btn-sm" style="padding-top: 5px;padding-bottom: 5px;" data-toggle="modal" data-target="#enterModal"><i class="icon-plus bigger-80"></i>入驻协议</button>
    <a href="/wxapp/legwork/riderExcel" class="btn btn-green btn-sm">导出骑手</a>


</div><!-- /.page-header -->

<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/legwork/riderList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">姓名</div>
                            <input type="text" class="form-control" name="riderName" value="<{$riderName}>"  placeholder="骑手名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">电话</div>
                            <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="骑手电话">
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
                            <th>头像</th>
                            <th>骑手名称</th>
                            <th>登录账号</th>
                            <th>骑手状态</th>
                            <th>工作状态</th>
                            <th>允许派单</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['alr_id']}>">
                                <td>
                                    <{if $val['alr_avatar']}>
                                        <img src="<{$val['alr_avatar']}>" alt="头像" style="width: 50px">
                                    <{elseif $val['m_avatar']}>
                                        <img src="<{$val['m_avatar']}>" alt="头像" style="width: 50px">
                                    <{else}>
                                        <img src="/public/wxapp/images/applet-avatar.png" alt="头像" style="width: 50px">
                                    <{/if}>
                                </td>
                                <td><{$val['alr_name']}></td>
                                <td>
                                    <{if $val['alr_password']}><{$val['alr_mobile']}><{else}>无账号<{/if}>
                                    <p style="margin:0;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-esmid="<{$val['alr_id']}>"  data-mobile="<{$val['alr_mobile']}>" onclick="" data-toggle="modal" data-target="#infoModal">修改账户信息</a>
                                    </p>
                                </td>
                                <td>
                                    <{if $val['alr_status'] == 1}>
                                    <span style="color: red;">已封禁</span>
                                    <{else}>
                                    <span style="color: green;">正常</span>
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['alr_work']}>
                                    <span style="color: green;">工作中</span>
                                    <{else}>
                                    <span style="color: red;">休息</span>
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['alr_admin_send']}>
                                    <span style="color: green;">允许</span>
                                    <{/if}>
                                </td>
                                <td>
                                    <p>
                                        <a href="/wxapp/legwork/riderEdit?id=<{$val['alr_id']}>" >编辑</a>
                                         - <a href="#" class="delete-shop" data-id="<{$val['alr_id']}>" style="color: red">删除</a>
                                        <{if $val['alr_status'] == 1}>
                                        - <a href="#" class="closure-rider" data-id="<{$val['alr_id']}>" data-type="0">解封</a>
                                        <{else}>
                                        - <a href="#" class="closure-rider" data-id="<{$val['alr_id']}>" data-type="1" style="color: red">封禁</a>
                                        <{/if}>
                                    </p>
                                    <p>
                                        <a href="/wxapp/legwork/incomeList?id=<{$val['alr_id']}>" >佣金</a>
                                        - <a href="/wxapp/legwork/goodsfeeList?id=<{$val['alr_id']}>" >垫付费用</a>
                                    </p>
                                    <p>
                                        <a data-target="#orderExcelModal" data-toggle="modal" data-id="<{$val['alr_id']}>" class="order-excel-button">导出订单</a>
                                        <a data-target="#withdrawExcelModal" data-toggle="modal" data-id="<{$val['alr_id']}>" class="withdraw-excel-button">导出提现</a>
                                    </p>
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

<div class="modal fade" id="orderExcelModal" tabindex="-1" role="dialog" aria-labelledby="orderExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="orderExcelLabel">
                    导出记录
                </h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="/wxapp/legwork/excelOrder" method="post">
                    <input type="hidden" name="rider_id" id="rider_id" value="">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">订单状态：</label>
                        <div class="col-sm-8">
                            <select name="excel_status" id="excel_status" class="form-control">
                                <{foreach $link as $key=>$val}>
                                <option value="<{$key}>"><{$val['label']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">下单起始时间：</label>
                        <div class="col-sm-8">
                            <input id="start" name="excel_start" class="form-control" placeholder="请填写起始时间" style="height:auto!important" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" autocomplete="off" />
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">下单截止时间：</label>
                        <div class="col-sm-8">
                            <input id="end" name="excel_end" class="form-control" placeholder="请填写截止时间" style="height:auto!important" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" autocomplete="off" />
                        </div>
                    </div>
                    <!--
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                        <div class="col-sm-3" style="text-align: left">
                            <input type="checkbox" name="mergeOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
                            <label for="goods-order" style="position: relative;top: 2px">同订单合并</label>
                        </div>
                    </div>
                    -->
                    <div style="margin: 0 auto;text-align: center">
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="withdrawExcelModal" tabindex="-1" role="dialog" aria-labelledby="withdrawExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="orderExcelLabel">
                    导出记录
                </h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="/wxapp/legwork/riderWithdrawExcel" method="post">
                    <input type="hidden" name="withdraw_rider_id" id="withdraw_rider_id" value="">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">提现类型：</label>
                        <div class="col-sm-8">
                            <select name="withdraw_type" id="withdraw_type" class="form-control">
                                <option value="0">全部</option>
                                <option value="1">佣金提现</option>
                                <option value="2">垫付费用提现</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">提现状态：</label>
                        <div class="col-sm-8">
                            <select name="withdraw_audit" id="withdraw_audit" class="form-control">
                                <option value="0">全部</option>
                                <option value="1">待审核</option>
                                <option value="2">已通过</option>
                                <option value="3">已拒绝</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">下单起始时间：</label>
                        <div class="col-sm-8">
                            <input id="start" name="withdraw_start" class="form-control" placeholder="请填写起始时间" style="height:auto!important" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" autocomplete="off" />
                        </div>

                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">下单截止时间：</label>
                        <div class="col-sm-8">
                            <input id="end" name="withdraw_end" class="form-control" placeholder="请填写截止时间" style="height:auto!important" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" autocomplete="off" />
                        </div>
                    </div>
                    <!--
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                        <div class="col-sm-3" style="text-align: left">
                            <input type="checkbox" name="mergeOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
                            <label for="goods-order" style="position: relative;top: 2px">同订单合并</label>
                        </div>
                    </div>
                    -->
                    <div style="margin: 0 auto;text-align: center">
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
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
                        <input id="mobile" class="form-control" placeholder="请填写手机号" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码：</label>
                    <div class="col-sm-8">
                        <input id="password" type="password" autocomplete="off" class="form-control" placeholder="请填写密码" style="height:auto!important"/>
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
                    导出骑手
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/excel/communityShopExportExcel" method="post">
                        <div class="form-group lookup-condition">
                            <label class="col-sm-2 control-label" style="text-align: right;width: 150px">骑手类型</label>
                            <div class="col-sm-6">
                                <select id="category" name="category" style="height:34px;width:100%" class="form-control">
                                    <option value="0" selected>全部</option>
                                    <{foreach $categoryData as $key => $val}>
                                    <optgroup label="<{$val['firstName']}>" data-id="<{$val['id']}>">
                                        <{foreach $val['secondItem'] as $key1=>$val1}>
                                        <option value="<{$val1['id']}>"><{$val1['secondName']}></option>
                                        <{/foreach}>
                                    </optgroup>
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
<!-- 模态框（Modal） -->
<div class="modal fade" id="enterModal" tabindex="-1" role="dialog" aria-labelledby="enterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="enterModalLabel">
                    入驻协议
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12" style="padding: 30px">
                        <textarea class="form-control" style="width:100%;height:400px;visibility:hidden;" id = "applyRule" name="applyRule" placeholder="入驻协议"  rows="20" style=" text-align: left; resize:vertical;" >
                              <{if $applyRule}><{$applyRule}><{/if}>
                        </textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="applyRule" />
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="conform-applyrule">
                    保存
                </button>
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
        $('#mobile').val($(this).data('mobile'));
    });

    $('#confirm-info').on('click',function(){
        var id      = $('#esmid').val();
        var mobile   = $('#mobile').val();
        var password = $('#password').val();
        var data = {
            id     : id,
            mobile   : mobile,
            password : password
        };
        if(id && mobile && password){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/legwork/changeInfo',
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
       layer.confirm('您确定要删除吗？删除后骑手将无法登陆。', {
          btn: ['确定','取消'] //按钮
        }, function(){
           deleteEnterShop(id);
        }, function(){

        });
    });

    $('.closure-rider').on('click',function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var msg = '';
        if(type == 0){
            msg = '解除封禁';
        }else{
            msg = '封禁骑手';
        }
        layer.confirm('您确定要'+msg+'吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                id: id,
                type:type
            };
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/legwork/changeRiderStatus',
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

    $('.hand-close-shop').on('click',function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var msg = '';
        if(type == 1){
            msg = '确定要打烊骑手吗？'
        }else{
            msg = '确定要开启骑手吗？'
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
            'url'   : '/wxapp/legwork/riderDelete',
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
     /*开启或者关闭骑手买单
     */
    function openShop(obj) {
        var id = $(obj).data('id');
        var isbuy = $(obj).data('buy');
        var msg = '';
        if(isbuy){
            msg = '你确定关闭该骑手的买单功能吗？';
        }else{
            msg = '你确定要为该骑手开启买单功能吗?';
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
            layer.msg('您尚未选择商家等级');
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
            layer.msg('您尚未选择商家等级');
        }

    });

    //重新生成骑手二维码图片
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

    // 提交入驻协议
    $("#conform-applyrule").click(function(){
        var applyRule = $('#applyRule').val();
        var data = {
            'applyRule'     : applyRule
        };
        var index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            type: 'post',
            url: "/wxapp/legwork/saveApplyRule" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    $('#myModal').modal('hide');
                }
            }
        });
    });

    $('.order-excel-button').click(function () {
        $('#rider_id').val($(this).data('id'));
    });

    $('.withdraw-excel-button').click(function () {
        $('#withdraw_rider_id').val($(this).data('id'));
    });

</script>
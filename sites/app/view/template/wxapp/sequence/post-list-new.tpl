<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/wxapp/hotel/css/emoji.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style>
    .input-group .select2-choice{
        height: 34px;
        line-height: 34px;
        border-radius: 0 4px 4px 0 !important;
    }
    .input-group .select2-container{
        border: none !important;
        padding: 0 !important;
    }

    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: none;
    }
    .zhiding{
        /*margin-left: 15px;
        border: 2px solid #FFEB3B;
        padding: 2px;
        background: #e99d93;*/
    }
    .set-top{
        min-width: 90px;
    }
    .status-td button{
        padding: 1px 2px !important;
    }
    .search-box .form-group{
        margin-bottom: 10px !important;
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
    .tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
</style>
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
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


</style>


<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/sequence/postList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">帖子排序</div>
                            <select name="sortField" class="form-control" >
                                <{foreach $sortArr as $key=>$val}>
                                <option value="<{$key}>" <{if $sort eq $key}> selected <{/if}>><{$val}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">发帖人昵称</div>
                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="发帖人微信昵称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">发帖内容</div>
                            <input type="text" class="form-control" name="content" value="<{$content}>"  placeholder="发帖内容">
                        </div>
                    </div>
                    <div class="form-group" style="width: 400px">
                        <div class="input-group">
                            <div class="input-group-addon" >发帖时间</div>
                            <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                            <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                            <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">帖子类型</div>
                            <select name="post_type" class="form-control" >
                                <option value="0">全部</option>
                                <option value="1" <{if $post_type == 1}> selected <{/if}>>小区精选</option>
                                <option value="2" <{if $post_type == 2}> selected <{/if}>>附近社区</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">筛选</div>
                            <select name="screen" class="form-control" id="screen">
                                <option value="">全部</option>
                                <option value="status0">未封禁</option>
                                <option value="status1">已封禁</option>
                                <option value="top0">未置顶</option>
                                <option value="top1">已置顶</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">小区</div>
                            <select name="search_community" class="form-control my-select2" >
                                <option value="0">全部</option>
                                <{foreach $communitySelectKey as $key=>$val}>
                            <option value="<{$key}>" <{if $search_community eq $key}> selected <{/if}>><{$val['name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">团长</div>
                            <select name="search_leader" class="form-control my-select2" >
                                <option value="0">全部</option>
                                <{foreach $leaderSelectKey as $key=>$val}>
                            <option value="<{$key}>" <{if $search_leader eq $key}> selected <{/if}>><{$val['name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                    <!--
                    <div class="form-group" style="width:580px;">
                        <div class="input-group" style="width:100%;">
                            <div class="start-endtime">
                                <em style="width:70px;text-align:center">发帖时间：</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                                <em style="padding:0 3px;">到</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
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
<div id="content-con">
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <thead>
                        <tr>
                            <th>发帖人头像</th>
                            <th>发帖人</th>
                            <th>帖子类型</th>
                            <th>帖子内容</th>
                            <th>小区</th>
                            <th>所属团长</th>
                            <th>帖子状态</th>
                            <th>是否置顶</th>
                            <th>发帖时间</th>
                            <{if $sort ==2}>
                            <th>最新评论时间</th>
                            <{/if}>
                            <{if $sort ==3}>
                            <th>点赞数量</th>
                            <{/if}>
                            <{if $sort ==4}>
                            <th>回复数量</th>
                            <{/if}>
                            <th>置顶到期时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asp_id']}>" class="tr-content">
                                <td><img src="<{if $val['asp_member_avatar']}> <{$val['asp_member_avatar']}> <{else}>/public/wxapp/images/applet-avatar.png<{/if}>" width="50" style="border-radius:4px;"></td>
                                <td style="max-width: 120px"><{if $val['asp_member_nickname']}>
                                    <a href="/wxapp/sequence/postList?nickname=<{$val['asp_member_nickname']}>">
                                    <{$val['asp_member_nickname']}>
                                    </a>
                                    <{else}><{$curr_shop['s_name']}><{/if}></td>
                                <td>
                                    <{if $val['asp_type'] == 1}>
                                    小区精选
                                    <{elseif $val['asp_type'] == 2}>
                                    附近社区
                                    <{/if}>
                                </td>
                                <td style="max-width: 500px;overflow: hidden"><{$val['asp_content']}></td>
                                <td>
                                    <{if $val['asp_com_id']}>
                                    <a href="/wxapp/sequence/postList?search_community=<{$val['asp_com_id']}>">
                                    <{$communitySelectKey[$val['asp_com_id']]['name']}>
                                    </a>
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['asp_com_leader_id']}>
                                    <a href="/wxapp/sequence/postList?search_leader=<{$val['asp_com_leader_id']}>">
                                        <{$leaderSelectKey[$val['asp_com_leader_id']]['name']}>
                                    </a>
                                    <{/if}>
                                </td>
                                <td class="status-td"><{if $val['asp_status']}>
                                    <span style="color: red">封禁</span>
                                    <!--<br><button class="btn btn-sm btn-success change-post-status" onclick="changePostStatus(<{$val['asp_id']}>,0)">解封</button>-->
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus(<{$val['asp_id']}>,0)" />
                                    <{else}>
                                    <span style="color: green">正常</span>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus(<{$val['asp_id']}>,1)" />
                                    <!--<br><button class="btn btn-sm btn-danger change-post-status" onclick="changePostStatus(<{$val['asp_id']}>,1)">封禁</button>-->
                                    <{/if}>
                                </td>
                                <td  class="set-top" <{if $val['asp_is_top'] > 0 && $val['asp_top_expire']>time()}>style="color: red"<{/if}>>
                                <{if $val['asp_is_top'] > 0 && $val['asp_top_expire']>time()}>是<{else}>
                                	否 
                                	<!--<a data-toggle="modal" data-target="#myTopModal" href="#" data-id="<{$val['asp_id']}>" class="zhiding">置顶</a>-->
                                	<img src="/public/wxapp/images/icon_edit.png" class="good-admend zhiding" data-toggle="modal" data-target="#myTopModal" href="#" data-id="<{$val['asp_id']}>" />
                                <{/if}>
                                </td>
                                <td><{if $val['asp_create_time'] > 0}><{date('Y-m-d H:i',$val['asp_create_time'])}><{/if}></td>
                                <{if $sort ==2}>
                                <td><{if $val['asp_last_comment']}><{date('Y-m-d H:i',$val['asp_last_comment'])}><{/if}></td>
                                <{/if}>
                                <{if $sort ==3}>
                                <td><{if $val}><{$val['asp_like_num']}><{/if}></td>
                                <{/if}>
                                <{if $sort ==4}>
                                <td><{if $val}><{$val['asp_comment_num']}><{/if}></td>
                                <{/if}>
                                <td><{if $val['asp_is_top'] > 0 && $val['asp_top_expire']>time() }><{date('Y-m-d H:i',$val['asp_top_expire'])}><{/if}></td>
                                <td class="jg-line-color">
                                    <p>
                                        <a href="/wxapp/sequence/postDetails/id/<{$val['asp_id']}>">详情</a> -
                                        <a href="#" id="delete-confirm" data-id="<{$val['asp_id']}>" onclick="deletePost('<{$val['asp_id']}>')" style="color: red">删除</a>
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

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改帖子信息
                </h4>
                <input type="hidden" id="post_id" value="">
                <input type="hidden" id="post_cate_old" value="">
                <input type="hidden" id="category_level" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">阅读量：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="post_show" id="post_show" placeholder="请输入增加的数量">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">点赞量：</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="post_like" id="post_like" placeholder="请输入增加的数量">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">分类：</label>
                        <div class="col-sm-6">
                            <select name="first_category" id="first_category" class="form-control">
                                <{foreach $firstCateList as $val}>
                                 <option value="<{$val['id']}>"><{$val['title']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" style="display: none" id="second-box">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">二级分类：</label>
                        <div class="col-sm-6">
                            <select name="second_category" id="second_category" class="form-control">
                                <option value="0">无</option>
                            </select>
                        </div>
                    </div>
                    <!--
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">发帖时间</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="custom_watermark" id="custom_watermark">
                        </div>
                    </div>
                    -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-update">
                        确认修改
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
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



<!-- 模态框（置顶选项） -->
<div class="modal fade" id="myTopModal" tabindex="-1" role="dialog" aria-labelledby="myTopModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myTopModal">
                    置顶帖子
                </h4>
                <input type="hidden" id="pid" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">置顶时间：</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="cost_data">
                                <option value="1">1天</option>
                                <option value="7">7天</option>
                                <option value="15">15天</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="conform-top">
                        确认置顶
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        //$(".form-group-box .form-container").css("width",sumWidth+"px");

        $("#first_category").change(function () {
           var fid = $(this).val();
           secondCategoryShow(fid);
        });

        var screen = '<{$screen}>';
        $("#screen").val(screen);

        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });
    });

    function pushPost(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/postPush',
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

    function secondCategoryShow(fid,secondId) {
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/city/ajaxSecondCategory',
            'data'  : { fid:fid},
            'dataType'  : 'json',
            'success'  : function(ret){
                if(ret.ec == 200){
                    var _html = '';
                    $("#second_category").html("<option value='0'>无</option>");
                    for(var i = 0 ; i < ret.data.length ; i++){
                        _html += "<option value='"+ ret.data[i].id +"'>"+ ret.data[i].title +"</option>"
                    }
                    $("#second_category").append(_html);
                    $("#second-box").css('display','block');
                    if(secondId){
                        $("#second_category").val(secondId);
                    }
                    layer.close(load_index);

                }else{
                    $("#second_category").html("<option value='0'>无</option>");
                    $("#second-box").css('display','none');
                    layer.close(load_index);
                }
            }
        });
    }

    function deletePost(id) {
        //var id = $(this).data('id');
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){

            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/sequence/deletePost',
                'data'  : { id:id},
                'dataType'  : 'json',
                'success'  : function(ret){
                    layer.close(load_index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });

    }

    function updatePost(id,cateId,secondId) {
        $('#post_id').val(id);
        $('#first_category').val(cateId);
        if(secondId){
            secondCategoryShow(cateId,secondId);
        }
    }

    $('#conform-update').on('click',function () {
        var post_id = $('#post_id').val();
        var post_show = $('#post_show').val();
        var post_like = $('#post_like').val();
        var first_cate = $('#first_category').val();
        var second_cate = $('#second_category').val();
        if(post_id && (post_show>0 || post_like>0 || first_cate>0 || second_cate>0)){
            var data = {
                id       : post_id,
                showNum  : post_show,
                likeNum  : post_like,
                first_cate : first_cate,
                second_cate : second_cate

            };
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/city/updatePost',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    })

    //置顶功能
    $('.zhiding').on('click',function(){
        var id = $(this).data('id');
        if(id){
            $('#pid').val(id);
        }
    });
    $('#conform-top').on('click',function(){
        var id   = $('#pid').val();
        var cost = $('#cost_data').val();
        if(id && cost){
            var data = {
                'id'   : id,
                'cost' : cost
            };
            var load_index = layer.load(2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/sequence/updateCostTime',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em,{
                        time:1000
                    },function(){
                        window.location.reload();
                    });
                }
            });
        }
    });

    function changeOpen() {
        var postOpen   = $('#rewardOpen:checked').val();
        var percentage   = $('#percentage').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveShopReward',
            'data'  : { type:2,percentage:percentage,postOpen:postOpen == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
            }
        });
    }
    //更改发帖时候的内容提示
    function changeTip(){
        var tip = $('#post-tip').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/savePostTip',
            'data'  : { tip:tip},
            'dataType'  : 'json',
            'success'   : function(ret){
            }
        });


    }

    function changeMarkOpen() {
        var markOpen   = $('#markOpen:checked').val();
        var mark   = $('#mark').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/saveCityMark',
            'data'  : { mark:mark,markOpen:markOpen == 'on' ? 1 : 0},
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 400){
                    layer.msg(ret.em);
                }
            }
        });
    }

    function changePostStatus(id,status) {
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        var data = {
            pid : id,
            status : status
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/postStatusChange',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    var str = '';
                    if(status == 1){
//                      str =  '<span style="color: red">封禁</span><br><button class="btn btn-sm btn-success change-post-status" onclick="changePostStatus('+id+',0)">解封</button>'
						str =  '<span style="color: red">封禁</span> <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus('+id+',0)" />'
                    }else{
//                      str =  '<span style="color: green">正常</span><br><button class="btn btn-sm btn-danger change-post-status" onclick="changePostStatus('+id+',1)">封禁</button>'
						str =  '<span style="color: green">正常</span> <img src="/public/wxapp/images/icon_edit.png" class="good-admend change-post-status" onclick="changePostStatus('+id+',1)" />'
                    }
                    $('#tr_'+id).find('.status-td').html(str);
                }
                layer.close(load_index);
            }
        });
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/postPreview',
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


</script>

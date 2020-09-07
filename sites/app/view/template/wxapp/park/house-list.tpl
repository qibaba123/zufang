<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
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

     .datepicker{
         z-index: 1060 !important;
     }
    .ui-table-order .time-cell{
        width: 120px !important;
    }
    .form-group{
        margin-bottom: 10px !important;
    }
    .search-box{
        margin: 20px auto 20px;
    }
    .input-group .select2-choice{
        height: 34px;
        line-height: 34px;
        border-radius: 0 4px 4px 0 !important;
    }
    .input-group .select2-container{
        border: none !important;
        padding: 0 !important;
    }
    .zdy-md-xz{
        display: none;
    }

</style>
<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <{include file="../layer/ajax-select-input-single.tpl"}>
        <input type="hidden" id="hid_ahrId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary js-save my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con" >
    <!-- 推广商品弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">房源二维码</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后查看房源信息</p>
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
    <!-- 复制链接弹出框 -->
    <div class="ui-popover ui-popover-link left-center" style="top:100px;">
        <div class="ui-popover-inner">
            <div class="input-group copy-div">
                <input type="text" class="form-control" id="copy" value="" readonly>
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <a href="/wxapp/resources/add" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>

    <!--<a class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;" data-toggle="modal" data-target="#advModal"><i class="icon-plus bigger-80"></i>广告位设置</a>-->
    <a class="add-cost btn btn-primary btn-xs" href="#" data-toggle="modal" data-target="#cfgModal"  data-id="" data-weight="" >发布设置</a>
    <a href="javascript:;" class="btn btn-green btn-xs btn-excel" ><i class="icon-download"></i>房源导出</a>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/resources/index" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">标题</div>
                                <input type="text" class="form-control" name="title" value="<{$title}>" placeholder="商品名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;"><{if $curr_shop['s_id'] eq 12253}>地址<{else}>小区<{/if}></div>
                                <input type="text" class="form-control" name="coumunity" value="<{$coumunity}>" <{if $curr_shop['s_id'] neq 12253}>placeholder="小区名称"<{/if}> >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">推荐</div>
                                <select name="recommend" class="form-control" >
                                    <option value="-1" <{if !$recommend}>selected<{/if}>>全部</option>
                                    <option value="0" <{if $recommend == 0}>selected<{/if}>>未推荐</option>
                                    <option value="1" <{if $recommend == 1}>selected<{/if}>>首页</option>
                                    <option value="2" <{if $recommend == 2}>selected<{/if}>>分类页</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">出售类型</div>
                                <select name="saleType" id="saleType" class="form-control" >
                                    <option value="0" <{if !$saleType}>selected<{/if}>>全部</option>
                                    <option value="1" <{if $saleType == 1}>selected<{/if}>>出售</option>
                                    <option value="2" <{if $saleType == 2}>selected<{/if}>>出租</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">房源类型</div>
                                <select name="resourceSource" id="resourceSource" class="form-control">
                                    <option value="0" <{if !$resourceSource}>selected<{/if}>>全部</option>
                                    <option value="1" <{if $resourceSource == 1}>selected<{/if}>>个人房源</option>
                                    <option value="2" <{if $resourceSource == 2}>selected<{/if}>>中介房源</option>
                                    <{if $curr_shop['s_id'] eq 12253}>
                                    <option value="3" <{if $resourceSource == 3}>selected<{/if}>>闲置资源</option>
                                    <option value="4" <{if $resourceSource == 4}>selected<{/if}>>闲置农房</option>
                                    <option value="5" <{if $resourceSource == 5}>selected<{/if}>>闲置古厝</option>
                                    <{/if}>
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
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>标题</th>
                                <th>出售类型</th>
                                <th>房源类型</th>
                                <th>用户信息</th>
                                <{if $curr_shop['s_id'] eq 12253}>
                                <th>地址</th>
                                <th>图片</th>
                                <th>面积</th>
                                <th>结构</th>
                                <th>建造年份</th>
                                <th>状态</th>
                                <{else}>
                                <th>小区</th>
                                <th>图片</th>
                                <th>面积</th>
                                <th>房型</th>
                                <th>朝向</th>
                                <th>楼层</th>
                                <{/if}>

                                <{if $applet == 51}>
                                <th>查看价格</th>
                                <{/if}>
                                <th>是否置顶</th>
                                <th>置顶到期时间</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ahr_id']}>">
                                <!--<td><{if $val['ahr_status']==1}>首页推荐<{/if}><{if $val['ahr_status']==2}>分类页推荐<{/if}></td>-->
                                <td class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['ahr_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td><{$val['ahr_title']}></td>
                                <td><{if $val['ahr_sale_type']==1}>出售<{else}>出租<{/if}></td>
                                <td><{$houseType[$val['ahr_resource_source']]}></td>
                                <td>
                                    用户编号：<{$val['m_show_id']}><br>
                                    <{$val['m_nickname']}>
                                </td>
                                <{if $curr_shop['s_id'] eq 12253}>
                                <td><{$val['ahr_address']}></td>
                                <{else}>
                                <td><{$val['ahr_community']}></td>
                                <{/if}>
                                <td><img src="<{$val['ahr_cover']}>" alt="" style="width: 100px"/></td>
                                <td><{$val['ahr_area']}>㎡</td>
                                <{if $curr_shop['s_id'] eq 12253}>
                                <td><{$val['ahr_fitment']}></td>
                                <td><{$val['ahr_build_time']}></td>
                                <td><{if $val['ahr_status'] lt 4}><span style="color:green">通过</span><{else}><{if $val['ahr_status'] eq 4}>待审核<{else}><span style="color:red">未通过</span><{/if}><{/if}></td>
                                <{else}>
                                <td><{$val['ahr_home_num']}>室<{$val['ahr_hall_num']}>厅<{$val['ahr_toilet_num']}>卫</td>
                                <td><{$val['ahr_orientation']}></td>
                                <td><{$val['ahr_floor']}>楼/共<{$val['ahr_all_floor']}>层</td>
                                <{/if}>

                                <{if $applet == 51}>
                                <td><{$val['ahr_fee']}></td>
                                <{/if}>
                                <td>
                                    <{if $val['ahr_is_top'] == 1 && $val['ahr_istop_expiration'] > time()}>
                                    <span style="color:green">已置顶</span>
                                    <{else}>
                                    未置顶
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['ahr_istop_expiration']}>
                                    <{date('Y-m-d H:i:s',$val['ahr_istop_expiration'])}>
                                    <{/if}>
                                </td>
                                <td><{date('Y-m-d H:i:s',$val['ahr_create_time'])}></td>
                                <td>
                                    <p>
                                        <a href="/wxapp/resources/add/?id=<{$val['ahr_id']}>" >编辑</a> -
                                        <a class="change-status" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['ahr_id']}>" data-status = "<{$val['ahr_status']}>">设置置顶</a> -
                                        <{if $curr_shop['s_id'] eq 12253}><a class="change-auth-status" href="#" data-toggle="modal" data-target="#statusModal"  data-id="<{$val['ahr_id']}>" data-status = "<{$val['ahr_status']}>">审核</a> -<{/if}>
                                        <a href="javascript:;" class="refresh-time" data-id="<{$val['ahr_id']}>">刷新时间</a>
                                        <{if $applet == 51}>
                                         - <a class="change-price" href="#" data-id="<{$val['ahr_id']}>">查看价格</a>
                                        <a class="change-recommend" href="#" data-toggle="modal" data-target="#recommendModal"  data-id="<{$val['ahr_id']}>" data-status = "<{$val['ahr_recommend']}>">房源标签</a>
                                        <{/if}>
                                    </p>
                                    <p>
                                        <a href="javascript:;" onclick="pushHouse('<{$val['ahr_id']}>')" >推送</a> -
                                        <a href="javascript:;" onclick="showPreview(<{$val['ahr_id']}>)">推送预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=house&id=<{$val['ahr_id']}>" >推送记录</a>
                                    </p>
                                    <p>
                                        <a href="javascript:;" class="btn-tuiguang" data-share="<{$val['ahr_qrcode']}>" data-id="<{$val['ahr_id']}>">房源二维码</a> -
                                        <a href="javascript:;" id="del_<{$val['ahr_id']}>" class="btn-del" data-gid="<{$val['ahr_id']}>">删除</a>
                                         - <a class="set-member" data-id="<{$val['ahr_id']}>" >绑定用户</a>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr>
                                <td colspan="4">
                                    <span class="btn btn-xs btn-name btn-multi-change btn-primary" data-target="#changeModal" data-toggle="modal">批量修改</span>
                                    <span class="btn btn-xs btn-name btn-multi-delete btn-default" >批量删除</span></td>
                                <td colspan="10" style="text-align:right"><{$paginator}></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置房源置顶
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">置顶设置：</label>
                    <div class="col-sm-8">
                        <select name="status" id="status" class="form-control" onchange="statusChange(this)">
                            <option value="0" >不置顶</option>
                            <option value="1" >置顶</option>
                            <{if $applet == 51}>
                            <option value="2" >分类页</option>
                            <{/if}>
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="display: none;" id="recommend-time">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">置顶时长：</label>
                    <div class="col-sm-8">
                        <select name="time" id="time" class="form-control">
                            <{if $costList}>
                            <{foreach $costList as $val}>
                            <option value="<{$val['ahtc_data']}>" ><{$val['ahtc_data']}>天</option>
                            <{/foreach}>
                            <{else}>
                            <option value="1" >1天</option>
                            <option value="7" >7天</option>
                            <option value="15" >15天</option>
                            <option value="30" >30天</option>
                            <{/if}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-status">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="recommendModal" tabindex="-1" role="dialog" aria-labelledby="recommendModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="recommend_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="recommendModalLabel">
                    设置房源标签
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">标签设置：</label>
                    <div class="col-sm-8">
                        <select name="recommend" id="recommend" class="form-control">
                            <option value="0" >无</option>
                            <option value="1" >推荐</option>
                            <option value="2" >热销</option>
                            <option value="3" >火爆</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-recommend">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="advModal" tabindex="-1" role="dialog" aria-labelledby="advModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="advModalLabel">
                    广告位设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-12" style="padding: 20px">
                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="180" data-dom-id="upload-advImg" id="upload-advImg"  src="<{if $tpl && $tpl['ahi_adv_img']}><{$tpl['ahi_adv_img']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_30.png<{/if}>"  width="96%" style="display:inline-block;margin-left:12px;">
                        <input type="hidden" id="advImg"  class="avatar-field bg-img" name="advImg" value="<{if $tpl && $tpl['ahi_adv_img']}><{$tpl['ahi_adv_img']}><{/if}>"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-adv">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- 发布设置 -->
<div class="modal fade" id="cfgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-bottom: 5px;margin-top: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">非会员每日发布数：</label>
                    <div class="col-sm-6">
                        <input type="number" maxlength="4" class="form-control" id="postnum" value="<{$tplCfg['ahi_house_post_num']}>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-cfg">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
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
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    房源导出
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/resources/importResource" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">添加日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入添加日期"/>
                            </div>
                            <label class="col-sm-2 control-label">添加时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker1" name="startTime" placeholder="请输入添加时间"/>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 50px;"></div>
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
                        <div class="space" style="margin-bottom: 50px;"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">房源类型</label>
                            <div class="col-sm-4">
                                <select id="resourceSource" name="resourceSource" class="form-control">
                                    <option value="1">个人房源</option>
                                    <option value="2">中介房源</option>
                                    <{if $curr_shop['s_id'] eq 12253}>
                                    <option value="3">闲置资源</option>
                                    <option value="4">闲置农房</option>
                                    <option value="5">闲置古厝</option>
                                    <{/if}>
                                </select>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 50px;"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">出售类型</label>
                            <div class="col-sm-4">
                                <select id="saleType" name="saleType" class="form-control">
                                    <option value="1">出售</option>
                                    <option value="2">出租</option>
                                </select>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 50px;"></div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="changeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 450px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    批量修改
                </h4>
            </div>
            <div class="modal-body" style="padding: 10px !important;">
                <div class="form-group">
                    <label for="kind2" class="control-label">房源类型：</label>
                    <div class="control-group">
                        <select name="house_source" id="house_source" class="form-control">
                            <option value="0">不修改</option>
                            <option value="1">个人房源</option>
                            <option value="2">中介房源</option>
                            <{if $curr_shop['s_id'] eq 12253}>
                            <option value="3">闲置资源</option>
                            <option value="4">闲置农房</option>
                            <option value="5">闲置古厝</option>
                            <{/if}>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="kind2" class="control-label">联系人：</label>
                    <div class="control-group">
                        <input type="text" value="" class="form-control" id="house_contact" placeholder="不填表示不修改">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kind2" class="control-label">联系电话：</label>
                    <div class="control-group">
                        <input type="text" value="" class="form-control" id="house_mobile" placeholder="不填表示不修改">
                    </div>
                </div>
                <div class="form-group">
                    <label for="kind2" class="control-label">微信：</label>
                    <div class="control-group">
                        <input type="text" value="" class="form-control" id="house_weixin" placeholder="不填表示不修改">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-multi-info">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
<div class="modal-dialog" style="width: 535px;">
    <div class="modal-content">
        <input type="hidden" id="h_id" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title" id="statusModalLabel">
                审核
            </h4>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">状态：</label>
                <div class="col-sm-8">
                    <select name="authstatus" id="authstatus" class="form-control">
                        <option value="1" >通过</option>
                        <option value="2" >拒绝</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消
            </button>
            <button type="button" class="btn btn-primary" id="confirm-auth-status">
                确认
            </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>

<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
    });

    $('.change-status').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#status').val($(this).data('status'));
        if($(this).data('status')==0){
            $('#recommend-time').hide();
        }else{
            $('#recommend-time').show();
        }
    });

    $('.change-auth-status').on('click',function () {
        $('#h_id').val($(this).data('id'));
        $('#authstatus').val($(this).data('status'));
    });
    $('.change-recommend').on('click',function () {
        $('#recommend_id').val($(this).data('id'));
        $('#recommend').val($(this).data('status'));
    });

    function statusChange(e){
        if($(e).val()==0){
            $('#recommend-time').hide();
        }else{
            $('#recommend-time').show();
        }
    }

    $('.change-price').on('click',function(){
        var id = $(this).data('id');
        layer.prompt({title: '输入查看价格，并确认', formType: 0}, function(price, index){
            var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
            if (!reg.test(price)){
                layer.msg('请输入正确金额');
                return false;
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var data = {
                'id'	: id,
                'price': price
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/resources/editPrice',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });
    });

    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
        if(shareImg){
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(id);
            $('#download-goods-qrcode').attr('href', '/wxapp/resources/downloadGoodsQrcode?id='+id);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158-95}).stop().show();
        }
    });

    //重新生成商品二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/resources/createQrcode',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }

    $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', '.code-fenlei .pull-left li', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".code-fenlei .pull-right .text-center").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', function(event) {
        event.stopPropagation();
    });
    $("#content-con").on('click', function(event) {
        optshide();
    });
    /*隐藏弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();

        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
            $(this).remove();
        });
    }

    $('#confirm-status').on('click',function(){
        var id     = $('#hid_id').val();
        var status   = $('#status').val();
        var time = $('#time').val();
        var data = {
            id     : id,
            status   : status,
            time: time
        };
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/resources/changeStatus',
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

    $('#confirm-recommend').on('click',function(){
        var id     = $('#recommend_id').val();
        var status   = $('#recommend').val();
        var data = {
            id     : id,
            status   : status
        };
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/resources/changeRecommend',
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
    $('#confirm-auth-status').on('click',function(){
        var id     = $('#h_id').val();
        var status   = $('#authstatus').val();
        var data = {
            id     : id,
            status   : status
        };
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/resources/changeAuthStatus',
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

    $('#confirm-adv').on('click',function(){
        var adv   = $('#advImg').val();
        var data = {
            adv     : adv
        };
        if(adv){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/house/changeAdv',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                }
            });
        }
    });
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
        optshide();
    } );
    $('.btn-shelf').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){
            var data = {
                'ids' : ids,
                'type' : type
            };
            var url = '/manage/goods/shelf';
            plumAjax(url,data,true);
        }

    });
    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }

            show_modal_content('threeSale',gid);
            $('#modal-info-form').modal('show');
        }else{
            layer.msg('未获取到商品信息');
        }
    });
    $('.setPoint').on('click',function(){
        var gid    = $(this).data('gid');
        var format = $(this).data('format');
        var point  = $(this).data('point');
        var unit   = $(this).data('unit');
        $('#backNum').val($(this).data('num'));
        $('input[name="backUnit"][value="'+unit+'"]').attr("checked",true);
        if(format == 0){
            var html = show_point_setting('赠送积分','sendPoint0',point,gid);
            $('#hid-num').val(1);
            $('#pointContent').html(html);
        }else{ //多规格的，分别处理
            var data = {
                'gid' : gid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/manage/goods/formatToPoint',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        var html = '';
                        for(var i = 0 ; i < ret.data.length ; i ++){
                            var row = ret.data;
                            html += show_point_setting(row[i]['name'],'sendPoint'+i,row[i]['point'],row[i]['id'])
                        }

                        $('#hid-num').val(ret.data.length);
                        $('#pointContent').html(html);
                    }
                }
            });
        }
        $('#hid-format').val(format);
        show_modal_content('setPoint',gid);
        $('#modal-info-form').modal('show');
    });
    function show_point_setting(title,id,val,did){
        var _html = '<div class="form-group">';
        _html += '<div class="input-group">';
        _html += '<div class="input-group-addon input-group-addon-title">'+title+'</div>';
        _html += '<input type="text" class="form-control" id="'+id+'" value="'+val+'" data-id="'+did+'" placeholder="请填写积分">';
        _html += '<div class="input-group-addon">分</div>';
        _html += '</div></div>';
        _html += '<div class="space-4"></div>';
        return _html;
    }
    function show_modal_content(id,gid){
        $('.tab-div').hide();
        $('#'+id).show();
        $('#hid-goods').val(gid);
        var title = '佣金配置设置',type='deduct';
        switch (id){
            case 'threeSale':
                title = '佣金配置设置';
                type  = 'deduct';
                break;
            case 'setPoint':
                title = '商品积分设置';
                type  = 'point';
                break;
        }
        $('#modal-title').text(title);
        $('#hid-type').val(type);
    }
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('gid'),
            'type': 'resources'
        };
        commonDeleteByIdWxapp(data);
    });
    $('.modal-save').on('click',function(){
        var type = $('#hid-type').val();
        switch (type){
            case 'deduct':
                saveRatio();
                break;
            case 'point':
                savePoint();
                break;
        }

    });
    function saveRatio(){
        var gid = $('#hid-goods').val();
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/manage/goods/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }

    function savePoint(){
        var data = {
            'gid'    : $('#hid-goods').val(),
            'format' : $('#hid-format').val(),
            'unit'   : $('input[name="backUnit"]:checked').val(),
            'num'    : parseInt($('#backNum').val())
        };
        if(data.num <= 0){
            layer.msg('请填写返还期数');
            return false;
        }
        if(data.format == 0){
            data.point = $('#sendPoint0').val();
        }else{
            var num    = $('#hid-num').val();
            var point  = {};
            for(var i = 0 ; i < num ; i ++){
                var temp = {
                    'id' : $('#sendPoint'+i).data('id'),
                    'val': $('#sendPoint'+i).val()
                };
                point['point_'+i] = temp;
            }
            data.point = point;
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/manage/goods/savePoint',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    }

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    = '<{$now}>';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }

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

    /*
    保存名片配置
     */
    $('#save-cfg').on('click',function () {
        var loading = layer.load(2);
        //var address = $("input[name='request_addr']:checked").val();
        //var email = $("input[name='request_email']:checked").val();
        var postnum = $("#postnum").val();
        var data = {
            postnum : postnum
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/house/saveCfg',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#cfgModal').modal('hide');
                }
            }
        });
    });

    $('.refresh-time').on('click',function () {
        var loading = layer.load(2);
        var id = $(this).data('id');
        var data = {
            id : id
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/house/refreshTime',
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


    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/housePreview',
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
                    $('#tplPreviewModal').modal('show');
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }

    function pushHouse(id) {
        layer.confirm('确定要推送吗？', {
            btn: ['确定','取消'], //按钮
            title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/resourcePush',
                'data'  : { ahr_id:id},
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

    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

    $("#content-con").on('click', 'table td a.set-member', function(event) {
        var id = $(this).data('id');
        $('#hid_ahrId').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-349,'top':top-conTop-90}).stop().show();
    });

    $('.js-save').on('click',function(){
        var ahrId = $('#hid_ahrId').val();
        var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
        if(!mid){
            layer.msg('请选择用户');
            return;
        }

        var data = {
            'id' : ahrId,
            'mid': mid
        };
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/resources/changeBelong',
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

    $('.btn-multi-delete').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            layer.confirm('确定要删除所选房源？', {
                btn: ['确定','取消'], //按钮
                title : '删除'
            }, function(){
                var data = {
                    'ids' : ids
                };
                var url = '/wxapp/resources/multiDelete';
                plumAjax(url,data,true);
            });
        }else{
            layer.msg('未选择房源');
        }
    });

    $('#change-multi-info').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        var mobile = $('#house_mobile').val();
        var contact = $('#house_contact').val();
        var source = $('#house_source').val();
        var weixin = $('#house_weixin').val();
        if(ids){
            layer.confirm('确定要保存吗？', {
                btn: ['确定','取消'], //按钮
                title : '修改'
            }, function(){
                var data = {
                    'ids' : ids,
                    'mobile' : mobile,
                    'contact': contact,
                    'source':source,
                    'weixin':weixin
                };
                var url = '/wxapp/resources/multiChange';
                plumAjax(url,data,true);
            });
        }else{
            layer.msg('未选择房源');
        }
    });


</script>
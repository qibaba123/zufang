<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
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

    .vip-dialog__viptable td {
        border: 1px solid #e5e5e5;
        border-left: none;
        padding: 5px;
        height: 40px;
    }

    .vip-dialog__viptable .td-discount {
        width: 110px;
        text-align: center;
    }

    .vip-dialog__viptable .mini-input input {
        width: 54px;
        min-width: 0;
        padding: 3px 7px;
    }

    .vip-dialog__viptable .td-discount__unit {
        display: inline-block;
        margin-left: 10px;
    }

    .vip-dialog__viptable_head th{
        text-align: center;
        padding-bottom: 15px;
    }
    .form-container .form-group{
        margin-bottom: 10px;
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
    .set-goodsinfo{
        margin-left:3px;
    }

</style>
<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-goodsinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-goodsinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con" >

<!-- 推广商品弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">商品二维码</span>
                <span>商品链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后直接购买</p>
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
                        <p>商品页链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="pages/goodDetail/goodDetail" readonly>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-white copy_input" id="copygoods" type="button" data-clipboard-target="copyLink" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                            </span>
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
    <a href="/wxapp/sequence/goodsEdit" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <a href="/wxapp/goods/commonGoods" target="_blank" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 从商品库导入</a>
    <{if $import}>
    <a href="<{$import['link']}>" class="btn btn-pink btn-xs"><i class="icon-exchange bigger-80"></i> <{$import['name']}></a>
    <{/if}>

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/sequence/goodsList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="商品名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类目</div>
                                <select id="cate" name="cate" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $category as $key => $val}>
                                    <option <{if $cate eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">排序</div>
                                <select name="sortType" style="height:34px;width:100%" class="form-control">
                                    <option value="updateNew" <{if $sortType eq 'updateNew'}>selected<{/if}>>最近更新</option>
                                    <option value="createNew" <{if $sortType eq 'createNew'}>selected<{/if}>>最近添加</option>
                                    <option value="createOld" <{if $sortType eq 'createOld'}>selected<{/if}>>最早添加</option>
                                </select>
                            </div>
                        </div>
                        <!--
                        <input type="hidden" name="plateform" id="plateform" value="<{$plateform}>">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类别</div>
                                <select id="gtype" name="gtype" style="height:34px;width:100%" class="form-control ">
                                    <option value="0">全部</option>
                                    <{foreach $type as $key => $val}>
                                    <option  <{if $gtype eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <{if $plateform==2}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">所属商家</div>
                                <select id="esId" name="esId" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <{foreach $enterShop as $key => $val}>
                                <option <{if $esId eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <{/if}>
                        <{if $threeSale}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">单品分销</div>
                                <select name="selDeduct" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <option  <{if $selDeduct eq 2}>selected<{/if}> value="2">开启</option>
                                    <option  <{if $selDeduct eq 1}>selected<{/if}> value="1">非开启</option>
                                </select>
                            </div>
                        </div>
                        <{/if}>
                        -->
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>

    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>&plateform=<{$plateform}>" <{if $status eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>商品 价格</th>

                                <th>商品分类</th>
                                <!--
                                <th>店长推荐</th>

                                <{if $plateform==2}>
                                <th>所属商家</th>
                                <{/if}>
                                <th>访问量</th>
                                -->
                                <th>库存</th>
                                <th>商品销量</th>
                                <th>添加时间</th>
                                <th>小区限制</th>
                                <!--
                                <th>排序权重</th>
                                -->
                                <!--
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                -->
                                <!--<{if $threeSale}><th>单品分销</th><{/if}>
                                <{if $openPoint}><th>积分</th><{/if}>-->
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar" style="border: none">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['g_id']}>">
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['g_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td class="proimg-name" style="min-width: 270px;">
                                    <{if isset($val['g_cover'])}>
                                    <img src="<{$val['g_cover']}>" width="75px" height="75px" alt="封面图">
                                    <{/if}>
                                    <div>
                                        <p class="pro-name">
                                            <a href="/wxapp/sequence/goodsEdit/?id=<{$val['g_id']}>" >
                                            <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                            <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                            </a>
                                        </p>

                                        <p class="pro-price">
                                            <{$val['g_price']}>
                                        </p>
                                        <!--
                                        <p>
                                            <{if $val['g_is_top'] eq 1}>
                                            <span class="label label-sm label-success">店长推荐</span>
                                            <{/if}>
                                        </p>
                                        -->
                                    </div>

                                </td>
                                <td><{$category[$val['g_kind2']]}></td>
                                <!--
                                <td><{if $val['g_is_top'] eq 1}>
                                    <span class="label label-sm label-success">店长推荐</span>
                                    <{/if}></td>

                                <{if $plateform==2}>
                                <td><{$val['es_name']}></td>
                                <{/if}>
                                <td id="show_num_<{$val['g_id']}>">
                                    <span><{$val['g_show_num']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_show_num']}>" data-field="show_num">修改</a>
                                </td>
                                -->
                                <td id="stock_<{$val['g_id']}>">
                                    <span><{$val['g_stock']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_stock']}>" data-field="stock">修改</a>
                                </td>
                                <td id="sold_<{$val['g_id']}>">
                                    <span><{$val['g_sold']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_sold']}>" data-field="sold">修改</a>
                                </td>
                                <td><{if $val['g_create_time']}><{date('Y-m-d',$val['g_create_time'])}><{/if}></td>

                                <td>
                                    <{if $val['g_add_bed'] == 1}>
                                    <span style="color: red">限制小区购买</span>
                                    <a href="#" class="btn btn-xs btn-primary change-limit" data-id="<{$val['g_id']}>" data-status="0">解除</a>
                                    <{else}>
                                    <span style="">无限制</span>
                                    <a href="#" class="btn btn-xs btn-danger change-limit" data-id="<{$val['g_id']}>" data-status="1">限制小区</a>
                                    <{/if}>
                                </td>
                                <!--
                                <td><{$val['g_show_num']}></td>
                                <td><{$val['g_stock']}></td>
                                <td><{$val['g_sold']}></td>
                                -->
                                <!--
                                <td><{$val['g_weight']}></td>
                                -->
                                <!--
                                <td><{date('Y-m-d H:i:s',$val['g_update_time'])}></td>
                                -->
                                <!--<{if $threeSale}>
                                <td>
                                    <{if $val['g_is_deduct']}>已开启<{else}>未开启<{/if}>
                                    <a href="javascript:;"
                                       data-gid="<{$val['g_id']}>"
                                       data-ratio_0="<{if isset($deduct[$val['g_id']])}><{$deduct[$val['g_id']]['gd_0f_ratio']}><{/if}>"
                                       data-ratio_1="<{if isset($deduct[$val['g_id']])}><{$deduct[$val['g_id']]['gd_1f_ratio']}><{/if}>"
                                       data-ratio_2="<{if isset($deduct[$val['g_id']])}><{$deduct[$val['g_id']]['gd_2f_ratio']}><{/if}>"
                                       data-ratio_3="<{if isset($deduct[$val['g_id']])}><{$deduct[$val['g_id']]['gd_3f_ratio']}><{/if}>"
                                       data-used="<{if isset($deduct[$val['g_id']])}><{$deduct[$val['g_id']]['gd_is_used']}><{else}>0<{/if}>"
                                       class="fxGoods"> 设置 </a>
                                </td>
                                <{/if}>
                                <{if $openPoint}>
                                <td>
                                    <a href="javascript:;" class="setPoint"
                                       data-gid="<{$val['g_id']}>"
                                       data-format="<{$val['g_has_format']}>"
                                       data-point="<{$val['g_send_point']}>"
                                       data-num="<{$val['g_back_num']}>"
                                       data-unit="<{$val['g_back_unit']}>"
                                            >设置积分</a>
                                </td>
                                <{/if}>
                                <td><{if $val['g_push']}>已推送<{else}><span style="color: red">未推送</span><{/if}></td>
                                -->
                                <td>


                                    <p>
                                        <a href="javascript:;" class="btn-tuiguang" data-link="pages/goodDetail/goodDetail?id=<{$val['g_id']}>" data-share="<{$val['g_qrcode']}>" data-id="<{$val['g_id']}>">商品推广</a>
                                        <!--
                                        <{if $levelList}>
                                        - <a href="javascript:;" onclick="showVipPriceModal(<{$val['g_id']}>, <{$val['g_has_format']}>, <{$val['g_price']}>)">会员价</a>
                                        <{/if}>
                                        <{if $addMember == 1}>
                                        - <a href="/wxapp/goods/commentGoods?id=<{$val['g_id']}>" >评价</a>
                                        <{/if}>
                                        -->
                                    </p>
                                    <p>

                                        <a href="javascript:;" onclick="pushGoods('<{$val['g_id']}>')" >到货通知推送</a>

                                    </p>
                                    <!--
                                    <p>
                                        <a href="javascript:;" onclick="pushGoods('<{$val['g_id']}>')" >推送</a> -
                                        <a href="javascript:;" onclick="showPreview(<{$val['g_id']}>)">推送预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=goods&id=<{$val['g_id']}>" >推送记录</a>
                                    </p>
                                    -->
                                    <p>
                                        <a href="javascript:;" class="btn-import" data-id="<{$val['g_id']}>">导入自有产品库</a> -
                                        <a href="/wxapp/sequence/goodsEdit/?id=<{$val['g_id']}>" >编辑</a> -
                                        <!--<a href="javascript:;" id="link_<{$val['g_id']}>" class="btn-link" data-link="<{$val['link']}>">链接</a> - -->
                                        <a href="javascript:;" id="del_<{$val['g_id']}>" class="btn-del" data-gid="<{$val['g_id']}>"><span style="color: red">删除</span></a>
                                    </p>

                                    <{if $val['g_add_bed'] == 1}>
                                    <p>
                                        <a href="/wxapp/sequence/goodsCommunityEdit?id=<{$val['g_id']}>" >编辑商品小区</a>
                                    </p>
                                    <{/if}>


                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="2">
                                    <{if $status eq 'sell' || $status eq 'sellout'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下架</span>
                                    <{elseif $status eq 'depot'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <{/if}>
                                    <!--
                                    <{if $plateform != 2}>
                                    <span class="btn btn-xs btn-name btn-change-cate btn-primary" >

                                        <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >修改商品分类</a>
                                    </span>
                                    <{/if}>
                                    -->
                                </td><td colspan="9" style="text-align:center"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <{if $threeSale}>
    <div id="modal-info-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:850px;;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger" id="modal-title">佣金配置设置</h4>
                </div>

                <div class="modal-body" style="overflow: hidden;">
                    <input type="hidden" class="form-control" id="hid-goods" value="0">
                    <input type="hidden" class="form-control" id="hid-type" value="deduct">
                    <!--分佣比例设置-->
                    <div id="threeSale" class="tab-div">
                        <div class="alert alert-block alert-yellow">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            若未开启，或者未设置，则按 店铺 佣金配置进行分销!
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div id="home"  class="tab-pane in active">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">购买人返现比例</div>
                                        <input type="text" class="form-control" id="ratio_0" placeholder="返现比例百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">上级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_1" placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <{if $threeSale > 1}>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">二级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_2"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <{/if}>
                                <{if $threeSale > 2}>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">三级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_3"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <{/if}>
                                <div class="input-group col-sm-3">
                                    <div class="input-group-addon"> 是否开启 : &nbsp;</div>
                                    <label class="input-group-addon" id="choose-yesno" style="padding: 4px 10px;margin: 0;border: 1px solid #D5D5D5;">
                                        <input name="used" class="ace ace-switch ace-switch-5" id="used"  type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--积分设置-->
                    <div id="setPoint" class="tab-div">
                        <input type="hidden" class="form-control" id="hid-num" value="1">
                        <input type="hidden" class="form-control" id="hid-format" value="0">
                        <div id="pointContent">

                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">返还期数</div>
                                <input type="text" class="form-control" style="height: 40px;" id="backNum" value="" placeholder="请填写大于0的整数" >
                                <div class="input-group-addon">
                                    <div class="radio-box">
                                        <{foreach $integral as $ikey => $ial}>
                                        <span data-val="<{$ikey}>">
                                            <input type="radio" name="backUnit" value="<{$ikey}>" id="refer<{$ikey}>" >
                                            <label for="refer<{$ikey}>">按<{$ial}></label>
                                        </span>
                                        <{/foreach}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-block alert-yellow">
                            期数为“1”，则购买后立即赠送积分。
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save">保存</button>
                </div>
            </div>
        </div>
    </div>    <!-- MODAL ENDS -->
    <{/if}>
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
                        修改商品分类
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kind2" class="control-label">商品分类：</label>
                        <div class="control-group" id="customCategory">

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
    <div class="modal fade" id="vipPriceModal" tabindex="-1" role="dialog" aria-labelledby="vipPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="overflow: auto; width: 900px">
            <div class="modal-content">
                <input type="hidden" id="vip-price-type" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        自定义会员价
                    </h4>
                </div>
                <div class="modal-body" style="overflow: auto" id="vip-price-edit">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="save-vip-price">
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
</div>    <!-- PAGE CONTENT ENDS -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
    customerGoodsCategory(0);
    function customerGoodsCategory(df){
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/ajaxGoodsCustomCategory',
            'dataType'  : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    customer_category(ret.data,df);
                }
            }
        });
    }
    function customer_category(data,df){
        var html = '<select id="custom_cate" name="custom_cate" class="form-control">';
        for(var i = 0; i < data.length ; i++){
            var son = data[i].secondItem;
            html += '<optgroup label="'+data[i].firstName+'" data-id="'+data[i].id+'">';
            for(var s = 0 ; s < son.length ; s ++){
                var sel = '';
                if(df == son[s].id){
                    sel = 'selected';
                }
                html += '<option value ="'+son[s].id+'" '+sel+'>'+son[s].secondName+'</option>';
            }

            html += '';
            html += '</optgroup>';
        }
        html += '</select>';
        $('#customCategory').html(html);
    }
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
        optshide();
    } );
    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            $('.copy-div input').val(link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
     });
    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
        var link   = $(this).data('link');
        $('#copyLink').val(link); //购买链接
        if(shareImg){
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(id);
            $('#download-goods-qrcode').attr('href', '/wxapp/goods/downloadGoodsQrcode?id='+id);
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

    /*修改商品信息*/
    $("#content-con").on('click', 'table td a.set-goodsinfo', function(event) {
        var id = $(this).data('id');
        var field = $(this).data('field');
        //var value = $(this).data('value');
        var value = $(this).parent().find("span").text();//直接取span标签内数值,防止更新后value不变
        $('#hid_gid').val(id);
        $('#hid_field').val(field);
        $('#currValue').val(value);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-76}).stop().show();
    });

    //重新生成商品二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/createQrcode',
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

    function showVipPriceModal(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/getVipPrice',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                $('#vip-price-type').val(ret.type);
                $html = '';
                $html += '<table><thead class="vip-dialog__viptable_head">';
                $html += '<tr>';
                for(var i in ret.formatName){
                    $html +=  '<th class="sku"><div class="tdwrap1">'+ret.formatName[i]+'</div></th>';
                }
                $html +=  '<th class="sku"><div class="tdwrap1">正常售价</div></th>';
                for(var i in ret.data[0]['vipPrice']){
                    $html += '<th><div class="tdwrap2">'+ret.data[0]['vipPrice'][i]['name']+'</div></th>';
                }
                $html += '</tr></thead>';
                $html += '<tbody class="vip-dialog__viptable">';
                for(var i in ret.data){
                    $html += '<tr>';
                    if(ret.data[i]['name1']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name1']+'</div></td>';
                    }
                    if(ret.data[i]['name2']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name2']+'</div></td>';
                    }
                    if(ret.data[i]['name3']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name3']+'</div></td>';
                    }
                    $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">￥'+ret.data[i]['price']+'</div></td>';
                    for(var n in ret.data[i]['vipPrice']){
                        $html += '<td class=""><div class="td-discount">' +
                            '<div class="zent-number-input-wrapper mini-input" style="display: inline-block">' +
                            '<div class="zent-input-wrapper mini-input">' +
                            '<input type="text" class="form-control vip-price-value" style="display: inline-block" data-id='+ret.data[i]['vipPrice'][n]['id']+' data-lid='+ret.data[i]['vipPrice'][n]['lid']+' value="'+ret.data[i]['vipPrice'][n]['price']+'"></div></div>' +
                            '<span class="td-discount__unit">元</span></div></td>';
                    }
                    $html += '</tr>';
                }
                $html += '</tbody></table>';
                $('#vip-price-edit').html($html);
                $('#vipPriceModal').modal('show');
            }
        });
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/goodsPreview',
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

    $('#save-vip-price').click(function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var type = $('#vip-price-type').val();
        var data = [];
        $('.vip-price-value').each(function(index, element) {
            data[index] = {
                'id' : $(element).data('id'),
                'identity' : $(element).data('lid'),
                'price' : $(element).val(),
            };
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/saveVipPrice',
            'data'  : {data:data, type: type},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#vipPriceModal').modal('hide');
                }
            }
        });
    });

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
    $(".ui-popover-goodsinfo").on('click', function(event) {
        event.stopPropagation();
    });
     $("body").on('click', function(event) {
        optshide();
     });
     /*隐藏弹出框*/
     function optshide(){
         $('.ui-popover').stop().hide();
     }
    $('.btn-shelf').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){
            var data = {
                'ids' : ids,
                'type' : type
            };
            var url = '/wxapp/goods/shelf';
            plumAjax(url,data,true);
        }

    });
    $('#change-cate').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'custom_cate': $('#custom_cate').val()
            };
            var url = '/wxapp/goods/changeCate';
            plumAjax(url,data,true);
        }
    });
    $('.btn-import').on('click',function(){
        var id = $(this).data('id');
        if(id){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/shop2Common',
                'data'  : {id:id},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    layer.close(index);
                }
            });
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
                'url'   : '/wxapp/goods/formatToPoint',
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
            'type': 'goods'
        };
        //commonDeleteById(data);
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
                'url'   : '/wxapp/goods/saveRatio',
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
            'url'   : '/wxapp/goods/savePoint',
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

    function pushGoods(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/goodsGetPush',
                'data'  : { id:id},
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

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<{$now}>';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        //$(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
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

    $(".save-goodsinfo").on('click',function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });

        var id = $('#hid_gid').val();
        var field = $('#hid_field').val();
        var value = $('#currValue').val();

        var data = {
          'id'  :id,
          'field' :field,
          'value':value
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/changeGoodsInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find("span").text(value);
                    //$("#"+field+"_"+id).find("a").attr('data-value',value);
                    layer.close(index);
                }else{
                    layer.msg(ret.em);
                }
            }
        });


    });

    $('.change-limit').on('click',function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var data = {
            id : id,
            status : status
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/changeGoodsLimit',
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

</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style type="text/css">
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        white-space: nowrap;
        min-width: auto;
    }
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

    .zdy-sort:hover{
        color: #00ff00;
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
        width: 14.28%;
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
    .table thead tr th{font-size:12px;}
	.choose-state>a.active{border-bottom-color: #4C8FBD;border-top:0;}
	.tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
	.btn-xs{padding:0 2px!important;}
    select.form-control{
		-webkit-appearance: none;
	}
    .tgl-light+ .tgl-btn{
        border-radius:1.5em;

    }
    .tgl+.tgl-btn{
        width: 3em;
        height: 1.5em;
    }
    .main-container{
        overflow-x: hidden;
    }
    .btn-xs{
        padding: 0 5px!important;
    }
    .new-action a{
        transition: 0.5s;
        color: #9a999e!important;
    }
    .new-action a:hover{
        text-decoration: none!important;
        color: #333!important;
    }
    .new-action a i{
        font-size: 14px;
        margin-right: 5px;
    }
    .tooltip {
        white-space:normal!important;
    }
    .area-link{
        margin-right:8px;
    }
    .text-justify{
        text-align:justify;
        text-align-last:justify;
    }
    .text-justify .justify-span{
        display:inline-block;
        width: 60px;
    }
    #sample-table-1 td{
        border-right: 1px solid #efefef;
    }
    #sample-table-1 td:nth-of-type(1),#sample-table-1 td:nth-of-type(2){
        border-right: none;
    }
    #sample-table-1 thead tr{
        background-color: #e0e0e0;
        background-image: linear-gradient(to bottom, #F8F8F8 0, #e0e0e0 100%);
    }
    #sample-table-1 .pro-name a{
        color: #9a999e;
        transition: 0.5s;
    }
    #sample-table-1 .pro-name a:hover{
        color:#428bca;
    }
    .span{
        color: #9a999e;
    }
    .tr-content td{
        transition: 0.5s;
    }
    .tr-content:hover+ .goods-tool td{
        transition: 0.5s;
        background-color: #fff!important;
    }
    .tools{
        border-left: 1px solid #efefef;
        border-right: 1px solid #efefef;
        padding:12px 10px;
    }

</style>
<{if $seqregion == 1}>
<{include file="../common-second-menu.tpl"}>
<div style="margin-left: 130px">
<{/if}>
<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-goodsinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <input type="hidden" id="hid_table" value="">
        <a class="ui-btn ui-btn-primary save-goodsinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con">
    <div class="ui-popover ui-popover-qrcode left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show" style='padding:20px;'>
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
                    <button class="btn btn-white copy_input" id="copycardid" data-clipboard-target="#copy" style="border-left:0;outline:none;">复制</button>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 汇总信息 -->
    <{if $verify_list != 1}>
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">商品总数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">出售中<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['sale']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已售罄<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['soldout']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已下架<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['nosale']}></span>
            </div>
        </div>
        <{if $area_info==''}>
        <div class="balance-info">
            <div class="balance-title">总销量<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['soldNum']}></span>
            </div>
        </div>
        <{/if}>
        <div class="balance-info">
            <div class="balance-title">总推送次数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['pushTotal']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">总推送人数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['pushMemberSum']}></span>
            </div>
        </div>
    </div>
    <{/if}>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="<{if $verify_list == 1 || $region_id > 0}>/wxapp/seqregion/goodeVerify<{else}>/wxapp/goods/index<{/if}>" method="get" class="form-inline" id="search-form-box">
                <input type="hidden" value="<{$region_id}>" name="region_id">
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
                                <div class="input-group-addon" style="height:34px;">商品品类</div>
                                <select id="cate" name="cate" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <{foreach $category as $key => $val}>
                                    <option <{if $cate eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="plateform" id="plateform" value="<{$plateform}>">
                        <{if $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36}>
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
                        <{/if}>
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
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">排序</div>
                                <select name="sortType" style="height:34px;width:100%" class="form-control">
                                    <option value="sortMax" <{if $sortType eq 'sortMax'}>selected<{/if}>>排序最大</option>
                                    <option value="sortMin" <{if $sortType eq 'sortMin'}>selected<{/if}>>排序最小</option>
                                    <option value="updateNew" <{if $sortType eq 'updateNew'}>selected<{/if}>>最近更新</option>
                                    <option value="createNew" <{if $sortType eq 'createNew'}>selected<{/if}>>最近添加</option>
                                    <option value="createOld" <{if $sortType eq 'createOld'}>selected<{/if}>>最早添加</option>
                                    <option value="stockMax" <{if $sortType eq 'stockMax'}>selected<{/if}>>库存最多</option>
                                    <option value="stockMin" <{if $sortType eq 'stockMin'}>selected<{/if}>>库存最少</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">供应商</div>
                                <select id="supplier" name="supplier" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <{foreach $supplier as $key => $val}>
                                    <option <{if $smarty.get.supplier eq $val.assi_id}>selected<{/if}> value="<{$val.assi_id}>"><{$val.assi_name}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="status" value="<{$status}>">
                        <!--按照权重排序-->
                        <input type="hidden" name="weightSortType" value="<{$weightSortType}>">
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <{if $area_info==''}>
    <div style="margin-bottom: 20px">
        <a href="/wxapp/sequence/goodsEdit" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 新增</a>
        <{if $sequenceShowAll == 1}>
        <a href="/wxapp/goods/allCommonGoods" target="_blank" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 从商品库导入</a>
        <{/if}>
        <!-- <a href="#" data-toggle="modal" data-target="#settingModal" class="btn btn-sm btn-green goods-setting">设置</a> -->
        <a href="/wxapp/configs/config#goodssetting" target="_blank" class="btn btn-sm btn-green goods-setting">补货提醒设置</a>
        <{if $import}>
        <a href="<{$import['link']}>" class="btn btn-sm btn-pink"><i class="icon-exchange bigger-80"></i> <{$import['name']}></a>
        <{/if}>
    </div>
    <{/if}>
    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>&plateform=<{$plateform}>&region_id=<{$region_id}>" <{if $status eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
    </div>
    <div class='tools'>
        <{if $area_info=='' || $verify_list == 0}>
            <!-- 区域管理合伙人隐藏此选项 -->
            <{if $status eq 'sell' || $status eq 'sellout' }>
            <span class="btn btn-xs btn-name btn-shelf btn-danger" data-type="down">下架</span>
            <{elseif $status eq 'depot' || $status eq 'supplier_presell'}>
            <span class="btn btn-xs btn-name btn-shelf btn-success" data-type="up">上架</span>
            <{elseif $status eq 'presell'}>
            <span class="btn btn-xs btn-name btn-shelf btn-success" data-type="up">上架</span>
            <span class="btn btn-xs btn-name btn-shelf btn-danger" data-type="down">下架</span>
            <{/if}>
            <{if $plateform != 2}>
            <span class="btn btn-xs btn-name btn-change-cate btn-info" >

                <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >修改商品分类</a>
            </span>
            <{/if}>
            <{if $levelList}>
            <span class="btn btn-xs btn-name btn-change-cate btn-primary" >

                <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#discountModal" >会员折扣</a>
            </span>
            <{/if}>
            <{if ($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36) && $closePrepare == 0}>
                <{if $status == 'sell'}>
                <span class="btn btn-xs btn-warning shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="down">
                设置自动下架
                </span>
                <{/if}>
                <{if $status == 'depot' || $status == 'sell'}>
                <span class="btn btn-xs btn-success shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell">
                设置预售时间
                </span>
                <{/if}>
                <{if $status == 'presell'}>
                <span class="btn btn-xs btn-success shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell_change">
                修改预售时间
                </span>
                <{/if}>
            <{/if}>
        <{/if}>

        <{if $area_info=='' || $verify_list == 0}>
        <!-- 区域合伙人不能显示批量删除商品的功能-->
        <span class="btn btn-xs btn-name btn-multi-delete btn-default" data-type="down">批量删除</span>
        <{/if}>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead style='border: 1px solid #ddd;'>
                            <tr>
                                <th class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th style="width:40px;">排序</th>
                                <th style='min-width: 270px; width: 350px;'>商品</th>
                                <th>价格</th>
                                <{if $plateform==2}>  <!--说明是商家商品-->
                                <th>所属商家</th>
                                <{/if}>
                                <th>佣金</th>
                                <th>库存</th>
                                <th>供应商</th>
                                <th>发货时间</th>
                                <th>推广设置</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>

                        <{foreach $list as $val}>
                            <!-- 工具栏区域 -->
                            <tr class='goods-tool'>
                                <td colspan="10" style='background-color: #f5f5f5;'>
                                    <div style='color:#9a999e;display: flex;align-items: center;'>
                                        <p class='new-action' style='flex:1;'>
                                            添加时间：<{if $val['g_create_time']}><{date('Y/m/d H:i:s',$val['g_create_time'])}><{/if}>&nbsp;&nbsp;&nbsp;
                                            <a href='/wxapp/goods/goodsBuyRecord?id=<{$val["g_id"]}>' title='购买记录' data-toggle="tooltip" data-tooltip='tooltip'><i class="fa icon-shopping-cart"></i> </a>
                                            <a target="_blank" href='/wxapp/order/commentList?goods_id=<{$val["g_id"]}>' title='查看商品评论' data-toggle="tooltip" data-tooltip='tooltip'><i class="fa icon-comment-alt"></i></a>
                                            <{if $sequenceShowAll == 1}>
                                            <{if $area_info=='' || $verify_list == 0}>
                                                <a href="javascript:;" class="btn-import" data-id="<{$val['g_id']}>" title='加入商品库' data-toggle="tooltip" data-tooltip='tooltip'><i class="fa icon-folder-close-alt "></i></a>
                                            <{/if}>
                                            <{/if}>
                                            <!-- 昨日销量 -->
                                            <a href="javascript:;" id="btn-yesterday-sale-<{$val['g_id']}>" class="btn-yesterday-sale" data-html="true" data-id="<{$val['g_id']}>" data-reload='1' title='' data-toggle="tooltip"><i class="fa icon-calendar-empty"></i></a>
                                            <!-- 商品标签 -->
                                            <span>
                                                <{if $val['g_has_format']}>
                                                <!--<span class="label label-sm label-success">多规格商品</span>-->
                                                <span style="color: #e8ae3a;border: 1px solid rgba(232, 174, 58, 0.5);border-radius: 8px;padding: 0px 8px;">多规格</span>
                                                <{/if}>
                                                <{if $val['g_is_top'] eq 1}>
                                                <!--<span class="label label-sm label-success">店长推荐</span>-->
                                                <span style="color: #82af6f;border: 1px solid rgba(130, 175, 111, 0.5);border-radius: 8px;padding: 0px 8px;">店长推荐</span>
                                                <{/if}>
                                                <{if $levelList && $val['g_join_discount'] == 1}>
                                                <!--<span class="label label-sm label-danger">会员折扣</span>-->
                                                <span style="color: #d15b47;border: 1px solid rgba(209, 91, 71, 0.6);border-radius: 8px;padding: 0px 8px;">会员折扣</span>
                                                <{/if}>
                                            </span>
                                            <{if $val['region_name']}>
                                            <span>
                                                <{if $area_info=='' || $verify_list == 1 || $region_id > 0}>
                                                <span style="color: #c09853;border:1px solid rgba(192, 152, 83, 0.6);border-radius: 8px;padding: 0px 8px;"><{$val['region_name']}></span>
                                                <{else}>
                                                <span style="color: #c09853;border:1px solid rgba(192, 152, 83, 0.6);border-radius: 8px;padding: 0px 8px;">自定义添加商品</span>
                                                <{/if}>
                                            </span>
                                            <span>
                                                <{if $area_info || $val['g_region_add_by'] > 0}>
                                                    <{if $val['g_is_sale'] == 4}>
                                                        <span style="color: #0000FF;border:1px solid rgba(0,0,255, 0.6);border-radius: 8px;padding: 0px 8px;">审核中</span>
                                                    <{elseif $val['g_is_sale'] == 5}>
                                                        <span style="color: #DC143C;border:1px solid rgba(220,20,60, 0.6);border-radius: 8px;padding: 0px 8px;">未通过审核</span>
                                                        <{if $val['g_discuss_info']}>
                                                        <span style="padding-left: 5px;color: red">原因：<{$val['g_discuss_info']}></span>
                                                        <{/if}>
                                                    <{/if}>
                                                <{/if}>
                                            </span>
                                            <{/if}>
                                            <!-- 商品预售 -->
                                            <{if ($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36) &&  ($val['upDate'] || $val['downDate'])}>
                                                <span class='text-danger' style='margin-left:10px;'>商品预售:</span>
                                                <{if $val['upDate']}>
                                                <span class='text-danger' style="padding-right: 8px">上架时间：<{$val['upDate']}></span>
                                                <{/if}>
                                                <{if $val['downDate']}>
                                                <span class='text-danger' style="padding-right: 8px">下架时间：<{$val['downDate']}></span>
                                                <{/if}>
                                            <{/if}>
                                        </p>

                                        <p>
                                        <{if $area_info =='' || ($verify_list == 0 && $area_info =='')}>
                                            <!--非区域合伙人显示的内容  -->
                                            <p  class='area-link'
                                                <{if $val['g_add_bed'] == 1}>
                                                style="display:block;"
                                                <{else}>
                                                style="display:none;"
                                                <{/if}>
                                            >
                                                <a href="/wxapp/sequence/goodsCommunityEdit?id=<{$val['g_id']}>" >设置限购区域</a>
                                            </p>
                                            <span class="tg-list-item">
                                                <input class="tgl tgl-light change-limit" id="change-limit_<{$val['g_id']}>" type="checkbox"  data-id="<{$val['g_id']}>"
                                                    <{if $val['g_add_bed'] == 1}>
                                                        checked
                                                    <{/if}>
                                                >
                                                <label class="tgl-btn" for="change-limit_<{$val['g_id']}>" style="display: inline-block;"></label>
                                                <span class='limit-title' style='margin-left:8px;'>区域限购</span>
                                                <i class="fa icon-question-sign" style='color:#9a999e;' data-toggle="tooltip" data-tooltip='tooltip' data-placement="bottom" title="开启改选项后，需同时设置限购区域,默认商品所有区域不可购买。"></i>
                                            </span>
                                        <{else}>
                                            <!-- 区域合伙人显示的内容 -->
                                            <p  class='area-link' style='margin-right:8px;'
                                                <{if $val['region_limit'] == 1}>
                                                style="display:block;"
                                                <{else}>
                                                style="display:none;"
                                                <{/if}>
                                            >
                                                <a href="/wxapp/sequence/goodsCommunityEdit?id=<{$val['g_id']}>" >设置限购区域</a>
                                            </p>
                                            <span class="tg-list-item">
                                                <input class="tgl tgl-light change-limit" id="change-limit_<{$val['g_id']}>" type="checkbox"  data-id="<{$val['g_id']}>"
                                                    <{if $val['region_limit'] == 1}>
                                                        checked
                                                    <{/if}>
                                                >
                                                <label class="tgl-btn" for="change-limit_<{$val['g_id']}>" style="display: inline-block;"></label>
                                                <span class='limit-title' style='margin-left:8px;'>区域限购</span>
                                                <i class="fa icon-question-sign" style='color:#9a999e;' data-toggle="tooltip" data-tooltip='tooltip' data-placement="bottom" title="开启改选项后，需同时设置限购区域,默认商品所有区域不可购买。"></i>
                                            </span>
                                        <{/if}>
                                        </p>
                                    </div>

                                </td>
                            </tr>
                            <tr id="tr_<{$val['g_id']}>" class="tr-content" style="border-bottom:0">
                                <!-- 选择框 -->
                                <td class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['g_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <!-- 排序 -->
                                <td style="width:40px;">
                                    <span class='span'><{$val['g_weight']}></span>
                                    <{if $area_info=='' || $verify_list == 0}>
                                    <!-- 区域管理合伙人隐藏此选项 -->
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_weight']}>" data-field="weight" />
                                    <{/if}>
                                </td>
                                <!-- 商品 -->
                                <td class="proimg-name" style="min-width: 270px; width: 320px;">
                                    <{if isset($val['g_cover'])}>
                                    <img src="<{$val['g_cover']}>" width="75px" height="75px" alt="封面图" style="border-radius:4px;">
                                    <{/if}>
                                    <div>
                                        <p class="pro-name" style="margin-bottom:6px;">
                                            <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                                            <a
                                                <{if $area_info=='' || $verify_list == 0}>
                                                href="/wxapp/sequence/goodsEdit?id=<{$val['g_id']}>"
                                                <{else}>
                                                href='javascript:;'
                                                <{/if}>
                                            >
                                                <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                                <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                            </a>
                                            <{else}>
                                            <a
                                                <{if $area_info=='' || $verify_list == 0}>
                                                href="/wxapp/goods/newAdd/?id=<{$val['g_id']}>&verify_list=<{$val['verify_list']}>"
                                                <{else}>
                                                href='javascript:;'
                                                <{/if}>
                                            >
                                            <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                            <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                            </a>
                                            <{/if}>
                                        </p>
                                        <{if $category[$val['g_kind2']]}>
                                        <p style='font-weight: bold;color:#666;'>
                                            品类&nbsp;[<span style='color: #9a999e;'><{$category[$val['g_kind2']]}></span>]
                                        </p>
                                        <{/if}>
                                    </div>

                                </td>
                                <!-- 价格 -->
                                <td>
                                    <p  id="cost_<{$val['g_id']}>" class='text-justify'>
                                        <{if $area_info == '' || ($area_info != '' && $val['g_region_add_by'] == $area_manager_id)}>
                                        <span class='justify-span'>成本价：</span>￥<span class='justify-span span'><{$val['g_cost']}></span>

                                        <{/if}>
                                        <input type="hidden" value="<{$area_manager_id}>">
                                        <input type="hidden" value="<{$val['g_region_add_by']}>">
                                        <{if $area_info =='' || $verify_list == 0}>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_cost']}>" data-field="cost" />
                                        <{/if}>
                                    </p>
                                    <p id="ori_price_<{$val['g_id']}>" class='text-justify'>
                                        <span class='justify-span'>原价：</span>￥<span class='justify-span span'><{$val['g_ori_price']}></span>
                                        <{if $area_info =='' || $verify_list == 0}>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_ori_price']}>" data-field="ori_price" />
                                        <{/if}>
                                    </p>
                                    <p id="price_<{$val['g_id']}>" class="pro-price text-justify" style="color: #E97312;font-weight: bold;">
                                        <{if $val['g_is_discuss']}>
                                            面议
                                        <{else}>
                                        <span class='justify-span'>售价：</span>￥<span class='justify-span span'><{$val['g_price']}></span>
                                        <{if $area_info =='' || $verify_list == 0}>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_price']}>" data-field="price" />
                                        <{/if}>
                                        <{/if}>
                                    </p>
                                    <{if $area_info=='' || $verify_list == 0}>
                                    <!-- 区域管理合伙人隐藏此选项 -->
                                    <p>
                                        <a href="javascript:;" onclick="showVipPriceModal(<{$val['g_id']}>, <{$val['g_has_format']}>, <{$val['g_price']}>)">设置会员价</a>
                                    </p>
                                    <{/if}>
                                </td>

                                <{if $plateform==2}>
                                <!--说明是商家商品-->
                                <td><{$val['es_name']}></td>
                                <{/if}>
                                <!-- 佣金 -->
                                <td>
                                    <p id='1f_ratio_<{$val['asgd_id']}>'>
                                        团长佣金：
                                        <span class='span'><{if $val.g_1f_ratio_percent}><{$val.g_1f_ratio_percent}><{else}>0<{/if}></span><i style='color:#9a999e;'>&nbsp;%</i>
                                        <{if $area_info =='' || $verify_list == 0}>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['asgd_id']}>" data-value="<{$val['g_1f_ratio_percent']}>" data-field="1f_ratio" data-table='deduct' />
                                        <{/if}>
                                    </p>
                                    <p>
                                        <span data-toggle="tooltip" data-tooltip='tooltip' data-placement="left" title="仅估算商品中设置的分佣比例">预估佣金：</span>
                                        <span style='color:#9a999e;'>￥<{if $val['g_1f_ratio']}><{$val['g_1f_ratio']}><{else}>0<{/if}></span>
                                    </p>
                                    <{if $sequenceShowAll == 1}>
                                    <{if $area_info =='' || $verify_list == 0}>
                                    <p id='r_1f_ratio_<{$val['asrgd_id']}>'>
                                        区域合伙人佣金：
                                        <span class='span'><{if $val.asrgd_1f_ratio_percent}><{$val.asrgd_1f_ratio_percent}><{else}>0<{/if}></span><i style='color:#9a999e;'>&nbsp;%</i>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['asrgd_id']}>" data-value="<{$val['asrgd_1f_ratio_percent']}>" data-field="1f_ratio" data-table='region' />
                                    </p>
                                    <p>
                                        <span data-toggle="tooltip" data-tooltip='tooltip' data-placement="left" title="仅估算商品中设置的分佣比例">预估佣金：</span>
                                        <span style='color:#9a999e;'>￥<{if $val.asrgd_1f_ratio}><{$val.asrgd_1f_ratio}><{else}>0<{/if}></span>
                                    </p>
                                    <{/if}>
                                    <{/if}>
                                </td>
                                <!-- 库存 -->
                                <td id="stock_<{$val['g_id']}>">
                                    <span class='span'><{$val['g_stock']}></span>
                                    <{if $area_info=='' || $verify_list == 0}>
                                    <!-- 区域管理合伙人隐藏此选项 -->
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_stock']}>" data-field="stock" data-format='<{$val.g_has_format}>' />
                                    <{/if}>
                                </td>

                                <!-- 供应商 -->
                                <td class='text-center'>
                                   <p style='width: 60px;white-space: normal;color: #9a999e;'>
                                    <{if $val['assi_name']}>
                                    <{$val['assi_name']}>
                                    <{else}>
                                    无
                                    <{/if}>
                                   </p>
                                </td>
                                <!-- 配送发货时间 -->
                                <td id="sequence_day_<{$val['g_id']}>">
                                    <span class='span'><{$val.g_sequence_day}></span><span style='color: #9a999e;'>天</span>
                                    <{if $area_info =='' || $verify_list == 0}>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_sequence_day']}>" data-field="sequence_day" />
                                    <{/if}>
                                </td>
                                <!-- 推广设置 商品销量  访问量-->
                                <td >
                                    <p id="sold_<{$val['g_id']}>">
                                        商品销量：<span class='span'><{$val['g_sold']}></span>
                                        <{if $area_info=='' || $verify_list == 0}>
                                        <!-- 区域管理合伙人隐藏此选项 -->
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_sold']}>" data-field="sold" />
                                        <{/if}>
                                    </p>
                                    <p id="show_num_<{$val['g_id']}>">
                                       浏览量： <span class='span'><{$val['g_show_num']}></span>
                                        <{if $area_info=='' || $verify_list == 0}>
                                        <!-- 区域管理合伙人隐藏此选项 -->
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_show_num']}>" data-field="show_num" />
                                        <{/if}>
                                    </p>
                                </td>
                                <!-- 操作 -->
                                <td class='new-action' style="color:#ccc;">
                                    <{if $verify_list == 1}>
                                    <!--
                                    <button class="btn btn-xs btn-success">查看</button>
                                    -->
                                    <button class="btn btn-xs btn-primary confirm-handle" data-id="<{$val['g_id']}>" data-toggle="modal" data-target="#handleModal" >审核</button>
                                    <{elseif $region_id > 0}>
                                    <a class="btn btn-xs btn-primary" href="/wxapp/sequence/goodsEdit/?id=<{$val['g_id']}>&region_id=<{$region_id}>" style="color: #fff !important;">编辑</a>
                                    <{else}>
                                    <p>
                                        <{if $area_info=='' || $verify_list == 0}>
                                        <!-- 区域管理合伙人隐藏此选项 -->
                                        <a href="/wxapp/sequence/goodsEdit/?id=<{$val['g_id']}>" title='编辑' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-edit'></i></a>
                                        <a href="javascript:;" id="del_<{$val['g_id']}>" class="btn-del" data-gid="<{$val['g_id']}>" title='删除' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-trash '></i></a>
                                        <a href="javascript:;" onclick="pushGoodsGet('<{$val['g_id']}>')" title='到货通知推送' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-bell'></i></a>
                                        <{if $addMember == 1}>
                                        <a href="/wxapp/goods/commentGoods?id=<{$val['g_id']}>" title='评价商品' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-comment-alt'></i></a>
                                        <{/if}>
                                        <{if $plateform==2}>
                                        -<a href="/wxapp/goods/shopList/?gid=<{$val['g_id']}>&esId=<{$val['g_es_id']}>"  data-gid="<{$val['g_id']}>" data-toggle="tooltip" data-tooltip='tooltip'>复制</a>
                                        <{/if}>
                                        <{else}>
                                        <{if $val['g_region_add_by']}>
                                        <!-- 社区团购区域管理合伙人自定义添加的商品开放编辑权限 -->
                                        <a href="/wxapp/sequence/goodsEdit/?id=<{$val['g_id']}>" title='编辑'><i class='fa icon-edit'></i></a>
                                        <a href="javascript:;" id="del_<{$val['g_id']}>" class="btn-del" data-gid="<{$val['g_id']}>" title='删除' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-trash '></i></a>
                                        <{/if}>
                                        <{/if}>
                                        <a href="javascript:;" class="btn-qrcode" data-link="<{$goodsPath}>?id=<{$val['g_id']}>" data-share="<{$val['g_qrcode']}>" data-id="<{$val['g_id']}>" title='商品小程序码' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-qrcode'></i></a>
                                        <a href="javascript:;" id="link_<{$val['g_id']}>" class="btn-link" data-link="<{$goodsPath}>?id=<{$val['g_id']}>" title='商品小程序路径' data-toggle="tooltip" data-tooltip='tooltip'><i class='fa icon-link' style='font-size: 15px;'></i></a>
                                    </p>
                                    <{/if}>

                                </td>
                            </tr>
                        <{/foreach}>
                        <!-- 底部菜单与分页处理 -->
                        <tr style="display:none;">
                            <td colspan="3">
                                <{if $area_info=='' || $verify_list == 0}>
                                <!-- 区域管理合伙人隐藏此选项 -->
                                <{if $status eq 'sell' || $status eq 'sellout' }>
                                <span class="btn btn-xs btn-name btn-shelf btn-danger" data-type="down">下架</span>
                                <{elseif $status eq 'depot' || $status eq 'supplier_presell'}>
                                <span class="btn btn-xs btn-name btn-shelf btn-success" data-type="up">上架</span>
                                <{elseif $status eq 'presell'}>
                                <span class="btn btn-xs btn-name btn-shelf btn-success" data-type="up">上架</span>
                                <span class="btn btn-xs btn-name btn-shelf btn-danger" data-type="down">下架</span>
                                <{/if}>
                                <{if $plateform != 2}>
                                <span class="btn btn-xs btn-name btn-change-cate btn-info" >

                                    <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >修改商品分类</a>
                                </span>
                                <{/if}>

                                <{if $levelList}>
                                <span class="btn btn-xs btn-name btn-change-cate btn-primary" >

                                    <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#discountModal" >会员折扣</a>
                                </span>
                                <{/if}>

                                <{if ($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36) && $closePrepare == 0}>

                                <{if $status == 'sell'}>
                                <span class="btn btn-xs btn-warning shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="down">
                                设置自动下架
                                </span>
                                <{/if}>

                                <{if $status == 'depot' || $status == 'sell'}>
                                <span class="btn btn-xs btn-success shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell">
                                设置预售时间
                                </span>
                                <{/if}>

                                <{if $status == 'presell'}>
                                <span class="btn btn-xs btn-success shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell_change">
                                修改预售时间
                                </span>
                                <{/if}>

                                <{/if}>

                                <{/if}>

                                <{if $area_info=='' || $verify_list == 0}>
                                <!-- 区域合伙人不能显示批量删除商品的功能-->
                                <span class="btn btn-xs btn-name btn-multi-delete btn-default" data-type="down">批量删除</span>
                                <{/if}>
                            </td>
                            <td colspan="7" class="text-right"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <div style="height: 53px;margin-top: 15px;">
	    <div class="bottom-opera-fixd">
	        <div class="bottom-opera">
	            <div class="bottom-opera-item" style="padding: 13px 0;<{if $showPage == 0 }>text-align: center;<{/if}>">
	            	<{if $area_info=='' || $verify_list == 0}>
	            		<!-- 区域管理合伙人隐藏此选项 -->
                        <{if $status eq 'sell' || $status eq 'sellout' }>
                        	<a href="#" class="btn btn-blue btn-xs js-recharge-btn btn-shelf" data-type="down">下架</a>
                        <{elseif $status eq 'depot' || $status eq 'supplier_presell'}>
                        	<a href="#" class="btn btn-blue btn-xs js-recharge-btn btn-shelf" data-type="up">上架</a>
                        <{elseif $status eq 'presell'}>
                        	<a href="#" class="btn btn-blue btn-xs js-recharge-btn btn-shelf" data-type="up">上架</a>
                        	<a href="#" class="btn btn-blue btn-xs js-recharge-btn btn-shelf" data-type="down">下架</a>
                        <{/if}>
                    	<{if $plateform != 2}>
                    		<a href="#" class="btn btn-blue btn-xs js-recharge-btn" data-toggle="modal" data-target="#myModal">修改分类</a>
                        <{/if}>
                    	<{if $levelList}>
                    		<a href="#" class="btn btn-blue btn-xs js-recharge-btn" data-toggle="modal" data-target="#discountModal">会员折扣</a>
                        <{/if}>
                        <{if ($appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36) && $closePrepare == 0}>
                        	<{if $status == 'sell'}>
                        		<a href="#" class="btn btn-blue btn-xs js-recharge-btn shelf_auto_button" data-toggle="modal" data-target="#shelfAutoModal" data-type="down">自动下架</a>
                            <{/if}>
                        	<{if $status == 'depot' || $status == 'sell'}>
                        		<a href="#" class="btn btn-blue btn-xs js-recharge-btn shelf_auto_button" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell">预售时间</a>
                            <{/if}>
                        	<{if $status == 'presell'}>
                        		<a href="#" class="btn btn-blue btn-xs js-recharge-btn shelf_auto_button" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell_change">修改预售时间</a>
                            <{/if}>
                        <{/if}>	
	            	<{/if}>
            		<{if $area_info=='' || $verify_list == 0}>
                        <!-- 区域合伙人不能显示批量删除商品的功能-->
                        <a href="#" class="btn btn-blueoutline btn-xs btn-multi-delete" data-toggle="modal" data-type="down" >批量删除</a>
                    <{/if}>
	            </div>
	            <div class="bottom-opera-item" style="text-align: right">
	                <div class="page-part-wrap"><{$paginator}></div>
	            </div>
	        </div>
	    </div>
	</div>
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
    <div class="modal fade" id="shelfAutoModal" tabindex="-1" role="dialog" aria-labelledby="shelfAutoModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;">
            <div class="modal-content">
                <input type="hidden" id="auto_type" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="shelfAutoModalLabel">
                        设置时间
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="up_time_box">
                        <label for="kind2" class="control-label">上架时间：</label>
                        <div class="control-group">
                            <input type="text" class="form-control" name="up_time" value="" placeholder="上架时间" id="up_time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
                        </div>
                    </div>
                    <div class="form-group" id="down_time_box">
                        <label for="kind2" class="control-label">下架时间：</label>
                        <div class="control-group">
                            <input type="text" class="form-control" name="down_time" value="" placeholder="下架时间" id="down_time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="shelf-auto">
                        确认
                    </button>
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
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;">
            <div class="modal-content">
                <input type="hidden" id="hid_id" >
                <input type="hidden" id="now_expire" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="discountModalLabel">
                        是否参与会员价
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kind2" class="control-label">是否参与会员价：</label>
                        <select name="join-discount" id="join-discount" class="form-control">
                            <option value="0">不参与</option>
                            <option value="1">参与</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="change-join-discount">
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
                <div class="modal-body" style="overflow: auto" >
                    <div id="vip-price-edit">

                    </div>
                    <div class="form-group" style="margin-top: 10px">
                        <label class="control-label">是否显示会员价：</label>
                        <div class="control-group" style="display: inline-block;">
                            <label style="padding: 4px 0;margin: 0;">
                                <input name="g_show_vip" class="ace ace-switch ace-switch-5" id="g_show_vip" type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
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
    <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 635px;">
            <div class="modal-content" style="border-radius: 0 !important;">
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

                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">补货提醒：</label>
                    <div class="col-sm-8">
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="goodsAlert" id="alert_yes" value="1" <{if $curr_shop['s_goods_alert_open'] eq 1}>checked<{/if}>>
                                        <label for="alert_yes">开启提醒</label>
                                    </span>
                            <span>
                                        <input type="radio" name="goodsAlert" id="alert_no" value="0" <{if $curr_shop['s_goods_alert_open'] eq 0}>checked<{/if}>>
                                        <label for="alert_no">关闭提醒</label>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">提醒值：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<{$curr_shop['s_goods_alert_value']}>" id="alertValue" style="">
                        <span>当库存达到此数量时将推送提醒</span>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消
        </button>
        <button type="button" class="btn btn-primary" id="confirm-jump">
            确认
        </button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal -->

    <div class="modal fade" id="handleModal" tabindex="-1" role="dialog" aria-labelledby="handleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 535px;">
            <div class="modal-content">
                <input type="hidden" id="hid_handle_id" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="handleModalLabel">
                        申请处理
                    </h4>
                </div>
                <div class="modal-body" style="padding: 10px 15px !important;">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                        <div class="col-sm-10">
                            <select name="handle_status" id="handle_status" class="form-control">
                                <option value="2">通过</option>
                                <option value="3">拒绝</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                        <div class="col-sm-10">
                            <textarea id="handle_remark" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
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

</div>

</div>    <!-- PAGE CONTENT ENDS -->
<{if $seqregion == 1}>
</div>
<{/if}>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">

    // 定义一个新的复制对象
    var clipboard = new ClipboardJS('.copy_input');
    // 复制内容到剪贴板成功后的操作
    clipboard.on( 'success', function(e) {
        layer.msg('复制成功');
        optshide();
    } );


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

    $("#content-con").on('click', 'table td a.btn-qrcode', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
        var link   = $(this).data('link');
        $('#copyLink').val(link); //购买链接
        $('#qrcode-goods-id').val(id);
        if(shareImg){
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
        }else{
            reCreateQrcode();
        }
        
        $('#download-goods-qrcode').attr('href', '/wxapp/goods/downloadGoodsQrcode?id='+id);
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-qrcode").css({'left':left-conLeft-520,'top':top-conTop-158-72}).stop().show();
    });

    /*修改商品信息*/
    $("#content-con").on('click', 'table td .good-admend.set-goodsinfo', function(event) {
        var id = $(this).data('id');
        var field = $(this).data('field');
        if(field=='stock'){
            let format=$(this).data('format');
            if(format){
                layer.msg('多规格商品请进入商品详情页进行库存修改');
                return;
            }
            
        }
        let table=$(this).data('table');
        //var value = $(this).data('value');
        var value = $(this).parent().find(".span").text();//直接取span标签内数值,防止更新后value不变
        $('#hid_gid').val(id);
        $('#hid_field').val(field);
        $('#currValue').val(value);
        $('#hid_table').val(table);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        // 设置位置
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        if(field == 'weight'){
            $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft+3,'top':top-conTop-66}).stop().show();
        }else{
            $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-66}).stop().show();
        }

    });

    //重新生成商品二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var independent = '<{$independent}>';

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/createQrcode',
            'data'  : {id:id,independent:independent},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                layer.close(index);
                if(ret.ec == 200){
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }

    function showVipPriceModal(id) {
        // 先判断是否添加了会员等级
        var levelCount = '<{$levelCount}>';
        if(levelCount<1){
            layer.msg('请先添加会员等级才能使用此功能');
            return false;
        }

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
                if(ret.showVip == 1){
                    $('#g_show_vip').prop("checked", true);
                }else{
                    $('#g_show_vip').prop("checked", false);
                }

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
        var showVip = $('#g_show_vip').is(':checked');
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
            'data'  : {data:data, type: type, showVip: showVip},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                layer.close(index);
                if(ret.ec == 200){
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
    $(".ui-popover-qrcode").on('click', function(event) {
        event.stopPropagation();
    });
    $(".ui-popover-link").on('click', function(event) {
        // event.stopPropagation();
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
        let msg='下架';
        if(type=='up')
            msg='上架';
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){

            layer.confirm('确定要'+msg+'商品？', {
                btn: ['确定','取消'], //按钮
                title : '商品上/下架管理'
            }, function(){
                var data = {
                    'ids' : ids,
                    'type' : type
                };
                var url = '/wxapp/goods/shelf';
                plumAjax(url,data,true);
            });
        }else{
            layer.msg('未选择商品');
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

    $('#change-join-discount').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'join': $('#join-discount').val()
            };
            var url = '/wxapp/goods/changeJoinDiscount';
            plumAjax(url,data,true);
        }
    });

    $('#shelf-auto').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'type': $('#auto_type').val(),
                'up_time' : $('#up_time').val(),
                'down_time' : $('#down_time').val()
            };
            var url = '/wxapp/goods/autoShelf';
            console.log(data);
            plumAjax(url,data,true);
        }else{
            layer.msg('请选择商品');
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
                'url'   : '/wxapp/tplpush/goodsPush',
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
    jQuery(function($) {
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<{$now}>';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        //$(".form-group-box .form-container").css("width",sumWidth+"px");
        // if(lists){
        //     tableFixedInit();//表格初始化
        //     $(window).resize(function(event) {
        //         tableFixedInit();
        //     });
        // }
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });


        //排序权重升序或降序
        $('.zdy-sort').on('click',function(){
            var sort = $(this).data('sort');
            var willSort = sort == "DESC" ? "ASC" : 'DESC';
            $('input[name="weightSortType"]').val(willSort);
            $('#search-form-box').submit();
        });

        $("[data-tooltip='tooltip']").tooltip();

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
       

        var id = $('#hid_gid').val();
        var field = $('#hid_field').val();
        var value = $('#currValue').val();
        let table =$('#hid_table').val();

        var data = {
          'id'  :id,
          'field' :field,
          'value':value
        };
        if(table)
            data['table']=table;
        // 库存修改傻子防护机制
        if(field=='stock'){
             layer.confirm('正在售卖中的商品建议先下架再进行修改，否则会影响库存等信息的统计！！！',{
                btn:['任性修改','考虑一下']
            },function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/goods/changeGoodsInfo',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.msg(ret.em);
                        layer.close(index);
                        if(ret.ec == 200){
                            optshide();
                            field=(table=='region'?'r_'+field:field);
                            $("#"+field+"_"+id).find(".span").text(value);                   
                            if(field == "weight"){
                                window.location.reload();
                            }
                        }
                    }
                });
            });
        }else{
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/changeGoodsInfo',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em);
                    layer.close(index);
                    if(ret.ec == 200){
                        optshide();
                        field=(table=='region'?'r_'+field:field);
                        $("#"+field+"_"+id).find(".span").text(value);                   
                        if(field == "weight"){
                            window.location.reload();
                        }
                    }
                }
            });
        }
      
    });

    function pushGoodsGet(id) {
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

    $('.change-limit').on('click',function () {
        var id = $(this).data('id');
        // var status = $(this).data('status');
        var status = $(this).is(':checked');
        let _this=$(this);
        var data = {
            id : id,
            status : status?1:0
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
                    if(status==1){
                        _this.parent().parent().find('.area-link').show();
                    }else{
                        _this.parent().parent().find('.area-link').hide();
                    }
                }
            }
        });
    });

    $('.shelf_auto_button').on('click',function () {
        var type = $(this).data('type');
        if(type == 'down'){
            $('#up_time_box').hide();
        }else{
            $('#up_time_box').show();
        }
        $('#auto_type').val(type);
        $('#down_time').val('');
        $('#up_time').val('');
    });

    $('#confirm-jump').on('click',function () {
        var goodsAlert = $('input[name=goodsAlert]:checked').val();
        var alertValue = $('#alertValue').val();
        var data = {
            goodsAlert : goodsAlert,
            alertValue : alertValue
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/allGoodsJump',
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

    $('.btn-multi-delete').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            layer.confirm('确定要删除所选商品？', {
                btn: ['确定','取消'], //按钮
                title : '删除'
            }, function(){
                var data = {
                    'ids' : ids
                };
                var url = '/wxapp/goods/multiDelete';
                plumAjax(url,data,true);
            });
        }else{
            layer.msg('未选择商品');
        }
    });


    $('.confirm-handle').on('click',function () {
        $('#hid_handle_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_handle_id').val();
        var remark = $('#handle_remark').val();
        var status = $('#handle_status').val();
        var data = {
            id : hid,
            remark : remark,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/seqregion/handleGoodsVerify',
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

    $('.btn-yesterday-sale').click(function(){
        let gid=$(this).data('id');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/checkGoodsSaleData',
            'data'  : {
                'gid':gid
            },
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec==200){
                    layer.msg('昨日销量:'+ret.data.data);
                }else{
                    layer.msg('暂无数据');
                }
            }
        });
    });
     $('.btn-yesterday-sale').mouseenter(function(){
        let _this=$(this);
        let gid=$(this).data('id');
        let reload=_this.data('reload');
        if(!reload){
            _this.tooltip();
            return;
        }
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/checkGoodsSaleData',
            'data'  : {
                'gid':gid,
                'show_today':1
            },
            'dataType' : 'json',
            success : function(ret){
                _this.data('reload',0);
                _this.attr('title',ret.data.data).tooltip('fixTitle').tooltip('show');;
            }
        });
     });

</script>

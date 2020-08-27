<script>
    //console.log('商铺ID：'+<{$sidddd}>);
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
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
</style>
<{if $appletCfg['ac_type'] == 8 && $menuType == 'toutiao'}>
<{include file="../common-second-menu-new.tpl"}>
<{/if}>
<div  id="content-con" style="margin-left: 120px">

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/goods/verifyGoodsList" method="get" class="form-inline" id="search-form-box">
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
                                <div class="input-group-addon" style="height:34px;">审核状态</div>
                                <select id="status" name="status" style="height:34px;width:100%" class="form-control">
                                    <option value="4" <{if $status == 4}> selected <{/if}>>待审核</option>
                                    <option value="1" <{if $status == 1}> selected <{/if}>>已通过</option>
                                    <option value="5" <{if $status == 5}> selected <{/if}>>已拒绝</option>
                                </select>
                            </div>
                        </div>

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
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
<div style="margin-bottom: 20px">
    <div class="input-group-box" style="display: inline-block;width: 185px;margin-left: 10px;">
        <label class="label-name">商家商品审核：</label>
        <div class="right-info" style="float: right;position: relative;top: -5px;">
            <span class="tg-list-item">
                <input class="tgl tgl-light" id="watermark-open" type="checkbox" onchange="watermarkOpen()" <{if $curr_shop && $curr_shop['s_entershop_goods_verify'] == 1}>checked<{/if}>>
                <label class="tgl-btn" for="watermark-open"></label>
            </span>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-hover table-avatar">
                        <thead>
                            <tr>
                                <th>商品</th>
                                <th>价格</th>
                                <th>所属商家</th>
                                <th>添加时间</th>
                                <th>申请时间</th>
                                <th>审核状态</th>
                                <th>审核备注</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['g_id']}>" class="tr-content">
                                <td class="proimg-name" style="min-width: 270px;">
                                    <{if isset($val['g_cover'])}>
                                    <img src="<{$val['g_cover']}>" width="75px" height="75px" alt="封面图" style="border-radius:4px;">
                                    <{/if}>
                                    <div>
                                        <p class="pro-name" style="margin-bottom:6px;">
                                            <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                                            <a href="/wxapp/sequence/goodsEdit?id=<{$val['g_id']}>" >
                                                <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                                <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                            </a>
                                            <{else}>
                                            <a href="/wxapp/goods/newAdd/?id=<{$val['g_id']}>" >
                                            <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                            <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                            </a>
                                            <{/if}>
                                        </p>
                                    </div>

                                </td>
                                <td>
                                	<p class="pro-price" style="color: #E97312;font-weight: bold;">
                                        <{if $val['g_is_discuss']}>
                                           	面议
                                        <{else}>
                                        <{$val['g_price']}>
                                        <{/if}>
                                    </p>
                                </td>
                                <td><{$val['es_name']}></td>
                                <td><{if $val['g_create_time']}><{date('Y-m-d',$val['g_create_time'])}><{/if}></td>
                                <td>
                                    <{if $val['g_verify_apply_time']}><{date('Y-m-d',$val['g_verify_apply_time'])}><{/if}>
                                </td>
                                <td>
                                    <{if $val['g_is_sale'] == 4}>
                                    <span class="font-color-audit">待审核</span>
                                    <{elseif $val['g_is_sale'] == 5}>
                                    <span class="font-color-refuse">拒绝</span>
                                    <{else}>
                                    <span class="font-color-pass">通过</span>
                                    <{/if}>
                                </td>
                                <td style="max-width: 500px;overflow: hidden"><{$val['g_verify_remark']}></td>
                                <td>
                                    <a href="/wxapp/goods/newAdd?id=<{$val['g_id']}>" >详情</a>
                                    <{if $val['g_is_sale'] == 4}>
                                    <a href="javascript:;" class="handle-apply" data-toggle="modal" data-target="#verifyModal" data-id="<{$val['g_id']}>" >审核</a>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="8" style="text-align:center"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->


    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <input type="hidden" id="hid_goods_id" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="verifyModalLabel">
                        审核商品
                    </h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">审核结果：</label>
                            <div class="col-sm-8">
                                <select name="apply_status" id="apply_status" class="form-control" >
                                    <option value="5">拒绝</option>
                                    <option value="1">通过</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-4"></div>

                        <div class="form-group row ">
                            <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">审核备注：</label>
                            <div class="col-sm-8">
                                <textarea name="remark" id="remark" cols="30" rows="5" class="form-control" style="width: 100%"></textarea>
                            </div>
                        </div>
                        <div class="space-4 "></div>

                        <div class="form-group row" style="<{if !($appletCfg['ac_type'] == 8 && $menuType == 'toutiao')}>display: none;<{/if}>" >
                            <label  for="" style="width: 100%; margin: 0 0 10px 30px;">审核图片（建议尺寸640*640; 最多上传5张;）</label>
                            <div id="slide-img" class="pic-box" style="display:inline-block; margin: 0 0 0 30px;">
                                
                            </div>
                            <div style="margin: 10px 0 0 30px;">
                                <span onclick="toUpload(this)" data-limit="5" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
                                <!-- <span onclick="slideImgs()" class="btn btn-xs btn-info">测试</span> -->
                            </div>
                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-blue save-handle">保存</button>
                </div>
            </div>
        </div>
    </div>

</div>

<{include file="../img-upload-modal.tpl"}>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
    $(function () {
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });

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
    });


    function watermarkOpen() {
        var status = $('#watermark-open').is(':checked');
        var data = {
            status : status ? 1 : 0
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/changeShopGoodsVerify',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(data.status==1){
                        layer.msg('启用成功');
                    }else{
                        layer.msg('关闭成功');
                    }
                }
            }
        });
    }

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


    $('.handle-apply').click(function () {
        let id = $(this).data('id');
        $('#hid_goods_id').val(id);
        $('#slide-img').html('');
        $('#slide-img-num').val(0); 
    });

    $('.save-handle').click(function () {
        let id = $('#hid_goods_id').val();
        let remark = $('#remark').val();
        let status = $('#apply_status').val();
        //let address  = $('#address').val();
        
        var imgs = [];
        var len = $('#slide-img').children().length;
        for(var i=0; i<len; i++) {
            imgs.push($('#slide_'+i).val());
        }
        var imgs_json = JSON.stringify( imgs ); //图片数组的json字符串


        let data = {
            'id' : id,
            'remark' : remark,
            'status' : status,
            'imgs'   : imgs_json,
            //'address'  : address
        };
        console.log(data);

        let index = layer.load(10, {
            shade: [0.6,'#666']
        });

        $.ajax({
            type  : 'post',
            url   : '/wxapp/goods/saveHandleGoods',
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                if(json_ret.ec == 200){
                    layer.msg(json_ret.em, {
                        time: 1500,
                    }, function(){
                        window.location.reload();
                    });
                }else{
                    layer.msg(json_ret.em);
                }
            }
        });
    });




     /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){

        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-es_logo'){
                    $('#es_logo').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p class="slide-p">';
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
                    layer.msg('审核图片最多'+maxNum+'张');
                }
            }
        }
    }

    function slideImgs() {
        var imgs = [];
        var len = $('#slide-img').children().length;
        console.log(len);

        for(var i=0; i<len; i++) {
            imgs.push($('#slide_'+i).val());
        }

        console.log(imgs);

        var imgs_json = JSON.stringify( imgs );
        console.log(imgs_json);
    }
</script>

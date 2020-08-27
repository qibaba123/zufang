<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
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
    #sample-table-1{
        border-right: none;
        border-left: none;
    }
</style>
<div  id="content-con" >
    <!-- 推广商品弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <{if !in_array($menuType,['toutiao','qq'])}>
                <span class="active">商品二维码</span>
                <{/if}>
                <span>商品链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box <{if !in_array($menuType,['toutiao','qq'])}>show<{/if}>">
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
                <div class="link-box <{if in_array($menuType,['toutiao'])}>show<{/if}>">
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
    <a href="/wxapp/reservation/addGood?type=1" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <a href="/wxapp/reservation/goodsCategory?type=1" class="btn btn-primary btn-xs">产品分类</a>
    <{if $import}>
    <a href="<{$import['link']}>" class="btn btn-pink btn-xs"><i class="icon-exchange bigger-80"></i> <{$import['name']}></a>
    <{/if}>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/reservation/goods" method="get" class="form-inline">
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
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $status eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
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
                                <th>产品分类</th>
                                <th>已预约数量</th>
                                <th>剩余名额</th>
                                <th>排序权重</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                <!--<{if $threeSale}><th>单品分销</th><{/if}>
                                <{if $openPoint}><th>积分</th><{/if}>-->
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
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
                                            <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                            <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                        </p>
                                        <p class="pro-price"><{$val['g_price']}></p>
                                    </div>
                                    
                                </td>
                                <td><{$category[$val['g_kind2']]}></td>
                                <td><{$val['g_sold']}></td>
                                <td><{$val['g_stock']}></td>
                                <td><{$val['g_weight']}></td>
                                <td><{date('Y-m-d H:i:s',$val['g_update_time'])}></td>
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
                                <{/if}>-->

                                <td>
                                    <p>
                                        <a href="/wxapp/reservation/addGood/?id=<{$val['g_id']}>&type=1" >编辑</a> -
                                        <{if $levelList}>
                                        <a href="javascript:;" onclick="showVipPriceModal(<{$val['g_id']}>, <{$val['g_has_format']}>, <{$val['g_price']}>)">会员价</a> -
                                        <{/if}>
                                        <{if $addMember == 1}>
                                        <a href="/wxapp/goods/commentGoods?id=<{$val['g_id']}>" >评价</a>
                                        <{/if}>
                                    </p>
                                   <p>
                                       <!--<a href="javascript:;" id="link_<{$val['g_id']}>" class="btn-link" data-link="<{$val['link']}>">链接</a> - -->
                                       <a href="javascript:;" id="del_<{$val['g_id']}>" class="btn-del" data-gid="<{$val['g_id']}>">删除</a>-
                                       <a href="javascript:;" class="btn-tuiguang" data-link="pages/goodDetail/goodDetail?id=<{$val['g_id']}>" data-share="<{$val['g_qrcode']}>" data-id="<{$val['g_id']}>">商品推广</a>
                                   </p>

                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="2">
                                    <{if $status eq 'sell'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下架</span>
                                    <{elseif $status eq 'depot'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <{/if}>
                                </td><td colspan="8" style="text-align:right"><{$paginator}></td></tr>
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
</div>    <!-- PAGE CONTENT ENDS -->

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

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
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
                $html +=  '<th class="sku"><div class="tdwrap1" style="text-align:center">正常售价</div></th>';
                for(var i in ret.data[0]['vipPrice']){
                    $html += '<th><div class="tdwrap2" style="text-align:center">'+ret.data[0]['vipPrice'][i]['name']+'</div></th>';
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

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<{$now}>';
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
</script>
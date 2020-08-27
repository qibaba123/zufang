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
<!-- 商家二维码 -->
<div class="ui-popover ui-popover-tuiguang left-center">
    <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
        <div class="tab-name">
            <span class="active">商家二维码</span>
        </div>
        <div class="tab-main">
            <div class="code-box show">
                <div class="alert alert-orange" style="text-align: center">扫一扫，在手机上查看</div>
                <div class="code-fenlei">
                    <div style="text-align: center;margin: 0 auto">
                        <div class="text-center show" >
                            <input type="hidden" id="qrcode-goods-id"/>
                            <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                            <p>扫码后进入商家</p>
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
    <!--<div class="alert alert-block alert-warning" style="line-height: 20px;">
        商家登录管理地址：<a href="http://www.tiandiantong.com/shop/user/index"> http://www.tiandiantong.com/shop/user/index</a><a href="javascript:;" class="copy-button btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://www.tiandiantong.com/shop/user/index" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>

    </div>-->
    <div class="page-header">
        <a href="javascript:;" class="btn btn-green btn-sm btn-import"><i class="icon-plus bigger-80"></i> 批量复制</a>
    </div><!-- /.page-header -->

    <!--<div class="page-header search-box">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/community/shopList" method="get">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">店铺名称</div>
                                <input type="text" class="form-control" name="shopName" value="<{$shopName}>"  placeholder="店铺名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">负责人</div>
                                <input type="text" class="form-control" name="contact" value="<{$contact}>"  placeholder="店铺负责人">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">电话</div>
                                <input type="text" class="form-control" name="phone" value="<{$phone}>"  placeholder="店铺电话">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>-->
    <div id="content-con">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>店铺名称</th>
                            <th>负责人</th>
                            <th>分类</th>
                            <th>商圈</th>
                            <th>店铺地址</th>
                            <th>到期时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <!--隐藏域存放要复制的商品id-->
                        <input type="hidden" id="gid" value="<{$gid}>">
                        <input type="hidden" id="esId" value="<{$esId}>">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['es_id']}>">
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['es_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td><{$val['es_name']}></td>
                                <td><{$val['es_contact']}></td>
                                <td><span class="cate-span"><{$category[$val['es_cate1']]}></span><span class="cate-span"><{$category[$val['es_cate2']]}></span></td>
                                <td><span class="cate-span"><{$district[$val['es_district2']]['area_name']}></span><span class="cate-span"><{$district[$val['es_district2']]['name']}></span></td>
                                <td><{$val['es_addr']}></td>
                                <td><{if $val['es_expire_time'] > 0}><{date('Y-m-d H:i',$val['es_expire_time'])}><{/if}></td>
                                <td>
                                    <a href="javascript:;" class="btn-import" data-id="<{$val['es_id']}>">复制</a>
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

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script>
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


    $(function () {
        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1
        });


    });

    //将商品导入到某个或多个商家
    $('.btn-import').on('click',function(){
        var id = $(this).data('id');
        var ids = '';   //商家id
        if(id){
            ids = id;
        }else{
            ids  = get_select_all_ids_by_name('ids');
        }
        var gid = $('#gid').val();   //商品id
        var esId = $('#esId').val();  //入驻店铺Id
        if(ids){
            var data = {
                'ids' : ids,
                'gid' :gid,
                'esId' :esId
            };
            console.log(data);
            var url = '/wxapp/goods/copyShopGoods';
            plumAjax(url,data,false);
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
    $(".ui-popover").on('click', function(event) {
        event.stopPropagation();
    });
    /*隐藏设置等级弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
            $(this).remove();
        });
    }
    $(".main-container").on('click', function(event) {
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

    //重新生成店铺二维码图片
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

</script>
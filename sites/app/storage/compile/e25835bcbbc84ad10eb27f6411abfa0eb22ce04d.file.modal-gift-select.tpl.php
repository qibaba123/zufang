<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:41:29
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/modal-gift-select.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11100336195e86a259e5e783-36529313%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e25835bcbbc84ad10eb27f6411abfa0eb22ce04d' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/modal-gift-select.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11100336195e86a259e5e783-36529313',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'goodsName' => 0,
    'appletCfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86a259eaa7c3_46112652',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86a259eaa7c3_46112652')) {function content_5e86a259eaa7c3_46112652($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/ajax-page.css">
<style type="text/css">
    #goods-tr th{
        padding: 5px 0;
    }
    #goods-tr td{
        padding:6px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        /*width: 35px;*/
        height: 35px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 20px;
        line-height: 20px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    #goods-tr td p.g-price{
        color: #FF8C39;
        margin:0;
    }
    .modal-dialog{
        width: 600px;
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    table{
        width: 100%;
    }

    .good-search .input-group{
        width: 85%;
    }
</style>
<!-- 模态框（Modal） -->
<div class="modal fade" id="goodsList" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 15px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="padding: 10px 15px">
                <div class="good-search">
                    <div class="input-group">
                        <input type="text" id="keyword" class="form-control" placeholder="搜索<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?><?php }?>">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchGoodsPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr style="margin: 10px 0 0;">
                <table  class="table table-hover table-responsive" id="goods-tr">

                    <!--商品列表展示-->

                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var currPage=1,keyIndex= 0,modalType='goods';
    //添加赠品
    function addGood(elem){
        var itemElem = $(elem).parents('.product-item');
        keyIndex = itemElem.index();
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择赠品');
        currPage  = 1 ;
        modalType = 'gift';
        fetchGoodsPageData(currPage);
    }

    // 选取积分商品添加
    function confirmAddPointgoods(){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择可使用<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>');
        currPage  = 1 ;
        modalType = 'pointGoods';
        fetchGoodsPageData(currPage);

    }

    function addLimitGood(type = 'limit'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>');
        currPage  = 1 ;
        modalType = 'limit';
        fetchGoodsPageData(currPage);
    }

    function addLimitGoodNew(type = 'limitNew'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>');
        currPage  = 1 ;
        modalType = 'limitNew';
        fetchGoodsPageData(currPage);
    }

    function addStoreGoodsLimit(type = 'storeGoods'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择门店自提商品');
        currPage  = 1 ;
        modalType = 'storeGoods';
        fetchGoodsPageData(currPage);
    }

    function addMealGood(type = 'meal'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>');
        currPage  = 1 ;
        modalType = 'meal';
        fetchGoodsPageData(currPage);
    }
    function addLimitCourse(type = 'limit'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购课程');
        currPage  = 1 ;
        modalType = 'train';
        fetchGoodsPageData(currPage);
    }

    function fetchGoodsPageData(page){
        currPage = page;
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var difValue = dealDif();
        var data = {
            'page'  : page,
            'modalType' : modalType,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : difValue.url,
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(loading);
                if(ret.ec == 200){
                    $('#footer-page').html(ret.pageHtml);
                    if(currPage == 1 && ret.list.length == 0){ //尚未添加<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>或者赠品，则调整提示
                        emptyTips(difValue.key,difValue.skip)
                    }else{ // 类型渲染modal
                        var hasSelect  = getHasSelect();
                        switch (modalType){
                            case 'gift':
                                fetchGiftHtml(ret.list,hasSelect);
                                break;
                            case 'goods':
                                fetchGoodsHtml(ret.list,hasSelect);
                                break;
                            case 'limit':
                                fetchGoodsHtml(ret.list,hasSelect);
                                break;
                            case 'limitNew':
                            case 'storeGoods':
                                fetchGoodsHtml(ret.list,hasSelect);
                                break;
                            case 'pointGoods':
                                fetchGoodsHtml(ret.list,hasSelect);
                                break;
                            case 'train':
                                fetchGoodsHtml(ret.list,hasSelect);
                                break;
                            case 'meal':
                                fetchGoodsHtml(ret.list,hasSelect);
                                break;
                            case 'room':
                                fetchRoomHtml(ret.list,hasSelect);
                                break;
                        }
                    }
                }
            }
        });
    }
    //根据类型，处理不同条件的数据
    function dealDif(){
        var goodsName = '<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>';
        var dif = {
            'skip' : '/wxapp/goods/add',
            'key'  : goodsName,
            'url' : '/wxapp/goods/giftGoods'
        };
        switch (modalType){
            case 'gift':
                dif.url     = '/manage/gift/giftSelect';
                dif.skip    = '/manage/gift/addGift';
                dif.key     = '赠品';
                break;
            case 'goods':
                dif.url     = '/wxapp/goods/giftGoods';
                dif.key     = goodsName;
                dif.skip    = '/wxapp/goods/add';
                break;
            case 'limit':
                dif.url     = '/wxapp/goods/giftGoods';
                dif.key     = goodsName;
                dif.skip    = '/wxapp/goods/add';
                break;
            case 'limitNew':
                dif.url     = '/wxapp/goods/giftGoods';
                dif.key     = goodsName;
                dif.skip    = '/wxapp/goods/add';
                break;
            case 'pointGoods':
                dif.url     = '/wxapp/goods/pointsGoods';
                dif.key     = '积分'+goodsName;
                dif.skip    = '/wxapp/community/pointGoods';
                break;
            case 'train':
                dif.url     = '/wxapp/train/giftGoods';
                dif.key     = '课程';
                dif.skip    = '/wxapp/train/addCourse';
                break;
            case 'meal' :
                dif.url     = '/wxapp/goods/giftGoods';
                dif.key     = '商品';
                dif.skip    = '/wxapp/meal/addGood';
                break;
            case 'storeGoods' :
                dif.url     = '/wxapp/goods/giftGoods';
                dif.key     = '商品';
                dif.skip    = '/wxapp/delivery/editStoreGoods';
                break;
            case 'room':
                dif.url     = '/wxapp/goods/giftGoods';
                dif.key     = goodsName;
                dif.skip    = '/wxapp/goods/add';
                break;

        }
        return dif;
    }
    //为空处理调整
    function emptyTips(key,url){
        layer.confirm('您还没添加'+key+'，现在去添加'+key+'？', {
            btn: ['现在去','暂不去'] //按钮
        }, function(){
            window.location.href = url;
        }, function(){
            layer.msg('没有'+key+'，无法添加活动哦', {icon: 1});
        });
    }

    function getHasSelect(){
        var id = new Array();
        switch (modalType){
            case 'gift':
                var type = $('#type').val();
                var item = $('#max-item').val();
                for(var i=0;i<item;i++){
                    var temp = $('#value_'+type+"_"+i).val();
                    if(temp) id[i] = parseInt(temp);
                }
                break;
            case 'goods':
                var g = 0;
                $('#can-used_goods').find('.good-item').each(function(){
                    var gid = $(this).find('.goods-info').data('gid');
                    if(gid){
                        id[g] = parseInt(gid);
                        g++;
                    }
                });
                break;
            case 'limit':
                var g = 0;
                $('#can-limit-goods').find('.good-item').each(function(){
                    var gid = $(this).find('.goods-info').data('gid');
                    var limit = $(this).find('.goods-limit input').val();
                    var price = $(this).find('.goods-price input').val();
                    if(gid){
                        id[g] = parseInt(gid);
                        g++;
                    }
                });
                break;
            case 'limitNew':
            case 'storeGoods':
                var g = 0;
                $('#can-limit-goods').find('.good-item').each(function(){
                    var gid = $(this).find('.goods-info').data('gid');
                    var limit = $(this).find('.goods-limit input').val();
                    var price = $(this).find('.goods-price input').val();
                    if(gid){
                        id[g] = parseInt(gid);
                        g++;
                    }
                });
                break;
            case 'pointGoods':
                var g = 0;
                $('#can-used_goods').find('.good-item').each(function(){
                    var gid = $(this).find('.goods-info').data('gid');
                    if(gid){
                        id[g] = parseInt(gid);
                        g++;
                    }
                });
                break;
            case 'room':
                var g = 0;
                $('#can-used_goods').find('.good-item').each(function(){
                    var gid = $(this).find('.goods-info').data('gid');
                    if(gid){
                        id[g] = parseInt(gid);
                        g++;
                    }
                });
                break;
        }
        return id;

    }
    /**
     * 商品分页渲染
     */
    function fetchGoodsHtml(data,hasSelect){
        var html = '<thead><tr>';
        html += '<th style="text-align:center">图片</th>';
        html += '<th style="text-align:left"><?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>信息</th>';
        html += '<th style="text-align:center">操作</th>';
        html += '</tr></thead>';
        html += '<tbody >';
        for(var i=0 ; i < data.length ; i++){
            var gid = parseInt(data[i].g_id);
            html += '<tr id="goods_tr_'+gid+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+')</p><p class="g-price">'+data[i].g_price+'<span style="color:#9a999e;">&nbsp;&nbsp;库存:（'+data[i].g_stock+'）</span></p></td>';
            if(hasSelect.indexOf(gid) == -1){
                html += '<td class="button-td"><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].g_id+'" data-name="'+data[i].g_name+'" data-price="'+data[i].g_price+'" data-img="'+data[i].g_cover+'" data-format=\''+data[i].g_format+'\' onclick="dealGoods( this )"> 选取 </a></td>';
            }else{
                html += '<td class="button-td"><a href="javascript:;" class="btn btn-xs btn-default"> 已选取</a></td>';
            }
            html += '</tr>';
        }
        html += '</tbody>';
        $('#goods-tr').html(html);
    }

    /**
     * 商品分页渲染
     */
    function fetchRoomHtml(data,hasSelect){
        var html = '<thead><tr>';
        html += '<th style="text-align:center">图片</th>';
        html += '<th style="text-align:left"><?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>信息</th>';
        html += '<th style="text-align:center">操作</th>';
        html += '</tr></thead>';
        html += '<tbody >';
        for(var i=0 ; i < data.length ; i++){
            var gid = parseInt(data[i].g_id);
            html += '<tr id="goods_tr_'+gid+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+')</p><p class="g-price">'+data[i].g_price+'<span style="color:#9a999e;">&nbsp;&nbsp;</span></p></td>';
            if(hasSelect.indexOf(gid) == -1){
                html += '<td class="button-td"><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].g_id+'" data-name="'+data[i].g_name+'" data-price="'+data[i].g_price+'" data-img="'+data[i].g_cover+'" data-format=\''+data[i].g_format+'\' onclick="dealGoods( this )"> 选取 </a></td>';
            }else{
                html += '<td class="button-td"><a href="javascript:;" class="btn btn-xs btn-default"> 已选取</a></td>';
            }
            html += '</tr>';
        }
        html += '</tbody>';
        $('#goods-tr').html(html);
    }


    /**
     * 赠品分页渲染
     */
    function fetchGiftHtml(data,hasSelect){
        var html = '<thead><tr>';
        html += '<th style="text-align:left">名称</th>';
        html += '<th style="text-align:left">开始时间</th>';
        html += '<th style="text-align:left">结束时间</th>';
        html += '<th>操作</th>';
        html += '</tr></thead>';
        html += '<tbody >';
        for(var i=0 ; i < data.length ; i++){
            var gid = parseInt(data[i].id);
            html += '<tr id="goods_tr_'+data[i].id+'">';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].name+'</p></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].start+'</p></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].end+'</p></td>';
            if(hasSelect.indexOf(gid) == -1){
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].id+'" data-name="'+data[i].name+'" onclick="dealGoods( this )"> 选取 </a></td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-default"> 已选取</a></td>';
            }
            html += '</tr>';
        }
        html += '</tbody>';
        $('#goods-tr').html(html);
    }


    //商品弹窗选择
    /*添加商品html*/
    function get_good_html(id,name){
        var html='<tr class="good-item">';
        html += '<td class="goods-info" data-id="0" data-gid="'+id+'" data-gname="'+name+'"><p>'+name+'</p></td>';
        html += '<td class="right"><span class="del-good">删除</span></td>';
        html += '</tr>';
        return html;
    }
    // 选取商品添加
    function confirmAddgood(){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择可使用<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>');
        currPage  = 1 ;
        modalType = 'goods';
        fetchGoodsPageData(currPage);

       // var name = "请选择<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>";
       // var goodItemHtml

       // var goodList = $(".add-good-box").find('.goodshow-list');
       // goodList.find('.table tbody').append(goodItemHtml);
       // var length = parseInt(goodList.find('.table tr.good-item').length);
       // if(length>0){
       //     goodList.stop().show();
       // }
    }

    // 选取房间添加
    function confirmAddRoom(){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择可使用<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>房间<?php }?>');
        currPage  = 1 ;
        modalType = 'room';
        fetchGoodsPageData(currPage);
    }

    /*添加限时抢购商品html*/
    function get_xianshi_good_html(id,name,price,zero = true){
        var html='<tr class="good-item">';
        html += '<td class="goods-info" data-id="0" data-gid="'+id+'" data-gname="'+name+'" data-gprice="'+price+'"><p><span class="good_name">'+name+'</span><span class="good_price">￥'+price+'</span></p></td>';
        html += '<td><div class="input-group">';
        html += '<span class="input-group-addon">限　购（0表示不限购）</span>';
        html += '<input type="text" class="form-control goods-limit" value="0">';
        html += '<span class="input-group-addon">件</span>';
        html += '</div></td>';
        html += '<td><div class="input-group">';
        html += '<span class="input-group-addon">减价后</span>';
        html += '<input type="text" class="form-control red goods-price">';
        html += '<span class="input-group-addon">元</span>';
        html += '</div></td>';
        html += '<td><div class="input-group">';
        html += '<span class="input-group-addon">共</span>';
        html += '<input type="text" class="form-control red goods-stock">';
        if(zero){
        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=12&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=7&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=4&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=18) {?>
            html += '<span class="input-group-addon">件 （0表示取<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>库存）</span>';
            <?php } else { ?>
            html += '<span class="input-group-addon">件</span>';
            <?php }?>

        }else{
            html += '<span class="input-group-addon">件 </span>';
        }
        html += '</div></td>';
        html += '<td class="right"><span class="del-good">删除</span></td>';
        html += '</tr>';
        return html;
    }

    /*添加限时抢购商品html*/
    function get_xianshi_good_html_new(id,name,price,zero = true, format){
        var html='<tr class="good-item">';
        html += '<td class="goods-info" data-id="0" data-gid="'+id+'" data-gname="'+name+'" data-gprice="'+price+'"><p><span class="good_name">'+name+'</span><span class="good_price">￥'+price+'</span></p></td>';
        html += '<td><div class="input-group">';
        html += '<span class="input-group-addon">限　购（0表示不限购）</span>';
        html += '<input type="text" class="form-control goods-limit" value="0">';
        html += '<span class="input-group-addon">件</span>';
        html += '</div></td>';
        html += '<td><div class="input-group">';
        html += '<span class="input-group-addon">减价后</span>';
        html += '<input type="text" class="form-control red goods-price">';
        html += '<span class="input-group-addon">元</span>';
        html += '</div></td>';
        html += '<td><div class="input-group">';
        html += '<span class="input-group-addon">共</span>';
        html += '<input type="text" class="form-control red goods-stock">';
        if(zero){
            html += '<span class="input-group-addon">件 （0表示取<?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>库存）</span>';
        }else{
            html += '<span class="input-group-addon">件 </span>';
        }
        html += '</div></td>';
        html += '<td><div class="input-group"><span class="input-group-addon">已售</span>';
        html += '<input type="text" class="form-control red goods-sold" value=""><span class="input-group-addon">件</span></div></td>';

        if(acType == 6 || acType == 8){
            html += '<td><div class="input-group"><input type="text" class="form-control red goods-view-num" value="">';
            html += '<span class="input-group-addon"> <label style="margin: 0;width: 40px;height: 20px;"><input name="viewNumShow" class="ace ace-switch ace-switch-5 goods-view-num-show" type="checkbox">';
            html += '<span class="lbl" style="position: relative;top: -7px;left: -10px;"></span></label></span></div></td>';
        }

        html += '<td class="right"><span class="del-good" data-gid="'+id+'">删除</span></td>';
        html += '</tr>';
        for(let i in format){
            html += `<tr class="format-item format${id}">
                        <td class="format-info format-name" data-gfid="${format[i]['id']}" data-name="${format[i]['name']}"><p><span class="format_name">${format[i]['name']}</span><span class="good_price">￥${format[i]['price']}</span></p></td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">减价后</span>
                                <input type="text" class="form-control red format-price" value="0">
                                <span class="input-group-addon">元</span>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon">共</span>
                                <input type="text" class="form-control red format-stock" value="0">.
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=12&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=7&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=4&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=18) {?>
                                <span class="input-group-addon">件（0表示取商品库存）</span>
                                <?php } else { ?>
                                <span class="input-group-addon">件</span>
                                <?php }?>
                            </div>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>`
        }
        return html;
    }


    /*添加门店限制商品html*/
    function get_xianshi_store_good_html(id,name,price,img,zero = true, format){
        var html='<tr class="good-item">';
        html += '<td class="goods-img"><img src="'+img+'" alt="" style="width: 50px;margin: 0"></td>';
        html += '<td class="goods-info" data-id="0" data-gid="'+id+'" data-gname="'+name+'" data-gprice="'+price+'"><p><span class="good_name">'+name+'</span></p></td>';
        html += '<td>'+ price +'</td>';
        html += '<td class="right"><span class="del-good"  onclick="deleteGoods(this)" data-gid="'+id+'">删除</span></td>';
        html += '</tr>';
        return html;
    }


    /*添加商品在include的文件中*/
    function dealGoods(ele){
        var id    = $(ele).data('id');
        var name  = $(ele).data('name');
        var price = $(ele).data('price');
        var format= $(ele).data('format');
        var html  = '';
        switch (modalType){
            case 'gift':
                html = $('#full-present').find('.product-item').eq(keyIndex);
                html.find('.good-name').text(name);
                html.find('.goods-id').val(id);
                break;
            case 'goods':
                html  = get_good_html(id,name);
                $('#can-used_goods').append(html);
                break;
            case 'limit':
                html  = get_xianshi_good_html(id,name,price);
                $('#can-limit-goods').append(html);
                break;
            case 'limitNew':
                html  = get_xianshi_good_html_new(id,name,price, true,format);
                $('#can-limit-goods').append(html);
                break;
            case 'pointGoods':
                html  = get_good_html(id,name);
                $('#can-used_goods').append(html);
                break;
            case 'train':
                html  = get_xianshi_good_html(id,name,price,false);
                $('#can-limit-goods').append(html);
                break;
            case 'storeGoods':
                var img = $(ele).data('img');
                html  = get_xianshi_store_good_html(id,name,price,img, true,format);
                $('#can-limit-goods').append(html);
                break;
            case 'room':
                html  = get_good_html(id,name);
                $('#can-used_goods').append(html);
                break;

        }
        if(modalType != 'goods' && modalType != 'storeGoods' && modalType != 'room'){
            $('#goodsList').modal('hide');
        }else{
            var change_html = '<td class="button-td"><a href="javascript:;" class="btn btn-xs btn-default"> 已选取</a></td>';
            $(ele).parent().html(change_html);
        }

    }

</script><?php }} ?>

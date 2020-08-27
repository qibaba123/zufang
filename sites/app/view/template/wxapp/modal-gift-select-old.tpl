<link rel="stylesheet" href="/public/manage/ajax-page.css">
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
                        <input type="text" id="keyword" class="form-control" placeholder="搜索<{if $goodsName}><{$goodsName}><{else}><{if $goodsName}><{$goodsName}><{else}>商品<{/if}><{/if}>">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchGoodsPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr style="margin: 10px 0 0;">
                <table  class="table-responsive" id="goods-tr">

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
        $('.modal-title').text('选择可使用<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>');
        currPage  = 1 ;
        modalType = 'pointGoods';
        fetchGoodsPageData(currPage);

    }

    function addLimitGood(type = 'limit'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>');
        currPage  = 1 ;
        modalType = 'limit';
        fetchGoodsPageData(currPage);
    }

    function addLimitGoodNew(type = 'limitNew'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>');
        currPage  = 1 ;
        modalType = 'limitNew';
        fetchGoodsPageData(currPage);
    }

    function addMealGood(type = 'meal'){
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('.modal-title').text('选择限时抢购<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>');
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
        var data = {
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        var difValue = dealDif();
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
                    if(currPage == 1 && ret.list.length == 0){ //尚未添加<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>或者赠品，则调整提示
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
                        }
                    }
                }
            }
        });
    }
    //根据类型，处理不同条件的数据
    function dealDif(){
        var goodsName = '<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>';
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
        }
        return id;

    }
    /**
     * 商品分页渲染
     */
    function fetchGoodsHtml(data,hasSelect){
        var html = '<thead><tr>';
        html += '<th style="text-align:center">图片</th>';
        html += '<th style="text-align:left"><{if $goodsName}><{$goodsName}><{else}>商品<{/if}>信息</th>';
        html += '<th style="text-align:center">操作</th>';
        html += '</tr></thead>';
        html += '<tbody >';
        for(var i=0 ; i < data.length ; i++){
            var gid = parseInt(data[i].g_id);
            html += '<tr id="goods_tr_'+gid+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p><p class="g-price">'+data[i].g_price+'</p></td>';
            if(hasSelect.indexOf(gid) == -1){
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].g_id+'" data-name="'+data[i].g_name+'" data-price="'+data[i].g_price+'" data-format=\''+data[i].g_format+'\' onclick="dealGoods( this )"> 选取 </a></td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-default"> 已选取</a></td>';
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
        $('.modal-title').text('选择可使用<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>');
        currPage  = 1 ;
        modalType = 'goods';
        fetchGoodsPageData(currPage);

//        var name = "请选择<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>";
//        var goodItemHtml
//
//        var goodList = $(".add-good-box").find('.goodshow-list');
//        goodList.find('.table tbody').append(goodItemHtml);
//        var length = parseInt(goodList.find('.table tr.good-item').length);
//        if(length>0){
//            goodList.stop().show();
//        }
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
            html += '<span class="input-group-addon">件 （0表示取<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>库存）</span>';
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
            html += '<span class="input-group-addon">件 （0表示取<{if $goodsName}><{$goodsName}><{else}>商品<{/if}>库存）</span>';
        }else{
            html += '<span class="input-group-addon">件 </span>';
        }
        html += '</div></td>';
        html += '<td><div class="input-group"><span class="input-group-addon">已售</span>';
        html += '<input type="text" class="form-control red goods-sold" value=""><span class="input-group-addon">件</span></div></td>';
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
                                <input type="text" class="form-control red format-stock" value="0">
                                <span class="input-group-addon">件（0表示取商品库存）</span>
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

        }
        $('#goodsList').modal('hide');
    }

</script>
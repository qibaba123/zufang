<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    .add-gift{
        padding-top: 10px;
    }
    .info-title{
        padding:10px 0;
        border-bottom: 1px solid #eee;
    }
    .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .input-table{
        width: 100%;
    }
    .input-table td{
        padding:8px 10px;
        vertical-align: middle;
    }
    .input-table td.label-td{
        padding-right: 0;
        width: 130px;
        text-align: right;
        vertical-align: top;
    }
    .input-table label{
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        width: 130px;
        line-height: 34px;
    }
    .input-table .form-control{
        width: 290px;
        height: 34px;
    }
    .Wdate{
        border-color: #ccc;
    }
    .input-table textarea.form-control{
        width: 100%;
        max-width: 750px;
        height: auto;
    }
    .input-table .form-control.spinner-input{
        width: 55px;
        border-color: #dfdfdf;
    }
    .Wdate{
        background-position: 98% center;
    }
    .full-minus-item,.product-item{
        padding: 10px;
        position: relative;
        border: 1px solid #e8e8e8;
        -webkit-border-radius: 4px;
        -ms-border-radius: 4px;
        border-radius: 4px;
        overflow: hidden;
        max-width: 750px;
        padding-right: 45px;
        margin-bottom: 10px;
        min-width: 650px;
    }
    .delete{
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .2;
        filter: alpha(opacity=20);
        position: absolute;
        top: 14px;
        right: 10px;
    }
    .delete:hover{
        opacity: .6;
        filter: alpha(opacity=60);
    }

    .item-wrap{
        font-size: 0;
    }
    .full-minus-item .item-wrap b,.product-item .item-wrap b{
        margin:0 5px;
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
    }
    .full-minus-item .item-wrap span,.product-item .item-wrap span,.product-item .item-wrap div{
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
    }
    .full-minus-item .item-wrap span input,.product-item .item-wrap span input{
        width: 150px;
        font-size: 14px;
    }
    .product-item .item-wrap .good-name-box{
        text-align: left;
        width: 50%;
    }
    .product-item .item-wrap .good-name-box .good-name{
        margin:0;
        padding: 0 5px;
        font-size: 14px;
        width: 95%;
        margin-left: 5px;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .modal-body .table-responsive{
        width: 100%;
    }

    /*选择全部或指定商品*/
    .choose-goodrange{
        padding-top: 5px;
    }
    .choosegoods{
        padding: 5px 0;
    }
    .choosegoods .tip{
        font-size: 12px;
        color: #999;
        margin:0;
    }
    .choosegoods>div{
        display: none;
    }
    .add-good-box .btn{
        margin-top: 10px;
    }
    .add-good-box .table{
        max-width: 1150px;
        margin: 10px 0 0;
    }
    .add-good-box .table thead tr th{
        border-right: 0;
        padding: 8px 10px;
        vertical-align: middle;
    }
    .add-good-box .table tbody tr td{
        padding: 6px 10px;
        vertical-align: middle;
        white-space: normal;
    }
    .left{
        text-align: left;
    }
    .center{
        text-align: center;
    }
    .right{
        text-align: right;
    }
    td.goods-info p{
        height: 20px;
        line-height: 20px;
        margin:0;
    }
    td.goods-info p span{
        display: inline-block;
        vertical-align: middle;
    }
    td.goods-info p span.good_name{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 220px;
        margin-right: 3px;
    }
    td.goods-info p span.good_price{
        color: #FF6600;
    }
    .add-good-box .table span.del-good{
        color: #38f;
        font-weight: bold;
        cursor: pointer;
    }
    .good-item .input-group{
        width: 110px;
        margin:0 auto;
    }
    .good-item .input-group input.form-control{
        width: 45px;
        padding: 6px 3px;
        text-align: center;
    }
    .good-item .input-group input.form-control.red{
        color: #FF6600!important;
    }
    td.goods-info p {
        height: 20px;
        line-height: 20px;
        margin: 0;
        width: 300px;
    }
    td.goods-info p span.good_name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 220px;
        margin-right: 3px;
    }

    .good-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .good-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }
    .add-gift{min-width:700px;overflow-x: auto;}
    .goodshow-list .format-item{
        background: #eee;
    }

    td.format-info p{
        height: 20px;
        line-height: 20px;
        margin:0;
    }
    td.format-info p span{
        display: inline-block;
        vertical-align: middle;
    }
    td.format-info p span.good_name{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 270px;
        margin-right: 3px;
    }
    td.format-info p span.good_price{
        color: #FF6600;
    }
    .format-item .input-group{
        width: 110px;
        margin:0 auto;
    }
    .format-item .input-group input.form-control{
        width: 45px;
        padding: 6px 3px;
        text-align: center;
    }
    .format-item .input-group input.form-control.red{
        color: #FF6600!important;
    }
    td.format-info p {
        height: 20px;
        line-height: 20px;
        margin: 0;
        width: 300px;
    }
    td.format-info p span.format_name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 225px;
        margin-right: 3px;
    }

    .format-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .format-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }
    .example-box{

    }
    .example-box input{
        display: inline-block !important;
        margin-right: 10px;
    }
    .example-item{
        margin: 8px 0;
    }
    .del-good{
        cursor: pointer;
        color: blue;
    }

</style>


<input type="hidden" id="store_id" value="<{$storeId}>">
<div class="page-top-button—box">
    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addStoreGoodsLimit()">+添加商品</button>
    <button class="btn btn-sm btn-success btn-save">保存</button>
</div>
<div class="add-gift" id="div-add">
<table class="input-table">
    <div class="choose-goodrange">
        <div class="assigngood-tip" data-type="assign" style="display: block;">
            <div class="add-good-box">
                <div class="goodshow-list">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>商品图片</th>
                            <th class="left" style="width: 40%;">
                                商品名称
                            </th>
                            <th>商品价格</th>
                            <!--
                            <th class="center">限购</th>
                            <th class="center">优惠</th>
                            <th class="center">数量</th>
                            <th class="center">虚拟销量</th>
                            -->
                            <th class="right">操作</th>
                        </tr>
                        </thead>
                        <tbody id="can-limit-goods">
                        <{if $goods}>
                            <{foreach $goods as $val}>
                            <tr class="good-item">
                                <td class="goods-img"><img src="<{$val['g_cover']}>" alt="" style="width: 50px;margin: 0"></td>
                                <td class="goods-info goods-name" data-id="<{$val['asgl_id']}>" data-gid="<{$val['g_id']}>" data-name="<{$val['g_name']}>"><p><span class="good_name"><{$val['g_name']}></span></p></td>
                                <td><{$val['g_price']}></td>
                                <!--
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">限　购（0表示不限购）</span>
                                        <input type="text" class="form-control goods-limit" value="<{$val['limit']}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                        <span class="input-group-addon">件</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">减价后</span>
                                        <input type="text" class="form-control red goods-price" value="<{$val['price']}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                        <span class="input-group-addon">元</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">共</span>
                                        <input type="text" class="form-control red goods-stock" value="<{$val['stock']}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                        <span class="input-group-addon">件 <{if $appletCfg['ac_type'] != 12}>（0表示取<{$goodsName}>库存）<{/if}></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">已售</span>
                                        <input type="text" class="form-control red goods-sold" value="<{$val['sold']}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                        <span class="input-group-addon">件</span>
                                    </div>
                                </td>
                                -->
                                <td class="right">
                                    <span class="del-good" data-gid="<{$val['g_id']}>" onclick="deleteGoods(this)">删除</span>
                                </td>
                            </tr>
                            <!--
                            <{foreach $val['format'] as $value}>
                            <tr class="format-item format<{$val['gid']}>">
                                <td class="format-info format-name" data-id="<{$value['id']}>" data-gfid="<{$value['gfid']}>" data-name="<{$value['name']}>"><p><span class="format_name"><{$value['name']}></span><span class="good_price">￥<{$value['gfprice']}></span></p></td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">减价后</span>
                                        <input type="text" class="form-control red format-price" value="<{$value['price']}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                        <span class="input-group-addon">元</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon">共</span>
                                        <input type="text" class="form-control red format-stock" value="<{$value['stock']}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                        <span class="input-group-addon">件 <{if $appletCfg['ac_type'] != 12}>（0表示取<{$goodsName}>库存）<{/if}></span>
                                    </div>
                                </td>
                                <td>
                                </td>
                                <td>
                                </td>
                            </tr>
                            <{/foreach}>
                            -->
                            <{/foreach}>
                            <{/if}>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <tr>
        <td class="label-td"><label><span class="red">&nbsp;</td>
        <td><a href="javascript:;" class="btn btn-sm btn-green btn-save"> 保 存 活 动 </a></td>
    </tr>

</table>
</div>
<!--添加礼物结束-->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<{include file="../modal-gift-select.tpl"}>
<script type="text/javascript">
    var acType = "<{$appletCfg['ac_type']}>";
    var currSid = "<{$appletCfg['ac_s_id']}>";
    $(function(){
        // 删除选择的商品
        // $(".del-good").on('click',function(event) {
        //     var trElem = $(this).parents('tr.good-item');
        //     console.log(trElem);
            // var goodListElem = $(this).parents('.goodshow-list');
            // var length = parseInt($(this).parents('.table').find('tbody tr').length);
            // trElem.remove();
            //var gid = $(this).data('gid');
            //$('.format'+gid).remove();
        // });
    });

    function deleteGoods(ele){
        var trElem = $(ele).parents('tr.good-item');
        console.log(trElem);
        trElem.remove();
    }

    $('.btn-save').on('click',function(){

        var data  = {};
        data.id   	= $('#store_id').val();



        var goods = {},g=0;
        $('#can-limit-goods').find('.good-item').each(function(){
            var _this = $(this);
            var gid = _this.find('.goods-info').data('gid');
            // var limit = _this.find('.goods-limit').val();
            // var price = _this.find('.goods-price').val();
            // var stock = _this.find('.goods-stock').val();
            // var sold = _this.find('.goods-sold').val();
            // var viewNum = _this.find('.goods-view-num').val();
            // var viewNumShow = _this.find('.goods-view-num-show:checked').val();

            // var format = [];
            // $('.format'+gid).each(function () {
            //    format.push({
            //        'id' : $(this).find('.format-info').data('gfid'),
            //        'price' : $(this).find('.format-price').val(),
            //        'stock' : $(this).find('.format-stock').val(),
            //    });
            // });
            if(gid){
                goods['go_'+g] = {
                    'id' 	: $(this).find('.goods-info').data('id'),
                    'gid'	: gid,
                    // 'name'	: $(this).find('.goods-info').data('gname'),
                    // 'limit' : limit,
                    // 'price' : price,
                    // 'stock' : stock,
                    // 'sold' : sold,
                    // 'viewNum' : viewNum,
                    // 'viewNumShow' : viewNumShow=='on'?1:0,
                    // 'format': format
                };
                g++;
            }
        });

        console.log(goods);
        //培训版 餐饮版 预约版 必须设置秒杀数量
        // for(var i in goods){
        //     if(acType == '12' || acType == '4' || acType == '7' || acType == '18'){
        //         if(goods[i].stock <=0 ){
        //             layer.msg('请填写商品数量');
        //             return false;
        //         }
        //     }
        // }
        data.goods = goods;

        console.log(data);
        //保存信息
        layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var loading = layer.load(10, {
	            shade: [0.6,'#666']
	        });
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/delivery/saveStoreGoods',
	            'data'  : data,
	            'dataType' : 'json',
	            'success'   : function(ret){
	                layer.close(loading);
	                layer.msg(ret.em);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }
	            }
	        });
        },function () {
            console.log(data);
        });

    });
    
    function removeExample(e) {
        $(e).parent().remove();
    }
    
    function addExample() {
        var example_html = getExampleHtml();
        $('.example-box').append(example_html);
    }

    
</script>
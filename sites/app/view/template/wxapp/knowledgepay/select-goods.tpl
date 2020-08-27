<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
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

    /*选择全部或指定课程*/
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
        max-width: 850px;
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
        width: 270px;
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
    .good-item .input-group .input-group-addon{
        padding: 6px 5px;
    }
    .good-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .good-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }
</style>
<div class="add-gift" id="div-add">
<h4 class="info-title"><span id="show_title">积分课程</span></h4>
<input type="hidden" id="id"  class="form-control" value="<{if $row}><{$row['la_id']}><{/if}>"/>

<table class="input-table">
    <tr>
        <td class="label-td"><label><span class="red">*</span>选择课程:</label></td>
        <td class="text-left">
            <div class="choose-goodrange">
                <div class="assigngood-tip" data-type="assign" style="display: block;">
                <div class="add-good-box">
                    <div class="goodshow-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="left" style="width: 50%;">课程名称</th>
                                <th class="center">课程积分</th>
                                <!--<th class="center">限购</th>
                                <th class="center">优惠</th>-->
                                <th class="right">操作</th>
                            </tr>
                            </thead>
                            <tbody id="can-limit-goods">
                                <{if $goods}>
                                <{foreach $goods as $val}>
                                <tr class="good-item">
                                    <td class="goods-info goods-name" data-id="<{$val['id']}>" data-gid="<{$val['gid']}>" data-name="<{$val['gname']}>"><p><span class="good_name"><{$val['gname']}></span><span class="good_price">￥<{$val['gprice']}></span></p></td>
                                    <!--<td>
                                       <div class="input-group">
                                            <span class="input-group-addon">限　购（0表示不限购）</span>
                                            <input type="text" class="form-control goods-limit" value="<{$val['limit']}>">
                                            <span class="input-group-addon">件</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">减价后</span>
                                            <input type="text" class="form-control red goods-price" value="<{$val['price']}>">
                                            <span class="input-group-addon">元</span>
                                        </div>
                                    </td>-->
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">积分</span>
                                            <input type="text" class="form-control red goods-price" value="<{$val['price']}>">
                                            <span class="input-group-addon">分</span>
                                        </div>
                                    </td>
                                    <td class="right"><span class="del-good">删除</span></td>
                                </tr>
                                <{/foreach}>
                                <{/if}>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addPointGood()">+添加课程</div>
                </div>
            </div>
            </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">&nbsp;</td>
        <td><a href="javascript:;" class="btn btn-sm btn-green btn-save-now"> 保 存 活 动 </a></td>
    </tr>
</table>
</div>
<!--添加礼物结束-->

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<{include file="./modal-point-select.tpl"}>
<script type="text/javascript">
    $(function(){
        // 删除选择的课程
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
            // if(length<=1){
            // 	goodListElem.stop().hide();
            // }
        });
    });

    $('.btn-save-now').on('click',function(){
        console.log(456);
        var data  = {};
        data.id   	= $('#id').val();
        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var goods = {},g=0;
        $('#can-limit-goods').find('.good-item').each(function(){
            var _this = $(this);
            var gid   = _this.find('.goods-info').data('gid');
            var limit = _this.find('.goods-limit').val();
            var price = _this.find('.goods-price').val();
            if(gid){
                goods['go_'+g] = {
                    'gid'	: gid,
                    'price' : price
                };
                g++;
            }
        });
        data.goods = goods;
        console.log(data);
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/copyPointGoods',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/knowledgepay/pointGoods'
                }
            }
        });

    });
</script>
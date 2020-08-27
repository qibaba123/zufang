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

    .good-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .good-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }
    .add-gift{min-width:700px;overflow-x: auto;}
</style>
<{include file="../common-second-menu.tpl"}>

<div class="add-gift" id="div-add" style="margin-left: 150px">
<h4 class="info-title"><span id="show_title">添加限时抢购活动</span></h4>
<input type="hidden" id="id"  class="form-control" value="<{if $row}><{$row['la_id']}><{/if}>"/>

<table class="input-table">
    <tr>
        <td class="label-td"><label><span class="red">*</span>活动名称:</label></td>
        <td><input type="text" id="name"  class="form-control" placeholder="请输入活动名称" value="<{if $row}><{$row['la_name']}><{/if}>"/></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>开始时间:</label></td>
        <td><input id="start_time" type="text" placeholder="请选择开始时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'end_time\')}'})" value="<{if $row}><{date('Y-m-d H:i:s',$row['la_start_time'])}><{/if}>"></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>结束时间:</label></td>
        <td><input id="end_time" type="text" placeholder="请选择结束时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'start_time\') || (\'%y-%M-%d\')}'})" value="<{if $row}><{date('Y-m-d H:i:s',$row['la_end_time'])}><{/if}>"></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>活动标签:</label></td>
        <td><input type="text" id="label"  class="form-control" placeholder="请填写活动标签" value="<{if $row}><{$row['la_label']}><{/if}>"/></td>
    </tr>
    <!--
    <{if $sid eq 5655}>
    <tr>
        <td class="label-td"><label>分享标题:</label></td>
        <td><input type="text" id="shareTitle"  class="form-control" placeholder="分享标题" value="<{if $row}><{$row['la_share_desc']}><{/if}>"/></td>
    </tr>
    <{/if}>
    -->
    <tr>
        <td class="label-td"><label><span class="red">*</span>抢购<{$goodsName}>:</label></td>
        <td class="text-left">
            <div class="choose-goodrange">
                <div style="color: red">若所选商品有不同规格、价格，统一按此处配置价格购买</div>
                <div class="assigngood-tip" data-type="assign" style="display: block;">
                <div class="add-good-box">
                    <div class="goodshow-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="left" style="width: 40%;">
                                    <{$goodsName}>名称
                                </th>
                                <th class="center">限购</th>
                                <th class="center">优惠</th>
                                <th class="center">数量</th>
                                <th class="right">操作</th>
                            </tr>
                            </thead>
                            <tbody id="can-limit-goods">
                                <{if $goods}>
                                <{foreach $goods as $val}>
                                <tr class="good-item">
                                    <td class="goods-info goods-name" data-id="<{$val['id']}>" data-gid="<{$val['gid']}>" data-name="<{$val['gname']}>"><p><span class="good_name"><{$val['gname']}></span><span class="good_price">￥<{$val['gprice']}></span></p></td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">共</span>
                                            <input type="text" class="form-control red goods-stock" value="<{$val['stock']}>">
                                            <span class="input-group-addon">件 <{if $appletCfg['ac_type'] != 12 && $appletCfg['ac_type'] != 7 && $appletCfg['ac_type'] != 4 && $appletCfg['ac_type'] != 18}>（0表示取<{$goodsName}>库存）<{/if}></span>
                                        </div>
                                    </td>
                                    <td class="right"><span class="del-good">删除</span></td>
                                </tr>
                                <{/foreach}>
                                <{/if}>
                            </tbody>
                        </table>
                         <{$paginator}>
                    </div>
                    <{if $appletCfg['ac_type'] == 12}>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addLimitCourse()">+添加<{$goodsName}></div>
                    <{else}>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addLimitGood()">+添加<{$goodsName}></div>
                    <{/if}>
                </div>
            </div>
            </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">&nbsp;</td>
        <td><a href="javascript:;" class="btn btn-sm btn-green btn-save"> 保 存 活 动 </a></td>
    </tr>
</table>
</div>
<!--添加礼物结束-->

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<{include file="../modal-gift-select.tpl"}>
<script type="text/javascript">
    var acType = "<{$appletCfg['ac_type']}>";
    $(function(){
        // 删除选择的商品
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

    $('.btn-save').on('click',function(){
        var field = new Array('name','start_time','end_time','label');
        console.log(111);
        var data  = {};
        for(var i=0; i < field.length; i++){
            var temp = $('#'+field[i]).val();
            if(temp){
                data[field[i]] = temp
            }else{
                var msg = $('#'+field[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        data.id   	= $('#id').val();

        var goods = {},g=0;
        $('#can-limit-goods').find('.good-item').each(function(){
            var _this = $(this);
            var gid = _this.find('.goods-info').data('gid');
            var limit = _this.find('.goods-limit').val();
            var price = _this.find('.goods-price').val();
            var stock = _this.find('.goods-stock').val();
            if(gid){
                goods['go_'+g] = {
                    'id' 	: $(this).find('.goods-info').data('id'),
                    'gid'	: gid,
                    'name'	: $(this).find('.goods-info').data('gname'),
                    'limit' : limit,
                    'price' : price,
                    'stock' : stock
                };
                g++;
            }
        });
        //培训版 餐饮版 预约版 必须设置秒杀数量
        for(var i in goods){
            if(acType == '12' || acType == '4' || acType == '7' || acType == '18'){
                if(goods[i].stock <=0 ){
                    layer.msg('请填写商品数量');
                    return false;
                }
            }
        }
        data.goods = goods;
        //保存信息
        layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var loading = layer.load(10, {
	            shade: [0.6,'#666']
	        });
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/limit/saveLimit',
	            'data'  : data,
	            'dataType' : 'json',
	            'success'   : function(ret){
	                console.log(ret);
	                layer.close(loading);
	                layer.msg(ret.em);
	                if(ret.ec == 200){
	                    window.location.href='/wxapp/limit/index'
	                }
	            }
	        });
        });

    });
</script>
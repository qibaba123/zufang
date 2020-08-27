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

</style>
<{include file="../common-second-menu.tpl"}>



<div class="add-gift" id="div-add" style="margin-left: 150px">
    <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
    <div class="alert alert-block alert-warning">
        活动开始后，可修改活动标题、标签、虚拟案例，不能修改其他信息。
    </div>
    <{/if}>

<h4 class="info-title"><span id="show_title">添加限时抢购活动</span></h4>
<input type="hidden" id="id"  class="form-control" value="<{if $row}><{$row['la_id']}><{/if}>"/>
<input type="hidden" id="ban-edit"  class="form-control" value="<{$banEdit}>"/>

<table class="input-table">
    <tr>
        <td class="label-td"><label><span class="red">*</span>活动名称:</label></td>
        <td><input type="text" id="name"  class="form-control" placeholder="请输入活动名称" value="<{if $row}><{$row['la_name']}><{/if}>"/></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>开始时间:</label></td>
        <td><input id="start_time" type="text" placeholder="请选择开始时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'end_time\')}'})" value="<{if $row}><{date('Y-m-d H:i:s',$row['la_start_time'])}><{/if}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>结束时间:</label></td>
        <td><input id="end_time" type="text" placeholder="请选择结束时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'start_time\') || (\'%y-%M-%d\')}'})" value="<{if $row}><{date('Y-m-d H:i:s',$row['la_end_time'])}><{/if}>" <{if $banEdit == 1}> disabled="disabled" <{/if}>></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>活动标签:</label></td>
        <td><input type="text" id="label"  class="form-control" placeholder="请填写活动标签" value="<{if $row}><{$row['la_label']}><{/if}>"/></td>
    </tr>
    <tr <{if $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36}>style="display:none"<{/if}>>
        <td class="label-td"><label>是否参与分佣:</label></td>
        <td>
            <div class="radio-box">
                <span>
                    <input type="radio" name="ignore_deduct" id="ignore_yes" value="0" <{if $row['la_ignore_deduct'] neq 1}>checked<{/if}> <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                    <label for="ignore_yes">参与分佣（团长有佣金）</label>
                </span>
                <span>
                    <input type="radio" name="ignore_deduct" id="ignore_no" value="1" <{if $row['la_ignore_deduct'] eq 1}>checked<{/if}> <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                    <label for="ignore_no">不参与分佣（团长无佣金）</label>
                </span>
            </div>
        </td>
    </tr>

    <{if $customShare == 1}>
    <tr>
        <td class="label-td"><label>分享图片:</label></td>
        <td><img onclick="toUpload(this)"
                 data-limit="1"
                 data-width="500"
                 data-height="400"
                 data-dom-id="share_image"
                 id="share_image"
                 placeholder="请上传分享图片"
                 data-need="required"
                 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_45_45.png"
                 src="<{if $row && $row['la_share_img']}><{$row['la_share_img']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  style="display:inline-block;width:100px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="500" data-height="400" data-dom-id="share_image">修改<small>(尺寸：500*400)</small></a></td>
    </tr>
    <tr>
        <td class="label-td"><label>分享标题:</label></td>
        <td><input type="text" id="share_title"  class="form-control" placeholder="分享标题" value="<{if $row}><{$row['la_share_title']}><{/if}>"/></td>
    </tr>
    <{/if}>
    <tr>
        <td class="label-td"><label><span class="red">*</span>抢购<{$goodsName}>:</label></td>
        <td class="text-left">
            <div class="choose-goodrange">
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
                                <th class="center">虚拟销量</th>
                                <{if $appletCfg['ac_type'] == 6 || $appletCfg['ac_type'] == 8}>
                                <th class="center">浏览量</th>
                                <{/if}>
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
                                    <{if $appletCfg['ac_type'] == 6 || $appletCfg['ac_type'] == 8}>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control red goods-view-num" value="<{$val['viewNum']}>">
                                            <span class="input-group-addon">
                                                <label style="margin: 0;width: 40px;height: 20px;">
                                                    <input name="viewNumShow" class="ace ace-switch ace-switch-5 goods-view-num-show" <{if ($val && $val['viewNumShow']) || !$val}>checked<{/if}> type="checkbox" <{if $banEdit == 1}> disabled="disabled" <{/if}>>
                                                    <span class="lbl" style="position: relative;top: -7px;left: -10px;"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </td>
                                    <{/if}>
                                    <td class="right">
                                        <{if $banEdit != 1}>
                                        <span class="del-good" data-gid="<{$val['gid']}>">删除</span>
                                        <{/if}>
                                    </td>
                                </tr>
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
                                <{/foreach}>
                                <{/if}>
                            </tbody>
                        </table>
                         <{$paginator}>
                    </div>
                    <{if $banEdit != 1}>

                    <{if $appletCfg['ac_type'] == 12}>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addLimitCourse()">+添加<{$goodsName}></div>
                    <{else}>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addLimitGoodNew()">+添加<{$goodsName}></div>
                    <{/if}>

                    <{/if}>
                </div>
            </div>
            </div>
            </div>
        </td>
    </tr>


    <tr <{if $showExample != 1}> style="display:none"<{/if}> >
        <td class="label-td"><label>虚拟案例:</label></td>
        <td>
            <button class="btn btn-xs btn-warning example-add" onclick="addExample()" style="margin-top: 5px">+添加案例</button>
            <div class="example-box">
                <{foreach $example_list as $example}>
                <div class="example-item">
                    <input type='hidden' value='<{$example['lfe_id']}>' class='example-id'>
                    标题：<input type='text' class='form-control example-title' value='<{$example['lfe_title']}>' placeholder='请填写案例标题'>售出数量：<input type='number' class='form-control example-num' value='<{$example['lfe_num']}>' placeholder='请填写售出数量'>时间：<input type='text' placeholder='请选择时间' class='form-control example-time' onClick='WdatePicker({dateFmt:"yyyy-MM-dd"})' value='<{$example['lfe_time']}>'><button class='btn btn-xs btn-danger example-delete' onclick="removeExample(this)">删除</button>
                </div>
                <{/foreach}>
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
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<{include file="../modal-gift-select.tpl"}>
<script type="text/javascript">
    var acType = "<{$appletCfg['ac_type']}>";
    var currSid = "<{$appletCfg['ac_s_id']}>";
    $(function(){
        // 删除选择的商品
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
            var gid = $(this).data('gid');
            $('.format'+gid).remove();
            // if(length<=1){
            // 	goodListElem.stop().hide();
            // }
        });
    });

    $('.btn-save').on('click',function(){
        var customShare = '<{$customShare}>';
        if(customShare == '1'){
            var field = new Array('name','start_time','end_time','label','share_title');
        }else{
            var field = new Array('name','start_time','end_time','label');
        }

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
        if(customShare == '1'){
            var imgField   =  new Array('share_image');
            for(var j=0; j<imgField.length; j++){
                var imgTemp = $('#'+imgField[j]).attr('src');
                var df      = $('#'+imgField[j]).data('dfvalue');
                if(imgTemp && df != imgTemp){
                    data[imgField[j]] = imgTemp
                }else{

                }
            }
        }


        var goods = {},g=0;
        $('#can-limit-goods').find('.good-item').each(function(){
            var _this = $(this);
            var gid = _this.find('.goods-info').data('gid');
            var limit = _this.find('.goods-limit').val();
            var price = _this.find('.goods-price').val();
            var stock = _this.find('.goods-stock').val();
            var sold = _this.find('.goods-sold').val();
            var viewNum = _this.find('.goods-view-num').val();
            var viewNumShow = _this.find('.goods-view-num-show:checked').val();

            var format = [];
            $('.format'+gid).each(function () {
               format.push({
                   'id' : $(this).find('.format-info').data('gfid'),
                   'price' : $(this).find('.format-price').val(),
                   'stock' : $(this).find('.format-stock').val(),
               });
            });
            if(gid){
                goods['go_'+g] = {
                    'id' 	: $(this).find('.goods-info').data('id'),
                    'gid'	: gid,
                    'name'	: $(this).find('.goods-info').data('gname'),
                    'limit' : limit,
                    'price' : price,
                    'stock' : stock,
                    'sold' : sold,
                    'viewNum' : viewNum,
                    'viewNumShow' : viewNumShow=='on'?1:0,
                    'format': format
                };
                g++;
            }
        });

        console.log(goods);
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

        var exampleArr = [];
        var exampleRow = '';
        $('.example-item').each(function(){
            exampleRow = {
                'id': $(this).find('.example-id').val(),
                'title': $(this).find('.example-title').val(),
                'num': $(this).find('.example-num').val(),
                'time': $(this).find('.example-time').val(),
            };
            exampleArr.push(exampleRow);
        });
        if(exampleArr.length > 0){
            for (let i=0;i<exampleArr.length;i++){
                if(!exampleArr[i].title){
                    layer.msg('请填写案例标题');
                    return;
                }
                if(exampleArr[i].num <= 0){
                    layer.msg('请填写案例售出数量');
                    return;
                }
                if(!exampleArr[i].time){
                    layer.msg('请填写案例时间');
                    return;
                }
            }
        }

        data.exampleList = exampleArr;
        console.log(exampleArr);

        //社区团购是否分佣
        var ignore_deduct = $('input[name="ignore_deduct"]:checked').val();
        var banEdit = $('#ban-edit').val();
        data.ignoreDeduct = ignore_deduct;
        data.banEdit = banEdit;
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
	                layer.close(loading);
	                layer.msg(ret.em);
	                if(ret.ec == 200){
	                    window.location.href='/wxapp/limit/index'
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
    
    function getExampleHtml() {
       var example_html = "<div class='example-item'><input type='hidden' value='0' class='example-id'>标题：<input type='text' class='form-control example-title' value='' placeholder='请填写案例标题'>售出数量：<input type='number' class='form-control example-num' value='' placeholder='请填写售出数量'>时间：<input type='text' placeholder='请选择时间' class='form-control example-time' onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" value=''><button class='btn btn-xs btn-danger example-delete' onclick='removeExample(this)'>删除</button></div>";
       return example_html;
    }
    
</script>
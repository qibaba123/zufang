<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    .payment-block .payment-block-body p { line-height: 24px; }
    .payment-block .payment-block-body dl { line-height: 24px; }
    .payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
    .payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
    .payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
    .payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
    /* 保存按钮样式 */
    .alert.save-btn-box{
        border: 1px solid #F5F5AA;
        background-color: #FFFFCC;
        text-align: center;
        position: fixed;
        bottom: 0;
        left: 50%;
        margin-left: -453px;
        width: 870px;
        margin-bottom: 0;
        z-index: 200;
    }
    #container object{
        position:relative!important;
        height: 300px!important;
    }
    .switch-title{
        padding-left: 8px;
        font-weight: bold;
    }
    .input-tip{
        color: #999;
        padding-left: 5px;
    }
    .second-navmenu li > a{
        padding-left: 0 !important;
        text-align: center !important;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
    .link-box div{
        width: 50% ;
    }
    .business-time{
        width: 12% !important;
        display: inline-block;
    }

    .bg-box{
        display: inline-block;
        margin-right: 20px;
        /*box-sizing: border-box;*/
        cursor: pointer;
        position: relative;
    }
    .bg-box-selected{
        border: 3px solid red;
    }

    .all-template li{
        display: inline-block;
        margin-right: 15px;
        margin-bottom: 15px;
    }
    .all-template li .temp-img{
        width: 175px;
        height: 290px;
        border:1px solid #eee;
        overflow: hidden;
        position: relative;
    }
    .all-template li p{
        text-align: center;
        line-height: 2.5;
        font-size: 14px;
        margin: 0;
        font-weight: bold;
    }
    .all-template li.usingtem .temp-img:after {
        content: '';
        position: absolute;
        height: 100%;
        width: 100%;
        background: url(/public/manage/images/using.png) no-repeat;
        background-size: 25px;
        background-position: center;
        background-color: rgba(0,0,0,.5);
        z-index: 1;
        top: 0;
        left: 0;
    }
    .all-template li img{
        width: 100%;
        padding:5px;
    }
    .add-good-box .table span.del-good{
        color: #38f;
        font-weight: bold;
        cursor: pointer;
    }

</style>
<div class="payment-style" >

    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">开启分享海报</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                    <input class='tgl tgl-light' id='shareposter-open' type='checkbox' value="1" <{if $cfg['asc_shareposter_open'] == 1}> checked <{/if}>>
                    <label class='tgl-btn' for='shareposter-open' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">是否手动添加</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="shareposter-add" id="shareposter-add-1" value="1" <{if $cfg['asc_shareposter_add'] eq 1}>checked<{/if}>>
                        <label for="shareposter-add-1">手动添加</label>
                    </span>

                    <span>
                        <input type="radio" name="shareposter-add" id="shareposter-add-2" value="2" <{if $cfg['asc_shareposter_add'] eq 2}>checked<{/if}>>
                        <label for="shareposter-add-2">自动获得</label>
                    </span>
                </div>
                <div style="margin-top: 5px;color: red">
                    自动获得时，会根据推荐商品和排序自动获得对应数量的商品
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">商品数量</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="shareposter-num" id="shareposter-num-2" value="2" <{if $cfg['asc_shareposter_num'] eq 2}>checked<{/if}>>
                        <label for="shareposter-num-2">2件</label>
                    </span>

                    <span>
                        <input type="radio" name="shareposter-num" id="shareposter-num-4" value="4" <{if $cfg['asc_shareposter_num'] eq 4}>checked<{/if}>>
                        <label for="shareposter-num-4">4件</label>
                    </span>

                    <span>
                        <input type="radio" name="shareposter-num" id="shareposter-num-6" value="6" <{if $cfg['asc_shareposter_num'] eq 6}>checked<{/if}>>
                        <label for="shareposter-num-6">6件</label>
                    </span>

                    <span>
                        <input type="radio" name="shareposter-num" id="shareposter-num-8" value="8" <{if $cfg['asc_shareposter_num'] eq 8}>checked<{/if}>>
                        <label for="shareposter-num-8">8件</label>
                    </span>
                </div>
                <div style="margin-top: 5px;color: red">
                </div>
            </div>
        </div>

        <div class="row add-goods-row" <{if $cfg['asc_shareposter_add'] == 2}> style="display: none" <{/if}>>
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">添加分享商品</label>
            </div>
            <div class="form-group col-sm-10 goods-box">
                <div class="add-good-box" style="width: 50%">
                    <div class="goodshow-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="left">商品名称</th>
                                <th class="right">操作</th>
                            </tr>
                            </thead>
                            <tbody id="can-used_goods">
                            <{foreach $goods_list as $val}>
                                <tr class="good-item">
                                    <td class="goods-info" data-id="<{$val['g_id']}>" data-gid="<{$val['g_id']}>" data-name="<{$val['g_name']}>"><p><{$val['g_name']}></p></td>
                                    <td class="right"><span class="del-good">删除</span></td>
                                </tr>
                                <{/foreach}>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn btn-xs btn-primary confirm-add-good" data-toggle="modal" data-target="#goodsList" >+添加商品</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">选择海报背景</label>
            </div>
            <div class="form-group col-sm-10 all-template">
                <{foreach $shareposter_bg as $row}>
                <li data-bg="<{$row}>" <{if $cfg['asc_shareposter_bg'] == $row}>class="usingtem" <{/if}> >
                <div class="temp-img">
                    <img src="<{$row}>" alt="">
                    <div class="use-edit">
                    </div>
                </div>
                <p></p>
                </li>
                <{/foreach}>
            </div>
        </div>

    </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<{include file="../modal-gift-select.tpl"}>
<script>
    $(function () {
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
        });

        $('input[name="shareposter-add"]').change(function () {
            
            if(this.value == 2){
                $('.add-goods-row').css('display','none');
            }else{
                $('.add-goods-row').css('display','block');
            }
        });

        $('.confirm-add-good').click(function () {
            var num = $('input[name="shareposter-num"]:checked').val();
            confirmAddgood();
        });
    });

    $('.all-template li').click(function () {
        $('.all-template li').removeClass('usingtem');
        $(this).addClass('usingtem');
    });

    $('.btn-save').on('click',function(){
        var num = $('input[name="shareposter-num"]:checked').val();
        var open = $('#shareposter-open:checked').val();
        var add = $('input[name="shareposter-add"]:checked').val();
        var bg = $('.usingtem').data('bg');
        open = open == 1 ? 1 : 0;
        var data = {
            num : num,
            open : open,
            add : add,
            bg : bg
        };
        var goods = [],g = 0;
        $('#can-used_goods').find('.good-item').each(function(){
            var gid = $(this).find('.goods-info').data('gid');
            if(gid){
                var goods_row = {
                    'id' 	: $(this).find('.goods-info').data('id'),
                    'gid'	: gid,
                    'name'	: $(this).find('.goods-info').data('name')
                };
                goods.push(goods_row);
                g++;
            }
        });
        if(add == 1 && num != goods.length){
            layer.msg('请添加正确数量的商品.');
            return;
        }

        data.goods = goods;

        layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){

            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/sequence/saveShareposterCfg',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });

    });

</script>

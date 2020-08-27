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
        <!--
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
        -->

        <div class="row">
            <div class="form-group col-sm-3 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">社区精选帖子每人每日发布数量</label>
            </div>
            <div class="form-group col-sm-3">
                <input class='form-control' id='member_post_day_num' type='number' value="<{$cfg['asc_member_post_day_num']}>" style="display: inline-block;width: 60%">
                <span>帖/天</span>
                <div style="margin-top: 5px;color: #666">
                    0表示不限制
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-3 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">附近社区帖子每人每日发布数量</label>
            </div>
            <div class="form-group col-sm-3">
                <input class='form-control' id='leader_post_day_num' type='number' value="<{$cfg['asc_leader_post_day_num']}>" style="display: inline-block;width: 60%">
                <span>帖/天</span>
                <div style="margin-top: 5px;color: #666">
                    0表示不限制
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-3 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">社区精选发帖置顶天数</label>
            </div>
            <div class="form-group col-sm-3">
                <input class='form-control' id='leader_top_day' type='number' value="<{$cfg['asc_leader_top_day']}>" style="display: inline-block;width: 60%">
                <span>天</span>
                <div style="margin-top: 5px;color: #666">
                    0表示不能置顶
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-3 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">附近社区帖子查找范围</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="leader-post-scope" id="leader-post-scope-0" value="0" <{if $cfg['asc_leader_post_scope'] eq 0}>checked<{/if}>>
                        <label for="leader-post-scope-0">全部</label>
                    </span>
                    <span>
                        <input type="radio" name="leader-post-scope" id="leader-post-scope-1" value="1" <{if $cfg['asc_leader_post_scope'] eq 1}>checked<{/if}>>
                        <label for="leader-post-scope-1">市级</label>
                    </span>

                    <span>
                        <input type="radio" name="leader-post-scope" id="leader-post-scope-2" value="2" <{if $cfg['asc_leader_post_scope'] eq 2}>checked<{/if}>>
                        <label for="leader-post-scope-2">县级</label>
                    </span>
                </div>
                <div style="margin-top: 5px;color: red">
                    选择"市级"时，附近社区帖子列表将显示团长发布的与用户当前选择小区相同城市的小区帖子，"县级"同上。
                </div>
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


    });



    $('.btn-save').on('click',function(){
        var scope = $('input[name="leader-post-scope"]:checked').val();
        var member_num = $('#member_post_day_num').val();
        var leader_num = $('#leader_post_day_num').val();
        var leader_top_day = $('#leader_top_day').val();
        open = open == 1 ? 1 : 0;
        var data = {
            scope : scope,
            member_num : member_num,
            leader_num : leader_num,
            leader_top_day : leader_top_day
        };

        layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){

            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/sequence/savePostCfg',
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

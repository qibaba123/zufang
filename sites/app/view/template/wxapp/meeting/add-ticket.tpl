<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style type="text/css">
    #default-onoff input[name=is_default].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是 \a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    #default-onoff input[type=checkbox].ace.ace-switch{
        margin:0;
        width: 60px;
        height: 30px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        line-height: 30px;
        height: 31px;
        width: 60px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after{
        left: 30px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
        width: 29px;
        height: 29px;
        line-height: 29px;
    }
    #container {
        width:100%;
        height: 300px;
    }
    .marker-route{
        width: 120px;
        height: 50px;
        background-color: #fff;
        font-size: 14px;
    }
    .week-choose{
        font-size: 0;
    }
    .week-choose span{
        display: inline-block;
        width: 13%;
        margin:0 0.64%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #E2E2E2;
        font-size: 12px;
        text-align: center;
        color: #777;
        line-height: 34px;
        cursor: pointer;
        max-width: 50px;
    }
    .week-choose span.active{
        border-color: #3DC018;
        position: relative;
    }
    .week-choose span.active:before{
        position: absolute;
        content: '';
        top:0;
        right: 0;
        z-index: 1;
        background: url(/public/manage/images/active.png) no-repeat;
        background-size: 14px;
        background-position: top right;
        width: 14px;
        height: 14px;
    }

    .panel-body{
        padding: 0;
    }

    .control-group{
        margin-left: 18%;
    }

    .panel{
        max-width: 300px;
        float: left;
    }

    .close {
        font-size: 30px;
        line-height: 50px;
        margin: 0 10px;
    }

    .panel-group .panel+.panel {
        margin-top: 0;
    }

    .placeholder{
        position: absolute;
        right: 25px;
        top: 5px;
        color: #a6a6a6;
    }
</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<div  ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="property-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<{if $ticket}><{$ticket['amt_id']}><{else}>0<{/if}>">
                                    <input type="hidden" id="hid_id" name="amid" value="<{if $amid}><{$amid}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>票类名称</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="票类名称" required="required" value="<{if $ticket}><{$ticket['amt_name']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>票类价格</label>
                                            </div>
                                            <div class="form-group col-sm-4" style="position: relative;">
                                                <input type="text" class="form-control" id="price" name="price" placeholder="票类价格" value="<{if $ticket}><{$ticket['amt_price']}><{/if}>">
                                                <label class="placeholder">元</label>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>票类总数</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="total" name="total" placeholder="票类名称" required="required" value="<{if $ticket}><{$ticket['amt_total']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>票类说明</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:80%;height:200px;" id = "content" name="content" placeholder="票类说明"  rows="20" style=" text-align: left; resize:vertical;" ><{if $ticket && $ticket['amt_content']}><{$ticket['amt_content']}><{/if}></textarea>
                                                <!--<input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                <input type="hidden" name="ke_textarea_name" value="content" />-->
                                            </div>
                                        </div>
                                        <div class="space-8"></div>

                                        <div class="form-group col-sm-12" style="text-align:center">
                                            <span type="button" class="btn btn-primary btn-sm btn-save " onclick="saveProperty()"> 保 存 </span>
                                        </div>
                                        <div class="space-8"></div>
                                    </div>
                                </form>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    function saveProperty(){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/meeting/saveTicket',
            'data'  : $('#property-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    window.location.href='/wxapp/meeting/ticket/id/'+ret.amid;
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }
    var nowdate = new Date();
    var year = nowdate.getFullYear(),
            month = nowdate.getMonth()+1,
            date = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd'
        });
    }
</script>



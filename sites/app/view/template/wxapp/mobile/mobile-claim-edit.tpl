<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
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
</style>
<{include file="../article-kind-editor.tpl"}>
<div  ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="javascript:history.go(-1);" >返回</a></small> | 查看认领信息</h4>

                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="activity-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['ams_id']}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <!--<div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>认领人姓名</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写姓名" required="required" value="<{if $name}><{$name}><{/if}>">
                                            </div>
                                        </div>-->

                                        <!--<div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">门牌号</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="addr_detail" name="addr_detail" placeholder="请填写门牌号" value="<{if $row}><{$row['ams_addr_detail']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>联系电话</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" required="required" class="form-control" id="mobile" name="mobile" placeholder="请填写联系电话" value="<{if $row}><{$row['ams_mobile']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>-->
                                        <!--<div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">申请时间</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input id="startTime" name="startTime" type="text" placeholder="请选择开始时间" class="Wdate form-control" <{if $row && $row['ams_create_time']}><{/if}> value="<{if $row}><{date('Y-m-d H:i:s',$row['ams_create_time'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\');}'})">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">审批时间</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input id="authTime" name="authTime" type="text" placeholder="请选择开始时间" class="Wdate form-control" <{if $row && $row['ams_auth_time']}><{/if}> value="<{if $row}><{date('Y-m-d H:i:s',$row['ams_auth_time'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\');}'})">
                                            </div>
                                        </div>-->


                                        <div class="space-8"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">认领详情</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                               <!--<h3 class="lighter block green">店铺详情图(<small>最多三张</small>)</h3>-->
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $imgs as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val}>"  layer-pid="" src="<{$val}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$key}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <!--<span onclick="toUpload(this)" data-limit="5" data-width="750" data-height="1334" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>-->
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $imgs}><{count($imgs)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                            </div>
                                        </div>

                                        <div class="space-8"></div>
                                        <!--<div class="form-group col-sm-12" style="text-align:center">
                                            <span type="button" class="btn btn-primary btn-sm btn-save "> 保 存 </span>
                                        </div>-->
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
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
    var latitude = '<{$row['ams_lat']}>'?'<{$row['ams_lat']}>':'34.77485';
    var longitude = '<{$row['ams_lng']}>'?'<{$row['ams_lng']}>':'113.72052';
    var storeAddress = '<{$row['ams_address']}>'?'<{$row['ams_address']}>':'公司地址';
    $(function(){
        /*选择接待开始时间*/
        $('#open_time').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        /*选择接待结束时间*/
        $('#close_time').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        /*选择周几*/
        $(".week-choose").on('click', 'span', function(event) {
            $(this).toggleClass('active');
        });

        //初始化省、市、区
        var id = $('#hid_id').val();
        //if(id){
        //    initWxappRegion(1,'province','<{$row['ams_province']}>');
        //    initWxappRegion('<{$row['ams_province']}>','city','<{$row['ams_city']}>');
        //   initWxappRegion('<{$row['ams_city']}>','zone','<{$row['ams_zone']}>');
        //}else{
        //    initWxappRegion(1,'province');
        //}
        //$("#province").find("option[text='河南']").attr("selected",true);
        $('#province option[text="河南"]').attr("selected", true);
        


       /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-logo'){
                    $('#logo').val(allSrc[0]);
                }
            }else {
                var img_html = '';
                var cur_num = $('#' + nowId + '-num').val();
                for (var i = 0; i < allSrc.length; i++) {
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="' + allSrc[i] + '"  layer-pid="" src="' + allSrc[i] + '" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_' + key + '" name="slide_' + key + '" value="' + allSrc[i] + '">';
                    img_html += '<input type="hidden" id="slide_id_' + key + '" name="slide_id_' + key + '" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num) + allSrc.length;
                if (now_num <= maxNum) {
                    $('#' + nowId + '-num').val(now_num);
                    $('#' + nowId).prepend(img_html);
                } else {
                    layer.msg('详情图片最多' + maxNum + '张');
                }
            }
        }
    }

    $('.btn-save').on('click',function(){
        saveShop();
    });

    function saveShop(){
    var is_head  = $('#is_head:checked').val();
    var data = {};
//    var check = new Array('name','addr','lng','lat','logo','mobile','date');
    var check = new Array('name','addr','contact','lng','lat','open_time','close_time','logo','content','addr_detail','mobile','wxcode','date','management');
    for(var i=0 ; i < check.length; i++){
        var temp = $('#'+check[i]).val();
        var require = $('#'+check[i]).attr('required');
        data[check[i]] = temp;

        if(!temp && require == 'required'){
            var msg = $('#'+check[i]).attr('placeholder');
            layer.msg(msg);
            return false;
        }else{

        }
    }
    data.category = $('#category').val();
    data.id      = $('#hid_id').val();

    var imgArr = [];
    $('#slide-img').find("img").each(function () {
       var _this = $(this);
       imgArr.push(_this.attr('src'))
    });
    data.imgArr = imgArr;
    var index    = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/wxapp/mobile/saveShopEdit',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            if(ret.ec == 200){
                layer.msg(ret.em);
                window.location.href='/wxapp/mobile/shopList';
            }else{
                layer.msg(ret.em);
            }
        }
    });


}
</script>



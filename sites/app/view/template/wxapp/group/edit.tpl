<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<!-- <link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" /> -->
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
    .chosen-container {
        width: 100%!important;
    }
    .chosen-container-multi .chosen-choices{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .chosen-container-single .chosen-single{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
        height: 34px;
        background: url();
        background-color: #fff;
    }
    .chosen-container-single .chosen-single span{
        margin-top: 2px;
    }
    .chosen-single div b:before{
        top:3px;
    }
    select.form-control {
        padding: 5px 6px;
        height: 34px;
    }
    .ptinfo-fenlei{
        background-color: #f6f6f6;
        border:1px solid #e8e8e8;
        border-radius: 4px;
        margin-bottom: 10px;
        padding: 15px 10px;
    }
    .ptinfo-fenlei .fenlei-name{
        font-size: 16px;
        line-height: 34px;
        font-weight: bold;
        color: #02a802;
        display: block;
        text-align: center;
        padding-right: 10px;
    }
    .ptinfo-fenlei .control-label{
        font-weight: bold;
        text-align: right;
        padding-right: 0;
        line-height: 26px;
    }
    .ptinfo-fenlei .col-xs-10 .form-group:last-child{
        margin-bottom: 0;
    }
    .Wdate.form-control[type=text]{
        background: #fff url(/public/plugin/datePicker/skin/datePicker.gif) no-repeat;
        height: 34px;
        border-color: #ccc;
        background-position: 98% center;
    }
    .radio-box{
        line-height: 34px;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div id="mainContent">
<div class="choose-pintuan" id="div-type">
    <h3>选择创建一种拼团方式</h3>
    <p>通过发放优惠券提高用户参与度</p>
    <div class="pintuan-type" >
        <{foreach $groupType as $val}>
        <div class="type-item" data-type="<{$val['type']}>">
            <a href="#">
                <div class="ticket ticket-<{$val['color']}>">
                    <span><{$val['title']}></span>
                </div>
                <div class="right-txt">
                    <h4><{$val['brief']}></h4>
                    <p><{$val['desc']}></p>
                </div>
            </a>
        </div>
        <{/foreach}>
    </div>
</div>
<div class="choose-pintuan"  id="div-add" style="display: none;">
    <form class="form-horizontal" id="activity-form"  enctype="multipart/form-data">
        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['gb_id']}><{else}>0<{/if}>">
        <input type="hidden" id="type" name="type" value="<{if $row}><{$row['gb_type']}><{else}>0<{/if}>" data-need="required" placeholder="请选择团购分类">
        <div style="overflow:hidden">
            <div class="ptinfo-fenlei clearfix">
                <div class="col-xs-2">
                    <span class="fenlei-name">参团商品</span>
                </div>
                <div class="col-xs-10" style="border-left:1px dashed #ddd;">
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">拼团购封面</label>
                        <div class="col-xs-9">
                            <div>
                                <img onclick="toUpload(this)"
                                     data-limit="1"
                                     data-width="750"
                                     data-height="360"
                                     data-dom-id="cover"
                                     id="cover"
                                     data-dfvalue="/public/manage/img/zhanwei/zw_fxb_75_36.png"
                                     placeholder="请上传拼图购封面图"
                                     data-need="required"
                                     src="<{if $row && $row['gb_cover']}><{$row['gb_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  style="display:inline-block;width:200px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="360" data-dom-id="cover">修改（尺寸：750*360）</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">参团商品</label>
                        <div class="col-xs-9">
                            <select class="form-control selectpicker chosen-select" id="g_id" name="g_id" <{if $row && $row['gb_g_id']}><{/if}>  data-live-search="true"  data-need="required" data-placeholder="请选择参团商品">
                            <{foreach $goodsList as $val}>
                        <option value="<{$val['g_id']}>" <{if $row && $row['gb_g_id'] eq $val['g_id']}>selected="selected"<{/if}>><{mb_substr($val['g_name'],0,20)}></option>
                            <{/foreach}>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">活动规则</label>
                        <div class="col-xs-9">
                            <textarea id="activity_rule" class="form-control " rows="3" name="activity_rule" data-need="" placeholder="请填写活动规则"><{if $row}><{$row['gb_act_rule']}><{/if}></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ptinfo-fenlei clearfix">
                <div class="col-xs-2">
                    <span class="fenlei-name">价格设置</span>
                </div>
                <div class="col-xs-10" style="border-left:1px dashed #ddd;">
                    <div class="form-group tuanzhang" style="display: none">
                        <label for="price" class="col-xs-3 control-label">团长优惠价</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control " id="tz_price" name="tz_price"  data-need="" placeholder="请填写团长优惠价格" <{if $row && $row['gb_tz_price']}><{/if}> value="<{if $row}><{$row['gb_tz_price']}><{/if}>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">团购价格</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control " id="price" name="price" placeholder="请填写团购价格" <{if $row && $row['gb_price']}><{/if}> data-need="required" value="<{if $row}><{$row['gb_price']}><{/if}>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="ptinfo-fenlei clearfix">
                <div class="col-xs-2">
                    <span class="fenlei-name">人数设置</span>
                </div>
                <div class="col-xs-10" style="border-left:1px dashed #ddd;">
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">单个团要求参团人数</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control need-desc" id="total" name="total" placeholder="请填写参团人数，至少2人" <{if $row && $row['gb_total']}><{/if}> data-need="required" value="<{if $row}><{$row['gb_total']}><{/if}>"  oninput="this.value=this.value.replace(/\D/g,'')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">所有拼团共计参与人数</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control need-desc" id="joined" name="joined" placeholder="本活动总计参与人数"  data-need="required" value="<{if $row}><{$row['gb_joined']}><{/if}>"  oninput="this.value=this.value.replace(/\D/g,'')">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">凑团显示个数</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control need-desc" id="show_num" name="show_num" placeholder="请填写凑团显示个数" data-need="required" value="<{if $row}><{$row['gb_show_num']}><{/if}>"  oninput="this.value=this.value.replace(/\D/g,'')">
                        </div>
                    </div>

                </div>
            </div>
            <div class="ptinfo-fenlei clearfix">
                <div class="col-xs-2">
                    <span class="fenlei-name">时间设置</span>
                </div>
                <div class="col-xs-10" style="border-left:1px dashed #ddd;">
                    <div class="form-group">
                        <label for="start" class="col-xs-3 control-label">开始时间</label>
                        <div class="col-xs-9">
                            <input id="startTime" name="startTime" type="text" placeholder="请选择开始时间" class="Wdate form-control" <{if $row && $row['gb_start_time']}><{/if}> value="" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\');}'})">
                            <!-- <div class="col-xs-6">
								<input type="text" class="form-control" id="start" name="start" placeholder="请选择开始日期" data-need="required" value="<{if $row}><{date('Y-m-d',$row['gb_start_time'])}><{else}><{$now}><{/if}>">
							</div>
							<div class="col-xs-6">
								<div class="input-group bootstrap-timepicker">
									<input id="startTime" name="startTime" type="text" class="form-control" data-need="required" value="<{if $row}><{date('H:i:s',$row['gb_start_time'])}><{/if}>" placeholder="请选择开始时间" />
									<span class="input-group-addon">
										<i class="icon-time bigger-110"></i>
									</span>
								</div>
							</div> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end" class="col-xs-3 control-label">结束时间</label>
                        <div class="col-xs-9">
                            <input id="endTime" name="endTime"  type="text" placeholder="请选择结束时间" class="Wdate form-control" <{if $row && $row['gb_end_time']}><{/if}> value="" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\');}'})">
                            <!-- <div class="col-xs-6">
								<input type="text" class="form-control" id="end" name="end" placeholder="请选择结束时间" data-need="required" value="<{if $row}><{date('Y-m-d',$row['gb_end_time'])}><{else}><{$now}><{/if}>">
							</div>
							<div class="col-xs-6">
								<div class="input-group bootstrap-timepicker">
									<input id="endTime" name="endTime" type="text" class="form-control" data-need="required" value="<{if $row}><{date('H:i:s',$row['gb_end_time'])}><{/if}>" placeholder="请选择结束时间"/>
									<span class="input-group-addon">
										<i class="icon-time bigger-110"></i>
									</span>
								</div>
							</div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="ptinfo-fenlei clearfix putong" style="display: none;">
                <div class="col-xs-2">
                    <span class="fenlei-name">其它设置</span>
                </div>
                <div class="col-xs-10" style="border-left:1px dashed #ddd;">
                    <div class="form-group putong" style="display: none;" id="div-auto">
                        <label for="price" class="col-xs-3 control-label">是否自动成团</label>
                        <div class="col-xs-9">
                            <div class="radio-box">
                                <{foreach $yesNo as $key=>$val}>
                                <span data-val="<{$key}>">
									<input type="radio" name="auto" value="<{$key}>" id="auto<{$key}>" <{if $row && $row['gb_start_time']<time()}><{/if}>  <{if $row && $row['gb_use_auto'] eq $key}>checked<{elseif empty($row) && $key eq 1}>checked<{/if}>>
									<label for="auto<{$key}>"><{$val}></label>
								</span>
                                <{/foreach}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ptinfo-fenlei clearfix">
                <div class="col-xs-2">
                    <span class="fenlei-name">分享设置</span>
                </div>
                <div class="col-xs-10" style="border-left:1px dashed #ddd;">
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">分享图片</label>
                        <div class="col-xs-9">
                            <img onclick="toUpload(this)"
                                 data-limit="1"
                                 data-width="215"
                                 data-height="168"
                                 data-dom-id="share_image"
                                 id="share_image"
                                 placeholder="请上传分享图片"
                                 data-need=""
                                 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_45_45.png"
                                 src="<{if $row && $row['gb_share_image']}><{$row['gb_share_image']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  style="display:inline-block;width:100px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="215" data-height="168" data-dom-id="share_image">修改<small>(尺寸：215*168)</small></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-xs-3 control-label">分享标题</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control need-desc" id="share_title" name="share_title" data-need="" placeholder="若不填写，则取商品标题" value="<{if $row}><{$row['gb_share_title']}><{/if}>" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-12" style="text-align:center">
                <button type="button" class="btn btn-primary btn-save"> 保 存 </button>
            </div>
        </div>
    </form>
</div><!-- /row -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<!-- <script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script> -->

<script type="text/javascript">
    $(function(){
        // 搜索选择下拉框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true
        });

        if('<{$isAdd}>' == 'edit'){
            deal_show_hide_by_type('<{$row['gb_type']}>')
        }

    });
    $('.type-item').on('click',function(){
        var type = $(this).data('type');
        if(type){
            deal_show_hide_by_type(type);
        }
    });
    $('.need-desc').on('focus',function(){
        var desc = $(this).data('desc');
        if(desc){
            var id   = $(this).attr('id');
            layer.tips(desc, '#'+id, {
                tips: [2, '#78BA32'],
                time: 4000
            });
        }
    });

    function deal_show_hide_by_type(type){
        $('#type').val(type);
        $('#div-type').hide();
        $('#div-add').show();
        var type_val = parseInt(type);
        switch (type_val){
            case 1 :
                $('.putong').show();
                break;
            case 2 :
                $('.choujiang').show();
                break;
            case 3 :
                $('.tuanzhang').show();
                break;
        }
    }
    /*初始化日期选择器*/
    /*$('#start').datepicker({autoclose:true}).next().on(ace.click_event, function(){
		// $(this).prev().focus();
	});
	$('#end').datepicker({autoclose:true}).next().on(ace.click_event, function(){
		// $(this).prev().focus();
	});
	$('#startTime').timepicker({
		minuteStep: 1,
		showSeconds: true,
		showMeridian: false
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	$('#endTime').timepicker({
		minuteStep: 1,
		showSeconds: true,
		showMeridian: false
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});*/
    $('.btn-save').on('click',function(){
        var field = new Array('type','g_id','price','total','joined','show_num','start','startTime','end','endTime','share_title','share_desc','activity_rule');
        var data  = {};
        for(var i=0; i<field.length; i++){
            var temp = $('#'+field[i]).val();
            if(temp){
                data[field[i]] = temp
            }else{
                var req = $('#'+field[i]).attr('data-need');
                if(req == 'required'){
                    var msg = $('#'+field[i]).attr('placeholder');
                    layer.msg(msg);
                    return false;
                }
            }
        }
        data.use_auto  =  $('input[name="auto"]:checked').val();
        data.sub_limit =  $('input[name="limit"]:checked').val();
       /// data.id 	   =  $('#hid_id').val();
        data.tz_price  =  $('#tz_price').val();
        var imgField   =  new Array('cover','share_image');
        for(var j=0; j<imgField.length; j++){
            var imgTemp = $('#'+imgField[j]).attr('src');
            var df      = $('#'+imgField[j]).data('dfvalue');
            if(imgTemp && df != imgTemp){
                data[imgField[j]] = imgTemp
            }else{
                errorTips(imgField[j]);
                return false;
            }
        }

        if(data.total <= 1){
            layer.msg('参团人数必需大于1个人');
            return false;
        }

        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/group/saveGroup',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/group/index';
                }
            }
        });

    });

    function errorTips(id){
        var req = $('#'+id).data('need');
        if(req == 'required'){
            var msg = $('#'+id).attr('placeholder');
            layer.msg(msg);
        }
    }
    function deal_select_img(allSrc){
        if(allSrc){
            $('#'+nowId).attr('src',allSrc[0]);
        }
    }
</script>


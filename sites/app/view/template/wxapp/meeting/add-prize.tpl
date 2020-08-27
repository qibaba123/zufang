<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style type="text/css">
    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    .ct{
        margin-left: 33%;
    }
</style>

<div ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-xs-12">
            <div class="widget-main">
                <div class="step-content row-fluid position-relative" id="step-container">
                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                        <input type="hidden" id="id" name="id" value="<{if $row}><{$row['ampl_id']}><{else}>0<{/if}>">
                        <!-- 表单分类显示 -->
                        <div class="info-group-inner">
                            <div class="group-info">
                                <div class="form-group" id="showSort">
                                    <label for="price" class="control-label"><font color="red">*</font>名称：</label>
                                    <div class="control-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="请填写自定义名称"  value="<{if $row}><{$row['ampl_name']}><{/if}>">
                                    </div>
                                </div>

                                <div class="form-group" id="points"   <{if $row['ampl_type']==1 || $row['ampl_type']==0}>style="display:none;" <{/if}>>
                                    <label for="price" class="control-label"><font color="red">*</font>奖励数量：</label>
                                    <div class="control-group">
                                        <input type="text" class="form-control" id="pnum" name="pnum" placeholder="请填写奖励数量"  value="<{if $row}><{$row['ampl_pnum']}><{/if}>">
                                    </div>
                                </div>

                                <!--<div class="form-group">
                                    <label for="price"  class="col-sm-3 control-label"><font color="red">*</font>链接职位：</label>
                                    <div class="control-group">
                                        <select id="ss_link" name="ss_link" class="form-control" >
                                        <{foreach $posOne as $key => $val}>
                                         <option  <{if $row['ss_link'] eq $val['link']}>selected<{/if}> value="<{$val['link']}>"><{$val['title']}></option>
                                        <{/foreach}>
                                        </select>
                                    </div>
                                </div>-->
                                <!--<div class="form-group" id="showSort">
                                    <label for="price" class="control-label"><font color="red">*</font>权重：</label>
                                    <div class="control-group">
                                        <input type="text" class="form-control" id="ss_weight" name="ss_weight" placeholder="请填写0-99之间的数字权重,数值越大显示越靠前"  value="<{if $row}><{$row['ss_weight']}><{/if}>">
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <label for="price"  class="col-sm-3 control-label"><font color="red">*</font>奖品类型：</label>
                                    <div class="control-group">
                                        <select id="type" name="type" onchange="showNum(this)" class="form-control">
                                            <{foreach $typeArr as $key => $val}>
                                        <option  <{if $row['ampl_type'] eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                            <{/foreach}>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="price" class="control-label"><font color="red">*</font>上传图片：</label>
                                    <div class="control-group">
                                        <h3 class="lighter block green">上传奖品图片(<small style="font-size: 12px;color:#999">建议尺寸：200 x 200 </small>)</h3>
                                        <div>
                                            <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['ampl_cover']}><{$row['ampl_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" height="150" style="display:inline-block;margin-left:0;">
                                            <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['ampl_cover']}><{$row['ampl_cover']}><{/if}>"/>
                                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover">修改</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row-fluid ct">
                    <button class="btn btn-primary" onclick="saveSlide();">
                        保存
                    </button>
                </div>
            </div><!-- /widget-main -->
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<{include file="../img-upload-modal.tpl"}>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(function(){
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

    });

    function showNum(obj){
         var type = $(obj).val();
         if(type ==2 || type ==3 || type ==4){
             $('#points').show();
         }else{
             $('#points').hide();
         }

    }
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }
    /**
     * 保存幻灯信息
     */
    function saveSlide(){
        var filed = new Array('type','name','cover');
        for(var i= 0;i<filed.length;i++){
            if(!$("#"+filed[i]).val()){
                layer.msg('请完善您的数据');
                return;
            }
        }

        var senddata = $('#goods-form').serialize();
        var load_index = layer.load(2,{
            shade: [0.1,'#333'],
            time: 10*1000
        });

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/meeting/savePrize',
            'data'  : senddata,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(load_index);
                layer.msg(ret.em,{
                    time:2000
                },function(){
                    if(ret.ec == 200){
                        window.location.href='/wxapp/meeting/prizeList';
                    }
                });
            }
        });
    }
</script>


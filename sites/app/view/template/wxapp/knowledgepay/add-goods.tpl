<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
    .pintuan-type .ticket{
        margin-left: 207px;
    }
</style>

<{include file="../../manage/common-kind-editor.tpl"}>
<{if $isAdd != 'edit'}>
<div class="choose-pintuan" id="div-type">
    <h3>选择创建课程类型</h3>
    <div class="pintuan-type" >
        <div class="type-item" data-type="1">
            <a href="#">
                <div class="ticket ticket-red">
                    <span>图文</span>
                </div>
            </a>
        </div>
        <div class="type-item" data-type="2">
            <a href="#">
                <div class="ticket ticket-blue">
                    <span>音频</span>
                </div>
            </a>
        </div>
        <div class="type-item" data-type="3">
            <a href="#">
                <div class="ticket ticket-green">
                    <span>视频</span>
                </div>
            </a>
        </div>
    </div>
</div>
<{/if}>

<div ng-app="ShopIndex" id="div-add" ng-controller="ShopInfoController" style="display: none;">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/knowledgepay/goodsList"> 返回 </a></small> | 新增/编辑课程信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="type" name="g_knowledge_pay_type" value="<{if $row}><{$row['g_knowledge_pay_type']}><{else}>0<{/if}>" data-need="required" placeholder="请选择类型">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['g_id']}><{else}>0<{/if}>">
                                        <div class="step-pane active" id="step1" >
                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>课程名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写课程名称" required="required" value="<{if $row}><{$row['g_name']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>作者：</label>
                                                            <div class="control-group">
                                                                <select name="g_label" id="g_label" class="form-control">
                                                                    <option value="0">请选择课程讲师</option>
                                                                    <{foreach $teacherList as $val}>
                                                                <option <{if $row && $row['g_label'] eq $val['akt_id']}>selected<{/if}> value="<{$val['akt_id']}>"><{$val['akt_name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>课程总数：</label>
                                                            <div class="control-group">
                                                                <input type="number" class="form-control" id="g_knowledge_total" name="g_knowledge_total" placeholder="请填写课程总数"  value="<{if $row}><{$row['g_knowledge_total']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>课程售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" placeholder="请填写课程售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="form-group" style=" <{if $menuType eq 'toutiao' && $acType eq 27}><{else}>display:none;<{/if}>" >
                                                            <label class="control-label">会员价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_vip_price" name="g_vip_price" placeholder="请填写会员价"  value="<{if $row}><{$row['g_vip_price']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">销量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_sold" name="g_sold" placeholder="请填写销量" required="required" value="<{if $row}><{$row['g_sold']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="kind2" class="control-label">商品分类：</label>
                                                            <div class="control-group" id="customCategory">

                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="cover-format1">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>课程封面图(640 * 640)：</label>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover">修改(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="cover-format2">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>课程封面图(640 * 360)：</label>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="360" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_485_260.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="360" data-dom-id="upload-cover">修改(<small style="font-size: 12px;color:#999">建议尺寸：640 x 360 像素</small>)</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="cover-format11">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>课程封面图(640 * 640)：</label>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover1" id="upload-cover1"  src="<{if $row && $row['g_cover1']}><{$row['g_cover1']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover1"  class="avatar-field bg-img" name="g_cover1" value="<{if $row && $row['g_cover1']}><{$row['g_cover1']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover1">修改(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="cover-format21">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>课程封面图(640 * 360)：</label>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="360" data-dom-id="upload-cover1" id="upload-cover1"  src="<{if $row && $row['g_cover1']}><{$row['g_cover1']}><{else}>/public/manage/img/zhanwei/zw_fxb_485_260.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover1"  class="avatar-field bg-img" name="g_cover1" value="<{if $row && $row['g_cover1']}><{$row['g_cover1']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="360" data-dom-id="upload-cover1">修改(<small style="font-size: 12px;color:#999">建议尺寸：640 x 360 像素</small>)</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>推荐课程：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_is_top" id="recommend1" value="1" <{if $row && $row['g_is_top'] eq 1}>checked<{/if}>>
                                                                        <label for="recommend1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_is_top" id="recommend2" value="0"  <{if !($row && $row['g_is_top'] eq 1)}>checked<{/if}>>
                                                                        <label for="recommend2">否</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>是否新品：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_special" id="special1" value="1" <{if $row && $row['g_special'] eq 1}>checked<{/if}>>
                                                                        <label for="special1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_special" id="special2" value="0"  <{if !($row && $row['g_special'] eq 1)}>checked<{/if}>>
                                                                        <label for="special2">否</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['g_weight']}><{else}>1<{/if}>" name="g_weight" id="g_weight"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越大排序越靠前</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">课程标签：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_custom_label" name="g_custom_label" placeholder="请填写课程标签,不同标签以空格隔开"  value="<{if $row}><{$row['g_custom_label']}><{/if}>" >
                                                                <p class="tip">不同标签以空格隔开</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name" class="control-label">留言模板：</label>
                                                            <div class="control-group">
                                                                <select name="g_message_tpid" id="g_message_tpid" class="form-control">
                                                                    <option value="0">请选择留言模板</option>
                                                                    <{foreach $messageListData as $val}>
                                                                <option <{if $row && $row['g_message_tpid'] eq $val['amt_id']}>selected<{/if}> value="<{$val['amt_id']}>"><{$val['amt_name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                                <div class="help-inline">
                                                                    <a href="/wxapp/goods/addMessageList" target="_blank" class="new-window" style="float: right;position: relative;top: -23px;">新建</a>
                                                                </div>
                                                                <p class="tip">若未设置模板可点击右侧新建模板</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">课程简介：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" id="g_brief" name="g_brief" placeholder="课程简介" ><{if $row}><{$row['g_brief']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">课程详情：</label>
                                                            <div class="control-group">
                                                                <textarea class="form-control" style="width:80%;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="课程详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <{if $row && $row['g_detail']}><{$row['g_detail']}><{/if}>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_detail" />
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </form>
                                </div>
                                <div class="row-fluid wizard-actions" style="text-align: center">
                                    <button class="btn btn-primary" onclick="saveGoods('save');">
                                        保存
                                    </button>
                                </div>
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
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>

<script type="text/javascript">
    jQuery(function($) {

        if('<{$isAdd}>' == 'edit'){
            deal_show_hide_by_type('<{$row['g_knowledge_pay_type']}>')
        }

        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
            if(info.step == 1 && info.direction == 'next'){
                if(!checkBasic()) return false;
            }else if(info.step == 2 && info.direction == 'next'){
                if(!checkImg()) return false;
            }
        }).on('finished', function(e) {
            saveGoods('step');
        });

        $('.type-item').on('click',function(){
            var type = $(this).data('type');
            if(type){
                deal_show_hide_by_type(type);
            }
        });

        //获取自定义商品分类
        var kind = 0 ;
        <{if $row && $row['g_kind2']}>
            kind = <{$row['g_kind2']}>;
        <{/if}>
        customerGoodsCategory(kind,'<{$independent}>');

        function deal_show_hide_by_type(type){
            $('#type').val(type);
            $('#div-type').hide();
            $('#div-add').show();
            if(type == 1 || type == 2){
                $('#cover-format2').remove();
                $('#cover-format11').remove();
            }else{
                $('#cover-format1').remove();
                $('#cover-format21').remove();
            }
        }

        $('.product-leibie').on('click', 'li', function(event) {
            $(this).addClass('selected').siblings('li').removeClass('selected');
            var id = $(this).data('id');
            $('#g_c_id').val(id);
        });

        // 初始化库存是否可输入
        var panelLen = parseInt($("#panel-group").find('.panel').length);
        if(panelLen>0){
            $("#g_stock").attr("readonly",true);
        }
        // 统计课程规格所有库存
        $("#panel-group").on('input propertychange', 'input[name^="format_stock"]', function(event) {
            event.preventDefault();
            var that = $(this);
            var parElem = that.parents('#panel-group');
            var sumStock = 0;
            parElem.find('input[name^="format_stock"]').each(function(index, el) {
                sumStock += parseInt($(this).val());
            });
            $("#g_stock").val(sumStock);
        });
    });
    /**
     * 第二步检查基本信息
     * */
    function checkBasic(){
        var check   = new Array('g_name','g_price');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp){
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        return true;
    }

    /**
     * 第三步，检查图片
     * @returns {boolean}
     */
    function checkImg(){
        var g_cover = $('#g_cover').val();
        if(!g_cover){
            layer.msg('请上传封面图');
            return false;
        }
        return true;
    }

    /**
     * 保存课程信息
     */
    function saveGoods(){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/saveGoods',
            'data'  : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.href='/wxapp/knowledgepay/goodsList';
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            $('#'+nowId).attr('src',allSrc[0]);
            if(nowId == 'upload-cover'){
                $('#g_cover').val(allSrc[0]);
            }
            if(nowId == 'upload-cover1'){
                $('#g_cover1').val(allSrc[0]);
            }
        }
    }


</script>

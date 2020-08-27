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

    .title-tip{
        padding-top: 5px;
        padding-bottom: 8px;
        margin-left: 15px;
        color:#999;
    }

</style>
<{include file="../common-kind-editor.tpl"}>
<div ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/meal/goods"> 返回 </a></small> | 新增/编辑商品信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">

                                <hr />
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['g_id']}><{else}>0<{/if}>">
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>商品名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写商品名称" required="required" value="<{if $row}><{$row['g_name']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>商品售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写商品售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">商品销量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_sold" name="g_sold"  placeholder="请填写商品销量"  value="<{if $row}><{$row['g_sold']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price" class="control-label"><font color="red">*</font>是否参与满减活动：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input class="ace ace-switch ace-switch-5" name="g_join_act" id="g_join_act" <{if !$row || $row['g_join_act']}>checked<{/if}> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">餐盒费：</label>
                                                            <div class="control-group">
                                                                <div class="input-group"  style="width:160px;">
                                                                    <div class="input-group-addon">￥</div>
                                                                    <input type="text" class="form-control" name="g_unified_fee" value="<{if $row}><{$row['g_unified_fee']}><{/if}>"  placeholder="餐盒费">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>商品分类：</label>
                                                            <div class="control-group">
                                                                <select id="g_kind1" name="g_kind1" class="form-control">
                                                                    <{foreach $category as $key => $val}>
                                                                    <option <{if $row && $row['g_kind1'] eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>商品封面图：</label>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover">修改(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>首页推荐商品：</label>
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
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['g_weight']}><{else}>1<{/if}>" name="g_weight" id="g_weight"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越大排序越靠前</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>库存类型：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_stock_type" id="stockType1" value="1" <{if !$row || $row['g_stock_type'] == 1}>checked<{/if}>>
                                                                        <label for="stockType1">总库存</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_stock_type" id="stockType2" value="2"  <{if $row && $row['g_stock_type'] == 2}>checked<{/if}>>
                                                                        <label for="stockType2">单日库存</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group all_stock">
                                                            <label class="control-label"><font color="red">*</font>商品库存：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_stock" name="g_stock" placeholder="商品库存数量" required="required" value="<{if $row}><{$row['g_stock']}><{/if}>"  style="width:160px;">
                                                                <p class="tip">
                                                                    添加规格以后库存数量不更手动更改
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group day_stock">
                                                            <label class="control-label"><font color="red">*</font>单日库存：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_day_stock" name="g_day_stock" placeholder="商品库存数量" required="required" value="<{if $row}><{$row['g_day_stock']}><{/if}>"  style="width:160px;">
                                                                <p class="tip">
                                                                    添加规格以后库存数量不更手动更改
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>售卖方式：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_sold_type" id="g_sold_type1" value="0"  <{if $row && $row['g_sold_type'] eq 0}>checked<{/if}>>
                                                                        <label for="g_sold_type1">通用</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_sold_type" id="g_sold_type2" value="1" <{if $row && $row['g_sold_type'] eq 1}>checked<{/if}>>
                                                                        <label for="g_sold_type2">外卖</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_sold_type" id="g_sold_type3" value="2"  <{if $row && $row['g_sold_type'] eq 2}>checked<{/if}>>
                                                                        <label for="g_sold_type3">堂食</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">商品规格：</label>
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group">
                                                                    <!--存放商品规格-->
                                                                    <{foreach $format as $key=>$val}>
                                                                    <div class="panel" data-sort="format_id_<{$key}>">
                                                                        <input type="hidden" name="format_id_<{$key}>" value="<{$val['gf_id']}>">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" data-hid-id="<{$val['gf_id']}>" onclick="removeGuige(this)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>名称</label>
                                                                                        <input type="text" name="format_name_<{$key}>" class="form-control guigeName" value="<{$val['gf_name']}>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>价格</label>
                                                                                        <input type="text" name="format_price_<{$key}>" data-key="<{$key}>" onblur="toMathVIp( this )" class="form-control" value="<{$val['gf_price']}>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4 all_stock">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>总库存</label>
                                                                                        <input type="text" name="format_stock_<{$key}>" data-key="<{$key}>" onblur="toMathVIp( this )" class="form-control" value="<{$val['gf_stock']}>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4 day_stock">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>单日库存</label>
                                                                                        <input type="text" name="format_day_stock_<{$key}>" data-key="<{$key}>" onblur="toMathVIp( this )" class="form-control" value="<{$val['gf_day_stock']}>">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <{/foreach}>
                                                                </div>
                                                                <a href="javascript:;" class="ui-btn" onclick="addGuige()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加规格</a>
                                                                <input type="hidden" name="format-num" id="format-num" value="<{$formatNum}>">
                                                                <input type="hidden" name="format-sort" id="format-sort" value="<{$formatSort}>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>详情</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label">幻灯图：</label>
                                                            <div class="title-tip">幻灯图仅在拼团砍价秒杀等活动展示使用</div>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block;padding-left: 15px">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['gs_path']}>"  layer-pid="" src="<{$val['gs_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['gs_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['gs_id']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">商品详情：</label>
                                                            <div class="title-tip">商品详情仅在拼团砍价秒杀等活动展示使用</div>
                                                            <div class="control-group form-textarea">
                                                                <textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="商品详情"  rows="20" style=" text-align: left; resize:vertical;" >
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

                                <hr />
                                <div class="row-fluid wizard-actions">
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
<script type="text/javascript">
    var stockType = '<{$row['g_stock_type']}>'?'<{$row['g_stock_type']}>':1;
    jQuery(function($) {
        if(stockType == 2){
            $('.all_stock').hide();
            $('.day_stock').show();
        }else{
            $('.all_stock').show();
            $('.day_stock').hide();
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

        $('.product-leibie').on('click', 'li', function(event) {
            $(this).addClass('selected').siblings('li').removeClass('selected');
            var id = $(this).data('id');
            $('#g_c_id').val(id);
        });
        formatSort();

        // 初始化库存是否可输入
        /*var panelLen = parseInt($("#panel-group").find('.panel').length);
        if(panelLen>0){
            $("#g_stock").attr("readonly",true);
        }*/
        // 统计商品规格所有库存
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
        var format = $('#format-num').val();
        var check   = new Array('g_name','g_price');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp && format == 0){
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
     * 保存商品信息
     */
    function saveGoods(type){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/meal/saveGood',
            'data'  : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.href='/wxapp/meal/goods';
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
        }
    }


    /*移除规格*/
    function removeGuige(elem){
        var panelBox = $(elem).parents(".panel");
        panelBox.remove();
        var panelNum = $('#format-num').val();
        var is_old   = $(elem).data('hid-id');
        if(is_old == 0){ //删除数据库存在的，则不递减
            panelNum -- ; //递减
        }
        var panel = $("#panel-group .panel").length;
        if(panel == 0){
            $("#g_price").attr("readonly",false);
            $("#g_stock").attr("readonly",false);
        }else{
            $("#g_price").attr("readonly",true);
            $("#g_stock").attr("readonly",true);
        }
        $('#format-num').val(panelNum);
    }
    /*添加规格*/
    function addGuige(){
        var key  = parseInt($('#format-num').val());
        key ++;
        var html = get_format_html(key);
        $("#panel-group").append(html);
        $('#format-num').val(key);
        $("#g_price").attr("readonly",true);
        $("#g_stock").attr("readonly",true);
        formatSort();
        sortString();
        if(stockType == 2){
            $('.all_stock').hide();
            $('.day_stock').show();
        }else{
            $('.all_stock').show();
            $('.day_stock').hide();
        }
    }

    function get_format_html(key){
        var _html   = '<div class="panel" data-sort="format_id_'+key+'">';
        _html       += '<div class="panel-collapse">';
        _html       += '<a href="javascript:;" class="close" onclick="removeGuige(this)">×</a>';
        _html       += '<div class="panel-body">';

        _html       += '<input type="hidden" name="format_id_'+key+'" value="0">';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>名称</label>';
        _html       += '<input type="text" class="form-control guigeName" name="format_name_'+key+'"  value="规格#'+key+'">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>价格</label>';
        _html       += '<input type="text" class="form-control"  data-key="'+key+'" onblur="toMathVIp( this )"  name="format_price_'+key+'" value="">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4 all_stock">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>总库存</label>';
        _html       += '<input type="text" class="form-control"  data-key="'+key+'" onblur="toMathVIp( this )"  name="format_stock_'+key+'" value="">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4 day_stock">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>单日库存</label>';
        _html       += '<input type="text" class="form-control"  data-key="'+key+'" onblur="toMathVIp( this )"  name="format_day_stock_'+key+'" value="">';
        _html       += '</div></div>';

        _html       += '</div><!---panel-body----> </div><!---panel-collapse----></div><!---panel---->';
        return _html;
    }

    function formatSort(){
        $("#panel-group").sortable({
            update: function( event, ui ) {
                sortString();
            }
        });
    }
    function sortString(){
        var sortString="";
        $('#panel-group').find(".panel").each(function(){
            var sortid = $(this).data("sort");
            sortString +=sortid+",";
        });
        $("#format-sort").val(sortString);
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
                    $('#g_cover').val(allSrc[0]);
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

    $('input[name="g_stock_type"]').click(function(){
        stockType = $(this).val();
        if($(this).val() == 2){
            $('.all_stock').hide();
            $('.day_stock').show();
        }else{
            $('.all_stock').show();
            $('.day_stock').hide();
        }
    })
</script>

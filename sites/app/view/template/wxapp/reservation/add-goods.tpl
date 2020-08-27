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

    #gift-group{
        float: right;
        width: 81%;
        margin-top: -45px;
    }
    .expert-select{
        display: inline-block !important;
    }
    .btn-remove-expert{
        display: inline-block !important;
        margin-left: 5px !important;
    }
    .expert-select-div{
        margin: 6px 0 !important;
    }

</style>
<{include file="../../manage/common-kind-editor.tpl"}>

<div ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/reservation/goods"> 返回 </a></small> | 新增/编辑产品信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
                                    <ul class="wizard-steps">
                                        <li data-target="#step1" <{if $row}>class="complete" <{else}>class="active"<{/if}>>
                                        <span class="step">1</span>
                                        <span class="title">基本信息</span>
                                        </li>

                                        <li data-target="#step2">
                                            <span class="step">2</span>
                                            <span class="title">产品图片</span>
                                        </li>

                                        <li data-target="#step3">
                                            <span class="step">3</span>
                                            <span class="title">产品详情</span>
                                        </li>
                                    </ul>
                                </div>

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
                                                            <label for="name" class="control-label"><font color="red">*</font>产品名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写产品名称" required="required" value="<{if $row}><{$row['g_name']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">产品原价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_ori_price" name="g_ori_price" placeholder="原价" required="required" value="<{if $row}><{$row['g_ori_price']}><{/if}>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>产品售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写产品售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  style="width:160px;display: inline-block">
                                                                <input type="text" class="form-control" id="g_unit" name="g_unit" placeholder="单位"  value="<{if $row}><{$row['g_unit']}><{/if}>"  style="width:160px;display: inline-block">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>产品信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">视频链接：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_video_url" name="g_video_url" placeholder="请填写产品的视频链接" required="required" value="<{if $row}><{$row['g_video_url']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>产品分类：</label>
                                                            <div class="control-group">
                                                                <select id="g_kind2" name="g_kind2" class="form-control">
                                                                    <{foreach $category as $key => $val}>
                                                                    <option <{if $row && $row['g_kind2'] eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label">产品所属专家：</label>
                                                            <div class="control-group">

                                                                <a class="btn btn-xs btn-blue" onclick="addExpert()" style="display: inline-block">添加</a>
                                                                <span style="padding-left: 10px;color: red">不添加所属专家则默认为全部专家</span>
                                                                <div class="expert-select-box">
                                                                    <{if $expertList}>
                                                                    <{foreach $expertList as $expert}>
                                                                    <div class="expert-select-div expert-select_<{$expert['arge_sort']}>">
                                                                    <select class="form-control expert-select" style="width: 80%">
                                                                        <{foreach $list as $key => $val}>
                                                                    <option <{if $expert['arge_e_id'] eq $val['g_id']}>selected<{/if}> value="<{$val['g_id']}>"><{$val['g_name']}></option>
                                                                        <{/foreach}>
                                                                    </select>
                                                                    <a class="btn btn-xs btn-default btn-remove-expert" onclick="removeExpert(<{$expert['arge_sort']}>)">移除</a>
                                                                        <input type="hidden" class="expert-sort" value="<{$expert['arge_sort']}>">
                                                                    </div>
                                                                    <{/foreach}>
                                                                    <{/if}>
                                                                </div>
                                                                <!--
                                                                <select id="g_kind3" name="g_kind3" class="form-control">
                                                                    <option value="0">所有</option>
                                                                    <{foreach $list as $key => $val}>
                                                                <option <{if $row && $row['g_kind3'] eq $val['g_id']}>selected<{/if}> value="<{$val['g_id']}>"><{$val['g_name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                                -->

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">已预约数量：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['g_sold']}><{else}>1<{/if}>" name="g_sold" id="g_sold"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">可预约名额：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['g_stock']}><{else}>1<{/if}>" name="g_stock" id="g_stock"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['g_weight']}><{else}>1<{/if}>" name="sort" id="g_weight"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越大排序越靠前</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>规格</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">产品规格：</label>
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group">
                                                                    <!--存放产品规格-->
                                                                    <{foreach $format as $key=>$val}>
                                                                    <div class="panel" data-sort="format_id_<{$key}>">
                                                                        <input type="hidden" name="format_id_<{$key}>" value="<{$val['gf_id']}>">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" data-hid-id="<{$val['gf_id']}>" onclick="removeGuige(this)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-6">
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
                                                        <span>下单留言</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">留言模板：</label>
                                                            <div class="control-group">
                                                                <div class="col-xs-4">
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step-pane" id="step2">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">产品封面图(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</h3>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover">修改</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">产品幻灯图(<small>最多五张，尺寸 810 x 540 像素</small>)</h3>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['gs_path']}>"  layer-pid="" src="<{$val['gs_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['gs_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['gs_id']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="810" data-height="540" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>VR全景</span>
                                                    </div>
                                                    <div class="group-info">
                                                            <div class="form-group">
                                                                <div class="control-group" style="margin-left: 0px">
                                                                    <input type="text" class="form-control" id="g_vr" name="g_vr" placeholder="请填写VR全景连接" required="required" value="<{if $row}><{$row['g_vr_url']}><{/if}>">
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="step-pane" id="step3">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>简介详情</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label">产品简介：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" id="g_brief" name="g_brief" placeholder="产品简介" style="max-width: 850px;"><{if $row}><{$row['g_brief']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">产品详情：</label>
                                                            <div class="control-group">
                                                                <textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="产品详情"  rows="20" style=" text-align: left; resize:vertical;" >
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
                                    <{if $row}>
                                    <button class="btn btn-primary" onclick="saveGoods('save');">
                                        保存
                                    </button>
                                    <{/if}>
                                    <button class="btn btn-prev">
                                        <i class="icon-arrow-left"></i>
                                        上一步
                                    </button>

                                    <button class="btn btn-success btn-next" data-last="完成">
                                        下一步
                                        <i class="icon-arrow-right icon-on-right"></i>
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
    jQuery(function($) {

        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
            console.log(info.step);
            /*  去掉产品类目不再做验证*/
            /*
            if(info.step == 1 && info.direction == 'next') {
                if(!checkCategory()) return false;
            }else
            */
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
        //获取自定义产品分类
        var kind = 0 ;
        <{if $row && $row['g_kind2']}>
        kind = <{$row['g_kind2']}>;
        <{/if}>
        customerGoodsCategory(kind);

        // 初始化库存是否可输入
        var panelLen = parseInt($("#panel-group").find('.panel').length);
        /*if(panelLen>0){
            $("#g_stock").attr("readonly",true);
        }*/
        // 统计产品规格所有库存
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
        // 产品标签选择
        $(".goods-tagbox").on('click', 'span', function(event) {
            event.preventDefault();
            var _this = $(this);
            $(this).toggleClass('active');
            $(this).parents('.goods-tagbox').find('span').each(function(index, el) {
                var id = $(this).data('id');
                if($(this).hasClass('active')){
                    $("#good_tag_"+id).val(1);
                }else{
                    $("#good_tag_"+id).val(0);
                }
            });
        });
        //配送标签选择
        $(".delivery-tagbox").on('click', 'span', function(event) {
            event.preventDefault();
            var _this = $(this);
            $(this).toggleClass('active');
            $(this).parents('.delivery-tagbox').find('span').each(function(index, el) {
                var id = $(this).data('id');
                if($(this).hasClass('active')){
                    $("#delivery_tag_"+id).val(1);
                }else{
                    $("#delivery_tag_"+id).val(0);
                }
            });
        });
    });


    function addExpert() {

        var count = $('.expert-select').length;
        // if(count >= 5){
        //     layer.msg('最多添加5条相关文章');
        //     return false;
        // }else{
        //
        // }
        var _html = '';
        _html += '<div class="expert-select-div expert-select_'+ count +'" style="margin: 6px 0;"><select style="width: 80% !important;display:inline-block !important" class="form-control expert-select"><{foreach $list as $key=>$val}><option value="<{$val['g_id']}>"><{$val['g_name']}></option><{/foreach}></select><a class="btn btn-xs btn-default btn-remove-expert" onclick="removeExpert('+ count +')" style="display:inline-block;margin-left:5px">移除</a><input type="hidden" class="expert-sort" value="'+count+'"></div>';
        console.log(_html);
        $('.expert-select-box').append(_html);
    }

    function removeExpert(index) {
        $(".expert-select_"+index).remove();
    }

    /**
     * 第一步检查产品类目
     * */
    function checkCategory(){
        var temp = $('#g_c_id').val();
        if(!temp){
            var msg = $('#g_c_id').attr('placeholder');
            layer.msg(msg);
            return false;
        }
        return true;
    }

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
        var discount = $('#g_vip_discount').val();
        if(discount > 100 || discount < 1){
            layer.msg('VIP折扣1－100之间整数');
            return false
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
        var slide = 0;
        for(var i=0;i<=4;i++){
            var temp = $('#slide_'+i).val();
            if(temp) {
                slide = parseInt(slide) + 1;
                console.log(slide);
            }
        }
        if(slide == 0){
            layer.msg('请上传幻灯');
            return false;
        }
        return true;
    }

    /**
     * 保存产品信息
     */
    function saveGoods(type){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        var expertInfo = [];
        //保存相关文章
        $('.expert-select-div').each(function () {
            var eid = $(this).find('.expert-select').val();
            var sort = $(this).find('.expert-sort').val();

            selectInfo = {
                'eid' : eid,
                'sort' : sort
            };
            expertInfo.push(selectInfo);
        });
        console.log(expertInfo);

        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/reservation/saveGood',
            'data'  : $('#goods-form').serialize()+'&expertInfo='+JSON.stringify(expertInfo),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200 && type == 'step'){
                    window.location.href='/wxapp/reservation/goods';
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
    /**
     * 图片删除功能
     * 以图片容器为准，容器中的图片img标签结果<div><p><img>
     */
//    $(".pic-box").on('click', '.delimg-btn', function(event) {
//        var id = $(this).parent().parent().attr('id');
//        event.preventDefault();
//        event.stopPropagation();
//        var delElem = $(this).parent();
//        layer.confirm('确定要删除吗？', {
//            title:false,
//            closeBtn:0,
//            btn: ['确定','取消'] //按钮
//        }, function(){
//            delElem.remove();
//            var num = parseInt($('#'+id+'-num').val());
//            console.log(num);
//            console.log(id);
//            if(num > 0){
//                $('#'+id+'-num').val(parseInt(num) - 1);
//            }
//            layer.msg('删除成功');
//        });
//    });

    $('.math-vip').blur(function(){
        var discount = $(this).val();
    });


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
            $("#g_gift1").attr("readonly",false);
            $("#g_gift2").attr("readonly",false);
            $("#g_gift3").attr("readonly",false);
        }else{
            $("#g_price").attr("readonly",true);
            $("#g_stock").attr("readonly",true);
        }
        $('#format-num').val(panelNum);
    }
    /*添加规格*/
    function addGuige(){
        //var id = $("#panel-group .panel").length+1;
        // $("#panel-template .guige").text("规格#"+id);
        //$("#panel-template input.guigeName").attr("value","规格#"+id);
        var key  = parseInt($('#format-num').val());
        key ++;
        var html = get_format_html(key);//$("#panel-template").html();
        $("#panel-group").append(html);
        $('#format-num').val(key);
        $("#g_price").attr("readonly",true);
        $("#g_stock").attr("readonly",true);
        $("#g_gift1").attr("readonly",true);
        $("#g_gift2").attr("readonly",true);
        $("#g_gift3").attr("readonly",true);
        formatSort();
        sortString();
    }

    function get_format_html(key){
        var _html   = '<div class="panel" data-sort="format_id_'+key+'">';
        _html       += '<div class="panel-collapse">';
        _html       += '<a href="javascript:;" class="close" onclick="removeGuige(this)">×</a>';
        _html       += '<div class="panel-body">';

        _html       += '<input type="hidden" name="format_id_'+key+'" value="0">';

        _html       += '<div class="col-xs-6">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>名称</label>';
        _html       += '<input type="text" class="form-control guigeName" name="format_name_'+key+'"  value="规格#'+key+'">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>价格</label>';
        _html       += '<input type="text" class="form-control"  data-key="'+key+'" onblur="toMathVIp( this )"  name="format_price_'+key+'" value="">';
        _html       += '</div></div>'
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
        console.log(sortString);
    }

</script>


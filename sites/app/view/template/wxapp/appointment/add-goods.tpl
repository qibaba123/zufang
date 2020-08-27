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

    .option-delete {
        height: 25px;
        line-height: 25px;
        text-align: center;
        width: 25px;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 22px;
        font-weight: 900;
        cursor: pointer;
    }

</style>
<{include file="../common-second-menu-new.tpl"}>
<{include file="../../manage/common-kind-editor.tpl"}>

<div ng-app="chApp" ng-controller="chCtrl" id="mainContent">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/appointment/goods"> 返回 </a></small> | 新增/编辑项目信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
                                    <ul class="wizard-steps">
                                        <!--
                                        <li data-target="#step1"  <{if $row}>class="complete" <{else}>class="active"<{/if}>>
                                        <span class="step">1</span>
                                        <span class="title">项目类目</span>
                                        </li>
                                        -->
                                        <li data-target="#step1" <{if $row}>class="complete" <{else}>class="active"<{/if}>>
                                        <span class="step">1</span>
                                        <span class="title">基本信息</span>
                                        </li>

                                        <li data-target="#step2">
                                            <span class="step">2</span>
                                            <span class="title">项目图片</span>
                                        </li>

                                        <li data-target="#step3">
                                            <span class="step">3</span>
                                            <span class="title">项目详情</span>
                                        </li>
                                    </ul>
                                </div>

                                <hr />
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['g_id']}><{else}>0<{/if}>">
                                        <!--
                                        <div class="step-pane <{if !$row}>active<{/if}>" id="step1" >
                                            <h3 class="lighter block green">所属类目</h3>
                                            <div class="product-leibie">
                                                <ul>
                                                    <{foreach $category as $val}>
                                                    <li <{if $row && $row['g_c_id'] eq $val['c_id']}>class="selected"<{/if}> data-id="<{$val['c_id']}>">
                                                    <div data-id="<{$val['c_id']}>"><{$val['c_name']}></div>
                                                    </li>
                                                    <{/foreach}>
                                                </ul>
                                                <input type="hidden" id="g_c_id" name="g_c_id" value="<{if $row}><{$row['g_c_id']}><{/if}>" placeholder="请选择项目类目">
                                            </div>
                                        </div>
                                        -->
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>预约服务名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写项目名称" required="required" value="<{if $row}><{$row['g_name']}><{/if}>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="g_appointment_kind" class="control-label">预约服务分类：</label>
                                                            <select name="g_appointment_kind" id="g_appointment_kind" class="form-control" style="max-width: 70%">
                                                                <option value="0">无分类</option>
                                                                <{foreach $category_select as $key => $val}>
                                                                <option value="<{$key}>" <{if $key eq $row['g_appointment_kind']}>selected<{/if}>><{$val}></option>
                                                                <{/foreach}>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>预约服务单价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写项目售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>项目信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>项目服务时长：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_appointment_length" name="g_appointment_length" onblur="mathVIp()" placeholder="请填写预约时长"  value="<{if $row}><{$row['g_appointment_length']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>项目服务日期：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_appointment_date" name="g_appointment_date" onblur="mathVIp()" placeholder="请填写预约日期"  value="<{if $row}><{$row['g_appointment_date']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>项目服务时间：</label>
                                                            <div class="control-group">
                                                                <input type="text" id="start_time" name="start_time" class="cus-input time form-control" style="width: 160px;float: left" value="<{if $row && $row['g_appointment_time']}><{$row['g_appointment_time'][0]}><{/if}>"/>
                                                                <input type="text" id="end_time" name="end_time" class="cus-input time form-control" style="width: 160px"  value="<{if $row && $row['g_appointment_time']}><{$row['g_appointment_time'][1]}><{/if}>"/>
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
                                                            <label class="control-label"><font color="red">*</font>首页推荐项目：</label>
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='info-group-box'>
                                                <div class='info-group-inner'>
                                                    <div class='group-title'>
                                                        <span>报名设置</span>
                                                    </div>
                                                    <div class='group-info'>
                                                          <!-- 新增的头像显示与报名人数限制开关 -->
                                         
                                                          <div class='form-group'>
                                                            <label class='control-label'>报名人数：</label>
                                                            <div class='control-group'>
                                                                <input class='form-control' type="number" name="g_pnumber_limit" style='width: 160px;' placeholder="报名人数" oninput="this.value=this.value.replace(/\D/g,'')" 
                                                                    value="<{if $row && $row['g_number_limit']}><{$row['g_number_limit']}><{else}>0<{/if}>"
                                                                >
                                                                <p class='tip'>报名人数为空或者0时不限制上限人数</p>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='control-label'>单人最多可报名次数：</label>
                                                            <div class='control-group'>
                                                                <input class='form-control' type="number" name="g_limit" style='width: 160px;' placeholder="单人最多可报名次数" oninput="this.value=this.value.replace(/\D/g,'')" 
                                                                    value="<{if $row && $row['g_limit']}><{$row['g_limit']}><{else}>0<{/if}>"
                                                                >
                                                                <p class='tip'>为空或者0时不限制</p>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='control-label'>单人单日可报名次数：</label>
                                                            <div class='control-group'>
                                                                <input class='form-control' type="number" name="g_day_limit" style='width: 160px;' placeholder="报名人数" oninput="this.value=this.value.replace(/\D/g,'')" 
                                                                    value="<{if $row && $row['g_day_limit']}><{$row['g_day_limit']}><{else}>0<{/if}>"
                                                                >
                                                                <p class='tip'>为空或者0时不限制</p>
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='control-label'>阅读量：</label>
                                                            <div class='control-group'>
                                                                <input class='form-control' type="number" name="g_show_num" style='width: 160px;' placeholder="阅读量" oninput="this.value=this.value.replace(/\D/g,'')" 
                                                                    value="<{if $row && $row['g_show_num']}><{$row['g_show_num']}><{else}>0<{/if}>"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='control-label'>转发量：</label>
                                                            <div class='control-group'>
                                                                <input class='form-control' type="number" name="g_forward" style='width: 160px;' placeholder="转发量" oninput="this.value=this.value.replace(/\D/g,'')" 
                                                                    value="<{if $row && $row['g_forward']}><{$row['g_forward']}><{else}>0<{/if}>"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                显示报名人列表：
                                                            </label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="show_join_list" id="join_check_1" value='1'
                                                                        <{if $row && $row['g_show_join_list'] eq 1}>
                                                                        checked
                                                                        <{/if}>
                                                                        >
                                                                        <label for="join_check_1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="show_join_list" id="join_check_2" value="0" 
                                                                        <{if $row && $row['g_show_join_list'] eq 0}>
                                                                        checked
                                                                        <{/if}>
                                                                        >
                                                                        <label for="join_check_2">否</label>
                                                                    </span>
                                                                </div>
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
                                                            <label for="name" class="control-label">项目规格：</label>
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group">
                                                                    <!--存放项目规格-->
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
                                                        <span>留言</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group">
                                                                    <div class="panel" ng-repeat="message in messageList track by $index">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" ng-click="delIndex('messageList',$index)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <input type="text"  maxlength="5" style="width: 100%;max-width: 100%"  class="form-control" ng-model="message.name">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <select class="form-control" ng-model="message.type" style="width: 100%;max-width: 100%"   ng-options="x.type as x.name for x in messageType" ></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group">
                                                                                        <label for=""  style="padding: 6px 3px">
                                                                                            <input type="checkbox" name="require" ng-model="message.require"  ng-checked="message.require"> 必填
                                                                                        </label>
                                                                                        <label for=""  style="padding: 6px 3px" ng-if="message.type=='text'">
                                                                                            <input type="checkbox" name="date" ng-model="message.multi"  ng-checked="message.multi"> 多行
                                                                                        </label>
                                                                                        <label for=""  style="padding: 6px 3px" ng-if="message.type=='time'">
                                                                                            <input type="checkbox" name="date" ng-model="message.date"  ng-checked="message.date"> 日期
                                                                                        </label>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="options" ng-if="message.type=='radio' || message.type=='checkbox'" style="margin-top: 45px;padding: 0px 12px;">
                                                                                    <div ng-repeat="option in message.options track by $index" style="position:relative;display: inline-block;width=100px;margin-bottom: 10px;">
                                                                                        <div class="option-delete" ng-click="delOption($parent.$index, $index)"  style="top: 5px; right: 10px">×</div>
                                                                                        <input type="text" ng-model="option.title" class="form-control" style="margin-bottom: 10px;width: 80%;" />
                                                                                    </div>
                                                                                    <a href="javascript:;" class="ui-btn" ng-click="addOptions($index)" style="    margin: 3px 0;"><i class="icon-plus"></i>添加选择项</a>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:;" class="ui-btn" ng-click="addMessage()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加字段</a>
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
                                                            <h3 class="lighter block green">项目封面图(<small style="font-size: 12px;color:#999">建议尺寸：640 x 365 像素</small>)</h3>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="365" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="365" data-dom-id="upload-cover">修改</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">项目幻灯图(<small>最多五张，尺寸 750 x 360 像素</small>)</h3>
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
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="750" data-height="360" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
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
                                                            <label class="control-label">项目简介：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" id="g_brief" name="g_brief" placeholder="项目简介" style="max-width: 850px;"><{if $row}><{$row['g_brief']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">项目详情：</label>
                                                            <div class="control-group">
                                                                <textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="项目详情"  rows="20" style=" text-align: left; resize:vertical;" >
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
                                    <button class="btn btn-primary" ng-click="saveData()">
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
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.messageList = <{$messageList}>;
        console.log($scope.messageList);
        $scope.messageType = [
            {
                'type': 'text',
                'name': '文本格式'
            },
            {
                'type': 'number',
                'name': '数字格式'
            },
            {
                'type': 'email',
                'name': '邮箱'
            },
            {
                'type': 'date',
                'name': '日期'
            },
            {
                'type': 'time',
                'name': '时间'
            },
            {
                'type': 'idcard',
                'name': '身份证号'
            },
            {
                'type': 'image',
                'name': '图片'
            },
            {
                'type': 'mobile',
                'name': '手机号'
            },
            <{if in_array($appletCfg['ac_type'],[21,27])}>
                {
                    'type': 'radio',
                    'name': '单选框'
                },
                {
                    'type': 'checkbox',
                    'name': '多选框'
                },
            <{/if}>
        ];
        $scope.addSpec = function(){
            var data = {
                'name': '颜色',
                'value': []
            };
            $scope.spec.push(data);
        };
        $scope.addMessage = function () {
            var data = {
                'name': '留言',
                'type': 'text',
                'multi': false,
                'require': false,
                'options': [],
                'date' : false
            };
            $scope.messageList.push(data);
            console.log($scope.messageList);
        }

        $scope.addOptions = function (findex) {
            var option_Default = {
                'title': '选择项'
            };
            $scope.messageList[findex].options.push(option_Default);
        };

        $scope.delOption = function(i,index){
            $scope.messageList[i].options.splice(index,1);
        };

        $scope.doThis=function(type,findex,index){
            $scope[type][findex].value[index].img = imgNowsrc;
        };

        /*删除元素*/
        $scope.delIndex=function(type,index){
            console.log(index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(index,1);
                });
                layer.msg('删除成功');
            })
        }


        // 保存数据
        $scope.saveData = function(){
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var load_index = layer.load(
	                2,
	                {
	                    shade: [0.1,'#333'],
	                    time: 10*1000
	                }
	            );
	            $.ajax({
	                'type'   : 'post',
	                'url'   : '/wxapp/appointment/saveGood',
	                'data'  : $('#goods-form').serialize()+'&messageList='+JSON.stringify($scope.messageList),
	                'dataType'  : 'json',
	                'success'   : function(ret){
	                    layer.close(load_index);
	                    layer.msg(ret.em);
	                    window.location.reload();
	                }
	            });
	        });
        };
    jQuery(function($) {
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
            console.log(info.step);
            /*  去掉项目类目不再做验证*/
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
            $scope.saveData();
        });

        $('.product-leibie').on('click', 'li', function(event) {
            $(this).addClass('selected').siblings('li').removeClass('selected');
            var id = $(this).data('id');
            $('#g_c_id').val(id);
        });
        formatSort();
        //获取自定义项目分类
        var kind = 0 ;
        <{if $row && $row['g_kind2']}>
        kind = <{$row['g_kind2']}>;
        <{/if}>
        customerGoodsCategory(kind);

        // 初始化库存是否可输入
        var panelLen = parseInt($("#panel-group").find('.panel').length);
        if(panelLen>0){
            $("#g_stock").attr("readonly",true);
        }
        // 统计项目规格所有库存
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
        // 项目标签选择
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
    });
    }]);
    /**
     * 第一步检查项目类目
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
        var check   = new Array('g_name');
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
     * 保存项目信息
     */
    function saveGoods(type){
       /* var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/appointment/saveGood',
            'data'  : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200 && type == 'step'){
                    window.location.href='/wxapp/appointment/goods';
                }else{
                    layer.msg(ret.em);
                }
            }
        });*/
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
        formatSort();
        sortString();
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
    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>


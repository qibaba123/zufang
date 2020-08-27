<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<{if $isActivity == 1}>
    <{include file="../common-second-menu-new.tpl"}>
<{/if}>
<style type="text/css">
    h1, h2, h3, h4, h5, h6{
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif,"Microsoft yahei"!important;
    }
    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

    table {
        width: 100%;
        border: 1px solid #ecedf0;
        border-radius: 2px;
        table-layout: fixed;
        background: #fff;
        text-align: center;
    }

    table th {
        background: #f7f7f7;
        height: 50px;
        line-height: 50px;
        color: #404040;
        font-size: 14px;
        padding-left: 6px;
        padding-right: 6px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        position: relative;
        font-weight: 400;
        text-align: center;
    }

    table td.border-right {
        border-right: 1px solid #ecedf0;
        text-align: center;
    }

    table td {
        border-top: 1px solid #ecedf0;
        height: 52px;
        line-height: 22px;
        color: #666;
        font-size: 14px;
        padding-left: 6px;
        padding-right: 6px;
        word-wrap: break-word;
        border-right: 1px solid #ecedf0;
    }

    table td .form-control {
        max-width: 100%;
    }

    .delete {
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

    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        /*font-family: '黑体';*/
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .goods-selected{
        padding: 5px 2px;
        margin: 0 2px;
        position: relative;
    }
    .goods-selected-name{
        font-weight: bold;
        color: #38f;
        width: 90%;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }
    .goods-selected-button{
        width: 9%;
        display: inline-block;
        padding-left: 2px;
    }
    .add-related-box{
        text-align: center;
    }
    .related-info{
        margin-bottom: 10px;
        height: 35px;
        line-height: 35px;
    }
    .btn-remove-info{

    }
    .related-info-cate{
        width: 35%;
        float: left;
        margin-right: 10px;
    }
    .related-info-detail{
        width: 49%;
        float: left;
        margin-right: 20px;
    }
    .control-label{
        width: 134px !important;
    }
    .group-title{
        margin-right: 3px;
        font-size: 14px!important;
    }
    .info-group-inner .group-info{
        padding-left: 50px;
    }
    .info-group-inner .group-info .control-label{
        font-weight: normal;
    }
    .col-xs-4{
        padding-left: 0;
    }
    @media (max-width: 1480px){
        .xs-hidden-label{
            display: none;
        }
        .xs-hidden-info{
            margin-left: 0!important;
            padding-left: 0!important;
        }
        .ke-container{
            margin:0 auto!important;
        }
    }

</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<div  id="mainContent" ng-app="chApp" ng-controller="chCtrl">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter" style='font-size: 14px;font-weight: 500;'><a href="/wxapp/goods/index"><i class="fa icon-double-angle-left"></i>返回 </a> | <span style='color:#2c87d6;'>新增/编辑商品信息</span></h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main" style="padding: 0 !important;">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['g_id']}><{else}>0<{/if}>">

                                        <div class="step-pane active" id="step1" style="padding: 0 0 1px 0 !important;">
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
                                                            <label for="name" class="control-label">商品简介：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_brief" name="g_brief" placeholder="请填写商品简介" value="<{if $row}><{$row['g_brief']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group ori-price-form" ng-show=" isDiscuss != '1' ">
                                                            <label class="control-label">商品成本：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_cost" name="g_cost" placeholder="商品成本" value="<{if $row}><{$row['g_cost']}><{/if}>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group ori-price-form" ng-show=" isDiscuss != '1' ">
                                                            <label class="control-label">商品原价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_ori_price" name="g_ori_price" placeholder="原价" value="<{if $row}><{$row['g_ori_price']}><{/if}>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group price-form" ng-show=" isDiscuss != '1' ">
                                                            <label class="control-label"><font color="red">*</font>商品售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写商品售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  required="required" style="width:160px;display: inline-block;">
                                                                <span>*多规格商品请直接修改规格相关价格*</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group price-form">
                                                            <label class="control-label">团长分佣固定金额：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="goods_ratio_fixed" name="goods_ratio_fixed" placeholder=""  value="<{if $ratio}><{$ratio['asgd_ratio_fixed']}><{/if}>"  style="width:160px;display: inline-block">
                                                                <span>请填写数字类型，若不为空优先按照固定金额进行分佣</span>
                                                            </div>
                                                        </div>
                                                        <p></p>
                                                        <div class="form-group price-form">
                                                            <label class="control-label">团长分佣比例：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="goods_ratio" name="goods_ratio" placeholder=""  value="<{if $ratio}><{$ratio['asgd_1f_ratio']}><{/if}>"  style="width:160px;display: inline-block">
                                                                <span>%，请填写0-100的数字，不填则以团长分佣比例为准</span>
                                                            </div>
                                                        </div>
                                                     
                                                        <{if $sequenceShowAll == 1}>
                                                        <{if $show_area_leader==1}>
                                                         <div class="form-group price-form">
                                                            <label class="control-label">区域合伙人分佣比例：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="region_goods_ratio" name="region_goods_ratio" placeholder=""  value="<{if $region_ratio && $region_ratio['asrgd_1f_ratio'] > -1}><{$region_ratio['asrgd_1f_ratio']}><{/if}>"  style="width:160px;display: inline-block">
                                                                <span id="<{$region_ratio['asrgd_1f_ratio']}>">%，请填写0-100的数字，不填则以默认区域合伙人分佣比例为准</span>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <{/if}>
                                                        <div class="form-group price-form">
                                                            <label class="control-label">开始配送/发货时间：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="sequence_day" name="sequence_day" placeholder=""  value="<{if $row}><{$row['g_sequence_day']}><{/if}>"  style="width:160px;display: inline-block">
                                                                <span>天，不填写或0则以配送配置为准</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">销量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_sold" name="g_sold" placeholder="请填写销量" value="<{if $row}><{$row['g_sold']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kind2" class="control-label">商品分类：</label>
                                                            <div class="control-group" id="customCategory">

                                                            </div>
                                                        </div>
                                                        <{if $sequenceShowAll == 1}>
                                                        <div class="form-group">
                                                            <label for="" class="control-label">供应商：</label>
                                                            <div class="control-group">
                                                                <select name="g_supplier_id" id="g_supplier_id" class="form-control">
                                                                    <option value="0">无</option>
                                                                    <{foreach $supplierList as $val}>
                                                                    <option value="<{$val['id']}>" <{if $val['id'] == $row['g_supplier_id']}>selected<{/if}>><{$val['name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <div class="form-group">
                                                            <label class="control-label">商品标签：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_custom_label" name="g_custom_label" placeholder="请填写商品标签,不同标签以空格隔开"  value="<{if $row}><{$row['g_custom_label']}><{/if}>" >
                                                                <p class="tip">不同标签以空格隔开</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">单人限购：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_limit" name="g_limit" placeholder="不限购则为填写“0”" required="required" value="<{if $row}><{$row['g_limit']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                            <span style="color: red;margin-left:150px">注: 单人限购表示该商品对单人总限购数，0表示不限购</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">单人单日限购：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_day_limit" name="g_day_limit" placeholder="不限购则为填写“0”" required="required" value="<{if $row}><{$row['g_day_limit']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                            <span style="color: red;margin-left:150px">注: 单人单日限购表示该商品对每人每天的限购数，0表示不限购</span>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">单次最低购买：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_least_buy" name="g_least_buy" placeholder="不限购则为填写“0”" required="required" value="<{if $row}><{$row['g_least_buy']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                            <span style="color: red;margin-left:150px">注: 单次最低购买表示该商品一次最低购买多少件，0表示不限制。商品有规格时此配置无效</span>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<{if $row}><{$row['g_weight']}><{else}>1<{/if}>" name="g_weight" id="g_weight"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越大排序越靠前</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">访问量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_show_num" name="g_show_num" placeholder="请填写访问量" required="required" value="<{if $row}><{$row['g_show_num']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">虚拟购买人数：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_fake_buynum" name="g_fake_buynum" placeholder="虚拟购买人数" required="required" value="<{if $row}><{$row['g_fake_buynum']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                            <span style="color: red;margin-left:150px">用于与实际购买人数相加</span>
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
                                                            <label class="control-label">商品列表显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_applay_goods_show" class="ace ace-switch ace-switch-5" id="g_applay_goods_show" <{if ($row && $row['g_applay_goods_show']) || !$row}>checked<{/if}> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">是否参与会员折扣：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_join_discount" class="ace ace-switch ace-switch-5" id="g_join_discount" <{if ($row && $row['g_join_discount']) || !$row}>checked<{/if}> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- 新人专享 -->

                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>新人专享</span>
                                                </div>
                                                <div class="group-info">
                                                    <div class="form-group">
                                                        <label class="control-label">是否设置为新人专享：</label>
                                                        <div class="control-group">
                                                            <label style="padding: 4px 0;margin: 0;">
                                                                <input name="g_has_window" class="ace ace-switch ace-switch-5" id="g_has_window" <{if $row && $row['g_has_window'] == 2}>checked<{/if}> type="checkbox">
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">新人专享购买数量：</label>
                                                        <div class="control-group">
                                                            <input type="text" class="form-control" id="g_hotel_stock" name="g_hotel_stock" placeholder="新人专享购买数量"  value="<{if $row}><{$row['g_hotel_stock']}><{/if}>" style="width: 160px;">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">新人专享购买价格：</label>
                                                        <div class="control-group">
                                                            <input type="text" class="form-control" id="g_date_price" name="g_date_price" placeholder="新人专享购买价格"  value="<{if $row}><{$row['g_date_price']}><{/if}>" style="width: 160px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 下单留言 -->
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
                                        <!-- 库存 -->
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>库存/规格</span>
                                                </div>
                                                <div class="group-info">
                                                    <div class="form-group">
                                                        <label class="control-label"><font color="red">*</font>商品库存：</label>
                                                        <div class="control-group">
                                                            <input type="text" class="form-control" id="g_stock" name="g_stock" placeholder="商品库存数量" required="required" value="<{if $row}><{$row['g_stock']}><{/if}>"  style="width:160px; display: inline-block;" <{if $row['g_has_format']}>readonly<{/if}> >
                                                            <{if $row['g_has_format']}>
                                                                <span>*多规格商品请修改规格对应库存*</span>
                                                            <{/if}>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">商品重量：</label>
                                                        <div class="control-group">
                                                            <input type="text" class="form-control"  name="g_goods_weight" placeholder="商品重量"  value="<{if $row}><{$row['g_goods_weight']}><{/if}>"  style="width:160px; display: inline-block;" <{if $row['g_has_format']}>readonly<{/if}> >
                                                            <select  name="g_goods_weight_type" class="form-control" style="max-width: 100px;display: inline-block;">
                                                                <option value="1" <{if $row && $row['g_goods_weight_type'] eq 1}>selected<{/if}>>g</option>
                                                                <option value="2" <{if $row && $row['g_goods_weight_type'] eq 2}>selected<{/if}>>Kg</option>
                                                            </select>
                                                            <{if $row['g_has_format']}>
                                                                <span>*多规格商品请修改规格对应重量*</span>
                                                            <{/if}>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">商品规格：</label>
                                                            <div class='col-xs-10' style='padding-left:0;'>
                                                                <div class="control-group" style="border: 1px solid #ccc; margin-left: 15px;" ng-if="spec.length>0">
                                                                    <div ng-repeat="s in spec" ng-init="fIndex = $index" style="position:relative;background: #fff;border-bottom: 1px solid #ccc;padding: 10px;">
                                                                        <div class="delete" ng-click="delIndex('spec',$index)">×</div>
                                                                        <div style="margin-bottom: 10px;">
                                                                            <input type="text" ng-model="s.name" class="form-control"  />
                                                                        </div>
                                                                        <div ng-repeat="value in s.value track by $index" style="position:relative;display: inline-block;width=100px;margin-bottom: 10px;">
                                                                            <div class="delete" ng-click="delValueIndex('spec',s.value, $index)"  style="top: 5px; right: 10px">×</div>
                                                                            <input type="text" ng-model="value.name" class="form-control" style="margin-bottom: 10px;" />
                                                                            <div ng-if="fIndex==0">
                                                                                <img onclick="toUpload(this)" onload="changeSrc(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-format_cover{{$index}}" imageonload="doThis('spec',fIndex,$index)" id="upload-format_cover{{$index}}"  src="{{value.img?value.img:'/public/manage/img/zhanwei/zw_fxb_45_45.png'}}"  style="display:inline-block;margin-left:0;width: 143px">
                                                                                <input type="hidden" id="format_cover{{$index}}"  class="avatar-field bg-img" ng-value="value.img"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class='btn btn-primary' ng-click = "addSpecValue($index)" style="display: inline-block;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;">添加规格值</div>
                                                                    </div>
                                                                    <div class='btn btn-warning' ng-if="spec.length<3&&spec.length>0" ng-click="addSpec()" style="background: #fff;display: inline-block;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;margin: 10px">添加规格</div>
                                                                </div>
                                                                <div ng-if="spec.length<3&&spec.length<1" ng-click="addSpec()" style="background: #428bca;display: inline-block;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;color: #fff;margin-left: 15px;">添加规格</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" ng-if="spec.length>0">
                                                            <label for="name" class="control-label">规格明细：</label>
                                                            <div class="control-group">
                                                                <table >
                                                                    <thead>     
                                                                    <th ng-repeat="s in spec" ng-if="s.value.length>0">{{s.name}}</th>
                                                                    <th>成本</th>
                                                                    <{if !$row['g_es_id']}>
                                                                        <th>原价</th>
                                                                    <{/if}>
                                                                   
                                                                    <th>价格</th>

                                                                    <th>新人价</th>

                                                                    <th>重量</th>
                                                                    <th>库存</th>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr ng-repeat="data in dataList track by $index" ng-init="trIndex = $index">
                                                                        <td ng-repeat="d in data.spec track by $index" rowspan="{{rowspan[$index]}}" ng-if="trIndex % rowspan[$index]==0">{{d.name}}</td>
                                                                        <{if !$row['g_es_id']}>
                                                                        <td>
                                                                            <input type="text" class="form-control" style="max-width: 100%" ng-model="data.cost" />
                                                                        </td>
                                                                        <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.oriPrice" /></td>
                                                                        <{/if}>
                                                                        <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.price" /></td>

                                                                        <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.newmemberPrice" /></td>

                                                                        <td>
                                                                            <input type="text" class="form-control" placeholder="选填/Kg" style="max-width: 58%;float: left;margin-right: 2%" ng-model="data.weight" />
                                                                            <select id="g_goods_weight_type" name="g_goods_weight_type" class="form-control" ng-model="data.weightType" style="max-width: 40%">
                                                                                <option value="1">g</option>
                                                                                <option value="2">Kg</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.stock" /></td>
                                                                    </tr>
                                                                    </tbody>
                                                                    <tfoot ng-if="dataList[0].spec.length > 0">
                                                                    <tr>
                                                                        <td colspan="{{dataList[0].spec.length}}"> 批量设置：</td>
                                                                        <td>
                                                                            <input type="number" class="form-control" id="batch-cost-value" style="display: inline-block;width: 60%">
                                                                            <a href="javascript:;" ng-click="batchSet('cost')">确定</a></td>
                                                                        <td>
                                                                            <input type="number" class="form-control" id="batch-oriPrice-value" style="display: inline-block;width: 60%">
                                                                            <a href="javascript:;" ng-click="batchSet('oriPrice')">确定</a></td>
                                                                         
                                                                        <td>
                                                                            <input type="number" class="form-control" id="batch-price-value" style="display: inline-block;width: 60%">
                                                                            <a href="javascript:;" ng-click="batchSet('price')">确定</a>
                                                                        </td>

                                                                        <td>
                                                                            <input type="number" class="form-control" id="batch-newmemberPrice-value" style="display: inline-block;width: 60%">
                                                                            <a href="javascript:;" ng-click="batchSet('newmemberPrice')">确定</a>
                                                                        </td>

                                                                        <td style="padding: 0">
                                                                            <input type="number" class="form-control" id="batch-weight-value" style="display: inline-block;width: 30%">
                                                                            <select id="batch-weight-type-value" class="form-control"  style="display: inline-block;width: 30%">
                                                                                <option value="1">g</option>
                                                                                <option value="2">Kg</option>
                                                                            </select>
                                                                            <a href="javascript:;" ng-click="batchSet('weight')">确定</a>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control" id="batch-stock-value" style="display: inline-block;width: 60%">
                                                                            <a href="javascript:;" ng-click="batchSet('stock')">确定</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 图片信息 -->
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>图片信息</span>
                                                </div>
                                                <div class="group-info">
                                                    <div class="form-group">
                                                        <label class="control-label">商品封面图：</label>
                                                        <div class='control-group'>
                                                            <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover" id="upload-g_cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;">
                                                            <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover">修改</a>
                                                        </div>
                                                        <div class='help-block' style='margin-left: 150px;'>
                                                            <small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="">
                                                        <label class='control-label'>商品幻灯图：</label>
                                                        <div class='control-group'>
                                                            <div  id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['gs_path']}>"  layer-pid="" src="<{$val['gs_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['gs_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['gs_id']}>">
                                                                    <input type="hidden" id="slide_sort_<{$key}>" class="slide-sort" name="slide_sort_<{$key}>" value="<{$val['gs_sort']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-primary btn-sm">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                            <div class='help-block'>
                                                                <small style='font-size: 12px;color:#999'>最多五张，尺寸 640 x 640 像素</small>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- 视频信息 -->
                                        <{if $sequenceShowAll == 1}>
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>视频地址</span>
                                                </div>
                                                <div class="group-info">
                                                    <div class="form-group">
                                                        <label class='control-label'>视频地址：</label>
                                                        <div class="control-group">
                                                            <input type="text" class="form-control" id="g_video" name="g_video" placeholder="请填写视频地址" value="<{if $row}><{$row['g_video_url']}><{/if}>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <{/if}>
                                        <!-- 物流 -->
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>物流其它</span>
                                                </div>
                                                <div class="group-info">
                                                    <div class="form-group">
                                                        <label class="control-label">运费方式：</label>
                                                        <div class="control-group" style="height:50px">
                                                            <div class="radio-box col-xs-2"  style="width:172px;">
                                                                <span>
                                                                    <input type="radio" name="g_expfee_type" id="g_expfee_type1" value="1" <{if $row && ($row['g_expfee_type'] eq 1 || $row['g_expfee_type'] eq 0)}>checked<{/if}>>
                                                                    <label for="g_expfee_type1">统一运费</label>
                                                                </span>
                                                            </div>
                                                            <div class="input-group col-xs-3"  style="width:160px;">
                                                                <div class="input-group-addon">￥</div>
                                                                <input type="text" class="form-control" name="g_unified_fee" value="<{if $row}><{$row['g_unified_fee']}><{/if}>"  placeholder="统一运费费用">
                                                            </div>
                                                        </div>
                                                        <div class="control-group" >
                                                            <div class="radio-box col-xs-2"  style="width:172px;">
                                                                <span>
                                                                    <input type="radio" name="g_expfee_type" id="g_expfee_type2"  value="2" <{if $row && $row['g_expfee_type'] eq 2}>checked<{/if}>  <{if count($tempList) == 0}>disabled="disabled"<{/if}>>
                                                                    <label for="g_expfee_type2">运费模板</label>
                                                                </span>
                                                            </div>
                                                            <div class="col-xs-4">
                                                                <select name="g_unified_tpid" id="g_unified_tpid" class="form-control">
                                                                    <option value="0">请选择运费模板</option>
                                                                    <{foreach $tempList as $val}>
                                                                    <option <{if $row && $row['g_unified_tpid'] eq $val['sdt_id']}>selected<{/if}> value="<{$val['sdt_id']}>"><{$val['sdt_name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                                <div class="help-inline">
                                                                    <a href="/wxapp/delivery/add" target="_blank" class="new-window" style="float: right;position: relative;top: -23px;">新建</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">运费显示：</label>
                                                        <div class="control-group">
                                                            <label style="padding: 4px 0;margin: 0;">
                                                                <input name="g_expfee_show" class="ace ace-switch ace-switch-5" id="g_expfee_show" <{if ($row && $row['g_expfee_show']) || !$row}>checked<{/if}> type="checkbox">
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!--  重复，上面已有会员折扣
                                                    <div class="form-group">
                                                        <label class="control-label">是否参与会员折扣：</label>
                                                        <div class="control-group">
                                                            <label style="padding: 4px 0;margin: 0;">
                                                                <input name="g_join_discount" class="ace ace-switch ace-switch-5" id="g_join_discount" <{if ($row && $row['g_join_discount']) || !$row}>checked<{/if}> type="checkbox">
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- 富文本框信息 -->
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>详情</span>
                                                </div>
                                                <div class="group-info  xs-hidden-info">
                                                    <div class="form-group">
                                                        <label class="control-label xs-hidden-label">商品详情：</label>
                                                        <div class="control-group xs-hidden-info" >
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
                                        <div class='info-group-box'>
                                            <div class="info-group-inner">
                                                <div class="group-title" style="background-color: transparent!important;"></div>
                                                <div class='group-info' style="margin-left: 0;padding-left: 0;background-color: transparent!important;">
                                                    <button class="btn btn-primary" ng-click="saveData()" style="width: 150px;">保存</button>
                                                    <a href="/wxapp/goods/index" class="btn btn-default"  style="width: 150px;">返回商品列表</a>
                                                    <{if $show_save_tip == 1}>
                                                    <{if $row['g_id'] > 0}>
                                                    <span style="color: red">
                                                        保存商品需重新审核
                                                    </span>
                                                    <{else}>
                                                    <span style="color: red">
                                                        商品需审核通过后方可上架
                                                    </span>
                                                    <{/if}>

                                                    <{/if}>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<div id="goods-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">推荐商品</h4>
            </div>
            <div class="modal-body">
                <div class="good-search" style="margin-top: 20px">
                    <div class="input-group">
                        <input type="text" id="keyword" class="form-control" placeholder="搜索商品">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchGoodsPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr>
                <table  class="table-responsive">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <thead>
                    <tr>
                        <th>商品图片</th>
                        <th style="text-align:left">商品名称</th>
                        <th>操作</th>
                    </thead>

                    <tbody id="goods-tr">
                    <!--商品列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<{include file="../img-upload-modal.tpl"}>

<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.spec = <{$spec}>;
        $scope.isDiscuss = '<{$row['g_is_discuss']}>';
        $scope.dataList=<{$dataList}>;
        $scope.rowspan = [];
        //$scope.messageList = <{$messageList}>;
        //$scope.vipPriceList = <{$vipPriceList}>;
       // $scope.levelList = <{$levelList}>;
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
            }
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
                'date' : false
            };
            $scope.messageList.push(data);
        };
        $scope.addVipPrice = function () {
            var data = {
                'identity': 0,
                'price': 0,
            };
            $scope.vipPriceList.push(data);
        };
        $scope.addSpecValue = function(index){
            var data = {
                'name':'规格值',
                'img' : '/public/manage/img/zhanwei/zw_fxb_45_45.png'
            };
            if(index>0 &&$scope.spec[(index - 1)].value.length==0){
                layer.msg('请先添加上级规格值')
            }else{
                $scope.spec[index].value.push(data);
            }
        };

        //监听sb变量的变化，并在变化时更新DOM
        $scope.$watch('spec',function(n,o){
            var n = 0;
            if($scope.spec.length==0){
                $scope.dataList = [];
                $scope.rowspan = [];
            }

            if(($scope.spec.length==1)||($scope.spec.length==2&&$scope.spec[1].value.length==0) || ($scope.spec.length==3&&$scope.spec[2].value.length==0&&$scope.spec[1].value.length==0)){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    $scope.dataList[n] = {
                        'spec': [$scope.spec[0].value[i]],
                        'oriPrice': $scope.dataList[n]?$scope.dataList[n].oriPrice:0,
                        'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                        'cost': $scope.dataList[n]?$scope.dataList[n].cost:0,
                        'stock': $scope.dataList[n]?$scope.dataList[n].stock:0,
                        'weight': $scope.dataList[n]?$scope.dataList[n].weight:0,
                        'newmemberPrice' : $scope.dataList[n]?$scope.dataList[n].newmemberPrice:0
                    }
                    n++;
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [1];
            }
            if(($scope.spec.length==2 && $scope.spec[1].value.length>0)||($scope.spec.length==3&&$scope.spec[2].value.length==0)){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    for(var j=0;j<$scope.spec[1].value.length;j++){
                        $scope.dataList[n] = {
                            'spec': [$scope.spec[0].value[i],$scope.spec[1].value[j]],
                            'oriPrice': $scope.dataList[n]?$scope.dataList[n].oriPrice:0,
                            'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                            'cost': $scope.dataList[n]?$scope.dataList[n].cost:0,
                            'stock': $scope.dataList[n]?$scope.dataList[n].stock:0,
                            'weight': $scope.dataList[n]?$scope.dataList[n].weight:0,
                            'newmemberPrice' : $scope.dataList[n]?$scope.dataList[n].newmemberPrice:0
                        }
                        n++
                    }
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [$scope.spec[1].value.length>0?$scope.spec[1].value.length:1, 1];
            }
            if($scope.spec.length==3 && $scope.spec[2].value.length>0){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    for(var j=0;j<$scope.spec[1].value.length;j++){
                        for(var k=0;k<$scope.spec[2].value.length;k++){
                            $scope.dataList[n] = {
                                'spec': [$scope.spec[0].value[i],$scope.spec[1].value[j],$scope.spec[2].value[k]],
                                'oriPrice': $scope.dataList[n]?$scope.dataList[n].oriPrice:0,
                                'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                                'cost': $scope.dataList[n]?$scope.dataList[n].cost:0,
                                'stock': $scope.dataList[n]?$scope.dataList[n].stock:0,
                                'weight': $scope.dataList[n]?$scope.dataList[n].weight:0,
                                'newmemberPrice' : $scope.dataList[n]?$scope.dataList[n].newmemberPrice:0
                            }
                            n++;
                        }
                    }
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [$scope.spec[1].value.length*($scope.spec[2].value.length>0?$scope.spec[2].value.length:1), $scope.spec[2].value.length>0?$scope.spec[2].value.length:1, 1];
            }

        },true);

        $scope.doThis=function(type,findex,index){
            $scope[type][findex].value[index].img = imgNowsrc;
        };

        /*删除元素*/
        $scope.delIndex=function(type,index){
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

        /*删除规格值元素*/
        $scope.delValueIndex=function(type,value,sindex){
            var index=0
            for(var i=0; i<$scope[type].length; i++){
                if($scope[type][i].value == value){
                    index = i;
                }
            }
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type][index].value.splice(sindex,1);
                    if($scope[type][index].value.length<1){
                        $scope[type].splice(index,1);
                    }
                });
                layer.msg('删除成功');
            })
        }

        //批量设置
        $scope.batchSet = function(type){

            var value = $('#batch-'+type+'-value').val();

            for (var i=0; i< $scope.dataList.length; i++){
                $scope.dataList[i][type] = value;
            }
        }


        // 保存数据
        $scope.saveData = function(){
            var g_applay_goods_show = $('input[name="g_applay_goods_show"]:checked').length > 0 ? '' : '&g_applay_goods_show=off';
            var gids     = [];
            //保存推荐商品
            $('.goods-selected').each(function () {
                var gid = $(this).attr('gid');
                gids.push(gid)
            });
            var slide = 0;
            for(var i=0;i<=4;i++){
                var temp = $('#slide_'+i).val();
                if(temp) {
                    slide = parseInt(slide) + 1;
                }
            }
            if(slide == 0){
                layer.msg('请上传幻灯');
                return false;
            }
            let goods_id=$('#hid_id').val();
            if(goods_id!=0){
                 // 再说库存有问题的就是傻子了
                // 提示已经很明显了
                layer.confirm('正在售卖中的商品建议先下架再进行修改，否则会影响库存等信息的统计！！！',{
                    btn:['任性修改','考虑一下']
                },function(){
                    var load_index = layer.load(
                        2,
                        {
                            shade: [0.1,'#333'],
                            time: 10*1000
                        }
                    );
                    $.ajax({
                        'type'   : 'post',
                        'url'   : '/wxapp/goods/newSave',
                        'data'  : $('#goods-form').serialize()+'&formatType='+JSON.stringify($scope.spec)+'&formatList='+JSON.stringify($scope.dataList)+'&gids='+JSON.stringify(gids)+g_applay_goods_show,
                        'dataType'  : 'json',
                        'success'   : function(ret){
                            layer.close(load_index);
                            layer.msg(ret.em);
                            if(ret.ec == 200){
                                window.location.href = '/wxapp/goods/index';
                            }
                        }
                    });
                });  
            }else{
                var load_index = layer.load(
                    2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
                );
                $.ajax({
                    'type'   : 'post',
                    'url'   : '/wxapp/goods/newSave',
                    'data'  : $('#goods-form').serialize()+'&formatType='+JSON.stringify($scope.spec)+'&formatList='+JSON.stringify($scope.dataList)+'&gids='+JSON.stringify(gids)+g_applay_goods_show,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(load_index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.href = '/wxapp/goods/index';
                        }
                    }
                });
            }
        };

        jQuery(function($) {
            $('#slide-img').sortable().bind('sortupdate', function () {
                changeSortable();
            });

            $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
                /*  去掉商品类目不再做验证*/
                /*
                 if(info.step == 1 && info.direction == 'next') {
                 if(!checkCategory()) return false;
                 }else
                 */
                // if(info.step == 1 && info.direction == 'next'){
                //
                // }else if(info.step == 2 && info.direction == 'next'){
                //
                // }
                if(!checkBasic()) return false;
                if(!checkImg()) return false;
            }).on('finished', function(e) {
                //saveGoods('step');
                $scope.saveData();
            });

            $('.product-leibie').on('click', 'li', function(event) {
                $(this).addClass('selected').siblings('li').removeClass('selected');
                var id = $(this).data('id');
                $('#g_c_id').val(id);
            });
            formatSort();
            //获取自定义商品分类
            var kind = 0 ;
            <{if $row && $row['g_kind2']}>
            kind = <{$row['g_kind2']}>;
            <{/if}>
            customerGoodsCategory(kind);

            // 初始化库存是否可输入
            var panelLen = parseInt($("#panel-group").find('.panel').length);
            if(panelLen>0){
                //$("#g_stock").attr("readonly",true);
            }
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
            // 商品标签选择
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

    //管理商品
    $('.btn-goods').on('click',function(){
        //初始化
        var num = $('.goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个商品');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');

        $('.th-weight').hide();

        $('#goods-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage);
    });

    function fetchGoodsPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            'id'    :  $('#currId').val()  ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/giftGoods',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].g_id+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p></td>';
            html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealGoods( this )"> 选取 </td>';
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }

    //选择关联商品
    function dealGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        $('.goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //移除关联商品
    function removeGoods(ele) {
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
            $('.goods-selected-list').html(default_html);
        }
    }

    //清空关联商品
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.goods-selected-list').html(default_html);
    });

    //图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    /**
     * 第一步检查商品类目
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
        var check   = new Array('g_name','g_price','g_stock');
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
            }
        }
        if(slide == 0){
            layer.msg('请上传幻灯');
            return false;
        }
        return true;
    }

    /**
     * 保存商品信息
     */
//    /*function saveGoods(type){
//        var load_index = layer.load(
//                2,
//                {
//                    shade: [0.1,'#333'],
//                    time: 10*1000
//                }
//        );
//        $.ajax({
//            'type'   : 'post',
//            'url'   : '/wxapp/goods/save',
//            'data'  : $('#goods-form').serialize(),
//            'dataType'  : 'json',
//            'success'   : function(ret){
//                layer.close(load_index);
//                if(ret.ec == 200 && type == 'step'){
//                    window.location.href='/wxapp/goods/index';
//                }else{
//                    layer.msg(ret.em);
//                }
//            }
//        });
//    }*/
    /**
     * 图片结果处理
     * @param allSrc
     */
   function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                var imgId = nowId.split('-');
                $('#'+nowId).attr('src',allSrc[0]);
                $('#'+nowId).val(allSrc[0]);
                $('#'+imgId[1]).val(allSrc[0]);
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
                    img_html += '<input type="hidden" id="slide_sort_'+key+'" class="slide-sort" name="slide_sort_'+key+'" value="'+key+'">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).append(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }


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

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>库存</label>';
        _html       += '<input type="text" class="form-control"  name="format_stock_'+key+'"  value="">';
        _html       += '</div></div>';

        _html       += '</div><!---panel-body----> </div><!---panel-collapse----></div><!---panel---->';
        return _html;
    }



    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }

    function formatSort(){
        /*$("#panel-group").sortable({
            update: function( event, ui ) {
                sortString();
            }
        });*/
    }

    function changeSortable() {
        let index = 0;
        $("#slide-img p").each(function () {
            $(this).find('.slide-sort').val(index);
            index++;
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
</script>


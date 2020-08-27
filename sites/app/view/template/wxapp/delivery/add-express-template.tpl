<link rel="stylesheet" href="/public/wxapp/mall/css/deliverRegion.css">
<link rel="stylesheet" href="/public/wxapp/mall/css/addTemplate.css">
<style>
    .app{
        min-height: 800px;
    }
    .select-area table tr td{
        padding: 10px 15px;
    }
    .select-area table tr td:first-child{
        width: 300px;
    }
    .select-area .prov{
        color: #333;
        font-size: 12px;
    }
    .select-area .prov .city{
        color: #777;
    }
    .select-area .prov .region{
        color: #999;
    }
    .opera-box{
        float: right;
    }
    .opera-box a{
        color: #38f;
        margin:0 3px;
        font-size: 12px;
    }
</style>
<{if $applet['ac_type'] != 13}>
<{include file="../common-second-menu-new.tpl"}>
<{/if}>
<div class="app" ng-app="areaApp" ng-controller="areaCtrl" >
    <input type="hidden" value="<{$row['sdt_id']}>" name="id" id="id">
    <input type="hidden" value="<{if $sendCfg['acs_es_id'] && $sendCfg['acs_es_id'] > 0}><{$sendCfg['acs_es_id']}><{else}>0<{/if}>" name="esId" id="esId">
    <div class="app-inner clearfix">
        <div class="app-init-container">
            <div id="page-trade-delivery" class="app__content page-trade-delivery" style="display: block;"><div>

                    <form class="form-horizontal freight-add-form" onkeypress="return event.keyCode != 13;">
                        <div class="control-group">
                            <label class="control-label">
                                模版名称：
                            </label>
                            <div class="controls">
                                <input class="js-valuation-name form-control col-xs-3" type="text" value="<{$row['sdt_name']}>" name="name" id="temp-name">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">
                                计费方式：
                            </label>
                            <div class="controls">

                                <label class="inline radio">
                                    <input class="js-valuation-type" type="radio" name="valuation_type" value="1" <{if $row['sdt_type'] == 1}> checked="checked" <{/if}> id="temp-type">
                                    按件数
                                </label>
                                <label class="inline radio" style="margin-left: 20px">
                                    <input class="js-valuation-type" type="radio" name="valuation_type" value="2" <{if $row['sdt_type'] == 2}> checked="checked" <{/if}>>
                                    按重量
                                </label>

                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">
                                配送区域：
                            </label>
                            <div class="controls">

                                <table class="freight-template-table freight-template-item">
                                    <thead class="js-freight-cost-header freight-template-title">


                                    <tr>
                                        <th>可配送区域</th>
                                        <th id="first">首件（个）</th>
                                        <th>运费（元）</th>
                                        <th id="continue">续件（个）</th>
                                        <th>续费（元）</th>
                                    </tr>

                                    </thead>
                                    <tbody  ng-show="templateList.length>0">
                                        <tr ng-repeat="template in templateList track by $index" ng-if="template.singalFinalRes">
                                            <td>
                                                <span class="prov" ng-repeat="prov in template.singalFinalRes track by $index">
                                                    <span ng-if="prov.region.stateShowAll">{{prov.region.name}}</span>
                                                    <span class="city" ng-repeat="city in prov.region.state" ng-if="!prov.region.stateShowAll && city.cityShow>0">
                                                        {{city.name}}
                                                        <span class="dun" ng-if="$index!=(prov.region.stateShow-1)">&nbsp;&nbsp;</span>
                                                    </span>
                                                    <span class="dun" ng-if="!$last && prov">&nbsp;&nbsp;</span>
                                                </span>
                                                <div class="pull-right">
                                                    <a href="javascript:;" class="js-edit-cost-item" ng-click="showChooseArea($index, template.singalFinalRes)">编辑</a>
                                                    <a href="javascript:;" class="js-delete-cost-item" ng-click="deleteChooseArea($index, template.singalFinalRes)">删除</a>
                                                </div>
                                            </td>
                                            <td><input type="text" ng-model="template.firstNum" class="cost-input js-input-number form-control" name="first_amount" data-default="0" maxlength="8"></td>
                                            <td><input type="text" ng-model="template.firstFee" class="cost-input js-input-currency form-control" name="first_fee" maxlength="8"></td>
                                            <td><input type="text" ng-model="template.addNum" class="cost-input js-input-number form-control" name="additional_amount" data-default="0" maxlength="8"></td>
                                            <td><input type="text" ng-model="template.addFee" class="cost-input js-input-currency form-control" name="additional_fee" maxlength="7"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="js-freight-tablefoot" style="display: table-footer-group;">
                                    <tr>
                                        <td><a href="javascript:;" class="js-assign-cost zent-btn btn-wide" ng-click="showChooseArea()">指定可配送区域和运费</a></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <a href="javascript:;" class="zent-btn zent-btn-primary btn-wide js-save-btn" ng-click="saveTemplate()">保存</a>
                            </div>
                        </div>

                    </form>
                </div></div>                            </div>
        <div class="notify-bar js-notify animated hinge hide">
        </div>
    </div>
    <div class="area-modal-wrap">
        <div class="modal-mask"></div>
        <div class="area-modal">
            <div class="area-modal-head">选择可配送区域</div>
            <div class="area-modal-content">
                <div class="area-editor-wrap clearfix">
                    <div class="area-editor-column js-area-editor-notused">
                        <div class="area-editor">
                            <h4 class="area-editor-head">可选省、市</h4>
                            <div class="area-editor-list">
                                <ul class="area-editor-list area-editor-depth0">
                                    <li ng-repeat="provinceList in selectAreaList" ng-show="(provinceList.region.stateShow==0||provinceList.region.stateShow!=provinceList.region.state.length)&&!provinceList.region.hide">
                                        <div class="area-editor-list-title" ng-click="selectToggle($event,provinceList)">
                                            <div class="area-editor-list-title-content js-ladder-select">
                                                <div class="js-ladder-toggle area-editor-ladder-toggle extend" ng-click="ladderToggle($event)">+</div>
                                                {{provinceList.region.name}}
                                            </div>
                                        </div>
                                        <ul class="area-editor-list area-editor-depth1" style="display: none;">
                                            <li ng-repeat="cityList in provinceList.region.state" ng-show="cityList.cityShow==0">
                                                <div class="area-editor-list-title" ng-click="selectToggle($event,cityList)">
                                                    <div class="area-editor-list-title-content js-ladder-select">
                                                        {{cityList.name}}
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="area-add">
                        <button class="zent-btn btn-wide area-editor-add-btn js-area-editor-translate" ng-click="addToRight()">添加</button>
                    </div>
                    <div class="area-editor-column area-editor-column-used js-area-editor-used">
                        <div class="area-editor">
                            <h4 class="area-editor-head">已选省、市</h4>
                            <div class="area-editor-list">
                                <ul class="area-editor-list area-editor-depth0">
                                    <li ng-repeat="provinceList in rightList track by $index" ng-show="provinceList.region.stateShow>0">
                                        <div class="area-editor-list-title" ng-if="provinceList">
                                            <div class="area-editor-list-title-content js-ladder-select">
                                                <div class="js-ladder-toggle area-editor-ladder-toggle extend" ng-click="ladderToggle($event)">+</div>
                                                {{provinceList.region.name}}
                                                <div class="area-editor-remove-btn js-ladder-remove" ng-click="deleteSelectItem($event,provinceList)">×</div>
                                            </div>
                                        </div>
                                        <ul class="area-editor-list area-editor-depth1" style="display: none;">
                                            <li ng-repeat="cityList in provinceList.region.state" ng-show="cityList.cityShow>0 && cityList.cityShow!=0.5">
                                                <div class="area-editor-list-title">
                                                    <div class="area-editor-list-title-content js-ladder-select">
                                                        {{cityList.name}}
                                                        <div class="area-editor-remove-btn js-ladder-remove" ng-click="deleteSelectItem($event,cityList)">×</div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="area-modal-foot">
                <button class="zent-btn zent-btn-primary js-modal-save" ng-click="getFinalData()">确定</button>
                <button class="zent-btn btn-wide js-modal-close" ng-click="hideChooseArea()">取消</button>
            </div>
        </div>
    </div>
</div>
<!-- 选择可配送区域弹出层 -->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/wxapp/mall/js/deliverRegion.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
    window.LocalAreaList=<{$LocalAreaList}>;
    $(function () {
        var selectedvalue = $("input[name='valuation_type']:checked").val();
        if(selectedvalue == 1){
            $('#first').text('首件（个）');
            $('#continue').text('续件（个）');
        }else{
            $('#first').text('首重（Kg）');
            $('#continue').text('续重（Kg）');
        }
    })

    var jsonlist = <{$list}>;
    var list = [];
    for(var i in jsonlist){
        list[i] = jsonlist[i]
    }

    var singalFinalRes = [];
    var templateList = [];
    var groupName = [];
    for(var j=0;j<list.length;j++){
        groupName[j] = [];
        if(list[j]){
            for(var i=0;i<list[j].length;i++){
                groupName[j].push(list[j][i]['sdc_area_name']);
            }
        }
    }

    $("input[name='valuation_type']").change(function(){
        var selectedvalue = $("input[name='valuation_type']:checked").val();
        if(selectedvalue == 1){
            $('#first').text('首件（个）');
            $('#continue').text('续件（个）');
        }else{
            $('#first').text('首重（Kg）');
            $('#continue').text('续重（Kg）');
        }
    });
</script>

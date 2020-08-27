<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:20:12
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/giftcard/edit-card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18569925745e4e6b6c406c84-78680157%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c011deddeb9c65d426a124b742a3654b32762f0' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/giftcard/edit-card.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18569925745e4e6b6c406c84-78680157',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'cardType' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6b6c43ace9_31646085',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6b6c43ace9_31646085')) {function content_5e4e6b6c43ace9_31646085($_smarty_tpl) {?>
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    a.new-window { color: blue; }
    .payment-block-wrap { font-family: '黑体'; }
    .payment-block { border: 1px solid #e5e5e5; margin-bottom: 20px; }
    .payment-block .payment-block-header { position: relative; padding: 10px; border-bottom: 1px solid #e5e5e5; margin-bottom: -1px; background: #F8F8F8; cursor: pointer; }
    .payment-block .payment-block-header h3 { font-size: 16px; font-weight: bold; line-height: 30px; margin: 0; }
    .payment-block .payment-block-header h3:after { content: ' '; border: 5px solid #999; width: 0; height: 0; display: inline-block; position: absolute; margin-left: 6px; margin-top: 12px; border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent; border-top-width: 7px; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; transition: all 0.2s; }
    .payment-block-wrap.open .payment-block-header h3:after { -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); -webkit-transform-origin: 50% 25%; -moz-transform-origin: 50% 25%; -ms-transform-origin: 50% 25%; transform-origin: 50% 25%; }
    .payment-block .payment-block-header .choose-onoff { position: absolute; top: 10px; right: 10px; }
    .payment-block .payment-block-body { display: none; padding: 25px; }
    .payment-block-body .form-group { overflow: hidden; }
    .payment-block-body .form-group label { font-weight: bold; }
    .payment-block-body .form-group p { color: #999; margin: 0; margin-top: 5px; }
    .payment-block .payment-block-body h4 { color: #333; margin-bottom: 20px; font-size: 14px; }
    .form-horizontal { margin-bottom: 30px; width: auto; }
    .form-horizontal .control-group { margin-bottom: 10px; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .controls-row:after, .dropdown-menu>li>a, .form-actions:after, .form-horizontal .control-group:after, .modal-footer:after, .nav-pills:after, .nav-tabs:after, .navbar-form:after, .navbar-inner:after, .pager:after, .thumbnails:after { clear: both; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .form-horizontal .control-label { float: left; width: 160px; padding-top: 5px; text-align: right; }
    .form-horizontal .control-label { width: 120px; font-size: 14px; line-height: 18px; }
    .page-payment .form-label-text-left .control-label { text-align: left; width: 100px; }
    .controls { font-size: 14px; }
    .form-horizontal .controls { margin-left: 180px; }
    .form-horizontal .controls { margin-left: 130px; word-break: break-all; }
    .page-payment .form-label-text-left .controls { margin-left: 100px; }
    .form-horizontal .control-action { padding-top: 5px; display: inline-block; font-size: 14px; line-height: 18px; }
    .ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
    .ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }
    .pay-test-status { font-size: 12px; margin-top: 10px; width: 400px; }
    .payment-block .payment-block-body p { line-height: 24px; }
    .payment-block .payment-block-body dl { line-height: 24px; }
    .payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
    .payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
    .payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
    .payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
    .showhide-secreskey { position: absolute; top: 4px; right: 18px; height: 26px; line-height: 26px; border-radius: 3px; background-color: #0095e5; color: #fff; z-index: 1; padding: 0 7px; font-size: 12px; cursor: pointer; }
    .showhide-secreskey:hover { opacity: 0.9; }

    .timeDian{
        margin-left: 10% !important;
    }
    .title-col-2{
        width: 135px !important;
        padding-left: 20px !important;
    }
    .save-button-box{
        margin-left: 20.6666% !important;
    }
    .time{
        display: inline-block;
    }
    /* 保存按钮样式 */
    .alert.save-btn-box{
        border: 1px solid #F5F5AA;
        background-color: #FFFFCC;
        text-align: center;
        position: fixed;
        bottom: 0;
        left: 50%;
        margin-left: -453px;
        width: 870px;
        margin-bottom: 0;
        z-index: 200;
    }
    #container object{
        position:relative!important;
        height: 300px!important;
    }
    .switch-title{
        padding-left: 8px;
        font-weight: bold;
    }
    .input-tip{
        color: #999;
        padding-left: 5px;
    }
    .second-navmenu li > a{
        padding-left: 0 !important;
        text-align: center !important;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
    .link-box div{
        width: 50% ;
    }
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../article-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="payment-style" ng-app="chApp" ng-controller="chCtrl" >

    <div class="payment-block-body js-wxpay-body-region" style="display: block;">

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">充值卡名称<span style="color: red">*</span></label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id="name" name="name" ng-model="name">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">封面图<span style="color: red">*</span>(尺寸750*470)</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="form-group col-sm-10" style="padding-left: 0">
                    <img onclick="toUpload(this)"   data-limit="1" onload="changeSrc(this)" data-width="750" data-height="470" imageonload="changeCover()" data-dom-id="upload-cover" id="upload-cover"  ng-src="{{cover}}"  height="100%" style="display:inline-block;height: 200px;margin: 0">
                    <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" ng-value="cover"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">价格<span style="color: red">*</span></label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id ="price" name="price" ng-model="price" placeholder="请填写充值卡售价">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">获得金额<span style="color: red">*</span></label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id ="coin" name="coin" ng-model="coin" placeholder="请填写大于零的数字">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">排序</label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id ="sort" name="sort" ng-model="sort" placeholder="越大越靠前">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">使用规则</label>
            </div>
            <div class="form-group col-sm-5">
                <textarea class="form-control" id ="rule" name="rule" ng-model="rule" placeholder="请输入使用规则" rows="8"></textarea>
            </div>
        </div>
        <div style="height: 60px"></div>
    </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save" ng-click="saveData()"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){

        $scope.cover       = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_cover'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_cover'];?>
':'/public/manage/img/zhanwei/zw_fxb_750_422.png';
        $scope.name        = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_name'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_name'];?>
': '';
        $scope.rule        = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_rule'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_rule'];?>
': '';
        $scope.price        = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_price'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_price'];?>
': '';
        $scope.coin        = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_coin'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_coin'];?>
': '';
        $scope.sort        = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_sort'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_sort'];?>
': '0';
        $scope.cardId      = '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_id'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['row']->value['agc_id'];?>
' : '0';
        $scope.cardType    = '<?php echo $_smarty_tpl->tpl_vars['cardType']->value;?>
' ? '<?php echo $_smarty_tpl->tpl_vars['cardType']->value;?>
' : '1';

        $scope.changeCover=function(){
            if(imgNowsrc){
                $scope.cover = imgNowsrc;
            }
        };


        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };

        /*删除元素*/
        $scope.delIndex=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }


            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if(parentType){
                    $scope.$apply(function(){
                        $scope[parentType][type].splice(realIndex,1);
                    });
                }else{
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                }
                layer.msg('删除成功');
            });
        }

        $scope.changeApplyIcon=function(){
            if(imgNowsrc){
                $scope.applyIcon = imgNowsrc;
            }
        };


        $scope.doThis=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
                $scope[parentType][type][realIndex].imgsrc = imgNowsrc;
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
                $scope[type][realIndex].imgsrc = imgNowsrc;
            }


        };

        // 保存数据
        $scope.saveData = function(){

            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'cover' : $scope.cover,
                'name'  : $scope.name,
                'coin'  : $scope.coin,
                'price' : $scope.price,
                'sort'  : $scope.sort,
                'id'    : $scope.cardId,
                'rule'  : $scope.rule,
                'cardType' : $scope.cardType
            };
            $http({
                method: 'POST',
                url:    '/wxapp/giftcard/saveCard',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                if(response.data.ec == 200){
                    window.location.href = '/wxapp/giftcard/coinCardList';
                }
            });
        };

        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).attr('data-id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
            });


        });
    }]);
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
    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }

</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

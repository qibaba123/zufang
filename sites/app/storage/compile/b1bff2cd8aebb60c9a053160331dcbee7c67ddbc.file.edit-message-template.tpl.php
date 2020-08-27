<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 15:53:01
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/edit-message-template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3952559435e86eb5d2912c6-35550704%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1bff2cd8aebb60c9a053160331dcbee7c67ddbc' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/edit-message-template.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3952559435e86eb5d2912c6-35550704',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'messageList' => 0,
    'applet' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86eb5d2bd736_49545310',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86eb5d2bd736_49545310')) {function content_5e86eb5d2bd736_49545310($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">

<style>
    .page-content {
        width: 90%;
        min-height: 420px;
        zoom: 1;
        margin: auto;
    }

    .form-horizontal .control-label {
        float: left;
        width: 160px;
        padding-top: 5px;
        text-align: right;
        font-size: 14px;
        line-height: 18px;
    }

    .form-horizontal .controls {
        margin-left: 180px;
        word-break: break-all;
    }

    .info-group-inner .group-title {
        font-weight: bold;
        font-size: 16px;
        text-align: center;
        /* background-color: #f8f8f8; */
        padding: 20px 0;
        width: 20%;
    }

    .wizard-actions {
        text-align: center;
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


<div ng-app="chApp" ng-controller="chCtrl" class="page-content form-horizontal">
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['amt_id'];?>
" name="hid_id" id="hid_id">
    <div class="control-group">
        <label class="control-label">
            模版名称：
        </label>
        <div class="controls">
            <input class="js-valuation-name form-control col-xs-3" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['amt_name'];?>
" name="name" id="temp-name">
        </div>
    </div>
    <div class="control-group" style="margin-top: 60px">
        <label class="control-label">
            模版名称：
        </label>
        <div class="controls">
            <div style="color: red;padding-top: 3px;padding-bottom: 5px">字段名称最多4个字，超出部分不展示</div>
            <div class="panel-group" id="panel-group" ui-sortable ng-model="messageList">
                <div class="panel" ng-repeat="message in messageList track by $index">
                    <div class="panel-collapse">
                        <a href="javascript:;" class="close" ng-click="delIndex('messageList',$index)">×</a>
                        <div class="panel-body">
                            <div class="col-xs-2">
                                <div class="input-group" style="width: 100%">
                                    <input type="text"  maxlength="4" style="width: 100%;max-width: 100%"  class="form-control" ng-model="message.name">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="input-group" style="width: 100%">
                                    <select class="form-control" ng-model="message.type" style="width: 100%;max-width: 100%"   ng-options="x.type as x.name for x in messageType" ></select>
                                </div>
                            </div>
                            <div class="col-xs-4" ng-if="message.type!='image'&&message.type!='radio'&&message.type!='checkbox'">
                                <div class="input-group" style="width: 100%">
                                    <input type="text"  style="width: 100%;max-width: 100%" placeholder="提示文本" class="form-control" ng-model="message.placeholder">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="input-group">
                                    <label for=""  style="padding: 6px 3px">
                                        <input type="checkbox" name="require" ng-model="message.require"  ng-checked="message.require==true"> 必填
                                    </label>
                                    <label for=""  style="padding: 6px 3px" ng-if="message.type=='text'">
                                        <input type="checkbox" name="date" ng-model="message.multi"  ng-checked="message.multi==true"> 多行
                                    </label>
                                    <label for=""  style="padding: 6px 3px" ng-if="message.type=='time'">
                                        <input type="checkbox" name="date" ng-model="message.date"  ng-checked="message.date==true"> 日期
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
        <div class="row-fluid wizard-actions">
            <button class="btn btn-primary" ng-click="saveData()">
                保存
            </button>
        </div>
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.messageList = <?php echo $_smarty_tpl->tpl_vars['messageList']->value;?>
;
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
            <?php if ($_smarty_tpl->tpl_vars['applet']->value['ac_type']==18) {?>
            {
                'type': 'shop',
                'name': '门店'
            },
            {
                'type': 'address',
                'name': '地址'
            },
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['applet']->value['ac_type']==21||$_smarty_tpl->tpl_vars['applet']->value['ac_s_id']==9373) {?>
                {
                    'type': 'radio',
                    'name': '单选框'
                },
                {
                    'type': 'checkbox',
                    'name': '多选框'
                },
            <?php }?>
        ];

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
        };

        $scope.addOptions = function (findex) {
            var option_Default = {
                'title': '选择项'
            };
            $scope.messageList[findex].options.push(option_Default);
        };

        $scope.delOption = function(i,index){
            $scope.messageList[i].options.splice(index,1);
        }

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
            var id   = $('#hid_id').val();
            var name = $('#temp-name').val();
            if(name){
                var load_index = layer.load(
                    2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
                );
                $.ajax({
                    'type'   : 'post',
                    'url'   : '/wxapp/goods/saveMessageList',
                    'data'  : {id: id,name: name,messageList: $scope.messageList},
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(load_index);
                        layer.msg(ret.em);
                        window.location.href = "/wxapp/goods/messageList";
                    }
                });
            }else{
                layer.msg("请完善模板信息");
            }
        };
    }]);

</script>

<?php }} ?>

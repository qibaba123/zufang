<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:57:52
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/memberCard/add-card.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13698368315e4df5b02eb7d6-11383154%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c469a7d67eed7f5786b06a9e8774545bda6d29d' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/memberCard/add-card.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13698368315e4df5b02eb7d6-11383154',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'color' => 0,
    'key' => 0,
    'row' => 0,
    'cal' => 0,
    'type' => 0,
    'tal' => 0,
    'levelList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df5b034bb90_24241991',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df5b034bb90_24241991')) {function content_5e4df5b034bb90_24241991($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/store/memberCard/css/index.css">
<link rel="stylesheet" href="/public/manage/store/memberCard/css/style.css">
<div class="preview-page" ng-app="cardApp" ng-controller="cardCtrl" style="padding-bottom:70px;">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                会员卡详情
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="card-detail">
                        <div class="card-box">
                            <div class="card-item" ng-class="cardInfo.cardColor">
                                <div class="card-type">{{cardInfo.cardType}}</div>
                                <div class="card-name">
                                    <div class="avatar">
                                        <img src="/public/manage/store/memberCard/images/avatar.png" alt="头像">
                                    </div>
                                    <h3><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
{{cardInfo.cardType}}</h3>
                                </div>
                                <div class="card-info">
                                    <p ng-bind="cardInfo.title"></p>
                                    <span ng-bind="cardInfo.fuTitle"></span>
                                </div>
                                <div class="limit-date">
                                    <p>【有效期{{cardInfo.limitMonth}}天，不可退换】</p>
                                    <span>售价:￥{{cardInfo.price}}元</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-intro">
                            <h4 class="border-b">会员卡权益</h4>
                            <div class="intro-txt" id="rightsShow">
                            </div>
                        </div>
                        <div class="card-intro">
                            <h4 class="border-b">使用须知</h4>
                            <div class="intro-txt" id="useNoticeShow">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con">
            <div class="card-manage ">
                <div class="input-rows">
                    <label for="">会员卡标题：</label>
                    <input type="text" class="cus-input" ng-model="cardInfo.title">
                </div>
                <div class="input-rows">
                    <label for="">副标题：</label>
                    <input type="text" class="cus-input" ng-model="cardInfo.fuTitle">
                </div>
                <div class="input-rows">
                    <label for="">卡颜色：</label>
                    <div style="padding: 5px 0;width: 100%;">
                        <div class="radio-box">
                            <?php  $_smarty_tpl->tpl_vars['cal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cal']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['color']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cal']->key => $_smarty_tpl->tpl_vars['cal']->value) {
$_smarty_tpl->tpl_vars['cal']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cal']->key;
?>
                            <span data-val="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" ng-click="changeCardcolor($event)">
                                <input type="radio" name="color" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['oc_bg_type']==$_smarty_tpl->tpl_vars['key']->value) {?>checked<?php }?> id="type<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" >
                                <label for="type<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-color="<?php echo $_smarty_tpl->tpl_vars['cal']->value['color'];?>
" data-key="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['cal']->value['name'];?>
</label>
                            </span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="">卡类型：</label>
                    <div style="padding: 5px 0;width: 100%;">
                        <div class="radio-box">
                            <?php  $_smarty_tpl->tpl_vars['tal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tal']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tal']->key => $_smarty_tpl->tpl_vars['tal']->value) {
$_smarty_tpl->tpl_vars['tal']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tal']->key;
?>
                            <span data-val="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" ng-click="changeCardType($event)">
                                <input type="radio" name="type" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['row']->value['oc_long_type']==$_smarty_tpl->tpl_vars['key']->value) {?>checked<?php }?> id="type<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" >
                                <label for="type<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-long="<?php echo $_smarty_tpl->tpl_vars['tal']->value['long'];?>
" data-key="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['tal']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['tal']->value['name'];?>
</label>
                            </span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="">可消费次数：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="0表示不限次数（默认）" ng-model="cardInfo.times">
                            <span class="input-group-addon">次</span>
                        </div>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="">价格：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.price">
                            <span class="input-group-addon">元</span>
                        </div>
                    </div>
                </div>
                <div class="input-rows">
                    <label for="" style="width: 125px;!important;">虚拟开卡人数：</label>
                    <input type="text" class="cus-input" ng-model="cardInfo.fictitiousNum">
                </div>
                <!--
                <div class="line"></div>
                <div class="input-rows form-group">
                    <label for="">会员返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct0">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']&&$_smarty_tpl->tpl_vars['row']->value['tc_level']>0) {?>
                <div class="input-rows">
                    <label for="">上级返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct1">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']&&$_smarty_tpl->tpl_vars['row']->value['tc_level']>1) {?>
                <div class="input-rows form-inline">
                    <label for="">上二级返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct2">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['tc_level']&&$_smarty_tpl->tpl_vars['row']->value['tc_level']>2) {?>
                <div class="input-rows">
                    <label for="">上三级返现：</label>
                    <div style="width: 100%">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardInfo.deduct3">
                            <span class="input-group-addon">％</span>
                        </div>
                    </div>
                </div>
                <?php }?>
                -->
                <div class="line"></div>
                <div class="input-rows">
                    <label for="">会员身份：</label>
                    <select class="cus-input form-control" ng-model="cardInfo.identity"  ng-options="x.ml_id as x.ml_name for x in levelList" ></select>
                </div>
                <div class="input-rows">
                    <label for="">会员卡权益：</label>
                    <textarea class="cus-input" rows="4" id="rights" ng-model="cardInfo.rights"></textarea>
                </div>
                <div class="input-rows">
                    <label for="">使用须知：</label>
                    <textarea class="cus-input" rows="4" id="useNotice" ng-model="cardInfo.useNotice"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveCard()"> 保 存 </button></div>
</div>
<script src="/public/manage/store/memberCard/layer/layer.js"></script>
<script src="/public/manage/store/memberCard/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/store/memberCard/js/angular-root.js"></script>
<script>
    var app = angular.module('cardApp',['RootModule']);
    app.controller('cardCtrl', ['$scope','$http', function($scope,$http){

        $scope.cardInfo = {
            title       : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_name'];?>
",
            identity    : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_identity'];?>
",
            fuTitle     : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_name_sub'];?>
",
            cardColor   : "<?php echo $_smarty_tpl->tpl_vars['row']->value['color'];?>
",
            bgType      : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_bg_type'];?>
",
            cardType    : "<?php echo $_smarty_tpl->tpl_vars['row']->value['type'];?>
",
            longType    : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_long_type'];?>
",
            //limitMonth  : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_long'];?>
",
            'limitMonth': '<?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['row']->value['oc_long_type']]['long'];?>
',
            times       : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_times'];?>
",
            price       : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_price'];?>
",
            rights      : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_rights'];?>
",
            useNotice   : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_notice'];?>
",
            deduct0     : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_0f_deduct'];?>
",
            deduct1     : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_1f_deduct'];?>
",
            deduct2     : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_2f_deduct'];?>
",
            deduct3     : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_3f_deduct'];?>
",
            addOpenNum  : "<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_add_open_num'];?>
"
        };
        $scope.levelList = <?php echo $_smarty_tpl->tpl_vars['levelList']->value;?>
;
        /*更改会员卡颜色*/
        $scope.changeCardcolor = function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var value = that.next().data('color');
            var type  = that.next().data('key');
            that.get(0).checked=true;
            $scope.cardInfo.cardColor   = value;
            $scope.cardInfo.bgType      = type;
        };
        /*更改会员卡类型*/
        $scope.changeCardType = function($event){
            $event.preventDefault();
            var that  = $($event.target).prev('input:eq(0)');
            var name  = that.next().data('name');
            var long  = that.next().data('long');
            var type  = that.next().data('key');
            that.get(0).checked=true;
            $scope.cardInfo.cardType   = name;
            $scope.cardInfo.limitMonth = long;
            $scope.cardInfo.longType   = type;
        };
        $scope.saveCard = function(){
            var data = {
                'id'        : '<?php echo $_smarty_tpl->tpl_vars['row']->value['oc_id'];?>
',
                'name' 	    : $scope.cardInfo.title,
                'identity' 	: $scope.cardInfo.identity,
                'name_sub' 	: $scope.cardInfo.fuTitle,
                'bg_type' 	: $scope.cardInfo.bgType,
                'long_type' : $scope.cardInfo.longType,
                'times'     : $scope.cardInfo.times,
                'price'     : $scope.cardInfo.price,
                'rights'    : $scope.cardInfo.rights,
                'notice'    : $scope.cardInfo.useNotice,
                '0f_deduct' : $scope.cardInfo.deduct0,
                '1f_deduct' : $scope.cardInfo.deduct1,
                '2f_deduct' : $scope.cardInfo.deduct2,
                '3f_deduct' : $scope.cardInfo.deduct3,
                'add_open_num' : $scope.cardInfo.addOpenNum
            };

            var loading = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            $http({
                method: 'POST',
                url:    '/wxapp/membercard/saveCard',
                data:   data
            }).then(function(response) {
                console.log(response);
                layer.close(loading);
                layer.msg(response.data.em);
                if(response.data.ec == 200){
                    //window.location.href = '/wxapp/membercard/card';
                    window.location.href = '/wxapp/membercard/storeCfg';
                }
            });
        };
        $(function(){
            $("#rightsShow").html($scope.cardInfo.rights.split("\n").join("<br />"));
            $("#useNoticeShow").html($scope.cardInfo.useNotice.split("\n").join("<br />"));
            $("#rights").on('input', function(event) {
                var curVal = $(this).val();
                $scope.cardInfo.rights = curVal ;
                var showVal = curVal.split("\n").join("<br />");
                $("#rightsShow").html(showVal);
            });
            $("#useNotice").on('input', function(event) {
                var curVal = $(this).val();
                $scope.cardInfo.useNotice = curVal ;
                var showVal = curVal.split("\n").join("<br />");
                $("#useNoticeShow").html(showVal);
            });
        });
    }]);
</script><?php }} ?>

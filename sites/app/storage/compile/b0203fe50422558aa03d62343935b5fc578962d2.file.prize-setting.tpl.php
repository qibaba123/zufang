<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:13:32
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/collection/prize-setting.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15659085755dea1bbc172dc6-71672764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b0203fe50422558aa03d62343935b5fc578962d2' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/collection/prize-setting.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15659085755dea1bbc172dc6-71672764',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'applet' => 0,
    'row' => 0,
    'coupon' => 0,
    'couponJson' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1bbc1a3ce4_30562858',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1bbc1a3ce4_30562858')) {function content_5dea1bbc1a3ce4_30562858($_smarty_tpl) {?><script>
    //console.log('<?php echo json_encode($_smarty_tpl->tpl_vars['link']->value);?>
');
</script>
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css">
<style>

    .fenlei-nav ul { background-color: #fff; }
    .fenlei-nav li img { -webkit-border-radius: 25px; -moz-border-radius: 25px; -ms-border-radius: 25px; border-radius: 25px; }
    .good-list-wrap .good-list{padding: 0 4px;}
    .good-list-wrap .good-view2 .good-item{padding: 4px;box-sizing: border-box;}
    .good-list-wrap .good-view2 .item-wrap{padding: 0;}
    .good-list-wrap .good-view2 .good-image {width: 100%;height: 150px;}
    .good-list-wrap .good-view2 .good-title { text-align: left; }
    .good-list-wrap .good-view2 .price-buy{text-align: left;}
    .good-list-wrap .good-view2 .price-buy .sold{text-align: right;color: #999;font-size: 12px;}
    .recommend-img { padding: 0 4px 10px; overflow: hidden;margin-bottom: 8px; }
    .recommend-img .img-item { padding: 4px; box-sizing: border-box; float: left;margin: 0; width: 50%; height: 100px; }
    .fenleinav-manage .edit-img { -webkit-border-radius: 50%; -moz-border-radius: 50%; -ms-border-radius: 50%; border-radius: 50%; }
    .recommend-manage { padding: 15px; }
    .recommend-manage .edit-img { float: none; width: 90%; -webkit-border-radius: 0; -moz-border-radius: 0; -ms-border-radius: 0; border-radius: 0; height: auto; margin: 0 auto 8px; }
    .recommend-manage .edit-txt { float: none; width: 100% }
    .fenlei-nav ul { white-space: normal; }
    .recommend-img .img-item { width: 100%;height: auto;}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--<div style="margin-left:135px;"><a target="_blank" style="color:red; " href="
http://p18m0a32n.bkt.clouddn.com/%E7%A0%8D%E4%BB%B7.mp4">该插件使用教程请点此查看</a></div>-->
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar ">
                收藏有礼
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="" data-id="1" style="height: 100%;display: block">
                        <div class="banner-wrap" style="position: relative">
                            <img src="/public/wxapp/images/collection-prize-bg-new.png" alt="" style="position: absolute;width: 100%">
                            <p style="position: relative;top: 295px;width: 86%;line-height: 1.5em;margin: auto;font-size: 12px;">2、在微信发现-小程序中点击我的小程序，并在下方上传正确截图即可获得"<span style="color: red">{{couponJson[couponId]}}</span>"</p>
                            <div>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['applet']->value['ac_avatar'];?>
" style="width: 28px;position: relative;top: 332px;border-radius: 50%;left: 57px;display: inline-block;" />
                                <span style="width: 175px;position: relative;top: 332px;left: 63px;display: inline-block;font-size: 12px;"><?php echo $_smarty_tpl->tpl_vars['applet']->value['ac_name'];?>
</span>
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
            <div class="banner" data-right-edit data-id="1" style="display:block;">
                <div class="prize-manage" style="margin-bottom: 15px">
                    <label for="">优惠券：</label>
                    <select class="cus-input" ng-model="couponId"  >
                        <option ng-repeat="coupon in couponList" value="{{coupon.cl_id}}">{{coupon.cl_name}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm"  ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.demoImg = '<?php echo $_smarty_tpl->tpl_vars['row']->value['acp_demo_img'];?>
'? '<?php echo $_smarty_tpl->tpl_vars['row']->value['acp_demo_img'];?>
' : '/public/manage/img/zhanwei/zw_fxb_75_30.png';
        $scope.couponId = '<?php echo $_smarty_tpl->tpl_vars['row']->value['acp_coupon_id'];?>
';
        $scope.couponList = <?php echo $_smarty_tpl->tpl_vars['coupon']->value;?>
;
        $scope.couponJson = <?php echo $_smarty_tpl->tpl_vars['couponJson']->value;?>
;

        $scope.changeDemoImg=function(){
            if(imgNowsrc){
                $scope.demoImg = imgNowsrc;
            }
        };
        // 保存数据
        $scope.saveData = function(){
            layer.confirm('确定要保存吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                },{
                    time : 10*1000
                });

                var data = {
                    'demoImg' 	    : $scope.demoImg,
                    'couponId'      : $scope.couponId,
                };
                console.log(data);
                $http({
                    method: 'POST',
                    url:    '/wxapp/collectionprize/saveSetting',
                    data:   data
                }).then(function(response) {
                    layer.close(index);
                    layer.msg(response.data.em);
                });
            });
        };
    }]);
    //图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    //call the function that was passed
                    console.log(attrs.imageonload);
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
        console.log(imgNowsrc);

    }
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

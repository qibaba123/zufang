<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:19:09
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/service/msg-setting.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21269151605e4dfaaddafc15-07165653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '069de32c722a6fd59c19626566137a80983e2180' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/service/msg-setting.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21269151605e4dfaaddafc15-07165653',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'quickLink' => 0,
    'type' => 0,
    'val' => 0,
    'msg' => 0,
    'appletCfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4dfaaddfd258_20720774',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4dfaaddfd258_20720774')) {function content_5e4dfaaddfd258_20720774($_smarty_tpl) {?><link rel="stylesheet" href="/public/plugin/emoji/lib/css/jquery.mCustomScrollbar.min.css"/>
<link rel="stylesheet" href="/public/plugin/emoji/dist/css/jquery.emoji.css"/>
<link rel="stylesheet" href="/public/plugin/emoji/lib/css/railscasts.css"/>
<link rel="stylesheet" href="/public/manage/css/auto-replay.css"/>
<style>
    .reply-header span {
        width: 100px;
    }
    .reply-content .reply-detail {
        display: inherit;
    }
    .img-upload>div p {
        line-height: 4.5;
    }
    .edit-con {
        width: 100%;
        margin-top: 135px;
        border: 1px solid #D1D1D1;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        position: relative;
        background-color: #fff;
        padding: 10px 20px;
        margin-bottom: 35px;
    }
</style>

<div class="reply" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                消息预览
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="touxiang"><img ng-src="{{appCover}}" alt="头像" style="border-radius: 4px"></div>
                    <div class="msg-show" id="msg-show" ng-show="msgType=='text'" style="display: inline-block;max-width: 250px;">
                        <div ng-bind-html="msgContent" style="margin-top: 2px;background: #fff;border-radius: 4px;margin-left: 10px;padding: 6px 8px;word-break: break-all;"></div>
                    </div>
                    <div class="msg-show" id="msg-show" ng-show="msgType=='image'" style="display: inline-block;max-width: 250px;">
                        <img ng-src="{{msgCover}}" alt="" style="width: 150px;border-radius: 4px;">
                    </div>
                    <div class="msg-show" id="msg-show" ng-show="msgType=='link'" style="display: inline-block;width: 250px;">
                        <div style="margin-top: 2px;background: #fff;border-radius: 4px;margin-left: 10px;padding: 6px 8px;word-break: break-all;">
                            <div ng-bind="msgTitle"></div>
                            <div>
                                <div ng-bind="msgDesc" style="width: 78%;display: inline-block;font-size: 12px;color: gray;height: 45px;vertical-align: top;padding-top: 5px;"></div>
                                <img ng-src="{{msgCover}}" alt="" style="width: 45px;display: inline-block;">
                            </div>
                        </div>
                    </div>
                    <div class="msg-show" id="msg-show" ng-show="msgType=='miniprogrampage'" style="display: inline-block;max-width: 250px;">
                        <div style="margin-top: 2px;background: #fff;border-radius: 4px;margin-left: 10px;padding: 6px 8px;word-break: break-all;">
                            <div style="margin-bottom: 10px">
                                <img ng-src="{{appCover}}" alt="" style="width: 20px;border-radius: 50%;display: inline-block">
                                <div style="display: inline-block;font-size: 12px;position: relative;top: 1px;left: 3px">{{appName}}</div>
                            </div>
                            <div ng-bind="msgTitle"></div>
                            <div>
                                <img ng-src="{{msgCover}}" alt="" style="margin-top: 10px;width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div style="margin-left:370px;padding-top:1px;">
        <div class="keyword-content">
            <div class="edit-con">
                <div class="row" style="height: 35px">
                    <div class="form-group col-sm-2 text-right">
                        <label for="" style="line-height: 35px;">关键字：</label>
                    </div>
                    <div class="form-group col-sm-10" >
                        <input type="text" class="form-control" placeholder="请填写关键字"  ng-model="msgKeyword">
                    </div>
                </div>
                <span style="color: red;position: relative;left: -68px;">注：关键字设置为空，表示当未匹配到关键字时，给的默认回复</span>
            </div>
        </div>
        <div class="auto-reply">
            <div class="reply-header">
                <span ng-class="msgType=='text'?'active':''" data-type="text" ><i class="icon-edit"></i>文字</span>
                <span ng-class="msgType=='image'?'active':''" data-type="image" ><i class="icon-picture"></i>图片</span>
                <span ng-class="msgType=='link'?'active':''" data-type="link" ><i class="icon-picture"></i>图文</span>
                <span ng-class="msgType=='miniprogrampage'?'active':''" data-type="miniprogrampage"><i class="icon-picture"></i>小程序卡片</span>
            </div>
            <div class="reply-content">
                <div class="reply-detail" ng-show="msgType=='text'">
                    <textarea name="editor" id="editor" onmouseup="getPosition(this)" oninput="getPosition(this)" ng-model="msgContent"></textarea>
                </div>
                <div class="reply-detail" ng-show="msgType=='image'">
                    <div style="text-align: center;padding: 30px;">
                        <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="640" data-height="640" imageonload="changeMsgCover()" data-dom-id="upload-msgImageCover" id="upload-msgImageCover"  ng-src="{{msgCover}}"  width="40%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="msgImageCover" class="avatar-field bg-img" name="msgCover" ng-value="msgCover"/>
                    </div>
                </div>
                <div class="reply-detail" ng-show="msgType=='link'">
                    <div class="reply-container" style="width: 90%;margin-top: 15px">
                        <div class="row" style="margin-bottom: 10px;height: 45px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">标题</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写图文标题" required="required" ng-model="msgTitle">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;height: 85px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">描述</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <textarea class="form-control" cols="30" rows="3" placeholder="请填写图文描述" ng-model="msgDesc"></textarea>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;height: 45px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">图文链接</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写图文链接" required="required" ng-model="msgUrl">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;height: 230px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">封面图</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <div>
                                    <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="640" data-height="640" imageonload="changeMsgCover()" data-dom-id="upload-msgLinkCover" id="upload-msgLinkCover"  ng-src="{{msgCover}}"  width="60%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="msgLinkCover" class="avatar-field bg-img" name="msgCover" ng-value="msgCover"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reply-detail" ng-show="msgType=='miniprogrampage'">
                    <div class="reply-container" style="width: 90%;margin-top: 15px">
                        <div class="row" style="margin-bottom: 10px;height: 45px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">标题</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写小程序卡片标题" required="required" ng-model="msgTitle">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;height: 45px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">小程序路径</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写小程序卡片路径" required="required" ng-model="msgPath">
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;height: 260px">
                            <div class="form-group col-sm-3 text-right">
                                <label for="" style="line-height: 35px;">封面图</label>
                            </div>
                            <div class="form-group col-sm-9" >
                                <div>
                                    <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="540" data-height="416" imageonload="changeMsgCover()" data-dom-id="upload-msgMiniprogrampageCover" id="upload-msgMiniprogrampageCover"  ng-src="{{msgCover}}"  width="60%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="msgMiniprogrampageCover" class="avatar-field bg-img" name="msgCover" ng-value="msgCover"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reply-footer" ng-show="msgType=='text'" >
                <div class="emotion">
                    <div class="remain-chars pull-right">还可以输入<span class="num"></span>个字</div>
                </div>
                <div class="insert-text">
                    <?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable('text', null, 0);?>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['quickLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['type']->value!=$_smarty_tpl->tpl_vars['val']->value['type']) {?><BR/><?php }?>
                    <span class="insert-txt <?php $_smarty_tpl->tpl_vars['type'] = new Smarty_variable($_smarty_tpl->tpl_vars['val']->value['type'], null, 0);?>" data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" data-content='<?php echo $_smarty_tpl->tpl_vars['val']->value['content'];?>
'><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</span>
                    <?php } ?>
                    <br/>
                    <span data-toggle="modal" data-target="#customLink" class="btn btn-xs btn-success">自定义链接</span>
                </div>
            </div>     
        </div>
        <div class="btn-box">
            <input type="hidden" name="type" id="type" value="<?php echo $_smarty_tpl->tpl_vars['msg']->value['wm_type'];?>
">
            <button class="btn btn-success btn-sm save-btn" ng-click="saveMsg()">保存</button>
        </div>
    </div>
    <div class="modal fade" id="customLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">
                        添加自定义链接
                    </h4>
                </div>
                <div class="modal-body">
                    <div style="padding:20px;">
                        <form role="form">
                            <div class="input-group" style="width: 100%;">
                                <span class="input-group-addon" style="width: 132px;">链接文本</span>
                                <input type="text" class="form-control" placeholder="请输入链接文本" id="cusLinkName">
                            </div>
                            <div class="input-group" style="width: 100%;">
                                <span class="input-group-addon" style="width: 132px;">链接地址(可选)</span>
                                <input type="text" class="form-control" placeholder="请输入链接地址（可选）" id="cusLink">
                            </div>
                            <div class="input-group" style="width: 100%;">
                                <span class="input-group-addon" style="width: 132px;">小程序路径(可选)</span>
                                <input type="text" class="form-control" placeholder="请输入小程序路径（可选）" id="cusPath">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                    </button>
                    <button type="button" class="btn btn-primary" ng-click="insertLink()">
                        插入
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/emoji/lib/script/highlight.pack.js"></script>
<script type="text/javascript" src="/public/plugin/emoji/lib/script/jquery.mousewheel-3.0.6.min.js"></script>
<script type="text/javascript" src="/public/plugin/emoji/lib/script/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/weixin.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/manage/newTemTwo/js/angular-sanitize.min.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable", "ngSanitize"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.msgType    = '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_type'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_type'];?>
':'text';
        $scope.msgKeyword = '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_keyword'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_keyword'];?>
':'';
        $scope.msgContent = `<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_content'];?>
`?`<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_content'];?>
`:'回复内容';
        $scope.msgTitle   = '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_title'];?>
':'回复标题';
        $scope.msgDesc    = `<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_desc'];?>
`?`<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_desc'];?>
`:'回复描述';
        $scope.msgPath    = '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_path'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_path'];?>
':'';
        $scope.msgUrl     = '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_url'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_url'];?>
':'';
        $scope.msgCover   = '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_cover'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_cover'];?>
':'/public/manage/img/zhanwei/zw_fxb_200_200.png';
        $scope.appid      = '<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_appid'];?>
';
        $scope.appCover   = '<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_avatar'];?>
';
        $scope.appName    = '<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_name'];?>
';

        $scope.changeMsgCover=function(){
            if(imgNowsrc){
                $scope.msgCover = imgNowsrc;
            }
        };

        $scope.insertLink = function(){
            var link = $("#cusLink").val();
            var linkName =  $("#cusLinkName").val();
            var path =  $("#cusPath").val();
            var insertLink = '<a href="'+link+'" data-miniprogram-appid="'+$scope.appid+'" data-miniprogram-path="'+path+'">'+linkName+'</a>';
            var textObj = $("#editor");
            var val = textObj.val();
            var newVal = val.substr(0, cursorIndex) + insertLink + val.substr(cursorIndex, val.length);
            $scope.msgContent = newVal;
            $('#customLink').modal('hide');
        }

        $(function(){
            /*文字图片切换*/
            $(".reply-header").on('click', 'span', function(event) {
                $scope.msgType = $(this).data('type');
                $scope.$apply();
            });
            /*初始化剩余字符数*/
            remainChars();

            $(".insert-text").on('click', 'span.insert-txt', function(event) {
                var insertTxt = $(this).data('content');
                var textObj = $("#editor");
                var val = textObj.val();
                var newVal = val.substr(0, cursorIndex) + insertTxt + val.substr(cursorIndex, val.length);
                textObj.val(newVal);
            });
        });

        $scope.saveMsg = function () {
            var data = {
                'id'         : '<?php echo $_smarty_tpl->tpl_vars['msg']->value['asm_id'];?>
',
                'msgType'    : $scope.msgType,
                'msgKeyword' : $scope.msgKeyword,
                'msgContent' : $scope.msgContent,
                'msgTitle'   : $scope.msgTitle,
                'msgDesc'    : $scope.msgDesc,
                'msgPath'    : $scope.msgPath,
                'msgUrl'     : $scope.msgUrl,
                'msgCover'   : $scope.msgCover,
                'appid'      : $scope.appid,
                'appCover'   : $scope.appCover,
                'appName'    : $scope.appName,
            };
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/service/saveMessage',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.href = "/wxapp/service/msgList";
                    }
                }
            });
        }


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

    /*设置可输入字符数*/
    var totalChars = 600;
    var cursorIndex = 0;
    function remainChars(){
        // var imgNum = $("#editor").find('img').length;
        // var curNum = $("#editor").text().length+imgNum;
        var _editor = $("#editor");
        var curNum = _editor.val().length;

        var remainNum = totalChars - curNum;
        if(remainNum>=0){
            $(".remain-chars").find('.num').text(remainNum);
        }else{
            var curVal = _editor.val();
            _editor.val(curVal.substr(0,totalChars));
        }
    }

    /*获取光标索引*/
    function getPosition(obj) {
        remainChars();
        var cursurPosition=0;
        if(obj.selectionStart){ //非IE
            cursurPosition= obj.selectionStart;
        }else{ //IE
            try{
                var range = document.selection.createRange();
                range.moveStart("character",-obj.value.length);
                cursurPosition=range.text.length;
            }catch(e){
                cursurPosition = 0;
            }
        }
        cursorIndex = cursurPosition;
        // console.log(cursorIndex);
        return cursorIndex;
    }

    $('.clear-upload').on('click',function(){
        $('#g_cover').val();
        $('.img-upload').show();
        $('.img-show').hide();
    });
    $('.del-auto-reply').on('click',function(){
        layer.confirm('您确定要删除自动回复？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            delAutoReply();
        });
    });

</script><?php }} ?>

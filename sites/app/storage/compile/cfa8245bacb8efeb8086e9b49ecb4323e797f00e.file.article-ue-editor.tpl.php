<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 09:14:36
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/article-ue-editor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18963408765e853c7c1e6524-47099763%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfa8245bacb8efeb8086e9b49ecb4323e797f00e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/article-ue-editor.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18963408765e853c7c1e6524-47099763',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'curr_shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e853c7c1eb720_59986549',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e853c7c1eb720_59986549')) {function content_5e853c7c1eb720_59986549($_smarty_tpl) {?><!---引入kind edit---->
<script charset="utf-8" src="/public/plugin/ueditor/ueditor.config.js"></script>
<script charset="utf-8" src="/public/plugin/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/plugin/ueditor/lang/zh-cn/zh-cn.js"></script>

<script>
   var weddingTaocanDetailArray = [];
   $(function () {
       //UE.getEditor('_editor').render('_editor');
       var ue_textarea_name = $("input[name=ke_textarea_name]");
       UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
       UE.Editor.prototype.getActionUrl = function(action) {
           if (action == 'uploadimage' || action == 'uploadscrawl' || action == 'catchimage') {
               return '/admin/image/upload/common/default?dir=image&suid=<?php echo $_smarty_tpl->tpl_vars['curr_shop']->value["s_unique_id"];?>
';
           }else {
               return this._bkGetActionUrl.call(this, action);
           }
       };

       if (ue_textarea_name.length >= 1) {
           ue_textarea_name.each(function(index, element) {
               var name = $(element).val();
               var height = $('#'+name).css('height');
               var ue = UE.getEditor(name,{
                   toolbars: [
                       [
                           'source', '|',
                           'undo', 'redo', '|',
                           'pasteplain', 'autotypeset','formatmatch', 'preview', '|',
                           'print', 'template', '|' ,
                           'insertimage', 'horizontal', 'inserttable', 'emotion', 'pagebreak', 'anchor','link','unlink'
                       ],
                       [
                           'fontfamily','fontsize','backcolor','forecolor','justifyleft','justifyright','justifycenter','justifyjustify','insertorderedlist','insertunorderedlist','subscript','superscript', 'bold', 'indent' , 'italic',  'underline', 'strikethrough' ,'snapscreen','preview',
                           'spechars',   'drafts' , 'time','date', 'fontborder', 'blockquote', 'selectall', 'removeformat'
                       ],
                       [
                           'insertrow', 'insertcol', 'mergeright', 'mergedown', 'deleterow', 'deletecol', 'splittorows', 'splittocols',
                           'splittocells', 'deletecaption', 'inserttitle', 'mergecells', 'deletetable', 'cleardoc','fullscreen'
                       ]
                   ],
                   autoHeightEnabled: false,
                   autoFloatEnabled: false,
                   scaleEnabled: true
               });

               ue.ready(function () {
                   ue.setHeight(parseInt(height));
               })

               ue.addListener('afterExecCommand',function(t, e, arguments){
                   afterUploadImage(arguments);
               });

               function afterUploadImage(arguments) {
                   console.log(arguments);
                   if(arguments[0]=="inserthtml" || arguments[0]=="insertimage"){
                       ue.execCommand( 'insertparagraph' );
                       if(arguments[0]=="insertimage" && typeof addImageWater!="undefined" && addImageWater == 1){
                           var waterImages = [];
                           for(var i in arguments[1]){
                               waterImages.push(arguments[1][i].src);
                           }
                           setTimeout(function(){
                               $.ajax({
                                   'type'   : 'post',
                                   'url'   : '/wxapp/goods/addImageWater',
                                   'data'  : {'images': waterImages},
                                   'dataType'  : 'json',
                                   'success'   : function(ret){
                                   }
                               });
                           }, 5000)

                       }
                   }
               }

               ue.addListener("contentChange",function(){
                   var html = ue.getContent();
                   weddingTaocanDetailArray[index] = html;
                   console.log(weddingTaocanDetailArray);
                   if(html.length>=0 && $(element).data('show')!=false){
                       $("#article-con").html(html);
                   }
               });
           });
       }
   })

   function addUeEditor(name,index, eleIndex,height, controller) {
       if(!height){
           var height = $('#'+name).css('height');
       }
       UE.delEditor(name);
       var ue = UE.getEditor(name,{
           toolbars: [
               [
                   'source', '|',
                   'undo', 'redo', '|',
                   'pasteplain', 'autotypeset','formatmatch', 'preview', '|',
                   'print', 'template', '|' ,
                   'insertimage', 'horizontal', 'inserttable', 'emotion', 'pagebreak', 'anchor','link','unlink'
               ],
               [
                   'fontfamily','fontsize','backcolor','forecolor','justifyleft','justifyright','justifycenter','justifyjustify','insertorderedlist','insertunorderedlist','subscript','superscript', 'bold', 'indent' , 'italic',  'underline', 'strikethrough' ,'snapscreen','preview',
                   'spechars',   'drafts' , 'time','date', 'fontborder', 'blockquote', 'selectall', 'removeformat'
               ],
               [
                   'insertrow', 'insertcol', 'mergeright', 'mergedown', 'deleterow', 'deletecol', 'splittorows', 'splittocols',
                   'splittocells', 'deletecaption', 'inserttitle', 'mergecells', 'deletetable', 'cleardoc','fullscreen'
               ]
           ],
           autoHeightEnabled: false,
           autoFloatEnabled: false,
           scaleEnabled: true
       });

       ue.ready(function () {
           ue.setHeight(parseInt(height));
       })

       ue.addListener('afterExecCommand',function(t, e, arguments){
           afterUploadImage(arguments);
       });

       function afterUploadImage(arguments) {
           if(arguments[0]=="inserthtml" || arguments[0]=="insertimage"){
               ue.execCommand( 'insertparagraph' );
           }
       }

       ue.addListener("contentChange",function(){
           var html = ue.getContent();
           weddingTaocanDetailArray[index] = html;
           console.log(weddingTaocanDetailArray);
           if(controller){
               var controllerScope = $('div[ng-controller="'+controller+'"]').scope();
               controllerScope.selectedComponents[eleIndex].data.detail = html;
               $("#article-con"+index).html(html);
               controllerScope.$apply();
           }
           if(html.length>=0 && $("#article-detail"+index).data('show')!=false){
               $("#article-con").html(html);
           }
       });
   }


    /*ue.ready(function () {
        //获取html内容，返回: <p>hello</p>
        var html = ue.getContent();
    });*/

    /*function createUeditor() {

        var shellId = 'article';

        //window.UEDITOR_HOME_URL = "/resources/js/lib/ueditor/";

        //window.UEDITOR_CONFIG.langPath = '/resources/js/lib/ueditor/lang/zh-cn/';
        window.UEDITOR_CONFIG.maximumWords = 140;
        window.UEDITOR_CONFIG.initialFrameHeight = 120;
        window.UEDITOR_CONFIG.initialFrameWidth = 530;
        var editor = new UE.ui.Editor();
        editor.render(shellId);

        editor.ready(function(){
            //alert('fuck ready'+editor.getAllHtml());
            $('#' + shellId + ' #edui1_toolbarbox').css('display','none');
            editor.fireEvent("contentChange");

            var $textarea = $('#' + shellId + '').parent().find('iframe').contents();
            //$('#' + shellId + '').parent().find('iframe');

            var fn = function(){
                alert(editor.getContent());
            }

            if (document.all) {
                $textarea.get(0).attachEvent('onpropertychange',function(e) {
                    fn();
                });
            }else{
                $textarea.on('input',fn);
            }

        });

        //事件
        editor.addListener("contentChange",function(){
            console.log('内容改变:'+editor.getContent());
            //var d = editor.getContent();
        });

        return editor;
    }
    createUeditor();*/
</script>
<!---引入kind edit---->

<?php }} ?>

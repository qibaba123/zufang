<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:35:45
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/article-kind-editor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20449341535e1be59158c206-48114641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f6815738893d102ffaa5a415555f6501ff78c93' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/article-kind-editor.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20449341535e1be59158c206-48114641',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'curr_shop' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be5915be3c8_01929213',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be5915be3c8_01929213')) {function content_5e1be5915be3c8_01929213($_smarty_tpl) {?><!---引入kind edit---->
<link rel="stylesheet" href="/modules/common/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/modules/common/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/modules/common/kindeditor/kindeditor-all.js"></script>
<script charset="utf-8" src="/modules/common/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/modules/common/kindeditor/plugins/code/prettify.js"></script>

<script>
    var weddingTaocanDetailArray = [];
    KindEditor.lang({
        'template.fileList' : {
            '1.html' : '图片和文字',
            '2.html' : '表格',
            '3.html' : '项目编号',
            'jianyi.html' : '建议模板'
        }
    }, 'zh_CN');

    KindEditor.ready(function(K) {
        var full_items = [
            'source', '|',
            'undo', 'redo', '|',
            'plainpaste', 'quickformat', 'preview', '|',
            'print', 'template', 'shcode', 'wordpaste', '|',
            'image', 'multiimage', 'hr', 'table', 'emoticons', 'pagebreak', 'anchor', 'link', 'unlink', '|','fullscreen','/',
            'formatblock', 'fontname', 'fontsize', '|',
            'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat','|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript', 'superscript', 'clearhtml', 'selectall', '|'

        ];
        var simplify_items = [
            'undo', 'redo', '|',
            'image', 'multiimage', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyfull','|'
        ];
        var items = "<?php echo $_smarty_tpl->tpl_vars['items']->value=='simplify';?>
"?simplify_items:full_items;

        var ke_textarea_name = $("input[name=ke_textarea_name]");
        // console.log(ke_textarea_name);
        var type = $("#ke_textarea_name").data('type');
        // console.log(type);
        if (ke_textarea_name.length >= 1) {
            ke_textarea_name.each(function(index, element) {
                let item=items;
                var name = $(element).val();

                var items_type = $(element).data('items');
                if(items_type == 'simple')
                    item=simplify_items;

                K.create('textarea[name="'+name+'"]', {
                    cssPath : '/modules/common/kindeditor/plugins/code/prettify.css',
                    uploadJson : '/admin/image/upload/common/default?suid=<?php echo $_smarty_tpl->tpl_vars['curr_shop']->value["s_unique_id"];?>
',
                    filePostName : 'files[imageFile]',
                    allowFileManager : false,
                    items : item,
                    afterBlur  : function() {
                        this.sync();
                        K.ctrl(document, 13, function() {
                            K('form[name=edit-form]')[0].submit();
                        });
                        K.ctrl(this.edit.doc, 13, function() {
                            K('form[name=edit-form]')[0].submit();
                        });
                    },
                    afterChange : function() {
                        this.sync();
                        var html = this.html();
                        var index = $('textarea[name="'+name+'"]').parents('.jianzheng-manage').index();
                        weddingTaocanDetailArray[index] = html;
                        if(html.length>=0 && $(element).data('show')!=false){
                            $("#article-con").html(html);
                        }
                    } 
                });

            });

        }
        prettyPrint();
    });


    function create_kindEditor(name,index, eleIndex,height, controller) {
        KindEditor.ready(function(K) {
            var full_items = [
                'source', '|',
                'undo', 'redo', '|',
                'plainpaste', 'quickformat', 'preview', '|',
                'print', 'template', 'shcode', 'wordpaste', '|',
                'image', 'multiimage', 'hr', 'table', 'emoticons', 'pagebreak', 'anchor', 'link', 'unlink', '/',
                'formatblock', 'fontname', 'fontsize', '|',
                'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat','|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript', 'superscript', 'clearhtml', 'selectall', '|'

            ];
            K.create('textarea[name="'+name+'"]', {
                cssPath : '/modules/common/kindeditor/plugins/code/prettify.css',
                uploadJson : '/admin/image/upload/common/default',
                filePostName : 'files[imageFile]',
                allowFileManager : false,
                items : full_items,
                afterBlur  : function() {
                    this.sync();
                    K.ctrl(document, 13, function() {
                        K('form[name=edit-form]')[0].submit();
                    });
                    K.ctrl(this.edit.doc, 13, function() {
                        K('form[name=edit-form]')[0].submit();
                    });
                },
                afterChange : function() {
                    this.sync();
                    var html = this.html();
                    //var index = $('textarea[name="'+name+'"]').parents('.jianzheng-manage').index();
                    weddingTaocanDetailArray[index] = html;
                    if(controller){
                        console.log(index);
                        console.log(name);
                       var controllerScope = $('div[ng-controller="'+controller+'"]').scope();
                       controllerScope.selectedComponents[eleIndex].data.detail = html;
                       $("#article-con"+index).html(html);
                       controllerScope.$apply();
                   }
                    if(html.length>0){
                        $("#article-con").html(html);
                    }

                }
            });
            prettyPrint();
        });
    }

    function add_kindeditor(name) {
        // console.log(name);
        create_kindEditor(name);
    }
</script>
<!---引入kind edit---->

<?php }} ?>

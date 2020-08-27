<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:05:52
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/article-kind-editor-other.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5300246885e4df7908eca34-38405023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4cc458eacd01ce5ef7329272b9354dfeb6193503' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/article-kind-editor-other.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5300246885e4df7908eca34-38405023',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df7908f0428_72643922',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df7908f0428_72643922')) {function content_5e4df7908f0428_72643922($_smarty_tpl) {?><!---引入kind edit---->
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
            'image', 'multiimage', 'hr', 'table', 'emoticons', 'pagebreak', 'anchor', 'link', 'unlink', '/',
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
        if (ke_textarea_name.length >= 1) {
            ke_textarea_name.each(function(index, element) {
                var name = $(element).val();
                K.create('textarea[name="'+name+'"]', {
                    cssPath : '/modules/common/kindeditor/plugins/code/prettify.css',
                    uploadJson : '/admin/image/upload/common/default',
                    filePostName : 'files[imageFile]',
                    allowFileManager : false,
                    items : items,
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
                        weddingTaocanDetailArray[index-1] = html;
                        if(html.length>=0){
                            if(index<0){
                                $("#article-con").html(html);
                            }
                        }
                        
                    } 
                });

            });

        }
        prettyPrint();
    });


    function create_kindEditor(name) {
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
                    var index = $('textarea[name="'+name+'"]').parents('.jianzheng-manage').index();
                    weddingTaocanDetailArray[index] = html;
                    if(html.length>0){
                        $("#article-con").html(html);
                        $("#article-content").html(html);
                    }

                }
            });
            prettyPrint();
        });
    }

    function add_kindeditor(name) {
        console.log(name);
        create_kindEditor(name);
    }
</script>
<!---引入kind edit---->

<?php }} ?>

<?php /* Smarty version Smarty-3.1.17, created on 2020-02-18 21:23:29
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/common-kind-editor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20323386345e4be5514d3e48-11488218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f1e3047024c158e92c52f906c3f4ff8ab7f7924' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/common-kind-editor.tpl',
      1 => 1561447904,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20323386345e4be5514d3e48-11488218',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4be5514d7505_47641529',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4be5514d7505_47641529')) {function content_5e4be5514d7505_47641529($_smarty_tpl) {?><!---引入kind edit---->
<link rel="stylesheet" href="/modules/common/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/modules/common/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="/modules/common/kindeditor/kindeditor-all.js"></script>
<script charset="utf-8" src="/modules/common/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/modules/common/kindeditor/plugins/code/prettify.js"></script>

<script>
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
                var readonly = $(element).data('readonly');
                K.create('textarea[name="'+name+'"]', {
                    cssPath : '/modules/common/kindeditor/plugins/code/prettify.css',
                    uploadJson : '/admin/image/upload/common/default',
                    filePostName : 'files[imageFile]',
                    allowFileManager : false,
                    readonlyMode : readonly==1?true:false,
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
                });

            });

        }
        prettyPrint();
    });
</script>
<!---引入kind edit---->

<?php }} ?>

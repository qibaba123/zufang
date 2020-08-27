<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:46:11
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/help-center-info-edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6903750505e4df2f38912d2-66538707%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4321521d18854b20b683857b254ac62bc4ede6e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/currency/help-center-info-edit.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6903750505e4df2f38912d2-66538707',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'headTitle' => 0,
    'row' => 0,
    'now' => 0,
    'shop' => 0,
    'cropper' => 0,
    'curr_sid' => 0,
    'category_select' => 0,
    'key' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df2f38de3f6_46359185',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df2f38de3f6_46359185')) {function content_5e4df2f38de3f6_46359185($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/wechatArticle.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
    .topic>div.part{
        display: inline-block;
        width: 50%;
        float: left;
    }
    .goods-button{
        padding: 3px 6px !important;
        font-weight: bold;
    }
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .goods-selected{
        padding: 1px 2px;
        margin: 0 2px;
        position: relative;
    }
    .goods-selected-name{
        font-weight: bold;
        color: #38f;
        width: 90%;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }
    .goods-selected-button{
        width: 9%;
        display: inline-block;
        padding-left: 2px;
    }
    .add-related-box{
        text-align: center;
    }
    .related-info{
        margin-bottom: 10px;
        height: 35px;
        line-height: 35px;
    }
    .btn-remove-info{

    }
    .related-info-cate{
        width: 35%;
        float: left;
        margin-right: 10px;
    }
    .related-info-detail{
        width: 49%;
        float: left;
        margin-right: 20px;
    }

    #edui1_imagescale{
        display:none !important;
    }

    #edui140_content{
        display:none !important;
    }

    .setting-save {
        z-index: 1088;
    }
    .recommentGoods, .recommentAppointmentGoods{
        background: #fff;
        padding: 10px;
        border-radius: 4px;
    }

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../article-ue-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<!--
<div class="edit-con" style="margin: 30px auto;text-align: center;width: 60%;">
    <select name="article-link-type" id="article-link-type" style="width: 20%;float: left;" class="form-control">
        <option value="1">网页链接</option>
        <option value="2">公众号文章链接</option>
    </select>
    <input type="text" id="fetch-url"  placeholder="网页链接" style="width: 60%">
    <a href="javascript:void(0)" id="fetch-content" class="btn btn-sm btn-success">提取页面内容</a>
</div>
-->
<div class="preview-page">
    <div class="mobile-page">
        <div class="mobile-header">

        </div>
        <div class="mobile-con">
            <div class="title-bar">
                <?php echo $_smarty_tpl->tpl_vars['headTitle']->value;?>

            </div>
            <div class="article">
                <h4 class="article-title" id="article-title"><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ahci_title']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_title'];?>
<?php } else { ?>这里是帮助标题<?php }?>！</h4>
                <div class="date"><?php echo $_smarty_tpl->tpl_vars['now']->value;?>
 <span class="link-name"><?php echo $_smarty_tpl->tpl_vars['shop']->value['s_name'];?>
</span></div>
                <div class="article-con" id="article-con">
                    <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ahci_content']) {?>
                    <!-- <?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_content'];?>
 -->
                    <?php } else { ?>
                    <p>这里将会显示帮助内容</p>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>

    <div class="edit-right">
        <div class="edit-con">
            <div><?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>
</div>
            <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ahci_id']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_id'];?>
<?php }?>"/>
            <div class="topic">
                <label for="">标题<font color="red">*</font></label>
                <input type="text" id="title" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ahci_title']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_title'];?>
<?php }?>" placeholder="这里添加标题" oninput="previewTitle(this)" onpropertychange="previewTitle(this)">
            </div>
            <div class="topic">
                <label for="">排序权重</label>
                <input class="form-control" type="number" id="sort" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ahci_sort']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_sort'];?>
<?php }?>" placeholder="越大越靠前">
            </div>
            <div class="contxt">
                <label for="">内容<font color="red">*</font></label>
                <div>
                    <div class="form-textarea">
                        <textarea style="width:100%;height:350px;" id="article-detail" name="article-detail" placeholder="内容"  rows="20" style=" text-align: left; resize:vertical;" ><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ahci_content']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_content'];?>
<?php }?></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-detail" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning setting-save" role="alert">
        <button class="btn btn-primary btn-sm btn-save" style="background-color: #02c700;margin-right: 15px">保存</button>
        <button class="btn btn-primary btn-sm btn-return">返回列表</button>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    /*标题实时预览*/
    function previewTitle(elem){
        var val = $(elem).val();
        $("#article-title").text(val);
    }

    var nowdate = new Date();
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd HH:mm:ss'
        });
    }


    //选择关联商品
    function dealGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //选择关联商品
    function dealAppointmentGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".appointment-goods-none").remove();
        var append_html = "<div class='goods-name appointment-goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeAppointmentGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.appointment-goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //移除关联商品
    function removeGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.goods-selected-list').html(default_html);
        }
    }

    //移除关联商品
    function removeAppointmentGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.appointment-goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
            $('.appointment-goods-selected-list').html(default_html);
        }
    }


    //清空关联商品
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.goods-selected-list').html(default_html);
    });

    //清空关联商品
    $('.btn-appointment-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.appointment-goods-selected-list').html(default_html);
    });


    $('.btn-save').on('click',function(){
        var content = weddingTaocanDetailArray[0];
        var title    = $('#title').val();
//        var video    = $('#video').val();
//        var cover    = $('#cover').val();
//        var brief    = $('#brief').val();
        var sort     = $('#sort').val();
//        var price     = $('#price').val();
//        var articleFrom = $('#articleFrom').val();
//        var category = $('#category-name').val();
//        var recommend= $('#isRecommend').val();
//        var urlType  = $('input[name="type"]:checked').val();
//        var goodsType  = $('input[name="goodsType"]:checked').val();
//        var appointmentGoodsType  = $('input[name="appointmentGoodsType"]:checked').val();
//        var displayType  = $('input[name="displayType"]:checked').val();
        //var id       = '<?php echo $_smarty_tpl->tpl_vars['row']->value['ahci_id'];?>
';
        var id       = $('#hid_id').val();
//        var gids     = [];
//        var agids     = [];
//        var relatedInfo = [];
        //var selectInfo = {};
//        var showNum  = $('#showNum').val();
//        var likeNum  = $('#likeNum').val();
//        var customTime = $('#customTime').val();
        //保存推荐商品
//        $('.goods-selected').each(function () {
//            var gid = $(this).attr('gid');
//           gids.push(gid)
//        });
//        $('.appointment-goods-selected').each(function () {
//            var agid = $(this).attr('gid');
//            agids.push(agid)
//        });
//        console.log(gids);
//        console.log(agids);
//        //保存相关文章
//        $('.related-info').each(function () {
//            var selectCate = $(this).find('.select-cate').val();
//            var selectInfo = $(this).find('.select-info').val();
//            if(selectCate && selectInfo){
//                 selectInfo = {
//                    'cateId' : selectCate,
//                    'infoId' : selectInfo
//                 };
//                 relatedInfo.push(selectInfo);
//            }
//        });
        //if(<?php echo $_smarty_tpl->tpl_vars['curr_sid']->value;?>
 == 5655){
        //    console.log(relatedInfo);
        //    return false;
        //}

        var data = {
            'id'         : id,
            'title'      : title,
//            'cover'      : cover,
//            'brief'      : brief,
//            'category'   : category,
//            'video'      : video,
            'content'    : content,
            'sort'       : sort,
//            'price'      : price,
//            'urlType'    : urlType,
//            'recommend'  : recommend,
//            'gids'       : gids,
//            'agids'      : agids,
//            'relatedInfo': relatedInfo,
//            'likeNum'    : likeNum,
//            'showNum'    : showNum,
//            'customTime' : customTime,
//            'articleFrom': articleFrom,
//            'displayType': displayType,
//            'goodsType'  : goodsType,
//            'appointmentGoodsType': appointmentGoodsType
        };

        if(title && content){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/currency/helpCenterInfoSave',
                'data'	: data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        if(ret.id > 0){
                            $('#hid_id').val(ret.id);
                        }
                        window.location.href='/wxapp/currency/helpCenterInfoList';
                        //window.history.go(-1);
                    }
                }
            });
        }else{
            layer.msg('请填写完整数据');
        }
    });

    /**/
    $("#link-type").on('click', 'input[type=radio]', function(event) {
        var timer;
        clearTimeout(timer);
        $(".link-name").css("color","red");
        timer = setTimeout(function(){
            $(".link-name").css("color","#607fa6");
        },2000)
    });


    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    $(function(){
        $('#fetch-content').click(function(){
            var url = $('#fetch-url').val();
            var type = $('#article-link-type').val();
            if(url){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'	: 'post',
                    'url'	: '/wxapp/currency/fetchWebContent',
                    'data'	: {url:url, type: type},
                    'dataType' : 'json',
                    'success'  : function(ret){
                        console.log(ret);
                        layer.close(index);
                        if(ret.ec == 200){
                            if(type == 1){
                                if(ret.data.title){
                                    $('#title').val(ret.data.title);
                                    $('#article-title').text(ret.data.title);
                                }
                                for (var i=0;i<ret.data.all_list.length;i++)
                                {
                                    if(typeof(ret.data.all_list[i]) == 'string' ){
                                        $('#brief').val(ret.data.all_list[i]);
                                        break;
                                    }
                                }
                                if(ret.data.html){
                                    //KindEditor.instances[0].html(ret.data.html);
                                    UE.getEditor('article-detail').setContent(ret.data.html);
                                }
                                if(ret.data.img_list[0]){
                                    $('#upload-cover').attr('src',ret.data.img_list[0].url);
                                    $('#cover').val(ret.data.img_list[0].url);
                                }
                            }else{
                                if(ret.data.title){
                                    $('#title').val(ret.data.title);
                                    $('#article-title').text(ret.data.title);
                                }
                                $('#brief').val(ret.data.desc);
                                if(ret.data.cover){
                                    $('#upload-cover').attr('src',ret.data.cover);
                                    $('#cover').val(ret.data.cover);
                                }

                                if(ret.data.content){
                                    UE.getEditor('article-detail').setContent(ret.data.content);
                                    //KindEditor.instances[0].html(ret.data.content);
                                }

                                if(ret.data.video){
                                    $('#video').val(ret.data.video);
                                }
                            }

                            layer.msg('获取成功');
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }

        })

    });
    /**
     * 预览视频
     */
    function hrefto(data){
        layer.open({
            type: 2,
            title: false,
            area: ['630px', '360px'],
            shade: 0.8,
            closeBtn: 1,
            shadeClose: true,
            content: data
        });
    };
    /**
     * 预览音频
     */
    function hreftoVoice(data){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            skin: 'yourclass',
            content: data
        });
    };
    function videoShow(obj){
        var type=$('input:radio:checked').val();
        var data=$('#video').val();
        if(type==1){
            if(data){
                var html='<video id="media" src="'+data+'"autoplay="autoplay" controls="controls" style="width:400px"></video>';
                hreftoVoice(html);
                var Media = document.getElementById("media");
                Media.onerror = function() {
                    $('.layui-layer').css('display','none');
                    $('.layui-layer-shade').css('display','none');
                    layer.msg('请填入正确的视频地址');
                };
            }else{
                layer.msg('请填入视频地址');
            }
        }else if(type==2){
            if(data){
                var htmll='<audio id="voice" src="'+data+'"autoplay="autoplay" controls="controls"></audio>';
                hreftoVoice(htmll);
                var voice = document.getElementById("voice");
                voice.onerror = function() {
                    $('.layui-layer').css('display','none');
                    $('.layui-layer-shade').css('display','none');
                    layer.msg('请填入正确的音频地址');
                };
            }else{
                layer.msg('请填入音频地址');
            }
        }
    }

    //管理商品
    $('.btn-goods').on('click',function(){
        //初始化
        var num = $('.goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个商品');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();

        $('.th-weight').hide();

        $('#goods-modal').modal('show');
        $('#search-type').val('information');

        //重新获取数据
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage, 'information');
    });

    //管理商品
    $('.btn-appointment-goods').on('click',function(){
        //初始化
        var num = $('.appointment-goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个商品');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();

        $('.appointment-th-weight').hide();

        $('#goods-modal').modal('show');
        $('.typeselect').hide();
        $('#search-type').val('informationAppointment');

        //重新获取数据
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage,'informationAppointment');
    });

    function changeGoodsType(goodsType) {
        $('#goodsType').val(goodsType) ;
        fetchGoodsPageData(1)
    }

    function fetchGoodsPageData(page, type){
        if(!type){
            type = $('#search-type').val();
        }
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  type, //帮助添加商品
            'id'    :  $('#currId').val()  ,
            'goodsType' : $('#goodsType').val() ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/giftGoods',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list, type);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data, type){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].g_id+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p></td>';
            if(type=='information'){
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealGoods( this )"> 选取 </td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealAppointmentGoods( this )"> 选取 </td>';
            }
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }



    var infoArr = [];

    function getInformation(ele,index) {
        var cate = $(ele).val();
        var infoSelect = infoArr[cate];
        infoSelectOption(index,infoSelect);

    }
    function infoSelectOption(index,infoSelect) {
        var str = '';
            str += "<option value='0'>请选择文章</option>";
            if(infoSelect){
                for(var i = 0 ; i < infoSelect.length; i++){
                    str += "<option value='"+ infoSelect[i].id +"'>"+ infoSelect[i].title +"</option>"
                }
            }
        console.log(str);
        $(".related-info_"+index).find('.select-info').html(str);

    }

    function removeInfo(index) {
         $(".related-info_"+index).remove();
    }

    function addInfo() {
        var count = $('.related-info').length;
        if(count >= 5){
            layer.msg('最多添加5条相关文章');
            return false;
        }else{
            var _html = '';
             _html += '<div class="related-info related-info_'+ count +'"><div class="related-info-cate"><label id="default-onoff"><select style="height: 35px;" class="form-control select-cate" onchange="getInformation(this,'+ count +')"><option value="0">请选择分类</option><?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category_select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option><?php } ?></select></label></div><div class="related-info-detail"><select  style="height: 35px;" class="form-control select-info"><option value="0">请选择文章</option></select></div><button class="btn btn-sm btn-default goods-button btn-remove-info" onclick="removeInfo('+ count +')">移除</button></div>';
            $('.related-info-box').append(_html);
        }
    }

    $('.btn-return').on('click',function(){
        window.location.href='/wxapp/currency/helpCenterInfoList';
    });





</script>
<?php }} ?>

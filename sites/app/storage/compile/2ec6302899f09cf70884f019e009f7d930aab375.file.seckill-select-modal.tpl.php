<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:47:02
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/seckill-select-modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9528492055e4df3262df432-79727661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ec6302899f09cf70884f019e009f7d930aab375' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/seckill-select-modal.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9528492055e4df3262df432-79727661',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df3262e4442_72229170',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df3262e4442_72229170')) {function content_5e4df3262e4442_72229170($_smarty_tpl) {?><!--<link rel="stylesheet" href="/public/site/css/help/swiper-4.2.2.min.css">-->
<style>
    #myimg{
        font-family: "黑体";
    }
    .modal-body{
        padding:0!important;
    }
    .seckill-img{

    }
    .seckill-name{
        background-color: #F2F2F2;
        width: 160px;
        float: left;
        padding: 15px 0;
        height: 530px;
    }
    /*.seckill-name.commonH{
    	height: 588px;
    }*/
    .seckill-name>div{
        /*background-color: #fff;*/
        line-height: 3;
        padding:0 15px;
        /* margin-bottom: 5px;*/
        cursor: pointer;
        /*   color:#fff;*/
    }
    .seckill-name>div.active{
        background-color: #fff;
    }
    .seckill-name span{
        float: right;
        color: #999;
    }
    .showseckill-con{
        margin-left: 15px;
    }
    .showseckill-con ul{
        margin:0;
        padding:0;
        padding-right: 16px;
        overflow: hidden;
        padding-top: 15px;
        /*height: 486px;*/
        height: 530px;
    }
    .showseckill-con ul li{
        margin-left: 16px;
        width: 120px;
        text-align: center;
        float: left;
    }
    .showseckill-con ul li p{
        margin: 0;
        line-height: 1.5;
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        height: 45px;
    }
    .showseckill-con li div{
        height: 120px;
        background-color: #f2f2f2;
        vertical-align: middle;
        position: relative;
        overflow: hidden;
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .showseckill-con li>div.selected::after{
        position: absolute;
        left: 0;
        top:0;
        content: '';
        height: 100%;
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:2px solid #0077DD;
        z-index: 1;
    }
    .showseckill-con li>div.selected::before{
        content:'';
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 2;
        height: 30px;
        width: 30px;
        background: url(/public/manage/img/sanjiao.png) no-repeat;
        background-size: 30px;
        background-position: bottom right;
    }
    .showseckill-con li div img{
        width: 100%;
        display: block;
        margin:auto;
        height: 100%;
    }
    .showseckill-con li div span{
        position: absolute;
        height: 30px;
        line-height: 30px;
        color: #fff;
        width: 100%;
        left: 0;
        bottom: 0;
        z-index: 1;
        background-color: rgba(0,0,0,0.4);
    }

    .img-pages{
        text-align: right;
        padding:10px 0;
        margin:0 15px 5px;
        border-radius: 5px;
        background-color: #f5f5f5;
        position: relative;
    }
    .img-pages #upload-btn{
        position: absolute;
        left: 5px;
    }
    .img-pages a{
        padding: 5px 8px;
        margin: 0 1px;
        min-width: 28px;
        border: 1px solid #ddd;
        background-color: #fff;
        text-align: center;
        border-radius: 2px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        color: #333;
    }
    .img-pages a:hover{
        background-color: #f8f8f8;
        color: #0077DD;
    }
    .img-pages a.active{
        background-color: #0077DD;
        color: #fff;
        border-color: #0077DD;
    }
    .img-pages p{
        display: inline-block;
        vertical-align: top;
        margin-left: 5px;
        margin-bottom: 0;
    }
    .add-img{
        display: none;
        padding:40px 30px;
    }
    .add-tip{
        overflow: hidden;
    }
    .add-tip p{
        margin:10px 0;
        color: #999;
    }
    .add-tip img.selected::after{
        position: absolute;
        left: 0;
        top:0;
        content: '';
        height: 100%;
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:2px solid #0077DD;
        z-index: 1;
    }
    .add-tip img.selected::before{
        content:'';
        position: absolute;
        bottom: 0;
        right: 0;
        z-index: 2;
        height: 30px;
        width: 30px;
        background: url(/public/manage/img/sanjiao.png) no-repeat;
        background-size: 30px;
        background-position: bottom right;
    }
    .modal-header h4 {
        margin: 0;
        font-size: 16px;
        font-family: "黑体";
    }
    .modal-header h4 span{
        color: #38f;
        cursor: pointer;
    }
    /* .layui-layer-shade{
        display: none;
    } */
    #slide-img {
        margin: 0;
        margin-bottom: 5px;
    }
    #slide-img p {
        margin: 0;
        position: relative;
        padding: 0;
        display: inline-block;
        height: 90px;
        width: 90px;
        margin-right: 15px;
        cursor: pointer;
    }
    #slide-img p .delimg-btn {
        position: absolute;
        top: -9px;
        right: -9px;
        height: 20px;
        line-height: 17px;
        text-align: center;
        width: 20px;
        border: 1px solid #ddd;
        background-color: rgba(0, 0, 0, 0.3);
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
        font-size: 16px;
        color: #fff;
        cursor: pointer;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        -ms-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
    }
    #slide-img p:hover .delimg-btn, #slide-img p .delimg-btn:hover {
        background-color: #444;
    }
    .img-thumbnail {
        display: inline-block;
        margin-right: 15px;
        margin-left: 0;
        height: 90px;
        width: 90px;
    }
    /* 查看大图 */
    .view-shade {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: #444;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 9999;
    }
    .bigImg-show {
        position: absolute;
        height: 90%;
        width: 90%;
        left: 5%;
        top: 5%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }
    .bigImg-show img {
        max-width: 100%;
        max-height: 100%;
        margin: auto;
        display: block;
        border: 5px solid #f9f9f9;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
    }
    .img-pages #delete-btn{
        position: absolute;
        left: 80px;
        top: 4px;
        background-color: red!important;
        border-color: red!important;
    }
    #showseckill-con .img-con{
        display:none;
    }
    #showseckill-con .img-con.active{
        display:block;
    }
    .select-tab{
        width:100%;
        height:57px;
        line-height:57px;
        color:#333;
        background-color:#f2f2f2;
        font-size:0;
        box-sizing:border-box;
        border-left:1px solid #e5e5e5;
    }
    .select-tab .swiper-container{
        width:100%;
        height:100%;
    }
    .select-tab .swiper-slide .tab-item{
        width:100%;
        text-align: center;
        display:inline-block;
        font-size:16px;
    }
    .select-tab .swiper-slide.active .tab-item{
        background-color:#fff;
    }

    .select-seckill-modal-btn .select-btn{
        border: 1px solid #dfdfdf;
        padding: 5px;
        border-radius: 4px;
        background: #dfdfdf;
        text-align: center;
        color: #888;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 100%;
    }
</style>
<!--图片弹窗-->
<div class="modal fade" id="mySeckill" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:880px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    秒杀
                </h4>
            </div>
            <div class="modal-body">
                <div class="search-seckill" style="height: 35px;margin-top: 15px;margin-left: 20px;padding-right: 33px;">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group" style="width: 100%;margin-bottom: 0px">
                                <div class="input-group" style="width: 100%;">
                                    <input type="text" style="border-radius: 4px;" id="seckill-name" class="form-control" name="name" value="" placeholder="商品名称">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="margin-top: 2px">
                        <button class="btn btn-green btn-sm" onclick="fetchSeckillData(1)">查询</button>
                    </div>
                </div>
                <div class="group-img">
                    <div class="showseckill-con" id="showseckill-con">
                        <div class="img-con active">
                            <ul id="attach-ajax-seckill">
                                <!--图片显示位置-->
                            </ul>
                            <div class="img-pages">
                                <div id="ajax-seckill-page-html" style="display:inline-block">
                                    <!--分页显示位置-->
                                </div>
                                <p id="seckill-page-total"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align:right">
                <button type="button" class="btn btn-blue"
                        data-dismiss="modal" id="confirm-seckill-btn" style="width:100px;">确定
                </button>
            </div>
        </div>
    </div>
</div>

<div class="view-shade" id="view-shade" style="display:none">
    <div class="bigImg-show">
        <img src="" alt="图片">
    </div>
</div>
<!--  <script src="/public/plugin/layer/layer.js"></script>-->
<!-- <script src="/public/site/js/swiper-4.4.2.min.js"></script>-->
<script>
    $('#seckill-name .neme-item').click(function(){
        var index = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('#showseckill-con .img-con').eq(index).addClass('active').siblings().removeClass('active');
        if(index==1){
            $(this).parent().addClass('commonH');
            $('#delete-btn').stop().hide();
        }else{
            $(this).parent().removeClass('commonH');
            $('#delete-btn').stop().show();
        }
    })

    /**
     * 调用方法说明：
     * 调用toUpload()方法，并传递限制图片的数量 如果不传则默认选择一个
     * 打开modal弹窗，选择图片
     * 点击保存时，返回图片地址
     * 自定义deal_select_img()方法，来处理返回的图片地址
     * */
    var seckillMaxNum = 10,page= 1, doIndex=''; //图片选择配置  大于1多选，数量为最多选择图片个数 小于1单选
    function toSelectSeckill(elem){
        $('#seckill-name').val('');
        fetchSeckillData(1);
        doIndex = $(elem).data('index');
        $('#mySeckill').modal('show');
    }

    /*选中图片添加选中样式*/
    $(".showseckill-con").on('click', 'li>div', function(event) {
        var num=0;
        if(seckillMaxNum>1){
            var liItems = $(this).parents('ul').find('li');
            liItems.each(function(index, el) {
                if($(this).find('div').hasClass('selected')){
                    num++;
                }else{

                }
            });
            if(num<seckillMaxNum){
                $(this).toggleClass('selected');
            }else{
                if($(this).hasClass('selected')){
                    $(this).toggleClass('selected');
                }else{
                    layer.msg("最多添加"+seckillMaxNum+"张图片哦！")
                }
            }

        }else if(seckillMaxNum<=1){
            $(this).parents(".showseckill-con").find('li div').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    /*点击确定按钮打印获取图片路径*/
    $("#confirm-seckill-btn").on('click', function(event) {
        var liItems = $(this).parents('.modal-content').find('.showseckill-con li');
        liItems.each(function(index, el) {
            if($(this).find('div').hasClass('selected')){
                var appElement = document.querySelector('[ng-controller=custempCtrl]');
                //获取$scope变量
                var $scope = angular.element(appElement).scope();

                $scope.$apply(function(){
                    $scope.showComponentData[doIndex].goodsData.push({
                        'id'    : $(el).data('id'),
                        'title'  : $(el).data('name'),
                        'price' : $(el).data('price'),
                        'oriPrice' : $(el).data('oriPrice'),
                        'cover' : $(el).data('cover'),
                        'brief' : $(el).data('brief'),
                    });
                });
            }else{

            }
        });
    });


    function fetchSeckillData(page){
        var data = {
            'page'   : page,
            'name'   : $('#seckill-name').val()
        };
        $.ajax({
            'type'   : 'post',
            'url'    : '/wxapp/index/fetchSelectSeckill',
            'data'   : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret);
                if(ret.ec == 200){
                    $('#ajax-seckill-page-html').html(ret.pageHtml);
                    $('#seckill-page-total').html('共'+ret.total+'条，每页'+ret.count+'条');
                    showSeckill(ret.data);
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function fetchSeckillPageData(page){
        var data = {
            'page'   : page,
            'name'   : $('#seckill-name').val()
        };
        $.ajax({
            'type'   : 'post',
            'url'    : '/wxapp/index/fetchSelectSeckill',
            'data'   : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret);
                if(ret.ec == 200){
                    $('#ajax-seckill-page-html').html(ret.pageHtml);
                    $('#seckill-page-total').html('共'+ret.total+'条，每页'+ret.count+'条');
                    showSeckill(ret.data);
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function showSeckill(data){
        if(data.length > 0){
            var img_html = '';
            for(var i=0;i<data.length;i++){
                img_html += '<li data-id='+data[i].id+' data-cover='+data[i].cover+' data-name='+data[i].name+' data-brief="'+data[i].brief+'" data-oriPrice='+data[i].oriPrice+' data-price='+data[i].price+'><div>';
                img_html += '<img src="'+data[i].cover+'" alt="图片">';
                img_html += '</div><p data-id='+data[i].id+'>'+data[i].name+'</p>';
                img_html += '</li>'
            }
            $('#attach-ajax-seckill').html(img_html);
        }else{
            $('#attach-ajax-seckill').html(img_html);
        }
    }

</script><?php }} ?>

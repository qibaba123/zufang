<!--<link rel="stylesheet" href="/public/site/css/help/swiper-4.2.2.min.css">-->
<style>
    #myimg{
        font-family: "黑体";
    }
    .modal-body{
        padding:0!important;
    }
    .group-img{

    }
    .group-name{
        background-color: #F2F2F2;
        width: 160px;
        float: left;
        padding: 15px 0;
        height: 530px;
    }
    /*.group-name.commonH{
    	height: 588px;
    }*/
    .group-name>div{
        /*background-color: #fff;*/
        line-height: 3;
        padding:0 15px;
       /* margin-bottom: 5px;*/
        cursor: pointer;
     /*   color:#fff;*/
    }
    .group-name>div.active{
    	background-color: #fff;
    }
    .group-name span{
        float: right;
        color: #999;
    }
    .showimg-con{
        margin-left: 160px;
    }
    .showimg-con ul{
        margin:0;
        padding:0;
        padding-right: 16px;
        overflow: hidden;
        padding-top: 15px;
        /*height: 486px;*/
       height: 490px;
    }
    .showimg-con ul li{
        margin-left: 16px;
        width: 120px;
        text-align: center;
        float: left;
    }
    .showimg-con ul li p{
        margin:0;
        line-height: 2.5;
        margin-bottom: 5px;
    }
    .showimg-con li div{
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
    .showimg-con li>div.selected::after{
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
    .showimg-con li>div.selected::before{
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
    .showimg-con li div img{
        width: 100%;
        display: block;
        margin:auto;
        height: 100%;
    }
    .showimg-con li div span{
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
        top: 4px;
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
    #showimg-con .img-con{
    	display:none;
    }
    #showimg-con .img-con.active{
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
</style>
<!--图片弹窗-->
<div class="modal fade" id="myimg" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:880px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myimgTitle">
                    我的图片
                </h4>
            </div>
            <div class="modal-body">
                <div class="group-img">
                    <div class="group-name" id="group-name">
                        <div class="neme-item active">全部图片<span id="uploadTotalImg"></span></div>
                        <div class="neme-item">公共图片<span id="uploadCommonTotalImg"></span></div>
                    </div>
                    <div class="showimg-con" id="showimg-con">
                    	<div class="img-con active">
                    		<ul id="attach-ajax-img">
	                            <!--图片显示位置-->
	                        </ul>
	                        <div class="img-pages">
	                            <div class="btn btn-green btn-xs" id="upload-btn">上传图片</div>
	                            <div id="ajax-page-html" style="display:inline-block">
	                                <!--分页显示位置-->
	                            </div>
	                            <p id="page-total"></p>
	                        </div>
                    	</div>
                    	<div class="img-con">
                    		<!--<div class="select-tab" id="select-tab">
                    			<div class="swiper-container commonImg-tab">
								    <div class="swiper-wrapper">
								      <div class="swiper-slide active">
								      	<div class="tab-item">
		                    				会议
		                    			</div>
								      </div>
								      <div class="swiper-slide">
								      	<div class="tab-item">
		                    				商城
		                    			</div>
								      </div>
								      <div class="swiper-slide">
								      	<div class="tab-item">
		                    				酒店
		                    			</div>
								      </div>
								      <div class="swiper-slide">
								      	<div class="tab-item">
		                    				会议
		                    			</div>
								      </div>

								    </div>
								</div>
                    		</div>-->
                    		<div class="tab-con">
                    			<ul id="attach-common-ajax-img">

		                        </ul>
                    		</div>
                    		<div class="img-pages">
<!--	                            <div class="btn btn-green btn-xs">上传图片</div>-->
	                            <div style="display:inline-block" id="ajax-common-page-html" >
	                                <!--分页显示位置-->
	                            </div>
                                <p id="page-common-total"></p>
	                        </div>
                    	</div>
                    </div>
                </div>
                <div class="add-img">
                    <div class="add-tip">
                        <label class="col-xs-3 text-right">本地图片：</label>
                        <div class="col-xs-9" id="upload-width-height">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align:right">
                <button type="button" class="btn btn-red" id="delete-btn" style="width:100px;background-color: red!important;" >删除
                </button>
                <button type="button" class="btn btn-blue"
                        data-dismiss="modal" id="confirm-btn" style="width:100px;">确定
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
    	$('#group-name .neme-item').click(function(){
    		var index = $(this).index();
    		$(this).addClass('active').siblings().removeClass('active');
    		$('#showimg-con .img-con').eq(index).addClass('active').siblings().removeClass('active');
    		if(index==1){
    			$(this).parent().addClass('commonH');
    			$('#delete-btn').stop().hide();
//  			var swiper = new Swiper('.commonImg-tab', {
//		    	  resistanceRatio:0,
//			      slidesPerView:7,
//			      spaceBetween:0,
//			      freeMode: true
//			    });
    		}else{
    			$(this).parent().removeClass('commonH');
    			$('#delete-btn').stop().show();
    		}
    		
    	})
    	
//  	$('#select-tab .swiper-slide').click(function(){
//  		$(this).addClass('active').siblings().removeClass('active')
//  	})
    	
    	
        /**
         * 调用方法说明：
         * 调用toUpload()方法，并传递限制图片的数量 如果不传则默认选择一个
         * 打开modal弹窗，选择图片
         * 点击保存时，返回图片地址
         * 自定义deal_select_img()方法，来处理返回的图片地址
         * */
        var nowIndex = 0, maxNum = 1,nowId='upload-cover',page= 1, width=200,height=200; //图片选择配置  大于1多选，数量为最多选择图片个数 小于1单选
        function toUpload(elem){
            var limit   = parseInt($(elem).data('limit'));
                width   = parseInt($(elem).data('width'));
                height  = parseInt($(elem).data('height'));
            var domId   = $(elem).data('dom-id');
            if(limit > 0)  maxNum = limit;
            initUploadBox();
            if(domId) nowId = domId;
            fetchUploadImgData(1);
            $('#myimg').modal('show');
            var index = $(elem).data('index');
            if(index) nowIndex=index;
            console.log(width);
            console.log(height);
        }

        function initUploadBox(){
            var html = '<div class="cropper-box" data-width="'+width+'" data-height="'+height+'">';
            html += '<img src="/public/manage/img/zhanwei/default.png" height="100px" alt="图片">';
            html += '<p>仅支持jpg、gif、png三种格式, <span id="up_wh_tip">建议尺寸：'+width+' x '+height+' 像素</span></p>';
            html += '<p>请将图片大小控制在2M以内，否则将无法上传</p>';
            html += '<input type="hidden"  class="avatar-field bg-img" value=""/>';
            html += '</div>';
            $('#upload-width-height').html(html);
            $(".cropper-box").unbind();

            new $.CropAvatar($("#crop-avatar"));
        }

        /*弹出层出现时清空已选择图片*/
        $('#myimg').on('show.bs.modal', function () {
            $(".showimg-con li div").removeClass('selected');
        });

        /*选中图片添加选中样式*/
        $(".showimg-con").on('click', 'li>div', function(event) {
            var num=0;
            if(maxNum>1){
                var liItems = $(this).parents('ul').find('li');
                liItems.each(function(index, el) {
                    if($(this).find('div').hasClass('selected')){
                        num++;
                    }else{

                    }
                });
                if(num<maxNum){
                    $(this).toggleClass('selected');
                }else{
                    if($(this).hasClass('selected')){
                        $(this).toggleClass('selected');
                    }else{
                        layer.msg("最多添加"+maxNum+"张图片哦！")
                    }
                }

            }else if(maxNum<=1){
                $(this).parents(".showimg-con").find('li div').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        /*点击确定按钮打印获取图片路径*/
        $("#confirm-btn").on('click', function(event) {
            var groupImg = $(this).parents('.modal-content').find('.group-img').css("display");
            var addImg = $(this).parents('.modal-content').find('.add-img');
            var allSrc = new Array();
            if(groupImg==='block'){
                var liItems = $(this).parents('.modal-content').find('.showimg-con li');
                liItems.each(function(index, el) {
                    if($(this).find('div').hasClass('selected')){
                        var imgSrc = $(this).find('div img').attr("src");
                        allSrc.push(imgSrc);
                    }else{

                    }
                });
            }else if(groupImg==='none'){
                allSrc.push(addImg.find('img').attr("src"));
            }
            $(".group-img").stop().show();
            $(".add-img").stop().hide();
            /*打印图片路径*/
            console.log(allSrc);
            deal_select_img(allSrc);
            /*layer.photos({
                photos: '#slide-img',
                zIndex: '199890410'
            });*/
        });

        /*上传图片按钮点击跳转上传图片区域*/
        $("#upload-btn").click(function(event) {
            $(".group-img").stop().hide();
            $(".group-img").find('.showimg-con li div').removeClass('selected');
            $(".add-img").stop().show();
            $("#myimgTitle").html("<span id='chooseimg'>选择图片></span>上传图片");


        });

        /*标题选择图片点击返回选择图片区域*/
        $(".modal-content").on('click','#chooseimg', function(event) {
            $(".group-img").stop().show();
            $(".add-img").stop().hide();
            $("#myimgTitle").html("我的图片");
        });

        function fetchUploadImgData(page){
            var data = {
                'page'   : page,
                'height' : height,
                'width'  : width
            };
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/fetchAttachment',
                'data'   : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        $('#ajax-page-html').html(ret.pageHtml);
                        $('#page-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                        $('#uploadTotalImg').text(ret.total+'张');
                        showImg(ret.data);
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
            var data = {
                'page'   : page,
                'height' : height,
                'width'  : width,
                'type'   : 'common'
            };
            $.ajax({
                'type'   : 'post',
                'url'    : '/wxapp/index/fetchAttachment/type/common',
                'data'   : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        $('#ajax-common-page-html').html(ret.pageHtml);
                        $('#page-common-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                        $('#uploadCommonTotalImg').text(ret.total+'张');
                        showImg(ret.data, 'common');
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }

        function fetchPageImgData(page, type){
            if(type == 'common'){
                var data = {
                    'page'   : page,
                    'height' : height,
                    'width'  : width,
                    'type'   : 'common'
                };
                $.ajax({
                    'type'   : 'post',
                    'url'    : '/wxapp/index/fetchAttachment/type/common',
                    'data'   : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        console.log(ret.pageHtml);
                        console.log(ret);
                        if(ret.ec == 200){
                            $('#ajax-common-page-html').html(ret.pageHtml);
                            $('#page-common-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                            $('#uploadCommonTotalImg').text(ret.total+'张');
                            showImg(ret.data, 'common');
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }else{
                var data = {
                    'page'   : page,
                    'height' : height,
                    'width'  : width,
                };
                $.ajax({
                    'type'   : 'post',
                    'url'    : '/wxapp/index/fetchAttachment',
                    'data'   : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        console.log(ret);
                        if(ret.ec == 200){
                            $('#ajax-page-html').html(ret.pageHtml);
                            $('#page-total').html('共'+ret.total+'张，每页'+ret.count+'张');
                            $('#uploadTotalImg').text(ret.total+'张');
                            showImg(ret.data);
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }
        }

        function showImg(data, type){
            if(data.length > 0){
                var img_html = '';
                for(var i=0;i<data.length;i++){
                    img_html += '<li><div>';
                    img_html += '<img src="'+data[i].path+'" alt="图片">';
                    img_html += '<span class="resolution-ratio">'+data[i].width+'*'+data[i].height+'</span>';
                    img_html += '</div><p>'+data[i].name+'</p>';
                    img_html += '</li>'
                }
                if(type=='common'){
                    $('#attach-common-ajax-img').html(img_html);
                }else{
                    $('#attach-ajax-img').html(img_html);
                }
            }else{
                if(type=='common'){
                    $('#attach-common-ajax-img').html('');
                }else{
                    $('#attach-ajax-img').html(img_html);
                }
            }
        }


        /*幻灯添加放大事件*/
        $("#slide-img").on('click', 'img', function(event) {
            var that = $(this);
            var curSrc = that.attr("src");

            $("#view-shade .bigImg-show img").attr("src",curSrc);
            $("#view-shade").stop().fadeIn();
        });

        $("#view-shade").on('click', function(event) {
            $(this).stop().fadeOut();
        });

        /*点击确定按钮打印获取图片路径*/
        $("#delete-btn").on('click', function(event) {
            var groupImg = $(this).parents('.modal-content').find('.group-img').css("display");
            var addImg = $(this).parents('.modal-content').find('.add-img');
            var allSrc = new Array();
            if(groupImg==='block'){
                var liItems = $(this).parents('.modal-content').find('.showimg-con li');
                liItems.each(function(index, el) {
                    if($(this).find('div').hasClass('selected')){
                        var imgSrc = $(this).find('div img').attr("src");
                        allSrc.push(imgSrc);
                    }
                });
            }else if(groupImg==='none'){
                allSrc.push(addImg.find('img').attr("src"));
            }
            if(allSrc.length>0){
                layer.confirm('确定要删除吗？一旦删除将无法找回', {
                    title:false,
                    closeBtn:0,
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        'type'   : 'post',
                        'url'    : '/wxapp/index/deleteAttachment',
                        'data'   : { imgSrc:allSrc},
                        'dataType'  : 'json',
                        'success'   : function(ret){
                            layer.msg(ret.em);
                            if(ret.ec == 200) {
                                if(groupImg==='block'){
                                    var liItems = $('#delete-btn').parents('.modal-content').find('.showimg-con li');
                                    liItems.each(function(index, el) {
                                        if($(this).find('div').hasClass('selected')){
                                            $(this).remove();
                                        }
                                    });
                                }else if(groupImg==='none'){
                                    addImg.remove();
                                }
                            }
                        }
                    });
                });
            }else{
                layer.msg('请选择要删除的图片');
            }

        });

        /**
         * 图片删除功能
         * 以图片容器为准，容器中的图片img标签结果<div><p><img>
         */
        $(".pic-box").on('click', '.delimg-btn', function(event) {
            var id = $(this).parent().parent().attr('id');
            event.preventDefault();
            event.stopPropagation();
            var delElem = $(this).parent();
            layer.confirm('确定要删除吗？', {
                title:false,
                closeBtn:0,
                btn: ['确定','取消'] //按钮
            }, function(){
                delElem.remove();
                var num = parseInt($('#'+id+'-num').val());
                console.log(num);
                console.log(id);
                if(num > 0){
                    $('#'+id+'-num').val(parseInt(num) - 1);
                }
                layer.msg('删除成功');
            });
        });
        /**
         * 模板angular图片上传使用
         *
         */
        function deal_select_img(allSrc){
            if(allSrc){
                var imgId = nowId.split('-');
                $('#'+nowId).attr('src',allSrc[0]);
                $('#'+nowId).val(allSrc[0]);
                $('#'+imgId[1]).val(allSrc[0]);
            }
        }
    </script>
    <{$cropper['modal']}>
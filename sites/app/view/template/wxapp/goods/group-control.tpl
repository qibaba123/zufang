<link rel="stylesheet" href="/public/manage/groupControl/css/index.css">
<link rel="stylesheet" href="/public/manage/groupControl/css/style.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
    .modal-body{
        padding: 15px!important;
        padding-bottom: 0!important;
    }
    .modal-body .ajax-pages{
        padding:15px 0;
    }
    .modal-body table{
        border: 1px solid #eee;
    }
    .modal-body table th{
        text-align: center;
        padding:8px 0;
        background-color: #f8f8f8;
        border-bottom: 1px solid #eee;
    }
    .modal-body table td{
        padding:8px 0;
        text-align: center;
        border-bottom: 1px dashed #eee;
        cursor: pointer;
    }
    tr.selected td{
        color: #53bd42;
        font-weight: bold;
    }
    .edit-right .edit-con{
        margin-top: 60px;
    }
    .edit-con > div > label{
        width: 170px;
    }
    .ui-btn {
        display: inline-block;
        border-radius: 2px;
        height: 26px;
        line-height: 26px;
        padding: 0 12px;
        cursor: pointer;
        color: #333;
        background: #f8f8f8;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 12px;
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
    }
    .edit-right .right-code{
        text-align: right;
    }
    .edit-right .right-code .ui-btn{
        margin-top: 50px;
        height: 30px;
        line-height: 30px;
        z-index: 1;
        background-color: #fff;
        position: relative;
    }
    .edit-right .right-code .ui-btn:hover{
        background-color: #fafafa;
    }
    .edit-right .right-code p{
        margin:0;
        line-height: 1.5;
    }
    .edit-right .right-code .code{
        position: absolute;
        top: 100%;
        right: 0;
        border:1px solid #eee;
        border-radius: 3px;
        background-color: #fff;
        text-align: center;
        font-size: 12px;
        padding: 15px;
        z-index: 1;
        color: #666;
        display: none;
        margin-top: 5px;
        padding-bottom: 10px;
    }
    .edit-right .right-code .code img{
        width: 120px;
        height: 120px;
        float: none;
    }
    .edit-right .right-code .code .copy_input{
        font-size: 12px;
        margin:0;
        line-height:1.5;
        cursor: pointer;
        color: #666;
    }
    .edit-right .right-code .code .copy_input:hover{
        color: #333;
    }
</style>
<div class="preview-page" ng-app="proApp" ng-controller="proCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                商品列表
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="product-fenlei-list" ng-repeat="goodFenlei in goodFenleis" data-left-preview data-id="{{goodFenlei.index}}" ng-click="previewCliShow($event)">
                        <input type="hidden" ng-value="goodFenlei.showstyle" ng-model="goodFenlei.showstyle">
                        <div class="fenlei-title">
                            <img ng-src="{{goodFenlei.imgsrc}}" alt="分类标题">
                        </div>
                        <div class="goods-show">
                            <div class="goods-view1">
                                <ul>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/groupControl/images/goodsView1.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥9999</p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/groupControl/images/goodsView2.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥9999</p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/groupControl/images/goodsView3.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥9999</p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="delete-fenlei" ng-click="deletegoodFenlei(goodFenlei.index)">删除</div>
                    </div>
                    <div class="add-fenlei" ng-click="addgoodFenlei()">分类商品</div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right" style="margin-bottom:50px; ">
        <div class="right-code">
            <div class="ui-btn">访问商品分类
                <div class="code">
                    <p>手机扫码访问</p>
                    <div id="erweima">
                        <img src="/wxapp/shop/qrcode?url=<{$link}>" alt="二维码">
                    </div>
                    <span id="copy-btn" data-clipboard-target="link-address" class="copy_input">复制页面链接</span>
                    <input type="hidden" value="<{$link}>" id="link-address">
                </div>
            </div>
        </div>
        <div class="edit-con">
            <div class="goodsShow-manage" ng-repeat="goodFenlei in goodFenleis" data-right-edit data-id="{{goodFenlei.index}}">
                <label>商品来源</label>
                <div class="product-source" data-toggle="modal" data-target="#goods-modal" ng-click="selectGroup(goodFenlei.index)">{{goodFenlei.kindName}}</div>
                <label>分类名称</label>
                <input type="text" ng-model="goodFenlei.name" ng-value="goodFenlei.name">
                <label>显示个数</label>
                <div class="radio-box showNum-radio">
                    <input type="hidden" ng-value="goodFenlei.showNum" ng-model="goodFenlei.showNum">
                    <span ng-click="changeShowNum($event)">
                      <input type="radio" name="{{$index}}-goods-num" data-numid="1" id="{{$index}}-showNum1" >
                      <label for="{{$index}}-showNum1">6</label>
                    </span>
                        <span ng-click="changeShowNum($event)">
                      <input type="radio" name="{{$index}}-goods-num" data-numid="2" id="{{$index}}-showNum2" >
                      <label for="{{$index}}-showNum2">12</label>
                    </span>
                    <span ng-click="changeShowNum($event)">
                      <input type="radio" name="{{$index}}-goods-num" data-numid="3" id="{{$index}}-showNum3" >
                      <label for="{{$index}}-showNum3">18</label>
                    </span>
                </div>
                <label>分类图片(512*160像素)</label>
                <div class="fenleiimg-manage cropper-box" data-width="512" data-height="160">
                    <img ng-src="{{goodFenlei.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis(goodFenlei.index)"  alt="分类图片">
                    <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="goodFenlei.imgsrc"/>
                </div>
                <label>列表样式</label>
                <div class="radio-box showstyle-radio">
                    <input type="hidden" ng-value="goodFenlei.showstyle" ng-model="goodFenlei.showstyle">
                    <span ng-click="changeStyle($event)">
                            <input type="radio" name="{{$index}}-goods-show" data-styleid="1" id="{{$index}}-showstyle1" >
                            <label for="{{$index}}-showstyle1" data-type="showstyle">大图</label>
                        </span>
                    <span ng-click="changeStyle($event)">
                            <input type="radio" name="{{$index}}-goods-show" data-styleid="2" id="{{$index}}-showstyle2" >
                            <label for="{{$index}}-showstyle2" data-type="showstyle">小图</label>
                        </span>
                    <span ng-click="changeStyle($event)">
                            <input type="radio" name="{{$index}}-goods-show" data-styleid="3" id="{{$index}}-showstyle3" >
                            <label for="{{$index}}-showstyle3" data-type="showstyle">一大两小</label>
                        </span>
                    <span ng-click="changeStyle($event)">
                            <input type="radio" name="{{$index}}-goods-show" data-styleid="4" id="{{$index}}-showstyle4" >
                            <label for="{{$index}}-showstyle4" data-type="showstyle">详细列表</label>
                        </span>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm" ng-click="saveChange()">  保 存 </button></div>

    <!--- 选择分组弹层 开始-->
    <div id="goods-modal"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">关联商品</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <table  class="table-responsive" style="width: 100%;">
                        <thead>
                        <tr>
                            <th class="col-xs-6">分组名称</th>
                            <th class="col-xs-6">包含商品数量</th>
                        </thead>

                        <tbody id="goods-tr">
                        <!--商品列表展示-->
                        </tbody>
                    </table>
                    <div id="footer-page" class="ajax-pages text-center"><!--存放分页数据--></div>
                </div>
                <div class="modal-footer"  >
                     <a href="/wxapp/goods/group" class="btn btn-sm btn-info"> 添加分组 </a>
                     <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" ng-click="selectMath()"> 选取 </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- 选择分组弹层 结束-->
</div>



<script src="/public/manage/groupControl/js/jquery-1.11.3.min.js"></script>
<script src="/public/manage/groupControl/layer/layer.js"></script>
<script src="/public/manage/groupControl/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/vendor/angular-root.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        //console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
        $('.edit-right .right-code .ui-btn .code').stop().fadeOut();
    } );
    //查看商品分类二维码显示隐藏
    $(".edit-right .right-code .ui-btn").click(function(event) {
        event.stopPropagation();
        var isDisplay = $(this).find('.code').css("display");
        if(isDisplay=="none"){
            $(this).find('.code').stop().fadeIn();
        }else{
            $(this).find('.code').stop().fadeOut();
        }
    });
    $('body').not('.edit-right .right-code .ui-btn .code').click(function(event) {
        $('.edit-right .right-code .ui-btn .code').stop().fadeOut();
    });
$(function(){
        $(".index-main").on('click', '.delete-fenlei', function(event) {
            event.stopPropagation();
        });
        /*初始化列表展示样式*/
        initListShow();
    });

    var currPage = 1; //分组分页
    function selectGroup(){
        $('#goods-modal').modal('show');
        fetchPageData(currPage);
    }
    /*遍历添加对应列表展示样式*/
    function initListShow(){
        $('.edit-con').find(".showstyle-radio input[type=hidden]").each(function(index, el) {
            var styleVal = $(this).val();
            $(this).parents('.showstyle-radio').find('span').eq(styleVal-1).find('input[type=radio]').prop('checked','checked');
        });
        $('.edit-con').find(".showNum-radio input[type=hidden]").each(function(index, el) {
            var styleVal = $(this).val();
            $(this).parents('.showNum-radio').find('span').eq(styleVal-1).find('input[type=radio]').prop('checked','checked');
        });
        $(".index-main").find("input[type=hidden]").each(function(index, el) {
            var that = $(this);
            var styleVal = that.val();
            var styleDiv = $(this).parents(".product-fenlei-list").find(".goods-show>div");
            var curClass = styleDiv.attr("class");
            styleDiv.removeClass(curClass).addClass('goods-view'+styleVal);
        });
        var length = $(".index-main").find('[data-left-preview]').length-1;
        $(".index-main").find('[data-left-preview]').removeClass('cur-edit');
        $(".index-main").find('[data-left-preview]').eq(length).addClass('cur-edit');
        $(".edit-con").find('[data-right-edit]').removeClass('show');
        $(".edit-con").find('[data-right-edit]').eq(length).addClass('show');
    }

    var imgNowsrc=0;
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
        // return imgNowsrc;

    }

    var app = angular.module('proApp',['RootModule']);

    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    //call the function that was passed
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    app.controller('proCtrl', ['$scope', '$http',function($scope,$http){

        $scope.goodFenleis = <{$data}>;
        /*添加商品分类*/
        $scope.addgoodFenlei = function(){
            var goodFenlei_length = $scope.goodFenleis.length;
            for( var i=0;i<goodFenlei_length;i++){
                if(goodFenlei_length===$scope.goodFenleis[i].index){
                    goodFenlei_length = "a"+goodFenlei_length;
                }else{
                    goodFenlei_length = goodFenlei_length;
                }
            }
            var goodFenlei_Default = {
                id          : 0 ,
                index       : goodFenlei_length,
                imgsrc      : 'public/manage/img/zhanwei/zw_fxb_640_200.png',
                showstyle   : "3",
                kind        : 1,
                kindName    : '请选取商品分组',
                showNum     : 1 ,
                name        : ''
            };
            $scope.goodFenleis.push(goodFenlei_Default);
            setTimeout(function(){
                initListShow();
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },20);
        };
        /*获取真正索引*/
        $scope.getRealIndex = function(index){
            var resultIndex = -1;
            for(var i=0;i<$scope.goodFenleis.length;i++){
                if($scope.goodFenleis[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };
        /*删除元素*/
        $scope.deletegoodFenlei=function(index){
            var resultIndex = -1;
            realIndex = $scope.getRealIndex(index);
            // console.log("当前要删除的索引是"+$scope.getRealIndex(index));
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消'] 
            }, function(){
                var id   = $scope.goodFenleis[realIndex].id;
                $scope.$apply(function(){
                    $scope.goodFenleis.splice(realIndex,1);
                });
                if(id){
                    var data = {
                        'id' : id
                    };
                    $http({
                        method   : 'POST',
                        url      : '/wxapp/goods/delGroupKind',
                        data     :  data
                    }).then(function(response) {
                        layer.msg(response.data.em);
                    });
                }
                initListShow();
            });
        };
        /*保存当前列表样式值到对象*/
        $scope.saveStyleIndex = function(index,val,type){
            console.log(index+","+val+","+type);
            if(type == 'showNum'){
                $scope.goodFenleis[index].showNum = val;
            }else{
                $scope.goodFenleis[index].showstyle = val;
            }
        };
        /*点击显示编辑*/
        $scope.previewCliShow = function($event){
                var _this=$($event.target);
                if(_this.hasClass('product-fenlei-list')){
                    $event.preventDefault();
                    var id = _this.data('id');
                    id = $scope.getRealIndex(id);
                    console.log(id);
                    $(".index-main").find("[data-left-preview]").removeClass('cur-edit');
                    _this.addClass('cur-edit');
                    ///alert($(this));
                    $(".edit-con").find("[data-right-edit]").removeClass('show');
                    $('.edit-con').find("[data-right-edit]").eq(id).addClass('show');
                }
      };

        $scope.changeStyle=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var index = that.parents('.goodsShow-manage').index();
            var value = that.data('styleid');
            that.get(0).checked=true;
            var type =  $event.target.getAttribute('data-type');
            $scope.saveStyleIndex(index,value,type);
            var leftShowList = $(".index-main").find('.product-fenlei-list').eq(index).find(".goods-show>div").eq(0);
            var curClass = leftShowList.attr("class");
            leftShowList.removeClass(curClass).addClass('goods-view'+value);
        };

        $scope.changeShowNum=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var index = that.parents('.goodsShow-manage').index();
            var value = that.data('numid');
            that.get(0).checked=true;

            $scope.goodFenleis[index].showNum = value;
        };

        $scope.selectIndex = "";
        $scope.selectGroup = function(index){
            fetchPageData(currPage);
            $scope.selectIndex = $scope.getRealIndex(index);
            console.log("当前操作的索引："+$scope.selectIndex);
        };
        $scope.selectMath = function(){
            var curindex = $scope.selectIndex;
            console.log("实际操作"+curindex);
            $("#goods-modal").find('table tbody#goods-tr tr').each(function() {
                if($(this).hasClass('selected')){
                    var dataId = $(this).data("id");
                    var dataName = $(this).data("name");
                    console.log(dataId+"/"+dataName);
                    $scope.goodFenleis[curindex].kind = dataId;
                    $scope.goodFenleis[curindex].kindName = dataName;
                    console.log($scope.goodFenleis);
                }
            });
        };
        //保存到服务端
        $scope.saveChange=function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var goodFenlei_length = $scope.goodFenleis.length;
            var data = {
                'num' : goodFenlei_length,
                'goods' : $scope.goodFenleis
            };

            $http({
                method   : 'POST',
                url      : '/wxapp/goods/saveGroupKind',
                data     :  data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                window.location.reload();
            });

        };

        $scope.doThis=function(index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex(index);
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            $scope.goodFenleis[realIndex].imgsrc = imgNowsrc;
            //console.log($scope[type][realIndex]);
        };

    }]);

/**
 * 分页加载分组数据
 * @param page
 */
function fetchPageData(page){
    currPage = page;
    var index = layer.load(10, {
        shade: [0.6,'#666']
    });
    var data = {
        'page'  : page
    };
    $.ajax({
        'type'  : 'post',
        'url'   : '/wxapp/goods/ajaxGroup',
        'data'  : data,
        'dataType' : 'json',
        'success'   : function(ret){
            layer.close(index);
            if(ret.ec == 200){
                fetchGoodsHtml(ret.list);
                $('#footer-page').html(ret.pageHtml)
            }
        }
    });
}
/**
 * 渲染分组数据到固定容器里
 * @param data
 */
function fetchGoodsHtml(data){
    var html = '';
    for(var i=0 ; i < data.length ; i++){
        html += '<tr id="goods_tr_'+data[i].gg_id+'" onclick="selectval(this)" data-id="'+data[i].gg_id+'" data-name="'+data[i].gg_name+'">';
        html += '<td class="col-xs-6">'+data[i].gg_name+'</td>';
        html += '<td class="col-xs-6">'+data[i].gg_total+' 个</td>';
        html += '</tr>';
    }
    $('#goods-tr').html(html);
}
function selectMath(ele){
    var id   = $(ele).data('id');
    var name = $(ele).data('name');
    console.log(id + "," +name +","+selectIndex);

}
function selectval(elem){
    $(elem).addClass('selected').siblings('tr').removeClass('selected');
}

</script>
<{$cropper['modal']}>
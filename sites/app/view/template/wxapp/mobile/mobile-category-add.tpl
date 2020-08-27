<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
    .add-gift{
        padding-top: 10px;
    }
    .info-title{
        padding:10px 0;
        border-bottom: 1px solid #eee;
    }
    .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .input-table{
        width: 100%;
    }
    .input-table td{
        padding:8px 10px;
        vertical-align: middle;
    }
    .input-table td.label-td{
        padding-right: 0;
        width: 130px;
        text-align: right;
        vertical-align: top;
    }
    .input-table label{
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        width: 130px;
        line-height: 34px;
    }
    .input-table .form-control{
        width: 290px;
        height: 34px;
    }
    .Wdate{
        border-color: #ccc;
    }
    .input-table textarea.form-control{
        width: 100%;
        max-width: 750px;
        height: auto;
    }
    .input-table .form-control.spinner-input{
        width: 55px;
        border-color: #dfdfdf;
    }
    .Wdate{
        background-position: 98% center;
    }
    .full-minus-item,.product-item{
        padding: 10px;
        position: relative;
        border: 1px solid #e8e8e8;
        -webkit-border-radius: 4px;
        -ms-border-radius: 4px;
        border-radius: 4px;
        overflow: hidden;
        max-width: 750px;
        padding-right: 45px;
        margin-bottom: 10px;
        min-width: 650px;
    }
    .delete{
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .2;
        filter: alpha(opacity=20);
        position: absolute;
        top: 14px;
        right: 10px;
    }
    .delete:hover{
        opacity: .6;
        filter: alpha(opacity=60);
    }

    .item-wrap{
        font-size: 0;
    }
    .full-minus-item .item-wrap b,.product-item .item-wrap b{
        margin:0 5px;
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
    }
    .full-minus-item .item-wrap span,.product-item .item-wrap span,.product-item .item-wrap div{
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
    }
    .full-minus-item .item-wrap span input,.product-item .item-wrap span input{
        width: 150px;
        font-size: 14px;
    }
    .product-item .item-wrap .good-name-box{
        text-align: left;
        width: 50%;
    }
    .product-item .item-wrap .good-name-box .good-name{
        margin:0;
        padding: 0 5px;
        font-size: 14px;
        width: 95%;
        margin-left: 5px;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .modal-body .table-responsive{
        width: 100%;
    }

    /*选择全部或指定商品*/
    .choose-goodrange{
        padding-top: 5px;
    }
    .choosegoods{
        padding: 5px 0;
    }
    .choosegoods .tip{
        font-size: 12px;
        color: #999;
        margin:0;
    }
    .choosegoods>div{
        display: none;
    }
    .add-good-box .btn{
        margin-top: 10px;
    }
    .add-good-box .table{
        max-width: 1150px;
        margin: 10px 0 0;
    }
    .add-good-box .table thead tr th{
        border-right: 0;
        padding: 8px 10px;
        vertical-align: middle;
    }
    .add-good-box .table tbody tr td{
        padding: 6px 10px;
        vertical-align: middle;
        white-space: normal;
    }
    .left{
        text-align: left;
    }
    .center{
        text-align: center;
    }
    .right{
        text-align: right;
    }
    td.goods-info p{
        height: 20px;
        line-height: 20px;
        margin:0;
    }
    td.goods-info p span{
        display: inline-block;
        vertical-align: middle;
    }
    td.goods-info p span.good_name{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 270px;
        margin-right: 3px;
    }
    td.goods-info p span.good_price{
        color: #FF6600;
    }
    .add-good-box .table span.del-good{
        color: #38f;
        font-weight: bold;
        cursor: pointer;
    }
    .good-item .input-group{
        width: 110px;
        margin:0 auto;
    }
    .good-item .input-group input.form-control{
        width: 45px;
        padding: 6px 3px;
        text-align: center;
    }
    .good-item .input-group input.form-control.red{
        color: #FF6600!important;
    }
    .good-item .input-group .input-group-addon{
        padding: 6px 5px;
    }
    .good-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .good-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }

    .cus-input { padding: 7px 8px; font-size: 14px; border: 1px solid #ddd; -webkit-border-radius: 4px; -moz-border-radius: 4px; -ms-border-radius: 4px; -o-border-radius: 4px; border-radius: 4px; width: 100%; -webkit-transition: box-shadow 0.5s; -moz-transition: box-shadow 0.5s; -ms-transition: box-shadow 0.5s; -o-transition: box-shadow 0.5s; transition: box-shadow 0.5s; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; -o-box-sizing: border-box; box-sizing: border-box; min-height: 34px; resize: none; font-size: 14px;}
    .classify-wrap .classify-title { font-size: 14px;  line-height: 2; }
    .classify-wrap .classify-preiview-page { width: 320px; padding: 0 20px 20px; border: 1px solid #dfdfdf; -webkit-border-radius: 10px 10px 0 0; -moz-border-radius: 10px 10px 0 0; -ms-border-radius: 10px 10px 0 0; -o-border-radius: 10px 10px 0 0; border-radius: 10px 10px 0 0; background-color: #fff; box-sizing: content-box; float: left; }
    .classify-preiview-page .mobile-head { padding: 12px 0; text-align: center}
    .classify-preiview-page .mobile-con { border: 1px solid #dfdfdf; min-height: 150px; background-color: #f5f6f7; }
    .classify-preiview-page .mobile-nav { position: relative; }
    .classify-preiview-page .mobile-nav img { width: 100%; }
    .classify-preiview-page .mobile-nav p { display: none;line-height: 44px; height: 44px; position: absolute; width: 100%; top: 20px; left: 0; font-size: 15px; text-align: center; }
    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
    /*.classify-wrap .right-classify-manage {  min-height: 210px; }*/
    .right-classify-manage .manage-title{font-weight: bold;padding: 10px 10px 5px;}
    .right-classify-manage .manage-title span{font-size: 13px;color: #999;font-weight: normal;}
    .right-classify-manage .add-classify{padding: 0px;}
    .right-classify-manage .add-classify .add-btn{height: 30px;line-height: 30px; padding: 0 10px;background-color: #06BF04;border-radius: 4px;font-size: 14px;display: inline-block;cursor: pointer;border:1px solid #00AB00;color: #fff;}
    .classify-name-con { font-size: 0; padding-top: 10px;}
    .noclassify{font-size: 15px;color: #999;}
    .classify-name-con .classify-name { border: 1px solid #ddd; border-radius: 4px; padding: 5px 10px; position: relative; display: inline-block; font-size: 14px; margin-right: 10px; margin-bottom: 10px; background-color: #f5f6f7; cursor: move;}
    .right-classify-manage .classify-name .cus-input{display: inline-block;width: 150px;}
    .classify-name-con .classify-name .del-btn { display:inline-block;height: 34px; line-height: 34px; font-size: 20px; width: 25px; cursor: pointer; text-align: center; color: #666; vertical-align: middle;}
    .classify-name-con .classify-name .del-btn:hover { color: #333; }
</style>
<{include file="../common-second-menu.tpl"}>

<div class="add-gift" id="div-add" style="margin-left: 150px">
<h4 class="info-title"><span id="show_title">添加电话本商家类型</span></h4>
<input type="hidden" id="id"  class="form-control" value="<{if $row}><{$row['amc_id']}><{/if}>"/>

<table class="input-table">
    <tr>
        <td class="label-td"><label><span class="red">*</span>标题:</label></td>
        <td><input type="text" id="title"  class="form-control" placeholder="请输入标题" value="<{if $row}><{$row['amc_title']}><{/if}>"/></td>
    </tr>
    <tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>图标:</label></td>
        <td><div class="form-group">
                <div>
                    <img onclick="toUpload(this)" data-limit="1" data-width="100" data-height="100" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['amc_img']}><{$row['amc_img']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;">
                    <input type="hidden" id="amc_img"  class="avatar-field bg-img" name="amc_img" value="<{if $row && $row['amc_img']}><{$row['amc_img']}><{/if}>" placeholder="请上传图标"/>
                    <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="100" data-height="100" data-dom-id="upload-cover">修改</a>
                </div>
            </div></td>
    </tr>
    <tr>
        <td class="label-td"><label>排序权重:</label></td>
            <td><input type="text" id="sort"  class="form-control" placeholder="请输入排序权重数值" value="<{if $row}><{$row['amc_sort']}><{else}>0<{/if}>" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-]+/,'');}).call(this)" onblur="this.v();" maxlength="2"/></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>类型标签:</label></td>
        <td class="text-left">
            <div class="classify-wrap" ng-app="classifyApp" ng-controller="classifyCtrl" style="margin-top: 3px;">
                <div class="classify-title" style="">标签名称不能超过6个汉字</div>
                <div class="classify-con" style="overflow: hidden;">
                    <div class="right-classify-manage">

                        <div class="classify-name-con" ui-sortable ng-model="classifyList" id="label-box">
                            <div class="classify-name" ng-repeat="classify in classifyList">
                                <input type="text" ng-model="classify.name" class="cus-input" maxlength="6" placeholder="请输入标签名称">
                                <span class="del-btn" ng-click="delIndex('classifyList',classify.index)">×</span>
                            </div>
                        </div>
                        <div class="add-classify">
                            <span class="add-btn" ng-click="addClassify()" style="background-color: #2a6496;border: 1px solid #2a6496">添加标签</span>
                        </div>

                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">&nbsp;</td>
        <td><a href="javascript:;" class="btn btn-sm btn-green btn-save"> 保 存 分 类 </a></td>
    </tr>
</table>
</div>
<!--添加礼物结束-->
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<{include file="../img-upload-modal.tpl"}>
<script>
    // 分类相关
    var app = angular.module('classifyApp', ['RootModule']);
    app.controller('classifyCtrl',['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.classifyList   = <{$labelList}>;
        $scope.addClassify = function(){
            var classify_length = $scope.classifyList.length;
            var defaultIndex = 0;
            if(classify_length>0){
                for (var i=0;i<classify_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.classifyList[i].index)){
                        defaultIndex = $scope.classifyList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(classify_length>=4){
                layer.msg('最多只能添加4个标签');
            }else{
                var classify_Default = {
                    id: 0,
                    index: defaultIndex,
                    name: '标签名称'
                };
                $scope.classifyList.push(classify_Default);
                $scope.inpurClassify = '';
            }
        };
        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };
        /*删除元素*/
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);

            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');
                $scope.saveSkillTag();
            });
        };

        // 保存分类数据
        $scope.saveSkillTag = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'tagList'  : $scope.classifyList,

            };
            $http({
                method: 'POST',
                url:    '/wxapp/tag/saveData',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };


    }]);




</script>
<script type="text/javascript">
    $(function(){
        // 删除选择的商品
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
            // if(length<=1){
            // 	goodListElem.stop().hide();
            // }
        });


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
                    $('#amc_img').val(allSrc[0]);
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

    $('.btn-save').on('click',function(){
        var field = new Array('title','sort','amc_img');
        var data  = {};
        for(var i=0; i < field.length; i++){
            var temp = $('#'+field[i]).val();
            if(temp){
                data[field[i]] = temp
            }else{
                var msg = $('#'+field[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }

        var label  = [];
        $('#label-box').find("input").each(function(){
            var _this = $(this);
            label.push(_this.val())
        });

        if(label.length == 0){
            layer.msg('请添加类型标签');
            return false;
        }

        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        data.id   	= $('#id').val();
        data.label = label;
        //保存信息
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mobile/saveCategory',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/mobile/index'
                }
            }
        });

    });
</script>

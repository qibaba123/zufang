<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
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
    .right-classify-manage .classify-name .cus-input{display: inline-block;width: 105px;}
    .classify-name-con .classify-name .del-btn { display:inline-block;height: 34px; line-height: 34px; font-size: 20px; width: 25px; cursor: pointer; text-align: center; color: #666; vertical-align: middle;}
    .classify-name-con .classify-name .del-btn:hover { color: #333; }
</style>
<{include file="../common-second-menu-new.tpl"}>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="add-category btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#myModal"  data-id="0" data-sort="" data-name="" data-logo="/public/manage/img/zhanwei/zw_fxb_200_200.png" data-label="" ><i class="icon-plus bigger-80"></i> 添加分类</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>分类名称</th>
                            <th>分类图标</th>
                            <th>分类排序</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['amc_id']}>">
                                <td><{$val['amc_title']}></td>
                                <td>
                                    <{if $val['amc_img']}>
                                <img src="<{$val['amc_img']}>" style="width:50px" alt="">
                                    <{/if}>
                                </td>
                                <td><{$val['amc_sort']}></td>
                                <td><{date('Y-m-d H:i:s',$val['amc_update_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="add-category" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['amc_id']}>" data-sort="<{$val['amc_sort']}>" data-name="<{$val['amc_title']}>" data-logo="<{$val['amc_img']}>" data-label='<{$val['amc_label']}>' >编辑</a> -
                                    <a href="#" data-id="<{$val['amc_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="5" style="text-align:right"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 550px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">图标：(建议尺寸100*100)</label>
                    <div class="col-sm-8">
                        <div>
                            <div class="cropper-box" data-width="100" data-height="100" style="height:100%;">
                                <img id="default-cover" src="/public/manage/img/zhanwei/zw_fxb_200_200.png" width="100%" height="100%" style="display:block;width: 75px;height: 75px" alt="图标" >
                                <input type="hidden" class="avatar-field bg-img" name="category-logo" id="category-logo"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类名称：</label>
                    <div class="col-sm-8">
                        <input id="category-name" class="form-control" placeholder="请填写分类名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类排序：</label>
                    <div class="col-sm-8">
                        <input type="number" id="category-sort" class="form-control" placeholder="数字越大，排序越靠前" maxlength="2" style="height:auto!important" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">分类标签：</label>
                    <div class="col-sm-8">
                        <div class="classify-wrap" ng-app="classifyApp" ng-controller="classifyCtrl" style="margin-top: 3px;">
                <div class="classify-title" style="">标签名称不能超过6个汉字</div>
                <div class="classify-con" style="overflow: hidden;">
                    <div class="right-classify-manage">

                        <div class="classify-name-con" ng-model="classifyList" id="label-box">
                            <div class="classify-name" ng-repeat="classify in classifyList">
                                <input type="text" ng-model="classify.name" class="cus-input" maxlength="6" placeholder="请输入名称">
                                <span class="del-btn" onclick="deleteLabel(this)">×</span>
                            </div>
                        </div>
                        <div class="add-classify">
                            <span class="add-btn" style="background-color: #2a6496;border: 1px solid #2a6496">添加标签</span>
                        </div>

                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="add-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{$cropper['modal']}>
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>

<script>

    $('.add-btn').on('click',function () {
        var length = $('.classify-name').length;
        if(length < 4 ){
            var _html = '<div class="classify-name" ng-repeat="classify in classifyList"><input type="text" ng-model="classify.name" class="cus-input" maxlength="6" placeholder="请输入名称"><span class="del-btn" onclick="deleteLabel(this)">×</span></div>';

        $('.classify-name-con').append(_html);
        }else{
            layer.msg('最多只能添加4个标签');
        }

    });

    function deleteLabel(label) {
        $(label).parent().remove();
    }


    $('.add-category').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#category-name').val($(this).data('name'));
        $('#category-sort').val($(this).data('sort'));
        $('#category-logo').val($(this).data('logo'));
        $('#default-cover').attr('src',$(this).data('logo'));
        $('.classify-name-con').html('');
        if($(this).data('label').length > 0){
            var labelArr = $(this).data('label');
            for(var i = 0 ; i < labelArr.length ; i++){
                $('.classify-name-con').append('<div class="classify-name"><input type="text" value="'+ labelArr[i] +'" class="cus-input" maxlength="6" placeholder="请输入名称"><span class="del-btn" onclick="deleteLabel(this)">×</span></div>');
            }

        }
    });

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            if(id){
	            var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/mobile/deleteCategory',
	                'data'  : { id:id},
	                'dataType' : 'json',
	                success : function(ret){
	                    layer.close(loading);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
	                        window.location.reload();
	                    }
	                }
	            });
	        }
        });
    }

    $('#add-category').on('click',function(){
        var name = $('#category-name').val();
        var sort = $('#category-sort').val();
        var logo = $('#category-logo').val();

        var label  = [];
        $('#label-box').find("input").each(function(){
            var _this = $(this);
            label.push(_this.val())
        });

//        if(label.length == 0){
//            layer.msg('请添加类型标签');
//            return false;
//        }
        if(!name){
            layer.msg('请填写分类名称');
            return;
        }
        if(!logo){
            layer.msg('请上传分类图标');
            return;
        }

        var loading = layer.load(10, {
            shade: [0.6,'#666']
        });
        var id  = $('#hid_id').val();


        var data = {
            id   : id,
            name : name,
            logo : logo,
            sort : sort,
            label : label

        };
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
                    window.location.href='/wxapp/mobile/categoryList'
                }
            }
        });

    });
</script>


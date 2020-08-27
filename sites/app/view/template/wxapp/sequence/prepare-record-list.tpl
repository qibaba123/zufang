<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    .goods-row .name-input{
        width: 60%;
    }
    .goods-row .num-input{
        width: 20%;
    }
    .goods-row input{
        margin-right: 10px;
    }
    .goods-row{
        margin-bottom: 3px;
    }
    .list-group{
        margin-bottom:0;
    }
    .list-group-item-info {
        display: flex;
        color: #31708f;
        /*background-color: #d9edf7;*/
        border:1px solid #f1f1f1!important;
        border-radius: 4px;
        border-left-width:1px!important;
    }
    .list-group-item-info span:nth-of-type(1){
        flex: 1;
    }
    .list-group-item-info span:nth-of-type(2){
        width: 100px;
    }
    .table-hover>tbody>tr:hover .list-group-item-info{
        background-color: #f5f5f5;
    }
    </style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <button class="btn btn-sn btn-success edit-goods" data-id="0" data-status="1" data-note="<{$val['note']}>" data-addmid="0" data-addtype="2" data-community="0" data-toggle="modal" data-target="#myModal">
                添加
            </button>
            <div class="introduce-tips" style="display:inline-block;min-width:400px;margin-left:20px;">
	        	<div class="tips-btn">
	        		<span>介绍</span><img src="/public/site/img/tips.png" alt="图标" />
	        	</div>
	        	<div class="tips-con-wrap">
	        		<div class="tips-con">
		        		<div class="triangle_border_up"><span></span></div>
		        		<div class="con">功能使用说明：该处点击“添加”按钮，由团长在小程序端团长管理中心->配货记录表进行确认。；小程序端团长管理中心->配货记录表点击添加，由平台进行确认。便于平台和团长双方核对每次收到的商品数量。</div>
		        	</div>
	        	</div>
	        </div>	
        </div>
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/prepareRecordList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="truename" value="<{$truename}>"  placeholder="姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">电话</div>
                                    <input type="text" class="form-control" name="mobile" value="<{$mobile}>"  placeholder="电话">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">状态</div>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0">全部</option>
                                        <option value="2" <{if $status == 2}> selected <{/if}>>已确认</option>
                                        <option value="1" <{if $status == 1}> selected <{/if}>>未确认</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">小区</div>
                                    <input type="text" class="form-control" name="community" value="<{$community}>"  placeholder="小区">
                                </div>
                            </div>

                            <div class="form-group" style="width: 480px;margin-top: 10px">
                                <div class="input-group">
                                    <div class="input-group-addon" >提交时间</div>
                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                    <span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>团长/小区</th>
                            <th>商品信息</th>
                            <th>备注</th>
                            <th>时间</th>
                            <td>来源</td>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['id']}>">
                                <td style="text-align: left">
                                   <p>姓名：<{$val['leaderName']}></p>
                                   <p>电话：<{$val['leaderMobile']}></p>
                                    <{if $val['communityName']}>
                                    <p>小区：<{$val['communityName']}></p>
                                    <{/if}>
                                </td>
                                <td style="text-align: left;white-space: inherit;max-width: 400px">
                                    <{if $val['goodsData']}>
                                    <ul class="list-group" style='max-width: 500px;'>
                                        <{foreach $val['goodsData'] as $goods}>
                                        <li class="list-group-item list-group-item-info">  
                                            <span>商品名称：<b class='text-warning'><{$goods['name']}></b></span>
                                            <span>到货数：<b class='text-warning'><{$goods['num']}></b></span>
                                        </li>
                                        <{/foreach}>
                                    </ul>
                                    <{/if}>
                                </td>
                                <td style="text-align: left;white-space: inherit;max-width: 200px">
                                    <{$val['note']}>
                                </td>
                                <td>
                                    <{$val['time']}><br>
                                </td>
                                <td>
                                    <{if $val['addType'] == 1}>
                                    团长添加
                                    <{elseif $val['addType'] == 2}>
                                    后台添加
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['status'] == 1}>
                                    <span style="color: red"><{$val['statusNote']}></span>
                                    <{else}>
                                    <span style="color: green"><{$val['statusNote']}></span>
                                    <{/if}>

                                </td>
                                <td>
                                    <p>
                                        <a data-id="<{$val['id']}>" data-status="<{$val['status']}>" data-note="<{$val['note']}>" data-addmid="<{$val['addMid']}>" data-addtype="<{$val['addType']}>" data-community="<{$val['community']}>" data-toggle="modal" data-target="#myModal" class="edit-goods" style="cursor: pointer;">编辑</a>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>

                        <!--<tr><td colspan="6" style='text-align:right;'></td></tr>-->

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<{if $showPage != 0 }>
<!--固定分页底部-->
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">
            <div class="bottom-opera-item" style="text-align:center">
                <div class="page-part-wrap"><{$pagination}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 900px;">
        <div class="modal-content" style="overflow: visible">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    编辑
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">
                <div class="goods-box" style="width: 100%;padding: 10px">

                </div>
                <div style="text-align: center">
                    <span class="btn btn-primary" onclick="addGoods()">添加商品</span>
                </div>
                <div class="form-group row admin-status" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">状态：</label>
                    <div class="col-sm-8">
                        <input type="radio" name="prepare_status" id="prepare_status_1" value="1" >待确认
                        <input type="radio" name="prepare_status" id="prepare_status_2" value="2" style="margin-left: 10px">已确认
                    </div>
                </div>

                <div class="form-group row admin-community" style="margin-top: 10px;display: none">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">小区：</label>
                    <div class="col-sm-8">
                        <select name="select_community" id="select_community" class="form-control">
                            <option value="0">请选择小区</option>
                            <{foreach $communitySelect as $val}>
                            <option value="<{$val['id']}>"><{$val['name']}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>

                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                    <div class="col-sm-8">
                        <textarea name="note" id="note" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" onclick="savePrepare()">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    var goodsList = <{$goodsList}>;
    $('.edit-goods').on('click',function () {
        $('.goods-box').empty();
        var status = $(this).data('status');
        var note = $(this).data('note');
        var hid_id = $(this).data('id');
        var addType = $(this).data('addtype');
        var community = $(this).data('community');
        $('#hid_id').val(hid_id);
        $('#note').val(note);
        $('#select_community').val(community);
        $('#prepare_status_'+status).prop('checked',true);
        var html_str = '';
        var goods_html = '';
        var goodsData = [];
        if(hid_id > 0){
            goodsData = goodsList[hid_id];
            $('.admin-status').css('display','block');
        }else{
            //添加的时候不选择状态
            $('.admin-status').css('display','none');
        }
        if(goodsData.length > 0){
            $(goodsData).each(function (key,row) {
                goods_html = getGoodsHtml(row.name,row.num);
                html_str += goods_html;
            });
            $('.goods-box').append(html_str);
        }

        if(addType == 2){
            //后台添加的时候可以更改小区
            $('.admin-community').css('display','block');
        }else{
            $('.admin-community').css('display','none');
        }

    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#asa_name').val('');
        $('#asa_poster_name').val('');
        $('#asa_poster_mobile').val('');
    });



    function savePrepare() {
        layer.confirm('确定保存吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $('#hid_id').val();
            var note = $('#note').val();
            var status = $('input[name=prepare_status]:checked').val();
            var community = $('#select_community').val();
            var goods = [];
            var goods_name = '';
            var goods_num = '';
            var goods_row = {};
            $('.goods-row').each(function (key,row) {
                goods_name = $(row).find('.name-input').val();
                goods_num = $(row).find('.num-input').val();
                goods_row = {
                    'name' : goods_name,
                    'num'  : goods_num
                };
                goods.push(goods_row);
            });

            var data = {
                id:id,
                note:note,
                status:status,
                goods:goods,
                community:community
            };
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/prepareRecordSave',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        });

    }

    function getGoodsHtml(name,num) {
        var goods_html = "<div class='goods-row' style='width: 100%'>名称：<input type='text' class='form-control name-input' value='"+name+"' style='display: inline-block;margin-right: 10px'>件数：<input type='text' class='form-control num-input' value='"+num+"' style='display: inline-block;margin-right: 10px'><span class='btn btn-xs btn-danger' onclick='removeGoods(this)'>删除</span></div>";
        return goods_html;
    }

    function addGoods() {
        var goods_html = getGoodsHtml('','');
        $('.goods-box').append(goods_html);
    }

    function removeGoods(ele) {
        $(ele).parent().remove();
    }


</script>
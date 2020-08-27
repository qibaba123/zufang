<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style>
    .container{
        width: 60%;
    }
    .group-info .control-group .form-control {
        max-width: 100%;
    }
    .layui-layer .container{
        width: 100%;
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
    .search-input{
        width: 90% !important;
        margin-bottom: 5px !important;
        display: block !important;
    }

</style>

<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['asl_id']}><{$row['asl_id']}><{/if}>"/>
    <div class="group-info">
        <{if !$row['asl_id']}>
        <div class="form-group">
            <label for="">搜索会员<font color="red">* 按照微信昵称进行搜索（该微信需已进入并授权头像和昵称）</font></label>
            <div class="control-group">
            <{include file="../layer/ajax-select-input-single.tpl"}>
            </div>
        </div>
        <{else}>
        <input type="hidden" id="hid_mid" value="<{$row['asl_m_id']}>">
        <{/if}>
        <div class="form-group">
            <label for="">姓名<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="asl_name" placeholder="真实姓名" class="form-control"  value="<{if $row && $row['asl_name']}><{$row['asl_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">电话<font color="red">*</font></label>
            <div class="control-group">
                <input id="asl_mobile" class="form-control" placeholder="电话" value="<{if $row && $row['asl_mobile']}><{$row['asl_mobile']}><{/if}>">
            </div>
        </div>
        <div class="form-group" style="display: none">
            <label for="">微信</label>
            <div class="control-group">
                <input id="asl_wxcode" class="form-control" placeholder="微信" value="<{if $row && $row['asl_wxcode']}><{$row['asl_wxcode']}><{/if}>">
            </div>
        </div>
        <{if $region == false}>
        <div class="form-group">
            <label for="">分佣比例(%)<font color="red">*</font></label>
            <div class="control-group">
                <input id="asl_percent" class="form-control" type="number" maxlength="3" value="<{if $row && $row['asl_percent']}><{$row['asl_percent']}><{/if}>">
                <span style="color: #777">请填写0-100之间的整数</span>
            </div>
        </div>
        <{/if}>
        <div class="form-group" style="display: none">
            <label for="">上级团长</label>
            <div class="control-group">
                <span id="parent-leader" style="display: inline-block;min-width: 200px">
                    <{if $parent}>
                    <{if $parent['asl_name']}><{$parent['asl_name']}><{else}><{$parent['m_nickname']}><{/if}>（会员编号：<{$parent['m_show_id']}>）
                    <{else}>
                    无<{/if}>
                </span>
                <a href="#" class="btn btn-sm btn-blue get-members" data-mk="leader" style="display: inline-block;margin-left: 80px">选择团长</a>
                <input type="hidden" value="<{if $parent}><{$parent['asl_id']}><{else}>0<{/if}>" id="asl_parent_id">
                <input type="hidden" value="<{if $parent}><{$parent['asl_m_id']}><{else}>0<{/if}>" id="asl_parent_mid">
            </div>
        </div>

        <div class="form-group">
            <label for="">二维码<font color="red">*</font><small style="font-size: 12px;color:#999">建议尺寸：400 x 400 像素</small></label>
            <div class="control-group" style="margin-top: 10px">
                <div>
                    <img onclick="toUpload(this)" data-limit="1" data-width="400" data-height="400" data-dom-id="upload-asl_qrcode" id="upload-asl_qrcode"  src="<{if $row && $row['asl_qrcode']}><{$row['asl_qrcode']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="asl_qrcode"  class="avatar-field bg-img" name="asl_qrcode" placeholder="请上传团长二维码" value="<{if $row && $row['asl_qrcode']}><{$row['asl_qrcode']}><{/if}>"/>
                    <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="400" data-height="400" data-dom-id="upload-asl_qrcode">修改</a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">备注</label>
            <div class="control-group">
                <textarea class="form-control" name="asl_remark" id="asl_remark" cols="30" rows="3"><{if $row && $row['asl_remark']}><{$row['asl_remark']}><{/if}></textarea>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning setting-save" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm btn-save">保存</button>
</div>
<div id="goods-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">查找</h4>
            </div>
            <div class="modal-body">
                <div class="good-search">
                    <div class="input-group">
                        <input type="text" id="nickname" class="form-control search-input" placeholder="昵称">
                        <input type="text" id="truename" class="form-control search-input search-truename" placeholder="姓名">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr style="margin: 0">
                <table  class="table-responsive">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <thead>
                    <tr>
                        <th>头像</th>
                        <th style="text-align:left">昵称</th>
                        <th class="th-truename">姓名</th>
                        <th>会员编号</th>
                        <th>操作</th>
                    </thead>

                    <tbody id="goods-tr">
                    <!--商品列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<{include file="../img-upload-modal.tpl"}>
<script>

    //管理商品
    $('.get-members').on('click',function(){
        //初始化
        $('#goods-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');
        if(type == 'leader'){
            $('.th-truename').show();
            $('.search-truename').show();
        }else{
            $('.th-truename').hide();
            $('.search-truename').hide();
        }
        $('#goods-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchPageData(currPage);
    });

    function fetchPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            //'id'    :  $('#currId').val()  ,
            'page'  : page,
            'nickname': $('#nickname').val(),
            'truename' : $('#truename').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/fetchMemberLeader',
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

    function fetchGoodsHtml(data){
        var mk = $('#mkType').val();
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].m_id+'">';
            if(data[i].m_avatar){
                html += '<td><img src="'+data[i].m_avatar+'"/></td>';
            }else{
                html += '<td><img src="/public/wxapp/images/applet-avatar.png"/></td>';
            }

            html += '<td style="text-align:left"><p class="g-name">'+data[i].m_nickname+'</p></td>';
            if(mk == 'leader'){
                html += '<td class="th-truename">'+ data[i].asl_name +'</td>';
                //html += '<td><a href="javascript:;" class="btn btn-xs btn-danger" data-type="del" data-id="'+data[i].g_id+'" onclick="dealMember( this )"> 移除 </a></td>';
            }
            html += '<td style="text-align:center"><p class="g-name">'+data[i].m_show_id+'</p></td>';
            html += '<td><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-mid="'+data[i].m_id+'" data-id="'+data[i].asl_id+'" data-name="'+data[i].asl_name+'" data-nickname="'+data[i].asl_nickname+'" data-showid="'+data[i].m_show_id+'" onclick="dealMember( this )"> 选取 </td>';
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }

    function dealMember(ele){
        var name = $(ele).data('name');
        var nickname = $(ele).data('nickname');
        var id   = $(ele).data('id');
        var mid   = $(ele).data('mid');
        var showid   = $(ele).data('showid');
        $('#asl_parent_id').val(id);
        $('#asl_parent_mid').val(mid);
        var showname = ''
        if(name){
            showname = name;
        }else{
            showname = nickname;
        }
        var str = showname+'（会员编号：'+showid+'）';
        $('#parent-leader').text(str);
        $('#goods-modal').modal('hide');
    }
</script>
<script type="text/javascript">


    $('.btn-save').click(function(){
        var id = $('#hid_id').val();
        var name = $('#asl_name').val();
        var mobile = $('#asl_mobile').val();
        var percent = $('#asl_percent').val();
        var parent = $('#asl_parent_id').val();
        var parentMid = $('#asl_parent_mid').val();
        var remark = $('#asl_remark').val();
        var qrcode = $('#asl_qrcode').val();
        var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');


         if(percent > 100){
             layer.msg("分佣比例不能大于100%");
             return;
         }
        if(!name || !mobile){
            layer.msg("姓名或电话不能为空");
            return;
        }
        if(!id && !mid){
            layer.msg("请选择会员");
            return;
        }
        if(!qrcode){
            layer.msg("请上传团长二维码");
            return;
        }
        if(parent == id){
            layer.msg('上级团长不能是自己');
            return;
        }
        // if(!shopName) {
        //     layer.msg("店铺名称不能为空");
        //     return;
        // }
        // if(!address || !lng || !lat){
        //     layer.msg("请填写并在地图中标记地址");
        //     return;
        // }

        var data = {
                id : id,
                name: name,
                mid : mid,
                percent : percent,
                mobile : mobile,
                parent : parent,
                parentMid : parentMid,
                remark : remark,
                qrcode : qrcode
            };
        
        $('.btn-save').attr('disabled',true);
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/leaderSave',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/sequence/leaderList';
                }else{
                    $('.btn-save').attr('disabled',false);
                }
            }
        });

    })

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>

<{$cropper['modal']}>

<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">

<style>
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }

    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    .ui-popover{
        z-index: 1010;
    }
    .lookup-condition{
        width: 100%;
        height: 35px;
        margin-bottom: 10px;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }

    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
</style>

<div id="content-con">
    <a href="/wxapp/job/editPosition?pType=<{$pType}>" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <div  id="mainContent" >

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/job/positionList" method="get" class="form-inline">
                    <input type="hidden" name="search_type" value="<{$pType}>">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">职位名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="职位名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">公司名称</div>
                                    <input type="text" class="form-control" name="company" value="<{$company}>" placeholder="公司名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">职位ID</div>
                                    <input type="text" class="form-control" name="id" value="<{$id}>" placeholder="公司名称">
                                </div>
                            </div>

                            <div class="form-group" style="width: 440px">
                                <div class="input-group">
                                    <div class="input-group-addon">城市搜索</div>
                                    <select class="form-control" id="search_province" name="search_province" onchange="changeSearchAmapProvince()" placeholder="请选择省份" style="width: 45%;display: inline-block">
                                        <option value="">选择省份</option>
                                    </select>
                                    <select class="form-control" id="search_city" name="search_city"  placeholder="请选择城市" style="width: 50%;display: inline-block">
                                        <option value="" >选择城市</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn">
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
                            <th>职位ID</th>
                            <th>职位名称</th>
                            <th>职位类型</th>
                            <th>公司名称</th>
                            <th>职位城市</th>
                            <th>是否有奖</th>
                            <th>是否置顶</th>
                            <th>职位状态</th>
                            <th>发布时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ajp_id']}>">
                                <td><{$val['ajp_id']}></td>
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><{$val['ajp_title']}></td>
                                <td><{$val['ajc_name']}></td>
                                <td><{$val['ajc_company_name']}></td>
                                <td><{$val['ajp_city']}></td>
                                <td><{if $val['ajp_type']==1}><span style="color: red">有</span><{else}>无<{/if}></td>
                                <td  class="set-top" <{if $val['ajp_is_top'] eq 1 && $val['ajp_top_expiration']>time()}>style="color: red;text-align: center"<{/if}>>
                                <{if $val['ajp_is_top'] eq 1 && $val['ajp_top_expiration']>time()}>
                                是
                                <p><{date('m-d H:i', $val['ajp_top_expiration'])}></p>
                                <{else}>
                                否 <a data-toggle="modal" data-target="#myTopModal" href="#" data-id="<{$val['ajp_id']}>" class="zhiding">置顶</a>
                                <{/if}>
                                </td>
                                <td><{if $val['ajp_status'] == 1}><span style="color:green">招聘中</span><{else}><span style="color:red">已关闭</span><{/if}></td>
                                <td><{date("Y-m-d H:i", $val['ajp_create_time'])}></td>
                                <td>
                                    <p>
                                        <a href="/wxapp/job/editPosition?id=<{$val['ajp_id']}>&pType=<{$pType}>" >编辑</a> -
                                        <a href="/wxapp/job/positionDetail?id=<{$val['ajp_id']}>&pType=<{$pType}>" >预览职位</a> -
                                        <a href="/wxapp/job/sendRecord?id=<{$val['ajp_id']}>">投递记录</a>-
                                        <{if $val['ajp_type'] == 1}>
                                        <a href="/wxapp/job/awardDetail?id=<{$val['ajp_id']}>" >奖金详情</a> -
                                        <{/if}>
                                        <{if $val['ajp_status'] == 1}>
                                        <a href="#" id="close-confirm" data-id="<{$val['ajp_id']}>" onclick="closePosition('<{$val['ajp_id']}>')" >关闭职位</a> -
                                        <{/if}>
                                        <a href="#" id="delete-confirm" data-id="<{$val['ajp_id']}>" onclick="deletePosition('<{$val['ajp_id']}>')" style="color:#f00;">删除</a>
                                    </p>
                                    <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                    <p>
                                        <a href="javascript:;" onclick="pushPosition('<{$val['ajp_id']}>')" >推送</a> -
                                        <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview(<{$val['ajp_id']}>)">推送预览</a> -
                                        <a href="/wxapp/tplpreview/pushHistory?type=position&id=<{$val['ajp_id']}>" >推送记录</a>
                                    </p>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="12"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>


<!-- 模态框（置顶选项） -->
<div class="modal fade" id="myTopModal" tabindex="-1" role="dialog" aria-labelledby="myTopModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 460px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myTopModal">
                    置顶帖子
                </h4>
                <input type="hidden" id="pid" value="">
            </div>
            <div class="modal-body">
                <div id="buy-template">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num">置顶时间：</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="cost_data">
                                <{foreach $costList as $val}>
                                <option value="<{$val['act_id']}>"><{$val['act_data']}>天</option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="confirm-top">
                        确认置顶
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>

<div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="overflow: auto; width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    推送预览
                </h4>
            </div>
            <div class="modal-body preview-page" style="overflow: auto">
                <div class="mobile-page ">
                    <div class="mobile-header"></div>
                    <div class="mobile-con">
                        <div class="title-bar">
                            消息模板预览
                        </div>
                        <!-- 主体内容部分 -->
                        <div class="index-con">
                            <!-- 首页主题内容 -->
                            <div class="index-main" style="height: 380px;">
                                <div class="message">
                                    <h3 id="tpl-title"></h3>
                                    <p class="date" id="tpl-date"></p>
                                    <div class="item-txt"  id="tpl-content">

                                    </div>
                                    <div class="see-detail">进入小程序查看</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-footer"><span></span></div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>

<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

        var search_city = '<{$search_city}>';
        var search_province = '<{$search_province}>';

        intiSearchPosition(search_province,search_city,0);

    });

    function intiSearchPosition(province,city,zone) {
        console.log(province);
        console.log(city);
        if(province){
            initSearchAmap(-1,'search_province',province);
            if(city){
                initSearchAmap(province,'search_city',city);
            }
            if(city && zone){
                initSearchAmap(city,'search_zone',zone);
            }
        }else if(city){  //区域管理合伙人获取可添加的街道区域
            if(zone)
                initSearchAmap(city,'search_zone',zone);
            else
                initSearchAmap(city,'search_zone',0);
        }else{
            initSearchAmap(-1,'search_province');
        }
    }

    function deletePosition(id) {
        //var id = $(this).data('id');
        console.log(id);
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/job/deletePosition',
            'data'  : { id:id},
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    function closePosition(id) {
        var load_index = layer.load(2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/job/closePosition',
            'data'  : { id:id},
            'dataType'  : 'json',
            'success'  : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    //置顶功能
    $('.zhiding').on('click',function(){
        var id = $(this).data('id');
        if(id){
            $('#pid').val(id);
        }
    });
    $('#confirm-top').on('click',function(){
        var id   = $('#pid').val();
        var cost = $('#cost_data').val();
        if(id && cost){
            var data = {
                'id'   : id,
                'cost' : cost
            };
            var load_index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'      : 'post',
                'url'       : '/wxapp/job/positionTop',
                'data'      : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em,{
                        time:1000
                    },function(){
                        window.location.reload();
                    });
                }
            });
        }
    });

    function pushPosition(id) {
        layer.confirm('确定要推送吗？', {
            btn: ['确定','取消'], //按钮
            title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/positionPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/positionPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }

    /**
     * 省会变更
     */
    function changeSearchAmapProvince(){
        var fid = $('#search_province').val();
        initSearchAmap(fid ,'search_city');
    }

    function initSearchAmap(fid,selectId,df){
        if(fid != 0) {
            var data = {
                'fid': fid
            };
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/index/amap',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        region_html(ret.data,selectId,df);
                        if(!df){
                            if(selectId == 'search_province'){
                                initSearchAmap(ret.data[0].aa_id,'city');
                            }
                            if(selectId == 'search_city'){
                                initSearchAmap(ret.data[0].aa_id,'zone');
                            }
                        }
                    }
                }
            });
        }
    }


    /**
     * 展示区域省市区
     * @param data
     * @param selectId
     */
    function region_html(data,selectId,df){
        console.log('this is df--'+ df);
        var option = '<option  value="">请选择</option>';
        for(var i=0 ; i < data.length ; i++){
            var temp  = data[i];
            var sel   = '';
            if(df && temp.aa_id == df ){
                sel = 'selected';
            }
            option += '<option  value="'+temp.aa_id+'" '+sel+'>'+temp.aa_name+'</option>';
        }
        $('#'+selectId).html(option);
    }

</script>
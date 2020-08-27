<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .balance .balance-info .balance-content {
        zoom: 1;
        text-align: center;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
        text-align: center;
    }
    .balance .balance-info {
        float: left;
        width: 33.3%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
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
</style>


<div id="content-con">

    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-xs btn-green" href="/wxapp/job/editResume" >新增</a>
        </div>
        <!-- 订单汇总信息 -->
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">已创建简历总数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{if $total}><{$total}><{else}>0<{/if}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">公开数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{if $publicTotal}><{$publicTotal}><{else}>0<{/if}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">未公开数</div>
                <div class="balance-content">
                    <span class="money money-font"><{if $privateTotal}><{$privateTotal}><{else}>0<{/if}></span>
                </div>
            </div>
        </div>

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/job/resumeList" method="get" class="form-inline">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
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

        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/Excel/resumeExportExcel" method="get" class="form-inline">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">开始日期</div>
                                    <input type="text" class="form-control date-picker" autocomplete="off" required name="start_time" data-date-format="yyyy-mm-dd" value="<{if $start_time}><{$start_time}><{/if}>" placeholder="开始日期">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">结束日期</div>
                                    <input type="text" class="form-control date-picker" autocomplete="off" required name="end_time" data-date-format="yyyy-mm-dd" value="<{if $end_time}><{$end_time}><{/if}>" placeholder="结束日期">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn">
                        <button type="submit" class="btn btn-green btn-sm">简历导出</button>
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
                            <th>会员头像</th>
                            <th>会员昵称</th>
                            <th>手机号</th>
                            <th>姓名</th>
                            <th>头像</th>
                            <th>求职意向</th>
                            <th>发布时间</th>
                            <th>是否公开</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['ajr_id']}>">
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><img src="<{$val['m_avatar']}>" alt="" style="width: 50px"></td>
                                <td><{$val['m_nickname']}></td>
                                <td><{$val['ajr_mobile']}></td>
                                <td><{$val['ajr_name']}></td>
                                <td><img src="<{$val['ajr_avatar']}>" alt="" style="width: 50px"></td>
                                <td><{$val['ajc_name']}></td>
                                <td><{date("Y-m-d H:i", $val['ajr_create_time'])}></td>
                                <td><{if $val['ajr_public']}><span>公开</span><{else}><span style="color: red">不公开</span><{/if}></td>
                                <td>
                                    <a href="/wxapp/job/resumeDetail?id=<{$val['ajr_id']}>" data-toggle="modal" >预览简历</a>
                                    <{if $val['ajr_background'] == 1}>
                                     - <a href="/wxapp/job/editResume?id=<{$val['ajr_id']}>" >编辑简历</a>
                                    <p>
                                        <a href="/wxapp/job/editWorkExperience?id=<{$val['ajr_id']}>" >编辑工作经历</a>
                                         - <a href="/wxapp/job/editEduExperience?id=<{$val['ajr_id']}>" >编辑教育经历</a>
                                    </p>
                                    <p>
                                        <a href="/wxapp/job/editObjExperience?id=<{$val['ajr_id']}>" >编辑项目经历</a>
                                         - <a href="#" style="color: red" onclick="confirmDelete(this)" data-id="<{$val['ajr_id']}>">删除简历</a>
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

<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/jquery.prettyphoto.js"></script>
<script type="text/javascript" src="/public/plugin/prettyPhoto/js/lrtk.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>

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

        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        var search_city = '<{$search_city}>';
        var search_province = '<{$search_province}>';

        intiSearchPosition(search_province,search_city,0);

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
                    'url'   : '/wxapp/job/deleteResume',
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
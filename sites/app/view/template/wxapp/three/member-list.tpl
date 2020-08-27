<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<style>
    .form-group-box { overflow: auto; }
    .form-group-box .form-group { width: 260px; margin-right: 10px; float: left; }
    .table.table-avatar tbody>tr>td { line-height: 30px; }
    .fixed-table-box .table thead>tr>th, .fixed-table-body .table tbody>tr>td { text-align: center; }
    .member-set .form-group { margin-right: 0; margin-left: 0; width: 200px; display: table-cell; vertical-align: middle; }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 33.33%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
</style>
<div class="ui-popover ui-popover-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span></span>
        <select id="member-grade" name="jiaohuo">
            <{if $mLevel}>
                <option value="0">请选择等级</option>
            <{foreach $mLevel as $key=>$val}>
                <option value="<{$key}>"><{$val}></option>
            <{/foreach}>
            <{else}>
                <option value="0">尚未添加等级</option>
            <{/if}>
        </select>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn ui-btn-primary js-save" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<!--转移会员下级-->
<div class="ui-popover ui-member-select left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center;margin-bottom: 6px;">将所有下级会员转移至新选择会员下</span>
        <div class="member-set" style="display: table;">
        <{include file="../layer/ajax-select-input-single.tpl"}>
        <input type="hidden" id="hid_mid" value="0">
         <input type="hidden" id="nickname" >
            <div style="text-align: center;padding: 3px 0 3px 5px;display: table-cell;vertical-align: middle;">
            <a class="ui-btn ui-btn-primary my-ui-btn save-transfer-member" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<!--转移会员下级结束-->
<div class="ui-popover ui-popover-time left-center" style="top:100px;">
    <div class="ui-popover-inner">
        <span></span>
        <input type="text" id="endDate" style="margin:0">
        <input type="hidden" id="hid_dateid" value="0">
        <a class="ui-btn ui-btn-primary js-save-date" href="javascript:;" onclick="saveDate(this)">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<{include file="../common-second-menu.tpl"}>
<div  id="mainContent">
    <{if $curr_shop['s_empty_membership'] eq 0}>
     <!--<div class="alert alert-block alert-warning" style="line-height: 20px;">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        清空会员关系将会把所有会员上下级关系、上下级数量、分销佣金全部清空，该操作仅能操作一次且会员总人数少于50人时才能使用，请谨慎使用
        <br/>
   </div>
   <div class="page-header" style="overflow:hidden">
        <div class="col-sm-1">
            <a class="btn btn-green btn-sm btn-deleted" href="javascript:;">
                <i class="bigger-40"></i> 清空会员关系
            </a>
        </div>
    </div>-->
    <{/if}>
    <!-- 汇总信息 -->
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">分销会员<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
       <!-- <div class="balance-info">
            <div class="balance-title">最高级会员<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['highestTotal']}></span>
            </div>
        </div>-->
        <div class="balance-info">
            <div class="balance-title">累计销售<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['sale']}></span>
                <span class="unit">元</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计返佣<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['deduct']}></span>
                <span class="unit">元</span>
            </div>
        </div>
    </div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/three/member" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <input type="hidden" name="type" value="<{if $type}><{$type}><{else}>all<{/if}>">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">昵称</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>" placeholder="微信昵称">
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">会员编号</div>
                                <input type="text" class="form-control" name="mid"  value="<{if $mid}><{$mid}><{/if}>" placeholder="编号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">手机号</div>
                                <input type="text" class="form-control" name="mobile"  value="<{if $mobile}><{$mobile}><{/if}>" placeholder="手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">备注</div>
                                <input type="text" class="form-control" name="remark"  value="<{if $remark}><{$remark}><{/if}>" placeholder="备注">
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
    <div class="choose-state">
        <!-- <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $type eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
        -
        <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;">
            <i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span>
        </button>
        -->
       <!-- <{if $type eq 'highest'}>
        <button class="pull-right btn btn-info btn-xs add-btn" style="margin-top: 5px;margin-right: 10px;"
                data-type="highest" data-title="添加最高级">
            添加最高级
        </button>
        <{/if}>-->
        <{if $type eq 'refer'}>
        <button class="pull-right btn btn-info btn-xs add-btn" style="margin-top: 5px;margin-right: 10px;"
                data-type="refer" data-title="添加官方推荐人">
            添加官方推荐人
        </button>
        <{/if}>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fixed-table-box" style="margin-bottom: 30px;">
                        <div class="fixed-table-header">
                            <table class="table table-hover table-avatar">
                                <thead>
                                    <tr>
                                        <th>会员编号</th>
                                        <th>会员昵称</th>
                                       <!-- <th>分佣区域</th>-->
                                        <th>会员备注</th>
                                        <th>手机号</th>
                                        <th>分享码</th>
                                        <th>分享海报</th>
          
                                        <{if $curr_shop['s_id'] eq 7163 || $curr_shop['s_id'] neq 7224}>
                                        <th>会员等级</th>
                                        <{/if}>
                                        <th>销售总额</th>
                                        <th>返佣总额</th>
                                        <th>下级数量</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="fixed-table-body">
                            <table id="sample-table-1" class="table table-hover table-avatar">
                                <tbody>
                                <{foreach $list as $val}>
                                    <tr id="tr_<{$val['m_id']}>">
                                        <td><{$val['m_show_id']}></td>
                                        <td>
                                            <{if $val['m_nickname']}>
	                                            <a href="/wxapp/member/list?mid=<{$val['m_show_id']}>"><{$val['m_nickname']}>
	                                           <!-- <{if $val['m_is_highest'] eq 1}>
	                                            	(最高级) 
	                                            <{/if}>
	                                            <{if $val['m_is_refer'] eq 1}>
	                                            	(官方推荐人)
	                                            <{/if}>-->
                                                    (<{$deduct[$val['m_is_highest']]}>)
	                                            </a>
                                            <{else}>
                                            -
                                            <{/if}>
                                            <!--<{if $val['m_is_highest'] eq 1}>
                                            <span class="label label-sm label-success">
                                                最高级</span>
                                            <{/if}>
                                            <{if $val['m_is_refer'] eq 1}>
                                            <span class="label label-sm label-info">
                                                官方推荐人</span>
                                            <{/if}>-->
                                        </td>
                                        <!--<td><{$val['m_h_pro_name']}>-<{$val['m_h_city_name']}>-<{$val['m_h_area_name']}>-<{$val['m_h_street_name']}></td>-->
                                        <td><div style="white-space: normal;line-height:1.5;width:160px;"><{$val['m_remark']}></div></td>
                                        <td><{if $val['m_mobile']}><{$val['m_mobile']}><{else}>无<{/if}></td>
                                        <td><{$val['m_invite_code']}></td>
                                        <td id="td_share_img_<{$val['m_id']}>">
                                            <{if $val['m_spread_image']}>
                                            <a href="javascript:;" class="btn btn-primary btn-xs btn-share-look" data-uid="<{$val['m_id']}>" data-img="<{$val['m_spread_image']}>">查看海报</a>
                                            <{else}>
                                            <p>未生成海报</p>
                                            <a href="javascript:;" class="btn btn-primary btn-xs btn-share-create" data-uid="<{$val['m_id']}>">创建海报</a>
                                            <{/if}>
                                        </td>
                     
                                        <{if $curr_shop['s_id'] eq 7163 || $curr_shop['s_id'] neq 7224}>
                                            <td><{$mLevel[$val['m_level']]}></td>
                                        <{/if}>
                                        <td><{$val['m_sale_amount']}></td>
                                        <td><{$val['m_deduct_amount']}></td>
                                        <td>
                                        	<!--<{$val['total1']}>-->
	                                        <{if $val['total1']}>
	                                            <a href="/wxapp/three/member?1f_id=<{$val['m_id']}>" title="查看下级会员"><{$val['total1']}></a>
	                                        <{else}>
	                                        	<span><{$val['total1']}></span>
	                                        <{/if}>                        
                                        </td>
                        
                                        <td class="jg-line-color">
                                            <a href="/wxapp/three/daybook?mid=<{$val['m_id']}>">佣金流水</a>
                                            <{if $type eq 'refer'}>
                                             - <a href="javascript:;" class="cel-refer" data-id=<{$val['m_id']}>>取消官方推荐</a>
                                            <{/if}>
                                            <{if $curr_shop['s_id'] eq 7163 || $curr_shop['s_id'] neq 7224}>
                                             - <a href="#" class="set-membergrade" data-id="<{$val['m_id']}>" data-level="<{$val['m_level']}>">设会员</a>
                                            <{/if}>
                                            <!--<a href="#" class="transfer-member" data-id="<{$val['m_id']}>" data-nickname="<{$val['m_nickname']}>">转移下级</a>-->
                                            <{if !$type || $type=='all' || $type=='highest'}>
                                             - <a href="/wxapp/member/list?1f_id=<{$val['m_id']}>">查看下级</a>
                                            <{/if}>
                                        </td>
                                    </tr>
                                    <{/foreach}>
                                </tbody>
                            </table>
                            <{$paginator}>
                        </div>
                    </div>
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form><input type="hidden" id="hid_type" value="">
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">会员编号</span>
                            <input type="text" class="form-control" id="showID" aria-describedby="inputGroupSuccess1Status">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group has-success has-feedback">
                        <div class="input-group">
                            <span class="input-group-addon">推荐码(选填)</span>
                            <input oninput="this.value=this.value.replace(/[^\A-\Z0-9]/g,'')" class="form-control" id="code" placeholder="6位数字或大写字母组合,会员推荐码" >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveReferBest">保存</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/custom.js"></script>
<script type="text/javascript" src="/public/wxapp/three/js/member.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $('.add-btn').on('click',function(){
        var type = $(this).data('type');
        var title = $(this).data('title');
        $('#myModalLabel').html(title);
        $('#hid_type').val(type);
        $('#showID').val('');
        $('#code').val('');
        $('#myModal').modal('show')
    });

    $('.saveReferBest').on('click',function(){
        var type   = $('#hid_type').val();
        var showId = $('#showID').val();
        var code   = $('#code').val();
        /*if(code.length !=6 ){
            layer.msg('推荐码必须是6位数字和大写字母组合');
            return false;
        }*/

        if(showId && type){
            var data = {
                'type'      :  type,
                'showId'    : showId,
                'code'      : code
            };
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setReferBest',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });

   $('#myTab li').on('click', function() {
       var id = $(this).data('id');
       window.location.href='/wxapp/three/member?type='+id;
   });

   /*设置会员等级*/
    $('select').searchableSelect();
    $("#mainContent").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
            console.log(level);
           $('#member-grade').val(level);
        }
        $('#hid_mid').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#mainContent").offset().left)-160;
        var conTop = Math.round($("#mainContent").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-360,'top':top-conTop-96}).stop().show();
    });
    /**
     * 保存等级到期时间
     */
    $("#content-con").on('click', 'table td a.long_date', function(event) {
        var _this = $(this);
        var id  = _this.data('id');
        var end = _this.data('end');
        var curDate = _this.text();
        $("#endDate").val(curDate);
        $("#hid_dateid").val(id);

        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#mainContent").offset().left)-60;
        var conTop = Math.round($("#mainContent").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-time").css({'left':left-conLeft-445,'top':top-conTop-96}).stop().show();
    });

    $(".ui-popover").on('click', function(event) {
        event.stopPropagation();
    });
    $(".main-container").on('click', function(event) {
        optshide();
    });

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level>0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择用户等级');
        }

    });


    //取消官方推荐
    $('.cel-refer').on('click',function(){
        var id = $(this).data('id');
        var data  = {
            'id'    : id
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/cancelRefer',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+id).remove();
                    //optshide();
                }
            }
        });
    });
    $('.btn-share-look').on('click',function(){
        var id  = $(this).data('uid');
        var img = $(this).data('img');
        if(id && img){
            var html='<p class="text-center" style="height: 500px;width: 360px;"><img src="'+img+'" alt="宣传海报" style="width:100%; height:100%;" class="img-thumbnail"></p>';
            html  +='<p class="text-center"><button type="button" class="btn btn-danger btn-destroy" onclick="destroySpread('+id+')">销毁此海报</button></p>';
            layer.open({
                type: 1,
                title:'分享海报',
                top:-10,
                skin: 'layui-layer-demo', //样式类名
                closeBtn: 1, //不显示关闭按钮
                shift: 2,
                shadeClose: true, //开启遮罩关闭
                content: html
            });

        }
    });

    function destroySpread(id){
        if(id){
            var data  = {
                'id'    : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/destroySpread',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.closeAll();
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#td_share_img_'+id).text('未生成海报');
                    }
                }
            });
        }
    }


    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

        /*日期选择器*/
        $('#endDate').datepicker({autoclose:true}).next().on(ace.click_event, function(){
          // $(this).prev().focus();
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
    });
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }

    //转移会员下级
    $("#mainContent").on('click', 'table td a.transfer-member', function(event) {
        var id = $(this).data('id');
        var nickname = $(this).data('nickname');
        $('#hid_mid').val(id);
        $('#nickname').val(nickname);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#mainContent").offset().left)-160;
        var conTop = Math.round($("#mainContent").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-member-select").css({'left':left-conLeft-360,'top':top-conTop-96}).stop().show();
    });

    $(".ui-popover .save-transfer-member").on('click', function(event) {
        var targetMid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
        var pendMid = $('#hid_mid').val();
        var nickname = $('#nickname').val();
        var newNickname = $('#hid_nickname').val();
        console.log(newNickname);
        console.log(nickname);
        console.log(targetMid);
        console.log(pendMid);
        if(pendMid>0 && targetMid>0){
            event.preventDefault();
            var data  = {
                'pendMid'    : pendMid,
                'targetMid' : targetMid
            };
            layer.confirm('确定要将《'+nickname+'》的所有下级会员转移到《'+newNickname+'》名下吗？一旦转移将无法恢复', {
                btn: ['确定','取消'], //按钮
                title : '确认转移'
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/member/transferMember',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'  : function(ret){
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                            optshide();
                        }
                    }
                });
            }, function(){

            });
        }else{
            layer.msg('请选择转移到的用户');
        }

    });

    //创建海报
    $('.btn-share-create').on('click',function(){
        var mid  = $(this).data('uid');
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/three/threePostCreate',
            'data'  : {mid: mid},
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    });

    //取消官方推荐
    $('.btn-deleted').on('click',function(){
        console.log(123455);
        layer.confirm('你确定要清空会员关系吗？一旦清空将无法恢复', {
            btn: ['确定','取消'], //按钮
            title : '确认清空'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/three/emptyMemberShip',
                'data'  : { },
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        optshide();
                    }
                }
            });
        }, function(){

        });
    });
</script>
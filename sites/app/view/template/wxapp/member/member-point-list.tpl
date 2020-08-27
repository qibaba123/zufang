<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
    .datepicker{
        z-index: 1060 !important;
    }
    .ui-table-order .time-cell{
        width: 120px !important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }
    .recharge-btn,.point-btn{
        padding: 0 3px !important;
        margin-left: 10px;
        /*position: absolute;*/
        /*right: 5px;*/
        /*top: 24.5px;*/
    }
    .recharge-td {
        /*position: relative;*/
    }
    .waiter-dialog{
        width: 500px !important;
    }
    .waiter-content{
        overflow:visible !important;
    }
    .radio-box span{
        margin-right: 45px !important;
    }
    #waiter_shop{
        max-width: 250px;
    }

    /* 扣费弹出框 */
    .ui-popover,.openid-box {
        background: #000 none repeat scroll 0 0;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        padding: 2px;
        z-index: 1010;
        display: none;
        position: absolute;
        right: 0;
        top: 75%;
        width: 340px;
        left: auto;
    }
    .ui-popover .ui-popover-inner {
        background: #fff none repeat scroll 0 0;
        border-radius: 4px;
        min-width: 280px;
        padding: 10px;
    }
    .ui-popover .ui-popover-inner .money-input,.ui-popover .ui-popover-inner .point-input {
        border-radius: 4px !important;
        line-height: 19px;
        -webkit-transition: border linear .2s, box-shadow linear .2s;
        -moz-transition: border linear .2s, box-shadow linear .2s;
        -o-transition: border linear .2s, box-shadow linear .2s;
        transition: border linear .2s, box-shadow linear .2s;
    }
    .ui-popover .ui-popover-inner .money-input:focus,.ui-popover .ui-popover-inner .point-input:focus {
        border: 1px solid #73b8ee;
        -webkit-box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075);
        -moz-box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075);
        box-shadow: inset 0 1px 1px rgba(115, 184, 238, .075);
    }
    .ui-popover .arrow {
        border: 5px solid transparent;
        height: 0;
        position: absolute;
        width: 0;
    }
    .ui-popover.top-center .arrow {
        left: 90%;
        margin-left: -5px;
        top: -10px;
    }
    .ui-popover.top-left .arrow, .ui-popover.top-center .arrow, .ui-popover.top-right .arrow {
        border-bottom-color: #000;
    }
    .ui-popover .arrow::after {
        border: 5px solid transparent;
        content: " ";
        display: block;
        font-size: 0;
        height: 0;
        position: relative;
        width: 0;
    }
    .ui-popover.top-center .arrow::after {
        left: -5px;
        top: -3px;
    }
    .ui-popover.top-left .arrow::after, .ui-popover.top-center .arrow::after, .ui-popover.top-right .arrow::after {
        border-bottom-color: #fff;
    }

    .bottom-tr td{
        line-height: 25px !important;
    }
    .btn-openid{
        padding-top: 2px !important;
        padding-bottom: 2px !important;
        text-align: center;
        margin: 0 auto;
        width: 72px;
        display: block;
    }

    #sample-table-1{
        border-right: none;
        border-left: none;
    }


</style>
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="fixed-table-box" style="margin-bottom: 30px;">
                        <div class="fixed-table-header">
                            <table class="table table-hover table-avatar">
                                <thead>
                                    <tr>
                                        <th>交易标题</th>
                                        <th>收入类型</th>
                                        <th>积分数量</th>
                                        <th>交易时间</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="fixed-table-body">
                            <table id="sample-table-1" class="table table-hover table-avatar">
                                <tbody>
                                <{foreach $list as $val}>
                                    <tr id="tr_<{$val['m_id']}>">
                                        <td><{$val['pi_title']}></td>
                                        <td><{if $val['pi_type'] == 1}>收入<{else}>支出<{/if}></td>
                                        <td><{$val['pi_point']}></td>
                                        <td><{date('Y-m-d H:i:s',$val['pi_create_time'])}></td>
                                    </tr>
                                <{/foreach}>
                                    <tr class="bottom-tr">
                                        <td colspan="4" style="text-align: right">
                                            <{$paginator}>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>

<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/controllers/member.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    $(function(){
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
    })
    var clipboard = new ClipboardJS('.copy-openid');
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
    });

    //新增添加会员弹出框
    function addMember(){
        $('#add-modal').modal('show');
    }
    //保存新的会员信息
    function saveMember(){
       var name    = $('#username').val();
       var avatar  = $('#cover').val();
       var data    = {
           'name':name,
           'avatar':avatar
       };
       if(name && avatar){
           $.ajax({
               'type'  : 'post',
               'url'   : '/wxapp/member/addMember',
               'data'  : data,
               'dataType' : 'json',
               'success'  : function(ret){
                   layer.msg(ret.em);
                   if(ret.ec == 200){
                       //$('#tr_'+id).remove();
                       //optshide();
                       window.location.reload();
                   }
               }
           });
       }else{
           layer.msg('请完善信息');
       }

    }
    /*扣费弹出框*/
    $(".js-recharge-money").click(function(event) {
        event.stopPropagation();
        $(".money-input").val('');
        $(this).next().stop().fadeToggle();
        $("#money-input")[0].focus();
    });
    /*减少积分弹出框*/
    $(".js-recharge-point").click(function(event) {
        event.stopPropagation();
        $(".point-input").val('');
        $(this).next().stop().fadeToggle();
        $("#point-input")[0].focus();
    });

    function hideChargeInput(){
        $(".charge-input").stop().fadeOut();
    }
    function hidePointInput(){
        $(".point-charge-input").stop().fadeOut();
    }

    /*确认扣费*/
    function confirmSplit(elem, coin, mid){
        var txt;
        var that = $(elem);
        txt = that.prev().val();
        if(mid){
            if(!isNaN(txt)){
                if (txt == 0) {
                    layer.msg('金额必须为数字');
                } else {
                    amount  = Math.abs(txt);
                    if(amount<=coin){
                        layer.confirm('确定扣除用户'+amount+'余额？', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var data = {
                                'mid'   : mid,
                                'amount': amount
                            };
                            $.ajax({
                                type  : 'post',
                                url   : '/wxapp/member/splitMoney',
                                data  : data,
                                dataType  : 'json',
                                success : function (json_ret) {
                                    layer.msg(json_ret.em);
                                    if(json_ret.ec == 200){
                                        window.location.reload();
                                    }
                                }
                            })
                        }, function(){

                        });
                    }else{
                        layer.msg('扣除金额大于用户余额');
                    }
                }
            }else{
                layer.msg('金额必须为数字');

            }
        }


    }

    /*确认扣除积分*/
    function confirmPointSplit(elem, coin, mid){
        var txt;
        var that = $(elem);
        txt = that.prev().val();
        if(mid){
            if(!isNaN(txt)){
                if (txt == 0) {
                    layer.msg('积分必须为数字');
                } else {
                    amount  = Math.abs(txt);
                    if(amount<=coin){
                        layer.confirm('确定扣除用户'+amount+'积分？', {
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var data = {
                                'mid'   : mid,
                                'point': amount
                            };
                            $.ajax({
                                type  : 'post',
                                url   : '/wxapp/member/splitPoint',
                                data  : data,
                                dataType  : 'json',
                                success : function (json_ret) {
                                    layer.msg(json_ret.em);
                                    if(json_ret.ec == 200){
                                        window.location.reload();
                                    }
                                }
                            })
                        }, function(){

                        });
                    }else{
                        layer.msg('扣除积分大于用户积分');
                    }
                }
            }else{
                layer.msg('积分必须为数字');

            }
        }


    }


    $('.add-btn').on('click',function(){
        var type = $(this).data('type');
        var title = $(this).data('title');
        $('#myModalLabel').html(title);
        $('#hid_type').val(type);
        $('#showID').val('');
        $('#code').val('');
        $('#myModal').modal('show')
    });
    //充值模态框点击
    $('.recharge-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var coinNow = $(this).data('coin');
        //批量充值
        if(type == 'multi'){
            //隐藏操作选择
            $(".coin-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".coin-operate").css('display','');
        }
        $('#hid_mid').val(mid);
        $('#recharge_type').val(type);
        $('#gold_coin_now').val(coinNow);
        $('#gold_coin').val('');
        $('#remark').val('');
        $('#pwd').val('');
    });


    //增加积分模态框点击
    $('.point-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var pointNow = $(this).data('point_now');
        //批量增加
        if(type == 'multi'){
            $(".point-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".point-operate").css('display','');
        }
        $('#point_mid').val(mid);
        $('#point_type').val(type);
        $('#point_now').val(pointNow);
        $('#point').val('');
        $('#point_remark').val('');
        $('#point_pwd').val('');
    });

    $('.waiter-set').on('click',function () {
        var mid = $(this).data('mid');
        var isWaiter = $(this).data('waiter');
        var shop = $(this).data('shop');
        $('#hid_waiter_mid').val(mid);
        if(isWaiter){
            $('#waiter_yes').attr('checked','checked');
            $('#waiter_no').attr('checked','');
        }
        $('#waiter_shop').val(shop);
    });

    $('.saveWaiter').on('click',function(){
        var mid    = $('#hid_waiter_mid').val();
        var isWaiter = $('input:radio[name="is_waiter"]:checked').val();
        var shop   = $('#waiter_shop').val();
        if(mid){
            var data = {
                'mid'     : mid,
                'isWaiter': isWaiter,
                'shop'    : shop
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setWaiterNew',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.close(index);
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });

    $('.saveReferBest').on('click',function(){
        var type   = $('#hid_type').val();
        var showId = $('#showID').val();
        var code   = $('#code').val();
        if(code.length !=6 ){
            layer.msg('推荐码必须是6位数字');
            return false;
        }

        if(showId && type){
            var data = {
                'type'      :  type,
                'showId'    : showId,
                'code'      : code
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                type  : 'post',
                url   : '/wxapp/member/setReferBest',
                data  : data,
                dataType  : 'json',
                success : function (json_ret) {
                    layer.close(index);
                    layer.msg(json_ret.em);
                    if(json_ret.ec == 200){
                        window.location.reload();
                    }
                }
            })
        }
    });
    //管理员操作余额
    $('.saveRecharge').on('click',function(){
        var mid    = $('#hid_mid').val();
        var coin   = $('#gold_coin').val();
        var coinNow= $('#gold_coin_now').val();
        var remark = $('#remark').val();
        var pwd    = $('#pwd').val();
        var type   = $('#recharge_type').val();
        var operate= $("input[name='operateCoin']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && parseFloat(coinNow) < parseFloat(coin)){
            layer.msg('扣费金额需小于当前余额');
            return false;
        }
        var data = {
            'mid'     : mid,
            'coin'    : coin,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl= '/wxapp/member/newSaveRecharge';
        //批量充值
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择用户');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiRecharge'
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

    //管理员增加积分
    $('.savePoint').on('click',function(){
        var mid    = $('#point_mid').val();
        var type   = $('#point_type').val();
        var point  = $('#point').val();
        var pointNow = $('#point_now').val();
        var remark = $('#point_remark').val();
        var pwd    = $('#point_pwd').val();
        var operate= $("input[name='operatePoint']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && pointNow < point){
            layer.msg('扣除积分需小于当前积分');
            return false;
        }

        var data = {
            'mid'     : mid,
            'point'   : point,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl = '/wxapp/member/savePoint';
        //批量增加
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择会员');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiPoint';
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });

   $('#myTab li').on('click', function() {
       var id = $(this).data('id');
       window.location.href='/wxapp/member/list?type='+id;
   });

   /*设置会员等级*/
    $('#member-grade').searchableSelect();
    $("#content-con").on('click', 'table td a.set-membergrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
           $('#member-grade').val(level);
        }
        $('#hid_mid').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        $(".ui-popover.ui-popover-select").css({'left':left-conLeft-486,'top':top-conTop-76}).stop().show();
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
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top); 
        $(".ui-popover.ui-popover-time").css({'left':left-conLeft-445,'top':top-conTop-96}).stop().show();
    });

    // $(".ui-popover").on('click', function(event) {
    //     event.stopPropagation();
    // });
    // $(".ui-popover").on('click', function(event) {
    //     setTimeout(function () {
    //         event.preventDefault();
    //         event.stopPropagation();
    //     },100);
    // });

    //$(".main-container").on('click', function(event) {

    $("#content-con").on('click', function(event) {
        optshide();
    });

    /*复制openid弹出框*/
    $("#content-con").on('click', 'table td a.btn-openid', function(event) {
        var openid = $(this).data('openid');
        if(openid){
            $('.copy-div input').val(openid);
            $('.copy-div .copy-openid').attr('data-clipboard-text',openid);
        }
        event.preventDefault();
        event.stopPropagation();

        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-openid").css({'left':left-conLeft-64,'top':top-conTop-66}).stop().show();
    });

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level != 0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
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
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/cancelRefer',
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+id).remove();
                    //optshide();
                }
            }
        });
    });
    /*$('.long_date').on('click',function(){
        var id  = $(this).data('id');
        var end = $(this).data('end');
    });*/

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

    function changeStatus(id, status){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/changeStatus',
            'data'  : {id: id,status: status},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    $('.freeze-gold').on('click',function () {
        var mid = $(this).attr('mid');
        var status = $(this).attr('status')
        var text;
        if(status==1){
        	text="确定要冻结余额吗？";
        }else{
        	text="确定要解冻余额吗？";
        }
        layer.confirm(text, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(
	                2,
	                {
	                    shade: [0.1,'#333'],
	                    time: 10*1000
	                }
	        );
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/member/freezeGold',
	            'data'  : {mid: mid,status: status},
	            'dataType'  : 'json',
	            'success'   : function(ret){
	                layer.close(load_index);
	                if(ret.ec == 200){
	                    window.location.reload();
	                }else{
	                    layer.msg(ret.em);
	                }
	            }
	        });
        });
    });

    $('.set-waiter').on('click',function () {
        var mid = $(this).attr('mid');
        var status = $(this).attr('status')
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/setWaiter',
            'data'  : {mid: mid,status: status},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    });

    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

    $('.leader-set').on('click',function () {
       var mid = $(this).data('mid');
       var type = $(this).data('type');
       var text = '';
       if(type == 1){
           text = '确定将该用户设置为团长吗？';
       }else{
           text = '确定取消该用户的团长吗？';
       }
        layer.confirm(text, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/changeLeader',
                'data'  : {mid: mid,type: type},
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });

    });

</script>
<{include file="../img-upload-modal.tpl"}>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .nav-tabs{z-index:1;}
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
    .table thead tr th{font-size:12px;}
    .choose-state>a.active{border-bottom-color: #4C8FBD;border-top:0;}
    .tr-content .card-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;margin-left:3px}
    .tr-content:hover .card-admend{visibility:visible;}
    .btn-xs{padding:0 2px!important;}
</style>
<!-- 修改会员卡信息弹出框 -->
<div class="ui-popover ui-popover-cardinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-cardinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <{include file="./tabal-link.tpl"}>
            <div class="tab-content"  style="z-index:1;">
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <div class="page-header">
                            <{if $cardtype eq 1}>
                            <a href="/wxapp/membercard/addCard" class="btn btn-green btn-sm" >添加会员计次卡</a>
                            <{/if}>
                            <{if $cardtype eq 2}>
                            <a href="/wxapp/membercard/addCard/type/2" class="btn btn-green btn-sm" >
                                <{if $appletCfg['ac_type'] == 16}>
                                添加会员卡
                                <{else}>
                                添加会员卡
                                <{/if}>

                            </a>
                            <{if $appletCfg['ac_type'] == 27}>
                            <a href="/wxapp/knowledgepay/vipRightsCfg" class="btn btn-green btn-sm" >会员权益页面</a>
                            <{/if}>
                            <{/if}>
                        </div>
                        <!--------------会员卡记录列表---------------->
                        <div class="choose-state">
                            <{if $appletCfg['ac_type'] != 16}>
                            <{if $cardtype eq 1}>
                            <a href="/wxapp/membercard/card/type/1"  class="active" >优惠次卡</a>
                            <{/if}>
                            <{if $cardtype eq 2}>
                            <a href="/wxapp/membercard/card/type/2"  class="active" >会员卡</a>
                            <{/if}>
                            <{/if}>

                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <{if $cardtype eq 2}>
                                    <th>会员卡名称</th>
                                    <{else}>
                                    <th>会员卡名称</th>
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] != 16}>
                                    <th>副标题</th>
                                    <{/if}>
                                    <th>类型/时长</th>
                                    <th>价格</th>
                                    <{if $appletCfg['ac_type'] != 16}>
                                    <th>消费次数</th>
                                    <{/if}>
                                    <{if $cardtype eq 2}>
                                    <th>折扣率</th>
                                    <{/if}>
                                    <th>排序权重</th>
                                    <th>权益</th>
                                    <th>须知</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                <tr id="tr_<{$val['oc_id']}>" class="tr-content">
                                    <td><{$val['oc_name']}></td>
                                    <{if $appletCfg['ac_type'] != 16}>
                                    <td><{$val['oc_name_sub']}></td>
                                    <{/if}>
                                    <td><{$type[$val['oc_long_type']]['name']}>/<{$val['oc_long']}>天</td>
                                    <td><{$val['oc_price']}></td>
                                    <{if $appletCfg['ac_type'] != 16}>
                                    <td><{if $val['oc_times']}><{$val['oc_times']}>次<{else}>不限<{/if}></td>
                                    <{/if}>
                                    <{if $cardtype eq 2}>
                                    <td><{if $val['ml_discount'] > 0}><{$val['ml_discount']}>折<{/if}></td>
                                    <{/if}>
                                    <td>
                                        <span><{$val['oc_weight']}></span>
                                        <img src="/public/wxapp/images/icon_edit.png" class="card-admend set-card-weight" data-id="<{$val['oc_id']}>" data-value="<{$val['oc_weight']}>" data-field="weight" />
                                    </td>
                                    <td><{$val['oc_rights']}></td>
                                    <td><{$val['oc_notice']}></td>
                                    <td style="color:#ccc;">
                                        <a href="/wxapp/membercard/addCard/?id=<{$val['oc_id']}>&type=<{$val['oc_type']}>" >编辑</a>-
                                        <a href="javascript:;" data-id="<{$val['oc_id']}>" class="del-btn" style="color:#f00;">删除</a>
                                    </td>
                                </tr>
                                <{/foreach}>
                                <{if $pageHtml}>
                                    <tr><td colspan="10" class='text-right'><{$pagination}></td></tr>
                                <{/if}>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
    $("body").on('click', function(event) {
        optshide();
    });

    $('.del-btn').on('click',function(){
        var data   = {
            'id'     : $(this).data('id')
        };
        if(data.id > 0){
        	layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           	var loading = layer.load(10, {
	                shade: [0.6,'#666']
	            });
	           	console.log(data);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/membercard/delCard',
	                'data'  : data,
	                'dataType' : 'json',
	                'success'   : function(ret){
	                    console.log(ret);
	                    layer.close(loading);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
	                        $('#tr_'+data.id).hide();
	                    }
	                }
	            }); 
	        });
        }
    });

    /*修改商品信息*/
    $("#content-con").on('click', 'table td .card-admend.set-card-weight', function(event) {
        var id = $(this).data('id');
        var field = $(this).data('field');
        //var value = $(this).data('value');
        var value = $(this).parent().find("span").text();//直接取span标签内数值,防止更新后value不变
        //console.log(value);
        $('#hid_gid').val(id);
        $('#hid_field').val(field);
        $('#currValue').val(value);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-cardinfo").css({'left':left-conLeft-376,'top':top-conTop-76}).stop().show();
    });

    $(".ui-popover-cardinfo").on('click', function(event) {
        event.stopPropagation();
    });

    /*隐藏弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    $(".save-cardinfo").on('click',function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });

        var id = $('#hid_gid').val();
        var field = $('#hid_field').val();
        var value = $('#currValue').val();

        var data = {
            'id'  :id,
            'field' :field,
            'value':value
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/membercard/changeCardInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find("span").text(value);
                    layer.close(index);
                    if(field == "weight"){
                        window.location.reload();
                    }
                }else{
                    layer.msg(ret.em);
                }
            }
        });


    });
</script>




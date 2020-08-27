<script>
    //console.log(<{$siddd}>);
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .fixed-table-body {
        max-height: inherit;
    }
</style>
<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-goodsinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-goodsinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con" >
    <a href="/wxapp/meal/addGood" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/meal/goods" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="商品名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">分类</div>
                                <select id="cate" name="cate" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $category as $key => $val}>
                                    <option <{if $cate eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
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
    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $status eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>商品 价格</th>
                                <th>分类</th>
                                <th>售卖方式</th>
                                <th>商品销量</th>
                                <th>排序权重</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['g_id']}>">
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['g_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td class="proimg-name" style="min-width: 270px;">
                                    <{if isset($val['g_cover'])}>
                                    <img src="<{$val['g_cover']}>" width="75px" height="75px" alt="封面图">
                                    <{/if}>
                                    <div>
                                        <p class="pro-name">
                                            <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                            <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                        </p>
                                        <p class="pro-price"><{$val['g_price']}></p>
                                    </div>
                                    
                                </td>
                                <td><{$category[$val['g_kind1']]}></td>
                                <td><{$g_sold_type[$val['g_sold_type']]}></td>
                                <td><{$val['g_sold']}></td>
                                <td>
                                    <span><{$val['g_weight']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_weight']}>" data-field="weight">修改</a>
                                </td>
                                <td><{date('Y-m-d H:i:s',$val['g_update_time'])}></td>

                                <td>
                                    <a href="/wxapp/meal/addGood/?id=<{$val['g_id']}>" >编辑</a> -
                                    <a href="javascript:;" id="del_<{$val['g_id']}>" class="btn-del" data-gid="<{$val['g_id']}>">删除</a> 
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr>
                                <td colspan="2">
                                    <{if $status eq 'sell'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下架</span>
                                    <{elseif $status eq 'depot'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <{/if}>
                                    <{if $plateform != 2}>
                                    <span class="btn btn-xs btn-name btn-change-cate btn-primary" >
                                        <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >修改商品分类</a>
                                    </span>
                                    <{/if}>
                                </td>
                                <td colspan="8" style="text-align:right"><{$paginator}></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->
<!-- 商品分类批量修改 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    修改商品分类
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="kind2" class="control-label">商品分类：</label>
                    <div class="control-group" id="customCategory">
                        <select id="custom_cate"  style="height:34px;width:100%" class="form-control">
                            <option value="0">全部</option>
                            <{foreach $category as $key => $val}>
                            <option <{if $cate eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-cate">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('gid'),
            'type': 'goods'
        };
        commonDeleteByIdWxapp(data);
    });

    $('.btn-shelf').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){
            var data = {
                'ids' : ids,
                'type' : type
            };
            var url = '/wxapp/goods/shelf';
            plumAjax(url,data,true);
        }

    });

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    = '<{$now}>';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
        // 批量修改商品分类
        $('#change-cate').on('click',function(){
            var ids  = get_select_all_ids_by_name('ids');
            if(ids){
                var data = {
                    'ids' : ids,
                    'custom_cate': $('#custom_cate').val()
                };
                var url = '/wxapp/meal/changeCate';
                plumAjax(url,data,true);
            }else{
                layer.msg('请选择要修改的商品！');
            }
        });

    });

    /*修改商品信息*/
    $("#content-con").on('click', 'table td a.set-goodsinfo', function(event) {
        console.log('work');
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
        $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-76}).stop().show();
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

    /*隐藏弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }

    $(".save-goodsinfo").on('click',function () {
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
            'url'   : '/wxapp/goods/changeGoodsInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find("span").text(value);                    
                    if(field == "weight"){
                        window.location.reload();
                    }
                }else{
                    layer.msg(ret.em);
                }
                layer.close(index);
            }
        });


    });
</script>
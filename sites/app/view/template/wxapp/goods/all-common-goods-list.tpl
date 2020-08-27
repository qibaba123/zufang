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

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }

</style>
<div  id="content-con" >
    <!--<a href="javascript:" class="btn btn-green btn-xs btn-import"><i class="icon-plus bigger-80"></i>批量导入</a>-->
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/goods/allCommonGoods" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="商品名称">
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
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th>商品 价格</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['g_id']}>">
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
                                <td><{date('Y-m-d H:i:s',$val['g_update_time'])}></td>
                                <td>
                                    <a href="/wxapp/goods/allCommonGoodsDetail/?id=<{$val['g_id']}>">导入商品</a>
                                    <!--<a href="javascript:" class="btn-import" data-id="<{$val['g_id']}>">导入商品</a>-->
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr>
                                </td><td colspan="3" style="text-align:right"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }

            show_modal_content('threeSale',gid);
            $('#modal-info-form').modal('show');
        }else{
            layer.msg('未获取到商品信息');
        }
    });
    $(function(){
        let name = '<{$name}>';
        let noGoods = '<{$noGoods}>';
        if(name && noGoods==1){
            layer.msg("无关键词商品");
        }
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<{$now}>';
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

    $('.btn-import').on('click',function(){
        var id = $(this).data('id');
        var ids = '';
        if(id){
            ids = id;
        }else{
            ids  = get_select_all_ids_by_name('ids');
        }
        if(ids){
            var data = {
                'ids' : ids
            };
            var url = '/wxapp/goods/allCommon2Shop';
            plumAjax(url,data,false);
        }else{
            layer.msg("请选择要导入的商品");
        }
    });
</script>
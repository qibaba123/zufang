<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/goods-trans.css">
<style type="text/css">
    #form .label{
        height: 25px;
        line-height: 1.4;
        padding: 4px 12px;
        cursor: pointer;
        background-color: #abbac3 !important;
    }
    #form .active{
        background-color: #3a87ad !important;
    }
    .font-bold{
        font-size: 14px;
    }
</style>
<{if $search_box == 1}>
<!-- 是否开启了商品访问的细粒度设置项 -->
<div class='panel panel-default'>
    <div class='panel-body text-right'>
        <div class='row'>
            <div class='col-xs-8 text-left'>
                <form id='form' class='form-inline'>
                    <span name='all' class="search label label-info <{if $smarty.get.start=='all' || $smarty.get.start==''}>active<{/if}>">全部</span>
                    <span name='today' class="search label label-info  <{if $smarty.get.start=='today'}>active<{/if}>">今日</span>
                    <span name='yesterday' class="search label label-info <{if $smarty.get.start=='yesterday'}>active<{/if}>">昨日</span> 
                    <span name='week' class="search label label-info  <{if $smarty.get.start=='week'}>active<{/if}>">近7日</span>
                    <span name='month' class="search label label-info  <{if $smarty.get.start=='month'}>active<{/if}>">近30日</span>&nbsp;&nbsp;
                    <div class='form-group'>
                        <input name='start' type="text" id="start" class='form-control' placeholder="开始时间" value='<{if !in_array($smarty.get.start,["today","yesterday","week","month","all"])}><{$smarty.get.start}><{/if}>' autocomplete='off'>
                    </div>
                    <div class='form-group'>
                        <input name='end' type="text" id="end" class='form-control' placeholder="结束时间" value='<{$smarty.get.end}>' autocomplete='off'>
                    </div>
                    <button type='submit' class='btn btn-info btn-sm' id='dateGroup'>查询</button>
                </form>
            </div>
        </div>
    </div>
</div>
<{/if}>
<div class='help-block text-right'>
    <!-- <small class='text-warning'>*仅统计已完成订单数据*</small> -->
    <a href="/wxapp/seqstatistics/goodsTrans" class='btn btn-sm btn-warning'>
        <{if $smarty.get.finish_only != 1}>
        <i class="icon-ok-sign"></i>
        <{/if}>全部
    </a>
    <a href="/wxapp/seqstatistics/goodsTrans?finish_only=1" class='btn btn-sm btn-warning'>
        <{if $smarty.get.finish_only == 1}>
        <i class="icon-ok-sign"></i>
        <{/if}>仅显示已完成订单
    </a>
</div>
<table class='table table-hover'>
    <thead>
        <tr>
            <th>商品名称</th>
            <th>访问次数</th>
            <th>购买件数</th>
            <th style='width:300px;'>转换率</th>
        </tr>
    </thead>
    <tbody>
        <{foreach $trans_list as $item}>
            <tr>
                <td>
                    <div class='flex'>
                        <p>
                            <img class='goods-img' src="<{$item.g_cover}>">
                        </p>
                        <p>
                            <{$item.g_name}>
                        </p>
                    </div>
                </td>
                <td>
                    <span class='font-bold'><{$item.g_show_real_num}></span>
                </td>
                <td>
                   <span class='font-bold'> <{if $item.num}> <{$item.num}><{else}>0<{/if}></span>
                </td>
                <td>
                    <p class='font-bold'>
                        <{if $item.g_show_real_num==0 && $item.num!=0}>
                            100%
                        <{else}>
                            <{($item.num/$item.g_show_real_num*100)|string_format:"%.2f"}>%
                        <{/if}>
                    </p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="
                        <{if $item.g_show_real_num==0 && $item.num != 0}>
                        100%;
                        <{else}>
                        <{($item.num/$item.g_show_real_num*100)|string_format:"%.2f"}>
                        <{/if}>
                        "
                        aria-valuemin="0" aria-valuemax="100" style="width:
                        <{if $item.g_show_real_num==0 && $item.num != 0}>
                        100%;
                        <{else}>
                        <{($item.num/$item.g_show_real_num*100)|string_format:"%.2f"}>%
                        <{/if}>"></div>
                    </div>
                </td>
            </tr>
            <{/foreach}>
    </tbody>
</table>
<!--<div class='text-right'>
   
</div>-->
<{if $showPage != 0 }>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><{$paginator}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
    $(function(){
        laydate.render({
          elem: '#start' 
        });
        laydate.render({
          elem: '#end' 
        });
        $('.search').click(function(){
            let search_type=$(this).attr('name');
            if(search_type=='all')
                 location.href='/wxapp/seqstatistics/goodsTrans';
            else
                location.href='/wxapp/seqstatistics/goodsTrans?start='+search_type;
        });
    })
</script>

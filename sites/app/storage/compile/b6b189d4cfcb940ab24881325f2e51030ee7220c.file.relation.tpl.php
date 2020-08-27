<?php /* Smarty version Smarty-3.1.17, created on 2020-03-30 22:30:53
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/relation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9010448125e82029dee7f46-29639736%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6b189d4cfcb940ab24881325f2e51030ee7220c' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/three/relation.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9010448125e82029dee7f46-29639736',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'mid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e82029df0cd69_89156797',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e82029df0cd69_89156797')) {function content_5e82029df0cd69_89156797($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<style>
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
        width: 310px;
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
</style>
<head>
    <meta charset="UTF-8">
    <title>echarts demo</title>
    <script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
    <script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
    <script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
    <script type="text/javascript" src="/public/manage/controllers/member.js"></script>
    <script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
    <script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
    <script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
    <script src="http://echarts.baidu.com/build/dist/echarts.js"></script>
    <script type="text/javascript">
        var chart;
        require.config({
            paths: {
                echarts: 'http://echarts.baidu.com/build/dist'
            }
        });
        require(['echarts', 'echarts/chart/tree'], function(ec) {
            chart = ec.init($("#main")[0]);
            chart.setOption(option);
            var ecConfig = require('echarts/config');
            chart.on(ecConfig.EVENT.CLICK, clickFun2);
        })


        var option = {
            tooltip: {
                trigger: 'item',
                formatter: '{b}:{c}',
                hideDelay: 0
            },
            series: [
                {
                name: '树图',
                type: 'tree',
                orient: 'horizontal', // vertical horizontal
                rootLocation: {x: 50,y: 'center'}, // 根节点位置  {x: 'center',y: 10}
                nodePadding: 40, //智能定义全局最小节点间距，不能定义层级节点间距，有点搓。
                symbol: 'circle',
                symbolSize: 40,
                expandAndCollapse: true,
                roam: true,
                data: [<?php echo $_smarty_tpl->tpl_vars['data']->value;?>
]
            }]
        };
        //关键点！
        //显示的图片是否有子节点以及是否收缩了建议用不同的symbol图片（不直接使用的图片预加载过来）
        function clickFun2(param) {
            console.log(param);
            $('#hid_mid').val(param.value.id);
            $('#select-name').html(param.name+':');
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var left = Math.round(param.event.offsetX);
            var top = Math.round(param.event.offsetY);
            $(".ui-popover.ui-popover-select").css({'left':left + 20,'top':top - 50}).stop().show();
            $('#cover').stop().show();

            if(!(param.data.children && param.data.children.length > 0)) {
                console.log('open');
                if(param.value.id != <?php echo $_smarty_tpl->tpl_vars['mid']->value;?>
){
                    param.data.itemStyle.normal.color = "#44b549";
                }
                if(param.data.children_bak) {
                    param.data.children = param.data.children_bak;
                }
            } else {
                console.log('close');
                param.data.itemStyle.normal.color = "#f00";
                param.data.children_bak = param.data.children;
                param.data.children = []; //root节点会在refresh时读children的length
            }
            chart.refresh(); //一定要refresh，否则不起作用
        }

        function hideCover() {
            optshide();
            $('#cover').stop().hide();
        }

        $(function(){
            $('.js-set-highest').on('click', function (e) {
                var id = $('#hid_mid').val();
                var name = $('#select-name').text();
                layer.confirm("确定将【"+name+"】设置为最高级？", {
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
                        'url'   : '/wxapp/three/setHighest',
                        'data'  : {mid: id},
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
            })

            $('.js-empty-children').on('click', function (e) {
                var id = $('#hid_mid').val();
                var name = $('#select-name').text();
                layer.confirm("确定将【"+name+"】设为非分销会员？(其所有下级将全部变为非分销会员)", {
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
                        'url'   : '/wxapp/three/emptyChildren',
                        'data'  : {mid: id},
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
            })

        })

    </script>
</head>

<body>
<div class="ui-popover ui-popover-select left-center" style="top:100px;" >
    <div class="ui-popover-inner" style="text-align: center">
        <div id="select-name" style="margin-bottom: 10px"></div>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn js-set-highest" href="javascript:;">设为最高级</a>
        <a class="ui-btn js-empty-children" href="javascript:;">设为非分销会员</a>
        <a class="ui-btn js-set-children" href="javascript:;" onclick="toSelectMember(this)">添加下级</a>
    </div>
    <div class="arrow"></div>
</div>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="height:800px"></div>
<div id="cover" style="position: fixed; width: 100%;height: 100%;top: 0;display: none" onclick="hideCover()"></div>
</body>

</html>
<?php echo $_smarty_tpl->getSubTemplate ("./member-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>

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
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    table tr td,table tr th{
        text-align: center;
    }
    .shortmenu-intro {
      overflow: hidden;
      background-color: #f5f5f5;
      border-radius: 2px;
      /*margin:15px 0 20px;*/
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
      content: "已启用\a0\a0\a0\a0\a0\a0\a0未启用";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
      background-color: #666666;
      border: 1px solid #666666;
    }
    input[type=checkbox].ace.ace-switch {
      width: 110px;
      height: 36px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
      line-height: 35px;
      height: 36px;
      overflow: hidden;
      border-radius: 18px;
      width: 100px;
      font-size: 14px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before {
      background-color: #44BB00;
      border-color: #44BB00;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
      width: 34px;
      height: 34px;
      line-height: 34px;
      border-radius: 50%;
      top: 1px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after {
      left: 64px;
      top: 1px
    }
</style>

<{if $plugin == 1}>
<{include file="../common-second-menu.tpl"}>
<div id="content-con" style="margin-left: 130px">
<{else}>
<div>
<{/if}>

<div class="shortmenu-intro">
    <!--
    <div class="col-xs-9">
        <h3>门店会员卡</h3>
        <p>开启线下门店会员卡后，商家可添加多个门店、设置门店优惠信息、统计门店销售！</p>
    </div>
    -->
    <!--
    <div class="col-xs-3" style="height: 92px;text-align: right;">
        <label id="choose-onoff" style="margin:35px 0;">
            <input name="sms_start" class="ace ace-switch ace-switch-5" id="sms_start" <{if $cfg }>checked<{/if}> type="checkbox">
            <span class="lbl"></span>
        </label>
    </div>
    <div class="input-group copy-div" style="margin:0 20px 20px">
        <div class="input-group-addon">访问地址：</div>
        <input type="text" class="form-control" id="copy" value="<{$link}>" readonly>
        <span class="input-group-btn">
            <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
        </span>
    </div>
    -->
</div>

<{if $appletCfg['ac_type'] == 21 && $plugin != 1}>
    <div class="alert alert-block alert-yellow ">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        可在底部菜单，折叠菜单，首页快捷导航等处连接门店列表，展示门店相关信息，也可在配送方式处开启门店自提配送方式，用户下单选择门店自提时可以选择相应门店
    </div>
<{/if}>

<div class="row" id="content-con" style="<{if !$cfg }>display: none;<{/if}>">
    <div class="col-sm-12" style="margin-bottom: 20px;">
        <div class="tabbable">
            <!----导航链接----->
            <{include file="./tabal-link.tpl"}>

            <div class="tab-content">
                <!--门店管理-->
                <div id="home" class="tab-pane in active">
                    <a href="/wxapp/membercard/addstore" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;margin-bottom:15px;"><i class="icon-plus bigger-80"></i> 新增</a>
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-hover table-avatar">
                            <thead>
                            <tr>
                                <th>门店名称</th>
                                <th>是否总店</th>
                                <th>联系方式</th>
                                <th>详细地址</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    创建时间
                                </th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <{foreach $list as $val}>
                                <tr id="tr_<{$val['os_id']}>">
                                    <td><{$val['os_name']}></td>
                                    <td><{if $val['os_is_head'] eq 1}>总店<{else}>-<{/if}></td>
                                    <td><{$val['os_contact']}></td>
                                    <td><{$val['os_addr']}></td>
                                    <td><{date('Y-m-d H:i:s',$val['os_create_time'])}></td>
                                    <td style="color:#ccc;">
                                        <{if $face}>
                                         <a href="/wxapp/cash/index?osId=<{$val['os_id']}>&plugin=<{$plugin}>"> 设备绑定 </a>  -
                                        <{/if}>
                                        <a href="/wxapp/membercard/addStore?id=<{$val['os_id']}>&plugin=<{$plugin}>"> 编辑 </a> -
                                        <a href="javascript:void();" class="del-btn" data-id='<{$val['os_id']}>' style="color:#f00;"> 删除 </a>

                                    </td>
                                </tr>
                                <{/foreach}>
                            <tr><td colspan="6"><{$paginator}></td></tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/membercard/store.js"></script>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript">
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
    } );

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

    });
    $('.del-btn').on('click',function(){
        var id = $(this).data('id');
        delStore(id);
    });

    $("#choose-onoff").click(function(event) {
        var isChecked=$(this).find('input[type=checkbox]').is(':checked');
        var data = {};
        if(isChecked){
            $("#content-con").stop().show();
            data.start = 1;
        }else{
            $("#content-con").stop().hide();
            data.start = 0;
        }
        openStore(data);
    });

</script>
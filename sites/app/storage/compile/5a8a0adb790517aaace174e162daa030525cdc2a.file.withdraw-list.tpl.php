<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:11:03
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/goodsratio/withdraw-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8867423525e4e6947103dc8-15106687%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a8a0adb790517aaace174e162daa030525cdc2a' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/goodsratio/withdraw-list.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8867423525e4e6947103dc8-15106687',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'alert' => 0,
    'audit' => 0,
    'name' => 0,
    'mobile' => 0,
    'list' => 0,
    'val' => 0,
    'withdrawType' => 0,
    'bankList' => 0,
    'withdraw_status' => 0,
    'paginator' => 0,
    'tx_ma_map' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e69471893b9_22318571',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e69471893b9_22318571')) {function content_5e4e69471893b9_22318571($_smarty_tpl) {?><style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .modal-body .form-group{
        margin-bottom: 10px;
    }
    .modal-body .form-group .checkbox{
        margin-top: 0;
        margin-bottom: 0;
    }
    .modal-body .form-group label{
        margin-bottom: 5px;
        display: block;
    }
    .table.table-avatar tbody>tr>td{
        line-height: 30px;
    }
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
    }

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
        width: calc(100% / 6);
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
    .fixed-table-box .table thead > tr > th, .fixed-table-body .table tbody > tr > td{
        min-width: 96px !important;
    }

</style>
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
        
    });
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent">
    <div class="alert alert-block alert-warning" style="line-height: 20px;">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        使用企业付款到零钱提现功能,请务必保证你的微信支付--商户平台--产品中心--<a href="https://pay.weixin.qq.com/index.php/public/product/detail?pid=5" target="_blank">企业付款到零钱</a>产品处于开启状态,可点击前往开启产品。
        <br/>
        使用企业付款到银行卡提现功能,请务必保证你的微信支付--商户平台--产品中心--<a href="https://pay.weixin.qq.com/index.php/public/product/detail?pid=5" target="_blank">企业付款到银行卡</a>产品处于开启状态,可点击前往开启产品。
        <!-- 使用微信红包提现功能,请务必保证你的微信支付--商户平台--产品中心--<a href="https://pay.weixin.qq.com/index.php/public/product/detail?pid=4" target="_blank">现金红包</a>产品处于开启状态,可点击前往开启产品。-->
    </div>

    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">累计提现申请<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">累计申请金额<span></span></div>
            <div class="balance-content">
                <span class="money">￥<?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_money'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">待审核提现<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_dsh'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">待审核金额<span></span></div>
            <div class="balance-content">
                <span class="money">￥<?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_dsh_money'];?>
</span>
            </div>
        </div>

        <div class="balance-info">
            <div class="balance-title">已通过提现<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_ytg'];?>
</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已通过金额<span></span></div>
            <div class="balance-content">
                <span class="money">￥<?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total_ytg_money'];?>
</span>
            </div>
        </div>

    </div>

    <div class="page-header" style="overflow:hidden">
        <!--
        <div class="alert alert-block alert-<?php if ($_smarty_tpl->tpl_vars['alert']->value['errno']<0) {?>yellow<?php } else { ?>success<?php }?> ">
            <i class="icon-bullhorn"></i>
            <?php echo $_smarty_tpl->tpl_vars['alert']->value['errmsg'];?>

        </div>
        -->
        <div class="col-sm-1">
            <a class="btn btn-green btn-sm" href="/wxapp/goodsratio/withdrawCfg">
                <i class="icon-cog bigger-40"></i> 提现配置
            </a>
        </div>
    </div>
    <div ng-app="Withdraw"  ng-controller="WithdrawList">
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/goodsratio/withdraw">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <input type="hidden" name="audit" value="<?php echo $_smarty_tpl->tpl_vars['audit']->value;?>
">
                            <div class="form-group">
                                <div class="input-group ">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="提现人姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">手机号</div>
                                    <input type="text" class="form-control" name="mobile" value="<?php echo $_smarty_tpl->tpl_vars['mobile']->value;?>
" placeholder="提现人手机号">
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
            <a href="/wxapp/goodsratio/withdraw" <?php if (!$_smarty_tpl->tpl_vars['audit']->value) {?> class="active" <?php }?>>全部提现申请</a>
            <a href="/wxapp/goodsratio/withdraw?audit=audit" <?php if ($_smarty_tpl->tpl_vars['audit']->value=='audit') {?> class="active" <?php }?>>待审核</a>
            <a href="/wxapp/goodsratio/withdraw?audit=pass" <?php if ($_smarty_tpl->tpl_vars['audit']->value=='pass') {?> class="active" <?php }?>>已通过</a>
            <a href="/wxapp/goodsratio/withdraw?audit=refuse" <?php if ($_smarty_tpl->tpl_vars['audit']->value=='refuse') {?> class="active" <?php }?>>已拒绝</a>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="fixed-table-box" style="margin-bottom: 30px;">
                    <div class="fixed-table-header">
                        <table class="table table-hover table-avatar">
                            <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th class="hidden-480">手机号</th>
                                    <th>提现方式</th>
                                    <th class="hidden-480">提现帐户</th>
                                    <th>实际提现方式</th>
                                    <th>返佣总额</th>
                                    <th>可提现</th>
                                    <th>本次提现金额</th>
                                    <th>手续费</th>
                                    <th>实际到账金额</th>
                                    <th>已经提现</th>
                                    <th>状态</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        申请时间
                                    </th>
                                    <th>
                                        处理结果
                                    </th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="fixed-table-body">
                        <table id="sample-table-1" class="table table-hover">
                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['wd_s_id']==11) {?>
                                    <td class="realName" id="tr_info_<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_id'];?>
"
                                        data-num="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_traded_num'];?>
"
                                        data-money="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_traded_money'];?>
"
                                        data-sale="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_sale_amount'];?>
"
                                        data-deduct="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_deduct_amount'];?>
">
                                        <a href="/wxapp/member/list?realMid=<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_m_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['wd_realname'];?>
</a></td>
                                    <?php } else { ?>
                                    <td><a href="/wxapp/member/list?realMid=<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_m_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['wd_realname'];?>
</a></td>
                                    <?php }?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wd_mobile'];?>
</td>
                                    <td><?php if (isset($_smarty_tpl->tpl_vars['withdrawType']->value[$_smarty_tpl->tpl_vars['val']->value['wd_type']])) {?><?php echo $_smarty_tpl->tpl_vars['withdrawType']->value[$_smarty_tpl->tpl_vars['val']->value['wd_type']];?>
<?php }?></td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['wd_type']==3) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['bankList']->value[$_smarty_tpl->tpl_vars['val']->value['wd_bank']];?>
<br>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['wd_account'];?>

                                        <?php } else { ?>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['wd_account'];?>

                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['wd_curr_type']==2) {?>
                                        微信零钱
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['wd_curr_type']==3) {?>
                                        银行账号
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['wd_curr_type']==4) {?>
                                        人工转账
                                        <?php }?>
                                    </td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_deduct_amount'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_deduct_ktx'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wd_money'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wd_service_money'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wd_money']-$_smarty_tpl->tpl_vars['val']->value['wd_service_money'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_deduct_ytx'];?>
</td>
                                    <td>
                                        <!--
                                        <span class="label label-sm label-<?php echo $_smarty_tpl->tpl_vars['withdraw_status']->value[$_smarty_tpl->tpl_vars['val']->value['wd_audit']]['css'];?>
"><?php echo $_smarty_tpl->tpl_vars['withdraw_status']->value[$_smarty_tpl->tpl_vars['val']->value['wd_audit']]['label'];?>
</span>
                                        -->
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['wd_audit']==0) {?>
                                        <span class="font-color-audit">待审核</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['wd_audit']==1) {?>
                                        <span class="font-color-pass">审核通过</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['wd_audit']==2) {?>
                                        <span class="font-color-refuse">审核拒绝</span>
                                        <?php }?>
                                    </td>
                                    <td><?php echo date('y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['wd_create_time']);?>
</td>
                                    <td>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['wd_audit_note'];?>

                                    </td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['wd_audit']==0) {?>
                                        <button class="btn btn-xs btn-info deal-audit"
                                                data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_id'];?>
"
                                                data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_type'];?>
"
                                                data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_realname'];?>
">
                                            审核
                                        </button>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['wd_audit']==1) {?>
                                        <button class="btn btn-xs btn-warning roll-back hide"
                                                data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_id'];?>
" data-money="<?php echo $_smarty_tpl->tpl_vars['val']->value['wd_money'];?>
">
                                            回滚
                                        </button>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

                    </div>
                </div>
                
            </div><!-- /span -->
        </div><!-- /row -->
        <div id="withdraw-form"  class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">提现处理</h4>
                    </div>
                    <div class="modal-body" style="padding: 10px 20px">
                        <form>
                            <input type="hidden" ng-model="hid_id" id="hid_id" value="0">
                            <div class="form-group">
                                <div class="checkbox" style="padding-left: 0">
                                    <label><b>审核状态</b></label>
                                    <div class="radio-box">
                                        <span>
                                            <input type="radio" name="status" value="1" id="status1" checked>
                                            <label for="status1">通过</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="status" value="2" id="status2">
                                            <label for="status2">拒绝</label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox wx-type" style="padding-left: 0">
                                    <label><b>转账方式</b></label>
                                    <div class="radio-box">
                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['tx_ma_map']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                        <span>
                                            <input type="radio" name="type" id="type<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==1) {?>checked<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
                                            <label for="type<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</label>
                                        </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><b>审核备注</b></label>
                                <textarea type="text" class="form-control" id="note" name="note" rows="3" cols="80" placeholder="请输入审核备注"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                        <button type="button" class="btn btn-primary modal-save" >保存</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/wxapp/three/js/withdraw-list.js" ></script>

<script type="text/javascript" language="javascript">
    $(function(){
        $('.deal-audit').on('click',function(){
            var id   = $(this).data('id');
            var type = $(this).data('type');
            $('#hid_id').val(id);
            $('#note').val('');
            if(type == 1 || type ==3){
                $('.wx-type').show();
            }else{
                $('.wx-type').hide();
            }
            $('#withdraw-form').modal('show');
        });
        $('input[name="status"]').on('click',function(){
           var status = $(this).val();
            if(status == 1 ){
                $('.wx-type').show();
            }else if(status == 2){
                $('.wx-type').hide();
            }
        });
        $('.modal-save').on('click',function(){
            //遮挡，防止多次点击
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{time:10*1000});

            var status = $('input[name="status"]:checked').val();
            var type = $('input[name="type"]:checked').val();
            var id   = $('#hid_id').val();
            var note = $('#note').val();
            if(id && status){
                var data = {
                    'id'     : id,
                    'status' : status,
                    'type'   : type,
                    'note'   : note
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/goodsratio/dealWithdraw',
                    'data'  : data,
                    'dataType'  : 'json',
                    success : function(json_ret){
                        layer.close(index);
                        layer.msg(json_ret.em);

                        if(json_ret.ec == 200){
                            window.location.reload();
                        }
                    }

                })
            }else{
                layer.close(index);
                layer.msg('请求参数错误');
            }
        });
        $('.roll-back').on('click',function(){
            var id    = $(this).data('id');
            var money = $(this).data('money');
            layer.confirm('回滚操作会给用户增加'+money+'元可提现金额，确定操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var data = {
                  'id' : id
                };
                rollbackWithdraw(data);
            });
        });
        $('.realName').on('mouseover',function(){
            var num    = $(this).data('num');
            var money  = $(this).data('money');
            var sale   = $(this).data('sale');
            var deduct = $(this).data('deduct');

            var html = '成交量：'+num+'单<br/>';
            html    += '交易额：'+money+'元<br/>';
            html    += '销售额：'+sale+'元<br/>';
            html    += '总返佣：'+deduct+'元<br/>';
            layer.tips(html, this, {
                tips: [2, '#3595CC'],
                time: 4000
            });
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
    })
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

</script>
<?php }} ?>

<link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">
<style>
    .zent-dialog-body .online-pay-content .weixin-btn {
        top: 45px;
        bottom: inherit;
    }
    .zent-dialog-body .online-pay-content .weixin-btn p {
        margin-bottom: 60px;
    }
</style>
<{if $plugin == 1}>
<{include file="../common-second-menu.tpl"}>
    <div id="content-con" style="margin-left: 130px">
<{else}>
    <div>
<{/if}>
    <div class="page-header">
        <button onclick="showAddModel()" class="btn btn-green" role="button" data-toggle="modal"><i class="icon-plus bigger-80"></i> 添加操作员</button>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <!--
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                -->
                                <th>姓名</th>
                                <th>工号</th>
                                <th>手机号</th>
                                <th>是否允许登录企商平台</th>
                                <th class="hidden-480">性别</th>
                                <{if $applet['ac_report_open']}>
                                <th>微信号</th>
                                <{/if}>
                                <{if $face}>
                                <th>门店绑定</th>
                                <{/if}>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    创建时间
                                </th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <{foreach $list as $item}>
                            <tr id="tr_id_<{$item['m_id']}>">
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  name="ids"  value="<{$val['m_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td>
                                    <a href="#"><{$item['m_nickname']}><{if $item['m_fid'] == 0}>（主管理员）<{/if}></a>
                                </td>
                                <td>
                                    <{$item['m_job_number']}>
                                </td>

                                <td><{$item['m_mobile']}></td>
                                <td><{if $item['m_login_client'] == 1 || $item['m_fid']==0}>允许<{else}>不允许<{/if}></td>
                                <td class="hidden-480"><{if $item['m_sex'] eq 'M'}>男<{else}>女<{/if}></td>
                                <{if $applet['ac_report_open']}>
                                <td>
                                    <{if $item['m_weixin_mid']}>
                                    <img src="<{$item['mavatar']}>" alt="" style="width: 50px;float: left">
                                    <div style="float: left;margin-left: 8px;">
                                        <div style="margin-top: 3px;text-align: left;"><{$item['mnickname']}><a href="javascript:;" style="margin-left: 3px;" data-id="<{$item['m_id']}>" onclick="unbindMember(this)">解绑</a></div>
                                        <div style="margin-top: 12px;">消息通知:<{if $item['m_report_open']}>已开启<{else}>已关闭<{/if}><a href="javascript:;" style="margin-left: 3px;"  data-id="<{$item['m_id']}>" data-status="<{$item['m_report_open']}>" onclick="changeReportStatus(this)">修改</a></div>
                                    </div>
                                    <{/if}>
                                </td>
                                <{/if}>

                                <{if $face}>
                                <td>
                                    <{if $item['m_bind_sid']}>
                                    <div style="float: left;margin-left: 8px;">
                                        <div style="margin-top: 3px;text-align: left;">门店:<{$storeList[$item['m_bind_sid']]}><a href="javascript:;" style="margin-left: 3px;" data-id="<{$item['m_id']}>" data-osid="<{$item['m_bind_sid']}>" onclick="delBind(this)">解绑</a></div>
                                        <!--<div style="margin-top: 12px;">已绑定<a href="/wxapp/cash/index?osId=<{$item['m_bind_sid']}>&keeperId=<{$item['m_id']}>&type=keeper" style="margin-left: 3px;" >查看</a></div>-->

                                    </div>
                                    <{else}>
                                    <div style="float: left;margin-left: 8px;">
                                        <div style="margin-top: 3px;text-align: left;">未绑定<a href="javascript:;" style="margin-left: 3px;" data-id="<{$item['m_id']}>" onclick="changeBindStore(this)">绑定</a></div>
                                    </div>
                                    <{/if}>
                                </td>

                                <{/if}>


                                <td><{$item['m_createtime']|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                                <td>
                                    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                        <{if $item['m_fid'] > 0}>
                                        <button class="btn btn-xs btn-info" onclick="showModel(this)"
                                                data-id="<{$item['m_id']}>"
                                                data-nickname="<{$item['m_nickname']}>"
                                                data-mobile="<{$item['m_mobile']}>"
                                                data-login="<{$item['m_login_client']}>"
                                                data-sex="<{$item['m_sex']}>"
                                                data-job="<{$item['m_job_number']}>"
                                                data-osid="<{$item['m_bind_sid']}>"
                                        >

                                            编辑
                                        </button>
                                        <{if $plugin != 1}>
                                        <a class="btn btn-xs btn-yellow" style="margin-left: 15px" href="/wxapp/manager/settingRole/id/<{$item['m_id']}>">
                                            设置权限
                                        </a>
                                        <{/if}>
                                        <button class="btn btn-xs btn-danger" style="margin-left: 15px"
                                                onclick="deleteManager('<{$item['m_id']}>')" data-mid="<{$item['m_id']}>">
                                            删除
                                        </button>
                                        <{/if}>
                                        <{if $item['m_report_qrcode'] && $applet['ac_report_open']}>
                                        <a class="btn btn-xs btn-green" data-qrcode="<{$item['m_report_qrcode']}>" onclick="bindMember(this)" <{if $item['m_fid'] > 0}>style="margin-left: 15px"<{/if}> href="javascript:;" >
                                            微信消息通知
                                        </a>
                                        <{/if}>
                                    </div>
                                </td>
                            </tr>
                            <{/foreach}>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">操作员管理</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hid_id" value="0">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none">手机号 : </div>
                                    <input type="text" class="form-control" id="mobile" placeholder="请输入管理员电话" style="border-radius:4px;">
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none"> 姓&emsp;&emsp;&emsp;名 : </div>
                                    <input type="text" class="form-control" id="nickname" placeholder="管理员姓名" style="border-radius:4px;">
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none"> 工&emsp;&emsp;&emsp;号 : </div>
                                    <input type="text" readonly="readonly" class="form-control" id="jobnumber" placeholder="工号" style="border-radius:4px;">
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none"> 密&emsp;&emsp;&emsp;码 : </div>
                                    <input type="password" class="form-control" id="password" placeholder="修改管理员信息时，不填写视为不修改" style="border-radius:4px;">
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none"> 门&emsp;&emsp;&emsp;店 : </div>
                                    <select class="form-control" id="checkStore">
                                        <option value="">请选择</option>
                                        <{foreach $storeList as $key=>$val}>
                                        <option value="<{$key}>"><{$val}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
                            </div>


                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="manager-sex" class="input-group-addon" style="background-color:#fff;border:none">是否允许登录企商平台：</label>
                                    <div style="width:100%;">
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-login" id="islogin" value="1"> 允许
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-login" id="nologin" value="0"> 不允许
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="manager-sex" class="input-group-addon" style="background-color:#fff;border:none">性&emsp;&emsp;&emsp;别：</label>
                                    <div style="width:100%;">
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-sex" id="sex_m" value="M"> 男
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-sex" id="sex_f" value="F"> 女
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="saveWxappManager()">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="qrcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="qrcodeModalLabel">
                    微信消息通知
                </h4>
            </div>
            <div class="modal-body">
                <div class="zent-dialog-body clearfix">
                    <div class="online-pay-content" style="display: block;">
                        <div class="pay-qrcode image-code">
                            <img src="" alt="公众号二维码" id="weixin-qrcode">
                        </div>
                        <div class="weixin-btn">
                            <p>微信扫码关注公众号</p>
                            <input class="zent-btn zent-btn-primary js-qrcode-success" onclick="hadScan(this, event)" type="submit" value="我已关注">
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>

<!--新增绑定窗口-->
<div id="add-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" style="font-size: 18px">绑定门店</h3>
            </div>
            <div class="modal-body" style="margin: 5px 15px">
                <form id="add-form">
                    <input type="hidden" id="checkId" name="checkId" value="">
                    <div class="form-group">
                        <label for="name">线下门店</label>
                        <select class="form-control" id="checkStore">
                            <option value="">请选择</option>
                            <{foreach $storeList as $key=>$val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="bindStore()" class="btn btn-blue btn-save-add" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function showAddModel() {
        $("#hid_id").val(0);
        $("#mobile").val('');
        $("#nickname").val('');
        $("#password").val('');
        $("#jobnumber").val('');
        $("#checkStore").val('');
        $('#islogin').attr("checked","checked");
        $('#modal-info-form').modal('show');
    }

    function showModel(ele) {
        $("#hid_id").val($(ele).data('id'));
        $("#mobile").val($(ele).data('mobile'));
        $("#nickname").val($(ele).data('nickname'));
        $("#jobnumber").val($(ele).data('job'));
        $("#checkStore").val($(ele).data('osid'));
        $("#password").val('');
        if($(ele).data('login')==1){
            $('#islogin').attr("checked","checked");
        }else{
            $('#nologin').attr("checked","checked");
        }
        if($(ele).data('sex')=='M'){
            $('#sex_m').attr("checked","checked");
        }else{
            $('#sex_f').attr("checked","checked");
        }
        $('#modal-info-form').modal('show');
    }
    function saveWxappManager() {
        var hid_id   = $("#hid_id").val();
        var mobile   = $("#mobile").val();
        var nickname = $("#nickname").val();
        var password = $("#password").val();
        var number   = $("#jobnumber").val();//工号
        var sex      = $('input[name="manager-sex"]:checked').val();
        var login    = $('input[name="manager-login"]:checked').val();
        var osId     = $('#checkStore').val();
        var pattern  = /^1[23456789]\d{9}$/;
        if (!pattern.test(mobile)) {
            layer.msg('请输入有效的手机号');
            return false;
        }
        var data = {
            'id'        : hid_id,
            'mobile'    : mobile,
            'nickname'  : nickname,
            'password'  : password,
            'login'     : login,
            'number'    : number,
            'sex'       : sex,
            'osId'      : osId
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/manager/saveManager',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200 ){
                    window.location.reload();
                }
            }
        });
    };

    function deleteManager(mid) {
        if(mid){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/manager/deleteManager',
                'data'  : { mid:mid},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        window.location.reload();
                    }
                }
            });
        }
    }

    function bindMember(ele) {
        let qrcode = $(ele).data('qrcode');
        $('#weixin-qrcode').attr('src', qrcode);
        $('#qrcodeModal').modal('show');
    }

    function hadScan(obj, event) {
        event.preventDefault();
        location.reload();
    }

    function unbindMember(ele) {
        let id = $(ele).data('id');
        layer.confirm('解除绑定后，将无法接收消息通知？', {
            btn: ['确定','取消'], //按钮
            title : '解绑'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/manager/unbindMember',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    function changeReportStatus(ele) {
        let id = $(ele).data('id');
        let status = $(ele).data('status');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/manager/changeReportStatus',
            'data'  : { id:id, status: status},
            'dataType' : 'json',
            success : function(ret){
                layer.msg(ret.em,{
                    time: 2000, //2s后自动关闭
                },function(){
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                });
            }
        });
    }

    //处理门店的绑定和解绑

    function changeBindStore(ele){
        let id = $(ele).data('id');
        $('#checkId').val(id);
        $('#add-modal').modal('show');
    }

    function bindStore() {
        let id    = $('#checkId').val();
        let store = $('#checkStore').val();
        if(id && store){
            layer.confirm('您确认要绑定该门店吗?',function () {
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/manager/bindStore',
                    'data'  : { id:id, store: store},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.msg(ret.em,{
                            time: 2000 //2s后自动关闭
                        },function(){
                            if(ret.ec == 200){
                                window.location.reload();
                            }
                        });
                    }
                });
            },function () {

            });
        }else{
            layer.msg('请选择想要绑定的门店');
        }
    }
    //解除绑定
    function delBind(ele){
        let osid = $(ele).data('osid');
        let mid  = $(ele).data('id');
        if(osid && mid){
            layer.confirm('您确定要解除该门店的绑定吗?解除绑定后将自动清除所有该门店绑定的机器!',function () {
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/manager/delBind',
                    'data'  : { mid:mid, osid: osid},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.msg(ret.em,{
                            time: 2000 //2s后自动关闭
                        },function(){
                            if(ret.ec == 200){
                                window.location.reload();
                            }
                        });
                    }
                });
            },function () {

            });
        }else{
            layer.msg('暂时无法解绑哦');
        }
    }






</script>

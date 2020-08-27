<style type="text/css">
    table tr th,table tr td{
        text-align: center;
    }
    #modal-info-form .input-group{
        width: 100%;
    }
    #modal-info-form .input-group .input-group-addon-title{
        width: 125px;
        text-align: right;
    }
</style>
<div>
    <!--
	<div class="alert alert-block alert-yellow" style="margin-bottom:20px;">
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
		<!--<i class="icon-exclamation-sign"></i>
		[公告] (版本号 <{$sys_notice[0]['sn_version']}>) <{$sys_notice[0]['sn_title']}>
		<a target="_blank" href="/wxapp/index/noticeList">历史更新</a>-->
        <!--
		<div class="update-content">
			
		</div>

	</div>
	-->
    <div class="row">
        <div class="col-sm-9" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-money bigger-110"></i>
                            充值金额
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/member/record">
                            <i class="green icon-th-large bigger-110"></i>
                            充值记录
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/member/cfg">
                            <i class="green icon-cog bigger-110"></i>
                            充值配置
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="page-header">
                            <button  class="btn btn-green btn-modal" data-type="edit" role="button"><i class="icon-plus bigger-80"></i> 添加</button>
                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>充值金额</th>
                                    <th>得到金额</th>
                                    <th>限购次数</th>
                                    <th>会员身份</th>
                                    <!--
                                    <{foreach $thLevel as $key=>$val}>
                                    <th><{$val}></th>
                                    <{/foreach}>
                                    -->
                                    <th>权重排序</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        最近修改
                                    </th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $item}>
                                    <tr id="tr_id_<{$item['rv_id']}>">
                                        <td><{$item['rv_money']}></td>
                                        <td><{$item['rv_coin']}></td>
                                        <td><{$item['rv_limit']}></td>
                                        <td><{$levelList[$item['rv_identity']]}></td>
                                        <!--
                                        <{foreach $fieldLevel as $key=>$val}>
                                        <th><{$item[$val]}></th>
                                        <{/foreach}>
                                        -->
                                        <td><{$item['rv_weight']}></td>
                                        <td><{date('Y-m-d H:i:s',$item['rv_create_time'])}></td>
                                        <td>
                                            <a href="javascript:;" class="btn-modal"
                                               data-type="edit"
                                               data-id="<{$item['rv_id']}>"
                                               data-money="<{$item['rv_money']}>"
                                               data-coin="<{$item['rv_coin']}>"
                                               data-limit="<{$item['rv_limit']}>"
                                               data-identity="<{$item['rv_identity']}>"
                                               data-coin1="<{$item['rv_1f_coin']}>"
                                               data-coin2="<{$item['rv_2f_coin']}>"
                                               data-coin3="<{$item['rv_3f_coin']}>"
                                               data-weight="<{$item['rv_weight']}>">
                                                编辑
                                            </a>
                                            -
                                            <a href="javascript:;" class="btn-del" data-id="<{$item['rv_id']}>">
                                                删除
                                            </a>
                                        </td>
                                    </tr>
                                    <{/foreach}>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加/编辑会员登录</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="hid_id" value="0">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">充值金额</div>
                                <input type="number" class="form-control" id="money" placeholder="请输入整数金额" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">获得金额</div>
                                <input type="number" class="form-control" id="coin" placeholder="请输入充值获得金额" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">限购次数</div>
                                <input type="number" class="form-control" id="limit" placeholder="限购次数,0表示不限购" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                            <span style="color: red;margin-left: 125px;">限购次数,0表示不限购</span>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">会员身份</div>
                                <select name="identity" id="identity" class="form-control">
                                    <option value="0">无</option>
                                    <{foreach $levelList as $key => $val}>
                                    <option value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                            <span style="color: red;margin-left: 125px">可选, 充值对应金额, 获取的会员身份, 自定义金额无效</span>
                        </div>
                        <!--
                        <div class="space-4"></div>
                        <{$levelHtml}>
                        -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">权重排序</div>
                                <input type="number" class="form-control" id="weight" placeholder="1-100之间的整数(数字越大排序越靠前)" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-btn">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $('.btn-modal').on('click',function(){
        var type = $(this).data('type');
        var id= 0,coin='',limit=0,identity=0,coin_1='',coin_2='',coin_3='',money='',weight='';

        if(type == 'edit'){
            id      = $(this).data('id');
            coin    = $(this).data('coin');
            limit   = $(this).data('limit');
            identity = $(this).data('identity');

            coin_1  = $(this).data('coin1');
            coin_2  = $(this).data('coin2');
            coin_3  = $(this).data('coin3');
            money   = $(this).data('money');
            weight  = $(this).data('weight');
        }
        $('#hid_id').val(id);
        $('#coin').val(coin);
        $('#limit').val(limit);
        $('#identity').val(identity);
        $('#money').val(money);
        $('#weight').val(weight);
        $('#level_1').val(coin_1);
        $('#level_2').val(coin_2);
        $('#level_3').val(coin_3);

        $('#modal-info-form').modal('show');
    });
    $('.save-btn').on('click',function(){
        var data = {
            'id'    : $('#hid_id').val(),
            'coin'  : $('#coin').val(),
            'limit' : $('#limit').val(),
            'identity': $('#identity').val(),
            'coin_1': $('#level_1').val(),
            'coin_2': $('#level_2').val(),
            'coin_3': $('#level_3').val(),
            'money' : $('#money').val(),
            'weight': $('#weight').val()
        };
        if(data.coin > 0 && data.money > 0){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/saveValue',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }else{
            layer.msg('请填写整数');
        }
    });
    $('.btn-del').on('click',function(){
        var id = $(this).data('id');
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                'id'    : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/delValue',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#tr_id_'+id).remove();
                    }
                }
            });
        });
    });
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .el-col{
        margin: 30px 10px 20px;
        border: 1px solid rgb(209, 219, 229);
        padding: 25px;
        border-radius: 4px;
        height: 190px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
    }

    .el-button{
        font-size: 12px;
        width: 60px;
        color: #fff;
        border-radius: 4px;
        background-color: #010406;
        border-color: #010406;
    }
    .source{
        margin-bottom: 30px;
    }

    .source, .category-list{
        padding: 10px 30px;
        border: 1px solid rgb(209, 219, 229);
        border-radius: 4px;
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.12), 0 0 6px 0 rgba(0,0,0,.04);
    }

    .article-circle-img {
        width: 50px;
        height: 50px;
        border-radius: 25px;
        background-color: #eee;
        margin-left: 0;
    }
    .gzh-middle-content {
        display: flex;
        flex-direction: column;
    }
    .introduce-article-content, .introduce-content {
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .article-add-img {
        width: 20px;
        height: 20px;
        margin-left: 20px;
        cursor: pointer;
    }

    #search-content{
        font-size: 12px;
    }

    #search-content .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }

    .middle-div {
        border-bottom: 1px solid #e5e5e5;
        width: 590px!important;
    }

    #search-content td {
        min-width: 66px;
        font-size: 12px;
        line-height: 20px!important;
        vertical-align: middle!important;
        padding-top: 11px!important;
        padding-bottom: 11px!important;
        border-color: #e5e5e5!important;
    }

    .introduce-content {
        width: 400px;
    }

    .clearfix:before, .clearfix:after {
        display: block;
        visibility: hidden;
        height: 0;
        content: "";
        clear: both;
    }
    .zent-dialog-body .image-code {
        height: 200px;
    }
    h4{font-size:16px;}
    .table thead tr th{
		color:#000;
		font-size:13px;
		border-right:0;
	}
</style>
<{include file="../common-second-menu-new.tpl"}>
<div  id="mainContent">
	<div class="alert alert-block alert-yellow">
	    说明： 公众号关联成功后，会不定时同步前一天公众号文章。
	</div>
	<div id="content-con">
	    <div >
	        <div class="source">
	            <div class="source-header">
	                <h4>内容来源</h4>
	                <div align="center" style="margin-top: -29px;margin-left:80px; float: left;">
	                    <button type="button" class="button el-button--primary el-button--mini" onclick="confirmCharge(this)" style="font-size: 12px; width: 60px;background: #1AAD19;border-color: #1AAD19;color: #FFFFFF;border-radius: 3px;">
	                        <span>新增</span>
	                    </button>
	                </div>
	            </div>
	            <div class="source-content clearfix" style="padding: 0 30px;">
	                <{if !$gzhList }>
	                <div class="el-col col-sm-3" align="center" style="width: 23%;">
	                    <div class="el-card category-card">
	                        <div class="el-card__body">
	                            <div align="center" style="margin-top: 35px;">
	                                <button type="button" class="el-button button el-button--primary el-button--mini" data-toggle="modal" data-target="#myModal" style="font-size: 12px; width: 60px;">
	                                    <span>添加</span>
	                                </button>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <{/if}>
	                <{foreach $gzhList as $val}>
	                <div class="el-col col-sm-3" align="center" style="width: 23%;">
	                    <div class="el-card category-card">
	                        <div class="el-card__body">
	                            <div align="center">
	                                <img src="<{$val['abg_cover']}>" style="width: 45px;margin-bottom: 10px;" class="category-card-img">
	                            </div>
	                            <div align="center">
	                                <div style="height: 35px;">
	                                    <p style="font-size: 14px; line-height: 1.2;">
                                            <{$val['abg_name']}>
                                            <a href="javascript:;" data-toggle="modal" data-wxnoid="<{$val['abg_id']}>" data-showtype="<{$val['abg_show_type']}>" onclick="settingGzh(this)" data-target="#settingModal">设置</a>
                                        </p>
	                                </div>
	                                <button type="button" class="el-button button el-button--primary el-button--mini" onclick="getArticle(<{$val['abg_id']}>)" style="font-size: 12px; width: 80px;margin-bottom: 10px">
	                                    <span>同步文章</span>
	                                </button>
	                                <button type="button" class="el-button button el-button--primary el-button--mini" onclick="removeGzh(<{$val['abg_id']}>)" style="font-size: 12px; width: 70px;">
	                                    <span>移除</span>
	                                </button>
	                                <div style="margin-top: 15px">
	                                    已获取文章数量<{$val['informationCount']}>篇
	                                    <a href="/wxapp/currency/informationList/wxno/<{$val['abg_wxno']}>">查看</a>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <{/foreach}>
	                <{for $i=0; $i<$curr_shop['s_gzh_num']; $i++}>
	                <div class="el-col col-sm-3" align="center" style="width: 23%;">
	                    <div class="el-card category-card">
	                        <div class="el-card__body">
	                            <div align="center" style="margin-top: 35px;">
	                                <button type="button" class="el-button button el-button--primary el-button--mini" data-toggle="modal" data-target="#myModal" style="font-size: 12px; width: 60px;">
	                                    <span>添加</span>
	                                </button>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <{/for}>
	            </div>
	        </div>
	        <div class="category-list" style="height: auto">
	            <div class="source-header">
	                <h4>分类设置</h4>
	            </div>
	            <div class="source-content" style="margin-top: 30px">
	                <div class="row">
	                    <div class="col-xs-12">
	                        <div class="table-responsive">
	                            <table id="sample-table-1" class="table table-hover table-avatar">
	                                <thead>
	                                <tr>
	                                    <th>分类名称</th>
	                                    <th>绑定公众号</th>
	                                    <th>操作</th>
	                                </tr>
	                                </thead>
	                                <tbody>
	                                <{foreach $categoryList as $val}>
	                                    <tr>
	                                        <td><{$val['aic_name']}></td>
	                                        <td><{$val['abg_name']}></td>
	                                        <td>
	                                            <a href="javascriot:;" data-toggle="modal" onclick="bindSource(<{$val['aic_id']}>)" data-target="#sourceModal">修改</a> -
	                                            <a href="javascriot:;" onclick="delBindSource(<{$val['abg_id']}>)" style="color:#f00;">解除</a>
	                                        </td>
	                                    </tr>
	                                    <{/foreach}>
	                                <tr><td colspan="8"><{$paginator}></td></tr>
	                                </tbody>
	                            </table>
	                        </div><!-- /.table-responsive -->
	                    </div><!-- /span -->
	                </div><!-- /row -->
	            </div>
	        </div>
	    </div>
	</div>
</div>

<div class="modal fade" id="gzhModal" tabindex="-1" role="dialog" aria-labelledby="gzhModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 620px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    文章来源
                </h4>
            </div>
            <div class="modal-body">
                <{for $i=0; $i<4; $i++}>
                <div class="el-col col-sm-3" align="center" style="width: 21%;">
                    <div class="el-card category-card">
                        <div class="el-card__body">
                            <{if $gzhList[$i]}>
                            <div align="center">
                                <img src="<{$gzhList[$i]['abg_cover']}>" style="width: 45px;margin-bottom: 10px;" class="category-card-img">
                            </div>
                            <div align="center">
                                <div style="height: 35px;">
                                    <p style="font-size: 14px; line-height: 1.2;"><{$gzhList[$i]['abg_name']}></p>
                                </div>
                                <button type="button" class="el-button button el-button--primary el-button--mini" onclick="removeGzh(<{$gzhList[$i]['abg_id']}>)" style="font-size: 12px; width: 60px;">
                                    <span>移除</span>
                                </button>
                            </div>
                            <{else}>
                            <div align="center" style="margin-top: 35px;">
                                <button type="button" class="el-button button el-button--primary el-button--mini" data-toggle="modal" data-target="#myModal" style="font-size: 12px; width: 60px;">
                                    <span>添加</span>
                                </button>
                            </div>
                            <{/if}>
                        </div>
                    </div>
                </div>
                <{/for}>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 620px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加文章来源
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <select id="search-type"  class="form-control">
                            <option value="1" >公众号</option>
                            <option value="2" >公众号文章链接</option>
                        </select>
                    </div>
                    <div class="col-sm-7">
                        <input id="search-key" class="form-control" placeholder="请填写公众号名称" style="height:auto!important"/>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-primary" onclick="searchWeixin()">搜索</button>
                    </div>
                </div>
                <div id="search-content" style="height: 400px;overflow-y: auto;overflow-x: hidden;">
                    <div style="display: block;">
                        <p>注意事项：</p>
                        <p class="tips">1.如果输入公众号名未搜到，可输入公众号文章链接</p>
                        <p class="tips">2.文章数据同步可能出现延迟, 若当天未同步, 则会在次日重新获取</p>
                        <p class="tips">3.如果添加未授权的内容来源，可能存在版权风险</p>
                    </div>
                </div>
            </div>
            <div id="search-pager" style="text-align: center;">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div id="layer-charge" style="display:none">
    <div class="zent-dialog-body clearfix">
        <div class="pay-info">
            <dl>
                <dt>名称：</dt>
                <dd>新增绑定公众号</dd>
            </dl>
            <dl>
                <dt>金额：</dt>
                <dd>
                    <span class="money">￥50.00</span>
                </dd>
            </dl>
        </div>
        <div class="ui-nav clearfix">
            <ul class="pull-left">
                <li class="pay-way-nav js-online-pay active">
                    <a href="javascript:;">微信扫码充值</a>
                </li>
                <li class="pay-way-nav js-offline-pay">
                    <a href="javascript:;">支付宝扫码充值</a>
                </li>
            </ul>
        </div>
        <div class="online-pay-content" style="display: block;">
            <div class="pay-qrcode image-code">
                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="loading js-img-src">
            </div>
            <div class="weixin-btn">
                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
            </div>
        </div>
        <div class="online-pay-content" style="display: none;">
            <div class="pay-qrcode image-code">
                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="loading js-img-src">
            </div>
            <div class="weixin-btn">
                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sourceModal" tabindex="-1" role="dialog" aria-labelledby="sourceModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 620px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    绑定文章来源
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="category-id" value="">
                <span style="display: inline-block;margin-top: 7px">内容源</span>
                <select name="article-source" id="article-source" class="form-control" style="width: 90%;float: right">
                    <{foreach $gzhList as $val}>
                    <option value="<{$val['abg_id']}>"><{$val['abg_name']}></option>
                    <{/foreach}>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-bind">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 620px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="settingModalLabel">
                    公众号设置
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="wxno-id" value="">
                <div class="form-inline row " style="text-align: center">
                    <label for="inputEmail3" class="control-label" style="margin-right: 20px;">获取的文章是否以公众号原文样式展示</label>
                    <label class="form-group" id="choose-yesno">
                        <input class='tgl tgl-light' id='article-show-type' type='checkbox'>
                        <label class='tgl-btn' for='article-show-type'></label>
                    </label>
                    <p style="color: red;text-align: center;margin-top: 10px;">注：此设置仅针对已绑定小程序的公众号有效</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-setting">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>

<script>
    var amount = 50 * 100;
    function bindSource(id) {
        $('#category-id').val(id);
    }

    /*确认充值*/
    function confirmCharge(elem){
        var html = $("#layer-charge");
        layer.confirm('注：新增公众号绑定后不可移除更换！！！', {
            btn: ['确定','取消'], //按钮
            title : '新增绑定公众号'
        }, function(){
            //页面层
            layer.open({
                type: 1,
                title: '新增绑定公众号',
                area: ['640px','550px'], //宽高
                content: html
            });
            qrcode(0);
        })
    }

    //获取扫码
    function qrcode(index) {
        console.log(index);
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/shop/wxAlipayChargeQrcode/amount/'+amount+'/channel/'+type[index];
        console.log(url);
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');
        if (typeof img.data('amount') == 'undefined' || amount != parseInt(img.data('amount'))) {
            img.attr('src', url);
            img.data('amount', amount);
        }
    }

    /*弹出层tab栏切换*/
    $(".pay-way-nav").click(function(event) {
        $(this).addClass('active').siblings().removeClass('active');
        var index = $(this).index();
        $(".online-pay-content").eq(index).stop().show();
        $(".online-pay-content").eq(index).siblings('.online-pay-content').stop().hide();
        qrcode(index);
    });

    function hadPay(obj, event) {
        event.preventDefault();
        var curr_url    = location.href;
        var new_url     = "";
        for (var i=0; i<curr_url.length; i++) {
            var curr_char   = curr_url.charAt(i);
            if (curr_char == '#') {
                break;
            }
            new_url += curr_char;
        }
        window.location.replace(new_url);
    }

    function delBindSource(id) {
        	layer.confirm('确定要解除绑定吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	        	if(id){
		            var loading = layer.load(2);
		            $.ajax({
		                'type'  : 'post',
		                'url'   : '/wxapp/currency/delBindCategory',
		                'data'  : {id: id},
		                'dataType' : 'json',
		                success : function(ret){
		                    layer.close(loading);
		                    layer.msg(ret.em);
		                    if(ret.ec == 200){
		                        window.location.reload();
		                    }
		                }
		            });
		        }
	        });
    }

    $('#confirm-bind').on('click',function(){
        var cid = $('#category-id').val();
        var sourceId = $('#article-source').val();
        var data = {
            cid : cid,
            sourceId : sourceId
        };
        if(cid && sourceId){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/bindCategory',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('请选择内容源');
        }
    });

    function searchWeixin(page=1) {
        var type = $('#search-type').val();
        var key = $('#search-key').val();
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });

        var data = {
            'type'  : type,
            'key' : key,
            'page': page
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/information/search',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                var html = '';
                html += '<table class="table table-hover article-self-table"><tbody class="list-content">';
                var data = ret.data;
                for(var key in data){
                    html +='<tr><td class="padding-tr" style="width:50px;min-width:50px">' +
                        '<img class="article-circle-img" src="'+data[key]['round_head_img']+'"></td><td class="middle-div">' +
                        '<div class="gzh-middle-content"><span>'+data[key]['nickname']+'</span>' +
                        '</div></td>' +
                        '<td class="add-img-div">' +
                        '<img class="article-add-img" onclick="addWxapp(this)" data-cover="'+data[key]['round_head_img']+'" data-url="'+(data[key]['url']?data[key]['url']:'')+'" data-name="'+data[key]['nickname']+'"  data-wxno="'+data[key]['fakeid']+'" src="/public/wxapp/images/article_add.png">' +
                        '</td></tr>';
                }
                html += '</tbody></table>';
                $('#search-content').html(html);
                /*layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }*/
            }
        });
    }

    function removeGzh(id) {
        layer.confirm('确定删除文章源？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/information/removeGzh',
                'data'  : {id: id},
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }, function(){

        });
    }

    function getArticle(id) {
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/information/syncArticles',
            'data'  : {id: id},
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                layer.msg(ret.data.msg+', 获取文章'+ret.data.num+'篇');
            }
        });
    }

    function addWxapp(elem) {
        var data = {
            'url' : $(elem).data('url'),
            'wxno': $(elem).data('wxno'),
            'name' : $(elem).data('name'),
            'cover': $(elem).data('cover'),
        }
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/information/addWxapp',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    };

    function settingGzh(elem) {
        let wxnoid = $(elem).data('wxnoid');
        let showType = $(elem).data('showtype');

        $('#wxno-id').val(wxnoid);
        $('#article-show-type').prop("checked", showType?true:false);

    }

    $('#confirm-setting').on('click', function () {
        var wxnoid = $('#wxno-id').val();
        var showType = $('#article-show-type').is(':checked');
        var data = {
            wxnoid : wxnoid,
            showType : showType ? 1 : 0
        };

        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/information/gzhSetting',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    })

</script>
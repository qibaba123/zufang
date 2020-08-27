<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <!--
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加团长</a>
            -->
            <a class="btn btn-green btn-xs" href="/wxapp/sequence/activityEdit" ><i class="icon-plus bigger-80"></i>添加活动</a>
            <div class="introduce-tips" style="display:inline-block;min-width:400px;margin-left:20px;">
	        	<div class="tips-btn">
	        		<span>介绍</span><img src="/public/site/img/tips.png" alt="图标" />
	        	</div>
	        	<div class="tips-con-wrap">
	        		<div class="tips-con">
		        		<div class="triangle_border_up"><span></span></div>
		        		<div class="con">功能使用说明：该功能相当于“商品分组”功能，可以把一些热卖、新品的商品组合在一个活动里。添加后，可以在①后台页面管理->主页管理->自定义首页->拖拽“活动列表”组件；②后台页面管理->主页管理->选择“社区团购”固定模板展示。</div>
		        	</div>
	        	</div>
	        </div>	
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/activityList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">标题</div>
                                    <input type="text" class="form-control" name="title" value="<{$title}>"  placeholder="标题">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>活动标题</th>
                            <{if $appletCfg['ac_base'] < 28}>
                            <th>活动时间</th>
                            <th>提货时间</th>
                            <{/if}>
                            <th>活动状态</th>
                            <th>供应商信息</th>
                            <th>活动电话</th>
                            <{if $appletCfg['ac_base'] < 28}>
                            <th>小区限制</th>
                            <{/if}>
                            <th>最近更新</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asa_id']}>">

                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['asa_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td>
                                    <{$val['asa_title']}>
                                </td>
                                <{if $appletCfg['ac_base'] < 28}>
                                <td>
                                    开始：<{date('Y-m-d H:i',$val['asa_start'])}><br>
                                    结束：<{date('Y-m-d H:i',$val['asa_end'])}>
                                </td>
                                <td>
                                    开始：<{date('Y-m-d H:i',$val['asa_receive_start'])}><br>
                                    结束：<{date('Y-m-d H:i',$val['asa_receive_end'])}>
                                </td>
                                <{/if}>
                                <td>
                                    <{if $val['asa_is_on'] == 2}>
                                    <span style="color:#999;">已下线</span>
                                    <{else}>
                                    <span style="color:green;">正常</span>
                                    <{/if}>
                                </td>
                                <td style="text-align: left">
                                    <img src="<{if $val['asa_avatar']}><{$val['asa_avatar']}><{else}>'/public/wxapp/images/applet-avatar.png'<{/if}>" alt="" style="width: 40px;margin-left: 0;display: inline-block">
                                    <span><{$val['asa_nickname']}></span>
                                </td>
                                <td>
                                    <{$val['asa_mobile']}>
                                </td>
                                <{if $appletCfg['ac_base'] < 28}>
                                <td>
                                    <{if $val['asa_limit_com'] == 1}>
                                    <span style="color: red">限制小区购买</span>
                                    <a href="#" class="btn btn-xs btn-primary change-limit" data-id="<{$val['asa_id']}>" data-status="0">解除</a>
                                    <{else}>
                                    <span style="">无限制</span>
                                    <a href="#" class="btn btn-xs btn-danger change-limit" data-id="<{$val['asa_id']}>" data-status="1">限制小区</a>
                                    <{/if}>
                                </td>
                                <{/if}>
                                <td>
                                    <{date('Y-m-d H:i',$val['asa_update_time'])}>
                                </td>
                                <td class="jg-line-color">                                  
                                    <p>
                                        <a href="/wxapp/sequence/activityGoodsList?id=<{$val['asa_id']}>" >查看活动商品</a>
                                        - <a href="/wxapp/sequence/activityGoodsEdit?id=<{$val['asa_id']}>" >编辑活动商品</a>
                                    </p>
                                    <{if $val['asa_limit_com'] && $appletCfg['ac_base'] < 28}>
                                    <p>
                                        <a href="/wxapp/sequence/activityCommunityEdit?id=<{$val['asa_id']}>" >编辑活动小区</a>
                                    </p>
                                    <{/if}>
                                    <p>
                                      <a href="/wxapp/sequence/activityEdit?id=<{$val['asa_id']}>">编辑</a>
                                        - <a href="javascript:;" onclick="confirmDelete(this)" style="color: red" data-id="<{$val['asa_id']}>">删除</a>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>

                        <!--<tr>
                            <td colspan="2">
                                <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下线</span>
                                <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上线</span>
                            </td>
                            <td colspan="5" class='text-right'></td></tr>-->

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">
            <div class="bottom-opera-item" style="padding: 13px 0;<{if $showPage == 0 }>text-align: center;<{/if}>">
                <a href="#" class="btn btn-blue btn-xs js-recharge-btn btn-shelf" data-type="up">上线</a>
                <a href="#" class="btn btn-blueoutline btn-xs btn-shelf" data-type="down">下线</a>
            </div>
            <div class="bottom-opera-item" style="text-align: right">
                <div class="page-part-wrap"><{$pagination}></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content" style="overflow: visible">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加团长
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">

                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">微信昵称：</label>
                    <div class="col-sm-8">
                        <{include file="../layer/ajax-select-input-single.tpl"}>
                        <input type="hidden" id="hid_acsId" value="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="comfirm-area">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#asa_name').val($(this).data('name'));
        $('#asa_poster_name').val($(this).data('postername'));
        $('#asa_poster_mobile').val($(this).data('postermobile'));

    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#asa_name').val('');
        $('#asa_poster_name').val('');
        $('#asa_poster_mobile').val('');
    });

    $('#comfirm-area').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#asa_name').val();
        var posterName = $('#asa_poster_name').val();
        var posterMobile  = $('#asa_poster_mobile').val();
        var data = {
            id     : id,
            name   : name,
            posterMobile : posterMobile,
            posterName  : posterName,
        };
        
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/areaSave',
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
        }
    });

    $('.btn-shelf').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(!ids){
            layer.msg('请选择活动');
            return;
        }
        if(ids && type){
            var data = {
                'ids' : ids,
                'type' : type
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });

            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/activityShelf',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }

    });

    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/deleteActivity',
                    'data'  : { id:id},
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

    $('.change-limit').on('click',function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var data = {
            id : id,
            status : status
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/changeActivityLimit',
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
    });

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#category-cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }
</script>
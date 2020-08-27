<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<style>
    .dropdown-menu{
        z-index: 1200 !important;
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
        width: 33.33%;
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
    select.form-control{
		-webkit-appearance: none;
	}
</style>
<{if $verify_list == 1}>
    <{include file="../common-second-menu.tpl"}>
<div id="content-con">
    <{else}>
    <div id="content-con">
<{/if}>

    <div  id="mainContent" >
        <!-- 汇总信息 -->
        <{if $verify_list != 1}>
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">社区总数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已关联团长社区<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['leader']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">未关联团长社区<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['noleader']}></span>
                </div>
            </div>
        </div>

        <div class="page-header">
            <a href="/wxapp/sequence/communityEdit" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i>添加社区</a>

            <a href="javascript:;" class="btn btn-sm btn-green btn-excel"><i class="icon-download"></i>导出商品销售统计</a>

        </div><!-- /.page-header -->
        <{/if}>
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="<{if $verify_list == 1}>/wxapp/seqregion/communityVerify<{else}>/wxapp/sequence/communityList<{/if}>" >
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">社区名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="社区名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">所属街道</div>
                                    <select name="area" id="" class="form-control">
                                        <option value="0">全部</option>
                                        <{foreach $areaSelect as $key => $val}>
                                    <option value="<{$key}>" <{if $key eq $area}>selected<{/if}>><{$val['name']}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">团长姓名</div>
                                    <input type="text" class="form-control" name="leader" value="<{$leader}>"  placeholder="团长姓名">
                                </div>
                            </div>
                            <{if $seqregion == 1 || $verify_list == 1}>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">审核状态</div>
                                    <select name="verify_status" id="verify_status" class="form-control">
                                        <option value="1" <{if $verify_status == 1}> selected <{/if}>>待审核</option>
                                        <option value="2" <{if $verify_status == 2}> selected <{/if}>>审核通过</option>
                                        <option value="3" <{if $verify_status == 3}> selected <{/if}>>审核拒绝</option>
                                    </select>
                                </div>
                            </div>
                            <{/if}>
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
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border:none">
                        <thead>
                        <tr>
                            <{if $verify_status != 1}>
                            <th class="center" style='width: 50px;min-width: 50px;'>
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <{/if}>

                            <th>社区/店铺名称</th>
                            <th>团长信息</th>
                            <th>街道</th>
                            <th>社区地址</th>
                            <th>更新时间</th>
                            <{if $verify_list == 1}>
                            <th>审核状态</th>
                            <{else}>
                            <th>团长设置</th>
                            <{/if}>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asc_id']}>">

                                <td class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace aceitem" name="ids" value="<{$val['asc_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>

                                <td>
                                    <p style="color:#333;">
                                        <{$val['asc_name']}> &nbsp;/&nbsp;<{$val['asc_shop_name']}>
                                    </p>
                                </td>
                                <td>
                                    <p style="color:#333;">
                                        团长姓名：<span style='color:#999;'><{$val['asl_name']}></span>
                                        </p>
                                        <p style="color:#333;">
                                            团长昵称：<span style='color:#999;'><{$val['m_nickname']}></span>
                                        </p>
                                        <p style="color:#333;">
                                            团长电话：<span style='color:#999;'><{$val['asl_mobile']}></span>
                                    </p>
                                    <p> 
                                        团长统计：
                                        <a style='color:#4CAF50;' href="/wxapp/sequence/communityLeaderGoodsSum?id=<{$val['asc_id']}>&leader=<{$val['asl_id']}>" class="remove-leader" >商品销售统计</a>
                                    </p>                                
                                </td>
                                <td  width='200px;'><{$areaSelect[$val['asc_area']]['name']}></td>
                                <td>
                                    <p>
                                        <{$val['asc_address_detail']}>
                                    </p>
                                    <p>
                                        <{$val['asc_post_address']}>
                                    </p>
                                </td>
                                <td width='200px;'><{date('Y/m/d H:i:s', $val['asc_update_time'])}></td>
                                <{if $val['asc_status'] == 2}>
                                <td>
                                    <p>
                                        <{if $val['asl_id'] > 0}>
                                             <a href="#" class="remove-leader" data-id="<{$val['asc_id']}>" data-leaderid="<{$val['asl_id']}>" onclick="removeLeader(this)" style="color: red">解除团长</a>
                                        <{else}>
                                            <a  href="#" class="get-members" data-mk="leader" data-id="<{$val['asc_id']}>">设置团长</a>
                                        <{/if}>
                                    </p>
                                </td>
                                <{else}>
                                <td style="white-space: inherit;max-width: 400px">
                                    <{if $val['asc_status'] == 1}>
                                    <span>待审核</span>
                                    <{elseif $val['asc_status'] == 3}>
                                    <span style="color:red">审核未通过</span>
                                    <{if $val['asc_handle_remark']}>
                                    <br><span>原因：<{$val['asc_handle_remark']}></span>
                                    <{/if}>
                                    <{/if}>
                                </td>

                                <{/if}>
                                <td class="jg-line-color" >
                                    <{if $verify_list == 1}>
                                    <p>
                                        <{if $val['asc_status'] == 1}>
                                        <button class="btn btn-xs btn-primary confirm-handle" data-toggle="modal" data-target="#handleModal" data-id="<{$val['asc_id']}>">审核</button>
                                        <{/if}>
                                    </p>
									<{else}>
									<p>
										<a href="/wxapp/sequence/communityEdit?id=<{$val['asc_id']}>" >编辑</a>
                                     	- <a href="#" data-id="<{$val['asc_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>

									</p>

                                    <!--
                                    <a href="#" data-id="<{$val['asc_id']}>" class="previewCon" data-type="1">提货单</a>
                                    <a href="#" data-id="<{$val['asc_id']}>" class="previewCon" data-type="2">交货单</a>
                                    <a href="#" class="" data-toggle="modal" data-target="#printModal">分拣配货单</a>
                                    -->

                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>

                            <!--<tr><td colspan="8" class="text-right"></td></tr>-->

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<{if $showPage != 0 }>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><{$pagination}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="printModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="printModalLabel">
                    打印
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px;height: 220px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form>
                        <input type="hidden" value="3" id="print_type">
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="print_start_date" data-date-format="yyyy-mm-dd" name="print_start_date" placeholder="请输入开始日期" autocomplete="off" />
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" name="timepicker_print_start" id="timepicker_print_start" placeholder="请输入开始时间" autocomplete="off" value="00:00:00" />
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="print_end_date" data-date-format="yyyy-mm-dd" name="print_end_date" placeholder="请输入结束日期" autocomplete="off"  />
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker_print_end" name="timepicker_print_end" placeholder="请输入结束时间" autocomplete="off" value="23:59:59" />
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 70px;"></div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="button" class="btn btn-primary previewConGoods" >打印</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px;height: 220px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/sequence/comLeaderGoodsExcel" method="post"  id="form-action">
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" autocomplete="off" name="startDate" placeholder="请输入开始日期" autocomplete="off" />
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker1" name="startTime" placeholder="请输入开始时间" autocomplete="off" value="00:00:00" />
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd"  autocomplete="off" name="endDate" placeholder="请输入结束日期" autocomplete="off" />
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间" autocomplete="off" value="23:59:59" />
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 70px;"></div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="handleModal" tabindex="-1" role="dialog" aria-labelledby="handleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 535px;">
            <div class="modal-content">
                <input type="hidden" id="hid_handle_id" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="handleModalLabel">
                        申请处理
                    </h4>
                </div>
                <div class="modal-body" style="padding: 10px 15px !important;">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                        <div class="col-sm-10">
                            <select name="handle_status" id="handle_status" class="form-control">
                                <option value="2">通过</option>
                                <option value="3">拒绝</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                        <div class="col-sm-10">
                            <textarea id="handle_remark" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="confirm-handle">
                        确认
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<{include file="../fetch-leader-modal.tpl"}>
<script>
    $(function () {
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        setDefaultCheckbox();

        // 动态改变url中的选中小区id参数
        $('.aceitem').click(function(){
            // 获取原地址中的参数信息
            let params=getQueryVariable();            
            let ids_arr=setUrlParams(params['ids'],$(this));
            params['ids']=ids_arr.join('_');
            setNewUrl(params);
        });

        $('.btn-excel').on('click',function(){
            var ids  = get_select_all_ids_by_name('ids');
            if(ids){
                let params=getQueryVariable();

                str = '/wxapp/sequence/comLeaderGoodsExcelNew?ids='+params['ids'];
                $('#form-action').attr('action',str);
                $('#excelOrder').modal('show');
            }else{
                layer.msg('未选择小区');
            }

        });


        // 重新设置id参数数组
        function setUrlParams(ids,_this){
            let ids_arr=new Array();
            let id=_this.val();
            if(ids){
                ids_arr=ids.split('_');
            }
            if(_this.prop('checked')){
                ids_arr.push(id);
            }else{
                for(let i in ids_arr){
                    if(id==ids_arr[i]){
                        ids_arr.splice(i,1);
                    }
                }
            }
            return ids_arr;
        }
        // 设置默认选中的checkbox框
        function setDefaultCheckbox(){
            // 分页加载时设置checkbox的选中状态
            let params=getQueryVariable();
            if(!params['ids'])
                return;
            let ids=params['ids'].split('_');
            let count=0;
            $('.aceitem').each(function(){
                for(let i in ids){
                    if($(this).val()==ids[i]){
                        $(this).prop('checked','checked');
                        count++;
                    }
                }
            });
            if($('.aceitem').length==count){
                $('#checkBox').prop('checked','checked');
            }
        }

        // 获取url参数
        function getQueryVariable(){
           let query = window.location.search.substring(1);
           let vars = query.split("&");
           let params={};
           for (let i=0;i<vars.length;i++) {
               let pair = vars[i].split("=");
               params[pair[0]]=pair[1];
           }
           return params;
        }
        // 设置新的连接
        function setNewUrl(params){
            let base_url = document.URL;
            let new_url='';
            let num = decodeURIComponent(base_url).indexOf('?');  //获取＃在的位置信息
            if(num>-1){
                new_url = base_url.substring(0,num);  //截取网址信息
               
            }else{
                new_url=base_url;
            }
            new_url+='?'+decodeURIComponent($.param(params));
            history.pushState(null,null,new_url);  //将网址设置
        }

        $('#checkBox').click(function(){
            select_all_by_name_vendor('ids','checkBox');
        });
        // 全选或取消
        function select_all_by_name_vendor(name,id){
            var ele = $('#'+id);
            let params=getQueryVariable();
            let ids=params['ids'].split('_');
            if(ele.is(':checked')){//全选
                $("input[name='"+name+"']").prop('checked', true);
                // 设置全部选中的ids
                $('.aceitem').each(function(){
                    ids.push($(this).val());
                });
            }else{//取消全选
                $("input[name='"+name+"']").prop('checked', false);
                // 删除取消选中的所有的ids
                $('.aceitem').each(function(){
                    for(let i in  ids){
                        if(ids[i]==$(this).val()){
                            ids.splice(i,1)
                        }
                    }
                });
            }
            params['ids']=ids.join('_');
            setNewUrl(params);
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
                    'url'   : '/wxapp/sequence/communityDelete',
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

    function removeLeader(ele) {
        layer.confirm('确定取消关联吗？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            var leaderId = $(ele).data('leaderid');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/removeCommunityLeader',
                    'data'  : { id:id,leaderId:leaderId},
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

    $('.confirm-handle').on('click',function () {
        $('#hid_handle_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_handle_id').val();
        var remark = $('#handle_remark').val();
        var status = $('#handle_status').val();
        var data = {
            id : hid,
            remark : remark,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/seqregion/handleCommunityVerify',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
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

    $('.previewCon').on('click',function(){
        var type = $(this).data('type');
        if(type){
            var id  = $(this).data('id');
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var data = {
                'type' : type,
                'id'  : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/print/sequencePrintShow',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        layer.open({
                            type: 1,
                            title: '内容预览',
                            hadeClose: true,
                            scrollbar: false,
                            maxmin: true, //开启最大化最小化按钮
                            area: ['1000px', '600px'],
                            content: ret.data
                        });
                    }else{
                        layer.msg(ret.em);
                    }

                }
            });

        }else{
            layer.msg('位置模版类型');
        }
    });

    $('.previewConGoods').on('click',function(){
        var type = $('#print_type').val();

        let start_date = $('#print_start_date').val();
        let start_time = $('#timepicker_print_start').val();

        let end_date = $('#print_end_date').val();
        let end_time = $('#timepicker_print_end').val();

        if(type){
            // var id  = $(this).data('id');
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var data = {
                'print_type' : type,
                // 'id'  : id,
                'print_start_date' : start_date,
                'print_start_time' : start_time,
                'print_end_date' : end_date,
                'print_end_time' : end_time,
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/print/sequencePrintShowGoods',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        layer.open({
                            type: 1,
                            title: '内容预览',
                            hadeClose: true,
                            scrollbar: false,
                            maxmin: true, //开启最大化最小化按钮
                            area: ['1000px', '600px'],
                            content: ret.data
                        });
                    }else{
                        layer.msg(ret.em);
                    }

                }
            });

        }else{
            layer.msg('位置模版类型');
        }
    });

</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class='col-sm-12'>
                <p style='padding-left: 15px;'>
                    供应商登录地址:<a target="_blank" href="http://<{$host}>/supplier">http://<{$host}>/supplier</a>&nbsp;&nbsp;
                    <button id='copy' data-clipboard-action='copy' data-clipboard-text='http://<{$host}>/supplier' class='btn btn-xs btn-default' style='padding:1px 5px;'>复制</button></p>
            </div>
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/supplierInfoList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">供应商名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="供应商名称">
                                </div>
                            </div>

                        </div>
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">联系人手机</div>
                                    <input type="text" class="form-control" name="mobile" value="<{if $mobile}><{$mobile}><{/if}>"  placeholder="联系人手机">
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
                            <th>名称</th>
                            <th>联系人</th>
                            <th>电话</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['assi_id']}>">
                                <td><{$val['assi_name']}></td>
                                <td><{$val['assi_contact']}></td>
                                <td><{$val['assi_mobile']}></td>
                                <td><{date('Y-m-d H:i:s', $val['assi_create_time'])}></td>
                                <td class="jg-line-color">
                                	<a href="/wxapp/sequence/supplierGoodsSum?id=<{$val['assi_id']}>" >订单商品统计</a>
                                    -<a target="_blank" href="/wxapp/goods/index?supplier=<{$val['assi_id']}>" >查看所属商品</a>
                                    -<a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['assi_id']}>" data-name="<{$val['assi_name']}>" data-contact="<{$val['assi_contact']}>" data-mobile="<{$val['assi_mobile']}>" data-note="<{$val['assi_note']}>" data-suppliertime="<{$val.assi_supplier_time}>">编辑</a>
                                    -<a data-id="<{$val['assi_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>

                        <!--<tr><td colspan="5" class='text-right'></td></tr>-->

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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加供应商
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">
                <!--
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">省份：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="province" name="province" onchange="changeWxappProvince()" placeholder="请选择省份">
                            <option value="">选择省份</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">城市：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="city" name="city" onchange="changeWxappCity()" placeholder="请选择城市">
                            <option value="">选择城市</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">地区：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="zone" name="zone"  placeholder="请选择地区">
                            <option value="">选择省会</option>
                        </select>
                    </div>
                </div>
                -->
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">名称<span style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <input id="assi_name" class="form-control" placeholder="请填写供应商名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">联系人<span style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <input id="assi_contact" class="form-control" placeholder="请填写联系人名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">手机号<span style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <input id="assi_mobile" class="form-control" placeholder="请填写联系人手机号" style="height:auto!important"/>
                    </div>
                </div>
                <!-- 供应商后台登录密码 -->
                <div class="form-group row" >
                    <label class="col-sm-3 control-label no-padding-right"  style="text-align: center">密码<span style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <input type="password" autocomplete="off" style="display: none;"/>
                        <input id="assi_pass" type='password' class="form-control" placeholder="供应商登录密码(默认为手机号码)" style="height:auto!important" autocomplete="new-password"/>
                    </div>
                </div>
                <!-- 选择每日供货时间点 -->
                <div class="form-group row" >
                    <label class="col-sm-3 control-label no-padding-right"  style="text-align: center">供货时间<span style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <input id="assi_supplier_time" class="form-control" placeholder="供货时间" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注</label>
                    <div class="col-sm-8">
                        <textarea name="assi_note" id="assi_note" cols="30" rows="8" style="width: 100%"></textarea>
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
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script>
    var clipboard = new ClipboardJS('#copy');
    clipboard.on('success', function(e) {
        layer.msg('复制成功');
    });
    //时间选择器
    laydate.render({
        elem: '#assi_supplier_time',
        type: 'time'
    });

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#assi_name').val($(this).data('name'));
        $('#assi_contact').val($(this).data('contact'));
        $('#assi_mobile').val($(this).data('mobile'));
        $('#assi_note').val($(this).data('note'));
        $('#assi_supplier_time').val($(this).data('suppliertime'));
//        var province = $(this).data('province');
//        var city = $(this).data('city');
//        var zone = $(this).data('zone');
//        intiPosition(province,city,zone);
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#assi_name').val('');
        $('#assi_contact').val('');
        $('#assi_mobile').val('');
        $('#assi_note').val('');
        $('#assi_pass').val('');
        $('#assi_supplier_time').val('');
//        intiPosition(0,0,0);
    });

    function intiPosition(province,city,zone) {
        if(province){
            initWxappRegion(1,'province',province);
            if(city){
                initWxappRegion(province,'city',city);
            }
            if(city && zone){
                initWxappRegion(city,'zone',zone);
            }
        }else{
            initWxappRegion(1,'province');
        }
    }
    //初始化省、市、区
    var id = $('#hid_id').val();


    $('#comfirm-area').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#assi_name').val();
        var contact   = $('#assi_contact').val();
        var mobile = $('#assi_mobile').val();
        var note  = $('#assi_note').val();
        var passwd=$('#assi_pass').val();
        var supplier_time=$('#assi_supplier_time').val();
       // var province = $('#province').val();
       // var city = $('#city').val();
       // var zone = $('#zone').val();
        var data = {
            id     : id,
            name   : name,
            contact   : contact,
            mobile : mobile,
            note   : note,
            passwd: passwd,
            supplier_time:supplier_time,
        };
        $('#comfirm-area').attr('disabled',true);
        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/supplierInfoSave',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        $('#comfirm-area').attr('disabled',false);
                    }
                }
            });
        }
    });

    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/supplierInfoDelete',
                    'data'  : { id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }else{

                        }
                    }
                });
            }
        });

    }

    /**
     * 省会变更
     */
    function changeWxappProvince(){
        var fid = $('#province').val();
        initWxappRegion(fid ,'city');
    }
    /**
     * 城市变更
     */
    function changeWxappCity(){
        var fid = $('#city').val();
        initWxappRegion(fid ,'zone');
    }

    function initWxappRegion(fid,selectId,df){
        if(fid > 0) {
            var data = {
                'fid': fid
            };
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/index/region',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        region_html(ret.data,selectId,df);
                        if(!df){
                            if(selectId == 'province'){
                                initWxappRegion(ret.data[0].region_id,'city');
                            }
                            if(selectId == 'city'){
                                initWxappRegion(ret.data[0].region_id,'zone');
                            }
                        }
                    }
                }
            });
        }
    }

    /**
     * 展示区域省市区
     * @param data
     * @param selectId
     */
    function region_html(data,selectId,df){
        var option = '';
        for(var i=0 ; i < data.length ; i++){
            var temp  = data[i];
            var sel   = '';
            if(df && temp.region_id == df ){
                sel = 'selected';
            }
            option += '<option  value="'+temp.region_id+'" '+sel+'>'+temp.region_name+'</option>';
        }
        $('#'+selectId).html(option);
    }

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
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加区域</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/currency/couponReceiveList" method="get">
                    <input type="hidden" value="<{$id}>" name="id">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <{if !$id}>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">优惠券</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="优惠券名称">
                                </div>
                            </div>
                            <{/if}>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">分享人</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="分享人昵称">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">使用状态</div>
                                    <select name="status" id="status" class="form-control">
                                        <option value="0">全部</option>
                                        <option value="1" <{if $status == 1}> selected<{/if}>>已使用</option>
                                        <option value="2" <{if $status == 2}> selected<{/if}>>未使用</option>
                                        <option value="3" <{if $status == 3}> selected<{/if}>>已过期</option>
                                    </select>
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
                            <th>优惠券名称</th>
                            <th>领取时间</th>
                            <th>使用状态</th>
                            <th>使用时间</th>
                            <th>分享人</th>
                        </tr>
                        </thead>
                        <tbody style=''>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['cr_id']}>">
                                <td><{$val['cl_name']}></td>
                                <td><{date('Y-m-d H:i:s',$val['cr_receive_time'])}></td>
                                <td>
                                    <{if $val['cr_is_used'] == 0}>
                                    <span class="font-color-audit">未使用</span>
                                    <{elseif $val['cr_is_used'] == 1}>
                                    <span class="font-color-pass">已使用</span>
                                    <{elseif $val['cr_is_used'] == 2}>
                                    <span class="font-color-refuse">已过期</span>
                                    <{/if}>
                                </td>
                                <td><{if $val['cr_used_time']}><{date('Y-m-d H:i:s',$val['cr_used_time'])}><{/if}></td>
                                <td><{$val['cr_share_nickname']}></td>
                            </tr>
                         <{/foreach}>
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
                    添加区域
                </h4>
            </div>
            <div class="modal-body" style="margin-left: 20px">
                <{if $area.m_area_id == ''}>
                <!-- 区域合伙人添加区域时去掉省份 -->
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">省份：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="province" name="province" onchange="changeWxappProvince()" placeholder="请选择省份">
                            <option value="">选择省份</option>
                        </select>
                    </div>
                </div>
                <{/if}>
                <{if $area==''|| ($area && $area.m_area_type=='C')}>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">城市：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="city" name="city" onchange="changeWxappCity()" placeholder="请选择城市" 
                        <{if $area.m_area_id!=''}>
                        disabled
                        <{/if}>
                        >
                            <option value="">选择城市</option>
                        </select>
                    </div>
                </div>
                <{/if}>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">地区：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="zone" name="zone"  placeholder="请选择地区" <{if $area.m_area_id!='' && $area.m_area_type=='D'}>disabled<{/if}>>
                            <option value="" >选择县区</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">区域名称：</label>
                    <div class="col-sm-8">
                        <input id="asa_name" class="form-control" placeholder="请填写区域名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row" style="display: none;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">配送员名称：</label>
                    <div class="col-sm-8">
                        <input id="asa_poster_name" class="form-control" placeholder="请填写区域名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row" style="display: none;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">配送员电话：</label>
                    <div class="col-sm-8">
                        <input id="asa_poster_mobile" class="form-control" placeholder="请填写区域名称" style="height:auto!important"/>
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
<!-- hidden fields start-->
<input id='area_id' type="hidden" value="<{$area.m_area_id}>">
<input id='area_name' type="hidden" value="<{$area.region_name}>">
<input id='area_type' type="hidden" value="<{$area.m_area_type}>">
<!-- hidden fiels end -->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#asa_name').val($(this).data('name'));
        $('#asa_poster_name').val($(this).data('postername'));
        $('#asa_poster_mobile').val($(this).data('postermobile'));
        var province = $(this).data('province');
        var city = $(this).data('city');
        var zone = $(this).data('zone');

        let area_id=$('#area_id').val();
        let area_name=$('#area_name').val();
        if(area_id){
            intiPosition(0,city,zone);
            $('#city').html('<option value="'+area_id+'">'+area_name+'</option>');
        }else{
            intiPosition(province,city,zone);
        }
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#asa_name').val('');
        $('#asa_poster_name').val('');
        $('#asa_poster_mobile').val('');

         // 区域合伙人相关城市回写
        let area_id=$('#area_id').val();
        // 如果直接是区县级别的合伙人的话 省市信息就不在显示了
        let area_type=$('#area_type').val();
        if(area_type=='D'){
            $('#zone').val(area_id);
            let area_name=$('#area_name').val();
            $('#zone').html("<option value='"+area_id+"' >"+area_name+"</option>");
        }else{
            if(area_id)
                intiPosition(0,area_id,0);
            else
                intiPosition(0,0,0);

            let area_name=$('#area_name').val();
            if(area_name){
                $('#city').html('<option value="'+area_id+'">'+area_name+'</option>');
            }
        }
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
        }else if(city){  //区域管理合伙人获取可添加的街道区域
            if(zone)
                initWxappRegion(city,'zone',zone);
            else
                initWxappRegion(city,'zone',0);
        }else{
            initWxappRegion(1,'province');
        }
    }
    //初始化省、市、区
    var id = $('#hid_id').val();


    $('#comfirm-area').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#asa_name').val();
        var posterName = $('#asa_poster_name').val();
        var posterMobile  = $('#asa_poster_mobile').val();
        var province = $('#province').val();
        var city = $('#city').val();
        var zone = $('#zone').val();
        var data = {
            id     : id,
            name   : name,
            posterMobile : posterMobile,
            posterName  : posterName,
            province : province,
            city : city,
            zone : zone
        };
        console.log(data);
        $('#comfirm-area').attr('disabled',true);
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
                    }else{
                        $('#comfirm-area').attr('disabled',false);
                    }
                }
            });
        }else{
            layer.msg('区域名称不能为空');
            $('#comfirm-area').attr('disabled',false);
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
                    'url'   : '/wxapp/sequence/areaDelete',
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

    $('#search_prov,#search_city').change(function(){
        let p_id=$(this).val();
        let type=$(this).data('type');
        if(p_id==0){
            if(type=='province'){
                $('#search_city').find('option[value="0"]').attr('selected',true);
            }
            $('#search_zone').find('option[value="0"]').attr('selected',true);
            return;
        }
        if(type=='city')
            type='2';
        $.ajax({
            type:'post',
            url:'/wxapp/sequence/getRegionByPId',
            dataType:'json',
            data:{
                'region_id':p_id,
                'type':type,
            },
            success:function(res){
                if(res.ec == 200 ){
                    let option="<option value='0'>请选择开通城市</option>";
                    for(let i=0;i<res.data.length;i++){
                        option+="<option value='"+res.data[i].region_id+"'>"+res.data[i].region_name+"</option>";
                    }
                    if(type==2)
                        $('#search_zone').html(option);
                    else
                        $('#search_city').html(option);
                }else{
                    layer.msg(res.em);
                }
            }
        });
    });
</script>
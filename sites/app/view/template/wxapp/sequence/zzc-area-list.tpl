<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加区域</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/areaList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">区域名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>"  placeholder="区域名称">
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
                            <th>街道名称</th>
                            <th>省-市-区</th>
                            <!--
                            <th>配送员名称</th>
                            <th>配送员电话</th>
                            -->
                            <th>添加时间</th>
                            <th>社区列表</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asa_id']}>">
                                <td><{$val['asa_name']}></td>
                                <td><{$val['area']}></td>
                                <!--
                                <td><{$val['asa_poster_name']}></td>
                                <td><{$val['asa_poster_mobile']}></td>
                                -->
                                <td><{date('Y/m/d H:i:s', $val['asa_create_time'])}></td>
                                <td>
                                    <a href="/wxapp/sequence/communityList?area=<{$val['asa_id']}>" >查看社区列表</a>
                                </td>
                                <td class="jg-line-color">
                                	
                                     - <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['asa_id']}>" data-name="<{$val['asa_name']}>" data-postername="<{$val['asa_poster_name']}>" data-postermobile="<{$val['asa_poster_mobile']}>" data-province="<{$val['asa_province']}>" data-city="<{$val['asa_city']}>" data-zone="<{$val['asa_zone']}>">编辑</a>
                                     - <a data-id="<{$val['asa_id']}>" onclick="confirmDelete(this)" style="color:red;">删除</a>                                   
                                </td>
                            </tr>
                            <{/foreach}>

                        <tr><td colspan="5"><{$pagination}></td></tr>

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
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
        intiPosition(province,city,zone);
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#asa_name').val('');
        $('#asa_poster_name').val('');
        $('#asa_poster_mobile').val('');
        intiPosition(0,0,0);
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
</script>
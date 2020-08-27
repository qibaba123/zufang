<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>添加商圈</a>
        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/community/district" method="get" class="form-inline">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">省份</div>
                                    <select name="searchProvince" id="searchProvince" class="form-control" onchange="changeSearchWxappProvince()">
                                        <{foreach $provSelect as $key => $val}>
                                    <option value="<{$key}>" <{if $key==$zone['parent_id']}>selected<{/if}>><{$val}></option>
                                        <{/foreach}>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">城市</div>
                                    <select name="searchCity" id="searchCity" class="form-control" onchange="changeSearchWxappCity()">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="height:34px;">区域</div>
                                    <select name="searchZone" id="searchZone" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">商圈名称</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="商圈名称">
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
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>商圈名称</th>
                            <th>所属地区</th>
                            <th>排序</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['acd_id']}>">
                                <td><{$val['acd_name']}></td>
                                <td><{$val['acd_area_name']}></td>
                                <td><{$val['acd_sort']}></td>
                                <td><{date('Y-m-d H:i:s', $val['acd_create_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="confirm-handle" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['acd_id']}>" data-prov="<{$val['acd_prov_id']}>" data-city="<{$val['acd_city_id']}>" data-area="<{$val['acd_area_id']}>" data-name="<{$val['acd_name']}>" data-weight="<{$val['acd_sort']}>" >编辑</a>
                                     - <a data-id="<{$val['acd_id']}>" onclick="confirmDelete(this)" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="9"><{$pagination}></td></tr>
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
                    添加商圈
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-top: 20px">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商圈名称：</label>
                    <div class="col-sm-8">
                        <input id="district-name" class="form-control" placeholder="请填写商圈名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">所属区域：</label>
                    <div class="col-sm-2">
                        <select name="province" id="province" class="form-control" onchange="changeWxappProvince()">
                            <{foreach $provSelect as $key => $val}>
                            <option value="<{$key}>" <{if $key==$zone['parent_id']}>selected<{/if}>><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="city" id="city" class="form-control" onchange="changeWxappCity()">

                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select name="zone" id="zone" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">商圈排序：</label>
                    <div class="col-sm-8">
                        <input id="district-weight" class="form-control" placeholder="数字越大，排序越靠后" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script>
    var province = '<{$zone['parent_id']}>';
    var city = '<{$zone['region_id']}>';

    var searchProvince = '<{$searchProvince}>';
    var searchCity = '<{$searchCity}>';
    var searchZone = '<{$searchZone}>';
    var areaSelect = <{json_encode($areaSelect)}>;

    $(function(){
        initWxappRegion(province,'city',city);
        initWxappRegion(city,'zone','');

        initSearchWxappRegion(searchProvince,'searchCity',searchCity);
        initSearchWxappRegion(searchCity,'searchZone',searchZone);
    });

    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#district-name').val($(this).data('name'));
        $('#district-weight').val($(this).data('weight'));
        initWxappRegion($(this).data('prov'),'city',$(this).data('city'));
        initWxappRegion($(this).data('city'),'zone',$(this).data('area'));
    });

    $('#add-new').on('click',function () {
        $('#hid_id').val(0);
        $('#district-name').val('');
        $('#district-weight').val('');
        initWxappRegion(province,'city',city);
        initWxappRegion(city,'zone','');
    });

    $('#confirm-category').on('click',function(){
        var id     = $('#hid_id').val();
        var name   = $('#district-name').val();
        var weight = $('#district-weight').val();
        var area  = $('#zone').val();
        var province  = $('#province').val();
        var city  = $('#city').val();
        var data = {
            id     : id,
            name   : name,
            weight : weight,
            province : province,
            city : city,
            area  : area,
            areaName:areaSelect[area]
        };

        if(name){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/saveDistrict',
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

    function confirmDelete(ele) {
        var id = $(ele).data('id');
        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/deleteDistrict',
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
    }

    /**
     * 省会变更
     */
    function changeSearchWxappProvince(){
        var fid = $('#searchProvince').val();
        initSearchWxappRegion(fid ,'searchCity');
    }
    /**
     * 城市变更
     */
    function changeSearchWxappCity(){
        var fid = $('#searchCity').val();
        initSearchWxappRegion(fid ,'searchZone');
    }

    function initSearchWxappRegion(fid,selectId,df){
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
                        region_search_html(ret.data,selectId,df);
                        if(!df){
                            if(selectId == 'searchProvince'){
                                initSearchWxappRegion(ret.data[0].region_id,'searchCity');
                            }
                            if(selectId == 'searchCity'){
                                initSearchWxappRegion(ret.data[0].region_id,'searchZone');
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
    function region_search_html(data,selectId,df){
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



</script>
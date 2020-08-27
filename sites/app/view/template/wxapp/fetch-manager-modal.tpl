<style>
    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .search-input{
        width: 90% !important;
        margin-bottom: 5px !important;
        display: block !important;
    }
</style>
<div id="manager-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">查找</h4>
            </div>
            <div class="modal-body">
                <div class="good-search">
                    <div class="input-group">
                        <input type="text" id="nickname" class="form-control search-input" placeholder="姓名">
                        <input type="text" id="mobile" class="form-control search-input search-truename" placeholder="电话">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr style="margin: 0">
                <table  class="table-responsive">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <input type="hidden" id="managerId" value="">
                    <thead>
                    <tr>
                        <th style="text-align:left">名称</th>
                        <th class="th-truename">电话</th>
                        <th>操作</th>
                    </thead>

                    <tbody id="goods-tr">
                    <!--商品列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>

    //管理商品
    $('.get-managers').on('click',function(){
        //初始化
        $('#goods-tr').empty();
        $('#footer-page').empty();
        $('#managerId').val('');
        var type = $(this).data('mk');
        $('#manager-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        $('#managerId').val($(this).data('manager'));
        currPage = 1 ;
        fetchPageData(currPage);
    });

    function fetchPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            //'id'    :  $('#currId').val()  ,
            'page'  : page,
            'nickname': $('#nickname').val(),
            'mobile' : $('#mobile').val(),
            'managerId' : $('#managerId').val(),
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/fetchManager',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data){
        var mk = $('#mkType').val();
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].m_id+'">';
//            if(data[i].m_avatar){
//                html += '<td><img src="'+data[i].m_avatar+'"/></td>';
//            }else{
//                html += '<td><img src="/public/wxapp/images/applet-avatar.png"/></td>';
//            }

            html += '<td style="text-align:left"><p class="g-name">'+data[i].esm_nickname+'</p></td>';
            html += '<td style="text-align:center"><p class="g-name">'+data[i].esm_mobile+'</p></td>';
            if(mk == 'choose'){
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].esm_id+'" data-nickname="'+data[i].esm_nickname+'" onclick="dealMember( this )"> 选取 </td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info" data-type="add" data-id="'+data[i].esm_id+'" data-nickname="'+data[i].esm_nickname+'" onclick="selectMember( this )"> 选取 </td>';
            }

            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }

    function selectMember(ele) {
        $('#select-manager-id').val($(ele).data('id'));
        $('#select-manager-name').text($(ele).data('nickname'));
        $('#manager-modal').modal('hide');
    }


    function dealMember(ele){
        var id      = $(ele).data('id');
        var leader      = $('#currId').val() ;
        // console.log(data);
        if(id){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var data = {
                'id'    : id,
                'leader': leader
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/addLeaderManager',
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
    }
</script>
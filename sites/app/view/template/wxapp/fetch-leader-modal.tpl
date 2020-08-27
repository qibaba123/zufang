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
<div id="goods-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">查找</h4>
            </div>
            <div class="modal-body">
                <div class="good-search">
                    <div class="input-group">
                        <input type="text" id="nickname" class="form-control search-input" placeholder="昵称">
                        <input type="text" id="truename" class="form-control search-input search-truename" placeholder="姓名">
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
                    <thead>
                    <tr>
                        <th>头像</th>
                        <th style="text-align:left">昵称</th>
                        <th class="th-truename">姓名</th>
                        <th>会员编号</th>
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

<div class="modal fade" id="sendCouponModal" tabindex="-1" role="dialog" aria-labelledby="sendCouponModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_coupon_id" >
            <input type="hidden" id="hid_leader_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">赠送数量：</label>
                    <div class="col-sm-8">
                        <input id="send-coupon-num" class="form-control" placeholder="请填写赠送数量" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-send-coupon">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>

    //管理商品
    $('.get-members').on('click',function(){
        //初始化
        $('#goods-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');
        if(type == 'leader'){
            $('.th-truename').show();
            $('.search-truename').show();
        }else if(type == 'leader-coupon'){
            $('.th-truename').show();
            $('.search-truename').show();
        }else{
            $('.th-truename').hide();
            $('.search-truename').hide();
        }
        $('#goods-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
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
            'truename' : $('#truename').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/fetchMemberLeader',
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
            if(data[i].m_avatar){
                html += '<td><img src="'+data[i].m_avatar+'"/></td>';
            }else{
                html += '<td><img src="/public/wxapp/images/applet-avatar.png"/></td>';
            }

            html += '<td style="text-align:left"><p class="g-name">'+data[i].m_nickname+'</p></td>';
            if(mk == 'leader' || mk == 'leader-coupon'){
                html += '<td class="th-truename">'+ data[i].asl_name +'</td>';
                //html += '<td><a href="javascript:;" class="btn btn-xs btn-danger" data-type="del" data-id="'+data[i].g_id+'" onclick="dealMember( this )"> 移除 </a></td>';
            }
            html += '<td style="text-align:center"><p class="g-name">'+data[i].m_show_id+'</p></td>';
            if(mk == 'leader-coupon'){
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info select-leader" data-type="add" data-mid="'+data[i].m_id+'" data-id="'+data[i].asl_id+'" onclick="couponModal( this )"> 发放 </td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info select-leader" data-type="add" data-mid="'+data[i].m_id+'" data-id="'+data[i].asl_id+'" onclick="dealMember( this )"> 选取 </td>';
            }

            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }

    function dealMember(ele){
        $('.select-leader').attr('disabled','disabled');
        var id      = $(ele).data('id');
        var mid     = $(ele).data('mid');
        var type    = $(ele).data('type');
        var cid      = $('#currId').val() ;
        // var data = {
        //     'id'    : id,
        //     'mid'   : mid,
        //     'type'  : type,
        //     'cid'    : cid
        // };
        // console.log(data);
        if(id && type){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var data = {
                'id'    : id,
                'mid'   : mid,
                'type'  : type,
                'cid'    : cid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/addCommunityLeader',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        $('.select-leader').removeAttr('disabled');
                    }
                }
            });
        }
    }


    function couponModal(ele){
        //$('.select-leader').attr('disabled','disabled');
        let id      = $(ele).data('id');
        let mid     = $(ele).data('mid');
        let type    = $(ele).data('type');
        let cid      = $('#currId').val() ;

        $('#send-coupon-num').val();
        $('#hid_leader_id').val(id);
        $('#hid_coupon_id').val(cid);


        $('#sendCouponModal').modal('show');
    }

    $('#confirm-send-coupon').click(function () {
        let leader = $('#hid_leader_id').val();
        let coupon = $('#hid_coupon_id').val();
        let num = $('#send-coupon-num').val();

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        let data = {
            'leader' : leader,
            'coupon' : coupon,
            'num'    : num
        };

        console.log(data);

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/coupon/sendLeaderCoupon',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    //$('.select-leader').removeAttr('disabled');
                }
            }
        });

    });

</script>
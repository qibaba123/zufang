<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <!--
    <a href="javascript:;" onclick="addMember()" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <br><br>
    -->
    <div class="row" style="margin-left: 140px;">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-hover">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>链接</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $page_list as $val}>
                        <tr id="tr_">
                            <td><{$val['name']}></td>
                            <td><{$val['path']}></td>
                            <td>
                                <a href="javascript:;" class="btn btn-xs btn-green btn-copy_link" data-link="<{$val['path']}>">
                                    复制链接
                                </a>
                                <!--
                                <a href="javascript:;" class="btn btn-xs btn-info deal-audit">
                                    示例
                                </a>
                                <a href="javascript:;" class="btn btn-xs btn-danger del-btn" style="color:#f00;">
                                    删除
                                </a>
                                -->
                            </td>
                        </tr>
                    <{/foreach}>
                    <{if $pageHtml}>
                        <tr><td colspan="3"><{$pageHtml}></td></tr>
                    <{/if}>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->

</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/withdraw-list.js" ></script>

<script type="text/javascript" language="javascript">
    $('.deal-audit').on('click',function(){
        $('#h1Title').text($(this).data('title'));
        $('#example').html($(this).data('example'));
        $('#withdraw-form').modal('show');
    });
    $('.modal-save').on('click',function(){
        $('#withdraw-form').modal('hide');
    })
    $('.xxmb-bnt').on('click',function(){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: '516px',
            shadeClose: true,
            content: '<img src="/public/manage/img/helper/WX20171102-190708.png" width="500px">'
        });
    });

    //复制
    $('.btn-copy_link').on('click',function(){
        var copy_input = document.createElement('input');
        copy_input.value = $(this).data('link');
        document.body.appendChild(copy_input);
        copy_input.select();
        document.execCommand('Copy');
        //copy_input.style.display='none';
        copy_input.setAttribute('type','hidden');
        layer.msg('复制成功',{ time:2000 });
    });


</script>

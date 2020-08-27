<link rel="stylesheet" href="/public/plugin/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/css/code.css?11">
<style>
    .tgl-light+.tgl-btn {
        background: #00CA4D;!important;
    }
    .tgl-light:checked+.tgl-btn {
        background: red;!important;
    }
    .table{
        border: 0;
    }
    .table thead tr{
        background: #fff;
        border: 0;
        color: #333;
    }

    .table thead tr th{
        border: 0;
    }

    .table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th{
        border: 0;
        background: #fff;
    }

</style>
<{if $noticeList}>
<div class="version-item-box">
    <div class="code-version-title">
        <h3>历史公告</h3>
    </div>
    <div id="content-con">
        <div  id="mainContent">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                            <{foreach $noticeList as $val}>
                            <thead>
                            <tr>
                                <th>(版本号 <{$val['sn_version']}>) <{$val['sn_title']}></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><{$val['sn_content']}></td>
                                </tr>
                            <tr>
                            </tr>
                            </tbody>
                            <{/foreach}>
                        </table>
                    </div><!-- /.table-responsive -->
                    <td colspan="9"><{$pageHtml}></td>
                </div><!-- /span -->
            </div><!-- /row -->
            <!-- PAGE CONTENT ENDS -->
        </div>
    </div>
</div>
<{/if}>

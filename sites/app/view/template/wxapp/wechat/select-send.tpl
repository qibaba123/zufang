<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/css/wechatArticle.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<style>
    .chosen-container {
        width: 100%!important;
    }
    .chosen-container-multi .chosen-choices{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    select.form-control {
        padding: 5px 6px;
        height: 34px;
    }
    .content .form-group .control-label{
        font-weight: bold;
    }
</style>
<div class="content">
    <hr>
    <div class="row" >
        <div class="col-xs-10">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="amount" class="col-sm-2 control-label">发送会员</label>
                    <div class="col-sm-10">
                        <select id="member" class="selectpicker form-control bla bla bli chosen-select" multiple="" data-live-search="true" data-placeholder="请选择会员">
                            <{foreach $member as $val}>
                            <option value="<{$val['m_id']}>"><{$val['m_nickname']}>(编号：<{$val['m_show_id']}>)</option>
                            <{/foreach}>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="text-center"><a href="javascript:;" class="btn btn-primary btn-xs btn-save"> 立即发送 </a></div>
                    </div>
                </div> -->
            </form>
        </div>
        <div class="col-xs-2">
            <div style="padding-top: 74px;"><a href="javascript:;" class="btn btn-green btn-lg btn-save"> 立即发送 </a></div>
        </div>
    </div>
    <hr>

</div>

<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    $(function(){
        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true
        });

        $('.btn-save').on('click',function(){
            var type = $('input[name="type"]:checked').val();
            /*选中的值*/
            var mid = $('.selectpicker').val();
            if(type==0 && !mid){
                layer.msg('请选择发送会员');
                return false;
            }

            var data = {
                'type'    : type,
                'msgId'   : '<{$row['wt_id']}>'
            };
            if(mid){
                data.member = mid.join(',')
            }
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
        });
    });
</script>
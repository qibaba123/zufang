<style>
    .page-header{
        padding:10px 0;
    }
</style>
<div class="page-header">
    <div style="padding: 10px">
        注意事项：跳转域名仅支持HTTPS域名，请先在微信小程序后台<span style="color: blue">设置-->开发设置-->业务域名<span>配置业务域名信息<a href="https://mp.weixin.qq.com/" target="_blank">查看配置</a>
    </div>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-sm-9" style="margin-bottom: 20px;">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green icon-home bigger-110"></i>
                        跳转信息配置
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!--店铺基本信息-->
                <div id="home" class="tab-pane in active">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> 跳 &nbsp; 转 &nbsp; 链 &nbsp; 接 : </div>
                            <input type="text" class="form-control" id="outside_web" placeholder="请输入跳转的URL地址，只支持https域名" value="<{if $row}><{$row['awp_url']}><{/if}>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="right">
                            <button class="btn btn-primary" style="margin:0 10px" onclick="saveOutsideSetup();">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    // 保存店铺信息配置
    function saveOutsideSetup(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });
        var data = {
            'outside' : $('#outside_web').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/outside/saveOutsideSetup',
            'data'  : data,
            'dataType' : 'json',
            success : function(response){
                layer.close(index);
                layer.msg(response.em);
            }
        });
    }
</script>
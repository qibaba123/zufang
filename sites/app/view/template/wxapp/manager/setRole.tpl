<link rel="StyleSheet" href="/public/dtree/dtree.css" type="text/css" />
<script type="text/javascript" src="/public/dtree/dtree.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<style>
    .power-box{
        display: flex;
        flex-direction: row;
        align-items: flex-start;
    }
    .app_dtree{
        padding-top: 50px;
        margin-left: 50px;
    }
</style>

<div class="row power-box">
    <div class="dtree power-content">
        <h3><{$group}></h3>
        <p><a href="javascript:  d.closeAll();">展开全部</a> | <a href="javascript: d.openAll();">收起全部</a></p>

        <script type="text/javascript">
            <!--
            d = new dTree('d');
            // d.add(0,-1,'权限设置');
            d.add(0,-1,'子管理员权限设置');
            <{foreach $menu_arr as $menu}>
            d.add(<{$menu['id']}>,<{$menu['fid']}>,'authority','<{$menu['key']}>','<{$menu['name']}>',<{$menu['select']}>);
            <{/foreach}>
            document.write(d);
            d.openAll();
            //-->
        </script>

    </div>


    <div class="app_dtree power-content" <{if !$app_power}>style="display: none"<{/if}>>
        <p></p>
        <script type="text/javascript">
            app = new dTree('app');
            // d.add(0,-1,'权限设置');
            app.add(0,-1,'子管理员App权限设置');
            <{foreach $app_menu_arr as $app_menu}>
            app.add(<{$app_menu['id']}>,0,'app_authority','<{$app_menu['key']}>','<{$app_menu['name']}>',<{$app_menu['select']}>);
            <{/foreach}>
            document.write(app);
        </script>
    </div>


</div>
<button type="button"  data-button class="btn btn-success btn-sm" data-add="<{$id}>" style="margin-left: 30px;margin-top: 20px;">保存</button>
<style>
    .dtree {
        font-size: 16px;
        line-height: 2;
        margin-left: 20px;
    }
</style>
<script type="text/javascript">
    $("[data-button]").on('click',function(){
        var sel=[];
        $("input[name='authority']:checked").each(function() {
            sel.push($(this).val());
        });

        var app_sel=[];
        $("input[name='app_authority']:checked").each(function() {
            app_sel.push($(this).val());
        });

        var id = $(this).data('add');
        console.log(id);
        console.log(sel);
        console.log(app_sel);
        if(id){
            $.ajax({
                type: 'POST',
                url: "/wxapp/manager/saveSubManageRole",
                data: {id:id,sel:sel,app_sel:app_sel},
                dataType: 'json',
                success: function(ret){
                    if (ret.ec == 200) {
                        layer.msg(ret.em);
                        window.location.reload();
                    } else {
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });
</script>
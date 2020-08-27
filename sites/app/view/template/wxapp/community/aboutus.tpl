<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style type="text/css">
    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    #container {
        width:100%;
        height: 300px;
    }

    .inline{
        display: inline-block;
        padding-right: 30px;
        text-align: center;
    }

    .left-inline{
        padding-left: 30px;
    }

    .left-palceholder{
        position: relative;
        right: -30px;
        color: #a6a6a6;
        top: 2px;
    }

    .palceholder{
        position: relative;
        left: -30px;
        color: #a6a6a6;
        top: 2px;
    }

    .form-control:not(.left-inline){
        margin-left: 18px;
    }

    .group-title, .group-info,.info-group-inner .group-info,.info-group-inner .group-title{
        background: #fff;;
    }

    .info-group-inner .group-info .control-label {
        font-weight: normal;
        color: gray;
    }

</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<div  ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-main">
                        <form class="form-inline container" id="property-form"  enctype="multipart/form-data">
                            <div style="overflow:hidden"
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <textarea class="form-control" style="width:100%;height:600px;visibility:hidden;" id = "aboutus" name="aboutus" placeholder="关于我们"  rows="20" style=" text-align: left; resize:vertical;" ><{$aboutus}></textarea>
                                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                        <input type="hidden" name="ke_textarea_name" value="aboutus" />
                                    </div>
                                </div>

                                <div class="form-group col-sm-12" style="text-align:center">
                                    <span type="button" class="btn btn-primary btn-sm btn-save " onclick="saveAboutUs()"> 保 存 </span>
                                </div>
                                <div class="space-8"></div>
                            </div>
                        </form>
                    </div><!-- /widget-main -->
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">

    /**
     * 保存关于我们
     */
    function saveAboutUs(type){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        var aboutus = $('#aboutus').val();
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/community/saveAboutus',
            'data'  : {about: aboutus},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
            }
        });
    }



</script>


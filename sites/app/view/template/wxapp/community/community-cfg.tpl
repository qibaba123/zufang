<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .balance .balance-info2 {
        width: 100%;
        text-align: left;
    }
    .code{
        float: left;
    }
    .line-display{
        display: inline-block;
        padding: 4px;
    }

    .section-item{
        margin: 6px 0;
    }
    .section-item input{
        display: inline-block;
        width: 100px;
        margin: 0 5px;
    }
</style>
<{include file="../common-community-menu.tpl"}>
<div class="tabbable" style="padding-left: 130px;">
    <div class="tab-content">
        <!--店铺基本信息-->
        <div class=" in">
            <div class="ui-box settlement-info">
                <{if $appletCfg['ac_type'] != 4 && $appletCfg['ac_type'] != 7 && $appletCfg['ac_type'] != 18 && $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $appletCfg['ac_type'] != 12  && $appletCfg['ac_type'] != 27}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">签到赠送积分</p>
                            <div class="item-wrap">
                                <sapn>每次获得</sapn>
                                <span class="line-display"><input type="number" id="register" value="<{$pointCfg['aps_register']}>" class="form-control"></span>
                                <span>积分</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $appletCfg['ac_type'] == 27 || $appletCfg['ac_type'] == 12}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">首签赠送积分</p>
                            <div class="item-wrap">
                                <sapn>首签获得</sapn>
                                <span class="line-display"><input type="number" id="register" value="<{$pointCfg['aps_register']}>" class="form-control"></span>
                                <span>积分，</span>
                            </div>
                        </div>
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">每日递增</p>
                            <div class="item-wrap">
                                <sapn>连续签到每日递增</sapn>
                                <span class="line-display"><input type="number" id="registerAdd" value="<{$pointCfg['aps_continuous_add']}>" class="form-control"></span>
                                <span>积分，</span>
                            </div>
                        </div>
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">赠送积分上限</p>
                            <div class="item-wrap">
                                <sapn>连续签到积分上限(0表示不设上限)</sapn>
                                <span class="line-display"><input type="number" id="registerMax" value="<{$pointCfg['aps_continuous_max']}>" class="form-control"></span>
                                <span>积分</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $appletCfg['ac_type'] != 30}>
                <div class="balance clearfix" >
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">订单消费金额获得积分</p>
                            <div class="item-wrap">
                                <span>每消费</span>
                                <span class="line-display"><input type="number" id="trade" value="<{$pointCfg['aps_trade']}>" class="form-control"></span>
                                <span>元，获得一积分</span>
                            </div>
                        </div>
                    </div>
                    <div class="balance-info balance-info2" <{if $showCountSection != 1}> style="display: none" <{/if}>>
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">订单消费次数获得积分</p>
                            <div class="item-wrap">
                                <button class="btn btn-xs btn-primary add-section" onclick="addSection()" style="margin-left: 10px">新增积分规则</button>
                                <span>消费次数获得积分与消费金额获得积分同时生效。只统计已经完成的订单</span>
                                <div class="section-box">
                                    <{foreach $countSection as $item}>
                                    <div class="section-item">下单<input type="number" class="form-control section-min" value="<{$item['min']}>">次至<input type="number" class="form-control section-max" value="<{$item['max']}>">次，获得<input type="number" class="form-control section-value" value="<{$item['value']}>">积分<button class="btn btn-xs btn-danger remove-section" onclick="removeSection(this)" style="margin-left: 20px">删除</button>
                                    </div>
                                    <{/foreach}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <{if $appletCfg['ac_type'] != 4 && $appletCfg['ac_type'] != 27  && $appletCfg['ac_type'] != 7  && $appletCfg['ac_type'] != 18 && $appletCfg['ac_type'] != 3 && $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">评价订单<{if $appletCfg['ac_type'] != 12}>或评价帖子<{/if}>获得积分</p>
                            <div class="item-wrap">
                                <span>评价一次获得</span>
                                <span class="line-display"><input type="number" id="comment" value="<{$pointCfg['aps_comment']}>" class="form-control"></span>
                                <span>积分，每天评价最高获得</span>
                                <span class="line-display"><input type="number" id="commentTotal" value="<{$pointCfg['aps_comment_total']}>" class="form-control"></span>
                                <span>积分，（未设置最高(默认为0)表示积分无上限）</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $appletCfg['ac_type'] != 4 && $appletCfg['ac_type'] != 27  && $appletCfg['ac_type'] != 7  && $appletCfg['ac_type'] != 18 && $appletCfg['ac_type'] != 3  && $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $appletCfg['ac_type'] != 12}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">收藏店铺商品帖子获得积分</p>
                            <div class="item-wrap">
                                <span>收藏一次获得</span>
                                <span class="line-display"><input type="number" id="collection" value="<{$pointCfg['aps_collection']}>" class="form-control"></span>
                                <span>积分，每天收藏最高获得</span>
                                <span class="line-display"><input type="number" id="colTotal" value="<{$pointCfg['aps_collection_total']}>" class="form-control"></span>
                                <span>积分，（未设置最高(默认为0)表示积分无上限）</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">分享获得积分</p>
                            <div class="item-wrap">
                                <span>分享一次获得</span>
                                <span class="line-display"><input type="number" id="share" value="<{$pointCfg['aps_share']}>" class="form-control"></span>
                                <span>积分，每天分享最高获得</span>
                                <span class="line-display"><input type="number" id="shareTotal" value="<{$pointCfg['aps_share_total']}>" class="form-control"></span>
                                <span>积分，（未设置最高(默认为0)表示积分无上限）</span>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">阅读资讯文章获得积分</p>
                            <div class="item-wrap">
                                <span>阅读一篇资讯文章获得</span>
                                <span class="line-display"><input type="number" id="read" value="<{$pointCfg['aps_read_article']}>" class="form-control"></span>
                                <span>积分，每天阅读最高获得</span>
                                <span class="line-display"><input type="number" id="readTotal" value="<{$pointCfg['aps_read_article_total']}>" class="form-control"></span>
                                <span>积分，（未设置最高(默认为0)表示积分无上限）</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{if $appletCfg['ac_type'] == 27}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">学习课程获得积分</p>
                            <div class="item-wrap">
                                <span>每学习一节课程获得</span>
                                <span class="line-display"><input type="number" id="study" value="<{$pointCfg['aps_study']}>" class="form-control"></span>
                                <span>积分，每天分享最高获得</span>
                                <span class="line-display"><input type="number" id="studyTotal" value="<{$pointCfg['aps_study_total']}>" class="form-control"></span>
                                <span>积分，（未设置最高(默认为0)表示积分无上限）</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $appletCfg['ac_type'] != 4  && $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $appletCfg['ac_type'] != 12}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">开通会员获取积分</p>
                            <div class="item-wrap">
                                <span>开通会员获得</span>
                                <span class="line-display"><input type="number" id="member" value="<{$pointCfg['aps_open_member']}>" class="form-control"></span>
                                <span>积分</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{if $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $appletCfg['ac_type'] != 12 && !$dyyu}>
                <div class="balance clearfix">
                    <div class="balance-info balance-info2">
                        <div class="code">
                            <p style="font-size: 20px;font-weight: bold;">收银台支付获得积分</p>
                            <div class="item-wrap">
                                <span>每消费</span>
                                <span class="line-display"><input type="number" id="cashier" value="<{$pointCfg['aps_cashier_pay']}>" class="form-control"></span>
                                <span>元，获得一积分</span>
                            </div>
                        </div>
                    </div>
                </div>
                <{/if}>
                <{/if}>
                <input type="hidden" id="pointId" value="<{$pointCfg['aps_id']}>" class="form-control">
                <div>
                    <button class="btn btn-sm btn-green btn-save" style="margin-left: 20%;margin-top: 20px;margin-bottom: 10px"> 保 存</button>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script>
    $(function () {
        var type = '<{$type}>'
        if(type && type=='discount'){
            $('#home').removeClass('active');
            $('#discount').addClass('active');
            $('#cashier-code').removeClass('active');
            $('#cashier-discount').addClass('active');
        }
    });
    $('.btn-save').on('click',function(){
        var register        = $('#register').val();
        var registerAdd     = $('#registerAdd').val();
        var registerMax     = $('#registerMax').val();
        var trade           = $('#trade').val();
        var commentTotal    = $('#commentTotal').val();
        var comment         = $('#comment').val();
        var collection      = $('#collection').val();
        var colTotal        = $('#colTotal').val();
        var share           = $('#share').val();
        var shareTotal      = $('#shareTotal').val();
        var study           = $('#study').val();
        var studyTotal      = $('#studyTotal').val();
        var post            = $('#post').val();
        var postTotal       = $('#postTotal').val();
        var read            = $('#read').val();
        var readTotal       = $('#readTotal').val();
        var member          = $('#member').val();
        var cashier         = $('#cashier').val();
       /* var pointTotal      = $('#pointTotal').val();*/
        var pointId         = $('#pointId').val();
        var data = {
         'register'        : register,
         'registerAdd'     : registerAdd,
         'registerMax'     : registerMax,
         'trade'           : trade,
         'commentTotal'    : commentTotal,
         'comment'         : comment,
         'collection'      : collection,
         'colTotal'        : colTotal,
         'share'           : share,
         'shareTotal'      : shareTotal,
         'study'           : study,
         'studyTotal'      : studyTotal,
         'post'            : post,
         'postTotal'       : postTotal,
         'read'            : read,
         'readTotal'       : readTotal,
         'member'          : member,
         'cashier'         : cashier,
         /*'pointTotal'      : pointTotal,*/
         'id'              : pointId
        };

        var sectionArr = [];
        var sectionRow = '';
        $('.section-item').each(function(){
            sectionRow = {
                'min': $(this).find('.section-min').val(),
                'max': $(this).find('.section-max').val(),
                'value': $(this).find('.section-value').val()
            };
            sectionArr.push(sectionRow);
        });
        data.sectionArr = sectionArr;

        if(data){
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            });
	            $.ajax({
	                'type'	: 'post',
	                'url'	: '/wxapp/community/savePointSourceCfg',
	                'data'	: data,
	                'dataType' : 'json',
	                'success'  : function(ret){
	                    layer.close(index);
	                    layer.msg(ret.em);
	                    if(ret.ec == 200){
	                       // window.location.reload();
	                    }
	                }
	            });
	        });
        }else{
            layer.msg('请填写完整数据');
        }
    });


    function removeSection(e) {
        $(e).parent().remove();
    }

    function addSection() {
        var section_html = getSectionHtml();
        $('.section-box').append(section_html);
    }


    function getSectionHtml() {
        var section_html = "<div class='section-item' style=' margin: 6px 0;'>下单<input type='number' class='form-control section-min' value='' style='margin: 0 5px;'>次至<input type='number' class='form-control section-max' value='' style='margin: 0 5px;'>次，获得<input type='number' class='form-control section-value' value='' style='margin: 0 5px;'>积分<button class='btn btn-xs btn-danger remove-section' onclick='removeSection(this)' style='margin-left: 20px'>删除</button></div>";
        return section_html;
    }
</script>

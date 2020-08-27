<link rel="stylesheet" href="/public/wxapp/seqstatistics/css/member-incre.css">
<div class='panel panel-default'>
    <div class='panel-body'>
        <form class='form-inline text-right' action='/wxapp/seqstatistics/memberIncrease' method='get'>
            <!-- 按天计算 -->
            <div class='form-group'>
                <select id='day' class="form-control" name="day">
                    <option <{if $smarty.get.day ==7}>selected<{/if}> value="7">7天</option>
                    <option <{if $smarty.get.day ==14}>selected<{/if}> value="14">14天</option>
                    <option <{if $smarty.get.day ==30}>selected<{/if}> value="30">30天</option>
                    <option  <{if $smarty.get.day==''}>selected<{/if}> value=''>按日期</option>
                </select>
            </div>
            <!-- 年份计算 -->
            <div class='form-group'>
                <input type="hidden" id='year_hidden' value='<{$smarty.get.year}>'>
                <select id='year' name="year">
                    <option value="">年份</option>
                </select>
            </div>
            <!-- 月份计算 -->
            <div class='form-group'>
                <select id='month' class="form-control" name="month">
                    <option value="">月份</option>
                    <option <{if $smarty.get.month ==1}>selected<{/if}> value="1">1月</option>
                    <option <{if $smarty.get.month ==2}>selected<{/if}> value="2">2月</option>
                    <option <{if $smarty.get.month ==3}>selected<{/if}> value="3">3月</option>
                    <option <{if $smarty.get.month ==4}>selected<{/if}> value="4">4月</option>
                    <option <{if $smarty.get.month ==5}>selected<{/if}> value="5">5月</option>
                    <option <{if $smarty.get.month ==6}>selected<{/if}> value="6">6月</option>
                    <option <{if $smarty.get.month ==7}>selected<{/if}> value="7">7月</option>
                    <option <{if $smarty.get.month ==8}>selected<{/if}> value="8">8月</option>
                    <option <{if $smarty.get.month ==9}>selected<{/if}> value="9">9月</option>
                    <option <{if $smarty.get.month ==10}>selected<{/if}> value="10">10月</option>
                    <option <{if $smarty.get.month ==11}>selected<{/if}> value="11">11月</option>
                    <option <{if $smarty.get.month ==12}>selected<{/if}> value="12">12月</option>
                </select>
            </div>
            <button type='submit' class='btn btn-sm btn-info'>搜索</button>
        </form>
    </div>
</div>
<div class='panel panel-default'>
    <div class='panel-heading'>趋势图</div>
    <div class='panel-body'>
        <div id='echart'></div>
    </div>
</div>
<input type="hidden" id='echart-x' value='<{$member_incre.xaxis}>'>
<input type="hidden" id='echart-y' value='<{$member_incre.yaxis}>'>
<script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script src="/public/wxapp/seqstatistics/js/seqstatistics.js"></script>

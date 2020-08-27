var echart = function echart() {
    var myChart = echarts.init(document.getElementById('echart'));
    var xaxis=JSON.parse(document.getElementById('echart-x').value);
    var yaxis=JSON.parse(document.getElementById('echart-y').value);

    var option = {
        title: {
            text: '会员增长趋势表',
            textAlign: 'auto',
            left: 'center'
        },
        legend: {
           data: ['人数'],
           left:'right'
        },
        tooltip: {
            trigger: 'axis'
        },
        xAxis: {
            name: '时间',
            nameLocation: 'end',
            nameGap: 30,
            type: 'category',
            data: xaxis,
            axisLabel:{
                rotate:xaxis.length>6?50:0
            }
        },
        yAxis: {
            name: '人数',
            nameGap: 30,
            nameLocation: 'center',
            type: 'value',
            minInterval:1,
        },
        series: [{
            data: yaxis,
            type: 'line',
            name:'人数',
            symbol: 'circle',
            label: {
                show: true,
                color: '#999',
                distance:8,
            },
            areaStyle: {
                color: '#d6e7ff',
            },
            lineStyle: {
                color: '#388cff'
            },
            itemStyle: {
                color: '#388cff'
            },
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
    $(window).resize(function() {
        myChart.resize();
    });
    $(window).load(function(){
        myChart.resize();
    });
}();
$(function(){
    // 设置年份
    let date=new Date();
    let select_year=date.getFullYear();
    let i=0;
    let dom_year=$('#year');
    let get_year=$('#year_hidden').val();
    while (i<10) {
        if(select_year==get_year)
            dom_year.append('<option selected value="'+select_year+'">'+select_year+'年</option');
        else
            dom_year.append('<option value="'+select_year+'">'+select_year+'年</option');
        select_year--;
        i++;
    }
    $('#day').change(function(){
        $('#year').val('');
        $('#month').attr('disabled','true');
    });
    $('#year').change(function(){
        let year=$(this).val();
        if(year){
            $('#month').removeAttr('disabled');
            $('#day').val('');
        }else
            $('#month').attr('disabled','true');
    });
});

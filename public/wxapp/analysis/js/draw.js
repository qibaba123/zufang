$(function() {
    $('.easy-pie-chart .team').each(function(){
        var w = $(this).width();
        var size = parseInt(w*0.9) || 150;
        $(this).css('line-height', size+"px");
        var barcolor = $(this).data('color') ||  '#ef1e25';
        $(this).easyPieChart({
            barColor: barcolor,
            trackColor: '#f5f5f5',
            scaleColor: false,
            lineCap: 'butt',
            lineWidth: parseInt(size/7),
            animate: 1000,
            size: size
        });
    });
});

function drawAxisChart(id, data, titleData, tipTitle) {
    var container = document.getElementById(id);
    var chart = echarts.init(container);
    var option = {
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: titleData
        },
        tooltip: {
            trigger: 'axis'
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: data,
            type: 'line',
            name: tipTitle,
            areaStyle: {
                color: '#d6e7ff',
            },
            lineStyle: {
                color: '#388cff'
            },
            itemStyle: {
                color: '#388cff'
            }
        }]
    };
    if (option && typeof option === "object") {
        chart.setOption(option, true);
    }
}
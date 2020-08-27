var echart = function echart() {
    var pie_real_data=new Array();
    var xaxis=new Array();
    var yaxis=new Array();
    var myChart = echarts.init(document.getElementById('echart'));
    var pie_data=document.getElementById('pie_data').value;
    var year=document.getElementById('year_hidden').value;
    var month=document.getElementById('month_hidden').value;
    var day=document.getElementById('day_hidden').value;
    var chart_type=document.getElementById('chart_type').value;
    var type=document.getElementById('type').value;
    var pie_json=JSON.parse(pie_data);
    if(pie_json){
        for(let i=0;i<pie_json.length;i++){
            let pie_item={};
            if(chart_type=='pie'){
                if(day!=0){
                    let start=pie_json[i].dates.substr(-2,2);
                    let end=(parseInt(start)+1).toString().padStart(2,0);
                    pie_item={value:pie_json[i].total,name:start+'点-'+end+'点'};
                }else
                    pie_item={value:pie_json[i].total,name:pie_json[i].dates};
                pie_real_data.push(pie_item);
            }else{
                if(day!=0){
                    let start=pie_json[i].dates.substr(-2,2);
                    let end=(parseInt(start)+1).toString().padStart(2,0);
                    xaxis.push(start+'点-'+end+'点');
                }else{
                    xaxis.push(pie_json[i].dates);
                }
                yaxis.push(pie_json[i].total);
            } 
        }
    }

   var option={};
    // 饼图
    if(chart_type=='pie'){
        option = {
            title : {
                text: '销售数据统计',
                subtext: (year!=0?year:'')+'/'+(month!=0?month:'')+'/'+(day!=0?day:''),
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            series : [
                {
                    name: '日期',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:pie_real_data,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
    }else{
         // 折线图
        var labelName='';
        if(type=='total')
            labelName='交易额';
        else if(type=='count')
            labelName='交易量';

        option = {
            title: {
                text: '销售数据统计',
                textAlign: 'auto',
                left: 'center'
            },
            legend: {
               data: [labelName],
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
                name: labelName,
                nameGap: 30,
                nameLocation: 'center',
                type: 'value',
                minInterval:1,
            },
            series: [{
                data: yaxis,
                type: 'line',
                name:labelName,
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
    }
    
   
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
    // 设置月份
    let month=$('#month');
    let j=1;
    let get_month=$('#month_hidden').val();
    while(j<=12){
        if(get_month==j)
            month.append('<option selected value="'+j+'">'+j+'月</option');
        else
             month.append('<option value="'+j+'">'+j+'月</option');
        j++;
    }
    $('#month').change(function(){
        let select_month=$(this).val();
        set_day(get_year,select_month);
    });
    // 日期
    set_day(get_year,get_month);
    function set_day(get_year,get_month){
        var t = mGetDate(get_year,get_month);
        let d=1;
        let day=$('#day');
        day.html('<option value="0">日期</option>');
        let get_day=$('#day_hidden').val();
        while(d<=t){
            if(get_day==d)
                day.append('<option selected value="'+d+'">'+d+'日</option');
            else
                 day.append('<option value="'+d+'">'+d+'日</option');
            d++;
        }
    }
    function mGetDate(year,month) {
        var d = new Date(year,month,0);
        return d.getDate();
    }

    // 筛选订单类型
    $('.finish').click(function(){
        let type=$(this).data('type');
        let params=getQueryVariable();
        params['finish_only']=type;
        location.href='/wxapp/seqstatistics/sale?'+$.param(params);
    });
    $('.chart_type').click(function(){
        let type=$(this).data('type');
        let params=getQueryVariable();
        params['chart_type']=type;
        location.href='/wxapp/seqstatistics/sale?'+$.param(params);
    });
    // 获取url参数
    function getQueryVariable(){
       let query = window.location.search.substring(1);
       let vars = query.split("&");
       let params={};
       for (let i=0;i<vars.length;i++) {
           let pair = vars[i].split("=");
           params[pair[0]]=pair[1];
       }
       return params;
    }
});
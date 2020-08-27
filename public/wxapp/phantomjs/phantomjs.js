var page = require('webpage').create();
page.onConsoleMessage = function(msg) {
    console.log(msg);
}
system = require('system');
var url;
var path;
if (system.args.length == 1) {
    phantom.exit();
} else {
    url = system.args[1];
    if (system.args.length == 3) {
        path = system.args[2];
    } else {
        path = "hello.png";
    }
}
if (path.indexOf("pdf") == -1) {
    var width = 750;
    var height = 18000;
} else {
    var width = 750;
    var height = 1500;
}
page.viewportSize = {
    'width': width,
    'height': height
}; //浏览器大小，宽度根据网页情况自行设置，高度可以随意，因为后面会滚动到底部
page.open(url, function(status) {
    if (status != "success") {
        phantom.exit();
    }
    var length;
    if (path.indexOf("pdf") == -1) {
        window.setTimeout(function() {
            length = page.evaluate(function() {
                //此函数在目标页面执行的，上下文环境非本phantomjs，所以不能用到这个js中其他变量
                var div    = document.getElementById('job-wrap'); //要截图的div的id
                var bc     = div.getBoundingClientRect();
                var top    = bc.top;
                var left   = bc.left;
                var width  = bc.width;
                var height = bc.height;
                window.scrollTo(0, 10000); //滚动到底部
                return [top, left, width, height];
            });
            page.clipRect = { //截图的偏移和宽高
                top: length[0],
                left: length[1] - 186, //多个375 需要向左平移375的一半的距离
                width: length[2] + 375 , //视窗宽度多了375 需要加上
                height: (length[3] > 30010 ? 2000 * 5 : length[3]) * 2  // 高度尽量高
            };
        }, 10);
    } else {
        window.setTimeout(function() {
            length = page.evaluate(function() {
                //此函数在目标页面执行的，上下文环境非本phantomjs，所以不能用到这个js中其他变量
                var div = document.getElementById('job-wrap'); //要截图的div的id
                var bc     = div.getBoundingClientRect();
                var top    = bc.top;
                var left   = bc.left;
                var width  = bc.width;
                var height = bc.height;
                window.scrollTo(0, 10000); //滚动到底部
                return [top, left, width, height];
            });
            page.clipRect = { //截图的偏移和宽高
                top: length[0],
                left: length[1],
                width: length[2],
                height: length[3]
            };
        }, 10);
    }

    window.setTimeout(function() {
        console.log('true');
        if (path.indexOf("pdf") == -1) {
            page.zoomFactor = 2;
        }
        page.render(path);
        phantom.exit();
    }, 10);
});
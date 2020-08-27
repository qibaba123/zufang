
    ;(function(win){
        var docEl = document.documentElement,tid,
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
    function refreshRem(){
        var clientWidth = docEl.getBoundingClientRect().width;
        if (!clientWidth) return;
        if(clientWidth>=640){
            docEl.style.fontSize = 85.333333+'px';
        }else{
            docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
        }
    }
    win.addEventListener('resize', function() {
        clearTimeout(tid);
        tid = setTimeout(refreshRem, 300);
    }, false);
    win.addEventListener('pageshow', function(e) {
        if (e.persisted) {
            clearTimeout(tid);
            tid = setTimeout(refreshRem, 300);
        }
    }, false);
    document.addEventListener('DOMContentLoaded',function(){
        clearTimeout(tid);
        tid = setTimeout(refreshRem,300);
    },false)
    refreshRem();
    })(window);




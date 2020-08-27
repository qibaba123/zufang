jQuery(document).ready(function($) {
    //参数page_index{int整型}表示当前的索引页
    var initPagination = function() {
        var pager_count = $("#pager-count-num").val();
        pager_count = parseInt(pager_count) > 0 ? parseInt(pager_count) : 10;
        var pager_total = $("#pager-total-num").val();
        pager_total = parseInt(pager_total) > 0 ? parseInt(pager_total) : 10;

        var current_page = location.href.match(/page=\d+/);
        if (current_page) {
            current_page = parseInt(current_page[0].split('=').pop());
        } else {
            current_page = 0;
        }
        var pager_all   = Math.ceil(pager_total/pager_count);
        if (pager_all > 1) {
            // 创建分页
            $("#pager-tpl").pagination(pager_total, {
                num_edge_entries: $(window).width() > 500 ? 2 : 1, //边缘页数
                num_display_entries: $(window).width() > 400 ? 3 : 2, //主体页数
                callback: pageselectCallback,
                items_per_page: pager_count, //每页显示1项
                current_page : current_page,
                prev_text:"上一页",
                next_text:"下一页",
                jump_text:"跳转",
            }).show();
        }
    }();

    function pageselectCallback(page_index, jq){
        var base_url = location.href;
        if (/page=\d+/.test(base_url)) {
            var new_url = base_url.replace(/page=\d+/, 'page='+page_index);
        } else {
            var new_url = base_url + "&page=" + page_index;
        }
        window.location.replace(new_url);
        return false;
    }
});
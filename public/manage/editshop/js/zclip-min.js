$(function() {
	$(".j-copy").zclip({
		path: "/public/manage/editshop/js/ZeroClipboard.swf",
		copy: function() {
			return $(this).data("copy")
		},
		afterCopy: function() {
			HYD.hint("success", "\u5185\u5bb9\u5df2\u6210\u529f\u590d\u5236\u5230\u60a8\u7684\u526a\u8d34\u677f\u4e2d")
		}
	})
});
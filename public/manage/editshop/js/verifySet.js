$(function() {
	function e(e) {
		0 == e ? ($("#verify-set-prev").addClass("hide"), $("#verify-set-save").addClass("hide"), $("#verify-set-next").removeClass("hide")) : 2 == e ? ($("#verify-set-next").addClass("hide"), $("#verify-set-save").removeClass("hide")) : ($("#verify-set-prev").removeClass("hide"), $("#verify-set-next").removeClass("hide"), $("#verify-set-save").addClass("hide")), $(".verify-set-div").addClass("hide"), $(".verify-set-div").eq(e).removeClass("hide"), 1 == e && $(".j-copy").zclip({
			path: "/Public/plugins/zclip/ZeroClipboard.swf",
			copy: function() {
				return $(this).data("copy")
			},
			afterCopy: function() {
				HYD.hint("success", "内容已成功复制到您的剪贴板中")
			}
		})
	}! function() {
		var e, t = function() {
			/*隐藏系统设置弹出框*/
			/*$.jBox.show({
				width: 700,
				height: 600,
				title: "系统设置",
				content: _.template($("#tpl_verify_set").html()),
				onOpen: function() {
					e && clearInterval(e)
				},
				onClosed: function() {
					e = setInterval(t, 6e4)
				}
			})*/
		};
		1 == isFirstLogin ? t() : e = setInterval(t, 6e4)
	}(), $(".jbox-buttons").hide(), $(document).on("click", "#verify-set-tabs a", function() {
		var t = $(this).index();
		e(t)
	}), $(document).on("click", "#verify-set-prev", function() {
		var e = parseInt($("#verify-set-tabs a.active").index());
		$("#verify-set-tabs a").eq(e - 1).click()
	}), $(document).on("click", "#verify-set-next", function() {
		var e = parseInt($("#verify-set-tabs a.active").index()),
			t = $("#form-set").serialize() + "&i=" + e;
		$.post("/System/verifySetHandle/i/" + e, t, function(e) {}), $("#verify-set-tabs a").eq(e + 1).click()
	}), _QV_ = "%E6%9D%AD%E5%B7%9E%E5%90%AF%E5%8D%9A%E7%A7%91%E6%8A%80%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E7%89%88%E6%9D%83%E6%89%80%E6%9C%89", $(document).on("click", "#verify-set-save", function() {
		var e = $("#form-set").serialize() + "&act=sub";
		return $.jBox.showloading(), $.post("/Home/verifySet", e, function(e) {
			$(".jbox-close").click(), 1 == e.status ? (HYD.hint("success", e.msg), setTimeout(function() {
				window.location.reload()
			}, 1e3)) : HYD.hint("danger", e.msg), $.jBox.hideloading()
		}), !1
	})
});
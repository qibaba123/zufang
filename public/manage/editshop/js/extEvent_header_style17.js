$(function() {
	Defaults = {
		17: {
			page: {
				title: "店铺首页"
			},
			PModules: [{
				id: 17,
				type: "Header_style17",
				draggable: !1,
				sort: 0,
				content: {
					bg: "",
					dataset: [{
						link: "/Shop/index",
						linkType: 6,
						showtitle: "首页",
						title: "",
						subtitle: "HOME"
					}, {
						link: "/Shop/index",
						linkType: 6,
						showtitle: "新品上市",
						title: "",
						subtitle: "NEWS"
					}, {
						link: "/Shop/index",
						linkType: 6,
						showtitle: "热卖",
						title: "",
						subtitle: "HOT"
					}, {
						link: "/Shop/index",
						linkType: 6,
						showtitle: "推荐",
						title: "",
						subtitle: "RECOMMEND"
					}]
				}
			}],
			LModules: []
		}
	}, _QV_ = "%E6%9D%AD%E5%B7%9E%E5%90%AF%E5%8D%9A%E7%A7%91%E6%8A%80%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E7%89%88%E6%9D%83%E6%89%80%E6%9C%89", HYD.DIY.Unit.event_typeHeader_style17 = function(t, e) {
		var i = e.dom_conitem,
			n = t,
			l = $("#tpl_diy_con_typeHeader_style17").html(),
			a = $("#tpl_diy_ctrl_typeHeader_style17").html(),
			s = function() {
				var t = $(_.template(l, e));
				i.find(".Header_style17_panel").remove().end().append(t);
				var s = $(_.template(a, e));
				n.empty().append(s), HYD.DIY.Unit.event_typeHeader_style17(n, e)
			};
		n.find(".j-modify-bg").click(function() {
			HYD.popbox.ImgPicker(function(t) {
				e.content.bg = t[0], s()
			})
		}), n.find(".j-moveup").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			if (0 != t) {
				var i = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t - 1, 0, i), s()
			}
		}), n.find(".j-movedown").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				i = e.content.dataset.length;
			if (t != i - 1) {
				var n = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t + 1, 0, n), s()
			}
		}), n.find(".ctrl-item-list-add").click(function() {
			var t = {
				link: "/Shop/index",
				linkType: 6,
				showtitle: "首页",
				title: "",
				subtitle: "HOME"
			};
			e.content.dataset.push(t), s()
		}), n.find(".j-del").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset.splice(t, 1), s()
		}), n.find("input[name='showtitle'],input[name='subtitle']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				i = $(this).val(),
				n = $(this).attr("name");
			e.content.dataset[t][n] = i, s()
		}), n.find(".j-navDplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(i, n) {
					e.content.dataset[t].title = i.title, e.content.dataset[t].link = i.link, e.content.dataset[t].linkType = n, s()
				}
			})
		}), n.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		})
	}
});
$(function() {
	HYD.DIY = HYD.DIY ? HYD.DIY : {}, HYD.DIY.Unit = HYD.DIY.Unit ? HYD.DIY.Unit : {}, HYD.DIY.PModules = HYD.DIY.PModules ? HYD.DIY.PModules : [], HYD.DIY.LModules = HYD.DIY.LModules ? HYD.DIY.LModules : [];
	var t = $("#diy-contain"),
		e = $("#diy-ctrl");
	HYD.DIY.constant = {
		diyoffset: $(".diy").offset()
	}, HYD.DIY.getTimestamp = function() {
		var t = new Date;
		return "" + t.getFullYear() + parseInt(t.getMonth() + 1) + t.getDate() + t.getHours() + t.getMinutes() + t.getSeconds() + t.getMilliseconds()
	}, HYD.DIY.add = function(e, n) {
		e.content || (e.content = {}), "undefined" == typeof e.content.modulePadding && (e.content.modulePadding = 5);
		var i = _.template($("#tpl_diy_con_type" + e.type).html(), e),
			o = _.template($("#tpl_diy_conitem").html(), {
				html: i
			}),
			a = $(o);
		e.dom_conitem = a;
		var l = a.find(".diy-conitem-action"),
			c = (l.find(".j-edit"), l.find(".j-del"));
		l.click(function() {
			$(".diy-conitem-action").removeClass("selected"), $(this).addClass("selected"), HYD.DIY.edit(e)
		});
		var d = "";
		return e.draggable ? (c.click(function() {
			return HYD.DIY.del(e), !1
		}), d = ".drag") : (c.remove(), d = ".nodrag"), t.find(d).append(a), n = n ? n : !1, n && l.click(), e.draggable ? HYD.DIY.LModules.push(e) : HYD.DIY.PModules.push(e), !1
	}, HYD.DIY.edit = function(t) {
		t.content || (t.content = {}), "undefined" == typeof t.content.modulePadding && (t.content.modulePadding = 5), e.find(".diy-ctrl-item[data-origin='item']").remove();
		var n = $("#tpl_diy_ctrl").html(),
			i = _.template($("#tpl_diy_ctrl_type" + t.type).html(), t),
			o = _.template(n, {
				html: i
			}),
			a = $(o);
		return e.append(a), HYD.DIY.repositionCtrl(t.dom_conitem, a), HYD.DIY.bindEvents(a, t), a.show().siblings(".diy-ctrl-item").hide(), !1
	}, HYD.DIY.repositionCtrl = function(t, e) {
		var n = t.offset().top,
			i = n - HYD.DIY.constant.diyoffset.top;
		e.css("marginTop", i), $("html,body,.main-content").animate({
			scrollTop: i
		}, 300)
	}, HYD.DIY.del = function(t) {
		return t ? ($.jBox.show({
			title: "提示",
			content: _.template($("#tpl_jbox_simple").html(), {
				content: "删除后将不可恢复，是否继续？"
			}),
			btnOK: {
				onBtnClick: function(n) {
					$.jBox.close(n);
					for (var i = HYD.DIY.LModules, o = HYD.DIY.LModules.length, a = 0; o > a; a++)
						if (i[a].id == t.id) {
							i.splice(a, 1);
							break
						}
					t.dom_conitem.remove(), e.find(".diy-ctrl-item[data-origin='item']").remove()
				}
			}
		}), !1) : void 0
	}, HYD.DIY.bindEvents = function(t, e) {
		10 != e.type && HYD.DIY.Unit["event_type" + e.type](t, e)
	}, HYD.DIY.reCalcPModulesSort = function() {
		_.each(HYD.DIY.LModules, function(t, e) {
			t.sort = t.dom_conitem.index()
		})
	}, HYD.DIY.Unit.getData = function() {
		HYD.DIY.reCalcPModulesSort();
		var t = {
			page: {},
			PModules: {},
			LModules: {}
		};
		t.page.title = $(".j-pagetitle-ipt").val(), t.page.subtitle = $(".j-pagesubtitle-ipt").val(), t.page.view_pic = $(".j-view_pic-ipt").prop("src"), t.page.praise_num = $(".j-pagepraisenum").val(), t.PModules = HYD.DIY.PModules, t.page.goto_time = $(".j-gototime-ipt").val(), t.page.hasMargin = $(".j-page-hasMargin:checked").val() || 1, t.page.backgroundColor = $("#j-page-backgroundColor").data("color") || "#f8f8f8";
		for (var e = [], n = 0; n < HYD.DIY.LModules.length; n++) {
			var i = HYD.DIY.LModules[n];
			"" != i && (e[i.sort] = i)
		}
		t.LModules = e;
		var i = $.extend(!0, {}, t);
		return _.each(i.LModules, function(t) {
			t.dom_conitem = null, t.dom_ctrl = null, t.ue = null
		}), _.each(i.PModules, function(t) {
			t.dom_conitem = null, t.dom_ctrl = null, t.ue = null
		}), i
	}, HYD.DIY.Unit.html_encode = function(t) {
		var e = "";
		return 0 == t.length ? "" : (e = t.replace(/&/g, "&amp;"), e = e.replace(/</g, "&lt;"), e = e.replace(/>/g, "&gt;"), e = e.replace(/ /g, "&nbsp;"), e = e.replace(/\'/g, "&#39;"), e = e.replace(/\"/g, "&quot;"))
	}, HYD.DIY.Unit.html_decode = function(t) {
		var e = "";
		return 0 == t.length ? "" : (e = t.replace(/&amp;/g, "&"), e = e.replace(/&lt;/g, "<"), e = e.replace(/&gt;/g, ">"), e = e.replace(/&nbsp;/g, " "), e = e.replace(/&#39;/g, "'"), e = e.replace(/&quot;/g, '"'))
	}
}), $(function() {
	var t = function(t) {
		var e = t;
		return e = e.replace(/\<script\>/, ""), e = e.replace(/\<\/script\>/, "")
	};
	$(document).on("change", ".input,.diy-videowebsite input", function() {
		var t = $(this).val();
		t = t.replace(/\</, "&lt;").replace(/\</, "&lt;"), t = t.replace(/\>/, "&gt;").replace(/\>/, "&gt;"), t = t.replace(/\//, "/"), $(this).val(t)
	}), HYD.DIY.Unit.event_type1 = function(e, n) {
		var i = n.dom_conitem,
			o = e;
		n.ue && n.ue.destroy(), n.ue = UE.getEditor("editor" + n.id), n.ue.ready(function() {
			n.ue.setContent(HYD.DIY.Unit.html_decode(n.content.fulltext)), n.ue.focus(!0);
			var e = function() {
				var e = n.ue.getContent(),
					e = t(e);
				"" == e && (e = "<p>『富文本编辑器』</p>"), i.find(".fulltext").html(e), n.content.fulltext = HYD.DIY.Unit.html_encode(e)
			};
			n.ue.addListener("selectionchange", e), n.ue.addListener("contentChange", e)
		}), o.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: n.content.modulePadding,
			slide: function(t, e) {
				i.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), o.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, e) {
				n.content.modulePadding = parseInt(e.value)
			}
		})
	}, HYD.DIY.Unit.event_type2 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type2").html(),
			a = $("#tpl_diy_ctrl_type2").html();
		e.dom_ctrl = t;
		var l = function() {
			var t = $(_.template(o, e));
			n.find(".members_con").remove().end().append(t);
			var l = $(_.template(a, e));
			i.empty().append(l), HYD.DIY.Unit.event_type2(i, e)
		};
		i.find("input[name='title'],input[name='direction'],input[name='style']").change(function() {
			var t = $(this).val(),
				n = $(this).attr("name");
			e.content[n] = t, l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type3 = function(t, e) {
		var n = e.dom_conitem,
			i = t;
		e.dom_ctrl = t;
		var o = function() {
				HYD.popbox.ModulePicker(function(t) {
					n.find(".type3_custModule").text(t.title), i.find(".type3_custModule_ctrl").text(t.title), e.content = t
				})
			},
			a = function() {
				HYD.popbox.ModulePicker(function(t) {
					n.find(".type3_custModule").text(t.title);
					var a = _.template($("#tpl_diy_ctrl_type3_modify").html(), {
							content: t
						}),
						l = $(a);
					l.filter(".j-btn-modify").click(o), i.find(".form-controls").empty().append(l), e.content = t
				})
			};
		i.find(".j-btn-add").click(a), i.find(".j-btn-modify").click(o)
	}, HYD.DIY.Unit.event_type4 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type4").html(),
			a = $("#tpl_diy_ctrl_type4").html();
		e.dom_ctrl = t;
		var l = function(t) {
				var l = $(_.template(o, e));
				n.find(".members_con").remove().end().append(l);
				var c = $(_.template(a, e));
				i.empty().append(c), HYD.DIY.Unit.event_type4(i, e), t && t()
			},
			c = function() {
				n.find(".mingoods,.biggoods,.b_mingoods").each(function(t, e) {
					var n = $(this),
						i = n.find("img").width();
					n.find("img").closest("a").height(i)
				})
			};
		i.find("input[name='layout']").change(function() {
			var t = $(this).val();
			e.content.layout = t, l(c)
		}), i.find("input[name='goodstyle']").change(function() {
			var t = $(this).val();
			e.content.goodstyle = t, l(c)
		}), i.find("input[name='layoutstyles']").change(function() {
			var t = $(this).val();
			e.content.layoutstyles = t, l(c)
		}), i.find("input[name='showName']").change(function() {
			var t = $(this).val();
			e.content.showName = t, l(c)
		}), i.find("input[name='showIco']").change(function() {
			var t = $(this).is(":checked");
			e.content.showIco = t, l(c)
		}), i.find("input[name='showPrice']").change(function() {
			var t = $(this).is(":checked");
			e.content.showPrice = t, l(c)
		}), i.find("input[name='priceBold']").change(function() {
			var t = $(this).val();
			e.content.priceBold = t, l(c)
		}), i.find("input[name='goodstxt']").change(function() {
			var t = $(this).val();
			n.find(".goods-btn a").text($(this).val()), e.content.goodstxt = t, l(c)
		}), i.find("input[name='multiLine']").change(function() {
			$(this).attr("checked") ? ($(this).attr("checked", "true"), e.content.titleLine = 1) : ($(this).removeAttr("checked"), e.content.titleLine = 0), l(c)
		}), i.find(".j-delgoods").click(function() {
			var t = $(this).parents("li").index();
			return e.content.goodslist.splice(t, 1), l(c), !1
		}), i.find(".j-addgoods").click(function() {
			var t = i.find("input[name=goods_ids]").val().split(",");
			return $.selectGoods({
				selectMod: 2,
				selectIds: t,
				callback: function(t, n) {
					e.content.goodslist = e.content.goodslist.concat(t), l(c)
				}
			}), !1
		}), i.find(".img-list>li .img-move-left").on("click", function() {
			var t = $(this),
				n = t.closest("li").index(),
				i = t.closest("li");
			if (0 != n) {
				n--, t.closest("ul").find("li").eq(n).before(i);
				var o = e.content.goodslist.slice(n + 1, n + 2)[0];
				e.content.goodslist.splice(n + 1, 1), e.content.goodslist.splice(n, 0, o), l(c)
			}
			return !1
		}), i.find(".img-list>li .img-move-right").on("click", function() {
			var t = $(this),
				n = t.closest("ul").find("li").length - 1,
				i = t.closest("li").index(),
				o = t.closest("li");
			if (i != n - 1) {
				i++, t.closest("ul").find("li").eq(i).after(o);
				var a = e.content.goodslist.slice(i, i + 1)[0];
				e.content.goodslist.splice(i, 1), e.content.goodslist.splice(i - 1, 0, a), l(c)
			}
			return !1
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type5 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type5").html(),
			a = $("#tpl_diy_ctrl_type5").html();
		e.dom_ctrl = t;
		var l = function() {
			var t = $(_.template(o, e));
			n.find(".members_con").remove().end().append(t);
			var l = $(_.template(a, e));
			i.empty().append(l), HYD.DIY.Unit.event_type5(i, e)
		};
		i.find("input[name='layout']").change(function() {
			var t = $(this).val();
			e.content.layout = t, l()
		}), i.find("input[name='goodstyle']").change(function() {
			var t = $(this).val();
			e.content.goodstyle = t, l()
		}), i.find("input[name='layoutstyles']").change(function() {
			var t = $(this).val();
			e.content.layoutstyles = t, l()
		}), i.find("input[name='showName']").change(function() {
			var t = $(this).is(":checked");
			e.content.showName = t, l()
		}), i.find("input[name='goodstxt']").change(function() {
			var t = $(this).val();
			n.find(".goods-btn a").text($(this).val()), e.content.goodstxt = t, l()
		}), i.find("input[name='showIco']").change(function() {
			var t = $(this).is(":checked");
			e.content.showIco = t, l()
		}), i.find("input[name='showPrice']").change(function() {
			var t = $(this).is(":checked");
			e.content.showPrice = t, l()
		}), i.find(".j-btn-add,.j-btn-modify").click(function() {
			HYD.popbox.GoodsAndGroupPicker("group", function(t) {
				e.content.group = t, l()
			})
		}), i.find('input[name="goodsize"]').change(function(t) {
			var n = $(this),
				i = n.val();
			e.content.goodsize = i, l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type6 = function(t, e) {
		var n = e.dom_conitem,
			i = t;
		$("#tpl_diy_con_type6").html(), $("#tpl_diy_ctrl_type6").html();
		e.dom_ctrl = t, i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type7 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type7").html(),
			a = $("#tpl_diy_ctrl_type7").html();
		e.dom_ctrl = t;
		var l = function() {
			var t = $(_.template(o, e));
			n.find(".members_con").remove().end().append(t);
			var l = $(_.template(a, e));
			i.empty().append(l), HYD.DIY.Unit.event_type7(i, e)
		};
		i.find("input[name='title']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].showtitle = $(this).val(), l()
		}), i.find(".droplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(n, i) {
					e.content.dataset[t].title = n.title, e.content.dataset[t].showtitle = n.title, e.content.dataset[t].link = n.link, e.content.dataset[t].linkType = i, l()
				}
			})
		}), i.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		}), i.find(".j-moveup").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			if (0 != t) {
				var n = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t - 1, 0, n), l()
			}
		}), i.find(".j-movedown").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = e.content.dataset.length;
			if (t != n - 1) {
				var i = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t + 1, 0, i), l()
			}
		}), i.find(".ctrl-item-list-add").click(function() {
			var t = {
				linkType: 0,
				link: "",
				title: "",
				showtitle: ""
			};
			e.content.dataset.push(t), l()
		}), i.find(".j-del").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset.splice(t, 1), l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type8 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type8").html(),
			a = $("#tpl_diy_ctrl_type8").html();
		e.dom_ctrl = t;
		var l = function(t) {
			var l = $(_.template(o, e));
			n.find(".members_con").remove().end().append(l);
			var c = $(_.template(a, e));
			i.empty().append(c), HYD.DIY.Unit.event_type8(i, e), t && t()
		};
		i.find("input[name='layout'],input[name='layout1_style'],input[name='hasImgMargin']").change(function() {
			var t = $(this).attr("name");
			e.content[t] = $(this).val(), l()
		}), i.find("input[name='title']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].showtitle = $(this).val(), l()
		}), i.find(".droplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(n, i) {
					e.content.dataset[t].title = n.title, e.content.dataset[t].showtitle = n.title, e.content.dataset[t].link = n.link, e.content.dataset[t].linkType = i, n.pic && "" != n.pic && (n.is_compress ? e.content.dataset[t].pic = n.pic + "480x480" : e.content.dataset[t].pic = n.pic), l()
				}
			})
		}), i.find(".j-selectimg").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.ImgPicker(function(n) {
				e.content.dataset[t].pic = n[0], l()
			})
		}), i.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		}), i.find(".j-moveup").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			if (0 != t) {
				var n = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t - 1, 0, n), l()
			}
		}), i.find(".j-movedown").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = e.content.dataset.length;
			if (t != n - 1) {
				var i = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t + 1, 0, i), l()
			}
		}), i.find(".ctrl-item-list-add").click(function() {
			var t = {
				linkType: 0,
				link: "#",
				showtitle: "导航名称",
				titleBackgroundColor: "#FE9303",
				pic: "/public/manage/editshop/images/waitupload.png"
			};
			e.content.dataset.push(t), l()
		}), i.find(".j-del").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset.splice(t, 1), l()
		}), i.find(".j-imgNav-cp").each(function(t, n) {
			var i = $(this).data("#FE9303");
			$(this).ColorPicker({
				color: i,
				onShow: function(t) {
					return $(t).fadeIn(500), !1
				},
				onHide: function(t) {
					return $(t).fadeOut(500), !1
				},
				onChange: function(n, i, o) {
					var i = "#" + i;
					e.content.dataset[t].titleBackgroundColor = i, l()
				}
			})
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type9 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type9").html(),
			a = $("#tpl_diy_ctrl_type9").html();
		e.dom_ctrl = t;
		var l = function() {
			var t = $(_.template(o, e));
			n.find(".members_con").remove().end().append(t);
			var l = $(_.template(a, e));
			i.empty().append(l), HYD.DIY.Unit.event_type9(i, e)
		};
		i.find("input[name='title']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].showtitle = $(this).val(), l()
		}), i.find("input[name='showType']").change(function() {
			e.content.showType = $(this).val(), l()
		}), i.find("input[name='space']").change(function() {
			e.content.space = $(this).val(), l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 20,
			step: 1,
			animate: "fast",
			value: e.content.margin,
			slide: function(t, e) {
				n.find(".members_imgad ul li").css("margin-bottom", e.value), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.margin = parseInt(n.value)
			}
		}), i.find(".droplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(n, i) {
					e.content.dataset[t].title = n.title, e.content.dataset[t].showtitle = n.title, e.content.dataset[t].link = n.link, e.content.dataset[t].linkType = i, e.content.dataset[t].is_compress = n.is_compress, n.pic && "" != n.pic && (n.is_compress ? e.content.dataset[t].pic = n.pic + "480x480" : e.content.dataset[t].pic = n.pic), l()
				}
			})
		}), i.find(".j-selectimg").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.ImgPicker(function(n) {
				e.content.dataset[t].pic = n[0], l()
			})
		}), i.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		}), i.find(".j-moveup").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			if (0 != t) {
				var n = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t - 1, 0, n), l()
			}
		}), i.find(".j-movedown").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = e.content.dataset.length;
			if (t != n - 1) {
				var i = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t + 1, 0, i), l()
			}
		}), i.find(".ctrl-item-list-add").click(function() {
			var t = {
				linkType: 0,
				link: "",
				title: "",
				showtitle: "",
				pic: ""
			};
			e.content.dataset.push(t), l()
		}), i.find(".j-del").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset.splice(t, 1), l()
		}), i.find(".j-slider2").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight2").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type11 = function(t, e) {
		var n = e.dom_conitem,
			i = t;
		$("#tpl_diy_con_type11").html(), $("#tpl_diy_ctrl_type11").html();
		e.dom_ctrl = t;
		i.find("#slider").slider({
			min: 10,
			max: 100,
			step: 1,
			animate: "fast",
			value: e.content.height,
			slide: function(t, e) {
				n.find(".custom-space").css("height", e.value), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.height = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type12 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type12").html(),
			a = $("#tpl_diy_ctrl_type12").html();
		e.dom_ctrl = t;
		var l = function() {
			var t = $(_.template(o, e));
			n.find(".members_con").remove().end().append(t);
			var l = $(_.template(a, e));
			i.empty().append(l), HYD.DIY.Unit.event_type12(i, e)
		};
		i.find("input[name='navtitle']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = $(this).val();
			e.content.dataset[t].showtitle = n, l()
		}), i.find(".droplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(n, i) {
					e.content.dataset[t].title = n.title, e.content.dataset[t].showtitle = n.title, e.content.dataset[t].link = n.link, e.content.dataset[t].linkType = i, n.pic && "" != n.pic && (e.content.dataset[t].pic = n.pic), l()
				}
			})
		}), i.find(".j-selectimg").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.ImgPicker(function(n) {
				e.content.dataset[t].pic = n[0], l()
			})
		}), i.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		}), i.find("select[name='navbgColor']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = $(this).val();
			e.content.dataset[t].bgColor = n, l()
		}), i.find('input[name="showstyle"]').change(function(t) {
			var n = $(this),
				i = n.val();
			e.content.style = i, l()
		}), i.find('input[name="marginstyle"]').change(function(t) {
			var n = $(this),
				i = n.val();
			e.content.marginstyle = i, l()
		}), i.find(".ctrl-item-list-li").each(function(t, n) {
			var i = $(this);
			i.find(".colorPicker").each(function(n, i) {
				var o = $(this);
				if (0 == n) {
					var a = ($(this).data("name"), $(this).data("color"));
					o.ColorPicker({
						color: a,
						onShow: function(t) {
							return $(t).fadeIn(100), !1
						},
						onHide: function(t) {
							return $(t).fadeOut(100), l(), !1
						},
						onChange: function(n, i, a) {
							var i = "#" + i;
							o.css("background-color", i), e.content.dataset[t].bgColor = i
						}
					})
				} else {
					var a = ($(this).data("name"), $(this).data("color"));
					o.ColorPicker({
						color: a,
						onShow: function(t) {
							return $(t).fadeIn(100), !1
						},
						onHide: function(t) {
							return $(t).fadeOut(100), l(), !1
						},
						onChange: function(n, i, a) {
							var i = "#" + i;
							o.css("background-color", i), e.content.dataset[t].fotColor = i
						}
					})
				}
			})
		}), i.find(".j-uploadIcon").click(function(t) {
			var n = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.ImgPicker(function(t) {
				e.content.dataset[n].pic = t[0], l()
			})
		}), i.find(".j-navModifyIcon").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.IconPicker(function(n) {
				e.content.dataset[t].pic = n[0], l()
			})
		}), i.find(".j-moveup").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			if (0 != t) {
				var n = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t - 1, 0, n), l()
			}
		}), i.find(".j-movedown").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = e.content.dataset.length;
			if (t != n - 1) {
				var i = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t + 1, 0, i), l()
			}
		}), i.find(".ctrl-item-list-add").click(function() {
			var t = $(this).closest("ul").children("li").length;
			if (6 > t) {
				var n = {
					linkType: 0,
					link: "",
					title: "",
					showtitle: "内容",
					pic: "",
					bgColor: "#07a0e7",
					fotColor: "#fff"
				};
				e.content.dataset.push(n), l()
			} else HYD.hint("danger", "顶部菜单不可多于5个")
		}), i.find(".j-del").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset.splice(t, 1), l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type13 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type13").html(),
			a = $("#tpl_diy_ctrl_type13").html();
		e.dom_ctrl = t;
		var l = function(t) {
				var l = $(_.template(o, e));
				n.find(".members_con").remove().end().append(l);
				var c = $(_.template(a, e));
				i.empty().append(c), HYD.DIY.Unit.event_type13(i, e), t && t()
			},
			c = function() {
				var t = $("input[name=layout]:checked").val();
				1 == parseInt(t) ? $(".board3").each(function(t, e) {
					var n = $(this),
						i = n.width();
					n.height(i).css("overflow", "hidden")
				}) : $(".board3").each(function(t, e) {
					var n = $(this),
						i = n.width();
					(n.hasClass("small_board") || !n.hasClass("big_board")) && n.children("span").attr("style", "height:" + i + "px !important;overflow:hidden;"), n.hasClass("big_board") && n.children("span").attr("style", "height:" + (2 * i + 9) + "px !important;overflow:hidden;")
				})
			};
		i.find('input[name="layout"]').change(function(t) {
			var n = $(this),
				i = n.val();
			e.content.layout = i, e.content.version && 2 == e.content.version ? l() : l(c)
		}), i.find("input[name='title']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].title = $(this).val(), l()
		}), i.find(".droplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(n, i) {
					e.content.dataset[t].title = n.title, e.content.dataset[t].link = n.link, e.content.dataset[t].linkType = i, e.content.dataset[t].is_compress = n.is_compress, n.pic && "" != n.pic && (e.content.dataset[t].pic = n.pic), l()
				}
			})
		}), i.find(".j-selectimg").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.ImgPicker(function(n) {
				n[0].indexOf("@") < 0 ? (e.content.dataset[t].pic = n[0] + "@", e.content.dataset[t].is_compress = 1) : (e.content.dataset[t].pic = n[0], e.content.dataset[t].is_compress = 0), e.content.version && 2 == e.content.version ? l() : l(c)
			})
		}), i.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		}), i.find(".j-showTitle").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].showTitle = $(this).val(), l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type14 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type14").html(),
			a = $("#tpl_diy_ctrl_type14").html();
		e.dom_ctrl = t;
		var l = function(t) {
				var l = $(_.template(o, e));
				n.find(".members_con").remove().end().append(l);
				var c = $(_.template(a, e));
				i.empty().append(c), HYD.DIY.Unit.event_type14(i, e), l.find("iframe").attr("src", t)
			},
			c = function(t) {
				var e, n, i, o = /vid\=([^\&]*)($|\&)+/g,
					a = /sid\/\w*.*?/g;
				return n = t.match(o), i = t.match(a), n && (n = n.toString(), e = "http://v.qq.com/iframe/player.html?" + n + "&tiny=0&auto=0"), i && (i = i.toString(), i = i.split("/v.swf"), i = i.toString(), i = i.replace("sid/", "").replace(",", ""), e = "http://player.youku.com/embed/" + i), null === n && null === i ? (HYD.hint("danger", "请填写正确的视频网址"), !1) : e
			};
		i.find(".j-getvideo").click(function(t) {
			var n = $(this).prev("input").val();
			e.content.website = n;
			var i = c(n);
			l(i)
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type15 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type15").html(),
			a = $("#tpl_diy_ctrl_type15").html();
		e.dom_ctrl = t;
		var l = function(t) {
				var l = $(_.template(o, e));
				n.find(".members_con").remove().end().append(l);
				var c = $(_.template(a, e));
				i.empty().append(c), HYD.DIY.Unit.event_type15(i, e)
			},
			c = function(t) {
				var n, i = $("#tpl_popbox_Audio").html(),
					o = $(i),
					a = function(t, e) {
						var i = function(t) {
							if (n = t.list, n && n.length) {
								var i = _.template($("#tpl_popbox_ImgPicker_audio").html(), {
										dataset: n
									}),
									l = $(i);
								l.filter("li").click(function() {
									$(this).addClass("selected").siblings("li").removeClass("selected")
								}), l.find(".audio-name").click(function(t) {
									return !1
								}), l.find(".j-get-edit-name").click(function(t) {
									return $(this).hide().siblings(".j-edit-name").show(), $(this).siblings(".j-edit-name").find("input").focus(), !1
								}), l.find(".j-getAudioName").click(function(t) {
									var e = $(this),
										n = e.siblings('input[name="audioName"]').val(),
										i = e.data("id");
									$.ajax({
										url: "/Design/renameImg",
										type: "POST",
										dataType: "json",
										data: {
											file_id: i,
											file_name: n
										},
										success: function(t) {
											1 == t.status && (HYD.hint("success", "恭喜您，修改音频名称成功！"), e.closest(".j-edit-name").hide().siblings(".j-curname").html(n))
										}
									})
								}), o.find(".imgpicker-list").empty().append(l);
								var c = t.page,
									d = $(c);
								d.filter("a:not(.disabled,.cur)").click(function() {
									var t = $(this).attr("href"),
										e = t.split("/");
									return e = e[e.length - 1], e = e.replace(/.html/, ""), a(e), !1
								}), o.find(".paginate").empty().append(d)
							} else o.find(".imgpicker-list").append("<p class='txtCenter'>对不起，暂无音频</p>");
							e && e()
						};
						$.ajax({
							url: "/public/manage/editshop/json/Design/getMediaList.json",
							type: "post",
							dataType: "json",
							data: {
								p: parseInt(t),
								type: "voice"
							},
							success: function(t) {
								1 == t.status ? i(t) : HYD.hint("danger", "对不起，获取数据失败：" + t.msg)
							}
						})
					},
					c = function(t) {
						var n = [],
							i = [];
						o.find("#imgpicker_upload_input").uploadify({
							debug: !1,
							auto: !0,
							formData: {
								PHPSESSID: $.cookie("PHPSESSID"),
								type: "voice"
							},
							width: 60,
							height: 60,
							multi: !0,
							swf: "/public/manage/editshop/js/uploadify.swf",
							uploader: "/Design/uploadMedia",
							buttonText: "+",
							fileSizeLimit: "5MB",
							fileTypeExts: "*.mp3; *.wma; *.wav; *.amr",
							onSelectError: function(t, e, n) {
								switch (e) {
									case -100:
										HYD.hint("danger", "对不起，系统只允许您一次最多上传10个文件");
										break;
									case -110:
										HYD.hint("danger", "对不起，文件 [" + t.name + "] 大小超出5MB！");
										break;
									case -120:
										HYD.hint("danger", "文件 [" + t.name + "] 大小异常！");
										break;
									case -130:
										HYD.hint("danger", "文件 [" + t.name + "] 类型不正确！")
								}
							},
							onFallback: function() {
								HYD.hint("danger", "您未安装FLASH控件，无法上传图片！请安装FLASH控件后再试。")
							},
							onUploadSuccess: function(t, e, a) {
								var e = $.parseJSON(e),
									l = $("#tpl_popbox_ImgPicker_audio2").html(),
									c = o.find(".imgpicker-upload-preview"),
									d = e.file_path,
									s = e.file_id;
								n.push(d), i.push(s);
								var r = _.template(l, {
										url: d,
										id: s
									}),
									p = $(r);
								p.find(".j-imgpicker-upload-btndel").click(function() {
									var t = o.find(".imgpicker-upload-preview li").index($(this).parent("li"));
									p.fadeOut(300, function() {
										n.splice(t, 1), $(this).remove()
									})
								}), c.append(p)
							},
							onUploadError: function(t, e, n, i) {
								HYD.hint("danger", "对不起：" + t.name + "上传失败：" + i)
							}
						}), o.find("#j-btn-uploaduse").click(function() {
							0 == n.length ? HYD.hint("danger", "对不起，您没有选择音频：" + e.msg) : (e.content.audiosrc = n[0], l()), $.jBox.close(t)
						})
					};
				a(1, function() {
					$.jBox.show({
						title: "选择音频",
						content: o,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(i) {
							var a = o.find("#j-btn-listuse"),
								l = o.find("#j-btn-listdel");
							a.click(function() {
								var a = [],
									l = [];
								o.find(".imgpicker-list li.selected").each(function() {
									a.push(n[$(this).index()].file_path), l.push(n[$(this).index()].file_id)
								}), 0 == a.length ? HYD.hint("danger", "对不起，您没有选择音频：" + e.msg) : t && t(a), $.jBox.close(i)
							}), l.click(function() {
								var t = o.find(".imgpicker-list li.selected").children(".audio-flag").data("id");
								$.ajax({
									url: "/Design/delImg",
									type: "POST",
									dataType: "json",
									data: {
										file_id: t
									},
									success: function(t) {
										1 == t.status && (HYD.hint("success", "删除成功"), o.find(".imgpicker-list li.selected").remove())
									}
								})
							}), o.find(".j-initupload").one("click", function() {
								c(i)
							})
						}
					})
				})
			};
		i.find(".j-selectimg").click(function() {
			$(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.ImgPicker(function(t) {
				e.content.imgsrc = t[0], l()
			})
		}), i.find(".j-audioselect").click(function() {
			c(function(t) {
				e.content.audiosrc = t[0], l()
			})
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type16 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type16").html(),
			a = $("#tpl_diy_ctrl_type16").html();
		e.dom_ctrl = t;
		var l = function(t) {
			var l = $(_.template(o, e));
			n.find(".members_con").remove().end().append(l);
			var c = $(_.template(a, e));
			i.empty().append(c), HYD.DIY.Unit.event_type16(i, e), t && t()
		};
		i.find("input[name='notice']").change(function() {
			var t = $(this).val();
			n.find(".j-notice").text("公告：" + $(this).val()), e.content.strLength = t.length, e.content.showtitle = t, l()
		}), i.find("input[name='noticeStyle']").change(function() {
			var t = $(this).val();
			e.content.noticeStyle = t, l()
		}), i.find("select[name='navbgColor']").change(function() {
			var t = $(this).val();
			e.content.bgColor = t, l()
		}), i.find(".colorPicker").each(function(t, n) {
			var i = $(this);
			if (0 == t) {
				var o = ($(this).data("name"), $(this).data("color"));
				i.ColorPicker({
					color: o,
					onShow: function(t) {
						return $(t).fadeIn(100), !1
					},
					onHide: function(t) {
						return $(t).fadeOut(100), l(), !1
					},
					onChange: function(t, n, o) {
						var n = "#" + n;
						i.css("background-color", n), e.content.bgColor = n
					}
				})
			} else {
				var o = ($(this).data("name"), $(this).data("color"));
				i.ColorPicker({
					color: o,
					onShow: function(t) {
						return $(t).fadeIn(100), !1
					},
					onHide: function(t) {
						return $(t).fadeOut(100), l(), !1
					},
					onChange: function(t, n, o) {
						var n = "#" + n;
						i.css("background-color", n), e.content.fotColor = n
					}
				})
			}
		}), i.find("input[name='fontSize']").change(function() {
			var t = $(this).val();
			n.find(".notice-con").removeClass("font12 font14 font16").addClass(t), e.content.fontSize = t
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type17 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type17").html(),
			a = $("#tpl_diy_ctrl_type17").html();
		e.dom_ctrl = t;
		var l = function(t) {
			var l = $(_.template(o, e));
			n.find(".members_con").remove().end().append(l);
			var c = $(_.template(a, e));
			i.empty().append(c), HYD.DIY.Unit.event_type17(i, e), t && t()
		};
		i.find(".droplist li").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			HYD.popbox.dplPickerColletion({
				linkType: $(this).data("val"),
				callback: function(n, i) {
					e.content.dataset[t].title = n.title, e.content.dataset[t].showtitle = n.title, e.content.dataset[t].link = n.link, e.content.dataset[t].linkType = i, n.pic && "" != n.pic && (e.content.dataset[t].pic = n.pic), l()
				}
			})
		}), i.find("input[name='customlink']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset[t].link = $(this).val()
		}), i.find("input[name='classify']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = $(this).val();
			e.content.dataset[t].showtitle = n, l()
		}), i.find("select[name='navbgColor']").change(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = $(this).val();
			e.content.dataset[t].bgColor = n, l()
		}), i.find(".ctrl-item-list-li").each(function(t, n) {
			var i = $(this);
			i.find(".colorPicker1").each(function(n, i) {
				var o = $(this);
				if (0 == n) {
					var a = ($(this).data("name"), $(this).data("color"));
					o.ColorPicker({
						color: a,
						onShow: function(t) {
							return $(t).fadeIn(100), !1
						},
						onHide: function(t) {
							return $(t).fadeOut(100), l(), !1
						},
						onChange: function(n, i, a) {
							var i = "#" + i;
							o.css("background-color", i), e.content.dataset[t].bgColor = i
						}
					})
				} else {
					var a = ($(this).data("name"), $(this).data("color"));
					o.ColorPicker({
						color: a,
						onShow: function(t) {
							return $(t).fadeIn(100), !1
						},
						onHide: function(t) {
							return $(t).fadeOut(100), l(), !1
						},
						onChange: function(n, i, a) {
							var i = "#" + i;
							o.css("background-color", i), e.content.dataset[t].fotColor = i
						}
					})
				}
			})
		}), i.find("input[name='layout']").change(function() {
			var t = $(this).val();
			n.find(".members_classify").attr("class", "members_classify layoutstyle" + t), e.content.layout = t
		}), i.find(".j-moveup").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			if (0 != t) {
				var n = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t - 1, 0, n), l()
			}
		}), i.find(".j-movedown").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index(),
				n = e.content.dataset.length;
			if (t != n - 1) {
				var i = e.content.dataset.slice(t, t + 1)[0];
				e.content.dataset.splice(t, 1), e.content.dataset.splice(t + 1, 0, i), l()
			}
		}), i.find(".ctrl-item-list-add").click(function() {
			var t = {
				link: "#",
				linkType: 0,
				showtitle: "内容",
				bgColor: "#28c192",
				cloPicker: "2",
				fotColor: "#fff"
			};
			e.content.dataset.push(t), l()
		}), i.find(".j-del").click(function() {
			var t = $(this).parents("li.ctrl-item-list-li").index();
			e.content.dataset.splice(t, 1), l()
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type18 = function(t, e) {
		var n = e.dom_conitem,
			i = t;
		i.find(".J-edit-signtemp").click(function() {
			var t = n.find(".fulltext").html();
			$.composeBox({
				content: t,
				callback: function(t, i) {
					("" == t || "" == i) && (t = "<p>『富文本编辑器』</p>"), n.find(".fulltext").html(t), e.content.fulltext = HYD.DIY.Unit.html_encode(t)
				}
			})
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}, HYD.DIY.Unit.event_type19 = function(t, e) {
		var n = e.dom_conitem,
			i = t,
			o = $("#tpl_diy_con_type19").html(),
			a = $("#tpl_diy_ctrl_type19").html();
		e.dom_ctrl = t;
		var l = function(t) {
				var l = $(_.template(o, e));
				n.find(".members_con").remove().end().append(l);
				var c = $(_.template(a, e));
				i.empty().append(c), HYD.DIY.Unit.event_type19(i, e), t && t()
			},
			c = function() {
				n.find(".mingoods,.biggoods,.b_mingoods").each(function(t, e) {
					var n = $(this),
						i = n.find("img").width();
					n.find("img").closest("a").height(i)
				})
			};
		i.find("input[name='layout']").change(function() {
			var t = $(this).val();
			e.content.layout = t, l(c)
		}), i.find("input[name='goodstyle']").change(function() {
			var t = $(this).val();
			e.content.goodstyle = t, l(c)
		}), i.find("input[name='layoutstyles']").change(function() {
			var t = $(this).val();
			e.content.layoutstyles = t, l(c)
		}), i.find("input[name='showName']").change(function() {
			var t = $(this).val();
			e.content.showName = t, l(c)
		}), i.find("input[name='showIco']").change(function() {
			var t = $(this).is(":checked");
			e.content.showIco = t, l(c)
		}), i.find("input[name='showPrice']").change(function() {
			var t = $(this).is(":checked");
			e.content.showPrice = t, l(c)
		}), i.find("input[name='priceBold']").change(function() {
			var t = $(this).val();
			e.content.priceBold = t, l(c)
		}), i.find("input[name='goodstxt']").change(function() {
			var t = $(this).val();
			n.find(".goods-btn a").text($(this).val()), e.content.goodstxt = t, l(c)
		}), i.find("input[name='multiLine']").change(function() {
			$(this).attr("checked") ? ($(this).attr("checked", "true"), e.content.titleLine = 1) : ($(this).removeAttr("checked"), e.content.titleLine = 0), l(c)
		}), i.find(".j-slider").slider({
			min: 0,
			max: 50,
			step: 1,
			animate: "fast",
			value: e.content.modulePadding,
			slide: function(t, e) {
				n.find(".modulePadding").css({
					"padding-top": e.value,
					"padding-bottom": e.value
				}), i.find(".j-ctrl-showheight").text(e.value + "px")
			},
			stop: function(t, n) {
				e.content.modulePadding = parseInt(n.value)
			}
		})
	}
}), $(function() {
	HYD.DIY.Unit.verifyWhiteList = ["1", "6", "10", "11", "12", "13", "14", "15", "16", "17", "Header_style1", "Header_style2", "Header_style3", "Header_style4", "Header_style5", "Header_style6", "Header_style7", "Header_style8", "Header_style9", "Header_style10", "Header_style11", "Header_style12", "Header_style13", "Header_style14", "Header_style15", "Header_style16", "Header_style17", "Header_style18", "Header_style19", "Header_style20", "Header_style21", "Header_style7_news", "Header_style9_news", "Header_style12_ad", "Header_style12_nav", "Header_style15_news", "UserCenter", "Navigation", "MgzCate", "GoodsGroup"], HYD.DIY.Unit.verify_type2 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		if ("" == t.content.title) {
			i();
			var o = t.dom_ctrl.find("input[name='title']");
			HYD.FormShowError(o, "请填写标题")
		}
		if ("" == t.content.subtitle) {
			i();
			var o = t.dom_ctrl.find("input[name='subtitle']");
			HYD.FormShowError(o, "请填写副标题")
		}
		return n
	}, HYD.DIY.Unit.verify_type3 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		if (!t.content) {
			i();
			var o = t.dom_ctrl.find(".j-verify");
			HYD.FormShowError(o, "请选择一个自定义模块")
		}
		return n
	}, HYD.DIY.Unit.verify_type4 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		if (!t.content.goodslist.length) {
			i();
			var o = t.dom_ctrl.find(".j-verify");
			HYD.FormShowError(o, "请至少选择一件商品")
		}
		return n
	}, HYD.DIY.Unit.verify_type5 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		if (!t.content.group) {
			i();
			var o = t.dom_ctrl.find(".j-verify");
			HYD.FormShowError(o, "请选择商品分组")
		}
		return n
	}, HYD.DIY.Unit.verify_type7 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		t.content.dataset.length || (i(), t.dom_ctrl.find(".j-verify-least").addClass("error").text("请至少添加一个导航链接"));
		for (var o = 0; o < t.content.dataset.length; o++) {
			var a = t.content.dataset[o];
			if ("" == a.showtitle) {
				i();
				var l = t.dom_ctrl.find(".ctrl-item-list-li:eq(" + o + ") input[name='title']");
				HYD.FormShowError(l, "请输入导航名称")
			}
			0 == a.linkType && (i(), t.dom_ctrl.find(".ctrl-item-list-li:eq(" + o + ") .j-verify-linkType").addClass("error").text("请选择要链接的地址"))
		}
		return n
	}, HYD.DIY.Unit.verify_type8 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		t.content.dataset.length || (i(), t.dom_ctrl.find(".j-verify-least").addClass("error").text("请至少添加一个图片导航"));
		for (var o = 0; o < t.content.dataset.length; o++) {
			var a = t.content.dataset[o];
			0 == a.linkType && (i(), t.dom_ctrl.find(".ctrl-item-list-li:eq(" + o + ") .j-verify-linkType").addClass("error").text("请选择要链接的地址")), "" == a.pic && (i(), t.dom_ctrl.find(".ctrl-item-list-li:eq(" + o + ") .j-verify-pic").addClass("error").text("请选择一张图片"))
		}
		return n
	}, HYD.DIY.Unit.verify_type9 = function(t) {
		var e = !1,
			n = !0,
			i = function() {
				e || (t.dom_conitem.find(".diy-conitem-action").click(), e = !0, n = !1)
			};
		t.content.dataset.length || (i(), t.dom_ctrl.find(".j-verify-least").addClass("error").text("请至少添加一个图片广告"));
		for (var o = 0; o < t.content.dataset.length; o++) {
			var a = t.content.dataset[o];
			0 == a.linkType && (i(), t.dom_ctrl.find(".ctrl-item-list-li:eq(" + o + ") .j-verify-linkType").addClass("error").text("请选择要链接的地址")), "" == a.pic && (i(), t.dom_ctrl.find(".ctrl-item-list-li:eq(" + o + ") .j-verify-pic").addClass("error").text("请选择一张图片"))
		}
		return n
	}, HYD.DIY.Unit.verify = function() {
		var t = HYD.DIY.Unit.verifyWhiteList,
			e = !0,
			n = HYD.DIY.LModules.length,
			i = HYD.DIY.PModules.length;
		if (n)
			for (var o = 0; n > o; o++) {
				var a = HYD.DIY.LModules[o];
				if (t.indexOf(a.type.toString()) < 0 && !HYD.DIY.Unit["verify_type" + a.type](a)) {
					e = !1;
					break
				}
			}
		if (i)
			for (var o = 0; i > o; o++) {
				var a = HYD.DIY.PModules[o];
				if (t.indexOf(a.type.toString()) < 0 && !HYD.DIY.Unit["verify_type" + a.type](a)) {
					e = !1;
					break
				}
			}
		return e
	}
}), $(function() {
	$(".j-diy-addModule").click(function() {
		var t = $(this).data("type"),
			e = {
				id: HYD.DIY.getTimestamp(),
				type: t,
				draggable: !0,
				sort: 0,
				content: null
			};
		switch (t) {
			case 1:
				e.ue = null, e.content = {
					fulltext: "&lt;p&gt;『富文本编辑器』&lt;/p&gt;",
					modulePadding: 5
				};
				break;
			case 2:
				e.content = {
					title: "标题名称",
					style: 0,
					direction: "left",
					modulePadding: 5
				};
				break;
			case 3:
				e.content = {
					modulePadding: 0
				};
				break;
			case 4:
				e.content = {
					layout: 1,
					showPrice: !0,
					showIco: !0,
					showName: 1,
					goodslist: [],
					sale_num: 5,
					goodstyle: 1,
					layoutstyles: 1,
					goodstxt: "立即购买",
					titleLine: 0,
					version: 1,
					modulePadding: 5,
					priceBold: 1
				};
				break;
			case 5:
				e.content = {
					layout: 1,
					showPrice: !0,
					showIco: !0,
					showName: !0,
					group: null,
					goodsize: 6,
					sale_num: 5,
					goodstyle: 1,
					layoutstyles: 1,
					goodstxt: "立即购买",
					version: 1,
					modulePadding: 5,
					goodslist: [{
						item_id: "1",
						link: "#",
						pic: "/public/manage/editshop/images/goodsView1.jpg",
						price: "100.00",
						original_price: "200.00",
						title: "第一个商品"
					}, {
						item_id: "2",
						link: "#",
						pic: "/public/manage/editshop/images/goodsView2.jpg",
						price: "200.00",
						original_price: "300.00",
						title: "第二个商品"
					}, {
						item_id: "3",
						link: "#",
						pic: "/public/manage/editshop/images/goodsView3.jpg",
						price: "300.00",
						original_price: "400.00",
						title: "第三个商品"
					}, {
						item_id: "4",
						link: "#",
						pic: "/public/manage/editshop/images/goodsView4.jpg",
						price: "400.00",
						original_price: "500.00",
						title: "第四个商品"
					}]
				};
				break;
			case 6:
				e.content = {
					modulePadding: 5
				};
				break;
			case 7:
				e.content = {
					modulePadding: 5,
					dataset: [{
						linkType: 0,
						link: "",
						title: "",
						showtitle: ""
					}]
				};
				break;
			case 8:
				e.content = {
					layout: 1,
					layout1_style: 1,
					modulePadding: 5,
					hasImgMargin: 1,
					dataset: [{
						linkType: 0,
						link: "#",
						showtitle: "导航名称",
						titleBackgroundColor: "#FE9303",
						pic: "/public/manage/editshop/images/waitupload.png"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "导航名称",
						titleBackgroundColor: "#FE9303",
						pic: "/public/manage/editshop/images/waitupload.png"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "导航名称",
						titleBackgroundColor: "#FE9303",
						pic: "/public/manage/editshop/images/waitupload.png"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "导航名称",
						titleBackgroundColor: "#FE9303",
						pic: "/public/manage/editshop/images/waitupload.png"
					}]
				};
				break;
			case 9:
				e.content = {
					showType: 1,
					space: 0,
					margin: 5,
					modulePadding: 5,
					dataset: []
				};
				break;
			case 10:
				break;
			case 11:
				e.content = {
					height: 10
				};
				break;
			case 12:
				e.content = {
					style: 0,
					marginstyle: 0,
					modulePadding: 5,
					dataset: [{
						link: "/Shop/index",
						linkType: 6,
						showtitle: "首页",
						title: "店铺主页",
						pic: "/public/manage/editshop/images/ind3_1.png",
						bgColor: "#07a0e7",
						cloPicker: "0",
						fotColor: "#fff"
					}, {
						link: "/Shop/index",
						linkType: 6,
						showtitle: "新品",
						title: "",
						pic: "/public/manage/editshop/images/ind3_2.png",
						bgColor: "#72c201",
						cloPicker: "1",
						fotColor: "#fff"
					}, {
						link: "/Shop/index",
						linkType: 6,
						showtitle: "热卖",
						title: "店铺主页",
						pic: "/public/manage/editshop/images/ind3_3.png",
						bgColor: "#ffa800",
						cloPicker: "2",
						fotColor: "#fff"
					}, {
						link: "/Shop/index",
						linkType: 6,
						showtitle: "推荐",
						title: "",
						pic: "/public/manage/editshop/images/ind3_4.png",
						bgColor: "#d50303",
						cloPicker: "3",
						fotColor: "#fff"
					}]
				};
				break;
			case 13:
				e.content = {
					layout: 0,
					version: 2,
					modulePadding: 5,
					dataset: [{
						linkType: 0,
						link: "#",
						showTitle: 1,
						title: "橱窗文字",
						pic: "/public/manage/editshop/images/waitupload2.png"
					}, {
						linkType: 0,
						link: "#",
						showTitle: 1,
						title: "橱窗文字",
						pic: "/public/manage/editshop/images/waitupload2.png"
					}, {
						linkType: 0,
						link: "#",
						showTitle: 1,
						title: "橱窗文字",
						pic: "/public/manage/editshop/images/waitupload2.png"
					}]
				};
				break;
			case 14:
				e.content = {
					website: "",
					modulePadding: 5
				};
				break;
			case 15:
				e.content = {
					direct: 0,
					imgsrc: "",
					audiosrc: "",
					modulePadding: 5
				};
				break;
			case 16:
				e.content = {
					linkType: 0,
					title: "公告",
					showtitle: "请填写内容，如果过长，将会滚动显示",
					bgColor: "#ffffcc",
					noticeStyle: "1",
					cloPicker: "2",
					fontSize: "font12",
					modulePadding: 5
				};
				break;
			case 17:
				e.content = {
					layout: 0,
					modulePadding: 5,
					dataset: [{
						linkType: 0,
						link: "#",
						showtitle: "内容1",
						bgColor: "#28c192",
						cloPicker: "2",
						fotColor: "#fff"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "内容2",
						bgColor: "#28c192",
						cloPicker: "2",
						fotColor: "#fff"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "内容3",
						bgColor: "#28c192",
						cloPicker: "2",
						fotColor: "#fff"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "内容4",
						bgColor: "#28c192",
						cloPicker: "2",
						fotColor: "#fff"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "内容5",
						bgColor: "#28c192",
						cloPicker: "2",
						fotColor: "#fff"
					}, {
						linkType: 0,
						link: "#",
						showtitle: "内容6",
						bgColor: "#28c192",
						cloPicker: "2",
						fotColor: "#fff"
					}]
				};
				break;
			case 18:
				e.content = {
					fulltext: "&lt;p&gt;『微排版编辑器』&lt;/p&gt;",
					modulePadding: 5
				};
				break;
			case 19:
				e.content = {
					layout: 1,
					showPrice: !0,
					showIco: !0,
					showName: 1,
					goodslist: [],
					sale_num: 5,
					goodstyle: 1,
					layoutstyles: 1,
					goodstxt: "立即购买",
					titleLine: 0,
					modulePadding: 5,
					priceBold: 1
				}
		}
		HYD.DIY.add(e, !0)
	}), $("#diy-phone .drag").sortable({
		revert: !0,
		placeholder: "drag-highlight",
		stop: function(t, e) {
			HYD.DIY.repositionCtrl(e.item, $(".diy-ctrl-item[data-origin='item']"))
		}
	}).disableSelection(), $(".j-pagetitle").click(function() {
		$(".diy-ctrl-item[data-origin='pagetitle']").show().siblings(".diy-ctrl-item[data-origin='item']").hide()
	}), $(".j-pagetitle-ipt").change(function() {
		$(".j-pagetitle").text($(this).val())
	})
});
﻿! function(e, o, n) {
	var i = {
			selectMod: 1,
			selectIds: [],
			callback: null
		},
		t = {
			selectGoods: e("#tpl_popup_selectGoods").html()
		},
		c = null,
		l = {},
		s = {
			getItem: "/public/manage/editshop/json/Design/getItem.json"
		},
		a = function(o, n, i) {
			e.ajax({
				url: s.getItem + "?v=" + Math.round(100 * Math.random()),
				type: "POST",
				dataType: "json",
				data: i,
				beforeSend: function() {
					e.jBox.showloading()
				},
				success: function(s) {
					if (1 == s.status) {
						c = s.list;
						var a = _.template(t.selectGoods, {
								dataset: s.list,
								classlists: s.class_lists,
								page: s.page,
								formdata: i,
								selectMod: n.selectMod,
								selectIds: n.selectIds,
								curPageCache: l[i.p]
							}),
							r = e(a);
						o.find(".jbox-container").empty().html(r)
					} else HYD.hint("danger", "获取数据失败，" + s.msg), e.jBox.close(o);
					e.jBox.hideloading()
				}
			})
		},
		r = function(e) {
			var o = e.attr("href");
			if (o.length) {
				var n = o.split("/"),
					i = n[n.length - 1].replace(/.html/, "");
				return i
			}
		};
	_QV_ = "%E6%9D%AD%E5%B7%9E%E5%90%AF%E5%8D%9A%E7%A7%91%E6%8A%80%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E7%89%88%E6%9D%83%E6%89%80%E6%9C%89", e.selectGoods = function(o) {
		var n = e.extend(!0, {}, i, o);
		c = null, l = {}, e.jBox.show({
			title: "选择商品",
			width: 1e3,
			minHeight: 605,
			content: "",
			onOpen: function(o) {
				a(o, n, {
					p: 1
				});
				var i = function() {
					var n = o.find(".paginate a.cur").text(),
						i = [],
						t = [];
					o.find(".j-chkbox:checked").each(function() {
						var o = e(this),
							n = o.data("itemid"),
							l = o.data("index"),
							s = c[l];
						i.push(n), t.push(s)
					}), l[n] = {
						ids: i,
						data: t
					}
				};
				o.on("click", ".paginate a", function() {
					if (!e(this).hasClass("cur")) {
						i();
						var t = r(e(this)),
							c = o.find("input[name=title]").val(),
							l = o.find("select[name=status]").val(),
							s = o.find("select[name=class_id]").val();
						return a(o, n, {
							p: t,
							title: c,
							status: l,
							class_id: s
						}), !1
					}
				}), o.on("click", ".j-search", function() {
					var e = o.find("input[name=title]").val(),
						i = o.find("select[name=status]").val(),
						t = o.find("select[name=class_id]").val();
					a(o, n, {
						p: 1,
						title: e,
						status: i,
						class_id: t
					})
				}), 1 == n.selectMod ? o.on("click", ".j-select", function() {
					var i = e(this).data("index");
					n.callback && n.callback(c[i]), e.jBox.close(o)
				}) : (o.on("click", ".j-select", function() {
					var o = e(this),
						n = o.siblings(".j-chkbox");
					o.hasClass("cur") ? (o.removeClass("cur"), n.attr("checked", !1)) : (o.addClass("cur"), n.attr("checked", !0))
				}), o.on("click", ".j-use", function() {
					i();
					var t = [],
						c = [];
					for (var s in l) t = t.concat(l[s].ids), c = c.concat(l[s].data);
					n.callback && n.callback(c, t), e.jBox.close(o)
				}), o.on("click", ".j-selectAll", function() {
					o.find(".j-select").addClass("cur"), o.find(".j-chkbox").attr("checked", !0)
				}), o.on("click", ".j-selectReverse", function() {
					o.find(".j-select").each(function() {
						var o = e(this),
							n = o.siblings(".j-chkbox");
						o.hasClass("cur") ? (o.removeClass("cur"), n.attr("checked", !1)) : (o.addClass("cur"), n.attr("checked", !0))
					})
				}), o.on("click", ".j-cancelSelectAll", function() {
					o.find(".j-select").removeClass("cur"), o.find(".j-chkbox").attr("checked", !1)
				}))
			},
			btnOK: {
				show: !1
			},
			btnCancel: {
				show: !1
			}
		})
	}
}(jQuery, document, window), $(function() {
	var e = null,
		o = null,
		n = null,
		i = {
			content: "",
			callback: null
		};
	$.composeBox = function(t) {
		var c = $.extend(!0, {}, i, t),
			l = $("#tpl_popup_selectCompose").html(),
			s = $(l);
		$("body").append(s);
		var a = ($(".J-composeBox").height(), $(window).height());
		$("body").append('<div class="box-overlay"></div>'), $(".box-overlay").css("height", a);
		var r = $(window).height(),
			d = $(".compose_top").height(),
			g = $("#tmpl h2").height(),
			u = r - d - g;
		s.find(".compose_lists").css({
			height: u,
			overflow: "auto"
		});
		var p = function() {
			$(".J-composeBox").remove(), $(".box-overlay").remove(), $("body").css({
				height: "auto",
				overflow: "auto"
			})
		};
		renderData(s, "10"), s.on("click", ".J-okClk", function() {
			c.content = e.getContent(), o = c.content, n = html_encode(c.content), c.callback && c.callback(o, n), p(), e.destroy()
		}), s.on("click", ".J-noClk", function() {
			p(), e.destroy()
		}), s.find("#nav li").click(function() {
			var e = $(this),
				o = e.data("id");
			e.addClass("active").siblings().removeClass("active"), renderData(s, o)
		}), s.on("click", ".compose_lists li", function() {
			var o = $(this).find(".pEditor").html() + "<p></p>";
			e.focus(), e.execCommand("inserthtml", o)
		}), e = UE.getEditor("edit_content", {
			autoHeight: !1,
			autoHeightEnabled: !1,
			autoClearinitialContent: !1,
			initialFrameHeight: u - 74
		}), e.ready(function() {
			e.setContent(c.content)
		})
	}, _QV_ = "%E6%9D%AD%E5%B7%9E%E5%90%AF%E5%8D%9A%E7%A7%91%E6%8A%80%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E7%89%88%E6%9D%83%E6%89%80%E6%9C%89", renderData = function(e, o) {
		$.ajax({
			url: "/Public/mockdata/composedata/dataset" + o + ".json?v=" + Math.round(100 * Math.random()),
			type: "GET",
			dataType: "json",
			beforeSend: function() {
				$.jBox.showloading()
			},
			success: function(o) {
				if (1 == o.status) {
					var n = $("#tpl_Compose_lists").html(),
						i = _.template(n, {
							dataset: o.data
						}),
						t = $(i);
					$("#tmpl .compose_lists").empty().append(t)
				} else HYD.hint("danger", "获取数据失败，"), $.jBox.close(e);
				$.jBox.hideloading()
			}
		})
	}, html_encode = function(e) {
		var o = "";
		return 0 == e.length ? "" : (o = e.replace(/&/g, "&amp;"), o = o.replace(/</g, "&lt;"), o = o.replace(/>/g, "&gt;"), o = o.replace(/ /g, "&nbsp;"), o = o.replace(/\'/g, "&#39;"), o = o.replace(/\"/g, "&quot;"))
	}, html_decode = function(e) {
		var o = "";
		return 0 == e.length ? "" : (o = e.replace(/&amp;/g, "&"), o = o.replace(/&lt;/g, "<"), o = o.replace(/&gt;/g, ">"), o = o.replace(/&nbsp;/g, " "), o = o.replace(/&#39;/g, "'"), o = o.replace(/&quot;/g, '"'))
	}
});
var HYD = HYD ? HYD : {};
HYD.Constant = HYD.Constant ? HYD.Constant : {}, HYD.popbox = HYD.popbox ? HYD.popbox : {}, HYD.linkType = {
		1: "选择商品",
		2: "商品分组",
		3: "专题页面",
		4: "页面分类",
		5: "营销活动",
		6: "店铺主页",
		7: "会员主页",
		8: "分销申请",
		9: "购物车",
		10: "全部商品",
		12: "商品分类",
		11: "自定义链接",
		13: "我的订单"
	}, HYD.getTimestamp = function() {
		var e = new Date;
		return "" + e.getFullYear() + parseInt(e.getMonth() + 1) + e.getDate() + e.getHours() + e.getMinutes() + e.getSeconds() + e.getMilliseconds()
	}, HYD.hint = function(e, o, n) {
		if (e && o) {
			var i = $("#tpl_hint").html(),
				t = _.template(i, {
					type: e,
					content: o
				}),
				c = $(t),
				l = 200,
				n = n || 1500;
			$("body").append(c.css({
				opacity: "0",
				zIndex: "999999"
			})), c.animate({
				opacity: 1,
				top: 200
			}, l, function() {
				setTimeout(function() {
					c.animate({
						opacity: 0,
						top: 600
					}, l, function() {
						$(this).remove()
					})
				}, n)
			})
		}
	}, HYD.FormShowError = function(e, o, n) {
		e && o && (void 0 == n && (n = !0), e.addClass("error").siblings(".fi-help-text").addClass("error").text(o).show(), n && e.focus(), "select" == e[0].nodeName.toLowerCase() && e.siblings(".select-sim").addClass("error"), e.one("change", function() {
			HYD.FormClearError($(this))
		}))
	}, HYD.FormClearError = function(e) {
		e && (e.removeClass("error").siblings(".fi-help-text").hide(), "select" == e[0].nodeName.toLowerCase() && e.siblings(".select-sim").removeClass("error"))
	}, HYD.showQrcode = function(e) {
		var o = $("#qrcode");
		if (!o.length) {
			var n = _.template($("#tpl_qrcode").html(), {
				src: e
			});
			o = $(n), o.click(function() {
				o.fadeOut(300)
			}), $("body").append(o)
		}
		o.find("img").attr("src", e), o.fadeIn(300)
	}, HYD.changeWizardStep = function(e, o) {
		var n = $(e),
			i = n.find(".wizard-item");
		i.removeClass("process complete");
		for (var t = 0; o - 1 >= t; t++) i.filter(":eq(" + t + ")").addClass("complete");
		i.filter(":eq(" + o + ")").addClass("process")
	}, HYD.autoLocation = function(e, o) {
		if (e) {
			var o = o ? o : 2e3;
			timer = setInterval(function() {
				1e3 >= o ? (clearInterval(timer), window.location.href = e) : (o -= 1e3, $("#j-autoLocation-second").text(o / 1e3))
			}, 1e3)
		}
	}, HYD.ajaxPopTable = function(e) {
		var o, n, i = {
				title: "",
				url: "",
				data: {
					p: 1
				},
				tpl: "",
				onOpen: null,
				onPageChange: null
			},
			t = $.extend(!0, {}, i, e),
			c = $("<div></div>"),
			l = function(e) {
				var i = t.tpl,
					s = t.url,
					a = function(s) {
						o = s;
						var a = _.template(i, s),
							r = $(a);
						c.empty().append(r), c.find(".paginate a:not(.disabled,.cur)").click(function() {
							for (var e = $(this).attr("href"), o = e.split("/"), n = 0; n < o.length; n++)
								if ("p" == o[n]) {
									t.data.p = o[n + 1], l();
									break
								}
							return !1
						}), e && e(), t.onPageChange && t.onPageChange(n, o)
					};
				$.ajax({
					url: s + "?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: t.data,
					success: function(e) {
						1 == e.status ? a(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			};
		l(function() {
			$.jBox.show({
				title: t.title,
				content: c,
				btnOK: {
					show: !1
				},
				btnCancel: {
					show: !1
				},
				onOpen: function(e) {
					n = e, t.onOpen && t.onOpen(e, o)
				}
			})
		})
	}, HYD.popbox.ImgPicker = function(e) {
		var o, n = $("#tpl_popbox_ImgPicker").html(),
			i = $(n),
			t = function(e, n) {
				var c = function(e) {
					if (o = e.list, o && o.length) {
						var c = _.template($("#tpl_popbox_ImgPicker_listItem").html(), {
								dataset: o
							}),
							l = $(c);
						l.filter("li").click(function() {
							$(this).toggleClass("selected")
						}), i.find(".imgpicker-list").empty().append(l);
						var s = e.page,
							a = $(s);
						a.filter("a:not(.disabled,.cur)").click(function() {
							var e = $(this).attr("href"),
								o = e.split("/");
							return o = o[o.length - 1], o = o.replace(/.html/, ""), t(o), !1
						}), i.find(".paginate").empty().append(a)
					} else i.find(".imgpicker-list").append("<p class='txtCenter'>对不起，暂无图片</p>");
					n && n()
				};
				$.ajax({
					url: "/Design/getImg?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(e)
					},
					success: function(e) {
						1 == e.status ? c(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			},
			c = function(o) {
				var n = [];
				i.find("#imgpicker_upload_input").uploadify({
					debug: !1,
					auto: !0,
					formData: {
						PHPSESSID: $.cookie("PHPSESSID")
					},
					width: 60,
					height: 60,
					multi: !0,
					swf: "/public/manage/editshop/js/uploadify.swf",
					uploader: "/public/manage/editshop/json/Design/uploadFile.json",
					buttonText: "+",
					fileSizeLimit: "5MB",
					fileTypeExts: "*.jpg; *.jpeg; *.png; *.gif; *.bmp",
					onSelectError: function(e, o, n) {
						switch (o) {
							case -100:
								HYD.hint("danger", "对不起，系统只允许您一次最多上传10个文件");
								break;
							case -110:
								HYD.hint("danger", "对不起，文件 [" + e.name + "] 大小超出5MB！");
								break;
							case -120:
								HYD.hint("danger", "文件 [" + e.name + "] 大小异常！");
								break;
							case -130:
								HYD.hint("danger", "文件 [" + e.name + "] 类型不正确！")
						}
					},
					onFallback: function() {
						HYD.hint("danger", "您未安装FLASH控件，无法上传图片！请安装FLASH控件后再试。")
					},
					onUploadSuccess: function(e, o, t) {
						var o = $.parseJSON(o),
							c = $("#tpl_popbox_ImgPicker_uploadPrvItem").html(),
							l = i.find(".imgpicker-upload-preview"),
							s = o.file_path;
						n.push(s);
						var a = _.template(c, {
								url: s
							}),
							r = $(a);
						r.find(".j-imgpicker-upload-btndel").click(function() {
							var e = i.find(".imgpicker-upload-preview li").index($(this).parent("li"));
							r.fadeOut(300, function() {
								n.splice(e, 1), $(this).remove()
							})
						}), l.append(r)
					},
					onUploadError: function(e, o, n, i) {
						HYD.hint("danger", "对不起：" + e.name + "上传失败：" + i)
					}
				}), i.find("#j-btn-uploaduse").click(function() {
					e && e(n), $.jBox.close(o)
				})
			};
		t(1, function() {
			$.jBox.show({
				title: "选择图片",
				content: i,
				btnOK: {
					show: !1
				},
				btnCancel: {
					show: !1
				},
				onOpen: function(n) {
					var t = i.find("#j-btn-listuse");
					t.click(function() {
						var t = [];
						i.find(".imgpicker-list li.selected").each(function() {
							t.push(o[$(this).index()])
						}), e && e(t), $.jBox.close(n)
					}), i.find(".j-initupload").one("click", function() {
						c(n)
					})
				}
			})
		})
	}, HYD.popbox.IconPicker = function(e) {
		var o, n = $("#icon_imgPicker").html(),
			i = $(n);
		o = $.browser.chrome ? "body" : document.documentElement || document.body, $(o).append(i);
		var t = $("#icon_imglist").html(),
			c = {
				style: "style1",
				color: "color0"
			},
			l = function(e) {
				c = e ? e : c;
				var o = _.template(t, {
					data: HYD.popbox.iconimgsrc.data[c.style][c.color]
				});
				i.find(".albums-icon-tab").html(o), i.find(".albums-icon-tab").find("li").click(function(e) {
					var o = $(this);
					o.hasClass("selected") || o.addClass("selected").siblings("li").removeClass("selected")
				})
			};
		l(c), i.find(".albums-cr-actions").children("a").click(function(e) {
			var o = $(this),
				n = o.data("style");
			c.style = n, o.addClass("cur").siblings("a").removeClass("cur"), l(c)
		}), i.find(".albums-color-tab").find("li").click(function(e) {
			var o = $(this),
				n = o.data("color");
			c.color = n, o.addClass("cur").siblings("li").removeClass("cur"), l(c), "color1" == n && $(".albums-icon-tab").find("li").css({
				background: "#333"
			})
		});
		var s = [];
		i.find("#j-useIcon").click(function(o) {
			var n = i.find(".albums-icon-tab").find("li.selected");
			if (0 == n.length) return HYD.hint("danger", "对不起，请选择一张小图标"), !1;
			var t = n.children("img").attr("src");
			t = t.replace("Public", "PublicMob"), s.push(t), a(), e && e(s)
		});
		var a = function() {
			i.remove()
		};
		i.find("#Jclose").click(function(e) {
			a()
		})
	}, HYD.popbox.ModulePicker = function(e) {
		var o, n = $("#tpl_popbox_ModulePicker").html(),
			i = $(n),
			t = function(e, n) {
				var c = function(e) {
					if (o = e.list, o && o.length) {
						var c = $("#tpl_popbox_ModulePicker_item").html(),
							l = _.template(c, {
								dataset: o
							}),
							s = $(l);
						i.find(".modulePicker-list").empty().append(s);
						var a = e.page,
							r = $(a);
						r.filter("a:not(.disabled,.cur)").click(function() {
							var e = $(this).attr("href"),
								o = e.split("/");
							return o = o[o.length - 1], o = o.replace(/.html/, ""), t(o), !1
						}), i.find(".paginate").empty().append(r)
					} else i.find(".modulePicker-list").append("<p class='txtCenter'>对不起，暂无自定义模块</p>");
					n && n()
				};
				$.ajax({
					url: "/Design/getModule?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(e)
					},
					success: function(e) {
						1 == e.status ? c(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			};
		t(1, function() {
			$.jBox.show({
				title: "选择自定义模块",
				content: i,
				btnOK: {
					show: !1
				},
				btnCancel: {
					show: !1
				},
				onOpen: function(n) {
					i.on("click", ".j-select", function() {
						var i = $(".modulePicker-list li").index($(this).parent("li"));
						e && e(o[i]), $.jBox.close(n)
					})
				}
			})
		})
	}, HYD.popbox.GoodsAndGroupPicker = function(e, o) {
		var n, i, t = $("#tpl_popbox_GoodsAndGroupPicker").html(),
			c = $(t),
			l = [],
			s = [],
			a = function(e, o) {
				var i = function(e) {
					if (n = e.list, n && n.length) {
						var i = $("#tpl_popbox_GoodsAndGroupPicker_goodsitem").html(),
							t = _.template(i, {
								dataset: n
							}),
							r = $(t);
						r.find(".j-select").click(function() {
							var e, o = $(this),
								i = o.parent("li"),
								t = i.index(),
								c = i.data("item"),
								a = $(".j-verify").val();
							if (e = "" != a ? a.split(",") : [], i.hasClass("selected")) {
								if (i.removeClass("selected"), o.removeClass("btn-success").text("选取"), 0 != l.length)
									for (var r = 0; r < l.length; r++)
										if (c == l[r].item_id) {
											l.splice(r, 1);
											break
										}
								if (0 != s.length)
									for (var r = 0; r < s.length; r++) {
										var d = s[r];
										if (c == d) {
											s.splice(r, 1);
											break
										}
									}
								if (0 != e.length) {
									for (var r = 0; r < e.length; r++) {
										var d = e[r];
										if (c == d) {
											e.splice(r, 1);
											break
										}
									}
									a = e.join(","), $(".j-verify").val(a)
								}
							} else i.addClass("selected"), o.addClass("btn-success").text("已选"), l.push(n[t]), s.push(c), e.push(c), a = e.join(","), $(".j-verify").val(a)
						}), c.find(".gagp-goodslist").empty().append(r);
						var d = e.page,
							g = $(d);
						g.filter("a:not(.disabled,.cur)").click(function() {
							var e = $(this).attr("href"),
								o = e.split("/");
							return o = o[o.length - 1], o = o.replace(/.html/, ""), a(o), !1
						}), c.find(".paginate:eq(0)").empty().append(g)
					} else c.find(".gagp-goodslist").append("<p class='txtCenter'>对不起，暂无数据</p>");
					var u = [];
					"" != $(".j-verify").val() ? u = $(".j-verify").val().split(",") : $(".img-list li").not(".img-list-add").each(function(e, o) {
						var n = $(this).data("item");
						u.push(n)
					}), c.find("li").each(function(e, o) {
						var n = $(this),
							i = n.data("item");
						$.each(u, function(e, o) {
							i == o && (n.addClass("selected"), n.children(".j-select").addClass("btn-success").text("已选"))
						})
					}), o && o()
				};
				$.ajax({
					url: "/public/manage/editshop/json/Design/getItem.json?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(e)
					},
					success: function(e) {
						1 == e.status ? i(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			},
			r = function(e, o) {
				var n = function(e) {
					if (i = e.list, i && i.length) {
						var n = $("#tpl_popbox_GoodsAndGroupPicker_groupitem").html(),
							t = _.template(n, {
								dataset: i
							}),
							l = $(t);
						c.find(".gagp-grouplist").empty().append(l);
						var s = e.page,
							a = $(s);
						a.filter("a:not(.disabled,.cur)").click(function() {
							var e = $(this).attr("href"),
								o = e.split("/");
							return o = o[o.length - 1], o = o.replace(/.html/, ""), r(o), !1
						}), c.find(".paginate").empty().append(a)
					} else c.find(".gagp-grouplist").append("<p class='txtCenter'>对不起，暂无数据</p>");
					var d = $(".badge-success").data("group");
					void 0 != d && c.find(".gagp-grouplist li").each(function(e, o) {
						var n = $(this),
							i = n.data("group");
						d == i && n.find(".j-select").addClass("btn-success").text("已选")
					}), o && o()
				};
				$.ajax({
					url: "/public/manage/editshop/json/Design/getGroup.json?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(e)
					},
					success: function(e) {
						1 == e.status ? n(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			},
			d = function(e, n) {
				c.on("click", ".j-btn-goodsuse", function() {
					var n = 1;
					o && o(l, n, s), $.jBox.close(e)
				})
			},
			g = function(e) {
				var i = 1;
				c.find(".j-btn-goodsuse").remove(), c.on("click", ".gagp-goodslist .j-select", function() {
					var t = $(".gagp-goodslist li").index($(this).parent("li"));
					o && o(n[t], i), $.jBox.close(e)
				})
			},
			u = function(e) {
				var n = 2;
				c.on("click", ".gagp-grouplist .j-select", function() {
					var t = $(".gagp-grouplist li").index($(this).parent("li"));
					o && o(i[t], n), $.jBox.close(e)
				})
			},
			p = function(e) {
				g(e), c.find(".j-tab-group").one("click", function() {
					r(1, function() {
						u(e)
					})
				})
			};
		switch (e) {
			case "goods":
			case "goodsMulti":
				c.find(".tabs").remove(), c.find(".gagp-goodslist").unwrap().unwrap(), c.find(".tc[data-index='2']").remove(), a(1, function() {
					var o = '<span class="fl">选择商品</span><div class="goodsearch"><input type="text" name="title" placeholder="请输入商品名称" /><select class="select small newselect" style="width:90px;"><option value="-1">在售中</option><option value="3">仓库中</option></select><a href="javascript:;" class="btn btn-primary jGetgood"><i class="gicon-search white"></i>查询</a></div>';
					$.jBox.show({
						title: o,
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(o) {
							if ("goodsMulti" == e) {
								var i = [];
								$(".img-list li").not(".img-list-add").each(function(e, o) {
									var n = $(this).data("item");
									i.push(n)
								}), c.find("li").each(function(e, o) {
									var n = $(this),
										t = n.data("item");
									$.each(i, function(e, o) {
										t == o && (n.addClass("selected"), n.children(".j-select").addClass("btn-success").text("已选"))
									})
								}), d(o, i)
							} else g(o);
							$(document).on("click", ".jGetgood", function(e) {
								var o = $(this).siblings("input").val(),
									i = $(this).siblings("select").val(),
									t = function(e, a) {
										e = e ? e : 1;
										var r = function(e) {
											if (n = e.list, n && n.length) {
												var o = $("#tpl_popbox_GoodsAndGroupPicker_goodsitem").html(),
													i = _.template(o, {
														dataset: n
													}),
													r = $(i);
												r.find(".j-select").click(function() {
													var e, o = $(this),
														i = o.parent("li"),
														t = i.index(),
														c = i.data("item"),
														a = $(".j-verify").val();
													if (e = "" != a ? a.split(",") : [], i.hasClass("selected")) {
														if (i.removeClass("selected"), o.removeClass("btn-success").text("选取"), 0 != l.length)
															for (var r = 0; r < l.length; r++)
																if (c == l[r].item_id) {
																	l.splice(r, 1);
																	break
																}
														if (0 != s.length)
															for (var r = 0; r < s.length; r++) {
																var d = s[r];
																if (c == d) {
																	s.splice(r, 1);
																	break
																}
															}
														if (0 != e.length) {
															for (var r = 0; r < e.length; r++) {
																var d = e[r];
																if (c == d) {
																	e.splice(r, 1);
																	break
																}
															}
															a = e.join(","), $(".j-verify").val(a)
														}
													} else i.addClass("selected"), o.addClass("btn-success").text("已选"), l.push(n[t]), s.push(c), e.push(c), a = e.join(","), $(".j-verify").val(a)
												}), c.find(".gagp-goodslist").empty().append(r);
												var d = e.page,
													g = $(d);
												g.filter("a:not(.disabled,.cur)").click(function() {
													var e = $(this).attr("href"),
														o = e.split("/");
													return o = o[o.length - 1], o = o.replace(/.html/, ""), t(o), !1
												}), c.find(".paginate:eq(0)").empty().append(g)
											} else c.find(".gagp-goodslist").empty().append("<p class='txtCenter'>对不起，暂无数据</p>"), c.find(".paginate").empty();
											a && a()
										};
										$.ajax({
											url: "/public/manage/editshop/json/Design/getItem.json?v=" + Math.round(100 * Math.random()),
											type: "post",
											dataType: "json",
											data: {
												p: parseInt(e),
												title: o,
												status: i
											},
											success: function(e) {
												1 == e.status ? r(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
											}
										})
									};
								t()
							})
						}
					})
				});
				break;
			case "group":
				c.find(".tabs").remove(), c.find(".gagp-grouplist").unwrap().unwrap(), c.find(".tc[data-index='1']").remove(), r(1, function() {
					$.jBox.show({
						title: "选择商品分组",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							u(e)
						}
					})
				});
				break;
			case "all":
				a(1, function() {
					$.jBox.show({
						title: "选择商品或商品分组",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							p(e)
						}
					})
				})
		}
	}, HYD.popbox.MgzAndMgzCate = function(e, o) {
		var n, i, t = $("#tpl_popbox_MgzAndMgzCate").html(),
			c = $(t),
			l = function(e, o) {
				var i = function(e) {
					if (n = e.list, n && n.length) {
						var i = $("#tpl_popbox_MgzAndMgzCate_item").html(),
							t = _.template(i, {
								dataset: n
							}),
							s = $(t);
						s.find(".j-select").click(function() {
							var e = $(this),
								o = e.parent("li");
							o.hasClass("selected") ? (o.removeClass("selected"), e.removeClass("btn-success").text("选取")) : (o.addClass("selected"), e.addClass("btn-success").text("已选"))
						}), c.find(".mgz-list-panel1").empty().append(s);
						var a = e.page,
							r = $(a);
						r.filter("a:not(.disabled,.cur)").click(function() {
							var e = $(this).attr("href"),
								o = e.split("/");
							return o = o[o.length - 1], o = o.replace(/.html/, ""), l(o), !1
						}), c.find(".paginate").empty().append(r)
					} else c.find(".mgz-list-panel1").empty().append("<p class='txtCenter'>对不起，暂无数据</p>");
					o && o()
				};
				$.ajax({
					url: "/public/manage/editshop/json/Design/getMagazine.json?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(e)
					},
					success: function(e) {
						1 == e.status ? i(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			},
			s = function(e, o) {
				var n = function(e) {
					if (i = e.list, i && i.length) {
						var n = $("#tpl_popbox_MgzAndMgzCate_item").html(),
							t = _.template(n, {
								dataset: i
							}),
							l = $(t);
						l.find(".j-select").click(function() {
							var e = $(this),
								o = e.parent("li");
							o.hasClass("selected") ? (o.removeClass("selected"), e.removeClass("btn-success").text("选取")) : (o.addClass("selected"), e.addClass("btn-success").text("已选"))
						}), c.find(".mgz-list-panel2").empty().append(l);
						var a = e.page,
							r = $(a);
						r.filter("a:not(.disabled,.cur)").click(function() {
							var e = $(this).attr("href"),
								o = e.split("/");
							return o = o[o.length - 1], o = o.replace(/.html/, ""), s(o), !1
						}), c.find(".paginate").empty().append(r)
					} else c.find(".mgz-list-panel2").empty().append("<p class='txtCenter'>对不起，暂无数据</p>");
					o && o()
				};
				$.ajax({
					url: "/public/manage/editshop/json/Design/getMagazineCategory.json?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(e)
					},
					success: function(e) {
						1 == e.status ? n(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			},
			a = function(e) {
				c.on("click", ".mgz-list-panel1 .j-select", function() {
					var i = $(".mgz-list-panel1 li").index($(this).parent("li"));
					o && o(n[i], 3), $.jBox.close(e)
				})
			},
			r = function(e) {
				c.on("click", ".mgz-list-panel2 .j-select", function() {
					var n = $(".mgz-list-panel2 li").index($(this).parent("li"));
					o && o(i[n], 4), $.jBox.close(e)
				})
			},
			d = function(e) {
				c.on("click", ".j-btn-use", function() {
					var n = [],
						t = 4;
					c.find(".mgz-list-panel2 li.selected").each(function() {
						n.push(i[$(this).index()])
					}), o && o(n, t), $.jBox.close(e)
				})
			},
			g = function(e) {
				a(e), c.find(".j-tab-mgzcate").one("click", function() {
					s(1, function() {
						r(e)
					})
				})
			};
		switch (e) {
			case "mgzCate":
				c.find(".tabs").remove(), c.find(".mgz-list-panel2").unwrap().unwrap(), c.find(".tc[data-index='1']").remove(), c.find(".j-btn-use").remove(), s(1, function() {
					$.jBox.show({
						title: "选择专题分类",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							r(e)
						}
					})
				});
				break;
			case "mgzCateMulti":
				c.find(".tabs").remove(), c.find(".mgz-list-panel2").unwrap().unwrap(), c.find(".tc[data-index='1']").remove(), s(1, function() {
					$.jBox.show({
						title: "选择专题分类",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							d(e)
						}
					})
				});
				break;
			case "mgz":
				c.find(".tabs").remove(), c.find(".mgz-list-panel1").unwrap().unwrap(), c.find(".tc[data-index='2']").remove(), c.find(".j-btn-use").remove(), l(1, function() {
					$.jBox.show({
						title: "选择专题页面",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							g(e)
						}
					})
				});
				break;
			case "all":
				c.find(".j-btn-use").remove(), l(1, function() {
					$.jBox.show({
						title: "选择专题页面或者分类",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							g(e)
						}
					})
				})
		}
		switch (e) {
			case "goods":
			case "goodsMulti":
				c.find(".tabs").remove(), c.find(".gagp-goodslist").unwrap().unwrap(), c.find(".tc[data-index='2']").remove(), showListRender_goods(1, function() {
					$.jBox.show({
						title: "选择商品",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(o) {
							"goodsMulti" == e ? selectEvent_goods_multi(o) : selectEvent_goods(o)
						}
					})
				});
				break;
			case "group":
				c.find(".tabs").remove(), c.find(".gagp-grouplist").unwrap().unwrap(), c.find(".tc[data-index='1']").remove(), showListRender_group(1, function() {
					$.jBox.show({
						title: "选择商品分组",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							selectEvent_group(e)
						}
					})
				});
				break;
			case "all":
				showListRender_goods(1, function() {
					$.jBox.show({
						title: "选择商品或商品分组",
						content: c,
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function(e) {
							selectEvent_goodsAndGroup(e)
						}
					})
				})
		}
	}, HYD.popbox.GamePicker = function(e, o) {
		var n = $("#tpl_popbox_GamePicker").html(),
			i = $(n),
			t = {
				1: [],
				2: [],
				3: [],
				4: []
			},
			c = function(e, o, n) {
				var l = function(o) {
						if (t[e] = o.list, t[e] && t[e].length) {
							var l = $("#tpl_popbox_GamePicker_item").html(),
								s = _.template(l, {
									dataset: t[e]
								}),
								a = $(s);
							a.find(".j-select").click(function() {
								var e = $(this),
									o = e.parent("li");
								o.hasClass("selected") ? (o.removeClass("selected"), e.removeClass("btn-success").text("选取")) : (o.addClass("selected"), e.addClass("btn-success").text("已选"))
							}), i.find(".game-list-panel" + e).empty().append(a);
							var r = o.page,
								d = $(r);
							d.filter("a:not(.disabled,.cur)").click(function() {
								var o = $(this).attr("href"),
									n = o.split("/");
								return n = n[n.length - 1], n = n.replace(/.html/, ""), c(e, n), !1
							}), i.find(".paginate:eq(" + (e - 1) + ")").empty().append(d)
						} else i.find(".game-list-panel" + e).empty().append("<p class='txtCenter'>对不起，暂无数据</p>");
						n && n(e)
					},
					s = {
						1: 1,
						2: 4,
						3: 3,
						4: 5
					};
				$.ajax({
					url: "/public/manage/editshop/json/Design/getGame.json?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						p: parseInt(o),
						type: parseInt(s[e])
					},
					success: function(e) {
						1 == e.status ? l(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			},
			l = function(e, n) {
				i.on("click", ".game-list-panel" + n + " .j-select", function() {
					var i = $(".game-list-panel" + n + " li").index($(this).parent("li"));
					o && o(t[n][i], 5), $.jBox.close(e)
				})
			};
		c(1, 1, function(e) {
			$.jBox.show({
				title: "选择营销活动",
				content: i,
				btnOK: {
					show: !1
				},
				btnCancel: {
					show: !1
				},
				onOpen: function(o) {
					l(o, e), i.find(".j-tab-game").one("click", function() {
						var e = $(this).data("index");
						c(e, 1, function(e) {
							l(o, e)
						})
					})
				}
			})
		})
	}, HYD.popbox.dplPickerColletion = function(e) {
		var o = {
				linkType: 1,
				callback: null
			},
			n = $.extend(!0, {}, o, e);
		switch (parseInt(n.linkType)) {
			case 1:
				$.selectGoods({
					selectMod: 1,
					callback: function(e) {
						n.callback(e, 1)
					}
				});
				break;
			case 2:
				HYD.popbox.GoodsAndGroupPicker("group", n.callback);
				break;
			case 3:
				HYD.popbox.MgzAndMgzCate("mgz", n.callback);
				break;
			case 4:
				HYD.popbox.MgzAndMgzCate("mgzCate", n.callback);
				break;
			case 5:
				HYD.popbox.GamePicker("all", n.callback);
				break;
			case 6:
				var i = {
					title: "店铺主页",
					link: "/Shop/index"
				};
				n.callback(i, 6);
				break;
			case 7:
				var i = {
					title: "会员主页",
					link: "/User/index"
				};
				n.callback(i, 7);
				break;
			case 8:
				var i = {
					title: "分销申请",
					link: "/User/dist_apply"
				};
				n.callback(i, 8);
				break;
			case 9:
				var i = {
					title: "购物车",
					link: " /Item/cart"
				};
				n.callback(i, 9);
				break;
			case 10:
				var i = {
					title: "全部商品",
					link: " /Item/lists"
				};
				n.callback(i, 10);
				break;
			case 11:
				var i = {
					title: "",
					link: ""
				};
				n.callback(i, 11);
				break;
			case 12:
				var i = {
					title: "商品分类",
					link: "/Item/item_class"
				};
				n.callback(i, 12);
				break;
			case 13:
				var i = {
					title: "我的订单",
					link: "/Order/lists"
				};
				n.callback(i, 13)
		}
	}, HYD.ajaxPopTable = function(e) {
		var o, n, i = {
				title: "",
				url: "",
				width: "auto",
				minHeight: "auto",
				data: {
					p: 1
				},
				tpl: "",
				onOpen: null,
				onPageChange: null
			},
			t = $.extend(!0, {}, i, e),
			c = $("<div></div>"),
			l = function(e) {
				var i = t.tpl,
					s = t.url,
					a = function(s) {
						o = s;
						var a = _.template(i, s),
							r = $(a);
						c.empty().append(r), c.find(".paginate a:not(.disabled,.cur)").click(function() {
							for (var e = $(this).attr("href"), o = e.split("/"), n = 0; n < o.length; n++)
								if ("p" == o[n]) {
									t.data.p = o[n + 1].replace(/.html/, ""), l();
									break
								}
							return !1
						}), e && e(), t.onPageChange && t.onPageChange(n, o)
					};
				$.ajax({
					url: s + "?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: t.data,
					success: function(e) {
						1 == e.status ? a(e) : HYD.hint("danger", "对不起，获取数据失败：" + e.msg)
					}
				})
			};
		l(function() {
			$.jBox.show({
				title: t.title,
				width: t.width,
				minHeight: t.minHeight,
				content: c,
				btnOK: {
					show: !1
				},
				btnCancel: {
					show: !1
				},
				onOpen: function(e) {
					n = e, t.onOpen && t.onOpen(e, o)
				}
			})
		})
	}, HYD.regRules = {
		email: /^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i,
		mobphone: /^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/,
		telphone: /^0\d{2,3}(\-)?\d{7,8}$/,
		integer: /^\d+$/,
		"float": /^[\d]*\.?[\d]+$/
	}, HYD.popbox.iconimgsrc = {
		data: {
			style1: {
				color0: ["images/icon/style1/color0/icon_home.png", "images/icon/style1/color0/icon_allgoods.png", "images/icon/style1/color0/icon_newgoods.png", "images/icon/style1/color0/icon_user.png", "images/icon/style1/color0/icon_fx.png", "images/icon/style1/color0/icon_active.png", "images/icon/style1/color0/icon_hotsale.png", "images/icon/style1/color0/icon_subject.png", "images/icon/style1/color0/style1_gz0.png", "images/icon/style1/color0/style1_shopcar0.png"],
				color1: ["images/icon/style1/color1/icon_home.png", "images/icon/style1/color1/icon_allgoods.png", "images/icon/style1/color1/icon_newgoods.png", "images/icon/style1/color1/icon_user.png", "images/icon/style1/color1/icon_fx.png", "images/icon/style1/color1/icon_active.png", "images/icon/style1/color1/icon_hotsale.png", "images/icon/style1/color1/icon_subject.png", "images/icon/style1/color1/style1_gz1.png", "images/icon/style1/color1/style1_shopcar1.png"],
				color2: ["images/icon/style1/color2/icon_home.png", "images/icon/style1/color2/icon_allgoods.png", "images/icon/style1/color2/icon_newgoods.png", "images/icon/style1/color2/icon_user.png", "images/icon/style1/color2/icon_fx.png", "images/icon/style1/color2/icon_active.png", "images/icon/style1/color2/icon_hotsale.png", "images/icon/style1/color2/icon_subject.png", "images/icon/style1/color2/style1_gz2.png", "images/icon/style1/color2/style1_shopcar2.png"],
				color3: ["images/icon/style1/color3/icon_home.png", "images/icon/style1/color3/icon_allgoods.png", "images/icon/style1/color3/icon_newgoods.png", "images/icon/style1/color3/icon_user.png", "images/icon/style1/color3/icon_fx.png", "images/icon/style1/color3/icon_active.png", "images/icon/style1/color3/icon_hotsale.png", "images/icon/style1/color3/icon_subject.png", "images/icon/style1/color3/style1_gz3.png", "images/icon/style1/color3/style1_shopcar3.png"],
				color4: ["images/icon/style1/color4/icon_home.png", "images/icon/style1/color4/icon_allgoods.png", "images/icon/style1/color4/icon_newgoods.png", "images/icon/style1/color4/icon_user.png", "images/icon/style1/color4/icon_fx.png", "images/icon/style1/color4/icon_active.png", "images/icon/style1/color4/icon_hotsale.png", "images/icon/style1/color4/icon_subject.png", "images/icon/style1/color4/style1_gz4.png", "images/icon/style1/color4/style1_shopcar4.png"],
				color5: ["images/icon/style1/color5/icon_home.png", "images/icon/style1/color5/icon_allgoods.png", "images/icon/style1/color5/icon_newgoods.png", "images/icon/style1/color5/icon_user.png", "images/icon/style1/color5/icon_fx.png", "images/icon/style1/color5/icon_active.png", "images/icon/style1/color5/icon_hotsale.png", "images/icon/style1/color5/icon_subject.png", "images/icon/style1/color5/style1_gz5.png", "images/icon/style1/color5/style1_shopcar5.png"],
				color6: ["images/icon/style1/color6/icon_home.png", "images/icon/style1/color6/icon_allgoods.png", "images/icon/style1/color6/icon_newgoods.png", "images/icon/style1/color6/icon_user.png", "images/icon/style1/color6/icon_fx.png", "images/icon/style1/color6/icon_active.png", "images/icon/style1/color6/icon_hotsale.png", "images/icon/style1/color6/icon_subject.png", "images/icon/style1/color6/style1_gz6.png", "images/icon/style1/color6/style1_shopcar6.png"],
				color7: ["images/icon/style1/color7/icon_home.png", "images/icon/style1/color7/icon_allgoods.png", "images/icon/style1/color7/icon_newgoods.png", "images/icon/style1/color7/icon_user.png", "images/icon/style1/color7/icon_fx.png", "images/icon/style1/color7/icon_active.png", "images/icon/style1/color7/icon_hotsale.png", "images/icon/style1/color7/icon_subject.png", "images/icon/style1/color7/style1_gz7.png", "images/icon/style1/color7/style1_shopcar7.png"],
				color8: ["images/icon/style1/color8/icon_home.png", "images/icon/style1/color8/icon_allgoods.png", "images/icon/style1/color8/icon_newgoods.png", "images/icon/style1/color8/icon_user.png", "images/icon/style1/color8/icon_fx.png", "images/icon/style1/color8/icon_active.png", "images/icon/style1/color8/icon_hotsale.png", "images/icon/style1/color8/icon_subject.png", "images/icon/style1/color8/style1_gz8.png", "images/icon/style1/color8/style1_shopcar8.png"]
			},
			style2: {
				color0: ["images/icon/style2/color0/icon_home.png", "images/icon/style2/color0/icon_allgoods.png", "images/icon/style2/color0/icon_newgoods.png", "images/icon/style2/color0/icon_user.png", "images/icon/style2/color0/icon_fx.png", "images/icon/style2/color0/icon_active.png", "images/icon/style2/color0/icon_hotsale.png", "images/icon/style2/color0/icon_subject.png", "images/icon/style2/color0/style2_gz0.png", "images/icon/style2/color0/style2_shopcar0.png"],
				color1: ["images/icon/style2/color1/icon_home.png", "images/icon/style2/color1/icon_allgoods.png", "images/icon/style2/color1/icon_newgoods.png", "images/icon/style2/color1/icon_user.png", "images/icon/style2/color1/icon_fx.png", "images/icon/style2/color1/icon_active.png", "images/icon/style2/color1/icon_hotsale.png", "images/icon/style2/color1/icon_subject.png", "images/icon/style2/color1/style2_gz1.png", "images/icon/style2/color1/style2_shopcar1.png"],
				color2: ["images/icon/style2/color2/icon_home.png", "images/icon/style2/color2/icon_allgoods.png", "images/icon/style2/color2/icon_newgoods.png", "images/icon/style2/color2/icon_user.png", "images/icon/style2/color2/icon_fx.png", "images/icon/style2/color2/icon_active.png", "images/icon/style2/color2/icon_hotsale.png", "images/icon/style2/color2/icon_subject.png", "images/icon/style2/color2/style2_gz2.png", "images/icon/style2/color2/style2_shopcar2.png"],
				color3: ["images/icon/style2/color3/icon_home.png", "images/icon/style2/color3/icon_allgoods.png", "images/icon/style2/color3/icon_newgoods.png", "images/icon/style2/color3/icon_user.png", "images/icon/style2/color3/icon_fx.png", "images/icon/style2/color3/icon_active.png", "images/icon/style2/color3/icon_hotsale.png", "images/icon/style2/color3/icon_subject.png", "images/icon/style2/color3/style2_gz3.png", "images/icon/style2/color3/style2_shopcar3.png"],
				color4: ["images/icon/style2/color4/icon_home.png", "images/icon/style2/color4/icon_allgoods.png", "images/icon/style2/color4/icon_newgoods.png", "images/icon/style2/color4/icon_user.png", "images/icon/style2/color4/icon_fx.png", "images/icon/style2/color4/icon_active.png", "images/icon/style2/color4/icon_hotsale.png", "images/icon/style2/color4/icon_subject.png", "images/icon/style2/color4/style2_gz4.png", "images/icon/style2/color4/style2_shopcar4.png"],
				color5: ["images/icon/style2/color5/icon_home.png", "images/icon/style2/color5/icon_allgoods.png", "images/icon/style2/color5/icon_newgoods.png", "images/icon/style2/color5/icon_user.png", "images/icon/style2/color5/icon_fx.png", "images/icon/style2/color5/icon_active.png", "images/icon/style2/color5/icon_hotsale.png", "images/icon/style2/color5/icon_subject.png", "images/icon/style2/color5/style2_gz5.png", "images/icon/style2/color5/style2_shopcar5.png"],
				color6: ["images/icon/style2/color6/icon_home.png", "images/icon/style2/color6/icon_allgoods.png", "images/icon/style2/color6/icon_newgoods.png", "images/icon/style2/color6/icon_user.png", "images/icon/style2/color6/icon_fx.png", "images/icon/style2/color6/icon_active.png", "images/icon/style2/color6/icon_hotsale.png", "images/icon/style2/color6/icon_subject.png", "images/icon/style2/color6/style2_gz6.png", "images/icon/style2/color6/style2_shopcar6.png"],
				color7: ["images/icon/style2/color7/icon_home.png", "images/icon/style2/color7/icon_allgoods.png", "images/icon/style2/color7/icon_newgoods.png", "images/icon/style2/color7/icon_user.png", "images/icon/style2/color7/icon_fx.png", "images/icon/style2/color7/icon_active.png", "images/icon/style2/color7/icon_hotsale.png", "images/icon/style2/color7/icon_subject.png", "images/icon/style2/color7/style2_gz7.png", "images/icon/style2/color7/style2_shopcar7.png"],
				color8: ["images/icon/style2/color8/icon_home.png", "images/icon/style2/color8/icon_allgoods.png", "images/icon/style2/color8/icon_newgoods.png", "images/icon/style2/color8/icon_user.png", "images/icon/style2/color8/icon_fx.png", "images/icon/style2/color8/icon_active.png", "images/icon/style2/color8/icon_hotsale.png", "images/icon/style2/color8/icon_subject.png", "images/icon/style2/color8/style2_gz8.png", "images/icon/style2/color8/style2_shopcar8.png"]
			},
			style3: {
				color0: ["images/icon/style3/color0/icon_home.png", "images/icon/style3/color0/icon_allgoods.png", "images/icon/style3/color0/icon_newgoods.png", "images/icon/style3/color0/icon_user.png", "images/icon/style3/color0/icon_fx.png", "images/icon/style3/color0/icon_active.png", "images/icon/style3/color0/icon_hotsale.png", "images/icon/style3/color0/icon_subject.png", "images/icon/style3/color0/style3_gz0.png", "images/icon/style3/color0/style3_shopcar0.png"],
				color1: ["images/icon/style3/color1/icon_home.png", "images/icon/style3/color1/icon_allgoods.png", "images/icon/style3/color1/icon_newgoods.png", "images/icon/style3/color1/icon_user.png", "images/icon/style3/color1/icon_fx.png", "images/icon/style3/color1/icon_active.png", "images/icon/style3/color1/icon_hotsale.png", "images/icon/style3/color1/icon_subject.png", "images/icon/style3/color1/style3_gz1.png", "images/icon/style3/color1/style3_shopcar1.png"],
				color2: ["images/icon/style3/color2/icon_home.png", "images/icon/style3/color2/icon_allgoods.png", "images/icon/style3/color2/icon_newgoods.png", "images/icon/style3/color2/icon_user.png", "images/icon/style3/color2/icon_fx.png", "images/icon/style3/color2/icon_active.png", "images/icon/style3/color2/icon_hotsale.png", "images/icon/style3/color2/icon_subject.png", "images/icon/style3/color2/style3_gz2.png", "images/icon/style3/color2/style3_shopcar2.png"],
				color3: ["images/icon/style3/color3/icon_home.png", "images/icon/style3/color3/icon_allgoods.png", "images/icon/style3/color3/icon_newgoods.png", "images/icon/style3/color3/icon_user.png", "images/icon/style3/color3/icon_fx.png", "images/icon/style3/color3/icon_active.png", "images/icon/style3/color3/icon_hotsale.png", "images/icon/style3/color3/icon_subject.png", "images/icon/style3/color3/style3_gz3.png", "images/icon/style3/color3/style3_shopcar3.png"],
				color4: ["images/icon/style3/color4/icon_home.png", "images/icon/style3/color4/icon_allgoods.png", "images/icon/style3/color4/icon_newgoods.png", "images/icon/style3/color4/icon_user.png", "images/icon/style3/color4/icon_fx.png", "images/icon/style3/color4/icon_active.png", "images/icon/style3/color4/icon_hotsale.png", "images/icon/style3/color4/icon_subject.png", "images/icon/style3/color4/style3_gz4.png", "images/icon/style3/color4/style3_shopcar4.png"],
				color5: ["images/icon/style3/color5/icon_home.png", "images/icon/style3/color5/icon_allgoods.png", "images/icon/style3/color5/icon_newgoods.png", "images/icon/style3/color5/icon_user.png", "images/icon/style3/color5/icon_fx.png", "images/icon/style3/color5/icon_active.png", "images/icon/style3/color5/icon_hotsale.png", "images/icon/style3/color5/icon_subject.png", "images/icon/style3/color5/style3_gz5.png", "images/icon/style3/color5/style3_shopcar5.png"],
				color6: ["images/icon/style3/color6/icon_home.png", "images/icon/style3/color6/icon_allgoods.png", "images/icon/style3/color6/icon_newgoods.png", "images/icon/style3/color6/icon_user.png", "images/icon/style3/color6/icon_fx.png", "images/icon/style3/color6/icon_active.png", "images/icon/style3/color6/icon_hotsale.png", "images/icon/style3/color6/icon_subject.png", "images/icon/style3/color6/style3_gz6.png", "images/icon/style3/color6/style3_shopcar6.png"],
				color7: ["images/icon/style3/color7/icon_home.png", "images/icon/style3/color7/icon_allgoods.png", "images/icon/style3/color7/icon_newgoods.png", "images/icon/style3/color7/icon_user.png", "images/icon/style3/color7/icon_fx.png", "images/icon/style3/color7/icon_active.png", "images/icon/style3/color7/icon_hotsale.png", "images/icon/style3/color7/icon_subject.png", "images/icon/style3/color7/style3_gz7.png", "images/icon/style3/color7/style3_shopcar7.png"],
				color8: ["images/icon/style3/color8/icon_home.png", "images/icon/style3/color8/icon_allgoods.png", "images/icon/style3/color8/icon_newgoods.png", "images/icon/style3/color8/icon_user.png", "images/icon/style3/color8/icon_fx.png", "images/icon/style3/color8/icon_active.png", "images/icon/style3/color8/icon_hotsale.png", "images/icon/style3/color8/icon_subject.png", "images/icon/style3/color8/style3_gz8.png", "images/icon/style3/color8/style3_shopcar8.png"]
			}
		}
	}, $(function() {
		top.location != self.location && (top.location.href = self.location.href), $(".header-ctrl-item").hover(function() {
			var e = $(this);
			e.data("type"), e.data("cache");
			e.find(".header-ctrl-item-children").length && e.addClass("show")
		}, function() {
			$(this).removeClass("show")
		}), $(".tips").tooltips();
		var e = $(".container .inner");
		if (e.length) {
			var o = function() {
					HYD.Constant.windowHeight = $(this).height(), HYD.Constant.windowWidth = $(this).width(), HYD.Constant.containerOffset = e.offset(), HYD.Constant.containerWidth = e.outerWidth()
				},
				n = function() {
					$("#j-gotop").css("left", HYD.Constant.containerWidth + HYD.Constant.containerOffset.left + 10)
				};
			$(window).resize(function() {
				o(), n()
			}), o(), n()
		}
		$(window).scroll(function() {
				$(this).scrollTop() >= 150 ? $("#j-gotop").fadeIn(300) : $("#j-gotop").fadeOut(300)
			}), $.ajaxSetup({
				timeout: 2e4,
				error: function(e, o, n) {
					"timeout" == o && (HYD && HYD.hint ? HYD.hint("warning", "请求超时，请重试！") : alert("请求超时，请重试！"), $.jBox.hideloading())
				}
			}),
			function() {
				var e = function() {
					$.jBox.show({
						title: "温馨提示",
						width: 520,
						content: $("#tpl_jbox_domain_tip").html(),
						btnOK: {
							show: !1
						},
						btnCancel: {
							show: !1
						},
						onOpen: function() {},
						onClosed: function() {}
					})
				};
				window.is_domain_tip && e()
			}(), $(".js-save-btn").click(function() {
				HYD.hint("success", "恭喜，保存成功！")
			})
	}), $(function() {
		var e = $(".wxtables").find("input[type='checkbox'].table-ckbs");
		$(".btn_table_selectAll").click(function() {
			e.attr("checked", !0)
		}), $(".btn_table_Cancle").click(function() {
			e.attr("checked", !1)
		}), $(".paginate").each(function() {
			var e = $(this),
				o = e.find("input"),
				n = e.find(".goto"),
				i = window.location.href.toString();
			o.focus(function() {
				$(this).addClass("focus").siblings(".goto").addClass("focus")
			}), o.blur(function() {
				"" == $(this).val() && $(this).removeClass("focus").siblings(".goto").removeClass("focus")
			}), o.keypress(function(e) {
				var o = window.event ? e.keyCode : e.which;
				return 13 == o && (window.location.href = $(this).siblings("a.goto").attr("href")), 8 == o || 46 == o || 37 == o || 39 == o ? !0 : 48 > o || o > 57 ? !1 : !0
			}), o.keyup(function(e) {
				var o = $(this).val(),
					t = i.split("/"),
					c = t.length,
					l = !1,
					s = !1;
				"" == t[c - 1] && (t.pop(), c = t.length, l = !0), (l || "p" != t[c - 2]) && (t.push("p"), c = t.length, s = !0), l || s ? t[c] = o + ".html" : t[c - 1] = o + ".html", n.attr("href", t.join("/"))
			})
		})
	}), $(function() {
		$(document).on("click", ".tabs .tabs_a", function() {
			var e = $(this),
				o = e.data("origin"),
				n = 0;
			e.parent().hasClass("wizardstep") || e.parent().hasClass("nochange") || (e.addClass("active").siblings(".tabs_a").removeClass("active"), e.data("index") ? (n = e.data("index"), $(".tabs-content[data-origin='" + o + "']").find(".tc[data-index='" + n + "']").removeClass("hide").siblings(".tc").addClass("hide")) : (n = e.index(), $(".tabs-content[data-origin='" + o + "']").find(".tc:eq(" + n + ")").removeClass("hide").siblings(".tc").addClass("hide")))
		})
	}), $(function() {
		$(".alert.disable-del").each(function() {
			var e = $('<a href="javascript:;" class="alert-delete" title="隐藏"><i class="gicon-remove"></i></a>');
			e.click(function() {
				$(this).parent(".alert").fadeOut()
			}), $(this).append(e)
		}), _QV_ = "%E6%9D%AD%E5%B7%9E%E5%90%AF%E5%8D%9A%E7%A7%91%E6%8A%80%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E7%89%88%E6%9D%83%E6%89%80%E6%9C%89"
	}),
	function(e, o, n) {
		var i = {
			trigger: "hover"
		};
		e.fn.tooltips = function() {
			return this.each(function() {
				var o = function() {
						var o = e(this),
							n = o.data("content"),
							i = o.offset(),
							t = {
								width: o.outerWidth(!0),
								height: o.outerHeight(!0)
							},
							c = o.data("placement");
						if (this.tip = null, n = void 0 == n || "" == n ? n = o.text() : n, null == this.$tip) {
							var l = e("#tpl_tooltips").html();
							if (void 0 == l || "" == l) return void console.log("Please check template!");
							var s = _.template(l, {
								content: n,
								placement: c
							});
							this.$tip = e(s), e("body").append(this.$tip);
							var a = 0,
								r = 0,
								d = this.$tip.outerWidth(!0),
								g = this.$tip.outerHeight(!0);
							switch (c) {
								case "top":
									a = i.top + t.height + 5, r = i.left - 5;
									break;
								case "bottom":
									a = i.top - g - 5, r = i.left - 5;
									break;
								case "left":
									a = i.top - t.height / 2, r = i.left + t.width + 5;
									break;
								case "right":
									a = i.top + t.height / 2 - g / 2, r = i.left - d - 5
							}
							this.$tip.css({
								top: a,
								left: r
							})
						}
						this.$tip.stop(!0, !0).fadeIn(300)
					},
					n = function() {
						this.$tip && this.$tip.stop(!0, !0).fadeOut(300)
					},
					t = e(this).data("trigger");
				switch (t = void 0 != t && "" != t ? t : i.trigger) {
					case "hover":
						e(this).hover(o, n);
						break;
					case "click":
						e(this).click(o).mouseleave(n)
				}
			})
		}
	}(jQuery, document, window), $(function() {
		$(document).on("mouseover", ".droplist .j-droplist-toggle", function() {
			$(this).siblings(".droplist-menu").show()
		}), $(document).on("mouseleave", ".droplist .droplist-menu", function() {
			$(this).hide()
		}), $(document).on("mouseleave", ".droplist", function() {
			$(this).find(".droplist-menu").hide()
		}), $(document).on("click", ".droplist .droplist-menu a", function() {
			$(this).parents(".droplist-menu").hide()
		})
	}),
	function(e, o, n) {
		var i = {
				callback: null
			},
			t = {},
			c = {
				width: e(n).width(),
				height: e(n).height()
			},
			l = {
				main: e("#tpl_albums_main").html(),
				overlay: e("#tpl_albums_overlay").html(),
				tree: e("#tpl_albums_tree").html(),
				treeFn: e("#tpl_albums_tree_fn").html(),
				imgs: e("#tpl_albums_imgs").html()
			},
			s = {
				folderID: "",
				moveFolderID: 0,
				imgs: {}
			},
			a = {
				getFolderTree: "/public/manage/editshop/json/Design/getFolderTree.json",
				getSubFolderTree: "/Design/getSubFolderTree",
				getImgList: "/public/manage/editshop/json/Design/getImgList.json",
				/*addImg: "/public/manage/editshop/json/Design/uploadFile./public/manage/editshop/json/sid/" + e.cookie("shop_id"),*/
				addImg: "/public/manage/editshop/json/Design/uploadFile.json",
				moveImg: "/public/manage/editshop/json/Design/moveImg.json",
				delImg: "/public/manage/editshop/json/Design/delImg.json",
				addFolder: "/public/manage/editshop/json/Design/addFolder.json",
				renameFolder: "/public/manage/editshop/json/Design/renameFolder.json",
				delFolder: "/public/manage/editshop/json/Design/delFolder.json",
				moveCateImg: "/public/manage/editshop/json/Design/moveCateImg.json",
				renameImg: "/Design/renameImg"
			},
			r = function(o, n, i, t) {
				var c = arguments.callee,
					r = o.find("#j-panelImgs"),
					d = o.find("#j-panelPaginate"),
					g = n >= 0 ? {
						id: n,
						p: i,
						file_name: t
					} : {
						p: i,
						file_name: t
					};
				"undefined" == typeof GLOBAL_NEED_COMPRESS || 0 == GLOBAL_NEED_COMPRESS ? g.need_compress = 0 : g.need_compress = 1, e.ajax({
					url: a.getImgList + "?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: g,
					beforeSend: function() {
						r.find(".j-loading").show()
					},
					success: function(i) {
						if (1 == i.status) {
							s.imgs = _.isArray(i.data) ? i.data : null;
							var a = e(_.template(l.imgs, {
									dataset: s.imgs
								})),
								g = e(i.page);
							r.find(".j-loading").hide().end().find("ul,.j-noPic").remove().end().append(a), d.empty().append(g), g.filter("a:not(.disabled,.cur)").click(function() {
								var i = e(this).attr("href"),
									l = i.split("/");
								return l = l[l.length - 1], l = l.replace(/.html/, ""), c(o, n, l, t), !1
							})
						} else HYD.hint("danger", "对不起，图片获取失败：" + i.msg)
					}
				})
			};
		UpdateSubTreeNums = function(n) {
			if ("undefined" == typeof n) var n = e(o).find(".j-albumsNodes .selected").data("id");
			e.ajax({
				url: "/public/manage/editshop/json/Design/getAllSubFolderTree.json?v=" + Math.round(100 * Math.random()),
				type: "post",
				dataType: "json",
				data: {
					id: n
				},
				success: function(n) {
					if (1 == n.status) {
						var i = n.data.tree,
							t = e(o).find("#j-panelTree");
						i.push({
							id: "-1",
							picNum: n.data.total
						}, {
							id: "0",
							picNum: n.data.nocat_total
						});
						var c = function(e) {
							var o = arguments.callee;
							_.each(e, function(e) {
								t.find("dt[data-id=" + e.id + "]").find(".j-num").text(e.picNum), e.subFolder && e.subFolder.length && o(e.subFolder)
							})
						};
						c(i)
					} else console.log("更新文件夹树图片数量失败")
				}
			})
		}, e.albums = function(n) {
			t = e.extend(!0, {}, i, n);
			var d = e("#albums"),
				g = e("#albums-overlay");
			if (!d.length) {
				d = e(l.main), g = e(l.overlay), e("body").append(d.hide(), g.hide());
				var u = d.find("#j-close"),
					p = d.find("#j-addFolder"),
					m = d.find("#j-renameFolder"),
					f = d.find("#j-delFolder"),
					h = d.find("#j-addImg"),
					b = d.find("#j-moveImg"),
					y = d.find("#j-cateImg"),
					v = d.find("#j-delImg"),
					P = d.find("#j-panelTree"),
					$ = function() {
						d.fadeOut("fast"), g.fadeOut("fast"), d.find("#j-panelImgs li").removeClass("selected")
					};
				e.ajax({
					url: a.getFolderTree + "?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					success: function(o) {
						if (1 == o.status) {
							var n = _.template(l.treeFn),
								i = n({
									dataset: o.data.tree,
									templateFn: n
								}),
								t = e(_.template(l.tree, {
									dataset: o.data,
									nodes: i
								}));
							P.empty().append(t), d.find(".j-albumsNodes > dt:first").click()
						} else HYD.hint("danger", "对不起，文件夹获取失败：" + o.msg)
					}
				}), e(o).on("click", ".j-albumsNodes dt", function(o) {
					var n = e(this),
						i = n.data("id");
					if (n.parents(".j-albumsNodes").find("dt").removeClass("selected"), n.addClass("selected"), e(o.currentTarget).parents(".j-propagation").length) s.moveFolderID = i;
					else {
						if (s.folderID == i) return;
						s.folderID = i;
						var t = n.data("add"),
							c = n.data("rename"),
							l = n.data("del");
						1 == t ? p.show() : p.hide(), 1 == c ? m.show() : m.hide(), 1 == l ? f.show() : f.hide(), r(d, s.folderID, 1)
					}
					return !1
				});
				var j = function(o, n) {
					e.ajax({
						url: a.getSubFolderTree + "?v=" + Math.round(100 * Math.random()),
						type: "post",
						dataType: "json",
						data: {
							id: n
						},
						success: function(n) {
							if (1 == n.status) {
								var i = _.template(l.treeFn),
									t = i({
										dataset: n.data,
										templateFn: i
									});
								$render = e(t), o.parent("dt").siblings("dd").empty().append($render), $render.filter("dl").slideDown(200)
							}
						}
					})
				};
				e(o).on("click", ".j-albumsNodes dt i", function() {
					var o = e(this),
						n = o.parent("dt").siblings("dd").find(" > dl"),
						i = n.length,
						t = o.parent("dt").data("id");
					return o.hasClass("open") ? (o.removeClass("open"), n.slideUp(200)) : (o.addClass("open"), i ? n.slideDown(200) : j(o, t)), !1
				});
				var k = 0;
				d.on("click", "#j-panelImgs li", function() {
					return e(this).toggleClass("selected"), e(this).find(".img-name-edit").hide(), e(this).data("selectindex", k++), !1
				}), d.on("click", "#j-panelImgs li .albums-edit", function() {
					return e(this).children(".img-name-edit").show(), !1
				}), d.on("click", "#j-useImg", function() {
					if (!d.find("#j-panelImgs li.selected").length) return void HYD.hint("warning", "请选择图片！");
					var o = {},
						n = [];
					d.find("#j-panelImgs li.selected").each(function() {
						o[e(this).data("selectindex")] = s.imgs[e(this).index()].file
					});
					for (var i in o) n.push(o[i]);
					return t.callback && (t.callback(n), $()), !1
				}), p.click(function() {
					var o = [{
						id: 0,
						name: "未命名文件夹",
						picNum: 0
					}];
					e.ajax({
						url: a.addFolder + "?v=" + Math.round(100 * Math.random()),
						type: "post",
						dataType: "json",
						data: {
							name: o.name,
							parent_id: s.folderID
						},
						success: function(n) {
							if (1 == n.status) {
								o[0].id = n.data;
								var i = _.template(l.treeFn, {
									dataset: o
								});
								$render = e(i), P.find("dt[data-id='" + s.folderID + "']").siblings("dd").append($render), $render.css("display", "block"), $render.parent().siblings("dt").find(".icon-folder").addClass("open"), $render.find("dt:first").click(), m.click()
							} else HYD.hint("danger", "对不起，添加失败：" + n.msg)
						}
					})
				}), m.click(function() {
					var o = P.find("dt[data-id='" + s.folderID + "']"),
						n = o.find(".j-treeShowTxt"),
						i = o.find(".j-ip"),
						t = o.find(".j-loading");
					n.hide(), i.show().focus().select(), i.blur(function() {
						var o = e(this).val();
						e.ajax({
							url: a.renameFolder + "?v=" + Math.round(100 * Math.random()),
							type: "post",
							dataType: "json",
							data: {
								name: o,
								category_img_id: s.folderID
							},
							beforeSend: function() {
								t.css("display", "inline-block")
							},
							success: function(e) {
								1 == e.status ? n.find(".j-name").text(o) : HYD.hint("danger", "对不起，重命名失败：" + e.msg), n.show(), i.hide(), t.hide()
							}
						})
					})
				}), f.click(function() {
					var o = e("#tpl_albums_delFolder").html(),
						n = e(o),
						i = n.find("input[name=isDelImgs]");
					e.jBox.show({
						title: "提示",
						content: n,
						btnOK: {
							onBtnClick: function(o) {
								var n = i.filter(":checked").val();
								e.ajax({
									url: a.delFolder + "?v=" + Math.round(100 * Math.random()),
									type: "post",
									dataType: "json",
									data: {
										type: n,
										id: s.folderID
									},
									success: function(e) {
										if (1 == e.status) {
											UpdateSubTreeNums();
											var o = P.find("dt[data-id=" + s.folderID + "]").parent("dl");
											o.parent("dd").siblings("dt").click(), o.remove()
										} else HYD.hint("danger", "对不起，删除失败失败：" + e.msg)
									}
								}), e.jBox.close(o)
							}
						}
					})
				}), v.click(function() {
					if (!d.find("#j-panelImgs li.selected").length) return void HYD.hint("warning", "请选择要删除的图片！");
					var o = [];
					d.find("#j-panelImgs li.selected").each(function() {
						o.push(e(this).data("id"))
					}), e.ajax({
						url: a.delImg + "?v=" + Math.round(100 * Math.random()),
						type: "post",
						dataType: "json",
						data: {
							file_id: o
						},
						success: function(o) {
							1 == o.status ? (d.find("#j-panelImgs li.selected").fadeOut(300, function() {
								e(this).remove()
							}), UpdateSubTreeNums()) : HYD.hint("danger", "对不起，删除失败：" + o.msg)
						}
					})
				}), h.uploadify({
					debug: !1,
					auto: !0,
					width: 86,
					height: 28,
					multi: !0,
					swf: "/public/manage/editshop/js/uploadify.swf",
					uploader: a.addImg,
					buttonText: "上传图片",
					fileSizeLimit: "5MB",
					fileTypeExts: "*.jpg; *.jpeg; *.png; *.gif; *.bmp",
					onUploadStart: function() {
						h.uploadify("settings", "formData", {
							cate_id: -1 == s.folderID ? 0 : s.folderID,
							PHPSESSID: e.cookie("PHPSESSID")
						})
					},
					onSelectError: function(e, o, n) {
						switch (o) {
							case -100:
								HYD.hint("danger", "对不起，系统只允许您一次最多上传10个文件");
								break;
							case -110:
								HYD.hint("danger", "对不起，文件 [" + e.name + "] 大小超出5MB！");
								break;
							case -120:
								HYD.hint("danger", "文件 [" + e.name + "] 大小异常！");
								break;
							case -130:
								HYD.hint("danger", "文件 [" + e.name + "] 类型不正确！")
						}
					},
					onFallback: function() {
						HYD.hint("danger", "您未安装FLASH控件，无法上传图片！请安装FLASH控件后再试。")
					},
					onUploadSuccess: function(e, o, n) {
						console.log(e, o, n)
					},
					onQueueComplete: function(e) {
						r(d, s.folderID, 1), UpdateSubTreeNums()
					},
					onUploadError: function(e, o, n, i) {
						HYD.hint("danger", "对不起：" + e.name + "上传失败：" + i)
					}
				}), b.click(function() {
					if (!d.find("#j-panelImgs li.selected").length) return void HYD.hint("warning", "请选择要移动的图片！");
					var o = e("<div class='albums-cl-tree j-albumsNodes j-propagation'></div>");
					o.append(P.find("dd:first").contents().clone()), e.jBox.show({
						title: "请选择移动文件夹",
						content: o,
						onOpen: function() {
							o.find("dt:first").click()
						},
						btnOK: {
							onBtnClick: function(o) {
								var n = [];
								d.find("#j-panelImgs li.selected").each(function() {
									n.push(e(this).data("id"))
								}), e.ajax({
									url: a.moveImg + "?v=" + Math.round(100 * Math.random()),
									type: "post",
									dataType: "json",
									data: {
										file_id: n,
										cate_id: s.moveFolderID
									},
									success: function(n) {
										if (1 == n.status) {
											var i = e(o).find(".j-albumsNodes .selected").data("id");
											d.find("#j-panelImgs li.selected").fadeOut(300, function() {
												e(this).remove()
											}), UpdateSubTreeNums(), UpdateSubTreeNums(i), HYD.hint("success", "恭喜您，操作成功！")
										} else HYD.hint("danger", "对不起，移动失败：" + n.msg)
									}
								}), e.jBox.close(o)
							}
						}
					})
				}), y.click(function() {
					if (!s.folderID) return void HYD.hint("warning", "请选择要移动的分类！");
					var o = e("<div class='albums-cl-tree j-albumsNodes j-propagation'></div>");
					o.append(P.find("dd:first").contents().clone()), e.jBox.show({
						title: "请选择移动文件夹",
						content: o,
						onOpen: function() {
							o.find("dt:first").click()
						},
						btnOK: {
							onBtnClick: function(o) {
								e.ajax({
									url: a.moveCateImg + "?v=" + Math.round(100 * Math.random()),
									type: "post",
									dataType: "json",
									data: {
										cid: s.folderID,
										cate_id: s.moveFolderID
									},
									success: function(n) {
										if (1 == n.status) {
											var i = e(o).find(".j-albumsNodes .selected").data("id");
											d.find("#j-panelImgs li.selected").fadeOut(300, function() {
												e(this).remove()
											}), UpdateSubTreeNums(), UpdateSubTreeNums(i), HYD.hint("success", "恭喜您，操作成功！")
										} else HYD.hint("danger", "对不起，移动失败：" + n.msg)
									}
								}), e.jBox.close(o)
							}
						}
					})
				}), u.click($)
			}
			d.fadeIn("fast"), g.fadeIn("fast"), d.outerHeight() >= c.height && d.css({
				position: "absolute",
				marginTop: "0",
				top: e(o).scrollTop() + 10
			}), d.on("click", ".renameImg", function() {
				var o = e(this),
					n = o.closest("li").data("id"),
					i = o.siblings("input.file_name").val();
				return e.ajax({
					url: a.renameImg + "?v=" + Math.round(100 * Math.random()),
					type: "post",
					dataType: "json",
					data: {
						file_id: n,
						file_name: i
					},
					success: function(e) {
						1 == e.status ? (o.closest(".albums-edit").children(".img-name-edit").hide(), o.closest(".albums-edit").children("p").html(i), o.closest(".albums-edit").children("input.file_name").val(i), HYD.hint("success", "恭喜您，操作成功！")) : HYD.hint("danger", "对不起，操作失败")
					}
				}), !1
			}), d.on("click", ".searchImg", function() {
				var o = e(this).prev().val();
				r(d, s.folderID, 1, o)
			})
		}
	}(jQuery, document, window), _QV_ = "%E6%9D%AD%E5%B7%9E%E5%90%AF%E5%8D%9A%E7%A7%91%E6%8A%80%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8%E7%89%88%E6%9D%83%E6%89%80%E6%9C%89", HYD.popbox.ImgPicker = function(e) {
		$.albums({
			callback: e
		})
	}, $(function() {
		var e = '<span class="autosave-loading"></span>',
			o = '<span class="save-success"><em class="gicon-ok white"></em>已自动保存</span>',
			n = "undefined" != typeof URL_virChkb && URL_virChkb.length ? URL_virChkb : window.location.href;
		$(".j-vir-chkb").each(function() {
			var e = $(this),
				o = e.find(".vir-chkb-actions"),
				i = e.find(".vir-chkb-enable"),
				t = e.find(".vir-chkb-disable"),
				c = e.find(".j-vir-checkbox"),
				l = c.is(":checked") ? !0 : !1;
			l ? (o.removeClass("disable").addClass("enable"), i.show(), t.hide()) : (o.removeClass("enable").addClass("disable"), i.hide(), t.show()), c.change(function() {
				var e, o = $(this),
					i = o.attr("name"),
					t = {};
				e = "undefined" == typeof o.data("enableval") ? o.is(":checked") ? 1 : 0 : o.is(":checked") ? o.data("enableval") : o.data("disableval"), t.name = i, t.value = e;
				var c = o.siblings(".j-vir-formdata");
				c.each(function() {
					var e = $(this);
					t[e.data("name")] = e.val()
				}), $.ajax({
					url: n + "?v=" + Math.round(100 * Math.random()),
					type: "POST",
					dataType: "json",
					data: t,
					success: function(e) {
						1 != e.status && HYD.hint("danger", "对不起，保存失败：" + e.msg)
					}
				})
			}), o.show().click(function() {
				l ? (t.show(), o.animate({
					left: -66
				}, 150, function() {
					i.hide()
				}), c.attr("checked", !1), l = !1) : (i.show(), o.animate({
					left: 0
				}, 150, function() {
					t.hide()
				}), c.attr("checked", !0), l = !0), c.trigger("change")
			})
		}), $(".j-text-autosave,.j-select-autosave").change(function() {
			var i = $(this),
				t = i.attr("name"),
				c = i.val(),
				l = $(e),
				s = i.get(0).nextSibling,
				a = s ? $(s) : i;
			$.ajax({
				url: n + "?v=" + Math.round(100 * Math.random()),
				type: "POST",
				dataType: "json",
				data: {
					name: t,
					value: c
				},
				beforeSend: function() {
					l.insertAfter(a)
				},
				success: function(e) {
					l.fadeOut("fast", function() {
						if ($(this).remove(), 1 == e.status) {
							var n = $(o);
							n.insertAfter(a).animate({
								opacity: 1
							}, 200, function() {
								setTimeout(function() {
									n.fadeOut("fast", function() {
										n.remove()
									})
								}, 1e3)
							})
						} else HYD.hint("danger", "对不起，保存失败：" + e.msg)
					})
				}
			})
		}), $(".j-radio-autosave").change(function() {
			var i = $(this),
				t = i.parents(".form-controls").find(".j-autosavePanel"),
				c = i.attr("type"),
				l = i.attr("name"),
				s = i.val();
			if ("radio" == c) {
				var a = $(e);
				$.ajax({
					url: n + "?v=" + Math.round(100 * Math.random()),
					type: "POST",
					dataType: "json",
					data: {
						name: l,
						value: s
					},
					beforeSend: function() {
						t.append(a)
					},
					success: function(e) {
						a.fadeOut("fast", function() {
							if ($(this).remove(), 1 == e.status) {
								var n = $(o);
								t.append(n), n.animate({
									opacity: 1
								}, 200, function() {
									setTimeout(function() {
										n.fadeOut("fast", function() {
											n.remove()
										})
									}, 1e3)
								})
							} else HYD.hint("danger", "对不起，保存失败：" + e.msg)
						})
					}
				})
			}
		});
		var i = {};
		$(".j-checkbox-autosave").each(function() {
			var t = $(this),
				c = t.parents(".form-controls").find(".j-autosavePanel"),
				l = (t.attr("type"), t.attr("name")),
				s = function() {
					var i = [];
					$("input[name='" + l + "']").each(function() {
						$(this).is(":checked") && i.push($(this).val())
					});
					var t = $(e);
					$.ajax({
						url: n + "?v=" + Math.round(100 * Math.random()),
						type: "POST",
						dataType: "json",
						data: {
							name: l,
							value: i
						},
						beforeSend: function() {
							c.append(t)
						},
						success: function(e) {
							t.fadeOut("fast", function() {
								if ($(this).remove(), 1 == e.status) {
									var n = $(o);
									c.append(n), n.animate({
										opacity: 1
									}, 200, function() {
										setTimeout(function() {
											n.fadeOut("fast", function() {
												n.remove()
											})
										}, 1e3)
									})
								} else HYD.hint("danger", "对不起，保存失败：" + e.msg)
							})
						}
					})
				};
			i[l] = null, t.change(function() {
				i[l] && clearTimeout(i[l]), i[l] = setTimeout(s, 800)
			})
		})
	});
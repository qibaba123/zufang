  // 微信分享方法    
function fx(shareTitle,ShareTimeline,descContent,lineLink,imgUrl){
//分享朋友圈
		wx.onMenuShareTimeline({
			title: ShareTimeline, // 分享标题
			link: lineLink, // 分享链接
			imgUrl: imgUrl, // 分享图标
			trigger: function (res) {
                        //alert('用户点击发送给朋友');
            },
			success: function () { 
				//alert("success");
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				//alert("cancel");
				// 用户取消分享后执行的回调函数
			}
		});
		//分享朋友
		wx.onMenuShareAppMessage({
			title: shareTitle, // 分享标题
			desc: descContent, // 分享描述
			link: lineLink, // 分享链接
			imgUrl: imgUrl, // 分享图标
			type: 'link', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			//dataUrl: 'http://www.digitalwe.cn/zhsp/1.mp4',
			//dataUrl: '',
			trigger: function (res) {
                        //alert('用户点击发送给朋友');
            },
			success: function () { 	  		 
				// 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});		 
		//分享到QQ
		wx.onMenuShareQQ({
			title: shareTitle, // 分享标题
			desc: descContent, // 分享描述
			link: lineLink, // 分享链接
			imgUrl: imgUrl, // 分享图标
			success: function () { 
			     
			},
			cancel: function () { 
			   // 用户取消分享后执行的回调函数
			}
		});			
		//分享到weibo
		wx.onMenuShareWeibo({
			title: shareTitle, // 分享标题
			desc: descContent, // 分享描述
			link: lineLink, // 分享链接
			imgUrl: imgUrl, // 分享图标
			success: function () {  
			   // 用户确认分享后执行的回调函数
			},
			cancel: function () { 
				// 用户取消分享后执行的回调函数
			}
		});		
}

 
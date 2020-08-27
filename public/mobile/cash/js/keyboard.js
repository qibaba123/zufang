	$(function(){
		/*取得要操作的元素*/
		var finishBtn = $(".js-ok");
		var cursorEle = $("#js-cashier-cursor");
		var uiKeyboard = $("#ui-keyboard");
		var cashierField = $(".cashier-field");
		var keyboardNum = $(".ui-keyboard-numbers li");
		var cashierNum = $("#cashier-num");
		var delBtn = $(".js-del");
		/*虚拟键盘完成按钮*/
		finishBtn.on('touchstart', function(event) {
			event.preventDefault();
			cursorEle.css("display","none");
			uiKeyboard.removeClass('on');
			var curNumber = cashierNum.text()=='' ? 0:cashierNum.text();
			var curVal = parseFloat(curNumber);
		});

		cashierField.on('touchstart', function(event) {
			event.preventDefault();
			cursorEle.css("display","");
			uiKeyboard.addClass('on');
		});

		delBtn.on('touchstart', function(event) {
			event.preventDefault();
			var proNum = cashierNum.text();
			var finalNum = proNum.substring(0,proNum.length-1);
			// console.log(finalNum);
			cashierNum.text(finalNum);
		});

		keyboardNum.each(function(){
			var _this = $(this);
			_this.on('touchstart', function(event) {
				event.preventDefault();
				var curNum = $(this).text();
				var proNum = cashierNum.text()=='' ? 0:cashierNum.text();
				var showVal = proNum +""+ curNum;
				if(/\./.test(proNum)){//之前已经输入小数点了
					if(!/\.([0-9]{0,1}$)/.test(proNum)){//小数点之后已经有两位了
						showVal = proNum;
					}else if(curNum=='.'){//已经有小数点 还要再次输入小数点
						showVal = proNum;
					}
				}else{
					if(parseInt(proNum)==0){
						showVal = curNum;
					}
				}

				//判断最后生成的数字是不是以  . 开头
				if(/^\./.test(showVal)){
					showVal='0'+showVal;
				}

				cashierNum.text(showVal);
			});
		});
	});
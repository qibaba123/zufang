window.onload = function (){
	/*获取拖动元素*/
	var oDiv = document.getElementById('messages');
	/*获取设备及拖动元素宽高*/
	var boxWidth = window.screen.availWidth,
		boxHeight = window.screen.availHeight,
		oDivWidth = oDiv.offsetWidth,
		oDivHeight = oDiv.offsetHeight;
	var startTime = 0,endTime = 0, gap = 0;
	function touchStart(ev){
		startTime = new Date().getTime();
		//获取事件对象
		var oEvent = ev||event;
		/*阻止start默认事件*/
		stopDefault(oEvent);
		//获取第一根手指信息
		var oTouch0 = oEvent.touches[0];
		
		//利用第一根手指信息计算出 手指触摸位置到物体左上角的横向和纵向距离
		var disX = oTouch0.clientX-oDiv.offsetLeft;
		var disY = oTouch0.clientY-oDiv.offsetTop;
		

		bindTouchmove(document,touchMove);
		bindTouchend(document,touchEnd);
		function touchMove(ev){
			var oEvent = ev||event;
			var oTouch0 = oEvent.touches[0];

			var limitL = boxWidth - oDivWidth;
			var limitT = boxHeight - oDivHeight;

			//当手指移动时算出最新的位置信息
			var l = oTouch0.clientX-disX;
			var t = oTouch0.clientY-disY;
			if(l>limitL){
				l = limitL;
			}else if(l<0){
				l = 0;
			}
			if(t>limitT){
				t = limitT;
			}else if(t<0){
				t = 0;
			}

			//改变样式 设置最新位置
			oDiv.style.left = l+'px';
			oDiv.style.top = t+'px';
		};


		function touchEnd(){
			endTime = new Date().getTime();
			gap = endTime - startTime;
			if(gap<300){
				jumpPage();
			}
			//触摸结束 清除事件
			document.removeEventListener('touchmove',touchMove,false);
			document.removeEventListener('touchend',touchEnd,false);
		};

	}
	/*触摸开始执行*/
	bindTouchstart(oDiv,touchStart);
};

//绑定start事件
function bindTouchstart(obj,fn){
	obj.addEventListener('touchstart',fn,false);
}
//绑定move事件
function bindTouchmove(obj,fn){
	obj.addEventListener('touchmove',fn,false);
}

//绑定end事件
function bindTouchend(obj,fn){
	obj.addEventListener('touchend',fn,false);
}

/*阻止默认事件*/
function stopDefault( e ) { 
    if ( e && e.preventDefault ) 
        e.preventDefault(); 
    else 
        window.event.returnValue = false; 
    	return false; 
} 

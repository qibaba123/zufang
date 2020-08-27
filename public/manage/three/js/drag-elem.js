function dragElem(id,parentId,fn){
	/*获取拖动元素*/
	var oParentdiv = getElem(parentId);
	var oDiv = getElem(id);
	var curX = 0,curY = 0;
	/*获取设备及拖动元素宽高*/
	var oDivWidth = oDiv.offsetWidth,
		oDivHeight = oDiv.offsetHeight;
		boxWidth = oParentdiv.offsetWidth;
		boxHeight = oParentdiv.offsetHeight;
	
	var startTime = 0,endTime = 0, gap = 0;
	function mouseDown(ev){
		startTime = new Date().getTime();
		//获取事件对象
		var oEvent = ev||event;
		/*阻止start默认事件*/
		stopDefault(oEvent);
		
		//利用第一根手指信息计算出 手指触摸位置到物体左上角的横向和纵向距离
		var disX = oEvent.clientX-oDiv.offsetLeft;
		var disY = oEvent.clientY-oDiv.offsetTop;
		
		bindMousemove(document,mouseMove);
		bindMouseup(document,mouseUp);
		function mouseMove(ev){
			var oEvent = ev||event;
			var limitL = boxWidth;
			var limitT = boxHeight;

			//当手指移动时算出最新的位置信息
			var l = oEvent.clientX-disX;
			var t = oEvent.clientY-disY;
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
			curX = l;
			curY = t;
			//改变样式 设置最新位置
			oDiv.style.left = l+'px';
			oDiv.style.top = t+'px';
		}

		function mouseUp(){
			if(fn){
				fn({
					x:curX,
					y:curY
				})
			}
			//触摸结束 清除事件
			document.removeEventListener('mousemove',mouseMove,false);
			document.removeEventListener('mouseup',mouseUp,false);
		}
	}
	/*触摸开始执行*/
	bindMovedown(oDiv,mouseDown);

}
function getElem(id){
	var oDiv = document.getElementById(id);
	return oDiv;
}
//绑定Mousedown事件
function bindMovedown(obj,fn){
	obj.addEventListener('mousedown',fn,false);
}
//绑定Mousemove事件
function bindMousemove(obj,fn){
	obj.addEventListener('mousemove',fn,false);
}

//绑定MouseUp事件
function bindMouseup(obj,fn){
	obj.addEventListener('mouseup',fn,false);
}
/*阻止默认事件*/
function stopDefault( e ) { 
    if ( e && e.preventDefault ) 
        e.preventDefault(); 
    else 
        window.event.returnValue = false; 
    return false; 
}
/*阻止事件冒泡*/
function stopProp(e){
    window.event? window.event.cancelBubble = true : e.stopPropagation();
}
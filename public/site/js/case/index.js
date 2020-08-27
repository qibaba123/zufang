//蒙版

		$(".panel").click(function(){
			$(".panelContent").hide();
			$(".panel").hide();
		})
//		标题
		$(".addTittle").click(function(){
		   $(".moreTittleHidden").fadeToggle();
		   var isShow = $(".moreTittleHidden").css("display");
		   if(isShow=='block'){
		   	$('body').css('overflow','hidden');
		   }else{
		   	$('body').css('overflow','auto');
		   }
		   console.log($(".moreTittleHidden").css("display"))
		})
//		更多内容隐藏
		$(".closeButton").click(function(){
		   $(".moreTittleHidden").fadeOut();
		   $('body').css('overflow','auto');
		})
		$(".moreTittle").click(function(){
		   $(".moreTittleHidden").fadeOut();
		   $('body').css('overflow','auto');
		})
		
//	导航栏	
$(function(){
   /* $(".mainBox .mainList").hide();
    for(i = 0;i<6;i++){
      	   $(".mainBox .mainList").eq(i).show();
    }*/
    
   $(".contest-tittle ul li").click(function(){ 
              
      	$(this).addClass("active").siblings().removeClass("active");
      	var index = $(this).index();
      	if(index != 6){                 //按钮不能算
      	   var start = index*3;
      	
      	 $(".mainBox .mainList").hide();
		  	for(i = start;i<start+3;i++){
		  	   $(".mainBox .mainList").eq(i).show();
		  	} 
      	}
      	            
      })
      
      /*$(".mainBox .mainList button").click(function(){
	 var name   = $(this).data('name');
	 var src    = $(this).data('src');
	 var qrcode = $(this).data('qrcode');
	 $(".panelList img").attr('src',src);
	 $(".panelShare").html(name);
	 $(".codeImg img").attr('src',qrcode);
	 $(".panelContent").show();
	 var h=$(window).height();
	 $(".panel").height(h);
	 $(".panel").show();

	 })*/


      $(".topicList span").click(function(){
          $(this).addClass("active").siblings().removeClass("active");
      	  var index = $(this).index();
      	  var start = index*3 + 18;

      	 $(".mainBox .mainList").hide();
      	 for(i = start;i<start+3;i++){
      	   $(".mainBox .mainList").eq(i).show();
      	 }
		 $(".moreTittleHidden").fadeOut();

      });
})		

 
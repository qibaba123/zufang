$(function(){
	//	立即支付
	$('.pay-btn').click(function(){
        let amount  = $('#amount').val();
		if(amount){

			console.log(amount);
			var url  = '/jhpay/doPay/amount/'+amount;
			if(url){
				$('.pay-msg-bottom').hide();
				$('.pay-img').attr('src',url);
				$('.need-pay-num').html('￥<text>'+amount+'</text>');
				$('.pay-code').fadeIn();
			}else{
				layer.msg('二维码生成异常');
			}

			/*$.ajax({
				'type' : 'post',
				'url'  : '/jhpay/doPay',
				'data' : {'amount':amount},
				'dataType' : 'json',
				'success'  : function (ret) {
					console.log(ret);
					if(ret.ec == 200){
						$('.pay-msg-bottom').hide();
						$('.pay-img').attr('src',ret.url);
						$('.need-pay-num').html('￥<text>'+amount+'</text>')
						$('.pay-code').fadeIn();

					}else{
						layer.msg(ret.em);
					}
				}
			});*/

		}else{
			layer.msg('请填写金额哦');
		}

	})
	
	//重新输入
	$('.change-pay-num').click(function(){
		$('.pay-code').hide();
		$('.pay-msg-bottom').fadeIn();
	})
})

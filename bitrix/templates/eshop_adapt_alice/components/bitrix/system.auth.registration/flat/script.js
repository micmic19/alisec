function refreshcaptcha(url){
	$.post(url,
		{'ajax':'y'},
		function(data) {
			$("#captcha_sid").val(data);
			$("#captcha_image_sid").attr("src","/bitrix/tools/captcha.php?captcha_sid="+data)
	});
} 
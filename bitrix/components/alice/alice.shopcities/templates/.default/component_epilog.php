<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	//downclock
	//$APPLICATION->AddHeadScript($templateFolder.'/flipclock.min.js');
	//$APPLICATION->SetAdditionalCSS($templateFolder.'/flipclock.css');		

	if (!($USER->IsAdmin() || CLightHTMLEditor::IsMobileDevice()))
		echo $arResult["UF_SHOP_CITY"]["~PROPERTY_JIVO_SITE_VALUE"]["TEXT"];
?>
<script>
	setTimeout(function(){
	  $("#jivo_container").contents().find("#jivo-label-copyright").css("display","none");  
	},5000);	
</script>
<?if (empty($_SESSION["jivo_chat_widget_expand"]) && empty($_POST["jivo_chat_widget_expand"])):?>
	<script>
	setTimeout(function(){
		if ($("#jivo_container").contents().find("#jivo_chat_widget_online").length == 0) return false;
		$("#jivo_container").contents().find("#jivo-label").trigger("click");//jivo site activate
		$.post('<?=$componentPath."/ajax.php"?>', {jivo_chat_widget_expand:true});
		setTimeout(function(){
		var messages_div_inner_clear = $("#jivo_container").contents().find("#messages-div-inner-clear");
		messages_div_inner_clear.html('<div class="new-msg-container agentMessage green  new-msg-animate"><div class="pip"></div><div class="new-msg-body agentMessage"><div class="new-msg-body-inner"><div class="new-msg-text " style="height: 30px;"><div class="new-msg-text-inner">Здравствуйте! Могу ли я вам чем-то помочь?</div>/div></div></div><div class="new-time">'+new Date().getHours() +':'+new Date().getMinutes()+'</div></div>');
		$("#jivo_container").contents().find("#jivosite-adword").css("display","none");		
		$("#jivo_close_button").css("background-size","cover");
		//$("#jivo_close_button").css("padding","14px");
		}, 2000);
	}, 30000);
	</script>
<?endif?>
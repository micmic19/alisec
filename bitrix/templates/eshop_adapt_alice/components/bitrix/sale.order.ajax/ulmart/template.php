<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
    <?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");?>
<?
	if ($_REQUEST["is_ajax_post"] == "Y" && $_REQUEST["show_delivery_info"]=="Y"){
		$arResult["OUTPOST_ID"] = $_REQUEST["OUTPOST_ID"];
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/self_delivery_info.php");
		die();
	}	
?>
<?
	if ($_REQUEST["is_ajax_post"] == "Y" && $_REQUEST["recalc_summary"]=="Y"){
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
		die();
	}	
?>

	<?if ($arResult["DELIVERY_STEP"] == 1):?>
		<div id="ajax-content-step1">
			<table id="del-content-step1" class="sale_order_table props">
				<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["TEMPLATE_LOCATION"],false,"b-go-сhargestep", "del-content-step1", $arParams["DELIVERY_ORDER_PROPS_STEP1_REQ"]);?>
			</table>
			<div class="bt3-wrapper"><a id="b-go-сhargestep" href="#" class="bt3 <?if (!CheckFillFields($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["DELIVERY_ORDER_PROPS_STEP1_REQ"])) echo "disabled"?>" onclick="gochargestep()">Продолжить</a></div>
		</div>
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");?>
	<?endif;?>

	<?if ($arResult["DELIVERY_STEP"] > 1):?>
		<div id="ajax-content-step1">
			<table id="del-content-step1" class="sale_order_table props">
				<tr><td><a href="#" onclick="goaddressstep()"><b>Изменить</b></a></td></tr>
				<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["TEMPLATE_LOCATION"],true,"","",$arParams["DELIVERY_ORDER_PROPS_STEP1_REQ"]);?>
			</table>
		</div>
	<?endif;?>
	<?if ($arResult["DELIVERY_STEP"] >= 2):?>
		<div id="ajax-content-step2">
			<?if($arResult["DELIVERY_STEP"] == 3):?>
				<tr><td><a href="#" onclick="gochargestep()"><b>Изменить</b></a></td></tr>
			<?endif?>
			<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");?>
		</div>
	<?endif;?>
	<?if ($arResult["DELIVERY_STEP"] == 3):?>	
		<div id="ajax-content-step3">
			<table id="del-content-step3" class="sale_order_table props">
				<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["TEMPLATE_LOCATION"], false, "b-go-make-delivery-order", "del-content-step3", $arParams["DELIVERY_ORDER_PROPS_STEP3_REQ"]);?>
			</table>
			<div class="bt3-wrapper"><a id="b-go-make-delivery-order" href="#" class="bt3 <?if (!CheckFillFields($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["DELIVERY_ORDER_PROPS_STEP3_REQ"])) echo "disabled"?>" onclick="submitForm(this)">Оформить заказ</a></div>
		</div>
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");?>
	<?endif;?>	
	<?if (!empty($arResult["DELIVERY_STEP"])) die();?>		

	<div id="dummy_ajax" style="display:none;"></div>
<?CUtil::InitJSCore(array('fx', 'popup', 'window', 'ajax'));?>

<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>
<? 

if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
{
	if(!empty($arResult["ERROR"]))
	{
		foreach($arResult["ERROR"] as $v)
			echo ShowError($v);
	}
	elseif(!empty($arResult["OK_MESSAGE"]))
	{
		foreach($arResult["OK_MESSAGE"] as $v)
			echo ShowNote($v);
	}

	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
}
else
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			?>
			<script>
			<!--
			window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			//-->
			</script>
			<?
			die();
		}
		else
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
		}
	}
	else
	{
		?>
		<script>
		<!--
		/*function submitForm(val)
		{
			if(val != 'Y')
				BX('confirmorder').value = 'N';
			else
				BX('confirmorder').value = 'Y';
				
			var orderForm = BX('ORDER_FORM');
			
			BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);
			//BX.submit(orderForm);

			return true;
		}*/

		function SetContact(profileId)
		{
			BX("profile_change").value = "Y";
			submitForm();
		}
		//-->
		</script>
		<?if($_POST["is_ajax_post"] != "Y")
		{
			?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" onsubmit="return false">
			<?=bitrix_sessid_post()?>
			<div id="order_form_content">

    <h1 class="main-hxl main-hxl_bold">Выберите способ получения заказа</h1>
	<div id="error-holder"></div>
	<div class="b-tabs">
		<div id="bt-delivery" class="b-tab col-md-3 col-xs-12" onclick="SelectTypeDelivery(this);">
			<span>Доставка по СПб и ЛО</span>
		</div>
		<div id="bt-self-delivery" onclick="SelectTypeDelivery(this);" class="b-tab col-md-3 col-xs-12 selected">
			<span>Заберу самостоятельно</span>
		</div>
		<div id="bt-ozon-delivery" class="b-tab col-md-3 col-xs-12" onclick="SelectTypeDelivery(this);">
			<span>Доставка через Озон</span>
		</div>
	</div>
	<div class="tab-content">
		<div id="tab-delivery">
			<div>
				<h4>Доставка от Элис – самый удобный и быстрый способ получения товара</h4>
				<div class="point-delivery">
					<ul>
						<li>Осмотреть товар и принять решение о покупке вы можете до оплаты.</li>
						<li>А если форс-мажор, и вы попали в 1% тех, к кому не успели в день доставки — следующая доставка за наш счет!</li>
						<li>Есть замечания по сервису? <span>Оставьте свое предложение</span> и оно попадет непосредственно к руководителю региона.</li>
						<li><b><i class="b-ico coin"></i>Принимается оплата наличными</span></b></li>
					</ul>
					<div>
						<div id="addressStep" class="b-delivery-step active">
							<h4>Адрес доставки</h4>
							<div id="del-holder-step1" class="delivery-content-step">
								<table id="del-content-step1" class="sale_order_table props">
									<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["TEMPLATE_LOCATION"],false,"b-go-сhargestep", "del-content-step1", $arParams["DELIVERY_ORDER_PROPS_STEP1_REQ"]);?>
								</table>
								<div class="bt3-wrapper"><a id="b-go-сhargestep" href="#" class="bt3 <?if (!CheckFillFields($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["DELIVERY_ORDER_PROPS_STEP1_REQ"])) echo "disabled"?>" onclick="gochargestep()">Продолжить</a></div>								
							</div>
						</div>
						<div id="chargestep" class="b-delivery-step">
							<h4>Дата и тариф доставки</h4>
							<div id="del-holder-step2" class="delivery-content-step">

							</div>
						</div>
						<div id="personaldatastep" class="b-delivery-step">
							<h4>Личные данные</h4>
							<div class="delivery-content-step">
								<div id="del-holder-step3">

								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div>
		<div id="tab-self-delivery" class="selected">
			<div class="selected">
				<h4>Быстрее - центральный склад</h4>
				<div class="point-self-delivery">				
					<ul>
					<?foreach($arResult["SELF_DELIVERY_PLACES"] as $arItem):?>
						<?if ($arItem["PROPERTY_OUTPOST_VALUE"]=="0"):?>						
							<li>
								<span class="b-point-short" onclick="ShowOrderDeliveryInfo('<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',this,<?=$arItem["ID"]?>);">
									<i class="b-ico-letter">м</i>
									<span class="b-pseudolink"><?=$arItem["PROPERTY_METRO_STATION_VALUE"]?></span>
									<span class = "hidden-xs"><?=$arItem["PROPERTY_ADDRESS_VALUE"]?></span>
								</span>
								<?if($arItem["DELIVERY_TYPE"]=="NOW"):?><span class="hint"><i class="b-ico check"></i><?=$arItem["DELIVERY_DATE_PRINT"]?></span><?endif;?>
								<?if($arItem["DELIVERY_TYPE"]=="DELAY"):?><span class="hint"><i class="b-ico wait"></i>Привезем:<b><?=$arItem["DELIVERY_DATE_PRINT"]?></b></span><?endif;?>								
								<span class="payment-method"><?if($arItem["PROPERTY_PAYMENT_METHOD_CASH_VALUE"]=="1"):?><i class="b-ico coin"></i>наличные<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_CARD_VALUE"]=="1"):?><i class="b-ico card"></i>карта<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_BONUS_VALUE"]=="1"):?><i class="b-ico bonus q-tooltip" data-url="/info/bonus-info"></i>бонус<?endif;?></span>
							</li>
						<?endif?>						
					<?endforeach;?>						
					</ul>				
				</div>
				<h4>Удобнее — пункты выдачи «Элис Пост»</h4>
				<div class="point-self-delivery">
					<ul>
					<?foreach($arResult["SELF_DELIVERY_PLACES"] as $arItem):?>					
						<?if ($arItem["PROPERTY_OUTPOST_VALUE"]=="1"):?>						
							<li>
								<span class="b-point-short" onclick="ShowOrderDeliveryInfo('<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',this,<?=$arItem["ID"]?>);">
									<i class="b-ico-letter">м</i>
									<span class="b-pseudolink"><?=$arItem["PROPERTY_METRO_STATION_VALUE"]?></span>
									<span class="hidden-xs"><?=$arItem["PROPERTY_ADDRESS_VALUE"]?></span>
								</span>
								<?if($arItem["DELIVERY_TYPE"]=="NOW"):?><span class="hint"><i class="b-ico check"></i><?=$arItem["DELIVERY_DATE_PRINT"]?></span><?endif;?>								
								<?if($arItem["DELIVERY_TYPE"]=="DELAY"):?><span class="hint"><i class="b-ico wait"></i>Привезем:<b><?=$arItem["DELIVERY_DATE_PRINT"]?></b></span><?endif;?>
								<span class="payment-method hidden-xs"><?if($arItem["PROPERTY_PAYMENT_METHOD_CASH_VALUE"]=="1"):?><i class="b-ico coin"></i>наличные<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_CARD_VALUE"]=="1"):?><i class="b-ico card"></i>карта<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_BONUS_VALUE"]=="1"):?><i class="b-ico bonus q-tooltip" data-url="/info/bonus-info"></i>бонус<?endif;?></span>
							</li>
						<?endif?>						
					<?endforeach;?>												
					</ul>				
				</div>	
			</div>
		</div>
		<div id="tab-ozon-delivery">
			<h4>Внимание! После получения заказа оператор обязательно свяжется с Вами и сообщит точную стоимость и дату доставки.</h4>			
			<div id="error-holder-ozon"></div>
			<table id="ozon-del-content" class="sale_order_table props">		
				<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["TEMPLATE_LOCATION"],false, "b-go-make-order-self", "self-del-content", $arParams["SELF_DELIVERY_ORDER_PROPS_REQ"]);?>
			</table>
			<div>
				<script>
					var ozon_packages = <? echo json_encode($arResult["PACKAGES"]); ?>
				</script>
				<iframe id="OzonWidget" title="Ozon widget" style="width: 100%; height: 100%; min-width: 320px; min-height: 350px; border: none; overflow: hidden" src="<?="https://rocket.ozon.ru/lk/widget?token=FTK6IoClK8%2FO%2FV7xjiUhxA%3D%3D&hidepostamat=true&showdeliveryprice=false&showdeliverytime=false&fromplaceid=15066285956000&packages".json_encode($arResult["PACKAGES"])?>">Ѕраузер не поддерживает iframe</iframe>
			</div>
		</div>
	</div>
	<div id="holder-summary" class="delivery-content-step">
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");?>		
	</div>
	
	<?
		}
		else
		{
			$APPLICATION->RestartBuffer();
		}
		if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);

			?>
			<script>
				top.BX.scrollToNode(top.BX('ORDER_FORM'));
			</script>
			<?
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");

		if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
			echo $arResult["PREPAY_ADIT_FIELDS"];
		?>
		<?if($_POST["is_ajax_post"] != "Y")
		{
			?>
				</div>
				<input type="hidden" name="confirmorder" id="confirmorder" value="N">
				<input type="hidden" name="profile_change" id="profile_change" value="N">
				<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
				<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arParams["PAY_SYSTEM_ID"]?>">
			</form>
			<?if($arParams["DELIVERY_NO_AJAX"] == "N"):?>
				<script language="JavaScript" src="/bitrix/js/main/cphttprequest.js"></script>
				<script language="JavaScript" src="/bitrix/components/bitrix/sale.ajax.delivery.calculator/templates/.default/proceed.js"></script>
			<?endif;?>
			<?
		}
		else
		{
			?>
			<script>
				top.BX('confirmorder').value = 'Y';
				top.BX('profile_change').value = 'N';
			</script>
			<?
			die();
		}
	}
}
?>
</div>
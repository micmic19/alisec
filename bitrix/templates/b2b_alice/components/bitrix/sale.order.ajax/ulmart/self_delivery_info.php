<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult["SELF_DELIVERY_PLACES"] as $arItem){
    if ($arItem["ID"]==$arResult["OUTPOST_ID"]) break;
}?>
<div class="b-box-i">
	<input type="hidden" ID="<?=$arResult["FIELD_LOCATION"]?>" name="<?=$arResult["FIELD_LOCATION"]?>" value="<?=$arItem["PROPERTY_LOCATION_VALUE"]?>"/>
	<input type="hidden" ID="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>" name="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>" value="<?=$arItem["DELIVERY_DATE_PRINT"]?>"/>
	<?if ($arItem["DELIVERY_TYPE"]=="NOW"):?>
	<div class="_fine">
	<?elseif ($arItem["DELIVERY_TYPE"]=="DELAY"):?>	
		<div class="_good">  
	<?else:?>
		<div class="_bad">  
	<?endif?>
		<h4>
		  <?if ($arItem["DELIVERY_TYPE"]=="NOW"):?>
			Здесь Вы можете забрать заказ уже сегодня.<span class="main-strong"></span>
		  <?elseif ($arItem["DELIVERY_TYPE"]=="DELAY"):?>
				В этом магазине нет в наличии. Можем привезти.<span class="main-strong"><?=$arItem["DELIVERY_DATE_PRINT"]?> после 10:00</span>
		  <?else:?>	
				К сожалению ваш заказ недоступен в этом магазине.
		  <?endif?>
		</h4>
		<span><b>Можно заплатить:<?if($arItem["PROPERTY_PAYMENT_METHOD_CASH_VALUE"]=="1"):?><i class="b-ico coin"></i>наличные<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_CARD_VALUE"]=="1"):?><i class="b-ico card"></i>карта<?endif;?></b></span>
		<p>
			<table id="self-del-content" class="sale_order_table props">		
				<?if (!empty($arItem["DELIVERY_TYPE"])):?>
					<?PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["TEMPLATE_LOCATION"],false, "b-go-make-order-self", "self-del-content", $arParams["SELF_DELIVERY_ORDER_PROPS_REQ"]);?>
				<?else:?>	
					<tr><td>Для отрезного товара требуется дополнительное согласование по телефону: <b><?=$arItem["MAIN_PHONE"]?></b></td></tr>
					<tr><td>Выберите другой магазин или закажите доставку.</td></tr>					
				<?endif?>										
			</table>
			<input type="hidden" name="ORDER_PROP_<?=$arParams["SELF_DELIVERY_ORDER_PROP"]?>" id="ORDER_PROP_<?=$arParams["SELF_DELIVERY_ORDER_PROP"]?>" value="<?=$arResult["OUTPOST_ID"]?>">
		    <?if (!empty($arItem["DELIVERY_TYPE"])):?>			
			  <div class="bt3-wrapper"><a id="b-go-make-order-self" href="#" class="bt3 <?if (!CheckFillFields($arResult["ORDER_PROP"]["USER_PROPS"], $arParams["SELF_DELIVERY_ORDER_PROPS_REQ"])) echo "disabled"?>" onclick="submitForm(this)">Заберу отсюда</a></div>															
		    <?endif?>			
		</p>
	</div>
</div>						
<div class="js-toggle">
	<span class="b-pseudolink"  onclick="ToggleOrderDeliveryInfo();">Схема проезда и режим работы</span>
	<div class="js-toggle-block" id="point">
		<div class="point-self-delivery-info">
			<div class="map"><?echo $arItem["~PROPERTY_YANDEX_PLACE_MAP_VALUE"];?></div>
			<p><strong>Адрес: </strong><?=$arItem["PROPERTY_ADDRESS_VALUE"]?></p>
			<p><strong>Телефон: </strong><?=$arItem["PROPERTY_PHONE_VALUE"]?></p>
			<p><strong>Часы работы: </strong><?=$arItem["PROPERTY_WORK_HOURS_VALUE"]?></p>
			<div style="clear:both;"></div>
		</div>
	</div>
</div>
<div class="b-shadow-box-close" title="Закрыть" onclick="CloseOrderDeliveryInfo();"><span class="i">×</span></div>


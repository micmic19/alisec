<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-detail" itemscope itemtype = "http://schema.org/Product">
	<div class="b-box-i">
		<span><b>Можно заплатить:<?if($arResult["PAYMENT_METHOD_CASH"]["VALUE"]=="1"):?><i class="b-ico coin"></i>наличные<?endif;?><?if($arResult["PAYMENT_METHOD_CARD"]["VALUE"]=="1"):?><i class="b-ico card"></i>карта<?endif;?></b></span>
	</div>						
	<div class="js-toggle">
		<span>Схема проезда и режим работы</span>
		<div class="point-self-delivery-info">
			<div class="hidden-xs"><?=$arResult["YANDEX_PLACE_MAP_INTERACT"]["~VALUE"]?></div>
			<div class="hidden-sm hidden-md hidden-lg"><?=$arResult["YANDEX_PLACE_MAP"]["~VALUE"]?></div>
			<p><strong>Ближайшая станция: </strong><?=$arResult["METRO_STATION"]["VALUE"]?></p>			
			<p><strong>Адрес: </strong><?=$arResult["ADDRESS"]["VALUE"]?></p>
			<p><strong>Телефон: </strong><?=$arResult["PHONE"]["VALUE"]?></p>
			<p><strong>Часы работы: </strong><?=$arResult["WORK_HOURS"]["VALUE"]?></p>
			<div style="clear:both;"></div>
		</div>
	</div>
	<h4>Фотогалерея</h4>
	<?foreach($arResult["MORE_PHOTO"]["VALUE"] as $value):?>
	<img src="<?=$value["SRC"]?>" title="<?=$value["DESCRIPTION"]?>" alt="<?=$value["DESCRIPTION"]?>"></img>
	<?endforeach;?>
</div>
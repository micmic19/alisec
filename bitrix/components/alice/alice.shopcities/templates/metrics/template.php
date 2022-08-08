<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="contactsdata">
	<?if (empty($arResult["UF_SHOP_CITY"])):?>
		<a></a>	
	<?else:?>	
		<?echo $arResult["UF_SHOP_CITY"]["~PROPERTY_YANDEX_METRIKA_VALUE"]["TEXT"];?>
	<?endif?>	
</div>

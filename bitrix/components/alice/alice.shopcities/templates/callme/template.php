<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="contactsdata">
	<?if (empty($arResult["UF_SHOP_CITY"])):?>
		<a class="tel"><b><?=iconv("windows-1251", "utf-8", "");?></b></a>	
	<?else:?>	
		<a href="tel:<?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_VALUE"];?>">
			<?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_VALUE"];?>
		</a>
	<?endif?>	
</div>

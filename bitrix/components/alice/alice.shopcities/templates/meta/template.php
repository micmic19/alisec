<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (empty($arResult["UF_SHOP_CITY"])):?>
	<a></a>	
<?else:?>	
	<?echo $arResult["UF_SHOP_CITY"]["~PROPERTY_GEO_META_TAG_VALUE"];?>
<?endif?>	

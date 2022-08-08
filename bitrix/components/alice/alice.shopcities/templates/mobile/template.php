<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<li class="mobile_header_city_selector">
	<?if (empty($arResult["UF_SHOP_CITY"])):?>
		<a href="#"><?=iconv("windows-1251", "utf-8", "Выберите город");?></a>
	<?else:?>
		<a href="#"><?=$arResult["UF_SHOP_CITY"]["NAME"];?></a>
	<?endif?>
		<ul>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if ($arItem["ID"]!=$arResult["UF_SHOP_CITY"]["ID"]):?>
				<li><a href="" onclick="alicesetcity('<?=$arItem["CODE"]?>')"><?=$arItem["NAME"];?></a></li>
			<?endif?>
		<?endforeach;?>
		</ul>
</li>

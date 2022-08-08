<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="contactsdata">
	<?if (empty($arResult["UF_SHOP_CITY"])):?>
		<a class="tel"><b><?=iconv("windows-1251", "utf-8", "");?></b></a>	
	<?else:?>	
		<a href="/about/contacts/">
			<span class="tel" itemprop="telephone"><?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_VALUE"];?></span>
		</a>
		<span class="workhours"><?=$arResult["UF_SHOP_CITY"]["PROPERTY_SCHEDULE_VALUE"];?></span>
		<?if (!empty($arResult["UF_SHOP_CITY"]["PROPERTY_PHONE1_VALUE"])):?>		
			<span style="font-size: 70%">По вопросам оптовых закупок<br/>обращаться по телефону<br/><?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE1_VALUE"];?></span>		
		<?endif?>			
	<?endif?>	
</div>

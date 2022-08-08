<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table>	
<tr><td>
	<a href="#" class="go-to-top" data-psn-hnd-ga-ym="1" data-container="siteClick;scrollTop"></a>
	<div class="alicelogo">
		<img src="/images/site_logo.gif">
	</div>
	</td><td>
	<div class="sitelogo">
		<?if (is_array($arResult["UF_SHOP_CITY"]["PREVIEW_PICTURE"])):?>
			<img ID="sitelogoimg" src="<?=$arResult["UF_SHOP_CITY"]["PREVIEW_PICTURE"]["SRC"]?>">
		<?endif?>	
	</div>
	</td>
	<td class="contactsdata">
		<div>
		<?if (empty($arResult["UF_SHOP_CITY"])):?>
			<a class="tel"><b><?=iconv("windows-1251", "utf-8", "");?></b></a>	
		<?else:?>	
			<a href="/about/contacts/">
				<span class="tel" itemprop="telephone"><?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_VALUE"];?></span>
			</a>
			<span class="workhours"><?=$arResult["UF_SHOP_CITY"]["~PROPERTY_SCHEDULE_VALUE"]["TEXT"];?></span>
		<?endif?>
		</div>
	</td>
	</tr>
</table>
